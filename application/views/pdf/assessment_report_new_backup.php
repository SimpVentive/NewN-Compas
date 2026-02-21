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
 
$path1 = BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['ass_id'].'/over_all'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'.svg';
$type1 = pathinfo($path1, PATHINFO_EXTENSION);
$data1 = url_get_contents($path1);
$base64_new = 'data:image/' . $type1 . ';base64,' . base64_encode($data1);

?>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  
  <title>Competency Assessment Report</title>
  
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
		font-family: "rockwell";
		color:#000;
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
		padding: 10px;
		font-family: "rockwell";
		color:#000;
		font-size: 12px;
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
		
	}
	p#second {
        color: rgb(00,63,127);
        font-family: times;
        font-size: 12pt;
        text-align: justify;
    }
	.fish { position: absolute; top: 570px; left: 150px; }
	.fish1 { position: absolute; bottom: 500px; left: 100px; text-align:left;}
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
	p {
		font-size: 14px;
		line-height: 25px;
	}
	ol li {
		font-size: 14px;
		padding:0px;
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
	<div id="overlay"><img src="public/PDF/images/cms/employee_final.jpg" width="99.9%"></div>
	<img src="<?php echo LOGO_IMG; ?>" style="margin:0.15cm 0.2cm" width="176" height="66" class="fish"> 
	<label class="fish1"><b style="font-size:22px;color:#000;"><?php echo $emp_info['name']; ?></b><br><b style="font-size:14px;color:#000;"><?php echo @$posdetails['position_name']; ?></b></label>
	

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
		<?php $aa=defined('LOGO_IMG2')?TRUE:FALSE; if($aa){ ?><img src="<?php echo LOGO_IMG2; ?>" style="margin:0.15cm 0.2cm;float:right;" width="176" height="66"><?php } ?>
	</div>

	<div class="footer">
	  <div style="text-align: right;color:#000;margin-right:50px;">N-Compas.com</div>
	</div>

	<div class="body">
		<div style="height: 780px;bottom:0px;">&nbsp;</div>
		<p style="color:red;padding-left:5px;">
		NOTE:This report and its contents are the property of <?php echo $emp_info['parent_organisation'];?> and no portion of the same should be copied or reproduced without the prior permission of <?php echo $emp_info['parent_organisation'];?>.</p>
		<p style="color:red;padding-left:5px;">The report is a part of the Selection process of <?php echo $emp_info['name']; ?>, for the post of <?php echo @$posdetails['position_name']; ?></p>

	</div>
	<div style="page-break-after: always;"></div>
	<div class="body">
	<h3 class="title"  style="text-align:right;">1.Introduction</h3>
	<h4 class="titleheader">WHAT IS THE COMPETENCY BASED INTERVIEWING</h4>
	<p>Competencies and competency mapping process can be used for all activities along the HR value chain, including that for recruitment.Since the competencies required for various positions have been mapped, that is the critical competencies for the position have been identified; in the process of recruitment the focus could therefore be on these.  Also, the competency profile of the position, describes the needs of the job, in terms of the other knowledge and skill requirements for the position being filled.  </p>
	<h4 class="titleheader">WHAT IS COMPETENCY SELF ASSESSMENT?</h4>
	<p>As a part of the selection process, <?php echo $emp_info['parent_organisation'];?> is using a self assessment for candidature evaluation. This is a PART of the selection process and the inputs have to be used in conjunction with other inputs in making the final selection.  </p>
	<p>As a part of the self-assessment, the candidate was sent the job description, the competency profile.  The candidate had been instructed to rate himself /herself on the pre identified competencies (based on competency profile of the position) .  The rating would have been done based on a combination of  knowledge, experience and exposure in the  identified set of competencies.  </p>
	<h4 class="titleheader">HOW TO USE SELF ASSESSMENT IN THE SELECTION PROCESS?</h4>
	<p>The primary purpose of this assessment report is for a  first level filtration and/or  as selection input.  The preliminary assessment provides for the following </p>
	<ol>
		<li>An indicator on where the candidate feels he/she stands with regards the identified competencies</li>
		<li>Based on the information provided as to why he/she has rated himself the way they have, and you as a selection member would get a perspective on their approach, prior exposure in the given areas</li>
		<li>Juxtapose the data and information collected during the process of interview to verify some of the aspects in the self-assessment process </li>
	</ol>
	</div>
	<div style="page-break-after: always;"></div>
	<div class="body">
	<h4 class="titleheader">SOME DO’S AND DON’T’S?</h4>
	<p>While this self assessment report provides a good starting point, and at times a pre-interview judgement making enabler, there are a set of some DO’s and DON’T’s with regards useage of this report and the information therein. </p>
	<b>DO’s</b>
	<ol>
		<li>Ensure that you are able to validate the information provided by candidate, by asking relevant and pertinent follow up questions, to the rating information.</li>
		<li>Juxtapose the data and information from the interview process to arrive a comprehensive picture. </li>
		<li>Probe into areas where the candidate has rated himself/herself either very high or low (in any given competency)</li>
	</ol>
	<b>DO’s</b>
	<ol>
		<li>Do not use the information in the report as the sole criteria for the selection process </li>
		<li>Do not ask for explanation for a rating in manner which may seem as investigative – remember that most people often rate themselves higher during the self-assessment process  </li>
	</ol>
	<div style="height: 320px;padding-bottom:60px;">&nbsp;</div>
	<div style="padding-bottom:20px;">
		<p>Note:  For further information on Competencies, Competency modelling and assessment, please refer to the FAQ section in <a href="http://n-compas.com/" target="_blank">www.N-Compas.com </a></p>
	</div>
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
			<tbody>
				<tr class="row header">
					<td class="normal" style="width:50%"><b>Reports to</b></td>
					<td class="normal" style="width:50%"><b>Reportees</b></td>
				</tr>
				<tr>
					<td class="normal" ><?php echo @$posdetails['reportsto']; !empty($posdetails['reportsto'])?"":"-";?></td>
					<td class="normal"><?php echo @$posdetails['reportees_name']; !empty($posdetails['reportees_name'])?"":"-";?></td>
				</tr>
			</tbody>
		</table>
		<h4 class="titleheader">Position Description</h4>
		<table>
			<tbody>
				<tr class="row header">
					<td class="normal" style="width:33%"><b>Education Background</b></td>
					<td class="normal" style="width:33%"><b>Experience</b></td>
					<td class="normal" style="width:33%"><b>Industry Experience</b></td>
				</tr>
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
		<b>The Job, <?php echo $emp_info['position_name']; ?>  whose description is provided in the above section, would require Competencies  - Functional, Managerial and Behavioural, to ensure that the objectives/goals or KRAs are achieved.  However, the various competencies required for this or other job are not required, one at the same Proficiency level and two, at the same level of criticality (please notes below).
		<br>Each competency has been defined in Four Levels</b>
		<?php 
		foreach($scale_info as $scale_infos){
		?>
		<p><b><?php echo $scale_infos['scale_name'];?>:</b><?php echo $scale_infos['description'];?></p>
		<?php
		}
		?>
		<p>The second dimension, in Competency Profiling is called the Level of Criticality, which in turn is split into three categories
		</p>
		<?php 
		foreach($cri_info as $cri_infos){
		?>
		<p><b><?php echo $cri_infos['name'];?>:</b><?php echo $cri_infos['description'];?></p>
		<?php
		}
		?>
		<p>In the process of assessment or interviewing, it is preferable to focus first on the Critical competencies and then on those that are classified as Important.  If time permitting, those in the Less Important category can be touched upon. </p>
	</div>
	<div style="page-break-after: always;"></div>
	<div class="body">
		<h3 class="titleheader">Competency/Skill Requirements</h3>
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
				$assessor[]=$ass_comp_infos['assessor_id'];
				$assessor_id=$ass_comp_infos['assessor_id'];
				$comp_id=$ass_comp_infos['comp_def_id'];
				$req_scale_id=$ass_comp_infos['req_scale_id'];
				$results[$comp_id]['comp_name']=$ass_comp_infos['comp_def_name'];
				$results[$comp_id]['req_scale_id']=$ass_comp_infos['req_scale_id'];
				$results[$comp_id]['req_scale_name']=$ass_comp_infos['req_scale_name'];
				$results[$comp_id]['assessment_id']=$ass_comp_infos['assessment_id'];
				$results[$comp_id]['position_id']=$ass_comp_infos['position_id'];
				$results[$comp_id]['employee_id']=$ass_comp_infos['employee_id'];
				$results[$comp_id]['comp_cri_name']=$ass_comp_infos['comp_cri_name'];
				$results[$comp_id][$assessor_id]['overall_id']=$ass_comp_infos['final_scaled_id'];
				$results[$comp_id][$assessor_id]['overall_name']=$ass_comp_infos['final_scaled_name'];
				$results[$comp_id][$assessor_id]['development']=$ass_comp_infos['development_area'];
				
			}
			//print_r($results);
			foreach($results as $comp_def_id=>$result){
				$final_admin_id=$_SESSION['user_id'];
				$ass_comp=UlsAssessmentReport::getadminassessment_competencies_insert($result['assessment_id'],$result['position_id'],$result['employee_id'],$final_admin_id,$comp_def_id);
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
	</div>
	<div style="page-break-after: always;"></div>
	
	<div class="body">
		<h3 class="title"  style="text-align:right;">4. Assessment Methods</h3><br>
		<?php /* <h4 class="titleheader">Assessments Methods</h4> */ ?>
		<div>The following Assessment methods are being used as a part of the pre-interview/ selection process.</div>
		<br><br>
		<table>
			<tbody>
			<tr class="row header">
				<td class="normal">S.No</td>
				<td class="normal">Assessment Type</td>
				<!--<th>Assessment Weightages</th>-->
				<td class="normal">Duration</td>
			</tr>
			
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
	<?php 
	foreach($testtypes as $testtype){ 
		if($testtype['assessment_type']=="TEST" || $testtype['assessment_type']=="INTERVIEW" ){
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
				
		        <br><b>Q<?php echo $keys.")"; ?></b>&nbsp;<?php echo $que['question_id']."-".$que['question_name'];?><br>
				
			<?php	
			   $ss=Doctrine_Query::create()->select('value_id,text,correct_flag')->from("UlsQuestionValues")->where("question_id=".$que['question_id'])->execute();
			  
			   $empdetail=UlsMenu::callpdorow("SELECT * FROM `uls_utest_responses_assessment` WHERE `assessment_id`=".$_REQUEST['ass_id']." and test_type='".$testtype['assessment_type']."' and `employee_id`=".$_REQUEST['emp_id']." and `user_test_question_id`=".$que['question_id']);
			   if($type=='S' || $type=='M'){ echo "<ol>"; }
		       foreach($ss as $key1=>$sss){
				   $col=$sss['correct_flag']=='Y'? 'style="color:green;font-family:italic;"':'';
				   $col2=$empdetail['response_value_id']==$sss['value_id']?'style="color:blue;font-family:italic;"':'';
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
					    <li type='A' <?php echo $col;?> <?php echo $col2;?>><?php echo trim(strip_tags($sss['text']));?></li>
					    
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
		 b.	Marked in <font color="green">GREEN</font>:  Suggested/recommended answer/option <br>
		 C.	Marked in <font color="green">GREEN</font>:  Applicant and Suggested/recommended answer/option are Correct </span>
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
					<h3 class="title"  style="text-align:right;">What is an In-Basket Exercise?</h3>
					<?php /*<h2 style="text-align:center"><?php echo @$inbasket['inbasket_name']; ?></h2><p>&nbsp;</p>
					<h4 class="titleheader">What is an In-Basket Exercise?</h4> */ ?>
					<div>An In-Basket or an Intray is a list of items of work that need to be to be attended to when you come to work.  These could include mails, calls (mobile, intercom), reports, meetings, visits by you or by others, etc.  For the various items in the In-Basket/intray, there would be a certain approach you would take – for exampling first attending the mail items, or the work from the previous day; and for each of them you would decide the kind of action you want to take and/or delegate the same.  Whatever you decide, is a reflection of your style of work and also tells how you prioritize and plan your work.<br><br>
					In the following excercize,  you will role-play the person mentioned in the In-basket narration and help him/her plan the items of work that he/she needs to be doing.<br><br>
					Please read the In-Basket Narration and Instructions carefully before starting.</div>
					
				</div>
				<div style="page-break-after: always;"></div>
				<div class="body">
					
					<?php if(!empty($inbasket['inbasket_narration'])){ ?>
					<h4 class="titleheader">In-Basket Narration</h4>
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
				<h4 class="titleheader">In-Basket Instructions</h4>
				<div><?php echo nl2br($inbasket['inbasket_instructions']); ?></div>
				<?php } ?>
				</div>
					<div style="page-break-after: always;"></div>
				<div class="body">
				<h4 class="titleheader">In-Basket Exercise</h4>
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
							<h4 class="titleheader_new"><?php echo $scorting_arrow; ?> Intray <?php echo $keyy; ?> - <?php echo $question_views['comp_def_name']; ?> : <?php echo $question_views['scale_name']; ?></h4>
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
						<h4 class="titleheader">In-Basket: Analysis and Interpretation</h4>
					
					<table>
						<tr><td>Applicant Priority</td><td>Action & Description</td><td>Competency</td><td>Level</td><td>SME Priority</td></tr>
						<?php
							//echo $empdetailinbasket['text'];
							$inbaskets=json_decode($empdetailinbasket['text'], true); 
							if(is_array($inbaskets)){
							foreach($inbaskets as $inbasket){
								$b=$inbasket['id'];
								$smep=!empty($priority[$b])?$priority[$b]:"NA";
								echo "<tr><td>".$intrayss[$b]."</td><td>".$inbasket['action']."<br>".$inbasket['text']."</td><td>".$compp[$b]."</td><td>".$scall[$b]."</td><td>".$smep."</td></tr>";
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
				<h3 class="title"  style="text-align:right;">Case Study/Caselet</h3>
				<!--<h4 class="titleheader">Case Study/Caselet</h4>
				<h2 style="text-align:center"><?php echo @$case_details['casestudy_name']; ?></h2>
				<?php if(!empty($case_details['casestudy_link'])){?>
				<p>Link: <a href="<?php echo @$case_details['casestudy_link']; ?>" target="_blank" >Click Here</a></p>
				<?php } ?>
				<p>&nbsp;</p>-->
				<div><?php echo $case_details['casestudy_description']; ?></div>
				<?php $case_study_questions=UlsCaseStudyQuestions::viewcasestudyquestion($nocase['casestudy_id']); ?>
				
				<h4 class="titleheader">Questions</h4>
				<?php foreach($case_study_questions as $case_study_question){
					$empdetailcase=UlsMenu::callpdorow("SELECT * FROM `uls_utest_responses_assessment` WHERE `assessment_id`=".$_REQUEST['ass_id']." and `employee_id`=".$_REQUEST['emp_id']." and test_type='CASE_STUDY' and `user_test_question_id`=".$case_study_question['casestudy_quest_id']);
					
					$empdetailcaseattach=UlsMenu::callpdorow("SELECT * FROM `uls_utest_attempts_assessment` WHERE `assessment_id`=".$_REQUEST['ass_id']." and `employee_id`=".$_REQUEST['emp_id']." and test_type='CASE_STUDY' and status='A'");
					?>
				<div><b><?php echo $case_study_question['casestudy_quest']; ?></b></div>
				<div style="color:blue;font-family:italic;"><?php echo @$empdetailcase['text']; ?></div>
				<?php if(!empty($empdetailcaseattach['inbasket_upload'])){ ?>
				Please Click on
					<a href="<?php echo BASE_URL; ?>/public/uploads/employee_casestudy/<?php echo $empdetailcaseattach['inbasket_upload'];?>" parent="_blank">Attachment</a> to view Applicant add document.
				<?php } ?>
				<?php } ?>
				</div>
			<?php } ?>
			<?php } ?>
	</div>
	<?php } ?>
</body>
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
</div>
<div style="page-break-after: always;"></div>
	
<div class="body">
	<h3 class="title"  style="text-align:right;">6. Assessment Summary Sheet</h3><br>
	<br><br>
	<table>
		<tbody>
		<tr class="row header">
			<td class="normal">S.No</td>
			<td class="normal">Assessment Method</td>
			<td class="normal">Total Question</td>
			<td class="normal">Answered Correctly/Rating</td>
			<td class="normal">Percentage Scored (%)</td>
			<td class="normal">Weightage for Assessment Method (%)</td>
			<td class="normal">Weighted Score</td>
		</tr>
		
		<?php $i=1;
		$score='';
		$wei_sum=0;
		$wei_total=0;
		foreach($assessor_rating as $assessor_ratings){
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
					$score=round($assessor_ratings['rat_num'],2);
					echo $score_f=$score;
				} 
				?></td>
				<td><?php
				if($assessor_ratings['assessment_type']=='TEST'){
					echo $score_test=(($assessor_ratings['test_score']/$assessor_ratings['test_ques'])*100);
				}
				else{
					echo $score=((round($assessor_ratings['rat_num'],2)/$assessor_ratings['rating_scale'])*100);
				} 
				?></td>
				<td><?php echo $assessor_ratings['weightage']; ?></td>
				<td><?php
				$score_final=$scorefinal=0;
				if($assessor_ratings['assessment_type']=='TEST'){
					$score_test=(($assessor_ratings['test_score']/$assessor_ratings['test_ques'])*100);
					$wei=$assessor_ratings['weightage'];
					echo $score_final=(($score_test*$wei)/100);
				}
				else{
					$score=((round($assessor_ratings['rat_num'],2)/$assessor_ratings['rating_scale'])*100);
					$wei=$assessor_ratings['weightage'];
					echo $scorefinal=(($score*$wei)/100);
				} 
				$wei_total=$wei_total+($score_final+$scorefinal);
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
	<p style="color:red;padding-left:5px;font-size:10px;">
	For Inbasket and Case, Rating scale of 1 to 4 <br>
	<?php 
	foreach($ass_rating_scale as $ass_rating_scales){
	?>
	<span><?php echo $ass_rating_scales['rating_number'];?>-<?php echo $ass_rating_scales['rating_name_scale'];?></span>
	<?php
	}
	?>
	</p>
	<br>
	<p><img src="<?php echo $base64_new;?>" style="width:98%;" /></p>
</div>
<div style="page-break-after: always;"></div>
	
<div class="body">
	<h3 class="title"  style="text-align:right;">7. Development Road Map</h3><br>
	<br><br>
	<?php
	$tt="";
	foreach($ass_development as $ass_developments){
		echo "<h4 class='titleheader'>".$ass_developments['comp_def_name']."</h4>";
	?>
	<p><?php 
	//echo $ass_developments['dev_area'];
	$dev=explode('**',$ass_developments['dev_area']);
	foreach($dev as $devs){
		echo $devs."<br>";
	}
	?>
	</p>
	<?php
	}
	?>
</div>
<div style="page-break-after: always;"></div>

<div id="overlay2"><img src="public/PDF/images/cms/competencyassessmentreportback.jpg" width="100%"></div>
