<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-inverse card-view">
				<form class="form-horizontal">
                <div class="panel-body">
				<?php 
				foreach($reportdetails as $reportdetail){ 
					 $rname=$reportdetail['report_name'];
					 $rtype=$reportdetail['default_report_name'];
					 $coments=$reportdetail['comments'];
					 $query=$reportdetail['query_name'];
				}  ?>
					<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1">
						<thead>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Report Name</th>
								<th><?php echo $rname;  ?>&nbsp; </th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Report Type</th>
								<th><?php echo $rname;   ?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Comments</th>
								<th><?php $coments;   ?>&nbsp; </th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Query function Name</th>
								<th><?php echo $query;  ?>&nbsp; </th>
							</tr>
						</thead>
					</table>
					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-4">
							<button class="btn btn-primary" type="button" onClick="createreport_like('report_create?id=<?php echo $_REQUEST['id']."&hash=".md5(SECRET.$_REQUEST['id']);?>')">Update</button>
							<button class="btn btn-primary" type="button" onClick="createreport_like('report_create')">Create</button>
							<button class="btn btn-primary" type="button" onClick="createreport_like('reports')">Cancel</button>
						</div>
					</div>
					<div class="hr-line-dashed"></div>
					<div class="table-responsive">
						<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1">
							<thead>
							<tr>
								<th>Parameter Name</th>
								<th>System Code</th>
								<th>Visible Option</th>
							</tr>
							</thead>
							<tbody>
							<?php foreach($reportdetails as $reportdetail){  ?>
							<tr>
								<td><?php echo $reportdetail['parameter_name']; ?></td>
								<td><?php echo $reportdetail['pname']; ?></td>
								<td><?php echo $reportdetail['stat']; ?></td>
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
