<?php if(empty($loc)){ ?>
<div class="row">
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		<h5 class="txt-dark">Locations</h5>
	</div>
</div>
<div class="row">
	<?php foreach($locations as $location){ ?>
		<a style="cursor:pointer;" onclick="getlocassesspos('<?php echo $emptype; ?>','<?php echo $bu; ?>','<?php echo $location['location_id']; ?>')"><div class="col-md-2">
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
<?php  } ?>
	<div class="row">
			<?php $colsize="col-lg-12"; if(empty($emptype)){ $colsize="col-lg-8"; ?>
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
							<div class="chat-cmplt-wrap chat-for-widgets">
								<div class="chat-box-wrap">
									<div>
										<div class="users-nicescroll-bar">
											<ul class="chat-list-wrap">
												<li class="chat-list">
													<div class="chat-body">
														<?php foreach($assessors as $assessor){ ?>
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
						<select name="year" id="year"  onchange="getassessyr('<?php echo $emptype; ?>','<?php echo $bu; ?>','<?php echo $loc; ?>');" class="col-lg-12 form-control m-b">
							<option value=''>Select Year</option>
							<?php $years=array("2015","2016","2017","2018","2019"); foreach($years as $year){
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
						<table id="datable_2" class="table table-bordered">
							<thead>
							<tr>
								<th class="col-sm-6">Assessment Name</th>
								<th class="col-sm-2">Positions covered</th>
								<th class="col-sm-2">Initiated Date</th>
								<th class="col-sm-2">Employee covered</th>
							</tr>
							</thead>
							<tbody>
							<?php foreach($assessments as $assessment){ ?>
							<tr>
								<td><?php echo $assessment['assessment_name']; ?></td>
								<td><a onclick="getasesspos(<?php echo $assessment['assessment_id']; ?>);" style="cursor: pointer;" data-toggle="modal" data-target=".bs-example-modal-lg"><?php echo $assessment['positions']; ?></a></td>
								<td><?php echo date("d-m-Y",strtotime($assessment['start_date'])); ?></td>
								<td><a onclick="getasessposemp(<?php echo $assessment['assessment_id']; ?>);" style="cursor: pointer;" data-toggle="modal" data-target=".bs-example-modal-lg"><?php echo $assessment['employees']; ?></a></td>
							</tr>
							<?php } ?>
							</tbody>
						</table>
					</div></div>
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
											<th>Type</th>
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
										<td><a onclick="getposdet(<?php echo $position_infos['position_id']; ?>)" style="cursor: pointer;" data-toggle="modal" data-target=".bs-example-modal-lg"><?php echo $position_infos['position_name']; ?></a></td>
										<td><?php echo $position_infos['position_type']; ?></td>
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
<?php if(empty($loc)){ ?></div><?php } ?>