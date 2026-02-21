<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">
				<div class="panel-heading hbuilt">
					<font color="#FF0000">* Indicated are Mandatory <br></font>
				</div>
                <div class="panel-body">
					<legend>Test Options.</legend>
					<form method="post" id="testForm" name="testForm"  action="" class="form-horizontal">
						
						<div class="form-group"><label class="col-sm-3 control-label">Test code:</label>
							<div class="col-sm-5"><input type="text" name="test_code" id="test_code" maxlength="50"  class="validate[minSize[3],maxSize[80],ajax[ajaxTestCode]] form-control"></div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Test Name<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5"><input type="text" name="test_name" id="test_name" maxlength="50" class="validate[required,minSize[3],maxSize[80],ajax[ajaxTestName]] form-control"></div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Published status<sup><font color="#FF0000">*</font></sup>:</label>

							<div class="col-sm-5">
								<select  name="publish" id="publish" class="validate[required] form-control m-b" >
									<option value="">Select</option>
									<?php 
									foreach($publish as $publishs ){?>
										<option value="<?php echo $publishs['code']; ?>"><?php echo $publishs['name'] ; ?></option>
									<?php 
									} ?>	
								</select>
							</div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Assessment Type<sup><font color="#FF0000">*</font></sup>:</label>

							<div class="col-sm-5">
								<select name="testtype" class="validate[required] form-control m-b" id="testtype" onchange="getresumedetails()">
									<option value="">Select</option> 
									<?php
									foreach($assesment as $assesments){?>
										<option value="<?php echo $assesments['code']; ?>"><?php echo $assesments['name']; ?></option>
									<?php 
									} ?>		
								</select>
							</div>
						</div>
						<div class="form-group" id='ratingscale' style='display:none;'><label class="col-sm-3 control-label">Rating Scale<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<select name="rating_scale"  id="rating_scale" class="validate[required] form-control m-b" onchange="getresumedetails()">
									<option value="">Select</option> 
									<?php 
									foreach($ratingscale as $ratingscales){?>
										<option value="<?php echo $ratingscales['rating_scale_id']; ?>"><?php echo $ratingscales['scale_name']; ?></option>
									<?php 
									} ?>
								</select>
							</div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Description:</label>
							<div class="col-sm-5">
								<textarea id="desc" class="form-control" maxlength="2000" style='resize:none;' name="desc" ></textarea>
							</div>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="form-group">
							<div class="col-sm-offset-9">
								<button class="btn btn-danger" type="submit" onClick="create_link('test_home')" > Cancel</button>
								<button class="btn btn-success" type="submit" name="TestSuabmit" id="TestSuabmit" onclick="return validation()" >Save changes</button>
							</div>
						</div>
					</form>
				</div>
            </div>
        </div>
    </div>
</div>
