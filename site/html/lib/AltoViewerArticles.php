<?php

require_once 'AltoViewer.php';
require_once 'AltoViewerRenderer.php';

class AltoViewerArticles extends AltoViewer {

  public function __construct($config, $fileId, $vScale, $hScale) {
    parent::__construct($config['altoDir'], $config['imageDir'], $fileId, $vScale, $hScale);

    $textBlocks = $this->getTextBlocks();
    $imageSize = $this->imageSize;
    $imageName = $this->imageName;
    $scaledHeight = $imageSize[1] * $vScale;
    $scaledWidth = $imageSize[0] * $hScale;
    $template_path = 'theme/articles.tpl.php';
    $vars = compact(
        "vScale",
        "hScale",
        "image",
        "altoViewer",
        "imageSize",
        "imageName",
        "textBlocks",
        "scaledHeight",
        "scaledWidth"
    );
    $this->renderer = new AltoViewerRenderer($template_path, $vars);
  }
}