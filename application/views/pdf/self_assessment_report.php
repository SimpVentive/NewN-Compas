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
  
  <title>Self Assessment Report</title>
  
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
		background: #999 none repeat scroll 0 0;
		color: #ffffff;
		font-weight: 900;
	}
	ul,ol,li{
		margin:0px 5px;
		padding:0px;
	}
	.fish { position: absolute; top: 250px; left: 170px; }
	.fish1 { position: absolute; bottom: 450px; left: 520px; }
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
	.titleheader {
		background: #ea6153;
		color:#fff;
		border: 1px solid #333;
		border-radius: 0.25rem;
		margin-bottom: 1rem;
		padding: 0.60rem 1.25rem;
		position: relative;
		
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
		background: red;
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
		font-size: 20pt;
	}
  </style>
  
</head>

<div class="flyleaf">
	<div id="overlay"><img src="public/PDF/images/cms/competencyassessmentreport-full.jpg" width="100%"></div>
	<img src="<?php echo LOGO_IMG; ?>" style="margin:0.15cm 0.2cm" width="176" height="66" class="fish"> 
	<label class="fish1"><b style="font-size:22px;color:#fff;text-align: left;"><?php echo @$posdetails['position_name']; ?></b></label>
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
	<div style="height: 780px;bottom:0px;">&nbsp;</div>
	<p style="color:red;padding-left:5px;">
	NOTE:This report and its contents are the property of <?php echo $posdetails['parent_organisation'];?> and no portion of the same should be copied or reproduced without the prior permission of <?php echo $posdetails['parent_organisation'];?>.</p>

</div>

<div style="page-break-after: always;"></div>
<div class="body">
<h3 class="title"  style="text-align:right;">1.Introduction</h3>
<h4 class="titleheader">WHAT ARE COMPETENCIES</h4>
<p>Competencies are a combination of Knowledge Skill and Attitude.  Knowledge is defined as that information, data, understanding gained through structured process, such as education or training.  Skill is practised ability or the expertise gained through applying ones knowledge.  Attitude in this context is defined as the inclination to better one self through constant upgradation of knowledge and wanting to apply the same at the workplace</p>
<p><img src="public/PDF/images/cms/self.jpg" style="align:center;"></p>
<h4 class="titleheader">WHAT IS COMPETENCY ASSESSMENT </h4>
<p>Organizations in order to maintain their competitive advantage need constantly invest in their people – by reskilling and/or upskilling them.  This process of  enhancing the skill sets is done along those competencies which are crucial for the organization and the positions therein.  The process of carrying out a structured method to determine where a current employee is, especially with respect to the competencies required for the position, he/she is manning, is called competency assessment </p>
<h4 class="titleheader">WHAT IS COMPETENCY SELF-ASSESSMENT?</h4>
<p>In the process of developing on competencies, one of the most important dimensions is to ascertain where the individual presently perceives himself/herself to be at.  This process, usually referred to as self-assessment enables one to make an honest, usually qualitative judgement on where one believes he/she is pegged on the various competencies required for his/her job.  </p>
<p>During the course of assessment, one must make a realistic assessment of where he/she is on various competencies.  Since the process of self-assessment is mostly used for the development purposes, the more realistic one is, better are the development opportunities.</p>

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
			<td class="normal"><?php echo @$posdetails['position_org_name']; !empty($posdetails['position_org_name'])?"":"-";?></td>
		</tr>
		<tr>
			<td class="normal"><b>Location</b></td>
			<td class="normal"><?php echo @$posdetails['location_name']; !empty($posdetails['location_name'])?"":"-"; ?></td>
			<td class="normal"><b></b></td>
			<td class="normal"></td>
		</tr>
	</tbody>
