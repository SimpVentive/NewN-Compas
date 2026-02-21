<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-inverse card-view">
                <div class="panel-body">
					<form method="post" class="form-horizontal" action="<?php echo base_url()?>assessor/changepassword">
						<div class="form-group"><label class="col-sm-3 control-label">Old Password<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5"><input type="password" name="oldpassword" value="" id="oldpassword" class="validate[required,minSize[4],maxSize[100],ajax[ajaxPassword]] form-control"></div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">New Password<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5"><input type="password" name="password" value="" id="password" class="validate[required,minSize[4],maxSize[100],ajax[ajaxPassword]] form-control"></div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Confirm Password<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5"><input type="password" name="conpassword" value="" id="conpassword" class="validate[required,minSize[4],maxSize[15],equals[password]] form-control"></div>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="form-group">
							<div class="col-sm-8 col-sm-offset-9">
								<a href="#" class="btn btn-default" >Cancel</a>
								<button class="btn btn-primary" name="submit_r" id="submit_r" type="submit">Save changes</button>
							</div>
						</div>
					</form>
				</div>
            </div>
        </div>
    </div>
</div>