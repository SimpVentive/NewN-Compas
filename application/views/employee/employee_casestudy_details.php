<script> 
<?php
echo "var time=".$ass_details['time_details'].";"; 
?>
</script>
<section class="main-section">
	<div class="container">
		<div class="row">
			<!-- TEST SECTION :BEGIN -->
			<div class="test-section">
			<form action='<?php echo BASE_URL;?>/employee/employee_test_casestudy' method='post' name='employeeTest' id='employeeTest' enctype='multipart/form-data'>
			<input type='hidden' name='testid' id='testid' value="<?php echo $test_id;?>"/>
			<input type='hidden' name='assid' id='assid' value="<?php echo $ass_id;?>" />
			<input type='hidden' name='empid' id='empid' value="<?php echo $emp_id;?>" />
			<input type='hidden' name='ttype' id='ttype' value="<?php echo $ass_details['assessment_type'];?>" /> 
			<input type='hidden' name='jid' id='jid' value='<?php echo $_REQUEST['jid']; ?>' />
			<input type='hidden' name='ass_test_id' id='ass_test_id' value="<?php echo $ass_test_id;?>" />
			<input type='hidden' name='timeconsume' id='timeconsume' value='<?php echo $ass_details['time_details'];?>' />
				<!-- TEST HEAD SECTION :BEGIN -->
				<div class="test-head-section">
					<div class="d-flex align-items-center justify-content-between">
						<div class="test-head">
							<div class="icon material-icons">search</div>
							<div class="test-info">
								<div class="test-name">Case Study</div>
								<!--<p class="test-content red-text">*Lorem Lipsum s simply a dummy text since 1800s.</p>-->
							</div>
						</div>
						<div class="time-head">
							<div class="time-icon material-icons">timer</div>
							<div class="time-info">
								<p class="time"><span class="minute" id="minute"><?php echo $ass_details['time_details']; ?></span><sub>min</sub> : <span class="minute" id="second">00</span><sub>Sec</sub></p>
								<span class="text">Time taken</span>
							</div>
						</div>
					</div>
				</div>
				<!-- TEST HEAD SECTION :END -->

				<!-- TEST BODY :BEGIN -->
				<div class="case-study-section">
					<div class="test-body">
						<div class="row">
							<div class="col-6">
								<div class="test-header d-flex align-items-center justify-content-between">
									<div class="case-title">Case</div>
									<div style="padding-left:150px;">
										<a href="javascript:;" class="case-view-btn" data-toggle="modal" data-target="#competency-profile-modal-<?php echo $ass_id; ?>-<?php echo $pos_id; ?>" onclick="open_comp_details(<?php echo $ass_id; ?>,<?php echo $pos_id; ?>);">View Competency Profile</a>
									</div>
									<?php 
									if(!empty($case_details['casestudy_source'])){
									?>
									<a href="<?php echo BASE_URL; ?>/public/uploads/casestudy/<?php echo $case_details['casestudy_id'];?>/<?php echo $case_details['casestudy_source'];?>" class="case-view-btn" target="_blank">View PDF</a>
									<?php } ?>
									<a href="javascript:;" class="case-view-btn" data-toggle="modal" data-target="#intrays-case-modal<?php echo $case_details['casestudy_id'];?>" onclick="open_case(<?php echo $case_details['casestudy_id']; ?>);">View Complete Case</a>
								</div>
								<div class="case-scroll custom-scroll">
									<div class="case-body">
										<div class="question-content">
										<?php
										if(strlen(strip_tags($case_details['casestudy_description'])<=1300)){echo substr(($case_details['casestudy_description']),0, 1300).'...';}else{ echo substr(($case_details['casestudy_description']),0, 1300).'...';} ?>
										<?php //echo ltrim(strip_tags($case_details['casestudy_description'])); ?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-6">
								<div class="test-header d-flex align-items-center justify-content-between">
									<div class="case-title">Output</div>
								</div>
								<div class="case-scroll custom-scroll">
									<div class="case-body p-0">
										<ul class="nav nav-tabs align-items-center justify-content-center" role="tablist">
										<?php
										if(count($testdetails)>0){
											foreach($testdetails as $key=>$testdetailss){
												$count=count($testdetails);
											$ke=$key+1;
											$aria=($ke==1)?"true":"false";
											$actives=($ke==1)?"show active":"disabled";
											$tabs=($ke==$count)?"data-toggle='tab'":"";
											?>
											<li class="nav-item">
												<a class="nav-link <?php echo $actives; ?>" id="que-<?php echo $ke; ?>-tab" data-toggle='tab' href="#question-<?php echo $ke; ?>-tab" role="tab" aria-selected="<?php echo $aria; ?>">Question <?php echo $ke; ?></a>
											</li>
										<?php 
											}
										}?>
										</ul>
										<div class="tab-content">
											<?php
											$valid='required';
											if(count($testdetails)>0){
												foreach($testdetails as $keys=>$testdetail){
													$key=$keys+1; 
													$active=($key==1)?"show active":"";
													$var=($key==1)?"block":"none";
						
													?>
													<div <?php /*style='display:<?php echo $var;?>question_list<?php echo $key;?>*/ ?> id="question-<?php echo $key; ?>-tab" class="tab-pane fade <?php echo $active; ?>" role="tabpanel" aria-labelledby="question-<?php echo $key; ?>-tab">
														<div class="case-body">
															<div class="question-title">Question</div>
															<div class="question-content"><?php echo ltrim(($testdetail['casestudy_quest'])); ?></div>
															<?php 
															if(!empty($testdetail['casestudy_quest_lang'])){
															?>
															<div class="question-content"><?php echo ltrim(($testdetail['casestudy_quest_lang'])); ?></div>
															<?php
															}
															?>
															<input type='hidden' id='question_<?php echo $key; ?>' name='question[<?php echo $key; ?>]'  value='<?php echo $testdetail['question_id'];?>' >
															<input type='hidden' name='qtype' id='qtype_<?php echo $key; ?>' value='FT' />
															<input type='hidden' name='testid' id='testid' value='<?php echo $test_id;?>' />
															<input type='hidden' name='inb_assess_test_id' id='inb_assess_test_id' value="<?php echo $case_details['casestudy_id'];?>" />
															<input type='hidden' name='start_period' id='start_period' value='' />
															<?php 
															
															$valuename=UlsMenu::callpdorow("SELECT * FROM `uls_utest_responses_assessment` where utest_question_id in (SELECT `id` FROM `uls_utest_questions_assessment` where `employee_id`=".$_SESSION['emp_id']." and `assessment_id`=".$ass_id." and `test_id`=".$test_id." and `test_type`='".$ass_details['assessment_type']."' and event_id=".$ass_test_id." and user_test_question_id=".$testdetail['question_id'].")");
															$ched=isset($valuename['text'])?$valuename['text']:"";
															?>
															<div class="space-20"></div>
															<div class="question-title">Answer</div>
															<?php 
															if($ass_details['lang_process']=='Y'){
															?>
															<textarea class="validate[<?php echo $valid;?>] value" rows="4" name='answer_lang_<?php echo $key;?>[]' id='answer_<?php echo $key;?>' data-prompt-position='topLeft'><?php echo $ched; ?></textarea>
															<?php
															}
															else{
															?>
															<textarea class="validate[<?php echo $valid;?>] value" rows="4" name='answer_<?php echo $key;?>[]' id='answer_<?php echo $key;?>' data-prompt-position='topLeft'><?php echo $ched; ?></textarea>
															<?php 
															}
															?>
															<div class="space-20"></div>
															<?php 
															
															//echo $key."-".$count;
															if($key==$count){
															?>
															<div style='display:<?php echo $var;?>' id='question_upload<?php echo $key;?>'>
															<div class="question-title">Upload Attachment</div>
															<input type="file" name='casestudy_source_file'>
															</div>
															<?php } ?>
														</div>
													</div>
													<?php 
												}
											}?>
											
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- TEST BODY :END -->
				<?php
				if(count($testdetails)>0){
					foreach($testdetails as $keys=>$testdetail){
						
						$key_f=$keys+1;
						
						$var_footer=($key_f==1)?"block flex":"none";
						?>
						<div class="test-footer d-flex align-items-center justify-content-between" id='next<?php echo $key_f;?>' style='display:<?php echo $var_footer;?>' id='question_button<?php echo $key_f;?>'>
							<a href="javascript:;" class="btn btn-light nav-back-btn">Back</a>
							<?php
							$counts=count($testdetails);
							if($key_f<$counts){
							?>
							<button type="button" id="" class="next_question btn btn-primary nav-next-btn"  data-pre='<?php echo $key_f;?>' data-post='<?php echo ($key_f+1);?>'>Next</button>
							<?php
							}
							else{
							?>
							<button class='btn btn-primary nav-next-btn' type="submit" id='submit_ass'>Submit</button>
							<?php	
							}
							?>
							
						</div>
					<?php 
					}
				}?>
			</form>
			</div>
			<!-- TEST SECTION :END -->
		</div>
	</div>
</section>

<div class="modal fade case-modal" id="intrays-case-modal<?php echo $case_details['casestudy_id']; ?>" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div id="view_case<?php echo $case_details['casestudy_id']; ?>"></div>
		</div>
	</div>
</div>
<div class="modal fade case-modal" id="competency-profile-modal-<?php echo $ass_id; ?>-<?php echo $pos_id; ?>" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document" >
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title flex">Competency Profile for this Assessment</h5>
				<a href="javascript:;" class="close-modal" data-dismiss="modal" aria-label="Close">
					<i class="material-icons">close</i> Close
				</a>
			</div>
			<div class="case-info">
				
			</div>
			
			<div class="modal-body" >
					<div id="comp_details_<?php echo $ass_id; ?>_<?php echo $pos_id; ?>"></div>
				
				
			</div>
		</div>
	</div>
</div>