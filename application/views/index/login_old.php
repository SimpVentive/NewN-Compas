<style>.login_bg{background:#324349;position:relative}.login_bg.bg-img{background:url(../public/home/images/bg/it-solutions.jpg) no-repeat center top / cover;height:450px}.row{margin-right:-15px;margin-left:-15px}.landing-page .heading-image{position:absolute;right:60px;top:120px;text-align:right}@media(max-width:420px) .login-container,.lock-container{margin:auto 10px}.login-container{max-width:420px;margin:auto;padding-top:6%}.hpanel .panel-body{background:#fff;border:1px solid #eaeaea;border-radius:2px;padding:20px;position:relative}.hpanel{background-color:none;border:0;box-shadow:none;margin-bottom:25px}.landing-page .heading-image{text-align:left;width:300px}@media(max-width:1200px) .landing-page .heading-image{position:absolute;right:5px;top:120px;text-align:right;width:90%}.landing-page .heading-image{position:absolute;right:60px;top:120px;text-align:right}</style>
<div class="login_bg bg-img padding-lg">
<div class="heading-image animate-panel">
<div class="login-container">
<div class="row">
<div class="col-md-12" style="">
<div class="hpanel">
<div class="panel-body">
<?php if($this->session->userdata('contact_admin')==1){
?>
<h4 style="color:#A01507">Please contact admin.</h4>
<?php } $this->session->unset_userdata('contact_admin');
if($this->session->userdata('wrong_username')==1){
?>
<h4 style="color:#A01507">Wrong Username.</h4>
<?php } $this->session->unset_userdata('wrong_username');
if($this->session->userdata('username_empty')==1){
?>
<h4 style="color:#A01507">Username can't be empty.</h4>
<?php } $this->session->unset_userdata('username_empty');
?>
<form method="post" action="<?php echo base_url()?>index/login_insert" id="long_master">
<div class="form-group">
<label class="control-label" for="username">Username</label>
<input type="text" placeholder="example@gmail.com" title="Please enter you username" value="" id="name" name="username" size="15" maxlength="128" class="form-control validate[required]">
<span class="help-block small">Your unique username to login</span>
</div>
<div class="form-group">
<label class="control-label" for="password">Password</label>
<input type="password" title="Please enter your password" placeholder="******" value="" name="password" id="password" class="form-control validate[required]">
<span class="help-block small">Your strong password</span>
</div>
<!--<div class="checkbox">
<input type="checkbox" class="i-checks" >
Remember login
</div>-->
<input type='submit' id="submit" name="signIn" class="btn btn-success btn-block" value="Login">
</form>
</div>
</div>
</div>
</div>
</div>
</div>
</div>