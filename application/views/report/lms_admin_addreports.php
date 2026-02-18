<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-inverse card-view">
				<div class="panel-heading hbuilt">
					<font color="#FF0000">* Indicated are Mandatory <br></font>
				</div>
                <div class="panel-body">
					 <?php $id=isset($_REQUEST['id'])? $_REQUEST['id'] : "";   ?>
					<form id="reportForm" name="reportForm" class="form-horizontal" action="<?php echo BASE_URL ?>/report/addreports_insertfun" method="post">
					<input type="hidden" name="report_group_id" id="report_group_id" value="<?php echo $id; ?>" />
					
						<div class="form-group"><label class="col-sm-3 control-label">Report Group Name<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
							<input type="text"  name="report_group_name" id="report_group_name" value="<?php echo isset($groupsdetails->report_group_name)?$groupsdetails->report_group_name : ''; ?>" class="validate[required,minSize[3],maxSize[50],ajax[ajaxReportGroupName]] form-control"></div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Parent Organization Name<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<?php $dd=isset($_REQUEST['id'])? ' disabled': ''; ?> 
								<select  class="validate[required] form-control m-b" <?php echo $dd; ?> <?php isset($_REQUEST['id'])?'':''; ?> name="porg"  id="porg"> 
									<option value="">Select</option>
									<?php foreach($parentorgs as $parentorg){
										$sel=isset($groupsdetails->parent_org_id)?($groupsdetails->parent_org_id==$parentorg->orgid)?'selected="selected"':'':'';
										?>
										<option <?php echo $sel; ?> value="<?php echo $parentorg->orgid; ?>"><?php echo $parentorg->orgname; ?></option>
									<?php 
									} ?>
								</select>
								<?php if(isset($_REQUEST['id'])){ ?>
									<input type='hidden' name='porg' id='org' value='<?php echo $groupsdetails->parent_org_id; ?>' />
								<?php } ?>
							</div>
						</div>
						
						<div class="form-group"><label class="col-sm-3 control-label">Comments:</label>
							<div class="col-sm-5">
								<textarea style="resize:none;" name="comments" id="comments" class="form-control"><?php echo isset($groupsdetails->comments)?$groupsdetails->comments:'';  ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-10">
								<button class="btn btn-success" type="button" name="reportbutton"  id="reportbutton" value="Report Creation" onClick="createreport_like('reports')">Report Creation</button>
							</div>
						</div>
						
						<div class="hr-line-dashed"></div>
						<div class="page-header"><h5>Reports Details</h5></div>
						<div>
							<a class="btn btn-success" name="addrow" id="addrow" onclick="addfun()">Add Row</a>
							<a class="btn btn-danger" name="delete" id="delete" value="Delete" onclick="deletefun()">Delete</a>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="table-responsive">
							<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1" id="reportTable" >
								<thead>
								<tr>
									<td>Select</td>
									<td>Report Name</td>
									<td>Visible Option</td>
								</tr>
								</thead>
								<tbody>
								<?php 
								if(isset($groupreports)){
									foreach($groupreports as $key21=>$gpsr){ 
										$key1=$key21+1; //$keyr='';
										if($key21==0) { $key2=$key21+1 ;} 
										else {   $ds=$key21+1; 
										$key2=$key2.','.$ds;  
										}
										?>
										<tr>
											<td style="text-align:center"><input type="checkbox" name="chkbox[]" disabled="disabled" id="chkbox_<?php echo $key1; ?>" value="" /></td>
											<td style="text-align:left">
												<select  disabled="disabled" id="reportname<?php echo $key1;  ?>" class="validate[required] form-control m-b" name="reportname[]"><option value="">select</option>
												<?php 
												foreach($groups as $group){
													$sel=$gpsr->report_id==$group->id? 'selected="selected"':'';
													?>
													<option <?php echo $sel; ?> value="<?php echo $group->id; ?>"><?php echo $group->name; ?></option>
												<?php } ?>
												</select>
												<input type="hidden" name="reportname[]" id="reportname<?php echo $key1;  ?>" value="<?php echo $gpsr->report_id;  ?>" />
											</td>
											<td style="text-align:left">
												<select  id="visible<?php echo $key1; ?>" class="validate[required] form-control m-b" name="visible[]">
												<?php foreach($status as $keyr=>$statuss){
													$sel=$gpsr->visible==$statuss['code']? 'selected="selected"':'';
												?>
												<option  <?php echo $sel;   ?> value="<?php echo $statuss['code']; ?>"> <?php echo $statuss['name'];  ?></option><?php } ?>
												</select>
											</td>
										</tr>
									<?php  
									} 
								}
								else {?>
									<tr>
										<td style="text-align:center"><input type="checkbox" name="chkbox[]" id="chkbox_1" value="" /></td>
										<td style="text-align:left">
											<select id="reportname1" class="validate[required] form-control m-b" name="reportname[]">
												<option value="">select</option>
												<?php foreach($groups as $keyr=>$group){ ?>
												<option value="<?php echo $group->id; ?>"><?php echo $group->name; ?></option>
												<?php } ?>
											</select>
										</td>
										<td style="text-align:left">
											<select id="visible1" class="validate[required] form-control m-b" name="visible[]"><?php foreach($status as $statuss){ $sel=$statuss['code']=='VIS' ?'selected="selected"' : '';  ?>
												<option  <?php echo $sel; ?> value="<?php echo $statuss['code']; ?>"> <?php echo $statuss['name'];  ?></option><?php } ?>
											</select>
										</td>
									</tr>
								<?php } ?>
								</tbody>
								<?php $kval=isset($_REQUEST['id'])? $key2:1;  $kes=count($groups);?>   
								<input type="hidden" name="countreports" id="countreports" value="<?php echo $kes;  ?>" />  
							</table>
							<input type="hidden" id="addgroup" name="addgroup" value="<?php echo $kval; ?>" />  
						</div>
						<div class="hr-line-dashed"></div>
						<div class="form-group">
							<div class="col-sm-offset-9">
								<button class="btn btn-danger" type="button" onclick="back()">Cancel</button>
								<button class="btn btn-success" type="submit" name="formsubmit" id="formsubmit" onclick="return validation()">Save changes</button>
							</div>
						</div>
					</form>
				</div>
            </div>
        </div>
    </div>
