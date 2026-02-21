<?php
ini_set('display_errors',1);
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
		$img_file = K_PATH_IMAGES.'adanipower/competencyassessmentbooklet_new.jpg';
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
				<td width="95%" style="text-align:left;"><img src="'.LOGO_IMG_PDF.'" style="margin:0.15cm 0.2cm" height="35"> </td>
				
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
					</table>';
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

// set default font subsetting mode
$pdf->setFontSubsetting(true);
// ---------------------------------------------------------
$fontname = TCPDF_FONTS::addTTFfont('/var/www/adani-energy.n-compas.com/public_html/application/libraries/tcpdf/fonts/hope.ttf', 'TrueTypeUnicode', '', 96);

//$fontname = TCPDF_FONTS::addTTFfont('../fonts/ARIAL.ttf', 'TrueTypeUnicode', '', 96);
// use the font
$pdf->SetFont($fontname, '', 14, '', false);
// set font
//$pdf->SetFont('Helvetica', '', 11);

// add a page
$pdf->AddPage();
$pdf->footershow=false;
$pdf->SetFooterMargin(0);
// Print a text
if($posdetails['position_structure']=='A'){
	$pos_name=UlsPosition::pos_details($posdetails['position_structure_id']);
	$posname=$pos_name['position_name'];
}
else{
	$posname=$posdetails['position_name'];
}



$txt='<label class="fish1"><b style="font-size:18pt;color:#000;font-family: Helvetica;">'.@$posname.'</b></label><br><br><img src="'.LOGO_IMG_PDF.'" style="margin:0.15cm 0.2cm" height="35">';
	
$html = <<<EOD
<table cellspacing="0" width="100%" cellpadding="5" border="0" >
	<tr>
		<td width="100%" height="400pt" colspan="3" align="center">&nbsp;</td>
	</tr>	
	<tr>
		<td width="100%" colspan="3" align="center">$txt</td>
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
$para1="NOTE:This report and its contents are the property of ".@$posdetails['parent_organisation']." and no portion of the same should be copied or reproduced without the prior permission of ".@$posdetails['parent_organisation'];
$para2="The Assessment Booklet is for the position of ".trim(@$posname);
$tbl = <<<EOD
<div style="height: 750pt;bottom:0px;">&nbsp;<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></div>

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
$condata="";$condata2="";
if($_REQUEST['pos_type']=='NMS'){
	$condata='<li>Based on the various positions in the organization, a complete set of Technical Competencies have been identified.<br></li>
	<li>In order to assess the individual on these competencies a set of methods have been identified, which are different for different positions. Those relevant for your position are given, and detailed in the following section.<br></li>';
	$condata2='In this cycle we will be assessing only technical/functional competencies as a part of the Promotion process for NMS (Non-Management Staff) to MS (Management Staff) using a process, Multiple Choice Questions (MCQs).';
}
else{
	$condata='<li>Based on the various positions in the organization, a complete set of Technical Competencies have been identified (please refer to the competency dictionary available at www.N-Compas.com) for the <b>Cement Business</b>.<br></li>
	<li>Each position has been defined in terms of the competency requirement, referred to as Competency Profile.<br></li>
	<li>In order to assess an individual on these competencies a set of methods have been identified, which are different for different positions.  Those relevant for your position are given, and detailed in the following section.<br></li>';
	$condata2='This assessment will focus on evaluating the incumbents technical/functional and managerial/behavioural competencies, and will culminate in a tailored development roadmap.<br><br>
	<span align="left" style="font-family: Helvetica;font-size: 14px;color:#36a2eb; line-height:1.5;">WHAT IS THE OUTCOME OF THIS ASSESSMENT <br></span>
	You will get a complete report, which will help you understand the assessment results.  Based on this, you will be getting an Individual Development Plan called, CO-RAMP &copy; Competency Development Road Map, which will be used for your learning, and development process.';
}
$tbl = <<<EOD
<table cellspacing="0" cellpadding="0" border="0" >
    <tr>
        <td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">1. Introduction</span>		
	</td>
    </tr>
