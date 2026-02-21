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
$path = BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['ass_id'].'/'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'_radar.svg';
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = url_get_contents($path);
 $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
 
$path1 = BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['ass_id'].'/over_all_hr'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'.svg';
$type1 = pathinfo($path1, PATHINFO_EXTENSION);
$data1 = url_get_contents($path1);
$base64_new = 'data:image/' . $type1 . ';base64,' . base64_encode($data1);

?>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  
  <title>Competency Assessment Report</title>
  
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
		margin-top: 2.5cm !important;
		margin-bottom: 1.1cm !important;
		text-align: justify !important;
		font-family: "Helvetica,sans-serif" !important;
		font-size: 14px;
	}
	div.body {
		//margin-top: 2.5cm !important;
		margin-bottom: 1.5cm !important;
		margin-left: 1.5cm !important;
		margin-right: 1.5cm !important;
		color:#000;
		text-align: justify !important;
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
		padding: 10px;
		border: 1px solid #e3e3e3;
		font-family: "Helvetica,sans-serif" !important;
		font-size: 12px;
		text-align: justify !important;
    }
    tbody td{
		border: 1px solid #e3e3e3;
		padding: 10px;
		font-family: "Helvetica,sans-serif" !important;
		color:#000;
		font-size: 12px;
		text-align: justify !important;
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
	.fish6 { position: absolute; top: 80px; text-align:right;right: 200px;}
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
		line-height: 20px;
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
		margin-bottom: 1rem;
		padding: 0.60rem 1.25rem;
		position: relative;
		border-color: #734021;
		
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
		float: left;
		padding:0px 20px 0px 0px;
	}

	#main-content {
		left: auto;
		right: auto;
		position: relative;
		width: 40%;
		float: right;
		padding:10px;

	}
	.w3-light-grey {
		background-color: #f1f1f1 !important;
		color: #000 !important;
	}
	.w3-green{
		background-color: #4caf50 !important;
		color: #fff !important;
	}
	.w3-blue{
		background-color: #2196f3 !important;
		color: #fff !important;
	}
	.w3-center {
		text-align: left !important;
	}
	.w3-container{
		padding: 0.01em 16px;
	}
	hr.style-one {
		border: 0;
		height: 1px;
		background: #333;
	}
	.circle {
		width:10px;
		height:10px;
		border-radius:50px;
		font-size:15px;
		color:#fff;
		line-height:100px;
		background: green;
		display: inline-block;
	}
	.red-circle {
		background: #f1f1f1;
	}
  </style>
  
</head>


