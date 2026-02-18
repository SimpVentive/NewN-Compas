<?php
ini_set('display_errors',0);
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	public $footershow=true;
	public $header="";
	//Page header
	public function Header() {
		global $pkey2;
		// get the current page break margin
		$bMargin = $this->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $this->AutoPageBreak;
		// disable auto-page-break
		
		if($pkey2==0){
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
		if($pkey2>0){
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
				</table>
				';
				$this->writeHTML($text, true, false, true, false, '');
		}
		$pkey2++;
	}
	
	public function Footer() {
		global $pkey1;
		// Position at 15 mm from bottom
		$this->SetY(-8);
		//if ($this->tocpage) {
			// *** replace the following parent::Footer() with your code for TOC page
			//parent::Footer();
		//} else {
			//if($pkey1==0){			
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
		$pkey1++;
		
	}
}
global $key;
global $pkey1;
global $pkey2;
$key=$pkey1=$pkey2=0;
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdfname=trim($emp_info['name']);
$pdfname=ucwords(strtolower($pdfname));
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Srikanth Math');
$pdf->SetTitle('HR Assessment Report of '.$pdfname);
$pdf->SetSubject('HR Assessment Report of '.$pdfname);
$pdf->SetKeywords('HR Assessment Report of '.$pdfname);

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
$pdf->SetFont('Helvetica', '', 11);

// add a page
$pdf->AddPage();
$pdf->footershow=false;
$pdf->SetFooterMargin(0);
// Print a text

$txt='<label class="fish5" text-align="right;" width="100%"><b style="font-size:30pt;color:#fff;">Assessment Report</b></label><br><br><br>
<label class="fish6"><b style="font-size:26pt;color:#fff;">(HR)</b></label><br><br><br>
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
<div style="height: 750px;bottom:0px;">&nbsp;<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></div>
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
	$para3.='<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#59b0ea" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5;">
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
	}
	$kk=0;
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

// add a page
$pdf->AddPage();
// -- set new background ---
$pdf->SetFooterMargin(5);
$pdf->Bookmark('4. Assessment Methods', 0, 0, '', '', array(0,0,0));
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
$para4='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">The following methods were used as a part of this Assessment process.<br><br>
<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#59b0ea" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5;">
	<thead><tr height="30" bgcolor="#59b0ea" align="center" class="row header" style="color:#fff;">
			<th width="10%">S.No</th>
			<th width="60%">Assessment Type</th>
			<th width="30%">Duration</th>
		</tr>
	</thead>
	<tbody>';
	$i=1;$kk=0;
	foreach($testtypes as $testtype){
		$bgcolor=($kk%2==0)?"#deeaf6":"#ffffff";
		$kk++;
		$para4.='<tr bgcolor="'.$bgcolor.'">';
		$para4.='<td align="center" width="10%">'.$i.'</td>';
		$para4.='<td width="60%">'.$testtype['assess_type'].'</td>';
		$para4.='<td width="30%">'.$testtype['time_details'].' mins</td></tr>';
		$i++;
	}
	$para4.='</tbody>
	</table>
	</div>';		
$tbl = <<<EOD
<table cellspacing="0" cellpadding="0" border="0" >
    <tr>
        <td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">4. Assessment Methods<br></span>
	</td>
    </tr>
</table>
$para4
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');


$para5="";
foreach($testtypes as $k=>$testtype){
	if($testtype['assessment_type']=="TEST"){
		$testdetails=UlsAssessmentTest::assessment_view_final($testtype['assess_test_id']);
		$pdf->AddPage();
		$pdf->SetFooterMargin(5);
		$pdf->Bookmark('4.'.($k+1).'. '.$testtype['assess_type'], 1, 0, '', '', array(0,0,0));
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
}

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
		$pdf->Bookmark('4.'.($k+1).'. '.$testtype['assess_type'], 1, 0, '', '', array(0,0,0));
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
	$para8.=nl2br($question_views['text']).'</div>';
}
$para8.='</div>';
// add a page
$pdf->AddPage();
$pdf->SetFooterMargin(5);
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();
$tbl = <<<EOD
$para8
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

