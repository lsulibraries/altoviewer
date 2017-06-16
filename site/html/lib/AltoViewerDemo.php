<?php

require_once 'AltoViewer.php';
require_once 'AltoViewerRenderer.php';

class AltoViewerDemo extends AltoViewer {

  public function __construct($config, $fileId, $vScale, $hScale) {
    parent::__construct($config['altoDir'], $config['imageDir'], $fileId, $vScale, $hScale);

    $strings = $this->getStrings();
    $textLines = $this->getTextLines();
    $textBlocks = $this->getTextBlocks();
    $printSpace = $this->getPrintSpace();
    $imageSize = $this->imageSize;
    $imageName = $this->imageName;
    $scaledHeight = $imageSize[1] * $vScale;
    $scaledWidth = $imageSize[0] * $hScale;
    $template_path = 'theme/default.tpl.php';
    $vars = compact(
        "vScale",
        "hScale",
        "image",
        "altoViewer",
        "imageSize",
        "imageName",
        "strings",
        "textLines",
        "textBlocks",
        "printSpace",
        "scaledHeight",
        "scaledWidth"
    );
    $this->renderer = new AltoViewerRenderer($template_path, $vars);
  }
}