<div class="flyleaf">
	<div id="overlay"><img src="public/PDF/images/cms/adani-power-cover.jpg" width="100%"></div>
	<img src="<?php echo LOGO_IMG_PDF; ?>" style="margin:0.15cm 0.2cm" width="300"  class="fish">
	<label class="fish5"><b style="font-size:34pt;color:#fff;">Assessment Report </b></label>
	<label class="fish6"><b style="font-size:28pt;color:#fff;">(HR)</b></label>
	<label class="fish1"><b style="font-size:22pt;color:#000;"><?php echo $emp_info['name']; ?></b><br><b style="font-size:14pt;color:#000;"><?php echo @$posdetails['position_name']; ?></b></label>
	

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

	<div class="body">
		<div style="height: 750px;bottom:0px;">&nbsp;</div>
		<p style="color:red;padding-left:5px;">
		NOTE:This report and its contents are the property of <?php echo $emp_info['parent_organisation'];?> and no portion of the same should be copied or reproduced without the prior permission of <?php echo $emp_info['parent_organisation'];?>.</p>
		<p style="color:red;padding-left:5px;">The report is a part of the Techincal/ Functional Assessment process of <?php echo $emp_info['name']; ?>, <?php echo @$posdetails['position_name']; ?></p>
		<p style="padding-left:5px;">For further information on Competencies, Competency modelling and assessment, please refer to the FAQ section in <a href="http://n-compas.com/" target="_blank">www.N-Compas.com </a></p>

	</div>
	<div style="page-break-after: always;"></div>
	<div class="body">
	<h3 class="title">1.Introduction</h3>
	<h4 class="titleheader">WHAT IS THIS ALL ABOUT?</h4><br>
	<p>As you know the organization is constantly in the process of improving the capability platform of employees, so as to enable them reach their true potential.  As a part of this, the organization has drawn-up an ambitious process of Technical and Functional Competency assessment and development process, with an end objective of FOCUSED LEARNING AND DEVELOPMENT FOR EACH INDIVIDUAL.</p>
	<br>
	<h4 class="titleheader">WHAT IS THE BASIC FRAMEWORK OF THIS PROCESS?</h4><br>
	<p>This process has been developed based on the following</p>
	<p>1. Every job in the organization has a set of accountabilities, which are measured in terms of the outcomes, referred to as KRAs.  These (KRAs), in order to be achieved, would require a certain set of Competencies. These competencies in turn are clasified along the Technical, Functional, Managerial and Leadership dimensions</p>
	<p>2. Based on the various positions in the organization, a complete set of Technical Competencies have been identified (please refer to the competency dictionary available at www.N-Compas.com) for the Energy business (Thermal Power)</p>
	<p>3. Each position has been defined in terms of the competency requirement, referred to as Competency Profile </p>
	<p>4. In order to assess an individual on these competencies a set of methods have been identified, which are different for different positions.  Those relevant for your position are given, and detailed in the following section</p>
	</div>
	<div style="page-break-after: always;"></div>
	<div class="body">
		<h4 class="titleheader">WHAT ARE THE ASSESSMENT METHODS USED?</h4>
		<p>Based on the position, you will be having a combination of the following assessment methods</p>
		<p><b style="text-decoration:underline;">MCQ or Multiple Choice Questions:</b> <br> These are questions which are based on your product, process/SOP and related aspects.</p>
		<p><b style="text-decoration:underline;">In-basket Exercises:</b> <br> As an executive, your day comprises of a number of activities. How you organize your day, both in terms of time - prioritization and the quality of action - how you choose to act or what you delegate, reflects on your capabilities.</p>
		<p><b style="text-decoration:underline;">Caselets:</b> <br> These are small situational narratives which have been built around your typical issues/aspects which you encounter in your every day work.  How you handle these reflects your technical and to some extent managerial capabilities as well</p>
		<p><b style="text-decoration:underline;">Cases: </b> <br>These are usually ‘third party’ situational constructs where-in you have to analyze the same and provide your perspective on how you would deal with various aspects therein (as given in the case questions).</p>
		<h4 class="titleheader">WHAT IS THE SCOPE OF THIS ASSESSMENT?</h4>
		<p>In this cycle we will be assessing only technical/functional competencies and drawing of the Development Road Map for them.</p>
		
	</div>
	<div style="page-break-after: always;"></div>
	<div class="body">
		
		<h4 class="titleheader">HOW TO READ THIS REPORT?</h4>
		<br>
		<p>This report has the following <br><br>
		01.	Your job description, including the competency profile.  This profile information was used in creating the assessment <br>
		02.	A Radar graph showing the competency requirement of your job, and how you were assessed each of these, using various methods <br>
		03.	A consolidated assessment summary sheet<br>
		04.	Development road map information as suggested by the assessors.<br><br> <br> <br>  
		Please read each section of the report carefully, since they flow sequentially.  
		</p>
		
	</div>
	<div style="page-break-after: always;"></div>
	<div class="body">
		<h3 class="title"  style="text-align:right;">2.Job Description</h3>
		<table>
			<tbody>
				<tr>
					<td class="normal"  style="width:15%"><b>Job Title</b></td>
					<td class="normal"  style="width:35%"><?php echo @$posdetails['position_name']; ?>&nbsp;</td>
					<td class="normal"  style="width:15%"><b>Grade/Level</b></td>
					<td class="normal"  style="width:35%"><?php echo @$posdetails['grade_name']; ?></td>
				</tr>
				<tr>
					<td class="normal"><b>Business</b></td>
					<td class="normal"><?php echo @$posdetails['bu_name']; !empty($posdetails['bu_name'])?"":"-"; ?></td>
					<td class="normal"><b>Function</b></td>
					<td class="normal"><?php echo @$posdetails['location_name']; !empty($posdetails['location_name'])?"":"-";?></td>
				</tr>
				<tr>
					<td class="normal"><b>Location</b></td>
					<td class="normal"><?php echo @$posdetails['location_name']; !empty($posdetails['location_name'])?"":"-"; ?></td>
					<td class="normal"><b></b></td>
					<td class="normal"></td>
				</tr>
			</tbody>
		</table>
		<h4 class="titleheader">Reporting Relationships </h4>
		<table>
			<thead>
				<tr class="row header">
					<th  style="width:50%"><b>Reports to</b></th>
					<th  style="width:50%"><b>Reportees</b></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="normal" ><?php echo @$posdetails['reportsto']; !empty($posdetails['reportsto'])?"":"-";?></td>
					<td class="normal"><?php echo @$posdetails['reportees_name']; !empty($posdetails['reportees_name'])?"":"-";?></td>
				</tr>
			</tbody>
		</table>
		<h4 class="titleheader">Position Description</h4>
		<table>
			<thead>
				<tr class="row header">
					<th style="width:33%"><b>Education Background</b></th>
					<th style="width:33%"><b>Experience</b></th>
					<th style="width:33%"><b>Industry Experience</b></th>
				</tr>
			</thead>
				<tbody>
				<tr>
					<td class="normal" ><?php echo strip_tags(@$posdetails['education']); !empty($posdetails['education'])?"":"-"; ?></td>
					<td class="normal"><?php echo strip_tags(@$posdetails['experience']); !empty($posdetails['experience'])?"":"-"; ?></td>
					<td class="normal"><?php echo strip_tags(@$posdetails['specific_experience']); !empty($posdetails['specific_experience'])?"":"-"; ?></td>
				</tr>
			</tbody>
		</table>
		<?php if(!empty($posdetails['other_requirement'])){ ?>
		<h4 class="titleheader">Other Requirements:</h4><p><?php echo @$posdetails['other_requirement']; ?></p>
		<?php } ?>
		<h4 class="titleheader">Purpose:</h4><p><?php echo @$posdetails['position_desc']; ?></p>
		<h4 class="titleheader">Accountabilities:</h4><p><?php echo @$posdetails['accountablities']; ?></p>
		<?php if(count($kras)>0){ ?>
		<h4 class="titleheader">KRA & KPI</h4>
		<table>
			<thead>
			<tr  class="row header">
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
		<?php 
		} ?>
	</div>
	<div style="page-break-after: always;"></div>
	<div  class="body">
		<h3 class="title"  style="text-align:right;">3.Competency Profile</h3>
		<p>The <?php echo $emp_info['position_name']; ?>, whose description is provided in the above section, would require Competencies – Functional, Technical, Managerial and Behavioural, to ensure that the objectives/goals or KRAs are achieved.  However, not all the competencies, are required at the same Levels of Proficiency or the same level of Criticality.  The process of mapping the position in terms of required Competencies – the Levels and the Criticality is  referred to as Profiling.<br>
		The definition of various Levels of Proficiency and the Criticality Dimensions are given hereunder. </p><br>
		<!--<b>The Job, <?php echo $emp_info['position_name']; ?>  whose description is provided in the above section, would require Competencies  - Functional, Managerial and Behavioural, to ensure that the objectives/goals or KRAs are achieved.  However, the various competencies required for this or other job are not required, one at the same Proficiency level and two, at the same level of criticality (please notes below).-->
		<p>In case of Functional/ Techincal Competencies there are Four Level of profficiency.</p>
		<?php 
		foreach($scale_info_four as $scale_infos){
			?>
			<p><b style="font-size:11pt;text-decoration: underline;"><?php echo $scale_infos['scale_name'];?>:</b><?php echo $scale_infos['description'];?></p>
		<?php
		}
		
		if(count($scale_info_five)>0){?>
			<br>
			<p>For Managerial/ Behavioural Competencies there are Five Levels scale of profficiency as given below.</p>
			<?php 
			foreach($scale_info_five as $scale_infoss){
			?>
			<p><b style="font-size:11pt;text-decoration: underline;"><?php echo $scale_infoss['scale_name'];?>:</b><?php echo $scale_infoss['description'];?></p>
			<?php
			}
		}
		?>
		<br>
		<p>The second dimension, in Competency Profiling is called the Level of Criticality, which in turn is split into three categories
		</p>
		<?php 
		foreach($cri_info as $cri_infos){
		?>
		<p><b style="font-size:11pt;text-decoration: underline;"><?php echo $cri_infos['name'];?>:</b><?php echo $cri_infos['description'];?></p>
		<?php
		}
		?>
		
	</div>
	<div style="page-break-after: always;"></div>
	<div class="body">
		<h3 class="titleheader">Competency/Skill Requirements</h3><br>
		<p>The following are the competencies required for the position of <?php echo $emp_info['position_name']; ?>. This is also reffered to as Competency Profilling</p><br>
		<?php
		foreach($category as $categorys){
			$ass_comp_info=UlsAssessmentReport::getassessment_admin_competency($ass_id,$pos_id,$categorys['category_id']);
		?>
		<h4 class="titleheader"><?php echo $categorys['name']; ?></h4>
		<table>
			<thead>
			<tr class="row header">
				<th>Competency/Skill</th>
				<th>Level Requirement</th>
				<th>Criticality</th>
			</tr>
			</thead>
			<tbody>
			<?php 
			$results=$assessor=array();
			foreach($ass_comp_info as $ass_comp_infos){
				//$assessor[]=$ass_comp_infos['assessor_id'];
				//$assessor_id=$ass_comp_infos['assessor_id'];
				$comp_id=$ass_comp_infos['comp_def_id'];
				$req_scale_id=$ass_comp_infos['req_scale_id'];
				$results[$comp_id]['comp_name']=$ass_comp_infos['comp_def_name'];
				$results[$comp_id]['req_scale_id']=$ass_comp_infos['req_scale_id'];
				$results[$comp_id]['req_scale_name']=$ass_comp_infos['req_scale_name'];
				$results[$comp_id]['assessment_id']=$ass_comp_infos['assessment_id'];
				$results[$comp_id]['position_id']=$ass_comp_infos['position_id'];
				//$results[$comp_id]['employee_id']=$ass_comp_infos['employee_id'];
				$results[$comp_id]['comp_cri_name']=$ass_comp_infos['comp_cri_name'];
				/* $results[$comp_id][$assessor_id]['overall_id']=$ass_comp_infos['final_scaled_id'];
				$results[$comp_id][$assessor_id]['overall_name']=$ass_comp_infos['final_scaled_name'];
				$results[$comp_id][$assessor_id]['development']=$ass_comp_infos['development_area']; */
				
			}
			//print_r($results);
			foreach($results as $comp_def_id=>$result){
				$final_admin_id=$_SESSION['user_id'];
				//$ass_comp=UlsAssessmentReport::getadminassessment_competencies_insert($result['assessment_id'],$result['position_id'],$result['employee_id'],$final_admin_id,$comp_def_id);
			?>
				<tr>
					<td><?php echo $result['comp_name']; ?></td>
					<td><?php echo $result['comp_cri_name']; ?></td>
					<td><?php echo $result['req_scale_name']; ?></td>
					
				</tr>
				
			<?php
			}
			?>	
			</tbody>
		</table>
		<?php } ?>
	</div>
	<div style="page-break-after: always;"></div>
	
	<div class="body">
		<h3 class="title"  style="text-align:right;">4. Assessment Methods</h3><br>
		<?php /* <h4 class="titleheader">Assessments Methods</h4> */ ?>
		<div>The following methods were used as a part of this Assessment process.</div>
		<br><br>
		<table>
			<thead>
			<tr class="row header">
				<th>S.No</th>
				<th>Assessment Type</th>
				<!--<th>Assessment Weightages</th>-->
				<th>Duration</th>
			</tr>
			</thead>
			<tbody>
			
			<?php $i=1;
			foreach($testtypes as $testtype){
			?>
				<tr>
					<td><?php echo $i++; ?></td>
					<td><?php echo $testtype['assess_type']; ?></td>
					<!--<td><?php echo $testtype['weightage']; ?></td>-->
					<td><?php echo $testtype['time_details']; ?> mins</td>
				</tr>
				
			<?php
			}
			?>	
			</tbody>
		</table>
	</div>
