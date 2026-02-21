<style>
.popover {
	max-width: 650px;
}
</style>
<div class='col-md-12'>
	<!--<div class="panel panel-inverse card-view">
		<div class="panel-heading">-->
			<div class="clearfix"><br></div>
			<h5>Final Summary Details</h5>
		<!--</div>-->
		
		<div class="panel-body">
			<div class="">
			<?php
			
			//echo count($ass_rating);
			//if(count($ass_rating)==3){
			$inb=$case=$test=$interview=0;$feedback=0;
			if(!empty($ass_rating)){
				
				foreach($ass_rating as $ass_ratings){
					if(($ass_ratings['assessment_type']=='INBASKET')){
						if(!empty($ass_ratings['scale_id']) && !empty($ass_ratings['comments']) && $comp_status['total_count']!=0){
							$inb=1;
						}
					}
					if(($ass_ratings['assessment_type']=='CASE_STUDY')){
						if(!empty($ass_ratings['scale_id']) && !empty($ass_ratings['comments'])){
							$case=1;
						}
					}
					if(($ass_ratings['assessment_type']=='TEST')){
						if(!empty($ass_ratings['scale_id'])){
							$test=1;
						}
					}
					if(($ass_ratings['assessment_type']=='INTERVIEW')){
						if(!empty($ass_ratings['scale_id'])){
							$interview=1;
						}
					}
					if(($ass_ratings['assessment_type']=='Feedback')){
						if(!empty($ass_ratings['scale_id'])){
							$feedback=1;
						}
					}
				}
			}
			//echo $inb."-".$case."-".$test; || ($feedback==1)
			if(($inb==1) && ($case==1) || ( (($test==1) || ($interview==1)))){
			?>
				<div class='table-responsive'>
					<form action='' method='post' name="summary_sumbit" id="summary_sumbit" class="form-horizontal">
					<input type="hidden" name="parent_org_id" value="<?php echo $_SESSION['parent_org_id'];?>" >
					<input type="hidden" name="assessment_id" value="<?php echo $id;?>" >
					<input type="hidden" name="position_id" value="<?php echo $pos_id;?>" >
					<input type="hidden" name="employee_id" value="<?php echo $emp_id;?>" >
					<input type="hidden" name="assessor_id" value="<?php echo $_SESSION['asr_id'];?>" >
					<table cellpadding='1' cellspacing='1' class='table table-bordered table-striped' width="100%">
						<thead>
						<?php 
						$ass=(count($ass_test)==4)?6:5;
						?>
							<tr>
								<th rowspan='2' style="width:10%">Competency name</th>
								<th rowspan='2' style="width:10%">Required Level</th>
								<th colspan='<?php echo $ass; ?>' scope='colgroup' align='center' style="width:50%">Assessed Level</th>
							</tr>
							<tr>
								<?php 
								$ass_type=array();
								
								foreach($ass_test as $ass_tests){
									
									$ass_type[]=$ass_tests['assessment_type'];
									if($ass_tests['assessment_type']=='CASE_STUDY'){
										foreach($test_casestudy as $key=>$test_casestudys){
											$getpretest_case=UlsUtestAttemptsAssessment::getattemptvalus_inbasket($id,$emp_id,$test_casestudys['assess_test_id'],'CASE_STUDY',$test_casestudys['test_id']);
											//$getpretest_case['attempt_id'];
											$case_study=$test_casestudys['assessment_type']=='CASE_STUDY'?'Case Study':'';
											$casestudy=$case_study."-".($key+1);
										?>
											<th>
												<sup><font color="#FF0000">*</font></sup>
													<a data-target='#casestudy_rating<?php echo $getpretest_case['attempt_id'];?>' onclick='open_comp_indicator(<?php echo  $getpretest_case['attempt_id'];?>)' data-toggle='modal' href='#casestudy_rating<?php echo $getpretest_case['attempt_id'];?>'  style="color:#007bb6;text-decoration:underline"><?php echo $casestudy;?></a>
													<!--<div id='workinfoview_ind<?php echo $competencys['comp_def_id'];?>'  class='modal fade' tabindex='-1' role='dialog'  aria-hidden='true'>
														<div class='modal-dialog modal-lg'>
															<div class="modal-content">
																<div class="color-line"></div>
																<div class="modal-header">
																	<h6 class="modal-title">Competency Indicator</h6>
																</div>
																<div class="modal-body">
																	<div id="indicator_comp<?php echo $competencys['comp_def_id']; ?>" class="modal-body no-padding">
																	
																	</div>
																</div>
																
															</div>
														</div>
														
													</div>-->
											</th>
										<?php
										}
									}
									elseif($ass_tests['assessment_type']=='INBASKET'){
										foreach($test_inbasket as $key=>$test_inbaskets){
											$in_basket=$test_inbaskets['assessment_type']=='INBASKET'?'In-basket':'';
											$inbasket=$in_basket."-".($key+1);
										?>
											<th>
												<sup><font color="#FF0000">*</font></sup>
													<?php echo $inbasket;?>
											</th>
										<?php
										}
									}
									elseif($ass_tests['assessment_type']=='TEST'){
									?>
										<th><sup><font color="#FF0000">*</font></sup><?php echo ($ass_tests['assessment_type']=='TEST')?'Test':''; ?></th>
									<?php
									}
									elseif($ass_tests['assessment_type']=='INTERVIEW'){
									?>
										<th><sup><font color="#FF0000">*</font></sup><?php echo ($ass_tests['assessment_type']=='INTERVIEW')?'INTERVIEW':''; ?></th>
									<?php
									}
									elseif($ass_tests['assessment_type']=='FEEDBACK'){
									?>
										<th>Self Feedback</th>
										<th>Others Feedback</th>
									<?php
									}
								}
								?>
								<th style="width:30%"><sup><font color="#FF0000">*</font></sup><a href="#" data-target='#overalldev' href='#overalldev' data-toggle='modal'  onclick="getoveralldevelop(<?php echo "'".$id."','".$pos_id."','".$emp_id."'"; ?>)"><code style="color:#007bb6;text-decoration:underline;">Over All</code></a>
										<div id='overalldev' class='modal fade' tabindex='-1' role='dialog'  aria-hidden='true'>
											<div class='modal-dialog modal-lg' style="width:1200px;">
												<div class='modal-content'>
													<div class='color-line'></div>												
													<?php echo "<div class='modal-body no-padding'><button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button><div id='overalldevdet'></div></div>"; ?>
												</div>
											</div>
								</div><sup><font color="#FF0000">*</font></sup> Development </th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach($competency as $competencys){
							?>
							<tr style="valign:top">
							<th scope='row'>
							<input type="hidden" name="report_id[]" value="<?php echo !empty($competencys['report_id'])?$competencys['report_id']:"";?>">
							<input type="hidden" name="competency[]" value="<?php echo $competencys['comp_def_id'];?>" >
							<!--<a data-target='#workinfoview_ind<?php echo $competencys['comp_def_id'];?>' onclick='open_comp_indicator(<?php echo  $competencys['comp_def_id'];?>,<?php echo  $competencys['req_scale_id'];?>)' data-toggle='modal' href='#workinfoview_ind<?php echo $competencys['comp_def_id'];?>'  style="color:#007bb6;text-decoration:underline"><?php echo $competencys['comp_def_name'];?></a>-->
							<?php echo $competencys['comp_def_name'];?>
							</th>
							<div id='workinfoview_ind<?php echo $competencys['comp_def_id'];?>'  class='modal fade' tabindex='-1' role='dialog'  aria-hidden='true'>
								<div class='modal-dialog modal-lg'>
									<div class="modal-content">
										<div class="color-line"></div>
										<div class="modal-header">
											<h6 class="modal-title">Competency Indicator</h6>
										</div>
										<div class="modal-body">
											<div id="indicator_comp<?php echo $competencys['comp_def_id']; ?>" class="modal-body no-padding">
											
											</div>
										</div>
										
									</div>
								</div><!-- /.modal-dialog -->
								
							</div>
							<div id='workinfoview<?php echo $competencys['comp_def_id'];?>'  class='modal fade' tabindex='-1' role='dialog'  aria-hidden='true'>
								<div class='modal-dialog modal-lg' style="width:1200px;">
									<div class='modal-content'>
										<div class='color-line'></div>
										<div id='workinfodetails<?php echo $competencys['comp_def_id'];?>' class='modal-body no-padding'>
											
										</div>
										
									</div><!-- /.modal-content -->
								</div><!-- /.modal-dialog -->
							</div>
							<td><input type="hidden" name="requiredlevel_<?php echo $competencys['comp_def_id'];?>" id="requiredlevel_<?php echo $competencys['comp_def_id'];?>" value="<?php echo $competencys['req_scale_id'];?>" ><?php echo $competencys['req_scale_name'];?></td>
							<?php
							
							foreach($ass_test as $ass_tests){
								if($ass_tests['assessment_type']=='CASE_STUDY'){
									foreach($test_casestudy as $key=>$test_casestudys){
										$flag1=0;
										if(!empty($competencys['report_id']) && !empty($competencys['comp_def_id'])){
										$report_comp=UlsAssessmentReportBytype::summary_details_count($competencys['report_id'],$ass_tests['assessment_type'],$competencys['comp_def_id'],$test_casestudys['case_assess_test_id']);
										
										foreach($report_comp as $report_compss){
											
											if($report_compss['competency_id']==$competencys['comp_def_id']){
												//echo "Reached";
											$flag1=1;
											$scale=UlsLevelMasterScale::levelscale_detail($report_compss['assessed_scale_id']);
											?>
											<td><?php echo $scale['scale_name'];?></td>
											<?php
											}
											else{
												echo "<td></td>";
											}
										}
										}
										if($flag1==0){
										//foreach($test_casestudy as $key=>$test_casestudys){
											
											echo "<td></td>";
											//}
										}
									}	
								}
								elseif($ass_tests['assessment_type']=='INBASKET'){
									foreach($test_inbasket as $key=>$test_inbaskets){
										$flag2=0;
										if(!empty($competencys['report_id']) && !empty($competencys['comp_def_id'])){
										$report_comp=UlsAssessmentReportBytype::summary_details_inbasket_count($competencys['report_id'],$ass_tests['assessment_type'],$competencys['comp_def_id'],$test_inbaskets['inb_assess_test_id']);
										
										foreach($report_comp as $report_compss){
											
											if($report_compss['competency_id']==$competencys['comp_def_id']){
												//echo "Reached";
											$flag2=1;
											$scale=UlsLevelMasterScale::levelscale_detail($report_compss['assessed_scale_id']);
											?>
											<td><?php echo @$scale['scale_name'];?></td>
											<?php
											}
											else{
												echo "<td></td>";
											}
										}
										}
										if($flag2==0){
										//foreach($test_casestudy as $key=>$test_casestudys){
											
											echo "<td></td>";
											//}
										}
									}	
								}
								elseif($ass_tests['assessment_type']=='TEST'){
									$flag=0;
									if(!empty($competencys['report_id']) && !empty($competencys['comp_def_id'])){
									$report_comp=UlsAssessmentReportBytype::summary_detail_info($competencys['report_id'],$competencys['comp_def_id']);
									$flag=0;
									//echo count($report_comp);
									if(!empty($report_comp)){
									foreach($report_comp as $report_comps){
										if($report_comps['assessment_type']==$ass_tests['assessment_type']){
											//echo $report_comps['assessed_scale_id'];
											$flag=1;
											$scale=UlsLevelMasterScale::levelscale_detail($report_comps['assessed_scale_id']);
											
											$testdetails=UlsUtestAttemptsAssessment::gettestasstest($id,$emp_id);
											$comp_question=UlsAssessmentTestQuestions::gettestquestionsbycomp($testdetails['event_id'],$testdetails['test_id'],$testdetails['test_type'],$emp_id,$testdetails['assessment_id'],$competencys['comp_def_id']);
										?>
										<td><a href="#" data-target='#testquesdet<?php echo $competencys['comp_def_id']; ?>' href='#testquesdet<?php echo $competencys['comp_def_id']; ?>' data-toggle='modal'  onclick="gettestquestion(<?php echo "'".$comp_question['comp_def_id']."','".$testdetails['event_id']."','".$emp_id."','".$testdetails['assessment_id']."','".$comp_question['q_id']."'"; ?>)"><code style="color:#007bb6;text-decoration:underline;"><?php echo $scale['scale_name'];?></code></a>
										<div id='testquesdet<?php echo $competencys['comp_def_id'];?>' class='modal fade' tabindex='-1' role='dialog'  aria-hidden='true'>
											<div class='modal-dialog modal-lg' style="width:1200px;">
												<div class='modal-content'>
													<div class='color-line'></div>												
													<?php echo "<div class='modal-body no-padding'><button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button><div id='testques".$competencys['comp_def_id']."'></div></div>"; ?>
												</div>
											</div>
										</div>
										</td>
										
										<?php 
										}
										?>
										
									<?php 
									}
									}
									}
									if($flag==0){
										echo "<td></td>";
									}
									
								}
								elseif($ass_tests['assessment_type']=='INTERVIEW'){
									$report_comp=UlsAssessmentReportBytype::summary_detail_info($competencys['report_id'],$competencys['comp_def_id']);
									$flag3=0;
									//echo count($report_comp);
									foreach($report_comp as $report_comps){
										if($report_comps['assessment_type']==$ass_tests['assessment_type']){
											//echo $report_comps['assessed_scale_id'];
											$flag3=1;
											$scale=UlsLevelMasterScale::levelscale_detail($report_comps['assessed_scale_id']);
										?>
										<td><?php echo $scale['scale_name'];?></td>
										
										<?php 
										}
										?>
										
									<?php 
									}
									if($flag3==0){
										echo "<td></td>";
									}
								}
								elseif($ass_tests['assessment_type']=='FEEDBACK'){
									$selffeedrate=UlsFeedbackEmployeeRating::getselffeedbackasscomp($emp_id,$competencys['comp_def_id'],$id);
									$otherfeedrate=UlsFeedbackEmployeeRating::getothersfeedbackasscomp($emp_id,$competencys['comp_def_id'],$id);
									$selffeedrateelements=UlsFeedbackEmployeeRating::getselffeedbackasscompelement($emp_id,$competencys['comp_def_id'],$id);
									$otherfeedrateelements=UlsFeedbackEmployeeRating::getothersfeedbackasscompelement($emp_id,$competencys['comp_def_id'],$id);
									?>
									<div id='feedbackrating<?php echo $competencys['comp_def_id'];?>'  class='modal fade' tabindex='-1' role='dialog'  aria-hidden='true'>
										<div class='modal-dialog modal-lg' style="width:1200px;">
											<div class='modal-content'>
												<div class='color-line'></div>
												
												<?php echo "<div class='modal-body no-padding'><button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>";
												foreach($selffeedrateelements as $k=>$elements){
													if($k==0){ echo "<strong>".$elements['comp_def_name']."<br> Self Feedback</strong><br>"; }
													echo "Rating is ".round($elements['val'],1)." for ".$elements['element_id_edit']."<br>";
												}
												foreach($otherfeedrateelements as $k=>$elements){
													if($k==0){ echo "<strong>Others Feedback</strong><br>"; }
													echo "Rating is ".round($elements['val'],1)." for ".$elements['element_id_edit']."<br>";
												}

												echo "</div>"; ?>
												
											</div><!-- /.modal-content -->
										</div><!-- /.modal-dialog -->
									</div>
									<?php
									if(isset($selffeedrate['val'])){echo "<td><a data-target='#feedbackrating".$competencys['comp_def_id']."' href='#feedbackrating".$competencys['comp_def_id']."' data-toggle='modal'><code style='color:#007bb6;text-decoration:underline;'>".round($selffeedrate['val'],1)."</code></a></td>";}else{echo "<td>-</td>";}
									if(isset($otherfeedrate['val'])){echo "<td><a data-target='#feedbackrating".$competencys['comp_def_id']."' href='#feedbackrating".$competencys['comp_def_id']."' data-toggle='modal'><code style='color:#007bb6;text-decoration:underline;'>".round($otherfeedrate['val'],1)."</code></a></td>";}else{echo "<td>-</td>";}
									
									}
								
							}							
								 ?>
								
								<td>
								<?php $data="";
								$data="
								<select name='OVERALL_".$competencys['comp_def_id']."' id='OVERALL_".$competencys['comp_def_id']."' class='form-control m-b' style='width:180px;' onchange='open_alert_summary(".$competencys['comp_def_id'].")'>
								<option value=''>Select</option>";
								$level_id=UlsCompetencyDefinition::viewcompetency($competencys['comp_def_id']);
								$scale_overall=UlsLevelMasterScale::levelscale($level_id['comp_def_level']);
								foreach($scale_overall as $scales){
									$final_scale=!empty($competencys['final_scaled_id'])?$competencys['final_scaled_id']==$scales['scale_id']?"selected='selected'":"":"";
									$data.="<option value='".$scales['scale_id']."' ".$final_scale.">".$scales['scale_name']."</option>";
								}
								$data.="</select>";
								echo $data; ?>
								<br>
								<a data-target='#workinfoview<?php echo $competencys['comp_def_id'];?>' onclick='open_migration_maps(<?php echo  $competencys['comp_def_id'];?>,<?php echo  $competencys['req_scale_id'];?>)' data-toggle='modal' href='#workinfoview<?php echo $competencys['comp_def_id'];?>'><code style="color:#007bb6;text-decoration:underline;">Development Road Map</code></a>
								<!--<textarea rows="5" name="development_<?php echo $competencys['comp_def_id'];?>" class="validate[groupRequired[payments]]" data-prompt-position="topLeft" style="width:100%;"><?php echo !empty($competencys['development_area'])?$competencys['development_area']:""; ?></textarea>-->
								<?php 
								if(!empty($competencys['final_scaled_id'])){
									if($competencys['req_scale_id']>=$competencys['final_scaled_id']){
										$val_req="validate[required,minSize[100]]";
									}
									else{
										$val_req="";
									}
								}
								else{
									$val_req="";
								}
								?>
							<textarea rows="5" name="development_<?php echo $competencys['comp_def_id'];?>"  data-prompt-position="topLeft" style="width:100%;" class="<?php echo $val_req; ?>" id="development_<?php echo $competencys['comp_def_id'];?>"><?php echo !empty($competencys['development_area'])?$competencys['development_area']:""; ?></textarea>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					<?php
					$rating=UlsRatingMasterScale::ratingscale(5);
					?>
					<br>
					
					<div class='form-group'>
						<label class='col-sm-1 control-label'>Rating<sup><font color='#FF0000'>*</font></sup>:</label>
						<div class='col-sm-6'>
							<select class='form-control' name='scale_id' id='scale_id'>
								<option value=''>Select</option>
								<?php
								foreach($rating as $ratings){
									$rat_sel=!empty($ass_rating_final['scale_id'])?($ass_rating_final['scale_id']==$ratings['scale_id']?'selected="selected"':''):'';
									?>
									<option value='<?php echo $ratings['scale_id'];?>' <?php echo $rat_sel;?>><?php echo $ratings['rating_name_scale'];?></option>
									<?php
								}
								?>
							</select>
						</div>
					</div>
					<br>
					<div class='form-group'>
						<label class='col-sm-1 control-label'>Strengths<sup><font color='#FF0000'>*</font></sup>:</label>
						<?php $strength=!empty($ass_rating_final['strength'])?$ass_rating_final['strength']:''; ?>
						<div class='col-sm-6'><textarea class='form-control' type='text' name='strength' id='strength'><?php echo $strength;?></textarea></div>
					</div>
					<br>
					<div class='form-group'>
						<label class='col-sm-1 control-label'>OFISs<sup><font color='#FF0000'>*</font></sup>:</label>
						<?php $ofiss=!empty($ass_rating_final['ofiss'])?$ass_rating_final['ofiss']:''; ?>
						<div class='col-sm-6'><textarea class='form-control' type='text' name='ofiss' id='ofiss'><?php echo $ofiss;?></textarea></div>
					</div>
					<br>
					<div class='form-group'>
						<label class='col-sm-1 control-label'>Comments<sup><font color='#FF0000'>*</font></sup>:</label>
						<?php $comments=!empty($ass_rating_final['comments'])?$ass_rating_final['comments']:'';?>
						<div class='col-sm-6'><textarea placeholder='placeholder' class='form-control' type='text' name='comments' id='comments'><?php echo $comments;?></textarea></div>
					</div>
					<?php if(count($competency)>0){
						$final_scale_dis=!empty($ass_rating_final['final_id'])?'disabled':'';
						//<?php echo $final_scale_dis; 
						?>
					<div class="text-right  m-t-xs">
						<button class="btn btn-warning" type="button" name="summary_info_save" id="summary_info_save" <?php echo $final_scale_dis; ?>><i class="fa fa-check"></i> Save</button>
						<button class="btn btn-primary " type="button" name="summary_info_submit" id="summary_info_submit" ><i class="fa fa-check"></i> Submit</button>
					</div>
					<?php } ?>
					</form>
				</div>
				<?php 
			}
			else{
			?>
			<div class="alert alert-danger alert-dismissable">
				<i class="zmdi zmdi-block pr-15 pull-left"></i><p class="pull-left">Sorry! All Methods Evaluation is not Completed.</p>
				<div class="clearfix"></div>
			</div>
			<?php
			}
			?>
			</div>
		</div>
	<!--</div>-->
</div>