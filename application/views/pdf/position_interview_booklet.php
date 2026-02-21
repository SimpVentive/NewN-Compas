<?php
class MYPDF extends Pdf {
	//Page header
	public function Header() {
		global $key;
		// get the current page break margin
		$bMargin = $this->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $this->AutoPageBreak;
		// disable auto-page-break
		$this->SetAutoPageBreak(false, 0);
		if($key==0){
			$img_file = K_PATH_IMAGES.'cms/interviewcover.jpg';
			$this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
		}
		else{
			$img_file = K_PATH_IMAGES.'cms/bar.jpg';
			$this->Image($img_file, 0, 0, 8.8, 297, '', '', '', false, 300, '', false, false, 0);
		}
		$this->SetAutoPageBreak($auto_page_break, $bMargin);
		$this->setPageMark();
		$key++;
	}
	
	public function Footer() {
		if ($this->tocpage) {
			parent::Footer();
		} else {
			parent::Footer();
		}
	}
}
global $key;
$key=0;
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Srikanth Math');
$pdf->SetTitle('Assessment Booklet');
$pdf->SetSubject('Assessment Booklet');
$pdf->SetKeywords('Assessment Booklet');
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 040', PDF_HEADER_STRING);
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(10, 10, 10);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}
$pdf->SetFont('rockwell', '', 10);

//extract($posdetails);
// add a page
$pdf->AddPage();
$pdf->SetFooterMargin(0);
$position_name=$posdetails['position_name'];
$grade=$posdetails['grade_name'];
$bu_name=$posdetails['bu_name'];
$position_org_name=!empty($posdetails['position_org_name'])?$posdetails['position_org_name']:"-";
$location_name=!empty($posdetails['location_name'])? $posdetails['location_name']:"-";

$image=LOGO_IMG;
// Print a text
$html = <<<EOD

<table cellspacing="0" width="100%" cellpadding="5" border="0" >
	<tr>
		<td width="100%" colspan="3" align="right"><img src="$image" style="margin:0.15cm 0.2cm" width="176" height="66"> </td>
	</tr>
	<tr>
		<td width="100%" height="570pt" colspan="3">&nbsp;</td>
	</tr>
    <tr>
        <td width="2%">&nbsp;</td>
		<td width="96%"><span style="font-family: rockwell;font-size: 16pt;color:#f37021; width:70%">This is a report generated for $position_name<br> in Coromandel International Ltd</span></td>
		<td width="2%">&nbsp;</td>
	</tr>
</table>
EOD;
$pdf->writeHTML($html, true, false, true, false, '');

//$pdf->setPrintHeader(false);
// add a page
$pdf->AddPage();
// -- set new background ---
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->Bookmark('1. Assessment Details', 0, 0, '', '', array(0,0,0));
$index_link = $pdf->AddLink();
$pdf->SetLink($index_link, 0, '*1');

/*// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(false, 0);
// restore auto-page-break status
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();*/


$tbl = <<<EOD
<table cellspacing="0" cellpadding="5" border="0" >
    <tr>
        <td colspan="2" width="100%"><span style="font-family: rockwell;font-size: 20pt;color:#f37021;">Position Name : $position_name</span>
	</td>
    </tr>
</table>
<br>

<table style="font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;border-collapse: collapse;width: 100%;">
 <tr>
  <th colspan="4" align="center" style="border: 1px solid #ddd;padding: 15px;"><span style="font-family: rockwell;font-size: 14pt;color:#fcaf17;">Position Details</span></th>
 </tr>
 <tr>
  <td style="border: 1px solid #ddd;padding: 14px;height:30px;"><span style="font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;font-size: 10pt;color:#212121;width:15%">Job Title:</span></td>
  <td style="border: 1px solid #ddd;padding: 14px;height:30px;"><span style="font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;;font-size: 10pt;color:#212121;width:35%">$position_name</span></td>
  <td style="border: 1px solid #ddd;padding: 14px;height:30px;"><span style="font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;;font-size: 10pt;color:#212121;width:15%">Grade/Level:</span></td>
  <td style="border: 1px solid #ddd;padding: 14px;height:30px;"><span style="font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;;font-size: 10pt;color:#212121;width:35%">$grade_name</span></td>
 </tr>
 <tr>
  <td style="border: 1px solid #ddd;padding: 14px;height:30px;"><span style="font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;;font-size: 10pt;color:#212121;">Business:</span></td>
  <td style="border: 1px solid #ddd;padding: 14px;height:30px;"><span style="font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;;font-size: 10pt;color:#212121;">$bu_name</span></td>
  <td style="border: 1px solid #ddd;padding: 14px;height:30px;"><span style="font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;;font-size: 10pt;color:#212121;">Function:</span></td>
  <td style="border: 1px solid #ddd;padding: 14px;height:30px;"><span style="font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;;font-size: 10pt;color:#212121;">$position_org_name</span></td>
 </tr>
 <tr>
  <td style="border: 1px solid #ddd;padding: 14px;height:30px;"><span style="font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;;font-size: 10pt;color:#212121;">Location:</span></td>
  <td style="border: 1px solid #ddd;padding: 14px;height:30px;"><span style="font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;;font-size: 10pt;color:#212121;">$location_name</span></td>
  <td style="border: 1px solid #ddd;padding: 14px;height:30px;"><span style="font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;;font-size: 10pt;color:#212121;"></span></td>
  <td style="border: 1px solid #ddd;padding: 14px;height:30px;"><span style="font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;;font-size: 10pt;color:#212121;"></span></td>
 </tr>
 
