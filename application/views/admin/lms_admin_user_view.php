<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-inverse card-view">				
                <div class="panel-body">
					<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1">
						<thead>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">User Name</th>
								<th><?php echo isset($userdetails['user_name'])?$userdetails['user_name']:"";?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Employee Name</th>
								<th><?php echo isset($roledetails['role_code'])?$roledetails['role_code']:"";?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Menu Name</th>
								<th><?php echo isset($userdetails['full_name'])?$userdetails['full_name']:"";?>&nbsp;  </th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Email Address</th>
								<th><?php echo isset($userdetails['email'])?$userdetails['email']:"";?>&nbsp; </th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">User Type</th>
								<th><?php echo isset($userdetails['actor'])?$userdetails['actor']:"";?>&nbsp; </th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Start Date</th>
								<th><?php echo isset($userdetails['start_date'])? (($userdetails['start_date']!=NULL)? date("d-m-Y",strtotime($userdetails['start_date'])):""):""; ?>&nbsp; </th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">End Date</th>
								<th><?php echo isset($userdetails['end_date'])? (($userdetails['end_date']!=NULL)? date("d-m-Y",strtotime($userdetails['end_date'])):""):""; ?>&nbsp; </th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Validate Days</th>
								<th><?php echo isset($userdetails['password_validity_days'])? ($userdetails['password_validity_days']!=0?$userdetails['password_validity_days']:"&nbsp;"):"&nbsp;"; ?>&nbsp; </th>
							</tr>
						</thead>
					</table>
					<div class="hr-line-dashed"></div>
					<div class="table-responsive">
						<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1" id="thetable">
							<thead>
							<tr>
								<th>Role Name</th>
								<th>Comments</th>
								<th>Start Date</th>
								<th>End Date</th>
							</tr>
							</thead>
							<tbody>
								<?php				
								$f=0;
								foreach($userdetails['userrole'] as $key=>$roles){ $f++;  ?>
									<tr <?php if($f==1){ ?> class="first" <?php } ?>>
										<td><?php echo isset($roles['role_name'])?$roles['role_name']:""; ?></td>
										<td><?php echo isset($roles['description'])?$roles['description']:""; ?></td>
										<td><?php echo isset($roles['start_date'])? (($roles['start_date']!=NULL && !empty($roles['start_date']))? date("d-m-Y",strtotime($roles['start_date'])):""):""; ?></td>
										<td><?php echo isset($roles['end_date'])? (($roles['end_date']!=NULL && !empty($roles['end_date']))? date("d-m-Y",strtotime($roles['end_date'])):""):""; ?></td>
									</tr>
								<?php } ?>	
							</tbody>
						</table>
					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<div class="col-sm-offset-4">
							<?php if(isset($userdetails['user_id'])){ ?><button class="btn btn-primary btn-sm" type="button" onClick="create_link('create_user?id=<?php echo $userdetails['user_id']."&hash=".md5(SECRET.$userdetails['user_id']);?>')">Update</button><?php } ?>
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('create_user')">Create</button>
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('user_creation')">Cancel</button>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
