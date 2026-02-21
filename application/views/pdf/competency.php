<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">  
  <title><?php echo !empty($compdetails['comp_def_name_alt'])?$compdetails['comp_def_name_alt']:$compdetails['comp_def_name']; ?> Competency</title>  
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
		margin-top: 3cm;
		margin-bottom: 1.7cm;
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
		font-family: sans-serif;
		color:#5E5B5C;
    }
    thead th{
		text-align: left;
		padding: 10px;
    }
    tbody td{
		border: 1px solid #e3e3e3;
		padding: 2px 5px;
    }
   
	.titleheader {
		background: #999;
		color:#fff;
		border: 1px solid #333;
		border-radius: 0.25rem;
		margin-bottom: 1rem;
		padding: 0.60rem 1.25rem;
		position: relative;
		
	}
	.titleheader2 {
		background: #ea6153;
		color:#fff;
		border: 1px solid #ea6153;
		border-radius: 0.25rem;
		margin-bottom: 1rem;
		padding: 0.60rem 1.25rem;
		position: relative;
		
	}
	
	#overlay {
		position: absolute;
		top: 0;
		left: 0;
		height: 100%;
		width: 100%;
		
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
		background-position: left top;
		background-repeat: no-repeat;
		z-index: 9999;
	}
	.fish { position: absolute; top: 20px; right: 20px; }
	.fish1 { position: absolute; top: 126px; right: 10px; text-align:right; }
	
	ul,ol,li{
		margin:0px 5px;
		padding:0px;
	}
  </style>
  
</head>

<div class="flyleaf">
	<div id="overlay"><img src="public/PDF/images/cms/competency.jpg" width="100%"></div>
	<img src="<?php echo LOGO_IMG; ?>" style="margin:0.15cm 0.2cm" width="176" height="66" class="fish"> 
	<label class="fish1"><b style="font-size:22px;color:#414142;text-align: left;"><b>COMPETENCY DETAILS OF </b><br><?php echo !empty($compdetails['comp_def_name_alt'])?$compdetails['comp_def_name_alt']:$compdetails['comp_def_name']; ?></b></label>
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
	<h2 class="title"><?php echo !empty($compdetails['comp_def_name_alt'])?$compdetails['comp_def_name_alt']:$compdetails['comp_def_name']; ?> <small>(<?php echo @$compdetails['category']; echo !empty($compdetails['subcategory'])?", ".$compdetails['subcategory']:""; ?>)</small></h2>
	<h4 class="titleheader">Description:</h4><p><?php echo @$compdetails['comp_def_short_desc']; ?></p>
	
	<h4 class="titleheader">Key Indicators</h4>
		<div id="tab-keyind" class="tab-pane active">
			<div class="panel-body">
				<?php echo @$compdetails['comp_def_key_indicator']; ?>
			</div>
		</div>
		
	<h4 class="titleheader">Key Coverage Aspects</h4>
		<div id="tab-keycov" class="tab-pane">
			<div class="panel-body">
				<?php echo @$compdetails['comp_def_key_coverage']; ?>
			</div>
		</div>
</div>

<?php 
$j=0; 
foreach($levels as $level){
	$class=($j==0)?"active":""; $j++;?>
	<div style="page-break-after: always;"></div>
	<div class="body">
	<div class="titleheader2"><?php echo $level['scale_name']; ?></div>
	<h4 class="titleheader">Indicators</h4>
	<?php $tmp="";
	foreach($levelindicators as $indicator){
		if($indicator['comp_def_level_id']==$level['scale_id']){
			if($tmp!=$indicator['comp_def_level_ind_type']){
				echo !empty($tmp)?"<strong>".$indicator['ind_master_name']."</strong>
				":"<strong>".$indicator['ind_master_name']."</strong>
					";
					$tmp=$indicator['comp_def_level_ind_type'];
			}
			echo "<ul><li style='line-height: 1.0em;height: auto;'>".$indicator['comp_def_level_ind_name']."</li></ul>";
		}
	} ?>
	<h4 class="titleheader">Migration Maps</h4>
	<ul>
	<?php
	foreach($levelmigrationmaps as $migrate){														
		if($migrate['comp_def_level_ind_id']==$level['scale_id']){															
			echo "<li>".$migrate['migrate_type']." ".$migrate['comp_def_level_migrate_oth']."</li>";
		}
	} ?>
	</ul>
	<h4 class="titleheader">Assessment Methods</h4>
	<ul>
	<?php
	foreach($levelassessments as $assessment){														
		if($assessment['comp_def_level_ind_id']==$level['scale_id']){															
			echo "<li>".$assessment['assess_method']."</li>";
		}
	} ?>
	</ul>
	</div>
<?php 
} ?>					
<div style="page-break-after: always;"></div>
</body>
<div id="overlay2"><img src="public/PDF/images/cms/compproback.jpg" width="100%"></div>