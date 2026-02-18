<style>
.hpanel .panel-body {
    background: #fff none repeat scroll 0 0;
    border: 1px solid #eaeaea;
    border-radius: 2px;
    max-height: 145px;
    padding: 20px;
    position: relative;
}
</style>
<div class="">
	<div class="font-bold m-b-sm">
		<?php echo $position['position_name']; ?> Employees
	</div>
	<div class="panel panel-inverse card-view">

		<?php foreach($employees as $employee){ $photo=!empty($employee['photo'])?BASE_URL."/public/uploads/profile_pic/".$employee['employee_id'].'/'.$employee['photo']:BASE_URL."/public/images/male_user.jpg";?>
		<div class="col-md-2">
			<div class="panel panel-inverse card-view">
				<div class="panel-body text-center">
					<img alt="logo" class="img-circle img-small" src="<?php echo $photo; ?>">
					<div class="m-t-sm">
						<strong><?php echo $employee['full_name']; ?></strong>
						<p class="small" style="font-size: 75%;"><?php echo $employee['position_name']; ?></p>
						
					</div>
				</div>
				<div class="panel-footer contact-footer">
					<div class="row">
						<div class="col-md-6 border-right"> <div class="contact-stat"><strong><a onclick="getemployeedetails(<?php echo $employee['employee_id']; ?>)"><button class="btn btn-warning btn-xs">Profile</button></a></strong></div> </div>
						<div class="col-md-6 border-right"> <div class="contact-stat"><strong><a onclick="self_getemployeeassessment(<?php echo $employee['position_id']; ?>,<?php echo $employee['employee_id']; ?>,<?php echo $assessment_id; ?>)"><button class="btn btn-info btn-xs">Final </button></a></strong></div> </div>
						
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
<div class="row">
<div id='employeedetails'>

</div>
</div>
