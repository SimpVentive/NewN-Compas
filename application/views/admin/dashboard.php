<style>
@media (min-width: 768px) {
	.table-responsive{ overflow-x:hidden;}
}
.col-lg-2 {
    width: 20%;
}
</style>
<script>
/**
* Data for Bar chart
*/		
<?php 
$label=$complete=$incomplete=array();;
foreach($graphs as $graph){
	$label[]='"'.$graph['name'].'"';
	$complete[]=$graph['tot'];
	$incomplete[]=!empty($graph['total'])?$graph['total']:0;
} 
?>
var barData = {
	labels: [<?php echo @implode(",",$label); ?>],
	datasets: [
		{
			label: "Completed",
			backgroundColor: "#5489a5",
			borderColor: "#5489a5",
			highlightFill: "#5489a5",
			highlightStroke: "#5489a5",
			borderWidth: 1,
			data: [<?php echo @implode(",",$complete); ?>]
		},
		{
			label: "In Complete",
			backgroundColor: "rgba(220,220,220,0.5)",
			borderColor: "rgba(220,220,220,0.8)",
			highlightFill: "rgba(220,220,220,0.75)",
			highlightStroke: "rgba(220,220,220,1)",                    
			borderWidth: 1,
			data: [<?php echo @implode(",",$incomplete); ?>]
		}
	]
};

<?php 
$label_p=$complete_p=array();;
foreach($pos_department as $pos_departments){
	$label_p[]='"'.$pos_departments['org_name'].'"';
	$complete_p[]=$pos_departments['pos_count'];
} 

?>
var barData_position = {
	labels: [<?php echo @implode(",",$label_p); ?>],
	datasets: [
		{
			label: "Position Count",
			backgroundColor: "#5489a5",
			borderColor: "#5489a5",
			highlightFill: "#5489a5",
			highlightStroke: "#5489a5",
			borderWidth: 1,
			data: [<?php echo @implode(",",$complete_p); ?>]
		}
	]
};
</script>
<div class="content">
<div class="row">
	<div class="col-lg-2 col-md-6 col-sm-12 col-xs-12">
		<a href="<?php echo BASE_URL; ?>/admin/dashboard">
		<div class="panel panel-default card-view pa-0 <?php if(strstr($_SERVER['REQUEST_URI'],'dashboard')){ echo "bg-blue";}?>">
			<div class="panel-wrapper collapse in">
				<div class="panel-body pa-0">
					<div class="sm-data-box">
						<div class="container-fluid">
							<div class="row">
								<div class="col-xs-10 text-center pl-0 pr-0 data-wrap-left">
									<span class="txt-dark block counter font-15 <?php if(strstr($_SERVER['REQUEST_URI'],'dashboard')){ echo "txt-light";}?>" ><span class="">Over All Dashbaord</span></span>
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
<!--<div class="row">
	<div class="col-lg-12 text-center welcome-message">
		<h2>
			Welcome to Competency Management System
		</h2>
	</div>
</div>
<div  class="row">
	<div class="col-lg-12">
		<div class="hpanel success">
			<div class="panel-body">
				<div class="col-sm-12">
					<div class="col-sm-10">
						<h6><a href="#">Introduction</a></h6>
						<p>
							It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum..
						</p>
						<div class="row">
							<div class="col-sm-3">
								<div class="project-label">CLIENT</div>
								<small>Vito Company</small>
							</div>
							<div class="col-sm-3">
								<div class="project-label">VERSION</div>
								<small>3.0.0</small>
							</div>
							<div class="col-sm-3">
								<div class="project-label">DEDLINE</div>
								<small>16.10.2015</small>
							</div>
							<div class="col-sm-3">
								<div class="project-label">PROGRESS</div>
								<div class="progress m-t-xs full progress-small">
									<div style="width: 65%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="65" role="progressbar" class=" progress-bar progress-bar-warning">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-2 project-info">
						<div class="project-action m-t-md">
							<div class="btn-group">
								<button class="btn btn-xs btn-default"> View Presentation</button>
							</div>
						</div>
						
					</div>
					
				</div>
			</div>
		</div>
	</div>
	

