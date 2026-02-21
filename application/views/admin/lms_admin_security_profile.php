<?php 
if(count($last_record)>0){
	foreach($last_record as $last_rec){
		$p_name=$last_rec['profile_name'];
		$p_id=$last_rec['parent_org_id'];
		$status=$last_rec['value_code'];
		$sec_type=$last_rec['security_type'];
		$hier_id=$last_rec['hierarchy_id'];
		$top_org=$last_rec['top_organization'];
		$sec_hier_id=$last_rec['secure_hierarchy_id'];
	}
}else{$p_name='';$p_id='';$status='';$sec_type='';$sec_hier_id='';}
?>
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">
				<div class="panel-heading hbuilt">
					<font color="#FF0000">* Indicated are Mandatory <br></font>
				</div>
                <div class="panel-body">
					
					<form id="sec_profile" action="<?php echo BASE_URL;?>/admin/security_details" method="post" class="form-horizontal">
					
						<div class="form-group"><label class="col-sm-3 control-label">Profile Name<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5"><input type="text" id="profile_name" name="profile_name" class="validate[required,funcCall[checknotinteger],minSize[2],maxSize[30],ajax[ajaxGrade]]  form-control" value='<?php echo $p_name;?>'>
							<input type='hidden' name='secure_profile_id' id='secure_profile_id' value='<?php echo (isset($_REQUEST['secure_id']))?$_REQUEST['secure_id']:'';?>'></div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Parent Organization<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<select name="parent_org_id" id="parent_org_id" onchange='getLocations()' class="validate[required] form-control m-b" >
									<option value=''>Select</option>
									<?php 	
									foreach($parent_orgs as $parent_org){
										$p_sel=($p_id==$parent_org['orgid'])?"selected='selected'":'';?>
										<option value="<?php echo $parent_org['orgid'];?>" <?php echo $p_sel;?>><?php echo $parent_org['orgname'];?></option>
									<?php 	
									} ?>
								</select>
							</div>
						</div>
						
						<div class="form-group"><label class="col-sm-3 control-label"> Status<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<select id="status" name="status" class="validate[required]  form-control m-b" >
									<option value=''>Select</option>
									<?php 	
									foreach($gradestatus as $pocstatus){
										$s_sel=($status==$pocstatus['code'])?"selected='selected'":'';?>
										<option value="<?php echo $pocstatus['code'];?>" <?php echo $s_sel;?> ><?php echo $pocstatus['name'];?></option>
									<?php 	
									} ?>
								</select>
							</div>
						</div>
						<div class="hr-line-dashed"></div>
						<ul class="nav nav-tabs">
							<li class="active"><a data-toggle="tab" href="#tab-1"> Organization</a></li>
							<li class=""><a data-toggle="tab" href="#tab-2">Location</a></li>
						</ul>
						<div class="tab-content">
							<div id="tab-1" class="tab-pane active">
								<div class="panel-body">
									<strong>Organization</strong>
									<input type='hidden' name='secure_hierarchy_id' id='secure_hierarchy_id' value='<?php echo $sec_hier_id;?>'>
									<div class="form-group"><label class="col-sm-3 control-label">Security Type:</label>
										<div class="col-sm-5">
											<select  id="sec_type" class="validate[required] form-control m-b" name="sec_type" onchange='secure_type()'>
												<option value="">Select</option>
												<?php $no_sel=($sec_type=='no')?"selected='selected'":'';
													$org_sel=($sec_type=='org')?"selected='selected'":'';?>
												<option value="no" <?php echo $no_sel;?>>No Security</option>
												<option value="org" <?php echo $org_sel;?>>Organization Security</option>
											</select>
										</div>
									</div>
									<?php $org_disp=($sec_type=='org')?"block":'none';?>
									<?php $org_disp=($sec_type=='org')?"block":'none';?>
									<div id='secorg' style='display:<?php echo $org_disp;?>;'>
										<div class="form-group"><label class="col-sm-3 control-label">Select Hierarchy:</label>
											<div class="col-sm-5">
												<select  id="hier_name" class="form-control m-b" name="hier_name">
													<option value="">Select</option>
														<?php 	
														if(count($last_record)>0){
															$hier=UlsHeirarchyMaster::hierarchynames($p_id);
															if(count($hier)>0){														
																foreach($hier as $hiers){
																	$sel=($hier_id==$hiers['hierarchy_id'])?"selected='selected'":'';
																	echo "<option value=".$hiers['hierarchy_id']." ".$sel.">".$hiers['hierarchy_name']."</option>";
																}
															}
														}?>
												</select>
											</div>
										</div>
										<div class="form-group"><label class="col-sm-3 control-label">Top Organization <div id='man_org' style='display:none;'><sup><font color="#FF0000">*</font></sup></div>:</label>
											<div class="col-sm-5">
												<select  id="top_org" class="form-control m-b" name="top_org">
													<option value="">Select</option>
													<?php 	
													if(count($last_record)>0){
														$org_names=UlsOrganizationMaster::orgNames($p_id);
														if(count($org_names)>0){
															foreach($org_names as $org_name){
																$t_sel=($top_org==$org_name['id'])?"selected='selected'":'';
																echo "<option value=".$org_name['id']." ".$t_sel.">".$org_name['name']."</option>";
															}
														}
													}?>
												</select>
											</div>
										</div>
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="headingOne">
												<h6 class="panel-title">
													<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
														Add Organization
													</a>
												</h6>
											</div>
											<?php if(count($last_record)>0){$collapsed="collapse in";}else{$collapsed="collapse";}?>
											<div id="collapseOne" class="panel-collapse <?php echo $collapsed;?>" role="tabpanel" aria-labelledby="headingOne">
												<div class="panel-body">
													<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id='org_details'>
														<thead>
															<tr>
																<th>Select</th>
																<th>Organization Name</th>
																<th>Organization Type</th>
															</tr>
														</thead>
														<tbody>
														<?php 	
														if(count($last_record)>0){
															$var=array();$orgsid=array();
															foreach($last_record as $key=>$last_rec){
																if(!in_array($last_rec['secure_org_id'],$orgsid)){
																	$orgsid[]=$last_rec['secure_org_id'];
																	$var[]=$key;?>
																	<tr id="orgs<?php echo $key;?>">
																		<td style="padding-left:20px;" class="hidden-480">
																			<input type="hidden" name="secure_org_id[]" id="secure_org_id[<?php echo $key;?>]" value="<?php echo $last_rec['secure_org_id'];?>">
																			<input type="checkbox"  name="orgs_chk" id="orgs_chk_<?php echo $key;?>" value="<?php echo $key;?>" />
																		</td>
																		<td>
																			<select class="form-control m-b" name="orgname[]" id="orgname[<?php echo $key;?>]" onchange='orgtypes(<?php echo $key;?>)'  style='width: 50%;' />
																				<option value=''>Select</option>
																				<?php	
																				$org_names=UlsOrganizationMaster::orgNames($p_id);
																				if(count($org_names)>0){
																					foreach($org_names as $org_name){
																						$or_sel=($last_rec['organization_id']==$org_name['id'])?"selected='selected'":'';
																						echo "<option value=".$org_name['id']." ".$or_sel.">".$org_name['name']."</option>";
																					}
																				}?>
																			</select>
																		</td>
																		<td>
																			<div id="orgtype[<?php echo $key;?>]">
																				<?php	
																				$org_values=UlsOrganizationMaster::orgtypes($last_rec['organization_id']);
																				if(count($org_values)>0){
																					foreach($org_values as $org_value){					
																						echo $org_value['value_name'];
																					}
																				}?>	
																			</div>
																		</td>
																	</tr>
																<?php 
																$val=@implode(',',$var);
																}
															}
														}
														else{$val=0; ?>
															<tr id="orgs0">
																<td style="padding-left:20px;" class="hidden-480">
																	<input type="hidden" name="secure_org_id[]" id="secure_org_id[0]" value="">
																	<input type="checkbox"  name="orgs_chk" id="orgs_chk_0" value="0" />
																</td>
																<td>
																	<select class="form-control m-b" name="orgname[]" id="orgname[0]" onchange='orgtypes(0)' style='width: 50%;' />
																		<option value=''>Select</option>
																	</select>
																</td>
																<td>
																	<div id="orgtype[0]"> </div>
																</td>
															</tr>
														<?php 
														}?>	
														</tbody>
													</table>
													<input type='hidden' id='exp_hidden_id' value='<?php echo $val;?>' name="exp_hidden_id" />
													<div>
														<a class="btn btn-success"  name="addrow" id="addrow" onClick="AddOrgs()">Add Row</a>
														<a class="btn btn-danger" name="delete" id="delete" value="Delete" onClick="DelOrgs()">Delete</a>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<div class="col-sm-offset-5">
											<button class="btn btn-danger" type="button" onclick="create_link('security_search')">Cancel</button>
											<button class="btn btn-success" type="submit" name="formsubmit" id="formsubmit" onclick='return org_validate()'>Save changes</button>
										</div>
									</div>
								</div>
							</div>
							<div id="tab-2" class="tab-pane">
								<div class="panel-body">
									<strong>Location</strong>
									<?php if(count($last_record)>0){$collapse="";}else{$collapse="collapsed";} ?>
									<div class="panel panel-default">
										<div class="panel-heading" role="tab" id="headingTwo">
											<h6 class="panel-title">
												<a class="<?php echo $collapse;?>" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
													Locations
												</a>
											</h6>
										</div>
										<?php if(count($last_record)>0){$collapsed="collapse in";}else{$collapsed="collapse";} ?>
										<div id="collapseTwo" class="panel-collapse <?php echo $collapsed;?>" role="tabpanel" aria-labelledby="headingTwo">
											<div class="panel-body">
												<div class="table-responsive">
													<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id='loc_details'>
														<thead>
															<tr>
																<th>Select</th>
																<th>Location</th>
															</tr>
														</thead>
														<tbody>
														<?php 	
														if(count($last_record)>0){
															$var=array();$locsid=array();
															foreach($last_record as $key=>$last_rec){
																if(!in_array($last_rec['secure_location_id'],$locsid)){
																	$locsid[]=$last_rec['secure_location_id'];
																	$var[]=$key;?>
																	<tr id="locs<?php echo $key;?>">
																		<td style="padding-left:20px; width: 10%;" class="hidden-480">
																			<input type="hidden" name="secure_location_id[]" id="secure_location_id[<?php echo $key;?>]" value="<?php echo $last_rec['secure_location_id'];?>">
																			<input type="checkbox"  name="locs_chk" id="locs_chk_<?php echo $key;?>" value="<?php echo $key;?>" />
																		</td>
																		<td>
																			<select class="form-control m-b" name="location[]" id="location[<?php echo $key;?>]" style='width: 50%;' />
																				<option value=''>Select</option>
																		<?php	$locations=UlsLocation::get_locations($p_id);
																				if(count($locations)>0){
																					foreach($locations as $location){
																						$l_sel=($location->location_id==$last_rec['location_id'])?"selected='selected'":'';
																						echo "<option value=".$location->location_id." ".$l_sel.">".$location->location_name."</option>";
																					}
																				}?>
																			</select>
																		</td>												
																	</tr>
																<?php 				
																$val=@implode(',',$var);
																}
															}
														}
														else{$val=0; ?>
															<tr id="locs0">
																<td style="padding-left:20px; width: 10%;" class="hidden-480">
																	<input type="hidden" name="secure_location_id[]" id="secure_location_id[0]" value="">
																	<input type="checkbox"  name="locs_chk" id="locs_chk_0" value="0" />
																</td>
																<td>
																	<select class="form-control m-b" name="location[]" id="location[0]" style='width: 50%;' />
																		<option value=''>Select</option>
																	</select>
																</td>
															</tr>
														<?php 	
														}?>
														</tbody>
													</table>
													<input type='hidden' id='loc_hidden_id' value='<?php echo $val;?>' name="loc_hidden_id" />
													<div class="pull-left">
														<a class="btn btn-success"  name="addrow" id="addrow" onClick="AddLocs()">Add Row</a>
														<a class="btn btn-danger" name="delete" id="delete" value="Delete" onClick="DelLocs()">Delete</a>
													</div>
												</div>
												
											</div>
										</div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<div class=" col-sm-offset-5">
											<button class="btn btn-danger" type="button" onclick="create_link('security_search')">Cancel</button>
											<button class="btn btn-success" type="submit"  name="save" id="save" >Save changes</button>
										</div>
									</div>
								</div>
							</div>
						</div>
						
					</form>
				</div>
            </div>
        </div>
    </div>
</div>