<?php foreach($testtypes as $testtype){ ?>

		<?php
		// || $testtype['assessment_type']=="INTERVIEW" 
		if($testtype['assessment_type']=="TEST"){
			$testdetails=UlsAssessmentTest::assessment_view_final($testtype['assess_test_id']);
			
		?>
		<div style="page-break-after: always;"></div>
			<div class="body">
			<h3 class="title"  style="text-align:right;"><?php echo $testtype['assess_type']; ?></h3>
		 <?php foreach($testdetails as $key=>$que) { ?>	
	    <div>	 
		<?php 	$keys=$key+1;
				$ques=$que['question_id'];
				$type=$que['type_flag'];
				//echo $ques."-".
				?>
				
		        <br><b>Q<?php echo $keys.")"; ?></b>&nbsp;<?php echo $que['question_name'];?><br>
				
			<?php	
			   $ss=Doctrine_Query::create()->select('value_id,text,correct_flag')->from("UlsQuestionValues")->where("question_id=".$que['question_id'])->execute();
			   $empdetail=UlsMenu::callpdorow("SELECT * FROM `uls_utest_responses_assessment` WHERE `assessment_id`=".$_REQUEST['ass_id']." and test_type='".$testtype['assessment_type']."' and `employee_id`=".$_REQUEST['emp_id']." and `user_test_question_id`=".$que['question_id']);
			   if($type=='S' || $type=='M'){ echo "<ol>"; }
		       foreach($ss as $key1=>$sss){
				   $col=$sss['correct_flag']=='Y'? 'style="color:green;font-size:10px;font-family:italic;"':'';
				   $col2=$empdetail['response_value_id']==$sss['value_id']?
				   'style="color:blue;font-size:10px;font-family:italic;"':'';
					$ke=$key1+1;
		            if($type=='F'){  ?>
		                &nbsp;&nbsp;&nbsp;&nbsp;..............................................<br>
		  <?php     } 
		            else if($type=='B'){ ?>
						&nbsp;&nbsp;&nbsp;&nbsp;..............................................<br>
		<?php		}
		            else if($type=='T'){ ?>
					    <?php echo "&nbsp;&nbsp;&nbsp;&nbsp;".$ke."]"; ?><?php echo trim(strip_tags($sss['text']));?><br>
			<?php 	} 
			        else if($type=='S'){ ?>
					    <li type='A' <?php echo $col;?> <?php echo $col2;?>><?php echo trim(($sss['text']));?></li>
					    
			<?php	}
			        else if($type=='M') { ?>
					    <li type='A' <?php echo $col;?> <?php echo $col2;?>><?php echo trim(strip_tags($sss['text']));?></li>
			 <?php  } 
			        else if($type=='FT') { 
						$col=$sss['correct_flag']=='Y'? 'style="color:green;font-size:10px;font-family:italic;"':'';
						if(!empty($sss['text'])){ ?>
							
							<br><div <?php echo $col;?> class="answer"><i>What to look for<br><?php echo @$sss['text'];?></i></div><br>
						<?php }
						?>
						<?php if(!empty($empdetail['text'])){ ?>
						<div style="color:blue;font-size:10px;font-family:italic;" class="answer"><?php echo @$empdetail['text'];?></div>
						<?php } else{ ?>
						<textarea cols="100" style="height:85px;" ><span style="color:#d1d1d1;">Interviewers Comments</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</textarea>
						<?php } ?>
			<?php	} ?>
		<?php   }  
				if($type=='S' || $type=='M'){ echo "</ol>"; } ?>
			
		</div>
		
		 <?php } ?>
		 <?php if($testtype['assessment_type']=="TEST"){ ?>
		 <br><br><span style="font-size:0.8em;">Note:<br>
		 a.	Marked in <font color="blue">BLUE</font>:  Those given by the applicant<br>
		 b.	Marked in <font color="green">GREEN</font>:  Suggested/recommended answer/option </span>
		 <?php } ?>
		 </div>
		<?php } ?>
		<?php if($testtype['assessment_type']=="INBASKET"){
			$mode=array();
			foreach($modes as $val){
				$id=$val['code'];
				$mode[$id]=$val['name'];
			}
			$noinbaskets=UlsMenu::callpdo("SELECT * FROM `uls_assessment_test_inbasket` where assessment_id=$ass_id and position_id=$pos_id");
			foreach($noinbaskets as $noinbasket){
				$inbasket=UlsInbasketMaster::viewinbasket($noinbasket['inbasket_id']); ?>
				<div style="page-break-after: always;"></div>
				<div class="body">
					<h3 class="title"  style="text-align:right;">What is an In-basket Exercise?</h3>
					<?php /*<h2 style="text-align:center"><?php echo @$inbasket['inbasket_name']; ?></h2><p>&nbsp;</p>
					<h4 class="titleheader">What is an In-Basket Exercise?</h4> */ ?>
					<div>An In-basket or an Intray is a list of items of work that need to be to be attended to when you come to work.  These could include mails, calls (mobile, intercom), reports, meetings, visits by you or by others, etc.  For the various items in the In-basket/intray, there would be a certain approach you would take – for exampling first attending the mail items, or the work from the previous day; and for each of them you would decide the kind of action you want to take and/or delegate the same.  Whatever you decide, is a reflection of your style of work and also tells how you prioritize and plan your work.<br>Apat from this, for each of the In-basket, you are to suggest an action which reflects your level of understanding and expertize.<br><br>
					In the following exercise,  you will role-play the person mentioned in the In-basket narration and help him/her plan the items of work that he/she needs to be doing.<br><br>
					Please read the In-basket narration and instructions carefully before starting.</div>
					
				</div>
				<div style="page-break-after: always;"></div>
				<div class="body">
					
					<?php if(!empty($inbasket['inbasket_narration'])){ ?>
					<h4 class="titleheader">In-basket Narration</h4>
					<div><?php echo nl2br($inbasket['inbasket_narration']); ?></div>
					<?php } ?>
				
				<?php 
				if(!empty($inbasket['question_id'])){
					$empdetailinbasket=UlsMenu::callpdorow("SELECT * FROM `uls_utest_responses_assessment` WHERE `assessment_id`=".$_REQUEST['ass_id']." and `employee_id`=".$_REQUEST['emp_id']." and test_type='INBASKET' and `user_test_question_id`=".$inbasket['question_id']);
					
					$question_view=UlsQuestionValues::get_allquestion_values_competency($inbasket['question_id']);
					$scorting=($inbasket['inbasket_scorting_order']=='Y')?"sortable":"";
					$scorting_arrow=($inbasket['inbasket_scorting_order']=='Y')?"<span class='ui-icon ui-icon-arrowthick-2-n-s'></span>":"";
				?>
				<?php if(!empty($inbasket['inbasket_instructions'])){ ?>
				<h4 class="titleheader">In-basket Instructions</h4>
				<div><?php echo nl2br($inbasket['inbasket_instructions']); ?></div>
				<?php } ?>
				</div>
					<div style="page-break-after: always;"></div>
				<div class="body">
				<h4 class="titleheader">In-basket Exercise</h4>
					<?php 
					$intrayss=array();
					foreach($question_view as $key=>$question_views){ ?>
					
					
				<?php
						if(!empty($question_views['inbasket_mode'])){
						$parsed_json = json_decode($question_views['inbasket_mode'], true);
						}
						$keyy=$key+1;
						$a=$question_views['value_id'];
						$intrayss[$a]="Intray ".$keyy;
						$compp[$a]=$question_views['comp_def_name'];
						$scall[$a]=$question_views['scale_name'];
						$priority[$a]=$question_views['priority_inbasket'];
						
					?>
						<div class="portlet">
							<h4 class="titleheader_new"><?php echo $scorting_arrow; ?> Intray # <?php echo $keyy; ?>  </h4>
							<p>Competency: <?php echo $question_views['comp_def_name']; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Level: <?php echo $question_views['scale_name']; ?></p>
								<p class="text-muted">
								<?php
								if(!empty($parsed_json)){
									foreach($parsed_json as $key => $value)
									{
									?>
									   Mode: <?php $k=$value['mode']; echo @$mode[$k]; ?><br>
									   Time: <?php echo $value['period'];?><br>
									   From: <?php echo $value['from'];?><br>
									<?php
									}
								}
								?>
								<?php echo nl2br($question_views['text']); ?></p>
						
						</div>
					<?php } ?></div>
					<div style="page-break-after: always;"></div>
					<div class="body">
						<h4 class="titleheader">In-basket: Analysis and Interpretation</h4><br>
						<p>The following is the prioritization given by <?php echo $emp_info['name']; ?></p>
						<p>Please note the SME priority means the prioritization as pre-detemined by Subject Matter Expert(s)<p/>
						<br>
					<table>
						<tr><td>Priority Order</td><td>Action & Description</td><td>Competency</td><td>Level</td><td>SME Priority</td></tr>
						<?php
							//echo $empdetailinbasket['text'];
							$inbaskets=json_decode($empdetailinbasket['text'], true); 
							if(is_array($inbaskets)){
							foreach($inbaskets as $key=>$inbasket){
								$b=$inbasket['id'];
								$smep=!empty($priority[$b])?$priority[$b]:"NA";
								echo "<tr><td>".$intrayss[$b]." <br>is <br>Priority #".($key+1)."</td><td>".$inbasket['action']."<br>".$inbasket['text']."</td><td>".$compp[$b]."</td><td>".$scall[$b]."</td><td>".$smep."</td></tr>";
							}
							}
						?>
						</table>
						</div>
				<?php } ?>
				
			<?php }
		} ?>
		<?php if($testtype['assessment_type']=="CASE_STUDY"){
			$nocases=UlsMenu::callpdo("SELECT * FROM `uls_assessment_test_casestudy` where assessment_id=$ass_id and position_id=$pos_id");
			foreach($nocases as $nocase){
				$case_details=UlsCaseStudyMaster::viewcasestudy($nocase['casestudy_id']);
				//echo $case_details['casestudy_link'];
				?>				
				<div style="page-break-after: always;"></div>
				<div class="body">
				<h3 class="title"  style="text-align:right;">Case study/Caselet</h3>
				<!--<h4 class="titleheader">Case Study/Caselet</h4>
				<h2 style="text-align:center"><?php echo @$case_details['casestudy_name']; ?></h2>
				<?php if(!empty($case_details['casestudy_link'])){?>
				<p>Link: <a href="<?php echo @$case_details['casestudy_link']; ?>" target="_blank" >Click Here</a></p>
				<?php } ?>
				<p>&nbsp;</p>-->
				<div><?php echo $case_details['casestudy_description']; ?></div>
				<?php $case_study_questions=UlsCaseStudyQuestions::viewcasestudyquestion($nocase['casestudy_id']); ?>
				
				<h4 class="titleheader">Questions</h4>
				<?php foreach($case_study_questions as $key1=>$case_study_question){
					$empdetailcase=UlsMenu::callpdorow("SELECT * FROM `uls_utest_responses_assessment` WHERE `assessment_id`=".$_REQUEST['ass_id']." and `employee_id`=".$_REQUEST['emp_id']." and test_type='CASE_STUDY' and `user_test_question_id`=".$case_study_question['casestudy_quest_id']);
					
					$empdetailcaseattach=UlsMenu::callpdorow("SELECT * FROM `uls_utest_attempts_assessment` WHERE `assessment_id`=".$_REQUEST['ass_id']." and `employee_id`=".$_REQUEST['emp_id']." and test_type='CASE_STUDY' and status='A'");
					?>
					<br>
				<div><b>Q<?php echo $key1+1; ?>) <?php echo $case_study_question['casestudy_quest']; ?></b></div>
				<br>
				<span style="color:blue;font-size:16px;line-height: 1.8;">A. <?php echo @nl2br($empdetailcase['text']); ?></span>
				<br>
				<?php if(!empty($empdetailcaseattach['inbasket_upload'])){ ?>
				Please Click on
					<a href="<?php echo BASE_URL; ?>/public/uploads/employee_casestudy/<?php echo $empdetailcaseattach['inbasket_upload'];?>" parent="_blank">Attachment</a> to view Applicant add document.
				<?php } ?>
				
				<?php } ?>
				<p>&nbsp;</p>
				</div>
			<?php } ?>
			<?php } ?>
			
	</div>
	<?php } ?>	

