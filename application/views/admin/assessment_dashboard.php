<style>
@media (min-width: 768px) {
	.table-responsive{ overflow-x:hidden;}
}
#container {
    max-width: 800px;
    height: 115px;
    margin: 1em auto;
}
.highcharts-figure, .highcharts-data-table table {
    min-width: 320px;
    max-width: 700px;
    margin: 1em auto;
}

.highcharts-data-table table {
	font-family: Verdana, sans-serif;
	border-collapse: collapse;
	border: 1px solid #EBEBEB;
	margin: 10px auto;
	text-align: center;
	width: 100%;
	max-width: 500px;
}
.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}
.highcharts-data-table th {
	font-weight: 600;
    padding: 0.5em;
}
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
    padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}
.highcharts-data-table tr:hover {
    background: #f1f7ff;
}
.col-lg-2 {
    width: 20%;
}
</style>

<div class="content">
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
		<div class="panel panel-default card-view pa-0 <?php if(strstr($_SERVER['REQUEST_URI'],'assessment_dashboard')){ echo "bg-blue";}?>">
			<div class="panel-wrapper collapse in">
				<div class="panel-body pa-0">
					<div class="sm-data-box">
						<div class="container-fluid">
							<div class="row">
								<div class="col-xs-10 text-center pl-0 pr-0 data-wrap-left">
									<span class="txt-dark block counter font-15 <?php if(strstr($_SERVER['REQUEST_URI'],'assessment_dashboard')){ echo "txt-light";}?>"><span class="">Assessment Dashbaord</span></span>
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
	<div class="row">
		<div class="col-lg-12">
			 <div class="panel panel-default card-view">
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Search Parameters</h6>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-wrapper collapse in">
				
					<div class="panel-body">
						<div class="col-md-12">
							<div class="col-lg-3">
								<div class="panel-heading">
									<div class="pull-left col-lg-4">
										<h6 class="panel-title txt-dark">Year :</h6>
									</div>
									<div class="pull-left">
										<?php
										$date = date("Y");
										$date_range = range($date-2, $date+2);
										?>
										<select name="ass_year" id="ass_year" onchange="assessement_year();" class="col-lg-12 form-control m-b">
											<option value=''>Select Year</option>
											<?php foreach($date_range as $date_ranges){
												$select=isset($_REQUEST['year_id'])?(($_REQUEST['year_id']==$date_ranges)?"selected='selected'":""):"";
											?>
											<option value="<?php echo $date_ranges; ?>" <?php echo $select; ?>><?php echo $date_ranges; ?></option>
											<?php
											} ?>
										</select>
									</div>
									<div class="clearfix"></div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="panel-heading">
									<div class="pull-left col-lg-4">
										<h6 class="panel-title txt-dark">Assessment Name :</h6>
									</div>
									<div class="pull-left">
										
										<select name="assessement_name[]" id="assessement_name" class="col-lg-12" multiple="multiple" data-placeholder="Choose" onchange="assessment_details();" style="width:150%">
										<?php
										if(isset($_REQUEST['year_id'])){
										?>
											<optgroup label='Assessment Cycles'>
											<?php
											foreach($assessments as $assessment){
											$zone=isset($_REQUEST['ass_id'])?explode(",",$_REQUEST['ass_id']):array();
											$program_sel=in_array($assessment['assessment_id'],$zone)?"selected='selected'":"";
											?>
											<option value='<?php echo $assessment['assessment_id'];?>' <?php echo $program_sel; ?>><?php echo $assessment['assessment_name'];?></option>	
											<?php
											}
											?>	
											</optgroup>
										<?php 
										}
										?>
										</select>
									</div>
									<div class="clearfix"></div>
								</div>
							</div>
						</div>
						
					</div>
				
				</div>
			</div>
		</div>
	</div>
	
