<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Professional Profile</h6>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-body">
					<div class="col-lg-2">
					<?php 
					$pic_path=BASE_URL.'/public/images/male_user.jpg';if(isset($userdetails['employee_id'])){ $pic_path=(!empty($userdetails['photo']))?BASE_URL.'/public/uploads/profile_pic/'.trim($userdetails['employee_id']).'/'.trim($userdetails['photo']):(($userdetails['gender']=='M')?BASE_URL.'/public/images/male_user.jpg':BASE_URL.'/public/images/female_img.jpg'); } ?>
					<img alt="logo" class="img-square m-b m-t-md" src="<?php echo $pic_path; ?>">
					</div>
					<div class="col-lg-3">
					<h5><?php echo $userdetails['full_name']; ?></h5>
					<p><?php echo $userdetails['position_name']; ?>, <?php echo $userdetails['org_name']; ?></p>
					<p>Employee Number: <?php echo $userdetails['employee_number']; ?></p>
					<p>Grade: <?php echo !empty($userdetails['grade_name'])?$userdetails['grade_name']:"-"; ?></p>
					</div>
					<div class="col-lg-3">
						<p><i class="fa fa-birthday-cake"></i> <?php echo !empty($userdetails['date_of_birth'])?date("d F Y",strtotime($userdetails['date_of_birth'])):"-"; ?></p>
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
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-inverse card-view">
				<ul class="nav nav-pills">
					<li class="active"><a data-toggle="tab" href="#tab-1">Job Description</a></li>
					<li class=""><a data-toggle="tab" href="#tab-2">Key Result Areas</a></li>
					<li class=""><a data-toggle="tab" href="#tab-3">Competencies</a></li>
				</ul>
				<div class="tab-content">
					<div id="tab-1" class="tab-pane active">						
						<div class="panel-body">
							<?php
							if(!empty($userdetails['position_id'])){
							$posdetails=UlsPosition::viewposition($userdetails['position_id']);
							
							?>
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
							<?php }
							else{
							?>
							<div class="list-group ">
								<a class="list-group-item" href="#">
									<h5 class="list-group-item-heading">Alert!</h5>
									<p class="list-group-item-text">No Position Information has been added to this position.</p>
								</a>
							</div>
							<?php
							}
							?>
						</div>
						
					</div>
					<div id="tab-2" class="tab-pane">
						<?php
						$kras=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($userdetails['position_id']);
						?>
						<div class="panel-body">
						<?php
						if(count($kras>0)){
						?>
							<div class="table-responsive">
								<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
									<thead>
									<tr>
										<th>KRA</th>
										<th>KPI</th>
										<th>UOM</th>
									</tr>
									</thead>
									<tbody>
									<?php
									$temp="";
									foreach($kras as $kra){
										if($kra['comp_position_id']==$posdetails['position_id']){
											echo "<tr><td>";
											if($temp!=$kra['kra_master_name']){
												echo $kra['kra_master_name'];
												$temp=$kra['kra_master_name'];
											}
											echo "</td><td>".$kra['kra_kri']."</td><td>".$kra['kra_uom']."</td></tr>";
										}
									} ?>
									</tbody>
								</table>
							</div>
						<?php
						}
							else{
							?>
							<div class="list-group ">
								<a class="list-group-item" href="#">
									<h5 class="list-group-item-heading">Alert!</h5>
									<p class="list-group-item-text">No KRAs has been added to this position.</p>
								</a>
							</div>
						<?php
						}
						?>
						</div>
					</div>
					<div id="tab-3" class="tab-pane">
						<div class="panel-body">
						<?php
						$competencies=UlsCompetencyPositionRequirements::getcompetencypositionrequirements($userdetails['position_id']);
						if(count($competencies)>0){
						?>
						
							<div class="table-responsive">
								<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
									<thead>
									<tr>
										<th>Competencies</th>
										<th>Required Level</th>
										<th>Criticality</th>
									</tr>
									</thead>
									<tbody>
									<?php
									foreach($competencies as $competency){
										if($competency['comp_position_id']==$posdetails['position_id']){
									?>	
										<tr>
											<td><?php echo $competency['comp_def_name']; ?></td>
											<td><?php echo $competency['scale_name']; ?></td>
											<td><?php echo $competency['comp_cri_name']; ?></td>
										</tr>
									<?php }
									}
									?>
									</tbody>
								</table>
							</div>
						
						<?php }
						else{
						?>	
							<div class="list-group ">
								<a class="list-group-item" href="#">
									<h5 class="list-group-item-heading">Alert!</h5>
									<p class="list-group-item-text">No Competencies has been added to this position.</p>
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