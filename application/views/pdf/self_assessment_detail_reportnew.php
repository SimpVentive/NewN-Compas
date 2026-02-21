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
		$img_file = K_PATH_IMAGES.'self-assessment.jpg';
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
			if($pkey1==0){
			
			// *** replace the following parent::Footer() with your code for normal pages
			//parent::Footer();
			}
			else{
				if($this->footershow){
				$text='<table width="100%" style="text-align:center;font-family:Helvetica;font-weight:bold;font-size:10pt;">
				<tr>
				<td text-align="bottom" rowspan="2" width="95%" style="text-align:left;"><span style="font-family: Helvetica, sans-serif;font-size: 7.5pt;color:#646464;">'.PDF_NAME.'</span></td>
				
				<td width="5%" style="text-align:right;"><span style="font-family: Helvetica, sans-serif;font-size: 8pt;color:#646464;">'.$this->getAliasNumPage().'</span></td>
				</tr>
				</table>';
				$this->writeHTML($text, true, false, true, false, '');
				$this->writeHTMLCell($w='', $h='', $x='', $y='', $this->header, $border=0, $ln=0, $fill=0, $reseth=true, $align='L', $autopadding=true);
				//$this->SetLineStyle( array('width'=>0.40,'color'=> array(54,162,235)));
				$this->SetLineStyle( array('width'=>0.40,'color'=> array(100,100,100)));
				$this->RoundedRect(7, 20, $this->getPageWidth()-14, $this->getPageHeight()-29, 2.5, '1111');
				//$this->Rect(5, 24, $this->getPageWidth()-10, $this->getPageHeight()-34);
				}
			}
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
$filename=$posdetails['position_name'].'-'.'Self Assessment Report';
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Srikanth Math');
$pdf->SetTitle($filename);
$pdf->SetSubject($filename);
$pdf->SetKeywords($filename);

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
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);
// Print a text
$txt='<img src="'.LOGO_IMG_PDF.'" style="margin:0.15cm 0.2cm" width="200"  class="fish">';
$txt2='<span style="font-size:36px;color:#fff;">Self Assessment Report<br><br><br></span>
<span style="font-size:12px;color:#fff;">Position<br></span>
<span style="font-size:20px;color:#fff;">'.$posdetails['position_name'].'<br><br><br><br></span>';
	
$html = <<<EOD
<table cellspacing="0" width="100%" cellpadding="5" border="0" >
	<tr>
		<td width="100%" height="370pt" colspan="3" align="left">$txt</td>
	</tr>
	<tr>
		<td width="100%" colspan="3" align="left">$txt2</td>
	</tr>	
</table>
EOD;
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->setPrintHeader(true);

// add a page
$pdf->AddPage();
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
$para1="NOTE:This report and its contents are the property of ".$posdetails['parent_organisation']." and no portion of the same should be copied or reproduced without the prior permission of ".$posdetails['parent_organisation'];
$para2="The report is the self-assessment and development report of ".trim($posdetails['position_name']);
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
$image='<img src="'.BASE_URL.'/public/PDF/images/cms/self.png" width="300" style="align:center;">';
$tbl = <<<EOD
<table cellspacing="0" cellpadding="0" border="0" >
    <tr>
        <td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">1. Introduction</span>		
	</td>
    </tr>