<?php 
$results=$assessor=$comname=$comp_id=array();
foreach($ass_results as $key1=>$result){
	$comp_id[$result['comp_def_id']]="C".($key1+1);
	$comname[$result['comp_def_id']]=$result['comp_def_name'];
}
?>
<div style="page-break-after: always;"></div>	
<div  class="body">
	<h3 class="title"  style="text-align:right;">5. Radar Graph</h3>
	<br>
	<p>It is important to understand that each role requires as certain set of competencies at a certain level of proficiency as detailed in the competency profile sheet.  While this is the requirement in terms of the position, based on the assessment, you have been found to be at a certain level.  The graphical representation of this relative information – between what is required of the job and what you posses is called a Competency Radar Graph.  </p>
	<table width="100%">
		<tbody>
			<tr>
				<td width="50%"><img src="<?php echo $base64;?>" style="width:350px;padding-top:10px; border-bottom:thin solid  #000;"/></td>
				<td width="50%" align="top">
					<?php 
					$val_self=array_combine($comp_id,$comname);
					//print_r($val_self);
					foreach($val_self as $key => $val_selfs){
						echo $key."-".$val_selfs."<br>";
					}
					
					?>
				</td>
			</tr>
		</tbody>
	</table>
	<br>
	<span style="font-size:9px;">In case the assessed level is exactly the same as required level, you will be able to see only Green line (Assessed Level)</span>
	<br>
	<p>In the current assessment process, you have been evaluated by more than one person; the assessed values shown in the graph above is the average of the assessment given by  the different assessors.  The average has been arrived at by a simple arithmetic mean.</p>
