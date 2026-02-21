<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">
                <div class="panel-body">
					<?php
					foreach($locdetail as $key=>$locdetails){
						if($key==0){
					?>
					<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1">
						<thead>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Location Name</th>
								<th><?php  echo $locdetails['location_name'];?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Location Zones</th>
								<th><?php  echo $locdetails['loc_zones'];?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Address 1</th>
								<th><?php echo $locdetails['address_1'];?>&nbsp;  </th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Address 2 </th>
								<th><?php echo $locdetails['address_2'];?>&nbsp; </th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">City</th>
								<th><?php echo $locdetails['city'];?>&nbsp; </th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">State</th>
								<th><?php echo $locdetails['state'];?>&nbsp; </th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Country</th>
								<th><?php echo $locdetails['val_country'];?>&nbsp; </th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">PO BOX</th>
								<th><?php echo $locdetails['po_box'];?>&nbsp; </th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Status</th>
								<th><?php echo $locdetails['val_status'];?>&nbsp; </th>
							</tr>
						</thead>
					</table>
					<?php } } ?>
					<div class="hr-line-dashed"></div>
					<!--
					<h3 class="lighter block green">Employees</h3>
					<div class="table-responsive">
						<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1" id="thetable">
							<thead>
							<tr>
								<th>Role</th>
								<th>Employee Number</th>
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($locdetail as $key2=>$locdetail_role){
									?>
								<tr>
									<td><?php echo $locdetail_role['role_value_code'] ?></td>
									<td><?php echo $locdetail_role['role_employee_id'] ?></td>
								</tr>
									<?php
								}
								?>
							</tbody>
						</table>
					<div class="hr-line-dashed"></div>
					-->
					<div class="form-group">
						<div class="col-sm-offset-4">
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('location_creation?locid=<?php echo $_REQUEST['locid']."&hash=".md5(SECRET.$_REQUEST['locid']);?>')">Update</button>
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('location_creation')">Create</button>
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('location_search')">Cancel</button>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
