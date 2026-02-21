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
	$value='<svg class="britechart bar-chart" width="500" height="80"><g class="container-group" transform="translate(10, 20)"><g class="chart-group"><rect class="bar" y="30" x="0" height="'.$height.'" width="'.$b.'" fill="#FCB614"></rect><rect class="bar" y="0" x="0" height="'.$height.'" width="'.$a.'" fill="#0098DB"></rect><text x="'.($a+3).'" y="20" fill="#666666">'.$wid.'</text>
	<text x="'.($b+3).'" y="50" fill="#666666">'.$wid1.'</text></g></g></svg>';
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
		global $pdfname;
		// get the current page break margin
		$bMargin = $this->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $this->AutoPageBreak;
		// disable auto-page-break
		
		if($key2==0){
			$this->SetAutoPageBreak(false, 0);
			// set bacground image
			$img_file = K_PATH_IMAGES.'coromandel/CoverPage.png';
			$this->Image($img_file, 0, 0, 297, 210, '', '', '', false, 300, '', false, false, 0);
		}
		//$this->ImageSVG($file='images/360degree/c-complete-front.svg', $x=0, $y=0, $w=210, $h=297, $link='', $align='', $palign='', $border=0, $fitonpage=false);
		// restore auto-page-break status
		$this->SetAutoPageBreak($auto_page_break, $bMargin);
		// set the starting point for the page content
		$this->setPageMark();
		$this->SetMargins(0,25,1);
		if($key2>0){
			$this->SetAutoPageBreak(True, 10);
			//$img_file = 'adani-power-backcover.jpg';
			//$this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
			$text='<br>
				<table height="40px;" width="100%" style="text-align:center;font-family:Helvetica;font-weight:bold;font-size:10pt;">
				<tr>
				<td width="60%" style="text-align:left; background-color: #8064A2; margin: 4px 2px;"><span style="font-family: Helvetica, sans-serif;font-size: 18pt;color:#fff;padding: 15px 32px;">&nbsp;&nbsp;Assessment Report – '.$pdfname.'</span></td>
				<td width="10%" style="text-align:left;"></td>
				<td width="30%" style="text-align:right;"><img src="'.LOGO_IMG_PDF.'" style="margin:0.15cm 0.2cm" height="40"> </td>
				
				
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
		$this->SetY(-10);
		
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
				$text='<table width="100%" style="text-align:center;font-family:Helvetica;font-weight:bold;font-size:10pt;background-color: #9E768F;color:#fff">
				<tr>
				<td text-align="center" rowspan="2" height="80" width="45%" style="text-align:left;background-color: #9E768F;"><span style="font-family: Helvetica, sans-serif;font-size: 15pt;color:#fff;text-align="center"">'.PDF_NAME.'</span></td>
				<td text-align="center" rowspan="2" width="10%" height="80" style="text-align:left;background-color: #9E768F;"><span style="font-family: Helvetica, sans-serif;font-size: 15pt;color:#fff;text-align="center"">'.$this->getAliasNumPage().'</span></td>
				<td width="45%" text-align="center" style="text-align:right;background-color: #9E768F;">&nbsp;</td>
				</tr>
				</table>
				';
				
				$this->Rect(0, 197, $this->getPageWidth(), $this->getPageHeight(),'DF','',array(158,118,143));
				$this->writeHTML($text, true, false, true, false, '');
				$this->Image(LOGO_IMG_PDF_FOOTER, $this->getPageWidth()-26, $this->getPageHeight()-11, 25, 10, '', '', '', false, 150, '', false, false, 0, false, false, false);
				$this->writeHTMLCell($w='', $h='', $x='', $y='', $this->header, $border=0, $ln=0, $fill=0, $reseth=true, $align='L', $autopadding=true);
				//$this->SetLineStyle( array('width'=>0.40,'color'=> array(54,162,235)));
				$this->SetLineStyle( array('width'=>0.40,'color'=> array(128,100,162)));
				$this->RoundedRect(7, 20, $this->getPageWidth()-14, $this->getPageHeight()-40, 2.0, '1111');
				
				
				}
			//}
		//} 
		$key1++;
		
	}
}
global $key;
global $key1;
global $key2;
global $pdfname;
$pdfname=trim($emp_info['name']);
$pdfname=ucwords(strtolower($pdfname));
$key=$key1=$key2=0;
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


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
$pdf->setPageOrientation('L');

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(10,25,10,true);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0,0,0,false);


// set auto page breaks
//$pdf->SetAutoPageBreak(TRUE, 30);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

$pdf->SetFont('Helvetica', '', 12);

// add a page
$pdf->AddPage();
$pdf->footershow=false;
$pdf->SetFooterMargin(0);
// Print a text

$txt='<label class="fish5" text-align="right;" width="100%"></label><br><br><br>
<label class="fish6"><b style="font-size:26pt;color:#fff;"><br></b></label><br><br><br>
<br>
<label class="fish1"><b style="font-size:22pt;color:#000;">'.trim($emp_info['name']).'</b><br><b style="font-size:14pt;color:#000;">'.@$posdetails['position_name'].'</b></label>';
	
$html = <<<EOD
<table cellspacing="0" width="100%" cellpadding="5" border="0" >
	<tr>
		<td width="100%" height="220pt" colspan="3" align="right">$txt</td>
	</tr>	
</table>
EOD;
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->setPrintHeader(true);

// add a page
$pdf->AddPage();
$pdf->footershow=true;
// -- set new background ---
$pdf->SetFooterMargin(0);
//$pdf->Bookmark('1. Training Program Feedback', 0, 0, '', '', array(0,0,0));
// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(true, 25);
// set bacground image
//$img_file = K_PATH_IMAGES.'cms/bar.jpg';
//$pdf->Image($img_file, 0, 0, 8.8, 297, '', '', '', false, 300, '', false, false, 0);
// restore auto-page-break status
//$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();
$para1="NOTE:&nbsp;This report and its contents are the property of ".$emp_info['parent_organisation']." and no portion of the same should be copied or reproduced without the prior permission of ".$emp_info['parent_organisation'];
$para2="The report is contains the assessment of Technical/ Functional and Managerial/ Behavioral Competencies of ".trim($emp_info['name']).", ".trim($posdetails['position_name']);
$tbl = <<<EOD
<div style="bottom:0px;">&nbsp;<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></div>
<div style="color:red;padding-left:5px;font-family: Helvetica;font-size:10px;line-height:1.5;">$para1.<br>$para2<br>
<span style="padding-left:5px;font-family: Helvetica;font-size:10px;color:#646464;">For further information on Competencies, Competency modelling and assessment, please refer to the FAQ section in <a href="http://n-compas.com/" target="_blank">www.N-Compas.com </a><span></div>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');



// add a page
$pdf->AddPage();
// -- set new background ---
$pdf->SetFooterMargin(0);
$pdf->Bookmark('1. Introduction', 0, 0, '', '', array(0,0,0));
$pdf->Bookmark('*&nbsp;&nbsp;What is this all about', 1, 0, '', '', array(0,0,0));
$pdf->Bookmark('*&nbsp;&nbsp;What is the basic framework of this process?', 1, 0, '', '', array(0,0,0));
$pdf->Bookmark('*&nbsp;&nbsp;What are the Assessment Methods Used?', 1, 0, '', '', array(0,0,0));
$pdf->Bookmark('*&nbsp;&nbsp;What is the scope of this assessment?', 1, 0, '', '', array(0,0,0));
$index_link = $pdf->AddLink();
$pdf->SetLink($index_link, 0, '*1');
// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(true, 25);
// set bacground image
//$img_file = K_PATH_IMAGES.'cms/bar.jpg';
//$pdf->Image($img_file, 0, 0, 8.8, 297, '', '', '', false, 300, '', false, false, 0);
// restore auto-page-break status
//$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();
$tbl = <<<EOD

<table cellspacing="0" cellpadding="4" border="0" style="font-family: Helvetica;font-size:20px;background-color:#9E768F;" >
	<tr>
		<td width="100%">
			<b style="font-size: 5pt;color:#ffffff;"></b>
			<b style="font-family: Helvetica;font-size:20px;color:#ffffff;">&nbsp;Introduction</b>
		</td>
	</tr>
</table>
<div style="font-family: Helvetica;font-size:12px;line-height: 1.5;color:#000;">
	<br>
	<table cellspacing="0" cellpadding="4" border="0"  >
		<tr>
			<td width="18%" style="font-family: Helvetica;font-size:14px;background-color:#8064A2;">
				<b style="font-size: 5pt;color:#ffffff;">&nbsp;</b>
				<b style="font-family: Helvetica;font-size:14px;color:#ffffff;">What is this all about?</b>
			</td>
		</tr>
	</table>
	<br><br>
	As you are aware every organization is constantly in the process of improving the capabilities of its employees through various developmental efforts to enable them reach their true potential. CIL as a forward looking and progressive organization has drawn-up an ambitious process of competency building of its critical /key personnel. As a part of this, the organization has drawn-up an ambitious process of Technical & Managerial Competency assessment and development process, with an end objective of FOCUSED LEARNING AND DEVELOPMENT FOR EACH INDIVIDUAL.
	<br><br>
	<table cellspacing="0" cellpadding="4" border="0"  >
		<tr>
			<td width="35%" style="font-family: Helvetica;font-size:14px;background-color:#8064A2;">
				<b style="font-size: 5pt;color:#ffffff;">&nbsp;</b>
				<b style="font-family: Helvetica;font-size:14px;color:#ffffff;">What is the basic framework of this process?</b>
			</td>
		</tr>
	</table>
	<br><br>
	This process has been developed based on the following<br><br>
	1. Every job in the organization has a set of accountabilities, which are measured in terms of the outcomes, referred to as KRAs. These (KRAs), in order to be achieved, would require a certain set of Competencies. These competencies in turn are classified along the technical and managerial dimensions.<br>
	2. Based on the various positions in the organization, a complete set of Technical & managerial Competencies have been identified for the Agro Chemical Business.<br>
	3. Each position has been defined in terms of the competency requirement, referred to as Competency Profile.
	
	<br><br>
	<table cellspacing="0" cellpadding="4" border="0"  >
		<tr>
			<td width="30%" style="font-family: Helvetica;font-size:14px;background-color:#8064A2;">
				<b style="font-size: 5pt;color:#ffffff;">&nbsp;</b>
				<b style="font-family: Helvetica;font-size:14px;color:#ffffff;">What are the assessment methods used?</b>
			</td>
		</tr>
	</table>
	<br><br>
	In order to assess each of the employees systematically and comprehensively with respect to the above competencies, the following assessment methods were designed and rolled out.<br>
	<b style="color:#8064A2;">MCQ or Multiple Choice Questions:</b>&nbsp;These are questions which are based on your product, process/SOP and related aspects<br>
	<b style="color:#8064A2;">In-basket Exercises:</b>&nbsp;In order to understand how the person approaches various tasks at hand, in a limited time span, an in-tray exercise with given tasks was administered covering all the competencies.<br>
	<b style="color:#8064A2;">Casestudy:</b>&nbsp;To help gauge the employee’s approach to situations that they typically encounter in their workplace, two case-lets (covering two competencies) were given for analysis.<br>
	<b style="color:#8064A2;">360-degree Feedback: </b>&nbsp;A multi rater feedback was taken for each employee from the Managers, Peers, Subordinates as applicable for a given role.<br>
	<b style="color:#8064A2;">Personal Entrepreneurial Competencies Test (PEC): </b>&nbsp;In addition to the above, a personality test was also administered to each of the role holders.
	<br>
</div>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

// add a page
$pdf->AddPage();
// -- set new background ---
$pdf->SetFooterMargin(5);
$pdf->Bookmark('2. How to read this report', 0, 0, '', '', array(0,0,0));
$index_link = $pdf->AddLink();
$pdf->SetLink($index_link, 0, '*2');
// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(true, 25);
// set bacground image
//$img_file = K_PATH_IMAGES.'cms/bar.jpg';
//$pdf->Image($img_file, 0, 0, 8.8, 297, '', '', '', false, 300, '', false, false, 0);
// restore auto-page-break status
//$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();
$ass_methods='';
$ass_methods.='<table cellspacing="0" cellpadding="4" border="0"  >
		<tr>
			<td width="30%" style="font-family: Helvetica;font-size:14px;background-color:#8064A2;">
				<b style="font-size: 5pt;color:#ffffff;">&nbsp;</b>
				<b style="font-family: Helvetica;font-size:14px;color:#ffffff;">Assessment Methods</b>
			</td>
		</tr>
	</table>
	<br><br>';
$ass_methods='<div style="font-family: Helvetica;font-size:12px;line-height: 1.5;color:#000;">The following Assessment methods were being used for this position. Also indicated in the table are the corresponding weightages for each of the assessment methods.<br><br>
<table style="width:100%" align="left" cellspacing="0" border="1px" bordercolor="#8064A2" cellpadding="5" style="font-family: Helvetica; color:#000;font-size:12px;line-height: 1.5;">
	<thead><tr height="30" bgcolor="#8064A2" class="row header" style="font-size:14px;color:#fff;font-weight:bold">
			<th width="5%" align="center">S.No</th>
			<th width="40%">Assessment Type</th>
			<th width="40%">Assessment Weightages</th>
			<th width="15%">Duration</th>
		</tr>
	</thead>
	<tbody>';
	$i=1;$kk=0;
	foreach($testtypes as $testtype){
		$bgcolor=($kk%2==0)?"#E6E0EC":"#ffffff";
		$kk++;
		$weightage=(!empty($testtype['weightage']) && $testtype['weightage']!=0)?$testtype['weightage']."%":"No weightage has been given as this is a behavioural instrument.";
		$assess_type=($testtype['assessment_type']=='BEHAVORIAL_INSTRUMENT')?$testtype['assess_type'].'(Personal Entrepreneurial Competencies)':$testtype['assess_type'];
		$time=($testtype['assessment_type']=='BEHAVORIAL_INSTRUMENT' || $testtype['assessment_type']=='FEEDBACK')?"":$testtype['time_details'].' mins';
		$ass_methods.='<tr bgcolor="'.$bgcolor.'">';
		$ass_methods.='<td align="center" width="5%">'.$i.'</td>';
		$ass_methods.='<td width="40%">'.$assess_type.'</td>';
		$ass_methods.='<td width="40%">'.$weightage.'</td>';
		$ass_methods.='<td width="15%">'.$time.'</td></tr>';
		$i++;
	}
	$ass_methods.='</tbody>
	</table>
</div>
<table cellspacing="0" cellpadding="4" border="0"  >
	<tr>
		<td width="30%" style="font-family: Helvetica;font-size:14px;background-color:#8064A2;">
			<b style="font-size: 5pt;color:#ffffff;">&nbsp;</b>
			<b style="font-family: Helvetica;font-size:14px;color:#ffffff;">What is the scope of this assessment?</b>
		</td>
	</tr>
</table>

<div style="font-family: Helvetica;font-size:12px;line-height: 1.5;color:#000;"><br>In this cycle we will be assessing Functional & Technical and Managerial & Behavioural competencies and drawing of the Development Road Map for them.</div><br>
<table cellspacing="0" cellpadding="4" border="0" style="font-family: Helvetica;font-size:20px;background-color:#9E768F;" >
	<tr>
		<td width="100%">
			<b style="font-size: 5pt;color:#ffffff;"></b>
			<b style="font-family: Helvetica;font-size:20px;color:#ffffff;">&nbsp;2. How to read this report?</b>
		</td>
	</tr>
</table>
<div style="font-family: Helvetica;font-size:12px;line-height: 1.5;color:#000;"><br>This booklet is designed to help you gain insight into your strengths and areas for improvement when it comes to Managerial & behavioural and Functional & Technical competencies. Purpose of this Assessment is to bring an awareness and motivate for development. While reading your report,please bear in mind that there is no such thing as winning or getting single best profile. Thus, you should interpret your scores in terms of your own career aspirations and goals rather than in absolute terms.</div><br>
<table cellspacing="0" cellpadding="4" border="0" style="font-family: Helvetica;font-size:20px;background-color:#9E768F;" >
	<tr>
		<td width="100%">
			<b style="font-size: 5pt;color:#ffffff;"></b>
			<b style="font-family: Helvetica;font-size:20px;color:#ffffff;">&nbsp;3. Competency Profiling</b>
		</td>
	</tr>
</table>
<div style="font-family: Helvetica;font-size:12px;line-height: 1.5;color:#000;"><br>Each position has been defined in terms of the competency requirement, referred to as a Competency Profile.<br>
In order to do the Competency Profiling, a Competency Dictionary was used. The competencies were defined across 4 levels, Level 1 - Novice, Level 2 - Practitioner, Level 3 - Developed, Level 4 – Advanced.
</div>';
$tbl = <<<EOD
$ass_methods
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

