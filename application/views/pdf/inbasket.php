<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  
  <title>In-Basket Excerise</title>
  
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
	<div id="overlay"><img src="public/PDF/images/cms/intray.jpg" width="100%"> </div>
	<img src="<?php echo LOGO_IMG; ?>" width="176" height="66" class="fish"> 
	<label class="fish1"><b style="font-size:22px;color:#ffffff;">In-Basket Excerise<br><?php echo @$inbasket['inbasket_name']; ?></b></label>
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
<h2 style="text-align:center"><?php echo @$inbasket['inbasket_name']; ?></h2><p>&nbsp;</p>
<?php if(!empty($inbasket['inbasket_narration'])){ ?>
<h4 class="titleheader">In-Basket Narration</h4>
<div><?php echo nl2br($inbasket['inbasket_narration']); ?></div>
<?php } ?>
</div>
<div style="page-break-after: always;"></div>
<div class="body">
<?php 
if(!empty($inbasket['question_id'])){
$question_view=UlsQuestionValues::get_allquestion_values_competency($inbasket['question_id']);
$scorting=($inbasket['inbasket_scorting_order']=='Y')?"sortable":"";

$scorting_arrow=($inbasket['inbasket_scorting_order']=='Y')?"<span class='ui-icon ui-icon-arrowthick-2-n-s'></span>":"";
?>
<?php if(!empty($inbasket['inbasket_instructions'])){ ?>
<h4 class="titleheader">In-Basket Instruction</h4>
<div><?php echo nl2br($inbasket['inbasket_instructions']); ?></div>
<?php } ?>


	<?php 
	foreach($question_view as $key=>$question_views){
		if(!empty($question_views['inbasket_mode'])){
		$parsed_json = json_decode($question_views['inbasket_mode'], true);
		}
	?>
		<div class="portlet">
			<h4 class="titleheader"><?php echo $scorting_arrow; ?> Intray <?php echo $key+1; ?></h4>
			<div class="portlet-content">
				<p class="text-muted" style="font-weight:bold; float:right;">
					<b><?php echo $question_views['comp_def_name']; ?> (<code><?php echo $question_views['scale_name']; ?></code>)</b>
				</p>
				<br style="clear:both;">
				<?php
				if(!empty($parsed_json)){
					foreach($parsed_json as $key => $value)
					{
						$yes_stat="IN_MODE";
						$val_code=UlsAdminMaster::get_value_name_statuss($yes_stat,$value['mode']);
					?>
					   <p><code>Mode:</code><?php echo $val_code['name'];?></p>
					   <p><code>Time:</code><?php echo $value['period'];?></p>
					   <p><code>From:</code><?php echo $value['from'];?></p>
					<?php
					}
				}
				?>
				<p class="text-muted"><?php echo nl2br($question_views['text']); ?></p>
			</div>
		</div><br><br>
	<?php } ?>

<?php } ?>
</div>
</body>
<div style="page-break-after: always;"></div>
<div id="overlay2"><img src="public/PDF/images/cms/interviewbookletback.jpg" width="100%"></div>