</table>
<br>

<span style="font-family:Times New Roman;font-size: 16pt;color:#860908;">Position Description</span>

<div style="background-color:#ffffff;"><span style="font-family: Times New Roman;font-size: 14pt;color:#F36E1F;"> Education Background:</span></div>
<span style="font-family: Times New Roman;color:#646464;font-size: 10pt;">$education</span><br>
<div style="background-color:#ffffff;"><span style="font-family: Times New Roman;font-size: 14pt;color:#F36E1F;"> Experience:</span></div>
<span style="font-family: Times New Roman;color:#646464;font-size: 10pt;">$experience</span><br>
<div style="background-color:#ffffff;"><span style="font-family: Times New Roman;font-size: 14pt;color:#F36E1F;"> Industry Specific Experience:</span></div>
<span style="font-family: Times New Roman;color:#646464;font-size: 10pt;">$specific_experience</span><br>
<div style="background-color:#ffffff;"><span style="font-family: Times New Roman;font-size: 14pt;color:#F36E1F;"> Other Requirements:</span></div>
<span style="font-family: Times New Roman;color:#646464;font-size: 10pt;">$other_requirement</span>

EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

//$pdf->setPrintHeader(false);

$pdf->AddPage();
$pdf->Bookmark('3. KRA & KPI', 0, 0, '', '', array(0,0,0));
$index_link = $pdf->AddLink();
$pdf->SetLink($index_link, 0, '*1');
/*// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(false, 0);

// restore auto-page-break status
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();*/
$kri="";$key4=2;
$temp="";
foreach($kras as $key=>$kra){
	if($kra['comp_position_id']==$posdetails['position_id']){
	if ($key4%2==0){
		$kri.='<tr bgcolor="#f6ecd7">';
	}
	else{
		$kri.='<tr bgcolor="#ffffff">';
	}
	

		$kri.="<td>".$kra['kra_master_name']."</td>
		<td>".$kra['kra_kri']."</td>
		<td>".$kra['kra_uom']."</td>
	</tr>"; 
	$key4++;
	}
}

$tbl = <<<EOD
<span style="font-family: Times New Roman;font-size: 14pt;color:#fcaf17;">KRA & KPI</span><br>

<table align="left" cellspacing="0" cellpadding="5" style="font-family: Times New Roman; color:#646464;font-size: 10pt;border: 1px solid #dddddd;width:100%">
	<tr height="30" bgcolor="#fcaf17" style="font-family: rockwell;color:#fff;">
		<td align="center" style="width:35%"><b>KRA</b></td>
		<td align="center" style="width:35%"><b>KPI</b></td>
		<td align="center" style="width:30%"><b>Unit of Measurement (UOM)</b></td>
	</tr>
	$kri
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

//$pdf->setPrintHeader(false);

$cat_name=$cat_name['name']; 
$pdf->AddPage();
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->Bookmark('2. '.$cat_name.' Category', 0, 0, '', '', array(0,0,0));
$index_link = $pdf->AddLink();
$pdf->SetLink($index_link, 0, '*1');
/* // get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(false, 0);

// restore auto-page-break status
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark(); */
$comp_cat="";$key4=2;