</div>
<div style="page-break-after: always;"></div>
	
<div class="body">
	<h3 class="title"  style="text-align:right;">6. Assessment Summary Sheet</h3>
	<br>
	<p>In order to help you get a better understanding on the outcome of the assessment process, the various methods have been converted into numeric values. </p>
	<br><br>
	<table>
		<thead>
		<tr class="row header">
			<th>S.No</th>
			<th>Assessment Method</th>
			<th>Total Question</th>
			<th>Answered Correctly/Rating</th>
			<th>Percentage Scored (%)</th>
			<th>Weightage for Assessment Method (%)</th>
			<th>Weighted Score</th>
		</tr>
		</thead>
		<tbody>
		<?php 
		$results=array();
		foreach($assessor_rating_new as $assessor_rating_news){
			$finalval=!empty($assessor_rating_news['assessor_val'])?round(($assessor_rating_news['rat_num']*$assessor_rating_news['assessor_val']),2):$assessor_rating_news['rat_num'];
			$results[$assessor_rating_news['assessment_type']]['assessment_type']=$assessor_rating_news['assessment_type'];
			$results[$assessor_rating_news['assessment_type']]['assess_type']=$assessor_rating_news['assess_type'];
			$results[$assessor_rating_news['assessment_type']]['weightage']=$assessor_rating_news['weightage'];
			$results[$assessor_rating_news['assessment_type']]['test_ques']=$assessor_rating_news['test_ques'];
			$results[$assessor_rating_news['assessment_type']]['test_score']=$assessor_rating_news['test_score'];
			$results[$assessor_rating_news['assessment_type']]['rating_scale']=$assessor_rating_news['rating_scale'];
			$results[$assessor_rating_news['assessment_type']]['assessor'][$assessor_rating_news['assessor_id']]=$finalval;
		}
		/* echo "<pre>";
		print_r($results); */
		$i=1;
		$score='';
		$wei_sum=0;
		$wei_total=0;
		foreach($results as $key1=>$assessor_ratings){
			$wei_sum=($wei_sum+$assessor_ratings['weightage']);
			?>
			<tr>
				<td><?php echo $i++; ?></td>
				<td><?php 
				$ast=($assessor_ratings['assessment_type']!='TEST')?'<sup><font color="#FF0000">*</font></sup>':"";
				
				echo $assessor_ratings['assess_type']; echo $ast; ?></td>
				<td><?php
				if($assessor_ratings['assessment_type']=='TEST'){
					echo $assessor_ratings['test_ques'];
				}
				else{
					echo "NA";
				} 
				?></td>
				<td><?php
				if($assessor_ratings['assessment_type']=='TEST'){
					$score_test=$assessor_ratings['test_score'];
					echo $score_test_f=$score_test;
				}
				else{
					$final=0;
					foreach($assessor_ratings['assessor'] as $key2=>$ass_id){
						$final=$final+$results[$key1]['assessor'][$key2];
					}
					$final=round($final/count($results[$key1]['assessor']),2);
					$score=round($final,2);
					echo $score_f=$score;
				} 
				?></td>
				<td><?php
				if($assessor_ratings['assessment_type']=='TEST'){
					echo $score_test=(($assessor_ratings['test_score']/$assessor_ratings['test_ques'])*100);
				}
				else{
					$final=0;
					foreach($assessor_ratings['assessor'] as $key2=>$ass_id){
						$final=$final+$results[$key1]['assessor'][$key2];
					}
					$final=round($final/count($results[$key1]['assessor']),2);
					echo $score=(($final/$assessor_ratings['rating_scale'])*100);
				} 
				?></td>
				<td><?php echo $assessor_ratings['weightage']; ?></td>
				<td><?php
				$score_final=$scorefinal=0;
				if($assessor_ratings['assessment_type']=='TEST'){
					$score_test=(($assessor_ratings['test_score']/$assessor_ratings['test_ques'])*100);
					$wei=$assessor_ratings['weightage'];
					echo $score_final=round((($score_test*$wei)/100),2);
				}
				else{
					$final=0;
					foreach($assessor_ratings['assessor'] as $key2=>$ass_id){
						$final=$final+$results[$key1]['assessor'][$key2];
					}
					$final=round($final/count($results[$key1]['assessor']),2);
					$score=(($final/$assessor_ratings['rating_scale'])*100);
					$wei=$assessor_ratings['weightage'];
					echo $scorefinal=round((($score*$wei)/100),2);
				} 
				$wei_total=round($wei_total+($score_final+$scorefinal),2);
				?></td>
			</tr>
			<?php
		}
		?>
		<tr style="font-size:18px;">
			<td colspan='5'  style="font-size:18px;">Overall Score</td>
			<td style="font-size:18px;"><?php echo $wei_sum;?></td>
			<td style="font-size:18px;"><?php echo $wei_total;?></td>
		</tr>
		</tbody>
	</table>
	<br>
	<div style="color:red; padding-left:5px; font-size:10px;">
	For In-basket and Case study, a rating scale of 1 to 4 was used<br>
	<?php 
	foreach($ass_rating_scale as $key=>$ass_rating_scales){
		$g=($key!=0)?",":"";
	?>
	<span><?php echo $g; ?><?php echo $ass_rating_scales['rating_number'];?>-<?php echo $ass_rating_scales['rating_name_scale'];?></span>
	<?php
	}
	?>
	</div>
	<br style="clear:both;">
	<img src="<?php echo $base64_new;?>" style="width:100%;height:200px;" >
	
	<?php /*<div></div>*/
	$ass_d="";
	foreach($testtypes as $testtype){
		if($testtype['assessment_type']=='TEST'){
			$ass_d.="<li>The ratings for MCQ are as derived from the system</li>";
			$ass_count=UlsAssessmentPositionAssessor::getassessors_details($_REQUEST['ass_id'],$_REQUEST['pos_id']);
			if(count($ass_count)==1){
				$ass_d.="<li>Ratings for the In-basket, Case study and Interview are based on the scale given above</li>";
			}
			else{
				$ass_d.="<li>Ratings given in this report are an average of all ratings given by external subject matter experts who acted as assessors for this assessment cycle.<br>Ratings for the In-basket, Case study and Interview are based on the scale given above</li>";  
			}
			$ass_d.="<li>The weightage factor, given above is as per the assessment details given in the earlier section of the report.</li>";
			$ass_d.="<li>In order to ensure a consistency of reporting of the assessment results, within a group, the percentile method has been used for computing the ratings /overall ratings.This means that the person who has performed the best has gets a 99.99 score and the rest are marked or calibrated in relation to this score.</li>";  
			$ass_d.="<li>No other information other than this assessment has been used for arriving at the above.</li>";
		}
		elseif($testtype['assessment_type']=='INTERVIEW'){
			$ass_count=UlsAssessmentPositionAssessor::getassessors_details($_REQUEST['ass_id'],$_REQUEST['pos_id']);
			if(count($ass_count)==1){
				$ass_d.="<li>Ratings for the In-basket, Case study and Interview are based on the scale given above</li>";
			}
			else{
				$ass_d.="<li>Ratings given in this report are an average of all ratings given by external subject matter experts who acted as assessors for this assessment cycle.<br>Ratings for the In-basket, Case study and Interview are based on the scale given above</li>";  
			}
			$ass_d.="<li>The weightage factor, given above is as per the assessment details given in the earlier section of the report.</li>";
			$ass_d.="<li>In order to ensure a consistency of reporting of the assessment results, within a group, the percentile method has been used for computing the ratings /overall ratings.This means that the person who has performed the best has gets a 99.99 score and the rest are marked or calibrated in relation to this score.</li>"; 
			$ass_d.="<li>No other information other than this assessment has been used for arriving at the above.</li>";
		}
		elseif($testtype['assessment_type']=='INBASKET'){
			$ass_d.="";
		}
		elseif($testtype['assessment_type']=='CASE_STUDY'){
			$ass_d.="";
		}
	}
	
	
		
	?>
	<div style="font-size:10px;">Note:<br>
	<ol><?php echo $ass_d; ?></ol></div>