</div>-->
<?php //print_r($_SESSION); ?>
<div class="row">
	<div class="col-lg-12 hpanel">
	<div class="panel panel-default card-view panel-refresh relative">
		<div class="panel-heading">
			<div class="pull-left">
				<h6 class="panel-title txt-dark">Employee Type</h6>
			</div>
			<div class="pull-right">
				<!--<select name="employeetype" id="employeetype" onchange="getemployeetype();" class="col-lg-12 form-control m-b">
					<option value=''>Select Employee Type</option>
					<?php foreach($emp_types as $comp){
						$dep_sel=isset($emp_type)?($emp_type==$comp['code'])?"selected='selected'":"":"";
						echo "<option $dep_sel value='".$comp['code']."'>".$comp['name']."</option>";
					} ?>
				</select>-->
			</div>
			<div class="clearfix"></div>
		</div>
		
	</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-6">
        <div class="panel panel-default card-view panel-refresh relative">
			<div class="panel-heading">
				<h6>Jobs / Positions</h6> 
			</div>
			<div class="panel-footer contact-footer">
				
				<div class="row">
					<div class="col-xs-4 text-center">
						<h4 class="mb-10">
						<span class="counts block head-font"><span class="counter-anim label label-info  font-16"><?php echo $positiondet['total']; ?></span></span>
						</h4>
						<span class="counts-text block capitalize-font txt-dark ">Total Jobs/Positions</span>
					</div>
					<div class="col-xs-4 text-center">
						<h4 class="mb-10">
						<span class="counts block head-font"><span class="counter-anim label label-primary  font-16"><?php echo $positiondet['incomplete']; ?></span></span></h4>
						<span class="counts-text block capitalize-font txt-dark">Job / Positions Descriptions</span>
					</div>
					<div class="col-xs-4 text-center">
						<h4 class="mb-10">
						<span class="counts block head-font"><span class="counter-anim label label-warning  font-16"><?php echo $competenctprofile['total']; ?></span></span></h4>
						<span class="counts-text block capitalize-font txt-dark">Competency Profiles</span>
					</div>
				</div>
                
            </div>
			<hr class="light-grey-hr row mt-10 mb-15">
            <div class="panel-body">
			<!--<div id="morris_donut_chart" class="morris-chart donut-chart" ></div>
			<div class="col-sm-6 mb-15 text-center">
				<span id="pie_chart_1" class="easypiechart" data-percent="86">
					<span class="percent head-font">86</span>
				</span>
			</div>
			<div class="col-sm-6 mb-15 text-center">
				<div class="col-sm-4 mb-15 text-center">
					<span id="pie_chart_1" class="easypiechart" data-percent="86">
						<span class="percent head-font">86</span>
					</span>
				</div>
				<div class="col-sm-4 mb-15 text-center">
					<span id="pie_chart_2" class="easypiechart" data-percent="86">
						<span class="percent head-font">86</span>
					</span>
				</div>
			</div>-->
			<script>
			$(document).ready(function(){
				if( $('#pie_chart_1').length > 0 ){
					$('#pie_chart_1').easyPieChart({
						barColor : 'rgba(15, 197, 187,1)',
						lineWidth: 3,
						animate: 3000,
						size:	100,
						lineCap: 'square',
						scaleColor: 'rgba(33,33,33,.1)',
						trackColor: '#fff',
						onStep: function(from, to, percent) {
							$(this.el).find('.percent').text(Math.round(percent));
						}
					});
				}
				if( $('#pie_chart_2').length > 0 ){
					$('#pie_chart_2').easyPieChart({
						barColor : 'rgba(15, 197, 187,1)',
						lineWidth: 3,
						animate: 3000,
						size:	100,
						lineCap: 'square',
						scaleColor: 'rgba(33,33,33,.1)',
						trackColor: '#fff',
						onStep: function(from, to, percent) {
							$(this.el).find('.percent').text(Math.round(percent));
						}
					});
				}
				if($('#morris_donut_chart').length > 0) {
					// Donut Chart
					Morris.Donut({
						element: 'morris_donut_chart',
						data: [{
							label: "Total Jobs/Positions",
							value: 100
						}, {
							label: "Job / Positions Descriptions",
							value: <?php echo (!empty($positiondet['incomplete']))?(round((($positiondet['incomplete'])/ $positiondet['total'])*100,0)):0; ?>
						}, {
							label: "Competency Profiles",
							value:  <?php echo !empty($competenctprofile['total'])?(round((($competenctprofile['total'])/ $positiondet['total'])*100,0)):0; ?>
						}],
						colors: ['#316a89', '#ff7c43', '#ffa600'],
						resize: true,
						formatter:function (value, data) { return value + '%'},
						labelColor: '#878787',
					});
					$("div svg text").attr("style","font-family: Open Sans").attr("font-weight","500");
				}	
			});
			</script>
			<div>
				<canvas id="barOption_position" height=""></canvas>
			</div>
            </div>
        </div>
    </div>
	<div class="col-lg-6">
        <div class="panel panel-default card-view panel-refresh relative">
			<div class="panel-heading">
				<h6>Competencies</h6>
			</div>
            <div class="panel-footer contact-footer">
                <div class="row">
                    <div class="col-xs-4 text-center"> 
						<h4 class="mb-10">
						<span class="counts block head-font"><span class="counter-anim label label-info font-16 "><?php echo $competencies['total']; ?></span></span></h4>
						<span class="counts-text block capitalize-font txt-dark">Total Competencies</span>
					</div>
                    <div class="col-xs-4 text-center">
						<h4 class="mb-10">
						<span class="counts block head-font"><span class="counter-anim label label-primary font-16"><?php echo $competencies['total']-$compincomp['total']; ?></span></span></h4>
						<span class="counts-text block capitalize-font txt-dark">Completed</span>
					</div>
                    <div class="col-xs-4 text-center"> 
						<h4 class="mb-10">
						<span class="counts block head-font"><span class="counter-anim label label-warning font-16"><?php echo $compincomp['total']; ?></span></span></h4>
						<span class="counts-text block capitalize-font txt-dark">In-progress</span>
					</div>
                </div>
            </div>
			<hr class="light-grey-hr row mt-10 mb-15">
			<div class="panel-body">
                <div>
                    <canvas id="barOptions" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<?php