// add a page
$pdf->AddPage();
// -- set new background ---
$pdf->SetFooterMargin(5);
$pdf->Bookmark('3. Competency Profiling', 0, 0, '', '', array(0,0,0));
$pdf->Bookmark('*&nbsp;&nbsp;3.1 Competency profile used for assessment', 1, 0, '', '', array(0,0,0));
$index_link = $pdf->AddLink();
$pdf->SetLink($index_link, 0, '*2');
// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(true, 25);
// set bacground image
//$img_file = K_PATH_IMAGES.'cms/bar.jpg';
//$pdf->Image($img_file, 0, 0, 8.8, 297, '', '', '', false, 300, '', false, false, 0);
// restore auto-page-break status
//$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();
$assmethods='';
$assmethods.='<div style="font-family: Helvetica;font-size:12px;line-height: 1.5;color:#000;"><br><br><br>';
$para_new='';
foreach($scale_info_four as $key=>$scale_infos){
	$para_new.='<b style="font-size:14px;">'.$scale_infos['scale_name'].':&nbsp;</b><span style="font-size:12px;">'.$scale_infos['description'].'</span>';
	if((count($scale_info_four)-1)!=$key){
		$para_new.='<hr style="line-height:50px">';
	}
}
$left_image='<img src="'.BASE_URL.'/public/Picture122.png" height="300">';
$right_image='<img src="'.BASE_URL.'/public/Picture34.png" height="300">';
$assmethods.='<table width="100%" style="font-family: Helvetica;font-size:14px;color:#000;">
	<tr>
		<td  width="10%">'.$left_image.'</td>
		<td  width="50%">'.$para_new.'</td>
		<td  width="40%">'.$right_image.'</td>
	</tr>
</table>
</div>
<div style="font-family: Helvetica;font-size:12px;line-height: 1.5;color:#000;">';
$assmethods.='<br>The second dimension, in Competency Profiling is called the Level of Criticality, which in turn is split into '.count($cri_info).' categories<br><br>';
foreach($cri_info as $k=>$cri_infos){
	$assmethods.=$k!=0?'<br><br>':'';
	$assmethods.='<b style="font-size:11px;color:#9E768F">'.$cri_infos['name'].':</b> '.$cri_infos['description'];
}
$assmethods.='</div>
';
$tbl = <<<EOD
$assmethods
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
$pdf->SetAutoPageBreak(true, 25);
// set bacground image
//$img_file = K_PATH_IMAGES.'cms/bar.jpg';
//$pdf->Image($img_file, 0, 0, 8.8, 297, '', '', '', false, 300, '', false, false, 0);
// restore auto-page-break status
//$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();
$para_cat='';
$para_cat.='
<table cellspacing="0" cellpadding="4" border="0"  >
	<tr>
		<td width="35%" style="font-family: Helvetica;font-size:14px;background-color:#8064A2;">
			<b style="font-size: 5pt;color:#ffffff;">&nbsp;</b>
			<b style="font-family: Helvetica;font-size:14px;color:#ffffff;">3.1 Competency profile used for assessment </b>
		</td>
	</tr>
</table>';
$para_cat.='<div style="font-family: Helvetica;font-size:12px;line-height: 1.5;color:#000;">';
$para_cat.='Following is the Competency Profile that has been used for the process of Assessment';
foreach($category as $categorys){
	if($categorys['category_id']!=4){
	$ass_comp_info=UlsAssessmentReport::getassessment_admin_competency($ass_id,$pos_id,$categorys['category_id']);	
	$para_cat.='<br><b align="left" style="font-family: Helvetica;font-size: 14px;color:#8064A2; line-height: 1.5;">'.$categorys['name'].'</b><br>';
	$para_cat.='<table style="width:100%" align="left" cellspacing="0" border="1px" bordercolor="#8064A2" cellpadding="5" style="font-family: Helvetica; color:#000;font-size:12px;line-height: 1.5; border:0.5px solid #9999;">
	<thead>
		<tr height="30" bgcolor="#8064A2" align="center" class="row header" style="font-size:14px;color:#fff;font-weight:bold">
			<th>Competency/Skill</th>
			<th>Level Requirement</th>
			<th>Criticality</th>
		</tr>
	</thead>
	<tbody>';
	$results=$assessor=array();
	$sub_cat_comp=UlsAssessmentReportBytype::get_competencies_subcat($_REQUEST['ass_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id']);
	echo $catsubname=explode("-",$sub_cat_comp['comp_def_name']);
	
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
	}$kk=0;
	$caomp_cat=trim($catsubname[0]);
	foreach($results as $comp_def_id=>$result){
		$final_admin_id=$_SESSION['user_id'];
		$bgcolor=($kk%2==0)?"#E6E0EC":"#ffffff";
		$kk++;
		$color=($result['comp_cri_code']=='C1')?'style="color:red"':'';
		$para_cat.='<tr bgcolor="'.$bgcolor.'">';
		if($result['comp_name']==$caomp_cat){
			
			$para_cat.='<td>'.$result['comp_name'].'<span style="color:red">**</span></td>';
		}
		/* elseif($result['comp_name']=='DAP - Operations'){
			$para_cat.='<td>'.$result['comp_name'].'<span style="color:red">**</span></td>';
		} 
		elseif($result['comp_name']=='SHE'){
			$para_cat.='<td>'.$result['comp_name'].'<span style="color:red">**</span></td>';
		}*/
		else{
			$para_cat.='<td>'.$result['comp_name'].'</td>';
		}
		$para_cat.='<td>'.$result['req_scale_name'].'</td>
		<td>'.$result['comp_cri_name'].'</td>		
		</tr>';
	}
	
	$para_cat.='</tbody>
	</table>';
	}
	if($categorys['category_id']==2){
		$para_cat.='<b style="font-family: Helvetica;font-size: 12px;">Note: There are sub competencies which define this competency in totality details of which are in Annexure 1</b>';
	}
}
$para_cat.='</div>';		
$tbl = <<<EOD

$para_cat
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

