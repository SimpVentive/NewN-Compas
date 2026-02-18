<section class="main-section">
	<div class="container">
		<div class="row">
			<!-- TEST SECTION :BEGIN -->
			<div class="test-section">
				<!-- TEST HEAD SECTION :BEGIN -->
				<div class="test-head-section">
					<div class="d-flex align-items-center justify-content-between">
						<div class="test-head">
							<div class="icon material-icons">supervised_user_circle</div>
							<div class="test-info">
								<div class="test-name">Skill evaluation  - Employees</div>
							</div>
						</div>
						
					</div>
				</div>
				<!-- TEST HEAD SECTION :END -->

				<div class="report-view-section custom-scroll">
					<div class="report-view-block">
						<table class="idp-report-table table-bordered table" style="width:1050px">
							<tr>
								<th colspan="5" class="report-title">Skill evaluation</th>
							</tr>
							<tr>
								<th class="report-sub-title" colspan="1">Employee Name</th>
								<th class="report-sub-title">level</th>
								<th class="report-sub-title">Position Name</th>
								<th class="report-sub-title">Test Status</th>
								<th class="report-sub-title">Action</th>
							</tr>

							<?php 
							foreach($sup_emp as $key=>$sup_emps){
							?>
							<tr>
								<td>
									<span class="number"><?php echo $key+1; ?></span>
									<span class="name"><?php echo $sup_emps['employee_number']."-".$sup_emps['full_name'];?></span>
								</td>
								<td><?php 
								if($sup_emps['skill_type']==1){
									echo "Level 2";
								}
								elseif($sup_emps['skill_type']==2){
									echo "Level 3";
								}
								elseif($sup_emps['skill_type']==3){
									echo "Level 4";
								}
								else{
									echo "Not Mapped";
								}
								?></td>
								<td><?php echo $sup_emps['position_name'];?></td>
								<td><?php echo ($sup_emps['attempt_status']=='COM')?"Completed":"";?></td>
								<td>
								<?php 
								if(empty($sup_emps['emp_result'])){
								?>
								<a href="<?php echo BASE_URL; ?>/manager/employee_skill_evaluation_details?type=1&emp_id=<?php echo $sup_emps['employee_id']; ?>&ass_id=<?php echo $sup_emps['assessment_id']; ?>&pos_id=<?php echo $sup_emps['pos_id']; ?>&atest_id=<?php echo $sup_emps['event_id']; ?>&stype=<?php echo $sup_emps['skill_type']; ?>" class="btn btn-primary">Skill</a>
								<?php 
								}
								else{
								?>
								<a href="#" class="btn btn-primary">Completed</a>
								<?php
								}
								?>
								</td>
							</tr>
							<?php } ?>
						</table>
						<div class="space-20"></div>
					</div>
				</div>
				
			</div>
			<!-- TEST SECTION :END -->
		</div>
	</div>
</section>
