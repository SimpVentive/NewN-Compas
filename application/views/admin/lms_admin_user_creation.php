
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">
				<div class="panel-heading hbuilt">
					<font color="#FF0000">* Indicated are Mandatory <br></font>
				</div>
                <div class="panel-body">
					
					<form name="usercreationform" id="usercreationform" action="<?php echo BASE_URL;?>/admin/lms_usercreation" method="post" class="form-horizontal">
					
					<div id="error_div" class="message">
					<?php 
					$message=$this->session->flashdata('message');
					if(!empty($message)){ echo $this->session->flashdata('message'); $this->session->unset_userdata('message'); } ?></div>
					
						<div class="form-group"><label class="col-sm-3 control-label">Username<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
							<input type="hidden" id="user_id" name="user_id" value="<?php echo isset($usercreate->user_id)? $usercreate->user_id:""; ?>" />
						<input type="hidden" id="org_id" name="org_id" value="<?php echo isset($usercreate->parent_org_id)? $usercreate->parent_org_id:$_SESSION['parent_org_id'];?>"/>
							<input type="text" name="user_name" id="user_name" value="<?php echo isset($usercreate->user_name)? $usercreate->user_name:""; ?>"  class="validate[required,minSize[4],maxSize[80],ajax[ajaxUsername]] form-control"></div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Password<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5"><input type="password" name="password" id="password" value="<?php echo isset($usercreate->password)? $usercreate->password:""; ?>" class="validate[required,minSize[4],maxSize[16],custom[alphanumericSp]] form-control"></div>
						</div>
						
						<div class="form-group"><label class="col-sm-3 control-label">Confirm Password<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<input type="password" name="con_password" id="con_password" value="<?php echo isset($usercreate->password)? $usercreate->password:""; ?>" class="validate[required,minSize[4],maxSize[16],equals[password]] form-control">
							</div>
						</div>
						
						<div class="form-group"><label class="col-sm-3 control-label">Employee Name<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<select name="employee_id" id="employee_id"  class="validate[required] form-control m-b" onChange="empid()">
									<option value="">Select</option>
									<?php foreach($employees as $employee){ 
									$sel=isset($usercreate->employee_id)? (($usercreate->employee_id==$employee['employee_id'])?"selected='selected'":""):""; ?>
									<option <?php echo $sel; ?> value="<?php echo $employee['employee_id']; ?>"><?php echo $employee['employee_number'];?> - <?php echo $employee['full_name'];?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						
						<div class="form-group"><label class="col-sm-3 control-label">Email Address:</label>
							<div class="col-sm-5">
								<input type="text" name="email_address" class="validate[custom[email]] form-control" value="<?php echo isset($usercreate->email_address)? trim($usercreate->email_address):""; ?>" id="email_address">
								<input type="hidden" name="doj" id="doj">
							</div>
						</div>
						
						<div class="form-group"><label class="col-sm-3 control-label">User Type<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<select name="user_type" id="user_type" class="validate[required] form-control m-b" >
									<option value="">Select</option>
									<?php $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
									$query = "select mc.master_code, mv.* from uls_admin_master mc, uls_admin_values mv where mc.master_code='EMP_TYPE' and mc.master_code=mv.master_code";
									$user_type = $pdo->prepare($query);
									$user_type->execute(); 
									$user_types=$user_type->fetchAll();
									foreach($user_types as $user_types1){ $sel=isset($usercreate->user_type)? (($usercreate->user_type==$user_types1['value_code'])?"selected='selected'":""):""; ?>
									<option <?php echo $sel; ?> value="<?php echo $user_types1['value_code'];?>"><?php echo $user_types1['value_name'];?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						
						<div class="form-group"><label class="col-sm-3 control-label">Start Date<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<div class="input-group date" id="datepicker">
									<input type="text" class="validate[required,custom[date2]]  form-control" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="start_date" id="start_date" value="<?php echo isset($usercreate->start_date)? (($usercreate->start_date!=NULL)? date("d-m-Y",strtotime($usercreate->start_date)):""):""; ?>">
									<span class="input-group-addon">
										<span class="fa fa-calendar"></span>
									</span>
								</div>
							</div>
						</div>
						
						<div class="form-group"><label class="col-sm-3 control-label">End Date:</label>
							<div class="col-sm-5">
								<div class="input-group date" id="datepicker">
									<input type="text" class="validate[custom[date2],future[#start_date]]  form-control" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy"  name="end_date" id="end_date" value="<?php echo isset($usercreate->end_date)? (($usercreate->end_date!=NULL)? date("d-m-Y",strtotime($usercreate->end_date)):""):""; ?>" >
									<span class="input-group-addon">
										<span class="fa fa-calendar"></span>
									</span>
								</div>
							</div>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="table-responsive">
							<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1" id="thetable">
								<thead>
								<tr>
									<th><b>&emsp;&emsp;&emsp;</b></th>
									<th><b>&emsp;Role Name</b></th>
									<th><b>&emsp;Comments</b></th>
									<th><b>&emsp;Start Date</b></th>
									<th><b>&emsp;End Date</b></th>
									<th><b>&emsp;Menu</b></th>
								</tr>
								</thead>
								<tbody>
								<?php
								if(isset($rolecreate)){
									$rc=array();
								foreach($rolecreate as $roles){
									$key=$roles['role_id'];
									$rc[$key]['user_role_id']=$roles['user_role_id'];
									$rc[$key]['user_id']=$roles['user_id'];
									$rc[$key]['role_id']=$roles['role_id'];
									$rc[$key]['menu_id']=$roles['menu_id'];
									$rc[$key]['description']=$roles['description'];						
									$rc[$key]['start_date']=$roles['start_date'];
									$rc[$key]['end_date']=$roles['end_date'];						
								}
								unset($rolecreate);
								$rolecreate=$rc;
								}
								$f=0;
								foreach($roless as $key=>$roles){ $key=$roles['role_id']; $f++;  ?>
									<tr <?php if($f==1){ ?> class="first" <?php } ?>>
										<td> <input type="checkbox"  id="rollid_<?php echo $key; ?>" name="rolename[]" <?php echo isset($rolecreate[$key]['role_id'])? (($rolecreate[$key]['role_id']==$roles['role_id'])?"checked='checked' disabled='disabled'":""):""; ?> class="validate[minCheckbox[1]] checkbox form-control"  onChange="role_creationid(<?php echo $key; ?>)" /></td>
										<td><input id="user_role_id<?php echo $key; ?>" type="hidden" <?php echo isset($rolecreate[$key]['user_role_id'])? (!empty($rolecreate[$key]['user_role_id'])?"":"disabled='disabled'"):"disabled='disabled'"; ?> name="user_role_id[<?php echo $key; ?>]" value="<?php echo isset($rolecreate[$key]['user_role_id'])? $rolecreate[$key]['user_role_id']:""; ?>" class="form-control">
										<select name="role_id[<?php echo $key; ?>]" <?php echo isset($rolecreate[$key]['user_role_id'])? (!empty($rolecreate[$key]['user_role_id'])?"":"disabled='disabled'"):"disabled='disabled'"; ?> id="role_id<?php echo $key; ?>" style="width:150px;" onChange="role_creationid(<?php echo $key; ?>)"  class="form-control m-b" >
											<!--<option value="">Select</option>-->
											<option selected='selected' value="<?php echo $roles['role_id']; ?>"><?php echo $roles['role_name']; ?></option>
										</select></td>
										<td><input type="text" <?php echo isset($rolecreate[$key]['user_role_id'])? (!empty($rolecreate[$key]['user_role_id'])?"":"disabled='disabled'"):"disabled='disabled'"; ?> name="description[<?php echo $key; ?>]"  value="<?php echo isset($rolecreate[$key]['description'])? $rolecreate[$key]['description']:""; ?>" id="description<?php echo $key; ?>" class="form-control"></td>
										<td><div class="input-group date" id="datepicker_start<?php echo $key; ?>"><input type="text" <?php echo isset($rolecreate[$key]['user_role_id'])? (!empty($rolecreate[$key]['user_role_id'])?"":"disabled='disabled'"):"disabled='disabled'"; ?> name="startdate[<?php echo $key; ?>]" value="<?php echo isset($rolecreate[$key]['start_date'])? (($rolecreate[$key]['start_date']!=NULL && !empty($rolecreate[$key]['start_date']))? date("d-m-Y",strtotime($rolecreate[$key]['start_date'])):""):""; ?>" id="startdate_<?php echo $key; ?>" class="validate[required,custom[date2],future[#start_date]] form-control" data-prompt-position="inline"><span class="input-group-addon"><span class="fa fa-calendar"></span></span></div></td>
										<td><div class="input-group date" id="datepicker_end<?php echo $key; ?>"><input type="text" <?php echo isset($rolecreate[$key]['user_role_id'])? (!empty($rolecreate[$key]['user_role_id'])?"":"disabled='disabled'"):"disabled='disabled'"; ?> name="enddate[<?php echo $key; ?>]"  value="<?php echo isset($rolecreate[$key]['end_date'])? (($rolecreate[$key]['end_date']!=NULL && !empty($rolecreate[$key]['end_date']))? date("d-m-Y",strtotime($rolecreate[$key]['end_date'])):""):""; ?>" id="enddate_<?php echo $key; ?>" class="validate[custom[date2],future[#startdate_<?php echo $key; ?>]] form-control" data-prompt-position="inline" ><span class="input-group-addon"><span class="fa fa-calendar"></span></span></div></td>
										<td><div id="menu_execlusions<?php echo $key; ?>"><a onClick='exclusion(<?php echo $roles['role_id']; ?>,<?php echo $key; ?>)'><input type='hidden' <?php echo isset($rolecreate[$key]['user_role_id'])? (!empty($rolecreate[$key]['user_role_id'])?"":"disabled='disabled'"):"disabled='disabled'"; ?> value='<?php echo isset($rolecreate[$key]['menu_id'])?$rolecreate[$key]['menu_id']:""; ?>' name='menuid[<?php echo $key; ?>]' id='menuids_<?php echo $key; ?>' ><input type='button' name='exclusion' id='exclusion<?php echo $key; ?>' value='Menu'  <?php echo isset($rolecreate[$key]['user_role_id'])? (!empty($rolecreate[$key]['user_role_id'])?" class='bigbutton'":"disabled='disabled'"):"disabled='disabled'"; ?>></a><?php /*}}*/ ?></div></td>
										<script>
										$(document).ready(function(){
											var date1 = new Date();
											var date2 = new Date(2039,0,19);
											var timeDiff = Math.abs(date2.getTime() - date1.getTime());
											var difDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
											var dates = $( "#startdate_<?php echo $key; ?>, #enddate_<?php echo $key; ?>" ).datepicker({
												dateFormat:"dd-mm-yy",
												defaultDate: "+1w",
												changeMonth: true,
												changeYear: true,
												numberOfMonths: 1,
												/*minDate:0,
												maxDate:difDays,*/
												onSelect: function( selectedDate ) {
													var option = this.id === "startdate_<?php echo $key; ?>" ? "minDate" : "maxDate", instance = $( this ).data( "datepicker" ),date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat,selectedDate, instance.settings );
													dates.not( this ).datepicker( "option", option, date );
												}
											});
											if($("#enddate_<?php echo $key; ?>").val()!=""){
												$( "#startdate_<?php echo $key; ?>" ).datepicker("option", "maxDate", $("#enddate_<?php echo $key; ?>").val());
											}
											if($("#startdate_<?php echo $key; ?>").val()!=""){
												$( "#enddate_<?php echo $key; ?>" ).datepicker("option", "minDate", $("#startdate_<?php echo $key; ?>").val());
											}
										});
									</script>
									</tr>
									<?php } ?>
								</tbody>
							</table>
							<?php foreach($roless as $key=>$roles){ ?>
								<div id="msg<?php echo $roles['role_id']; ?>"></div>
							<?php } ?>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-9">
								<button class="btn btn-danger" type="button" onclick='canceluser()'>Cancel</button>
								<button class="btn btn-success" type="submit" name="submit_user" id="submit_user">Save changes</button>
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