$getweights=UlsMenu::callpdo("SELECT * FROM `uls_assessment_competencies_weightage` WHERE `assessment_id`='".$_REQUEST['ass_id']."' and `position_id`='".$_REQUEST['pos_id']."' and assessment_type!='BEHAVORIAL_INSTRUMENT'");
$allweights=array();
foreach($getweights as $wei){
	$assessment_type=$wei['assessment_type'];
	$allweights[$assessment_type]=$wei['weightage'];
}
/* echo "<pre>";
print_r($allweights); */
$ass_comp_info=UlsAssessmentReportBytype::report_bytype_competencies($_REQUEST['ass_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id']);
$results_comp=array();
foreach($ass_comp_info as $ass_comp_infos){
	$comp_id=$ass_comp_infos['comp_def_id'];
	$req_scale_id=$ass_comp_infos['assessment_pos_level_scale_id'];
	$results_comp[$comp_id]['comp_id']=$comp_id;
	$results_comp[$comp_id]['cat_id']=$ass_comp_infos['comp_def_category'];
	$results_comp[$comp_id]['req_level']=$ass_comp_infos['scale_number'];
	$results_comp[$comp_id]['comp_name']=$ass_comp_infos['comp_def_name'];
	$results_comp[$comp_id]['pos_com_weightage']=$ass_comp_infos['pos_com_weightage'];
}
/* echo "<pre>";
print_r($results_comp); */
$getdats=UlsMenu::callpdo("SELECT avg(b.scale_number) as required,avg(c.scale_number) as assessed,a.`position_id`,a.`employee_id`,a.`assessment_type`,a.`competency_id`,ct.comp_def_category FROM `uls_assessment_report_bytype` a 
inner join(SELECT `assessment_pos_assessor_id`,`assessment_id`,`position_id`,`assessor_val`,assessor_id FROM `uls_assessment_position_assessor`) ac on ac.assessor_id=a.assessor_id and a.assessment_id=ac.assessment_id and a.`position_id`=ac.position_id
inner join uls_level_master_scale b on a.`require_scale_id`=b.scale_id inner join uls_level_master_scale c on a.`assessed_scale_id`=c.scale_id 
left join(SELECT `comp_def_id`,`comp_def_name`,`comp_def_category` FROM `uls_competency_definition`) ct on ct.comp_def_id=a.competency_id
 WHERE a.`assessment_id`='".$_REQUEST['ass_id']."' and a.`employee_id`='".$_REQUEST['emp_id']."' and a.`position_id`='".$_REQUEST['pos_id']."' group by a.`competency_id`, a.`assessment_type` ORDER BY `a`.`assessment_type` ASC");
$final_comp=$allcomp=$allcompfeed=$allcompreq=$allcomp_score_a=$allcomp_score_b=$allcomp_score_a_subcat=$allcomp_subcat=$allcompreq_subcat=array();
foreach($getdats as $aa){
	$cid=$aa['competency_id'];
	$catid=$aa['comp_def_category'];
	$ctype=$aa['assessment_type'];
	if($aa['assessed']>$aa['required']){
		$score_data=100;
	}
	elseif($aa['assessed']>=$aa['required']){
		$score_data=100;
	}
	elseif($aa['assessed']==$aa['required']){
		$score_data=100;
	}
	elseif($aa['assessed']<($aa['required']-1)){
		$score_data=25;
	}
	else{
		$score_data=50;
	}
	if($catid==4){
		$allcomp_score_a_subcat[$cid][$ctype]['score']=$score_data;
		$allcomp_subcat[$cid][$ctype]=$aa['assessed'];
		$allcompreq_subcat[$cid]=$aa['required'];
	}
	$allgg[$cid][$ctype]['score']=$score_data;
	$allcomp_score_a[$cid][$ctype]['score']=$score_data;
	$allcomp[$cid][$ctype]=$aa['assessed'];
	$allcompreq[$cid]=$aa['required'];
	
	
}
/* echo "<pre>";
print_r($allgg); */

$getdatfeeds=UlsMenu::callpdo("SELECT avg(a.`rater_value`) as val,a.`element_competency_id`,ct.comp_def_category FROM `uls_feedback_employee_rating` a
left join(SELECT `comp_def_id`,`comp_def_name`,`comp_def_category` FROM `uls_competency_definition`) ct on ct.comp_def_id=a.element_competency_id
WHERE a.`assessment_id`='".$_REQUEST['ass_id']."' and a.`employee_id`='".$_REQUEST['emp_id']."' and a.`giver_id`!='".$_REQUEST['emp_id']."' and a.`rater_value` is not null and a.`rater_value`!=0 group by a.`element_competency_id`");
foreach($getdatfeeds as $aaa){
	$cid=$aaa['element_competency_id'];
	$ctype="FEEDBACK";
	$catid=$aaa['comp_def_category'];
	$allcompfeed[$cid][$ctype]=$aaa['val'];
	/* if($aaa['val']>3){
		$score_data=25;
	}
	elseif(($aaa['val']<=3) && ($aaa['val']>=2.1)){
		$score_data=50;
	}
	elseif(($aaa['val']<=2) && ($aaa['val']>=1.5)){
		$score_data=75;
	}
	else{
		$score_data=100;
	} */
	$rat=round($aaa['val'],2);
	$score_data=round((100 - (($rat - 1) * ((100 - 0) / (5 - 1)))),2);

	if($catid==4){
		$allcomp_score_a_subcat[$cid][$ctype]['score']=$score_data;
	}
	$allcomp_score_a[$cid][$ctype]['score']=$score_data;
}
/* echo "<pre>";
print_r($allcomp_score_a);  */
foreach($allcomp_score_a as $key_com=>$allcomp_score_a_graph){
	$asstype_array=array();
	foreach($allcomp_score_a[$key_com] as $key=>$score_val){
		$asstype_array[$key]=$score_val['score'];
	}
	if(count($asstype_array)>0){
		require_once(LIB_PATH.DS.DS.'graph'.DS.'includes'.DS.'SVGGraph.php');
		$setting_method = array(
		  'back_colour' => '#fff',
		  'back_stroke_width' => 0,
		  'back_stroke_colour' => '#fff',
		  'stroke_colour' => '#666',
		  'axis_colour' => '#666',
		  'axis_overlap' => 2,
		  'grid_colour' => '#666',
		  'label_colour' => '#666',
		  'axis_font' => 'Arial',
		  'axis_font_size' => 16,
		  'pad_right' => 50,
		  'pad_left' => 50,
		  'link_base' => '/',
		  'link_target' => '_top',
		  'minimum_grid_spacing' => 30,
		  'show_subdivisions' => true,
		  'show_grid_subdivisions' => true,
		  'grid_subdivision_colour' => '#eee',
		  'bar_width'=>30,
		  'axis_max_h'=>100,
		  'show_bar_labels'=>true,
		  'data_label_font_size'=>12,
		  'data_label_fill'=>'#fff',
		  'bar_label_colour'=>'#fff',
		);

		$width = 300;
		$height = 200;
		$values = $asstype_array;


		$colours = array('#8064A2');
		$graph = new SVGGraph(650, 300, $setting_method);
		$graph->colours = $colours;
		$graph->Values($values);
		$value11=$graph->Fetch('HorizontalBarGraph', false);
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

		$myfile = fopen($target_path.DS.$_REQUEST['emp_id']."_".$_REQUEST['pos_id'].'_'.$key_com.'_assessement_method_bargraph.svg', "w") or die("Unable to open file!");
		//$target_path='public'.DS.'feedback'.DS.$feedid.DS.$name.'.svg';
		//$myfile = fopen($target_path, "w") or die("Unable to open file!");
		fwrite($myfile, $value11);
		fclose($myfile);
	}
}

$final_table='';
$final_table.='<table style="width:100%" align="left" cellspacing="0" border="0.5px" bordercolor="#59b0ea" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5;">
	<thead><tr height="30" bgcolor="#59b0ea" align="center" class="row header" style="color:#fff;">
			<th width="30%">Competency Name</th>
			<th width="10%">Level</th>
			<th width="20%">Assessment Weightages</th>
			<th width="10%">Final Score</th>
			<th width="20%">weighted Final Score</th>
			<th width="10%">Ass level</th>
		</tr>
	</thead>
	<tbody>';
	$total_comp_val_adequate=$total_comp_val_excellent=$total_comp_val_essential=$total_comp_val_rec=$total_comp_val_later=0;
	$total_comp_val_poor=$total_comp_val_average=$total_comp_val_good=$total_comp_val_vgood=0;
	$cat_ass_one_count=$cat_ass_final_one_count=0;
	$cat_ass_two=$cat_ass_two_count=$cat_ass_final_two=$cat_ass_final_two_count=0;
	$final_wei=0;
	$kkk=$ccc=1;
	$val_c=1;
	$cat_ass_one=$cat_ass_final_one=$ass_val_final=$rating_final_val=0;
	foreach($results_comp as $results_comps){
		$comp_id=$results_comps['comp_id'];
		$cat_sub_type=$results_comps['cat_id'];
		
		$method=array();
		$me_sum=0;
		foreach($allcomp_score_a[$comp_id] as $key=>$method_val){
			$method[]=$allweights[$key];
		}
		foreach($allcomp_score_a[$comp_id] as $key=>$method_val){
			$me_sum+=($allweights[$key]/array_sum($method))*$method_val['score'];
		}
		//echo "<br>".$allweights[$key]."-".array_sum($method)."-".$comp_id."-".$method_val['score'];
		
		$final_val=round($me_sum,2);
		$rating_final_val+=$results_comps['req_level'];
		$final_wei+=round((($final_val*$results_comps['pos_com_weightage'])/100),2);
		$ass_val=round(($results_comps['req_level']*$final_val)/100,2);
		$ass_val_final+=$ass_val;
		$final_table.='<tr>
			<td width="30%">'.$results_comps['comp_name'].'</td>
			<td width="10%">'.$results_comps['req_level'].'</td>
			<td width="20%">'.$results_comps['pos_com_weightage'].'%</td>
			<td width="10%">'.$final_val.'</td>
			<td width="20%">'.round((($final_val*$results_comps['pos_com_weightage'])/100),2).'</td>
			<td width="10%">'.$ass_val.'</td>
		</tr>';
		$kkcomp_id[$comp_id]="C".($kkk);
		$kkreq_sid[$comp_id]=$results_comps['req_level'];
		$kkass_sid[$comp_id]=$ass_val;
		$kkcomp_name[$comp_id]="C".($kkk)." ".$results_comps['comp_name'];
		if($final_val>=0 && $final_val<=40){
			$total_comp_val_poor+=1;
		}
		if($final_val>40 && $final_val<=60){
			$total_comp_val_average+=1;
		}
		if($final_val>60 && $final_val<=80){
			$total_comp_val_good+=1;
		}
		if($final_val>80 && $final_val<=100){
			$total_comp_val_vgood+=1;
		}
		
		if($final_val>=0 && $final_val<=65){
			$total_comp_val_essential+=1;
			$comp_training[$comp_id]=$results_comps['comp_name'];
		}
		
		if($final_val>65 && $final_val<=85){
			$total_comp_val_rec+=1;
		}
		if($final_val>85 && $final_val<=100){
			$total_comp_val_later+=1;
		}
		if($cat_sub_type==2){
			$cat_ass_one+=$ass_val;
			$cat_ass_one_count+=1;
			$cat_ass_final_one+=$results_comps['req_level'];
			$cat_ass_final_one_count+=1;
			$kkcomp_name_sub[$comp_id]=$results_comps['comp_name'];
			$kkcomp_name_sub_anns[$comp_id]=$results_comps['comp_name'];
			$kkcomp_name_sub_one[$comp_id]=$results_comps['comp_name'];
		}
		if($cat_sub_type==3){
			$cat_ass_two+=$ass_val;
			$cat_ass_two_count+=1;
			$cat_ass_final_two+=$results_comps['req_level'];
			$cat_ass_final_two_count+=1;
			$kkcomp_name_sub_two[$comp_id]=$results_comps['comp_name'];
			$kkcomp_name_sub_anns[$comp_id]=$results_comps['comp_name'];
		}
		if($cat_sub_type==4){
			$kkcomp_id_sub[$comp_id]="P & I/".($ccc);
			$kkreq_sid_sub[$comp_id]=$results_comps['req_level'];
			$kkass_sid_sub[$comp_id]=$ass_val;
			$kkcomp_name_sub[$comp_id]=$results_comps['comp_name'];
			$kkcomp_name_sub_comp[$comp_id]="P & I/".($ccc)." ".$results_comps['comp_name'];
			$ccc++;
		}
		
		$kkk++;
		
	}
	$final_table.='<tr>
		<td></td>
		<td>'.$rating_final_val.'</td>
		<td></td>
		<td>'.$final_wei.'</td>
		<td></td>
		<td>'.$ass_val_final.'</td>
	</tr>';
	$final_table.='</tbody>
</table>';
/* echo "<pre>";
print_r($comp_training); */
/* echo "<pre>";
print_r($kkcomp_name_sub_comp); */
//print_r($total_comp_val_adequate."-".$total_comp_val_good."-".$total_comp_val_excellent);
/* print_r($total_comp_val_essential."-".$total_comp_val_rec."-".$total_comp_val_later); */

$division=0.5;
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
	/* 'axis_min_v' => $minv,
	'axis_max_v' => $maxv, */
	'show_subdivisions' => true,
	'show_grid_subdivisions' => false,
	'grid_subdivision_colour' => '#ccc',
	//'marker_type'       => array('*', 'star'),
	//'marker_colour'     => array('#008534', '#850000')
	'legend_position' => "outer bottom 0 0",
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

$division=0.5;
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
	/* 'axis_min_v' => $minv,
	'axis_max_v' => $maxv, */
	'show_subdivisions' => true,
	'show_grid_subdivisions' => false,
	'grid_subdivision_colour' => '#ccc',
	//'marker_type'       => array('*', 'star'),
	//'marker_colour'     => array('#008534', '#850000')
	'legend_position' => "outer bottom 0 0",
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
$val_required_sub=array_combine($kkcomp_id_sub,$kkreq_sid_sub);
$val_assessed_sub=array_combine($kkcomp_id_sub,$kkass_sid_sub);

$values = array($val_required_sub,$val_assessed_sub);
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

$myfile = fopen($target_path.DS.$_REQUEST['emp_id']."_".$_REQUEST['pos_id'].'_sub_radar.svg', "w") or die("Unable to open file!");
//$target_path='public'.DS.'feedback'.DS.$feedid.DS.$name.'.svg';
//$myfile = fopen($target_path, "w") or die("Unable to open file!");
fwrite($myfile, $value11);
fclose($myfile);

$performance_graph="<svg xmlns:xlink='http://www.w3.org/1999/xlink' xmlns='http://www.w3.org/2000/svg' width='500' height='150' version='1.1'><rect width='100%' height='100%' fill='#fff' stroke-width='0px'/><g><path d='M31 128h440M31 10h440M31 10v118M53 10v118M75 10v118M97 10v118M119 10v118M141 10v118M163 10v118M185 10v118M207 10v118M229 10v118M251 10v118M273 10v118M295 10v118M317 10v118M339 10v118M361 10v118M383 10v118M405 10v118M427 10v118M449 10v118M471 10v118' stroke='#aaa'/></g><rect height='80' y='29' x='31' width='176' id='e3' style='stroke:#aaa;stroke-width:1px;fill:#ee4b2b'/><rect height='80' y='29' x='207' width='88' id='e5' style='stroke:#aaa;stroke-width:1px;fill:#ffb900'/><rect height='80' y='29' x='295' width='88' id='e7' style='stroke:#aaa;stroke-width:1px;fill:#8bc249'/><rect height='80' y='29' x='383' width='88' id='e9' style='stroke:#aaa;stroke-width:1px;fill:#009750'/><path d='M31 131v-3M53 131v-3M75 131v-3M97 131v-3M119 131v-3M141 131v-3M163 131v-3M185 131v-3M207 131v-3M229 131v-3M251 131v-3M273 131v-3M295 131v-3M317 131v-3M339 131v-3M361 131v-3M383 131v-3M405 131v-3M427 131v-3M449 131v-3M471 131v-3M28 128h3M28 10h3' stroke-width='1px' stroke='#aaa'/><g stroke='#aaa' stroke-width='2px'><path d='M29 128h444'/><path d='M31 8v122'/></g><g font-size='10px' font-family='Georgia' fill='#aaa'><g text-anchor='end' fill='#fff'></g><g text-anchor='middle'><text y='140' x='31'>0%</text><text y='140' x='75'>10%</text><text y='140' x='119'>20%</text><text y='140' x='163'>30%</text><text y='140' x='207'>40%</text><text y='140' x='251'>50%</text><text y='140' x='295'>60%</text><text y='140' x='339'>70%</text><text y='140' x='383'>80%</text><text y='140' x='427'>90%</text><text y='140' x='471'>100%</text></g></g><g><g><text font-family='sans-serif' font-size='20px' fill='rgb(0,0,0)' y='76' x='119' text-anchor='middle'>$total_comp_val_poor</text></g><g><text font-family='sans-serif' font-size='20px' fill='rgb(0,0,0)' y='76' x='251' text-anchor='middle'>$total_comp_val_average</text></g><g><text font-family='sans-serif' font-size='20px' fill='rgb(0,0,0)' y='76' x='339' text-anchor='middle'>$total_comp_val_good</text></g><g><text font-family='sans-serif' font-size='20px' fill='rgb(0,0,0)' y='76' x='427' text-anchor='middle'>$total_comp_val_vgood</text></g></g><rect height='80' y='29' x='31' width='176' id='e2' style='stroke:#aaa;stroke-width:1px;fill:#ee4b2b' opacity='0'/><rect height='80' y='29' x='207' width='88' id='e4' style='stroke:#aaa;stroke-width:1px;fill:#ffb900' opacity='0'/><rect height='80' y='29' x='295' width='88' id='e6' style='stroke:#aaa;stroke-width:1px;fill:#8bc249' opacity='0'/><rect height='80' y='29' x='383' width='88' id='e8' style='stroke:#aaa;stroke-width:1px;fill:#009750' opacity='0'/><g id='tooltip' visibility='hidden' transform='translate(467 41)'><rect fill='#000' opacity='0.3' x='1.5px' y='1.5px' width='19px' height='19px' id='ttshdw' rx='0px' ry='0px'/><rect stroke='black' stroke-width='1px' fill='#ffffcc' width='18px' height='18px' id='ttrect' rx='0px' ry='0px'/><g id='tooltiptext' fill='black' font-size='10px' font-family='sans-serif' font-weight='normal' text-anchor='middle' visibility='hidden' transform='translate(9,0)'><text y='13px'>20</text></g></g></svg>";

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

$myfile = fopen($target_path.DS.$_REQUEST['emp_id']."_".$_REQUEST['pos_id'].'_performance_graph.svg', "w") or die("Unable to open file!");
//$target_path='public'.DS.'feedback'.DS.$feedid.DS.$name.'.svg';
//$myfile = fopen($target_path, "w") or die("Unable to open file!");
fwrite($myfile, $performance_graph);
fclose($myfile);

$indicative_graph="<svg xmlns:xlink='http://www.w3.org/1999/xlink' xmlns='http://www.w3.org/2000/svg' width='500' height='150' version='1.1'><rect width='100%' height='100%' fill='#fff' stroke-width='0px'/><g><path d='M31 128h440M31 10h440M31 10v118M53 10v118M75 10v118M97 10v118M119 10v118M141 10v118M163 10v118M185 10v118M207 10v118M229 10v118M251 10v118M273 10v118M295 10v118M317 10v118M339 10v118M361 10v118M383 10v118M405 10v118M427 10v118M449 10v118M471 10v118' stroke='#aaa'/></g><rect height='80' y='29' x='31' width='286' id='e3' style='stroke:#aaa;stroke-width:1px;fill:#ffb900'/><rect height='80' y='29' x='317' width='88' id='e5' style='stroke:#aaa;stroke-width:1px;fill:#8bc249'/><rect height='80' y='29' x='405' width='66' id='e7' style='stroke:#aaa;stroke-width:1px;fill:#009750'/><path d='M31 131v-3M53 131v-3M75 131v-3M97 131v-3M119 131v-3M141 131v-3M163 131v-3M185 131v-3M207 131v-3M229 131v-3M251 131v-3M273 131v-3M295 131v-3M317 131v-3M339 131v-3M361 131v-3M383 131v-3M405 131v-3M427 131v-3M449 131v-3M471 131v-3M28 128h3M28 10h3' stroke-width='1px' stroke='#aaa'/><g stroke='#aaa' stroke-width='2px'><path d='M29 128h444'/><path d='M31 8v122'/></g><g font-size='10px' font-family='Georgia' fill='#aaa'><g text-anchor='end' fill='#fff'><text x='26' y='72'>0</text></g><g text-anchor='middle'><text y='140' x='31'>0%</text><text y='140' x='75'>10%</text><text y='140' x='119'>20%</text><text y='140' x='163'>30%</text><text y='140' x='207'>40%</text><text y='140' x='251'>50%</text><text y='140' x='295'>60%</text><text y='140' x='339'>70%</text><text y='140' x='383'>80%</text><text y='140' x='427'>90%</text><text y='140' x='471'>100%</text></g></g><g><g><text font-family='sans-serif' font-size='20px' fill='rgb(0,0,0)' y='76' x='174' text-anchor='middle'>$total_comp_val_essential</text></g><g><text font-family='sans-serif' font-size='20px' fill='rgb(0,0,0)' y='76' x='361' text-anchor='middle'>$total_comp_val_rec</text></g><g><text font-family='sans-serif' font-size='20px' fill='rgb(0,0,0)' y='76' x='438' text-anchor='middle'>$total_comp_val_later</text></g></g><rect height='80' y='29' x='31' width='286' id='e2' style='stroke:#aaa;stroke-width:1px;fill:#ffb900' opacity='0'/><rect height='80' y='29' x='317' width='88' id='e4' style='stroke:#aaa;stroke-width:1px;fill:#8bc249' opacity='0'/><rect height='80' y='29' x='405' width='66' id='e6' style='stroke:#aaa;stroke-width:1px;fill:#009750' opacity='0'/><g id='tooltip' visibility='hidden' transform='translate(463 117)'><rect fill='#000' opacity='0.3' x='1.5px' y='1.5px' width='19px' height='19px' id='ttshdw' rx='0px' ry='0px'/><rect stroke='black' stroke-width='1px' fill='#ffffcc' width='18px' height='18px' id='ttrect' rx='0px' ry='0px'/><g id='tooltiptext' fill='black' font-size='10px' font-family='sans-serif' font-weight='normal' text-anchor='middle' visibility='hidden' transform='translate(9,0)'><text y='13px'>15</text></g></g></svg>";

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

$myfile = fopen($target_path.DS.$_REQUEST['emp_id']."_".$_REQUEST['pos_id'].'_indicative_graph.svg', "w") or die("Unable to open file!");
//$target_path='public'.DS.'feedback'.DS.$feedid.DS.$name.'.svg';
//$myfile = fopen($target_path, "w") or die("Unable to open file!");
fwrite($myfile, $indicative_graph);
fclose($myfile);

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
$pdf->writeHTML($tbl, true, false, false, false, '');  */


$pdf->AddPage();
$pdf->footershow=true;
$pdf->SetFooterMargin(0);
$pdf->Bookmark('4. Competency Assessment Overview', 0, 0, '', '', array(0,0,0));
$index_link = $pdf->AddLink();
$pdf->SetLink($index_link, 0, '*1');
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(true, 25);
//$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();
$over_rate='';
if($final_wei>=0 && $final_wei<=40){
	$ass_overview='Poor';
	$over_rate='<img src="'.BASE_URL.'/public/reports/Poor.png" style="text-align:center">';
}
if($final_wei>40 && $final_wei<=60){
	$ass_overview='Average';
	$over_rate='<img src="'.BASE_URL.'/public/reports/Average.png" style="text-align:center">';
}
if($final_wei>60 && $final_wei<=80){
	$ass_overview='Good';
	$over_rate='<img src="'.BASE_URL.'/public/reports/Good.png" style="text-align:center">';
}
if($final_wei>80 && $final_wei<=100){
	$ass_overview='Very Good';
	$over_rate='<img src="'.BASE_URL.'/public/reports/Verygood.png" style="text-align:center">';
}
$compact_ass='';
$compact_ass.='
<div style="font-family: Helvetica;font-size:12px;line-height: 1.5;color:#000;">
<table cellspacing="0" cellpadding="5" border="0" >
    
	<tr>
		<td width="50%">
			<table cellspacing="0" cellpadding="4" border="0"  >
				<tr>
					<td width="70%" style="font-family: Helvetica;font-size:14px;background-color:#9E768F;">
						<b style="font-size: 5pt;color:#ffffff;">&nbsp;</b>
						<b style="font-family: Helvetica;font-size:14px;color:#ffffff;">4. Competency Assessment Overview</b>
					</td>
				</tr>
			</table>
			<div style="font-family: Helvetica;font-size:12px;line-height: 1.5;color:#000;">
				The following is a snapshot or a summary of the entire assessment<br>
				'.trim($emp_info['name']).' was assessed on '.count($results_comp).' competencies for the position of '.@$posdetails['position_name'].'. Overall, on a 100 - point scale he scored '.$final_wei.', which means '.trim($emp_info['name']).' can be rated as '.$ass_overview.'
				<br>';
				$compact_ass.=$over_rate;
			$compact_ass.='</div>
		</td>
		<td width="50%">
			<table cellspacing="0" cellpadding="5" border="0" >
				<tr>
					<td width="50%">
						<table cellspacing="0" cellpadding="4" border="0"  >
							<tr>
								<td width="100%" style="font-family: Helvetica;font-size:14px;">
									<b style="font-size: 5pt;color:#000;">&nbsp;</b>
									<b style="font-family: Helvetica;font-size:14px;color:#000;">Overall Competency Rating</b>
								</td>
							</tr>
							<tr>
								<td><img src="'.BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['ass_id'].'/'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'_radar.svg" /></td>
							</tr>
						</table>
					</td>
					<td width="50%">
						<table cellspacing="0" cellpadding="4" border="0"  >
							<tr>
								<td width="100%" style="font-family: Helvetica;font-size:14px;">
									<b style="font-size: 5pt;color:#000;">&nbsp;</b>
									<b style="font-family: Helvetica;font-size:14px;color:#000;">Sub Competency Rating</b>
								</td>
							</tr>
							<tr>
								<td><img src="'.BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['ass_id'].'/'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'_sub_radar.svg" /></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<div style="font-family: Helvetica;font-size:12px;line-height: 1.5;color:#000;">
				Note: Kindly refer “Annexure 1” for detailed explanation of the graph.
			</div>
		</td>
	</tr>
	<tr>
		<td width="50%">
			<table cellspacing="0" cellpadding="4" border="0"  >
				<tr>
					<td width="100%" style="font-family: Helvetica;font-size:14px;">
						<b style="font-size: 5pt;color:#000;">&nbsp;</b>
						<b style="font-family: Helvetica;font-size:14px;color:#000;">Competency Levels:</b><br>
						<b style="font-family: Helvetica;font-size:14px;color:#000;">*Performance on Total '.count($results_comp).' Competencies Assessed*</b>
					</td>
				</tr>
				<tr>
					<td><img src="'.BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['ass_id'].'/'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'_performance_graph.svg" width="500" height="150"/></td>
				</tr>
				<tr>
					<td  width="10%"></td>
					<td  width="3%"  bgcolor="#EE4B2B" ></td>
					<td  width="15%" style="font-family: Helvetica;font-size:12px;color:#000;">Poor</td>
					<td  width="3%"  bgcolor="#ffb900" ></td>
					<td  width="15%"  style="font-family: Helvetica;font-size:12px;color:#000;">Average</td>
					<td  width="3%" bgcolor="#8bc249"></td>
					<td  width="15%"  style="font-family: Helvetica;font-size:12px;color:#000;">Good</td>
					<td  width="3%" bgcolor="#009750"></td>
					<td  width="15%" style="font-family: Helvetica;font-size:12px;color:#000;">Very Good</td>
				</tr>
			</table>
		</td>
		<td width="50%">
			<table cellspacing="0" cellpadding="4" border="0"  >
				<tr>
					<td width="100%" style="font-family: Helvetica;font-size:14px;">
						<b style="font-size: 5pt;color:#000;">&nbsp;</b><br>
						<b style="font-family: Helvetica;font-size:14px;color:#000;">Indicative Training Needs</b>
					</td>
				</tr>
				<tr>
					<td><img src="'.BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['ass_id'].'/'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'_indicative_graph.svg" width="500" height="150" /></td>
				</tr>
				<tr>
					<td  width="5%"></td>
					<td  width="3%"  bgcolor="#ffb900" ></td>
					<td  width="30%"  style="color:#646464;" style="font-family: Helvetica;font-size:12px;color:#000;">Training is Essential</td>
					<td  width="3%" bgcolor="#8bc249"></td>
					<td  width="30%"  style="color:#646464;" style="font-family: Helvetica;font-size:12px;color:#000;">Training is Recommeded</td>
					<td  width="3%" bgcolor="#009750"></td>
					<td  width="30%"  style="color:#646464;" style="font-family: Helvetica;font-size:12px;color:#000;">Train Later</td>
				</tr>
			</table>
			
		</td>
	</tr>
</table></div>
';
$tbl = <<<EOD
$compact_ass
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');



$pdf->AddPage();
$pdf->footershow=true;
$pdf->SetFooterMargin(0);
$pdf->Bookmark('5. Consolidated Summary of Results', 0, 0, '', '', array(0,0,0));
$pdf->Bookmark('*&nbsp;&nbsp;Understanding the overall assessment analysis', 1, 0, '', '', array(0,0,0));
$index_link = $pdf->AddLink();
$pdf->SetLink($index_link, 0, '*1');
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(true, 25);
//$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();
$cat_one_final=round(($cat_ass_one/$cat_ass_one_count),2);
$cat_req_level=round(($cat_ass_final_one/$cat_ass_final_one_count),2);
$cat_one_final_per=round((($cat_one_final/$cat_req_level)*100),2);
if($cat_one_final_per>=0 && $cat_one_final_per<=40){
	$cat_ass_overview='Poor';
}
if($cat_one_final_per>40 && $cat_one_final_per<=60){
	$cat_ass_overview='Average';
}
if($cat_one_final_per>60 && $cat_one_final_per<=80){
	$cat_ass_overview='Good';
}
if($cat_one_final_per>80 && $cat_one_final_per<=100){
	$cat_ass_overview='Very Good';
}
$target_path=__SITE_PATH.DS.'public'.DS.'reports'.DS.'graphs'.DS.'full'.DS.$_REQUEST['ass_id'];
if(is_dir($target_path)){
	//echo "Exists!";
} 
else{ 
	mkdir($target_path,0777);
	chmod($target_path, 0777);
}
$a=540;
$b=(540*$cat_one_final_per)/100;
$value_man="<svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns='http://www.w3.org/2000/svg' width='800' height='180'><g transform='translate(10,5)'><rect width='540' height='25' x='0' style='fill:#eee'></rect><rect width='540' height='8.333333333333334' x='0' y='8.333333333333334' style='fill:#8064a2'></rect><line style='stroke:#403251;stroke-width:5px' x1='".$b."' x2='".$b."' y1='0' y2='25'></line><g transform='translate(0,0)' style='opacity:1'><line y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.5px'></line><text style='font-family:sans-serif' text-anchor='middle' dy='1em' y='39.166666666666668' font-size='10px'>0%</text></g><g><line x1='10.8' x2='10.8' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='21.6' x2='21.6' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='32.4' x2='32.4' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='43.2' x2='43.2' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='64.8' x2='64.8' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='75.6' x2='75.6' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='86.4' x2='86.4' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='97.2' x2='97.2' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='118.8' x2='118.8' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='129.6' x2='129.6' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='140.4' x2='140.4' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='151.2' x2='151.2' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='172.8' x2='172.8' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='183.6' x2='183.6' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='194.4' x2='194.4' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='205.2' x2='205.2' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='226.8' x2='226.8' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='237.6' x2='237.6' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='248.4' x2='248.4' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='259.2' x2='259.2' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='280.8' x2='280.8' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='291.6' x2='291.6' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='302.4' x2='302.4' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='313.2' x2='313.2' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='334.8' x2='334.8' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='345.6' x2='345.6' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='356.4' x2='356.4' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='367.2' x2='367.2' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='388.8' x2='388.8' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='399.6' x2='399.6' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='410.4' x2='410.4' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='421.2' x2='421.2' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='442.8' x2='442.8' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='453.6' x2='453.6' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='464.4' x2='464.4' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='475.2' x2='475.2' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='496.8' x2='496.8' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='507.6' x2='507.6' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='518.4' x2='518.4' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='529.2' x2='529.2' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g transform='translate(54,0)' style='opacity:1'><line y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.5px'></line><text style='font-family:sans-serif' text-anchor='middle' dy='1em' y='39.166666666666668' font-size='10px'>10%</text></g><g transform='translate(108,0)' style='opacity:1'><line y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.5px'></line><text style='font-family:sans-serif' text-anchor='middle' dy='1em' y='39.166666666666668' font-size='10px'>20%</text></g><g transform='translate(162,0)' style='opacity:1'><line y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.5px'></line><text style='font-family:sans-serif' text-anchor='middle' dy='1em' y='39.166666666666668' font-size='10px'>30%</text></g><g transform='translate(216,0)' style='opacity:1'><line y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.5px'></line><text style='font-family:sans-serif' text-anchor='middle' dy='1em' y='39.166666666666668' font-size='10px'>40%</text></g><g transform='translate(270,0)' style='opacity:1'><line y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.5px'></line><text style='font-family:sans-serif' text-anchor='middle' dy='1em' y='39.166666666666668' font-size='10px'>50%</text></g><g transform='translate(324,0)' style='opacity:1'><line y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.5px'></line><text style='font-family:sans-serif' text-anchor='middle' dy='1em' y='39.166666666666668' font-size='10px'>60%</text></g><g transform='translate(378,0)' style='opacity:1'><line y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.5px'></line><text style='font-family:sans-serif' text-anchor='middle' dy='1em' y='39.166666666666668' font-size='10px'>70%</text></g><g transform='translate(432,0)' style='opacity:1'><line y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.5px'></line><text style='font-family:sans-serif' text-anchor='middle' dy='1em' y='39.166666666666668' font-size='10px'>80%</text></g><g transform='translate(486,0)' style='opacity:1'><line y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.5px'></line><text style='font-family:sans-serif' text-anchor='middle' dy='1em' y='39.166666666666668' font-size='10px'>90%</text></g><g transform='translate(540,0)' style='opacity:1'><line y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.5px'></line><text style='font-family:sans-serif' text-anchor='middle' dy='1em' y='39.166666666666668' font-size='10px'>100%</text></g><g style='text-anchor:end' transform='translate(-6,12.5)'><text font-size='16px' style='font-family:sans-serif'></text></g></g></svg>";
$myfile_man = fopen($target_path.DS.$_REQUEST['emp_id']."_".$_REQUEST['pos_id'].'_functional_technical.svg', "w") or die("Unable to open file!");
fwrite($myfile_man, $value_man);
fclose($myfile_man);

$cat_two_final=round(($cat_ass_two/$cat_ass_two_count),2);
$cat_req_level_two=round(($cat_ass_final_two/$cat_ass_final_two_count),2);
$cat_two_final_per=round((($cat_two_final/$cat_req_level_two)*100),2);
if($cat_two_final_per>=0 && $cat_two_final_per<=40){
	$cat_ass_overview_two='Poor';
}
if($cat_two_final_per>40 && $cat_two_final_per<=60){
	$cat_ass_overview_two='Average';
}
if($cat_two_final_per>60 && $cat_two_final_per<=80){
	$cat_ass_overview_two='Good';
}
if($cat_two_final_per>80 && $cat_two_final_per<=100){
	$cat_ass_overview_two='Very Good';
}
$target_path=__SITE_PATH.DS.'public'.DS.'reports'.DS.'graphs'.DS.'full'.DS.$_REQUEST['ass_id'];
if(is_dir($target_path)){
	//echo "Exists!";
} 
else{ 
	mkdir($target_path,0777);
	chmod($target_path, 0777);
}
$a=540;
$b=(540*$cat_two_final_per)/100;
$value_tec="<svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns='http://www.w3.org/2000/svg' width='800' height='180'><g transform='translate(10,5)'><rect width='540' height='25' x='0' style='fill:#eee'></rect><rect width='540' height='8.333333333333334' x='0' y='8.333333333333334' style='fill:#8064a2'></rect><line style='stroke:#403251;stroke-width:5px' x1='".$b."' x2='".$b."' y1='0' y2='25'></line><g transform='translate(0,0)' style='opacity:1'><line y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.5px'></line><text style='font-family:sans-serif' text-anchor='middle' dy='1em' y='39.166666666666668' font-size='10px'>0%</text></g><g><line x1='10.8' x2='10.8' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='21.6' x2='21.6' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='32.4' x2='32.4' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='43.2' x2='43.2' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='64.8' x2='64.8' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='75.6' x2='75.6' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='86.4' x2='86.4' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='97.2' x2='97.2' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='118.8' x2='118.8' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='129.6' x2='129.6' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='140.4' x2='140.4' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='151.2' x2='151.2' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='172.8' x2='172.8' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='183.6' x2='183.6' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='194.4' x2='194.4' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='205.2' x2='205.2' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='226.8' x2='226.8' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='237.6' x2='237.6' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='248.4' x2='248.4' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='259.2' x2='259.2' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='280.8' x2='280.8' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='291.6' x2='291.6' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='302.4' x2='302.4' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='313.2' x2='313.2' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='334.8' x2='334.8' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='345.6' x2='345.6' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='356.4' x2='356.4' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='367.2' x2='367.2' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='388.8' x2='388.8' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='399.6' x2='399.6' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='410.4' x2='410.4' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='421.2' x2='421.2' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='442.8' x2='442.8' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='453.6' x2='453.6' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='464.4' x2='464.4' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='475.2' x2='475.2' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='496.8' x2='496.8' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='507.6' x2='507.6' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='518.4' x2='518.4' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='529.2' x2='529.2' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g transform='translate(54,0)' style='opacity:1'><line y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.5px'></line><text style='font-family:sans-serif' text-anchor='middle' dy='1em' y='39.166666666666668' font-size='10px'>10%</text></g><g transform='translate(108,0)' style='opacity:1'><line y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.5px'></line><text style='font-family:sans-serif' text-anchor='middle' dy='1em' y='39.166666666666668' font-size='10px'>20%</text></g><g transform='translate(162,0)' style='opacity:1'><line y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.5px'></line><text style='font-family:sans-serif' text-anchor='middle' dy='1em' y='39.166666666666668' font-size='10px'>30%</text></g><g transform='translate(216,0)' style='opacity:1'><line y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.5px'></line><text style='font-family:sans-serif' text-anchor='middle' dy='1em' y='39.166666666666668' font-size='10px'>40%</text></g><g transform='translate(270,0)' style='opacity:1'><line y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.5px'></line><text style='font-family:sans-serif' text-anchor='middle' dy='1em' y='39.166666666666668' font-size='10px'>50%</text></g><g transform='translate(324,0)' style='opacity:1'><line y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.5px'></line><text style='font-family:sans-serif' text-anchor='middle' dy='1em' y='39.166666666666668' font-size='10px'>60%</text></g><g transform='translate(378,0)' style='opacity:1'><line y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.5px'></line><text style='font-family:sans-serif' text-anchor='middle' dy='1em' y='39.166666666666668' font-size='10px'>70%</text></g><g transform='translate(432,0)' style='opacity:1'><line y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.5px'></line><text style='font-family:sans-serif' text-anchor='middle' dy='1em' y='39.166666666666668' font-size='10px'>80%</text></g><g transform='translate(486,0)' style='opacity:1'><line y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.5px'></line><text style='font-family:sans-serif' text-anchor='middle' dy='1em' y='39.166666666666668' font-size='10px'>90%</text></g><g transform='translate(540,0)' style='opacity:1'><line y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.5px'></line><text style='font-family:sans-serif' text-anchor='middle' dy='1em' y='39.166666666666668' font-size='10px'>100%</text></g><g style='text-anchor:end' transform='translate(-6,12.5)'><text font-size='16px' style='font-family:sans-serif'></text></g></g></svg>";
$myfile_tec = fopen($target_path.DS.$_REQUEST['emp_id']."_".$_REQUEST['pos_id'].'_managerial_behavioural.svg', "w") or die("Unable to open file!");
fwrite($myfile_tec, $value_tec);
fclose($myfile_tec);




$final_assessed_level=round(($ass_val_final/count($results_comp)),2);
$final_assessed_percentage=round((($ass_val_final/$rating_final_val)*100),2);

/* if($final_assessed_percentage>=0 && $final_assessed_percentage<=40){
	$overview_final_conmment='Poor';
}
if($final_assessed_percentage>40 && $final_assessed_percentage<=60){
	$overview_final_conmment='Average';
}
if($final_assessed_percentage>60 && $final_assessed_percentage<=80){
	$overview_final_conmment='Good';
}
if($final_assessed_percentage>80 && $final_assessed_percentage<=100){
	$overview_final_conmment='Very Good';
} */
if($final_wei>=0 && $final_wei<=40){
	$overview_final_conmment='Poor';
}
if($final_wei>40 && $final_wei<=60){
	$overview_final_conmment='Average';
}
if($final_wei>60 && $final_wei<=80){
	$overview_final_conmment='Good';
}
if($final_wei>80 && $final_wei<=100){
	$overview_final_conmment='Very Good';
}



$target_path=__SITE_PATH.DS.'public'.DS.'reports'.DS.'graphs'.DS.'full'.DS.$_REQUEST['ass_id'];
if(is_dir($target_path)){
	//echo "Exists!";
} 
else{ 
	mkdir($target_path,0777);
	chmod($target_path, 0777);
}
$a=540;
$b=(540*$final_wei)/100;
$value_over_final="<svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns='http://www.w3.org/2000/svg' width='800' height='180'><g transform='translate(10,5)'><rect width='540' height='25' x='0' style='fill:#eee'></rect><rect width='540' height='8.333333333333334' x='0' y='8.333333333333334' style='fill:#8064a2'></rect><line style='stroke:#403251;stroke-width:5px' x1='".$b."' x2='".$b."' y1='0' y2='25'></line><g transform='translate(0,0)' style='opacity:1'><line y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.5px'></line><text style='font-family:sans-serif' text-anchor='middle' dy='1em' y='39.166666666666668' font-size='10px'>0%</text></g><g><line x1='10.8' x2='10.8' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='21.6' x2='21.6' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='32.4' x2='32.4' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='43.2' x2='43.2' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='64.8' x2='64.8' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='75.6' x2='75.6' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='86.4' x2='86.4' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='97.2' x2='97.2' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='118.8' x2='118.8' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='129.6' x2='129.6' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='140.4' x2='140.4' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='151.2' x2='151.2' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='172.8' x2='172.8' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='183.6' x2='183.6' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='194.4' x2='194.4' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='205.2' x2='205.2' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='226.8' x2='226.8' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='237.6' x2='237.6' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='248.4' x2='248.4' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='259.2' x2='259.2' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='280.8' x2='280.8' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='291.6' x2='291.6' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='302.4' x2='302.4' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='313.2' x2='313.2' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='334.8' x2='334.8' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='345.6' x2='345.6' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='356.4' x2='356.4' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='367.2' x2='367.2' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='388.8' x2='388.8' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='399.6' x2='399.6' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='410.4' x2='410.4' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='421.2' x2='421.2' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='442.8' x2='442.8' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='453.6' x2='453.6' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='464.4' x2='464.4' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='475.2' x2='475.2' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='496.8' x2='496.8' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='507.6' x2='507.6' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='518.4' x2='518.4' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g><line x1='529.2' x2='529.2' y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.1px'></line></g><g transform='translate(54,0)' style='opacity:1'><line y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.5px'></line><text style='font-family:sans-serif' text-anchor='middle' dy='1em' y='39.166666666666668' font-size='10px'>10%</text></g><g transform='translate(108,0)' style='opacity:1'><line y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.5px'></line><text style='font-family:sans-serif' text-anchor='middle' dy='1em' y='39.166666666666668' font-size='10px'>20%</text></g><g transform='translate(162,0)' style='opacity:1'><line y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.5px'></line><text style='font-family:sans-serif' text-anchor='middle' dy='1em' y='39.166666666666668' font-size='10px'>30%</text></g><g transform='translate(216,0)' style='opacity:1'><line y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.5px'></line><text style='font-family:sans-serif' text-anchor='middle' dy='1em' y='39.166666666666668' font-size='10px'>40%</text></g><g transform='translate(270,0)' style='opacity:1'><line y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.5px'></line><text style='font-family:sans-serif' text-anchor='middle' dy='1em' y='39.166666666666668' font-size='10px'>50%</text></g><g transform='translate(324,0)' style='opacity:1'><line y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.5px'></line><text style='font-family:sans-serif' text-anchor='middle' dy='1em' y='39.166666666666668' font-size='10px'>60%</text></g><g transform='translate(378,0)' style='opacity:1'><line y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.5px'></line><text style='font-family:sans-serif' text-anchor='middle' dy='1em' y='39.166666666666668' font-size='10px'>70%</text></g><g transform='translate(432,0)' style='opacity:1'><line y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.5px'></line><text style='font-family:sans-serif' text-anchor='middle' dy='1em' y='39.166666666666668' font-size='10px'>80%</text></g><g transform='translate(486,0)' style='opacity:1'><line y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.5px'></line><text style='font-family:sans-serif' text-anchor='middle' dy='1em' y='39.166666666666668' font-size='10px'>90%</text></g><g transform='translate(540,0)' style='opacity:1'><line y1='25' y2='29.166666666666668' style='stroke:#666;stroke-width:.5px'></line><text style='font-family:sans-serif' text-anchor='middle' dy='1em' y='39.166666666666668' font-size='10px'>100%</text></g><g style='text-anchor:end' transform='translate(-6,12.5)'><text font-size='16px' style='font-family:sans-serif'></text></g></g></svg>";
$myfile_over_final = fopen($target_path.DS.$_REQUEST['emp_id']."_".$_REQUEST['pos_id'].'_over_final.svg', "w") or die("Unable to open file!");
fwrite($myfile_over_final, $value_over_final);
fclose($myfile_over_final);
$compactass='';
$compactass.='
<div style="font-family: Helvetica;font-size:12px;line-height: 1.5;color:#000;">
<table cellspacing="0" cellpadding="5" border="0" >
    
	<tr>
		<td width="50%">
			<table cellspacing="0" cellpadding="4" border="0"  >
				<tr>
					<td width="70%" style="font-family: Helvetica;font-size:14px;background-color:#9E768F;">
						<b style="font-size: 5pt;color:#ffffff;">&nbsp;</b>
						<b style="font-family: Helvetica;font-size:14px;color:#ffffff;">5. Consolidated Summary of Results</b>
					</td>
				</tr>
			</table>
			<table cellspacing="0" cellpadding="4" border="0"  >
				<tr>
					<td width="100%" style="font-family: Helvetica;font-size:14px;">
						<b style="font-family: Helvetica;font-size:14px;color:#000;">Leadership Competencies Index</b>
					</td>
				</tr>
				<tr>
					<td style="font-family: Helvetica;font-size:12px;color:#000;">The average Assessed level of the Leadership Competencies is '.$cat_two_final_per.'%</td>
				</tr>
				<tr>
					<td><img src="'.BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['ass_id'].'/'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'_managerial_behavioural.svg" style="width:600px;height:100px;"/></td>
					
				</tr>
				<tr>
					<td style="font-family: Helvetica;font-size:12px;color:#000;">(The average of the assessed score is '.$cat_two_final.'. The assessed score as % is ~ '.$cat_two_final_per.'%) The Leadership Competencies Index of '.trim($emp_info['name']).' is assessed to be <b style="font-family: Helvetica;font-size:16px;">'.$cat_ass_overview_two.'</b></td>
				</tr>
			</table>
			<br><br>
			<table cellspacing="0" cellpadding="4" border="0"  >
				<tr>
					<td width="100%" style="font-family: Helvetica;font-size:14px;">
						<b style="font-family: Helvetica;font-size:14px;color:#000;">Functional/Technical Index</b>
					</td>
				</tr>
				<tr>
					<td style="font-family: Helvetica;font-size:12px;color:#000;">The average Assessed level of the Functional/Technical Competencies is '.$cat_one_final_per.'%</td>
				</tr>
				<tr>
					<td><img src="'.BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['ass_id'].'/'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'_functional_technical.svg" style="width:600px;height:100px;"/></td>
				</tr>
				<tr>
					<td style="font-family: Helvetica;font-size:12px;color:#000;">(The average of the assessed score is '.$cat_one_final.'. The assessed score as % is ~ '.$cat_one_final_per.'%) The Functional/Technical Index of '.trim($emp_info['name']).' is assessed to be <b style="font-family: Helvetica;font-size:16px;">'.$cat_ass_overview.'</b></td>
				</tr>
			</table>
			
		</td>
		<td width="50%">
			<table cellspacing="0" cellpadding="4" border="0"  >
				<tr>
					<td width="100%" style="font-family: Helvetica;font-size:14px;">
						<b style="font-size: 5pt;color:#000;">&nbsp;</b>
						<b style="font-family: Helvetica;font-size:14px;color:#000;">OVERALL INDEX/SCORE</b>
					</td>
				</tr>
			</table>
			<table style="width:100%" align="left" cellspacing="0" border="1px" bordercolor="#8064A2" cellpadding="5" style="font-family: Helvetica; color:#000;font-size:12px;line-height: 1.5; border:0.5px solid #9999;">
				<thead>
					<tr height="30" bgcolor="#8064A2" align="center" class="row header" style="font-size:14px;color:#fff;font-weight:bold">
						<th width="40%">Level</th>
						<th width="60%">Remarks</th>
					</tr>
				</thead>
				<tbody>
					<tr bgcolor="#E6E0EC">
						<td>Assessed Level '.$final_assessed_level.'</td>
						<td>The individual is at '.$final_wei.'% of the required competency level</td>
					</tr>
				</tbody>
			</table>
			<table cellspacing="0" cellpadding="4" border="0"  >
				
				<tr>
					<td style="font-family: Helvetica;font-size:12px;color:#000;">The overall average, across the Functional & Technical, Leadership Competencies is '.$final_wei.'%</td>
				</tr>
				<tr>
					<td><img src="'.BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['ass_id'].'/'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'_over_final.svg" style="width:600px;height:100px;"/></td>
				</tr>
				<tr>
					<td style="font-family: Helvetica;font-size:12px;color:#000;">The Overall Competency score of '.trim($emp_info['name']).' is found to be <b style="font-family: Helvetica;font-size:16px;">'.$overview_final_conmment.'</b></td>
				</tr>
			</table>
		</td>
	</tr>
	
</table></div>
';
$tbl = <<<EOD
$compactass
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');


$pdf->AddPage();
// -- set new background ---
$pdf->SetFooterMargin(0);

// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(true, 25);
// set bacground image
//$img_file = K_PATH_IMAGES.'cms/bar.jpg';
//$pdf->Image($img_file, 0, 0, 8.8, 297, '', '', '', false, 300, '', false, false, 0);
// restore auto-page-break status
//$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();
$inbasket_comments="";
$case_comments="";
$overall_ass='';
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
				$inbasket_comments.=''.trim($ass_ratingcomment['assess_type']).'-'.$result_ss[$key_i]['comments'][$key2].'<br>';
			}
			$i++;
		}
	}
}
$inbasket_rating=UlsAssessmentAssessorRating::get_ass_rating_report($_REQUEST['ass_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id'],'INBASKET');
$inbasket_comments.='<br>';
$inbasket_comments.='<table style="width:100%" align="left" cellspacing="0" border="1px" bordercolor="#8064A2" cellpadding="5" style="font-family: Helvetica; color:#000;font-size:12px;line-height: 1.5; border:0.5px solid #9999;">
	<tr>
		<td width="100%" style="font-family: Helvetica;font-size:12px;">
			<b style="font-family: Helvetica;font-size:12px;color:#00A300;">The overall rating on In-Basket is <span style="font-size: 12px;">'.round($inbasket_rating['ass_rat'],0).'</span></b>
		</td>
	</tr>
