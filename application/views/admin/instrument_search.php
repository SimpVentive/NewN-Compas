<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Instrument Master </h6>
					</div>
					
					<div class="clearfix"></div>
				</div>
				<div class="panel-body">
					
				</div>
				<div class="hpanel">
					<div class="panel-body">
						<div class="table-wrap">
							<div class="table-responsive">
								<div id="edit_datable_2_wrapper" class="dataTables_wrapper">
									<table cellpadding="1" cellspacing="1" id="edit_datable_2" class="table table-hover table-bordered mb-0">
										<thead>
											<tr>
												<th class="col-sm-8">Instrument Name</th>
												<th class="col-sm-2">Status</th>
												<th class="col-sm-2">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($searchresults as $val){ ?>
											<tr class="tooltip-demo" id="langdel_<?php echo $val['instrument_id']; ?>" >
												<td><?php echo $val['instrument_name']; ?></td>
												<td><?php echo $val['int_status']; ?></td>
												<td>
													<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="<?php echo BASE_URL;?>/admin/language_view?id=<?php echo @$val['instrument_id'];?>&hash=<?php echo md5(SECRET.$val['instrument_id']);?>"><i class="fa fa-eye text-success"></i> </a>
													<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Update" href="<?php echo BASE_URL;?>/admin/instrument_master?id=<?php echo @$val['instrument_id'];?>&hash=<?php echo md5(SECRET.$val['instrument_id']);?>"><i class="fa fa-pencil text-primary"></i> </a>
													
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