
<div id='idexceltable' >
	<br />
	<div id='navbar' class='navbar navbar-default navbar-fixed-top'>
	<div align='center'> <span><b>Assessment Interview Report</b> </span></div><br/>
	<span style='float:right; padding-right:30px;'>Date & Time : <b><?php echo  date('d-m-Y h:i:s');?></b></span>
	</div><br />
	<?php
	
	if(!isset($_REQUEST['ExportType'])){ ?>
		<div align='right' style='padding:10px;'>
			<input type='button' onclick="htmltopdf('idexceltable','<?php echo (isset($_REQUEST['report_name']))?$_REQUEST['report_name']:''?>')" name='btnpdfExport' class='btn btn-sm btn-success'  id='btnpdfExport' value='Generate Pdf' >					
			<!--<input type='button' name='btnExport' class='btn btn-sm btn-success' id='btnExport' value='Export to excel' onclick="downloadexcel('employeesTable','<?php echo (isset($_REQUEST['report_name']))?$_REQUEST['report_name']:''?>')">-->
			<a class='btn btn-sm btn-success' href="https://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."&ExportType=export-to-excel"; ?>">Export To Excel</a>
		</div>
		<?php 		
	}?>
	<?php
	
	$ass_type=array();
	
	?>
	<table id='employeesTable' style='widtd:100%' align='center' class='table table-striped table-bordered table-hover'>
		
	</table>
	<table id='employeesTable' style='widtd:100%' align='center' class='table table-striped table-bordered table-hover'>
		<thead>
			<tr>
				<td>S.No</td>
				<td>Employee Number</td>
				<td>Employee Name</td>
				<td>Department</td>
				<td>Location</td>
				<td>Assessment Position</td>
				<td>Competency</td>
				<td>Req. Level</td>
				<td>1st-Assessment Overall Score</td>
				<td>Re-Assessment Overall Score</td>
				<td>Re-Assessment MCQ Test</td>
				<td>Re-Assessment PI Test</td>
			</tr>
			
		</thead>
		<tbody>
		<?php 
		$key=1;
		foreach($emp_details as $emp_detail){
			$emp_pre_report=UlsAssessmentEmployees::get_assessment_employees_prereport($emp_detail['employee_id'],$emp_detail['assessment_id'],$emp_detail['position_id']);
		?>
		<tr>
			<td><?php echo $key; ?></td>
			<td><?php echo $emp_detail['employee_number']; ?></td>
			<td><?php echo $emp_detail['full_name']; ?></td>
			<td><?php echo $emp_detail['org_name']; ?></td>
			<td><?php echo $emp_detail['location_name']; ?></td>
			<td><?php echo $emp_detail['position_name']; ?></td>
			<td><?php echo $emp_detail['comp_def_name']; ?></td>
			<td><?php echo $emp_detail['rating_number']; ?></td>
			<td>
			<?php
			$ass_final_score=UlsAssessmentEmployeeFinalReport::get_assessment_employees_report($emp_pre_report['assessment_id'],$emp_detail['position_id'],$emp_detail['employee_id'],$emp_detail['competency_id'],$emp_detail['require_scale_id']);
			echo !empty($ass_final_score['assessed_value'])?$ass_final_score['assessed_value']:"-";
			?>
			</td>
			<td><?php echo $emp_detail['assessed_value']; ?></td>
			<td>
			<?php
			$asscomptest=UlsAssessmentReport::admin_position_assessed_competency_level_test($emp_detail['assessment_id'],$emp_detail['position_id'],$emp_detail['competency_id'],$emp_detail['employee_id'],$emp_detail['require_scale_id']);
			echo !empty($asscomptest['ass_ave'])?round($asscomptest['ass_ave'],2):"-";
			?>
			</td>
			<td>
			<?php
			$asscompinterview=UlsAssessmentReport::admin_position_assessed_competency_level_interview($emp_detail['assessment_id'],$emp_detail['position_id'],$emp_detail['competency_id'],$emp_detail['employee_id'],$emp_detail['require_scale_id']);
			echo !empty($asscompinterview['ass_ave'])?round($asscompinterview['ass_ave'],2):"-";
			?>
			</td>
			
		</tr>
		<?php
		$key++;
		}
		?>
		</tbody>
	</table>
	
	</div><br /><br />
	
			