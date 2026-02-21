<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-inverse card-view">
				<div class="panel-heading">
					Notification
					<div class="pull-right">
						<a href="#" onClick="create_link('notification')" class="btn btn-primary btn-sm">&nbsp <i class="fa fa-plus-circle"></i> Create  &nbsp </a>
					</div>
				</div>
			
			<!--<div class="panel-heading hbuilt hblue">
               Search
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
							<button type="submit" class="btn btn-primary btn-sm form-control" id="submit" >Search</button>
						</div>

					</div>
				</div>
				
					
					
				</form>
			</div>-->
				<div class="hpanel">
					<div class="panel-body">
						<div class="table-wrap">
							<div class="table-responsive">
								<div id="edit_datable_2_wrapper" class="dataTables_wrapper">
									<table cellpadding="1" cellspacing="1" id="edit_datable_2" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>Notification Name</th>
												<th >Organization Name</th>
												<th>Notification Status</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										<?php
										if(count($notificdetails)){
											foreach($notificdetails as $key=>$notificdetail){
												$key1=$key+1;
												$nid=$notificdetail['notification_id'];
												$hash=md5(SECRET.$nid);
												?>
												<tr id="row<?php echo $key1;  ?>">
													<td><?php echo $notificdetail['notification_name']; ?></td>
													<td ><?php echo $notificdetail['org_name']; ?></td>
													<td><?php echo $notificdetail['value_name']; ?></td>
													<td>
														<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="<?php echo BASE_URL."/admin/notificatio_view?id=".$nid."&hash=".$hash;?>"><i class="fa fa-eye"></i></a>
														<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Update" href="<?php echo BASE_URL."/admin/notification?id=".$nid."&hash=".$hash;?>"><i class="fa fa-pencil"></i></a>
														<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" id="<?php echo $nid; ?>" name="delete_notification" rel="row<?php echo $key1; ?>"  href="#"><i class="fa fa-trash"></i></a>
													</td>
												</tr>
											<?php
											}
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
<div id="dialog-confirm" class="hide">
	<div class="alert alert-info bigger-110">
		Do you want to Delete this Notification ?
	</div>
	<div class="space-6"></div>
	<p class="bigger-110 bolder center grey">
		<i class="ace-icon fa fa-hand-o-right blue bigger-120"></i>
		Are you sure?
	</p>
</div>

<div id="dialog-confirm-delete" class="hide">
	<div class="alert alert-info bigger-110">		
	</div>
	<div class="space-6"></div>	
</div>