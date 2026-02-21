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
$path = BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['pos_id'].'/'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'_radar.svg';
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = url_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

$pathnew = BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['pos_id'].'/'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'_radar2.svg';
$typen = pathinfo($pathnew, PATHINFO_EXTENSION);
$datan = url_get_contents($pathnew);
$base64_new = 'data:image/' . $typen . ';base64,' . base64_encode($datan);

$path1 = BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['pos_id'].'/'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'_bar.svg';
$type1 = pathinfo($path1, PATHINFO_EXTENSION);
$data1 = url_get_contents($path1);
$base64_bar = 'data:image/' . $type1 . ';base64,' . base64_encode($data1);


$path_emp = BASE_URL.'/public/uploads/profile_pic/'.$_REQUEST['emp_id'].'/'.$emp_info['photo'];
$type_emp = pathinfo($path_emp, PATHINFO_EXTENSION);
$data_emp = url_get_contents($path_emp);
$base64_emp = 'data:image/' . $type_emp . ';base64,' . base64_encode($data_emp);
$path_water = BASE_URL.'/public/SAMPLE.png';
$type_water = pathinfo($path_water, PATHINFO_EXTENSION);
$data_water = url_get_contents($path_water);
$base64_water = 'data:image/' . $type_water . ';base64,' . base64_encode($data_water);
?>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  
  <title>Employee Skill Report</title>
  
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
		line-height: 13px;
		font-family: "Helvetica,sans-serif" !important;
	}
	ol li {
		font-size: 10px;
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
	#watermark {
		position: fixed;

		/** 
			Set a position in the page for your image
			This should center it vertically
		**/
		bottom:   0cm;
		left:     -2cm;

		/** Change image dimensions**/
		width:    25cm;
		height:   30cm;

		/** Your watermark should be behind every content**/
		z-index:  -1000;
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
		<img src="<?php echo LOGO_IMG; ?>" style="float:right;margin:0.15cm 0.2cm" width="150" height="40"> 
		
	</div>

	<div class="footer">
	  <div style="text-align: right;color:#000;margin-right:50px;font-size: 10px;font-family: Helvetica,sans-serif !important;">www.N-Compas.com</div>
	</div>

	
	<div class="body">
		
		<h4 style="text-align:center;padding-left:20px;">Summary Assessment Report of <b style="font-size:14pt;"><?php echo $emp_info['full_name']; ?></b></h4>
		<table cellspacing="0" cellpadding="5" style="border:1px solid #36a2eb;">
			<tr bgcolor="#f1f1f1">
				<td width="39%">
					<p>Name:<?php echo $emp_info['full_name']; ?></p>
					<p>Education:<?php echo $emp_info['qualification']; ?></p>
					<p>Designation:<?php echo $emp_info['position_name']; ?></p>
					<p>Unit:<?php echo $emp_info['location_name']; ?></p>
				</td>
				<td width="39%">
					<p>Employee ID:<?php echo $emp_info['employee_number']; ?></p>
					<p>DOJ:<?php echo date('dS F Y',strtotime($emp_info['date_of_joining']));?></p>
					<p>Department:<?php echo $emp_info['org_name']; ?></p>
					<p>Supervisor:<?php echo $emp_info['hod']; ?></p>
				</td>
				<td width="22%"><img src="<?php echo $base64_emp;?>" style="width:140px;height:130px;padding-top:5px; "/></td>
				
			</tr>
		</table>
		
		<h4 class="titleheader" style="font-size:9pt;"><b style="font-size:9pt;">A. Acceptance of Job Description </b></h4>
		<p>Employee has accepeted his Job Role on <b>Date:<?php echo date('dS F Y',strtotime($emp_info['pos_conf_date']));?> (<b style="font-size:7pt;">Please find the annexure at the bottom</b>)</b></p>
		<?php 
		$report=UlsAssessmentEmployees::get_assessment_employees_report($_REQUEST['emp_id'],$_REQUEST['pos_id']);
		foreach($report as $reports){
			$ass_test=UlsAssessmentTest::get_ass_position_test($reports['assessment_id'],$reports['position_id'],'TEST');
			$report_detail_leveltwo=UlsAssessmentTestQuestions::get_test_questions_report($ass_test['assess_test_id'],$ass_test['test_id'],$ass_test['assessment_id'],$_REQUEST['emp_id']);
			
		?>
		<h4 class="titleheader" style="font-size:9pt;"><b style="font-size:9pt;">B. Skill Assessment Question common for all operator</b></h4>
		<br style="clear:both;">
		<div style="float:left;width:60%">
			<table width="100%" align="top" style="float:left;">
				<thead>
					
					<tr  class="row header">
						<th width="35%">Knowledge</th>
						<th width="20%">Bench Mark</th>
						<th width="20%">Marks</th>
					</tr>
				</thead>
				<tbody>
				<?php 
				foreach($report_detail_leveltwo as $report_detail_leveltwos){
				?>
					<tr>
						<td>Knowledge Part - A </td>
						<td>12</td>
						<td>15</td>
					</tr>
				<?php
				}
				?>
					<tr  style="background:yellow;">
						<td>Skill Score</td>
						<td>3</td>
						<td>4</td>
					</tr>
					<tr>
						<td colspan='2'>Total Score</td>
						<td>19</td>
					</tr>
					<tr>
						<td colspan='2'>Total Marks</td>
						<td>25</td>
					</tr>
					<tr>
						<td colspan='2'><b>% Marks Secured in L-1 to L-2</b></td>
						<td><b>76%</b></td>
					</tr>
				</tbody>
			</table>
			
			
		</div>
		
		<div style="float:right;width:40%"><img src="<?php echo $base64_bar; ?>" height="200px;" style=""/></div>
		<br style="clear:both;">
		
		<h4 class="titleheader"  style="font-size:9pt;"><b style="font-size:9pt;">C. Skill Assessment for specific Operator Role</b></h4>
		<div style="float:left;width:55%">
			<table width="100%" align="top" style="float:left;">
				<thead>
					
					<tr  class="row header">
						<th width="35%">Knowledge</th>
						<th width="20%">Bench Mark</th>
						<th width="20%">Marks</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Safety </td>
						<td>8</td>
						<td>8</td>
					</tr>
					<tr>
						<td>Quality</td>
						<td>6</td>
						<td>9</td>
					</tr>
					<tr>
						<td>Process</td>
						<td>8</td>
						<td>9</td>
					</tr>
					<tr>
						<td>System</td>
						<td>6</td>
						<td>9</td>
					</tr>
					<tr>
						<td>5s, TPM</td>
						<td>6</td>
						<td>9</td>
					</tr>
					<tr>
						<td>Engineering</td>
						<td>5</td>
						<td>5</td>
					</tr>
					<tr style="background:yellow;">
						<td>Skill Score</td>
						<td>7</td>
						<td>7</td>
					</tr>
					<tr>
						<td colspan='2'>Total</td>
						<td>56</td>
					</tr>
					<tr>
						<td colspan='2'>Total Marks</td>
						<td>70</td>
					</tr>
					<tr>
						<td colspan='2'><b>% Marks Secured in L-2 to L-3</b></td>
						<td><b>80%</b></td>
					</tr>
				</tbody>
			</table>
			
			
		</div>
		
		<div style="float:right;width:45%"><img src="<?php echo $base64;?>" style="width:310px;height:290px;padding-top:-28px; "/></div>
		<div style="page-break-after: always;"></div>
		<h4 class="titleheader"  style="font-size:9pt;"><b style="font-size:9pt;">D. Skill Assessment process for Multiscale Operator Role </b></h4>
		<br style="clear:both;">
		<p>Assessor for Position:Mill Man : <b>Bibhuti Prasad Dash</b></p>
		<div style="float:left;width:55%">
			<table width="100%" align="top" style="float:left;">
				<thead>
					<tr class="row header">
						<th colspan="3"><b style="text-align:center;font-size:9pt;">Job Roll - Mill Man</b></th>
					</tr>
					<tr  class="row header">
						<th width="35%">Knowledge</th>
						<th width="20%">Bench Mark</th>
						<th width="20%">Marks</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Safety </td>
						<td>8</td>
						<td style="color:red;">7</td>
					</tr>
					<tr>
						<td>Quality</td>
						<td>6</td>
						<td>8</td>
					</tr>
					<tr>
						<td>Process</td>
						<td>8</td>
						<td>9</td>
					</tr>
					<tr>
						<td>System</td>
						<td>6</td>
						<td>8</td>
					</tr>
					<tr>
						<td>5s, TPM</td>
						<td>6</td>
						<td>10</td>
					</tr>
					<tr>
						<td>Engineering</td>
						<td>5</td>
						<td>7</td>
					</tr>
					<tr style="background:yellow;">
						<td>Skill Score</td>
						<td>7</td>
						<td>7</td>
					</tr>
					<tr>
						<td colspan='2'>Total</td>
						<td>56</td>
					</tr>
					<tr>
						<td colspan='2'>Total Marks</td>
						<td>70</td>
					</tr>
					<tr>
						<td colspan='2'><b>% Marks Secured in L-3 to L-4</b></td>
						<td><b>80%</b></td>
					</tr>
				</tbody>
			</table>
			
			
		</div>
		
		<div style="float:right;width:45%"><img src="<?php echo $base64_new; ?>" style="width:310px;height:290px;padding-top:-28px; "/></div>
		<br style="clear:both;">
		<?php } ?>
		<h4 style="text-align:center;padding-left:20px;">Job Description of <b style="font-size:14pt;">Mixer Operator</b></h4>
		
		<h4>Position Details</h4>
		<table >
			<tr bgcolor="#deeaf6">
				<td class="normal"  style="width:15%"><b>Job Title</b></td>
				<td class="normal"  style="width:35%"><?php echo @$posdetails['position_name'];?></td>
				<td class="normal"  style="width:15%"><b>Grade/Level</b></td>
				<td class="normal"  style="width:35%"><?php echo @$posdetails['grade_name'];?></td>
			</tr>
			<tr>
				<td class="normal"><b>Department</b></td>
				<td class="normal"><?php echo @$posdetails['position_org_name'];?></td>
				<td class="normal"><b>Section</b></td>
				<td class="normal"><?php echo @$posdetails['section_org'];?></td>
			</tr>
			<tr  bgcolor="#deeaf6">
				<td class="normal"><b>Location</b></td>
				<td class="normal"><?php echo @$posdetails['location_name'];?></td>
				<td class="normal"><b>Work Area</b></td>
				<td class="normal"><?php echo @$posdetails['workarea'];?></td>
			</tr>
		</table>
		<br style="clear:both;">
		<h4>Reporting Relationships</h4>
		<table>
			<tr>
				<td style="width:25%"><b>Reports to</b></td><td class="normal" style="width:75%"><?php echo @$posdetails['reportsto'];?></td>
			</tr>
			<tr bgcolor="#deeaf6">
				<td style="width:25%"><b>Reportees</b></td><td class="normal" style="width:75%"><?php echo @$posdetails['reportees_name'];?></td>
			</tr>
		</table>
		<br style="clear:both;">
		<h4>Position Description</h4>
		<table>
			<tr>
				<td style="width:25%"><b>Education Background</b></td><td class="normal" style="width:75%"><?php echo strip_tags(@$posdetails['education']);?></td>
			</tr>
			<tr bgcolor="#deeaf6">
				<td style="width:25%"><b>Experience</b></td><td class="normal" style="width:75%"><?php echo strip_tags(@$posdetails['experience']);?></td>
			</tr>
			<tr>
				<td style="width:25%"><b>Industry Experience</b></td>
				<td class="normal" style="width:75%"><?php echo strip_tags(@$posdetails['specific_experience']);?></td>
			</tr>

		</table>
		<?php
		if(!empty($posdetails['other_requirement'])){
		?>
		<div style="page-break-after: always;"></div>
		<h4>Reports to be made/ Data to be generated</h4><?php echo @$posdetails['other_requirement'];?>
		<?php
		}
		?>
		<br style="clear:both;">
		<h4>Purpose</h4><?php echo @$posdetails['position_desc'];?>
		<?php
		if(!empty($posdetails['interaction_with'])){
			$int_type=($posdetails['interaction_type']=='I')?"Internal":"External";
		
		?>
		<br style="clear:both;">
		<h4>Interactions</h4>
		<br><b>Interaction with:</b><?php echo @$posdetails['interaction_with'];?>
		<br><b>Internal/External:</b><?php echo $int_type;?>
		<br><b>Reason:</b><?php echo @$posdetails['interaction_reason'];?>
		<?php
		}
		?>
	</div>
</body>

