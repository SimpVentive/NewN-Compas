<?php
ini_set('display_errors',1);
$formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);
function svgbarr($wid,$wid1,$paraname,$ass_id,$emp_id,$pos_id,$ht=''){
	$target_path=__SITE_PATH.DS.'public'.DS.'reports'.DS.'graphs'.DS.'full'.DS.$ass_id;
	$height=!empty($ht)?$ht:'26';
	$a=$wid*60;
	$b=$wid1*60;
	if($a>360 || $b>360){
		$a=$a/2;
		$b=$b/2;
	}
	$value='<svg class="britechart bar-chart" width="500" height="80"><g class="container-group" transform="translate(10, 20)"><g class="chart-group"><rect class="bar" y="30" x="0" height="'.$height.'" width="'.$b.'" fill="#FCB614"></rect><rect class="bar" y="0" x="0" height="'.$height.'" width="'.$a.'" fill="#0098DB"></rect><text x="'.($a+3).'" y="20" fill="#666666">'.$wid.'</text><text x="'.($b+3).'" y="50" fill="#666666">'.$wid1.'</text></g></g></svg>';
	$myfile = fopen($target_path.DS.'bar_'.$emp_id.'_'.$pos_id.'_'.$paraname.'.svg', "w") or die("Unable to open file!");
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
if($posdetails['position_structure']=='A'){
	$pos_name=UlsPosition::pos_details($posdetails['position_structure_id']);
	$posname=$pos_name['position_name'];
}
else{
	$posname=$posdetails['position_name'];
}
$txt='<label class="fish5" text-align="right;" width="100%"><b style="font-size:30pt;color:#fff;font-family: Helvetica;">Assessment Report</b></label><br><br><br>
<label class="fish6"><b style="font-size:26pt;color:#fff;"><br></b></label><br><br><br>
<img src="'.LOGO_IMG_PDF.'" style="margin:0.15cm 0.2cm" width="200"  class="fish"><br><br><br>
<label class="fish1"><b style="font-size:22pt;color:#000;font-family: Helvetica;">'.trim($emp_info['name']).'</b><br><b style="font-size:14pt;color:#000;font-family: Helvetica;">'.@$posname.'</b></label>';
	
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
$para1="NOTE:&nbsp;This report and its contents are the property of ".$emp_info['parent_organisation']." and no portion of the same should be copied or reproduced without the prior permission of ".$emp_info['parent_organisation']." OR HeadNorth Talent Solutions.";

$tbl = <<<EOD
<div style="height: 750px;bottom:0px;">&nbsp;<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></div>
<div style="color:red;padding-left:5px;font-family: Helvetica;font-size:10px;line-height:1.5;">$para1<br>
<span style="padding-left:5px;font-family: Helvetica;font-size:10px;color:#646464;">For further information on Competencies, Competency modelling and assessment, please refer to the FAQ section in <a href="http://n-compas.com/" target="_blank">www.N-Compas.com </a><span></div>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');


// add a page
$pdf->AddPage();
// -- set new background ---
$pdf->SetFooterMargin(5);
$pdf->Bookmark('1. INTRODUCTION', 0, 0, '', '', array(0,0,0));
$pdf->Bookmark('*&nbsp;&nbsp;WHAT IS THIS ALL ABOUT?', 1, 0, '', '', array(0,0,0));
$pdf->Bookmark('*&nbsp;&nbsp;WHAT IS THE BASIC FRAMEWORK OF THIS PROCESS?', 1, 0, '', '', array(0,0,0));
$pdf->Bookmark('*&nbsp;&nbsp;WHAT ARE THE ASSESSMENT METHODS USED?', 1, 0, '', '', array(0,0,0));
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
$comp_data="";
$comp_data.="<ol>";
	foreach($ass_comp as $ass_comps){
		$comp_data.="<li>".$ass_comps['comp_def_name']."</li>";
	}
$comp_data.="</ol>";
$level_count=count($scale_info_four);
$level_name="";
foreach($scale_info_four as $key=>$scale_info_fours){
	if($key==0){
		$level_name.=$scale_info_fours["scale_name"];
	}
	else{
		$level_name.=", ".$scale_info_fours["scale_name"]."";
	}
	if(($key+1)==$level_count){
		$level_name.=".";
	}
	
}
$level_desc="";
foreach($scale_info_four as $k=>$scale_infos){
	$level_desc.=$k!=0?'<br><br>':'';
	$level_desc.='<b style="font-size:11px;">'.$scale_infos['scale_name'].':</b> '.$scale_infos['description'];
}
$cri_desc="";
$cre_count=count($cri_info);
foreach($cri_info as $k=>$cri_infos){
	$cri_desc.=$k!=0?'<br><br>':'';
	$cri_desc.='<b style="font-size:11px;">'.$cri_infos['name'].':</b> '.$cri_infos['description'];
}
$tbl = <<<EOD
<table cellspacing="0" cellpadding="0" border="0" >
    <tr>
        <td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">1. INTRODUCTION</span>		
	</td>
    </tr>
</table>
<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">
	<br><span align="left" style="font-family: Helvetica;font-size: 14px;color:#36a2eb; line-height:1.5;">WHAT IS THIS ALL ABOUT?<br></span>
	As you are aware every organization is constantly in the process of improving the capabilities of its employees through various developmental efforts to enable them reach their true potential. <b>Heidelberg</b> as a forward looking and progressive organization has drawnup an ambitious process of competency building of its critical /key personnel of the Heidelberg ecosystem. This developmental initiative is focused on developing the Functional & Technical and Managerial & Behavioural competencies of its key resources namely Regional Managers, through a systematic Assessment and Development process, with an end objective of focused learning and development for each individual.
	<br><br>
	<span align="left" style="font-family: Helvetica;font-size: 14px;color:#36a2eb; line-height:1.5;">WHAT IS THE BASIC FRAMEWORK OF THIS PROCESS?<br></span><br>
	Every job in the organization has a set of accountabilities, which are measured in terms of the outcomes, referred to as KRAs. These (KRAs), in order to be achieved, would require a certain set of Competencies. These competencies in turn are classified along the Functional & Technical, Managerial & Behavioural dimensions. Based on the various positions in the organization, a set of competencies have been identified for the position of Regional Manager - Sales & Marketing.<br>
	These competencies were identified keeping in mind the critical deliverables of the job(s) and include<br>
		$comp_data
	<br>
	<b>COMPETENCY PROFILING</b>
	<br><br>
	Each position has been defined in terms of the competency requirement, referred to as a <b>Competency Profile</b>. 
	<br><br>
	In order to do the Competency Profiling, a Competency Dictionary was prepared where in the definitions of each of the competencies was carefully defined with 4 levels of competency $level_name 
	<br><br>
	The process of mapping the position in terms of required level of Competencies - that is determining the level of Proficiency and Criticality at which these competencies are required for the successful performance of the job, is referred to as Competency Profiling. The Competency Profiling of this position is given in the next section.
	<br><br>
	The two dimensions of Profiling are Proficiency and Criticality, which are explained below:
	<br><br>
	<b>DIMENSION ONE - Level of Proficiency:</b> Below is a brief explanation of the same:<br><br>
	$level_desc
	<br><br>
	<b>DIMENSION TWO - Level of Criticality:</b> 
	<br><br>
	<b>The second dimension,</b> in Competency Profiling is called the Level of Criticality, which in turn is split into $cre_count categories<br><br>
	$cri_desc
	<br><br>
	<span align="left" style="font-family: Helvetica;font-size: 14px;color:#36a2eb; line-height:1.5;">WHAT ARE THE ASSESSMENT METHODS USED?<br><br></span>
	In order to assess each of the employees systematically and comprehensively with respect to the above competencies, the following assessment methods were designed and rolled out.<br><br>
	<b>MCQ or Multiple Choice Questions:</b> These are questions which are based on your product, process/SOP and related aspects.<br><br>
	<b>In-basket Exercises:</b> As an executive, your day comprises of a number of activities. How you organize your day, both in terms of time - prioritization and the quality of action - how you choose to act or what you delegate, reflects on your capabilities.<br><br>
	<b>Caselets:</b> These are small situational narratives which have been built around your typical issues/aspects which you encounter in your everyday work. How you handle these reflects your technical and to some extent managerial capabilities as well.<br><br>
	<b>360° Feedback:</b> A 360° feedback process gathers structured inputs from an employee’s managers, peers, subordinates, and other stakeholders to offer a holistic view of behavioural strengths and development areas. It helps identify blind spots, enhances self-awareness, and anchors personalised development plans.<br><br>
	<b>Jungian Personality Test:</b> Rooted in Carl Jung’s psychological typologies, this assessment identifies natural preferences in how individuals perceive information, make decisions, and interact with the world. It offers deep insights into personality patterns, communication styles, and team compatibility.<br><br>
	<b>Assessment Centre:</b> The Assessment Centre will include a structured personal interview and a presentation round. Candidates will present the case study they solved during the pre-assessment, followed by a focused competency-based interview. This offers a quick, reliable view of both their analytical ability and behavioural strengths.
	<br>
</div>

EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');


$para_cat='';
$para_cat.='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">';
$para_cat.='Following is the Competency Profile that has been used for the process of Assessment ';
foreach($category as $categorys){
	$ass_comp_info=UlsAssessmentReport::getassessment_admin_competency($ass_id,$pos_id,$categorys['category_id']);	
	$para_cat.='<br><br><b align="left" style="font-family: Helvetica;font-size: 14px;color:#36a2eb; line-height: 1.5;">'.$categorys['name'].'</b><br>';
	$para_cat.='<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#59b0ea" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5; border:0.5px solid #9999;">
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
		$results[$comp_id]['comp_cri_code']=$ass_comp_infos['comp_cri_code'];
		$results[$comp_id]['req_scale_count']=$ass_comp_infos['req_scale'];
	}$kk=0;
	foreach($results as $comp_def_id=>$result){
		$final_admin_id=$_SESSION['user_id'];
		$bgcolor=($kk%2==0)?"#deeaf6":"#ffffff";
		$kk++;
		$color=($result['comp_cri_code']=='C1')?'style="color:red"':'';
		$para_cat.='<tr>
		<td >'.$result['comp_name'].'</td>
		<td '.$color.'>'.$result['req_scale_name'].'</td>
		<td '.$color.'>'.$result['comp_cri_name'].'</td>		
		</tr>';
	}
	$para_cat.='</tbody>
	</table>';
}
$para_cat.='<br><br>Note:  The critical competencies are <span style="color:red">MARKED IN RED </span></div>';	
// add a page
$pdf->AddPage();
// -- set new background ---
$pdf->SetFooterMargin(5);
$pdf->Bookmark('*&nbsp;&nbsp;WHAT IS THE SCOPE OF THIS ASSESSMENT?', 1, 0, '', '', array(0,0,0));
$pdf->Bookmark('2. HOW TO READ THIS REPORT?', 0, 0, '', '', array(0,0,0));
$pdf->Bookmark('3. COMPETENCY PROFILE USED FOR ASSESSMENT ', 0, 0, '', '', array(0,0,0));
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

