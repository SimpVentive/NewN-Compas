<?php 
$reportname=Doctrine_Query::Create()->from('UlsReportDefaultReportTypes')->where("default_repot_id=".$type)->fetchOne();
?>
<div id='idexceltable' >
	<br />
	<div id='navbar' class='navbar navbar-default navbar-fixed-top'>
	<div align='center'> <span><b><?php echo $reportname['default_report_name'];?></b> </span></div><br/>
	<span style='padding-left:30px;'>User Name : <b><?php echo ucwords($username['full_name']);?></b> </span><span style='float:right; padding-right:30px;'>Date & Time : <b><?php echo  date('d-m-Y h:i:s');?></b></span>
	</div><br />
	<table id='employeesTable' style='widtd:100%' align='center' class='table table-striped table-bordered table-hover'>
	<thead>
		
		<tr>
			<td nowrap>S.No</td>
			<td nowrap>Emp Code</td>
			<td nowrap>Emp Name</td>
			<td nowrap>Department</td>
			<td nowrap>Desgination</td>
			<td nowrap>Competency</td>
			<td nowrap>Indicators</td>
			<td nowrap>Programs</td>
		</tr>
	</thead>
	<tbody>
	<?php
	$temp=$temp1=$temp2=$temp3=$temp4="";
	$keyy=1;
	foreach($employee as $key=>$employees){
	?>
	<tr>
		<!--<td>
		<?php 
		if($temp!=$employees['full_name']){
		echo $keyy;
		}
		?></td>
		<td>
		<?php
		if($temp!=$employees['full_name']){
			$keyy++;
			echo $employees['employee_number']."-".$employees['full_name'];
			$temp=$employees['full_name'];
			
		} ?>
		</td>
		<td><?php
		if($temp1!=$employees['employee_number']."-".$employees['org_name']){
			echo $employees['org_name'];
			$temp1=$employees['employee_number']."-".$employees['org_name'];
		}
			?></td>
		<td><?php
		$posname=$employees['position_name'];
		if($temp2!=$employees['employee_number']."-".$posname){
			echo $posname;
			//echo $employees['position_id'];
			$temp2=$employees['employee_number']."-".$posname;
			
		}?></td>
		<td><?php 
		if($temp3!=$employees['comp_def_name']){
			echo $employees['comp_def_name'];
			$temp3=$employees['comp_def_name'];
		}?></td>-->
		<td><?php echo ($key+1);?></td>
		<td><?php echo $employees['employee_number']; ?></td>
		<td><?php echo $employees['full_name']; ?></td>
		<td><?php echo $employees['org_name']; ?></td>
		<td><?php echo $employees['position_name']; ?></td>
		<td><?php echo $employees['comp_def_name']; ?></td>
		<td><?php echo $employees['comp_def_level_ind_name'];?></td>
		<td><?php echo $employees['program_name'];?></td>
	</tr>
	<?php			 
	}			 
	?>
			</tbody>
		   </table></div><br /><br />
			<?php
			if(count($employee)>0 && !isset($_REQUEST['ExportType'])){ ?>
				<div align='right' style='padding:10px;'>
					<input type='button' onclick="htmltopdf('idexceltable','<?php echo (isset($_REQUEST['report_name']))?$_REQUEST['report_name']:''?>')" name='btnpdfExport' class='btn btn-sm btn-success'  id='btnpdfExport' value='Generate Pdf' >					
					<!--<input type='button' name='btnExport' class='btn btn-sm btn-success' id='btnExport' value='Export to excel' onclick="downloadexcel('employeesTable','<?php echo (isset($_REQUEST['report_name']))?$_REQUEST['report_name']:''?>')">-->
					<a class='btn btn-sm btn-success' href="https://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."&ExportType=export-to-excel"; ?>">Export To Excel</a>
				</div>
				<?php 		
			}?>