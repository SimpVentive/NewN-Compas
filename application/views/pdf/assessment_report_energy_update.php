<?php
ini_set('display_errors',1);
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
$pdf->SetFont('Helvetica', '', 11);

// add a page
$pdf->AddPage();
$pdf->footershow=false;
$pdf->SetFooterMargin(0);
// Print a text
$assdetails=UlsAssessmentDefinition::viewassessment($ass_id);
if(!empty($assdetails['assessment_id'])){
	//if($assdetails['ass_pos_view']=='Y'){
		//echo $posdetails['position_name'];
		if($posdetails['position_structure']=='A'){
			$pos_name=UlsPosition::pos_details($posdetails['position_structure_id']);
			$posname=$pos_name['position_name'];
		}
		else{
			$posname=$posdetails['position_name'];
		}
	/* }
	else{
		$posname="";
	} */
}
$txt='<label class="fish5" text-align="right;" width="100%"><b style="font-size:30pt;color:#fff;">Assessment Report</b></label><br><br><br>
<label class="fish6"><b style="font-size:26pt;color:#fff;"><br></b></label><br><br><br>
<img src="'.LOGO_IMG_PDF.'" style="margin:0.15cm 0.2cm" width="200"  class="fish"><br><br><br>
<label class="fish1"><b style="font-size:22pt;color:#000;">'.trim($emp_info['name']).'</b><br><b style="font-size:14pt;color:#000;">'.@$posname.'</b></label>';
	
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
$para2="The report is a part of the Techincal/ Functional Assessment process of ".trim($emp_info['name']).", ".$posname;
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
$read="";
if($assposdetail['assessor_process']=='N'){
	$read="<li>Development road map information.<br></li>";
}
else{
	$read="<li>Development road map information as suggested by the assessors.<br></li>";
}

$tbl = <<<EOD
<table cellspacing="0" cellpadding="0" border="0" >
    <tr>
        <td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">1. Introduction</span>		
	</td>
    </tr>
