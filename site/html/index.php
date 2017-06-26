<?php

require_once 'lib/AltoViewerArticles.php';
require_once 'lib/METS.php';
require_once 'lib/MetsAltoViewer.php';

$vScale = $_REQUEST['vScale'];
$hScale = $_REQUEST['hScale'];
$image  = $_REQUEST['image'];
$format = $_REQUEST['format'];
$article_id = 'MODSMD_ARTICLE' . $_REQUEST['article'];

$config = parse_ini_file('./config/altoview.ini');

$mets_path = '/vagrant/content/LMNP01/19231115/19231115-METS.xml';

$tmp = simplexml_load_file($mets_path);
$tmp->registerXPathNamespace('m', 'http://www.loc.gov/METS/');
$files = $tmp->xpath("//m:fileGrp[@ID='ALTOGRP']/m:file/m:FLocat[1]/@*[namespace-uri()='http://www.w3.org/TR/xlink' and local-name()='href']");

array_walk($files, function($value, $key){
  $value['href'] = str_replace('file://./', '/vagrant/content/LMNP01/19231115/', $value['href']);
});

$img_paths = $tmp->xpath("//m:fileGrp[@ID='IMGGRP']/m:file/m:FLocat[1]/@*[namespace-uri()='http://www.w3.org/TR/xlink' and local-name()='href']");
array_walk($img_paths, function($value, $key){
  $value['href'] = str_replace('file://./', '/vagrant/content/LMNP01/19231115/', $value['href']);
});

$mets = new METS(file_get_contents($mets_path));

//$content = sprintf($mets->get_article_text($article_id));
$content = sprintf($mets->get_article_markup($article_id, $format));
if ($format == 'highlight') {
  $viewer = new AltoViewerArticles($config, $image, $vScale, $hScale, $content);
  $viewer->renderer->render();
}
else {
  print($content);
}
