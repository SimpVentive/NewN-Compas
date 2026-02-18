<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  
  <title>Case Study/Caselet Exercise</title>
  <link href="https://fonts.googleapis.com/css?family=Hind:400,700&amp;subset=devanagari,latin-ext" rel="stylesheet">
  <style type="text/css">
	@page {
	  margin: 0;
	}
	html { margin: 0px}
	.flyleaf {
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
		font-family: "Hind";
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
		background-image: url('public/PDF/images/cms/intray.jpg');
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
		margin-top: -2.5cm !important;
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
	<div id="overlay"><img src="public/PDF/images/cms/casestudy.jpg" width="100%"> </div>
	<img src="<?php echo LOGO_IMG; ?>" width="176" height="66" class="fish"> 
	<label class="fish1"><b style="font-size:22px;color:#414142;">Case Study/Caselet Exercise<br><?php echo @$case_study['casestudy_name']; ?></b></label>
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
		<?php $aa=defined('LOGO_IMG2')?TRUE:FALSE; if($aa){ ?><img src="<?php echo LOGO_IMG2; ?>" style="margin:0.15cm 0.2cm;float:right;" width="176" height="66"><?php } ?>
	</div>
	<div class="footer">
	  <div style="text-align: right; color:#000;margin-right:10px;">N-Compass.com</div>
	</div>
<div class="body">
<h2 style="text-align:center;font-family: Hind"><?php echo @$case_study['casestudy_name']; ?></h2><p>&nbsp;</p>


<?php if(!empty($case_study['casestudy_description'])){ ?>
<h4 class="titleheader">Descripton</h4>
<div><?php echo nl2br($case_study['casestudy_description']); ?></div>
<?php } ?>
</div>
<div style="page-break-after: always;"></div>
<div class="body">

<h4 class="titleheader">Case Study Questions</h4>
<?php 
foreach($case_study_questions as $case_study_question){ ?>
<div><b><?php echo nl2br($case_study_question['casestudy_quest']); ?></b></div>
<table cellpadding="1" cellspacing="1" id="edit_datable_2" class="table table-hover table-bordered mb-0">
	<thead>
		<tr>
			<th class="col-sm-8">Competency Name</th>
			<th class="col-sm-4">Level Name</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$comp_details=UlsCaseStudyCompMap::getcasestudycompetencies($case_study_question['casestudy_quest_id']);
	foreach($comp_details as $comp_detail){
	?>
		<tr>
			<td><?php echo $comp_detail['competencies_name']; ?></td>
			<td><?php echo $comp_detail['level_name']; ?></td>
		</tr>
	<?php
	}
	?>
	</tbody>
</table>
<?php } ?>


</div>
</body>
<div style="page-break-after: always;"></div>
<div id="overlay2"><img src="public/PDF/images/cms/interviewbookletback.jpg" width="100%"></div>