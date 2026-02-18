<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Create Assessment Manage</h6>
					</div>
					<div class="pull-right">
						<a href="<?php echo BASE_URL;?>/admin/assessor_assessment" target="_blank" class="btn btn-primary btn-xs pull-left mr-15">&nbsp <i class="fa fa-plus-circle"></i> Assessor Status Report &nbsp </a>
						<!--<a href="<?php echo BASE_URL;?>/admin/employee_training_need_report" target="_blank" class="btn btn-primary btn-xs pull-left mr-15">&nbsp <i class="fa fa-plus-circle"></i> Training Needs &nbsp </a>-->
						<a href="<?php echo BASE_URL;?>/admin/report_generation_data" target="_blank" class="btn btn-primary btn-xs pull-left mr-15">&nbsp <i class="fa fa-plus-circle"></i> Admin report generation status &nbsp </a>
						<a href="<?php echo BASE_URL;?>/admin/assessment_status_comp_report?id=1" target="_blank" class="btn btn-primary btn-xs pull-left mr-15">&nbsp <i class="fa fa-plus-circle"></i> Question Analaysis Data &nbsp </a>
						<!--<a href="<?php echo BASE_URL;?>/admin/feedback_assessment" target="_blank" class="btn btn-primary btn-xs pull-left mr-15">&nbsp <i class="fa fa-plus-circle"></i> Feedback Data &nbsp </a>-->
						<a href="<?php echo BASE_URL;?>/admin/assessment_final_data" target="_blank" class="btn btn-primary btn-xs pull-left mr-15">&nbsp <i class="fa fa-plus-circle"></i> Assessment Final Data &nbsp </a>
						<a href="<?php echo BASE_URL;?>/admin/assessment_creation?status" class="btn btn-primary btn-xs pull-left mr-15">&nbsp <i class="fa fa-plus-circle"></i> Create Assessment Manage &nbsp </a>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-body">
					<form action="" id="loginForm" class="searchForm" method="get">
						<div class="row">
							<!--<div class="col-md-3">								
								<div class="form-group col-lg-12">
									<label class="control-label mb-10 text-left">Assessment Cycle Type</label>
									<select class=" form-control m-b" id="assess_cycle_type" name="assess_cycle_type" style="width: 100%">
										<option value="">Select</option>
										<?php 
										foreach($pos_types as $pos_type){
											$dep_sel=isset($assess_cycle_type)?($assess_cycle_type==$pos_type['code'])?"selected='selected'":"":"";
											?>
												<option value="<?php echo $pos_type['code'];?>" <?php echo $dep_sel; ?>><?php echo $pos_type['name'];?></option>
											<?php } ?>
									</select>
								</div>
							</div>-->
							<div class="col-md-3">						
								<div class="form-group col-lg-12">
									<label class="control-label mb-10 text-left">Assessment Name</label>
									<input value="<?php echo @$assessment; ?>" id="assessment" class="form-control" name="assessment" type="text">
								</div>
							</div>
							<div class="form-group col-md-1">
								<div class="text-left">
									<label class="control-label mb-10 text-left">&nbsp;</label>
									<button class="btn btn-primary btn-sm">Search</button>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="hpanel">
					<div class="panel-body">
						<h6 class="txt-dark capitalize-font">Search Results</h6>
						<hr class="light-grey-hr">
						<div class="table-wrap">
							<div class="table-responsive">
								<div id="edit_datable_2_wrapper" class="dataTables_wrapper">
									<table cellpadding="1" cellspacing="1" id="edit_datable_2" class="table table-hover table-bordered mb-0">
										<thead>
											<tr>
												<th>Assessment Template</th>
												<th>Assessment Cycle Type</th>
												<th>Status</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($searchresults as $val){ ?>
											 <tr class="tooltip-demo" id="assessmentdel_<?php echo $val['assessment_id']; ?>">
												<td><?php echo @$val['assessment_name'];?></td>
												<td><?php echo @$val['asess_cycle_type'];?></td>
												<td><?php echo @$val['assessstatus'];?></td>
												<td>
												<?php 
												$link=($val['assessment_type']=='SELF')?'self_assessment_details':'assessment_details';
												$link_report=($val['assessment_type']=='SELF')?'self_assessment_report':'assessment_report';
												?>
												<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Details" href="<?php echo BASE_URL;?>/admin/<?php echo $link;?>?tab=1&id=<?php echo @$val['assessment_id'];?>&hash=<?php echo md5(SECRET.$val['assessment_id']);?>"><i class="fa fa-file text-primary1"></i> </a>
												<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Booklet Duplication" href="<?php echo BASE_URL;?>/admin/assessment_position_duplicate?id=<?php echo @$val['assessment_id'];?>&hash=<?php echo md5(SECRET.$val['assessment_id']);?>"><i class="fa fa-question-circle text-danger"></i> </a>
												<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Question Validation" href="<?php echo BASE_URL;?>/admin/assessment_question_validation?id=<?php echo @$val['assessment_id'];?>&hash=<?php echo md5(SECRET.$val['assessment_id']);?>"><i class="fa fa-question-circle text-warning"></i> </a>
												<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Question Adding" href="<?php echo BASE_URL;?>/admin/assessment_questionbank_validation?id=<?php echo @$val['assessment_id'];?>&hash=<?php echo md5(SECRET.$val['assessment_id']);?>"><i class="fa fa-question-circle text-warning"></i> </a>
												<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Reports" href="<?php echo BASE_URL;?>/admin/<?php echo $link_report; ?>?id=<?php echo @$val['assessment_id'];?>&hash=<?php echo md5(SECRET.$val['assessment_id']);?>"><i class="fa fa-street-view text-info"></i> </a>
												<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="<?php echo BASE_URL;?>/admin/assessment_view?id=<?php echo @$val['assessment_id'];?>&hash=<?php echo md5(SECRET.$val['assessment_id']);?>"><i class="fa fa-eye text-success"></i> </a>
												<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Update" href="<?php echo BASE_URL;?>/admin/assessment_creation?status&id=<?php echo @$val['assessment_id'];?>&hash=<?php echo md5(SECRET.$val['assessment_id']);?>"><i class="fa fa-edit text-primary"></i> </a>
												<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" id="<?php echo $val['assessment_id']; ?>" name="deleteassessment" rel="assessmentdel_<?php echo $val['assessment_id']; ?>" onclick="deletefunction(this)"><i class="fa fa-trash text-danger"></i> </a>
												<?php
												if($val['broadcast']!='P'){
													
													?>
													<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Employee Publish" id="<?php echo $val['assessment_id']; ?>" name="publishassessment" rel="assessmentdel_<?php echo $val['assessment_id']; ?>" onclick="assessmentfunction(this)"><i class="icon-rocket text-info"></i> </a>
													<?php 
													
												} ?>
												<?php
												/* if($val['ass_methods']=='N'){
													?>
													<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Employee TNI Mail Publish" id="<?php echo $val['assessment_id']; ?>" name="publishemployeeassessment" rel="assessmentdel_<?php echo $val['assessment_id']; ?>" onclick="assessmentfunction(this)"><i class="icon-rocket text-info"></i> </a>
													<?php 
													
												}
												else{
													if($val['broadcast']!='P'){
														
														?>
														<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Employee Assessment Publish" id="<?php echo $val['assessment_id']; ?>" name="publishassessment" rel="assessmentdel_<?php echo $val['assessment_id']; ?>" onclick="assessmentfunction(this)"><i class="icon-rocket text-info"></i> </a>
														<?php 
													} 
												} */
												?>
												<!--<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Feedback Givers Mails" id="<?php echo $val['assessment_id']; ?>" name="publishfeedbackassessment" rel="assessmentdel_<?php echo $val['assessment_id']; ?>" onclick="assessmentfunction(this)"><i class="icon-rocket text-info"></i> </a>
												<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Feedback Givers Reminder Mails" id="<?php echo $val['assessment_id']; ?>" name="publishfeedbackremindermails" rel="assessmentdel_<?php echo $val['assessment_id']; ?>" onclick="assessmentfunction(this)"><i class="icon-rocket text-info"></i> </a>-->
												<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Report" href="<?php echo BASE_URL;?>/admin/position_assessment_statusreport?id=<?php echo @$val['assessment_id'];?>&hash=<?php echo md5(SECRET.$val['assessment_id']);?>" target="_blank"><i class="fa fa-file-excel-o"></i> </a>
												<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Test Results Report" href="<?php echo BASE_URL;?>/admin/assessment_test_result_statusreport?id=<?php echo @$val['assessment_id'];?>&hash=<?php echo md5(SECRET.$val['assessment_id']);?>" target="_blank"><i class="fa fa-file-excel-o"></i> </a>
												<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Feedback Report" href="<?php echo BASE_URL;?>/admin/feedback_assessment_statusreport?id=<?php echo @$val['assessment_id'];?>&hash=<?php echo md5(SECRET.$val['assessment_id']);?>" target="_blank"><i class="fa fa-file-excel-o"></i> </a>
												<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Assessment FInal Report" href="<?php echo BASE_URL;?>/admin/assessment_final_report?id=<?php echo @$val['assessment_id'];?>&hash=<?php echo md5(SECRET.$val['assessment_id']);?>" target="_blank"><i class="fa fa-file-excel-o"></i> </a>
												<!--<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Assessment Data Report" href="<?php echo BASE_URL;?>/admin/assessment_data_report?ass_id=<?php echo @$val['assessment_id'];?>" target="_blank"><i class="fa fa-file-text-o"></i> </a>-->
												<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Feedback TNA Report" href="<?php echo BASE_URL;?>/admin/feedback_assessment_tna_feed_statusreport?id=<?php echo @$val['assessment_id'];?>&hash=<?php echo md5(SECRET.$val['assessment_id']);?>" target="_blank"><i class="fa fa-file-excel-o"></i> </a>
												<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Employee TNI Mapped" href="<?php echo BASE_URL;?>/admin/tni_assessment_mapped_empreport?id=<?php echo @$val['assessment_id'];?>&hash=<?php echo md5(SECRET.$val['assessment_id']);?>" target="_blank"><i class="fa fa-file-excel-o"></i> </a>
												<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="360 degree Feedback Report" href="<?php echo BASE_URL;?>/admin/seeker_feedback_assessment_report?id=<?php echo @$val['assessment_id'];?>&hash=<?php echo md5(SECRET.$val['assessment_id']);?>" target="_blank"><i class="fa fa-file-excel-o"></i> </a>
												<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="360 degree Feedback Giver Report" href="<?php echo BASE_URL;?>/admin/giver_feedback_assessment_report?id=<?php echo @$val['assessment_id'];?>&hash=<?php echo md5(SECRET.$val['assessment_id']);?>" target="_blank"><i class="fa fa-file-excel-o"></i> </a>
												<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="360 degree Report" href="<?php echo BASE_URL;?>/admin/final_assessment_report?id=<?php echo @$val['assessment_id'];?>&hash=<?php echo md5(SECRET.$val['assessment_id']);?>" target="_blank"><i class="fa fa-file-excel-o"></i> </a>
												<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Competency Test Report" href="<?php echo BASE_URL;?>/admin/position_assessment_status_report?id=<?php echo @$val['assessment_id'];?>&hash=<?php echo md5(SECRET.$val['assessment_id']);?>" target="_blank"><i class="fa fa-file-excel-o"></i> </a>
												<!--<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Assessment Overall Report" href="<?php echo BASE_URL;?>/admin/assessment_overallstatus_report?id=<?php echo @$val['assessment_id'];?>&hash=<?php echo md5(SECRET.$val['assessment_id']);?>" target="_blank"><i class="fa fa-file-excel-o"></i> </a>-->
												<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Assessment Interview Report" href="<?php echo BASE_URL;?>/admin/assessment_interview_status_report?id=<?php echo @$val['assessment_id'];?>&hash=<?php echo md5(SECRET.$val['assessment_id']);?>" target="_blank"><i class="fa fa-file-excel-o"></i> </a>
												<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Assessment Competency Overall Report" href="<?php echo BASE_URL;?>/admin/assessment_comp_overall_report?id=<?php echo @$val['assessment_id'];?>&hash=<?php echo md5(SECRET.$val['assessment_id']);?>" target="_blank"><i class="fa fa-file-excel-o"></i> </a>
												</td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
									<?php echo $pagination; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php foreach($searchresults as $val){ ?>
<div id="workinfoview<?php echo $val['assessment_id']; ?>"  class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="color-line"></div>
			<div class="modal-header">
				<h6 class="modal-title">Assessment Broadcast</h6>
			</div>
			<div class="modal-body">
				<div id="workinfodetails<?php echo $val['assessment_id']; ?>" class="modal-body no-padding">
				
				</div>
			</div>
			
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

<?php } ?>