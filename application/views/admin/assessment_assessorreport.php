<br/>
<div id='idexceltable'>
	<br/>
	<div id='navbar' class='navbar navbar-default navbar-fixed-top'>
			
		<div align='center'> <span><b>Assessor Report</b> </span></div>
		
		<br/>
		
		
		<span style='float:right; padding-right:30px;'>Date & Time : <b><?php echo date('d-m-Y h:i:s');?></b></span>
	</div>
	<br/>
	<table id='repheader' style='width:99%' align='center' class='table table-striped table-bordered table-hover'>
		<thead>
			<tr>
				<td rowspan='2' nowrap>S.No</td>
				<td rowspan='2' nowrap>Assessor Name</td>
				<td rowspan='2' nowrap>Assessment Name</td>
				<td rowspan='2' nowrap>Total</td>
				<td rowspan='2' nowrap>No. of Emp Mapped</td>
				<td rowspan='2' nowrap>Completed By Assessor</td>
				<td rowspan='2' nowrap>Pending</td>
			</tr>
			
		</thead>
		<tbody>
		<?php
		$assessor=$ass_c=$ass_tot=$assfinal="";
		$key=1;
		$total_ass=0;
		$assessor_array=array();
		foreach($assessor_details as $assessor_detail){
			$assessor_array[$assessor_detail['assessor_id']][$assessor_detail['assessment_id']]['assessor_id']=$assessor_detail['assessor_id'];
			$assessor_array[$assessor_detail['assessor_id']][$assessor_detail['assessment_id']]['assessor_name']=$assessor_detail['assessor_name'];
			$assessor_array[$assessor_detail['assessor_id']][$assessor_detail['assessment_id']]['assessment_name']=$assessor_detail['assessment_name'];
			//$posids=$ass_rights['positionids'];
			//$pos_id=$positions['position_id'];
			$pos_id=explode(",",$assessor_detail['positionids']);
			$total_c=$fianl_c=0;
			foreach($pos_id as $pos_ids){
				$ass_rights=UlsAssessmentPositionAssessor::get_assessor_rights($assessor_detail['assessment_id'],$assessor_detail['assessor_id'],$pos_ids);
				$ass_per=($ass_rights['assessor_per']=='Y')?$ass_rights['emp_ids']:"";
				$employee=UlsAssessmentPositionAssessor::get_assessor_assessmentreport($assessor_detail['assessment_id'],'ASS',$ass_per,$pos_ids);
				$total_c+=$employee['total_emp'];
				$ass_final=UlsAssessmentReportFinal::assessment_assessor_report($assessor_detail['assessment_id'],$pos_ids,$assessor_detail['assessor_id']);
				$fianl_c+=$ass_final['comp_total'];
			}
			
			$assessor_array[$assessor_detail['assessor_id']][$assessor_detail['assessment_id']]['total_count']=$total_c;
			$assessor_array[$assessor_detail['assessor_id']][$assessor_detail['assessment_id']]['total_final']=$fianl_c;
			
		}
		/* echo "<pre>";	
		print_r($assessor_array); */
		foreach($assessor_array as $key_n=>$assessor_arrays){
			foreach($assessor_arrays as $key_h=>$assessorarrays){
		?>
			<tr>
				
				<?php
				if($ass_c!=$assessorarrays['assessor_id']){
					$ass_c=$assessorarrays['assessor_id'];
					echo "<td rowspan='".count($assessor_array[$key_n])."'>".$key."</td>";
					$key++;
				}
				?>
				<?php 
				if($assessor!=$assessorarrays['assessor_id']){
					$assessor=$assessorarrays['assessor_id'];
					echo "<td rowspan='".count($assessor_array[$key_n])."'>".$assessorarrays['assessor_name']."</td>";
				}
				?>
				<td><?php echo $assessorarrays['assessment_name']; ?></td>
				<?php 
				if($ass_tot!=$assessorarrays['assessor_id']){
					$ass_tot=$assessorarrays['assessor_id'];
					$count_ass=0;
					foreach($assessor_array[$key_n] as $count_assessor){
						$count_ass=($count_assessor['total_count']+$count_ass);
					}
					echo "<td rowspan='".count($assessor_array[$key_n])."'>".$count_ass."</td>";
				}
				?>
				<td><?php echo $assessorarrays['total_count']; ?></td>
				<td><?php echo $assessorarrays['total_final']; ?></td>
				<?php 
				if($assfinal!=$assessorarrays['assessor_id']){
					$assfinal=$assessorarrays['assessor_id'];
					$count_final=0;
					foreach($assessor_array[$key_n] as $count_assessor){
						$count_final=(($count_assessor['total_count']-$count_assessor['total_final'])+$count_final);
					}
					echo "<td rowspan='".count($assessor_array[$key_n])."'>".$count_final."</td>";
				}
				?>
				
			</tr>
		<?php
			
			}
		}
		
		?>
		
		</tbody>
	</table> 
	
	

</div>

	<br />
	<div align='right' style='padding:10px;'>
		
		<a class='btn btn-sm btn-success' href="http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."&ExportType=export-to-excel"; ?>">Export To Excel</a>
	</div>