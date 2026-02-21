<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends  MY_Controller {
	
	 public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$user_id=$this->session->userdata('user_id');
		if(empty($user_id)){
			redirect(site_url(),'refresh');
			exit;
        }
	 }
	 
	public function sessionexist(){
		$user_id=$this->session->userdata('user_id');
		if(empty($user_id)){
			redirect(site_url(),'refresh');
			exit;
        }
    }
	
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
	 
	public function profile()
	{		
		$data=array();
		$data['menu']="index";
		$emp_id=$this->session->userdata('emp_id');		
		$data['userdetails']=UlsEmployeeMaster::getempdetails($emp_id);
		$content = $this->load->view('employee/employee_profile',$data,true);
		$this->render('layouts/adminnew',$content);	
	}
	
	public function changepassword()
	{
		$data=array();
        $this->pagedetails('admin','changepassword');
        if(isset($_POST['conpassword'])){
			
            $checkuser=Doctrine::getTable('UlsUserCreation')->find($this->session->userdata('user_id'));
            if(isset($checkuser->user_id)){
                $checkuser->password=(!empty($_POST['conpassword']))?trim($_POST['conpassword']):'welcome';
                $checkuser->user_login=1;
                $checkuser->save();
                $this->registry->template->message="Password change successfully";
				redirect("admin/profile");
            }
            else{
                $data['message']="Some error occurred please try again";
            }
        }
		$content = $this->load->view('employee/employee_change_password',$data,true);
		$this->render('layouts/employee_changepassword_layout',$content);
	}
	
	public function employee_assessment(){
		$data=array();
		$data['menu']="index";
		$emp_id=$this->session->userdata('emp_id');		
		$data['assessments']=UlsAssessmentDefinition::getemployeeassessments($emp_id);
		$data["aboutpage"]=$this->pagedetails('employee','emp_assessment');
		$content = $this->load->view('employee/employee_assessment',$data,true);
		$this->render('layouts/adminnew',$content);	
	}
	
	public function employee_self_assessment(){
		$data=array();
		$data['menu']="index";
		$emp_id=$this->session->userdata('emp_id');
		$position_id=$_REQUEST['position_id'];
		$assessment_id=$_REQUEST['assessment_id'];
		$assessment_pos_id=$_REQUEST['assessment_pos_id'];	
		$data['ass_details']=UlsAssessmentDefinition::viewassessment($_REQUEST['assessment_id']);
		$data['jour_details']=UlsAssessmentEmployeeJourney::get_employees_details($_REQUEST['jid']);
		$posdetails=UlsPosition::viewposition($_REQUEST['position_id']);
		$data['posdetails']=$posdetails;
		$data['assessments']=UlsAssessmentDefinition::getemployeeselfassessments($emp_id);
		$data["aboutpage"]=$this->pagedetails('employee','emp_assessment');
		$content = $this->load->view('employee/employee_self_assessment',$data,true);
		$this->render('layouts/employee_layout',$content);	
	}
	
	public function employee_self_assessment_details(){		
		$data=array();
		$data['menu']="index";
		$data["aboutpage"]=$this->pagedetails('employee','emp_self_assessment');
		$assessment_id=$_REQUEST['assessment_id'];
		$data['assessment_id']=$assessment_id;
		$data['positions']=UlsSelfAssessmentEmployees::getselfassessment($assessment_id);
		$content = $this->load->view('employee/employee_self_assessment_test',$data,true);
		$this->render('layouts/adminnew',$content);	
	}
	
	public function getassessmentjd(){
		$data=array();
		$position_id=$_REQUEST['position_id'];
		$assessment_id=$_REQUEST['assessment_id'];
		$data['assessment_id']=$assessment_id;
		$data['position_id']=$position_id;
		$posdetails=UlsPosition::viewposition($position_id);
		$data['posdetails']=$posdetails;
		$content = $this->load->view('employee/assessmentjd',$data,true);
		$this->render('layouts/ajax-layout',$content);
	}
	
	public function getcomp_indicator(){
		$comp_id=$_REQUEST['comp_id'];
		$scale_id=$_REQUEST['scale_id'];
		$compentency=UlsMenu::callpdorow("SELECT comp_def_id,comp_def_name,comp_def_short_desc FROM `uls_competency_definition` where comp_def_id='$comp_id'");
		$indicator=UlsCompetencyDefLevelIndicator::getcompdeflevelind_details($comp_id,$scale_id);
		$scale_detail=UlsLevelMasterScale::levelscale_detail($scale_id);
		$data="";
		$data.="
		
		<h4>".$compentency['comp_def_name']." : ".$scale_detail['scale_name']."</h4><br>
		<div><p class='text-muted'>".$compentency['comp_def_short_desc']."</p></div><br>";
		if(count($indicator)>0){
		$data.="
		<div style='border:1px solid #DDDDDD; height: 400px;overflow: auto;' align='left'>
		<table cellpadding='1' cellspacing='1' class='table table-bordered table-striped' width='100%'>
			<thead>
				<tr>
					<th>Indicators Type</th>
					<th>Indicators</th>
				</tr>
			</thead>
			<tbody>";
			foreach($indicator as $indicators){
				$data.="<tr>
					<td>".$indicators['ind_master_name']."</td>
					<td>".$indicators['comp_def_level_ind_name']."</td>
				</tr>";
			}
			$data.="</tbody>
		</table></div>";
		}	
		echo $data;
	}
	
	public function getassessmentprofiling(){
		$data=array();
		$position_id=$_REQUEST['position_id'];
		$assessment_id=$_REQUEST['assessment_id'];
		$data['assessment_id']=$assessment_id;
		$data['position_id']=$position_id;
		$posdetails=UlsPosition::viewposition($position_id);
		$data['posdetails']=$posdetails;
		$data['competencies']=UlsCompetencyPositionRequirements::getcompetencypositionrequirements($position_id);
		$data['kras']=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($position_id);
		$content = $this->load->view('employee/assessmentprofiling',$data,true);
		$this->render('layouts/ajax-layout',$content);	
	}
	
	public function self_ass_summary_details(){
		$data=array();
		$ass_type=$_REQUEST['ass_type'];
		$ass_id=$_REQUEST['assessment_id'];
		$emp_id=$_REQUEST['emp_id'];
		$pos_id=$_REQUEST['position_id'];
		$ass_pos_id=$_REQUEST['assessment_pos_id'];
		$data['id']=$ass_id;
		$data['emp_id']=$emp_id;
		$data['pos_id']=$pos_id;
		$data['ass_type']=$ass_type;
		$data['ass_pos_id']=$ass_pos_id;
		$data['ass_test']=UlsAssessmentTest::assessment_test($ass_id,$pos_id);
		$data['comp_details']=UlsSelfAssessmentReport::getselfassessment_comp_details($ass_id,$pos_id);
		$data['competency_dev']=UlsSelfAssessmentReportDevArea::getselfassessment_dev_summary($ass_id,$pos_id,$emp_id);
		$data['rating_count']=UlsSelfAssessmentReport::getadminselfrating_count($ass_id,$pos_id,$emp_id);
		$data['training_needs']=UlsSelfAssessmentTrainingNeeds::getadminselftrainings($ass_id,$pos_id,$emp_id);
		$yes_stat="YES_NO";
        $data["yesstat"]=UlsAdminMaster::get_value_names($yes_stat);
		$method="DEV_METHOD";
        $data["dev_method"]=UlsAdminMaster::get_value_names($method);
		$review="DEV_PLAN";
        $data["review_method"]=UlsAdminMaster::get_value_names($review);
		$enroll=(!empty($_REQUEST['jid']))?Doctrine_Core::getTable('UlsAssessmentEmployeeJourney')->find($_REQUEST['jid']): new UlsAssessmentEmployeeJourney();
		$enroll->status='I';
		$enroll->save();
		$data["aboutpage"]=$this->pagedetails('employee','self_assessment');
		$content = $this->load->view('employee/selfassessmentsummarydetails',$data,true);
		$this->render('layouts/employee_assessment',$content);
		/* $content = $this->load->view('employee/selfassessmentsummarydetails',$data,true);
		$this->render('layouts/adminnew',$content);	 */
	}
	
	public function self_ass_full_summary_details(){
		$data=array();
		$ass_id=$_REQUEST['ass_id'];
		$emp_id=$_REQUEST['emp_id'];
		$pos_id=$_REQUEST['pos_id'];
		$data['id']=$ass_id;
		$data['emp_id']=$emp_id;
		$data['pos_id']=$pos_id;
		$data['ass_test']=UlsAssessmentTest::assessment_test($ass_id,$pos_id);
		$data['competency']=UlsSelfAssessmentReport::getself_assessment_competencies_full_summary($ass_id,$pos_id,$emp_id);
		$data['competency_dev']=UlsSelfAssessmentReportDevArea::getselfassessment_dev_summary($ass_id,$pos_id,$emp_id);
		$content = $this->load->view('employee/selfassessmentfullsummarydetails',$data,true);
		$this->render('layouts/ajax-layout',$content);
	}
	
	public function getcomp_level(){
		$comp_id=$_REQUEST['comp_id'];
		$level_details=UlsCompetencyDefinition::view_competency_scale($comp_id);
		$data="";
		$data.="<table cellpadding='1' cellspacing='1' class='table table-bordered table-striped' width='100%'>
			<thead>
				<tr>
					<!--<th>Level Number</th>-->
					<th>Level Name</th>
					<th>Level Description</th>
				</tr>
			</thead>
			<tbody>";
			foreach($level_details as $level_detail){
				$des=explode("<br><br>",$level_detail['scale_desc']);
				$desc=isset($des[1])?$des[1]:"";
				$data.="<tr>
					<!--<td>".$level_detail['scale_number']."</td>-->
					<td>".$level_detail['scale_name']."</td>
					<td>
					".$des[0]."
					<div class='mt-10'>
					<code style='font-style: italic;'>".$desc."</code>
					</div>
					</td>
				</tr>";
			}
			$data.="</tbody>
		</table>";
		$cri_info=UlsCompetencyCriticality::criticality_names();
		foreach($cri_info as $cri_infos){
			$data.="<p><b>".$cri_infos['name'].":</b>".$cri_infos['description']."</p>";
		}
		echo $data;
	}
	
	public function self_summary_result_insert(){
		if(isset($_POST['employee_id'])){
			foreach($_POST['competency'] as $key=>$competencys){
				$master_value=!empty($_POST['self_report_id'][$key])?Doctrine::getTable('UlsSelfAssessmentReport')->find($_POST['self_report_id'][$key]): new UlsSelfAssessmentReport();
				$master_value->assessment_id=$_POST['assessment_id'];
				$master_value->position_id=$_POST['position_id'];
				$master_value->employee_id=$_POST['employee_id'];
				$master_value->competency_id=$competencys;
				$master_value->require_scale_id=$_POST['requiredlevel_'.$competencys];
				$master_value->assessed_scale_id=$_POST['OVERALL_'.$competencys];
                $master_value->save();
			}
			$fieldinsertupdates=array('knowledge_dev'=>'knowledge_dev', 'skill_dev'=>'skill_dev');
            $enroll=(!empty($_POST['self_dev_report_id']))?Doctrine_Core::getTable('UlsSelfAssessmentReportDevArea')->find($_POST['self_dev_report_id']): new UlsSelfAssessmentReportDevArea();
            foreach($fieldinsertupdates as $key=>$post_enroll){
				$enroll->$key=(!empty($_POST[$post_enroll]))?$_POST[$post_enroll]:Null;
			}
			$enroll->assessment_id=$_POST['assessment_id'];
			$enroll->position_id=$_POST['position_id'];
			$enroll->employee_id=$_POST['employee_id'];
            $enroll->save();
			$this->session->set_flashdata('assessment',"Self Assessment information has been submitted  successfully.");
			redirect("employee/self_ass_summary_details?id=2&status=career&jid=".$_POST['jid']."&ass_type=".$_POST['ass_type']."&assessment_id=".$_POST['assessment_id']."&position_id=".$_POST['position_id']."&emp_id=".$_POST['employee_id']."&assessment_pos_id=".$_POST['ass_pos_id']);
		}
	}
	
	public function self_summary_result_insert_career(){
		if(isset($_POST['short_term_goals'])){
			
			$fieldinsertupdates=array('short_term_goals'=>'short_term_goals', 'medium_term_goals'=>'medium_term_goals', 'long_term_goals'=>'long_term_goals');
            $enroll=(!empty($_POST['self_dev_report_id']))?Doctrine_Core::getTable('UlsSelfAssessmentReportDevArea')->find($_POST['self_dev_report_id']): new UlsSelfAssessmentReportDevArea();
            foreach($fieldinsertupdates as $key=>$post_enroll){
				$enroll->$key=(!empty($_POST[$post_enroll]))?$_POST[$post_enroll]:Null;
			}
			$enroll->assessment_id=$_POST['assessment_id'];
			$enroll->position_id=$_POST['position_id'];
			$enroll->employee_id=$_POST['employee_id'];
            $enroll->save();
			$this->session->set_flashdata('assessment',"Career Planning information has been submitted  successfully.");
			redirect("employee/self_ass_summary_details?id=3&status=strength&jid=".$_POST['jid']."&ass_type=".$_POST['ass_type']."&assessment_id=".$_POST['assessment_id']."&position_id=".$_POST['position_id']."&emp_id=".$_POST['employee_id']."&assessment_pos_id=".$_POST['ass_pos_id']);
		}
	}
	
	public function self_summary_result_insert_strength(){
		if(isset($_POST['employee_id'])){
			foreach($_POST['competency'] as $key=>$competencys){
				$master_value=!empty($_POST['self_report_id'][$key])?Doctrine::getTable('UlsSelfAssessmentReport')->find($_POST['self_report_id'][$key]): new UlsSelfAssessmentReport();
				$master_value->strengths=$_POST['strengths_'.$competencys];
                $master_value->save();
			}
			
			$this->session->set_flashdata('assessment',"Self Assessment information has been submitted  successfully.");
			redirect("employee/self_ass_summary_details?id=4&status=development&jid=".$_POST['jid']."&ass_type=".$_POST['ass_type']."&assessment_id=".$_POST['assessment_id']."&position_id=".$_POST['position_id']."&emp_id=".$_POST['employee_id']."&assessment_pos_id=".$_POST['ass_pos_id']);
		}
	}
	
	public function self_summary_result_insert_development(){
		if(isset($_POST['employee_id'])){
			foreach($_POST['competency'] as $key=>$competencys){
				$master_value=!empty($_POST['self_report_id'][$key])?Doctrine::getTable('UlsSelfAssessmentReport')->find($_POST['self_report_id'][$key]): new UlsSelfAssessmentReport();
				$master_value->knowledge_skill=$_POST['knowledge_skill_'.$competencys];
				$master_value->method=$_POST['method_'.$competencys];
				$master_value->org_support=$_POST['org_support_'.$competencys];
				$master_value->target_date=!empty($_POST['target_date_'.$competencys])?date("Y-m-d",strtotime($_POST['target_date_'.$competencys])):NULL;
				$master_value->comp_evidence=$_POST['comp_evidence_'.$competencys];
                $master_value->save();
			}
			if(isset($_POST['leverage'])){
				$fieldinsertupdates=array('leverage'=>'leverage', 'review'=>'review', 'reporting'=>'reporting');
				$enroll=(!empty($_POST['self_dev_report_id']))?Doctrine_Core::getTable('UlsSelfAssessmentReportDevArea')->find($_POST['self_dev_report_id']): new UlsSelfAssessmentReportDevArea();
				foreach($fieldinsertupdates as $key=>$post_enroll){
					$enroll->$key=(!empty($_POST[$post_enroll]))?$_POST[$post_enroll]:Null;
				}
				$enroll->assessment_id=$_POST['assessment_id'];
				$enroll->position_id=$_POST['position_id'];
				$enroll->employee_id=$_POST['employee_id'];
				$enroll->save();
			}
			if(isset($_POST['training_desc'])){
            foreach($_POST['training_desc'] as $key=>$code){
                $master_value=!empty($_POST['self_training_id'][$key])?Doctrine::getTable('UlsSelfAssessmentTrainingNeeds')->find($_POST['self_training_id'][$key]): new UlsSelfAssessmentTrainingNeeds();
                $master_value->training_desc=$_POST['training_desc'][$key];
                $master_value->remark=$_POST['remarks'][$key];
				$master_value->assessment_id=$_POST['assessment_id'];
				$master_value->position_id=$_POST['position_id'];
				$master_value->employee_id=$_POST['employee_id'];
                $master_value->save();
            }
			}
			
			redirect("employee/self_ass_summary_preview?jid=".$_POST['jid']."&ass_type=".$_POST['ass_type']."&assessment_id=".$_POST['assessment_id']."&position_id=".$_POST['position_id']."&emp_id=".$_POST['employee_id']."&assessment_pos_id=".$_POST['ass_pos_id']);
		}
	}
	
	
	
	public function self_full_summary_result_insert(){
		if(isset($_POST['employee_id'])){
			foreach($_POST['competency'] as $key=>$competencys){
				$master_value=!empty($_POST['self_report_id'][$key])?Doctrine::getTable('UlsSelfAssessmentReport')->find($_POST['self_report_id'][$key]): new UlsSelfAssessmentReport();
				$master_value->assessment_id=$_POST['assessment_id'];
				$master_value->position_id=$_POST['position_id'];
				$master_value->employee_id=$_POST['employee_id'];
				$master_value->competency_id=$competencys;
				$master_value->require_scale_id=$_POST['requiredlevel_'.$competencys];
				$master_value->assessed_scale_id=$_POST['OVERALL_'.$competencys];
                $master_value->save();
			}
			$fieldinsertupdates=array('knowledge_dev'=>'knowledge_dev', 'skill_dev'=>'skill_dev');
            $enroll=(!empty($_POST['self_dev_report_id']))?Doctrine_Core::getTable('UlsSelfAssessmentReportDevArea')->find($_POST['self_dev_report_id']): new UlsSelfAssessmentReportDevArea();
            foreach($fieldinsertupdates as $key=>$post_enroll){
				$enroll->$key=(!empty($_POST[$post_enroll]))?$_POST[$post_enroll]:Null;
			}
			$enroll->assessment_id=$_POST['assessment_id'];
			$enroll->position_id=$_POST['position_id'];
			$enroll->employee_id=$_POST['employee_id'];
            $enroll->save();
			echo 'done';
		}
	}
	
	public function employee_assessment_details(){
		$this->sessionexist();	
		$data=array();
		$data['menu']="index";
		$data["aboutpage"]=$this->pagedetails('employee','emp_assessment');
		$data['testimonials']=array();//Testimonials::doTestimoniallimit();
		$data['package']=array();//Packages::dopackages();
		$posdetails=UlsPosition::viewposition($_REQUEST['position_id']);
		$data['posdetails']=$posdetails;
		$data['ass_details']=UlsAssessmentDefinition::viewassessment($_REQUEST['assessment_id']);
		$data['jour_details']=UlsAssessmentEmployeeJourney::get_employees_details($_REQUEST['jid']);
		$data['competencies']=UlsAssessmentCompetencies::getassessment_competencies_emp($_REQUEST['assessment_id'],$_REQUEST['position_id']);
		$data['kras']=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($_REQUEST['position_id']);
		$data['assessor']=UlsAssessmentPositionAssessor::getassessors_details($_REQUEST['assessment_id'],$_REQUEST['position_id']);
		$data['ass_test']=UlsAssessmentTest::assessment_testemp($_REQUEST['assessment_id'],$_REQUEST['position_id']);
		$data['emp_comp_map']=UlsAssessmentEmployees::get_assessment_employees_comp($_SESSION['emp_id'],$_REQUEST['assessment_id'],$_REQUEST['position_id']);
		$jor_id=UlsAssessmentEmployeeJourney::get_employees_details($_REQUEST['jid']);
		$enroll=(!empty($_REQUEST['jid']))?Doctrine_Core::getTable('UlsAssessmentEmployeeJourney')->find($_REQUEST['jid']): new UlsAssessmentEmployeeJourney();
		$enroll->status=!empty($jor_id)?(($jor_id['status']=='C')?'C':'I'):'I';
		$enroll->save();
		if(isset($_SESSION['inbasket_time'])){
			unset($_SESSION['inbasket_time']);
		}
		$content = $this->load->view('employee/employee_assessment_test',$data,true);
		$this->render('layouts/employee_layout',$content);	
	}
	
	public function employee_test_details(){
		$this->sessionexist();	
		$data=array();
		$data['menu']="index";
		if(isset($_REQUEST['assess_test_id'])){
			$ass_test=UlsAssessmentTest::test_details($_REQUEST['assess_test_id']);
			$data['ass_details']=$ass_test;
			$emp_id=isset($_SESSION['e_emp_id']) ? $_SESSION['e_emp_id'] : $_SESSION['emp_id'];
			$test_id=$ass_test['test_id'];
			$ass_test_id=$_REQUEST['assess_test_id'];
			$pos_id=$ass_test['position_id'];
			$ass_id=$ass_test['assessment_id'];
			$assdetails=UlsAssessmentDefinition::viewassessment($ass_id);
			$checkalreadyteststarted=UlsMenu::callpdo("select * from uls_utest_employee_question where test_id=$test_id and ass_test_id=$ass_test_id and assessment_id=$ass_id and employee_id=$emp_id");
			if(count($checkalreadyteststarted)==0){
				if($assdetails['ass_emp_comp']=='Y'){
					$emp_comp=UlsAssessmentEmployees::get_assessment_employees_comp($emp_id,$ass_id,$pos_id);
					$testques=UlsUtestResponsesAssessment::get_test_view_comp_details($test_id,$ass_test_id,$ass_id,$emp_comp['comp_ids']);
				}
				else{
					$testques=UlsUtestResponsesAssessment::get_test_view_details($test_id,$ass_test_id,$ass_id);
				}
				
				foreach($testques as $testque){
					$testq=new UlsUtestEmployeeQuestion();
					$testq->employee_id=$emp_id;
					$testq->sequence=$testque['sequence'];
					$testq->question_id=$testque['question_id'];
					$testq->question_type=$testque['question_type'];
					$testq->test_id=$test_id;
					$testq->ass_test_id=$ass_test_id;
					$testq->assessment_id=$ass_id;
					$testq->competency_id=!empty($testque['competency_id'])?$testque['competency_id']:NULL;
					$testq->save();
				}
			}
			$data['testdetails']=UlsMenu::callpdo("select a.sequence,b.question_id,b.question_name,b.question_type,a.answer from uls_utest_employee_question a ,uls_questions b where a.question_id=b.question_id and a.test_id=".$test_id." and a.ass_test_id=".$ass_test_id." and a.assessment_id=".$ass_id ." and a.employee_id=$emp_id");
			$data["aboutpage"]=$this->pagedetails('employee','emp_test_assessment');
			$content = $this->load->view('employee/employee_test_details',$data,true);
		}
		$this->render('layouts/employee_assessment',$content);	
	}
	
	public function employee_development(){		
		$data=array();
		$data['menu']="index";
		$data['testimonials']=array();//Testimonials::doTestimoniallimit();
		$data['package']=array();//Packages::dopackages();
		
		$content = $this->load->view('employee/employee_development',$data,true);
		$this->render('layouts/adminnew',$content);	
	}

	/* public function menu()
	{		
		$data=array();
		$data['menu']="menu";
		$data['ourmenu']=Menu::domenu();
		$content = $this->load->view('welcome/menu',$data,true);
		$this->render('layouts/front',$content);	
	} */

	/* 
	public function logout(){
		unset($_SESSION['userid']);
		unset($_SESSION['username']);
		redirect("login");
	} */
	
	public function login()
	{		
		$data=array();
		$data['menu']="index";
		$data['testimonials']=array();//Testimonials::doTestimoniallimit();
		$data['package']=array();//Packages::dopackages();
		$content = $this->load->view('admin/dashboard',$data,true);
		$this->render('layouts/adminnew',$content);	
	}
	
	public function assessment_test_details(){
		$id=$_REQUEST['ass_id'];
		$ass_details=UlsAssessmentTest::test_details($id);
		$emp_id=isset($_SESSION['e_emp_id']) ? $_SESSION['e_emp_id'] : $_SESSION['emp_id'] ;
		$getpretest=UlsUtestAttemptsAssessment::getattemptvalus($ass_details['assessment_id'],$emp_id,$id,$ass_details['assessment_type']);
		$data="";
		if($ass_details['assessment_type']=='INBASKET'){
			$ass_detail_inbasket=UlsAssessmentTestInbasket::getinbasketassessment($id);
			
			$data="<div class='col-md-12'>
			<div class='hpanel hgreen'>
				<div class='panel-heading hbuilt'>
					<h3>INBASKET Items</h3>
				</div>
				<div class='panel-body'>
					
					<div class='table-responsive'>
					<table class='table table-hover table-bordered table-striped'>
						<thead>
							<tr>
								<th>Assessment Name</th>
								<th>Status</th>
								<!--<th>Details</th>-->
								<th>Action</th>
							</tr>
						</thead>
						<tbody>";
						foreach($ass_detail_inbasket as $ass_detail_inbaskets){
							$getpretest_inbasket=UlsUtestAttemptsAssessment::getattemptvalus_inbasket($ass_details['assessment_id'],$emp_id,$id,$ass_details['assessment_type'],$ass_detail_inbaskets['test_id']);
						$data.="<tr>
							<td class='issue-info'>
								<a href='#'>
									".$ass_details['assessment_name']."
								</a>
							</td>
							<td>";
								$data.=($getpretest_inbasket['attempt_status']=='COM')?'Completed':'In Process';
							$data.="</td>
							<!--<td class='text-center'>
								<span class='label label-success' data-target='#workinfoview".$ass_detail_inbaskets['inbasket_id']."' onclick='work_info_view(".$ass_detail_inbaskets['inbasket_id'].")' data-toggle='modal' href='#workinfoview".$ass_detail_inbaskets['inbasket_id']."'>Details</span>
							</td>-->
							<td class='text-center'>";
							if(empty($getpretest_inbasket['attempt_status'])){
								$data.="<button class='btn btn-success btn-xs' data-toggle='modal' data-target='#myModal5' onclick='mytest_details_inbasket(".$id.",".$ass_details['assessment_id'].",".$ass_detail_inbaskets['test_id'].",\"".$ass_details['assessment_type']."\",".$ass_detail_inbaskets['inbasket_id'].");'> Start</button>";
							}
							else{
								$data.="<a href='#' class='btn btn-danger btn-xs' onclick='alertmsg()' >Completed</a>";
							}
							$data.="</td>
						</tr>
						<div id='workinfoview".$ass_detail_inbaskets['inbasket_id']."'  class='modal fade' tabindex='-1' role='dialog'  aria-hidden='true'>
							<div class='modal-dialog modal-lg'>
								<div class='modal-content'>
									<div class='color-line'></div>
									<div class='modal-header'>
										<h4 class='modal-title'>In-basket Details</h4>
									</div>
									<div class='modal-body'>
										<div id='workinfodetails".$ass_detail_inbaskets['inbasket_id']."' class='modal-body no-padding'>
										
										</div>
									</div>
									
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div>";
						}
						$data.="</tbody>
					</table>
					</div>
				</div>
			</div>
		</div>";
		}
		elseif($ass_details['assessment_type']=='BEHAVORIAL_INSTRUMENT'){
			$ass_detail_beh=UlsAssessmentTestBehavorialInst::getbehavorialassessment($id);
			
			$data="<div class='col-md-12'>
			<div class='hpanel hgreen'>
				<div class='panel-heading hbuilt'>
					<h3>Behavorial Instrument</h3>
				</div>
				<div class='panel-body'>
					
					<div class='table-responsive'>
					<table class='table table-hover table-bordered table-striped'>
						<thead>
							<tr>
								<th>Assessment Name</th>
								<th>Status</th>
								<!--<th>Details</th>-->
								<th>Action</th>
							</tr>
						</thead>
						<tbody>";
						foreach($ass_detail_beh as $ass_detail_behs){
							$getpretest_beh=UlsBeiAttemptsAssessment::getattemptvalus_beh($ass_details['assessment_id'],$emp_id,$ass_details['assessment_type'],$id,$ass_detail_behs['instrument_id']);
						$data.="<tr>
							<td class='issue-info'>
								<a href='#'>
									".$ass_details['assessment_name']."
								</a>
							</td>
							<td>";
								$data.=($getpretest_beh['attempt_status']=='COM')?'Completed':'In Process';
							$data.="</td>
							<td class='text-center'>";
							if(empty($getpretest_beh['attempt_status'])){
								$data.="<button class='btn btn-success btn-xs' data-toggle='modal' data-target='#myModal5' onclick='mytest_details_beh(".$id.",".$ass_details['assessment_id'].",\"".$ass_details['assessment_type']."\",".$ass_detail_behs['instrument_id'].");'> Start</button>";
							}
							else{
								$data.="<a href='#' class='btn btn-danger btn-xs' onclick='alertmsg()' >Action</a>";
							}
							$data.="</td>
						</tr>
						<div id='workinfoview".$ass_detail_behs['instrument_id']."'  class='modal fade' tabindex='-1' role='dialog'  aria-hidden='true'>
							<div class='modal-dialog modal-lg'>
								<div class='modal-content'>
									<div class='color-line'></div>
									<div class='modal-header'>
										<h4 class='modal-title'>In-basket Details</h4>
									</div>
									<div class='modal-body'>
										<div id='workinfodetails".$ass_detail_behs['instrument_id']."' class='modal-body no-padding'>
										
										</div>
									</div>
									
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div>";
						}
						$data.="</tbody>
					</table>
					</div>
				</div>
			</div>
		</div>";
		}
		elseif($ass_details['assessment_type']=='CASE_STUDY'){
			$ass_detail_casestudy=UlsAssessmentTestCasestudy::getcasestudyassessment($id);
			
			$data="<div class='col-md-12'>
			<div class='hpanel hgreen'>
				<div class='panel-heading hbuilt'>
					<h3>Case Study Details</h3>
				</div>
				<div class='panel-body'>
					<div class='table-responsive'>
					<table class='table table-hover table-bordered table-striped'>
						<thead>
							<tr>
								<th>Assessment Name</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>";
						foreach($ass_detail_casestudy as $ass_detail_casestudys){
							$getpretest_inbasket=UlsUtestAttemptsAssessment::getattemptvalus_inbasket($ass_details['assessment_id'],$emp_id,$id,$ass_details['assessment_type'],$ass_detail_casestudys['test_id']);
						$data.="<tr>
							<td class='issue-info'>
								<a href='#'>
									".$ass_details['assessment_name']."
								</a>
							</td>
							<td>";
								$data.=$getpretest_inbasket['attempt_status']=='COM'?'Completed':'In Process';
							$data.="</td>
							<!--<td class='text-center'>
								<span class='label label-success' data-target='#workinfoview_casestudy".$ass_detail_casestudys['casestudy_id']."' onclick='work_info_view_casestudy(".$ass_detail_casestudys['casestudy_id'].")' data-toggle='modal' href='#workinfoview_casestudy".$ass_detail_casestudys['casestudy_id']."'>Details</span>
							</td>-->
							<td class='text-center'>";
							if(empty($getpretest_inbasket['attempt_status'])){
								$data.="<button class='btn btn-success btn-xs' data-toggle='modal' data-target='#myModal5' onclick='mytest_details_casestudy(".$id.",".$ass_details['assessment_id'].",".$ass_detail_casestudys['test_id'].",\"".$ass_details['assessment_type']."\",".$ass_detail_casestudys['casestudy_id'].");'> Start</button>";
							}
							else{
								$data.="<a href='#' class='btn btn-danger btn-xs' onclick='alertmsg()' >Completed</a>";
							}
							$data.="</td>
						</tr>
						<div id='workinfoview_casestudy".$ass_detail_casestudys['casestudy_id']."'  class='modal fade' tabindex='-1' role='dialog'  aria-hidden='true'>
							<div class='modal-dialog modal-lg'>
								<div class='modal-content'>
									<div class='color-line'></div>
									<div class='modal-header'>
										<h4 class='modal-title'>Case Study Details</h4>
									</div>
									<div class='modal-body'>
										<div id='workinfodetails_casestudy".$ass_detail_casestudys['casestudy_id']."' class='modal-body no-padding'>
										
										</div>
									</div>
									
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div>";
						}
						$data.="</tbody>
					</table>
					</div>
				</div>
			</div>
		</div>";
		}
		else{		
		$data="<div class='col-md-12'>
			<div class='hpanel hgreen'>
				<div class='panel-heading hbuilt'>
					<h3>Test Details</h3>
				</div>
				<div class='panel-body'>

					<div class='table-responsive'>
					<table class='table table-hover table-bordered table-striped'>
						<thead>
							<tr>
								<th>Assessment Type</th>
								<th>Assessment Name</th>
								<th>Total Questions</th>
								<th>Time Interval</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						<tr>
							<td>
								<span class='label label-success'>".$ass_details['assessment_type']."</span>
							</td>
							<td class='issue-info'>
								<a href='#'>
									".$ass_details['assessment_name']."
								</a>
							</td>
							<td>
								".$ass_details['no_questions']."
							</td>
							<td>
								".$ass_details['time_details']."
							</td>
							<td>";
								$data.=$status=empty($getpretest['attempt_status'])?'In Process':'Completed';
							$data.="</td>
							<td class='text-right'>";
							if(empty($getpretest['attempt_status'])){
								$data.="<button class='btn btn-success btn-xs' data-toggle='modal' data-target='#myModal5' onclick='mytest_details(".$id.",".$ass_details['assessment_id'].",".$ass_details['test_id'].",\"".$ass_details['assessment_type']."\");'> Start</button>";
							}
							else{
								$data.="<a href='#' class='btn btn-danger btn-xs' onclick='alertmsg()' >".$status."</a>";
							}
							$data.="</td>
						</tr>
						</tbody>
					</table>
					</div>
				</div>

			</div>
		</div>";
		}
		echo $data;
	}


	public function getemp_test(){	   
		$testype="'".$_REQUEST['type']."'";
		$ass_id=$_REQUEST['ass_id'];
        $ass_test_id=$_REQUEST['id'];
		$test_id=$_REQUEST['test_id'];
		$inbasket_ass_id=$_REQUEST['ins_id'];
		$emp_id=isset($_SESSION['e_emp_id']) ? $_SESSION['e_emp_id'] : $_SESSION['emp_id'] ;
        $testval=UlsAssessmentEmployees::getfeedback_attempts_new($ass_test_id,$ass_id,$testype,$test_id,$emp_id); //getting attempts from UlsTesAttempts Table
		$ass_test=UlsAssessmentTest::test_details($ass_test_id);
        $testd=UlsUtestResponsesAssessment::get_test_details($test_id); 
		$checkalreadyteststarted=UlsMenu::callpdo("select * from uls_utest_employee_question where test_id=$test_id and ass_test_id=$ass_test_id and assessment_id=$ass_id and employee_id=$emp_id");
		if(count($checkalreadyteststarted)==0){
			$testques=UlsUtestResponsesAssessment::get_test_view_details($test_id,$ass_test_id,$ass_id);
			foreach($testques as $testque){
				$testq=new UlsUtestEmployeeQuestion();
				$testq->employee_id=$emp_id;
				$testq->sequence=$testque['sequence'];
				$testq->question_id=$testque['question_id'];
				$testq->question_type=$testque['question_type'];
				$testq->test_id=$test_id;
				$testq->ass_test_id=$ass_test_id;
				$testq->assessment_id=$ass_id;
				$testq->save();
			}
		}
        //$testdetails=UlsUtestResponsesAssessment::get_test_view_details($test_id,$ass_test_id,$ass_id);
		
		$testdetails=UlsMenu::callpdo("select a.sequence,b.question_id,b.question_name,b.question_type,a.answer from uls_utest_employee_question a ,uls_questions b where a.question_id=b.question_id and a.test_id=".$test_id." and a.ass_test_id=".$ass_test_id." and a.assessment_id=".$ass_id ." and a.employee_id=$emp_id");
		$respvals=array();
		$data="";
        $data.="
			<div class=''>
				<div class='modal-header'>
				<h5 class='modal-title'>&emsp;".$_REQUEST['type']."</h5>
				<table  class='pull-right'><tr>
										<td class='btn btn-block btn-anim btn-primary btn-rounded'><b>Test Time :<label id='testtime' style='width:auto' >".$ass_test['time_details']." </label>Minute(s).</b></td>
										<td> </td>
										<td class='btn btn-info btn-rounded btn-block btn-anim'><b>Remaining Time :<span id='m_timer' class='style colorDefinition size_sm'></b></td>
											<td id='countdowntimer'></span>
											 
										   </td>
									 </tr> </table>
			</div>
			<form action='".BASE_URL."/employee/employee_test' method='post' name='employeeTest' id='employeeTest'>
				<div class='panel-body no-padding'>
					<div class='row'>
						<div class='col-md-9 '>
							<div class='chat-discussion'>
							<p class='text-muted'><code>*Please give answers to all questions.</code></p>
								<div class='hpanel'>
			<input type='hidden' name='testid' id='testid' value=".$test_id." />
			<input type='hidden' name='assid' id='assid' value=".$ass_id." />
			<input type='hidden' name='empid' id='empid' value=".$emp_id." />
			<input type='hidden' name='ttype' id='ttype' value=".$testype." /> 
			<input type='hidden' name='ass_test_id' id='ass_test_id' value=".$ass_test_id." />
			<input type='hidden' name='timeconsume' id='timeconsume' value='Y' />
			<input type='hidden' name='totquest' id='totquest' value='".count($testdetails)."' />";
								$valid='required';
								if(count($testdetails)>0){
									foreach($testdetails as $keys=>$testdetail){
										$key=$keys+1; 
										$type=$testdetail['question_type'];
										$var=($key==1)?"block":"none";
										$data.="<div style='display:".$var.";' id='question_list".$key."' class='open_question_div' >
											<div class='panel-heading hbuilt'>
												<button class='btn btn-info btn-circle' type='button'>".$key."</button> ".$testdetail['question_name']."
												<input type='hidden' id='question_".$key."' name='question[".$key."]'  value='".$testdetail['question_id']."' >
												<input type='hidden' name='qtype' id='qtype_". $key."' value=".$type." />
												<input type='hidden' name='testid' id='testid' value=".$test_id." />
												<input type='hidden' name='inb_assess_test_id' id='inb_assess_test_id' value=".$inbasket_ass_id." />
											</div>
											<div class='panel-body no-padding'>";
											$scort=($type=='P')?'sortable':'';
												$data.="<ul id='".$scort."' class='list-group'>";
												$ran='';//'ORDER BY RAND()';
												$ss=UlsAssessmentTest::test_question_value($testdetail['question_id'],$ran);
												foreach($ss as $key1=>$sss){
													if($type=='F'){ 
														if(in_array($sss['value_id'],$respvals)){
															$valuename=Doctrine_Query::Create()->from('UlsUtestResponsesAssessment')->where("response_value_id=".$sss['value_id']." and assessment_id=".$ass_id."  And employee_id=".$emp_id." And test_type=".$testype." And event_id=".$ass_test_id)->fetchOne();
															$ched=$valuename->text; 
														}
														else {  $ched=""; }
														if(!empty($testdetail['answer'])){$ched=$testdetail['answer'];}
														$data.="<li class='list-group-item'>
															&emsp;Ans: <input type='text' value='".$ched."' class='validate[".$valid."] mediumtext' name='answer_".$key."[]' id='answer_". $key ."_".$key1 ."'/>
														</li>";
													}
													else if($type=='B'){
														if(in_array($sss['value_id'],$respvals)){				
															$valuename=Doctrine_Query::Create()->from('UlsUtestResponsesAssessment')->where("response_value_id=".$sss['value_id']." and assessment_id=".$ass_id." And employee_id =".$emp_id." And test_type=".$testype." And event_id=".$ass_test_id)->fetchOne(); 
															$ched=$valuename->text;
														} 
														else {  $ched=""; }
														if(!empty($testdetail['answer'])){$ched=$testdetail['answer'];}
														$data.="<li class='list-group-item'>
															&emsp;Ans: <input type='text' value='".$ched."' class='validate[".$valid."] mediumtext' name='answer_".$key."[]' id='answer_".$key."_".$key1."' />
														</li>";
													}
													else if($type=='T'){
														if(in_array($sss['value_id'], $respvals)){ $ched="checked='checked'"; } else {  $ched=""; }
														if(!empty($testdetail['answer'])){ if($sss['value_id']==$testdetail['answer']){ $ched="checked='checked'"; } else {  $ched=""; } }
														$data.="<li class='list-group-item'>
															<div class=''><label  for='truefalse'> <input type='radio' class='validate[".$valid."]' ".$ched."  value='".$sss['value_id']."' name='answer_".$key."[]' value='' id='answer_".$key."_".$key1."'> ".$sss['text']."</label></div>
														</li>";
													}
													else if($type=='S'){ 
														if(in_array($sss['value_id'], $respvals)){ 
															$ched="checked='checked'"; } 
														else {  
															$ched=""; 
														}
														if(!empty($testdetail['answer'])){ if($sss['value_id']==$testdetail['answer']){ $ched="checked='checked'"; } else {  $ched=""; } }
														$data.="<li class='list-group-item'>
															<div class=''><label  for='truefalse'> <input type='radio'". $ched."  class='validate[".$valid."]' value='".$sss['value_id']."' name='answer_".$key."[]' id='answer_".$key ."_".$key1."'> ".$sss['text']."</label></div>
														</li>";
													}
													else if($type=='M'){
														if(in_array($sss['value_id'], $respvals)){ 
															$ched='checked="checked"'; 
														}
														else { 
															$ched=''; 
														}
														if(!empty($testdetail['answer'])){
															$ansmulti=explode(",",$testdetail['answer']);
															if(in_array($sss['value_id'], $ansmulti)){ $ched="checked='checked'"; }
															else {  $ched=""; }
														}
														$data.="<li class='list-group-item'>
															<div class=''><label  for='truefalse'> <input type='checkbox' ".$ched." class='validate[".$valid."]' value='".$sss['value_id']."' name='answer_".$key."[]' id='answer_".$key ."_".$key1."'> ".$sss['text']."</label></div>
														</li>";
													}
													else if($type=='FT'){
														if(in_array($sss['value_id'],$respvals)){				
														$valuename=Doctrine_Query::Create()->from("UlsUtestResponsesAssessment")->where("response_value_id=".$sss['value_id']." and employee_id=".$emp_id." and test_type=".$testype." and event_id=".$ass_test_id." and  assessment_id=".$ass_id)->fetchOne();
														$ched=$valuename->text;
														}
														else {  $ched=""; }
														if(!empty($testdetail['answer'])){$ched=$testdetail['answer'];}
														$data.="<li class='list-group-item'>
															&emsp;<textarea style='resize:none;width:750px;height:250px;' name='answer_".$key."[]' class='validate[".$valid."] mediumtexta' id='answer_".$key."_". $key1 ."'> ". $ched."</textarea>
														</li>";
													}
													else if($type=='P'){
														if(in_array($sss['value_id'],$respvals)){				
														$valuename=Doctrine_Query::Create()->from("UlsUtestResponsesAssessment")->where("response_value_id=".$sss['value_id']." and employee_id=".$emp_id." and test_type=".$testype." and event_id=".$ass_test_id." and  assessment_id=".$ass_id)->fetchOne();
														$ched=$valuename->text;
														}
														else {  $ched=""; }
														$data.="<li class='list-group-item'>
															<i class='fa fa-arrows-v'></i>
															<input type='hidden' value='".$sss['value_id']."' name='answer_".$key."[]' id='answer_".$key ."_".$key1."'>
															<label  for='truefalse'> ".str_replace(array("\\\\","\\r\\n"),array("\\","<br>"),$sss['text'])."</label> 
															<input type='text' name='answer_text".$sss['value_id']."' id='answer_text_".$key ."_".$key1."' class='form-control'>
														</li>";
													}
												}	
												$data.="</ul>
											</div>
											<div class='panel-footer borders' style='display:".$var.";padding: 6px 22px 40px;' id='question_button". $key."'>";
											$count=count($testdetails);
											if($type=='P'){
												$data.="
												<div class='pull-right'>
													<div class='btn-group'>
														<button class='btn btn-success' id='submit_ass'>Submit</button>
													</div>
												</div>";
											}
											else{
												$data.="<div class='pull-right'>
													<div class='btn-group'>";
													if($key==1){
														$data.="<button class='next_question btn btn-info' id='next' data='".$key."'>Next</button>";
														if(empty($testdetail['answer'])){
															$data.="<button class='skip_question btn btn-warning' id='next' data='".$key."'>Skip</button>";
														}
													}
													elseif($key<$count){
														$data.="<button class='next_question btn btn-info' id='next' data='".$key."'>Next</button>";
														if(empty($testdetail['answer'])){
															$data.="<button class='skip_question btn btn-warning' id='next' data='".$key."'>Skip</button>";
														}
													}
													elseif($key=$count){
														$data.="<button class='btn btn-success' onclick='return click_submit();' id='submit_ass'>Submit</button>";
													}
														
													$data.="</div>
												</div>";
											}
											$data.="</div>
										</div>";
									}
								}
								$data.="</div>
								
							</div>
						</div>
						<div class='col-md-3'>
							<div class='chat-users'>
									
								<div class='users-list'>";
								if(count($testdetails)>0){
									$anstet="";
									foreach($testdetails as $key=>$testdetailss){
										$ke=$key+1;$cc=""; $bcolor="";
										if(!empty($testdetailss['answer'])){ if(empty($anstet)){ $anstet=$ke; }else{ $anstet=$anstet.",".$ke;} $cc="onclick='openskipdiv($ke)'"; $bcolor="btn-success"; }
										if($ke==1){
											$cc="onclick='openskipdiv($ke)'";
										}
									$data.="<div class='chat-user'>
										<div class='chat-user-name'>
											<button class='btn question_color".$testdetailss['question_id']." btn-circle $bcolor' type='button'>".$ke."</button> &nbsp;&nbsp;<a href='#' id='open_skip_question".$testdetailss['question_id']."' $cc>Question ".$ke."</a>
											<input type='hidden' id='skipvalue".$ke."' value=''>
										</div>
									</div>";
									}
								}									
								$data.="<input type='hidden' id='totansweredquest' value='$anstet' ></div>
							</div>
						</div>
					</div>
				</div>
			</form></div>";
		$data.="";
		echo $data;	
	}
	
	public function getemp_test_beh(){	   
		$testype="'".$_REQUEST['type']."'";
		$ass_id=$_REQUEST['ass_id'];
        $ass_test_id=$_REQUEST['id'];
		$instrument_id=$_REQUEST['instrument_id'];
		$emp_id=isset($_SESSION['e_emp_id']) ? $_SESSION['e_emp_id'] : $_SESSION['emp_id'] ;
		$instrumenttype=UlsMenu::callpdorow("SELECT * FROM `uls_be_instruments` where instrument_id=".$instrument_id);
        $testdetails=UlsBeiResponsesAssessment::get_test_view_details_beh($ass_test_id,$ass_id,$instrument_id);
		$respvals=array();
		$data="";
        $data.="
			<div class=''>
				<div class='modal-header'>
				<h5 class='modal-title'>&emsp;Behavioral Instrument : ".$instrumenttype['instrument_name']."</h5>
				
			</div>
			<form action='".BASE_URL."/employee/employee_test_beh' method='post' name='employeeTest' id='employeeTest'>
				<div class='panel-body no-padding'>
					<div class='row'>
						<div class='col-md-12 '>
							<p><h6 class='panel-title'>About the Instrument:</h6>".$instrumenttype['instrument_description']."</p>
							<p><h6 class='panel-title'>Instructions:</h6>".$instrumenttype['instrument_instruction']."</p>
							<div class='chat-discussion'>
							<p class='text-muted'><code>*Please choose an Option for all the statements.</code></p>
								<div class='hpanel'>
			<input type='hidden' name='instrument_id' id='instrument_id' value=".$instrument_id." />
			<input type='hidden' name='assid' id='assid' value=".$ass_id." />
			<input type='hidden' name='empid' id='empid' value=".$emp_id." />
			<input type='hidden' name='ttype' id='ttype' value=".$testype." /> 
			<input type='hidden' name='ass_test_id' id='ass_test_id' value=".$ass_test_id." />
			<input type='hidden' name='timeconsume' id='timeconsume' value='Y' />";
								$valid='required';
								if(count($testdetails)>0){
									if($instrumenttype['instrument_type']=='BEI_RATING_SINGLE'){
										foreach($testdetails as $keys=>$testdetail){
											$key=$keys+1; 
											$var=($key==1)?"block":"none";
											$data.="<div style='display:".$var.";' id='question_list".$key."' class='open_question_div' >
												<div class='panel-heading hbuilt'>
													<button class='btn btn-info btn-circle' type='button'>".$key."</button> ".$testdetail['ins_subpara_text']."
													<input type='hidden' id='question_".$key."' name='question[".$key."]'  value='".$testdetail['ins_subpara_id']."' >
													<input type='hidden' id='par_question_".$key."' name='par_question[".$key."]'  value='".$testdetail['ins_para_id']."' >
													<input type='hidden' name='qtype' id='qtype_". $key."' value=".$testdetail['instrument_type']." />
													<input type='hidden' name='testid' id='testid' value=".$testdetail['assess_test_id']." />
													<input type='hidden' name='instrument_id' id='instrument_id' value=".$testdetail['instrument_id']." />
													<input type='hidden' name='instrument_scale' id='instrument_scale' value=".$testdetail['instrument_scale']." />
														
												</div>
												<div class='panel-body no-padding'>";
													$data.="<ul class='list-group'>";
													$ran='ORDER BY RAND()';
													$ss=UlsBeInsRatScaleValues::rating_value($testdetail['instrument_scale']);
													foreach($ss as $key1=>$sss){
														
														if(in_array($sss['ins_rat_scale_value_id'], $respvals)){ 
															$ched="checked='checked'"; } 
														else {  
															$ched=""; 
														}
														$data.="<li class='list-group-item'>
															<div class=''><label  for='truefalse'> <input type='radio'". $ched."  class='validate[".$valid."]' value='".$sss['ins_rat_scale_value_number']."' name='answer_".$key."[]' id='answer_".$key ."_".$key1."'> ".$sss['ins_rat_scale_value_name']."</label></div>
														</li>";
														
													}	
													$data.="</ul>
												</div>
												<div class='panel-footer borders' style='display:".$var.";padding: 6px 22px 40px;' id='question_button". $key."'>";
												$count=count($testdetails);
												
												$data.="<div class='pull-right'>
													<div class='btn-group'>";
													if($key==1){
														$data.="<button class='next_question btn btn-info' id='next' data='".$key."'>Next</button>";
													}
													elseif($key<$count){
														$data.="<button class='next_question btn btn-info' id='next' data='".$key."'>Next</button>";
													}
													elseif($key=$count){
														$data.="<button class='btn btn-success' onclick='click_submit();' id='submit_ass'>Submit</button>";
													}
														
													$data.="</div>
												</div>";
												
												$data.="</div>
											</div>";
										}
									}
									else if($instrumenttype['instrument_type']=='BEI_RATING_TWO'){
										$data.="<table width='100%' class='table '>";
										foreach($testdetails as $keys=>$testdetail){
											$key=$keys+1; 
											$var=($key==1)?"block":"";//<div style='display:".$var.";' id='question_list".$key."' class='open_question_div' >
											$data.="
												
												<tr><td>".$key."</td><td width='30%'>".$testdetail['ins_subpara_text']."
													<input type='hidden' id='question_".$key."' name='question[".$key."]'  value='".$testdetail['ins_subpara_id']."' >
													<input type='hidden' id='par_question_".$key."' name='par_question[".$key."]'  value='".$testdetail['ins_para_id']."' >
													<input type='hidden' name='qtype' id='qtype_". $key."' value=".$testdetail['instrument_type']." />
													<input type='hidden' name='testid' id='testid' value=".$testdetail['assess_test_id']." />
													<input type='hidden' name='instrument_id' id='instrument_id' value=".$testdetail['instrument_id']." />
													<input type='hidden' name='instrument_scale' id='instrument_scale' value=".$testdetail['instrument_scale']." />
														
												</td>";
													$ran='ORDER BY RAND()';
													$ss=UlsBeInsRatScaleValues::rating_value($testdetail['instrument_scale']);
													foreach($ss as $key1=>$sss){
														
														if(in_array($sss['ins_rat_scale_value_id'], $respvals)){ 
															$ched="checked='checked'"; } 
														else {  
															$ched=""; 
														}
														$data.="<td>
															<div class=''><label  for='truefalse'> <input type='radio'". $ched."  class='validate[".$valid."]' value='".$sss['ins_rat_scale_value_number']."' name='answer_".$key."[]' id='answer_".$key ."_".$key1."'> ".$sss['ins_rat_scale_value_name']."</label></div>
														</td>";
														
													}	
													$data.="<td width='30%'>".$testdetail['ins_subpara_text_ext']."</td>
												</tr>";
												
												
										}
										$data.="</table>";
										$data.="<div class='panel-footer borders' style='display:".$var.";padding: 6px 22px 40px;' id='question_button". $key."'>";
										$count=count($testdetails);
										$data.="<div class='pull-right'>
											<div class='btn-group'>";
											/* if($key==1){
												$data.="<button class='next_question btn btn-info' id='next' data='".$key."'>Next</button>";
											}
											elseif($key<$count){
												$data.="<button class='next_question btn btn-info' id='next' data='".$key."'>Next</button>";
											}
											else */
											if($key==$count){
												$data.="<button class='btn btn-success' onclick='click_submit();' id='submit_ass'>Submit</button>";
											}
											$data.="</div>";
											//</div>
											$data.="</div>";
									}
								}
								$data.="</div>
								
							</div>
						</div>
					
					</div>
				</div>
			</form></div>";
		$data.="";
		echo $data;	
	}
	
	public function insert_question_beh_answers()
	{
	    $question_id=$_REQUEST['ins_subpara_id'];
		$ins_para_id=$_REQUEST['ins_para_id'];
		$assess_test_id=$_REQUEST['assess_test_id'];
		$assessment_id=$_REQUEST['assessment_id'];
		$ans=$_REQUEST['ans'];
		$qtype=$_REQUEST['qtype'];
		$tid=$_REQUEST['instrument_id'];
		$teststatus='COM';
		$emp_id=isset($_SESSION['e_emp_id']) ? $_SESSION['e_emp_id'] : $_SESSION['emp_id'];
		$pass=0; $totscore=0; $wrongans=0;$correctans=0;
        $question_values=new UlsBeiQuestionsAssessment();
		$question_values->employee_id=$emp_id;
		$question_values->parent_org_id=$_SESSION['parent_org_id'];
		$question_values->instrument_id=$tid;
		$question_values->assessment_id=$assessment_id;
		$question_values->event_id=$assess_test_id;
		$question_values->test_type=$qtype;
		$question_values->status='COM';
		$question_values->user_test_question_id=$question_id;
		$question_values->ins_para_id=$ins_para_id;
		//$question_values->save();
		$corec="";
		$text="";
		$respid="";
		$text=$ans;
            
		$questions=new UlsBeiResponsesAssessment();
		$questions->utest_question_id=$question_values->id;
		$questions->parent_org_id=$_SESSION['parent_org_id'];
		$questions->employee_id=$emp_id;
		$questions->assessment_id=$assessment_id;
		$questions->user_test_question_id=$question_id;
		$questions->ins_para_id=$ins_para_id;
		$questions->test_type=$qtype;
		$questions->event_id=$assess_test_id;
		$questions->instrument_id=$tid;
		$questions->response_type_id=$qtype;
		$questions->answered_flag='';
		$questions->text=$text;
		//$questions->save();
		//echo $corec;
		echo $question_id;
    }
	
	public function employee_test_beh(){
		$this->sessionexist();
		if(isset($_SESSION['user_id'])){
			$this->pagedetails('admin','employee_test');
			$testtype=$_POST['ttype'];
			$emp_id=isset($_SESSION['e_emp_id']) ? $_SESSION['e_emp_id'] : $_SESSION['emp_id'];
			if(isset($_POST['instrument_id']) || isset($_POST['resume'] ) ){
				$eveid=$_POST['ass_test_id'];
				$tidss=$tid=$_POST['instrument_id'];
				//$testids=$_POST['testrespids'];
				$evalid=$_POST['assid'];
				$scaleid=$_POST['instrument_scale'];
				$teststatus=isset($_POST['resume'])?'RES':'COM';
				$qtvalus=Doctrine_Query::create()->select('id')->from('UlsBeiQuestionsAssessment')->where("instrument_id=".$tid." and event_id=".$eveid." and employee_id=".$emp_id." and test_type='".$_REQUEST['ttype']."' and assessment_id=".$evalid." and parent_org_id=".$_SESSION['parent_org_id'])->execute();
				if(count($qtvalus)>0){
					foreach($qtvalus as $qtvalue){
						if(!empty($qtvalue['id'])){
							$del=Doctrine_Query::Create()->Delete('UlsBeiResponsesAssessment')->where("utest_question_id=".$qtvalue['id'])->execute();
						}
					}
				}
				Doctrine_Query::create()->delete('UlsBeiQuestionsAssessment')->where("instrument_id=".$tid." and event_id=".$eveid." and assessment_id=".$evalid." and employee_id=".$emp_id." and test_type='".$_REQUEST['ttype']."' and parent_org_id=".$_SESSION['parent_org_id'])->execute();
				// Deletion Completed;
				// code for getting Version_number in UlsTestAttempts Table
				$attval=Doctrine_Query::Create()->select('version_number as atts,attempt_id')->from('UlsBeiAttemptsAssessment')->where("employee_id=".$emp_id." and event_id=".$eveid." and parent_org_id=".$_SESSION['parent_org_id']." and assessment_id=".$evalid."  and  test_type='".$_POST['ttype']."' and instrument_id=".$tid )->setHydrationMode(Doctrine::HYDRATE_ARRAY)->execute();
				if(count($attval)>0){ 
					//print_r($attval);
					foreach($attval as $attvals){
						$versionnum=$attvals['atts']+1;
						$qattempt=Doctrine_Core::getTable('UlsBeiAttemptsAssessment')->find($attvals['attempt_id']);
						$qattempt->status='I';
						$qattempt->save();
					}
				}
				else { $versionnum=1; }
				
				$pass=0; $totscore=0; $wrongans=0;$correctans=0;
				/* echo "<pre>";
				print_r($_POST); */
				foreach($_POST['question'] as $key=>$val){
					$ins_para_id=$_POST['par_question'][$key];
                    $anss='answer_'.$key;
                    $key0=$key-1;
                    $question_values=new UlsBeiQuestionsAssessment();
                    $question_values->employee_id=$emp_id;
                    $question_values->parent_org_id=$_SESSION['parent_org_id'];
                    $question_values->instrument_id=$tid;
					$question_values->assessment_id=$evalid;
                    $question_values->event_id=$eveid;
                    $question_values->test_type=$_POST['ttype'];  //we have to get it
                    $question_values->status=$teststatus;
                    $question_values->user_test_question_id=$val;
					$question_values->ins_para_id=$ins_para_id;
                    $question_values->save();
					$text="";
					$respid="";
					if(isset($_POST[$anss])){
						foreach($_POST[$anss] as $key_n=>$ans){
							$text=$ans;
							
						}
					} 
                    $questions=new UlsBeiResponsesAssessment();
                    $questions->utest_question_id=$question_values->id;
                    $questions->parent_org_id=$_SESSION['parent_org_id'];
                    $questions->employee_id=$emp_id;
                    $questions->assessment_id=$evalid;
                    $questions->user_test_question_id=$val;
					$questions->ins_para_id=$ins_para_id;
                    $questions->test_type=$_POST['ttype'];
                    $questions->event_id=$eveid;
					$questions->instrument_id=$tid;
					$questions->response_value_id=$val;
                    $questions->answered_flag='';
                    $questions->text=$text;
                    $questions->points=0;
                    $questions->save();
					
                }
            
				$atts_status='COM';
				$notificationdata=new UlsBeiAttemptsAssessment();
				$notificationdata->employee_id=$emp_id;
				$notificationdata->elearning_object_id=0;
				$notificationdata->event_id=$eveid;
				$notificationdata->assessment_id=$evalid;
				$notificationdata->parent_org_id=$_SESSION['parent_org_id'];
				$notificationdata->version_number=$versionnum;
				$notificationdata->status='A';
				$notificationdata->timestamp= date('Y-m-d h:i:s', time());
				$notificationdata->performance_source="";
				$notificationdata->attempt_status=$atts_status;
				$notificationdata->test_status=$teststatus;
				$notificationdata->timee=0;
				$notificationdata->instrument_id=$tid;
				$notificationdata->test_type=$_POST['ttype'];
				$notificationdata->internal_state="";
				$notificationdata->mastery_score=0;
				$notificationdata->save();
				$ass_details=UlsAssessmentTest::assessment_test_employee($eveid);
				$this->session->set_userdata('bint_comp',1);
				redirect("employee/employee_ass_complete?jid=".$_POST['jid']."&pro=BEHAVORIAL_INSTRUMENT&asstype=".$ass_details['assessment_type']."&assessment_id=".$ass_details['assessment_id']."&position_id=".$ass_details['position_id']."&assessment_pos_id=".$ass_details['assessment_pos_id']); 
				//redirect("employee/employee_assessment_details?jid=".$_POST['jid']."&pro=TEST&asstype=".$ass_details['assessment_type']."&assessment_id=".$ass_details['assessment_id']."&position_id=".$ass_details['position_id']."&assessment_pos_id=".$ass_details['assessment_pos_id']);
				
			}
		}
    }
	
	
	public function insert_question_answers()
	{
	    $question_id=$_REQUEST['question_id'];
		$testtype=$_REQUEST['type'];
		$assess_test_id=$_REQUEST['assess_test_id'];
		$assessment_id=$_REQUEST['assessment_id'];
		$ans=$_REQUEST['ans'];
		$qtype=$_REQUEST['qtype'];
		$tid=$_REQUEST['testid'];
		$skipv=$_REQUEST['skip_v'];
		$teststatus='COM';
		$ass_details=UlsAssessmentTest::test_details($assess_test_id);
		$testdeails=Doctrine_Core::getTable('UlsCompetencyTest')->findOneByTest_id($tid);
		$emp_id=isset($_SESSION['e_emp_id']) ? $_SESSION['e_emp_id'] : $_SESSION['emp_id'];
		$pass=0; $totscore=0; $wrongans=0;$correctans=0;
        $st=Doctrine_Core::getTable('UlsQuestions')->findOneByQuestion_id($question_id);
        $question_values=new UlsUtestQuestionsAssessment();
		$question_values->employee_id=$emp_id;
		$question_values->parent_org_id=$_SESSION['parent_org_id'];
		$question_values->test_id=$tid;
		$question_values->assessment_id=$assessment_id;
		$question_values->event_id=$assess_test_id;
		$question_values->test_type=$_REQUEST['type'];
		$question_values->status='COM';
		$question_values->user_test_question_id=$question_id;
		//$question_values->save();
		$corec="";
		$text="";
		$respid="";
		$checkalreadyteststarted=UlsMenu::callpdorow("select * from uls_utest_employee_question where test_id=$tid and ass_test_id=$assess_test_id and assessment_id=$assessment_id and question_id=$question_id and employee_id=$emp_id");
		if($ans=='undefined'){$ans="";}
		if(isset($checkalreadyteststarted['id'])){
			$empquesans=Doctrine_Core::getTable('UlsUtestEmployeeQuestion')->find($checkalreadyteststarted['id']);
			$empquesans->answer=!empty($ans)?$ans:NULL;
			$empquesans->save();
		}
		$que=Doctrine_Core::getTable('UlsQuestions')->findOneByQuestion_id($question_id);
		$resp=Doctrine_Core::getTable('UlsQuestionValues')->findOneByValue_id($ans);
            if($que->question_type=='F' || $que->question_type=='B' ||  $que->question_type=='FT' ){
                $resp=Doctrine_Core::getTable('UlsQuestionValues')->findOneByQuestion_id($question_id);
                $filtext=trim($resp->text);
				$actutext = preg_replace('/\s+/', '', $filtext);
				$low=strtolower($actutext);
				$rr=trim($ans);
				$enteredtext=preg_replace('/\s+/', '', $rr);
				$reslow=strtolower($enteredtext);
				$bb=strcmp($reslow,$low);
				$corec=($bb==0)? "C" : "W";
				$text=$ans;
				$respid=$resp->value_id;
            }
            else if($que->question_type=='M'){
			 $anss=explode(',',$ans);
			  foreach($anss as $ans){
			  $resp=Doctrine_Core::getTable('UlsQuestionValues')->findOneByValue_id($ans);
                if(empty($corec)){
					$text=$resp->text;
					$respid=!empty($ans)?$ans:"";
					$corec=($resp->correct_flag=='Y')?"C":'W';
                }
                else {
					$text=$text.",".$resp->text;
					$respid.=",".$ans;
					$corec.=($resp->correct_flag=='Y')?","."C":","."W";
                }
				}
            }
            else {
					$text=!empty($resp->text)?$resp->text:"";
					$respid=!empty($ans)?$ans:"";
					$corec=!empty($resp->correct_flag)?(($resp->correct_flag=='Y')?"C":'W'):'W';
            }
            if($que->question_type=='M'){ // get correct answers from multiple choice
                $cou=0;
                $getquesval=Doctrine_Query::create()->select("correct_flag as correct")->from('UlsQuestionValues')->where('parent_org_id='.$_SESSION['parent_org_id'].' and question_id='.$question_id.' and correct_flag="Y"')->execute();
                $countcorre=count($getquesval);
                $vv=explode(',',$corec); $givencount=count($vv);
                foreach( $vv as $vs){ if($vs=='C'){ $cou=$cou+1;} }
                    //echo "Given ans".$cou;
                        if($countcorre==$givencount){
                            $corec=($countcorre==$cou)?'C':'W';
                        }
						else {
						$corec='W';
						}
		    }
			$questions=new UlsUtestResponsesAssessment();
			$questions->utest_question_id=$question_values->id;
			$questions->parent_org_id=$_SESSION['parent_org_id'];
			$questions->employee_id=$emp_id;
			$questions->assessment_id=$assessment_id;
			$questions->user_test_question_id=$question_id;
			$questions->test_type=$_REQUEST['type'];
			$questions->response_value_id=$respid;
			$questions->event_id=$assess_test_id;
			$questions->response_type_id=$que->question_type;
			$questions->answered_flag='';
			$questions->text=$text;
			$questions->correct_flag=$corec;
			$questions->points=$st->points;
			//$questions->save();
			//echo $corec; 
            echo $skipv;
    }
	
	public function employee_test_casestudy(){
		$this->sessionexist();
		if(isset($_SESSION['user_id'])){
			$this->pagedetails('admin','employee_test');
			$testtype=$_POST['ttype'];
			$emp_id=isset($_SESSION['e_emp_id']) ? $_SESSION['e_emp_id'] : $_SESSION['emp_id'];
			if(isset($_POST['testid']) || isset($_POST['resume'] ) ){
				$eveid=$_POST['ass_test_id'];
				$tidss=$tid=$_POST['testid'];
				//$testids=$_POST['testrespids'];
				$evalid=$_POST['assid'];
				$teststatus=isset($_POST['resume'])?'RES':'COM';
				$testdeails=Doctrine_Core::getTable('UlsCompetencyTest')->findOneByTest_id($tid);
				// Deleting Previous Test Records
				$qtvalus=Doctrine_Query::create()->select('id')->from('UlsUtestQuestionsAssessment')->where("test_id=".$tid." and event_id=".$eveid." and employee_id=".$emp_id." and test_type='".$testtype."' and assessment_id=".$evalid." and parent_org_id=".$_SESSION['parent_org_id'])->execute();
				if(count($qtvalus)>0){
					foreach($qtvalus as $qtvalue){
						if(!empty($qtvalue['id'])){
							$del=Doctrine_Query::Create()->Delete('UlsUtestResponsesAssessment')->where("utest_question_id=".$qtvalue['id'])->execute();
						}
					}
				}
				Doctrine_Query::create()->delete('UlsUtestQuestionsAssessment')->where("test_id=".$tid." and event_id=".$eveid." and assessment_id=".$evalid." and employee_id=".$emp_id." and test_type='".$testtype."' and parent_org_id=".$_SESSION['parent_org_id'])->execute();
				// Deletion Completed;
				// code for getting Version_number in UlsTestAttempts Table
				$attval=Doctrine_Query::Create()->select('version_number as atts,attempt_id')->from('UlsUtestAttemptsAssessment')->where("employee_id=".$emp_id." and event_id=".$eveid." and parent_org_id=".$_SESSION['parent_org_id']." and assessment_id=".$evalid."  and  test_type='".$testtype."' and test_id=".$tid )->setHydrationMode(Doctrine::HYDRATE_ARRAY)->execute();
				if(count($attval)>0){ 
					//print_r($attval);
					foreach($attval as $attvals){
						$versionnum=$attvals['atts']+1;
						$qattempt=Doctrine_Core::getTable('UlsUtestAttemptsAssessment')->find($attvals['attempt_id']);
						$qattempt->status='I';
						$qattempt->save();
					}
				}
				else { $versionnum=1; }
				// $stat=isset($_POST['resume'])?'W':'C';
				//$stat_type='';
				$pass=0; $totscore=0; $wrongans=0;$correctans=0;
				foreach($_POST['question'] as $key=>$val){
                    $anss='answer_'.$key;
					$anss_lang='answer_lang_'.$key;
                    $key0=$key-1;
                    
                    $question_values=new UlsUtestQuestionsAssessment();
                    $question_values->employee_id=$emp_id;
                    $question_values->parent_org_id=$_SESSION['parent_org_id'];
                    $question_values->test_id=$tid;
					$question_values->assessment_id=$evalid;
                    $question_values->event_id=$eveid;
                    $question_values->test_type=$_POST['ttype'];  //we have to get it
                    $question_values->status=$teststatus;
                    $question_values->user_test_question_id=$val;
                    $question_values->save();
                    $corec="";
					$text="";
					$respid="";
                    if(isset($_POST[$anss])){
						foreach($_POST[$anss] as $key_n=>$ans){
							
								$rr=trim($ans);
								$text=$ans;
							
						}
					}
					$text_lang="";
					if(isset($_POST[$anss_lang])){
						foreach($_POST[$anss_lang] as $key_n=>$ans_lang){
							
								$rr=trim($ans_lang);
								$text_lang=$ans_lang;
							
						}
					} 
					
                    $questions=new UlsUtestResponsesAssessment();
                    $questions->utest_question_id=$question_values->id;
                    $questions->parent_org_id=$_SESSION['parent_org_id'];
                    $questions->employee_id=$emp_id;
                    $questions->assessment_id=$evalid;
                    $questions->user_test_question_id=$val;
                    $questions->test_type=$testtype;
                    $questions->response_value_id=$respid;
                    $questions->event_id=$eveid;
                    $questions->answered_flag='';
                    $questions->text=$text;
					$questions->text_lang=$text_lang;
                    $questions->correct_flag=$corec;
                    $questions->save();
                }
			
            $atts_status='COM';
			if(!empty($_FILES['casestudy_source_file']['name'])){
				$filename=str_replace(array(" ","'","&"),array("_","_","_"),$_FILES['casestudy_source_file']['name']);
			}
			else{
				$filename='';
			}
			$file_casestudy=$emp_id."_".$evalid."_".$eveid."_".$filename;
			$notificationdata=new UlsUtestAttemptsAssessment();
			$notificationdata->employee_id=$emp_id;
			$notificationdata->elearning_object_id=0;
			$notificationdata->event_id=$eveid;
			$notificationdata->assessment_id=$evalid;
			$notificationdata->parent_org_id=$_SESSION['parent_org_id'];
			$notificationdata->version_number=$versionnum;
			$notificationdata->status='A';
			$notificationdata->timestamp= date('Y-m-d h:i:s', time());
			$notificationdata->performance_source="";
			$notificationdata->attempt_status=$atts_status;
			$notificationdata->test_status=$teststatus;
			$notificationdata->timee=0;
			$notificationdata->test_id=$tidss;
			$notificationdata->test_type=$testtype;
			$notificationdata->internal_state="";
			$notificationdata->mastery_score=0;
			$notificationdata->start_period=date('Y-m-d h:i:s', strtotime($_POST['start_period']));
			$notificationdata->end_period=date('Y-m-d h:i:s');
			if(!empty($filename)){
				$notificationdata->inbasket_upload=$file_casestudy;
			}
			$notificationdata->save();
			
			if(!empty($_FILES['casestudy_source_file']['tmp_name'])){
				$uploaddir1= __SITE_PATH .DS.'public'.DS.'uploads'.DS.'employee_casestudy';
				if(is_dir($uploaddir1)){
					echo $target_path = $uploaddir1.DS. $file_casestudy;
					move_uploaded_file($_FILES['casestudy_source_file']['tmp_name'], $target_path);
				}
				
            }
			$this->session->set_userdata('case_comp',1);
			$ass_details=UlsAssessmentTest::assessment_test_employee($eveid);
			redirect("employee/employee_ass_complete?jid=".$_POST['jid']."&pro=CASE_STUDY&asstype=".$ass_details['assessment_type']."&assessment_id=".$ass_details['assessment_id']."&position_id=".$ass_details['position_id']."&assessment_pos_id=".$ass_details['assessment_pos_id']); 
			}
		}
    }
	
	public function employee_test(){
		$this->sessionexist();
		if(isset($_SESSION['user_id'])){
			$this->pagedetails('admin','employee_test');
			$testtype=$_POST['ttype'];
			$emp_id=isset($_SESSION['e_emp_id']) ? $_SESSION['e_emp_id'] : $_SESSION['emp_id'];
			if(isset($_POST['testid']) || isset($_POST['resume'] ) ){
				$eveid=$_POST['ass_test_id'];
				$tidss=$tid=$_POST['testid'];
				//$testids=$_POST['testrespids'];
				$evalid=$_POST['assid'];
				$teststatus=isset($_POST['resume'])?'RES':'COM';
				$testdeails=Doctrine_Core::getTable('UlsCompetencyTest')->findOneByTest_id($tid);
				// Deleting Previous Test Records
				$qtvalus=Doctrine_Query::create()->select('id')->from('UlsUtestQuestionsAssessment')->where("test_id=".$tid." and event_id=".$eveid." and employee_id=".$emp_id." and test_type='".$testtype."' and assessment_id=".$evalid." and parent_org_id=".$_SESSION['parent_org_id'])->execute();
				if(count($qtvalus)>0){
					foreach($qtvalus as $qtvalue){
						if(!empty($qtvalue['id'])){
							$del=Doctrine_Query::Create()->Delete('UlsUtestResponsesAssessment')->where("utest_question_id=".$qtvalue['id'])->execute();
						}
					}
				}
				Doctrine_Query::create()->delete('UlsUtestQuestionsAssessment')->where("test_id=".$tid." and event_id=".$eveid." and assessment_id=".$evalid." and employee_id=".$emp_id." and test_type='".$testtype."' and parent_org_id=".$_SESSION['parent_org_id'])->execute();
				// Deletion Completed;
				// code for getting Version_number in UlsTestAttempts Table
				$attval=Doctrine_Query::Create()->select('version_number as atts,attempt_id')->from('UlsUtestAttemptsAssessment')->where("employee_id=".$emp_id." and event_id=".$eveid." and parent_org_id=".$_SESSION['parent_org_id']." and assessment_id=".$evalid."  and  test_type='".$testtype."' and test_id=".$tid )->setHydrationMode(Doctrine::HYDRATE_ARRAY)->execute();
				if(count($attval)>0){ 
					//print_r($attval);
					foreach($attval as $attvals){
						$versionnum=$attvals['atts']+1;
						$qattempt=Doctrine_Core::getTable('UlsUtestAttemptsAssessment')->find($attvals['attempt_id']);
						$qattempt->status='I';
						$qattempt->save();
					}
				}
				else { $versionnum=1; }
				// $stat=isset($_POST['resume'])?'W':'C';
				//$stat_type='';
				$pass=0; $totscore=0; $wrongans=0;$correctans=0;
				foreach($_POST['question'] as $key=>$val){
                    $anss='answer_'.$key;
                    $key0=$key-1;
                    $st=Doctrine_Core::getTable('UlsQuestions')->findOneByQuestion_id($val);
                    $question_values=new UlsUtestQuestionsAssessment();
                    $question_values->employee_id=$emp_id;
                    $question_values->parent_org_id=$_SESSION['parent_org_id'];
                    $question_values->test_id=$tid;
					$question_values->assessment_id=$evalid;
                    $question_values->event_id=$eveid;
                    $question_values->test_type=$testtype;  //we have to get it
                    $question_values->status=$teststatus;
                    $question_values->user_test_question_id=$val;
                    $question_values->save();
                    $corec="";
					$text="";
					$respid="";
                    $que=Doctrine_Core::getTable('UlsQuestions')->findOneByQuestion_id($val);
                    if(isset($_POST[$anss])){
						foreach($_POST[$anss] as $key_n=>$ans){
							$resp=Doctrine_Core::getTable('UlsQuestionValues')->findOneByValue_id($ans);
							if($que->question_type=='F' || $que->question_type=='B' ||  $que->question_type=='FT' ){
								$resp=Doctrine_Core::getTable('UlsQuestionValues')->findOneByQuestion_id($val);
								$filtext=trim($resp->text);
								$actutext = preg_replace('/\s+/', '', $filtext);
								$low=strtolower($actutext);
								$rr=trim($ans);
								$enteredtext=preg_replace('/\s+/', '', $rr);
								$reslow=strtolower($enteredtext);
								$bb=strcmp($reslow,$low);
								$corec=($bb==0)? "C" : "W";
								$text=$ans;
								$respid=$resp->value_id;
							}
							else if($que->question_type=='P'){
								$anss_content=$_POST['answer_text'.$ans];
								$anss_action=$_POST['intray_action'.$ans];
								$results[]= array('id' => $ans, 'text' => $anss_content,'action' => $anss_action);
								$output = ($results);
								if($key_n==0){
									$texts=$output;
									$respid=$ans;
								}
								else {
									$texts=$output;
									$respid.=",".$ans;
								}
							}
                            else if($que->question_type=='M'){
								if(empty($corec)){
									$text=$resp->text;
									$respid=$ans;
									$corec=($resp->correct_flag=='Y')?"C":'W';
								}
								else {
									$text=$text.",".$resp->text;
									$respid.=",".$ans;
									$corec.=($resp->correct_flag=='Y')?","."C":","."W";
								}
                            }
							
							else{
                                $text=$resp->text;
                                $respid=$ans;
                                $corec=($resp->correct_flag=='Y')?"C":'W';
                            }
						}
					} 
					//print_r(json_encode($output));
					// End of TestResponces For Loop
					if($que->question_type=='M'){ // get correct answers from multiple choice
						$cou=0;
						$getquesval=Doctrine_Query::create()->select("correct_flag as correct")->from('UlsQuestionValues')->where('parent_org_id='.$_SESSION['parent_org_id'].' and question_id='.$val.' and correct_flag="Y"')->execute();
						//echo "correct ans".$countcorre=count($getquesval);
						$vv=explode(',',$corec); $givencount=count($vv);
						foreach( $vv as $vs){ if($vs=='C'){ $cou=$cou+1;} }
						//echo "Given ans".$cou;
						if($countcorre==$givencount){
							$corec=($countcorre==$cou)?'C':'W';
						}else { $corec='W';}
					}
					if($que->question_type=='P'){
						$text=json_encode($texts);
					}
                    $questions=new UlsUtestResponsesAssessment();
                    $questions->utest_question_id=$question_values->id;
                    $questions->parent_org_id=$_SESSION['parent_org_id'];
                    $questions->employee_id=$emp_id;
                    $questions->assessment_id=$evalid;
                    $questions->user_test_question_id=$val;
                    $questions->test_type=$testtype;
                    $questions->response_value_id=$respid;
                    $questions->event_id=$eveid;
                    $questions->response_type_id=$que->question_type;
                    $questions->answered_flag='';
                    $questions->text=$text;
                    $questions->correct_flag=$corec;
                    $questions->points=$st->points;
                    $questions->save();
					if($que->question_type!='FT'){
						if($corec=='C' || $corec=='W' ||  $corec==''){
                            if($corec=='C'){  $pass=$pass+$st->points;  $correctans=$correctans+1; }
                            else if($corec=='W' || $corec==''){  $wrongans=$wrongans+1; }
							$totscore=$totscore+$st->points;
						}
                    }
                } // End of Questions for Loop
//            }
//         }
//    }     //  echo "pass score-".$pass."<br />";
            if($pass!=0){ $attsmarks=($pass/$totscore)*100; } else { $attsmarks=0; }
			
            $atts_status='COM';
			$notificationdata=new UlsUtestAttemptsAssessment();
			$notificationdata->employee_id=$emp_id;
			$notificationdata->elearning_object_id=0;
			$notificationdata->event_id=$eveid;
			$notificationdata->assessment_id=$evalid;
			$notificationdata->parent_org_id=$_SESSION['parent_org_id'];
			$notificationdata->version_number=$versionnum;
			$notificationdata->status='A';
			$notificationdata->timestamp= date('Y-m-d h:i:s', time());
			$notificationdata->performance_source="";
			$notificationdata->attempt_status=$atts_status;
			$notificationdata->test_status=$teststatus;
			$notificationdata->score=$pass;
			$notificationdata->correct_ans=$correctans;
			$notificationdata->wrong_ans=$wrongans;
			$notificationdata->timee=0;
			$notificationdata->test_id=$tidss;
			$notificationdata->test_type=$testtype;
			$notificationdata->internal_state="";
			$notificationdata->mastery_score=0;
			$notificationdata->start_period=date('Y-m-d h:i:s', strtotime($_POST['start_period']));
			$notificationdata->end_period=date('Y-m-d h:i:s');
			$notificationdata->save();
			$ass_details=UlsAssessmentTest::assessment_test_employee($eveid);
			
			redirect("employee/employee_ass_complete?jid=".$_POST['jid']."&pro=TEST&asstype=".$ass_details['assessment_type']."&assessment_id=".$ass_details['assessment_id']."&position_id=".$ass_details['position_id']."&assessment_pos_id=".$ass_details['assessment_pos_id']);
			}
		} 
    }
	
	public function employee_ass_complete(){
		$this->sessionexist();	
		$data=array();
		$data['menu']="index";
		$content = $this->load->view('employee/employee_test_complete',$data,true);
		$this->render('layouts/employee_assessment',$content);	
	}
	
	public function employee_feed_complete(){
		$this->sessionexist();	
		$data=array();
		$data['menu']="index";
		$content = $this->load->view('employee/employee_feed_complete',$data,true);
		$this->render('layouts/employee_assessment',$content);	
	}
	
	public function employee_feedback_details(){
		$this->sessionexist();	
		$data=array();
		$data['menu']="index";
		$data['ass_test']=UlsAssessmentTest::assessment_testemp($_REQUEST['assessment_id'],$_REQUEST['position_id']);
		$content = $this->load->view('employee/employee_feedback_details',$data,true);
		$this->render('layouts/employee_assessment',$content);	
	}
	
	public function employee_feedback_insert(){
		if(isset($_POST['assessment_id'])){
			$work_activation=(!empty($_POST['feed_id']))?Doctrine::getTable('UlsAssessmentFeedbackEmployees')->find($_POST['feed_id']):new UlsAssessmentFeedbackEmployees;
			$work_activation->assessment_id=$_POST['assessment_id'];
			$work_activation->position_id=$_POST['position_id'];
			$work_activation->Q1=!empty($_POST['Q1'])?$_POST['Q1']:NULL;
			$work_activation->Q21=!empty($_POST['Q21'])?$_POST['Q21']:NULL;
			$work_activation->Q22 =!empty($_POST['Q22'])?$_POST['Q22']:NULL;
			$work_activation->Q23=!empty($_POST['Q23'])?$_POST['Q23']:NULL;
			$work_activation->Q24=!empty($_POST['Q24'])?$_POST['Q24']:NULL;
			$work_activation->Q25=!empty($_POST['Q25'])?$_POST['Q25']:NULL;
			$work_activation->Q3=!empty($_POST['Q3'])?$_POST['Q3']:NULL;
			$work_activation->Q4=!empty($_POST['Q4'])?$_POST['Q4']:NULL;
			$work_activation->employee_id=$_SESSION['emp_id'];
			$work_activation->status='A';
			$work_activation->save();
			$enroll=(!empty($_POST['jid']))?Doctrine_Core::getTable('UlsAssessmentEmployeeJourney')->find($_POST['jid']): new UlsAssessmentEmployeeJourney();
			$enroll->status='C';
			$enroll->save();
			$update=Doctrine_Query::create()->update('UlsAssessmentEmployees');
			$update->set('status','?','A');
			$update->where('assessment_id=?',$_POST['assessment_id']);
			$update->andwhere('position_id=?',$_POST['position_id']);
			$update->andwhere('employee_id=?',$_POST['employee_id']);
			$update->limit(1)->execute();
			$emp_mobile=UlsEmployeeMaster::fetch_emp_grade_per($_SESSION['emp_id']);
			$msg="".$emp_mobile['full_name']." @ ".$emp_mobile['location_name']." has completed the On-Line Competency Assesssment";
			$mob1="9764190666";
			$mob2="9160060494";
			
			if(!empty($emp_mobile['office_number'])){
				$mob=$mob1.",".$mob2.",".$emp_mobile['office_number'];
			}
			else{
				$mob=$mob1.",".$mob2;
			}
			
			$user_mobile=explode(',',$mob);
			//print_r($user_mobile);
			foreach($user_mobile as $k=>$user_mob){
				$this->textmessage($user_mob,$msg);
			}
			
			redirect("employee/employee_feed_complete?jid=".$_POST['jid']."&pro=INBASKET&asstype=".$_POST['asstype']."&assessment_id=".$_POST['assessment_id']."&position_id=".$_POST['position_id']."&assessment_pos_id=".$_POST['assessment_pos_id']);
		}
	}
	
	public function textmessage($mobile,$msg){
		//print_r($mobile);
		//exit();
		$message = $msg;
		$response_type = 'json';
		$route = "4";
		$postData = array(
						'authkey' => MSG91_AUTH_KEY,
						'mobiles' => $mobile,
						'message' => $message,
						'sender' => MSG91_SENDER_ID,
						'route' => $route,
						'response' => $response_type
		);
		//API URL
		$url = "https://control.msg91.com/sendhttp.php";
		
		// init the resource
		$ch = curl_init();
		curl_setopt_array($ch, array(
						CURLOPT_URL => $url,
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_POST => true,
						CURLOPT_POSTFIELDS => $postData
						//,CURLOPT_FOLLOWLOCATION => true
		));
		
		//Ignore SSL certificate verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		
		//get response
		$output = curl_exec($ch);

		//Print error if any
		if (curl_errno($ch)) {
						echo 'error:' . curl_error($ch);
		}

		curl_close($ch);
		
	}
	
	public function employee_feedback_skip(){
		if(isset($_REQUEST['assessment_id'])){
			$work_activation=(!empty($_REQUEST['feed_id']))?Doctrine::getTable('UlsAssessmentFeedbackEmployees')->find($_REQUEST['feed_id']):new UlsAssessmentFeedbackEmployees;
			$work_activation->assessment_id=$_REQUEST['assessment_id'];
			$work_activation->position_id=$_REQUEST['position_id'];
			$work_activation->employee_id=$_SESSION['emp_id'];
			$work_activation->status='R';
			$work_activation->save();
			$enroll=(!empty($_REQUEST['jid']))?Doctrine_Core::getTable('UlsAssessmentEmployeeJourney')->find($_REQUEST['jid']): new UlsAssessmentEmployeeJourney();
			$enroll->status='C';
			$enroll->save();
			
		}
	}
	
	public function inbasket_test_details(){
		$in_id=$_REQUEST['inbasket_id'];
		$data="";
		$compdetails=UlsInbasketMaster::viewinbasket($in_id);
		$data.="Inbasket Name: <h3>".@$compdetails['inbasket_name']."</h3>
		<p>Why it is used: ".@$compdetails['inbasket_why_used']."</p>
		<p>Who will be using it: ".@$compdetails['inbasket_will_using']."</p>
		<p>Narration: ".@$compdetails['inbasket_narration']."</p>";
		if(!empty($compdetails['inbasket_upload'])){ 
		$data.="<p>Link: <a href='".BASE_URL."/public/uploads/inbasket/".$compdetails['inbasket_id']."/".$compdetails['inbasket_upload']."' target='_blank' >Click Here</a></p>";
		}
		$data.="<p>Status: ".@$compdetails['inbasketstatus']."</p>
		<p>".@$compdetails['inbasket_description']."</p>";
		echo $data;
	}
	
	public function casestudy_test_details(){
		$in_id=$_REQUEST['casestudy_id'];
		$data="";
		$compdetails=UlsCaseStudyMaster::viewcasestudy($in_id);
		$data.="<h3>Inbasket Name: ".@$compdetails['casestudy_name']."</h3>
		<p>Author: ".@$compdetails['casestudy_author']."</p>
		<p>Source: ".@$compdetails['casestudy_source']."</p>";
		if(!empty($compdetails['casestudy_link'])){ 
		$data.="<p>Link: <a href='".BASE_URL."/public/uploads/inbasket/".$compdetails['casestudy_id']."/".$compdetails['casestudy_link']."' target='_blank' >Click Here</a></p>";
		}
		$data.="<p>Status: ".@$compdetails['casestatus']."</p>
		<p>".@$compdetails['casestudy_description']."</p>";
		echo $data;
	}
	
	
	public function getemp_test_casestudy(){
		$testype="'".$_REQUEST['type']."'";
		$ass_id=$_REQUEST['ass_id'];
        $ass_test_id=$_REQUEST['id'];
		$test_id=$_REQUEST['test_id'];
		$casestudy_id=$_REQUEST['ins_id'];
		$emp_id=isset($_SESSION['e_emp_id']) ? $_SESSION['e_emp_id'] : $_SESSION['emp_id'] ;
        $testval=UlsAssessmentEmployees::getfeedback_attempts($ass_test_id,$ass_id,$testype,$test_id); //getting attempts from UlsTesAttempts Table
		$ass_test=UlsAssessmentTest::test_details($ass_test_id);
        $testd=UlsUtestResponsesAssessment::get_test_details($test_id);   
        $testdetails=UlsUtestResponsesAssessment::get_test_view_detail_casestudy($test_id,$ass_test_id,$ass_id);
		$case_details=UlsCaseStudyMaster::viewcasestudy($casestudy_id);
		$act=!empty($compdetails['casestudy_source'])?"":"display:none";
		$act2=!empty($compdetails['casestudy_source'])?"display:none":"";
		$respvals=array();
		$data="";
		$data.="
		<form action='".BASE_URL."/employee/employee_test_casestudy' method='post' name='employeeTest' id='employeeTest' enctype='multipart/form-data'>
		<input type='hidden' name='testid' id='testid' value=".$test_id." />
		<input type='hidden' name='assid' id='assid' value=".$ass_id." />
		<input type='hidden' name='empid' id='empid' value=".$emp_id." />
		<input type='hidden' name='ttype' id='ttype' value=".$testype." /> <br />
		<input type='hidden' name='ass_test_id' id='ass_test_id' value=".$ass_test_id." />
		<input type='hidden' name='timeconsume' id='timeconsume' value='".$ass_test['time_details']."' />
		<div class='modal-header'>
			<h4 class='modal-title'>".$_REQUEST['type']."</h4>
		</div>
		<div class='modal-body'>
			<div class='row'>
				<div class='col-md-6'>
					<div class='hpanel'>
						<div class='panel-body'>
							<div class='tab-content'>
								<div id='note1' class='tab-pane active'>
									<div class='pull-right text-muted m-l-lg'>
										<label id='testtime' style='width:auto' >".$ass_test['time_details']." </label>Minute(s).
									</div>
									<h7><b>".$case_details['casestudy_name']."</b></h7>
									<hr>
									<div class='note-content'>
										<div id='casedesc' class='form-control' style='height:345px;overflow:auto;$act2'>".$case_details['casestudy_description']."
										</div>";
										if(!empty($case_details['casestudy_source'])){
										//$data.="<div id='casepdf' class='form-control' style='height:345px;overflow:hide; display:none'><iframe src='".BASE_URL."/public/webpdf/web/viewer.php?id=uploads/casestudy/".$casestudy_id."/".$case_details['casestudy_source']."' height='345px' width='100%'></iframe></div>";
										$data.="<div id='casepdf' class='form-control' style='height:345px;overflow:hide;margin:0px;padding:0px; $act'><iframe src='https://drive.google.com/viewerng/viewer?url=".BASE_URL."/public/uploads/casestudy/".$casestudy_id."/".$case_details['casestudy_source']."?pid=explorer&efh=false&a=v&chrome=false&embedded=true' height='345px' width='100%'></iframe></div>";
										}
									$data.="</div>
									<div class='btn-group'>
										<button onclick='opendesc()' class='btn btn-info' type='button'>View Description</button>";
										if(!empty($case_details['casestudy_source'])){
										$data.="<button onclick='openpdf()' class='btn btn-success' type='button'>View PDF</button>";
										}
									$data.="</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class='col-md-6'>
					<br>
					<h7><b>".$_REQUEST['type']." Questions</b></h7>
					<hr>
					<div class='hpanel panel-group'>
						<!--<div class='panel-body'>
							<div class='text-center text-muted font-bold'>".$_REQUEST['type']." Questions</div>

						</div>
						<div class='panel-section'>

							<div class='input-group'>";
							if(count($testdetails)>0){
								foreach($testdetails as $key=>$testdetailss){
									$ke=$key+1;
									$data.="<a href='#' id='open_skip_question".$testdetailss['question_id']."'><button class='btn question_color".$testdetailss['question_id']." btn-circle' type='button'>".$ke."</button></a>
									<input type='hidden' id='skipvalue".$ke."' value=''>";
								}
							}
							$data.="</div>
							
						</div>-->

						<div id='notes' class='collapse in'>
							<div class=''>
								<div class='hpanel'>";
								$valid='required';
								if(count($testdetails)>0){
									foreach($testdetails as $keys=>$testdetail){
										$key=$keys+1; 
										$var=($key==1)?"block":"none";
										
										$data.="<div style='display:".$var.";?>' id='question_list".$key."' class='open_question_div' >
											<div class='panel-heading hbuilt'>
												<span style='float:left;'><button class='btn btn-danger btn-icon-anim btn-circle'>".$key."</button>&nbsp;&nbsp; </span> ".$testdetail['casestudy_quest']."
												<input type='hidden' id='question_".$key."' name='question[".$key."]'  value='".$testdetail['question_id']."' >
												<input type='hidden' name='qtype' id='qtype_". $key."' value='FT' />
												<input type='hidden' name='testid' id='testid' value=".$test_id." />
												<input type='hidden' name='inb_assess_test_id' id='inb_assess_test_id' value=".$casestudy_id." />
											</div>
											<div class='panel-body no-padding'>";
												$data.="<ul  class='list-group'>";
												//$valuename=Doctrine_Query::Create()->from("UlsUtestResponsesAssessment")->where("employee_id=".$emp_id." and test_type=".$testype." and event_id=".$ass_test_id." and  assessment_id=".$ass_id." and user_test_question_id=".$testdetails['question_id'])->fetchOne();
												//$ched=!empty($valuename->text)?$valuename->text:"";

												//$valuename=Doctrine_Query::Create()->from("UlsUtestResponsesAssessment")->where("employee_id=".$emp_id." and test_type=".$testype." and event_id=".$ass_test_id." and  assessment_id=".$ass_id)->fetchOne();

												
												$valuename=UlsMenu::callpdorow("SELECT * FROM `uls_utest_responses_assessment` where utest_question_id in (SELECT `id` FROM `uls_utest_questions_assessment` where `employee_id`=".$emp_id." and `assessment_id`=".$ass_id." and `test_id`=".$test_id." and `test_type`=".$testype." and event_id=".$ass_test_id." and user_test_question_id=".$testdetail['question_id'].")");
												
												$ched=isset($valuename->text)?$valuename->text:"";
												
												$data.="<li class=''>
													&emsp;<textarea style='resize:none;width:490px;height:170px;' name='answer_".$key."[]' class='validate[".$valid."] mediumtexta' id='answer_".$key."'> ". $ched."</textarea>";
													
												$data.="</li>";
																							
												$data.="</ul>
											</div>";
											$count=count($testdetails);
											if($key==$count){
												//validate[".$valid."]
												$data.="<div class='form-group col-lg-6' style='display:".$var.";' id='question_upload". $key."'>
													<label class='control-label mb-10 text-left'>Upload Casestudy</label>
													<input type='file' name='casestudy_source_file' class=''>
												</div><div class='seprator-block'></div>";
											}	
											$data.="<div class='panel-footer borders' style='display:".$var.";padding: 6px 22px 40px;' id='question_button". $key."'>";
											
												
												$data.="<div class='pull-right'>
													<div class='btn-group'>";
													
													if($key<$count){
														$data.="<button class='next_question btn btn-info' id='next' data='".$key."'>Next</button>";
													}
													elseif($key=$count){
														$data.="<button class='btn btn-success' id='submit_ass'>Submit</button>";
													}
														
													$data.="</div>
												</div>";
											
											$data.="</div>
										</div>";
									}
								}
								$data.="</div>
								
							</div>
							

						</div>
					</div>
				</div>
			</div>
		</div>
	</form>";
	echo $data;
	}
	
	public function getemp_test_inbasket(){
		$testype="'".$_REQUEST['type']."'";
		$ass_id=$_REQUEST['ass_id'];
        $ass_test_id=$_REQUEST['id'];
		$test_id=$_REQUEST['test_id'];
		$inbasket_id=$_REQUEST['ins_id'];
		$emp_id=isset($_SESSION['e_emp_id']) ? $_SESSION['e_emp_id'] : $_SESSION['emp_id'] ;
        $testval=UlsAssessmentEmployees::getfeedback_attempts($ass_test_id,$ass_id,$testype,$test_id); //getting attempts from UlsTesAttempts Table
		$ass_test=UlsAssessmentTest::test_details($ass_test_id);
        $testd=UlsUtestResponsesAssessment::get_test_details($test_id);   
        $testdetails=UlsUtestResponsesAssessment::get_test_view_details($test_id,$ass_test_id,$ass_id);
		$inbasket_details=UlsInbasketMaster::viewinbasket($inbasket_id);
		$respvals=array();
		$act=!empty($inbasket_details['inbasket_upload'])?"":"display:none";
		$act2=!empty($inbasket_details['inbasket_upload'])?"display:none":"";
		$act3=!empty($inbasket_details['inbasket_instructions'])?"display:block":"";
		$data="";
		$data.="
		<form action='".BASE_URL."/employee/employee_test' method='post' name='employeeTest' id='employeeTest'>
		<input type='hidden' name='start_period' id='start_period' value='' />
		<input type='hidden' name='testid' id='testid' value=".$test_id." />
		<input type='hidden' name='assid' id='assid' value=".$ass_id." />
		<input type='hidden' name='empid' id='empid' value=".$emp_id." />
		<input type='hidden' name='ttype' id='ttype' value=".$testype." /> <br />
		<input type='hidden' name='ass_test_id' id='ass_test_id' value=".$ass_test_id." />
		<input type='hidden' name='timeconsume' id='timeconsume' value='".$ass_test['time_details']."' />
		<div class='modal-header'>
			<h4 class='modal-title'>".$_REQUEST['type']."</h4>
		</div>
		<div class='modal-body'>
			<div class='row'>
				<div class='col-md-6'>
					<div class='hpanel'>
						<div class='panel-body'>
							<div class='tab-content'>
								<div id='note1' class='tab-pane active'>
									<div class='pull-right text-muted m-l-lg'>
										<label id='testtime' style='width:auto' >".$inbasket_details['inbasket_time_period']." </label>Minute(s).
									</div>
									<h3><b>Intray Exercises</b></h3>
									<hr>
									<div class='note-content'>
										<div id='casedesc' class='form-control' style='height:auto;overflow:auto;line-height:30px;$act3'>
										<h6 class='panel-title'>How to do the Inbasket</h6>
										<br>
										".nl2br($inbasket_details['inbasket_instructions'])."
										</div>";
										if(!empty($inbasket_details['inbasket_upload'])){
										//$data.="<div id='casepdf' class='form-control' style='height:345px;overflow:hide; display:none'><iframe src='".BASE_URL."/public/webpdf/web/viewer.php?id=uploads/inbasket/".$inbasket_id."/".$inbasket_details['inbasket_upload']."' height='345px' width='100%'></iframe></div>";
										$data.="<div id='casepdf' class='form-control' style='height:400px;overflow:hide;margin:0px;padding:0px; $act'><iframe src='https://drive.google.com/viewerng/viewer?url=".BASE_URL."/public/uploads/inbasket/".$inbasket_id."/".$inbasket_details['inbasket_upload']."?pid=explorer&efh=false&a=v&chrome=false&embedded=true' height='390px' width='100%'></iframe></div>";
										}
										$data.="<div id='intray' style='display:none;'><link rel='stylesheet' href='https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'><style>.ui-widget.ui-widget-content {border: 1px solid #c5c5c5;border-bottom-right-radius: 3px;}
										.ui-widget-header {border: 1px solid #dddddd;background: #e9e9e9;color: #333333;font-weight: bold;}
										.ui-state-default{border:0px;background: #fff;}
										.ui-widget-content {border: 1px solid #dddddd;background: #ffffff;color: #333333;}
										.column { list-style-type: none; margin: 0; padding: 0; width: 60%;}
										.portlet{margin: 0 1em 1em 0;padding: 0.3em;}
										.portlet-header {padding: 0.2em 0.3em;margin-bottom: 0.5em;position: relative;border: 1px solid #dddddd;background: #e9e9e9;color: #333333;font-weight: bold;}
										.portlet-toggle {position: absolute;top: 50%;right: 0;margin-top: -8px;}
										.portlet-content {padding: 0.4em;}
										.portlet-placeholder {border: 1px dotted black;margin: 0 1em 1em 0;height: 50px;}</style>
										
										";
										if(count($testdetails)>0){
											foreach($testdetails as $keys=>$testdetail){
											$key=$keys+1; 
											$type=$testdetail['question_type'];
											$data.="<ul class=''>";
												$ran='ORDER BY RAND()';$j=0;
												$ss=UlsAssessmentTest::test_question_value($testdetail['question_id'],$ran);
												foreach($ss as $key1=>$sss){
													if($type=='P'){ $j++;
														$parsed_json="";
														if(!empty($sss['inbasket_mode'])){												
															$parsed_json = json_decode($sss['inbasket_mode'], true);
														}
														$data.="<li class='ui-state-default'>
															<div class='portlet'>
															
																<div class='portlet-header'><span class='ui-icon ui-icon-arrowthick-2-n-s'></span> Intray $j</div>
																<div class='portlet-content'>";
																	if(!empty($parsed_json)){
																		foreach($parsed_json as $key => $value)
																		{
																			$yes_stat="IN_MODE";
																			$val_code=UlsAdminMaster::get_value_name_statuss($yes_stat,$value['mode']);
																		$data.="
																		   <p><code>Mode:</code>".$val_code['name']."</p>
																		   <p><code>Time:</code>".$value['period']."</p>
																		   <p><code>From:</code>".$value['from']."</p>";
																		}
																	}
																	//$data.="<label  for='truefalse'> ".str_replace(array("\\\\","\\r\\n"),array("\\","<br>"),$sss['text'])."</label> 
																	$data.="<p><label  for='truefalse'> ".nl2br($sss['text'])."</label> </p>
																</div>
															</div>
														</li>";
													}
												}
											$data.="</ul>";
											}
										}
										$data.="</div>
									</div>
									<div class='button-list mt-25'>
										<button type='button' onclick='opendesc()' class='btn btn-primary'>View Description</button>";
										if(!empty($inbasket_details['inbasket_upload'])){
											$data.="<button type='button' class='btn  btn-info' onclick='openpdf()'>View PDF</button>";
										}
										$data.="
										<button type='button' class='btn  btn-success' onclick='openintray()'>View Intray</button>
										
									</div>
									
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class='col-md-6'>
					<br>
					
					<h3 id='casenarrations'><b>Inbasket Background</b></h3>
					<div id='intray_elementss' style='display:none'>
					<div class='pull-right text-muted m-l-lg'>
						<div id='countdown'></div>
					</div>
					<h5><b>Time Taken</b></h5>
					<br>
					<h3><b>Your Prioritization</b></h3>
					
					</div>
					<hr>
					<div class='hpanel panel-group'>
						<div id='notes' class='collapse in'>
							<div class=''>
								<div class='hpanel'>
								<div id='casenarration' class='form-control' style='height:auto;overflow:auto;line-height:30px;$act2'>
								".nl2br($inbasket_details['inbasket_narration'])."
								</div>
								<div id='intray_elements' style='display:none'>";
								$valid='required';
								if(count($testdetails)>0){
									foreach($testdetails as $keys=>$testdetail){
										$key=$keys+1; 
										$type=$testdetail['question_type'];
										$var=($key==1)?"block":"none";
										$data.="<div style='display:".$var.";?>' id='question_list".$key."' class='open_question_div' >
											<input type='hidden' id='question_".$key."' name='question[".$key."]'  value='".$testdetail['question_id']."' >
											<input type='hidden' name='qtype' id='qtype_". $key."' value=".$type." />
											<input type='hidden' name='testid' id='testid' value=".$test_id." />
											<input type='hidden' name='inb_assess_test_id' id='inb_assess_test_id' value=".$inbasket_id." />
											<div class=''>";
											$scort=($type=='P')?'sortable':'';
												$data.="<link rel='stylesheet' href='https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'><style>.ui-widget.ui-widget-content {border: 1px solid #c5c5c5;border-bottom-right-radius: 3px;}
	.ui-widget-header {border: 1px solid #dddddd;background: #e9e9e9;color: #333333;font-weight: bold;}
	.ui-state-default{border:0px;background: #fff;}
	.ui-widget-content {border: 1px solid #dddddd;background: #ffffff;color: #333333;}
	.column { list-style-type: none; margin: 0; padding: 0; width: 60%;}
	.portlet{margin: 0 1em 1em 0;padding: 0.3em;}
	.portlet-header {padding: 0.2em 0.3em;margin-bottom: 0.5em;position: relative;border: 1px solid #dddddd;background: #e9e9e9;color: #333333;font-weight: bold;}
	.portlet-toggle {position: absolute;top: 50%;right: 0;margin-top: -8px;}
	.portlet-content {padding: 0.4em;}
	.portlet-placeholder {border: 1px dotted black;margin: 0 1em 1em 0;height: 50px;}</style><ul id='".$scort."' class=''>";
												$ran='ORDER BY RAND()';$j=0;
												$ss=UlsAssessmentTest::test_question_value($testdetail['question_id'],$ran);
												foreach($ss as $key1=>$sss){
													if($type=='P'){ $j++; 
														if(in_array($sss['value_id'],$respvals)){				
														$valuename=Doctrine_Query::Create()->from("UlsUtestResponsesAssessment")->where("response_value_id=".$sss['value_id']." and employee_id=".$emp_id." and test_type=".$testype." and event_id=".$ass_test_id." and  assessment_id=".$ass_id)->fetchOne();
														$ched=$valuename->text;
														}
														else {  $ched=""; }
														$data.="<li class='ui-state-default'>
																	<div class='portlet'>
																		<div class='portlet-header'><span class='ui-icon ui-icon-arrowthick-2-n-s'></span> Intray $j <span style='float:right;padding-right:50px;' class='intray_position'>Your Selected intray position is $j</span></div>
																		<div class='portlet-content'>
															<input type='hidden' value='".$sss['value_id']."' name='answer_".$key."[]' id='answer_".$key ."_".$key1."'>
															<div class='row'>
																<div class='col-md-12'>
																	<div class='form-group'>
																		<label class='control-label mb-10'>What Action do you take for the following Intray</label>
																		<select class='form-control' name='intray_action".$sss['value_id']."' id='intray_action_".$key ."_".$key1."'>
																			<option value=''>Select</option>
																			<option value='Action'>Action</option>
																			<option value='Delegate'>Delegate</option>
																			<option value='Hold'>Hold</option>
																			<option value='Other'>Other</option>
																		</select>
																	</div>
																	<div class='form-group'>
																		<label class='control-label mb-10'>Description</label>
																		<textarea name='answer_text".$sss['value_id']."' id='answer_text_".$key ."_".$key1."' class='form-control'></textarea>
																	</div>
																</div>
																
															</div>
															</div></div>
														</li>";
													}
												}	
												$data.="</ul>
											</div>
											<div class='panel-footer borders' style='display:".$var.";padding: 6px 22px 40px;' id='question_button". $key."'>";
											$count=count($testdetails);
											if($type=='P'){
												$data.="
												<div class='pull-right'>
													<div class='btn-group'>
														<button class='btn btn-success' id='submit_ass'>Submit</button>
													</div>
												</div>";
											}
											else{
												$data.="<div class='pull-right'>
													<div class='btn-group'>";
													if($key==1){
														$data.="<button class='next_question btn btn-info' id='next' data='".$key."'>Next</button>
														<button class='skip_question btn btn-warning' id='next' data='".$key."'>Skip</button>";
													}
													elseif($key<$count){
														$data.="<button class='next_question btn btn-info' id='next' data='".$key."'>Next</button>
														<button class='skip_question btn btn-warning' id='next' data='".$key."'>Skip</button>";
													}
													elseif($key=$count){
														$data.="<button class='btn btn-success' onclick='click_submit();' id='submit_ass'>Submit</button>";
													}
														
													$data.="</div>
												</div>";
											}
											$data.="</div>
										</div>";
									}
								}
								$data.="</div></div>
								
							</div>
							

						</div>
					</div>
				</div>
			</div>
		</div>
	</form>";
	echo $data;
	}
	
	
	/* public function employee_pos_validation(){
		$data=array();
		$data['menu']="index";
		$emp_id=$this->session->userdata('emp_id');		
		$data['assessments']=UlsValidationPositionDefinition::getemployeevalidation($emp_id);
		$data["aboutpage"]=$this->pagedetails('employee','employee_pos_validation');
		$content = $this->load->view('employee/employee_pos_validation',$data,true);
		$this->render('layouts/adminnew',$content);	
	} */
	
	public function employee_pos_validation(){
		$data=array();
		$data['menu']="index";
		$emp_id=$this->session->userdata('emp_id');
		$position_id=$_REQUEST['position_id'];
		$val_id=$_REQUEST['val_id'];
		$val_pos_id=$_REQUEST['val_pos_id'];	
		$jid=$_REQUEST['jid'];
		$data['ass_details']=UlsValidationPositionDefinition::viewpositionvalidation($val_id);
		$data['jour_details']=UlsAssessmentEmployeeJourney::get_employees_details($jid);
		$posdetails=UlsPosition::viewposition($position_id);
		$data['posdetails']=$posdetails;
		$data["aboutpage"]=$this->pagedetails('employee','emp_posvalidation');
		$content = $this->load->view('employee/employee_pos_validation',$data,true);
		$this->render('layouts/employee_layout',$content);	
	}
	
	public function employee_validation_details(){		
		$data=array();
		$data['menu']="index";
		$data["aboutpage"]=$this->pagedetails('employee','emp_validation');
		$posdetails=UlsPosition::viewposition($_REQUEST['position_id']);
		$data['posdetails']=$posdetails;
		$data['competencies']=UlsCompetencyPositionRequirements::getcompetencypositionrequirements($_REQUEST['position_id']);
		$data['kras']=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($_REQUEST['position_id']);
		$data['emp_validation_details']=UlsPositionTemp::employee_viewpositionvalidation($_REQUEST['val_id'],$_REQUEST['position_id']);
		$data['emp_kra_validation_details']=UlsPositionTemp::get_self_validation_kra_summary($_REQUEST['val_id'],$_REQUEST['position_id'],$_REQUEST['val_pos_id']);
		$data['emp_kra_details']=UlsPositionKraTempTray::get_self_validation_kra($_REQUEST['val_id'],$_REQUEST['position_id']);
		$org_stat="VAL_REQUIRE";
        $data["require"]=UlsAdminMaster::get_value_names($org_stat);
		$data['comp_details']=UlsPositionTemp::employee_view_position_cat($_REQUEST['val_id'],$_REQUEST['position_id']);
		$content = $this->load->view('employee/employee_position_validation_process',$data,true);
		$this->render('layouts/employee_assessment',$content);	
	}
	
	public function position_profile_details(){
		$position_id=$_REQUEST['pos_id'];
		$data="";
		$posdetails=UlsPosition::viewposition($position_id);
		$data.="<div class='year-tab-section'>
				<ul class='nav nav-tabs align-items-center'>
					<li class='nav-item'>
						<a class='nav-link section-to-scroll active' href='javascript:;' data-section='job-description-tab' data-tab='0'>Job Description</a>
					</li>
					<li class='nav-item'>
						<a class='nav-link section-to-scroll' href='javascript:;' data-section='key-result-areas-tab' data-tab='1'>Key Result Areas</a>
					</li>
					<li class='nav-item'>
						<a class='nav-link section-to-scroll' href='javascript:;' data-section='competencies-tab' data-tab='2'>Competencies</a>
					</li>
					
				</ul>

				<div class='section-view'>
					<div id='scrolling-section' class='tab-content no-scrollbar'>
						<div id='job-description-tab' class='tab-pane'>
							<div class='custom-scroll'>
								<div class='tab-panel'>
									<div class='title'>Job Description</div>
									<div class='tab-body'>
										<p class='content'><b>Purpose</b></p>
										<p class='content'>".$posdetails['position_desc']."</p>
										<br>
										<p class='content'><b>Accountabilities</b></p>
										<p class='content'>".$posdetails['accountablities']."</p>
										<br>
										<p class='content'><b>Reporting Relationships</b></p>
										<p class='content'>Reports to: ".$posdetails['reportsto']."</p>
										<p class='content'>Reportees:".$posdetails['reportees_name']."</p>
										<br>
										<p class='content'><b>Position Requirements</b></p>
										<p class='content'>Education Background: ".$posdetails['education']."</p>
										<p class='content'>Experience: ".$posdetails['experience']."</p>
										<p class='content'>Industry Specific Experience: ".$posdetails['specific_experience']."</p>
										<br>";
										if(!empty($posdetails['other_requirement'])){ 
										$data.="<p class='content'><b>Other Requirements</b></p>
										<p class='content'>".$posdetails['other_requirement']."</p>";
										}
									$data.="</div>
								</div>
							</div>
						</div>

						<div id='key-result-areas-tab' class='tab-pane'>
							<div class='custom-scroll'>
								<div class='tab-panel'>
									<div class='title'>Key Result Areas</div>";
									$kras=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($position_id);
									$temp='';
									$key1=0;
									if(count($kras>0)){
										foreach($kras as $key=>$kra){
											if($kra['comp_position_id']==$posdetails['position_id']){
											if($temp!=$kra['kra_master_name']){
												$key1++;
												if($key!=0){
												$data.="</div></div>";
												}
												$data.="<div class='tab-areas-card'>
													
													<div class='tab-areas-header'>
														
														<span class='icon'>".$key1."</span>
														<span>".$kra['kra_master_name']."</span>
														
													</div>										
													<div class='tab-areas-body'>";
													$temp=$kra['kra_master_name'];
												}
												$data.="<div class='tab-areas-group d-flex align-items-center justify-content-between'>
													<label class='label'>".$kra['kra_kri']."</label>
													<p class='value'>".$kra['kra_uom']."</p>
													</div>";
											}
										}
									
									}
									$data.=(count($kras>0))?'</div></div>':'';
								$data.="</div>
								
							</div>
						</div>

						<div id='competencies-tab' class='tab-pane'>
							<div class='custom-scroll'>
								<div class='tab-panel'>
									<div class='title'>Competencies</div>";
									$competencies=UlsCompetencyPositionRequirements::getcompetencypositionrequirements($position_id);
									if(count($competencies)>0){
										foreach($competencies as $key=>$competency){
											if($competency['comp_position_id']==$posdetails['position_id']){
											
												$data.="<div class='tab-areas-card'>
													<div class='tab-areas-header'>
														<span class='icon'>".($key+1)."</span>
														<span>".$competency['comp_def_name']."</span>
													</div>
													<div class='tab-areas-body'>
														<div class='tab-areas-group d-flex align-items-center justify-content-between'>
															<label class='label'>Required Level:</label>
															<p class='value'>".$competency['scale_name']."</p>
														</div>
														<div class='tab-areas-group d-flex align-items-center justify-content-between'>
															<label class='label'>Criticality:</label>
															<p class='value'>".$competency['comp_cri_name']."</p>
														</div>
													</div>
												</div>";
											}
										}
									}
								$data.="</div>
							</div>
						</div>

					</div>
				</div>
			</div>";
		echo $data;
	}
	
	public function employee_position_validation_insert(){
        $this->sessionexist();
        if(isset($_POST['val_id'])){
            $fieldinsertupdates=array('accountabilities','responsibilities','val_id','position_id');
            $case=Doctrine::getTable('UlsPositionTemp')->find($_POST['pos_temp_id']);
            !isset($case->val_id)?$case=new UlsPositionTemp():"";
            foreach($fieldinsertupdates as $val){
				$case->$val=(!empty($_POST[$val]))?($_POST[$val]):NULL;
			}
			$case->employee_id=$_SESSION['emp_id'];
            $case->save();
			$enroll=(!empty($_POST['jid']))?Doctrine_Core::getTable('UlsAssessmentEmployeeJourney')->find($_POST['jid']): new UlsAssessmentEmployeeJourney();
			$enroll->status='I';
			$enroll->save();
            redirect('employee/employee_validation_details?id=2&status=career&jid='.$_POST['jid'].'&val_id='.$_POST['val_id'].'&position_id='.$_POST['position_id'].'&val_pos_id='.$_POST['val_pos_id']);
        }
        else{
			$content = $this->load->view('employee/employee_pos_validation',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }
	
	public function validation_position_competency_insert(){
		$this->sessionexist();
		if(isset($_POST['val_id'])){
			if(!empty($_POST['competency'])){
				foreach($_POST['competency'] as $key=>$competencys){
					$master_value=!empty($_POST['pos_comp_temp_id'][$key])?Doctrine::getTable('UlsPositionCompetencyTemp')->find($_POST['pos_comp_temp_id'][$key]): new UlsPositionCompetencyTemp();
					$master_value->val_id=$_POST['val_id'];
					$master_value->position_id=$_POST['position_id'];
					$master_value->employee_id=$_SESSION['emp_id'];
					$master_value->competency_id=$competencys;
					$master_value->required_process=$_POST['required_process_'.$competencys];
					$master_value->require_scale_id=$_POST['requiredlevel_'.$competencys];
					$master_value->assessed_scale_id=!empty($_POST['OVERALL_'.$competencys])?$_POST['OVERALL_'.$competencys]:NULL;
					$master_value->reason=!empty($_POST['reason_'.$competencys])?$_POST['reason_'.$competencys]:NULL;
					$master_value->save();
				}
			}
			if(isset($_POST['category_id'])){
				foreach($_POST['category_id'] as $key=>$category){
					if(isset($_POST['competency_name_'.$category])){
						foreach($_POST['competency_name_'.$category] as $key_cat=>$comp_category){
							if(!empty($comp_category)){
								$master_value=!empty($_POST['pos_comp_tray_id_'.$category][$key_cat])?Doctrine::getTable('UlsPositionCompetencyTempTray')->find($_POST['pos_comp_tray_id_'.$category][$key_cat]): new UlsPositionCompetencyTempTray();
								$master_value->val_id=$_POST['val_id'];
								$master_value->position_id=$_POST['position_id'];
								$master_value->employee_id=$_SESSION['emp_id'];
								$master_value->category_id=$category;
								$master_value->competency_name=$_POST['competency_name_'.$category][$key_cat];
								$master_value->require_scale_id=$_POST['require_scale_id_'.$category][$key_cat];
								$master_value->reason=!empty($_POST['reason_'.$category][$key_cat])?$_POST['reason_'.$category][$key_cat]:NULL;
								$master_value->save();
							}
						}
					}
				}
				
			}
			
			$this->session->set_flashdata('assessment',"Assessment position information has been ".(!empty($_POST['val_id'])?"updated":"inserted")." successfully.");
			 redirect('employee/employee_validation_details?id=3&status=strength&jid='.$_POST['jid'].'&val_id='.$_POST['val_id'].'&position_id='.$_POST['position_id'].'&val_pos_id='.$_POST['val_pos_id']);
		}
		else{
			$content = $this->load->view('employee/employee_pos_validation',$data,true);
			$this->render('layouts/adminnew',$content);
        }
	}
	
	public function validation_position_kra_insert(){
		$this->sessionexist();
		if(isset($_POST['val_id'])){
			/* echo "<pre>";
			print_r($_POST); */
			if(!empty($_POST['comp_kra_id'])){
				foreach($_POST['comp_kra_id'] as $key=>$comp_kra_id){
					$master_value=!empty($_POST['pos_kra_temp_id'][$key])?Doctrine::getTable('UlsPositionKraTemp')->find($_POST['pos_kra_temp_id'][$key]): new UlsPositionKraTemp();
					$master_value->val_id=$_POST['val_id'];
					$master_value->position_id=$_POST['position_id'];
					$master_value->employee_id=$_SESSION['emp_id'];
					$master_value->required_process=$_POST['required_process_'.$comp_kra_id];
					$master_value->comp_kra_id=$comp_kra_id;
					$master_value->reason=!empty($_POST['reason_'.$comp_kra_id])?$_POST['reason_'.$comp_kra_id]:NULL;
					$master_value->save();
				}
			}
			
			if(!empty($_POST['kra_des'])){
				foreach($_POST['kra_des'] as $key_kra=>$kra){
					$master_value=!empty($_POST['pos_kra_tray_id'][$key_kra])?Doctrine::getTable('UlsPositionKraTempTray')->find($_POST['pos_kra_tray_id'][$key_kra]): new UlsPositionKraTempTray();
					$master_value->val_id=$_POST['val_id'];
					$master_value->position_id=$_POST['position_id'];
					$master_value->employee_id=$_SESSION['emp_id'];
					$master_value->kra_des=$kra;
					$master_value->kra_kri=$_POST['kra_kri'][$key_kra];
					$master_value->kra_uom=$_POST['kra_uom'][$key_kra];
					$master_value->reason=!empty($_POST['reason_kra'][$key_kra])?$_POST['reason_kra'][$key_kra]:NULL;
					$master_value->save();
				}
			}
			
			$this->session->set_flashdata('assessment',"Assessment position information has been ".(!empty($_POST['val_id'])?"updated":"inserted")." successfully.");
			redirect('employee/pos_validation_summary_preview?jid='.$_POST['jid'].'&val_id='.$_POST['val_id'].'&position_id='.$_POST['position_id'].'&val_pos_id='.$_POST['val_pos_id']);
		}
		else{
			$content = $this->load->view('employee/employee_pos_validation',$data,true);
			$this->render('layouts/adminnew',$content);
        }
	}
	
	public function pos_validation_summary_preview(){
		$this->sessionexist();	
		$data=array();
		$data['menu']="index";
		$val_id=$_REQUEST['val_id'];
		$pos_id=$_REQUEST['position_id'];
		$val_pos_id=$_REQUEST['val_pos_id'];
		$data['emp_validation_details']=UlsPositionTemp::employee_viewpositionvalidation($val_id,$pos_id);
		$org_stat="VAL_REQUIRE";
        $data["require"]=UlsAdminMaster::get_value_names($org_stat);
		$data['comp_details']=UlsPositionTemp::employee_view_position_cat($val_id,$pos_id);
		$data['emp_kra_validation_details']=UlsPositionTemp::get_self_validation_kra_summary($val_id,$pos_id,$val_pos_id);
		$data["aboutpage"]=$this->pagedetails('employee','emp_case_assessment');
		$content = $this->load->view('employee/pos_validation_summary_preview',$data,true);
		$this->render('layouts/employee_assessment',$content);	
	}
	
	public function position_assessment_final(){
		if(isset($_POST['final_submit'])){
			$enroll=(!empty($_POST['jid']))?Doctrine_Core::getTable('UlsAssessmentEmployeeJourney')->find($_POST['jid']): new UlsAssessmentEmployeeJourney();
			$enroll->status='C';
			$enroll->save();
			
			redirect('employee/employee_pos_validation?jid='.$_POST['jid'].'&val_id='.$_POST['val_id'].'&position_id='.$_POST['position_id'].'&val_pos_id='.$_POST['val_pos_id']);
		}
	}
	
	public function delete_validation_kra(){
		if(!empty($_REQUEST['val'])){
			$play=Doctrine_Query::Create()->delete('UlsPositionKraTempTray')->where("pos_kra_tray_id=".$_REQUEST['val'])->execute();
			echo 1;
		}
		else{
			echo "Selected Assessment Position cannot be deleted. Ensure you delete all the usages of the Assessment Position before you delete it.";
		}
	}
	
	public function delete_validation_competency(){
		if(!empty($_REQUEST['val'])){
			$play=Doctrine_Query::Create()->delete('UlsPositionCompetencyTempTray')->where("pos_comp_tray_id=".$_REQUEST['val'])->execute();
			echo 1;
		}
		else{
			echo "Selected Assessment Position cannot be deleted. Ensure you delete all the usages of the Assessment Position before you delete it.";
		}
	}
	
	public function getindicator_details(){
		$comp_id=$_REQUEST['comp_id'];
		$scale_id=$_REQUEST['scale_id'];
		$compentency=UlsMenu::callpdorow("SELECT comp_def_id,comp_def_name,comp_def_short_desc FROM `uls_competency_definition` where comp_def_id='$comp_id'");
		$indicator=UlsCompetencyDefLevelIndicator::getcompdeflevelind_details($comp_id,$scale_id);
		$scale_detail=UlsLevelMasterScale::levelscale_detail($scale_id);
		$scale_info=UlsLevelMasterScale::levelscale($scale_detail['level_id']);
		$datas="";
		$datas.="<div><p class='text-muted'><code>You have selected Level as ".$scale_detail['scale_name']."</code>";
		if(count($indicator)>0){
		$datas.="
		<div style='border:1px solid #DDDDDD; height: 400px;overflow: auto;' align='left'>
		<table cellpadding='1' cellspacing='1' class='table table-bordered table-striped' width='100%'>
			<thead>
				<tr>
					<th>S.No</th>
					<th>Type</th>
					<th>Indicators</th>
				</tr>
			</thead>
			<tbody>";
			foreach($indicator as $key=>$indicators){
				$type=($indicators['ind_master_name']=='General')?"":$indicators['ind_master_name'];
				$datas.="<tr>
					<td>".($key+1)."</td>
					<td>".$type."</td>
					<td>".$indicators['comp_def_level_ind_name']."</td>
				</tr>";
			}
			$datas.="</tbody>
		</table></div>";
		}
		echo $datas;
	}
	
	public function competency_profile_details(){
		$ass_id=$_REQUEST['ass_id'];
		$pos_id=$_REQUEST['pos_id'];
		$competencies=UlsCompetencyPositionRequirements::getcompetencypositionrequirements($pos_id);
		$data="";
		foreach($competencies as $key=>$competencie){
			$data.="<div class='tab-areas-card'>
				<div class='tab-areas-header'>
					<span class='icon'>".($key+1)."</span>
					<span>".$competencie['comp_def_name']."</span>
				</div>
				<div class='tab-areas-body'>
					<div class='tab-areas-group d-flex align-items-center justify-content-between'>
						<label class='label'>Required Level:</label>
						<p class='value'>".$competencie['scale_name']."</p>
					</div>
					<div class='tab-areas-group d-flex align-items-center justify-content-between'>
						<label class='label'>Criticality:</label>
						<p class='value'>".$competencie['comp_cri_name']."</p>
					</div>
				</div>
			</div>";
		}
		echo $data;
	}
	
	public function employee_inbasket_details(){
		$this->sessionexist();	
		$data=array();
		$data['menu']="index";
		//unset($_SESSION['inbasket_time']);
		if(isset($_REQUEST['assess_test_id'])){
			$ass_test=UlsAssessmentTest::test_details($_REQUEST['assess_test_id']);
			$data['ass_details']=$ass_test;
			$emp_id=isset($_SESSION['e_emp_id']) ? $_SESSION['e_emp_id'] : $_SESSION['emp_id'];
			$test_id=$_REQUEST['test_id'];
			$ass_test_id=$_REQUEST['assess_test_id'];
			$inbasket_id=$_REQUEST['in_id'];
			$pos_id=$ass_test['position_id'];
			$ass_id=$ass_test['assessment_id'];
			$data['ass_id']=$ass_id;
			$data['pos_id']=$pos_id;
			$data['inbasket_question']=UlsAssessmentTestQuestions::get_inbasket_questions_info($ass_test_id,$test_id);
			$data["inbasket_details"]=UlsInbasketMaster::viewinbasket($inbasket_id);
			$data["testdetails"]=UlsUtestResponsesAssessment::get_test_view_details($test_id,$ass_test_id,$ass_id);
			$data["aboutpage"]=$this->pagedetails('employee','emp_inbasket_assessment');
			$content = $this->load->view('employee/employee_inbasket_details',$data,true);
		}
		$this->render('layouts/employee_assessment',$content);	
	}
	
	public function inbasket_int_submit(){
		if(isset($_POST['submit_int'])){
			$this->session->set_userdata('inbasket_starttime',$_POST['start_period']);
			redirect('employee/employee_inbasket_details?status=self&jid='.$_POST['jid'].'&assess_test_id='.$_POST['assess_test_id'].'&in_id='.$_POST['in_id'].'&test_id='.$_POST['test_id']);
		}
	}
	
	public function inbasket_one_submit(){
		if(isset($_POST['submit_one'])){
			
			redirect('employee/employee_inbasket_details?status=career&jid='.$_POST['jid'].'&assess_test_id='.$_POST['assess_test_id'].'&in_id='.$_POST['in_id'].'&test_id='.$_POST['test_id']);
		}
	}
	
	public function inbasket_two_submit(){
		if(isset($_POST['assess_test_id'])){
			$this->session->set_userdata('inbasket_starttime',$_POST['start_period']);
			$this->session->set_userdata('inbasket_time',$_POST['time_period']);
			if(($_POST['time_period']=='00:01') || ($_POST['time_period']=='0:1') || ($_POST['time_period']=='0:0')){
				if(isset($_SESSION['user_id'])){
					
					$testtype=$_POST['ttype'];
					$emp_id=isset($_SESSION['e_emp_id']) ? $_SESSION['e_emp_id'] : $_SESSION['emp_id'];
					if(isset($_POST['test_id']) || isset($_POST['resume'] ) ){
						print_r($_POST);
						$eveid=$_POST['assess_test_id'];
						$tidss=$tid=$_POST['test_id'];
						$evalid=$_POST['assid'];
						$teststatus=isset($_POST['resume'])?'RES':'COM';
						$testdeails=Doctrine_Core::getTable('UlsCompetencyTest')->findOneByTest_id($tid);
						$pass=0; $totscore=0; $wrongans=0;$correctans=0;$versionnum=1;
						$atts_status='COM';
						$notificationdata=new UlsUtestAttemptsAssessment();
						$notificationdata->employee_id=$emp_id;
						$notificationdata->elearning_object_id=0;
						$notificationdata->event_id=$eveid;
						$notificationdata->assessment_id=$evalid;
						$notificationdata->parent_org_id=$_SESSION['parent_org_id'];
						$notificationdata->version_number=$versionnum;
						$notificationdata->status='A';
						$notificationdata->timestamp= date('Y-m-d h:i:s', time());
						$notificationdata->performance_source="";
						$notificationdata->attempt_status=$atts_status;
						$notificationdata->test_status=$teststatus;
						$notificationdata->score=$pass;
						$notificationdata->correct_ans=$correctans;
						$notificationdata->wrong_ans=$wrongans;
						$notificationdata->timee=0;
						$notificationdata->test_id=$tidss;
						$notificationdata->test_type=$testtype;
						$notificationdata->internal_state="";
						$notificationdata->mastery_score=0;
						$notificationdata->start_period=date('Y-m-d h:i:s', strtotime($_POST['start_period']));
						$notificationdata->end_period=date('Y-m-d h:i:s');
						$notificationdata->save();
						$ass_details=UlsAssessmentTest::assessment_test_employee($eveid);
						redirect("employee/employee_ass_complete?jid=".$_POST['jid']."&pro=INBASKET&asstype=".$ass_details['assessment_type']."&assessment_id=".$ass_details['assessment_id']."&position_id=".$ass_details['position_id']."&assessment_pos_id=".$ass_details['assessment_pos_id']);
					}				
				}
			}
			else{
				redirect('employee/employee_inbasket_details?status=strength&jid='.$_POST['jid'].'&assess_test_id='.$_POST['assess_test_id'].'&in_id='.$_POST['in_id'].'&test_id='.$_POST['test_id']);
			}
		}
	}
	
	public function inbasket_three_submit(){
		if(isset($_POST['assess_test_id'])){
			if(($_POST['time_period']=='00:01') || ($_POST['time_period']=='0:1') || ($_POST['time_period']=='0:0')){
				if(isset($_SESSION['user_id'])){
					
					$testtype=$_POST['ttype'];
					$emp_id=isset($_SESSION['e_emp_id']) ? $_SESSION['e_emp_id'] : $_SESSION['emp_id'];
					if(isset($_POST['test_id']) || isset($_POST['resume'] ) ){
						print_r($_POST);
						$eveid=$_POST['assess_test_id'];
						$tidss=$tid=$_POST['test_id'];
						$evalid=$_POST['assid'];
						$teststatus=isset($_POST['resume'])?'RES':'COM';
						$testdeails=Doctrine_Core::getTable('UlsCompetencyTest')->findOneByTest_id($tid);
						$pass=0; $totscore=0; $wrongans=0;$correctans=0;$versionnum=1;
						$atts_status='COM';
						$notificationdata=new UlsUtestAttemptsAssessment();
						$notificationdata->employee_id=$emp_id;
						$notificationdata->elearning_object_id=0;
						$notificationdata->event_id=$eveid;
						$notificationdata->assessment_id=$evalid;
						$notificationdata->parent_org_id=$_SESSION['parent_org_id'];
						$notificationdata->version_number=$versionnum;
						$notificationdata->status='A';
						$notificationdata->timestamp= date('Y-m-d h:i:s', time());
						$notificationdata->performance_source="";
						$notificationdata->attempt_status=$atts_status;
						$notificationdata->test_status=$teststatus;
						$notificationdata->score=$pass;
						$notificationdata->correct_ans=$correctans;
						$notificationdata->wrong_ans=$wrongans;
						$notificationdata->timee=0;
						$notificationdata->test_id=$tidss;
						$notificationdata->test_type=$testtype;
						$notificationdata->internal_state="";
						$notificationdata->mastery_score=0;
						$notificationdata->start_period=date('Y-m-d h:i:s', strtotime($_POST['start_period']));
						$notificationdata->end_period=date('Y-m-d h:i:s');
						$notificationdata->save();
						$ass_details=UlsAssessmentTest::assessment_test_employee($eveid);
						redirect("employee/employee_ass_complete?jid=".$_POST['jid']."&pro=INBASKET&asstype=".$ass_details['assessment_type']."&assessment_id=".$ass_details['assessment_id']."&position_id=".$ass_details['position_id']."&assessment_pos_id=".$ass_details['assessment_pos_id']);
					}				
				}
			}
			else{
				$array=$_POST['val_id'];
				
				//$_SESSION['intray_values']=$array;
				$eveid=$_POST['assess_test_id'];
				$tid=$_POST['test_id'];
				$evalid=$_POST['assid'];
				$testtype=$_POST['ttype'];
				$emp_id=isset($_SESSION['e_emp_id']) ? $_SESSION['e_emp_id'] : $_SESSION['emp_id'];
				$teststatus=isset($_POST['resume'])?'RES':'COM';
				$testdeails=Doctrine_Core::getTable('UlsCompetencyTest')->findOneByTest_id($tid);
				// Deleting Previous Test Records
				$qtvalus=Doctrine_Query::create()->select('id')->from('UlsUtestQuestionsAssessment')->where("test_id=".$tid." and event_id=".$eveid." and employee_id=".$emp_id." and test_type='".$testtype."' and assessment_id=".$evalid." and parent_org_id=".$_SESSION['parent_org_id'])->execute();
				/* if(count($qtvalus)>0){
					foreach($qtvalus as $qtvalue){
						if(!empty($qtvalue['id'])){
							$del=Doctrine_Query::Create()->Delete('UlsUtestResponsesAssessment')->where("utest_question_id=".$qtvalue['id'])->execute();
						}
					}
				}
				Doctrine_Query::create()->delete('UlsUtestQuestionsAssessment')->where("test_id=".$tid." and event_id=".$eveid." and assessment_id=".$evalid." and employee_id=".$emp_id." and test_type='".$testtype."' and parent_org_id=".$_SESSION['parent_org_id'])->execute(); 
				$attval=Doctrine_Query::Create()->select('version_number as atts,attempt_id')->from('UlsUtestAttemptsAssessment')->where("employee_id=".$emp_id." and event_id=".$eveid." and parent_org_id=".$_SESSION['parent_org_id']." and assessment_id=".$evalid."  and  test_type='".$testtype."' and test_id=".$tid )->setHydrationMode(Doctrine::HYDRATE_ARRAY)->execute();
				if(count($attval)>0){ 
					//print_r($attval);
					foreach($attval as $attvals){
						$versionnum=$attvals['atts']+1;
						$qattempt=Doctrine_Core::getTable('UlsUtestAttemptsAssessment')->find($attvals['attempt_id']);
						$qattempt->status='I';
						$qattempt->save();
					}
				}
				else { $versionnum=1; }
				$pass=0; $totscore=0; $wrongans=0;$correctans=0;*/
				
				$st=Doctrine_Core::getTable('UlsQuestions')->findOneByQuestion_id($_POST['question']);
				$question_inbasket=UlsUtestQuestionsAssessment::question_values_inbasket($emp_id,$eveid,$evalid);
				$question_values=(!empty($question_inbasket['id']))?Doctrine::getTable('UlsUtestQuestionsAssessment')->find($question_inbasket['id']):new UlsUtestQuestionsAssessment;
				$question_values->employee_id=$emp_id;
				$question_values->parent_org_id=$_SESSION['parent_org_id'];
				$question_values->test_id=$tid;
				$question_values->assessment_id=$evalid;
				$question_values->event_id=$eveid;
				$question_values->test_type=$testtype;  //we have to get it
				$question_values->status=$teststatus;
				$question_values->user_test_question_id=$_POST['question'];
				$question_values->save();
				$corec="";
				$text="";
				$respid="";
				$key_n=1;
				if(isset($array)){
					foreach($array as $ans){
							//print_r($key_n);
							$anss_content=!empty($_POST['answer_text'.$ans])?$_POST['answer_text'.$ans]:"";
							$anss_action=!empty($_POST['intray_action'.$ans])?$_POST['intray_action'.$ans]:"";
							$results[]= array('id' => $ans, 'text' => $anss_content,'action' => $anss_action);
							$lang_answer=!empty($_POST['lang_process'.$ans])?$_POST['lang_process'.$ans]:"";
							$results_lang[]= array('id' => $ans, 'text' => $lang_answer,'action' => $anss_action);
							$output = ($results);
							$output_lang = ($results_lang);
							if($key_n==1){
								$texts=$output;
								$texts_lang=$output_lang;
								$respid=$ans;
							}
							else {
								$texts=$output;
								$texts_lang=$output_lang;
								$respid.=",".$ans;
							}
						$key_n++;	
					}
				}
				/* print_r($respid);
				exit(); */
				$text=json_encode($texts);
				$texts_lang=json_encode($texts_lang);
				$text_save=!empty($_POST['save_text'])?$_POST['save_text']:$text;
				$text_save_lang=!empty($_POST['save_text'])?$_POST['save_text']:$texts_lang;
				$resp_inbasket=UlsUtestResponsesAssessment::responce_values_inbasket($emp_id,$eveid,$evalid);
				$questions=(!empty($resp_inbasket['user_test_response_id']))?Doctrine::getTable('UlsUtestResponsesAssessment')->find($resp_inbasket['user_test_response_id']):new UlsUtestResponsesAssessment;
				$questions->utest_question_id=$question_values->id;
				$questions->parent_org_id=$_SESSION['parent_org_id'];
				$questions->employee_id=$emp_id;
				$questions->assessment_id=$evalid;
				$questions->user_test_question_id=$_POST['question'];
				$questions->test_type=$testtype;
				$questions->response_value_id=$respid;
				$questions->event_id=$eveid;
				$questions->response_type_id='P';
				$questions->answered_flag='';
				$questions->text=$text_save;
				$questions->text_lang=$text_save_lang;
				$questions->correct_flag=$corec;
				$questions->points=$st->points;
				$questions->save();
				$this->session->set_userdata('inbasket_time',$_POST['time_period']);
				redirect('employee/employee_inbasket_details?status=development&jid='.$_POST['jid'].'&assess_test_id='.$_POST['assess_test_id'].'&in_id='.$_POST['in_id'].'&test_id='.$_POST['test_id']);
			}
		}
	}
	
	public function inbasket_four_submit_auto(){
		if(isset($_SESSION['user_id'])){
			$testtype=$_POST['ttype'];
			$emp_id=isset($_SESSION['e_emp_id']) ? $_SESSION['e_emp_id'] : $_SESSION['emp_id'];
			if(isset($_POST['testid']) || isset($_POST['resume'] ) ){
				$eveid=$_POST['ass_test_id'];
				$tidss=$tid=$_POST['testid'];
				$evalid=$_POST['assid'];
				$teststatus=isset($_POST['resume'])?'RES':'COM';
				$testdeails=Doctrine_Core::getTable('UlsCompetencyTest')->findOneByTest_id($tid);
				// Deleting Previous Test Records
				/* $qtvalus=Doctrine_Query::create()->select('id')->from('UlsUtestQuestionsAssessment')->where("test_id=".$tid." and event_id=".$eveid." and employee_id=".$emp_id." and test_type='".$testtype."' and assessment_id=".$evalid." and parent_org_id=".$_SESSION['parent_org_id'])->execute();
				if(count($qtvalus)>0){
					foreach($qtvalus as $qtvalue){
						if(!empty($qtvalue['id'])){
							$del=Doctrine_Query::Create()->Delete('UlsUtestResponsesAssessment')->where("utest_question_id=".$qtvalue['id'])->execute();
						}
					}
				}
				Doctrine_Query::create()->delete('UlsUtestQuestionsAssessment')->where("test_id=".$tid." and event_id=".$eveid." and assessment_id=".$evalid." and employee_id=".$emp_id." and test_type='".$testtype."' and parent_org_id=".$_SESSION['parent_org_id'])->execute();
				$attval=Doctrine_Query::Create()->select('version_number as atts,attempt_id')->from('UlsUtestAttemptsAssessment')->where("employee_id=".$emp_id." and event_id=".$eveid." and parent_org_id=".$_SESSION['parent_org_id']." and assessment_id=".$evalid."  and  test_type='".$testtype."' and test_id=".$tid )->setHydrationMode(Doctrine::HYDRATE_ARRAY)->execute();
				if(count($attval)>0){ 
					//print_r($attval);
					foreach($attval as $attvals){
						$versionnum=$attvals['atts']+1;
						$qattempt=Doctrine_Core::getTable('UlsUtestAttemptsAssessment')->find($attvals['attempt_id']);
						$qattempt->status='I';
						$qattempt->save();
					}
				}
				else { $versionnum=1; }
				$pass=0; $totscore=0; $wrongans=0;$correctans=0;
				
				$st=Doctrine_Core::getTable('UlsQuestions')->findOneByQuestion_id($_POST['question']);
				$question_values=new UlsUtestQuestionsAssessment();
				$question_values->employee_id=$emp_id;
				$question_values->parent_org_id=$_SESSION['parent_org_id'];
				$question_values->test_id=$tid;
				$question_values->assessment_id=$evalid;
				$question_values->event_id=$eveid;
				$question_values->test_type=$testtype;  //we have to get it
				$question_values->status=$teststatus;
				$question_values->user_test_question_id=$_POST['question'];
				$question_values->save(); */
				$corec="";
				$text="";
				$respid="";
				if(isset($_POST['answer'])){
					foreach($_POST['answer'] as $key_n=>$ans){
						
							$anss_content=!empty($_POST['answer_text'.$ans])?$_POST['answer_text'.$ans]:"";
							$anss_action=!empty($_POST['intray_action'.$ans])?$_POST['intray_action'.$ans]:"";
							$results[]= array('id' => $ans, 'text' => $anss_content,'action' => $anss_action);
							$lang_answer=!empty($_POST['lang_process'.$ans])?$_POST['lang_process'.$ans]:"";
							$results_lang[]= array('id' => $ans, 'text' => $lang_answer,'action' => $anss_action);
							$output = ($results);
							$output_lang = ($results_lang);
							if($key_n==0){
								$texts=$output;
								$texts_lang=$output_lang;
								$respid=$ans;
							}
							else {
								$texts=$output;
								$texts_lang=$output_lang;
								$respid.=",".$ans;
							}
						
					}
				}
				$text=json_encode($texts);
				$texts_lang=json_encode($texts_lang);
				$questions=(!empty($_POST['user_test_response_id']))?Doctrine::getTable('UlsUtestResponsesAssessment')->find($_POST['user_test_response_id']):new UlsUtestResponsesAssessment;
				$questions->utest_question_id=$_POST['utest_question_id'];
				$questions->parent_org_id=$_SESSION['parent_org_id'];
				$questions->employee_id=$emp_id;
				$questions->assessment_id=$evalid;
				$questions->user_test_question_id=$_POST['question'];
				$questions->test_type=$testtype;
				$questions->response_value_id=$_POST['response_value_id'];
				$questions->event_id=$eveid;
				$questions->response_type_id='P';
				$questions->answered_flag='';
				$questions->text=$text;
				$questions->text_lang=$texts_lang;
				$questions->correct_flag=$corec;
				$questions->points=0;
				$questions->save();
				
			}				
		}
		
	}
	
	public function inbasket_four_submit(){
		if(isset($_SESSION['user_id'])){
			$testtype=$_POST['ttype'];
			$emp_id=isset($_SESSION['e_emp_id']) ? $_SESSION['e_emp_id'] : $_SESSION['emp_id'];
			if(isset($_POST['testid']) || isset($_POST['resume'] ) ){
				$eveid=$_POST['ass_test_id'];
				$tidss=$tid=$_POST['testid'];
				$evalid=$_POST['assid'];
				$teststatus=isset($_POST['resume'])?'RES':'COM';
				$testdeails=Doctrine_Core::getTable('UlsCompetencyTest')->findOneByTest_id($tid);
				// Deleting Previous Test Records
				$qtvalus=Doctrine_Query::create()->select('id')->from('UlsUtestQuestionsAssessment')->where("test_id=".$tid." and event_id=".$eveid." and employee_id=".$emp_id." and test_type='".$testtype."' and assessment_id=".$evalid." and parent_org_id=".$_SESSION['parent_org_id'])->execute();
				if(count($qtvalus)>0){
					foreach($qtvalus as $qtvalue){
						if(!empty($qtvalue['id'])){
							$del=Doctrine_Query::Create()->Delete('UlsUtestResponsesAssessment')->where("utest_question_id=".$qtvalue['id'])->execute();
						}
					}
				}
				Doctrine_Query::create()->delete('UlsUtestQuestionsAssessment')->where("test_id=".$tid." and event_id=".$eveid." and assessment_id=".$evalid." and employee_id=".$emp_id." and test_type='".$testtype."' and parent_org_id=".$_SESSION['parent_org_id'])->execute();
				$attval=Doctrine_Query::Create()->select('version_number as atts,attempt_id')->from('UlsUtestAttemptsAssessment')->where("employee_id=".$emp_id." and event_id=".$eveid." and parent_org_id=".$_SESSION['parent_org_id']." and assessment_id=".$evalid."  and  test_type='".$testtype."' and test_id=".$tid )->setHydrationMode(Doctrine::HYDRATE_ARRAY)->execute();
				if(count($attval)>0){ 
					//print_r($attval);
					foreach($attval as $attvals){
						$versionnum=$attvals['atts']+1;
						$qattempt=Doctrine_Core::getTable('UlsUtestAttemptsAssessment')->find($attvals['attempt_id']);
						$qattempt->status='I';
						$qattempt->save();
					}
				}
				else { $versionnum=1; }
				$pass=0; $totscore=0; $wrongans=0;$correctans=0;
				
				$st=Doctrine_Core::getTable('UlsQuestions')->findOneByQuestion_id($_POST['question']);
				$question_values=new UlsUtestQuestionsAssessment();
				$question_values->employee_id=$emp_id;
				$question_values->parent_org_id=$_SESSION['parent_org_id'];
				$question_values->test_id=$tid;
				$question_values->assessment_id=$evalid;
				$question_values->event_id=$eveid;
				$question_values->test_type=$testtype;  //we have to get it
				$question_values->status=$teststatus;
				$question_values->user_test_question_id=$_POST['question'];
				$question_values->save();
				$corec="";
				$text="";
				$respid="";
				if(isset($_POST['answer'])){
					foreach($_POST['answer'] as $key_n=>$ans){
						
							$anss_content=!empty($_POST['answer_text'.$ans])?$_POST['answer_text'.$ans]:"";
							$anss_action=!empty($_POST['intray_action'.$ans])?$_POST['intray_action'.$ans]:"";
							$results[]= array('id' => $ans, 'text' => $anss_content,'action' => $anss_action);
							$lang_answer=!empty($_POST['lang_process'.$ans])?$_POST['lang_process'.$ans]:"";
							$results_lang[]= array('id' => $ans, 'text' => $lang_answer,'action' => $anss_action);
							$output = ($results);
							$output_lang = ($results_lang);
							if($key_n==0){
								$texts=$output;
								$texts_lang=$output_lang;
								$respid=$ans;
							}
							else {
								$texts=$output;
								$texts_lang=$output_lang;
								$respid.=",".$ans;
							}
						
					}
				}
				$text=json_encode($texts);
				$texts_lang=json_encode($texts_lang);
				$questions=new UlsUtestResponsesAssessment();
				$questions->utest_question_id=$question_values->id;
				$questions->parent_org_id=$_SESSION['parent_org_id'];
				$questions->employee_id=$emp_id;
				$questions->assessment_id=$evalid;
				$questions->user_test_question_id=$_POST['question'];
				$questions->test_type=$testtype;
				$questions->response_value_id=$respid;
				$questions->event_id=$eveid;
				$questions->response_type_id='P';
				$questions->answered_flag='';
				$questions->text=$text;
				$questions->text_lang=$texts_lang;
				$questions->correct_flag=$corec;
				$questions->points=$st->points;
				$questions->save();
				
				$atts_status='COM';
				$notificationdata=new UlsUtestAttemptsAssessment();
				$notificationdata->employee_id=$emp_id;
				$notificationdata->elearning_object_id=0;
				$notificationdata->event_id=$eveid;
				$notificationdata->assessment_id=$evalid;
				$notificationdata->parent_org_id=$_SESSION['parent_org_id'];
				$notificationdata->version_number=$versionnum;
				$notificationdata->status='A';
				$notificationdata->timestamp= date('Y-m-d h:i:s', time());
				$notificationdata->performance_source="";
				$notificationdata->attempt_status=$atts_status;
				$notificationdata->test_status=$teststatus;
				$notificationdata->score=$pass;
				$notificationdata->correct_ans=$correctans;
				$notificationdata->wrong_ans=$wrongans;
				$notificationdata->timee=0;
				$notificationdata->test_id=$tidss;
				$notificationdata->test_type=$testtype;
				$notificationdata->internal_state="";
				$notificationdata->mastery_score=0;
				$notificationdata->start_period=date('Y-m-d H:i:s', strtotime($_POST['start_period']));
				$notificationdata->end_period=date('Y-m-d H:i:s');
				$notificationdata->save();
				$this->session->set_userdata('inb_comp',1);
				$ass_details=UlsAssessmentTest::assessment_test_employee($eveid);
				redirect("employee/employee_ass_complete?jid=".$_POST['jid']."&pro=INBASKET&asstype=".$ass_details['assessment_type']."&assessment_id=".$ass_details['assessment_id']."&position_id=".$ass_details['position_id']."&assessment_pos_id=".$ass_details['assessment_pos_id']);
			}				
		}
		
	}
	
	
	
	public function assessment_inbasket_details(){
		$val_id=$_REQUEST['val_id'];
		$id=$_REQUEST['intray'];
		$values=UlsQuestionValues::get_allquestion_values_edit($val_id);
		$parsed_json="";
		if(!empty($values['inbasket_mode'])){												
			$parsed_json = json_decode($values['inbasket_mode'], true);
		}
		$data="";
		$data.="<div class='modal-header'>
			<h5 class='modal-title flex'>Intray ".$id."</h5>
			<a href='javascript:;' class='close-modal' data-dismiss='modal' aria-label='Close'>
				<i class='material-icons'>close</i> Close
			</a>
		</div>
		<div class='case-info'>";
		if(!empty($parsed_json)){
			foreach($parsed_json as $key => $value){
				$yes_stat="IN_MODE";
				$val_code=UlsAdminMaster::get_value_name_statuss($yes_stat,$value['mode']);
			$data.="<label class='case-name'><b>Mode:</b> ".$val_code['name']."</label>
			<label class='case-name'><b>Date/Time:</b> ".$value['period']."</label>
			<label class='case-name'><b>From:</b> ".$value['from']."</label>";
			}
		}
		$data.="</div>

		<!-- NAVIGATION :BEGIN 
		<div class='nav-arrow'>
			<a href='javascript:;' class='nav-icon left material-icons'>arrow_back</a>
			<a href='javascript:;' class='nav-icon right material-icons'>arrow_forward</a>
		</div>-->
		<!-- NAVIGATION :END -->

		<div class='modal-body'>
			<div class=''>
				<p class='content'>";
				$data.=($values['text']);
				$data.=!empty($values['text_lang'])?"<br>".$values['text_lang']:"";
				$data.=($values['suggestion_inbasket']);
				"</p>
			</div>
		</div>";
		echo $data;
	}
	
	public function employee_case_details(){
		$this->sessionexist();	
		$data=array();
		$data['menu']="index";
		if(isset($_REQUEST['assess_test_id'])){
			$ass_test=UlsAssessmentTest::test_details($_REQUEST['assess_test_id']);
			$data['ass_details']=$ass_test;
			$emp_id=isset($_SESSION['e_emp_id']) ? $_SESSION['e_emp_id'] : $_SESSION['emp_id'];
			$test_id=$_REQUEST['test_id'];
			$ass_test_id=$_REQUEST['assess_test_id'];
			$case_id=$_REQUEST['case_id'];
			$pos_id=$ass_test['position_id'];
			$ass_id=$ass_test['assessment_id'];
			$data['emp_id']=$emp_id;
			$data['test_id']=$test_id;
			$data['ass_test_id']=$ass_test_id;
			$case_id=$_REQUEST['case_id'];
			$data['pos_id']=$pos_id;
			$data['ass_id']=$ass_id;
			$data["case_details"]=UlsCaseStudyMaster::viewcasestudy($case_id);
			$data["testdetails"]=UlsUtestResponsesAssessment::get_test_view_detail_casestudy($test_id,$ass_test_id,$ass_id);
			$data["aboutpage"]=$this->pagedetails('employee','emp_case_assessment');
			$content = $this->load->view('employee/employee_casestudy_details',$data,true);
		}
		$this->render('layouts/employee_assessment',$content);	
	}
	
	
	
	
	public function assessment_case_details(){
		$val_id=$_REQUEST['val_id'];
		$case_details=UlsCaseStudyMaster::viewcasestudy($val_id);
		$parsed_json="";
		
		$data="";
		$data.="<div class='modal-header'>
			<h5 class='modal-title flex'>Case Details</h5>
			<a href='javascript:;' class='close-modal' data-dismiss='modal' aria-label='Close'>
				<i class='material-icons'>close</i> Close
			</a>
		</div>
		<!-- NAVIGATION :END -->

		<div class='modal-body'>
			
				<p class='content'>
				".ltrim(($case_details['casestudy_description']))."
				</p>";
				if(!empty($case_details['casestudy_description_lang'])){
					$data.="<p class='content'>
					".ltrim(($case_details['casestudy_description_lang']))."
					</p>";
				}
			
		$data.="</div>";
		echo $data;
	}
	
	public function self_ass_summary_preview(){
		$this->sessionexist();	
		$data=array();
		$data['menu']="index";
		$ass_id=$_REQUEST['assessment_id'];
		$emp_id=$_REQUEST['emp_id'];
		$pos_id=$_REQUEST['position_id'];
		$ass_pos_id=$_REQUEST['assessment_pos_id'];
		$data['self_assessment']=UlsSelfAssessmentReport::getassessment_self_competency($ass_id,$pos_id,$emp_id);
		$data['career_planning']=UlsSelfAssessmentReportDevArea::getselfassessment_dev_summary($ass_id,$pos_id,$emp_id);
		$enroll=(!empty($_REQUEST['jid']))?Doctrine_Core::getTable('UlsAssessmentEmployeeJourney')->find($_REQUEST['jid']): new UlsAssessmentEmployeeJourney();
		$enroll->status='C';
		$enroll->save();
		$data["aboutpage"]=$this->pagedetails('employee','emp_case_assessment');
		$content = $this->load->view('employee/self_ass_summary_preview',$data,true);
		$this->render('layouts/employee_assessment',$content);	
	}
	
	public function self_assessment_final(){
		if(isset($_POST['final_submit'])){
			$enroll=(!empty($_POST['jid']))?Doctrine_Core::getTable('UlsAssessmentEmployeeJourney')->find($_POST['jid']): new UlsAssessmentEmployeeJourney();
			$enroll->status='C';
			$enroll->save();
			redirect('employee/employee_self_assessment?jid='.$_POST['jid'].'&ass_type='.$_POST['ass_type'].'&assessment_id='.$_POST['assessment_id'].'&position_id='.$_POST['position_id'].'&emp_id='.$_POST['emp_id'].'&assessment_pos_id='.$_POST['assessment_pos_id']);
		}
	}
	
	public function employee_fishbone_details(){
		$this->sessionexist();	
		$data=array();
		$data['menu']="index";
		//unset($_SESSION['inbasket_time']);
		if(isset($_REQUEST['assess_test_id'])){
			$ass_test=UlsAssessmentTest::test_details($_REQUEST['assess_test_id']);
			$data['ass_details']=$ass_test;
			$emp_id=isset($_SESSION['e_emp_id']) ? $_SESSION['e_emp_id'] : $_SESSION['emp_id'];
			$test_id=$_REQUEST['test_id'];
			$ass_test_id=$_REQUEST['assess_test_id'];
			$fish_id=$_REQUEST['fish_id'];
			$pos_id=$ass_test['position_id'];
			$ass_id=$ass_test['assessment_id'];
			$data['ass_id']=$ass_id;
			$data['pos_id']=$pos_id;
			$data['fish_question']=UlsAssessmentTestQuestions::get_fishbone_questions_info($ass_test_id,$test_id);
			$data["fish_details"]=UlsFishboneMaster::viewfishbone($fish_id);
			$data["testdetails"]=UlsUtestResponsesAssessment::get_test_view_detail_fishbone($test_id,$ass_test_id,$ass_id);
			$data['responce_value']=UlsUtestResponsesAssessment::responce_values($emp_id,$ass_test_id,$ass_id);
			$data["aboutpage"]=$this->pagedetails('employee','emp_fishbone_assessment');
			$content = $this->load->view('employee/employee_fishbone_details',$data,true);
		}
		$this->render('layouts/employee_assessment',$content);	
	}
	
	public function fishbone_int_submit(){
		if(isset($_POST['submit_int'])){
			$this->session->set_userdata('inbasket_starttime',$_POST['start_period']);
			$this->session->set_userdata('inbasket_time',$_POST['time_period']);
			redirect('employee/employee_fishbone_details?status=strength&jid='.$_POST['jid'].'&assess_test_id='.$_POST['assess_test_id'].'&fish_id='.$_POST['fish_id'].'&test_id='.$_POST['test_id']);
		}
	}
	
	public function fishbone_three_submit(){
		if(isset($_POST['ass_test_id'])){
			if(($_POST['time_period']=='00:01') || ($_POST['time_period']=='0:1') || ($_POST['time_period']=='0:0')){
				if(isset($_SESSION['user_id'])){
					$testtype=$_POST['ttype'];
					$emp_id=isset($_SESSION['e_emp_id']) ? $_SESSION['e_emp_id'] : $_SESSION['emp_id'];
					if(isset($_POST['test_id']) || isset($_POST['resume'] ) ){
						print_r($_POST);
						$eveid=$_POST['assess_test_id'];
						$tidss=$tid=$_POST['test_id'];
						$evalid=$_POST['assid'];
						$teststatus=isset($_POST['resume'])?'RES':'COM';
						$testdeails=Doctrine_Core::getTable('UlsCompetencyTest')->findOneByTest_id($tid);
						$pass=0; $totscore=0; $wrongans=0;$correctans=0;$versionnum=1;
						$atts_status='COM';
						$notificationdata=new UlsUtestAttemptsAssessment();
						$notificationdata->employee_id=$emp_id;
						$notificationdata->elearning_object_id=0;
						$notificationdata->event_id=$eveid;
						$notificationdata->assessment_id=$evalid;
						$notificationdata->parent_org_id=$_SESSION['parent_org_id'];
						$notificationdata->version_number=$versionnum;
						$notificationdata->status='A';
						$notificationdata->timestamp= date('Y-m-d h:i:s', time());
						$notificationdata->performance_source="";
						$notificationdata->attempt_status=$atts_status;
						$notificationdata->test_status=$teststatus;
						$notificationdata->score=$pass;
						$notificationdata->correct_ans=$correctans;
						$notificationdata->wrong_ans=$wrongans;
						$notificationdata->timee=0;
						$notificationdata->test_id=$tidss;
						$notificationdata->test_type=$testtype;
						$notificationdata->internal_state="";
						$notificationdata->mastery_score=0;
						$notificationdata->start_period=date('Y-m-d h:i:s', strtotime($_POST['start_period']));
						$notificationdata->end_period=date('Y-m-d h:i:s');
						$notificationdata->save();
						$ass_details=UlsAssessmentTest::assessment_test_employee($eveid);
						redirect("employee/employee_ass_complete?jid=".$_POST['jid']."&pro=FISHBONE&asstype=".$ass_details['assessment_type']."&assessment_id=".$ass_details['assessment_id']."&position_id=".$ass_details['position_id']."&assessment_pos_id=".$ass_details['assessment_pos_id']);
					}	
				}
			}
			else{
				if(isset($_SESSION['user_id'])){
				
					$testtype=$_POST['ttype'];
					$emp_id=isset($_SESSION['e_emp_id']) ? $_SESSION['e_emp_id'] : $_SESSION['emp_id'];
					
					if(isset($_POST['testid'])){
						
						$eveid=$_POST['ass_test_id'];
						$tidss=$tid=$_POST['testid'];
						$evalid=$_POST['assid'];
						$teststatus=isset($_POST['resume'])?'RES':'COM';
						$testdeails=Doctrine_Core::getTable('UlsCompetencyTest')->findOneByTest_id($tid);
						// Deleting Previous Test Records
						$qtvalus=Doctrine_Query::create()->select('id')->from('UlsUtestQuestionsAssessment')->where("test_id=".$tid." and event_id=".$eveid." and employee_id=".$emp_id." and test_type='".$testtype."' and assessment_id=".$evalid." and parent_org_id=".$_SESSION['parent_org_id'])->execute();
						if(count($qtvalus)>0){
							foreach($qtvalus as $qtvalue){
								if(!empty($qtvalue['id'])){
									$del=Doctrine_Query::Create()->Delete('UlsUtestResponsesAssessment')->where("utest_question_id=".$qtvalue['id'])->execute();
								}
							}
						}
						Doctrine_Query::create()->delete('UlsUtestQuestionsAssessment')->where("test_id=".$tid." and event_id=".$eveid." and assessment_id=".$evalid." and employee_id=".$emp_id." and test_type='".$testtype."' and parent_org_id=".$_SESSION['parent_org_id'])->execute();
						$attval=Doctrine_Query::Create()->select('version_number as atts,attempt_id')->from('UlsUtestAttemptsAssessment')->where("employee_id=".$emp_id." and event_id=".$eveid." and parent_org_id=".$_SESSION['parent_org_id']." and assessment_id=".$evalid."  and  test_type='".$testtype."' and test_id=".$tid )->setHydrationMode(Doctrine::HYDRATE_ARRAY)->execute();
						if(count($attval)>0){ 
							//print_r($attval);
							foreach($attval as $attvals){
								$versionnum=$attvals['atts']+1;
								$qattempt=Doctrine_Core::getTable('UlsUtestAttemptsAssessment')->find($attvals['attempt_id']);
								$qattempt->status='I';
								$qattempt->save();
							}
						}
						else { $versionnum=1; }
						$pass=0; $totscore=0; $wrongans=0;$correctans=0;
							$question_values=new UlsUtestQuestionsAssessment();
							$question_values->employee_id=$emp_id;
							$question_values->parent_org_id=$_SESSION['parent_org_id'];
							$question_values->test_id=$tid;
							$question_values->assessment_id=$evalid;
							$question_values->event_id=$eveid;
							$question_values->test_type=$_POST['ttype'];  //we have to get it
							$question_values->status=$teststatus;
							$question_values->user_test_question_id=$_POST['question'];
							$question_values->save();
							
							if(isset($_POST['group'])){
								foreach($_POST['group'] as $key_n=>$ans){
									/* echo "<br>";
									print_r($ans."-".$_POST['headlist'][$key_n]); */
									$list_cause=explode(",",$ans);
									foreach($list_cause as $k=>$list_values){
										/* echo "<br>";
										print_r($list_values."-".$_POST['headlist'][$key_n]); */
										$top_reason=($k==0)?"1":"";
										$results[]= array('id' => $list_values, 'head' => $_POST['headlist'][$key_n],'reason' => $top_reason);
										$output = ($results);
										$texts=$output;
									}
								}
								/* echo "<pre>";
								print_r($texts); */
							}
							$corec="";
							$text="";
							$respid="";
							$text=json_encode($texts);
							$questions=new UlsUtestResponsesAssessment();
							$questions->utest_question_id=$question_values->id;
							$questions->parent_org_id=$_SESSION['parent_org_id'];
							$questions->employee_id=$emp_id;
							$questions->assessment_id=$evalid;
							$questions->user_test_question_id=$_POST['question'];
							$questions->test_type=$testtype;
							$questions->response_value_id=$respid;
							$questions->event_id=$eveid;
							$questions->response_type_id='FB';
							$questions->answered_flag='';
							$questions->text=$text;
							$questions->correct_flag=$corec;
							$questions->points=0;
							$questions->save();
						
						$atts_status='COM';
						$attp_value=UlsUtestAttemptsAssessment::getattemptvalus($evalid,$emp_id,$eveid,$testtype);
						$notificationdata=!empty($attp_value['attempt_id'])?Doctrine::getTable('UlsUtestAttemptsAssessment')->find($attp_value['attempt_id']): new UlsUtestAttemptsAssessment();
						$notificationdata->employee_id=$emp_id;
						$notificationdata->elearning_object_id=0;
						$notificationdata->event_id=$eveid;
						$notificationdata->assessment_id=$evalid;
						$notificationdata->parent_org_id=$_SESSION['parent_org_id'];
						$notificationdata->version_number=$versionnum;
						$notificationdata->status='A';
						$notificationdata->timestamp= date('Y-m-d h:i:s', time());
						$notificationdata->performance_source="";
						$notificationdata->attempt_status=$atts_status;
						$notificationdata->test_status=$teststatus;
						$notificationdata->score=$pass;
						$notificationdata->correct_ans=$correctans;
						$notificationdata->wrong_ans=$wrongans;
						$notificationdata->timee=0;
						$notificationdata->test_id=$tidss;
						$notificationdata->test_type=$testtype;
						$notificationdata->internal_state="";
						$notificationdata->mastery_score=0;
						$notificationdata->start_period=date('Y-m-d h:i:s', strtotime($_POST['start_period']));
						$notificationdata->save();
						redirect('employee/employee_fishbone_details?status=development&jid='.$_POST['jid'].'&assess_test_id='.$_POST['ass_test_id'].'&fish_id='.$_POST['fish_id'].'&test_id='.$_POST['testid'].'&attempt_id='.$notificationdata->attempt_id);
					}
					
				}
				
			}
		}
	}
	
	public function fishbone_four_submit(){
		if(isset($_SESSION['user_id'])){
			$testtype=$_POST['ttype'];
			$emp_id=isset($_SESSION['e_emp_id']) ? $_SESSION['e_emp_id'] : $_SESSION['emp_id'];
			if(isset($_POST['testid']) || isset($_POST['resume'] ) ){
				$update=Doctrine_Query::create()->update('UlsUtestAttemptsAssessment');
				$update->set('end_period','?',date('Y-m-d h:i:s'));
				$update->where('attempt_id=?',$_POST['attempt_id']);
				$update->execute();
				$this->session->set_userdata('fish_comp',1);
				$ass_details=UlsAssessmentTest::assessment_test_employee($_POST['ass_test_id']);
				redirect("employee/employee_ass_complete?jid=".$_POST['jid']."&pro=FISHBONE&asstype=".$ass_details['assessment_type']."&assessment_id=".$ass_details['assessment_id']."&position_id=".$ass_details['position_id']."&assessment_pos_id=".$ass_details['assessment_pos_id']);
			}				
		}
		
	}
	
	public function employee_assessment_competency(){
		$this->sessionexist();	
		$data=array();
		$data['menu']="index";
		$posdetails=UlsPosition::viewposition($_REQUEST['pos_id']);
		$data['posdetails']=$posdetails;
		$data['ass_details']=UlsAssessmentDefinition::viewassessment($_REQUEST['ass_id']);
		$data["aboutpage"]=$this->pagedetails('employee','emp_fishbone_assessment');
		$data["emp_feedback"]=UlsAssessmentEmployeeJourney::get_employees_details($_REQUEST['jid']);
		$content = $this->load->view('employee/employee_assessment_competency',$data,true);
		$this->render('layouts/employee_assessment',$content);	
	}
	
	public function employee_assessment_rating(){
		$this->sessionexist();	
		$data=array();
		$data['menu']="index";
		$posdetails=UlsPosition::viewposition($_REQUEST['pos_id']);
		$data['posdetails']=$posdetails;
		$data['ass_details']=UlsAssessmentDefinition::viewassessment($_REQUEST['ass_id']);
		$data["aboutpage"]=$this->pagedetails('employee','emp_fishbone_assessment');
		$data["emp_feedback"]=UlsAssessmentEmployeeJourney::get_employees_details($_REQUEST['jid']);
		$content = $this->load->view('employee/employee_assessment_rating',$data,true);
		$this->render('layouts/employee_assessment',$content);	
	}
	
	public function employee_competency_insert(){
		/* echo "<pre>";
			print_r($_POST);
			exit(); */
		if(isset($_POST['group'])){
			
			if(!empty($_POST['emp_id']) && !empty($_POST['pos_id']) && !empty($_POST['ass_id'])){
				
			$del=Doctrine_Query::create()->delete('UlsAssessmentEmployeeDevCompetencies')->where("assessment_id=".$_POST['ass_id']." and position_id=".$_POST['pos_id']." and employee_id=".$_POST['emp_id'])->execute();
			
			foreach($_POST['group'] as $k=>$comp_id){
				if(isset($comp_id)){
					
						/* echo "<pre>";
						print_r($val);
						exit(); */
						$work_activation=new UlsAssessmentEmployeeDevCompetencies();
						$work_activation->assessment_id=$_POST['ass_id'];
						$work_activation->position_id=$_POST['pos_id'];
						$work_activation->employee_id=$_POST['emp_id'];
						$work_activation->comp_def_id=$comp_id;
						$work_activation->scale_id=$_POST['req_id'][$comp_id];
						$work_activation->save();
						
					
				}
				
			}
			$tna=!empty($_POST['tna_id'])?"&tna=1":"";
			redirect("employee/employee_assessment_rating?ass_type=ASS".$tna."&jid=".$_POST['jid']."&ass_id=".$_POST['ass_id']."&pos_id=".$_POST['pos_id']."&emp_id=".$_POST['emp_id']);
			}
		}
	}
	
	public function employee_rating_insert(){
		if(isset($_POST['comp_id'])){
			/* echo "<pre>";
			print_r($_POST);
			exit(); */
			if(!empty($_POST['emp_id']) && !empty($_POST['pos_id']) && !empty($_POST['ass_id'])){
				
			$del=Doctrine_Query::create()->delete('UlsAssessmentEmployeeDevRating')->where("assessment_id=".$_POST['ass_id']." and position_id=".$_POST['pos_id']." and employee_id=".$_POST['emp_id'])->execute();
			
			foreach($_POST['comp_id'] as $k=>$comp_id){
				$select_value=$_POST['group'.$comp_id];
				if(isset($select_value)){
					
					foreach($select_value as $key=>$val){
						/* echo "<pre>";
						print_r($val);
						exit(); */
						$emp_info=UlsEmployeeMaster::getempdetails($_POST['emp_id']);
						$work_activation=new UlsAssessmentEmployeeDevRating();
						$work_activation->assessment_id=$_POST['ass_id'];
						$work_activation->position_id=$_POST['pos_id'];
						$work_activation->employee_id=$_POST['emp_id'];
						$work_activation->org_id=$emp_info['org_id'];
						$work_activation->grade_id=$emp_info['grade_id'];
						$work_activation->location_id=$emp_info['location_id'];
						$work_activation->comp_def_id=$comp_id;
						$work_activation->scale_id=$_POST['req_id'][$k];
						$work_activation->comp_def_level_ind_id=$val;
						$work_activation->save();
						
					}
				}
				
			}
			
			$tna=!empty($_POST['tna_id'])?"&tna=1":"";
			redirect("employee/employee_assessment_rating_view?ass_type=ASS".$tna."&jid=".$_POST['jid']."&ass_id=".$_POST['ass_id']."&pos_id=".$_POST['pos_id']."&emp_id=".$_POST['emp_id']); 
			}
		}
	}
	
	public function employee_assessment_rating_view(){
		$this->sessionexist();	
		$data=array();
		$data['menu']="index";
		$data['ass_details']=UlsAssessmentDefinition::viewassessment($_REQUEST['ass_id']);
		$data['ass_final']=UlsAssessmentEmployeeDevRating::get_emp_rating_view_final($_REQUEST['ass_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id']);
		$data['ass_ind_final']=UlsAssessmentEmployeeDevRating::get_emp_indicator_final($_REQUEST['ass_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id']);
		$data["emp_feedback"]=UlsAssessmentEmployeeJourney::get_employees_details($_REQUEST['jid']);
		$content = $this->load->view('employee/employee_assessment_rating_view',$data,true);
		$this->render('layouts/employee_assessment',$content);	
	}
	
	public function employee_program_insert(){
		if(isset($_POST['comp_programs'])){
			/* echo "<pre>";
			print_r($_POST);
			exit(); */
			if(!empty($_POST['emp_id']) && !empty($_POST['pos_id']) && !empty($_POST['ass_id'])){
				
			$del=Doctrine_Query::create()->delete('UlsAssessmentEmployeeSelectPrograms')->where("assessment_id=".$_POST['ass_id']." and position_id=".$_POST['pos_id']." and employee_id=".$_POST['emp_id'])->execute();
			if(isset($_POST['total_programs'])){
				$ta_progams=explode(",",$_POST['total_programs']);
				foreach($_POST['comp_program_year'] as $del_val){
					if (($key = array_search($del_val, $ta_progams)) !== false) {
						unset($ta_progams[$key]);
					}
				}
			}
			/* print_r($_POST['comp_program_year']);
			print_r($ta_progams);
			exit(); */
			foreach($_POST['comp_program_year'] as $pro_id){
				$work_activation=new UlsAssessmentEmployeeSelectPrograms();
				$work_activation->assessment_id=$_POST['ass_id'];
				$work_activation->position_id=$_POST['pos_id'];
				$work_activation->employee_id=$_POST['emp_id'];
				$work_activation->comp_def_id=$_POST['comp_def_id'][$pro_id];
				$work_activation->comp_def_level_id=$_POST['comp_def_level_id'][$pro_id];
				$work_activation->ass_scale_id=!empty($_POST['ass_scale_id'][$pro_id])?$_POST['ass_scale_id'][$pro_id]:NULL;
				$work_activation->tna_year=1;
				$work_activation->comp_def_pro_id=$pro_id;
				$work_activation->save();
				
			}
			if(isset($ta_progams)){
				foreach($ta_progams as $program_id){
					$work_activation=new UlsAssessmentEmployeeSelectPrograms();
					$work_activation->assessment_id=$_POST['ass_id'];
					$work_activation->position_id=$_POST['pos_id'];
					$work_activation->employee_id=$_POST['emp_id'];
					$work_activation->comp_def_id=$_POST['comp_def_id'][$program_id];
					$work_activation->comp_def_level_id=$_POST['comp_def_level_id'][$program_id];
					$work_activation->ass_scale_id=!empty($_POST['ass_scale_id'][$program_id])?$_POST['ass_scale_id'][$program_id]:NULL;
					$work_activation->tna_year=2;
					$work_activation->comp_def_pro_id=$program_id;
					$work_activation->save();
					
				}
			}
			$update=Doctrine_Query::create()->update('UlsAssessmentEmployeeJourney');
			$update->set('feed_status','?','C');
			$update->set('feed_q1','?',$_POST['Q1']);
			$update->set('feed_q2','?',$_POST['Q4']);
			$update->set('tni_status','?',1);
			$update->where('id=?',$_POST['jid']);
			$update->limit(1)->execute();
			redirect("employee/employee_tna_complete?ass_type=ASS&jid=".$_POST['jid']."&ass_id=".$_POST['ass_id']."&pos_id=".$_POST['pos_id']."&emp_id=".$_POST['emp_id']);
			//redirect("employee/employee_tna_complete");
			}
		}
	}
	
	public function employee_tna_complete(){
		$this->sessionexist();	
		$this->load->library('pdfgenerator');
		$data=array();
		$data['menu']="index";
		$id=isset($_REQUEST['ass_id'])? $_REQUEST['ass_id']:"";
		$data['ass_id']=$id;
		$data['pos_id']=$_REQUEST['pos_id'];
		$data['emp_id']=$_REQUEST['emp_id'];
		$id=isset($_REQUEST['ass_id'])? $_REQUEST['ass_id']:"";
		$posdetails=UlsPosition::viewposition($_REQUEST['pos_id']);
		$data['posdetails']=$posdetails;
		$empd=UlsEmployeeMaster::get_empdetails_id($_REQUEST['emp_id']);
		$data['emp_info']=$empd;
		$data['competencies']=UlsAssessmentCompetencies::getassessment_competencies_type($id,$_REQUEST['pos_id']);
		$data['ass_results']=UlsAssessmentTest::assessment_results($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
		$data['assessor_rating_new']=UlsAssessmentAssessorRating::assessor_results_report_new($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
		//$data['assessor_rating']=UlsAssessmentAssessorRating::assessor_results_report($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
		$ass_details=UlsAssessmentDefinition::viewassessment($id);
		$data['ass_details']=$ass_details;
		$data['ass_rating_scale']=UlsAssessmentDefinition::view_assessment_rating($id);

		$data['ass_development']=UlsAssessmentReport::getassessment_competencies_summary_report($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
		$data['ass_rating_comments']=UlsAssessmentAssessorRating::get_ass_rating_comments($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);

		/* include("radargraph_full_admin.php");
		$content = $this->load->view('pdf/assessment_report',$data,true); */
		require_once(LIB_PATH.DS.DS.'graph'.DS.'includes'.DS.'SVGGraph.php');
		$settings = array(
			'back_colour'       => '#fff',    'stroke_colour'      => '#666',
			'back_stroke_width' => 0,         'back_stroke_colour' => '#fff',
			'axis_colour'       => '#666',    'axis_overlap'       => 2,
			'axis_font'         => 'Georgia', 'axis_font_size'     => 12,
			'grid_colour'       => '#666',    'label_colour'       => '#666',
			'pad_right'         => 50,        'pad_left'           => 50,
			'link_base'         => '/',       'link_target'        => '_top',
			'fill_under'        => false,	  'line_stroke_width'=>5,
			'marker_size'       => 6,		  'axis_max_v'  => 4, 'grid_division_v' =>1,
			'minimum_subdivision' =>5,
			//'marker_type'       => array('*', 'star'),
			//'marker_colour'     => array('#008534', '#850000')
			'legend_position' => "outer bottom 0 0",
			'legend_stroke_width' => 0,
			'legend_shadow_opacity' => 0,
			'legend_title' => "Legend", 'legend_colour' => "#666",
			'legend_columns' => 4,
			'legend_text_side' => "right",
			'legend_font_size'=>15,
			'reverse'=>true
		);
		$settings['legend_entries'] = array('Required Level', 'Assessed Level');
		$assresults=UlsAssessmentTest::assessment_results_avg($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
		$results=$ass_comname=$ass_req_sid=$ass_given_sid=array();
		foreach($assresults as $assresult){
			$compid=$assresult['comp_def_id'];
			$finalval=!empty($assresult['assessor_val'])?round(($assresult['ass_scale_number']*$assresult['assessor_val']),2):$assresult['ass_scale_number'];
			$results[$assresult['comp_def_id']]['comp_id']=$compid;
			$results[$assresult['comp_def_id']]['comp_name']=$assresult['comp_def_name'];
			$results[$assresult['comp_def_id']]['req_val']=$assresult['req_number'];
			$results[$assresult['comp_def_id']]['assessor'][$assresult['assessor_id']]=$finalval;
		}
		$req_sid=$ass_sid=$comname=array();
		$k=1;
		if(count($results)>0){
			foreach($results as $key1=>$result){
				$comp_id[$key1]="C".($k);
				$comname[$key1]=$result['comp_name'];
				$req_sid[$key1]=$result['req_val'];
				$final=0;
				foreach($result['assessor'] as $key2=>$ass_id){
					$final=$final+$results[$key1]['assessor'][$key2];
				}
				$final=round($final/count($results[$key1]['assessor']),2);
				$ass_sid[$key1]=$final;
				$k++;
			}
		}

		if($ass_details['ass_comp_selection']=='N'){
		$val=array();
		$val_required=array_combine($comp_id,$req_sid);
		$val_assessed=array_combine($comp_id,$ass_sid);
		$values = array($val_required,$val_assessed);
		$colours = array(array('#b12c43', '#b12c43'), array('#008534', '#008534'));
		$graph = new SVGGraph(500, 500, $settings);
		$graph->colours = $colours;
		$graph->Values($values);
		$value11=$graph->Fetch('MultiRadarGraph', false);//$graph->Fetch('MultiRadarGraph', false);
		$target_path=__SITE_PATH.DS.'public'.DS.'reports'.DS.'graphs'.DS.'full'.DS.$id;
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

		$myfile = fopen($target_path.DS.$_REQUEST['emp_id']."_".$_REQUEST['pos_id'].'_radar.svg', "w") or die("Unable to open file!");
		//$target_path='public'.DS.'feedback'.DS.$feedid.DS.$name.'.svg';
		//$myfile = fopen($target_path, "w") or die("Unable to open file!");
		fwrite($myfile, $value11);
		fclose($myfile);
		}
		$data['ass_final']=UlsAssessmentEmployeeSelectPrograms::get_emp_rating_final($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
		$data['ass_final_next']=UlsAssessmentEmployeeSelectPrograms::get_emp_rating_final_next($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
		$data['competencies']=UlsAssessmentCompetencies::getassessment_competencies($id,$_REQUEST['pos_id']);

		$pdf_content = $this->load->view('pdf/assessment_tna_report_single_new',$data,true);
		
		$filename = "Employee-TNA-single-report-".$empd['enumber']."-".trim($empd['name']);
		$this->pdfgenerator->generate($pdf_content, $filename, false, 'A4', 'portrait','tna_reports');
		$emails=UlsMenu::callpdorow("SELECT * FROM `employee_data` WHERE `employee_id`=".$_REQUEST['emp_id']);
		if(!empty($emails['supervisor_id'])){
		$emailsup=UlsMenu::callpdorow("SELECT * FROM `employee_data` WHERE `employee_id`=".$emails['supervisor_id']);
		if(!empty($emailsup['email'])){
			$checkmail=UlsMenu::callpdorow("SELECT * FROM `uls_notification_history` where employee_id=".$emailsup['employee_id']." and mail_type='TNA'");
			
			if(!isset($checkmail['notification_history_id'])){
				$ss=new UlsNotificationHistory();
				$ss->employee_id=$emailsup['employee_id'];
				$ss->to=$emailsup['email'];
				//$ss->cc="";
				$ss->timestamp=date('Y-m-d H:i:s');
				$ss->subject="TNI Report of Direct Subordinate";
				$ss->notification_id=NULL;
				$ss->mail_type='TNA';
				$ss->attachment=$filename;
				$ss->mail_content='Dear '.trim($emailsup['full_name']).',<br><br>Thank you for taking the time to complete the Training Needs Identification (TNI) of your direct subordinates. Attached with this email is a consolidated summary of the training needs of the subordinates for whom you have provided the training needs data.<br><br>You can also view the summary online by clicking on the link http://l-kurve.com/adani and using <b>'.trim($emailsup['employee_number']).'</b> in the "Login" box.<br><br>If you have any questions, please feel free to contact us on info@unitol.in with "Adani TNI Query // Your employee number" in the subject line of your email.<br><br>Regards,<br>UniTol Team';
				$ss->save();
			}
		}
		}
		$content = $this->load->view('employee/employee_tna_complete',$data,true);
		$this->render('layouts/employee_assessment',$content);	
	}
	
	public function final_tni(){
		if(isset($_POST['submit'])){
			$update=Doctrine_Query::create()->update('UlsAssessmentEmployeeJourney');
			$update->set('tni_status','?',1);
			$update->where('id=?',$_POST['jid']);
			$update->limit(1)->execute();
			redirect("admin/profile"); 
		}
	}
	
	public function employee_assessment_rating_final(){
		$this->sessionexist();	
		$data=array();
		$data['menu']="index";
		$data['ass_details']=UlsAssessmentDefinition::viewassessment($_REQUEST['ass_id']);
		$data['ass_final']=UlsAssessmentEmployeeSelectPrograms::get_emp_rating_final($_REQUEST['ass_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id']);
		$data['ass_ind_final']=UlsAssessmentEmployeeDevRating::get_emp_indicator_final($_REQUEST['ass_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id']);
		$data["emp_feedback"]=UlsAssessmentEmployeeJourney::get_employees_details($_REQUEST['jid']);
		$content = $this->load->view('employee/employee_assessment_rating_final',$data,true);
		$this->render('layouts/employee_assessment',$content);	
	}
	
	public function employee_reportees(){
		$data=array();
		$data['menu']="index";
		$emp_id=$this->session->userdata('emp_id');
		$data['reportees_data']=UlsEmployeeMaster::fetch_reportees_detail_emp($emp_id);
		$data["aboutpage"]=$this->pagedetails('employee','emp_assessment');
		$content = $this->load->view('employee/employee_reportees',$data,true);
		$this->render('layouts/employee_layout',$content);	
	}
	
	public function employee_ins_details(){
		$this->sessionexist();	
		$data=array();
		$data['menu']="index";
		if(isset($_REQUEST['assess_test_id'])){
			$ass_test=UlsAssessmentTest::test_details($_REQUEST['assess_test_id']);
			$data['ass_details']=$ass_test;
			$ass_id=$ass_test['assessment_id'];
			$instrument_id=$_REQUEST['instrument_id'];
			$data['testdetails']=UlsBeiResponsesAssessment::get_test_view_details_beh($_REQUEST['assess_test_id'],$ass_id,$instrument_id);
			$data['ass_lang']=UlsAssessmentDefinition::get_lang_ass_type($ass_id);
			$data["aboutpage"]=$this->pagedetails('employee','emp_instrument_assessment');
			$content = $this->load->view('employee/employee_instrument_details',$data,true);
		}
		$this->render('layouts/employee_assessment',$content);	
	}
	
	public function employee_feed_details(){
		$this->sessionexist();	
		$data=array();
		$data['menu']="index";
		if(isset($_REQUEST['assess_test_id'])){
			$ass_test=UlsAssessmentTest::test_details($_REQUEST['assess_test_id']);
			$data['ass_details']=$ass_test;
			$emp_id=isset($_SESSION['e_emp_id']) ? $_SESSION['e_emp_id'] : $_SESSION['emp_id'];
			$ass_test_id=$_REQUEST['assess_test_id'];
			$ass_id=$ass_test['assessment_id'];
			$position_id=$ass_test['position_id'];
			$group_details=UlsAssessmentFeedEmployees::getfeed_assessment($ass_id,$position_id,$emp_id);
			$data['group_info']=$group_details;
			$group_id=$group_details['group_id'];
			
			$checkalreadyteststarted=UlsMenu::callpdo("select * from uls_feedback_employee_rating where ass_test_id=$ass_test_id and assessment_id=$ass_id and group_id=$group_id and employee_id=$emp_id and giver_id=$emp_id");
			if(count($checkalreadyteststarted)==0){
				$testques=UlsMenu::callpdo("SELECT b.`ques_element_id`,b.`ques_id`,b.`element_id_edit`,b.`element_competency_id`,b.`element_level_scale_id`,a.* FROM `uls_assessment_test_feedback` a
				left join(SELECT `ques_element_id`,`ques_id`,`element_id_edit`,`element_competency_id`,`element_level_scale_id` FROM `uls_questionnaire_competency_element`) b on a.ques_id=b.ques_id
				where a.`assess_test_id`=".$_REQUEST['assess_test_id']." and a.`position_id`=".$ass_test['position_id']." and a.`assessment_id`=".$ass_test['assessment_id']."");
				foreach($testques as $testque){
					$testq=new UlsFeedbackEmployeeRating();
					$testq->employee_id=$emp_id;
					$testq->giver_id=$emp_id;
					$testq->ques_element_id=$testque['ques_element_id'];
					$testq->ass_test_id=$ass_test_id;
					$testq->assessment_id=$ass_id;
					$testq->group_id=$group_id;
					$testq->ques_id=$testque['ques_id'];
					$testq->element_competency_id=$testque['element_competency_id'];
					$testq->element_level_scale_id=$testque['element_level_scale_id'];
					$testq->status='W';
					$testq->save();
				}
			}
			$data['testdetails']=UlsMenu::callpdo("select b.*,a.* from uls_feedback_employee_rating a ,uls_questionnaire_competency_element b where a.ques_element_id=b.ques_element_id and a.ass_test_id=".$ass_test_id." and a.assessment_id=".$ass_id ." and a.employee_id=$emp_id and a.giver_id=$emp_id");
			$data['ass_lang']=UlsAssessmentDefinition::get_lang_ass_type($ass_id);
			$data["aboutpage"]=$this->pagedetails('employee','emp_feedback_assessment');
			$content = $this->load->view('employee/employee_feed_details',$data,true);
		}
		$this->render('layouts/employee_assessment',$content);	
	}
	
	public function insert_feedback_question_answers()
	{
	    $question_id=$_REQUEST['question_id'];
		$testtype=$_REQUEST['type'];
		$assess_test_id=$_REQUEST['assess_test_id'];
		$assessment_id=$_REQUEST['assessment_id'];
		$group_id=$_REQUEST['group_id'];
		$ans=$_REQUEST['ans'];
		$qtype=$_REQUEST['qtype'];
		$skipv=$_REQUEST['skip_v'];
		$teststatus='COM';
		$emp_id=isset($_SESSION['e_emp_id']) ? $_SESSION['e_emp_id'] : $_SESSION['emp_id'];
		$pass=0; $totscore=0; $wrongans=0;$correctans=0;
		
		$checkalreadyteststarted=UlsMenu::callpdorow("select * from uls_feedback_employee_rating where ass_test_id=$assess_test_id and assessment_id=$assessment_id and group_id=$group_id and ques_element_id=$question_id and giver_id=$emp_id and employee_id=$emp_id");
		if($ans=='undefined'){$ans="";}
		if(isset($checkalreadyteststarted['feed_id'])){
			$empquesans=Doctrine_Core::getTable('UlsFeedbackEmployeeRating')->find($checkalreadyteststarted['feed_id']);
			$empquesans->giver_id=$emp_id;
			$empquesans->rater_value=!empty($ans)?$ans:NULL;
			$empquesans->status='W';
			$empquesans->save();
		}
		echo $skipv;
    }
	
	public function employee_feedback(){
		$this->sessionexist();
		if(isset($_SESSION['user_id'])){
			$this->pagedetails('admin','employee_test');
			$assessment_id=$_POST['assid'];
			$testtype=$_POST['ttype'];
			$assess_test_id=$_POST['ass_test_id'];
			$group_id=$_POST['group_id'];
			$emp_id=isset($_SESSION['e_emp_id']) ? $_SESSION['e_emp_id'] : $_SESSION['emp_id'];
			if(isset($_POST['empid'])){
				//print_r($_POST);
				foreach($_POST['question'] as $key=>$val){
					$button=isset($_POST['save_con'])?"W":"C";
                    $anss='answer_'.$key;
                    $checkalreadyteststarted=UlsMenu::callpdorow("select * from uls_feedback_employee_rating where ass_test_id=$assess_test_id and assessment_id=$assessment_id and group_id=$group_id and ques_element_id=$val and giver_id='$emp_id' and employee_id=$emp_id");
					$question_values=Doctrine_Core::getTable('UlsFeedbackEmployeeRating')->find($checkalreadyteststarted['feed_id']);
					$question_values->status=$button;
					$question_values->giver_id=$emp_id;
					if(isset($_POST[$anss])){
						foreach($_POST[$anss] as $key_n=>$ans){
							$question_values->rater_value=!empty($ans)?$ans:NULL;
						}
					}
                    $question_values->save();
                } 
				$ass_details=UlsAssessmentTest::assessment_test_employee($assess_test_id);
				$this->session->set_userdata('feedback_comp',1);
				if(isset($_POST['save_con'])){
					redirect("employee/employee_assessment_details?jid=".$_POST['jid']."&pro=FEEDBACK&asstype=".$ass_details['assessment_type']."&assessment_id=".$ass_details['assessment_id']."&position_id=".$ass_details['position_id']."&assessment_pos_id=".$ass_details['assessment_pos_id']);
				}
				else{
					redirect("employee/employee_ass_complete?jid=".$_POST['jid']."&pro=FEEDBACK&asstype=".$ass_details['assessment_type']."&assessment_id=".$ass_details['assessment_id']."&position_id=".$ass_details['position_id']."&assessment_pos_id=".$ass_details['assessment_pos_id']);
				}
				
			}
		} 
    }
	
	public function feedback_rating(){
		$this->sessionexist();	
		$data=array();
		$data['menu']="index";
		$data["aboutpage"]=$this->pagedetails('employee','emp_assessment');
		$feedothers=UlsAssessmentFeedEmployees::get_feed_empothers($_SESSION['emp_id']);
		$data['feed_others_details']=$feedothers;
		$content = $this->load->view('employee/employee_other_feedback',$data,true);
		$this->render('layouts/employee_layout',$content);	
	}
	
	public function employee_feed_other_rating(){
		$this->sessionexist();	
		$data=array();
		$data['menu']="index";
		if(isset($_REQUEST['assess_test_id'])){
			$ass_test=UlsAssessmentTest::test_details($_REQUEST['assess_test_id']);
			$data['ass_details']=$ass_test;
			$emp_id=isset($_SESSION['e_emp_id']) ? $_SESSION['e_emp_id'] : $_SESSION['emp_id'];
			$seeker_id=$_REQUEST['sid'];
			$ass_test_id=$_REQUEST['assess_test_id'];
			$ass_id=$ass_test['assessment_id'];
			$position_id=$ass_test['position_id'];
			$group_details=UlsAssessmentFeedEmployees::getfeed_assessment($ass_id,$position_id,$seeker_id);
			$data['group_info']=$group_details;
			$group_id=$group_details['group_id'];
			//echo "select * from uls_feedback_employee_rating where ass_test_id=$ass_test_id and assessment_id=$ass_id and group_id=$group_id and giver_id=$emp_id and employee_id=$seeker_id";
			$checkalreadyteststarted=UlsMenu::callpdo("select * from uls_feedback_employee_rating where ass_test_id=$ass_test_id and assessment_id=$ass_id and group_id=$group_id and giver_id=$emp_id and employee_id=$seeker_id");
			if(count($checkalreadyteststarted)==0){
				$testques=UlsMenu::callpdo("SELECT b.`ques_element_id`,b.`ques_id`,b.`element_id_edit`,b.`element_competency_id`,b.`element_level_scale_id`,a.* FROM `uls_assessment_test_feedback` a
				left join(SELECT `ques_element_id`,`ques_id`,`element_id_edit`,`element_competency_id`,`element_level_scale_id` FROM `uls_questionnaire_competency_element`) b on a.ques_id=b.ques_id
				where a.`assess_test_id`=".$_REQUEST['assess_test_id']." and a.`position_id`=".$ass_test['position_id']." and a.`assessment_id`=".$ass_test['assessment_id']."");
				foreach($testques as $testque){
					$testq=new UlsFeedbackEmployeeRating();
					$testq->employee_id=$seeker_id;
					$testq->giver_id=$emp_id;
					$testq->ques_element_id=$testque['ques_element_id'];
					$testq->ass_test_id=$ass_test_id;
					$testq->assessment_id=$ass_id;
					$testq->group_id=$group_id;
					$testq->ques_id=$testque['ques_id'];
					$testq->element_competency_id=$testque['element_competency_id'];
					$testq->element_level_scale_id=$testque['element_level_scale_id'];
					$testq->save();
				}
			}
			$data['testdetails']=UlsMenu::callpdo("select b.*,a.* from uls_feedback_employee_rating a ,uls_questionnaire_competency_element b where a.ques_element_id=b.ques_element_id and a.ass_test_id=".$ass_test_id." and a.assessment_id=".$ass_id ." and giver_id=$emp_id and a.employee_id=$seeker_id");
			
			$data["aboutpage"]=$this->pagedetails('employee','emp_feedback_assessment_others');
			$content = $this->load->view('employee/employee_feed_other_details',$data,true);
		}
		$this->render('layouts/employee_assessment',$content);	
	}
	
	public function employee_feedback_others(){
		$this->sessionexist();
		if(isset($_SESSION['user_id'])){
			$this->pagedetails('admin','employee_test');
			$assessment_id=$_POST['assid'];
			$group_id=$_POST['group_id'];
			$testtype=$_POST['ttype'];
			$assess_test_id=$_POST['ass_test_id'];
			$seeker_id=$_POST['seeker_id'];
			$emp_id=isset($_SESSION['e_emp_id']) ? $_SESSION['e_emp_id'] : $_SESSION['emp_id'];
			if(isset($_POST['empid'])){
				//print_r($_POST);
				foreach($_POST['question'] as $key=>$val){
					$button=isset($_POST['save_con'])?"W":"C";
                    $anss='answer_'.$key;
                    $checkalreadyteststarted=UlsMenu::callpdorow("select * from uls_feedback_employee_rating where ass_test_id=$assess_test_id and assessment_id=$assessment_id and group_id=$group_id and ques_element_id=$val and giver_id=$emp_id and employee_id=$seeker_id");
					$question_values=Doctrine_Core::getTable('UlsFeedbackEmployeeRating')->find($checkalreadyteststarted['feed_id']);
					$question_values->giver_id=$emp_id;
					if(isset($_POST[$anss])){
						foreach($_POST[$anss] as $key_n=>$ans){
							$question_values->rater_value=!empty($ans)?($ans=='A')?0:$ans:NULL;
						}
					}
					$question_values->status=$button;
                    $question_values->save();
                }
				redirect("employee/feedback_rating");
			}
		} 
    }
	
	public function insert_others_feedback_question_answers()
	{
	    $question_id=$_REQUEST['question_id'];
		$testtype=$_REQUEST['type'];
		$assess_test_id=$_REQUEST['assess_test_id'];
		$assessment_id=$_REQUEST['assessment_id'];
		$seeker_id=$_REQUEST['seeker_id'];
		$ans=$_REQUEST['ans'];
		$qtype=$_REQUEST['qtype'];
		$skipv=$_REQUEST['skip_v'];
		$group_id=$_REQUEST['group_id'];
		$teststatus='COM';
		$emp_id=isset($_SESSION['e_emp_id']) ? $_SESSION['e_emp_id'] : $_SESSION['emp_id'];
		$pass=0; $totscore=0; $wrongans=0;$correctans=0;
		
		$checkalreadyteststarted=UlsMenu::callpdorow("select * from uls_feedback_employee_rating where ass_test_id=$assess_test_id and assessment_id=$assessment_id and group_id=$group_id and ques_element_id=$question_id and giver_id=$emp_id and employee_id=$seeker_id");
		if($ans=='undefined'){$ans="";}
		if(isset($checkalreadyteststarted['feed_id'])){
			$empquesans=Doctrine_Core::getTable('UlsFeedbackEmployeeRating')->find($checkalreadyteststarted['feed_id']);
			$empquesans->giver_id=$emp_id;
			$empquesans->rater_value=!empty($ans)?$ans:NULL;
			$empquesans->status='W';
			$empquesans->save();
		}
		echo $skipv;
    }
}

