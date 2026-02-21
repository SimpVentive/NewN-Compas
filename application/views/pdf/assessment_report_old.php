
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  
  <title>NON-MANAGEMENT STAFF (NMS) TO MANAGEMENT STAFF (MS) ASSESSMENT PROCESS CIL</title>
  
  <style type="text/css">
	@page {
	  margin: 0;
	}
	.flyleaf {
    page-break-after: always;
		z-index: -1;
		margin-top: -2.5cm !important;
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
		margin-top: -2.5cm !important;
		background-image: url('public/PDF/images/cms/interviewbookletback.jpg');
		background-position: left top;
		background-repeat: no-repeat;
		z-index: 9999;
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
		font-family: sans-serif;
		color:#5E5B5C;
    }
    thead th{
		text-align: left;
		padding: 10px;
		border: 1px solid #e3e3e3;
    }
    tbody td{
		border: 1px solid #e3e3e3;
		padding: 10px;
    }
    /*tbody tr:nth-child(even){
		background: #F6F5FA;
    }
    tbody tr:hover{
		background: #EAE9F5
    }*/
	
	div.test {
        color: #CC0000;
        background-color: #FFFF66;
        font-family: helvetica;
        font-size: 10pt;
        border-style: solid solid solid solid;
        border-width: 2px 2px 2px 2px;
        border-color: green #FF00FF blue red;
        text-align: center;
    }
	p#second {
        color: rgb(00,63,127);
        font-family: times;
        font-size: 12pt;
        text-align: justify;
    }
	.fish { position: absolute; top: 240px; left: 170px; }
	.fish1 { position: absolute; bottom: 520px; left: 500px; }
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
  </style>
  
</head>


<div class="flyleaf">
	<div id="overlay"><img src="public/PDF/images/cms/competencyassessmentreport-full.jpg" width="100%"></div>
	<img src="<?php echo LOGO_IMG; ?>" style="margin:0.15cm 0.2cm" width="176" height="66" class="fish"> 
	<label class="fish1"><b style="font-size:22px;color:#fff;text-align: left;"><?php echo $posdetails['position_name']; ?></b></label>
</div>
<body class="body">
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
  <div style="text-align: right;color:#000;margin-right:50px;">N-Compas.com</div>
</div>

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
foreach($emp_infos as $emp_info){
	$ass_test=UlsAssessmentTest::get_ass_position($_REQUEST['ass_id'],$_REQUEST['pos_id'],'TEST');
	$ass_test_emp=UlsUtestAttemptsAssessment::getattempttest($_REQUEST['ass_id'],$ass_test['assess_test_id'],$ass_test['test_id'],$emp_info['employee_id']);
	foreach($ass_test_emp as $ass_test_emps){
	$path = BASE_URL.'/public/reports/graphs/nms/'.$_REQUEST['ass_id'].'/'.$ass_test_emps['employee_id'].'_'.$_REQUEST['pos_id'].'_pie.png';
	$type = pathinfo($path, PATHINFO_EXTENSION);
	$data = url_get_contents($path);
	$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

?>
<div class="body">
<h4 class="titleheader">Employee Details</h4>
<table>
	<tbody>
		<tr>
			<td class="normal"  style="width:15%"><b>Employee Name</b></td>
			<td class="normal"  style="width:35%"><?php echo $emp_info['full_name']; ?>&nbsp;</td>
		</tr>
		<tr>
			<td class="normal"><b>Employee Number</b></td>
			<td class="normal"><?php echo $emp_info['employee_number']; ?></td>
		</tr>
		<tr>
			<td class="normal"><b>Position</b></td>
			<td class="normal"><?php echo $emp_info['position_name']; ?></td>
		</tr>
	</tbody>
</table>

<h4 class="titleheader">Competency/Skill Requirements</h4>
<table>
	<thead>
	<tr class="row header">
		<th>Competency/Skill</th>
		<th>Level Requirement</th>
		<th>Criticality</th>
		<th>Weightage in Overall assessment</th>
	</tr>
	</thead>
	<tbody>
	<?php 
	$tmp="";
	foreach($competencies as $competency){
		$per_test=UlsAssessmentTest::get_ass_position($_REQUEST['ass_id'],$_REQUEST['pos_id'],'TEST');
		
		?>
		<tr>
			<td><?php echo $competency['comp_def_name']; ?></td>
			<td><?php echo $competency['scale_name']; ?></td>
			<td><?php echo $competency['comp_cri_name']; ?></td>
			<td>
			<?php
			//echo $competency['comp_cri_code'];
			if($tmp!=$competency['comp_cri_code']){
				$tmp=$competency['comp_cri_code'];
				if($competency['comp_cri_code']=='C1'){
					$cv=$per_test['c1'];
				}
				if($competency['comp_cri_code']=='C2'){
					$cv=$per_test['c2'];
				}
				if($competency['comp_cri_code']=='C3'){
					$cv=$per_test['c3'];
				}
				if($competency['comp_cri_code']=='C4'){
					$cv=$per_test['c4'];
				}
				if($competency['comp_cri_code']=='C5'){
					$cv=$per_test['c5'];
				}
				echo $cv;
			}
			
			
			
			?>
			</td>
		</tr>
		
		<?php
	}
	?>	
	</tbody>
</table>
<div style="page-break-after: always;"></div>
<h4 class="titleheader">Assessment Results</h4>
<table>
	<thead>
	<tr class="row header">
		<th>Competency / Skill</th>
		<th>Total of Questions</th>
		<th>Correctly Answered</th>
		<!--<th>Wrongly Answered</th>-->
		<th>Percentage(%)</th>
	</tr>
	</thead>
	<tbody>
	<?php 
	foreach($competencies as $competency){
		$per_test=UlsAssessmentTest::get_ass_position($_REQUEST['ass_id'],$_REQUEST['pos_id'],'TEST');
		$ass_test_correct=UlsAssessmentTest::assessment_test_score_count($per_test['assess_test_id'],$ass_test_emps['employee_id'],$competency['comp_def_id']);
		$ass_test_total=UlsAssessmentTest::assessment_test_score_count_total($per_test['assess_test_id'],$ass_test_emps['employee_id'],$competency['comp_def_id']);
		
		
		?>
		<tr>
			<td><?php echo $competency['comp_def_name']; ?></td>
			<td><?php echo !empty($ass_test_total['t_correct'])?$ass_test_total['t_correct']:0; ?></td>
			<td><?php echo !empty($ass_test_correct['correct'])?$ass_test_correct['correct']:0; ?></td>
			<?php /*<td><?php echo !empty($ass_test_correct['correct'] && $ass_test_total['t_correct'])?($ass_test_total['t_correct']-$ass_test_correct['correct']):0?></td> */ ?>
			<td><?php echo (!empty($ass_test_correct['correct']) && !empty($ass_test_total['t_correct']))?(round(($ass_test_correct['correct']/$ass_test_total['t_correct'])*100,1)):0 ?></td>
		</tr>
		
	<?php
	}
	?>	
	</tbody>
</table>

<h4 class="titleheader">Over all</h4>
<div style="text-align:center;"><img src="<?php echo $base64;?>"   style="height:200px;width:200px;padding-top:10px;"/></div>
</div>
<div style="page-break-after: always;"></div>
<?php }
} ?>
</body>
<div id="overlay2"><img src="public/PDF/images/cms/competencyassessmentreportback.jpg" width="100%"></div>
