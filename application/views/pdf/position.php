<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  
  <title>Job Profile for <?php echo @$posdetails['position_name']; ?></title>
  
  <style type="text/css">
	@page {
	  margin: 0;
	}
	.flyleaf {
		page-break-after: always;
		
	}
	body{
		margin:0px;
		padding:0px;
	}
	div.body {
		margin-top: 2.5cm;
		margin-bottom: 1.1cm;
		margin-left: 1.5cm;
		margin-right: 1.5cm;
		font-family: "rockwell";
		text-align: justify;
		color:#000;
		font-size: 12px;
	}
	
	div.header{
		position: fixed;
		background: #fff;
		color:#fff;
		width: 100%;
		border-bottom:1px solid #010F3C;
		overflow: hidden;
		margin-left: 1cm;
		margin-right: 1cm;
		top: 0px;
		left:0cm;
		height:2cm;
	}
	div.footer {
		position: fixed;
		background: #fff;
		color:#fff;
		width: 100%;
		border-top:1px solid #010F3C;
		overflow: hidden;
		margin-left: 1cm;
		margin-right: 1cm;
		bottom: 0px;
		left:0px;
		height:1cm;
	}
	
	div.leftpane {
		position: fixed;
		background: #fff;
		width: 1cm;
		border-right: 1px solid #010F3C;
		top: 0cm;
		left: 0cm;
		height: 30cm;
	}
	
	div.rightpane {
		position: fixed;
		background: #fff;
		width: 1cm;
		border-left: 1px solid #010F3C;
		top: 0cm;
		right: 0cm;
		height: 30cm;
	}
	
	div.footer table {
	  width: 100%;
	  text-align: center;
	}
	
	hr {
	  page-break-after: always;
	  border: 0;
	}
	table{
		width:100%;
		border-collapse: collapse;
		font-family: "rockwell";
		font-size: 12px;
    }
    thead th{
		text-align: left;
		padding: 10px;
		border: 1px solid #e3e3e3;
		font-family: "rockwell";
		font-size: 12px;
    }
    tbody td{
		border: 1px solid #e3e3e3;
		padding: 2px 5px;
    }
	li{
		margin: 5px;
		line-height:1.5em;
	}
   
	#overlay {
		position: absolute;
		top: 0;
		left: 0;
		height: 100%;
		width: 100%;
		margin:0px;
		padding:0px;
		background-image: url('public/PDF/images/cms/jdfrontpage.jpg');
		background-position: left top;
		background-repeat: no-repeat;
		z-index: -1;
	}
	
	
	#overlay2 {
		position: absolute;
		top: 0;
		left: 0;
		height: 100%;
		width: 100%;
		margin:0px;
		padding:0px;
		background-image: url('public/PDF/images/cms/interviewbookletback.jpg');
		background-position: left top;
		background-repeat: no-repeat;
		z-index: 9999;
	}
	.row.header {
		background: #ea6153 none repeat scroll 0 0;
		color: #ffffff;
		font-weight: 900;
	}
	ul,ol,li{
		margin:0px 5px;
		padding:0px;
	}
	.fish { position: absolute; top: 30px; right: 30px; }
	.fish1 { position: absolute; top: 106px; right: 30px; text-align: right;}
	.titleheader {
		background: #999;
		color:#fff;
		border: 1px solid #333;
		border-radius: 0.25rem;
		margin-bottom: 1rem;
		padding: 0.60rem 1.25rem;
		position: relative;
		
	}
  </style>
  
</head>
<div class="flyleaf">
	<div id="overlay"><img src="public/PDF/images/cms/jdfrontpage.jpg" width="100%"> </div>
	<img src="<?php echo LOGO_IMG; ?>" width="176" height="66" class="fish"> 
	<label class="fish1"><b style="font-size:22px;color:#414142;">JOB DESCRIPTION<br><?php echo @$posdetails['position_name']; ?></b></label>
</div>
<body>
	<div class="leftpane">
		<div style="text-align: center;"></div>
	</div>
	<div class="rightpane">
	  <div style="text-align: center;"></div>
	</div>
	<div class="header">
		<img src="<?php echo LOGO_IMG; ?>" style="margin:0.15cm 0.2cm" width="176" height="66">
	</div>
	<div class="footer">
	  <div style="text-align: right; color:#000;margin-right:10px;">N-Compass.com</div>
	</div>
