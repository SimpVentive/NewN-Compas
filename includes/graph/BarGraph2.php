<?php
require_once 'includes/SVGGraph.php';
/* $width = 500;
$height = 400;
$settings = array(
  'back_colour' => 'white',
  'graph_title' => 'Start of Fibonacci series'
);
 
$graph2 = new SVGGraph($width, $height, $settings);
$graph2->Values(0, 1, 1, 2, 3, 5, 8, 13, 21,100,-100);
$graph2->Render('BarGraph',true); */


$settings = array('graph_title'=>'Program Feedback','show_legend'=>'true','graph_title_font_size'=>24,
  'back_colour' => '#ffffff',  'stroke_colour' => '#ffffff',
  'back_stroke_width' => 1, 'back_stroke_colour' => '#ffffff',
  'axis_colour' => '#000',  'axis_overlap' => 0,
  'axis_font' => 'Georgia', 'axis_font_size' => 10,
  'grid_colour' => '#ccc',  'label_colour' => '#000',
  'pad_right' => 20,        'pad_left' => 20,
  'link_base' => '/',       'link_target' => '_top',  
  'minimum_grid_spacing' => 20, 'show_bar_labels'=>'true',
  'bar_label_position' =>'above', 'axis_min_v' => 4.5,
  'axis_max_v' => 5,'grid_division_v' => 0.1
);
 
$values = array(
 array('Overall satisfaction with the program' => 4.8, 'Learning experienced' => 4.7, 'Practical application of learning' => 4.7, 'Methods adopted' => 4.7)
);
 
$colours = array(array('#008cea','#36a2eb'));
//$links = array('Dough' => 'jpegsaver.php', 'Ray' => 'crcdropper.php',  'Me' => 'svggraph.php');
 
$graph = new SVGGraph(600, 300, $settings);
$graph->colours = $colours;
 
$graph->Values($values);
$graph->Links($links);
$graph->Render('BarGraph');
?>