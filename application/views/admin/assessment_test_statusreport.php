<br/>
<div id='idexceltable'>
	<br/>
	<div id='navbar' class='navbar navbar-default navbar-fixed-top'>
			
		<div align='center'> <span><b>Assessment Test Report</b> </span></div>
		
		<br/>
		
		
		<span style='float:right; padding-right:30px;'>Date & Time : <b><?php echo date('d-m-Y h:i:s');?></b></span>
	</div>
	<br/>
	<table id='repheader' style='width:99%' align='center' class='table table-striped table-bordered table-hover'>
		<thead>
			<tr>
				<td>S.No</td>
				<td>Emp Code</td>
				<td>Name</td>
				<td>Department</td>
				<td>Location</td>
				<td>Grade</td>
				<td>Designation</td>
				<td>Test Status</td>
				<td>Test Score</td>
				<td>Skill Score</td>
				<td>Result</td>
				<td>Total Score</td>
			</tr>
			
			
		</thead>
		<tbody>
		<?php
		foreach($test_details as $key=>$test_detail){
		?>
		<tr>
			<td><?php echo ($key+1); ?></td>
			<td><?php echo $test_detail['employee_number'];?></td>
			<td><?php echo $test_detail['full_name'];?></td>
			<td><?php echo $test_detail['org_name'];?></td>
			<td><?php echo $test_detail['location_name'];?></td>
			<td><?php echo $test_detail['grade_name'];?></td>
			<td><?php echo $test_detail['position_name'];?></td>
			<td><?php echo ($test_detail['attempt_status']=='COM')?"Completed":"Not Started";?></td>
			<td><?php echo !empty($test_detail['score'])?$test_detail['score']:"Not Started";?></td>
			<td><?php echo !empty($test_detail['skill_marks'])?$test_detail['skill_marks']:"Not Started";?></td>
			<td><?php echo !empty($test_detail['emp_result'])?$test_detail['emp_result']:"Not Started";?></td>
			<td><?php echo !empty($test_detail['eva_score'])?$test_detail['eva_score']:"Not Started";?></td>
		</tr>
		<?php
		}
		?>
		</tbody>
	</table> 
	<br>
	
</div>
<br />
	<div align='right' style='padding:10px;'>
		
		<a class='btn btn-sm btn-success' href="https://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."&ExportType=export-to-excel"; ?>">Export To Excel</a>
	</div>
	