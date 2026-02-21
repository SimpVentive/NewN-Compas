<div class='modal-header'>
	<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
	<h4 class='modal-title'>Competencies Profiling of <?php echo $posdetails['position_name']; ?></h4>
</div>
<div class='modal-body'>
	<div class="row">
		
		<ul class="nav nav-pills">
			<li class="active"><a data-toggle="tab" href="#tab-compentencies<?php echo $posdetails['position_id']; ?>"> Competency Requirements</a></li>
			<li class=""><a data-toggle="tab" href="#tab-employees<?php echo $posdetails['position_id']; ?>"> Key Result Areas</a></li>
		</ul>
		<div class="tab-content ">
			<div id="tab-compentencies<?php echo $posdetails['position_id']; ?>" class="tab-pane active">
			
				<div class="panel-body">
					<div class="panel-heading hbuilt">
						<div class="pull-right">
							<?php 
							$hash=SECRET.$posdetails['position_id'];
							?>
							<a class="btn btn-primary " href="<?php echo BASE_URL."/admin/positionprofilepdf?posid=".$posdetails['position_id']."&hash=".md5(@$hash);?>" target="_blank">&nbsp <i class="fa fa-plus-circle"></i> Competency Requirements PDF &nbsp </a>
							
						</div>
					</div>
					<div class="clearfix mt-20"></div>
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
								<th>KRI</th>
								<th>UOM</th>
							</tr>
							</thead>
							<tbody>
							<?php
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
		</div>
	</div>
</div>