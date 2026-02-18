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
				<ul class="nav nav-pills">
					<li class="active"><a data-toggle="tab" href="#tab-compentencies<?php echo $posdetails['position_id']; ?>"> Competency Requirements</a></li>
					
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
										<th>Question Banks</th>
									</tr>
									</thead>
									<tbody>
									<?php
									foreach($competencies as $competency){
										if($competency['comp_position_id']==$posdetails['position_id']){
											$hash=SECRET.$competency['comp_def_id'];
											$id=$competency['comp_def_id'];
											$sid=$competency['scale_id'];
											$aa="";
											if(isset($qtypes[$id][$sid]['COMP_INTERVIEW'])){
												$aa.=$qtypes[$id][$sid]['COMP_INTERVIEW']." (".$qcount[$id][$sid]['COMP_INTERVIEW']['q'].") <i class='fa fa-info-circle ' aria-hidden='true' data-toggle='tooltip' title='Interview Question Bank'></i>&nbsp;&nbsp;&nbsp;";
											}
											if(isset($qtypes[$id][$sid]['COMP_CASESTUDY'])){
												$aa.=$qtypes[$id][$sid]['COMP_CASESTUDY']." (".$qcount[$id][$sid]['COMP_CASESTUDY']['q'].") <i class='fa fa-briefcase' aria-hidden='true' data-toggle='tooltip' title='Casestudy Question Bank'></i>&nbsp;&nbsp;&nbsp;";
											}
											if(isset($qtypes[$id][$sid]['COMP_INBASKET'])){
												$aa.=$qtypes[$id][$sid]['COMP_INBASKET']." (".$qcount[$id][$sid]['COMP_INBASKET']['q'].") <i class='fa fa-shopping-basket' aria-hidden='true' data-toggle='tooltip' title='Inbasket Question Bank'></i>&nbsp;&nbsp;&nbsp;";
											}
											if(isset($qtypes[$id][$sid]['COMP_TEST'])){
												$aa.=$qtypes[$id][$sid]['COMP_TEST']." (".$qcount[$id][$sid]['COMP_TEST']['q'].") <i class='fa fa-question' aria-hidden='true' data-toggle='tooltip' title='MCQ Question Bank'></i>&nbsp;&nbsp;&nbsp;";
											}
											echo "<tr><td>".$competency['comp_def_name']."</td>
											<td>".$competency['scale_name']."</td>
											<td>".$competency['comp_cri_name']."</td>
											<td>".$aa."</td></tr>";
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
