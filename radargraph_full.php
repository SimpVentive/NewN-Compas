<?php   

include_once("dbconnect.php");
/* ini_set("display_errors",1); */
include("pchart/class/pData.class.php");
include("pchart/class/pDraw.class.php");
include("pchart/class/pRadar.class.php");
include("pchart/class/pImage.class.php");

$ass_id=$_REQUEST['ass_id'];
$pos_id=$_REQUEST['pos_id'];
$emp_id=$_REQUEST['emp_id'];
if(isset($_REQUEST['ass_id'])){
	$uploaddir1 ="public/reports/graphs/full/".$ass_id;
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
	
$results=$assessor=array();
$sql ="select b.comp_def_id, b.comp_def_name as comp_def_name,s.scale_id as req_scale_id, s.scale_name as req_scale_name,a.report_id,a.assessed_scale_id as final_scaled_id,ass.scale_name as final_scaled_name,a.development_area,ct.comp_cri_name,ct.comp_rating_value,s.scale_number as req_scale,ass.scale_number as ass_scale,b.comp_def_short_desc,l.level_scale,ct.comp_cri_code, a.* from uls_assessment_report a
left join (select comp_def_id,comp_def_name,comp_def_short_desc from uls_competency_definition group by comp_def_id)b on b.comp_def_id=a.competency_id
left join(SELECT `comp_position_id`,`comp_position_competency_id`,`comp_position_criticality_id` FROM `uls_competency_position_requirements`) c on c.comp_position_id=a.position_id and c.comp_position_competency_id=a.competency_id
left join(SELECT `comp_cri_id`,`comp_cri_name`,comp_rating_value,comp_cri_code FROM `uls_competency_criticality`) ct on ct.comp_cri_id=c.comp_position_criticality_id
left join (select scale_id,scale_name,scale_number,level_id from uls_level_master_scale group by scale_id)s on s.scale_id=a.require_scale_id
left join(SELECT `level_id`,`level_scale` FROM `uls_level_master`) l on l.level_id=s.level_id
left join (select scale_id,scale_name,scale_number from uls_level_master_scale group by scale_id)ass on ass.scale_id=a.assessed_scale_id
where 1 and a.assessment_id=$ass_id and a.position_id=$pos_id and a.employee_id=$emp_id and a.assessor_id is not NULL order by a.assessment_id asc";
$q=mysqli_query($con,$sql);
$num_rows = mysqli_num_rows($q);
if($num_rows>0){
while($ass_comp_infos=mysqli_fetch_array($q)){
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
$req_sid=$ass_sid=$comname=array();
foreach($results as $comp_def_id=>$result){
	$final_admin_id=$_SESSION['user_id'];
	$ass_comp=UlsAssessmentReport::getadminassessment_competencies_insert($result['assessment_id'],$result['position_id'],$result['employee_id'],$final_admin_id,$comp_def_id);
	$level_id=UlsCompetencyDefinition::viewcompetency($comp_def_id);
	$scale_overall=UlsLevelMasterScale::levelscale_detail($ass_comp['assessed_scale_id']);
	$req_v=$result['comp_rating_value'];
	$req_scale_id=$result['req_scale_id'];
	$ass_scale_id=$ass_comp['assessed_scale_id'];
	$ass_scale_name=$scale_overall['scale_name'];
	$comname[]=$result['comp_name'];
	$req_sid[]=$result['req_scale'];
	$ass_sid[]=$scale_overall['scale_number'];
	
}
		
$par=array("A","B","C","D","E","F","G","H","I","J","K","L","M");
$sd=array();
for($i=0;$i<count($comname); $i++){
	$sd[]=$par[$i];			 
}
$MyData = new pData();
$MyData->addPoints($req_sid,"Required Level");  
$MyData->addPoints($ass_sid,"Assessed Level"); 
$MyData->addPoints($sd,"Labels");
$MyData->setAbscissa("Labels");


$myPicture = new pImage(400,400,$MyData);
$myPicture->drawGradientArea(0,0,400,400,DIRECTION_VERTICAL,array("StartR"=>255,"StartG"=>255,"StartB"=>255,"EndR"=>255,"EndG"=>255,"EndB"=>255,"Alpha"=>100));
$myPicture->drawGradientArea(0,0,400,20,DIRECTION_HORIZONTAL,array("StartR"=>30,"StartG"=>30,"StartB"=>30,"EndR"=>100,"EndG"=>100,"EndB"=>100,"Alpha"=>100));
$myPicture->drawLine(0,20,400,20,array("R"=>255,"G"=>255,"B"=>255));
$RectangleSettings = array("R"=>180,"G"=>180,"B"=>180,"Alpha"=>100);

/* Add a border to the picture */
$myPicture->drawRectangle(0,0,399,399,array("R"=>0,"G"=>0,"B"=>0));

/* Write the picture title */ 
$myPicture->setFontProperties(array("FontName"=>"pchart/fonts/verdana.ttf","FontSize"=>12));
$myPicture->drawText(10,13,"Radar Graph",array("R"=>255,"G"=>255,"B"=>255));

/* Set the default font properties */ 
$myPicture->setFontProperties(array("FontName"=>"pchart/fonts/verdana.ttf","FontSize"=>12,"R"=>80,"G"=>80,"B"=>80));

/* Enable shadow computing */ 
$myPicture->setShadow(TRUE,array("X"=>2,"Y"=>2,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

/* Create the pRadar object */ 
$SplitChart = new pRadar();

/* Draw a radar chart */ 
$myPicture->setGraphArea(10,25,390,390);
$Options = array("DrawPoly"=>TRUE,"WriteValues"=>TRUE,"ValueFontSize"=>8,"Layout"=>RADAR_LAYOUT_CIRCLE,"BackgroundGradient"=>array("StartR"=>255,"StartG"=>255,"StartB"=>255,"StartAlpha"=>100,"EndR"=>207,"EndG"=>227,"EndB"=>125,"EndAlpha"=>50));
$SplitChart->drawRadar($myPicture,$MyData,$Options);

/* Render the picture (choose the best way) */
//$myPicture->autoOutput("public/reports/graphs/full/$ass_id/".$emp_id."_".$pos_id."_radar.png");
$myPicture->render("public/reports/graphs/full/$ass_id/".$emp_id."_".$pos_id."_radar.png");
} 
?>
