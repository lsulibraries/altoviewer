<?php

/**
 * Following the example set here:
 * https://www.smashingmagazine.com/2011/10/getting-started-with-php-templating/
 */
class AltoViewerRenderer {

  protected $template_path;

  public function __construct($template_path, $vars = array()) {
    $this->template_path = $template_path;
    $this->vars = $vars;
  }
  public function _set($name, $value) {
    $this->$name = $value;
  }
  public function _get($name) {
    return $this->$name;
  }
  public function render() {
    foreach ($this->vars as $name => $value) {
      $$name = $value;
    }
    if(file_exists($this->template_path)) {
      include $this->template_path;
    }
    else {
      throw new Exception("File not found at $this->template_path");
    }
  }
}
