<?php

require_once 'lib/AltoViewerArticles.php';


$vScale = $_REQUEST['vScale'];
$hScale = $_REQUEST['hScale'];
$image = $_REQUEST['image'];
$config = parse_ini_file('./config/altoview.ini');

$viewer = new AltoViewerArticles($config, $image, $vScale, $hScale);
$viewer->renderer->render();