</table>';

if(!empty($ass_rating_case_comments)>0){
	$case_comments.=''.$ass_rating_case_comments['comments'].'<br>';
	$case_comments.='<br>';
	/* $case_feed_comments=UlsAssessmentReportBytype::competency_details_methods($_REQUEST['ass_id'],'CASE_STUDY',$_REQUEST['pos_id'],$_REQUEST['emp_id'],$ass_rating_case_comments['assessor_id']);
	foreach($case_feed_comments as $case_feed_comment){
		$case_comments.='<b>'.$case_feed_comment['comp_def_name'].'</b>:'.$case_feed_comment['interview_comments'].'<br>';
	} */
	$case_comments.='<table style="width:100%" align="left" cellspacing="0" border="1px" bordercolor="#8064A2" cellpadding="5" style="font-family: Helvetica; color:#000;font-size:12px;line-height: 1.5; border:0.5px solid #9999;">
		<tr>
			<td width="100%" style="font-family: Helvetica;font-size:12px;">
				<b style="font-family: Helvetica;font-size:12px;color:#00A300;">The overall rating on Case Study is <span style="font-size: 12px;">'.round($ass_rating_case_comments['ass_rat'],0).'</span> </b>
			</td>
		</tr>
	</table>';
	
}
$overall_ass.='
<table cellspacing="0" cellpadding="4" border="0"  >
	<tr>
		<td width="35%" style="font-family: Helvetica;font-size:14px;background-color:#8064A2;">
			<b style="font-size: 5pt;color:#ffffff;">&nbsp;</b>
			<b style="font-family: Helvetica;font-size:14px;color:#ffffff;">Understanding the overall assessment analysis</b>
		</td>
	</tr>
