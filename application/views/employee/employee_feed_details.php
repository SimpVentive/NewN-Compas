<script> 

</script>
<section class="main-section">
	<div class="container">
		<div class="row">
			<!-- TEST SECTION :BEGIN -->
			<div class="test-section">
				<!-- TEST HEAD SECTION :BEGIN -->
				<form action='<?php echo BASE_URL;?>/employee/employee_feedback' method='post' name='employeeTest' id='employeeTest'>
				
				<input type='hidden' name='assid' id='assid' value="<?php echo $ass_details['assessment_id'];?>" />
				<input type='hidden' name='empid' id='empid' value="<?php echo $_SESSION['emp_id'];?>" />
				<input type='hidden' name='ttype' id='ttype' value="<?php echo $ass_details['assessment_type'];?>" /> 
				<input type='hidden' name='ass_test_id' id='ass_test_id' value="<?php echo $ass_details['assess_test_id'];?>"/>
				<input type='hidden' name='timeconsume' id='timeconsume' value='Y' />
				<input type='hidden' name='jid' id='jid' value='<?php echo $_REQUEST['jid']; ?>' />
				<input type='hidden' name='group_id' id='group_id' value='<?php echo $group_info['group_id']; ?>' />
				<input type='hidden' name='totquest' id='totquest' value='<?php echo count($testdetails);?>' />
				<div class="test-head-section">
					<div class="d-flex align-items-center justify-content-between">
						<div class="test-head">
							<div class="icon material-icons">assignment_turned_in</div>
							<div class="test-info">
								<div class="test-name">360 degree Feedback</div>
								<p class="test-content red-text">*As a Seeker Please give answers to all questions.</p>
							</div>
						</div>
						<?php
						if(!empty($ass_lang)){
							foreach($ass_lang as $ass_langs){
						?>
						<script>
						var lan="<?php echo $ass_langs['lang_id'];?>";
						 function view_language(){
							var lang=document.getElementById("lang_select").value;
							if(lang==""){
								$(".language").show();
								$(".language"+lan).hide();
								$(".language_d").show();
								$(".language_d"+lan).hide();
							}
							else{
								$(".language").hide();
								$(".language"+lan).show();
								$(".language_d").hide();
								$(".language_d"+lan).show();
							}
						 }
						</script>
						<?php 
							}
						}
						?>
						<!--<div class="time-head">
							<div class="">Select language</div>
							<div class="time-info">
								<select name="lang_select" id="lang_select" class="form-control" onchange="view_language();">
									<option value="">English</option>
									<?php foreach($ass_lang as $ass_langs){
										if(!empty($ass_langs['lang_id'])){ ?>
									<option value="<?php echo $ass_langs['lang_id'];?>"><?php echo $ass_langs['lang_name'];?></option>
									<?php }} ?>
								</select>
							</div>
						</div>-->
					</div>
				</div>
				<!-- TEST HEAD SECTION :END 
				<div class="space-40"></div>-->
				
				
				<div class="test-body">

					<h5>Feedback Process</h5>
					<hr/>
					<?php
					if(count($testdetails)>0){
						foreach($testdetails as $keys=>$testdetail){
							$key=$keys+1;
					?>	
					<div class="case-question-box">
						<div class="number"><?php echo $key;?></div>
						<div class="case-details">
							<div class="d-flex align-items-center justify-content-between">
								<label class="language name" style="font-size: 13px;"><?php echo $testdetail['element_id_edit'];?></label>
								<?php
								if(!empty($ass_lang)){
									foreach($ass_lang as $ass_langs){
										?>
										<label class='language<?php echo $ass_langs['lang_id'];?>' style='display:none;font-size:16px;'><?php echo $testdetail['element_language'];?></label>
										<?php
									}
								}
								?>
								<span class="note"></span>
							</div>
							<input type='hidden' id='question_<?php echo $key;?>' name='question[<?php echo $key;?>]'  value='<?php echo $testdetail['ques_element_id'];?>' >
							<input type='hidden' name='qtype' id='qtype_<?php echo $key;?>' value="S" />
							<div class="d-flex align-items-center justify-content-between">
								
								<?php
								$ran='';
								$valid='required';
								$respvals=array();
								$ss=UlsQuestionnaireMaster::viewfeedback_rating($testdetail['ques_id']);
								
								foreach($ss as $key1=>$sss){
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
		</div>
	</div>
</section>