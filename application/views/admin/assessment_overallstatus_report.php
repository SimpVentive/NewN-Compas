
<div id='idexceltable' >
	<br />
	<div id='navbar' class='navbar navbar-default navbar-fixed-top'>
	<div align='center'> <span><b>Assessment Assessor Overall Report</b> </span></div><br/>
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
	
	$count_case=$count_in=$count_beh=$count_test=$count_interview="";
	$status_test=$status_inb=$status_case=$status_beh="";
	$ass_type=array();
	
	?>
	<table id='employeesTable' style='widtd:100%' align='center' class='table table-striped table-bordered table-hover'>
		
	</table>
	
	<table id='employeesTable' style='widtd:100%' align='center' class='table table-striped table-bordered table-hover'>
		<thead>
			<tr>
			   <td nowrap>S.No</td>
			  
			   <td nowrap>Employee Number</td>
			   <td nowrap>Employee Name</td>
			   <td nowrap>Department</td>
			   <td nowrap>Location</td>
			   <!--<td nowrap>Position</td>-->
			   <td nowrap>Assessment Position</td>
			    <td nowrap>Assessor Name</td>
			   <td nowrap colspan=2>Assessment Methods</td>
			   <!--<td nowrap>Final Status</td>-->
			</tr>
			
			<tr>
				<td nowrap></td>
				<td nowrap></td>
				<td nowrap></td>
				<td nowrap></td>
				<td nowrap></td>
				<td nowrap></td>
				<td nowrap></td>
				<td>TEST</td>
				<td>INTERVIEW</td>
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
			$ass_test=UlsAssessmentTest::assessment_test_report($ass_id,$pos_id);
		?>
		<tr>
			<td><?php echo ($keyss);?></td>
			<td><?php echo $emp_detail['employee_number'];?></td>
			<td><?php echo $emp_detail['full_name'];?></td>
			<td><?php echo $emp_detail['org_name'];?></td>
			<td><?php echo $emp_detail['location_name'];?></td>
			<td><?php echo $emp_detail['position_name'];?></td>
			<td><?php echo $emp_detail['assessor_name'];;?></td>
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
	
			