</table>
<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">
	<br><span align="left" style="font-family: Helvetica;font-size: 14px;color:#36a2eb; line-height:1.5;">WHAT ARE COMPETENCIES?<br></span>
	Competencies are a combination of Knowledge Skill and Attitude.  Knowledge is defined as that information, data, understanding gained through structured process, such as education or training.  Skill is practised ability or the expertise gained through applying ones knowledge.  Attitude in this context is defined as the inclination to better one self through constant upgradation of knowledge and wanting to apply the same at the workplace.<br>
	<div align="center">$image</div>
	<br><br>
	
	<span align="left" style="font-family: Helvetica;font-size: 14px;color:#36a2eb; line-height:1.5;">WHAT IS COMPETENCY ASSESSMENT?<br></span>
	Organizations in order to maintain their competitive advantage need constantly invest in their people – by reskilling and/or upskilling them.  This process of  enhancing the skill sets is done along those competencies which are crucial for the organization and the positions therein.  The process of carrying out a structured method to determine where a current employee is, especially with respect to the competencies required for the position, he/she is manning, is called competency assessment.<br><br><br>
	
	<span align="left" style="font-family: Helvetica;font-size: 14px;color:#36a2eb; line-height:1.5;">WHAT IS COMPETENCY SELF-ASSESSMENT?<br></span>
	In the process of developing on competencies, one of the most important dimensions is to ascertain where the individual presently perceives himself/herself to be at.  This process, usually referred to as self-assessment enables one to make an honest, usually qualitative judgement on where one believes he/she is pegged on the various competencies required for his/her job.<br>During the course of assessment, one must make a realistic assessment of where he/she is on various competencies.  Since the process of self-assessment is mostly used for the development purposes, the more realistic one is, better are the development opportunities.
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
	<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#5b9bd5" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5; border:0.5px solid #9999;">
		<tbody>
			<tr bgcolor="#deeaf6">
				<td class="normal"  style="width:10%"><b>Job Title</b></td>
				<td class="normal"  style="width:35%">'.@$posdetails['position_name'].'</td>
				<td class="normal"  style="width:20%"><b>Grade/Designation</b></td>
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
		<h4 class="titleheader">Reporting Relationships </h4>
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
		$jd.='<h4 class="titleheader">Other Requirements:</h4>'.@$posdetails['other_requirement'];
		}
		$jd.='<h4 class="titleheader">Purpose:</h4>'.@$posdetails['position_desc'];
	$jd.='</div>';





$tbl = <<<EOD
<table cellspacing="0" cellpadding="0" border="0" >
    <tr>
        <td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">2. Job Description</span>		
	</td>
    </tr>
</table><br>
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

$jd='<h4 class="titleheader" style="font-family: Helvetica;color:#646464;">KRA & KPI</h4><div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">';
$jd.='<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#5b9bd5" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5; border:0.5px solid #646464;">
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

$para3='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">The '.$posdetails['position_name'].', whose description is provided in the above section, would require Competencies – Functional, Technical, Managerial and Behavioural, to ensure that the objectives/goals or KRAs are achieved.  However, not all the competencies, are required at the same Levels of Proficiency or the same level of Criticality.  The process of mapping the position in terms of required Competencies – the Levels and the Criticality is  referred to as Profiling.<br>
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

$para3='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;"><span align="left" style="font-family: Helvetica;font-size: 14px;color:#5b9bd5;line-height: 1.5;">COMPETENCY/SKILL REQUIREMENTS<br></span>';
	$para3.='The following are the competencies required for the position of '.$posdetails['position_name'].'. This is also reffered to as Competency Profilling';
foreach($category as $categorys){
	$competencies=UlsCompetencyPositionRequirements::getcompetencypositionrequirements_cat($_REQUEST['pos_id'],$categorys['category_id']);
	$para3.='<br><br><span align="left" style="text-transform: uppercase; font-family: Helvetica;font-size: 14px;color:#5b9bd5; line-height: 1.5;">'.$categorys['name'].'</span><br><br>';
	$para3.='<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#5b9bd5" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5; border:0.5px solid #9999;">
	<thead><tr height="30" bgcolor="#5b9bd5" align="center" class="row header" style="color:#fff;">
		<th>Competency/Skill</th>
		<th>Level Requirement</th>
		<th>Criticality</th>
		</tr>
	</thead>
	<tbody>';
	$kk=0;
	foreach($competencies as $competency){
		if($competency['comp_position_id']==$posdetails['position_id']){
			$bgcolor=($kk%2==0)?"#deeaf6":"#ffffff";
			$kk++;
			$para3.='<tr bgcolor="'.$bgcolor.'">
			<td>'.$competency['comp_def_name'].'</td>
			<td>'.$competency['scale_name'].'</td>
			<td>'.$competency['comp_cri_name'].'</td>
		</tr>';
		}
	}
	$para3.='</tbody>
	</table>';
}
$para3.='</div>';		
$tbl = <<<EOD
$para3
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');





