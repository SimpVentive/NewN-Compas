<?php
include_once("dbconnect.php");
require_once('includes/graph/includes/SVGGraph.php');

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
		
	$par=array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
	$k=0;
	while($r=mysqli_fetch_array($q)){
		$v=$par[$k];
		$comp_name[$v]=$r['comp_def_name'];
		$Series1[$v]= $r['req_number'];
		$Series2[$v]= $r['ass_number'];
		$k++;
	}
		
	
	
	/* for($i=0;$i<count($comp_name); $i++){
		$sd[]=$par[$i];			 
	} */
	
	$settings = array(
	'back_colour'       	=> '#fff', 		'stroke_colour'      => '#666',
	'back_stroke_width' 	=> 0,			'back_stroke_colour' => '#fff',
	'axis_colour'       	=> '#666',		'axis_overlap'       => 2,
	'axis_font'         	=> 'Georgia',	'axis_font_size'     => 10,
	'grid_colour'       	=> '#666',		'label_colour'       => '#666',
	'pad_right'         	=> 50,			'pad_left'           => 50,
	'link_base'         	=> '/',			'link_target'        => '_top',
	'fill_under'        	=> false,		'reverse'			=> true, 'start_angle' => 90,
	'marker_size'       	=> 6,			'axis_max_v'  => 5 ,'minimum_subdivision' =>5,'grid_division_v' =>1,
	//'marker_type'       	=> array('*', 'star'),
	//'marker_colour'     	=> array('#008534', '#850000')
	'legend_stroke_width'	=> 1,			'legend_shadow_opacity' => 0,'legend_stroke_colour'	=> '#666',
	'legend_title' => "",					'legend_columns' => 4,'legend_colour' => "#666",
	'legend_text_side' => "right",			'legend_position'		=> "outer bottom 10 -10",'marker_opacity'=>0.5
	);

	$settings['legend_entries'] = array('Required Level', 'Assessed Level');

	$values = array($Series1, $Series2);
	 
	$colours = array(array('#5b9bd5', '#5b9bd5'),array('#72d65e', '#72d65e'));
	$graph = new SVGGraph(500, 500, $settings);
	$graph->colours = $colours;
	 
	$graph->Values($values);
	//$graph->Render('MultiRadarGraph');
	
	$value11=$graph->Fetch('MultiRadarGraph', false);//$graph->Fetch('MultiRadarGraph', false);
	$target_path="public/reports/graphs/self/$ass_id";
	
	
	
	if(is_dir($target_path)){
	//echo "Exists!";
	} 
	else{ 
	//echo "Doesn't exist" ;
	mkdir($target_path,0777);
	// Read and write for owner, nothing for everybody else
	chmod($target_path, 0777);
	//print "created";
	}

	$myfile = fopen($target_path."/".$r_cat['category_id']."_".$emp_id."_".$pos_id."_radar.svg", "w") or die("Unable to open file!");
	fwrite($myfile, $value11);
	fclose($myfile);
			
			
	}
}
?>