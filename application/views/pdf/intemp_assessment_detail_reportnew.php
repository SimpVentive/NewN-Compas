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
		$img_file = K_PATH_IMAGES.'adanipower/interviewbooklet2.jpg';
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
$pdf->SetMargins(10,25,12,true);
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
$txtimg='<img src="'.LOGO_IMG_PDF.'" style="margin:0.15cm 0.2cm" width="200"  class="fish">';
$txt='<label class="fish1"><b style="font-size:16pt;color:#000;">'.trim($emp_info['name']).'</b><br><b style="font-size:12pt;color:#000;">'.@$posdetails['position_name'].'</b></label>';
	
$html = <<<EOD
<table cellspacing="0" width="100%" cellpadding="5" border="0" >
	<tr>
		<td colspan="2" width="100%" height="150pt" align="right">&nbsp;</td>
	</tr>
	<tr>
		<td width="52%" align="center">$txtimg</td>
		<td width="48%"  align="left">$txt</td>
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
$para2="The Assessment Booklet is for ".trim($emp_info['name']).", ".trim($posdetails['position_name']);
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
$pdf->Bookmark('1. Job Description', 0, 0, '', '', array(0,0,0));
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
$pdf->Bookmark('2. Competency Profile', 0, 0, '', '', array(0,0,0));
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

$para3='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">The Job, '.$emp_info['position_name'].', whose description is provided in the above section, would require Competencies – Functional, Technical, Managerial and Behavioural, to ensure that the objectives/goals or KRAs are achieved.  However, not all the competencies, are required at the same Levels of Proficiency or the same level of Criticality.  The process of mapping the position in terms of required Competencies – the Levels and the Criticality is  referred to as Profiling.<br>
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
        <td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">2. Competency Profile<br></span>
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

$para3='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;"><span align="left" style="font-family: Helvetica;font-size: 14px;color:#36a2eb;line-height: 1.5;">COMPETENCY/SKILL REQUIREMENTS<br></span>';
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
$para3
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');


// add a page
$pdf->AddPage();
// -- set new background ---
$pdf->SetFooterMargin(5);
$pdf->Bookmark('3. Assessment Methods', 0, 0, '', '', array(0,0,0));
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
        <td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">3. Assessment Methods<br></span>
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
	$text=str_replace(array("<br>","</br>"),array("",""),$question_views['text']);
	$para8.=nl2br($text).'</div>';
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
<style>
.titleheaderchk {

		
}
</style>
$para8
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

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
$para9.='</tbody></table><br><br>
						<h4 class="titleheader">Rating</h4>
						Consider the following and rate the participant on the Inbasket/Intray exercises
						<ol>
							<li>Has been completed all the intrays in the given time.</li>
							<li>The prioritization is consistent with the requirements of the Role & Responsibilities.</li>
							<li>The quality of action proposed reflects the competency requirements (L1 -  Knowing,  L2 – Doing,  L3- Improving and L4 – Expertize).</li>
							<li>The way to action (ie delegate, hold, actionize) proposed are appropriate to the Intray.</li>
							<li>When delegating the actions are clear, lucid and understandable.</li>
						</ol>
						<table border="0" style="font-size:20px;">
			<tr><td valign="middle"><img src="'.BASE_URL.'/public/images/checkbox.jpg" width="20px" height="20px"> Poor</td><td valign="middle"><img src="'.BASE_URL.'/public/images/checkbox.jpg" width="20px" height="20px"> Average</td><td valign="middle"><img src="'.BASE_URL.'/public/images/checkbox.jpg" width="20px" height="20px"> Good</td><td valign="middle"><img src="'.BASE_URL.'/public/images/checkbox.jpg" width="20px" height="20px"> Very Good </td></tr></table></div>';
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
		WHERE `assess_test_id`=".$testtype['assess_test_id']." and `test_id`=".$testtype['test_id']."");
		
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
		$para10.='<h4 class="titleheader">Rating</h4>
						Consider the following and rate the participant in the Casestudy/Case Analysis <br>
						<ol>
							<li>Has identified the core issue  / problem of the case </li>
							<li>Has analyzed the core  issues/ problem, in the most appropriate manner</li>
							<li>Proposed action (if any) is consistent with the competency required (L1 -  Knowing,  L2 – Doing,  L3- Improving and L4 – Expertise)</li>
							<li>Presents the solution / analysis in a coherent and logical way </li>
						</ol>
			<table border="0" style="font-size:20px;">
			<tr><td valign="middle"><img src="'.BASE_URL.'/public/images/checkbox.jpg" width="20px" height="20px"> Poor</td><td valign="middle"><img src="'.BASE_URL.'/public/images/checkbox.jpg" width="20px" height="20px"> Average</td><td valign="middle"><img src="'.BASE_URL.'/public/images/checkbox.jpg" width="20px" height="20px"> Good</td><td valign="middle"><img src="'.BASE_URL.'/public/images/checkbox.jpg" width="20px" height="20px"> Very Good </td></tr></table></div>';
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
$img_file = K_PATH_IMAGES.'adanipower/interviewbookletb2.jpg';
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

$emp_details=trim($emp_info['name'])."-".$posdetails['position_name']."-Employee Assessment Report";

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


//Close and output PDF document
$pdf->Output($emp_details.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+