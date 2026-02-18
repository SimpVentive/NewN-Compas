<?php 
	if(isset($_REQUEST['message'])){
		echo "<div align='center'><font color='#009966'>Employee Details Added Successfully</font></div>";
	}
	$empid=$_REQUEST['emp_id'];
	$hash=SECRET.$empid;
	$wrkid=$_REQUEST['wrk_id'];
	$wrkhash=SECRET.$wrkid;
?>
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">
				<div class="panel-heading">
					Employee Details
				</div>
                <div class="panel-body">					
					<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1">
						<thead>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Title</th>
								<th><?php  echo $last_details['title'];?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Gender</th>
								<th><?php  echo $last_details['gender_status'];?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%"> First Name</th>
								<th><?php  echo $last_details['first_name'];?>&nbsp;  </th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%"> Employee Type</th>
								<th><?php  echo $last_details['new_emp_type_status'];?>&nbsp; </th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Middle Name</th>
								<th><?php  echo $last_details['middle_name'];?>&nbsp; </th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Employee Number</th>
								<th><?php  echo $last_details['employee_number'];?>&nbsp; </th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Last Name</th>
								<th><?php  echo $last_details['last_name'];?>&nbsp; </th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Date of Birth</th>
								<th><?php echo ($last_details['date_of_birth']!=Null)?date('d-m-Y',strtotime($last_details['date_of_birth'])):''?>&nbsp; </th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-inverse card-view">
				<div class="panel-body">
					<ul class="nav nav-pills">
						<li class="active">
							<a data-toggle="tab" href="#emppersonal-info">
								<i class="green ace-icon fa fa-pencil-square-o bigger-125"></i>
								Personal Information
							</a>
						</li>
						<li>
							<a data-toggle="tab" href="#empwork-info">
								<i class="purple ace-icon fa fa-cog bigger-125"></i>
								Work Information
							</a>
						</li>
						<li>
							<a data-toggle="tab" href="#empreportees">
								<i class="red ace-icon fa fa-pencil bigger-125"></i>
								Reportees
							</a>
						</li>
					</ul>
					<div class="tab-content">
						<div id="emppersonal-info" class="tab-pane in active">
							<h6 class="header blue bolder smaller">Employee Details</h6>							
							<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1">
								<thead>
									<tr>
										<th style=" background-color: #edf3f4;width:20%">Employee Status</th>
										<th><?php  echo $last_details['emp_status_status'];?>&nbsp;</th>
									</tr>
									<tr>
										<th style=" background-color: #edf3f4;width:20%">Qualification</th>
										<th><?php  echo $last_details['edu_qualification'];?>&nbsp;</th>
									</tr>
									<tr>
										<th style=" background-color: #edf3f4;width:20%"> Experience</th>
										<th><?php  echo $last_details['previous_exp'];?>&nbsp;  </th>
									</tr>
									<tr>
										<th style=" background-color: #edf3f4;width:20%"> Nationality</th>
										<th><?php  echo $last_details['nationality_status'];?>&nbsp; </th>
									</tr>
									<tr>
										<th style=" background-color: #edf3f4;width:20%">Date of Joining</th>
										<th><?php  echo ($last_details['date_of_joining']!=Null)?date('d-m-Y',strtotime($last_details['date_of_joining'])):''?>&nbsp; </th>
									</tr>
									<tr>
										<th style=" background-color: #edf3f4;width:20%">Date of Exit</th>
										<th><?php  echo ($last_details['date_of_exit']!=Null)?date('d-m-Y',strtotime($last_details['date_of_exit'])):''?>&nbsp; </th>
									</tr>
									<tr>
										<th style=" background-color: #edf3f4;width:20%">Email Address</th>
										<th><?php  echo $last_details['email']?>&nbsp; </th>
									</tr>
									<tr>
										<th style=" background-color: #edf3f4;width:20%">Country</th>
										<th><?php  echo $last_details['country_status']?>&nbsp; </th>
									</tr>
									<tr>
										<th style=" background-color: #edf3f4;width:20%">Phone</th>
										<th><?php  echo $last_details['office_number']?>&nbsp; </th>
									</tr>
									<tr>
										<th style=" background-color: #edf3f4;width:20%">Additional Information</th>
										<th><?php  echo $last_details['additional_info']?>&nbsp; </th>
									</tr>
								</thead>
							</table>
						</div>

						<div id="empwork-info" class="tab-pane">
							<div class="space-10"></div>
							<h6 class="header blue bolder smaller">Work Details</h6>
							<table id="workinfotable" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<td>From Date</td>
										<td>To Date</td>
										<td>Organization</td>
										<td>Position</td>
										<td>Grade</td>
										<td>Location</td>
										<td>Supervisor</td>
										<td>Gross Salary</td>
										<td>Net Salary</td>
										<td>Total CTC</td>
										<td>Status</td>
									</tr>
								</thead>
								<tbody>
								<?php 
									if(count($last_details['workinfo'])>0){$f=0;
										foreach($last_details['workinfo'] as $key=>$work_info){$f++;?>
											<tr <?php if($f==1){ ?> class="first" <?php } ?>>
												<td><label><?php echo ($work_info['from_date']!=Null)?date('d-m-Y',strtotime($work_info['from_date'])):''?></label></td>
												<td><label><?php echo ($work_info['to_date']!=Null)?date('d-m-Y',strtotime($work_info['to_date'])):''?></label></td>
												<td><label><?php echo $work_info['org_name'];?></label></td>
												<td><label><?php echo $work_info['position_name'];?></label></td>
												<td><label><?php echo $work_info['grade_name'];?></label></td>
												<td><label><?php echo $work_info['location_name'];?></label></td>
												<td><label><?php echo $work_info['full_name'];?></label></td>
												<td><label><?php echo $work_info['gross_salary'];?></label></td>
												<td><label><?php echo $work_info['net_salary'];?></label></td>
												<td><label><?php echo $work_info['total_ctc'];?></label></td>                    
												<td><label><?php echo $work_info['value_name'];?></label></td>
											</tr>
								<?php 	}
									}else{?>
										<tr class="first">
											<td class="nodata" colspan="5"><label>No Reportees Found</label></td>                    
										</tr>
						   <?php 	} ?>
								</tbody>
							</table>							
						</div>						
						
						<div id="empreportees" class="tab-pane">
							<div class="space-10"></div>
							<h6 class="header blue bolder smaller">Reportees Details</h6>
							<table id="reporteetable" class="table table-striped table-bordered table-hover">
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
									if(count($last_details['reportees'])>0){$f=0;
										foreach($last_details['reportees'] as $key=>$reportees_info){$f++;?>
											<tr <?php if($f==1){ ?> class="first" <?php } ?>>
												<td><label><?php echo $reportees_info['employee_number'];?></label></td>
												<td><label><?php echo $reportees_info['full_name'];?></label></td>
												<td><label><?php echo $reportees_info['org_name'];?></label></td>
												<td><label><?php echo $reportees_info['position_name'];?></label></td>
												<td><label><?php echo $reportees_info['location_name'];?></label></td>
											</tr>
								<?php 	}
									}else{?>
											<tr class="first">
												<td class="nodata" colspan="5"><label>No Reportees Found</label></td>                    
											</tr>
							   <?php 	} ?>
								</tbody>
							</table>							
						</div>

						
					</div>
					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<div class="col-sm-offset-4">
							<input type="button" class="btn btn-primary btn-sm" name="update" id="update" value="Update" onclick="create_link('employee_creation?status=person_edit&emp_id=<?php echo $empid;?>&hash=<?php echo $hash;?>&wrk_id=<?php echo $wrkid;?>&wrk_hash=<?php echo $wrkhash;?>')" >&nbsp;
							<input type="button" class="btn btn-primary btn-sm" name="create" value="Create" onClick="create_link('employee_creation')"/>&nbsp;					
							<input type="button" class="btn btn-primary btn-sm" name="cancel" id="cancel" value="Cancel" onclick="create_link('employee_search')" >
						</div>
					</div>			
					
				</div>
            </div>
        </div>
    </div>
</div>
