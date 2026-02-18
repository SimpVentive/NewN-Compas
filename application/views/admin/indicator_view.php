
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">
				
                <div class="panel-body">
					
					<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1">
						<thead>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Indicator Name</th>
								<th><?php  echo $indicatordetails['ind_master_name'];?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Status</th>
								<th><?php echo $indicatordetails['value_name'];?>&nbsp;</th>
							</tr>
						</thead>
					</table>
					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<div class="col-sm-offset-4">
							<button class="btn btn-success" type="button" onClick="create_link('indicator_update?ind_master_id=<?php echo $indicatordetails['ind_master_id']."&hash=".md5(SECRET.$indicatordetails['ind_master_id']);?>')">Update</button>
							<button class="btn btn-info" type="button" onClick="create_link('indicator_update')">Create</button>
							<button class="btn btn-danger" type="button" onClick="create_link('indicator_search')">Cancel</button>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
