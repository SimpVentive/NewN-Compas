<?php
require_once 'includes/SVGGraph.php';
$width = 500;
$height = 400;
$settings = array(
  'back_colour' => '#ffffff',  'stroke_colour' => '#ffffff',
  'back_stroke_width' => 2, 'back_stroke_colour' => '#ffffff',
  'axis_colour' => '#999',  'axis_overlap' => 1,
  'axis_min_v' => 2, 'axis_max_v' => 17,
  'grid_division_v' => 3,
  'graph_title' => 'Start of Fibonacci series'
);
 
$graph2 = new SVGGraph($width, $height, $settings);
$graph2->Values(5, 5, 5, 3, 3, 5, 8, 13, 15);
$graph2->Render('BarGraph',true);
?>