<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-inverse card-view">
				<div class="panel-heading hbuilt">
					<font color="#FF0000">* Indicated are Mandatory <br></font>
				</div>
                <div class="panel-body">					
					<form id="reportForm" class="form-horizontal" name="reportForm" action="<?php echo BASE_URL ?>/report/reportcreation" method="post">
						<input type="hidden" name="report_id" id="report_id" value="<?php echo isset($_REQUEST['id'])? $_REQUEST['id'] : ''; ?> " />
						<div class="form-group">
							<label class="col-sm-3 control-label">Report Name<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
							<input type="text"  name="report_name" id="report_name" value="<?php echo isset($_REQUEST['id'])? $report->report_name : ''; ?>"  class="validate[required,minSize[3],maxSize[80],ajax[ajaxReportName]] form-control"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Report Type<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<select class="validate[required] form-control m-b" onchange="getreportparams()"  name="reptype" id="reptype" <?php echo isset($_REQUEST['id'])? ' disabled ':''; ?> >
									<option value="">Select</option> 
									<?php 
									foreach($rtype as $rtypes){
									$sel=isset($_REQUEST['id']) ? $report->report_type_id==$rtypes->default_repot_id ? 'selected="selected"' :'' : '';
									?><option <?php echo $sel;  ?> value="<?php echo $rtypes->default_repot_id; ?>"><?php echo $rtypes->default_report_name; ?></option> <?php } ?> </select>
									<?php if(isset($_REQUEST['id'])){?> 
									<input type="hidden" name="reptype" id="reptype" value="<?php echo $report->report_type_id; ?>" />
									<?php  }   ?>
							</div>
						</div>						
						<div class="form-group">
							<label class="col-sm-3 control-label">Comments:</label>
							<div class="col-sm-5">
								<textarea style="resize:none;" name="comments" id="comments" class="form-control" ><?php echo isset($_REQUEST['id'])? $report->comments :'' ;  ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Query function Name<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
							<input type="text"  name="queryfun" id="queryfun"  value="<?php echo isset($_REQUEST['id'])? $report->query_name :'' ;  ?>"  class="form-control"></div>
						</div>
						
						<div class="hr-line-dashed"></div>
						<div class="page-header"><h5>Parameters Details</h5></div>
						<div>
							<a class="btn btn-primary" name="addrow" id="addrow" onclick="addfun()">Add Row</a>
							<a class="btn btn-primary" name="delete" id="delete" value="Delete" onclick="deletefun_new()">Delete</a>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="table-responsive">
							<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1" id="parametersTable">
								<thead>
								<tr>
									<th style="width:20px;"></th>
									 <th>Parameter Name <sup><font size="2" color="#FF0000">*</font></sup></th>
									 <th>System Code<sup><font size="2" color="#FF0000">*</font></sup></th>
									 <th>Visible Option<sup><font size="2" color="#FF0000">*</font></sup></th>
								</tr>
								</thead>
								<tbody>
								<?php  
								$asg=''; $kk=0;
								if(isset($_REQUEST['id'])) {
									foreach ($rdetails as $key=>$rdetail) {  
									$key=$key+1; 
									$asg=empty($asg)? $key : $asg.','.$key;  
									$kk.=+1;
									?>
									<tr>
										<td style="text-align:center">
											<input type="checkbox" name="chkbox[]" id="chkbox_<?php echo $key; ?>" value="<?php echo $key; ?>" />
										</td>
										<td style="text-align:left">
											<input type="text" name="param[]" id="param<?php echo $key ; ?>"  value="<?php echo $rdetail->parameter_name ; ?>" class="validate[required,minSize[3],maxSize[50]] form-control"/>
											<input type="hidden" name="report_paramid[]" id="report_paramid_<?php echo $key ; ?>" value="<?php echo $rdetail->report_param_id; ?>" />
										</td>
										<td>
											<div id="div_syscode">
												<?php  $val='';  ?>
												<select name="syscode[]" class="validate[required] form-control m-b" id="syscode<?php echo $key ; ?>">
													<option value="">select</option>
													<?php 
													foreach($types as $type) {
														$sel2=$rdetail->param_code==$type->parameter_code ? ' selected="selected"': ''; 
														if(empty($val)){ $val=$type->parameter_code.'###'.$type->parameter_name;  } else{ $val=$val.'***'.$type->parameter_code.'###'.$type->	parameter_name;  }
														?>
														<option  <?php echo $sel2 ; ?> value="<?php echo $type->parameter_code; ?>" > <?php echo  $type->parameter_name;  ?></option>
													<?php 
													} ?>
												</select>
												<input id="grouptypeid" type="hidden" value="<?php echo $report->report_type_id; ?>" name="grouptypeid">
												<input id="typevalues" type="hidden" value="<?php echo $val;  ?>" name="typevalues">
											</div>
										</td>
										<td style="text-align:left">
											<select id="visible<?php echo $key ; ?>" name="visible[]" class="validate[required,minSize[3],maxSize[50]] form-control m-b">
												<?php 
												foreach($status as $statuss){
													$sel2=($rdetail->status==$statuss['code']) ? ' selected="selected"': ''; 
													?> 
													<option  <?php echo $sel2; ?> value="<?php echo $statuss['code']; ?>"> <?php echo $statuss['name'];  ?></option>
												<?php } ?>
											</select>
										</td>
									</tr>
									<?php 
									}
									if($kk==0) { 
									echo $kk;
									?>
										<tr>
											<td style="text-align:center">
												<input type="checkbox" name="chkbox[]" id="chkbox_<?php echo $key; ?>" value="<?php echo $key; ?>" />
											</td>
											<td style="text-align:left">
												<input type="text" name="param[]" id="param1"  value="" class="validate[required,minSize[3],maxSize[50]] form-control" />
												<input type="hidden" name="report_paramid[]" id="report_paramid_1" value="" />
											</td>
											<td>
												<div id="div_syscode"> <?php  $val='';  ?>
													<select name="syscode[]" class="validate[required] form-control m-b" id="syscode1">
														<option value="">select</option>
														<?php 
														foreach($types as $type) {
															if(empty($val)){ $val=$type->parameter_code.'###'.$type->parameter_name;  } else{ $val=$val.'***'.$type->parameter_code.'###'.$type->parameter_name;  }
														?>
														<option   value="<?php echo $type->parameter_code; ?>" > <?php echo  $type->parameter_name;  ?></option>
														<?php } ?>
													</select>
													<input id="grouptypeid" type="hidden" class=' col-xs-12 col-sm-6' value="" name="grouptypeid">
													<input id="typevalues" type="hidden" value="<?php echo $val;?>" name="typevalues">
												</div>
											</td>
											<td style="text-align:left">
												<select id="visible1" name="visible[]" class="validate[required,minSize[3],maxSize[50]] form-control m-b">
													<?php foreach($status as $statuss){
														?> <option  <?php // echo $sel2; ?> value="<?php echo $statuss['code']; ?>"> <?php echo $statuss['name'];  ?></option><?php } ?>
												</select>
											</td>
										</tr>  
									<?php  
									}
								} 
								else {  ?>
									<tr>
										<td style="text-align:center">
											<input type="checkbox" name="chkbox[]" id="chkbox_1" value="" />
											<input type="hidden" name="report_paramid[]" id="report_paramid_1" value="" />
										</td>
										<td style="text-align:left">
											<input type="text" name="param[]" id="param1" class="validate[required,minSize[3],maxSize[50]] form-control" />
										</td>
										<td>
											<div id="div_syscode">
											   <select name="syscode[]" class="validate[required] form-control m-b" id="syscode1">
												<option value="">select</option>
												</select>
											</div>
										</td>
										<td style="text-align:left">
											<select id="visible1" name="visible[]" class="validate[required,minSize[3],maxSize[50]] form-control m-b"><?php foreach($status as $statuss){ ?> <option value="<?php echo $statuss['code']; ?>"> <?php echo $statuss['name'];  ?></option><?php } ?></select>
										</td>
									</tr> 
								<?php } ?>
								</table>
								<input type="hidden" id="addgroup" name="addgroup" value="<?php echo isset($_REQUEST['id'])? $asg : 1; ?>" />
							
						</div>
						<div class="form-group">
							<div class="col-sm-offset-9">
								<button class="btn btn-primary" type="button"  onclick="createreport_like('reports')" >Cancel</button>
								<button class="btn btn-primary" type="submit" onclick="return validation()" name="formsubmit" id="formsubmit">Save changes</button>
							</div>
						</div>
					</form>
				</div>
            </div>
        </div>
    </div>
</div>
<script>
    <?php
          $visible='';
    foreach($status as $status1){
        if($visible==''){
            $visible=$status1['code']."*".$status1['name'];
        }
        else{
            $visible=$visible.",".$status1['code']."*".$status1['name'];
        }
    }
   echo "var status='".$visible."';"; 
   
       ?>  //alert(status);
 </script>