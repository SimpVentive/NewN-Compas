<style>
.col-lg-2 {
    width: 20%;
}
</style>
<div class="row">
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
		<div class="panel panel-default card-view pa-0 <?php if(strstr($_SERVER['REQUEST_URI'],'assessor_dashboard')){ echo "bg-blue";}?>">
			<div class="panel-wrapper collapse in">
				<div class="panel-body pa-0">
					<div class="sm-data-box">
						<div class="container-fluid">
							<div class="row">
								<div class="col-xs-10 text-center pl-0 pr-0 data-wrap-left">
									<span class="txt-dark block counter font-15 <?php if(strstr($_SERVER['REQUEST_URI'],'assessor_dashboard')){ echo "txt-light";}?>"><span class="">Assessor Dashbaord</span></span>
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
	<div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
		<div class="panel panel-default card-view panel-refresh">
			<div class="refresh-container">
				<div class="la-anim-1"></div>
			</div>
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark">Assessor Status</h6>
				</div>
				
				<div class="clearfix"></div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div id="morris_extra_bar_chart" class="morris-chart" style="height:310px;"></div>
				<?php 
				$ext_year=UlsMenu::callpdo("SELECT count(distinct(a.assessor_id)) as ext_count,a.created_date,group_concat(distinct(a.assessor_id)) FROM `uls_assessment_position_assessor` a
				WHERE 1 and a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.assessor_type='EXT'  group by YEAR(a.created_date)");
				$int_year=UlsMenu::callpdo("SELECT count(distinct(a.assessor_id)) as int_count,a.created_date,group_concat(distinct(a.assessor_id)) FROM `uls_assessment_position_assessor` a
				WHERE 1 and a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.assessor_type='INT'  group by YEAR(a.created_date)");
				$status=array();
				if(count($int_year)>0){
					foreach($int_year as $key=>$int_years){
						$status[$key]['y']=date("Y",strtotime($int_years['created_date']));
						$status[$key]['a']=(int)$int_years['int_count'];
					}
				}
				
				if(count($ext_year)>0){
					foreach($ext_year as $key=>$ext_years){
						$status[$key]['y']=date("Y",strtotime($ext_years['created_date']));
						$status[$key]['b']=(int)$ext_years['ext_count'];
					}
				}					
				/* echo "<pre>";
				print_r($status); */
				//echo json_encode($status);
				?>
				<script>
				
				$(document).ready(function(){
					if($('#morris_extra_bar_chart').length > 0) {
						// Donut Chart
						Morris.Bar({
							element: 'morris_extra_bar_chart',
							dataType: "json",
							data: <?php  echo json_encode($status);?>,
							xkey: 'y',
							ykeys: ['a', 'b'],
							labels: ['Internal Assessors', 'External Assessors'],
							barColors:['#8BC34A', '#f8b32d'],
							barOpacity:1,
							hideHover: 'auto',
							grid: false,
							resize: true,
							barSize: 50,
							gridTextColor:'#878787',
							gridTextFamily:"Open Sans"
						});
					}	
				});
			</script>
			</div>
		</div>
	</div>
	<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
		<div class="panel card-view">
			<div class="panel-heading small-panel-heading relative">
				<div class="pull-left">
					<h6 class="panel-title txt-dark">Internal Assessors</h6>
				</div>
				<div class="clearfix"></div>
			</div>		
			<div class="panel-wrapper collapse in">
				<div class="panel-body row pa-0">
					<div class="sm-data-box">
						<div class="container-fluid">
							<div class="row" style="height:140px;">
								<a onclick="open_internal();" data-toggle="modal" data-target=".bs-example-modal-lg1" style="cursor: pointer;">
								<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
									<span class="block"><i class="zmdi zmdi-trending-up txt-success font-18 mr-5"></i><span class="weight-500 uppercase-font">Total Number</span></span>
									<span class="block counter txt-dark"><span class="counter-anim"><?php echo count($ass_int); ?></span></span>
								</div>
								<div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
									<i class="icon-user-following data-right-rep-icon txt-light-grey"></i>
								</div>
								</a>
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade bs-example-modal-lg1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h5 class="modal-title" id="myLargeModalLabel">Internal Assessors</h5>
					</div>
					<div class="modal-body">
						<div id="internal_results"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger text-left" data-dismiss="modal">Close</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		
		<div class="panel card-view">
			<div class="panel-heading small-panel-heading relative">
				<div class="pull-left">
					<h6 class="panel-title">External Assessors</h6>
				</div>
				<div class="clearfix"></div>
			</div>		
			<div class="panel-wrapper collapse in">
				<div class="panel-body row pa-0">
					<div class="sm-data-box">
						<div class="container-fluid">
							<div class="row" style="height:140px;">
							<a onclick="open_external()" data-toggle="modal" data-target=".bs-example-modal-lg" style="cursor: pointer;">
								<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
									<span class="block"><i class="zmdi zmdi-trending-up txt-success font-18 mr-5"></i><span class="weight-500 uppercase-font">Total Number</span></span>
									<span class="txt-dark block counter"><span class="counter-anim"><?php echo count($ass_ext); ?></span></span>
								</div>
								<div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
									<i class="icon-user-following data-right-rep-icon txt-light-grey"></i>
								</div>
							</a>
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h5 class="modal-title" id="myLargeModalLabel">External Assessors</h5>
					</div>
					<div class="modal-body">
						<div id="external_results"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger text-left" data-dismiss="modal">Close</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		
	</div>
</div>
<div class="row">
   <div class="col-lg-12">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark">Locations</h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div  class="panel-body">
					<div class="">
						<div id="owl_demo_2" class="owl-carousel owl-theme">
							<?php 
							foreach($loc_details as $loc_detail){
								$ass_count=UlsMenu::callpdorow("SELECT count(DISTINCT(a.`assessor_id`)) as ass_count FROM `uls_assessment_position_assessor` a
								left join(SELECT `assessor_id`,`employee_id`,`assessor_name`,assessor_type FROM `uls_assessor_master`) b on b.assessor_id=a.assessor_id
								left join(SELECT `employee_id`,`employee_number`,`full_name`,`location_id` FROM `employee_data`) c on c.employee_id=b.employee_id
								WHERE 1 and b.assessor_type='INT' and c.location_id=".$loc_detail['location_id']);
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
												<span class="font-20 block counter txt-dark"><span class="counter-anim" ><?php echo $ass_count['ass_count']; ?></span></span></span>
										</div>
									</div>
								</div>
							</div>
							</a>
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
<div id="result_data">
<div class="row">
   <div class="col-lg-12">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark">Assessors</h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div  class="panel-body">
					<div class="">
						<div id="owl_demo_4" class="owl-carousel owl-theme">
							<?php 
							foreach($ass_int as $key=>$ass_ints){
							?>
							<div class="item">
								<a onclick="open_assessor_assessment(<?php echo $ass_ints['location_id'];?>,<?php echo $ass_ints['assessor_id']; ?>);" style='cursor: pointer;'>
								<div class="panel panel-default card-view hbggreen">
									<div class="panel-body">
										<div class="text-center">
											<h6 class="font-11"><?php echo $ass_ints['assessor_name']; ?></h6>
											<div class="progress progress-xs mb-0 ">
												<div style="width:100%" class="progress-bar progress-bar-primary"></div>
											</div>
											<?php 
											$ass_pos_count2=UlsMenu::callpdorow("SELECT count(b.employee_id) as ass_counts FROM `uls_assessment_position_assessor` a
											left join(SELECT `employee_id`,`assessment_id`,`position_id` FROM `uls_assessment_employees`) b on a.assessment_id=b.assessment_id and a.position_id=b.position_id
											 WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.assessor_id=".$ass_ints['assessor_id']." and a.assessor_type='INT' and (a.assessor_per is NULL || a.assessor_per='N')");
											$ass_pos_count1=UlsMenu::callpdorow("SELECT group_concat(emp_ids) as ass_count FROM `uls_assessment_position_assessor` WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and assessor_id=".$ass_ints['assessor_id']." and assessor_type='INT' and (assessor_per is NULL || assessor_per='Y')");
											$yes_array=explode(",",$ass_pos_count1['ass_count']);
											$total_emp_count=($ass_pos_count2['ass_counts']+count($yes_array));
											?>
											<span class="font-10 head-font txt-dark" >Total no of Employees mapped 
												<span class="font-18 block counter txt-dark"><span class="counter-anim" ><?php echo $total_emp_count; ?></span></span></span>
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

<script>
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
						items:8
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

function open_assessor_assessment_employees(assm_id,id,loc_id){
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
			
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/assessor_mapped_assessment_details?assm_id="+assm_id+"&loc_id="+loc_id+"&ass_id="+id,true);
	xmlhttp.send();	
	
}

function open_internal(){
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
			document.getElementById('internal_results').innerHTML=xmlhttp.responseText;
			
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/assessor_internal_details",true);
	xmlhttp.send();	
	
}

function open_external(){
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
			document.getElementById('external_results').innerHTML=xmlhttp.responseText;
			
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/assessor_external_details",true);
	xmlhttp.send();	
	
}

</script>
		