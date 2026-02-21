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
				<!-- TEST HEAD SECTION :BEGIN -->
				<form action='<?php echo BASE_URL;?>/employee/employee_test' method='post' name='employeeTest' id='employeeTest'>
				<input type='hidden' name='testid' id='testid' value="<?php echo $ass_details['test_id'];?>" />
				<input type='hidden' name='assid' id='assid' value="<?php echo $ass_details['assessment_id'];?>" />
				<input type='hidden' name='empid' id='empid' value="<?php echo $_SESSION['emp_id'];?>" />
				<input type='hidden' name='ttype' id='ttype' value="<?php echo $ass_details['assessment_type'];?>" /> 
				<input type='hidden' name='ass_test_id' id='ass_test_id' value="<?php echo $ass_details['assess_test_id'];?>"/>
				<input type='hidden' name='timeconsume' id='timeconsume' value='Y' />
				<input type='hidden' name='jid' id='jid' value='<?php echo $_REQUEST['jid']; ?>' />
				<input type='hidden' name='totquest' id='totquest' value='<?php echo count($testdetails);?>' />
				<input type='hidden' name='start_period' id='start_period' value='' />
				<div class="test-head-section">
					<div class="d-flex align-items-center justify-content-between">
						<div class="test-head">
							<div class="icon material-icons">assignment_turned_in</div>
							<div class="test-info">
								<div class="test-name">Test</div>
								<p class="test-content red-text">*Please give answers to all questions.</p>
							</div>
						</div>
						<div class="time-head">
							<div class="time-icon material-icons">timer</div>
							<div class="time-info">
								<p class="time"><span class="minute" id="minute"><?php echo $ass_details['time_details']; ?></span><sub>min</sub> : <span class="minute" id="second">00</span><sub>Sec</sub></p>
								<span class="text">Remaining time</span>
							</div>
						</div>
					</div>
				</div>
				<!-- TEST HEAD SECTION :END -->

				<div class="space-40"></div>

				<ul class="test-process d-flex align-items-center">
					<?php
					if(count($testdetails)>0){
						$anstet="";
						foreach($testdetails as $key=>$testdetailss){
							$ke=$key+1;$cc=""; $bcolor="";
							if(!empty($testdetailss['answer'])){ if(empty($anstet)){ $anstet=$ke; }else{ $anstet=$anstet.",".$ke;} $cc="onclick='openskipdiv($ke)'"; $bcolor="green"; }
							if($ke==1){
								$cc="onclick='openskipdiv($ke)'";
							}
							?>
							<li class="flex"><a href='#' id='open_skip_question<?php echo $testdetailss['question_id'];?>' <?php echo $cc;?>><span class="question_color<?php echo $testdetailss['question_id'];?> <?php echo $bcolor; ?>"></span></a>
							<input type='hidden' id='skipvalue<?php echo $ke;?>' value=''>
							</li>
							<?php
						}
					}			
					?>
					<input type='hidden' id='totansweredquest' value='<?php echo $anstet;?>' >
				</ul>

				<!-- TEST BODY :BEGIN -->
				<?php
				if(count($testdetails)>0){
					foreach($testdetails as $keys=>$testdetail){
						$key=$keys+1;
						$type=$testdetail['question_type'];
						$var=($key==1)?"block":"none";
						$var_footer=($key==1)?"block flex":"none";
						$ques_lang_n=UlsQuestionsLanguage::get_question_language($testdetail['question_id']);
					?>
				<div  style='display:<?php echo $var;?>' id='question_list<?php echo $key;?>' class="test_paper">
					<div class="test-body" >
						<div class="test-questions-text">Questions <?php echo $key;?> out of <?php echo count($testdetails); ?>:</div>
						<div class="question-title"><?php echo $testdetail['question_name'];?></div>
						<?php
						if($ass_details['lang_process']=='Y'){
						if(!empty($ques_lang_n)){
							foreach($ques_lang_n as $ques_langs){
							?>
							<div class="question-title"><?php echo $ques_langs['question_name'];?></div>
							<?php
							}								
						}	
						}
						?>
						<input type='hidden' id='question_<?php echo $key;?>' name='question[<?php echo $key;?>]'  value='<?php echo $testdetail['question_id'];?>' >
						<input type='hidden' name='qtype' id='qtype_<?php echo $key;?>' value="<?php echo $type;?>" />
						
						<!--<div class="question-content">A. Potentiation: An increase in the toxicity of the pesticide.
							B. Synergism: The total effect is greater than the sum of the independent effect.
							C. Additive effect: Combining two or more pesticides, and the resulting toxicity is not more than the amount of either pesticide.
							D. Suspension : A solution of a pesticide with emulsifying agents in a water insoluble organic solvent which will form an emulsion when added to water</div>-->

						<div class="space-20"></div>
						<div class="answer-section">
						<?php
						$ran='';
						$valid='required';
						$respvals=array();
						$ss=UlsAssessmentTest::test_question_value($testdetail['question_id'],$ran);
						
						foreach($ss as $key1=>$sss){
							if($type=='F'){
								if(in_array($sss['value_id'],$respvals)){
									$valuename=Doctrine_Query::Create()->from('UlsUtestResponsesAssessment')->where("response_value_id=".$sss['value_id']." and assessment_id=".$ass_details['assessment_id']."  And employee_id=".$_SESSION['emp_id']." And test_type='".$ass_details['assessment_type']."' And event_id=".$ass_details['assess_test_id'])->fetchOne();
									$ched=$valuename->text; 
								}
								else {  $ched=""; }
						?>
							<div class="answer-section">
								<input type='text' value='<?php echo $ched;?>' class='validate[<?php echo $valid;?>] form-control col-12' name='answer_<?php echo $key;?>[]' id='answer_<?php echo $key;?>_<?php echo $key1;?>'/>
							</div>
						<?php 
							}
							else if($type=='S'){ 
								if(in_array($sss['value_id'], $respvals)){ 
									$ched="checked='checked'"; } 
								else {  
									$ched=""; 
								}
								if(!empty($testdetail['answer'])){ 
									if($sss['value_id']==$testdetail['answer']){ 
										$ched="checked='checked'"; 
									} else {  $ched=""; } 
								}
								?>
								
									<div class="ans-radio-group">
										<input id="answer_<?php echo $key;?>_<?php echo $key1;?>[]" type="radio" <?php echo $ched;?>  value='<?php echo $sss['value_id'];?>' name='answer_<?php echo $key;?>[]' class="radio-control validate[<?php echo $valid;?>]">
										<label for="answer_<?php echo $key;?>_<?php echo $key1;?>[]" class="label"><?php echo $sss['text'];?><br>
										<?php
										if($ass_details['lang_process']=='Y'){
										$ques_lan=UlsLangQuestionValues::get_all_lang_values($sss['value_id']);
										if(!empty($ques_lan)){
											foreach($ques_lan as $ques_langs){
											?>
											<?php echo $ques_langs['text'];?>
											<?php
											}
										}
										}
										?></label>
									</div>
								
								<?php
							}
						}
						?></div>
					</div>
				</div>
				<!-- TEST BODY :END -->

				<div class="test-footer d-flex align-items-center justify-content-between test_footer" style='display:<?php echo $var_footer;?>;' id='question_button<?php echo $key;?>'>
					<?php 
					$count=count($testdetails);
					if($type=='P'){
					?>
					<div>
						<a href="assessment-test-complete.php" class="btn btn-primary">Submit</a>
					</div>
					<?php
					}else{
						if($key==1){
							?>
							<div>
								
							</div>
							<div>
							<?php
							if(empty($testdetail['answer'])){
							?>
								<button class="btn btn-light skip_question" id='next' data='<?php echo $key; ?>'>Skip</button>
							<?php
							}
							?>
								<button class="btn btn-primary next_question" id='next' data='<?php echo $key; ?>'>Next</button>
							</div>
						<?php 
						}
						elseif($key<$count){?>
						<div>
							<button class="btn btn-primary pre_question" id='next' data='<?php echo $key; ?>'>Previous</button>
						</div>
						<div>
						<?php
						if(empty($testdetail['answer'])){
						?>
							<button class="btn btn-light skip_question" id='next' data='<?php echo $key; ?>'>Skip</button>
						<?php } ?>
							<button class="btn btn-primary next_question" id='next' data='<?php echo $key; ?>'>Next</button>
						</div>
						
						<?php 
						}
						elseif($key=$count){
						?>
						<div>&nbsp;</div>
						<div>
							<button class="btn btn-primary" onclick='return click_submit();' id='submit_ass'>Submit</button>
						</div>
						
						<?php }
					}						?>
					
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