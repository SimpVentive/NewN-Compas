<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					<div class="clearfix"></div>
				</div>
				<div class="panel-body">
					<form action="#" id="loginForm">
					<div class="row">
						<div class="col-md-10">
							<div class="form-group col-lg-3">
								<label class="control-label mb-10 text-left">Employee Number</label>
								<input name="emp_number" id="emp_number" value="<?php echo isset($emp_number)?$emp_number:''; ?>" class="form-control" type="text">
							</div>
							<div class="form-group col-lg-4">
								<label class="control-label mb-10 text-left">Employee Name</label>
								<input name="emp_name" id="emp_name" value="<?php echo isset($emp_name)? $emp_name:''; ?>" class="form-control" type="text">
							</div>
							<div class="form-group col-lg-4">
								<label class="control-label mb-10 text-left">Assessment Name</label>
								<select class="form-control m-b" id="assessment_id" name="assessment_id" style="width: 100%">
									<option value="">Select</option>
									<?php 
									foreach($ass_name as $ass_names){
										$dep_sel=isset($assessment_id)?($assessment_id==$ass_names['assessment_id'])?"selected='selected'":"":"";
									?>
										<option value="<?php echo $ass_names['assessment_id'];?>" <?php echo $dep_sel; ?> ><?php echo $ass_names['assessment_name'];?></option>
									<?php } ?>
								</select>
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
												<th class="col-sm-2">Assessement</th>
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
												<td class="hidden-480"><?php echo $empdetail['assessment_name'];?></td>
												<td>
												<?php 
												//echo $empdetail['end_date'];
												$data=date("Y-m-d");
												if($empdetail['end_date']<=$data){
													if($empdetail['report_gen']==1){
													?>
													<a class="mr-10" href="<?php echo BASE_URL; ?>/index/ass_position_emp?ass_type=ASS&ass_id=<?php echo $empdetail['assessment_id']; ?>&pos_id=<?php echo $empdetail['position_id']; ?>&emp_id=<?php echo $empid; ?>" target="_blank"data-original-title="Download Report" data-toggle="tooltip">
													<button class="btn btn-primary btn-icon-anim btn-circle  btn-sm"><i class="fa fa-download"></i></button>
													</a>
													<?php
													}
													else{
													?>
													<a class="mr-10" href="<?php echo BASE_URL; ?>/index/ass_position_emp?ass_type=ASS&ass_id=<?php echo $empdetail['assessment_id']; ?>&pos_id=<?php echo $empdetail['position_id']; ?>&emp_id=<?php echo $empid; ?>" target="_blank" data-original-title="View Report" data-toggle="tooltip">
													<button class="btn btn-success btn-icon-anim btn-circle  btn-sm"><i class="fa fa-eye"></i></button>
													</a>
													<?php	
													}
												}
												else{
												?>
												<button class="btn btn-danger btn-icon-anim btn-circle" data-original-title="Report Pending" data-toggle="tooltip"><i class="fa fa-times"></i></button>
												<?php
												}
												?>
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