<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Create Employee</h6>
					</div>	
					<div class="pull-right">
						<a onClick="create_link('employee_creation?status=')" href="#" class="btn btn-primary btn-xs pull-left mr-15"><i class="fa fa-plus-circle"></i> Create Employee</a>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-body">
					<form action="#" id="loginForm">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group col-lg-6">
								<label class="control-label mb-10 text-left">Employee Number</label>
								<input name="emp_number" id="emp_number" value="<?php echo isset($emp_number)?$emp_number:''; ?>" class="form-control" type="text">
							</div>
							<div class="form-group col-lg-6">
								<label class="control-label mb-10 text-left">Employee Name</label>
								<input name="emp_name" id="emp_name" value="<?php echo isset($emp_name)? $emp_name:''; ?>" class="form-control" type="text">
							</div>
						</div>
						<div class="form-group col-md-1">
							<div class="text-left">
								<label class="control-label mb-10 text-left">&nbsp;</label>
								<button type="submit" class="btn btn-primary btn-sm" id="submit">Search</button>
							</div>

						</div>
					</div>
					</form>
				</div>
				<div class="hpanel">
					<div class="panel-body">
						<h6 class="txt-dark capitalize-font">Search Results</h6>
						<hr class="light-grey-hr">
						<div class="table-wrap">
							<div class="table-responsive">
								<div id="edit_datable_2_wrapper" class="dataTables_wrapper">
									<table cellpadding="1" cellspacing="1" id="edit_datable_2" class="table table-hover table-bordered mb-0">
										<thead>
											<tr>
												<th class="col-sm-2">Employee Number</th>
												<th class="col-sm-2">Employee Name</th>
												<th class="col-sm-2">Organization</th>
												<th class="col-sm-2">SBU</th>
												<th class="col-sm-2">Location</th>
												<th class="col-sm-1">Action</th>
											</tr>
										</thead>
										<tbody>
										<?php
										if(count($empdetails)>0){
											foreach($empdetails as $key=>$empdetail){
												$fullname=$empdetail['full_name'];
												$org_name=$empdetail['org_name'];
												$location_name=$empdetail['location_name'];
												$buname=$empdetail['buname'];
												$empid=$empdetail['employee_id'];
												$hash=SECRET.$empid;
												$wrkid=$empdetail['work_info_id'];
												$wrkhash=SECRET.$wrkid;
										?>
											<tr class="tooltip-demo" id='emp_row_<?php echo $key?>'>
												<td><?php echo $empdetail['employee_number'];?></td>
												<td><?php echo ucwords(strtolower($fullname));?></td>
												<td><?php echo ucwords(strtolower($org_name));?></td>
												<td><?php echo ucwords(strtolower($buname));?></td>
												<td class="hidden-480"><?php echo ucwords(strtolower($location_name));?></td>
												<td>
												<a class="mr-10" href="<?php echo BASE_URL?>/admin/view_emp_details?status&emp_id=<?php echo $empid; ?>&hash=<?php echo md5($hash); ?>&wrk_id=<?php echo $wrkid; ?>&wrk_hash=<?php echo md5($wrkhash); ?>" data-original-title="View" data-toggle="tooltip"><i class="fa fa-eye text-success m-r-10"></i></a>
												
												<a class="mr-10" href="<?php echo BASE_URL?>/admin/employee_creation?status&emp_id=<?php echo $empid?>&hash=<?php echo md5($hash);?>&wrk_id=<?php echo $wrkid;?>&wrk_hash=<?php echo md5($wrkhash);?>" data-original-title="Edit" data-toggle="tooltip"><i class="fa fa-pencil text-primary m-r-10"></i></a>
												
												<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" id="<?php echo $empid; ?>" name="delete_employee" rel="emp_row_<?php echo $key; ?>" onclick="deletefunction(this)"><i class="fa fa-trash text-danger"></i> <span class="bold"></span></a>
												</td>
											</tr>
											<?php
											}
										}
										else{
											echo "<td colspan='6' class='nodata'>No Data Found</td>";
										} ?>
										</tbody>
									</table>
									<?php echo $pagination; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="dialog-confirm" class="hide">
	<div class="alert alert-info bigger-110">
		Do you want to Delete this Employee ?
	</div>

	<div class="space-6"></div>

	<p class="bigger-110 bolder center grey">
		<i class="ace-icon fa fa-hand-o-right blue bigger-120"></i>
		Are you sure?
	</p>
</div>

<div id="dialog-confirm-delete" class="hide">
	<div class="alert alert-info bigger-110">
		You cannot delete an employee with a Training records exists in the application.
	</div>

	<div class="space-6"></div>
	
</div>