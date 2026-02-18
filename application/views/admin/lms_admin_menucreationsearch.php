<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-inverse card-view">
				<div class="panel-heading">
					Menu Creation
					<div class="pull-right">
						<a href="#" onClick="create_link('create_menus')" class="btn btn-primary btn-sm">&nbsp <i class="fa fa-plus-circle"></i> Create  &nbsp </a>
					</div>
				</div>
				<div class="panel-body">
					<form action="#" id="loginForm">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group col-lg-6">
								<label>Role</label>
								<select class="chosen-select  form-control m-b" name="menu_type" id="menu_type">
									<option value=''>Select</option>
									<?php foreach($actor_types as $actor_type){ $sel=($actor_type->type==$menu_type) ? "selected=selected":""; ?>
									<option <?php echo $sel; ?> value="<?php echo $actor_type->type; ?>"><?php echo $actor_type->name; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group col-lg-6">
								<label>Menu Name</label>
								<input name="menu_name" id="menu_name" value="<?php echo isset($menu_name)? $menu_name:""; ?>"class="form-control" type="text">
							</div>
						</div>
						<div class="form-group col-md-1">
							<div class="text-left">
								<label>&nbsp;</label>
								<button type="submit" id="submit" class="btn btn-primary btn-sm">Search</button>
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
												<th>Menu Name</th>
												<th>Role</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										<?php
										if(count($menuss)>0){
											foreach($menuss as $key=>$menu1){ 
												$hash=SECRET.$menu1['menu_creation_id'];
												$key1=$key+1;?>
												<tr id="mmenu_<?php echo $menu1['menu_creation_id']; ?>">
													<td><?php echo $menu1['menu_name']; ?></td>
													<td><?php echo $menu1['actor']; ?></td>
													<td>
														<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="<?php echo BASE_URL."/admin/viewmenu?id=".$menu1['menu_creation_id']."&hash=".md5($hash);?>"><i class="fa fa-eye"></i></a>
														<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Update" href="<?php echo BASE_URL."/admin/create_menus?id=".$menu1['menu_creation_id']."&hash=".md5($hash);?>"><i class="fa fa-pencil"></i></a>
														<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" id="<?php echo $menu1['menu_creation_id']; ?>" name="deletemenu" rel="mmenu_<?php echo $menu1['menu_creation_id']; ?>" onclick="deletefunction(this)"><i class="fa fa-trash"></i></a>
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
<div class="modal fade hmodal-danger" id="dialog-confirm" class="hide" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="alert alert-info bigger-110">
		Do you want to Delete this Menu ?.
	</div>

	<div class="space-6"></div>

	<p class="bigger-110 bolder center grey">
		<i class="ace-icon fa fa-hand-o-right blue bigger-120"></i>
		Are you sure?
	</p>
</div>

<div id="dialog-confirm-delete" class="hide">
	<div class="alert alert-info bigger-110">
		Ensure the Menu is not used in any Role before you delete it. 
		Ensure you delete all the usages of the Menu before you delete it.
		You cannot delete this Menu as an Role is currently using it
	</div>

	<div class="space-6"></div>
	
</div>