</div>
<script>
function addfun(){  
     var cou=document.getElementById('countreports').value;
     if(cou==0){ alert('You have Only one Report.Please Create Report.') ; return false; }
      var table = document.getElementById('reportTable');
      var rowCount = table.rows.length;
       var dd="addgroup";
       var s=document.getElementById(dd).value;  
       
       	 if(s!=''){  
	         s=s.split(",");
	  // alert(s.length);
       for(var i=0;i<s.length;i++){var b=s[i];
           //if(s.length==8){ alert("The maximum number of reports are 8 Only."); return false;}
                var param=document.getElementById('reportname'+b).value;
                var visible=document.getElementById('visible'+b).value;
                var regex= /^[0-9]+$/;  
                 if(param==''){
                    alert("Please select Report Name .");
                    return false;
                  }
                
                  if(visible==''){
                      alert("Please select Visible option.");
                      return false;
                  }
                   
           
                for(var j=0;j<s.length;j++){var bb=s[j];
                    if(j!=i){
                            var param1=document.getElementById('reportname'+bb).value;
                            var visible1=document.getElementById('visible'+bb).value;
                            
                        if(param==param1){
                            alert("Report already you have selected.");
                             document.getElementById('reportname'+bb).value='';
                             document.getElementById('visible'+bb).focus();
                            return false;

                           }                        
                    }
            }
        }
      }
         var temp2=0;	
	var parametercount=document.getElementById(dd).value;
	parametercount=parametercount.split(",");
	var asdf=parametercount.length-1;
	for(var k=0; k<parametercount.length; k++){	
		if(parseInt(temp2)<parseInt(parametercount[k])){
			temp2=parametercount[k];
		}
	}
	var p=parseInt(temp2)+1;
	if(document.getElementById(dd).value==""){
		parametercount=1;
		p=1;
	}
	else{parametercount.push(p);}
	 document.getElementById(dd).value=parametercount;
	// var rowcou=parseInt(iteration)+1;
	var row = table.insertRow(rowCount);
                
           var cell1 = row.insertCell(0);      
          cell1.innerHTML="<div style='text-align:center;'><input  type='checkbox' name='chkbox[]' id='chkbox_"+p+"'  value='' /></div>";     
                
       var cell2 = row.insertCell(1);
      cell2.innerHTML="<div style='text-align:left;'><select class='validate[required] form-control m-b' id='reportname"+p+"' name='reportname[]'><option value=''>select</option><?php  foreach($groups as $group){?><option value='<?php echo $group->id;  ?>'><?php echo $group->name;  ?></option> <?php } ?></select></div>";  
       
       var cell3=row.insertCell(2);
        cell3.innerHTML="<div style='text-align:left;'><select class='validate[required] form-control m-b' id='visible"+p+"' name='visible[]'><?php foreach($status as $statuss){ ?> <option value='<?php echo $statuss['code']; ?>'> <?php echo $statuss['name'];  ?></option><?php } ?></select></div>";      
    
    }
        
    </script>