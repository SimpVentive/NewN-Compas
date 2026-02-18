<br/>
<div id='idexceltable'>
	<br/>
	<div id='navbar' class='navbar navbar-default navbar-fixed-top'>
			
		<div align='center'> <span><b>Assessment Employee Competency Test Results</b> </span></div>
		
		<br/>
		
		
		<span style='float:right; padding-right:30px;'>Date & Time : <b><?php echo date('d-m-Y h:i:s');?></b></span>
	</div>
	<br/>
	<table id='repheader' style='width:99%' align='center' class='table table-striped table-bordered table-hover'>
		<thead>
			<tr>
				<td nowrap>S.No</td>
				<td nowrap>Employee Name</td>
				<td nowrap>Position Name</td>
				<td nowrap>Competency Name</td>
				<td nowrap>Required level</td>
				<td nowrap>Criticality</td>
				<td nowrap># of Questions</td>
				<td nowrap>Unanswered Questions</td>
				<td nowrap># Answered right</td>
				<td nowrap># Answered wrong</td>
				<td nowrap>%</td>
			</tr>
			<?php
			$temp=$temp1=$temp_count="";
			$key=$key1=1;
			$total_per_count=$total_correct_count=$total_count=$total_blank_count=$total_wrong_count=0;
			foreach($comp_details as $comp_detail){
				$test_details=UlsAssessmentTest::get_ass_position($comp_detail['assessment_id'],$comp_detail['position_id'],'TEST');
				$total_ques=UlsAssessmentTestQuestions::get_question_ids($test_details['assess_test_id'],$comp_detail['comp_def_id']);
				$cor_count=UlsUtestResponsesAssessment::question_count_correct($total_ques['question_ids'],$comp_detail['employee_id'],$test_details['assess_test_id'],$comp_detail['assessment_id']);
				$blank_count=UlsUtestResponsesAssessment::question_count_leftblank($total_ques['question_ids'],$comp_detail['employee_id'],$test_details['assess_test_id'],$comp_detail['assessment_id']);
				
				$wrong_questions=($total_ques['te_count']-$blank_count['l_count']-$cor_count['c_count']);
				$total_correct_count+=$cor_count['c_count'];
				$total_blank_count+=$blank_count['l_count'];
				$total_wrong_count+=$wrong_questions;
				$total_count+=@count($total_ques['te_count']);
				$total_question_one=($blank_count['l_count'])>0?(($total_ques['te_count'])-$blank_count['l_count']):$total_ques['te_count'];
					?>
					<tr>
						<td><?php 
						if($temp1!=$comp_detail['employee_number']){
						echo $key1;
						}
						?></td>
						<td><?php
						if($temp1!=$comp_detail['employee_number']){
							$key1++;
							echo $comp_detail['employee_number']."-".$comp_detail['full_name'];
							$temp1=$comp_detail['employee_number'];
							
						} ?></td>
						<td><?php
						if($temp!=$comp_detail['position_name']){
							$key++;
							echo $comp_detail['position_name'];
							$temp=$comp_detail['position_name'];
							
						} 
						
						?></td>
						
						<td><?php echo $comp_detail['comp_def_name']; ?></td>
						<td><?php echo $comp_detail['scale_name']; ?></td>
						<td><?php echo $comp_detail['comp_cri_name']; ?></td>
						<td><?php echo $total_ques['te_count']; ?></td>
						<td><?php echo !empty($blank_count['l_count'])?$blank_count['l_count']:0; ?></td>
						<td><?php echo !empty($cor_count['c_count'])?$cor_count['c_count']:0; ?></td>
						<td><?php echo $wrong_questions; ?></td>
						<td><?php 
						
						$corr=!empty($cor_count['c_count'])?$cor_count['c_count']:0;
						$to=$total_question_one;
						echo $corr>0?(round((($corr/$to)*100),2)):0; ?>%</td>
					</tr>
			<?php
				
			}
			?>
		</thead>
		<tbody>
		
		</tbody>
	</table> 
	
	

</div>

	<br />
	<div align='right' style='padding:10px;'>
		
		<a class='btn btn-sm btn-success' href="http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."&ExportType=export-to-excel"; ?>">Export To Excel</a>
	</div>