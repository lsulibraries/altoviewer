<?php

class METS {

  protected $mets;

  /**
   * Class constructor; initializes mets.
   * 
   * @param string $xml
   *   string contents of a mets file.
   */
  public function __construct($xml) {
    $this->mets = simplexml_load_string($xml);
    $this->mets->registerXPathNamespace('m', 'http://www.loc.gov/METS/');
  }

  /**
   * Generates toc in markup from mets.
   * 
   * @return string
   *   markup for the toc
   */
  public function toc2markup() {
    $markup = "<div id='toc_wrapper'>";
    foreach($this->articles as $id => $title) {
      $toc_id = $id . '_toc';
      $markup .= "<div id='$toc_id'>$title</div>";
    }
    $markup .= "</div>";
    return $markup;
  }

  public function __get($name) {
    if (!property_exists($this, $name)) {
      $fn = "_$name";
      if(method_exists($this, $fn)){
        return $this->$fn();
      }
      throw new Exception("Function $fn does not exist.");
    }
    return $this->$name;
  }

  private function _article_ids() {
    $articles = array();
    foreach($this->mets->xpath("//m:div[@DMDID]") as $div) {
      $id = (string) $div['DMDID'];
      if (strpos($id, 'ARTICLE')) {
        $title = $div['LABEL'];

        $articles[$id]['id'] = $id;
        $articles[$id]['title'] = (string) $title;
      }
    }

    return $articles;
  }
  
  public function get_article_outline($article_id) {
    if (!in_array($article_id, array_keys($this->article_ids))) {
      throw new Exception("article id $article_id does not exist.");
    }
    $article_layout = $this->mets->xpath("//m:div[@DMDID='$article_id']")[0];
    $article_layout->registerXPathNamespace('m', 'http://www.loc.gov/METS/');

    $title = $article_layout->xpath("m:div[@TYPE='HEADING']/m:div[@TYPE='TITLE']//m:area");
    $author = $article_layout->xpath("m:div[@TYPE='HEADING']/m:div[@TYPE='AUTHOR']//m:area");
    $areas = $article_layout->xpath("m:div[@TYPE='BODY']//m:area");

    $outline = array(
      'heading' => array(
        'title'  => array(
          'fileid' => array_key_exists(0, $title) ? (string) $title[0]['FILEID'] : false,
          'textblock' => array_key_exists(0, $title) ? (string) $title[0]['BEGIN'] : false,
        ),
        'author' => array(
          'fileid' => array_key_exists(0, $author) ? (string) $author[0]['FILEID'] : false,
          'textblock' => array_key_exists(0, $author) ? (string)$author[0]['BEGIN'] : false,
        ),
      ),
      'body' => array(),
    );
    foreach ($areas as $area) {
      $fileid = (string) $area['FILEID'];
      if (!in_array($fileid, array_keys($outline['body']))) {
        $outline['body'][$fileid] = array();
      }
      $outline['body'][$fileid][] = (string)$area['BEGIN'];
    }
    return $outline;
  }
  
  public function get_article_markup($article_id, $format = 'text') {
    $div_id = 0;
    $format = $format == 'text' ? $format : 'highlight';
    $getter = "get_alto_textblock_$format";

    $outline = $this->get_article_outline($article_id);

    $title  = $this->$getter($outline['heading']['title']['fileid'], $outline['heading']['title']['textblock']);
    $author = $this->$getter($outline['heading']['author']['fileid'], $outline['heading']['author']['textblock']);

    $text  = "<div id='$article_id' class='article'>";
    $text .= "<div class='article-title'>$title</div>";
    $text .= "<div class='article-author'>$author</div>";

    foreach ($outline['body'] as $alto_file_id => $text_block_ids) {
      foreach ($text_block_ids as $text_block_id) {
        $text .= sprintf("<div id='$article_id~$div_id' class='article-text-block'>%s</div>", $this->$getter($alto_file_id, $text_block_id));
        $div_id++;
      }
    }
    return $text . "</div>";
  }

  public function get_alto_textblock_highlight($alto_id, $tb_id) {
    if (!$alto_id || !$tb_id) {
      return '';
    }
    preg_match('/P\d+_TB(\d+)$/', $tb_id, $matches);
    $alto = $this->get_alto($alto_id);
    $query = sprintf("//TextBlock[@ID='%s']", $tb_id);
    $tblock = $alto->xpath($query)[0];
    $highlight = sprintf("<div class='highlighter highlight-block'  style=\"
      left: %spx; 
      top: %spx; 
      width: %spx; 
      height: %spx;\"></div>",
        ceil($tblock['HPOS'] * 0.5),
        ceil($tblock['VPOS'] * 0.5),
        floor($tblock['WIDTH'] * 0.5),
        floor($tblock['HEIGHT'] * 0.5)
        );
    return $highlight;
  }
  
  public function get_alto_textblock_text($alto_id, $tb_id) {
    if (!$alto_id || !$tb_id) {
      return '';
    }
    preg_match('/P\d+_TB(\d+)$/', $tb_id, $matches);
    $alto = $this->get_alto($alto_id);
    $query = sprintf("//TextBlock[@ID='%s']/TextLine", $tb_id);
    $lines = $alto->xpath($query);
    $text = '';
    $span = "<%s class='highlighter highlight-%s'  style=\"
      left: %spx; 
      top: %spx; 
      width: %spx; 
      %s\">";
    foreach ($lines as $line) {
      $text .= sprintf($span,
          'span',
          'line',
          ceil($line['HPOS'] * 0.5),
          ceil($line['VPOS'] * 0.5),
          floor($line['WIDTH'] * 0.5),
          isset($line['HEIGHT']) ? "height: " . floor($line['HEIGHT'] * 0.5) . 'px;' : ''
        );
      foreach($line->xpath('*') as $elem) {

        $name = $elem->getName();
        if($name == 'HYP') {
          $text .= '-';
        }elseif($name == 'SP') {
          $text .= ' ';
        }
        else{
          $text .= $elem['CONTENT'];
        }
      }
      $text .= "</span>";
    }
    return $text;
  }
  
  private function get_alto($fileid) {
    $pattern = "/vagrant/content/LMNP01/19231115/19231115-%s.xml";
    return simplexml_load_file(sprintf($pattern, $fileid));
  }
  
  private function get_text_block($id) {
    preg_match('/P\d+_TB(\d+)$/', $id, $matches);
    var_dump($matches);
    $xpath = sprintf("//TextBlock[@ID='%s']", $area['BEGIN']);
  }
}
