<?php
ini_set('display_errors',1);
function svgbarr($wid,$wid1,$paraname,$ass_id,$emp_id,$pos_id,$ht=''){
	$target_path=__SITE_PATH.DS.'public'.DS.'reports'.DS.'graphs'.DS.'full'.DS.$ass_id;
	$height=!empty($ht)?$ht:'26';
	$a=$wid*60;
	$b=$wid1*60;
	if($a>360 || $b>360){
		$a=$a/2;
		$b=$b/2;
	}
	$value='<svg class="britechart bar-chart" width="500" height="80"><g class="container-group" transform="translate(10, 20)"><g class="chart-group"><rect class="bar" y="30" x="0" height="'.$height.'" width="'.$a.'" fill="#FCB614"></rect><rect class="bar" y="0" x="0" height="'.$height.'" width="'.$b.'" fill="#0098DB"></rect><text x="'.($b+3).'" y="20" fill="#666666">'.$wid.'</text><text x="'.($a+3).'" y="50" fill="#666666">'.$wid1.'</text></g></g></svg>';
	$myfile = fopen($target_path.DS.'bar'.$paraname.'.svg', "w") or die("Unable to open file!");
	//$target_path='public'.DS.'feedback'.DS.$feedid.DS.$name.'.svg';
	//$myfile = fopen($target_path, "w") or die("Unable to open file!");
	fwrite($myfile, $value);
	fclose($myfile);
	
}
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	public $footershow=true;
	public $header="";
	//Page header
	public function Header() {
		global $key2;
		// get the current page break margin
		$bMargin = $this->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $this->AutoPageBreak;
		// disable auto-page-break
		
		if($key2==0){
			$this->SetAutoPageBreak(false, 0);
			// set bacground image
			$img_file = K_PATH_IMAGES.'adanipower/adani-power-cover.jpg';
			$this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
		}
		//$this->ImageSVG($file='images/360degree/c-complete-front.svg', $x=0, $y=0, $w=210, $h=297, $link='', $align='', $palign='', $border=0, $fitonpage=false);
		// restore auto-page-break status
		$this->SetAutoPageBreak($auto_page_break, $bMargin);
		// set the starting point for the page content
		$this->setPageMark();
		if($key2>0){
			$this->SetAutoPageBreak(True, 10);
			//$img_file = 'adani-power-backcover.jpg';
			//$this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
			$text='<br><br>
				<table height="65px;" width="100%" style="text-align:center;font-family:Helvetica;font-weight:bold;font-size:10pt;">
				<tr>
				<td width="95%" style="text-align:left;"><img src="'.LOGO_IMG_PDF.'" style="margin:0.15cm 0.2cm" height="50"> </td>
				
				<td width="5%" style="text-align:right;"><span style="font-family: Helvetica, sans-serif;font-size: 8pt;color:#1b578b;">&nbsp;</span></td>
				</tr>
				<tr>
				<td colspan="2">&nbsp;</td></tr>
				</table>';
				$this->writeHTML($text, true, false, true, false, '');
		}
		$key2++;
	}
	
	public function Footer() {
		global $key1;
		// Position at 15 mm from bottom
		$this->SetY(-8);
		//if ($this->tocpage) {
			// *** replace the following parent::Footer() with your code for TOC page
			//parent::Footer();
		//} else {
			//if($key1==0){
			
			// *** replace the following parent::Footer() with your code for normal pages
			//parent::Footer();
			//}
			//else{
				if($this->footershow){
				$text='<table width="100%" style="text-align:center;font-family:Helvetica;font-weight:bold;font-size:10pt;">
				<tr>
				<td text-align="bottom" rowspan="2" width="95%" style="text-align:left;"><span style="font-family: Helvetica, sans-serif;font-size: 7.5pt;color:#1b578b;">'.PDF_NAME.'</span></td>
				
				<td width="5%" style="text-align:right;"><span style="font-family: Helvetica, sans-serif;font-size: 8pt;color:#1b578b;">'.$this->getAliasNumPage().'</span></td>
				</tr>
				</table>
				';
				$this->writeHTML($text, true, false, true, false, '');
				$this->writeHTMLCell($w='', $h='', $x='', $y='', $this->header, $border=0, $ln=0, $fill=0, $reseth=true, $align='L', $autopadding=true);
				//$this->SetLineStyle( array('width'=>0.40,'color'=> array(54,162,235)));
				$this->SetLineStyle( array('width'=>0.40,'color'=> array(100,100,100)));
				$this->RoundedRect(7, 20, $this->getPageWidth()-14, $this->getPageHeight()-29, 2.5, '1111');
				//$this->Rect(5, 24, $this->getPageWidth()-10, $this->getPageHeight()-34);
				}
			//}
		//} 
		$key1++;
		
	}
}
global $key;
global $key1;
global $key2;
$key=$key1=$key2=0;
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdfname=trim($emp_info['name']);
$pdfname=ucwords(strtolower($pdfname));
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Srikanth Math');
$pdf->SetTitle('Employee Assessment Report of '.$pdfname);
$pdf->SetSubject('Employee Assessment Report of '.$pdfname);
$pdf->SetKeywords('Employee Assessment Report of '.$pdfname);

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 040', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));


// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(10,25,10,true);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(5);


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
// set default font subsetting mode
$pdf->setFontSubsetting(true);
// ---------------------------------------------------------
$fontname = TCPDF_FONTS::addTTFfont(__SITE_PATH.'/application/libraries/tcpdf/fonts/hope.ttf', 'TrueTypeUnicode', '', 96);
//$fontname = TCPDF_FONTS::addTTFfont('../fonts/ARIAL.ttf', 'TrueTypeUnicode', '', 96);
// use the font
$pdf->SetFont($fontname, '', 14, '', false);

// add a page
$pdf->AddPage();
$pdf->footershow=false;
$pdf->SetFooterMargin(0);
// Print a text

$txt='<label class="fish5" text-align="right;" width="100%"><b style="font-size:30pt;color:#fff;">Assessment Report</b></label><br><br><br>
<label class="fish6"><b style="font-size:26pt;color:#fff;"><br></b></label><br><br><br>
<img src="'.LOGO_IMG_PDF.'" style="margin:0.15cm 0.2cm" width="200"  class="fish"><br><br><br>
<label class="fish1"><b style="font-size:22pt;color:#000;">'.trim($emp_info['name']).'</b><br><b style="font-size:14pt;color:#000;">'.@$posdetails['position_name'].'</b></label>';
	
$html = <<<EOD
<table cellspacing="0" width="100%" cellpadding="5" border="0" >
	<tr>
		<td width="100%" height="520pt" colspan="3" align="right">$txt</td>
	</tr>	
</table>
EOD;
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->setPrintHeader(true);

// add a page
$pdf->AddPage();
$pdf->footershow=true;
// -- set new background ---
$pdf->SetFooterMargin(5);
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
$para1="NOTE:This report and its contents are the property of ".$emp_info['parent_organisation']." and no portion of the same should be copied or reproduced without the prior permission of ".$emp_info['parent_organisation'];
$para2="The report is a part of the Techincal/ Functional Assessment process of ".trim($emp_info['name']).", ".trim($posdetails['position_name']);
$tbl = <<<EOD
<div style="height: 750px;bottom:0px;">&nbsp;<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></div>
<div style="color:red;padding-left:5px;font-family: Helvetica;font-size:10px;line-height:1.5;">$para1.<br>$para2<br>
<span style="padding-left:5px;font-family: Helvetica;font-size:10px;color:#646464;">For further information on Competencies, Competency modelling and assessment, please refer to the FAQ section in <a href="http://n-compas.com/" target="_blank">www.N-Compas.com </a><span></div>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

// add a page
$pdf->AddPage();
// -- set new background ---
$pdf->SetFooterMargin(5);
$pdf->Bookmark('1. Introduction', 0, 0, '', '', array(0,0,0));
$index_link = $pdf->AddLink();
$pdf->SetLink($index_link, 0, '*1');
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
$tbl = <<<EOD
<table cellspacing="0" cellpadding="0" border="0" >
    <tr>
        <td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">1. Introduction</span>		
	</td>
    </tr>
</table>
<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">
	<br><span align="left" style="font-family: Helvetica;font-size: 14px;color:#36a2eb; line-height:1.5;">WHAT IS THIS ALL ABOUT?<br></span>
	As you know the organization is constantly in the process of improving the capability platform of employees, so as to enable them reach their true potential.  As a part of this, the organization has drawn-up an ambitious process of Technical and Functional Competency assessment and development process, with an end objective of FOCUSED LEARNING AND DEVELOPMENT FOR EACH INDIVIDUAL.<br><br><br>
	
	<span align="left" style="font-family: Helvetica;font-size: 14px;color:#36a2eb; line-height:1.5;">WHAT IS THE BASIC FRAMEWORK OF THIS PROCESS?<br></span>
	This process has been developed based on the following
	<ol>
	<li>Every job in the organization has a set of accountabilities, which are measured in terms of the outcomes, referred to as KRAs.  These (KRAs), in order to be achieved, would require a certain set of Competencies. These competencies in turn are clasified along the Technical, Functional, Managerial and Leadership dimensions.<br></li>
	<li>Based on the various positions in the organization, a complete set of Technical Competencies have been identified (please refer to the competency dictionary available at www.N-Compas.com) for the Energy business (Thermal Power).<br></li>
	<li>Each position has been defined in terms of the competency requirement, referred to as Competency Profile.<br></li>
	<li>In order to assess an individual on these competencies a set of methods have been identified, which are different for different positions.  Those relevant for your position are given, and detailed in the following section.<br></li>
	</ol><br><br><br>
	
	<span align="left" style="font-family: Helvetica;font-size: 14px;color:#36a2eb; line-height:1.5;">WHAT ARE THE ASSESSMENT METHODS USED?<br></span>
	Based on the position, you will be having a combination of the following assessment methods<br><br>
	<b>MCQ or Multiple Choice Questions:</b><br>These are questions which are based on your product, process/SOP and related aspects.<br><br>
	<b>In-basket Exercises:</b><br>As an executive, your day comprises of a number of activities. How you organize your day, both in terms of time - prioritization and the quality of action - how you choose to act or what you delegate, reflects on your capabilities.<br><br>
	<b>Caselets:</b><br>These are small situational narratives which have been built around your typical issues/aspects which you encounter in your every day work.  How you handle these reflects your technical and to some extent managerial capabilities as well<br><br>
	<b>Cases: </b> <br>These are usually ‘third party’ situational constructs where-in you have to analyze the same and provide your perspective on how you would deal with various aspects therein (as given in the case questions).<br><br>
	
	<span align="left" style="font-family: Helvetica;font-size: 14px;color:#36a2eb; line-height:1.5;">WHAT IS THE SCOPE OF THIS ASSESSMENT?<br></span>
	In this cycle we will be assessing only technical/functional competencies and drawing of the Development Road Map for them.<br><br><br><br>
	<div style="page-break-after: always;"></div>
	<span align="left" style="font-family: Helvetica;font-size: 14px;color:#36a2eb; line-height:1.5;">HOW TO READ THIS REPORT?<br></span>
	This report has the following
	<ol>
	<li>Your job description, including the competency profile.  This profile information was used in creating the assessment<br></li>
	<li>A Radar graph showing the competency requirement of your job, and how you were assessed each of these, using various methods<br></li>
	<li>A consolidated assessment summary sheet<br></li>
	<li>Development road map information as suggested by the assessors.<br></li>
	</ol><br> <br> <br>
	Please read each section of the report carefully, since they flow sequentially		
	</div>
	
