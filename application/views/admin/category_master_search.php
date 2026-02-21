<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Create Category Master</h6>
					</div>
					<div class="pull-right">
						<a onClick="create_link('category_master')" href="#" class="btn btn-primary btn-xs pull-left mr-15">&nbsp <i class="fa fa-plus-circle"></i> Create Category Master &nbsp </a>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-body">
					<form action="" id="loginForm" class="searchForm" method="get">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group col-lg-6">
									<label class="control-label mb-10 text-left">Category Type</label>
									<select class="chosen-select  form-control m-b" name="cat_type" id="cat_type">
									<option>Select</option>
									<?php foreach($cat_types as $res){ $sel=($res['code']==$cat_type) ? "selected=selected":""; ?>
									<option <?php echo $sel; ?> value="<?php echo $res['code']; ?>"><?php echo $res['name']; ?></option>
									<?php } ?>
									</select>
								</div>
								<div class="form-group col-lg-6">
									<label class="control-label mb-10 text-left">Category Name</label>
									<input value="<?php echo @$cat_name; ?>" class="form-control" name="cat_name" type="text">
								</div>
							</div>
							<div class="form-group col-md-1">
								<div class="text-left">
									<label class="control-label mb-10 text-left">&nbsp;</label>
									<button class="btn btn-primary btn-sm">Search</button>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="hpanel">
					<div class="panel-body">
						<h6 class="txt-dark capitalize-font">Search Results</h6>
						<hr class="light-grey-hr">
						<div class="table-wrap">
							<div class="table-responsive">
								<div id="edit_datable_2_wrapper" class="dataTables_wrapper">
									<table cellpadding="1" cellspacing="1" id="edit_datable_2" class="table table-hover table-bordered mb-0">
										<thead>
											<tr>
												<th class="col-sm-5">Category Name</th>
												<th class="col-sm-3">Category Type</th>
												<th class="col-sm-2">Status</th>
												<th class="col-sm-2">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($searchresults as $val){ ?>
											<tr class="tooltip-demo" id="catdel_<?php echo $val['category_id']; ?>">
												<td><?php echo @$val['name'];?></td>
												<td><?php echo @$val['cat_type'];?></td>
												<td><?php echo @$val['cat_status'];?></td>
												<td>
													<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="<?php echo BASE_URL;?>/admin/category_view?id=<?php echo @$val['category_id'];?>"><i class="fa fa-eye text-success"></i></a>
													<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Update" href="<?php echo BASE_URL;?>/admin/category_master?id=<?php echo @$val['category_id'];?>"><i class="fa fa-pencil text-primary"></i></a>
													<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" id="<?php echo $val['category_id']; ?>" name="deletecategory" rel="catdel_<?php echo $val['category_id']; ?>" onclick="deletefunction(this)"><i class="fa fa-trash text-danger"></i></a>
												</td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
									<?php echo $pagination; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>