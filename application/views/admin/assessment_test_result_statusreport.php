<br/>
<div id='idexceltable'>
	<br/>
	<div id='navbar' class='navbar navbar-default navbar-fixed-top'>
			
		<div align='center'> <span><b>Assessment Employee Test Results Report</b> </span></div>
		
		<br/>
		
		
		<span style='float:right; padding-right:30px;'>Date & Time : <b><?php echo date('d-m-Y h:i:s');?></b></span>
	</div>
	<br />
	<?php
	if(count($emp_details)>0 && !isset($_REQUEST['ExportType'])){ ?>
		<div align='right' style='padding:10px;'>
			<input type='button' onclick="htmltopdf('idexceltable','<?php echo (isset($_REQUEST['report_name']))?$_REQUEST['report_name']:''?>')" name='btnpdfExport' class='btn btn-sm btn-success'  id='btnpdfExport' value='Generate Pdf' >					
			<!--<input type='button' name='btnExport' class='btn btn-sm btn-success' id='btnExport' value='Export to excel' onclick="downloadexcel('employeesTable','<?php echo (isset($_REQUEST['report_name']))?$_REQUEST['report_name']:''?>')">-->
			<a class='btn btn-sm btn-success' href="https://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."&ExportType=export-to-excel"; ?>">Export To Excel</a>
		</div>
		<?php 		
	}?>
	<br/>
	
	<table id='repheader' style='width:99%' align='center' class='table table-striped table-bordered table-hover'>
		<thead>
			<tr>
				<td nowrap>S.No</td>
				<td nowrap>Emp Id</td>
				<td nowrap>Emp Name</td>
				<td nowrap>Grade Code</td>
				<td nowrap>Designation</td>
				<td nowrap>Grade</td>
				<td nowrap>Location</td>
				<td nowrap>Solor/Wind</td>
				<td nowrap>Area</td>
				<td nowrap>Assessment Position</td>
				<td nowrap># of Questions</td>
				<td nowrap>MCQ Correct</td>
				<td nowrap>MCQ Wrong</td>
				<td nowrap>MCQ Left</td>
				<td nowrap>MCQ Score</td>
				<td nowrap>MCQ % Score</td>
			</tr>
			
		</thead>
		<tbody>
		<?php
			foreach($emp_details as $key=>$employees){
				$left_q=UlsUtestResponsesAssessment::question_count_blank($employees['employee_id'],$employees['event_id'],$employees['assessment_id']);
				$wrong_q=UlsUtestResponsesAssessment::question_count_wrong($employees['employee_id'],$employees['event_id'],$employees['assessment_id']);
				$per=round(((($employees['score'])/($employees['correct_ans']+$wrong_q['w_count']))*100),2);
			?>
				<tr>
					<td><?php echo ($key+1);?></td>
					<td><?php echo $employees['employee_number'];?></td>
					<td><?php echo $employees['full_name'];?></td>
					<td><?php echo $employees['subgradename'];?></td>
					<td><?php echo $employees['position_name'];?></td>
					<td><?php echo @$employees['grade_name'];?></td>
					<td><?php echo @$employees['location_name'];?></td>
					<td><?php echo @$employees['bu'];?></td>
					<td><?php echo $employees['org_name'];?></td>
					<td><?php echo $employees['ass_position_name'];?></td>
					<td><?php echo $employees['correct_ans']+$wrong_q['w_count']+$left_q['c_count'];?></td>
					<td><?php echo $employees['correct_ans'];?></td>
					<td><?php echo $wrong_q['w_count'];?></td>
					<td><?php echo $left_q['c_count'];?></td>
					<td><?php echo $employees['score'];?></td>
					<td><?php echo $per;?></td>
				</tr>
			<?php 
			}
			?>
		</tbody>
	</table> 
	
	

</div>

	