<div class="body">
<h2 style="text-align:center"><?php echo @$posdetails['position_name']; ?></h2><p>&nbsp;</p>
<h4 class="titleheader">Position Details</h4>
<table>
	<tbody>
		<tr>
			<td class="normal"  style="width:15%"><b>Job Title</b></td>
			<td class="normal"  style="width:35%"><?php echo @$posdetails['position_name']; ?>&nbsp;</td>
			<td class="normal"  style="width:15%"><b>Grade/Level</b></td>
			<td class="normal"  style="width:35%"><?php echo @$posdetails['grade_name']; ?>&nbsp;</td>
		</tr>
		<tr><td class="normal"><b>Business</b></td>
			<td class="normal"><?php echo @$posdetails['bu_name']; ?>&nbsp;</td>
			<td class="normal"><b>Function</b></td>
			<td class="normal"><?php echo @$posdetails['position_org_name']; !empty($posdetails['position_org_name'])?"":"-"; ?></td>			
		</tr>
		<tr>
			<td class="normal"><b>Location</b></td>
			<td class="normal"><?php echo @$posdetails['location_name']; !empty($posdetails['location_name'])?"":"-";?></td>
			<td class="normal">&nbsp;</td>
			<td class="normal">&nbsp;</td>
		</tr>
	</tbody>
</table>

<h4 class="titleheader">Reporting Relationships </h4>
<table>
	<tbody>
		<tr>
			<td class="normal" style="width:50%"><b>Reports to</b></td>
			<td class="normal" style="width:50%"><b>Reportees</b></td>
		</tr>
		<tr>
			<td class="normal" ><?php echo @$posdetails['reportsto']; !empty($posdetails['reportsto'])?"":"-";?></td>
			<td class="normal"><?php echo @$posdetails['reportees_name']; !empty($posdetails['reportees_name'])?"":"-";?></td>
		</tr>
	</tbody>
</table>

<h4 class="titleheader">Position Requirements </h4>
<table>
	<tbody>
		<tr>
			<td class="normal" style="width:33%"><b>Education Background</b></td>
			<td class="normal" style="width:33%"><b>Experience</b></td>
			<td class="normal" style="width:33%"><b>Industry Experience</b></td>
		</tr>
		<tr>
			<td class="normal" ><?php echo @$posdetails['education']; !empty($posdetails['education'])?"":"-"; ?></td>
			<td class="normal"><?php echo @$posdetails['experience']; !empty($posdetails['experience'])?"":"-"; ?></td>
			<td class="normal"><?php echo @$posdetails['specific_experience']; !empty($posdetails['specific_experience'])?"":"-"; ?></td>
		</tr>
	</tbody>
</table>

<?php if(!empty($posdetails['other_requirement'])){ ?>
<h4 class="titleheader">Other Requirements</h4>
<div><?php echo @$posdetails['other_requirement']; ?></div>
<?php } ?>
<h4 class="titleheader">Purpose</h4>
<div><?php echo @$posdetails['position_desc']; ?></div>
</div>
<div style="page-break-after: always;"></div>
<div class="body">
<h4 class="titleheader">Accountabilities</h4>
<div><?php echo @$posdetails['accountablities']; ?></div>
</div>
<!--<div style="page-break-after: always;"></div>
<div class="body">
<h4 class="titleheader">Responsibilities</h4>
<div><?php echo @$posdetails['responsibilities']; ?></div>
</div>-->
<?php if(count($kras)>0){ ?>
<div style="page-break-after: always;"></div>
<div class="body">

	<h4 class="titleheader">KRA & KPI</h4>
	<table>
		<thead>
		<tr class="row header">
			<th>KRA</th>
			<th>KPI</th>
			<th>Unit of Measurement (UOM)</th>
		</tr>
		</thead>
		<tbody>
		<?php
		$temp="";
		foreach($kras as $kra){
			if($kra['comp_position_id']==$posdetails['position_id']){
				echo "<tr><td>";
				if($temp!=$kra['kra_master_name']){
					echo $kra['kra_master_name'];
					$temp=$kra['kra_master_name'];
				}
				echo "</td><td>".$kra['kra_kri']."</td><td>".$kra['kra_uom']."</td></tr>";
			}
		} ?>


		</tbody>
	</table>
</div>
<?php } ?>
<div style="page-break-after: always;"></div>
<div class="body">
<h4 class="titleheader">Competencies Required</h4>
<?php
foreach($category as $categorys){
	$competencies=UlsCompetencyPositionRequirements::getcompetencypositionrequirements_cat($_REQUEST['posid'],$categorys['category_id']);
?>
<h4 class="titleheader"><?php echo $categorys['name']; ?></h4>
<table>
	<thead>
	<tr class="row header">
		<th>Competencies</th>
		<th>Required Level</th>
		<th>Criticality</th>
	</tr>
	</thead>
	<tbody>
	<?php
	foreach($competencies as $competency){
		if($competency['comp_position_id']==$posdetails['position_id']){
	?>
		<tr>
			<td><?php echo $competency['comp_def_name']; ?></td>
			<td><?php echo $competency['scale_name']; ?></td>
			<td><?php echo $competency['comp_cri_name']; ?></td>
		</tr>
	<?php
		}
	}
	?>
	</tbody>
</table>
<?php } ?>
</div>
<div style="page-break-after: always;"></div>

</body>
<div id="overlay2"><img src="public/PDF/images/cms/interviewbookletback.jpg" width="100%"></div>