$emptype=isset($emp_type)?$emp_type:"";
if(!empty($sbu) || $_SESSION['security_type']=='no'){ ?>
<div class="row">
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		<h5 class="txt-dark">SBU</h5>
	</div>
</div>
<div class="row">
	<?php 
	
	foreach($bus as $bu){ ?>
	<!--style="cursor:pointer;" onclick="getlocassesspos('<?php echo $emptype; ?>','<?php echo $bu['id']; ?>','')"-->
	<a ><div class="col-md-2">
		<div class="panel panel-default card-view hbggreen">
			<div class="panel-body">
				<div class="text-center">
					<h6><?php echo substr($bu['name'], 0, 15); echo strlen($bu['name'])>25?"...":""; ?></h6>
					<div class="progress progress-xs mb-0 ">
						<div style="width:100%" class="progress-bar progress-bar-warning"></div>
					</div>
					<span class="font-12 head-font txt-dark" >Total no of Locations are 
						<span class="font-20 block counter txt-dark"><span class="counter-anim" ><?php echo !empty($bu['totloc'])?$bu['totloc']:0; ?></span></span></span>
				</div>
			</div>
		</div>
	</div></a>
	<?php } ?>
</div>
<hr>
<?php } ?>
<div id="updateddiv">
	<div class="row">
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<h5 class="txt-dark">Locations</h5>
		</div>
	</div>
	<div class="row">
		<?php foreach($locations as $location){ ?>
		<!--style="cursor:pointer;" onclick="getlocassesspos('<?php echo $emptype; ?>','','<?php echo $location['location_id']; ?>')"-->
		<a><div class="col-md-2">
			<div class="panel panel-default card-view hbggreen">
				<div class="panel-body">
					<div class="text-center">
						<h6><?php echo substr($location['location_name'], 0, 15); echo strlen($location['location_name'])>25?"...":""; ?></h6>
						<div class="progress progress-xs mb-0 ">
							<div style="width:100%" class="progress-bar progress-bar-primary"></div>
						</div>
						<span class="font-12 head-font txt-dark" >Total no of Positions are 
							<span class="font-20 block counter txt-dark"><span class="counter-anim" ><?php echo !empty($location['positions'])?$location['positions']:0; ?></span></span></span>
					</div>
				</div>
			</div>
		</div></a>
		<?php } ?>
	</div>
	<div id="updateddivloc">
		<div class="row">
			<?php $colsize="col-lg-12"; if(empty($emp_type)){ $colsize="col-lg-8"; ?>
			<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
				<div class="panel panel-default border-panel card-view">
					<div class="panel-heading">
						<div class="pull-left">
							<h6 class="panel-title pull-left">Assessors</h6>
						</div>
						
						<div class="clearfix"></div>
					</div>
					<div class="panel-wrapper collapse in">
						<div class="panel-body row pa-0">
							<!--<div class="chat-cmplt-wrap chat-for-widgets">
								<div class="chat-box-wrap">
									<div>
										
									</div>
								</div>
							</div>-->
							<div  class="tab-struct custom-tab-2 mt-40">
								<ul role="tablist" class="nav nav-tabs" id="myTabs_15">
									<li class="active" role="presentation"><a aria-expanded="true"  data-toggle="tab" role="tab" id="home_tab_15" href="#home_15" style="font-size:14px;">Internal Assessors</a></li>
									<li role="presentation" class=""><a  data-toggle="tab" id="profile_tab_15" role="tab" href="#profile_15" aria-expanded="false" style="font-size:14px;">External Assessors</a></li>
									
								</ul>
								<div class="tab-content" id="myTabContent_15">
									<div  id="home_15" class="tab-pane fade active in" role="tabpanel">
										<div class="users-nicescroll-bar">
											<ul class="chat-list-wrap">
												<li class="chat-list">
													<div class="chat-body">
														<?php foreach($assessors_int as $assessor){ ?>
															<div class="chat-data">
																<img class="user-img img-circle"  src="<?php echo BASE_URL; ?>/public/images/male_user.jpg" alt="user"/>
																<div class="user-data">
																	<span class="name block capitalize-font"><?php echo $assessor['full_name']; ?></span>
																	<span class="time block truncate txt-grey"><?php echo $assessor['email']; ?></span>
																	<span class="time block truncate txt-grey"><?php echo $assessor['assessor_type']=='INT'?'Internal':'External'; ?></span>
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
									<div  id="profile_15" class="tab-pane fade" role="tabpanel">
										<div class="users-nicescroll-bar">
											<ul class="chat-list-wrap">
												<li class="chat-list">
													<div class="chat-body">
														<?php foreach($assessors_ext as $assessor){ ?>
															<div class="chat-data">
																<img class="user-img img-circle"  src="<?php echo BASE_URL; ?>/public/images/male_user.jpg" alt="user"/>
																<div class="user-data">
																	<span class="name block capitalize-font"><?php echo $assessor['assessor_name']; ?></span>
																	<span class="time block truncate txt-grey"><?php echo $assessor['assessor_email']; ?></span>
																	<span class="time block truncate txt-grey"><?php echo $assessor['assessor_type']=='INT'?'Internal':'External'; ?></span>
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
				</div>
			</div>
		<?php } ?>
		<div class="<?php echo $colsize; ?>">
			<div class="panel panel-default card-view panel-refresh relative">
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Assessment Cycles</h6>
					</div>
					<div class="pull-right">
						<select name="year" id="year" onchange="getassessyr('<?php echo $emptype; ?>','','');" class="col-lg-12 form-control m-b">
							<option value=''>Select Year</option>
							<?php $years=array("2015","2016","2017","2018","2019","2020","2021"); 
							foreach($years as $year){
								//$dep_sel=isset($emp_type)?($emp_type==$comp['code'])?"selected='selected'":"":"";
								echo "<option  value='".$year."'>".$year."</option>";
							} ?>
						</select>
					</div>
					<div class="clearfix"></div>
				</div>
					<div class="panel-wrapper collapse in">
						<div class="panel-body" style="height: 400px;overflow-y: auto;">
							<div class="table-wrap">
								<div class="table-responsive" id="assesstable">
									<table id="datable_2" class="table table-bordered" >
										<thead>
										<tr>
											<th class="col-sm-4">Assessment Name</th>
											<th class="col-sm-2">Positions covered</th>
											<th class="col-sm-2">Initiated Date</th>
											<th class="col-sm-2">Intitiated for</th>
											<!--<th class="col-sm-2">Percentage Completed</th>-->
										</tr>
										</thead>
										<tbody>
										<?php
										$total_per=0;
										foreach($assessments as $assessment){ 
										$pos_count=UlsPosition::pos_stru_count_details($assessment['pos_id']);?>
										<tr>
											<td><?php echo $assessment['assessment_name']; ?>&nbsp;&nbsp;<span data-toggle="tooltip" data-placement="top" title="<?php echo $assessment['assessment_desc'];?>"><i class="fa fa-question-circle-o">  </i></span></td>
											<td><a onclick="getasesspos(<?php echo $assessment['assessment_id']; ?>);" style="color:blue;cursor: pointer;" data-toggle="modal" data-target=".bs-example-modal-lg"><?php echo !empty(count($pos_count))?count($pos_count):"-"; ?></a></td>
											<td><?php echo date("d-m-Y",strtotime($assessment['start_date'])); ?></td>
											<td><a onclick="getasessposemp(<?php echo $assessment['assessment_id']; ?>);" style="color:blue;cursor: pointer;" data-toggle="modal" data-target=".bs-example-modal-lg">Emp Count:<?php echo $assessment['employees']!=0?$assessment['employees']:0; ?></a></td>
											<!--<td>
											<?php 
											$total_per=!empty($assessment['employees'])?round((($assessment['ass_emp']/$assessment['employees'])*100),2):"";
											?>
											<a style="color:blue;cursor: pointer;"><?php echo !empty($total_per)?$total_per."%":""; ?></a></td>-->
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
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-default card-view">
					<div class="panel-heading">
						<div class="pull-left">
							<h6 class="panel-title txt-dark">Position Statistics</h6>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="panel-wrapper collapse in">
						<div class="panel-body">
							<div class="table-wrap">
								<div class="table-responsive">
									<table id="datable_1" class="table table-bordered" >
										<thead>
											<tr>
												<th>Position</th>
												<th>Purpose</th>
												<th>Accountabilities</th>
												<th>Experience</th>
												<th>Industry Experience</th>
												<th>Competency Profile</th>
												<th>KRA's</th>
											</tr>
										</thead>
										
										<tbody>
										<?php 
										foreach($position_info as $position_infos){
										?>
										<tr>
											<td><a onclick="getposdet(<?php echo $position_infos['position_id']; ?>)" style="color:blue;cursor: pointer;" data-toggle="modal" data-target=".bs-example-modal-lg"><?php echo $position_infos['position_name']; ?></a></td>
											
											<td><?php echo !empty($position_infos['position_desc'])?"Yes <i class='fa fa-check text-success'></i>":"No <i class='fa fa-times text-danger'></i>" ?></td>
											<td><?php echo !empty($position_infos['accountablities'])?"Yes <i class='fa fa-check text-success'></i>":"No <i class='fa fa-times text-danger'></i>" ?></td>
											<td><?php echo !empty($position_infos['experience'])?"Yes <i class='fa fa-check text-success'></i>":"No <i class='fa fa-times text-danger'></i>" ?></td>
											<td><?php echo !empty($position_infos['specific_experience'])?"Yes <i class='fa fa-check text-success'></i>":"No <i class='fa fa-times text-danger'></i>" ?></td>
											<td><?php echo !empty($position_infos['conp_profile'])?"Yes <i class='fa fa-check text-success'></i>":"No <i class='fa fa-times text-danger'></i>" ?></td>
											<td><?php echo !empty($position_infos['kra'])?"Yes <i class='fa fa-check text-success'></i>":"No <i class='fa fa-times text-danger'></i>" ?></td>
										</tr>
										<?php
										}
										?>	
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>	
			</div>
		</div>
	</div>
</div>
<?php /*<div class="row ">
	<div class="col-lg-12 hpanel">
	<div class="panel panel-default card-view panel-refresh relative">
		<div class="panel-heading">
			<div class="pull-left">
				<h6 class="panel-title txt-dark">Assessment Methods </h6>
			</div>
			<div class="pull-right">
				<select name="competencies" id="competencies" onchange="getassementques();" class="col-lg-12 form-control m-b">
					<option value=''>Select Competencies</option>
					<?php if(isset($competency)){ foreach($competency as $comp){
						echo "<option value='".$comp['id']."'>".$comp['name']."</option>";
					} } else{ ?>
						<optgroup label="MS">
						<?php foreach($competencymsdetails as $competencydetail){ ?>
							<option value="<?php echo $competencydetail['comp_def_id']; ?>" ><?php echo $competencydetail['comp_def_name'];?></option>
						<?php
						}
						?>
						</optgroup>
						<optgroup label="NMS">
						<?php foreach($competencynmsdetails as $competencydetail){ ?>
							<option value="<?php echo $competencydetail['comp_def_id']; ?>"  ><?php echo $competencydetail['comp_def_name'];?></option>
						<?php
						}
						?>
						</optgroup>
					<?php } ?>
				</select>
				
			</div>
			<div class="clearfix"></div>
		</div>
		
	</div></div>
</div>


<div id="dashboarddata">
	<div class="row">
		<?php
		$tests=$questionbanks['mcq'];
		if(empty($tests)){
			$color="style='color:#ccc !important;'";
			$width="style='width: 0%'";
		}
		else{
			$color="";
			$width="style='width: 100%'";
		}
		?>
		<div class="col-md-3">
			<div class="panel panel-default card-view hbggreen">
				<div class="panel-body">
					<div class="text-center">
						<h3 <?php echo $color; ?>>Questions</h3>
						<div class="progress progress-xs mb-0 ">
							<div <?php echo $width; ?> class="progress-bar progress-bar-primary"></div>
						</div>
						<span class="font-20 block counter txt-dark"><span class="counter-anim label label-danger" <?php echo $color; ?>><?php echo $questions['mcq']; ?></span></span></span>
						
						<span class="font-12 head-font txt-dark" <?php echo $color; ?>>Total no of Question bank are 
						<span class="font-20 block counter txt-dark"><span class="counter-anim" <?php echo $color; ?>><?php echo $questionbanks['mcq']; ?></span></span></span>
						
					</div>
				</div>
			</div>
		</div>
		<?php
		$cases=$questionbanks['cases'];
		if(empty($cases)){
			$color="style='color:#ccc !important;'";
			$width="style='width: 0%'";
		}
		else{
			$color="";
			$width="style='width: 100%'";
		}
		?>
		<div class="col-md-3">
			<div class="panel panel-default card-view hbggreen">
				<div class="panel-body">
					<div class="text-center">
						<h3 <?php echo $color; ?>>Case studies</h3>
						<div class="progress progress-xs mb-0 ">
							<div <?php echo $width; ?> class="progress-bar progress-bar-primary"></div>
						</div>
						<span class="font-20 block counter txt-dark"><span class="counter-anim  label label-danger" <?php echo $color; ?>><?php echo $questions['cases']; ?></span></span></span>
						<span class="font-12 head-font txt-dark" <?php echo $color; ?>>Total no of Case studies are 
						<span class="font-20 block counter txt-dark"><span class="counter-anim" <?php echo $color; ?>><?php echo $questionbanks['cases']; ?></span></span></span>
						
					</div>
				</div>
			</div>
		</div>
		<?php
		$inbaskets=$questionbanks_inbasket['q_bank'];
		if(empty($inbaskets)){
			$color="style='color:#ccc !important;'";
			$width="style='width: 0%'";
		}
		else{
			$color="";
			$width="style='width: 100%'";
		}
		?>
		<div class="col-md-3">
			<div class="panel panel-default card-view hbggreen">
				<div class="panel-body">
					<div class="text-center">
						<h3 <?php echo $color; ?>>In-Baskets</h3>
						<div class="progress progress-xs mb-0 ">
							<div <?php echo $width; ?> class="progress-bar progress-bar-primary"></div>
						</div>
						<span class="font-20 block counter txt-dark"><span class="counter-anim  label label-danger" <?php echo $color; ?>><?php echo $question_inbasket['ques']; ?></span></span></span>
						
						<span class="font-12 head-font txt-dark" <?php echo $color; ?>>Total no of In-Basket are
						<span class="font-20 block counter txt-dark"><span class="counter-anim" <?php echo $color; ?>><?php echo $questionbanks_inbasket['q_bank']; ?></span></span></span>
					</div>
				</div>
			</div>
		</div>
		<?php
		$interviews=$questionbanks['interview'];
		if(empty($interviews)){
			$color="style='color:#ccc !important;'";
			$width="style='width: 0%'";
		}
		else{
			$color="";
			$width="style='width: 100%'";
		}
		?>
		<div class="col-md-3">
			<div class="panel panel-default card-view hbggreen">
				<div class="panel-body">
					<div class="text-center">
						<h3 <?php echo $color; ?>>Interviews</h3>
						<div class="progress progress-xs mb-0 ">
							<div <?php echo $width; ?> class="progress-bar progress-bar-primary"></div>
						</div>
						<span class="font-20 block counter txt-dark"><span class="counter-anim  label label-danger" <?php echo $color; ?>><?php echo $questions['interview']; ?></span></span></span>
						<span class="font-12 head-font txt-dark" <?php echo $color; ?>>Total no of Interviews are
						<span class="font-20 block counter txt-dark"><span class="counter-anim" <?php echo $color; ?>><?php echo $questionbanks['interview']; ?></span></span></span>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

        <?php /*<div class="row">
            <div class="col-md-3">
                <div class="hpanel">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Competencies</th>
                                    <th>Count</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <span class="text-success font-bold">Production Technology</span>
                                    </td>
                                    <td>50</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-success font-bold">Instrumentation & Controls</span>
                                    </td>
                                    <td>30</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-success font-bold">Research & Development </span>
                                    </td>
                                    <td>20</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-3">
                <div class="hpanel">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Competencies</th>
                                    <th>Count</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <span class="text-success font-bold">Production Technology</span>
                                    </td>
                                    <td>50</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-success font-bold">Instrumentation & Controls</span>
                                    </td>
                                    <td>30</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-success font-bold">Research & Development </span>
                                    </td>
                                    <td>20</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-3">
                <div class="hpanel">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Competencies</th>
                                    <th>Count</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <span class="text-success font-bold">Production Technology</span>
                                    </td>
                                    <td>50</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-success font-bold">Instrumentation & Controls</span>
                                    </td>
                                    <td>30</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-success font-bold">Research & Development </span>
                                    </td>
                                    <td>20</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-3">
                <div class="hpanel">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Competencies</th>
                                    <th>Count</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <span class="text-danger font-bold">Lorem ipsum</span>
                                    </td>
                                    <td>Jul 14, 2013</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-danger font-bold">Lorem ipsum</span>
                                    </td>
                                    <td>Jul 09, 2015</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-danger font-bold">Lorem ipsum</span>
                                    </td>
                                    <td>Jul 24, 2014</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
		</div> */ ?>
		

</div>
<!-- sample modal content -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h5 class="modal-title" id="myLargeModalLabel">Competency attached Positions</h5>
			</div>
			<div class="modal-body">
				<h5 class="mb-15" id="followdes">Following are the Positions</h5>
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
<!-- /.modal -->

<?php 

if(!empty($_SESSION['pop_id'])){
?>
<div class="modal fade bs-example-modal-lg in" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabelnew" aria-hidden="true" style="display: block;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form id="org_master" action="<?php echo BASE_URL;?>/admin/employee_type_details" method="post" enctype="multipart/form-data">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h5 class="modal-title" id="myLargeModalLabel">Employee Selection</h5>
			</div>
			<div class="modal-body">
				<div id="txtHint" style="margin: 15px;">
					<div class="panel-body">
						<p class="text-muted"> This portal has information on Competency/Skill for employees across your various categories – ie NMS (Non Management Staff) and MS (Management Staff).  To ease your navigation, you can choose the category of people, whose information you want to view.</p>
						<div class="row mt-40">
							<div class="col-sm-12">
								<div class="radio">
									<input type="radio" value="MS" id="radio1" name="data_radio">
									<label for="radio1"> Management Staff (MS) </label>
								</div>
								<div class="radio">
									<input type="radio" value="NMS" id="radio2" name="data_radio">
									<label for="radio1"> Non Management (NMS)</label>
								</div>
								<div class="radio">
									<input type="radio" value="Both" id="radio2" name="data_radio">
									<label for="radio1"> Both (NMS and MS)</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm" type="submit" name="save" id="save"> Proceed</button>
			</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<?php
}
?>