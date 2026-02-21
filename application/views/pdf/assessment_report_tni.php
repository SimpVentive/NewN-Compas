<?php
function url_get_contents ($Url) {
    if (!function_exists('curl_init')){ 
        die('CURL is not installed!');
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}


?>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  
  <title>TRAINING PROGRAM DESIGN OUTLINE</title>
  
  <style type="text/css">
	@page {
	  margin: 0;font-family: "Helvetica,sans-serif" !important;
	}
	html { margin: 0px;font-family: "Helvetica,sans-serif" !important;}
	.flyleaf {
		page-break-after: always;
		z-index: -1;
		margin-top: -2.5cm !important;
		font-family: "Helvetica,sans-serif" !important;
	}
	body{
		margin:0px;
		padding:0px;
		margin-top: 2.2cm !important;
		
		font-family: "Helvetica,sans-serif" !important;
		font-size: 14px;
	}
	div.body {
		margin-left: 1.5cm !important;
		margin-right: 1.5cm !important;
		color:#000;
		font-family: "Helvetica,sans-serif" !important;
		font-size: 14px;
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
		background-position: left top;
		background-repeat: no-repeat;
		z-index: 9999;
	}
	
	div.header{
		position: fixed;
		background: #fff;
		color:#fff;
		width: 100%;
		border-bottom:1px solid #2073EE;
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
		border-top:1px solid #2073EE;
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
		border-right: 1px solid #2073EE;
		top: 0cm;
		left: 0cm;
		height: 30cm;
	}
	
	div.rightpane {
		position: fixed;
		background: #fff;
		width: 1cm;
		border-left: 1px solid #2073EE;
		top: 0cm;
		right: 0cm;
		height: 30cm;
	}

	
	div.footer table {
	  width: 100%;
	  text-align: center;
	}
	
	/* hr {
	  page-break-after: always;
	  border: 0;
	} */
	table{
		width:100%;
		border-collapse: collapse;
		font-family: "Helvetica,sans-serif" !important;
		color:#000;
		font-size: 12px;
    }
    thead th{
		text-align: left;
		padding: 5px;
		border: 1px solid #e3e3e3;
		font-family: "Helvetica,sans-serif" !important;
		font-size: 11px;
		text-align: left;
    }
    tbody td{
		border: 1px solid #e3e3e3;
		padding: 5px;
		font-family: "Helvetica,sans-serif" !important;
		color:#000;
		font-size: 11px;
		
    }
    /*tbody tr:nth-child(even){
		background: #F6F5FA;
    }
    tbody tr:hover{
		background: #EAE9F5
    }*/
	
	div.test {
		color: #000;
		background-color: #FFF;
		font-family: helvetica;
		font-size: 10pt;
		border-style: solid solid solid solid;
		border-width: 2px 2px 2px 2px;
		border-color: #BC6F74;
		font-family: "Helvetica,sans-serif" !important;
		
	}
	p#second {
        color: rgb(00,63,127);
        font-family: times;
        font-size: 12pt;
        text-align: justify;
    }
	.fish { position: absolute; top: 570px; left: 150px; }
	.fish1 { position: absolute; top: 300px; left: 100px; text-align:left;}
	.fish5 { position: absolute; top: 20px; text-align:right;right: 20px;}
	.headinfo { 
	   position: absolute; 
	   bottom: 200px; 
	   left: 0; 
	   width: 100%; 
	}
	.card-view.panel.panel-default > .panel-heading {
		background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
		border-bottom: 2px solid #eee;
	}
	.card-view.panel > .panel-heading {
		border: medium none;
		border-radius: 0;
		color: inherit;
		margin: -28px -15px 0;
		padding: 0px 15px;
	}
	h6, .panel-title {
		font-size: 16px;
		font-weight: 600;
		line-height: 24px;
		text-transform: capitalize;
		font-family: "Helvetica,sans-serif" !important;
	}
	.card-view {
		background: #fff none repeat scroll 0 0;
		border: medium none;
		border-radius: 0;
		box-shadow: 0 1px 11px rgba(0, 0, 0, 0.09);
		margin-bottom: 10px;
		margin-left: -10px;
		margin-right: -10px;
		padding: 15px 15px 0;
	}
	.card-view.panel .panel-body {
		padding: 20px 0;
	}
	p,span{
		font-size: 12px;
		line-height: 15px;
		font-family: "Helvetica,sans-serif" !important;
	}
	ol li {
		font-size: 12px;
		padding:0px;
		font-family: "Helvetica,sans-serif" !important;
	}
	ul li {
		font-size: 12px;
		padding:0px;
		font-family: "Helvetica,sans-serif" !important;
	}
	.title {
		border: 1px solid transparent;
		border-radius: 0.25rem;
		margin-bottom: 1rem;
		padding: 0.60rem 1.25rem;
		position: relative;
		border-color: #b8daff;
		background: #0077d3 none repeat scroll 0 0;
		color: #fff;
		
	}
	.titleheader {
		border: 1px solid #734021;
		border-radius: 0.25rem;
		margin-bottom: 0.5rem;
		padding: 0.40rem 1.20rem;
		position: relative;
		border-color: #734021;
		font-weight:bold;
		
	}
	.row.header {
		background: #ea6153 none repeat scroll 0 0;
		color: #ffffff;
		font-weight: 900;
	}
	#header {
		position: relative;
		left: auto;
		right: auto;
		width: 59%;
		float: right;
		padding:0px 18px 0px 0px;
	}

	#main-content {
		left: auto;
		right: auto;
		position: relative;
		width: 40%;
		float: right;
		padding:10px;

	}
	
	hr.style-one {
		border: 0;
		height: 1px;
		background: #333;
	}
	hr.new1 {
	  border-top: 0.5px solid black;
	}
  </style>
  
