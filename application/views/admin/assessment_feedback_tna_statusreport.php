<br/>
<div id='idexceltable'>
	<br/>
	<div id='navbar' class='navbar navbar-default navbar-fixed-top'>
			
		<div align='center'> <span><b>Assessment Feedback Report</b> </span></div>
		
		<br/>
		
		
		<span style='float:right; padding-right:30px;'>Date & Time : <b><?php echo date('d-m-Y h:i:s');?></b></span>
	</div>
	<br/>
	<table id='repheader' style='width:99%' align='center' class='table table-striped table-bordered table-hover'>
		<thead>
			<tr>
				<td nowrap>S.No</td>
				<td nowrap>Emp Code</td>
				<td nowrap>Emp Name</td>
				<td nowrap>Emp Location</td>
				<td nowrap>Ass Position</td>
				<td nowrap>Do you think that this process has helped in identifying your specific training needs?</td>
				<td nowrap>Do you have any suggestions for improving the process.</td>
				<td nowrap>Date</td>
			</tr>
			
		</thead>
		<tbody>
		<?php 
		foreach($feed_details as $key=>$feed_detail){
		?>
			<tr>
				<td><?php echo $key+1; ?></td>
				<td><?php echo $feed_detail['employee_number']; ?></td>
				<td><?php echo $feed_detail['full_name']; ?></td>
				<td><?php echo $feed_detail['location_name']; ?></td>
				<td><?php echo $feed_detail['ass_position_name']; ?></td>
				<td><?php 
				if($feed_detail['feed_q1']==1){
					echo "Strongly Disagree";
				}
				if($feed_detail['feed_q1']==2){
					echo "Disagree";
				}
				if($feed_detail['feed_q1']==3){
					echo "Neither Agree nor Disagree";
				}
				if($feed_detail['feed_q1']==4){
					echo "Agree";
				}
				if($feed_detail['feed_q1']==5){
					echo "Strongly Agree";
				}
				?></td>
				<td><?php echo $feed_detail['feed_q2'];?></td>
				<td><?php echo date("d-m-Y",strtotime($feed_detail['modified_date']));?></td>
			</tr>
		<?php } ?>
		</tbody>
	</table> 
	
	

</div>

	<br />
	<div align='right' style='padding:10px;'>
		
		<a class='btn btn-sm btn-success' href="https://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."&ExportType=export-to-excel"; ?>">Export To Excel</a>
	</div>