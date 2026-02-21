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
				<td width="5%" style="text-align:left;"><span style="font-family: Helvetica, sans-serif;font-size: 8pt;color:#1b578b;">&nbsp;</span> </td>
				
				<td width="95%" style="text-align:right;"><img src="'.LOGO_IMG_PDF.'" style="margin:0.15cm 0.2cm" height="50"></td>
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
$emp_code=$emp_info['enumber'];
$txt='<label class="fish5" text-align="right;" width="100%"><b style="font-size:30pt;color:#fff;">Assessment Report</b></label><br><br><br>
<label class="fish6"><b style="font-size:26pt;color:#fff;"><br></b></label><br><br><br>
<img src="'.LOGO_IMG_PDF.'" style="margin:0.15cm 0.2cm" width="200"  class="fish"><br><br><br>
<label class="fish1"><b style="font-size:22pt;color:#000;">'.trim($emp_info['name']).'</b><br><b style="font-size:22pt;color:#000;">'.$emp_code.'</b><br><b style="font-size:14pt;color:#000;">'.@$posname.'</b></label>';
	
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
// -- set new background ---
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
$name=$emp_info['name'];

$empinfo_details='<table cellspacing="0" cellpadding="5" style="font-family: Helvetica;font-size:12px;border:1px solid #36a2eb;" width="100%">
	<tr>
		<td width="15%">Emp. ID:<br><b>'.$emp_code.'</b></td>
		<td width="25%">Designation:<br><b>'.$posname.'</b></td>
		<td width="30%">Grade:<br><b>'.$emp_info['grade_name'].'</b></td>
		<td width="15%">Department:<br><b>'.$emp_info['org_name'].'</b></td>
		<td width="15%">Location:<br><b>'.$emp_info['location_name'].'</b></td>
	</tr>
</table>';

