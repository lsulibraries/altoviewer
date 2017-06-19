<?php

class METS {

  protected $mets;

  /**
   * Class constructor; initializes mets.
   * 
   * @param string $doc
   *   string contents of a mets file.
   */
  public function __construct($doc) {
    $this->mets = new DOMDocument();
    $this->mets->loadXML($doc);
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
      return $this->$fn();
    }
    return $this->$name;
  }

  private function _articles() {
    $xpath = new DOMXPath($this->mets);
    $query = "//@DMDID";
    $elems = $xpath->evaluate($query);

    $title_query = "//m:div[@DMDID='%s']/@LABEL";
    $articles = array();
    $xpath->registerNamespace('m', 'http://www.loc.gov/METS/');
    foreach($elems as $elem) {
      $key = $elem->value;
      if (strpos($key, 'ARTICLE')) {
        $local_query = sprintf($title_query, $key);

        $labels = $xpath->evaluate($local_query);
        $title = $labels->item(0)->value;
        $articles[$key] = $title;
      }
    }

    return $articles;
  }
  
  public function article_pages($article_id) {
    if (!in_array(array_keys($this->articles)) {
      throw new Exception("article id $article_id does not exist.");
    }
  }
}