</table>';
$overall_ass.='<div style="font-family: Helvetica;font-size:12px;line-height: 1.5;color:#000;">';
$overall_ass.='<br>Each of the assessment methods, Namely Test, In Basket, Case Study are rated on a scale of 1-4 (1: Poor, 2: Average, 3: Good, 4: Very Good) while 360 degree is rated on a scale of 1-5. All the ratings have been arrived after a detailed analysis and of all the assessment instruments.
<br><br>
<b style="font-size:12px;color:#000;">Assessment Method:  In-basket</b><br>
In the case of in-basket, the rating is based on multiple dimensions of prioritization, quality of action and the time taken. The feedback for you on the in-basket exercise is as follows<br><br>';
$overall_ass.=$inbasket_comments;
$overall_ass.='<br><br>
<b style="font-size:12px;color:#000;">Assessment Method:  Case Study</b><br>
For the Case study, the rating is based on the understanding of the core issues, the approach to the solution and finally the quality of the solution provided. The feedback on the case studies is as follows<br><br>';
$overall_ass.=$case_comments;
$overall_ass.='<br><br>
<b style="font-size:12px;color:#000;">Assessment Method:  360 Deg Feedback</b><br>
Ratings on the 360 Degree feedback are on a scale of 1-5. Annexure 1 provides you with data on how you have rated yourself on each of the statements and the average of the feedback given by all other raters for you on those statements.';
$overall_ass.='</div>';		
$tbl = <<<EOD

$overall_ass
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');


$pdf->AddPage();
// -- set new background ---
$pdf->SetFooterMargin(0);
$pdf->Bookmark('6. Competency Specific Development plans', 0, 0, '', '', array(0,0,0));
$pdf->Bookmark('*&nbsp;&nbsp;Area to Develop', 1, 0, '', '', array(0,0,0));
$pdf->Bookmark('*&nbsp;&nbsp;Development Actions', 1, 0, '', '', array(0,0,0));
$pdf->Bookmark('*&nbsp;&nbsp;Results and Outcomes', 1, 0, '', '', array(0,0,0));
$pdf->Bookmark('*&nbsp;&nbsp;Training Schedule', 1, 0, '', '', array(0,0,0));
$pdf->Bookmark('*&nbsp;&nbsp;Other Development Initiatives', 1, 0, '', '', array(0,0,0));
$index_link = $pdf->AddLink();
$pdf->SetLink($index_link, 0, '*1');
// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(true, 25);
// set bacground image
//$img_file = K_PATH_IMAGES.'cms/bar.jpg';
//$pdf->Image($img_file, 0, 0, 8.8, 297, '', '', '', false, 300, '', false, false, 0);
// restore auto-page-break status
//$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();
$dev_plan='';

$dev_plan.='
<table cellspacing="0" cellpadding="4" border="0"  >
	<tr>
		<td width="35%" style="font-family: Helvetica;font-size:14px;background-color:#9E768F;">
			<b style="font-size: 5pt;color:#ffffff;">&nbsp;</b>
			<b style="font-family: Helvetica;font-size:14px;color:#ffffff;">6. Competency Specific Development plans</b>
		</td>
	</tr>
</table>';
$dev_plan.='<div style="font-family: Helvetica;font-size:12px;line-height: 1.5;color:#000;">';
$dev_plan.='<br>The following are competency specific development inputs given by the assessors.<br>
NOTE: The development map against each of the competencies has been drawn taking into consideration the performance against different assessment methods and the assessor feedback (if any). Please note that in order to facilitate your development, the assessor and the system would ‘err’ in a manner which would enable your growth, and thus these following Training and Development needs are meant to ensure your further improvement. Hence, you may find that at times, although the Assessor(s) have commented that you have adequate knowledge, or skills, or exposure, a Training Program may have been suggested for you, nonetheless.</div>
<br>
<table cellspacing="0" cellpadding="4" border="0"  >
	<tr>
		<td width="100%" style="font-family: Helvetica;font-size:14px;background-color:#8064A2;">
			<b style="font-size: 5pt;color:#ffffff;">&nbsp;</b>
			<b style="font-family: Helvetica;font-size:14px;color:#ffffff;">1. Area to Develop:</b>
		</td>
	</tr>
</table>
<div style="font-family: Helvetica;font-size:12px;line-height: 1.5;color:#000;padding-left:40px;">';
if(!empty($comp_training)){
foreach($comp_training as $comp_trainings){
	$dev_plan.='&bull; '.$comp_trainings.'<br>';
}
}
$dev_plan.='
</div>

<table cellspacing="0" cellpadding="4" border="0"  >
	<tr>
		<td width="100%" style="font-family: Helvetica;font-size:14px;background-color:#8064A2;">
			<b style="font-size: 5pt;color:#ffffff;">&nbsp;</b>
			<b style="font-family: Helvetica;font-size:14px;color:#ffffff;">2. Development Actions:</b>
		</td>
	</tr>
</table>
<table style="width:100%" align="left" cellspacing="0" border="1px" bordercolor="#8064A2" cellpadding="5" style="font-family: Helvetica; color:#000;font-size:12px;line-height: 1.5; border:0.5px solid #9999;">
	
	<tbody>
		<tr bgcolor="#E6E0EC">
			<td>OJT:<br>
			A practical session that allows the employee to observe a demonstration assists the performer, perform in an environment, perform under supervision or perform independently.</td>
			<td>
			<ul>';
			if(!empty($comp_training)){
			foreach($comp_training as $key=>$comptraining){
				$comp_scale_details=UlsAssessmentCompetencies::getassessment_competency_scale($_REQUEST['ass_id'],$_REQUEST['pos_id'],$key);
				$migration_maps=UlsCompetencyDefLevelMigrationMaps::getcompdeflevelmigmap($comp_scale_details['assessment_pos_com_id'],$comp_scale_details['assessment_pos_level_scale_id']);
				if(!empty($migration_maps['comp_def_level_migrate_type'])){
					if($migration_maps['comp_def_level_migrate_type']=='OJT'){
					$dev_plan.='<li>'.$comptraining.'</li>';
					}
				}
			}
			}
			
			$dev_plan.='
			</ul>
			</td>
		</tr>
		<tr bgcolor="#E6E0EC">
			<td>Projects:<br>
			An employee centered learning practice designed to teach concepts using real-world problems and challenge.</td>
			<td>
			<ul>';
			if(!empty($comp_training)){
			foreach($comp_training as $key=>$comptrainings){
				$comp_scale_details=UlsAssessmentCompetencies::getassessment_competency_scale($_REQUEST['ass_id'],$_REQUEST['pos_id'],$key);
				$migration_maps=UlsCompetencyDefLevelMigrationMaps::getcompdeflevelmigmap($comp_scale_details['assessment_pos_com_id'],$comp_scale_details['assessment_pos_level_scale_id']);
				if(!empty($migration_maps['comp_def_level_migrate_type'])){
					if($migration_maps['comp_def_level_migrate_type']=='PROJ'){
					$dev_plan.='<li>'.$comptrainings.'</li>';
					}
				}
			}
			}
			$dev_plan.='
			</ul>
			</td>
		</tr>
	</tbody>
