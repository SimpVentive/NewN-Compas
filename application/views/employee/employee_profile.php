<div class="body-section">
	<!-- TOP YEAR SECTION :BEGIN -->
	<?php 
	if(isset($joining)){
	?>
	<div class="top-nav-section" style="">
		<ul class="nav align-items-center">
			<?php
			foreach($joining as $n=>$joinings){
				//$active=($n==0)?"active":"";
				if(isset($positionid)){
					if($joinings['position_id']==$positionid){
						$active="active";
					}else{
						$active="";
					}
				}else{
					$active=($n==0)?"active":"";
		
					}
				?>
			<li class="nav-year-item">
				<a href="?position_id=<?php echo $joinings['position_id'];?>"  class="item <?php echo $active; ?>" id="positiontab<?php echo $joinings['position_id'];?>"><?php echo date('Y',strtotime($joinings['joining_date'])); ?></a>
			</li>
			<?php } ?>
		</ul>
	</div>
	<!-- TOP YEAR SECTION :END -->

	<!-- TOP YEAR SECTION :BEGIN -->
	
	<br>
	<div class="top-nav-section">
		<ul class="nav align-items-center">
			<li class="nav-year-item">
				<?php
				if(!empty($joinings['position_id'])){
					$posdetails=UlsPosition::viewposition($joinings['position_id']);
					if($posdetails['position_structure']=='A'){
						$pos_name=UlsPosition::pos_details($posdetails['position_structure_id']);
						$posname=$pos_name['position_name'];
					}
					else{
						$posname=$posdetails['position_name'];
					}
				?>
				<a href="javascript:;" class="item"><span style="color: #404040;display: block;font-size: 16px;font-weight: bold;margin-bottom: 1px;position: relative;">Position:&nbsp;&nbsp;<?php echo @$posname; ?></span></a>
				<?php 
				} ?>
			</li>
		</ul>
	</div>
	<?php 
	foreach($joining as $j=>$joinings){
		if(!empty($joinings['position_id'])){
		$posdetails=UlsPosition::viewposition($joinings['position_id']);
		if(!empty($posdetails['accountablities'])){
		if(isset($positionid)){
			if($joinings['position_id']==$positionid){
				$act="block";
			}else{
			$act="none";
			}
			}else{

			$act=($j==0)?"block":"none";
		}
	?>
	<div class="year-tab-section" id="position-tab<?php echo $joinings['position_id'];?>" style="display:<?php echo $act; ?>;">
		<ul class="nav nav-tabs align-items-center" style="border-top: 1px solid #dee2e6;">
			<li class="nav-item">
				<a class="nav-link section-to-scroll active" href="javascript:;" data-section="job-description-tab<?php echo $joinings['position_id'];?>" data-position="<?php echo $joinings['position_id'];?>" data-tab="0">Job Description</a>
			</li>
			<li class="nav-item">
				<a class="nav-link section-to-scroll" href="javascript:;" data-section="key-result-areas-tab<?php echo $joinings['position_id'];?>" data-position="<?php echo $joinings['position_id'];?>" data-tab="1">Key Result Areas</a>
			</li>
			<li class="nav-item">
				<a class="nav-link section-to-scroll" href="javascript:;" data-section="competencies-tab<?php echo $joinings['position_id'];?>" data-position="<?php echo $joinings['position_id'];?>" data-tab="2">Competencies</a>
			</li>
			<!--<li class="nav-item">
				<a class="nav-link section-to-scroll" href="javascript:;" data-section="assessments-tab<?php echo $joinings['position_id'];?>" data-position="<?php echo $joinings['position_id'];?>" data-tab="3">Assessments</a>
			</li>
			<li class="nav-item">
				<a class="nav-link section-to-scroll" href="javascript:;" data-section="developmemt-roadmap-tab<?php echo $joinings['position_id'];?>" data-position="<?php echo $joinings['position_id'];?>" data-tab="4">Development Roadmap</a>
			</li>-->
		</ul>

		<div class="section-view">
			 <div class="d-flex align-items-center justify-content-between">
				<div class="assessment-head-title">&nbsp;</div>
				<?php 
				$hash=SECRET.$joinings['position_id'];
				?>
				<!--<a class="assessment-profile-btn" href="<?php echo BASE_URL."/admin/positionpdf?posid=".$joinings['position_id']."&hash=".md5($hash);?>" target="_blank" style="text-decoration: underline;"><img src="<?php echo BASE_URL; ?>/public/newlayout/img/pdf.png" style="margin:0.0cm 0.2cm;float:right;" height="50"></a>-->
			</div>
			<div id="scrolling-section<?php echo $joinings['position_id'];?>" class="tab-content no-scrollbar">
				<div id="job-description-tab<?php echo $joinings['position_id'];?>" class="tab-pane">
					<div class="">
						<div class="tab-panel">
							<?php
							if(!empty($joinings['position_id'])){
								
								$posdetails=UlsPosition::viewposition($joinings['position_id']);
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
								<p class="content">Experience: <br><?php echo @$posdetails['experience']; ?></p>
								<p class="content">Industry Specific Experience: <br><?php echo @$posdetails['specific_experience']; ?></p>
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

				<div id="key-result-areas-tab<?php echo $joinings['position_id'];?>" class="tab-pane">
					<div class="">
						<div class="tab-panel">
							<div class="title">Key Result Areas</div>
							<?php
							
							$kras=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($joinings['position_id']);
							$temp="";
							$temp1="";
							$key1=0;
							if(count($kras)>0){
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
									<?php
									if($temp1!=$kra['kra_master_name']){
									?>
									<div class="tab-areas-group d-flex align-items-center justify-content-between">
									
									<label class="label"><b style="text-decoration: underline;">KPI</b></label>
									<p class="value"><b style="text-decoration: underline;">UOM</b></p>
									</div>
									<?php
									$temp1=$kra['kra_master_name'];
									} ?>
											<div class="tab-areas-group d-flex align-items-center justify-content-between">
											
											<label class="label"><?php echo $kra['kra_kri'];?></label>
											<p class="value"><?php echo $kra['kra_uom'];?></p>
											</div>	
										
									<?php 
									}
								}
							
							}
							echo (count($kras)>0)?"</div></div>":"";
							?>
						</div>
						
					</div>
				</div>

				<div id="competencies-tab<?php echo $joinings['position_id'];?>" class="tab-pane">
					<div class="">
						<div class="tab-panel">
							<div class="title">Competencies</div>
							<?php
							
							$competencies=UlsCompetencyPositionRequirements::getcompetencypositionrequirements($joinings['position_id']);
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
													<p class="value"><a href="javascript:;" data-toggle="modal" data-target="#ass-rules-modal<?php echo $competency['comp_def_id']; ?>" onclick="open_comp_level(<?php echo $competency['comp_def_id']; ?>);"><?php echo $competency['scale_name']; ?></a></p>
												</div>
												<div class="tab-areas-group d-flex align-items-center justify-content-between">
													<label class="label">Criticality:</label>
													<p class="value"><a href="javascript:;" data-toggle="modal" data-target="#ass-rules-modal<?php echo $competency['comp_def_id']; ?>" onclick="open_comp_level(<?php echo $competency['comp_def_id']; ?>);"><?php echo $competency['comp_cri_name']; ?></a></p>
												</div>
											</div>
										</div>
										<div class="modal fade case-modal" id="ass-rules-modal<?php echo $competency['comp_def_id']; ?>" tabindex="-1" role="dialog">
											<div class="modal-dialog" role="document" >
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title flex">Level Details</h5>
														<a href="javascript:;" class="close-modal" data-dismiss="modal" aria-label="Close">
															<i class="material-icons">close</i> Close
														</a>
													</div>
													<div class="case-info">
														
													</div>
													<div class="modal-body" >
														<div id="level_comp<?php echo $competency['comp_def_id']; ?>">
														
														</div>
													</div>
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

				<!--<div id="assessments-tab<?php echo $joinings['position_id'];?>" class="tab-pane">
					<div class="">
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
				</div>-->

				<div id="developmemt-roadmap-tab<?php echo $joinings['position_id'];?>" class="tab-pane">
					<div class="">
						<div class="tab-panel">
							<div class="title">Development Roadmap</div>
							<div class="tab-areas-card">
								
								<div class="tab-areas-body" style="padding: 254px;">
									<div class="tab-areas-group">
										
										<p class="value" style="color: #989898;">Your Development Roadmap has not yet been prepared/created</p>
									</div>
									
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php }
	else{
		?>
		<br>
		<div class="top-nav-section">
		<ul class="nav align-items-center">
			<li class="nav-year-item">
				
				<a href="javascript:;" class="item"><span style="color: #404040;display: block;font-size: 16px;font-weight: bold;margin-bottom: 1px;position: relative;">Positional Details Not Available/Not Required</span></a>
				
			</li>
		</ul>
	</div>
		<?php
	}
		}
		else{
	?>
	<div class="title">No Position is Mapped</div>
	<?php	
	} 
	}
	}else{
	?>
	<div class="title">No Position is Mapped</div>
	<?php
	}
	?>
	<!-- TOP YEAR SECTION :END -->
</div>
<script>
function open_comp_level(comp_id){
	var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('level_comp'+comp_id).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/employee/getcomp_level?comp_id="+comp_id,true);
	 xmlhttp.send();    
}
</script>
