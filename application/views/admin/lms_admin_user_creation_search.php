<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-inverse card-view">
				<div class="panel-heading">
					User Creation 
					<div class="pull-right">
						<a href="#" onClick="create_link('create_user')" class="btn btn-primary btn-sm">&nbsp <i class="fa fa-plus-circle"></i> Create User  &nbsp </a>
					</div>
				</div>
				<div class="panel-body">
					<form action="#" id="loginForm">
						<div class="row">
							<div class="col-md-6">								
								<div class="form-group col-lg-6">
									<label>User Name</label>
									<input type="text" name="username" id="username" value="<?php echo isset($username)? $username:""; ?>" class="form-control" >
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
												<th>User Name</th>
												<th>Validate Days</th>
												<th>Start Date</th>
												<th>End Date</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										<?php
										if(count($usercreations)>0){
											foreach($usercreations as $key=>$user_creations){
												$hash=SECRET.$user_creations->user_id;
												$key1=$key+1;?>
												<tr>
													<td><?php echo $user_creations->user_name; ?></td>
													<td><?php echo $user_creations->password_validity_days>0?$user_creations->password_validity_days:""; ?></td>
													<td><?php if($user_creations->start_date!=NULL){ echo date('d-m-Y',strtotime($user_creations->start_date)); } ?></td>
													<td><?php if($user_creations->end_date!=NULL){ echo date('d-m-Y',strtotime($user_creations->end_date)); } ?></td>
													<td>
														<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="<?php echo BASE_URL."/admin/user_view?id=".$user_creations->user_id."&hash=".md5($hash);?>"><i class="fa fa-eye"></i></a>
														<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Update" href="<?php echo BASE_URL; ?>/admin/create_user?id=<?php echo $user_creations->user_id."&hash=".md5($hash);?>"><i class="fa fa-pencil"></i></a>
													<!--	<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" name="deleterole"  href="#" onclick="deletefunction(this)"><i class="fa fa-trash"></i></a>-->
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