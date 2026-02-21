<div class="content">
	<div class="row projects">
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				<div class="hpanel">
					<div class="panel-body">
						
						<div class="table-wrap mt-20">
							<div class="table-responsive">
								<div id="edit_datable_2_wrapper" class="dataTables_wrapper">
									
									<table cellpadding="1" cellspacing="1" id="edit_datable_2" class="table table-hover table-bordered mb-0">
										<thead>
											<tr>
												<th>Validation Name</th>
												<th>Start Date</th>
												<th>End Date</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										<?php 
										foreach($assessments as $assessment){
										?>
										<tr>
											<td><?php echo $assessment['position_validation_name']; ?></td>
											<td><?php echo date("d-m-Y",strtotime($assessment['start_date'])); ?></td>
											<td><?php echo date("d-m-Y",strtotime($assessment['end_date'])); ?></td>
											<td>
											<?php 
											$date=date("Y-m-d");
											if($assessment['end_date']<$date){
											?>
											<a class="btn btn-danger btn-xs pull-left mr-15">Closed</a>
											<?php
											}
											else{
											?>
											<a data-toggle="tooltip" data-placement="top" title="" data-original-title="Assessments" href="<?php echo BASE_URL; ?>/manager/manager_position_details?val_id=<?php echo $assessment['val_id']; ?>" class="btn btn-info btn-xs pull-left mr-15">View</a>
											<?php } ?>
											
											</td>
										</tr>
										<?php
										}
										?>


										
										</tbody>
									</table>
									<div class="clearfix mt-20"></div>
								</div>
								
							</div>
							
						</div>
						
					</div>
				</div>
			</div>
		</div>
		
	</div>
</div>



