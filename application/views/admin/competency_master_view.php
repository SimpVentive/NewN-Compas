<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">
                <div class="panel-body">
					<h3><?php echo @$compdetails['comp_def_name']; ?> <small>(<?php echo @$compdetails['category']; echo !empty($compdetails['subcategory'])?", ".$compdetails['subcategory']:""; ?>)</small></h3>
					<div class="col-lg-12">
                        <p>
						<?php echo @$compdetails['comp_def_short_desc']; ?>
						</p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="panel panel-inverse card-view">
				<ul class="nav nav-pills">
					<li class="active"><a data-toggle="tab" href="#tab-keyind"> Key Indicators</a></li>
					<li class=""><a data-toggle="tab" href="#tab-keycov">Key Coverage Aspects</a></li>
				</ul>
				<div class="tab-content ">
					<div id="tab-keyind" class="tab-pane active">
						<div class="panel-body">
							<?php echo @$compdetails['comp_def_key_indicator']; ?>
						</div>
					</div>
					<div id="tab-keycov" class="tab-pane">
						<div class="panel-body">
							<?php echo @$compdetails['comp_def_key_coverage']; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="panel panel-inverse card-view">
				<ul class="nav nav-pills">
					<?php $j=0; foreach($levels as $level){ $class=($j==0)?"active":""; $j++;?>
						<li class="<?php echo $class; ?>"><a data-toggle="tab" href="#tab-<?php echo $level['scale_id']; ?>"> <?php echo $level['scale_name']; ?></a></li>
					<?php } ?>
				</ul>
				<div class="tab-content">
					<?php $j=0; foreach($levels as $level){ $class=($j==0)?"active":""; $j++;?>
					<div id="tab-<?php echo $level['scale_id']; ?>" class="tab-pane <?php echo $class; ?>">
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<div class="panel panel-inverse card-view">
										<ul class="nav nav-pills">
											<li class="active"><a data-toggle="tab" href="#tab-keyind<?php echo $level['scale_id']; ?>">Indicators</a></li>
											<li class=""><a data-toggle="tab" href="#tab-keyques<?php echo $level['scale_id']; ?>"> Questions</a></li>
											<li class=""><a data-toggle="tab" href="#tab-keymigr<?php echo $level['scale_id']; ?>">Migration Maps</a></li>
											<li class=""><a data-toggle="tab" href="#tab-keyasses<?php echo $level['scale_id']; ?>">Assessment Methods</a></li>
										</ul>
										<div class="tab-content ">
											<div id="tab-keyind<?php echo $level['scale_id']; ?>" class="tab-pane active">
												<div class="panel-body">
													<?php $tmp="";
													foreach($levelindicators as $indicator){														
														if($indicator['comp_def_level_id']==$level['scale_id']){
															if($tmp!=$indicator['comp_def_level_ind_type']){ echo !empty($tmp)?"</ul><strong>".$indicator['ind_master_name']."</strong><ul>":"<strong>".$indicator['ind_master_name']."</strong><ul>";  $tmp=$indicator['comp_def_level_ind_type']; }
															echo "<li>".$indicator['comp_def_level_ind_name']."</li>";
														}
													} ?>
												</div>
											</div>
											<div id="tab-keyques<?php echo $level['scale_id']; ?>" class="tab-pane">
												<div class="panel-body">
													<strong>Question List from the question bank</strong><br>
													<div class="slimScrollDiv" >
													<table id="example<?php echo $level['scale_id']; ?>" cellpadding="1" cellspacing="1" class="table table-bordered table-striped" style="width: 100%;" >
														<thead>
															<tr>
																<th >S.No</th>
																<th>Question name</th>
															</tr>
														</thead>
													
													<script type="text/javascript" language="javascript" class="init">
	
														$(document).ready(function() {
															$('#example<?php echo $level['scale_id']; ?>').DataTable( {
																"pageLength" : 10,
																"serverSide": true,
																"autoWidth" : false,
																"ajax": {
																	url : "<?php echo BASE_URL;?>/admin/comp_master_questions?comp_id=<?php echo $compdetails['comp_def_id']; ?>&scale_id=<?php echo $level['scale_id']; ?>",
																	
																	"order": [
																	  [1, "asc" ]
																	],
																	
																	"columns": [
																		null,
																		null
																	],
																	"fixedHeader": {
																		"header": true,
																		"footer": true
																	},
																	"columnDefs": [
																		{ "width": "5%", "targets": 0 },
																		{ "width": "95%", "targets": 1 }
																	],
																},
															} );
														} );

													</script>
													
													
													</table>
													</div>
													<strong>Interview Questions List</strong><br>
													<ol>
													<?php
													$levelinterquestions=UlsCompetencyDefIntQuestion::getcompdefintques_view($compdetails['comp_def_id'],$level['scale_id']);
													if(count($levelinterquestions)>0){
														
														foreach($levelinterquestions as $intquest){
															echo "<li>".$intquest['question_name']."</li>";
															
														}
													}
													else{
														echo "<b>No interview Questions are mapped to this Level.</b>";
													}
													?>
													</ol>
												</div>
											</div>
											<div id="tab-keymigr<?php echo $level['scale_id']; ?>" class="tab-pane">
												<div class="panel-body">
													<ul>
													<?php
													foreach($levelmigrationmaps as $migrate){														
														if($migrate['comp_def_level_ind_id']==$level['scale_id']){															
															echo "<li>".$migrate['migrate_type']." ".$migrate['comp_def_level_migrate_oth']."</li>";
														}
													} ?>
													</ul>
												</div>
											</div>
											<div id="tab-keyasses<?php echo $level['scale_id']; ?>" class="tab-pane">
												<div class="panel-body">
													<ul>
													<?php
													foreach($levelassessments as $assessment){														
														if($assessment['comp_def_level_ind_id']==$level['scale_id']){															
															echo "<li>".$assessment['assess_method']."</li>";
														}
													} ?>
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
				</div>
			</div>
		</div>
	
		<div class="form-group">
			<div class="col-sm-offset-4">
				<button class="btn btn-primary btn-sm" type="button" onClick="create_link('competency_master?id=<?php echo $compdetails['comp_def_id']."&hash=".md5(SECRET.$compdetails['comp_def_id']);?>')">Update</button>
				<button class="btn btn-primary btn-sm" type="button" onClick="create_link('competency_master')">Create</button>
				<button class="btn btn-primary btn-sm" type="button" onClick="create_link('competency_master_search')">Cancel</button>
			</div>
		</div>
	</div>
</div>