foreach($ass_comp as $key=>$ass_comps){$para="";
	$path = BASE_URL.'/public/reports/graphs/self/'.$_REQUEST['ass_id'].'/'.$ass_comps['category_id'].'_'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'_radar.png';
	//$type = pathinfo($path, PATHINFO_EXTENSION);
	//$data = url_get_contents($path);
	//$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
	$key1=$key+4;
	$ass_comp_info=UlsSelfAssessmentReport::getassessment_self_admin_summary($ass_id,$_REQUEST['pos_id'],$_REQUEST['emp_id'],$ass_comps['category_id']);
	if(count($ass_comp_info)>0){
		

		if($key==0){
			$para.='<table cellspacing="0" cellpadding="0" border="0" ><tr><td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">4. Self Assessment Results<br></span></td></tr></table>';
		}
		// add a page
		$pdf->AddPage();
		// -- set new background ---
		$pdf->SetFooterMargin(5);
		// get the current page break margin
		$bMargin = $pdf->getBreakMargin();
		if($key==0){
		$pdf->Bookmark('4. Self Assessment Results', 0, 0, '', '', array(0,0,0));
		$index_link = $pdf->AddLink();
		$pdf->SetLink($index_link, 0, '*1');
		}
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
		$para.='<h4 style="font-family: Helvetica;color:#646464;">'.$ass_comps['name'].'</h4>';
		$para.='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;"><table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#5b9bd5" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5;">';
		$comp_name=array();
		$kk=0;
		foreach($ass_comp_info as $result){
			$bgcolor=($kk%2==0)?"#deeaf6":"#ffffff";
			$kk++;
			$level=$result['level_scale'];
			$comp_name[]=$result['comp_def_name'];
			$req_sid=round((($result['req_number']/$level)*100),1);
			$ass_sid=round((($result['ass_number']/$level)*100),1);
			$para.='<tr bgcolor="'.$bgcolor.'"><td><b>'.$result['comp_def_name'].'</b><br><i>Criticality:';
			foreach($cri_info as $cri_infos){
				if($cri_infos['comp_cri_code']==$result['comp_cri_code']){
					$para.=$cri_infos['name'];
				}
			}
			$para.='</i>
			</td>
			<td>
			<table>
				<tr>';/*<br><span style="font-size:10px;">'.$result['comp_def_short_desc'].'</span>*/
				for($i=1;$i<=$result['req_number'];$i++){					
					$para.='<td bgcolor="#f2804c">&nbsp;</td>';					
				}
				for($i=1;$i<=($level-$result['req_number']);$i++){
					$d=$i==1?"&nbsp;".$result['req_number']:'';
					$para.='<td bgcolor="#f9f9f9">'.$d.'</td>';
				}
				$para.='</tr>
				<tr>';
				for($i=1;$i<=$result['ass_number'];$i++){					
					$para.='<td bgcolor="#b7d63c">&nbsp;</td>';					
				}
				for($i=1;$i<=($level-$result['ass_number']);$i++){
					$d=$i==1?"&nbsp;".$result['ass_number']:'';
					$para.='<td bgcolor="#f9f9f9">'.$d.'</td>';
				}
				$para.='</tr>
			</table>
						<span style="color:#f2804c;"><i>Required Level</i>: '.$result['req_scale_name'].'</span><br>
						<span style="color:#b7d63c;"><i>Assessed Level</i>: '.$result['final_scaled_name'].'</span>
				
			</td>
			</tr>';
		}
		$para.='</table></div>';
$tbl = <<<EOD
$para
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

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


		$para='<h4  style="font-family: Helvetica;color:#646464;">Radar Graph for '.$ass_comps['name'].'</h4><div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">	
		
		<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#5b9bd5" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5; border:0.5px solid #646464;">
		<tbody>
		<tr>
		<td width="60%" align="center"><img src="'.$path.'" style="width:400px;height:400px;"/></td>
		<td width="40%" align="left">
			<span style="color:#f2804c;"><i>RL : Required Level</i></span><br>
			<span style="color:#b7d63c;"><i>AL : Assessed Level</i></span><br><br>';
		$par=array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
		$sd=array();
		for($i=0;$i<count($comp_name); $i++){
			$sd=$par[$i];
			$para.=$sd .'-'.$comp_name[$i].'<br>';
		}
		$para.='</td>
			</tr>
		</tbody>
	</table>
	</div>';
$tbl = <<<EOD
$para
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

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
	$para='<h3 style="font-family: Helvetica;color:#646464;">Vectorization for '.$ass_comps['name'].'</h3>
	<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">Vectorizing is a process of determining/assigning a numeric value to the gap/strength and arriving at a direction (assigning positive or negative values).<br>
	Vectorized value is obtained, by the following steps.<br>
	Step 1. Identify the gap level in a competency – for instance required level is developed, assessed level is novice, implies ga is \'2\'<br>
	Step 2. Identify the level of criticality to the competency (assigned numeric  are Critical = 5, Important =3, Less Important = 1)<br>
	Step 3. Multiply the gap level (attained in Step 1)  with the criticality dimension (Step 3)<br>
	Step 4. Vectorize the magnitude strength/gap (Step 3), by a proportionate sign/arrow ie usually a positive sign for the strength and negative for the gap.<br>
	The total value, indicates the Overall Strength (if value is Positive) or the Development Need (if the value is Negative) for you, with respect to the position and the '.$ass_comps['name'].' of  competencies. <br><br>
	
	<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#5b9bd5" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5; border:0.5px solid #646464;">
		<thead>
			<tr height="30" bgcolor="#5b9bd5" align="center" class="row header" style="color:#fff;">
			<th style="width:25%">Competency name</th>
			<th style="width:15%">Criticality</th>
			<th style="width:21%">Required Level</th>
			<th style="width:21%">Assessed Level</th>
			<th style="width:18%">Vectorized Value</th>
			</tr>
		</thead>
		<tbody>';
		$vec_sum=0;$kk=0;
		foreach($ass_comp_info as $result){
			$bgcolor=($kk%2==0)?"#deeaf6":"#ffffff";
			$kk++;			
			$req_v=$result['comp_rating_value'];
			$req_sid=$result['req_number'];
			$ass_sid=$result['ass_number'];
			$vec=(($ass_sid-$req_sid)*$req_v);
			$vec_sum=$vec_sum+(($ass_sid-$req_sid)*$req_v);
			$para.='<tr bgcolor="'.$bgcolor.'">
				<td>'.$result['comp_def_name'].'</td>
				<td>'.$result['comp_cri_name'].'</td>
				<td>'.$result['req_scale_name'].'</td>
				<td>'.$result['final_scaled_name'].'</td>
				<td>'.$vec.'</td>
			</tr>';
		}
		$para.='<tr bgcolor="#5b9bd5" style="color:#fff;">
			<td colspan="4" align="right">Total Vectorized value</td>
			<td>'.$vec_sum.'</td>
		</tr>
		</tbody>
	</table>
	</div>';
$tbl = <<<EOD
$para
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
	}
}




