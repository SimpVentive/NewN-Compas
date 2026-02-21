<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Migration Master</h6>
					</div>	
					<div class="pull-right">
						<a href="<?php echo BASE_URL;?>/admin/migration_master" class="btn btn-primary btn-xs pull-left mr-15">&nbsp <i class="fa fa-plus-circle"></i> Create Migration Master &nbsp </a>
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
											<th class="col-sm-2">Migration Type</th>
											<th class="col-sm-2">Content Type</th>
											<th class="col-sm-4">Migration Name</th>
											<th class="col-sm-2">Status</th>
											<th class="col-sm-2">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										if(count($searchresults)>0){
										foreach($searchresults as $val){ ?>
										<tr class="tooltip-demo" id="leveldel_<?php echo $val['course_id']; ?>" >
											<td><?php echo $val['migrationtype'];?></td>
											<td><?php echo $val['type'];?></td>
											<td><?php echo $val['program_name'];?></td>
											<td><?php echo @$val['status_val']; ?></td>
											<td>
												<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="<?php echo BASE_URL;?>/admin/migration_view?course_id=<?php echo @$val['course_id'];?>&hash=<?php echo md5(SECRET.$val['course_id']);?>"><i class="fa fa-eye text-success"></i> </a>
												<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Update" href="<?php echo BASE_URL;?>/admin/migration_master?course_id=<?php echo @$val['course_id'];?>&hash=<?php echo md5(SECRET.$val['course_id']);?>"><i class="fa fa-pencil text-primary"></i> </a>
												<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" id="<?php echo $val['course_id']; ?>" name="kralevel" rel="leveldel_<?php echo $val['course_id']; ?>" onclick="deletefunction(this)"><i class="fa fa-trash text-danger"></i> </a>
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