$para9='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">
<span align="left" style="text-transform: uppercase; font-family: Helvetica;font-size: 14px;color:#36a2eb; ">In-basket: Analysis and Interpretation<br><br></span>
The following is the prioritization given by '.$emp_info['name'].'<br>
Please note the SME priority means the prioritization as pre-detemined by Subject Matter Expert(s)
<br>
<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#59b0ea" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5;">
	<thead><tr height="30" bgcolor="#59b0ea" align="center" class="row header" style="color:#fff;">
		<th width="15%">Priority Order</th><th width="45%">Action & Description</th><th  width="25%">Competency/Level</th><th width="15%">SME Priority</th></tr></thead><tbody>';
$inbaskets=json_decode($empdetailinbasket['text'], true);
$kk=0;
if(is_array($inbaskets)){
	foreach($inbaskets as $key=>$inbasket){
		$b=$inbasket['id'];
		$smep=!empty($priority[$b])?$priority[$b]:"NA";
		$bgcolor=($kk%2==0)?"#deeaf6":"#ffffff";
		$kk++;
		$para9.='<tr bgcolor="'.$bgcolor.'">';
		$para9.='<td width="15%">'.$intrayss[$b].' <br>is <br>Priority #'.($key+1).'</td><td width="45%">'.$inbasket['action'].'<br>'.$inbasket['text'].'</td><td width="25%">'.$compp[$b].'<br>'.$scall[$b].'</td><td width="15%">'.$smep.'</td></tr>';
	}
}
$para9.='</tbody></table></div>';
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
		$case_study_questions=UlsCaseStudyQuestions::viewcasestudyquestion($nocase['casestudy_id']);
		$para10.='<h4 class="titleheader">Questions</h4>';
		foreach($case_study_questions as $key1=>$case_study_question){
			$empdetailcase=UlsMenu::callpdorow("SELECT * FROM `uls_utest_responses_assessment` WHERE `assessment_id`=".$_REQUEST['ass_id']." and `employee_id`=".$_REQUEST['emp_id']." and test_type='CASE_STUDY' and `user_test_question_id`=".$case_study_question['casestudy_quest_id']);
			$empdetailcaseattach=UlsMenu::callpdorow("SELECT * FROM `uls_utest_attempts_assessment` WHERE `assessment_id`=".$_REQUEST['ass_id']." and `employee_id`=".$_REQUEST['emp_id']." and test_type='CASE_STUDY' and status='A'");
			$para10.='<br>
			<span style="color:#646464;font-size:11px;line-height: 1.5;">Q'.($key1+1).') '.$case_study_question['casestudy_quest'].'</span><br><br>
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
$pdf->Bookmark('4.'.($k+1).'. '.$testtype['assess_type'], 1, 0, '', '', array(0,0,0));
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
	
	

$results=$assessor=$comname=$comp_id=array();
foreach($ass_results as $key1=>$result){
	$comp_id[$result['comp_def_id']]="C".($key1+1);
	$comname[$result['comp_def_id']]=$result['comp_def_name'];
}

$para11='
<table cellspacing="0" cellpadding="0" border="0" >
    <tr>
        <td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">5. Radar Graph<br></span>		
	</td>
    </tr>
</table>
<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">It is important to understand that each role requires as certain set of competencies at a certain level of proficiency as detailed in the competency profile sheet.  While this is the requirement in terms of the position, based on the assessment, you have been found to be at a certain level.  The graphical representation of this relative information – between what is required of the job and what you posses is called a Competency Radar Graph.<br>
<table width="100%">
<tbody>
<tr>
<td width="50%"><img src="'.BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['ass_id'].'/'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'_radar.svg" style="width:350px;padding-top:10px;"/></td>
<td width="50%" align="top">';
$val_self=array_combine($comp_id,$comname);
foreach($val_self as $key => $val_selfs){
	$para11.=$key.'-'.$val_selfs.'<br>';
}
$para11.='</td>
			</tr>
		</tbody>
	</table>
	<br>
	<span style="font-size:9px;">In case the assessed level is exactly the same as required level, you will be able to see only Green line (Assessed Level)</span>
	<br>
	<p>In the current assessment process, you have been evaluated by more than one person; the assessed values shown in the graph above is the average of the assessment given by  the different assessors.  The average has been arrived at by a simple arithmetic mean.</p>