</table>
<div style="font-family: Helvetica;font-size:11px;line-height: 1.35;color:#646464;">
	<br><span align="left" style="font-family: Helvetica;font-size: 14px;color:#36a2eb; line-height:1.5;">WHAT IS THIS ALL ABOUT?<br></span>
	As you know the organization is constantly in the process of improving the capability platform of employees, so as to enable them reach their true potential.  As a part of this, the organization has drawn-up an ambitious process of Technical and Functional Competency assessment and development process, with an end objective of FOCUSED LEARNING AND DEVELOPMENT FOR EACH INDIVIDUAL.<br><br>
	
	<span align="left" style="font-family: Helvetica;font-size: 14px;color:#36a2eb; line-height:1.5;">WHAT IS THE BASIC FRAMEWORK OF THIS PROCESS?<br></span>
	This process has been developed based on the following
	<ol>
	<li>Every job in the organization has a set of accountabilities, which are measured in terms of the outcomes, referred to as KRAs.  These (KRAs), in order to be achieved, would require a certain set of Competencies. These competencies in turn are classified along the Technical, Functional, Managerial and Leadership dimensions.<br></li>	
	$condata
	</ol><br>
	
	<span align="left" style="font-family: Helvetica;font-size: 14px;color:#36a2eb; line-height:1.5;">WHAT ARE THE ASSESSMENT METHODS USED?<br></span>
	Based on the position, you will be having a combination of the following assessment methods<br><br>
	<b>MCQ or Multiple Choice Questions</b><br>These are questions which are based on your product, process/SOP and related aspects.<br><br>
	<b>In-basket Exercises</b><br>As an executive, your day comprises of a number of activities. How you organize your day, both in terms of time - prioritization and the quality of action - how you choose to act or what you delegate, reflects on your capabilities.<br><br>
	<b>Caselets</b><br>These are small situational narratives which have been built around your typical issues/aspects which you encounter in your every day work.  How you handle these reflects your technical and to some extent managerial capabilities as well<br><br>
	<!--<b>Cases </b> <br>These are usually ‘third party’ situational constructs where-in you have to analyze the same and provide your perspective on how you would deal with various aspects therein (as given in the case questions).-->
	<b>360° Feedback</b><br>A 360° feedback process gathers structured inputs from an employee’s managers, peers, subordinates, and other stakeholders to offer a holistic view of behavioural strengths and development areas. It helps identify blind spots, enhances self-awareness, and anchors personalised development plans.<br><br>
	<b>Jungian Personality Test</b><br>Rooted in Carl Jung’s psychological typologies, this assessment identifies natural preferences in how individuals perceive information, make decisions, and interact with the world. It offers deep insights into personality patterns, communication styles, and team compatibility.<br><br>
	<b>Assessment Centre</b><br>The Assessment Centre will include a structured personal interview and a presentation round. Candidates will present the case study they solved during the pre-assessment, followed by a focused competency-based interview. This offers a quick, reliable view of both their analytical ability and behavioural strengths.<br><br>
	<span align="left" style="font-family: Helvetica;font-size: 14px;color:#36a2eb; line-height:1.5;">WHAT IS THE SCOPE OF THIS ASSESSMENT?<br></span>
	$condata2
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
		<td class="normal"  style="width:35%">'.@$posname.'</td>
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
$para3='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">The '.$posi.', whose description is provided in the above section, would require Competencies – Technical, to ensure that the objectives/goals or KRAs are achieved.  However, not all the competencies, are required at the same Levels of Proficiency or the same level of Criticality.  The process of mapping the position in terms of required Competencies – the Levels and the Criticality is  referred to as Profiling.<br>
The definition of various Levels of Proficiency and the Criticality Dimensions are given here under.<br><br>
In case of Technical Competencies there are Four Level of proficiency.<br><br>';
$para_new='<br><br>';
foreach($scale_info_four as $key=>$scale_infos){
	$para_new.='<b style="font-size:13px;">'.$scale_infos['scale_name'].':&nbsp;</b><span style="font-size:12px;">'.$scale_infos['description'].'</span>';
	if((count($scale_info_four)-1)!=$key){
		$para_new.='<hr style="line-height:22px">';
	}
	
	
}
$left_image='<img src="'.BASE_URL.'/public/Picture122.png">';
$right_image='<img src="'.BASE_URL.'/public/Picture34.png">';
$para3.='<table width="100%" style="font-family: Helvetica;font-size:14px;color:#646464;">
	<tr>
		<td  width="10%">'.$left_image.'</td>
		<td  width="50%">'.$para_new.'</td>
		<td  width="40%">'.$right_image.'</td>
	</tr>
