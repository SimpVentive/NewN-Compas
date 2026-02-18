<?php
/**
 * HTML2PDF Librairy - example
 *
 * HTML => PDF convertor
 * distributed under the LGPL License
 *
 * @author      Laurent MINGUET <webmaster@html2pdf.fr>
 *
 * isset($_GET['vuehtml']) is not mandatory
 * it allow to display the result in the HTML format
 */

ob_start();

?>
<style type="text/css">
table.page_header {width: 100%; border: none; padding: 10mm 2mm 0mm 0mm; }
    table.page_footer {width: 100%; border: none; background-color: #BC6F74; border-top: solid 1mm #BC6F74; padding: 2mm;color:#FFF;}
	div.note {font-size: 16px;font-weight:bold;background-color:#BC6F74; padding: 2mm; border-radius: 2mm; width: 100%;color:#FFF; }
    h1 {color: #000033; text-decoration:underline;background-color: #d78585;width:1000px;}
    h2 {color: #000055; text-decoration:underline;}
    h3 {color: #000077; text-decoration:underline;}
	h4 {color: #000099; text-decoration:underline;}

    div.niveau
    {
        padding-left: 2mm;
    }
.bordered table
{
    width: 100%;
    border:1px solid #000;
	border-radius:10px;
}
	 
.bordered th
{
	border-radius:1px;
	padding: 8px;
	color:#000;
    text-align: center;
    border:1px #000;
    background: #D4D4D4;
	background-color:#D4D4D4;
	
}
.bordered td
{
	border-radius:1px;
    text-align: center;
	padding: 5px;
    border: 1px #000;
	background-color:#FFFFFF;
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
div.test2 {
	color: #000;
	background-color: #FFF;
	font-family: helvetica;
	font-size: 10pt;
	border:0px;
	
}

table.first {
        color: #003300;
        font-family: helvetica;
        font-size: 10pt;
		border:2px solid #8B2523;
		
        background-color: #FFF;
    }
    
   
</style>
<?php 
$position_name=UlsAssessmentTest::view_assessment_position($assess_test_id);
?>
<!--<page backtop="0mm"  backbottom="0mm" backleft="0mm" backright="0mm" backimgx="0mm" backimgy="0mm" backimgw="215.8mm" backimg="<?php echo BASE_URL; ?>/public/images/reports/front.jpg" style="font-size: 20pt;">
<div align="center" style="padding:130mm 0mm 0mm 85mm;" ><span style="font-size: 24pt;"><b><?php echo $position_name['position_name']; ?></b></span><br><br>
<img style="width:250px;" src="<?php echo BASE_URL; ?>/public/images/coromandel.jpg">
<br><span style="font-size: 20pt;"><b>Coromandel International  Ltd </b> </span>
</div>
</page>
<page pageset="new" backtop="25mm" backbottom="10mm" backleft="10mm" backright="10mm"  backimgx="0mm" backimgy="0mm" backimgw="215.8mm" backimg="<?php echo BASE_URL;?>/public/images/reports/page.jpg" >
	<page_header>
        <table class="page_header">
            <tr>
                <td style="width: 100%; text-align:right">
                    <b>Assessment Report for - <font color="#d73f41"><?php echo  $position_name['position_name'];?></font></b>
                </td>
            </tr>
        </table>
    </page_header>
	<page_footer>
        <table class="page_footer">
            <tr>
                <td style="width: 100%; text-align: right">
                    page [[page_cu]]/[[page_nb]]
                </td>
            </tr>
        </table>
    </page_footer>	
<div class="niveau">
		<div style="height: 600px;padding-bottom:60px;">&nbsp;</div>
		<div class="test" style="height:250px;">
		
		<p style="color:red;padding-left:5px;">
		NOTE:
		</p>
		<p style="color:red;padding-left:5px;">THE CONTENTS OF THIS ASSESSMENT SHEET ARE CONFIDENTAL AND THE PROPERTY OF UNITOL TRAINING SOLUTIONS
		PVT LTD AND COROMANDEL.</p>
		<p style="color:red;padding-left:5px;">NO PORTION OF THIS SHOULD BE COPIED, REPRODUCED OR DISTRIBUTED WITHOUT THE PRIOR PERMISSION OF EITHER
		OF THE ABOVE MENTIONED PARTIES.</p>
		</div>
</div>
</page>
<page pageset='old'>
<div class="niveau">
	<div class="note">A.Assessment Details</div>
	<br />
	<div style="font-size:16px;height:100px;" class="test" >
		<br><br>
		&nbsp;&nbsp;This assessment is for the Position of  <br>
		
		<p style="font-size:20px;">&nbsp;&nbsp;<b><?php echo  $position_name['position_name'];?></b></p>
		<br>
	</div>
	<br />
	<div class="note">The Skills/Competency requirements for this Position are as follows</div>
	<br>
	<table style='width:98%' align="center" class='bordered'>
		<col style='width:8%'>
		<col style='width:30%'>
		<col style='width:20%'>
		<col style='width: 20%'>
		<col style='width: 20%'>
		<tr>
			<th>S.No</th>
			<th>Skill/Competency</th>
			<th>Level</th>
			<th>Criticality</th>
			<th># of CBT Question</th>
		</tr>
		<?php
		$competencies=UlsAssessmentCompetencies::getassessment_competencies_type($position_name['assessment_id'],$position_name['position_id']);
		
		$tmp="";
		foreach($competencies as $key1=>$competency){
			$per_test=UlsAssessmentTest::get_ass_position($position_name['assessment_id'],$position_name['position_id'],'TEST');
		?>
		<tr>
			<td><?php echo $key1+1; ?></td>
			<td><?php echo $competency['comp_def_name']; ?></td>
			<td><?php echo $competency['scale_name']; ?></td>
			<td><?php echo $competency['comp_cri_name']; ?></td>
			<td>
			<?php 
			if($tmp!=$competency['comp_cri_code']){
				$tmp=$competency['comp_cri_code'];
				echo $per_test['c1'];
			}
			
			?>
			</td>
		</tr>
		<?php } ?>
	</table>
	<br>
	<div style="font-size:16px;height:80px;" class="test" >
		<br><br><p>&nbsp;Duration:</p><br>&nbsp;The total time for this Test is  <?php echo  $position_name['time_details']." Mins";?>
		<br>
	</div>
	
</div>
</page>
<page pageset='old'>
<div class="niveau">
	<div class="note">B. EMPLOYEE DETAILS</div>
	<br>
	<div style="font-size:16px;height:100px;" class="test" >
		<br><br>
		&nbsp;&nbsp;The following employees will be taking this assessment
		<br>
	</div>
	<br>
	<table style='width:100%' align="center" class='bordered'>
		<col style='width:7%'>
		<col style='width:35%'>
		<col style='width:10%'>
		<col style='width:33%'>
		<col style='width:15%'>
		<tr>
			<th>S.No</th>
			<th>Name</th>
			<th>Employee ID</th>
			<th>Email ID</th>
			<th>Mobile</th>
		</tr>
		<?php 
		$employee=UlsAssessmentEmployees::getassessmentemployees_position_report($position_name['assessment_id'],$position_name['position_id']);
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
	</table>
</div>
</page>-->
<?php
$testdetails=UlsAssessmentTest::assessment_view_final($assess_test_id);
?>
<page pageset='old'>
<div class="niveau">
	<div class="note" style="width:100%">C. CBT QUESTIONS</div>
	<br>
	<!--<div style="font-size:16px;height:100px;width:100%" class="test" >
		<br><br>
		<p>&nbsp;&nbsp; The following are the MCQ (Multiple Choice Questions) that will be used in this assessment process.</p>
		<p>&nbsp;&nbsp; The right answers are shown in Green Color.</p>
		<p>&nbsp;&nbsp; NOTE that the order and sequence of the questions will be randomized for each of the employees.</p>
		<br>
	</div>
	<br>-->
	
	    <table width='90%' style="font-size:12px;width:100%;margin:0px;padding:5px;" class="test2">
			<tr>
				<td></td><td colspan="2"><br><br>Questions<br></td>
				<!--<td style="padding-left:150px"><br><br>Competency<br></td>
				<td style="padding-left:50px"><br><br>Level<br></td>-->
			</tr>
	  <?php foreach($testdetails as $key=>$que) {
		        $keys=$key+1;
				$ques=$que['question_id'];
				$type=$que['type_flag'];?>
				
		        <tr>
					<td valign="top"><?php echo $keys.")"; ?></td>
				    <td valign="top" colspan="2"><?php echo $que['question_name'];?></td>
					<!--<td style="padding-left:150px"><br><br><?php echo $que['comp_def_name'];?><br></td>
					<td style="padding-left:50px"><br><br><?php echo $que['scale_name'];?><br></td>-->
				</tr>
				
			<?php	
			   $ss=Doctrine_Query::create()->select('text,correct_flag')->from("UlsQuestionValues")->where("question_id=".$que['question_id'])->execute();
		        foreach($ss as $key1=>$sss){
					$ke=$key1+1;
		            if($type=='F'){  ?>
		                <tr><td></td><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;..............................................</td></tr>
		  <?php     } 
		            else if($type=='B'){ ?>
						<tr><td></td><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;..............................................</td></tr>
		<?php		}
		            else if($type=='T'){ ?>
					    <tr><td><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;".$ke."]"; ?></td><td colspan="2"><?php echo $sss['text'];?> </td></tr>
			<?php 	} 
			        else if($type=='S'){ ?>
					    <tr><td><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;".$ke."]"; ?></td><td colspan="2"><?php echo $sss['text'];?></td></tr>
					    
			<?php	}
			        else if($type=='M') { ?>
					    <tr><td></td><td colspan="2"><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;".$ke."] ".$sss['text'];?></td></tr>
			 <?php  } 
			        else if($type=='FT') { ?>
						<tr><td></td><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;..............................................<br>&nbsp;&nbsp;&nbsp;&nbsp;.............................................<br>&nbsp;&nbsp;&nbsp;&nbsp;.............................................</td></tr>
			<?php	} ?>
		<?php   } ?>
	  <?php } ?>
			
		</table>
</div>

</page>

<?php
	echo $content = ob_get_clean();
	/* require(LIB_PATH.DS."html2pdf.class.php");
    try{
		$html2pdf = new HTML2PDF('P', array(215.9,279), 'fr', true, 'UTF-8', array(0, 0, 0, 0));
		$html2pdf->pdf->SetDisplayMode("fullpage");
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('bookmark.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    } */ 
?>