</div>';

// add a page
$pdf->AddPage();
$pdf->SetFooterMargin(5);
$pdf->Bookmark('5. Radar Graph', 0, 0, '', '', array(0,0,0));
$index_link = $pdf->AddLink();
$pdf->SetLink($index_link, 0, '*1');
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();
$tbl = <<<EOD
$para11
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

$para12='<table cellspacing="0" cellpadding="0" border="0" >
    <tr>
        <td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">6. Assessment Summary Sheet<br></span>		
	</td>
    </tr>
</table>
<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">In order to help you get a better understanding on the outcome of the assessment process, the various methods have been converted into numeric values.<br><br>
	<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#59b0ea" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5;">
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
		$para12.='<tr bgcolor="'.$bgcolor.'">';
		$para12.='<td width="6%">'.($i++).'</td>
		<td width="20%">';
				$ast=($assessor_ratings['assessment_type']!='TEST')?'<sup><font color="#FF0000">*</font></sup>':"";
				
		$para12.=$assessor_ratings['assess_type'].' '.$ast.'</td><td width="10%">';
		if($assessor_ratings['assessment_type']=='TEST'){
			$para12.=$assessor_ratings['test_ques'];
		}
		else{
			$para12.='NA';
		}
		$para12.='</td><td  width="12%">';
				if($assessor_ratings['assessment_type']=='TEST'){
					$score_test=$assessor_ratings['test_score'];
					$para12.=$score_test_f=$score_test;
				}
				else{
					$final=0;
					foreach($assessor_ratings['assessor'] as $key2=>$ass_id){
						$final=$final+$results[$key1]['assessor'][$key2];
					}
					$final=round($final/count($results[$key1]['assessor']),2);
					$score=round($final,2);
					$score_f=$score;
					$para12.=$score_f;
				}
				$para12.='</td>
				<td  width="12%">';
				if($assessor_ratings['assessment_type']=='TEST'){
					$score_test=(($assessor_ratings['test_score']/$assessor_ratings['test_ques'])*100);
					$para12.=$score_test;
				}
				else{
					$final=0;
					foreach($assessor_ratings['assessor'] as $key2=>$ass_id){
						$final=$final+$results[$key1]['assessor'][$key2];
					}
					$final=round($final/count($results[$key1]['assessor']),2);
					$score=(($final/$assessor_ratings['rating_scale'])*100);
					$para12.=$score;
				}
				
				$para12.='</td>
				<td  width="20%">'.$assessor_ratings['weightage'].'</td>
				<td  width="20%">';
				$score_final=$scorefinal=0;
				if($assessor_ratings['assessment_type']=='TEST'){
					$score_test=(($assessor_ratings['test_score']/$assessor_ratings['test_ques'])*100);
					$wei=$assessor_ratings['weightage'];
					$score_final=round((($score_test*$wei)/100),2);
					$para12.=$score_final;
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
					$para12.=$scorefinal;
				} 
				$wei_total=round($wei_total+($score_final+$scorefinal),2);
				$para12.='</td>
			</tr>';
		}
		$para12.='<tr style="font-size:18px;">
			<td colspan="5"  style="font-size:18px;">Overall Score</td>
			<td style="font-size:18px;">'.$wei_sum.'</td>
			<td style="font-size:18px;">'.$wei_total.'</td>
		</tr>
		</tbody>
	</table>
	<br>
	<div style="color:red; padding-left:5px; font-size:10px;">
	For In-basket and Case study, a rating scale of 1 to 4 was used<br>';
	foreach($ass_rating_scale as $key=>$ass_rating_scales){
		$g=($key!=0)?",":"";
		$para12.='<span>'.$g.' '.$ass_rating_scales['rating_number'].' - '.$ass_rating_scales['rating_name_scale'].'</span>';
	}
	$para12.='</div>
	<br style="clear:both;">
	<img src="'.BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['ass_id'].'/over_all_hr'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'.svg" style="width:600px;height:200px;" >';
	
	$ass_d="";
	foreach($testtypes as $testtype){
		if($testtype['assessment_type']=='TEST'){
			$ass_d.="<li>The ratings for MCQ are as derived from the system</li>";
			$ass_count=UlsAssessmentPositionAssessor::getassessors_details($_REQUEST['ass_id'],$_REQUEST['pos_id']);
			if(count($ass_count)==1){
				$ass_d.="<li>Ratings for the In-basket, Case study and Interview are based on the scale given above</li>";
			}
			else{
				$ass_d.="<li>Ratings given in this report are an average of all ratings given by external subject matter experts who acted as assessors for this assessment cycle.</li><li>Ratings for the In-basket, Case study and Interview are based on the scale given above</li>";  
			}
			$ass_d.="<li>The weightage factor, given above is as per the assessment details given in the earlier section of the report.</li>";
			$ass_d.="<li>In order to ensure a consistency of reporting of the assessment results, within a group, the percentile method has been used for computing the ratings /overall ratings.This means that the person who has performed the best has gets a 99.99 score and the rest are marked or calibrated in relation to this score.</li>";  
			$ass_d.="<li>No other information other than this assessment has been used for arriving at the above.</li>";
		}
		elseif($testtype['assessment_type']=='INTERVIEW'){
			$ass_count=UlsAssessmentPositionAssessor::getassessors_details($_REQUEST['ass_id'],$_REQUEST['pos_id']);
			if(count($ass_count)==1){
				$ass_d.="<li>Ratings for the In-basket, Case study and Interview are based on the scale given above</li>";
			}
			else{
				$ass_d.="<li>Ratings given in this report are an average of all ratings given by external subject matter experts who acted as assessors for this assessment cycle.<br>Ratings for the In-basket, Case study and Interview are based on the scale given above</li>";  
			}
			$ass_d.="<li>The weightage factor, given above is as per the assessment details given in the earlier section of the report.</li>";
			$ass_d.="<li>In order to ensure a consistency of reporting of the assessment results, within a group, the percentile method has been used for computing the ratings /overall ratings.This means that the person who has performed the best has gets a 99.99 score and the rest are marked or calibrated in relation to this score.</li>"; 
			$ass_d.="<li>No other information other than this assessment has been used for arriving at the above.</li>";
		}
		elseif($testtype['assessment_type']=='INBASKET'){
			$ass_d.="";
		}
		elseif($testtype['assessment_type']=='CASE_STUDY'){
			$ass_d.="";
		}
	}
	
	$para12.='<div style="font-size:10px;">Note:<br><ol>'.$ass_d.'</ol></div></div>';

