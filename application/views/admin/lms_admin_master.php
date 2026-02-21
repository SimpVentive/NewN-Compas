<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">
				<div class="panel-heading hbuilt">
					<font color="#FF0000">* Indicated are Mandatory <br></font>
				</div>
                <div class="panel-body">					
					<form name="lms_masters" id="lms_masters" action="<?php echo BASE_URL?>/admin/list_of_values" method="post" class="form-horizontal">
					<div id="error_div" class="message"><?php 
					$message=$this->session->flashdata('message');
					if(!empty($message)){ echo $this->session->flashdata('message'); $this->session->unset_userdata('message'); } ?></font></div>
					<?php 
					if(isset($viewmaster)){
						foreach($viewmaster as $viewmaster1){
							$mastrid=$viewmaster1['master_id'];
							$mastrcode=$viewmaster1['master_code'];
							$mastrtitle=$viewmaster1['master_title'];
							$mastrdesc=$viewmaster1['description'];
							$read="readonly='radonly'";
						}
					}
					else{
						$mastrid='';
						$mastrcode='';
						$mastrtitle='';
						$mastrdesc='';
						$read='';        
					}
					?>
						<div class="form-group"><label class="col-sm-3 control-label">Master Code<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
							<input type="hidden" id="master_id" name="master_id" value="<?php echo $mastrid;?>">
							<input type="text"  name="master_code" id="master_code" value="<?php echo $mastrcode;?>" <?php echo $read;?>  class="validate[required,minSize[2],maxSize[30],custom[alphanumericSp],ajax[ajaxMaterCode]] form-control"></div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Master Title<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5"><input type="text" name="master_title" id="master_title" value="<?php echo $mastrtitle;?>" class="validate[required,minSize[3],maxSize[80],custom[alphanumericSp],ajax[ajaxMaterTitle]] form-control"></div>
						</div>
						
						<div class="form-group"><label class="col-sm-3 control-label">Description:</label>
							<div class="col-sm-5">
								<textarea name="master_desc" id="master_desc" class="form-control" maxlength="2000" style="resize:none;"><?php echo $mastrdesc;?></textarea>
							</div>
						</div>
						
						
						<div class="hr-line-dashed"></div>
						<div class="page-header"><h5>Master Details</h5></div>
						<div>
							<a class="btn btn-primary btn-sm" name="addrow" id="addrow" onClick="AddMore()">Add Row</a>
							<a class="btn btn-primary btn-sm" name="delete" id="delete" value="Delete" onClick="Material_Delete()">Delete</a>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="table-responsive">
							<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1" id='top_material_upload' style="margin-bottom:0px; width:1000px;">
								<thead>
								<tr>
									<td style="width:66px;">Select</td>
									<td align='center' style="width:85px;">Code</td>
									<td align='center' style="width:254px;">Value</td>
									<td align="left" style="padding-left:15px; width:133px;">Start Date</td>
									<td align="left" style="padding-left:15px; width:133px;">End Date</td>
								</tr>
								</thead>
							</table>
							<div id="tablediv" style="height:250px; width:1020px; overflow:auto; overflow-x:hidden;">
								<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1" id='material_upload' style="width:1000px;">
								<tbody>
									<?php 
									if(isset($viewmaster1['UlsAdminValues'])){
										$hide_val=array();
										foreach($viewmaster1['UlsAdminValues'] as $key=>$viewmas){
											$hide_val[]=$key;
										?>
											<tr id="innertable<?php echo $key;?>">
												<td align='center' style="padding-left:12px; width:40px;">
													<input type="checkbox" name="select_chk" id="select_chk[<?php echo $key;?>]" value="<?php echo $key;?>"/>
												</td>
												<td style="width:52px;">
													<input type="hidden" name="value_id[]" id="value_id[<?php echo $key;?>]" value="<?php echo $viewmas['value_id'];?>">
													<input type="text" class="validate[required,minSize[1],maxSize[30],custom[alphanumericSp]] form-control" name="code[]" id="code[<?php echo $key;?>]" value="<?php echo $viewmas['value_code'];?>" maxlength='30' size="9px" readonly="" style="width:90%;"/>
												</td>
												<td style="width:155px;">
													<input type="text" class="validate[required,minSize[2],maxSize[80],custom[alphanumericSp]] form-control" name="value[]" id="value[<?php echo $key;?>]" value="<?php echo $viewmas['value_name'];?>" size="50px" style="width:95%;"/>
												</td>
												<td style="width:55px;">
													<div class="input-group date" id="datepicker_start">
														<input type="text" name="stdate[]" id="stdate<?php echo $key;?>" value="<?php echo ($viewmas['start_date']!=NULL)? date('d-m-Y',strtotime($viewmas['start_date'])):"";?>" class="validate[custom[date2]] form-control" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" style="width:100%;">
														<span class="input-group-addon">
															<span class="fa fa-calendar"></span>
														</span>	
													</div>
												</td>
												<td style="width:55px;">
													<div class="input-group date" id="datepicker_end">
														<input type="text" name="enddate[]" id="enddate<?php echo $key;?>" value="<?php echo ($viewmas['end_date']!=NULL)?date('d-m-Y',strtotime($viewmas['end_date'])):"";?>" class="validate[custom[date2],future[#stdate<?php echo $key;?>]] form-control" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" style="width:100%;">
														<span class="input-group-addon">
															<span class="fa fa-calendar"></span>
														</span>	
													</div>
													
												</td>
											</tr>
									<?php 	}$hidden=@implode(',',$hide_val);
										}
										else{$hidden=0;?>
											<tr id="innertable0">
												<td align='center' style="padding-left:12px; width:40px;">
													<input type="checkbox" name="select_chk" id="select_chk[0]" value="0"/>
												</td>
												<td style="width:52px;">
													<input type="hidden" name="value_id[]" id="value_id[0]" value="">
													<input type="text" class="validate[required,minSize[1],maxSize[30],custom[alphanumericSp]] form-control" name="code[]" id="code[0]" value="" maxlength='30' size="9px" style="width:90%;"/>
												</td>
												<td style="width:155px;">
													<input type="text" class="validate[required,minSize[2],maxSize[80],custom[alphanumericSp]] form-control" name="value[]" id="value[0]" value="" size="50px" style="width:95%;"/>
												</td>
												<td style="width:55px;">
													<div class="input-group date" id="datepicker_start">
														<input type="text" value="" name="stdate[]" id="stdate0" class="validate[custom[date2]] form-control" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" style="width:100%;">
														<span class="input-group-addon">
															<span class="fa fa-calendar"></span>
														</span>	
													</div>
												</td>
												<td style="width:55px;">
													<div class="input-group date" id="datepicker_end">
														<input type="text" value="" name="enddate[]" id="enddate0" class="validate[custom[date2],future[#stdate0]] form-control" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" onfocus="date_funct(this.id)" style="width:100%;">
														<span class="input-group-addon">
															<span class="fa fa-calendar"></span>
														</span>	
													</div>
												</td>
											</tr>
								<?php  }
								?>
								</tbody>
								<input type='hidden' id='inner_hidden_id' value='<?php echo $hidden;?>' name="inner_hidden_id" />
									
								</table>
							</div>
							
						</div>
						<div class="form-group">
							<div class="col-sm-offset-9">
								<button class="btn btn-primary btn-sm" type="button" onClick="Cancel_data()">Cancel</button>
								<button class="btn btn-primary btn-sm" type="submit" name="submit_user" id="submit_user" onclick="return validate_masters()">Save changes</button>
							</div>
						</div>
					</form>
				</div>
            </div>
        </div>
    </div>
</div>
<div id="msg_box" class="lightbox pre_register" style="background:#FBFBFB;border-shadow:5px;border-radius:5px; position:fixed;"></div>
<script>
    $(document).ready(function(){
        $("#usercreation").attr('autocomplete', 'off');
        //$(':input').live('focus',function(){
        //    $(this).attr('autocomplete', 'off');
       // });
    });
</script>