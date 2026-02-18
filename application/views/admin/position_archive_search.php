<style>
.col-sm-2 {
    width: 13.667%;
}
</style>
<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark">View Position Archive</h6>
					</div>
					
					<div class="clearfix"></div>
				</div>
				<div class="panel-body">
					<form action="" method="get">
						
						<div class="row">
							<div class="col-md-2">								
								<div class="form-group col-lg-12">
									<label class="control-label mb-10 text-left">Position Type</label>
									<select class=" form-control m-b" id="position_type" name="position_type" style="width: 100%">
										<option value="">Select</option>
										<?php 
										foreach($pos_types as $pos_type){
											$dep_sel=isset($position_type)?($position_type==$pos_type['code'])?"selected='selected'":"":"";
											?>
												<option value="<?php echo $pos_type['code'];?>" <?php echo $dep_sel; ?>><?php echo $pos_type['name'];?></option>
											<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-md-2">								
								<div class="form-group">
									<label class="control-label mb-10 text-left">Location</label>
									<select class=" form-control m-b" id="location" name="location" style="width: 100%">
										<option value="">Select</option>
										<?php 
										foreach($pos_locations as $pos_location){
											$dep_sel=isset($location)?($location==$pos_location['location_id'])?"selected='selected'":"":"";
											?>
												<option value="<?php echo $pos_location['location_id'];?>" <?php echo $dep_sel; ?>><?php echo $pos_location['location_name'];?></option>
											<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-md-3">								
								<div class="form-group">
									<label class="control-label mb-10 text-left">Department</label>
									<select class=" form-control m-b" id="department" name="department" style="width: 100%">
										<option value="">Select</option>
										<?php 
										foreach($departments as $department){
											$dep_sel=isset($depart)?($depart==$department['id'])?"selected='selected'":"":"";
											?>
												<option value="<?php echo $department['id'];?>" <?php echo $dep_sel; ?>><?php echo $department['name'];?></option>
											<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-md-3">								
								<div class="form-group">
									<label class="control-label mb-10 text-left">Position Name</label>
									<input name="pos_name" id="pos_name" value="<?php echo isset($pos_name)? $pos_name:""; ?>"  class="form-control" type="text">
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
				<div class="">
					<div class="panel-body">
						<h6 class="txt-dark capitalize-font">Search Results</h6>
						<hr class="light-grey-hr">
						<div class="table-wrap">
							<div class="table-responsive">
								<div id="edit_datable_2_wrapper" class="dataTables_wrapper">
									<table cellpadding="1" cellspacing="1" id="edit_datable_2" class="table table-hover table-bordered mb-0">
										<thead>
											<tr>
												<th class="col-sm-4">Position Name</th>
												<th class="col-sm-1">Version</th>
												<th class="col-sm-1">Type</th>
												<th class="col-sm-1">Location</th>
												<th class="col-sm-1">Status</th>
												<th class="col-sm-2">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php 
											if(count($positions)>0){
												foreach($positions as $position){
													$hash=SECRET.$position['position_id'];
											?>
											<tr class="tooltip-demo" id="pposition<?php echo $position['position_id']; ?>">
												<td><?php echo $position['position_name'];?></td>
												<td><?php echo (isset($position['version_id']))?"Version-".$position['version_id']:""; ?></td>
												<td><?php echo $position['position_type'];?></td>
												<td><?php echo $position['loc_name'];?></td>
												<td><?php echo $position['value_name'];?></td>
												<td>
													<a class="mr-10"  data-placement="top" title="" data-original-title="View" onclick="getposdet(<?php echo $position['position_id']; ?>)" style="cursor: pointer;" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-eye text-success"></i> <span class="bold"></span></a>
												</td>
											</tr>
											<?php } } else{ ?>
											<tr>
												<td colspan="5" class="nodata">No Search Found</td>
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
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h5 class="modal-title" id="myLargeModalLabel">Competency attached Positions</h5>
			</div>
			<div class="modal-body">
				<h5 class="mb-15" id="followdes">Following are the Positions</h5>
				<div id="txtHint" style="margin: 15px;">
				
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger text-left" data-dismiss="modal">Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>