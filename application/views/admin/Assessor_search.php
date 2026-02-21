<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Create Assessors</h6>
					</div>
					<div class="pull-right">
						<a href="<?php echo BASE_URL;?>/admin/assessor_master" class="btn btn-primary btn-xs pull-left mr-15">&nbsp <i class="fa fa-plus-circle"></i> Create Assessors&nbsp </a>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-body">
					<form action="" id="loginForm" class="searchForm" method="get">
						<div class="row">
							<div class="col-md-3">						
								<div class="form-group col-lg-12">
									<label class="control-label mb-10 text-left">Assessors Name</label>
									<input value="<?php echo @$assessors; ?>" id="assessors" class="form-control" name="assessors" type="text">
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
				<div class="panel panel-inverse card-view">
					<div class="panel-body">
						<div class="table-wrap">
						<h6 class="txt-dark capitalize-font">Search Results</h6>
						<hr class="light-grey-hr">
							<div class="table-responsive">
								<div id="edit_datable_2_wrapper" class="dataTables_wrapper">
									<table cellpadding="1" cellspacing="1" id="edit_datable_2" class="table table-hover table-bordered mb-0">
										<thead>
										<tr>
											<th class="col-sm-3">Assessors Name</th>
											<th class="col-sm-3">Email</th>
											<th class="col-sm-2">Assessor Type</th>
											<th class="col-sm-2">Status</th>
											<th class="col-sm-2">Action</th>
										</tr>
										</thead>
										<tbody>
											<?php foreach($searchresults as $val){ ?>
											<tr class="tooltip-demo" id="casedel_<?php echo $val['assessor_id']; ?>">
												<td><?php echo @$val['assessor_name']; ?></td>
												<td><?php echo @$val['assessor_email']; ?></td>
												<td><?php echo @$val['assesstype']; ?></td>
												<td><?php echo @$val['assessstatus']; ?></td>
												<td>
													<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="<?php echo BASE_URL;?>/admin/assessor_view?id=<?php echo @$val['assessor_id'];?>"><i class="fa fa-eye text-success"></i> </a>
													<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Update" href="<?php echo BASE_URL;?>/admin/assessor_master?status&id=<?php echo @$val['assessor_id'];?>"><i class="fa fa-pencil text-primary"></i> </a>
													<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" id="<?php echo $val['assessor_id']; ?>" name="deleteassessor" rel="casedel_<?php echo $val['assessor_id']; ?>" onclick="deletefunction(this)"><i class="fa fa-trash text-danger"></i> </a>
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