<?php
ini_set('display_errors',1);

$final_table='';
$final_table.='
<table style="width:100%" align="left" border="1" cellspacing="0" border="0.5px" bordercolor="#59b0ea" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5;">
	<thead>
		<tr height="30" class="row header">
			<th width="30%">Employee Name</th>
			<td>'.$emp_info['name'].'</td>
		</tr>
		<tr height="30" class="row header">
			<th width="30%">Employee Code</th>
			<td>'.$emp_info['enumber'].'</td>
		</tr>
		<tr height="30" class="row header">
			<th width="30%">Position Name</th>
			<td>'.$emp_info['position_name'].'</td>
		</tr>
	</thead>
</table>
<br style="clear:both;">
<br><br>
<table style="width:100%" align="left" border="1" cellspacing="0" border="0.5px" bordercolor="#59b0ea" cellpadding="5" style="font-family: Helvetica; color:#646464;font-size:11px;line-height: 1.5;">
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
	left join (select assessment_pos_com_id,assessment_id,position_id,assessment_pos_level_scale_id from uls_assessment_competencies)dc on dc.assessment_pos_com_id=a.competency_id and dc.assessment_id=a.assessment_id and dc.`position_id`=a.position_id
	inner join uls_level_master_scale b on dc.`assessment_pos_level_scale_id`=b.scale_id inner join uls_level_master_scale c on a.`assessed_scale_id`=c.scale_id 
	left join(SELECT `comp_def_id`,`comp_def_name`,`comp_def_category` FROM `uls_competency_definition`) ct on ct.comp_def_id=a.competency_id
	WHERE a.`assessment_id`='".$_REQUEST['ass_id']."' and a.`employee_id`='".$_REQUEST['emp_id']."' and a.`position_id`='".$_REQUEST['pos_id']."' and (a.assessment_type='TEST' || a.assessment_type='INTERVIEW') group by a.`competency_id`, a.`assessment_type` ORDER BY `a`.`assessment_type` ASC");
	$final_comp=$allcomp=$allcompfeed=$allcompreq=$allcomp_score_a=$allcomp_score_b=$allcomp_score_a_subcat=$allcomp_subcat=$allcompreq_subcat=array(); 
	foreach($getdats as $aa){
		$cid=$aa['competency_id'];
		$catid=$aa['comp_def_category'];
		$ctype=$aa['assessment_type'];
		/* if($aa['assessed']>$aa['required']){
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
		} */
		$score_data=round((100-((($aa['required']-$aa['assessed'])/$aa['required'])*100)),2);
		$allgg[$cid][$ctype]['score']=$score_data;
		$allcomp_score_a[$cid][$ctype]['score']=$score_data;
		$allcomp[$cid][$ctype]=$aa['assessed'];
		$allcompreq[$cid]=$aa['required'];
	}
	/* echo "<pre>";
	print_r($allgg); */
	
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
		
		$empstatus=UlsAssessmentEmployeeFinalReport::get_assessment_employees_report($_REQUEST['ass_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id'],$comp_id,$results_comps['req_level']);
		 $emp_status=!empty($empstatus['emp_report_id'])?Doctrine::getTable('UlsAssessmentEmployeeFinalReport')->find($empstatus['emp_report_id']):new UlsAssessmentEmployeeFinalReport();
		$emp_status->assessment_id=$_REQUEST['ass_id'];
		$emp_status->position_id=$_REQUEST['pos_id'];
		$emp_status->employee_id=$_REQUEST['emp_id'];
		$emp_status->competency_id=$comp_id;
		$emp_status->require_scale_id=$results_comps['req_level'];
		$emp_status->assessed_value=$ass_val;
		$emp_status->Save();
		/* if($final_val>=0 && $final_val<=40){
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
		} */
		
		$cat_ass_one+=$ass_val;
		$cat_ass_one_count+=1;
		$cat_ass_final_one+=$results_comps['req_level'];
		$cat_ass_final_one_count+=1;
		$kkcomp_name_sub[$comp_id]=$results_comps['comp_name'];
		$kkcomp_name_sub_anns[$comp_id]=$results_comps['comp_name'];
		$kkcomp_name_sub_one[$comp_id]=$results_comps['comp_name'];
		
		
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
echo $final_table;