</div>
<div style="page-break-after: always;"></div>
	
<div class="body">
	<h3 class="title"  style="text-align:right;">7. Assessment Feedback & Development Road Map</h3><br>
	<p>Appreciate the time you've spent on undergoing the entire process. And, hope that the in-basket, case study and the interactive sessions were a value add to you.</p>
	<p>As mentioned in the introductory part of the report the entire Competency Mapping and Assessment process is for the purpose of enabling your development. In arriving at your Development needs/requirements, the Assessors have taken into consideration all the information available across the various Assessment Methods.
	</p>
	<p>Your performance in various assessment methods has been carefully analyzed and the following development roadmap has been recommended to further enhance your performance:
	</p>
	<br><br>
	<p>
	
	<?php
	$result_ss=array();
	foreach($ass_rating_comments as $ass_rating_comment){
		if(!empty($ass_rating_comment['comments'])){
			$result_ss[$ass_rating_comment['assessment_type']]['ass_type']=$ass_rating_comment['assessment_type'];
			$result_ss[$ass_rating_comment['assessment_type']]['assess_type']=$ass_rating_comment['assess_type'];
			$result_ss[$ass_rating_comment['assessment_type']]['comments'][$ass_rating_comment['assessor_id']]=$ass_rating_comment['comments'];
		}
	}
	/* echo "<pre>";
	print_r($result_ss); */
	
	if(count($result_ss)>0){
		$i=1;
		foreach($result_ss as $key_i=>$ass_ratingcomment){
			echo "<h4 class='titleheader'>".$ass_ratingcomment['assess_type']."</h4><ul>";
			foreach($ass_ratingcomment['comments'] as $key2=>$ass_id){
				echo "<li style='color:blue;line-height: 1.5;'>".$result_ss[$key_i]['comments'][$key2]."</li>";
			} 
			echo "</ul>";
			$i++;
		}
	}
	?>
	
	</p>
	<br><br>
	<p style="font-size:8pt;">Note: The comments and development guide lines are adverbatim, as given by the assessors,these could include comments on the performance in different assessment methods as well as development guidelines.<br>The development requirements identified by the assessors may be in the context of the current job as well as the future requirements. <br>Kindly focus on the development requirement identified.</p>
	<br><br>
	<h4 class="titleheader">7.1 Competency Specific Development Plans</h4><br>
	<p>The following are competency specific development inputs given by the assessors.</p>
	<?php
	$tt="";
	$result_s=array();
	foreach($ass_development as $ass_developments){
		if(!empty($ass_developments['dev_area'])){
			$result_s[$ass_developments['comp_def_id']]['comp_name']=$ass_developments['comp_def_name'];
			$result_s[$ass_developments['comp_def_id']]['dev_area'][$ass_developments['assessor_id']]=$ass_developments['dev_area'];
		}
	}
	if(count($result_s)>0){
	foreach($result_s as $key1=>$result){
	?>
	<h4 class='titleheader'><?php echo $result['comp_name']; ?></h4>
	<ul>
		<?php
		foreach($result['dev_area'] as $key2=>$ass_id){
		
		echo "<li>".$result_s[$key1]['dev_area'][$key2]."</li>";
		
		}
		?>
	</ul>
	<?php }
	}
	else{
		echo "<br><br><br><br><p style='font-style:italic;color:#808080;'>No competency specific development inputs have been provided.</p>";
	}
	?>
</div>
<div style="page-break-after: always;"></div>
</body>
<div id="overlay2"><img src="public/PDF/images/cms/adani-power-bcover.jpg" width="100%"></div>
