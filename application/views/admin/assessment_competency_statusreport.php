<br/>
<div id='idexceltable'>
	<br/>
	<div id='navbar' class='navbar navbar-default navbar-fixed-top'>
			
		<div align='center'> <span><b>Question Report</b> </span></div>
		
		<br/>
		
		
		<span style='float:right; padding-right:30px;'>Date & Time : <b><?php echo date('d-m-Y h:i:s');?></b></span>
	</div>
	<br/>
	<table id='repheader' style='width:99%' align='center' class='table table-striped table-bordered table-hover'>
		<thead>
			<tr>
				<td nowrap>S.No</td>
				<td nowrap>Competency</td>
				<td nowrap>Level</td>
				<td nowrap>Question</td>
				<td nowrap>Total Questions</td>
				<td nowrap># of Answering Right</td>
				<td nowrap># of Answering wrong</td>
				<td nowrap>% Answering Right</td>
				<td nowrap>% Answering wrong</td>
			</tr>
			
		</thead>
		<tbody>
		<?php 
		foreach($comp_details as $key=>$comp_detail){
			$total_question=UlsMenu::callpdorow("SELECT count(*) as total_q FROM `uls_utest_responses_assessment` WHERE `user_test_question_id`=".$comp_detail['question_id']." and correct_flag!=''");
			$correct_question=UlsMenu::callpdorow("SELECT count(*) as cor_q FROM `uls_utest_responses_assessment` WHERE `user_test_question_id`=".$comp_detail['question_id']." and correct_flag='C'");
			$wrong_question=UlsMenu::callpdorow("SELECT count(*) as wro_q FROM `uls_utest_responses_assessment` WHERE `user_test_question_id`=".$comp_detail['question_id']." and correct_flag='W'");
			$corr_per=@round(($correct_question['cor_q']/$total_question['total_q'])*100,2);
			$wro_per=@round(($wrong_question['wro_q']/$total_question['total_q'])*100,2);	
		?>
		<tr>
			<td><?php echo $key+1; ?></td>
			<td><?php echo $comp_detail['comp_def_name']; ?></td>
			<td><?php echo $comp_detail['scale_name']; ?></td>
			<td><?php echo $comp_detail['question_name']; ?></td>
			<td><?php echo $total_question['total_q']; ?></td>
			<td><?php echo @$correct_question['cor_q']; ?></td>
			<td><?php echo @$wrong_question['wro_q']; ?></td>
			<td><?php echo $corr_per; ?></td>
			<td><?php echo $wro_per; ?></td>
		</tr>
		<?php
		}
		?>
		</tbody>
	</table> 
	
	

</div>

	<br />
	<div align='right' style='padding:10px;'>
		
		<a class='btn btn-sm btn-success' href="http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."&ExportType=export-to-excel"; ?>">Export To Excel</a>
	</div>