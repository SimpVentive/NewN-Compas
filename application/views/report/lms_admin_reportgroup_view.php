<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-inverse card-view">
				<form class="form-horizontal">
                <div class="panel-body">
					<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1">
						<thead>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Report Group Name</th>
								<th><?php echo $groupdetails['report_group_name'];  ?>&nbsp; </th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Parent Organization Name</th>
								<th><?php echo $groupdetails['org_name'];  ?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Comments</th>
								<th><?php echo $groupdetails['comments'];   ?>&nbsp; </th>
							</tr>
						</thead>
					</table>
					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-4">
							<button class="btn btn-primary" type="button" onClick="createreport_like('reportgroup_create?id=<?php echo $_REQUEST['id']."&hash=".md5(SECRET.$_REQUEST['id']);?>')">Update</button>
							<button class="btn btn-primary" type="button" onClick="createreport_like('reportgroup_create')">Create</button>
							<button class="btn btn-primary" type="button" onClick="createreport_like('reportgroups')">Cancel</button>
						</div>
					</div>
					<div class="hr-line-dashed"></div>
						<div class="page-header"><h5>Reports Details</h5></div>
					<div class="table-responsive">
						<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1">
							<thead>
							<tr>
								<th>Report Name</th>
								<th>Visible Option</th>
							</tr>
							</thead>
							<tbody>
							<?php foreach($reportdetails as $reportdetails1){  ?>
							<tr>
								<td><?php echo $reportdetails1['report_name']; ?></td>
								<td><?php echo $reportdetails1['value_name']; ?></td>
							</tr>
							<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				
				</form>
            </div>
        </div>
    </div>
</div>
