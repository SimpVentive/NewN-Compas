<br/>
<div id='idexceltable'>
	<br/>
	<div id='navbar' class='navbar navbar-default navbar-fixed-top'>
			
		<div align='center'> <span><b>Assessment Giver Employees Report</b> </span></div>
		
		<br/>
		
		
		<span style='float:right; padding-right:30px;'>Date & Time : <b><?php echo date('d-m-Y h:i:s');?></b></span>
	</div>
	<br/>
	<?php 
	$userid=array();
	$managaer=array();
	$peer=array();
	$subordinate=array();
	$customer=array();
	$intcustomer=array();
	$ids="";
	$ar=array();
	$ss='';
	$var=0;      
	foreach($feed_details as $key=>$feed_detail){
		$feed_test=UlsAssessmentTestFeedback::getfeedback_assessment($feed_detail['assessment_id'],$feed_detail['position_id']);
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
		$id=$feed_detail['employee_id'];
		$employee_id[$id]=$a;
		foreach($a as $aauser){ 
			if(!in_array($aauser,$ar)){
				$ar[]=$aauser;
				$var++;
			}
		}
	}
	?>
	<table id='repheader' style='width:99%' align='center' class='table table-striped table-bordered table-hover'>
		<thead>
			<tr align='center' style='background-color:#436DAC; color:#fff;'>
				<th align='center'>Feedback Givers</th>
				<th align='center'>Total</th>
				<th align='center'>Completed</th>
				<th align='center'>Inprocess</th>
				<th align='center'>Not Started</th>
				<th align='center'>Feedback Seekers</th>
			</tr>
		</thead>
		<?php 
		foreach($ar as $val){
			$feedopt_giver=UlsEmployeeMaster::fetch_giver_emp($val);
			foreach($feedopt_giver as $feedopt_givers){
			?>
			<tr height='25'  style='font:bold 10px Verdana, Geneva, sans-serif;' >
				<td  nowrap='nowrap' style='background-color:#F0F8FF;' align='left'>
					<?php 
					if(!empty($feedopt_givers['employee_id'])){
					?>
					<font><?php echo $feedopt_givers['employee_number']."-".$feedopt_givers['full_name'];?></font>
					<?php 
					} 
					?>
				</td>
				<?php 
				$total=$completed=$inprocess=$not=0;
				foreach($employee_id as $ky=>$fgf){
					if(in_array($val,$fgf)){
						$opt=UlsAssessmentFeedEmployees::get_feed_giver_assessment_detail_emp($_REQUEST['id'],$ky);
						if(count($opt)>0){
							$total+= count($opt);
							foreach($opt as $opts){
								$rating_user=UlsFeedbackEmployeeRating::giver_status($opts['group_id'],$val,$ky);
								if(!empty($rating_user['status'])){
									if($rating_user['status']=='C'){
										$completed+=1;
									}
									elseif($rating_user['status']=='W'){
										$inprocess+=1;
									}
									else{
										$not+=1;
									}
								}
								else{
									$not+=1;
								}
							}
						}
						else{
							
						}
					}
				}
				?>
				<td><?php echo $total;  ?></td>
				<td><?php echo $completed;  ?></td>
				<td><?php echo $inprocess;?></td>
				<td><?php echo $not;?></td>
				<?php 
				foreach($employee_id as $ky=>$fgf){
					if(in_array($val,$fgf)){
						$opt=UlsAssessmentFeedEmployees::get_feed_giver_assessment_detail_emp($_REQUEST['id'],$ky);
						if(count($opt)>0){
							foreach($opt as $opts){
								$rating_user=UlsFeedbackEmployeeRating::giver_status($opts['group_id'],$val,$ky);
								if(!empty($rating_user['status'])){
									if($rating_user['status']=='C'){
										$col12="color:#00cc33";
									}
									elseif($rating_user['status']=='W'){
										$col12="color:#ff6600";
									}
									else{
										$col12="color:#000";
									}	
								}
								else{
									$col12="color:#000";
								}
								if(!empty($ky)){
									$asd=UlsEmployeeMaster::fetch_tna_emp($ky);
								?>
									<td style='<?php echo $col12;?>'><?php echo $asd['employee_number']."-".$asd['full_name'];?></td>
								<?php 
								}
							}
						}
						else{
							if(!empty($ky)){
								$asd=UlsEmployeeMaster::fetch_tna_emp($ky);
							?>
								<td><?php echo $asd['employee_number']."-".$asd['full_name'];?></td>
							<?php
							}
						}
					}
				}
				?>
			</tr>
			<?php 
			}
		}
		?>
	</table> 
	
	

</div>

	<br />
	<div align='right' style='padding:10px;'>
		
		<a class='btn btn-sm btn-success' href="http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."&ExportType=export-to-excel"; ?>">Export To Excel</a>
	</div>