<style>
.value{
	display: block;
    position: relative;
    padding: 4px 8px;
    width: 100%;
    font-size: 14px;
    resize: none;
    border: 1px solid #CCC;
    background-color: #FAFAFA;
    outline: none;
}
.radio_space{
	padding-right:20px;
}
.form-group {
    margin-bottom: 15px;
    font-size: 15px;
}
</style>
<script>
$(document).ready(function(){
	$("#feedback").validationEngine();
	
});
function open_reason(){
	var child=document.getElementById('radio_14');
	if(child.checked==true){
		document.getElementById('reason').style.display='block';
	}else{
		document.getElementById('reason').style.display='none';
	}
}
</script>
<div class="content">
	<div class="row projects">
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				<div class="hpanel">
					<div class="panel-body">
						<div class="form-wrap">
							<form action='<?php echo BASE_URL;?>/assessor/assessor_feedback_insert' method='post' name='feedback' id='feedback' enctype='multipart/form-data'>
								<input type='hidden' name='assessment_id' id='assessment_id' value="<?php echo $_REQUEST['assessment_id'];?>" />
								<input type='hidden' name='feed_id' id='feed_id' value='' />
								<div class="alert alert-info alert-dismissable">
									<h6 style="color:#fff;">Welcome to Feedback Process.</h6>
									<p></p>
									<p>We appreciate you taking the time and assessing various individuals/ employees and helping in drawing  up their development roadmaps.</p>
									<p>We are constantly improving the process and for that your feedback can be very valuable.</p>
									<p></p>
								</div>
								
								<div class="form-group">
									<label class="control-label mb-10" for="email_de">1. How do you find this process of Competency Assessment & Development, from an Assessor’s perspective</label>
									<div class="radio-list">
										<div class="radio-inline pl-0">
											<span class="radio">
												<input type="radio" name="Q1" id="radio_1" value="1" class="validate[required]">
												<label for="radio_1">Excellent</label>
											</span>
										</div>
										<div class="radio-inline">
											<span class="radio">
												<input type="radio" name="Q1" id="radio_2" value="2" class="validate[required]">
												<label for="radio_2">Very Good </label>
											</span>
										</div>
										<div class="radio-inline">
											<span class="radio">
												<input type="radio" name="Q1" id="radio_3" value="3" class="validate[required]">
												<label for="radio_3">Good </label>
											</span>
										</div>
										<div class="radio-inline">
											<span class="radio">
												<input type="radio" name="Q1" id="radio_4" value="4" class="validate[required]">
												<label for="radio_4">Average</label>
											</span>
										</div>
										<div class="radio-inline">
											<span class="radio">
												<input type="radio" name="Q1" id="radio_5" value="5" class="validate[required]">
												<label for="radio_5">Poor</label>
											</span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label mb-10" for="pwd_de">2. Do you think this process is objective in assessing individuals? </label>
									<div class="radio-list">
										<div class="radio-inline pl-0">
											<span class="radio">
												<input type="radio" name="Q2" id="radio_6" value="1" class="validate[required]">
												<label for="radio_6">Yes</label>
											</span>
										</div>
										<div class="radio-inline">
											<span class="radio">
												<input type="radio" name="Q2" id="radio_7" value="2" class="validate[required]">
												<label for="radio_7">No</label>
											</span>
										</div>
										
									</div>
								</div>
								<div class="form-group">
									<label class="control-label mb-10" for="pwd_de">3. This process will help in drawing up the Development roadmap of the Individual</label>
									<div class="radio-list">
										<div class="radio-inline pl-0">
											<span class="radio">
												<input type="radio" name="Q3" id="radio_8" value="1" class="validate[required]">
												<label for="radio_8">Strongly Disagree</label>
											</span>
										</div>
										<div class="radio-inline">
											<span class="radio">
												<input type="radio" name="Q3" id="radio_9" value="2" class="validate[required]">
												<label for="radio_9">Disagree</label>
											</span>
										</div>
										<div class="radio-inline">
											<span class="radio">
												<input type="radio" name="Q3" id="radio_10" value="3" class="validate[required]">
												<label for="radio_10">Neither Agree nor Disagree </label>
											</span>
										</div>
										<div class="radio-inline">
											<span class="radio">
												<input type="radio" name="Q3" id="radio_11" value="4" class="validate[required]">
												<label for="radio_11">Agree</label>
											</span>
										</div>
										<div class="radio-inline">
											<span class="radio">
												<input type="radio" name="Q3" id="radio_12" value="5" class="validate[required]">
												<label for="radio_12">Strongly Agree</label>
											</span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label mb-10" for="pwd_de">4. Would you recommend this process for the purpose of Hiring </label>
									<div class="radio-list">
										<div class="radio-inline pl-0">
											<span class="radio">
												<input type="radio" name="Q41" id="radio_13" value="1" onclick="open_reason();" class="validate[required]">
												<label for="radio_13">Yes</label>
											</span>
										</div>
										<div class="radio-inline">
											<span class="radio">
												<input type="radio" name="Q41" id="radio_14" value="2" onclick="open_reason();" class="validate[required]">
												<label for="radio_14">No</label>
											</span>
										</div>
									</div>
								</div>
								<div class="form-group" id="reason" style="display:none;">
									<label class="control-label mb-10 text-left">Reason</label>
									<textarea class="form-control" rows="5" name="Q42" id="Q42"></textarea>
								</div>
								<div class="form-group">
									<label class="control-label mb-10" for="pwd_de">5. Can you suggest ways of improving this process and making it more effective</label>
									<textarea class="form-control  validate[required]" name="Q5" id="Q5" rows="5"></textarea>
								</div>
								<div class="form-group mb-4">
									<button type="submit" class="btn btn-success btn-anim">Submit</button>
								</div>	
								<div class="form-group mb-4">
								
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</div>

	