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
		<?php $count=!empty($position_temp)?(count($position_temp)+1):""; ?>
			<td colspan="<?php echo $count; ?>" align="center"><b><?php echo $pos_details['position_name']; ?></b></td>
		</tr>
		<tr style="background-color:#ff0">
			<td colspan="<?php echo $count; ?>" align="center"><b>Accountabilities</b></td>
			
		</tr>
		<tr style="background-color:#ff0">
			
			<td><b>Current</b></td>
			<?php 
			foreach($position_temp as $position_temps){
			?>
			<td><b><?php echo $position_temps['full_name']; ?></b></td>
			<?php } ?>
		</tr>
		<tr>
			<td><?php echo $pos_details['accountablities']; ?></td>
			<?php 
			foreach($position_temp as $position_temps){
			?>
			<td><?php echo !empty($position_temps['accountabilities'])?$position_temps['accountabilities']:"-"; ?></td>
			<?php } ?>
		</tr>
	</table> 
	<table id='repheader' style='width:90%' align='center' class='table table-striped table-bordered table-hover'>
		
		<tr style="background-color:#ff0">
			<td colspan="<?php echo $count; ?>" align="center"><b>Responsibilities</b></td>
			
		</tr>
		<tr style="background-color:#ff0">
			
			<td><b>Current</b></td>
			<?php 
			foreach($position_temp as $position_temps){
			?>
			<td><b><?php echo $position_temps['full_name']; ?></b></td>
			<?php } ?>
		</tr>
		<tr>
			<td><?php echo $pos_details['responsibilities']; ?></td>
			<?php 
			foreach($position_temp as $position_temps){
			?>
			<td><?php echo !empty($position_temps['responsibilities'])?$position_temps['responsibilities']:"-"; ?></td>
			<?php } ?>
		</tr>
	</table> 
	<br/>
	<label style='padding-left:70px;font-size:18px;'><b>Competencies</b></label>
	<br />
	<table id='repheader' style='width:90%;border:1px' align='center' class='table table-striped table-bordered table-hover'>
		<tr style="background-color:#ff0">
			<td nowrap><b>Employee</b></td>
			<td nowrap><b>Require</b></td>
			<td nowrap><b>Caterogy Name</b></td>
			<td nowrap><b>Competency Name</b></td>
			<td nowrap><b>Required Level</b></td>
			<td nowrap><b>Criticality</b></td>
			<td nowrap><b>Suggestion</b></td>
			<td nowrap><b>Reason</b></td>
		</tr>
		<?php foreach($competencies as $competency){ ?>
			<tr style="background-color:#54ff79">
				<td nowrap><b>Default</b></td>
				<td nowrap>-</td>
				<td nowrap><?php echo $competency['category']; ?></td>
				<td nowrap><?php echo $competency['comp_def_name']; ?></td>
				<td nowrap><?php echo $competency['scale_name']; ?></td>
				<td nowrap><?php echo $competency['comp_cri_name']; ?></td>
				<td nowrap>-</td>
				<td nowrap>-</td>
			</tr>
			<?php foreach($employees as $employee){
					$empcomp=UlsPositionTemp::getemployeecompetency($_REQUEST['id'],$_REQUEST['pos_id'],$competency['comp_position_competency_id'],$employee['employee_id']);
			?>
			<tr>
				<td nowrap><b><?php echo $employee['full_name']; ?></b></td>
				<td nowrap><?php echo @$empcomp['req_process']; ?></td>
				<td nowrap></td>
				<td nowrap></td>
				<td nowrap></td>
				<td nowrap></td>
				<td nowrap><?php echo @$empcomp['ass_scale_name']; ?></td>
				<td nowrap><?php echo @$empcomp['reason']; ?></td>
			</tr>
			<?php } ?>
		<?php } ?>
		
	</table>
	
	<br/>
	<label style='padding-left:70px;font-size:18px;'><b>New Added Competencies</b></label>
	<br />
	<table id='repheader' style='width:90%' align='center' class='table table-striped table-bordered table-hover'>
		<tr>
			<td nowrap><b>Employee Name</b></td>
			<td nowrap><b>Category</b></td>
			<td nowrap><b>Competency Name</b></td>
			<td nowrap><b>Suggestion</b></td>
			<td nowrap><b>Reason</b></td>
		</tr>
		<?php
		$position_details=UlsPositionCompetencyTempTray::get_position_validation_competencies($_REQUEST['id'],$_REQUEST['pos_id']);
		foreach($position_details as $key=>$position_detail){ 
		?>
		<tr>
			<td nowrap><?php echo @$position_detail['full_name']; ?></td>
			<td nowrap><?php echo @$position_detail['name']; ?></td>
			<td><?php echo !empty($position_detail['competency_name'])?$position_detail['competency_name']:"-"; ?></td>
			<td><?php echo !empty($position_detail['scale_name'])?$position_detail['scale_name']:"-"; ?></td>
			<td><?php echo !empty($position_detail['reason'])?$position_detail['reason']:"-"; ?></td>
		</tr>
		<?php
		}
		?>
	</table>
	
	<br/>
	<label style='padding-left:70px;font-size:18px;'><b>KRA's</b></label>
	<br />
	<table id='repheader' style='width:90%' align='center' class='table table-striped table-bordered table-hover'>
		<thead>
			<tr style="background-color:#ff0">
				<td nowrap><b>Employee</b></td>
				<td nowrap><b>Require</b></td>
				<td nowrap><b>KRA</b></td>								
				<td nowrap><b>KPI</b></td>
				<td nowrap><b>UOM</b></td>
				<td nowrap><b>Reason</b></td>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach($kras as $kra){
		?>
		<tr style="background-color:#54ff79">
			<td>Default</td>
			<td>-</td>
			<td><?php echo !empty($kra['kra_master_name'])?$kra['kra_master_name']:"-"; ?></td>
			<td><?php echo !empty($kra['kra_kri'])?$kra['kra_kri']:"-"; ?></td>
			<td><?php echo !empty($kra['kra_uom'])?$kra['kra_uom']:"-"; ?></td>
			<td>-</td>
		</tr>
		<?php foreach($employees as $employee){
					$empkra=UlsPositionTemp::get_position_validation_kra_summary($_REQUEST['id'],$_REQUEST['pos_id'],$kra['comp_kra_id'],$employee['employee_id']);
		?>
			<tr>
				<td nowrap><b><?php echo $employee['full_name']; ?></b></td>
				<td nowrap><?php echo @$empkra['req_process']; ?></td>
				<td nowrap></td>
				<td nowrap></td>
				<td nowrap></td>
				<td nowrap><?php echo @$empkra['reason']; ?></td>
			</tr>
		<?php } ?>
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
				<td nowrap><b>Employee Name</b></td>
				<td nowrap><b>KRA</b></td>								
				<td nowrap><b>KPI</b></td>
				<td nowrap><b>UOM</b></td>
				<td nowrap><b>Reason</b></td>
			</tr>
		</thead>
		<tbody>
		<?php
		$emp_kra_details=UlsPositionKraTempTray::get_position_validation_kra($_REQUEST['id'],$_REQUEST['pos_id']);
		foreach($emp_kra_details as $key=>$emp_kra_detail){ 
		?>
		<tr>
			<td nowrap><?php echo @$emp_kra_detail ['full_name']; ?></td>
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

</div></div></div>
	<br />
	<div align='right' style='padding:10px;'>
		<a class='btn btn-sm btn-success' href="http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."&ExportType=export-to-excel"; ?>">Export To Excel</a>
	</div>