</table>
<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">
	<br><span align="left" style="font-family: Helvetica;font-size: 14px;color:#36a2eb; line-height:1.5;">WHAT IS THIS ALL ABOUT<br></span>
	As you know the organization is constantly in the process of improving the capability platform of employees, so as to enable them reach their true potential.  As a part of this, the organization has drawn-up an ambitious process of Technical and Functional Competency assessment and development process, with an end objective of FOCUSED LEARNING AND DEVELOPMENT FOR EACH INDIVIDUAL.<br><br><br>
	
	<span align="left" style="font-family: Helvetica;font-size: 14px;color:#36a2eb; line-height:1.5;">WHAT IS THE BASIC FRAMEWORK OF THIS PROCESS?<br></span>
	This process has been developed based on the following
	<ol>
	<li>Every job in the organization has a set of accountabilities, which are measured in terms of the outcomes, referred to as KRAs.  These (KRAs), in order to be achieved, would require a certain set of Competencies. These competencies in turn are clasified along the Technical, Functional, Managerial and Leadership dimensions.<br></li>
	<li>Based on the various positions in the organization, a complete set of Technical Competencies have been identified (please refer to the competency dictionary available at www.N-Compas.com) for the Renewable Energy Business (Solar & Wind).<br></li>
	<li>Each position has been defined in terms of the competency requirement, referred to as Competency Profile.<br></li>
	<li>In order to assess an individual on these competencies a set of methods have been identified, which are different for different positions.  Those relevant for your position are given, and detailed in the following section.<br></li>
	</ol><br><br><br>
	
	<span align="left" style="font-family: Helvetica;font-size: 14px;color:#36a2eb; line-height:1.5;">WHAT ARE THE ASSESSMENT METHODS USED?<br></span>
	Based on the position, you will be having a combination of the following assessment methods<br><br>
	<b>MCQ or Multiple Choice Questions:</b><br>These are questions which are based on your product, process/SOP and related aspects.<br><br>
	<b>In-basket Exercises:</b><br>As an executive, your day comprises of a number of activities. How you organize your day, both in terms of time - prioritization and the quality of action - how you choose to act or what you delegate, reflects on your capabilities.<br><br>
	<b>Caselets:</b><br>These are small situational narratives which have been built around your typical issues/aspects which you encounter in your every day work.  How you handle these reflects your technical and to some extent managerial capabilities as well<br><br>
	<b>Cases: </b> <br>These are usually ‘third party’ situational constructs where-in you have to analyze the same and provide your perspective on how you would deal with various aspects therein (as given in the case questions).<br><br>
	<b>Fishbone Analysis: </b> <br>The candidate is presented with a potential problem and is asked to categorize the root causes of the problem.<br><br>
	<span align="left" style="font-family: Helvetica;font-size: 14px;color:#36a2eb; line-height:1.5;">WHAT IS THE SCOPE OF THIS ASSESSMENT?<br></span>
	In this cycle we will be assessing only technical/functional competencies and drawing of the Development Road Map for them.<br><br><br><br>
	<div style="page-break-after: always;"></div>
	<span align="left" style="font-family: Helvetica;font-size: 14px;color:#36a2eb; line-height:1.5;">HOW TO READ THIS REPORT?<br></span>
	This report has the following
	<ol>
	<li>Your job description, including the competency profile.  This profile information was used in creating the assessment<br></li>
	<li>A Radar graph showing the competency requirement of your job, and how you were assessed each of these, using various methods<br></li>
	<li>A consolidated assessment summary sheet<br></li>
	$read
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
$grade=!empty($posname)?$posdetails['grade_name']:"-";
$jd='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">
	<h4 class="titleheader">Position Details</h4>
	<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#5b9bd5" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5; border:0.5px solid #9999;">
		<tbody>
		<tr bgcolor="#deeaf6">
		<td class="normal"  style="width:15%"><b>Job Title</b></td>
		<td class="normal"  style="width:35%">'.@$posname.'</td>
		<td class="normal"  style="width:15%"><b>Grade/Level</b></td>
		<td class="normal"  style="width:35%">'.$grade.'</td>
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

	$jd.='</div>';$name=$posname;
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
$posi=!empty($posname)?$posname:"Position";
$para3='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">The '.$posi.', whose description is provided in the above section, would require Competencies – Functional, Technical, Managerial and Behavioural, to ensure that the objectives/goals or KRAs are achieved.  However, not all the competencies, are required at the same Levels of Proficiency or the same level of Criticality.  The process of mapping the position in terms of required Competencies – the Levels and the Criticality is  referred to as Profiling.<br>
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
$para13='';

$para13.='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;"><span align="left" style="font-family: Helvetica;font-size: 14px;color:#36a2eb;line-height: 1.5;">COMPETENCY/SKILL REQUIREMENTS<br></span>';
$posi_data=!empty($posname)?" of".$posname:"";
$para13.='The following are the competencies required for the position '.$posi_data.'. This is also reffered to as Competency Profilling';
foreach($category as $categorys){
	$ass_comp_info=UlsAssessmentReport::getassessment_admin_competency($ass_id,$pos_id,$categorys['category_id']);	
	$para13.='<br><br><span align="left" style="text-transform: uppercase; font-family: Helvetica;font-size: 14px;color:#36a2eb; line-height: 1.5;">'.$categorys['name'].'</span><br><br>';
	$para13.='<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#59b0ea" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5; border:0.5px solid #9999;">
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
		$results[$comp_id]['comp_name']=!empty($ass_comp_infos['comp_def_name_alt'])?$ass_comp_infos['comp_def_name_alt']:$ass_comp_infos['comp_def_name'];
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
		$para13.='<tr bgcolor="'.$bgcolor.'">
		<td>'.$result['comp_name'].'</td>
		<td>'.$result['req_scale_name'].'</td>
		<td>'.$result['comp_cri_name'].'</td>		
		</tr>';
	}
	$para13.='</tbody>
	</table>';
}
$para13.='</div>';		
$tbl = <<<EOD

$para13
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

// add a page
$pdf->AddPage();
$pdf->footershow=true;
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
<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#59b0ea" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5; border:0.5px solid #9999;">
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

