<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-inverse card-view">
				<div class="panel-heading">
					Organization Hierarchy 
					<div class="pull-right">
						<a href="#" onClick="create_link('org_hierarchy')" class="btn btn-primary btn-sm">&nbsp <i class="fa fa-plus-circle"></i> Add Organization Hierarchy &nbsp </a>
					</div>
				</div>
				<div class="panel-body">
					<form action="#" id="loginForm" class="searchForm">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group col-lg-12">
									<label>Hierarchy Name</label>
									<input name="hierarchy" id="hierarchy" value="<?php echo isset($hierarchy)?$hierarchy:''; ?>" class="form-control" type="text">
								</div>
							</div>
							<div class="form-group col-md-1">
								<div class="text-left">
									<label>&nbsp;</label>
									<button class="btn btn-primary btn-sm">Search</button>
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
											<th class="col-sm-4">Hierarchy Name</th>
											<th class="col-sm-3">Start Date</th>
											<th class="col-sm-3 hidden-480">End Date</th>
											<th class="col-sm-2">Action</th>
										</tr>
									</thead>
									<tbody>
									<?php
									if(count($masterlists)>0){
										$t=1;
										foreach($masterlists as $key=>$masters){
											$keys=$key+1;
											$hierarchy_id=$masters->hierarchy_id;
											$hash=SECRET.$hierarchy_id;
									?>
									<tr class="tooltip-demo" id="hierarchy_row_<?php echo $keys;?>">
										<td><?php echo $masters->hierarchy_name;?></td>
										<td><?php echo ($masters->start_date!=Null)?date('d-m-Y',strtotime($masters->start_date)):'';?></td>
										<td class="hidden-480"><?php echo ($masters['end_date']!=Null)?date('d-m-Y',strtotime($masters->end_date)):'';?></td>
										<td>
											<a title='View' data-toggle="tooltip" data-placement="top" data-original-title="View" class="mr-10" href="<?php echo BASE_URL?>/admin/org_hierarchy_view?hier_id=<?php echo $hierarchy_id?>&parentid=<?php echo $masters->parent_org_id;?>"><i class="fa fa-upload"></i> View</a>
											<a title='Update' data-toggle="tooltip" data-placement="top" data-original-title="Update" class="mr-10" href="<?php echo BASE_URL?>/admin/org_hierarchy?hier_id=<?php echo $hierarchy_id?>&parentid=<?php echo $masters->parent_org_id;?>"><i class="fa fa-paste"></i> Update</a>									
											<a title='Delete' data-toggle="tooltip" data-placement="top" data-original-title="Delete" class="mr-10" id="<?php echo $hierarchy_id; ?>" name="delete_hierarchy" rel="hierarchy_row_<?php echo $keys; ?>" onclick="deletefunction(this)"><i class="fa fa-trash-o"></i> Delete</a>
										</td>
									</tr>
									<?php $t++; } } else{ echo "<td colspan='4' class='nodata'>No Data Found</td>"; } ?>
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
<div id="dialog-confirm" class="hide">
	<div class="alert alert-info bigger-110">
		Do you want to Delete this Hierarchy ?
	</div>
	<div class="space-6"></div>
	<p class="bigger-110 bolder center grey">
		<i class="ace-icon fa fa-hand-o-right blue bigger-120"></i>
		Are you sure?
	</p>
</div>

<div id="dialog-confirm-delete" class="hide">
	<div class="alert alert-info bigger-110">
		Ensure the Hierarchy is not used in the application before deleting it
	</div>
	<div class="space-6"></div>	
</div>