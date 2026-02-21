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
				<form action='<?php echo BASE_URL;?>/employee/employee_competency_insert' method='post' name='feedback' id='feedback' enctype='multipart/form-data'>
				
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
								<?php
								if($ass_details['ass_comp_selection']=='Y'){
								?>
								In order to ensure that we are able to focus on specific development needs, kindly do Select from amongst the list of competencies identified for your profile, <b>ANY 
								<?php 
								$competencies=UlsAssessmentCompetencies::getassessment_competencies($_REQUEST['ass_id'],$_REQUEST['pos_id']);
								$j=1;
								$comp_cpunt=0;
								foreach($competencies as $key1=>$competency){
									if($competency['comp_per']=='Y'){
										$comp_cpunt+=$j;
										
									}
									
								}
								if((!empty($_REQUEST['tna'])) && $_REQUEST['tna']==1){
									$tna_count=($comp_cpunt>3)?'3':$comp_cpunt;
									$max_value=!empty($_REQUEST['tna'])?(($_REQUEST['tna']==1)?$tna_count:$ass_details['ass_comp_count']):$ass_details['ass_comp_count'];	
								}
								else{
									$tna_count=($comp_cpunt>3)?$ass_details['ass_comp_count']:$comp_cpunt;
									$max_value=$tna_count;
								}
								echo $max_value; ?></b>, on which you would like to focus for the current year.  
								<?php }
								else{
								?>
								The following are the Competencies along with the Required levels of Proficiency identified for your position <b><?php echo $posdetails['position_name']; ?></b>
								<?php
								}
								?>
								</p>
							</div>
						</div>
						
					</div>
				</div>
				<!-- TEST HEAD SECTION :END -->

				<div class="space-40"></div>

				
				<!-- TEST BODY :BEGIN -->
				<div class="test-nav-scoll custom-scroll">
					<div id="self-assessment" class="tast-tab-nav">
						<h5>Competency Name</h5>
						<hr>
						<div class="test-body">
						<?php 
						$assresults=UlsAssessmentTest::assessment_results_avg($_REQUEST['ass_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id']);
						$results=$ass_comname=$ass_req_sid=$ass_given_sid=array();
						$j=0;
						foreach($assresults as $assresult){
							$compid=$assresult['comp_def_id'];
							$finalval=!empty($assresult['assessor_val'])?round(($assresult['ass_scale_number']*$assresult['assessor_val']),2):$assresult['ass_scale_number'];
							$results[$assresult['comp_def_id']]['comp_id']=$compid;
							$results[$assresult['comp_def_id']]['comp_name']=$assresult['comp_def_name'];
							$results[$assresult['comp_def_id']]['req_name']=$assresult['req_scale_name'];
							$results[$assresult['comp_def_id']]['req_id']=$assresult['require_scale_id'];
							$results[$assresult['comp_def_id']]['req_val']=$assresult['req_number'];
							$results[$assresult['comp_def_id']]['assessor'][$assresult['assessor_id']]=$finalval;
						}
						$tna=isset($_REQUEST['tna'])?"":($ass_details['ass_comp_selection']=='N');
						if($tna){
							
						if(count($results)>0){
							foreach($results as $key1=>$result){
								
								/* $comname[$key1]=$result['comp_name'];
								$req_sid[$key1]=$result['req_val']; */
								$final=0;
								foreach($result['assessor'] as $key2=>$ass_id){
									$final=$final+$results[$key1]['assessor'][$key2];
								}
								$final=round($final/count($results[$key1]['assessor']),2);
								//$ass_sid[$key1]=$final;
								
								if($result['req_val']>$final){
									$comp_per=UlsAssessmentCompetencies::get_casestudy_competencies($_REQUEST['ass_id'],$_REQUEST['pos_id'],$result['comp_id'],$result['req_id']);
									if($comp_per['comp_per']=='Y'){
									
							?>
							
							
							<?php
							
							//$name="group[]";
							
							?>
							<div class="case-question-box">
								
								<div class="">
									<div class="d-flex align-items-center justify-content-between">
										
										<input type="hidden" name="group[]" value="<?php echo $result['comp_id']; ?>">
										<input type="hidden" name="req_id[<?php echo $result['comp_id']; ?>]" value="<?php echo $result['req_id']; ?>">
										<label class="name" style="font-size: 14px;">&nbsp;&nbsp;&nbsp;<?php echo $result['comp_name']; ?></label>
										<!--<label class="name" style="font-size: 14px;">
										<input id="comp_details_<?php echo $result['comp_id']; ?>" type="checkbox" name="<?php echo $name;?>"  class="validate[minCheckbox[<?php echo $max_value; ?>],maxCheckbox[<?php echo $max_value; ?>]]  justify-content-between" value="<?php echo $result['comp_id']; ?>">&nbsp;&nbsp;&nbsp;<?php echo $result['comp_name']; ?></label>-->
										<span class="note">* Required level: <?php echo $result['req_name']; ?></span>
										
									</div>
									
								</div>
							</div>
						<?php 
									}
							
							}
							}
						}
						}
						elseif((!empty($_REQUEST['tna'])) && $_REQUEST['tna']==1){
							
							$competencies=UlsAssessmentCompetencies::getassessment_competencies($_REQUEST['ass_id'],$_REQUEST['pos_id']);
							$j=1;
							$comp_cpunt=0;
							foreach($competencies as $key1=>$competency){
								if($competency['comp_per']=='Y'){
									$comp_cpunt+=$j;
									
								}
								
							}
							
							foreach($competencies as $key1=>$competency){
								if($competency['comp_per']=='Y'){
									$emp_sel_com=UlsAssessmentEmployeeDevCompetencies::get_emp_competency_view($_REQUEST['ass_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id'],$competency['comp_def_id'],$competency['scale_id']);
									$check=!empty($emp_sel_com['dev_comp_id'])?"checked='checked'":"";
								?>
							
							<input type="hidden" name="req_id[<?php echo $competency['comp_def_id']; ?>]" value="<?php echo $competency['scale_id']; ?>">
							<?php
							$name="group[]";
							//echo $comp_cpunt;
							$tna_count=($comp_cpunt>3)?'3':$comp_cpunt;
							$max_value=!empty($_REQUEST['tna'])?(($_REQUEST['tna']==1)?$tna_count:$ass_details['ass_comp_count']):$ass_details['ass_comp_count'];
							?>
							<div class="case-question-box">
								
								<div class="">
									<div class="d-flex align-items-center justify-content-between">
										<label class="name" style="font-size: 14px;">
										<input id="comp_details_<?php echo $competency['comp_def_id']; ?>" type="checkbox" name="<?php echo $name;?>" <?php echo $check; ?> class="validate[minCheckbox[<?php echo $max_value; ?>],maxCheckbox[<?php echo $max_value; ?>]]  justify-content-between" value="<?php echo $competency['comp_def_id']; ?>">&nbsp;&nbsp;&nbsp;<?php echo $competency['comp_def_name']; ?></label>
										
										<span class="note">* Required level: <?php echo $competency['scale_name']; ?></span>
										
									</div>
									
								</div>
							</div>
							<?php
							
							}
							}
						}
						else{
							
							
							$competencies=UlsAssessmentCompetencies::getassessment_competencies($_REQUEST['ass_id'],$_REQUEST['pos_id']);
							$j=1;
							$comp_cpunt=0;
							foreach($competencies as $key1=>$competency){
								if($competency['comp_per']=='Y'){
									$comp_cpunt+=$j;
								}
							}
							
							foreach($competencies as $key1=>$competency){
								if($competency['comp_per']=='Y'){
									$emp_sel_com=UlsAssessmentEmployeeDevCompetencies::get_emp_competency_view($_REQUEST['ass_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id'],$competency['comp_def_id'],$competency['scale_id']);
									$check=!empty($emp_sel_com['dev_comp_id'])?"checked='checked'":"";
								?>
							
							<input type="hidden" name="req_id[<?php echo $competency['comp_def_id']; ?>]" value="<?php echo $competency['scale_id']; ?>">
							<?php
							$name="group[]";
							$tna_count=($comp_cpunt>3)?$ass_details['ass_comp_count']:$comp_cpunt;
							
							$max_value=$tna_count;
							?>
							<div class="case-question-box">
								
								<div class="">
									<div class="d-flex align-items-center justify-content-between">
										<label class="name" style="font-size: 14px;">
										<input id="comp_details_<?php echo $competency['comp_def_id']; ?>" type="checkbox" name="<?php echo $name;?>" <?php echo $check; ?> class="validate[minCheckbox[<?php echo $max_value; ?>],maxCheckbox[<?php echo $max_value; ?>]]  justify-content-between" value="<?php echo $competency['comp_def_id']; ?>">&nbsp;&nbsp;&nbsp;<?php echo $competency['comp_def_name']; ?></label>
										
										<span class="note">* Required level: <?php echo $competency['scale_name']; ?></span>
										
									</div>
									
								</div>
							</div>
							<?php
							}
							}
						}
						?>
						
						</div>

					</div>
					
				</div>
				<!-- TEST BODY :END -->

				<div class="test-footer d-flex align-items-center justify-content-between">
					<a href="#" class="btn btn-light idp-nav-back-btn"></a>
					<button class='btn btn-primary' type="submit" id='submit_ass'>Next</button>
				</div>
				</form>
			</div>
			<!-- TEST SECTION :END -->
		</div>
	</div>
</section>