<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">
	<br>
	
	<span align="left" style="font-family: Helvetica;font-size: 14px;color:#36a2eb; line-height:1.5;">WHAT IS THE SCOPE OF THIS ASSESSMENT?<br></span><br>
	This assessment will focus on evaluating the incumbents technical/functional and managerial/behavioural competencies, and will culminate in a tailored development roadmap. 
	<br><br><br>
	<table cellspacing="0" cellpadding="0" border="0" >
		<tr>
			<td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">2. HOW TO READ THIS REPORT?</span>		
		</td>
		</tr>
	</table>
	<br>
	<br>
	Please read each section of the Report carefully. The Report helps you to understand the process of assessment you have undergone through the basket of assessment methods, scores generated and the analysis and interpretation of the data obtained. The report also provides you insights into your areas of strengths and areas which require planned development interventions and efforts. Also captured in the report is a section on your workplace behavioral patterns assessed through Jungian Personality Test.<br>
	<br><br>
	<table cellspacing="0" cellpadding="0" border="0" >
    <tr>
        <td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">3. COMPETENCY PROFILE USED FOR ASSESSMENT <br></span>
	</td>
    </tr>
</table>
$para_cat
</div>

EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');


$sdate = $emp_info['date_of_joining'];
$edate = date("Y-m-d");

$date_diff = abs(strtotime($edate) - strtotime($sdate));

