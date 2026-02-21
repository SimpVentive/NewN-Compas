<br/>
<div id='idexceltable'>
	<br/>
	<div id='navbar' class='navbar navbar-default navbar-fixed-top'>
			
		<div align='center'> <span><b>Assessment Competency Mapping Report</b> </span></div>
		
		<br/>
		
		
		<span style='float:right; padding-right:30px;'>Date & Time : <b><?php echo date('d-m-Y h:i:s');?></b></span>
	</div>
	<br/>
	<table id='repheader' style='width:99%' align='center' class='table table-striped table-bordered table-hover'>
		<thead>
			<tr>
				<td nowrap>S.No</td>
				<td nowrap>Position Name</td>
				<td nowrap>Competency Name</td>
				<td nowrap>Required level</td>
				<td nowrap>Criticality</td>
			</tr>
			<?php
			$temp=$temp_count="";
			$key=1;
			foreach($comp_details as $comp_detail){
			?>
			<tr>
				<td><?php 
				if($temp!=$comp_detail['position_name']){
				echo $key;
				}
				?></td>
				<td><?php
				if($temp!=$comp_detail['position_name']){
					$key++;
					echo $comp_detail['position_name'];
					$temp=$comp_detail['position_name'];
					
				} ?></td>
				<td><?php echo $comp_detail['comp_def_name']; ?></td>
				<td><?php echo $comp_detail['scale_name']; ?></td>
				<td><?php echo $comp_detail['comp_cri_name']; ?></td>
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