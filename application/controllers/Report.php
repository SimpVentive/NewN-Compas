<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends  MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		//$this->load->model('QuizUsermaster');		
	}
	 
	
	
	/* public function index(){ 
		if($this->session->userdata('emp_id')){
			$data["aboutpage"]=$this->pagedetails('admin','index');
			$content = $this->load->view('admin/index',$data,true);
			$this->render('layouts/adminnew',$content);
		}
	} */
	
	public function pagedetails($controller,$page){
        $str=array(); $values=array("pagetitle"=>"title","pagekeyword"=>"keyword","pagedescription"=>"description","pagecss"=>"css","pagejs"=>"js");
        $pagedeatils=Doctrine_Query::Create()->from('UlsPages')->where("controller='$controller' and page='$page'")->fetchOne();
		$data=array();
        foreach($values as $key=>$val){
			$str[$key]=isset($pagedeatils->id)? $pagedeatils->$val:"";
			$data[$key]=$str[$key];
        }
		return $data;
    }
	
	/*Modified by Prasad Used for Menu Change option */
	public function layoutmenus(){ 
		$id=$_REQUEST['id']; 
		$this->session->set_userdata('Role_id',$id);
		$this->session->set_userdata('Menu_Id',$_REQUEST['menu']);
		$role=Doctrine_Core::getTable('UlsMenuCreation')->find($_REQUEST['menu']);
		$this->session->set_userdata('user_role',$role->system_menu_type);            
		$parentid=Doctrine_Core::getTable('UlsRoleCreation')->find($id);
		$this->session->set_userdata('parent_org_id',$parentid->parent_org_id); 
		$orgdata=Doctrine_Core::getTable('UlsOrganizationMaster')->find($parentid->parent_org_id);
		$this->session->set_userdata('org_start_date',$orgdata->start_date);
		$this->session->set_userdata('org_end_date',$orgdata->end_date);
		$emp_id=Doctrine_Core::getTable('UlsUserCreation')->find($this->session->userdata('user_id'));
		$this->session->set_userdata('emp_id',$emp_id->employee_id);
		$coun=Doctrine_Query::Create()->from('UlsEmployeeWorkInfo')->where('supervisor_id='.$emp_id->employee_id)->execute();
		$counts=count($coun);
		($counts>0)?$this->session->set_userdata('mngr_id',$emp_id->employee_id):"";
		/* $aaa=($_SESSION['user_role']=="tra")? $this->registry->template->training('admin_profile_manager','admin-layout'):$this->registry->template->training('admin_profile','admin-layout');
		header("Location: {$aaa}"); */
		redirect("admin/profile");
	}
         
	public function dashboard(){
		/*$this->sessionexist();*/
		$data["aboutpage"]=$this->pagedetails("report","reportgeneration"); 
		$data['reports']=UlsReports::getreportparams();
		$content = $this->load->view('report/lms_admin_dashboard1',$data,true);
		$this->render('layouts/adminnew',$content);
	}        
       
	public function report_create(){
		/*$this->sessionexist();*/
		$data["aboutpage"]=$this->pagedetails("report","reports"); 
		$mcode='REPORT_STATUS';
		$data['status']=UlsAdminMaster::get_value_names($mcode);
		$data['pcode']=UlsReports::getparamcode();
		$data['rtype']=UlsReports::getReporttype();
		$id=filter_input(INPUT_GET,'id') ? filter_input(INPUT_GET,'id'):""; 
		$hash=filter_input(INPUT_GET,'hash') ? filter_input(INPUT_GET,'hash'):""; 
		$flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
		if($flag==1 && !empty($id) ){
			$content = $this->load->view('report/lms_admin_restriction',$data,true);
		}
		else{
			if(!empty($id)){
				$repor=Doctrine_Core::getTable('UlsReports')->find($id); 
				$reporttypes=Doctrine_Query::Create()->from('UlsReportDefaultparameters')->where('default_report_id='.$repor->report_type_id)->execute();
				$data['types']=$reporttypes;
				$data['report']=$repor;
				$levels=Doctrine_Query::Create()->from('UlsReportParameters')->where('report_id='.$id)->execute();
				$data['rdetails']=$levels;
			}
			$content = $this->load->view('report/lms_admin_report_create',$data,true);
		}
		$this->render('layouts/adminnew',$content);	
	}
	
	public function report_view(){
		/*$this->sessionexist();*/
		$id=filter_input(INPUT_GET,'id') ? filter_input(INPUT_GET,'id'):""; 
		$hash=filter_input(INPUT_GET,'hash') ? filter_input(INPUT_GET,'hash'):""; 
		$flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;        
		if($flag==1  || $id==""){
			$content = $this->load->view('report/lms_admin_restriction',$data,true);
		}
		else{   $id=$_REQUEST['id'];
			//$this->pagedetails("admin","notification");
			$data['reportdetails']=UlsReports::get_report_details($id);
			$content = $this->load->view('report/lms_admin_report_view',$data,true);
		}
		$this->render('layouts/adminnew',$content);
	}

     public function reports(){
		/*$this->sessionexist();*/
        $data["aboutpage"]=$this->pagedetails("report","reports"); 
        $limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
        $report_name=filter_input(INPUT_GET,'report_name') ? filter_input(INPUT_GET,'report_name'):"";       
        $page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
        $start=$page!=0? ($page-1)*$limit:0;	
        $filePath=BASE_URL."/report/reports";
        $data['limit']=$limit;
        $data['report_name']=$report_name;
		$data['perpages']=UlsMenuCreation::perpage();
        $data['reportdetails']=UlsReports::search($start,$limit,$report_name);
        $total=UlsReports::searchcount($report_name);
        $otherParams="perpage=".$limit."&report_name=$report_name";
        $data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams); 
		$content = $this->load->view('report/lms_admin_reports',$data,true);
		$this->render('layouts/adminnew',$content);
    }
      
     public function reportgroups(){
		/*$this->sessionexist();*/
		$data["aboutpage"]=$this->pagedetails("report","reportssearch"); 
		$limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
		$reportg_name=filter_input(INPUT_GET,'reportg_name') ? filter_input(INPUT_GET,'reportg_name'):"";       
		$page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
		$start=$page!=0? ($page-1)*$limit:0;	
		$filePath=BASE_URL."/report/reportgroups";
		$data['limit']=$limit;
		$data['reportg_name']=$reportg_name;
		$data['perpages']=UlsMenuCreation::perpage();
		$data['reportgdetails']=UlsReportGroups::search($start,$limit,$reportg_name);
		$total=UlsReportGroups::searchcount($reportg_name);
		$otherParams="perpage=".$limit."&reportg_name=$reportg_name";
		$data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams); 
		$content = $this->load->view('report/lms_admin_reports_group_search',$data,true);
		$this->render('layouts/adminnew',$content);	
	}  
       
     
	public function reportgroup_view(){
		/*$this->sessionexist();*/
		$id=filter_input(INPUT_GET,'id') ? filter_input(INPUT_GET,'id'):""; 
		$hash=filter_input(INPUT_GET,'hash') ? filter_input(INPUT_GET,'hash'):""; 
		$flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;        
		if($flag==1  || $id==""){
			$content = $this->load->view('report/lms_admin_restriction',$data,true); 
		}
		else{
			$id=$_REQUEST['id'];
			//$this->pagedetails("admin","notification");
			$data['groupdetails']=UlsReportGroups::get_groupdetails($id);
			$data['reportdetails']=UlsReportGroups::get_groupreport_details($id);
			$content = $this->load->view('report/lms_admin_reportgroup_view',$data,true);
		}
		$this->render('layouts/adminnew',$content);
	}      
      
	public function getgroupreportdetails(){
		$gid=$_REQUEST['id'];
		$groupsdeails=UlsReports::getgroupreportdetails12($gid);
		echo "<table id='groupreportTable' class='bordered' style='width:660px;height:40px;'>
		<thead>
		<tr><th style='width:50px;'>S.No</th>
		<th style='width:100px;'>Group Name</th>
		<th style='width:100px;'>Parent Organization</th>
		<th style='width:100px;'>Number of Reports</th>
		<th style='width:100px;'>Edit </th>
		</tr>
		</thead>
		</table>
		<div style='height:200px; over-flow:auto'>
		<table id='groupreportTable1' class='bordered' style=' margin-top:-1px;width:660px;'>";
		if(count($groupsdeails)>0){
			foreach($groupsdeails as $key=>$groupsdeail){ $key=($key==0)? $key+1 : $key+1;
				echo "<tr><td style='width:56px;' >".$key."</td><td style='width:100px;'>".$groupsdeail['name']."</td><td style='width:105px;'>".$groupsdeail['orgname']."</td>
				<td style='width:105px;'>".$groupsdeail['numreports']."</td><td style='width:100px;'><a href='addreports?id=".$groupsdeail['id']."'><img src='".BASE_URL."/public/images/edit.gif' /></a></td></tr>";
			}
		}
		else {
			echo "<tr><td colspan='7'>No Rearch Results Available.</td></tr>";
		}
		echo "</table></div>";
	}

	public function getreporttypes(){          
		$typeid=$_REQUEST['id'];
		if($typeid!=''){
			$cc=Doctrine_Query::Create()->from("UlsReportDefaultparameters")->where("default_report_id=".$typeid)->execute();
			$values="";
			$sds=" <select name='syscode[]' class='validate[required] form-control m-b' id='syscode1'>
			<option value=''>select</option>";
			foreach($cc as $params){
				//echo "haii <br /> hello <br /> haiii.";
				if(empty($values)){
					$values=$params->parameter_code.'###'.$params->parameter_name;
				}
				else{ $values=$values.'***'.$params->parameter_code.'###'.$params->parameter_name; }
				$sds.= "<option value='".$params->parameter_code."'>".$params->parameter_name."</option>"; 
			}
			$sds.="</select>";
			$sds.= "<input type='hidden' name='grouptypeid' id='grouptypeid' value='".$typeid."' /> <input type='hidden' name='typevalues' id='typevalues' value='".$values."' />";
			echo $sds;
		}
	}

	public function reportcreation(){
		/*$this->sessionexist();*/
		if(isset($_POST['report_name'])){
			$fieldinsert=array('report_name'=>'report_name','report_type_id'=>'reptype','comments'=>'comments','query_name'=>'queryfun');
			$sde=trim($_POST['report_id']);
			$masters=!empty($sde)? Doctrine::getTable('UlsReports')->find($sde):new UlsReports();
			foreach($fieldinsert as $key=>$post_val){
				$masters->$key=$_POST[$post_val];
			}
			$masters->save();           
			foreach($_POST['syscode'] as $key=>$syscode){
				$reportparams=!empty($_POST['report_paramid'][$key])? Doctrine::getTable('UlsReportParameters')->find($_POST['report_paramid'][$key]) : new UlsReportParameters();
				$reportparams->report_id=$masters->report_id;
				$reportparams->parameter_name=trim($_POST['param'][$key]);
				$reportparams->param_code=$syscode;
				$reportparams->status=$_POST['visible'][$key];
				$reportparams->save();
			}
			redirect("report/reports");     
		}
	}
      
	function deletegroupreport(){
		$id=trim($_REQUEST['val']);
		if(!empty($id)){
			$q = Doctrine_Query::Create()->delete('UlsReportGroupDetails')->where('report_group_id=?',$id);
			$q->execute();
			$qq=Doctrine_Query::Create()->delete('UlsReportGroups')->where('report_group_id=?',$id);
			$qq->execute();
			echo 1;
		}
	}
      
	function deletereport(){
		$id=trim($_REQUEST['val']);
		if(!empty($id)){
			$q = Doctrine_Query::Create()->from('UlsReportGroupDetails')->where('report_id=?',$id);
			$q->execute();
			if(count($q)>0){
				echo "This Report used in report groups.So you cant Delete it.";
			}
			else {  
				$qq =Doctrine_Query::create()->delete('UlsReportParameters')->where("report_id=".$id)->execute();
				$qq=Doctrine_Query::Create()->delete('UlsReports')->where('report_id=?',$id);
				$qq->execute();
				echo 1;
			}
		}
	}
      
	public function deletetereportvals(){
		// $cid=$_REQUEST['cid'];  
		$lid=$_REQUEST['id'];
		$q =!empty($lid)? Doctrine_Query::create()->delete('UlsReportParameters')->where("report_param_id=".$lid)->execute():"";
	}      
      
	public function reportgroup_create(){
		/*$this->sessionexist();*/
		$data["aboutpage"]=$this->pagedetails("report","reportgroup_create"); 
		$mcode='REPORT_STATUS';
		$data['status']=UlsAdminMaster::get_value_names($mcode);
		$data['parentorgs']=UlsOrganizationMaster::parent_orgs();
		$data['groups']=UlsReports::getallreports();
		if(isset($_REQUEST['id'])){
			$groupsdetails=Doctrine_Core::getTable('UlsReportGroups')->find($_REQUEST['id']); 
			$data['groupsdetails']=$groupsdetails;
			$data['groupreports']=Doctrine_Query::Create()->from('UlsReportGroupDetails')->where('report_group_id='.$_REQUEST['id'])->execute();
		}  
		$content = $this->load->view('report/lms_admin_addreports',$data,true);
		$this->render('layouts/adminnew',$content);	
	}
          
	public function addreports_insertfun(){
		if(isset($_POST['report_group_name'])){
			$fieldinsert=array('report_group_name'=>'report_group_name', 'comments'=>'comments','parent_org_id'=>'porg');
			$masters=!empty($_POST['report_group_id'])? Doctrine::getTable('UlsReportGroups')->find($_POST['report_group_id']):new UlsReportGroups();
			foreach($fieldinsert as $key=>$post_val){
				$masters->$key=$_POST[$post_val];
			}
			$masters->save();
			foreach($_POST['reportname'] as $key=>$param){
				echo $param;
				$rr=Doctrine_Core::getTable('UlsReportGroupDetails')->findOneByReportGroupIdAndReportId($_POST['report_group_id'],$param);
				$reportparams=!empty($rr->report_grp_details_id)? Doctrine_Core::getTable('UlsReportGroupDetails')->find($rr->report_grp_details_id):new UlsReportGroupDetails();
				$reportparams->report_group_id=$masters->report_group_id;
				$reportparams->report_id=$param;
				$reportparams->visible=$_POST['visible'][$key];
				$reportparams->save();
			}
			redirect("report/reportgroups");
		}
	}
          
	public function reportgeneration(){
		/*$this->sessionexist();*/
		$data["aboutpage"]=$this->pagedetails("report","reportgeneration");
		$data['reports']=UlsReports::getreportparams();
		$content = $this->load->view('report/lms_admin_reportgeneration',$data,true);
		$this->render('layouts/adminnew',$content);
	}
          
	public function getsearchresults(){
		$data["aboutpage"]=$this->pagedetails("report","reportgeneration"); 
		$typeid=$_REQUEST['typeid'];
		$fromdate=$_REQUEST['fromdate'];
		$todate=$_REQUEST['todate'];
		$username=UlsReports::getusername();

		if($typeid==1){
			$content = $this->load->view('report/lms_report_type1',$data,true);
			$this->render('layouts/adminnew',$content);
		}
		if($typeid==2){
			$content = $this->load->view('report/lms_report_type2',$data,true);
			$this->render('layouts/adminnew',$content);
		}
		if($typeid==3){
			$content = $this->load->view('report/lms_report_type3',$data,true);
			$this->render('layouts/adminnew',$content);
		}
		if($typeid==4){
			$content = $this->load->view('report/lms_report_type4',$data,true);
			$this->render('layouts/adminnew',$content);
		} 
		if($typeid==5){
			$content = $this->load->view('report/lms_report_type5',$data,true);
			$this->render('layouts/adminnew',$content);
		}
		if($typeid==7){ 
			$content = $this->load->view('report/lms_report_type7',$data,true);
			$this->render('layouts/adminnew',$content);	
		}
		if($typeid==8){
			$content = $this->load->view('report/lms_report_type8',$data,true);
			$this->render('layouts/adminnew',$content);
		}
		if($typeid==9){
			$content = $this->load->view('report/lms_report_type9',$data,true);
			$this->render('layouts/adminnew',$content);
		}
		//TNA Report
		if($typeid==10){
			$content = $this->load->view('report/lms_report_type10',$data,true);
			$this->render('layouts/adminnew',$content);
		} 
		//Vendor's Training Report
		if($typeid==11){
			$content = $this->load->view('report/lms_report_type11',$data,true);
			$this->render('layouts/adminnew',$content);
		}
		// Training Calendar Report
		if($typeid==12){
			$content = $this->load->view('report/lms_report_type12',$data,true);
			$this->render('layouts/adminnew',$content);
		}
		if($typeid==13){
			$content = $this->load->view('report/lms_report_type13',$data,true);
			$this->render('layouts/adminnew',$content);
		}
		if($typeid==14){
			$content = $this->load->view('report/lms_report_type14',$data,true);
			$this->render('layouts/adminnew',$content);
		} 
		if($typeid==15){
			$content = $this->load->view('report/lms_report_type15',$data,true);
			$this->render('layouts/adminnew',$content);
		}   
		if($typeid==16){
			$content = $this->load->view('report/lms_report_type16',$data,true);
			$this->render('layouts/adminnew',$content);
		}
		if($typeid==17){
			$content = $this->load->view('report/lms_report_type17',$data,true);
			$this->render('layouts/adminnew',$content);
		}  		
		if($typeid==18){
			redirect("index/monthlypdf?year=".$_REQUEST['param2']."&month=".$_REQUEST['param1']); 
		}
		if($typeid==19){
			$content = $this->load->view('report/lms_report_type19',$data,true);
			$this->render('layouts/adminnew',$content);
		} 
		if($typeid==20){
			$content = $this->load->view('report/lms_report_type20',$data,true);
			$this->render('layouts/adminnew',$content);
		} 
		if($typeid==21){
			$content = $this->load->view('report/lms_report_type21',$data,true);
			$this->render('layouts/adminnew',$content);
		}
		if($typeid==22){
			$content = $this->load->view('report/lms_report_type22',$data,true);
			$this->render('layouts/adminnew',$content);
		} 
		if($typeid==23){
			$content = $this->load->view('report/lms_report_type23',$data,true);
			$this->render('layouts/adminnew',$content);
		}
		if($typeid==24){
			/* $content = $this->load->view('report/lms_report_type24',$data,true);
			$this->render('layouts/report-layout',$content); */
			redirect("index/ass_position_nms?ass_id=".$_REQUEST['param1']."&pos_id=".$_REQUEST['param2']);
		}
		if($typeid==25){
			redirect("index/ass_position_emp?ass_type=".$_REQUEST['param1']."&ass_id=".$_REQUEST['param2']."&pos_id=".$_REQUEST['param3']."&emp_id=".$_REQUEST['param4']);
		}
		if($typeid==26){
			redirect("report/position_booklet?pos_id=".$_REQUEST['param1']."&cri=".$_REQUEST['param2']."&cat=".$_REQUEST['param3']."&int_type=".$_REQUEST['param4']."&total=".$_REQUEST['param5']); 
		}
		if($typeid==27){
			redirect("index/ass_position_details?ass_type=".$_REQUEST['param1']."&pos_type=".$_REQUEST['param2']."&ass_id=".$_REQUEST['param3']."&pos_id=".$_REQUEST['param4']);
		}
		/* if($typeid==28){
			$content = $this->load->view('report/lms_report_type24',$data,true);
			$this->render('layouts/report-layout',$content);
			//redirect("index/ass_position_nms?ass_id=".$_REQUEST['param1']."&pos_id=".$_REQUEST['param2']);
		}
		if($typeid==29){
			redirect("admin/assessment_status_report?typeid=".$typeid."&ass_id=".$_REQUEST['param1']."&ass_type=".$_REQUEST['param2']."&pos_id=".$_REQUEST['param3']);
		} */
		if($typeid==29){
			redirect("index/ass_position_intemp?ass_type=".$_REQUEST['param1']."&ass_id=".$_REQUEST['param2']."&pos_id=".$_REQUEST['param3']."&emp_id=".$_REQUEST['param4']);
		}
		if($typeid==28){
			redirect("admin/assessment_emp_status_report?typeid=".$typeid."&ass_id=".$_REQUEST['param1']."&ass_type=".$_REQUEST['param2']."&pos_id=".$_REQUEST['param3']);
		}
		
		/* if($typeid==32){
			redirect("index/emp_single_report?ass_type=".$_REQUEST['param1']."&ass_id=".$_REQUEST['param2']."&pos_id=".$_REQUEST['param3']."&emp_id=".$_REQUEST['param4']);
		} */
		if($typeid==30){
			redirect("index/assessment_assessor_report?ass_type=".$_REQUEST['param1']."&ass_id=".$_REQUEST['param2']."&assessor_id=".$_REQUEST['param3']);
		}
		/* if($typeid==34){
			redirect("admin/location_emp_status_report?typeid=".$typeid."&loc_id=".$_REQUEST['param1']."&org_id=".$_REQUEST['param2']);
		} 
		if($typeid==35){
			redirect("admin/location_emp_traning_status_report?typeid=".$typeid."&loc_id=".$_REQUEST['param1']."&org_id=".$_REQUEST['param2']."&emp_id=".$_REQUEST['param3']);
		}
		if($typeid==36){
			redirect("index/emp_tna_single_report?ass_type=".$_REQUEST['param1']."&ass_id=".$_REQUEST['param2']."&pos_id=".$_REQUEST['param3']."&emp_id=".$_REQUEST['param4']);
		}*/
		if($typeid==31){
			redirect("admin/assessment_data_report?ass_type=".$_REQUEST['param1']."&ass_id=".$_REQUEST['param2']."&pos_id=".$_REQUEST['param3']);
		}
		if($typeid==32){
			redirect("admin/assessment_employee_final_data_report?ass_type=".$_REQUEST['param1']."&ass_id=".$_REQUEST['param2']."&pos_id=".$_REQUEST['param3']);
		}
		if($typeid==33){
			redirect("admin/assessment_competency_final_report?ass_type=".$_REQUEST['param1']."&ass_id=".$_REQUEST['param2']."&pos_id=".$_REQUEST['param3']);
		}
		if($typeid==34){
			redirect("index/ass_position_emp_cal?ass_type=".$_REQUEST['param1']."&ass_id=".$_REQUEST['param2']."&pos_id=".$_REQUEST['param3']."&emp_id=".$_REQUEST['param4']);
		}
		if($typeid==35){
			redirect("index/emp_single_report?ass_type=".$_REQUEST['param1']."&ass_id=".$_REQUEST['param2']."&pos_id=".$_REQUEST['param3']."&emp_id=".$_REQUEST['param4']);
		}
	}	
	
	public function position_booklet(){
		$this->load->library('tcpdf');
		$this->load->library('pdfgenerator');
		$p_id=isset($_REQUEST['pos_id'])? $_REQUEST['pos_id']:"";
		$t_id=isset($_REQUEST['total'])? $_REQUEST['total']:"";
		$c_id=isset($_REQUEST['cri'])? $_REQUEST['cri']:"";
		$cat_id=isset($_REQUEST['cat'])? $_REQUEST['cat']:"";
		$int_type=isset($_REQUEST['int_type'])? $_REQUEST['int_type']:"";
		$posdetails=UlsPosition::viewposition($p_id);
		$data['posdetails']=$posdetails;
		$data['competencies']=UlsCompetencyPositionRequirements::getcompetencypositionrequirements($p_id);
		
		$data['scale_info']=UlsLevelMasterScale::scale_values_level_two();
		$data['scale_info_four']=UlsLevelMasterScale::scale_values_level_four();
		$data['scale_info_five']=UlsLevelMasterScale::scale_values_level_five();
		$data['category']=UlsCompetencyPositionRequirements::category_comp_details($_REQUEST['pos_id']);
		$data['cri_info']=UlsCompetencyCriticality::criticality_names();
		$data['kras']=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($p_id);
		$data['cat_name']=UlsCategory::get_cat_name($cat_id);
		$data['cat_name_others']=UlsCategory::get_cat_name_report($cat_id);
		
		/* $content = $this->load->view('pdf/position_interview_booklet_old',$data,true);
		$filename =$posdetails['position_name']." - Interview Booklet";
		$this->pdfgenerator->generate($content, $filename, true, 'A4', 'portrait','competency_profiling'); */
		$content = $this->load->view('pdf/position_interview_booklet_new',$data,true);
		$this->render('layouts/ajax-layout',$content);
	}
	
	/* public function position_booklet(){
		$this->load->library('TCPDF');
		$p_id=isset($_REQUEST['pos_id'])? $_REQUEST['pos_id']:"";
		$t_id=isset($_REQUEST['total'])? $_REQUEST['total']:"";
		$c_id=isset($_REQUEST['cri'])? $_REQUEST['cri']:"";
		$cat_id=isset($_REQUEST['cat'])? $_REQUEST['cat']:"";
		$int_type=isset($_REQUEST['int_type'])? $_REQUEST['int_type']:"";
		$posdetails=UlsPosition::viewposition($p_id);
		$data['posdetails']=$posdetails;
		$data['competencies']=UlsCompetencyPositionRequirements::getcompetencypositionrequirements($p_id);
		$data['func_competencies']=UlsCompetencyPositionRequirements::getcompetency_position_requirement_cat($p_id,$cat_id,$c_id);
		$data['kras']=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($p_id);
		$data['cat_name']=UlsCategory::get_cat_name($cat_id);
		$data['cat_name_others']=UlsCategory::get_cat_name_report($cat_id);
		$content = $this->load->view('pdf/position_interview_booklet',$data,true);
		$this->render('layouts/ajax-layout',$content);
	} */
	
	public function getpdfdata(){
		$data=$_REQUEST['data'];
		$content = ob_get_clean();
		require(LIB_PATH.DS."html2pdf.class.php");
		try{
			$html2pdf = new HTML2PDF('P', array(215.9,279), 'fr', true, 'UTF-8', array(0, 0, 0, 0));
			$html2pdf->pdf->SetDisplayMode("fullpage");
			$html2pdf->writeHTML($content, isset($_GET["vuehtml"]));

			$html2pdf->createIndex("Content of the Report",0, 0, false, true, 2);
			$html2pdf->Output("360degreesfeedback_".ucwords(strtolower($userdname->user_name)).".pdf");
		}
		catch(HTML2PDF_exception $e) {
			echo $e;
			exit;
		}
	}

    public function getallbus(){
		$locid=$_REQUEST['id'];
		$typeid=$_REQUEST['typeid'];
        if($typeid==13) { 
		echo "<select id='org_name' name='org_name' class='col-xs-12 col-sm-6'><option value=''>Select</option>";
		$buids=UlsReports::getorgsbylocation($locid);
		foreach($buids as $buid){ 
		echo "<option value=".$buid['organization_id'].">".$buid['org_name']."</option>";
		}
	
		echo  "</select>";
		}
	}
	public function getalleventsbyprog(){
		$progid=$_REQUEST['id'];
		$typeid=$_REQUEST['typeid'];
		$require=($typeid==9 || $typeid==20)?' validate[required] ':'';
		$onchange='geteventdates();';
		if($typeid==7 || $typeid==4) { $onchange.= 'getsessions();';} else { echo""; }
		echo "<select id='evename' name='evename' onchange='$onchange' class=' $require col-xs-12 col-sm-6'><option value=''>Select</option>";
		$events=UlsEventCreation::get_events($progid); 
		foreach($events as $event){ 
		echo "<option value=".$event->eid.">".$event->ename."</option>";
		}
		echo  "</select>";
	}
	   
	public function getteststatus(){
		$testtype=$_REQUEST['id'];
		if($testtype!=''){
			if($testtype=='FEED'){
				$admvals=Doctrine_Query::Create()->from('UlsAdminValues')->where('master_code like "TEST_STATUS" and value_code="COM"')->execute();
				$data="<option value=''>Select</option>";
				foreach($admvals as $admval){
					$data.= "<option value='".$admval['value_code']."'>".$admval['value_name']."</option>";		  
				}
			} 
			else {
				$admvals=Doctrine_Query::Create()->from('UlsAdminValues')->where('master_code like "TEST_STATUS" and (value_code="PAS" || value_code="FAI" )')->execute();
				$data="<option value=''>Select</option>";
				foreach($admvals as $admval){
					$data.= "<option value='".$admval['value_code']."'>".$admval['value_name']."</option>";		  
				}
			} 
		}
		else {
			$data="<option value=''>Select</option>";		  
		}
		echo $data;
	}
  
    public function getparameters(){
        $report_id=$_REQUEST['rep'];
		if(!empty($report_id)){
            $parms=UlsReports::getreportparameters($report_id); 
            $data['reportparams']=UlsReports::getreportparameters($report_id); 
            $values='';
            $sds=0;
			///print_r($parms);
            foreach($parms as $parm){
				$typeid=$parm['report_type_id']; 
                $values=empty($values)? $parm['code'] : $values.'***'.$parm['code']; 
				//$typeid==17 || 
                $require=($typeid==4 || $typeid==5 || $typeid==7 || $typeid==9 || $typeid==13 || $typeid==16 || $typeid==14 || $typeid==22 || $typeid==33)?'<sup><font size="2" color="#FF0000">*</font></sup>':'';
				    if($typeid!=17){
						if($parm['code']=='PROG_NAME' || $parm['code']=='TEST_STATUS' ||  $parm['code']=='EVAL_TYPE' || $parm['code']=='SESS_NAME' || $parm['code']=='DEPT' || $parm['code']=='ORG_NAME'|| $parm['code']=='EVE_NAME' || $parm['code']=='TRAINER_NAME' || $parm['code']=='LOCATION_ZONES' || $parm['code']=='MONTH' || $parm['code']=='ASSESSOR_NAME'){
							$require='';
						}
					}
					else{
						//$parm['code']=='EVE_NAME' || 
						if($parm['code']=='TEST_STATUS' ||  $parm['code']=='EVAL_TYPE' || $parm['code']=='SESS_NAME' || $parm['code']=='DEPT' || $parm['code']=='ORG_NAME'|| $parm['code']=='TRAINER_NAME'){
							$require='';
						}
					}
				    $required='';
					// $onchangesession=($typeid==7 || $typeid==4) ? 'onchange="getsessions()"' : '';
					echo  "<div class='space-4'></div><div class='form-group'>
				            <input type='hidden' name='typeid' id='typeid' value='$typeid' />
						    <label class='control-label mb-10 col-sm-3'>".$parm['pname']."".$require."</label>
						    <div class='col-xs-12 col-sm-8'>
							    <div class='clearfix'>";
									if($parm['code']=='EVALU_TYPE' and $typeid==4){
										echo "<select id='evaluation_type' name='evaluation_type' class='validate[required] col-xs-12 col-sm-8'><option value=''>Select</option>";
										$evaluationtype=UlsReports::get_months("ASSESSMENT_TYPE");
										foreach($evaluationtype as $evaluationtypes){
										 echo   "<option value=".$evaluationtypes['code'].">".$evaluationtypes['name']."</option>";
										}
										echo   "</select>";
									}
									if($parm['code']=='Bul_NAME'){ 
										echo  "<select id='bul_name' name='bul_name' class='$required col-xs-12 col-sm-8'><option value=''>Select</option>";
										 $bulname=UlsReports::getbulname();
										foreach($bulname as $bulnames){
										 echo   "<option value=".$bulnames['id'].">".$bulnames['name']."".$require."</option>";
										 }
										echo   "</select>";
									}
									if($parm['code']=='TNA_YEAR'){ 
										echo  "<select id='tnayear' name='tnayear' class='$required col-xs-12 col-sm-8'><option value=''>Select</option>";
										 $tnayear=UlsReports::gettnayears();
										foreach($tnayear as $tnayears){
										 echo   "<option value=".$tnayears['id'].">".$tnayears['name']."".$require."</option>";
										 }
										echo   "</select>";
									}
									if($parm['code']=='MNGR'){ 
										echo  "<select id='tnamanager' name='tnamanager' class='$required col-xs-12 col-sm-8'><option value=''>Select</option>";
										 $tnamanagers=UlsReports::gettnamanagers();
										foreach($tnamanagers as $tnamanager){
										 echo   "<option value=".$tnamanager['id'].">".$tnamanager['name']."".$require."</option>";
										 }
										echo   "</select>";
									}   
									if($parm['code']=='TRAINING_SRC'){ 
										echo  "<select id='transource' name='transource' class='$required col-xs-12 col-sm-8'><option value=''>Select</option>";
										 $tnamanagers=UlsReports::gettnasources();
										foreach($tnamanagers as $tnamanager){
										 echo   "<option value=".$tnamanager['id'].">".$tnamanager['name']."".$require."</option>";
										 }
										echo   "</select>";
									}
							        if($parm['code']=='PROG_NAME'){ 
										//$typeid==17 || 
							            if($typeid==21){ $required="validate[required]"; }if($typeid==7){ $required="";}
                                            echo  "<select id='programs' name='programs' onchange='getevents()' class='$required col-xs-12 col-sm-8'><option value=''>Select</option>";
                                            $programs=UlsReports::getprograms();
                                            foreach($programs as $program){
                                                echo   "<option value=".$program['id'].">".$program['name']."</option>";
                                            }
                                        echo   "</select>";
                                    }
							        if($parm['code']=='EVE_NAME' and  ($typeid!=5 )){ $sds=1; 
										$onchangesession='geteventdates();';
							            if($typeid==9 || $typeid==19 || $typeid==20){ 
										    $required="validate[required]";       
											/* $onchangesession="onchange='geteventdates()'" */;  }
							            else if($typeid==7 || $typeid==4) { $onchangesession.= 'getsessions()';}
							            else {  /* $onchangesession= ""; */ }   
							            echo " <div id='div_events'><select id='evename' name='evename' onchange='$onchangesession' class='$required col-xs-12 col-sm-8'><option value=''>Select</option>";
                                        $events=UlsReports::getevents();
										foreach($events as $event){
										  echo  "<option value=".$event->event_id.">".$event->event_name."</option>";
										}
                                        echo  "</select></div>";
                                    }
						            if($parm['code']=='SESS_NAME' and ($typeid==7 || $typeid==4)){ 
						                echo "<select id='session_name' name='session_name' class='col-xs-12 col-sm-8'><option value=''>Select</option></select>";
                             
                                    }
					                if($parm['code']=='SESS_NAME' and $typeid==5 ){ echo "<select id='evename' name='evename' class='validate[required] col-xs-12 col-sm-8'><option value=''>Select</option>";
                                        $events=UlsReports::getevents();
										foreach($events as $event){
										  echo  "<option value=".$event->event_id.">".$event->event_name."</option>";
										}
                                        echo  "</select>";
                                    }		
                            
                                    if($parm['code']=='ORG_NAME' and $typeid!=13 ){ echo "<div id='orgs'><select id='org_name' name='org_name' class='col-xs-12 col-sm-8'><option value=''>Select</option>";
                                       $orgs=UlsReports::getorgs();
										  foreach($orgs as $org){
											echo  "<option value=".$org['organization_id'].">".$org['org_name']."</option>";
										  }
                                        echo  "</select></div>";
                                    }  
									if($parm['code']=='ORG_NAME' and $typeid==13 ){ echo "<div id='orgs'><select id='org_name' name='org_name' class='col-xs-12 col-sm-8'><option value=''>Select</option>";
                                       
                                        echo  "</select></div>";
                                    }  
                                    if($parm['code']=='SYSTEM_ENROLLMENT_STATUS'){ 
 									    echo "<select id='enronlstatus' name='enronlstatus' class='col-xs-12 col-sm-8' > <option value=''>Select</option>";
                                        $enrol_status=UlsReports::getenrollmentstatus($parm['code']);
										foreach($enrol_status as $enrol_statuss){
										   echo  "<option value=".$enrol_statuss['value_code'].">".$enrol_statuss['value_name']."</option>";
										}
                                        echo  "</select>";
                                    } 
                                    if($parm['code']=='CAT_NAME'){  
									    echo "<select id='cat_name' name='cat_name' class='col-xs-12 col-sm-8' > <option value=''>Select</option>";
                                        $enrol_status=UlsReports::getcategories();
										foreach($enrol_status as $enrol_statuss){
										  echo  "<option value=".$enrol_statuss['id'].">".$enrol_statuss['name']."</option>";
										}
                                 echo  "</select>";
                                    }   
                                    if($parm['code']=='RESOURCE_BOOKING_STATUS'){  echo "<select id='resourcestatus' name='resourcestatus' class='col-xs-12 col-sm-8' > <option value=''>Select</option>";
									   // $enrol_status=UlsReports::getenrollmentstatus($parm['code']);
										$enrol_status=UlsReports::getenrollmentstatus('EVENT_STATUS');
									   foreach($enrol_status as $enrol_statuss){
										 echo  "<option value=".$enrol_statuss['value_code'].">".$enrol_statuss['value_name']."</option>";
									   }
                                       echo  "</select>";
                                    } 
						   
									if($parm['code']=='TEST_STATUS'){  echo "<select id='test_status' name='test_status' class='col-xs-12 col-sm-8' > <option value=''>Select</option>";
										   // $enrol_status=UlsReports::getenrollmentstatus($parm['code']);
										   /*  $test_status=UlsReports::getteststatus('TEST_STATUS');
										   foreach($test_status as $test_statuss){
											 echo  "<option value=".$test_statuss['value_code'].">".$test_statuss['value_name']."</option>";
										   } */
										 echo  "</select>";
									} 
				                    if($parm['code']=='EVAL_TYPE'){  echo "<select id='test_type' name='test_type' onchange='getteststatus()' class='col-xs-12 col-sm-8' > <option value=''>Select</option>";
                               // $enrol_status=UlsReports::getenrollmentstatus($parm['code']);
										$enrol_status=UlsReports::getenrollmentstatus('EVAL_TYPE');
										   foreach($enrol_status as $enrol_statuss){
											 echo  "<option value=".$enrol_statuss['value_code'].">".$enrol_statuss['value_name']."</option>";
										   }
                                         echo  "</select>";
                                    } 
				                    if($parm['code']=='EMP_NUM'){ if($typeid==7){$required="validate[required]";}
                                        echo "<input type='text' id='empnumber' name='empnumber' class='$required col-xs-12 col-sm-8' />";       
                                    }
									/// Vendor Report Parameters.////
									if($parm['code']=='RES_CAT'){  
										echo "<select id='resourcecategory' name='resourcecategory' class='col-xs-12 col-sm-8' > <option value=''>Select</option>";
										$res_cat=UlsReports::getenrollmentstatus('BUDGET_ITEM');
											foreach($res_cat as $res_cat){
												echo  "<option value=".$res_cat['value_code'].">".$res_cat['value_name']."</option>";
											}
												echo  "</select>";
									}
									if($parm['code']=='RES_TYPE'){  
										 echo "<select id='res_type' name='res_type'  class='col-xs-12 col-sm-8' > <option value=''>Select</option>";
									    // $enrol_status=UlsReports::getenrollmentstatus($parm['code']);
										// $enrol_status=UlsReports::getenrollmentstatus('BUDGET_ITEM');
										// foreach($enrol_status as $enrol_statuss){
										// echo  "<option value=".$enrol_statuss['value_code'].">".$enrol_statuss['value_name']."</option>";
										// }
										echo "<option value='I'>Internal</ value='E'><option>External</option>";
										 echo  "</select>";
									}
									
				                    if($parm['code']=='VENDOR_ORG'){  echo "<select id='vendororg' name='vendororg' class='col-xs-12 col-sm-8' > <option value=''>Select</option>";
                                        $enrol_status=UlsReports::getvendororgs();
									    foreach($enrol_status as $enrol_statuss){
										 echo  "<option value=".$enrol_statuss['organization_id'].">".$enrol_statuss['org_name']."</option>";
									    }
                                        echo  "</select>";
                                    }
				                    if($parm['code']=='VENDOR_NAME'){  echo "<select id='vendorname' name='vendorname' class='col-xs-12 col-sm-8' > <option value=''>Select</option>";
									  $enrol_status=UlsReports::getvendorname();
										   foreach($enrol_status as $enrol_statuss){
											 echo  "<option value=".$enrol_statuss['resource_def_id']."-".$enrol_statuss['structure_name'].">".$enrol_statuss['structure_name']."&nbsp;-&nbsp;".$enrol_statuss['column2']."</option>";
										   }
										 echo  "</select>";
                                    }
									if($parm['code']=='CAL_NAME'){
										echo "<select id='calendar_id' name='calendar_id' class='validate[required] col-xs-12 col-sm-8'>
											<option value=''> Select</option>";
											$calendar=Ulsreports::calendarnames();
											foreach($calendar as $cal){
												echo "<option value=".$cal['calendar_id'].">".$cal['calendar_name']."</option>";
											}
										echo "</select>";
                                    }
									if($parm['code']=='LOCATION_ZONES'){
										echo "<select id='zone_id' name='zone_id' class='col-xs-12 col-sm-8'>
											<option value=''> Select</option>";
											$month=Ulsreports::get_months("LOCATION_ZONES");
											foreach($month as $months){
												echo "<option value=".$months['code'].">".$months['name']."</option>";
											}
										echo "</select>";
                                    }
									/// Knowledge Bulletin Zone.//////
									if($parm['code']=='BUL_ZONE'){
										echo "<select id='zone_id' name='zone_id' class='col-xs-12 col-sm-8'>
											<option value=''> Select</option>";
											$month=Ulsreports::get_months("LOCATION_ZONES");
											foreach($month as $months){
												echo "<option value=".$months['code'].">".$months['name']."</option>";
											}
										echo "</select>";
                                    }
									/// Knowledge BUlletin location Report Parameters.//////
									if($parm['code']=='BUL_LOCATION'){
										echo "<select id='proglocation' name='proglocation' class='col-xs-12 col-sm-8' > <option value=''>Select</option>";
										$enrol_status=UlsReports::getprogramloaction();
											foreach($enrol_status as $enrol_statuss){
												 echo  "<option value=".$enrol_statuss['location_id'].">".$enrol_statuss['location_name']."</option>";
											}
											 echo  "</select>";
                                    } 
									/// Training Calendar Report Parameters.//////
									if($parm['code']=='PROG_LOCATION'){
									    if($typeid==13){ $required="validate[required]"; $onchanges="get_bus()";}	else{ $onchanges='';}		  
								            echo "<select id='proglocation' name='proglocation' onchange='$onchanges' class='$required col-xs-12 col-sm-8' > <option value=''>Select</option>";
											$enrol_status=UlsReports::getprogramloaction();
												foreach($enrol_status as $enrol_statuss){
													 echo  "<option value=".$enrol_statuss['location_id'].">".$enrol_statuss['location_name']."</option>";
												}
												 echo  "</select>";
                                    } 
									/// Employee Trained Vs Un Trained Report Parameters.////
									if($parm['code']=='DEPT'){
											echo "<select id='department' name='department' class='col-xs-12 col-sm-8' > <option value=''>Select</option>";
												$orgs=UlsReports::getdepartments();
												foreach($orgs as $org){
													echo  "<option value=".$org['organization_id'].">".$org['org_name']."</option>";
												}
												 echo  "</select>";
									}
									if($parm['code']=='LEVEL'){
										if($typeid==13){ $required="validate[required]"; }
										echo "<select id='level' name='level' class='$required col-xs-12 col-sm-8' > <option value=''>Select</option>";
										   $levels=UlsReports::getlevel();
											foreach($levels as $level){
												echo  "<option value=".$level['grade_id'].">".$level['grade_name']."</option>";
											}
											echo  "</select>";
									}
									//Program Feedback Report Parametes
									if($parm['code']=='FEEDBACK_TEMP'){
										echo "<select id='feedback' name='feedback' class='validate[required] col-xs-12 col-sm-8' > <option value=''>Select</option>";
										$templates=UlsReports::getfeedbacktemplates();
											foreach($templates as $templates1){
												echo  "<option value=".$templates1['test_id'].">".$templates1['test_name']."</option>";
											}
											echo  "</select>";
									}						
									//Budget Report Parametes
									if($parm['code']=='BUDGET_NAME'){
										echo "<select id='budgetname' name='budgetname' class='validate[required] col-xs-12 col-sm-8' onchange='getbudperiodnames()' > <option value=''>Select</option>";
										$budgets=UlsReports::getbudgetnames();
										foreach($budgets as $budgets1){
											echo  "<option value=".$budgets1['budget_id'].">".$budgets1['budget_name']."</option>";
										}
										echo  "</select>";
									}
									if($parm['code']=='BUDGET_PERIOD'){
										echo "<select id='budget' name='budget' class='col-xs-12 col-sm-8' > <option value=''>Select</option>";
										echo  "</select>";
									}
									//Training Program report parameters validate[required] 
									if($parm['code']=='MONTH'){
										echo "<select id='month_id' name='month_id' class='col-xs-12 col-sm-8'>
												<option value=''> Select</option>";
												$month=Ulsreports::get_months("TRNG_BUDGET_MONTHS");
													foreach($month as $months)
													{
														echo "<option value=".$months['code'].">".$months['name']."</option>";
													}
										echo "</select>";
									}
									if($parm['code']=='YEAR'){
										if($typeid==16){ $required="validate[required]"; }
										echo "<select id='year_id' name='year_id' class='$required col-xs-12 col-sm-8'>
												<option value=''> Select Year</option>";
												$year=date("Y");
													for($i=2013;$i<=$year; $i++){
														echo "<option value=".$i.">".$i."</option>";
													}
										echo "</select>";
									}
									 //Trainer Feedback Report Parameter	
									if($parm['code']=='TRAINER_NAME')
									{
										echo "<select id='tra_name' name='tra_name' class='chosen-select col-xs-12 col-sm-8'>
												<option value=''> Select</option>";
												$resource=Ulsreports::get_trainers();
													foreach($resource as $resource)
													{
														$typ=($resource['res_type']=='I')?"Internal":"External";
														
														echo "<option value=".$resource['res_trainer_id'].">".$typ." - ".$resource['tra_name']."</option>";
														
													}
										echo "</select>";
									}
									if($parm['code']=='ASS_TYPE'){
							            if($typeid==25 || $typeid==27 || $typeid==30 || $typeid==31 || $typeid==32 || $typeid==33 || $typeid==34 || $typeid==35 || $typeid==36 || $typeid==28){ $required="validate[required]"; }
                                            echo  "<select id='ass_type' name='ass_type'  class='$required form-control m-b'  data-prompt-position='topLeft'><option value=''>Select</option>";
											$ass_type="ASS_TYPE";
											$asstype=UlsAdminMaster::get_value_names($ass_type);
                                            foreach($asstype as $asstypes){
                                                echo   "<option value=".$asstypes['code'].">".$asstypes['name']."</option>";
                                            }
                                        echo   "</select>";
                                    }
									if($parm['code']=='POS_TYPE'){
							            if($typeid==27){ $required="validate[required]"; }
                                            echo  "<select id='pos_type' name='pos_type'  class='$required form-control m-b' onchange='open_ass_type();' data-prompt-position='topLeft'><option value=''>Select</option>";
											$ass_type="POSTYPE";
											$postype=UlsAdminMaster::get_value_names($ass_type);
                                            foreach($postype as $postypes){
                                                echo   "<option value=".$postypes['code'].">".$postypes['name']."</option>";
                                            }
                                        echo   "</select>";
                                    }
									if($parm['code']=='ASSESS_NAME'){
							            if($typeid==24 || $typeid==25 || $typeid==27 || $typeid==28 || $typeid==30 || $typeid==31 || $typeid==32 || $typeid==33 || $typeid==34 || $typeid==35 || $typeid==36){ $required="validate[required]"; }
										if($typeid==30){
											$onchange="open_ass_assessor";
										}
										else{
											$onchange="open_ass_position";
										}
                                            echo  "<select id='assess_name' name='assess_name'  class='$required form-control m-b' onchange='".$onchange."();' data-prompt-position='topLeft'><option value=''>Select</option>";
											$ass_type=($typeid==24)?'NMS':'MS';
											if($typeid==35){
												$programs=UlsReports::get_re_assessname($ass_type);
											}
											else{
												$programs=UlsReports::getassessname($ass_type);
											}
											
                                            foreach($programs as $program){
                                                echo   "<option value=".$program['id'].">".$program['name']."</option>";
                                            }
                                        echo   "</select>";
                                    }
									
									
									if($parm['code']=='POS_NAME'){
										//$typeid==28 || 
							            if($typeid==24 || $typeid==25 || $typeid==26 || $typeid==27 || $typeid==30 || $typeid==36 || $typeid==33 || $typeid==34 || $typeid==35){ $required="validate[required]"; }
										if($typeid==25 || $typeid==29 || $typeid==31 || $typeid==32 || $typeid==34 || $typeid==35 || $typeid==36){ $on_changes="onchange='open_ass_position_emp()'"; }else{ $on_changes="";}
										
                                            echo  "<select id='pos_name' name='pos_name' $on_changes  class='$required form-control m-b' data-prompt-position='topLeft'>";
											if($typeid==26){
												echo  "<option value=''>Select</option>";
												$positions=UlsPosition::pos_orgbased_all();
												foreach($positions as $position){
													echo   "<option value=".$position['position_id'].">".$position['position_name']."</option>";
												}
											}
										echo   "</select>";
                                    }
									
									if($parm['code']=='ASSESSOR_NAME'){
							            if($typeid==30){ //$required="validate[required]"; 
										}
                                            echo  "<select id='assessor_id' name='assessor_id' class='$required form-control m-b' data-prompt-position='topLeft'>";
											echo  "<option value=''>Select</option>";
										echo   "</select>";
                                    }
									
									if($parm['code']=='EMP_NAME'){
										if($typeid==25 || $typeid==31 || $typeid==32 || $typeid==34 || $typeid==36){ $required="validate[required]"; }
										echo  "<select id='emp_name' name='emp_name'  class='$required form-control m-b' data-prompt-position='topLeft'>
										</select>";
									}
									//Position Interview Booklet
									if($parm['code']=='CRI_POS'){
										if($typeid==26){ $required="validate[required]"; }
										$cri_code_single=UlsCompetencyCriticality::criticality_group_name_cri();
										$cri_code=UlsCompetencyCriticality::criticality_group_names();
										echo  "<select id='cri_position' name='cri_position'  class='$required form-control m-b' data-prompt-position='topLeft'>
											<option value=''>Select</option>
											<option value='".$cri_code_single['code_s']."'>Criticality</option>
											<option value='".$cri_code['code']."'>All</option>
										</select>";
									}
									if($parm['code']=='TOT_QUESTION'){
										if($typeid==26){ $required="validate[required]"; }
										echo  "<input type='text' name='total_question' id='total_question' class='$required form-control' data-prompt-position='topLeft'>";
									}
									//Position Interview Booklet
									
									if($parm['code']=='CAT_POS'){
										if($typeid==26){ $required="validate[required]"; }
										$category=UlsCategory::learning_corner();
										echo  "<select id='cat_position' name='cat_position'  class='$required form-control m-b' data-prompt-position='topLeft'>
											<option value=''>Select</option>";
											foreach($category as $categorys){
												echo  "<option value='".$categorys['category_id']."'>".$categorys['name']."</option>";
											}
										echo  "</select>";
									}
									if($parm['code']=='INT_TYPE'){
										if($typeid==26){ $required="validate[required]"; }
										
										echo  "<select id='int_type' name='int_type'  class='$required form-control m-b' data-prompt-position='topLeft'>
											<option value=''>Select</option>
											<option value='1'>Interview Question</option>
											<option value='2'>Interview and CBT Question</option>";
										echo  "</select>";
									}
									//Question Analysis Report Parameter
									if($parm['code']=='TEST_NAME')
									{
										echo "<select id='test_name' name='test_name' class='col-xs-12 col-sm-8'>
												<option value=''> Select</option>";
												$tests=Ulsreports::get_tests();
													foreach($tests as $test)
													{
													   echo "<option value=".$test['test_id'].">".$test['test_name']."</option>";
													}
										echo "</select>";
									}
									//Location Employee Report
									if($parm['code']=='LOC_NAME'){
										if($typeid==34){ $required="validate[required]"; }
										$loc_names=UlsMenu::callpdo("SELECT b.`location_id`,b.`location_name` FROM `uls_assessment_employees` a 
										left join(SELECT `location_id`,`location_name` FROM `uls_location`) b on a.location_id=b.location_id
										WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." group by a.location_id");
										echo  "<select id='loc_name' name='loc_name'  class='$required form-control m-b' data-prompt-position='topLeft'>
											<option value=''>Select</option>";
											foreach($loc_names as $loc_name)
											{
											   echo "<option value=".$loc_name['location_id'].">".$loc_name['location_name']."</option>";
											}
										echo  "</select>";
									}
									if($parm['code']=='DEP_NAME'){
										
										$org_names=UlsMenu::callpdo("SELECT b.`organization_id`,b.`org_name` FROM `uls_assessment_employees` a 
										left join(SELECT `organization_id`,`org_name` FROM `uls_organization_master`) b on a.org_id=b.organization_id
										WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." group by a.org_id");
										echo  "<select id='org_name' name='org_name'  class='form-control m-b' data-prompt-position='topLeft'>
											<option value=''>Select</option>";
											foreach($org_names as $org_name)
											{
											   echo "<option value=".$org_name['organization_id'].">".$org_name['org_name']."</option>";
											}
										echo  "</select>";
									}
									//Employee Training Area Report
									if($parm['code']=='TRA_LOC_NAME'){
										if($typeid==35){ $required="validate[required]"; }
										$loc_names=UlsMenu::callpdo("SELECT b.`location_id`,b.`location_name` FROM `uls_assessment_employee_dev_rating` a 
										left join(SELECT `location_id`,`location_name` FROM `uls_location`) b on a.location_id=b.location_id
										WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." group by a.location_id");
										echo  "<select id='tra_loc_name' name='tra_loc_name'  class='$required form-control m-b' data-prompt-position='topLeft'>
											<option value=''>Select</option>";
											foreach($loc_names as $loc_name)
											{
											   echo "<option value=".$loc_name['location_id'].">".$loc_name['location_name']."</option>";
											}
										echo  "</select>";
									}
									if($parm['code']=='TRA_DEP_NAME'){
										
										$org_names=UlsMenu::callpdo("SELECT b.`organization_id`,b.`org_name` FROM `uls_assessment_employee_dev_rating` a 
										left join(SELECT `organization_id`,`org_name` FROM `uls_organization_master`) b on a.org_id=b.organization_id
										WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." group by a.org_id");
										echo  "<select id='tra_org_name' name='tra_org_name'  class='form-control m-b' data-prompt-position='topLeft'>
											<option value=''>Select</option>";
											foreach($org_names as $org_name)
											{
											   echo "<option value=".$org_name['organization_id'].">".$org_name['org_name']."</option>";
											}
										echo  "</select>";
									}
									if($parm['code']=='TRA_EMP_NAME'){
										
										$org_names=UlsMenu::callpdo("SELECT b.`employee_id`,b.`employee_number`,b.`full_name` FROM `uls_assessment_employee_dev_rating` a 
										left join(SELECT `employee_id`,`employee_number`,`full_name` FROM `employee_data` ) b on a.employee_id=b.employee_id
										WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." group by a.employee_id");
										echo  "<select id='tra_emp_name' name='tra_emp_name'  class='form-control m-b' data-prompt-position='topLeft'>
											<option value=''>Select</option>";
											foreach($org_names as $org_name)
											{
											   echo "<option value=".$org_name['employee_id'].">".$org_name['full_name']."</option>";
											}
										echo  "</select>";
									}
						echo"   </div>
						    </div>
						</div>";
                        echo  "</td></tr>";
			}
		    if($typeid==1 || $typeid==2 || $typeid==3 || $typeid==4 || $typeid==5 || $typeid==7 || $typeid==8 || $typeid==9 || $typeid==11 || $typeid==12 || $typeid==13 || $typeid==14 || $typeid==15 || $typeid==19 || $typeid==21 || $typeid==17){
				$req=($typeid==17)?"":"required";
				$req_q=($typeid==17)?"":"<sup><font color='#FF0000'>*</font></sup>";
				    echo "<div id='datesdiv'><div class='form-group'>
							<label class='control-label mb-10 col-sm-3'>From Date ".$req_q."</label>
							<div class='col-xs-12 col-sm-6'>
								<div class='input-large'>
									<div class='input-group'>
										<input type='text' id='startdate' onfocus='date_funct(this.id)' name='startdate'  data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy' class='validate[".$req.",custom[date2]] datepicker input-large date-picker' />
										<span class='input-group-addon'>
											<i class='ace-icon fa fa-calendar'></i>
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class='space-2'></div>	
					<div class='form-group'>
							<label class='control-label mb-10 col-sm-3'>To Date ".$req_q."</label>
							<div class='col-xs-12 col-sm-6'>
								<div class='input-large'>
									<div class='input-group'>
										<input type='text' id='enddate' name='enddate' data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy'  class='validate[".$req.",custom[date2],future[#startdate]] datepicker input-large date-picker' onfocus='date_funct(this.id)' />
										<span class='input-group-addon'>
											<i class='ace-icon fa fa-calendar'></i>
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class='space-2'></div>	</div>";
            }
			else if($typeid==10){ 
    			 echo "<input type='hidden' id='startdate' onfocus='date_funct(this.id)' name='startdate'  data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy' class='validate[required,custom[date2]] datepicker input-large date-picker' /> <input type='hidden' id='enddate' name='enddate' data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy'  class='validate[required,custom[date2],future[#startdate]] datepicker input-large date-picker' onfocus='date_funct(this.id)' />";
			}	
            else if($typeid==16 || $typeid==17 || $typeid==18 || $typeid==20 || $typeid==22 || $typeid==24){ 
    			echo "<input type='hidden' id='startdate' name='startdate'  data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy' class='validate[required,custom[date2]] datepicker input-large date-picker' value='NULL'/> <input type='hidden' id='enddate' name='enddate' data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy'  class='validate[required,custom[date2],future[#startdate]] datepicker input-large date-picker' value='NULL'/>";
			}	   					  
            echo "<hr class='light-grey-hr'>
			<div class='form-group'>
				<div class='col-sm-offset-9'> 
					<a id='report_a' role='button'  onclick='getsearchdata()' > 
					<input type='button' class='btn btn-sm btn-success'  name='formsubmit' id='formsubmit' value='Generate' /></a>
				</div>
			</div>";
            echo " <input type='hidden' name='evee' id='evee' value='".$sds."'  /><input type='hidden' name='paramscode' value='".$values."' id='paramscode' /> <input type='hidden' name='type_id' id='type_id' value='".$typeid."' />";
		} else   { echo ""; }
           
    }
	
	public function get_assessment_type(){
		$id=$_REQUEST['ass_type'];
		$pos_id=$_REQUEST['pos_type'];
		$data="";
		$asstype=UlsAssessmentDefinition::getassessment_type($id,$pos_id);
		$data.="<option value=''>Select</option>";
		foreach($asstype as $asstypes){
			$data.="<option value='".$asstypes['assessment_id']."'>".$asstypes['assessment_name']."</option>";
		}
		echo $data;
		
	}
	
	public function get_selfassessment_position(){
		$id=$_REQUEST['assid'];
		$data="";
		$positions=UlsAssessmentPosition::getassessmentpositions($id);
		$data.="<option value=''>Select</option>";
		foreach($positions as $position){
			$data.="<option value='".$position['position_id']."'>".$position['position_name']."</option>";
		}
		echo $data;
		
	}
	
	public function get_assessment_position(){
		$id=$_REQUEST['assid'];
		$data="";
		$positions=UlsAssessmentPosition::getassessmentpositions($id);
		$data.="<option value=''>Select</option>";
		foreach($positions as $position){
			$data.="<option value='".$position['position_id']."'>".$position['position_name']."</option>";
		}
		echo $data;
		
	}
	
	public function get_assessment_position_emp(){
		$id=$_REQUEST['assid'];
		$pid=$_REQUEST['posid'];
		$ass_type=$_REQUEST['ass_type'];
		$data="";
		$data.="<option value=''>Select</option>";
		if($ass_type='SELF'){
			$positions=UlsSelfAssessmentEmployees::getselfassessmentemployees($id);
			
			foreach($positions as $position){
				$data.="<option value='".$position['employee_id']."'>".$position['employee_number']."-".$position['full_name']."</option>";
			}
		}
		if($ass_type='ASS'){
			$positions=UlsAssessmentEmployees::getassessmentemployees_position_report($id,$pid);
			
			foreach($positions as $position){
				$data.="<option value='".$position['employee_id']."'>".$position['employee_number']."-".$position['full_name']."</option>";
			}
		}
		
		echo $data;
		
	}
	
	public function geteventdates(){
		$eid=$_REQUEST['id'];
		if(!empty($eid)){
			$edates=Doctrine_Core::getTable('UlsEventCreation')->findOneByEvent_id($eid);
			echo "<div class='form-group'>
					<label class='control-label col-xs-12 col-sm-4 no-padding-right' for='email'>From Date<sup><font color='#FF0000'>*</font></sup></label>
					<div class='col-xs-12 col-sm-6'>
						<div class='input-large'>
							<div class='input-group'>
								<input type='text' id='startdate'  name='startdate' value='".date('d-m-Y',strtotime($edates->event_start_date))."' readonly='readonly' data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy' class='validate[required,custom[date2]] datepicker input-large date-picker' />
								<span class='input-group-addon'>
									<i class='ace-icon fa fa-calendar'></i>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class='space-2'></div>	
				<div class='form-group'>
					<label class='control-label col-xs-12 col-sm-4 no-padding-right' for='email'>To Date <sup><font color='#FF0000'>*</font></sup></label>
					<div class='col-xs-12 col-sm-6'>
						<div class='input-large'>
							<div class='input-group'>
								<input type='text' id='enddate' name='enddate' data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy'  readonly='readonly' class='validate[required,custom[date2],future[#startdate]] datepicker input-large date-picker' value='".date('d-m-Y',strtotime($edates->event_end_date))."' />
								<span class='input-group-addon'>
									<i class='ace-icon fa fa-calendar'></i>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class='space-2'></div>	";
		}
		else {
			echo "<div id='datesdiv'><div class='form-group'>
						<label class='control-label col-xs-12 col-sm-4 no-padding-right' for='email'>From Date<sup><font color='#FF0000'>*</font></sup></label>
						<div class='col-xs-12 col-sm-6'>
							<div class='input-large'>
								<div class='input-group'>
									<input type='text' id='startdate' onfocus='date_funct(this.id)' name='startdate'  data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy' class='validate[required,custom[date2]] datepicker input-large date-picker' />
									<span class='input-group-addon'>
										<i class='ace-icon fa fa-calendar'></i>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class='space-2'></div>	
					<div class='form-group'>
						<label class='control-label col-xs-12 col-sm-4 no-padding-right' for='email'>To Date <sup><font color='#FF0000'>*</font></sup></label>
						<div class='col-xs-12 col-sm-6'>
							<div class='input-large'>
								<div class='input-group'>
									<input type='text' id='enddate' name='enddate' data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy'  class='validate[required,custom[date2],future[#startdate]] datepicker input-large date-picker' onfocus='date_funct(this.id)' />
									<span class='input-group-addon'>
										<i class='ace-icon fa fa-calendar'></i>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class='space-2'></div></div>";
		}
	}
		 
	public function getevesessions(){
		$eveid=$_REQUEST['id'];
		if(!empty($eveid)){			
			$data="<option value=''>Select</option>";
			$events=UlsReports::geteventsessions($eveid);
			foreach($events as $event){
				$data.="<option value=".$event['event_sess_id'].">".$event['session_name']."</option>";
			}		   
		}
		else { $data="<option value=''>Select</option>"; }
		echo $data;
	}
	
	public function getbudgetperiods(){
		$budgetid=$_REQUEST['budgetid'];
		if(!empty($budgetid)){
			$data="<option value=''>Select</option>";
			$budgets=UlsReports::getbudgetperiodnames($budgetid);
			foreach($budgets as $budget){
				$data.="<option value=".$budget['period_id'].">".$budget['period_name']."</option>";
			}		   
		}
		else{ $data="<option value=''>Select</option>"; }
		echo $data;
	}
	
	public function get_assessment_asessor(){
		$id=$_REQUEST['assid'];
		$data="";
		$assessors=UlsAssessmentPositionAssessor::get_unique_assessors_details($id);
		$data.="<option value=''>Select</option>";
		foreach($assessors as $assessor){
			$data.="<option value='".$assessor['assessor_id']."'>".$assessor['assessor_name']."</option>";
		}
		echo $data;
		
	}
	
    ///////////////////////////////////////////////////
    ///       PRASAD CODE ENDS                      ///
    ///////////////////////////////////////////////////
   
}
