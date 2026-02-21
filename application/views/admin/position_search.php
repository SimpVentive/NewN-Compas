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
						<h6 class="panel-title txt-dark">Create Position</h6>
					</div>
					<div class="pull-right">
						<a href="#" onClick="create_link('compareposition')" class="btn btn-primary btn-xs pull-left mr-15">&nbsp <i class="fa fa-plus-circle"></i> Compare Position &nbsp </a>
						<a href="#" onClick="create_link('position_update?eve_stat')" class="btn btn-primary btn-xs pull-left mr-15">&nbsp <i class="fa fa-plus-circle"></i> Create Position &nbsp </a>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-body">
					<form action="" method="get">
						
						<div class="row">
							<!--<div class="col-md-2">								
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
							</div>-->
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
												<th class="col-sm-3">Position Name</th>
												<th class="col-sm-1">Type</th>
												<th class="col-sm-1">Location</th>
												<th class="col-sm-3"></th>
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
												<td><a href="<?php echo BASE_URL."/admin/position_view?posid=".$position['position_id']."&hash=".md5($hash);?>"><?php echo $position['position_name'];?></a></td>
												<td><?php echo $position['position_type'];?></td>
												<td><?php echo $position['loc_name'];?></td>
												<td>
												<?php 
												//&& !empty($position['specific_experience']) && !empty($position['responsibilities'])
												$profile=(!empty($position['position_desc']) && !empty($position['experience'])  && !empty($position['accountablities']) )?"success":"danger"; 
												$c_profile=!empty($position['conp_profile'])?"success":"danger"; 
												$kra=!empty($position['kra'])?"success":"danger";
												?>
												<span class="label label-<?php echo $profile; ?>">Job Description</span>
												<span class="label label-<?php echo $c_profile; ?>">Competency Profile</span>
												<span class="label label-<?php echo $kra; ?>">KRA's</span>
												</td>
												<td><?php echo $position['value_name'];?></td>
												<td>
													<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Position JD PDF" href="<?php echo BASE_URL."/admin/positionpdf?posid=".$position['position_id']."&hash=".md5($hash);?>" target="_blank"><i class="fa fa-file-pdf-o text-info"></i> <span class="bold"></span></a>
													<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Position Competencies PDF" href="<?php echo BASE_URL."/admin/positionprofilepdf?posid=".$position['position_id']."&hash=".md5($hash);?>" target="_blank"><i class="fa fa-file-pdf-o text-info "></i> <span class="bold"></span></a>
													<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="<?php echo BASE_URL."/admin/position_view?posid=".$position['position_id']."&hash=".md5($hash);?>"><i class="fa fa-eye text-success"></i> <span class="bold"></span></a>
													<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Position Versioning" href="<?php echo BASE_URL."/admin/position_update?eve_stat&var=1&posid=".$position['position_id']."&hash=".md5($hash);?>"><i class="fa fa-shopping-bag text-info"></i> <span class="bold"></span></a>
													<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Position Duplicate" href="<?php echo BASE_URL."/admin/position_update_clone?posid=".$position['position_id']."&hash=".md5($hash);?>"><i class="fa fa-pencil text-info"></i> <span class="bold"></span></a>
													<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Update" href="<?php echo BASE_URL."/admin/position_update?eve_stat&posid=".$position['position_id']."&hash=".md5($hash);?>"><i class="fa fa-pencil text-primary"></i> </a>
													<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" id="<?php echo $position['position_id']; ?>" name="deleteposition" rel="pposition<?php echo $position['position_id']; ?>" onclick="deletefunction(this)"><i class="fa fa-trash text-danger"></i> <span class="bold"></span></a>
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
<div id="dialog-confirm" class="hide">
		<div class="alert alert-info bigger-110">
			Do you want to Delete this Position ?.
		</div>

		<div class="space-6"></div>

		<p class="bigger-110 bolder center grey">
			<i class="ace-icon fa fa-hand-o-right blue bigger-120"></i>
			Are you sure?
		</p>
	</div>
	
	<div id="dialog-confirm-delete" class="hide">
		<div class="alert alert-info bigger-110">
			Selected Position cannot be deleted. Ensure you delete all the usages of the Position before you delete it.
		</div>

		<div class="space-6"></div>
		
	</div>