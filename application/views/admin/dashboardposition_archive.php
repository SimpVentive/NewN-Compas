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
					<h3><?php echo @$posdetails['position_name']; ?> <small>(<?php echo @$posdetails['value_name']; ?>)</small></h3>
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
					</div>
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
					<h6>Responsibilities</h6>
					<div class="col-lg-12">
						<?php echo @$posdetails['responsibilities']; ?>
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
					<li class="active"><a data-toggle="tab" href="#tab-compentencies<?php echo $posdetails['position_id']; ?>"> Competency Requirements</a></li>
					<li class=""><a data-toggle="tab" href="#tab-employees<?php echo $posdetails['position_id']; ?>"> Key Result Areas</a></li>
				</ul>
				<div class="tab-content ">
					<div id="tab-compentencies<?php echo $posdetails['position_id']; ?>" class="tab-pane active">
						<div class="panel-body">
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
											$hash=SECRET.$competency['comp_def_id'];
											$id=$competency['comp_def_id'];
											$sid=$competency['scale_id'];
											
											echo "<tr><td>".$competency['comp_def_name']."</td>
											<td>".$competency['scale_name']."</td>
											<td>".$competency['comp_cri_name']."</td></tr>";
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
    </div>
</div>
