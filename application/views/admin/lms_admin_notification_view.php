<div class="content">
    <div class="row">
        <div class="col-lg-12">
			<form class="form-horizontal">
				<div class="panel panel-inverse card-view">
                <div class="panel-body">
					<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1">
						<thead>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Notification Name</th>
								<th><?php echo   $notification['notification_name']; ?>&nbsp; </th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Status</th>
								<th><?php echo   $notification['status']; ?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Parent Organization</th>
								<th><?php   echo $notification['org_name']; ?>&nbsp; </th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">History</th>
								<th><?php echo   $notification['history']; ?> Days&nbsp; </th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">System Notification Name</th>
								<th><?php echo   $notification['event_type']; ?>&nbsp; </th>
							</tr>
						</thead>
					</table>
					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<div class="col-sm-offset-4">
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('notification?id=<?php echo $_REQUEST['id']."&hash=".md5(SECRET.$_REQUEST['id']);?>')">Update</button>
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('notification')">Create</button>
							<button class="btn btn-primary btn-sm" type="button" onClick="window.history.back()">Cancel</button>
						</div>
					</div>
					<div class="hr-line-dashed"></div>
				</div>
			</div>
			<div class="panel panel-inverse card-view">
                <div class="panel-body">
					<ul class="nav nav-pills">
						<li class="active"><a data-toggle="tab" title="Recipients" href="#recipients">Recipients</a></li>
						<li class=""><a data-toggle="tab" title="Query Map" href="#querymap">History</a></li>
					</ul>
					<div class="tab-content">
						<div id="recipients" class="tab-pane active">
							<div class="panel-body">
								<strong>Recipients IDs</strong>
								<div class="form-group"><label class="col-sm-3 control-label">To:</label>
									<div class="col-sm-5"><input type="text" value="<?php echo isset($_REQUEST['id'])? $notification['mail_to'] :''; ?>" name="users" id="users"  class="form-control" readonly></div>
								</div>
								<div class="form-group"><label class="col-sm-3 control-label">Cc:</label>
									<div class="col-sm-5"><input type="text" name="manager"   value="<?php echo  isset($_REQUEST['id'])? $notification['mail_cc'] :'';  ?>" id="manager" readonly  class="form-control "></div>
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
				</div>				
				</form>
            </div>
        </div>
    </div>
</div>
