
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">				
                <div class="panel-body">
					<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1">
						<thead>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Zone Name</th>
								<th><?php  echo $zonedetail['zone_name'];?>&nbsp;</th>
							</tr>
						</thead>
					</table>
					<div class="hr-line-dashed"></div>
					<h5 class="lighter block green">List States</h5>
					<div class="table-responsive">
						<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1" id="thetable">
							<thead>
							<tr>
								<th>Name</th>
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($zonestates as $key2=>$zonestate){
									?>
								<tr>
									<td><?php echo $zonestate['state_name'] ?></td>
								</tr>
									<?php
								}
								?>
							</tbody>
						</table>
					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<div class="col-sm-offset-4">
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('zone_creation?zone_id=<?php echo $_REQUEST['zone_id']."&hash=".md5(SECRET.$_REQUEST['zone_id']);?>')">Update</button>
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('zone_creation')">Create</button>
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('zone_search')">Cancel</button>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
