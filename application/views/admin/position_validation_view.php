<style>
.modal-header {
    background: #f7f9fa none repeat scroll 0 0;
    padding: 10px 0px;
}
</style>
<div class="content">
    <div class="row">
		<div class="col-lg-12">
            <div class="panel panel-inverse card-view">
                <div class="panel-body">
					<h3><?php echo @$compdetails['position_validation_name']; ?> <small>(<?php echo @$compdetails['val_status']; ?>)</small></h3>
					<div class="col-lg-12">
                        <p>
							<strong>Start Date</strong>:<?php echo @date("d-m-Y",strtotime($compdetails['start_date'])); ?>
						</p>
						<p>
							<strong>End Date</strong>:<?php echo @date("d-m-Y",strtotime($compdetails['end_date'])); ?>
						</p>
						
					</div>
					
					<h6>Positions For Corrections</h6>
					<div class="col-lg-12">
					<?php
					foreach($position_details as $position){ 
					?>
                        <p>
							<?php echo @$position['position_name']; ?>
						</p>
					<?php } ?>	
					</div>
					
				</div>
			</div>
		</div>

		<div class="col-lg-12">
			<div class="panel panel-inverse card-view">
				<?php
				if(!empty($position_details)){
				?>
				<ul class="nav nav-pills">
					<?php $j=0;
					
						foreach($position_details as $position){ 
						$class=($j==0)?"active":""; $j++;
						
						?>
						<li class="<?php echo $class; ?>"><a data-toggle="tab" href="#tab-<?php echo $position['position_id']; ?>"> <?php echo $position['position_name']; ?></a></li>
					<?php }
					
					?>
				</ul>
				<div class="tab-content">
						<?php $i=0; 
						foreach($position_details as $position){ 
							$classs=($i==0)?"active":""; $i++;
							$val_id=(isset($compdetails['val_id']))?$compdetails['val_id']:'';
							$emp_details=UlsValidationPositionEmployees::get_employees_position_view($val_id,$position['position_id'],$position['val_pos_id']);
						?>
						<div id="tab-<?php echo $position['position_id']; ?>" class="tab-pane <?php echo $classs; ?>">
							<div class="panel-body">
								
								<div class="table-responsive">
										<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
											<thead>
											<tr>
												<th class="col-sm-2">Employee Number</th>
												<th class="col-sm-3">Name</th>
												<th class="col-sm-2">Department</th>
												<th class="col-sm-3">Position</th>
												<th class="col-sm-2">Location</th>
											</tr>
											</thead>
											<tbody>
											<?php 
											foreach($emp_details as $key1=>$emp_detail){
												$key=$key1+1;
											?>
											<tr>
												<td><?php echo $emp_detail['employee_number']; ?></td>
												<td><?php echo $emp_detail['full_name']; ?></td>
												<td><?php echo $emp_detail['org_name']; ?></td>
												<td><?php echo $emp_detail['position_name']; ?></td>
												<td><?php echo $emp_detail['location_name']; ?></td>
											</tr>
											<?php
											}
											?>
											</tbody>
										</table>
									</div>
									
									
								
								<hr class="light-grey-hr">
								<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-account mr-10"></i>Employees from different position to validate this position </h6>
								<hr class="light-grey-hr">
								<div class="table-responsive">
									<table cellpadding="1" cellspacing="1" id="edit_datable_2" class="table table-hover table-bordered mb-0">
										<thead>
											<tr>
												<th class="col-sm-2">Employee Number</th>
												<th class="col-sm-3">Name</th>
												<th class="col-sm-2">Department</th>
												<th class="col-sm-3">Position</th>
												<th class="col-sm-2">Location</th>
											</tr>
										</thead>
										<tbody>
										<?php 
										$pos_emp=UlsValidationPositionEmployees::get_employees_position($val_id,$position['position_id'],$position['val_pos_id']);
										foreach($pos_emp as $pos_emps){
										?>
											<tr id="assessmentdel_<?php echo $pos_emps['val_pos_empid']; ?>">
												<td><?php echo $pos_emps['employee_number']; ?></td>
												<td><?php echo $pos_emps['full_name']; ?></td>
												<td><?php echo $pos_emps['org_name']; ?></td>
												<td><?php echo $pos_emps['position_name']; ?></td>
												<td><?php echo $pos_emps['location_name']; ?></td>
												
											</tr>
										<?php } ?>
										</tbody>
									</table>
								</div>
								<div class="clearfix mt-40"></div>
								<div class="col-sm-offset-7 col-sm-7">
									<a class="btn btn-info " href="<?php echo BASE_URL;?>/admin/position_validation_report?id=<?php echo $_REQUEST['id'] ?>&pos_id=<?php echo $position['position_id']; ?>&val_pos_id=<?php echo $position['val_pos_id'];?>" target="_blank">Generate Report For <?php echo $position['position_name']; ?></a>
								</div>
								
								<div class="clearfix mt-40"></div>
							</div>
						</div>
						
						<?php } ?>
					</div>
								
				<?php } ?>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-4">
				<button class="btn btn-primary btn-sm" type="button" onClick="create_link('position_validation_creation?eve_stat&id=<?php echo $compdetails['val_id']."&hash=".md5(SECRET.$compdetails['val_id']);?>')">Update</button>
				<button class="btn btn-primary btn-sm" type="button" onClick="create_link('position_validation_creation?eve_stat')">Create</button>
				<button class="btn btn-primary btn-sm" type="button" onClick="create_link('position_validation_search')">Cancel</button>
			</div>
		</div>
    </div>
</div>
