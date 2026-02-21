
<div id='idexceltable'>

	<table class='tablestyled bgWhite' style="width:100%" border='1'>
		<tr align='center' style='background-color:#436DAC; color:#fff;'>
			<th align='center' style="padding:10px;text-align:center;">Employee Name</th>
			<th align='center' style="padding:10px;text-align:center;">Employee Mobile</th>
			<th align='center' style="padding:10px;text-align:center;">Total No. of Rater</th>
			<th align='center' style="padding:10px;">Parameter name</th>
			<th align='center' style="padding:10px;text-align:center;">Self</th>
			<th align='center' style="padding:10px;text-align:center;">Manager</th>
			<th align='center' style="padding:10px;text-align:center;">Peers</th>
			<th align='center' style="padding:10px;text-align:center;">Subordinate</th>
			<th align='center' style="padding:10px;text-align:center;">Leadership Team</th>
			<th align='center' style="padding:10px;text-align:center;">Overall Rating</th>
		</tr>
		<?php
		if($grouping_user){
			?>
			<tr height='25'  style='font:bold 10px Verdana, Geneva, sans-serif;height:50px;' >
				<td  nowrap='nowrap' style='padding:10px;' align='left'><?php echo $grouping_user['employee_number'];?></td>
				<td bgcolor='' align='center' style="padding:10px;"><?php echo $grouping_user['full_name'];?></td>
				<?php
				$count_array=array();
				$self_rating=UlsFeedbackEmployeeRating::report_users($grouping_user['group_id'],$grouping_user['employee_id'],$grouping_user['assessment_id'],$grouping_user['ques_id']);
				if($self_rating>0){
					foreach($self_rating as $self_ratings){
						$a=$self_ratings['element_competency_id'];
						$selfsrs[$a]= round($self_ratings['avge'],1);
					}
				}
				/* echo "<pre>";
				print_r($selfsrs[$a]);	 */	
				if(!empty($grouping_user['manager_id'])){
					$mansrs=array();
					$manager=explode(',',$grouping_user['manager_id']);
					$count_manager=count($manager);
					array_push($count_array,$count_manager);
					$othavgman='select DISTINCT(element_competency_id) as id, avg(rater_value) as avg  from  uls_feedback_employee_rating where employee_id='.$grouping_user['employee_id'].' && group_id='.$grouping_user['group_id'].' and rater_value<>0 && giver_id in ('.$grouping_user['manager_id'].') group by element_competency_id';
					$othman=UlsMenu::callpdo($othavgman);
					if($othman>0){
						foreach($othman as $othmans){
							$a=$othmans['id'];
							$mansrs[$a]= round($othmans['avg'],1);
						}
					}						
				}
				
				if(!empty($grouping_user['peer_id'])){
					$peerssrs=array();
					$peer=explode(',',$grouping_user['peer_id']);
					$count_peer=count($peer);
					array_push($count_array,$count_peer);
					$othavgpeer='select DISTINCT(element_competency_id) as id, avg(rater_value) as avg  from  uls_feedback_employee_rating where employee_id='.$grouping_user['employee_id'].' && group_id='.$grouping_user['group_id'].' and rater_value<>0 && giver_id in ('.$grouping_user['peer_id'].') group by element_competency_id';
					$othpeer=UlsMenu::callpdo($othavgpeer);
					foreach($othpeer as $othpeers){
						$a=$othpeers['id'];
						$peerssrs[$a]= round($othpeers['avg'],1);
					}
				}
				if(!empty($grouping_user['sub_ordinates_id'])){
					$subsrs=array();
					$sub=explode(',',$grouping_user['sub_ordinates_id']);
					$count_sub=count($sub);
					array_push($count_array,$count_sub);
					$othavgsub='select DISTINCT(element_competency_id) as id, avg(rater_value) as avg  from  uls_feedback_employee_rating where employee_id='.$grouping_user['employee_id'].' && group_id='.$grouping_user['group_id'].' and rater_value<>0 && giver_id in ('.$grouping_user['sub_ordinates_id'].') group by element_competency_id';
					$othsub=UlsMenu::callpdo($othavgsub);
					foreach($othsub as $othsubs){
						$a=$othsubs['id'];
						$subsrs[$a]= round($othsubs['avg'],1);
					}
				}
				if(!empty($grouping_user['customer_id'])){
					$cussrs=array();
					$customer=explode(',',$grouping_user['customer_id']);
					$count_customer=count($customer);
					array_push($count_array,$count_customer);
					$othavgcus='select DISTINCT(element_competency_id) as id, avg(rater_value) as avg  from  uls_feedback_employee_rating where employee_id='.$grouping_user['employee_id'].' && group_id='.$grouping_user['group_id'].' and rater_value<>0 && giver_id in ('.$grouping_user['customer_id'].') group by element_competency_id';
					/* echo "<pre>";
					print_r($othavgcus); */
					$othcus=UlsMenu::callpdo($othavgcus);
					foreach($othcus as $othcuss){
						$a=$othcuss['id'];
						$cussrs[$a]= round($othcuss['avg'],1);
					}
				}
				
				$total_sum=array_sum($count_array);
				?>
				<td bgcolor='' align='center' style="padding:10px;" ><?php echo $total_sum;?></td>
				<?php
				
				$selfotheravge=UlsFeedbackEmployeeRating::report_users_dashboard($grouping_user['group_id'],$grouping_user['employee_id'],$grouping_user['assessment_id'],$grouping_user['ques_id']);
				$res=0;
				$self_average=array();
				$manager_average=array();
				$peer_average=array();
				$sub_average=array();
				$internal_average=array();
				$cus_average=array();
				$tot_average=array();
				foreach($selfotheravge as $selfotheravges){
					$a=$selfotheravges['element_competency_id'];
					$sd=array();
					if($res <> 0){
						?>
						<td bgcolor='' align='center' colspan='2' ></td><td bgcolor='' align='center'  ></td>
					<?php
					}
					else{
						
					}
					?>
					<td bgcolor='' align='left' style="padding:10px;"  ><?php echo $selfotheravges['comp_def_name'];?></td>
					<td bgcolor='' align='center' ><?php echo $selfsrs[$a];?></td>
					<?php
					$mannn="";$peerssrss="";$subsrss="";$ssrs="";$cussrss="";
					if(!empty($grouping_user['manager_id'])){
						$mannn=!empty($mansrs[$a])?$mansrs[$a]:0;
					}
					if(!empty($grouping_user['peer_id'])){
						$peerssrss=isset($peerssrs[$a])?$peerssrs[$a]:0;
					}
					if(!empty($grouping_user['sub_ordinates_id'])){
						$subsrss=isset($subsrs[$a])?$subsrs[$a]:0;
					}
					if(!empty($grouping_user['customer_id'])){
						$cussrss=isset($cussrs[$a])?$cussrs[$a]:0;
					}
					?>
					<td bgcolor='' align='center'><?php echo $mannn;?></td>
					<td bgcolor='' align='center'><?php echo $peerssrss;?></td>
					<td bgcolor='' align='center'><?php echo $subsrss;?></td>
					<td bgcolor='' align='center'><?php echo $cussrss;?></td>
					<td bgcolor='' align='center'><?php echo round($selfotheravges['avge'],2);?></td>
				</tr>
				<?php
					array_push($self_average,$selfsrs[$a]);
					array_push($manager_average,$mannn);
					array_push($peer_average,$peerssrss);
					array_push($sub_average,$subsrss);
					array_push($cus_average,$cussrss);
					array_push($tot_average,round($selfotheravges['avge'],2));
					$res++;
				}
				$total_self=array_sum($self_average)/$res;
				$total_manager=array_sum($manager_average)/$res;
				$total_peer=array_sum($peer_average)/$res;
				$total_sub=array_sum($sub_average)/$res;
				$total_cus=array_sum($cus_average)/$res;
				$total_avg=array_sum($tot_average)/$res;
				?>
				<tr style='background-color:#00ACD4;'>
					<td bgcolor='' align='center' style="padding:10px;" colspan='3'> Average </td>
					<td bgcolor='' align='center'>  </td>
					<td bgcolor='' align='center'><?php echo round($total_self,2);?></td>
					<td bgcolor='' align='center'><?php echo round($total_manager,2);?></td>
					<td bgcolor='' align='center'><?php echo round($total_peer,2);?></td>
					<td bgcolor='' align='center'><?php echo round($total_sub,2);?></td>
					<td bgcolor='' align='center'><?php echo round($total_cus,2);?></td>
					<td bgcolor='' align='center'><?php echo round($total_avg,2);?></td>
					</tr>
			<?php
			}
		?>
	</table> 

</div>
