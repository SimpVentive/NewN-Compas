<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Assessor extends  MY_Controller {	
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
		$data["aboutpage"]=$this->pagedetails('assessor','assprofile');
		$compdetails=UlsAssessorMaster::viewassessor($this->session->userdata('asr_id'));
		$data['assessordetails']=$compdetails;
		$data['instruments']=UlsAssessorCertifiedInstruments::getassessorinstruments($this->session->userdata('asr_id'));
		$data['competencies']=UlsAssessorCompetencies::getassessorcompetencies($this->session->userdata('asr_id'));
		$content = $this->load->view('assessor/assessor_profile',$data,true);
		$this->render('layouts/assessornew',$content);	
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
				redirect("assessor/profile");
            }
            else{
                $data['message']="Some error occurred please try again";
            }
        }
		$content = $this->load->view('assessor/assessor_changepassword',$data,true);
		$this->render('layouts/assessornew',$content);
	}
	
	public function assessor_assessment(){
		$data=array();
		$data['menu']="index";
		$asr_id=$this->session->userdata('asr_id');
		$data['assessments']=UlsAssessmentPositionAssessor::getassessorassessments($asr_id);
		$data["aboutpage"]=$this->pagedetails('assessor','ass_assessment');
		$content = $this->load->view('assessor/assessor_assessment',$data,true);
		$this->render('layouts/assessornew',$content);	
	}
	
	public function assessor_feedback_details(){
		$this->sessionexist();	
		$data=array();
		$data['menu']="index";
		$data["aboutpage"]=$this->pagedetails('assessor','assessor_feedback_details');
		$content = $this->load->view('assessor/assessor_feedback_details',$data,true);
		$this->render('layouts/assessornew',$content);	
	}
	
	public function assessor_feedback_insert(){
		if(isset($_POST['assessment_id'])){
			$work_activation=(!empty($_POST['feed_id']))?Doctrine::getTable('UlsAssessmentFeedbackAssessor')->find($_POST['feed_id']):new UlsAssessmentFeedbackAssessor;
			$work_activation->assessment_id=$_POST['assessment_id'];
			$work_activation->Q1=!empty($_POST['Q1'])?$_POST['Q1']:NULL;
			$work_activation->Q2=!empty($_POST['Q2'])?$_POST['Q2']:NULL;
			$work_activation->Q3=!empty($_POST['Q3'])?$_POST['Q3']:NULL;
			$work_activation->Q41=!empty($_POST['Q41'])?$_POST['Q41']:NULL;
			if($_POST['Q41']==2){
				$work_activation->Q42=!empty($_POST['Q42'])?$_POST['Q42']:NULL;
			}
			$work_activation->Q5=!empty($_POST['Q5'])?$_POST['Q5']:NULL;
			$work_activation->assessor_id=$this->session->userdata('asr_id');
			$work_activation->status='A';
			$work_activation->save();
			$this->session->set_userdata('feed_session',1);
			redirect("assessor/assessor_assessment");
		}
	}
	
	public function assessor_assessment_details(){		
		$data=array();
		$data['menu']="index";
		$data["aboutpage"]=$this->pagedetails('assessor','assessor_assessment_details');
		$asr_id=$this->session->userdata('asr_id');
		$assessment_id=$_REQUEST['assessment_id'];
		$data['assessor_id']=$asr_id;
		$data['assessment_id']=$assessment_id;
		$data['ass_name']=UlsAssessmentDefinition::viewassessment($assessment_id);
		$data['positions']=UlsAssessmentPositionAssessor::getassessorassessmentpositions($assessment_id,$asr_id);
		$content = $this->load->view('assessor/assessor_assessment_details',$data,true);
		$this->render('layouts/assessornew',$content);	
	}
	
	public function getemployeedetails(){
		$data=array();
		$employee_id=$_REQUEST['employee_id'];
		$assessment_id=$_REQUEST['assessment_id'];
		$data['assessment_id']=$assessment_id;
		$data['employee_id']=$employee_id;
		$data['userdetails']=UlsEmployeeMaster::getempdetails($employee_id);
		$content = $this->load->view('assessor/employeedetails',$data,true);
		$this->render('layouts/ajax-layout',$content);	
	}
	
	public function getemployeeassessment(){
		$data=array();
		$position_id=$_REQUEST['position_id'];
		$assessment_id=$_REQUEST['assessment_id'];
		$employee_id=$_REQUEST['employee_id'];
		$emp_name=$_REQUEST['emp_name'];
		$data['assessment_id']=$assessment_id;
		$data['position_id']=$position_id;
		$data['employee_id']=$employee_id;
		$data['emp_name']=$emp_name;
		$data['rating_ass']=UlsAssessmentAssessorRating::get_ass_rating_assessor($assessment_id,$position_id,$employee_id);
		$data['rating_ass_final']=UlsAssessmentReportFinal::assessment_assessor_final($assessment_id,$position_id,$employee_id,$_SESSION['asr_id']);
		$data['comp_inbasket']=UlsAssessmentReportBytype::summary_details_count_status($assessment_id,'INBASKET',$position_id,$employee_id,$_SESSION['asr_id']);
		
		$data['ass_test']=UlsAssessmentTest::assessment_testemp($assessment_id,$position_id);
		$data['ass_rating']=UlsAssessmentAssessorRating::get_ass_rating_assessor_summary($assessment_id,$position_id,$employee_id);
		$content = $this->load->view('assessor/assessmenttest',$data,true);
		$this->render('layouts/ajax-layout',$content);	
	}
	
	public function assessmenttest_details(){
		$data=array();
		$ass_id=$_REQUEST['ass_id'];
		$emp_id=$_REQUEST['emp_id'];
		$pos_id=$_REQUEST['pos_id'];
		$data['id']=$ass_id;
		$data['emp_id']=$emp_id;
		$data['pos_id']=$pos_id;
		$ass_details=UlsAssessmentTest::test_details($ass_id);
		$data['ass_details']=$ass_details;
		$data['getpretest']=UlsUtestAttemptsAssessment::getattemptvalus($ass_details['assessment_id'],$emp_id,$ass_id,$ass_details['assessment_type']);
		$data['getpretest_interview']=UlsUtestAttemptsAssessment::getattemptvalus_interview($ass_details['assessment_id'],$emp_id,$ass_id,$ass_details['assessment_type']);
		$content = $this->load->view('assessor/assessmenttestdetails',$data,true);
		$this->render('layouts/ajax-layout',$content);
	}
	
	public function feedbackreport(){
		$data=array();
		$ass_id=$_REQUEST['ass_id'];
		$emp_id=$_REQUEST['emp_id'];
		$data['id']=$ass_id;
		$data['emp_id']=$emp_id;
		$data['grouping_user']=UlsAssessmentFeedEmployees::get_feed_assessment_details_assess_emp($ass_id,$emp_id);
		$content = $this->load->view('assessor/assessmentfeedbackdetails',$data,true);
		$this->render('layouts/ajax-layout',$content);
	}
	
	public function getassessmentjd(){
		$data=array();
		$position_id=$_REQUEST['position_id'];
		$assessor_id=$_REQUEST['assessor_id'];
		$assessment_id=$_REQUEST['assessment_id'];
		$data['assessor_id']=$assessor_id;
		$data['assessment_id']=$assessment_id;
		$data['position_id']=$position_id;
		$posdetails=UlsPosition::viewposition($position_id);
		$data['posdetails']=$posdetails;
		$content = $this->load->view('assessor/assessmentjd',$data,true);
		$this->render('layouts/ajax-layout',$content);
	}
	
	public function getassessmentprofiling(){
		$data=array();
		$position_id=$_REQUEST['position_id'];
		$assessor_id=$_REQUEST['assessor_id'];
		$assessment_id=$_REQUEST['assessment_id'];
		$data['assessor_id']=$assessor_id;
		$data['assessment_id']=$assessment_id;
		$data['position_id']=$position_id;
		$posdetails=UlsPosition::viewposition($position_id);
		$data['posdetails']=$posdetails;
		$data['competencies']=UlsCompetencyPositionRequirements::getcompetencypositionrequirements($position_id);
		$data['kras']=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($position_id);
		$content = $this->load->view('assessor/assessmentprofiling',$data,true);
		$this->render('layouts/ajax-layout',$content);	
	}
	
	public function getassessoremployees(){
		$data=array();
		$data["aboutpage"]=$this->pagedetails('assessor','assessor_assessment_details');
		$position_id=$_REQUEST['position_id'];
		$assessor_id=$_REQUEST['assessor_id'];
		$assessment_id=$_REQUEST['assessment_id'];
		$data['assessor_id']=$assessor_id;
		$data['assessment_id']=$assessment_id;
		$data['position_id']=$position_id;
		$data['position']=Doctrine::getTable('UlsPosition')->find($position_id);
		$assessor=UlsAssessmentPositionAssessor::get_assessor_rights($assessment_id,$assessor_id,$position_id);
		$data['assessor']=$assessor;
		if($assessor['assessor_per']=='Y'){
			$data['employees']=UlsAssessmentPositionAssessor::getemployees_mapped($assessor['emp_ids']);
		}
		else{
			$data['employees']=UlsAssessmentPositionAssessor::getemployees($assessment_id,$assessor_id,$position_id);
		}
		$content = $this->load->view('assessor/assessmentemployee',$data,true);
		$this->render('layouts/assessornew',$content);	
	}
	
	public function employee_development(){		
		$data=array();
		$data['menu']="index";
		$data['testimonials']=array();//Testimonials::doTestimoniallimit();
		$data['package']=array();//Packages::dopackages();
		$content = $this->load->view('assessor/assessor_development',$data,true);
		$this->render('layouts/assessornew',$content);	
	}
	
	public function getemp_test_casestudy_view(){	   
		$testype="'".$_REQUEST['type']."'";
		$ttype=$_REQUEST['type'];
        $ass_test_id=$_REQUEST['id'];
		$ass_id=$_REQUEST['ass_id'];
		$emp_id=$_REQUEST['emp_id'];
		$tid=$_REQUEST['test_id'];
		$ins_id=$_REQUEST['ins_id'];
		$pos_id=$_REQUEST['pos_id'];
		$case_id=$_REQUEST['case_id'];
		$testdetails=UlsUtestResponsesAssessment::gettesttakenquestions_casestudy($tid,$testype,$ass_id,$ass_test_id,$emp_id);
		$comp_questions=UlsCaseStudyMaster::get_casestudy_competency_unique_assessor($ins_id,$testype,$emp_id,$ass_id,$pos_id);
		$testdetail_insert=UlsUtestAttemptsAssessment::getattemptvalus_inbasket($ass_id,$emp_id,$ass_test_id,$ttype,$tid);
		$ass_rating=UlsAssessmentAssessorRating::get_ass_rating($testdetail_insert['attempt_id'],$emp_id,$ttype);
		$ass_rating_id=!empty($ass_rating['ass_rating_id'])?$ass_rating['ass_rating_id']:"";
        echo "
		<div class='modal-header' style='padding: 10px 10px;'>
			<button aria-hidden='true' data-dismiss='modal' class='close' type='button' style='margin:5px 10px;'>X</button>
			<h4 class='modal-title' style='margin:5px 10px;'>".$ttype."</h4>
		</div>
		<div class='modal-body'>
		<p class='text-muted'><code>Once you submit a rating, it cannot be changed later</code></p>
		<form class='form-horizontal' name='employeeTest' id='employeeTest'>";
				$pa_id="";$ss=''; $rr='';$respvals=array();
				
				echo "
					<div>
						<hr class='light-grey-hr row mt-10 mb-10'>
						<span class='pull-left inline-block capitalize-font txt-dark'>
							Casestudy Questions.
						</span>
						
						<span class='pull-right'><a class='btn btn-info btn-xs' data-toggle='modal' data-target='#myModalin_".$case_id."_".$pos_id."_".$emp_id."' id='openinbasketview_".$case_id."_".$pos_id."_".$emp_id."'> View</a></span>
						<div class='clearfix'></div>
						<hr class='light-grey-hr row mt-10 mb-10'>
						
					</div>
					<div id='myModalin_".$case_id."_".$pos_id."_".$emp_id."'  class='modal fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'  aria-hidden='false' style='overflow-y:auto;' >
						<div class='modal-dialog modal-lg' style='width:900px'>
							<div class='modal-content'>
								<div class='color-line'></div>
								<div class='modal-header'>
									<button aria-hidden='true' class='close' id='close_".$case_id."_".$pos_id."_".$emp_id."' type='button'>×</button>
									<h4 class='modal-title'>Casestudy</h4>
								</div>
								<div class='modal-body'>";
									$compdetails=UlsCaseStudyMaster::viewcasestudy($case_id);
									echo "<h3>Casestudy Name: ".@$compdetails['casestudy_name']."</h3>
									<p>Author: ".@$compdetails['casestudy_author']."</p>
									<p>Source: ".@$compdetails['casestudy_source']."</p>";
									if(!empty($compdetails['casestudy_link'])){ 
									$data.="<p>Link: <a href='".BASE_URL."/public/uploads/inbasket/".$compdetails['casestudy_id']."/".$compdetails['casestudy_link']."' target='_blank' >Click Here</a></p>";
									}
									echo "<p>Status: ".@$compdetails['casestatus']."</p>
									<p>".@$compdetails['casestudy_description']."</p>
								</div>
								
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div>";
				echo "<div style='padding-top: 3px; border:1px solid #DDDDDD; height: 300px;overflow: auto;' align='left'>";
				$scort="";
					if(count($testdetails)>0){
						foreach($testdetails as $keys=>$testdetail){
							$key=$keys+1; 
						echo "<p style='text-align:left'><b>&nbsp;".$key." . ".strip_tags($testdetail['casestudy_quest'])."</b></p>
							<input type='hidden' id='question_". $key."' name='question[". $key."]'  value='".$testdetail['casestudy_quest_id']."' >";
							$case_comp=UlsCaseStudyMaster::viewcasestudy_ass_question_comp($ass_id,$testdetail['casestudy_quest_id'],$pos_id);
							foreach($case_comp as $case_comps){
								echo "<div><code>".$case_comps['comp_def_name']."-".$case_comps['scale_name']."</code></div><br>";
							}
							$ran=($testdetail['sequence']=='R')?' ORDER BY RAND()' : '';
							
							echo "<div class='col-md-12'>";
								$valuename=Doctrine_Query::Create()->from("UlsUtestResponsesAssessment")->where("employee_id=".$emp_id." and test_type=".$testype." and event_id=".$ass_test_id." and assessment_id=".$ass_id." and user_test_question_id=".$testdetail['casestudy_quest_id'])->fetchOne();
								$ched=isset($valuename->text)?htmlentities(stripslashes($valuename->text)):"";
								//$valuename=Doctrine_Query::Create()->from("UlsUtestResponsesAssessment")->where("employee_id=".$emp_id." and test_type=".$testype." and event_id=".$ass_test_id." and assessment_id=".$ass_id)->fetchOne();
								$valuename=UlsMenu::callpdorow("SELECT * FROM `uls_utest_responses_assessment` where utest_question_id in (SELECT `id` FROM `uls_utest_questions_assessment` where `employee_id`=".$emp_id." and `assessment_id`=".$ass_id." and `test_id`=".$tid." and `test_type`=".$testype." and event_id=".$ass_test_id." and user_test_question_id=".$testdetail['casestudy_quest_id'].")");
								$chedn=isset($valuename['text'])?htmlentities(stripslashes($valuename['text'])):"";
								$ched=!empty($valuename['text_lang'])?$valuename['text_lang']:$chedn;
								
								

								echo"<textarea style='width:1300px;height:200px;resize:none;font-size: 14px;color: green;'  name='answer_".$key."[]' class='mediumtexta' id='answer_".$key."' readonly> ". $ched."</textarea>";
								if(!empty($testdetail_insert['inbasket_upload'])){
								echo "<p>Upload: <a href='".BASE_URL."/public/uploads/employee_casestudy/".$testdetail_insert['inbasket_upload']."' target='_blank' >Click Here</a></p>";
								}
							echo "</div>";
						}          
					} else { echo "<p>No Data Available.</p>"; }  echo"</div>";
		echo "</form>
		<br style='clear:both;'>
		<div class='hr-line-dashed'></div>
			<form action='' method='post' class='form-horizontal' id='casestudy_form_".$ins_id."' name='casestudy_form_".$ins_id."'>
				<input type='hidden' name='ass_rating_id'  id='ass_rating_id' value='".$ass_rating_id."'>
				<input type='hidden' name='attempt_id'  id='attempt_id' value='".$testdetail_insert['attempt_id']."'>
				<input type='hidden' name='employee_id'  id='employee_id' value='".$emp_id."'>
				<input type='hidden' name='assessment_type'  id='assessment_type' value='".$ttype."'>
				<input type='hidden' name='assessor_id' value='".$_SESSION['asr_id']."' >
				<input type='hidden' name='parent_org_id' value='".$_SESSION['parent_org_id']."' >
				<input type='hidden' name='assessment_id' value='".$ass_id."' >
				<input type='hidden' name='position_id' value='".$pos_id."' >";
				$ass_details=UlsAssessmentDefinition::viewassessment($ass_id);
				
				echo "<div class='table-responsive'>
					<table cellpadding='1' cellspacing='1' class='table table-bordered table-striped'>
						<thead>
						<tr>
							<th>Competency Name</th>
							<th>Required Level</th>
							<th>Assessed Level<sup><font color='#FF0000'>*</font></sup></th>
						</tr>
						</thead>
						<tbody>";
						if(count($comp_questions)>0){
							foreach($comp_questions as $keys=>$comp_question){
								$scale=UlsLevelMasterScale::levelscale($comp_question['level_id']);
								echo "<tr>
									<td>
									<input type='hidden' name='case_assess_test_id' value='".$comp_question['case_assess_test_id']."'>
									<input type='hidden' name='position_id' value='".$comp_question['position_id']."'>
									<input type='hidden' name='report_id[]' value='".$comp_question['report_id']."'>
									<input type='hidden' name='competency[]' id='competency[]' value='".$comp_question['comp_def_id']."'>
									".$comp_question['comp_def_name']."</td>
									<td>
									<input type='hidden' name='requiredlevel_".$comp_question['comp_def_id']."' value='".$comp_question['scale_id']."' >
									".$comp_question['scale_name']."</td>
									<td>
										<select name='".$ttype."_".$comp_question['comp_def_id']."' id='".$ttype."_".$comp_question['comp_def_id']."' class='form-control m-b validate[required]' style='width:400px;'>
											<option value=''>Select</option>";
											foreach($scale as $scales){			
												$scale_s=!empty($comp_question['assessed_scale_id'])?$comp_question['assessed_scale_id']==$scales['scale_id']?"selected='selected'":"":"";
												echo "<option value='".$scales['scale_id']."' ".$scale_s.">".$scales['scale_name']."</option>";
											}
											echo "</select>
									</td>
								</tr>";
							}
						}
						echo "</tbody>
					</table>
				</div>
				<div class='hr-line-dashed'></div>
				<p class='text-muted'><code>Overall Rating</code></p>
				<p class='text-muted col-md-12'><code>Consider the following and rate the participant on the following Casestudy/Case Analysis
				<br>
				1. Has identified the core issue/ problem of the case<br>
				2. Has analyzed the core issues/ problem, in the most appropriate manner<br>
				3. Proposed action (if any) is consistant with the competency required<br>
				4. Presents the solution / analysis in a coherent and logical way
				</code></p>
				<br style='clear:both;'>";
				$rating=UlsRatingMasterScale::ratingscale($ass_details['rating_id']);
				
				echo "<div class='form-group'>
				<label class='col-sm-1 control-label'>Rating<sup><font color='#FF0000'>*</font></sup>:</label>";
					
					echo "<div class='col-sm-3'>
						<select class='validate[required] form-control' name='scale_id' id='scale_id'>
							<option value=''>Select</option>";
							foreach($rating as $ratings){
								$rat_sel=!empty($ass_rating['scale_id'])?($ass_rating['scale_id']==$ratings['scale_id']?'selected="selected"':''):'';
								echo "<option value='".$ratings['scale_id']."' ".$rat_sel.">".$ratings['rating_name_scale']."</option>";
							}
						echo "</select>
					</div>
				</div>
				
				<div class='form-group'>
					<label class='col-sm-1 control-label'>Comments<sup><font color='#FF0000'>*</font></sup>:</label>";
					$comments=!empty($ass_rating['comments'])?$ass_rating['comments']:'';
					echo "<div class='col-sm-9'><textarea class='validate[required] form-control' type='text' name='comments' id='comments'>".$comments."</textarea></div>
				</div>
				<div class='hr-line-dashed'></div>";
				//$ass_rating_dis=!empty($ass_rating['ass_rating_id'])?'disabled':""".$ass_rating_dis.";
				echo "<div class='form-group'>
					<div class='col-sm-12 col-sm-offset-9'>
						<button class='btn btn-default' data-dismiss='modal' type='button'>Cancel</button>
						<button class='btn btn-primary' type='button' name='submit' id='casestudy_submit_".$ins_id."' >Save</button>
					</div>
				</div>
			</form>
		</div>
		";	
	}
	
	public function beireport(){
		$id=$_REQUEST['id'];
		$ins_id=$_REQUEST['ins_id'];
		$ass_id=$_REQUEST['ass_id'];
		$emp_id=$_REQUEST['emp_id'];
		
		$query="SELECT count(`text`) as val,`text` as name,response_value_id FROM `uls_bei_responses_assessment` WHERE `employee_id`=$emp_id and `assessment_id`=$ass_id and `event_id`=$id and `instrument_id`=$ins_id group by `text`";
		$results=UlsMenu::callpdo($query);
		
		
		$query2="SELECT `ins_rat_scale_value_number` as id,`ins_rat_scale_value_name` as name FROM `uls_be_ins_rat_scale_values` WHERE `ins_rat_scale_id` in (SELECT `instrument_scale` FROM `uls_be_instruments` WHERE `instrument_id`=$ins_id)";
		$results2=UlsMenu::callpdo($query2);
		
		$data['results']=$results;
		$data['ratings']=$results2;
		$data['ins_id']=$ins_id;
		$content = $this->load->view('assessor/beireport',$data,true);
		$this->render('layouts/ajax-layout',$content);
		
	}
	
	public function getemp_test_view(){	   
		$testype="'".$_REQUEST['type']."'";
		$ttype=$_REQUEST['type'];
        $ass_test_id=$_REQUEST['id'];
		$ass_id=$_REQUEST['ass_id'];
		$emp_id=$_REQUEST['emp_id'];
		$tid=$_REQUEST['test_id'];
		$ins_id=$_REQUEST['ins_id'];
		$pos_id=$_REQUEST['pos_id'];
		$employee_info=UlsEmployeeMaster::get_employees($emp_id);
		$type_p=($ttype=="INBASKET")?'In-basket':'Test';
		if($ttype=="INBASKET"){
			$testdetails=UlsUtestResponsesAssessment::gettesttakenquestions_inbasket($tid,$testype,$ass_id,$ass_test_id,$emp_id);
			$ins_details=UlsAssessmentTestInbasket::get_inbasket_details($ass_test_id,$ass_id,$tid);
			$comp_questions=UlsQuestionValues::get_allquestion_values_competency_unique_assessor($ins_id,$testype,$emp_id,$ass_id);	
			
		}
		else{
			$testdetails=UlsUtestResponsesAssessment::gettesttakenquestions($tid,$testype,$ass_id,$ass_test_id,$emp_id);
			$comp_questions=UlsAssessmentTestQuestions::gettestquestions($ass_test_id,$tid,$ttype,$emp_id,$ass_id);
		}
		
		$testdetail_insert=UlsUtestAttemptsAssessment::getattemptvalus_inbasket($ass_id,$emp_id,$ass_test_id,$ttype,$tid);
		$ass_rating=UlsAssessmentAssessorRating::get_ass_rating($testdetail_insert['attempt_id'],$emp_id,$ttype);
		$ass_rating_id=!empty($ass_rating['ass_rating_id'])?$ass_rating['ass_rating_id']:"";
		/* for ".$employee_info['employee_number']."-".$employee_info['full_name']."*/
        echo "
		<div class='modal-header' style='padding: 10px 10px;'>
			<button aria-hidden='true' data-dismiss='modal' class='close' type='button' style='margin:5px 10px;'>X</button>
			<h4 class='modal-title' style='margin:5px 10px;'>".$type_p."</h4>
		</div>
		<div class='modal-body'>
			<p class='text-muted'><code>Once you save a rating, it cannot be changed later</code></p>";
			if($ttype=='INBASKET'){
				$start_date =date('Y-m-d H:i:s',strtotime($testdetail_insert['start_period']));
				$start = strtotime($start_date);
				$end_date =date('Y-m-d H:i:s',strtotime($testdetail_insert['end_period']));
				$end = strtotime($end_date);
				/* $diff = (strtotime($stoptime) - strtotime($starttime));
				$total = $diff/60;
				echo('%02dh %02dm'.' '.floor($total/60).' '.($total%60)); */
				
				//$totaltime = abs($end - $start)  ; 
				$totaltime = abs($start - $end)  ;
				$hours = intval($totaltime / 3600);   
				$seconds_remain = ($totaltime - ($hours * 3600)); 

				$minutes = intval($seconds_remain / 60);   
				$seconds = ($seconds_remain - ($minutes * 60));
				
				echo "<table class='table table-bordered table-striped' cellspacing='1' cellpadding='1'>
					<thead>
						<tr>
							<th style=' background-color: #edf3f4;width:30%'>Total Allocated Time</th>
							<th>&nbsp;".$ins_details['inbasket_time_period']." Mins</th>
						</tr>
						<tr>
							<th style=' background-color: #edf3f4;width:30%'>Total Time Taken</th>
							<th>&nbsp;";
							$hour=($hours>0 && $hours<5)?$hours." Hrs :":"";
							echo $minutes." Mins</th>
						</tr>
				
					</thead>
				</table>";
			}
			echo "<div class='hr-line-dashed'></div>";
				$pa_id="";$ss=''; $rr='';$respvals=array();
				if($ttype=='INBASKET'){
				$question_cc= Doctrine_Query::create()->from('UlsUtestQuestionsAssessment')->where("employee_id=".$emp_id." and assessment_id=".$ass_id." and parent_org_id=".$_SESSION['parent_org_id']." and test_id=".$tid." and event_id=".$ass_test_id." and test_type=".$testype)->execute();
				
				foreach($question_cc as $qq){
					$ccc= Doctrine_Query::create()->from('UlsUtestResponsesAssessment')->where("employee_id=".$emp_id." and assessment_id=".$ass_id." and parent_org_id=".$_SESSION['parent_org_id']." and event_id=".$ass_test_id." and test_type=".$testype." and utest_question_id=".$qq['id'])->execute();
					foreach( $ccc as $cccs){
						$pa_id=$cccs->utest_question_id;
						$respvals[$cccs->utest_question_id]=$cccs->response_value_id;
					} 
				}
				}
				else{
					$ccc= Doctrine_Query::create()->from('UlsUtestResponsesAssessment')->where("employee_id=".$emp_id." and assessment_id=".$ass_id." and parent_org_id=".$_SESSION['parent_org_id']." and event_id=".$ass_test_id." and test_type=".$testype)->execute();
					foreach( $ccc as $cccs){
						$respvals[$cccs->utest_question_id]=$cccs->response_value_id;
					}
				}
				//print_r($respvals);
				echo "<input type='hidden' name='testrespids' id='testrespids' value=".$ss." />";
				echo "
					<p class='text-muted'><code style='font-size: 12px;'>Note: <br>The Unsorted In-trays is given on the left, Sorting Order is the priority assigned by the assessee(or employee).<br>
					You can see the In-tray prioritization and the actions proposed by the employees below. Priority assigned by the employee is indicated by the 'My Priority'. The Unsorted In-trays is visible on the left. <br>
					You can refer to the recommendation by internal experts below the table
					</code>
					</p>
					<hr class='light-grey-hr'>";
					$scort="";
					if(count($testdetails)>0){
						foreach($testdetails as $keys=>$testdetail){
							$key=$keys+1; 
							$type=$testdetail['question_type']; 
							$scort=($type=='P')?'sortable':'';
							$listt=($type=='P')?'':'list-group';
							echo "<div class='clearfix mt-20'></div>
							
							<h6 class='panel-title txt-dark'>Narration:</h6>
							<p style='text-align:left;font-size: 12px;'><b>&nbsp;".$testdetail['inbasket_narration']."</b></p>";
							echo "<input type='hidden' id='question_". $key."' name='question[". $key."]'  value='".$testdetail['question_id']."' >";
							$intray_name=(isset($testdetail['inbasket_tray_name']))?$testdetail['inbasket_tray_name']:'In-tray';
							$ran=($testdetail['sequence']=='R')?' ORDER BY RAND()' : '';
							//$ss=Doctrine_Query::create()->select('text,correct_flag,scorting_order')->from("UlsQuestionValues")->where("question_id=".$testdetail['question_id'])->execute();
							$ss=UlsQuestionValues::get_all_question_values($testdetail['question_id']);
							echo "
							<div>
								<hr class='light-grey-hr row mt-10 mb-10'>
								<span class='pull-left'>
									<h6>Please check the expert priority</h6>
								</span>
								
								<span class='pull-right'><a class='btn btn-info btn-xs' data-toggle='modal' data-target='#myModal_in_".$ass_test_id."' id='open_inbasket_view_".$ass_test_id."'> View</a></span>
								<div class='clearfix'></div>
								<hr class='light-grey-hr row mt-10 mb-10'>
								
							</div>
							<div class='row'>
							<form action='' method='post' class='form-horizontal' id='casestudy_form_".$ins_id."' name='casestudy_form_".$ins_id."'>
							<input type='hidden' name='ass_rating_id'  id='ass_rating_id' value='".$ass_rating_id."'>
							<input type='hidden' name='attempt_id'  id='attempt_id' value='".$testdetail_insert['attempt_id']."'>
							<input type='hidden' name='employee_id'  id='employee_id' value='".$emp_id."'>
							<input type='hidden' name='assessment_type'  id='assessment_type' value='".$ttype."'>
							<input type='hidden' name='assessor_id' value='".$_SESSION['asr_id']."' >
							<input type='hidden' name='parent_org_id' value='".$_SESSION['parent_org_id']."' >
							<input type='hidden' name='assessment_id' value='".$ass_id."' >
							<input type='hidden' name='position_id' value='".$pos_id."' >
										
								<div class='col-sm-6'>
									<span class='pull-left'>
										<h6>In-tray Prioritization</h6>
									</span>
									
									<table cellpadding='1' cellspacing='1' id='edit_datable_2' class='table table-hover table-bordered mb-0'>
										<thead>
											<tr>
												<th></th>
												<th>Competency</th>
												<th>Level</th>
												<th>Unsorted In-trays</th>
												<th>Employee's priority</th>
												<th>SME priority</th>
											</tr>
										</thead>
										<tbody>";
										$j=0;
										foreach($ss as $key1=>$sss){
											
											$question_val=UlsQuestionValues::get_allquestion_values_inbasket($sss['value_id']);
											if(!empty($sss['inbasket_mode'])){
											$parsed_json2 = json_decode($sss['inbasket_mode'], true);
											}
											$class=($j==0)?"in":""; 
											$j++;
											$test=$respvals[$pa_id];
											$valuename=Doctrine_Query::Create()->from("UlsUtestResponsesAssessment")->where("response_value_id in (".$test.") and employee_id=".$emp_id." and test_type=".$testype." and event_id=".$ass_test_id." and  assessment_id=".$ass_id)->fetchOne();
											$lang_text=!empty($valuename->text_lang)?$valuename->text_lang:$valuename->text;
											$ched=json_decode($lang_text);
											$sme_details=UlsAssessmentReportSmeType::summary_sme_details($question_val['comp_def_id'],$ass_id,$sss['value_id'],$emp_id);
											$p_comment="";
											$p_action="";
											$s_order="";
											$p_ids="";
											
											foreach($ched as $key=>$cheds){
												if($cheds->id==@$sss['value_id']){
													
													$p_ids=$cheds->id;
													$p_action=$cheds->action;
													$p_comment=$cheds->text;
													$s_order=$key+1;
													$intray_order=@$sss['scorting_order'];
												}
											}
											echo "
											<tr id='innertable".$intray_order."'>
												<td>
												<a role='button' data-toggle='collapse' data-parent='#accordion_".$intray_order."' href='#collapse_".$intray_order."' aria-expanded='true'><i class='fa fa-plus'></i></a> 
												</td>
												
												<td>".$sss['value_id']."-".$question_val['comp_def_name']."</td>
												<td>".$question_val['scale_name']."</td>
												<td>".$intray_name." ".$intray_order."</td>
												<td>".$s_order."</td>
												<td>";
												$sme_priority=isset($sme_details['sme_priority'])?trim($sme_details['sme_priority']):$question_val['priority_inbasket'];
												//echo $question_val['priority_inbasket'];
												//$sme_priority=empty($sme_priority)?$question_val['priority_inbasket']:"";
												$report_sme_id=isset($sme_details['report_sme_id'])?$sme_details['report_sme_id']:'';
												echo "
												<input type='hidden' name='comp_def_id[]'  id='comp_def_id' value='".$question_val['comp_def_id']."'>
												<input type='hidden' name='required_level_".$key1."_".$question_val['comp_def_id']."' value='".$question_val['scale_id']."' >
												
												<input type='hidden' name='value_id_".$key1."_".$question_val['comp_def_id']."'  id='value_id' value='".$sss['value_id']."'><input type='text' class='validate[custom[onlyNumberSp],min[1],max[".count($ss)."]] form-control' name='sme_priority_".$key1."_".$question_val['comp_def_id']."'  id='sme_priority' value='".$sme_priority."'></td>
											</tr>
											<tr id='innertable".$intray_order."'>
												<td colspan='6'>
													<div id='collapse_".$intray_order."' class='panel-collapse collapse ".$class."' role='tabpanel'>
														<div class='panel-body pa-15'>";
														if(!empty($parsed_json2)){
															foreach($parsed_json2 as $key => $value)
															{
																$yes_stat="IN_MODE";
																$val_code=UlsAdminMaster::get_value_name_statuss($yes_stat,$value['mode']);
															echo "
															   <p><code>Mode:</code>".$val_code['name']."</p>
															   <p><code>Time:</code>".$value['period']."</p>
															   <p><code>From:</code>".$value['from']."</p>";
															}
														}
														echo "<label>".$sss['text']."</label>";
														echo "<br><p><code>Action</code> : <span style='font-size: 14px;color: green;'>".$p_action."</span></p>
														<p><code>Reason</code> : <span style='font-size: 14px;color: green;'>".$p_comment."</span></p>
														
														</div>
													</div>
												</td>
											</tr>";
										}
										echo "</tbody>
									</table>
								</div>
								<div class='col-sm-6'>
								<span class='pull-left'>
									<h6>Competency Evaluation</h6>
								</span>
								
								";
										$ass_details=UlsAssessmentDefinition::viewassessment($ass_id);
										
										echo "<div class='col-md-12'><div class='table-responsive'>
											<table cellpadding='1' cellspacing='1' class='table table-bordered table-striped'>
												<thead>
												<tr>
													<th class='col-md-3'>Competency Name</th>
													<th class='col-md-2'>Required Level</th>
													<th class='col-md-2'>Criticality</th>
													<th class='col-md-4'>Assessed Level</th>
												</tr>
												</thead>
												<tbody>";
												if(count($comp_questions)>0){
													foreach($comp_questions as $keys=>$comp_question){
														if($ttype=='INBASKET'){
															$scale=UlsLevelMasterScale::levelscale($comp_question['comp_def_level']);
														}
														else{
															$scale=UlsLevelMasterScale::levelscale($comp_question['assessment_pos_level_id']);
														}
														$criticality=UlsCompetencyPositionRequirements::get_competency_position($comp_question['position_id'],$comp_question['comp_def_id']);
														echo "<tr>
															<td  class='col-md-3'>";
															if($ttype=='INBASKET'){
																echo "<input type='hidden' name='inb_assess_test_id'  id='inb_assess_test_id' value='".$comp_question['inb_assess_test_id']."'>";
															}
															echo "<input type='hidden' name='position_id' value='".$comp_question['position_id']."'>
															<input type='hidden' name='report_id[]' value='".$comp_question['report_id']."'>
															<input type='hidden' name='competency[]' id='competency[]' value='".$comp_question['comp_def_id']."'>
															".$comp_question['comp_def_name']."</td>
															<td  class='col-md-2'>
															<input type='hidden' name='requiredlevel_".$comp_question['comp_def_id']."' value='".$comp_question['scale_id']."' >
															".$comp_question['scale_name']."</td>
															<td  class='col-md-2'>".$criticality['comp_cri_name']."</td>
															<td  class='col-md-4'>
																<select name='".$ttype."_".$comp_question['comp_def_id']."' id='".$ttype."_".$comp_question['comp_def_id']."' class='form-control m-b validate[required]' >
																	<option value=''>Select</option>";
																	foreach($scale as $scales){			
																		$scale_s=!empty($comp_question['assessed_scale_id'])?$comp_question['assessed_scale_id']==$scales['scale_id']?"selected='selected'":"":"";
																		echo "<option value='".$scales['scale_id']."' ".$scale_s.">".$scales['scale_name']."</option>";
																	}
																	echo "</select>
															</td>
														</tr>";
														
													}
												}
												
												echo "</tbody>
											</table>
										</div>
										<table class='table table-bordered table-striped' cellspacing='1' cellpadding='1'>
											<thead>
												<tr>
													<th style=' background-color: #edf3f4;width:30%'>Total Allocated Time</th>
													<th>&nbsp;".$ins_details['inbasket_time_period']." Mins</th>
												</tr>
												<tr>
													<th style=' background-color: #edf3f4;width:30%'>Total Time Taken</th>
													<th>&nbsp;";
													$hour=($hours>0)?$hours." Hrs :":"";
													echo $minutes." Mins</th>
												</tr>
												
											</thead>
										</table>
										</div>
										<div class='hr-line-dashed'></div>
										<br>
										<p class='text-muted'><code>Overall Rating</code></p>
										<br>
										<p class='text-muted col-md-12'><code>Consider the following and rate the participant on the following In-basket/In-tray exercises
										<br>
										1. Has completed all the in-trays in the given time<br>
										2. The prioritization is consistent with the requirements of the Role & Responsibilities<br>
										3. The quality of action proposed reflects the competency requirements<br>
										4. The way to action (i.e. delegate, hold, actionize) proposed are appropriate to the In-tray<br>
										5. When delegating the actions are clear, lucid and understandable
										</code></p>
										<br><br>
										<div class='form-group'>
										
										<div class='hr-line-dashed'></div><br>";
										$rating=UlsRatingMasterScale::ratingscale($ass_details['rating_id']);
										echo "<label class='col-sm-2 control-label'>Rating<sup><font color='#FF0000'>*</font></sup>:</label>";
											
											echo "<div class='col-sm-3'>
												<select class='validate[required] form-control' name='scale_id' id='scale_id'>
													<option value=''>Select</option>";
													foreach($rating as $ratings){
														$rat_sel=!empty($ass_rating['scale_id'])?($ass_rating['scale_id']==$ratings['scale_id']?'selected="selected"':''):'';
														echo "<option value='".$ratings['scale_id']."' ".$rat_sel.">".$ratings['rating_name_scale']."</option>";
													}
												echo "</select>
											</div>
										</div>
										<!--<div class='form-group'>
											<label class='col-sm-3 control-label'>Correct Answers<sup><font color='#FF0000'>*</font></sup>:</label>";
											$correct_ans=!empty($ass_rating['correct_ans'])?$ass_rating['correct_ans']:'';
											echo "<div class='col-sm-6'><input class='validate[required,custom[integer]] form-control' type='text' name='correct_ans' id='correct_ans' value='".$correct_ans."'></div>
										</div>
										<div class='form-group'>
											<label class='col-sm-3 control-label'>Wrong Answers<sup><font color='#FF0000'>*</font></sup>:</label>";
											$wrong_ans=!empty($ass_rating['wrong_ans'])?$ass_rating['wrong_ans']:'';
											echo "<div class='col-sm-9'><input class='validate[required,custom[integer]] form-control' type='text' name='wrong_ans' id='wrong_ans' value='".$wrong_ans."'></div>
										</div>
										<div class='form-group'>
											<label class='col-sm-3 control-label'>Total Score<sup><font color='#FF0000'>*</font></sup>:</label>";
											$score=!empty($ass_rating['score'])?$ass_rating['score']:'';
											echo "<div class='col-sm-9'><input class='validate[required,custom[integer],max[]] form-control' type='text' name='score' id='score' value='".$score."'></div>
										</div>-->
										<div class='form-group'>
											<label class='col-sm-2 control-label'>Comments<sup><font color='#FF0000'>*</font></sup>:</label>";
											$comments=!empty($ass_rating['comments'])?$ass_rating['comments']:'';
											echo "<div class='col-sm-9'><textarea class='validate[required] form-control' type='text' name='comments' id='comments'>".$comments."</textarea></div>
										</div>
										<div class='hr-line-dashed'></div>";
										$ass_rating_dis=!empty($ass_rating['ass_rating_id'])?'disabled':"";
										echo "<div class='form-group'>
											<div class='col-sm-12 col-sm-offset-6'>
												<button class='btn btn-default' data-dismiss='modal' type='button'>Cancel</button>
												<button class='btn btn-warning' type='button' name='submit' id='casestudy_save_".$ins_id."'>Save</button>
												<button class='btn btn-primary' type='button' name='submit' id='casestudy_submit_".$ins_id."'>Submit</button>
											</div>
										</div>
									
								
								</div>
							</form>
							</div>";
						}          
					} 
					else { 
						echo "<p>No Data Available.</p>"; 
					} 
				echo "<div class='hr-line-dashed'></div>
		
				<div id='myModal_in_".$ass_test_id."'  class='modal fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'  aria-hidden='false' style='overflow-y:auto;' >
					<div class='modal-dialog modal-lg' style='width:500px'>
						<div class='modal-content'>
							<div class='color-line'></div>
							<div class='modal-header'>
								<button aria-hidden='true' class='close' id='close_".$ass_test_id."' type='button'>×</button>
								<h4 class='modal-title'>In-basket Expert View</h4>
							</div>
							<div class='modal-body'>
								<table cellpadding='1' cellspacing='1' id='edit_datable_2' class='table table-hover table-bordered mb-0'>
									<thead>
										<tr>
											<th class='col-sm-8'>In-tray Name</th>
											<th class='col-sm-4'>Expert Priority</th>
										</tr>
									</thead>
									<tbody>";
									if(count($testdetails)>0){
										foreach($testdetails as $keys=>$testdetail){
											$intray_name=(isset($testdetail['inbasket_tray_name']))?$testdetail['inbasket_tray_name']:'In-tray';
											$ques_values=UlsQuestionValues::get_allquestion_values_competency($testdetail['question_id']);
											foreach($ques_values as $key1=>$ques_valuess){
												echo "<tr>
													<td>".$intray_name." ".$ques_valuess['scorting_order']."</td>
													<td>".$ques_valuess['priority_inbasket']."</td>
												</tr>";
											}
										}
									}
									echo "</tbody>
								</table>
							</div>
							
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div>
				<hr class='light-grey-hr'>
		
		</div>
		";	
	}
	
	public function inbasket_test_details(){
		$in_id=$_REQUEST['inbasket_id'];
		$data="";
		$compdetails=UlsInbasketMaster::viewinbasket($in_id);
		$data.="<h3>In-basket Name: ".@$compdetails['inbasket_name']."</h3>
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
		$data.="<h3>Casestudy Name: ".@$compdetails['casestudy_name']."</h3>
		<p>Author: ".@$compdetails['casestudy_author']."</p>
		<p>Source: ".@$compdetails['casestudy_source']."</p>";
		if(!empty($compdetails['casestudy_link'])){ 
		$data.="<p>Link: <a href='".BASE_URL."/public/uploads/inbasket/".$compdetails['casestudy_id']."/".$compdetails['casestudy_link']."' target='_blank' >Click Here</a></p>";
		}
		$data.="<p>Status: ".@$compdetails['casestatus']."</p>
		<p>".@$compdetails['casestudy_description']."</p>";
		echo $data;
	}
	
	public function inbasket_test_view(){	   
		$testype=$_REQUEST['type'];
        $ass_test_id=$_REQUEST['id'];
		$ass_id=$_REQUEST['ass_id'];
		$emp_id=$_REQUEST['emp_id'];
		$tid=$_REQUEST['test_id'];
		$ins_id=$_REQUEST['ins_id'];
		$inbasket_name=UlsInbasketMaster::viewinbasket($ins_id);
		$testdetails=UlsUtestAttemptsAssessment::getattemptvalus_inbasket($ass_id,$emp_id,$ass_test_id,$testype,$tid);
		$question_count=UlsUtestQuestionsAssessment::ass_question_count($tid,$testype,$ass_id,$ass_test_id,$emp_id);	
		$ass_rating=UlsAssessmentAssessorRating::get_ass_rating($testdetails['attempt_id'],$emp_id,$testype);
		$ass_rating_id=!empty($ass_rating['ass_rating_id'])?$ass_rating['ass_rating_id']:"";
		$data="";
		$data.="
			<table class='table table-bordered table-striped' cellspacing='1' cellpadding='1'>
				<thead>
					<tr>
						<th style=' background-color: #edf3f4;width:30%'>In basket Name</th>
						<th>".$inbasket_name['inbasket_name']."&nbsp;</th>
					</tr>
					<tr>
						<th style=' background-color: #edf3f4;width:30%'>Time Taken</th>
						<th>&nbsp;</th>
					</tr>
					<tr>
						<th style=' background-color: #edf3f4;width:30%'>Total Questions</th>
						<th>".$question_count."&nbsp;</th>
					</tr>
				</thead>
			</table>
			<div class='hr-line-dashed'></div>
			<form action='' method='post' class='form-horizontal' id='inbasket_form_".$ins_id."' name='inbasket_form_".$ins_id."'>
				<input type='hidden' name='ass_rating_id'  id='ass_rating_id' value='".$ass_rating_id."'>
				<input type='hidden' name='attempt_id'  id='attempt_id' value='".$testdetails['attempt_id']."'>
				<input type='hidden' name='employee_id'  id='employee_id' value='".$emp_id."'>
				<input type='hidden' name='assessment_type'  id='assessment_type' value='".$testype."'>
				<div class='form-group'>
					<label class='col-sm-3 control-label'>Correct Answers<sup><font color='#FF0000'>*</font></sup>:</label>";
					$correct_ans=!empty($ass_rating['correct_ans'])?$ass_rating['correct_ans']:'';
					$data.="<div class='col-sm-9'><input class='validate[required,custom[integer]] form-control' type='text' name='correct_ans' id='correct_ans' value='".$correct_ans."'></div>
				</div>
				<div class='form-group'>
					<label class='col-sm-3 control-label'>Wrong Answers<sup><font color='#FF0000'>*</font></sup>:</label>";
					$wrong_ans=!empty($ass_rating['wrong_ans'])?$ass_rating['wrong_ans']:'';
					$data.="<div class='col-sm-9'><input class='validate[required,custom[integer]] form-control' type='text' name='wrong_ans' id='wrong_ans' value='".$wrong_ans."'></div>
				</div>
				<div class='form-group'>
					<label class='col-sm-3 control-label'>Total Score<sup><font color='#FF0000'>*</font></sup>:</label>";
					$score=!empty($ass_rating['score'])?$ass_rating['score']:'';
					$data.="<div class='col-sm-9'><input class='validate[required,custom[integer],max[".$question_count."]] form-control' type='text' name='score' id='score' value='".$score."'></div>
				</div>
				<div class='form-group'>
					<label class='col-sm-3 control-label'>Comments</label>";
					$comments=!empty($ass_rating['comments'])?$ass_rating['comments']:'';
					$data.="<div class='col-sm-9'><textarea placeholder='placeholder' class='form-control' type='text' name='comments' id='comments'>".$comments."</textarea></div>
				</div>
				<div class='hr-line-dashed'></div>
			
				<div class='form-group'>
					<div class='col-sm-8 col-sm-offset-4'>
						<button class='btn btn-default' data-dismiss='modal' type='button'>Cancel</button>
						<button class='btn btn-primary' type='button' name='submit' id='inbasket_submit_".$ins_id."'>Submit</button>
					</div>
				</div>
			</form>
		";
		echo $data;
		
	}
	
	public function casestudy_test_view(){	   
		$testype=$_REQUEST['type'];
        $ass_test_id=$_REQUEST['id'];
		$ass_id=$_REQUEST['ass_id'];
		$emp_id=$_REQUEST['emp_id'];
		$tid=$_REQUEST['test_id'];
		$case_id=$_REQUEST['case_id'];
		$inbasket_name=UlsCaseStudyMaster::viewcasestudy($case_id);
		$testdetails=UlsUtestAttemptsAssessment::getattemptvalus_inbasket($ass_id,$emp_id,$ass_test_id,$testype,$tid);
		$question_count=UlsUtestQuestionsAssessment::ass_question_count($tid,$testype,$ass_id,$ass_test_id,$emp_id);
		$ass_rating=UlsAssessmentAssessorRating::get_ass_rating($testdetails['attempt_id'],$emp_id,$testype);
		$ass_rating_id=!empty($ass_rating['ass_rating_id'])?$ass_rating['ass_rating_id']:"";
		$data="";
		$data.="
			<table class='table table-bordered table-striped' cellspacing='1' cellpadding='1'>
				<thead>
					<tr>
						<th style=' background-color: #edf3f4;width:30%'>Case study Name</th>
						<th>".$inbasket_name['casestudy_name']."&nbsp;</th>
					</tr>
					<tr>
						<th style=' background-color: #edf3f4;width:30%'>Time Taken</th>
						<th>&nbsp;</th>
					</tr>
					<tr>
						<th style=' background-color: #edf3f4;width:30%'>Total Questions</th>
						<th>".$question_count."&nbsp;</th>
					</tr>
				</thead>
			</table>
			<div class='hr-line-dashed'></div>
			<form action='' method='post' class='form-horizontal' id='casestudy_form_".$case_id."' name='casestudy_form_".$case_id."'>
				<input type='hidden' name='ass_rating_id'  id='ass_rating_id' value='".$ass_rating_id."'>
				<input type='hidden' name='attempt_id'  id='attempt_id' value='".$testdetails['attempt_id']."'>
				<input type='hidden' name='employee_id'  id='employee_id' value='".$emp_id."'>
				<input type='hidden' name='assessment_type'  id='assessment_type' value='".$testype."'>
				<div class='form-group'>
					<label class='col-sm-3 control-label'>Correct Answers<sup><font color='#FF0000'>*</font></sup>:</label>";
					$correct_ans=!empty($ass_rating['correct_ans'])?$ass_rating['correct_ans']:'';
					$data.="<div class='col-sm-9'><input class='validate[required,custom[integer]] form-control' type='text' name='correct_ans' id='correct_ans' value='".$correct_ans."'></div>
				</div>
				<div class='form-group'>
					<label class='col-sm-3 control-label'>Wrong Answers<sup><font color='#FF0000'>*</font></sup>:</label>";
					$wrong_ans=!empty($ass_rating['wrong_ans'])?$ass_rating['wrong_ans']:'';
					$data.="<div class='col-sm-9'><input class='validate[required,custom[integer]] form-control' type='text' name='wrong_ans' id='wrong_ans' value='".$wrong_ans."'></div>
				</div>
				<div class='form-group'>
					<label class='col-sm-3 control-label'>Total Score<sup><font color='#FF0000'>*</font></sup>:</label>";
					$score=!empty($ass_rating['score'])?$ass_rating['score']:'';
					$data.="<div class='col-sm-9'><input class='validate[required,custom[integer],max[".$question_count."]] form-control' type='text' name='score' id='score' value='".$score."'></div>
				</div>
				<div class='form-group'>
					<label class='col-sm-3 control-label'>Comments</label>";
					$comments=!empty($ass_rating['comments'])?$ass_rating['comments']:'';
					$data.="<div class='col-sm-9'><textarea placeholder='placeholder' class='form-control' type='text' name='comments' id='comments'>".$comments."</textarea></div>
				</div>
				<div class='hr-line-dashed'></div>
			
				<div class='form-group'>
					<div class='col-sm-8 col-sm-offset-4'>
						<button class='btn btn-default' data-dismiss='modal' type='button'>Cancel</button>
						<button class='btn btn-primary' type='button' name='submit' id='casestudy_submit_".$case_id."'>Submit</button>
					</div>
				</div>
			</form>
		";
		echo $data;
		
	}
	
	public function test_result_insert(){
		if(isset($_POST['scale_id'])){
			//print_r($_POST);
			$fieldinsertupdates=array('scale_id','attempt_id','employee_id','position_id','assessment_id','assessment_type','comments');
			$role=!empty($_POST['ass_rating_id'])? Doctrine_Core::getTable('UlsAssessmentAssessorRating')->find($_POST['ass_rating_id']):new UlsAssessmentAssessorRating();
			foreach($fieldinsertupdates as $val){ $role->$val=!empty($_POST[$val])? $_POST[$val]:null;}
			$role->status='A';
			$role->save();
			
			if(!empty($_POST['competency'])){
			foreach($_POST['competency'] as $key=>$competencys){
				$compid=UlsAssessmentReport::getadminassessment_com_insert($_POST['assessment_id'],$_POST['position_id'],$_POST['employee_id'],$_POST['assessor_id'],$competencys);
				$master_value=isset($compid['report_id'])?Doctrine::getTable('UlsAssessmentReport')->find($compid['report_id']): new UlsAssessmentReport();
                $master_value->assessment_id=$_POST['assessment_id'];
				$master_value->position_id=$_POST['position_id'];
				$master_value->employee_id=$_POST['employee_id'];
				$master_value->assessor_id=$_POST['assessor_id'];
				$master_value->competency_id=$competencys;
				$master_value->require_scale_id=$_POST['requiredlevel_'.$competencys];
				/* $master_value->assessed_scale_id=$_POST['OVERALL_'.$competencys];
				$master_value->development_area=$_POST['development_'.$competencys]; */
                $master_value->save();
				$ass_test=UlsAssessmentTest::assessment_test($master_value->assessment_id,$master_value->position_id);
				foreach($ass_test as $ass_tests){
					if(isset($_POST['TEST_'.$competencys])){
						if($ass_tests['assessment_type']=='TEST'){
							$master_results=UlsAssessmentReportBytype::summary_details($master_value->report_id,$ass_tests['assessment_type'],$competencys);
							$master_value_sub=!empty($master_results['report_assess_id'])?Doctrine::getTable('UlsAssessmentReportBytype')->find($master_results['report_assess_id']): new UlsAssessmentReportBytype();
							$master_value_sub->report_id=$master_value->report_id;
							$master_value_sub->assessment_id=$master_value->assessment_id;
							$master_value_sub->position_id=$master_value->position_id;
							$master_value_sub->employee_id=$master_value->employee_id;
							$master_value_sub->assessor_id=$master_value->assessor_id;
							$master_value_sub->assessment_type=$ass_tests['assessment_type'];
							$master_value_sub->competency_id=$competencys;
							$master_value_sub->require_scale_id=$master_value->require_scale_id;
							$master_value_sub->assessed_scale_id=!empty($_POST['TEST_'.$competencys])?$_POST['TEST_'.$competencys]:NULL;
							$master_value_sub->interview_comments=" ";
							$master_value_sub->save();
						}
					}
				} 
			}
			}
			echo $button='done@yes';
			//echo $button;
		}
	}
	
	public function casestudy_result_insert(){
		if(isset($_POST['scale_id'])){
			//print_r($_POST);
			$fieldinsertupdates=array('scale_id','attempt_id','employee_id','position_id','assessment_id','assessment_type','comments');
			$role=!empty($_POST['ass_rating_id'])? Doctrine_Core::getTable('UlsAssessmentAssessorRating')->find($_POST['ass_rating_id']):new UlsAssessmentAssessorRating();
			foreach($fieldinsertupdates as $val){ $role->$val=!empty($_POST[$val])? $_POST[$val]:null;}
			$role->status='A';
			$role->save();
		if(!empty($_POST['competency'])){
			foreach($_POST['competency'] as $key=>$competencys){
				$compid=UlsAssessmentReport::getadminassessment_com_insert($_POST['assessment_id'],$_POST['position_id'],$_POST['employee_id'],$_POST['assessor_id'],$competencys);
				$master_value=isset($compid['report_id'])?Doctrine::getTable('UlsAssessmentReport')->find($compid['report_id']): new UlsAssessmentReport();
                $master_value->assessment_id=$_POST['assessment_id'];
				$master_value->position_id=$_POST['position_id'];
				$master_value->employee_id=$_POST['employee_id'];
				$master_value->assessor_id=$_POST['assessor_id'];
				$master_value->competency_id=$competencys;
				$master_value->require_scale_id=$_POST['requiredlevel_'.$competencys];
				/* $master_value->assessed_scale_id=$_POST['OVERALL_'.$competencys];
				$master_value->development_area=$_POST['development_'.$competencys]; */
                $master_value->save();
				$ass_test=UlsAssessmentTest::assessment_test($master_value->assessment_id,$master_value->position_id);
				foreach($ass_test as $ass_tests){
					if(isset($_POST['INTERVIEW_'.$competencys])){
						if($ass_tests['assessment_type']=='INTERVIEW'){
							$master_results=UlsAssessmentReportBytype::summary_details($master_value->report_id,$ass_tests['assessment_type'],$competencys);
							$master_value_sub=!empty($master_results['report_assess_id'])?Doctrine::getTable('UlsAssessmentReportBytype')->find($master_results['report_assess_id']): new UlsAssessmentReportBytype();
							$master_value_sub->report_id=$master_value->report_id;
							$master_value_sub->assessment_id=$master_value->assessment_id;
							$master_value_sub->position_id=$master_value->position_id;
							$master_value_sub->employee_id=$master_value->employee_id;
							$master_value_sub->assessor_id=$master_value->assessor_id;
							$master_value_sub->assessment_type=$ass_tests['assessment_type'];
							$master_value_sub->competency_id=$competencys;
							$master_value_sub->require_scale_id=$master_value->require_scale_id;
							$master_value_sub->assessed_scale_id=!empty($_POST['INTERVIEW_'.$competencys])?$_POST['INTERVIEW_'.$competencys]:NULL;
							$master_value_sub->interview_ass_value=!empty($_POST['INTERVIEW_ass_value_'.$competencys])?$_POST['INTERVIEW_ass_value_'.$competencys]:NULL;//$master_value_sub->interview_comments=$_POST['INTERVIEW_comments_'.$competencys];
							$master_value_sub->save();
							
							$master_value_update=isset($master_value->report_id)?Doctrine::getTable('UlsAssessmentReport')->find($master_value->report_id): new UlsAssessmentReport();
							$master_value_update->development_area=isset($_POST['INTERVIEW_comments_'.$competencys])?$_POST['INTERVIEW_comments_'.$competencys]:NULL;
							$master_value_update->save();
						}
					}
				} 
			}
		}
		echo $button='done@yes';
			//echo $button;
		}
		
	}
	
	public function interview_overall_result_insert(){
		if(isset($_POST['scale_id'])){
			//print_r($_POST);
			$fieldinsertupdates=array('scale_id','attempt_id','employee_id','position_id','assessment_id','assessment_type','comments');
			$role=!empty($_POST['ass_rating_id'])? Doctrine_Core::getTable('UlsAssessmentAssessorRating')->find($_POST['ass_rating_id']):new UlsAssessmentAssessorRating();
			foreach($fieldinsertupdates as $val){ $role->$val=!empty($_POST[$val])? $_POST[$val]:null;}
			$role->status='A';
			$role->save();
			$ass_test_final=UlsAssessmentReportFinal::assessment_assessor_final($_POST['assessment_id'],$_POST['position_id'],$_POST['employee_id'],$_POST['assessor_id']);
			$master_value_final=!empty($ass_test_final['final_id'])?Doctrine::getTable('UlsAssessmentReportFinal')->find($ass_test_final['final_id']): new UlsAssessmentReportFinal();
			$master_value_final->assessment_id=$_POST['assessment_id'];
			$master_value_final->position_id=$_POST['position_id'];
			$master_value_final->employee_id=$_POST['employee_id'];
			$master_value_final->assessor_id=$_POST['assessor_id'];
			$master_value_final->status='A';
			$master_value_final->save();
			
			echo $button='done@yes';
			//echo $button;
		}
	}
	
	public function inbasket_interview_result_insert(){
		if(isset($_POST['scale_id'])){
			//print_r($_POST);
			$fieldinsertupdates=array('scale_id','attempt_id','employee_id','position_id','assessment_id','assessment_type','comments');
			$role=!empty($_POST['ass_rating_id'])? Doctrine_Core::getTable('UlsAssessmentAssessorRating')->find($_POST['ass_rating_id']):new UlsAssessmentAssessorRating();
			foreach($fieldinsertupdates as $val){ $role->$val=!empty($_POST[$val])? $_POST[$val]:null;}
			$role->status='A';
			$role->save();
		if(!empty($_POST['competency'])){
			foreach($_POST['competency'] as $key=>$competencys){
				$compid=UlsAssessmentReport::getadminassessment_com_insert($_POST['assessment_id'],$_POST['position_id'],$_POST['employee_id'],$_POST['assessor_id'],$competencys);
				$master_value=isset($compid['report_id'])?Doctrine::getTable('UlsAssessmentReport')->find($compid['report_id']): new UlsAssessmentReport();
                $master_value->assessment_id=$_POST['assessment_id'];
				$master_value->position_id=$_POST['position_id'];
				$master_value->employee_id=$_POST['employee_id'];
				$master_value->assessor_id=$_POST['assessor_id'];
				$master_value->competency_id=$competencys;
				$master_value->require_scale_id=$_POST['requiredlevel_'.$competencys];
				/* $master_value->assessed_scale_id=$_POST['OVERALL_'.$competencys];
				$master_value->development_area=$_POST['development_'.$competencys]; */
                $master_value->save();
				if(isset($_POST['INBASKET_'.$competencys])){
					/* $master_results=UlsAssessmentReportBytype::summary_details($master_value->report_id,'INBASKET',$competencys); */
					$master_results=UlsAssessmentReportBytype::summary_details_inbaskert($master_value->report_id,'INBASKET',$competencys,$_POST['inb_assess_test_id']);
					$master_value_sub=!empty($master_results['report_assess_id'])?Doctrine::getTable('UlsAssessmentReportBytype')->find($master_results['report_assess_id']): new UlsAssessmentReportBytype();
					$master_value_sub->inb_assess_test_id=$_POST['inb_assess_test_id'];
					$master_value_sub->report_id=$master_value->report_id;
					$master_value_sub->assessment_id=$master_value->assessment_id;
					$master_value_sub->position_id=$master_value->position_id;
					$master_value_sub->employee_id=$master_value->employee_id;
					$master_value_sub->assessor_id=$master_value->assessor_id;
					$master_value_sub->assessment_type='INBASKET';
					$master_value_sub->competency_id=$competencys;
					$master_value_sub->require_scale_id=$master_value->require_scale_id;
					$master_value_sub->assessed_scale_id=!empty($_POST['INBASKET_'.$competencys])?$_POST['INBASKET_'.$competencys]:NULL;
					//$master_value_sub->interview_comments=!empty($_POST['INBASKET_'.$competencys])?$_POST['INBASKET_'.$competencys]:NULL;
					$master_value_sub->save();
				}
			}
		}
		echo $button='done@yes';
		}
	}
	
	public function casestudy_interview_result_insert(){
		if(isset($_POST['scale_id'])){
			//print_r($_POST);
			$fieldinsertupdates=array('scale_id','attempt_id','employee_id','position_id','assessment_id','assessment_type','comments');
			$role=!empty($_POST['ass_rating_id'])? Doctrine_Core::getTable('UlsAssessmentAssessorRating')->find($_POST['ass_rating_id']):new UlsAssessmentAssessorRating();
			foreach($fieldinsertupdates as $val){ $role->$val=!empty($_POST[$val])? $_POST[$val]:null;}
			$role->status='A';
			$role->save();
		if(!empty($_POST['competency'])){
			foreach($_POST['competency'] as $key=>$competencys){
				$compid=UlsAssessmentReport::getadminassessment_com_insert($_POST['assessment_id'],$_POST['position_id'],$_POST['employee_id'],$_POST['assessor_id'],$competencys);
				$master_value=isset($compid['report_id'])?Doctrine::getTable('UlsAssessmentReport')->find($compid['report_id']): new UlsAssessmentReport();
                $master_value->assessment_id=$_POST['assessment_id'];
				$master_value->position_id=$_POST['position_id'];
				$master_value->employee_id=$_POST['employee_id'];
				$master_value->assessor_id=$_POST['assessor_id'];
				$master_value->competency_id=$competencys;
				$master_value->require_scale_id=$_POST['requiredlevel_'.$competencys];
                $master_value->save();
				if(isset($_POST['CASE_STUDY_'.$competencys])){
					/* $master_results=UlsAssessmentReportBytype::summary_details($master_value->report_id,'CASE_STUDY',$competencys); */
					$master_results=UlsAssessmentReportBytype::summary_details_casestudy($master_value->report_id,'CASE_STUDY',$competencys,$_POST['case_assess_test_id']);
					$master_value_sub=!empty($master_results['report_assess_id'])?Doctrine::getTable('UlsAssessmentReportBytype')->find($master_results['report_assess_id']): new UlsAssessmentReportBytype();
					$master_value_sub->report_id=$master_value->report_id;
					$master_value_sub->case_assess_test_id=$_POST['case_assess_test_id'];
					$master_value_sub->assessment_id=$master_value->assessment_id;
					$master_value_sub->position_id=$master_value->position_id;
					$master_value_sub->employee_id=$master_value->employee_id;
					$master_value_sub->assessor_id=$master_value->assessor_id;
					$master_value_sub->assessment_type='CASE_STUDY';
					$master_value_sub->competency_id=$competencys;
					$master_value_sub->require_scale_id=$master_value->require_scale_id;
					$master_value_sub->assessed_scale_id=!empty($_POST['CASE_STUDY_'.$competencys])?$_POST['CASE_STUDY_'.$competencys]:NULL;
					$master_value_sub->interview_comments=!empty($_POST['CASE_STUDY_'.$competencys])?$_POST['CASE_STUDY_'.$competencys]:NULL;
					$master_value_sub->save();
				}
			}
		}
		echo $button='done@yes';
		}
	}
	
	public function interview_process_result_insert(){
		if(isset($_POST['interview_comments'])){
			/* print_r($_POST);
			exit(); */
			//if(!empty($_POST['interview_comments'])){
				foreach($_POST['interview_comments'] as $key=>$interview_comments){
					//if(!empty($interview_comments)){
					$compid=UlsAssessmentReportBytypeInterview::get_interview_adminassessment_com_insert($_POST['assessment_id'],$_POST['position_id'],$_POST['employee_id'],$_POST['assessor_id'],$_POST['assessor_id'],$_POST['comp_def_id'],$_POST['comp_int_qid'][$key],$_POST['report_id']);
					$master_value=!empty($_POST['report_ass_intid'][$key])?Doctrine::getTable('UlsAssessmentReportBytypeInterview')->find($_POST['report_ass_intid'][$key]): new UlsAssessmentReportBytypeInterview();
					$master_value->assessment_id=$_POST['assessment_id'];
					$master_value->position_id=$_POST['position_id'];
					$master_value->employee_id=$_POST['employee_id'];
					$master_value->assessor_id=$_POST['assessor_id'];
					$master_value->competency_id=$_POST['comp_def_id'];
					$master_value->require_scale_id=$_POST['scale_id'];
					$master_value->report_id=$_POST['report_id'];
					$master_value->comp_qtype=$_POST['comp_qtype'];
					$master_value->comp_int_id=$_POST['comp_int_id'];
					$master_value->assessment_type='INTERVIEW';
					$master_value->comp_int_qid=$_POST['comp_int_qid'][$key];
					$master_value->interview_comments=!empty($interview_comments)?($interview_comments):NULL;
					$master_value->save();
					//}
				}
			//}
			echo $button='done@yes';
			//echo $button;
		}
	}
	
	
	
	public function inbasket_result_insert(){
		if(isset($_POST['score'])){
			$fieldinsertupdates=array('score','wrong_ans','correct_ans','attempt_id','employee_id','assessment_type','comments');
			$role=!empty($_POST['ass_rating_id'])? Doctrine_Core::getTable('UlsAssessmentAssessorRating')->find($_POST['ass_rating_id']):new UlsAssessmentAssessorRating();
			foreach($fieldinsertupdates as $val){ $role->$val=!empty($_POST[$val])? $_POST[$val]:null;}
			$role->status='A';
			$role->save();
			echo 'done';
		}
	}
	
	public function test_info_view(){
		$attempt_id=$_REQUEST['attempt_id'];
        $test_id=$_REQUEST['test_id'];
		$emp_id=$_REQUEST['emp_id'];
		$pos_id=$_REQUEST['pos_id'];
		$testdetails=UlsUtestAttemptsAssessment::attempt_details($attempt_id,$test_id,$emp_id);	
		$assdetails=UlsAssessmentDefinition::viewassessment($testdetails['assessment_id']);
		
		
		$comp_questions=UlsAssessmentTestQuestions::gettestquestions($testdetails['event_id'],$testdetails['test_id'],$testdetails['test_type'],$emp_id,$testdetails['assessment_id']);
		
		
		$grade_details=UlsEmployeeMaster::fetch_emp_grade_per($emp_id);
		$question_blank=UlsUtestResponsesAssessment::question_count_blank($emp_id,$testdetails['event_id'],$testdetails['assessment_id']);
		$total=(($testdetails['correct_ans'])+($testdetails['wrong_ans']));
		$wrongans=count($question_blank)>0?($testdetails['wrong_ans']-$question_blank['c_count']):$testdetails['wrong_ans'];
		$ass_rating=UlsAssessmentAssessorRating::get_ass_rating($attempt_id,$emp_id,$testdetails['test_type']);
		$ass_rating_id=!empty($ass_rating['ass_rating_id'])?$ass_rating['ass_rating_id']:"";
		//".$grade_details['grade_percentage']."
		$data="";
		
		$data.="
		<p class='text-muted'><code>Once you Save a rating, it cannot be changed later</code></p>
		<br>
		<form action='' method='post' class='form-horizontal' id='test_form_".$attempt_id."' name='test_form_".$attempt_id."'>
			<input type='hidden' name='ass_rating_id'  id='ass_rating_id' value='".$ass_rating_id."'>
			<input type='hidden' name='attempt_id'  id='attempt_id' value='".$attempt_id."'>
			<input type='hidden' name='employee_id'  id='employee_id' value='".$emp_id."'>
			<input type='hidden' name='assessment_type'  id='assessment_type' value='".$testdetails['test_type']."'>
			<input type='hidden' name='assessment_id' value='".$testdetails['assessment_id']."' >
			<input type='hidden' name='position_id' value='".$pos_id."' >
			<input type='hidden' name='assessor_id' value='".$_SESSION['asr_id']."' >
			<table class='table table-bordered table-striped' cellspacing='1' cellpadding='1'>
				<thead>
					<tr>
						<th style=' background-color: #edf3f4;width:30%'>Total Questions</th>
						<th>".$total."&nbsp;</th>
					</tr>
					<tr>
						<th style=' background-color: #edf3f4;width:30%'>Correct Questions</th>
						<th>".$testdetails['correct_ans']."&nbsp;</th>
					</tr>
					<tr>
						<th style=' background-color: #edf3f4;width:30%'>Unanswered Questions</th>
						<th>".$question_blank['c_count']."&nbsp;</th>
					</tr>
					<tr>
						<th style=' background-color: #edf3f4;width:30%'>Wrong Questions</th>
						<th>".$wrongans."&nbsp;</th>
					</tr>
					<tr>
						<th style=' background-color: #edf3f4;width:30%'>Score</th>
						<th>".$testdetails['score']."&nbsp;</th>
					</tr>
				</thead>
			</table>
			<div class='hr-line-dashed'></div>
			";
			$ass_details=UlsAssessmentDefinition::viewassessment($testdetails['assessment_id']);
			
			$data.="<p class='text-muted'><code>Based on test score, please rate individual competencies.</code></p>
			<div class='hr-line-dashed'></div>
			<div class='table-responsive'>
				<table cellpadding='1' cellspacing='1' class='table table-bordered table-striped'>
					<thead>
						<tr>
							<th>Competency Name</th>
							<th>Required Level</th>
							<th># of Questions</th>
							<th>Unanswered Questions</th>
							<th># Answered right</th>
							<th># Answered wrong</th>
							<th>% Correct</th>
							<th>Assessed Level</th>
						</tr>
					</thead>
					<tbody>";
					$total_per_count=$total_correct_count=$total_count=$total_blank_count=$total_wrong_count=0;
					foreach($comp_questions as $key1=>$comp_question){
						
						$cor_count=UlsUtestResponsesAssessment::question_count_correct($comp_question['q_id'],$emp_id,$testdetails['event_id'],$testdetails['assessment_id']);
						$blank_count=UlsUtestResponsesAssessment::question_count_leftblank($comp_question['q_id'],$emp_id,$testdetails['event_id'],$testdetails['assessment_id']);
						$total=@explode(",",$comp_question['q_id']);
						$total_question=($blank_count['l_count'])>0?(count($total)-$blank_count['l_count']):count($total);
						$total_per=($cor_count['c_count']>0)?(round((($cor_count['c_count']/$total_question)*100),2)):0;
						$wrong_questions=(count($total)-$blank_count['l_count']-$cor_count['c_count']);
						$total_per_count+=$total_per;
						$total_correct_count+=$cor_count['c_count'];
						$total_blank_count+=$blank_count['l_count'];
						$total_wrong_count+=$wrong_questions;
						$total_count+=count($total);
						$scale=UlsLevelMasterScale::levelscale($comp_question['assessment_pos_level_id']);
						
						$data.="<tr>
							<td>
							<input type='hidden' name='position_id' value='".$comp_question['position_id']."'>
							<input type='hidden' name='report_id[]' value='".$comp_question['report_id']."'>
							<input type='hidden' name='competency[]' id='competency[]' value='".$comp_question['comp_def_id']."'>
							<a href='".BASE_URL."/assessor/comp_test_view?comp_id=".$comp_question['comp_def_id']."&event_id=".$testdetails['event_id']."&emp_id=".$emp_id."&ass_id=".$testdetails['assessment_id']."&q_id=".$comp_question['q_id']."' target='_blank' style='color:#007bb6;text-decoration:underline'>".$comp_question['comp_def_name']."</a></td>
							<td>
							<input type='hidden' name='requiredlevel_".$comp_question['comp_def_id']."' value='".$comp_question['scale_id']."' >
							".$comp_question['scale_name']."</td>
							<td>".count($total)."</td>
							<td>".$blank_count['l_count']."</td>
							<td>".$cor_count['c_count']."</td>
							<td>".$wrong_questions."</td>
							<td>".$total_per."</td>";
							$scale_no=$grade_per="";
							$req_scale=$comp_question['scale_id'];
							if(!empty($grade_details['grade_percentage'])){
								$scale_no=$comp_question['scale_number'];
								if($grade_details['grade_percentage']>$total_per){
									if(($scale_no-1)==0){
										$scale_no=$scale_no;
									}
									else{
										$scale_no=$scale_no-1;										
									}
									$grade_per.="equal".$total_per."-".($comp_question['scale_id']);
								}
								elseif($grade_details['grade_percentage']<=$total_per){
									$scale_no=$scale_no;
									$grade_per.="great".$total_per."-".$comp_question['scale_id'];
								}
							}
							else{
								$grade_per="";
							}
							
							
							$data.="<td>
								<select name='".$testdetails['test_type']."_".$comp_question['comp_def_id']."' id='".$testdetails['test_type']."_".$comp_question['comp_def_id']."' class='form-control m-b validate[required]' style='width:250px;' onchange='open_alert(".$comp_question['comp_def_id'].")'>
									<option value=''>Select</option>";
									
									foreach($scale as $key=>$scales){
										
										$per_sel=!empty($scale_no)?($scales['scale_number']==$scale_no?"selected='selected'":""):"";
										$scale_s=!empty($comp_question['assessed_scale_id'])?$comp_question['assessed_scale_id']==$scales['scale_id']?"selected='selected'":"":$per_sel;
										$data.="<option value='".$scales['scale_id']."' ".$scale_s.">".$scales['scale_name']."</option>";
									}
									$data.="</select>
							</td>
						</tr>";
					}
					$data.="<tr>
						<td colspan='2'>Total % Correct</td>
						<td>".round(($total_count),1)."</td>
						<td>".round(($total_blank_count),1)."</td>
						<td>".round(($total_correct_count),1)."</td>
						<td>".round(($total_wrong_count),1)."</td>
						<td>".round(($total_per_count/count($comp_questions)),1)."</td>
						<td></td>
					</tr>";
					
					$data.="</tbody>
				</table>
			</div>";
			$total_cal=round(($total_per_count/count($comp_questions)),1);
			
			$calt="";
			if($total_cal<=45.9){
				$calt=6;
			}
			elseif(($total_cal>46) && ($total_cal<=65.9) ){
				$calt=7;
			}
			elseif(($total_cal>66) && ($total_cal<=80.9) ){
				$calt=8;
			}
			elseif(($total_cal>81) && ($total_cal<=100) ){
				$calt=9;
			}
			
			$data.="<input type='hidden' name='scale_id' id='scale_id' value='".$calt."'>";
			$data.="<div class='form-group'>
				<div class='col-sm-12 col-sm-offset-9'>
					<button class='btn btn-default' data-dismiss='modal' type='button'>Cancel</button>
					<button class='btn btn-primary' type='button' name='submit' id='test_submit_".$attempt_id."' >Save</button>
				</div>
			</div>
			
			</form>
			";
		echo $data;
		
	}
	
	public function comp_test_view(){
		$com_id=$_REQUEST['comp_id'];
		$emp_id=$_REQUEST['emp_id'];
		$ass_id=$_REQUEST['ass_id'];
		$event_id=$_REQUEST['event_id'];
		$q_id=$_REQUEST['q_id'];
		$que_values=UlsUtestResponsesAssessment::question_values($q_id,$emp_id,$event_id,$ass_id);
		$comp_name=UlsCompetencyDefinition::competency_detail_single($com_id);
		echo "
		<label>Test Questions of ".$comp_name['comp_def_name']."</label>
		<br style='clear:both'>
		<br style='clear:both'>
		<div style='padding-top: 3px; border:1px solid #DDDDDD; overflow: auto;' align='center'>
		<table width='100%'>";
		$testype='TEST';
		$ccc= Doctrine_Query::create()->from('UlsUtestResponsesAssessment')->where("employee_id=".$emp_id." and assessment_id=".$ass_id." and parent_org_id=".$_SESSION['parent_org_id']." and event_id=".$event_id." and test_type='".$testype."'")->execute();
		$chktest=array();
        foreach( $ccc as $cccs){
			$respvals[$cccs->utest_question_id]=$cccs->response_value_id;
			$chktest[$cccs->user_test_question_id]=$cccs->correct_flag;
		}
		$txt="";
		if(count($que_values)>0){
			foreach($que_values as $key=>$que_value){
				$type=$que_value['question_type']; 
				$qid=$que_value['question_id'];
				if($chktest[$qid]=='W'){
					$txt=$txt."<br>".$que_value['question_name'];
				}
				echo "<tr><td style='line-height: 18px;'><span style='float:left' >".($key+1)." )</span> ".$que_value['question_name']."
				</td>
				</tr>";
				$ss=Doctrine_Query::create()->select('text,correct_flag')->from("UlsQuestionValues")->where("question_id=".$que_value['question_id'])->execute();
				foreach($ss as $key1=>$sss){
					if($type=='F'){ 
						if(in_array($sss['value_id'],$respvals)){
							$valuename=Doctrine_Query::Create()->from('UlsUtestResponsesAssessment')->where("response_value_id=".$sss['value_id']." and assessment_id=".$ass_id."  And employee_id =".$emp_id." And test_type='".$testype."' And event_id=".$event_id)->fetchOne();
							$ched=htmlentities(stripslashes($valuename->text)); 
						}
						else {  $ched=""; }
						echo "<tr><td>&emsp;Ans: <input type='text' value='".$ched."' class='mediumtext' name='answer_".$key."[]' id='answer_". $key ."_".$key1 ."'/>";
						echo "</td></tr>";              
					}
					else if($type=='B'){
						if(in_array($sss['value_id'],$respvals)){				
							$valuename=Doctrine_Query::Create()->from('UlsUtestResponsesAssessment')->where("response_value_id=".$sss['value_id']." and assessment_id=".$ass_id." And employee_id =".$emp_id." And test_type='".$testype."' And event_id=".$event_id)->fetchOne(); 
							$ched=htmlentities(stripslashes($valuename->text));
						} 
						else {  $ched=""; }			  
						echo "<tr><td>&emsp;Ans: <input type='text' value='".$ched."' class='mediumtext' name='answer_".$key."[]' id='answer_".$key."_".$key1."' />
						</td></tr>  ";
					}
					else if($type=='T'){
						if(in_array($sss['value_id'], $respvals)){ $ched="checked='checked'"; } else {  $ched=""; }
						echo "<tr>
						<td>&emsp;<input type='radio' class='".$ched."  value='".$sss['value_id']."' name='answer_".$key."[]' value='' id='answer_".$key."_".$key1."'  style='float:left; margin-left: 13px;'/>
						<label style='font-size:13px; float:left;' for='truefalse'>".htmlentities(stripslashes($sss['text']))."</label> 
						</td>
						</tr>"; 
					}
					else if($type=='S'){ 
						if(in_array($sss['value_id'], $respvals)){ $ched="checked='checked'"; } 
						else {  $ched=""; }
						
						$color=$sss['correct_flag']=='Y'?"color:green":"";//".$sss['value_id']."-".htmlentities(stripslashes($sss['text']))."
						echo "<tr>
							<td>&emsp;<input type='radio'". $ched." value='".$sss['value_id']."' name='answer_".$key."[]' id='answer_".$key ."_".$key1."'  style='float:left; margin-left: 13px;' disabled />
							<label style='font-size:13px; float:left;".$color."' for='truefalse'>".htmlentities(stripslashes($sss['text']))."</label></td>
						</tr>";  
					}
					else if($type=='M'){
						if(in_array($sss['value_id'], $respvals)){ $ched='checked="checked"'; }
						else {  $ched=''; }			   
						echo"<tr>
							<td> &emsp; <input type='checkbox' ".$ched." value='".$sss['value_id']."' name='answer_".$key."[]' id='answer_".$key ."_".$key1."'  /> <label style='font-size:13px; margin-top:-7px;' for='truefalse'>".htmlentities(stripslashes($sss['text']))."</label></td>
						</tr> " ;
					}
					else if($type=='FT'){
						if(in_array($sss['value_id'],$respvals)){				
							$valuename=Doctrine_Query::Create()->from("UlsUtestResponsesAssessment")->where("response_value_id=".$sss['value_id']." and employee_id=".$emp_id." and test_type='".$testype."' and event_id=".$event_id." and assessment_id=".$ass_id)->fetchOne();
							$ched=htmlentities(stripslashes($valuename->text));
						}
						else {  $ched=""; }
						echo"<tr><td>&emsp;<textarea style='resize:none;' name='answer_".$key."[]' class='largetext' id='answer_".$key."_". $key1 ."'> ". $ched."</textarea> </td></tr> "; 
					}
				}
				echo "<tr><td><hr></td></tr>";
			}          
		} 
		else { echo "<tr><td>No Data Available.</td></tr>"; }  echo"</table></div>";
		if(!empty($txt)){
			echo "<strong>If required please copy paste the question into development roadmap</strong>".$txt;
		}
	}
	
	
	/* public function interview_test_view(){	   
		$attempt_id=$_REQUEST['attempt_id'];
        $test_id=$_REQUEST['test_id'];
		$emp_id=$_REQUEST['emp_id'];
		$testdetails=UlsUtestAttemptsAssessment::attempt_details($attempt_id,$test_id,$emp_id);
		$test_type='"'.$testdetails['test_type'].'"';
		$testdetail_comp=UlsAssessmentTestQuestions::gettestquestions($testdetails->event_id,$testdetails->test_id,$testdetails->test_type,$emp_id,$testdetails->assessment_id);
		$question_count=UlsUtestQuestionsAssessment::ass_question_count($test_id,$testdetails['test_type'],$testdetails['assessment_id'],$testdetails['event_id'],$testdetails['employee_id']);
		$ass_rating=UlsAssessmentAssessorRating::get_ass_rating($testdetails['attempt_id'],$testdetails['employee_id'],$testdetails['test_type']);
		$ass_rating_id=!empty($ass_rating['ass_rating_id'])?$ass_rating['ass_rating_id']:"";
		$test_details=UlsUtestResponsesAssessment::gettesttakenquestion_view($testdetails['test_id'],$testdetails['test_type'],$testdetails['assessment_id'],$testdetails['event_id'],$emp_id);
		$data="";
		$ss=''; $rr='';$respvals=array();
		$ccc= Doctrine_Query::create()->from('UlsUtestResponsesAssessment')->where("employee_id=".$emp_id." and assessment_id=".$testdetails['assessment_id']." and parent_org_id=".$_SESSION['parent_org_id']." and event_id=".$testdetails['event_id']." and test_type='".$testdetails['test_type']."'")->execute();
        foreach( $ccc as $cccs){
			$respvals[$cccs->utest_question_id]=$cccs->response_value_id;
		}
		
		
		$data.="<div style='padding-top: 3px; border:1px solid #DDDDDD; height: 300px;overflow: auto;' align='center'>
		<table width='100%'>";
		if(count($test_details)>0){
			foreach($test_details as $keys=>$testdetail){
				$key=$keys+1; 
				$type=$testdetail['question_type']; 
				$data.="<tr><td style='line-height: 18px;'><span style='float:left' >".$key." )</span> ".$testdetail['question_name']."
				</td>
				</tr>";
				$ss=Doctrine_Query::create()->select('text,correct_flag')->from("UlsQuestionValues")->where("question_id=".$testdetail['question_id'])->execute();
	 
				foreach($ss as $key1=>$sss){
					if($type=='F'){ 
						if(in_array($sss['value_id'],$respvals)){
							$valuename=Doctrine_Query::Create()->from('UlsUtestResponsesAssessment')->where("response_value_id=".$sss['value_id']." and assessment_id=".$testdetails['assessment_id']."  And employee_id =".$emp_id." And test_type='".$testdetails['test_type']."' And event_id=".$testdetails['event_id'])->fetchOne();
							$ched=htmlentities(stripslashes($valuename->text)); 
						}
						else {  $ched=""; }
						$data.="<tr><td>&emsp;Ans: <input type='text' value='".$ched."' class='mediumtext' name='answer_".$key."[]' id='answer_". $key ."_".$key1 ."'/>";
						$data.="</td></tr>";              
					}
					else if($type=='B'){
						if(in_array($sss['value_id'],$respvals)){				
							$valuename=Doctrine_Query::Create()->from('UlsUtestResponsesAssessment')->where("response_value_id=".$sss['value_id']." and assessment_id=".$testdetails['assessment_id']." And employee_id =".$emp_id." And test_type='".$testdetails['test_type']."' And event_id=".$testdetails['event_id'])->fetchOne(); 
							$ched=htmlentities(stripslashes($valuename->text));
						} 
						else {  $ched=""; }			  
						$data.="<tr><td>&emsp;Ans: <input type='text' value='".$ched."' class='mediumtext' name='answer_".$key."[]' id='answer_".$key."_".$key1."' />
						</td></tr>";
					}
					else if($type=='T'){
						if(in_array($sss['value_id'], $respvals)){ $ched="checked='checked'"; } else {  $ched=""; }
						$data.="<tr>
						<td>&emsp;<input type='radio' class='".$ched."  value='".$sss['value_id']."' name='answer_".$key."[]' value='' id='answer_".$key."_".$key1."'  style='float:left; margin-left: 13px;'/>
						<label style='font-size:13px; float:left;' for='truefalse'>".htmlentities(stripslashes($sss['text']))."</label> 
						</td>
						</tr>"; 
					}
					else if($type=='S'){ 
						if(in_array($sss['value_id'], $respvals)){ $ched="checked='checked'"; } 
						else {  $ched=""; }
						$data.="<tr>
							<td>&emsp;<input type='radio'". $ched."  value='".$sss['value_id']."' name='answer_".$key."[]' id='answer_".$key ."_".$key1."'  style='float:left; margin-left: 13px;'  />
							<label style='font-size:13px; float:left;' for='truefalse'>".htmlentities(stripslashes($sss['text']))."</label></td>
						</tr>";  
					}
					else if($type=='M'){
						if(in_array($sss['value_id'], $respvals)){ $ched='checked="checked"'; }
						else {  $ched=''; }			   
						$data.="<tr>
							<td> &emsp; <input type='checkbox' ".$ched." value='".$sss['value_id']."' name='answer_".$key."[]' id='answer_".$key ."_".$key1."'  /> <label style='font-size:13px; margin-top:-7px;' for='truefalse'>".htmlentities(stripslashes($sss['text']))."</label></td>
						</tr> " ;
					}
					else if($type=='FT'){
						
						if(in_array($sss['value_id'],$respvals)){	
							
							$valuename=Doctrine_Query::Create()->from("UlsUtestResponsesAssessment")->where("response_value_id=".$sss['value_id']." and employee_id=".$emp_id." and test_type='".$testdetails['test_type']."' and event_id=".$testdetails['event_id']." and assessment_id=".$testdetails['assessment_id'])->fetchOne();
							$ched=htmlentities(stripslashes($valuename->text));
						}
						else {  $ched=""; }
						$data.="<tr><td>&emsp;<textarea style='resize:none;' name='answer_".$key."[]' class='largetext' id='answer_".$key."_". $key1 ."'> ". $ched."</textarea> </td></tr> "; 
					}
				}
				$data.="<tr><td><hr></td></tr>";
			}          
		} 
		else { $data.="<tr><td>No Data Available.</td></tr>"; }  $data.="</table></div>
			<div class='hr-line-dashed'></div>
			<form action='' method='post' class='form-horizontal' id='interview_form' name='interview_form'>
				<input type='hidden' name='ass_rating_id'  id='ass_rating_id' value='".$ass_rating_id."'>
				<input type='hidden' name='attempt_id'  id='attempt_id' value='".$testdetails['attempt_id']."'>
				<input type='hidden' name='employee_id'  id='employee_id' value='".$testdetails['employee_id']."'>
				<input type='hidden' name='assessment_type'  id='assessment_type' value='".$testdetails['test_type']."'>
				<input type='hidden' name='assessment_id' value='".$testdetails['assessment_id']."' >
				<input type='hidden' name='assessor_id' value='".$_SESSION['asr_id']."' >";
				$ass_details=UlsAssessmentDefinition::viewassessment($testdetails['assessment_id']);
				$rating=UlsRatingMasterScale::ratingscale($ass_details['rating_id']);
				$data.="<div class='form-group'>
					<label class='col-sm-3 control-label'>Rating<sup><font color='#FF0000'>*</font></sup>:</label>
					<div class='col-sm-6'>
						<select class='validate[required] form-control' name='scale_id' id='scale_id'>
							<option>Select</option>";
							foreach($rating as $ratings){
								$rat_sel=!empty($ass_rating['scale_id'])?($ass_rating['scale_id']==$ratings['scale_id']?'selected="selected"':''):'';
								$data.="<option value='".$ratings['scale_id']."' ".$rat_sel.">".$ratings['rating_name_scale']."</option>";
							}
						$data.="</select>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-3 control-label'>Comments</label>";
					$comments=!empty($ass_rating['comments'])?$ass_rating['comments']:'';
					$data.="<div class='col-sm-9'><textarea placeholder='placeholder' class='form-control' type='text' name='comments' id='comments'>".$comments."</textarea></div>
				</div>
				<div class='hr-line-dashed'></div>
				<div class='table-responsive'>
					<table cellpadding='1' cellspacing='1' class='table table-bordered table-striped'>
						<thead>
						<tr>
							<th>Competency Name</th>
							<th>Required Level</th>
							<th>Assessed Level</th>
						</tr>
						</thead>
						<tbody>";
						if(count($testdetail_comp)>0){
							foreach($testdetail_comp as $keys=>$testdetail){
								$scale=UlsLevelMasterScale::levelscale($testdetail['assessment_pos_level_id']);
								$data.="<tr>
									<td>
									<input type='hidden' name='position_id' value='".$testdetail['position_id']."'>
									<input type='hidden' name='report_id[]' value='".$testdetail['report_id']."'>
									<input type='hidden' name='competency[]' id='competency[]' value='".$testdetail['comp_def_id']."'>
									".$testdetail['comp_def_name']."</td>
									<td>
									<input type='hidden' name='requiredlevel_".$testdetail['comp_def_id']."' value='".$testdetail['scale_id']."' >
									".$testdetail['scale_name']."</td>
									<td>
										<select name='".$testdetails['test_type']."_".$testdetail['comp_def_id']."' id='".$testdetails['test_type']."_".$testdetail['comp_def_id']."' class='form-control m-b validate[required]' style='width:120px;'>
											<option value=''>Select</option>";
											foreach($scale as $scales){			
												$scale_s=!empty($testdetail['assessed_scale_id'])?$testdetail['assessed_scale_id']==$scales['scale_id']?"selected='selected'":"":"";
												$data.="<option value='".$scales['scale_id']."' ".$scale_s.">".$scales['scale_name']."</option>";
											}
											$data.="</select>
									</td>
								</tr>";
							}
						}
						$data.="</tbody>
					</table>
				</div>
				<div class='hr-line-dashed'></div>
				<div class='form-group'>
					<div class='col-sm-8 col-sm-offset-4'>
						<button class='btn btn-default' data-dismiss='modal' type='button'>Cancel</button>
						<button class='btn btn-primary' type='button' name='submit' id='interview_submit'>Submit</button>
					</div>
				</div>
			</form>
		";
		echo $data;
		
	} */
	
	/* public function interview_test_view(){	   
		$assess_test_id=$_REQUEST['assess_test_id'];
        $position_id=$_REQUEST['position_id'];
		$emp_id=$_REQUEST['emp_id'];
		$testdetails=UlsAssessmentTest::test_details($assess_test_id);
		$assdetails=UlsAssessmentDefinition::viewassessment($testdetails['assessment_id']);
		$ass_rating=UlsAssessmentAssessorRating::get_ass_rating_interview($testdetails['assessment_id'],$testdetails['position_id'],$emp_id,$testdetails['assessment_type']);
		$ass_rating_id=!empty($ass_rating['ass_rating_id'])?$ass_rating['ass_rating_id']:"";
		$data="";
		$data.="
		<form action='' method='post' class='form-horizontal' id='interview_form_".$testdetails['rating_id']."' name='interview_form'>
				<input type='hidden' name='ass_rating_id'  id='ass_rating_id' value='".$ass_rating_id."'>
				<input type='hidden' name='employee_id'  id='employee_id' value='".$emp_id."'>
				<input type='hidden' name='assessment_type'  id='assessment_type' value='".$testdetails['assessment_type']."'>
				<input type='hidden' name='assessment_id' value='".$testdetails['assessment_id']."' >
				<input type='hidden' name='position_id' value='".$testdetails['position_id']."' >
				<input type='hidden' name='assessor_id' value='".$_SESSION['asr_id']."' >";
				$data.="<div class=''>
					<div class='table-responsive'>
					<table cellpadding='1' cellspacing='1' class='table table-bordered table-striped'>
						<thead>
						<tr>
							<th>Competency Name</th>
							<th>Required Level</th>
							<th>Assessed Level<sup><font color='#FF0000'>*</font></sup></th>
							<!--<th>Comments<sup><font color='#FF0000'>*</font></sup></th>-->
							<th></th>
						</tr>
						</thead>
						<tbody>";
						if($assdetails['ass_emp_comp']=='Y'){
							$emp_comp_map=UlsAssessmentEmployees::get_assessment_employees_comp($emp_id,$testdetails['assessment_id'],$position_id);
							$compquestions=UlsAssessmentTestQuestions::get_interview_empcomp_questions($testdetails['position_id'],$testdetails['assessment_type'],$emp_id,$testdetails['assessment_id'],$emp_comp_map['comp_ids']);
						}
						else{
							$compquestions=UlsAssessmentTestQuestions::get_interview_questions($testdetails['position_id'],$testdetails['assessment_type'],$emp_id,$testdetails['assessment_id']);
						}
						
						if(count($compquestions)>0){
							foreach($compquestions as $keys=>$comp_question){
								$scale=UlsLevelMasterScale::levelscale($comp_question['assessment_pos_level_id']);
								
								$data.="<tr>
									<td><input type='hidden' name='position_id' value='".$comp_question['position_id']."'>
									<input type='hidden' name='report_id[]' value='".$comp_question['report_id']."'>
									<input type='hidden' name='competency[]' id='competency[]' value='".$comp_question['comp_def_id']."'>
									".$comp_question['comp_def_name']."</td>
									<td>
									<input type='hidden' name='requiredlevel_".$comp_question['comp_def_id']."' value='".$comp_question['scale_id']."' >
									
									".$comp_question['scale_name']."</td>
									<td>
										<select name='".$testdetails['assessment_type']."_".$comp_question['comp_def_id']."' id='".$testdetails['assessment_type']."_".$comp_question['comp_def_id']."' class='validate[required] form-control m-b' style='width:400px;' data-prompt-position='topLeft'>
											<option value='N/A'>Select</option>";
											foreach($scale as $scales){			
												$scale_s=!empty($comp_question['assessed_scale_id'])?$comp_question['assessed_scale_id']==$scales['scale_id']?"selected='selected'":"":"";
												$data.="<option value='".$scales['scale_id']."' ".$scale_s.">".$scales['scale_name']."</option>";
											}
											$data.="</select>
									</td>
									<!--<td><textarea name='".$testdetails['assessment_type']."_comments_".$comp_question['comp_def_id']."' id='".$testdetails['assessment_type']."_".$comp_question['comp_def_id']."'  rows='3' cols='60' class='validate[required]' data-prompt-position='topLeft'>".(!empty($comp_question['development_area'])?$comp_question['development_area']:"")."</textarea></td>-->
									<td>";
									$total_comp_int=UlsCompetencyDefLevelInterview::getcompdeflevelint_details_count($comp_question['comp_def_id'],$comp_question['scale_id']);
									$total_int_q=$total_comp_int['total_count'];
									$knowledge_con=UlsAssessmentReportBytypeInterview::get_interview_check_condition($testdetails['assessment_id'],$position_id,$emp_id,$_SESSION['asr_id'],$comp_question['comp_def_id'],$comp_question['scale_id'],$comp_question['report_id'],'KC');
									$application_con=UlsAssessmentReportBytypeInterview::get_interview_check_condition($testdetails['assessment_id'],$position_id,$emp_id,$_SESSION['asr_id'],$comp_question['comp_def_id'],$comp_question['scale_id'],$comp_question['report_id'],'AQ');
										$data.="
										<input type='hidden' id='int_random_".$comp_question['comp_def_id']."_".$comp_question['scale_id']."' value='0'>
										<div class='button-list'>";
										if(isset($knowledge_con) && $knowledge_con>0){
											$data.="<a class='btn btn-primary  btn-xs'>Completed</a>";
										}
										else{
											$data.="<a class='btn btn-primary  btn-xs' data-bs-toggle='modal' onclick='open_secound_model(".$comp_question['comp_def_id'].",".$comp_question['scale_id'].",".$emp_id.",1,".$comp_question['report_id'].",".$assess_test_id.",".$total_int_q.",".$position_id.",".$testdetails['rating_id'].");'>Knowledge Based - Generate</a>";
										}
										
										if(isset($application_con) && $application_con>0){
											$data.="<a class='btn btn-primary  btn-xs'>Completed</a>";
										}
										else{	
											$data.="<a class='btn btn-primary  btn-xs' data-bs-toggle='modal' onclick='open_secound_model(".$comp_question['comp_def_id'].",".$comp_question['scale_id'].",".$emp_id.",2,".$comp_question['report_id'].",".$assess_test_id.",".$total_int_q.",".$position_id.",".$testdetails['rating_id'].");'>Application Based - Generate</a>";
										}
										$data.="</div>
										
									</td>
								</tr>
								
								";
							}
						}
						$data.="</tbody>
					</table>
				</div>";
				
				$rating=UlsRatingMasterScale::ratingscale($testdetails['rating_id']);
				$data.="
				<div class='hr-line-dashed'></div>
				<p class='text-muted'><code>Overall Rating</code></p>
				<br>
				<div class='hr-line-dashed'></div>
				<div class='form-group'>
					<label class='col-sm-1 control-label'>Rating<sup><font color='#FF0000'>*</font></sup>:</label>
					<div class='col-sm-6'>
						<select class='validate[required] form-control' name='scale_id' id='scale_id'>
							<option value=''>Select</option>";
							foreach($rating as $ratings){
								$rat_sel=!empty($ass_rating['scale_id'])?($ass_rating['scale_id']==$ratings['scale_id']?'selected="selected"':''):'';
								$data.="<option value='".$ratings['scale_id']."' ".$rat_sel.">".$ratings['rating_name_scale']."</option>";
							}
						$data.="</select>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-1 control-label'>Comments:</label>";
					$comments=!empty($ass_rating['comments'])?$ass_rating['comments']:'';
					$data.="<div class='col-sm-9'><textarea placeholder='placeholder' class='form-control' type='text' name='comments' id='comments'>".$comments."</textarea></div>
				</div>";
				//$ass_rating_dis=!empty($ass_rating['ass_rating_id'])?'disabled':""".$ass_rating_dis.">;
				$data.="<div class='hr-line-dashed'></div>
				<div class='form-group'>
					<div class='col-sm-8 col-sm-offset-4'>
						<button class='btn btn-default' data-dismiss='modal' type='button'>Cancel</button>
						<button class='btn btn-primary' type='button' name='submit' id='interview_submit_".$testdetails['rating_id']."'> Submit</button>
					</div>
				</div>
			</div>
			</form>
		";
		if(count($compquestions)>0){
			foreach($compquestions as $keys=>$comp_question){
				$array=[1,2];
				foreach($array as $s){
				$data.="<div id='interview_questions".$comp_question['comp_def_id']."_".$comp_question['scale_id']."_".$emp_id."_".$s."'  class='modal fade'  tabindex='-1' role='dialog' aria-hidden='true' data-backdrop='static' data-keyboard='false' >
					<div class='modal-dialog modal-dialog-scrollable  modal-lg'>
						<div class='modal-content'>
							<div class='color-line'></div>
							<div class='modal-header'>
								<h4 class='modal-title'>Interview Questions</h4>
								<button type='button' class='close'
								
								aria-hidden='true' id='close_int".$comp_question['comp_def_id']."_".$comp_question['scale_id']."_".$emp_id."_".$s."' onclick='close_mode(".$comp_question['comp_def_id'].",".$comp_question['scale_id'].",".$emp_id.",".$s.")'>X</button>
								
							</div>
							<div class='modal-body'>
								<div id='interview_question_detail".$comp_question['comp_def_id']."_".$comp_question['scale_id']."_".$emp_id."_".$s."' class='modal-body no-padding'>
								
								</div>
							</div>
							
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div>";
				}
				
			}
		}
		echo $data;
		
	} */
	
	public function interview_test_view(){	   
		$assess_test_id=$_REQUEST['assess_test_id'];
        $position_id=$_REQUEST['position_id'];
		$emp_id=$_REQUEST['emp_id'];
		$testdetails=UlsAssessmentTest::test_details($assess_test_id);
		$ass_rating=UlsAssessmentAssessorRating::get_ass_rating_interview($testdetails['assessment_id'],$testdetails['position_id'],$emp_id,$testdetails['assessment_type']);
		$ass_rating_id=!empty($ass_rating['ass_rating_id'])?$ass_rating['ass_rating_id']:"";
		$data="";
		$data.="
		<form action='' method='post' class='form-horizontal' id='interview_form_".$testdetails['rating_id']."' name='interview_form'>
				<input type='hidden' name='ass_rating_id'  id='ass_rating_id' value='".$ass_rating_id."'>
				<input type='hidden' name='employee_id'  id='employee_id' value='".$emp_id."'>
				<input type='hidden' name='assessment_type'  id='assessment_type' value='".$testdetails['assessment_type']."'>
				<input type='hidden' name='assessment_id' value='".$testdetails['assessment_id']."' >
				<input type='hidden' name='position_id' value='".$testdetails['position_id']."' >
				<input type='hidden' name='assessor_id' value='".$_SESSION['asr_id']."' >";
				$data.="<div class=''>
					<div class='table-responsive'>
					<table cellpadding='1' cellspacing='1' class='table table-bordered table-striped' width='100%'>
						<thead>
						<tr>
							<th>Competency Name</th>
							<th>Required Level</th>
							<th>Assessed Level<sup><font color='#FF0000'>*</font></sup></th>
							<th>Assessed Correction Level<sup><font color='#FF0000'>*</font></sup></th>
							<th>Comments<sup><font color='#FF0000'>*</font></sup></th>
						</tr>
						</thead>
						<tbody>";
						$compquestions=UlsAssessmentTestQuestions::get_interview_questions($testdetails['position_id'],$testdetails['assessment_type'],$emp_id,$testdetails['assessment_id']);
						if(count($compquestions)>0){
							foreach($compquestions as $keys=>$comp_question){
								$scale=UlsLevelMasterScale::levelscale($comp_question['assessment_pos_level_id']);
								
								$data.="<tr>
									<td><input type='hidden' name='position_id' value='".$comp_question['position_id']."'>
									<input type='hidden' name='report_id[]' value='".$comp_question['report_id']."'>
									<input type='hidden' name='competency[]' id='competency[]' value='".$comp_question['comp_def_id']."'>
									".$comp_question['comp_def_name']."</td>
									<td>
									<input type='hidden' name='requiredlevel_".$comp_question['comp_def_id']."' value='".$comp_question['scale_id']."' >
									".$comp_question['scale_name']."</td>
									<td>
										<select name='".$testdetails['assessment_type']."_".$comp_question['comp_def_id']."' id='".$testdetails['assessment_type']."_".$comp_question['comp_def_id']."' class='validate[required] form-control m-b' style='width:400px;' data-prompt-position='topLeft'>
											<option value=''>Select</option>";
											foreach($scale as $scales){			
												$scale_s=!empty($comp_question['assessed_scale_id'])?$comp_question['assessed_scale_id']==$scales['scale_id']?"selected='selected'":"":"";
												$data.="<option value='".$scales['scale_id']."' ".$scale_s.">".$scales['scale_name']."</option>";
											}
											$data.="</select>
									</td>
									<td>
										<select name='".$testdetails['assessment_type']."_ass_value_".$comp_question['comp_def_id']."' id='".$testdetails['assessment_type']."_".$comp_question['comp_def_id']."' class='validate[required] form-control m-b' style='width:100px;' data-prompt-position='topLeft'>
											<option value=''>Select</option>";
											for ($i = 1; $i <= count($scale); $i += 0.25) {
												$scale_s=!empty($comp_question['interview_ass_value'])?$comp_question['interview_ass_value']==$i?"selected='selected'":"":"";
												$data.="<option value='".$i."' ".$scale_s.">".$i."</option>";
											}
											$data.="</select>
									</td>
									<td><textarea name='".$testdetails['assessment_type']."_comments_".$comp_question['comp_def_id']."' id='".$testdetails['assessment_type']."_".$comp_question['comp_def_id']."'  rows='3' cols='60' class='validate[required]' data-prompt-position='topLeft'>".(!empty($comp_question['development_area'])?$comp_question['development_area']:"")."</textarea></td>
								</tr>";
							}
						}
						$data.="</tbody>
					</table>
				</div>";
				$rating=UlsRatingMasterScale::ratingscale($testdetails['rating_id']);
				$data.="<div class='form-group'>
					<label class='col-sm-3 control-label'>Rating<sup><font color='#FF0000'>*</font></sup>:</label>
					<div class='col-sm-6'>
						<select class='validate[required] form-control' name='scale_id' id='scale_id'>
							<option value=''>Select</option>";
							foreach($rating as $ratings){
								$rat_sel=!empty($ass_rating['scale_id'])?($ass_rating['scale_id']==$ratings['scale_id']?'selected="selected"':''):'';
								$data.="<option value='".$ratings['scale_id']."' ".$rat_sel.">".$ratings['rating_name_scale']."</option>";
							}
						$data.="</select>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-3 control-label'>Comments<sup><font color='#FF0000'>*</font></sup>:</label>";
					$comments=!empty($ass_rating['comments'])?$ass_rating['comments']:'';
					$data.="<div class='col-sm-9'><textarea placeholder='placeholder' class='validate[required] form-control' type='text' name='comments' id='comments'>".$comments."</textarea></div>
				</div>";
				//$ass_rating_dis=!empty($ass_rating['ass_rating_id'])?'disabled':""".$ass_rating_dis.">;
				$data.="<div class='hr-line-dashed'></div>
				<div class='form-group'>
					<div class='col-sm-8 col-sm-offset-4'>
						<button class='btn btn-default' data-dismiss='modal' type='button'>Cancel</button>
						<button class='btn btn-primary' type='button' name='submit' id='interview_submit_".$testdetails['rating_id']."'> Submit</button>
					</div>
				</div>
			</form>
		";
		echo $data;
		
	}
	
	public function interview_comp_test_view(){
		$data="";
		$assess_test_id=$_REQUEST['assess_test_id'];
        $position_id=$_REQUEST['position_id'];
		$emp_id=$_REQUEST['emp_id'];
		$testdetails=UlsAssessmentTest::test_details($assess_test_id);
		$assessment_id=$testdetails['assessment_id'];
		$assdetails=UlsAssessmentDefinition::viewassessment($testdetails['assessment_id']);
		$emp_comp_ids=UlsAssessmentEmployees::get_assessment_employees_comp($emp_id,$assessment_id,$position_id);
		$emp_pre_ass_id=UlsAssessmentEmployees::get_assessment_employees_prereport($emp_id,$assessment_id,$position_id);
		$ass_rating=UlsAssessmentAssessorRating::get_ass_rating_interview($testdetails['assessment_id'],$testdetails['position_id'],$emp_id,'TEST');
		if(!empty($ass_rating['ass_rating_id'])){
		$inbasket_details="SELECT c.`inbasket_id`,c.`inbasket_name`,c.`inbasket_narration`,d.question_bank_id,f.value_id,f.`comp_def_id`,f.`scale_id`,f.inbasket_mode,f.text,g.comp_def_name,l.scale_name FROM `uls_assessment_test` a
		left join(SELECT `assess_test_id`,`position_id`,`assessment_id`,`inbasket_id` FROM `uls_assessment_test_inbasket` ) b on b.assess_test_id=a.assess_test_id and b.assessment_id=a.assessment_id and b.position_id=a.position_id
		left join(SELECT `inbasket_id`,`inbasket_name`,`position_id`,`inbasket_narration` FROM `uls_inbasket_master`) c on c.inbasket_id=b.inbasket_id and c.position_id=b.position_id
		left join(SELECT question_bank_id,`inbasket_id` FROM `uls_questionbank`) d on d.inbasket_id=c.inbasket_id
		left join(SELECT `question_id`,`question_bank_id`,`question_name` FROM `uls_questions`) e on e.question_bank_id=d.question_bank_id
		left join(SELECT `value_id`,`question_id`,`comp_def_id`,`scale_id`,inbasket_mode,text FROM `uls_question_values`) f on f.question_id=e.question_id
		LEFT JOIN (SELECT comp_def_id, comp_def_name,comp_def_name_alt FROM uls_competency_definition GROUP BY comp_def_id)g ON g.comp_def_id = f.comp_def_id
		LEFT JOIN(SELECT `scale_id`,`scale_number`,`level_id`,`scale_name` FROM `uls_level_master_scale`)l on l.scale_id=f.scale_id
		WHERE a.`assessment_id`=".$emp_pre_ass_id['assessment_id']." and a.`position_id`=".$position_id." and a.`assessment_type`='INBASKET' and f.comp_def_id in (".$emp_comp_ids['comp_ids'].")";
		$inbasketdetails=UlsMenu::callpdo($inbasket_details);
		$data.="<div  class='tab-struct custom-tab-1'>
			<ul role='tablist' class='nav nav-tabs' id='myTabs_7'>
				<li class='active main'  id='tabhome_7' role='presentation'><a aria-expanded='true'  data-toggle='tab' role='tab' id='home_tab_7' href='#home_7' style='font-size:14px'>Inbasket Questions</a></li>
				<li role='presentation' class='main' id='tabprofile_7'><a  data-toggle='tab' id='profile_tab_7' role='tab' href='#profile_7' aria-expanded='false' style='font-size:14px'>Casestudy Questions</a></li>
				<li role='presentation' class='main'  id='tabopen_7'><a  data-toggle='tab' id='open_tab_7' role='tab' href='#open_7' aria-expanded='false'  style='font-size:14px'>Open-ended Questions</a></li>
				<li role='presentation' class='main'  id='tabover_7'><a  data-toggle='tab' id='open_tab_7' role='tab' href='#over_7' aria-expanded='false'  style='font-size:14px'>Overall Rating</a></li>
			</ul>
			<div class='tab-content' id='myTabContent_7'>
				<div  id='home_7' class='tab-pane fade active in main' role='tabpanel'>
					<h6 class='mb-15'>Inbasket Questions</h6>";
					$ass_rating=UlsAssessmentAssessorRating::get_ass_rating_interview($testdetails['assessment_id'],$testdetails['position_id'],$emp_id,'INBASKET');
					$ass_rating_id=!empty($ass_rating['ass_rating_id'])?$ass_rating['ass_rating_id']:"";
					$tmp="";
					foreach($inbasketdetails as $questionviews){
						if($tmp!=$questionviews['inbasket_id']){
							
							$data.="<p>".$questionviews['inbasket_narration']."</p>";
							$tmp=$questionviews['inbasket_id'];
						}
					}
					$data.="<h6>Intrays</h6>
					<ul class='column'>";
						foreach($inbasketdetails as $key=>$question_views){
							if(!empty($question_views['inbasket_mode'])){
							$parsed_json = json_decode($question_views['inbasket_mode'], true);
							}
						
						$data.="<li class='ui-state-default' id='intraydelete_".$question_views['value_id']."'>
							<div class='portlet'>
								<div class='portlet-header' style='padding: 0.2em 0.3em;margin-bottom: 0.5em;position: relative;border: 1px solid #dddddd;background: #e9e9e9;color: #333333;font-weight: bold;'>
									<span class='ui-icon ui-icon-arrowthick-2-n-s'></span> Intray ".($key+1)."</div>
								<div class='portlet-content'>
								<p class='text-muted' style='font-weight:bold; float:right;'><b>".$question_views['comp_def_name']." (<code>".$question_views['scale_name']."</code>)</b></p>
								";
								if(!empty($parsed_json)){
									foreach($parsed_json as $key => $value)
									{
										$yes_stat="IN_MODE";
										$val_code=UlsAdminMaster::get_value_name_statuss($yes_stat,$value['mode']);
									   $data.="<p><code>Mode:</code>".$val_code['name']."</p>
									   <p><code>Time:</code>".$value['period']."</p>
									   <p><code>From:</code>".$value['from']."</p>";
									}
								}
								$data.="<p class='text-muted'>".(trim($question_views['text']))."</p></div>
							</div>
						</li>";
						}
						
					$data.="</ul>
					<form action='' method='post' class='form-horizontal' id='inbasket_interview_form_".$testdetails['rating_id']."' name='inbasket_interview_form'>
						
						<input type='hidden' name='employee_id'  id='employee_id' value='".$emp_id."'>
						<input type='hidden' name='assessment_type'  id='assessment_type' value='INBASKET'>
						<input type='hidden' name='assessment_id' value='".$testdetails['assessment_id']."' >
						<input type='hidden' name='position_id' value='".$testdetails['position_id']."' >
						<input type='hidden' name='assessor_id' value='".$_SESSION['asr_id']."' >";
						$rating=UlsRatingMasterScale::ratingscale($testdetails['rating_id']);
						$data.="
						<br>
						<div class='table-responsive'>
							<table cellpadding='1' cellspacing='1' class='table table-bordered table-striped'>
								<thead>
								<tr>
									<th>Competency Name</th>
									<th>Required Level</th>
									<th>Assessed Level</th>
									<th>Comments</th>
								</tr>
								</thead>
								<tbody>";
								$compinbasketquestions=UlsAssessmentTestQuestions::get_interview_empcomp_questions($testdetails['position_id'],'INBASKET',$emp_id,$testdetails['assessment_id'],$emp_comp_ids['comp_ids']);
								foreach($compinbasketquestions as $compinbasketquestion){
									$scale=UlsLevelMasterScale::levelscale($compinbasketquestion['assessment_pos_level_id']);
									$data.="<tr>
										<td><input type='hidden' name='position_id' value='".$compinbasketquestion['position_id']."'>
										<input type='hidden' name='report_id[]' value='".$compinbasketquestion['report_id']."'>
										<input type='hidden' name='competency[]' id='competency[]' value='".$compinbasketquestion['comp_def_id']."'>".$compinbasketquestion['comp_def_name']."</td>
										<td>
										<input type='hidden' name='requiredlevel_".$compinbasketquestion['comp_def_id']."' value='".$compinbasketquestion['scale_id']."' >".$compinbasketquestion['scale_name']."</td>
										<td>
										<select name='INBASKET_".$compinbasketquestion['comp_def_id']."' id='INBASKET_".$compinbasketquestion['comp_def_id']."' class='form-control m-b' style='width:400px;' data-prompt-position='topLeft'>
											<option value='N/A'>Select</option>";
											foreach($scale as $scales){			
												$scale_s=!empty($compinbasketquestion['assessed_scale_id'])?$compinbasketquestion['assessed_scale_id']==$scales['scale_id']?"selected='selected'":"":"";
												$data.="<option value='".$scales['scale_id']."' ".$scale_s.">".$scales['scale_name']."</option>";
											}
											$data.="</select>
									</td>
									<td><textarea name='INBASKET_comments_".$compinbasketquestion['comp_def_id']."' id='INBASKET_".$compinbasketquestion['comp_def_id']."'  rows='3' cols='60' class='' data-prompt-position='topLeft'>".(!empty($compinbasketquestion['development_area'])?$compinbasketquestion['development_area']:"")."</textarea></td>
									</tr>";
								}
								$data.="</tbody>
							</table>
						</div>
						<br>";
						$data.="<div class='hr-line-dashed'></div>
						<div class='form-group'>
							<div class='col-sm-8 col-sm-offset-4'>
								<button class='btn btn-default' data-dismiss='modal' type='button'>Cancel</button>
								<button class='btn btn-primary' type='button' name='submit' id='inbasket_interview_submit_".$testdetails['rating_id']."'> Submit</button>
							</div>
						</div>
					</form>
				</div>
				<div  id='profile_7' class='tab-pane fade main' role='tabpanel'>
					<h6 class='mb-15'>Casestudy Questions</h6>";
					$ass_rating=UlsAssessmentAssessorRating::get_ass_rating_interview($testdetails['assessment_id'],$testdetails['position_id'],$emp_id,'CASE_STUDY');
					$ass_rating_id=!empty($ass_rating['ass_rating_id'])?$ass_rating['ass_rating_id']:"";
					$comp_scale=UlsAssessmentCompetencies::get_assessment_competency_scale($assessment_id,$position_id,$emp_comp_ids['comp_ids']);
					foreach($comp_scale as $comp_scales){
						
						$case_details="SELECT b.casestudy_id,d.casestudy_quest,c.casestudy_description,e.comp_def_id,f.comp_def_name,l.scale_name FROM `uls_assessment_test` a
						left join(SELECT `assess_test_id`,`position_id`,`assessment_id`,`casestudy_id` FROM `uls_assessment_test_casestudy` ) b on b.assess_test_id=a.assess_test_id and b.assessment_id=a.assessment_id and b.position_id=a.position_id
						left join(SELECT `casestudy_id`,`casestudy_name`,`casestudy_description` FROM `uls_case_study_master`) c on c.casestudy_id=b.casestudy_id
						left join(SELECT `casestudy_quest_id`,`casestudy_id`,`casestudy_quest` FROM `uls_case_study_questions`) d on d.casestudy_id=c.casestudy_id
						left join(SELECT `case_map_id`,`casestudy_quest_id`,`casestudy_id`,`comp_def_id`,`scale_id` FROM `uls_case_study_comp_map`) e on e.casestudy_quest_id=d.casestudy_quest_id and e.casestudy_id=d.casestudy_id
						LEFT JOIN (SELECT comp_def_id, comp_def_name,comp_def_name_alt FROM uls_competency_definition GROUP BY comp_def_id)f ON f.comp_def_id = e.comp_def_id
						LEFT JOIN(SELECT `scale_id`,`scale_number`,`level_id`,`scale_name` FROM `uls_level_master_scale`)l on l.scale_id=e.scale_id
						WHERE a.`assessment_id`=".$emp_pre_ass_id['assessment_id']." and a.`position_id`=".$position_id." and a.`assessment_type`='CASE_STUDY' and e.comp_def_id=".$comp_scales['assessment_pos_com_id']." and e.scale_id=".$comp_scales['assessment_pos_level_scale_id']."";
						$casedetails=UlsMenu::callpdo($case_details);
						$cemp="";
						foreach($casedetails as $ke=>$casedetail){
							$s=$ke+1;
							if($cemp!=$casedetail['casestudy_id']){
								$data.="<p>".$casedetail['casestudy_description']."</p>
								<h6>Case Questions</h6>";
								$cemp=$casedetail['casestudy_id'];
							}
							$data.="
							<p class='text-muted' style='font-weight:bold;'>Competency:<b>".$casedetail['comp_def_name']." (<code>".$casedetail['scale_name']."</code>)</b></p>
							<p>".$s." )".$casedetail['casestudy_quest']."</p>
							
							<br>";
						}
					}
					
					$data.="<form action='' method='post' class='form-horizontal' id='casestudy_interview_form_".$testdetails['rating_id']."' name='casestudy_interview_form'>
						
						<input type='hidden' name='employee_id'  id='employee_id' value='".$emp_id."'>
						<input type='hidden' name='assessment_type'  id='assessment_type' value='CASE_STUDY'>
						<input type='hidden' name='assessment_id' value='".$testdetails['assessment_id']."' >
						<input type='hidden' name='position_id' value='".$testdetails['position_id']."' >
						<input type='hidden' name='assessor_id' value='".$_SESSION['asr_id']."' >";
						$rating=UlsRatingMasterScale::ratingscale($testdetails['rating_id']);
						$data.="
						<div class='table-responsive'>
							<table cellpadding='1' cellspacing='1' class='table table-bordered table-striped'>
								<thead>
								<tr>
									<th>Competency Name</th>
									<th>Required Level</th>
									<th>Assessed Level</th>
									<th>Comments</th>
								</tr>
								</thead>
								<tbody>";
						foreach($comp_scale as $comp_scales){
							$scale=UlsLevelMasterScale::levelscale($comp_scales['assessment_pos_level_id']);
							$case_details="SELECT b.casestudy_id,d.casestudy_quest,c.casestudy_description,e.comp_def_id,r.report_id,r.development_area,f.comp_def_name,s.scale_name,e.scale_id FROM `uls_assessment_test` a
							left join(SELECT `assess_test_id`,`position_id`,`assessment_id`,`casestudy_id` FROM `uls_assessment_test_casestudy` ) b on b.assess_test_id=a.assess_test_id and b.assessment_id=a.assessment_id and b.position_id=a.position_id
							left join(SELECT `casestudy_id`,`casestudy_name`,`casestudy_description` FROM `uls_case_study_master`) c on c.casestudy_id=b.casestudy_id
							left join(SELECT `casestudy_quest_id`,`casestudy_id`,`casestudy_quest` FROM `uls_case_study_questions`) d on d.casestudy_id=c.casestudy_id
							left join(SELECT `case_map_id`,`casestudy_quest_id`,`casestudy_id`,`comp_def_id`,`scale_id` FROM `uls_case_study_comp_map`) e on e.casestudy_quest_id=d.casestudy_quest_id and e.casestudy_id=d.casestudy_id
							left join(SELECT `comp_def_id`,`comp_def_name`,comp_def_category FROM `uls_competency_definition`) f on f.comp_def_id=e.comp_def_id
							left join (SELECT `scale_id`,`scale_name`,scale_number FROM `uls_level_master_scale`) s on s.scale_id=e.scale_id
							left join (select report_id,assessment_id,position_id,competency_id,assessed_scale_id,development_area,employee_id,assessor_id from uls_assessment_report where employee_id=$emp_id and assessment_id=".$testdetails['assessment_id']." and assessor_id=".$_SESSION['asr_id'].")r on r.position_id=a.position_id and r.competency_id=e.comp_def_id 
							left join (select report_id,assessed_scale_id,assessment_type from uls_assessment_report_bytype where assessment_type='CASE_STUDY' and assessment_id=".$testdetails['assessment_id'].")rs on rs.report_id=r.report_id
							WHERE a.`assessment_id`=".$emp_pre_ass_id['assessment_id']." and a.`position_id`=".$position_id." and a.`assessment_type`='CASE_STUDY' and e.comp_def_id=".$comp_scales['assessment_pos_com_id']." and e.scale_id=".$comp_scales['assessment_pos_level_scale_id']." group by e.comp_def_id,e.scale_id";
							$casedetails=UlsMenu::callpdo($case_details);
							$cemp="";
							foreach($casedetails as $ke=>$casedetail){
								$data.="<tr>
									<td><input type='hidden' name='position_id' value='".$testdetails['position_id']."'>
									<input type='hidden' name='report_id[]' value='".$casedetail['report_id']."'>
									<input type='hidden' name='competency[]' id='competency[]' value='".$casedetail['comp_def_id']."'>
									".$casedetail['comp_def_name']."</td>
									<td>
									<input type='hidden' name='requiredlevel_".$casedetail['comp_def_id']."' value='".$casedetail['scale_id']."' >
									
									".$casedetail['scale_name']."</td>
									<td>
										<select name='CASE_STUDY_".$casedetail['comp_def_id']."' id='CASE_STUDY_".$casedetail['comp_def_id']."' class='validate[required] form-control m-b' style='width:400px;' data-prompt-position='topLeft'>
											<option value='N/A'>Select</option>";
											foreach($scale as $scales){			
												$scale_s=!empty($casedetail['assessed_scale_id'])?$casedetail['assessed_scale_id']==$scales['scale_id']?"selected='selected'":"":"";
												$data.="<option value='".$scales['scale_id']."' ".$scale_s.">".$scales['scale_name']."</option>";
											}
											$data.="</select>
									</td>
									<td><textarea name='CASE_STUDY_comments_".$casedetail['comp_def_id']."' id='CASE_STUDY_".$casedetail['comp_def_id']."'  rows='3' cols='60' class='data-prompt-position='topLeft'>".(!empty($casedetail['development_area'])?$casedetail['development_area']:"")."</textarea></td>
								</tr>";
							}
						}
								$data.="</tbody>
							</table>
						</div>
						<div class='hr-line-dashed'></div>
						<div class='form-group'>
							<div class='col-sm-8 col-sm-offset-4'>
								<button class='btn btn-default' data-dismiss='modal' type='button'>Cancel</button>
								<button class='btn btn-primary' type='button' name='submit' id='casestudy_interview_submit_".$testdetails['rating_id']."'> Submit</button>
							</div>
						</div>
					</form>";
				$data.="</div>
				<div  id='open_7' class='tab-pane fade main' role='tabpanel'>
					<h6 class='mb-15'>Open-ended Questions</h6>
					<p><code>Please rate the candidate on all the gap areas</code></p>";
					$ass_rating=UlsAssessmentAssessorRating::get_ass_rating_interview($assessment_id,$position_id,$emp_id,$testdetails['assessment_type']);
					$ass_rating_id=!empty($ass_rating['ass_rating_id'])?$ass_rating['ass_rating_id']:"";
					$data.="<form action='' method='post' class='form-horizontal' id='interview_form_".$testdetails['rating_id']."' name='interview_form'>
						<input type='hidden' name='ass_rating_id'  id='ass_rating_id' value='".$ass_rating_id."'>
						<input type='hidden' name='employee_id'  id='employee_id' value='".$emp_id."'>
						<input type='hidden' name='assessment_type'  id='assessment_type' value='".$testdetails['assessment_type']."'>
						<input type='hidden' name='assessment_id' value='".$testdetails['assessment_id']."' >
						<input type='hidden' name='position_id' value='".$testdetails['position_id']."' >
						<input type='hidden' name='assessor_id' value='".$_SESSION['asr_id']."' >";
						$data.="<div class=''>
							<div class='table-responsive'>
							<table cellpadding='1' cellspacing='1' class='table table-bordered table-striped'>
								<thead>
								<tr>
									<th>Competency Name</th>
									<th>Required Level</th>
									<th>Assessed Level<sup><font color='#FF0000'>*</font></sup></th>
									<!--<th>Comments<sup><font color='#FF0000'>*</font></sup></th>-->
									<th></th>
								</tr>
								</thead>
								<tbody>";
								if($assdetails['ass_emp_comp']=='Y'){
									
									$emp_comp_map=UlsAssessmentEmployees::get_assessment_employees_comp($emp_id,$testdetails['assessment_id'],$position_id);
									$compquestions=UlsAssessmentTestQuestions::get_interview_empcomp_questions($testdetails['position_id'],$testdetails['assessment_type'],$emp_id,$testdetails['assessment_id'],$emp_comp_map['comp_ids']);
								}
								else{
									$compquestions=UlsAssessmentTestQuestions::get_interview_questions($testdetails['position_id'],$testdetails['assessment_type'],$emp_id,$testdetails['assessment_id']);
								}
								
								if(count($compquestions)>0){
									foreach($compquestions as $keys=>$comp_question){
										$scale=UlsLevelMasterScale::levelscale($comp_question['assessment_pos_level_id']);
										if(!empty($comp_question['report_id'])){
										$data.="<tr>
											<td><input type='hidden' name='position_id' value='".$comp_question['position_id']."'>
											<input type='hidden' name='report_id[]' value='".$comp_question['report_id']."'>
											<input type='hidden' name='competency[]' id='competency[]' value='".$comp_question['comp_def_id']."'>
											".$comp_question['comp_def_name']."</td>
											<td>
											<input type='hidden' name='requiredlevel_".$comp_question['comp_def_id']."' value='".$comp_question['scale_id']."' >
											
											".$comp_question['scale_name']."</td>
											<td>
												<select name='".$testdetails['assessment_type']."_".$comp_question['comp_def_id']."' id='".$testdetails['assessment_type']."_".$comp_question['comp_def_id']."' class='validate[required] form-control m-b' style='width:400px;' data-prompt-position='topLeft'>
													<option value=''>Select</option>";
													foreach($scale as $scales){			
														$scale_s=!empty($comp_question['assessed_scale_id'])?$comp_question['assessed_scale_id']==$scales['scale_id']?"selected='selected'":"":"";
														$data.="<option value='".$scales['scale_id']."' ".$scale_s.">".$scales['scale_name']."</option>";
													}
													$data.="</select>
											</td>
											<!--<td><textarea name='".$testdetails['assessment_type']."_comments_".$comp_question['comp_def_id']."' id='".$testdetails['assessment_type']."_".$comp_question['comp_def_id']."'  rows='3' cols='60' class='validate[required]' data-prompt-position='topLeft'>".(!empty($comp_question['development_area'])?$comp_question['development_area']:"")."</textarea></td>-->
											<td>";
											$total_comp_int=UlsCompetencyDefLevelInterview::getcompdeflevelint_details_count($comp_question['comp_def_id'],$comp_question['scale_id']);
											$total_int_q=$total_comp_int['total_count'];
											$knowledge_con=UlsAssessmentReportBytypeInterview::get_interview_check_condition($testdetails['assessment_id'],$position_id,$emp_id,$_SESSION['asr_id'],$comp_question['comp_def_id'],$comp_question['scale_id'],$comp_question['report_id'],'KC');
											$application_con=UlsAssessmentReportBytypeInterview::get_interview_check_condition($testdetails['assessment_id'],$position_id,$emp_id,$_SESSION['asr_id'],$comp_question['comp_def_id'],$comp_question['scale_id'],$comp_question['report_id'],'AQ');
												$data.="
												<input type='hidden' id='int_random_".$comp_question['comp_def_id']."_".$comp_question['scale_id']."' value='0'>
												<div class='button-list'>";
												if(isset($knowledge_con) && $knowledge_con>0){
													$data.="<a class='btn btn-primary  btn-xs'>Completed</a>";
												}
												else{
													$data.="<a class='btn btn-primary  btn-xs' data-bs-toggle='modal' onclick='open_secound_model(".$comp_question['comp_def_id'].",".$comp_question['scale_id'].",".$emp_id.",1,".$comp_question['report_id'].",".$assess_test_id.",".$total_int_q.",".$position_id.",".$testdetails['rating_id'].");'>Knowledge Based - Generate</a>";
												}
												
												if(isset($application_con) && $application_con>0){
													$data.="<a class='btn btn-primary  btn-xs'>Completed</a>";
												}
												else{	
													$data.="<a class='btn btn-primary  btn-xs' data-bs-toggle='modal' onclick='open_secound_model(".$comp_question['comp_def_id'].",".$comp_question['scale_id'].",".$emp_id.",2,".$comp_question['report_id'].",".$assess_test_id.",".$total_int_q.",".$position_id.",".$testdetails['rating_id'].");'>Application Based - Generate</a>";
												}
												$data.="</div>
												
											</td>
										</tr>
										
										";
										}
									}
								}
								$data.="</tbody>
							</table>
						</div>";
						
						//$ass_rating_dis=!empty($ass_rating['ass_rating_id'])?'disabled':""".$ass_rating_dis.">;
						$data.="<div class='hr-line-dashed'></div>
						<div class='form-group'>
							<div class='col-sm-8 col-sm-offset-4'>
								<button class='btn btn-default' data-dismiss='modal' type='button'>Cancel</button>
								<button class='btn btn-primary' type='button' name='submit' id='interview_submit_".$testdetails['rating_id']."'> Submit</button>
							</div>
						</div>
					</div>
					</form>
				";
				if(count($compquestions)>0){
					foreach($compquestions as $keys=>$comp_question){
						$array=[1,2];
						foreach($array as $s){
						$data.="<div id='interview_questions".$comp_question['comp_def_id']."_".$comp_question['scale_id']."_".$emp_id."_".$s."'  class='modal fade'  tabindex='-1' role='dialog' aria-hidden='true' data-backdrop='static' data-keyboard='false' >
							<div class='modal-dialog modal-dialog-scrollable  modal-lg'>
								<div class='modal-content'>
									<div class='color-line'></div>
									<div class='modal-header'>
										<h4 class='modal-title'>Interview Questions</h4>
										<button type='button' class='close'
										
										aria-hidden='true' id='close_int".$comp_question['comp_def_id']."_".$comp_question['scale_id']."_".$emp_id."_".$s."' onclick='close_mode(".$comp_question['comp_def_id'].",".$comp_question['scale_id'].",".$emp_id.",".$s.")'>X</button>
										
									</div>
									<div class='modal-body'>
										<div id='interview_question_detail".$comp_question['comp_def_id']."_".$comp_question['scale_id']."_".$emp_id."_".$s."' class='modal-body no-padding'>
										
										</div>
									</div>
									
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div>";
						}
						
					}
				}
				$data.="</div>
				<div  id='over_7' class='tab-pane fade main' role='tabpanel'>
				<h6 class='mb-15'>Overall Rating</h6>";
				
				$ass_given_int=UlsAssessmentReportBytype::summary_details_count_status($testdetails['assessment_id'],'INTERVIEW',$testdetails['position_id'],$emp_id,$_SESSION['asr_id']);
				//$data.=count($compquestions)."-".$ass_given_int['total_count'];
				if(count($compquestions)==$ass_given_int['total_count']){
					$data.="<form action='' method='post' class='form-horizontal' id='interview_over_form_".$testdetails['rating_id']."' name='interview_over_form'>
					<input type='hidden' name='ass_rating_id'  id='ass_rating_id' value='".$ass_rating_id."'>
					<input type='hidden' name='employee_id'  id='employee_id' value='".$emp_id."'>
					<input type='hidden' name='assessment_type'  id='assessment_type' value='INTERVIEW'>
					<input type='hidden' name='assessment_id' value='".$testdetails['assessment_id']."' >
					<input type='hidden' name='position_id' value='".$testdetails['position_id']."' >
					<input type='hidden' name='assessor_id' value='".$_SESSION['asr_id']."' >";
					
					
					$rating=UlsRatingMasterScale::ratingscale($testdetails['rating_id']);
					
					$data.="
					
					<div class='form-group'>
						<label class='col-sm-1 control-label'>Rating<sup><font color='#FF0000'>*</font></sup>:</label>
						<div class='col-sm-6'>
							<select class='validate[required] form-control' name='scale_id' id='scale_id'>
								<option value=''>Select</option>";
								foreach($rating as $ratings){
									$rat_sel=!empty($ass_rating['scale_id'])?($ass_rating['scale_id']==$ratings['scale_id']?'selected="selected"':''):'';
									$data.="<option value='".$ratings['scale_id']."' ".$rat_sel.">".$ratings['rating_name_scale']."</option>";
								}
							$data.="</select>
						</div>
					</div>
					<div class='form-group'>
						<label class='col-sm-1 control-label'>Comments<sup><font color='#FF0000'>*</font></sup>:</label>";
						$comments=!empty($ass_rating['comments'])?$ass_rating['comments']:'';
						$data.="<div class='col-sm-9'><textarea placeholder='placeholder' class='validate[required,minSize[100]] form-control' type='text' name='comments' id='comments'>".$comments."</textarea></div>
					</div>";
					//$ass_rating_dis=!empty($ass_rating['ass_rating_id'])?'disabled':""".$ass_rating_dis.">;
					$data.="<div class='hr-line-dashed'></div>
					<div class='form-group'>
						<div class='col-sm-8 col-sm-offset-4'>
							<button class='btn btn-default' data-dismiss='modal' type='button'>Cancel</button>
							<button class='btn btn-primary' type='button' name='submit' id='interview_over_submit_".$testdetails['rating_id']."'> Submit</button>
						</div>
					</div>
				</div>
				</form>";
				}
				else{
					$data.="<div class='alert alert-danger alert-dismissable'>
						Please Assess all the competencies in Open-ended Questions 
					</div>";
				}
			$data.="</div>
		</div>";
		}
		else{
			$data.="<b>Please complete Test Evaluation</b>";
			$data.="<div class='hr-line-dashed'></div>
			<div class='form-group'>
				<div class='col-sm-8 col-sm-offset-4'>
					<button class='btn btn-default' data-dismiss='modal' type='button'>Cancel</button>
					
				</div>
			</div>";
		}
		echo $data;
	}
	
	public function getemp_comp_int_questions(){
		$data="";
		$comp_def_id=$_REQUEST['comp_def_id'];
		$scale_id=$_REQUEST['scale_id'];
		$rot_in=$_REQUEST['rot_in'];
		$emp_id=$_REQUEST['emp_id'];
		$type=$_REQUEST['type'];
		$report_id=$_REQUEST['report_id'];
		$assess_test_id=$_REQUEST['assess_test_id'];
		$type_n=($type==1)?"KC":"AQ";
		$testdetails=UlsAssessmentTest::test_details($assess_test_id);
		$report_details=UlsAssessmentReport::admin_position_report($report_id);
		$int_question_count=UlsCompetencyDefLevelInterview::getcompdeflevelint_details_count($comp_def_id,$scale_id);
		$rotin=($rot_in-1);
		$int_questions=UlsCompetencyDefLevelInterview::getcompdeflevelint_details_random($comp_def_id,$scale_id,$rotin);
		$ass_comp_count=UlsAssessmentReportBytypeInterview::get_interview_question_countdetails($report_id,$report_details['assessment_id'],$report_details['position_id'],$emp_id,$report_details['assessor_id'],$comp_def_id,$type_n,$int_questions['comp_int_id']);
		if(isset($ass_comp_count['total_count']) && $ass_comp_count['total_count']>0){
			$comp_interview_que=UlsCompetencyDefLevelInterviewQuestions::get_interview_question_type_assessor_insert($int_questions['comp_int_id'],$type_n,$report_details['assessment_id'],$report_details['position_id'],$emp_id,$report_details['assessor_id']);
			$flag=1;
		}
		else{
			
			$comp_interview_que=UlsCompetencyDefLevelInterviewQuestions::get_interview_question_type_assessor($int_questions['comp_int_id'],$type_n,$report_details['assessment_id'],$report_details['position_id'],$emp_id,$report_details['assessor_id']);
			$flag=2;
		}
		$total_comp_int=UlsCompetencyDefLevelInterview::getcompdeflevelint_details_count($comp_def_id,$scale_id);
		$total_int_q=$total_comp_int['total_count'];
		$kn=1;
		$data.="
		<form action='#' method='post' class='form-horizontal' id='interview_form_".$comp_def_id."_".$scale_id."_".$emp_id."_".$type."' name='interview_form_".$comp_def_id."_".$scale_id."_".$emp_id."'>
		<input type='hidden' name='report_id' id='report_id' value='".$report_id."'>
		<input type='hidden' name='comp_def_id' id='comp_def_id' value='".$comp_def_id."'>
		<input type='hidden' name='scale_id' id='scale_id' value='".$scale_id."'>
		<input type='hidden' name='employee_id' id='employee_id' value='".$emp_id."'>
		<input type='hidden' name='assessment_id' id='assessment_id' value='".$report_details['assessment_id']."'>
		<input type='hidden' name='position_id' id='position_id' value='".$report_details['position_id']."'>
		<input type='hidden' name='assessor_id' id='assessor_id' value='".$report_details['assessor_id']."'>
		<input type='hidden' name='comp_qtype' id='comp_qtype' value='".$type_n."'>
		<input type='hidden' id='intrandom_".$comp_def_id."_".$scale_id."' value='0'>
		";
		
		
		$data.="<div class='form-group panel-heading'>
			<div class='pull-left'>
				<h6 class='panel-title txt-dark'>Scenario</h6>
			</div>
			<div class='pull-right'>";
				//$gen_count>6 || 
				
				if((!isset($ass_comp_count['total_count']) || $ass_comp_count['total_count']==0)){
				$data.="<a href='#' onclick='open_generate_questions(".$comp_def_id.",".$scale_id.",".$emp_id.",".$type.",".$total_int_q.");' class='btn btn-primary btn-xs pull-left mr-15'>&nbsp; Regenerate&nbsp; </a>";
				}
			$data.="</div>
			<div class='clearfix'></div>
		</div>
		<div id='interview_question_generate_detail_".$comp_def_id."_".$scale_id."_".$emp_id."_".$type."'>
		<p>".$int_questions['interview_question']."</p><br><hr class='light-grey-hr'>
		<input type='hidden' name='comp_int_id' id='comp_int_id' value='".$int_questions['comp_int_id']."'>
		";
		foreach($comp_interview_que as $comp_interview_ques){
			$comments_h=!empty($comp_interview_ques['interview_comments'])?$comp_interview_ques['interview_comments']:"";
			$report_ass_intid=!empty($comp_interview_ques['report_ass_intid'])?$comp_interview_ques['report_ass_intid']:"";
		$data.="
			<div class='form-group'>
				<label class='control-label mb-10 col-sm-2' for='email_hr'>Question ".$kn.":</label>
				<div class='col-sm-10'>
					<input type='hidden' name='report_ass_intid[]' id='report_ass_intid' value='".$report_ass_intid."'>
					<input type='hidden' name='comp_int_qid[]' id='comp_int_qid' value='".$comp_interview_ques['comp_int_qid']."'>
					<textarea rows='2' cols='60' class='form-control' readonly>".$comp_interview_ques['comp_question_name']."</textarea>
				</div>
			</div>
			<div class='form-group'>
				<label class='control-label mb-10 col-sm-2' for='pwd_hr'>Question Answer:</label>
				<div class='col-sm-10'>".nl2br($comp_interview_ques['comp_question_answer'])."
				</div>
			</div>
			<div class='form-group'>
				<label class='control-label mb-10 col-sm-2' for='pwd_hr'>Comments:</label>
				<div class='col-sm-10'>
					<textarea name='interview_comments[]' rows='3' cols='60' class='form-control validate[groupRequired[payments]]' >".$comments_h."</textarea>
				</div>
			</div><hr class='light-grey-hr'>";
			$kn++;
		}
		
		$data.="
		</div>
		<div class='form-group mb-0'> 
				<div class='col-sm-offset-2 col-sm-10'>
				  <button type='button' id='interview_submit_".$comp_def_id."_".$scale_id."_".$emp_id."_".$type."' class='btn btn-success'><span class='btn-text'>submit</span></button>
				</div>
			</div>
		</form>";
		echo $data;
	}
	
	public function getemp_comp_int_generate_questions(){
		$data="";
		$comp_def_id=$_REQUEST['comp_def_id'];
		$scale_id=$_REQUEST['scale_id'];
		$type=$_REQUEST['type'];
		$rot_in=$_REQUEST['rot_in'];
		$rotin=($rot_in-1);
		$type_n=($type==1)?"KC":"AQ";
		
		$int_questions=UlsCompetencyDefLevelInterview::getcompdeflevelint_details_random($comp_def_id,$scale_id,$rotin);
		$comp_interview_que=UlsCompetencyDefLevelInterviewQuestions::get_interview_question_type_assessor_regenate($int_questions['comp_int_id'],$type_n);
		$kn=1;
		$data.="<p>".$int_questions['interview_question']."</p><br><hr class='light-grey-hr'>
		<input type='hidden' name='comp_int_id' id='comp_int_id' value='".$int_questions['comp_int_id']."'>
		";
		foreach($comp_interview_que as $comp_interview_ques){
			$report_ass_intid=!empty($comp_interview_ques['report_ass_intid'])?$comp_interview_ques['report_ass_intid']:"";
			
		$data.="
			
			<div class='form-group'>
				<label class='control-label mb-10 col-sm-2' for='email_hr'>Question ".$kn.":</label>
				<div class='col-sm-10'>
					<input type='hidden' name='report_ass_intid[]' id='report_ass_intid' value='".$report_ass_intid."'>
					<input type='hidden' name='comp_int_qid[]' id='comp_int_qid' value='".$comp_interview_ques['comp_int_qid']."'>
					<textarea rows='2' cols='60' class='form-control' readonly>".$comp_interview_ques['comp_question_name']."</textarea>
				</div>
			</div>
			<div class='form-group'>
				<label class='control-label mb-10 col-sm-2' for='pwd_hr'>Question Answer:</label>
				<div class='col-sm-10'>".nl2br($comp_interview_ques['comp_question_answer'])."
				</div>
			</div>
			<div class='form-group'>
				<label class='control-label mb-10 col-sm-2' for='pwd_hr'>Comments:</label>
				<div class='col-sm-10'>
					<textarea name='interview_comments[]' rows='3' cols='60' class='form-control validate[groupRequired[payments]]' ></textarea>
				</div>
			</div><hr class='light-grey-hr'>";
			$kn++;
		}
		echo $data;
	}
	
	
	
	public function getemp_test(){	   
		$testype="'".$_REQUEST['type']."'";
		$ass_id=$_REQUEST['ass_id'];
        $ass_test_id=$_REQUEST['id'];
		$test_id=$_REQUEST['test_id'];
		$emp_id=$_REQUEST['emp_id'];
        $testval=UlsAssessmentEmployees::getfeedback_attempts_new($ass_test_id,$ass_id,$testype,$test_id,$emp_id); //getting attempts from UlsTesAttempts Table
		$ass_test=UlsAssessmentTest::test_details($ass_test_id);
        $testd=UlsUtestResponsesAssessment::get_test_details($test_id);   
        $testdetails=UlsUtestResponsesAssessment::get_test_view_details($test_id,$ass_test_id,$ass_id);
		$respvals=array();
		$data="";
        $data.="<form action='".BASE_URL."/assessor/employee_test' method='post' name='employeeTest' id='employeeTest'>
			<input type='hidden' name='testid' id='testid' value=".$test_id." />
			<input type='hidden' name='assid' id='assid' value=".$ass_id." />
			<input type='hidden' name='emp_id' id='emp_id' value=".$emp_id." />
			<input type='hidden' name='ttype' id='ttype' value=".$testype." /> <br />
			<input type='hidden' name='ass_test_id' id='ass_test_id' value=".$ass_test_id." />
			<input type='hidden' name='timeconsume' id='timeconsume' value='".$ass_test['time_details']."' />
			<label id='testtime' style='width:auto' >".$ass_test['time_details']." </label>Minute(s).
			<div class='hpanel '>
				<div class='panel-heading hbuilt'>
					Test
				</div>
				<div class='panel-body no-padding'  style='max-height:none;'>
					<div class='row'>
						<div class='col-md-9 '>
							<div class='chat-discussion'>
								<div class='hpanel'>";
								$valid='required';
								if(count($testdetails)>0){
									foreach($testdetails as $keys=>$testdetail){
										$key=$keys+1; 
										$type=$testdetail['question_type'];
										$var=($key==1)?"block":"none";
										$data.="<div style='display:".$var.";?>' id='question_list".$key."' class='open_question_div' >
											<div class='panel-heading hbuilt'>
												<button class='btn btn-info btn-circle' type='button'>".$key."</button> ".$testdetail['question_name']."
												<input type='hidden' id='question_".$key."' name='question[".$key."]'  value='".$testdetail['question_id']."' >
												<input type='hidden' name='qtype' id='qtype_". $key."' value=".$type." />
												<input type='hidden' name='testid' id='testid' value=".$test_id." />
												
											</div>
											<div class=''>";
											$scort=($type=='P')?'sortable':'';
												$data.="<ul id='".$scort."' class='list-group'>";
												$ran='ORDER BY RAND()';
												$ss=UlsAssessmentTest::test_question_value($testdetail['question_id'],$ran);
												foreach($ss as $key1=>$sss){
													if($type=='F'){ 
														if(in_array($sss['value_id'],$respvals)){
															$valuename=Doctrine_Query::Create()->from('UlsUtestResponsesAssessment')->where("response_value_id=".$sss['value_id']." and assessment_id=".$ass_id."  And employee_id=".$emp_id." And test_type=".$testype." And event_id=".$ass_test_id)->fetchOne();
															$ched=$valuename->text; 
														}
														else {  $ched=""; }
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
														$data.="<li class='list-group-item'>
															&emsp;Ans: <input type='text' value='".$ched."' class='validate[".$valid."] mediumtext' name='answer_".$key."[]' id='answer_".$key."_".$key1."' />
														</li>";
													}
													else if($type=='T'){
														if(in_array($sss['value_id'], $respvals)){ $ched="checked='checked'"; } else {  $ched=""; }
														$data.="<li class='list-group-item'>
															<div class='radio'><label  for='truefalse'> <input type='radio' class='radiocheck validate[".$valid."]' ".$ched."  value='".$sss['value_id']."' name='answer_".$key."[]' value='' id='answer_".$key."_".$key1."'> ".$sss['text']."</label></div>
														</li>";
													}
													else if($type=='S'){ 
														if(in_array($sss['value_id'], $respvals)){ 
															$ched="checked='checked'"; } 
														else {  
															$ched=""; 
														}
														$data.="<li class='list-group-item'>
															<div class=''><label  for='truefalse'> <input type='radio'". $ched."  class='radiocheck validate[".$valid."]' value='".$sss['value_id']."' name='answer_".$key."[]' id='answer_".$key ."_".$key1."'> ".$sss['text']."</label></div>
														</li>";
													}
													else if($type=='M'){
														if(in_array($sss['value_id'], $respvals)){ 
															$ched='checked="checked"'; 
														}
														else { 
															$ched=''; 
														}	
														$data.="<li class='list-group-item'>
															<div class=''><label  for='truefalse'> <input type='checkbox' ".$ched." class='check validate[".$valid."]' value='".$sss['value_id']."' name='answer_".$key."[]' id='answer_".$key ."_".$key1."'> ".$sss['text']."</label></div>
														</li>";
													}
													else if($type=='FT'){
														if(in_array($sss['value_id'],$respvals)){				
														$valuename=Doctrine_Query::Create()->from("UlsUtestResponsesAssessment")->where("response_value_id=".$sss['value_id']." and employee_id=".$emp_id." and test_type=".$testype." and event_id=".$ass_test_id." and  assessment_id=".$ass_id)->fetchOne();
														$ched=$valuename->text;
														}
														else {  $ched=""; }
														$data.="<li class=''>
															&emsp;<textarea style='resize:none;width:655px;height:120px;' name='answer_".$key."[]' class='validate[".$valid."] mediumtexta' id='answer_".$key."_". $key1 ."'> ". $ched."</textarea>
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
												<br style='clear:both;'>
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
														$data.="<button type='button' class='next_question btn btn-info' id='next' data='".$key."'>Next</button>
														<button type='button' class='skip_question btn btn-warning' id='next' data='".$key."'>Skip</button>";
													}
													elseif($key<$count){
														$data.="<button type='button' class='next_question btn btn-info' id='next' data='".$key."'>Next</button>
														<button type='button' class='skip_question btn btn-warning' id='next' data='".$key."'>Skip</button>";
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
								$data.="</div>
								<br style='clear:both;'>
							</div>
							<br style='clear:both;'>
						</div>
						<div class='col-md-3'>
							<div class='chat-users'>
									
								<div class='users-list'>";
								if(count($testdetails)>0){
									foreach($testdetails as $key=>$testdetailss){
										$ke=$key+1;
									$data.="<div class='chat-user'>
										<div class='chat-user-name'>
											<button class='btn question_color".$testdetailss['question_id']." btn-circle' type='button'>".$ke."</button> &nbsp;&nbsp;<a href='#' id='open_skip_question".$testdetailss['question_id']."'>Question ".$ke."</a>
											<input type='hidden' id='skipvalue".$ke."' value=''>
										</div>
									</div>";
									}
								}									
								$data.="</div>
							</div>
						</div>
						<br style='clear:both;'>
					</div>
					<br style='clear:both;'>
				</div>
				<br style='clear:both;'>
			</div>";
		$data.="</form>";
		echo $data;	
	}
	
	public function employee_test(){
		$this->sessionexist();
		if(isset($_SESSION['user_id'])){
			$this->pagedetails('admin','employee_test');
			$testtype=$_POST['ttype'];
			$emp_id=$_POST['emp_id'];
			if(isset($_POST['testid']) || isset($_POST['resume'] ) ){
				$eveid=$_POST['ass_test_id'];
				echo $tidss=$tid=$_POST['testid'];
				//$testids=$_POST['testrespids'];
				$evalid=$_POST['assid'];
				$teststatus=isset($_POST['resume'])?'RES':'COM';
				$testdeails=Doctrine_Core::getTable('UlsCompetencyTest')->findOneByTest_id($tid);
				// Deleting Previous Test Records
				$qtvalus=Doctrine_Query::create()->select('id')->from('UlsUtestQuestionsAssessment')->where("test_id=".$tid." and event_id=".$eveid." and employee_id=".$emp_id." and assessor_id=".$_SESSION['asr_id']." and test_type='".$_REQUEST['ttype']."' and assessment_id=".$evalid." and parent_org_id=".$_SESSION['parent_org_id'])->execute();
				if(count($qtvalus)>0){
					foreach($qtvalus as $qtvalue){
						if(!empty($qtvalue['id'])){
							$del=Doctrine_Query::Create()->Delete('UlsUtestResponsesAssessment')->where("utest_question_id=".$qtvalue['id'])->execute();
						}
					}
				}
				Doctrine_Query::create()->delete('UlsUtestQuestionsAssessment')->where("test_id=".$tid." and event_id=".$eveid." and assessment_id=".$evalid." and employee_id=".$emp_id." and assessor_id=".$_SESSION['asr_id']." and test_type='".$_REQUEST['ttype']."' and parent_org_id=".$_SESSION['parent_org_id'])->execute();
				// Deletion Completed;
				// code for getting Version_number in UlsTestAttempts Table
				$attval=Doctrine_Query::Create()->select('version_number as atts,attempt_id')->from('UlsUtestAttemptsAssessment')->where("employee_id=".$emp_id." and assessor_id=".$_SESSION['asr_id']." and event_id=".$eveid." and parent_org_id=".$_SESSION['parent_org_id']." and assessment_id=".$evalid."  and  test_type='".$_POST['ttype']."' and test_id=".$tid )->setHydrationMode(Doctrine::HYDRATE_ARRAY)->execute();
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
					$question_values->assessor_id=$_SESSION['asr_id'];
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
								$results[]= array('id' => $ans, 'text' => $anss_content);
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
					$questions->assessor_id=$_SESSION['asr_id'];
                    $questions->assessment_id=$evalid;
                    $questions->user_test_question_id=$val;
                    $questions->test_type=$_POST['ttype'];
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
			$notificationdata->assessor_id=$_SESSION['asr_id'];
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
			$notificationdata->test_type=$_POST['ttype'];
			$notificationdata->internal_state="";
			$notificationdata->mastery_score=0;
			$notificationdata->save();
			$ass_details=UlsAssessmentTest::assessment_test_employee($eveid);
			redirect("assessor/assessor_assessment_details?assessment_id=".$ass_details['assessment_id']);
			
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
		$emp_id=$_REQUEST['emp_id'];
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
	
	
	public function ass_summary_details(){
		$data=array();
		$ass_id=$_REQUEST['ass_id'];
		$emp_id=$_REQUEST['emp_id'];
		$pos_id=$_REQUEST['pos_id'];
		$data['id']=$ass_id;
		$data['emp_id']=$emp_id;
		$data['pos_id']=$pos_id;
		$data['assdetails']=UlsAssessmentDefinition::viewassessment($ass_id);
		$data['test_casestudy']=UlsAssessmentTestCasestudy::viewcasestudy_count($ass_id,$pos_id);
		$data['test_inbasket']=UlsAssessmentTestInbasket::viewinbasket_count($ass_id,$pos_id);
		$data['ass_test']=UlsAssessmentTest::assessment_test($ass_id,$pos_id);
		$data['competency']=UlsAssessmentReport::getassessment_competencies_summary($ass_id,$pos_id,$emp_id);
		$data['ass_rating']=UlsAssessmentAssessorRating::get_ass_rating_assessor_summary($ass_id,$pos_id,$emp_id);
		$data['ass_rating_final']=UlsAssessmentReportFinal::assessment_assessor_final($ass_id,$pos_id,$emp_id,$_SESSION['asr_id']);
		$data['comp_status']=UlsAssessmentReportBytype::summary_details_count_status($ass_id,'INBASKET',$pos_id,$emp_id,$_SESSION['asr_id']);
		$content = $this->load->view('assessor/assessmentsummarydetails',$data,true);
		$this->render('layouts/ajax-layout',$content);
	}
	
	public function summary_result_insert(){
		if(isset($_POST['assessor_id'])){
			
			/* foreach($_POST['competency'] as $key=>$competencys){
				$master_value=!empty($_POST['report_id'][$key])?Doctrine::getTable('UlsAssessmentReport')->find($_POST['report_id'][$key]): new UlsAssessmentReport();
				$master_value->assessed_scale_id=$_POST['OVERALL_'.$competencys];
				$master_value->development_area=$_POST['development_'.$competencys];
                $master_value->save();
				$ass_test=UlsAssessmentTest::assessment_test($master_value->assessment_id,$master_value->position_id);
				foreach($ass_test as $ass_tests){
					if(!empty($_POST['CASE_STUDY_'.$competencys])){
						if($ass_tests['assessment_type']=='CASE_STUDY'){
							$master_results=UlsAssessmentReportBytype::summary_details($master_value->report_id,$ass_tests['assessment_type']);
							$master_value_sub=!empty($master_results['report_assess_id'])?Doctrine::getTable('UlsAssessmentReportBytype')->find($master_results['report_assess_id']): new UlsAssessmentReportBytype();
							$master_value_sub->report_id=$master_value->report_id;
							$master_value_sub->assessment_id=$master_value->assessment_id;
							$master_value_sub->position_id=$master_value->position_id;
							$master_value_sub->employee_id=$master_value->employee_id;
							$master_value_sub->assessor_id=$master_value->assessor_id;
							$master_value_sub->assessment_type=$ass_tests['assessment_type'];
							$master_value_sub->competency_id=$competencys;
							$master_value_sub->require_scale_id=$master_value->require_scale_id;
							$master_value_sub->assessed_scale_id=$_POST['CASE_STUDY_'.$competencys];
							$master_value_sub->save();
						}
					}
					if(!empty($_POST['INBASKET_'.$competencys])){
						if($ass_tests['assessment_type']=='INBASKET'){
							$master_results=UlsAssessmentReportBytype::summary_details($master_value->report_id,$ass_tests['assessment_type']);
							$master_value_sub=!empty($master_results['report_assess_id'])?Doctrine::getTable('UlsAssessmentReportBytype')->find($master_results['report_assess_id']): new UlsAssessmentReportBytype();
							$master_value_sub->report_id=$master_value->report_id;
							$master_value_sub->assessment_id=$master_value->assessment_id;
							$master_value_sub->position_id=$master_value->position_id;
							$master_value_sub->employee_id=$master_value->employee_id;
							$master_value_sub->assessor_id=$master_value->assessor_id;
							$master_value_sub->assessment_type=$ass_tests['assessment_type'];
							$master_value_sub->competency_id=$competencys;
							$master_value_sub->require_scale_id=$master_value->require_scale_id;
							$master_value_sub->assessed_scale_id=$_POST['INBASKET_'.$competencys];
							$master_value_sub->save();
						}
					}
					if(!empty($_POST['TEST_'.$competencys])){
						if($ass_tests['assessment_type']=='TEST'){
							$master_results=UlsAssessmentReportBytype::summary_details($master_value->report_id,$ass_tests['assessment_type']);
							$master_value_sub=!empty($master_results['report_assess_id'])?Doctrine::getTable('UlsAssessmentReportBytype')->find($master_results['report_assess_id']): new UlsAssessmentReportBytype();
							$master_value_sub=new UlsAssessmentReportBytype();
							$master_value_sub->report_id=$master_value->report_id;
							$master_value_sub->assessment_id=$master_value->assessment_id;
							$master_value_sub->position_id=$master_value->position_id;
							$master_value_sub->employee_id=$master_value->employee_id;
							$master_value_sub->assessor_id=$master_value->assessor_id;
							$master_value_sub->assessment_type=$ass_tests['assessment_type'];
							$master_value_sub->competency_id=$competencys;
							$master_value_sub->require_scale_id=$master_value->require_scale_id;
							$master_value_sub->assessed_scale_id=$_POST['TEST_'.$competencys];
							$master_value_sub->save();
						}
					}
					if(!empty($_POST['INTERVIEW_'.$competencys])){
						if($ass_tests['assessment_type']=='INTERVIEW'){
							$master_results=UlsAssessmentReportBytype::summary_details($master_value->report_id,$ass_tests['assessment_type']);
							$master_value_sub=!empty($master_results['report_assess_id'])?Doctrine::getTable('UlsAssessmentReportBytype')->find($master_results['report_assess_id']): new UlsAssessmentReportBytype();
							$master_value_sub=new UlsAssessmentReportBytype();
							$master_value_sub->report_id=$master_value->report_id;
							$master_value_sub->assessment_id=$master_value->assessment_id;
							$master_value_sub->position_id=$master_value->position_id;
							$master_value_sub->employee_id=$master_value->employee_id;
							$master_value_sub->assessor_id=$master_value->assessor_id;
							$master_value_sub->assessment_type=$ass_tests['assessment_type'];
							$master_value_sub->competency_id=$competencys;
							$master_value_sub->require_scale_id=$master_value->require_scale_id;
							$master_value_sub->assessed_scale_id=$_POST['INTERVIEW_'.$competencys];
							$master_value_sub->save();
						}
					}
				} 
				
			}*/
			$ass_test_final=UlsAssessmentReportFinal::assessment_assessor_final($_POST['assessment_id'],$_POST['position_id'],$_POST['employee_id'],$_POST['assessor_id']);
			$master_value_final=!empty($ass_test_final['final_id'])?Doctrine::getTable('UlsAssessmentReportFinal')->find($ass_test_final['final_id']): new UlsAssessmentReportFinal();
			$master_value_final->assessment_id=$_POST['assessment_id'];
			$master_value_final->position_id=$_POST['position_id'];
			$master_value_final->employee_id=$_POST['employee_id'];
			$master_value_final->assessor_id=$_POST['assessor_id'];
			$master_value_final->status='A';
			$master_value_final->scale_id=$_POST['scale_id'];
			$master_value_final->strength=$_POST['strength'];
			$master_value_final->ofiss=$_POST['ofiss'];
			$master_value_final->comments=$_POST['comments'];
			$master_value_final->save();
			echo 'done';
		}
	}
	
	public function summary_result_insert_save(){
		if(isset($_POST['assessor_id'])){
			
			foreach($_POST['competency'] as $key=>$competencys){
				$master_value=!empty($_POST['report_id'][$key])?Doctrine::getTable('UlsAssessmentReport')->find($_POST['report_id'][$key]): new UlsAssessmentReport();
				$master_value->assessment_id=$_POST['assessment_id'];
				$master_value->position_id=$_POST['position_id'];;
				$master_value->employee_id=$_POST['employee_id'];;
				$master_value->assessor_id=$_POST['assessor_id'];;
				$master_value->competency_id=$competencys;
				$master_value->require_scale_id=!empty($_POST['requiredlevel_'.$competencys])?$_POST['requiredlevel_'.$competencys]:NULL;
				$master_value->assessed_scale_id=!empty($_POST['OVERALL_'.$competencys])?$_POST['OVERALL_'.$competencys]:NULL;
				$master_value->development_area=!empty($_POST['development_'.$competencys])?$_POST['development_'.$competencys]:NULL;
                $master_value->save();
			}
			echo 'done';
		}
	}
	
	public function getemp_test_readonly(){	   
		$testype=$_REQUEST['ass_type'];
        $event=$_REQUEST['event_id'];
		$ass_id=$_REQUEST['ass_id'];
		$emp_id=$_REQUEST['emp_id'];
		$tid=$_REQUEST['test_id'];
		$empdetails=UlsEmployeeMaster::get_empdetails_id($emp_id);
		$testdetails=UlsUtestResponsesAssessment::gettesttakenquestion_view($tid,$testype,$ass_id,$event,$emp_id);	
        echo "
        <div align='center'>";
		$ss=''; $rr='';$respvals=array();
        
        $ccc= Doctrine_Query::create()->from('UlsUtestResponsesAssessment')->where("employee_id=".$emp_id." and assessment_id=".$ass_id." and parent_org_id=".$_SESSION['parent_org_id']." and event_id=".$event." and test_type='".$testype."'")->execute();
        foreach( $ccc as $cccs){
			$respvals[$cccs->utest_question_id]=$cccs->response_value_id;
		}
		/* echo "<pre>";
		print_r($respvals); */
		echo "<div align='center' class='widget-box pricing-box-small widget-color-grey' style='width:100%;'> 
			<div class='widget-header'>
				<h5 class='widget-title bigger lighter'>Test Questions.</h5>
			</div>
		</div>";
		  
		echo "<div style='padding-top: 3px; border:1px solid #DDDDDD; height: 300px;overflow: auto;' align='center'>
		<table width='100%'>";
		if(count($testdetails)>0){
			foreach($testdetails as $keys=>$testdetail){
				$key=$keys+1; $type=$testdetail['question_type']; 
				echo "<tr><td style='line-height: 18px;'><span style='float:left' >".$key." )</span> ".$testdetail['question_name']."
				</td>
				</tr>";
				$ss=Doctrine_Query::create()->select('text,correct_flag')->from("UlsQuestionValues")->where("question_id=".$testdetail['question_id'])->execute();
	 
				foreach($ss as $key1=>$sss){
					if($type=='F'){ 
						if(in_array($sss['value_id'],$respvals)){
							$valuename=Doctrine_Query::Create()->from('UlsUtestResponsesAssessment')->where("response_value_id=".$sss['value_id']." and assessment_id=".$ass_id."  And employee_id =".$emp_id." And test_type='".$testype."' And event_id=".$event)->fetchOne();
							$ched=htmlentities(stripslashes($valuename->text)); 
						}
						else {  $ched=""; }
						echo "<tr><td>&emsp;Ans: <input type='text' value='".$ched."' class='mediumtext' name='answer_".$key."[]' id='answer_". $key ."_".$key1 ."'/>";
						echo "</td></tr>";              
					}
					else if($type=='B'){
						if(in_array($sss['value_id'],$respvals)){				
							$valuename=Doctrine_Query::Create()->from('UlsUtestResponsesAssessment')->where("response_value_id=".$sss['value_id']." and assessment_id=".$ass_id." And employee_id =".$emp_id." And test_type='".$testype."' And event_id=".$event)->fetchOne(); 
							$ched=htmlentities(stripslashes($valuename->text));
						} 
						else {  $ched=""; }			  
						echo "<tr><td>&emsp;Ans: <input type='text' value='".$ched."' class='mediumtext' name='answer_".$key."[]' id='answer_".$key."_".$key1."' />
						</td></tr>  ";
					}
					else if($type=='T'){
						if(in_array($sss['value_id'], $respvals)){ $ched="checked='checked'"; } else {  $ched=""; }
						echo "<tr>
						<td>&emsp;<input type='radio' class='".$ched."  value='".$sss['value_id']."' name='answer_".$key."[]' value='' id='answer_".$key."_".$key1."'  style='float:left; margin-left: 13px;'/>
						<label style='font-size:13px; float:left;' for='truefalse'>".htmlentities(stripslashes($sss['text']))."</label> 
						</td>
						</tr>"; 
					}
					else if($type=='S'){ 
						if(in_array($sss['value_id'], $respvals)){ $ched="checked='checked'"; } 
						else {  $ched=""; }
						$color=$sss['correct_flag']=='Y'?"color:green":"";
						echo "<tr>
							<td>&emsp;<input type='radio'". $ched."  value='".$sss['value_id']."' name='answer_".$key."[]' id='answer_".$key ."_".$key1."'  style='float:left; margin-left: 13px;' disabled />
							<label style='font-size:13px; float:left;".$color."' for='truefalse'>".htmlentities(stripslashes($sss['text']))."</label></td>
						</tr>";  
					}
					else if($type=='M'){
						if(in_array($sss['value_id'], $respvals)){ $ched='checked="checked"'; }
						else {  $ched=''; }			   
						echo"<tr>
							<td> &emsp; <input type='checkbox' ".$ched." value='".$sss['value_id']."' name='answer_".$key."[]' id='answer_".$key ."_".$key1."'  /> <label style='font-size:13px; margin-top:-7px;' for='truefalse'>".htmlentities(stripslashes($sss['text']))."</label></td>
						</tr> " ;
					}
					else if($type=='FT'){
						if(in_array($sss['value_id'],$respvals)){				
							$valuename=Doctrine_Query::Create()->from("UlsUtestResponsesAssessment")->where("response_value_id=".$sss['value_id']." and employee_id=".$emp_id." and test_type='".$testype."' and event_id=".$event." and assessment_id=".$ass_id)->fetchOne();
							$ched=htmlentities(stripslashes($valuename->text));
						}
						else {  $ched=""; }
						echo"<tr><td>&emsp;<textarea style='resize:none;' name='answer_".$key."[]' class='largetext' id='answer_".$key."_". $key1 ."'> ". $ched."</textarea> </td></tr> "; 
					}
				}
				echo "<tr><td><hr></td></tr>";
			}          
		} 
		else { echo "<tr><td>No Data Available.</td></tr>"; }  echo"</table></div>";
	   
	   
		echo "</form> <br style='clear:both;'>";	
	}
	
	
	public function migration_map_details(){
		$comp_id=$_REQUEST['comp_id'];
		$scale_id=$_REQUEST['scale_id'];
		$data="";
		$migration=UlsCompetencyDefLevelMigrationMaps::getcompdeflevelmigmap($comp_id,$scale_id);
		$comp_name=UlsCompetencyDefinition::competency_detail_single($comp_id);
		$scale_name=UlsLevelMasterScale::levelscale_detail($scale_id);
		$mig=explode(",",$migration['comp_def_level_migrate_type']);
		$data.="
		<div class='modal-header'>
			<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
			<h4 class='modal-title'>".$comp_name['comp_def_name']." (".$scale_name['scale_name'].")</h4>
		</div>
		<div class='modal-body'>
			<div class='panel-body'>
				<div class='row'>
					<div class='row col-lg-12'>
						<div  class='pills-struct'>
							<ul role='tablist' class='nav nav-pills' id='myTabs_6' style='padding-left: 14px;'>";
								$j=0;
								foreach($mig as $migs){
									$name='';
									if($migs=='EXT_TRAINING'){
										$name.='Training';
									}
									elseif($migs=='OJT'){
										$name.='On Job Training';
									}
									elseif($migs=='PROJ'){
										$name.='Projects';
									}
									elseif($migs=='MENTOR'){
										$name.='Mentoring';
									}
									elseif($migs=='CER'){
										$name.='Certification';
									}
									elseif($migs=='OTHERS'){
										$name.='Others';
									}
									$class=($j==0)?"active":""; $j++;
									$data.="<li class='".$class."' role='presentation'><a aria-expanded='true'  data-toggle='tab' role='tab' id='home_tab_6' href='#home_".$comp_id."_".$scale_id."_".$migs."'>".$name."</a></li>";
								}
							$data.="</ul>
							<div class='tab-content' id='myTabContent_6' >";
							$i=0;
							foreach($mig as $migs){
								$compdetails=UlsCompetencyMigrationContentMaster::get_migration_competencies($comp_id,$scale_id,$migs);
								$class=($i==0)?"active in":""; $i++;
								$data.="<div  id='home_".$comp_id."_".$scale_id."_".$migs."' class='tab-pane fade ".$class."' role='tabpanel' style='padding-left: 0px;'><ul class='list-icons'>";
								foreach($compdetails as $compdetail){
									$square=(!empty($compdetail['program_objective']))?"&nbsp;<i class='fa fa-caret-square-o-down'></i>":"";
									$data.="
										<li class='mb-10>
										<h7 class='weight-500'>".$compdetail['program_name']."</h7>
										<a data-toggle='collapse' class='mt-10' href='#collapseExample".$compdetail['course_id']."' aria-expanded='false' aria-controls='collapseExample".$compdetail['course_id']."'>
											".$square."</a></li>";
										if(!empty($compdetail['program_objective'])){
										$data.="<div class='collapse' id='collapseExample".$compdetail['course_id']."'>
											
											<div class='well'>
											<div class='pull-left'>
											<h6 class='panel-title inline-block txt-dark'>Objective</h6>
											</div>";
											if(!empty($compdetail['program_link'])){
											$data.="<div class='pull-right'>
											
												<span class='label label-info capitalize-font inline-block ml-10'><a href='".$compdetail['program_link']."' target='_blank' style='color:white;'>Link</a></span>
											
											</div>";
											}
											$data.="<div class='clearfix'></div>
												".$compdetail['program_objective']."
											</div>
											
										</div>";
										}
								}
								$data.="</ul></div>";
							}	
							$data.="</div>
						</div>";
					$data.="
					</div>
				</div>
			</div>
		</div>";
		echo $data;
	}
	
	public function getcomp_indicator(){
		$comp_id=$_REQUEST['comp_id'];
		$scale_id=$_REQUEST['scale_id'];
		$compentency=UlsMenu::callpdorow("SELECT comp_def_id,comp_def_name,comp_def_short_desc FROM `uls_competency_definition` where comp_def_id='$comp_id'");
		$indicator=UlsCompetencyDefLevelIndicator::getcompdeflevelind_details($comp_id,$scale_id);
		$scale_detail=UlsLevelMasterScale::levelscale_detail($scale_id);
		$scale_info=UlsLevelMasterScale::levelscale($scale_detail['level_id']);
		$data="";
		$data.="
		<h4>Competency Name: ".$compentency['comp_def_name']."</h4><br>
		<h4>Level Name: ".$scale_detail['scale_name']."</h4><br>
		<div><p class='text-muted'>Competency Description: ".$compentency['comp_def_short_desc']."</p></div><br>
		<div><p class='text-muted'><code>Please find the Level indicators for other levels</code>
		<div class='row'>
			<div class='col-sm-4'>
				<select class='form-control' id='scale_id_select_".$comp_id."' name='scale_id_select' onchange='get_level_indicator(".$comp_id.")'>
					<option>Select</option>";
					foreach($scale_info as $scale_infos){
						$select=!empty($scale_id)?($scale_id==$scale_infos['scale_id'])?'selected="selected"':'':'';
						$data.="<option value='".$scale_infos['scale_id']."' ".$select.">".$scale_infos['scale_name']."</option>";
					}
				$data.="</select>
			</div>
			<div class='col-sm-8'>&nbsp;</div>
		</div>
		</div></p></div><br>";
		$data.="<div id='scaledetail_info".$comp_id."'>";
		if(count($indicator)>0){
		$data.="
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
				$type=($indicators['ind_master_name']=='General')?"General":$indicators['ind_master_name'];
				$data.="<tr>
					<td>".($key+1)."</td>
					<td>".$type."</td>
					<td>".$indicators['comp_def_level_ind_name']."</td>
				</tr>";
			}
			$data.="</tbody>
		</table></div>";
		}
		$data.="</div>";
		echo $data;
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
				$type=($indicators['ind_master_name']=='General')?"General":$indicators['ind_master_name'];
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
	
	public function overalldet(){
		$data=array();
		$category=UlsCompetencyPositionRequirements::category_comp_details($_REQUEST['pos_id']);
		$data['category']=$category;
		$testtypes=UlsAssessmentTest::get_assessment_position($_REQUEST['ass_id'],$_REQUEST['pos_id']);
		$data['testtypes']=$testtypes;
		$data['assessor_rating_new']=UlsAssessmentAssessorRating::assessor_results_report_new($_REQUEST['ass_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id']);
		$data['emp_id']=$_REQUEST['emp_id'];
		$content = $this->load->view('assessor/overalldetailstable',$data,true);
		$this->render('layouts/ajax-layout',$content);
	}
}

