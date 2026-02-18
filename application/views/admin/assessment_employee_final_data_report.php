<script>
function assessment_details(){
	var selMulti = $.map($("#assessement_name option:selected"), function (el, i) {
         return $(el).val();
    });
	var ass_select_ids=selMulti.join(",");
	if(ass_select_ids!=''){
		location.href=BASE_URL+"/admin/assessment_data_report?ass_id="+ass_select_ids;
	}
	
}
</script>

	<!--<div class="row">
		<div class="col-lg-12">
			 <div class="panel panel-default card-view">
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Search Parameters</h6>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-wrapper collapse in">
				
					<div class="panel-body">
						<div class="col-md-12">
							
							<div class="col-lg-6">
								<div class="panel-heading">
									<div class="pull-left col-lg-4">
										<h6 class="panel-title txt-dark">Assessment Name :</h6>
									</div>
									<div class="pull-left">
										
										<select name="assessement_name[]" id="assessement_name" class="col-lg-12" multiple="multiple" data-placeholder="Choose" onchange="assessment_details();" style="width:150%">
										
										<optgroup label='Assessment Cycles'>
										<?php
										foreach($assessments as $assessment){
										$zone=isset($_REQUEST['ass_id'])?explode(",",$_REQUEST['ass_id']):array();
										$program_sel=in_array($assessment['assessment_id'],$zone)?"selected='selected'":"";
										?>
										<option value='<?php echo $assessment['assessment_id'];?>' <?php echo $program_sel; ?>><?php echo $assessment['assessment_name'];?></option>	
										<?php
										}
										?>	
										</optgroup>
										
										</select>
									</div>
									<div class="clearfix"></div>
								</div>
							</div>
						</div>
						
					</div>
				
				</div>
			</div>
		</div>
	</div>-->
	<?php 
	if(!empty($ass_id)){
	?>
	<div align='right' style='padding:10px;'>
		
		<a class='btn btn-sm btn-success' href="https://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."&ExportType=export-to-excel"; ?>">Export To Excel</a>
	</div>
	<div id="idexceltable">	
		<table id='repheader' style='width:99%' align='center' class='table table-striped table-bordered table-hover'>
			<thead>
			
				<tr>
					<td nowrap>Employee Code</td>
					<td nowrap>Employee Name</td>
					<td nowrap>Grade Code</td>
					<td nowrap>Designation</td>
					<td nowrap>Grade</td>
					<td nowrap>Location</td>
					<td nowrap>Solar/Wind</td>
					<td nowrap>Work Scope</td>
					<td nowrap>Assessment Position</td>
					<th nowrap>Competency</th>
					<th nowrap>Required level</th>
					<th nowrap>Assessed Value</th>
					
				</tr>
			</thead>
			<?php 
			foreach($comp_data as $key=>$emp_datas){
			?>
			<tr>
				
				<td><?php echo $emp_datas['employee_number'];?></td>
				<td><?php echo $emp_datas['full_name'];?></td>
				<td><?php echo $emp_datas['subgradename'];?></td>
				<td><?php echo $emp_datas['position_name'];?></td>
				<td><?php echo @$emp_datas['grade_name'];?></td>
				<td><?php echo @$emp_datas['location_name'];?></td>
				<td><?php echo @$emp_datas['bu'];?></td>
				<td><?php echo $emp_datas['org_name'];?></td>
				<td><?php echo $emp_datas['ass_position_name'];?></td>
				<td><?php echo $emp_datas['comp_def_name'];?></td>
				<td><?php echo $emp_datas['scale_name'];?></td>
				<td><?php echo $emp_datas['assessed_value'];?></td>
			</tr>
			<?php
			}
			?>
		</table>
					
			
	</div>
	
	<?php
	}?>
