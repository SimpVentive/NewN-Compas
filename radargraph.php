<?php   

include_once("dbconnect.php");
/* ini_set("display_errors",0); */
include_once("pchart/class/pData.class.php");
include_once("pchart/class/pDraw.class.php");
include_once("pchart/class/pRadar.class.php");
include_once("pchart/class/pImage.class.php");

$ass_id=$_REQUEST['ass_id'];
$pos_id=$_REQUEST['pos_id'];
$emp_id=$_REQUEST['emp_id'];
if(isset($_REQUEST['ass_id'])){
	$uploaddir1 ="public/reports/graphs/self/".$ass_id;
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
	

$cat_sql="SELECT c.category_id,c.name FROM `uls_self_assessment_competencies` a
left join(SELECT `comp_def_id`,`comp_def_name`,`comp_def_category` FROM `uls_competency_definition`) b on a.	assessment_pos_com_id=b.comp_def_id
left join(SELECT `category_id`,`name` FROM `uls_category`) c on b.comp_def_category=c.category_id
where a.assessment_id=$ass_id and a.position_id=$pos_id group by b.comp_def_category ";
$q_cat=mysqli_query($con,$cat_sql);
while($r_cat=mysqli_fetch_array($q_cat)){
	$Series1=$Series2=$sd=$comp_name=array();
	$sql ="select b.comp_def_id, b.comp_def_name as comp_def_name,s.scale_id as req_scale_id, s.scale_name as req_scale_name,a.self_report_id,a.assessed_scale_id as final_scaled_id,ass.scale_name as final_scaled_name, a.* ,s.scale_number as req_number,ass.scale_number as ass_number,ct.comp_cri_name,ct.comp_rating_value,b.comp_def_short_desc,l.level_scale,ct.comp_cri_code from uls_self_assessment_report a
	left join (select comp_def_id,comp_def_name,comp_def_short_desc,comp_def_category from uls_competency_definition group by comp_def_id)b on b.comp_def_id=a.competency_id
	left join(SELECT `comp_position_id`,`comp_position_competency_id`,`comp_position_criticality_id` FROM `uls_competency_position_requirements`) c on c.comp_position_id=a.position_id and c.comp_position_competency_id=a.competency_id
	left join(SELECT `comp_cri_id`,`comp_cri_name`,comp_rating_value,comp_cri_code FROM `uls_competency_criticality`) ct on ct.comp_cri_id=c.comp_position_criticality_id
	left join (select scale_id,scale_name,scale_number,level_id from uls_level_master_scale group by scale_id)s on s.scale_id=a.require_scale_id
	left join(SELECT `level_id`,`level_scale` FROM `uls_level_master`) l on l.level_id=s.level_id
	left join (select scale_id,scale_name,scale_number from uls_level_master_scale group by scale_id)ass on ass.scale_id=a.assessed_scale_id
	where 1 and a.assessment_id=$ass_id and a.position_id=$pos_id and b.comp_def_category=".$r_cat['category_id']."  and a.employee_id=$emp_id  order by b.comp_def_name asc";
	$q=mysqli_query($con,$sql);
	$num_rows = mysqli_num_rows($q);
	if($num_rows!=0){
		

	while($r=mysqli_fetch_array($q)){
		$comp_name[]=$r['comp_def_name'];
		$Series1[]= $r['req_number'];
		$Series2[]= $r['ass_number'];
	}
		
	$par=array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
	
	for($i=0;$i<count($comp_name); $i++){
		$sd[]=$par[$i];			 
	}

$MyData = new pData();
$MyData->addPoints($Series2,"Self");  
$MyData->addPoints($Series1,"Others"); 
$MyData->addPoints($sd,"Labels");
$MyData->setAbscissa("Labels");


$myPicture = new pImage(400,400,$MyData);
$myPicture->drawGradientArea(0,0,400,400,DIRECTION_VERTICAL,array("StartR"=>255,"StartG"=>255,"StartB"=>255,"EndR"=>255,"EndG"=>255,"EndB"=>255,"Alpha"=>100));
//$myPicture->drawGradientArea(0,0,400,20,DIRECTION_HORIZONTAL,array("StartR"=>30,"StartG"=>30,"StartB"=>30,"EndR"=>100,"EndG"=>100,"EndB"=>100,"Alpha"=>100));
//$myPicture->drawLine(0,20,400,20,array("R"=>255,"G"=>255,"B"=>255));
$RectangleSettings = array("R"=>180,"G"=>180,"B"=>180,"Alpha"=>100);

/* Add a border to the picture */
//$myPicture->drawRectangle(0,0,399,399,array("R"=>0,"G"=>0,"B"=>0));

/* Write the picture title */ 
//$myPicture->setFontProperties(array("FontName"=>"pchart/fonts/verdana.ttf","FontSize"=>12));
//$myPicture->drawText(10,13,"",array("R"=>255,"G"=>255,"B"=>255));

/* Set the default font properties */ 
$myPicture->setFontProperties(array("FontName"=>"pchart/fonts/verdana.ttf","FontSize"=>12,"R"=>80,"G"=>80,"B"=>80));

/* Enable shadow computing */ 
$myPicture->setShadow(TRUE,array("X"=>2,"Y"=>2,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

/* Create the pRadar object */ 
$SplitChart = new pRadar();

/* Draw a radar chart */ 
$myPicture->setGraphArea(0,0,399,399);
$Options = array("DrawPoly"=>False,"WriteValues"=>TRUE,"ValueFontSize"=>8,"Layout"=>RADAR_LAYOUT_CIRCLE,"DrawBackground"=>False,"BackgroundGradient"=>array("StartR"=>255,"StartG"=>255,"StartB"=>255,"StartAlpha"=>100,"EndR"=>207,"EndG"=>227,"EndB"=>125,"EndAlpha"=>50));
$SplitChart->drawRadar($myPicture,$MyData,$Options);

/* Render the picture (choose the best way) */
//$myPicture->autoOutput("public/reports/graphs/self/$ass_id/".$emp_id."_".$pos_id."_radar.png");
$myPicture->render("public/reports/graphs/self/$ass_id/".$r_cat['category_id']."_".$emp_id."_".$pos_id."_radar.png"); 
	}
}
?>