</table>
<?php 
if(!empty($posdetails['reportsto'])){
?>
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
<?php } 
if(!empty($posdetails['education']) || !empty($posdetails['experience']) || !empty($posdetails['specific_experience'])){
?>
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
<?php 
}
if(!empty($posdetails['other_requirement'])){ ?>
<h4 class="titleheader">Other Requirements:</h4><p><?php echo @$posdetails['other_requirement']; ?></p>
<?php } ?>
<h4 class="titleheader">Purpose:</h4><p><?php echo @$posdetails['position_desc']; ?></p>
<h4 class="titleheader">Accountabilities:</h4><p><?php echo @$posdetails['accountablities']; ?></p>
<?php if(count($kras)>0){ ?>
	<h3 class="titleheader">KRA & KPI</h3>
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
<div class="body">
<h3 class="title"  style="text-align:right;">3.Competency Profile</h3>
The Job, <?php echo $posdetails['position_name']; ?>  whose description is provided in the above section, would require Competencies  - Functional, Managerial and Behavioural, to ensure that the objectives/goals or KRAs are achieved.  However, the various competencies required for this or other job are not required, one at the same Proficiency level and two, at the same level of criticality (please notes below).
<br>Each competency has been defined in Four Levels in Case of Functional Competencies and Five Levels in Case of Behavioural Competencies.
<?php 
$tmp="";$j=0;
foreach($scale_info as $scale_infos){
	
	if($scale_infos['level_id']!=$tmp){
		$tmp=$scale_infos['level_id'];
		if($j==0){
			$j++;
			echo "<p><b>Following is the scale being used for Functional Competency Assessment</b></p>";
		}
		else{
			echo "<p><b>Following is the scale being used for Behavioural Competency Assessment</b></p>";
		}
	}
?>
<p><b><?php echo $scale_infos['scale_name'];?>:</b><?php echo $scale_infos['description'];?></p>
<?php
}
?><br>
<b>The second dimension, in Competency Profiling is called the Level of Criticality, which in turn is split into three categories
</b>
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
<h4 class="titleheader">Competency Profile</h4><br>
<?php
foreach($category as $categorys){
	$competencies=UlsCompetencyPositionRequirements::getcompetencypositionrequirements_cat($_REQUEST['pos_id'],$categorys['category_id']);
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
	?>
		<tr>
			<td><?php echo $competency['comp_def_name']; ?></td>
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
<div style="page-break-after: always;"></div>

<?php 
foreach($ass_comp as $key=>$ass_comps){
	$path = BASE_URL.'/public/reports/graphs/self/'.$_REQUEST['ass_id'].'/'.$ass_comps['category_id'].'_'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'_radar.png';
	$type = pathinfo($path, PATHINFO_EXTENSION);
	$data = url_get_contents($path);
	$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
	$key1=$key+4;
	$ass_comp_info=UlsSelfAssessmentReport::getassessment_self_admin_summary($ass_id,$_REQUEST['pos_id'],$_REQUEST['emp_id'],$ass_comps['category_id']);
	if(count($ass_comp_info)>0){
	?>
	<div class="body">
	<?php
	if($key==0){ ?>
		<h3 class="title"  style="text-align:right;">4.Self Assessment Results</h3>
	<?php 
	}
	?>
	<h4 class="titleheader"><?php echo $ass_comps['name']; ?></h4>
	<?php
	$comp_name=array();
	foreach($ass_comp_info as $result){
		$level=$result['level_scale'];
		$comp_name[]=$result['comp_def_name'];
		$req_sid=round((($result['req_number']/$level)*100),1);
		$ass_sid=round((($result['ass_number']/$level)*100),1);
		?>
		<div id="header">
			<h4>Competency Name:<?php echo $result['comp_def_name']; ?></h4>
			<p><h4>Description:</h4><?php echo $result['comp_def_short_desc'];?></p>
			<br>
		</div>
		<div id="main-content">
			<div class="w3-container">
				<div class="w3-light-grey">
				  <div style="width:<?php echo $req_sid; ?>%" class="w3-container w3-green w3-center"><?php echo $result['req_scale_name']; ?></div>
				</div><br>
				<div class="w3-light-grey">
				  <div style="width:<?php echo $ass_sid; ?>%" class="w3-container w3-blue w3-center"><?php echo $result['final_scaled_name']; ?></div>
				</div><br>
			</div>
	
			<div style="padding:15px">
				<?php
				foreach($cri_info as $cri_infos){
					$cir=($cri_infos['comp_cri_code']==$result['comp_cri_code'])?"":"red-circle";
				?>
				<div class="circle <?php echo $cir;?>"></div><span>&nbsp;<?php echo $cri_infos['name'] ?>&nbsp;&nbsp;</span>     
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
	<div class="body">
	<h3 class="titleheader">Radar Graph for <?php echo $ass_comps['name']; ?></h3>
	<table width="100%">
		<tbody>
			<tr>
				<td width="60%"><img src="<?php echo $base64;?>"   style="height:60%;padding-top:10px; border-bottom:thin solid  #000;"/></td>
				<td width="40%" align="top">
					<?php 
					$par=array("A","B","C","D","E","F","G","H","I","J","K","L","M");
					$sd=array();
					
					for($i=0;$i<count($comp_name); $i++){
						$sd=$par[$i];
						echo $sd ."-".$comp_name[$i]; echo "<br />";
					}
					?>
				</td>
			</tr>
		</tbody>
	</table>
	</div>
	<div style="page-break-after: always;"></div>
	<div class="body">
	
	<h3 class="titleheader">Vectorization for <?php echo $ass_comps['name']; ?></h3>
	<table>
		<thead>
		<tr  class="row header">
			<th style="width:25%">Competency name</th>
			<th style="width:15%">Criticality</th>
			<th style="width:21%">Required Level</th>
			<th style="width:21%">Assessed Level</th>
			<th style="width:18%">Vectorized Value</th>
		</tr>
		</thead>
		<tbody>
		<?php 
		$vec_sum=0;
		foreach($ass_comp_info as $result){
			$req_v=$result['comp_rating_value'];
			$req_sid=$result['req_number'];
			$ass_sid=$result['ass_number'];
			$vec=(($ass_sid-$req_sid)*$req_v);
			$vec_sum=$vec_sum+(($ass_sid-$req_sid)*$req_v);
		?>
			<tr>
				<td><?php echo $result['comp_def_name']; ?></td>
				<td><?php echo $result['comp_cri_name']; ?></td>
				<td><?php echo $result['req_scale_name']; ?></td>
				<td><?php echo $result['final_scaled_name']; ?></td>
				<td>
				<?php  echo $vec;?></td>
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
<?php 
	}
} 
if($ass_details['self_ass_type']=='IS'){?>
<div class="body">
<h3 class="title"  style="text-align:right;">5.Development Road Map</h3>
<p>You have drawn up the following development Road Map for the purpose of improving yourself in the various competencies</p>
<h4 class="titleheader">Knowledge</h4>
<p><?php echo !empty($ass_dev_info['knowledge_dev'])?$ass_dev_info['knowledge_dev']:""; ?></p>
<h4 class="titleheader">Skill</h4>
<p><?php echo !empty($ass_dev_info['skill_dev'])?$ass_dev_info['skill_dev']:""; ?></p>
</div>
<?php } 
if($ass_details['self_ass_type']=='FS'){?>
<div class="body">
<h3 class="title"  style="text-align:right;">5.Individual Professional & Career Development Plan</h3>
<p>This plan is a planning and monitoring tool that is created to enable you to prepare your professional and career plan – which you along with your superior and/or mentor can review, monitor and guide you towards your goals</p>
<h4 class="titleheader">A.Career Planning</h4>
<p>What are your career goals?  (in line with the Vision you have for your Career) </p>
<table>
	<thead>
	<tr>
		<th colspan="3"><b>SML</b> Goals</th>
	</tr>
	<tr class="row header">
		<th style="width:35%">Short Term Goals</th>
		<th style="width:35%">Medium Term Goal</th>
		<th style="width:30%">Long Term Goal</th>
	</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo !empty($ass_dev_info['short_term_goals'])?$ass_dev_info['short_term_goals']:""; ?></td>
			<td><?php echo !empty($ass_dev_info['medium_term_goals'])?$ass_dev_info['medium_term_goals']:""; ?></td>
			<td><?php echo !empty($ass_dev_info['long_term_goals'])?$ass_dev_info['long_term_goals']:""; ?></td>
		</tr>
	</tbody>
</table>
<p>Now that you have done a self-assessment you know the various strengths that you can leverage and development needs that need to be addressed, so as to achieve your above goals</p>

<h4 class="titleheader">B.Strengths</h4>
<?php
foreach($category as $categorys){
	$competencies_name=UlsSelfAssessmentReport::getassessment_self_category($_REQUEST['ass_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id'],$categorys['category_id']);
	?>
	<h4 class="titleheader"><?php echo $categorys['name']; ?></h4>
	<table>
		<thead>
		<tr class="row header">
			<th>Competencies</th>
		</tr>
		</thead>
		<tbody>
		<?php
		if(count($competencies_name)>0){
			foreach($competencies_name as $key=>$competencies_names){
			?>
				<tr>
					<td><?php echo $competencies_names['comp_def_name']; ?></td>
				</tr>
			<?php			
			}
		}
		else{
		?>
			<tr>
				<td>No competencies selected.</td>
			</tr>
		<?php
		}
		?>
		</tbody>
	</table>
<?php
}
?>
<p>How would want to leverage on your Strengths.  Examples of leveraging on your strength could include, coaching some one, taking up special projects, becoming a team member to help groups/others, etc</p>
<p><?php echo !empty($ass_dev_info['leverage'])?$ass_dev_info['leverage']:""; ?></p>
<h4 class="titleheader">C.Development Planning</h4>
<table>
	<thead>
	<tr class="row header">
		<th>Competency</th>
		<th>Knowledge/Skill</th>
		<th>Method </th>
		<th>Org. Support Requirement</th>
		<th>Targeted Date for Completion </th>
		<th>Evidence of competition </th>
	</tr>
	</thead>
	<tbody>
	<?php
	foreach($ass_report_info as $ass_report_infos){
	?>
		<tr>
			<td><?php echo $ass_report_infos['comp_def_name']; ?></td>
			<td><?php echo $ass_report_infos['knowledge_skill']; ?></td>
			<td><?php echo $ass_report_infos['method_value_name']; ?></td>
			<td><?php echo $ass_report_infos['org_support']; ?></td>
			<td><?php echo $ass_report_infos['target_date']; ?></td>
			<td><?php echo $ass_report_infos['comp_evidence']; ?></td>
		</tr>
	<?php
	}
	?>
	</tbody>
</table>
<p>Review: When do you want to review this development plan?</p>
<p><?php echo !empty($ass_dev_info['review_value_name'])?$ass_dev_info['review_value_name']:""; ?></p>
<p>Have you discussed this development plan with your Reporting Manager 	</p>
<p><?php echo !empty($ass_dev_info['reporting_value_name'])?$ass_dev_info['reporting_value_name']:""; ?></p>	
</div>	
<?php
} ?>
</body>
<div style="page-break-after: always;"></div>
<div id="overlay2"><img src="public/PDF/images/cms/competencyassessmentreportback.jpg" width="100%"></div>