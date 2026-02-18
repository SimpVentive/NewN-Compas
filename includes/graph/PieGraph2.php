<?php
header('content-type: application/xhtml+xml; charset=UTF-8');
require_once 'includes/SVGGraph.php';

$settings = array(
  'back_colour' => '#fff',   'stroke_colour' => '#fff',
  'back_stroke_width' => 0,  'back_stroke_colour' => '#eee',
  'pad_right' => 20,         'pad_left' => 20,
  'link_base' => '/',        'link_target' => '_top',
  'show_labels' => true,     'show_label_amount' => true,
  'label_font' => 'Georgia', 'label_font_size' => '11',
  'label_colour' => '#000',  'units_before_label' => '',
  'sort' => false
);

$values = array('Dough' => 30, 'Ray' => 50, 'Me' => 40, 'So' => 25, 'Far' => 45, 'Lard' => 35,'Doughh' => 30, 'Rayy' => 50, 'Mee' => 40,'Soo' => 25, 'Farr' => 45, 'Lardd' => 35);
$colours = array('#FF9F40','#FFCD56','#4BC0C0','#36A2EB','#9966FF','#C9CBCF','#FF6384','#ff830f','#ffb711','#1abfbf','#1595ea','#7028ff','#aeb0b2','#ff2b55');
$links = array('Dough' => 'jpegsaver.php', 'Ray' => 'crcdropper.php', 'Me' => 'svggraph.php');
 
$graph = new SVGGraph(350, 350, $settings);
$graph->colours = $colours;
 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1 plus MathML 2.0 plus SVG 1.1//EN"
  "http://www.w3.org/2002/04/xhtml-math-svg/xhtml-math-svg.dtd">
 <html xmlns="http://www.w3.org/1999/xhtml"
  xmlns:svg="http://www.w3.org/2000/svg"
  xmlns:xlink="http://www.w3.org/1999/xlink" xml:lang="en">
 <head>
  <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8" />
  <title>SVGGraph example</title>
 </head>
 <body>
  <h1>Example of SVG in XHTML</h1>
  <div style="float:left; width:25%">
<?php

$graph->Values($values);
//PieGraph,Pie3DGraph,DonutGraph,SemiDonutGraph,PolarAreaGraph,PolarArea3DGraph,ExplodedPieGraph,ExplodedPie3DGraph
echo $graph->Fetch('PieGraph', false); 
?>
  </div>
  <div style="float:left; width:25%">
<?php
$graph->Values($values);
//PieGraph,Pie3DGraph,DonutGraph,SemiDonutGraph,PolarAreaGraph,PolarArea3DGraph,ExplodedPieGraph,ExplodedPie3DGraph
echo $graph->Fetch('Pie3DGraph', false); 
?>
  </div>
  <div style="float:left; width:25%">
<?php
$graph->Values($values);
//PieGraph,Pie3DGraph,DonutGraph,SemiDonutGraph,PolarAreaGraph,PolarArea3DGraph,ExplodedPieGraph,ExplodedPie3DGraph
echo $graph->Fetch('DonutGraph', false); 
?>
  </div>
  <div style="float:left; width:25%">
<?php
$graph->Values($values);
//PieGraph,Pie3DGraph,DonutGraph,SemiDonutGraph,PolarAreaGraph,PolarArea3DGraph,ExplodedPieGraph,ExplodedPie3DGraph
echo $graph->Fetch('SemiDonutGraph', false); 
?>
  </div> 
    <div style="float:left; width:25%">
<?php
$graph->Values($values);
//PieGraph,Pie3DGraph,DonutGraph,SemiDonutGraph,PolarAreaGraph,PolarArea3DGraph,ExplodedPieGraph,ExplodedPie3DGraph
echo $graph->Fetch('PolarAreaGraph', false); 
?>
  </div>
    <div style="float:left; width:25%">
<?php
$graph->Values($values);
//PieGraph,Pie3DGraph,DonutGraph,SemiDonutGraph,PolarAreaGraph,PolarArea3DGraph,ExplodedPieGraph,ExplodedPie3DGraph
echo $graph->Fetch('PolarArea3DGraph', false); 
?>
  </div>
	<div style="float:left; width:25%">
<?php
$graph->Values($values);
//PieGraph,Pie3DGraph,DonutGraph,SemiDonutGraph,PolarAreaGraph,PolarArea3DGraph,ExplodedPieGraph,ExplodedPie3DGraph
echo $graph->Fetch('ExplodedPieGraph', false); 
?>
  </div>
	<div style="float:left; width:25%">
<?php
$graph->Values($values);
//PieGraph,Pie3DGraph,DonutGraph,SemiDonutGraph,PolarAreaGraph,PolarArea3DGraph,ExplodedPieGraph,ExplodedPie3DGraph
echo $graph->Fetch('ExplodedPie3DGraph', false); 
?>
  </div>
<?php
echo $graph->FetchJavascript();
?>

 </body>
 </html>