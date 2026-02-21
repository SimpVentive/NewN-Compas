<style>
.disabled{
	pointer-events:none;
}
</style>
<script>
<?php $org_strt_date=date('d-m-Y',strtotime($_SESSION['org_start_date']));
	echo "var org_start_date='".$org_strt_date."';";
    // To pass the Requested Status to empcreation.js File
    foreach($_REQUEST as $key=>$val){
        if($key=="status"){
            echo "var ".$key."='".$val."';";
        }
    }
    // To pass the Organization Details to empcreation.js File  
    $orgdata='';
    foreach($emp_orgdetails as $org1){
        if($orgdata==''){
            $orgdata=$org1['id']."*".$org1['name'];
        }
        else{
            $orgdata=$orgdata.",".$org1['id']."*".$org1['name'];
        }
    }
    echo "var org_val='".$orgdata."';"; 
	
	// To pass the Business Unit Details to empcreation.js File  
    $businessorgdata='';
    foreach($business_units as $business_units1){
        if($businessorgdata==''){
            $businessorgdata=$business_units1['id']."*".$business_units1['name'];
        }
        else{
            $businessorgdata=$businessorgdata.",".$business_units1['id']."*".$business_units1['name'];
        }
    }
    echo "var bus_org_val='".$businessorgdata."';"; 
	
	//To pass the Pos-ition Details to empcreation.js File
    $posdata='';
	foreach($positions as $emp_position){
	    if($posdata==''){
		    $posdata=$emp_position['position_id']."*".$emp_position['position_name'];
		}
		else{
		    $posdata=$posdata.",".$emp_position['position_id']."*".$emp_position['position_name'];
		}
	}
	echo "var pos_val='".$posdata."';";
    
    // To pass the Grades Details to empcreation.js File
    $gradedata='';
    foreach($emp_grade as $emp_grad){
        if($gradedata==''){
            $gradedata=$emp_grad->grade_id."*".$emp_grad->grade_name;
        }
        else{
            $gradedata=$gradedata.",".$emp_grad->grade_id."*".$emp_grad->grade_name;
        }
    }
    echo "var grade_val='".$gradedata."';";
	
	// To pass the SubGrades Details to empcreation.js File
    $subgradedata='';
    foreach($sub_grade as $sub_grade1){
        if($subgradedata==''){
            $subgradedata=$sub_grade1['sub_grade_id']."*".$sub_grade1['sub_name'];
        }
        else{
            $subgradedata=$subgradedata.",".$sub_grade1['sub_grade_id']."*".$sub_grade1['sub_name'];
        }
    }
    echo "var sub_grade_val='".$subgradedata."';";
    
    // To pass the Locations Details to empcreation.js File
    $locationdata='';
    foreach($emp_locs as $emp_loc){
        if($locationdata==''){
            $locationdata=$emp_loc->location_id."*".$emp_loc->location_name;
        }
        else{
            $locationdata=$locationdata.",".$emp_loc->location_id."*".$emp_loc->location_name;
        }
    }
    echo "var loc_val='".$locationdata."';";
    
    // To pass the Supervisors Details to empcreation.js File
    $superdata='';
    if(count($supervisors_data)>0){
    foreach($supervisors_data as $supervisor){
        if($superdata==''){
            $superdata=$supervisor['employee_id']."*".$supervisor['employee_number']."&nbsp;&nbsp;".$supervisor['full_name'];
        }
        else{
            $superdata=$superdata.",".$supervisor['employee_id']."*".$supervisor['employee_number']."&nbsp;&nbsp;".$supervisor['full_name'];
        }
    }
    echo "var super_val='".$superdata."';";
    }
    else{
        echo "var super_val='';";
    }
    
    // To pass the Status to empcreation.js File
    $stat='';
    foreach($orgstat as $orgstatus){
        if($stat==''){
            $stat=$orgstatus['code']."*".$orgstatus['name'];
        }
        else{
            $stat=$stat.",".$orgstatus['code']."*".$orgstatus['name'];
        }
    }
    echo "var org_status='".$stat."';";
	
//Roles to .js file
$extyp='';
foreach($roless as $key=>$roles1){
    if($extyp==''){
        $extyp=$roles1['role_id']."*".$roles1['role_name'];
    }
    else{
        $extyp=$extyp.",".$roles1['role_id']."*".$roles1['role_name'];
    }
}
echo "var exptype='".$extyp."';";
   
if(isset($last_wrk_details)){
	foreach($last_wrk_details as $key=>$last_wrk_det){
?>
/* $("#supervisor_<?php echo $key;?>").ajaxChosen({
	   dataType: 'json',
	   type: 'POST',
	   url:BASE_URL+'/admin/autoemployee'
},{
	   loadingImg: 'loading.gif'
}); */
<?php } } ?>

