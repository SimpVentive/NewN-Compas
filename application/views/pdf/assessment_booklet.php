<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  
  <title>Assessment Booklet</title>
  
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
	div.leftpane2 {
		position: fixed;
		background: #fff;
		width: 10%;
		border-bottom-width: 1px solid #2286c9;
		border-left: 3px solid #fff;
		overflow: hidden;
		padding: 0.1cm;
		top: 0cm;
		left: 1cm;
		height: 3cm;
	}
	div.leftpane3 {
		position: fixed;
		background: #fff;
		width: 10%;
		border-top: 1px solid #2286c9;
		border-left: 2px solid #010F3C;
		overflow: hidden;
		padding: 0.1cm;
		bottom: 0cm;
		left: 1cm;
		height: 1cm;
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
		border: 1px solid #d2d2d2;
    }
    tbody td{
		border: 1px solid #d2d2d2;
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
	.fish { position: absolute; top: 500px; left: 490px; }
	.fish1 { position: absolute; top: 450px; left: 450px; }
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
  </style>
  
</head>


<div class="flyleaf">
	<div id="overlay"><img src="public/PDF/images/cms/front.jpg" width="100%"></div>
	<img src="<?php echo LOGO_IMG; ?>" style="margin:0.15cm 0.2cm" width="176" height="66" class="fish"> 
	<label class="fish1"><b style="font-size:22px;color:#000;text-align: left;"><?php echo $posdetails['position_name']; ?></b></label>
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
<div style="height: 500px;padding-bottom:100px;">&nbsp;</div>
<div style="height:250px;">

<p style="color:red;padding-left:5px;">
NOTE:
</p>
<p style="color:red;padding-left:5px;">This report and its contents are the property of <?php echo $posdetails['parent_organisation'];?> and no portion of the same should be copied or reproduced without the prior permission of <?php echo $posdetails['parent_organisation'];?>.</p>
<p style="color:red;padding-left:5px;">NO PORTION OF THIS SHOULD BE COPIED, REPRODUCED OR DISTRIBUTED WITHOUT THE PRIOR PERMISSION OF EITHER OF THE ABOVE MENTIONED PARTIES.</p>
</div>
</div>
<div style="page-break-after: always;"></div>
<div class="body">
<h3 class="title">1.The Skills/Competency requirements for this Position are as follows</h3>
<table>
	<thead>
	<tr class="row header">
		<th>S.No</th>
		<th>Skill/Competency</th>
		<th>Level</th>
		<th>Criticality</th>
		<th>Assessment Types</th>
	</tr>
	</thead>
	<tbody>
	<?php
	foreach($competencies as $key1=>$competency){
		
	?>
		<tr>
			<td><?php echo $key1+1; ?></td>
			<td><?php echo $competency['comp_def_name']; ?></td>
			<td><?php echo $competency['scale_name']; ?></td>
			<td><?php echo $competency['comp_cri_name']; ?></td>
			<td><?php echo $competency['assessment_type']; ?></td>
		</tr>
	<?php
		
	}
	?>
	</tbody>
</table>

</div>
<div style="page-break-after: always;"></div>
<div class="body">
<h3 class="title">2.Employee Details</h3>
<h4 class="titleheader">The following employees will be taking this assessment:</h4>
<table>
	<thead>
	<tr class="row header">
		<th>S.No</th>
		<th>Name</th>
		<th>Employee ID</th>
		<th>Email ID</th>
		<th>Mobile</th>
	</tr>
	</thead>
	<tbody>
	<?php
	foreach($employee as $key=>$employees){
		?>
		<tr>
			<td><?php echo $key+1; ?></td>
			<td><?php echo $employees['full_name']; ?></td>
			<td><?php echo $employees['employee_number']; ?></td>
			<td><?php echo $employees['email']; ?></td>
			<td><?php echo $employees['office_number']; ?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>

</div>
<div style="page-break-after: always;"></div>

</body>
<div style="page-break-after: always;"></div>
<div id="overlay2"><img src="public/PDF/images/cms/back.jpg" width="100%"></div>