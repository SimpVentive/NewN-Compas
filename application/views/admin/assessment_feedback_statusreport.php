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
				<td rowspan='2' nowrap>S.No</td>
				<td rowspan='2' nowrap>Emp Code</td>
				<td rowspan='2' nowrap>Emp Name</td>
				<td rowspan='2' nowrap>Emp Location</td>
				<td rowspan='2' nowrap>Assessment Position</td>
				<td rowspan='2' nowrap>How did you find the overall process</td>
				<td nowrap colspan='5'>How do you rate each of the Methods used</td>
				<td nowrap>If you have to take a person reporting to you (new hire)..</td>
				<td nowrap>Any Other Feedback or Comments on the process, so as to improve/refine it</td>
			</tr>
			<tr>
				<td>MCQs</td>
				<td>Inbasket</td>
				<td>Casestudy</td>
				<td>360° Feedback</td>
				<td>Behavioural Instrument</td>
				<td></td>
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
				if($feed_detail['Q1']==1){
					echo "Poor";
				} 
				elseif($feed_detail['Q1']==2){
					echo "Average";
				}
				elseif($feed_detail['Q1']==3){
					echo "Good";
				}
				elseif($feed_detail['Q1']==4){
					echo "Very Good";
				}
				else{
					echo "Excellent";
				}
				?></td>
				<td>
				<?php 
				if($feed_detail['Q21']==1){
					echo "InAppropriate";
				} 
				elseif($feed_detail['Q21']==2){
					echo "Neither App. or InApp";
				}
				elseif($feed_detail['Q21']==3){
					echo "Appropriate";
				}
				else{
					echo "Not Applicable";
				}
				?>
				</td>
				<td>
				<?php 
				if($feed_detail['Q22']==1){
					echo "InAppropriate";
				} 
				elseif($feed_detail['Q22']==2){
					echo "Neither App. or InApp";
				}
				elseif($feed_detail['Q22']==3){
					echo "Appropriate";
				}
				else{
					echo "Not Applicable";
				}
				?>
				</td>
				<td>
				<?php 
				if($feed_detail['Q23']==1){
					echo "InAppropriate";
				} 
				elseif($feed_detail['Q23']==2){
					echo "Neither App. or InApp";
				}
				elseif($feed_detail['Q23']==3){
					echo "Appropriate";
				}
				else{
					echo "Not Applicable";
				}
				?>
				</td>
				<td>
				<?php 
				if($feed_detail['Q24']==1){
					echo "InAppropriate";
				} 
				elseif($feed_detail['Q24']==2){
					echo "Neither App. or InApp";
				}
				elseif($feed_detail['Q24']==3){
					echo "Appropriate";
				}
				else{
					echo "Not Applicable";
				}
				?>
				</td>
				<td>
				<?php 
				if($feed_detail['Q25']==1){
					echo "InAppropriate";
				} 
				elseif($feed_detail['Q25']==2){
					echo "Neither App. or InApp";
				}
				elseif($feed_detail['Q25']==3){
					echo "Appropriate";
				}
				else{
					echo "Not Applicable";
				}
				?>
				</td>
				<td>
				<?php 
				if($feed_detail['Q3']==1){
					echo "Yes";
				}
				else{
					echo "No";
				}
				?>
				</td>
				<td><?php echo $feed_detail['Q4']; ?></td>
				
			</tr>
		<?php } ?>
		</tbody>
	</table> 
	
	

</div>

	<br />
	<div align='right' style='padding:10px;'>
		
		<a class='btn btn-sm btn-success' href="https://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."&ExportType=export-to-excel"; ?>">Export To Excel</a>
	</div>