</script>
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default card-view">
				<div class="panel-heading">
					Create/Update Employee
				</div>
                <div class="panel-body">
					<div id="error_div" class="message"><font color="#FF0000">* Indicated are Mandatory <br />
					<?php 
					$message=$this->session->flashdata('message');
					if(!empty($message)){ echo $this->session->flashdata('message'); $this->session->unset_userdata('message'); } ?></font></div>
                    <form id="org_master" action="<?php echo BASE_URL;?>/admin/emp_details" method="post" enctype="multipart/form-data">
						<div class="col-lg-2">
							<div class="panel-body">
								<?php $path=(!empty($last_details->photo))?BASE_URL.'/public/uploads/profile_pic/'.trim($last_details->employee_id).'/'.trim($last_details->photo):BASE_URL.'/public/images/male_user.jpg'?>
								<img alt="logo" class="img-circle m-b" src="<?php echo $path;?>"  width="110px;" height="100px;">
								<br style="clear:both;">
								<div id="change_pic" style="padding:6px 4px 0px;">
									<input type="file" name="imgInp" id="imgInp" class="validate[custom[picture]]" style="width:75px;" src="<?php echo $path;?>">
								</div>
							</div>
						</div>
						<div class="col-lg-10">
							<div class="form-group col-lg-2">
								<label class="control-label mb-10 text-left">Title<sup><font color="#FF0000">*</font></sup>:</label>
								<select name="title" id="title" onchange="change_gendar()" class="validate[required]  form-control m-b">
									<option value="">Select</option>
									<?php 		
									foreach($emptitle as $emptitles){$titl=(isset($last_details->title))?strtoupper($last_details->title):'';
										$tit_sel=(isset($last_details->title))?($titl==$emptitles['code'])?"selected='selected'":'':''?>
										<option value="<?php echo $emptitles['code'];?>" <?php echo $tit_sel;?>><?php echo $emptitles['name'];?></option>
									<?php 	
									}?>
								</select>
							</div>
							<div class="form-group col-lg-2">
								<label class="control-label mb-10 text-left">Gender<sup><font color="#FF0000">*</font></sup>:</label>
								<select name="Gendar" id="Gendar" class="validate[required] form-control m-b" onchange="change_title()">
									<option value="" >Select</option>
									<?php 
									foreach($empgendar as $empgendars){
										$gen_sel=(isset($last_details->gender))?($last_details->gender==$empgendars['code'])?"selected='selected'":'':''?>
										<option value="<?php echo $empgendars['code'];?>" <?php echo $gen_sel;?>><?php echo $empgendars['name'];?></option>
									<?php 
									} ?>
								</select>
							</div>
							<div class="form-group col-lg-3">
								<label class="control-label mb-10 text-left">Employee Category:</label>
								<select class="form-control m-b" name="emp_cat" id="emp_cat" onchange="change_title()">
									<option value="" >Select</option>
									<?php 		
									foreach($empcat as $empcats){
										$gen_sel=(isset($last_details->emp_cat))?($last_details->emp_cat==$empcats['emp_cat_id'])?"selected='selected'":'':''?>
										<option value="<?php echo $empcats['emp_cat_id'];?>" <?php echo $gen_sel;?>><?php echo $empcats['emp_cat_name'];?></option>
									<?php 	
									}?>
								</select>
							</div>
							<div class="form-group col-lg-2">
								<label class="control-label mb-10 text-left">Employee Type:</label>
								<select class="form-control m-b"  name="emp_type" id="emp_type">
									<option value="">Select</option>
									<?php 	
									foreach($emptyp as $emptypes){
										$typ_sel=(isset($last_details->emp_type))?($last_details->emp_type==$emptypes['emp_type_id'])?"selected='selected'":'':''?>
										<option value="<?php echo $emptypes['emp_type_id'];?>" <?php echo $typ_sel;?>><?php echo $emptypes['emp_type_name'];?></option>
									<?php 	
									}?>	
								</select>
							</div>
							
							<div class="form-group col-lg-3">
								<label class="control-label mb-10 text-left">Employee Number<sup><font color="#FF0000">*</font></sup>:</label>
								<input type="text" class="validate[required,minSize[2],maxSize[80],custom[alphanumericSp],ajax[ajaxEmpNumber]] form-control"name="emp_number" id="emp_number" value="<?php echo (isset($last_details->employee_number))?$last_details->employee_number:''?>" maxlength='10'  data-prompt-position="topRight:-100" >
							</div>
							
							<div class="form-group col-lg-3">
								<label class="control-label mb-10 text-left">First Name<sup><font color="#FF0000">*</font></sup>:</label>
								<input type="hidden" name="employee_id" id="employee_id" value="<?php echo (isset($last_details->employee_id))?$last_details->employee_id:''?>">
								<input type="text" class="validate[required,minSize[2],maxSize[80], funcCall[checknotinteger]] form-control" name="first_name" id="first_name" value="<?php echo (isset($last_details->first_name))?$last_details->first_name:''?>">
							</div>
							<div class="form-group col-lg-3">
								<label class="control-label mb-10 text-left">Middle Name</label>
								<input type="" class="validate[funcCall[checknotinteger]] form-control" name="mid_name" id="mid_name" value="<?php echo (isset($last_details->middle_name))?$last_details->middle_name:''?>">
							</div>
							<div class="form-group col-lg-3">
								<label class="control-label mb-10 text-left">Last Name</label>
								<input type="text" class="validate[funcCall[checknotinteger]] form-control" name="last_name" id="last_name" value="<?php echo (isset($last_details->last_name))?$last_details->last_name:''?>">
							</div>
							<div class="form-group col-lg-3">
								<label class="control-label mb-10 text-left">Date of Birth</label>
								<input type="hidden" name="present_date" id="present_date" value="<?php echo date('d-m-Y');?>">
								<div class="input-group date" id="datepicker">
									<input type="text" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="dob" id="dob" value="<?php echo (isset($last_details->date_of_birth))?($last_details->date_of_birth!=Null && $last_details->date_of_birth!='0000-00-00')?date('d-m-Y',strtotime($last_details->date_of_birth)):'':''?>" class="validate[custom[date2]] form-control">
									<span class="input-group-addon">
										<span class="fa fa-calendar"></span>
									</span>	
								</div>
							</div>	
							
						</div>
						<ul class="nav nav-pills">
							 <?php 	if(isset($_REQUEST['emp_id'])){?>
							<li id='emppersonal_li'>
								<a data-toggle="tab" href="#emppersonal-info">
									<i class="green ace-icon fa fa-pencil-square-o bigger-125"></i>
									Personal Information
								</a>
							</li>

							<li id='empwork_li'>
								<a data-toggle="tab" id="checkchosen" href="#empwork-info">
									<i class="purple ace-icon fa fa-cog bigger-125"></i>
									Work Information
								</a>
							</li>
							<li id='empreportees_li'>
								<a data-toggle="tab" href="#empreportees">
									<i class="red ace-icon fa fa-pencil bigger-125"></i>
									Reportees
								</a>
							</li>
							<li id='empuser_li'>
								<a data-toggle="tab" href="#empuser">
									<i class="red ace-icon fa fa-pencil bigger-125"></i>
									User Roles
								</a>
							</li>
				 <?php 	}else{?>
							<li id='emppersonal_li' class="active">
								<a data-toggle="tab" href="#emppersonal-info">
									<i class="green ace-icon fa fa-pencil-square-o bigger-125"></i>
									Personal Information
								</a>
							</li>

							<li class="disabled">
								<a data-toggle="tab" href="#empwork-info">
									<i class="purple ace-icon fa fa-cog bigger-125"></i>
									Work Information
								</a>
							</li>
							<li class="disabled">
								<a data-toggle="tab" href="#empreportees">
									<i class="purple ace-icon fa fa-cog bigger-125"></i>
									Reportees
								</a>
							</li>
							<li class="disabled">
								<a data-toggle="tab" href="#empuser">
									<i class="red ace-icon fa fa-pencil bigger-125"></i>
									User Roles
								</a>
							</li>
							<?php 	
							}?>	
							
						</ul>
						<div class="tab-content">
							<div id="emppersonal-info" class="tab-pane active">
								<div class="panel-body">
									<h6 class="header blue bolder smaller">Employee Details</h6>
									<hr class="light-grey-hr">
									<div class="row">
										<div class="form-group col-lg-2">
											<label class="control-label mb-10 text-left">Employee Status<sup><font color="#FF0000">*</font></sup>:</label>
											<select name="emp_status" id="emp_status" class="validate[required] form-control m-b">
												<option value="">Select</option>
												<?php 	
												foreach($empstats as $empstatus){
													$stat_sel=(isset($last_details->current_employee_flag))?($last_details->current_employee_flag==$empstatus['code'])?"selected='selected'":'':''?>
													<option value="<?php echo $empstatus['code'];?>" <?php echo $stat_sel;?>><?php echo $empstatus['name'];?></option>
												<?php 	
												}?>
											</select>
										</div>
										<div class="form-group col-lg-2">
											<label class="control-label mb-10 text-left">Date of Joining<sup><font color="#FF0000">*</font></sup>:</label>
											<div class="input-group date" id="datepicker">
												<input type='hidden' name='org_start_date' id='org_start_date' value='<?php echo date('d-m-Y',strtotime($_SESSION['org_start_date']))?>'>
												<input type="text" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="date_of_joining" id="date_of_joining" value="<?php echo (isset($last_details->date_of_joining))?($last_details->date_of_joining!=Null && $last_details->date_of_joining!='0000-00-00')?date('d-m-Y',strtotime($last_details->date_of_joining)):'':''?>" class="validate[required, custom[date2]] form-control">
												<span class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</span>	
											</div>
										</div>
										<div class="form-group col-lg-2">
											<label class="control-label mb-10 text-left">Date of Exit</label>
											<div class="input-group date" id="datepicker">
												<input type='hidden' name='org_start_date' id='org_start_date' value='<?php echo date('d-m-Y',strtotime($_SESSION['org_start_date']))?>'>
												<input type="text" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="date_of_exit" id="date_of_exit" value="<?php echo (isset($last_details->date_of_exit))?($last_details->date_of_exit!=Null && $last_details->date_of_exit!='0000-00-00')?date('d-m-Y',strtotime($last_details->date_of_exit)):'':''?>" class="validate[custom[date2],future[#date_of_joining]] form-control">
												<span class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</span>	
											</div>
										</div>
										<div class="form-group col-lg-3">
											<label class="control-label mb-10 text-left">Email Address</label>
											<input type="text" class="validate[custom[email]] form-control email checkmail" name="email" id="email" value="<?php echo (isset($last_details->email))?$last_details->email:''?>">
										</div>
										<div class="form-group col-lg-3">
											<label class="control-label mb-10 text-left">Phone</label>
											<input type="text" class="validate[custom[phone]] form-control" name="phone" id="phone" value="<?php echo (isset($last_details->office_number))?trim($last_details->office_number):''?>" maxlength='13'>
										</div>
										<div class="form-group col-lg-3">
											<label class="control-label mb-10 text-left">Country</label>
											<select name="country" id="country" class="form-control m-b">
												<option value="">Select</option>
												<?php 	
												foreach($empcntry as $empcountry){
													$nat_sel=(isset($last_details->country))?($last_details->country==$empcountry['code'])?"selected='selected'":'':''?>
													<option value="<?php echo $empcountry['code'];?>" <?php echo $nat_sel;?>><?php echo $empcountry['name'];?></option>
												<?php 	
												}?>
											</select>
										</div>
										<div class="form-group col-lg-3">
											<label class="control-label mb-10 text-left">Nationality</label>
											<select class="form-control m-b" name="nationality" id="nationality" >
												<option value="">Select</option>
												<?php 	
												foreach($empnation as $empnationality){
													$nat_sel=(isset($last_details->nationality))?($last_details->nationality==$empnationality['code'])?"selected='selected'":'':''?>
													<option value="<?php echo $empnationality['code'];?>" <?php echo $nat_sel;?>><?php echo $empnationality['name'];?></option>
												<?php 	
												}?>
											</select>
										</div>
										<div class="form-group col-lg-3">
											<label class="control-label mb-10 text-left">Qualification</label>
											<input type="text" class="form-control" name="qualification" id="qualification" value="<?php echo (isset($last_details->edu_qualification))?trim($last_details->edu_qualification):''?>" maxlength='13'>
										</div>
										<div class="form-group col-lg-3">
											<label class="control-label mb-10 text-left">Experience</label>
											<input type="text" class="validate[custom[number]] form-control" name="experience" id="experience" value="<?php echo (isset($last_details->previous_exp))?trim($last_details->previous_exp):''?>" maxlength='13' >
										</div>
										<div class="form-group col-lg-12">
											<label class="control-label mb-10 text-left">Additional Information</label>
											<textarea class="validate[custom[alphanumericSp]] form-control" name="add_info" id="add_info" style="resize:none;"><?php echo (isset($last_details->additional_info))?$last_details->additional_info:''?></textarea>
										</div>
									</div>

									<hr class="light-grey-hr">
									<div class="form-group">
										<button class="btn btn-primary btn-sm" type="submit" name="save" id="save"> Save & Proceed</button>
										<a href="<?php echo BASE_URL; ?>/admin/employee_search" class="btn btn-danger btn-sm" type="button"> <span class="bold">Cancel</span></a>
										
										
									</div>
								</div>
							</div>
							<div id="empwork-info" class="tab-pane">
								<div class="panel-body">
									<h6 class="header blue bolder smaller">Work Details</h6>	
									<hr class="light-grey-hr">
									<div class="row">
										<a class="btn btn-xs btn-primary" data-toggle='modal' href='#workinfoviewadd' onclick="on_loads()">&nbsp <i class="fa fa-plus-circle"></i> Add &nbsp;</a>
										<a class="btn btn-danger btn-xs" name="del_emp" id="del_emp" onclick="DelInfo()">&nbsp <i class="fa fa-trash-o"></i>  Delete &nbsp;</a>
										<div id="work_div" style="height: 300px; overflow: auto; border: 1px solid #DDDDDD;">
											<div class="table-responsive">
												<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="workinfo_tab">
													<thead>
													<tr>
														<th>Select</th>
														<th>From Date</th>
														<th>To Date</th>
														<th>Organization</th>
														<th>Status</th>
														<th>Details</th>
													</tr>
													</thead>
													<tbody>
													<?php
													if(count($last_wrk_details)>0){
														$var=array();
														foreach($last_wrk_details as $key=>$last_wrk_det){
															$var[]=$key;
															$key1=$key-1;
													?>
													<tr id="worktab<?php echo $key;?>">
														<td>
														<input type="hidden" name="work_info_id" id="work_info_id" value="<?php echo (isset($last_wrk_det['work_info_id']))?$last_wrk_det['work_info_id']:''?>">
														<label><input type="checkbox"  name="select_chk" id="select_chk[<?php echo $key;?>]" value="<?php echo $key;?>"></label></td>
														<td>
															<input type="hidden" name="work_id[]" id="work_id[<?php echo $key;?>]" value="<?php echo (isset($last_wrk_det['work_info_id']))?$last_wrk_det['work_info_id']:''?>">
															<div class="input-group date" id="datepicker">
																<input type="text" name="from_date[]" id="from_date<?php echo $key;?>" value="<?php echo (isset($last_wrk_det['from_date']))?($last_wrk_det['from_date']!=Null)?date('d-m-Y',strtotime($last_wrk_det['from_date'])):date('d-m-Y',strtotime($last_details->date_of_joining)):date('d-m-Y',strtotime($last_details->date_of_joining))?>" readonly class="validate[custom[date2],future[#to_date<?php echo $key1;?>], past[#date_of_exit]] form-control">
																<span class="input-group-addon">
																	<span class="fa fa-calendar"></span>
																</span>	
															</div>
														</td>
														<td>
															<div class="input-group date" id="datepicker">
																<input type="text" name="to_date[]" id="to_date<?php echo $key;?>" onfocus="date_funct(this.id)" value="<?php echo (isset($last_wrk_det['to_date']))?($last_wrk_det['to_date']!=Null && $last_wrk_det['to_date']!='0000-00-00')?date('d-m-Y',strtotime($last_wrk_det['to_date'])):'':''?>" onchange="setfromdate(<?php echo $key;?>)" class="validate[custom[date2],future[#from_date<?php echo $key;?>], past[#date_of_exit]] form-control">
																<span class="input-group-addon">
																	<span class="fa fa-calendar"></span>
																</span>	
															</div>
														</td>
														<td>
															<select name="department[]" id="department[<?php echo $key;?>]"  class="validate[required] form-control m-b">
																<option value="0">Select</option>
																<?php 	
																foreach($emp_orgdetails as $org1){
																	$org_sel=(isset($last_wrk_det['org_id']))?($last_wrk_det['org_id']==$org1['id'])?"selected='selected'":'':''?>
																	<option value="<?php echo $org1['id'];?>" <?php echo $org_sel;?>><?php echo $org1['name'];?></option>
																<?php 	
																}?>
															</select>
														</td>
														<td>
															<input type='hidden' name='stat_hidden' id='stat_hidden[<?php echo $key;?>]' value="<?php echo (isset($last_wrk_det['status']))?$last_wrk_det['status']:''?>">
															<select class="form-control m-b" name="status[]" id="status[<?php echo $key;?>]" onchange="status_change()">
																<?php 	
																foreach($orgstat as $orgstatus){
																	$sel_sat=(isset($last_wrk_det['status']))?($last_wrk_det['status']==$orgstatus['code'])?"selected='selected'":'':''?>
																	<option value="<?php echo $orgstatus['code']?>" <?php echo $sel_sat?>><?php echo $orgstatus['name']?></option>
																<?php 	
																}?>
															</select>
														</td>
														<td>
															<a  class="btn btn-primary btn-sm" data-target="#workinfoview<?php echo $last_wrk_det['work_info_id']; ?>" onclick='work_info_view(<?php echo $last_wrk_det['work_info_id']; ?>)' data-toggle='modal' href='#workinfoview<?php echo $last_wrk_det['work_info_id']; ?>'>
																Details
															</a>
														</td>
													</tr>
													<?php   
														}
														$hiden_val=@implode(',',$var);
													}
													?>
													</tbody>
													<input type="hidden" name="inner_hidden_id" id="inner_hidden_id" value="<?php echo !empty($hiden_val)?$hiden_val:"0";?>">
												</table>
											</div>
										</div>
										<hr class="light-grey-hr">
										<div class="form-group">
											<div class="col-sm-offset-0">
												<button class="btn btn-primary btn-sm" type="submit" name="save" id="save" onclick="return orgname_valid()"> Save & Proceed</button>
												<a href="#" onclick="create_link('employee_search')" class="btn btn-danger btn-sm" > <span class="bold">Cancel</span></a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div id="empreportees" class="tab-pane">
								<div class="panel-body">
									
									<div class="col-lg-12">
										<div class="row">
											<div class="panel-heading hbuilt">
												Reportees Details
											</div>
											<div class="table-responsive">
												<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
													<thead>
													<tr>
														<th>Employee Number</th>
														<th>Employee Name</th>
														<th>Div/Dept/Sec</th>
														<th>Position</th>
														<th>Location</th>
													</tr>
													</thead>
													<tbody>
													<?php 
													if(count($reportees_data)>0){
														foreach($reportees_data as $key=>$reportees_info){?>
															<tr>
																<td><?php echo $reportees_info['employee_number'];?></td>
																<td><?php echo $reportees_info['full_name'];?></td>
																<td><?php echo $reportees_info['value_name'];?></td>
																<td><?php echo $reportees_info['position_name'];?></td>
																<td><?php echo $reportees_info['location_name'];?></td>
															</tr>
														<?php 	
														}
														}else{?>
															<td colspan="5">No Reportees Found</td>
														<?php 	
														} ?>
													</tbody>
												</table>
											</div>
											
										</div>
									</div>
									<hr class="light-grey-hr">
									<div class="form-group">
										<div class="col-sm-offset-0">
											<button class="btn btn-primary btn-sm" type="submit" name="save" id="save" onclick="return orgname_valid()"> Save & Proceed</button>
											<a href="#" onclick="create_link('employee_search')" class="btn btn-danger btn-sm" > <span class="bold">Cancel</span></a>
										</div>
									</div>
								</div>
							</div>
							<div id="empuser" class="tab-pane">
								<div class="col-lg-12">
									<h6 class="header blue bolder smaller">User Roles</h6>	
									<hr class="light-grey-hr">
									<div class="row">
										<div class="form-group col-lg-4">
											<label class="control-label mb-10 text-left">Username<sup><font color="#FF0000">*</font></sup>:</label>
											<input type="hidden" id="user_id" name="user_id" value="<?php echo isset($usercreate->user_id)? $usercreate->user_id:""; ?>" />
											<input type="text" name="user_name" id="user_name" value="<?php echo isset($usercreate->user_name)? $usercreate->user_name:""; ?>" class="validate[required,minSize[4],maxSize[80],ajax[ajaxUsername]] form-control" >
										</div>
										<div class="form-group col-lg-4">
											<label class="control-label mb-10 text-left">Email Address</label>
											<input type="text" name="email_address" class="validate[custom[email]] form-control" value="<?php echo isset($usercreate->email_address)? trim($usercreate->email_address):""; ?>" id="email_address" readonly >
											<input type="hidden" name="doj" id="doj">
										</div>
										<div class="form-group col-lg-4">
											<label class="control-label mb-10 text-left">User Type<sup><font color="#FF0000">*</font></sup>:</label>
											<select name="user_type" id="user_type" class="validate[required]  form-control m-b">
												<option value="">Select</option>
												<?php $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
												$query = "select mc.master_code, mv.* from uls_admin_master mc, uls_admin_values mv where mc.master_code='EMP_TYPE' and mc.master_code=mv.master_code";
												$user_type = $pdo->prepare($query);
												$user_type->execute(); 
												$user_types=$user_type->fetchAll();
												foreach($user_types as $user_types1){ $sel=isset($usercreate->user_type)? (($usercreate->user_type==$user_types1['value_code'])?"selected='selected'":""):""; ?>
												<option <?php echo $sel; ?> value="<?php echo $user_types1['value_code'];?>"><?php echo $user_types1['value_name'];?></option>
												<?php } ?>
											</select>
										</div>
										<div class="form-group col-lg-4">
											<label class="control-label mb-10 text-left">Password<sup><font color="#FF0000">*</font></sup>:</label>
											<input type="password" name="password" id="password" value="<?php echo isset($usercreate->password)? $usercreate->password:""; ?>" class="validate[required,minSize[4],maxSize[80]]  form-control" >
										</div>
										<div class="form-group col-lg-4">
											<label class="control-label mb-10 text-left">Confirm Password</label>
											<input type="password" name="con_password" id="con_password" value="<?php echo isset($usercreate->password)? $usercreate->password:""; ?>" class="validate[required,minSize[4],maxSize[80],equals[password]] form-control">
										</div>
										
										<div class="form-group col-lg-2">
											<label class="control-label mb-10 text-left">Start Date<sup><font color="#FF0000">*</font></sup>:</label>
											<div class="input-group date" id="datepicker_new">
												<input type="text" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy"  name="start_date" id="start_date" value="<?php echo isset($usercreate->start_date)? (($usercreate->start_date!=NULL)? date("d-m-Y",strtotime($usercreate->start_date)):""):""; ?>" class="validate[required,custom[date2]] form-control">
												<span class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</span>	
											</div>
										</div>
										<div class="form-group col-lg-2">
											<label class="control-label mb-10 text-left">End Date</label>
											<div class="input-group date" id="datepicker_news">
												<input type="text" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy"  name="end_date" id="end_date" value="<?php echo isset($usercreate->end_date)? (($usercreate->end_date!=NULL)? date("d-m-Y",strtotime($usercreate->end_date)):""):""; ?>" class="validate[custom[date2],future[#start_date]] form-control">
												<span class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</span>	
											</div>
										</div>
									</div>
									<div class="row">
										<div class="panel-heading hbuilt">
											<div class="pull-right">
												<a class="btn btn-xs btn-primary" onClick="AddExpenses()">&nbsp <i class="fa fa-plus-circle"></i> Add Row&nbsp</a>
												<a class="btn btn-danger btn-xs" onClick="DelExpenses()">&nbsp <i class="fa fa-trash-o"></i>  Delete Row&nbsp</a>
											</div>
										</div>
										<div class="table-responsive col-lg-12">
											<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id='expense_details'>
												<thead>
												<tr>
													<th>Select</th>
													<th>Role Name</th>
													<th>Comments</th>
													<th>Start Date</th>
													<th>End Date</th>
													<th>Menu</th>
												</tr>
												</thead>
												<tbody>
												<?php
												if(isset($rolecreate) && !empty($rolecreate)){
													$var=array();
													foreach($rolecreate as $key1=>$roles){
														$var[]=$key1;
														$role_names=UlsRoleCreation::getspecRoles($roles['role_id']);
														?>
														<tr  id="expenses<?php echo $key1;?>">
															<td><label><input type="checkbox" id="rollid_<?php echo $key1;?>" name="rolename[]" class="validate[minCheckbox[1]] checkbox" value="<?php echo $key1;?>" <?php echo isset($roles['role_id'])? (($roles['role_id']==$role_names['role_id'])?"checked='checked' disabled='disabled'":""):""; ?>></label></td>
															<td>
															<input id="user_role_id<?php echo $key1; ?>" type="hidden" name="user_role_id[<?php echo $key1; ?>]" value="<?php echo $roles['user_role_id']; ?>">
															<select class="form-control m-b" name="role_id[<?php echo $key1;?>]" id="role_id<?php echo $key1;?>" onchange="getRole(<?php echo $roles['role_id']; ?>,<?php echo $key1;?>);">
																<option <?php //echo $select; ?> value="<?php echo $role_names['role_id']; ?>" ><?php echo $role_names['role_name']; ?></option>
															</select>
															</td>
															<td>
															<input type="text" name="description[<?php echo $key1;?>]"  id="description<?php echo $key1;?>"  class="form-control" value="<?php echo isset($roles['description'])? $roles['description']:""; ?>">
															</td>
															<td>
																<div class="input-group date" id="datepicker_start<?php echo $key1;?>">
																	<input type="text" name="startdate[<?php echo $key1;?>]" id="startdate_<?php echo $key1;?>" class="validate[required,custom[date2],future[#start_date]] form-control" value="<?php echo isset($roles['start_date'])? (($roles['start_date']!=NULL && !empty($roles['start_date']))? date("d-m-Y",strtotime($roles['start_date'])):""):""; ?>">
																	<span class="input-group-addon">
																		<span class="fa fa-calendar"></span>
																	</span>	
																</div>
															</td>
															<td>
																<div class="input-group date" id="datepicker_end<?php echo $key1;?>">
																	<input type="text" name="enddate[<?php echo $key1;?>]"  id="enddate_<?php echo $key1;?>" class="validate[custom[date2],future[#startdate_<?php echo $key1;?>]] form-control" value="<?php echo isset($roles['end_date'])? (($roles['end_date']!=NULL && !empty($roles['end_date']))? date("d-m-Y",strtotime($roles['end_date'])):""):""; ?>">
																	<span class="input-group-addon">
																		<span class="fa fa-calendar"></span>
																	</span>	
																</div>
															</td>
															<td>
																<div id="menu_execlusions<?php echo $key1;?>">
																	<input type='hidden' value='<?php echo isset($roles['menu_id'])?$roles['menu_id']:""; ?>' name='menuid[<?php echo $key1; ?>]' id='menuids_<?php echo $key1; ?>' >
																	<a onClick='exclusion(<?php echo $roles['role_id']; ?>,<?php echo $roles['role_id']; ?>)'><input type='button' name='exclusion' id='exclusion<?php echo $key1;?>' value='Menu'></a>
																</div>
															</td>
															<script>
																$(document).ready(function(){
																	var date1 = new Date();
																	var date2 = new Date(2039,0,19);
																	var timeDiff = Math.abs(date2.getTime() - date1.getTime());
																	var difDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
																	var dates = $( "#startdate_<?php echo $key1;?>, #enddate_<?php echo $key1;?>" ).datepicker({
																		dateFormat:"dd-mm-yy",
																		defaultDate: "+1w",
																		changeMonth: true,
																		changeYear: true,
																		numberOfMonths: 1,
																		/*minDate:0,
																		maxDate:difDays,*/
																		onSelect: function( selectedDate ) {
																			var option = this.id === "startdate_<?php echo $key1;?>" ? "minDate" : "maxDate", instance = $( this ).data( "datepicker" ),date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat,selectedDate, instance.settings );
																			dates.not( this ).datepicker( "option", option, date );
																		}
																	});
																	if($("#enddate_<?php echo $key1;?>").val()!=""){
																		$( "#startdate_<?php echo $key1;?>" ).datepicker("option", "maxDate", $("#enddate_<?php echo $key1;?>").val());
																	}
																	if($("#startdate_<?php echo $key1;?>").val()!=""){
																		$( "#enddate_<?php echo $key1;?>" ).datepicker("option", "minDate", $("#startdate_<?php echo $key1;?>").val());
																	}
																});
																
															</script>
														</tr>
														<?php
															$val=@implode(',',$var);
													}
												}
												else{
													$val=0;?>
													<tr>
														<td><label><input type="checkbox" id="rollid_0" name="rolename[]" class="validate[minCheckbox[1]] checkbox" value="0" ></label></td>
														<td>
														<input id="user_role_id0" type="hidden" name="user_role_id[0]" value="" >
														<select class="form-control m-b" name="role_id[0]" id="role_id0" onchange="getRole(this.value,0);">
															<option value="">Select</option>
															<?php
															foreach($roless as $roles1){
															?>
															<option value="<?php echo $roles1['role_id']; ?>"><?php echo $roles1['role_name']; ?></option>
															<?php
															}
															?>	
														</select>
														</td>
														<td>
														<input type="text" name="description[0]"  id="description0" class="form-control">
														</td>
														<td>
															<div class="input-group date" id="datepicker_start0">
																<input type="text" name="startdate[0]" id="startdate_0" class="validate[required,custom[date2],future[#start_date]] form-control">
																<span class="input-group-addon">
																	<span class="fa fa-calendar"></span>
																</span>	
															</div>
														</td>
														<td>
															<div class="input-group date" id="datepicker_end0">
																<input type="text"name="enddate[0]"  id="enddate_0" class="validate[custom[date2],future[#startdate_0]] form-control">
																<span class="input-group-addon">
																	<span class="fa fa-calendar"></span>
																</span>	
															</div>
														</td>
														<td>
															<div id="menu_execlusions0">
																	<input type='button' name='exclusion' id='exclusion0' value='Menu'>
															</div>
														</td>
														<script>
															$(document).ready(function(){
																var date1 = new Date();
																var date2 = new Date(2039,0,19);
																var timeDiff = Math.abs(date2.getTime() - date1.getTime());
																var difDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
																var dates = $( "#startdate_0, #enddate_0" ).datepicker({
																	dateFormat:"dd-mm-yy",
																	defaultDate: "+1w",
																	changeMonth: true,
																	changeYear: true,
																	numberOfMonths: 1,
																	/*minDate:0,
																	maxDate:difDays,*/
																	onSelect: function( selectedDate ) {
																		var option = this.id === "startdate_0" ? "minDate" : "maxDate", instance = $( this ).data( "datepicker" ),date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat,selectedDate, instance.settings );
																		dates.not( this ).datepicker( "option", option, date );
																	}
																});
																if($("#enddate_0").val()!=""){
																	$( "#startdate_0" ).datepicker("option", "maxDate", $("#enddate_0").val());
																}
																if($("#startdate_0").val()!=""){
																	$( "#enddate_0" ).datepicker("option", "minDate", $("#startdate_0").val());
																}
															});
															
														</script>
													</tr>
													
												<?php } ?>
												</tbody>
											</table>
											<?php foreach($roless as $roles11){ ?>
												<div id="msg<?php echo $roles11['role_id']; ?>"></div>
											<?php } ?>
											<input type='hidden' id='exp_hidden_id' value='<?php echo $val;?>' name="exp_hidden_id" />
										</div>
									</div>
								</div>
								<hr class="light-grey-hr">
								<div class="form-group">
									<div class="col-sm-offset-0">
										<button class="btn btn-primary btn-sm" type="submit" name="save" id="save" onclick="return AddExpenses_validation();">Save & Proceed</button>
										<a href="#" onclick="create_link('employee_search')" class="btn btn-danger btn-sm" ><span class="bold">Cancel</span></a>
									</div>
								</div>
							</div>
						</div>
                        
                    </form>
            </div>
        </div>

    </div>
