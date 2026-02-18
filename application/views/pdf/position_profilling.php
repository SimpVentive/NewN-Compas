<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  
  <title>Job Profile for <?php echo @$posdetails['position_name']; ?></title>
  
  <style type="text/css">
	@page {
	  margin: 0;
	}
	html { margin: 0px}
	.flyleaf {
		page-break-after: always;
		page-break-after: always;
		z-index: -1;
		margin-top: -2.5cm !important;
	}
	body{
		margin:0px;
		padding:0px;
		margin-top: 2.5cm !important;
	}
	
	div.body {
		//margin-top: 2.5cm !important;
		margin-bottom: 1.1cm !important;
		margin-left: 1.5cm !important;
		margin-right: 1.5cm !important;
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
		margin-bottom:1.5cm;
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
		margin-top:0;
		margin-bottom:0;
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
	div.leftpane2 {
		position: fixed;
		background: #fff;
		width: 10%;
		border-bottom-width: 1px solid #2286c9;
		border-left: 3px solid #fff;
		overflow: hidden;
		padding: 0.1cm;
		top: 0cm;
		left: 1cm;
		height: 3cm;
	}
	div.leftpane3 {
		position: fixed;
		background: #fff;
		width: 10%;
		border-top: 1px solid #2286c9;
		border-left: 3px solid #fff;
		overflow: hidden;
		padding: 0.1cm;
		bottom: 0cm;
		left: 1cm;
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
		font-family: "rockwell";
		color:#5E5B5C;
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
    /*tbody tr:nth-child(even){
		background: #F6F5FA;
    }
    tbody tr:hover{
		background: #EAE9F5
    }*/
	
	div.test {
        color: #fff;
        background-color: #ea6153;
        font-family: helvetica;
        font-size: 10pt;
        border-style: solid solid solid solid;
        border-width: 2px 2px 2px 2px;
        border-color: #ea6153;
        text-align: center;
    }
	p#second {
        color: rgb(00,63,127);
        font-family: times;
        font-size: 12pt;
        text-align: justify;
    }
	#overlay {
		position: absolute;
		top: 0;
		left: 0;
		height: 100%;
		width: 100%;
		margin:0px;
		padding:0px;
		margin-top: -2.5cm !important;
		background-position: center top;
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
		margin-top: -2.5cm !important;
		background-position: left top;
		background-repeat: no-repeat;
		z-index: 9999;
	}
	.fish { position: absolute; top: 20px; right: 20px; }
	.fish1 { position: absolute; top: 126px; left: 40px; text-align:left; }
	.titleheader {
		background: #999;
		color:#fff;
		border: 1px solid #333;
		border-radius: 0.25rem;
		margin-bottom: 1rem;
		padding: 0.60rem 1.25rem;
		position: relative;
		
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
  </style>
  
</head>


<div class="flyleaf">
	<div id="overlay"><img src="public/PDF/images/cms/compprofront.jpg" width="100%"></div>
	<img src="<?php echo LOGO_IMG; ?>" width="176" height="66" class="fish"> 
	<label class="fish1"><b style="font-size:24px;color:#084b86;text-align: right;">COMPETENCY PROFILE</b><br><b style="font-size:20px;color:#414142;"><?php echo @$posdetails['position_name']; ?></b></label>
	

</div>
<body  class="body">
<div class="leftpane">
  <div style="text-align: center;">
		
	</div>
</div>
<div class="rightpane">
  <div style="text-align: center;">
		
	</div>
</div>

<div class="header">
	<img src="<?php echo LOGO_IMG; ?>" style="margin:0.15cm 0.2cm" width="176" height="66">
	<?php $aa=defined('LOGO_IMG2')?TRUE:FALSE; if($aa){ ?><img src="<?php echo LOGO_IMG2; ?>" style="margin:0.15cm 1.2cm;float:right;" width="176" height="66"><?php } ?>
</div> 

<div class="footer">
 <div style="text-align: right;color:#000;margin-right:10px;">N-Compas.com</div>
</div>
<div class="body">
<h2 class="title">Position Name : <i style="color:#990000"><?php echo @$posdetails['position_name']; ?></h2>
<p>&nbsp;</p>
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
			$comp=!empty($competency['comp_def_name_alt'])?$competency['comp_def_name_alt']:$competency['comp_def_name'];
	?>
		<tr>
			<td><?php echo $comp; ?></td>
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
		foreach($kras as $kra){
			if($kra['comp_position_id']==$posdetails['position_id']){
				echo "<tr><td>".$kra['kra_master_name']."</td><td>".$kra['kra_kri']."</td><td>".$kra['kra_uom']."</td></tr>";
			}
		} ?>

	
		</tbody>
	</table>
</div>
<?php } ?>
<div>
<?php
foreach($category as $categorys){
	$competencies=UlsCompetencyPositionRequirements::getcompetencypositionrequirements_cat($_REQUEST['posid'],$categorys['category_id']);
	foreach($competencies as $competency){
	if($competency['comp_position_id']==$posdetails['position_id']){
		$comp_n=!empty($competency['comp_def_name_alt'])?$competency['comp_def_name_alt']:$competency['comp_def_name'];
		$indicators=UlsCompetencyDefLevelIndicator::getcompdeflevelind_details($competency['comp_def_id'],$competency['scale_id']);
	?>
	<div style="page-break-after: always;"></div>	
	<div class="body">
		<div class="test">
			<p><b style="font-size:15px;"><?php echo $comp_n;?></b></p>
			<p><b><?php echo $competency['scale_name'];?></b></p>
			<p><b>Criticality:<?php echo $competency['comp_cri_name'];?></b></p>
		</div>
		<h4 class="titleheader">Level Indicators</h4>
		<ul>
		<?php
		if(count($indicators)>0){
			foreach($indicators as $k=>$indicator){$k++;
				echo "<li>".$indicator['comp_def_level_ind_name']."</li>";
			}
		}
		else{
			echo "<li>No Indicators has been added to this competency</li>";
		}
		?>
		</ul>
	</div>

<?php }
	}
}	?>
</div>
</body>
<div id="overlay2"><img src="public/PDF/images/cms/compproback.jpg" width="100%"></div>