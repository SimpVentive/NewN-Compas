<div class="body-section">
	<!-- TOP YEAR SECTION :BEGIN 
	<div class="top-nav-section">
		<ul class="nav align-items-center">
			<li class="nav-year-item">
				<a href="javascript:;" class="item"><?php echo date('Y'); ?></a>
			</li>
			
		</ul>
	</div>-->
	<!-- TOP YEAR SECTION :END -->

	<!-- TOP YEAR SECTION :BEGIN -->
	<div class="year-tab-section">
		<ul class="nav nav-tabs align-items-center">
			<li class="nav-item">
				<a class="nav-link section-to-scroll active" href="javascript:;" data-section="job-description-tab" data-tab="0">Job Description</a>
			</li>
			<li class="nav-item">
				<a class="nav-link section-to-scroll" href="javascript:;" data-section="key-result-areas-tab" data-tab="1">Key Result Areas</a>
			</li>
			<li class="nav-item">
				<a class="nav-link section-to-scroll" href="javascript:;" data-section="competencies-tab" data-tab="2">Competencies</a>
			</li>
			<li class="nav-item">
				<a class="nav-link section-to-scroll" href="javascript:;" data-section="assessments-tab" data-tab="3">Assessments</a>
			</li>
			<li class="nav-item">
				<a class="nav-link section-to-scroll" href="javascript:;" data-section="developmemt-roadmap-tab" data-tab="4">Developmemt Roadmap</a>
			</li>
		</ul>

		<div class="section-view">
			<div id="scrolling-section" class="tab-content no-scrollbar">
				<div id="job-description-tab" class="tab-pane">
					<div class="custom-scroll">
						<div class="tab-panel">
							<?php
							if(!empty($userdetails['position_id'])){
								$posdetails=UlsPosition::viewposition($userdetails['position_id']);
							?>
							<div class="title">Job Description</div>
							<div class="tab-body">
								<p class="content"><b>Purpose</b></p>
								<p class="content"><?php echo @$posdetails['position_desc']; ?></p>
								<br>
								<p class="content"><b>Accountabilities</b></p>
								<p class="content"><?php echo @$posdetails['accountablities']; ?></p>
								<br>
								<p class="content"><b>Reporting Relationships</b></p>
								<p class="content">Reports to: <?php echo @$posdetails['reportsto']; ?></p>
								<p class="content">Reportees:<?php echo @$posdetails['reportees_name']; ?></p>
								<br>
								<p class="content"><b>Position Requirements</b></p>
								<p class="content">Education Background: <?php echo @$posdetails['education']; ?></p>
								<p class="content">Experience: <?php echo @$posdetails['experience']; ?></p>
								<p class="content">Industry Specific Experience: <?php echo @$posdetails['specific_experience']; ?></p>
								<br>
								<?php if(!empty($posdetails['other_requirement'])){ ?>
								<p class="content"><b>Other Requirements</b></p>
								<p class="content"><?php echo @$posdetails['other_requirement']; ?></p>
								<?php } ?>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>

				<div id="key-result-areas-tab" class="tab-pane">
					<div class="custom-scroll">
						<div class="tab-panel">
							<div class="title">Key Result Areas</div>
							<?php
							$kras=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($userdetails['position_id']);
							$temp="";
							$key1=0;
							if(count($kras>0)){
								foreach($kras as $key=>$kra){
									if($kra['comp_position_id']==$posdetails['position_id']){
									?>
									<?php 
									if($temp!=$kra['kra_master_name']){
										$key1++;
										if($key!=0){
										?>
										</div></div>
										<?php
										}
										?>
										<div class="tab-areas-card">
											
											<div class="tab-areas-header">
												
												<span class="icon"><?php echo $key1; ?></span>
												<span><?php echo $kra['kra_master_name'];?></span>
												
											</div>										
											<div class="tab-areas-body">
											
											<?php
											$temp=$kra['kra_master_name'];
									}?>
											<div class="tab-areas-group d-flex align-items-center justify-content-between">
											<label class="label"><?php echo $kra['kra_kri'];?></label>
											<p class="value"><?php echo $kra['kra_uom'];?></p>
											</div>	
										
									<?php 
									}
								}
							
							}
							echo (count($kras>0))?"</div></div>":"";
							?>
						</div>
						
					</div>
				</div>

				<div id="competencies-tab" class="tab-pane">
					<div class="custom-scroll">
						<div class="tab-panel">
							<div class="title">Competencies</div>
							<?php
							$competencies=UlsCompetencyPositionRequirements::getcompetencypositionrequirements($userdetails['position_id']);
							if(count($competencies)>0){
								foreach($competencies as $key=>$competency){
									if($competency['comp_position_id']==$posdetails['position_id']){
									?>
										<div class="tab-areas-card">
											<div class="tab-areas-header">
												<span class="icon"><?php echo $key+1;?></span>
												<span><?php echo $competency['comp_def_name']; ?></span>
											</div>
											<div class="tab-areas-body">
												<div class="tab-areas-group d-flex align-items-center justify-content-between">
													<label class="label">Required Level:</label>
													<p class="value"><?php echo $competency['scale_name']; ?></p>
												</div>
												<div class="tab-areas-group d-flex align-items-center justify-content-between">
													<label class="label">Criticality:</label>
													<p class="value"><?php echo $competency['comp_cri_name']; ?></p>
												</div>
											</div>
										</div>
									<?php
									}
								}
							}?>

							
						</div>
					</div>
				</div>

				<div id="assessments-tab" class="tab-pane">
					<div class="custom-scroll">
						<div class="tab-panel">
							<div class="title">Assessments</div>
							<ul class="tab-assessments">
								<li class="assessment-timeline">
									<div class="date">26th March 2014</div>
									<div class="tab-areas-card">
										<div class="tab-areas-header">
											<i class="icon material-icons">assignment_turned_in</i>
											<span>Assessment For Asst Manager/ Dy Manager - Research & Development</span>
											<span class="status status-close">Closed</span>
										</div>
										<div class="tab-areas-body">
											<div class="tab-areas-group">
												<label class="label">Position:</label>
												<p class="value">Asst Manager/ Dy Manager - Research & Development</p>
											</div>
											<div class="tab-areas-group">
												<label class="label">Assessor:</label>
												<p class="value">
													<a href="javascript:;" class="assessor-icon material-icons">perm_identity</a>
													<a href="javascript:;" class="assessor-icon material-icons">perm_identity</a>
													<a href="javascript:;" class="assessor-icon material-icons">perm_identity</a>
												</p>
											</div>
											<div class="tab-areas-group">
												<label class="label">End date:</label>
												<p class="value">26th March 2014 </p>
											</div>
										</div>
									</div>
								</li>
								<li class="assessment-timeline">
									<div class="date">31st May 2014</div>
									<div class="tab-areas-card">
										<div class="tab-areas-header">
											<i class="icon material-icons">assignment_turned_in</i>
											<span>CF1 - MG3 Assessment Cycle - Ankaleshwar</span>
											<span class="status status-view">View</span>
										</div>
										<div class="tab-areas-body">
											<div class="tab-areas-group">
												<label class="label">Position:</label>
												<p class="value">Asst Manager/ Dy Manager - Research & Development</p>
											</div>
											<div class="tab-areas-group">
												<label class="label">Assessor:</label>
												<p class="value">
													<a href="javascript:;" class="assessor-icon material-icons">perm_identity</a>
												</p>
											</div>
											<div class="tab-areas-group">
												<label class="label">End date:</label>
												<p class="value">26th March 2014 </p>
											</div>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>

				<div id="developmemt-roadmap-tab" class="tab-pane">
					<div class="custom-scroll">
						<div class="tab-panel">
							<div class="title">Developmemt Roadmap</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- TOP YEAR SECTION :END -->
</div>

