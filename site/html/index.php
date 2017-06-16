<?php

/**
 * ALTO File Viewer
 *
 * @package    AltoViewer
 * @author     Dan Field <dof@llgc.org.uk>
 * @copyright  Copyright (c) 2010 National Library of Wales / Llyfrgell Genedlaethol Cymru. 
 * @link       http://www.llgc.org.uk
 * @license    http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License 3
 * @version    $Id$
 * @link       http://www.loc.gov/standards/alto/
 * 
 **/

/**
 * Following the example set here:
 * https://www.smashingmagazine.com/2011/10/getting-started-with-php-templating/
 */
class AltoView {

  protected $template_path;

  public function __construct($vars = array()) {
    foreach ($vars as $name => $value) {
      $this->$name = $value;
    }
  }
  public function _set($name, $value) {
    $this->$name = $value;
  }
  public function _get($name) {
    return $this->$name;
  }
  public function render() {
    if(file_exists($this->template_path)) {
      include $this->template_path;
    }
    else {
      throw new Exception("File not found at $this->template_path");
    }
  }
}

require_once 'lib/AltoViewer.php';
 
$vScale = $_REQUEST['vScale'];
$hScale = $_REQUEST['hScale'];
$image = $_REQUEST['image'];

$config = parse_ini_file('./config/altoview.ini');

$altoViewer = new AltoViewer(   $config['altoDir'], 
                                $config['imageDir'], 
                                $image, $vScale, $hScale);
$imageSize = $altoViewer->getImageSize();
$imageName = $altoViewer->getImageName();
$strings = $altoViewer->getStrings();
$textLines = $altoViewer->getTextLines();
$textBlocks = $altoViewer->getTextBlocks();
$printSpace = $altoViewer->getPrintSpace();

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
    "scaledWidth",
    "template_path"
);
$view = new AltoView($vars);
$view->render();