if($ass_details['self_ass_type']=='IS'){
	
// add a page
$pdf->AddPage();
// -- set new background ---
$pdf->SetFooterMargin(5);
// get the current page break margin
$bMargin = $pdf->getBreakMargin();
$pdf->Bookmark('4. Self Assessment Results', 0, 0, '', '', array(0,0,0));
$index_link = $pdf->AddLink();
$pdf->SetLink($index_link, 0, '*1');
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
$para='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">	
You have drawn up the following development Road Map for the purpose of improving yourself in the various competencies
<h4 class="titleheader">Knowledge</h4>';
$para.=!empty($ass_dev_info['knowledge_dev'])?$ass_dev_info['knowledge_dev']:"";
$para.='<h4 class="titleheader">Skill</h4>';
$para.=!empty($ass_dev_info['skill_dev'])?$ass_dev_info['skill_dev']:"";
$para.='</div>';
$tbl = <<<EOD
<table cellspacing="0" cellpadding="0" border="0" >
    <tr>
        <td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">5.Development Road Map<br></span>
	</td>
    </tr>
</table>
$para
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
}


if($ass_details['self_ass_type']=='FS'){
// add a page
$pdf->AddPage();
// -- set new background ---
$pdf->SetFooterMargin(5);
// get the current page break margin
$bMargin = $pdf->getBreakMargin();
$pdf->Bookmark('5.Individual Professional & Career Development Plan', 0, 0, '', '', array(0,0,0));
$pdf->Bookmark('5.1. Career Planning', 1, 0, '', '', array(0,0,0));
$index_link = $pdf->AddLink();
$pdf->SetLink($index_link, 0, '*1');
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
$para='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">
This plan is a planning and monitoring tool that is created to enable you to prepare your professional and career plan – which you along with your superior and/or mentor can review, monitor and guide you towards your goals
<h4 style="color:#36a2eb;">A. Career Planning</h4>
What are your career goals?  (in line with the Vision you have for your Career)<br>
<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#5b9bd5" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5; border:0.5px solid #646464;">
	<thead>
		<tr height="30" bgcolor="#5b9bd5" align="center" class="row header" style="color:#fff;">
			<th colspan="2" align="center"><b>SML Goals</b></th>
		</tr>
	</thead>
	<tr bgcolor="#deeaf6"><td style="width:20%">Short Term Goals</td><td style="width:80%">'.$ass_dev_info['short_term_goals'].'</td></tr>
	<tr><td style="width:20%">Medium Term Goal</td><td style="width:80%">'.$ass_dev_info['medium_term_goals'].'</td></tr>	
	<tr bgcolor="#deeaf6"><td style="width:20%">Long Term Goal</td><td style="width:80%">'.$ass_dev_info['long_term_goals'].'</td></tr>	
</table>
Now that you have done a self-assessment you know the various strengths that you can leverage and development needs that need to be addressed, so as to achieve your above goals';
$tbl = <<<EOD
<table cellspacing="0" cellpadding="0" border="0" >
    <tr>
        <td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">5.Individual Professional & Career Development Plan</span>
	</td>
    </tr>
</table>
$para
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');


// add a page
$pdf->AddPage();
// -- set new background ---
$pdf->SetFooterMargin(5);
// get the current page break margin
$bMargin = $pdf->getBreakMargin();
$pdf->Bookmark('5.2. Strengths', 1, 0, '', '', array(0,0,0));
$index_link = $pdf->AddLink();
$pdf->SetLink($index_link, 0, '*1');
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
$para='<h4 style="color:#36a2eb;">B.Strengths</h4><div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">';

foreach($category as $categorys){
	$competencies_name=UlsSelfAssessmentReport::getassessment_self_category($_REQUEST['ass_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id'],$categorys['category_id']);
	$para.='<h4 class="titleheader2">'.$categorys['name'].'</h4>';
	if(count($competencies_name)>0){
		foreach($competencies_name as $key=>$competencies_names){
			if(!empty($competencies_names['strengths_desc'])){
				$para.='<span >'.$competencies_names['comp_def_name'].'</span><br>
				<div>'.$competencies_names['strengths_desc'].'</div>';
			}
		}
	}
	else{
		$para.='<span>No competencies selected.</span><br>';
	}
	
}
$para.='<br>How would you want to leverage on your Strengths.  Examples of leveraging on your strength could include, coaching some one, taking up special projects, becoming a team member to help groups/others, etc.<br>
'.$ass_dev_info['leverage'].'</div>';
$tbl = <<<EOD
$para
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');


// add a page
$pdf->AddPage('L');
// -- set new background ---
$pdf->SetFooterMargin(5);
// get the current page break margin
$bMargin = $pdf->getBreakMargin();
$pdf->Bookmark('5.3. Development Planning', 1, 0, '', '', array(0,0,0));
$index_link = $pdf->AddLink();
$pdf->SetLink($index_link, 0, '*1');
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
$para='<h4 style="color:#36a2eb;">C. Development Planning</h4><div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">
<table align="left" cellspacing="0" border="0.5px" bordercolor="#5b9bd5" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5;">
	<thead>
	<tr height="30" bgcolor="#5b9bd5" align="center" class="row header" style="color:#fff;">
		<th>Competency</th>
		<th>Knowledge/Skill</th>
		<th>Method </th>
		<th>Org. Support Requirement</th>
		<th>Targeted Date for Completion </th>
		<th>Evidence of Completion</th>
	</tr>
	</thead>
	<tbody>';
	$kk=0;
	foreach($ass_report_info as $ass_report_infos){
		$bgcolor=($kk%2==0)?"#deeaf6":"#ffffff";
		$kk++;
		$date=!empty($ass_report_infos['target_date'])?date("d-m-Y",strtotime($ass_report_infos['target_date'])):"";
		$para.='<tr bgcolor="'.$bgcolor.'">
			<td>'.$ass_report_infos['comp_def_name'].'</td>
			<td>'.$ass_report_infos['knowledge_skill'].'</td>
			<td>'.$ass_report_infos['method_value_name'].'</td>
			<td>'.$ass_report_infos['org_support'].'</td>
			<td>'.$date.'</td>
			<td>'.$ass_report_infos['comp_evidence'].'</td>
		</tr>';
	}
	$para.='</tbody>
</table></div>';
$tbl = <<<EOD
$para
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');


// add a page
$pdf->AddPage('L');
// -- set new background ---
$pdf->SetFooterMargin(5);
// get the current page break margin
$bMargin = $pdf->getBreakMargin();
$pdf->Bookmark('5.4. Review & Other', 1, 0, '', '', array(0,0,0));
$index_link = $pdf->AddLink();
$pdf->SetLink($index_link, 0, '*1');
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
$para='<h4 style="color:#36a2eb;">D. Review & Other</h4><div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">
When do you want to review this development plan?<br>
'.$ass_dev_info['review_value_name'].'
<br><br>
Have you discussed this development plan with your Reporting Manager<br>
'.$ass_dev_info['reporting_value_name'].'
<br><br>';
if(count($training_needs_info)>0){
$para.='<h4 style="color:#646464;">Training Needs</h4>
<table align="left" cellspacing="0" border="0.5px" bordercolor="#5b9bd5" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5;">
	<thead>
	<tr height="30" bgcolor="#5b9bd5" align="center" class="row header" style="color:#fff;">
		<th width="50%">Training</th>
		<th width="50%">Remarks</th>
	</tr>
	</thead>
	<tbody>';
	$kk=0;
	foreach($training_needs_info as $training_needs_infos){
		$bgcolor=($kk%2==0)?"#deeaf6":"#ffffff";
		$kk++;
		$para.='<tr bgcolor="'.$bgcolor.'">
			<td  width="50%">'.$training_needs_infos['training_desc'].'</td>
			<td  width="50%">'.$training_needs_infos['remark'].'</td>
		</tr>';
	}
	$para.='</tbody></table>';
}
$para.='</div>';

$tbl = <<<EOD
$para
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
}



 // add a page
$pdf->AddPage('P');
$pdf->footershow=False;
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
$img_file = K_PATH_IMAGES.'adani-power-backcover.jpg';
$pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
// restore auto-page-break status
//$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();
$pdf->writeHTML("", true, false, false, false, '');






// add a new page for TOC
$pdf->addTOCPage('P');
$pdf->footershow=True;
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


$filename=$posdetails['position_name'].'_'.' Self Assessment Report';
$filename=str_replace(" ","_",$filename);
$filename=str_replace("-","_",$filename);
$filename=str_replace("__","_",$filename);
$filename=str_replace("__","_",$filename);
//Close and output PDF document
$pdf->Output("$filename.pdf", 'I');

//============================================================+
// END OF FILE
//============================================================+