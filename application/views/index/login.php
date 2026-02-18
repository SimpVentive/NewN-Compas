<section class="login-section">
	<div class="left-section">
		<div class="logo-text"><a href="<?php echo base_url()?>"><img src="<?php echo BASE_URL; ?>/public/images/heidelberg.png" style="margin:0.15cm 0.2cm;float:right;" width="300" height="50"></a></div>
		<div class="center-section d-flex align-items-center justify-content-center">
			<form method="post" id="long_master" action="<?php echo base_url()?>index/login_insert" class="form-section">
				
				<div class="title">Sign in to Account</div>
				<?php if($this->session->userdata('contact_admin')==1){
				?>
				<h6 style="color:#f33923">Please contact admin.</h6>
				<?php } $this->session->unset_userdata('contact_admin');
				if($this->session->userdata('wrong_username')==1){
				?>
				<h6 style="color:#f33923">Wrong Username.</h6>
				<?php } $this->session->unset_userdata('wrong_username');
				if($this->session->userdata('username_empty')==1){
				?>
				<h6 style="color:#f33923">Username can't be empty.</h6>
				<?php } $this->session->unset_userdata('username_empty');
				?>
				<div class="form-group">
					<label class="label">Username</label>
					<input type="text" class="form-control" id="name" name="username" placeholder="Username">
					<span class="form-note">Your unique user name to login</span>
				</div>
				<div class="form-group">
					<label class="label">Password</label>
					<input type="password" name="password" id="password" class="form-control" placeholder="Password">
					<span class="form-note">Your strong password</span>
				</div>
				<div class="d-flex align-items-center justify-content-between">
					<div class="checkbox-group">
						<input id="rememberme" type="checkbox" class="checkbox-control">
						<label for="rememberme" class="label">Remember Me</label>
					</div>

					<div class="form-group mb-none">
						<button type="submit" id="submit" name="signIn" class="btn btn-primary">Login</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="right-section">
		<div class="center-section d-flex align-items-center justify-content-center">
			<div class="">
				<h2 class="login-title">N-Compas </h2>
				<p class="login-info-new">(All Encompassing Competency Management System) </p>
				<p class="login-info">Welcome to N-Compas, your complete IT solutions for managing effectively all the aspects of competency mapping, assessment and development process. </p>
			</div>
		</div>
	</div>
</section>