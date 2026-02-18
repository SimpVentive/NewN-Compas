<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-inverse card-view">
				<div class="panel-heading">
					Reports
					<div class="pull-right">
						<a href="#" onClick="createreport_like('report_create')" class="btn btn-primary">&nbsp <i class="fa fa-plus-circle"></i> Create  &nbsp </a>
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
								<button type="submit" class="btn btn-primary" id="submit" >Search</button>
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
												<th>Report Name</th>
												<th>Report Type</th>
												<th>Query Function</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										<?php
										if(count($reportdetails) >0){
											foreach($reportdetails as $key=>$reportdetail){
												$pub="";
												$key1=$key+1;				
												$rid=$reportdetail['report_id'];
												$hash=SECRET.$rid;
												?>
												<tr id="row<?php echo $key1; ?>">
													<td><?php echo $reportdetail['report_name'] ;?></td>
													<td class="hidden-480"><?php echo $reportdetail['default_report_name'];  ?></td>
													<td><?php echo $reportdetail['query_name']; ?></td>
													<td>
														<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="<?php echo BASE_URL."/report/report_view?id=".$rid."&hash=".md5($hash);?>"><i class="fa fa-eye"></i></a>
														<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Update" href="<?php echo BASE_URL."/report/report_create?id=".$rid."&hash=".md5($hash);?>"><i class="fa fa-pencil"></i></a>
														<a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" onclick="deletefunctionrep(this)" id="<?php echo $rid; ?>" name="deletereport" rel="row<?php echo $key1; ?>" href="#"><i class="fa fa-trash"></i></a>
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
		Do you want to Delete this Report  ?.
	</div>

	<div class="space-6"></div>

	<p class="bigger-110 bolder center grey">
		<i class="ace-icon fa fa-hand-o-right blue bigger-120"></i>
		Are you sure?
	</p>
</div>

<div id="dialog-confirm-delete" class="hide">
<div class="alert alert-info bigger-110">
	Ensure the Report is not attached to any Report Group before you delete it 
</div>

<div class="space-6"></div>

</div>