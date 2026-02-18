<script>
$(document).ready(function(){
	$("#feedback").validationEngine();
	
});
function open_skip_button(){
	var position_id=document.getElementById('position_id').value;
	var assessment_pos_id=document.getElementById('assessment_pos_id').value;
	var assessment_id=document.getElementById('assessment_id').value;
	var asstype=document.getElementById('asstype').value;
	var pro=document.getElementById('pro').value;
	var jid=document.getElementById('jid').value;
	var emp_id=document.getElementById('emp_id').value;
	var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			//document.getElementById('text').innerHTML=xmlhttp.responseText;
			window.location.href =BASE_URL+"/employee/employee_assessment_details?jid="+jid+"&pro="+pro+"&asstype="+asstype+"&assessment_id="+assessment_id+"&position_id="+position_id+"&assessment_pos_id="+assessment_pos_id; 
		}
	}
	xmlhttp.open("GET",BASE_URL+"/employee/employee_feedback_skip?position_id="+position_id+"&assessment_pos_id="+assessment_pos_id+"&assessment_id="+assessment_id+"&asstype="+asstype+"&pro="+pro+"&jid="+jid,true);
	xmlhttp.send();
}
</script>
<section class="main-section">
	<div class="container">
		<div class="">
			<!-- TEST SECTION :BEGIN -->
			<form action="<?php echo BASE_URL;?>/employee/employee_demographic_insert" method="post" id="demographic_master" name="demographic_master">
			<input type='hidden' name='emp_id' id='emp_id' value="<?php echo $_SESSION['emp_id'];?>" />
			<input type='hidden' name='position_id' id='position_id' value="<?php echo $_REQUEST['pos_id'];?>"/>
			<input type='hidden' name='assessment_id' id='assessment_id' value="<?php echo $_REQUEST['ass_id'];?>" />
			<input type='hidden' name='jid' id='jid' value='<?php echo $_REQUEST['jid']; ?>' />
			<input type='hidden' name='feed_id' id='feed_id' value='' />
			<div class="test-section">
				<div class="test-head-section">
					<div class="d-flex align-items-center justify-content-between">
						<div class="test-head">
							<div class="icon material-icons">assignment_turned_in</div>
							<div class="test-info">
								<div class="test-name">Demographics </div>
								<p class="test-content" style="color:red;">* are mandatory feilds.</p>
							</div>
						</div>
						
					</div>
				</div>
				<div class="">
					<div class="row">
						<div class="col-12">
							<div class="test-body">
								<div class="row flex">
									
									<div class="col-3">
										<label class="label text-right">Email id<sup><font color="#FF0000">*</font></sup>:</label>
										<input type="text" class="validate[required,custom[email]] form-control" name="email" id="email">
									</div>
									<div class="col-3">
										<label class="label text-right">DOB(DD-MM-YYYY)<sup><font color="#FF0000">*</font></sup>:</label>
										<input type="date" class="validate[required] form-control" name="date_of_birth" id="date_of_birth">
									</div>
									
									<div class="col-3">
										<label class="label text-right">Gender<sup><font color="#FF0000">*</font></sup>:</label>
										<select class="validate[required] form-control" name="gender" id="gender">
											<option value="">Select</option>
											<option value="M">Male</option>
											<option value="F">Female</option>
										</select>
									</div>
									<div class="col-3">
										<label class="label text-right">Place<sup><font color="#FF0000">*</font></sup>:</label>
										<input type="text" class="validate[required] form-control" name="emp_location" id="emp_location">
									</div>
								</div>
								<div class="space-20"></div>
								<div class="row flex">
									
									<div class="col-4">
										<label class="label text-right">Qualification<sup><font color="#FF0000">*</font></sup>:</label>
										<input type="text" class="validate[required] form-control" name="edu_qualification" id="edu_qualification">
									</div>
									<div class="col-4">
										<label class="label text-right">College<sup><font color="#FF0000">*</font></sup>:</label>
										<input type="text" class="validate[required] form-control" name="edu_college" id="edu_college">
									</div>
									<div class="col-4">
										<label class="label text-right">% Marks Scored in the Qualifying Exam<sup><font color="#FF0000">*</font></sup>:</label>
										<input type="text" class="validate[required] form-control" name="per_scored" id="per_scored">
									</div>
								</div>
								<div class="space-20"></div>
								<div class="row flex">
									<div class="col-6">
										<label class="label text-right">Address<sup><font color="#FF0000">*</font></sup>:</label>
										<textarea class="form-control" rows="2" name="emp_address" id="emp_address"></textarea>
									</div>
									<div class="col-6">
										<label class="label text-right">Academic Achievements:</label>
										<textarea class="form-control" rows="2" name="emp_acadamic" id="emp_acadamic"></textarea>
									</div>
									
								</div>
								<div class="space-20"></div>
								<div class="row flex">
									
									<div class="col-6">
										<label class="label text-right">Professional Achievements:</label>
										<textarea class="form-control" rows="2" name="emp_pro_achievement" id="emp_pro_achievement"></textarea>
									</div>
									<div class="col-6">
										<label class="label text-right">Hobbies:</label>
										<textarea class="form-control" rows="2" name="emp_hobbies" id="emp_hobbies"></textarea>
									</div>
								</div>
							</div>
							
						</div>
					</div>
					<h3>Feedback</h3>
					<div class="row">
						
						<div class="col-6">
							<div class="test-body">
								<div class="question-title">1.) How did you find the overall process<sup><font color="#FF0000">*</font></sup></div>
								
								<div class="space-20"></div>

								<div class="answer-section">
									<input id="ans-ac" type="radio" name="Q1" value="1" class="validate[required] radio-control">
									<label for="ans-ac" class="label">Poor</label>
									<span class="radio_space"></span>
									<input id="ans-abc" type="radio" name="Q1" value="2" class="validate[required] radio-control">
									<label for="ans-abc" class="label">Average</label>
									<span class="radio_space"></span>
									<input id="ans-abcd" type="radio" name="Q1" value="3" class="validate[required] radio-control">
									<label for="ans-abcd" class="label">Good</label>
									<span class="radio_space"></span>
									<input id="ans-none" type="radio" name="Q1" value="4" class="validate[required] radio-control">
									<label for="ans-none" class="label">Very Good</label>
									<span class="radio_space"></span>
									<input id="ans-none" type="radio" name="Q1" value="5" class="validate[required] radio-control">
									<label for="ans-none" class="label">Excellent</label>
								</div>
							</div>
							<?php /* <div class="test-body">
								<div class="question-title">2.) How do you rate each of the Methods used<sup><font color="#FF0000">*</font></sup></div>
								<b>1. MCQs</b>
								<div class="space-20"></div>

								<div class="answer-section">
									<input id="ans-ac1" type="radio" name="Q21" value="1" class="validate[required] radio-control">
									<label for="ans-ac" class="label">InAppropriate</label>
									<span class="radio_space"></span>
									<input id="ans-abc2" type="radio" name="Q21" value="2" class="validate[required] radio-control">
									<label for="ans-abc" class="label">Neither App. or InApp</label>
									<span class="radio_space"></span>
									<input id="ans-abcd3" type="radio" name="Q21" value="3" class="validate[required] radio-control">
									<label for="ans-abcd" class="label">Appropriate</label>
									<span class="radio_space"></span>
									<input id="ans-abcd4" type="radio" name="Q21" value="4" class="validate[required] radio-control">
									<label for="ans-abcd" class="label">Not Applicable</label>
								</div>								
								
							</div> */ ?>
						</div>
						<div class="col-6">
							<?php /* <div class="test-body">
								<div class="question-title">3.) If you have to take a person reporting to you (new hire) would you think that a similar process at a time of recuitment/hiring, would you enhance the process<sup><font color="#FF0000">*</font></sup></div>
								
								<div class="space-20"></div>

								<div class="answer-section">
									<input id="ans-ac-y" type="radio" name="Q3" value="1" class="validate[required] radio-control">
									<label for="ans-ac" class="label">Yes</label>
									<span class="radio_space"></span>
									<input id="ans-abc-n" type="radio" name="Q3" value="2" class="validate[required] radio-control">
									<label for="ans-abc" class="label">No</label>
								
									
								</div>
							</div>*/ ?>
							<div class="test-body">
								<div class="question-title">2.) Any Other Feedback or Comments on the process, so as to improve/refine it<sup><font color="#FF0000">*</font></sup></div>
								
								<div class="space-20"></div>

								<div class="answer-section">
									<textarea class="validate[required]  value form-control" rows="2" name="Q4" id="Q4" data-prompt-position='topLeft'></textarea>
									
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="test-footer d-flex align-items-center justify-content-between">
					<!--<div>
						<a href="#" class="btn btn-primary" onclick="open_skip_button();">Skip</a>
					</div>-->
					<div>
						<button class='btn btn-primary' type="submit" id='submit_ass'>Submit</button>
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
</section>
<script>
$(document).ready(function(){
	$('#demographic_master').validationEngine();
});
</script>
	