// add a page
$pdf->AddPage();
$pdf->SetFooterMargin(5);
$pdf->Bookmark('6. Assessment Summary Sheet', 0, 0, '', '', array(0,0,0));
$index_link = $pdf->AddLink();
$pdf->SetLink($index_link, 0, '*1');
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();
$tbl = <<<EOD
$para12
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');



$para13='<table cellspacing="0" cellpadding="0" border="0" >
    <tr>
        <td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">7. Assessment Feedback & Development Road Map<br></span>
	</td>
    </tr>
</table>
<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">Appreciate the time you\'ve spent on undergoing the entire process. And, hope that the in-basket, case study and the interactive sessions were a value add to you.<br>
As mentioned in the introductory part of the report the entire Competency Mapping and Assessment process is for the purpose of enabling your development. In arriving at your Development needs/requirements, the Assessors have taken into consideration all the information available across the various Assessment Methods.<br>
Your performance in various assessment methods has been carefully analyzed and the following development roadmap has been recommended to further enhance your performance:<br><br>';
$result_ss=array();
foreach($ass_rating_comments as $ass_rating_comment){
	if(!empty($ass_rating_comment['comments'])){
		$result_ss[$ass_rating_comment['assessment_type']]['ass_type']=$ass_rating_comment['assessment_type'];
		$result_ss[$ass_rating_comment['assessment_type']]['assess_type']=$ass_rating_comment['assess_type'];
		$result_ss[$ass_rating_comment['assessment_type']]['comments'][$ass_rating_comment['assessor_id']]=ucfirst($ass_rating_comment['comments']);
	}
}
if(count($result_ss)>0){
	$i=1;
	foreach($result_ss as $key_i=>$ass_ratingcomment){
		$para13.='<span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 14px;color:#36a2eb; ">'.$ass_ratingcomment['assess_type'].'</span><ul>';
		foreach($ass_ratingcomment['comments'] as $key2=>$ass_id){
			$para13.='<li style="color:blue;line-height: 1.5;">'.$result_ss[$key_i]['comments'][$key2].'</li>';
		}
		$para13.='</ul>';
		$i++;
	}
}
$para13.='<br><br>
	<span style="font-size:8px;">Note: The comments and development guide lines are adverbatim, as given by the assessors,these could include comments on the performance in different assessment methods as well as development guidelines.<br>The development requirements identified by the assessors may be in the context of the current job as well as the future requirements. <br>Kindly focus on the development requirement identified.</span>
	<br><br>';