foreach($func_competencies as $key2=>$func_competencie){
	if($func_competencie['comp_position_id']==$posdetails['position_id']){
	$key2=$key2+1;
	if ($key4%2==0){
		$comp_cat.='<tr bgcolor="#f6ecd7">';
	}
	else{
		$comp_cat.='<tr bgcolor="#ffffff">';
	}
	$comp_cat.="<td>".$key2."</td>
			<td>".$func_competencie['comp_def_name']."</td>
			<td>".$func_competencie['scale_name']."</td>
			<td>".$func_competencie['comp_cri_name']."</td>
		</tr>";
	}
	$key4++;
}
$tbl = <<<EOD
<span style="font-family: Times New Roman;font-size: 14pt;color:#fcaf17;"> $cat_name Category</span><br>

<table style="width:100%" align="left" cellspacing="0" cellpadding="5" style="font-family: Times New Roman; color:#646464;font-size: 10pt;">
	<tr height="30" bgcolor="#fcaf17" style="font-family: rockwell;color:#fff;">
		<td style="width:7%"><b>S No</b></td>
		<td align="center" style="width:45%"><b>Competencies</b></td>
		<td align="center" style="width:29%"><b>Required Level</b></td>
		<td align="center" style="width:18%"><b>Criticality</b></td>
	</tr>
	$comp_cat
</table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

//$pdf->setPrintHeader(false);


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

foreach($func_competencies as $positions){
	if(isset($c_id[0])){
		if($positions['comp_position_criticality_id']==$c_id[0]){
			$comp_id=$positions['comp_position_competency_id'];
			$comp_l1[]=$positions['comp_position_competency_id'];
			$level_l1[$comp_id]=$positions['comp_position_level_scale_id'];
			$cri_l1[]=$positions['comp_position_criticality_id'];
		}
	}
	if(isset($c_id[1])){
		if($positions['comp_position_criticality_id']==$c_id[1]){
			$comp_id=$positions['comp_position_competency_id'];
			$comp_l2[]=$positions['comp_position_competency_id'];
			$level_l2[$comp_id]=$positions['comp_position_level_scale_id'];
			$cri_l2[]=$positions['comp_position_criticality_id'];

		}
	}
	if(isset($c_id[2])){
		if($positions['comp_position_criticality_id']==$c_id[2]){				
			$comp_id=$positions['comp_position_competency_id'];
			$comp_l3[]=$positions['comp_position_competency_id'];
			$level_l3[$comp_id]=$positions['comp_position_level_scale_id'];
			$cri_l3[]=$positions['comp_position_criticality_id'];

		}
	}
	if(isset($c_id[3])){
		if($positions['comp_position_criticality_id']==$c_id[3]){
			$comp_l4[]=$positions['comp_position_competency_id'];
			$level_l4[]=$positions['comp_position_level_scale_id'];
			$cri_l4[]=$positions['comp_position_criticality_id'];

		}
	}
	if(isset($c_id[4])){
		if($positions['comp_position_criticality_id']==$c_id[4]){
			$comp_l5[]=$positions['comp_position_competency_id'];
			$level_l5[]=$positions['comp_position_level_scale_id'];
			$cri_l5[]=$positions['comp_position_criticality_id'];

		}
	}
}
$int_type=$_REQUEST['int_type'];
$no_questions=$_REQUEST['total'];
$count_v=sizeof($comp_l1);
$count_i=sizeof($comp_l2);
$count_l3=sizeof($comp_l3);
$count_l4=sizeof($comp_l4);
$count_l5=sizeof($comp_l5);
$count_vital_limit=@(int)($no_questions/$count_v);
 $count_vital_limit_mul=@$no_questions-($count_vital_limit*$count_v);
$count_imp_limit=@(int)($no_questions/$count_i);
$count_imp_limit_mul=$no_questions-($count_imp_limit*$count_i);
$count_imp_limil3=@(int)($no_questions/$count_l3);
$count_imp_limit_mull3=$no_questions-($count_imp_limil3*$count_l3);
$count_imp_limil4=@(int)($no_questions/$count_l4);
$count_imp_limit_mull4=$no_questions-($count_imp_limil4*$count_l4);
$count_imp_limil5=@(int)($no_questions/$count_l5);
$count_imp_limit_mull5=$no_questions-($count_imp_limil5*$count_l5); 
$c1_total=$c2_total=$c3_total=$c4_total=$c5_total=0;
$c1_t=array();
foreach($comp_l1 as $key=>$comps){
	$comp_count=UlsQuestions::get_questions_count($comps,'COMP_TEST',$level_l1[$comps]);
	$c1_t[$comps]=$comp_count['test_count'];
}
$c1_i=array();
foreach($comp_l1 as $key2=>$comps){
	$comp_count_i=UlsQuestions::get_questions_count($comps,'COMP_INTERVIEW',$level_l1[$comps]);
	$c1_i[$comps]=$comp_count_i['test_count'];
}

