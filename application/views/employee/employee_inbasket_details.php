<script>
<?php
foreach($_REQUEST as $key=>$val){
	if($key=="status"){
		echo "var ".$key."='".$val."';";
	}
}
if(isset($_SESSION['inbasket_time'])){
	if(!empty($_SESSION['inbasket_time'])){
		$time=explode(":",$_SESSION['inbasket_time']);
		echo "var time_spend=".(($time[0]*60*1000)+($time[1]*1000)).";";
	}
	else{
	echo "var time_spend=0;";
	}
}

else{
	echo "var time_spend=0;";
}
echo "var time=".$ass_details['time_details'].";"; 
?>
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
							<div class="icon material-icons">desktop_mac</div>
							<div class="test-info">
								<div class="test-name">Inbasket</div>
								<p class="test-content red-text">**The Intray card are in random order. Please set your prioritization with the action.</p>
							</div>
							<div class="d-flex align-items-center justify-content-between">
								
								<a href="javascript:;" class="case-view-btn" data-toggle="modal" data-target="#competency-profile-modal-<?php echo $ass_id; ?>-<?php echo $pos_id; ?>" onclick="open_comp_details(<?php echo $ass_id; ?>,<?php echo $pos_id; ?>);">View Competency Profile</a>
							</div>
						</div>
						<div class="time-head">
							<div class="time-icon material-icons">timer</div>
							<div class="time-info">
								<?php
								if(($_REQUEST['status']=='career') || ($_REQUEST['status']=='strength') || ($_REQUEST['status']=='development')){
									if(!empty($_SESSION['inbasket_time'])){
										$time_spent=explode(":",$_SESSION['inbasket_time']);
									?>
									<p class="time">
									<span class="minute" id="minute">
									<?php echo $time_spent[0]; ?>
									</span>
									<sub>min</sub> : 
									<span class="minute" id="second"><?php echo $time_spent[1]; ?></span><sub>Sec</sub></p>
									<span class="text">Time taken</span>
									<?php	
									}
									else{
									?>
									<p class="time">
									<span class="minute" id="minute">
									<?php echo $ass_details['time_details']; ?>
									</span>
									<sub>min</sub> : 
									<span class="minute" id="second">00</span><sub>Sec</sub></p>
									<span class="text">Time taken</span>
									<?php									
									}
								?>
									
								<?php
								}
								else{
								?>
								<p class="time">
								<span class="minute">
								<?php echo $ass_details['time_details']; ?>
								</span>
								<sub>min</sub> : 
								<span class="minute" >00</span><sub>Sec</sub></p>
								<span class="text">Time Period</span>
								<?php
								}
								?>
							</div>
						</div>
						
					</div>
				</div>
				<!-- TEST HEAD SECTION :END -->

				<div class="space-40"></div>

				<ul class="test-nav-panel d-flex align-items-center">
					<?php
					
					if(isset($_REQUEST['assess_test_id'])){
						$action_button=($inbasket_details['inbasket_reason']=='N' || $inbasket_details['inbasket_reason']=='')?"Actionize Intrays":"Your Priority";
					?>
					<li class="flex active" data-tab-id="read-complete-instruction" id='instruction_li'>
						<span class="num">1</span>
						<span class="txt">Intro & Instructions</span>
					</li>
					<li class="flex" data-tab-id="read-complete-scenerio" id='compentencies_li'>
						<span class="num">2</span>
						<span class="txt">Scenario</span>
					</li>
					<li class="flex" data-tab-id="see-intrays" id='employees_li'>
						<span class="num">3</span>
						<span class="txt">See Intrays</span>
					</li>
					<li class="flex" data-tab-id="pritorize-the-intrays" id='strengths_li'>
						<span class="num">4</span>
						<span class="txt">Prioritize the Intrays</span>
					</li>
					<li class="flex" data-tab-id="actionize-intrays" id='development_li'>
						<span class="num">5</span>
						<span class="txt"><?php echo $action_button; ?></span>
					</li>
					<?php }
					else{
					?>
					<li class="flex active" data-tab-id="read-complete-instruction" id='instruction_li'>
						<span class="num">1</span>
						<span class="txt">Intro & Instructions</span>
					</li>
					<li class="flex">
						<span class="num">2</span>
						<span class="txt">Scenario</span>
					</li>
					<li class="flex">
						<span class="num">3</span>
						<span class="txt">See Intrays</span>
					</li>
					<li class="flex">
						<span class="num">4</span>
						<span class="txt">Prioritize the Intrays</span>
					</li>
					<li class="flex">
						<span class="num">5</span>
						<span class="txt"><?php echo $action_button; ?></span>
					</li>
					<?php
					}
					?>
				</ul>

				<!-- TEST BODY :BEGIN -->
					<div id="read-complete-instruction" class="tast-tab-nav">
						<form action="<?php echo BASE_URL;?>/employee/inbasket_int_submit" method="post"  id="tab_summary_sumbit">
						<input type='hidden' class="timespent" name='time_period' id='time' value='<?php echo !empty($_SESSION['inbasket_time'])?$_SESSION['inbasket_time']:""; ?>' />
						<input type="hidden" name="assess_test_id" value="<?php echo $_REQUEST['assess_test_id'];?>" >
						<input type="hidden" name="in_id" value="<?php echo $_REQUEST['in_id'];?>" >
						<input type="hidden" name="test_id" value="<?php echo $_REQUEST['test_id'];?>" >
						<input type="hidden" name="jid" value="<?php echo $_REQUEST['jid'];?>" >
						<div class="test-nav-scoll">
						
							<div class="test-body">
								
								<div class="question-title">Introduction:</div>
								<div class="question-content">
								An Inbasket or an Intray is a list of items of work that need to be to be attended to when you come to work. These could include mails, calls (mobile, intercom), reports, meetings, visits by you or by others, etc. For the various items in the inbasket/intray, there would be a certain approach you would take – for exampling first attending the mail items, or the work from the previous day; and for each of them you would decide the kind of action you want to take and/or delegate the same. Whatever you decide, is a reflection of your style of work and also tells how you prioritize and plan your work.
								</div>
								
								<div class="question-content">
								The Intrays are created in a certain Scenario; which is  a narrative of the context in which you will have to do the Intrays.  Read it to get a feel of the person who shall role play and the context/situation in which he/she is. 
								</div>
								<div class="space-40"></div>
								<div class="question-title">Instructions for the InTray Exercise:</div>
								<div class="question-content">
								<?php 
								if($inbasket_details['inbasket_reason']=='N' || $inbasket_details['inbasket_reason']==''){
								?>
								1.&nbsp;The Intrays have been arranged in a Random Order. 
								2.&nbsp;First make sure you have read all the Intrays (click on Read Full Intray to view the complete details) 
								3.&nbsp;Once you have read all the Intrays, you are ready to Prioritize the same, that is you will want to do the various intrays in a particular order – a sequence which you feel is the appropriate way to address the various issues (intrays).
								4.&nbsp;You can prioritize the various intrays by dragging them to the box/sequence where you want it.  For instance if you want to first address Intray # 6, you could drag it and drop it at Box 1.  This will indicate that you have given the top priority to Item # The same information, that is, what priority you have given will appear in the Table on the right.  
								5.&nbsp;Once you have prioritized, you would need to indicate what Action you would want to take.  This could include what data you want to collect, what analysis you want to present, mail reply that you need to give, what instructions you want to give to your subordinate (in case you are delegating the same). <b style="font-size:16px;text-decoration: underline;color:red;">Your action details will indicate to the assessor your approach to the whole intray, as well as your knowledge – so make sure you give detail instructions (factoring in the time)</b>
								<?php 
								}
								else{
								?>
								1.The Intrays have been arranged in a Random Order.  You will find that the proposed action (that is what the necessary action for a given item) has been provided. 
								2.First make sure you have read all the Intrays (click on Read Full Intray to view the complete details) 
								3.Once you have read all the Intrays, you are ready to Prioritize the same, that is you will want to do the various intrays in a particular order – a sequence which you feel is the appropriate way to address the various issues (intrays). 
								4.You can prioritize the various intrays by dragging them to the box/sequence where you want it. For instance if  think that top priority is for Intray # 6, you could drag it and drop it at Box 1. This will indicate that you have given the top priority to Item # The same information, that is, what priority you have given will appear in the Table on the right. 
								5.  Once you have completed, you will have to click on NEXT.  NOTE, YOU CANNOT CHANGE ONCE YOU CLICK ON THIS BUTTON 
								6.  You can view how you have sorted, by clicking on the tab YOUR PRIORITY

								<?php
								}
								?>
								</div>
								<div class="question-content">
									YOU HAVE A TOTAL OF <b><?php echo $ass_details['time_details']; ?></b> MINUTES TO COMPLETE THIS EXCERCIZE.  THE CLOCK WILL START ONCE YOU REACH “SEE INTRAYS”.  
									<br>
									Please NOTE that if you don’t complete this within the allocated time, the system will automatically close.  So, plan your time accordingly.
								</div>
								<div class="space-40"></div>
								
							</div>
						</div>
						<div class="test-footer d-flex align-items-center justify-content-between">
							<a href="javascript:;" class="btn btn-light nav-back-btn">Back</a>
							<button type="submit" name="submit_int" class="btn btn-primary">Next</button>
						</div>
						</form>
					</div>
					<div id="read-complete-scenerio" class="tast-tab-nav">
						<form action="<?php echo BASE_URL;?>/employee/inbasket_one_submit" method="post"  id="tab_summary_sumbit">
						<input type='hidden' class="timespent" name='time_period' id='time' value='<?php echo !empty($_SESSION['inbasket_time'])?$_SESSION['inbasket_time']:""; ?>' />
						<input type="hidden" name="assess_test_id" value="<?php echo $_REQUEST['assess_test_id'];?>" >
						<input type="hidden" name="in_id" value="<?php echo $_REQUEST['in_id'];?>" >
						<input type="hidden" name="test_id" value="<?php echo $_REQUEST['test_id'];?>" >
						<input type="hidden" name="jid" value="<?php echo $_REQUEST['jid'];?>" >
						<div class="test-nav-scoll">
						
							<div class="test-body">
								<div class="question-title">Inbasket Background:</div>
								<div class="question-content"><?php echo nl2br($inbasket_details['inbasket_narration']); ?>
								</div>
								<?php 
								if(!empty($inbasket_details['inbasket_narration_lang'])){
								?>
								<div class="question-content"><?php echo nl2br($inbasket_details['inbasket_narration_lang']); ?>
								</div>
								<?php
								}?>
								<div class="space-40"></div>

								<!--<div class="question-title">How to do the Inbasket:</div>
								<div class="question-content"><?php echo nl2br($inbasket_details['inbasket_instructions']); ?>
								</div>-->
							</div>
						</div>
						<div class="test-footer d-flex align-items-center justify-content-between">
							<a href="javascript:;" class="btn btn-light nav-back-btn">Back</a>
							<button type="submit" name="submit_one" class="btn btn-primary">Next</button>
						</div>
						</form>
					</div>
					<div id="see-intrays" class="tast-tab-nav display-none">
						
						<form action="<?php echo BASE_URL;?>/employee/inbasket_two_submit" method="post"  id="inbasket_two_submit">
						<input type='hidden' class="timespent" name='time_period' id='time' value='<?php echo !empty($_SESSION['inbasket_time'])?$_SESSION['inbasket_time']:""; ?>' />
						<input type="hidden" name="assess_test_id" value="<?php echo $_REQUEST['assess_test_id'];?>" >
						<input type="hidden" name="in_id" value="<?php echo $_REQUEST['in_id'];?>" >
						<input type="hidden" name="test_id" value="<?php echo $_REQUEST['test_id'];?>" >
						<input type="hidden" name="jid" value="<?php echo $_REQUEST['jid'];?>" >
						<input type='hidden' name='ttype' id='ttype' value="INBASKET" />
						<input type='hidden' name='assid' id='assid' value="<?php echo $ass_id;?>" />
						<input type='hidden' name='start_period' id='start_period' value='<?php echo isset($_SESSION['inbasket_starttime'])?$_SESSION['inbasket_starttime']:""; ?>' />
						<div class="test-nav-scoll">
						<div class="test-body">
							<div class="question-title">Intrays</div>
							<p class="test-content red-text" style="color:red;font-size:11px;">**Please read all the Intrays  first and then Click on Next to sort the Intrays</p>
							
							<div class="case-section">
								<div class="row">
								<?php 
								if(count($testdetails)>0){
									foreach($testdetails as $keys=>$testdetail){
										$key=$keys+1; 
										$type=$testdetail['question_type'];
										$ran='ORDER BY RAND()';$j=0;
										$ss=UlsAssessmentTest::test_question_value($testdetail['question_id'],$ran);
										foreach($ss as $key1=>$sss){
											if($type=='P'){ 
											$j++;
											$parsed_json="";
											if(!empty($sss['inbasket_mode'])){												
												$parsed_json = json_decode($sss['inbasket_mode'], true);
											}
											?>
											<div class="col-3">
												<div class="case-item">
													<div class="case-name">Intray <?php echo $j; ?></div>
													<div class="case-txt">
													<?php if(strlen(strip_tags($sss['text'])<=250)){echo substr(strip_tags($sss['text']),0, 250).'...';}else{ echo substr(strip_tags($sss['text']),0, 250).'...';}?>
													</div>
													<a href="javascript:;" class="link" data-toggle="modal" data-target="#intrays-case-modal<?php echo $sss['value_id']; ?>" onclick="open_inbasket(<?php echo $sss['value_id']; ?>,<?php echo $j; ?>);">Read Full Intray</a>
												</div>
											</div>
											
											<?php
											}
										}
									}
								}?>
								</div>
								
							</div>
						</div>
						</div>
						<div class="test-footer d-flex align-items-center justify-content-between">
							<a href="javascript:;" class="btn btn-light nav-back-btn">Back</a>
							<button type="submit" name="submit_two" class="btn btn-primary">Next</button>
						</div>
						</form>
					</div>
					<div id="pritorize-the-intrays" class="tast-tab-nav display-none">
						
						<form action="<?php echo BASE_URL;?>/employee/inbasket_three_submit" method="post"  id="inbasket_three_submit">
						<input type='hidden' class="timespent" name='time_period' id='time' value='<?php echo !empty($_SESSION['inbasket_time'])?$_SESSION['inbasket_time']:""; ?>' />
						<input type="hidden" name="assess_test_id" value="<?php echo $_REQUEST['assess_test_id'];?>" >
						<input type="hidden" name="in_id" value="<?php echo $_REQUEST['in_id'];?>" >
						<input type="hidden" name="test_id" value="<?php echo $_REQUEST['test_id'];?>" >
						<input type="hidden" name="jid" value="<?php echo $_REQUEST['jid'];?>" >
						<input type='hidden' name='ttype' id='ttype' value="INBASKET" />
						<input type='hidden' name='assid' id='assid' value="<?php echo $ass_id;?>" />
						<input type='hidden' name='question'  value='<?php echo $inbasket_question['q_id'];?>' >
						<input type='hidden' name='start_period' id='start_period' value='<?php echo isset($_SESSION['inbasket_starttime'])?$_SESSION['inbasket_starttime']:""; ?>' />
						<div class="test-nav-scoll">
							<div class="test-body">
								<div class="row">
									<div class="col-10">
										<div class="question-title">Set Priority :</div>
										<p class="test-content red-text" style="color:red;font-size:11px;">**Drag the Intray to move it to the position you want it in.</p>
										<ul id="set-priority" class="case-section list-group list-group-sortable-connected">
											<?php 
										if(count($testdetails)>0){
											foreach($testdetails as $keys=>$testdetail){
												$key=$keys+1; 
												$type=$testdetail['question_type'];
												$j=0;
												$ss=UlsAssessmentTest::test_question_value($testdetail['question_id']);
												foreach($ss as $key1=>$sss){
													if($type=='P'){ 
													$j++;
													if(!empty($sss['inbasket_mode'])){		
														$parsed_json = json_decode($sss['inbasket_mode'], true);
													}
													?>
													<li data-case="<?php echo $j; ?>" data-value="<?php echo $sss['value_id']; ?>">
														<div class="case-item">
															<div class="case-name">Intray <?php echo $j; ?> <span class="move-icon material-icons">drag_indicator</span></div>
															
															<div class="case-txt" style="font-size:10px;">
															<?php
															if(!empty($parsed_json)){
																foreach($parsed_json as $key => $value){
																	$yes_stat="IN_MODE";
																	$val_code=UlsAdminMaster::get_value_name_statuss($yes_stat,$value['mode']);
																?>
																<b>From:</b> <?php if(strlen(strip_tags($value['from'])<=20)){echo substr(strip_tags($value['from']),0, 20).'...';}else{ echo substr(strip_tags($sss['from']),0, 20).'...';}?><br>
																<b>Mode:</b> <?php echo $val_code['name'];?><br>
																<b>Time:</b> <?php echo $value['period'];?><br>
																
																<?php
																}
															}
															?>
															</div>
															<a data-toggle="modal" data-target="#intrays-case-modal<?php echo $sss['value_id']; ?>" onclick="open_inbasket(<?php echo $sss['value_id']; ?>,<?php echo $j; ?>);" class="link">Read Full Intray</a>
														</div>
													</li>
													<?php
													}
												}
											}
										}?>
										</ul>

										<!--<div class="question-title">Intrays :</div>-->
										<ul class="list-group list-group-sortable-connected">
										
										</ul>
									</div>
									<div class="col-2">
										<div class="question-title">Your Prioritization :</div>
										
										<div id="sortable-cases">
										<?php 
										$res=UlsUtestResponsesAssessment::responce_values_inbasket($_SESSION['emp_id'],$_REQUEST['assess_test_id'],$ass_id);
										if(!empty($res['response_value_id'])){
										$value_scort=explode(",",$res['response_value_id']);
										?>
										<input type='hidden' name='utest_question_id'  value='<?php echo $res['utest_question_id'];?>' >
										<input type='hidden' name='user_test_response_id'  value='<?php echo $res['user_test_response_id'];?>' >
										<?php 
										if($ass_details['lang_process']=='Y'){
										?>
										<input type='hidden' name='save_text'  value='<?php echo $res['text_lang'];?>' >
										<?php 
										}
										else{
										?>
										<input type='hidden' name='save_text'  value='<?php echo $res['text'];?>' >
										<?php
										}
										?>
										<?php
										foreach($value_scort as $key=>$value_scorts){
											$intray_val=UlsQuestionValues::get_allquestion_values_edit($value_scorts);
										?>
											<div class="case-question-box responses-box p20">
												<div class="case-details"><label class="name">You have given Priority of <?php echo $key+1; ?></label><span class="ans">for the Intray <?php echo $intray_val['scorting_order'] ?></span><input type="hidden" name="val_id[<?php echo $value_scorts; ?>]" id="val_id[]" class="intray_values" value="<?php echo $value_scorts; ?>"></div>
											</div>
										<?php 
										}
										}?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="test-footer d-flex align-items-center justify-content-between">
							<a href="javascript:;" class="btn btn-light nav-back-btn">Back</a>
							<button type="submit" name="submit_three" class="btn btn-primary">Next</button>
						</div>
						</form>
					</div>
					<div id="actionize-intrays" class="tast-tab-nav display-none">
						
						<form action="<?php echo BASE_URL;?>/employee/inbasket_four_submit" method="post"  id="tab_four_sumbit">
						<input type="hidden" name="ass_test_id" value="<?php echo $_REQUEST['assess_test_id'];?>" >
						<input type="hidden" name="in_id" value="<?php echo $_REQUEST['in_id'];?>" >
						<input type="hidden" name="testid" value="<?php echo $_REQUEST['test_id'];?>" >
						<input type="hidden" name="jid" value="<?php echo $_REQUEST['jid'];?>" >
						<input type='hidden' name='assid' id='assid' value="<?php echo $ass_id;?>" />
						<input type='hidden' name='ttype' id='ttype' value="INBASKET" />
						<input type='hidden' class="timespent" name='time_period' id='time' value='<?php echo !empty($_SESSION['inbasket_time'])?$_SESSION['inbasket_time']:""; ?>' />
						<input type='hidden' name='start_period' id='start_period' value='<?php echo isset($_SESSION['inbasket_starttime'])?$_SESSION['inbasket_starttime']:""; ?>' />
						<input type='hidden' name='question'  value='<?php echo $inbasket_question['q_id'];?>' >
						<?php 
							$res=UlsUtestResponsesAssessment::responce_values_inbasket($_SESSION['emp_id'],$_REQUEST['assess_test_id'],$ass_id);
							if(!empty($res['response_value_id'])){
							$val=$res['response_value_id'];
							$values=explode(",",$res['response_value_id']);
						?>
						<input type='hidden' name='response_value_id'  value='<?php echo $val;?>' >
						<input type='hidden' name='utest_question_id'  value='<?php echo $res['utest_question_id'];?>' >
						<input type='hidden' name='user_test_response_id'  value='<?php echo $res['user_test_response_id'];?>' >
						<div class="test-nav-scoll">
							<?php
							//print_r($values);
							if(!empty($values)){
							?>
							<div class="test-body
								<?php
								if($inbasket_details['inbasket_reason']=='N' || $inbasket_details['inbasket_reason']==''){
								?>
								<div class="question-title">Actionize Intrays:</div>
								<?php
								}
								else{
								?>
								<div class="question-title">Your Priority:</div>
								<?php	
								}
								if($inbasket_details['inbasket_reason']=='N' || $inbasket_details['inbasket_reason']==''){
								?>
								<p style="color:red;">Note: On each, intray please indicate in detail the action you would take.<br>
								In case you want to delegate please give the required directions regarding the task.</p>
								<?php 
								}?>
								<div class="case-section">
									<div class="row">
									<?php
									$test_array=array();
									$test_array_lang=array();
									if(!empty($res['text'])){
									$text_val=json_decode($res['text']);
									$text_val_lang=json_decode($res['text_lang']);
									foreach($text_val as $text_vals){
										$id=$text_vals->id;
										$test_array[$id]['text']=$text_vals->text;
										$test_array[$id]['action']=$text_vals->action;
									}
									foreach($text_val_lang as $text_val_langs){
										$id=$text_val_langs->id;
										$test_array_lang[$id]['text']=$text_val_langs->text;
										$test_array_lang[$id]['action']=$text_val_langs->action;
									}
									
									/* echo "<pre>";
									print_r($test_array_lang);  */
									$k=1;
									$option=array('Action','Delegate','Hold','Other');
									foreach($values as $key=>$value){
										
										$intray_val=UlsQuestionValues::get_allquestion_values_edit($value);
									?>
										<div class="col-3">
											<div class="case-item">
												<div class="case-name">Intray <?php echo $intray_val['scorting_order']; ?></div>
												
												<div class="case-txt">
												<?php if(strlen(strip_tags($intray_val['text'])<=290)){echo substr(strip_tags($intray_val['text']),0, 290).'...';}else{ echo substr(strip_tags($intray_val['text']),0, 290).'...';}?>
												</div>
												<input type='hidden' value='<?php echo $intray_val['value_id']; ?>' name='answer[]'>
												
												<a href="javascript:;" class="link" data-toggle="modal" data-target="#intrays-case-modal<?php echo $intray_val['value_id']; ?>" onclick="open_inbasket(<?php echo $intray_val['value_id']; ?>,<?php echo $intray_val['scorting_order']; ?>);">Read Full Intray</a>
												<?php
												if($inbasket_details['inbasket_reason']=='N' || $inbasket_details['inbasket_reason']==''){
												?>
												<select class="action-case validate[required]" name='intray_action<?php echo $intray_val['value_id'];?>'>
													<option value="">Select action<sup><font color="#FF0000">*</font></sup></option>
													<?php 
													foreach($option as $options){
														$sel=isset($test_array[$value]['action'])?(($test_array[$value]['action']==$options)?"selected='selected'":""):"";
													?>
													<option value='<?php echo $options; ?>' <?php echo $sel; ?>><?php echo $options; ?></option>
													<?php } ?>
												</select>
												<?php 
												if($ass_details['lang_process']=='Y'){
												?>
												<textarea name='lang_process<?php echo $intray_val['value_id'];?>' class="case-description validate[required]" rows="3" placeholder="Hindi Description*"><?php echo isset($test_array_lang[$value]['text'])?$test_array_lang[$value]['text']:""; ?></textarea>
												<?php
												}
												else{
												?>
												<textarea name='answer_text<?php echo $intray_val['value_id'];?>' class="case-description validate[required]" rows="3" placeholder="Description*"><?php echo isset($test_array[$value]['text'])?$test_array[$value]['text']:""; ?></textarea>
												<?php
												}
												?>
												<?php } ?>
											</div>
										</div>
									
										<?php
										$k++;
									}
									}
									?>
									</div>
								</div>
							</div>
							<?php }
							}
							else{
							?>
							<div class="test-footer d-flex align-items-center justify-content-between">
								<a href="javascript:;" class="btn btn-light nav-back-btn" >Back</a>
							</div>
							<?php
							}
							?>
						</div>
						
						<div class="test-footer d-flex align-items-center justify-content-between">
							
							<?php 
							if(!empty($values) && ($_REQUEST['status']=='development')){
							
							if($inbasket_details['inbasket_reason']=='N' || $inbasket_details['inbasket_reason']==''){
							?>
							<a class="btn btn-light" data-toggle="modal" data-target="#competency-alert">Back</a>
							<?php
							}
							else{
							?>
							<a href="#" class="btn btn-light nav-back-btn" >Back</a>
							<?php
							}
							?>
							
							<button type="submit" name="submit_two" class="btn btn-primary">Submit</button>
							<?php }
							
							?>
						</div>
						</form>
				
					</div>
			
			<!-- TEST SECTION :END -->
			</div>
		</div>
	</div>
