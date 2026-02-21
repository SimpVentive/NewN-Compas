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
 $path = BASE_URL.'/public/reports/graphs/full/'.$_REQUEST['ass_id'].'/'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'_radar.png';
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = url_get_contents($path);
 $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

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
	.fish1 { position: absolute; bottom: 500px; left: 30px; }
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
	<label class="fish1"><b style="font-size:22px;color:#000;text-align: left;"><?php echo @$posdetails['position_name']; ?></b></label>
	

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
		<h3 class="title"  style="text-align:right;">4.Final Assessment Results</h3>
		<?php 
		$results=$assessor=$comname=array();
		foreach($ass_comp_info as $ass_comp_infos){
			$assessor[]=$ass_comp_infos['assessor_id'];
			$assessor_id=$ass_comp_infos['assessor_id'];
			$comp_id=$ass_comp_infos['comp_def_id'];
			$req_scale_id=$ass_comp_infos['req_scale_id'];
			$results[$comp_id]['comp_name']=$ass_comp_infos['comp_def_name'];
			$results[$comp_id]['comp_def_short_desc']=$ass_comp_infos['comp_def_short_desc'];
			$results[$comp_id]['req_scale_id']=$ass_comp_infos['req_scale_id'];
			$results[$comp_id]['comp_cri_code']=$ass_comp_infos['comp_cri_code'];
			$results[$comp_id]['req_scale_name']=$ass_comp_infos['req_scale_name'];
			$results[$comp_id]['req_scale']=$ass_comp_infos['req_scale'];
			$results[$comp_id]['level_scale']=$ass_comp_infos['level_scale'];
			$results[$comp_id]['assessment_id']=$ass_comp_infos['assessment_id'];
			$results[$comp_id]['comp_rating_value']=$ass_comp_infos['comp_rating_value'];
			$results[$comp_id]['position_id']=$ass_comp_infos['position_id'];
			$results[$comp_id]['employee_id']=$ass_comp_infos['employee_id'];
			$results[$comp_id]['comp_cri_name']=$ass_comp_infos['comp_cri_name'];
			$results[$comp_id][$assessor_id]['overall_id']=$ass_comp_infos['final_scaled_id'];
			$results[$comp_id][$assessor_id]['overall_name']=$ass_comp_infos['final_scaled_name'];
			$results[$comp_id][$assessor_id]['development']=$ass_comp_infos['development_area'];
			
		}
		//print_r($results);
		$vec_sum=0;
		foreach($results as $comp_def_id=>$result){
			$final_admin_id=$_SESSION['user_id'];
			$ass_comp=UlsAssessmentReport::getadminassessment_competencies_insert($result['assessment_id'],$result['position_id'],$result['employee_id'],$final_admin_id,$comp_def_id);
			$level_id=UlsCompetencyDefinition::viewcompetency($comp_def_id);
			$scale_overall=UlsLevelMasterScale::levelscale_detail($ass_comp['assessed_scale_id']);
			$req_v=$result['comp_rating_value'];
			$req_scale_id=$result['req_scale_id'];
			$ass_scale_id=$ass_comp['assessed_scale_id'];
			$ass_scale_name=$scale_overall['scale_name'];
			$req_sid=$result['req_scale'];
			$ass_sid=$scale_overall['scale_number'];
			$level=$result['level_scale'];
			$comname[]=$result['comp_name'];
			$reqsid=round((($result['req_scale']/$level)*100),1);
			$asssid=round((($scale_overall['scale_number']/$level)*100),1);
		?>
		<div id="header">
		<h4>Competency Name:<?php echo $result['comp_name']; ?></h4>
		<p><h4>Description:</h4><?php echo $result['comp_def_short_desc'];?></p>
		<br>
		
		</div>
		<div id="main-content">
			<div class="w3-container">
			
			<div class="w3-light-grey">
			  <div style="width:<?php echo $reqsid; ?>%" class="w3-container w3-green w3-center"><?php echo $result['req_scale_name']; ?></div>
			</div><br>

			<div class="w3-light-grey">
			  <div style="width:<?php echo $asssid; ?>%" class="w3-container w3-blue w3-center"><?php echo $ass_scale_name; ?></div>
			</div><br>

			</div>
		
			<div style="padding:15px">
				<?php
				foreach($cri_info as $cri_infos){
					$cir=($cri_infos['comp_cri_code']==$result['comp_cri_code'])?"":"red-circle";
				?>
				<div class="circle <?php echo $cir;?>"></div><span>&nbsp;<?php echo $cri_infos['name'] ?></span><br>
				<?php } ?>
			</div>
		</div>
	
		<br style="clear:both;">
	
		<div class="style-one" style="width:100%;background-color:#000;height:1px;">&nbsp;</div>
		<?php
		
		}
		?>
		
	</div>
	<div style="page-break-after: always;"></div>	
	<div  class="body">
		<h3 class="title"  style="text-align:right;">5. Radar Graph</h3>
		<table width="100%">
			<tbody>
				<tr>
					<td width="60%"><img src="<?php echo $base64;?>"   style="height:70%;padding-top:10px; border-bottom:thin solid  #000;"/></td>
					<td width="40%" align="top">
						<?php 
						$par=array("A","B","C","D","E","F","G","H","I","J","K","L","M");
						$sd=array();
						
						for($i=0;$i<count($comname); $i++){
							$sd=$par[$i];
							echo $sd ."-".$comname[$i]; echo "<br />";
						}
						?>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div style="page-break-after: always;"></div>	
	<div class="body">
		<h3 class="title"  style="text-align:right;">6. Vectorization</h3>
		<table>
			<thead>
			<tr>
				<th style="width:20%">Competency name</th>
				<th>Criticality</th>
				<th style="width:15%">Required Level</th>
				<th>Assessed Level</th>
				<th>Vectorized Value</th>
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
				$results[$comp_id]['req_scale']=$ass_comp_infos['req_scale'];
				$results[$comp_id]['assessment_id']=$ass_comp_infos['assessment_id'];
				$results[$comp_id]['comp_rating_value']=$ass_comp_infos['comp_rating_value'];
				$results[$comp_id]['position_id']=$ass_comp_infos['position_id'];
				$results[$comp_id]['employee_id']=$ass_comp_infos['employee_id'];
				$results[$comp_id]['comp_cri_name']=$ass_comp_infos['comp_cri_name'];
				$results[$comp_id][$assessor_id]['overall_id']=$ass_comp_infos['final_scaled_id'];
				$results[$comp_id][$assessor_id]['overall_name']=$ass_comp_infos['final_scaled_name'];
				$results[$comp_id][$assessor_id]['development']=$ass_comp_infos['development_area'];
				
			}
			//print_r($results);
			$vec_sum=0;
			foreach($results as $comp_def_id=>$result){
				$final_admin_id=$_SESSION['user_id'];
				$ass_comp=UlsAssessmentReport::getadminassessment_competencies_insert($result['assessment_id'],$result['position_id'],$result['employee_id'],$final_admin_id,$comp_def_id);
				$level_id=UlsCompetencyDefinition::viewcompetency($comp_def_id);
				$scale_overall=UlsLevelMasterScale::levelscale_detail($ass_comp['assessed_scale_id']);
				$req_v=$result['comp_rating_value'];
				$req_scale_id=$result['req_scale_id'];
				$ass_scale_id=$ass_comp['assessed_scale_id'];
				$req_sid=$result['req_scale'];
				$ass_sid=$scale_overall['scale_number'];
				$vec=(($ass_sid-$req_sid)*$req_v);
				$vec_sum=$vec_sum+(($ass_sid-$req_sid)*$req_v);
			?>
				<tr>
					<td><?php echo $result['comp_name']; ?></td>
					<td><?php echo $result['comp_cri_name']; ?></td>
					<td><?php echo $result['req_scale_name']; ?></td>
					<td><?php echo $scale_overall['scale_name'];?></td>
					<td><?php echo $vec;?></td>
				</tr>
				
			<?php
			}
			?>
			<tr>
				<td colspan="4" align='right'>Total Vectorized value</td>
				<td><?php echo $vec_sum; ?></td>
			</tr>
			</tbody>
		</table>
	</div>
	<div style="page-break-after: always;"></div>

	<div class="body">
		<h3 class="title"  style="text-align:right;">7. Development Area</h3>
		<?php 
		$results=$assessor=array();
		foreach($ass_comp_info as $ass_comp_infos){
			$assessor[]=$ass_comp_infos['assessor_id'];
			$assessor_id=$ass_comp_infos['assessor_id'];
			$comp_id=$ass_comp_infos['comp_def_id'];
			$results[$comp_id]['comp_name']=$ass_comp_infos['comp_def_name'];
			$results[$comp_id]['comp_cri_name']=$ass_comp_infos['comp_cri_name'];
			$results[$comp_id]['assessment_id']=$ass_comp_infos['assessment_id'];
			$results[$comp_id]['position_id']=$ass_comp_infos['position_id'];
			$results[$comp_id]['employee_id']=$ass_comp_infos['employee_id'];
			$results[$comp_id][$assessor_id]['overall_id']=$ass_comp_infos['final_scaled_id'];
			$results[$comp_id][$assessor_id]['overall_name']=$ass_comp_infos['final_scaled_name'];
			$results[$comp_id][$assessor_id]['development']=$ass_comp_infos['development_area'];
			
		}
		//print_r($results);
		$vec_sum=0;
		foreach($results as $comp_def_id=>$result){
			$final_admin_id=$_SESSION['user_id'];
			$ass_comp=UlsAssessmentReport::getadminassessment_competencies_insert($result['assessment_id'],$result['position_id'],$result['employee_id'],$final_admin_id,$comp_def_id);
			$level_id=UlsCompetencyDefinition::viewcompetency($comp_def_id);
			$scale_overall=UlsLevelMasterScale::levelscale_detail($ass_comp['assessed_scale_id']);
			?>
			
			<h6 class="panel-title txt-dark"><?php echo $result['comp_name']; ?></h6>
			<p><?php echo !empty($ass_comp['development_area'])?$ass_comp['development_area']:""; ?></p>
			<br>
		<?php
		}
		?>
	</div>
	<?php
	if(!empty($beh_instrument['assess_test_id'])){
	$ass_detail_casestudy=UlsAssessmentTestBehavorialInst::getbeiassessment($beh_instrument['assess_test_id']);
	if(count($ass_detail_casestudy)>0){
	?>
	<div style="page-break-after: always;"></div>
	<div class="body">
		<h3 class="title"  style="text-align:right;">8. Behavorial Instrument Results</h3>
		<?php
		foreach($ass_detail_casestudy as $ass_detail_casestudies){
			$getpretest_inbasket=UlsBeiAttemptsAssessment::getattemptvalus_beh($ass_detail_casestudies['assessment_id'],$_REQUEST['emp_id'],$ass_detail_casestudies['assessment_type'],$ass_detail_casestudies['assess_test_id'],$ass_detail_casestudies['instrument_id']);
		?>
		<h6><?php echo $ass_detail_casestudies['instrument_name']; ?></h6>
		<b>Results:</b><p><?php echo !empty($getpretest_inbasket['admin_bei_result'])?$getpretest_inbasket['admin_bei_result']:""; ?></p>
		<b>Admin Comments:</b><p><?php echo !empty($getpretest_inbasket['admin_bei_comment'])?$getpretest_inbasket['admin_bei_comment']:""; ?></p>
		<?php
		}?>
	</div>
	
	<?php }
	}	?>
</body>
<div style="page-break-after: always;"></div>
<div id="overlay2"><img src="public/PDF/images/cms/competencyassessmentreportback.jpg" width="100%"></div>
