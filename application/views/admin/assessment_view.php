<style>
.nav-pills > li + li {
    margin-left: -4px;
}
</style>
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">
                <div class="panel-body">
					<h3><?php echo @$compdetails['assessment_name']; ?> <small>(<?php echo @$compdetails['assessmentstatus']; ?>)</small></h3>
					<div class="col-lg-12">
                        <p>
						<?php echo @$compdetails['assessment_desc']; ?>
						</p>
					</div>
					<h5>Positions</h5>
					<?php foreach($positions as $position){ ?>
					<div class="col-sm-4">
						<dt class="mb-10"><i class="fa fa-check text-danger mr-5"></i>
						<?php echo @$position['position_name']; ?>
						</dt>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="panel panel-inverse card-view">
				
				<div class="panel-wrapper collapse in">
					<div  class="panel-body">
						
						<div  class="pills-struct vertical-pills">
							<ul role="tablist" class="nav nav-pills ver-nav-pills" id="myTabs_10">
								<?php $j=0; foreach($positions as $position){ $class=($j==0)?"active":""; $j++;?>
									<li class="<?php echo $class; ?>"><a data-toggle="tab" href="#tab-<?php echo $position['position_id']; ?>"> <?php echo $position['position_name']; ?></a></li>
								<?php } ?>
							</ul>
							<div class="tab-content" id="myTabContent_10">
								<?php 
								$j=0; 
								foreach($positions as $position){ $class=($j==0)?"active":""; $j++;?>
								<div id="tab-<?php echo $position['position_id']; ?>" class="tab-pane <?php echo $class; ?>">
									<div class="panel-body">
										<div class="row">
											<div class="">
												<div class="" style="margin-top: -20px;">
													<ul class="nav nav-pills">
														<li class="active"><a data-toggle="tab" href="#tab-jd<?php echo $position['position_id']; ?>">Job Description</a></li>
														<li class=""><a data-toggle="tab" href="#tab-kra<?php echo $position['position_id']; ?>">Key Responsibility Area</a></li>
														<li class=""><a data-toggle="tab" href="#tab-compentencies<?php echo $position['position_id']; ?>">Competencies</a></li>
														<li class=""><a data-toggle="tab" href="#tab-employees<?php echo $position['position_id']; ?>"> Employees</a></li>
														<li class=""><a data-toggle="tab" href="#tab-assessors<?php echo $position['position_id']; ?>">Assessor</a></li>
														<li class=""><a data-toggle="tab" href="#tab-assessments<?php echo $position['position_id']; ?>">Assessments</a></li>
													</ul>
													<div class="tab-content">
													<?php 
													$posdetails=UlsPosition::viewposition($position['position_id']);?>
														<div id="tab-jd<?php echo $position['position_id']; ?>" class="tab-pane active">
															<div class="col-lg-12 row panel-body">
																<h6>Purpose</h6>
																<div class="col-lg-12">
																	<p>
																		<?php echo @$posdetails['position_desc']; ?>
																	</p>
																</div>
																<h6>Accountabilities</h6>
																<div class="col-lg-12">
																	<?php echo @$posdetails['accountablities']; ?>
																</div>
																<h6>Reporting Relationships</h6>
																<div class="col-lg-12">
																	<p>
																		<strong>Reports to</strong>:<?php echo @$posdetails['reportsto']; ?>
																	</p>
																	<p>
																		<strong>Reportees</strong>:<?php echo @$posdetails['reportees_name']; ?>
																	</p>
																</div>

																<h6>Position Requirements</h6>
																<div class="col-lg-12">
																	<p>
																		<strong>Education Background</strong>:<?php echo @$posdetails['education']; ?>
																	</p>
																	<p>
																		<strong>Experience</strong>:<?php echo @$posdetails['experience']; ?>
																	</p>
																	<p>
																		<strong>Industry Specific Experience</strong>:<?php echo @$posdetails['specific_experience']; ?>
																	</p>
																</div>
																<?php if(!empty($posdetails['other_requirement'])){ ?>
																<h6>Other Requirements</h6>
																<div class="col-lg-12">
																	<p>
																		<?php echo @$posdetails['other_requirement']; ?>
																	</p>
																</div>
																<?php } ?>
															</div>
														</div>
														<div id="tab-kra<?php echo $position['position_id']; ?>" class="tab-pane">
															<div class="col-lg-12 row panel-body">
																<div class="table-responsive">
																	<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
																		<thead>
																		<tr>
																			<th>KRA</th>
																			<th>KRI</th>
																			<th>UOM</th>
																		</tr>
																		</thead>
																		<tbody>
																		<?php
																		$kras=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($position['position_id']);
																		foreach($kras as $kra){
																			if($kra['comp_position_id']==$posdetails['position_id']){
																				echo "<tr><td>".$kra['kra_master_name']."</td><td>".$kra['kra_kri']."</td><td>".$kra['kra_uom']."</td></tr>";
																			}
																		} ?>
																		</tbody>
																	</table>
																</div>
															</div>
														</div>
														<div id="tab-compentencies<?php echo $position['position_id']; ?>" class="tab-pane">
															<div class="col-lg-12 row panel-body">
																<div class="table-responsive">
																	<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
																		<thead>
																		<tr>
																			<th>Competencies</th>
																			<th>Scale</th>
																		</tr>
																		</thead>
																		<tbody>
																		<?php
																		foreach($competencies as $competency){
																			if($competency['position_id']==$position['position_id']){
																				echo "<tr><td>".$competency['comp_def_name']."</td>
																				<td>".$competency['scale_name']."</td></tr>";
																			}
																		} ?>
																		</tbody>
																	</table>
																</div>
															</div>
														</div>
														<div id="tab-employees<?php echo $position['position_id']; ?>" class="tab-pane">
															<div class="col-lg-12 row panel-body">
																<div class="table-responsive">
																	<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
																		<thead>
																		<tr>
																			<th>Employee Code</th>
																			<th>Employee name</th>
																			<th>Department</th>
																			<th>Position</th>
																		</tr>
																		</thead>
																		<tbody>
																		<?php
																		foreach($employees as $employee){
																			if($employee['position_id']==$position['position_id']){
																				echo "<tr><td>".$employee['employee_number']."</td>
																				<td>".$employee['full_name']."</td>
																				<td>".$employee['org_name']."</td>
																				<td>".$employee['position_name']."</td></tr>";
																			}
																		} ?>
																		</tbody>
																	</table>
																</div>
															</div>
														</div>
														<div id="tab-assessors<?php echo $position['position_id']; ?>" class="tab-pane">
															<div class="col-lg-12 row panel-body">
																<div class="table-responsive">
																	<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
																		<thead>
																		<tr>
																			<th>Assessor</th>
																			<th>Competencies</th>
																			<th>Level</th>
																			<th>Scale</th>
																			<th>Method</th>
																		</tr>
																		</thead>
																		<tbody>
																		<?php
																		foreach($assessors as $assessor){
																			if($assessor['position_id']==$position['position_id']){
																				echo "<tr><td>".$assessor['assessor_name']."</td>
																				<td>".$assessor['comp_def_name']."</td>
																				<td>".$assessor['level_name']."</td>
																				<td>".$assessor['scale_name']."</td>
																				<td>".$assessor['assesstype']."</td></tr>";
																			}
																		} ?>
																		</tbody>
																	</table>
																</div>
															</div>
														</div>
														<div id="tab-assessments<?php echo $position['position_id']; ?>" class="tab-pane">
															<div class="panel-wrapper collapse in">
																<div class="col-lg-12 row panel-body">
																	<?php
																	$levelassessments=UlsAssessmentCompetenciesWeightage::getassessmentcompetencies_weightage_test($compdetails['assessment_id'],$position['position_id']);
																	foreach($levelassessments as $assessment){
																		if($assessment['position_id']==$position['position_id']){
																			
																		?>
																		<div>

																			<span class="pull-left inline-block capitalize-font txt-dark">
																				<?php echo $assessment['assesstype']." (".$assessment['weightage']."%)"; ?>
																			</span>
																			
																			<div class="clearfix"></div>
																			<hr class="light-grey-hr row mt-10 mb-10">
																			
																		</div>
																		<?php
																		}
																	}  ?>
																</div>
																<button class="btn btn-xs  btn-info btn-rounded pull-right" onclick="get_check_questions_view(<?php echo $_REQUEST['id'];?>,<?php echo $position['position_id']; ?>)">Generate  Booklet</button>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
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
	</div>
	<div class="form-group">
		<div class="col-sm-offset-4">
			<button class="btn btn-primary btn-sm" type="button" onClick="create_link('assessment_creation?status&id=<?php echo $compdetails['assessment_id']."&hash=".md5(SECRET.$compdetails['assessment_id']);?>')">Update</button>
			<button class="btn btn-primary btn-sm" type="button" onClick="create_link('assessment_creation')">Create</button>
			<button class="btn btn-primary btn-sm" type="button" onClick="create_link('assessment_search')">Cancel</button>
		</div>
	</div>
</div>

<script>

function get_check_questions_view(id,pos_id){
		window.open(BASE_URL+"/index/ass_booklet?assess_id="+id+"&pos_id="+pos_id,'_blank')
    }
</script>