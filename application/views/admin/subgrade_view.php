<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">
                <div class="panel-body">	
					<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1">
						<thead>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Sub Grade Name</th>
								<th><?php  echo $gradedetails['subgrade_name'];?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Status</th>
								<th><?php echo $gradedetails['val_status'];?>&nbsp;</th>
							</tr>
						</thead>
					</table>					
					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<div class="col-sm-offset-4">
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('subgrade_creation?subgrade_id=<?php echo $gradedetails['subgrade_id']."&hash=".md5(SECRET.$gradedetails['subgrade_id']);?>')">Update</button>
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('subgrade_creation')">Create</button>
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('subgrade_search')">Cancel</button>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