$years = floor($date_diff / (365*60*60*24));
$months = floor(($date_diff - $years * 365*60*60*24) / (30*60*60*24));
$days = floor(($date_diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

/* if($months<6){
	$feed_weightage=5;
}
else{
	$feed_weightage=10;
} */
$pdf->AddPage();
$pdf->footershow=true;
$pdf->SetFooterMargin(5);
$pdf->Bookmark('4. COMPETENCY ASSESSMENT OVERVIEW', 0, 0, '', '', array(0,0,0));
$index_link = $pdf->AddLink();
$pdf->SetLink($index_link, 0, '*1');
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();

$para178='<table cellspacing="0" cellpadding="0" border="0" >
    <tr>
        <td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">4. COMPETENCY ASSESSMENT OVERVIEW<br></span>		
	</td>
    </tr>
</table>
<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">This part of the Report covers the methods employed for the assessment of the position, weightages for each method and the duration for each method.  It also covers in detail the results of the assessment which include the scores obtained in each method of assessment, analysis and the interpretation of the data.
</div>';
$ass_methods='<span align="left" style="font-family: Helvetica;font-size: 14px;color:#36a2eb; line-height:1.5;">ASSESSMENT METHODS<br></span>';
$ass_methods.='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">The Following Assessment methods were being used for this position. Also indicated in the table are the corresponding weightages for each of the assessment methods.<br><br>
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
		if($testtype['assessment_type']=='FEEDBACK'){
			//$weightage=$feed_weightage."%";
			$weightage=$testtype['weightage']."%";
		}
		else{
			$weightage=(!empty($testtype['weightage']) && $testtype['weightage']!=0)?$testtype['weightage']."%":"--";
		}
		$assess_type="";
		/* $assess_type=($testtype['assessment_type']=='BEHAVORIAL_INSTRUMENT')?'Jungian Personality Test':$testtype['assess_type'];
		$assess_type=($testtype['assessment_type']=='TEST')?'MCQ':$testtype['assess_type'];
		$assess_type=($testtype['assessment_type']=='FEEDBACK')?'360 Feedback':$testtype['assess_type'];
		$assess_type=($testtype['assessment_type']=='INTERVIEW')?'Assessment Centre':$testtype['assess_type']; */
		if($testtype['assessment_type']=='BEHAVORIAL_INSTRUMENT'){
			$assess_type.='Jungian Personality Test';
		}
		elseif($testtype['assessment_type']=='TEST'){
			$assess_type.='MCQ';
		}
		elseif($testtype['assessment_type']=='FEEDBACK'){
			$assess_type.='360&deg; Feedback';
		}
		elseif($testtype['assessment_type']=='INTERVIEW'){
			$assess_type.='Assessment Centre';
		}
		else{
			$assess_type.=$testtype['assess_type'];
		}
		$time_details=!empty($testtype['time_details'])?$testtype['time_details']." mins" :"-";
		$ass_methods.='<tr bgcolor="'.$bgcolor.'">';
		$ass_methods.='<td align="center" width="10%">'.$i.'</td>';
		$ass_methods.='<td width="40%">'.$assess_type.'</td>';
		$ass_methods.='<td width="30%">'.$weightage.'</td>';
		$ass_methods.='<td width="20%">'.$time_details.'</td></tr>';
		$i++;
	}
	$ass_methods.='</tbody>
	</table>
</div>';
$tbl = <<<EOD
$para178
<br style="clear:both;">
$ass_methods

EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');


$pdf->AddPage();
$pdf->footershow=true;
$pdf->SetFooterMargin(5);
$pdf->Bookmark('5. CONSOLIDATED SUMMARY OF RESULTS ', 0, 0, '', '', array(0,0,0));
$index_link = $pdf->AddLink();
$pdf->SetLink($index_link, 0, '*1');
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();
$total_all_weight=0;
$cluster_wei=array();$kkk=1;$keyy=0;
$ass_comp_info=UlsAssessmentReport::getassessment_admin_competency($_REQUEST['ass_id'],$_REQUEST['pos_id']);
$ass_method_inbasket=$ass_method_case=$ass_method_interview=0;		
$results_comp=$result_assessor=$assessor=$results_comp_logic=array();
$ass_method_score="";
foreach($ass_comp_info as $ass_comp_infos){
	$comp_id=$ass_comp_infos['comp_def_id'];
	$req_scale_id=$ass_comp_infos['req_scale_id'];
	$results_comp[$comp_id]['comp_id']=$comp_id;
	$results_comp[$comp_id]['comp_name']=$ass_comp_infos['comp_def_name'];
	$results_comp[$comp_id]['pos_com_weightage']=$ass_comp_infos['pos_com_weightage'];
	$results_comp[$comp_id]['comp_cri_code']=$ass_comp_infos['comp_cri_code'];
}
/* echo "<pre>";
print_r($assessor_rating_new); */
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
			//$ass_method_test=$assessor_ratings['event_id'];
			$ass_method_test=round(($assessor_ratings['test_score']/$assessor_ratings['test_ques'])*100,2);
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
$getweights=UlsMenu::callpdo("SELECT * FROM `uls_assessment_competencies_weightage` WHERE `assessment_id`='".$_REQUEST['ass_id']."' and `position_id`='".$_REQUEST['pos_id']."'");
$allweights=array();
foreach($getweights as $wei){
	//$final_weightage=($wei['assessment_type']=='FEEDBACK')?$feed_weightage:$wei['weightage'];
	$final_weightage=$wei['weightage'];
	$assessment_type=$wei['assessment_type'];
	$allweights[$assessment_type]=$final_weightage;
}
/* echo "<pre>";
print_r($allweights) */;
$ass_comp_info=UlsAssessmentReportBytype::report_bytype_competencies($_REQUEST['ass_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id']);
$results_comp_logic=array();
foreach($ass_comp_info as $ass_comp_infos){
	$comp_id=$ass_comp_infos['comp_def_id'];
	$req_scale_id=$ass_comp_infos['assessment_pos_level_scale_id'];
	$results_comp_logic[$comp_id]['comp_id']=$comp_id;
	$results_comp_logic[$comp_id]['cat_id']=$ass_comp_infos['comp_def_category'];
	$results_comp_logic[$comp_id]['req_level']=$ass_comp_infos['scale_number'];
	$results_comp_logic[$comp_id]['comp_name']=$ass_comp_infos['comp_def_name'];
	$results_comp_logic[$comp_id]['comp_cri_name']=$ass_comp_infos['comp_cri_name'];
	$results_comp_logic[$comp_id]['pos_com_weightage']=$ass_comp_infos['pos_com_weightage'];
}
/* echo "<pre>";
print_r(results_comp_logic); */
$getdats=UlsMenu::callpdo("SELECT avg(b.scale_number) as required,avg(c.scale_number) as assessed,a.`position_id`,a.`employee_id`,a.`assessment_type`,a.`competency_id`,ct.comp_def_category ,a.interview_ass_value FROM `uls_assessment_report_bytype` a 
inner join(SELECT `assessment_pos_assessor_id`,`assessment_id`,`position_id`,`assessor_val`,assessor_id FROM `uls_assessment_position_assessor`) ac on ac.assessor_id=a.assessor_id and a.assessment_id=ac.assessment_id and a.`position_id`=ac.position_id
inner join uls_level_master_scale b on a.`require_scale_id`=b.scale_id inner join uls_level_master_scale c on a.`assessed_scale_id`=c.scale_id 
left join(SELECT `comp_def_id`,`comp_def_name`,`comp_def_category` FROM `uls_competency_definition`) ct on ct.comp_def_id=a.competency_id
WHERE a.`assessment_id`='".$_REQUEST['ass_id']."' and a.`employee_id`='".$_REQUEST['emp_id']."' and a.`position_id`='".$_REQUEST['pos_id']."' group by a.`competency_id`, a.`assessment_type` ORDER BY `a`.`assessment_type` ASC");
$getdatfeeds=UlsMenu::callpdo("SELECT avg(a.`rater_value`) as val,a.`element_competency_id`,ct.comp_def_category FROM `uls_feedback_employee_rating` a 
left join(SELECT `comp_def_id`,`comp_def_name`,`comp_def_category` FROM `uls_competency_definition`) ct on ct.comp_def_id=a.element_competency_id
 WHERE `assessment_id`='".$_REQUEST['ass_id']."' and `employee_id`='".$_REQUEST['emp_id']."' and `giver_id`!='".$_REQUEST['emp_id']."' and `rater_value` is not null and `rater_value`!=0 group by `element_competency_id`");

/* $pdf->AddPage();
$pdf->footershow=true;
$pdf->SetFooterMargin(0);
$pdf->Bookmark('6. Competency Assessment Overview', 0, 0, '', '', array(0,0,0));
$index_link = $pdf->AddLink();
$pdf->SetLink($index_link, 0, '*1');
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(true, 25);
//$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();

$tbl = <<<EOD

$final_table
EOD;
$pdf->writeHTML($tbl, true, false, false, false, ''); */

$allcomp=$allcompreq=array();
foreach($getdats as $aa){
	$cid=$aa['competency_id'];
	$catid=$aa['comp_def_category'];
	$ctype=$aa['assessment_type'];
	if($ctype=='INTERVIEW'){
		$score_data=round($aa['interview_ass_value'],2);
	}
	else{
		$score_data=round($aa['assessed'],2);
	}
	
	
	$allgg[$cid][$ctype]['score']=$score_data;
	$allcomp_score_a[$cid][$ctype]['score']=$score_data;
	$allcomp[$cid][$ctype]=$aa['assessed'];
	$allcompreq[$cid]=$aa['required'];
}

foreach($getdatfeeds as $aaa){
	$cid=$aaa['element_competency_id'];
	$ctype="FEEDBACK";
	$catid=$aaa['comp_def_category'];
	$allcompfeed[$cid][$ctype]=$aaa['val'];
	$rat=round($aaa['val'],2);
	$score_data=round((100 - (($rat - 1) * ((100 - 0) / (4 - 1)))),2);
	$allcomp_score_a[$cid][$ctype]['score']=$rat;
}
/* echo "<pre>";
print_r($allcomp_score_a); */
$final_table='';
$final_table.='<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#59b0ea" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5;">
	<thead><tr height="30" bgcolor="#59b0ea" align="center" class="row header" style="color:#fff;">
			<th width="30%">Competency Name</th>
			<th width="10%">Level</th>
			<th width="10%">Final Score</th>
		</tr>
	</thead>
	<tbody>';
	
	$final_wei=0;
	$kkk=$ccc=1;
	$val_c=1;
	$cat_ass_one=$cat_ass_final_one=$ass_val_final=$rating_final_val=0;
	foreach($results_comp_logic as $results_comps){
		$comp_id=$results_comps['comp_id'];
		$cat_sub_type=$results_comps['cat_id'];
		$keyy=$results_comps['comp_id'];
		$method=array();
		$me_sum=0;
		foreach($allcomp_score_a[$comp_id] as $key=>$method_val){
			$method[]=$allweights[$key];
			
		}
		/* echo "<pre>";
		print_r($method); */
		$rmethod=array();
		
		foreach($allcomp_score_a[$comp_id] as $key=>$method_val){
			/* echo "<pre>";
			print_r($allweights[$key]); */
			$remain_we=100-(array_sum($method));
			
			$me_sum+=($allweights[$key]/array_sum($method))*$method_val['score'];
		}
		//echo "<br>".$allweights[$key]."-".$remain_we."-".array_sum($method)."-".$comp_id."-".$method_val['score'];
		/* echo "<pre>";
		print_r($me_sum); */
		
		$final_val=round($me_sum,2);
		$rating_final_val+=$results_comps['req_level'];
		//$final_wei+=round((($final_val*$results_comps['pos_com_weightage'])/100),2);
		$final_wei+=round($final_val,2);
		//$ass_val=round(($results_comps['req_level']*$final_val)/100,2);
		//$ass_val=round($results_comps['req_level'],2);
		$ass_val_final+=$final_val;
		$final_table.='<tr>
			<td width="30%">'.$results_comps['comp_name'].'</td>
			<td width="10%">'.$results_comps['req_level'].'</td>
			<td width="10%">'.$final_val.'</td>
		</tr>';
		$kkcomp_id[$keyy]="C".($kkk);
		$kkreq_sid[$keyy]=@round($allcompreq[$keyy],0);//$result['req_val'];
		$kkass_sid[$keyy]=$final_val;
		$kkcomp_name[$keyy]=$results_comps['comp_name'];
		$kkk++;
		
	}
	$final_table.='<tr>
		<td></td>
		<td>'.$rating_final_val.'</td>
		
		<td>'.$final_wei.'</td>
	</tr>';
	$final_table.='</tbody>
</table>';
//echo $final_table;
$results=$assessor=$comname=$comp_id=array();
foreach($results_comp_logic as $key1=>$result){
	$comp_id[$result['comp_id']]="C".($key1+1);
	$comname[$result['comp_id']]=$result['comp_name'];
}
$minreq=min($kkreq_sid);
$minass=min($kkass_sid);
$maxreq=max($kkreq_sid);
$maxass=max($kkass_sid);
//$minv=($minreq<$minass)?($minreq-0.5):($minass-0.5);
$minv=($minreq<$minass)?($minreq):($minass);
$minv=($minv>0.5)?0.5:0;
$maxv=($maxreq>$maxass)?$maxreq:$maxass;
$maxv=$maxv+0.5;
$division=round(($maxv-$minv/5),1);
//$division=0.5;
require_once(LIB_PATH.DS.DS.'graph'.DS.'includes'.DS.'SVGGraph.php');
$settings = array(
	'back_colour'       => '#fff',    'stroke_colour'      => '#666',
	'back_stroke_width' => 0,         'back_stroke_colour' => '#fff',
	'axis_colour'       => '#666',    'axis_overlap'       => 2,
	'axis_font'         => 'Georgia', 'axis_font_size'     => 14,
	'grid_colour'       => '#666',    'label_colour'       => '#666',
	'pad_right'         => 50,        'pad_left'           => 50,
	'link_base'         => '/',       'link_target'        => '_top',
	'fill_under'        => false,	  'line_stroke_width'=>5,
	'marker_size'       => 6,
	//'grid_division_v' =>5,
	'minimum_subdivision' =>$division,
	'axis_min_v' => $minv,
	'axis_max_v' => $maxv,
	'show_subdivisions' => true,
	'show_grid_subdivisions' => false,
	'grid_subdivision_colour' => '#ccc',
	//'marker_type'       => array('*', 'star'),
	//'marker_colour'     => array('#008534', '#850000')
	'legend_position' => "outer bottom 150 0",
	'legend_stroke_width' => 0,
	'legend_shadow_opacity' => 0,
	'legend_title' => "Legend", 'legend_colour' => "#666",
	'legend_columns' => 4,
	'legend_text_side' => "right",
	'legend_font_size'=>15,
	'reverse'=>true
);
$settings['legend_entries'] = array('Required Level', 'Assessed Level');

$val=array();
$val_required=array_combine($kkcomp_id,$kkreq_sid);
$val_assessed=array_combine($kkcomp_id,$kkass_sid);

$values = array($val_required,$val_assessed);
$colours = array(array('#b12c43', '#b12c43'), array('#008534', '#008534'));
$graph = new SVGGraph(600, 600, $settings);
$graph->colours = $colours;
$graph->Values($values);
$value11=$graph->Fetch('MultiRadarGraph', false);//$graph->Fetch('MultiRadarGraph', false);
$target_path=__SITE_PATH.DS.'public'.DS.'reports'.DS.'graphs'.DS.'full'.DS.$_REQUEST['ass_id'];
if(is_dir($target_path)){
	//echo "Exists!";
} 
else{ 
	//echo "Doesn't exist" ;
	mkdir($target_path,0777);
	// Read and write for owner, nothing for everybody else
	chmod($target_path, 0777);
	//print "created";
}

$myfile = fopen($target_path.DS.$_REQUEST['emp_id']."_".$_REQUEST['pos_id'].'_radar.svg', "w") or die("Unable to open file!");
//$target_path='public'.DS.'feedback'.DS.$feedid.DS.$name.'.svg';
//$myfile = fopen($target_path, "w") or die("Unable to open file!");
fwrite($myfile, $value11);
fclose($myfile);
$results_rating='';
$results_rating.='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">
The following is a snapshot or a summary of the entire assessment<br><br>
<table cellspacing="0" cellpadding="5" border="0.5px" align="left" style="width:100%;font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5; border:0.5px solid #9999;">
	<thead>
		<tr bgcolor="#59b0ea" align="center" style="color:#fff;" class="row header">
			<th style="width:40%">Competency</th>
			<th style="width:30%">Criticality</th>
			<th style="width:15%">Required Level</th>
			<th style="width:15%">Assessed Level</th>
		</tr>
		
	</thead>
	<tbody>';
	$total_all_weight=0;
	$cluster_wei=array();$kkk=1;
	$keyy=0;
		
		$results=$result_assessor=$assessor=array();
		$ass_method_score="";
		
		$total_ass_score=$total_req_score=0;
		foreach($results_comp_logic as $comp_def_id=>$result){
			
			$keyy=$result['comp_id'];
			$total_ass_score+=$kkass_sid[$keyy];
			$total_req_score+=$kkreq_sid[$keyy];
			$results_rating.='<tr>
				<td style="width:40%;">'.$result['comp_name'].'</td>
				<td style="width:30%">'.$result['comp_cri_name'].'</td>
				<td style="width:15%">'.$result['req_level'].'</td>
				<td style="width:15%">'.$kkass_sid[$keyy].'</td>
			</tr>';
		}
		$results_rating.='<tr>
			<td colspan="3">Total Assessed Value </td>
			<td>'.$total_ass_score.'</td>
		</tr>';
	$results_rating.='</tbody>
</table>

	
	<br style="clear:both;">';	
$image1 = BASE_URL.'/public/reports/Assessment-Centre.png';
$image2 = BASE_URL.'/public/reports/inbasket.png';
$image3 = BASE_URL.'/public/reports/casestudy.png';
$image4 = BASE_URL.'/public/reports/360degree.png';
$image5 = BASE_URL.'/public/reports/MCQ_Icon.png';
$pic1 = BASE_URL.'/public/reports/pic1.png';
if($emp_info['critical_metric_two']==1){
	$pic2 = BASE_URL.'/public/reports/Poor.png';
}
elseif($emp_info['critical_metric_two']==2){
	$pic2 = BASE_URL.'/public/reports/Average.png';
}
elseif($emp_info['critical_metric_two']==3){
	$pic2 = BASE_URL.'/public/reports/Good.png';
}
elseif($emp_info['critical_metric_two']==4){
	$pic2 = BASE_URL.'/public/reports/Excellent.png';
}
if($ass_final_rating['rating_number']==1){
	$pic3 = BASE_URL.'/public/reports/takeoffc.png';
}
else{
	$pic3 = BASE_URL.'/public/reports/takeoff.png';
}
if($ass_final_rating['rating_number']==2){
	$pic4 = BASE_URL.'/public/reports/taxiingc.png';
}
else{
	$pic4 = BASE_URL.'/public/reports/taxiing.png';
}
if($ass_final_rating['rating_number']==3){
	$pic5 = BASE_URL.'/public/reports/hangerc.png';
}
else{
	$pic5 = BASE_URL.'/public/reports/hanger.png';
}

$the_degree=UlsMenu::callpdorow("SELECT avg(`rater_value`) as val FROM `uls_feedback_employee_rating` WHERE `assessment_id`='".$_REQUEST['ass_id']."' and `employee_id`='".$_REQUEST['emp_id']."' and `giver_id`!='".$_REQUEST['emp_id']."' and `rater_value` is not null and `rater_value`!=0");
$ratval=round($the_degree['val'],2);
$para_radar="";
foreach($kkcomp_name as $key=>$val_selfs){	
	$para_radar.=$kkcomp_id[$key].'-'.$val_selfs.', ';
}
$pec_bench=UlsAssessmentTest::get_ass_position($_REQUEST['ass_id'],$_REQUEST['pos_id'],'BEHAVORIAL_INSTRUMENT');
$instrument=UlsAssessmentTestBehavorialInst::get_behavorial_assessment_report($testtypes_bh['assess_test_id']);



$position_exp=@explode(",",$emp_info['specific_experience']);
$age=date_diff(date_create($emp_info['date_of_birth']), date_create('today'))->y;

$years_len=strlen($years);
if($years_len==1){
	$year_code=$years ." year";
}
else{
	$year_code=$years ." years";
}

$pre_exp=strlen($emp_info['previous_exp']);
if($pre_exp==1){
	$preexp=$pre_exp ." yr";
}
else{
	$preexp=$pre_exp ." yrs";
}
$tenure = $year_code." ".$months." months";
$design_table='
<table cellspacing="5" cellpadding="5" bordercolor="#5b9bd5" style="width:100%;font-size:10pt;font-family:Helvetica; color:#fff;background-color: #04AA6D;">
	<tr>
		<th width="25%">Age:  '.$age.' yrs </th>
		<th width="20%">Total Exp: '.$emp_info['previous_exp'].' yrs</th>
		<th width="55%" align="center">Tenure in '.$emp_info['parent_organisation'].':  '.$tenure.'</th>
		
	</tr>
</table>
<table cellspacing="0" cellpadding="0"  border="0.5px" bordercolor="#435094" style="color:#646464;font-family:Helvetica;font-size:11pt;" >
    <tr>
		<td style="text-indent: 5mm; width: 20%;background-color:#f2f2f2">
			<br>
			<span style="color:#435094; font-size: 10pt;text-align:center">Performance on Assessment Methods</span>
			<br>
			<table cellspacing="3" cellpadding="3" bordercolor="#5b9bd5" style="width:100%;font-size:12pt;font-family:Helvetica; ">
				<tr>
					<th><img src="'.$image5.'"></th>
					<th style="vertical-align: middle;"><b style="font-size:14pt;">'.$ass_method_test.'%</b></th>
				</tr>
				
				<tr>
					<th><img src="'.$image1.'"></th>
					<th style="vertical-align: middle;"><b style="font-size:16pt;">'.$ass_method_interview.'</b></th>
				</tr>
				<tr>
					<th><img src="'.$image2.'" ></th>
					<th style="vertical-align: middle;"><b style="font-size:16pt;">'.$ass_method_inbasket.'</b></th>
				</tr>
				<tr>
					<th><img src="'.$image3.'"></th>
					<th style="vertical-align: middle;"><b style="font-size:16pt;">'.$ass_method_case.'</b></th>
				</tr>
				<tr>
					<th><img src="'.$image4.'"></th>
					<th style="vertical-align: middle;"><b style="font-size:16pt;">'.$ratval.'</b></th>
				</tr>
			</table>
			
			<span style="color:#646464;font-family:Helvetica;font-size: 6pt;">Ratings in MCQ, Assessment Centre, Inbasket, Case Study, 360° Feedback  on a Scale of 4.
			</span>
		</td>
		<td style="text-indent: 10mm; width: 35%;background-color:#fddfa7">
			<br>
			<span style="color:#435094; text-align:center;font-size: 10pt;">Overall Competency Rating </span>
			<br>
			<table cellspacing="5" cellpadding="5" bordercolor="#5b9bd5" style="width:100%;font-size:12pt;font-family:Helvetica; ">
				<tr>
					<td><img src="'.BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['ass_id'].'/'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'_radar.svg" /></td>
					
				</tr>
				<tr>
					<td width="100%" align="top" style="font-family:Helvetica;font-size: 6pt;">'.$para_radar.'</td>
				</tr>
				
			</table>
			<br>
			<span style="color:#000; text-align:center;font-size: 12pt;"><b>Total Competency Score</b></span>
			<br>
			<span style="color:#000; text-align:center;font-size: 12pt;"><b>'.$total_ass_score.'</b></span>
			<br>
			<span style="color:#000; text-align:right;font-size: 5pt;"><b>Score on a scale of '.$total_req_score.'</b></span>
			
			
		</td>
		<td style="text-indent: 5mm;width: 45%;">
			<br>
			<span style="color:#435094; font-size: 10pt;">Overall Feedback </span>
			<br>
			<table cellspacing="5" cellpadding="5" bordercolor="#5b9bd5" style="width:100%;font-size:8pt;font-family:Helvetica; ">
				<tr>
					<th width="100%">
					<span style="color:#435094; font-size: 12pt;">Strengths: </span><br>
					'.$ass_final_rating['strength'].'
					</th>
				</tr>
				
			</table>
			<br>
			<table cellspacing="5" cellpadding="5" bordercolor="#5b9bd5" style="width:100%;font-size:8pt;font-family:Helvetica; ">
				<tr>
					
					<th  width="100%">
					<span style="color:#435094; font-size: 12pt;">Development Needs: </span><br>
					'.$ass_final_rating['ofiss'].'
					</th>
				</tr>
				
			</table>
			<br>
			
			<span style="color:#435094; font-size: 14pt;">&nbsp;&nbsp;Overall Rating</span>
			<br>
			<table cellspacing="5" cellpadding="5" bordercolor="#5b9bd5" style="width:100%;font-size:10pt;font-family:Helvetica; ">
				<tr>
					<th width="33%"><img src="'.$pic3.'"><br><span style="text-align:center;">Take Off</span></th>
					<th width="33%"><img src="'.$pic4.'"><br><span style="text-align:center;">Taxiing</span></th>
					<th width="33%"><img src="'.$pic5.'"><br><span style="text-align:center;">In-Hanger</span></th>
				</tr>
				
			</table>
		</td>
	</tr>
</table>';	
$tbl = <<<EOD
<table cellspacing="0" cellpadding="0" border="0" >
    <tr>
        <td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">5. CONSOLIDATED SUMMARY OF RESULTS</span>		
	</td>
    </tr>
</table>
$results_rating
<br>
$design_table
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');



$pdf->AddPage();
$pdf->footershow=true;
$pdf->SetFooterMargin(5);
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();
$full_name=trim($emp_info['name']);
$inter_comments=$case_comments="";
/* if($ass_method_interview==1){
	$inter_comments="Your knowledge across the various competencies, application of knowledge, the degree of comprehension of issues and the quality & clarity of responses has been found to be <b style='font-size: 12px;'>1</b>. ";	
}
elseif($ass_method_interview==2){
	$inter_comments="Your knowledge across the various competencies, application of knowledge, the degree of comprehension of issues and the quality & clarity of responses has been found to be <b style='font-size: 12px;'>2</b>.";	
}
elseif($ass_method_interview==3){
	$inter_comments="Your knowledge across the various competencies, application of knowledge, the degree of comprehension of issues and the quality & clarity of responses has been found to be <b style='font-size: 12px;'>3 </b>. ";	
}
elseif($ass_method_interview==4){
	$inter_comments="Your knowledge across the various competencies, application of knowledge, the degree of comprehension of issues and the quality & clarity of responses has been found to be <b style='font-size: 12px;'>4</b>. ";	
} */

if(!empty($get_ass_rating_report_interview)>0){
	
	$inter_comments.=''.$get_ass_rating_report_interview['comments'].'<br>';
	$inter_comments.='<br>';
	/* $case_feed_comments=UlsAssessmentReportBytype::competency_details_methods($_REQUEST['ass_id'],'CASE_STUDY',$_REQUEST['pos_id'],$_REQUEST['emp_id'],$ass_rating_case_comments['assessor_id']);
	foreach($case_feed_comments as $case_feed_comment){
		$case_comments.='<b>'.$case_feed_comment['comp_def_name'].'</b>:'.$case_feed_comment['interview_comments'].'<br>';
	} */
	$inter_comments.='<b>The overall rating on Assessment Centre is <span style="font-size: 12px;">'.round($get_ass_rating_report_interview['ass_rat'],0).'</span> </b>';
}
$inbasket_comments="";
$inbasket_comments.="The feedback for you on the in-basket exercise is as follows:<br><br>
";

$result_ss=array();
foreach($ass_rating_comments as $ass_rating_comment){
	if(!empty($ass_rating_comment['comments'])){
		$result_ss[$ass_rating_comment['assessment_type']]['ass_type']=$ass_rating_comment['assessment_type'];
		$result_ss[$ass_rating_comment['assessment_type']]['assess_type']=$ass_rating_comment['assess_type'];
		$result_ss[$ass_rating_comment['assessment_type']]['comments'][$ass_rating_comment['assessor_id']]=ucfirst($ass_rating_comment['comments']);
	}
}
/* print_r($result_ss);
exit(); */
if(count($result_ss)>0){
	$i=1;
	$j=1;
	foreach($result_ss as $key_i=>$ass_ratingcomment){
		if($ass_ratingcomment['ass_type']=='INBASKET'){
			foreach($ass_ratingcomment['comments'] as $key2=>$ass_id){
				$inbasket_comments.=''.trim($ass_ratingcomment['assess_type']).' - '.$result_ss[$key_i]['comments'][$key2].'<br>';
			}
			$i++;
		}
	}
}
$inbasket_rating=UlsAssessmentAssessorRating::get_ass_rating_report($_REQUEST['ass_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id'],'INBASKET');
$inbasket_comments.='<br><b>The overall rating on In-Basket is <span style="font-size: 12px;">'.round($inbasket_rating['ass_rat'],0).'</span></b>';

if(!empty($ass_rating_case_comments)>0){
	$case_comments.=''.$ass_rating_case_comments['comments'].'<br>';
	$case_comments.='<br>';
	/* $case_feed_comments=UlsAssessmentReportBytype::competency_details_methods($_REQUEST['ass_id'],'CASE_STUDY',$_REQUEST['pos_id'],$_REQUEST['emp_id'],$ass_rating_case_comments['assessor_id']);
	foreach($case_feed_comments as $case_feed_comment){
		$case_comments.='<b>'.$case_feed_comment['comp_def_name'].'</b>:'.$case_feed_comment['interview_comments'].'<br>';
	} */
	$case_comments.='<b>The overall rating on Case Study is <span style="font-size: 12px;">'.round($ass_rating_case_comments['ass_rat'],0).'</span> </b>';
}

$para181='
<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">
	
	<span align="left" style="font-family: Helvetica;font-size: 16px;color:#36a2eb; line-height:1.5;">Overall Rating<br><br></span>
	Based on all the above qualitative and quantitative information, you have been classified
	<br><br>';
	if($ass_final_rating['rating_number']==1){
		$para181.='<b style="font-family: Helvetica;font-size: 16px;text-align:center">Takeoff</b>
		<br><br>';
		$para181.='<img src="'.BASE_URL.'/public/reports/takeoffc.png"  style="text-align:center"/>';
		$para181.='<br><br>
		<span style="font-family: Helvetica;font-size: 14px;"><b>Inference:</b> You can be groomed into a higher role with minimal developmental support. It is the informed opinion of the assessors, that you have the required potential to take on higher responsibilities.</span> ';
	}
	if($ass_final_rating['rating_number']==2){
		$para181.='<b style="font-family: Helvetica;font-size: 16px;text-align:center">Taxiing</b>  
		<br><br>';
		$para181.='<img src="'.BASE_URL.'/public/reports/taxiingc.png" style="text-align:center"/>';
		$para181.='<br><br>
		<span style="font-family: Helvetica;font-size: 14px;"><b>Inference:</b> You need more developmental inputs to move to a higher role. It is the informed opinion of the assessors that you have the potential and with some focused developmental inputs, will be able to take on higher responsibilities.</span>';
	}
	if($ass_final_rating['rating_number']==3){
		$para181.='<b style="font-family: Helvetica;font-size: 16px;text-align:center">In Hangar</b>
		<br><br>';
		$para181.='<img src="'.BASE_URL.'/public/reports/hangerc.png"  style="text-align:center"/>';
		$para181.='<br><br>
		<span style="font-family: Helvetica;font-size: 14px;"><b>Inference:</b> You may require significant /substantial inputs for development in the current role. It is the informed opinion of the assessors that you require significant development inputs to be able to perform more effectively in the current role and in future take on new roles and responsibilities. </span>';
	}
	
$para181.='</div>';

$para178='
<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">
	<span align="left" style="font-family: Helvetica;font-size: 14px;color:#36a2eb; line-height:1.5;"><u>UNDERSTANDING THE OVERALL  ASSESSMENT ANALYSIS</u><br><br></span>
	In each of the assessment methods, Assessment Centre, In-basket, and Case study, the rating is on a scale of 1-4 (1: Poor, 2: Average, 3: Good, 4: Excellent). All the ratings have been arrived after a detailed discussion and consensus among all the assessors involved in the assessment process. This is NOT an average value<br><br>
	<b style="font-size:12px;color:#36a2eb;">Assessment Method:  Assessment Centre</b><br>
	In the case of Assessment Centre, the assessors have based their ratings on multiple parameters, and rated on scale of 1-4. 
	<br><br>
	'.$inter_comments.'
	<br><br>
	<b style="font-size:12px;color:#36a2eb;">Assessment Method:  In-basket</b><br>
	In the case of in-basket, the rating is based on multiple dimensions of prioritization, quality of action and the time taken.
	'.$inbasket_comments.'
	<br><br>
	<b style="font-size:12px;color:#36a2eb;">Assessment Method:  Case Study</b><br>
	For the Case study, the rating is based on the understanding of the core issues, the approach to the solution and finally the quality of the solution provided.  The feedback on the case studies is as follows:
	<br><br>
	'.$case_comments.'
	<br><br>
	<b style="font-size:12px;color:#36a2eb;">Assessment Method:  360&deg; Feedback</b><br>
	Ratings on the 360&deg; feedback are on a scale of 1-4. Annexure 1 provides you with data on how you have rated yourself on each of the statements and the average of the feedback given by all other raters for you on those statements.  The Radar Graph corresponding to this and the interpretation is given therein.  
	The score given in the sheet in the Annexure, is the average of all others ratings, across all the competencies.  From your development perspective, please pay attention to the statements where the difference between yourself and others rating is high.  For your convenience we have identified them under the category of Blind Spots.  Blind spot is defined as those areas/competencies, where perception of self is higher than that of others.<br><br>  
	
</div>';
$tbl = <<<EOD
$para178
<br><br>
$para181
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

$ass_comp_info_details=UlsAssessmentReport::getassessment_admin_competency($_REQUEST['ass_id'],$_REQUEST['pos_id']);
$resultsinfo_detailss=array();
foreach($ass_comp_info_details as $ass_comp_info_detailss){
	$comp_id=$ass_comp_info_detailss['comp_def_id'];
	$req_scale_id=$ass_comp_info_detailss['req_scale_id'];
	$resultsinfo_detailss[$comp_id]['comp_name']=$ass_comp_info_detailss['comp_def_name'];
	$resultsinfo_detailss[$comp_id]['req_scale_id']=$ass_comp_info_detailss['req_scale_id'];
	$resultsinfo_detailss[$comp_id]['req_scale_name']=$ass_comp_info_detailss['req_scale_name'];
	$resultsinfo_detailss[$comp_id]['req_scale_count']=$ass_comp_info_detailss['req_scale'];
}
/* 
$pdf->AddPage();
$pdf->footershow=true;
$pdf->SetFooterMargin(5);
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();


$kk=0;

$para18='
<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">
	<span align="left" style="font-family: Helvetica;font-size: 14px;color:#36a2eb; line-height:1.5;">Overall Competency Rating<br><br></span>
	The overall competency rating is represented in the form of a Radar Graph (given in Page 8), showing the required levels of each of the competencies and the weighted average of the assessed scores.The weighted average for each of the competency is arrived at as follows:
	<br><br>
	For each of the assessment methods of interview, in-basket and case study the consensus score is multiplied by the weightage given to that particular method (refer to Page 7 where the information on weightages is given). As an example for the competency "Market Analysis & Forecasting", your assessed score is arrived at as follows, 
	<br><br>
	<span align="left" style="font-family: Helvetica;font-size: 12px;color:#36a2eb; line-height:1.5;">Competency:  Market Analysis & Forecasting <br><br></span>
	<table cellspacing="0" cellpadding="5" border="0.5px" align="left" style="width:100%;font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5; border:0.5px solid #9999;">
		<thead>
			<tr bgcolor="#59b0ea" align="center" style="color:#fff;" class="row header">
				<th style="width:40%">Assessment Method </th>
				<th style="width:30%">Consensus score </th>
				<th style="width:15%">Weightage </th>
				<th style="width:15%">Weighted Score</th>
			</tr>
			
		</thead>
		<tbody>';
		$i=1;$kk=0;
		$final_scr=0;
		$total=0;
		foreach($testtypes as $testtype){
			if($testtype['assessment_type']!='BEHAVORIAL_INSTRUMENT'){
			$bgcolor=($kk%2==0)?"#deeaf6":"#ffffff";
			$kk++;
			if($testtype['assessment_type']=='FEEDBACK'){
				//$weightage=$feed_weightage;
				$weightage=$testtype['weightage'];
			}
			else{
				$weightage=(!empty($testtype['weightage']) && $testtype['weightage']!=0)?$testtype['weightage']:"No weightage has been given –the reason for the same is explained in the ensuing sections.";
			}
			$time_details=!empty($testtype['time_details'])?$testtype['time_details']." mins" :"";
			
			//$assess_type=($testtype['assessment_type']=='BEHAVORIAL_INSTRUMENT')?$testtype['assess_type'].'(Personal Entrepreneurial Competencies)':$testtype['assess_type'];
			if($testtype['assessment_type']=='FEEDBACK'){
				$assert_name="360 Degree (Average of others) ";
			}
			elseif($testtype['assessment_type']=='TEST'){
				$assert_name="MCQ";
			}
			elseif($testtype['assessment_type']=='INTERVIEW'){
				$assert_name="Assessment Centre";
			}
			else{
				$assert_name=$testtype['assessment_type'];
			}
			//$total=round((($score*$weightage)/100),2);
			$final_value=number_format((float)$total, 2, '.', '');
			//$final_value=$total;
			$para18.='<tr bgcolor="'.$bgcolor.'">';
			$para18.='<td width="40%">'.$assert_name.'</td>';
			$para18.='<td width="30%">'.$score.'</td>';
			$para18.='<td width="15%">'.$weightage.'</td>';
			$para18.='<td width="15%">'.$kkass_sid[61].'</td>';
			$para18.='</tr>';
			$final_scr+=$kkass_sid[61];
			}
		}
		$para18.='<tr>
			<td colspan="3">Assessed Weighted Average score on Market Analysis & Forecasting</td>
			<td>'.$final_scr.'</td>
		</tr>';
		$para18.='</tbody>
	</table>
	<br>
	<br>';
	$words = $formatter->format(count($resultsinfo_detailss));
	$para18.='The same method of computation is used for all the '.$words.'('.count($resultsinfo_detailss).') Competencies to arrive at the Total Competency Score, which for you is <b>'.$total_ass_score.'</b><br><br>
	You may want to compare this with the Maximum Competency Score, just to give you some kind of a perspective. This (Maximum Competency Score) is  <br><br>
	
	<table cellspacing="0" cellpadding="5" border="0.5px" align="left" style="width:100%;font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5; border:0.5px solid #9999;">
		<thead>
			<tr bgcolor="#59b0ea" align="center" style="color:#fff;" class="row header">
				<th style="width:40%">Competency  </th>
				<th style="width:30%">Required Level </th>
				<th style="width:30%">Numeric Value of Required Level   </th>
			</tr>
			
		</thead>
		<tbody>';
		$total_req_count=0;
		foreach($resultsinfo_detailss as $comp_def_id=>$resultsinfo_details){
			$total_req_count+=$resultsinfo_details['req_scale_count'];
			$para18.='<tr>
			<td style="width:40%">'.$resultsinfo_details['comp_name'].'</td>
			<td style="width:30%">'.$resultsinfo_details['req_scale_name'].'</td>
			<td style="width:30%">'.$resultsinfo_details['req_scale_count'].'</td>		
			</tr>';
		}
		$para18.='
			<tr>
				<td colspan="2">Maximum Competency Score</td>
				<td><b>'.$total_req_count.'</b></td>
			</tr>
		</tbody>
	</table>
</div>';
$tbl = <<<EOD
$para18
EOD;
$pdf->writeHTML($tbl, true, false, false, false, ''); */



/* $pdf->AddPage();
$pdf->footershow=true;
$pdf->SetFooterMargin(5);
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();
$position_req=$emp_info['other_requirement'];

$tbl = <<<EOD
$para181
EOD;
$pdf->writeHTML($tbl, true, false, false, false, ''); */

$pdf->AddPage();
// -- set new background ---
$pdf->SetFooterMargin(5);
$pdf->Bookmark('6. COMPETENCY WISE FEEDBACK & DEVELOPMENT ROAD MAP', 0, 0, '', '', array(0,0,0));
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
		
		$method_check=UlsAssessmentReportBytype::summary_detail_info_report($_REQUEST['ass_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id'],$comp_id);
		
		
			if(!in_array($result['comp_id'],$compid)){
				$compid[]=$result['comp_id']."-".$require_scale_id;
			}
		
	}
	
}
$compid_low=array();

$para_data_comment="";
if(!empty($compid)){
	foreach($compid as $compids){
		$comp_d=explode("-",$compids);
		//if(!in_array($comp_d[0],$compid_low)){
		$development=UlsCompetencyDefLevelTraining::getcompdeftraining($comp_d[0],$comp_d[1]);
		
		$comp_name=UlsCompetencyDefinition::competency_detail_single($comp_d[0]);
		$para_data_comment.='<br><br><span align="left" style="font-family: Helvetica;font-size: 13px;float:right;font-weight: bold;">Competency:</span>&nbsp;<span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 13px;color:#36a2eb; float:right;font-weight: bold;font-style: italic;">'.$comp_name['comp_def_name'].'</span><br>';
		if(!empty(trim($dev[$comp_d[0]]))){
			$para_data_comment.='<b>Assessor Comments:</b><br><span style="font-style: italic;">'.$dev[$comp_d[0]].'</span>';
		}
		//}
	}
}
else{
	$para_data_comment.='';
}
//print_r($para_data);	
$para_data_comment=trim($para_data_comment);
$para_data_comment=empty($para_data_comment)?"<br><br><span align='center'>No Development Area</span>":$para_data_comment;
$tb2 = <<<EOD

<table cellspacing="0" cellpadding="0" border="0" >
    <tr>
        <td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">6. COMPETENCY WISE FEEDBACK & DEVELOPMENT ROAD MAP <br></span>
	</td>
    </tr>
</table>
<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">
$para_data_comment
<br><br><br>
Note: All statements have been recorded verbatim as provided by the assessor and have not been altered in any manner.
</div>
EOD;
$pdf->writeHTML($tb2, true, false, false, false, '');



$pdf->AddPage();
// -- set new background ---
$pdf->SetFooterMargin(5);
$pdf->Bookmark('7. CLOSING COMMENTS ', 0, 0, '', '', array(0,0,0));
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

$tb2 = <<<EOD

<table cellspacing="0" cellpadding="0" border="0" >
    <tr>
        <td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">7. CLOSING COMMENTS <br></span>
	</td>
    </tr>
</table>
<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">
We thank you for taking the time and the effort to go through this important initiative that your organization has undertaken for your development.  
<br><br>
We are sure that you have uncovered very important insights in your competency and personality profile and we hope that you will earnestly embark on a development journey in the months ahead.  
<br><br>

<br><br>
WISHING YOU ALL THE BEST IN YOUR DEVELOPMENT JOURNEY!
<br><br>

</div>
EOD;
$pdf->writeHTML($tb2, true, false, false, false, '');

$pdf->AddPage();
$pdf->footershow=true;
// -- set new background ---
$pdf->SetFooterMargin(5);
$pdf->Bookmark('ANNEXURES', 0, 0, '', '', array(0,0,0));
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
<div style="height: 750px;bottom:0px;">&nbsp;<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></div>
<div style="color:black;padding-left:500px;font-family: Helvetica;font-size:32px;line-height:1.5;text-align:center;"><b>ANNEXURES</b>
</div>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

// add a page
$pdf->AddPage();
// -- set new background ---
$pdf->SetFooterMargin(5);

$pdf->Bookmark('Annexure 1: 360&deg; Feedback', 0, 0, '', '', array(0,0,0));
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
$para41='<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">
360&deg; Feedback, also known as multi rater feedback is a process where in an individual receives feedback on a set of competencies, from multiple sources /groups of people with whom one interact in the course of discharging his/her job responsibilities. 
The 360° feedback report highlights differences between the individual’s self-perception and the feedback from others. Critical areas for self-development are highlighted. The report becomes a critical piece for professional development planning.
<br><br>
<b>How to use the report:</b> The report covers a detailed analysis of the feedback received on each of the competencies. This will help you to understand your own perceptions and that of the others perception vis-à-vis the competencies. It provides information on rating on each of the elements, of the '.count($resultsinfo_detailss).' competencies - your self-rating and the average of all others who have rated you, which includes Manager, Subordinates, Peers and Leadership Team (where applicable).


<br>';
$sqlself ="select AVG( a.rater_value) AS average,a.element_competency_id FROM uls_feedback_employee_rating a
left join(SELECT `feed_assess_test_id`,`assess_test_id`,`position_id`,`assessment_id`,`ques_id` FROM `uls_assessment_test_feedback`) b on a.ass_test_id=b.assess_test_id and a.ques_id=b.ques_id and a.assessment_id=b.assessment_id
where a.employee_id='".$_REQUEST['emp_id']."' and a.giver_id='".$_REQUEST['emp_id']."' and a.rater_value<>0 and a.assessment_id='".$_REQUEST['ass_id']."' GROUP BY a.element_competency_id";	
$q=UlsMenu::callpdo($sqlself);
$Series2=array();
$parameter=array();
foreach($q as $r){
	/* echo "<pre>";
	print_r($r); */
	$prs=$r['element_competency_id'];
	$Series2[$prs]= round($r['average'],2);
}
$para41.='<br><br><table cellspacing="0" cellpadding="0" border="0" >
    <tr>
        <td  width="54%" ></td>
        <td  width="3%"  bgcolor="#0098DB" ></td>
        <td  width="20%"  style="color:#646464;">&nbsp;Self Average</td>
        <td  width="3%" bgcolor="#FCB614"></td>
        <td  width="20%"  style="color:#646464;">&nbsp;Others Average</td>
    </tr>
</table>';
$catquery="SELECT * FROM `uls_category` WHERE `category_id` in (SELECT DISTINCT(`comp_def_category`) FROM `uls_competency_definition` WHERE 1 and `comp_def_id` in (SELECT DISTINCT(`element_competency_id`) FROM `uls_feedback_employee_rating` WHERE employee_id='".$_REQUEST['emp_id']."' and giver_id='".$_REQUEST['emp_id']."' and rater_value<>0 and assessment_id='".$_REQUEST['ass_id']."' ORDER BY `uls_feedback_employee_rating`.`element_competency_id` ASC ) ORDER BY `uls_competency_definition`.`comp_def_category` ASC )";
$catresults=UlsMenu::callpdo($catquery);
foreach($catresults as $cate){
$para41.="
<br><br><span align='left' style='font-family: Helvetica;font-size: 20px;color:#36a2eb; line-height:1.5;'><b>".$cate['name']."</b></span><br><br>";	
/* print_r($Series2); */
$para41.='<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#59b0ea" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5;">
	<thead><tr height="30" bgcolor="#59b0ea" align="center" class="row header" style="color:#fff;">
			<th width="76%">Competency</th>
			<th width="24%">Rating : Self Vs Others</th>
		</tr>
	</thead>
	<tbody>';
	$sql12 ="select AVG(a.rater_value) AS average,a.element_competency_id,d.comp_def_name FROM uls_feedback_employee_rating a
	left join(SELECT `feed_assess_test_id`,`assess_test_id`,`position_id`,`assessment_id`,`ques_id` FROM `uls_assessment_test_feedback`) b on a.ass_test_id=b.assess_test_id and a.ques_id=b.ques_id and a.assessment_id=b.assessment_id
	left join(SELECT `ques_comp_id`,`ques_id`,`ques_competency_id`,`ques_level_scale_id` FROM `uls_questionnaire_competency`) c on c.ques_competency_id=a.element_competency_id and a.ques_id=c.ques_id
	left join(SELECT `comp_def_id`,`comp_def_name`,comp_def_category FROM `uls_competency_definition`) d on d.comp_def_id=c.ques_competency_id
	where a.employee_id=".$_REQUEST['emp_id']." and a.giver_id!=".$_REQUEST['emp_id']." and a.rater_value<>0 and a.assessment_id=".$_REQUEST['ass_id']." and d.comp_def_category='".$cate['category_id']."' GROUP BY a.element_competency_id";
	$q=UlsMenu::callpdo($sql12);
	$Series1=array();
	$parameter=array();
	$kk=0;
	foreach($q as $ro){
		/* echo "<pre>";
		print_r($ro); */
		$bgcolor=($kk%2==0)?"#deeaf6":"#ffffff";
		$kk++;
		$pro=$ro['element_competency_id'];
		$Series1[$pro]= round($ro['average'],2);
		$parameter[]=$ro['comp_def_name'];
		$wid=$Series2[$pro];
		$wid1=$Series1[$pro];
		$heit=26;
		$withh=50;
		/* echo "<pre>";
		print_r($wid."-".$wid1."-".$ro['element_competency_id']); */
		$k_path=svgbarr($wid,$wid1,$ro['element_competency_id'],$_REQUEST['ass_id'],$_REQUEST['emp_id'],$_REQUEST['pos_id'],$heit);
		$bar2 = BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['ass_id'].'/bar_'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'_'.$ro['element_competency_id'].'.svg';
		$para41.='<tr bgcolor="'.$bgcolor.'">
			<td style="width:'.$withh.'%">'.ucwords(strtolower($ro['comp_def_name'])).'</td>
			<td style="width:'.$withh.'%"><img src="'.$bar2.'" width="350" ></td>
		</tr>';
	}
	
	$para41.='</tbody>
</table><br>';


$para41.='<br><table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#59b0ea" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5;">
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
	where a.employee_id=".$_REQUEST['emp_id']." and a.giver_id=".$_REQUEST['emp_id']." and a.rater_value<>0 and a.assessment_id=".$_REQUEST['ass_id']." GROUP BY a.ques_element_id";	
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
</table>';


}
$diffb=0.5;
$diffd=-0.5;

	
	
$sqlself_comp_spot ="select AVG(a.rater_value) AS average,a.element_competency_id,a.ques_element_id FROM uls_feedback_employee_rating a
left join(SELECT `feed_assess_test_id`,`assess_test_id`,`position_id`,`assessment_id`,`ques_id` FROM `uls_assessment_test_feedback`) b on a.ass_test_id=b.assess_test_id and a.ques_id=b.ques_id and a.assessment_id=b.assessment_id
where a.employee_id=".$_REQUEST['emp_id']." and a.giver_id=".$_REQUEST['emp_id']." and a.rater_value<>0 and a.assessment_id=".$_REQUEST['ass_id']." GROUP BY a.ques_element_id";	
$q_self_comp_spot=UlsMenu::callpdo($sqlself_comp_spot);
$Series_self_spot=array();
foreach($q_self_comp_spot as $r_self_spot){
	$pr=$r_self_spot['ques_element_id'];
	$Series_self_spot[$pr]= round($r_self_spot['average'],1);
}
$sql13_spot ="select AVG( a.rater_value) AS average,a.element_competency_id,d.comp_def_name,e.element_id_edit,a.ques_element_id FROM uls_feedback_employee_rating a
left join(SELECT `feed_assess_test_id`,`assess_test_id`,`position_id`,`assessment_id`,`ques_id` FROM `uls_assessment_test_feedback`) b on a.ass_test_id=b.assess_test_id and a.ques_id=b.ques_id and a.assessment_id=b.assessment_id
left join(SELECT `ques_comp_id`,`ques_id`,`ques_competency_id`,`ques_level_scale_id` FROM `uls_questionnaire_competency`) c on c.ques_competency_id=a.element_competency_id and a.ques_id=c.ques_id
left join(SELECT `ques_element_id`,`ques_id`,`element_id`,`element_competency_id`,`element_id_edit` FROM `uls_questionnaire_competency_element`) e on e.ques_id=a.ques_id and c.ques_competency_id=e.element_competency_id and e.ques_element_id=a.ques_element_id
left join(SELECT `comp_def_id`,`comp_def_name`,comp_def_category FROM `uls_competency_definition`) d on d.comp_def_id=c.ques_competency_id
where a.employee_id=".$_REQUEST['emp_id']." and a.giver_id!=".$_REQUEST['emp_id']." and a.rater_value<>0 and a.assessment_id=".$_REQUEST['ass_id']." GROUP BY a.ques_element_id order by c.ques_competency_id ASC";
$qq_spot=UlsMenu::callpdo($sql13_spot);
$kkk=0;
$Series_others_spot=array();
$temp=$bright_spot=$dark_spot="";
$b=$d=1;
foreach($qq_spot as $rn_spot){
	$pr=$rn_spot['ques_element_id'];
	$Series_others_spot[$pr]= round($rn_spot['average'],1);
	$diff_spot=$Series_self_spot[$pr]-$Series_others_spot[$pr];
	$self_r=$Series_self_spot[$pr];
	$oth_r=$Series_others_spot[$pr];
	
	if($diff_spot >= $diffb){
		$dark_spot.=$b.". ".$rn_spot['element_id_edit']."<br>";
		$b++;
	}
	if($diff_spot < $diffd){
		$bright_spot.=$d.". ".$rn_spot['element_id_edit']."<br>";
		$d++;
	}
}
/* <br>
$para41_spot */
$para41.='</div>';	
$tbl = <<<EOD
<table cellspacing="0" cellpadding="0" border="0" >
    <tr>
        <td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 20px;color:#36a2eb; float:right">Annexure 1: 360° FEEDBACK<br></span>
	</td>
    </tr>
</table>
$para41
<table style="width:100%" align="left" style="">
	<tr style="color:#646464;text-align:justify;font-family: Helvetica;font-size: 11px;">
		<td colspan="4">
			<br><br><span style="font-size: 12pt;color:#435094;font-family: Helvetica;">BRIGHT SPOTS</span><br>
			Our perception of self could be vastly different from what others see or think about us. Sometimes there could be a negative skew meaning that we may not see ourselves as having the required skills or capabilities in a given area. Whereas, others would think that we possess (either based on interaction with us or because of our demonstration) the required competency. Such areas are called <b>BRIGHT SPOTS</b> and for you the following are the Bright Spots.<br>
			$bright_spot
			<br><br><span style="font-size: 12pt;color:#435094;font-family: Helvetica;">BLIND SPOTS</span><br>
			Our perception of self could be many a time different from what others see or think about us. Sometimes there could be a positive skew meaning that we may see ourselves as having the required skills or capabilities in a given area. Whereas, others would think that we do not posses (either based on interaction with us or because of our demonstration) the required competency. Such areas are called <b>BLIND SPOTS</b> and for you the following are the Blind Spots.
			<br>
			$dark_spot
			<br><br><br>
		</td>
	</tr>
	
	
</table>

EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
$selfavg_rating=$parameter=$otheravg_rating=array();
$self_avg ="select AVG( a.rater_value) AS average,a.element_competency_id,d.comp_def_name FROM uls_feedback_employee_rating a
left join(SELECT `feed_assess_test_id`,`assess_test_id`,`position_id`,`assessment_id`,`ques_id` FROM `uls_assessment_test_feedback`) b on a.ass_test_id=b.assess_test_id and a.ques_id=b.ques_id and a.assessment_id=b.assessment_id
left join(SELECT `ques_comp_id`,`ques_id`,`ques_competency_id`,`ques_level_scale_id` FROM `uls_questionnaire_competency`) c on c.ques_competency_id=a.element_competency_id and a.ques_id=c.ques_id
left join(SELECT `comp_def_id`,`comp_def_name`,comp_def_category FROM `uls_competency_definition`) d on d.comp_def_id=c.ques_competency_id
where a.employee_id=".$_REQUEST['emp_id']." and a.giver_id=".$_REQUEST['emp_id']." and a.rater_value<>0 and a.assessment_id=".$_REQUEST['ass_id']." GROUP BY a.element_competency_id";
$selfavg=UlsMenu::callpdo($self_avg);
foreach($selfavg as $selfavgs){
	$key=$selfavgs['element_competency_id'];
	$selfavg_rating[$key]=$selfavgs['average'];
}

$other_avg ="select AVG( a.rater_value) AS average,a.element_competency_id,d.comp_def_name FROM uls_feedback_employee_rating a
left join(SELECT `feed_assess_test_id`,`assess_test_id`,`position_id`,`assessment_id`,`ques_id` FROM `uls_assessment_test_feedback`) b on a.ass_test_id=b.assess_test_id and a.ques_id=b.ques_id and a.assessment_id=b.assessment_id
left join(SELECT `ques_comp_id`,`ques_id`,`ques_competency_id`,`ques_level_scale_id` FROM `uls_questionnaire_competency`) c on c.ques_competency_id=a.element_competency_id and a.ques_id=c.ques_id
left join(SELECT `comp_def_id`,`comp_def_name`,comp_def_category FROM `uls_competency_definition`) d on d.comp_def_id=c.ques_competency_id
where a.employee_id=".$_REQUEST['emp_id']." and a.giver_id!=".$_REQUEST['emp_id']." and a.rater_value<>0 and a.assessment_id=".$_REQUEST['ass_id']." GROUP BY a.element_competency_id";
$otheravg=UlsMenu::callpdo($other_avg);


foreach($otheravg as $keyn=>$otheravgs){
	$key=$otheravgs['element_competency_id'];
	$otheravg_rating[$key]=$otheravgs['average'];
	$parameter[]="C".($keyn+1);
}

$settings1 = array(
  
	'back_colour'       	=> '#fff', 		'stroke_colour'      => '#666',
	'back_stroke_width' 	=> 0,			'back_stroke_colour' => '#fff',
	'axis_colour'       	=> '#666',		'axis_overlap'       => 2,
	'axis_font'         	=> 'Georgia',	'axis_font_size'     => 12,
	'grid_colour'       	=> '#c1c1c1',		'label_colour'       => '#666',
	'grid_back_stripe'		=> false,
	//'grid_dash_h'		 => "4,2",
	//'grid_dash_v' => "4,2",
	'axis_stroke_width'=>0,
	'grid_subdivision_dash' => "1", 'line_stroke_width'		=>2, 'guideline_opacity'=>0.5,
	//'pad_right'         	=> 10,			'pad_left'           => 10,
	'link_base'         	=> '/',			'link_target'        => '_top',
	'fill_under'        	=> false,		'reverse'			=> true, 'start_angle' => 90,
	'marker_size'       	=> 6,			'axis_max_v'  => 4 ,'minimum_subdivision' =>6,'grid_division_v' =>1,
	//'marker_type'       	=> array('*', 'star'),
	//'marker_colour'     	=> array('#008534', '#850000')
	'legend_stroke_width'	=> 1,			'legend_shadow_opacity' => 0,'legend_stroke_colour'	=> '#aaa',
	'legend_title' => "",					'legend_columns' => 4,'legend_colour' => "#aaa",
	'legend_text_side' => "right",			'legend_position'		=> "outer bottom left",'marker_opacity'=>0.5,
	'grid_straight' => true
);
$coloursscg = array( '#0098DB','#FCB614', '#191970','#800000');
$settings1['graph_title_position'] = "top";
$settings1['graph_title_font_weight'] = "bold";
$settings1['legend_entries'] = array('Self','Others');
$val=array(); 

$par=array("A","B","C","D","E","F","G","H","I","J","K","L","M");
$sd=array();
for($i=0;$i<count($parameter); $i++){
	$sd[]=$par[$i];			 
}
$val[]=array_combine($parameter,$selfavg_rating);
$val[]=array_combine($parameter,$otheravg_rating);

$radar_add=Array();		
$radar_add[]=1;

$values1 = $val; 
$radar_name = 'radar_'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'.svg';
$settings1['graph_title'] = 'SELF VS OTHERS';

$graph1 = new SVGGraph(700, 500, $settings1);

$graph1->Values($values1);
$value11=$graph1->Fetch('MultiRadarGraph', false);//$graph->Fetch('MultiRadarGraph', false);

$target_path=__SITE_PATH.DS.'public'.DS.'reports'.DS.'graphs'.DS.'full'.DS.$_REQUEST['ass_id'];
if(is_dir($target_path)){
	//echo "Exists!";
} 
else{ 
	//echo "Doesn't exist" ;
	mkdir($target_path,0777);
	// Read and write for owner, nothing for everybody else
	chmod($target_path, 0777);
	//print "created";
}
$myfile = fopen($target_path.DS.$radar_name, "w") or die("Unable to open file!");
//$target_path='public'.DS.'feedback'.DS.$feedid.DS.$name.'.svg';
//$myfile = fopen($target_path, "w") or die("Unable to open file!");
fwrite($myfile, $value11);
fclose($myfile);

$svg_radar= BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['ass_id'].'/radar_'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'.svg';
$para16h='
<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">
	<span align="left" style="font-family: Helvetica;font-size: 14px;color:#36a2eb; line-height:1.5;">360&deg; Feedback Radar Graph of Self vs Others  <br><br></span>
	<table cellspacing="0" cellpadding="10" border="0" >
		<tr>
			<td style="width:100%" align="center"><img src="'.$svg_radar.'" width="600px"/></td>
		</tr>
	</table>
	<br>
	<span style="font-family: Helvetica;font-size: 8px;">Others= Average Score Given by Others</span>
	<br>
	<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#59b0ea" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5;">
	<thead><tr height="30" bgcolor="#59b0ea" align="center" class="row header" style="color:#fff;">
			<th>Competency</th>
		</tr>
	</thead>
	<tbody>';
	$kkk=0;
	foreach($otheravg as $keyn=>$otheravgs){
		$key=$otheravgs['element_competency_id'];
		$otheravg_rating[$key]=$otheravgs['average'];
		$bgcolor=($kkk%2==0)?"#deeaf6":"#ffffff";
		$kkk++;
		$para16h.='<tr bgcolor="'.$bgcolor.'">
			<td style="">'."C".($keyn+1)."-".$otheravgs['comp_def_name'].'</td>
		</tr>';
	}
	$para16h.='</tbody>
</table>

</div>
';
$pdf->AddPage();
$pdf->footershow=true;
$pdf->SetFooterMargin(5);
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();

$para16h.='';
$tbl = <<<EOD
$para16h
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
$para166="";
$jung="";		
$instrument=UlsAssessmentTestBehavorialInst::get_behavorial_assessment_report($testtypes_bh['assess_test_id']);
foreach($instrument as $instruments){
	$inst=UlsBeiAttemptsAssessment::get_attempt_valus_beh($_REQUEST['ass_id'],$_REQUEST['emp_id'],$instruments['assess_test_id']);
	
	if($instruments['instrument_type']=='BEI_RATING_TWO'){
		$pdf->AddPage();
		$pdf->footershow=true;
		$pdf->SetFooterMargin(5);
		$pdf->Bookmark('Annexure 2: Jungian Personality Test', 0, 0, '', '', array(0,0,0));
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
		//$jung.=($inst_array['F']>=4)?"F":"T";
		$jung.=isset($inst_array['F'])?($inst_array['F']>=4)?"F":"T":"T";
		$jung.=($inst_array['J']>=4)?"J":"P"; 
		/* echo "<pre>";
		print_r($jung); */
$sqls_j="SELECT * FROM `feed_jungian_description` WHERE 1";
$s1_sql_j=UlsMenu::callpdo($sqls_j);
$jungian_code=$jungian_name=$jungian_description='';
$jungian_data=array();
foreach($s1_sql_j as $s1_sql_js){
	if(trim($s1_sql_js['jungian_code'])==$jung){
		$jungian_code=$s1_sql_js['jungian_code'];
		$jungian_name=$s1_sql_js['jungian_name'];
		$jungian_description=$s1_sql_js['jungian_description'];
		$jungian_strength=$s1_sql_js['jungian_strength'];
		$jungian_weakness=$s1_sql_js['jungian_weakness'];
	}
}
/* $jungianstrength=explode(",",$jungian_strength);
$jungianweakness=explode(",",$jungian_weakness);	
$jungianstrengthn=array(explode(",",$jungian_strength));
$jungianweaknessn=array(explode(",",$jungian_weakness)); */
$jungianstrengthn['Strengths']=(explode(",",$jungian_strength));
$jungianweaknessn['Weakness']=(explode(",",$jungian_weakness)); 
$res=array_merge($jungianstrengthn,$jungianweaknessn);


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
		
$para166.='<div style="font-family: Helvetica;font-size:12px;line-height: 1.5;color:#646464;">
Your responses on the Jungian Personality instrument indicate that your reported type is:&nbsp;<span style="font-size: 14pt;color: #0A0A0A;font-family: helvetica;"><b>'.$jung.'</b></span>
<br>
Please read the highlighted portions to understand the type
<p bgcolor="#5b9bd5" align="right" style="font-size: 20pt;"><b>Personality Type: <span style="font-size: 22pt; background-color:#5b9bd5;" ><i>'.$jung.'</i></span></b></p>

</br>
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
<br>
<span style="font-family: Helvetica;font-size:12px;line-height: 1.1;color:#646464;">As an <b>'.$jung.',</b> the following are Strengths and Weakness</span>
<br>
<table cellspacing="0" cellpadding="5" border="0.5px" align="left" style="width:100%;font-family: Helvetica; color:#646464;font-size:12px;line-height: 1.3; border:0.5px solid #9999;">
	<thead>
		<tr bgcolor="#59b0ea" align="center" style="color:#fff;" class="row header">';
			$cols = array_keys($res);
			foreach($cols as $col){
				$para166.='<th style="width:50%">'.$col.'</th>';
			}
		$para166.='</tr>
	</thead>
	<tbody>';
	
	foreach ($res[$cols[0]] as $i => $null) {
		$para166.='<tr>';
			foreach ($cols as $col){
				$para166.='<td>'.$res[$col][$i].'</td>';
			}
			
		$para166.='</tr>';
	}	
	
	$para166.='</tbody>
	</table>
	<br>
	<span style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">It is suggested that you may take note of strengths and weakness associated with this Personality type and introspect and reflect on them. The impact of these may be evident in your workplace behavior and as such it may be good to develop self-awareness and put an effort to minimize some of the weaknesses and leverage on the strengths you possess.</span>

</div>
';
$para16h='<table cellspacing="0" cellpadding="0" border="0" >
<tr>
	<td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 18px;color:#36a2eb; float:right">Annexure 2: Jungian Personality Test</span>		
</td>
</tr>
</table>';

$tbl = <<<EOD
$para16h
$para166

EOD;
	$pdf->writeHTML($tbl, true, false, false, false, '');

	}
	
}
	
$pdf->AddPage();
$pdf->footershow=true;
$pdf->SetFooterMargin(5);
$pdf->Bookmark('Annexure 3:  Overall Competency Rating Graph', 0, 0, '', '', array(0,0,0));
$index_link = $pdf->AddLink();
$pdf->SetLink($index_link, 0, '*1');
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();
$para20h=$paracomp='';
foreach($kkcomp_name as $key=>$val_selfs){	
	$paracomp.=$kkcomp_id[$key].' - '.$val_selfs.'<br>';
}
$para20h.='

<table cellspacing="0" cellpadding="0" border="0" >
<tr>
	<td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 18px;color:#36a2eb; float:right">Annexure 3:  Overall Competency Rating Graph</span>		
</td>
</tr>
</table>
<div style="font-family: Helvetica;font-size:11px;line-height: 1.5;color:#646464;">
	<table cellspacing="5" cellpadding="5" bordercolor="#5b9bd5" style="width:100%;font-size:12px;font-family:Helvetica; ">
		<tr>
			<td><img src="'.BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['ass_id'].'/'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'_radar.svg" /></td>
			
		</tr>
		<tr>
			<td width="100%" align="top" style="font-family:Helvetica;font-size: 12px;">'.$paracomp.'</td>
		</tr>
		
	</table>		


</div>';
$tbl = <<<EOD
$para20h
EOD;
	$pdf->writeHTML($tbl, true, false, false, false, '');


$pdf->AddPage();
$pdf->footershow=true;
// -- set new background ---
$pdf->SetFooterMargin(5);
$pdf->Bookmark('NOTES', 0, 0, '', '', array(0,0,0));
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
		<td colspan="2" width="100%" ><span align="left" style="text-transform: uppercase;font-family: Helvetica;font-size: 18px;color:#36a2eb; float:right">NOTES</span>		
	</td>
	</tr>
</table>
<div style="font-family: Helvetica;font-size:12px;line-height: 1.5;color:#646464;">
	<b>Based on the report findings, list down three  (3) or four (4) areas in which you want to improve </b>
	<br><br><br><br>
	<b>1.____________________________________________________________________________________________________</b>
	<br><br>
	<br><br>
	<br><br>
	<b>2.________________________________________________________________________________________________</b>
	<br><br>
	<br><br>
	<br><br>
	<b>3.________________________________________________________________________________________________</b>
	<br><br>
	<br><br>
	<br><br>
	<b>4.________________________________________________________________________________________________</b>
	<br><br>
	<br><br>
	<b>Action Plan: What are the key development action plans you have for the above</b>
	<br><br><br><br>
	<b>__________________________________________________________________________________________________</b>
	<br><br>
	<br><br>
	<br><br>
	<b>__________________________________________________________________________________________________</b>
	<br><br>
	<br><br>
	<br><br>
	<b>__________________________________________________________________________________________________</b>
	<br><br>
	<br><br>
	<br><br>
	<br><br>
	<b>Support Required: What support do you require for your   development plan</b>
	<br><br><br><br>
	<b>_________________________________________________________________________________________________</b>
	<br><br>
	<br><br>
	<br><br>
	<b>_________________________________________________________________________________________________</b>
	<br><br>
	<br><br>
	<br><br>
	<b>_________________________________________________________________________________________________</b>
	<br><br>
</div>
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
$img_file = K_PATH_IMAGES.'adanipower/Headnorth-backcover.jpg';
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