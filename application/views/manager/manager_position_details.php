<div class="content">
	<div class="row projects">
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				<div class="hpanel">
					<div class="panel-body">
						<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1">
						<thead>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Category Name</th>
								<th><?php  echo $validation['position_validation_name'];?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Category Start Date</th>
								<th><?php echo date("d-m-Y",strtotime($validation['start_date']));?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Category End Date</th>
								<th><?php echo date("d-m-Y",strtotime($validation['end_date']));?>&nbsp;</th>
							</tr>
							
						</thead>
					</table>					
					<div class="hr-line-dashed"></div>	
						<div class="table-wrap mt-20">
							<div class="table-responsive">
								<div id="edit_datable_2_wrapper" class="dataTables_wrapper">
									
									<table cellpadding="1" cellspacing="1" id="edit_datable_2" class="table table-hover table-bordered mb-0">
										<thead>
											<tr>
												<th>Position Name</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										<?php 
										foreach($pos_assessments as $assessment){
										?>
										<tr>
											<td><?php echo $assessment['position_name']; ?></td>
											<td>
											
											<a data-toggle="tooltip" data-placement="top" title="" data-original-title="Assessments" href="<?php echo BASE_URL; ?>/manager/manager_validation_details?status=information&val_id=<?php echo $_REQUEST['val_id']; ?>&pos_id=<?php echo $assessment['pos_id']; ?>" class="btn btn-info btn-xs pull-left mr-15">View</a>
											
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



