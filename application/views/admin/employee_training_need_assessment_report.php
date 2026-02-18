<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Training Need Report</h6>
					</div>
					<div class="clearfix"></div>
				</div>
				
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group  col-lg-4">
								<label class="control-label mb-10">Competency:</label>
								<?php 
								$comp_details=UlsMenu::callpdo("SELECT a.`comp_def_id`,b.`comp_def_name` FROM `uls_assessment_employee_dev_rating` a 
								left join(SELECT `comp_def_id`,`comp_def_name` FROM `uls_competency_definition`) b on b.comp_def_id=a.comp_def_id 
								WHERE 1 and a.`comp_def_id` is not NULL group by a.comp_def_id");
								?>
								<select id="comp_def_id" name="comp_def_id" class="validate[required] form-control m-b" data-prompt-position="topLeft" onchange="open_level();">
									<option value="">Select</option>
									<?php 
									foreach($comp_details as $comp_detail){
										$select=!empty($_REQUEST['comp_def_id'])?(($comp_detail['comp_def_id']==$_REQUEST['comp_def_id'])?"selected='selected'":""):"";
									?>
									<option value="<?php echo $comp_detail['comp_def_id']; ?>" <?php echo $select;?>><?php echo $comp_detail['comp_def_name']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
							<div class="form-group col-lg-4" id="scale_details">
								<label class="control-label mb-10">Level:</label>
								<select id="scale_id" name="scale_id" class="validate[required] form-control m-b" data-prompt-position="topLeft">
									<option value="">Select</option>
									<?php 
									if(!empty($_REQUEST['scale_id'])){
										$scale=UlsLevelMasterScale::levelscale_detail($_REQUEST['scale_id']);
									?>
									<option value="<?php echo $scale['scale_id']; ?>" selected><?php echo $scale['scale_name']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
							<div class="form-group col-md-1">
								<div class="text-left">
									<label class="control-label mb-10 text-left">&nbsp;</label>
									<a href="#" class="btn btn-primary btn-sm" onclick="assessment_details()">Search</a>
								</div>

							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					<?php 
					if(!empty($_REQUEST['comp_def_id']) && !empty($_REQUEST['scale_id'])){
						$rating_details=UlsAssessmentEmployeeDevRating::get_report_info($_REQUEST['comp_def_id'],$_REQUEST['scale_id']);
						$ele_details=UlsAssessmentEmployeeDevReport::get_report_details($_REQUEST['comp_def_id'],$_REQUEST['scale_id']);
						$tni_per=UlsTniPercentage::tni_per_details();
					?>
					<form action="<?php echo BASE_URL;?>/admin/tni_report_insert" method="post" id="reportForm">
						<input type="hidden" name="in_comp_def_id" value="<?php echo $_REQUEST['comp_def_id']; ?>">
						<input type="hidden" name="in_scale_id" value="<?php echo $_REQUEST['scale_id']; ?>">
						<input type="hidden" name="assessment_id" value="<?php echo $rating_details['assessment_id']; ?>">
						<input type="hidden" name="position_id" value="<?php echo $rating_details['position_id']; ?>">
						<input type="hidden" name="dev_report_id" value="<?php echo !empty($ele_details['dev_report_id'])?$ele_details['dev_report_id']:""; ?>">
						<input type="hidden" name="tni_per_id" value="<?php echo !empty($tni_per['tni_per_id'])?$tni_per['tni_per_id']:""; ?>">
						<input type="hidden" name="tni_percentage" value="<?php echo !empty($tni_per['tni_percentage'])?$tni_per['tni_percentage']:""; ?>">
						<h6>Key Training coverage aspects for the above competency </h6>
						<p>Note:  The following are the key training areas that have been identified for this competency, in this level, by a majority of people.</p>
						<table cellpadding="1" cellspacing="1" id="edit_datable_2" class="table table-hover table-bordered mb-0">
							<thead>
								<tr>
									<th class="col-sm-1">S.No</th>
									<th class="col-sm-10">Element Name</th>
									<th class="col-sm-1">Employee Count</th>
								</tr>
							</thead>
							<tbody>
							<?php 
							$element_name=UlsAssessmentEmployeeDevRating::get_element_details($_REQUEST['comp_def_id'],$_REQUEST['scale_id']);
							$total=0;
							foreach($element_name as $key=>$element_names){
								$total+=$element_names['emp_count'];
							}
							$total_sum=0;
							$comp_element_id="";
							foreach($element_name as $key=>$element_names){
								$total_per=round((($element_names['emp_count']/$total)*100),2);
								$total_sum+=$total_per;
								if($total_sum<=$tni_per['tni_percentage']){
									$comp_element_id.=$element_names['ind_id']. ',';
							?>
								<tr>
									<td class="col-sm-2"><?php echo $key+1; ?></td>
									<td class="col-sm-8"><?php echo $element_names['comp_def_level_ind_name'];?></td>
									<td class="col-sm-1"><a onclick="get_employee_details(<?php echo $_REQUEST['comp_def_id'];?>,<?php echo $_REQUEST['scale_id'];?>,<?php echo $element_names['comp_def_level_ind_id'];?>);" style="color:blue;cursor: pointer;" data-toggle="modal" data-target=".bs-example-modal-lg" ><?php echo $element_names['emp_count'];?></a></td>
									<!--<td><?php echo $total_per; ?></td>-->
								</tr>
							<?php
								}							
							}?>
							<!--<tr>
								<td colspan="2"></td>
								<td><?php echo $total; ?></td>
							</tr>-->
							</tbody>
						</table>
						<?php $comp_element_id=trim($comp_element_id, ','); ?>
						<hr class="light-grey-hr">
						<h6>Please modify /edit the elements to create your program design  for this competency:</h6>
						<div class="form-group">
							<div class="col-sm-12">
								<?php $level_ind_id_s=!empty($ele_details['dev_report_id'])?$ele_details['level_ind_ids']:$comp_element_id; ?>
								<input type="hidden" name="level_ind_ids" value="<?php echo $level_ind_id_s; ?>">
								<textarea class="validate[required] summernote form-control m-b" name="program_design" id="program_design" >
								<?php
								if(!empty($ele_details['dev_report_id'])){
									echo $ele_details['program_design'];
								}
								else{
									$total_n_sum=0;
									foreach($element_name as $key=>$element_names){
										$total_per=round((($element_names['emp_count']/$total)*100),2);
										$total_n_sum+=$total_per;
										if($total_n_sum<=$tni_per['tni_percentage']){
											echo ($key+1).") ".$element_names['comp_def_level_ind_name']."<br>";
										}
									}
								}
								
								?>
								</textarea>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="form-group col-lg-4">
									<label class="control-label mb-10 text-left">Suggested Trainer/Facilitator <sup><font color="#FF0000">*</font></sup></label>
									<input type="text" class="validate[required] form-control" name="trainer_name" id="trainer_name" value="<?php echo !empty($ele_details['trainer_name'])?$ele_details['trainer_name']:""; ?>">
								</div>
								<div class="form-group col-lg-3">
									<label class="control-label mb-10 text-left">Trainer/Facilitator Type<sup><font color="#FF0000">*</font></sup></label>
									<select name="trainer_type" id="trainer_type" class="validate[required]  form-control m-b">
										<option value="">Select</option>
										<?php 		
										foreach($type as $types){
											$type_sel=isset($ele_details['trainer_type'])?($ele_details['trainer_type']==$types['code'])?"selected='selected'":"":"";?>
											<option value="<?php echo $types['code'];?>" <?php echo $type_sel; ?>><?php echo $types['name'];?></option>
										<?php 	
										}?>
									</select>
								</div>
								<div class="form-group col-lg-3">
									<label class="control-label mb-10 text-left">Tentative Duration<sup><font color="#FF0000">*</font></sup> </label>
									<select name="program_duration" id="program_duration" class="validate[required]  form-control m-b">
										<option value="">Select</option>
										<?php 
										
										for($i=1;$i <= 10;$i++){
											$dur_sel=isset($ele_details['program_duration'])?($ele_details['program_duration']==$i)?"selected='selected'":"":"";
											?>
											<option value="<?php echo $i;?>" <?php echo $dur_sel; ?>><?php echo $i;?></option>
										<?php 	
										}?>
									</select>
								</div>
							</div>
						</div>
						
						<hr class="light-grey-hr">
						<div class="form-group">
							<button class="btn btn-primary btn-sm" type="submit" name="save" id="save">Training Design</button>
							<a href="<?php echo BASE_URL;?>/admin/tni_employee_report?comp_def_id=<?php echo $_REQUEST['comp_def_id'];?>&scale_id=<?php echo $_REQUEST['scale_id'];?>&ele_id=<?php echo $level_ind_id_s;?>" target="_blank" class="btn btn-danger btn-sm" type="button"> <span class="bold">List of participants </span></a>
						</div>
						<div class="clearfix"></div>
					</form>	
					<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h5 class="modal-title" id="myLargeModalLabel">Employee Details</h5>
			</div>
			<div class="modal-body">
				<h5 class="mb-15" id="followdes">Following are the Employees</h5>
				<div id="txtHint" style="margin: 15px;">
				
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger text-left" data-dismiss="modal">Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<?php

if(!empty($_REQUEST['dev_report_id'])){
	?>
	<script>
	window.open("<?php echo BASE_URL.'/admin/report_generation_tni?dev_report_id='.$_REQUEST['dev_report_id']; ?>",'_blank');
	</script>
	<?php
	
}
?>

