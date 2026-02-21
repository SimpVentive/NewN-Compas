<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  
  <title>Job Profile for <?php echo @$posdetails['position_name']; ?></title>
  
  <style type="text/css">
	@page {
	  margin: 0;
	}
	
	body {
		margin-top: 2.5cm;
		margin-bottom: 1cm;
		margin-left: 1.5cm;
		margin-right: .5cm;
		font-family: sans-serif;
		text-align: justify;
		color:#5E5B5C;
	}
	
	div.header,
	div.footer {
	  position: fixed;
	  background: #3498db;
	  color:#fff;
	  width: 100%;
	  /*border: 0px solid #2286c9;*/
	  overflow: hidden;
	  padding: 0.1cm;
	}
	
	div.leftpane {
		position: fixed;
		background: #3498db;
		width: 1cm;
		/*border-right: 1px solid #2286c9;*/
		top: 0cm;
		left: 0cm;
		height: 30cm;
	}
	div.leftpane2 {
		position: fixed;
		background: #3498db;
		width: 10%;
		border-bottom-width: 1px solid #2286c9;
		border-left: 3px solid #3498db;
		overflow: hidden;
		padding: 0.1cm;
		top: 0cm;
		left: 1cm;
		height: 3cm;
	}
	div.leftpane3 {
		position: fixed;
		background: #3498db;
		width: 10%;
		border-top: 1px solid #2286c9;
		border-left: 3px solid #3498db;
		overflow: hidden;
		padding: 0.1cm;
		bottom: 0cm;
		left: 1cm;
		height: 1cm;
	}
	div.header {
		top: 0cm;
		left: 0cm;
		border-bottom-width: 1px;
		height: 2cm;
	}
	
	div.footer {
		bottom: 0cm;
		left: 0cm;
		border-top-width: 1px;
		height: 1cm;
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
		font-family: arial;
		color:#5E5B5C;
    }
    thead th{
		text-align: left;
		padding: 10px;
    }
    tbody td{
		border-top: 1px solid #e3e3e3;
		padding: 10px;
    }
    tbody tr:nth-child(even){
		background: #F6F5FA;
    }
    tbody tr:hover{
		background: #EAE9F5
    }
  </style>
  
</head>

<body>

<div class="header">
	<img src="<?php echo LOGO_IMG; ?>" style="margin:0.15cm 0.9cm" width="176" height="66"> 
</div>

<div class="footer">
  <div style="text-align: right;">On line footer content aligned to the right.</div>
</div>

<div class="leftpane">
  <div style="text-align: center;">
		
	</div>
</div>

<h2 style="text-align:center">Job Profile</h2>
<div>
	<div style="float:left;width:20%">
		<b>Job Title</b>
	</div>
	<div style="float:left;width:80%">
		<?php echo @$posdetails['position_name']; ?>
	</div>
</div>
<br style="clear:both;">
<div>
	<div style="float:left;width:20%">
		<b>Reports to</b>
	</div>
	<div style="float:left;width:80%">
		<?php echo @$posdetails['reportsto']; ?>
	</div>
</div>
<br style="clear:both;">
<div>
	<div style="float:left;width:20%">
		<b>Reportees</b>
	</div>
	<div style="float:left;width:80%">
		<?php echo @$posdetails['reportees_name']; ?>
	</div>
</div>
<br style="clear:both;">
<div>
	<div style="float:left;width:20%">
		<b>Function</b>
	</div>
	<div style="float:left;width:80%">
		<?php echo @$posdetails['position_org_name']; ?>
	</div>
</div>
<br style="clear:both;">
<div>
	<div style="float:left;width:20%">
		<b>Location</b>
	</div>
	<div style="float:left;width:80%">
		<?php echo @$posdetails['location_name']; ?>
	</div>
</div>
<br style="clear:both;">
<div style=" border-bottom:1px solid #3498db;"></div><br>
<b>Purpose Statement</b>
<div><?php echo @$posdetails['position_desc']; ?></div>
<br>
<b>Accountabilities</b>
<div><?php echo @$posdetails['accountablities']; ?></div>
<br>
<b>Education Background</b>
<p><?php echo @$posdetails['education']; ?></p>
<br>
<b>Experience</b>
<p><?php echo @$posdetails['experience']; ?></p>
<br>
<b>Industry Specific Experience</b>
<p><?php echo @$posdetails['specific_experience']; ?></p><br>
<?php if(!empty($posdetails['other_requirement'])){ ?>
<b>Other Requirements</b>
<div>
<p>
<?php echo @$posdetails['other_requirement']; ?>
</p>
</div>
<?php } ?>
<b> Competency Requirements</b>
<table>
	<thead>
		<tr>
			<th class="normal">Competencies</th>
			<th class="normal">Required Level</th>
			<th class="normal">Criticality</th>
		</tr>
	</thead>
	<tbody>
		<?php //<td>".$competency['level_name']."</td>
		foreach($competencies as $competency){
		if($competency['comp_position_id']==$posdetails['position_id']){
		$hash=SECRET.$competency['comp_def_id'];
		echo "<tr><td>".$competency['comp_def_name']."</td>
		<td>".$competency['scale_name']."</td>
		<td>".$competency['comp_cri_name']."</td></tr>";
		}
		} ?>
	</tbody>
</table>
<br>
<?php if(count($kras)>0){ ?>
<b> Key Result Areas</b>
<table>
	<thead>
	<tr>
		<th>KRA</th>
	</tr>
	</thead>
	<tbody>
	<?php
	foreach($kras as $kra){
		if($kra['comp_position_id']==$posdetails['position_id']){
			echo "<tr><td>".$kra['kra_master_name']."</td></tr>";
		}
	} ?>
	</tbody>
</table>
<?php } ?>
<br><br>
<div style="width:100%">
	<div style="float:left;width:15%">
		<b>Signature</b>
	</div>
	<div style="float:left;width:85%">
		.................................................................
	</div>
	 
</div><br style="clear:both;">
<div style="width:100%">
	<div style="float:left;width:15%">
		<b>Job Holder</b>
	</div>
	<div style="float:left;width:85%">
		.................................................................
	</div>
</div><br style="clear:both;">
<div style="width:100%">
	<div style="float:left;width:15%">
		<b>Date</b>
	</div>
	<div style="float:left;width:85%">
		.................................................................
	</div>
</div><br style="clear:both;">
<div style="width:100%">
	<div style="float:left;width:15%">
		<b>Manager</b>
	</div>
	<div style="float:left;width:85%">
		.................................................................
	</div>
</div><br style="clear:both;"><br>
<p>..................................................................................................................................................................<br><br>
..................................................................................................................................................................<br><br>
..................................................................................................................................................................<br><br>
..................................................................................................................................................................<br><br>
..................................................................................................................................................................</p>

</body>