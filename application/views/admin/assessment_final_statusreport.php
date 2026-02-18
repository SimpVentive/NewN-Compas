<br/>
<div id='idexceltable'>
	<br/>
	<div id='navbar' class='navbar navbar-default navbar-fixed-top'>
			
		<div align='center'> <span><b>Assessment Feedback Report</b> </span></div>
		
		<br/>
		
		
		<span style='float:right; padding-right:30px;'>Date & Time : <b><?php echo date('d-m-Y h:i:s');?></b></span>
	</div>
	<br/>
	<?php
	foreach($position_details as $position_detail){
		$comp_details=UlsAssessmentReport::admin_assessment_competencies_report($_REQUEST['id'],$position_detail['position_id']);
		if(count($comp_details)>0){
			$emp_details=UlsAssessmentEmployees::getassessmentemployees_position_report($_REQUEST['id'],$position_detail['position_id']);
	?>
	<label style="font-size:12px;font-color:blue;">Position Name: <?php echo $position_detail['position_name']; ?></label><br>
	<table id='repheader' style='width:99%' align='center' class='table table-striped table-bordered table-hover'>
		<thead>
			<tr>
				<td>S.No</td>
				<td>Emp Code</td>
				<td>Name</td>
				<td>Grade</td>
				<td>Designation</td>
				<td>Department</td>
				<td>Location</td>
				<td colspan='<?php echo (count($comp_details)*3); ?>' align="center">Competencies</td>
			</tr>
			
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<?php
				foreach($comp_details as $comp_detail){
				?>
				<td colspan='3' align="center"><?php echo $comp_detail['comp_def_name']; ?></td>
				<?php 
				} 
				?>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<?php 
				foreach($comp_details as $comp_detail){
				?>
				<td>Required</td>
				<td>Assessed</td>
				<td>Development</td>
				<?php } ?>
			</tr>
			
		</thead>
		<tbody>
		<?php 
		$results=$ass_comname=$ass_req_sid=$ass_given_sid=array();
		$k=1;	
		foreach($emp_details as $key=>$emp_detail){
			
			//foreach($comp_details as $comp_detail){,$comp_detail['comp_def_id']
				$assresults=UlsAssessmentTest::assessment_results_avg($_REQUEST['id'],$position_detail['position_id'],$emp_detail['employee_id']);
				if(count($assresults)>0){
		?>
		<tr>
			<td><?php echo ($k); ?></td>
			<td><?php echo $emp_detail['employee_number'];?></td>
			<td><?php echo $emp_detail['full_name'];?></td>
			<td><?php echo $emp_detail['grade_name'];?></td>
			<td><?php echo $emp_detail['position_name'];?></td>
			<td><?php echo $emp_detail['org_name'];?></td>
			<td><?php echo $emp_detail['location_name'];?></td>
			<?php
			
				foreach($assresults as $assresult){
					$compid=$assresult['comp_def_id'];
					$finalval=!empty($assresult['assessor_val'])?round(($assresult['ass_scale_number']*$assresult['assessor_val']),2):$assresult['ass_scale_number'];
					$results[$assresult['comp_def_id']]['comp_id']=$compid;
					$results[$assresult['comp_def_id']]['comp_name']=$assresult['comp_def_name'];
					$results[$assresult['comp_def_id']]['req_val']=$assresult['req_number'];
					$results[$assresult['comp_def_id']]['require_scale_id']=$assresult['require_scale_id'];
					$results[$assresult['comp_def_id']]['assessor'][$assresult['assessor_id']]=$finalval;
				}
				$req_sid=$ass_sid=$comname=$compid=$require_scale_id=array();
				if(count($results)>0){
					foreach($results as $key1=>$result){
						$flag=0;
						$comp_id[$key1]=$result['comp_id'];
						$comname[$key1]=$result['comp_name'];
						$req_sid[$key1]=$result['req_val'];
						$require_scale_id[$key1]=$result['require_scale_id'];
						$final=0;
						foreach($result['assessor'] as $key2=>$ass_id){
							$final=$final+$results[$key1]['assessor'][$key2];
						}
						$final=round($final/count($results[$key1]['assessor']),2);
						$ass_sid[$key1]=$final;
						if($ass_sid[$key1]<$req_sid[$key1]){
							$flag=1;
						}
						
						$method_check=UlsAssessmentReportBytype::summary_detail_info_report($_REQUEST['id'],$position_detail['position_id'],$emp_detail['employee_id'],$result['comp_id']);
						
						foreach($method_check as $method_checks){
							if($method_checks['assessment_type']=='INBASKET'){
								$req_level_bycomp=$method_checks['req_number'];
								$ass_level_bycomp=round($method_checks['ass_scale_number'],1);
								if($req_level_bycomp>$ass_level_bycomp){
									$flag=1;
								}
							}
							if($method_checks['assessment_type']=='CASE_STUDY'){
								$req_level_bycomp=$method_checks['req_number'];
								$ass_level_bycomp=round($method_checks['ass_scale_number'],1);
								$case_check=UlsAssessmentAssessorRating::get_ass_rating_report($_REQUEST['id'],$position_detail['position_id'],$emp_detail['employee_id'],'CASE_STUDY');
								if($req_level_bycomp>$ass_level_bycomp){
									$flag=1;
								}
								if($case_check['ass_rat']<3){
									$flag=1;
								}
							}
						}
						if($flag==1){
							if(!in_array($result['comp_id'],$compid)){
								$compid[$key1]=$result['comp_id'];
							}
						}
					}
				}
				
			?>
			<?php 
			foreach($comp_details as $comp_detail){
				
				$req_level=@$req_sid[$comp_detail['comp_def_id']];
				$ass_level=@$ass_sid[$comp_detail['comp_def_id']];
				if($ass_level>$req_level){
					$color='green';
				}
				if($ass_level<$req_level){
					$color='red';
				}
				if($ass_level==$req_level){
					$color='orange';
				}
				
			
			?>
			<td><?php echo @$req_sid[$comp_detail['comp_def_id']]; ?></td>
			<td style="color:<?php echo $color; ?>"><?php echo @$ass_sid[$comp_detail['comp_def_id']]; ?></td>
			<td><?php 
			$cc=@$compid[$comp_detail['comp_def_id']];
			$rq=$require_scale_id[$comp_detail['comp_def_id']];
			/* echo "<pre>";
			print_r($cc); 
				print_r($rq);  */
			if(!empty($cc)){
				$development=UlsCompetencyDefLevelTraining::getcompdeftraining($cc,$rq);	
				echo (!empty($development))?"Development":"";
			}
			?></td>
			<?php } ?>
		</tr>
		<?php
		$k++;
				}
		}
		?>
		</tbody>
	</table> 
	<br>
	<?php }
	}	?>
</div>
<br />
	<div align='right' style='padding:10px;'>
		
		<a class='btn btn-sm btn-success' href="http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."&ExportType=export-to-excel"; ?>">Export To Excel</a>
	</div>
	