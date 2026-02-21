<style>
.test-section .test-body .case-question-box .case-details .name {
    display: block;
    position: relative;
    font-size: 15px;
    color: #404040;
    font-weight: 600;
    margin-bottom: 11px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
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
				<form action='<?php echo BASE_URL;?>/employee/employee_rating_insert' method='post' name='feedback' id='feedback' enctype='multipart/form-data'>
				<!-- TEST HEAD SECTION :BEGIN -->
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
								<div class="test-name">Identifying Specific Training Areas</div>
								<p class="test-content red-text" style="font-size: 15px;">
								
								Elements around which the Competencies have been defined are listed, hereunder.  For each of the Competencies, you can select only a set number of elements – this is being done to ensure that you are able to focus on specific areas/requirements.  </p>
							</div>
						</div>
						
					</div>
				</div>
				<!-- TEST HEAD SECTION :END -->

				<div class="space-40"></div>

				
				<!-- TEST BODY :BEGIN -->
				<div class="test-nav-scoll custom-scroll">
					<div id="self-assessment" class="tast-tab-nav">
						<div class="test-body">
						<?php 
						$results=UlsAssessmentEmployeeDevCompetencies::get_emp_competency_final($_REQUEST['ass_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id']);
						$j=0;
						
						if(count($results)>0){
							foreach($results as $key1=>$result){
								//$indicator_name=UlsCompetencyDefLevelIndicator::getcompdeflevelind_details($result['comp_def_id'],$result['scale_id']);
								$indicator_name=UlsCompetencyDefLevelIndicatorPrograms::getcompdeflevelind_details($result['comp_def_id'],$result['scale_id']);
								$total_count=0;
							$total_count+=count($indicator_name);
							$max_value=ceil((($total_count*50)/100));
							$maxvalue=($max_value>8)?"8":(($total_count<8)?$total_count:"8");
							?>
							<h5 style="float:left;"><?php echo $result['comp_def_name']; ?><span style="font-size:11px;color:red;">&nbsp;(Please select a Minimum of <b style="font-size:14px;">1</b> Option and a Maximum of <b style="font-size:14px;"><?php echo $maxvalue; ?></b> options.)</span></h5>
							<span  style="font-size:12px;float:right;">* Required level: <?php echo $result['scale_name']; ?></span>
							<hr  style="clear:both;"/>
							<input type="hidden" name="comp_id[]" value="<?php echo $result['comp_def_id']; ?>">
										<input type="hidden" name="req_id[]" value="<?php echo $result['scale_id']; ?>">
							<?php 
							
							$name="group".$result['comp_def_id']."[]";
							foreach($indicator_name as $key=>$indicator_names){
								$emp_ass_details=UlsAssessmentEmployeeDevRating::get_emp_rating_view($_REQUEST['ass_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id'],$result['comp_def_id'],$result['scale_id'],$indicator_names['comp_def_level_ind_id']);
								$check=!empty($emp_ass_details['dev_rating_id'])?"checked='checked'":"";
							?>
							<div class="case-question-box">
								
								<div class="">
									<div class="d-flex align-items-center justify-content-between">
										
										<label class="name" style="font-size: 14px;">
										<input id="element_details_<?php echo $indicator_names['comp_def_level_ind_id']; ?>" type="checkbox" name="<?php echo $name;?>" <?php echo $check; ?> class="validate[minCheckbox[1],maxCheckbox[<?php echo $maxvalue; ?>]]  justify-content-between" value="<?php echo $indicator_names['comp_def_level_ind_id']; ?>">&nbsp;&nbsp;&nbsp;<?php echo $indicator_names['comp_def_level_ind_name'];?></label>
										
									</div>
									
								</div>
							</div>
						<?php 
							}
							
							}
						}?>
						
						</div>

					</div>
					
				</div>
				<!-- TEST BODY :END -->

				<div class="test-footer d-flex align-items-center justify-content-between">
					<?php
					if($ass_details['ass_comp_selection']=='Y'){
					?>
					<a href="<?php echo BASE_URL; ?>/employee/employee_assessment_competency?ass_type=ASS&jid=<?php echo $_REQUEST['jid'];?>&ass_id=<?php echo $_REQUEST['ass_id'];?>&pos_id=<?php echo $_REQUEST['pos_id'];?>&emp_id=<?php echo $_REQUEST['emp_id'];?>" class="btn btn-primary idp-nav-back-btn">Edit Competencies</a>
					<?php 
					}
					else{
					?>
					<a href="#" class="btn btn-light idp-nav-back-btn"></a>
					<?php
					}
					?>
					<button class='btn btn-primary' type="submit" id='submit_ass'>Submit</button>
				</div>
				</form>
			</div>
			<!-- TEST SECTION :END -->
		</div>
	</div>
</section>