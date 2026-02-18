<?php 
$reportname=Doctrine_Query::Create()->from('UlsReportDefaultReportTypes')->where("default_repot_id=".$type)->fetchOne();
?>
<div id='idexceltable' >
	<br />
	<div id='navbar' class='navbar navbar-default navbar-fixed-top'>
	<div align='center'> <span><b>Assessment Assessor Report for <?php echo $ass_name['assessment_name']; ?></b> </span></div><br/>
	<?php
	if(isset($assessor_name['assessor_name'])){
	?>
	<span style='padding-left:30px;'>Assessor Name : <b><?php echo ucwords($assessor_name['assessor_name']);?></b> </span>
	<?php
	}	
	?><span style='float:right; padding-right:30px;'>Date & Time : <b><?php echo  date('d-m-Y h:i:s');?></b></span>
	</div><br />
	<?php
	$position=UlsAssessmentPositionAssessor::getassessorassessmentpositions($ass_id,$assessorid);
	$count_case=$count_in=$count_beh=$count_test=$count_interview="";
	$status_test=$status_inb=$status_case=$status_beh="";
	$ass_type=array();
	foreach($position as $positions){
		$pos_id=$positions['position_id'];
		$assessor_id=$positions['assessor_id'];
	?>
	<label><?php echo $positions['position_name'];?></label><br>
	<table id='employeesTable' style='widtd:100%' align='center' class='table table-striped table-bordered table-hover'>
		<thead>
			<?php
			$ass_rights=UlsAssessmentPositionAssessor::get_assessor_rights($ass_id,$assessor_id,$pos_id);
			$ass_per=($ass_rights['assessor_per']=='Y')?$ass_rights['emp_ids']:"";
			$employee=UlsAssessmentEmployees::get_status_assessmentreport($ass_id,$asstype,$pos_id,$ass_per);
			$ass_test=UlsAssessmentTest::assessment_test_report($ass_id,$pos_id);
			$test_beh=UlsAssessmentTestBehavorialInst::viewbehavorial_count($ass_id,$pos_id);
			$test_casestudy=UlsAssessmentTestCasestudy::viewcasestudy_count_report($ass_id,$pos_id);
			$test_inbasket=UlsAssessmentTestInbasket::viewinbasket_count_report($ass_id,$pos_id);
			foreach($ass_test as $ass_tests){
				$ass_type[]=$ass_tests['assessment_type'];
				if($ass_tests['assessment_type']=='CASE_STUDY'){
					$count_case=count($test_casestudy);
				}
				elseif($ass_tests['assessment_type']=='INBASKET'){
					$count_in=count($test_inbasket);
					
				}
				/* elseif($ass_tests['assessment_type']=='BEHAVORIAL_INSTRUMENT'){
					$count_beh=count($test_beh);
					
				} */
				elseif($ass_tests['assessment_type']=='INTERVIEW'){
					$count_interview=1;
				}
				else{
					$count_test=1;
				}
			}
			//$count_beh+
			$count_td=@($count_test+$count_case+$count_in+$count_interview);
			?>
			<tr>
			   <td rowspan='7' nowrap>S.No</td>
			   <td rowspan='7' nowrap>Assessor Name</td>
			   <td rowspan='7' nowrap>Employee Number</td>
			   <td rowspan='7' nowrap>Employee Name</td>
			   <td rowspan='7' nowrap>Department</td>
			   <td rowspan='7' nowrap>Position</td>
			   <td rowspan='7' nowrap>Assessment Position</td>
			   <td nowrap colspan=<?php echo $count_td; ?>>Assessment Methods</td>
			   <!--<td nowrap>Final Status</td>-->
			</tr>
			<tr>
				<?php
				foreach($ass_test as $ass_tests){
					$ass_type[]=$ass_tests['assessment_type'];
					if($ass_tests['assessment_type']=='TEST'){
					?>
						<td><?php echo 'Test';?></td>
					<?php
					}
					elseif($ass_tests['assessment_type']=='INBASKET'){
						foreach($test_inbasket as $key=>$test_inbaskets){
							$inbasket=$test_inbaskets['assessment_type']."-".($key+1);
						?>
							<td><?php echo $inbasket;?></td>
						<?php
						}
					}
					elseif($ass_tests['assessment_type']=='CASE_STUDY'){
						foreach($test_casestudy as $key=>$test_casestudys){
							$casestudy=$test_casestudys['assessment_type']."-".($key+1);
							?>
								<td><?php echo $casestudy;?></td>
							<?php
						}
					}
					
					/* elseif($ass_tests['assessment_type']=='BEHAVORIAL_INSTRUMENT'){
						foreach($test_beh as $key=>$test_behs){
							//$test_behs['assessment_type']."-".
							$beh_int=$test_behs['instrument_name'];
						?>
							<td><?php echo $beh_int;?></td>
						<?php
						}
					} */
					elseif($ass_tests['assessment_type']=='INTERVIEW'){
					?>
						<td><?php echo 'Interview';?></td>
					<?php
					}
				}
				?>
				
				<!--<td></td>-->
			</tr>  
		</thead>
		<tbody>
		<?php
		foreach($employee as $key=>$employees){
		?>
			<tr>
				<td><?php echo ($key+1);?></td>
				<td><?php echo $positions['assessor_name'];;?></td>
				<td><?php echo $employees['employee_number'];?></td>
				<td><?php echo $employees['full_name'];?></td>
				<td><?php echo $employees['org_name'];?></td>
				<td><?php echo $employees['position_name'];?></td>
				<td><?php echo $employees['ass_position_name'];?></td>
				<?php
					$status_beh="";
					$status_final=0;
					$ass_final=UlsAssessmentReportFinal::assessment_assessor_final($ass_id,$pos_id,$employees['employee_id'],$assessor_id);
					$status_final=!empty($ass_final['final_id'])?1:0;
					
					foreach($ass_test as $ass_tests){
						if($ass_tests['assessment_type']=='TEST'){
							$asstests='TEST';
							$test_emp=UlsAssessmentReportBytype::summary_details_count_methods($ass_id,$asstests,$pos_id,$employees['employee_id'],$assessor_id);
							
						?>
						<?php //echo ($status_final==0)?(((count($test_emp)==0)?"Not Started":"In-process")):"Completed";?>
						<td><?php echo ((count($test_emp)==0)?"Not Started":"Completed");?></td>
						<?php
						}
						elseif($ass_tests['assessment_type']=='INBASKET'){
							$status_inb=0;
							foreach($test_inbasket as $key=>$test_inbaskets){
								$asstests='INBASKET';
								$inb_emp=UlsAssessmentReportBytype::summary_details_count_inbasket($ass_id,$asstests,$pos_id,$employees['employee_id'],$assessor_id,$test_inbaskets['inb_assess_test_id']);
								
								?>
								<?php //echo ($status_final==0)?((count($inb_emp)==0)?"Not Started":"In-process"):"Completed";?>
								<td><?php echo ((count($inb_emp)==0)?"Not Started":"Completed");?></td>
								<?php
							}
						}
						elseif($ass_tests['assessment_type']=='CASE_STUDY'){
							$status_case=0;
							foreach($test_casestudy as $key=>$test_casestudys){
								$asstests='CASE_STUDY';
								$case_emp=UlsAssessmentReportBytype::summary_details_count_casestudy($ass_id,$asstests,$pos_id,$employees['employee_id'],$assessor_id,$test_casestudys['case_assess_test_id']);
								
								?>
								<?php //echo ($status_final==0)?((count($case_emp)==0)?"Not Started":"In-process"):"Completed";?>
								<td><?php echo (count($case_emp)==0)?"Not Started":"Completed";?></td>
								<?php
							}
						}
						elseif($ass_tests['assessment_type']=='INTERVIEW'){
							$asstests='INTERVIEW';
							$case_emp=UlsAssessmentReportBytype::summary_details_count_methods($ass_id,$asstests,$pos_id,$employees['employee_id'],$assessor_id);
							
							?>
							<?php //echo ($status_final==0)?((count($case_emp)==0)?"Not Started":"In-process"):"Completed";?>
							<td><?php echo (count($case_emp)==0)?"Not Started":"Completed";?></td>
							<?php
						}
					?>
					<?php
					}
				?>
				<!--<td><?php echo !empty($ass_final['final_id'])?"Completed":"Not Started"; ?></td>-->
			</tr>
		<?php		
		}
		?>
		</tbody>
	</table>
	<?php 
	} ?>
	</div><br /><br />
	
			