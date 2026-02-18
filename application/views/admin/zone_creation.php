
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default card-view">
				<div class="panel-heading hbuilt">
					<font color="#FF0000">* Indicated are Mandatory <br></font>
				</div>
                <div class="panel-body">
					
					<form name="zoneform" id="zoneform" method="post" action="<?php echo BASE_URL;?>/admin/lms_zone" class="form-horizontal">
						<input type="hidden" name="zone_id" id="zone_id" value="<?php if(isset($zonedetail['zone_id'])){ echo @$zonedetail['zone_id']; }?>">
						<div id="error_div" class="message"><?php 
						$zone_msg=$this->session->flashdata('zone_msg');
						if(!empty($zone_msg)){ echo $this->session->flashdata('zone_msg'); $this->session->unset_userdata('zone_msg'); } ?></font></div>
						
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Zone Name<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5"><input type="text"  id="zone_name" name="zone_name" class="validate[required,funcCall[checknotinteger],minSize[4],maxSize[80],ajax[ajaxZone]]  form-control" value="<?php echo @$zonedetail['zone_name'];?>"></div>
						</div>
						<h6 class="txt-dark capitalize-font">States</h6>
						<hr class="light-grey-hr">
						<div>
							<a class="btn btn-primary btn-sm" name="addrow" id="addrow" onClick="AddMore_expenses()">Add Row</a>
							<a class="btn btn-danger btn-sm" name="delete" id="delete" value="Delete" onClick="DelPrgmRow_expenses()">Delete</a>
						</div>
						<div class="clearfix"></div>
						<div class="table-responsive">
							<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id='fleupload_tab_expense_id'>
								<thead>
									<tr>
										<th style="width:30px;">Select</th>
										<th style="width:175px;">State</th>
									</tr>
								</thead>
								<tbody>
								<?php
								if(isset($zonelocations) && count($zonelocations)>0){
									$var1=array();
									$amount=0;
									foreach($zonelocations as $key2=>$locdetail_role){
										$var1[]=$key2;
										?>
										<tr id="innertable_exp<?php echo $key2;?>">
											<td style="padding-left:20px;">
												<input type="hidden" name="loc_role_id[]" id="loc_role_id[<?php echo $key2;?>]" value="<?php echo $locdetail_role['map_id'];?>">
												<input type="checkbox"  name="select_chk[]" id="select_chk_<?php echo $key2;?>" value="<?php echo $key2;?>" />
											</td>
											<td>
											<select name="role_type[]" id="role_type[<?php echo $key2;?>]" style="width:250px;" class="form-control m-b validate[required]">
												<option value="">Select</option>
												<?php
												foreach($locroles as $locrole){
													if($locdetail_role['state_id']==$locrole['state_id']){
														$select="selected='selected'";
													}
													else{
														$select="";
													}
												?>
												<option <?php echo $select; ?> value="<?php echo $locrole['state_id'];?>"><?php echo $locrole['state_name'];?></option>
												<?php
												}
												?>
											</select>
											</td>
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
												<input type="checkbox"  name="select_chk[]" id="select_chk_0" value="0" />
											</td>
											<td>
											<select name="role_type[]" id="role_type[0]" style="width:250px;" class="form-control m-b validate[required]">
												<option value="">Select</option>
												<?php 
												foreach($locroles as $locrole){
												?>
												<option value="<?php echo $locrole['state_id'];?>"><?php echo $locrole['state_name'];?></option>
												<?php
												}
												?>
											</select>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
							<input type='hidden' id='inner_hidden_id_expenses' value='<?php echo $val_n;?>' name="inner_hidden_id_expenses" />
							
						</div>
						<hr class="light-grey-hr">
						<div class="form-group">
							<div class="col-sm-offset-0">
								<button class="btn btn-primary btn-sm" type="submit" name="update" onClick="return AddMore_expenses_chk_vald();">Save changes</button>
								<button class="btn btn-danger btn-sm" type="button" onClick="create_link('zone_search')">Cancel</button>
								
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
		   //var amount=document.getElementById('employee_number_'+i).value;
		   
			if(exp_type==''){
			   toastr.error("Please select State");
			   return false;
			}
			/* if(amount==''){
			   toastr.error("Please Enter Employee Number");
			   return false;
			} */
			else{
				for( var k=0;k<ins1.length;k++){
					l=ins1[k];
					var item_type2=document.getElementById('role_type['+l+']').value;
					//var item_resource2=document.getElementById('role_employee_number_'+l).value;
					if(k!=j){
						if(k!=j){
						   if(exp_type==item_type2){
								toastr.error("Same state has been added already added");
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
   $("#fleupload_tab_expense_id").append("<tr id='innertable_exp"+sub_iteration+"'><td style='padding-left:20px;'><input type='hidden' name='loc_role_id[]' id='loc_role_id["+sub_iteration+"]' value=''><input type='checkbox' name='select_chk[]' id='select_chk_"+sub_iteration+"' value='"+sub_iteration+"' /></td><td><select name='role_type[]' id='role_type["+sub_iteration+"]'  style='width:250px;' class='form-control m-b validate[required]'><option value=''>Select</option><?php foreach($locroles as $locrole){ ?><option value='<?php echo $locrole['state_id'];?>'><?php echo $locrole['state_name'];?></option><?php } ?></select></td></tr>");
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
					url: BASE_URL+"/admin/delete_zone_state",
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
