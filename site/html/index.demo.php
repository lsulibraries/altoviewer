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

require_once 'lib/AltoViewerDemo.php';


$vScale = $_REQUEST['vScale'];
$hScale = $_REQUEST['hScale'];
$image = $_REQUEST['image'];
$config = parse_ini_file('./config/altoview.ini');

$viewer = new AltoViewerDemo($config, $image, $vScale, $hScale);
$viewer->renderer->render();
