<script>
function create_loc(){
	window.location="<?php echo BASE_URL;?>/admin/location";	
}

function locget_search(){
	window.location="<?php echo BASE_URL;?>/admin/location_search";	
}
</script>
<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Create Location</h6>
					</div>
					<div class="pull-right">
						
						<a onClick="create_link('location_creation')" href="#" class="btn btn-primary btn-xs pull-left mr-15">&nbsp <i class="fa fa-plus-circle"></i> Create Location &nbsp </a>
					</div>
					<div class="clearfix"></div>
				</div>
				
				<div class="panel-body">
					<form action="" method="get">
						<div class="row">
							<div class="col-md-3">						
								<div class="form-group col-lg-12">
									<label class="control-label mb-10 text-left">Location Name</label>
									<input value="<?php echo $locname;?>" id="locname" class="form-control" name="locname" type="text">
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
				<div class="panel panel-inverse card-view">
					<div class="panel-body">
						<h6 class="txt-dark capitalize-font">Search Results</h6>
						<hr class="light-grey-hr">
						<div class="table-wrap">
							<div class="table-responsive">
								<div id="edit_datable_2_wrapper" class="dataTables_wrapper">
									<table cellpadding="1" cellspacing="1" id="edit_datable_2" class="table table-hover table-bordered mb-0">
										<thead>
											<tr>
												<th class="col-sm-6">Location Name</th>
												<th class="col-sm-4">Status</th>
												<th class="col-sm-2">Action</th>
											</tr>
										</thead>
										<tbody>
										<?php
										if(count($locations)>0){
											foreach($locations as $location){
												$hash=SECRET.$location['location_id']; ?>
												<tr class="tooltip-demo" id="llocation_<?php echo $location['location_id']; ?>">
													<td><?php echo $location['location_name'];?></td>
													<td><?php echo $location['value_name'];?></td>
													<td>
														<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="<?php echo BASE_URL."/admin/location_view?locid=".$location['location_id']."&hash=".md5($hash);?>"><i class="fa fa-eye text-success"></i> <span class="bold"></span></a>
														<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Update" href="<?php echo BASE_URL."/admin/location_creation?locid=".$location['location_id']."&hash=".md5($hash);?>"><i class="fa fa-pencil text-primary"></i> </a>
														<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" id="<?php echo $location['location_id']; ?>" name="deletelocation" rel="llocation_<?php echo $location['location_id']; ?>" onclick="deletefunction(this)"><i class="fa fa-trash text-danger"></i> <span class="bold"></span></a>
													</td>
												</tr>
												<?php
											}
										}
										else{ ?>
										<tr>
											<td colspan="6" class="nodata">No Data Found</td>
										</tr>
										<?php } ?>
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
		Do you want to Delete this Location ?.
	</div>

	<div class="space-6"></div>

	<p class="bigger-110 bolder center grey">
		<i class="ace-icon fa fa-hand-o-right blue bigger-120"></i>
		Are you sure?
	</p>
</div>

<div id="dialog-confirm-delete" class="hide">
	<div class="alert alert-info bigger-110">
		Selected location cannot be deleted. Ensure you delete all the usages of the Location before you delete it.
	</div>

	<div class="space-6"></div>
	
</div>
