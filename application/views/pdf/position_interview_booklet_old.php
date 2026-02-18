<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  
  <title>Interview Booklet for <?php echo @$posdetails['position_name']; ?></title>
  
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
	
	.answer{
		text-align: left;
		padding: 10px;
		border: 1px solid #e3e3e3;
    }
	
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
	
	.titleheader {
		background: #999;
		color:#fff;
		border: 1px solid #333;
		border-radius: 0.25rem;
		margin-bottom: 1rem;
		padding: 0.60rem 1.25rem;
		position: relative;
	}
	
	.titleheadercomp {
		border: 1px solid #333;
		border-radius: 0.25rem;
		margin-bottom: 1rem;
		padding: 0.60rem 1.25rem;
		position: relative;
		background: #666;
		color:#fff;
		font-size:1.2em;
	}
		
	div.test2 {
		color: #000;
		background-color: #FFF;
		font-family: helvetica;
		font-size: 10pt;
		border:0px;
	
	}
	
	.flyleaf {
		page-break-after: always;	
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
	
	.fish { position: absolute; top: 130px; right: 20px; }
	.fish1 { position: absolute; bottom: 260px; left: 50px; }
	.headinfo { 
	   position: absolute; 
	   bottom: 200px; 
	   left: 0; 
	   width: 100%; 
	}
	
	div.test {
		color: #000;
		background-color: #FFF;
		font-family: helvetica;
		font-size: 10pt;
		border-style: solid solid solid solid;
		border-width: 2px 2px 2px 2px;
		border-color: #BC6F74;		
	}
	
	.row.header {
		background: #ea6153 none repeat scroll 0 0;
		color: #ffffff;
		font-weight: 900;
	}
	
	.row.header2 {
		background: #666 none repeat scroll 0 0;
		color: #ffffff;
		font-weight: 900;
	}
	
	.footer .page:after { content: counter(page, upper-roman); }
	
	.alert {
		padding: 2px;
		background-color: #f44336;
		color: white;
	}
	
	.question {
		background: #ea6153 none repeat scroll 0 0;
		color: #ffffff;
		font-weight: 900;
		padding:10px;
		border-radius: 0.25rem;
	}
	ul,ol,li{
		margin:0px 5px;
		padding:0px;
	}
  </style>
</head>
<div class="flyleaf">
	<div id="overlay"><img src="public/PDF/images/cms/interviewbooklet.jpg" width="100%"> </div>
	<img src="<?php echo LOGO_IMG; ?>" style="margin:0.15cm 0.2cm" width="176" height="66" class="fish">	
	<label class="fish1"><b style="font-size:24px;color:#fff;text-align: left;">Position Name:</b><br>
	<b style="font-size:20px;color:#333;text-align: left;"><?php echo $posdetails['position_name']; ?></b></label>
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
  <div style="text-align: right;color:#000;margin-right:10px;">N-Compas.com</div>
 </div>

<div class="body">
<div style="height: 850px;bottom:0px;">&nbsp;</div>
<p style="color:red;padding-left:5px;">
NOTE:This report and its contents are the property of <?php echo $posdetails['parent_organisation'];?> and no portion of the same should be copied or reproduced without the prior permission of <?php echo $posdetails['parent_organisation'];?>.</p>
</div>
<div style="page-break-after: always;"></div>
<div class="body">
<h3 class="title" style="text-align:right;">1. Introduction</h3>
<br>
<h4 class="titleheader">WHAT IS THE COMPETENCY BASED INTERVIEWING</h4>
<p style="line-height: 1.7em;">Competencies and competency mapping process can be used for all activities along the HR value chain, including that for recruitment.Since the competencies required for various positions have been mapped, that is the critical competencies for the position have been identified; in the process of recruitment the focus could therefore be on these.  Also, the competency profile of the position, describes the needs of the job, in terms of the other knowledge and skill requirements for the position being filled.  </p>
<br><br><br>
<h4 class="titleheader">WHAT DOES THIS BOOKLET CONTAIN?</h4>
<p style="line-height: 1.7em;">This booklet is a facilitation guide for interviewers participating in the selection process for the position mentioned on the cover sheet.  These booklet servers as a guide for the process of selection and contains the following</p>
<ul style="line-height: 1.7em;">
	<li>Position or Job Description of the position being filled </li>
	<li>Competency Profile of the Position – that is the competency requirements of the position</li>
	<li>Brief Explanation of the critical competencies </li>
	<li>Guiding questions for the interviewer </li>
</ul>
<div style="height: 180px;padding-bottom:60px;">&nbsp;</div>
<div style="padding-bottom:20px;">
	<p>Note:  For further information on Competencies, Competency modelling and assessment, please refer to the FAQ section in <a href="http://n-compas.com" target="_blank">www.N-Compas.com </a></p>
</div>
</div>
<div style="page-break-after: always;"></div>
<div class="body">
<h3 class="title" style="text-align:right;">2. Job Description</h3>
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
<h4 class="titleheader">Reporting Relationships</h4>
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
</div>
<?php if(!empty($posdetails['accountablities'])){ ?>
<div style="page-break-after: always;"></div>
<div class="body">
<h4 class="titleheader">Accountabilities:</h4><p><?php echo @$posdetails['accountablities']; ?></p>
</div>
<?php } ?>
<?php if(count($kras)>0){ ?>
<div style="page-break-after: always;"></div>
<div class="body">
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
</div>
<?php 
} ?>


<div style="page-break-after: always;"></div>
<div class="body">
<h3 class="title" style="text-align:right;">3. Competency Profile</h3>
<p>The Job, <?php echo $posdetails['position_name']; ?>  whose description is provided in the above section, would require Competencies  - Functional, Managerial and Behavioural, to ensure that the objectives/goals or KRAs are achieved.  However, the various competencies required for this or other job are not required, one at the same Proficiency level and two, at the same level of criticality (please notes below).</p>
<p>Each competency has been defined in Four Levels</p><br>
<?php 
foreach($scale_info as $scale_infos){
?>
<p><b><?php echo $scale_infos['scale_name'];?>:</b><?php echo $scale_infos['description'];?></p><br>
<?php
}
?><br><br>
<p><b>The second dimension, in Competency Profiling is called the Level of Criticality, which in turn is split into three categories</b>
</p><br><br>
<?php 
foreach($cri_info as $cri_infos){
?>
<p><b><?php echo $cri_infos['name'];?>:</b><?php echo $cri_infos['description'];?></p><br>
<?php
}
?><br>
<p>In the process of assessment or interviewing, it is preferable to focus first on the Critical competencies and then on those that are classified as Important.  If time permitting, those in the Less Important category can be touched upon. </p>
</div>
<div style="page-break-after: always;"></div>
<div class="body">
<h3 class="titleheader">Competency Profile</i></h3>
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
</div>
<div style="page-break-after: always;"></div>
<div class="body">
<h3 class="title" style="text-align:right;">4. Interview Questions</h3>
<p>The following are a set of INDICATIVE QUESTIONS that you may use in the interview process.  PLEASE NOTE that you can ask other questions or probe further into any other dimension, as deemed fit and depending on the situation.</p>
<p>For this Position of <?php echo $posdetails['position_name']; ?> HR / Recruitment has generated this booklet based on the following</p>
<table>
	<thead>
	<tr class="row header2">
		<th>Competencies</th>
		<th>Objective Questions</th>
		<th>Total Number of Questions</th>
	</tr>
	</thead>
	<thead>
	<tr class="row header">
	<?php 
	$comp=!empty($_REQUEST['cri'])?$_REQUEST['cri']:"";
	$int=!empty($_REQUEST['int_type'])?$_REQUEST['int_type']:"";
	$total=!empty($_REQUEST['total'])?$_REQUEST['total']:"";
	$comps=explode(',',$comp);
	
	?>
		<th><?php echo (count($comps)>0)?"All Competencies":"Critical Competencies"; ?></th>
		<th><?php echo ($int==1)?"Interview Question":"Interview and CBT Question"; ?></th>
		<th><?php echo ($int==1)?$total:($total+$total); ?></th>
	</tr>
	</thead>
</table>
</div>

<?php 
$comp_l1=$comp_l2=$comp_l3=$comp_l4=$comp_l5=array();
$level_l1=$level_l2=$level_l3=$level_l4=$level_l5=array();
$cri_l1=$cri_l2=$cri_l3=$cri_l4=$cri_l5=array();
$cricality_details=UlsCompetencyCriticality::criticality_names_report($_REQUEST['cri']);
$c_id=array();
$i=0;
foreach($cricality_details as $key=>$cricality_detail){
	$c_id[$i]=$cricality_detail['code'];
	$i++;
}
$comp_all=$level_all=$cri_all=array();
if($_REQUEST['int_type']==2){
	$func_competencies=UlsCompetencyPositionRequirements::getcompetency_position_requirement_cat($_REQUEST['pos_id'],$_REQUEST['cat'],$_REQUEST['cri']);
	foreach($func_competencies as $positions){
		$comp_id=$positions['comp_position_competency_id'];
		$comp_all[]=$positions['comp_position_competency_id'];
		$level_all[$comp_id]=$positions['comp_position_level_scale_id'];
		$cri_all[]=$positions['comp_position_criticality_id'];
	}
	$count_v=sizeof($comp_all);
	$no_questions=$_REQUEST['total'];
	$count_all=@(int)($no_questions/$count_v);
	$count_all_limit_mul=@$no_questions-($count_all*$count_v);
	$c1_t=array();
	foreach($comp_all as $key2=>$comps){
		$comp_count_i=UlsQuestions::get_questions_count($comps,'COMP_INTERVIEW',$level_all[$comps]);
		$c1_i[$comps]=$comp_count_i['test_count'];
	}
	asort($c1_i); 
	$k=0;
	$count_q=0;
	?>
	
	
	<?php
	
	foreach($c1_i as $key=>$comps_c1){
	
	$comp_name=UlsCompetencyDefinition::viewcompetency($key);
	?>
	<div style="page-break-after: always;"></div>
	<div class="body">
	<?php
	if($k==0){ echo "<h3 class='title' style='text-align:right;'>Competency Based Interview questions</h3>";}
	if($key!=0){ echo "<br><br>";}
	?>
	
	<div class="titleheadercomp">
		<?php echo @$comp_name['comp_def_name']; ?>
	</div>
	<div><?php echo @$comp_name['comp_def_short_desc'];?></div>
	
	<br>
	<h4 class="titleheader">What To ask…</h4>
	<?php
	if((count($comp_all)-1)==$k){
		
		$question_counti=UlsQuestions::get_questions_count_comp($key,($count_all+$count_all_limit_mul),$level_all[$key],'COMP_INTERVIEW');
		//echo $comp_name['comp_def_name']."-".count($question_counti);
		if(count($question_counti)>0){
			foreach($question_counti as $keys=>$question_counts){
				echo $keys!=0?"<br><br>":"<br>";
				
			?>
			<div class="question"><?php echo strip_tags($question_counts['question_name']); ?></div>
					
					<?php
					$q_values=UlsQuestionValues::get_allquestion_values($question_counts['ques_id']);
					foreach($q_values as $q_value){
						$chk=$q_value['correct_flag']=='Y'? 'checked="checked"'  : '';
						$col=$q_value['correct_flag']=='Y'? 'style="color:green;"':'';
						if(!empty($q_value['text'])){
							?>
							<div <?php echo $col;?> class="answer"><?php echo @$q_value['text'];?></div>
							<div class="answer"><textarea cols="100" style="height:60px; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</textarea></div>
						<?php
						}
					}
					?>
				
			<?php
			}
		}
		else{
		?>
		<div class="alert"> 
		  <strong>Sorry!</strong> No questions available in this competency…
		</div>
		<?php	
		}
		$count_q=0;
	}
	else{
		$question_counti=UlsQuestions::get_questions_count_comp($key,$count_all,$level_all[$key],'COMP_INTERVIEW');
		if(count($question_counti)>0){
		foreach($question_counti as $keys=>$question_counts){
			if($keys!=0){ echo "<br><br>";}
			
			?>
			<div class="question"><?php echo strip_tags($question_counts['question_name']); ?></div>
			
					<?php
					$q_values=UlsQuestionValues::get_allquestion_values($question_counts['ques_id']);
					foreach($q_values as $q_value){
						$chk=$q_value['correct_flag']=='Y'? 'checked="checked"'  : '';
						$col=$q_value['correct_flag']=='Y'? 'style="color:green;"':'';
						if(!empty($q_value['text'])){
							?>
							<div <?php echo $col;?> class="answer"><?php echo @$q_value['text'];?></div>
							<div class="answer"><textarea cols="100" style="height:60px;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</textarea></div>
						<?php
						}
					}
					?>
				
			<?php
			}
		}
		else{
		?>
		<div class="alert"> 
		  <strong>Sorry!</strong> No questions available in this competency…
		</div>
		<?php
		}				
	}

	$k++; ?>
	</div>
	<?php 
	}
	?>
	
	

	
	<?php
	$i=0;
	foreach($c1_i as $key1=>$comp_alls){
		$comp_name=UlsCompetencyDefinition::viewcompetency($key1); ?>
	<div style="page-break-after: always;"></div>
	<div class="body">	
	<?php
		if($i==0){ echo "<h3 class='title' style='text-align:right;'>Competency Based CBT questions</h3>";}
		if($key1!=0){ echo "<br><br>";}
	?>
	
	<div class="titleheadercomp">
		<?php echo @$comp_name['comp_def_name']; ?>
	</div>
	<div><?php echo @$comp_name['comp_def_short_desc'];?></div>
	
	<br>
		<h4 class="titleheader">What To ask…</h4>
		<?php
		if((count($c1_i)-1)==$i){
			
			$question_countcbt=UlsQuestions::get_questions_count_comp($key1,$count_all+$count_all_limit_mul,$level_all[$key1],'COMP_TEST');
			if(count($question_countcbt)>0){
				foreach($question_countcbt as $keys=>$question_countcbts){
					echo $keys!=0?"<br><br>":"<br>";
					
				?>
				<div class="question"><?php echo strip_tags($question_countcbts['question_name']); ?></div>
				<?php 
				$q_values=UlsQuestionValues::get_allquestion_values($question_countcbts['ques_id']);
				foreach($q_values as $q_value){
				$chk=$q_value['correct_flag']=='Y'? 'checked="checked"'  : '';
				$col=$q_value['correct_flag']=='Y'? 'style="color:green;"':'';
				?>
				
					<div <?php echo $col;?> class="answer"><?php echo @$q_value['text'];?></div>
				
				
				<?php
				}
				?>
				<div class="answer"><textarea cols="100" style="height:60px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</textarea></div>
					
				<?php
				}
				
				?>
				<br>
			<?php
			}
			else{
			?>
			<div class="alert"> 
			  <strong>Sorry!</strong> No questions available in this competency…
			</div>
			<?php
			}
		}
		else{
			$question_counti_nn=UlsQuestions::get_questions_count_comp($key1,$count_all,$level_all[$key1],'COMP_TEST');
			if(count($question_counti_nn)>0){
				foreach($question_counti_nn as $keys=>$question_counti_nns){
					if($keys!=0){ echo "<br><br>";}
					
				?>
				<div class="question"><?php echo strip_tags($question_counti_nns['question_name']); ?></div>
					<?php 
					$q_values=UlsQuestionValues::get_allquestion_values($question_counti_nns['ques_id']);
					foreach($q_values as $q_value){
					$chk=$q_value['correct_flag']=='Y'? 'checked="checked"'  : '';
					$col=$q_value['correct_flag']=='Y'? 'style="color:green;"':'';
					?>
					
						<div <?php echo $col;?> class="answer"><?php echo @$q_value['text'];?></div>
					
					
					<?php
					}
					?>
							
						<div class="answer"><textarea cols="100" style="height:60px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</textarea></div>
				<?php
				}
			}
			else{
			?>
			<div class="alert"> 
			  <strong>Sorry!</strong> No questions available in this competency…
			</div>
			<?php
			}
		}
		
		$i++; ?>
		</div>
		
	<?php } ?>
	
<?php
}
if($_REQUEST['int_type']==1){
	?>
	
	<?php
	$comp_cri=$level_cri=$cri_cri=array();	
	$func_competencies=UlsCompetencyPositionRequirements::getcompetency_position_requirement_cat($_REQUEST['pos_id'],$_REQUEST['cat'],$_REQUEST['cri']);
	foreach($func_competencies as $positions){
		$comp_id=$positions['comp_position_competency_id'];
		$comp_cri[]=$positions['comp_position_competency_id'];
		$level_cri[$comp_id]=$positions['comp_position_level_scale_id'];
		$cri_cri[]=$positions['comp_position_criticality_id'];
	}
	$count_cri=sizeof($comp_cri);
	$no_questions=$_REQUEST['total'];
	$count_c=@(int)($no_questions/$count_cri);
	$count_vital_limit_mul=@$no_questions-($count_c*$count_cri);
	$c1_t=array();
	foreach($comp_cri as $key2=>$comps){
		$comp_count_i=UlsQuestions::get_questions_count($comps,'COMP_INTERVIEW',$level_cri[$comps]);
		$c1_i[$comps]=$comp_count_i['test_count'];
	}
	asort($c1_i);
	$count_q=0;
	$j=0;
	foreach($c1_i as $key=>$comps_c1){
		$comp_name=UlsCompetencyDefinition::viewcompetency($key);
		?>
	<div style="page-break-after: always;"></div>
	<div class="body"><?php if($j==0){echo "<h3 class='title' style='text-align:right;'>Competency Based Interview questions</h3>"; } ?>
		<div class="titleheadercomp">
			<?php echo @$comp_name['comp_def_name']; ?>
		</div>
		<div><?php echo @$comp_name['comp_def_short_desc'];?></div>
		
		<br>
		<h4 class="titleheader">What To ask…</h4>
		<?php
		if((count($comp_cri)-1)==$j){
			$question_counti=UlsQuestions::get_questions_count_comp($key,$count_c+$count_vital_limit_mul,$level_cri[$key],'COMP_INTERVIEW');
			if(count($question_counti)>0){
				foreach($question_counti as $keys=>$question_counts){
					echo $keys!=0?"<br><br>":"<br>";
					
					?>
					<div class="question"><?php echo strip_tags($question_counts['question_name']); ?></div>
							<?php 
							$q_values=UlsQuestionValues::get_allquestion_values($question_counts['ques_id']);
							foreach($q_values as $q_value){
							$chk=$q_value['correct_flag']=='Y'? 'checked="checked"'  : '';
							$col=$q_value['correct_flag']=='Y'? 'style="color:green;"':'';
								if(!empty($q_value['text'])){
									?>
									<div <?php echo $col;?> class="answer"><?php echo @$q_value['text'];?></div>
									<div class="answer"><textarea cols="100" style="height:60px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</textarea></div>
								<?php
								}
							}
						?>
				<?php
				}	
			}
			else{
			?>
			<div class="alert"> 
			  <strong>Sorry!</strong> No questions available in this competency…
			</div>
			<?php	
			}
		}
		else{
			$question_counti=UlsQuestions::get_questions_count_comp($key,$count_c,$level_cri[$key],'COMP_INTERVIEW');
			if(count($question_counti)>0){
				foreach($question_counti as $keys=>$question_counts){
					echo $keys!=0?"<br><br>":"<br>";
					
					?>
					<div class="question"><?php echo strip_tags($question_counts['question_name']); ?></div>
							<?php 
							$q_values=UlsQuestionValues::get_allquestion_values($question_counts['ques_id']);
							foreach($q_values as $q_value){
							$chk=$q_value['correct_flag']=='Y'? 'checked="checked"'  : '';
							$col=$q_value['correct_flag']=='Y'? 'style="color:green;"':'';
								if(!empty($q_value['text'])){
									?>
									<div <?php echo $col;?> class="answer"><?php echo @$q_value['text'];?></div>
									<div class="answer"><textarea cols="100" style="height:60px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</textarea></div>
								<?php
								}
							}
						?>
						
				<?php
				}
			}
			else{
			?>
			<div class="alert"> 
			  <strong>Sorry!</strong> No questions available in this competency…
			</div>
			<?php	
			}
		}
		$j++; ?>
		</div>
		<?php } ?>

<?php
}
?>
<div style="page-break-after: always;"></div>
<div class="body">
<h3 class="title" style="text-align:right;">5. Interviewer Remarks & Comments </h3>
<p>As interviewer, we know that you would want to take either a granular picture of the applicant or holistic perspective, either way, there is a provision to capture that information.</p>
<table>
	<thead>
		<tr>
			<th width="30%">Name of the application</th>
			<th width="70%">&nbsp;</th>
		</tr>
	</thead>
</table>
<br>
<h3 class="titleheader">Competency Profile</i></h3>
<table>
	<thead>
	<tr class="row header">
		<th>Competencies</th>
		<th>Criticality</th>
		<th>Required Level</th>
		<th>Assessed Level</th>
	</tr>
	</thead>
	<tbody>
	<?php
	foreach($competencies as $competency){
		if($competency['comp_position_id']==$posdetails['position_id']){
	?>
		<tr>
			<td><?php echo $competency['comp_def_name']; ?></td>
			<td><?php echo $competency['comp_cri_name']; ?></td>
			<td><?php echo $competency['scale_name']; ?></td>
			<td></td>
		</tr>
	<?php
		}
	}
	?>
	</tbody>
</table>
</div>
<div style="page-break-after: always;"></div>
<div class="body">
<p>&nbsp;</p>
<h4 class="titleheader">Comments & Observations on other Competencies/Areas </h4>
<p>&nbsp;</p>
<textarea cols="100" style="height:200px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</textarea>

<p>&nbsp;</p>
<b>Suitable for the  Position of <?php echo $posdetails['position_name']; ?> </b>:&nbsp;&nbsp;&nbsp;<label><b>Yes</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><b>No</b></label>
<p>&nbsp;</p>
<h4 class="titleheader">Development Recommendations if selected </h4>
<p>&nbsp;</p>
<textarea cols="100" style="height:200px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</textarea>
</div>
</body>
<div style="page-break-after: always;"></div>

<div id="overlay2"><img src="public/PDF/images/cms/interviewbookletback.jpg" width="100%"></div>