</div>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

// add a page
$pdf->AddPage();
// -- set new background ---
$pdf->SetFooterMargin(5);
$pdf->Bookmark('2. Job Description', 0, 0, '', '', array(0,0,0));
$index_link = $pdf->AddLink();
$pdf->SetLink($index_link, 0, '*1');
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
$jd='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">
	<h4 class="titleheader">Position Details</h4>
	<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#5b9bd5" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5; border:0.5px solid #9999;">
		<tbody>
		<tr bgcolor="#deeaf6">
		<td class="normal"  style="width:15%"><b>Job Title</b></td>
		<td class="normal"  style="width:35%">'.@$posdetails['position_name'].'</td>
		<td class="normal"  style="width:15%"><b>Grade/Level</b></td>
		<td class="normal"  style="width:35%">'.@$posdetails['grade_name'].'</td>
		</tr>
		<tr>
		<td class="normal"><b>Business</b></td>
		<td class="normal">'.@$posdetails['bu_name'].'</td>
					<td class="normal"><b>Function</b></td>
					<td class="normal">'.@$posdetails['position_org_name'].'</td>
				</tr>
				<tr  bgcolor="#deeaf6">
					<td class="normal"><b>Location</b></td>
					<td class="normal">'.@$posdetails['location_name'].'</td>
					<td class="normal"><b></b></td>
					<td class="normal"></td>
				</tr>
			</tbody>
		</table>
		<h4 class="titleheader">Reporting Relationships</h4>
		<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#5b9bd5" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5; border:0.5px solid #9999;">
				<tr><td style="width:25%"><b>Reports to</b></td><td class="normal" style="width:75%">'.@$posdetails['reportsto'].'</td></tr>
				<tr bgcolor="#deeaf6"><td style="width:25%"><b>Reportees</b></td><td class="normal" style="width:75%">'.@$posdetails['reportees_name'].'</td></tr>
		</table>
		<h4 class="titleheader">Position Description</h4>
		<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#5b9bd5" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5; border:0.5px solid #9999;">
				<tr><td style="width:25%"><b>Education Background</b></td><td class="normal" style="width:75%">'.strip_tags(@$posdetails['education']).'</td></tr>
				<tr bgcolor="#deeaf6"><td style="width:25%"><b>Experience</b></td><td class="normal" style="width:75%">'.strip_tags(@$posdetails['experience']).'</td></tr><tr><td style="width:25%"><b>Industry Experience</b></td><td class="normal" style="width:75%">'.strip_tags(@$posdetails['specific_experience']).'</td></tr>

		</table>';
		if(!empty($posdetails['other_requirement'])){
		$jd.='<h4 class="titleheader">Other Requirements</h4>'.@$posdetails['other_requirement'];
		}
		$jd.='<h4 class="titleheader">Purpose</h4>'.@$posdetails['position_desc'];

	$jd.='</div>';$name=trim($posdetails['position_name']);
$tbl = <<<EOD
<table cellspacing="0" cellpadding="0" border="0" >
    <tr>
        <td colspan="2" width="100%" ><span align="center" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#5b9bd5; float:right">$name</span>		
	</td>
    </tr>
</table>
$jd
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

if(!empty($posdetails['accountablities'])){
	// add a page
	$pdf->AddPage();
	// -- set new background ---
	$pdf->SetFooterMargin(5);
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
$jd='<h4 class="titleheader" style="font-family: Helvetica;color:#646464;">Accountabilities</h4><div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">';
$jd.=''.@$posdetails['accountablities'];
$jd.='</div>';
$tbl = <<<EOD
$jd
EOD;
	$pdf->writeHTML($tbl, true, false, false, false, '');
}

if(!empty($posdetails['responsibilities'])){
// add a page
$pdf->AddPage();
// -- set new background ---
$pdf->SetFooterMargin(5);
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
$jd='<h4 class="titleheader" style="font-family: Helvetica;color:#646464;">Responsibilities</h4><div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">';
$jd.=''.@$posdetails['responsibilities'];
$jd.='</div>';

$tbl = <<<EOD
$jd
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
}

if(count($kras)>0){
// add a page
$pdf->AddPage();
// -- set new background ---
$pdf->SetFooterMargin(5);
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

$jd='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">';
$jd.='<h4 class="titleheader">KRA & KPI</h4>
<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#5b9bd5" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5; border:0.5px solid #646464;">
			<thead>
				<tr  height="30" bgcolor="#5b9bd5" align="center" class="row header" style="color:#fff;">
		<th>KRA</th>
		<th>KPI</th>
		<th>Unit of Measurement (UOM)</th>
	</tr>
	</thead>
	<tbody>';
	
	$temp="";$kk=0;
	foreach($kras as $kra){
		if($kra['comp_position_id']==$posdetails['position_id']){
			$bgcolor=($kk%2==0)?"#deeaf6":"#ffffff";
			$kk++;
			$jd.='<tr bgcolor="'.$bgcolor.'"><td>';
			if($temp!=$kra['kra_master_name']){
				$jd.=$kra['kra_master_name'];
				$temp=$kra['kra_master_name'];
			}
			$jd.='</td><td>'.$kra['kra_kri'].'</td><td>'.$kra['kra_uom'].'</td></tr>';
		}
	} 
	$jd.='</tbody>
</table>';
$jd.='</div>';
$tbl = <<<EOD
$jd
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
}

// add a page
$pdf->AddPage();
// -- set new background ---
$pdf->SetFooterMargin(5);
$pdf->Bookmark('3. Competency Profile', 0, 0, '', '', array(0,0,0));
$index_link = $pdf->AddLink();
$pdf->SetLink($index_link, 0, '*1');
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

$para3='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">The '.$emp_info['position_name'].', whose description is provided in the above section, would require Competencies – Functional, Technical, Managerial and Behavioural, to ensure that the objectives/goals or KRAs are achieved.  However, not all the competencies, are required at the same Levels of Proficiency or the same level of Criticality.  The process of mapping the position in terms of required Competencies – the Levels and the Criticality is  referred to as Profiling.<br>
The definition of various Levels of Proficiency and the Criticality Dimensions are given here under.<br><br>
In case of Functional/ Techincal Competencies there are Four Level of profficiency.<br><br>';
foreach($scale_info_four as $scale_infos){
	$para3.='<b style="font-size:11px;">'.$scale_infos['scale_name'].':</b> '.$scale_infos['description'].'<br><br>';
}
if(count($scale_info_five)>0){
	$para3.='<br>For Managerial/ Behavioural Competencies there are Five Levels scale of profficiency as given below.<br><br>';
	foreach($scale_info_five as $scale_infoss){
		$para3.='<b style="font-size:11px;">'.$scale_infoss['scale_name'].':</b> '.$scale_infoss['description'].'<br><br>';
	}
}
$para3.='<br>The second dimension, in Competency Profiling is called the Level of Criticality, which in turn is split into three categories<br><br>';
foreach($cri_info as $k=>$cri_infos){
	$para3.=$k!=0?'<br><br>':'';
	$para3.='<b style="font-size:11px;">'.$cri_infos['name'].':</b> '.$cri_infos['description'];
}
$para3.='</div>';

$para3.='<br><br><br><br><br><br><br><br><div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;"><span align="left" style="font-family: Helvetica;font-size: 14px;color:#36a2eb;line-height: 1.5;">COMPETENCY/SKILL REQUIREMENTS<br></span>';
$para3.='The following are the competencies required for the position of '.$emp_info['position_name'].'. This is also reffered to as Competency Profilling';
foreach($category as $categorys){
	$ass_comp_info=UlsAssessmentReport::getassessment_admin_competency($ass_id,$pos_id,$categorys['category_id']);	
	$para3.='<br><br><span align="left" style="text-transform: uppercase; font-family: Helvetica;font-size: 14px;color:#36a2eb; line-height: 1.5;">'.$categorys['name'].'</span><br><br>';
	$para3.='<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#59b0ea" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5; border:0.5px solid #9999;">
	<thead><tr height="30" bgcolor="#59b0ea" align="center" class="row header" style="color:#fff;">
		<th>Competency/Skill</th>
		<th>Level Requirement</th>
		<th>Criticality</th>
		</tr>
	</thead>
	<tbody>';
	$results=$assessor=array();
	foreach($ass_comp_info as $ass_comp_infos){
		$comp_id=$ass_comp_infos['comp_def_id'];
		$req_scale_id=$ass_comp_infos['req_scale_id'];
		$results[$comp_id]['comp_name']=$ass_comp_infos['comp_def_name'];
		$results[$comp_id]['req_scale_id']=$ass_comp_infos['req_scale_id'];
		$results[$comp_id]['req_scale_name']=$ass_comp_infos['req_scale_name'];
		$results[$comp_id]['assessment_id']=$ass_comp_infos['assessment_id'];
		$results[$comp_id]['position_id']=$ass_comp_infos['position_id'];
		$results[$comp_id]['comp_cri_name']=$ass_comp_infos['comp_cri_name'];
	}$kk=0;
	foreach($results as $comp_def_id=>$result){
		$final_admin_id=$_SESSION['user_id'];
		$bgcolor=($kk%2==0)?"#deeaf6":"#ffffff";
		$kk++;
		$para3.='<tr bgcolor="'.$bgcolor.'">
		<td>'.$result['comp_name'].'</td>
		<td>'.$result['req_scale_name'].'</td>
		<td>'.$result['comp_cri_name'].'</td>		
		</tr>';
	}
	$para3.='</tbody>
	</table>';
}
$para3.='</div>';		
$tbl = <<<EOD
<table cellspacing="0" cellpadding="0" border="0" >
    <tr>
        <td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">3. Competency Profile<br></span>
	</td>
    </tr>
</table>
$para3
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

$para178='<table cellspacing="0" cellpadding="0" border="0" >
    <tr>
        <td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">4. Competency Overview<br></span>		
	</td>
    </tr>
</table>';
$para_overall='<span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 14px;color:#36a2eb; ">Overall Score</span>
<img src="'.BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['ass_id'].'/over_all'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'.svg" style="width:600px;height:100px;" >';

