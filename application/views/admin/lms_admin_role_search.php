<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-inverse card-view">
				<div class="panel-heading">
					Role Creation
					<div class="pull-right">
						<a href="#" onClick="create_link('create_role')" class="btn btn-primary btn-sm">&nbsp <i class="fa fa-plus-circle"></i> Create Role &nbsp </a>
					</div>
				</div>
				<div class="panel-body">
					<form action="#" id="loginForm">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group col-lg-6">
									<label>Role Name</label>
									<input type="text" name="role_name" id="role_name" value="<?php echo isset($rolen)? $rolen:""; ?>" class="form-control" >
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
				<div class="panel panel-inverse card-view">
					<div class="panel-body">
						<div class="table-wrap">
							<div class="table-responsive">
								<div id="edit_datable_2_wrapper" class="dataTables_wrapper">
									<table cellpadding="1" cellspacing="1" id="edit_datable_2" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>Role Name</th>
												<th>Organization Name</th>
												<th>Start Date</th>
												<th>End Date</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										<?php
										if(count($roless)>0){
											foreach($roless as $key=>$role){ $key1=$key+1;
											$hash=SECRET.$role['role_id'];
												?>
												<tr id="rrole_<?php echo $role['role_id']; ?>">
													<td><?php echo $role['role_name'];?></td>
													<td><?php echo $role['org_name'];?></td>	
													<td><?php echo $role['start_date'];?></td>
													<td><?php echo $role['end_date'];?></td>
													<td>
														<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="<?php echo BASE_URL."/admin/role_view?id=".$role['role_id']."&hash=".md5($hash);?>"><i class="fa fa-eye"></i></a>
														<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Update" href="<?php echo BASE_URL."/admin/create_role?id=".$role['role_id']."&hash=".md5($hash);?>"><i class="fa fa-pencil"></i></a>
														<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" id="<?php echo $role['role_id']; ?>" name="deleterole" rel="rrole_<?php echo $role['role_id']; ?>" href="#" onclick="deletefunction(this)"><i class="fa fa-trash"></i></a>
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
		Do you want to Delete this Role ?.
	</div>
	<div class="space-6"></div>
	<p class="bigger-110 bolder center grey">
		<i class="ace-icon fa fa-hand-o-right blue bigger-120"></i>
		Are you sure?
	</p>
</div>

<div id="dialog-confirm-delete" class="hide">
	<div class="alert alert-info bigger-110">
		Ensure the Role is not attached to any user before you delete it. 
		Ensure you delete all the usages of the Menu before you delete it.
		You cannot delete this Menu as an Role is currently using it
	</div>
	<div class="space-6"></div>	
</div>