</table>';	
if(count($scale_info_five)>0){
	$para3.='<br>For Managerial/ Behavioural Competencies there are Five Levels scale of profficiency as given below.<br><br>';
	foreach($scale_info_five as $scale_infoss){
		$para3.='<b style="font-size:11px;">'.$scale_infoss['scale_name'].':&nbsp;</b> '.$scale_infoss['description'].'<br><br>';
	}
}
$para3.='<br><br>The second dimension, in Competency Profiling is called the Level of Criticality, which in turn is split into '.count($cri_info).' categories<br><br>';
foreach($cri_info as $k=>$cri_infos){
	$para3.=$k!=0?'<br><br>':'';
	$para3.='<b style="font-size:11px;">'.$cri_infos['name'].':</b> '.$cri_infos['description'];
}

$para3.='</div>';

$para3.='</div>';

//$para3.='<img src="'.BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['ass_id'].'/level_svg_graph'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'.svg" width="900">';	

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

/*
$para3='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">The Job, '.$posdetails['position_name'].' whose description is provided in the above section, would require Competencies – Functional, Technical, Managerial and Behavioural, to ensure that the objectives/goals or KRAs are achieved.  However, not all the competencies, are required at the same Levels of Proficiency or the same level of Criticality.  The process of mapping the position in terms of required Competencies – the Levels and the Criticality is  referred to as Profiling.<br>
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
$para3.='<br><br><br>In the process of assessment or interviewing, it is preferable to focus first on the Critical competencies and then on those that are classified as Important. If time permitting, those in the Less Important category can be touched upon.</div>';

	
$tbl = <<<EOD
<table cellspacing="0" cellpadding="0" border="0" >
    <tr>
        <td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">3. Competency Profile<br></span>
	</td>
    </tr>
</table>
$para3
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');*/




	


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
$para123='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;"><span align="left" style="font-family: Helvetica;font-size: 14px;color:#36a2eb;line-height: 1.5;">COMPETENCY/SKILL REQUIREMENTS<br></span>';
	$para123.='The following are the competencies required for the position of '.trim($posname).'. This is also referred to as Competency Profiling';
	foreach($category as $categorys){
		if($categorys['category_id']!=4){
		 $ass_comp_info=UlsAssessmentReport::getassessment_admin_competency($ass_id,$pos_id,$categorys['category_id']);	
		$para123.='<br><p align="left" style="text-transform: uppercase; font-family: Helvetica;font-size: 14px;color:#36a2eb; line-height: 1.5;">'.trim($categorys['name']).'</p><br>
		<table align="left" cellspacing="0" border="0.5px" bordercolor="#59b0ea" cellpadding="5" style="width:100%; font-family: Helvetica; color:#646464; font-size:11px;"><tr height="30" bgcolor="#59b0ea" align="center" style="color:#fff;"><th>Competency/Skill</th><th>Level Requirement</th><th>Criticality</th></tr><tbody> ';
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
		}
		$kk=0;
		foreach($results as $comp_def_id=>$result){
			$final_admin_id=$_SESSION['user_id'];
			$bgcolor=($kk%2==0)?"#deeaf6":"#ffffff";
			$kk++;
			$para123.='<tr bgcolor="'.$bgcolor.'">
			<td>'.trim($result['comp_name']).'</td>
			<td>'.trim($result['req_scale_name']).'</td>
			<td>'.trim($result['comp_cri_name']).'</td>
			</tr>';
		}
		$para123.='</tbody></table>';
		}
	}
	$para123.='</div>';