$para_assessment='<span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 14px;color:#36a2eb; ">Assessment summary</span>
<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">In order to help you get a better understanding on the outcome of the assessment process, the various methods have been converted into numeric values.
</div>
<br>
<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#59b0ea" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5; border:0.5px solid #9999;">
	<thead>
		<tr height="30" bgcolor="#59b0ea" align="center" class="row header" style="color:#fff;">
			<th width="6%">S.No</th>
			<th width="20%">Assessment Method</th>
			<th width="10%">Total Question</th>
			<th width="12%">Answered Correctly/Rating</th>
			<th width="12%">Percentage Scored (%)</th>
			<th width="20%">Weightage for Assessment Method (%)</th>
			<th width="20%">Weighted Score</th>
		</tr>
	</thead>
	<tbody>';
		$results=array();
		foreach($assessor_rating_new as $assessor_rating_news){
			$finalval=!empty($assessor_rating_news['assessor_val'])?round(($assessor_rating_news['rat_num']*$assessor_rating_news['assessor_val']),2):$assessor_rating_news['rat_num'];
			$results[$assessor_rating_news['assessment_type']]['assessment_type']=$assessor_rating_news['assessment_type'];
			$results[$assessor_rating_news['assessment_type']]['assess_type']=$assessor_rating_news['assess_type'];
			$results[$assessor_rating_news['assessment_type']]['weightage']=$assessor_rating_news['weightage'];
			$results[$assessor_rating_news['assessment_type']]['test_ques']=$assessor_rating_news['test_ques'];
			$results[$assessor_rating_news['assessment_type']]['test_score']=$assessor_rating_news['test_score'];
			$results[$assessor_rating_news['assessment_type']]['rating_scale']=$assessor_rating_news['rating_scale'];
			$results[$assessor_rating_news['assessment_type']]['assessor'][$assessor_rating_news['assessor_id']]=$finalval;
		}
		$i=1;
		$score='';
		$wei_sum=0;
		$wei_total=0;$kk=0;
		foreach($results as $key1=>$assessor_ratings){
			$wei_sum=($wei_sum+$assessor_ratings['weightage']);
			$bgcolor=($kk%2==0)?"#deeaf6":"#ffffff";
			$kk++;
			$para_assessment.='<tr bgcolor="'.$bgcolor.'">
				<td width="6%">'.($i++).'</td>
				<td width="20%">';
					$ast=($assessor_ratings['assessment_type']!='TEST')?'<sup><font color="#FF0000">*</font></sup>':"";
					$para_assessment.=$assessor_ratings['assess_type'].' '.$ast.'
				</td>
				<td width="10%">';
					if($assessor_ratings['assessment_type']=='TEST'){
						$para_assessment.=$assessor_ratings['test_ques'];
					}
					else{
						$para_assessment.='NA';
					}
				$para_assessment.='</td>
				<td width="12%">';
					if($assessor_ratings['assessment_type']=='TEST'){
						$score_test=$assessor_ratings['test_score'];
						$para_assessment.=$score_test_f=$score_test;
					}
					else{
						$final=0;
						foreach($assessor_ratings['assessor'] as $key2=>$ass_id){
							$final=$final+$results[$key1]['assessor'][$key2];
						}
						$final=round($final/count($results[$key1]['assessor']),2);
						$score=round($final,2);
						$score_f=$score;
						$para_assessment.=$score_f;
					}
				$para_assessment.='</td>
				<td width="12%">';
					if($assessor_ratings['assessment_type']=='TEST'){
						$score_test=(($assessor_ratings['test_score']/$assessor_ratings['test_ques'])*100);
						$para_assessment.=$score_test;
					}
					else{
						$final=0;
						foreach($assessor_ratings['assessor'] as $key2=>$ass_id){
							$final=$final+$results[$key1]['assessor'][$key2];
						}
						$final=round($final/count($results[$key1]['assessor']),2);
						$score=(($final/$assessor_ratings['rating_scale'])*100);
						$para_assessment.=$score;
					}
				$para_assessment.='</td>
				<td  width="20%">'.$assessor_ratings['weightage'].'</td>
				<td  width="20%">';
				$score_final=$scorefinal=0;
				if($assessor_ratings['assessment_type']=='TEST'){
					$score_test=(($assessor_ratings['test_score']/$assessor_ratings['test_ques'])*100);
					$wei=$assessor_ratings['weightage'];
					$score_final=round((($score_test*$wei)/100),2);
					$para_assessment.=$score_final;
				}
				else{
					$final=0;
					foreach($assessor_ratings['assessor'] as $key2=>$ass_id){
						$final=$final+$results[$key1]['assessor'][$key2];
					}
					$final=round($final/count($results[$key1]['assessor']),2);
					$score=(($final/$assessor_ratings['rating_scale'])*100);
					$wei=$assessor_ratings['weightage'];
					$scorefinal=round((($score*$wei)/100),2);
					$para_assessment.=$scorefinal;
				} 
				$wei_total=round($wei_total+($score_final+$scorefinal),2);
				$para_assessment.='</td>
				
			</tr>';
		}
		$para_assessment.='<tr style="font-size:18px;">
			<td colspan="5"  style="font-size:18px;">Overall Score</td>
			<td style="font-size:18px;">'.$wei_sum.'</td>
			<td style="font-size:18px;">'.$wei_total.'</td>
		</tr></tbody>
	</table>	
	<br>
	<div style="color:red; padding-left:5px; font-size:10px;">
	For In-basket and Case study, a rating scale of 1 to 4 was used<br>';
	foreach($ass_rating_scale as $key=>$ass_rating_scales){
		$g=($key!=0)?",":"";
		$para_assessment.='<span>'.$g.' '.$ass_rating_scales['rating_number'].' - '.$ass_rating_scales['rating_name_scale'].'</span>';
	}
	$para_assessment.='</div>
	<br>