<?php 
if(!empty($ass_id)){
?>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				<?php 
				$ass_idss=explode(",",$_REQUEST['ass_id']);
				foreach($ass_idss as $ass_ids){
					$ass_name=UlsAssessmentDefinition::viewassessment($ass_ids);
				?>
				<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1">
					<thead>
						<tr>
							<th style=" background-color: #edf3f4;width:20%">Assessment Name:</th>
							<th><?php echo $ass_name['assessment_name']; ?>&nbsp;</th>
						</tr>
						<tr>
							<th style=" background-color: #edf3f4;width:20%">Assessment Description:</th>
							<th><?php echo $ass_name['assessment_desc']; ?>&nbsp;</th>
						</tr>
					
					</thead>
				</table>
				<br>
				<?php } ?>	
			</div>
		</div>
	</div>
			 
	<div class="row">
		<div class="col-lg-12">
			 <div class="panel panel-default card-view">
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Search Parameters</h6>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-wrapper collapse in">
					<input type="hidden" name="year_id" id="year_id" value="<?php echo $_REQUEST['year_id']; ?>">
					<input type="hidden" name="ass_id" id="ass_id" value="<?php echo $_REQUEST['ass_id']; ?>">
					<div class="panel-body">
						<div class="col-md-12">
							<div class="form-group col-lg-3">
								<label class="control-label mb-10 text-left">Departments</label>
								<select name="organization_id" id="organization_id" onchange="get_organisation_type();"  class="col-lg-12 form-control m-b">
									<option value=''>Select Departments</option>
									<?php
									
									foreach($dep_details as $dep_detail){
										$dep_select=isset($organization_id)?(($dep_detail['org_id']==$organization_id)?"selected='selected'":""):"";
									?>
									<option value="<?php echo $dep_detail['org_id']; ?>" <?php echo $dep_select; ?>><?php echo $dep_detail['org_name']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
							<div class="form-group col-lg-3">
								<label class="control-label mb-10 text-left">Grades</label>
								<select name="grade_id" id="grade_id" class="col-lg-12 form-control m-b" onchange="get_organisation_type();">
									<option value=''>Select Grades</option>
									<?php
									
									foreach($grade_details as $grade_detail){
										$grade_select=isset($grade_id)?(($grade_detail['grade_id']==$grade_id)?"selected='selected'":""):"";
									?>
									<option value="<?php echo $grade_detail['grade_id']; ?>" <?php echo $grade_select; ?>><?php echo $grade_detail['grade_name']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
							<div class="form-group col-lg-3">
								<label class="control-label mb-10 text-left">Positons</label>
								<select name="position_id" id="position_id" class="col-lg-12 form-control m-b" onchange="get_organisation_type();">
									<option value=''>Select Position</option>
									<?php
									
									foreach($pos_names as $pos_name){
										$grade_select=isset($position_id)?(($pos_name['position_id']==$position_id)?"selected='selected'":""):"";
									?>
									<option value="<?php echo $pos_name['position_id']; ?>" <?php echo $grade_select; ?>><?php echo $pos_name['position_name']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
							<div class="form-group col-lg-3">
								<label class="control-label mb-10 text-left">Location</label>
								<select name="location_id" id="location_id" class="col-lg-12 form-control m-b" onchange="get_organisation_type();">
									<option value=''>Select Location</option>
									<?php
									
									foreach($loc_details as $loc_detail){
										$loc_select=isset($location_id)?(($loc_detail['location_id']==$location_id)?"selected='selected'":""):"";
									?>
									<option value="<?php echo $loc_detail['location_id']; ?>" <?php echo $loc_select; ?>><?php echo $loc_detail['location_name']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
						
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
						<h6 class="panel-title txt-dark">Employee Details</h6>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-wrapper collapse in">
					<div  class="panel-body">
						<div class="">
							<div id="owl_demo_2" class="owl-carousel owl-theme">
							<?php
							if(!empty($emp_details)){
							foreach($emp_details as $emp_detail){
							?>
								<div class="item">
									<a href="<?php echo BASE_URL; ?>/index/ass_position_emp?ass_type=ASS&ass_id=<?php echo $emp_detail['assessment_id'];?>&pos_id=<?php echo $emp_detail['position_id'];?>&emp_id=<?php echo $emp_detail['employee_id'];?>" target="_blank">
									<img src="<?php echo BASE_URL;?>/public/images/male_user.jpg" alt="Owl Image" style="width:50%">
									<div class="panel-body">
										<p><?php echo $emp_detail['employee_number'];?></p>
										<label class="control-label mb-10 text-left"><?php echo $emp_detail['full_name'];?></label>
									</div>
									</a>
									
								</div>
							<?php }
							}
							?>
							</div>
						 </div>
					</div>
				</div>
			</div>	
		</div>
	</div>
					
	<div class="row">
		<div class="col-lg-12">
			 <div class="panel panel-default card-view">
				<div class="row">
					<div class="col-md-2">
						<div class="panel panel-default card-view hbggreen">
							<div class="panel-body">
								<div class="text-center">
									<h6>Locations</h6>
									<div class="progress progress-xs mb-0 ">
										<div style="width:100%" class="progress-bar progress-bar-warning"></div>
									</div>
									<span class="font-12 head-font txt-dark" ># of Locations are 
										<span class="font-20 block counter txt-dark"><span class="counter-anim" ><?php echo !empty($locations['count_loc'])?$locations['count_loc']:0; ?></span></span></span>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-2">
						<div class="panel panel-default card-view hbggreen">
							<div class="panel-body">
								<div class="text-center">
									<h6>Unique Competencies</h6>
									<div class="progress progress-xs mb-0 ">
										<div style="width:100%" class="progress-bar progress-bar-warning"></div>
									</div>
									<span class="font-12 head-font txt-dark" ># of Competencies are  
										<span class="font-20 block counter txt-dark"><span class="counter-anim" ><?php echo !empty($comp_f['countcom'])?$comp_f['countcom']:0; ?></span></span></span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="panel panel-default card-view hbggreen">
							<div class="panel-body">
								<div class="text-center">
									<h6>Positions (<?php echo !empty($position_f['countpoc'])?$position_f['countpoc']:0; ?>)</h6>
									<div class="progress progress-xs mb-0 ">
										<div style="width:100%" class="progress-bar progress-bar-warning"></div>
									</div>
									<span class="font-12 head-font txt-dark" ># of Positions used are 
										<span class="font-20 block counter txt-dark"><span class="counter-anim" ><?php echo !empty($position_taken['taken_pos'])?$position_taken['taken_pos']:0; ?></span></span></span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="panel panel-default card-view hbggreen">
							<div class="panel-body">
								<div class="text-center">
									<h6>Employees (<?php echo !empty($comp_emp['countemp'])?$comp_emp['countemp']:0; ?>)</h6>
									<div class="progress progress-xs mb-0 ">
										<div style="width:100%" class="progress-bar progress-bar-warning"></div>
									</div>
									<span class="font-12 head-font txt-dark" ># of Employees are 
										<span class="font-20 block counter txt-dark"><span class="counter-anim" ><?php echo !empty($emp_taken['taken_emp'])?$emp_taken['taken_emp']:0; ?></span></span></span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="panel panel-default card-view hbggreen">
							<div class="panel-body">
								<div class="text-center">
									<h6>Assessors</h6>
									<div class="progress progress-xs mb-0 ">
										<div style="width:100%" class="progress-bar progress-bar-warning"></div>
									</div>
									<span class="font-12 head-font txt-dark" ># of Assessors are 
										<span class="font-20 block counter txt-dark"><span class="counter-anim" ><?php echo !empty($assessor_f['countass'])?$assessor_f['countass']:0; ?></span></span></span>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				
						
				<div class="panel-heading">
					<?php $tittle=!empty($_REQUEST['org_id'])?"for ".$org_name['org_name']:""; ?>
					<div class="pull-left">
						<h6 class="panel-title txt-dark">CPD Techincal Competencies Overall Assessed levels <?php echo $tittle; ?></h6>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-wrapper collapse in">
					<div class="panel-body">
						
						<div style="overflow-y:auto;display:none;">
							<table cellpadding="1" cellspacing="1" id="edit_datable_2" class="table table-hover table-bordered mb-0">
								<thead>
									<tr>
										<th rowspan='2' style="width:15%">Competency</th>
										<th colspan='<?php echo count($pos_details); ?>' scope='colgroup' align='center' style="width:85%;display:none;" >Position Names</th>
									</tr>
									<tr>
									<?php
									
									foreach($pos_details as $key=>$pos_detail){
									?>
									<th style="display:none;">
										<?php echo "P".($key+1)."-".$pos_detail['position_id'];?>
									</th>
									<?php
									}
									?>
										<th>Req Avg</th>
										<th>Ass Avg</th>
										<th>Difference</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$req_sid=$ass_sid=$comname=array();
									$count_c=$total=$total_ass=$final_ass=$subcomp=0;
									foreach($comp_details as $k=>$comp_detail){
										$count_c=($k+1);
									?>
									<tr>
										<!--<td><?php echo "C".($k+1)."-".$comp_detail['comp_def_id']."-".$comp_detail['comp_def_name']; ?></td>-->
										<td><?php echo $comp_detail['comp_def_id']; ?></td>
										<?php 
										$sum_valu=$average_val=$count=0;$ass_ratingavg=$avg_final=0;$countemp=0;
										foreach($pos_details as $pos_detail){
											$pos_rating=UlsAssessmentReport::admin_position_competency_level($ass_id,$pos_detail['position_id'],$comp_detail['comp_def_id']);
											if(count($pos_rating)>0){
												foreach($pos_rating as $kn=>$pos_ratings){
													$count+=($kn+1);
													$sum_valu+= $pos_ratings['scale_number'];
													$average_val=round(($sum_valu/$count),1);
													$pos_rating_ass=UlsAssessmentReport::admin_position_assessed_competency_level($ass_id,$pos_detail['position_id'],$comp_detail['comp_def_id']);
													$sum_emp=$c_emp=0;
													if(count($pos_rating_ass)>0){
														
														foreach($pos_rating_ass as $kr=>$pos_rating_as){
															$count_emp=($kr+1);
															
															$sum_emp+=$pos_rating_as['ass_ave'];
															$rating_avg=round(($sum_emp/$count_emp),1);
															$rating_avg_final=isset($rating_avg)?$rating_avg:""; 
															//$rating_avg_final=$sum_emp."-".$count_emp;
															//$countemp++;
														
															
														}
														$countemp++;
														$avg_final+=($rating_avg_final);
														
														
													}
													else{
														$rating_avg_final="";
													}
													
													?>
													<td style="display:none;"><?php echo $pos_ratings['scale_number'];?>-<?php echo $rating_avg_final;?></td>
												<?php 
													
												}
											}
											else{
											?>
												<td style="display:none;">-</td>
											<?php
											}
										} 
										$total+=$average_val;
										$final_ass=!empty($avg_final)?round(($avg_final/$countemp),1):0;
										($final_ass!=0)?$total_ass+=$final_ass:"-";
										$final_ass==0?$subcomp++:"";
										
										?>
										<td><?php echo $average_val; ?></td>
										<td><?php echo ($final_ass!=0)?$final_ass:"-"; ?></td>
										<td><?php echo ($final_ass!=0)?($average_val-$final_ass):"5"; ?></td>
									</tr>
									
									<?php
									$diff_ass=($final_ass!=0)?($average_val-$final_ass):"5";
									if($final_ass!=0){
										$comp_id[$comp_detail['comp_def_id']]="C".($k+1);
										$comname[$comp_detail['comp_def_id']]=$comp_detail['comp_def_name'];
										$req_sid[$comp_detail['comp_def_id']]=$average_val;
										$ass_sid[$comp_detail['comp_def_id']]=$final_ass;
										$diff_ass_sid[$comp_detail['comp_def_id']]=$diff_ass;
									}
									} ?>
									
								</tbody>
								<tfoot>
									<tr>
										<th colspan='<?php echo count($pos_details); ?>' scope='colgroup'></th>
										<th>Total</th>
										<th><?php echo round(($total/$count_c),1); ?></th>
										<th><?php echo round(($total_ass/($count_c-$subcomp)),1); ?></th>
									</tr>
								</tfoot>
							</table>
							
							
						</div>
						
						<div class="col-lg-2">
						
						</div>
						<div class="col-lg-8">
						<input type="hidden" id="total_required" value="<?php echo @round(($total/$count_c),1); ?>"> 
						<input type="hidden" id="total_assessed" value="<?php echo @round(($total_ass/$count_c-$subcomp),1); ?>"> 
						<script>
						$( document ).ready(function() {
							Highcharts.setOptions({
								chart: {
									inverted: true,
									marginLeft: 135,
									type: 'bullet'
								},
								title: {
									text: null
								},
								legend: {
									enabled: false
								},
								yAxis: {
									gridLineWidth: 0
								},
								plotOptions: {
									series: {
										pointPadding: 0.25,
										borderWidth: 0,
										
										targetOptions: {
											width: '300%',
											color: '#eb3434'
										}
									}
								},
								credits: {
									enabled: false
								},
								exporting: {
									enabled: false
								}
							});

							Highcharts.chart('container', {
								chart: {									
									inverted: true,
									marginLeft: 135,
									type: 'bullet',
									marginTop: 40
								},
								title: {
									text: '<b>CPD Techincal Competencies Overall Assessed levels <?php echo $tittle; ?></b>'
								},
								xAxis: {
									categories: ['<br/><b>Assessed/Required Level</b>']
								},
								yAxis: {
									gridLineWidth: 0,
									plotBands: [{
										from: 0,
										to: 4.0,
										color: '#dedede'
									}],
									title: null
								},
								plotOptions: {
									series: {
										pointPadding: 0.25,
										borderWidth: 0,
										color: '#3452eb',
										targetOptions: {
											width: '300%',
											color: '#eb3434'
										}
									}
								},
								credits: {
									enabled: false
								},
								exporting: {
									enabled: false
								},
								series: [{
									data: [{
										dataLabels: {
											enabled: true,
											format: '<span class="hc-cat-title"></span>',
											align: 'left',
											y: 40,
											inside: true
										},
										y: <?php echo round(($total/$count_c),1); ?>,
										target: <?php echo round(($total_ass/$count_c),1); ?>
									}]
								}],
								tooltip: {
									pointFormat: '<b>{point.y}</b> (with target at {point.target})'
								},

									responsive: {
										rules: [{
											condition: {
												maxWidth: 500
											},
											chartOptions: {
												legend: {
													align: 'center',
													verticalAlign: 'bottom',
													layout: 'horizontal'
												},
												pane: {
													size: '70%'
												}
											}
										}]
									}
							});
						});
						</script>
						<div id="container"></div>
						</div>
						<div class="col-lg-2">
						
						</div>
						
					</div>	
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="">
			<div class="col-lg-12">
				<div class="panel panel-default card-view">
					<div class="panel-heading">
						<div class="pull-left">
							<?php $tittle=!empty($_REQUEST['org_id'])?"for ".$org_name['org_name']:""; ?>
							<h6 class="panel-title txt-dark">CPB Techincal Radar Graph <?php echo $tittle; ?></h6>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="panel-wrapper collapse in">
						<div class="panel-body">
							<?php
							if(isset($comp_id)){
							$valcompetency=array_combine($comp_id,$comname);
							$valrequired=array_combine($comp_id,$req_sid);
							$valassessed=array_combine($comp_id,$ass_sid);
							$diff_valassessed=array_combine($comp_id,$diff_ass_sid);
							$values = array($valrequired,$valassessed);
							$val_required=implode(',',array_values($valrequired));
							$val_assessed=implode(',',array_values($valassessed));
							$diff_val_assessed=implode(',',array_values($diff_valassessed));
							$val_competency=array_values($valcompetency);
							//echo "<pre>";
							//print_r($diff_valassessed);
							arsort($valassessed);
							//print_r($diff_valassessed);
							$val="";
							foreach($val_competency as $val_competencys){
								if(empty($val)){
									$val="'".str_replace(",","",$val_competencys)."'";
								}
								else{
									$val=$val.",'".str_replace(",","",$val_competencys)."'";
								}
								
							}
							?>
							<input type="hidden" id="comp_category" value="<?php echo $val;?>"> 
							<input type="hidden" id="required_level" value="<?php echo $val_required; ?>"> 
							<input type="hidden" id="assessed_level" value="<?php echo $val_assessed; ?>"> 
							<script>
							$( document ).ready(function() {
								Highcharts.setOptions({
									chart: {
										inverted: false,
										marginLeft: 0,
										type: 'bullet'
									},
									title: {
										text: null
									},
									legend: {
										enabled: false
									},
									yAxis: {gridLineWidth: 1,
										gridLineInterpolation: 'polygon',
											lineWidth: 0,
											min: 0
									},
									credits: {
										enabled: false
									},
									exporting: {
										enabled: false
									}
								});
								Highcharts.chart('container_radar', {
									chart: {
										polar: true,
										type: 'line'
									},
									title: {
										text: '<b>Required vs Assessed</b><br>',
										x: -200,
									},

									pane: {
										size: '100%'
									},

									xAxis: {
										categories: [<?php echo $val;?>],
										tickmarkPlacement: 'on',
										lineWidth: 0
									},

									yAxis: {
										gridLineInterpolation: 'polygon',
										lineWidth: 0,
										min: 0
									},

									tooltip: {
										shared: true,
										pointFormat: '<span style="color:{series.color}">{series.name}: <b>{point.y:,.1f}</b><br/>'
									},

									legend: {
										align: 'right',
										verticalAlign: 'middle',
										layout: 'vertical'
									},

									series: [{
										name: 'Required Level',
										data:[<?php echo $val_required; ?>],
										pointPlacement: 'on'
									}, {
										name: 'Assessed Level',
										data: [<?php echo $val_assessed; ?>],
										pointPlacement: 'on'
									}],

									responsive: {
										rules: [{
											condition: {
												maxWidth: 600
											},
											chartOptions: {
												legend: {
													align: 'center',
													verticalAlign: 'bottom',
													layout: 'horizontal'
												},
												pane: {
													size: '100%'
												}
											}
										}]
									}
								});
							});
							</script>
							<figure class="highcharts-figure" style="width: 700px; height: 400px;">
							 <div id="container_radar"></div>
							</figure>
							<?php } ?>
						</div>	
					</div>
				</div>
			</div>
			
		</div>
	</div>
	<div class="row">
		<div class="">
			<div class="col-lg-6">
				<div class="panel panel-default card-view">
					<div class="panel-heading">
						<div class="pull-left">
							<h6 class="panel-title txt-dark">CPB Top Competencies <?php echo $tittle; ?></h6>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="panel-wrapper collapse in">
						<div class="panel-body">
							
							<?php
							/* echo "<pre>";
							print_r(($diff_valassessed)); */
							//arsort($diff_val_assessed);
							
							$j=0;
							if(!empty($valassessed)){
							foreach($valassessed as $ki=>$valassesseds){
								if($valassesseds!=5){
								if($j<2){
									$comp=$valcompetency[$ki];
									$req=$valrequired[$ki];
									$ass=$valassesseds;
									//echo $comp."-".$req."-".$ass."<br>";
									
									?>
									<script>
									$( document ).ready(function() {
										 Highcharts.setOptions({
										chart: {
											inverted: true,
											marginLeft: 135,
											type: 'bullet'
										},
										title: {
											text: null
										},
										legend: {
											enabled: false
										},
										yAxis: {
											gridLineWidth: 0
										},
										plotOptions: {
											series: {
												pointPadding: 0.25,
												borderWidth: 0,
												
												targetOptions: {
													width: '300%',
													color: '#eb3434'
												}
											}
										},
										credits: {
											enabled: false
										},
										exporting: {
											enabled: false
										}
									});

									Highcharts.chart('container_top_<?php echo $ki; ?>', {
										chart: {									
											inverted: true,
											marginLeft: 135,
											type: 'bullet',
											marginTop: 40
										},
										title: {
											text: '<b>CPB Top Competencies</b>'
										},
										xAxis: {
											categories: ['<br/><?php echo $comp; ?>']
										},
										yAxis: {
											gridLineWidth: 0,
											plotBands: [{
												from: 0,
												to: 4.0,
												color: '#dedede'
											}],
											title: null
										},
										plotOptions: {
											series: {
												pointPadding: 0.25,
												borderWidth: 0,
												color: '#18ba60',
												targetOptions: {
													width: '300%',
													color: '#eb3434'
												}
											}
										},
										credits: {
											enabled: false
										},
										exporting: {
											enabled: false
										},
										series: [{
											data: [{
												dataLabels: {
													enabled: true,
													format: '<span class="hc-cat-title"></span>',
													align: 'left',
													y: 40,
													inside: true
												},
												y: <?php echo $req; ?>,
												target: <?php echo $ass; ?>
											}]
										}],
										tooltip: {
											pointFormat: '<b>Required: {point.y}</b> (Assessed: {point.target})'
										},

											responsive: {
												rules: [{
													condition: {
														maxWidth: 500
													},
													chartOptions: {
														legend: {
															align: 'center',
															verticalAlign: 'bottom',
															layout: 'horizontal'
														},
														pane: {
															size: '70%'
														}
													}
												}]
											}
									});

									}); 
									</script>
									<div id="container_top_<?php echo $ki; ?>" style="max-width: 800px;height: 115px;margin: 1em auto;"></div>
									<?php
									$j++;
								}
								}
								
							}
							}
							?>
							
							<div class="clearfix"></div>
						</div>	
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="panel panel-default card-view">
					<div class="panel-heading">
						<div class="pull-left">
							<h6 class="panel-title txt-dark">CPB Bottom Competencies <?php echo $tittle; ?></h6>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="panel-wrapper collapse in">
						<div class="panel-body">
							<?php
							if(!empty($valassessed)){
							asort($valassessed);
							//print_r($valassessed);
							$j=0;
							foreach($valassessed as $ki=>$valassesseds){
								if($valassesseds!=5){
								if($j<2){
									$comp=$valcompetency[$ki];
									$req=$valrequired[$ki];
									$ass=$valassesseds;
									//echo $comp."-".$req."-".$ass."<br>";
									
									?>
									<script>
									$( document ).ready(function() {
										 Highcharts.setOptions({
										chart: {
											inverted: true,
											marginLeft: 135,
											type: 'bullet'
										},
										title: {
											text: null
										},
										legend: {
											enabled: false
										},
										yAxis: {
											gridLineWidth: 0
										},
										plotOptions: {
											series: {
												pointPadding: 0.25,
												borderWidth: 0,
												
												targetOptions: {
													width: '300%',
													color: '#eb3434'
												}
											}
										},
										credits: {
											enabled: false
										},
										exporting: {
											enabled: false
										}
									});

									Highcharts.chart('container_bottom_<?php echo $ki; ?>', {
										chart: {									
											inverted: true,
											marginLeft: 135,
											type: 'bullet',
											marginTop: 40
										},
										title: {
											text: '<b>CPB Bottom Competencies</b>'
										},
										xAxis: {
											categories: ['<br/><?php echo $comp; ?>']
										},
										yAxis: {
											gridLineWidth: 0,
											plotBands: [{
												from: 0,
												to: 4.0,
												color: '#dedede'
											}],
											title: null
										},
										plotOptions: {
											series: {
												pointPadding: 0.25,
												borderWidth: 0,
												color: '#fd7e14',
												targetOptions: {
													width: '300%',
													color: '#eb3434'
												}
											}
										},
										credits: {
											enabled: false
										},
										exporting: {
											enabled: false
										},
										series: [{
											data: [{
												dataLabels: {
													enabled: true,
													format: '<span class="hc-cat-title"></span>',
													align: 'left',
													y: 40,
													inside: true
												},
												y: <?php echo $req; ?>,
												target: <?php echo $ass; ?>
											}]
										}],
										tooltip: {
											pointFormat: '<b>Required: {point.y}</b> (Assessed: {point.target})'
										},

											responsive: {
												rules: [{
													condition: {
														maxWidth: 500
													},
													chartOptions: {
														legend: {
															align: 'center',
															verticalAlign: 'bottom',
															layout: 'horizontal'
														},
														pane: {
															size: '70%'
														}
													}
												}]
											}
									});

									}); 
									</script>
									<div id="container_bottom_<?php echo $ki; ?>" style="max-width: 800px;height: 115px;margin: 1em auto;"></div>
									<?php
									$j++;
								}
								}
								
							}
							}
							?>
							<div class="clearfix"></div>
						</div>	
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="panel-heading">
			<div class="pull-left">
				<h6 class="panel-title txt-dark">Assessments and Performance on Different methods</h6>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
			<div class="panel panel-default card-view pa-0">
				<div class="panel-wrapper collapse in">
					<div class="panel-body pa-0">
						<div class="sm-data-box">
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
										<span class="txt-dark block counter"><span class="counter-anim"><?php echo !empty($test_count['count_test'])?$test_count['count_test']:0; ?></span></span>
										<span class="weight-500 uppercase-font block font-13">Test</span>
									</div>
									<div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
										<i class="pe-7s-science data-right-rep-icon txt-light-grey"></i>
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
										<span class="txt-dark block counter"><span class="counter-anim"><?php echo !empty($inb_count['count_inb'])?$inb_count['count_inb']:0; ?></span></span>
										<span class="weight-500 uppercase-font block">In-Basket</span>
									</div>
									<div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
										<i class="pe-7s-airplay data-right-rep-icon txt-light-grey"></i>
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
										<span class="block counter txt-dark"><span class="counter-anim"><?php echo !empty($case_count['count_case'])?$case_count['count_case']:0; ?></span></span>
										<span class="weight-500 uppercase-font block">Casestudy</span>
									</div>
									<div class="col-xs-6 text-center  pl-0 pr-0 txt-light data-wrap-right">
										<i class="pe-7s-global data-right-rep-icon txt-light-grey"></i>
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
		<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Top 5 competencies(Wrongly) in TEST</h6>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-wrapper collapse in">
					<div  class="panel-body">
					<?php 
					foreach($top_comp_details as $top_comp_detail){
					?>
						<span class="font-16 head-font txt-dark"><?php echo $top_comp_detail['comp_def_name']; ?><span class="pull-right font-12">Question Count:<?php echo $top_comp_detail['total']; ?></span></span>
						<div class="progress mt-10 mb-10">
							<div class="progress-bar progress-bar-primary" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $top_comp_detail['total']; ?>%" role="progressbar"> <span class="sr-only"><?php echo $top_comp_detail['total']; ?> Complete (success)</span> </div>
						</div>
					<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Analysis In_basket </h6>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-wrapper collapse in">
					
					<div class="panel-body sm-data-box-1">
						<?php
						$hour=$min=0;
						$wei_total_inb=$total_inb=0;
						$empc=0;
						foreach($inbasket_details as $inbasket_detail){
							$assessor_rating=UlsAssessmentAssessorRating::assessor_results_report($inbasket_detail['assessment_id'],$inbasket_detail['position_id'],$inbasket_detail['employee_id']);
							
							foreach($assessor_rating as $assessor_ratings){
								$scorefinal_inb=0;
								if($assessor_ratings['assessment_type']=='INBASKET'){
									$empc++;
									$score=((round($assessor_ratings['rat_num'],2)/$assessor_ratings['rating_scale'])*100);
									$wei=$assessor_ratings['weightage'];
									$scorefinal_inb=(($score*$wei)/100);
								} 
								$wei_total_inb+=$scorefinal_inb;
							}
							
							$start = strtotime($inbasket_detail['start_period']);
							$end = strtotime($inbasket_detail['end_period']);
							$totaltime = ($end - $start);
							$hours = @intval($totaltime / 3600); 
							$seconds_remain = ($totaltime - ($hours * 3600));
							$minutes = intval($seconds_remain / 60);
							$seconds = ($seconds_remain - ($minutes * 60));
							@$hour+=!empty($hours)?(($hours>0)?$hours:""):"";
							$min+=$minutes;
						}
						//echo $wei_total_inb."-".$empc;
						$total_inb=@round(((($wei_total_inb)/$empc)),2);
						?>
						<span class="uppercase-font weight-500 font-16 block text-center txt-dark">Time taken </span>	
						<div class="cus-sat-stat weight-500 font-24 txt-primary text-center mt-5">
							<span class="counter-anim"><?php echo $hour+(int)($min/60); ?></span><span>Hr</span><span class="counter-anim">&nbsp;<?php echo ($min-((int)($min/60)*60)); ?></span><span>Mins</span>
						</div>
						<div class="progress-anim mt-20">
							<div class="progress">
								<div class="progress-bar progress-bar-primary
								wow animated progress-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
							</div>
						</div>
						
					</div>
					<div class="mb-50"></div>
					<div class="mb-50"></div>
					<div class="panel-body sm-data-box-1">
						<span class="uppercase-font weight-500 font-16 block text-center txt-dark">Average of the score</span>	
						<div class="cus-sat-stat weight-500 font-24 txt-primary text-center mt-5">
							<span class="counter-anim"><?php echo ($total_inb>0)?$total_inb:""; ?></span><span>%</span>
						</div>
						<div class="progress-anim mt-20">
							<div class="progress">
								<div class="progress-bar progress-bar-primary
								wow animated progress-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
							</div>
						</div>
						<div class="mb-20"></div>
					</div>
					
				</div>
			</div>
		</div>
		<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Analysis Casestudy</h6>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-wrapper collapse in">
				<?php
				$wei_total_case=$total_case=$emp_case=0;
				foreach($case_details as $case_detail){
					$assessor_rating=UlsAssessmentAssessorRating::assessor_results_report($case_detail['assessment_id'],$case_detail['position_id'],$case_detail['employee_id']);
					
					foreach($assessor_rating as $assessor_ratings){
						$scorefinal_case=0;
						if($assessor_ratings['assessment_type']=='CASE_STUDY'){
							$emp_case++;
							$score=((round($assessor_ratings['rat_num'],2)/$assessor_ratings['rating_scale'])*100);
							$wei=$assessor_ratings['weightage'];
							$scorefinal_case=(($score*$wei)/100);
						} 
						$wei_total_case+=$scorefinal_case;
					}
					
				}
				//echo $wei_total_inb."-".count($inbasket_details);
				$total_case=round(((($wei_total_case)/$emp_case)),2);
				?>
					<div class="panel-body sm-data-box-1">
						<span class="uppercase-font weight-500 font-16 block text-center txt-dark">Average</span>	
						<div class="cus-sat-stat weight-500 font-24 txt-primary text-center mt-5">
							<span class="counter-anim"><?php echo ($total_case>0)?$total_case:"";?></span><span>%</span>
						</div>
						<div class="progress-anim mt-20">
							<div class="progress">
								<div class="progress-bar progress-bar-primary
								wow animated progress-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
							</div>
						</div>
						<table class="table table-hover mb-0">
							<thead>
							  <tr>
								<th>Competency</th>
								<th>Required</th>
								<th>Assessed</th>
								</tr>
							</thead>
							<tbody>
							<?php 
							foreach($case_top_details as $case_top_detail){
							?>
								<tr>
									<td><?php echo $case_top_detail['comp_def_name']; ?></td>
									<td><?php echo round($case_top_detail['required'],2); ?></td>
									<td><?php echo round($case_top_detail['assessed'],2); ?></td>
								
								</tr>
							<?php } ?> 
							  
							</tbody>
						</table>
						<div class="mt-20"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
			<div class="panel panel-default card-view panel-refresh">
				<div class="refresh-container">
					<div class="la-anim-1"></div>
				</div>
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Top Employees</h6>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-body row">
					<div class="panel-wrapper collapse in">
						<div id="testimonial_slider" data-ride="carousel" class="carousel slide testimonial-slider-wrap text-slider">
							<ol class="carousel-indicators">
								<?php 
								foreach($top_emp as $key=>$top_emps){
									$active=($key==0)?"active":"";
									?>
									<li data-target="#testimonial_slider" data-slide-to="<?php echo $key; ?>" class="<?php echo $active; ?>"></li>
								<?php 
								} 
								?>
							</ol>
							<div role="listbox" class="carousel-inner mb-50">
							<?php 
							$results=array();
							foreach($top_emp as $key_n=>$top_emps){
								$active_n=($key_n==0)?"active":"";
								$assessor_rating=UlsAssessmentAssessorRating::assessor_results_report($top_emps['assessment_id'],$top_emps['position_id'],$top_emps['employee_id']);
								$wei_total=0;
								foreach($assessor_rating as $assessor_ratings){
									!empty($ass_rating_max)?$percenti_score=$ass_rating_max:"";
									$total_que=!empty($percenti_score)?$percenti_score:$assessor_ratings['test_ques'];
									$score_final=$scorefinal=0;
									if($assessor_ratings['assessment_type']=='TEST'){
										$score_test=round((($assessor_ratings['test_score']/$total_que)*100),2);
										$wei=$assessor_ratings['weightage'];
										$score_final=(($score_test*$wei)/100);
									}
									else{
										$score=((round($assessor_ratings['rat_num'],2)/$assessor_ratings['rating_scale'])*100);
										$wei=$assessor_ratings['weightage'];
										$scorefinal=(($score*$wei)/100);
									} 
									$wei_total=$wei_total+($score_final+$scorefinal);
								}
								
								/* $results[$top_emps['employee_id']]['employee_number']=$top_emps['employee_number'];
									$results[$top_emps['employee_id']]['full_name']=$top_emps['full_name'];
									$results[$top_emps['employee_id']]['position_name']=$top_emps['position_name'];
									$results[$top_emps['employee_id']]['org_name']=$top_emps['org_name'];
									$results[$top_emps['employee_id']]['grade_name']=$top_emps['grade_name'];
									$results[$top_emps['employee_id']]['location_name']=$top_emps['location_name'];
									$results[$top_emps['employee_id']]['final_total']=$wei_total; */
							?>
							<div class="item <?php echo $active_n;?>"> 
									<div class="testimonial-wrap text-center  pl-30 pr-30">
										<img class="img-circle" src="<?php echo BASE_URL; ?>/public/new_layout/images/user-avatar.png" alt="First slide image" style="width: 29%;"> 
										<span class="testi-pers-name block mt-30 font-16 txt-dark capitalize-font head-font">
											<?php echo $top_emps['employee_number']."-".$top_emps['full_name']; ?>
										</span>
										<span class="testi-pers-desg block font-14 capitalize-font">
											<?php echo $top_emps['position_name'];?>
										</span>
										<span class="testi-pers-desg block font-12 capitalize-font">
											<?php echo $top_emps['org_name'];?>
										</span>
										<span class="testi-pers-desg block font-10 capitalize-font">
											<?php echo $top_emps['grade_name']."-".$top_emps['location_name'];?>
										</span>
										<p class="mt-30 font-16">
											<span class="font-12 head-font txt-dark">Overall Score<span class="pull-right"><?php echo $wei_total; ?></span></span>
											<div class="progress mt-10 mb-10">
												<div class="progress-bar progress-bar-primary" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $wei_total; ?>%" role="progressbar"> <span class="sr-only"><?php echo $wei_total; ?>% Complete (success)</span> </div>
											</div>
										</p>
										
									</div>
								</div>
							<?php
							} ?>							
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Rating accross methods</h6>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-wrapper collapse in">
				<?php 
				$result_test=array(0=>array('a'=>0,'b'=>0,'c'=>0,'y'=>'InAppropriate'),1=>array('a'=>0,'b'=>0,'c'=>0,'y'=>'Neither App. or InApp'),2=>array('a'=>0,'b'=>0,'c'=>0,'y'=>'Appropriate'),3=>array('a'=>0,'b'=>0,'c'=>0,'y'=>'Not Applicable'));
				$rating=array(0=>'InAppropriate',1=>'Neither App. or InApp',2=>'Appropriate',3=>'Not Applicable');
				$val="";
				//print_r($feed_detail_test);
				foreach($feed_detail_test as $key=>$feed_detail_tests){
					foreach($rating as $k=>$ratings){
						if(($k+1)==$feed_detail_tests['Q21']){
							$result_test[$k]['a']=$feed_detail_tests['emp_test'];
						}
					}
				}
				foreach($feed_detail_inb as $key=>$feed_detail_tests){
					foreach($rating as $k=>$ratings){
						if(($k+1)==$feed_detail_tests['Q22']){
							$result_test[$k]['b']=$feed_detail_tests['emp_inb'];
						}
					}
				}
				foreach($feed_detail_case as $key=>$feed_detail_tests){
					foreach($rating as $k=>$ratings){
						if(($k+1)==$feed_detail_tests['Q23']){
							$result_test[$k]['c']=$feed_detail_tests['emp_case'];
						}
					}
				}
				//echo "<pre>";
				//print_r($result_test);
				//echo json_encode($result_test);
				?>
				<script>
				
				$( document ).ready(function() {
					if($('#morris_extra_bar_charts').length > 0){
					   // Bar Chart
						Morris.Bar({
							element: 'morris_extra_bar_charts',
							data: <?php echo json_encode($result_test); ?>,
							xkey: 'y',
							ykeys: ['a', 'b', 'c'],
							labels: ['Test', 'In-Basket', 'Casestudy'],
							barColors:['#7AB800', '#00A9E0', '#F0AB00'],
							barOpacity:1,
							hideHover: 'auto',
							grid: false,
							resize: true,
							gridTextColor:'#878787',
							gridTextFamily:"Open Sans"
						});
					}
				});
				</script>
					<div  class="panel-body">
						<div class="col-sm-12 pa-0">
							<div id="morris_extra_bar_charts" class="morris-chart"  style="width:100%"></div>
						</div>
							
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Over All Process </h6>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-wrapper collapse in">
				<?php 
				$resulttest=array(0=>array('value'=>0,'label'=>'Poor'),1=>array('value'=>0,'label'=>'Average'),2=>array('value'=>0,'label'=>'Good'),3=>array('value'=>0,'label'=>'Very Good'),4=>array('value'=>0,'label'=>'Excellent'));
				$rating_val=array(0=>'Poor',1=>'Average',2=>'Good',3=>'Very Good',4=>'Excellent');
				//print_r($feed_detail_test);
				foreach($feed_detail_avg as $key=>$feed_detail_avgs){
					foreach($rating_val as $k=>$rating_vals){
						if(($k+1)==$feed_detail_avgs['Q1']){
							$resulttest[$k]['value']=$feed_detail_avgs['emp_avg'];
						}
					}
				}
				
				/* echo "<pre>";
				print_r($resulttest); */
				//echo json_encode($resulttest);
				?>
				<script>
				$( document ).ready(function() {
					if($('#morris_donut_chart').length > 0) {
						// Donut Chart
						Morris.Donut({
							element: 'morris_donut_chart',
							data: <?php echo json_encode($resulttest); ?>,
							colors: ['#ADC2BB', '#F5F1E6', '#62A0B8', '#2B7DA9', '#A1C4D8'],
							resize: true,
							labelColor: '#878787',
						});
						$("div svg text").attr("style","font-family: Open Sans").attr("font-weight","400");
					}
				});
				</script>
					<div  class="panel-body">
						<div class="col-sm-12 pa-0">
							<div id="morris_donut_chart" class="morris-chart donut-chart"></div>
						</div>
							
					</div>
				</div>
			</div>
		</div>
		
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default border-panel  review-box card-view">
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Top Feedback</h6>
					</div>
					
					<div class="clearfix"></div>
				</div>
				<div class="panel-wrapper collapse in">
					<div class="panel-body row pa-0">
						<div class="streamline">
						<?php 
						if(count($feed_top_avg)>0){
						foreach($feed_top_avg as $feed_top_avgs){
						?>
							<div class="sl-item">
								<div class="sl-content">
									<div class="per-rating inline-block pull-left">
										<a href="javascript:void(0);" class="zmdi zmdi-star"></a>
										<a href="javascript:void(0);" class="zmdi zmdi-star"></a>
										<a href="javascript:void(0);" class="zmdi zmdi-star"></a>
										<a href="javascript:void(0);" class="zmdi zmdi-star"></a>
										<a href="javascript:void(0);" class="zmdi zmdi-star"></a>
										<span class="inline-block">for <?php 
										echo $pos_name=($feed_top_avgs['position_structure']=='S')?$feed_top_avgs['pos_name']:$feed_top_avgs['map_pos_name'];?></span>
									</div>
									<a href="javascript:void(0);"  class=" pull-right txt-grey"><i class="zmdi zmdi-mail-reply"></i></a>
									<div class="clearfix"></div>
									<div class="inline-block pull-left">
										<span class="reviewer font-13">
											<span>By</span>
											<a href="javascript:void(0)" class="inline-block capitalize-font  mb-5"><?php echo $feed_top_avgs['employee_number']; ?>-<?php echo $feed_top_avgs['full_name']; ?></a>
										</span>	
										<span class="inline-block font-13  mb-5"><?php echo $feed_top_avgs['org_name']; ?></span>
									</div>	
									<div class="clearfix"></div>
									<p class="mt-5"><?php echo $feed_top_avgs['Q4']; ?></p>
								</div>
							</div>
							<hr class="light-grey-hr"/>
						<?php }
						}
						else{
						?>
						<div class="alert alert-danger alert-dismissable">
							Opps! No top feedback found for the following search parameters. 
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
							
<?php } ?>	
	
</div>


        