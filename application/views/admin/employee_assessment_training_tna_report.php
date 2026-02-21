<div class="content">
	<div class="row">
	<?php
	$security_location_id=@$this->session->userdata('security_location_id');
	if(empty($security_location_id)){
	?>
	
		<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Location Status</h6>
					</div>
					<div class="pull-right">
						<a  href="<?php echo BASE_URL;?>/admin/feedback_assessment_tna_atri_statusreport?type=1" target="_blank" class="pull-left label label-success  mr-15">Completed Employee Report
						</a>
						<a  href="<?php echo BASE_URL;?>/admin/feedback_assessment_tna_atri_statusreport?type=2" target="_blank" class="pull-left label label-warning  mr-15">Inprocess Employee Report
						</a>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-wrapper collapse in">
					<style>
					#table-wrapper {
					  position:relative;
					}
					#table-scroll {
					  height:350px;
					  overflow:auto;  
					  margin-top:20px;
					}
					#table-wrapper table {
					  width:100%;
						
					}
					#table-wrapper table thead th .text {
					  position:absolute;   
					  top:-20px;
					  z-index:2;
					  height:20px;
					}
					</style>
					<div class="panel-body">
						<div class="table-wrap" id="table-wrapper">
							<div class="table-responsive" id="table-scroll">
							  <table class="table table-bordered table-hover mb-0">
								<thead>
								  <tr>
									<th class="text">Location Name</th>
									<th class="text">Emp Completed</th>
									<th class="text">Emp Inprocess</th>
									</tr>
								</thead>
								<tbody>
								<?php 
								$loc_names=UlsMenu::callpdo("SELECT b.`location_id`,b.`location_name`,count(DISTINCT a.`employee_id`) as emp_count FROM uls_assessment_employee_journey a left join(SELECT `employee_id`,`location_id`,`assessment_id`,`position_id`,tna_status FROM `uls_assessment_employees`) i on a.employee_id=i.employee_id and a.assessment_id=i.assessment_id and a.position_id=i.position_id left join(SELECT `location_id`,`location_name` FROM `uls_location`) b on i.location_id=b.location_id WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and i.tna_status='Y' and a.tni_status=1 group by i.location_id order by b.`location_name` ASC");
								/* $loc_names=UlsMenu::callpdo("SELECT b.`location_id`,b.`location_name`,count(DISTINCT a.`employee_id`) as emp_count FROM `uls_assessment_employee_dev_rating` a 
								left join(SELECT `location_id`,`location_name` FROM `uls_location`) b on a.location_id=b.location_id
								left join(SELECT `employee_id`,`tni_status` FROM `uls_assessment_employee_journey`) e on e.employee_id=a.employee_id
								left join(SELECT `employee_id`,`location_id`,`assessment_id`,`position_id`,tna_status FROM `uls_assessment_employees`) i on a.employee_id=i.employee_id and a.assessment_id=i.assessment_id and a.position_id=i.position_id
								WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and i.tna_status='Y' and e.tni_status=1 group by a.location_id order by b.`location_name` ASC"); */
								$totol_emp_loc=$totalinprocess=0;
								foreach($loc_names as $loc_name){
									$tri_names=UlsMenu::callpdorow("SELECT count(DISTINCT `employee_id`) as triempcount FROM `uls_assessment_employees` WHERE `location_id`=".$loc_name['location_id']." and `tna_status`='Y'");
									$totol_emp_loc+=$loc_name['emp_count'];
									$total_inprocess=($tri_names['triempcount']-$loc_name['emp_count']);
									$totalinprocess+=$total_inprocess;
								?>
								  <tr>
									<td><a onclick="getlocationdata(<?php echo $loc_name['location_id']; ?>);"  style="color:blue;cursor: pointer;"><?php echo $loc_name['location_name'];?></a></td>
									
									<td><a onclick="getasesspos(<?php echo $loc_name['location_id']; ?>);"  style="color:blue;cursor: pointer;" data-toggle="modal" data-target=".bs-example-modal-lg"><?php echo $loc_name['emp_count'];?></a></td>
									<td><a onclick="getasessinprocess(<?php echo $loc_name['location_id']; ?>);"  style="color:blue;cursor: pointer;" data-toggle="modal" data-target=".bs-example-modal-lg-tri"><?php echo $total_inprocess;?></a></td>
									
								  </tr>
								<?php
								}
								?>
								<tr>
									<td></td>
									<td>Total:<?php echo $totol_emp_loc; ?></td>
									<td>Total:<?php echo $totalinprocess; ?></td>
								</tr>								
								</tbody>
							  </table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } 
	$col1=!empty($security_location_id)?"col-lg-6":"col-lg-5";
	$col2=!empty($security_location_id)?"col-lg-6":"col-lg-3";
	?>	
		<div id="tni_data">
		<div class="<?php echo $col1; ?> col-md-6 col-sm-6 col-xs-12">
			<div class="panel panel-default card-view" >
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Status</h6>
					</div>
					<?php
					if(!empty($security_location_id)){
						
					?>
					<div class="pull-right">
						<a  href="<?php echo BASE_URL;?>/admin/feedback_assessment_tna_atri_statusreport?type=1&loc_id=<?php echo $security_location_id; ?>" target="_blank" class="pull-left label label-success  mr-15">Completed Employee Report
						</a>
						<a  href="<?php echo BASE_URL;?>/admin/feedback_assessment_tna_atri_statusreport?type=2&loc_id=<?php echo $security_location_id; ?>" target="_blank" class="pull-left label label-warning  mr-15">Inprocess Employee Report
						</a>
					</div>
					<?php
					}?>
					<div class="clearfix"></div>
				</div>
				<div class="panel-wrapper collapse in">
					<div class="panel-body">
						<?php
						if(!empty($security_location_id)){
						$loca_name=UlsLocation::getloc($security_location_id);
						}
						$location_name=!empty($security_location_id)?"TNI information of ".$loca_name['location_name']."":"TNI information accross all locations";
						?>
						<h6 class="panel-title txt-dark"><?php echo $location_name; ?></h6>
						<?php
						$totalcount=0;
						$total_loc_details=!empty($security_location_id)?" and a.location_id=".$security_location_id."":"";
						$total_emp=UlsMenu::callpdorow("SELECT count(DISTINCT a.`employee_id`) as totemp_count FROM `uls_assessment_employees` a 
						left join(SELECT `location_id`,`location_name` FROM `uls_location`) b on a.location_id=b.location_id
						WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." ".$total_loc_details." and a.tna_status='Y'");
						if(!empty($security_location_id)){
						$loc_count=UlsMenu::callpdorow("SELECT b.`location_id`,b.`location_name`,count(DISTINCT a.`employee_id`) as emp_count FROM uls_assessment_employee_journey a left join(SELECT `employee_id`,`location_id`,`assessment_id`,`position_id`,tna_status FROM `uls_assessment_employees`) i on a.employee_id=i.employee_id and a.assessment_id=i.assessment_id and a.position_id=i.position_id left join(SELECT `location_id`,`location_name` FROM `uls_location`) b on i.location_id=b.location_id WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and i.location_id=".$security_location_id." and i.tna_status='Y' and a.tni_status=1 group by i.location_id order by b.`location_name` ASC");
						$totalcount=!empty($loc_count['emp_count'])?$loc_count['emp_count']:$totol_emp_loc;
						}
						else{
							$totalcount=$totol_emp_loc;
						}
						?>
						<div class="row mt-25">
							<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
								<div class="panel panel-default card-view pa-0">
									<div class="panel-wrapper collapse in">
										<div class="panel-body pa-0">
											<div class="sm-data-box">
												<div class="container-fluid">
													<div class="row">
														<?php
														$loc_n_id=!empty($security_location_id)?$security_location_id:""; ?>
														<?php 
														if(!empty($security_location_id)){
															$anchorcom="onclick='getasesscompt(".$loc_n_id.")'  style='color:blue;cursor: pointer;' data-toggle='modal' data-target='.bs-example-modal-lg'";
														}
														else{
															$anchorcom="onclick='getasesscompt(\"\")'  style='color:blue;cursor: pointer;' data-toggle='modal' data-target='.bs-example-modal-lg'";
														}
														?>
														<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
															<a <?php echo $anchorcom; ?>><span class="txt-dark block counter"><span class="counter-anim"><?php echo $total_emp['totemp_count']; ?></span></span>
															<span class="weight-500 uppercase-font block font-13">Total</span></a>
														</div>
														<div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
															<i class="icon-user-following data-right-rep-icon txt-light-grey"></i>
														</div>
													</div>	
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
								<div class="panel panel-default card-view pa-0">
									<div class="panel-wrapper collapse in">
										<div class="panel-body pa-0">
											<div class="sm-data-box">
												<div class="container-fluid">
													<div class="row">
													<?php
													$loc_n_id=!empty($security_location_id)?$security_location_id:""; ?>
													<?php 
													if(!empty($security_location_id)){
														$anchorc="onclick='getasesspos(".$loc_n_id.")'  style='color:blue;cursor: pointer;' data-toggle='modal' data-target='.bs-example-modal-lg'";
													}
													else{
														$anchorc="onclick='getasesspos(\"\")'  style='color:blue;cursor: pointer;' data-toggle='modal' data-target='.bs-example-modal-lg'";
													}
													?>
														<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
															<a <?php echo $anchorc; ?>><span class="txt-dark block counter"><span class="counter-anim"><?php echo $totalcount; ?></span></span>
															<span class="weight-500 uppercase-font block">Completed</span></a>
														</div>
														<div class="col-xs-6 text-center  pl-0 pr-0 pt-25  data-wrap-right">
															<i class="icon-user-following data-right-rep-icon txt-light-grey"></i>
														</div>
													</div>	
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						
							<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
								
								<div class="panel panel-default card-view pa-0">
									<div class="panel-wrapper collapse in">
										<div class="panel-body pa-0">
											<div class="sm-data-box">
												<div class="container-fluid">
													<div class="row">
														<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
															<?php $loc_n_id=!empty($security_location_id)?$security_location_id:""; ?>
															<?php 
															if(!empty($security_location_id)){
																$anchor="onclick='getasessinprocess(".$loc_n_id.")'  style='color:blue;cursor: pointer;' data-toggle='modal' data-target='.bs-example-modal-lg-tri'";
															}
															else{
																$anchor="onclick='getasessinprocess(\"\")'  style='color:blue;cursor: pointer;' data-toggle='modal' data-target='.bs-example-modal-lg-tri'";
															}
															?>
															<a <?php echo $anchor;?>>
															<span class="txt-dark block counter"><span class="counter-anim"><?php echo $notstarted=($total_emp['totemp_count']-$totalcount); ?></span></span>
															<span class="weight-500 uppercase-font block">Inprocess</span>
															</a>
														</div>
														<div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
															<i class="icon-user-following data-right-rep-icon txt-light-grey"></i>
														</div>
													</div>	
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
						</div>
						<div class="row  mt-25">
							<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
								<?php
								$total_comp_details=!empty($security_location_id)?" and i.location_id=".$security_location_id."":"";
								$total_comp=UlsMenu::callpdorow("SELECT count(DISTINCT a.`comp_def_id`) as comp_count,count(DISTINCT a.employee_id) as empcount FROM `uls_assessment_employee_select_programs` a 
								left join(SELECT `employee_id`,`tni_status` FROM `uls_assessment_employee_journey`) e on e.employee_id=a.employee_id
								left join(SELECT `employee_id`,`location_id`,`assessment_id`,`position_id`,tna_status FROM `uls_assessment_employees`) i on a.employee_id=i.employee_id and a.assessment_id=i.assessment_id and a.position_id=i.position_id
								WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." ".$total_comp_details." and i.tna_status='Y' and i.location_id is not NULL and e.tni_status=1");
								?>
								<div class="panel panel-default card-view">
									<div class="panel-wrapper collapse in">
										<div class="panel-body sm-data-box-1">
											<span class="uppercase-font weight-500 font-14 block text-center txt-dark">Total Competencies Selected</span>	
											<div class="cus-sat-stat weight-500 text-center mt-5">
												<span class="counter-anim"><?php echo $total_comp['comp_count']; ?></span>
											</div>
											<div class="progress-anim mt-20">
												<div class="progress">
													<div class="progress-bar progress-bar-primary
													wow animated progress-animated" role="progressbar" aria-valuenow="93.12" aria-valuemin="0" aria-valuemax="100" style="width: 93.12%;"></div>
												</div>
											</div>
											
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
								<?php
								$total_pro_details=!empty($security_location_id)?" and i.location_id=".$security_location_id."":"";
								$total_programs=UlsMenu::callpdorow("SELECT count(DISTINCT (trim(p.`program_name`))) as pro_count,count(DISTINCT a.employee_id) as proempcount FROM `uls_assessment_employee_select_programs` a
								left join(SELECT `comp_def_pro_id`,`comp_def_level_ind_id`,`comp_def_id`,program_name FROM `uls_competency_def_level_indicator_programs`) p on p.comp_def_pro_id=a.comp_def_pro_id
								left join(SELECT `employee_id`,`tni_status` FROM `uls_assessment_employee_journey`) e on e.employee_id=a.employee_id
								left join(SELECT `employee_id`,`location_id`,`assessment_id`,`position_id`,tna_status FROM `uls_assessment_employees`) i on a.employee_id=i.employee_id and a.assessment_id=i.assessment_id and a.position_id=i.position_id
								WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." ".$total_pro_details."  and i.tna_status='Y' and i.location_id is not NULL and e.tni_status=1"); 
								?>
								<div class="panel panel-default card-view">
									<div class="panel-wrapper collapse in">
										<div class="panel-body sm-data-box-1">
											<span class="uppercase-font weight-500 font-14 block text-center txt-dark">Total Programs Selected</span>
											<?php 
											//style='color:blue;cursor: pointer;' data-toggle='modal' data-target='.bs-example-modal-lg-pro'
											$locnid=!empty($security_location_id)?$security_location_id:"''";
											if(!empty($security_location_id)){
												$anchor_programs="onclick='getasessprogram(".$locnid.")'";
											}
											else{
												$anchor_programs="onclick='getasessprogram_full()'";
											}
											?>
											<a style='color:blue;cursor: pointer;' <?php echo $anchor_programs; ?>><div class="cus-sat-stat weight-500 text-center mt-5">
												<span class="counter-anim"><?php echo $total_programs['pro_count']; ?></span>
											</div></a>
											<div class="progress-anim mt-20">
												<div class="progress">
													<div class="progress-bar progress-bar-primary
													wow animated progress-animated" role="progressbar" aria-valuenow="93.12" aria-valuemin="0" aria-valuemax="100" style="width: 93.12%;"></div>
												</div>
											</div>
											
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
								<?php
								$total_ind_details=!empty($security_location_id)?" and i.location_id=".$security_location_id."":"";
								
								$total_indicators=UlsMenu::callpdorow("SELECT count(DISTINCT p.`comp_def_level_ind_id`) as ind_count,count(DISTINCT a.employee_id) as indempcount FROM `uls_assessment_employee_select_programs` a 
								left join(SELECT `comp_def_pro_id`,`comp_def_level_ind_id`,`comp_def_id` FROM `uls_competency_def_level_indicator_programs`) p on p.comp_def_pro_id=a.comp_def_pro_id
								left join(SELECT `employee_id`,`tni_status` FROM `uls_assessment_employee_journey`) e on e.employee_id=a.employee_id
								left join(SELECT `employee_id`,`location_id`,`assessment_id`,`position_id`,tna_status FROM `uls_assessment_employees`) i on a.employee_id=i.employee_id and a.assessment_id=i.assessment_id and a.position_id=i.position_id
								WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." ".$total_ind_details." and i.tna_status='Y' and i.location_id is not NULL and e.tni_status=1");
								?>
								<div class="panel panel-default card-view">
									<div class="panel-wrapper collapse in">
										<div class="panel-body sm-data-box-1">
											<span class="uppercase-font weight-500 font-14 block text-center txt-dark">Total Indicators Selected</span>	
											<div class="cus-sat-stat weight-500 text-center mt-5">
												<span class="counter-anim"><?php echo $total_indicators['ind_count']; ?></span>
											</div>
											<div class="progress-anim mt-20">
												<div class="progress">
													<div class="progress-bar progress-bar-primary
													wow animated progress-animated" role="progressbar" aria-valuenow="93.12" aria-valuemin="0" aria-valuemax="100" style="width: 93.12%;"></div>
												</div>
											</div>
											
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--<div class="table-wrap" id="table-wrapper">
							<div class="table-responsive" id="table-scroll">
							  <table class="table table-bordered table-hover mb-0">
								<thead>
								  <tr>
									<th  class="text">Department Name</th>
									<th class="text">Emp Completed Count</th>
									</tr>
								</thead>
								<tbody>
								<?php 
								$dap_name=!empty($security_location_id)?" and a.location_id=".$security_location_id:"";
								$org_names=UlsMenu::callpdo("SELECT b.`organization_id`,b.`org_name`,count(DISTINCT a.`employee_id`) as emp_count FROM `uls_assessment_employee_dev_rating` a 
								left join(SELECT `organization_id`,`org_name` FROM `uls_organization_master`) b on a.org_id=b.organization_id
								left join(SELECT `employee_id`,`tni_status` FROM `uls_assessment_employee_journey`) e on e.employee_id=a.employee_id
								WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and e.tni_status=1 ".$dap_name."  group by a.org_id order by b.`org_name` ASC");
								
								foreach($org_names as $org_name){
								?>
								  <tr>
									<td><?php echo $org_name['org_name'];?></td>
									<td><a onclick="getasessorg(<?php echo $org_name['organization_id']; ?>);"  style="color:blue;cursor: pointer;" data-toggle="modal" data-target=".bs-example-modal-lg-org"><?php echo $org_name['emp_count'];?></a></td>
								  </tr>
								<?php 
								}
								?>
								</tbody>
							  </table>
							</div>
						</div>-->
					</div>
				</div>
			</div>
		</div>	
		<div class="<?php echo $col2; ?> col-md-6 col-sm-6 col-xs-12">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Top 3 Competencies</h6>
						<small class="text-muted">Identified as Development</small>
					</div>
					
					<div class="clearfix"></div>
				</div>
				<div class="panel-wrapper collapse in">
					<div class="panel-body">
						<?php
						$total_top_details=!empty($security_location_id)?" and i.location_id=".$security_location_id."":"";
						$top_comp=UlsMenu::callpdo("SELECT a.`comp_def_id`,c.comp_def_name,count(DISTINCT a.employee_id) as empcount FROM `uls_assessment_employee_select_programs` a 
						left join(SELECT `employee_id`,`tni_status` FROM `uls_assessment_employee_journey`) e on e.employee_id=a.employee_id
						left join(SELECT `employee_id`,`location_id`,`assessment_id`,`position_id`,tna_status FROM `uls_assessment_employees`) i on a.employee_id=i.employee_id and a.assessment_id=i.assessment_id and a.position_id=i.position_id
						left join(SELECT `comp_def_id`,`comp_def_name` FROM `uls_competency_definition`) c on c.comp_def_id=a.comp_def_id 
						WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." ".$total_top_details." and i.tna_status='Y' and i.location_id is not NULL and e.tni_status=1 group by a.`comp_def_id` ORDER BY empcount DESC limit 3");
						?>
						<div>
						<?php 
						foreach($top_comp as $key=>$top_comps){
						?>
							<span class="pull-left inline-block capitalize-font txt-dark">
								<?php echo ($key+1)." ".$top_comps['comp_def_name']; ?>
							</span>
							<span class="label label-warning pull-right"></span>
							<div class="clearfix"></div>
							<hr class="light-grey-hr row mt-10 mb-20">
							<div class="clearfix"></div>
						<?php
						}
						?>
						</div>
					</div>	
				</div>
			</div>
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Top 3 Programs</h6>
						<small class="text-muted">Identified for Training </small>
					</div>
					
					<div class="clearfix"></div>
				</div>
				<div class="panel-wrapper collapse in">
					<div class="panel-body">
						<?php
						$total_pro_details=!empty($security_location_id)?" and i.location_id=".$security_location_id."":"";
						
						$top_programs=UlsMenu::callpdo("SELECT DISTINCT (trim(p.`program_name`)) as programname,count(DISTINCT a.employee_id) as empcount,a.`comp_def_pro_id` FROM `uls_assessment_employee_select_programs` a 
						left join(SELECT `employee_id`,`tni_status` FROM `uls_assessment_employee_journey`) e on e.employee_id=a.employee_id
						left join(SELECT `comp_def_pro_id`,`program_name` FROM `uls_competency_def_level_indicator_programs`) p on p.comp_def_pro_id=a.comp_def_pro_id
						left join(SELECT `employee_id`,`location_id`,`assessment_id`,`position_id`,tna_status FROM `uls_assessment_employees`) i on a.employee_id=i.employee_id and a.assessment_id=i.assessment_id and a.position_id=i.position_id
						WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." ".$total_pro_details." and i.tna_status='Y' and i.location_id is not NULL and e.tni_status=1 group by a.`comp_def_pro_id` ORDER BY empcount DESC limit 3");
						?>
						<div>
						<?php 
						foreach($top_programs as $key1=>$top_pros){
						?>
							<span class="pull-left inline-block capitalize-font txt-dark">
								<?php echo ($key1+1)." ".$top_pros['programname']; ?>
							</span>
							<span class="label label-warning pull-right"></span>
							<div class="clearfix"></div>
							<hr class="light-grey-hr row mt-10 mb-20">
							<div class="clearfix"></div>
						<?php
						}
						?>
						</div>
					</div>	
				</div>
			</div>
		</div>
		
		</div>
	</div>
	<div id="txtHintprofull">
	
	</div>
	<div id="txtHintpro">
	
	</div>
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Competency Based TNI Report</h6>
						<p style="color:red;">Please select on location (and other filters, as required) to generate the Competency Based TNI Report </p>
					</div>
					
					<div class="clearfix"></div>
				</div>
				<div class="panel-body">
					
					<form action="#"  class="form-horizontal">
						<div class="form-group" aria-expanded="true" style="color: rgb(15, 197, 187);"><label class="control-label mb-10 col-sm-2">Location Name<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
							<?php
							$security_location_id=@$this->session->userdata('security_location_id');
							if(!empty($security_location_id)){
								$loc_name=UlsLocation::getloc($security_location_id);
							?>
							<input type="hidden" name="location_id" id="location_id" value="<?php echo $security_location_id; ?>">
							<label class="control-label mb-10"><b><?php echo $loc_name['location_name']; ?></b></label>
							<?php
							}
							else{
							$loc_names=UlsMenu::callpdo("SELECT b.`location_id`,b.`location_name` FROM `uls_assessment_employee_dev_rating` a 
							left join(SELECT `location_id`,`location_name` FROM `uls_location`) b on a.location_id=b.location_id
							WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.location_id is not NULL group by a.location_id order by b.`location_name` ASC");
							?>
							<!--id="loginForm_new" validate[required]-->
							<select id="location_id" name="location_id" class="form-control m-b" data-prompt-position="topLeft" onchange="open_data();">
								<option value="">Select All</option>
								<?php 
								foreach($loc_names as $loc_name){
									$select=!empty($security_location_id)?(($loc_name['location_id']==$security_location_id)?"selected=selected":""):"";
								?>
								<option value="<?php echo $loc_name['location_id'];?>" <?php echo $select; ?>><?php echo $loc_name['location_name'];?></option>
								<?php
								}
								?>
							</select>
							<?php 
							}
							?>
							</div>
						</div>
						<div id="tni_data_search">
						<div class="form-group" aria-expanded="true" style="color: rgb(15, 197, 187);"><label class="control-label mb-10 col-sm-2">Department Name:</label>
							<div class="col-sm-5">
							<?php 
							$dap_name=!empty($security_location_id)?" and a.location_id=".$security_location_id:"";
							$org_names=UlsMenu::callpdo("SELECT b.`organization_id`,b.`org_name` FROM `uls_assessment_employee_dev_rating` a 
							left join(SELECT `organization_id`,`org_name` FROM `uls_organization_master`) b on a.org_id=b.organization_id
							WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." ".$dap_name."  group by a.org_id order by b.`org_name` ASC");
							?>
							<select id="organization_id" name="organization_id" class="form-control m-b"data-prompt-position="topLeft" onchange="open_competeny();">
								<option value="">Select All</option>
								<?php 
								foreach($org_names as $org_name){
								?>
								<option value="<?php echo $org_name['organization_id'];?>"><?php echo $org_name['org_name'];?></option>
								<?php
								}
								?>
							</select>
							</div>
						</div>
						<div id="comp_data_search">
						<?php
						$comp_name=!empty($security_location_id)?" and i.location_id=".$security_location_id:"";
						$competency_names=UlsMenu::callpdo("SELECT DISTINCT(a.comp_def_id) as comp_id,c.comp_def_name FROM `uls_assessment_employee_select_programs` a left join(SELECT `employee_id`,`tni_status` FROM `uls_assessment_employee_journey`) e on e.employee_id=a.employee_id left join(SELECT `employee_id`,`location_id`,`assessment_id`,`position_id`,tna_status FROM `uls_assessment_employees`) i on a.employee_id=i.employee_id and a.assessment_id=i.assessment_id and a.position_id=i.position_id 
						left join(SELECT `comp_def_id`,`comp_def_name` FROM `uls_competency_definition`) c on c.comp_def_id=a.comp_def_id
						WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." ".$comp_name." and i.tna_status='Y' and i.location_id is not NULL and e.tni_status=1 order by c.`comp_def_name` ASC");
						?>
						<div class="form-group" aria-expanded="true" style="color: rgb(15, 197, 187);" id="comptency_data"><label class="control-label mb-10 col-sm-2">Competency Name:</label>
							<div class="col-sm-5">
							<select id="comp_def_id" name="comp_def_id" class="form-control m-b"data-prompt-position="topLeft" onchange="open_program();">
								<option value="">Select All</option>
								<?php 
								foreach($competency_names as $key=>$competency_name){
								?>
								<option value="<?php echo $competency_name['comp_id'];?>"><?php echo $competency_name['comp_def_name'];?></option>
								<?php
								}
								?>
							</select>
							</div>
						</div>
						<div id="program_data">
						<?php
						$pro_name=!empty($security_location_id)?" and i.location_id=".$security_location_id:"";
						
						$programs_names=UlsMenu::callpdo("SELECT DISTINCT (trim(p.`program_name`)) as proname FROM `uls_assessment_employee_select_programs` a 
						left join(SELECT `employee_id`,`tni_status` FROM `uls_assessment_employee_journey`) e on e.employee_id=a.employee_id
						left join(SELECT `comp_def_pro_id`,`program_name` FROM `uls_competency_def_level_indicator_programs`) p on p.comp_def_pro_id=a.comp_def_pro_id
						left join(SELECT `employee_id`,`location_id`,`assessment_id`,`position_id`,tna_status FROM `uls_assessment_employees`) i on a.employee_id=i.employee_id and a.assessment_id=i.assessment_id and a.position_id=i.position_id
						WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." ".$pro_name." and i.tna_status='Y' and a.`comp_def_pro_id` is not NULL and i.location_id is not NULL and e.tni_status=1 order by proname ASC");
						?>
						<div  class="form-group" aria-expanded="true" style="color: rgb(15, 197, 187);"><label class="control-label mb-10 col-sm-2">Program Name:</label>
							<div class="col-sm-5">
							<select id="comp_def_pro_id" name="comp_def_pro_id" class="form-control m-b"data-prompt-position="topLeft">
								<option value="">Select All</option>
								<?php 
								foreach($programs_names as $key=>$programs_name){
								?>
								<option value="<?php echo urlencode($programs_name['proname']);?>"><?php echo $programs_name['proname'];?></option>
								<?php
								}
								?>
							</select>
							</div>
						</div>
						</div>
						</div>
						</div>
						<div class="col-sm-offset-6">
							
								<label class="control-label mb-10 text-left">&nbsp;</label>
								
								<a href="#" class="btn btn-primary btn-sm" onclick="get_organisation();" >Generate Report</a>
							

						</div>
						
						<div class="form-group col-sm-offset-0">
						
						</div>
					</form>
				</div>
				<div class="hpanel">
					
				</div>
			</div>
		</div>
	</div>
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Employee TNI Report</h6>
					</div>
					
					<div class="clearfix"></div>
				</div>
				<div class="panel-body">
					
					<form action="#" id="loginForm" class="form-horizontal">
						<div class="form-group" aria-expanded="true" style="color: rgb(15, 197, 187);"><label class="control-label mb-10 col-sm-2">Location Name<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
							<?php
							$security_location_id=@$this->session->userdata('security_location_id');
							if(!empty($security_location_id)){
								$loc_name=UlsLocation::getloc($security_location_id);
							?>
							<input type="hidden" name="location_id" id="locid" value="<?php echo $security_location_id; ?>">
							<label class="control-label mb-10"><b><?php echo $loc_name['location_name']; ?></b></label>
							<?php
							}
							else{
							$loc_names=UlsMenu::callpdo("SELECT b.`location_id`,b.`location_name` FROM `uls_assessment_employee_dev_rating` a 
							left join(SELECT `location_id`,`location_name` FROM `uls_location`) b on a.location_id=b.location_id
							WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.location_id is not NULL group by a.location_id order by b.`location_name` ASC");
							?>
							<select id="locid" name="locid" class="validate[required] form-control m-b" data-prompt-position="topLeft" onchange="open_data_report();">
								<option value="">Select</option>
								<?php 
								foreach($loc_names as $loc_name){
									$select=!empty($security_location_id)?(($loc_name['location_id']==$security_location_id)?"selected=selected":""):"";
								?>
								<option value="<?php echo $loc_name['location_id'];?>" <?php echo $select; ?>><?php echo $loc_name['location_name'];?></option>
								<?php
								}
								?>
							</select>
							<?php 
							}
							?>
							</div>
						</div>
						<div class="form-group" aria-expanded="true" style="color: rgb(15, 197, 187);"><label class="control-label mb-10 col-sm-2">Department Name:</label>
							<div class="col-sm-5">
							<?php 
							$dap_name=!empty($security_location_id)?" and a.location_id=".$security_location_id:"";
							$org_names=UlsMenu::callpdo("SELECT b.`organization_id`,b.`org_name` FROM `uls_assessment_employee_dev_rating` a 
							left join(SELECT `organization_id`,`org_name` FROM `uls_organization_master`) b on a.org_id=b.organization_id
							WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." ".$dap_name."  group by a.org_id order by b.`org_name` ASC");
							?>
							<select id="orgid" name="orgid" class="validate[required] form-control m-b" onchange="open_employees();" data-prompt-position="topLeft">
								<option value="">Select</option>
								<?php 
								foreach($org_names as $org_name){
								?>
								<option value="<?php echo $org_name['organization_id'];?>"><?php echo $org_name['org_name'];?></option>
								<?php
								}
								?>
							</select>
							</div>
						</div>
						<div id="tna_details">
						
						
						</div>
						
						<div class="form-group col-sm-offset-0">
						
						</div>
					</form>
				</div>
				<div class="hpanel">
					
				</div>
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
<div class="modal fade bs-example-modal-lg-tri" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabeltri" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg" style="width:1400px">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h5 class="modal-title" id="myLargeModalLabeltri">Competency attached Positions</h5>
			</div>
			<div class="modal-body">
				<div id="txtHinttri" style="margin: 15px;">
				
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

<div class="modal fade bs-example-modal-lg-pro" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabelpro" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg" style="width:1400px">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h5 class="modal-title" id="myLargeModalLabelpro">Programs</h5>
			</div>
			<div class="modal-body">
				<div id="txtHintpro" style="margin: 15px;">
				
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

<div class="modal fade bs-example-modal-lg-profull" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabelprofull" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg" style="width:1400px">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h5 class="modal-title" id="myLargeModalLabelprofull">Programs</h5>
			</div>
			<div class="modal-body">
				<div id="txtHintprofull" style="margin: 15px;">
				
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



<div class="modal fade bs-example-modal-lg-org" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabelorg" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h5 class="modal-title" id="myLargeModalLabelorg">Competency attached Positions</h5>
			</div>
			<div class="modal-body">
				<div id="txtHints" style="margin: 15px;">
				
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
function open_data_report(){ 
	var loc_id=document.getElementById('locid').value;
	
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
			
			document.getElementById('orgid').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/employee_tna_report_search_details?loc_id="+loc_id,true);
	xmlhttp.send();	
	
}
function open_data(){ 
	var loc_id=document.getElementById('location_id').value;
	
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
			
			document.getElementById('tni_data_search').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/employee_tna_search_details?loc_id="+loc_id,true);
	xmlhttp.send();	
	
}
function open_competeny(){ 
	var loc_id=document.getElementById('location_id').value;
	var organization_id=document.getElementById('organization_id').value;
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
			
			document.getElementById('comp_data_search').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/employee_tna_comp_search_details?loc_id="+loc_id+"&org_id="+organization_id,true);
	xmlhttp.send();	
	
}

function open_program(){ 
	var loc_id=document.getElementById('location_id').value;
	var organization_id=document.getElementById('organization_id').value;
	var comp_def_id=document.getElementById('comp_def_id').value;
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
			
			document.getElementById('program_data').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/employee_tna_program_search_details?loc_id="+loc_id+"&org_id="+organization_id+"&comp_def_id="+comp_def_id,true);
	xmlhttp.send();	
	
}

function open_employees(){ 
	var loc_id=document.getElementById('locid').value;
	var orgid=document.getElementById('orgid').value;
	
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
			
			document.getElementById('tna_details').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/employee_tna_report_details?location_id="+loc_id+"&organization_id="+orgid,true);
	xmlhttp.send();	
	
}

function getlocationdata(id){ 
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
			
			document.getElementById('tni_data').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/tni_location_details?location_id="+id,true);
	xmlhttp.send();	
}
function getasesspos(id){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Loction based employees";
	//document.getElementById("followdes").innerHTML ="Following are the Employees";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/get_location_tni_employees?id=" + id, true);
	xmlhttp.send();
}

function getasessprogram(id){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabelpro").innerHTML ="Programs";
	//document.getElementById("followdes").innerHTML ="Following are the Employees";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHintpro").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/get_location_tni_emp_programs?id=" + id, true);
	xmlhttp.send();
}

function getasessprogram_full(){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabelpro").innerHTML ="Programs";
	//document.getElementById("followdes").innerHTML ="Following are the Employees";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHintprofull").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/get_location_tni_emp_programs", true);
	xmlhttp.send();
}

function getasessinprocess(id){
	
	document.getElementById("txtHinttri").innerHTML ="";
	document.getElementById("myLargeModalLabeltri").innerHTML ="Loction based Inproccess employees";
	//document.getElementById("followdes").innerHTML ="Following are the Employees";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHinttri").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/get_location_tni_inp_employees?id=" + id, true);
	xmlhttp.send();
}
function getasessorg(id){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabelorg").innerHTML ="Department based employees";
	//document.getElementById("followdes").innerHTML ="Following are the Employees";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHints").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/get_location_tni_employees?org_id=" + id, true);
	xmlhttp.send();
}
function get_organisation(){
	var def=$('#loginForm_new').validationEngine('validate');
	if(def==false){
		$('#loginForm_new').validationEngine();
		return false;
	}
	else {
		var loc_id=document.getElementById("location_id").value;
		var org_id=document.getElementById("organization_id").value;
		var comp_def_id=document.getElementById("comp_def_id").value;
		var comp_def_pro_id=document.getElementById("comp_def_pro_id").value;
		var data="";
		if(org_id!=''){
			data+="&org_id="+org_id;
		}
		if(comp_def_id!=''){
			data+="&comp_def_id="+comp_def_id;
		}
		if(comp_def_pro_id!=''){
			data+="&comp_def_pro_id="+comp_def_pro_id;
		}
		
		window.open(BASE_URL+"/admin/feedback_assessment_tna_atri_statusreport?loc_id="+loc_id+data, '_blank');
	}
}
function sendreminder(id){
	document.getElementById("txtHint").innerHTML ="";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("emp"+id).innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/tnireminder?id=" + id, true);
	xmlhttp.send();
}
function sendreminderall(id){
	document.getElementById("txtHint").innerHTML ="";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("loctni"+id).innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/tniremindertoall?id=" + id, true);
	xmlhttp.send();
}

function open_employee_pro(names,ids){
	document.getElementById("txtHint").innerHTML ="";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("emp"+id).innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/tnireminder?id=" + id, true);
	xmlhttp.send();
}

function getasesscompt(id){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Loction based employees";
	//document.getElementById("followdes").innerHTML ="Following are the Employees";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/get_location_tni_triggered_employees?id=" + id, true);
	xmlhttp.send();
}
</script>
