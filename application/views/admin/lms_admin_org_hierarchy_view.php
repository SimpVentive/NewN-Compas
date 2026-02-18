<script>
<?php 
//To send organization names to .js file
$org='';
foreach($orgnz_data as $orgnz_datas){
    if($org==''){
        $org=$orgnz_datas->orgid."*".$orgnz_datas->orgname;
    }
    else{
        $org=$org.",".$orgnz_datas->orgid."*".$orgnz_datas->orgname;
    }
}
echo "var orgdata='".$org."';"; 
?>
</script>
<div class="content">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-inverse card-view">
				<div class="panel-heading hbuilt">
					Organization Hierarchy
				</div>
				<div class="panel-body">
					<form name="org_hierarchy" id="org_hierarchy" action="<?php echo BASE_URL;?>/admin/heirarchy_details" method="post">		
					<input type="hidden" name="key_value" id="key_value" value="0" />
					<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1">
						<thead>
							<tr>
								<th style=" background-color: #edf3f4;width:20%"> Hierarchy Name</th>
								<th><input type='hidden' name='hierarchy_id' id='hierarchy_id' value='<?php echo (isset($last_hiername['hierarchy_id']))?$last_hiername['hierarchy_id']:''?>'>
								<?php  echo (isset($last_hiername['hierarchy_name']))?$last_hiername['hierarchy_name']:''?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Start Date</th>
								<th><input type='hidden' name='hierarchy_id' id='hierarchy_id' value='<?php echo (isset($last_hiername['hierarchy_id']))?$last_hiername['hierarchy_id']:''?>'>
								<?php  echo (isset($last_hiername['start_date']))?($last_hiername['start_date']!=NULL)?date('d-m-Y',strtotime($last_hiername['start_date'])):'':''?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%"> End Date</th>
								<th><input type='hidden' name='hierarchy_id' id='hierarchy_id' value='<?php echo (isset($last_hiername['hierarchy_id']))?$last_hiername['hierarchy_id']:''?>'>
								<?php  echo (isset($last_hiername['end_date']))?($last_hiername['end_date']!=NULL)?date('d-m-Y',strtotime($last_hiername['end_date'])):'':''?>&nbsp;</th>
							</tr>
						</thead>
					</table>
					<div class="page-header"><h5>Parent Organization</h5></div>
					<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1">
						<thead>
							<tr>
								<th style=" background-color: #edf3f4;width:20%"> Parent Organization</th>
								<th><div id="parent_org" style="float:left;">
									<input type='hidden' name='hierarchy_id' id='hierarchy_id' value="<?php echo (isset($_REQUEST['hier_id']))?$_REQUEST['hier_id']:''?>">
									<select class="form-control m-b validate[required]" name="parent_org_name" id="parent_org_name" onclick="check_hierarchy()" disabled style="overflow: hidden; width: 260px;" >
										<?php $po_id='';$newtd='';
										if(count($last_details)>0){
											$newtd="<td><img id='select_parent' src='".BASE_URL."/public/images/down_arrow.png' onclick='getchildorgs()' style='margin-left:5px; margin-top:4px; cursor:pointer;' title='Move Down' /></td>";
											foreach($last_details as $po){
												$po_id=$po['parent_org_id'];
											}
											foreach($all_orgnz as $org_data){
												echo $po_sel=($po_id!='' &&  $po_id==$org_data->id)? "<option value=".$org_data->id.">".$org_data->name."</option>":''?>	
									<?php 	}
										}else{
											foreach($po_orgnz as $org_value){
												echo $po_sel=($po_id!='' &&  $po_id==$org_value->orgid)? "<option value=".$org_value->orgid.">".$org_value->orgname."</option>":''?>	
									<?php 	}
										}?>
									</select>
								</div>
								<div><?php echo $newtd;?></div></th>
							<tr>
						</thead>
					</table>
					<div class="page-header"><h5>Child Organizations<h5></div>
					<table class="table table-striped table-bordered table-hover" style="margin-bottom:0px;">
						<thead>
							<tr>
								<th style="width: 315px;">Organization Name</th>
								<th style="width: 208px;" class="hidden-480">Organization Type</th>
								<th style="width: 65px;"></th>
							</tr>
						</thead>
					</table>
					<div id="table_id" style="height:250px; overflow:auto;">
						<table id="org_data" class="table table-striped table-bordered table-hover">
							<tbody>
						<?php 	if(count($last_details)>0){
									$value=array();
									foreach($last_details as $key=>$details){
										$value[]=$key;?>
										<tr id='hier_row_<?php echo $key;?>'>
											<td style="width: 348px;">
												<input type='hidden' name='id[]' id='id[<?php echo $key?>]' value='<?php echo $details['id']?>'>
												<select class="form-control m-b" name="org_list[]" id="org_list[<?php echo $key?>]" style="width:215px;" onchange="getOrg_type(<?php echo $key?>)" disabled>
												<?php foreach($orgnz_data as $org_value){
												echo $org_sel=($org_value->orgid==$details['org_id'])? "<option value=".$org_value->orgid.">".$org_value->orgname."</option>":''?>				
												<?php }?>				
												</select>				
											</td>
											<td style="width: 230px;" class="hidden-480">
												<div id="input_type[<?php echo $key?>]"><?php echo $details['value_name']?></div>
											</td>
											<td style="width: 72px;">
												<p align='center'><img id="select_child" src="<?php echo BASE_URL;?>/public/images/up_arrow.png" onclick="Ajax_upgrade_child(<?php echo $key?>)" style='cursor:pointer;' /></p>
											</td>								
										</tr>
							<?php 	}	$hiddenval=@implode(',',$value);
								}?>
							<input type='hidden' id='inner_hidden_id' value='<?php echo $hiddenval;?>' name="inner_hidden_id" /></tbody>
						</table>
						<div id="error_div" style="float:right; margin-top:-80px; margin-right:40px;"></div>
					</div>
					<?php $hier_id=(isset($_REQUEST['hier_id']))?$_REQUEST['hier_id']:'';
						  $parentid=(isset($_REQUEST['parentid']))?$_REQUEST['parentid']:'';
					?>
					<div class="form-group">
						<div class="col-sm-offset-4">
							<input type="button" class="btn btn-sm btn-success" name="save" id="save" value="Update" onclick="create_link('org_hierarchy?hier_id=<?php echo $hier_id; ?>&parentid=<?php echo $parentid;?>')">&nbsp;
							<input type="button" class="btn btn-sm btn-info hidden-480" name="create" value="Create" onClick="create_link('org_hierarchy')"/>&nbsp;
							<input type="button" class="btn btn-sm btn-danger" name="clear" id="clear" value="Cancel" onclick="create_link('hierarchy_master')">		
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="msg_box33" class="lightbox pre_register" style="background:#FBFBFB;border-shadow:5px #333333;border-radius:5px solid #595959; position:fixed; width:35%;"></div>