<script>    
<?php
//To send justifications to .js file
$just=""."*"."select";
foreach($category as $categorys){
    if($just==''){
        $just=$categorys['category_id']."*".$categorys['name'];
    }
    else{
        $just=$just.",".$categorys['category_id']."*".$categorys['name'];
    }
}
echo "var justfication='".$just."';"; 

//To send sub grade names to .js file
$grad="";
foreach($subgrades as $subgrade){
	$grad=(empty($grad))?$subgrade['subgrade_id']."*".$subgrade['subgrade_name']:$grad.",".$subgrade['subgrade_id']."*".$subgrade['subgrade_name'];    
}
echo "var grades='".$grad."';"; 

//To send sub grade status to .js file
$grad_st="";
foreach($gradestatus as $pocstatus){
	$grad_st=(empty($grad_st))?$pocstatus['code']."*".$pocstatus['name']:$grad_st.",".$pocstatus['code']."*".$pocstatus['name'];   
}
echo "var grade_staus='".$grad_st."';"; 
?>
</script>
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default card-view">
				<div class="panel-heading">
					<font color="#FF0000">* Indicated are Mandatory <br></font>
				</div>
                <div class="panel-body">
					
					<form name="gradeform" id="gradeform" method="post" action="<?php echo BASE_URL;?>/admin/lms_grades" class="form-horizontal">
						<input type="hidden" id="grade_id" name="grade_id"  value="" />
						<input type="hidden" id="parent_date" name="parent_date" value="<?php echo date('d-m-Y',strtotime($_SESSION['org_start_date'])); ?>"   />
						<div id="error_div" class="message">
						<?php 
						$grade_msg=$this->session->flashdata('grade_msg');
						if(!empty($grade_msg)){ echo $this->session->flashdata('grade_msg'); $this->session->unset_userdata('grade_msg'); } ?></div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Grade Name<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5"><input type="text" id="grade_name" name="grade_name" class="validate[required,funcCall[checknotinteger],minSize[2],maxSize[30],ajax[ajaxGrade]] form-control"></div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Grade Percentage<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5"><input type="text" id="grade_percentage" name="grade_percentage" class="validate[required,custom[number],minSize[1],maxSize[3]] form-control"></div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Status<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<select  id="status" class="validate[required] form-control m-b" name="status">
									<option value="">Select</option>
									<?php foreach($gradestatus as $pocstatus){?>
									<option value="<?php echo $pocstatus['code'];?>"><?php echo $pocstatus['name'];?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="panel-body">
							<div class="panel-heading">
								
								<div class="pull-left">
									<h6 class="panel-title txt-dark">Sub Grade Details</h6>
								</div>
								<div class="pull-right">
									<a class="btn btn-xs btn-primary" onClick="return AddGrade()" >&nbsp <i class="fa fa-plus-circle"></i> Add &nbsp </a>
									<a class="btn btn-danger btn-xs" onClick="DelGrade()" >&nbsp <i class="fa fa-trash-o"></i>  Delete &nbsp </a>
								</div>
							</div>
							<br style="clear:both">
							<div class="table-responsive">
								<input type="hidden" id="sub_grade_id" name="sub_grade_id" value="">
								<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="sub_grade_table">
									<thead>
									<tr>
										<th>Select</th>
										<th>Sub Grade Name</th>
										<th>Status</th>
									</tr>
									</thead>
									<tbody>
									<tr id='subgrd0'>
										<td><label><input type="checkbox" id="subgrade0" name="subgrade" value="0"></label><input type="hidden" id="sub_grade_id0" name="sub_grade_id[]" value=""></td>
										<td>
											<select name="sub_grade_name[]" id="sub_grade_name[0]" class="form-control m-b">
												<option value="">Select</option>
										<?php 	foreach($subgrades as $subgrade){?>
													<option value="<?php echo $subgrade['subgrade_id'];?>"><?php echo $subgrade['subgrade_name'];?></option>
										<?php 	} ?>
											</select>
										</td>
										<td>
											<select class="form-control m-b" name="grade_status[]" id="grade_status[0]" >
												<option value="">Select</option>
												<?php 	foreach($gradestatus as $pocstatus){?>
														<option value="<?php echo $pocstatus['code'];?>"><?php echo $pocstatus['name'];?></option>
												<?php 	} ?>
											</select>
										</td>
									</tr>
									</tbody>
									<input type="hidden" name="subgradecount[]" id="subgradecount" value="0" />
								</table>
							</div>
						</div>
						<hr class="light-grey-hr">
						<div class="panel-heading hbuilt">
							
							<div class="pull-left">
								<h6 class="panel-title txt-dark">Training Days Details</h6>
							</div>
							<div class="pull-right">
								<a class="btn btn-xs btn-primary" onClick="return AddRow()">&nbsp <i class="fa fa-plus-circle"></i> Add &nbsp</a>
								<a class="btn btn-danger btn-xs">&nbsp <i class="fa fa-trash-o"></i>  Delete &nbsp</a>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="table-responsive">
							<input type="hidden" id="grade_year_id" name="grade_year_id" value="">
							<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="training_table">
								<thead>
								<tr>
									<th>Select</th>
									<th>Training Year (from)</th>
									<th>Training Year (to)</th>
									<th>Category</th>
									<th>Training Days</th>
								</tr>
								</thead>
								<tbody>
								<tr>
									<td><label><input type="checkbox" id="checkgrade0" name="checkgrade" value="1"></label><input type="hidden" id="gradeyearid0" name="gradeyearid[]" value=""></td>
									<td>
										<input type="text" type='text' name='month[]' id='month_0' class="date-picker0 form-control m-b validate[custom[date2]]" readonly='readonly'>
									</td>
									<td>
										<input type="text" name='month_to[]' id='month_to_0' class="date-picker_0  form-control m-b validate[custom[date2],future[#month_0]]" readonly='readonly'>
									</td>
									<td>
										<select class="form-control m-b" name="category[]" id="category[0]">
											<option value="">Select</option>
											<?php foreach($category as $categorys){?>
											<option value="<?php echo $categorys['category_id'];?>"><?php echo $categorys['name'];?></option>
											<?php } ?>
										</select>
									</td>
									<td>
										<input type="text" id="tra_days[0]" name="tra_days[]" class="form-control m-b" maxlength="2">
									</td>
								</tr>
								</tbody>
								<input type="hidden" name="trainingcount[]" id="trainingcount" value="0" />
							</table>
						</div>
						<hr class="light-grey-hr">
						<div class="form-group">
							<div class="col-sm-offset-0">
								<button class="btn btn-primary btn-sm" type="submit" name="save" id="save" onClick="return validation()">Save changes</button>
								<button class="btn btn-danger btn-sm" type="button" onClick="create_link('grade_search')">Cancel</button>
								
							</div>
						</div>
					</form>
				</div>
            </div>
        </div>
    </div>
</div>
