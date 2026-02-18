
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default card-view">
				<div class="panel-heading hbuilt">
					<font color="#FF0000">* Indicated are Mandatory <br></font>
					
				</div>
                <div class="panel-body">
					<form id="comp_master" action="<?php echo BASE_URL;?>/admin/instrument_master_edit" method="post" enctype="multipart/form-data">
					<input type="hidden" name="instrument_id" id="instrument_id" value="<?php if(isset($intdetail['instrument_id'])){ echo $intdetail['instrument_id']; }?>">
						<div class="table-responsive">
							<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="element_validation" name="element_validation">
								<thead>
									<tr>
										<th style="width:5%;">S.No</th>
										<?php 
										if($intdetail['instrument_type']=='BEI_RATING_TWO'){
										?>
										<th style="width:25%;">Elements Left</th>
										<th style="width:20%;">Language</th>
										<th style="width:25%;">Elements Right</th>
										<th style="width:20%;">Language</th>
										<?php
										}
										else{
										?>
										<th style="width:55%;">Elements</th>
										<th style="width:40%;">Language</th>
										<?php	
										}
										?>
										
									</tr>
								</thead>
								<tbody>
								<?php
								
								if(!empty($sub_par_detail)){
									$hide_val_c=array();
									$temp="";
									foreach($sub_par_detail as $key=>$sub_par_details){ 
										$key1=$key+1; 
										
										?> 
									<tr>
										<td><?php echo $key1; ?>
										<input type="hidden" name="ins_subpara_id[]" id="ins_subpara_id_<?php echo $key1; ?>" value="<?php echo $sub_par_details['ins_subpara_id']; ?>">
										</td>
										<?php 
										if($intdetail['instrument_type']=='BEI_RATING_TWO'){
										?>
										<td style='padding-left: 18px;'>
											<input type="text" name="ins_subpara_text[]" id="ins_subpara_text[]" value="<?php echo $sub_par_details['ins_subpara_text']; ?>" class="validate[required] form-control">
										</td>
										<td>
										<input type="text" name="ins_subpara_text_lang[]" id="ins_subpara_text_lang[]" value="<?php echo $sub_par_details['ins_subpara_text_lang']; ?>" class="form-control">
										</td>
										<td style='padding-left: 18px;'>
											<input type="text" name="ins_subpara_text_ext[]" id="ins_subpara_text_ext[]" value="<?php echo $sub_par_details['ins_subpara_text_ext']; ?>" class="validate[required] form-control">
										</td>
										<td>
										<input type="text" name="ins_subpara_text_ext_lang[]" id="ins_subpara_text_ext_lang[]" value="<?php echo $sub_par_details['ins_subpara_text_ext_lang']; ?>" class="form-control">
										</td>
										<?php } 
										else{
										?>
										<td style='padding-left: 18px;'>
											<input type="text" name="ins_subpara_text[]" id="ins_subpara_text[]" value="<?php echo $sub_par_details['ins_subpara_text']; ?>" class="validate[required] form-control">
										</td>
										<td>
										<input type="text" name="ins_subpara_text_lang[]" id="ins_subpara_text_lang[]" value="<?php echo $sub_par_details['ins_subpara_text_lang']; ?>" class="form-control">
										</td>
										<?php
										}
										?>
									</tr><?php }  $hidden=@implode(',',$hide_val_c); 
								}
								?>
								</tbody>
							</table>
							
						</div>
						<hr class="light-grey-hr">
						<div class="form-group">
							<div class="col-sm-offset-0">
								<button class="btn btn-primary btn-sm" type="submit"  name="update">Save changes</button>
								<button class="btn btn-danger btn-sm" type="button" onClick="create_link('instrument_search')">Cancel</button>
								
							</div>
						</div>
					</form>
				</div>
            </div>
        </div>
    </div>
</div>
