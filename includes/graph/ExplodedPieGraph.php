<?php
require_once('includes/SVGGraph.php');
 
$settings = array(
  'structure' => array(
    'key' => 0,
    'value' => 1,
    'explode' => 2,
  ),
  'explode' => 'none',     'explode_amount' => 50,
  'label_font_size' => 10, 'label_back_colour' => '#333',
  'sort' => false
);
 
$values = array(
  array('Tea', 10),
  array('Coffee', 20, 1.0),
  array('Milk', 25, 0.5),
  array('Water', 50),
);
 
$colours = array('#e97','#630','#edd', array('#6bf','pattern' => 'polkadot2'));
 
$graph = new SVGGraph(500, 500, $settings);
$graph->Colours($colours);
$graph->Values($values);
$graph->Render('ExplodedPieGraph');