</table>
';		
$tbl = <<<EOD

$dev_plan
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');




$pdf->AddPage();
// -- set new background ---
//$pdf->SetFooterMargin(10);

// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(true, 25);
$pdf->setPageMark();
$devplan='';

$devplan.='
<table cellspacing="0" cellpadding="4" border="0"  >
	<tr>
		<td width="100%" style="font-family: Helvetica;font-size:14px;background-color:#8064A2;">
			<b style="font-size: 5pt;color:#ffffff;">&nbsp;</b>
			<b style="font-family: Helvetica;font-size:14px;color:#ffffff;">3. Results and Outcomes:</b>
		</td>
	</tr>
</table>
<div style="font-family: Helvetica;font-size:12px;line-height: 1.5;color:#000;">
The following are the areas of training suggested for your development. Also given are details of the probable topics to be covered under these training modules. (Please Note that these training modules are only for those areas identified as <i>"Training is Essential"</i> )
</div><br>
<table style="width:100%" align="left" cellspacing="0" border="1px" bordercolor="#8064A2" cellpadding="5" style="font-family: Helvetica; color:#000;font-size:12px;line-height: 1.5; border:0.5px solid #9999;">
	<tr>
		<td width="100%" style="font-family: Helvetica;font-size:12px;">
			<b style="font-family: Helvetica;font-size:12px;color:#00A300;">Suggested Training Module</b>
		</td>
	</tr>
</table>
<ul style="font-family: Helvetica; color:#000;font-size:12px;">';
if(!empty($comp_training)){
foreach($comp_training as $comp_trainings){
	$devplan.='<li>'.$comp_trainings.'</li>';
}
}
$devplan.='
</ul>
<br>
<table style="width:100%" align="left" cellspacing="0" border="1px" bordercolor="#8064A2" cellpadding="5" style="font-family: Helvetica; color:#000;font-size:12px;line-height: 1.5; border:0.5px solid #9999;">
	<tr>
		<td width="100%" style="font-family: Helvetica;font-size:12px;">
			<b style="font-family: Helvetica;font-size:12px;color:#00A300;">Module Elements</b>
		</td>
	</tr>
</table>
<br>
<table style="width:100%" align="left" cellspacing="0" border="0.3px" bordercolor="#8064A2" cellpadding="5" style="font-family: Helvetica; color:#000;font-size:12px;line-height: 1.5; border:0.3px solid #9999;">
	
	<tbody>';
if(!empty($comp_training)){
foreach($comp_training as $key=>$comp_trainings){
	$comp_scale_details=UlsAssessmentCompetencies::getassessment_competency_scale($_REQUEST['ass_id'],$_REQUEST['pos_id'],$key);
	$develop_road=UlsCompetencyDefLevelTraining::getcompdeftraining($comp_scale_details['assessment_pos_com_id'],$comp_scale_details['assessment_pos_level_scale_id']);

	$devplan.='<tr><td><b>'.$comp_trainings.'</b> - '.$develop_road['program_obj'].'</td></tr>';
}
}
$devplan.='</tbody></table>
<br><br><br><table style="width:100%" align="left" cellspacing="0" border="1px" bordercolor="#8064A2" cellpadding="5" style="font-family: Helvetica; color:#000;font-size:12px;line-height: 1.5; border:0.5px solid #9999;">
	<tr>
		<td width="100%" style="font-family: Helvetica;font-size:12px;">
			<b style="font-family: Helvetica;font-size:12px;color:#00A300;">Learning Objectives</b>
		</td>
	</tr>
</table>
<ul style="font-family: Helvetica; color:#000;font-size:12px;">
	<li>Upon completion of training, the learner can demonstrate their understanding of competence by:<br>
		a. Retaking the assessment<br>
		b. On Job Performance
	</li>
</ul>';
$tbl = <<<EOD

$devplan
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');


$pdf->AddPage();
$pdf->footershow=true;
$pdf->SetFooterMargin(0);

$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(true, 25);
//$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();
$devplanmile='';

$devplanmile.='

<table style="width:100%" align="left" cellspacing="0" border="1px" bordercolor="#8064A2" cellpadding="5" style="font-family: Helvetica; color:#000;font-size:12px;line-height: 1.5; border:0.5px solid #9999;">
	
	<tbody>
		<tr>
			<td style="font-family: Helvetica; color:#000;font-size:12px"><b style="font-family: Helvetica; color:#000;font-size:14px;">4. Training Schedule:</b> 
			
			<p>Please enter the dates in consultation with your Manager/HR, by when you plan to complete the following training modules.</p>
			<br>
			<ul>';
			if(!empty($comp_training)){
			foreach($comp_training as $comp_trainings){
				$devplanmile.='<li>'.$comp_trainings.' _____________(DD/MM/YYYY)</li>';
			}
			}
			$devplanmile.='
			</ul>
			</td>
		</tr>
	</tbody>
</table>
<br><br>
<table style="width:100%" align="left" cellspacing="0" border="1px" bordercolor="#8064A2" cellpadding="5" style="font-family: Helvetica; color:#000;font-size:12px;line-height: 1.5; border:0.5px solid #9999;">
	
	<tbody>
		<tr>
			<td style="font-family: Helvetica; color:#000;font-size:12px"><b style="font-family: Helvetica; color:#000;font-size:14px;">5. Other Development Initiatives:</b> 
			
			<p>In Consultation with your Manager/HR indicate Developmental Projects and/or On Job Training, to enhance your Competency in any of the above identified areas.
			<br>
			<br><br><br><br><br><br><br></p>
			</td>
		</tr>
	</tbody>
</table>
<br>
';		
$tbl = <<<EOD

$devplanmile
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

$pdf->AddPage();
$pdf->footershow=true;
$pdf->SetFooterMargin(0);

$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(true, 25);
//$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();
$devplanmiles='';

$devplanmiles.='
<br>
<table style="width:100%" align="left" cellspacing="0" border="1px" bordercolor="#8064A2" cellpadding="5" style="font-family: Helvetica; color:#000;font-size:12px;line-height: 1.5; border:0.5px solid #9999;">
	
	<tbody>
		<tr>
			<td style="font-family: Helvetica; color:#000;font-size:12px">
			I agree to the above plan, and agree to follow through with my development actions and communicate any changes to my manager as appropriate.
			<br><br>
			Employee Signature: ________________________ Date: __________________
			<br><br>
			I agree to the above plan and agree to provide support and resources as the employees develop.
			<br><br>
			Manager: _____________________ Date: ___________________
			</td>
		</tr>
	</tbody>
</table>
';		
$tbl = <<<EOD

$devplanmiles
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

$pdf->AddPage();
$pdf->footershow=true;
// -- set new background ---
$pdf->SetFooterMargin(0);
$pdf->Bookmark('ANNEXURE 1', 0, 0, '', '', array(0,0,0));
// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(true, 25);
// set bacground image
//$img_file = K_PATH_IMAGES.'cms/bar.jpg';
//$pdf->Image($img_file, 0, 0, 8.8, 297, '', '', '', false, 300, '', false, false, 0);
// restore auto-page-break status
//$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();

$tbl = <<<EOD
<div style="height: 350px;bottom:0px;">&nbsp;<br><br><br><br><br><br><br><br><br><br></div>
<div style="color:black;padding-left:500px;font-family: Helvetica;font-size:32px;line-height:1.5;text-align:center;"><b>ANNEXURE 1</b>
</div>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');


$pdf->AddPage();
$pdf->footershow=true;
$pdf->SetFooterMargin(0);

$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(true, 25);
//$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();
/* echo "<pre>";
print_r($kkcomp_name_sub_two); */

$com_desc='';
$com_desc.='
<div style="font-family: Helvetica;font-size:12px;line-height: 1.5;color:#000;">
<table cellspacing="0" cellpadding="4" border="0"  >
	<tr>
		<td width="100%" style="font-family: Helvetica;font-size:14px;background-color:#8064A2;">
			<b style="font-size: 5pt;color:#ffffff;">&nbsp;</b>
			<b style="font-family: Helvetica;font-size:14px;color:#ffffff;">Competency Description</b>
		</td>
	</tr>
</table>
<span  style="font-family: Helvetica; color:#000;font-size:12px;">The following is the detailed profile of the position of '.trim($posdetails['position_name']).' Competencies & Sub Competencies.</span>
<br><br>
<table cellspacing="0" cellpadding="5" border="0" >
    
	<tr>
		<td width="50%">';
			$com_desc.='<table style="width:100%" align="left" cellspacing="0" border="1px" bordercolor="#8064A2" cellpadding="5" style="font-family: Helvetica; color:#000;font-size:12px;line-height: 1.5; border:0.5px solid #9999;">
				<thead>
					<tr height="30" bgcolor="#8064A2" align="center" class="row header" style="font-size:14px;color:#fff;font-weight:bold">
						<th width="10%">S.No</th>
						<th width="65%">Competency/Skill</th>
						<th width="25%">Level Req</th>
					</tr>
					
				</thead>
				<tbody>';
				$h=1;
				$kk=0;
				foreach($kkcomp_name as $key_comp=>$kkcomp_name_sub_twos){
					$scale_name=UlsAssessmentCompetencies::getassessment_competency_scale($_REQUEST['ass_id'],$_REQUEST['pos_id'],$key_comp);
					$bgcolor=($kk%2==0)?"#E6E0EC":"#ffffff";
					$kk++;
					$com_desc.='<tr bgcolor="'.$bgcolor.'">
						<td width="10%">'.$h.'</td>
						<td width="65%">'.$kkcomp_name_sub_twos.'</td>
						<td width="25%">'.$scale_name['scale_name'].'</td>
					</tr>';
					$h++;
				}
				$com_desc.='</tbody>
			</table>
			
			</td>
			<td width="50%">
				
			
			<table style="width:100%" align="left" cellspacing="0" border="1px" bordercolor="#8064A2" cellpadding="5" style="font-family: Helvetica; color:#000;font-size:12px;line-height: 1.5; border:0.5px solid #9999;">
				<thead>
					<tr height="30" bgcolor="#8064A2" align="center" class="row header" style="font-size:14px;color:#fff;font-weight:bold">
						<th width="10%">S.No</th>
						<th width="65%">Competency/Skill</th>
						<th width="25%">Level Req</th>
					</tr>
					
				</thead>
				<tbody>';
				$h=1;
				$kk=0;
				foreach($kkcomp_name_sub_comp as $keycompc=>$kkcomp_name_sub_comps){
					$scale_name=UlsAssessmentCompetencies::getassessment_competency_scale($_REQUEST['ass_id'],$_REQUEST['pos_id'],$keycompc);
					$bgcolor=($kk%2==0)?"#E6E0EC":"#ffffff";
					$kk++;
					$com_desc.='<tr bgcolor="'.$bgcolor.'">
						<td width="10%">'.$h.'</td>
						<td width="65%">'.$kkcomp_name_sub_comps.'</td>
						<td width="25%">'.$scale_name['scale_name'].'</td>
					</tr>';
					$h++;
				}
				$com_desc.='</tbody>
			</table>
			</td>
	</tr>
	
</table></div>
';
$tbl = <<<EOD
$com_desc
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

$pdf->AddPage();
// -- set new background ---
//$pdf->SetFooterMargin(10);

// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(true, 25);
// set bacground image
//$img_file = K_PATH_IMAGES.'cms/bar.jpg';
//$pdf->Image($img_file, 0, 0, 8.8, 297, '', '', '', false, 300, '', false, false, 0);
// restore auto-page-break status
//$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();
$para41='<div style="font-family: Helvetica;font-size:12px;line-height: 1.5;color:#000000;">
360 Degree feedback, also known as multi rater feedback is a process where in an individual receives feedback on a set of competencies, from multiple sources /groups of people with whom one interacted in the course of discharging his/her job responsibilities. 
The feedback report highlights differences between the individual’s self-perception and the feedback from others.  Critical areas for self-development are highlighted. The report becomes a critical piece for professional development planning.
<br><br>
<b>How to use the report:</b> The report covers a detailed analysis of the feedback received on each of the competencies. This will help you to understand your own perceptions and that of the others perception vis-à-vis the competencies. It provides information on rating on each of the elements, of the competencies –your self-rating and the average of all others who have rated you, which includes Manager, Subordinates, Peers and Customers (where applicable)<br><br>
<b>360 degree is rated on a scale of 1-5(1 - Strongly Agree, 2 - Agree, 3 - Neither agree nor disagree, 4 - Disagee, 5 - Strongly Disagree)</b>

<br>';
$sqlself ="select AVG( a.rater_value) AS average,a.element_competency_id FROM uls_feedback_employee_rating a
left join(SELECT `feed_assess_test_id`,`assess_test_id`,`position_id`,`assessment_id`,`ques_id` FROM `uls_assessment_test_feedback`) b on a.ass_test_id=b.assess_test_id and a.ques_id=b.ques_id and a.assessment_id=b.assessment_id
where a.employee_id='".$_REQUEST['emp_id']."' and a.giver_id='".$_REQUEST['emp_id']."' and a.rater_value<>0 and a.assessment_id='".$_REQUEST['ass_id']."' GROUP BY a.element_competency_id";	
$q=UlsMenu::callpdo($sqlself);
$Series2=array();
$parameter=array();
foreach($q as $r){
	$prs=$r['element_competency_id'];
	$Series2[$prs]= round($r['average'],2);
}

/* <br><br><table cellspacing="0" cellpadding="0" border="0" >
    <tr>
        <td  width="54%" ></td>
        <td  width="3%"  bgcolor="#0098DB" ></td>
        <td  width="20%"  style="color:#646464;">&nbsp;Self Average</td>
        <td  width="3%" bgcolor="#FCB614"></td>
        <td  width="20%"  style="color:#646464;">&nbsp;Others Average</td>
    </tr>
</table>
$catquery="SELECT * FROM `uls_category` WHERE `category_id` in (SELECT DISTINCT(`comp_def_category`) FROM `uls_competency_definition` WHERE 1 and `comp_def_id` in (SELECT DISTINCT(`element_competency_id`) FROM `uls_feedback_employee_rating` WHERE employee_id='".$_REQUEST['emp_id']."' and rater_value<>0 and assessment_id='".$_REQUEST['ass_id']."' ORDER BY `uls_feedback_employee_rating`.`element_competency_id` ASC ) ORDER BY `uls_competency_definition`.`comp_def_category` ASC )";
$catresults=UlsMenu::callpdo($catquery);
foreach($catresults as $cate){ 
$para41.="
<br><br><span align='left' style='font-family: Helvetica;font-size: 20px;color:#36a2eb; line-height:1.5;'><b>".$cate['name']."</b></span><br><br>";	
$para41.='<table style="width:100%" align="left" cellspacing="0" border="1px" bordercolor="#8064A2" cellpadding="5" style="font-family: Helvetica; color:#000;font-size:12px;line-height: 1.5; border:0.5px solid #9999;">
	<thead><tr height="30" bgcolor="#8064A2" align="center" class="row header" style="font-size:14px;color:#fff;font-weight:bold">
			<th width="76%">Competency</th>
			<th width="24%">Rating : Self Vs Others</th>
		</tr>
	</thead>
	<tbody>';
	$sql12 ="select AVG( a.rater_value) AS average,a.element_competency_id,d.comp_def_name FROM uls_feedback_employee_rating a
	left join(SELECT `feed_assess_test_id`,`assess_test_id`,`position_id`,`assessment_id`,`ques_id` FROM `uls_assessment_test_feedback`) b on a.ass_test_id=b.assess_test_id and a.ques_id=b.ques_id and a.assessment_id=b.assessment_id
	left join(SELECT `ques_comp_id`,`ques_id`,`ques_competency_id`,`ques_level_scale_id` FROM `uls_questionnaire_competency`) c on c.ques_competency_id=a.element_competency_id and a.ques_id=c.ques_id
	left join(SELECT `comp_def_id`,`comp_def_name`,comp_def_category FROM `uls_competency_definition`) d on d.comp_def_id=c.ques_competency_id
	where a.employee_id=".$_REQUEST['emp_id']." and a.giver_id!=".$_REQUEST['emp_id']." and a.rater_value<>0 and a.assessment_id=".$_REQUEST['ass_id']." and d.comp_def_category='".$cate['category_id']."' GROUP BY a.element_competency_id";
	$q=UlsMenu::callpdo($sql12);
	$Series1=array();
	$parameter=array();
	$kk=0;
	foreach($q as $r){
		$bgcolor=($kk%2==0)?"#E6E0EC":"#ffffff";
		$kk++;
		$pr=$r['element_competency_id'];
		$Series1[$pr]= round($r['average'],2);
		$parameter[]=$r['comp_def_name'];
		$wid=$Series2[$pr];
		$wid1=$Series1[$pr];
		$heit=26;
		$withh=50;
		$k_path=svgbarr($wid,$wid1,$r['element_competency_id'],$_REQUEST['ass_id'],$_REQUEST['emp_id'],$_REQUEST['pos_id'],$heit);
		$bar2 = BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['ass_id'].'/bar_'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'_'.$r['element_competency_id'].'.svg';
		$para41.='<tr bgcolor="'.$bgcolor.'">
			<td style="width:'.$withh.'%">'.ucwords(strtolower($r['comp_def_name'])).'</td>
			<td style="width:'.$withh.'%"><img src="'.$bar2.'" width="350" ></td>
		</tr>';
	}
	
	$para41.='</tbody>
</table><br>';*/


