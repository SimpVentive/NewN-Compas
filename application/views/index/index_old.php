
<?php

if($this->session->userdata('contact_admin')==1){
?>
<a class="bordered">Please contact admin.</a>
<?php }
$this->session->unset_userdata('contact_admin');
if($this->session->userdata('wrong_username')==1){
?>
<h4 class="bordered"><a>Wrong Username.</a></h4>
<?php }
$this->session->unset_userdata('wrong_username');
if($this->session->userdata('username_empty')==1){
?>
<a class="bordered">Username  can't be empty.</a>
<?php }
$this->session->unset_userdata('username_empty');
?>
<form action="<?php echo base_url()?>index/login_insert"  method="post">
	<div class="form-group">
		<label class="control-label" for="username">Username</label>
		<input type="text" placeholder="example@gmail.com" title="Please enter you username"  value="" id="name" name="username"  size="15" maxlength="128" class="form-control">
		<span class="help-block small">Your unique username to login</span>
	</div>
	<div class="form-group">
		<label class="control-label" for="password">Password</label>
		<input type="password" title="Please enter your password" placeholder="******"  value="" name="password" id="password" class="form-control">
		<span class="help-block small">Your strong password</span>
	</div>
	<div class="checkbox">
		<input type="checkbox" class="i-checks" checked>
			Remember login
	</div>
	<input type='submit' id="submit" name="signIn" class="btn btn-success btn-block" value="Login">
</form>
							