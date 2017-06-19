<?php

require_once 'lib/AltoViewerArticles.php';
require_once 'lib/METS.php';

$vScale = $_REQUEST['vScale'];
$hScale = $_REQUEST['hScale'];
$image = $_REQUEST['image'];
$config = parse_ini_file('./config/altoview.ini');

$mets = new METS(file_get_contents('/vagrant/content/LMNP01/19231115/19231115-METS.xml'));
echo $mets->toc2markup();
$viewer = new AltoViewerArticles($config, $image, $vScale, $hScale);
$viewer->renderer->render();
