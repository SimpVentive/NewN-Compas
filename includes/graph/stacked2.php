<?php
require_once('includes/SVGGraph.php');
 
$settings = array('graph_title'=>'Program Feedback','show_legend'=>'true','graph_title_font_size'=>24,
  'back_colour' => '#ffffff',  'stroke_colour' => '#ffffff',
  'back_stroke_width' => 1, 'back_stroke_colour' => '#ffffff',
  'axis_colour' => '#000',  'axis_overlap' => 0,
  'axis_font' => 'Georgia', 'axis_font_size' => 10,
  'grid_colour' => '#ccc',  'label_colour' => '#000',
  'pad_right' => 20,        'pad_left' => 20,
  'link_base' => '/',       'link_target' => '_top',  
  'minimum_grid_spacing' => 20, 'show_bar_labels'=>'true',
  'bar_label_position' =>'above'
);



$values = array(
 array('Overall satisfaction with the program' => 81, 'Learning experienced' => 19, 'Practical application of learning' => 0, 'Methods adopted' => 0),
 array('Overall satisfaction with the program' => 71, 'Learning experienced' => 29, 'Practical application of learning' => 0, 'Methods adopted' => 0),
 array('Overall satisfaction with the program' => 67, 'Learning experienced' => 33, 'Practical application of learning' => 0, 'Methods adopted' => 0),
 array('Overall satisfaction with the program' => 71, 'Learning experienced' => 29, 'Practical application of learning' => 0, 'Methods adopted' => 0)
);
 
//$colours = array(array('red','yellow'), array('blue','white'));

 
$graph = new SVGGraph(800, 400, $settings);
$graph->colours = $colours;
 
$graph->Values($values);
$graph->Links($links);
$graph->Render('GroupedBarGraph');