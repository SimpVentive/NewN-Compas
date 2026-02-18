<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">
                <div class="panel-body">					
					<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1">
						<thead>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Category Name</th>
								<th><?php  echo $catdetails['name'];?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Category Type</th>
								<th><?php echo $catdetails['cat_type'];?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Parent Category</th>
								<th><?php echo $catdetails['parent_category'];?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Category Start Date</th>
								<th><?php echo date("d-m-Y",strtotime($catdetails['start_date']));?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Category End Date</th>
								<th><?php echo date("d-m-Y",strtotime($catdetails['end_date']));?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Category Status</th>
								<th><?php echo $catdetails['cat_status'];?>&nbsp;</th>
							</tr>
						</thead>
					</table>					
					<div class="hr-line-dashed"></div>					
					<div class="form-group">
						<div class="col-sm-offset-4">
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('category_master?id=<?php echo $catdetails['category_id']."&hash=".md5(SECRET.$catdetails['category_id']);?>')">Update</button>
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('category_master')">Create</button>
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('category_master_search')">Cancel</button>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