</section>
<?php 
if(count($testdetails)>0){
	foreach($testdetails as $keys=>$testdetail){
		$key=$keys+1; 
		$type=$testdetail['question_type'];
		$ran='ORDER BY RAND()';$j=0;
		$ss=UlsAssessmentTest::test_question_value($testdetail['question_id'],$ran);
		foreach($ss as $key1=>$sss){
			if($type=='P'){
				?>
				<div class="modal fade case-modal" id="intrays-case-modal<?php echo $sss['value_id']; ?>" tabindex="-1" role="dialog">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div id="view_inbasket<?php echo $sss['value_id']; ?>"></div>
						</div>
					</div>
				</div>
			<?php
			}
		}
	}
}?>

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


<div class="modal fade case-modal" id="competency-alert" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document" >
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title flex">Alert</h5>
				<a href="javascript:;" class="close-modal" data-dismiss="modal" aria-label="Close">
					<i class="material-icons">close</i> Close
				</a>
			</div>
			<div class="case-info">
				
			</div>
			
			<div class="modal-body" >
				<p>If you reprioritize the intrays the action details captured shall be deleted. Please copy the details elsewhere to proceed and click on Ok button</p>
				<a href="<?php echo BASE_URL;?>/employee/employee_inbasket_details?status=strength&jid=<?php echo $_REQUEST['jid'];?>&assess_test_id=<?php echo $_REQUEST['assess_test_id'];?>&in_id=<?php echo $_REQUEST['in_id'];?>&test_id=<?php echo $_REQUEST['test_id'];?>" class="btn btn-success">OK</a>
			</div>
		</div>
	</div>
</div>