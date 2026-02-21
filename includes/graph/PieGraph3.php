<?php
ini_set('display_errors',1);
require_once('includes/SVGGraph.php');
 
$settings = array('graph_title'=>'The Pace to the Program','show_legend'=>'true','graph_title_font_size'=>24,
  'back_colour' => '#fff',   'stroke_colour' => '#fff',
  'back_stroke_width' => 0,  'back_stroke_colour' => '#eee',
  'pad_right' => 20,         'pad_left' => 20,
  'link_base' => '/',        'link_target' => '_top',
  'show_labels' => true,     'show_label_amount' => true,
  'label_font' => 'Georgia', 'label_font_size' => '11',
  'label_colour' => '#000',  'units_before_label' => '',
  'sort' => false
);


//$values = array('Dough' => 30, 'Ray' => 50, 'Me' => 40, 'So' => 25, 'Far' => 45, 'Lard' => 35,'Doughh' => 30, 'Rayy' => 50, 'Mee' => 40,'Soo' => 25, 'Farr' => 45, 'Lardd' => 35);
$values = array('Evenly paced'=>90,'Too Slow'=>5,'Too Fast'=>0,'Not responded'=>5);
$colours = array('#FF9F40','#FFCD56','#4BC0C0','#36A2EB','#9966FF','#C9CBCF','#FF6384','#ff830f','#ffb711','#1abfbf','#1595ea','#7028ff','#aeb0b2','#ff2b55');
//$links = array('Dough' => 'jpegsaver.php', 'Ray' => 'crcdropper.php', 'Me' => 'svggraph.php');
 
$graph = new SVGGraph(300, 300, $settings);
$graph->colours = $colours;
 
$graph->Values($values);
//$graph->Links($links);
//PieGraph,Pie3DGraph,DonutGraph,SemiDonutGraph,PolarAreaGraph,PolarArea3DGraph,ExplodedPieGraph,ExplodedPie3DGraph
$graph->Render('PieGraph'); 


/* $settings = array(
  'structure' => array('key' => 0,'value' => 1,'explode' => 0),
  'back_colour' => '#eee',   'stroke_colour' => '#000',
  'back_stroke_width' => 0,  'back_stroke_colour' => '#eee',
  'explode' => 'none',     'explode_amount' => 0,
  'label_font_size' => 10, 'label_back_colour' => '#333',
  'pad_right' => 20,         'pad_left' => 20,
  'link_base' => '/',        'link_target' => '_top',
  'show_labels' => true,     'show_label_amount' => true,
  'label_colour' => '#000',  'units_before_label' => '$',
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
$graph->Render('DonutGraph'); */