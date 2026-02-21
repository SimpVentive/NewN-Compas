<style>
.btn-danger {
    font-size: 15px;
    color: #FFF;
    height: 35px;
    padding: 0 40px;
    font-weight: 500;
    border-radius: 3px;
    line-height: 35px;
    border: none;
}
</style>
<script>
$(document).ready(function(){
	$("#feedback").validationEngine();
});
</script>
<section class="main-section">
	<div class="container">
		<div class="row">
			<!-- TEST SECTION :BEGIN -->
			<div class="test-section">
				<!-- TEST HEAD SECTION :BEGIN -->
				
				
				<div class="test-head-section">
					<div class="d-flex align-items-center justify-content-between">
						<div class="test-head">
							<div class="icon material-icons">supervised_user_circle</div>
							<div class="test-info">
								<div class="test-name">Training Needs Identification (TNI)</div>
								<p class="test-content red-text" style="font-size: 15px;">View Training Need Identification</p>
							</div>
						</div>
						
						<div class="button-action">
							<a href="javascript:;" class="btn btn-primary" data-toggle="modal" data-target="#competency-indicator-modal">View Indicators</a>
							
							<a href="<?php echo BASE_URL; ?>/admin/profile" class="btn btn-primary">Close</a>
							
						</div>
					</div>
				</div>
				<!-- TEST HEAD SECTION :END -->

				<div class="report-view-section custom-scroll">
					<div class="report-view-block">
					
						<table class="idp-report-table table-bordered table" style="width: 950px;">
							<tr>
							<?php 
							$count=($ass_details['ass_comp_selection']=='N')?"5":"4";
							?>
								<th colspan="<?php echo $count; ?>" class="report-title">Select TNI Competancy Based Programs</th>
							</tr>
							<tr>
								
								<th class="report-sub-title">Compentancy</th>
								<th class="report-sub-title">Required level</th>
								<?php
								if($ass_details['ass_comp_selection']=='N'){
								?><th class="report-sub-title">Assessed level</th>
								
								<?php } ?>
								<th class="report-sub-title">Training Year</th>
								<th class="report-sub-title">Training Program Suggested</th>
								
							</tr>
							<?php
							$temp1=$temp2="";
							foreach($ass_final as $key=>$ass_finals){
							?>
							<tr>
								
								<td><?php
								if($temp2!=$ass_finals['comp_def_name']){
									echo $ass_finals['comp_def_name'];
									$temp2=$ass_finals['comp_def_name'];
								}
									?></td>
								<td><?php echo $ass_finals['scale_number'];?></td>
								<?php
								if($ass_details['ass_comp_selection']=='N'){
								?>
								<td><?php echo $ass_finals['ass_scale_id']; ?></td>
								
								<?php } ?>
								<td><?php echo ($ass_finals['tna_year']==1)?"Current Year":"Next Year"; ?></td>
								<td><?php
								if($temp1!=$ass_finals['pro_name']){
									echo $ass_finals['pro_name'];
									$temp1=$ass_finals['pro_name'];
								}?></td>
							</tr>
							<?php
							} ?>
							
						</table>
						
						<div class="space-20"></div>

					</div>
				</div>
				
			</div>
			<!-- TEST SECTION :END -->
		</div>
	</div>
</section>
<div class="modal fade case-modal" id="competency-indicator-modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document" >
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title flex">Selected Indicators</h5>
				<a href="javascript:;" class="close-modal" data-dismiss="modal" aria-label="Close">
					<i class="material-icons">close</i> Close
				</a>
			</div>
			<div class="case-info">
				
			</div>
			
			<div class="modal-body" >
				<table class="idp-report-table table-bordered table">
					<tbody>
					<tr>
						<th class="report-sub-title">Competency</th>
						<th class="report-sub-title">Required Level</th>
						<th class="report-sub-title">Indicators</th>
					</tr>
					<?php 
					$temp4="";
					foreach($ass_ind_final as $ass_ind_finals){
					?>
					<tr>
						<td>
						<?php 
						if($temp4!=$ass_ind_finals['comp_def_name']){
							echo $ass_ind_finals['comp_def_name'];
							$temp4=$ass_ind_finals['comp_def_name'];
						}?>
						</td>
						<td><?php echo $ass_ind_finals['scale_name']; ?></td>
						<td><?php echo $ass_ind_finals['comp_def_level_ind_name']; ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
			<div class="button-action">
				
				<?php 
				if($emp_feedback['tni_status']!=1){
				?>
				<a href="<?php echo BASE_URL; ?>/employee/employee_assessment_rating?ass_type=<?php echo $_REQUEST['ass_type'] ?>&jid=<?php echo $_REQUEST['jid']; ?>&ass_id=<?php echo $_REQUEST['ass_id']; ?>&pos_id=<?php echo $_REQUEST['pos_id']; ?>&emp_id=<?php echo $_REQUEST['emp_id']; ?>" class="btn btn-primary">Edit</a>
				<?php } ?>
				
			</div>
			</div>
		</div>
	</div>
</div>

