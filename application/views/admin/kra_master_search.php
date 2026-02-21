<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					
					<div class="pull-left">
						<h6 class="panel-title txt-dark">KRA Master</h6>
					</div>	
					<div class="pull-right">
						<a href="<?php echo BASE_URL;?>/admin/kra_master" class="btn btn-primary btn-xs pull-left mr-15">&nbsp <i class="fa fa-plus-circle"></i> Create KRA Master &nbsp </a>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="hpanel">
					<div class="panel-body">
						<div class="table-wrap">
							<div class="table-responsive">
								<div id="edit_datable_2_wrapper" class="dataTables_wrapper">
									<table cellpadding="1" cellspacing="1" id="edit_datable_2" class="table table-hover table-bordered mb-0">
									<thead>
										<tr>
											<th class="col-sm-8">KRA Name</th>
											<th class="col-sm-2">Status</th>
											<th class="col-sm-2">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										if(count($searchresults)>0){
										foreach($searchresults as $val){ ?>
										<tr class="tooltip-demo" id="leveldel_<?php echo $val['kra_master_id']; ?>" >
											<td><?php
											if(strlen($val['kra_master_name'])<=30){echo substr($val['kra_master_name'],0, 30);}else{ echo substr($val['kra_master_name'],0, 30).'...';}
											?></td>
											<td><?php echo @$val['status']; ?></td>
											<td>
												<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="<?php echo BASE_URL;?>/admin/kra_view?kra_master_id=<?php echo @$val['kra_master_id'];?>&hash=<?php echo md5(SECRET.$val['kra_master_id']);?>"><i class="fa fa-eye text-success"></i> </a>
												<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Update" href="<?php echo BASE_URL;?>/admin/kra_master?kra_master_id=<?php echo @$val['kra_master_id'];?>&hash=<?php echo md5(SECRET.$val['kra_master_id']);?>"><i class="fa fa-pencil text-primary"></i> </a>
												<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" id="<?php echo $val['kra_master_id']; ?>" name="kralevel" rel="leveldel_<?php echo $val['kra_master_id']; ?>" onclick="deletefunction(this)"><i class="fa fa-trash text-danger"></i> </a>
											</td>
										</tr>
										<?php }
										}
										else{
										?>
										<tr>
											<td colspan="4">No Records found.</td>
										</tr>
										<?php
										}
										?>
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