<script src=" <?php echo BASE_URL; ?>/public/js/ckeditor/ckeditor.js"></script> 
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">
				<div class="panel-heading hbuilt">
					<font color="#FF0000">* Indicated are Mandatory <br></font>
				</div>
                <div class="panel-body">					
					<form id="notificationForm" name="notificationForm" action="<?php echo BASE_URL; ?>/admin/notification_insert" method="post" class="form-horizontal">					
						<div class="form-group"><label class="col-sm-3 control-label">Notification Name<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5"><input type="text" name="notification_name"  id="notification_name" maxlength="50" value="<?php echo isset($_REQUEST['id'])? $notification['notification_name'] : ""; ;?>"   class="validate[required,minSize[3],maxSize[80],ajax[ajaxNotificationName]]  form-control">
							<input type='hidden' name='notification_id' id='notification_id' value='<?php echo isset($_REQUEST['id'])? $_REQUEST['id'] : '';  ?>' /></div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Status<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<select name="status"  id="status" class="validate[required] form-control m-b" >
									<option value=''>Select</option>
									<?php foreach($status as $statuss ){ 
									$sel=(isset($notification['status']))? $notification['status']==$statuss['code'] ? "selected='selected'" : '' :'';   ?>
									<option  <?php echo $sel; ?> value="<?php echo $statuss['code']; ?>"><?php echo $statuss['name'] ; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>						
						<div class="form-group"><label class="col-sm-3 control-label"> Parent Organizations<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<select name="porg"  id="porg" class="validate[required]  form-control m-b" >
									<option value=''>Select</option>
									<?php foreach($parentorgs as $parentorg){
									$sel12=($notification['parent_org_id']==$parentorg->orgid)? "selected='selected'":"";
									?>
									<option <?php echo $sel12; ?> value="<?php echo $parentorg->orgid; ?>"><?php echo $parentorg->orgname; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>						
						<div class="form-group"><label class="col-sm-3 control-label">System Notification Name<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<select name="notification_type" id="notification_type" class="col-xs-12 col-sm-6 validate[required,ajax[ajaxNotificationType]]  form-control m-b" onchange="getparameters()" >
									<option value=''>Select</option>
									<?php 
									$doct=Doctrine_Query::Create()->from("UlsNotificationTypes")->where("notification_typeid")->execute();
									foreach($doct as $docts){
										if(isset($_REQUEST['id'])){
											if($notification['event_type']==$docts->notification_code){ 
												$sel='selected="selected"';
											} 
											else { $sel=" ";} 
										}
										echo "<option $sel value='".$docts->notification_typeid."-".$docts->notification_code."'>".$docts->notification_name."</option>";	
									}
									?>
								</select>
								<input type="hidden" name="system_notification" id="system_notification" value="" />	  
							</div>
						</div>						
						<div class="form-group"><label class="col-sm-3 control-label">Parameters:</label>
							<div class="col-sm-5">
								<select  name="parameters" id="parameters" class="form-control m-b" onchange="doGetCaretPosition(document.getElementById('mailcontent'));">
									<option value=''>Select</option>									
								</select>								
							</div>
							<div class="col-sm-3">
								<input type="button" value="Get Position" onclick="insertIntoCkeditor();"  class="btn btn-primary btn-sm">
							</div>
						</div>
						
						<div class="form-group"><label class="col-sm-3 control-label">History:</label>
							<div class="col-sm-5">
								<select  name="history" id="history"  class="form-control m-b" >
									<option value="">Select</option>
                                    <?php 
									for($i=1;$i<7;$i++){
										$sel2=($notification['history']==$i)? "selected='selected'":"";
									?>
									<option <?php echo $sel2; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
								</select>
							</div>
							<div class="col-sm-3">
								<button class="btn btn-primary btn-sm">  Days</button>
							</div>
						</div>
						
						<?php $maicontent=(isset($_REQUEST['id'])) ? $notification['comments'] : ''; ?>
						<div id="maildiv" style="display:block;">
						
							<div class="form-group"><label class="col-sm-3 control-label">Mail Content:</label>
								<div class="col-sm-9">
									<script type="text/javascript">
										var editor;
										CKEDITOR.on( 'instanceReady', function( ev ) {
											editor = ev.editor;
											// Event fired when the readOnly property changes.
											
											editor.on( 'readOnly', function() {});
										});
									
									
										function insertIntoCkeditor(){
											var str = document.getElementById('parameters').value;
											//$("#editor1").val('');
											//$('iframe').contents().find('body').empty();
											//CKEDITOR.instances['editor1'].setData(" ");
											//CKEDITOR.remove(CKEDITOR.instances['editor1']);
											//delete CKEDITOR.instances['editor1'];
											// CKEDITOR.replace('editor1');
											/* var o=CKEDITOR.instances['editarea'];
											if (o) o.destroy(); */

											//CKEDITOR.remove(CKEDITOR.instances.editor1);
											CKEDITOR.instances['editor1'].insertText(str);
										}
									</script>
									<textarea class="ckeditor" id="editor1" name="mailcontent" cols="90" rows="10"><?php echo $maicontent; ?> </textarea>
								</div>
							</div>
						</div>
						
						<div class="hr-line-dashed"></div>
						<div class="form-group">
							<div class="col-sm-offset-5">
								<button class="btn btn-primary btn-sm" type="button" onclick="create_link('notificationsearch')">Cancel</button>
								<button class="btn btn-primary btn-sm" type="submit" name="formsubmit" id="formsubmit" >Save changes</button>
							</div>
						</div>
						
						<ul class="nav nav-pills">
							<li class="active"><a data-toggle="tab" title="Recipients" href="#recipients">Recipients</a></li>
							<li class=""><a data-toggle="tab" title="Query Map" href="#querymap">History</a></li>
						</ul>
						<div class="tab-content">
							<div id="recipients" class="tab-pane active">
								<div class="panel-body">
									<strong>Recipients IDs</strong>
									<div class="form-group"><label class="col-sm-3 control-label">To:</label>
										<div class="col-sm-5"><input type="text" value="<?php echo isset($_REQUEST['id'])? $notification['mail_to'] :''; ?>" name="users" id="users"  class="form-control"></div>
									</div>
									<div class="form-group"><label class="col-sm-3 control-label">Cc:</label>
										<div class="col-sm-5"><input type="text" name="manager"   value="<?php echo  isset($_REQUEST['id'])? $notification['mail_cc'] :'';  ?>" id="manager"  class="form-control"></div>
									</div>
								</div>
							</div>
							<div id="querymap" class="tab-pane">
								<div class="panel-body">
									<strong>History Details</strong>
									<div style="width:960px; float: left; margin-top:20px;">
										<div style="width:300px;height:200px; overflow: auto; border:2px solid #99BEDD; margin-left:5px; float:left; ">
											<b>&emsp;<u>Mail Delivery Time</u></b>
												<table id="" class="table table-striped table-bordered table-hover">
												<?php  
												if(isset($notificationhistory)){
													if(count($notificationhistory)>0){ 
														foreach($notificationhistory as $history){ 
															if($history['employee_id']!=''){
																$empname="External Employee"; 
																$mail=$history['mail_content'];
															}
															else{ 
																$sd=Doctrine_Core::getTable('UlsEmployeeMaster')->findOneByEmployee_id($history['employee_id']);
																$empname=$sd->full_name;
															}
															echo "<tr><td><label style='cursor:pointer;'  onclick=\"getmailsdata('".$history['mail_delivey_time']."',".$_REQUEST['id'].")\"><font size='3' color='blue'>".date('d-m-Y H:i:s',  strtotime($history['mail_delivey_time'])). "</font></label></td></tr>"; 
														}
													}
													else{ $mail=""; ?><tr><td colspan="2">No data found.</td></tr> 
													<?php 
													} 
												} ?>
											</table>
										</div>
										<div id="mailcontent" class="" style="float:left; height:200px; width:612px; margin-left:5px; border:2px solid #99BEDD;" >
											<b>&emsp;<u>Mail Content</u></b> 
											<div id="mailscontent" style="overflow: auto; height: 200px;"></div>
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
