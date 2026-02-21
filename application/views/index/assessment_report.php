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
$dateObj   = DateTime::createFromFormat('!m', 12);
$monthName = $dateObj->format('F');
?>
<style type="text/css">
<!--
    table.page_header {width: 100%; border: none; padding: 10mm 2mm 0mm 0mm; }
    table.page_footer {width: 100%; border: none; background-color: #d78585; border-top: solid 1mm #d73f41; padding: 2mm}
	div.note {font-size: 16px;font-weight:bold;background-color:#F37F2A; padding: 2mm; border-radius: 2mm; width: 100%; }
    h1 {color: #000033; text-decoration:underline;background-color: #d78585;width:1000px;}
    h2 {color: #000055; text-decoration:underline;}
    h3 {color: #000077; text-decoration:underline;}
	h4 {color: #000099; text-decoration:underline;}

    div.niveau
    {
        padding-left: 5mm;
    }
-->
.bordered table
{
    width: 99%;
    border:1px solid #CCCCCC;
	border-radius:10px;
}
	 
.bordered th
{
	border-radius:1px;
	padding: 5px;
	color:#FFFFFF;
    text-align: center;
    border:1px dashed #4AC0F2;
    background: #DCE9F9;
	background-color:#4AC0F2;
	
}
.bordered td
{
	border-radius:1px;
    text-align: center;
	padding: 5px;
    border: 1px dashed #4AC0F2;
	background-color:#FFFFFF;
}
</style>
<!--<page backtop="0mm"  backbottom="0mm" backleft="0mm" backright="0mm" backimgx="0mm" backimgy="0mm" backimgw="215.8mm" backimg="<?php echo BASE_URL; ?>/public/images/reports/report.jpg" style="font-size: 20pt;">
<div align="center" style="padding:100mm 0mm 0mm 0mm;" ><span style="font-size: 24pt;">Monthly Report</span><br>for <br><span style="font-size: 24pt;"></span></div>
</page>-->

<page pageset="new" backtop="25mm" backbottom="10mm" backleft="10mm" backright="10mm"  backimgx="0mm" backimgy="0mm" backimgw="215.8mm" backimg="<?php echo BASE_URL;?>/public/images/reports/bg-1.jpg" >
	<page_header>
        <table class="page_header">
            <tr>
                <td style="width: 100%; text-align:right">
                    <b>Confidential</b>
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

</page>
	<div class="niveau">
		<h2>NON-MANAGEMENT STAFF (NMS) TO MANAGEMENT STAFF (MS) ASSESSMENT PROCESS CIL</h2><br>
		<table style='width:100%' class='bordered'>
			<col style='width:40%'>
			<col style='width:60%'>
			
			<tr>
				<td align="left" >Employee Name</td>
				<td align="left" ><?php echo $emp_info['name']; ?></td>
			</tr>
			<tr>
				<td align="left" >Employee Number</td>
				<td align="left" ><?php echo $emp_info['enumber']; ?></td>
			</tr>
			<tr>
				<td align="left" >Position</td>
				<td align="left" ><?php echo $emp_info['position_name']; ?></td>
			</tr>
		</table><br>
	</div>
	
	<div class="niveau">
		<div class="note">Competency/Skill Requirements</div><br>
		<table style='width:100%' align="center" class='bordered'>
			<col style='width:40%'>
			<col style='width:20%'>
			<col style='width:20%'>
			<col style='width: 20%'>
			<tr>
				<th>Competency/Skill</th>
				<th>Level Requirement</th>
				<th>Criticality</th>
				<th>Weightage in Overall assessment</th>
			</tr>
			
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			
		</table><br>
	</div>
	<div class="niveau">
		<div class="note">Assessment Results</div><br>
		<table style='width:100%' align="center" class='bordered'>
			<col style='width:40%'>
			<col style='width:15%'>
			<col style='width:15%'>
			<col style='width:15%'>
			<col style='width:15%'>
			<tr>
				<th>Competency / Skill</th>
				<th>Total of Questions</th>
				<th>Correctly Answered</th>
				<th>Wrongly Answered</th>
				<th>Percentage(%)</th>
			</tr>
			
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			
		</table><br>
	</div>
	
		
<?php

	$content = ob_get_clean();
	require(LIB_PATH.DS."html2pdf.class.php");
    try{
		$html2pdf = new HTML2PDF('L', array(215.9,279), 'fr', true, 'UTF-8', array(0, 0, 0, 0));
		$html2pdf->pdf->SetDisplayMode("fullpage");
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		/* $html2pdf->createIndex('Content', 20, 12,true, true, $on_page = null, $font_name = 'helvetica'); */
        $html2pdf->Output('bookmark.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
