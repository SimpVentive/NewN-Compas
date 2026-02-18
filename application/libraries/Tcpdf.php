<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once ('tcpdf/tcpdf.php');

class Pdf extends TCPDF

{
	function __construct()

    {

        parent::__construct();

    }
	
	public function generate()
	{
		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetTitle('Pdf Example');
		$pdf->SetHeaderMargin(30);
		$pdf->SetTopMargin(20);
		$pdf->setFooterMargin(20);
		$pdf->SetAutoPageBreak(true);
		$pdf->SetAuthor('Author');
		$pdf->SetDisplayMode('real', 'default');
		$pdf->Write(5, 'CodeIgniter TCPDF Integration');
	}

}

/*Author:Tutsway.com */  

/* End of file Pdf.php */

/* Location: ./application/libraries/Pdf.php */

?>