$tbl = <<<EOD
$para123

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
		if($testtype['assess_type']=='Feedback' || $testtype['assess_type']=='Behavorial Instruments'){
			$time="-";
		}
		else{
			$time=$testtype['time_details'].' mins';
		}
		$method_name=$testtype['assess_type']=='Interview'?'Assessment Centre':$testtype['assess_type'];
		$methodname=$method_name=='Behavorial Instruments'?'Behavioural Instrument':$method_name;
		$methodnamefinal=$methodname=='Feedback'?'360° Feedback':$methodname;
		$weightage=$testtype['weightage']==0?"-":$testtype['weightage'];
		$para4.='<tr bgcolor="'.$bgcolor.'">';
		$para4.='<td align="center" width="10%">'.$i.'</td>';
		$para4.='<td width="40%">'.$methodnamefinal.'</td>';
		$para4.='<td width="30%">'.$weightage.'</td>';
		$para4.='<td width="20%">'.$time.'</td></tr>';
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
	// || $testtype['assessment_type']=="INTERVIEW" 
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
			
			$para5.='<b>Q'.$keys.')</b>&nbsp;'.$que['question_name'];
			if($que['lang_process']=='Y'){
				$ques_lang_n=UlsQuestionsLanguage::get_question_language($que['question_id']);
				if(!empty($ques_lang_n)){
					foreach($ques_lang_n as $ques_langs){
						$para5.='<br>'.$ques_langs['question_name'];
					}								
				}
			}
			$para5.='';
			$ss=Doctrine_Query::create()->select('value_id,text,correct_flag')->from("UlsQuestionValues")->where("question_id=".$que['question_id'])->execute();
			
			if($type=='S' || $type=='M'){ $para5.='<ol >'; }
			foreach($ss as $key1=>$sss){
				$col=$sss['correct_flag']=='Y'? 'style="color:green;font-size:11px;font-family:Helvetica;"':'';
				$col2='';//$empdetail['response_value_id']==$sss['value_id']?'style="color:blue;font-size:10px;font-family:italic;"':'';
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
					if($que['lang_process']=='Y'){
						$ques_lan=UlsLangQuestionValues::get_all_lang_values($sss['value_id']);
						if(!empty($ques_lan)){
							foreach($ques_lan as $ques_langs){
								$para5.='<br>'.$ques_langs['text'];
							}
						}
					}	
				}
				else if($type=='M') {
					$para5.='<li type="A" '.$col.' '.$col2.'>'.trim(strip_tags($sss['text'])).'</li>';
				}
				else if($type=='FT') {
					$col=$sss['correct_flag']=='Y'? 'style="color:green;font-size:10px;font-family:italic;"':'';
					if(!empty($sss['text'])){
						$para5.='<br><div '.$col.' class="answer"><i>What to look for<br>'.@$sss['text'].'</i></div><br>';
					}
					
						$para5.='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					
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
		An In-basket or an Intray is a list of items of work that need to be to be attended to when you come to work.  These could include mails, calls (mobile, intercom), reports, meetings, visits by you or by others, etc.  For the various items in the In-basket/intray, there would be a certain approach you would take – for exampling first attending the mail items, or the work from the previous day; and for each of them you would decide the kind of action you want to take and/or delegate the same.  Whatever you decide, is a reflection of your style of work and also tells how you prioritize and plan your work.<br>Apart from this, for each of the In-basket, you are to suggest an action which reflects your level of understanding and expertize.<br><br>
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
	$para7.='<span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 14px;color:#36a2eb; ">In-basket Narration</span><br>'.nl2br($inbasket['inbasket_narration']).'
	<br>'.nl2br($inbasket['inbasket_narration_lang']).'
	';
}
if(!empty($inbasket['question_id'])){
	//$empdetailinbasket=UlsMenu::callpdorow("SELECT * FROM `uls_utest_responses_assessment` WHERE `assessment_id`=".$_REQUEST['ass_id']." and `employee_id`=".$_REQUEST['emp_id']." and test_type='INBASKET' and `user_test_question_id`=".$inbasket['question_id']);
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
	$comname=!empty($question_views['comp_def_name_alt'])?$question_views['comp_def_name_alt']:$question_views['comp_def_name'];
	$para8.='<div><span align="left" style="text-transform: uppercase;font-family: hope;font-size: 14px;color:#36a2eb; ">Intray # '.$keyy.'<br></span>Competency: <b>'.$comname.'</b><br>Level: <b>'.$question_views['scale_name'].'</b><br>';
	if(!empty($parsed_json)){
		foreach($parsed_json as $key => $value){
			$k=$value['mode'];
			$para8.='Mode: '.@$mode[$k].'<br>
			Time: '.$value['period'].'<br>
			From: '.$value['from'].'<br>';
		}
	}
	$para8.=nl2br($question_views['text']);
	if(!empty($question_views['text_lang'])){
		$para8.=nl2br($question_views['text_lang']);
	}
	$para8.='</div>';
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
}
}