asort($c1_t);
asort($c1_i);
/* print_r($c1_t);
print_r($c1_i);
print_r($comp_l1); */
$count_q=0;
$count_i=0;
// add a page
$pdf->AddPage();
//$pdf->SetMargins(60, 200, PDF_MARGIN_RIGHT,true);
// -- set new background ---
$pdf->Bookmark('4. Competency Based Interview Questions', 0, 0, '', '', array(0,0,0));
/* // get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(false, 0);

// restore auto-page-break status
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->SetFont('dejavusans', '', 10);
// set the starting point for the page content
$pdf->setPageMark(); */
$j=0;
$int_table="";
foreach($c1_i as $key=>$comps_c1){
	if($count_vital_limit>$comps_c1){
		$count_i+=$count_vital_limit-$comps_c1;
	}
	$comp_name=UlsCompetencyDefinition::viewcompetency($key);
	$comp_def_name=$comp_name['comp_def_name'];
	$comp_def_short_desc=$comp_name['comp_def_short_desc'];
	$int_table.='<table border="1" cellpadding="5" cellspacing="0"  >
			<tr nobr="true">
				<td><b>Competency:</b></td>
				<td>'.$comp_def_name.'</td>
			</tr>
			<tr nobr="true">
				<td colspan="2"><b>Description:</b>
				<br>
				<p>'.$comp_def_short_desc.'</p>
				</td>
			</tr>
			<tr nobr="true">
				<td colspan="2">
					<b>What To ask…</b>
					<ol>';
					if((count($c1_i)-1)==$j){
						$question_counti=UlsQuestions::get_questions_count_comp($key,($count_vital_limit+$count_vital_limit_mul+$count_i),$level_l1[$key],'COMP_INTERVIEW');
						foreach($question_counti as $question_counts){
						$int_table.='<li>'.strip_tags($question_counts['question_name']).'
							<ol>';
							$q_values=UlsQuestionValues::get_allquestion_values($question_counts['ques_id']);
							foreach($q_values as $q_value){
								$chk=$q_value['correct_flag']=='Y'? 'checked="checked"'  : '';
								$col=$q_value['correct_flag']=='Y'? 'style="color:#060506"':'';
								if(!empty($q_value['text'])){
									$int_table.='<li '.$col.'><span>'.$q_value['text'].'</span>
									<br />
									<textarea rows="4" cols="100"></textarea>
									</li>';
								}
							}
							$int_table.='</ol></li>';
						}
						$count_i=0;
					}
					else{
						$question_counti=UlsQuestions::get_questions_count_comp($key,$count_vital_limit,$level_l1[$key],'COMP_INTERVIEW');
						foreach($question_counti as $question_counts){
							$int_table.='<li>'.strip_tags($question_counts['question_name']).'
								<ol>';
								$q_values=UlsQuestionValues::get_allquestion_values($question_counts['ques_id']);
								foreach($q_values as $q_value){
									$chk=$q_value['correct_flag']=='Y'? 'checked="checked"'  : '';
									$col=$q_value['correct_flag']=='Y'? 'style="color:#060506;"':'';
									if(!empty($q_value['text'])){
										$int_table.='<li '.$col.'>
											<span>'.str_replace("Answer","",$q_value['text']).'</span>
											<br />
											<textarea rows="4" cols="100"></textarea>
											</li>';
									}
								}
								$int_table.='</ol></li>';
								
						}
					}
					$int_table.='</ol>
				</td>
			</tr>
	</table>
	<br />';
	$j++;
}

$tbl = <<<EOD
<table cellspacing="0" cellpadding="5" border="0" >
    <tr>
        <td colspan="2" width="100%"><span style="font-family: rockwell;font-size: 30pt;color:#f37021;">Competency Based Interview Questions</span>
	</td>
    </tr>
</table>
<br>
$int_table
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

//$pdf->setPrintHeader(false);

