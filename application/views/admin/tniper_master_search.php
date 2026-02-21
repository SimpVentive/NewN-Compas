<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark">TNI Percentage Master </h6>
					</div>
					<div class="pull-right">
						<a href="<?php echo BASE_URL;?>/admin/tniper_master" class="btn btn-primary btn-sm">&nbsp <i class="fa fa-plus-circle"></i> Create TNI Percentage &nbsp </a>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-body">
					<form action="" id="loginForm" class="searchForm" method="get">
						<div class="row">
							<div class="col-md-3">						
								<div class="form-group col-lg-12">
									<label class="control-label mb-10 text-left">Percentage</label>
									<input value="<?php echo @$tni_percentage; ?>" id="tni_percentage" class="form-control" name="tni_percentage" type="text">
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
				<div class="hpanel">
					<div class="panel-body">
						<div class="table-wrap">
							<div class="table-responsive">
								<div id="edit_datable_2_wrapper" class="dataTables_wrapper">
									<table cellpadding="1" cellspacing="1" id="edit_datable_2" class="table table-hover table-bordered mb-0">
										<thead>
											<tr>
												<th class="col-sm-6">Percentage</th>
												<th class="col-sm-2">Status</th>
												<th class="col-sm-2">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($searchresults as $val){ ?>
											<tr class="tooltip-demo" id="leveldel_<?php echo $val['tni_per_id']; ?>" >
												<td><?php echo @$val['tni_percentage']; ?></td>
												<td><?php echo @$val['rating_status']; ?></td>
												<td>
													<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" id="<?php echo $val['tni_per_id']; ?>" name="deletetniper" rel="leveldel_<?php echo $val['tni_per_id']; ?>" onclick="deletefunction(this)"><i class="fa fa-trash text-danger"></i> </a>
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