if($testtype['assessment_type']=="CASE_STUDY"){
	$nocases=UlsMenu::callpdo("SELECT * FROM `uls_assessment_test_casestudy` where assessment_id=$ass_id and position_id=$pos_id");
	foreach($nocases as $nocase){
		$case_details=UlsCaseStudyMaster::viewcasestudy($nocase['casestudy_id']);
		$case_desc=$case_details['casestudy_description'];
		$para10='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">
		<span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 14px;color:#36a2eb;">Case study/Caselet</span><br>'.$case_desc.'<br>';
		//$case_study_questions=UlsCaseStudyQuestions::viewcasestudyquestion($nocase['casestudy_id']);
		//$case_study_questions=UlsAssessmentTestQuestions::getcasesquestions_info($testtype['assess_test_id'],$testtype['test_id']);
		
		$case_study_questions=UlsMenu::callpdo("SELECT a.`question_id` as q_id,a.`competency_id`,d.comp_def_name,q.casestudy_quest as question_name  FROM `uls_assessment_test_questions` a
		left join(SELECT `comp_def_id`,`comp_def_name` FROM `uls_competency_definition`) d on d.comp_def_id=a.competency_id
		left join(SELECT `casestudy_quest_id`,`casestudy_quest` FROM `uls_case_study_questions`) q on q.casestudy_quest_id=a.question_id
		WHERE `assess_test_id`=".$testtype['assess_test_id']." and `test_id`=".$nocase['test_id']."");
		//print_r($case_study_questions);
		
		$para10.='<h4 class="titleheader">Questions</h4>';
		foreach($case_study_questions as $key1=>$case_study_question){
			//$empdetailcase=UlsMenu::callpdorow("SELECT * FROM `uls_utest_responses_assessment` WHERE `assessment_id`=".$_REQUEST['ass_id']." and `employee_id`=".$_REQUEST['emp_id']." and test_type='CASE_STUDY' and `user_test_question_id`=".$case_study_question['casestudy_quest_id']);
			//$empdetailcaseattach=UlsMenu::callpdorow("SELECT * FROM `uls_utest_attempts_assessment` WHERE `assessment_id`=".$_REQUEST['ass_id']." and `employee_id`=".$_REQUEST['emp_id']." and test_type='CASE_STUDY' and status='A'");
			$para10.='<br>
			<span style="color:#646464;font-size:11px;line-height: 1.5;">Q'.($key1+1).') '.$case_study_question['question_name'].'</span><br><br>
			<span style="color:blue;font-size:11px;line-height: 1.5;">A.</span>
			<br>';
			/* if(!empty($empdetailcaseattach['inbasket_upload'])){
				$para10.='Please Click on <a href="'.BASE_URL.'/public/uploads/employee_casestudy/'.$empdetailcaseattach['inbasket_upload'].'" parent="_blank">Attachment</a> to view Applicant add document.';
			} */
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
if($testtype['assessment_type']=="FISHBONE"){
	
	$nofishbone=UlsMenu::callpdo("SELECT * FROM `uls_assessment_test_fishbone` where assessment_id=$ass_id and position_id=$pos_id");
	foreach($nofishbone as $nofishbones){
		$fishbone=UlsFishboneMaster::viewfishbone($nofishbones['fishbone_id']);
		$para16='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;"><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 14px;color:#36a2eb; ">Fishbone Exercise</span>
		<br>
		'.nl2br($fishbone['fishbone_description']).'
		</div>';
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
$para16
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
	}
$para18='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">
<span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 14px;color:#36a2eb; ">List of probable causes<br></span>';
$intrayss=array();
$fishbone_questions=UlsMenu::callpdo("SELECT a.`question_id` as q_id,q.fishbone_quest as question_name,q.fishbone_quest_id  FROM `uls_assessment_test_questions` a
left join(SELECT `fishbone_quest_id`,`fishbone_quest` FROM `uls_fishbone_study_questions`) q on q.fishbone_quest_id=a.question_id
WHERE `assess_test_id`=".$testtype['assess_test_id']." and `test_id`=".$testtype['test_id']."");
foreach($fishbone_questions as $fishbone_question){	
	$para18.='<div><span align="left" style="font-family: Helvetica;font-size: 10px;"><b>Output:'.$fishbone_question['question_name'].'</b></div>';
	$comp_details=UlsFishboneListProbable::getfishbonecause($fishbone_question['fishbone_quest_id']);

$para18.='<br><table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#59b0ea" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5;">
	<thead><tr height="30" bgcolor="#59b0ea" align="center" class="row header" style="color:#fff;">
			<th width="10%">S.No</th>
			<th width="40%">Cause Name</th>
			<th width="30%">Head List</th>
			<th width="20%">Top Reason</th>
		</tr>
	</thead>
	<tbody>
	</tbody>';
	$ii=1;$kkk=0;
	foreach($comp_details as $comp_detail){
		$bgcolor=($kkk%2==0)?"#deeaf6":"#ffffff";
		$kkk++;
		$para18.='<tr bgcolor="'.$bgcolor.'">';
		$para18.='<td align="center" width="10%">'.$ii.'</td>';
		$para18.='<td width="40%">'.$comp_detail['probable_causes'].'</td>';
		$para18.='<td width="30%">'.$comp_detail['headlist'].'</td>';
		$para18.='<td width="20%">'.($comp_detail['top_reason']==1?"Yes":"").'</td></tr>';
		$ii++;
	}
	$para18.='</table>';
}
$para18.='</div>';
// add a page
$pdf->AddPage();
$pdf->SetFooterMargin(5);
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();
$tbl = <<<EOD
$para18
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

}
if($testtype['assessment_type']=="BEHAVORIAL_INSTRUMENT"){
	$para20='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;"><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 14px;color:#36a2eb; ">Instruments</span></div>';
	

	$noinrt=UlsMenu::callpdo("SELECT * FROM `uls_assessment_test_behavorial_inst` where assessment_id=$ass_id and position_id=$pos_id");
	foreach($noinrt as $noinrts){
		$instrument_details=UlsBeInstruments::view_instrument_details($noinrts['instrument_id']);
		
		$para20='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">
		<span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 14px;color:#36a2eb;">Instrument:</span><br>'.$instrument_details['instrument_description'].'';
		$inst_details=UlsBeInsSubparameters::view_inst_subpara_details($noinrts['instrument_id']);
		$para20.='<h4 class="titleheader">Instrument Questions</h4>';
		if($instrument_details['instrument_type']=='BEI_RATING_SINGLE'){
			$para20.='<br><table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#59b0ea" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5;">
			<thead><tr height="30" bgcolor="#59b0ea" align="center" class="row header" style="color:#fff;">
				<th width="10%">S.No</th>
				<th width="90%">Question Name</th>
			</tr>
		</thead>
			<tbody>';
			foreach($inst_details as $key2=>$inst_detailss){
				//$lang_one=!empty($inst_detailss['ins_subpara_text_lang'])?"<br>".$inst_detailss['ins_subpara_text_lang']:"";
				//'.$lang_one.'
				$para20.='<tr>
				<td  width="10%">'.($key2+1).'</td>
				<td  width="90%">'.$inst_detailss['ins_subpara_text'].'</td>
				</tr>';
			}
			$para20.='</tbody></table>';
		}
		else if($instrument_details['instrument_type']=='BEI_RATING_TWO'){
			$para20.='<br><table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#59b0ea" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5;">
			<thead><tr height="30" bgcolor="#59b0ea" align="center" class="row header" style="color:#fff;">
				<th width="10%">S.No</th>
				<th width="45%">Option 1</th>
				<th width="45%">Option 2</th>
			</tr>
			</thead>
			<tbody>';
			foreach($inst_details as $key5=>$inst_detailss){
				$langone=!empty($inst_detailss['ins_subpara_text_lang'])?"<br>".$inst_detailss['ins_subpara_text_lang']:"";
				$langtwo=!empty($inst_detailss['ins_subpara_text_ext_lang'])?"<br>".$inst_detailss['ins_subpara_text_ext_lang']:"";
				//'.$langone.'
				//'.$langtwo.'
				$para20.='<tr>
				<td width="10%">'.($key5+1).'</td>
				<td width="45%">'.$inst_detailss['ins_subpara_text'].'</td>
				<td width="45%">'.$inst_detailss['ins_subpara_text_ext'].'</td></tr>';
			}
			$para20.='</tbody></table>';
		}
		$para20.='</div>';
		$be_name=$testtype['assess_type']=='Behavorial Instruments'?'Behavioural Instrument':$testtype['assess_type'];
		$pdf->AddPage();
$pdf->SetFooterMargin(5);
$pdf->Bookmark('4.'.($k+1).'. '.$be_name, 1, 0, '', '', array(0,0,0));
$index_link = $pdf->AddLink();
$pdf->SetLink($index_link, 0, '*1');
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();
$tbl = <<<EOD
$para20
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
	}
	// add a page

}
if($testtype['assessment_type']=="FEEDBACK"){
	$nofeedback=UlsMenu::callpdo("SELECT * FROM `uls_assessment_test_feedback` where assessment_id=$ass_id and position_id=$pos_id");
	foreach($nofeedback as $nofeedbacks){
		$para21='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">
		<span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 14px;color:#36a2eb;">360 degree Feeeback Questionnaire:</span><br>';
		$feed_details=UlsQuestionnaireCompetencyElement::edit_comptency_element($nofeedbacks['ques_id']);
			$para21.='<br><table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#59b0ea" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5;">
			<thead><tr height="30" bgcolor="#59b0ea" align="center" class="row header" style="color:#fff;">
				<th width="10%">S.No</th>
				<th width="90%">Elements</th>
			</tr>
		</thead>
			<tbody>';
			foreach($feed_details as $key2=>$feed_detailss){
				$langfeed=!empty($feed_detailss['element_language'])?"<br>".$feed_detailss['element_language']:"";
				//'.$langfeed.'
				$para21.='<tr>
				<td  width="10%">'.($key2+1).'</td>
				<td  width="90%">'.$feed_detailss['element_name'].'</td>
				</tr>';
			}
			$para21.='</tbody></table>';
		
		$para21.='</div>';
// add a page
$feedname=$testtype['assess_type']=='Feedback'?'360° Feedback':$testtype['assess_type'];
$pdf->AddPage();
$pdf->SetFooterMargin(5);
$pdf->Bookmark('4.'.($k+1).'. '.$feedname, 1, 0, '', '', array(0,0,0));
$index_link = $pdf->AddLink();
$pdf->SetLink($index_link, 0, '*1');
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();
$tbl = <<<EOD
$para21
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
	}
}
}



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
$img_file = K_PATH_IMAGES.'adanipower/Headnorth-backcover.jpg';
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
$pos_name=$posdetails['position_name'];
/*
 * The key of the $bookmark_templates array represent the bookmark level (from 0 to n).
 * The following templates will be replaced with proper content:
 *     #TOC_DESCRIPTION#    this will be replaced with the bookmark description;
 *     #TOC_PAGE_NUMBER#    this will be replaced with page number.
 *
 * NOTES:
 *     If you want to align the page number on the right you have to use a monospaced font like courier, otherwise you can left align using any font type. bordercolor="#646464"
 *     The following is just an example, you can get various styles by combining various HTML elements.
 */

// A monospaced font for the page number is mandatory to get the right alignment
$bookmark_templates[0] = '<table border="0" cellpadding="0" cellspacing="5" style="background-color:#FFFFFF"><tr><td width="155mm">
<span style="font-family: Helvetica;font-size: 12px;color: #646464;">#TOC_DESCRIPTION#</span></td>
<td width="25mm"><span style="font-family: Helvetica;font-size: 12px;color: #646464;" align="center">#TOC_PAGE_NUMBER#</span></td></tr></table>';
$bookmark_templates[1] = '<table border="0" cellpadding="0" cellspacing="5"><tr><td width="155mm">
<span style="font-family:Helvetica;font-size:12px;color:#646464;">&nbsp;&nbsp;&nbsp;#TOC_DESCRIPTION#</span></td><td width="25mm">
<span style="font-family:Helvetica;font-size:12px;color:#646464;" align="center">#TOC_PAGE_NUMBER#</span></td></tr></table>';
$bookmark_templates[2] = '<table border="0" cellpadding="0" cellspacing="5"><tr><td width="155mm">
<span style="font-family:Helvetica;font-size:12px;color:#646464;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;#TOC_DESCRIPTION#</span></td><td width="25mm">
<span style="font-family:Helvetica;font-size:12px;color:#646464;" align="center">#TOC_PAGE_NUMBER#</span></td></tr></table>';
$bookmark_templates[3] = '<table border="0" cellpadding="0" cellspacing="5"><tr><td width="155mm">
<span style="font-family:Helvetica;font-size:12px;color:#646464;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;#TOC_DESCRIPTION#</span></td><td width="25mm">
<span style="font-family:Helvetica;font-size:12px;color:#646464;" align="center">#TOC_PAGE_NUMBER#</span></td></tr></table>';
$bookmark_templates[4] = '<table border="0" cellpadding="0" cellspacing="5"><tr><td width="155mm">
<span style="font-family:Helvetica;font-size:12px;color:#646464;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;#TOC_DESCRIPTION#</span></td><td width="25mm">
<span style="font-family:Helvetica;font-size:12px;color:#646464;" align="center">#TOC_PAGE_NUMBER#</span></td></tr></table>';
// add other bookmark level templates here ...

// add table of content at page 1
// (check the example n. 45 for a text-only TOC
$pdf->addHTMLTOC(2, 'Content', $bookmark_templates, true, 'B', array(128,0,0));

// end of TOC page
$pdf->endTOCPage();


//Close and output PDF document
$pdf->Output('Assessment-Booklet for '.$pos_name.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+