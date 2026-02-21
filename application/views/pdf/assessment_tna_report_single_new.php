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
  
  <title>Employee Single page Assessment Report</title>
  
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
		margin-top: 2.0cm !important;
		
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
	  <div style="text-align: right;color:#000;margin-right:50px;font-size: 10px;font-family: Helvetica,sans-serif !important;">www.N-Compas.com</div>
	</div>

	
	<div class="body">
		<h4 style="text-align:center;padding-left:20px;">Competency Based Traning Needs Identification (TNI)</h4>
		<table width="100%" cellspacing="0" cellpadding="5" style="border:1px solid #36a2eb;">
			<tr bgcolor="#f1f1f1">
				<td style="width:40%">Name:<b><?php echo $emp_info['name']; ?></b></td>
				<td style="width:60%">Designation:<b><?php echo $emp_info['position_name']; ?></b></td>
			</tr>
		</table>
		<table width="100%" cellspacing="0" cellpadding="5" style="border:1px solid #36a2eb;">
			
			<tr bgcolor="#f1f1f1">
				<td style="width:40%">Department:<b><?php echo $emp_info['org_name']; ?></b></td>
				<td style="width:30%">Grade:<b><?php echo $emp_info['grade_name']; ?></b></td>
				<td style="width:30%">Location:<b><?php echo $emp_info['location_name']; ?></b></td>
			</tr>
		</table>
		<?php $names=($ass_details['ass_comp_selection']=='N')?"Assessment Results":"Competency Profile"; ?>
		<h4 class="titleheader" style="font-size:9pt;"><b style="font-size:9pt;">A. <?php echo $names; ?></b></h4>
		
		
		<?php 
		
		$assresults=UlsAssessmentTest::assessment_results_avg($_REQUEST['ass_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id']);
		$results=$ass_comname=$ass_req_sid=$ass_given_sid=array();
		foreach($assresults as $assresult){
			$compid=$assresult['comp_def_id'];
			$finalval=!empty($assresult['assessor_val'])?round(($assresult['ass_scale_number']*$assresult['assessor_val']),2):$assresult['ass_scale_number'];
			$results[$assresult['comp_def_id']]['comp_id']=$compid;
			$results[$assresult['comp_def_id']]['comp_name']=$assresult['comp_def_name'];
			$results[$assresult['comp_def_id']]['req_val']=$assresult['req_number'];
			$results[$assresult['comp_def_id']]['assessor'][$assresult['assessor_id']]=$finalval;
		}
		?>
		<?php 
		if($ass_details['ass_comp_selection']=='N'){
		?>
		<div style="float:left;width:60%">
			<table width="100%" align="top" style="float:left;">
				<thead>
					<tr  class="row header">
						<th width="60%">Competency </th>
						<th width="20%">Req. Value</th>
						<th width="20%">Assessed Value</th>
					</tr>
				</thead>
				<tbody>
				<?php 
				$k=1;
				$final_value=array();
				foreach($results as $key1=>$result){
					?>
					<tr>
						<td><?php echo "C".($k)."-".$result['comp_name']; ?></td>
						<td><?php echo $result['req_val']; ?></td>
						<td>
						<?php
						$final=0;
						foreach($result['assessor'] as $key2=>$ass_id){
							$final=$final+$results[$key1]['assessor'][$key2];
						}
						echo $final=round($final/count($results[$key1]['assessor']),2);
						?>
						</td>
						
					</tr>
				<?php 
				$k++;
				} ?>
				</tbody>
			</table>
		</div>
		<div style="float:right;width:40%">
			<img src="<?php echo $base64;?>" style="width:310px;height:290px;padding-top:2px; "/>
		</div>
		<?php 
		}
		else{
		?>
		
		<table width="100%" align="top" style="float:left;">
			<thead>
				<tr  class="row header">
					<th width="60%">Competency </th>
					<th width="20%">Criticality</th>
					<th width="20%">Req. Value</th>
					
				</tr>
			</thead>
			<tbody>
			<?php
			foreach($competencies as $key1=>$competency){
				if($competency['comp_per']=='Y'){
			?>
			<tr>
				<td><?php echo $competency['comp_def_name']; ?></td>
				<td><?php echo $competency['comp_cri_name']; ?></td>
				<td><?php echo $competency['scale_name']; ?></td>
			</tr>
			<?php
				}
			}
			?>
			</tbody>
		</table>
		
		<?php
		}
		?>
		<br style="clear:both;">
		<h4 class="titleheader"  style="font-size:9pt;"><b style="font-size:9pt;">B. Training Programs Identified </b></h4>
		<?php 
		if($ass_details['ass_comp_selection']=='N'){
		?>
		<p>Based on your assessment results and the development items identified by you, the following are the training programs that are identified for you.  </p>
		<?php } 
		else{
		?>
		<p>Following are the training programs that are identified by you.  </p>
		<?php
		}
		if($ass_details['ass_comp_selection']=='Y'){
		?>
		<p style="font-size:16px;"><u>Current Year</u></p>
		<table width="100%">
			<thead>
				<tr class="row header">
					<th width="5%">S.No</th>
					<th width="40%">Competency</th>
					<th width="50%">Training Program Title</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$temp1=$temp4="";
			$key=1;
			foreach($ass_final as $ass_finals){
			?>
			<tr>
				<td><?php 
				if($temp4!=$ass_finals['comp_def_name']){
				echo $key;
				}				
				?></td>
				<td><?php
				if($temp4!=$ass_finals['comp_def_name']){
					$key++;
					echo $ass_finals['comp_def_name'];
					$temp4=$ass_finals['comp_def_name'];
				}
				else{
					echo "";
				}
				?></td>
				
				<td><?php
				if($temp1!=$ass_finals['pro_name']){
					$scale=($ass_finals['scale_number']>=3)?"Advanced":"";
					echo $scale." ".$ass_finals['pro_name'];
					$temp1=$ass_finals['pro_name'];
				}
				else{
					echo "";
				}?></td>
			</tr>
			<?php
			} ?>
			</tbody>
		</table>
		<?php }
		else{
		?>
		<p style="font-size:16px;"><u>Current Year</u></p>
		<table width="100%">
			<thead>
				<tr class="row header">
					<th width="5%">S.No</th>
					<th width="40%">Competency</th>
					<th width="50%">Training Program Title</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$temp1=$temp3="";
			$kn=1;
			foreach($ass_final as $key=>$ass_finals){
				if($ass_finals['tna_year']==1){
			?>
			<tr>
				<td><?php
				if($temp3!=$ass_finals['comp_def_name']){
					echo $kn; 
				}?></td>
				<td><?php
				if($temp3!=$ass_finals['comp_def_name']){
					$kn++;
					echo $ass_finals['comp_def_name'];
					$temp3=$ass_finals['comp_def_name'];
				}
				else{
					echo "";
				}
				?></td>
				
				<td><?php
				if($temp1!=$ass_finals['pro_name']){
					$scale=($ass_finals['scale_number']>=3)?"Advanced":"";
					echo $scale." ".$ass_finals['pro_name'];
					$temp1=$ass_finals['pro_name'];
				}
				else{
					echo "";
				}?></td>
			</tr>
			<?php
				}
				
			} ?>
			</tbody>
		</table>
		<p style="font-size:16px;"><u>Next Year</u></p>
		
		<table width="100%">
			<thead>
				<tr class="row header">
					<th width="5%">S.No</th>
					<th width="40%">Competency</th>
					<th width="50%">Training Program Title</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$temp1=$temp2="";
			$kv=$v=1;
			if(!empty($ass_final_next)){
				foreach($ass_final_next as $key=>$ass_finals){
				?>
				<tr>
					<td><?php 
					if($temp2!=$ass_finals['comp_def_name']){
					echo $kv; 
					}?></td>
					<td><?php
					if($temp2!=$ass_finals['comp_def_name']){
						$kv++;
						echo $ass_finals['comp_def_name'];
						$temp2=$ass_finals['comp_def_name'];
					}
					else{
						echo "";
					}
					?></td>
					
					<td><?php
					if($temp1!=$ass_finals['pro_name']){
						$scale=($ass_finals['scale_number']>=3)?"Advanced":"";
						echo $scale." ".$ass_finals['pro_name'];
						$temp1=$ass_finals['pro_name'];
					}
					else{
						echo "";
					}?></td>
				</tr>
				<?php
				}
			}
			else{
				echo "<tr>
					<td colspan='3'><p>NO TRAINING NEEDS IDENTIFIED FOR NEXT YEAR</p></td>
				</tr>";
			}
			?>
			</tbody>
		</table>
		<?php
		}
		?>
		
	</div>
</body>

