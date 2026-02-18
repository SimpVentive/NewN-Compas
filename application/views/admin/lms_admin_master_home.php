<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-inverse card-view">
				<div class="panel-heading">
					Application Master
					<div class="pull-right">
						<a href="#" onClick="create_link('masters')" class="btn btn-primary btn-sm">&nbsp <i class="fa fa-plus-circle"></i> Create  &nbsp </a>
					</div>
				</div>
				<div class="panel-body">
					<form action="#" id="loginForm">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group col-lg-6">
									<label>Master Code</label>
									<input type="text" name="master_code" id="master_code" value="<?php echo isset($master_code)? $master_code:""; ?>" class="form-control" >
								</div>
							</div>
							<div class="form-group col-md-1">
								<div class="text-left">
									<label>&nbsp;</label>
									<button type="submit" class="btn btn-primary btn-sm" id="submit" >Search</button>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="hpanel">
					<div class="panel-body">
						<div class="table-wrap">
							<div class="table-responsive">
								<div id="edit_datable_2_wrapper" class="dataTables_wrapper">
									<table cellpadding="1" cellspacing="1" id="edit_datable_2" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>Master Code</th>
												<th>Master Title</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										<?php
										if(count($masterlists)>0){
											$t=1;
											foreach($masterlists as $key=>$masters){ 
												$keys=$key+1;
												$masterid=$masters['master_id'];
												$hash=SECRET.$masterid;
												?>
												<tr id="master_<?php echo $keys;?>" >
													<td><?php echo $masters['master_code'];?></td>
													<td><?php echo $masters['master_title'];?></td>
													<td>
														<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="<?php echo BASE_URL?>/admin/view_masters?master_id=<?php echo $masterid;?>&hash=<?php echo md5($hash);?>"><i class="fa fa-eye"></i></a>
														<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Update" href="<?php echo BASE_URL?>/admin/masters?master_id=<?php echo $masterid;?>&hash=<?php echo md5($hash);?>"><i class="fa fa-pencil"></i></a>
														
													</td>
												</tr>
											<?php
											$t++; }
										}else{ echo "<td colspan='4' class='nodata'>No Data Found</td>"; } ?>
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