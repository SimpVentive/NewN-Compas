<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once("dompdf/autoload.inc.php");
use Dompdf\Dompdf;
use Dompdf\Options;

class Pdfgenerator {

  public function generate($html, $filename='', $stream=TRUE, $paper = 'A4', $orientation = "portrait",$type='')
  {
	$options = new Options();
	$options->set('isRemoteEnabled', TRUE);
    $dompdf = new DOMPDF($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper($paper, $orientation);
    $dompdf->render();
    if ($stream) {
        $dompdf->stream($filename.".pdf", array("Attachment" => 0));
		if(!empty($type)){
			$output=$dompdf->output();
			file_put_contents("public/uploads/$type/".$filename.".pdf", $output);
		}
    } else {
        $output=$dompdf->output();
		file_put_contents("public/uploads/$type/".$filename.".pdf", $output);
    }
  }
}