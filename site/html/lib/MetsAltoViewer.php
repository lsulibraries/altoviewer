<?php

class MetsAltoViewer {
  protected $mets;
  protected $altos = array();
  protected $image_paths = array();

  public function __construct($mets_path, $alto_paths, $image_paths) {
    $this->mets = simplexml_load_file($mets_path);
    foreach($alto_paths as $path) {
      $this->altos[] = simplexml_load_file($path);
    }
    $this->image_paths = $image_paths;
  }
}