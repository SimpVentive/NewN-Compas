<script> 

</script>
<section class="main-section">
	<div class="container">
		<div class="row">
			<!-- TEST SECTION :BEGIN -->
			<div class="test-section">
				<!-- TEST HEAD SECTION :BEGIN -->
				<form action='<?php echo BASE_URL;?>/employee/employee_feedback_others' method='post' name='employeeTest' id='employeeTest'>
				
				<input type='hidden' name='assid' id='assid' value="<?php echo $ass_details['assessment_id'];?>" />
				<input type='hidden' name='empid' id='empid' value="<?php echo $_SESSION['emp_id'];?>" />
				<input type='hidden' name='seeker_id' id='seeker_id' value="<?php echo $_REQUEST['sid'];?>" />
				<input type='hidden' name='ttype' id='ttype' value="<?php echo $ass_details['assessment_type'];?>" /> 
				<input type='hidden' name='ass_test_id' id='ass_test_id' value="<?php echo $ass_details['assess_test_id'];?>"/>
				<input type='hidden' name='timeconsume' id='timeconsume' value='Y' />
				<input type='hidden' name='group_id' id='group_id' value='<?php echo $group_info['group_id']; ?>' />
				<input type='hidden' name='totquest' id='totquest' value='<?php echo count($testdetails);?>' />
				<div class="test-head-section">
					<div class="d-flex align-items-center justify-content-between">
						<div class="test-head">
							<div class="icon material-icons">assignment_turned_in</div>
							<div class="test-info">
								<div class="test-name">360 Degree Feedback</div>
								<p class="test-content red-text">*Please give answers to all questions.</p>
							</div>
						</div>
						
					</div>
				</div>
				<!-- TEST HEAD SECTION :END 

				<div class="space-40"></div>-->
				<div class="test-body">
					<h5>Feedback Process</h5>
					<hr/>

				<!-- TEST BODY :BEGIN -->
				<?php
				if(count($testdetails)>0){
					foreach($testdetails as $keys=>$testdetail){
						$key=$keys+1;
						$var=($key==1)?"block":"none";
						$var_footer=($key==1)?"block flex":"none";
						$element_others=UlsCompetencyDefLevelElements::get_element_details($testdetail['element_id']);
						$seeker_name=UlsEmployeeMaster::getemployeedetails($_REQUEST['sid']);
						$element_name=!empty($element_others['element_oth_name'])?$element_others['element_oth_name']:$testdetail['element_id_edit'];
						$element_first_name = explode(" ", trim($element_name));
						$elementfirstname =strtolower($element_first_name[0]);
						array_shift($element_first_name); // remove first word
						$elementremname = implode(" ", $element_first_name);
						$element_full_name=$elementfirstname." ".$elementremname;
					?>
					<div class="case-question-box">
						<div class="number"><?php echo $key;?></div>
						<div class="case-details">
							<div class="d-flex align-items-center justify-content-between">
								<label class="name" style="font-size: 13px;"><?php echo $seeker_name['full_name']." ".$element_full_name;?></label>
								<span class="note"></span>
							</div>
							<input type='hidden' id='question_<?php echo $key;?>' name='question[<?php echo $key;?>]'  value='<?php echo $testdetail['ques_element_id'];?>' >
							<input type='hidden' name='qtype' id='qtype_<?php echo $key;?>' value="S" />
							<div class="d-flex align-items-center justify-content-between">
								<?php
								$valid='required';
								
								if(!is_null($testdetail['rater_value'])){ 
								//echo $testdetail['rater_value'];
									if($testdetail['rater_value']==0){ 
										$ched_zero="checked='checked'"; 
									} else {  $ched_zero=""; } 
								}
								else{
									$ched_zero="";
								}
								?>

								<input id="answer_<?php echo $key;?>_0[]" type="radio" <?php echo $ched_zero;?> name="answer_<?php echo $key;?>[]" class="radio-control validate[<?php echo $valid;?>]" value="A">
								<label for="answer_<?php echo $key;?>_0[]" class="radio-label">Not Applicable</label>
								<?php
								$ran='';
								
								$respvals=array();
								$ss=UlsQuestionnaireMaster::viewfeedback_rating($testdetail['ques_id']);
								
								foreach($ss as $key1=>$sss){
									$key1=$key1+1;
									if(!empty($testdetail['rater_value'])){ 
										if($sss['rating_number']==$testdetail['rater_value']){ 
											$ched="checked='checked'"; 
										} else {  $ched=""; } 
									}
									else{
										$ched="";
									}
								?>
								<div class="radio-group">
									<input id="answer_<?php echo $key;?>_<?php echo $key1;?>[]" type="radio" <?php echo $ched;?> name="answer_<?php echo $key;?>[]" class="radio-control validate[<?php echo $valid;?>]" value="<?php echo $sss['rating_number'];?>">
									<label for="answer_<?php echo $key;?>_<?php echo $key1;?>[]" class="radio-label"><?php echo $sss['rating_name_scale'];?></label>
								</div>
								<?php
								}
								?>
							</div>
						</div>
					</div>
				
				<?php 
					
					}
				}?>
				</div>
				<div class="test-footer d-flex align-items-center justify-content-between">
					<button class="btn btn-primary validate-skip" type="submit" name="save_con" id='submit_con' >Save & Continue</button>
					<button class="btn btn-primary" type="submit" name="submit" id='submit_ass' >Submit</button>
				</div>
				<br>
				</form>
			</div>
			<!-- TEST SECTION :END -->
		</div>
	</div>
</section>