$para41.='<br><table style="width:100%" align="left" cellspacing="0" border="1px" bordercolor="#8064A2" cellpadding="5" style="font-family: Helvetica; color:#000;font-size:12px;line-height: 1.5; border:0.5px solid #9999;">
	<thead><tr height="30" bgcolor="#8064A2" align="center" class="row header" style="font-size:14px;color:#fff;font-weight:bold">
			<th width="30%">Competency</th>
			<th width="50%">Elements</th>
			<th width="9%">Self Rating</th>
			<th width="11%">Others Rating</th>
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
	//and d.comp_def_category='".$cate['category_id']."'
	$sql13 ="select AVG( a.rater_value) AS average,a.element_competency_id,d.comp_def_name,e.element_id_edit,a.ques_element_id FROM uls_feedback_employee_rating a
	left join(SELECT `feed_assess_test_id`,`assess_test_id`,`position_id`,`assessment_id`,`ques_id` FROM `uls_assessment_test_feedback`) b on a.ass_test_id=b.assess_test_id and a.ques_id=b.ques_id and a.assessment_id=b.assessment_id
	left join(SELECT `ques_comp_id`,`ques_id`,`ques_competency_id`,`ques_level_scale_id` FROM `uls_questionnaire_competency`) c on c.ques_competency_id=a.element_competency_id and a.ques_id=c.ques_id
	left join(SELECT `ques_element_id`,`ques_id`,`element_id`,`element_competency_id`,`element_id_edit` FROM `uls_questionnaire_competency_element`) e on e.ques_id=a.ques_id and c.ques_competency_id=e.element_competency_id and e.ques_element_id=a.ques_element_id
	left join(SELECT `comp_def_id`,`comp_def_name`,comp_def_category FROM `uls_competency_definition`) d on d.comp_def_id=c.ques_competency_id
	where a.employee_id=".$_REQUEST['emp_id']." and a.giver_id!=".$_REQUEST['emp_id']." and a.rater_value<>0 and a.assessment_id=".$_REQUEST['ass_id']."  GROUP BY a.ques_element_id order by c.ques_competency_id ASC";
	$qq=UlsMenu::callpdo($sql13);
	$kkk=0;
	$Series_others=array();
	$temp="";
	foreach($qq as $rn){
		$bgcolor=($kkk%2==0)?"#E6E0EC":"#ffffff";
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
			<td style="width:50%">'.$rn['element_id_edit'].'</td>
			<td style="width:9%" align="center">'.$Series_self[$pr].'</td>
			<td style="width:11%" align="center">'.$Series_others[$pr].'</td>
		</tr>';
	}
	$para41.='</tbody>
</table>';


/* } */
$diffb=-0.5;
$diffd=0.5;

	
	
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
	//print_r("<br>".$rn_spot['element_id_edit']."-".$diff_spot."-".$diffb."-".$diffd."<br>");
	if($diff_spot <= $diffb){
		$bright_spot.=$b.". ".$rn_spot['element_id_edit']."<br>";
		$b++;
	}
	if($diff_spot >= $diffd){
		$dark_spot.=$d.". ".$rn_spot['element_id_edit']."<br>";
		$d++;
	}
}
//exit();
/* <br>
$para41_spot */
$para41.='</div>';	
$tbl = <<<EOD
<table cellspacing="0" cellpadding="4" border="0"  >
	<tr>
		<td width="30%" style="font-family: Helvetica;font-size:14px;background-color:#8064A2;">
			<b style="font-size: 5pt;color:#ffffff;">&nbsp;</b>
			<b style="font-family: Helvetica;font-size:14px;color:#ffffff;">Annexure 1: 360-degree FEEDBACK</b>
		</td>
	</tr>
</table>

$para41


EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');


$pdf->AddPage();
// -- set new background ---
//$pdf->SetFooterMargin(10);
// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(true, 25);
// set bacground image
//$img_file = K_PATH_IMAGES.'cms/bar.jpg';
//$pdf->Image($img_file, 0, 0, 8.8, 297, '', '', '', false, 300, '', false, false, 0);
// restore auto-page-break status
//$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();
$dark_spot=!empty($dark_spot)?$dark_spot:"<b style='color:red;'>No Blind Spots</b>";
$bright_spot=!empty($bright_spot)?$bright_spot:"<b style='color:red;'>No Bright Spots</b>";
$tbl = <<<EOD

<table style="width:100%" align="left" style="" cellspacing="0" cellpadding="5" >
	<tr style="color:#000000;text-align:justify;font-family: Helvetica;font-size: 12px;">
		<td colspan="4">
			<br><span style="font-size: 12pt;color:#435094;font-family: Helvetica;">BRIGHT SPOTS</span><br><br>
			Our perception of self could be vastly different from what others see or think about us. Sometimes there could be a negative skew meaning that we may not see ourselves as having the required skills or capabilities in a given area. Whereas, others would think that we possess (either based on interaction with us or because of our demonstration) the required competency. Such areas are called <b>BRIGHT SPOTS</b> and for you the following are the Bright Spots.<br>
			$bright_spot
			<br><span style="font-size: 12pt;color:#435094;font-family: Helvetica;">BLIND SPOTS</span><br><br>
			Our perception of self could be many a time different from what others see or think about us. Sometimes there could be a positive skew meaning that we may see ourselves as having the required skills or capabilities in a given area. Whereas, others would think that we do not posses (either based on interaction with us or because of our demonstration) the required competency. Such areas are called <b>BLIND SPOTS</b> and for you the following are the Blind Spots
			<br>
			$dark_spot
			
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
foreach($otheravg as $otheravgs){
	$key=$otheravgs['element_competency_id'];
	$otheravg_rating[$key]=$otheravgs['average'];
	if(strlen($otheravgs['comp_def_name'])<=50){
		$parameter[]=substr($otheravgs['comp_def_name'],0, 50);}
	else{ 
		$parameter[]=substr($otheravgs['comp_def_name'],0, 50).'...';
	}
}

$settings_gh= array(
	'back_colour'       => '#fff',    		'stroke_colour'      => '#666',
	'back_stroke_width' => 0,         		'back_stroke_colour' => '#fff',
	'axis_colour'       => '#666',    		'axis_overlap'       => 2,
	'axis_font'         => 'Georgia', 		'axis_font_size'     => 10,
	'grid_colour'       => '#c1c1c1',    	'label_colour'       => '#666',
	'link_base'         => '/',       		'link_target'        => '_top',
	'fill_under'        	=> false,		'reverse'			=> true, 'start_angle' => 90,
	'legend_stroke_width'	=> 1,			'legend_shadow_opacity' => 0,'legend_stroke_colour'	=> '#aaa',
	'legend_title' => "",					'legend_columns' => 4,'legend_colour' => "#aaa",
	'legend_text_side' => "right",			'legend_position'		=> "outer top right",'marker_opacity'=>0.5,
	'grid_straight' => true,
	'grid_back_stripe'		=> false,
	'axis_stroke_width'=>0,
	'grid_subdivision_dash' => "1", 'line_stroke_width'		=>1, 'guideline_opacity'=>0.5,
	'marker_size'       	=> 5,			'axis_max_v'  => 5 ,'minimum_subdivision' =>5,'grid_division_v' =>2.5,
);
$coloursscg = array( '#0098DB','#FCB614', '#191970','#800000');
$settings_gh['graph_title_position'] = "top";
$settings_gh['graph_title_font_weight'] = "bold";
$settings_gh['legend_entries'] = array('Self','Others');
$val_g=array(); 

/* $par_g=array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
$sd_g=array();
for($i=0;$i<count($parameter); $i++){
	$sd_g[]=$par_g[$i];			 
} */
$val_g[]=array_combine($parameter,$selfavg_rating);
$val_g[]=array_combine($parameter,$otheravg_rating);

$radar_add=Array();		
$radar_add[]=1;
/* echo "<pre>";
print_r($val_g); */
$values_g = $val_g; 
$radar_name = '360degree_radar_'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'.svg';
$settings_gh['graph_title'] = 'SELF VS OTHERS';

$graph_g = new SVGGraph(900, 500, $settings_gh);

$graph_g->Values($values_g);
$value11_g=$graph_g->Fetch('MultiRadarGraph', false);//$graph->Fetch('MultiRadarGraph', false);

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
fwrite($myfile, $value11_g);
fclose($myfile);

$svg_radar= BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['ass_id'].'/360degree_radar_'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'.svg';
$para16h='
<table cellspacing="0" cellpadding="4" border="0"  >
	<tr>
		<td width="35%" style="font-family: Helvetica;font-size:14px;background-color:#8064A2;">
			<b style="font-size: 5pt;color:#ffffff;">&nbsp;</b>
			<b style="font-family: Helvetica;font-size:14px;color:#ffffff;">360 Degree Radar Graph of Self vs Others  </b>
		</td>
	</tr>
</table>

	<table cellspacing="0" cellpadding="4" border="0" >
		<tr>
			<td style="width:100%" align="center"><img src="'.$svg_radar.'" width="800px" height="500px"/></td>
		</tr>
	</table>
	
	<span style="font-family: Helvetica;font-size: 8px;">Others= Average Score Given by Others</span>

';
$pdf->AddPage();
$pdf->footershow=true;
$pdf->SetFooterMargin(0);
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(true, 25);
//$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();

$para16h.='';
$tbl = <<<EOD
$para16h
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
		
$pec_bench=UlsAssessmentTest::get_ass_position($_REQUEST['ass_id'],$_REQUEST['pos_id'],'BEHAVORIAL_INSTRUMENT');
$instrument=UlsAssessmentTestBehavorialInst::get_behavorial_assessment_report($testtypes_bh['assess_test_id']);
$powercluster=$planningcluster=$achievementcluster=0;
foreach($instrument as $instruments){
	$inst=UlsBeiAttemptsAssessment::get_attempt_valus_beh($_REQUEST['ass_id'],$_REQUEST['emp_id'],$instruments['assess_test_id']);
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
	$powercluster=(($Persuasion+$Self_Confidence)/2);
	$planningcluster=(($GoalSetting+$Information+$Systematic)/3);
	$achievementcluster=(($Opportunity_Seeking+$Persistence+$Commitment+$RiskTaking+$Demand)/5);
	$power_cluster=round((($Persuasion+$Self_Confidence)/50)*100,2);
	$planning_cluster=round((($GoalSetting+$Information+$Systematic)/75)*100,2);
	$achievement_cluster=round((($Opportunity_Seeking+$Persistence+$Commitment+$RiskTaking+$Demand)/125)*100,2);
	require_once(LIB_PATH.DS.DS.'graph'.DS.'includes'.DS.'SVGGraph.php');
	$setting_pec = array(
	  'auto_fit' => true,
	  'back_colour' => '#eee',
	  'back_stroke_width' => 0,
	  'back_stroke_colour' => '#eee',
	  'stroke_colour' => '#000',
	  'axis_colour' => '#333',
	  'axis_overlap' => 2,
	  'grid_colour' => '#666',
	  'label_colour' => '#000',
	  'axis_font' => 'Arial',
	  'axis_font_size' => 10,
	  'pad_right' => 20,
	  'pad_left' => 20,
	  'link_base' => '/',
	  'link_target' => '_top',
	  'show_subdivisions' => true,
	  'show_grid_subdivisions' => true,
	  'grid_subdivision_colour' => '#fff',
	  'bar_width'=>20,
	  'bar_space'=>5,
	  'bar_width_min'=>10,
	  'show_bar_labels'=>true,
	  'bar_label_colour'=>'#fff'
	);
	
	$val=array();
	$values_pec = array("Power Cluster"=>$power_cluster,"Planning Cluster"=>$planning_cluster,"Achievement Cluster"=>$achievement_cluster);
	//print_r($values_pec);
	$colours = array('#8064A2');
	$graph = new SVGGraph(400, 300, $setting_pec);
	$graph->colours = $colours;
	$graph->Values($values_pec);
	$value_pec=$graph->Fetch('HorizontalBarGraph', false);//$graph->Fetch('MultiRadarGraph', false);
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
	
	$myfile_pec = fopen($target_path.DS.$_REQUEST['emp_id']."_".$_REQUEST['pos_id'].'_pec_graph.svg', "w") or die("Unable to open file!");
	//$target_path='public'.DS.'feedback'.DS.$feedid.DS.$name.'.svg';
	//$myfile = fopen($target_path, "w") or die("Unable to open file!");
	fwrite($myfile_pec, $value_pec);
	fclose($myfile_pec);
	
}		
$para17h='';
$pdf->AddPage();
		
		$bMargin = $pdf->getBreakMargin();
		$auto_page_break = $pdf->getAutoPageBreak();
		$pdf->SetFooterMargin(0);
		$pdf->SetAutoPageBreak(true, 20);
		//$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
		$pdf->setPageMark();
		
		$para17h.='
		<table cellspacing="0" cellpadding="4" border="0"  >
			<tr>
				<td width="45%" style="font-family: Helvetica;font-size:14px;background-color:#8064A2;">
					<b style="font-size: 5pt;color:#ffffff;">&nbsp;</b>
					<b style="font-family: Helvetica;font-size:14px;color:#ffffff;">Annexure 1:  Personal Entrepreneurial Competencies (PEC)</b>
				</td>
			</tr>
		</table>
		
		<div style="font-family: Helvetica;font-size:12px;line-height: 1.5;color:#000000;"><br>
		The following is the score that you have given yourself for the various elements/aspects of the PEC instrument.  The definition of the various clusters is given below and the interpretation of your score is given in the main part of the report
		<br>
		<br>
		<table style="width:100%" align="left" cellspacing="0" border="1px" bordercolor="#8064A2" cellpadding="5" style="font-family: Helvetica; color:#000;font-size:12px;line-height: 1.5; border:0.5px solid #9999;">
		<thead>
			<tr height="30" bgcolor="#a794bf" align="center" class="row header" style="font-size:14px;color:#fff;font-weight:bold">
				<th width="100%" colspan="2"><b>PEC Profile</b></th>
			</tr>
			<tr height="30" bgcolor="#8064A2" align="center" class="row header" style="font-size:14px;color:#fff;font-weight:bold">
				<th width="60%">Competency Name</th>
				<th width="40%">Final Score</th>
			</tr>
		</thead>
		<tbody>
			<tr bgcolor="#E6E0EC">
				<td width="60%">Opportunity Seeking</td>
				<td width="40%">'.($Opportunity_Seeking-$factor).'</td>
			</tr>
			<tr bgcolor="#ffffff">
				<td width="60%">Persistence</td>
				<td width="40%">'.($Persistence-$factor).'</td>
			</tr>
			<tr bgcolor="#E6E0EC">
				<td width="60%">Commitment to Work Contract</td>
				<td width="40%">'.($Commitment-$factor).'</td>
			</tr>
			<tr bgcolor="#ffffff">
				<td width="60%">Demand for Efficiency and Quality</td>
				<td width="40%">'.($Demand-$factor).'</td>
			</tr>
			<tr bgcolor="#E6E0EC">
				<td width="60%">Risk Taking</td>
				<td width="40%">'.($RiskTaking-$factor).'</td>
			</tr>
			<tr bgcolor="#ffffff">
				<td width="60%">Goal Setting</td>
				<td width="40%">'.($GoalSetting-$factor).'</td>
			</tr>
			<tr bgcolor="#E6E0EC">
				<td width="60%">Information Seeking</td>
				<td width="40%">'.($Information-$factor).'</td>
			</tr>
			<tr bgcolor="#ffffff">
				<td width="60%">Systematic Planning and monitoring</td>
				<td width="40%">'.($Systematic-$factor).'</td>
			</tr>
			<tr bgcolor="#E6E0EC">
				<td width="60%">Persuasion and Networking</td>
				<td width="40%">'.($Persuasion-$factor).'</td>
			</tr>
			<tr bgcolor="#ffffff">
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

