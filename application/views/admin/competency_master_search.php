<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Competency Definition</h6>
					</div>
					<div class="pull-right">
						<a href="<?php echo BASE_URL;?>/admin/competency_master" class="btn btn-primary btn-sm">&nbsp <i class="fa fa-plus-circle"></i> Create Competency Definition &nbsp </a>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-body">
					<form action="" id="loginForm" class="searchForm" method="get">
						<div class="row">
							<!--<div class="col-md-3">								
								<div class="form-group col-lg-12">
									<label class="control-label mb-10 text-left">Competency Type</label>
									<select class=" form-control m-b" id="comp_type" name="comp_type" style="width: 100%">
										<option value="">Select</option>
										<?php 
										foreach($pos_types as $pos_type){
											$dep_sel=isset($comp_type)?($comp_type==$pos_type['code'])?"selected='selected'":"":"";
											?>
												<option value="<?php echo $pos_type['code'];?>" <?php echo $dep_sel; ?>><?php echo $pos_type['name'];?></option>
											<?php } ?>
									</select>
								</div>
							</div>-->
							<div class="col-md-3">								
								<div class="form-group col-lg-12">
									<label class="control-label mb-10 text-left">Category</label>
									<select class=" form-control m-b" id="cat_type" name="cat_type" style="width: 100%">
										<option value="">Select</option>
										<?php 
										foreach($cat_details as $pos_type){
											$dep_sel=isset($cat_type)?($cat_type==$pos_type['category_id'])?"selected='selected'":"":"";
											?>
												<option value="<?php echo $pos_type['category_id'];?>" <?php echo $dep_sel; ?>><?php echo $pos_type['name'];?></option>
											<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-md-3">						
								<div class="form-group col-lg-12">
									<label class="control-label mb-10 text-left">Competency Name</label>
									<input value="<?php echo @$comp_name; ?>" id="comp_name" class="form-control" name="comp_name" type="text">
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
										<!-- sample modal content -->
										<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
											<div class="modal-dialog modal-lg">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
														<h5 class="modal-title" id="myLargeModalLabel">Competency Positions</h5>
													</div>
													<div class="modal-body">
														<h5 class="mb-15">Following are the Positions</h5>
														<div id="txtHint" style="margin: 15px;">
														
														</div>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-danger text-left" data-dismiss="modal">Close</button>
													</div>
												</div>
												<!-- /.modal-content -->
											</div>
											<!-- /.modal-dialog -->
										</div>
										<div class="modal fade bs-example1-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
											<div class="modal-dialog modal-lg">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
														<h5 class="modal-title" id="myLargeModalLabel">Competency Added Question Bank</h5>
													</div>
													<div class="modal-body">
														
														<div id="txtHint_question" style="margin: 15px;">
														
														</div>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-danger text-left" data-dismiss="modal">Close</button>
													</div>
												</div>
												<!-- /.modal-content -->
											</div>
											<!-- /.modal-dialog -->
										</div>
										
										<!-- /.modal -->
								<div id="edit_datable_2_wrapper" class="dataTables_wrapper">
									<table cellpadding="1" cellspacing="1" id="edit_datable_2" class="table table-hover table-bordered mb-0">
										<thead>
											<tr>
												<th>Competency Definition</th>
												<th>Type</th>
												<th>Category</th>
												<th>Area</th>
												<th>Additional Category</th>
												<th>Positions</th>
												<th>Question Banks</th>
												<th>Status</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($searchresults as $val){ ?>
											<tr class="tooltip-demo" id="compdefdel_<?php echo $val['comp_def_id']; ?>">
												<td><a href="<?php echo BASE_URL;?>/admin/competency_master_view?id=<?php echo @$val['comp_def_id'];?>&hash=<?php echo md5(SECRET.$val['comp_def_id']);?>"><?php echo @$val['comp_def_name'];?></a></td>
												<td><?php echo @$val['comp_type'];?></td>
												<td><?php echo @$val['category'];?></td>
												<td><?php echo @$val['subcategory'];?></td>
												<td><?php echo @$val['addcategory'];?></td>
												<td><a onclick="getoptions(<?php echo $val['comp_def_id']; ?>);" style="cursor: pointer;" data-toggle="modal" data-target=".bs-example-modal-lg"><?php echo @$val['positions'];?></a></td>
												<td><a onclick="getoptions_question(<?php echo $val['comp_def_id']; ?>);" style="cursor: pointer;" data-toggle="modal" data-target=".bs-example1-modal-lg"><button class="btn btn-danger btn-icon-anim btn-circle btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Total Question Banks Attached to Competency"><?php echo !empty($val['ques_bank'])?$val['ques_bank']:0;?></button>&nbsp;<button class="btn btn-primary btn-icon-anim btn-circle btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Attached Question Bank"><?php echo !empty($val['ques_bank_count'])?$val['ques_bank_count']:0;?></button></a></td>
												<td><?php echo @$val['comp_status'];?></td>
												<td>
													<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="PDF" target='_blank' href="<?php echo BASE_URL;?>/admin/competencypdf?id=<?php echo @$val['comp_def_id'];?>&hash=<?php echo md5(SECRET.$val['comp_def_id']);?>"><i class="fa fa-file-pdf-o text-info"></i> </a>
													<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Details" href="<?php echo BASE_URL;?>/admin/competency_levels?status&id=<?php echo @$val['comp_def_id'];?>&hash=<?php echo md5(SECRET.$val['comp_def_id']);?>"><i class="fa fa-file text-warning"></i> </a>
													<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="<?php echo BASE_URL;?>/admin/competency_master_view?id=<?php echo @$val['comp_def_id'];?>&hash=<?php echo md5(SECRET.$val['comp_def_id']);?>"><i class="fa fa-eye text-primary"></i> </a>
													<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Update" href="<?php echo BASE_URL;?>/admin/competency_master?id=<?php echo @$val['comp_def_id'];?>&hash=<?php echo md5(SECRET.$val['comp_def_id']);?>"><i class="fa fa-pencil text-success"></i> </a>
													<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" id="<?php echo $val['comp_def_id']; ?>" name="deletecompdef" rel="compdefdel_<?php echo $val['comp_def_id']; ?>" onclick="deletefunction(this)"><i class="fa fa-trash text-danger"></i> </a>
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
<script>
function getoptions(id){
	document.getElementById("txtHint").innerHTML ="";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", "<?php echo BASE_URL; ?>/admin/competencyattachedposition?id=" + id, true);
	xmlhttp.send();
}

function getoptions_question(id){
	document.getElementById("txtHint_question").innerHTML ="";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint_question").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", "<?php echo BASE_URL; ?>/admin/competencyattachedquestionbank?id=" + id, true);
	xmlhttp.send();
}


</script>