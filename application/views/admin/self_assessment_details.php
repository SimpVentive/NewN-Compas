<div class="content">
    <div class="row">
        <div class="col-lg-12">			
            <div class="panel panel-inverse card-view">
                <div class="panel-body">
					<h3><?php echo @$compdetails['assessment_name']; ?> <small>(<?php echo @$compdetails['assessmentstatus']; ?>)</small></h3>
					<div class="col-lg-12">
                        <p>
						<?php echo @$compdetails['assessment_desc']; ?>
						</p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="panel panel-inverse card-view">
				<ul class="nav nav-pills">
					<?php $j=0; foreach($positions as $position){ $class=($j==0)?"active":""; $j++;?>
						<li class="<?php echo $class; ?>"><a data-toggle="tab" href="#tab-<?php echo $position['position_id']; ?>"> <?php echo $position['position_name']; ?></a></li>
					<?php } ?>
				</ul>
				<div class="tab-content">
					<?php $i=0; foreach($positions as $position){ 
					$classs=($i==0)?"active":""; $i++;
					$ass_position=UlsAssessmentPosition::get_assessment_position_info($position['position_id'],$compdetails['assessment_id']);
					?>
					<div id="tab-<?php echo $position['position_id']; ?>" class="tab-pane <?php echo $classs; ?>">
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<div class="panel panel-inverse card-view">
										<?php
										$tab_1=!empty($_REQUEST['tab'])?($_REQUEST['tab']==1?"active":""):$classs;
										$tab_2=!empty($_REQUEST['tab'])?($_REQUEST['tab']==2?"active":""):"";
										?>
										<ul class="nav nav-pills">
											<li class="<?php echo $tab_1; ?>"><a data-toggle="tab" href="#tab-compentencies<?php echo $position['position_id']; ?>">Competencies</a></li>
											<li class="<?php echo $tab_2; ?>"><a data-toggle="tab" href="#tab-employees<?php echo $position['position_id']; ?>"> Employees</a></li>
										</ul>
										<div class="tab-content ">
										<?php $tab_a1=!empty($_REQUEST['tab'])?($_REQUEST['tab']==1?"active":""):""; ?>
											<div id="tab-compentencies<?php echo $position['position_id']; ?>" class="tab-pane <?php echo $tab_a1; ?>">
											<form id="case_master" action="<?php echo BASE_URL;?>/admin/self_assessment_competency_insert" method="post" enctype="multipart/form-data">
											<input type="hidden" name="assessment_id" id="assessment_id" value="<?php echo (isset($_REQUEST['id']))?$_REQUEST['id']:''?>">
											<input type="hidden" name="position_id" id="position_id" value="<?php echo $position['position_id']; ?>">
												<div class="panel-body">
													<div class="table-responsive">
														<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
															<thead>
															<tr>
																<th class="col-sm-1">Select</th>
																<th class="col-sm-3">Category</th>
																<th class="col-sm-3">Competencies</th>
																<th class="col-sm-3">Scale</th>
															</tr>
															</thead>
															<tbody>
															
															<?php
															
															$test=array();
															$posdetails=UlsCompetencyPositionRequirements::self_competencypositionrequirement_details($position['position_id'],$_REQUEST['id']);
															foreach($posdetails as $key1=>$posdetail){
																$key=$key1+1;
																
																if($posdetail['comp_position_id']==$position['position_id']){
																	$check=!empty($posdetail['self_ass_comp_id'])?"checked='checked'":"";
																	?>
																	<tr>
																	<td><input type='checkbox' name='check_position[<?php echo $posdetail['comp_def_id'];?>]' id='check_position_<?php echo $position['position_id'];?>'  <?php echo $check;?> value='<?php echo $posdetail['comp_def_id'];?>'>
																	<input type='hidden' name='self_ass_comp_id[<?php echo $posdetail['comp_def_id'];?>]' id='self_ass_comp_id[]' value='<?php echo $posdetail['self_ass_comp_id'];?>'>
																	<input type='hidden' name='assessment_pos_id[<?php echo $posdetail['comp_def_id'];?>]' id='assessment_pos_id[]' value='<?php echo $posdetail['assessment_pos_id'];?>'>
																	<?php /*<input type='hidden' name='assessment_type[]' id='ass_type_<?php echo $key;?>' value='<?php echo $posdetail['type'];?>'>*/ ?>
																	<input type='hidden' name='assessment_pos_level_id[<?php echo $posdetail['comp_def_id'];?>]' id='assessment_pos_level_id[]' value='<?php echo $posdetail['level_id'];?>'>
																	<input type='hidden' name='assessment_pos_level_scale_id[<?php echo $posdetail['comp_def_id'];?>]' id='assessment_pos_level_scale_id[]' value='<?php echo $posdetail['scale_id'];?>'>
																	<input type='hidden' name='assessment_pos_com_id[]' id='assessment_pos_com_id[]' value='<?php echo $posdetail['comp_def_id'];?>'>
																	</td>
																	<td><?php echo $posdetail['name'];?></td>
																	<td><?php echo $posdetail['comp_def_name'];?></td>
																	<td><?php echo$posdetail['scale_name'];?> </td>
																	
																</tr>
																<?php
																}
															} ?>
															</tbody>
														</table>
													</div>
													<?php /*id="assessment_type_details" */ ?>
													
												</div>
												<?php 
												if($ass_position['assessment_broadcast']!='A'){
												?>
												<div class="text-right m-t-xs">
													<button class="btn btn-danger" type="button" onclick="create_link('assessment_search')"><i class="fa fa-reply"></i> <span class="bold">Cancel</span></button>
													<button class="btn btn-primary " type="submit" name="submit" id="submit"><i class="fa fa-check"></i> Submit</button>
												</div>
												<?php } ?>
											</form>
											</div>
											<?php $tab_a2=!empty($_REQUEST['tab'])?($_REQUEST['tab']==2?"active":""):""; ?>
											<div id="tab-employees<?php echo $position['position_id']; ?>" class="tab-pane <?php echo $tab_a2;?>">
												<div class="panel-body">
													<form method="post" action="<?php echo BASE_URL;?>/admin/self_assessment_employee_insert" class="form-horizontal" id="self_emp_enroll<?php echo $position['position_id']; ?>">
													<input type="hidden" name="assessment_id" id="assessment_id_employee_<?php echo $position['position_id']; ?>" value="<?php echo (isset($_REQUEST['id']))?$_REQUEST['id']:''?>">
													<input type="hidden" name="position_id" id="position_id_employee_<?php echo $position['position_id']; ?>" value="<?php echo $position['position_id']; ?>">
													<div class="form-group"><label class="col-sm-3 control-label">Employee Enrollment:</label>
														<div class="col-sm-5">
															<select name="enroll_type" id="enroll_type_<?php echo $position['position_id']; ?>" onChange='enrolltype(<?php echo $position['position_id']; ?>,"self")'  class="form-control m-b">
																<option value="">Select</option>
																<option value="1">Single Enrollment</option>
																<option value="2">Bulk Enrollment</option>
															</select>
														</div>
													</div>
													<div class="table-responsive">
														<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
															<thead>
															<tr>
																<th>Employee Code</th>
																<th>Employee name</th>
																<th>Department</th>
																<th>Position</th>
															</tr>
															</thead>
															<tbody>
															<?php
															foreach($employees as $employee){														
																if($employee['position_id']==$position['position_id']){
																	echo "<tr><td>".$employee['employee_number']."</td>
																	<td>".$employee['full_name']."</td>
																	<td>".$employee['org_name']."</td>
																	<td>".$employee['position_name']."</td></tr>";
																}
															} ?>
															</tbody>
														</table>
													</div>
													<div id="enrollment_div_<?php echo $position['position_id']; ?>"></div>	
<div id="bulk_enrollment_div_<?php echo $position['position_id']; ?>" style="display:none;"  >
		<h4 class='header blue bolder smaller'>Bulk Enrollment</h4>
		<div class='row'>
			<div class='col-xs-12 col-sl-3'>
				<div class='form-group'>
					<div class='col-xs-12'>
						<a href='<?php echo BASE_URL;?>/public/templates/bulk_assessment_template.csv' style='text-decoration:underline;color:#00F' id='bulk_template'>Click here</a> to download sample template
					</div>
				</div>
			</div><br>
			<div class='col-xs-12 col-sl-3'>
				<div class='form-group'>
					<div class='col-xs-3'>
						<input type='file' name='upload' class="" id='bulkempupload<?php echo $position['position_id']; ?>'>&nbsp;&nbsp;<br>
					</div>
				</div>
			</div>
			<div class='col-xs-12 col-sl-3'>
				<input type='button' class='btn btn-sm btn-success bulk_upload' dat="self" name='bulk_upload' id='<?php echo $position['position_id']; ?>' value='Upload'>
			</div>
			</div>
	<br><br>
<h4 class='header blue bolder smaller'>Employee Details</h4>
<div id='bulk_search_data<?php echo $position['position_id']; ?>'>


<table id='single_enroll_tab' class='table table-striped table-bordered table-hover'>
<thead>
<tr>
<th>Employee Number</th>
<th>Employee Name</th>
<th>Department</th>
<th>Position</th>
</tr>
</thead>
<tr id='single_enroll0'>
<td style='padding-left:20px;'>
No Search Data Found</td>
<td align='left'>
<input type='hidden' name='employee_number[]' id='employee_number[0]' value=''/></td>
<td align='left'><input type='hidden' name='employee_name[]' id='employee_name[0]' value=''/></td>

</tr></table>
</div>
                </div>
														
													</form>
												</div>
											</div>
											
										</div>
									</div>
								</div>
							</div>
							
							
						</div>
					</div>
					
					<div id="workinfoview<?php echo $position['position_id']; ?>"  class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true">
						<div class="modal-dialog modal-lg" style="width:98%">
							<div class="modal-content">
								<div class="color-line"></div>
								<div class="modal-header">
									<h6 class="modal-title">Assessment Broadcast</h6>
									<button type="button" class="btn btn-default pull-right" data-dismiss="modal">X</button>
								</div>
								<div class="modal-body">
									<div id="workinfodetails<?php echo $position['position_id']; ?>" class="modal-body no-padding">
									
									</div>
								</div>
								
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div>
					<?php } ?>					
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
/* print_r($this->session->userdata);
if(!empty($this->session->flashdata('assmethod'))){
	if($this->session->flashdata('assmethod')=='TEST'){ */
		
if(!empty($_REQUEST['gen'])){
	if($_REQUEST['gen']=='TEST'){	
?>
<script type="text/javascript" >
$(document).ready(function(){
	open_position(<?php echo $_REQUEST['id']?>,<?php echo @$_REQUEST['pos_id']; ?>,'<?php echo $_REQUEST['gen']; ?>');
});
</script>
<?php
	}
}
//$this->session->unset_userdata('assmethod');
?>
<script>
function get_check_questions(id){
	window.open(BASE_URL+"/admin/questions_view_assessment?assess_test_id="+id,'_blank')
}
function get_check_question(id){
	window.open(BASE_URL+"/admin/questions_view_assessment_view?assess_test_id="+id,'_blank')
}
</script>

<div id="dialog-confirm" class="hide">
	<div class="alert alert-info bigger-110">
		Do you want to Delete this inbasket ?
	</div>

	<div class="space-6"></div>

	<p class="bigger-110 bolder center grey">
		<i class="ace-icon fa fa-hand-o-right blue bigger-120"></i>
		Are you sure?
	</p>
</div>