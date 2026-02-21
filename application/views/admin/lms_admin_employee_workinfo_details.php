<form role="form" action="<?php echo BASE_URL;?>/admin/emp_work_details" method="post">
	<div class="row">
		<div class="col-sm-12">

			<?php $key=1;
			foreach($view_details as $last_wrk_det){
				$supervisors_data=UlsEmployeeMaster::fetch_super_details($last_wrk_det['employee_id']);
				?>
			<input type="hidden" name="work_info_id" id="work_info_id" value="<?php echo (isset($last_wrk_det['work_info_id']))?$last_wrk_det['work_info_id']:''?>">
			<input type="hidden" name="employee_id" id="employee_id" value="<?php echo (isset($last_wrk_det['employee_id']))?$last_wrk_det['employee_id']:''?>">
			<input type="hidden" name="work_id[]" id="work_id" value="<?php echo (isset($last_wrk_det['work_info_id']))?$last_wrk_det['work_info_id']:''?>">
			<input type="hidden" name="from_date[]" id="from_date<?php echo $key;?>" value="<?php echo date('d-m-Y',strtotime($last_wrk_det['from_date']));?>" >
			<div class="col-sm-12">
				<div class="form-group col-lg-6">
					<label>Business Unit:</label>
					<select name="business_unit[]" id="business_unit" class="form-control m-b validate[required]">
						<option value="0">Select</option>
					<?php 	foreach($business_units as $bu){
								$org_sel=(isset($last_wrk_det['bu_id']))?($last_wrk_det['bu_id']==$bu['id'])?"selected='selected'":'':''?>
								<option value="<?php echo $bu['id'];?>" <?php echo $org_sel;?>><?php echo $bu['name'];?></option>
					<?php 	}?>
					</select>
				</div>
				<div class="form-group col-lg-6">
					<label>Division</label>
					<select name="division_id[]" id="division_id" class="form-control m-b validate[required]">
						<option value="0">Select</option>
					<?php 	foreach($division_detail as $dd){
								$org_sel=(isset($last_wrk_det['division_id']))?($last_wrk_det['division_id']==$dd['id'])?"selected='selected'":'':''?>
								<option value="<?php echo $dd['id'];?>" <?php echo $org_sel;?>><?php echo $dd['name'];?></option>
					<?php 	}?>
					</select>
				</div>



				<div class="form-group col-lg-6">
					<label>Parent Department</label>
					<select name="parent_dep_id[]" id="parent_dep_id" class="form-control m-b validate[required]">
						<option value="0">Select</option>
					<?php 	foreach($parent_depart as $pd){
								$org_sel=(isset($last_wrk_det['parent_dep_id']))?($last_wrk_det['parent_dep_id']==$pd['id'])?"selected='selected'":'':''?>
								<option value="<?php echo $pd['id'];?>" <?php echo $org_sel;?>><?php echo $pd['name'];?></option>
					<?php 	}?>
					</select>
				</div>

				<div class="form-group col-lg-6">
					<label>Position</label>
					<select class='form-control m-b' name="position[]" id="position[<?php echo $key;?>]" onclick="check_org(<?php echo $key;?>)">
						<option value="">Select</option>
						<?php

							foreach($positions as $emp_position){
								$pos_sel=(isset($last_wrk_det['position_id']))?($last_wrk_det['position_id']==$emp_position['position_id'])?"selected='selected'":'':''?>
								<option value="<?php echo $emp_position['position_id'];?>" <?php echo $pos_sel;?>><?php echo $emp_position['position_name'];?></option>
					<?php	}?>
					</select>
				</div>

				<div class="form-group col-lg-6">
					<label>Zones</label>
					<select class='form-control m-b' name="zones_name[]" id="zones_name[<?php echo $key;?>]" onchange="zones_change(<?php echo $key;?>)">
						<option value="">Select</option>
						<?php
						foreach($zonestatus as $zonestatuss){
							$zone_sel=(isset($last_wrk_det['zone_id']))?($last_wrk_det['zone_id']==$zonestatuss['zone_id'])?"selected='selected'":'':'';
						?>
						<option value="<?php echo $zonestatuss['zone_id']; ?>" <?php echo $zone_sel; ?>><?php echo $zonestatuss['zone_name']; ?></option>
						<?php
						}
						?>
					</select>
				</div>
				<div class="form-group col-lg-6">
					<label>States</label><div id='statenames<?php echo $key;?>'>
					<select class='form-control m-b' name="state_id[]" id="state_id[<?php echo $key;?>]" onchange="open_location_state(<?php echo $key;?>)">
						<option value="">Select</option>
						<?php
						foreach($states as $state){
						$sate_sel=(isset($last_wrk_det['state_id']))?($last_wrk_det['state_id']==$state['state_id'])?"selected='selected'":'':'';
						?>
						<option value="<?php echo $state['state_id']; ?>" <?php echo $sate_sel; ?>><?php echo $state['state_name']; ?></option>
						<?php
						}
						?>
					</select></div>
				</div>
				<div class="form-group col-lg-6">
					<label>Location</label><div id='locationnames<?php echo $key;?>'>
					<select class='form-control m-b' name="location[]" id="location[<?php echo $key;?>]" onclick="check_org(<?php echo $key;?>)">
						<option value="">Select</option>
						<?php
						foreach($location as $locations){
							$loc_sel=(isset($last_wrk_det['location_id']))?($last_wrk_det['location_id']==$locations['location_id'])?"selected='selected'":'':'';
						?>
						<option value="<?php echo $locations['location_id']; ?>" <?php echo $loc_sel; ?>><?php echo $locations['location_name']; ?></option>
						<?php
						}
						?>
					</select>
					</div>
				</div>

				<div class="form-group col-lg-6">
					<label>Manager</label>
					<select class='form-control m-b' name="manager[]" id="manager[<?php echo $key;?>]" onclick="check_org(<?php echo $key;?>)">
						<option value="">Select</option>
					</select>
				</div>


				<div class="form-group col-lg-6">
					<label> Grade</label>
					<select class='form-control m-b' name="grade[]" id="grade[<?php echo $key;?>]" onclick="grade_change(<?php echo $key;?>)">
						<option value="">Select</option>
					<?php 	foreach($emp_grade as $emp_grad){
								$grd_sel=(isset($last_wrk_det['grade_id']))?($last_wrk_det['grade_id']==$emp_grad->grade_id)?"selected='selected'":'':''?>
								<option value="<?php echo $emp_grad->grade_id;?>" <?php echo $grd_sel;?>><?php echo $emp_grad->grade_name;?></option>
					<?php 	}?>
					</select>
				</div>
				<div class="form-group col-lg-6">
					<label>Sub Grade</label><div id="subgradediv<?php echo $key;?>">
					<select class='form-control m-b' name="sub_grade[]" id="sub_grade[<?php echo $key;?>]">
						<option value="">Select</option>
					<?php 	foreach($sub_grade as $sub_grades){
								$grd_sel=(isset($last_wrk_det['sub_grade_id']))?($last_wrk_det['sub_grade_id']==$sub_grades['sub_grade_id'])?"selected='selected'":'':''?>
								<option value="<?php echo $sub_grades['sub_grade_id'];?>" <?php echo $grd_sel;?>><?php echo $sub_grades['sub_name'];?></option>
					<?php 	}?>
					</select></div>
				</div>

				<div class="form-group col-lg-6">
					<label>Payroll</label>
					<input type="text" class='form-control' name="payroll[]" id="payroll[<?php echo $key;?>]" value="<?php echo (isset($last_wrk_det['payroll']))?$last_wrk_det['payroll']:''?>" >
				</div>

				<div class="form-group col-lg-6">
					<label>Net Salary</label>
					<input type="text" class='form-control' name="net[]" id="net[<?php echo $key;?>]" value="<?php echo (isset($last_wrk_det['net_salary']))?$last_wrk_det['net_salary']:''?>" maxlength='9'>
				</div>
				<div class="form-group col-lg-6">
					<label>Gross Salary</label>
					<input type="text" class='form-control' name="gross[]" id="gross" value="<?php echo (isset($last_wrk_det['gross_salary']))?$last_wrk_det['gross_salary']:''?>" maxlength='9'>
				</div>
				<div class="form-group col-lg-6">
					<label>Total CTC</label>
					<input type="text" class='form-control' name="ctc[]" id="ctc" value="<?php echo (isset($last_wrk_det['total_ctc']))?$last_wrk_det['total_ctc']:''?>" maxlength='9'>
				</div>

				<div class="form-group col-lg-6">
					<label> Supervisor</label>
					<select class='supervisor form-control m-b chosen-select' name="supervisor[]" id="supervisor_1" onclick="check_org(<?php echo $key;?>)">
						<option value="">Select</option>
				<?php 	if(count($supervisors_data)>0){
							foreach($supervisors_data as $supervisor){
								$sup_sel=(isset($last_wrk_det['supervisor_id']))?($last_wrk_det['supervisor_id']==$supervisor['employee_id'])?"selected='selected'":'':'';
								echo "<option value='".$supervisor['employee_id']."' $sup_sel >".$supervisor['employee_number']." ".$supervisor['full_name']."</option>";
							}
						}   ?>
					</select>
				</div>
			</div>
			<div class="page-header">
				&nbsp;
			</div><!-- /.page-header -->
			<script>

			</script>
			<?php } ?>



		</div>
		&nbsp;
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" name="submit_user" id="submit_user" class="btn btn-primary btn-sm">Save changes</button>
	</div>
</form>
