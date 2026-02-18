<?php $orgid=$orgdetails['organization_id'];$hash=SECRET.$orgid;?>
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">
				
                <div class="panel-body">
					<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1">
						<thead>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Organization Name</th>
								<th><?php  echo $orgdetails['org_name'];?>&nbsp; </th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%"> Organization Type</th>
								<th><?php  echo $orgdetails['org_type_status'];?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%"> Business Unit Type</th>
								<th><?php  echo $orgdetails['butype'];?>&nbsp; </th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Organization Sub Type</th>
								<th><?php  echo $orgdetails['org_type1_status'];?>&nbsp; </th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Organization Manager</th>
								<th><?php  echo $orgdetails['full_name'];?>&nbsp; </th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Start Date</th>
								<th><?php echo ($orgdetails['start_date']!=NULL)?date('d-m-Y',strtotime($orgdetails['start_date'])):''?>&nbsp; </th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">End Date</th>
								<th><?php echo ($orgdetails['end_date']!=NULL)?date('d-m-Y',strtotime($orgdetails['end_date'])):''?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Location</th>
								<th><?php echo $orgdetails['location_name']?>&nbsp;</th>
							</tr>
						</thead>
					</table>
					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<div class="col-sm-offset-4">
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('org_master?orgid=<?php echo $orgid ?>&hash=<?php echo md5($hash) ?>')">Update</button>
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('org_master')">Create</button>
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('organization')">Cancel</button>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