<span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 14px;color:#36a2eb; ">Category wise score</span>';
$para_table='<table cellspacing="0" cellpadding="5" border="0.5px" align="left" style="width:100%;font-family: Helvetica; color:#646464;font-size:10px;line-height: 1.5; border:0.5px solid #9999;">
	<thead>
		<tr bgcolor="#59b0ea" align="center" style="color:#fff;" class="row header">
			<th style="width:20%" rowspan="2">Competency</th>
			<th style="width:60%" colspan="'.count($testtypes_new).'">Assessment Method</th>
			<th rowspan="2" style="width:10%">Computational Rational</th>
			<th rowspan="2" style="width:10%">Overall</th>
		</tr>
		<tr bgcolor="#59b0ea" align="center" style="color:#fff;" class="row header">';
			$a="";
			$wid=60/count($testtypes_new);
			foreach($testtypes_new as $testtype){
				if($testtype['assessment_type']=='TEST'){
					$para_table.='<th width="'.$wid.'%">Test('.$testtype['weightage'].')</th>';
				}
				elseif($testtype['assessment_type']=='INBASKET'){
					$para_table.='<th width="'.$wid.'%">In-Basket('.$testtype['weightage'].')</th>';
				}
				elseif($testtype['assessment_type']=='CASE_STUDY'){
					$para_table.='<th width="'.$wid.'%">Case Study('.$testtype['weightage'].')</th>';
				}
				elseif($testtype['assessment_type']=='INTERVIEW'){
					$para_table.='<th width="'.$wid.'%">Interview('.$testtype['weightage'].')</th>';
				}
				elseif($testtype['assessment_type']=='FEEDBACK'){
					$para_table.='<th width="'.$wid.'%">Feedback('.$testtype['weightage'].')</th>';
				}
			}
			$para_table.='</tr>
	</thead>
	<tbody>';
	$total_all_weight=0;
	$cluster_wei=array();
	foreach($category as $categorys){
		$ass_comp_info=UlsAssessmentReport::getassessment_admin_competency($_REQUEST['ass_id'],$_REQUEST['pos_id'],$categorys['category_id']);
		$para_table.='<tr>
			<td colspan="('.count($testtypes).')+3" style="width:100%">'.$categorys['name'].'</td>
		</tr>';
		$results=$result_assessor=$assessor=array();
		$ass_method_score="";
		foreach($ass_comp_info as $ass_comp_infos){
			$comp_id=$ass_comp_infos['comp_def_id'];
			$req_scale_id=$ass_comp_infos['req_scale_id'];
			$results[$comp_id]['comp_id']=$comp_id;
			$results[$comp_id]['comp_name']=$ass_comp_infos['comp_def_name'];
			$results[$comp_id]['pos_com_weightage']=$ass_comp_infos['pos_com_weightage'];
		}
		foreach($assessor_rating_new as $assessor_rating_news){
			$finalval=!empty($assessor_rating_news['assessor_val'])?round(($assessor_rating_news['rat_num']*$assessor_rating_news['assessor_val']),2):$assessor_rating_news['rat_num'];
			$result_assessor[$assessor_rating_news['assessment_type']]['assessment_type']=$assessor_rating_news['assessment_type'];
			$result_assessor[$assessor_rating_news['assessment_type']]['event_id']=$assessor_rating_news['event_id'];
			$result_assessor[$assessor_rating_news['assessment_type']]['assess_type']=$assessor_rating_news['assess_type'];
			$result_assessor[$assessor_rating_news['assessment_type']]['weightage']=$assessor_rating_news['weightage'];
			$result_assessor[$assessor_rating_news['assessment_type']]['test_ques']=$assessor_rating_news['test_ques'];
			$result_assessor[$assessor_rating_news['assessment_type']]['test_score']=$assessor_rating_news['test_score'];
			$result_assessor[$assessor_rating_news['assessment_type']]['rating_scale']=$assessor_rating_news['rating_scale'];
			$result_assessor[$assessor_rating_news['assessment_type']]['assessor'][$assessor_rating_news['assessor_id']]=$finalval;
		}
		foreach($result_assessor as $key1=>$assessor_ratings){
			if($assessor_ratings['assessment_type']!='FEEDBACK'){
				if($assessor_ratings['assessment_type']=='TEST'){
					$ass_method_test=$assessor_ratings['event_id'];
				}
				if($assessor_ratings['assessment_type']=='INBASKET'){
					$final=0;
					foreach($assessor_ratings['assessor'] as $key2=>$ass_id){
						$final=$final+$result_assessor[$key1]['assessor'][$key2];
					}
					$final=round($final/count($result_assessor[$key1]['assessor']),2);
					$score=round($final,2);
					$score_f=$score;
					$ass_method_inbasket=$score_f;
				}
				if($assessor_ratings['assessment_type']=='CASE_STUDY'){
					$final=0;
					foreach($assessor_ratings['assessor'] as $key2=>$ass_id){
						$final=$final+$result_assessor[$key1]['assessor'][$key2];
					}
					$final=round($final/count($result_assessor[$key1]['assessor']),2);
					$score=round($final,2);
					$score_f=$score;
					$ass_method_case=$score_f;
				}
				if($assessor_ratings['assessment_type']=='INTERVIEW'){
					$final=0;
					foreach($assessor_ratings['assessor'] as $key2=>$ass_id){
						$final=$final+$result_assessor[$key1]['assessor'][$key2];
					}
					$final=round($final/count($result_assessor[$key1]['assessor']),2);
					$score=round($final,2);
					$score_f=$score;
					$ass_method_interview=$score_f;
				}
				
			}
		}
		
		foreach($results as $comp_def_id=>$result){
			$para_table.='<tr>
				<td style="width:20%">'.$result['comp_name'].'('.$result['pos_com_weightage'].')</td>';
				$multi=1;
				
				$test_weight=$inb_weight=$case_weight=$int_weight=$feed_weight='';
				foreach($testtypes_new as $testtype){

					if($testtype['assessment_type']=='TEST'){
						
						$testdetails=UlsUtestAttemptsAssessment::attempt_detail_report($ass_method_test,$_REQUEST['emp_id']);
						$emp_id=$_REQUEST['emp_id'];
						$compquestion=UlsMenu::callpdorow("SELECT group_concat(distinct(a.`question_id`)) as q_id,a.`competency_id`,count(*)  as q_count,d.comp_def_name,s.scale_name,a.position_id,d.comp_def_id,s.scale_id,ac.assessment_pos_level_id,s.scale_number FROM `uls_assessment_test_questions` a
						left join(SELECT `assessment_id`,`assessment_pos_com_id`,`assessment_pos_level_scale_id`,`assessment_type`,assessment_pos_level_id,position_id FROM `uls_assessment_competencies` where assessment_id=".$ass_id.") ac on ac.assessment_pos_com_id=a.competency_id and ac.position_id=a.position_id
						left join(SELECT `comp_def_id`,`comp_def_name` FROM `uls_competency_definition`) d on d.comp_def_id=ac.assessment_pos_com_id
						left join (SELECT `scale_id`,`scale_name`,scale_number FROM `uls_level_master_scale`) s on s.scale_id=ac.assessment_pos_level_scale_id
						WHERE a.`assess_test_id`=".$testdetails->event_id." and a.`test_id`=".$testdetails->test_id." and a.assessment_id=".$testdetails->assessment_id." and a.`competency_id`=".$result['comp_id']."  group by a.`competency_id` ");
						
						$total=@explode(",",$compquestion['q_id']);$cor_count=UlsUtestResponsesAssessment::question_count_correct($compquestion['q_id'],$emp_id,$testdetails->event_id,$testdetails->assessment_id);
						$blank_count=UlsUtestResponsesAssessment::question_count_leftblank($compquestion['q_id'],$emp_id,$testdetails->event_id,$testdetails->assessment_id);
						$total_question=!empty($blank_count['l_count'])?(count($total)-$blank_count['l_count']):count($total);
						//$total_per=round((($cor_count['c_count']/$total_question)*100),2); 
						$total_per=round((($cor_count['c_count']/$total_question)),2);
						$test_weight=($total_per*($testtype['weightage']/100));
						$para_table.='<td width="'.$wid.'%">'.$total_per.'</td>';
					}
					elseif($testtype['assessment_type']=='INBASKET'){
						$inb_test_id=UlsAssessmentTest::get_ass_position_inbasket_comp($_REQUEST['ass_id'],$_REQUEST['pos_id'],$result['comp_id'],'INBASKET');
						$ass_method_inbasket="";
						if(!empty($inb_test_id['comp_id'])){
							$inb_weight=@(($ass_method_inbasket/4)*($testtype['weightage']/100));
							$para_table.='<td width="'.$wid.'%">'.$ass_method_inbasket.'</td>';
						}
						else{
							$multi=($multi+($testtype['weightage']/100));
							$para_table.='<td width="'.$wid.'%"></td>';
						}
						
					}
					elseif($testtype['assessment_type']=='CASE_STUDY'){
						$case_test_id=UlsAssessmentTest::get_ass_position_case_comp($_REQUEST['ass_id'],$_REQUEST['pos_id'],$result['comp_id'],'CASE_STUDY');
						$ass_method_case="";
						if(!empty($case_test_id)){
							$case_weight=@(($ass_method_case/4)*($testtype['weightage']/100));
							$para_table.='<td width="'.$wid.'%">'.$ass_method_case.'</td>';
						}
						else{
							$multi=($multi+($testtype['weightage']/100));
							$para_table.='<td width="'.$wid.'%"></td>';
						}
						
					}
					elseif($testtype['assessment_type']=='INTERVIEW'){
						$int_weight=(($ass_method_interview/4)*($testtype['weightage']/100));
						$para_table.='<td width="'.$wid.'%">'.$ass_method_interview.'</td>';
					}
					elseif($testtype['assessment_type']=='FEEDBACK'){
						$feed_test_id=UlsAssessmentTest::get_ass_position_test($_REQUEST['ass_id'],$_REQUEST['pos_id'],'FEEDBACK');
						$feed_comp=UlsMenu::callpdorow("SELECT avg(`rater_value`) as avg_rater_value FROM `uls_feedback_employee_rating` WHERE `assessment_id`=".$_REQUEST['ass_id']." and `ass_test_id`=".$feed_test_id['assess_test_id']." and `employee_id`=".$_REQUEST['emp_id']." and `giver_id`!=".$_REQUEST['emp_id']." and `element_competency_id`=".$result['comp_id']);
						$feed_weight=((round($feed_comp['avg_rater_value'],2)/4)*($testtype['weightage']/100));
						$feed_weights=!empty($feed_weight)?$feed_weight:0;
						$para_table.='<td width="'.$wid.'%">'.round($feed_comp['avg_rater_value'],2).'</td>';
					}
				}
				
				$total_com=@round(($test_weight+$inb_weight+$case_weight+$int_weight+$feed_weight)*($multi),2);
				$over_all=@round(($total_com*count($testtypes)),2);
				$over_all_weight=@round(($over_all*($result['pos_com_weightage']/100)),2);
				$total_all_weight+=$over_all_weight;
				$cat_details=$categorys['category_id']."*".$categorys['name'];
				$cluster_wei[$cat_details]=isset($cluster_wei[$cat_details])?$cluster_wei[$cat_details]+$over_all_weight:$over_all_weight;
				$clu_wei[$categorys['category_id']]=isset($clu_wei[$categorys['category_id']])?$clu_wei[$categorys['category_id']]+$result['pos_com_weightage']:$result['pos_com_weightage'];
			$para_table.='<td style="width:10%">'.$total_com.'</td>
			<td style="width:10%">'.$over_all_weight.'</td></tr>';
		}
	}
	
	$para_table.='</tbody>
	</table><br style="clear:both;">';
	/* foreach($cluster_wei as $key=>$cluster_weis){
		$cat=explode("*",$key);
		$para_table.=$cat[1]."***".($cluster_weis/4*100)."-".$clu_wei[$cat[0]];
	}
	
	$total_per=($total_all_weight/4*100);
	$para_table.='<b>'.$total_all_weight.'-'.$total_per.'</b>'; 
	$para_table_new="";
	$para_table_new='<br style="clear:both;">
	<img src="'.BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['ass_id'].'/comp_over_all'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'.svg" style="width:600px;" ><br style="clear:both;">';*/
$para_radar='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;"><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 14px;color:#36a2eb; ">Radar Graph</span>
';
$results=$assessor=$comname=$comp_id=array();
foreach($ass_results as $key1=>$result){
	$comp_id[$result['comp_def_id']]="C".($key1+1);
	$comname[$result['comp_def_id']]=$result['comp_def_name'];
}
$para_radar.='<table width="100%">
<tbody>
<tr>
<td width="50%"><img src="'.BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['ass_id'].'/'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'_radar.svg" style="width:350px;padding-top:10px;"/></td>
<td width="50%" align="top">';
$val_self=array_combine($comp_id,$comname);
foreach($val_self as $key => $val_selfs){
	$para_radar.=$key.'-'.$val_selfs.'<br>';
}
$para_radar.='</td>
			</tr>
		</tbody>
	</table>
	<br>
	<span style="font-size:9px;">In case the assessed level is exactly the same as required level, you will be able to see only Green line (Assessed Level)</span></div>';
// add a page
$pdf->AddPage();
$pdf->footershow=true;
$pdf->SetFooterMargin(5);
$pdf->Bookmark('4. Competency Overview', 0, 0, '', '', array(0,0,0));
$index_link = $pdf->AddLink();
$pdf->SetLink($index_link, 0, '*1');
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();
/* $para_table_new
<br style="clear:both;"> */
$tbl = <<<EOD
$para178
<br style="clear:both;">
$para_overall
<br style="clear:both;">
$para_assessment
<br style="clear:both;">
$para_table
<br style="clear:both;">

$para_radar
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

	$para16="";
	$jung="";

		
$instrument=UlsAssessmentTestBehavorialInst::get_behavorial_assessment_report($testtypes_bh['assess_test_id']);
foreach($instrument as $instruments){
	$inst=UlsBeiAttemptsAssessment::get_attempt_valus_beh($_REQUEST['ass_id'],$_REQUEST['emp_id'],$instruments['assess_test_id']);
	
	if($instruments['instrument_type']=='BEI_RATING_TWO'){
		$pdf->AddPage();
		$pdf->footershow=true;
		$pdf->SetFooterMargin(5);
		$pdf->Bookmark('5.1 Jung’s Output', 0, 0, '', '', array(0,0,0));
		$index_link = $pdf->AddLink();
		$pdf->SetLink($index_link, 0, '*1');
		$bMargin = $pdf->getBreakMargin();
		$auto_page_break = $pdf->getAutoPageBreak();
		$pdf->SetAutoPageBreak(false, 0);
		$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
		$pdf->setPageMark();
		$query="SELECT count(`text`) as val,`text` as name,response_value_id FROM `uls_bei_responses_assessment` WHERE `employee_id`=".$_REQUEST['emp_id']." and `assessment_id`=".$_REQUEST['ass_id']." and `event_id`=".$instruments['assess_test_id']." and `instrument_id`=".$instruments['instrument_id']." group by `text`";
		$inst_details=UlsMenu::callpdo($query);
		$inst_array=array();
		foreach($inst_details as $inst_detail){
			$id=$inst_detail['name'];
			$inst_array[$id]=$inst_detail['val'];
		}
		if(isset($inst_array['E']) && isset($inst_array['I'])){
			if($inst_array['E']>=4){
				$jung.="E";
			}
			else{
				$jung.="I";
			}
		}
		elseif(!isset($inst_array['E']) && isset($inst_array['I'])){
			$jung.="I";
		}
		elseif(isset($inst_array['E']) && !isset($inst_array['I'])){
			$jung.="E";
		}
		
		//$jung.=isset($inst_array['E'])?($inst_array['E']>=4)?"E":isset($inst_array['I'])?($inst_array['I']>=4)?"I":"E";
		$jung.=($inst_array['S']>=4)?"S":"N";
		$jung.=($inst_array['F']>=4)?"F":"T";
		$jung.=($inst_array['J']>=4)?"J":"P"; 
$sqls_j="SELECT * FROM `feed_jungian_description` WHERE 1";
$s1_sql_j=UlsMenu::callpdo($sqls_j);
$jungian_code=$jungian_name=$jungian_description='';
foreach($s1_sql_j as $s1_sql_js){
	if(trim($s1_sql_js['jungian_code'])==$jung){
		$jungian_code=$s1_sql_js['jungian_code'];
		$jungian_name=$s1_sql_js['jungian_name'];
		$jungian_description=$s1_sql_js['jungian_description'];
	}
}	

$arr1 = str_split($jung);
if(isset($arr1[0]))
{
	if($arr1[0] == "E"){
		$ar1[0]="Extroverted";
	}else if($arr1[0] == "I"){
		$ar1[0]="Introverted";
	}
}
if(isset($arr1[1]))
{
	if($arr1[1] == "S"){
		$ar1[1]="Sensing";
	}else if($arr1[1] == "N"){
		$ar1[1]="Intuitive";
	}
}

if(isset($arr1[2]))
{
	if($arr1[2] == "F"){
		$ar1[2]="Feeling";
	}else if($arr1[2] == "T"){
		$ar1[2]="Thinking";
	}
}
if(isset($arr1[3]))
{
	if($arr1[3] == "J"){
		$ar1[3]="Judging";
	}else if($arr1[3] == "P"){
		$ar1[3]="Perceiving";
	}
}
$ae=$arr1[0]=="E"?"E":"EW";
$ai=$arr1[0]=="I"?"I":"IW";
$as=$arr1[1]=="S"?"S":"SW";
$an=$arr1[1]=="N"?"N":"NW";
$af=$arr1[2]=="F"?"F":"FW";
$at=$arr1[2]=="T"?"T":"TW";
$aj=$arr1[3]=="J"?"J":"JW";
$ap=$arr1[3]=="P"?"P":"PW";
$a1 = BASE_URL.'/public/uploads/MBTI/'.$ae.'.png';
$a2 = BASE_URL.'/public/uploads/MBTI/'.$ai.'.png';
$a3 = BASE_URL.'/public/uploads/MBTI/'.$as.'.png';
$a4 = BASE_URL.'/public/uploads/MBTI/'.$an.'.png';
$a5 = BASE_URL.'/public/uploads/MBTI/'.$af.'.png';
$a6 = BASE_URL.'/public/uploads/MBTI/'.$at.'.png';
$a7 = BASE_URL.'/public/uploads/MBTI/'.$aj.'.png';
$a8 = BASE_URL.'/public/uploads/MBTI/'.$ap.'.png';

$aec=$arr1[0]=="E"?"color:#000000":"color:#999999";
$aic=$arr1[0]=="I"?"color:#000000":"color:#999999";
$asc=$arr1[1]=="S"?"color:#000000":"color:#999999";
$anc=$arr1[1]=="N"?"color:#000000":"color:#999999";
$afc=$arr1[2]=="F"?"color:#000000":"color:#999999";
$atc=$arr1[2]=="T"?"color:#000000":"color:#999999";
$ajc=$arr1[3]=="J"?"color:#000000":"color:#999999";
$apc=$arr1[3]=="P"?"color:#000000":"color:#999999";
		
$para16.='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;"><p>Your responses on the Jungian Personality instrument indicate that your reported type is:<span style="font-size: 14pt;color: #0A0A0A;font-family: helvetica;"><b>'.$jung.'</b></span></p><br>
<p bgcolor="#5b9bd5" align="right" style="font-size: 20pt;"><b>Personality Type: <span style="font-size: 22pt; background-color:#5b9bd5;" ><i>'.$jung.'</i></span></b></p></br></br>
<table cellspacing="0" cellpadding="5" border="0.5px" bordercolor="#5b9bd5" style="width:100%;font-size:10pt;font-family:Helvetica, sans-serif; color:#0A0A0A;">

<tr>
<td width="10%" align="center"><br><br><br><img src="'.$a1.'" width="300%"></td>
<td width="40%"><p style="'.$aec.'"><b>The Extroverts</b>:<br>They draw energy from others, believe in action, and indulge in multi-tasking, enjoy a variety of experiences and activities; and are confident in unfamiliar surroundings; tend to be expressive about themselves</p></td>
<td width="10%" align="center"><br><br><br><img src="'.$a2.'" width="300%"></td>
<td width="40%"><p style="'.$aic.'"><b>The Introverts:</b><br>Derive their energy by spending quiet time alone or with small groups drawing energy from inner self, prefer introspection, reflection; and self-discovery; learn by watching and are not very expressive with regards their feelings</p></td>
</tr>
<tr ><td width="10%" align="center"><br><br><br><img src="'.$a3.'" width="300%"></td>
<td width="40%"><p style="'.$asc.'"><b>The Sensors</b>:<br>Are usually more practical, pragmatic, and resourceful. Have higher attention to detail and demonstrate same in solving problems, they are detail oriented, use past experience, common sense and give importance to facts</p></td>
<td width="10%" align="center"><br><br><br><img src="'.$a4.'" width="300%"></td>
<td width="40%"><p style="'.$anc.'"><b>The Intuitives:</b><br>The focus is on abstract level of thinking; interested in theories, patterns and explanations; and more concerned with the future than the present; tend to dislike routines and details; rely on hunches, instincts, inductive reasoning and feelings</p></td></tr>
<tr ><td width="10%" align="center"><br><br><br><img src="'.$a5.'" width="300%"></td>
<td width="40%"><p style="'.$afc.'"> <b>The Feelers:</b><br>Warm, co-operative and sensitive to feelings of others;  are very conscious of the impact of their actions on others; decisions are driven by their own set of personal values and deep beliefs</p></td>
<td width="10%" align="center"><br><br><br><img src="'.$a6.'" width="300%"></td>
<td width="40%"><p style="'.$atc.'"><b>The Thinkers:</b><br>Tend to make decisions with their head and finding the most logical, reasonable choice; like to get to the bottom of any issue and enjoy debates; not too concerned about the impact of their decisions on others</p></td></tr>
<tr ><td width="10%" align="center"><br><br><br><img src="'.$a7.'" width="300%"></td>
<td width="40%"><p style="'.$ajc.'"><b>The Judgers</b>:<br>Purposeful and appreciate structure, order, plans and rules; like things planned and dislike last minute changes; driven to organize and be correct and tend to be inflexible preferring to see issues in black and white.</p></td>
<td width="10%" align="center"><br><br><br><img src="'.$a8.'" width="300%"></td>
<td width="40%"><p style="'.$apc.'"><b>The Perceivers:</b><br>Present oriented and going with the moment;  like to be flexible and keep options open; strong preference for spontaneity; like to spend less time in planning.</p></td></tr>
</table><span></span>
<p class="first">An <b>'.$jung.'</b>, is typified as folows: <br> <span style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">'.$jungian_description.'</span>
</p>
</div>';
$para16h='<table cellspacing="0" cellpadding="0" border="0" >
<tr>
	<td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">6. Jung’s Output<br></span>		
</td>
</tr>
</table>';

$tbl = <<<EOD
$para16h
$para16

EOD;
	$pdf->writeHTML($tbl, true, false, false, false, '');
	}
	elseif($instruments['instrument_type']=='BEI_RATING_SINGLE'){
		$para17h='';
		$pdf->AddPage();
		$pdf->footershow=true;
		$pdf->SetFooterMargin(5);
		$pdf->Bookmark('5.2. PEC Output', 0, 0, '', '', array(0,0,0));
		$index_link = $pdf->AddLink();
		$pdf->SetLink($index_link, 0, '*1');
		$bMargin = $pdf->getBreakMargin();
		$auto_page_break = $pdf->getAutoPageBreak();
		$pdf->SetAutoPageBreak(false, 0);
		$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
		$pdf->setPageMark();
		$query_pec="SELECT `text` as name,response_value_id,b.ins_subpara_code FROM `uls_bei_responses_assessment` a 
		left join(SELECT `ins_subpara_id`,`ins_para_id`,`instrument_id`,`ins_subpara_code`,`ins_subpara_text` FROM `uls_be_ins_subparameters` ) b on a.ins_para_id=b.ins_para_id and a.response_value_id=b.ins_subpara_id
		WHERE a.`employee_id`=".$_REQUEST['emp_id']." and a.`assessment_id`=".$_REQUEST['ass_id']." and a.`event_id`=".$instruments['assess_test_id']." and a.`instrument_id`=".$instruments['instrument_id'];
		$instdetails=UlsMenu::callpdo($query_pec);
		$pec_code=array();
		foreach($instdetails as $inst_detail){
			$code=$inst_detail['ins_subpara_code'];
			$pec_code[$code]=$inst_detail['name'];
		}
		$Opportunity_Seeking=$pec_code['I4Q26']+$pec_code['I4Q27']+$pec_code['I4Q28']-$pec_code['I4Q29']+$pec_code['I4Q30']+6;
		$Persistence=$pec_code['I4Q31']+$pec_code['I4Q32']+$pec_code['I4Q33']-$pec_code['I4Q34']+$pec_code['I4Q35']+6;
		$Commitment=$pec_code['I4Q1']+$pec_code['I4Q2']+$pec_code['I4Q3']+$pec_code['I4Q4']-$pec_code['I4Q5']+6;
		$Demand=$pec_code['I4Q11']+$pec_code['I4Q12']+$pec_code['I4Q13']+$pec_code['I4Q14']-$pec_code['I4Q15']+6;
		$RiskTaking=$pec_code['I4Q41']-$pec_code['I4Q42']+$pec_code['I4Q43']+$pec_code['I4Q44']+$pec_code['I4Q45']+6;
		$GoalSetting=$pec_code['I4Q16']-$pec_code['I4Q17']+$pec_code['I4Q18']+$pec_code['I4Q19']+$pec_code['I4Q20']+6;
		$Information=$pec_code['I4Q21']+$pec_code['I4Q22']-$pec_code['I4Q23']+$pec_code['I4Q24']+$pec_code['I4Q25']+6;
		$Systematic=$pec_code['I4Q51']+$pec_code['I4Q52']+$pec_code['I4Q53']-$pec_code['I4Q54']+$pec_code['I4Q55']+6;
		$Persuasion=$pec_code['I4Q36']-$pec_code['I4Q37']+$pec_code['I4Q38']+$pec_code['I4Q39']+$pec_code['I4Q40']+6;
		$Self_Confidence=$pec_code['I4Q46']-$pec_code['I4Q47']+$pec_code['I4Q48']+$pec_code['I4Q49']+$pec_code['I4Q50']+6;
		$Correction_Factor=$pec_code['I4Q6']-$pec_code['I4Q7']-$pec_code['I4Q8']-$pec_code['I4Q9']+$pec_code['I4Q10']+18;
		$pec_sum=(((($Opportunity_Seeking)+($Persistence)+($Commitment)+($Demand)+($RiskTaking)+($GoalSetting)+($Information)+($Systematic)+($Persuasion)+($Self_Confidence))/250)*100);
		$factor="";
		if($Correction_Factor==24 || $Correction_Factor==25){
			$factor=7;
		}
		elseif($Correction_Factor==22 || $Correction_Factor==23){
			$factor=5;
		}
		elseif($Correction_Factor==20 || $Correction_Factor==21){
			$factor=3;
		}
		elseif($Correction_Factor<=19){
			$factor=0;
		}
		
		$para17h.='<table cellspacing="0" cellpadding="0" border="0" >
		<tr>
			<td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">6. PEC Output</span>		
		</td>
		</tr>
		</table>
		<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">
			<p>How to read your PEC profile:<br>
			To achieve business excellence, employees need to demonstrate certain Entrepreneurial competencies. In the table above you see the 10 vital competencies identified. The highest score is 25 per competency. The closer you are to 25, the better you are at demonstrating that competency.<br>
			The average and median score is 12.5. A score below 12.5 means a challenge or an opportunity for improvement in that particular competency. The PECs profile is dynamic, meaning it is not set in stone and whatever challenges you may have could still be improved on.</p>
		
		<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#5b9bd5" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5; border:0.5px solid #646464;">
		<thead>
			<tr height="30" bgcolor="#59b0ea" align="center" class="row header" style="color:#fff;">
				<th width="100%" colspan="2"><b>PEC Profile</b></th>
			</tr>
			<tr height="30" bgcolor="#59b0ea" align="center" class="row header" style="color:#fff;">
				<th width="60%">Competency Name</th>
				<th width="40%">Final Score</th>
			</tr>
		</thead>
		<tbody>
			<tr bgcolor="#deeaf6">
				<td width="60%">Opportunity Seeking</td>
				<td width="40%">'.($Opportunity_Seeking-$factor).'</td>
			</tr>
			<tr>
				<td width="60%">Persistence</td>
				<td width="40%">'.($Persistence-$factor).'</td>
			</tr>
			<tr bgcolor="#deeaf6">
				<td width="60%">Commitment to Work Contract</td>
				<td width="40%">'.($Commitment-$factor).'</td>
			</tr>
			<tr>
				<td width="60%">Demand for Efficiency and Quality</td>
				<td width="40%">'.($Demand-$factor).'</td>
			</tr>
			<tr bgcolor="#deeaf6">
				<td width="60%">Risk Taking</td>
				<td width="40%">'.($RiskTaking-$factor).'</td>
			</tr>
			<tr>
				<td width="60%">Goal Setting</td>
				<td width="40%">'.($GoalSetting-$factor).'</td>
			</tr>
			<tr bgcolor="#deeaf6">
				<td width="60%">Information Seeking</td>
				<td width="40%">'.($Information-$factor).'</td>
			</tr>
			<tr>
				<td width="60%">Systematic Planning and monitoring</td>
				<td width="40%">'.($Systematic-$factor).'</td>
			</tr>
			<tr bgcolor="#deeaf6">
				<td width="60%">Persuasion and Networking</td>
				<td width="40%">'.($Persuasion-$factor).'</td>
			</tr>
			<tr>
				<td width="60%">Self-Confidence</td>
				<td width="40%">'.($Self_Confidence-$factor).'</td>
			</tr>
			<!--<tr bgcolor="#deeaf6">
				<td width="40%">Correction Factor</td>
				<td width="20%">'.$Correction_Factor.'</td>
				<td width="5%">-</td>
				<td width="10%"></td>
				<td width="5%">=</td>
				<td width="20%"></td>
			</tr>-->
		</tbody>
		</table>
		</div>';

$tbl = <<<EOD
$para17h
EOD;
	$pdf->writeHTML($tbl, true, false, false, false, '');
	}
}
	
$para58='<table cellspacing="0" cellpadding="0" border="0" >
<tr>
	<td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">6. Findings & Recommendations<br></span>		
</td>
</tr>
</table>';
$pdf->AddPage();
$pdf->footershow=true;
$pdf->SetFooterMargin(5);
$pdf->Bookmark('6. Findings & Recommendations', 0, 0, '', '', array(0,0,0));
$index_link = $pdf->AddLink();
$pdf->SetLink($index_link, 0, '*1');
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();

$tbl = <<<EOD
$para58
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

// add a page
$pdf->AddPage();
// -- set new background ---
$pdf->SetFooterMargin(5);
$pdf->Bookmark('7. Assessment Methods', 0, 0, '', '', array(0,0,0));
$index_link = $pdf->AddLink();
$pdf->SetLink($index_link, 0, '*1');
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
$para4='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">The Following Assessment methods are being used for this position.<br>Also indicated in the table is the corresponding weightages for each of the assessments methods.<br><br>
<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#59b0ea" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5;">
	<thead><tr height="30" bgcolor="#59b0ea" align="center" class="row header" style="color:#fff;">
			<th width="10%">S.No</th>
			<th width="40%">Assessment Type</th>
			<th width="30%">Assessment Weightages</th>
			<th width="20%">Duration</th>
		</tr>
	</thead>
	<tbody>';
	$i=1;$kk=0;
	foreach($testtypes as $testtype){
		$bgcolor=($kk%2==0)?"#deeaf6":"#ffffff";
		$kk++;
		$para4.='<tr bgcolor="'.$bgcolor.'">';
		$para4.='<td align="center" width="10%">'.$i.'</td>';
		$para4.='<td width="40%">'.$testtype['assess_type'].'</td>';
		$para4.='<td width="30%">'.$testtype['weightage'].'</td>';
		$para4.='<td width="20%">'.$testtype['time_details'].' mins</td></tr>';
		$i++;
	}
	$para4.='</tbody>
	</table>
	</div>';		
$tbl = <<<EOD
<table cellspacing="0" cellpadding="0" border="0" >
    <tr>
        <td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">7. Assessment Methods<br></span>
	</td>
    </tr>
</table>
$para4
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');


$para5="";
foreach($testtypes as $k=>$testtype){
	/* if($testtype['assessment_type']=="TEST"){
		$testdetails=UlsAssessmentTest::assessment_view_final($testtype['assess_test_id']);
		$pdf->AddPage();
		$pdf->SetFooterMargin(5);
		$pdf->Bookmark('7.'.($k+1).'. '.$testtype['assess_type'], 1, 0, '', '', array(0,0,0));
		$index_link = $pdf->AddLink();
		$pdf->SetLink($index_link, 0, '*1');
		$bMargin = $pdf->getBreakMargin();
		$auto_page_break = $pdf->getAutoPageBreak();
		$pdf->SetAutoPageBreak(false, 0);
		$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
		$pdf->setPageMark();
		$para5.='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;"><span align="left" style="font-family: Helvetica;font-size: 12px;color:#36a2eb; ">'.$testtype['assess_type'].'</span>';
		foreach($testdetails as $key=>$que){
			$para5.='<div>';
			$keys=$key+1;
			$ques=$que['question_id'];
			$type=$que['type_flag'];
			$para5.='<br><b>Q'.$keys.')</b>&nbsp;'.$que['question_name'].'<br>';
			$ss=Doctrine_Query::create()->select('value_id,text,correct_flag')->from("UlsQuestionValues")->where("question_id=".$que['question_id'])->execute();
			$empdetail=UlsMenu::callpdorow("SELECT * FROM `uls_utest_responses_assessment` WHERE `assessment_id`=".$_REQUEST['ass_id']." and test_type='".$testtype['assessment_type']."' and `employee_id`=".$_REQUEST['emp_id']." and `user_test_question_id`=".$que['question_id']);
			if($type=='S' || $type=='M'){ $para5.='<ol>'; }
			foreach($ss as $key1=>$sss){
				$col=$sss['correct_flag']=='Y'? 'style="color:green;font-size:10px;font-family:italic;"':'';
				$col2=$empdetail['response_value_id']==$sss['value_id']?'style="color:blue;font-size:10px;font-family:italic;"':'';
				$ke=$key1+1;
				if($type=='F'){
					$para5.='&nbsp;&nbsp;&nbsp;&nbsp;..............................................<br>';
				}
				else if($type=='B'){
					$para5.='&nbsp;&nbsp;&nbsp;&nbsp;..............................................<br>';
				}
				else if($type=='T'){
					$para5.='&nbsp;&nbsp;&nbsp;&nbsp;'.$ke.']'.trim(strip_tags($sss['text'])).'<br>';
				}
				else if($type=='S'){
					$para5.='<li type="A" '.$col.' '.$col2.'>'.trim(($sss['text'])).'</li>';
				}
				else if($type=='M') {
					$para5.='<li type="A" '.$col.' '.$col2.'>'.trim(strip_tags($sss['text'])).'</li>';
				}
				else if($type=='FT') {
					$col=$sss['correct_flag']=='Y'? 'style="color:green;font-size:10px;font-family:italic;"':'';
					if(!empty($sss['text'])){
						$para5.='<br><div '.$col.' class="answer"><i>What to look for<br>'.@$sss['text'].'</i></div><br>';
					}
					if(!empty($empdetail['text'])){
						$para5.='<div style="color:blue;font-size:10px;font-family:italic;" class="answer">'.@$empdetail['text'].'</div>';
					}
					else{
						$para5.='<textarea cols="100" style="height:85px;" ><span style="color:#d1d1d1;">Interviewers Comments</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</textarea>';
					}
				}
			}
			if($type=='S' || $type=='M'){ $para5.='</ol>'; }
			$para5.='</div>';
		}
		if($testtype['assessment_type']=="TEST"){
			$para5.='<br><br><span style="font-size:0.8em;">Note:<br>
			a.	Marked in <font color="blue">BLUE</font>:  Those given by the applicant<br>
			b.	Marked in <font color="green">GREEN</font>:  Suggested/recommended answer/option </span>';
		}
$para5.='</div>';

$tbl = <<<EOD
$para5
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
} */

if($testtype['assessment_type']=="INBASKET"){
	$mode=array();
	foreach($modes as $val){
		$id=$val['code'];
		$mode[$id]=$val['name'];
	}
	$noinbaskets=UlsMenu::callpdo("SELECT * FROM `uls_assessment_test_inbasket` where assessment_id=$ass_id and position_id=$pos_id");
	foreach($noinbaskets as $noinbasket){
		$inbasket=UlsInbasketMaster::viewinbasket($noinbasket['inbasket_id']);
		$para6='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;"><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 14px;color:#36a2eb; ">What is an In-basket Exercise?</span><br>
		An In-basket or an Intray is a list of items of work that need to be to be attended to when you come to work.  These could include mails, calls (mobile, intercom), reports, meetings, visits by you or by others, etc.  For the various items in the In-basket/intray, there would be a certain approach you would take – for exampling first attending the mail items, or the work from the previous day; and for each of them you would decide the kind of action you want to take and/or delegate the same.  Whatever you decide, is a reflection of your style of work and also tells how you prioritize and plan your work.<br>Apat from this, for each of the In-basket, you are to suggest an action which reflects your level of understanding and expertize.<br><br>
		In the following exercise,  you will role-play the person mentioned in the In-basket narration and help him/her plan the items of work that he/she needs to be doing.<br><br>
		Please read the In-basket narration and instructions carefully before starting.</div>';
		// add a page
		$pdf->AddPage();
		$pdf->SetFooterMargin(5);
		$pdf->Bookmark('7.'.($k+1).'. '.$testtype['assess_type'], 1, 0, '', '', array(0,0,0));
		$index_link = $pdf->AddLink();
		$pdf->SetLink($index_link, 0, '*1');
		$bMargin = $pdf->getBreakMargin();
		$auto_page_break = $pdf->getAutoPageBreak();
		$pdf->SetAutoPageBreak(false, 0);
		$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
		$pdf->setPageMark();
$tbl = <<<EOD
$para6
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
$para7='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">';
if(!empty($inbasket['inbasket_narration'])){
	$para7.='<span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 14px;color:#36a2eb; ">In-basket Narration</span><br>'.nl2br($inbasket['inbasket_narration']).'';
}
if(!empty($inbasket['question_id'])){
	$empdetailinbasket=UlsMenu::callpdorow("SELECT * FROM `uls_utest_responses_assessment` WHERE `assessment_id`=".$_REQUEST['ass_id']." and `employee_id`=".$_REQUEST['emp_id']." and test_type='INBASKET' and `user_test_question_id`=".$inbasket['question_id']);
	$question_view=UlsQuestionValues::get_allquestion_values_competency($inbasket['question_id']);
	$scorting=($inbasket['inbasket_scorting_order']=='Y')?"sortable":"";
	$scorting_arrow=($inbasket['inbasket_scorting_order']=='Y')?"<span class='ui-icon ui-icon-arrowthick-2-n-s'></span>":"";
	if(!empty($inbasket['inbasket_instructions'])){
		$para7.='<br><br><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 14px;color:#36a2eb; ">In-basket Instructions</span><br>
				'.nl2br($inbasket['inbasket_instructions']).'';
	}
	$para7.='</div>';
// add a page
$pdf->AddPage();
$pdf->SetFooterMargin(5);

$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();
$tbl = <<<EOD
$para7
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

$para8='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">
<span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 14px;color:#36a2eb; ">In-basket Exercise<br></span>';
$intrayss=array();
foreach($question_view as $key=>$question_views){
	if(!empty($question_views['inbasket_mode'])){
		$parsed_json = json_decode($question_views['inbasket_mode'], true);
	}
	$keyy=$key+1;
	$a=$question_views['value_id'];
	$intrayss[$a]="Intray ".$keyy;
	$compp[$a]=$question_views['comp_def_name'];
	$scall[$a]=$question_views['scale_name'];
	$priority[$a]=$question_views['priority_inbasket'];
	$para8.='<div><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 14px;color:#36a2eb; ">Intray # '.$keyy.'<br></span>Competency: '.$question_views['comp_def_name'].'<br>Level: '.$question_views['scale_name'].'';
	if(!empty($parsed_json)){
		foreach($parsed_json as $key => $value){
			$k=$value['mode'];
			$para8.='Mode: '.@$mode[$k].'<br>
			Time: '.$value['period'].'<br>
			From: '.$value['from'].'<br>';
		}
	}
	$text=str_replace(array("<br>","</br>"),array("",""),$question_views['text']);
	$para8.=nl2br($text).'</div>';
}
$para8.='</div>';
// add a page
/* $pdf->AddPage();
$pdf->SetFooterMargin(5);
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();
$tbl = <<<EOD
<style>
.titleheaderchk {

		
}
</style>
$para8
EOD; 
$pdf->writeHTML($tbl, true, false, false, false, '');*/

$para9='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">
<span align="left" style="text-transform: uppercase; font-family: Helvetica;font-size: 14px;color:#36a2eb; ">In-basket: Analysis and Interpretation<br><br></span>
The following is the prioritization given by '.$emp_info['name'].'<br>
Please note the SME priority means the prioritization as pre-detemined by Subject Matter Expert(s)
<br>
<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#59b0ea" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5; border:0.5px solid #9999;">
	<thead><tr height="30" bgcolor="#59b0ea" align="center" class="row header" style="color:#fff;">
		<th width="15%">Priority Order</th><th width="45%">Action & Description</th><th  width="25%">Competency/Level</th><th width="15%">SME Priority</th></tr></thead><tbody>';
$inbaskets=json_decode($empdetailinbasket['text'], true);
if(is_array($inbaskets)){$kk=0;
	foreach($inbaskets as $key=>$inbasket){
		$b=$inbasket['id'];
		$smep=!empty($priority[$b])?$priority[$b]:"NA";
		$bgcolor=($kk%2==0)?"#deeaf6":"#ffffff";
		$kk++;
		$para9.='<tr bgcolor="'.$bgcolor.'">';
		$para9.='<td width="15%">'.$intrayss[$b].' <br>is <br>Priority #'.($key+1).'</td><td width="45%"><b>'.$inbasket['action'].'</b><br>'.$inbasket['text'].'</td><td width="25%">'.$compp[$b].'<br>'.$scall[$b].'</td><td width="15%">'.$smep.'</td></tr>';
	}
}
$para9.='</tbody></table>
						</div>';
// add a page
$pdf->AddPage();
$pdf->SetFooterMargin(5);
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();
$tbl = <<<EOD
$para9
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
}
}

if($testtype['assessment_type']=="CASE_STUDY"){
	$nocases=UlsMenu::callpdo("SELECT * FROM `uls_assessment_test_casestudy` where assessment_id=$ass_id and position_id=$pos_id");
	foreach($nocases as $nocase){
		$case_details=UlsCaseStudyMaster::viewcasestudy($nocase['casestudy_id']);
		$para10='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">
		<span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 14px;color:#36a2eb;">Case study/Caselet</span><br>'.$case_details['casestudy_description'].'<br>';
		//$case_study_questions=UlsCaseStudyQuestions::viewcasestudyquestion($nocase['casestudy_id']);
		
		$case_study_questions=UlsMenu::callpdo("SELECT a.`question_id` as q_id,a.`competency_id`,d.comp_def_name,q.casestudy_quest_id,q.casestudy_quest as question_name  FROM `uls_assessment_test_questions` a
		left join(SELECT `comp_def_id`,`comp_def_name` FROM `uls_competency_definition`) d on d.comp_def_id=a.competency_id
		left join(SELECT `casestudy_quest_id`,`casestudy_quest` FROM `uls_case_study_questions`) q on q.casestudy_quest_id=a.question_id
		WHERE a.`assess_test_id`=".$testtype['assess_test_id']." and a.`test_id`=".$nocase['test_id']."");
		
		$para10.='<h4 class="titleheader">Questions</h4>';
		foreach($case_study_questions as $key1=>$case_study_question){
			$empdetailcase=UlsMenu::callpdorow("SELECT * FROM `uls_utest_responses_assessment` WHERE `assessment_id`=".$_REQUEST['ass_id']." and `employee_id`=".$_REQUEST['emp_id']." and test_type='CASE_STUDY' and `user_test_question_id`=".$case_study_question['casestudy_quest_id']);
			$empdetailcaseattach=UlsMenu::callpdorow("SELECT * FROM `uls_utest_attempts_assessment` WHERE `assessment_id`=".$_REQUEST['ass_id']." and `employee_id`=".$_REQUEST['emp_id']." and test_type='CASE_STUDY' and status='A'");
			$para10.='<br>
			<span style="color:#646464;font-size:11px;line-height: 1.5;">Q'.($key1+1).') '.$case_study_question['question_name'].'</span><br><br>
			<span style="color:blue;font-size:11px;line-height: 1.5;">A. '.@nl2br($empdetailcase['text']).'</span>
			<br>';
			if(!empty($empdetailcaseattach['inbasket_upload'])){
				$para10.='Please Click on <a href="'.BASE_URL.'/public/uploads/employee_casestudy/'.$empdetailcaseattach['inbasket_upload'].'" parent="_blank">Attachment</a> to view Applicant add document.';
			}
		}
		$para10.='</div>';
// add a page
$pdf->AddPage();
$pdf->SetFooterMargin(5);
$pdf->Bookmark('7.'.($k+1).'. '.$testtype['assess_type'], 1, 0, '', '', array(0,0,0));
$index_link = $pdf->AddLink();
$pdf->SetLink($index_link, 0, '*1');
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();

$tbl = <<<EOD
$para10
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
	}
}
}

// add a page
$pdf->AddPage();
// -- set new background ---
$pdf->SetFooterMargin(5);
$pdf->Bookmark('8. 360 feedback', 0, 0, '', '', array(0,0,0));
$index_link = $pdf->AddLink();
$pdf->SetLink($index_link, 0, '*1');
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
$para41='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">360 degree feedback also known as a multi-rater or multi source feedback is a process where an individual receives feedback from multiple sources with whom he/she has interacted in the course of discharging his/her job responsibilities on a set of workplace competencies<br>
The personal feedback report highlights differences between the individuals self perception and the feedback from others. Critical areas for self-development are highlighted. The report becomes a critical piece for professional development planning.<br>
How to use the report:
The report covers a detailed analysis of the feedback received on each of the competencies. This will help you to understand your own perceptions and that of the others perception vis-à-vis the competencies. It provides three pieces of information on every competency<br>
Three Steps<br>
1. Average Score for each competency<br>
2. Rating given by different groups of raters<br>
3. Rating on each element of each competency. 
</div>
<br>';
$sqlself ="select AVG( a.rater_value) AS average,a.element_competency_id FROM uls_feedback_employee_rating a
left join(SELECT `feed_assess_test_id`,`assess_test_id`,`position_id`,`assessment_id`,`ques_id` FROM `uls_assessment_test_feedback`) b on a.ass_test_id=b.assess_test_id and a.ques_id=b.ques_id and a.assessment_id=b.assessment_id
where a.employee_id='$emp_id' and a.giver_id='$emp_id' and a.rater_value<>0 and a.assessment_id='$ass_id' GROUP BY a.element_competency_id";	
$q=UlsMenu::callpdo($sqlself);
$Series2=array();
$parameter=array();
foreach($q as $r){
	$prs=$r['element_competency_id'];
	$Series2[$prs]= round($r['average'],1);
}
$catquery="SELECT * FROM `uls_category` WHERE `category_id` in (SELECT DISTINCT(`comp_def_category`) FROM `uls_competency_definition` WHERE 1 and `comp_def_id` in (SELECT DISTINCT(`element_competency_id`) FROM `uls_feedback_employee_rating` WHERE employee_id='".$_REQUEST['emp_id']."' and rater_value<>0 and assessment_id='".$_REQUEST['ass_id']."' ORDER BY `uls_feedback_employee_rating`.`element_competency_id` ASC ) ORDER BY `uls_competency_definition`.`comp_def_category` ASC )";
$catresults=UlsMenu::callpdo($catquery);
foreach($catresults as $cate){
$para41.="<h2>".$cate['name']."</h2>";	
/* print_r($Series2); */
$para41.='<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#59b0ea" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5;">
	<thead><tr height="30" bgcolor="#59b0ea" align="center" class="row header" style="color:#fff;">
			<th width="76%">Competency</th>
			<th width="24%">Rating : Self Vs Others</th>
		</tr>
	</thead>
	<tbody>';
	$sql12 ="select AVG( a.rater_value) AS average,a.element_competency_id,d.comp_def_name FROM uls_feedback_employee_rating a
	left join(SELECT `feed_assess_test_id`,`assess_test_id`,`position_id`,`assessment_id`,`ques_id` FROM `uls_assessment_test_feedback`) b on a.ass_test_id=b.assess_test_id and a.ques_id=b.ques_id and a.assessment_id=b.assessment_id
	left join(SELECT `ques_comp_id`,`ques_id`,`ques_competency_id`,`ques_level_scale_id` FROM `uls_questionnaire_competency`) c on c.ques_competency_id=a.element_competency_id and a.ques_id=c.ques_id
	left join(SELECT `comp_def_id`,`comp_def_name`,comp_def_category FROM `uls_competency_definition`) d on d.comp_def_id=c.ques_competency_id
	where a.employee_id='$emp_id' and a.giver_id!='$emp_id' and a.rater_value<>0 and a.assessment_id='$ass_id' and d.comp_def_category='".$cate['category_id']."' GROUP BY a.element_competency_id";
	$q=UlsMenu::callpdo($sql12);
	$Series1=array();
	$parameter=array();
	$kk=0;
	foreach($q as $r){
		$bgcolor=($kk%2==0)?"#deeaf6":"#ffffff";
		$kk++;
		$pr=$r['element_competency_id'];
		$Series1[$pr]= round($r['average'],1);
		$parameter[]=$r['comp_def_name'];
		$wid=$Series2[$pr];
		$wid1=$Series1[$pr];
		$heit=26;
		$withh=50;
		$k_path=svgbarr($wid,$wid1,$r['element_competency_id'],$_REQUEST['ass_id'],$_REQUEST['emp_id'],$_REQUEST['pos_id'],$heit);
		$bar2 = BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['ass_id'].'/bar'.$r['element_competency_id'].'.svg';
		$para41.='<tr bgcolor="'.$bgcolor.'">
			<td style="width:'.$withh.'%">'.ucwords(strtolower($r['comp_def_name'])).'</td>
			<td style="width:'.$withh.'%"><img src="'.$bar2.'" width="350" ></td>
		</tr>';
	}
	
	$para41.='</tbody>
</table>';


$para41.='<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#59b0ea" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5;">
	<thead><tr height="30" bgcolor="#59b0ea" align="center" class="row header" style="color:#fff;">
			<th width="30%">Competency</th>
			<th width="46%">Elements</th>
			<th width="12%">Self Rating</th>
			<th width="12%">Others Rating</th>
		</tr>
	</thead>
	<tbody>';
	$sqlself_comp ="select a.rater_value AS average,a.element_competency_id,a.ques_element_id FROM uls_feedback_employee_rating a
	left join(SELECT `feed_assess_test_id`,`assess_test_id`,`position_id`,`assessment_id`,`ques_id` FROM `uls_assessment_test_feedback`) b on a.ass_test_id=b.assess_test_id and a.ques_id=b.ques_id and a.assessment_id=b.assessment_id
	where a.employee_id=".$_REQUEST['emp_id']." and a.rater_value<>0 and a.assessment_id=".$_REQUEST['ass_id']." GROUP BY a.ques_element_id";	
	$q_self_comp=UlsMenu::callpdo($sqlself_comp);
	$Series_self=array();
	foreach($q_self_comp as $r_self){
		$pr=$r_self['ques_element_id'];
		$Series_self[$pr]= round($r_self['average'],1);
	}
	$sql13 ="select AVG( a.rater_value) AS average,a.element_competency_id,d.comp_def_name,e.element_id_edit,a.ques_element_id FROM uls_feedback_employee_rating a
	left join(SELECT `feed_assess_test_id`,`assess_test_id`,`position_id`,`assessment_id`,`ques_id` FROM `uls_assessment_test_feedback`) b on a.ass_test_id=b.assess_test_id and a.ques_id=b.ques_id and a.assessment_id=b.assessment_id
	left join(SELECT `ques_comp_id`,`ques_id`,`ques_competency_id`,`ques_level_scale_id` FROM `uls_questionnaire_competency`) c on c.ques_competency_id=a.element_competency_id and a.ques_id=c.ques_id
	left join(SELECT `ques_element_id`,`ques_id`,`element_id`,`element_competency_id`,`element_id_edit` FROM `uls_questionnaire_competency_element`) e on e.ques_id=a.ques_id and c.ques_competency_id=e.element_competency_id and e.ques_element_id=a.ques_element_id
	left join(SELECT `comp_def_id`,`comp_def_name`,comp_def_category FROM `uls_competency_definition`) d on d.comp_def_id=c.ques_competency_id
	where a.employee_id=".$_REQUEST['emp_id']." and a.giver_id!=".$_REQUEST['emp_id']." and a.rater_value<>0 and a.assessment_id=".$_REQUEST['ass_id']." and d.comp_def_category='".$cate['category_id']."' GROUP BY a.ques_element_id order by c.ques_competency_id ASC";
	$qq=UlsMenu::callpdo($sql13);
	$kkk=0;
	$Series_others=array();
	$temp="";
	foreach($qq as $rn){
		$bgcolor=($kkk%2==0)?"#deeaf6":"#ffffff";
		$kkk++;
		$pr=$rn['ques_element_id'];
		$Series_others[$pr]= round($rn['average'],1);
		
		$para41.='<tr bgcolor="'.$bgcolor.'">
			<td style="width:30%">';
			if($temp!=$rn['comp_def_name']){
				$para41.=ucwords(strtolower($rn['comp_def_name']));
				$temp=$rn['comp_def_name'];
			}
			$para41.='</td>
			<td style="width:46%">'.$rn['element_id_edit'].'</td>
			<td style="width:12%" align="center">'.$Series_self[$pr].'</td>
			<td style="width:12%" align="center">'.$Series_others[$pr].'</td>
		</tr>';
	}
	$para41.='</tbody>
</table>
';
}
	
$tbl = <<<EOD
<table cellspacing="0" cellpadding="0" border="0" >
    <tr>
        <td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">8. 360 feedback<br></span>
	</td>
    </tr>
</table>
$para41
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
 // add a page
$pdf->AddPage();
$pdf->footershow=false;
//$pdf->SetMargins(60, 200, PDF_MARGIN_RIGHT,true);
// -- set new background ---
$pdf->SetFooterMargin(0);
// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(false, 0);
// set bacground image
$img_file = K_PATH_IMAGES.'adanipower/adani-power-backcover.jpg';
$pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
// restore auto-page-break status
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();
$pdf->writeHTML("", true, false, false, false, '');

// add a new page for TOC
$pdf->addTOCPage();
$pdf->footershow=true;
// write the TOC title and/or other elements on the TOC page
$pdf->SetFont('times', 'B', 16);
$pdf->MultiCell(0, 0, 'Table Of Content', 0, 'C', 0, 1, '', '', true, 0);
$pdf->Ln();
$pdf->SetFont('Helvetica', '', 10);
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
<span style="font-family: Helvetica;font-size: 12px;color: #36a2eb;">#TOC_DESCRIPTION#</span></td>
<td width="25mm"><span style="font-family: Helvetica;font-size: 12px;color: #36a2eb;" align="center">#TOC_PAGE_NUMBER#</span></td></tr></table>';
$bookmark_templates[1] = '<table border="0" cellpadding="0" cellspacing="5"><tr><td width="155mm">
<span style="font-family:Helvetica;font-size:12px;color:#36a2eb;">&nbsp;&nbsp;&nbsp;#TOC_DESCRIPTION#</span></td><td width="25mm">
<span style="font-family:Helvetica;font-size:12px;color:#36a2eb;" align="center">#TOC_PAGE_NUMBER#</span></td></tr></table>';
$bookmark_templates[2] = '<table border="0" cellpadding="0" cellspacing="5"><tr><td width="155mm">
<span style="font-family:Helvetica;font-size:12px;color:#36a2eb;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;#TOC_DESCRIPTION#</span></td><td width="25mm">
<span style="font-family:Helvetica;font-size:12px;color:#36a2eb;" align="center">#TOC_PAGE_NUMBER#</span></td></tr></table>';
$bookmark_templates[3] = '<table border="0" cellpadding="0" cellspacing="5"><tr><td width="155mm">
<span style="font-family:Helvetica;font-size:12px;color:#36a2eb;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;#TOC_DESCRIPTION#</span></td><td width="25mm">
<span style="font-family:Helvetica;font-size:12px;color:#36a2eb;" align="center">#TOC_PAGE_NUMBER#</span></td></tr></table>';
$bookmark_templates[4] = '<table border="0" cellpadding="0" cellspacing="5"><tr><td width="155mm">
<span style="font-family:Helvetica;font-size:12px;color:#36a2eb;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;#TOC_DESCRIPTION#</span></td><td width="25mm">
<span style="font-family:Helvetica;font-size:12px;color:#36a2eb;" align="center">#TOC_PAGE_NUMBER#</span></td></tr></table>';
// add other bookmark level templates here ...

// add table of content at page 1
// (check the example n. 45 for a text-only TOC
$pdf->addHTMLTOC(2, 'Content', $bookmark_templates, true, 'B', array(128,0,0));

// end of TOC page
$pdf->endTOCPage();

$pdfname=str_replace(" ","_",'Employee Assessment Report of '.$pdfname);
//Close and output PDF document
$pdf->Output($pdfname.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+