$results=$assessor=$comname=$comp_id=array();
foreach($ass_results as $key1=>$result){
	//$finalval=!empty($result['assessor_val'])?round(($result['ass_scale_number']*$result['assessor_val']),2):$result['ass_scale_number'];
	$comp_id[$result['comp_def_id']]="C".($key1+1);
	$comname[$result['comp_def_id']]=!empty($result['comp_def_name_alt'])?$result['comp_def_name_alt']:$result['comp_def_name'];
	/* $results[$result['comp_def_id']]['req_val']=$result['req_number'];
	$results[$result['comp_def_id']]['assessor'][$result['assessor_id']]=$finalval; */
}
/* echo "<pre>";
print_r($results); */
$para11='<table cellspacing="0" cellpadding="0" border="0" >
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
/* echo "<pre>";
print_r($val_self); */
$n=1;
foreach($val_self as $key => $val_selfs){
	$para11.="C".$n.'-'.$val_selfs.'<br>';
	$n++;
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
$pdf->footershow=true;
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
$para11_com='';
$para11_com='<table cellspacing="0" cellpadding="0" border="0" >
    <tr>
        <td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right"></span>		
	</td>
    </tr>
</table>
<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">
	<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#59b0ea" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5; border:0.5px solid #9999;">
	<thead><tr height="30" bgcolor="#59b0ea" align="center" class="row header" style="color:#fff;">
		<th width="7%">S.No</th>
		<th width="20%">Competency/Skill</th>
		<th width="10%">Req Level </th>';
		foreach($assmethods as $ass_methodss){
			
			if($ass_methodss['assessment_type']=='TEST'){
				$para11_com.='<th width="12%">'.$ass_methodss['assess_type'].'</th>';
			}
			if($ass_methodss['assessment_type']=='INBASKET'){
				$para11_com.='<th width="12%">'.$ass_methodss['assess_type'].'</th>';
			}
			if($ass_methodss['assessment_type']=='CASE_STUDY'){
				$para11_com.='<th width="12%">'.$ass_methodss['assess_type'].'</th>';
			}
		}
		$para11_com.='<th width="15%">Weighted Average Assessed Level</th>';
		$para11_com.='<th width="10%">Difference in Assessed and Req Level </th>';
		$para11_com.='</tr>
	</thead>
	<tbody>';
	$results_data=array();
	foreach($assresults as $assresult){
		$compid=$assresult['comp_def_id'];
		if($assposdetail['assessor_process']=='N'){
			$finalval=!empty($assresult['assessor_val'])?round(($assresult['ass_number']*$assresult['assessor_val']),2):$assresult['ass_number'];
		}
		else{
			$finalval=!empty($assresult['assessor_val'])?round(($assresult['ass_scale_number']*$assresult['assessor_val']),2):$assresult['ass_scale_number'];
		}
		$results_data[$assresult['comp_def_id']]['comp_id']=$compid;
		$results_data[$assresult['comp_def_id']]['comp_name']=!empty($assresult['comp_def_name_alt'])?$assresult['comp_def_name_alt']:$assresult['comp_def_name'];
		$results_data[$assresult['comp_def_id']]['req_val']=$assresult['req_number'];
		$results_data[$assresult['comp_def_id']]['assessor'][$assresult['assessor_id']]=$finalval;
	}
	$kk=0;
	$nn=1;
	if(count($results_data)>0){
		foreach($results_data as $key1=>$result){
			$bgcolor=($kk%2==0)?"#deeaf6":"#ffffff";
			$kk++;
			$para11_com.='<tr bgcolor="'.$bgcolor.'">
			<td width="7%" align="center">'.$nn.'</td>
			<td width="20%">'.$result['comp_name'].'</td>
			<td width="10%" align="center">'.$result['req_val'].'</td>';
			$final=0;
			foreach($result['assessor'] as $key2=>$ass_id){
				$final=$final+$results_data[$key1]['assessor'][$key2];
			}
			$final=round($final/count($results_data[$key1]['assessor']),2);
			foreach($assmethods as $ass_methodss){
				if($ass_methodss['assessment_type']=='TEST'){
					$ass_comp_test=UlsAssessmentReport::admin_position_assessed_competency_level_test($_REQUEST['ass_id'],$_REQUEST['pos_id'],$result['comp_id'],$_REQUEST['emp_id']);
					$para11_com.='<td width="12%" align="center">'.(!empty($ass_comp_test['ass_ave'])?round($ass_comp_test['ass_ave'],2):"-").'</td>';
				}
				if($ass_methodss['assessment_type']=='INBASKET'){
					$ass_comp_inbasket=UlsAssessmentReport::admin_position_assessed_competency_level_inbasket($_REQUEST['ass_id'],$_REQUEST['pos_id'],$result['comp_id'],$_REQUEST['emp_id']);
					$para11_com.='<td width="12%" align="center">'.(!empty($ass_comp_inbasket['ass_ave'])?round($ass_comp_inbasket['ass_ave'],2):"-").'</td>';
				}
				if($ass_methodss['assessment_type']=='CASE_STUDY'){
					$ass_comp_case=UlsAssessmentReport::admin_position_assessed_competency_level_case($_REQUEST['ass_id'],$_REQUEST['pos_id'],$result['comp_id'],$_REQUEST['emp_id']);
					$para11_com.='<td width="12%" align="center">'.(!empty($ass_comp_case['ass_ave'])?round($ass_comp_case['ass_ave'],2):"-").'</td>';
				}
			}
			
			$para11_com.='<td width="15%" align="center">'.$final.'</td>';
			$para11_com.='<td width="10%" align="center">'.($final-$result['req_val']).'</td>';
			$para11_com.='</tr>';
			$nn++;
		}
		
	}
	
	$para11_com.='</tbody>
	</table>
</div>';

// add a page
$pdf->AddPage();
$pdf->footershow=true;
$pdf->SetFooterMargin(5);
$index_link = $pdf->AddLink();
$pdf->SetLink($index_link, 0, '*1');
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();

$tbl = <<<EOD
$para11_com
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

$para12='<table cellspacing="0" cellpadding="0" border="0" >
    <tr>
        <td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">6. Assessment Summary Sheet<br></span>		
	</td>
    </tr>
</table>
<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">In order to help you get a better understanding on the outcome of the assessment process, the various methods have been converted into numeric values.<br><br>
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
		$para12.='<tr bgcolor="'.$bgcolor.'">
		<td width="6%">'.($i++).'</td>
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
	For In-basket or Case study and Fishbone, a rating scale of 1 to 4 was used<br>';
	foreach($ass_rating_scale as $key=>$ass_rating_scales){
		$g=($key!=0)?",":"";
		$para12.='<span>'.$g.' '.$ass_rating_scales['rating_number'].' - '.$ass_rating_scales['rating_name_scale'].'</span>';
	}
	$para12.='</div>
	<br style="clear:both;">
	<img src="'.BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['ass_id'].'/over_all'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'.svg" style="width:600px;height:100px;" >';
	
	$ass_d="";
	foreach($testtypes as $testtype){
		if($testtype['assessment_type']=='TEST'){
			$ass_d.="<li>The ratings for MCQ are as derived from the system</li>";
			$ass_count=UlsAssessmentPositionAssessor::getassessors_details($_REQUEST['ass_id'],$_REQUEST['pos_id']);
			if(count($ass_count)==1){
				$ass_d.="<li>Ratings for the In-basket, Case study, Fishbone and Interview are based on the scale given above</li>";
			}
			else{
				$ass_d.="<li>Ratings given in this report are an average of all ratings given by external subject matter experts who acted as assessors for this assessment cycle.</li><li>Ratings for the In-basket, Case study and Interview are based on the scale given above</li>";  
			}
			$ass_d.="<li>The weightage factor, given above is as per the assessment details given in the earlier section of the report.</li>";
			if($assposdetail['assessor_process']=='N'){
				$ass_d.="<li>In order to ensure a consistency of reporting of the assessment results, within a group, the percentile method has been used for computing the ratings /overall ratings.This means that the person who has performed the best has gets a 99.99 score and the rest are marked or calibrated in relation to this score.</li>";
			}				
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
$pdf->footershow=true;
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


if($assposdetail['assessor_process']=='N'){
	$comments_admin=$final_deve_comments['comments'];
$para52="";
$para52.='<table cellspacing="0" cellpadding="0" border="0" >
    <tr>
        <td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">7. DEVELOPMENT ROAD MAP<br></span>
	</td>
    </tr>
</table>
<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">
	Appreciate the time you\'ve spent undergoing the entire process. And, hope that the Test, In-basket, and the Fish Bone Analysis were a value add to you. As mentioned in the introductory part of the report the entire Competency Mapping and Assessment process is for the purpose of enabling your development.<br><br>
	In arriving at your Development needs/requirements, the information available across the various Assessment Methods has been taken into consideration.<br><br>
	Your performance in various assessment methods has been carefully analyzed and the following development roadmap has been recommended to further enhance your performance:<br><br>';
	
	$rat_number="";
	if($weitotal>85){
		$rat_number=4;
		//$rating_id_scale="Very Good";
	}
	elseif($weitotal>=65 && $weitotal<=84.9){
		$rat_number=3;
	}
	elseif($weitotal>=45 && $weitotal<=64.9){
		$rat_number=2;
	}
	else{
		$rat_number=1;
	}
	//echo $weitotal."-".$rat_number;
	$rat_scale_name=UlsRatingMasterScale::ratingscale_number($assdetail_data['rating_id'],$rat_number);
	//$para52.="The candidate's overall performance was found to be <b>".$rat_scale_name['rating_name_scale']."</b>.<br><br>";
	$para52.=$comments_admin;
	$para52.='<br><br>
	<span style="font-size:8px;">Note: The development map against each of the competencies has been drawn taking into consideration the performance against different assessment methods.
	Please note that in order to facilitate your development, the system would ‘err’ in a manner which would enable your growth, and thus the Training and Development needs identified are aimed at your futuristic growth and development.
	</span>
	<br><br>
</div>';
	
	
	
// add a page
$pdf->AddPage();
$pdf->footershow=true;
$pdf->SetFooterMargin(5);
$pdf->Bookmark('7. Development Road Map', 0, 0, '', '', array(0,0,0));
$index_link = $pdf->AddLink();
$pdf->SetLink($index_link, 0, '*1');
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();
$tbl = <<<EOD
$para52
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');


	
}
else{


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
		$para13.='<span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 14px;color:#36a2eb; ">'.trim($ass_ratingcomment['assess_type']).'</span><ul>';
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
$pdf->footershow=true;
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
NOTE: The development map against each of the competencies has been drawn taking into consideration the performance against different assessment methods and the assessor feedback (if any). Please note that in order to facilitate your development, the assessor and the system would ‘err’ in a manner which would enable your growth, and thus these following Training and Development needs are meant to ensure your further improvement. Hence, you may find that at times, although the Assessor(s) have commented that you have adequate knowledge,or skills, or exposure, a Training Program may have been suggested for you, nonetheless. 
<br>
The plan detailed below, gives an extensive list of all the probable training areas, across the various elements of each of the Competencies (in which the employee has been assessed to be lower than the required level).  The employee, along with HR and Reporting manager may want to identify the most important area/aspect of the competency, to be taken up on priority.   ';
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
$req_sid=$ass_sid=$comname=$compid=$compidh=array();
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
		/* if(($ass_sid<$req_sid)){
			$flag=1;
		}
		if($ass_sid<=($req_sid) && $req_sid==1){
			$flag=1;
		} */
		if($ass_sid>$req_sid){
			$flag=2;
		}
		$method_check=UlsAssessmentReportBytype::summary_detail_info_report($_REQUEST['ass_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id'],$comp_id);
		
		foreach($method_check as $method_checks){
			if($method_checks['assessment_type']=='TEST'){
				$req_level_bycomp=$method_checks['req_number'];
				$ass_level_bycomp=round($method_checks['ass_scale_number'],1);
				if($req_level_bycomp>$ass_level_bycomp){
					$flag=1;
				}
				else{
					$flag=2;
				}
			}
			if($method_checks['assessment_type']=='INBASKET'){
				$req_level_bycomp=$method_checks['req_number'];
				$ass_level_bycomp=round($method_checks['ass_scale_number'],1);
				if($req_level_bycomp>$ass_level_bycomp){
					$flag=1;
				}
				else{
					$flag=2;
				}
			}
			if($method_checks['assessment_type']=='CASE_STUDY'){
				$req_level_bycomp=$method_checks['req_number'];
				$ass_level_bycomp=round($method_checks['ass_scale_number'],1);
				if($req_level_bycomp>$ass_level_bycomp){
					$flag=1;
				}
				else{
					$flag=2;
				}
			}
		}
		if($flag==1){
			if(!in_array($result['comp_id'],$compid)){
				$compid[]=$result['comp_id']."-".$require_scale_id;
			}
		}
		if($flag==2){
			if(!in_array($result['comp_id'],$compidh)){
				$compidh[]=$result['comp_id']."-".$require_scale_id;
			}
		}
	}
	
}
/* echo "<pre>";
print_r($dev); */
/* echo "<pre>";
print_r($compid); */
$para_data="";

foreach($dev as $com=>$devs){
	$ass_comments=!empty($devs)?$devs:"No Comments/Feedback by Assessors";
	$comp_name=UlsCompetencyDefinition::competency_detail_single($com);
	$com_detail=!empty($comp_name['comp_def_name_alt'])?$comp_name['comp_def_name_alt']:$comp_name['comp_def_name'];
	$para_data.='<br><span align="left" style="font-family: Helvetica;font-size: 13px;float:right;font-weight: bold;">Competency:</span><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 13px;color:#36a2eb; float:right;font-weight: bold;font-style: italic;">'.$com_detail.'</span><br>
	<b>Assessor Comments:</b><br><span style="font-style: italic;">'.$ass_comments.'</span><br><br>';
	if(!empty($compid)){
		foreach($compid as $compids){
			$comp_d=explode("-",$compids);
			if($comp_d[0]==$com){
			//echo $comp_d[0]."-".$comp_d[1]."<br>";
			
				//$ass_test=UlsAssessmentTest::get_ass_position($_REQUEST['ass_id'],$_REQUEST['pos_id'],'TEST');
				//$element_pro=UlsCompetencyDefLevelIndicatorPrograms::element_program_details($_REQUEST['ass_id'],$_REQUEST['pos_id'],$ass_test['assess_test_id'],$ass_test['test_id'],$comp_d[0],$comp_d[1],$emp_id);
				$element_pro=UlsCompetencyDefLevelIndicatorPrograms::getcompdeflevelind_details($comp_d[0],$comp_d[1]);
				if(count($element_pro)>0){
					foreach($element_pro as $element_pros){
						$para_data.='<b>Element Name: '.$element_pros['comp_def_level_ind_name'].'</b> <br>';
						$para_data.='Indicative Programs: <span align="left" style="font-family: Helvetica;font-size: 10px;">'.$element_pros['program_name'].'</span><br>';
					}
				}
				else{
					$para_data.='<br>Indicative Programs:<br>
					No programs available<br>';
				}
			}
			
		}
	}
	if(!empty($compidh)){
		foreach($compidh as $compidhs){
			$compd=explode("-",$compidhs);
			if($compd[0]==$com){
				$para_data.='<br>Specific development needs have not been identified <br>';
			}
		}
	}
	/* else{
		$para_data.='<br>Indicative Programs:<br>
					No programs available<br>';
	} */
}

 
//print_r($para_data);	
$para_data=trim($para_data);
//<br><br><span align='center'>No Development Area</span>
$para_data=empty($para_data)?"":$para_data;
$para_datah="";
if(!empty($compidh)){
	foreach($compidh as $compidhs){
		$comp_d=explode("-",$compidhs);
		$comp_name=UlsCompetencyDefinition::competency_detail_single($comp_d[0]);
		$com_detail=!empty($comp_name['comp_def_name_alt'])?$comp_name['comp_def_name_alt']:$comp_name['comp_def_name'];
		$para_datah.='<br><br><br><span align="left" style="font-family: Helvetica;font-size: 13px;float:right;font-weight: bold;">Competency:</span><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 13px;color:#36a2eb; float:right;font-weight: bold;font-style: italic;">'.$com_detail.'</span><br>';
		
		if(!empty(trim($dev[$comp_d[0]]))){
			$para_datah.='<b>Assessor Comments:</b><br><span style="font-style: italic;">'.$dev[$comp_d[0]].'</span>';
		}
		
	}
}
else{
	$para_datah.='';
}
//print_r($para_data);	
$para_datah=trim($para_datah);
$para_datah=empty($para_datah)?"<br><br><span align='center'></span>":$para_datah;
// add a page
$pdf->AddPage();
$pdf->footershow=true;
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
$para_datah
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
}

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
$img_file = K_PATH_IMAGES.'seedworks/adani-power-backcover.jpg';
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