// add a page
$pdf->AddPage();
//$pdf->SetMargins(60, 200, PDF_MARGIN_RIGHT,true);
// -- set new background ---
$pdf->Bookmark('5. Competency Based CBT Questions', 0, 0, '', '', array(0,0,0));
/* // get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(false, 0);

// restore auto-page-break status
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->SetFont('dejavusans', '', 10);
// set the starting point for the page content
$pdf->setPageMark(); */
$k=0;
$cbt_table="";
foreach($c1_t as $key1=>$comps_ct){
	if($count_vital_limit>$comps_ct){
		$count_q+=$count_vital_limit-$comps_ct;
	}
	$comp_name=UlsCompetencyDefinition::viewcompetency($key1);
	$comp_def_name_cbt=$comp_name['comp_def_name'];
	$comp_def_short_desc_cbt=$comp_name['comp_def_short_desc'];
	$cbt_table.='<table  cellspacing="0" cellpadding="5" border="1" >
			<tr nobr="true">
				<td><b>Competency:</b></td>
				<td>'.$comp_def_name_cbt.'</td>
			</tr>
			<tr nobr="true">
				<td colspan="2"><b>Description:</b>
				<p>'.strip_tags($comp_def_short_desc_cbt).'</p>
				</td>
			</tr>
			<tr nobr="true">
				<td colspan="2">
					<b>What To ask…</b>
					<ol>';
						if((count($c1_t)-1)==$k){
							$question_count_cbt=UlsQuestions::get_questions_count_comp($key1,($count_vital_limit+$count_vital_limit_mul+$count_q),$level_l1[$key1],'COMP_TEST');
							foreach($question_count_cbt as $question_countss){
								$cbt_table.='<li>'.strip_tags($question_countss['question_name']).'
								<ol>';
								$q_values_cbt=UlsQuestionValues::get_allquestion_values($question_countss['ques_id']);
								foreach($q_values_cbt as $q_values){
									$chk=$q_values['correct_flag']=='Y'? 'checked="checked"'  : '';
									$cols=$q_values['correct_flag']=='Y'? 'style="background-color:green;color:#000;"':'';
									$cbt_table.='<li><span '.$cols.'>'.strip_tags($q_values['text']).'</span></li>';
								}
								$cbt_table.='</ol></li>';
							}
							$count_q=0;
						}
						else{
							$question_count_cbt=UlsQuestions::get_questions_count_comp($key1,$count_vital_limit,$level_l1[$key1],'COMP_TEST');
							foreach($question_count_cbt as $question_countss){
								$cbt_table.='<li>'.strip_tags($question_countss['question_name']).'
								<ol>';
								$q_values_cbt=UlsQuestionValues::get_allquestion_values($question_countss['ques_id']);
								foreach($q_values_cbt as $q_values){
									$chk=$q_values['correct_flag']=='Y'? 'checked="checked"'  : '';
									$col=$q_values['correct_flag']=='Y'? 'style="color:green;"':'';
									$cbt_table.='<li '.$col.'><span>'.strip_tags($q_values['text']).'</span></li>';
								}
								$cbt_table.='</ol></li>';
							}
						}
					$cbt_table.='</ol>
				</td>
			</tr>
	</table>';
	$k++;
}
$tbl_cbt = <<<EOD
<table cellspacing="0" cellpadding="5" border="0" >
    <tr>
        <td colspan="2" width="100%"><span style="font-family: rockwell;font-size: 30pt;color:#f37021;">Competency Based CBT Questions</span>
	</td>
    </tr>
</table>
<br />
$cbt_table
EOD;
$pdf->writeHTML($tbl_cbt, true, false, false, false, '');

