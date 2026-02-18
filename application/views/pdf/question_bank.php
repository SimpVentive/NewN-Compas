<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">  
  <title><?php echo @$compdetails['comp_def_name']; ?> Competency</title>  
  <style type="text/css">
	@page {
	  margin: 0;
	}
	
	body {
		margin-top: 2.5cm;
		margin-bottom: 1.5cm;
		margin-left: 1.5cm;
		margin-right: 1.5cm;
		font-family: sans-serif;
		text-align: justify;
		color:#5E5B5C;
		font-size: 10px;
	}
	
	div.header,
	div.footer {
	  position: fixed;
	  background: #fff;
	  color:#fff;
	  width: 100%;
	  border: 0px solid #2286c9;
	  overflow: hidden;
	  padding: 0.1cm;
	}
	
	div.leftpane {
		position: fixed;
		background: #fff;
		width: 1cm;
		border-right: 1px solid #2286c9;
		top: 0cm;
		left: 0cm;
		height: 30cm;
	}
	div.rightpane {
		position: fixed;
		background: #fff;
		width: 1cm;
		border-left: 1px solid #2286c9;
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
		border-left: 3px solid #fff;
		overflow: hidden;
		padding: 0.1cm;
		bottom: 0cm;
		left: 1cm;
		height: 1cm;
	}
	div.header {
		top: 0cm;
		left: 1cm;
		border-bottom-width: 1px;
		height: 2cm;
	}
	
	div.footer {
		bottom: 0cm;
		left: 0cm;
		border-top-width: 1px;
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
  </style>
  
</head>

<body>

<div class="header">
	<img src="<?php echo LOGO_IMG; ?>" style="margin:0.15cm 0.2cm" width="176" height="66">
	<?php $aa=defined('LOGO_IMG2')?TRUE:FALSE; if($aa){ ?><img src="<?php echo LOGO_IMG2; ?>" style="margin:0.15cm 1.2cm;float:right;" width="176" height="66"><?php } ?>
</div>

<div class="footer">
  <div style="text-align: right;">On line footer content aligned to the right.</div>
</div>

<div class="leftpane">
  <div style="text-align: center;">
		
	</div>
</div>
<div class="rightpane">
  <div style="text-align: center;">
		
	</div>
</div>



<div class="content">
    <div class="row">
		<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1">
			<thead>
				
				<tr>
					<th style=" background-color: #edf3f4;width:20%">Question Bank Name</th>
					<th><?php echo isset($questionbanks['name'])? $questionbanks['name'] :"";?>&nbsp;</th>
				</tr>
				<tr>
					<th style=" background-color: #edf3f4;width:20%">Question Bank Type</th>
					<th><?php echo	isset($questionbanks['types'])?$questionbanks['types']:"";?> &nbsp;</th>
				</tr>
				<tr>
					<th style=" background-color: #edf3f4;width:20%">Competency</th>
					<th><?php echo	isset($questionbanks['comp_def_name'])?$questionbanks['comp_def_name']:"";?> &nbsp;</th>
				</tr>
				<tr>
					<th style=" background-color: #edf3f4;width:20%">Published Status</th>
					<th><?php echo	isset($questionbanks['comp_def_status'])?$questionbanks['comp_def_status']:"";?>&nbsp;</th>
				</tr>
				
			</thead>
		</table>
		<br>
		<h3 class="lighter block green">Questions</h3>
		<?php  if(count($questionss)>0){ ?> 
		<h3 style="color:green;">Green color values are Correct answers </h3>
		<?php } ?>
		<h3> <small></small></h3>
		<div id="tab-keyind" class="tab-pane active">
			<div class="panel-body">
				<table>
				<?php
				if(count($questionss)>0){  $nums=0; $single_quest=array();
					foreach ($questionss as  $key=>$question){ 
						$chk=$question['correct_flag']=='Y'? 'checked="checked"'  : '';
						$col=$question['correct_flag']=='Y'? 'style="color:green;font-size:12px;"':'style="font-size:12px;"';
						$key1=$key+1;
						if($question['question_type']=='F'){ 
							$nums=$nums+1;
						?>
							<tr>
								<td><b style="font-size:14px;"><?php echo $nums;  ?>).<?php echo strip_tags($question['question_name']); ?></b>
									<br />
									Ans: <input type='text' name='quest' id='quest' value="<?php echo strip_tags($question['text']); ?> " readonly="readonly" />
								</td>
							</tr>
						<?php 
						}
						else if($question['question_type']=='B'){ 
							$nums=$nums+1;
						?>
							<tr>
								<td><b style="font-size:14px;"><?php echo $nums;  ?>).<?php echo strip_tags($question['question_name']); ?></b>
								<br />
								Ans: <input type='text' name='fbn' id='fbn' value="<?php echo $question['text'];; ?> " readonly="readonly" />
								</td>
							</tr>
						<?php 
						}
						else if($question['question_type']=='T'){
							if(!in_array($question['id'],$single_quest)){
								$single_quest[]=$question['id'];  
								$nums=$nums+1;
								?>
								<tr>
									<td><b style="font-size:14px;"><?php echo $nums;  ?>).<?php echo strip_tags($question['question_name']); ?> </b></td> 
								</tr>
							<?php 
							} ?>
								<tr>
									<td>&emsp;<input type="radio" disabled="disabled"  name="truefalse<?php echo $key1 ; ?>" id="truefalse" <?php echo $chk ; ?> /> <label <?php echo $col ; ?> for="truefalse"><?php echo $question['text'];; ?></label> 
									</td>
								</tr>  
						<?php   
						}	   
						else if($question['question_type']=='S'){
							if(!in_array($question['id'],$single_quest)){
								$single_quest[]=$question['id'];  
								$nums=$nums+1; 
								?>
								<tr>
									<td><b style="font-size:14px;"><?php echo $nums;  ?>).<?php echo strip_tags($question['question_name']); ?></b>
									</td> 
								</tr>
								<?php 
							}?>
							<tr>
								<td>&emsp; <label  <?php echo $col ; ?> for="truefalse" ><?php echo strip_tags($question['text']);; ?></label> </td>
							</tr>  
						<?php 
						}
						else if($question['question_type']=='M'){
							if(!in_array($question['id'],$single_quest)){
								$single_quest[]=$question['id']; 
								$nums++;
								?>
								<tr>
									<td><b style="font-size:14px;"><?php echo $nums;  ?>).<?php echo strip_tags($question['question_name']); ?> </b></td>
								</tr>
								<?php 
							} 
							?>
							<tr>
								<td>&emsp;<input type="checkbox" disabled="disabled" name="truefalse" id="truefalse" <?php echo $chk ; ?> />
								<label  <?php echo $col ; ?> for="truefalse"><?php echo $question['text']; ?></label> </td>
							</tr> 
						<?php 
						} 
						else if($question['question_type']=='FT'){  
							$nums++;
							?>
							<tr >
								<td valign="top"><b style="font-size:14px;"><?php echo $nums;  ?>).<?php echo strip_tags($question['question_name']); ?></b>
								<textarea id="form-field-11" class="autosize-transition form-control" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 69px; name="ft" id="ft"><?php echo strip_tags($question['text']); ?></textarea> 
								</td>
							</tr>
						<?php 
						}
					}
				}
				else{ ?>
					<tr>
						<td colspan="2"> No Questions are available for this Questions Bank.</td>
					</tr>
				<?php } ?>
				</table>
			</div>
			<!--<div align='right' style='padding:10px;'>
				<input type='button' onclick="htmltopdf('idexceltable','question bank')" name='btnpdfExport' class='btn btn-sm btn-success'  id='btnpdfExport' value='Generate Pdf' >
			</div>-->
		</div>
	</div>
</div>
</body>