$para13.='</div>';

// add a page
$pdf->AddPage();
$pdf->SetFooterMargin(5);
$pdf->Bookmark('7. Assessment Feedback & Development Road Map', 0, 0, '', '', array(0,0,0));
$index_link = $pdf->AddLink();
$pdf->SetLink($index_link, 0, '*1');
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();
$tbl = <<<EOD
$para13
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

$para14='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;"><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 14px;color:#36a2eb; ">7.1. Competency Specific Development Plans</span><br>The following are competency specific development inputs given by the assessors.<br><br>
NOTE:  The development map against each of the competencies has been drawn taking into consideration the performance against different assessment methods and the assessor feedback (if any). Please note that in order to facilitate your development, the assessor and the system would ‘err’ in a manner which would enable your growth, and thus these following Training and Development needs are meant to ensure your further improvement. Hence, you may find that at times, although the Assessor(s) have commented that you have adequate knowledge, a Training Program may have been suggested for you.';
$assresults=UlsAssessmentTest::assessment_results_avg($_REQUEST['ass_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id']);
$results=$ass_comname=$ass_req_sid=$ass_given_sid=array();
foreach($assresults as $assresult){
	$compid=$assresult['comp_def_id'];
	$finalval=!empty($assresult['assessor_val'])?round(($assresult['ass_scale_number']*$assresult['assessor_val']),2):$assresult['ass_scale_number'];
	$results[$assresult['comp_def_id']]['comp_id']=$compid;
	$results[$assresult['comp_def_id']]['comp_name']=$assresult['comp_def_name'];
	$results[$assresult['comp_def_id']]['req_val']=$assresult['req_number'];
	$results[$assresult['comp_def_id']]['require_scale_id']=$assresult['require_scale_id'];
	$results[$assresult['comp_def_id']]['assessor'][$assresult['assessor_id']]=$finalval;
	$results[$assresult['comp_def_id']]['dev_area'][$assresult['assessor_id']]=$assresult['development_area'];
}
/* echo "<pre>";
print_r($results); */
$req_sid=$ass_sid=$comname=$compid=array();
$dev=array();

