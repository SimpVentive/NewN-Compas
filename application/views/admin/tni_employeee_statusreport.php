<br/>
<div id='idexceltable'>
	<br/>
	<div id='navbar' class='navbar navbar-default navbar-fixed-top'>
			
		<div align='center'> <span><b>TNI Employee Report</b> </span></div>
		
		<br/>
		
		
		<span style='float:right; padding-right:30px;'>Date & Time : <b><?php echo date('d-m-Y h:i:s');?></b></span>
	</div>
	<br/>
	<table id='repheader' style='width:99%' align='center' class='table table-striped table-bordered table-hover'>
		<thead>
			<tr>
				<td rowspan='2' nowrap>S.No</td>
				<td rowspan='2' nowrap>Emp Code</td>
				<td rowspan='2' nowrap>Emp Name</td>
				<td rowspan='2' nowrap>Designation</td>
				<td rowspan='2' nowrap>Location</td>
			</tr>
			
			
		</thead>
		<tbody>
		<?php 
		foreach($emp_details as $key=>$emp_detail){
		?>
		<tr>
			<td><?php echo ($key+1);?></td>
			<td><?php echo $emp_detail['employee_number'];?></td>
			<td><?php echo $emp_detail['full_name'];?></td>
			<td><?php echo $emp_detail['position_name'];?></td>
			<td><?php echo $emp_detail['location_name'];?></td>
		</tr>
		<?php } ?>
		</tbody>
	</table> 
	
	

</div>

	<br />
	<div align='right' style='padding:10px;'>
		
		<a class='btn btn-sm btn-success' href="http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."&ExportType=export-to-excel"; ?>">Export To Excel</a>
	</div>