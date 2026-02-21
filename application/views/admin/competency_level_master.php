<script>
<?php
//To send source type name to .js file
$indicators='';
foreach($ind_type as $ind_types){
    if($indicators==''){
        $indicators=$ind_types['ind_master_id']."*".str_replace(array(",","'"),array("",""),$ind_types['ind_master_name']);
    }
    else{
        $indicators=$indicators.",".$ind_types['ind_master_id']."*".str_replace(array(",","'"),array("",""),$ind_types['ind_master_name']);
    }
}
echo "var ind_detail='".$indicators."';";

$qtype_name='';
foreach($comp_intquestions as $comp_intquestion){
    if($qtype_name==''){
        $qtype_name=$comp_intquestion['code']."*".str_replace(array(",","'"),array("",""),$comp_intquestion['name']);
    }
    else{
        $qtype_name=$qtype_name.",".$comp_intquestion['code']."*".str_replace(array(",","'"),array("",""),$comp_intquestion['name']);
    }
}
echo "var qtypename='".$qtype_name."';";
?>
</script>
<div class="content">
    <div class="row">
		<div class="col-lg-12">
            <div class="panel panel-inverse card-view">				
                <div class="panel-body">
					<h5><?php echo @$compdetails['comp_def_name']; ?> <small>(<?php echo @$compdetails['category']; echo !empty($compdetails['subcategory'])?", ".$compdetails['subcategory']:""; ?>)</small></h5>
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
					<?php $i=0; foreach($levels as $level){ $classs=($i==0)?"active":""; $i++;?>
					<div id="tab-<?php echo $level['scale_id']; ?>" class="tab-pane <?php echo $classs; ?>">
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<div class="panel panel-inverse card-view">
										<div id="error_div" class="message"><font color="#62cb31">
										<?php 
										$indicator_message=$this->session->flashdata('indicator_message');
										if(!empty($indicator_message)){ echo $this->session->flashdata('indicator_message'); $this->session->unset_userdata('indicator_message'); } ?></font></div>
										<ul class="nav nav-pills">
											<li class="active"><a data-toggle="tab" href="#tab-keyind<?php echo $level['scale_id']; ?>">Indicators</a></li>
											<li class=""><a data-toggle="tab" href="#tab-keymigr<?php echo $level['scale_id']; ?>">Migration Maps</a></li>
											<li class=""><a data-toggle="tab" href="#tab-keyasses<?php echo $level['scale_id']; ?>">Assessment Methods</a></li>
											<li class=""><a data-toggle="tab" href="#tab-keyques<?php echo $level['scale_id']; ?>"> Questions</a></li>
											<li class=""><a data-toggle="tab" href="#tab-keydev<?php echo $level['scale_id']; ?>"> Development Road Map</a></li>
											<li class=""><a data-toggle="tab" href="#tab-keyprog<?php echo $level['scale_id']; ?>">Programs</a></li>
											<li class=""><a data-toggle="tab" href="#tab-keyQuest<?php echo $level['scale_id']; ?>"> Questionnaire</a></li>
											<li class=""><a data-toggle="tab" href="#tab-keyint<?php echo $level['scale_id']; ?>"> Interview Questions</a></li>
										</ul>
										<div class="tab-content ">
											<div id="tab-keyind<?php echo $level['scale_id']; ?>" class="tab-pane active">
												<div class="panel-body">
													<form id="indicator" action="<?php echo BASE_URL;?>/admin/competency_indicators" method="post" enctype="multipart/form-data" class="form-horizontal">
														<div class="panel-heading hbuilt">
															
															<div class="pull-left">
																<h6 class="panel-title txt-dark">Add Indicators</h6>
															</div>
															
														</div>
														<div class="clearfix"></div>
														<div class="table-responsive">
															<input type="hidden" id="comp_def_id" name="comp_def_id" value="<?php echo $_REQUEST['id']; ?>">
															<input type="hidden" id="scale_id[]" name="scale_id[]" value="<?php echo $level['scale_id']; ?>">
															<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id='source_table<?php echo $level['scale_id']; ?>'>
																<thead>
																<tr>
																	<th width="5%">Select</th>
																	<th width="20%">Element</th>
																	<th width="75%">Element Description</th>
																</tr>
																</thead>
																<tbody>
																<?php 
																$hide_val=array();
																if(count($levelindicators)>0){
																	foreach($levelindicators as $levelindicator){
																		if($levelindicator['comp_def_level_id']==$level['scale_id']){
																		$key=$levelindicator['comp_def_level_ind_id']; $hide_val[]=$key;
																		?>
																		<tr id='subgrd<?php echo $key; ?>_<?php echo $level['scale_id']; ?>'>
																			<td>
																				<input type="hidden" name="comp_def_level_ind_id[<?php echo $level['scale_id']; ?>][]" id="comp_def_level_ind_id<?php echo $levelindicator['comp_def_level_ind_id'];?>" value="<?php echo $levelindicator['comp_def_level_ind_id'];?>">
																				<label><input type="checkbox" id="chkbox<?php echo $key; ?>_<?php echo $level['scale_id']; ?>" name="chkbox[]" value="<?php echo $levelindicator['comp_def_level_ind_id'];?>"></label>
																			</td>
																			<td>
																				<select class="form-control m-b" name="comp_def_level_ind_type[<?php echo $level['scale_id']; ?>][]" id="comp_def_level_ind_type_<?php echo $key;?>_<?php echo $level['scale_id']; ?>">
																					<option value="">Select</option>
																					<?php 	
																					foreach($ind_type as $ind_types){
																						$sel_sat=(isset($levelindicator['comp_def_level_ind_type']))?($levelindicator['comp_def_level_ind_type']==$ind_types['ind_master_id'])?"selected='selected'":'':''?>
																						<option value="<?php echo $ind_types['ind_master_id']?>" <?php echo $sel_sat?>><?php echo $ind_types['ind_master_name']?></option>
																					<?php 	
																					}?>
																				</select>
																			</td>
																			<td><input type="text" name="comp_def_level_ind_name[<?php echo $level['scale_id']; ?>][]" id="comp_def_level_ind_name_<?php echo $key;?>_<?php echo $level['scale_id']; ?>" class="form-control" value="<?php echo $levelindicator['comp_def_level_ind_name'];?>"></td>
																		</tr>
																		<?php 
																		}
																	}
																	$hidden=@implode(',',$hide_val);
																}
																else{?>
																	<tr id='subgrd1_<?php echo $level['scale_id']; ?>'>
																		<td>
																			<input type="hidden" name="comp_def_level_ind_id[<?php echo $level['scale_id']; ?>][]" id="	comp_def_level_ind_id1" value="">
																			<label><input type="checkbox" id="chkbox1" name="chkbox[]" value="1"></label>
																		</td>
																		<td>
																			<select class="form-control m-b" name="comp_def_level_ind_type[<?php echo $level['scale_id']; ?>][]" id="comp_def_level_ind_type_1_<?php echo $level['scale_id']; ?>">
																				<option value="">Select</option>
																				<?php 	
																				foreach($ind_type as $ind_types){
																					?>
																					<option value="<?php echo $ind_types['ind_master_id']?>" ><?php echo $ind_types['ind_master_name']?></option>
																				<?php 	
																				}?>
																			</select>
																		</td>
																		<td><input type="text" name="comp_def_level_ind_name[<?php echo $level['scale_id']; ?>][]" id="comp_def_level_ind_name_1_<?php echo $level['scale_id']; ?>" class="form-control" value=""></td>
																	</tr>
																<?php 
																$hidden=1;
																}
																
																?>
																</tbody>
															</table>
															<input type="hidden" name="addgroup<?php echo $level['scale_id']; ?>" id="addgroup<?php echo $level['scale_id']; ?>" value="<?php echo $hidden; ?>">
														</div>
														
														<div class="pull-left">
															<a class="btn btn-xs btn-primary" onclick="open_indicator(<?php echo $level['scale_id']; ?>);">&nbsp <i class="fa fa-plus-circle"></i> Add &nbsp </a>
															<a class="btn btn-danger btn-xs" onclick="delete_indiactor(<?php echo $level['scale_id']; ?>);">&nbsp <i class="fa fa-trash-o"></i>  Delete &nbsp </a>
														</div>
														<div class="clearfix"></div>
														<hr class="light-grey-hr">
														<div class="form-group">
															<div class="col-sm-offset-0">
																<button class="btn btn-primary btn-sm" type="submit" name="save" id="save">Save changes</button>
																<button class="btn btn-danger btn-sm" type="button" onClick="create_link('competency_master_search')">Cancel</button>
																
															</div>
														</div>
													</form>
												</div>
											</div>
											<div id="tab-keyques<?php echo $level['scale_id']; ?>" class="tab-pane">
												<div class="panel-body">
													<div class="panel-heading hbuilt">
														
														<div class="pull-left">
															<h6 class="panel-title txt-dark">Add Question Bank</h6>
														</div>
														<div class="clearfix"></div>
													</div>
													<div class="table-responsive">
														<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
															<thead>
															<tr>
																<th>Questions</th>
																<th>Level</th>
																<th>Action</th>
															</tr>
															</thead>
															<tbody>
															<?php 
															$level_q1=UlsCompetencyDefQueBank::getcompdefquesbank_levels($compdetails['comp_def_id'],$level['scale_id'],$compdetails['comp_def_level']);
															foreach($level_q1 as $level_q1s){
															?>
															<tr>
																<td class="col-lg-9"><?php echo $level_q1s['question_name']; ?></td>
																<td class="col-lg-2"><?php echo $level_q1s['scale_name']; ?></td>
																<td class="col-lg-1"><a style="cursor: pointer;" onclick="open_intray_indiator(<?php echo $level_q1s['question_id'];?>,<?php echo $level['scale_id']; ?>,<?php echo $_REQUEST['id']; ?>);"  data-toggle="modal" data-target="#exampleModal_indicator<?php echo $level['scale_id']; ?>" class="btn btn-primary btn-xs pull-left mr-15">&nbsp; <i class="fa fa-plus-circle"></i> Action &nbsp; </a></td>
															</tr>
															<div class="modal fade" id="exampleModal_indicator<?php echo $level['scale_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
																<div class="modal-dialog modal-lg">
																	<div class="modal-content">
																		<div id="txtHint_indicator<?php echo $level['scale_id']; ?>"></div>
																	</div>
																	<!-- /.modal-content -->
																</div>
																<!-- /.modal-dialog -->
															</div>
															<?php } ?>
															</tbody>
														</table>
													</div>
													<hr class="light-grey-hr">
													<h6 class="panel-title txt-dark">Interview Questions</h6>
													<hr class="light-grey-hr">
													<div class="panel-heading hbuilt">
														<div class="pull-left">
															<h6 class="panel-title txt-dark">Interview Questions</h6>
														</div>
														<div class="clearfix"></div>
													</div>
													<div class="table-responsive">
														<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
															<thead>
															<tr>
																<th>Interview Questions</th>
																<th>Questions Level</th>
															</tr>
															</thead>
															<tbody>
															<?php 
															$level_int1=UlsCompetencyDefIntQuestion::getcompdefinterview_levels($compdetails['comp_def_id'],$level['scale_id'],$compdetails['comp_def_level']);
															foreach($level_int1 as $level_int1s){
															?>
															<tr>
																<td><?php echo $level_int1s['question_name']; ?></td>
																<td><?php echo $level_int1s['scale_name']; ?></td>
															</tr>
															<?php } ?>
															</tbody>
														</table>
													</div>
												</div>
											</div>
											<div id="tab-keymigr<?php echo $level['scale_id']; ?>" class="tab-pane">
												<div class="panel-body">
												<form id="indicator" action="<?php echo BASE_URL;?>/admin/competency_migration_map" method="post" enctype="multipart/form-data" class="form-horizontal">
												<?php
												$level2=UlsLevelMasterScale::levelscale_detail_levels($level['scale_number'],$compdetails['comp_def_level']);
												$levelmigrationmaps=UlsCompetencyDefLevelMigrationMaps::getcompdeflevelmigmap($compdetails['comp_def_id'],$level['scale_id']);
												?>
												<input type="hidden" id="comp_def_id" name="comp_def_id" value="<?php echo $_REQUEST['id']; ?>">
												<input type="hidden" id="scale_id" name="scale_id" value="<?php echo $level['scale_id']; ?>">
												<input type="hidden" name="comp_def_level_migrate_id" id="comp_def_level_migrate_id" value="<?php echo isset($levelmigrationmaps['comp_def_level_migrate_id'])?$levelmigrationmaps['comp_def_level_migrate_id']:"";
												?>">
												<input type="hidden" name="from_level_id" id="from_level_id" value="<?php echo $level['scale_id']; ?>">
												<input type="hidden" name="to_level_id" id="to_level_id" value="<?php echo !empty($level2['scale_id'])?$level2['scale_id']:""; ?>">
													<h6 class="panel-title txt-dark">Migration Map:
													&nbsp;<?php echo $level['scale_name']; ?> &nbsp;<?php echo !empty($level2['scale_name'])?"to":""; ?>&nbsp; <?php echo $level2['scale_name'] ?></h6>
													<div class="hr-line-dashed"></div>
													<table class="table">
														<thead>
															<tr>
																<td>
																	Migration Maps
																</td>
															</tr>
														</thead>
														<tbody>
														<?php 
														foreach($migrations as $migration){
															$map=isset($levelmigrationmaps['comp_def_level_migrate_type'])?explode(",",$levelmigrationmaps['comp_def_level_migrate_type']):array();
															$map_sel=in_array($migration['code'],$map)?"checked='checked'":""; 
														?>
															<tr>
																<td>
																	<input value="<?php echo $migration['code']; ?>" id="comp_def_level_migrate_type[]"  name="comp_def_level_migrate_type[<?php echo $level['scale_id']; ?>][]" type="checkbox" <?php echo $map_sel; ?>> <?php echo $migration['name']; ?>
																</td>
															</tr>
														<?php } ?>	
														</tbody>
													</table>
													<hr class="light-grey-hr">
													<h6 class="panel-title txt-dark">Others</h6>
													<hr class="light-grey-hr">
													<div class="panel-heading hbuilt">
														
														<div class="pull-left">
															<h6 class="panel-title txt-dark">Add Others</h6>
														</div>
														<div class="pull-right">
															<a class="btn btn-xs btn-primary" onclick="open_migration_maps(<?php echo $level['scale_id']; ?>);">&nbsp <i class="fa fa-plus-circle"></i> Add &nbsp </a>
															<a class="btn btn-danger btn-xs" onclick="delete_migration_maps(<?php echo $level['scale_id']; ?>);">&nbsp <i class="fa fa-trash-o"></i>  Delete &nbsp </a>
														</div>
													</div>
													<div class="clearfix"></div>
													<div class="table-responsive">
														<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="table_migration_map<?php echo $level['scale_id'];?>">
															<thead>
															<tr>
																<th>Select</th>
																<th>Others</th>
															</tr>
															</thead>
															<tbody>
															<?php 
															if($levelmigrationmaps['comp_def_level_ind_id']==$level['scale_id']){
																$others_migrations=isset($levelmigrationmaps['comp_def_level_migrate_oth'])?explode(",",$levelmigrationmaps['comp_def_level_migrate_oth']):array();
																if(!empty($others_migrations)){
																	foreach($others_migrations as $key1=>$others_migration){
																	$key=$key1+1;
																	$hide_val[]=$key;	
																	?>
																	<tr id='subgrd_migration<?php echo $key; ?>_<?php echo $level['scale_id']; ?>'>
																		<td>
																		<input type="hidden" name="comp_def_level_migrate_ids[<?php echo $level['scale_id']; ?>][]" id="comp_def_level_migrate_id<?php echo $key; ?>" value="<?php echo $levelmigrationmaps['comp_def_level_migrate_id'];?>">
																		<label><input type="checkbox" id="chkbox_migration<?php echo $key; ?>_<?php echo $level['scale_id']; ?>" name="chkbox_migration[]" value="<?php echo $others_migration;?>"></label>
																		</td>
																		<td><input type="text" value="<?php echo $others_migration; ?>" id="comp_def_level_migrate_oth_<?php echo $key;?>_<?php echo $level['scale_id']; ?>" class="form-control" name="comp_def_level_migrate_oth[<?php echo $level['scale_id']; ?>][]"></td>
																	</tr>
																	<?php }
																	$hidden_migration=@implode(',',$hide_val);
																}
																else{
																?>
																	<tr>
																		<td>
																			<input type="hidden" name="comp_def_level_migrate_ids[<?php echo $level['scale_id']; ?>][]" id="comp_def_level_migrate_id1" value="">
																			<label><input type="checkbox" id="chkbox_migration1_<?php echo $level['scale_id']; ?>" name="chkbox_migration[]" value=""></label>
																		</td>
																		<td><input type="text" value="" id="comp_def_level_migrate_oth_1_<?php echo $level['scale_id']; ?>" class="form-control" name="comp_def_level_migrate_oth[<?php echo $level['scale_id']; ?>][]"></td>
																	</tr>
																<?php
																$hidden_migration=1;
																}
															}
															/* else{
															?>
															<tr><td>No records</td></tr>
															<?php
															} */
															?>
															</tbody>
														</table>
														<input type="hidden" name="addgroup_migration<?php echo $level['scale_id']; ?>" id="addgroup_migration<?php echo $level['scale_id']; ?>" value="<?php echo !empty($hidden_migration)?$hidden_migration:""; ?>">
													</div>
													<hr class="light-grey-hr">
													<div class="form-group">
														<div class="col-sm-offset-0">
															<button class="btn btn-primary btn-sm" type="submit" name="save" id="save">Save changes</button>
															<button class="btn btn-danger btn-sm" type="button" onClick="create_link('competency_master_search')">Cancel</button>
														</div>
													</div>
												</form>
												</div>
											</div>
											<div id="tab-keyasses<?php echo $level['scale_id']; ?>" class="tab-pane">
												<div class="panel-body">
													<form id="indicator" action="<?php echo BASE_URL;?>/admin/competency_assessement_insert" method="post" enctype="multipart/form-data" class="form-horizontal">
													<input type="hidden" id="comp_def_id" name="comp_def_id" value="<?php echo $_REQUEST['id']; ?>">
													<input type="hidden" id="scale_id" name="scale_id" value="<?php echo $level['scale_id']; ?>">
														<table class="table">
															<thead>
																<tr>
																	<td>
																		Assessment Methods
																	</td>
																</tr>
															</thead>
															<tbody>
															<?php
															$select_ass=array();
															$levelassessments=UlsCompetencyDefLevelAssessment::getcompdeflevelassessment($compdetails['comp_def_id'],$level['scale_id']);
															if(!empty($levelassessments)){
																foreach($levelassessments as $levelassessment){
																	$key=$levelassessment['comp_def_level_assess_id'];
																	$value=$levelassessment['comp_def_assess_type'];
																	$select_ass[$key]=$value;
																}
															}
															foreach($ass_methods as $ass_method){
																$val=array_search($ass_method['code'],$select_ass);
																$ass_check=in_array($ass_method['code'],$select_ass)?"checked='checked'":"";
																echo "<tr>
																	<td>
																		<input type='hidden' name='comp_def_level_assess_id[]' id='comp_def_level_assess_id[]' value='".$val."'>
																		<div class='col-md-4'><input type='checkbox' name='comp_def_assess_type[]'  id='	comp_def_assess_type[]' onchange='open_method(\"".$ass_method['code']."\")' value='".$ass_method['code']."' ".$ass_check."> ".$ass_method['name']."</div>
																		<div class='col-md-4' id='sub_assessment_".$ass_method['code']."'></div>
																	</td>
																</tr>";
															}
															?>															
															</tbody>
														</table>
														
														<hr class="light-grey-hr">
														<div class="form-group">
															<div class="col-sm-offset-0">
																<button class="btn btn-primary btn-sm" type="submit">Save changes</button>
																<button class="btn btn-danger btn-sm" type="submit" onClick="create_link('competency_master_search')">Cancel</button>
															</div>
														</div>
													</form>
												</div>
											</div>
											<div id="tab-keydev<?php echo $level['scale_id']; ?>" class="tab-pane">
												<div class="panel-body">
													
													<?php
													$training_details=UlsCompetencyDefLevelTraining::getcompdeftraining($_REQUEST['id'],$level['scale_id']);
														$scale_no=UlsLevelMasterScale::levelscale_detail($level['scale_id']);
														$scale_name="";
														$indicator="";
														$scale_id="";
														if($scale_no['scale_number']==1){
															$scale_name="Basic";
															if(!empty($scale_no['scale_indicator'])){
																$sca_de=UlsLevelMasterScale::level_scale_detail($scale_no['level_id'],$scale_no['scale_indicator']);
																$scale_id=$sca_de['scale_ids'];
															}
															else{
																$scale_id=$level['scale_id'];
															}
															$level_indiactors=UlsCompetencyDefLevelIndicator::getcompdef_level_ind_details($_REQUEST['id'],$scale_id);
															$indicator.="The following are the objectives of this training program"."<br><br><br>";
															foreach($level_indiactors as $level_indiactor){
																$indicator.=$level_indiactor['comp_def_level_ind_name']."<br>";
															}
														}
														if($scale_no['scale_number']==2){
															$scale_name="Intermediate";
															if(!empty($scale_no['scale_indicator'])){
																$sca_de=UlsLevelMasterScale::level_scale_detail($scale_no['level_id'],$scale_no['scale_indicator']);
																$scale_id=$sca_de['scale_ids'];
															}
															else{
																$scale_id=$level['scale_id'];
															}
															$level_indiactors=UlsCompetencyDefLevelIndicator::getcompdef_level_ind_details($_REQUEST['id'],$scale_id);
															$indicator.="The following are the objectives of this training program"."<br><br><br>";
															foreach($level_indiactors as $level_indiactor){
																$indicator.=$level_indiactor['comp_def_level_ind_name']."<br>";
															}
														}
														if($scale_no['scale_number']==3){
															$scale_name="Intermediate";
															if(!empty($scale_no['scale_indicator'])){
																$sca_de=UlsLevelMasterScale::level_scale_detail($scale_no['level_id'],$scale_no['scale_indicator']);
																$scale_id=$sca_de['scale_ids'];
															}
															else{
																$scale_id=$level['scale_id'];
															}
															$level_indiactors=UlsCompetencyDefLevelIndicator::getcompdef_level_ind_details($_REQUEST['id'],$scale_id);
															$indicator.="The following are the objectives of this training program"."<br><br><br>";
															foreach($level_indiactors as $level_indiactor){
																$indicator.=$level_indiactor['comp_def_level_ind_name']."<br>";
															}
														}
														if($scale_no['scale_number']==4){
															$scale_name="Advanced";
															if(!empty($scale_no['scale_indicator'])){
																$sca_de=UlsLevelMasterScale::level_scale_detail($scale_no['level_id'],$scale_no['scale_indicator']);
																$scale_id=$sca_de['scale_ids'];
															}
															else{
																$scale_id=$level['scale_id'];
															}
															$level_indiactors=UlsCompetencyDefLevelIndicator::getcompdef_level_ind_details($_REQUEST['id'],$scale_id);
															$indicator.="The following are the objectives of this training program"."<br><br><br>";
															foreach($level_indiactors as $level_indiactor){
																$indicator.=$level_indiactor['comp_def_level_ind_name']."<br>";
															}
														}
													$comp_name=UlsCompetencyDefinition::competency_detail_single($_REQUEST['id']);
													?>
													<div class="panel-heading hbuilt">
														<div class="pull-left">
															<h6 class="panel-title txt-dark">Training Program: <?php echo $scale_name; ?></h6>
														</div>
														
														<div class="clearfix"></div>
													</div>
													<font color="#FF0000">* Indicated are Mandatory <br></font>
													
													<form class="form-horizontal"  name="language_form<?php echo $level['scale_id']; ?>" id="language_form<?php echo $level['scale_id']; ?>" method="post" action="<?php echo BASE_URL;?>/admin/competency_training_insert">
														<input type="hidden" id="comp_def_id" name="comp_def_id" value="<?php echo $_REQUEST['id']; ?>">
														<input type="hidden" id="scale_id" name="scale_id" value="<?php echo $level['scale_id']; ?>">
														<input type="hidden" name="training_id" id="training_id" value="<?php echo !empty($training_details['training_id'])?$training_details['training_id']:"";?>">
														<div class="form-group"><label class="col-sm-2 control-label">Program Tittle<sup><font color="#FF0000">*</font></sup>:</label>
															<div class="col-sm-8"><input type="text"  id="program_title[<?php echo $level['scale_id']; ?>]" name="program_title[<?php echo $level['scale_id']; ?>]" class="validate[required,funcCall[checknotinteger],minSize[4],maxSize[80],ajax[ajaxcriticality]] form-control" value="<?php echo !empty($training_details['program_title'])?$training_details['program_title']:$scale_name." program in ".$comp_name['comp_def_name'];?>"></div>
														</div>
														
														<div class="form-group"><label class="col-sm-2 control-label">Program Objective<sup><font color="#FF0000">*</font></sup>:</label>
															<div class="col-sm-8"><textarea class="summernote form-control m-b" name="program_obj[<?php echo $level['scale_id']; ?>]" id="program_obj"><?php echo !empty($training_details['program_obj'])?$training_details['program_obj']:$indicator;?></textarea></div>
														</div>
														<div class="form-group"><label class="col-sm-2 control-label">Duration<sup><font color="#FF0000">*</font></sup>:</label>

															<div class="col-sm-8">
																<select id="status" name="program_duration[<?php echo $level['scale_id']; ?>]" class="validate[required] form-control m-b">
																	<option value="">Select</option>
																	<?php foreach($day_details as $day_detail){ 
																		$dur=!empty($training_details['program_duration'])?(($training_details['program_duration']==$day_detail['code'])?"selected='selected'":""):"";
																		?>
																		<option value="<?php echo $day_detail['code'];?>" <?php echo $dur; ?>><?php echo $day_detail['name'];?></option>
																	<?php } ?>
																</select>
															</div>
														</div>
														<div class="form-group"><label class="col-sm-2 control-label">Status<sup><font color="#FF0000">*</font></sup>:</label>

															<div class="col-sm-8">
																<select id="status" name="status[<?php echo $level['scale_id']; ?>]" class="validate[required] form-control m-b">
																	<option value="">Select</option>
																	<?php foreach($locstatusss as $locstatus){ 
																		$sta=!empty($training_details['status'])?(($training_details['status']==$locstatus['code'])?"selected='selected'":""):"";?>
																		<option value="<?php echo $locstatus['code'];?>" <?php echo $sta; ?>><?php echo $locstatus['name'];?></option>
																	<?php } ?>
																</select>
															</div>
														</div>
														<div class="hr-line-dashed"></div>
														<div class="form-group">
															<div class="col-sm-offset-9">
																<button class="btn btn-primary btn-sm" type="button" onClick="create_link('competency_master_search')">Cancel</button>
																<button class="btn btn-primary btn-sm" type="submit"  name="update">Save changes</button>
															</div>
														</div>
													</form>	
													<script>
													$(document).ready(function(){
														$('#language_form<?php echo $level['scale_id']; ?>').validationEngine();
													});
													</script>
												</div>
											</div>
											<div id="tab-keyprog<?php echo $level['scale_id']; ?>" class="tab-pane">
												<div class="panel-body">
												<?php 
											if(count($levelindicators)>0){?>
											
										<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
											<thead>
											<tr>
												
												<th >Element</th>
												<th >Program Name</th>
												<th >Action</th>
											</tr>
											</thead>
											</tbody>
											<?php	foreach($levelindicators as $levelindicator){
													if($levelindicator['comp_def_level_id']==$level['scale_id']){
													$program_comp=UlsCompetencyDefLevelIndicatorPrograms::getcompdeflevel_pro_details($_REQUEST['id'],$levelindicator['comp_def_level_id'],$levelindicator['comp_def_level_ind_id']);
													?>
													<tr>
															<input type="hidden" name="comp_def_level_ind_id[<?php echo $level['scale_id']; ?>][]" id="comp_def_level_ind_id<?php echo $levelindicator['comp_def_level_ind_id'];?>" value="<?php echo $levelindicator['comp_def_level_ind_id'];?>">
														<td>
															<?php echo $levelindicator['comp_def_level_ind_name'];?>	
														</td>
														<td><?php echo @$program_comp['program_name'];?></td>
														<td>
														<div class="pull-left">
														<a style="cursor: pointer;"  data-toggle="modal" data-target="#exampleModal_progms<?php echo $level['scale_id']."_".$_REQUEST['id']."_".$levelindicator['comp_def_level_ind_id']; ?>" class="btn btn-primary btn-xs pull-left mr-15">&nbsp; <i class="fa fa-plus-circle"></i> Add &nbsp Program </a>
														</div>														
															<div class="modal fade" id="exampleModal_progms<?php echo $level['scale_id']."_".$_REQUEST['id']."_".$levelindicator['comp_def_level_ind_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
																<div class="modal-dialog modal-lg">
																	<div class="modal-content">
								<form class="form-horizontal"  name='program_form<?php echo $level['scale_id']."_".$_REQUEST['id']."_".$levelindicator['comp_def_level_ind_id'];?>' id='program_form<?php echo $level['scale_id']."_".$_REQUEST['id']."_".$levelindicator['comp_def_level_ind_id'];?>' action='<?php echo BASE_URL;?>/admin/competency_indicators_programss'  method='post' >
								<?php //comp_def_level_ind_id parent_org_id comp_def_id comp_def_level_id
  //  $sd=Doctrine_Core::getTable('UlsCompetencyDefLevelIndicatorPrograms')->findOneByCompDefIdAndCompDefLevelIdAndCompDefLevelIndIdAndParentOrgId($_REQUEST['id'],$level['scale_id'],$levelindicator['comp_def_level_ind_id'],$_SESSION['parent_org_id']);
	
	$sd=UlsCompetencyDefLevelIndicatorPrograms::getcompdeflevel_pro_details($_REQUEST['id'],$level['scale_id'],$levelindicator['comp_def_level_ind_id']);
    //$sd=Doctrine_Core::getTable('UlsCompetencyDefLevelIndicatorPrograms')->findOneByCompDefIdAndCompDefLevelIndIdAndCompDefLevelId($_REQUEST['id'],$levelindicator['comp_def_level_ind_id'],$level['scale_id']);
				$comp_def_pro_id='';
				$program_name='';
				if(!empty($sd)){
					$comp_def_pro_id=$sd['comp_def_pro_id'];
					$program_name=$sd['program_name'];
					$program_name_desc=$sd['program_name_desc'];
				}
				else{
					$comp_def_pro_id="";
					$program_name="";
					$program_name_desc="";
				}
				?>
														<input type="hidden" id="comp_def_pro_id" name="comp_def_pro_id" value="<?php echo $comp_def_pro_id; ?>">
														<input type="hidden" id="comp_def_id" name="comp_def_id" value="<?php echo $_REQUEST['id']; ?>">
														<input type="hidden" id="comp_def_level_ind_id" name="comp_def_level_ind_id" value="<?php echo $levelindicator['comp_def_level_ind_id']; ?>">
														<input type="hidden" id="comp_def_level_id" name="comp_def_level_id" value="<?php echo $level['scale_id']; ?>">
														<input type="hidden" id="parent_org_id" name="parent_org_id" value="<?php echo $_SESSION['parent_org_id']; ?>">
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
				<h5 class='modal-title' id='myLargeModalLabel'>Add Program</h5>
			</div>
			<div class='modal-body'>
				<div class='panel-body'>
				<div class="form-group"><label class="col-sm-2 control-label">Program Name<sup><font color="#FF0000">*</font></sup>:</label>
															<div class="col-sm-8"><textarea class="form-control m-b" name="prg_title" id="prg_title"><?php echo $program_name; ?></textarea></div>
														</div>
														<div class="form-group"><label class="col-sm-2 control-label">Program Description<sup><font color="#FF0000">*</font></sup>:</label>
															<div class="col-sm-8"><textarea class="form-control m-b" name="program_name_desc" id="program_name_desc"><?php echo $program_name_desc; ?></textarea></div>
														</div>
				</div>
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-danger text-left' data-dismiss='modal'>Close</button>
				<button class='btn btn-primary btn-sm' type='submit' name='save' id='save'> Save</button>
			</div>
		</form>
																	</div>
																	<!-- /.modal-content -->
																</div>
																<!-- /.modal-dialog -->
															</div>
															
													<script>
													$(document).ready(function(){
														$(
														'#program_form<?php echo $level['scale_id']."_".$_REQUEST['id']."_".$levelindicator['comp_def_level_ind_id']?>').validationEngine();
													});
													</script>
														</td>
																		</tr>
																		<?php 
																		}
																	}?>
																		</tbody>
																	</table>
																<?php }?>
												</div>
												</div>
											<div id="tab-keyQuest<?php echo $level['scale_id']; ?>" class="tab-pane">
												<div class="panel-body">
													<div class="panel-heading hbuilt">
														
														<div class="pull-left">
															<h6 class="panel-title txt-dark">Questionnaire Creation</h6>
														</div>
														<div class="pull-right">
															<a style="cursor: pointer;" onclick="open_element(<?php echo $level['scale_id']; ?>,<?php echo $_REQUEST['id']; ?>);"  data-toggle="modal" data-target="#example_Modal<?php echo $level['scale_id']; ?>" class="btn btn-primary btn-xs pull-left mr-15">&nbsp; <i class="fa fa-plus-circle"></i> Create Element &nbsp; </a>
														</div>
														<div class="clearfix"></div>
													</div>
													
													<div class="table-responsive">
														<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
															<thead>
															<tr>
																<th>Element Name</th>
																<th>Scale Name</th>
																<th>View</th>
															</tr>
															</thead>
															<tbody>
															<?php 
															$element_details=UlsCompetencyDefLevelElements::getcompdeflevelelement_details($_REQUEST['id'],$level['scale_id']);
															foreach($element_details as $element_detail){
															?>
															<tr id="inbasketdel_<?php echo $element_detail['element_id']; ?>">
																<td><?php echo $element_detail['element_name']; ?></td>
																<td><?php echo $element_detail['scale_name']; ?></td>
																<td>
																	<a class="mr-10" data-placement="top" title="" data-original-title="Update" style="cursor: pointer;" onclick="open_element_edit(<?php echo $level['scale_id']; ?>,<?php echo $_REQUEST['id']; ?>,<?php echo $element_detail['element_id']; ?>);"  data-toggle="modal" data-target="#example_Modal<?php echo $level['scale_id']; ?>_<?php echo $element_detail['element_id']; ?>"><i class="fa fa-pencil text-primary"></i> </a>
																	<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" id="<?php echo $element_detail['element_id']; ?>" name="deletelevelelement" rel="inbasketdel_<?php echo $element_detail['element_id']; ?>" onclick="deletefunction(this)"><i class="fa fa-trash text-danger"></i> </a>
																</td>
															</tr>
															
															<div class="modal fade" id="example_Modal<?php echo $level['scale_id']; ?>_<?php echo $element_detail['element_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
																<div class="modal-dialog modal-lg">
																	<div class="modal-content">
																		<div id="txtHint_element<?php echo $level['scale_id']; ?>_<?php echo $element_detail['element_id']; ?>"></div>
																	</div>
																	<!-- /.modal-content -->
																</div>
																<!-- /.modal-dialog -->
															</div>
															<?php
															}
															?>
															</tbody>
														</table>
													</div>
													<div class="modal fade" id="example_Modal<?php echo $level['scale_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
														<div class="modal-dialog modal-lg">
															<div class="modal-content">
																<div id="txtHint_element<?php echo $level['scale_id']; ?>"></div>
															</div>
															<!-- /.modal-content -->
														</div>
														<!-- /.modal-dialog -->
													</div>
												</div>
											</div>
											<div id="tab-keyint<?php echo $level['scale_id']; ?>" class="tab-pane">
												<div class="panel-body">
													<div class="panel-heading hbuilt">
														
														<div class="pull-left">
															<h6 class="panel-title txt-dark">Interview Question Creation</h6>
														</div>
														<div class="pull-right">
															<a style="cursor: pointer;" onclick="open_interview(<?php echo $level['scale_id']; ?>,<?php echo $_REQUEST['id']; ?>);"  data-toggle="modal" data-target="#example_Modal_int<?php echo $level['scale_id']; ?>" class="btn btn-primary btn-xs pull-left mr-15">&nbsp; <i class="fa fa-plus-circle"></i> Create Interview Scenario &nbsp; </a>
														</div>
														<div class="clearfix"></div>
													</div>
													
													<div class="table-responsive">
														<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
															<thead>
															<tr>
																<th>Scenario Name</th>
																<th>View</th>
															</tr>
															</thead>
															<tbody>
															<?php 
															$interview_details=UlsCompetencyDefLevelInterview::getcompdeflevelint_details($_REQUEST['id'],$level['scale_id']);
															foreach($interview_details as $interview_detail){
															?>
															<tr id="interviewdel_<?php echo $interview_detail['comp_int_id']; ?>">
																<td><?php echo $interview_detail['int_scenario']; ?></td>
																
																<td>
																	<a class="mr-10" data-placement="top" title="" data-original-title="Update" style="cursor: pointer;" onclick="open_interview_edit(<?php echo $level['scale_id']; ?>,<?php echo $_REQUEST['id']; ?>,<?php echo $interview_detail['comp_int_id']; ?>);"  data-toggle="modal" data-target="#example_Modal_int<?php echo $level['scale_id']; ?>_<?php echo $interview_detail['comp_int_id']; ?>"><i class="fa fa-pencil text-primary"></i> </a>
																	
																	<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" id="<?php echo $interview_detail['comp_int_id']; ?>" name="deletelevelinterview" rel="interviewdel_<?php echo $interview_detail['comp_int_id']; ?>" onclick="deletefunction(this)"><i class="fa fa-trash text-danger"></i> </a>
																</td>
															</tr>
															
															<div class="modal fade" id="example_Modal_int<?php echo $level['scale_id']; ?>_<?php echo $interview_detail['comp_int_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" data-backdrop="static">
																<div class="modal-dialog modal-lg" style="width:1200px;">
																	<div class="modal-content">
																		<div id="txtHint_interview<?php echo $level['scale_id']; ?>_<?php echo $interview_detail['comp_int_id']; ?>"></div>
																	</div>
																	<!-- /.modal-content -->
																</div>
																<!-- /.modal-dialog -->
															</div>
															
															<?php
															}
															?>
															</tbody>
														</table>
													</div>
													
													<div class="modal fade" id="example_Modal_int<?php echo $level['scale_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" data-backdrop="static">
														<div class="modal-dialog modal-lg" style="width:1200px;">
															<div class="modal-content">
																<div id="txtHint_interview<?php echo $level['scale_id']; ?>"></div>
															</div>
															<!-- /.modal-content -->
														</div>
														<!-- /.modal-dialog -->
													</div>
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
		
	</div>

</div>
