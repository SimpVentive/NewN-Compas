<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">
                <div class="panel-body">
					<?php 
					$level_msg=$this->session->flashdata('level_msg');
					if(!empty($level_msg)){ 
					?>
					<div id="error_div" class="alert alert-success">
						
						<?php
						echo $this->session->flashdata('level_msg');
						$this->session->unset_userdata('level_msg'); ?>
					</div>
					<br>
					<?php } ?>
					<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1">
						<thead>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Level Name</th>
								<th><?php  echo $leveldetails['level_name'];?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Level Scale</th>
								<th><?php echo $leveldetails['level_scale'];?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Status</th>
								<th><?php echo $leveldetails['level_status'];?>&nbsp;</th>
							</tr>
						</thead>
					</table>
					
					<div class="hr-line-dashed"></div>
					<h3 class="lighter block green">Level Scale Details</h3>
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
									$id=(isset($_REQUEST['level_id']))?$_REQUEST['level_id']:'';
									$subgrd=UlsLevelMasterScale::levelscale($id);
									if(count($subgrd)>0){
										foreach($subgrd as $kei=>$subgd){?>
											<tr id='subgrd<?php echo $kei;?>'>
												<td>
													<label><?php echo $subgd['scale_number']; ?></label>
												</td>
												<td>
													<label><?php echo $subgd['scale_name']; ?></label>
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
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('level_master?level_id=<?php echo $leveldetails['level_id']."&hash=".md5(SECRET.$leveldetails['level_id']);?>')">Update</button>
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('level_master')">Create</button>
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('level_master_search')">Cancel</button>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