if(count($results)>0){
	foreach($results as $key1=>$result){
		$flag=0;
		$comp_id=$result['comp_id'];
		$comname=$result['comp_name'];
		$req_sid=$result['req_val'];
		$require_scale_id=$result['require_scale_id'];
		$final=0;
		foreach($result['assessor'] as $key2=>$ass_id){
			$final=$final+$results[$key1]['assessor'][$key2];
		}
		$final=round($final/count($results[$key1]['assessor']),2);
		$ass_sid=$final;
		
		foreach($result['dev_area'] as $key2=>$assid){
			$dev[$comp_id]=isset($dev[$comp_id])?$dev[$comp_id]." ".$results[$key1]['dev_area'][$key2]:$results[$key1]['dev_area'][$key2];
		}
		if($ass_sid<$req_sid){
			$flag=1;
		}
		$method_check=UlsAssessmentReportBytype::summary_detail_info_report($_REQUEST['ass_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id'],$comp_id);
		
		foreach($method_check as $method_checks){
			if($method_checks['assessment_type']=='INBASKET'){
				$req_level_bycomp=$method_checks['req_number'];
				$ass_level_bycomp=round($method_checks['ass_scale_number'],1);
				if($req_level_bycomp>$ass_level_bycomp){
					$flag=1;
				}
			}
			if($method_checks['assessment_type']=='CASE_STUDY'){
				$req_level_bycomp=$method_checks['req_number'];
				$ass_level_bycomp=round($method_checks['ass_scale_number'],1);
				$case_check=UlsAssessmentAssessorRating::get_ass_rating_report($_REQUEST['ass_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id'],'CASE_STUDY');
				if($req_level_bycomp>$ass_level_bycomp){
					$flag=1;
				}
				if($case_check['ass_rat']<3){
					$flag=1;
				}
			}
		}
		if($flag==1){
			if(!in_array($result['comp_id'],$compid)){
				$compid[]=$result['comp_id']."-".$require_scale_id;
			}
		}
	}
	
}
/* echo "<pre>";
print_r($compid); */
$para_data="";
if(!empty($compid)){
	foreach($compid as $compids){
		$comp_d=explode("-",$compids);
		$development=UlsCompetencyDefLevelTraining::getcompdeftraining($comp_d[0],$comp_d[1]);
		if(!empty($development)){
		$comp_name=UlsCompetencyDefinition::competency_detail_single($comp_d[0]);
		$para_data.='<br><br><br><span align="left" style="font-family: Helvetica;font-size: 13px;float:right;font-weight: bold;">Competency:</span><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 13px;color:#36a2eb; float:right;font-weight: bold;font-style: italic;">'.$comp_name['comp_def_name'].'</span><br><br>
		'.$development['program_obj'];
		if(!empty(trim($dev[$comp_d[0]]))){
			$para_data.='<br><br><b>Assessor Comments:</b><br><span style="font-style: italic;">'.$dev[$comp_d[0]].'</span>';
		}
		}
		else{
			$para_data.='';
		}
	}
}
else{
	$para_data.='';
}	
$para_data=trim($para_data);
$para_data=empty($para_data)?"<br><br><span align='center'>No Development Area</span>":$para_data;
// add a page
$pdf->AddPage();
$pdf->SetFooterMargin(5);
$pdf->Bookmark('7.1. Competency Specific Development Plans', 1, 0, '', '', array(0,0,0));
$index_link = $pdf->AddLink();
$pdf->SetLink($index_link, 0, '*1');
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();
$tbl = <<<EOD
$para14
$para_data
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');


 // add a page
$pdf->AddPage();
$pdf->footershow=false;
//$pdf->SetMargins(60, 200, PDF_MARGIN_RIGHT,true);
// -- set new background ---
$pdf->SetFooterMargin(10);
// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(false, 0);
//$pdf->SetAutoPageBreak(True, 0);
// set bacground image
$img_file = K_PATH_IMAGES.'adanipower/adani-power-backcover.jpg';
$pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
// restore auto-page-break status
//$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
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
$pdf->SetAutoPageBreak(True, 0);
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

$pdfname=str_replace(" ","_",'HR Assessment Report of '.$pdfname);
//Close and output PDF document
$pdf->Output($pdfname.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+