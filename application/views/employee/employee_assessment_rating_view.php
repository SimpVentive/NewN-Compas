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
				<form action='<?php echo BASE_URL;?>/employee/employee_program_insert' method='post' name='feedback' id='feedback' enctype='multipart/form-data'>
				
				<input type="hidden" name="ass_id" value="<?php echo $_REQUEST['ass_id']; ?>">
				<input type="hidden" name="pos_id" value="<?php echo $_REQUEST['pos_id']; ?>">
				<input type="hidden" name="emp_id" value="<?php echo $_REQUEST['emp_id']; ?>">
				<input type="hidden" name="jid" value="<?php echo $_REQUEST['jid']; ?>">
				<input type="hidden" name="tna_id" value="<?php echo !empty($_REQUEST['tna'])?$_REQUEST['tna']:""; ?>">
				<div class="test-head-section">
					<div class="d-flex align-items-center justify-content-between">
						<div class="test-head">
							<div class="icon material-icons">supervised_user_circle</div>
							<div class="test-info">
								<div class="test-name">Training Needs Identification (TNI) </div>
								<p class="test-content red-text" style="font-size: 15px;">
								
								The competencies and the associated indicators therein have been mapped to various Training programs.  Based on your selection of the Competencies and the corresponding indicators, the following Training Programs have been identified for you.
								
								</p>
							</div>
						</div>
						
					</div>
					<br style="clear:both;">
						<div class="button-action" style="float:right;">
							<a href="javascript:;" class="btn btn-primary" data-toggle="modal" data-target="#competency-indicator-modal">View Indicators</a>
							<?php 
							if($emp_feedback['tni_status']!=1){
							?>
							<a href="<?php echo BASE_URL; ?>/employee/employee_assessment_rating?ass_type=<?php echo $_REQUEST['ass_type'] ?>&jid=<?php echo $_REQUEST['jid']; ?>&ass_id=<?php echo $_REQUEST['ass_id']; ?>&pos_id=<?php echo $_REQUEST['pos_id']; ?>&emp_id=<?php echo $_REQUEST['emp_id']; ?>" class="btn btn-primary">Edit</a>
						
							<input type="hidden" name="jid" value="<?php echo $_REQUEST['jid']; ?>">
							
							<?php
								if(!empty($ass_final)){
								?>
								<button class='btn btn-primary' type="submit" id='submit_ass'>Submit</button>
								
							<?php }
							}
							else{
							?>
							<a href="<?php echo BASE_URL; ?>/admin/profile" class="btn btn-primary">Close</a>
							<?php
							}
							?>
						</div>
						<br style="clear:both;">
				</div>
				<!-- TEST HEAD SECTION :END -->

				<div class="report-view-section custom-scroll">
					<div class="report-view-block">
					
						<table class="table-bordered table">
							<tr>
								
								<th colspan="5" class="report-title">Keeping in view the time and resource constraints and also help organization prioritize your training needs, kindly select from the following a <b style="color:red">MAXIMUM of <?php echo $ass_details['ass_pro_count']; ?></b>  Training programs.  </th>
								
							</tr>
							<tr>
								<?php
								//if(($ass_details['ass_comp_selection']=='Y') && ($ass_details['ass_pro_selection']=='Y')){
								?>	
								<th class="report-sub-title">Current Year Programs</th>
								<?php	
								//}
								?>
								<th class="report-sub-title">Compentancy</th>
								<th class="report-sub-title">Required level</th>
								<?php
								if($ass_details['ass_comp_selection']=='N'){
								?><th class="report-sub-title">Assessed level</th>
								<?php } ?>
								<th class="report-sub-title">Training Program Suggested</th>
								
							</tr>
							<?php
							
							if($ass_details['ass_comp_selection']=='N' || (!empty($_REQUEST['tna']) && ($_REQUEST['tna']==1))){
							$assresults=UlsAssessmentTest::assessment_results_avg($_REQUEST['ass_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id']);
							$results=$ass_comname=$ass_req_sid=$ass_given_sid=$ass_sid=array();
							foreach($assresults as $assresult){
								$compid=$assresult['comp_def_id'];
								$finalval=!empty($assresult['assessor_val'])?round(($assresult['ass_scale_number']*$assresult['assessor_val']),2):$assresult['ass_scale_number'];
								$results[$assresult['comp_def_id']]['comp_id']=$compid;
								$results[$assresult['comp_def_id']]['comp_name']=$assresult['comp_def_name'];
								$results[$assresult['comp_def_id']]['req_val']=$assresult['req_number'];
								$results[$assresult['comp_def_id']]['require_scale_id']=$assresult['require_scale_id'];
								$results[$assresult['comp_def_id']]['assessor'][$assresult['assessor_id']]=$finalval;
							}
							if(count($results)>0){
								foreach($results as $key1=>$result){
									$final=0;
									foreach($result['assessor'] as $key2=>$ass_id){
										$final=$final+$results[$key1]['assessor'][$key2];
									}
									$final=round($final/count($results[$key1]['assessor']),2);
									$ass_sid[$result['comp_id']]=$final;
								}
							}
							}
							$temp1=$temp2="";
							$comp_programs=array();
							if(!empty($ass_final)){
							foreach($ass_final as $key=>$ass_finals){
								$comp_programs[]=$ass_finals['comp_def_pro_id'];
							?>
							<tr>
								<?php
								
								//if(($ass_details['ass_comp_selection']=='Y') && ($ass_details['ass_pro_selection']=='Y')){
								?>
								<td>
								<input id="comp_details_<?php echo $ass_finals['comp_def_id']; ?>" type="checkbox" name="comp_program_year[]" class="validate[minCheckbox[1],maxCheckbox[<?php echo $ass_details['ass_pro_count']; ?>]]  justify-content-between" value="<?php echo $ass_finals['comp_def_pro_id']; ?>" data-prompt-position="bottomRight:270,90">
								<input type="hidden" id="comp_details_<?php echo $ass_finals['comp_def_id']; ?>" name="comp_programs[]" value="<?php echo $ass_finals['comp_def_pro_id']; ?>">
								<input type="hidden" name="comp_def_id[<?php echo $ass_finals['comp_def_pro_id']; ?>]" value="<?php echo $ass_finals['comp_def_id']; ?>">
								<input type="hidden" name="comp_def_level_id[<?php echo $ass_finals['comp_def_pro_id']; ?>]" value="<?php echo $ass_finals['scale_id']; ?>">
								<?php 
								if(($ass_details['ass_comp_selection']=='N' || (!empty($_REQUEST['tna']) && ($_REQUEST['tna']==1)))){
								?>
								<input type="hidden" name="ass_scale_id[<?php echo $ass_finals['comp_def_pro_id']; ?>]" value="<?php echo $ass_sid[$ass_finals['comp_def_id']]; ?>">
								<?php } ?>
								</td>
								
								<td><?php
								if($temp2!=$ass_finals['comp_def_name']){
									echo $ass_finals['comp_def_name'];
									$temp2=$ass_finals['comp_def_name'];
								}
									?></td>
								<td><?php echo $ass_finals['scale_number'];?></td>
								<?php
								if($ass_details['ass_comp_selection']=='N' || (!empty($_REQUEST['tna']) && ($_REQUEST['tna']==1))){
								?>
								<td><?php echo $ass_sid[$ass_finals['comp_def_id']]; ?></td>
								<?php } ?>
								<td><?php
								if($temp1!=$ass_finals['pro_name']){
									echo $ass_finals['pro_name'];
									$temp1=$ass_finals['pro_name'];
								}?></td>
							</tr>
							<?php
							}
							?>
							<?php
								if($ass_details['ass_comp_selection']=='N' || (!empty($_REQUEST['tna']) && ($_REQUEST['tna']==1))){
								?>
							<input type="hidden" name="total_programs" value="<?php echo implode(",",$comp_programs); ?>" > 
								<?php 
							}
							}
							else{
							?>
							<tr>
								<td  colspan="5">No Records</td>
							</tr>
							<?php
							}
							
							?>
						
						</table>
						
						<div class="space-20"></div>

					</div>
					<h4>Feedback</h4>
					<p style="color:red;font-size: 15px;font-weight: 600;">
						We would love to know from you regarding this process of Training Needs Identification based Competency based framework.  Your inputs will be valuable to improve the process and platform.  
					</p>
					<div class="row">
					
						<div class="test-body">
							<div class="question-title" style="font-size: 16px;">Do you think that this process has helped in identifying your specific training needs?</div>
							
							<div class="space-20"></div>

							<div class="answer-section">
								<?php 
								$q1=!empty($emp_feedback['feed_q1'])?(($emp_feedback['feed_q1']==1)?"checked='checked'":""):"";
								$q2=!empty($emp_feedback['feed_q1'])?(($emp_feedback['feed_q1']==2)?"checked='checked'":""):"";
								$q3=!empty($emp_feedback['feed_q1'])?(($emp_feedback['feed_q1']==3)?"checked='checked'":""):"";
								$q4=!empty($emp_feedback['feed_q1'])?(($emp_feedback['feed_q1']==4)?"checked='checked'":""):"";
								$q5=!empty($emp_feedback['feed_q1'])?(($emp_feedback['feed_q1']==5)?"checked='checked'":""):"";
								?>
								<input id="ans-ac" type="radio" name="Q1" value="1" class="validate[required] radio-control" <?php echo $q1; ?>>
								<label for="ans-ac" class="label">Strongly Disagree</label>
								<span class="radio_space"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input id="ans-abc" type="radio" name="Q1" value="2" class="validate[required] radio-control" <?php echo $q2; ?>>
								<label for="ans-abc" class="label">Disagree</label>
								<span class="radio_space"></span>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input id="ans-abcd" type="radio" name="Q1" value="3" class="validate[required] radio-control" <?php echo $q3; ?>>
								<label for="ans-abcd" class="label">Neither Agree nor Disagree</label>
								<span class="radio_space"></span>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input id="ans-none" type="radio" name="Q1" value="4" class="validate[required] radio-control" <?php echo $q4; ?>>
								<label for="ans-none" class="label">Agree </label>
								<span class="radio_space"></span>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input id="ans-none" type="radio" name="Q1" value="5" class="validate[required] radio-control" <?php echo $q5; ?>>
								<label for="ans-none" class="label">Strongly Agree</label>
							</div>
						</div>
						<div class="test-body">
								<div class="question-title"  style="font-size: 16px;">Do you have any suggestions for improving the process.</div>
								
								<div class="space-20"></div>

								<div class="answer-section">
									<textarea rows="4" cols="500" style="width:100%" class="validate[required]  value" name="Q4" data-prompt-position='topLeft'><?php echo $question=!empty($emp_feedback['feed_q2'])?$emp_feedback['feed_q2']:""; ?></textarea>
									
								</div>
							</div>
					</div>
				</div>
				</form>
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

