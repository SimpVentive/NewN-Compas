<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Create Position Validation</h6>
					</div>
					<div class="pull-right">
						<a href="<?php echo BASE_URL;?>/admin/position_validation_creation?status" class="btn btn-primary btn-xs pull-left mr-15">&nbsp <i class="fa fa-plus-circle"></i> Create Position Validation &nbsp </a>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-body">
					<form action="" id="loginForm" class="searchForm" method="get">
						<div class="row">
							
							<div class="col-md-3">						
								<div class="form-group col-lg-12">
									<label class="control-label mb-10 text-left">Position Validation Name</label>
									<input value="<?php echo @$validation_name; ?>" id="validation_name" class="form-control" name="validation_name" type="text">
								</div>
							</div>
							<div class="form-group col-md-1">
								<div class="text-left">
									<label class="control-label mb-10 text-left">&nbsp;</label>
									<button class="btn btn-primary btn-sm">Search</button>
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
												<th>Position Validation Name</th>
												<th>Start Date</th>
												<th>End Date</th>
												<th>Status</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($searchresults as $val){
												$pos_employee_count=UlsValidationPositionEmployees::get_employees_position_count($val['val_id']);?>
											 <tr class="tooltip-demo" id="assessmentdel_<?php echo $val['val_id']; ?>">
												<td><?php echo @$val['position_validation_name'];?></td>
												<td><?php echo date("d-m-Y",strtotime($val['start_date']));?></td>
												<td><?php echo date("d-m-Y",strtotime($val['end_date']));?></td>
												<td><?php echo @$val['val_status'];?></td>
												<td>
												<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="<?php echo BASE_URL;?>/admin/position_validation_view?id=<?php echo @$val['val_id'];?>&hash=<?php echo md5(SECRET.$val['val_id']);?>"><i class="fa fa-eye text-success"></i> </a>
												<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Update" href="<?php echo BASE_URL;?>/admin/position_validation_creation?status&id=<?php echo @$val['val_id'];?>&hash=<?php echo md5(SECRET.$val['val_id']);?>"><i class="fa fa-edit text-primary"></i> </a>
												<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" id="<?php echo $val['val_id']; ?>" name="deleteassessment" rel="assessmentdel_<?php echo $val['val_id']; ?>" onclick="deletefunction(this)"><i class="fa fa-trash text-danger"></i> </a>
												<?php
												if($val['publish']!='P'){
													
													?>
													<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Publish" id="<?php echo $val['val_id']; ?>" name="publishposition" rel="assessmentdel_<?php echo $val['val_id']; ?>" onclick="publishfunction(this)"><i class="icon-rocket text-info"></i> </a>
													<?php 
													
												} ?>
												</td>
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
