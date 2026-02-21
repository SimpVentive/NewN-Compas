
<div id='idexceltable' >
	<br />
	<div id='navbar' class='navbar navbar-default navbar-fixed-top'>
	<div align='center'> <span><b>Assessment Interview Report</b> </span></div><br/>
	<span style='float:right; padding-right:30px;'>Date & Time : <b><?php echo  date('d-m-Y h:i:s');?></b></span>
	</div><br />
	<?php
	
	if(!isset($_REQUEST['ExportType'])){ ?>
		<div align='right' style='padding:10px;'>
			<input type='button' onclick="htmltopdf('idexceltable','<?php echo (isset($_REQUEST['report_name']))?$_REQUEST['report_name']:''?>')" name='btnpdfExport' class='btn btn-sm btn-success'  id='btnpdfExport' value='Generate Pdf' >					
			<!--<input type='button' name='btnExport' class='btn btn-sm btn-success' id='btnExport' value='Export to excel' onclick="downloadexcel('employeesTable','<?php echo (isset($_REQUEST['report_name']))?$_REQUEST['report_name']:''?>')">-->
			<a class='btn btn-sm btn-success' href="https://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."&ExportType=export-to-excel"; ?>">Export To Excel</a>
		</div>
		<?php 		
	}?>
	<?php
	
	$ass_type=array();
	
	?>
	<table id='employeesTable' style='widtd:100%' align='center' class='table table-striped table-bordered table-hover'>
		
	</table>
	<?php $total_count=(count($comp_data)*5); ?>
	<table id='employeesTable' style='widtd:100%' align='center' class='table table-striped table-bordered table-hover'>
		<thead>
			<tr>
			   <td rowspan="7">S.No</td>
			   <td rowspan="7">Employee Number</td>
			   <td rowspan="7">Employee Name</td>
			   <td rowspan="7">Department</td>
			   <td rowspan="7">Location</td>
			   <td rowspan="7">Assessment Position</td>
			   <td rowspan="7">Assessor Name</td>
			   <td nowrap colspan=2>Assessment Methods</td>
				<th colspan="<?php echo $total_count; ?>">Competency</th>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<?php 
				foreach($comp_data as $comp_datas){
				?>
					<th colspan="8"><?php echo $comp_datas['comp_def_name']; ?></th>
					
				<?php 
				}
				?>
			</tr> 
			<tr>
				
				<td></td>
				<td></td>
				
				<?php 
				for ($x = 1; $x <= count($comp_data); $x++) {
				?>
					<th>Required Level</th>
					<th colspan="3">1st Assessment Score</th>
					<th>Competency Overall Score</th>
					<th colspan="2">2nd Assessment Score</th>
					<th>Competency Overall Score</th>
				<?php } ?>
			</tr>
			<tr>
				
				<td>TEST</td>
				<td>INTERVIEW</td>
				
				<?php 
				for ($x = 1; $x <= count($comp_data); $x++) {
				?>
					<th></th>
					<th>Test</th>
					<th>Inbasket</th>
					<th>Casestudy</th>
					<th></th>
					<th>Test</th>
					<th>interview</th>
					<th></th>
				
				<?php } ?>
			</tr>
		</thead>
		<tbody>
		<?php
		$keyss=1;
		foreach($emp_details as $emp_detail){
			$ass_id=$emp_detail['assessment_id'];
			$pos_id=$emp_detail['position_id'];
			$emp_id=$emp_detail['employee_id'];
			$assessor_id=$emp_detail['assessor_id'];
			
			$emp_pre_report=UlsAssessmentEmployees::get_assessment_employees_prereport($emp_id,$ass_id,$pos_id);
			$ass_test=UlsAssessmentTest::assessment_test_report($ass_id,$pos_id);
			
		?>
		<tr>
			<td><?php echo ($keyss);?></td>
			<td><?php echo $emp_detail['employee_number'];?></td>
			<td><?php echo $emp_detail['full_name'];?></td>
			<td><?php echo $emp_detail['org_name'];?></td>
			<td><?php echo $emp_detail['location_name'];?></td>
			<td><?php echo $emp_detail['position_name'];?></td>
			<td><?php echo $emp_detail['assessor_name'];?></td>
			<?php 
			foreach($ass_test as $ass_tests){
				if($ass_tests['assessment_type']=='TEST'){
					$asstests='TEST';
					$over_all_test=UlsAssessmentAssessorRating::get_ass_rating_assessor_report($ass_id,$pos_id,$emp_id,$assessor_id,$asstests);
					?>
					<td><?php echo $over_all_test['rating_name_scale'];?></td>
				<?php
				}
				elseif($ass_tests['assessment_type']=='INTERVIEW'){
					$asstests='INTERVIEW';
					$over_all_test=UlsAssessmentAssessorRating::get_ass_rating_assessor_report($ass_id,$pos_id,$emp_id,$assessor_id,$asstests);
					?>
					<td><?php echo $over_all_test['rating_name_scale'];?></td>
				<?php
				}
			}
			?>
			<?php
			foreach($comp_data as $comp_datas){
			?>
			<td><?php echo !empty($comp_datas['scale_name'])?$comp_datas['scale_name']:"-";?></td>
			<td>
			<?php
			$ass_comp_test=UlsAssessmentReport::admin_position_assessed_competency_level_test($emp_pre_report['assessment_id'],$pos_id,$comp_datas['comp_def_id'],$emp_id,$comp_datas['scale_id']);
			echo !empty($ass_comp_test['ass_ave'])?round($ass_comp_test['ass_ave'],2):"-";
			?>
			</td>
			<td>
			<?php
			$ass_comp_inbasket=UlsAssessmentReport::admin_position_assessed_competency_level_inbasket($emp_pre_report['assessment_id'],$pos_id,$comp_datas['comp_def_id'],$emp_id,$comp_datas['scale_id']);
			echo !empty($ass_comp_inbasket['ass_ave'])?round($ass_comp_inbasket['ass_ave'],2):"-";
			?>
			</td>
			<td>
			<?php
			$ass_comp_case=UlsAssessmentReport::admin_position_assessed_competency_level_case($emp_pre_report['assessment_id'],$pos_id,$comp_datas['comp_def_id'],$emp_id,$comp_datas['scale_id']);
			echo !empty($ass_comp_case['ass_ave'])?round($ass_comp_case['ass_ave'],2):"-";
			?>
			</td>
			<td>
			<?php
			$ass_final_score=UlsAssessmentEmployeeFinalReport::get_assessment_employees_report($emp_pre_report['assessment_id'],$pos_id,$emp_id,$comp_datas['comp_def_id'],$comp_datas['scale_id']);
			echo !empty($ass_final_score['assessed_value'])?$ass_final_score['assessed_value']:"-";
			?>
			</td>
			<td><?php
			$asscomptest=UlsAssessmentReport::admin_position_assessed_competency_level_test($ass_id,$pos_id,$comp_datas['comp_def_id'],$emp_id,$comp_datas['scale_id']);
			echo !empty($asscomptest['ass_ave'])?round($asscomptest['ass_ave'],2):"-";
			?></td>
			<td>
			<?php
			$asscompinterview=UlsAssessmentReport::admin_position_assessed_competency_level_interview($ass_id,$pos_id,$comp_datas['comp_def_id'],$emp_id,$comp_datas['scale_id']);
			echo !empty($asscompinterview['ass_ave'])?round($asscompinterview['ass_ave'],2):"-";
			?>
			</td>
			<td>
			<?php
			$assfinalscore=UlsAssessmentEmployeeFinalReport::get_assessment_employees_report($ass_id,$pos_id,$emp_id,$comp_datas['comp_def_id'],$comp_datas['scale_id']);
			echo !empty($assfinalscore['assessed_value'])?$assfinalscore['assessed_value']:"-";
			?>
			</td>
			<?php
			}
			?>
		</tr>
		<?php
			$keyss++;
		}
		?>
		</tbody>
	</table>
	<?php 
	 ?>
	</div><br /><br />
	
			