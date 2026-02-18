<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">			
                <div class="panel-body">					
					<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1">
						<thead>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">KRA Name</th>
								<th><?php  echo $kradetails['kra_master_name'];?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Status</th>
								<th><?php echo $kradetails['status'];?>&nbsp;</th>
							</tr>
						</thead>
					</table>					
					<div class="hr-line-dashed"></div>
					<h3 class="lighter block green">KRA Comptency Details</h3>
					<div class="table-responsive">
						<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1" id="thetable">
							<thead>
							<tr>
								<th>Competency Name</th>
								<th>Status</th>
							</tr>
							</thead>
							<tbody>
								<?php 
									if(count($kracomp)>0){
										foreach($kracomp as $kei=>$kracomps){?>
											<tr id='subgrd<?php echo $kei;?>'>
												<td>
													<label><?php echo $kracomps['comp_def_name']; ?></label>
												</td>
												<td>
													<label><?php echo $kracomps['comp_status']; ?></label>
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
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('kra_master?kra_master_id=<?php echo $kradetails['kra_master_id']."&hash=".md5(SECRET.$kradetails['kra_master_id']);?>')">Update</button>
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('kra_master')">Create</button>
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('kra_master_search')">Cancel</button>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
