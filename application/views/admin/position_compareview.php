<style>
.modal-header {
    background: #f7f9fa none repeat scroll 0 0;
    padding: 10px 0px;
}
</style>
<div class="content">
    <div class="row">
		<div class="col-lg-12">
            <div class="panel panel-inverse card-view">
                <div class="panel-body">
					<h4><?php echo @trim(str_replace("-","",$posdetails['position_name'])); ?> - <?php echo @$posdetails['ades']; ?><small>(<?php echo @$posdetails['value_name']; ?>)</small></h4>
					<h6>Role Profile</h6>
					<div class="col-lg-12">
                        <p>
							<strong>Reports to</strong>:<?php echo @$posdetails['reportsto']; ?>
						</p>
						<p>
							<strong>Reportees</strong>:<?php echo @$posdetails['reportees_name']; ?>
						</p>
						<p>
							<strong>Grade</strong>:<?php echo @$posdetails['grade_name']; ?>
						</p>
						<p>
							<strong>Business</strong>:<?php echo @$posdetails['bu_name']; ?>
						</p>
						<p>
							<strong>Function</strong>:<?php echo @$posdetails['position_org_name']; ?>
						</p>
						<p>
							<strong>Location</strong>:<?php echo @$posdetails['location_name']; ?>
						</p>
						<p>
							<strong>Required Designations</strong>:<?php echo @$posdetails['designation_name']; ?>
						</p>
					</div>
					<h6>Purpose</h6>
					<div class="col-lg-12">
                        <p>
							<?php echo @$posdetails['position_desc']; ?>
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
		</div>

		<div class="col-lg-12">
			<div class="panel panel-inverse card-view">
				<ul class="nav nav-pills">
					<li class="active"><a data-toggle="tab" href="#tab-acc<?php echo $posdetails['position_id']; ?>"> Accountabilities</a></li>
					<?php if(!empty($posdetails['responsibilities'])){ ?><li ><a data-toggle="tab" href="#tab-res<?php echo $posdetails['position_id']; ?>"> Responsibilities</a></li><?php } ?>
					<li ><a data-toggle="tab" href="#tab-compentencies<?php echo $posdetails['position_id']; ?>"> Competencies</a></li>
					<li class=""><a data-toggle="tab" href="#tab-employees<?php echo $posdetails['position_id']; ?>"> KRA</a></li>
				</ul>
				<div class="tab-content ">
					<div id="tab-acc<?php echo $posdetails['position_id']; ?>" class="tab-pane active">
						<div class="panel-body">
							<div class="col-lg-12">
								<?php echo @$posdetails['accountablities']; ?>
							</div>
						</div>
					</div>
					<?php if(!empty($posdetails['responsibilities'])){ ?><div id="tab-res<?php echo $posdetails['position_id']; ?>" class="tab-pane">
						<div class="panel-body">
							<div class="col-lg-12">
								<?php echo @$posdetails['responsibilities']; ?>
							</div>
						</div>
					</div><?php } ?>
					<div id="tab-compentencies<?php echo $posdetails['position_id']; ?>" class="tab-pane">
						<div class="panel-body">
							<div class="table-responsive">
								<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
									<thead>
									<tr>
										<th>Competencies</th>
										<!--<th>Level</th>-->
										<th>Required Level</th>
										<th>Criticality</th>
									</tr>
									</thead>
									<tbody>
									<?php //<td>".$competency['level_name']."</td>
									foreach($competencies as $competency){
										if($competency['comp_position_id']==$posdetails['position_id']){
											$hash=SECRET.$competency['comp_def_id'];
											echo "<tr><td><a style='text-decoration:underline' target='_blank' href='".BASE_URL."/admin/competency_master_view?id=".$competency['comp_def_id']."&hash=".md5($hash)."'>".$competency['comp_def_name']."</a></td>
											<td><a style='text-decoration:underline' data-target='#workinfoview".$competency['comp_def_id']."' onclick='indicator_view(".$competency['comp_def_id'].",".$competency['scale_id'].")' data-toggle='modal' href='#workinfoview".$competency['comp_def_id']."'>".$competency['scale_name']."</a></td>
											<td>".$competency['comp_cri_name']."</td></tr>
											<div id='workinfoview".$competency['comp_def_id']."'  class='modal fade' tabindex='-1' role='dialog'  aria-hidden='true'>
												<div class='modal-dialog modal-lg' style='width:1000px'>
													<div class='modal-content'>
														<div class='color-line'></div>
														<div class='modal-header'>
															<h6 class='modal-title'>Level Indicators </h6>
														</div>
														<div class='modal-body'>
															<div id='workinfodetails".$competency['comp_def_id']."' class='modal-body no-padding'>
															
															</div>
														</div>
														
													</div><!-- /.modal-content -->
												</div><!-- /.modal-dialog -->
											</div>";
										}
									} ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div id="tab-employees<?php echo $posdetails['position_id']; ?>" class="tab-pane">
						<div class="panel-body">
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
												if(!empty($kra['kra_master_des'])){
													echo "<br>Description:".$kra['kra_master_des'];
												}
												if(!empty($kra['kra_master_goal'])){
													echo "<br>Goal:".$kra['kra_master_goal'];
												}
											}
											echo "</td><td>".$kra['kra_kri']."</td><td>".$kra['kra_uom']."</td></tr>";
										}
									} ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-4">
				<a class="btn btn-primary btn-sm" target="_blank" href="<?php echo BASE_URL; ?>/admin/position_update?eve_stat&posid=<?php echo $posdetails['position_id']."&hash=".md5(SECRET.$posdetails['position_id']);?>">Update</a>
			</div>
		</div>
    </div>
</div>