</head>


<body class="body">
	<div class="leftpane">
	  <div style="text-align: center;"></div>
	</div>
	<div class="rightpane">
	  <div style="text-align: center;"></div>
	</div>
	<div class="header">
		<img src="<?php echo LOGO_IMG; ?>" style="float:right;margin:0.15cm 0.2cm" width="150" height="54"> 
		
	</div>

	<div class="footer">
	  <div style="text-align: right;color:#000;margin-right:20px;font-size: 10px;font-family: Helvetica,sans-serif !important;">Report generated by <span style="color:green;text-decoration: underline;">www.N-Compas.com</span></div>
	</div>

	
	<div class="body">
		<h4 style="font-size:16pt;color:#2073EE;text-align:center;padding-left:20px;">TRAINING PROGRAM DESIGN OUTLINE</h4>
		<?php
		if($report_details['scale_number']==1){
			$level="Basic";
		}
		elseif($report_details['scale_number']==2){
			$level="Intermediate";
		}
		elseif(($report_details['scale_number']==3) || ($report_details['scale_number']==4)){
			$level="Advanced";
		}
		
		?>
		<p style="font-size:10pt;"><b>TOPIC :</b><?php echo $report_details['comp_def_name']; ?></p>
		<p style="font-size:10pt;"><b>LEVEL :</b><?php echo $level; ?></p>
		<p style="font-size:10pt;"><b>DURATION :</b><?php echo $report_details['program_duration']; ?> Days</p>
		<hr class="new1">
		<h4 style="font-size:9pt;"><b style="font-size:9pt;">The following are the broad coverage areas/topics </b></h4>
		<p><?php echo $report_details['program_design']; ?></p>
		<h4 style="font-size:9pt;">Suggested Trainer/Facilitator: <?php echo $report_details['trainer_name']; ?></h4>
		<h4 style="font-size:9pt;">Trainer is an <?php echo ($report_details['trainer_type']=='INT')?"Internal":"External"; ?>  resource</h4>
		<br style="clear:both;">
		
	</div>
</body>

