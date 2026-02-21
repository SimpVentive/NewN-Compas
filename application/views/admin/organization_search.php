<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Create Organization</h6>
					</div>
					<div class="pull-right">
						
						<a onClick="create_link('org_master')" href="#" class="btn btn-primary btn-xs pull-left mr-15">&nbsp <i class="fa fa-plus-circle"></i> Create Organization &nbsp </a>
					</div>
					<div class="clearfix"></div>
				</div>
				
				<div class="panel-body">
					<form action="" method="get" >
						<div class="row">
							<div class="col-md-6">
								<div class="form-group col-lg-6">
									<label class="control-label mb-10 text-left">Organization Type</label>
									<select class="chosen-select form-control m-b" name="org_type" id="org_type">
										<option value="">Select</option>
										<?php foreach($organizationtypes as $actor_type){ $sel=isset($org_type)? (($org_type==$actor_type['value_code'])?"selected='selected'":""):""?>
										<option <?php echo $sel; ?> value="<?php echo $actor_type['value_code']; ?>"><?php echo $actor_type['value_name']; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group col-lg-6">
									<label class="control-label mb-10 text-left">Organization Name</label>
									<input type="text" class="form-control" name="organization" id="organization" value="<?php echo isset($organization)? $organization:""; ?>" >
								</div>
							</div>
							<div class="form-group col-md-1">
								<div class="text-left">
									<label class="control-label mb-10 text-left">&nbsp;</label>
									<button type="submit" class="btn btn-primary btn-sm" id="submit">Search</button>
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
											<th class="col-sm-4">Organization Name</th>
											<th class="col-sm-2">Organization Type</th>
											<th class="col-sm-2">Start Date</th>
											<th class="col-sm-2">End Date</th>
											<th class="col-sm-2">Action</th>
										</tr>
										</thead>
										<tbody>
										<?php
										if(count($masterlists)>0){
											$t=1;                        
											foreach($masterlists as $key=>$masters){
												$keys=$key+1;
												$orgid=$masters['organization_id'];
												$hash=SECRET.$orgid;
											?>
											<tr class="tooltip-demo" id="org_del_row_<?php echo $keys;?>">
												<td><?php echo $masters['org_name'];?></td>
												<td><?php echo $masters['value_name'];?></td>
												<td><?php echo ($masters['start_date']!=NULL)? date('d-m-Y',strtotime($masters['start_date'])):"";?>
												</td>
												<td><?php echo ($masters['end_date']!=NULL)? date('d-m-Y',strtotime($masters['end_date'])):"";?>
												</td>
												<td>
													<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="<?php echo BASE_URL?>/admin/org_master_view?orgid=<?php echo $orgid?>&hash=<?php echo md5($hash)?>"><i class="fa fa-eye text-success"></i> <span class="bold"></span></a>
													<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Update" href="<?php echo BASE_URL?>/admin/org_master?orgid=<?php echo $orgid?>&hash=<?php echo md5($hash)?>"><i class="fa fa-pencil text-primary"></i></a>
													<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" id="<?php echo $orgid; ?>" name="deleteOrganization" rel="org_del_row_<?php echo $keys; ?>" href="#" onclick="deletefunction(this)"><i class="fa fa-trash text-danger"></i> <span class="bold"></span></a>
												</td>
											</tr>
											<?php 	$t++;
											}
											} else{ echo "<td colspan='4' class='nodata'>No Data Found</td>"; } ?>
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

<div id="dialog-confirm" class="hide">
	<div class="alert alert-info bigger-110">
		Do you want to Delete this Organization ?
	</div>

	<div class="space-6"></div>

	<p class="bigger-110 bolder center grey">
		<i class="ace-icon fa fa-hand-o-right blue bigger-120"></i>
		Are you sure?
	</p>
</div>

<div id="dialog-confirm-delete" class="hide">
	<div class="alert alert-info bigger-110">
		Selected Organization cannot be deleted. Ensure you delete all the usages of the Organization before you delete it.
	</div>

	<div class="space-6"></div>
	
</div>
