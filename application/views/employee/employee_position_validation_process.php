<script>
<?php
foreach($_REQUEST as $key=>$val){
	if($key=="status"){
		echo "var ".$key."='".$val."';";
	}
}
?>
</script>

<section class="main-section">
	<div class="container">
		<div class="row">
			<!-- TEST SECTION :BEGIN -->
			<div class="test-section">
				<!-- TEST HEAD SECTION :BEGIN -->
				<div class="test-head-section">
					<div class="d-flex align-items-center justify-content-between">
						<div class="test-head">
							<div class="icon material-icons">supervised_user_circle</div>
							<div class="test-info">
								<div class="test-name">Position Validation Process</div>
								<p class="test-content red-text">Technical</p>
							</div>
						</div>
						<div class="time-head">
							<div class="time-icon material-icons">done</div>
							<div class="time-info">
								<p class="time"><span class="minute"><span id="taskID"><?php echo $_REQUEST['id']; ?></span>/4 Task</span></p>
							</div>
						</div>
					</div>
				</div>
				<!-- TEST HEAD SECTION :END -->

				<div class="space-40"></div>

				<ul class="test-nav-panel d-flex align-items-center">
					<?php
					if(isset($_REQUEST['val_id'])){
					?>
					<li class="flex active" data-tab-id="self-assessment" id='compentencies_li'>
						<span class="num">1</span>
						<span class="txt">JD Validation</span>
					</li>
					<li class="flex" data-tab-id="career-planning" id='employees_li'>
						<span class="num">2</span>
						<span class="txt">Competency Profile Validation</span>
					</li>
					<li class="flex" data-tab-id="strengths-tab" id='strengths_li'>
						<span class="num">3</span>
						<span class="txt">KRA's Validation</span>
					</li>
					
					<?php }
					else{
					?>
					<li class="flex active" data-tab-id="self-assessment" id='compentencies_li'>
						<span class="num">1</span>
						<span class="txt">JD Validation</span>
					</li>
					<li class="flex">
						<span class="num">2</span>
						<span class="txt">Competency Profile Validation</span>
					</li>
					<li class="flex">
						<span class="num">3</span>
						<span class="txt">KRA's Validation</span>
					</li>
					<?php
					}
					?>
				</ul>

				<!-- TEST BODY :BEGIN -->
				
					<div id="self-assessment" class="tast-tab-nav">
						<form id="assessment_master" action="<?php echo BASE_URL;?>/employee/employee_position_validation_insert" method="post" enctype="multipart/form-data" class="form-horizontal">
						<input type="hidden" name="val_id" id="val_id" value="<?php echo $_REQUEST['val_id']?>">
						<input type="hidden" name="position_id" id="position_id" value="<?php echo $_REQUEST['position_id'];?>">
						<input type="hidden" name="val_pos_id" id="val_pos_id" value="<?php echo $_REQUEST['val_pos_id'];?>">
						<input type="hidden" name="pos_temp_id" id="pos_temp_id" value="<?php echo (isset($emp_validation_details['pos_temp_id']))?$emp_validation_details['pos_temp_id']:''?>">
						<input type="hidden" name="jid" id="jid" value="<?php echo $_REQUEST['jid'];?>">
						<div class="test-nav-scoll custom-scroll">
							<div class="test-body">
								<div class="form-group">
									<label class="label">Accountabilities:</label>
									
									
									<textarea class="textarea-control" rows="4" name="accountabilities" id="accountabilities" ><?php echo (isset($emp_validation_details['accountabilities']))?$emp_validation_details['accountabilities']:"";?></textarea>
								</div>

								<div class="form-group">
									<label class="label">Responsibilities:</label>
									<textarea class="textarea-control" rows="4" name="responsibilities" id="responsibilities"><?php echo (isset($emp_validation_details['responsibilities']))?$emp_validation_details['responsibilities']:"";?></textarea>
								</div>
							</div>
						</div>
						<div class="test-footer d-flex align-items-center justify-content-between">
							<a href="javascript:;" class="btn btn-light idp-nav-back-btn">Back</a>
							<button class="btn btn-primary" type="submit" name="summary_info_submit" id="summary_info_submit" >Next</button>
						</div>
						
						</form>
					</div>
					<div id="career-planning" class="tast-tab-nav display-none">
						<form id="case_master" action="<?php echo BASE_URL;?>/employee/validation_position_competency_insert" method="post" enctype="multipart/form-data">
						<input type="hidden" name="val_id" id="val_id" value="<?php echo $_REQUEST['val_id']?>">
						<input type="hidden" name="position_id" id="position_id" value="<?php echo $_REQUEST['position_id'];?>">
						<input type="hidden" name="val_pos_id" id="val_pos_id" value="<?php echo $_REQUEST['val_pos_id'];?>">
						<input type="hidden" name="jid" id="jid" value="<?php echo $_REQUEST['jid'];?>">
						<div class="test-nav-scoll custom-scroll">
							<?php 
							foreach($comp_details as $comp_detail){
							?>
							<div class="test-body">
								<input type="hidden" id="category_id<?php echo $comp_detail['category_id']; ?>" name="category_id[]" value="<?php echo $comp_detail['category_id']; ?>">
								<h5><?php echo $comp_detail['name']; ?></h5>
								<hr/>
								<?php
								$competency=UlsPositionTemp::get_self_validation_competencies_summary($_REQUEST['val_id'],$_REQUEST['position_id'],$_REQUEST['val_pos_id'],$comp_detail['category_id']);
								foreach($competency as $key=>$competencys){
								?>
								<div class="case-question-box">
									<div class="number"><?php echo ($key+1); ?></div>
									<div class="case-details">
										<div class="d-flex align-items-center justify-content-between">
											<input type="hidden" name="pos_comp_temp_id[]" value="<?php echo !empty($competencys['pos_comp_temp_id'])?$competencys['pos_comp_temp_id']:"";?>">
											<input type="hidden" name="competency[]" value="<?php echo $competencys['comp_def_id'];?>" >
											<input type="hidden" name="requiredlevel_<?php echo $competencys['comp_def_id'];?>" value="<?php echo $competencys['scale_id'];?>" >
											<label class="name"><?php echo $competencys['comp_def_name'];?></label>
											<span class="note">* Required level: <?php echo $competencys['scale_name'];?></span>
										</div>
										<div class="d-flex mb-3">
											<label class="label min-width">Require :</label>
											<?php 
											foreach($require as $requires){
												$final_req=!empty($competencys['required_process'])?$competencys['required_process']==$requires['code']?"checked='checked'":"":"";
											?>
											<div class="radio-group mr-4">
												<input name='required_process_<?php echo $competencys['comp_def_id'];?>' id='required_process_<?php echo $competencys['comp_def_id'];?>_<?php echo $requires['code']; ?>' type="radio" class="validate[required] radio-control" value="<?php echo $requires['code']; ?>" <?php echo $final_req; ?>>
												<label for="required_process_<?php echo $competencys['comp_def_id'];?>_<?php echo $requires['code']; ?>" class="radio-label"><?php echo $requires['name']; ?></label>
											</div>
											<?php
											}
											?>
										</div>
										<div class="d-flex mb-3">
											<label class="label min-width">Suggested Level :</label>
											<div class="row">
												<?php
												$level_id=UlsCompetencyDefinition::viewcompetency($competencys['comp_def_id']);
												$scale_overall=UlsLevelMasterScale::levelscale($level_id['comp_def_level']);
												foreach($scale_overall as $scales){
													$final_scale=!empty($competencys['assessed_scale_id'])?$competencys['assessed_scale_id']==$scales['scale_id']?"checked='checked'":"":"";
												?>
												<div class="col-4">
													<div class="radio-group mb-2">
														<input name='OVERALL_<?php echo $competencys['comp_def_id'];?>' id='OVERALL_<?php echo $competencys['comp_def_id'];?>_<?php echo $scales['scale_id']; ?>' type="radio"  class="validate[required] radio-control" value="<?php echo $scales['scale_id']; ?>" <?php echo $final_scale; ?>>
														<label for="OVERALL_<?php echo $competencys['comp_def_id'];?>_<?php echo $scales['scale_id']; ?>" class="radio-label"><a href="javascript:;" data-toggle="modal" data-target="#ass-rules-modal<?php echo $competencys['comp_def_id']; ?>" onclick="open_comp_level(<?php echo $competencys['comp_def_id']; ?>);"><?php echo $scales['scale_name']; ?></a></label>
													</div>
												</div>
												<?php } ?>
											</div>
										</div>
										<div class="modal fade case-modal" id="ass-rules-modal<?php echo $competencys['comp_def_id']; ?>" tabindex="-1" role="dialog">
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
														<div class='custom-scroll'>
														<div id="level_comp<?php echo $competencys['comp_def_id']; ?>">
														</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="d-flex">
											<label class="label min-width">Reason:</label>
											<div class="row flex">
												<div class="col-7">
													<div class="form-group">
														<textarea class="textarea-control validate[required]" rows="4" name="reason_<?php echo $competencys['comp_def_id'];?>"><?php echo !empty($competencys['reason'])?$competencys['reason']:"";?></textarea>
													</div>
												</div>
												
											</div>
										</div>
									</div>
								</div>
								<?php 
								}?>
							</div>
							<h5>Add New Competency required in this <?php echo $comp_detail['name']; ?></h5>
							<hr/>
							<div class="panel-heading hbuilt">
								
								<div class="pull-right">
									<a class="btn btn-xs btn-primary" onclick="addsource_details_position(<?php echo $comp_detail['category_id']; ?>);">&nbsp <i class="fa fa-plus-circle"></i> Add &nbsp </a>
									<a class="btn btn-xs btn-danger" onclick="delete_position(<?php echo $comp_detail['category_id']; ?>);">&nbsp <i class="fa fa-trash-o"></i>  Delete &nbsp </a>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="table-responsive">
										
								<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="assessement_position<?php echo $comp_detail['category_id']; ?>">
									<thead>
									<tr>
										<th style="width:5%">Select</th>
										<th style="width:35%">Competency Name</th>
										<th style="width:20%">Suggested Level</th>
										<th style="width:20%">Reason</th>
									</tr>
									</thead>
									<tbody>
									<?php
									$cat_level=UlsCategory::get_cat_name($comp_detail['category_id']);
									$level_scale=UlsLevelMasterScale::levelscale($cat_level['level_id']);
									$position_details=UlsPositionCompetencyTempTray::get_self_validation_competencies($_REQUEST['val_id'],$_REQUEST['position_id'],$comp_detail['category_id']);
									if(!empty($position_details)){
										$hide_val=array();
										foreach($position_details as $key=>$position_detail){ 
											$key1=$key+1; $hide_val[]=$key1;
											?>
											<tr id='subgrd_position_<?php echo $comp_detail['category_id']; ?>_<?php echo $key1; ?>'>
												<td><label><input type="checkbox" id="chkbox_<?php echo $comp_detail['category_id']; ?>_<?php echo $key1; ?>" name="chkbox[]" value="<?php echo $position_detail['pos_comp_tray_id'];?>" ></label>
												<input type="hidden" id="pos_comp_tray_id_<?php echo $comp_detail['category_id']; ?>_<?php echo $key1; ?>" name="pos_comp_tray_id_<?php echo $comp_detail['category_id']; ?>[]" value="<?php echo $position_detail['pos_comp_tray_id'];?>">
												</td>
												<td>
													<input type="text" name="competency_name_<?php echo $comp_detail['category_id']; ?>[]" id="competency_name<?php echo $key1; ?>" class='form-control' value="<?php echo (isset($position_detail['competency_name']))?$position_detail['competency_name']:''?>">
												</td>
												<td>
													<select class="form-control m-b" name="require_scale_id_<?php echo $comp_detail['category_id']; ?>[]" id="require_scale_id_<?php echo $comp_detail['category_id']; ?>_<?php echo $key1; ?>">
														<option value="">Select</option>
														<?php 
														foreach($level_scale as $scales){
															$levelscale=!empty($position_detail['require_scale_id'])?$position_detail['require_scale_id']==$scales['scale_id']?"selected='selected'":"":"";
															?>
															<option value='<?php echo $scales['scale_id'];?>' <?php echo $levelscale;?>><?php echo $scales['scale_name'];?></option>
														<?php
														}
														?>
													</select>
												</td>
												<td>
													<input type="text" name="reason_<?php echo $comp_detail['category_id']; ?>[]" id="reason_<?php echo $comp_detail['category_id']; ?>_<?php echo $key1; ?>" class='form-control' value="<?php echo (isset($position_detail['reason']))?$position_detail['reason']:''?>" >
												</td>
											</tr>
										<?php 
										}
										$hidden_position=@implode(',',$hide_val);
									}
									else{?>
										<tr id='subgrd_position_<?php echo $comp_detail['category_id']; ?>_1'>
											<td><label><input type="checkbox" id="chkbox_<?php echo $comp_detail['category_id']; ?>_1" name="chkbox[]" value=""></label>
											<input type="hidden" id="pos_comp_tray_id_<?php echo $comp_detail['category_id']; ?>_1" name="pos_comp_tray_id_<?php echo $comp_detail['category_id']; ?>[]" value="">
											</td>
											<td>
												<input type="text" name="competency_name_<?php echo $comp_detail['category_id']; ?>[]" id="competency_name_<?php echo $comp_detail['category_id']; ?>_1" class='form-control'>
											</td>
											<td>
												<select class="form-control m-b" name="require_scale_id_<?php echo $comp_detail['category_id']; ?>[]" id="require_scale_id_<?php echo $comp_detail['category_id']; ?>_1">
													<option value="">Select</option>
													<?php 
													foreach($level_scale as $scales){
														?>
														<option value='<?php echo $scales['scale_id'];?>'><?php echo $scales['scale_name'];?></option>
													<?php
													}
													?>
												</select>
											</td>
											<td>
												<input type="text" name="reason_<?php echo $comp_detail['category_id']; ?>[]" id="reason_<?php echo $comp_detail['category_id']; ?>_1" class='form-control'>
											</td>
										</tr>
									<?php 
										$hidden_position=1;
									} ?>
									</tbody>
									<input type="hidden" name="addgroup_position_<?php echo $comp_detail['category_id']; ?>" id="addgroup_position_<?php echo $comp_detail['category_id']; ?>" value="<?php echo $hidden_position; ?>" />
								</table>
							</div>
							<script>
							function addsource_details_position(cat_id){
								var hiddtab="addgroup_position_"+cat_id;
								var ins=document.getElementById(hiddtab).value;
								if(ins!=''){
									var ins1=ins.split(",");
									var temp=0;
									for( var j=0;j<ins1.length;j++){
										if(ins1[j]>temp){
											temp=parseInt(ins1[j]);
										}
									}
									var maxa=Math.max(ins1);
									sub_iteration=parseInt(temp)+1;
									for( var j=0;j<ins1.length;j++){
										var i=ins1[j]; 
										var competency_name=document.getElementById('competency_name_'+cat_id+'_'+i).value;
										var require_scale_id=document.getElementById('require_scale_id_'+cat_id+'_'+i).value;
										if(competency_name==''){
											toastr.error("Please Enter Competency Name.");
											return false;
										}
										if(require_scale_id==''){
											toastr.error("Please Select Scale name.");
											return false;
										}
										for( var k=0;k<ins1.length;k++){
											l=ins1[k];
											var competency_name1=document.getElementById('competency_name_'+cat_id+'_'+l).value;
											if(k!=j){
												if(competency_name==competency_name1){
													toastr.error("Competency name should be Unique");
													return false;
												}
											}
										}
									}	
									sub_iteration=parseInt(temp)+1; 
								}
								else{
									sub_iteration=1;
									ins1=1;
									var ins1=Array(1);
								}
								
								$("#assessement_position"+cat_id).append("<tr id='subgrd_position_"+cat_id+"_"+sub_iteration+"'><td><input type='checkbox' id='chkbox_"+cat_id+"_"+sub_iteration+"' name='chkbox[]' value='"+sub_iteration+"'><input type='hidden' id='pos_comp_tray_id_"+cat_id+"_"+sub_iteration+"' name='pos_comp_tray_id_"+cat_id+"[]' value=''></td><td><input type='text' name='competency_name_"+cat_id+"[]' id='competency_name_"+cat_id+"_"+sub_iteration+"' class='form-control'></td><td><select name='require_scale_id_"+cat_id+"[]' id='require_scale_id_"+cat_id+"_"+sub_iteration+"' class='form-control m-b'><option value=''>Select</option><?php foreach($level_scale as $scales){?><option value='<?php echo $scales['scale_id'];?>'><?php echo $scales['scale_name'];?></option><?php } ?></select></td><td><input type='text' name='reason_"+cat_id+"[]' id='reason_"+cat_id+"_"+sub_iteration+"' class='form-control'></td></tr>");
								if(document.getElementById(hiddtab).value!=''){
									var ins=document.getElementById(hiddtab).value;
									document.getElementById(hiddtab).value=ins+","+sub_iteration;
								}
								else{
									document.getElementById(hiddtab).value=sub_iteration;
								}

							}
							
							function delete_position(cat_id){
								var hiddtab="addgroup_position_"+cat_id;
								var ins=document.getElementById(hiddtab).value;
								var arr1=ins.split(",");
								var flag=0;
								var tbl = document.getElementById('assessement_position'+cat_id);
								var lastRow = tbl.rows.length;
								for(var i=(arr1.length-1); i>=0; i--){
									var bb=parseInt(arr1[i]);
									var a="chkbox_"+cat_id+"_"+bb;
									if(document.getElementById(a).checked){
										var b=document.getElementById(a).value;
										var c="subgrd_position_"+cat_id+"_"+bb+"";
										//alert(b);
										var pos_comp_tray_id=document.getElementById("pos_comp_tray_id_"+cat_id+"_"+bb).value;
										//alert(calendar_act_id);
										if(pos_comp_tray_id!=' '){
											$.ajax({
												url: BASE_URL+"/employee/delete_validation_competency",
												global: false,
												type: "POST",
												data: ({val : pos_comp_tray_id}),
												dataType: "html",
												async:false,
												success: function(msg){
												}
											}).responseText;
										} 
										for(var j=(arr1.length-1); j>=0; j--) {
											if(parseInt(arr1[j])==bb) {
												arr1.splice(j, 1);
												break;
											}  
										}
										flag++;
										$("#"+c).remove();
									}
								}
								if(flag==0){
									toastr.error("Please select the Value to Delete");
									return false;
								}
								document.getElementById(hiddtab).value=arr1;
							}
							</script>
							<?php 
							}?>
						</div>
						<div class="test-footer d-flex align-items-center justify-content-between">
							<a href="javascript:;" class="btn btn-light idp-nav-back-btn">Back</a>
							<button class="btn btn-primary" type="submit" name="summary_info_submit" id="summary_info_submit" >Next</button>
						</div>
						</form>
					</div>
					<div id="strengths-tab" class="tast-tab-nav display-none">
						<form id="case_master" action="<?php echo BASE_URL;?>/employee/validation_position_kra_insert" method="post" enctype="multipart/form-data">
						<input type="hidden" name="val_id" id="val_id" value="<?php echo $_REQUEST['val_id']?>">
						<input type="hidden" name="position_id" id="position_id" value="<?php echo $_REQUEST['position_id'];?>">
						<input type="hidden" name="val_pos_id" id="val_pos_id" value="<?php echo $_REQUEST['val_pos_id'];?>">
						<input type="hidden" name="jid" value="<?php echo $_REQUEST['jid'];?>" >
						<div class="test-nav-scoll custom-scroll">
							<div class="test-body">
							<?php
							foreach($emp_kra_validation_details as $key=>$emp_kra_validation_detail){
								$datas=trim($emp_kra_validation_detail['kra_master_name']);
								if(!empty($datas)){
							?>
								<div class="case-question-box">
									<div class="number"><?php echo ($key+1); ?></div>
									<div class="case-details">
										<div class="d-flex align-items-center justify-content-between">
											<input type="hidden" name="pos_kra_temp_id[]" value="<?php echo !empty($emp_kra_validation_detail['pos_kra_temp_id'])?$emp_kra_validation_detail['pos_kra_temp_id']:"";?>">
											<input type="hidden" name="comp_kra_id[]" value="<?php echo $emp_kra_validation_detail['kra_id'];?>" >
											<label class="name"><?php echo $emp_kra_validation_detail['kra_master_name'];?></label>
											
										</div>
										<div class="d-flex mb-3">
											<label class="label min-width">KPI :</label>
											<label class="label min-width"><?php echo $emp_kra_validation_detail['kra_kri'];?></label>
										</div>
										<div class="d-flex mb-3">
											<label class="label min-width">UOM :</label>
											<label class="label min-width"><?php echo $emp_kra_validation_detail['kra_uom'];?></label>
										</div>
										<div class="d-flex mb-3">
											<label class="label min-width">Require :</label>
											<div class="row">
												<?php
												foreach($require as $e=>$requires){
												if($requires['code']!='M'){
													$final_req=!empty($emp_kra_validation_detail['required_process'])?$emp_kra_validation_detail['required_process']==$requires['code']?"checked='checked'":"":"";
												?>
												<div class="radio-group mr-4">
													<input name='required_process_<?php echo $emp_kra_validation_detail['kra_id'];?>' id='required_process_<?php echo $requires['code']; ?>_<?php echo $emp_kra_validation_detail['kra_id'];?>' type="radio"  class="validate[required] radio-control" value="<?php echo $requires['code']; ?>" <?php echo $final_req; ?>>
													<label for="required_process_<?php echo $requires['code']; ?>_<?php echo $emp_kra_validation_detail['kra_id'];?>" class="radio-label"><?php echo $requires['name']; ?></label>
												</div>
												
												<?php }
												}	
												?>
											</div>
										</div>
										
										<div class="d-flex">
											<label class="label min-width">Reason:</label>
											<div class="row flex">
												<div class="col-7">
													<div class="form-group">
														<textarea class="textarea-control validate[required]" rows="4" name="reason_<?php echo $emp_kra_validation_detail['kra_id'];?>"><?php echo !empty($emp_kra_validation_detail['reason'])?$emp_kra_validation_detail['reason']:"";?></textarea>
													</div>
												</div>
												
											</div>
										</div>
									</div>
								</div>
							<?php 
								}
							}?>
							<h5>Add New KRA's</h5>
							<hr/>
								<div class="panel-heading hbuilt">
									
									<div class="pull-right">
										<a class="btn btn-xs btn-primary" onclick="addsource_details_kra();">&nbsp <i class="fa fa-plus-circle"></i> Add &nbsp </a>
										<a class="btn btn-danger btn-xs" onclick="delete_kra();">&nbsp <i class="fa fa-trash-o"></i>  Delete &nbsp </a>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="table-responsive">
									<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="assessement_kra">
										<thead>
										<tr>
											<th style="width:5%">Select</th>
											<th style="width:35%">KRA</th>
											<th style="width:20%">KPI</th>
											<th style="width:20%">UOM</th>
											<th style="width:20%">Reason</th>
										</tr>
										</thead>
										<tbody>
										<?php
										if(!empty($emp_kra_details)){
											$hide_val=array();
											foreach($emp_kra_details as $key=>$emp_kra_detail){ 
												$key1=$key+1; $hide_val[]=$key1;
												?>
												<tr id='subgrd_kra_<?php echo $key1; ?>'>
													<td><label><input type="checkbox" id="chkbox_<?php echo $key1; ?>" name="chkbox[]" value="<?php echo $emp_kra_detail['pos_kra_tray_id'];?>" ></label>
													<input type="hidden" id="pos_kra_tray_id_<?php echo $key1; ?>" name="pos_kra_tray_id[]" value="<?php echo $emp_kra_detail['pos_kra_tray_id'];?>">
													</td>
													<td>
														<input type="text" name="kra_des[]" id="kra_des_<?php echo $key1; ?>" class='form-control' value="<?php echo (isset($emp_kra_detail['kra_des']))?$emp_kra_detail['kra_des']:''?>">
													</td>
													<td>
														<input type="text" name="kra_kri[]" id="kra_kri_<?php echo $key1; ?>" class='form-control' value="<?php echo (isset($emp_kra_detail['kra_kri']))?$emp_kra_detail['kra_kri']:''?>">
													</td>
													<td>
														<input type="text" name="kra_uom[]" id="kra_uom_<?php echo $key1; ?>" class='form-control' value="<?php echo (isset($emp_kra_detail['kra_uom']))?$emp_kra_detail['kra_uom']:''?>">
													</td>
													<td>
														<input type="text" name="reason_kra[]" id="reason_kra_<?php echo $key1; ?>" class='form-control' value="<?php echo (isset($emp_kra_detail['reason']))?$emp_kra_detail['reason']:''?>" >
													</td>
												</tr>
											<?php 
											}
											$hidden_position=@implode(',',$hide_val);
										}
										else{?>
											<tr id='subgrd_kra_1'>
												<td><label><input type="checkbox" id="chkbox_1" name="chkbox[]" value=""></label>
												<input type="hidden" id="pos_kra_tray_id_1" name="pos_kra_tray_id[]" value="">
												</td>
												<td>
													<input type="text" name="kra_des[]" id="kra_des_1" class='form-control'>
												</td>
												<td>
													<input type="text" name="kra_kri[]" id="kra_kri_1" class='form-control' value="">
												</td>
												<td>
													<input type="text" name="kra_uom[]" id="kra_uom_1" class='form-control' value="">
												</td>
												<td>
													<input type="text" name="reason_kra[]" id="reason_kra_1" class='form-control'>
												</td>
											</tr>
										<?php 
											$hidden_position=1;
										} ?>
										</tbody>
										<input type="hidden" name="addgroup_kra" id="addgroup_kra" value="<?php echo $hidden_position; ?>" />
									</table>
								</div>
							</div>
						</div>
						<div class="test-footer d-flex align-items-center justify-content-between">
							<a href="javascript:;" class="btn btn-light idp-nav-back-btn">Back</a>
							<button class="btn btn-primary" type="submit" name="summary_info_submit" id="summary_info_submit" >Next</button>
						</div>
						</form>
					</div>
					
				
				<!-- TEST BODY :END -->

				
			</div>
			<!-- TEST SECTION :END -->
		</div>
	</div>
</section>
