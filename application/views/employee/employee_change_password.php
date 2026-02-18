<script>
$(document).ready(function(){
	$('#password').validationEngine();
});
</script>
<section class="main-section">
	<div class="container">
		<div class="row">
			<!-- TEST SECTION :BEGIN -->
			<div class="test-section">
				<form action='<?php echo BASE_URL;?>/employee/changepassword' method='post' name='password' id='password' enctype='multipart/form-data'>
				
				<!-- TEST HEAD SECTION :BEGIN -->
				<div class="test-head-section">
					<div class="d-flex align-items-center justify-content-between">
						<div class="test-head">
							<div class="icon material-icons">assignment_turned_in</div>
							<div class="test-info">
								<div class="test-name">Change Password</div>
								
							</div>
						</div>
						
					</div>
				</div>
				<!-- TEST BODY :BEGIN -->
				<div class="">
					<div class="row">
						<div class="col-12">
							<div class="test-body">
								<div class="form-group"><label class="col-sm-3 control-label">Old Password<sup><font color="#FF0000">*</font></sup>:</label>
									<div class="col-sm-6"><input type="password" name="oldpassword" value="" id="oldpassword" class="validate[required,minSize[4],maxSize[100],ajax[ajaxPassword]] form-control"></div>
								</div>
								<div class="form-group"><label class="col-sm-3 control-label">New Password<sup><font color="#FF0000">*</font></sup>:</label>
									<div class="col-sm-6"><input type="password" name="new_password" value="" id="new_password" class="validate[required,minSize[4],maxSize[100],custom[notEqual]] form-control"></div>
								</div>
								<div class="form-group"><label class="col-sm-3 control-label">Confirm Password<sup><font color="#FF0000">*</font></sup>:</label>
									<div class="col-sm-6"><input type="password" name="conpassword" value="" id="conpassword" class="validate[required,minSize[4],maxSize[15],equals[new_password]] form-control"></div>
								</div>
							</div>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="form-group">
							<div class="col-sm-offset-9">
								
								<button class="btn btn-primary btn-sm" name="submit_r" id="submit_r" type="submit">Save changes</button>
							</div>
						</div>
					</div>
				</div>
				<!-- TEST BODY :END -->

				
				</form>
			</div>
			<!-- TEST SECTION :END -->
		</div>
	</div>
</section>

	