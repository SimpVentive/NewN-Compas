<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Manager extends  MY_Controller {	
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
		$man_id=$this->session->userdata('man_id');		
		$data['userdetails']=UlsEmployeeMaster::getempdetails($man_id);
		$content = $this->load->view('manager/manager_profile',$data,true);
		$this->render('layouts/manager_layout',$content);	
	}
	
	public function changepassword()
	{
		$data=array();
        $this->pagedetails('admin','changepassword');
        if(isset($_POST['password'])){
            $checkuser=Doctrine::getTable('UlsUserCreation')->find($this->session->userdata('user_id'));
            if(isset($checkuser->user_id)){
                $checkuser->password=(!empty($_POST['password']))?trim($_POST['password']):'welcome';
                $checkuser->user_login=1;
                $checkuser->save();
                $this->registry->template->message="Password change successfully";
				redirect("manager/profile");
            }
            else{
                $data['message']="Some error occurred please try again";
            }
        }
		$content = $this->load->view('manager/manager_changepassword',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function assessor_assessment(){
		$data=array();
		$data['menu']="index";
		$man_id=$this->session->userdata('man_id');
		$data['assessments']=UlsEmployeeMaster::fetch_manager_emp_details($man_id);
		$data["aboutpage"]=$this->pagedetails('employee','emp_assessment');
		$content = $this->load->view('manager/manager_assessment',$data,true);
		$this->render('layouts/adminnew',$content);	
	}
	
	public function employee_skill_assessment(){
		$this->sessionexist();
		$data=array();
		$man_id=$this->session->userdata('man_id');
		$data['sup_emp']=UlsEmployeeMaster::fetch_super_employee($man_id);
		$content = $this->load->view('manager/employee_skill_assessment',$data,true);
		$this->render('layouts/manager_layout',$content);
	}
	
	public function employee_skill_other_assessment(){
		$this->sessionexist();
		$data=array();
		$man_id=$this->session->userdata('man_id');
		$data['sup_emp']=UlsAssessmentPositionAssessor::get_skill_assessors_details($man_id);
		$content = $this->load->view('manager/employee_skill_other_assessment',$data,true);
		$this->render('layouts/manager_layout',$content);
	}
	
	public function employee_skill_evaluation_details(){
		 $this->sessionexist();
		$data=array();
		$man_id=$this->session->userdata('man_id');
		$data['emp_data']=UlsEmployeeMaster::emp_data_report($_REQUEST['emp_id']);
		$data['ass_data']=UlsAssessmentDefinition::viewassessment($_REQUEST['ass_id']);
		$data['man_values']=UlsAssessmentSkillEvaluationMaster::get_assessment_skill_manager($_REQUEST['ass_id'],$_REQUEST['pos_id'],$_REQUEST['atest_id']);
		$data['test_results']=UlsUtestAttemptsAssessment::getattemptvalus($_REQUEST['ass_id'],$_REQUEST['emp_id'],$_REQUEST['atest_id'],'TEST');
		$data['ass_test_results']=UlsAssessmentTest::test_details($_REQUEST['atest_id']);
		$content = $this->load->view('manager/employee_skill_evaluation_details',$data,true);
		$this->render('layouts/manager_layout',$content);
	}
	
	public function employee_skill_insert(){
		$this->sessionexist();
		if(isset($_POST['emp_id'])){
			$man_id=$this->session->userdata('man_id');
			$pass=0; $totscore=0; $wrongans=0;$correctans=0;
			$position_archive=UlsAssessmentSkillEvaluation::get_assessment_skill($_POST['ass_id'],$_POST['pos_id'],$_POST['emp_id'],$man_id,$_POST['atest_id']);
			if(empty($position_archive['position_id'])){
				$questions=new UlsAssessmentSkillEvaluation();
				$questions->employee_id=$_POST['emp_id'];
				$questions->assessment_id=$_POST['ass_id'];
				$questions->position_id=$_POST['pos_id'];
				$questions->manager_id=$man_id;
				$questions->assess_test_id=$_POST['atest_id'];
				$questions->skill_type=$_POST['stype'];
				$questions->status='A';
				$questions->save();
				foreach($_POST['question'] as $key=>$val){
					$anss='answer_'.$key;
					$st=Doctrine_Core::getTable('UlsQuestions')->findOneByQuestion_id($val);
					if(isset($_POST[$anss])){
						foreach($_POST[$anss] as $key_n=>$ans){
							$resp=Doctrine_Core::getTable('UlsQuestionValues')->findOneByValue_id($ans);
							$corec=($resp->correct_flag=='Y')?"1":'0';
							$respid=$ans;
							if($corec==1 || $corec==0){
								if($corec==1){  $pass=$pass+$st->points;  $correctans=$correctans+1; }
								else if($corec==0){  $wrongans=$wrongans+1; }
								$totscore=$totscore+$st->points;
							}
						}
					}
					$evaluation=new UlsAssessmentSkillEvaluationAttempts();
					$evaluation->eva_id=$questions->eva_id;
					$evaluation->ass_value_id=$_POST['ass_value_id'][$key];
					$evaluation->value_id=$respid;
					$evaluation->text=$corec;
					$evaluation->save();
				}
				//echo $correctans;
				$getpretest=UlsUtestAttemptsAssessment::getattemptvalus($questions->assessment_id,$questions->employee_id,$questions->assess_test_id,'TEST');
				$ass_test_results=UlsAssessmentTest::test_details($questions->assess_test_id);
				$skill_count=UlsAssessmentSkillEvaluationMaster::get_assessment_skill_manager_count($questions->assessment_id,$questions->position_id,$questions->assess_test_id);
				$total_que_count=$skill_count['skill_count'];
				$total_correct=$getpretest['score']+$correctans;
				$total_qu=$ass_test_results['no_questions']+$total_que_count;
				$total_per=$ass_test_results['pass_per'];
				$total_marks=round((($total_correct/$total_qu)*100),2);
				$result_data=($total_marks>=$total_per)?"PASS":"FAIL";
				$update=Doctrine_Query::create()->update('UlsUtestAttemptsAssessment');
				$update->set('manager_id','?',$man_id);
				$update->set('skill_marks','?',$correctans);
				$update->set('comp_date','?',date('Y-m-d'));
				$update->set('emp_result','?',$result_data);
				$update->set('eva_score','?',$total_marks);
				$update->where('attempt_id=?',$getpretest['attempt_id']);
				$update->execute();
				
				$update=Doctrine_Query::create()->update('UlsAssessmentSkillEvaluation');
				$update->set('result','?',$result_data);
				$update->where('eva_id=?',$questions->eva_id);
				$update->execute();
				
				if($result_data=='PASS'){
					$ass_det=UlsAssessmentDefinition::view_assessment_skill(2);
					$position=UlsAssessmentPosition::get_assessment_position_info($questions->position_id,$ass_det['assessment_id']);
					$empde=UlsEmployeeMaster::emp_data_report($questions->employee_id);
					$emp_check=UlsAssessmentEmployees::get_assessment_employees_check($questions->employee_id,$ass_det['assessment_id'],$empde['position_id']);
					if(empty($emp_check['assessment_pos_emp_id'])){
						$enroll=new UlsAssessmentEmployees();
						$enroll->assessment_id=$position['assessment_id'];
						$enroll->position_id=$position['position_id'];
						$enroll->employee_id=$questions->employee_id;
						$enroll->assessment_pos_id=$position['assessment_pos_id'];
						$enroll->bu_id=$empde['bu_id'];
						$enroll->org_id=$empde['org_id'];
						$enroll->grade_id=$empde['grade_id'];
						$enroll->location_id=$empde['location_id'];
						$enroll->save();
						$ass_journing=UlsAssessmentEmployeeJourney::get_assessment_employees($position['assessment_id'],$position['position_id'],$questions->employee_id);
						$enroll_journing=(!empty($ass_journing['id']))?Doctrine_Core::getTable('UlsAssessmentEmployeeJourney')->find($ass_journing['id']): new UlsAssessmentEmployeeJourney();
						$enroll_journing->assessment_type='Assessment';
						$enroll_journing->assessment_id=$enroll->assessment_id;
						$enroll_journing->position_id=$enroll->position_id;
						$enroll_journing->employee_id=$enroll->employee_id;
						$enroll_journing->save();
					}
				}
				if($result_data=='FAIL'){
					
					$st="ASSESSMENT_RESULT_FAIL";
					$notification=Doctrine_core::getTable('UlsNotification')->findOneByParent_org_idAndEvent_typeAndStatus($_SESSION['parent_org_id'],$st,'A');
					$empde=UlsEmployeeMaster::emp_data_report($_POST['emp_id']);
					if(!empty($notification)){
						$sup_name=UlsEmployeeMaster::get_employees_sup($empde['supervisor_id']);
						$ass_def=UlsAssessmentDefinition::viewassessment($questions->assessment_id);
						$ass_test="";
						if($ass_def['skill_type']==1){
							$ass_test="Level 2";
						}
						elseif($ass_def['skill_type']==2){
							$ass_test="Level 3";
						}
						else{
							$ass_test="Level 4";
						}
						$emailBody =$notification->comments;
						$emailBody = str_replace("#NAME#",ucwords($sup_name['full_name']),$emailBody);
						$emailBody = str_replace("#EMPNAME#",ucwords($empde['full_name']),$emailBody);
						$emailBody = str_replace("#DEPARTMENT#",$empde['org_name'],$emailBody);
						$emailBody = str_replace("#ASSTEST#",$ass_test,$emailBody);
						$mailsubject=$emailBody;
						$subject= "Assessment Results";
						$ss=new UlsNotificationHistory();
						$ss->employee_id=$empde['supervisor_id'];
						$ss->timestamp=date('Y-m-d H:i:s');
						$ss->to=!empty($sup_name['email'])? $sup_name['email'] : "";
						$ss->notification_id=$notification->notification_id;
						$ss->subject=$subject;
						$ss->mail_content=$mailsubject;
						$ss->save();
					}
				}
				if($_POST['type']==1){
					redirect("manager/employee_skill_assessment");
				}
				if($_POST['type']==2){
					redirect("manager/employee_skill_other_assessment");
				}
				
			}
		}
	}
	
	
	
	
	public function manager_position_details(){
		$data=array();
		$data['menu']="index";
		$id=isset($_REQUEST['val_id'])? $_REQUEST['val_id']:"";
		if($id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$man_id=$this->session->userdata('man_id');
			$data['validation']=UlsValidationPositionDefinition::viewpositionvalidation($id);
			$data['pos_assessments']=UlsEmployeeMaster::fetch_manager_pos_details($id,$man_id);
			$data["aboutpage"]=$this->pagedetails('employee','emp_assessment');
			$content = $this->load->view('manager/manager_position_details',$data,true);
		}
		$this->render('layouts/adminnew',$content);	
	}
	
	public function manager_validation_details(){		
		$data=array();
		$data['menu']="index";
		$data["aboutpage"]=$this->pagedetails('manager','manager_validation');
		$id=isset($_REQUEST['val_id'])? $_REQUEST['val_id']:"";
		$pos_id=isset($_REQUEST['pos_id'])? $_REQUEST['pos_id']:"";
		if($id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$man_id=$this->session->userdata('man_id');
			$data['emp_val_details']=UlsEmployeeMaster::fetch_manager_pos_emp_details($id,$man_id,$pos_id); 
			$data['man_validation_details']=UlsPositionTemp::manager_viewpositionvalidation($id,$pos_id);
			$data['pos_details']=UlsValidationPositions::view_validation_position($id,$pos_id);
			if(!empty($_REQUEST['val_pos_id'])){
				$data['emp_kra_validation_details']=UlsPositionTemp::get_self_validation_kra_summary($id,$pos_id,$_REQUEST['val_pos_id']);
			}
			$data['man_kra_details']=UlsPositionKraTempTray::get_manager_validation_kra($id,$pos_id);
			$org_stat="VAL_REQUIRE";
			$data["require"]=UlsAdminMaster::get_value_names($org_stat);
			$data['comp_details']=UlsPositionTemp::employee_view_position_cat($id,$pos_id);
			$content = $this->load->view('manager/manager_position_validation_process',$data,true);
		}
		$this->render('layouts/adminnew',$content);	
	}
	
	public function manager_position_validation_insert(){
        $this->sessionexist();
        if(isset($_POST['val_id'])){
            $fieldinsertupdates=array('accountabilities','responsibilities','val_id','position_id');
            $case=Doctrine::getTable('UlsPositionTemp')->find($_POST['pos_temp_id']);
            !isset($case->val_id)?$case=new UlsPositionTemp():"";
            foreach($fieldinsertupdates as $val){
				$case->$val=(!empty($_POST[$val]))?($_POST[$val]):NULL;
			}
			$case->manager_id=$this->session->userdata('man_id');
            $case->save();
			
			$this->session->set_flashdata('assessment',"Position JD Validation info ".(!empty($_POST['val_id'])?"updated":"inserted")." successfully.");
            redirect('manager/manager_validation_details?status=competency&val_id='.$_POST['val_id'].'&pos_id='.$_POST['position_id'].'&val_pos_id='.$_POST['val_pos_id']);
        }
        else{
			$content = $this->load->view('manager/assessor_assessment',$data,true);
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
					$master_value->manager_id=$this->session->userdata('man_id');
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
								$master_value->manager_id=$this->session->userdata('man_id');
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
			 redirect('manager/manager_validation_details?status=enrol&val_id='.$_POST['val_id'].'&pos_id='.$_POST['position_id'].'&val_pos_id='.$_POST['val_pos_id']);
		}
		else{
			$content = $this->load->view('manager/assessor_assessment',$data,true);
			$this->render('layouts/adminnew',$content);
        }
	}
	
	public function validation_position_kra_insert(){
		$this->sessionexist();
		if(isset($_POST['val_id'])){
			/* echo "<pre>";
			print_r($_POST); */
			foreach($_POST['required_process'] as $key=>$process){
				$master_value=!empty($_POST['pos_kra_temp_id'][$key])?Doctrine::getTable('UlsPositionKraTemp')->find($_POST['pos_kra_temp_id'][$key]): new UlsPositionKraTemp();
				$master_value->val_id=$_POST['val_id'];
				$master_value->position_id=$_POST['position_id'];
				$master_value->manager_id=$this->session->userdata('man_id');
				$master_value->required_process=$process;
				$master_value->comp_kra_id=$_POST['comp_kra_id'][$key];
				$master_value->reason=!empty($_POST['reason'][$key])?$_POST['reason'][$key]:NULL;
                $master_value->save();
			}
			
			if(!empty($_POST['kra_des'])){
				foreach($_POST['kra_des'] as $key_kra=>$kra){
					$master_value=!empty($_POST['pos_kra_tray_id'][$key_kra])?Doctrine::getTable('UlsPositionKraTempTray')->find($_POST['pos_kra_tray_id'][$key_kra]): new UlsPositionKraTempTray();
					$master_value->val_id=$_POST['val_id'];
					$master_value->position_id=$_POST['position_id'];
					$master_value->manager_id=$this->session->userdata('man_id');
					$master_value->kra_des=$kra;
					$master_value->kra_kri=$_POST['kra_kri'][$key_kra];
					$master_value->kra_uom=$_POST['kra_uom'][$key_kra];
					$master_value->reason=!empty($_POST['reason_kra'][$key_kra])?$_POST['reason_kra'][$key_kra]:NULL;
					$master_value->save();
				}
			}
			
			$this->session->set_flashdata('assessment',"Assessment position information has been ".(!empty($_POST['val_id'])?"updated":"inserted")." successfully.");
			redirect('manager/manager_validation_details?status=final&val_id='.$_POST['val_id'].'&pos_id='.$_POST['position_id'].'&val_pos_id='.$_POST['val_pos_id']);
		}
		else{
			$content = $this->load->view('manager/assessor_assessment',$data,true);
			$this->render('layouts/adminnew',$content);
        }
	}
	
	
}

