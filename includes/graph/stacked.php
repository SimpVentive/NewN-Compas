<?php
require_once('includes/SVGGraph.php');
 
$settings = array('graph_title'=>'Facilitator Feedback','show_legend'=>'true','graph_title_font_size'=>24,
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
 array('Rapport developed with participants' => 62, 'Explanation of concepts' => 33, 'Facilitation of exercises/ activities' => 5, 'Participant involvement' => 0, 'Was interesting & held my attention' => 0),
 array('Rapport developed with participants' => 71, 'Explanation of concepts' => 24, 'Facilitation of exercises/ activities' => 0, 'Participant involvement' => 0, 'Was interesting & held my attention' => 0),
 array('Rapport developed with participants' => 52, 'Explanation of concepts' => 48, 'Facilitation of exercises/ activities' => 0, 'Participant involvement' => 0, 'Was interesting & held my attention' => 0),
 array('Rapport developed with participants' => 65, 'Explanation of concepts' => 35, 'Facilitation of exercises/ activities' => 0, 'Participant involvement' => 0, 'Was interesting & held my attention' => 0),
 array('Rapport developed with participants' => 67, 'Explanation of concepts' => 33, 'Facilitation of exercises/ activities' => 0, 'Participant involvement' => 0, 'Was interesting & held my attention' => 0)
);
 
//$colours = array(array('red','yellow'), array('blue','white'));

 
$graph = new SVGGraph(800, 400, $settings);
$graph->colours = $colours;
 
$graph->Values($values);
$graph->Links($links);
$graph->Render('GroupedBarGraph');