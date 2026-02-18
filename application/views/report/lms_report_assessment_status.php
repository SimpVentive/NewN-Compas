<?php 
$reportname=Doctrine_Query::Create()->from('UlsReportDefaultReportTypes')->where("default_repot_id=".$type)->fetchOne();
?>
<div id='idexceltable' >
	<br />
	<div id='navbar' class='navbar navbar-default navbar-fixed-top'>
	<div align='center'> <span><b><?php echo $reportname['default_report_name'];?></b> </span></div><br/>
	<span style='padding-left:30px;'>User Name : <b><?php echo ucwords($username['full_name']);?></b> </span><span style='float:right; padding-right:30px;'>Date & Time : <b><?php echo  date('d-m-Y h:i:s');?></b></span>
	</div><br />
	<br />
			<?php
			if(count($employee)>0 && !isset($_REQUEST['ExportType'])){ ?>
				<div align='right' style='padding:10px;'>
					<input type='button' onclick="htmltopdf('idexceltable','<?php echo (isset($_REQUEST['report_name']))?$_REQUEST['report_name']:''?>')" name='btnpdfExport' class='btn btn-sm btn-success'  id='btnpdfExport' value='Generate Pdf' >					
					<!--<input type='button' name='btnExport' class='btn btn-sm btn-success' id='btnExport' value='Export to excel' onclick="downloadexcel('employeesTable','<?php echo (isset($_REQUEST['report_name']))?$_REQUEST['report_name']:''?>')">-->
					<a class='btn btn-sm btn-success' href="https://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."&ExportType=export-to-excel"; ?>">Export To Excel</a>
				</div>
				<?php 		
			}?>
	<table id='employeesTable' style='widtd:100%' align='center' class='table table-striped table-bordered table-hover'>
	<thead>
		<?php
		$count_case=$count_in=$count_beh=$count_test=$count_fish=$count_feed="";
		foreach($ass_test as $ass_tests){
			$ass_type[]=$ass_tests['assessment_type'];
			if($ass_tests['assessment_type']=='CASE_STUDY'){
				$count_case=count($test_casestudy);
			}
			elseif($ass_tests['assessment_type']=='INBASKET'){
				$count_in=count($test_inbasket);
				
			}
			elseif($ass_tests['assessment_type']=='BEHAVORIAL_INSTRUMENT'){
				$count_beh=count($test_beh);
				
			}
			elseif($ass_tests['assessment_type']=='FISHBONE'){
				$count_fish=count($test_fishbone);
				
			}
			elseif($ass_tests['assessment_type']=='FEEDBACK'){
				$count_feed=count($test_feedback);
				
			}
			else{
				$count_test=1;
			}
		}
		$count_td=@($count_test+$count_case+$count_in+$count_beh+$count_fish+$count_feed);
		?>
		<tr>
		   <td nowrap>S.No</td>
		   <td nowrap>Employee Code</td>
		   <td nowrap>Employee Name</td>
		   <td nowrap>Grade Code</td>
		   <td nowrap>Designation</td>
		   <td nowrap>Grade</td>
		   <td nowrap>Location</td>
		   <td nowrap>Business unit</td>
		   <td nowrap>Department</td>
		   <td nowrap>Mo. Number</td>
		   <td nowrap>Mail ID </td>
		   <td nowrap>Assessment Position</td>
		   <td nowrap colspan=<?php echo $count_td; ?>>Assessment Methods</td>
		   <!--<td colspan=<?php echo (count($ass_emp)*2); ?> nowrap>Assessor Status</td>-->
		   </tr>
		   <tr>
				<td nowrap></td>
				<td nowrap></td>
				<td nowrap></td>
				<td nowrap></td>
				<td nowrap></td>
				<td nowrap></td>
				<td nowrap></td>
				<td nowrap></td>
				<td nowrap></td>
				<td nowrap></td>
				<td nowrap></td>
				<td nowrap></td>
				<?php
				foreach($ass_test as $ass_tests){
					$ass_type[]=$ass_tests['assessment_type'];
					if($ass_tests['assessment_type']=='CASE_STUDY'){
						foreach($test_casestudy as $key=>$test_casestudys){
							$casestudy=$test_casestudys['assessment_type']."-".($key+1);
							?>
								<td><?php echo $casestudy;?></td>
							<?php
						}
					}
					elseif($ass_tests['assessment_type']=='INBASKET'){
						foreach($test_inbasket as $key=>$test_inbaskets){
							$inbasket=$test_inbaskets['assessment_type']."-".($key+1);
						?>
							<td><?php echo $inbasket;?></td>
						<?php
						}
					}
					elseif($ass_tests['assessment_type']=='FISHBONE'){
						foreach($test_fishbone as $key=>$test_fishbones){
							$fishbone=$test_fishbones['assessment_type']."-".($key+1);
						?>
							<td><?php echo $fishbone;?></td>
						<?php
						}
					}
					elseif($ass_tests['assessment_type']=='BEHAVORIAL_INSTRUMENT'){
						foreach($test_beh as $key=>$test_behs){
							//$test_behs['assessment_type']."-".
							$beh_int=$test_behs['instrument_name'];
						?>
							<td><?php echo $beh_int;?></td>
						<?php
						}
					}
					elseif($ass_tests['assessment_type']=='FEEDBACK'){
						foreach($test_feedback as $key=>$test_feedbacks){
							$feedback_int=$test_feedbacks['assessment_type']."-".($key+1);
						?>
							<td><?php echo $feedback_int;?></td>
						<?php
						}
					}
					else{
						?>
						<td><?php echo $ass_tests['assessment_type']; ?></td>
						<?php
					}
				}
				/* foreach($ass_emp as $ass_emps){ */
					?>
				
				<!--<td>Assessor Name</td>
				<td>Status</td>-->
				<?php /* } */ ?>
				
				
			</tr>
			</thead>
			<tbody>
			<?php
			$status_test=$status_inb=$status_case=$status_beh="";
			foreach($employee as $key=>$employees){
				$test_emp=UlsMenu::callpdorow("SELECT count(*) as ass_test,`status`,`employee_id`,`event_id`,`assessment_id`,`attempt_status` FROM `uls_utest_attempts_assessment` where `assessment_id`=".$employees['assessment_id']." and test_type='TEST' and `employee_id`=".$employees['employee_id']." and event_id=".$employees['position_id']);
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
					<td><?php echo $employees['office_number'];?></td>
					<td><?php echo $employees['email'];?></td>
					
					<td><?php echo $employees['ass_position_name'];?></td>
					<?php
					$status_beh="";
					foreach($ass_test as $asstests){
						if($asstests['assessment_type']=='TEST'){
							$status_test=0;
							$test_data=UlsAssessmentTest::get_ass_position_test($employees['assessment_id'],$employees['position_id'],'TEST');
							$test_emp=UlsMenu::callpdorow("SELECT count(*) as ass_test,`status`,`employee_id`,`event_id`,`assessment_id`,`attempt_status` FROM `uls_utest_attempts_assessment` where `assessment_id`=".$employees['assessment_id']." and test_type='TEST' and `employee_id`=".$employees['employee_id']." and event_id=".$test_data['assess_test_id']." and test_id=".$test_data['test_id']);
							$status_test=($test_emp['ass_test']==0)?1:0;
						?>
						<td><?php echo (($test_emp['ass_test']==0)?"Not Started":"Completed");?></td>
						<?php
						}
						elseif($asstests['assessment_type']=='INBASKET'){
							$status_inb=0;
							$test_inbasket_status=UlsAssessmentTestInbasket::viewinbasket_count_report_status($employees['assessment_id'],$employees['position_id']);
							foreach($test_inbasket_status as $key=>$test_inbasketss){
								$inb_emp=UlsMenu::callpdorow("SELECT count(*) as inbasket_test,`status`,`employee_id`,`event_id`,`assessment_id`,`attempt_status` FROM `uls_utest_attempts_assessment` where `assessment_id`=".$employees['assessment_id']." and test_type='INBASKET' and `employee_id`=".$employees['employee_id']." and event_id=".$test_inbasketss['assess_test_id']." and test_id=".$test_inbasketss['test_id']);
								//$status_inb=($inb_emp['inbasket_test']==0)?1:0;
								if($inb_emp['inbasket_test']==0){
									$status_inb=1;
								}
								else{
									if($status_inb==1){
										$status_inb=1;
									}
									else{
										$status_inb=0;
									}
									
								}
								?>
								<td><?php echo (($inb_emp['inbasket_test']==0)?"Not Started":"Completed");?></td>
								<?php
							}
						}
						elseif($asstests['assessment_type']=='FISHBONE'){
							$status_fishbone=0;
							foreach($test_fishbone as $key=>$test_fishbones){
								
								$fish_emp=UlsMenu::callpdorow("SELECT count(*) as fishbone_test,`status`,`employee_id`,`event_id`,`assessment_id`,`attempt_status` FROM `uls_utest_attempts_assessment` where `assessment_id`=".$employees['assessment_id']." and test_type='FISHBONE' and `employee_id`=".$employees['employee_id']." and event_id=".$test_fishbones['assess_test_id']." and test_id=".$test_fishbones['test_id']);
								//$status_inb=($inb_emp['inbasket_test']==0)?1:0;
								if($fish_emp['fishbone_test']==0){
									$status_fishbone=1;
								}
								else{
									if($status_fishbone==1){
										$status_fishbone=1;
									}
									else{
										$status_fishbone=0;
									}
									
								}
								?>
								<td><?php echo (($fish_emp['fishbone_test']==0)?"Not Started":"Completed");?></td>
								<?php
							}
						}
						elseif($asstests['assessment_type']=='CASE_STUDY'){
							$status_case=0;
							$test_casestudy_status=UlsAssessmentTestCasestudy::viewcasestudy_count_report($employees['assessment_id'],$employees['position_id']);
							foreach($test_casestudy_status as $key=>$test_casestudyss){
								$case_emp=UlsMenu::callpdorow("SELECT count(*) as case_test,`status`,`employee_id`,`event_id`,`assessment_id`,`attempt_status` FROM `uls_utest_attempts_assessment` where `assessment_id`=".$employees['assessment_id']." and test_type='CASE_STUDY' and `employee_id`=".$employees['employee_id']." and event_id=".$test_casestudyss['assess_test_id']." and test_id=".$test_casestudyss['test_id']);
								//$status_case=($case_emp['case_test']==0)?1:0;
								if($case_emp['case_test']==0){
									$status_case=1;
								}
								else{
									if($status_case==1){
										$status_case=1;
									}
									else{
										$status_case=0;
									}
									
								}
								?>
								<td><?php echo (($case_emp['case_test']==0)?"Not Started":"Completed");?></td>
								<?php
							}
						}
						elseif($asstests['assessment_type']=='BEHAVORIAL_INSTRUMENT'){
							$status_beh=0;
							foreach($test_beh as $key=>$test_behs){
								//echo $test_behs['assess_test_id'];
								$beh_emp=UlsMenu::callpdorow("SELECT count(*) as beh_test,`status`,`employee_id`,`event_id`,`assessment_id`,`attempt_status` FROM `uls_bei_attempts_assessment` where `assessment_id`=".$employees['assessment_id']." and test_type='BEHAVORIAL_INSTRUMENT' and `employee_id`=".$employees['employee_id']." and event_id=".$test_behs['assess_test_id']." and instrument_id=".$test_behs['instrument_id']);
								//$status_beh=($beh_emp['beh_test']==0)?($status_beh==0)?1:1:0;
								if($beh_emp['beh_test']==0){
									$status_beh=1;
								}
								else{
									if($status_beh==1){
										$status_beh=1;
									}
									else{
										$status_beh=0;
									}
									
								}
								?>
								<td><?php echo (($beh_emp['beh_test']==0)?"Not Started":"Completed");?></td>
								<?php
							}
						}
						elseif($asstests['assessment_type']=='INTERVIEW'){
						?>
							<td></td>
						<?php
						}
						elseif($asstests['assessment_type']=='FEEDBACK'){
							foreach($test_feedback as $key=>$test_feedbacks){
								$feed_emp=UlsMenu::callpdorow("SELECT * FROM `uls_feedback_employee_rating` where `assessment_id`=".$employees['assessment_id']." and `employee_id`=".$employees['employee_id']." and giver_id=".$employees['employee_id']." and ass_test_id=".$test_feedbacks['assess_test_id']." and ques_id=".$test_feedbacks['ques_id']);
								//$status_inb=($inb_emp['inbasket_test']==0)?1:0;
								if(empty($feed_emp['status'])){
									$status_feed="Not Started";
								}
								elseif($feed_emp['status']=='C'){
									$status_feed="Completed";
								}
								elseif($feed_emp['status']=='W'){
									$status_feed="In-Process";
								}
								elseif($feed_emp['rater_value']=='NULL'){
									$status_feed="In-Process";
								}
								?>
								<td><?php echo $status_feed;?></td>
							<?php
							}
						}
					}
					//$status_test==1 || $status_inb==1 || $status_case==1 || 
					$final_status=($status_beh==1)?"In Process":"Completed";
					
					
					/* foreach($ass_emp as $ass_emps){
						
						$assemp=UlsMenu::callpdorow("SELECT a.*,b.assessor_name,count(ar.ass_rating_id) as rating_ass FROM `uls_assessment_report_final` a
						left join(SELECT `ass_rating_id`,`assessment_id`,`position_id`,`employee_id`,`assessor_id` FROM `uls_assessment_assessor_rating`) ar on ar.assessment_id=a.assessment_id and ar.position_id=a.position_id and ar.employee_id=a.employee_id and ar.assessor_id=a.assessor_id
						left join(SELECT `assessor_id`,`assessor_name` FROM `uls_assessor_master`) b on b.assessor_id=a.assessor_id
						where a.`assessment_id`=".$employees['assessment_id']." and a.assessor_id=".$ass_emps['assessor_id']." and a.`employee_id`=".$employees['employee_id']." and a.position_id=".$_REQUEST['pos_id']);
						if(!empty($assemp['final_id'])){
							
						?> 
						<td><?php echo $assemp['assessor_name']; ?></td>
						<td><?php echo (($assemp['status']=='A')?"Completed":"In-Process"); ?></td>
						<?php
						}
						else{
						?>
						<td colspan="2">Not Mapped</td>
						
						<?php
						}
					} */ ?> 
					
					
					
				</tr>
			<?php			 
			}			 
			?>
			</tbody>
		   </table></div><br />