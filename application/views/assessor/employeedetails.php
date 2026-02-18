<div class="row">
<div class="col-lg-12">
	<div class="panel panel-inverse card-view">
		<div class="font-bold m-b-sm">
			<h5 class="txt-dark">Professional Profile</h5>
		</div>
		<hr class="light-grey-hr">
		<div class="panel-body" style="max-height:160px;">
			<div class="col-lg-2">
			<?php 
			$pic_path=BASE_URL.'/public/images/male_user.jpg';if(isset($userdetails['employee_id'])){ $pic_path=(!empty($userdetails['photo']))?BASE_URL.'/public/uploads/profile_pic/'.trim($userdetails['employee_id']).'/'.trim($userdetails['photo']):(($userdetails['gender']=='M')?BASE_URL.'/public/images/male_user.jpg':BASE_URL.'/public/images/female_img.jpg'); } ?>
			<img alt="logo" class="img-square m-b m-t-md" src="<?php echo $pic_path; ?>">
			</div>
			<div class="col-lg-3">
			<h6><?php echo $userdetails['full_name']; ?></h6>
			<p><?php echo $userdetails['position_name']; ?>, <?php echo $userdetails['org_name']; ?></p>
			<p>Employee Number: <?php echo $userdetails['employee_number']; ?></p>
			<p>Grade: <?php echo $userdetails['grade_name']; ?></p>
			</div>
			<div class="col-lg-3">
				<p><i class="fa fa-birthday-cake"></i> <?php echo date("d F Y",strtotime($userdetails['date_of_birth'])); ?></p>
				<p><i class="fa fa-calendar"></i> Date Hired on: <?php echo date("d F Y",strtotime($userdetails['date_of_joining'])); ?></p>
				<p><i class="fa fa-mortar-board"></i> <?php echo $userdetails['qualification']; ?></p>
				<p><i class="fa fa-user"></i> Experience: <?php echo $userdetails['expericence']; ?></p>
				<p>Reports to: <?php echo $userdetails['hod']; ?></p>
			</div>
			<div class="col-lg-4">
				<p><i class="fa fa-phone"></i> <?php echo $userdetails['office_number']; ?></p>
				<p><i class="fa fa-envelope"></i> <?php echo $userdetails['email']; ?></p>
				<p><i class="fa fa-map-marker"></i> <?php echo $userdetails['location_name']; ?></p>
			</div>
		</div>		
		<div class="panel-body">
			<dl>
				<dt>Additional Info</dt>
				<dd><?php echo @$userdetails['description']; ?></dd>
			</dl>
		</div>

	</div>
</div>
</div>