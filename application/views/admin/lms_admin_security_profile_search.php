<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-inverse card-view">
				<div class="panel-heading">
					Security Profile
					<div class="pull-right">
						<a href="#" onClick="create_link('security_profile')" class="btn btn-primary btn-sm">&nbsp <i class="fa fa-plus-circle"></i> Create  &nbsp </a>
					</div>
				</div>
				<div class="panel-body">
					<form action="#" id="loginForm">
						<div class="row">
							<div class="col-md-6">
								
								<div class="form-group col-lg-6">
									<label>Profile Name</label>
									<input type="text" name="prf_name" id="prf_name" value="<?php echo isset($prf_name)? $prf_name:''; ?>"  class="form-control" >
								</div>
							</div>
							<div class="form-group col-md-1">
								<div class="text-left">
									<label>&nbsp;</label>
									<button type="submit" class="btn btn-primary btn-sm" id="submit" >Search</button>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="hpanel">
					<div class="panel-body">
						<div class="table-wrap">
							<div class="table-responsive">
								<div id="edit_datable_2_wrapper" class="dataTables_wrapper">
									<table cellpadding="1" cellspacing="1" id="edit_datable_2" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>Profile Name</th>
												<th>Organization</th>
												<th>Status</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										<?php
										if(count($prfdetails)>0){
											foreach($prfdetails as $key=>$prfdetail){
												$profilename=$prfdetail['profile_name'];
												$org_name=$prfdetail['org_name'];
												$status=$prfdetail['value_name'];
												$empid=$prfdetail['secure_profile_id'];
												$hash=SECRET.$empid;
											?>
												<tr id='emp_row_<?php echo $key?>'>
													<td><?php echo ucwords(strtolower($profilename));?></td>
													<td><?php echo ucwords(strtolower($org_name));?></td>
													<td class="hidden-480"><?php echo ucwords(strtolower($status));?></td>
													<td>
														<!--<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="#"><i class="fa fa-eye"></i></a>-->
														<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Update" href="<?php echo BASE_URL?>/admin/security_profile?secure_id=<?php echo $empid?>&hash=<?php echo md5($hash);?>"><i class="fa fa-pencil"></i></a>
													</td>
												</tr>
											<?php
											}
										}else{ echo "<td colspan='4' class='nodata'>No Data Found</td>"; } ?>
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