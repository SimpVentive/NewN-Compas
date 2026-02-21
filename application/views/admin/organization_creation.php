<script>
<?php 
if(!empty($orglast->org_type) && $orglast->org_type=='PO'){
echo "var orgtype='".$orglast->org_type."';";
}
else{
echo "var orgtype='';";
}
?>
</script>
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">
                <div class="panel-body">
					<form id="org_master" action="<?php echo BASE_URL;?>/admin/Org_details" method="post" class="form-horizontal">
						<input type="hidden" name="org_id" id="org_id" value="<?php echo (isset($orglast->organization_id))?$orglast->organization_id:''?>">
						<input type="hidden" name="parent_org_id" id="parent_org_id" value="<?php echo (isset($orglast->parent_org_id))?$orglast->parent_org_id:$this->session->flashdata('parent_org_id');?>">
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Organization Name<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5"><input type="text" class="validate[required,minSize[2],maxSize[80], funcCall[checknotinteger] ] form-control" name="org_name" id="org_name" value="<?php echo (isset($orglast->org_name))?$orglast->org_name:''?>"></div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Organization Type<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<select name="org_type" class="validate[required, ajax[ajaxOrgNameType] ] form-control m-b" id="org_type"  onchange='show_fields()'>
									<option value="">Select</option>
									<?php 
									foreach($orgtyp as $org_value){
										$typ_sel=(isset($orglast->org_type))?($orglast->org_type==$org_value['code'])?"selected='selected'":'':'';?>
										<option value="<?php echo $org_value['code'];?>" <?php echo $typ_sel;?>><?php echo $org_value['name'];?></option>
									<?php 
									}?>
								</select>
							</div>
						</div>
						<?php $dis=(isset($orglast->org_type))? ($orglast->org_type=='PO')?"style='display:block;'" : "style='display:none;'":''; ?>
						<div id="urldiv" <?php echo $dis; ?> >
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Organization URL<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5"><input type="text" class="validate[required,funcCall[checknotinteger]] form-control" name="url" id="url" value="<?php echo !empty($orglast->org_url)? $orglast->org_url : "";  ?>" ></div>
						</div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Organization Sub Type:</label>
							<div class="col-sm-5">
								<select class="form-control m-b" name="org_type1" id="org_type1">
									<option value="">Select</option>
									<?php 
									foreach($orgsbtyp as $org_value){
										$typ_sel=(isset($orglast->org_type1))?($orglast->org_type1==$org_value['code'])?"selected='selected'":'':'';?>
										<option value="<?php echo $org_value['code'];?>" <?php echo $typ_sel;?>><?php echo $org_value['name'];?></option>                           
									<?php 
									}?>
								</select>
							</div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Organization Manager:</label>
							<div class="col-sm-5">
								<select class="chosen-select form-control m-b" name="org_manager" id="org_manager">
									<option value="">Select</option>
									<?php 
									foreach($emplist as $emplists){
										$mngr_sel=(isset($orglast->org_manager))?($orglast->org_manager==$emplists['employee_id'])?"selected='selected'":'':'';?>
										<option value="<?php echo $emplists['employee_id'];?>" <?php echo $mngr_sel?>><?php echo $emplists['employee_number']." - ".$emplists['full_name'];?></option>
									<?php 
									}?>
								</select>
							</div>
						</div>
						<?php $dis_divi=(isset($orglast->org_type))? ($orglast->org_type=='BU')?"style='display:block;'" : "style='display:none;'":''; ?>
						<div id="dividiv" <?php echo $dis_divi; ?> >
							<div class="form-group"><label class="control-label mb-10 col-sm-2">Division Name<sup><font color="#FF0000">*</font></sup>:</label>
								<div class="col-sm-5">
									<select class="validate[required] form-control m-b" name="division_id" id="division_id">
										<option value="">Select</option>
										<?php 
										foreach($orgdivi as $orgdivis){
											$loc_sel=(isset($orglast->division_id))?($orglast->division_id==$orgdivis['id'])?"selected='selected'":'':'';?>
											<option value="<?php echo $orgdivis['id'];?>" <?php echo $loc_sel;?>><?php echo $orgdivis['name'];?></option>
										<?php 
										}?>
									</select>
								</div>
							</div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Location:</label>
							<div class="col-sm-5">
								<select class="form-control m-b" name="location" id="location">
									<option value="">Select</option>
									<?php 
									foreach($orgloc as $orglocs){
										$loc_sel=(isset($orglast->location))?($orglast->location==$orglocs->location_id)?"selected='selected'":'':'';?>
										<option value="<?php echo $orglocs->location_id;?>" <?php echo $loc_sel;?>><?php echo $orglocs->location_name;?></option>
									<?php 
									}?>
								</select>
							</div>
						</div>
						<?php 	
						if(isset($_SESSION['parent_org_id'])){
							$orgdate="select start_date from uls_organization_master where parent_org_id=".$_SESSION['parent_org_id']." and org_type='PO'";
							$stdate=UlsMenu::callpdorow($orgdate);
						}else{$stdate='';}?>		
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Start Date<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<div class="input-group date datepicker">
									<input type='hidden' name='po_st_date' id='po_st_date' value='<?php echo (!empty($stdate))?date('Y-m-d', strtotime($stdate['start_date'])):'';?>'>
									<input type="text" class="validate[required,future[#po_st_date]]  form-control" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" name="stdate" id="stdate" value="<?php echo (isset($orglast->start_date))?($orglast->start_date!=NULL)?date('d-m-Y',strtotime($orglast->start_date)):'':''?>">
									<span class="input-group-addon">
										<span class="fa fa-calendar"></span>
									</span>
								</div>
							</div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">End Date:</label>
							<div class="col-sm-5">
								<div class="input-group date datepicker">
									<input type="text" class="validate[future[#stdate]] form-control" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" name="enddate" id="enddate" value="<?php echo (isset($orglast->end_date))?($orglast->end_date!=NULL)?date('d-m-Y',strtotime($orglast->end_date)):'':''?>">
									<span class="input-group-addon">
										<span class="fa fa-calendar"></span>
									</span>
								</div>
							</div>
						</div>
						<hr class="light-grey-hr">
						<div class="form-group">
							<div class="col-sm-offset-0">
								<button class="btn btn-primary btn-sm" type="submit" name="save" id="save">Save changes</button>
								<a href="#" class="btn btn-danger btn-sm" onclick="move_back('organization')">Cancel</a>
								
							</div>
						</div>
					</form>
				</div>
            </div>
        </div>
    </div>
</div>
