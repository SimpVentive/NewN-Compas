
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">
				
                <div class="panel-body">
					<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1">
						<thead>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Role Name</th>
								<th><?php echo isset($roledetails['role_name'])?$roledetails['role_name']:"";?>&nbsp; </th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Role Code</th>
								<th><?php echo isset($roledetails['role_code'])?$roledetails['role_code']:"";?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Menu Name</th>
								<th><?php echo isset($roledetails['menu_name'])?$roledetails['menu_name']:"";?>&nbsp; </th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Organization</th>
								<th><?php echo isset($roledetails['org_name'])?$roledetails['org_name']:"";?>&nbsp; </th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Security Profile</th>
								<th><?php echo isset($roledetails['profile_name'])?$roledetails['profile_name']:"";?>&nbsp; </th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Start Date</th>
								<th><?php echo ($roledetails['start_date']!=NULL)?date("d-m-Y",strtotime($roledetails['start_date'])):"";?>&nbsp; </th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">End Date</th>
								<th><?php echo ($roledetails['end_date']!=NULL)? date("d-m-Y",strtotime($roledetails['end_date'])):"";?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Comment</th>
								<th><?php echo isset($roledetails['comment'])?$roledetails['comment']:"";?>&nbsp;</th>
							</tr>
						</thead>
					</table>
					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<div class=" col-sm-offset-4">
							<button class="btn btn-success" type="button" onClick="create_link('create_role?id=<?php echo $roledetails['role_id']."&hash=".md5(SECRET.$roledetails['role_id']);?>')">Update</button>
							<button class="btn btn-info" type="button" onClick="create_link('create_role')">Create</button>
							<button class="btn btn-danger" type="button" onClick="create_link('role')">Cancel</button>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
