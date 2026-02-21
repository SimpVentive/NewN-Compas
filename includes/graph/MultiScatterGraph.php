<?php
require_once('includes/SVGGraph.php');
 
$settings = array(
  'back_colour'       => '#eee',    'stroke_colour'      => '#000',
  'back_stroke_width' => 0,         'back_stroke_colour' => '#eee',
  'axis_colour'       => '#333',    'axis_overlap'       => 2,
  'axis_font'         => 'Georgia', 'axis_font_size'     => 10,
  'grid_colour'       => '#666',    'label_colour'       => '#000',
  'pad_right'         => 20,        'pad_left'           => 20,
  'marker_colour'     => array('red', 'blue', 'green', 'orange'),
  'marker_type'       => array('square', 'triangle', 'x', 'cross'),
  'marker_size'       => array(2, 3, 4, 3),
  'scatter_2d'        => true,
  'best_fit'          => 'straight', 'best_fit_dash'     => '2,2',
  'best_fit_colour'   => array('red', 'blue', 'green', 'orange'),
);
 
$graph = new SVGGraph(300, 200, $settings);
$values = array(
  array(1,20), array(1,50), array(3,40), array(4,30),
  array(5,60), array(7,80), array(7,40), array(9,70)
);
$graph->Values($values);
$graph->Render('MultiScatterGraph');
?>