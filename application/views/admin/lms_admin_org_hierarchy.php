<script>
<?php 
//To send organization names to .js file
$org='';
foreach($orgnz_data as $orgnz_datas){
	if($orgnz_datas->org_type!='PO'){
		if($org==''){
			$org=$orgnz_datas->orgid."*".$orgnz_datas->orgname;
		}
		else{
			$org=$org.",".$orgnz_datas->orgid."*".$orgnz_datas->orgname;
		}
	}
}
echo "var orgdata='".$org."';"; 
?>
</script>

<div class="content">
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-inverse card-view">
			<div class="panel-body">
				<form class="form-horizontal" id="org_hierarchy" action="<?php echo BASE_URL;?>/admin/heirarchy_details" method="post">	
				<?php if(isset($_SESSION['msg'])){ echo "<div class='alert alert-success'><button data-dismiss='alert' class='close' type='button'><i class='ace-icon fa fa-times'></i></button><p>".$_SESSION['msg']."</p></div>"; unset($_SESSION['msg']);} ?>
				<input type="hidden" name="key_value" id="key_value" value="0" />
				<div class='row'>
					<div class='col-xs-12 col-sm-3'>
						Hierarchy Name<sup><font color="#FF0000">*</font></sup><br>
						<input type='hidden' name='hierarchy_id' id='hierarchy_id' value='<?php echo (isset($last_hiername['hierarchy_id']))?$last_hiername['hierarchy_id']:''?>'>
						<input type="text" class="validate[required,minSize[2],maxSize[80],custom[alphanumericSp],ajax[ajaxHierarchyName]] form-control" name="heirarchy_name" id="heirarchy_name" value="<?php echo (isset($last_hiername['hierarchy_name']))?$last_hiername['hierarchy_name']:''?>">
					</div>
					<div class='col-xs-12 col-sm-3'>
						Start Date<br>
						<div class="input-large">
							<div class="input-group">
								<input type="text" class="datepicker input-large date-picker form-control" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="start_date" id="start_date" value="<?php echo (isset($last_hiername['start_date']))?($last_hiername['start_date']!=NULL)?date('d-m-Y',strtotime($last_hiername['start_date'])):'':''?>">			
								<span class="input-group-addon">
									<i class="ace-icon fa fa-calendar"></i>
								</span>
							</div>
						</div>				
					</div>
					<div class='col-xs-12 col-sm-3'>
						End Date<br>
						<div class="input-large">
							<div class="input-group">	
								<input type="text" class="validate[future[#start_date]] datepicker input-large date-picker form-control" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="end_date" id="end_date" value="<?php echo (isset($last_hiername['end_date']))?($last_hiername['end_date']!=NULL)?date('d-m-Y',strtotime($last_hiername['end_date'])):'':''?>">		
								<span class="input-group-addon">
									<i class="ace-icon fa fa-calendar"></i>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="page-header"><h5>Parent Organization</h5></div>
				<div class="form-group">
					<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Parent Organization<sup><font color="#FF0000">*</font></sup>:</label>
					<div class="col-xs-12 col-sm-9">
						<div class="">
							<div id="parent_org" style="float:left;">
								<input type='hidden' name='hierarchy_id' id='hierarchy_id' value="<?php echo (isset($_REQUEST['hier_id']))?$_REQUEST['hier_id']:''?>">
								<select class="chosen-select validate[required] form-control m-b" name="parent_org_name" id="parent_org_name" style="width:210px;" onclick="check_hierarchy()">
									<option value="">Select</option>
								<?php 	$po_id='';$newtd='';
										if(count($last_details)>0){
											$newtd="<td><img id='select_parent' src='".BASE_URL."/public/images/down_arrow.png' onclick='getchildorgs()' style='margin-top:4px; cursor:pointer;' title='Move Down' /></td>";
											foreach($last_details as $po){
												$po_id=$po['parent_org_id'];
											}
											foreach($all_orgnz as $org_data){
												$po_sel=($po_id!='' &&  $po_id==$org_data->id)? "selected='selected'":''?>
												<option value="<?php echo $org_data->id;?>" <?php echo $po_sel;?>><?php echo $org_data->name;?></option>
									<?php 	}
										}
										else{
											foreach($po_orgnz as $org_value){
												$po_sel=($po_id!='' &&  $po_id==$org_value->orgid)? "selected='selected'":''?>
												<option value="<?php echo $org_value->orgid;?>" <?php echo $po_sel;?>><?php echo $org_value->orgname;?></option>
									<?php 	}
										}?>
								</select>
							</div>
							<div><?php echo $newtd;?></div>
						</div>
					</div>
				</div>
				<div class="space-2"></div>
				<div class="page-header"><h5>Child Organizations</h5></div>
				<div>        
					<input type="button" name="add" id="add" value="Add" class="btn btn-sm btn-primary" onclick="Add_Row()" />
					<input type="button" class="btn btn-sm btn-primary" name="del" id="del" value="Delete" onclick="Delete_Row()" />
				</div> 
				<table class="table table-striped table-bordered table-hover" style="width: 1022px; margin-bottom: 0px;">
					<thead>
						<tr>
							<th style="width: 25px;">Select</th>
							<th style="width: 315px;">Organization Name</th>
							<th style="width: 208px;">Organization Type</th>
							<th style="width: 65px;"></th>
						</tr>
					</thead>
				</table>
				<div id="table_id" style="height:250px; overflow:auto; width: 1020px;">
					<table id="org_data" class="table table-striped table-bordered table-hover" style="width: 1022px;">
						<tbody>
					<?php 	if(count($last_details)>0){
								$value=array();
								foreach($last_details as $key=>$details){
									$value[]=$key;?>
									<tr id='hier_row_<?php echo $key;?>'>
										<td style='padding-left:15px; width: 55px;'>
											<input type='hidden' name='id[]' id='id[<?php echo $key?>]' value='<?php echo $details['id']?>'>
											<input type="checkbox" name="hier_chk_[]" id="hier_chk_<?php echo $key?>" value="<?php echo $key?>" />
										</td>
										<td style="width: 315px;">
											<select class="chosen-select form-control m-b" name="org_list[]" id="org_list[<?php echo $key?>]" style="width:250px;" onchange="getOrg_type(<?php echo $key?>)">
												<option value="">Select</option>
										<?php 	foreach($orgnz_data as $org_value){
													if($org_value->org_type!='PO'){
														$org_sel=($org_value->orgid==$details['org_id'])?"selected='selected'":''?>
														<option value="<?php echo $org_value->orgid;?>" <?php echo $org_sel;?>><?php echo $org_value->orgname;?></option>
										<?php 		}
												}?>				
											</select>				
										</td>
										<td style="width: 208px;"><div id="input_type[<?php echo $key?>]"><?php echo $details['value_name']?></div></td>
										<td style="width: 65px;">
											<p align='center'><img id="select_child" src="<?php echo BASE_URL;?>/public/images/up_arrow.png" onclick="Ajax_upgrade_child(<?php echo $key?>)" style='cursor:pointer;' /></p>
										</td>
									</tr>
						<?php 	}	$hiddenval=@implode(',',$value);
							}
							else{$hiddenval=0;?>
								<tr id='hier_row_0'>
									<td style='padding-left:15px; width: 55px;'>
										<input type='hidden' name='id[]' id='id[0]' value=''>
										<input type="checkbox" name="hier_chk_[]" id="hier_chk_0" value="0" />
									</td>
									<td style="width: 315px;">
										<select class="chosen-select form-control m-b" name="org_list[]" id="org_list[0]" style="width:250px;" onchange="getOrg_type(0)">
											<option value="">Select</option>
										<?php 	foreach($orgnz_data as $org_value){
													if($org_value->org_type!='PO'){?>
														<option value="<?php echo $org_value->orgid;?>"><?php echo $org_value->orgname;?></option>
										<?php 		}
												}?>
										</select>				
									</td>
									<td style="width: 208px;"><div id="input_type[0]"></div></td>
									<td style="width: 65px;">
										<p align='center'><img id="select_child" src="<?php echo BASE_URL;?>/public/images/up_arrow.png" onclick="upgrade_child()" /></p>
									</td>
								</tr>
					<?php 	}?>
						<input type='hidden' id='inner_hidden_id' value='<?php echo $hiddenval;?>' name="inner_hidden_id" /></tbody>
					</table>
					<div id="error_div" style="float:right; margin-top:-80px; margin-right:40px;"></div>
				</div>
				<div class="hr-line-dashed"></div>
				<div class="form-group">
					<div class="col-sm-offset-9">
						<a class="btn btn-primary btn-sm" onclick="create_link('hierarchy_master')" href="#">Cancel</a>
						<button class="btn btn-primary btn-sm" type="submit" name="save" id="save" onclick="return validate()">Save changes</button>
					</div>
				</div>
				
				</form>
			</div>
        </div>
    </div>
</div>
</div>
<div id="msg_box33" class="lightbox pre_register" style="background:#FBFBFB;border-shadow:5px #333333;border-radius:5px solid #595959; position:fixed; width:35%;"></div>