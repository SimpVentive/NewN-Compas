<?php 
$reportname=Doctrine_Query::Create()->from('UlsReportDefaultReportTypes')->where("default_repot_id=".$type)->fetchOne();
?>
<div id='idexceltable' >
	<br />
	<div id='navbar' class='navbar navbar-default navbar-fixed-top'>
	<div align='center'> <span><b><?php echo $reportname['default_report_name'];?></b> </span></div><br/>
	<span style='padding-left:30px;'>User Name : <b><?php echo ucwords($username['full_name']);?></b> </span><span style='float:right; padding-right:30px;'>Date & Time : <b><?php echo  date('d-m-Y h:i:s');?></b></span>
	</div>
	<br /><br />
			<?php
			if(count($employee)>0 && !isset($_REQUEST['ExportType'])){ ?>
				<div align='right' style='padding:10px;'>
					<input type='button' onclick="htmltopdf('idexceltable','<?php echo (isset($_REQUEST['report_name']))?$_REQUEST['report_name']:''?>')" name='btnpdfExport' class='btn btn-sm btn-success'  id='btnpdfExport' value='Generate Pdf' >					
					<!--<input type='button' name='btnExport' class='btn btn-sm btn-success' id='btnExport' value='Export to excel' onclick="downloadexcel('employeesTable','<?php echo (isset($_REQUEST['report_name']))?$_REQUEST['report_name']:''?>')">-->
					<a class='btn btn-sm btn-success' href="<?php echo BASE_URL."".$_SERVER['REQUEST_URI']."&ExportType=export-to-excel"; ?>">Export To Excel</a>
				</div>
				<?php 		
			}?>
	<br />
	
	<table id='employeesTable' style='widtd:100%' align='center' class='table table-striped table-bordered table-hover'>
	<thead>
		
		<tr>
			<td nowrap>S.No</td>
			<td nowrap>Employee Name</td>
			<td nowrap>Department</td>
			<td nowrap>Desgination</td>
			<td nowrap>Competency</td>
			<td nowrap>Required Level </td>
			<td nowrap>Assessed Level</td>
			<td nowrap>Gap</td>
			<td nowrap>Gap Area</td>
		</tr>
	</thead>
	<tbody>
	<?php
	$temp="";
	$key=1;
	foreach($employee as $key=>$employees){
	?>
	<tr>
		<td>
		<?php 
		if($temp!=$employees['full_name']){
		echo $key+1;
		}
		?></td>
		<td><?php
		if($temp!=$employees['full_name']){
			$key++;
			echo $employees['employee_number']."-".$employees['full_name'];
			$temp=$employees['full_name'];
			
		} ?>
		</td>
		<td><?php echo $employees['org_name'];?></td>
		<td><?php echo $employees['position_name'];?></td>
		
		<?php 
		$assresults=UlsAssessmentTest::assessment_results_avg($employees['assessment_id'],$employees['position_id'],$employees['employee_id']);
		$results=$ass_comname=$ass_req_sid=$ass_given_sid=array();
		$j=0;
		foreach($assresults as $assresult){
			$compid=$assresult['comp_def_id'];
			$finalval=!empty($assresult['assessor_val'])?round(($assresult['ass_scale_number']*$assresult['assessor_val']),2):$assresult['ass_scale_number'];
			$results[$assresult['comp_def_id']]['comp_id']=$compid;
			$results[$assresult['comp_def_id']]['comp_name']=$assresult['comp_def_name'];
			$results[$assresult['comp_def_id']]['req_val']=$assresult['req_number'];
			$results[$assresult['comp_def_id']]['assessor'][$assresult['assessor_id']]=$finalval;
		}
		$req_sid=$ass_sid=$comname=array();
		$k=1;
		if(count($results)>0){
			foreach($results as $key1=>$result){
				$comp_id[$key1]="C".($k);
				$comname[$key1]=$result['comp_name'];
				$req_sid[$key1]=$result['req_val'];
				$final=0;
				foreach($result['assessor'] as $key2=>$ass_id){
					$final=$final+$results[$key1]['assessor'][$key2];
				}
				$final=round($final/count($results[$key1]['assessor']),2);
				$ass_sid[$key1]=$final;
				$k++;
				if($j==0){
			?>
			<td><?php echo $result['comp_name']; ?></td>
			<td><?php echo $result['req_val']; ?></td>
			<td><?php echo $final; ?></td>
			<td><?php echo ($result['req_val']-$final); ?></td>
			<td><?php echo ($final<$result['req_val'])?"1":""; ?></td>
			</tr>
				<?php }
				else{ ?>
				<tr><td colspan='4'>&nbsp;</td>
					<td><?php echo $result['comp_name']; ?></td>
			<td><?php echo $result['req_val']; ?></td>
			<td><?php echo $final; ?></td>
			<td><?php echo ($result['req_val']-$final); ?></td>
			<td><?php echo ($final<$result['req_val'])?"1":""; ?></td>
			</tr>
				<?php } $j++;
			}
		}
		?>
		
	</tr>
	<?php			 
	}			 
	?>
			</tbody>
		   </table></div>