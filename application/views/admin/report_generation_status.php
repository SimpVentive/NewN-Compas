<div id="idexceltable">	
<br />
<div id='navbar' class='navbar navbar-default navbar-fixed-top'>
	<div align='center'> <span><b>Report Generation Status</b> </span></div><br/>
	
	<span style='float:right; padding-right:30px;'>Date & Time : <b><?php echo  date('d-m-Y h:i:s');?></b></span>
	</div><br />
<div align='right' style='padding:10px;'>
	<?php
	if(!isset($_REQUEST['ExportType'])){ ?>
	<a class='btn btn-sm btn-success' href="https://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."?ExportType=export-to-excel"; ?>">Export To Excel</a>
	<?php 
	}
	?>
</div>

	<table id='employeesTable' style='width:99%' align='center' class='table table-striped table-bordered table-hover'>
		<thead>
		
			<tr>
				<td nowrap>S.No</td>
				<td nowrap>Generated Employee Code</td>
				<td nowrap>Generated Employee Name</td>
				<td nowrap>Employee Code</td>
				<td nowrap>Employee Name</td>
				<td nowrap>Grade Code</td>
				<td nowrap>Designation</td>
				<td nowrap>Grade</td>
				<td nowrap>Location</td>
				<td nowrap>Solar/Wind</td>
				<td nowrap>Work Scope</td>
				<th nowrap>Assessment Name</th>
				<th nowrap>Assessed Position Name</th>
				
			</tr>
		</thead>
		<?php 
		foreach($emp_data as $key=>$emp_datas){
			
		?>
		<tr>
			<td><?php echo $key+1;?></td>
			<td><?php echo $emp_datas['admin_employee_number'];?></td>
			<td><?php echo $emp_datas['admin_full_name'];?></td>
			<td><?php echo $emp_datas['employee_number'];?></td>
			<td><?php echo $emp_datas['full_name'];?></td>
			<td><?php echo $emp_datas['subgradename'];?></td>
			<td><?php echo $emp_datas['position_name'];?></td>
			<td><?php echo @$emp_datas['grade_name'];?></td>
			<td><?php echo @$emp_datas['location_name'];?></td>
			<td><?php echo @$emp_datas['bu'];?></td>
			<td><?php echo $emp_datas['org_name'];?></td>
			<td><?php echo $emp_datas['assessment_name'];?></td>
			<td><?php echo $emp_datas['ass_position_name'];?></td>
			
		</tr>
		<?php
		}
		?>
	</table>
				
		
</div>