$para18h='';
$pdf->AddPage();
		
		$bMargin = $pdf->getBreakMargin();
		$auto_page_break = $pdf->getAutoPageBreak();
		$pdf->SetFooterMargin(0);
		$pdf->SetAutoPageBreak(true, 20);
		//$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
		$pdf->setPageMark();
		
		$para18h.='
		<div style="font-family: Helvetica;font-size:12px;line-height: 1.5;color:#000000;">
		<p>The PEC maps the individual along three main clusters, </p>
		<p><b>Achievement Cluster:</b>  This cluster maps the individual with respect to his/her achievement orientation </p>
		<ul style="font-family: Helvetica;font-size:12px;line-height: 1.5;color:#000000;">
<li><b>Opportunity seeking – </b>Entrepreneurs have a good eye for spotting business  opportunities and acts on these opportunities appropriately. </li>
<li><b>Persistence - </b>Entrepreneurs do not easily give up in the face of obstacles. They will  take repeated or different actions to overcome the hurdles of business. This includes making a personal sacrifice or extraordinary effort to complete a job.</li>
<li><b>Commitment to work contract - </b>Entrepreneurs do their best to satisfy customers and to deliver what is promised. They accept full responsibility for problems when completing a job for customers.</li>
<li><b>Risk-taking - </b>Entrepreneurs are known for taking calculated risks and doing tasks that  are moderately challenging.</li>
<li><b>Demand for efficiency and quality - </b>Entrepreneurs see to it that the business meets or exceeds existing standards of excellence and exerts efforts to improve past  performance and do things better. They set high but realistic standards.</li>
</ul>

<p><b>Planning Cluster:</b>  This cluster indicates the planning and associated capabilities of the individual</p> 
<ul style="font-family: Helvetica;font-size:12px;line-height: 1.5;color:#000000;">
<li><b>Goal setting - </b>Entrepreneurs knows how to set specific, measurable, attainable, realistic, and time-bound (SMART) goals. It is easy for them to divide large goals into short-term goals.</li>
<li><b>Information seeking - </b>Entrepreneurs update themselves with new information about her customers, the market, suppliers, and competitors. This is rooted to their innate sense of curiosity. </li>
<li><b>Systematic planning and monitoring - </b>Entrepreneurs develop and use logical, step[1]by-step plans to reach their goals. They monitor progress towards goals and to alter strategies when necessary.</li>
</ul>

<p><b>Power Cluster:</b>  This cluster can be used to gauge the personality which the individual demonstrates in achieving his/her goals</p>
<ul style="font-family: Helvetica;font-size:12px;line-height: 1.5;color:#000000;">
<li><b>Persuasion and networking - </b>Entrepreneurs know how to use the right strategies to influence or persuade other people. They have naturally established a network of people who they can turn to in order to achieve their objectives. </li>
<li><b>Self-confidence -</b> Entrepreneurs have a strong belief in themselves and their own abilities. They have self-awareness and belief in their own ability to complete a difficult task or meet a challenge.</li>
</ul>		
<br>
<table width="100%" align="left">
	<tbody width="100%">
		<tr width="100%">
			<td width="100%" align="left"><img src="'.BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['ass_id'].'/'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'_pec_graph.svg" style="width:600px;padding-top:10px;height:400px;"/></td>
		</tr>
	</tbody>
</table>

</div>';
$tbl = <<<EOD
$para18h
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
	

$pdf->AddPage();
$pdf->footershow=true;
// -- set new background ---
$pdf->SetFooterMargin(0);
$pdf->Bookmark('ANNEXURE 2', 0, 0, '', '', array(0,0,0));
// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(true, 25);
// set bacground image
//$img_file = K_PATH_IMAGES.'cms/bar.jpg';
//$pdf->Image($img_file, 0, 0, 8.8, 297, '', '', '', false, 300, '', false, false, 0);
// restore auto-page-break status
//$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();

$tbl = <<<EOD
<div style="height: 350px;bottom:0px;">&nbsp;<br><br><br><br><br><br><br><br><br><br></div>
<div style="color:black;padding-left:500px;font-family: Helvetica;font-size:32px;line-height:1.5;text-align:center;"><b>ANNEXURE 2</b>
</div>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

foreach($results_comp as $resultscomps){
	$comp_analysis='';
$pdf->AddPage();

// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetFooterMargin(0);
$pdf->SetAutoPageBreak(true, 10);
// set bacground image
//$img_file = K_PATH_IMAGES.'cms/bar.jpg';
//$pdf->Image($img_file, 0, 0, 8.8, 297, '', '', '', false, 300, '', false, false, 0);
// restore auto-page-break status
//$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();

	$comp_id=$resultscomps['comp_id'];
	$cat_sub_type=$resultscomps['cat_id'];
	
	$method=array();
	$me_sum=0;
	foreach($allcomp_score_a[$comp_id] as $key=>$method_val){
		$method[]=$allweights[$key];
	}
	foreach($allcomp_score_a[$comp_id] as $key=>$method_val){
		$me_sum+=($allweights[$key]/array_sum($method))*$method_val['score'];
	}
	$final_val=round($me_sum,2);
	$assval_comp=round(($resultscomps['req_level']*$final_val)/100,2);
	$final_val_one=$final_val;
	$final_val_two=100-$final_val;
	$overrate=$final_comm='';
	if($final_val>=0 && $final_val<=40){
		$final_comm=''.trim($emp_info['name']).' has Poor Knowledge on '.$resultscomps['comp_name'].'';
		$overrate='<img src="'.BASE_URL.'/public/reports/Poor.png" style="text-align:center">';
	}
	if($final_val>40 && $final_val<=60){
		$final_comm=''.trim($emp_info['name']).' has Average Knowledge on '.$resultscomps['comp_name'].'';
		$overrate='<img src="'.BASE_URL.'/public/reports/Average.png" style="text-align:center">';
	}
	if($final_val>60 && $final_val<=80){
		$final_comm=''.trim($emp_info['name']).' has Good Knowledge on '.$resultscomps['comp_name'].'';
		$overrate='<img src="'.BASE_URL.'/public/reports/Good.png" style="text-align:center">';
	}
	if($final_val>80 && $final_val<=100){
		$final_comm=''.trim($emp_info['name']).' has Very Good Knowledge on '.$resultscomps['comp_name'].'';
		$overrate='<img src="'.BASE_URL.'/public/reports/Verygood.png" style="text-align:center">';
	}
	require_once(LIB_PATH.DS.DS.'graph'.DS.'includes'.DS.'SVGGraph.php');
	$setting_comp = [
	  'back_colour' => '#fff',
	  'back_stroke_width' => 0,
	  'back_stroke_colour' => '#eee',
	  'stroke_colour' => '#fff',
	  'label_colour' => '#000',
	  'pad_right' => 20,
	  'pad_left' => 20,
	  'sort' => false,
	  'show_labels' => false,
	  'label_font' => 'Helvetica',
	  'label_font_size' => '26',
	  'units_before_label' => '$',
	  'inner_text' => $final_val_one."%",
	];
	$width = 250;
	$height = 100;
	$values = [$final_val_one,$final_val_two];
	$colours = ['#8064A2','#a794bf']; 
	$graph = new SVGGraph(500, 300, $setting_comp);
	$graph->colours = $colours;
	$graph->Values($values);
	$value11=$graph->Fetch('DonutGraph', false);//$graph->Fetch('MultiRadarGraph', false);
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

	$myfile = fopen($target_path.DS.$_REQUEST['emp_id']."_".$_REQUEST['pos_id'].'_'.$comp_id.'_graph.svg', "w") or die("Unable to open file!");
	fwrite($myfile, $value11);
	fclose($myfile);
	
	$comp_analysis.='<div style="font-family: Helvetica;font-size:12px;line-height: 1.5;color:#000;">
	<table cellspacing="0" cellpadding="5" border="0" >
		
		<tr>
			<td width="50%">
				<table cellspacing="0" cellpadding="4" border="0"  >
					<tr>
						<td width="100%" style="font-family: Helvetica;font-size:14px;background-color:#8064A2;">
							<b style="font-family: Helvetica;font-size:14px;color:#ffffff;">Competency Assessed and Analysed<br>
							<i>'.$resultscomps['comp_name'].'</i><br>
							<i>Assessed Level - '.$assval_comp.'</i>
							</b>
						</td>
					</tr>
				</table>
				<table cellspacing="0" cellpadding="4" border="0" style="background-color:#E6E0EC;" >
					<tr>
						<td width="100%" height="180">
						<img src="'.BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['ass_id'].'/'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'_'.$comp_id.'_assessement_method_bargraph.svg" style="width:600px;height:250px;"/>
						</td>
					</tr>
				</table>
				<table cellspacing="0" cellpadding="4" border="0" style="background-color:#9E768F;" >
					<tr>
						<td width="100%" >
						<b style="font-family: Helvetica;font-size:14px;color:#ffffff;">Assessment Methodologies used:</b>
						</td>
					</tr>
				</table>';
				$comp_analysis.='<table  cellspacing="0" cellpadding="4" border="0" style="background-color:#9E768F;" ><tr>';
				$i=0;
				foreach($testtypes_new as $testtypes_news){
					
					$ass_type_data=UlsAssessmentReportBytype::report_assessment_type_count($_REQUEST['ass_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id'],$comp_id,$testtypes_news['assessment_type']);
					if(!empty($ass_type_data['ass_count'])){
						if($ass_type_data['ass_count']>=1){
							$check_image='<img src="'.BASE_URL.'/public/reports/Selection.png">';
						}
						else{
							if($testtypes_news['assessment_type']=='FEEDBACK'){
								$get_dat_feeds=UlsMenu::callpdorow("SELECT a.* FROM `uls_feedback_employee_rating` a
								left join(SELECT `comp_def_id`,`comp_def_name`,`comp_def_category` FROM `uls_competency_definition`) ct on ct.comp_def_id=a.element_competency_id
								WHERE a.`assessment_id`='".$_REQUEST['ass_id']."' and a.`employee_id`='".$_REQUEST['emp_id']."' and a.`element_competency_id`=".$comp_id." and a.`rater_value` is not null and a.`rater_value`!=0 group by a.`element_competency_id`");
								if(!empty($get_dat_feeds)){
									$check_image='<img src="'.BASE_URL.'/public/reports/Selection.png">';
								}
								else{
									$check_image='';
								}
							}
							else{
								$check_image='';
							}
							
						}
					}
					else{
						if($testtypes_news['assessment_type']=='FEEDBACK'){
							$get_dat_feeds=UlsMenu::callpdorow("SELECT a.* FROM `uls_feedback_employee_rating` a
							left join(SELECT `comp_def_id`,`comp_def_name`,`comp_def_category` FROM `uls_competency_definition`) ct on ct.comp_def_id=a.element_competency_id
							WHERE a.`assessment_id`='".$_REQUEST['ass_id']."' and a.`employee_id`='".$_REQUEST['emp_id']."' and a.`element_competency_id`=".$comp_id." and a.`rater_value` is not null and a.`rater_value`!=0 group by a.`element_competency_id`");
							if(!empty($get_dat_feeds)){
								$check_image='<img src="'.BASE_URL.'/public/reports/Selection.png">';
							}
							else{
								$check_image='';
							}
						}
						else{
							$check_image='';
						}
					}
					if($i%2==0 && $i!=0)
					{
					 $comp_analysis.='</tr><tr><td width="25%"><img src="'.BASE_URL.'/public/reports/'.$testtypes_news['assessment_type'].'.png"></td><td width="25%">'.$check_image.'</td>';
					}
				   else
					$comp_analysis.='<td width="25%"><img src="'.BASE_URL.'/public/reports/'.$testtypes_news['assessment_type'].'.png"></td><td width="25%">'.$check_image.'</td>';
				  $i++;
				}
				$comp_analysis.='</tr></table>
				<br><br>
				<table style="width:100%" align="left" cellspacing="0" border="1px" bordercolor="#8064A2" cellpadding="5" style="font-family: Helvetica; color:#000;font-size:12px;line-height: 1.5; border:0.5px solid #9999;">
					<tr>
						<td width="100%" style="font-family: Helvetica;font-size:12px;">
							<b style="font-family: Helvetica;font-size:12px;color:#00A300;">'.$final_comm.'</b>
						</td>
					</tr>
				</table>
				<table cellspacing="0" cellpadding="4" border="0"  >
					<tr>
						<td width="100%" style="font-family: Helvetica;font-size:14px;background-color:#8064A2;">
							<b style="font-family: Helvetica;font-size:14px;color:#ffffff;">Analysis of the Competency Elements</b>
						</td>
					</tr>
				</table>
			</td>
			<td width="50%">
				<table cellspacing="0" cellpadding="4" border="0"  >
					<tr>
						<td width="100%" style="font-family: Helvetica;font-size:14px;">
							<b style="font-size: 5pt;color:#000;">&nbsp;</b>
							<b style="font-family: Helvetica;font-size:14px;color:#000;">Overall Score for the Competency</b>
						</td>
					</tr>
				</table>
				<table cellspacing="0" cellpadding="5" border="0" >
					<tr>
						<td width="100%">
							<table cellspacing="0" cellpadding="4" border="0"  >
								<tr>
									<td>
									<img src="'.BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['ass_id'].'/'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'_'.$comp_id.'_graph.svg" />
									</td>
								</tr>
							</table>
						</td>
						
					</tr>
				</table>
				<br><br>
				<table cellspacing="0" cellpadding="5" border="0" >
					<tr>
						
						<td width="100%">
							<table cellspacing="0" cellpadding="4" border="0"  >
								
								<tr>
									<td width="20%"></td>
									<td width="80%">'.$overrate.'
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				
				
			</td>
		</tr>
		
	</table>
	</div>';
	
$tbl = <<<EOD

$comp_analysis
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
$img_file = K_PATH_IMAGES.'coromandel/LastPage.png';
$pdf->Image($img_file, 0, 0, 297, 210, '', '', '', false, 300, '', false, false, 0);
// restore auto-page-break status
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();
$pdf->writeHTML("", true, false, false, false, '');

// add a new page for TOC
$pdf->addTOCPage();
$pdf->footershow=true;
// write the TOC title and/or other elements on the TOC page
$pdf->SetFont('Helvetica', 'B', 16);
$pdf->MultiCell(0, 0, 'Table Of Content', 0, 'C', 0, 1, '', '', true, 0);
$pdf->Ln();
$pdf->SetFont('Helvetica', '', 10);
// disable auto-page-break
$pdf->SetAutoPageBreak(true, 25);
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
$bookmark_templates[0] = '<table border="0" cellpadding="0" cellspacing="5" style="background-color:#FFFFFF"><tr><td width="200mm">
<span style="font-family: Helvetica;font-size: 13px;color: #000;">#TOC_DESCRIPTION#</span></td>
<td width="25mm"><span style="font-family: Helvetica;font-size: 13px;color: #000;" align="center">#TOC_PAGE_NUMBER#</span></td></tr></table>';
$bookmark_templates[1] = '<table border="0" cellpadding="0" cellspacing="5"><tr><td width="200mm">
<span style="font-family:Helvetica;font-size:13px;color:#000;">&nbsp;&nbsp;&nbsp;#TOC_DESCRIPTION#</span></td><td width="25mm">
<span style="font-family:Helvetica;font-size:13px;color:#000;" align="center">#TOC_PAGE_NUMBER#</span></td></tr></table>';
$bookmark_templates[2] = '<table border="0" cellpadding="0" cellspacing="5"><tr><td width="200mm">
<span style="font-family:Helvetica;font-size:13px;color:#000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;#TOC_DESCRIPTION#</span></td><td width="25mm">
<span style="font-family:Helvetica;font-size:13px;color:#000;" align="center">#TOC_PAGE_NUMBER#</span></td></tr></table>';
$bookmark_templates[3] = '<table border="0" cellpadding="0" cellspacing="5"><tr><td width="200mm">
<span style="font-family:Helvetica;font-size:13px;color:#000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;#TOC_DESCRIPTION#</span></td><td width="25mm">
<span style="font-family:Helvetica;font-size:13px;color:#000;" align="center">#TOC_PAGE_NUMBER#</span></td></tr></table>';
$bookmark_templates[4] = '<table border="0" cellpadding="0" cellspacing="5"><tr><td width="200mm">
<span style="font-family:Helvetica;font-size:13px;color:#000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;#TOC_DESCRIPTION#</span></td><td width="25mm">
<span style="font-family:Helvetica;font-size:13px;color:#000;" align="center">#TOC_PAGE_NUMBER#</span></td></tr></table>';
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