
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">
				<div class="panel-heading hbuilt">
					<font color="#FF0000">* Indicated are Mandatory <br></font>
				</div>
                <div class="panel-body">					
					<form name="locationform" id="locationform" method="post" action="<?php echo BASE_URL;?>/admin/lms_location" class="form-horizontal">
						<input type="hidden" id="parent_date" name="parent_date" value="<?php echo date('d-m-Y',strtotime($_SESSION['org_start_date'])); ?>"  class="floatingvalue" />
						<input type="hidden" id="org_id" name="org_id" value="<?php echo $_SESSION['parent_org_id'];?>" >
						<input type="hidden" name="location_id" id="location_id" value="<?php if(isset($_REQUEST['locid'])){ echo $_REQUEST['locid']; }?>">
						<div id="error_div" class="message"><?php 
						$loc_msg=$this->session->flashdata('loc_msg');
						if(!empty($loc_msg)){ echo $this->session->flashdata('loc_msg'); $this->session->unset_userdata('loc_msg'); } ?></font></div>
						<?php
						if(isset($locdetail)){
							foreach($locdetail as $key=>$locdetails){
								if($key==0){
								?>
								<div class="form-group"><label class="control-label mb-10 col-sm-2">Location Name<sup><font color="#FF0000">*</font></sup>:</label>
									<div class="col-sm-5"><input type="text"  id="loc_name" name="location_name" class="validate[required,funcCall[checknotinteger],minSize[4],maxSize[80],ajax[ajaxLocation]]  form-control" value="<?php echo $locdetails['location_name'];?>"></div>
								</div>
								<div class="form-group"><label class="control-label mb-10 col-sm-2">Business Unit<sup><font color="#FF0000">*</font></sup>:</label>
									<div class="col-sm-5" >
										<select id="bu_id" name="bu_id" class="validate[required] form-control m-b">
											<option value="">Select</option>
											<?php 
											foreach($bus as $bu){
												$stat_sel=(isset($locdetails['bu_id']))?($locdetails['bu_id']==$bu['id'])?"selected='selected'":'':'';
											?>
											<option value="<?php echo $bu['id']; ?>" <?php echo $stat_sel; ?>><?php echo $bu['name']; ?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
								<div class="form-group"><label class="control-label mb-10 col-sm-2">Location Zones<sup><font color="#FF0000">*</font></sup>:</label>
									<div class="col-sm-5">
										<select id="location_zones" name="location_zones" class="validate[required] form-control m-b" onchange="open_zones();">
											<option value="">Select</option>
											<?php foreach($locat_zones as $locat_zone){ if($locat_zone['zone_id']==$locdetails['location_zones']){?>
											<option value="<?php echo $locat_zone['zone_id'];?>" selected='selected'><?php echo $locat_zone['zone_name'];?></option>
											<?php }else{?>
											<option value="<?php echo $locat_zone['zone_id'];?>"><?php echo $locat_zone['zone_name'];?></option>
											<?php }} ?>
										</select>
									</div>
								</div>
								<div class="form-group"><label class="control-label mb-10 col-sm-2">States<sup><font color="#FF0000">*</font></sup>:</label>
									<div class="col-sm-5" id="zonestate">
										<select id="state" name="state" class="validate[required] form-control m-b">
											<option value="">Select</option>
											<?php 
											foreach($states as $state){
												$stat_sel=(isset($locdetails['state_id']))?($locdetails['state_id']==$state['state_id'])?"selected='selected'":'':'';
											?>
											<option value="<?php echo $state['state_id']; ?>" <?php echo $stat_sel; ?>><?php echo $state['state_name']; ?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
								<div class="form-group"><label class="control-label mb-10 col-sm-2">Address 1<sup><font color="#FF0000">*</font></sup>:</label>
									<div class="col-sm-5">
										<input type="text" id="adds1" name="address_1" class="validate[required,maxSize[100]] form-control" value="<?php echo $locdetails['address_1'];?>">
									</div>
								</div>
								<div class="form-group"><label class="control-label mb-10 col-sm-2">Address 2:</label>
									<div class="col-sm-5">
										<input type="text" id="adds2" name="address_2" class="validate[maxSize[100]] form-control" value="<?php echo $locdetails['address_2'];?>" >
									</div>
								</div>
								<div class="form-group"><label class="control-label mb-10 col-sm-2">City:<sup><font color="#FF0000">*</font></sup></label>
									<div class="col-sm-5"><input type="text" id="city" name="city" class="validate[required,maxSize[100]] form-control"  value="<?php echo $locdetails['city'];?>"></div>
								</div>
								<div class="form-group"><label class="control-label mb-10 col-sm-2">Country:</label>
									<div class="col-sm-5">
										<select class="form-control m-b" id="country" name="country">
											<option value="">Select</option>
											<?php foreach($locatns as $locate){ 
											if($locate['code']==$locdetails['value_code']){?>
											<option value="<?php echo $locate['code'];?>" selected='selected'><?php echo $locate['name'];?></option>
											<?php }else{?>
											<option value="<?php echo $locate['code'];?>"><?php echo $locate['name'];?></option>
											<?php }} ?>
										</select>
									</div>
								</div>
								<div class="form-group"><label class="control-label mb-10 col-sm-2">PO BOX:</label>
									<div class="col-sm-5">
										<input type="text" id="po_box" name="po_box" class="validate[custom[integer],minSize[6],maxSize[6]] form-control" value="<?php echo trim($locdetails['po_box']);?>">
									</div>
								</div>
								<div class="form-group"><label class="control-label mb-10 col-sm-2">Status<sup><font color="#FF0000">*</font></sup>:</label>
									<div class="col-sm-5">
										<select id="status" name="status" class="validate[required] form-control m-b" >
											<option value="">Select</option>
											<?php foreach($locstatusss as $locstatus){ if($locstatus['code']==$locdetails['status']){?>
											<option value="<?php echo $locstatus['code'];?>" selected='selected'><?php echo $locstatus['name'];?></option>
											<?php }else{?>
											<option value="<?php echo $locstatus['code'];?>"><?php echo $locstatus['name'];?></option>
											<?php }} ?>
										</select>
									</div>
								</div>
								<?php 
								}
							}
						}
						else{
						?>
							<div class="form-group"><label class="control-label mb-10 col-sm-2">Location Name<sup><font color="#FF0000">*</font></sup>:</label>
								<div class="col-sm-5"><input type="text"  id="loc_name" name="location_name" class="validate[required,funcCall[checknotinteger],minSize[4],maxSize[80],ajax[ajaxLocation]]  form-control" value=""></div>
							</div>
							<div class="form-group"><label class="control-label mb-10 col-sm-2">Business Unit<sup><font color="#FF0000">*</font></sup>:</label>
									<div class="col-sm-5" >
										<select id="bu_id" name="bu_id" class="validate[required] form-control m-b">
											<option value="">Select</option>
											<?php 
											foreach($bus as $bu){
											?>
											<option value="<?php echo $bu['id']; ?>" ><?php echo $bu['name']; ?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
							<div class="form-group"><label class="control-label mb-10 col-sm-2">Location Zones<sup><font color="#FF0000">*</font></sup>:</label>

								<div class="col-sm-5">
									<select id="location_zones" name="location_zones" class="validate[required] form-control m-b" onchange="open_zones();">
										<option value="">Select</option>
										<?php foreach($locat_zones as $locat_zone){ 
										?>
										<option value="<?php echo $locat_zone['zone_id'];?>"><?php echo $locat_zone['zone_name'];?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group"><label class="control-label mb-10 col-sm-2">States<sup><font color="#FF0000">*</font></sup>:</label>
								<div class="col-sm-5" id="zonestate">
									<select id="state" name="state" class="validate[required] form-control m-b">
										<option value="">Select</option>
										<?php 
										foreach($states as $state){
										?>
										<option value="<?php echo $state['state_id']; ?>"><?php echo $state['state_name']; ?></option>
										<?php
										}
										?>
									</select>
								</div>
							</div>
							<div class="form-group"><label class="control-label mb-10 col-sm-2">Address 1<sup><font color="#FF0000">*</font></sup>:</label>
								<div class="col-sm-5">
									<input type="text" id="adds1" name="address_1" class="validate[required,maxSize[100]] form-control" value="">
								</div>
							</div>
							<div class="form-group"><label class="control-label mb-10 col-sm-2">Address 2:</label>
								<div class="col-sm-5">
									<input type="text" id="adds2" name="address_2" class="validate[maxSize[100]] form-control" value="" >
								</div>
							</div>
							<div class="form-group"><label class="control-label mb-10 col-sm-2">City:<sup><font color="#FF0000">*</font></sup></label>
								<div class="col-sm-5"><input type="text" id="city" name="city" class="validate[required,maxSize[100]] form-control"  value=""></div>
							</div>
							<div class="form-group"><label class="control-label mb-10 col-sm-2">Country:</label>
								<div class="col-sm-5">
									<select class="form-control m-b" id="country" name="country">
										<option value="">Select</option>
										<?php foreach($locatns as $locate){
											?>
										<option value="<?php echo $locate['code'];?>"><?php echo $locate['name'];?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group"><label class="control-label mb-10 col-sm-2">PO BOX:</label>
								<div class="col-sm-5">
									<input type="text" id="po_box" name="po_box" class="validate[custom[integer],minSize[6],maxSize[6]] form-control" value="">
								</div>
							</div>
							<div class="form-group"><label class="control-label mb-10 col-sm-2">Status<sup><font color="#FF0000">*</font></sup>:</label>
								<div class="col-sm-5">
									<select id="status" name="status" class="validate[required] form-control m-b" >
										<option value="">Select</option>
										<?php foreach($locstatusss as $locstatus){ 
											?>
										<option value="<?php echo $locstatus['code'];?>"><?php echo $locstatus['name'];?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						<?php
						}?>
						<!--
						<h6 class="txt-dark capitalize-font">Employees</h6>
						<hr class="light-grey-hr">
						<div>
							<a class="btn btn-primary btn-sm"  name="addrow" id="addrow" onClick="AddMore_expenses()">Add </a>
							<a class="btn btn-danger btn-sm"  name="delete" id="delete" value="Delete" onClick="DelPrgmRow_expenses()">Delete</a>
						</div>
						<div class="table-responsive">
							<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id='fleupload_tab_expense_id'>
								<thead>
									<tr>
										<th style="width:30px;">Select</th>
										<th style="width:175px;">Role</th>
										<th style="width:175px;">Employee Number</th>
										<th style="width:175px;"></th>
									</tr>
								</thead>
								<tbody>
								<?php
								if(isset($locdetail)){
									$var1=array();
									$amount=0;
									foreach($locdetail as $key2=>$locdetail_role){
										$var1[]=$key2;
										?>
										<tr id="innertable_exp<?php echo $key2;?>">
											<td style="padding-left:20px;">
												<input type="hidden" name="loc_role_id[]" id="loc_role_id[<?php echo $key2;?>]" value="<?php echo $locdetail_role['loc_role_id'];?>">
												<input type="checkbox"  name="select_chk[]" id="select_chk_<?php echo $key2;?>" value="<?php echo $key2;?>" />
											</td>
											<td>
											<select name="role_type[]" id="role_type[<?php echo $key2;?>]" style="width:250px;" class="form-control m-b">
												<option value="">Select</option>
												<?php
												foreach($locroles as $locrole){
													if($locdetail_role['role_value_code']==$locrole['code']){
														$select="selected='selected'";
													}
													else{
														$select="";
													}
												?>
												<option <?php echo $select; ?> value="<?php echo $locrole['code'];?>"><?php echo $locrole['name'];?></option>
												<?php
												}
												?>
											</select>
											
											<td>
											<input type='hidden' name='role_employee_number' id='role_employee_number_<?php echo $key2;?>' value='<?php echo $locdetail_role['role_employee_id']; ?>'>
											
											<input type="text" style="width:175px;" name="employee_number[]" id="employee_number_<?php echo $key2;?>" class="validate[minSize[2],maxSize[10],custom[alphanumericSp],ajax[ajaxEmpNumberAdmin]] form-control m-b" value="<?php echo $locdetail_role['role_employee_id']; ?>">
											</td>
											<td></td>
										</tr>
										<?php
											$val_n=@implode(',',$var1);
										}
									}
									else{
										
										$val_n=0;
										?>
										<tr id="innertable_exp0">
											<td style="padding-left:20px;">
												<input type="hidden" name="loc_role_id[]" id="loc_role_id[0]" value="">
												<input type="checkbox"  name="select_chk[]" id="select_chk_0" value="" />
											</td>
											<td>
											<select name="role_type[]" id="role_type[0]" style="width:250px;" class="form-control m-b">
												<option value="">Select</option>
												<?php 
												foreach($locroles as $locrole){
												?>
												<option value="<?php echo $locrole['code'];?>"><?php echo $locrole['name'];?></option>
												<?php
												}
												?>
											</select>
											</td>
											<td>
											<input type='hidden' name='role_employee_number' id='role_employee_number_0' value=''>
											<input type="text" style="width:175px;" name="employee_number[]" id="employee_number_0" class="validate[minSize[2],maxSize[10],custom[alphanumericSp],ajax[ajaxEmpNumberAdmin]] form-control m-b">
											</td>
											<td></td>
										</tr>
										
										<?php
									}
									
								?>
								</tbody>
							</table>
							<input type='hidden' id='inner_hidden_id_expenses' value='<?php echo $val_n;?>' name="inner_hidden_id_expenses" />
							
						</div>
						-->
						<div class="hr-line-dashed"></div>
						<div class="form-group">
							<div class="col-sm-offset-0">
								
								<button class="btn btn-primary btn-sm" type="submit" name="update" onClick="return AddMore_expenses_chk_vald()">Save changes</button>
								<button class="btn btn-danger btn-sm" type="button" onClick="create_link('location_search')">Cancel</button>
							</div>
						</div>
					</form>
				</div>
            </div>
        </div>
    </div>
</div>
<script>
function AddMore_expenses(){
	var tbl = document.getElementById("fleupload_tab_expense_id");
	var lastRow = tbl.rows.length;
	var lastrow1= lastRow+1;
	var hiddtab="inner_hidden_id_expenses";
	var ins=document.getElementById(hiddtab).value;
	if(ins!=''){
	   var ins1=ins.split(",");
	   var temp=0;
	   for( var j=0;j<ins1.length;j++){
		   if(ins1[j]>temp){
			   temp=ins1[j];
		   }
	   }
	   //var maxa=Math.max(ins1);
	   sub_iteration=parseInt(temp)+1;
	   for( var j=0;j<ins1.length;j++){
		   var i=ins1[j];
		   var exp_type=document.getElementById('role_type['+i+']').value;
		   var amount=document.getElementById('employee_number_'+i).value;
		   
			if(exp_type==''){
			   toastr.error("Please select Role type");
			   return false;
			}
			if(amount==''){
			   toastr.error("Please Enter Employee Number");
			   return false;
			}
			else{
				for( var k=0;k<ins1.length;k++){
					l=ins1[k];
					var item_type2=document.getElementById('employee_number_'+l).value;
					var item_resource2=document.getElementById('role_employee_number_'+l).value;
					if(k!=j){
						if(k!=j){
						   if(amount==item_type2 || amount==item_resource2){
								toastr.error("Same employee has been added to the role");
								return false;
						   }
                       }
					}
				}
			}
		}
	}
	else{
	   sub_iteration=1;
	   ins1=1;
	   var ins1=Array(1);
	}
   $("#fleupload_tab_expense_id").append("<tr id='innertable_exp"+sub_iteration+"'><td style='padding-left:20px;'><input type='hidden' name='loc_role_id[]' id='loc_role_id["+sub_iteration+"]' value=''><input type='checkbox' name='select_chk[]' id='select_chk_"+sub_iteration+"' value='"+sub_iteration+"' /></td><td><select name='role_type[]' id='role_type["+sub_iteration+"]'  style='width:250px;' class='form-control m-b'><option value=''>Select</option><?php foreach($locroles as $locrole){ ?><option value='<?php echo $locrole['code'];?>'><?php echo $locrole['name'];?></option><?php } ?></select></td><td><input type='hidden' name='role_employee_number' id='role_employee_number_"+sub_iteration+"' value=''><input class='validate[required,minSize[2],maxSize[10],custom[alphanumericSp],ajax[ajaxEmpNumberAdmin]] form-control' type='text' style='width:175px;' name='employee_number[]' id='employee_number_"+sub_iteration+"' /></td><td></td></tr>");
   if(document.getElementById(hiddtab).value!=''){
	   var ins=document.getElementById(hiddtab).value;
	   document.getElementById(hiddtab).value=ins+","+sub_iteration;
   }
   else{
	   document.getElementById(hiddtab).value=sub_iteration;
   }
}

function DelPrgmRow_expenses(){
   var ins=document.getElementById('inner_hidden_id_expenses').value;
   var arr1=ins.split(",");
   var flag=0;
   var tbl = document.getElementById('fleupload_tab_expense_id');
   var lastRow = tbl.rows.length;
   for(var i=(arr1.length-1); i>=0; i--){
	   var bb=arr1[i];
	   var a="select_chk_"+bb+"";
	   if(document.getElementById(a).checked){
		   var b=document.getElementById(a).value;
		   var c="innertable_exp"+b+"";
			var attachmentid=document.getElementById("loc_role_id["+b+"]").value;
			if(attachmentid!=' '){
				$.ajax({
					url: BASE_URL+"/admin/delete_location_roles",
					global: false,
					type: "POST",
					data: ({val : attachmentid}),
					dataType: "html",
					async:false,
					success: function(msg){
					}
				}).responseText;
			}
		   for(var j=(arr1.length-1); j>=0; j--) {
			   if(arr1[j]==b) {
				   arr1.splice(j, 1);
				   break;
			   }  
		   }
		   flag++;
		   $("#"+c).remove();
	   }
   }
   if(flag==0){
	   toastr.error("Please select the Value to Delete");
	   return false;
   }
   document.getElementById('inner_hidden_id_expenses').value=arr1;
}

function countemp(  ){
	var table = document.getElementById('fleupload_tab_expense_id');
	var rowCount = table.rows.length;
	// toastr.error(rowCount);
	
	var hiddtab="inner_hidden_id_expenses";
    var ins=document.getElementById(hiddtab).value;
	
	if(ins!=''){
		var ins1=ins.split(",");
		var temp=0;
		for( var j=0;j<ins1.length;j++){
		   if(ins1[j]>temp){
			   temp=ins1[j];
		   }
		}
		sub_iteration=parseInt(temp)+1;
		var amount=0;
		for( var j=0;j<ins1.length;j++){
			var i=ins1[j];
			var dd="employee_number["+j+"]";
			var tem=document.getElementById(dd).value;
			amount= +tem+ +amount;
			
		}
		document.getElementById("cost_data").value=amount;	
	}
}
</script>
