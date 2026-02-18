
<div class="small-header">
    <div class="panel panel-inverse card-view">
        <div class="panel-body">
            <div id="hbreadcrumb" class="pull-right">
                <ol class="hbreadcrumb breadcrumb">
                    <li><a href="index.html">Dashboard</a></li>
                     <li>
                        <span>Assessment Manage</span>
                    </li>
                    <li class="active">
                        <span>Assessment Manage Creation</span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs">
                Assessment Manage Creation
            </h2>
            <small>Enter all the details related to Assessment Manage.</small>
        </div>
    </div>
</div>

<div class="content">
    <div class="row">
		<div class="col-lg-4">
			<div class="panel panel-inverse card-view">
				<div class="panel-body">
					<div class="dd" id="nestable">
						<ol class="dd-list">
							
							<li class="dd-item" data-id="1">
								<div class="dd-handle">Assessment Definition</div>
								<ol class="dd-list">
									<li class="dd-item" data-id="2">
										<div class="dd-handle"><a href="competency_master.html"> Definition</a></div>
										<ol class="dd-list">
											<li class="dd-item" data-id="2">
												<div class="h-bg-green dd-handle"><a href="assessment_position_creation.html"> Position</a></div>
											</li>
										</ol>
									</li>
									
								</ol>
							</li>
							
						</ol>
					</div>
					
				</div>
			</div>
		</div>
		<div class="col-lg-8">
			<div class="panel panel-inverse card-view">
				
				<div class="panel-body">
					<h5 class="m-t-none m-b-sm">Assessment Definition</h5>
					<div class="hr-line-dashed"></div>
					<form method="get" class="form-horizontal">
						<div class="panel-heading hbuilt">
							Add Positions
							<div class="pull-right">
								<a class="btn btn-xs btn-primary">&nbsp <i class="fa fa-plus-circle"></i> Add &nbsp</a>
								<a class="btn btn-primary btn-xs">&nbsp <i class="fa fa-trash-o"></i>  Delete &nbsp</a>
							</div>
						</div>
						<div class="table-responsive">
							<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
								<thead>
								<tr>
									<th>Select</th>
									<th>Position</th>
									<th>status</th>
								</tr>
								</thead>
								<tbody>
								<tr>
									<td><label><input type="checkbox" value=""></label></td>
									<td>
										<select class="form-control m-b" name="account">
											<option>Select</option>
										</select>
									</td>
									<td>
										<select class="form-control m-b" name="account">
											<option>Select</option>
										</select>
									</td>
								</tr>
								</tbody>
							</table>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="form-group">
							<div class=" col-sm-offset-8">
								<button class="btn btn-primary btn-sm" type="submit">Cancel</button>
								<a href="assessment_positions.html" class="btn btn-primary btn-sm" type="submit">Save changes</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

</div>
