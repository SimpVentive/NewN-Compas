<style>
.col-lg-2 {
    width: 20%;
}
</style>
<div class="row">
	<div class="col-lg-2 col-md-6 col-sm-12 col-xs-12">
		<a href="<?php echo BASE_URL; ?>/admin/skill_dashboard">
		<div class="panel panel-default card-view pa-0">
			<div class="panel-wrapper collapse in">
				<div class="panel-body pa-0">
					<div class="sm-data-box">
						<div class="container-fluid">
							<div class="row">
								<div class="col-xs-10 text-center pl-0 pr-0 data-wrap-left">
									<span class="txt-dark block counter font-15"><span class="">Skill Dashbaord</span></span>
								</div>
								<div class="col-xs-2 text-center  pl-0 pr-0 data-wrap-right">
									<i class="icon-layers data-right-rep-icon txt-light-grey"></i>
								</div>
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>
		</a>
	</div>
	<div class="col-lg-2 col-md-6 col-sm-12 col-xs-12">
		<a href="<?php echo BASE_URL; ?>/admin/dashboard">
		<div class="panel panel-default card-view pa-0">
			<div class="panel-wrapper collapse in">
				<div class="panel-body pa-0">
					<div class="sm-data-box">
						<div class="container-fluid">
							<div class="row">
								<div class="col-xs-10 text-center pl-0 pr-0 data-wrap-left">
									<span class="txt-dark block counter font-15" ><span class="">Over All Dashbaord</span></span>
								</div>
								<div class="col-xs-2 text-center  pl-0 pr-0 data-wrap-right">
									<i class="icon-layers data-right-rep-icon txt-light-grey"></i>
								</div>
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>
		</a>
	</div>
	<div class="col-lg-2 col-md-6 col-sm-12 col-xs-12">
		<a href="<?php echo BASE_URL; ?>/admin/assessment_dashboard">
		<div class="panel panel-default card-view pa-0">
			<div class="panel-wrapper collapse in">
				<div class="panel-body pa-0">
					<div class="sm-data-box">
						<div class="container-fluid">
							<div class="row">
								<div class="col-xs-10 text-center pl-0 pr-0 data-wrap-left">
									<span class="txt-dark block counter font-15"><span class="">Assessment Dashbaord</span></span>
								</div>
								<div class="col-xs-2 text-center  pl-0 pr-0 data-wrap-right">
									<i class="icon-layers data-right-rep-icon txt-light-grey"></i>
								</div>
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>
		</a>
	</div>
	<div class="col-lg-2 col-md-6 col-sm-12 col-xs-12">
		<a href="<?php echo BASE_URL; ?>/admin/hr_dashboard">
		<div class="panel panel-default card-view pa-0">
			<div class="panel-wrapper collapse in">
				<div class="panel-body pa-0">
					<div class="sm-data-box">
						<div class="container-fluid">
							<div class="row">
								<div class="col-xs-10 text-center pl-0 pr-0 data-wrap-left">
									<span class="txt-dark block counter font-15"><span class="">HR Dashboard</span></span>
								</div>
								<div class="col-xs-2 text-center  pl-0 pr-0 data-wrap-right">
									<i class="icon-layers data-right-rep-icon txt-light-grey"></i>
								</div>
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>
		</a>
	</div>
	<div class="col-lg-2 col-md-6 col-sm-12 col-xs-12">
		<a href="<?php echo BASE_URL; ?>/admin/assessor_dashboard">
		<div class="panel panel-default card-view pa-0">
			<div class="panel-wrapper collapse in">
				<div class="panel-body pa-0">
					<div class="sm-data-box">
						<div class="container-fluid">
							<div class="row">
								<div class="col-xs-10 text-center pl-0 pr-0 data-wrap-left">
									<span class="txt-dark block counter font-15"><span class="">Assessor Dashbaord</span></span>
								</div>
								<div class="col-xs-2 text-center  pl-0 pr-0 data-wrap-right">
									<i class="icon-layers data-right-rep-icon txt-light-grey"></i>
								</div>
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>
		</a>
	</div>
	
</div>
	

<div class="row">
   <div class="col-lg-12">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark">Skill Data</h6>
				</div>
				
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div  class="panel-body">
					<div class="clearfix"></div>
					<div class="table-wrap">
						<div class="table-responsive">
							<table class="table table-bordered display mb-30" >
								<thead>
									<tr>
										<th rowspan="3">S.No</th>
										<th rowspan="3">Employee Number</th>
										<th rowspan="3">Employee Name</th>
										<!--<th rowspan="4">Department</th>-->
										<th colspan="10">Process</th>
									</tr>
									<tr>
										<th>Reactor Cleaning </th>
										<th>Motor Working</th>
										<th>Charging Operations</th>
										<th>Temperature Controls</th>
										<th>Filtration</th>
										<th>In process Quality Checking</th>
										<th>Water Effluent Checking</th>
										<th>Discharge</th>
										<th>Bagging</th>
										<th>Final Product Quality Checking</th>
									</tr>
								</thead>
								<tbody>
								<?php 
								$image=array("skill1.png","skill2.png","skill3.png","skill4.png");
								
								foreach($emp_info as $key=>$emp_infos){
									
								?>
									<tr>
										<td><?php echo $key+1; ?></td>
										<td><?php echo $emp_infos['employee_number']; ?></td>
										<td><?php echo $emp_infos['full_name']; ?></td>
										<!--<td><?php echo $emp_infos['org_name']; ?></td>-->
										<?php
										for ($i=0; $i<=9; $i++){
											$rquote = array_rand($image);
											$aa=$image[$rquote];
										?>
										<td><img src="<?php echo BASE_URL; ?>/public/home/images/<?php echo $aa; ?>"/></td>
										<?php 
										}?>
									</tr>
								<?php } ?>
								</tbody>
								
							</table>
						</div>
					</div>	
					<div class="table-wrap">
						<div class="table-responsive">
							<table class="table table-bordered display mb-30" >
								<tr>
									<td><img src="<?php echo BASE_URL; ?>/public/home/images/<?php echo $image[0]; ?>"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Under Training</th>
									<td><img src="<?php echo BASE_URL; ?>/public/home/images/<?php echo $image[1]; ?>"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Trained. Can work under supervision.</th>
									<td><img src="<?php echo BASE_URL; ?>/public/home/images/<?php echo $image[2]; ?>"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Can work Independently</th>
									<td><img src="<?php echo BASE_URL; ?>/public/home/images/<?php echo $image[3]; ?>"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Skilled can train others</th>
								</tr>
							</table>
						</div>
					</div>			
								
				</div>
			</div>
		</div>	
	</div>
</div>
		