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
		$img_file = K_PATH_IMAGES.'adanipower/interviewbooklet.jpg';
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
				<td text-align="bottom" rowspan="2" width="95%" style="text-align:left;"><span style="font-family: Helvetica, sans-serif;font-size: 7.5pt;color:#646464;">'.PDF_NAME.'</span></td>
				
				<td width="5%" style="text-align:right;"><span style="font-family: Helvetica, sans-serif;font-size: 8pt;color:#646464;">'.$this->getAliasNumPage().'</span></td>
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

$txt='<br><br><img src="'.LOGO_IMG_PDF.'" style="margin:0.15cm 0.2cm" width="200" class="fish"><br><br><br>
<label class="fish1"><b style="font-size:14pt;color:#000;">'.@$posdetails['position_name'].'</b></label>';
	
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
$para1="NOTE:This report and its contents are the property of ".$posdetails['parent_organisation']." and no portion of the same should be copied or reproduced without the prior permission of ".$posdetails['parent_organisation'];
$para2="The report is a part of the Techincal/ Functional Assessment process of ".trim($posdetails['position_name']);
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
	<br><span align="left" style="font-family: Helvetica;font-size: 14px;color:#36a2eb; line-height:1.5;">WHAT IS THE COMPETENCY BASED INTERVIEWING?<br></span>
	Competencies and competency mapping process can be used for all activities along the HR value chain, including that for recruitment.Since the competencies required for various positions have been mapped, that is the critical competencies for the position have been identified; in the process of recruitment the focus could therefore be on these.  Also, the competency profile of the position, describes the needs of the job, in terms of the other knowledge and skill requirements for the position being filled.<br><br><br>
	
	<span align="left" style="font-family: Helvetica;font-size: 14px;color:#36a2eb; line-height:1.5;">WHAT DOES THIS BOOKLET CONTAIN?<br></span>
	This booklet is a facilitation guide for interviewers participating in the selection process for the position mentioned on the cover sheet.  These booklet servers as a guide for the process of selection and contains the following
	<ol>
	<li>Position or Job Description of the position being filled.</li>
	<li>Competency Profile of the Position – that is the competency requirements of the position.</li>
	<li>Brief Explanation of the critical competencies.</li>
	<li>Guiding questions for the interviewer.</li>
	</ol>	
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
		<table style="width:100%" align="left" cellspacing="0" border="0.5px" cellpadding="5"  bordercolor="#5b9bd5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5;">
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
				<tr bgcolor="#deeaf6">
					<td class="normal"><b>Location</b></td>
					<td class="normal">'.@$posdetails['location_name'].'</td>
					<td class="normal"><b></b></td>
					<td class="normal"></td>
				</tr>
			</tbody>
		</table>
		<h4 class="titleheader">Reporting Relationships </h4>
		<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#5b9bd5" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5;">
				<tr><td style="width:25%"><b>Reports to</b></td><td class="normal" style="width:75%">'.@$posdetails['reportsto'].'</td></tr>
				<tr bgcolor="#deeaf6"><td style="width:25%"><b>Reportees</b></td><td class="normal" style="width:75%">'.@$posdetails['reportees_name'].'</td></tr>
		</table>
		<h4 class="titleheader">Position Description</h4>
		<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#5b9bd5" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5;">
				<tr><td style="width:25%"><b>Education Background</b></td><td class="normal" style="width:75%">'.strip_tags(@$posdetails['education']).'</td></tr>
				<tr bgcolor="#deeaf6"><td style="width:25%"><b>Experience</b></td><td class="normal" style="width:75%">'.strip_tags(@$posdetails['experience']).'</td></tr><tr><td style="width:25%"><b>Industry Experience</b></td><td class="normal" style="width:75%">'.strip_tags(@$posdetails['specific_experience']).'</td></tr>

		</table>';
		if(!empty($posdetails['other_requirement'])){
		$jd.='<h4 class="titleheader">Other Requirements:</h4>'.@$posdetails['other_requirement'];
		}
		$jd.='<h4 class="titleheader">Purpose:</h4>'.@$posdetails['position_desc'].'</div>';
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
The definition of various Levels of Proficiency and the Criticality Dimensions are given here under.<br><br>';
$lel=$posdetails['position_type']=='NMS'?'Two':'Four';
$para3.='In case of Functional/ Techincal Competencies there are '.$lel.' Level of profficiency.<br><br>';
if($posdetails['position_type']=='MS'){
	foreach($scale_info_four as $scale_infos){
		$para3.='<b style="font-size:11px;">'.$scale_infos['scale_name'].':</b> '.$scale_infos['description'].'<br><br>';
	}
	if(count($scale_info_five)>0){
		$para3.='<br>For Managerial/ Behavioural Competencies there are Five Levels scale of profficiency as given below.<br><br>';
		foreach($scale_info_five as $scale_infoss){
			$para3.='<b style="font-size:11px;">'.$scale_infoss['scale_name'].':</b> '.$scale_infoss['description'].'<br><br>';
		}
	}
}
if($posdetails['position_type']=='NMS'){
	foreach($scale_info as $scale_infos){
		$para3.='<b style="font-size:11px;">'.$scale_infos['scale_name'].':</b> '.$scale_infos['description'].'<br><br>';
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
	if($posdetails['position_type']=='MS'){
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
	}
	if($posdetails['position_type']=='NMS'){
		$para3.='<br><br><table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#5b9bd5" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5; border:0.5px solid #9999;">
		<thead><tr height="30" bgcolor="#5b9bd5" align="center" class="row header" style="color:#fff;">
				<th>Competencies</th>
				<th>Required Level</th>
				<th>Criticality</th>
			</tr>
		</thead>
		<tbody>';$kk=0;
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

// add a page
$pdf->AddPage();
// -- set new background ---
$pdf->SetFooterMargin(5);
$pdf->Bookmark('4. Interview Questions', 0, 0, '', '', array(0,0,0));
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
$para4='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">The following are a set of INDICATIVE QUESTIONS that you may use in the interview process.  PLEASE NOTE that you can ask other questions or probe further into any other dimension, as deemed fit and depending on the situation.<br>For this Position of '.$posdetails['position_name'].' HR / Recruitment has generated this booklet based on the following<br><br>
<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#5b9bd5" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5; border:0.5px solid #9999;">
	<thead>
		<tr height="30" bgcolor="#5b9bd5" align="center" class="row header" style="color:#fff;">
		<th>Competencies</th>
		<th>Objective Questions</th>
		<th>Total Number of Questions</th>
		</tr>
	</thead>
	<thead>
	<tr class="row header">';
	$comp=!empty($_REQUEST['cri'])?$_REQUEST['cri']:"";
	$int=!empty($_REQUEST['int_type'])?$_REQUEST['int_type']:"";
	$total=!empty($_REQUEST['total'])?$_REQUEST['total']:"";
	$comps=explode(',',$comp);
	$para4.='<th>'.((count($comps)>0)?"All Competencies":"Critical Competencies").'</th>
		<th>'.(($int==1)?"Interview Question":"Interview and CBT Question").'</th>
		<th>'.(($int==1)?$total:($total+$total)).'</th>
	</tr>
	</thead>
</table>';
$tbl = <<<EOD
<table cellspacing="0" cellpadding="0" border="0" >
    <tr>
        <td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">4. Interview Questions<br></span>
	</td>
    </tr>
</table>
$para4
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');



$comp_l1=$comp_l2=$comp_l3=$comp_l4=$comp_l5=array();
$level_l1=$level_l2=$level_l3=$level_l4=$level_l5=array();
$cri_l1=$cri_l2=$cri_l3=$cri_l4=$cri_l5=array();
$cricality_details=UlsCompetencyCriticality::criticality_names_report($_REQUEST['cri']);
$c_id=array();
$i=0;
foreach($cricality_details as $key=>$cricality_detail){
	$c_id[$i]=$cricality_detail['code'];
	$i++;
}
$comp_all=$level_all=$cri_all=array();
if($_REQUEST['int_type']==2){
	$func_competencies=UlsCompetencyPositionRequirements::getcompetency_position_requirement_cat($_REQUEST['pos_id'],$_REQUEST['cat'],$_REQUEST['cri']);
	foreach($func_competencies as $positions){
		$comp_id=$positions['comp_position_competency_id'];
		$comp_all[]=$positions['comp_position_competency_id'];
		$level_all[$comp_id]=$positions['comp_position_level_scale_id'];
		$cri_all[]=$positions['comp_position_criticality_id'];
	}
	$count_v=sizeof($comp_all);
	$no_questions=$_REQUEST['total'];
	$count_all=@(int)($no_questions/$count_v);
	$count_all_limit_mul=@$no_questions-($count_all*$count_v);
	$c1_t=array();
	foreach($comp_all as $key2=>$comps){
		$comp_count_i=UlsQuestions::get_questions_count($comps,'COMP_INTERVIEW',$level_all[$comps]);
		$c1_i[$comps]=$comp_count_i['test_count'];
	}
	asort($c1_i); 
	$k=0;
	$count_q=0;
	foreach($c1_i as $key=>$comps_c1){
		$para_TT="";
		$comp_name=UlsCompetencyDefinition::viewcompetency($key);
		
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
		if($k==0){
			$para_TT='<h3 style="font-family: Helvetica;line-height: 1.5;color:#646464;">Competency Based Interview questions</h3>';
		}
		/* if($key!=0){ 
			$para_TT.='<br><br>';
		} */
		$para_TT.='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">
		<b>'.@$comp_name['comp_def_name'].'</b><br>'.@$comp_name['comp_def_short_desc'].'<br>
		<h4 class="titleheader">What To ask…</h4>';
		if((count($comp_all)-1)==$k){
			$question_counti=UlsQuestions::get_questions_count_comp($key,($count_all+$count_all_limit_mul),$level_all[$key],'COMP_INTERVIEW');
			//echo $comp_name['comp_def_name']."-".count($question_counti);
			if(count($question_counti)>0){
				foreach($question_counti as $keys=>$question_counts){
					$para_TT.=$keys!=0?"<br><br>":"<br>";
					$para_TT.='<i>'.$question_counts['question_name'].'</i><br>';
					$q_values=UlsQuestionValues::get_allquestion_values($question_counts['ques_id']);
					foreach($q_values as $q_value){
						$chk=$q_value['correct_flag']=='Y'? 'checked="checked"'  : '';
						$col=$q_value['correct_flag']=='Y'? 'style="color:green;"':'';
						if(!empty($q_value['text'])){
							$para_TT.='<span '.$col.' class="answer">'.@$q_value['text'].'</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
						}
					}
				}
			}
			else{
				$para_TT.='<b>Sorry!</b> No questions available in this competency…';
			}
			$count_q=0;
		}
		else{
			$question_counti=UlsQuestions::get_questions_count_comp($key,$count_all,$level_all[$key],'COMP_INTERVIEW');
			if(count($question_counti)>0){
				foreach($question_counti as $keys=>$question_counts){
					if($keys!=0){ $para_TT.='<br><br>';}
					$para_TT.='<i>'.$question_counts['question_name'].'</i><br>';
					$q_values=UlsQuestionValues::get_allquestion_values($question_counts['ques_id']);
					foreach($q_values as $q_value){
						$chk=$q_value['correct_flag']=='Y'? 'checked="checked"'  : '';
						$col=$q_value['correct_flag']=='Y'? 'style="color:green;"':'';
						if(!empty($q_value['text'])){
							$para_TT.='<span '.$col.' class="answer">'.@$q_value['text'].'</span><br>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
						}
					}
				}
			}
			else{
				$para_TT.='<b>Sorry!</b> No questions available in this competency…';
			}
		}
		$k++;
		$para_TT.='</div>';
$tbl = <<<EOD
$para_TT
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	
	
	
	$i=0;
	foreach($c1_i as $key1=>$comp_alls){
		$para_TTT='';
		$comp_name=UlsCompetencyDefinition::viewcompetency($key1); 
		
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
		if($i==0){
			$para_TTT='<h3 style="font-family: Helvetica;line-height: 1.5;color:#646464;">Competency Based CBT questions</h3>';
		}
		/* if($i!=0){ 
			$para_TTT='<br><br>';
		} */
		$para_TTT.='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;"><b>'.@$comp_name['comp_def_name'].'</b><br>'.@$comp_name['comp_def_short_desc'].'<br>
		<h4 class="titleheader">What To ask…</h4>';
		if((count($c1_i)-1)==$i){
			$question_countcbt=UlsQuestions::get_questions_count_comp($key1,$count_all+$count_all_limit_mul,$level_all[$key1],'COMP_TEST');
			if(count($question_countcbt)>0){
				foreach($question_countcbt as $keys=>$question_countcbts){
					$para_TTT.=$keys!=0?"<br><br>":"<br>";
					$para_TTT.='<i>'.$question_countcbts['question_name'].'</i><br>';
					$q_values=UlsQuestionValues::get_allquestion_values($question_countcbts['ques_id']);
					foreach($q_values as $q_value){
						$chk=$q_value['correct_flag']=='Y'? 'checked="checked"'  : '';
						$col=$q_value['correct_flag']=='Y'? 'style="color:green;"':'';
						$para_TTT.='<span '.$col.' class="answer">'.@$q_value['text'].'</span><br>';
					}
					$para_TTT.='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				}
				$para_TTT.='<br>';
			}
			else{
				$para_TTT.='<b>Sorry!</b> No questions available in this competency…';
			}
		}
		else{
			$question_counti_nn=UlsQuestions::get_questions_count_comp($key1,$count_all,$level_all[$key1],'COMP_TEST');
			if(count($question_counti_nn)>0){
				foreach($question_counti_nn as $keys=>$question_counti_nns){
					if($keys!=0){ $para_TTT.='<br><br>';}
					$para_TTT.='<i>'.$question_counti_nns['question_name'].'</i><br>';
					$q_values=UlsQuestionValues::get_allquestion_values($question_counti_nns['ques_id']);
					foreach($q_values as $q_value){
						$chk=$q_value['correct_flag']=='Y'? 'checked="checked"'  : '';
						$col=$q_value['correct_flag']=='Y'? 'style="color:green;"':'';
						$para_TTT.='<span '.$col.' class="answer">'.@$q_value['text'].'</span><br>';
					}
					$para_TTT.='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				}
			}
			else{
				$para_TTT.='<b>Sorry!</b> No questions available in this competency…';
			}
		}
		$i++;
		$para_TTT.='</div>';
$tbl = <<<EOD
$para_TTT
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
	}
}












if($_REQUEST['int_type']==1){
	$comp_cri=$level_cri=$cri_cri=array();
	$func_competencies=UlsCompetencyPositionRequirements::getcompetency_position_requirement_cat($_REQUEST['pos_id'],$_REQUEST['cat'],$_REQUEST['cri']);
	foreach($func_competencies as $positions){
		$comp_id=$positions['comp_position_competency_id'];
		$comp_cri[]=$positions['comp_position_competency_id'];
		$level_cri[$comp_id]=$positions['comp_position_level_scale_id'];
		$cri_cri[]=$positions['comp_position_criticality_id'];
	}
	$count_cri=sizeof($comp_cri);
	$no_questions=$_REQUEST['total'];
	$count_c=@(int)($no_questions/$count_cri);
	$count_vital_limit_mul=@$no_questions-($count_c*$count_cri);
	$c1_t=array();
	foreach($comp_cri as $key2=>$comps){
		$comp_count_i=UlsQuestions::get_questions_count($comps,'COMP_INTERVIEW',$level_cri[$comps]);
		$c1_i[$comps]=$comp_count_i['test_count'];
	}
	asort($c1_i);
	$count_q=0;
	$j=0;
	foreach($c1_i as $key=>$comps_c1){
		$para_T="";
		$comp_name=UlsCompetencyDefinition::viewcompetency($key);		
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
		if($j==0){ $para_T='<table cellspacing="0" cellpadding="0" border="0" ><tr><td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">Competency Based Interview questions<br></span></td></tr></table>';
		}
		$para_T.='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;"><b>'.@$comp_name['comp_def_name'].'</b><br>'.@$comp_name['comp_def_short_desc'].'
		<br>
		<h4 class="titleheader">What To ask…</h4>';
		if((count($comp_cri)-1)==$j){
			$question_counti=UlsQuestions::get_questions_count_comp($key,$count_c+$count_vital_limit_mul,$level_cri[$key],'COMP_INTERVIEW');
			if(count($question_counti)>0){
				foreach($question_counti as $keys=>$question_counts){
					$para_T.=($keys!=0)?"<br><br>":"<br>";
					$para_T.='<i>'.$question_counts['question_name'].'</i><br>';
					$q_values=UlsQuestionValues::get_allquestion_values($question_counts['ques_id']);
					foreach($q_values as $q_value){
						$chk=$q_value['correct_flag']=='Y'? 'checked="checked"'  : '';
						$col=$q_value['correct_flag']=='Y'? 'style="color:green;"':'';
						if(!empty($q_value['text'])){
							$para_T.='<span '.$col.' class="answer">'.@$q_value['text'].'</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
						}
					}
				}	
			}
			else{
				$para_T.='<b>Sorry!</b> No questions available in this competency…';
			}
		}
		else{
			$question_counti=UlsQuestions::get_questions_count_comp($key,$count_c,$level_cri[$key],'COMP_INTERVIEW');
			if(count($question_counti)>0){
				foreach($question_counti as $keys=>$question_counts){
					$para_T.=$keys!=0?"<br><br>":"<br>";
					$para_T.='<i>'.$question_counts['question_name'].'</i><br>';
					$q_values=UlsQuestionValues::get_allquestion_values($question_counts['ques_id']);
					foreach($q_values as $q_value){
						$chk=$q_value['correct_flag']=='Y'? 'checked="checked"'  : '';
						$col=$q_value['correct_flag']=='Y'? 'style="color:green;"':'';
						if(!empty($q_value['text'])){
							$para_T.='<span '.$col.' class="answer">'.@$q_value['text'].'</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
						}
					}
				}
			}
			else{
				$para_T.='<b>Sorry!</b> No questions available in this competency…';
			}
		}
		$j++;
		$para_T.='</div>';
		
$tbl = <<<EOD
$para_T
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
	}
}

// add a page
$pdf->AddPage();
// -- set new background ---
$pdf->SetFooterMargin(5);
$pdf->Bookmark('5. Interviewer Remarks & Comments', 0, 0, '', '', array(0,0,0));
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
$para5='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">As  interviewer,  we  know  that  you  would  want  to  take  either  a  granular  picture  of  the  applicant  or  holistic  perspective,  either way, there is a provision to capture that information.<br><br>
<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#5b9bd5" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5; border:0.5px solid #9999;"><tr bgcolor="#deeaf6"><td width="25%">Name of Applicant</td><td width="75%"></td></tr></table><h4>Competency Profile</h4>';
	if($posdetails['position_type']=='MS'){
	foreach($category as $categorys){
		$competencies=UlsCompetencyPositionRequirements::getcompetencypositionrequirements_cat($_REQUEST['pos_id'],$categorys['category_id']);
		$para5.='<br><br><span align="left" style="text-transform: uppercase; font-family: Helvetica;font-size: 14px;color:#5b9bd5; line-height: 1.5;">'.$categorys['name'].'</span><br><br>';
		$para5.='<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#5b9bd5" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5;">
		<thead><tr height="30" bgcolor="#5b9bd5" align="center" class="row header" style="color:#fff;">
			<th>Competency/Skill</th>
			<th>Level Requirement</th>
			<th>Criticality</th>
			<th>Assessed Level</th>
			</tr>
		</thead>
		<tbody>';
		$kk=0;
		foreach($competencies as $competency){
			if($competency['comp_position_id']==$posdetails['position_id']){
				$bgcolor=($kk%2==0)?"#deeaf6":"#ffffff";
				$kk++;
				$para5.='<tr bgcolor="'.$bgcolor.'">
				<td>'.$competency['comp_def_name'].'</td>
				<td>'.$competency['scale_name'].'</td>
				<td>'.$competency['comp_cri_name'].'</td>
				<td></td>
			</tr>';
			}
		}
		$para5.='</tbody>
		</table>';
	}
	}
	if($posdetails['position_type']=='NMS'){
		$para5.='<br><br><table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#5b9bd5" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5; border:0.5px solid #9999;">
		<thead><tr height="30" bgcolor="#5b9bd5" align="center" class="row header" style="color:#fff;">
				<th>Competencies</th>
				<th>Required Level</th>
				<th>Criticality</th>
				<th>Assessed Level</th>
			</tr>
		</thead>
		<tbody>';$kk=0;
	foreach($competencies as $competency){
		if($competency['comp_position_id']==$posdetails['position_id']){
		$bgcolor=($kk%2==0)?"#deeaf6":"#ffffff";
		$kk++;
		$para5.='<tr bgcolor="'.$bgcolor.'">
		<td>'.$competency['comp_def_name'].'</td>
		<td>'.$competency['scale_name'].'</td>
		<td>'.$competency['comp_cri_name'].'</td>
		<td></td>
		</tr>';
		}
	}
	$para5.='</tbody>
	</table>';
	}
$para5.='</div>';
$tbl = <<<EOD
<table cellspacing="0" cellpadding="0" border="0" >
    <tr>
        <td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">5. Interviewer Remarks & Comments<br></span>
	</td>
    </tr>
</table>
$para5
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
$para6='<h4 style="font-family: Helvetica;line-height: 1.5;color:#646464;">Comments & Observations on other Competencies/Areas</h4><div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">
<div style="width:100%;border:1px solid #5b9bd5;borderradius:10px;">&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br></div>
<br><b>Suitable for the  Position of '.$posdetails['position_name'].'</b>:&nbsp;&nbsp;&nbsp;<label><b>Yes</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><b>No</b></label>
<h4 style="font-family: Helvetica;line-height: 1.5;color:#646464;">Development Recommendations if selected</h4>
<div style="width:100%;border:1px solid #5b9bd5;borderradius:10px;">&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br></div>
</div>';
$tbl = <<<EOD

$para6

EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
 // add a page
$pdf->AddPage();
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
$img_file = K_PATH_IMAGES.'adanipower/adani-power-backcover.jpg';
$pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
// restore auto-page-break status
//$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();
$pdf->writeHTML("", true, false, false, false, '');

// add a new page for TOC
$pdf->addTOCPage();
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


//Close and output PDF document
$pdf->Output('Assessment-Booklet.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+