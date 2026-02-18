<br/>
<div id='idexceltable'>
	<br/>
	<div id='navbar' class='navbar navbar-default navbar-fixed-top'>
			
		<div align='center'> <span><b>Assessment Mapped Employees Report</b> </span></div>
		
		<br/>
		
		
		<span style='float:right; padding-right:30px;'>Date & Time : <b><?php echo date('d-m-Y h:i:s');?></b></span>
	</div>
	<br/>
	<table id='repheader' style='width:99%' align='center' class='table table-striped table-bordered table-hover'>
		<thead>
			<tr align='center' style='background-color:#436DAC; color:#fff;'>
				<th align='center'>S.No</th>
				<th align='center'>Feedback Opted</th>
				<th align='center'>Feedback Giver</th>
			</tr>
		</thead>
		<?php 
		foreach($feed_details as $key=>$feed_detail){
			$feed_test=UlsAssessmentTestFeedback::getfeedback_assessment($feed_detail['assessment_id'],$feed_detail['position_id']);
			$rating_seeker=UlsFeedbackEmployeeRating::seeker_status_data($feed_detail['assessment_id'],$feed_detail['group_id'],$feed_detail['employee_id'],$feed_test['assess_test_id'],$feed_test['ques_id']);
			
			if(!empty($rating_seeker['status'])){
				if($rating_seeker['status']=='C'){
					$col12="color='#00cc33'";
				}
				elseif($rating_seeker['status']=='W'){
					$col12="color='#ff6600'";
				}
				else{
					$col12="color='#000'";
				}
			}
			else{
				$col12="color='#000'";
			}
			$ids="";
			if(!empty($feed_detail['manager_id'])){
				$ids=$feed_detail['manager_id'];
			}
			
			if(!empty($feed_detail['peer_id'])){
				if(!empty($ids)){
					$ids=$ids.",".$feed_detail['peer_id'];
				}
				else{
					$ids=$feed_detail['peer_id'];
				}
			}
			if(!empty($feed_detail['sub_ordinates_id'])){
				if(!empty($ids)){
					$ids=$ids.",".$feed_detail['sub_ordinates_id'];
				}
				else{
					$ids=$feed_detail['sub_ordinates_id'];
				}
			}
			if(!empty($feed_detail['customer_id'])){
				if(!empty($ids)){
					$ids=$ids.",".$feed_detail['customer_id'];
				}
				else{
					$ids=$feed_detail['customer_id'];
				}
			}
			if(!empty($feed_detail['m_m_id'])){
				if(!empty($ids)){
					$ids=$ids.",".$feed_detail['m_m_id'];
				}
				else{
					$ids=$feed_detail['m_m_id'];
				}
			}
			if(!empty($feed_detail['s_s_id'])){
				if(!empty($ids)){
					$ids=$ids.",".$feed_detail['s_s_id'];
				}
				else{
					$ids=$feed_detail['s_s_id'];
				}
			}
			if(!empty($feed_detail['coc_id'])){
				if(!empty($ids)){
					$ids=$ids.",".$feed_detail['coc_id'];
				}
				else{
					$ids=$feed_detail['coc_id'];
				}
			}
			//echo $ids."<br>";
			$a=explode(',',$ids);
		?>
		<tr height='25'  style='font:bold 10px Verdana, Geneva, sans-serif;' >
			<td  nowrap='nowrap' style='background-color:#F0F8FF;' align='left'>
				<?php echo $key+1; ?>
			</td>
			<td  nowrap='nowrap' style='background-color:#F0F8FF;' align='left'>
				<font <?php echo $col12;?> ><?php echo $feed_detail['employee_number']."-".$feed_detail['full_name'];?></font>
				
			</td>
			<td bgcolor='' align='center'>
				<table border='1' height='100%' width='100%'>
				<thead>
					<tr>
					<?php
					if(!empty($a)){
						foreach($a as $value){
							if(!empty($value)){
								?>
								<td nowrap='nowrap'> 
								<?php
								$feedopt_giver=UlsEmployeeMaster::get_employees($value);
								$feedopt=UlsFeedbackEmployeeRating::giver_rating_status_new($feed_detail['assessment_id'],$feed_detail['group_id'],$value,$feed_test['assess_test_id'],$feed_test['ques_id']);
								
								if(!empty($feedopt)){
									if($feedopt['status']=='C'){
										$col="color='#00cc33'";
									}
									elseif($feedopt['status']=='W'){
										$col="color='#ff6600'";
									}
									else{
										$col="color='#000'";
									}
								}
								else{
									$col="color='#000'";
								}
								?>
								<font <?php echo $col;?> ><?php echo $feedopt_giver['employee_number']."-".$feedopt_giver['full_name'];?></font>
								</td>
								<?php
							}
						}
					}
					?>
				</tr>
				</thead>
				</table>
			</td>
		</tr>
		<?php
		}
		?>
	</table> 
	
	

</div>

	<br />
	<div align='right' style='padding:10px;'>
		
		<a class='btn btn-sm btn-success' href="http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."&ExportType=export-to-excel"; ?>">Export To Excel</a>
	</div>