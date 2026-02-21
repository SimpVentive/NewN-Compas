<?php
ini_set('display_errors',1);


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
$pdf->Bookmark('1. Competency Assessment Overview', 0, 0, '', '', array(0,0,0));
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
						<b style="font-family: Helvetica;font-size:14px;color:#ffffff;">1. Competency Assessment Overview</b>
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
$pdf->Bookmark('2. Consolidated Summary of Results', 0, 0, '', '', array(0,0,0));
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
						<b style="font-family: Helvetica;font-size:14px;color:#ffffff;">2. Consolidated Summary of Results</b>
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


// end of TOC page
$pdf->endTOCPage();

$pdfname=str_replace(" ","_",'Employee Assessment Report of '.$pdfname);
//Close and output PDF document
$pdf->Output($pdfname.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+