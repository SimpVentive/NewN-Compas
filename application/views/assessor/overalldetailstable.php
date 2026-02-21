<?php
	$testtypes_new=UlsAssessmentTest::get_assessment_position_new($_REQUEST['ass_id'],$_REQUEST['pos_id']);
	$para_table='<table cellspacing="0" cellpadding="5" border="1" align="left" style="width:100%;font-family: Helvetica; color:#646464;font-size:10px;line-height: 1.5; border:1px solid #9999;">
	<thead>
		<tr bgcolor="#59b0ea" align="center" style="color:#fff;" class="header">
			<th rowspan="2" style="text-align:center;width:20%">Competency</th>
			<th style="text-align:center;width:60%" colspan="'.count($testtypes_new).'">Assessment Method</th>
			<th rowspan="2" style="text-align:center;width:10%">Assessed Competency Level</th>
			<th rowspan="2" style="text-align:center;width:10%">Required Competency Level</th>
		</tr>
		<tr bgcolor="#59b0ea" align="center" style="color:#fff;" class="header">';
			$a="";
			$wid=60/count($testtypes_new);
			$assessmentweight=array();
			foreach($testtypes_new as $testtype){
				if($testtype['assessment_type']=='TEST'){
					$para_table.='<th style="text-align:center;" width="'.$wid.'%">Test('.$testtype['weightage'].')</th>';
					$assessmentweight['TEST']=$testtype['weightage'];
				}
				elseif($testtype['assessment_type']=='INBASKET'){
					$para_table.='<th style="text-align:center;" width="'.$wid.'%">In-Basket('.$testtype['weightage'].')</th>';
					$assessmentweight['INBASKET']=$testtype['weightage'];
				}
				elseif($testtype['assessment_type']=='CASE_STUDY'){
					$para_table.='<th style="text-align:center;" width="'.$wid.'%">Case Study('.$testtype['weightage'].')</th>';
					$assessmentweight['CASE_STUDY']=$testtype['weightage'];
				}
				elseif($testtype['assessment_type']=='INTERVIEW'){
					$para_table.='<th style="text-align:center;" width="'.$wid.'%">Interview('.$testtype['weightage'].')</th>';
					$assessmentweight['INTERVIEW']=$testtype['weightage'];
				}
				elseif($testtype['assessment_type']=='FEEDBACK'){
					$para_table.='<th style="text-align:center;" width="'.$wid.'%">Feedback('.$testtype['weightage'].')</th>';
					$assessmentweight['FEEDBACK']=$testtype['weightage'];
				}
			}
		$para_table.='</tr>
	</thead>
	<tbody>';
	$total_all_weight=0;
	$cluster_wei=array();
	$kkk=1;
	$keyy=0;
	foreach($category as $categorys){
		$ass_comp_info=UlsAssessmentReport::getassessment_admin_competency($_REQUEST['ass_id'],$_REQUEST['pos_id'],$categorys['category_id']);
		$para_table.='<tr><td colspan="'.(count($testtypes)+2).'" style="width:100%; border:1px solid #dedede !important;"><strong>'.$categorys['name'].'</strong></td></tr>';
		$results=$result_assessor=$assessor=array();
		$ass_method_score="";
		foreach($ass_comp_info as $ass_comp_infos){
			$comp_id=$ass_comp_infos['comp_def_id'];
			$req_scale_id=$ass_comp_infos['req_scale_id'];
			$results[$comp_id]['comp_id']=$comp_id;
			$results[$comp_id]['comp_name']=$ass_comp_infos['comp_def_name'];
			$results[$comp_id]['pos_com_weightage']=$ass_comp_infos['pos_com_weightage'];
		}
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
					$ass_method_test=$assessor_ratings['event_id'];
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
			$assessment_type=$wei['assessment_type'];
			$allweights[$assessment_type]=$wei['weightage'];
		}
		$getdats=UlsMenu::callpdo("SELECT avg(b.scale_number) as required,avg(c.scale_number) as assessed,a.`position_id`,a.`employee_id`,a.`assessment_type`,a.`competency_id` FROM `uls_assessment_report_bytype` a inner join uls_level_master_scale b on a.`require_scale_id`=b.scale_id inner join uls_level_master_scale c on a.`assessed_scale_id`=c.scale_id WHERE `assessment_id`='".$_REQUEST['ass_id']."' and `employee_id`='".$_REQUEST['emp_id']."' and `position_id`='".$_REQUEST['pos_id']."' group by `competency_id`, `assessment_type` ORDER BY `a`.`assessment_type` ASC");
		
		$getdatfeeds=UlsMenu::callpdo("SELECT avg(`rater_value`) as val,`element_competency_id` FROM `uls_feedback_employee_rating` WHERE `assessment_id`='".$_REQUEST['ass_id']."' and `employee_id`='".$_REQUEST['emp_id']."' and `giver_id`!='".$_REQUEST['emp_id']."' and `rater_value` is not null and `rater_value`!=0 group by `element_competency_id`");
		
		$allcomp=$allcompreq=array();
		foreach($getdats as $aa){
			$cid=$aa['competency_id'];
			$ctype=$aa['assessment_type'];
			$allcomp[$cid][$ctype]=$aa['assessed'];
			$allcompreq[$cid]=$aa['required'];
		}
		foreach($getdatfeeds as $aaa){
			$cid=$aaa['element_competency_id'];
			$ctype="FEEDBACK";
			$allcomp[$cid][$ctype]=$aaa['val'];
		}		
		foreach($results as $comp_def_id=>$result){
			$para_table.='<tr>
				<td style="width:20%;border:1px solid #dedede !important;">'.$result['comp_name'].'('.$result['pos_com_weightage'].')</td>';
				$multi=1;
				
				$test_weight=$test_weight2=$inb_weight=$case_weight=$int_weight=$feed_weight='';
				foreach($testtypes_new as $testtype){

					if($testtype['assessment_type']=='TEST'){
						$test_test_id=UlsMenu::callpdorow("SELECT d.level_scale,avg(b.scale_number) as required,avg(c.scale_number) as assessed,a.`position_id`,a.`employee_id`,a.`assessment_type`,a.`competency_id` FROM `uls_assessment_report_bytype` a inner join uls_level_master_scale b on a.`require_scale_id`=b.scale_id inner join uls_level_master_scale c on a.`assessed_scale_id`=c.scale_id inner join uls_level_master d on b.level_id=c.level_id WHERE `assessment_id`='".$_REQUEST['ass_id']."' and `employee_id`='$emp_id' and `position_id`='".$_REQUEST['pos_id']."' and competency_id='".$result['comp_id']."' and  assessment_type='TEST' group by `competency_id`, `assessment_type` ORDER BY `a`.`assessment_type` ASC, `a`.`competency_id` ASC ");
						if(!empty($test_test_id['required'])){
							$chkcid=$result['comp_id'];$tot=1;
							if(isset($allcomp[$chkcid])){
								$allweight=0;
								foreach($allcomp[$chkcid] as $k=>$v){
									$allweight=$allweight+$allweights[$k];
								}
								$tot=$allweights['TEST']/$allweight;
							}
							$test_weight2="";//@round($test_test_id['assessed'],1).'-'.$allweight.'-'.$tot.'-';
							$test_weight=@round($test_test_id['assessed']*$tot,2);//*($testtype['weightage']/100));
							$para_table.='<td style="border:1px solid #dedede !important;text-align:center;" width="'.$wid.'%">'.$test_weight.$test_weight2.'</td>';
						}
						else{
							$para_table.='<td style="border:1px solid #dedede !important;text-align:center;" width="'.$wid.'%"></td>';
						}
					}
					elseif($testtype['assessment_type']=='INBASKET'){//$inb_test_id=UlsAssessmentTest::get_ass_position_inbasket_comp($_REQUEST['ass_id'],$_REQUEST['pos_id'],$result['comp_id'],'INBASKET');
						$ass_method_inbasket=""; 
						$inb_test_id=UlsMenu::callpdorow("SELECT d.level_scale,avg(b.scale_number) as required,avg(c.scale_number) as assessed,a.`position_id`,a.`employee_id`,a.`assessment_type`,a.`competency_id` FROM `uls_assessment_report_bytype` a inner join uls_level_master_scale b on a.`require_scale_id`=b.scale_id inner join uls_level_master_scale c on a.`assessed_scale_id`=c.scale_id inner join uls_level_master d on b.level_id=c.level_id WHERE `assessment_id`='".$_REQUEST['ass_id']."' and `employee_id`='$emp_id' and `position_id`='".$_REQUEST['pos_id']."' and competency_id='".$result['comp_id']."' and  assessment_type='INBASKET' group by `competency_id`, `assessment_type` ORDER BY `a`.`assessment_type` ASC, `a`.`competency_id` ASC ");
						if(!empty($inb_test_id['required'])){
							$chkcid=$result['comp_id'];$tot=1;
							if(isset($allcomp[$chkcid])){
								$allweight=0;
								foreach($allcomp[$chkcid] as $k=>$v){
									$allweight=$allweight+$allweights[$k];
								}
								$tot=$allweights['INBASKET']/$allweight;
							}
							$inb_weight2="";//@round($inb_test_id['assessed'],1).'-';
							$inb_weight=@round($inb_test_id['assessed']*$tot,2);//*($testtype['weightage']/100));
							$para_table.='<td style="border:1px solid #dedede !important;text-align:center;" width="'.$wid.'%">'.$inb_weight.$inb_weight2.'</td>';
						}
						else{
							//$multi=($multi+($testtype['weightage']/100));
							$para_table.='<td style="border:1px solid #dedede !important;text-align:center;" width="'.$wid.'%"></td>';
						}
						
					}
					elseif($testtype['assessment_type']=='CASE_STUDY'){//$case_test_id=UlsAssessmentTest::get_ass_position_case_comp($_REQUEST['ass_id'],$_REQUEST['pos_id'],$result['comp_id'],'CASE_STUDY');
						$case_test_id=UlsMenu::callpdorow("SELECT d.level_scale,avg(b.scale_number) as required,avg(c.scale_number) as assessed,a.`position_id`,a.`employee_id`,a.`assessment_type`,a.`competency_id` FROM `uls_assessment_report_bytype` a inner join uls_level_master_scale b on a.`require_scale_id`=b.scale_id inner join uls_level_master_scale c on a.`assessed_scale_id`=c.scale_id inner join uls_level_master d on b.level_id=c.level_id WHERE `assessment_id`='".$_REQUEST['ass_id']."' and `employee_id`='$emp_id' and `position_id`='".$_REQUEST['pos_id']."' and competency_id='".$result['comp_id']."' and  assessment_type='CASE_STUDY' group by `competency_id`, `assessment_type` ORDER BY `a`.`assessment_type` ASC, `a`.`competency_id` ASC ");
						$ass_method_case="";
						if(!empty($case_test_id['required'])){
							$chkcid=$result['comp_id'];$tot=1;
							if(isset($allcomp[$chkcid])){
								$allweight=0;
								foreach($allcomp[$chkcid] as $k=>$v){
									$allweight=$allweight+$allweights[$k];
								}
								$tot=$allweights['CASE_STUDY']/$allweight;
							}
							$case_weight2="";//@round($case_test_id['assessed'],1).'-';
							$case_weight=@round($case_test_id['assessed']*$tot,2);//*($testtype['weightage']/100);
							$para_table.='<td style="border:1px solid #dedede !important;text-align:center;" width="'.$wid.'%">'.$case_weight.$case_weight2.'</td>';
						}
						else{
							//$multi=($multi+($testtype['weightage']/100));
							$para_table.='<td style="border:1px solid #dedede !important;text-align:center;" width="'.$wid.'%"></td>';
						}
						
					}
					elseif($testtype['assessment_type']=='INTERVIEW'){
						$inter_test_id=UlsMenu::callpdorow("SELECT d.level_scale,avg(b.scale_number) as required,avg(c.scale_number) as assessed,a.`position_id`,a.`employee_id`,a.`assessment_type`,a.`competency_id` FROM `uls_assessment_report_bytype` a inner join uls_level_master_scale b on a.`require_scale_id`=b.scale_id inner join uls_level_master_scale c on a.`assessed_scale_id`=c.scale_id inner join uls_level_master d on b.level_id=c.level_id WHERE `assessment_id`='".$_REQUEST['ass_id']."' and `employee_id`='$emp_id' and `position_id`='".$_REQUEST['pos_id']."' and competency_id='".$result['comp_id']."' and  assessment_type='INTERVIEW' group by `competency_id`, `assessment_type` ORDER BY `a`.`assessment_type` ASC, `a`.`competency_id` ASC ");
						if(!empty($inter_test_id['required'])){
							$chkcid=$result['comp_id'];$tot=1;
							if(isset($allcomp[$chkcid])){
								$allweight=0;
								foreach($allcomp[$chkcid] as $k=>$v){
									$allweight=$allweight+$allweights[$k];
								}
								$tot=$allweights['INTERVIEW']/$allweight;
							}
							$int_weight2="";//@round($inter_test_id['assessed'],1).'-';
							$int_weight=@round($inter_test_id['assessed']*$tot,2);//*($testtype['weightage']/100);
							$para_table.='<td style="border:1px solid #dedede !important;text-align:center;" width="'.$wid.'%">'.$int_weight.$int_weight2.'</td>';
						}
						else{
							//$multi=($multi+($testtype['weightage']/100));
							$para_table.='<td style="border:1px solid #dedede !important;text-align:center;" width="'.$wid.'%"></td>';
						}
						/* $int_weight=(($ass_method_interview/4)*($testtype['weightage']/100));
						$para_table.='<td style="border:1px solid #dedede !important;" width="'.$wid.'%">'.$ass_method_interview.'</td>'; */
					}
					elseif($testtype['assessment_type']=='FEEDBACK'){
						$cpid=$result['comp_id'];
						$feed_test_id=UlsAssessmentTest::get_ass_position_test($_REQUEST['ass_id'],$_REQUEST['pos_id'],'FEEDBACK');
						$feedrate=UlsMenu::callpdorow("SELECT rating_scale FROM `uls_rating_master` WHERE `rating_id` in (SELECT `rating_id` FROM `uls_questionnaire_master` WHERE `ques_id` in (SELECT `ques_id` FROM `uls_assessment_test_feedback` WHERE `position_id`='".$_REQUEST['pos_id']."' and `assessment_id`='".$_REQUEST['ass_id']."' and `assessment_type`='FEEDBACK'))");
						
						$feed_comp=UlsMenu::callpdorow("SELECT avg(`rater_value`) as avg_rater_value FROM `uls_feedback_employee_rating` WHERE `assessment_id`=".$_REQUEST['ass_id']." and `ass_test_id`=".$feed_test_id['assess_test_id']." and `employee_id`=".$_REQUEST['emp_id']." and `giver_id`!=".$_REQUEST['emp_id']." and `element_competency_id`=".$result['comp_id']);
						$tot=1;
						if(isset($allcomp[$chkcid])){
							$allweight=0;
							foreach($allcomp[$chkcid] as $k=>$v){
								$allweight=$allweight+$allweights[$k];
							}
							$tot=$allweights['FEEDBACK']/$allweight;
						}
						$feed_weight=@(round(($feed_comp['avg_rater_value']/$feedrate['rating_scale'])*$allcompreq[$cpid],2))*$tot;//($testtype['weightage']/100));
						$feed_weights=!empty($feed_weight)?$feed_weight:0;
						$para_table.='<td style="border:1px solid #dedede !important;text-align:center;" width="'.$wid.'%">'.round($feed_weight,2).'</td>';
					}
				}
				$keyy=$result['comp_id'];
				$total_com=@round(($test_weight+$inb_weight+$case_weight+$int_weight+$feed_weight),2);
				//$over_all=@round(($total_com*count($testtypes)),2);
				$over_all_weight=@round(($total_com*($result['pos_com_weightage']/100)),2);
				$total_all_weight+=$over_all_weight;
				$cat_details=$categorys['category_id']."*".$categorys['name'];
				$cluster_wei[$cat_details]=isset($cluster_wei[$cat_details])?$cluster_wei[$cat_details]+$over_all_weight:$over_all_weight;
				$clu_wei[$categorys['category_id']]=isset($clu_wei[$categorys['category_id']])?$clu_wei[$categorys['category_id']]+$result['pos_com_weightage']:$result['pos_com_weightage'];
				$para_table.='<td style="border:1px solid #dedede !important;text-align:center;" style="width:10%">'.$total_com.'</td>
				<td style="border:1px solid #dedede !important;text-align:center;" style="width:10%">'.@round($allcompreq[$keyy],0).'</td></tr>';
				
				$kkcomp_id[$keyy]="C".($kkk);
				$kkreq_sid[$keyy]=@round($allcompreq[$keyy],0);//$result['req_val'];
				$kkass_sid[$keyy]=$total_com;
				$kkcomp_name[$keyy]=$result['comp_name'];
				$kkk++;
		}
	}
	$para_table.='</tbody></table><br style="clear:both;">';
	echo $para_table;