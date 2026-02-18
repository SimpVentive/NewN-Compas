<style>
.col-lg-21 {
    width: 20%;
}
</style>
<div class="content">

	
	<div class="row">
		<?php
		$anchorcom="onclick='getasesstotal(\"\")'  style='color:blue;cursor: pointer;' data-toggle='modal' data-target='.bs-example-modal-lg'";
		?>
		<div class="col-lg-2 col-md-6 col-sm-6 col-xs-12" <?php echo $anchorcom; ?>>
			<div class="panel panel-default card-view pa-0">
				<div class="panel-wrapper collapse in">
					<div class="panel-body pa-0">
						<div class="sm-data-box">
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
										<span class="txt-dark block counter"><span class=""><?php echo $total_emp['total_emp']; ?></span></span>
										<span class="weight-500 uppercase-font block font-13">Total Employees</span>
									</div>
									
								</div>	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-2 col-md-6 col-sm-6 col-xs-12" onclick='getasesscompt("")'  style='color:blue;cursor: pointer;' data-toggle='modal' data-target='.bs-example-modal-lg'>
			<div class="panel panel-default card-view pa-0">
				<div class="panel-wrapper collapse in">
					<div class="panel-body pa-0">
						<div class="sm-data-box">
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
										<span class="txt-dark block counter"><span class=""><?php echo $total_cemp['total_cemp']; ?></span></span>
										<span class="weight-500 uppercase-font block font-13"># Completed Employees</span>
									</div>
									
								</div>	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-2 col-md-6 col-sm-6 col-xs-12" onclick='getasesspend("")'  style='color:blue;cursor: pointer;' data-toggle='modal' data-target='.bs-example-modal-lg'>
			<div class="panel panel-default card-view pa-0">
				<div class="panel-wrapper collapse in">
					<div class="panel-body pa-0">
						<div class="sm-data-box">
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
										<span class="txt-dark block counter"><span class=""><?php echo ($total_emp['total_emp'])-($total_cemp['total_cemp']); ?></span></span>
										<span class="weight-500 uppercase-font block font-13"># Pending Employees</span>
									</div>
									
								</div>	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-2 col-md-6 col-sm-6 col-xs-12" onclick='getassessor_details()'  style='color:blue;cursor: pointer;' data-toggle='modal' data-target='.bs-example-modal-lg'>
			<div class="panel panel-default card-view pa-0">
				<div class="panel-wrapper collapse in">
					<div class="panel-body pa-0">
						<div class="sm-data-box">
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
										<span class="txt-dark block counter"><span class=""><?php echo $assessor_count['assessor_count']; ?></span></span>
										<span class="weight-500 uppercase-font block"># of Assessors</span>
									</div>
									
								</div>	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--<div class="col-lg-2 col-md-6 col-sm-6 col-xs-12" onclick='getassessor_assessed()'  style='color:blue;cursor: pointer;' data-toggle='modal' data-target='.bs-example-modal-lg'>
			<div class="panel panel-default card-view pa-0">
				<div class="panel-wrapper collapse in">
					<div class="panel-body pa-0">
						<div class="sm-data-box">
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
										<span class="txt-dark block counter"><span class=""><?php echo $assd_emp['assd_emp']; ?></span></span>
										<span class="weight-500 uppercase-font block"># Assessed Emloyees</span>
									</div>
									
								</div>	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-2 col-md-6 col-sm-6 col-xs-12" onclick='getassessor_pen_assessed()'  style='color:blue;cursor: pointer;' data-toggle='modal' data-target='.bs-example-modal-lg'>
			<div class="panel panel-default card-view pa-0">
				<div class="panel-wrapper collapse in">
					<div class="panel-body pa-0">
						<div class="sm-data-box">
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
										<span class="txt-dark block counter"><span class=""><?php echo $total_cemp['total_cemp']-$assd_emp['assd_emp']; ?></span></span>
										<span class="weight-500 uppercase-font block"># Pending Employees to Assess</span>
									</div>
									
								</div>	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>-->
		
	</div>
	<!--<div class="row">
		<div class="col-lg-12">
			 <div class="panel panel-default card-view">
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Search Sector Wise</h6>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-wrapper collapse in">
				
					<div class="panel-body">
						<div class="col-md-12">
							
							<div class="col-lg-4">
								<div class="panel-heading">
									<div class="pull-left col-lg-3">
										<h6 class="panel-title txt-dark">Clusters:</h6>
									</div>
									<div class="pull-left">
										
										<select name="ass_sector" id="ass_sector" onchange="assessement_sector();" class="col-lg-12 form-control m-b">
											<option value=''>Select Clusters</option>
											<?php 
											foreach($ass_loc_names as $ass_loc_namess){
												$select=isset($_REQUEST['id'])?(($_REQUEST['id']==$ass_loc_namess['location_id'])?"selected='selected'":""):"";
											?>
											<option value='<?php echo $ass_loc_namess['location_id']; ?>' <?php echo $select; ?>><?php echo $ass_loc_namess['location_name']; ?></option>
											<?php
											}
											?>
										</select>
									</div>
									<div class="clearfix"></div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="panel-heading">
									<div class="pull-left col-lg-2">
										<h6 class="panel-title txt-dark">Area:</h6>
									</div>
									<div class="pull-left">
										
										<select name="ass_area" id="ass_area" onchange="assessement_area();" class="col-lg-12 form-control m-b">
											<option value=''>Select Area</option>
											<?php 
											foreach($ass_area_names as $ass_area_namess){
												$select=isset($_REQUEST['id'])?(($_REQUEST['aid']==$ass_area_namess['organization_id'])?"selected='selected'":""):"";
											?>
											<option value='<?php echo $ass_area_namess['organization_id']; ?>' <?php echo $select; ?>><?php echo $ass_area_namess['org_name']; ?></option>
											<?php
											}
											?>
										</select>
									</div>
									<div class="clearfix"></div>
								</div>
							</div>
							<div class="col-lg-2">
								<div class="panel-heading">
									<div class="pull-left col-lg-1">
										<h6 class="panel-title txt-dark"></h6>
									</div>
									<div class="pull-left">
										
										<a href="<?php echo BASE_URL; ?>/admin/agel_dashboard" class="btn btn-primary btn-sm" id="submit">Clear</a>
									</div>
									<div class="clearfix"></div>
								</div>
								
							</div>
						</div>
						
					</div>
				
				</div>
			</div>
		</div>
	</div>-->
	<?php 
	if(isset($_REQUEST['id'])){
	?>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					<div class="pull-left">
						<?php 
						$area_name="";
						if(!empty($_REQUEST['aid'])){
							$area_name=" Area - ".$ass_area_name_detail['org_name'];
						}
						$sec_name="Cluster Information - ".$ass_loc_name_detail['location_name'];
						
						?>
						<h6 class="panel-title txt-dark"><?php echo $sec_name; ?><?php echo $area_name; ?> </h6>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-wrapper collapse in">
					<div  class="panel-body">
						
						<?php
						$l_id=$_REQUEST['id'];
						$bu_id=!empty($_REQUEST['aid'])?$_REQUEST['aid']:"\"\"";
						$anchorcom="onclick='getasesstotalcluster(".$l_id.",".$bu_id.")'  style='color:blue;cursor: pointer;' data-toggle='modal' data-target='.bs-example-modal-lg'";
						?>
						<div class="col-lg-2 col-md-6 col-sm-6 col-xs-12" <?php echo $anchorcom; ?>>
							<div class="panel panel-default card-view pa-0">
								<div class="panel-wrapper collapse in">
									<div class="panel-body pa-0">
										<div class="sm-data-box">
											<div class="container-fluid">
												<div class="row">
													<div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
														<span class="txt-dark block counter"><span class=""><?php echo $total_emp_cluster['total_emp']; ?></span></span>
														<span class="weight-500 uppercase-font block font-13">Total Employees</span>
													</div>
													
												</div>	
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-6 col-sm-6 col-xs-12" onclick='getasesscomptcluster(<?php echo $l_id;?>,<?php echo $bu_id;?>)'  style='color:blue;cursor: pointer;' data-toggle='modal' data-target='.bs-example-modal-lg'>
							<div class="panel panel-default card-view pa-0">
								<div class="panel-wrapper collapse in">
									<div class="panel-body pa-0">
										<div class="sm-data-box">
											<div class="container-fluid">
												<div class="row">
													<div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
														<span class="txt-dark block counter"><span class=""><?php echo $total_cemp_cluster['total_cemp']; ?></span></span>
														<span class="weight-500 uppercase-font block font-13"># Completed Employees</span>
													</div>
													
												</div>	
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-6 col-sm-6 col-xs-12" onclick='getasesspendcluster(<?php echo $l_id;?>,<?php echo $bu_id;?>)'  style='color:blue;cursor: pointer;' data-toggle='modal' data-target='.bs-example-modal-lg'>
							<div class="panel panel-default card-view pa-0">
								<div class="panel-wrapper collapse in">
									<div class="panel-body pa-0">
										<div class="sm-data-box">
											<div class="container-fluid">
												<div class="row">
													<div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
														<span class="txt-dark block counter"><span class=""><?php echo ($total_emp_cluster['total_emp'])-($total_cemp_cluster['total_cemp']); ?></span></span>
														<span class="weight-500 uppercase-font block font-13"># Pending Employees</span>
													</div>
													
												</div>	
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-6 col-sm-6 col-xs-12" onclick='getassessor_details_cluster(<?php echo $l_id;?>,<?php echo $bu_id;?>)'  style='color:blue;cursor: pointer;' data-toggle='modal' data-target='.bs-example-modal-lg'>
							<div class="panel panel-default card-view pa-0">
								<div class="panel-wrapper collapse in">
									<div class="panel-body pa-0">
										<div class="sm-data-box">
											<div class="container-fluid">
												<div class="row">
													<div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
														<span class="txt-dark block counter"><span class=""><?php echo $assessor_count_cluster['assessor_count']; ?></span></span>
														<span class="weight-500 uppercase-font block"># of Assessors</span>
													</div>
													
												</div>	
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-6 col-sm-6 col-xs-12" onclick='getassessor_assessed_cluster(<?php echo $l_id;?>,<?php echo $bu_id;?>)'  style='color:blue;cursor: pointer;' data-toggle='modal' data-target='.bs-example-modal-lg'>
							<div class="panel panel-default card-view pa-0">
								<div class="panel-wrapper collapse in">
									<div class="panel-body pa-0">
										<div class="sm-data-box">
											<div class="container-fluid">
												<div class="row">
													<div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
														<span class="txt-dark block counter"><span class=""><?php echo $assd_emp_cluster['assd_emp']; ?></span></span>
														<span class="weight-500 uppercase-font block"># Assessed Emloyees</span>
													</div>
													
												</div>	
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-lg-2 col-md-6 col-sm-6 col-xs-12" onclick='getassessor_pen_assessed_cluster(<?php echo $l_id;?>,<?php echo $bu_id;?>)'  style='color:blue;cursor: pointer;' data-toggle='modal' data-target='.bs-example-modal-lg'>
							<div class="panel panel-default card-view pa-0">
								<div class="panel-wrapper collapse in">
									<div class="panel-body pa-0">
										<div class="sm-data-box">
											<div class="container-fluid">
												<div class="row">
													<div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
														<span class="txt-dark block counter"><span class=""><?php echo $total_cemp_cluster['total_cemp']-$assd_emp_cluster['assd_emp']; ?></span></span>
														<span class="weight-500 uppercase-font block"># Pending Employees to Assess</span>
													</div>
													
												</div>	
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php 
	}
	?>
	<?php
	$cluster_info="";
	if(!empty($_REQUEST['id'])){
		$area_name="";
		$loca_name=UlsLocation::getloc($_REQUEST['id']);
		if(!empty($_REQUEST['b_id'])){
			$areaname=UlsMenu::callpdorow("SELECT `organization_id`,`org_name` FROM `uls_organization_master` where organization_id=".$_REQUEST['b_id']);
			$area_name=" - Area:".$areaname['org_name'];
		}
		$cluster_info=" - Cluster:".$loca_name['location_name']." ".$area_name."";
	}
	?>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					<div class="pull-left">
						
						<h6 class="panel-title txt-dark">Assessment information Location wise <?php echo $cluster_info; ?></h6>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-wrapper collapse in">
					<div  class="panel-body">
						<div id="owl_demo_new" class="owl-carousel owl-theme">
						<?php
						foreach($loc_names as $loc_name){
							
							$total_emp_loc=UlsMenu::callpdorow("SELECT count(distinct(a.employee_id)) as loc_total_emp FROM `uls_assessment_employees` a left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) b on a.assessment_id=b.assessment_id WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and b.ass_methods='Y' and b.assessment_status='A' and a.location_id=".$loc_name['location_id']);
							
							/* $comp_emp_loc=UlsMenu::callpdorow("SELECT count(distinct(a.employee_id)) as loc_total_emp FROM `uls_assessment_employees` a left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) b on a.assessment_id=b.assessment_id WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and b.ass_methods='Y' and a.status='C' and b.assessment_status='A' and a.location_id=".$loc_name['location_id']); */
							
							$comp_emp_loc=UlsMenu::callpdorow("SELECT count(distinct(a.employee_id)) as loc_total_emp FROM `uls_utest_attempts_assessment` a 
							left join(SELECT `assessment_id`,`position_id`,`employee_id`,`location_id` FROM `uls_assessment_employees`) e on e.assessment_id=a.assessment_id and a.employee_id=e.employee_id
							left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) b on a.assessment_id=b.assessment_id WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and b.ass_methods='Y' and a.status='A' and b.assessment_status='A' and e.location_id=".$loc_name['location_id']);
							
							$ass_emp_loc=UlsMenu::callpdorow("SELECT count(distinct(a.employee_id)) as ass_emp_loc FROM `uls_assessment_report_final` a
							left join(SELECT `employee_id`,`location_id` FROM `uls_assessment_employees`) b on b.employee_id=a.employee_id
							WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and b.location_id=".$loc_name['location_id']);
							$report_emp_loc=UlsMenu::callpdorow("SELECT count(distinct(employee_id)) as report_total_emp FROM `uls_assessment_employees` WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and report_gen=1 and location_id=".$loc_name['location_id']);
						?>
						
							<div class="item">
								
								<div class="panel panel-default card-view">
									<div class="panel-heading">
										<div class="pull-left">
											<h6 class="panel-title txt-dark"><?php echo $loc_name['location_name'];?></h6>
										</div>
										
										<div class="clearfix"></div>
									</div>
									<div class="panel-wrapper collapse in">
										<div class="panel-body">
											<b class="txt-dark">Assessment Information</b>
											<hr>
											<div>
												<a href="#" onclick="getasesstotal(<?php echo $loc_name['location_id'];?>);" style='color:blue;cursor: pointer;' data-toggle='modal' data-target='.bs-example-modal-lg'>
												<span># of Employees</span>
												<span class="label label-warning pull-right font-15"><?php echo $total_emp_loc['loc_total_emp']; ?></span>
												</a>
												<div class="clearfix"></div>
												<hr class="light-grey-hr row mt-10 mb-10">
												<a href="#" onclick="getasesscompt(<?php echo $loc_name['location_id'];?>);" style='color:blue;cursor: pointer;' data-toggle='modal' data-target='.bs-example-modal-lg'>
												<span># Emp taken</span>
												<span class="label label-primary pull-right font-15"><?php echo $comp_emp_loc['loc_total_emp']; ?></span>
												</a>
												<div class="clearfix"></div>
												<hr class="light-grey-hr row mt-10 mb-10">
												<a href="#" onclick="getasesspend(<?php echo $loc_name['location_id'];?>);" style='color:blue;cursor: pointer;' data-toggle='modal' data-target='.bs-example-modal-lg'>
												<span># Pending Emps</span>
												<span class="label label-success pull-right font-15"><?php echo $total_emp_loc['loc_total_emp']-$comp_emp_loc['loc_total_emp']; ?></span>
												</a>
												<div class="clearfix  row mt-10 mb-10"></div>
											</div>
											
										</div>	
									</div>
								</div>
							</div>
						
						<?php 
						}
						?>
						</div>
						<script>
						jQuery(document).ready(function($) {
							$('#owl_demo_new').owlCarousel({
								margin:20,
								nav:true,
								autoplay:true,
								responsive:{
									0:{
										items:1
									},
									380:{
										items:2
									},
									680:{
										items:4
									},
									1000:{
										items:8
									},
									
								}
							});
						});
						</script>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
   <div class="col-lg-12">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark">Assessor Locations <?php echo $cluster_info; ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div  class="panel-body">
					<div class="">
						<?php 
						if(count($loc_details)>0){
						?>
						<div id="owl_demo_2" class="owl-carousel owl-theme">
							<?php 
							foreach($loc_details as $loc_detail){
								$ass_count=UlsMenu::callpdorow("SELECT count(DISTINCT(a.`assessor_id`)) as ass_count FROM `uls_assessment_position_assessor` a
								left join(SELECT `assessor_id`,`employee_id`,`assessor_name`,assessor_type FROM `uls_assessor_master`) b on b.assessor_id=a.assessor_id
								left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) d on a.assessment_id=d.assessment_id
								left join(SELECT `employee_id`,`employee_number`,`full_name`,`location_id` FROM `employee_data`) c on c.employee_id=b.employee_id
								WHERE 1 and d.assessment_status='A' and b.assessor_type='INT' and c.location_id=".$loc_detail['location_id']);
							?>
							<a onclick="open_location_assessor(<?php echo $loc_detail['location_id'];?>);" style="cursor: pointer;">
							<div class="item">
								<div class="panel panel-default card-view hbggreen">
									<div class="panel-body">
										<div class="text-center">
											<h6><?php echo $loc_detail['location_name']; ?></h6>
											<div class="progress progress-xs mb-0 ">
												<div style="width:100%" class="progress-bar progress-bar-primary"></div>
											</div>
											<span class="font-12 head-font txt-dark" >Total no of Assessor are 
												<span class="font-20 block counter txt-dark"><span class="" ><?php echo $ass_count['ass_count']; ?></span></span></span>
										</div>
									</div>
								</div>
							</div>
							</a>
							<?php
							}
							?>
						</div>
						<?php
						}
						else{
						?>
						<div class="alert alert-danger alert-dismissable">
											
								<i class="zmdi zmdi-block pr-15 pull-left"></i><p class="pull-left">Opps! No assessors mapped to this cluster/Area.</p>
								<div class="clearfix"></div>
							</div>
						<?php
						}
						?>
					 </div>
				</div>
			</div>
		</div>	
	</div>
</div>
<div id="result_data">
<div class="row">
   <div class="col-lg-12">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark">Assessors <?php echo $cluster_info; ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div  class="panel-body">
					<div class="">
						<?php
						if(count($ass_int)>0){
						?>
						<div id="owl_demo_4" class="owl-carousel owl-theme">
							<?php 
							
							foreach($ass_int as $key=>$ass_ints){
								$lid=!empty($_REQUEST['id'])?$_REQUEST['id']:"''";
								$aid=!empty($_REQUEST['aid'])?$_REQUEST['aid']:"''";
							?>
							
							<div class="item">
								<a onclick="open_assessor_assessment_employees(<?php echo $ass_ints['location_id'];?>,<?php echo $ass_ints['assessor_id']; ?>,<?php echo $lid; ?>,<?php echo $aid; ?>);" style='cursor: pointer;'>
								<div class="panel panel-default card-view hbggreen">
									<div class="panel-body">
										<div class="text-center">
											<h6 class="font-11"><?php echo $ass_ints['assessor_name']; ?></h6>
											<div class="progress progress-xs mb-0 ">
												<div style="width:100%" class="progress-bar progress-bar-primary"></div>
											</div>
											<?php 
											$sq5="";
											$sq6="";
											$sq7="";
											if(!empty($_REQUEST['id'])){
											$ass_loc_name_detail=UlsMenu::callpdorow("SELECT `location_id`,`location_name` FROM `uls_location` where location_id=".$_REQUEST['id']);
											$ass_id=UlsMenu::callpdorow("SELECT GROUP_CONCAT(DISTINCT(`assessment_id`)) as ass_ids FROM `uls_assessment_definition` WHERE ass_methods='Y' and assessment_status='A' and `location_id`=".$_REQUEST['id']);
											$sq5=" and a.assessment_id in (".$ass_id['ass_ids'].")";
											$locids = '';
											$loc_ids=UlsMenu::callpdo("SELECT b.`location_id`,b.`location_name` FROM `uls_assessment_employees` a 
											left join(SELECT `location_id`,`location_name` FROM `uls_location`) b on a.location_id=b.location_id
											WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." ".$sq5." group by a.location_id");
											foreach($loc_ids as $loc_idss){
												$locids.=$loc_idss['location_id'].',';
											}
											$locids = trim($locids, ',');
											
											$sq6=" and e.location_id in (".$locids.")";
											if(!empty($_REQUEST['aid'])){
												$sq7=" and e.bu_id=".$_REQUEST['aid']."";
											}
											}
											
											$assd_id=UlsMenu::callpdorow("SELECT GROUP_CONCAT(DISTINCT(a.`assessment_id`)) as ass_ids FROM `uls_assessment_position_assessor` a 
											left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) d on a.assessment_id=d.assessment_id
											WHERE a.`assessor_id`=".$ass_ints['assessor_id']." and d.assessment_status='A' ".$sq5."");
											$assm_id=$assd_id['ass_ids'];
											if(!empty($assm_id)){
											$ass_pos_count2=UlsMenu::callpdorow("SELECT group_concat(b.employee_id) as ass_counts FROM `uls_assessment_position_assessor` a
											left join(SELECT `employee_id`,`assessment_id`,`position_id` FROM `uls_assessment_employees`) b on a.assessment_id=b.assessment_id and a.position_id=b.position_id
											left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) d on a.assessment_id=d.assessment_id
											WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.assessment_id in (".$assm_id.") and a.assessor_id=".$ass_ints['assessor_id']." and d.assessment_status='A' and a.assessor_type='INT' and (a.assessor_per is NULL || a.assessor_per='N') group by a.assessment_id");
											
											$ass_pos_count1=UlsMenu::callpdorow("SELECT group_concat(emp_ids) as ass_count FROM `uls_assessment_position_assessor` WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and assessment_id in (".$assm_id.") and assessor_id=".$ass_ints['assessor_id']." and assessor_type='INT' and (assessor_per is NULL || assessor_per='Y') and emp_ids is not NULL");
											
											
											if(!empty($ass_pos_count2['ass_counts'])){
												if($ass_pos_count1['ass_count']!="NULL"){
													$yes_array=explode(',',$ass_pos_count1['ass_count']);
												}
												else{
													$yes_array=array();
												}
												$yes_array=explode(',',$ass_pos_count1['ass_count']);
												$no_array=explode(',',$ass_pos_count2['ass_counts']);
												$total_emp_ids=array_merge($no_array,$yes_array);
												/* echo "<pre>";
												print_r($total_emp_ids); */
											}
											else{
												$total_emp_ids=explode(',',$ass_pos_count1['ass_count']);
											}
											/* echo "<pre>";
											print_r(array_filter($total_emp_ids)); */
											$total_emp_id=array_unique(array_filter($total_emp_ids));
											
											$totalempid=implode(",",array_filter($total_emp_ids));
											$empidss=!empty($totalempid)? " and a.employee_id in ($totalempid)":"";
											
											$ass_comp_count=UlsMenu::callpdo("SELECT a.*,b.assessor_name,count(ar.ass_rating_id) as rating_ass FROM `uls_assessment_report_final` a
											left join(SELECT `ass_rating_id`,`assessment_id`,`position_id`,`employee_id`,`assessor_id` FROM `uls_assessment_assessor_rating`) ar on ar.assessment_id=a.assessment_id and ar.position_id=a.position_id and ar.employee_id=a.employee_id and ar.assessor_id=a.assessor_id
											left join(SELECT `assessment_id`,`position_id`,`employee_id`,`bu_id`,`location_id`,`status` FROM `uls_assessment_employees`) e on e.assessment_id=a.assessment_id and e.position_id=a.position_id and e.employee_id=a.employee_id
											left join(SELECT `assessor_id`,`assessor_name` FROM `uls_assessor_master`) b on b.assessor_id=a.assessor_id
											where a.`assessment_id` in (".$assm_id.") and a.assessor_id=".$ass_ints['assessor_id']." ".$empidss." ".$sq6." ".$sq7." group by a.employee_id");
											$comp_emp=count($ass_comp_count);
											//$total_emp_count=($ass_pos_count2['ass_counts']+count($yes_array));
											?>
											<!--<span class="font-10 head-font txt-dark" >Total no of Employees mapped 
												<span class="font-18 block counter txt-dark"><?php echo count($total_emp_id); ?></span></span>-->
											<span class="font-10 head-font txt-dark" >
												<span class="font-18 block counter txt-dark">&nbsp; </span></span>
											<div>
												<span class="pull-left inline-block capitalize-font txt-dark">
													Employees mapped
												</span>
												<span class="label label-warning pull-right font-16"><?php echo count($total_emp_id); ?></span>
												<div class="clearfix"></div>
												<hr class="light-grey-hr row mt-10 mb-10">
												<span class="pull-left inline-block capitalize-font txt-dark">
													Employees Pending
												</span>
												<span class="label label-danger pull-right font-16"><?php echo (count($total_emp_id)-$comp_emp); ?></span>
												
											</div>
											<?php 
											}
											?>
										</div>
									</div>
								</div>
								</a>
							</div>
							<?php 
							}
							
							?>
						</div>
						<?php 
						
						}
							else{
							?>
							<div class="alert alert-danger alert-dismissable">
											
								<i class="zmdi zmdi-block pr-15 pull-left"></i><p class="pull-left">Opps! No assessors mapped to this cluster/Area.</p>
								<div class="clearfix"></div>
							</div>
							<?php
							}
							?>
					 </div>
					 
				</div>
			</div>
		</div>	
	</div>
</div>
<div id="result_ass_data">
<!--<div class="row">
   <div class="col-lg-12">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark">Assessment Mapped</h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div  class="panel-body">
					<div class="">
						<div id="owl_demo_5" class="owl-carousel owl-theme">
							<?php 
							foreach($assessment_details as $assessment_detail){
								$emp_count=UlsMenu::callpdorow("SELECT count(distinct(a.`employee_id`)) as emp_count FROM `uls_assessment_employees` a
								WHERE 1 and a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.assessment_id=".$assessment_detail['assessment_id']);
							?>
							<div class="item">
								<a href="#" data-toggle="modal" data-target=".bs-example-modal-lg" >
								<div class="panel panel-default card-view hbggreen">
									<div class="panel-body">
										<div class="text-center">
											<h6><?php echo $assessment_detail['assessment_name'];?></h6>
											<div class="progress progress-xs mb-0 ">
												<div style="width:100%" class="progress-bar progress-bar-primary"></div>
											</div>
											<span class="font-12 head-font txt-dark" >Total no of Employees are 
												<span class="font-20 block counter txt-dark"><span class="counter-anim" ><?php echo $emp_count['emp_count']; ?></span></span></span>
										</div>
									</div>
								</div>
								</a>
								
							</div>
							<?php 
							}
							?>
						</div>
					</div>
					 
				</div>
			</div>
		</div>	
	</div>
</div>-->

<div id="result_assessment_data">
</div>
</div>
</div>
	
	
</div>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg" style="width:1400px">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h5 class="modal-title" id="myLargeModalLabel">Competency attached Positions</h5>
			</div>
			<div class="modal-body">
				<div id="txtHint" style="margin: 15px;">
				
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger text-left" data-dismiss="modal">Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>



<script>
function assessement_sector(){
	var id=document.getElementById('ass_sector').value;
	if(id!=''){
		location.href=BASE_URL+"/admin/agel_dashboard?id="+id;
	}
	
}

function assessement_area(){
	var id=document.getElementById('ass_sector').value;
	var aid=document.getElementById('ass_area').value;
	if(id==''){
		toastr.error("Please Select Cluster.");
		return false;
	}
	if(id!=''){
		var aid=document.getElementById('ass_area').value;
		location.href=BASE_URL+"/admin/agel_dashboard?id="+id+"&aid="+aid;
	}
}
function open_location_assessor(id){
	var xmlhttp;
	if (window.XMLHttpRequest){
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('result_data').innerHTML=xmlhttp.responseText;
			$('#owl_demo_4').owlCarousel({
				margin:20,
				nav:true,
				autoplay:true,
				responsive:{
					0:{
						items:1
					},
					280:{
						items:2
					},
					480:{
						items:4
					},
					800:{
						items:6
					},
					
					
				}
			});
			$('#owl_demo_5').owlCarousel({
				margin:20,
				nav:true,
				autoplay:true,
				responsive:{
					0:{
						items:1
					},
					280:{
						items:2
					},
					480:{
						items:4
					},
					800:{
						items:8
					},
					
				}
			});
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/assessor_location_details?loc_id="+id,true);
	xmlhttp.send();	
	
}

function open_assessor_assessment(loc_id,id){
	var xmlhttp;
	if (window.XMLHttpRequest){
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('result_ass_data').innerHTML=xmlhttp.responseText;
			
			$('#owl_demo_5').owlCarousel({
				margin:20,
				nav:true,
				autoplay:true,
				responsive:{
					0:{
						items:1
					},
					280:{
						items:2
					},
					480:{
						items:4
					},
					800:{
						items:8
					},
					
				}
			});
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/assessment_assessor_details?loc_id="+loc_id+"&ass_id="+id,true);
	xmlhttp.send();	
	
}

function open_assessor_assessment_employees(loc_id,assr_id,aloc_id,as_id){
	var xmlhttp;
	if (window.XMLHttpRequest){
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('result_assessment_data').innerHTML=xmlhttp.responseText;
			let button = document.querySelector("#ass_download_excel");
			button.addEventListener("click", e => {
			  let table = document.querySelector("#assessor_data");
			  TableToExcel.convert(table);
			});
			
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/assessor_mapped_assessment_details?loc_id="+loc_id+"&ass_id="+assr_id+"&assl_id="+aloc_id+"&sec_id="+as_id,true);
	xmlhttp.send();	
	
}

function open_tobeassessed(id){
	var xmlhttp;
	if (window.XMLHttpRequest){
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			
			document.getElementById('result_data').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/agel_tobe_assessement?loc_id="+id,true);
	xmlhttp.send();	
	
}
function open_assessed(id){
	var xmlhttp;
	if (window.XMLHttpRequest){
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			
			document.getElementById('result_data').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/agel_assessed_assessement?loc_id="+id,true);
	xmlhttp.send();	
	
}
function open_report(id){
	var xmlhttp;
	if (window.XMLHttpRequest){
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			
			document.getElementById('result_data').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/report_assessement?loc_id="+id,true);
	xmlhttp.send();	
	
}
function getasesstotal(id){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Total employees";
	//document.getElementById("followdes").innerHTML ="Following are the Employees";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
			let button = document.querySelector("#download_excel");
			button.addEventListener("click", e => {
			  let table = document.querySelector("#edit_datable_2");
			  TableToExcel.convert(table);
			});
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/get_agel_total_employees?id="+id, true);
	xmlhttp.send();
}
function getasesstotalcluster(id,bu_id){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Total employees";
	//document.getElementById("followdes").innerHTML ="Following are the Employees";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
			let button = document.querySelector("#download_excel");
			button.addEventListener("click", e => {
			  let table = document.querySelector("#edit_datable_2");
			  TableToExcel.convert(table);
			});
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/get_agel_cluster_total_employees?id="+id+"&b_id="+bu_id, true);
	xmlhttp.send();
}
function getasesscompt(id){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Completed employees";
	//document.getElementById("followdes").innerHTML ="Following are the Employees";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
			let button = document.querySelector("#download_excel_comp");
			button.addEventListener("click", e => {
			  let table = document.querySelector("#edit_datable_2_comp");
			  TableToExcel.convert(table);
			});
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/get_agel_completed_employees?id="+id, true);
	xmlhttp.send();
}
function getasesscomptcluster(id,bu_id){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Completed employees";
	//document.getElementById("followdes").innerHTML ="Following are the Employees";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
			let button = document.querySelector("#download_excel_comp");
			button.addEventListener("click", e => {
			  let table = document.querySelector("#edit_datable_2_comp");
			  TableToExcel.convert(table);
			});
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/get_agel_cluster_completed_employees?id="+id+"&b_id="+bu_id, true);
	xmlhttp.send();
}
function getasesspend(id){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Pending employees";
	//document.getElementById("followdes").innerHTML ="Following are the Employees";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
			let button = document.querySelector("#download_excel_pen");
			button.addEventListener("click", e => {
			  let table = document.querySelector("#edit_datable_2_pen");
			  TableToExcel.convert(table);
			});
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/get_agel_pending_employees?id="+id, true);
	xmlhttp.send();
}
function getasesspendcluster(id,bu_id){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Pending employees";
	//document.getElementById("followdes").innerHTML ="Following are the Employees";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
			let button = document.querySelector("#download_excel_pen");
			button.addEventListener("click", e => {
			  let table = document.querySelector("#edit_datable_2_pen");
			  TableToExcel.convert(table);
			});
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/get_agel_cluster_pending_employees?id="+id+"&b_id="+bu_id, true);
	xmlhttp.send();
}
function getassessor_details(){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Assessor Details";
	//document.getElementById("followdes").innerHTML ="Following are the Employees";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
			let button = document.querySelector("#download_excel_ass");
			button.addEventListener("click", e => {
			  let table = document.querySelector("#edit_datable_2_ass");
			  TableToExcel.convert(table);
			});
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/get_agel_assessor_details", true);
	xmlhttp.send();
}
function getassessor_details_cluster(id,bu_id){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Assessor Details";
	//document.getElementById("followdes").innerHTML ="Following are the Employees";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
			let button = document.querySelector("#download_excel_ass");
			button.addEventListener("click", e => {
			  let table = document.querySelector("#edit_datable_2_ass");
			  TableToExcel.convert(table);
			});
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/get_agel_cluster_assessor_details?id="+id+"&b_id="+bu_id, true);
	xmlhttp.send();
}
function getassessor_assessed(){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Employee Assessed Details";
	//document.getElementById("followdes").innerHTML ="Following are the Employees";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
			let button = document.querySelector("#download_excel_assd");
			button.addEventListener("click", e => {
			  let table = document.querySelector("#edit_datable_2_assd");
			  TableToExcel.convert(table);
			});
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/get_agel_emp_assessed_details", true);
	xmlhttp.send();
}
function getassessor_assessed_cluster(id,bu_id){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Employee Assessed Details";
	//document.getElementById("followdes").innerHTML ="Following are the Employees";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
			let button = document.querySelector("#download_excel_assd");
			button.addEventListener("click", e => {
			  let table = document.querySelector("#edit_datable_2_assd");
			  TableToExcel.convert(table);
			});
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/get_agel_cluster_emp_assessed_details?id="+id+"&b_id="+bu_id, true);
	xmlhttp.send();
}
function getassessor_pen_assessed(){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Assessed pending employees details";
	//document.getElementById("followdes").innerHTML ="Following are the Employees";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
			let button = document.querySelector("#download_excel_passd");
			button.addEventListener("click", e => {
			  let table = document.querySelector("#edit_datable_2_passd");
			  TableToExcel.convert(table);
			});
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/get_agel_emp_pending_assessed_details", true);
	xmlhttp.send();
}
function getassessor_pen_assessed_cluster(id,bu_id){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Assessed pending employees details";
	//document.getElementById("followdes").innerHTML ="Following are the Employees";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
			let button = document.querySelector("#download_excel_passd");
			button.addEventListener("click", e => {
			  let table = document.querySelector("#edit_datable_2_passd");
			  TableToExcel.convert(table);
			});
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/get_agel_cluster_emp_pending_assessed_details?id="+id+"&b_id="+bu_id, true);
	xmlhttp.send();
}



</script>
