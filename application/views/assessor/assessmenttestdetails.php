<style>
.skin-option {
        position: fixed;
        text-align: center;
        right: -1px;
        padding: 10px;
        top: 80px;
        width: 150px;
        height: 133px;
        text-transform: uppercase;
        background-color: #ffffff;
        box-shadow: 0 1px 10px 0px rgba(0, 0, 0, 0.05), 10px 12px 7px 3px rgba(0, 0, 0, .1);
        border-radius: 4px 0 0 4px;
        z-index: 100;
    }
	.modal-lg {
		width: 1000px;
	}
	.chat-users, .chat-statistic {
		margin-left: -10px;
	}
	.modal-dialog {
		margin-top: 14px;
	}
	.modal-header {
		background: #f7f9fa none repeat scroll 0 0;
		padding: 6px 0px;
	}
	.chat-users, .chat-discussion {
		height: 400px;
		overflow-y: auto;
	}
	.chat-discussion {
		padding: 16px 19px;
	}
	.modal:nth-of-type(even) {
		z-index: 1062 !important;
	}
	.modal-backdrop.show:nth-of-type(even) {
		z-index: 1061 !important;
	}
	.interviewmodel{
		overflow-y:scroll;
	}
</style>
<?php
if($ass_details['assessment_type']=='INBASKET'){
	$ass_detail_inbasket=UlsAssessmentTestInbasket::getinbasketassessment($id);
	?>
<style>
.label2{
    border-radius: 50px;
    font-size: 25px;
    font-weight: 400;
    padding: 3px 6px;
    text-transform: capitalize;
}
</style>	
	<div class='col-md-12'>
		<div class="clearfix"><br></div>
		<!--<div class="panel panel-inverse card-view">
			<div class="panel-heading">-->
				<h5>In-basket Details </h5>
			<!--</div>-->
			<div class='panel-body'>
				<div class='table-responsive'>
				<table class='table table-hover table-bordered table-striped'>
					<thead>
						<tr>
							<th>Assessment Name</th>
							<th>In-basket Name</th>
							<th>Employee Assessement Status</th>
							<!--<th>Test Rating</th>-->
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php
					foreach($ass_detail_inbasket as $ass_detail_inbaskets){
						//echo $ass_detail_inbaskets['inb_assess_test_id'];
						$getpretest_inbasket=UlsUtestAttemptsAssessment::getattemptvalus_inbasket($ass_details['assessment_id'],$emp_id,$id,$ass_details['assessment_type'],$ass_detail_inbaskets['test_id']);
					?>
						<tr>
						<td class='issue-info'>
							<a href='#'><?php echo $ass_details['assessment_name'];?></a>
						</td>
						<td><span class='label label-success' data-target='#workinfoview<?php echo $ass_detail_inbaskets['inbasket_id'];?>' onclick='work_info_view(<?php echo  $ass_detail_inbaskets['inbasket_id'];?>)' data-toggle='modal' href='#workinfoview<?php echo $ass_detail_inbaskets['inbasket_id'];?>'><?php echo $ass_detail_inbaskets['inbasket_name'];?></span></td>
						<td><?php echo $status=empty($getpretest_inbasket['attempt_status'])?'In Process':'Completed';?></td>
						<!--<td><span class='label label-warning' data-target='#workinfoview_test<?php echo $ass_detail_inbaskets['inbasket_id'];?>' onclick='inbasket_test(<?php echo $id;?>,<?php echo $ass_details['assessment_id'];?>,<?php echo $ass_detail_inbaskets['test_id'];?>,<?php echo $emp_id;?>,"<?php echo $ass_details['assessment_type'];?>",<?php echo $ass_detail_inbaskets['inbasket_id'];?>)' data-toggle='modal' href='#workinfoview_test<?php echo $ass_detail_inbaskets['inbasket_id'];?>'>Details</span></td>-->
						<td class='text-center'>
						<?php
						if(empty($getpretest_inbasket['attempt_status'])){
						?>
						<a href='#' class='btn btn-danger btn-xs' onclick='alertmsg()' >Not Completed</a>
						<?php
						}
						else{

						?>
						<button class='btn btn-info btn-xs' data-toggle='modal' data-target='#myModal5' onclick='mytest_details(<?php echo $id;?>,<?php echo $ass_details['assessment_id'];?>,<?php echo $ass_detail_inbaskets['test_id'];?>,<?php echo $emp_id;?>,"<?php echo $ass_details['assessment_type'];?>",<?php echo $ass_detail_inbaskets['inb_assess_test_id'];?>,<?php echo $pos_id;?>);'> View</button>
						<?php
						}
						?></td>
					</tr>
					<div id='workinfoview<?php echo $ass_detail_inbaskets['inbasket_id'];?>'  class='modal fade' tabindex='-1' role='dialog'  aria-hidden='true'>
						<div class='modal-dialog modal-lg'>
							<div class='modal-content'>
								<div class='color-line'></div>
								<div class='modal-header'>
									<button aria-hidden="true" data-dismiss="modal" class="close" type="button" style="margin:5px 10px;">X</button>
									<h4 class='modal-title' style="margin:5px 10px;">In-basket Details</h4>
								</div>
								<div class='modal-body'>
									<div id='workinfodetails<?php echo $ass_detail_inbaskets['inbasket_id'];?>' class='modal-body no-padding'>
									
									</div>
								</div>
								
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div>
					<div id='workinfoview_test<?php echo $ass_detail_inbaskets['inbasket_id'];?>'  class='modal fade' tabindex='-1' role='dialog'  aria-hidden='true' data-backdrop="static">
						<div class='modal-dialog modal-lg'>
							<div class='modal-content'>
								<div class='color-line'></div>
								<div class='modal-header'>
									<button aria-hidden="true" data-dismiss="modal" class="close" type="button" style="margin:5px 10px;">X</button>
									<h4 class='modal-title' style="margin:5px 10px;">In-basket Test Score</h4>
								</div>
								<div class='modal-body'>
									<div id='test_details<?php echo $ass_detail_inbaskets['inbasket_id'];?>' class='modal-body no-padding'>
									
									</div>
								</div>
								
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div>
					<?php
					}
					?></tbody>
				</table>
				</div>
			</div>
		<!--</div>-->
	</div>
	<?php
	}
	elseif($ass_details['assessment_type']=='CASE_STUDY'){
	$ass_detail_casestudy=UlsAssessmentTestCasestudy::getcasestudyassessment($id);
	?>
	<div class='col-md-12'>	
		<!--<div class="panel panel-inverse card-view">
			<div class="panel-heading">-->
				<div class="clearfix"><br></div>
				<h5>Casestudy Details</h5>
			<!--</div>-->
			<div class='panel-body'>
				<div class='table-responsive'>
				<table class='table table-hover table-bordered table-striped'>
					<thead>
						<tr>
							<th>Assessment Name</th>
							<th>Casestudy Name</th>
							<th>Employee Assessement Status</th>
							<!--<th>Test Rating</th>-->
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php
					foreach($ass_detail_casestudy as $ass_detail_casestudies){
						$getpretest_inbasket=UlsUtestAttemptsAssessment::getattemptvalus_inbasket($ass_details['assessment_id'],$emp_id,$id,$ass_details['assessment_type'],$ass_detail_casestudies['test_id']);
					?>
						<tr>
						<td class='issue-info'>
							<a href='#'><?php echo $ass_details['assessment_name'];?></a>
						</td>
						<td><span class='label label-success' data-target='#workinfoview_case<?php echo $ass_detail_casestudies['casestudy_id'];?>' onclick='work_info_view_casestudy(<?php echo  $ass_detail_casestudies['casestudy_id'];?>)' data-toggle='modal' href='#workinfoview_case<?php echo $ass_detail_casestudies['casestudy_id'];?>'><?php echo $ass_detail_casestudies['casestudy_name'];?></span></td>
						<td><?php echo $status=empty($getpretest['attempt_status'])?'In Process':'Completed';?></td>
						<!--<td><span class='label label-warning' data-target='#workinfoview_casetest<?php echo $ass_detail_casestudies['casestudy_id'];?>' onclick='casestudy_test(<?php echo $id;?>,<?php echo $ass_details['assessment_id'];?>,<?php echo $ass_detail_casestudies['test_id'];?>,<?php echo $emp_id;?>,"<?php echo $ass_details['assessment_type'];?>",<?php echo $ass_detail_casestudies['casestudy_id'];?>)' data-toggle='modal' href='#workinfoview_casetest<?php echo $ass_detail_casestudies['casestudy_id'];?>'>Details</span></td>-->
						<td class='text-center'>
						<?php
						if(empty($getpretest_inbasket['attempt_status'])){
						?>
						<a href='#' class='btn btn-danger btn-xs' onclick='alertmsg()' >Not Completed</a>
						<?php
						}
						else{
						?>
						<button class='btn btn-info btn-xs' data-toggle='modal' data-target='#myModal5' onclick='mytest_details_casestudy(<?php echo $id;?>,<?php echo $ass_details['assessment_id'];?>,<?php echo $ass_detail_casestudies['test_id'];?>,<?php echo $emp_id;?>,"<?php echo $ass_details['assessment_type'];?>",<?php echo $ass_detail_casestudies['case_assess_test_id'];?>,<?php echo $pos_id;?>,<?php echo $ass_detail_casestudies['casestudy_id'];?>);'> View</button>
						<?php
						}
						?></td>
					</tr>
					<div id='workinfoview_case<?php echo $ass_detail_casestudies['casestudy_id'];?>'  class='modal fade' tabindex='-1' role='dialog'  aria-hidden='true'>
						<div class='modal-dialog modal-lg'>
							<div class='modal-content'>
								<div class='color-line'></div>
								<div class='modal-header'>
									<button aria-hidden="true" data-dismiss="modal" class="close" type="button" style="margin:5px 10px;">X</button>
									<h4 class='modal-title' style="margin:5px 10px;">Case study Details</h4>
								</div>
								<div class='modal-body'>
									<div id='workinfodetails_casestudy<?php echo $ass_detail_casestudies['casestudy_id'];?>' class='modal-body no-padding'>
									
									</div>
								</div>
								
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div>
					<div id='workinfoview_casetest<?php echo $ass_detail_casestudies['casestudy_id'];?>'  class='modal fade' tabindex='-1' role='dialog'  aria-hidden='true' data-backdrop="static">
						<div class='modal-dialog modal-lg'>
							<div class='modal-content'>
								<div class='color-line'></div>
								<div class='modal-header'>
									<button aria-hidden="true" data-dismiss="modal" class="close" type="button" style="margin:5px 10px;">X</button>
									<h4 class='modal-title' style="margin:5px 10px;">Case study Test Score</h4>
								</div>
								<div class='modal-body'>
									<div id='casestudy_details<?php echo $ass_detail_casestudies['casestudy_id'];?>' class='modal-body no-padding'>
									
									</div>
								</div>
								
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div>
					<?php
					}
					?></tbody>
				</table>
				</div>
			</div>
		<!--</div>-->
	</div>
	<?php
	}
	elseif($ass_details['assessment_type']=='INTERVIEW'){
	?>
	<div class='col-md-12'>
		<!--<div class="panel panel-inverse card-view">
			<div class="panel-heading">-->
			<div class="clearfix"><br></div>
				<h5>Interview Details</h5>
			<!--</div>-->
			<div class='panel-body'>
				<div class='table-responsive'>
				<table class='table table-hover table-bordered table-striped'>
					<thead>
						<tr>
							<th>Assessment Type</th>
							<th>Assessment Name</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<tr>
						<td>
							<span class='label label-success'><?php echo $ass_details['assessment_type'];?></span>
						</td>
						<td class='issue-info'>
							<a href='#'><?php echo $ass_details['assessment_name']?></a>
						</td>
						
						<td>
						<span class='label label-warning' data-target='#interview_score_details<?php echo $ass_details['assess_test_id'];?>_<?php echo $ass_details['position_id'];?>_<?php echo $ass_details['rating_id'];?>' onclick='test_score_interview(<?php echo $ass_details['assess_test_id'];?>,<?php echo $ass_details['position_id'];?>,<?php echo $ass_details['rating_id'];?>,<?php echo $emp_id; ?>)' data-toggle='modal' href='#interview_score_details<?php echo $ass_details['assess_test_id'];?>_<?php echo $ass_details['position_id'];?>_<?php echo $ass_details['rating_id'];?>'>Details</span>
						
						</td>
						
						
					</tr>
					<div id='interview_score_details<?php echo $ass_details['assess_test_id'];?>_<?php echo $ass_details['position_id'];?>_<?php echo $ass_details['rating_id'];?>'  class='modal fade interviewmodel' tabindex='-1' role='dialog'  aria-hidden='true' data-backdrop='static'>
							<div class='modal-dialog modal-lg' style="width:1400px">
								<div class='modal-content'>
									<div class='color-line'></div>
									<div class='modal-header'>
										<button aria-hidden="true" data-dismiss="modal" class="close" type="button" style="margin:5px 10px;">X</button>
										<h4 class='modal-title' style="margin:5px 10px;">Interview Score</h4>
									</div>
									<div class='modal-body'>
										<div id='interview_score_detail<?php echo $ass_details['assess_test_id'];?>_<?php echo $ass_details['position_id'];?>_<?php echo $ass_details['rating_id'];?>' class='modal-body no-padding'>
										
										</div>
									</div>
									
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div>
					</tbody>
				</table>
				</div>
			</div>

		<!--</div>-->
	</div>
	<?php
	}
	elseif($ass_details['assessment_type']=='BEHAVORIAL_INSTRUMENT'){
	$ass_detail_casestudy=UlsAssessmentTestBehavorialInst::getbeiassessment($id);
	?>
	<div class='col-md-12'>	
		<!--<div class="panel panel-inverse card-view">
			<div class="panel-heading">-->
				<div class="clearfix"><br></div>
				<h5>Behavioural Instrument Information</h5>
			<!--</div>-->
			<div class='panel-body'>
				<div class='table-responsive'>
					<table class='table table-hover table-bordered table-striped'>
						<thead>
							<tr>
								<th>Behavioural Instrument Name</th>
								<th>Status</th>
								<!--<th>Test Rating</th>-->
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						<?php
							foreach($ass_detail_casestudy as $ass_detail_casestudies){
								$getpretest_inbasket=UlsBeiAttemptsAssessment::getattemptvalus_beh($ass_details['assessment_id'],$emp_id,$ass_details['assessment_type'],$id,$ass_detail_casestudies['instrument_id']);
						?>
							<tr>
								<td><span class='label label-success' data-target='#workinfoview_case<?php echo $ass_detail_casestudies['instrument_id'];?>' onclick='work_info_view_casestudy(<?php echo  $ass_detail_casestudies['instrument_id'];?>)' data-toggle='modal' href='#workinfoview_case<?php echo $ass_detail_casestudies['instrument_id'];?>'><?php echo $ass_detail_casestudies['instrument_name'];?></span></td>
								<td><?php echo $status=empty($getpretest_inbasket['attempt_status'])?'In Process':'Completed';?></td>
								<td class='text-center'>
								<?php if(empty($getpretest_inbasket['attempt_status'])){ ?>
								<a href='#' class='btn btn-danger btn-xs' onclick='alertmsg()' >Not Completed</a>
								<?php } else{ ?>
								<button class='btn btn-info btn-xs' data-toggle='modal' data-target='#myModal5_bei' onclick='mytest_details_bei(<?php echo $id;?>,<?php echo $ass_details['assessment_id'];?>,<?php echo $ass_detail_casestudies['beh_inst_id'];?>,<?php echo $emp_id;?>,"<?php echo $ass_details['assessment_type'];?>",<?php echo $ass_detail_casestudies['instrument_id'];?>);'> View</button>
								<?php } ?></td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		<!--</div>-->
	</div>
	<?php
	}
	elseif($ass_details['assessment_type']=='FEEDBACK'){?>
	<div class='col-md-12'>
		<!--<div class="panel panel-inverse card-view">
			<div class="panel-heading">-->
			<div class="clearfix"><br></div>
				<h5>Feedback Details</h5>
			<!--</div>-->
			<div class='panel-body'>
				<div class='table-responsive'>
				<table class='table table-hover table-bordered table-striped'>
					<thead>
						<tr>
							<th>Assessment Type</th>
							<th>Assessment Name</th>
							<th>View</th>
						</tr>
					</thead>
					<tbody>
					<tr>
						<td>
							<span class='label label-success'><?php echo $ass_details['assessment_type'];?></span>
						</td>
						<td class='issue-info'>
							<a href='#'><?php echo $ass_details['assessment_name']?></a>
						</td>						
						<td>
						<span class='label label-info' data-toggle='modal' data-target='#myModal5_feeback' onclick='mytest_details_feedback(<?php echo $ass_details['assessment_id'];?>,<?php echo $emp_id;?>,"<?php echo $ass_details['assessment_type'];?>")'> View</span>
						</td>
						
					</tr>
					</tbody>
				</table>
				</div>
			</div>

		<!--</div>-->
	</div>
	<?php 
	}
	else{
	?>
	<div class='col-md-12'>
		<!--<div class="panel panel-inverse card-view">
			<div class="panel-heading">-->
			<div class="clearfix"><br></div>
				<h5>Test Details</h5>
			<!--</div>-->
			<div class='panel-body'>
				<div class='table-responsive'>
				<table class='table table-hover table-bordered table-striped'>
					<thead>
						<tr>
							<th>Assessment Type</th>
							<th>Assessment Name</th>
							<th>Total Questions</th>
							<th>Time Interval</th>
							<th>Employee Assessement Status</th>
							<th>Results</th>
							<th>Answ. Sheet</th>
						</tr>
					</thead>
					<tbody>
					<tr>
						<td>
							<span class='label label-success'><?php echo $ass_details['assessment_type'];?></span>
						</td>
						<td class='issue-info'>
							<a href='#'><?php echo $ass_details['assessment_name']?></a>
						</td>
						<td>
							<?php echo $ass_details['no_questions'];?>
						</td>
						<td>
							<?php echo $ass_details['time_details'];?>
						</td>
						<td><?php echo $status=empty($getpretest['attempt_status'])?'In Process':'Completed'; ?></td>
						<td><?php if(!empty($getpretest['attempt_status'])){ ?>
						<span class='label label-warning' data-target='#test_score_details<?php echo $getpretest['attempt_id'];?>_<?php echo $getpretest['test_id'];?>' onclick='test_score_info(<?php echo $getpretest['attempt_id'];?>,<?php echo $getpretest['test_id'];?>,<?php echo $emp_id; ?>,<?php echo $pos_id;?>)' data-toggle='modal' href='#test_score_details<?php echo $getpretest['attempt_id'];?>_<?php echo $getpretest['test_id'];?>'>View & Rate</span>
						<?php } ?>
						</td>
						<td>
						<?php
						if(empty($getpretest['attempt_status'])){
						?>
							
						<?php	
						}
						else{
							
						?> 
						<span class='label label-info' data-toggle='modal' data-target='#test_details_view<?php echo $id;?>_<?php echo $ass_details['test_id'];?>' onclick='mytest_detail_view(<?php echo $id;?>,<?php echo $ass_details['assessment_id'];?>,<?php echo $ass_details['test_id'];?>,<?php echo $emp_id;?>,"<?php echo $ass_details['assessment_type'];?>")'> View</span>
						
						<!--<button class='btn btn-info btn-xs' data-toggle='modal' data-target='#test_details_view<?php echo $id;?>_<?php echo $ass_details['test_id'];?>' onclick='mytest_detail_view(<?php echo $id;?>,<?php echo $ass_details['assessment_id'];?>,<?php echo $ass_details['test_id'];?>,<?php echo $emp_id;?>,"<?php echo $ass_details['assessment_type'];?>")'> View</button>-->
						<?php
						}
						?></td>
						
					</tr>
					</tbody>
				</table>
				</div>
			</div>

		<!--</div>-->
	</div>
	<?php
	}?>
	<div id='test_score_details<?php echo $getpretest['attempt_id'];?>_<?php echo $getpretest['test_id'];?>'  class='modal fade' tabindex='-1' role='dialog'  aria-hidden='true' data-backdrop="static">
		<div class='modal-dialog modal-lg' style="width:1400px">
			<div class='modal-content'>
				<div class='color-line'></div>
				<div class='modal-header'>
					<button aria-hidden="true" data-dismiss="modal" class="close" type="button" style="margin:5px 10px;">X</button>
					<h4 class='modal-title' style="margin:5px 10px;">Test Score</h4>
				</div>
				<div class='modal-body'>
					<div id='test_score_detail<?php echo $getpretest['attempt_id'];?>_<?php echo $getpretest['test_id'];?>' class='modal-body no-padding'>
					
					</div>
				</div>
				
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>
	
	<div id='test_details_view<?php echo $id;?>_<?php echo $ass_details['test_id'];?>'  class='modal fade bs-example-modal-lg in' tabindex='-1' role='dialog'  aria-hidden='true' data-backdrop="static">
	
		<div class='modal-dialog modal-lg'>
		
			<div class='modal-content'>
				<div class='color-line'></div>
				<div class='modal-header'>
					<button aria-hidden="true" data-dismiss="modal" class="close" type="button" style="margin:5px 10px;">X</button>
					<h4 class='modal-title' style="margin:5px 10px;">Test Details View</h4>
				</div>
				<div class='modal-body'>
					<div id='test_details_views<?php echo $id;?>_<?php echo $ass_details['test_id'];?>' class='modal-body no-padding'>
					
					</div>
				</div>
				
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>
	
	<div id='interview_details_view<?php echo $id;?>_<?php echo $ass_details['test_id'];?>'  class='modal fade' tabindex='-1' role='dialog'  aria-hidden='true' data-backdrop="static">
		<div class='modal-dialog modal-lg' style="width:1400px">
			<div class='modal-content'>
				<div class='color-line'></div>
				<div class='modal-header'>
					<button aria-hidden="true" data-dismiss="modal" class="close" type="button" style="margin:5px 10px;">X</button>
					<h4 class='modal-title' style="margin:5px 10px;">Test Details View</h4>
				</div>
				<div class='modal-body'>
					<div id='interview_details_views<?php echo $id;?>_<?php echo $ass_details['test_id'];?>' class='modal-body no-padding'>
					
					</div>
				</div>
				
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>
	
	<div class="modal fade" id="myModal5_Interview" tabindex="-1" role="dialog"  aria-hidden="true" data-backdrop="static">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="color-line"></div>
				<div class="modal-header">
					<button aria-hidden="true" data-dismiss="modal" class="close" type="button" style="margin:5px 10px;">X</button>					
					<h4 class="modal-title" style="margin:5px 10px;">Test</h4>
				</div>
				<div class="modal-body">
					<div id="testdiv_interview"></div>

				</div>
				
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="myModal5_bei" tabindex="-1" role="dialog"  aria-hidden="true" data-backdrop="static">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="color-line"></div>
				<div class="modal-header">
					<button aria-hidden="true" data-dismiss="modal" class="close" type="button" style="margin:5px 10px;">X</button>
					<h4 class="modal-title" style="margin:5px 10px;">BEHAVORIAL INSTRUMENT</h4>
				</div>
				<div class="modal-body">
					<div id="testdiv_bei"></div>

				</div>
				
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="myModal5_feeback" tabindex="-1" role="dialog"  aria-hidden="true" data-backdrop="static">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="color-line"></div>
				<div class="modal-header">
					<button aria-hidden="true" data-dismiss="modal" class="close" type="button" style="margin:5px 10px;">X</button>
					<h4 class="modal-title" style="margin:5px 10px;">360&deg; Feedback Report</h4>
				</div>
				<div class="modal-body">
					<div id="testdiv_feedback"></div>

				</div>
				
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="false" data-backdrop="static" style="overflow-y:auto;">
	<div class="modal-dialog modal-lg"  style="width:1400px" >
		<div class="modal-content">
			<div class="color-line"></div>
			<div id="testdiv">
				<div class="modal-header">
					<button aria-hidden="true" data-dismiss="modal" class="close" type="button" style="margin:5px 10px;">X</button>
					<h4 class="modal-title"  style="margin:5px 10px;"></h4>
				</div>
				<div class="modal-body">
					

				</div>
			</div>
			
		</div>
	</div>
</div>