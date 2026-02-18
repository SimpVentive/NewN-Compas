<section class="main-section">
	<div class="body-section">
		
		<div class="assessment-scroll-block">
			<div class="assessment-section">

				<div class="assessment-head">
					<div class="d-flex align-items-center justify-content-between">
						<div class="assessment-head-title"><?php  echo $emp_data['employee_number']."-".$emp_data['full_name'];?></div>
						
					</div>
					<ul class="assessment-info-list">
						<li class="assessment-item">
							<i class="icon material-icons">assignment_turned_in</i>
							<span class="align-middle"><?php 
								if($ass_data['skill_type']==1){
									echo "Level 2";
								}
								elseif($ass_data['skill_type']==2){
									echo "Level 3";
								}
								elseif($ass_data['skill_type']==3){
									echo "Level 4";
								}
								else{
									echo "Not Mapped";
								}
								?></span>
							<i class="info-icon material-icons">info</i>
						</li>
						<?php
						$total_correct=$test_results['score'];
						$total_qu=$ass_test_results['no_questions'];
						$total_per=$ass_test_results['pass_per'];
						$total_marks=round((($total_correct/$total_qu)*100),2);
						
						?>
						<li class="assessment-item">
							<span>Completion date: <?php echo $test_results['timestamp']; ?></span>
						</li>
						<li class="assessment-item">
							<span class="align-middle">Score : <b style="font-size:16px;color:blue"><?php echo ($total_correct);?>/<?php echo ($total_qu);?></b></span>
							
						</li>
					</ul>
					<ul class="assessment-info-list">
						<li class="assessment-item">
							<i class="icon material-icons bg-none">business_center</i>
							<span>Position: <?php echo $emp_data['position_name']; ?></span>
						</li>
						<li class="assessment-item">
							<i class="icon material-icons bg-none">date_range</i>
							<span>Start Date: <?php echo $ass_data['start_date'];?></span>
						</li>
						<li class="assessment-item">
							<i class="icon material-icons bg-none">date_range</i>
							<span>End Date: <?php echo $test_results['timestamp']; ?></span>
						</li>
					</ul>
				</div>
			</div>
			<div class="test-section">
			<form action='<?php echo BASE_URL;?>/manager/employee_skill_insert' method='post' name='employeeTest' id='employeeTest'>
				<input type="hidden" name="emp_id" id="emp_id" value="<?php echo $_REQUEST['emp_id']; ?>">
				<input type="hidden" name="ass_id" id="ass_id" value="<?php echo $_REQUEST['ass_id']; ?>">
				<input type="hidden" name="pos_id" id="pos_id" value="<?php echo $_REQUEST['pos_id'];?>">
				<input type="hidden" name="atest_id" id="atest_id" value="<?php echo $_REQUEST['atest_id'];?>">
				<input type="hidden" name="stype" id="stype" value="<?php echo $_REQUEST['stype'];?>">
				<input type="hidden" name="type" id="type" value="<?php echo $_REQUEST['type'];?>">
				<div class="test-nav-scoll custom-scroll">
					<div id="self-assessment" class="tast-tab-nav">
						<div class="test-body">
							<h5>Skill Evaluation</h5>
							<hr/>
							<?php 
							foreach($man_values as $key=>$man_value){
								$type=$man_value['question_type'];
							?>
							<div class="case-question-box">
								<div class="number"><?php echo ($key+1); ?></div>
								<div class="case-details">
									<div class="d-flex align-items-center justify-content-between">
										<label class="name"><?php echo $man_value['question_name']; ?></label>
										<input type='hidden' id='question_<?php echo $key;?>' name='question[<?php echo $key;?>]'  value='<?php echo $man_value['question_id'];?>' >
										<input type='hidden' id='ass_value_id_<?php echo $key;?>' name='ass_value_id[<?php echo $key;?>]'  value='<?php echo $man_value['ass_value_id'];?>' >
									</div>
									<div class="d-flex align-items-center">
									<?php
									$ran='';
									$valid='required';
									$respvals=array();
									$ss=UlsAssessmentTest::test_question_value($man_value['question_id'],$ran);
									foreach($ss as $key1=>$sss){
										if($type=='S'){ 
											if(in_array($sss['value_id'], $respvals)){ 
												$ched="checked='checked'"; } 
											else {  
												$ched=""; 
											}
											$value_name=$sss['text'];
											
											?>
											<div class="radio-group">
												<input id="answer_<?php echo $key;?>_<?php echo $key1;?>[]" type="radio"name='answer_<?php echo $key;?>[]' class="radio-control validate[<?php echo $valid;?>]" value='<?php echo $sss['value_id'];?>'>
												<label for="answer_<?php echo $key;?>_<?php echo $key1;?>[]" class="radio-label" ><?php echo $value_name;?>&nbsp;&nbsp;&nbsp;&nbsp;</label>
											</div>
									<?php 
										}
									}
									?>									
									</div>
								</div>
							</div>
							<?php 
							}
							?>
						</div>

					</div>
					
				</div>
				<div class="test-footer align-items-center justify-content-between">
					<button type="submit" name="submit" id="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
			</div>
			
		</div>
		
	</div>
</section>
<script>
$(document).ready(function(){
	$('#employeeTest').validationEngine();
	
});
</script>