//$pdf->setPrintHeader(false);
// add a page
$pdf->AddPage();
//$pdf->SetMargins(60, 200, PDF_MARGIN_RIGHT,true);
// -- set new background ---
$pdf->Bookmark('3. CBT Questions', 0, 0, '', '', array(0,0,0));
/* // get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(false, 0);

// restore auto-page-break status
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark(); */
$cat_others="";
$key8=2;
foreach($cat_name_others as $cat_name_other){
	$other_competencies=UlsCompetencyPositionRequirements::getcompetency_position_requirement_cat($_REQUEST['pos_id'],$cat_name_other['category_id'],$_REQUEST['cri']);
	if(count($other_competencies)){
		$cat_n=$cat_name_other['name'];
		$cat_others.='<table cellspacing="0" cellpadding="5" border="0" >
			<tr>
				<td colspan="2" width="100%"><span style="font-family: rockwell;font-size: 30pt;color:#f37021;">'.$cat_n.' Category</span>
			</td>
			</tr>
		</table>
		<br/>
		<table style="width:100%" align="left" cellspacing="0" cellpadding="5" style="font-family: Times New Roman; color:#646464;font-size: 10pt;">
			<tr height="30" bgcolor="#fcaf17" style="font-family: rockwell;color:#fff;">
				<td style="width:7%"><b>S No</b></td>
				<td align="center" style="width:45%"><b>Competencies</b></td>
				<td align="center" style="width:29%"><b>Required Level</b></td>
				<td align="center" style="width:18%"><b>Criticality</b></td>
			</tr>';
			foreach($other_competencies as $key_n=>$fun_competencie){
				if($fun_competencie['comp_position_id']==$posdetails['position_id']){
					$key_n=$key_n+1;
					if ($key8%2==0){
						$cat_others.='<tr bgcolor="#f6ecd7">';
					}
					else{
						$cat_others.='<tr bgcolor="#ffffff">';
					}
					$cat_others.='<td>'.$key_n.'</td>
						<td>'.$fun_competencie['comp_def_name'].'</td>
						<td>'.$fun_competencie['comp_def_name'].'</td>
						<td>'.$fun_competencie['scale_name'].'</td>
						<td>'.$fun_competencie['comp_cri_name'].'</td>
					</tr>';
				}
			}
		$cat_others.='</table>
		<br/>
		<h3 class="title">Overall Remarks</h3>
		<div style="width: 300px;height: 100px;padding: 50px;border: 1px solid #ff0000;">
		<br>&nbsp;
		<br>&nbsp;
		<br>&nbsp;
		<br>&nbsp;
		<br>&nbsp;
		<br>&nbsp;
		</div>';	
	}
}
$tbl = <<<EOD
$cat_others
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

//$pdf->setPrintHeader(false);
// add a page
$pdf->AddPage();
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
$img_file = K_PATH_IMAGES.'cms/cms-back.jpg';
$pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
// restore auto-page-break status
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();
$pdf->writeHTML("", true, false, false, false, '');
// ---------------------------------------------------------


// add a new page for TOC
$pdf->addTOCPage();

// write the TOC title and/or other elements on the TOC page
$pdf->SetFont('times', 'B', 16);
$pdf->MultiCell(0, 0, 'Table Of Content', 0, 'C', 0, 1, '', '', true, 0);
$pdf->Ln();
$pdf->SetFont('rockwell', '', 10);
// disable auto-page-break
$pdf->SetAutoPageBreak(false, 0);
// set bacground image
$img_file = K_PATH_IMAGES.'cms/bar.jpg';
$pdf->Image($img_file, 0, 0, 8.8, 297, '', '', '', false, 300, '', false, false, 0);
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
<span style="font-family: rockwell;font-size: 12pt;color: #f37021;">#TOC_DESCRIPTION#</span></td>
<td width="25mm"><span style="font-family: rockwell;font-size: 12pt;color: #f37021;" align="center">#TOC_PAGE_NUMBER#</span></td></tr></table>';
$bookmark_templates[1] = '<table border="0" cellpadding="0" cellspacing="5"><tr><td width="155mm">
<span style="font-family:rockwell;font-size:12pt;color:#f37021;">&nbsp;&nbsp;&nbsp;#TOC_DESCRIPTION#</span></td><td width="25mm">
<span style="font-family:rockwell;font-size:12pt;color:#f37021;" align="center">#TOC_PAGE_NUMBER#</span></td></tr></table>';
$bookmark_templates[2] = '<table border="0" cellpadding="0" cellspacing="5"><tr><td width="155mm">
<span style="font-family:rockwell;font-size:12pt;color:#f37021;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;#TOC_DESCRIPTION#</span></td><td width="25mm">
<span style="font-family:rockwell;font-size:12pt;color:#f37021;" align="center">#TOC_PAGE_NUMBER#</span></td></tr></table>';
$bookmark_templates[3] = '<table border="0" cellpadding="0" cellspacing="5"><tr><td width="155mm">
<span style="font-family:rockwell;font-size:12pt;color:#f37021;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;#TOC_DESCRIPTION#</span></td><td width="25mm">
<span style="font-family:rockwell;font-size:12pt;color:#f37021;" align="center">#TOC_PAGE_NUMBER#</span></td></tr></table>';
$bookmark_templates[4] = '<table border="0" cellpadding="0" cellspacing="5"><tr><td width="155mm">
<span style="font-family:rockwell;font-size:12pt;color:#f37021;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;#TOC_DESCRIPTION#</span></td><td width="25mm">
<span style="font-family:rockwell;font-size:12pt;color:#f37021;" align="center">#TOC_PAGE_NUMBER#</span></td></tr></table>';
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