$main_one='<img src="'.BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['ass_id'].'/'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'_main_secound_ass.svg"/>';
$main_two='<img src="'.BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['ass_id'].'/'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'_main_first_ass.svg"/>';
$main_three='<img src="'.BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['ass_id'].'/'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'_main_change_ass.svg"/>';
$competency_test='<img src="'.BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['ass_id'].'/'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'_competency_test.svg" style="width:1000px;height:500px;"/>';
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
$para12='';
foreach($results as $key1=>$assessor_ratings){
	$wei_sum=($wei_sum+$assessor_ratings['weightage']);
	$bgcolor=($kk%2==0)?"#deeaf6":"#ffffff";
$kk++;
$para12.='<tr>
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
</tr>';
/* $comdetails='';
$comdetails.='<br><br>
<table style="width:100%" align="left" cellspacing="0" border="0.3px" cellpadding="5" style="font-family: Helvetica; color:#000;font-size:12px;line-height: 1.5;">
	<thead>
		<tr height="30" class="row header" style="font-size:12px;font-weight:bold">
			<th width="15%"></th>
			<th width="55%">Competency</th>
			<th width="30%">Required Level</th>
			
		</tr>
	</thead>
	<tbody>';
	$kk=0;
	$kkk=1;
	foreach($compempstatus as $comp_question){
		$bgcolor=($kk%2==0)?"#E6E0EC":"#ffffff";
		$kk++;
		$comdetails.='<tr>
			<td width="15%">C'.$kkk.'</td>
			<td width="55%">'.$comp_question['comp_def_name'].'</td>
			<td width="30%">'.$comp_question['scale_name'].'</td>
		</tr>';
		$kkk++;
	}
	$comdetails.='</tbody>
</table>'; */
$competency_final='<img src="'.BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['ass_id'].'/'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'_competency_final.svg" style="width:650px;height:350px;"/>';
$tbl = <<<EOD

<h4 style="text-align:center;padding-left:20px;">Assessment Summary - <b style="font-size:14pt;">$name</b></h4>
$empinfo_details
<div style="font-family: Helvetica;font-size:12px;line-height: 1.5;color:#000;">
	<br>
	<table>
		<tr>
			<td>$main_one</td>
			<td>$main_two</td>
			<td>$main_three</td>
		</tr>
	</table>
	
	<table cellspacing="0" cellpadding="4" border="0"  >
		<tr>
			<td width="100%" style="font-family: Helvetica;font-size:16px;">
				<b style="font-size: 5pt;color:#ffffff;">&nbsp;</b>
				<b style="font-family: Helvetica;font-size:16px;">2nd Assessment Score Summary</b>
			</td>
		</tr>
	</table>
	<br><br>
	<table style="width:100%" align="left" cellspacing="0" border="0.3px" cellpadding="5" style="font-family: Helvetica; color:#000;font-size:12px;line-height: 1.5;">
		<thead>
			<tr height="30" align="center" class="row header" style="font-size:12px;font-weight:bold">
				<th width="6%">S.No</th>
				<th width="20%">Assessment Method</th>
				<th width="10%">Total Question</th>
				<th width="11%">Answered Correctly/Rating</th>
				<th width="12%">Percentage Scored (%)</th>
				<th width="21%">Weightage for Assessment Method (%)</th>
				<th width="20%">Weighted Score</th>
			</tr>
		</thead>
		<tbody>
		$para12
		</tbody>
	</table>
	<br><br>
	<table cellspacing="0" cellpadding="4" border="0"  >
		<tr>
			<td width="100%" style="font-family: Helvetica;font-size:16px;">
				<b style="font-size: 5pt;color:#ffffff;">&nbsp;</b>
				<b style="font-family: Helvetica;font-size:16px;">Knowledge Differential – Competency Scores in MCQ – A2 Vs A1</b>
			</td>
		</tr>
	</table>
	<br>
	$competency_test
	<br>
	<table cellspacing="0" cellpadding="0" border="0" >
		<tr>
			<td  width="25%" >
		</td>
			<td  width="3%"  bgcolor="#FCB614" >
		</td>
			<td  width="25%"  style="color:#646464;">Assessment 2
		</td>
			<td  width="3%" bgcolor="#0098DB">
		</td>
			<td  width="45%"  style="color:#646464;">Assessment 1
		</td>
		</tr>
	</table>
	<br>
	<div style="color:red;padding-left:5px;font-family: Helvetica;font-size:10px;line-height:1.5;">
	Note: The above values are reported in %.
	</div>
</div>
EOD;
//$comdetails
/* <br><br>
	<table cellspacing="0" cellpadding="4" border="0"  >
		<tr>
			<td width="100%" style="font-family: Helvetica;font-size:16px;">
				<b style="font-size: 5pt;color:#ffffff;">&nbsp;</b>
				<b style="font-family: Helvetica;font-size:16px;">Competency Profile</b>
			</td>
		</tr>
	</table> */
$pdf->writeHTML($tbl, true, false, false, false, '');
$pdf->AddPage();
$pdf->footershow=true;
$pdf->SetFooterMargin(5);
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();
	$ass_comments=$assessor_comments['comments'];			
$tbl = <<<EOD
	<br><br>
	<table cellspacing="0" cellpadding="4" border="0"  >
		<tr>
			<td width="100%" style="font-family: Helvetica;font-size:16px;">
				<b style="font-size: 5pt;color:#ffffff;">&nbsp;</b>
				<b style="font-family: Helvetica;font-size:16px;">Overall Employee Performance – Competency-wise Improvement – A2 Vs A1</b>
			</td>
		</tr>
	</table>
	$competency_final
	<br>
	<table cellspacing="0" cellpadding="0" border="0" >
		<tr>
			<td  width="25%" >
		</td>
			<td  width="3%"  bgcolor="#FCB614" >
		</td>
			<td  width="25%"  style="color:#646464;">Assessment 2
		</td>
			<td  width="3%" bgcolor="#0098DB">
		</td>
			<td  width="45%"  style="color:#646464;">Assessment 1
		</td>
		</tr>
	</table>
	<br>
	<div style="color:red;padding-left:5px;font-family: Helvetica;font-size:10px;line-height:1.5;">
	Note: The above values are the Assessed levels.
	</div>
	<br><br>
	<table cellspacing="0" cellpadding="4" border="0"  >
		<tr>
			<td width="100%" style="font-family: Helvetica;font-size:16px;">
				<b style="font-size: 5pt;color:#ffffff;">&nbsp;</b>
				<b style="font-family: Helvetica;font-size:16px;">Assessor Comments</b>
			</td>
		</tr>
	</table>
	<br><br>
	<span style="font-style: italic;">$ass_comments</span>
	<div style="height: 450px;bottom:0px;">&nbsp;<br><br><br><br><br><br><br><br><br><br><br><br></div>
	<div style="color:red;padding-left:5px;font-family: Helvetica;font-size:10px;line-height:1.5;">
	Note: The comments and development guide lines are adverbatim, as given by the assessors, these could include comments on the interview performance.
	The development requirements identified by the assessors may be in the context of the current job as well as the future requirements.
	Kindly focus on the development requirement identified.
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
$img_file = K_PATH_IMAGES.'seedworks/adani-power-backcover.jpg';
$pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
// restore auto-page-break status
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();
$pdf->writeHTML("", true, false, false, false, '');


$pdfname=str_replace(" ","_",'Employee Assessment Report of '.$pdfname);
//Close and output PDF document
$pdf->Output($pdfname.'.pdf', 'I');