<?php   

include_once("dbconnect.php");
include("pchart/class/pData.class.php");
include("pchart/class/pDraw.class.php");
include("pchart/class/pPie.class.php");
include("pchart/class/pImage.class.php");
$ass_id=$_REQUEST['ass_id'];
$pos_id=$_REQUEST['pos_id'];
if(isset($_REQUEST['ass_id'])){
	$uploaddir1 ="public/reports/graphs/nms/".$ass_id;
	//echo $uploaddir1;
	if(is_dir($uploaddir1)){
		//echo "Exists!";
	}
	else{
		//echo "Doesn't exist" ;
		mkdir($uploaddir1,0777);
		//print "created";
	}
}
$sql ="select b.full_name, b.employee_number, b.org_name,b.email, b.position_name,b.office_number, a.* from uls_assessment_employees a
left join (select employee_id,full_name,employee_number,org_name,position_name,email,office_number from employee_data group by employee_id)b on b.employee_id=a.employee_id
where 1 and a.position_id=".$pos_id." and a.assessment_id=".$ass_id." order by a.assessment_id asc";
$q=mysqli_query($con,$sql);
$num_rows = mysqli_num_rows($q);
if($num_rows>0){
	while($ass_comp_infos=mysqli_fetch_array($q)){
		$query ="SELECT a.* FROM uls_assessment_test a
		WHERE a.assessment_id=".$ass_id." and a.position_id=".$pos_id." and a.assessment_type='TEST'";
		$test=mysqli_query($con,$query);
		$test_id=mysqli_fetch_object($test);
		$test_score="SELECT * FROM `uls_utest_attempts_assessment` WHERE `assessment_id`=".$ass_id." and event_id=".$test_id->assess_test_id." and test_id=".$test_id->test_id." and employee_id=".$ass_comp_infos['employee_id'];
		$testscore=mysqli_query($con,$test_score);
		while($tests=mysqli_fetch_array($testscore)){
			$test_total=$tests['correct_ans']+$tests['wrong_ans'];
			$test_correct_ans=round(($tests['correct_ans']/$test_total)*100,1);
			$wrong_ans=round(($tests['wrong_ans']/$test_total)*100,1);
			//echo $test_correct_ans."-".$wrong_ans;
			/* Create and populate the pData object */
			$MyData = new pData();   
			$MyData->addPoints(array($tests['correct_ans'],$tests['wrong_ans']),"ScoreA");  
			$MyData->setAbscissa("ScoreA","Application A");
			
			$MyData->addPoints(array("Correct-".$tests['correct_ans'],"Wrong-".$tests['wrong_ans']),"Labels");
			$MyData->setAbscissa("Labels");	
			/* Define the absissa serie */
			

			/* Create the pChart object */
			$myPicture = new pImage(330,250,$MyData,TRUE);

			/* Draw a solid background */
			$Settings = array("R"=>255, "G"=>255, "B"=>255, "Dash"=>1, "DashR"=>255, "DashG"=>255, "DashB"=>255);
			$myPicture->drawFilledRectangle(0,0,700,250,$Settings);

			/* Draw a gradient overlay */
			$Settings = array("StartR"=>255, "StartG"=>255, "StartB"=>255, "EndR"=>255, "EndG"=>255, "EndB"=>255, "Alpha"=>90);
			$myPicture->drawGradientArea(0,0,700,250,DIRECTION_VERTICAL,$Settings);
			/* $myPicture->drawGradientArea(0,0,700,20,DIRECTION_VERTICAL,array("StartR"=>255,"StartG"=>255,"StartB"=>255,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>100)); */

			/* Add a border to the picture */
			$myPicture->drawRectangle(0,0,699,250,array("R"=>255,"G"=>255,"B"=>255));

			/* Write the picture title 
			$myPicture->setFontProperties(array("FontName"=>"pchart/fonts/verdana.ttf","FontSize"=>6));
			$myPicture->drawText(10,13,"Graph",array("R"=>255,"G"=>255,"B"=>255)); */

			/* Set the default font properties */ 
			$myPicture->setFontProperties(array("FontName"=>"pchart/fonts/verdana.ttf","FontSize"=>10,"R"=>80,"G"=>80,"B"=>80));

			/* Create the pPie object */ 
			$PieChart = new pPie($myPicture,$MyData);

			/* Define the slice color */
			$PieChart->setSliceColor(0,array("R"=>143,"G"=>197,"B"=>0));
			$PieChart->setSliceColor(1,array("R"=>97,"G"=>77,"B"=>63));
			$PieChart->setSliceColor(2,array("R"=>97,"G"=>113,"B"=>63));



			/* Enable shadow computing */ 
			$myPicture->setShadow(TRUE,array("X"=>3,"Y"=>3,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

			/* Draw a splitted pie chart */ 
			$PieChart->draw3DPie(165,130,array("Radius"=>150,"WriteValues"=>TRUE,"DataGapAngle"=>10,"DataGapRadius"=>6,"Border"=>TRUE));

			/* Write the legend */
			$myPicture->setFontProperties(array("FontName"=>"pchart/fonts/verdana.ttf","FontSize"=>6));
			$myPicture->setShadow(TRUE,array("X"=>2,"Y"=>1,"R"=>255,"G"=>255,"B"=>255,"Alpha"=>20));

			/* $myPicture->drawText(120,200,"Extended AA pass / Splitted",array("DrawBox"=>TRUE,"BoxRounded"=>TRUE,"R"=>0,"G"=>0,"B"=>0,"Align"=>TEXT_ALIGN_TOPMIDDLE)); */

			/* Write the legend box */ 
			$myPicture->setFontProperties(array("FontName"=>"pchart/fonts/verdana.ttf","FontSize"=>10));
			//$PieChart->drawPieLegend(600,8,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
			$PieChart->drawPieLegend(10,13,array("Alpha"=>10));
			/* Render the picture (choose the best way) */
			//$myPicture->autoOutput("public/reports/graphs/nms/$ass_id/".$tests['employee_id']."_".$pos_id."_pie.png");
			$myPicture->render("public/reports/graphs/nms/$ass_id/".$tests['employee_id']."_".$pos_id."_pie.png");
		}
	}
}

?>
