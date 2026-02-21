<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">			
                <div class="panel-body">					
					<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1">
						<thead>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Rating Scale Name</th>
								<th><?php  echo $ratingdetails['rating_name'];?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Scale</th>
								<th><?php echo $ratingdetails['rating_scale'];?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Status</th>
								<th><?php echo $ratingdetails['rating_status'];?>&nbsp;</th>
							</tr>
						</thead>
					</table>					
					<div class="hr-line-dashed"></div>
					<h5 class="lighter block green">Rating Scale Details</h5>
					<div class="table-responsive">
						<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1" id="thetable">
							<thead>
							<tr>
								<th>Scale Number</th>
								<th>Scale Name</th>
							</tr>
							</thead>
							<tbody>
								<?php 
									$id=(isset($_REQUEST['rating_id']))?$_REQUEST['rating_id']:'';
									$subgrd=UlsRatingMasterScale::ratingscale($id);
									if(count($subgrd)>0){
										foreach($subgrd as $kei=>$subgd){?>
											<tr id='subgrd<?php echo $kei;?>'>
												<td>
													<label><?php echo $subgd['rating_number']; ?></label>
												</td>
												<td>
													<label><?php echo $subgd['rating_name_scale']; ?></label>
												</td>
											</tr>
								<?php 	}
									}?>
							</tbody>
						</table>
					</div>
					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<div class="col-sm-offset-4">
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('rating_master?rating_id=<?php echo $ratingdetails['rating_id']."&hash=".md5(SECRET.$ratingdetails['rating_id']);?>')">Update</button>
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('rating_master')">Create</button>
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('rating_master_search')">Cancel</button>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
