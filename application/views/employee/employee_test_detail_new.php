<style>
.btn-danger {
    color: #fff;
    background-color: #dc3545;
    border-color: #dc3545;
	height: 35px;
    padding: 0 40px;
    font-weight: 500;
    border-radius: 3px;
    line-height: 35px;
    border: none;
}
</style>
<script> 
<?php
echo "var time=".$total_time.";"; 
?>
</script>
<script> 
<?php
if(isset($_SESSION['pop_message'])){
	
?>
	$(document).ready(function(){
		$("#ass-pop-modal").modal('show');
	
	});
<?php
}
?>
</script>
<section class="main-section">
	<div class="container">
	
		<div class="row">
			
			<!-- TEST SECTION :BEGIN -->
				<div class="test-section">
				<form action='<?php echo BASE_URL;?>/employee/employee_test' method='post' name='employeeTest' id='employeeTest'>
				<input type='hidden' name='testid' id='testid' value="<?php echo $ass_details['test_id'];?>" />
				<input type='hidden' name='assid' id='assid' value="<?php echo $ass_details['assessment_id'];?>" />
				<input type='hidden' name='empid' id='empid' value="<?php echo $_SESSION['emp_id'];?>" />
				<input type='hidden' name='ttype' id='ttype' value="<?php echo $ass_details['assessment_type'];?>" /> 
				<input type='hidden' name='ass_test_id' id='ass_test_id' value="<?php echo $ass_details['assess_test_id'];?>"/>
				<input type='hidden' name='timeconsume' id='timeconsume' value='Y' />
				<input type='hidden' name='jid' id='jid' value='<?php echo $_REQUEST['jid']; ?>' />
				<input type='hidden' name='totquest' id='totquest' value='<?php echo count($testdetails);?>' />
				<input type='hidden' name='comp_id' id='comp_id' value='<?php echo $_REQUEST['comp_id'];?>' />
				<input type='hidden' name='start_period' id='start_period' value='<?php echo date('Y-m-d h:i:s')?>' />
					<!-- TEST HEAD SECTION :BEGIN -->
					<div class="test-head-section">
						<div class="d-flex align-items-center justify-content-between">
							<div class="test-head">
								<div class="icon material-icons">assignment_turned_in</div>
								<div class="test-info">
									<div class="test-name"><?php echo $comp_details['comp_def_name'] ?></div>
									<p class="test-content red-text">*Please give answers to all questions.</p>
								</div>
							</div>
							<div class="time-head">
								<div class="time-icon material-icons">timer</div>
								<div class="time-info">
									<p class="time"><span class="minute" id="minute"><?php echo $total_time; ?></span><sub>min</sub> : <span class="minute" id="second">00</span><sub>Sec</sub></p>
									<span class="text">Remaining time</span>
								</div>
							</div>
						</div>
					</div>
					<!-- TEST HEAD SECTION :END -->
		
					<div class="space-40"></div>
					<div class="test-body">
						<div class="row">
							<div class="col-9">
								<ul class="test-process d-flex align-items-center">
									<?php
									if(count($testdetails)>0){
										$anstet="";
										foreach($testdetails as $key=>$testdetailss){
											$ke=$key+1;$cc=""; $bcolor="";
											if(!empty($testdetailss['answer'])){ 
												if(empty($anstet)){ 
													$anstet=$ke; 
												}
												else{ 
													$anstet=$anstet.",".$ke;
												} 
												$cc="onclick='openskipdiv($ke)'"; 
												$bcolor="green"; 
											}
											elseif($testdetailss['emp_view']==1){
												$bcolor="red"; 
											}
											if($ke==1){
												$cc="onclick='openskipdiv($ke)'";
											}
											?>
											<li class="flex"><a href='#' id='open_skip_question<?php echo $testdetailss['question_id'];?>' <?php echo $cc;?> onclick='openskipdiv(<?php echo $ke;?>)'><span class="question_color<?php echo $testdetailss['question_id'];?> <?php echo $bcolor; ?>"></span></a>
											<input type='hidden' id='skipvalue<?php echo $ke;?>' value=''>
											</li>
											<?php
										}
									}			
									?>
									<input type='hidden' id='totansweredquest' value='<?php echo $anstet;?>' >
								</ul>

								<?php
				
								if(count($testdetails)>0){
									foreach($testdetails as $keys=>$testdetail){
										$key=$keys+1;
										$type=$testdetail['question_type'];
										
										$var=isset($_REQUEST['nu'])?($_REQUEST['nu']==$key)?"block":"none":"none";
										$var_footer=isset($_REQUEST['nu'])?($_REQUEST['nu']==$key)?"block flex":"none":"none";
										if(!isset($_REQUEST['nu'])){
											$var=($key==1)?"block":"none";											
										}
										if(!isset($_REQUEST['nu'])){
											$var_footer=($key==1)?"block flex":"none";											
										}
										
										if(!empty($ass_details['lang_id'])){
											$lang_qname=UlsQuestionsLanguage::get_question_lan_name($testdetail['question_id'],$ass_details['lang_id']);
											$question_name=$lang_qname['lang_question_name'];
										}
										else{
											$question_name=$testdetail['question_name'];
										}
									?>
								<div  style='display:<?php echo $var;?>' id='question_list<?php echo $key;?>' class="test_paper">
									<div class="test-body" >
										<div class="test-questions-text">Questions <?php echo $key;?> out of <?php echo count($testdetails); ?>:</div>
										<div class="question-title"><?php echo $question_name;?></div>
										<input type='hidden' id='question_<?php echo $key;?>' name='question[<?php echo $key;?>]'  value='<?php echo $testdetail['question_id'];?>' >
										<input type='hidden' name='qtype' id='qtype_<?php echo $key;?>' value="<?php echo $type;?>" />
										

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
												if(!empty($ass_details['lang_id'])){
													$lang_qname=UlsLangQuestionValues::get_question_lang_name($sss['value_id'],$ass_details['lang_id']);
													$value_name=$lang_qname['text'];
												}
												else{
													$value_name=$sss['text'];
												}
												?>
												
													<div class="ans-radio-group">
													
														<input id="answer_<?php echo $key;?>_<?php echo $key1;?>[]" type="radio" <?php echo $ched;?>  value='<?php echo $sss['value_id'];?>' name='answer_<?php echo $key;?>[]' class="radio-control validate[<?php echo $valid;?>]">
														<label for="answer_<?php echo $key;?>_<?php echo $key1;?>[]" class="label"><?php echo $value_name;?></label>
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
										<a href="#" class="btn btn-primary">Submit</a>
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
										elseif($key==$count){
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
							</div>
							<div class="col-3">
								<div style="overflow-y:auto; height:50vh;">
								
								<?php
								
								foreach($ass_comp as $ass_comps){
									//if($ass_comps['comp_def_id']!=$_REQUEST['comp_id']){
									$testdetails_comp=UlsMenu::callpdo("select a.competency_id,a.sequence,b.question_id,b.question_name,b.question_type,a.answer,a.emp_view from uls_utest_employee_question a ,uls_questions b where a.question_id=b.question_id and a.test_id=".$ass_details['test_id']." and a.ass_test_id=".$ass_details['assess_test_id']." and a.competency_id=".$ass_comps['comp_def_id']." and a.assessment_id=".$ass_details['assessment_id']." and a.employee_id=".$_SESSION['emp_id']);
									$testdetails_comp_count=UlsMenu::callpdorow("select count(a.answer) as ans_count from uls_utest_employee_question a where a.test_id=".$ass_details['test_id']." and a.ass_test_id=".$ass_details['assess_test_id']." and a.competency_id=".$ass_comps['comp_def_id']." and a.assessment_id=".$ass_details['assessment_id']." and a.employee_id=".$_SESSION['emp_id']);
									$test_status=UlsUtestAttemptsAssessment::getattempttest_comp_status($ass_details['assessment_id'],$ass_details['assess_test_id'],$_SESSION['emp_id'],$ass_comps['comp_def_id']);
								?><style>.bgred{background:red;color:#fff;} .bggreen{ background:green;color:#fff;}.bggrey{ background:#DFDFDF;color:#fff;}</style>
									<div class="case-question-box responses-box">
										<div class="case-details">
											<label class="name"><?php echo $ass_comps['comp_def_name']; ?></label>
											<?php 
											/*if($test_status['attempt_status']=='COM' && ($testdetails_comp_count['ans_count']==$ass_comps['assessment_que_count'])){
											?>
												<span>Completed</span>
											<?php
											}
											else{*/
												if(count($testdetails_comp)>0){$ke=0;
													foreach($testdetails_comp as $key=>$testdetails_comps){
														$ke=$ke+1;$bcolor="";
														if(!empty($testdetails_comps['answer'])){
															$bcol="bggreen";
														}
														elseif($testdetails_comps['emp_view']==1){
															$bcol="bgred";
														}
														else{
															$bcol="bggrey";
														}
													?>
													<a href="<?php echo BASE_URL; ?>/employee/employee_test_detail_new?jid=<?php echo $_REQUEST['jid'];?>&assess_test_id=<?php echo $_REQUEST['assess_test_id'];?>&comp_id=<?php echo $ass_comps['comp_def_id'];?>&nu=<?php echo $ke; ?>"><span class="number question_<?php echo $ass_comps['comp_def_id']; ?>_<?php echo $testdetails_comps['question_id']; ?> <?php echo $bcol ?>"><?php echo $ke; ?></span></a>
													<?php 
													}
												}
												else{
													for ($x = 1; $x <= $ass_comps['assessment_que_count']; $x++) {
													?>
													  <a href="<?php echo BASE_URL; ?>/employee/employee_test_detail_new?jid=<?php echo $_REQUEST['jid'];?>&assess_test_id=<?php echo $_REQUEST['assess_test_id'];?>&comp_id=<?php echo $ass_comps['comp_def_id'];?>&nu=<?php echo $x; ?>"><span class="number bggrey question_<?php echo $ass_comps['comp_def_id']; ?>_<?php echo $x; ?>"><?php echo $x; ?></span></a>
													<?php
													}
												}
											/* } */
											?>
											<br style="clear:both;">
										</div>
									</div>
									
									
									
									
								<?php 
								} //}<span class="ans">&nbsp;</span>
								?>
								
								</div>
								<hr>
								<?php
								$test_status=UlsUtestAttemptsAssessment::get_total_value($ass_details['assessment_id'],$ass_details['assess_test_id'],$_SESSION['emp_id']);
								$testdetails_comp_count=UlsMenu::callpdorow("select count(a.answer) as ans_count from uls_utest_employee_question a where a.test_id=".$ass_details['test_id']." and a.ass_test_id=".$ass_details['assess_test_id']." and a.assessment_id=".$ass_details['assessment_id']." and a.employee_id=".$_SESSION['emp_id']);
								
								if(count($test_status)==count($ass_comp) && ($testdetails_comp_count['ans_count']==$ass_details['no_questions'])){
								?>
								<a href="javascript:;" data-toggle="modal" data-target="#ass-pop-modal-confirmation" class="btn btn-success">Submit All</a>
								
								<?php } ?>
							</div>
						</div>
					</div>
				</form><!-- TEST SECTION :END -->
			</div>
		</div>
	</div>
</section>

<div class="modal fade case-modal" id="ass-pop-modal" tabindex="-1" role="dialog" data-backdrop="static">
	<div class="modal-dialog" role="document" >
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title flex">Confirmation</h5>
			</div>
			<div class="case-info">
				
			</div>
			<div class="modal-body" >
				<p>You have completed the assessment, Do you want to review or Submit?</p>
				<a href="<?php echo BASE_URL; ?>/employee/employee_test_detail_new?jid=<?php echo $_REQUEST['jid'];?>&assess_test_id=<?php echo $_REQUEST['assess_test_id'];?>&comp_id=<?php echo $_REQUEST['comp_id'];?>&re=1" class="btn btn-warning">Review</a>&nbsp;&nbsp;&nbsp;
				<a href="<?php echo BASE_URL; ?>/employee/employee_demographic_details?jid=<?php echo $_REQUEST['jid'];?>&ass_id=<?php echo $ass_details['assessment_id'];?>&pos_id=<?php echo $ass_details['position_id'];?>&assess_test_id=<?php echo $_REQUEST['assess_test_id'];?>" class="btn btn-success">Submit</a>
				
			</div>
		</div>
	</div>
</div>

<div class="modal fade case-modal" id="ass-pop-modal-confirmation" tabindex="-1" role="dialog" data-backdrop="static">
	<div class="modal-dialog" role="document" >
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title flex">Confirmation</h5>
			</div>
			<div class="case-info">
				
			</div>
			<div class="modal-body" >
				<p>Once Submitted, you will not be able to review the questions, do you want to proceed further?</p>
				<a href="<?php echo BASE_URL; ?>/employee/employee_demographic_details?jid=<?php echo $_REQUEST['jid'];?>&ass_id=<?php echo $ass_details['assessment_id'];?>&pos_id=<?php echo $ass_details['position_id'];?>&assess_test_id=<?php echo $_REQUEST['assess_test_id'];?>" class="btn btn-primary">Yes</a>&nbsp;&nbsp;&nbsp;
				<a href="javascript:;" class="btn btn-danger" data-dismiss="modal" aria-label="Close" >No</a>
			</div>
		</div>
	</div>
</div>
