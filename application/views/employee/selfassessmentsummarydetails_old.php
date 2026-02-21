<script>
<?php
foreach($_REQUEST as $key=>$val){
	if($key=="status"){
		echo "var ".$key."='".$val."';";
	}
}
?>
</script>
<div class="content">
    <div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				
				<div class="panel-body">
					<ul class="nav nav-pills">
						<?php
						if(count($rating_count)>0){
						?>
							<li id='compentencies_li' class="active"><a data-toggle="tab" href="#tab-compentencies">Self Assessment</a></li>
							<li id='employees_li' ><a data-toggle="tab" href="#tab-employees">Career Planning</a></li>
							<li id='strengths_li' ><a data-toggle="tab" href="#tab-strengths">Strengths</a></li>
							<li id='development_li'><a data-toggle="tab" href="#tab-development">Development Planning</a></li>
						<?php
						}
						else{
						?>
							<li id='compentencies_li' class="active"><a data-toggle="tab" href="#tab-compentencies">Self Assessment</a></li>
							<li class="disabled" style="pointer-events:none;" ><a data-toggle="tab" href="#tab-employees">Career Planning</a></li>
							<li class="disabled" style="pointer-events:none;" ><a data-toggle="tab" href="#tab-strengths">Strengths</a></li>
							<li class="disabled" style="pointer-events:none;"><a data-toggle="tab" href="#tab-development">Development Planning</a></li>
						<?php
						}
						?>
						
					</ul>
					<div class="tab-content ">
						
						<div id="tab-compentencies" class="p-m tab-pane active">
							<div class='table-responsive'>
								<form action="<?php echo BASE_URL;?>/employee/self_summary_result_insert" method="post"  id="tab_summary_sumbit">
								<input type="hidden" name="parent_org_id" value="<?php echo $_SESSION['parent_org_id'];?>" >
								<input type="hidden" name="assessment_id" value="<?php echo $id;?>" >
								<input type="hidden" name="position_id" value="<?php echo $pos_id;?>" >
								<input type="hidden" name="employee_id" value="<?php echo $emp_id;?>" >
								<input type="hidden" name="ass_type" value="<?php echo $ass_type;?>" >
								<input type="hidden" name="ass_pos_id" value="<?php echo $ass_pos_id;?>" >
								<?php 
								foreach($comp_details as $comp_detail){
								?>
								<div class="panel-heading">
									<div class="pull-left">
										<h6 class="panel-title txt-dark"><?php echo $comp_detail['name']; ?></h6>
									</div>
									<div class="clearfix"></div>
								</div>
								<table cellpadding='1' cellspacing='1' class='table table-bordered table-striped' width="100%">
									<thead>
										<tr>
											<th style="width:20%">Competency name</th>
											<th  style="width:10%">Required Level</th>
											<th  style="width:10%">Self Assessed Level</th>
										</tr>
										
									</thead>
									<tbody>
										<?php
										$competency=UlsSelfAssessmentReport::getselfassessment_competencies_summary($id,$pos_id,$emp_id,$comp_detail['category_id']);
										foreach($competency as $competencys){
										?>
										<tr>
										<td scope='row'>
										<input type="hidden" name="self_report_id[]" value="<?php echo !empty($competencys['self_report_id'])?$competencys['self_report_id']:"";?>">
										<input type="hidden" name="competency[]" value="<?php echo $competencys['comp_def_id'];?>" >
										<a style="text-decoration: underline;" data-target="#workinfoviewadd<?php echo $competencys['comp_def_id']; ?>" data-toggle='modal' href='#workinfoviewadd<?php echo $competencys['comp_def_id']; ?>' onclick="open_comp_indicator(<?php echo $competencys['comp_def_id']; ?>,<?php echo $competencys['scale_id'];?>);"><?php echo $competencys['comp_def_name'];?></a></td>
										<td><input type="hidden" name="requiredlevel_<?php echo $competencys['comp_def_id'];?>" value="<?php echo $competencys['scale_id'];?>" >
										<a style="text-decoration: underline;" data-target="#workinfoviewadd_level<?php echo $competencys['comp_def_id']; ?>" data-toggle='modal' href='#workinfoviewadd_level<?php echo $competencys['comp_def_id']; ?>' onclick="open_comp_level(<?php echo $competencys['comp_def_id']; ?>);"><?php echo $competencys['scale_name'];?></a></td>
										
											<td>
											<?php $data="";
											$data="
											<select name='OVERALL_".$competencys['comp_def_id']."' id='OVERALL_".$competencys['comp_def_id']."' class='validate[required] form-control m-b' style='width:200px;'>
											<option value=''>Select</option>";
											$level_id=UlsCompetencyDefinition::viewcompetency($competencys['comp_def_id']);
											$scale_overall=UlsLevelMasterScale::levelscale($level_id['comp_def_level']);
											foreach($scale_overall as $scales){
												$final_scale=!empty($competencys['assessed_scale_id'])?$competencys['assessed_scale_id']==$scales['scale_id']?"selected='selected'":"":"";
												$data.="<option value='".$scales['scale_id']."' ".$final_scale.">".$scales['scale_name']."</option>";
											}
											$data.="</select>";
											echo $data; ?>
											</td>
											
										</tr>
										<div id="workinfoviewadd<?php echo $competencys['comp_def_id']; ?>"  class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true">
											<div class="modal-dialog modal-lg">
												<div class="modal-content">
													<div class="color-line"></div>
													<div class="modal-header">
														<h6 class="modal-title">Competency Indicator</h6>
													</div>
													<div class="modal-body">
														<div id="indicator_comp<?php echo $competencys['comp_def_id']; ?>" class="modal-body no-padding">
														
														</div>
													</div>
													
												</div><!-- /.modal-content -->
											</div><!-- /.modal-dialog -->
										</div>
										<div id="workinfoviewadd_level<?php echo $competencys['comp_def_id']; ?>"  class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true">
											<div class="modal-dialog modal-lg">
												<div class="modal-content">
													<div class="color-line"></div>
													<div class="modal-header">
														<h6 class="modal-title">Level Details</h6>
													</div>
													<div class="modal-body">
														<div id="level_comp<?php echo $competencys['comp_def_id']; ?>" class="modal-body no-padding">
														
														</div>
													</div>
													
												</div><!-- /.modal-content -->
											</div><!-- /.modal-dialog -->
										</div>
										<?php } ?>
									</tbody>
								</table>
								<?php } ?>
								<?php
								if($_REQUEST['ass_type']=='IS'){
								?>
								<div class="panel-heading">
									<div class="pull-left">
										<h6 class="panel-title txt-dark">Development Plan</h6>
									</div>
									<div class="clearfix"></div>
								</div>
								<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-comment-text mr-10"></i>Knowledge</h6>
								<hr class="light-grey-hr">
								<div class="form-group">
									<input type="hidden" name="self_dev_report_id" value="<?php echo !empty($competency_dev['self_dev_report_id'])?$competency_dev['self_dev_report_id']:"";?>">
									<textarea rows="4" name="knowledge_dev" id="knowledge_dev" placeholder="Knowledge" class="validate[required] form-control"><?php echo !empty($competency_dev['knowledge_dev'])?$competency_dev['knowledge_dev']:"";?></textarea>
								</div>
								<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-comment-text mr-10"></i>Skill</h6>
								<hr class="light-grey-hr">
								<div class="form-group">
									<textarea rows="4" name="skill_dev" id="skill_dev" placeholder="Skill"  class="validate[required] form-control"><?php echo !empty($competency_dev['skill_dev'])?$competency_dev['skill_dev']:"";?></textarea>
								</div>
								<?php 
								}
								if(count($competency)>0){ ?>
								<hr class="light-grey-hr">
								<div class="form-group">
									<div class="col-sm-offset-9">
									   <button class="btn btn-danger btn-sm" type="button" onclick="createmp_link('employee_self_assessment')"><i class="fa fa-reply"></i> <span class="bold">Cancel</span></button>
									   <button class="btn btn-primary btn-sm" type="submit" name="summary_info_submit" id="summary_info_submit"><i class="fa fa-check"></i> Submit</button>
									</div>
								</div>
							
								<?php } ?>
								</form>
								<div class="seprator-block"></div>
							</div>
						
						</div>
						<div id="tab-employees" class="p-m tab-pane">
							<div class="panel-body">
								<div class="form-wrap">
									<form action="<?php echo BASE_URL;?>/employee/self_summary_result_insert_career" method="post"  id="tab_summary_sumbit">
										<input type="hidden" name="parent_org_id" value="<?php echo $_SESSION['parent_org_id'];?>" >
										<input type="hidden" name="assessment_id" value="<?php echo $id;?>" >
										<input type="hidden" name="position_id" value="<?php echo $pos_id;?>" >
										<input type="hidden" name="employee_id" value="<?php echo $emp_id;?>" >
										<input type="hidden" name="ass_type" value="<?php echo $ass_type;?>" >
										<input type="hidden" name="ass_pos_id" value="<?php echo $ass_pos_id;?>" >
										<input type="hidden" name="self_dev_report_id" value="<?php echo !empty($competency_dev['self_dev_report_id'])?$competency_dev['self_dev_report_id']:"";?>">
										<div class="form-group">
											<label class="control-label mb-10 text-left">Short Term Goals<sup><font color="#FF0000">*</font></sup>:</label>
											<textarea rows="5" class="form-control" name="short_term_goals" id="short_term_goals"><?php echo !empty($competency_dev['short_term_goals'])?$competency_dev['short_term_goals']:"";?></textarea>
										</div>
										<div class="form-group">
											<label class="control-label mb-10 text-left">Medium Term Goals<sup><font color="#FF0000">*</font></sup>:</label>
											<textarea rows="5" class="form-control" name="medium_term_goals" id="medium_term_goals"><?php echo !empty($competency_dev['medium_term_goals'])?$competency_dev['medium_term_goals']:"";?></textarea>
										</div>
										<div class="form-group">
											<label class="control-label mb-10 text-left">Long Term Goals<sup><font color="#FF0000">*</font></sup>:</label>
											<textarea rows="5" class="form-control" name="long_term_goals" id="long_term_goals"><?php echo !empty($competency_dev['long_term_goals'])?$competency_dev['long_term_goals']:"";?></textarea>
										</div>
										
										<hr class="light-grey-hr">
										<div class="form-group">
											<div class="col-sm-offset-9">
											   <button class="btn btn-danger btn-sm" type="button" onclick="createmp_link('employee_self_assessment')"><i class="fa fa-reply"></i> <span class="bold">Cancel</span></button>
											   <button class="btn btn-primary btn-sm" type="submit" name="submit" id="submit"><i class="fa fa-check"></i> Submit</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div id="tab-strengths" class="p-m tab-pane">
							<div class='table-responsive'>
								<form action="<?php echo BASE_URL;?>/employee/self_summary_result_insert_strength" method="post"  id="tab_strengths_sumbit">
								<input type="hidden" name="parent_org_id" value="<?php echo $_SESSION['parent_org_id'];?>" >
								<input type="hidden" name="assessment_id" value="<?php echo $id;?>" >
								<input type="hidden" name="position_id" value="<?php echo $pos_id;?>" >
								<input type="hidden" name="employee_id" value="<?php echo $emp_id;?>" >
								<input type="hidden" name="ass_type" value="<?php echo $ass_type;?>" >
								<input type="hidden" name="ass_pos_id" value="<?php echo $ass_pos_id;?>" >
								<?php 
								foreach($comp_details as $comp_detail){
								?>
								<div class="panel-heading">
									<div class="pull-left">
										<h6 class="panel-title txt-dark"><?php echo $comp_detail['name']; ?></h6>
									</div>
									<div class="clearfix"></div>
								</div>
								<table cellpadding='1' cellspacing='1' class='table table-bordered table-striped' width="100%">
									<thead>
										<tr>
											<th style="width:20%">Competency name</th>
											<th style="width:10%">Strengths<sup><font color="#FF0000">*</font></sup></th>
										</tr>
										
									</thead>
									<tbody>
										<?php
										$competency=UlsSelfAssessmentReport::getselfassessment_competencies_summary($id,$pos_id,$emp_id,$comp_detail['category_id']);
										foreach($competency as $competencys){
										?>
										<tr>
										<td scope='row'>
										<input type="hidden" name="self_report_id[]" value="<?php echo !empty($competencys['self_report_id'])?$competencys['self_report_id']:"";?>">
										<input type="hidden" name="competency[]" value="<?php echo $competencys['comp_def_id'];?>" >
										<?php echo $competencys['comp_def_name'];?></td>
										
										
											<td>
											<?php $data="";
											$data="
											<select name='strengths_".$competencys['comp_def_id']."' id='strengths_".$competencys['comp_def_id']."' class='validate[required] form-control m-b' style='width:200px;'>
											<option value=''>Select</option>";
											foreach($yesstat as $yesstats){
												$final_scale=!empty($competencys['strengths'])?$competencys['strengths']==$yesstats['code']?"selected='selected'":"":"";
												$data.="<option value='".$yesstats['code']."' ".$final_scale.">".$yesstats['name']."</option>";
											}
											$data.="</select>";
											echo $data; ?>
											</td>
											
										</tr>
										
										
										<?php } ?>
									</tbody>
								</table>
								<?php } ?>
								<hr class="light-grey-hr">
								<div class="form-group">
									<div class="col-sm-offset-9">
									   <button class="btn btn-danger btn-sm" type="button" onclick="createmp_link('employee_self_assessment')"><i class="fa fa-reply"></i> <span class="bold">Cancel</span></button>
									   <button class="btn btn-primary btn-sm" type="submit" name="submit" id="submit"><i class="fa fa-check"></i> Submit</button>
									</div>
								</div>
								</form>
							</div>
						</div>
						<div id="tab-development" class="p-m tab-pane">
							<div class='table-responsive'>
								<form action="<?php echo BASE_URL;?>/employee/self_summary_result_insert_development" method="post"  id="tab_strengths_sumbit">
								<input type="hidden" name="parent_org_id" value="<?php echo $_SESSION['parent_org_id'];?>" >
								<input type="hidden" name="assessment_id" value="<?php echo $id;?>" >
								<input type="hidden" name="position_id" value="<?php echo $pos_id;?>" >
								<input type="hidden" name="employee_id" value="<?php echo $emp_id;?>" >
								<?php 
								foreach($comp_details as $comp_detail){
								?>
								<div class="panel-heading">
									<div class="pull-left">
										<h6 class="panel-title txt-dark"><?php echo $comp_detail['name']; ?></h6>
									</div>
									<div class="clearfix"></div>
								</div>
								<table cellpadding='1' cellspacing='1' class='table table-bordered table-striped' width="100%">
									<thead>
										<tr>
											<th style="width:20%">Competency name</th>
											<th style="width:15%">Knowledge/Skill</th>
											<th style="width:15%">Method</th>
											<th style="width:15%">Org Support Req</th>
											<th style="width:17%">Target Date</th>
											<th style="width:18%">Competition Evidence</th>
										</tr>
										
									</thead>
									<tbody>
										<?php
										$competency=UlsSelfAssessmentReport::getselfassessment_competencies_summary($id,$pos_id,$emp_id,$comp_detail['category_id']);
										foreach($competency as $competencys){
										?>
										<tr>
											<td scope='row'>
											<input type="hidden" name="self_report_id[]" value="<?php echo !empty($competencys['self_report_id'])?$competencys['self_report_id']:"";?>">
											<input type="hidden" name="competency[]" value="<?php echo $competencys['comp_def_id'];?>" >
											<?php echo $competencys['comp_def_name'];?></td>
											<td><input type="text" class="form-control" name="knowledge_skill_<?php echo $competencys['comp_def_id'];?>" id="knowledge_skill_<?php echo $competencys['comp_def_id'];?>" value="<?php echo !empty($competencys['knowledge_skill'])?$competencys['knowledge_skill']:"";?>"></td>
											<td>
												<select name='method_<?php echo $competencys['comp_def_id'];?>' id='method_<?php echo $competencys['comp_def_id'];?>' class='form-control m-b'>
												<option value=''>Select</option>
												<?php 
												foreach($dev_method as $dev_methods){
													$method_dev=!empty($competencys['method'])?$competencys['method']==$dev_methods['code']?"selected='selected'":"":"";
												?>
												<option value='<?php echo $dev_methods['code']; ?>' <?php echo $method_dev; ?>><?php echo $dev_methods['name']; ?></option>
												<?php
												}
												?>
												</select>
											</td>
											<td><input type="text" class="form-control" name='org_support_<?php echo $competencys['comp_def_id'];?>' id='org_support_<?php echo $competencys['comp_def_id'];?>' value="<?php echo !empty($competencys['org_support'])?$competencys['org_support']:"";?>"></td>
											<td>
												<div class="input-group date datepicker">
													<input type="text" class="validate[custom[date2]] form-control" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="target_date_<?php echo $competencys['comp_def_id'];?>" id="target_date_<?php echo $competencys['comp_def_id'];?>" value="<?php echo ($competencys['target_date']!='1970-01-01')?(!empty($competencys['target_date'])?$competencys['target_date']:""):"";?>">
													<span class="input-group-addon">
														<span class="fa fa-calendar"></span>
													</span>
												</div>
											</td>
											<td><input type="text" class="form-control" name="comp_evidence_<?php echo $competencys['comp_def_id'];?>" id="comp_evidence_<?php echo $competencys['comp_def_id'];?>" value="<?php echo !empty($competencys['comp_evidence'])?$competencys['comp_evidence']:"";?>"></td>
										</tr>
										
										
										<?php } ?>
									</tbody>
								</table>
								<?php } ?>
								<input type="hidden" name="self_dev_report_id" value="<?php echo !empty($competency_dev['self_dev_report_id'])?$competency_dev['self_dev_report_id']:"";?>">
								<div class="form-group">
									<label class="control-label mb-10 text-left">How would want to leverage on your Strengths.  Examples of leveraging on your strength could include, coaching some one, taking up special projects, becoming a team member to help groups/others, etc<sup><font color="#FF0000">*</font></sup>:</label>
									<textarea rows="5" class="form-control" name="leverage" id="leverage"><?php echo !empty($competency_dev['leverage'])?$competency_dev['leverage']:"";?></textarea>
								</div>
								<div class="form-group">
									<label class="control-label mb-10 text-left">Review: When do you want to review this development plan<sup><font color="#FF0000">*</font></sup>:</label>
									<select class="validate[required] form-control m-b" id="review" name="review" style="width: 40%">
										<option value="">Select</option>
										<?php
										foreach($review_method as $review_methods){
											$review_plan=!empty($competency_dev['review'])?$competency_dev['review']==$review_methods['code']?"selected='selected'":"":"";
										?>
										<option value="<?php echo $review_methods['code']; ?>" <?php echo $review_plan; ?>><?php echo $review_methods['name']; ?></option>
										<?php
										}
										?>		
									</select>
								</div>
								<div class="form-group">
									<label class="control-label mb-10 text-left">Have you discussed this development plan with your Reporting<sup><font color="#FF0000">*</font></sup>: </label>
									<select class="validate[required] form-control m-b" id="reporting" name="reporting" style="width: 40%">
										<option value="">Select</option>
										<?php
										foreach($yesstat as $yesstat_s){
											$review_plan=!empty($competency_dev['reporting'])?$competency_dev['reporting']==$yesstat_s['code']?"selected='selected'":"":"";
										?>
										<option value="<?php echo $yesstat_s['code']; ?>" <?php echo $review_plan; ?>><?php echo $yesstat_s['name']; ?></option>
										<?php
										}
										?>	
									</select>
									
								</div>
								<hr class="light-grey-hr">
								<div class="form-group">
									<div class="col-sm-offset-9">
									   <button class="btn btn-danger btn-sm" type="button" onclick="createmp_link('employee_self_assessment')"><i class="fa fa-reply"></i> <span class="bold">Cancel</span></button>
									   <button class="btn btn-primary btn-sm" type="submit" name="submit" id="submit"><i class="fa fa-check"></i> Submit</button>
									</div>
								</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>
