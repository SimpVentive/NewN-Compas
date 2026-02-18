<br/>
<div id='idexceltable'>
	<br/>
	<div id='navbar' class='navbar navbar-default navbar-fixed-top'>
			
		<div align='center'> <span><b>Position Report</b> </span></div>
		
		<br/>
		
		<span style='padding-left:30px;'>User Name : <b>Srikanth</b> </span>
		
		<span style='float:right; padding-right:30px;'>Date & Time : <b><?php echo date('d-m-Y h:i:s');?></b></span>
	</div>
	<br/>
	<table id='repheader' style='width:90%' align='center' class='table table-striped table-bordered table-hover'>
		<tr>
			<td colspan="3" align="center"><b><?php echo $pos_details['position_name']; ?></b></td>
		</tr>
		
		<tr>
			<td><b>Employee Name</b></td>
			<td><b>Accountabilities</b></td>
			<td><b>Responsibilities</b></td>
		</tr>
		<tr>
			<td>Default</td>
			<td><?php echo $pos_details['accountablities']; ?></td>
			<td><?php echo $pos_details['responsibilities']; ?></td>
		</tr>
		<?php 
		foreach($position_temp as $position_temps){
		?>
		<tr>
			<td><?php echo $position_temps['full_name']; ?></td>
			<td><?php echo $position_temps['accountabilities']; ?></td>
			<td><?php echo $position_temps['responsibilities']; ?></td>
		</tr>
		<?php
		}
		?>
	</table> 
	<br/>
	<?php 
	foreach($position_temp as $position_temps){
	?>
	<label style='padding-left:70px;font-size:20px;'><b>Employee Name:<?php echo $position_temps['full_name']; ?></b></label>
	<br/>
	<?php 
	foreach($comp_details as $comp_detail){
	?>
	<label style='padding-left:70px;font-size:18px;'><b><?php echo $comp_detail['name']; ?></b></label>
	<table id='repheader' style='width:90%;border:1px' align='center' class='table table-striped table-bordered table-hover'>
		<tr>
			<td nowrap><b>Require</b></td>
			<td nowrap><b>Competency Name</b></td>
			<td nowrap><b>Required Level</b></td>
			<td nowrap><b>Suggestion</b></td>
			<td nowrap><b>Reason</b></td>
		</tr>
		<?php
		$competency=UlsPositionTemp::get_admin_validation_competencies_summary($_REQUEST['id'],$_REQUEST['pos_id'],$_REQUEST['val_pos_id'],$comp_detail['category_id'],$position_temps['employee_id']);
		
		foreach($competency as $competencys){
		?>
		<tr>
			<td><?php echo !empty($competencys['req_process'])?$competencys['req_process']:"-"; ?></td>
			<td><?php echo !empty($competencys['comp_def_name'])?$competencys['comp_def_name']:"-"; ?></td>
			<td><?php echo !empty($competencys['scale_name'])?$competencys['scale_name']:"-"; ?></td>
			<td><?php echo !empty($competencys['ass_scale_name'])?$competencys['ass_scale_name']:"-"; ?></td>
			<td><?php echo !empty($competencys['reason'])?$competencys['reason']:"-"; ?></td>
		</tr>
		<?php 
		}
		?>
	</table>
	<br/>
	<label style='padding-left:70px;font-size:18px;'><b>Added New Competency Required In This <?php echo $comp_detail['name']; ?></b></label>
	<br />
	<table id='repheader' style='width:90%' align='center' class='table table-striped table-bordered table-hover'>
		<tr>
			<td nowrap><b>Competency Name</b></td>
			<td nowrap><b>Suggestion</b></td>
			<td nowrap><b>Reason</b></td>
		</tr>
		<?php
		$position_details=UlsPositionCompetencyTempTray::get_admin_validation_competencies($_REQUEST['id'],$_REQUEST['pos_id'],$comp_detail['category_id'],$position_temps['employee_id']);
		foreach($position_details as $key=>$position_detail){ 
		?>
		<tr>
			<td><?php echo !empty($position_detail['competency_name'])?$position_detail['competency_name']:"-"; ?></td>
			<td><?php echo !empty($position_detail['scale_name'])?$position_detail['scale_name']:"-"; ?></td>
			<td><?php echo !empty($position_detail['reason'])?$position_detail['reason']:"-"; ?></td>
		</tr>
		<?php
		}
		?>
	</table>
	
	
	<?php 
	} ?>
	<br/>
	<label style='padding-left:70px;font-size:18px;'><b>KRA's</b></label>
	<br />
	<table id='repheader' style='width:90%' align='center' class='table table-striped table-bordered table-hover'>
		<thead>
			<tr>
				<td nowrap><b>Require</b></td>
				<td nowrap><b>KRA</b></td>								
				<td nowrap><b>KPI</b></td>
				<td nowrap><b>UOM</b></td>
				<td nowrap><b>Reason</b></td>
			</tr>
		</thead>
		<tbody>
		<?php 
		$emp_kra_validation_details=UlsPositionTemp::get_admin_validation_kra_summary($_REQUEST['id'],$_REQUEST['pos_id'],$_REQUEST['val_pos_id'],$position_temps['employee_id']);
		foreach($emp_kra_validation_details as $emp_kra_validation_detail){
		?>
		<tr>
			<td><?php echo !empty($emp_kra_validation_detail['req_process'])?$emp_kra_validation_detail['req_process']:"-"; ?></td>
			<td><?php echo !empty($emp_kra_validation_detail['kra_master_name'])?$emp_kra_validation_detail['kra_master_name']:"-"; ?></td>
			<td><?php echo !empty($emp_kra_validation_detail['kra_kri'])?$emp_kra_validation_detail['kra_kri']:"-"; ?></td>
			<td><?php echo !empty($emp_kra_validation_detail['kra_uom'])?$emp_kra_validation_detail['kra_uom']:"-"; ?></td>
			<td><?php echo !empty($emp_kra_validation_detail['reason'])?$emp_kra_validation_detail['reason']:"-"; ?></td>
		</tr>
		<?php
		}
		?>
		</tbody>
	</table>
	<br />
	<label style='padding-left:70px;font-size:18px;'><b>Add New KRA's</b></label>
	<br />
	<table id='repheader'  style='width:90%' align='center' class='table table-striped table-bordered table-hover'>
		<thead>
			<tr>
				<td nowrap><b>KRA</b></td>								
				<td nowrap><b>KPI</b></td>
				<td nowrap><b>UOM</b></td>
				<td nowrap><b>Reason</b></td>
			</tr>
		</thead>
		<tbody>
		<?php
		$emp_kra_details=UlsPositionKraTempTray::get_admin_validation_kra($_REQUEST['id'],$_REQUEST['pos_id'],$position_temps['employee_id']);
		foreach($emp_kra_details as $key=>$emp_kra_detail){ 
		?>
		<tr>
			<td><?php echo !empty($emp_kra_detail['kra_des'])?$emp_kra_detail['kra_des']:"-"; ?></td>
			<td><?php echo !empty($emp_kra_detail['kra_kri'])?$emp_kra_detail['kra_kri']:"-"; ?></td>
			<td><?php echo !empty($emp_kra_detail['kra_uom'])?$emp_kra_detail['kra_uom']:"-"; ?></td>
			<td><?php echo !empty($emp_kra_detail['reason'])?$emp_kra_detail['reason']:"-"; ?></td>
		</tr>
		<?php
		}
		?>
		</tbody>
	</table>
	<?php 
	} ?>
</div>
	<br />
	<div align='right' style='padding:10px;'>
		<a class='btn btn-sm btn-success' href="http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."&ExportType=export-to-excel"; ?>">Export To Excel</a>
	</div>