<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
	<form id="criticality" action="<?php echo BASE_URL;?>/admin/lms_criticality" method="post" enctype="multipart/form-data" class="form-horizontal">
	<?php 
	$langmsg=$this->session->flashdata('langmsg');
	if(!empty($langmsg)){ echo $this->session->flashdata('langmsg'); $this->session->unset_userdata('langmsg'); } ?>
        <div class="panel panel-default card-view">
            <div class="panel-heading hbuilt">
				
				<div class="pull-left">
					<h6 class="panel-title txt-dark">Criticality Master</h6>
				</div>
				<div class="clearfix"></div>
			</div>
            <div class="panel-body">
				<div class="table-responsive">
					<table class="table table-bordered table-striped" id="table" cellspacing="1" cellpadding="1">
						<thead>
							<tr>
								<th>Criticality Code</th>
								<th>Criticality Name</th>
								<th>Description</th>
								<th>Rating Value</th>
								<th>Criticality Status</th>
							</tr>
							<?php 
							if(count($cri_data)>0){
								foreach($cri_data as $key1=>$cri_datas){
									$key=$key1+1;
								?>
								<tr>
									<td>
										<label><?php echo $cri_datas['comp_cri_code']; ?></label>
										<input type="hidden" name="comp_cri_code[]" id="comp_cri_code<?php echo $key; ?>" value="<?php echo $cri_datas['comp_cri_code']; ?>">
										<input type="hidden" name="comp_cri_id[]" id="comp_cri_id<?php echo $key; ?>" value="<?php echo $cri_datas['code']; ?>">
									</td>
									<td>
										<input class="validate[required] form-control" name="comp_cri_name[]" id="comp_cri_name<?php echo $key; ?>" data-prompt-position="topLeft" type="text" value="<?php echo $cri_datas['name']; ?>">
									</td>
									<td>
										<input class="form-control" name="description[]" id="description<?php echo $key; ?>" data-prompt-position="topLeft" type="text" value="<?php echo $cri_datas['description']; ?>">
									</td>
									<td>
										<input class="form-control" name="comp_rating_value[]" id="comp_rating_value<?php echo $key; ?>" data-prompt-position="topLeft" type="text" value="<?php echo $cri_datas['comp_rating_value']; ?>">
									</td>
									
									<td>
										<select class="validate[required] form-control m-b" name="status[]" id="status<?php echo $key; ?>">
											<option value="">Select</option>
											<?php foreach($locstatusss as $locstatus){
												$select=!empty($cri_datas['status'])?$cri_datas['status']==$locstatus['code']?"selected='selected'":"":"";?>
													<option value="<?php echo $locstatus['code'];?>" <?php echo $select; ?>><?php echo $locstatus['name'];?></option>
												<?php 
											} ?>
										</select>
									</td>
								</tr>
								<?php
								}
							}
							else{
								for($i1=0; $i1<5; $i1++){
									$i=$i1+1;
									$comp_code='C'.$i;
								?>
								<tr>
									<td>
										<label><?php echo $comp_code; ?></label>
										<input type="hidden" name="comp_cri_code[]" id="comp_cri_code<?php echo $i; ?>" value="<?php echo $comp_code; ?>">
										<input type="hidden" name="comp_cri_id[]" id="comp_cri_id<?php echo $i; ?>" value="">
									</td>
									<td>
								<input class="validate[groupRequired[name]] form-control" name="comp_cri_name[]" id="comp_cri_name<?php echo $i; ?>" data-prompt-position="topLeft" type="text" value="<?php echo $comp_code; ?>">
									</td>
									<td>
										<input class="form-control" name="description[]" id="description<?php echo $i; ?>" data-prompt-position="topLeft" type="text" value="">
									</td>
									<td>
										<input class="form-control" name="comp_rating_value[]" id="comp_rating_value<?php echo $i; ?>" data-prompt-position="topLeft" type="text" value="">
									</td>
									<td>
										<select class="validate[groupRequired[select]] form-control m-b" name="status[]" id="status<?php echo $i; ?>">
											<option value="">Select</option>
											<?php foreach($locstatusss as $locstatus){
												$sel=$locstatus['code']=='A'?"selected='selected'":"";
												?>
													<option value="<?php echo $locstatus['code'];?>" <?php echo $sel; ?>><?php echo $locstatus['name'];?></option>
												<?php 
											} ?>
										</select>
									</td>
								</tr>
							<?php }
							}							
							?>
						</thead>
					</table>
				</div>
				<hr class="light-grey-hr">
				<div class="form-group">
					<div class="col-sm-offset-0">
						<button class="btn btn-primary btn-sm" type="submit" name="save" id="save">Save changes</button>
					</div>
				</div>
            </div>
        </div>
	</form>
    </div>
</div>
</div>
</div>