</div>
<?php
if(!empty($last_wrk_details)>0){
foreach($last_wrk_details as $key=>$last_wrk_det){
	?>
<div id="workinfoview<?php echo $last_wrk_det['work_info_id']; ?>"  class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="color-line"></div>
			<div class="modal-header">
				<h6 class="modal-title">Employee Work Info </h6>
			</div>
			<div class="modal-body">
				<div id="workinfodetails<?php echo $last_wrk_det['work_info_id']; ?>" class="modal-body no-padding">
				
				</div>
			</div>
			
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<?php 
}
}
?>
<div class="modal fade" id="workinfoviewadd" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="color-line"></div>
			<div class="modal-header">
				<h6 class="modal-title">Employee Work Info </h6>
			</div>
			<form role="form" action="<?php echo BASE_URL;?>/admin/emp_work_single_details" method="post" id="work_info">
			<input type="hidden" name="employee_id" id="employee_id" value="<?php echo (isset($_REQUEST['emp_id']))?$_REQUEST['emp_id']:''?>">
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12">
						<div class="form-group col-lg-6">
							<label>From Date<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="input-group date" id="datepicker_from">
								<input type="text" name="from_date[]" id="from_date_0" readonly="" class="validate[required,custom[date2],past[#date_of_exit]] form-control">
								<span class="input-group-addon">
									<span class="fa fa-calendar"></span>
								</span>	
							</div>
						</div> 
						<div class="form-group col-lg-6">
							<label>To Date:</label>
							<div class="input-group date" id="datepicker_to">
								<input type="text"  name="to_date[]" id="to_date" value="" onfocus="date_funct(this.id)"  class="validate[custom[date2],future[#from_date_0]] form-control"><!-- onchange="setfromdate()" -->
								<span class="input-group-addon">
									<span class="fa fa-calendar"></span>
								</span>	
							</div>
						</div>
						<div class="form-group col-lg-6">
							<label>Organization<sup><font color="#FF0000">*</font></sup>:</label>
							<select name="department[]" id="department" onchange="get_pos(0)" class="validate[required] chosen-select form-control m-b ">
							<option value="">Select</option>
								<?php 	
								foreach($emp_orgdetails as $org1){
								?>
								<option value="<?php echo $org1['id'];?>"><?php echo $org1['name'];?></option>
								<?php 	
								}?>
							</select>
						</div>
						<div class="form-group col-lg-6">
							<label>Business Unit</label>
							<select class="validate[required] form-control m-b" name="business_unit[]" id="business_unit">
								<option value="0">Select</option>
								<?php 	
								foreach($business_units as $bu){
								?>
									<option value="<?php echo $bu['id'];?>" ><?php echo $bu['name'];?></option>
								<?php 	
								}?>
							</select>
						</div>
						<div class="form-group col-lg-6">
							<label>Parent Department:</label>
							<select class="validate[] form-control m-b" name="parent_dep_id[]" id="parent_dep_id">
								<option value="">Select</option>
								<?php 	
								foreach($parent_depart as $pdt){
									?>
									<option value="<?php echo $pdt['id'];?>" ><?php echo $pdt['name'];?></option>
								<?php 	}?>
							</select>
						</div>
						<div class="form-group col-lg-6">
							<label>Division:</label>
							<select class="validate[] form-control m-b" name="division_id[]" id="division_id">
								<option value="">Select</option>
								<?php 	
								foreach($division_detail as $pdiv){
								?>
									<option value="<?php echo $pdiv['id'];?>" ><?php echo $pdiv['name'];?></option>
								<?php 	
								}?>
							</select>
						</div>
						<div class="form-group col-lg-6">
							<label>Position</label>
							<select class="form-control m-b" name="position[]" id="position[0]" onclick="check_org(0)">
								<option value="">Select</option>
								<?php
								foreach($positions as $emp_position){                   
								?>
									<option value="<?php echo $emp_position['position_id'];?>" ><?php echo $emp_position['position_name'];?></option>
								<?php	
								}?> 
							</select>
						</div>
						<div class="form-group col-lg-6">
							<label>Grade</label>
							<select class="form-control m-b" name="grade[]" id="grade[0]" onclick="grade_change(0)">
								<option value="">Select</option>
								<?php 	
								foreach($emp_grade as $emp_grad){
								?>
									<option value="<?php echo $emp_grad->grade_id;?>"><?php echo $emp_grad->grade_name;?></option>
								<?php 	
								}?>
							</select>
						</div>
						<div class="form-group col-lg-6">
							<label>Sub Grade</label><div id="subgradediv0">
							<select class="form-control m-b" name="sub_grade[]" id="sub_grade[0]" >
								<option value="">Select</option>
								<?php 	
								foreach($sub_grade as $sub_grades){?>
									<option value="<?php echo $sub_grades['sub_grade_id'];?>" ><?php echo $sub_grades['sub_name'];?></option>
								<?php 	
								}?>
							</select></div>
						</div>
						
						<div class="form-group col-lg-6">
							<label>Manager</label>
							<select class="form-control m-b" name="manager[]" id="manager[]" onclick="check_org(0)">
								<option value="">Select</option>
							</select>
						</div>
						<div class="form-group col-lg-6">
							<label>Payroll</label>
							<input name="payroll[]" id="payroll[]" onclick="check_org(0)" class="form-control" type="text">
						</div>
						<div class="form-group col-lg-6">
							<label>Gross Salary</label>
							<input name="gross[]" id="gross"  maxlength='9' class="form-control" type="text">
						</div>
						<div class="form-group col-lg-6">
							<label>Net Salary</label>
							<input name="net[]" id="net[0]" value="" maxlength='9' class="form-control"  type="text">
						</div>
						<div class="form-group col-lg-6">
							<label>Total CTC</label>
							<input  name="ctc[]" id="ctc"  maxlength='9' class="form-control" type="text">
						</div>
						<div class="form-group col-lg-6">
							<label>Zones<sup><font color="#FF0000">*</font></sup>:</label>
							<select class="validate[required] form-control m-b" name="zones_name[]" id="zones_name[0]" onchange="zones_change(0)">
								<option value="">Select</option>
								<?php 	
								foreach($zonestatus as $zonestatuss){?>
								<option value="<?php echo $zonestatuss['zone_id'];?>"><?php echo $zonestatuss['zone_name'];?></option>
								<?php 	
								}?>
							</select>
						</div>
						<div class="form-group col-lg-6">
							<label>States<sup><font color="#FF0000">*</font></sup>:</label><div id='statenames0'>
							<select class="validate[required] form-control m-b" name="state_id[]" id="state_id[0]" onchange="open_location_state(0)">
								<option value="">Select</option>
								<?php 	
								foreach($states as $state){?>
								<option value="<?php echo $state['state_id'];?>"><?php echo $state['state_name'];?></option>
								<?php 	
								}?>
							</select></div>
						</div>
						<div class="form-group col-lg-6" >
							<label>Location<sup><font color="#FF0000">*</font></sup>:</label>
							<div id="locationnames0"> 
							<select class="validate[required] form-control m-b" name="location[]" id="location[0]" onclick="check_org(0)">
								<option value="">Select</option>
							</select>
							</div>
						</div>
						<div class="form-group col-lg-6" >
							<label>Status:</label>
							<select class="form-control m-b"  name="status[]" id="status[0]" onchange="status_change()">
								<option value="">Select</option>
								<?php 
								foreach($orgstat as $orgstatus){?>
								<option value="<?php echo $orgstatus['code']?>"><?php echo $orgstatus['name']?></option>
								<?php 	
								}?>
							</select>
						</div>
						<div class="form-group col-lg-6">
							<label>Supervisor</label>
							<select class="supervisor chosen-select form-control m-b" name="supervisor[]" id="supervisor_0" onclick="check_org(0)">
								<option value="">Select</option>
								<?php 	 
								if(count($supervisors_data)>0){
									foreach($supervisors_data as $supervisor){
										echo "<option value='".$supervisor['employee_id']."' >".$supervisor['employee_number']." ".$supervisor['full_name']."</option>";
									}
								}   ?>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
				<button type="submit" name="submit_user" id="submit_user" class="btn btn-primary btn-sm">Save changes</button>
			</div>
			</form>
		</div>
	</div>
</div>
