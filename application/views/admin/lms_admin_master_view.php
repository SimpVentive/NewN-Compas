<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-inverse card-view">				
                <div class="panel-body">
					<?php 
					if(count($viewmaster)>0){
						foreach($viewmaster as $viewmaster1){
							$mastrid=$viewmaster1['master_id'];
							$hash=SECRET.$mastrid;
							$mastrcode=$viewmaster1['master_code'];
							$mastrtitle=$viewmaster1['master_title'];
							$mastrdesc=$viewmaster1['description'];
						}
					}else{
						$mastrid='';
						$hash='';
						$mastrcode='';
						$mastrtitle='';
						$mastrdesc='';
					}
					?>
					<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1">
						<thead>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Master Code</th>
								<th><?php  echo $mastrcode;?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Master Title</th>
								<th><?php  echo $mastrtitle;?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Description</th>
								<th><?php  echo $mastrdesc;?>&nbsp;</th>
							</tr>
						</thead>
					</table>
					
					<div class="hr-line-dashed"></div>
					<h5 class="lighter block green">Master Details</h5>
					<div class="table-responsive">
						<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1" id="thetable">
							<thead>
							<tr>
								<th>Code</th>
								<th>Value</th>
								<th>Start Date</th>
								<th>End Date</th>
							</tr>
							</thead>
							<tbody>
							<?php $f=0; foreach($viewmaster1['UlsAdminValues'] as $keys=>$value){?>
								<tr <?php if($f==1){ ?> class="first" <?php } ?>>
									<td><?php echo $value['value_code'];?></td>
									<td><?php echo $value['value_name'];?></td>
									<td class="hidden-480"><?php echo ($value['start_date']!=NULL)?date('d-m-Y',strtotime($value['start_date'])):'';?></td>
									<td class="hidden-480"><?php echo ($value['end_date']!=NULL)?date('d-m-Y',strtotime($value['end_date'])):'';?></td>
								</tr>
							<?php }?>
							</tbody>
						</table>
					</div>
					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<div class="col-sm-offset-4">
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('masters?master_id=<?php echo $mastrid;?>&hash=<?php echo md5($hash)?>')">Update</button>
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('masters')">Create</button>
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('master_home')">Cancel</button>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
