<?php
header('content-type: application/xhtml+xml; charset=UTF-8');
require_once 'includes/SVGGraph.php';
$graph = new SVGGraph(400, 300, array('namespace' => true));
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
  <div>
<?php

$graph->Values(10, 14, 6, 3, 20, 14, 16,10, 14, 6, 3, 20, 14, 16,10, 14, 6, 3, 20, 14, 16);
echo $graph->Fetch('BarGraph', false);
?>
  </div>
  <div>
<?php
$graph->Values(8, 15, 14, 19, 12, 15, 13);
echo $graph->Fetch('BarGraph', false);
?>
  </div>

<?php
echo $graph->FetchJavascript();
?>

 </body>
 </html>