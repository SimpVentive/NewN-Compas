<div class="content">
	<div class="row projects">
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				<div class="hpanel">
					<div class="panel-body">
						
						<div class="table-wrap mt-20">
							<div class="table-responsive">
								<div id="edit_datable_2_wrapper" class="dataTables_wrapper">
									
									<table cellpadding="1" cellspacing="1" id="edit_datable_2" class="table table-hover table-bordered mb-0">
										<thead>
											<tr>
												<th>Assessment Name</th>
												<th>Start Date</th>
												<th>End Date</th>
												<th>Action</th>
												<th>Feedback</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($assessments as $assessment){ ?>
											 <tr class="tooltip-demo" id="assessmentdel_<?php echo $assessment['assessment_id']; ?>">
												<td><?php echo @$assessment['assessment_name']; ?></td>
												<td><?php echo date("d-m-Y",strtotime($assessment['start_date'])); ?></td>
												<td><?php echo date("d-m-Y",strtotime($assessment['end_date'])); ?></td>
												<td>
												<?php 
												$date=date("Y-m-d");
												if($assessment['end_date']<$date){
												?>
												<a class="btn btn-danger btn-xs pull-left mr-15">Closed</a>
												<?php
												}
												else{
												?>
												<a data-toggle="tooltip" data-placement="top" title="" data-original-title="Assessments" href="<?php echo BASE_URL; ?>/assessor/assessor_assessment_details?assessment_id=<?php echo $assessment['assessment_id']; ?>" class="btn btn-info btn-xs pull-left mr-15">View</a>
												<?php } ?>
												
												</td>
												<td>
												<?php 
												$ass_feedback=UlsAssessmentFeedbackAssessor::view_feedback_assessor($assessment['assessment_id']);
												
												$date=date("Y-m-d");
												if($assessment['end_date']<$date){
													if(empty($ass_feedback['feed_id'])){
														?>
														<a data-toggle="tooltip" data-placement="top" title="" data-original-title="Assessments" href="<?php echo BASE_URL; ?>/assessor/assessor_feedback_details?assessment_id=<?php echo $assessment['assessment_id']; ?>" class="btn btn-info btn-xs pull-left mr-15">Feedback</a>
														<?php
													}
													else{
														echo "Completed";
													}
												}
												else{
													echo "Assessment Inprocess";
												}
												?>
												</td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
									<div class="clearfix mt-20"></div>
								</div>
								
							</div>
							
						</div>
						
					</div>
				</div>
			</div>
		</div>
		
	</div>
</div>
<?php 
if(isset($_SESSION['feed_session'])){
	if($_SESSION['feed_session']==1){
	?>
	<script>
	$(document).ready(function(){
		$("#close").click(function(){	
			$('#confirmation').css("display","none");
		});
	});
	</script>
	<div class="modal fade bs-example-modal-sm in" tabindex="-1" role="dialog" aria-hidden="true" id="confirmation" style="display:block;">
		  <div class="modal-dialog modal-sm">
			 <div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h5 class="modal-title" id="mySmallModalLabel">Confirmation</h5>
				</div>
				<div class="modal-body">
				   <p>Thank you for completing the Feedback.</p>
				</div>
				<div class="modal-footer">
				   <button type="button" class="btn btn-secondary" id="close">Close</button>
				</div>
			 </div>
		  </div>
	   </div>
	<?php
	}
}
unset($_SESSION['feed_session']);
?>

