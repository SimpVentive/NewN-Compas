<br/>
<div id='idexceltable'>
	<br/>
	<div id='navbar' class='navbar navbar-default navbar-fixed-top'>
			
		<div align='center'> <span><b>Assessor Feedback Report</b> </span></div>
		
		<br/>
		
		
		<span style='float:right; padding-right:30px;'>Date & Time : <b><?php echo date('d-m-Y h:i:s');?></b></span>
	</div>
	<br/>
	<table id='repheader' style='width:99%' align='center' class='table table-striped table-bordered table-hover'>
		<thead>
			<tr>
				<td rowspan='2' nowrap>S.No</td>
				<td rowspan='2' nowrap>Assessor Name</td>
				<td rowspan='2' nowrap>How do you find this process of Competency Assessment & Development, from an Assessor’s perspective</td>
				<td rowspan='2' nowrap>Do you think this process is objective in assessing individuals?</td>
				<td rowspan='2' nowrap>This process will help in drawing up the Development roadmap of the Individual</td>
				<td rowspan='2' nowrap>Would you recommend this process for the purpose of Hiring</td>
				<td rowspan='2' nowrap>Reason</td>
				<td rowspan='2' nowrap>Can you suggest ways of improving this process and making it more effective</td>
			</tr>
			
		</thead>
		<tbody>
		<?php 
		foreach($feed_details as $key=>$feed_detail){
		?>
			<tr>
				<td><?php echo $key+1; ?></td>
				<td><?php echo $feed_detail['assessor_name']; ?></td>
				<td><?php 
				if($feed_detail['Q1']==1){
					echo "Excellent";
				} 
				elseif($feed_detail['Q1']==2){
					echo "Very Good";
				}
				elseif($feed_detail['Q1']==3){
					echo "Good";
				}
				elseif($feed_detail['Q1']==4){
					echo "Average";
				}
				else{
					echo "Poor";
				}
				?></td>
				<td>
				<?php 
				if($feed_detail['Q2']==1){
					echo "Yes";
				}
				else{
					echo "No";
				}
				?>
				</td>
				<td>
				<?php 
				if($feed_detail['Q3']==1){
					echo "Strongly Disagree";
				} 
				elseif($feed_detail['Q3']==2){
					echo "Disagree";
				}
				elseif($feed_detail['Q3']==3){
					echo "Neither Agree nor Disagree";
				}
				elseif($feed_detail['Q3']==4){
					echo "Agree";
				}
				else{
					echo "Strongly Agree";
				}
				?>
				</td>
				<td>
				<?php 
				if($feed_detail['Q41']==1){
					echo "Yes";
				}
				else{
					echo "No";
				}
				?>
				</td>
				<td>
				<?php 
				echo !empty($feed_detail['Q42'])?$feed_detail['Q42']:"-";
				?>
				</td>
				<td><?php echo $feed_detail['Q5']; ?></td>
			</tr>
		<?php } ?>
		</tbody>
	</table> 
	
	

</div>

	<br />
	<div align='right' style='padding:10px;'>
		
		<a class='btn btn-sm btn-success' href="http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."&ExportType=export-to-excel"; ?>">Export To Excel</a>
	</div>