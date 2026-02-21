<style>
.col-lg-21 {
    width: 20%;
}
</style>
<div class="content">
	<div class="row">
	<div class="col-lg-21 col-md-6 col-sm-12 col-xs-12">
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
	<div class="col-lg-21 col-md-6 col-sm-12 col-xs-12">
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
	<div class="col-lg-21 col-md-6 col-sm-12 col-xs-12">
		<a href="<?php echo BASE_URL; ?>/admin/hr_dashboard">
		<div class="panel panel-default card-view pa-0 <?php if(strstr($_SERVER['REQUEST_URI'],'hr_dashboard')){ echo "bg-blue";}?>">
			<div class="panel-wrapper collapse in">
				<div class="panel-body pa-0">
					<div class="sm-data-box">
						<div class="container-fluid">
							<div class="row">
								<div class="col-xs-10 text-center pl-0 pr-0 data-wrap-left">
									<span class="txt-dark block counter font-15 <?php if(strstr($_SERVER['REQUEST_URI'],'hr_dashboard')){ echo "txt-light";}?>"><span class="">HR Dashboard</span></span>
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
	<div class="col-lg-21 col-md-6 col-sm-12 col-xs-12">
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
	<div class="col-lg-21 col-md-6 col-sm-12 col-xs-12">
		<a href="<?php echo BASE_URL; ?>/admin/competency_dashboard">
		<div class="panel panel-default card-view pa-0">
			<div class="panel-wrapper collapse in">
				<div class="panel-body pa-0">
					<div class="sm-data-box">
						<div class="container-fluid">
							<div class="row">
								<div class="col-xs-10 text-center pl-0 pr-0 data-wrap-left">
									<span class="txt-dark block counter font-15"><span class="">Competency Dashbaord</span></span>
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
		<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
			<div class="panel panel-default card-view pa-0">
				<div class="panel-wrapper collapse in">
					<div class="panel-body pa-0">
						<div class="sm-data-box">
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
										<span class="txt-dark block counter"><span class="counter-anim"><?php echo $total_emp['total_emp']; ?></span></span>
										<span class="weight-500 uppercase-font block font-13">Total Employees</span>
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
			<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
			<div class="panel panel-default card-view pa-0">
				<div class="panel-wrapper collapse in">
					<div class="panel-body pa-0">
						<div class="sm-data-box">
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
										<span class="txt-dark block counter"><span class="counter-anim"><?php echo $assd_emp['assd_emp']; ?></span></span>
										<span class="weight-500 uppercase-font block"># Assessed Emloyees</span>
									</div>
									<div class="col-xs-6 text-center  pl-0 pr-0 pt-25  data-wrap-right">
										<div class="sp-small-chart" id="sparkline_4"><canvas width="100" height="50" style="display: inline-block; width: 100px; height: 50px; vertical-align: top;"></canvas></div>
									</div>
								</div>	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
			<div class="panel panel-default card-view pa-0">
				<div class="panel-wrapper collapse in">
					<div class="panel-body pa-0">
						<div class="sm-data-box">
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
										<span class="txt-dark block counter"><span class="counter-anim"><?php echo $assd_pos['assd_pos']; ?></span></span>
										<span class="weight-500 uppercase-font block"># Assessed Positions</span>
									</div>
									<div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
										<i class="icon-control-rewind data-right-rep-icon txt-light-grey"></i>
									</div>
								</div>	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
			<div class="panel panel-default card-view pa-0">
				<div class="panel-wrapper collapse in">
					<div class="panel-body pa-0">
						<div class="sm-data-box">
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
										<span class="txt-dark block counter"><span class="counter-anim"><?php echo $assessor_count['assessor_count']; ?></span></span>
										<span class="weight-500 uppercase-font block"># of Assessors</span>
									</div>
									<div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
										<i class="icon-layers data-right-rep-icon txt-light-grey"></i>
									</div>
								</div>	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		
		<div id="owl_demo_new" class="owl-carousel owl-theme">
		<?php
		foreach($loc_names as $loc_name){
			
			$total_emp_loc=UlsMenu::callpdorow("SELECT count(distinct(a.employee_id)) as loc_total_emp FROM `uls_assessment_employees` a left join(SELECT `assessment_id`,`ass_methods` FROM `uls_assessment_definition`) b on a.assessment_id=b.assessment_id WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and b.ass_methods='Y' and a.location_id=".$loc_name['location_id']);
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
							<div>
								<a href="#" onclick="open_tobeassessed(<?php echo $loc_name['location_id'];?>);" style="text-decoration: underline;color:blue;">
								<span># to be Assesssed</span>
								<span class="label label-warning pull-right font-15"><?php echo $total_emp_loc['loc_total_emp']; ?></span>
								</a>
								<div class="clearfix"></div>
								<hr class="light-grey-hr row mt-10 mb-10">
								<a href="#" onclick="open_assessed(<?php echo $loc_name['location_id'];?>);" style="text-decoration: underline;color:blue;">
								<span># Assessed</span>
								<span class="label label-primary pull-right font-15"><?php echo $ass_emp_loc['ass_emp_loc']; ?></span>
								</a>
								<div class="clearfix"></div>
								<hr class="light-grey-hr row mt-10 mb-10">
								<a href="#" onclick="open_report(<?php echo $loc_name['location_id'];?>);" style="text-decoration: underline;color:blue;">
								<span># Reports Generated</span>
								<span class="label label-success pull-right font-15"><?php echo $report_emp_loc['report_total_emp']; ?></span>
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
	<div id="result_data">
	<div class="row">
		<div class="col-lg-8 col-md-7 col-sm-12 col-xs-12">
			<div class="panel panel-default card-view panel-refresh">
				<div class="refresh-container">
					<div class="la-anim-1"></div>
				</div>
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark">To be Assessed</h6>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-wrapper collapse in">
					<div class="panel-body row pa-0">
						<div class="table-wrap">
							<div style='height: 500px;overflow: auto;'>
								<div class="table-responsive">
									<table class="table table-hover table-bordered display mb-30">
										<thead>
											<tr>
												<th>Emp Code</th>
												<th>Emp Name</th>
												<th>Designation</th>
												<th>Department</th>
												<th>Location</th>
												<th>Assessor Status</th>
											</tr>
											
										</thead>
										<tbody>
										<?php 
										foreach($emp_details as $emp_detail){
											$ass_pos_count=UlsMenu::callpdorow("SELECT count(distinct(assessor_id)) as ass_count FROM `uls_assessment_position_assessor` WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and `position_id`=".$emp_detail['position_id']." and `assessment_id`=".$emp_detail['assessment_id']." and assessor_per='Y' and find_in_set(".$emp_detail['employee_id'].",emp_ids)");
											$ass_pos_count2=UlsMenu::callpdorow("SELECT count(distinct(assessor_id)) as ass_counts FROM `uls_assessment_position_assessor` WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and `position_id`=".$emp_detail['position_id']." and `assessment_id`=".$emp_detail['assessment_id']." and assessor_per is NULL");
											$empass_pos_count=UlsMenu::callpdorow("SELECT count(assessor_id) as asscount FROM `uls_assessment_report_final` WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and employee_id=".$emp_detail['employee_id']." and `position_id`=".$emp_detail['position_id']." and `assessment_id`=".$emp_detail['assessment_id']);
										?>
											<tr>
												<td><span class="txt-dark weight-500"><?php echo $emp_detail['employee_number']; ?></span></td>
												<td><?php echo $emp_detail['full_name']; ?></td>
												<td><?php echo ($emp_detail['position_structure']=='S')?$emp_detail['pos_name']:$emp_detail['map_pos_name']; ?></td>
												<td><?php echo $emp_detail['org_name']; ?></td>
												<td><?php echo $emp_detail['location_name']; ?></td>
												<td>
												<?php
												$asessord_count=($ass_pos_count['ass_count']+$ass_pos_count2['ass_counts']);
												if($asessord_count==$empass_pos_count['asscount']){
													echo "<i class='fa fa-check text-success' tittle='Completed'></i>";
												}
												else{
													echo "<i class='fa fa-times text-danger' tittle='InProcess'></i>";
												}
												?></td>
												
											</tr>
										<?php } ?>	
										</tbody>
									</table>
									
								</div>
							</div>
						</div>	
					</div>	
				</div>
			</div>
		</div>
		<div class="col-lg-4 col-md-5 col-sm-12 col-xs-12">
			<div class="panel panel-default card-view panel-refresh">
				<div class="refresh-container">
					<div class="la-anim-1"></div>
				</div>
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Assessors</h6>
					</div>
					
					<div class="clearfix"></div>
				</div>
				<div class="panel-wrapper collapse in">
					<div class="panel-body">
						<ul class="chat-list-wrap">
							<li class="chat-list">
								<div class="chat-body" style="height: 500px;overflow: auto;">
									<?php
									foreach($assessor_details as $key=>$assessor_detail){
									?>
									<div class="chat-data">
										<img class="user-img img-circle" src="https://adani-power.n-compas.com/public/images/male_user.jpg" alt="user">
										<div class="user-data">
											<span class="name block capitalize-font"><?php echo $assessor_detail['full_name']; ?></span>
											<span class="time block truncate txt-grey"><?php echo $assessor_detail['employee_number']; ?></span>
											<span class="time block truncate txt-grey"><?php echo $assessor_detail['location_name']; ?></span>
										</div>
										
										<div class="status away"></div>
										<div class="clearfix"></div>
									</div>
									<hr class="light-grey-hr row mt-10 mb-15">
									<?php } ?>											
								</div>
							</li>
						</ul>
					</div>
				</div>	
			</div>	
		</div>	
	</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-xs-12">
			<div class="panel panel-default card-view panel-refresh">
				<div class="refresh-container">
					<div class="la-anim-1"></div>
				</div>
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Top 5 Training areas</h6>
					</div>
					<div class="clearfix"></div>
				</div>
				
				<?php 
				$comp_details=UlsMenu::callpdo("SELECT b.comp_def_id,b.comp_def_name,s.scale_id,s.scale_name,e.employee_id,e.full_name,avg(sa.scale_number) as ass_ave FROM `uls_assessment_report` a 
				left join (select comp_def_id,comp_def_name from uls_competency_definition group by comp_def_id)b on b.comp_def_id=a.competency_id
				left join (select scale_id,scale_name from uls_level_master_scale group by scale_id)s on  s.scale_id=a.require_scale_id
				left join (select scale_id,scale_name,scale_number from uls_level_master_scale group by scale_id)sa on  sa.scale_id=a.assessed_scale_id
				left join (select employee_id,full_name,employee_number,org_name,position_name from employee_data group by employee_id)e on e.employee_id=a.employee_id
				WHERE a.`parent_org_id`=3 and a.assessed_scale_id is not NULL group by a.`competency_id`,a.`require_scale_id`,a.`employee_id`");
				$comptencies=array();
				foreach($comp_details as $comp_detail){
					$c=$comp_detail['comp_def_id'];
					$e=$comp_detail['employee_id'];
					$l=$comp_detail['scale_id'];
					$comptencies[$c][$l][$e]=$comp_detail['ass_ave'];
				
				}
				
				$comps=array();
				foreach($comptencies as  $k=>$a){
					foreach($a as $l=>$h){
						$comps[$k."-".$l."-".count($h)]=round(array_sum($h)/count($h),1);
					}
				}
				asort($comps);
				//print_r($comps);
					?>
				
			</div>
		</div>
	</div>
	
	<div class="row">
		<?php 
		$limit=1;
		$newArray = array_slice($comps, 0, 5, true);
		foreach($newArray as $key=>$compss){
			$comp_d=explode("-",$key);
			$results=UlsMenu::callpdorow("select b.comp_def_name,c.scale_name from uls_assessment_competencies a
			left join(SELECT `comp_def_id`,`comp_def_name`,comp_def_category FROM `uls_competency_definition`) b on a.assessment_pos_com_id=b.comp_def_id
			left join(SELECT `scale_id`,`scale_number`,`scale_name` FROM `uls_level_master_scale`) c on c.scale_id=a.assessment_pos_level_scale_id
			where a.assessment_pos_com_id=".$comp_d[0]." and a.assessment_pos_level_scale_id=".$comp_d[1]."");
			
		?>
		<div class="col-lg-21 col-md-6 col-sm-6 col-xs-12">
			<div class="panel panel-default card-view bg-blue">
				<div class="panel-wrapper collapse in">
					<div class="panel-body sm-data-box-1">
						<span class="font-14 block txt-light"><?php echo $results['comp_def_name'];?></span>	
						<span class="weight-500 font-14 block txt-light"><?php echo $results['scale_name'];?></span>
						
					</div>
					<div class="clearfix row mt-15 mb-15"></div>
				</div>
			</div>
			<div class="panel panel-default card-view">
				
				<div class="panel-wrapper collapse in">
					<div class="panel-body">
						<div>
							<span class="pull-left inline-block capitalize-font txt-dark">
								Total Employees
							</span>
							<span class="label label-warning pull-right"><a href="#" style="font-color:#000;" data-toggle="modal" data-target="#myModal_emp_<?php echo $comp_d[0];?>_<?php echo $comp_d[1];?>" class=""><?php echo $comp_d[2]; ?></a></span>
							<div class="clearfix"></div>
							<hr class="light-grey-hr row mt-10 mb-10">
							<span class="pull-left inline-block capitalize-font txt-dark">
								Key aspects
							</span>
							<span class="label label-danger pull-right"><a href="#" data-toggle="modal" data-target="#myModal_key" class="txt-light">View</a></span>
							<div class="clearfix"></div>
							<hr class="light-grey-hr row mt-10 mb-10">
							<span class="pull-left inline-block capitalize-font txt-dark">
								Dev Reports
							</span>
							<span class="label label-success pull-right"><a href="#" data-toggle="modal" data-target="#myModal_report" class="txt-light">View</a></span>
							<div class="clearfix  row mt-10 mb-10"></div>
						</div>
					</div>	
				</div>
			</div>
		</div>
		<div id="myModal_emp_<?php echo $comp_d[0];?>_<?php echo $comp_d[1];?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h5 class="modal-title" id="myModalLabel">Employee Details</h5>
					</div>
					<div class="modal-body">
						<h6 class="mb-15"><?php echo $results['comp_def_name'];?></h6>
						<hr class="light-grey-hr row mt-10 mb-10">
						<div style='height: 500px;overflow: auto;'>
						<div class="table-responsive">
							<table class="table table-hover table-bordered mb-0">
								<thead>
									<tr>
										<th>Emp Code</th>
										<th>Emp Name</th>
										<th>Department</th>
										<th>Designation</th>
										<th>Location</th>
									</tr>
								</thead>
								<tbody>
								<?php 
								$empresults=UlsMenu::callpdo("select c.`employee_number`,c.`full_name`,c.`location_id`,c.org_name,c.location_name,s.position_name as map_pos_name,p.position_name as pos_name,p.position_structure from uls_assessment_report a
								left join(SELECT `employee_id`,`employee_number`,`full_name`,`location_id`,org_name,position_name,location_name,position_id FROM `employee_data`) c on c.employee_id=a.employee_id
								left join(SELECT `position_id`,`position_structure`,`position_name`,position_structure_id FROM `uls_position`) p on p.position_id=c.position_id
								left join(SELECT `position_id`,`position_structure`,`position_name`,position_structure_id FROM `uls_position` where position_structure='S') s on s.position_id=p.position_structure_id
								where a.competency_id=".$comp_d[0]." and a.require_scale_id=".$comp_d[1]."");
								foreach($empresults as $empresult){
									$pos_name=($empresult['position_structure']=='S')?$empresult['pos_name']:$empresult['map_pos_name'];
								?>
								
									<tr>
										<td><?php echo $empresult['employee_number']; ?></td>
										<td><?php echo $empresult['full_name']; ?></td>
										<td><?php echo $empresult['org_name']; ?></td>
										<td><?php echo $pos_name; ?></td>
										<td><?php echo $empresult['location_name']; ?></td>
									</tr>
								<?php 
								}
								?>								
								</tbody>
							</table>
						</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<?php 
		}
		?>
	</div>
	
</div>
<div id="myModal_key" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h5 class="modal-title" id="myLargeModalLabel">Large modal</h5>
			</div>
			<div class="modal-body">
				<h5 class="mb-15">Overflowing text to show scroll behavior</h5>
				<p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>
				<p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p>
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
	xmlhttp.open("GET",BASE_URL+"/admin/hr_tobe_assessement?loc_id="+id,true);
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
	xmlhttp.open("GET",BASE_URL+"/admin/hr_assessed_assessement?loc_id="+id,true);
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
</script>
