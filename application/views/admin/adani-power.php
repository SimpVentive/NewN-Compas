<?php
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	//Page header
	public function Header() {
		// get the current page break margin
		$bMargin = $this->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $this->AutoPageBreak;
		// disable auto-page-break
		$this->SetAutoPageBreak(false, 0);
		// set bacground image
		$img_file = K_PATH_IMAGES.'feedbackcover.jpg';
		$this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
		//$this->ImageSVG($file='images/360degree/c-complete-front.svg', $x=0, $y=0, $w=210, $h=297, $link='', $align='', $palign='', $border=0, $fitonpage=false);
		// restore auto-page-break status
		$this->SetAutoPageBreak($auto_page_break, $bMargin);
		// set the starting point for the page content
		$this->setPageMark();
	}
	
	public function Footer() {
		if ($this->tocpage) {
			// *** replace the following parent::Footer() with your code for TOC page
			parent::Footer();
		} else {
			// *** replace the following parent::Footer() with your code for normal pages
			parent::Footer();
		}
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Srikanth Math');
$pdf->SetTitle('Assessment Booklet');
$pdf->SetSubject('Assessment Booklet');
$pdf->SetKeywords('Assessment Booklet');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 040', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));


// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(10, 10, 10);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);


// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('rockwell', '', 10);

// add a page
$pdf->AddPage();
$pdf->SetFooterMargin(0);
// Print a text
$html = <<<EOD
<table cellspacing="0" width="100%" cellpadding="5" border="0" >
	<tr>
		<td width="100%" height="520pt" colspan="3">&nbsp;</td>
	</tr>
    <tr>
        <td width="2%">&nbsp;</td>
		<td width="96%"><span style="font-family: rockwell;font-size: 30pt;color:#f0f0f0; width:70%">Training Program Title</span></td>
		<td width="2%">&nbsp;</td>
	</tr>
</table>
EOD;
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->setPrintHeader(false);

$names=array("Srikanth Math","Balaji Singaraju","Rathna K","Anil Nampelly");
foreach($names as $name){
// add a page
$pdf->AddPage("L");
// -- set new background ---
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
//$pdf->Bookmark('1. Training Program Feedback', 0, 0, '', '', array(0,0,0));
// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(false, 0);
// set bacground image
//$img_file = K_PATH_IMAGES.'cms/bar.jpg';
//$pdf->Image($img_file, 0, 0, 8.8, 297, '', '', '', false, 300, '', false, false, 0);
// restore auto-page-break status
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();
$image=BASE_URL."/public/images/radar2.svg";
$tbl = <<<EOD
<table cellspacing="0" cellpadding="5" border="0" >
    <tr>
        <td colspan="2" width="100%" ><span align="left" style="font-family: rockwell;font-size: 20pt;color:#36a2eb; float:right">Assessment Findings</span></td>
    </tr>
</table>
<table cellspacing="0" cellpadding="5" style="border:1px solid #36a2eb;">
<tr bgcolor="#f1f1f1">
<td>Name:<br><b>$name</b></td>
<td>Designation:<br><b>Srikanth Math</b></td>
<td>Grade:<br><b>Srikanth Math</b></td>
<td>Department:<br><b>Srikanth Math</b></td>
<td>Location:<br><b>Srikanth Math</b></td>
</tr>
</table><br>&nbsp;<br><br>
<table cellspacing="0" cellpadding="5" border="0" >
<tr>
<td align="center" colspan="2"><b>Behavioral Assessment (SHL)</b></td>
<td align="center" colspan="2"><b>Technical Assessment (UniTol)</b></td>
<td rowspan="2">asda</td>
</tr>
<tr>
<td align="center" colspan="2"><img src="$image" width="350px"></td>
<td align="center" colspan="2"><img src="$image" width="350px"></td>
</tr>
<tr>
<td align="left" colspan="2"><span style="font-family: rockwell;font-size: 8pt;color:#000000;width:100%"><b>Development Roadmap</b><br>For the purpose of holistic development of the individual, it is recommended <br>- He may be put on job rotation/ deputation in the other interfaces of the plant.<br>- In-depth training may be imparted on Billing, metering and safety</span>
</td>
<td align="left" colspan="3"><span style="font-family: rockwell;font-size: 8pt;color:#000000;width:100%"><b>Overall Ratings & Recommendations</b><br></span></td>
</tr>
</table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
}


// add a new page for TOC
$pdf->addTOCPage();

// write the TOC title and/or other elements on the TOC page
$pdf->SetFont('times', 'B', 16);
$pdf->MultiCell(0, 0, 'Table Of Content', 0, 'C', 0, 1, '', '', true, 0);
$pdf->Ln();
$pdf->SetFont('rockwell', '', 10);
// disable auto-page-break
$pdf->SetAutoPageBreak(false, 0);
// set bacground image
//$img_file = K_PATH_IMAGES.'cms/bar.jpg';
//$pdf->Image($img_file, 0, 0, 8.8, 297, '', '', '', false, 300, '', false, false, 0);
// define styles for various bookmark levels
$bookmark_templates = array();

/*
 * The key of the $bookmark_templates array represent the bookmark level (from 0 to n).
 * The following templates will be replaced with proper content:
 *     #TOC_DESCRIPTION#    this will be replaced with the bookmark description;
 *     #TOC_PAGE_NUMBER#    this will be replaced with page number.
 *
 * NOTES:
 *     If you want to align the page number on the right you have to use a monospaced font like courier, otherwise you can left align using any font type.
 *     The following is just an example, you can get various styles by combining various HTML elements.
 */

// A monospaced font for the page number is mandatory to get the right alignment
$bookmark_templates[0] = '<table border="0" cellpadding="0" cellspacing="5" style="background-color:#FFFFFF"><tr><td width="155mm">
<span style="font-family: rockwell;font-size: 12pt;color: #36a2eb;">#TOC_DESCRIPTION#</span></td>
<td width="25mm"><span style="font-family: rockwell;font-size: 12pt;color: #36a2eb;" align="center">#TOC_PAGE_NUMBER#</span></td></tr></table>';
$bookmark_templates[1] = '<table border="0" cellpadding="0" cellspacing="5"><tr><td width="155mm">
<span style="font-family:rockwell;font-size:12pt;color:#36a2eb;">&nbsp;&nbsp;&nbsp;#TOC_DESCRIPTION#</span></td><td width="25mm">
<span style="font-family:rockwell;font-size:12pt;color:#36a2eb;" align="center">#TOC_PAGE_NUMBER#</span></td></tr></table>';
$bookmark_templates[2] = '<table border="0" cellpadding="0" cellspacing="5"><tr><td width="155mm">
<span style="font-family:rockwell;font-size:12pt;color:#36a2eb;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;#TOC_DESCRIPTION#</span></td><td width="25mm">
<span style="font-family:rockwell;font-size:12pt;color:#36a2eb;" align="center">#TOC_PAGE_NUMBER#</span></td></tr></table>';
$bookmark_templates[3] = '<table border="0" cellpadding="0" cellspacing="5"><tr><td width="155mm">
<span style="font-family:rockwell;font-size:12pt;color:#36a2eb;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;#TOC_DESCRIPTION#</span></td><td width="25mm">
<span style="font-family:rockwell;font-size:12pt;color:#36a2eb;" align="center">#TOC_PAGE_NUMBER#</span></td></tr></table>';
$bookmark_templates[4] = '<table border="0" cellpadding="0" cellspacing="5"><tr><td width="155mm">
<span style="font-family:rockwell;font-size:12pt;color:#36a2eb;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;#TOC_DESCRIPTION#</span></td><td width="25mm">
<span style="font-family:rockwell;font-size:12pt;color:#36a2eb;" align="center">#TOC_PAGE_NUMBER#</span></td></tr></table>';
// add other bookmark level templates here ...

// add table of content at page 1
// (check the example n. 45 for a text-only TOC
$pdf->addHTMLTOC(2, 'Content', $bookmark_templates, true, 'B', array(128,0,0));

// end of TOC page
$pdf->endTOCPage();


//Close and output PDF document
$pdf->Output('Assessment-Booklet.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
