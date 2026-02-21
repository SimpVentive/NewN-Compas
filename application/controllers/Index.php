<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends  MY_Controller {
	
	 public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		//$this->load->model('QuizUsermaster');		
	 }
	 
	/* This function is used for read the template
		like html ,css,js files etc.*/
	private function readTemplateFile($FileName){
		$fp = fopen($FileName,"r") or exit("Unable to open File ".$FileName);
		$str = "";
		while(!feof($fp)) {
			$str .= fread($fp,1024);
		}	
		return $str;
	}	
	 
	public function index()
	{		
		$data=array();
		$data['menu']="index";
		$data['testimonials']=array();//Testimonials::doTestimoniallimit();
		$data['package']=array();//Packages::dopackages();
		$content = $this->load->view('index/index',$data,true);
		$this->render('layouts/index',$content);	
	}
	
	public function features()
	{		
		$data=array();
		$data['menu']="index";
		$data['testimonials']=array();//Testimonials::doTestimoniallimit();
		$data['package']=array();//Packages::dopackages();
		$content = $this->load->view('index/features',$data,true);
		$this->render('layouts/index_layout',$content);	
	}
	
	public function consulting()
	{		
		$data=array();
		$data['menu']="index";
		$data['testimonials']=array();//Testimonials::doTestimoniallimit();
		$data['package']=array();//Packages::dopackages();
		$content = $this->load->view('index/consulting',$data,true);
		$this->render('layouts/index_layout',$content);	
	}
	
	public function customisedcms()
	{		
		$data=array();
		$data['menu']="index";
		$data['testimonials']=array();//Testimonials::doTestimoniallimit();
		$data['package']=array();//Packages::dopackages();
		$content = $this->load->view('index/customisedcms',$data,true);
		$this->render('layouts/index_layout',$content);	
	}
	
	public function aboutus()
	{		
		$data=array();
		$data['menu']="index";
		$data['testimonials']=array();//Testimonials::doTestimoniallimit();
		$data['package']=array();//Packages::dopackages();
		$content = $this->load->view('index/aboutus',$data,true);
		$this->render('layouts/index_layout',$content);	
	}
	
	
	public function termsofuse()
	{		
		$data=array();
		$data['menu']="index";
		$data['testimonials']=array();//Testimonials::doTestimoniallimit();
		$data['package']=array();//Packages::dopackages();
		$content = $this->load->view('index/termsofuse',$data,true);
		$this->render('layouts/index_layout',$content);	
	}
	
	public function privacypolicy()
	{		
		$data=array();
		$data['menu']="index";
		$data['testimonials']=array();//Testimonials::doTestimoniallimit();
		$data['package']=array();//Packages::dopackages();
		$content = $this->load->view('index/privacypolicy',$data,true);
		$this->render('layouts/index_layout',$content);	
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
		$content = $this->load->view('index/login',$data,true);
		$this->render('layouts/login_layout',$content);	
	}
	
	public function login_insert()
	{		
		if(isset($_POST['signIn'])){
			$data=array('username'=>trim($this->input->post('username')),'password'=>trim($this->input->post('password')));
			if(!empty($data['username']) && !empty($data['password'])){
				$data=Doctrine_Core::getTable('UlsUserCreation')->findOneByUser_nameAndPassword($data['username'],$data['password']);
				//$data=UlsUserCreation::user_details($data['username'],$data['password']);
				if(isset($data->user_id)){
					if($data->start_date<=date("Y-m-d") && (empty($data->end_date) || $data->end_date=="0000-00-00" || $data->end_date=="1970-01-01"|| $data->end_date>=date("Y-m-d"))){
						$data->last_login_date=date("Y-m-d H:i:s");
						$data->save();
						$this->session->set_userdata('type', '');
						/* global $session;
						$session->login($data); */
						$this->session->set_userdata('username',$data->user_name);
						$this->session->set_userdata('user_id',$data->user_id);
						$this->session->set_userdata('parent_org_id',$data->parent_org_id);
						$query="SELECT c.system_menu_type, a.user_role_id, a.`role_id`, c.menu_creation_id, b.parent_org_id FROM `uls_user_role` a INNER JOIN uls_role_creation b ON  a.`role_id` = b.`role_id` INNER JOIN uls_menu_creation c ON b.menu_id = c.menu_creation_id WHERE `user_id` =".$data->user_id." and (a.start_date<='".date('Y-m-d')."' and (a.end_date is NULL || a.end_date >='".date('Y-m-d')."'))";
						$roleasd=UlsMenu::callpdo($query);
						$usertypess=array();
						$ii=0;
						foreach($roleasd as $key=>$val){
							if($val['system_menu_type']=="emp"){
								//['UlsRoleCreation']['UlsMenuCreation']
								$ii=$key;
								break;
							}
						}
						if(isset($roleasd[$ii]['user_role_id'])){
							$this->session->set_userdata('Role_id',$roleasd[$ii]['role_id']);
							$this->session->set_userdata('Menu_Id',$roleasd[$ii]['menu_creation_id']);
							$this->session->set_userdata('user_role',$roleasd[$ii]['system_menu_type']);
							$this->session->set_userdata('parent_org_id',$roleasd[$ii]['parent_org_id']);
							$orgdata=Doctrine_Core::getTable('UlsOrganizationMaster')->find($roleasd[$ii]['parent_org_id']);
							$this->session->set_userdata('org_start_date',$orgdata->start_date);
							$this->session->set_userdata('org_end_date',$orgdata->end_date);
							if(!empty($data->employee_id)){
								$emp_id=Doctrine_Core::getTable('UlsEmployeeMaster')->findOneByEmployee_id($data->employee_id);
								$org=Doctrine_Core::getTable('UlsEmployeeWorkInfo')->findOneByEmployee_id($data->employee_id);
								$this->session->set_userdata('emp_type',$emp_id->emp_type);
								$this->session->set_userdata('emp_id',$data->employee_id);
								$this->session->set_userdata('ven_id',$data->vendor_id);
								$this->session->set_userdata('org_id',$org->org_id);
								$this->session->set_userdata('location_id',$org->location_id);
							}
							if($roleasd[$ii]['system_menu_type']=='emp'){
								($data->user_login==1)?redirect("admin/profile"):redirect("employee/changepassword");
							}
							elseif($roleasd[$ii]['system_menu_type']=='man'){
								
								$this->session->set_userdata('man_id',$data->employee_id);
								$aaa=($data->user_login==1)?redirect("manager/profile"):redirect("manager/changepassword");
							}
							elseif($roleasd[$ii]['system_menu_type']=='asr'){
								
								$this->session->set_userdata('asr_id',$data->assessor_id);
								$aaa=($data->user_login==1)?redirect("assessor/profile"):redirect("assessor/changepassword");
							}
							elseif($roleasd[$ii]['system_menu_type']=='aptri'){
								/* echo $roleasd[$ii]['system_menu_type'];
								exit; */
								/* echo $roleasd[$ii]['system_menu_type'];
								exit; */
								($data->user_login==1)?redirect("admin/profile"):redirect("admin/changepassword");
							}
							else{							   
								($data->user_login==1)?redirect("admin/dashboard"):redirect("admin/changepassword");
							}
						}
						else{
							($data->user_login==1)?redirect("admin/dashboard"):redirect("admin/changepassword");
						}
					}
					else{
						$this->session->set_userdata('contact_admin', '1');
						$content = $this->load->view('index/login',NULL,true);
						$this->render('layouts/login_layout',$content);
					}
				}
				else{
					$this->session->set_userdata('wrong_username', '1');
					$content = $this->load->view('index/login',NULL,true);
					$this->render('layouts/login_layout',$content);
				}
			}
			else{
				$this->session->set_userdata('username_empty', '1');
				$content = $this->load->view('index/login',NULL,true);
				$this->render('layouts/login_layout',$content);
			}
		}
		else{
			//redirect("index/login?id=".$data->userid);
			$content = $this->load->view('index/login',NULL,true);
				$this->render('layouts/login_layout',$content);
		}
		
	}
	
	/*Start of Validation Functions*/
    public function empmail(){
		$validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
		$mail= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
		$id= (filter_input(INPUT_GET, "employee_id"))? filter_input(INPUT_GET, "employee_id"):"";
		$sql="1";
		$sql.=!empty($mail)? " and email='".$mail."'":"";
		$sql.=!empty($id)? " and employee_id!='$id'":"";
		$parent_org_id=$this->session->userdata('parent_org_id');
		$sql.=!empty($parent_org_id)? " and parent_org_id=".$this->session->userdata('parent_org_id'):"";
		echo !empty($mail)? $this->commonajaxfunc('UlsEmployeeMaster',$validateId,$sql):true;
	}
	public function announcementorg(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $orgname= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $announce_id= (filter_input(INPUT_GET, "id"))? filter_input(INPUT_GET, "id"):"";
		$announce_inclu_id= (filter_input(INPUT_GET, "announce_inclu_id"))? filter_input(INPUT_GET, "announce_inclu_id"):"";
        $sql="1";
        $sql.=!empty($orgname)? " and organization_id='".$orgname."'":"";
		$sql.=!empty($announce_id)? " and announcement_id='".$announce_id."'":"";
        $sql.=!empty($announce_inclu_id)? " and announcement_inclu_id!='$announce_inclu_id'":"";
        $parent_org_id=$this->session->userdata('parent_org_id');
		$sql.=!empty($parent_org_id)? " and parent_org_id=".$this->session->userdata('parent_org_id'):"";
        echo !empty($orgname)? $this->commonajaxfunc('UlsAnnouncementInclusions',$validateId,$sql):true;
    }
	public function announcementlearnergroup(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $learnergroup= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $announce_id= (filter_input(INPUT_GET, "id"))? filter_input(INPUT_GET, "id"):"";
		$announce_inclu_id= (filter_input(INPUT_GET, "announce_inclu_id"))? filter_input(INPUT_GET, "announce_inclu_id"):"";
        $sql="1";
        $sql.=!empty($learnergroup)? " and learner_group_id='".$learnergroup."'":"";
		$sql.=!empty($announce_id)? " and announcement_id='".$announce_id."'":"";
        $sql.=!empty($announce_inclu_id)? " and announcement_inclu_id!='$announce_inclu_id'":"";
		$parent_org_id=$this->session->userdata('parent_org_id');
		$sql.=!empty($parent_org_id)? " and parent_org_id=".$this->session->userdata('parent_org_id'):"";
        echo !empty($learnergroup)? $this->commonajaxfunc('UlsAnnouncementInclusions',$validateId,$sql):true;
    }
    public function eventname(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $eventname= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $eventid= (filter_input(INPUT_GET, "event_id"))? filter_input(INPUT_GET, "event_id"):"";
        $sql="1";
        $sql.=!empty($eventname)? " and event_name='".$eventname."'":"";
        $sql.=!empty($eventid)? " and event_id!='$eventid'":"";
        $parent_org_id=$this->session->userdata('parent_org_id');
		$sql.=!empty($parent_org_id)? " and parent_org_id=".$this->session->userdata('parent_org_id'):"";
        echo !empty($eventname)? $this->commonajaxfunc('UlsEventCreation',$validateId,$sql):true;
    }
	public function eventsessname(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $eventname= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
		$eventid= (filter_input(INPUT_GET, "event_id"))? filter_input(INPUT_GET, "event_id"):"";
        $event_sess_id= (filter_input(INPUT_GET, "event_sess_id"))? filter_input(INPUT_GET, "event_sess_id"):"";
        $sql="1";
        $sql.=!empty($eventname)? " and session_name='".$eventname."'":"";
        $sql.=!empty($event_sess_id)? " and event_sess_id!='$event_sess_id'":"";
		$sql.=!empty($eventid)? " and event_id='$eventid'":"";
        $parent_org_id=$this->session->userdata('parent_org_id');
		$sql.=!empty($parent_org_id)? " and parent_org_id=".$this->session->userdata('parent_org_id'):"";
        echo !empty($eventname)? $this->commonajaxfunc('UlsEventSession',$validateId,$sql):true;
    }
	public function hierarchyname(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $hiername= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
		$hierid= (filter_input(INPUT_GET, "hierarchy_id"))? filter_input(INPUT_GET, "hierarchy_id"):"";
        $sql="1";
        $sql.=!empty($hiername)? " and hierarchy_name='".$hiername."'":"";
        $sql.=!empty($hierid)? " and hierarchy_id!='$hierid'":"";
        $parent_org_id=$this->session->userdata('parent_org_id');
		$sql.=!empty($parent_org_id)? " and parent_org_id=".$this->session->userdata('parent_org_id'):"";
        echo !empty($hiername)? $this->commonajaxfunc('UlsHeirarchyMaster',$validateId,$sql):true;
    }
	public function tna_name(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $tna_name= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $tna_id= (filter_input(INPUT_GET, "tna_id"))? filter_input(INPUT_GET, "tna_id"):"";
        $sql="1";
        $sql.=!empty($tna_name)? " and tna_year='".$tna_name."'":"";
        $sql.=!empty($tna_id)? " and tna_id!='$tna_id'":"";
        $parent_org_id=$this->session->userdata('parent_org_id');
		$sql.=!empty($parent_org_id)? " and parent_org_id=".$this->session->userdata('parent_org_id'):"";
        echo !empty($tna_name)? $this->commonajaxfunc('UlsTnaYearSetup',$validateId,$sql):true;
    }
	
	
	public function check_tna(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $tna_year= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $tnaadmin_id= (filter_input(INPUT_GET, "tna_admin_id"))? filter_input(INPUT_GET, "tna_admin_id"):"";
        $sql="1";
        $sql.=!empty($tna_year)? " and tna_id='".$tna_year."'":"";
        $sql.=!empty($tnaadmin_id)? " and admin_year_id!='$tnaadmin_id'":"";
        $parent_org_id=$this->session->userdata('parent_org_id');
		$sql.=!empty($parent_org_id)? " and parent_org_id=".$this->session->userdata('parent_org_id'):"";
		$emp_id=$this->session->userdata('emp_id');
		$sql.=!empty($emp_id)? " and employee_id=".$this->session->userdata('emp_id'):"";
		$Role_id=$this->session->userdata('Role_id');
		$sql.=!empty($Role_id)? " and role_id=".$this->session->userdata('Role_id'):"";
        echo !empty($tna_year)? $this->commonajaxfunc('UlsTnaAdminYear',$validateId,$sql):true;
    }
	public function learnerorgname(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $orgname= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $eventid= (filter_input(INPUT_GET, "lnr_eventid"))? filter_input(INPUT_GET, "lnr_eventid"):"";
		$learnerid= (filter_input(INPUT_GET, "learner_id"))? filter_input(INPUT_GET, "learner_id"):"";
        $sql="1";
        $sql.=!empty($orgname)? " and organization_id='".$orgname."'":"";
        $sql.=!empty($eventid)? " and event_id='$eventid'":"";
		$sql.=!empty($learnerid)? " and event_association_id!='$learnerid'":"";
        $parent_org_id=$this->session->userdata('parent_org_id');
		$sql.=!empty($parent_org_id)? " and parent_org_id=".$this->session->userdata('parent_org_id'):"";
		//echo $validateId."<br>".$orgname."<br>".$eventid."<br>".$learnerid;
        echo !empty($orgname)? $this->commonajaxfunc('UlsLearnerAccess',$validateId,$sql):true;
    }
	public function learnerorgname_prog(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $orgname= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $progid= (filter_input(INPUT_GET, "lnr_prg_id"))? filter_input(INPUT_GET, "lnr_prg_id"):"";
		$learnerid= (filter_input(INPUT_GET, "learner_id"))? filter_input(INPUT_GET, "learner_id"):"";
        $sql="1";
        $sql.=!empty($orgname)? " and organization_id='".$orgname."'":"";
        $sql.=" and access_type='P'";
		$sql.=!empty($progid)? " and program_id='$progid'":"";
		$sql.=!empty($learnerid)? " and event_association_id!='$learnerid'":"";
        $parent_org_id=$this->session->userdata('parent_org_id');
		$sql.=!empty($parent_org_id)? " and parent_org_id=".$this->session->userdata('parent_org_id'):"";
		//echo $validateId."<br>".$orgname."<br>".$eventid."<br>".$learnerid;
        echo !empty($orgname)? $this->commonajaxfunc('UlsLearnerAccess',$validateId,$sql):true;
    }
	public function learnerlocation(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $locname= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $eventid= (filter_input(INPUT_GET, "lnr_eventid"))? filter_input(INPUT_GET, "lnr_eventid"):"";
		$learnerid= (filter_input(INPUT_GET, "learner_id"))? filter_input(INPUT_GET, "learner_id"):"";
        $sql="1";
        $sql.=!empty($locname)? " and location_id='".$locname."'":"";
        $sql.=!empty($eventid)? " and event_id='$eventid'":"";
		$sql.=!empty($learnerid)? " and event_association_id!='$learnerid'":"";
        $parent_org_id=$this->session->userdata('parent_org_id');
		$sql.=!empty($parent_org_id)? " and parent_org_id=".$this->session->userdata('parent_org_id'):"";
        echo !empty($locname)? $this->commonajaxfunc('UlsLearnerAccess',$validateId,$sql):true;
    }
	
	public function eventchatname(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $chatname= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
		$chatid= (filter_input(INPUT_GET, "chat_id"))? filter_input(INPUT_GET, "chat_id"):"";
		$chat_event_id= (filter_input(INPUT_GET, "chat_eventid"))? filter_input(INPUT_GET, "chat_eventid"):"";
        $sql="1";
        $sql.=!empty($chatname)? " and c.chat_name='".$chatname."'":"";
		$sql.=!empty($chatid)? " and c.chat_id!='$chatid'":"";
		$parent_org_id=$this->session->userdata('parent_org_id');
		$sql.=!empty($parent_org_id)? " and c.parent_org_id=".$this->session->userdata('parent_org_id'):"";
        
		$sql.=!empty($chat_event_id)? " and b.event_cat_id='$chat_event_id'":"";
		//echo !empty($chatname)? $this->commonajaxfunc('UlsChat c',$validateId,$sql):true;		
		$arrayToJs = array();
        $arrayToJs[0] = $validateId;
		if(!empty($chatname)){
        $query=Doctrine_Query::create()->from('UlsChat c')->innerJoin('c.UlsChatInclusions b')->where($sql)->execute(); 
			$arrayToJs[1]=count($query)>0 ? false:true;
			
			echo json_encode($arrayToJs);
		}
		else{
			$arrayToJs[1]=true;			
			echo json_encode($arrayToJs);
		}		
    }
	public function eventforumname(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $forumname= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
		$forumid= (filter_input(INPUT_GET, "forum_id"))? filter_input(INPUT_GET, "forum_id"):"";
		$forum_eveid= (filter_input(INPUT_GET, "gen_event_id"))? filter_input(INPUT_GET, "gen_event_id"):"";
        $sql="1";
        $sql.=!empty($forumname)? " and f.forum_name='".$forumname."'":"";
		$sql.=!empty($forumid)? " and f.forum_id!='$forumid'":"";
		$parent_org_id=$this->session->userdata('parent_org_id');
		$sql.=!empty($parent_org_id)? " and f.parent_org_id=".$this->session->userdata('parent_org_id'):"";
		$sql.=!empty($forum_eveid)? " and i.gen_event_id='$forum_eveid'":"";
        //echo !empty($forumname)? $this->commonajaxfunc('UlsForums',$validateId,$sql):true;
		$arrayToJs = array();
        $arrayToJs[0] = $validateId;
		if(!empty($forumname)){
        $query=Doctrine_Query::create()->from('UlsForums f')->innerJoin('f.UlsForumInclusions i')->where($sql)->execute(); 
			$arrayToJs[1]=count($query)>0 ? false:true;
			
			echo json_encode($arrayToJs);
		}
		else{
			$arrayToJs[1]=true;			
			echo json_encode($arrayToJs);
		}		
    }
	public function eventtopicname(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $topicname= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
		$topicid= (filter_input(INPUT_GET, "expert_topic_id"))? filter_input(INPUT_GET, "expert_topic_id"):"";
		$eventid= (filter_input(INPUT_GET, "expert_eventid"))? filter_input(INPUT_GET, "expert_eventid"):"";
        $sql="1";
        $sql.=!empty($topicname)? " and expert_topic_name='".$topicname."'":"";
		$sql.=!empty($eventid)? " and event_id='$eventid'":"";
		$sql.=!empty($topicid)? " and expert_topic_id!='$topicid'":"";
        $parent_org_id=$this->session->userdata('parent_org_id');
		$sql.=!empty($parent_org_id)? " and parent_org_id=".$this->session->userdata('parent_org_id'):"";
        echo !empty($topicname)? $this->commonajaxfunc('UlsAskTheExpert',$validateId,$sql):true;
    }
	public function learnergroupname(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $groupname= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $eventid= (filter_input(INPUT_GET, "lnr_eventid"))? filter_input(INPUT_GET, "lnr_eventid"):"";
		$learnerid= (filter_input(INPUT_GET, "learner_id"))? filter_input(INPUT_GET, "learner_id"):"";
        $sql="1";
        $sql.=!empty($groupname)? " and lnr_group_id='".$groupname."'":"";
        $sql.=!empty($eventid)? " and event_id='$eventid'":"";
		$sql.=!empty($learnerid)? " and event_association_id!='$learnerid'":"";
        $parent_org_id=$this->session->userdata('parent_org_id');
		$sql.=!empty($parent_org_id)? " and parent_org_id=".$this->session->userdata('parent_org_id'):"";
        echo !empty($groupname)? $this->commonajaxfunc('UlsLearnerAccess',$validateId,$sql):true;
    }
    public function resourcename(){
        $validateId= (filter_input(INPUT_POST, "fieldId"))? filter_input(INPUT_POST, "fieldId"):"";
        $resid= (filter_input(INPUT_POST, "fieldValue"))? filter_input(INPUT_POST, "fieldValue"):"";
        $resbuk_id= (filter_input(INPUT_POST, "resource_booking_id"))? filter_input(INPUT_POST, "resource_booking_id"):"";
        $eventid= (filter_input(INPUT_POST, "event_id"))? filter_input(INPUT_POST, "event_id"):"";
		$stdt= (filter_input(INPUT_POST, "res_required_date_from"))? filter_input(INPUT_POST, "res_required_date_from"):"";
		$enddt= (filter_input(INPUT_POST, "res_required_date_to"))? filter_input(INPUT_POST, "res_required_date_to"):"";
		$eveststarttime= (filter_input(INPUT_POST, "res_required_start_time"))? filter_input(INPUT_POST, "res_required_start_time"):"";
		$eveenendtime= (filter_input(INPUT_POST, "res_required_end_time"))? filter_input(INPUT_POST, "res_required_end_time"):"";
		$structure_id= (filter_input(INPUT_POST, "structure_id"))? filter_input(INPUT_POST, "structure_id"):"";
        $sql="1";
        $sql.=!empty($resname)? " and resource_id='$resname'":"";
        $sql.=!empty($resid)? " and resource_booking_id!='$resid'":"";
        //$sql.=!empty($eventid)? " and event_id='$eventid'":"";
		$sql.=!empty($structure_id)? " and resource_type='$structure_id'":"";
		$sql.=!empty($res_required_date_from)? " and required_date_from='$res_required_date_from'":"";
        $sql.=" and forum_id is null and chat_id is null and expert_topic_id is null";
		//echo $sql;
        //echo !empty($resname)? $this->commonajaxfunc('UlsResourceBook',$validateId,$sql):true;
		
		//$resid=$_REQUEST['res_def_id'];
		//$structure_id=$_REQUEST['structure_id'];
		//$resbuk_id=$_REQUEST['resbuk_id'];
		$stdt=date('Y-m-d',strtotime($stdt));
		$enddt=date('Y-m-d',strtotime($enddt));
		$eveststarttime=isset($eveststarttime)?!empty($eveststarttime)?$eveststarttime:"09:00:00":"09:00:00";
		$eveenendtime=isset($eveenendtime)?!empty($eveenendtime)?$eveenendtime:"18:00:00":"18:00:00";
		$stdt=date("Y-m-d h:i:s",strtotime($stdt." ".$eveststarttime));
		$enddt=date("Y-m-d h:i:s",strtotime($enddt." ".$eveenendtime));
		//CONCAT(ec.`event_start_date`,ec.`event_start_time`)
		//CONCAT(ec.`event_end_date`,ec.`event_end_time`)
		$a="DATE_FORMAT(STR_TO_DATE(concat(ec.`event_start_date`,ec.`event_start_time`), '%Y-%m-%d %H:%i'), '%Y-%m-%d %H:%i:%s')";
		$b="DATE_FORMAT(STR_TO_DATE(concat(ec.`event_end_date`,ec.`event_end_time`), '%Y-%m-%d %H:%i'), '%Y-%m-%d %H:%i:%s')";
		$qury="select rb.resource_booking_id, rb.resource_id, rb.event_id from uls_resource_book rb
		INNER JOIN uls_event_creation ec on ec.event_id=rb.event_id
		where rb.resource_booking_id!='".$resbuk_id."' and rb.resource_id=".$resid." and (($a<='".$stdt."' and $b>='".$stdt."') or ($a<='".$enddt."' and $b>='".$enddt."')) and rb.parent_org_id=".$this->session->userdata('parent_org_id')." and rb.forum_id is null and rb.chat_id is null and rb.expert_topic_id is null and rb.resource_type='$structure_id'";
		$data=UlsMenu::callpdo($con,$qury);
		
		$arrayToJs = array();
		$arrayToJs[0] = $validateId;
		if(count($data)>0){
			$arrayToJs[1]=false;
		}else{
			$arrayToJs[1]=true;
		}
		//$arrayToJs[1]=count($query)>0 ? false:true;
		echo json_encode($arrayToJs);		
    }
	
	public function sessresourcename(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $resname= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $resid= (filter_input(INPUT_GET, "resource_booking_id"))? filter_input(INPUT_GET, "resource_booking_id"):"";
        $eventid= (filter_input(INPUT_GET, "event_id"))? filter_input(INPUT_GET, "event_id"):"";
		$sessid= (filter_input(INPUT_GET, "res_event_sess_id"))? filter_input(INPUT_GET, "res_event_sess_id"):"";
		$res_required_date_from= (filter_input(INPUT_GET, "res_required_date_from"))? filter_input(INPUT_GET, "res_required_date_from"):"";
		$structure_id= (filter_input(INPUT_GET, "structure_id"))? filter_input(INPUT_GET, "structure_id"):"";
        $sql="1";
        $sql.=!empty($resname)? " and resource_id='$resname'":"";
        $sql.=!empty($resid)? " and resource_booking_id!='$resid'":"";
        //$sql.=!empty($eventid)? " and event_id='$eventid'":"";
		//$sql.=!empty($sessid)? " and event_sess_id='$sessid'":"";
		$sql.=!empty($structure_id)? " and resource_type='$structure_id'":"";
		$sql.=!empty($res_required_date_from)? " and required_date_from='$res_required_date_from'":"";
        $sql.=" and forum_id is null and chat_id is null and expert_topic_id is null";
        echo !empty($resname)? $this->commonajaxfunc('UlsResourceBook',$validateId,$sql):true;
    }
	
	public function referencename(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $refname= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $refid= (filter_input(INPUT_GET, "reference_id"))? filter_input(INPUT_GET, "reference_id"):"";
        $eventid= (filter_input(INPUT_GET, "event_id"))? filter_input(INPUT_GET, "event_id"):"";
        $sql="1";
        $sql.=!empty($refname)? " and reference_name='$refname'":"";
        $sql.=!empty($refid)? " and reference_id!='$refid'":"";
        $sql.=!empty($eventid)? " and event_id='$eventid'":"";
		$parent_org_id=$this->session->userdata('parent_org_id');
		$sql.=!empty($parent_org_id)? " and parent_org_id=".$this->session->userdata('parent_org_id'):"";
        echo !empty($refname)? $this->commonajaxfunc('UlsReference',$validateId,$sql):true;
    }
	public function evaluationname(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $testname= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $evalid= (filter_input(INPUT_GET, "evaluation_id"))? filter_input(INPUT_GET, "evaluation_id"):"";
        $eventid= (filter_input(INPUT_GET, "eval_eventid"))? filter_input(INPUT_GET, "eval_eventid"):"";
		$evaltype= (filter_input(INPUT_GET, "evaluation_type"))? filter_input(INPUT_GET, "evaluation_type"):"";
        $sql="1";
        $sql.=!empty($testname)? " and test_id='$testname'":"";
        $sql.=!empty($evalid)? " and evaluation_id!='$evalid'":"";
        $sql.=!empty($eventid)? " and event_id='$eventid'":"";
		$sql.=!empty($evaltype)? " and evaluation_type='$evaltype'":"";
        echo !empty($testname)? $this->commonajaxfunc('UlsEventsEvaluation',$validateId,$sql):true;
    }
	public function sessevaluationname(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $testname= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $evalid= (filter_input(INPUT_GET, "sess_evaluation_id"))? filter_input(INPUT_GET, "sess_evaluation_id"):"";
        $sessid= (filter_input(INPUT_GET, "event_sess_id"))? filter_input(INPUT_GET, "event_sess_id"):"";
		$evaltype= (filter_input(INPUT_GET, "sess_evaluation_type"))? filter_input(INPUT_GET, "sess_evaluation_type"):"";
        $sql="1";
        $sql.=!empty($testname)? " and test_id='$testname'":"";
        $sql.=!empty($evalid)? " and sess_evaluation_id!='$evalid'":"";
        $sql.=!empty($sessid)? " and event_sess_id='$sessid'":"";
		$sql.=!empty($evaltype)? " and sess_evaluation_type='$evaltype'":"";
        echo !empty($testname)? $this->commonajaxfunc('UlsEventSessEvaluation',$validateId,$sql):true;
    }
    public function checkempenroll(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $empnum= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $enrlid= (filter_input(INPUT_GET, "enroll_id"))? filter_input(INPUT_GET, "enroll_id"):"";
        $eventid= (filter_input(INPUT_GET, "evntid"))? filter_input(INPUT_GET, "evntid"):"";
        $sql="1";
        $sql.=!empty($empnum)? " and employee_id='$empnum'":"";
        $sql.=!empty($enrlid)? " and enrollment_id!='$enrlid'":"";
        $sql.=!empty($eventid)? " and event_id='$eventid'":"";
        echo !empty($empnum)? $this->commonajaxfunc('UlsEnrollments',$validateId,$sql):true;
    }
	
	public function checkassenroll(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $empnum= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $assessment_id_assessor_id= (filter_input(INPUT_GET, "assessment_id_assessor_id"))? filter_input(INPUT_GET, "assessment_id_assessor_id"):"";
        $position_id_assessor_id= (filter_input(INPUT_GET, "position_id_assessor_id"))? filter_input(INPUT_GET, "position_id_assessor_id"):"";
        $sql="1";
        $sql.=!empty($empnum)? " and assessor_id='$empnum'":"";
        $sql.=!empty($assessment_id_assessor_id)? " and assessment_id!='$assessment_id_assessor_id'":"";
        $sql.=!empty($position_id_assessor_id)? " and position_id!='$position_id_assessor_id'":"";
        echo !empty($empnum)? $this->commonajaxfunc('UlsAssessmentPositionAssessor',$validateId,$sql):true;
    }
	
	public function checkassenrollsp(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $empnum= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $assessment_id_assessor_id= (filter_input(INPUT_GET, "assessment_id_assessor"))? filter_input(INPUT_GET, "assessment_id_assessor"):"";
        $position_id_assessor_id= (filter_input(INPUT_GET, "position_id_assessor"))? filter_input(INPUT_GET, "position_id_assessor"):"";
        $sql="1";
        $sql.=!empty($empnum)? " and assessment_pos_assessor_id!='$empnum'":"";
        $sql.=!empty($assessment_id_assessor_id)? " and assessor_id='$assessment_id_assessor_id'":"";
        $sql.=!empty($position_id_assessor_id)? " and position_id='$position_id_assessor_id'":"";
        echo !empty($empnum)? $this->commonajaxfunc('UlsAssessmentPositionAssessor',$validateId,$sql):true;
    }
	
    public function checkmastercode(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $code= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $id= (filter_input(INPUT_GET, "master_id"))? filter_input(INPUT_GET, "master_id"):"";
        $sql="1";
        $sql.=!empty($code)? " and master_code='".$code."'":"";
        $sql.=!empty($id)? " and master_id!='$id'":"";
        echo !empty($code)? $this->commonajaxfunc('UlsAdminMaster',$validateId,$sql):true;
    }    
    public function checkempnumber(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $emp_no= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $id= (filter_input(INPUT_GET, "employee_id"))? filter_input(INPUT_GET, "employee_id"):"";
        $sql="1";
        $sql.=!empty($emp_no)? " and employee_number='".$emp_no."'":"";
        $sql.=!empty($id)? " and employee_id!='$id'":"";
        $parent_org_id=$this->session->userdata('parent_org_id');
		$sql.=!empty($parent_org_id)? " and parent_org_id=".$this->session->userdata('parent_org_id'):"";
        echo !empty($emp_no)? $this->commonajaxfunc('UlsEmployeeMaster',$validateId,$sql):true;
    }
	
	public function checklanguage(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $lang_name= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $id= (filter_input(INPUT_GET, "lang_id"))? filter_input(INPUT_GET, "lang_id"):"";
        $sql="1";
        $sql.=!empty($lang_name)? " and lang_name='".$lang_name."'":"";
        $sql.=!empty($id)? " and lang_id!='$id'":"";
        $parent_org_id=$this->session->userdata('parent_org_id');
		$sql.=!empty($parent_org_id)? " and parent_org_id=".$this->session->userdata('parent_org_id'):"";
        echo !empty($lang_name)? $this->commonajaxfunc('UlsLanguageMaster',$validateId,$sql):true;
    }
	
	public function checkvennumber(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $emp_no= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $id= (filter_input(INPUT_GET, "vendor_id"))? filter_input(INPUT_GET, "vendor_id"):"";
        $sql="1";
        $sql.=!empty($emp_no)? " and vendor_code='".$emp_no."'":"";
        $sql.=!empty($id)? " and vendor_id!='$id'":"";
        $parent_org_id=$this->session->userdata('parent_org_id');
		$sql.=!empty($parent_org_id)? " and parent_org_id=".$this->session->userdata('parent_org_id'):"";
        echo !empty($emp_no)? $this->commonajaxfunc('UlsVendorWorkInfo',$validateId,$sql):true;
    }
	public function checkvenmobilenumber(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $emp_no= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $id= (filter_input(INPUT_GET, "vendor_id"))? filter_input(INPUT_GET, "vendor_id"):"";
        $sql="1";
        $sql.=!empty($emp_no)? " and vendor_mobile_no='".$emp_no."'":"";
        $sql.=!empty($id)? " and vendor_id!='$id'":"";
        $parent_org_id=$this->session->userdata('parent_org_id');
		$sql.=!empty($parent_org_id)? " and parent_org_id=".$this->session->userdata('parent_org_id'):"";
        echo !empty($emp_no)? $this->commonajaxfunc('UlsVendorWorkInfo',$validateId,$sql):true;
    }
	public function checkmennumber(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $emp_no= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $id= (filter_input(INPUT_GET, "mason_id"))? filter_input(INPUT_GET, "mason_id"):"";
        $sql="1";
        $sql.=!empty($emp_no)? " and mason_mobile_no='".$emp_no."'":"";
        $sql.=!empty($id)? " and mason_id!='$id'":"";
        $parent_org_id=$this->session->userdata('parent_org_id');
		$sql.=!empty($parent_org_id)? " and parent_org_id=".$this->session->userdata('parent_org_id'):"";
        echo !empty($emp_no)? $this->commonajaxfunc('UlsVendorMasonDetails',$validateId,$sql):true;
    }
	
	public function checkempnumberadmin(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $emp_no= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $id= (filter_input(INPUT_GET, "employee_id"))? filter_input(INPUT_GET, "employee_id"):"";
        $sql="1";
        $sql.=!empty($emp_no)? " and employee_number='".$emp_no."'":"";
        $sql.=!empty($id)? " and employee_id!='$id'":"";
        $parent_org_id=$this->session->userdata('parent_org_id');
		$sql.=!empty($parent_org_id)? " and parent_org_id=".$this->session->userdata('parent_org_id'):"";
        echo !empty($emp_no)? $this->commonajaxfunc('UlsEmployeeMaster',$validateId,$sql):true;
    }
	
    public function orgname(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $org_name= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $id= (filter_input(INPUT_GET, "org_id"))? filter_input(INPUT_GET, "org_id"):"";
		$pid= (filter_input(INPUT_GET, "parent_org_id"))? filter_input(INPUT_GET, "parent_org_id"):"";
		$org_type= (filter_input(INPUT_GET, "org_type"))? filter_input(INPUT_GET, "org_type"):"";
        $sql="1";
        $sql.=!empty($org_name)? " and org_name='".$org_name."'":"";
        $sql.=!empty($id)? " and organization_id!='$id'":"";
		$sql.=!empty($pid)? " and parent_org_id='$pid'":"";
		$sql.=!empty($org_type)? " and org_type='$org_type'":"";
		$parent_org_id=$this->session->userdata('parent_org_id');
        $sql.=($_SESSION['username']=='unitol_admin' && $this->session->userdata('parent_org_id')!=1)?(!empty($parent_org_id))? " and parent_org_id=".$this->session->userdata('parent_org_id'):"":"";
        echo !empty($org_name)? $this->commonajaxfunc('UlsOrganizationMaster',$validateId,$sql):true;
    }
	
	public function orgnametype(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $org_type= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $id= (filter_input(INPUT_GET, "org_id"))? filter_input(INPUT_GET, "org_id"):"";
		$pid= (filter_input(INPUT_GET, "parent_org_id"))? filter_input(INPUT_GET, "parent_org_id"):"";
		$org_name= (filter_input(INPUT_GET, "org_name"))? filter_input(INPUT_GET, "org_name"):"";
        $sql="1";
        $sql.=!empty($org_name)? " and org_name='".$org_name."'":"";
        $sql.=!empty($id)? " and organization_id!='$id'":"";
		$sql.=!empty($pid)? " and parent_org_id='$pid'":"";
		$sql.=!empty($org_type)? " and org_type='$org_type'":"";
        $parent_org_id=$this->session->userdata('parent_org_id');
        $sql.=($_SESSION['username']=='unitol_admin' && $this->session->userdata('parent_org_id')!=1)?(!empty($parent_org_id))? " and parent_org_id=".$this->session->userdata('parent_org_id'):"":"";
        echo !empty($org_name)? $this->commonajaxfunc('UlsOrganizationMaster',$validateId,$sql):true;
    }
    public function checkmastertitle(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $title= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $id= (filter_input(INPUT_GET, "master_id"))? filter_input(INPUT_GET, "master_id"):"";
        $sql="1";
        $sql.=!empty($title)? " and master_title='".$title."'":"";
        $sql.=!empty($id)? " and master_id!='$id'":"";
        echo !empty($title)? $this->commonajaxfunc('UlsAdminMaster',$validateId,$sql):true;
        
    }
    
    public function checkvaluecode(){
        if(isset($_REQUEST['code'])){
            $name=$_REQUEST['code'];
        }
        if(!empty($name)){
            $user=Doctrine_Query::create()->from('UlsAdminValues')->where("value_code='".$name."'")->execute();
            //$user=Doctrine::getTable('UlsCompetency')->findOnebyCompetency_Name($name);
            $valid = 'true';
            if(count($user)>0){
                $valid = 'false';
            }
            echo $valid;
        }
    }
	
    private function commonajaxfunc($table="",$validateId="", $sql=""){
		//header('Content-Type: application/json');
        //echo $table.$validateId.$sql;
        $arrayToJs = array();
        $arrayToJs[0] = $validateId;
        $query=Doctrine_Query::create()->from($table)->where($sql)->execute();
		$arrayToJs[1]=count($query)>0 ? false:true;
		//$arrayToJs[2]=count($query)>0 ? "Already Exist":"Valid";
        return json_encode($arrayToJs);
    }
	
    public function checkmenuname(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $name= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $id= (filter_input(INPUT_GET, "menu_creation_id"))? filter_input(INPUT_GET, "menu_creation_id"):"";
        $sql="1";
        $sql.=!empty($name)? " and menu_name='".$name."'":"";
        $sql.=!empty($id)? " and menu_creation_id!='$id'":"";
        echo !empty($name)? $this->commonajaxfunc('UlsMenuCreation',$validateId,$sql):true;
        /*$user=Doctrine_Query::create()->from('UlsMenuCreation')->where("Menu_Name='".$name."'".$sql)->execute();             
        $valid =count($user)>0 ? 'false':'true';
        echo $valid;*/
    }
	
    public function checkrolename(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $name= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $id= (filter_input(INPUT_GET, "Role_Id"))? filter_input(INPUT_GET, "Role_Id"):"";
        $sql="1";
        $sql.=!empty($name)? " and role_name='".$name."'":"";
        $sql.=!empty($id)? " and role_id!='$id'":"";
        echo !empty($name)? $this->commonajaxfunc('UlsRoleCreation',$validateId,$sql):true;
    }
    
    public function checkrolecode(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $code= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $id= (filter_input(INPUT_GET, "Role_Id"))? filter_input(INPUT_GET, "Role_Id"):"";
        $sql="1";
        $sql.=!empty($code)? " and role_code='".$code."'":"";
        $sql.=!empty($id)? " and role_id!='$id'":"";
        echo !empty($code)? $this->commonajaxfunc('UlsRoleCreation',$validateId,$sql):true;
    }
	
	public function empexitsforrole(){
	    $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $number= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
         $id= (filter_input(INPUT_GET, "roles"))? filter_input(INPUT_GET, "roles"):"";
		//$porg= (filter_input(INPUT_GET, "porg"))? filter_input(INPUT_GET, "porg"):"";
		
        $sql="1";
        $sql.=!empty($id)? " and wf_role_id!='".$id."'":"";
		$sql.=!empty($number)? " and number='".$number."'":"";
       //$sql.=!empty($porg)? " and parent_org_id!='$porg'":"";
        echo !empty($code)? $this->commonajaxfunc('UlsWfRoleValues',$validateId,$sql):true;
	  
	
	 
	 }
    
    public function checkbudgetnamename(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $name= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $id= (filter_input(INPUT_GET, "budget_id"))? filter_input(INPUT_GET, "budget_id"):"";
        $parent_org_id=$this->session->userdata('parent_org_id');
		$sql.=!empty($parent_org_id)? " and parent_org_id=".$this->session->userdata('parent_org_id'):"";
        $sql="1";
        $sql.=!empty($name)? " and budget_name='".$name."'":"";
        $sql.=!empty($id)? " and budget_id!='$id'":"";
        $sql.=!empty($parent_org_id)? " and parent_org_id='$parent_org_id'":"";
        echo !empty($name)? $this->commonajaxfunc('UlsBudgetNameDefinition',$validateId,$sql):true;
    }
    
    public function checkcalendarname(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $name= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $id= (filter_input(INPUT_GET, "calendar_id"))? filter_input(INPUT_GET, "calendar_id"):"";
		$parent_org_ids=$this->session->userdata('parent_org_id');
        $parent_org_id= !empty($parent_org_ids)? $this->session->userdata('parent_org_id'): "";
        $sql="1";
        $sql.=!empty($name)? " and calendar_name='".$name."'":"";
        $sql.=!empty($id)? " and calendar_id!='$id'":"";
        $sql.=!empty($parent_org_id)? " and parent_org_id='$parent_org_id'":"";
        echo !empty($name)? $this->commonajaxfunc('UlsCalendarName',$validateId,$sql):true;
    }
	
	public function checkzone_exist(){
		$validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $zone_name= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $zone_id= (filter_input(INPUT_GET, "zone_id"))? filter_input(INPUT_GET, "zone_id"):"";
        $parent_org_ids=$this->session->userdata('parent_org_id');
        $parent_org_id= !empty($parent_org_ids)? $this->session->userdata('parent_org_id'): "";
        $sql="1";
        $sql.=!empty($zone_name)? " and zone_name='".$zone_name."'":"";
        $sql.=!empty($parent_org_id)? " and parent_org_id='".$parent_org_id."'":"";
        $sql.=!empty($zone_id)? " and zone_id!='$zone_id'":"";
        echo $this->commonajaxfunc('UlsZone',$validateId,$sql);
	}
    
    public function checklocation_exist(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $location_name= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        //$city= (filter_input(INPUT_GET, "city"))? filter_input(INPUT_GET, "city"):"";
        $location_id= (filter_input(INPUT_GET, "location_id"))? filter_input(INPUT_GET, "location_id"):"";
		$parent_org_ids=$this->session->userdata('parent_org_id');
        $parent_org_id= !empty($parent_org_ids)? $this->session->userdata('parent_org_id'): "";
        $sql="1";
        $sql.=!empty($location_name)? " and location_name='".$location_name."'":"";
        //$sql.=!empty($city)? " and city='".$city."'":"";
        $sql.=!empty($parent_org_id)? " and parent_org_id='".$parent_org_id."'":"";
        $sql.=!empty($location_id)? " and location_id!='$location_id'":"";
        echo $this->commonajaxfunc('UlsLocation',$validateId,$sql);
    }
	
	public function checkeventrestrict_exist(){
		$validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $event_id= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $program_id= (filter_input(INPUT_GET, "program_id"))? filter_input(INPUT_GET, "program_id"):"";
		$restriction_id=(filter_input(INPUT_GET, "restriction_id"))? filter_input(INPUT_GET, "restriction_id"):"";
        $parent_org_ids=$this->session->userdata('parent_org_id');
        $parent_org_id= !empty($parent_org_ids)? $this->session->userdata('parent_org_id'): "";
        $sql="1";
        $sql.=!empty($event_id)? " and event_id='".$event_id."'":"";
        $sql.=!empty($parent_org_id)? " and parent_org_id='".$parent_org_id."'":"";
        $sql.=!empty($program_id)? " and program_id='$program_id'":"";
		 $sql.=!empty($restriction_id)? " and restriction_id!='$restriction_id'":"";
        echo $this->commonajaxfunc('UlsAdminEventRestriction',$validateId,$sql);
	}
	
    public function checkgrade_exist(){	
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $grade_name= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $grade_id= (filter_input(INPUT_GET, "grade_id"))? filter_input(INPUT_GET, "grade_id"):"";
        $parent_org_ids=$this->session->userdata('parent_org_id');
        $parent_org_id= !empty($parent_org_ids)? $this->session->userdata('parent_org_id'): "";
        $sql="1";
        $sql.=!empty($grade_name)? " and grade_name='".$grade_name."'":"";
        $sql.=!empty($parent_org_id)? " and parent_org_id='".$parent_org_id."'":"";
        $sql.=!empty($grade_id)? " and grade_id!='$grade_id'":"";
        echo $this->commonajaxfunc('UlsGrade',$validateId,$sql);
    }
	
	public function checksubgrade_exist(){	
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $subgrade_name= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $subgrade_id= (filter_input(INPUT_GET, "subgrade_id"))? filter_input(INPUT_GET, "subgrade_id"):"";
        $parent_org_ids=$this->session->userdata('parent_org_id');
        $parent_org_id= !empty($parent_org_ids)? $this->session->userdata('parent_org_id'): "";
        $sql="1";
        $sql.=!empty($subgrade_name)? " and subgrade_name='".$subgrade_name."'":"";
        $sql.=!empty($parent_org_id)? " and parent_org_id='".$parent_org_id."'":"";
        $sql.=!empty($subgrade_id)? " and subgrade_id!='$subgrade_id'":"";
        echo $this->commonajaxfunc('UlsSubgrade',$validateId,$sql);
    }
	
	public function checkemptype_exist(){	
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $emp_type_name= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $emp_type_id= (filter_input(INPUT_GET, "emp_type_id"))? filter_input(INPUT_GET, "emp_type_id"):"";
        $parent_org_ids=$this->session->userdata('parent_org_id');
        $parent_org_id= !empty($parent_org_ids)? $this->session->userdata('parent_org_id'): "";
        $sql="1";
        $sql.=!empty($emp_type_name)? " and emp_type_name='".$emp_type_name."'":"";
        $sql.=!empty($parent_org_id)? " and parent_org_id='".$parent_org_id."'":"";
        $sql.=!empty($emp_type_id)? " and emp_type_id!='$emp_type_id'":"";
        echo $this->commonajaxfunc('UlsEmployeeType',$validateId,$sql);
    }
	
	public function checklevel_exist(){	
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $level_name= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $level_id= (filter_input(INPUT_GET, "level_id"))? filter_input(INPUT_GET, "level_id"):"";
		$parent_org_ids=$this->session->userdata('parent_org_id');
        $parent_org_id= !empty($parent_org_ids)? $this->session->userdata('parent_org_id'): "";
        $sql="1";
        $sql.=!empty($level_name)? " and level_name='".$level_name."'":"";
        $sql.=!empty($parent_org_id)? " and parent_org_id='".$parent_org_id."'":"";
        $sql.=!empty($level_id)? " and level_id!='$level_id'":"";
        echo $this->commonajaxfunc('UlsLevelMaster',$validateId,$sql);
    }
	
    public function checkusername(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $user_name= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $user_id= (filter_input(INPUT_GET, "user_id"))? filter_input(INPUT_GET, "user_id"):"";
        $parent_org_ids=$this->session->userdata('parent_org_id');
        $parent_org_id= !empty($parent_org_ids)? $this->session->userdata('parent_org_id'): "";
        $sql="1";
        $sql.=!empty($user_name)? " and user_name='".$user_name."'":"";
        $sql.=!empty($user_id)? " and user_id!='$user_id'":"";		
        $sql.=!empty($parent_org_id)? " and parent_org_id='".$parent_org_id."'":"";
        echo $this->commonajaxfunc('UlsUserCreation',$validateId,$sql);
    }
	
    public function checkresource(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $user_name= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $resource_def_id= (filter_input(INPUT_GET, "resource_def_id"))? filter_input(INPUT_GET, "resource_def_id"):"";
        $parent_org_ids=$this->session->userdata('parent_org_id');
        $parent_org_id= !empty($parent_org_ids)? $this->session->userdata('parent_org_id'): "";
        $sql="1";
        $sql.=!empty($user_name)? " and column1='".trim($user_name)."'":"";
        $sql.=!empty($resource_def_id)? " and resource_def_id!='$resource_def_id'":"";		
        $sql.=!empty($parent_org_id)? " and parent_org_id='".$parent_org_id."'":"";
        echo $this->commonajaxfunc('UlsResourceDefinition',$validateId,$sql);
    }
	
	public function checktrainerresource(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $user_name= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $res_trainer_id= (filter_input(INPUT_GET, "res_trainer_id"))? filter_input(INPUT_GET, "res_trainer_id"):"";
        $parent_org_ids=$this->session->userdata('parent_org_id');
        $parent_org_id= !empty($parent_org_ids)? $this->session->userdata('parent_org_id'): "";
        $sql="1";
        $sql.=!empty($user_name)? " and name='".trim($user_name)."'":"";
        $sql.=!empty($res_trainer_id)? " and res_trainer_id!='$res_trainer_id'":"";		
        $sql.=!empty($parent_org_id)? " and parent_org_id='".$parent_org_id."'":"";
        echo $this->commonajaxfunc('UlsResourceTrainer',$validateId,$sql);
    }
	
    public function checkuseremail(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $email_address= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $user_id= (filter_input(INPUT_GET, "user_id"))? filter_input(INPUT_GET, "user_id"):"";
        $sql="1";
        $sql.=!empty($email_address)? " and email_address='".$email_address."'":"";
        $sql.=!empty($user_id)? " and user_id!='$user_id'":"";
        echo $this->commonajaxfunc('UlsUserCreation',$validateId,$sql);
    }
	
	
    public function checkprogramexist(){
        if(isset($_REQUEST['program_name'])){
            $name=trim($_REQUEST['program_name']);
        }
        if(isset($_REQUEST['proid'])){
            $proid=trim($_REQUEST['proid']);
        }
        $user=Doctrine_Query::create()->from('UlsProgramPrerequisites')->where("program_id='".$proid)->execute();
        $valid = 'true';
        if(count($user)>0){
            $valid = 'false';
        }
        echo $valid;
     }
 
    public function checkprogram_name_exist(){
		$validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $pro_name= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $prg_id= (filter_input(INPUT_GET, "pro_id"))? filter_input(INPUT_GET, "pro_id"):"";
        $cat_id= (filter_input(INPUT_GET, "category"))? filter_input(INPUT_GET, "category"):"";
        $parent_org_ids=$this->session->userdata('parent_org_id');
        $parent_org_id= !empty($parent_org_ids)? $this->session->userdata('parent_org_id'): "";
        $sql="1";
        $sql.=!empty($pro_name)? " and program_name='".$pro_name."'":"";
        $sql.=!empty($cat_id)? " and category_id='".$cat_id."'":"";
        $sql.=!empty($prg_id)? " and program_id!='$prg_id'":"";
        $sql.=!empty($parent_org_id)? " and parent_org_id='".$parent_org_id."'":"";
        echo $this->commonajaxfunc('UlsProgram',$validateId,$sql);
    }
    public function checkprogram_learner_comp(){
		$validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $level_name= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $prg_id= (filter_input(INPUT_GET, "program_id"))? filter_input(INPUT_GET, "program_id"):"";
        $cmp_id= (filter_input(INPUT_GET, "competency_id"))? filter_input(INPUT_GET, "competency_id"):"";
		$prg_learner_id= (filter_input(INPUT_GET, "prg_learner_id"))? filter_input(INPUT_GET, "prg_learner_id"):"";
        $parent_org_ids=$this->session->userdata('parent_org_id');
        $parent_org_id= !empty($parent_org_ids)? $this->session->userdata('parent_org_id'): "";
        $sql="1";
        $sql.=!empty($prg_id)? " and program_id='".$prg_id."'":"";
        $sql.=!empty($cmp_id)? " and competency_id='".$cmp_id."'":"";
		$sql.=!empty($level_name)? " and competency_level_id='".$level_name."'":"";
        $sql.=!empty($prg_learner_id)? " and prg_learner_id!='$prg_learner_id'":"";
        $sql.=!empty($parent_org_id)? " and parent_org_id='".$parent_org_id."'":"";
        echo $this->commonajaxfunc('UlsProgramLearnerCompetency',$validateId,$sql);
    }
    
    public function checktest_exist(){		
        if(isset($_REQUEST['test_name'])){
            $name=trim($_REQUEST['test_name']);
        }
        if(isset($_REQUEST['test_type'])){
            $test_type=trim($_REQUEST['test_type']);
        }
        if(isset($_REQUEST['event_id'])){
            $event_id=trim($_REQUEST['event_id']);
        }
        $user=Doctrine_Query::create()->from('UlsEventsEvaluation')->where("test_id=".$name. " and evaluation_type='$test_type'")->andwhere("event_id=".$event_id)->execute();
        $valid = 'true';
        if(count($user)>0){
            $valid = 'false';
        }
        echo $valid;
    }
	
    public function checkposition_exist(){
		header('Content-Type: application/json');
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $position_name= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        //$position_org_id= (filter_input(INPUT_GET, "position_org_id"))? filter_input(INPUT_GET, "position_org_id"):"";
        $pos_id= (filter_input(INPUT_GET, "pos_id"))? filter_input(INPUT_GET, "pos_id"):"";
        $parent_org_ids=$this->session->userdata('parent_org_id');
        $parent_org_id= !empty($parent_org_ids)? $this->session->userdata('parent_org_id'): "";
        $sql="1";
        $sql.=!empty($position_name)? " and position_name='".$position_name."'":"";
        //$sql.=!empty($position_org_id)? " and position_org_id='".$position_org_id."'":"";
        $sql.=!empty($parent_org_id)? " and parent_org_id='".$parent_org_id."'":"";
        $sql.=!empty($pos_id)? " and position_id!='$pos_id'":"";
        echo $this->commonajaxfunc('UlsPosition',$validateId,$sql);
    }
	
	public function checkcasestudy_exist(){
		header('Content-Type: application/json');
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $casestudy_name= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        //$position_org_id= (filter_input(INPUT_GET, "position_org_id"))? filter_input(INPUT_GET, "position_org_id"):"";
        $casestudy_id= (filter_input(INPUT_GET, "casestudy_id"))? filter_input(INPUT_GET, "casestudy_id"):"";
        $parent_org_ids=$this->session->userdata('parent_org_id');
        $parent_org_id= !empty($parent_org_ids)? $this->session->userdata('parent_org_id'): "";
        $sql="1";
        $sql.=!empty($casestudy_name)? " and casestudy_name='".$casestudy_name."'":"";
        //$sql.=!empty($position_org_id)? " and position_org_id='".$position_org_id."'":"";
        $sql.=!empty($parent_org_id)? " and parent_org_id='".$parent_org_id."'":"";
        $sql.=!empty($casestudy_id)? " and casestudy_id!='$casestudy_id'":"";
        echo $this->commonajaxfunc('UlsCaseStudyMaster',$validateId,$sql);
    }
	
	public function checkindicator_exist(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $indicator_name= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        //$position_org_id= (filter_input(INPUT_GET, "position_org_id"))? filter_input(INPUT_GET, "position_org_id"):"";
        $ind_master_id= (filter_input(INPUT_GET, "ind_master_id"))? filter_input(INPUT_GET, "ind_master_id"):"";
        $parent_org_ids=$this->session->userdata('parent_org_id');
        $parent_org_id= !empty($parent_org_ids)? $this->session->userdata('parent_org_id'): "";
        $sql="1";
        $sql.=!empty($indicator_name)? " and ind_master_name='".$indicator_name."'":"";
        //$sql.=!empty($position_org_id)? " and position_org_id='".$position_org_id."'":"";
        $sql.=!empty($parent_org_id)? " and parent_org_id='".$parent_org_id."'":"";
        $sql.=!empty($ind_master_id)? " and ind_master_id!='$ind_master_id'":"";
        echo $this->commonajaxfunc('UlsCompetencyLevelIndicatorMaster',$validateId,$sql);
    }
    
    private function commonajaxfunc2($table="",$params=array()){
        $sql="1";
        foreach($params as $val=>$k){
            $kval=explode("_",$k);
            $key=$val;
            $$key="";
            $not=($kval[1]=='pri')?"!":"";
            if($kval[0]=='g'){
                $$key= (filter_input(INPUT_GET, $val))? filter_input(INPUT_GET, $val):""; 
            }
            elseif($kval[0]=='p'){
                $$key= (filter_input(INPUT_POST, $val))? filter_input(INPUT_POST, $val):""; 
            }
            elseif($kval[0]=='s'){
                $$key= isset($_SESSION[$val])? $_SESSION[$val]: "";
            }
            //($key!="fieldId" && $key!="fieldValue" )?(!empty($$key)? $sql.=" and $key $not='".$$key."'":""):($key=="fieldValue" )?(!empty($$key)? $sql.=" and $fieldId  $not ='".$$key."'":""):"";
           if($key!="fieldId" && $key!="fieldValue"){
               if(!empty($$key)){
                   $sql.=" and $key $not='".$$key."'";
               }
           }
           elseif($key=="fieldValue"){
               if(!empty($$key)){
                   $sql.=" and $fieldId $not='".$$key."'";
               }
           }
        }
        //echo $sql;
        $arrayToJs = array();
        $arrayToJs[0] = $fieldId;
        $query=Doctrine_Query::create()->from($table)->where($sql)->execute();             
        $arrayToJs[1]=count($query)>0 ? false:true;
        return json_encode($arrayToJs);
    }
    
    public function checkcomname(){
        $arrayfield=array("fieldId"=>'g_not',"fieldValue"=>'g_not',"competency_id"=>'g_pri',"parent_org_id"=>'s_not');
        echo $this->commonajaxfunc2('UlsCompetency',$arrayfield);
    }
    
    public function checklevelcode(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $level_value= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $competency_type= (filter_input(INPUT_GET, "competency_type"))? filter_input(INPUT_GET, "competency_type"):"";
        $competency_name=(filter_input(INPUT_GET, "competency_name"))? filter_input(INPUT_GET, "competency_name"):"";
        $competency_id= (filter_input(INPUT_GET, "competency_id"))? filter_input(INPUT_GET, "competency_id"):"";
        $parent_org_ids=$this->session->userdata('parent_org_id');
        $parent_org_id= !empty($parent_org_ids)? $this->session->userdata('parent_org_id'): "";
        $sql="1 and a.competency_id = b.competency_id";
        $sql.=!empty($competency_name)? " and b.competency_name='".$competency_name."'":"";
        $sql.=!empty($competency_type)? " and b.competency_type='".$competency_type."'":"";
        $sql.=!empty($level_value)? " and a.level_value='".$level_value."'":"";
        $sql.=!empty($parent_org_id)? " and parent_org_id='".$parent_org_id."'":"";
        $sql.=!empty($competency_id)? " and competency_id!='$competency_id'":"";
        echo $this->commonajaxfunc('UlsCompetencyLevels a, UlsCompetency b',$validateId,$sql);
    }
    
    public function checklevelname(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $level_name= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $competency_type= (filter_input(INPUT_GET, "competency_type"))? filter_input(INPUT_GET, "competency_type"):"";
        $competency_name=(filter_input(INPUT_GET, "competency_name"))? filter_input(INPUT_GET, "competency_name"):"";
        $competency_id= (filter_input(INPUT_GET, "competency_id"))? filter_input(INPUT_GET, "competency_id"):"";
        $parent_org_ids=$this->session->userdata('parent_org_id');
        $parent_org_id= !empty($parent_org_ids)? $this->session->userdata('parent_org_id'): "";
        $sql="1 and a.competency_id = b.competency_id";
        $sql.=!empty($competency_name)? " and b.competency_name='".$competency_name."'":"";
        $sql.=!empty($competency_type)? " and b.competency_type='".$competency_type."'":"";
        $sql.=!empty($level_name)? " and a.level_name='".$level_name."'":"";
        $sql.=!empty($parent_org_id)? " and parent_org_id='".$parent_org_id."'":"";
        $sql.=!empty($competency_id)? " and competency_id!='$competency_id'":"";
        echo $this->commonajaxfunc('UlsCompetencyLevels a, UlsCompetency b',$validateId,$sql);
    }
	
	public function check_zone_map(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $level_name= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $zone_id= (filter_input(INPUT_GET, "zone_id"))? filter_input(INPUT_GET, "zone_id"):"";
        $state_id=(filter_input(INPUT_GET, "state_id"))? filter_input(INPUT_GET, "state_id"):"";
        $parent_org_ids=$this->session->userdata('parent_org_id');
        $parent_org_id= !empty($parent_org_ids)? $this->session->userdata('parent_org_id'): "";
        $sql=!empty($zone_id)? " a.zone_id='".$zone_id."'":"";
        $sql.=!empty($state_id)? " and a.state_id='".$state_id."'":"";
        echo $this->commonajaxfunc('UlsZoneMap a',$validateId,$sql);
    }
	
    public function checkcomcodeed(){
        if(isset($_REQUEST['level_code_edit'])){
                $level_code=trim($_REQUEST['level_code_edit']);
        }
        if(isset($_REQUEST['comp_name'])){
                $comp_name=trim($_REQUEST['comp_name']);
        }
        if(isset($_REQUEST['comp_type'])){
                $comp_type=trim($_REQUEST['comp_type']);
        }
        $competency=Doctrine_Query::create()->from('UlsCompetency')->where("competency_name='".$comp_name."' and competency_type='".$comp_type."'")->fetchOne();
        $valid = 'true';
        if(isset($competency->competency_id)){
            $competencylevel=Doctrine_Query::create()->from('UlsCompetencyLevels')->where("competency_id=".$competency->competency_id." and level_value='".$level_code."'")->execute();
            $valid = 'true';
            if(count($competencylevel)>0){
                $valid = 'false';
            }
        }
        echo $valid;
    }
	
    public function checkcomcode(){
        if(isset($_REQUEST['level_code'])){
            $level_code=trim($_REQUEST['level_code']);
        }
        if(isset($_REQUEST['comp_name'])){
            $comp_name=trim($_REQUEST['comp_name']);
        }
        if(isset($_REQUEST['comp_type'])){
            $comp_type=trim($_REQUEST['comp_type']);
        }
        $competency=Doctrine_Query::create()->from('UlsCompetency')->where("competency_name='".$comp_name."' and competency_type='".$comp_type."'")->fetchOne();
        $valid = 'true';
        if(isset($competency->competency_id)){
            $competencylevel=Doctrine_Query::create()->from('UlsCompetencyLevels')->where("competency_id=".$competency->competency_id." and level_value='".$level_code."'")->execute();
            $valid = 'true';
            if(count($competencylevel)>0){
                $valid = 'false';
            }
        }
        echo $valid;
    }
	
    public function checkcomcode1(){
        if(isset($_REQUEST['level_code'])){
            $level_code=trim($_REQUEST['level_code']);
        }
        if(isset($_REQUEST['comp_name'])){
            $comp_name=trim($_REQUEST['comp_name']);
        }
        if(isset($_REQUEST['comp_type'])){
            $comp_type=trim($_REQUEST['comp_type']);
        }
        $competency=Doctrine_Query::create()->from('UlsCompetency')->where("competency_name='".$comp_name."' and competency_type='".$comp_type."'")->fetchOne();
        $valid = 'true';
        if(isset($competency->competency_id)){
            $competencylevel=Doctrine_Query::create()->from('UlsCompetencyLevels')->where("competency_id=".$competency->competency_id." and level_value='".$level_code."'")->execute();
            $valid = 'true';
            if(count($competencylevel)>0){
                $valid = 'false';
            }
        }
        echo $valid;
    }
	
    public function checkcomcode2(){
        if(isset($_REQUEST['level_code'])){
                $level_code=trim($_REQUEST['level_code']);
        }
        if(isset($_REQUEST['comp_name'])){
                $comp_name=trim($_REQUEST['comp_name']);
        }
        if(isset($_REQUEST['comp_type'])){
                $comp_type=trim($_REQUEST['comp_type']);
        }
        $competency=Doctrine_Query::create()->from('UlsCompetency')->where("competency_name='".$comp_name."' and competency_type='".$comp_type."'")->fetchOne();
        $valid = 'true';
        if(isset($competency->competency_id)){
            $competencylevel=Doctrine_Query::create()->from('UlsCompetencyLevels')->where("competency_id=".$competency->competency_id." and level_value='".$level_code."'")->execute();
            $valid = 'true';
            if(count($competencylevel)>0){
                $valid = 'false';
            }
        }
        echo $valid;
    }
	
    public function checkcomcode3(){
        if(isset($_REQUEST['level_code'])){
                $level_code=trim($_REQUEST['level_code']);
        }
        if(isset($_REQUEST['comp_name'])){
                $comp_name=trim($_REQUEST['comp_name']);
        }
        if(isset($_REQUEST['comp_type'])){
                $comp_type=trim($_REQUEST['comp_type']);
        }
        $competency=Doctrine_Query::create()->from('UlsCompetency')->where("competency_name='".$comp_name."' and competency_type='".$comp_type."'")->fetchOne();
        $valid = 'true';
        if(isset($competency->competency_id)){
            $competencylevel=Doctrine_Query::create()->from('UlsCompetencyLevels')->where("competency_id=".$competency->competency_id." and level_value='".$level_code."'")->execute();
            $valid = 'true';
            if(count($competencylevel)>0){
                    $valid = 'false';
            }
        }
        echo $valid;
    }
	
	public function wfprocessname_exist(){             
              $arrayfield=array("fieldId"=>'g_not',"fieldValue"=>'g_not',"process_id"=>'g_pri');
        echo $this->commonajaxfunc2('UlsWfProcess',$arrayfield);
        }
        
        public function wfuserprocessname_exist(){             
              $arrayfield=array("fieldId"=>'g_not',"fieldValue"=>'g_not',"process_id"=>'g_pri');
        echo $this->commonajaxfunc2('UlsWfProcess',$arrayfield);
        }
       
        public function wfrolename_exist(){             
              $arrayfield=array("fieldId"=>'g_not',"fieldValue"=>'g_not',"wf_role_id"=>'g_pri');
        echo $this->commonajaxfunc2('UlsWfRoleDefinition',$arrayfield);
        }
        
        public function wf_groupname_exist(){
            $arrayfield=array("fieldId"=>'g_not',"fieldValue"=>'g_not',"approver_group_id"=>'g_pri');
        echo $this->commonajaxfunc2('UlsWfApproverGroups',$arrayfield);
            
        }
        
        public function report_name_exist(){
            $arrayfield=array("fieldId"=>'g_not',"fieldValue"=>'g_not',"report_id"=>'g_pri');
			echo $this->commonajaxfunc2('UlsReports',$arrayfield);
            
        }
		
		
        
          public function report_groupname_exist(){
            $arrayfield=array("fieldId"=>'g_not',"fieldValue"=>'g_not',"report_group_id"=>'g_pri');
        echo $this->commonajaxfunc2('UlsReportGroups',$arrayfield);
            
        }

        public function checkcomcode4(){
        if(isset($_REQUEST['level_code'])){
                $level_code=trim($_REQUEST['level_code']);
        }
        if(isset($_REQUEST['comp_name'])){
                $comp_name=trim($_REQUEST['comp_name']);
        }
        if(isset($_REQUEST['comp_type'])){
                $comp_type=trim($_REQUEST['comp_type']);
        }
        $competency=Doctrine_Query::create()->from('UlsCompetency')->where("competency_name='".$comp_name."' and competency_type='".$comp_type."'")->fetchOne();
        $valid = 'true';
        if(isset($competency->competency_id)){
            $competencylevel=Doctrine_Query::create()->from('UlsCompetencyLevels')->where("competency_id=".$competency->competency_id." and level_value='".$level_code."'")->execute();
            $valid = 'true';
            if(count($competencylevel)>0){
                $valid = 'false';
            }
        }
        echo $valid;
    }
    
    public function checkname(){
        if(isset($_REQUEST['level_name'])){
                $level_name=$_REQUEST['level_name'];
        }	

        if(isset($_REQUEST['comp_name'])){
                $comp_name=trim($_REQUEST['comp_name']);
        }
        if(isset($_REQUEST['comp_type'])){
                $comp_type=trim($_REQUEST['comp_type']);
        }

        $competency=Doctrine_Query::create()->from('UlsCompetency')->where("competency_name='".$comp_name."' and competency_type='".$comp_type."'")->fetchOne();
        $valid = 'true';
        if(isset($competency->competency_id)){
            $competencylevel=Doctrine_Query::create()->from('UlsCompetencyLevels')->where("competency_id=".$competency->competency_id." and level_name='".$level_name."'")->execute();
            $valid = 'true';
            if(count($competencylevel)>0){
                    $valid = 'false';
            }
        }
        echo $valid;
    }


    public function checkname1(){
        if(isset($_REQUEST['level_name'])){
            $level_name=$_REQUEST['level_name'];
        }	

        if(isset($_REQUEST['comp_name'])){
            $comp_name=trim($_REQUEST['comp_name']);
        }
        if(isset($_REQUEST['comp_type'])){
            $comp_type=trim($_REQUEST['comp_type']);
        }

        $competency=Doctrine_Query::create()->from('UlsCompetency')->where("competency_name='".$comp_name."' and competency_type='".$comp_type."'")->fetchOne();
        $valid = 'true';
        if(isset($competency->competency_id)){
            $competencylevel=Doctrine_Query::create()->from('UlsCompetencyLevels')->where("competency_id=".$competency->competency_id." and level_name='".$level_name."'")->execute();
            $valid = 'true';
            if(count($competencylevel)>0){
                $valid = 'false';
            }
        }
        echo $valid;
    }

    public function checkname2(){
        if(isset($_REQUEST['level_name'])){
            $level_name=$_REQUEST['level_name'];
        }	

        if(isset($_REQUEST['comp_name'])){
            $comp_name=trim($_REQUEST['comp_name']);
        }
        if(isset($_REQUEST['comp_type'])){
            $comp_type=trim($_REQUEST['comp_type']);
        }

        $competency=Doctrine_Query::create()->from('UlsCompetency')->where("competency_name='".$comp_name."' and competency_type='".$comp_type."'")->fetchOne();
        $valid = 'true';
        if(isset($competency->competency_id)){
            $competencylevel=Doctrine_Query::create()->from('UlsCompetencyLevels')->where("competency_id=".$competency->competency_id." and level_name='".$level_name."'")->execute();
            $valid = 'true';
            if(count($competencylevel)>0){
                $valid = 'false';
            }
        }
        echo $valid;
    }
    
    public function checkname3(){
        if(isset($_REQUEST['level_name'])){
            $level_name=$_REQUEST['level_name'];
        }
        		
        if(isset($_REQUEST['comp_name'])){
                $comp_name=trim($_REQUEST['comp_name']);
        }
        if(isset($_REQUEST['comp_type'])){
                $comp_type=trim($_REQUEST['comp_type']);
        }
        
        $competency=Doctrine_Query::create()->from('UlsCompetency')->where("competency_name='".$comp_name."' and competency_type='".$comp_type."'")->fetchOne();
        $valid = 'true';
        if(isset($competency->competency_id)){
            $competencylevel=Doctrine_Query::create()->from('UlsCompetencyLevels')->where("competency_id=".$competency->competency_id." and level_name='".$level_name."'")->execute();
            $valid = 'true';
            if(count($competencylevel)>0){
                $valid = 'false';
            }
        }
        echo $valid;
    }


    public function checkname4(){
        if(isset($_REQUEST['level_name'])){
                $level_name=$_REQUEST['level_name'];
        }
        if(isset($_REQUEST['comp_name'])){
                $comp_name=trim($_REQUEST['comp_name']);
        }
        if(isset($_REQUEST['comp_type'])){
                $comp_type=trim($_REQUEST['comp_type']);
        }
        $competency=Doctrine_Query::create()->from('UlsCompetency')->where("competency_name='".$comp_name."' and competency_type='".$comp_type."'")->fetchOne();
        $valid = 'true';
        if(isset($competency->competency_id)){
            $competencylevel=Doctrine_Query::create()->from('UlsCompetencyLevels')->where("competency_id=".$competency->competency_id." and level_name='".$level_name."'")->execute();
            $valid = 'true';
            if(count($competencylevel)>0){
                    $valid = 'false';
            }
        }
        echo $valid;
    }
    
    
    public  function test_code_exist(){
         $arrayfield=array("fieldId"=>'g_not',"fieldValue"=>'g_not',"test_id"=>'g_pri',"parent_org_id"=>'s_not');
        echo $this->commonajaxfunc2('UlsTest',$arrayfield);        
    }
    public  function test_name_exist(){
         $arrayfield=array("fieldId"=>'g_not',"fieldValue"=>'g_not',"test_id"=>'g_pri',"parent_org_id"=>'s_not');
        echo $this->commonajaxfunc2('UlsTest',$arrayfield);        
    }
    public function test_nameedit_exist(){
          $arrayfield=array("fieldId"=>'g_not',"fieldValue"=>'g_not',"test_id"=>'g_pri',"parent_org_id"=>'s_not');
        echo $this->commonajaxfunc2('UlsTest',$arrayfield);  
    }

    public function notification_name_exist(){
              $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
             $name= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";  
            $nid=(filter_input(INPUT_GET, "notification_id"))? filter_input(INPUT_GET, "notification_id"):"";  
          $sql="1";
          $sql.=!empty($nid)? " and notification_id!='".$nid."'":"";
           $sql.=!empty($name)? " and notification_name='".$name."'":"";
            $arrayToJs = array();
            $arrayToJs[0] = $validateId;
            $query=Doctrine_Query::create()->from('UlsNotification')->where($sql)->execute();             
            $arrayToJs[1]=count($query)>0 ? false:true;
            echo  json_encode($arrayToJs);        
    }
     public function notification_name_exist_parent(){
             $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
             $name= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):""; 
             $nn=explode('-',$name);
        	 		 
			 $nid=(filter_input(INPUT_GET, "notification_id"))? filter_input(INPUT_GET, "notification_id"):"";  
             $parent=(filter_input(INPUT_GET, "porg"))? filter_input(INPUT_GET, "porg"):"";  
			 $sql="1";
             $sql.=!empty($nid)? " and notification_id!=".$nid."":"";
             $sql.=!empty($nn[1])? " and event_type='".$nn[1]."'":"";
			  $sql.=!empty($parent)? " and parent_org_id =".$parent."":"";
            $arrayToJs = array();
            $arrayToJs[0] = $validateId;
            $query=Doctrine_Query::create()->from('UlsNotification')->where($sql)->execute();             
            $arrayToJs[1]=count($query)>0 ? false:true;
            echo  json_encode($arrayToJs);        
    }
     
	 
	  public function checknotifiction_mastercode(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $code= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $id= (filter_input(INPUT_GET, "master_id"))? filter_input(INPUT_GET, "master_id"):"";
        $sql="1";
        $sql.=!empty($code)? " and notification_code='".$code."'":"";
        $sql.=!empty($id)? " and notification_typeid!='$id'":"";
		
        echo !empty($code)? $this->commonajaxfunc('UlsNotificationTypes',$validateId,$sql):true;
    }
	
	
	
	public function checknotification_mastertitle(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $title= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $id= (filter_input(INPUT_GET, "master_id"))? filter_input(INPUT_GET, "master_id"):"";
        $sql="1";
        $sql.=!empty($title)? " and notification_name='".$title."'":"";
        $sql.=!empty($id)? " and notification_typeid!='$id'":"";
        echo !empty($title)? $this->commonajaxfunc('UlsNotificationTypes',$validateId,$sql):true;
     }
	
    
   public function learner_group_exist(){
            $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
             $name= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";           
            $arrayToJs = array();
            $arrayToJs[0] = $validateId;
            $query=Doctrine_Query::create()->from('UlsLnrGroup')->where("lnr_group_name='$name'")->execute();             
            $arrayToJs[1]=count($query)>0 ? false:true;
            echo  json_encode($arrayToJs);        
    }
   public function learner_groupedit_exist(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $lnr_group_name= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $lnr_group_id= (filter_input(INPUT_GET, "gid"))? filter_input(INPUT_GET, "gid"):"";
		$parent_org_ids=$this->session->userdata('parent_org_id');
        $parent_org_id= !empty($parent_org_ids)? $this->session->userdata('parent_org_id'): "";
        $sql="1";
        $sql.=!empty($lnr_group_name)? " and lnr_group_name='".$lnr_group_name."'":"";
        $sql.=!empty($parent_org_id)? " and parent_org_id='".$parent_org_id."'":"";
        $sql.=!empty($lnr_group_id)? " and lnr_group_id!='$lnr_group_id'":"";
        echo $this->commonajaxfunc('UlsLnrGroup',$validateId,$sql);
   }
   public function questionbankquestion_exist(){ 
           $arrayfield=array("fieldId"=>'g_not',"fieldValue"=>'g_not',"question_bank_id"=>'g_not',"question_id"=>'g_pri',"parent_org_id"=>'s_not');
        echo $this->commonajaxfunc2('UlsQuestions',$arrayfield);
            
    } 
     
	 
    
    public function questionbank_nameedit_exist(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $quest_bank_name= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $quest_bank_id= (filter_input(INPUT_GET, "questionbank_id"))? filter_input(INPUT_GET, "questionbank_id"):"";
        $parent_org_ids=$this->session->userdata('parent_org_id');
        $parent_org_id= !empty($parent_org_ids)? $this->session->userdata('parent_org_id'): "";
        $sql="1";
        $sql.=!empty($quest_bank_name)? " and name='".$quest_bank_name."'":"";
        $sql.=!empty($parent_org_id)? " and parent_org_id='".$parent_org_id."'":"";
        $sql.=!empty($quest_bank_id)? " and question_bank_id!='".$quest_bank_id."'":"";
         $sql;
        echo $this->commonajaxfunc('UlsQuestionbank',$validateId,$sql);
     }
     
    /*   public function questionbank_name_exist(){
            $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
             $name= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";           
            $arrayToJs = array();
            $arrayToJs[0] = $validateId;
            $query=Doctrine_Query::create()->from('UlsQuestionbank')->where("name='$name'")->execute();             
            $arrayToJs[1]=count($query)>0 ? false:true;
            echo  json_encode($arrayToJs);        
    } */

	public function checkuploaddir(){
		$validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
		$name= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
		$learning_material_id= (filter_input(INPUT_GET, "learning_material_id"))? filter_input(INPUT_GET, "learning_material_id"):"";
		$parent_org_ids=$this->session->userdata('parent_org_id');
        $parent_org_id= !empty($parent_org_ids)? $this->session->userdata('parent_org_id'): "";
		$myDir=__SITE_PATH.DS."public".DS."uploads".DS."learning_material".DS."scorm".DS.$_SESSION["parent_org_id"].DS.trim($name);		
		$arrayToJs = array();
		$arrayToJs[0] = $validateId;
		if(empty($learning_material_id)){
			$arrayToJs[1]=is_dir($myDir)?false:true;
		}
		else{
			$query=Doctrine::getTable('UlsEventScormmaterial')->find($learning_material_id);
			if(isset($query->learning_material_name)){
				$name=trim($name);
				$arrayToJs[1]=$query->learning_material_name!=$name?false:true;
			}
			else{
				$arrayToJs[1]=false;//count($query)>0 ? false:true;
			}			
		}		
		echo  json_encode($arrayToJs); 
	}
	
	public function checkuploaddirnon(){
		$validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
		$name= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
		$learning_material_id= (filter_input(INPUT_GET, "learning_material_id"))? filter_input(INPUT_GET, "learning_material_id"):"";
		$parent_org_ids=$this->session->userdata('parent_org_id');
        $parent_org_id= !empty($parent_org_ids)? $this->session->userdata('parent_org_id'): "";
		$myDir=__SITE_PATH.DS."public".DS."uploads".DS."learning_material".DS."nonscorm".DS.$this->session->userdata('parent_org_id').DS.trim($name);		
		$arrayToJs = array();
		$arrayToJs[0] = $validateId;
		$query2=Doctrine_Query::create()->from('UlsEventMaterial')->where("learning_material_name='$name' and parent_org_id=$parent_org_id and material_type='scorm'")->execute();
		if(count($query2)>0){
			$arrayToJs[1]=false;
		}
		else{			
			$query=Doctrine::getTable('UlsEventMaterial')->find($learning_material_id);
			if(isset($query->learning_material_name)){
				$name=trim($name);
				$arrayToJs[1]=$query->learning_material_name!=$name?false:true;
			}
			else{
				$arrayToJs[1]=true;
			}			
		}		
		echo  json_encode($arrayToJs); 
	}

    public function catname(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $name= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $category_id= (filter_input(INPUT_GET, "ids"))? filter_input(INPUT_GET, "ids"):"";
		$parent_org_ids=$this->session->userdata('parent_org_id');
        $parent_org_id= !empty($parent_org_ids)? $this->session->userdata('parent_org_id'): "";
        $sql="1";
        $sql.=!empty($name)? " and name='".$name."'":"";
        $sql.=!empty($category_id)? " and category_id!='$category_id'":"";
		$sql.=!empty($parent_org_id)? " and parent_org_id='$parent_org_id'":"";
        echo !empty($name)? $this->commonajaxfunc('UlsCategory',$validateId,$sql):true;
    }
	
	public function logout(){
		$this->session->sess_destroy();
        redirect(BASE_URL);
	}
	
	/* public function ass_position_emp(){
		$this->load->library('tcpdf');
		$this->load->library('pdfgenerator');
		$ass_type=isset($_REQUEST['ass_type'])? $_REQUEST['ass_type']:"";
		$id=isset($_REQUEST['ass_id'])? $_REQUEST['ass_id']:"";
		$data['ass_id']=$id;
		$data['aid']=$id;
		$data['pos_id']=$_REQUEST['pos_id'];
		$data['emp_id']=$_REQUEST['emp_id'];
		if($ass_type=='SELF'){
			$posdetails=UlsPosition::viewposition($_REQUEST['pos_id']);
			$data['posdetails']=$posdetails;
			$data['emp_info']=UlsEmployeeMaster::get_empdetails_id($_REQUEST['emp_id']);
			$data['pos_info']=UlsAssessmentPosition::get_assessment_position_info($id,$_REQUEST['pos_id']);
			$data['ass_comp']=UlsSelfAssessmentReport::getselfassessment_comp_details($id,$_REQUEST['pos_id']);
			$data['ass_details']=UlsAssessmentDefinition::viewassessment($id);
			$data['ass_dev_info']=UlsSelfAssessmentReportDevArea::getselfassessment_dev_summary($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['ass_report_info']=UlsSelfAssessmentReport::getassessment_self_competency($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['scale_info']=UlsLevelMasterScale::scale_values();
			$data['scale_info_four']=UlsLevelMasterScale::scale_values_level_four();
			$data['scale_info_five']=UlsLevelMasterScale::scale_values_level_five();
			$data['cri_info']=UlsCompetencyCriticality::criticality_names();
			$data['kras']=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($_REQUEST['pos_id']);
			$data['category']=UlsCompetencyPositionRequirements::category_comp_details($_REQUEST['pos_id']);
			include("radargraphnew.php");
			//$content = $this->load->view('pdf/self_assessment_report',$data,true);
			//$filename = "Employee - Competency Profile";
			//$this->pdfgenerator->generate($content, $filename, true, 'A4', 'portrait','competency_profiling');
			
			$content = $this->load->view('pdf/self_assessment_reportnew',$data,true);		
			$this->render('layouts/ajax-layout',$content);
		}
		else{
			$update=Doctrine_Query::create()->update('UlsAssessmentEmployees');
			$update->set('report_gen','?','1');
			$update->where('assessment_id=?',$id);
			$update->andwhere('position_id=?',$_REQUEST['pos_id']);
			$update->andwhere('employee_id=?',$_REQUEST['emp_id']);
			$update->limit(1)->execute();
			
			$posdetails=UlsPosition::viewposition($_REQUEST['pos_id']);
			$data['posdetails']=$posdetails;
			$empd=UlsEmployeeMaster::get_empdetails_id($_REQUEST['emp_id']);
			$data['emp_info']=$empd;
			$data['competencies']=UlsAssessmentCompetencies::getassessment_competencies_type($id,$_REQUEST['pos_id']);
			//$data['ass_comp_info']=UlsAssessmentReport::getassessment_admin_summary($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			
			$category=UlsCompetencyPositionRequirements::category_comp_details($_REQUEST['pos_id']);
			$data['category']=$category;
			$data['scale_info_four']=UlsLevelMasterScale::scale_values_level_four();
			$data['scale_info_five']=UlsLevelMasterScale::scale_values_level_five();
			$data['cri_info']=UlsCompetencyCriticality::criticality_names();
			$beh_asstype="BEHAVORIAL_INSTRUMENT";
			$data['beh_instrument']=UlsAssessmentTest::get_ass_position_test($id,$_REQUEST['pos_id'],$beh_asstype);
			$data['kras']=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($_REQUEST['pos_id']);
			$testtypes=UlsAssessmentTest::get_assessment_position($id,$_REQUEST['pos_id']);
			$testtypes_new=UlsAssessmentTest::get_assessment_position_new($id,$_REQUEST['pos_id']);
			$data['testtypes_new']=$testtypes_new;
			$data['testtypes']=$testtypes;
			$data['testtypes_bh']=UlsAssessmentTest::get_assessment_position_beh($id,$_REQUEST['pos_id']);
			$data['modes']=UlsAdminMaster::get_value_names("IN_MODE");
			$data['ass_results']=UlsAssessmentTest::assessment_results($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['ass_rating_results']=UlsAssessmentAssessorRating::get_ass_rating_results($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['assessor_rating_new']=UlsAssessmentAssessorRating::assessor_results_report_new($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			//$data['assessor_rating']=UlsAssessmentAssessorRating::assessor_results_report($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['ass_rating_scale']=UlsAssessmentDefinition::view_assessment_rating($id);
			$data['ass_development']=UlsAssessmentReport::getassessment_competencies_summary_report($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['ass_rating_comments']=UlsAssessmentAssessorRating::get_ass_rating_comments($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['ass_rating_case_comments']=UlsAssessmentAssessorRating::get_ass_rating_report_casestudy($id,$_REQUEST['pos_id'],$_REQUEST['emp_id'],'CASE_STUDY');
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
			$assessor_rating_new=UlsAssessmentAssessorRating::assessor_results_report_new($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			echo $content = $this->load->view('pdf/assessment_report_energy_new',$data,true);
			//echo $content = $this->load->view('pdf/assessment_report_new',$data,true);	
			//echo $content = $this->load->view('pdf/assessment_report_new_modified',$data,true);
			//echo $content = $this->load->view('pdf/assessment_report_new_single',$data,true);
			$this->render('layouts/ajax-layout',$content);
		}
	}
	 */
	 
	public function ass_position_emp_old(){
		$this->load->library('tcpdf');
		$this->load->library('pdfgenerator');
		$ass_type=isset($_REQUEST['ass_type'])? $_REQUEST['ass_type']:"";
		$id=isset($_REQUEST['ass_id'])? $_REQUEST['ass_id']:"";
		$data['ass_id']=$id;
		$data['pos_id']=$_REQUEST['pos_id'];
		$data['emp_id']=$_REQUEST['emp_id'];
		if($ass_type=='SELF'){
			$posdetails=UlsPosition::viewposition($_REQUEST['pos_id']);
			$data['posdetails']=$posdetails;
			$data['emp_info']=UlsEmployeeMaster::get_empdetails_id($_REQUEST['emp_id']);
			$data['pos_info']=UlsAssessmentPosition::get_assessment_position_info($id,$_REQUEST['pos_id']);
			$data['ass_comp']=UlsSelfAssessmentReport::getselfassessment_comp_details($id,$_REQUEST['pos_id']);
			$data['ass_details']=UlsAssessmentDefinition::viewassessment($id);
			$data['ass_dev_info']=UlsSelfAssessmentReportDevArea::getselfassessment_dev_summary($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['ass_report_info']=UlsSelfAssessmentReport::getassessment_self_competency($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['scale_info']=UlsLevelMasterScale::scale_values();
			$data['scale_info_four']=UlsLevelMasterScale::scale_values_level_four();
			$data['scale_info_five']=UlsLevelMasterScale::scale_values_level_five();
			$data['cri_info']=UlsCompetencyCriticality::criticality_names();
			$data['kras']=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($_REQUEST['pos_id']);
			$data['category']=UlsCompetencyPositionRequirements::category_comp_details($_REQUEST['pos_id']);
			include("radargraphnew.php");
			//$content = $this->load->view('pdf/self_assessment_report',$data,true);
			//$filename = "Employee - Competency Profile";
			//$this->pdfgenerator->generate($content, $filename, true, 'A4', 'portrait','competency_profiling');
			
			$content = $this->load->view('pdf/self_assessment_reportnew',$data,true);		
			$this->render('layouts/ajax-layout',$content);
		}
		else{
			$update=Doctrine_Query::create()->update('UlsAssessmentEmployees');
			$update->set('report_gen','?','1');
			$update->where('assessment_id=?',$id);
			$update->andwhere('position_id=?',$_REQUEST['pos_id']);
			$update->andwhere('employee_id=?',$_REQUEST['emp_id']);
			$update->limit(1)->execute();
			
			$genempid=UlsAssessmentEmployeeReportGeneration::get_assessment_employees_genreport($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$master_genempid=isset($genempid['gen_report_id'])?Doctrine::getTable('UlsAssessmentEmployeeReportGeneration')->find($genempid['gen_report_id']): new UlsAssessmentEmployeeReportGeneration();
			$master_genempid->assessment_id=$id;
			$master_genempid->position_id=$_REQUEST['pos_id'];
			$master_genempid->employee_id=$_REQUEST['emp_id'];
			$master_genempid->status=1;
			$master_genempid->gen_employee_id=$_SESSION['emp_id'];
			$master_genempid->save();
			
			$emp_id=$_REQUEST['emp_id'];
			$position_id=$_REQUEST['pos_id'];
			$assdeails_ass=UlsAssessmentDefinition::viewassessment($id);
			$data['assdetail_data']=$assdeails_ass;
			$ass_pos_details=UlsAssessmentPosition::get_assessment_position_info($_REQUEST['pos_id'],$id);
			$data['assposdetail']=$ass_pos_details;
			if($ass_pos_details['assessor_process']=='N'){
				$ass_test=UlsAssessmentTest::assessment_testemp($id,$_REQUEST['pos_id']);
				foreach($ass_test as $ass_tests){
					$ass_details=UlsAssessmentTest::test_details($ass_tests['assess_test_id']);
					if($ass_details['assessment_type']=='TEST'){
						$getpretest=UlsUtestAttemptsAssessment::getattemptvalus($ass_details['assessment_id'],$emp_id,$ass_tests['assess_test_id'],$ass_details['assessment_type']);
						$testdetails=UlsUtestAttemptsAssessment::attempt_details($getpretest['attempt_id'],$getpretest['test_id'],$emp_id);
						$comp_questions=UlsAssessmentTestQuestions::gettestquestions_admin($testdetails->event_id,$testdetails->test_id,$testdetails->test_type,$emp_id,$testdetails->assessment_id);
						$total_per_count=$total_correct_count=$total_count=$total_blank_count=$total_wrong_count=0;
						
						foreach($comp_questions as $key1=>$comp_question){
							$cor_count=UlsUtestResponsesAssessment::question_count_correct($comp_question['q_id'],$emp_id,$testdetails->event_id,$testdetails->assessment_id);
							$blank_count=UlsUtestResponsesAssessment::question_count_leftblank($comp_question['q_id'],$emp_id,$testdetails->event_id,$testdetails->assessment_id);
							$total=@explode(",",$comp_question['q_id']);
							$total_question=($blank_count['l_count'])>0?(count($total)-$blank_count['l_count']):count($total);
							$total_per=round((($cor_count['c_count']/$total_question)*100),2);
							$total_per_count+=$total_per;
							$num='';
							if($total_per>=75){
								$ass_scale_id=$comp_question['scale_id'];
								$ass_value=$comp_question['scale_number'];
							}
							else{
								$req_scale_num=UlsLevelMasterScale::levelscale_detail($comp_question['scale_id']);
								$num=($req_scale_num['scale_number']!=1)?($req_scale_num['scale_number']-1):$req_scale_num['scale_number'];
								$ass_level_scale=UlsLevelMasterScale::level_scale_detail_tni($comp_question['assessment_pos_level_id'],$num);
								$ass_scale_id=$ass_level_scale['scale_id'];
								$ass_value=$ass_level_scale['scale_number'];
							}
							$test_comp_details="<br>".$comp_question['comp_def_id'].'-'.$comp_question['comp_def_name'].'-'.$comp_question['scale_id'].'-'.$total_per.'-'.$ass_scale_id.'-'.$comp_question['scale_number'].'-'.$ass_value;
							
							if($comp_question['scale_number']>$ass_value){
								$less_ass_comps=$comp_question['comp_def_name'];
							}
							else{
								$less_ass_comps="";
							}
							$less_ass_comp[]=$less_ass_comps;
							$compid=UlsAssessmentReport::getadminassessment_com_insert_admin($testdetails->assessment_id,$position_id,$emp_id,$comp_question['comp_def_id']);
							$master_value=isset($compid['report_id'])?Doctrine::getTable('UlsAssessmentReport')->find($compid['report_id']): new UlsAssessmentReport();
							$master_value->assessment_id=$testdetails->assessment_id;
							$master_value->position_id=$position_id;
							$master_value->employee_id=$emp_id;
							$master_value->competency_id=$comp_question['comp_def_id'];
							$master_value->require_scale_id=$comp_question['scale_id'];
							$master_value->assessor_id=$_SESSION['emp_id'];
							$master_value->save();
							
							$master_results=UlsAssessmentReportBytype::summary_details($master_value->report_id,$ass_tests['assessment_type'],$comp_question['comp_def_id']);
							$master_value_sub=!empty($master_results['report_assess_id'])?Doctrine::getTable('UlsAssessmentReportBytype')->find($master_results['report_assess_id']): new UlsAssessmentReportBytype();
							$master_value_sub->report_id=$master_value->report_id;
							$master_value_sub->assessment_id=$master_value->assessment_id;
							$master_value_sub->position_id=$master_value->position_id;
							$master_value_sub->employee_id=$master_value->employee_id;
							$master_value_sub->assessor_id=$master_value->assessor_id;
							$master_value_sub->assessment_type=$ass_tests['assessment_type'];
							$master_value_sub->competency_id=$comp_question['comp_def_id'];
							$master_value_sub->require_scale_id=$master_value->require_scale_id;
							$master_value_sub->assessed_scale_id=$ass_scale_id;
							$master_value_sub->save();
						}
						//print_r(array_filter($less_ass_comp));
						$array_data_test=(array_filter($less_ass_comp));
						$test_comment_comp="";
						$key=1;
						foreach($array_data_test as $array_data_tests){
							$test_comment_comp.=$key.".".$array_data_tests."<br>";
							$key++;
						}
						if(count($array_data_test)==0){
							$test_comments="The candidate was found to be competent in all the areas at the current level of work. He may be trained and made ready to take up responsibilities at the next level.";
						}
						else{
							$test_comments="Except for ".count($array_data_test)." competencies the candidate was found to meet the required levels.<br>
							The following are his Development areas:<br>
							".$test_comment_comp."";
						}
						
						$test_total_per=round(($total_per_count/count($comp_questions)),1);
						$ass_details=UlsAssessmentDefinition::viewassessment($testdetails->assessment_id);
						$rat_number="";
						if($test_total_per>85){
							$rat_number=4;
							//$rating_id_scale="Very Good";
						}
						elseif($test_total_per>=65 && $test_total_per<=84.9){
							$rat_number=3;
						}
						elseif($test_total_per>=45 && $test_total_per<=64.9){
							$rat_number=2;
						}
						else{
							$rat_number=1;
						}
						$rating_id_scale=UlsRatingMasterScale::ratingscale_number($ass_details['rating_id'],$rat_number);
						$test_rating_scale=$rating_id_scale['scale_id'];
						$rating_process_id=UlsAssessmentAssessorRating::get_ass_rating_process_admin($testdetails->assessment_id,$position_id,$emp_id,$ass_tests['assessment_type']);
						$role=!empty($rating_process_id['ass_rating_id'])? Doctrine_Core::getTable('UlsAssessmentAssessorRating')->find($rating_process_id['ass_rating_id']):new UlsAssessmentAssessorRating();
						$role->scale_id=$test_rating_scale;
						$role->attempt_id=$getpretest['attempt_id'];
						$role->employee_id=$emp_id;
						$role->position_id=$position_id;
						$role->assessment_id=$testdetails->assessment_id;
						$role->assessment_type=$ass_tests['assessment_type'];
						$role->assessor_id=$_SESSION['emp_id'];
						$role->comments=$test_comments;
						$role->status='A';
						$role->save();
						
					}
					elseif($ass_details['assessment_type']=='INBASKET'){
						$ass_detail_inbasket=UlsAssessmentTestInbasket::getinbasketassessment($ass_tests['assess_test_id']);
						
						foreach($ass_detail_inbasket as $ass_detail_inbaskets){
							$testdetail_insert=UlsUtestAttemptsAssessment::getattemptvalus_inbasket($ass_details['assessment_id'],$emp_id,$ass_tests['assess_test_id'],$ass_details['assessment_type'],$ass_detail_inbaskets['test_id']);
							$testype="'".$ass_details['assessment_type']."'";
							$pa_id="";$ss=''; $rr='';$respvals=array();
							$question_cc= Doctrine_Query::create()->from('UlsUtestQuestionsAssessment')->where("employee_id=".$emp_id." and assessment_id=".$ass_details['assessment_id']." and parent_org_id=".$_SESSION['parent_org_id']." and test_id=".$ass_detail_inbaskets['test_id']." and event_id=".$ass_tests['assess_test_id']." and test_type=".$testype)->execute();
							
							foreach($question_cc as $qq){
								$ccc= Doctrine_Query::create()->from('UlsUtestResponsesAssessment')->where("employee_id=".$emp_id." and assessment_id=".$ass_details['assessment_id']." and parent_org_id=".$_SESSION['parent_org_id']." and event_id=".$ass_tests['assess_test_id']." and test_type=".$testype." and utest_question_id=".$qq['id'])->execute();
								foreach( $ccc as $cccs){
									$pa_id=$cccs->utest_question_id;
									$respvals[$cccs->utest_question_id]=$cccs->response_value_id;
								} 
							}
							$testdetails=UlsUtestResponsesAssessment::gettesttakenquestions_inbasket($ass_detail_inbaskets['test_id'],$testype,$ass_details['assessment_id'],$ass_tests['assess_test_id'],$emp_id);
							if(count($testdetails)>0){
								foreach($testdetails as $keys=>$testdetail){
									$ss=UlsQuestionValues::get_all_question_values($testdetail['question_id']);
									$j=0;
									$delta=array();
									foreach($ss as $key1=>$sss){
										$question_val=UlsQuestionValues::get_allquestion_values_inbasket($sss['value_id']);
										$test=$respvals[$pa_id];
										$valuename=Doctrine_Query::Create()->from("UlsUtestResponsesAssessment")->where("response_value_id in (".$test.") and employee_id=".$emp_id." and test_type=".$testype." and event_id=".$ass_tests['assess_test_id']." and  assessment_id=".$ass_details['assessment_id'])->fetchOne();
										$ched=json_decode($valuename->text);
										$s_order="";
										foreach($ched as $key=>$cheds){
											if($cheds->id==@$sss['value_id']){
												$p_comment=$cheds->text;
												$s_order=$key+1;
												$intray_order=@$sss['scorting_order'];
											}
										}
										$delta_val=abs(($question_val['priority_inbasket']-$s_order));
										if(isset($delta[$question_val['comp_def_id']])){
											$b=($delta[$question_val['comp_def_id']]);
											$a=$delta_val+$b[0];
											$c=$b[1]+1;
											$delta[$question_val['comp_def_id']]=$a."_".$c;
										}
										else{
											$delta[$question_val['comp_def_id']]=$delta_val."_1";
										}
									}
								}
							}
							$comp_questions_inbasket=UlsQuestionValues::get_allquestion_values_competency_unique_admin($ass_detail_inbaskets['inb_assess_test_id'],$testype,$emp_id,$ass_details['assessment_id']);
							$match_inb_count=0;
							if(count($comp_questions_inbasket)>0){
								foreach($comp_questions_inbasket as $keys=>$comp_question_in){
									$criticality=UlsCompetencyPositionRequirements::get_competency_position($comp_question_in['position_id'],$comp_question_in['comp_def_id']);
									$deltasplit=explode("_",$delta[$comp_question_in['comp_def_id']]);
									if($deltasplit[0]==0){
										$delval=$deltasplit[0];
									}
									else{
										$delval=$deltasplit[0]/$deltasplit[1];
									}
									$num_inb='';
									$req_scale_num=UlsLevelMasterScale::levelscale_detail($comp_question_in['scale_id']);
									if($criticality['comp_cri_code']=='C1'){
										if($delval<=1){
											$sel_ass=$comp_question_in['scale_number'];
										}
										else{
											$sel_ass=($comp_question_in['scale_number']-1);
										}
									}
									else{
										if($delval<=2){
											$sel_ass=$comp_question_in['scale_number'];
										}
										else{
											$sel_ass=($comp_question_in['scale_number']-1);
										}
									}
									//echo "<br>".$sel_ass;
									if($comp_question_in['scale_number']>$sel_ass){
										$less_ass_comp_inbasket=$comp_question_in['comp_def_name'];
									}
									else{
										$less_ass_comp_inbasket="";
									}
									$less_ass_comp_inb[]=$less_ass_comp_inbasket;
									$selass=($sel_ass==0)?1:$sel_ass;
									$match_inb_count+=($selass==$comp_question_in['scale_number'])?1:0;
									$ass_level=UlsLevelMaster::viewlevel($comp_question_in['comp_def_level']);
									$ass_level_scale=UlsLevelMasterScale::level_scale_detail_tni($ass_level['level_id'],$selass);
									$sel_ass_scale=$ass_level_scale['scale_id'];
									$inbasket_comp_data="<br>".$comp_question_in['comp_def_id']."-".$comp_question_in['comp_def_name']."-".$comp_question_in['scale_id']."-".$sel_ass_scale."-".$match_inb_count."-".$selass;
									
									$compid=UlsAssessmentReport::getadminassessment_com_insert_admin($ass_details['assessment_id'],$position_id,$emp_id,$comp_question_in['comp_def_id']);
									$master_value=isset($compid['report_id'])?Doctrine::getTable('UlsAssessmentReport')->find($compid['report_id']): new UlsAssessmentReport();
									$master_value->assessment_id=$ass_details['assessment_id'];
									$master_value->position_id=$position_id;
									$master_value->employee_id=$emp_id;
									$master_value->competency_id=$comp_question_in['comp_def_id'];
									$master_value->require_scale_id=$comp_question_in['scale_id'];
									$master_value->assessor_id=$_SESSION['emp_id'];
									$master_value->save();
									
									$master_results_inbasket=UlsAssessmentReportBytype::summary_details($master_value->report_id,$ass_details['assessment_type'],$comp_question_in['comp_def_id']);
									$master_value_sub=!empty($master_results_inbasket['report_assess_id'])?Doctrine::getTable('UlsAssessmentReportBytype')->find($master_results_inbasket['report_assess_id']): new UlsAssessmentReportBytype();
									$master_value_sub->report_id=$master_value->report_id;
									$master_value_sub->inb_assess_test_id=$comp_question_in['inb_assess_test_id'];
									$master_value_sub->assessment_id=$master_value->assessment_id;
									$master_value_sub->position_id=$master_value->position_id;
									$master_value_sub->employee_id=$master_value->employee_id;
									$master_value_sub->assessor_id=$master_value->assessor_id;
									$master_value_sub->assessment_type=$ass_details['assessment_type'];
									$master_value_sub->competency_id=$comp_question_in['comp_def_id'];
									$master_value_sub->require_scale_id=$master_value->require_scale_id;
									$master_value_sub->assessed_scale_id=$sel_ass_scale;
									$master_value_sub->save(); 
								}
							}
							//print_r((array_filter($less_ass_comp_inb)));
							$array_data_inbasket=array_filter($less_ass_comp_inb);
							$inbasket_comment_comp="";
							$key=1;
							foreach($array_data_inbasket as $array_data_inbaskets){
								$inbasket_comment_comp.=$key.".".$array_data_inbaskets."<br>";
								$key++;
							}
							if(count($array_data_inbasket)==0){
								$inbasket_comments="The candidate was found to be competent in all the areas at the current level of work. He may be trained and made ready to take up responsibilities at the next level.";
							}
							else{
								$inbasket_comments="Except for ".count($array_data_inbasket)." competencies the candidate was found to meet the required levels.<br>
								The following are his Development areas:<br>
								".$inbasket_comment_comp."";
							}
							
							
							$total_inb_count=count($comp_questions_inbasket);
							$inbratingscale=round(($match_inb_count/$total_inb_count)*100,2);
							$assdetails=UlsAssessmentDefinition::viewassessment($ass_details['assessment_id']);
							$rat_number="";
							if($inbratingscale>85){
								$rat_number=4;
								//$rating_id_scale="Very Good";
							}
							elseif($inbratingscale>=65 && $inbratingscale<=84.9){
								$rat_number=3;
							}
							elseif($inbratingscale>=45 && $inbratingscale<=64.9){
								$rat_number=2;
							}
							else{
								$rat_number=1;
							}
							//echo $rat_number;
							$rating_id_scale=UlsRatingMasterScale::ratingscale_number($assdetails['rating_id'],$rat_number);
							$inbasket_rating_scale=$rating_id_scale['scale_id'];
							$rating_process_id=UlsAssessmentAssessorRating::get_ass_rating_process_admin($ass_details['assessment_id'],$position_id,$emp_id,$ass_details['assessment_type']);
							$role=!empty($rating_process_id['ass_rating_id'])? Doctrine_Core::getTable('UlsAssessmentAssessorRating')->find($rating_process_id['ass_rating_id']):new UlsAssessmentAssessorRating();
							$role->scale_id=$inbasket_rating_scale;
							$role->attempt_id=$testdetail_insert['attempt_id'];
							$role->employee_id=$emp_id;
							$role->position_id=$position_id;
							$role->assessment_id=$ass_details['assessment_id'];
							$role->assessment_type=$ass_details['assessment_type'];
							$role->assessor_id=$_SESSION['emp_id'];
							$role->comments=$inbasket_comments;
							$role->status='A';
							$role->save();
						}
					}
					elseif($ass_details['assessment_type']=='FISHBONE'){
						$ass_detail_fishbone=UlsAssessmentTestFishbone::getfishboneassessment($ass_tests['assess_test_id']);
						$testype="'".$ass_details['assessment_type']."'";
						foreach($ass_detail_fishbone as $ass_detail_fishbones){
							//$testdetails=UlsUtestResponsesAssessment::gettesttakenquestions_inbasket($ass_detail_fishbones['test_id'],$testype,$ass_details['assessment_id'],$ass_tests['assess_test_id'],$emp_id);
							$testdetails=UlsUtestResponsesAssessment::gettesttakenquestions_fishbone($ass_detail_fishbones['test_id'],$testype,$ass_details['assessment_id'],$ass_tests['assess_test_id'],$emp_id);
							$comp_question_fish=UlsQuestionValues::get_allquestion_values_competency_unique_assessor_fishbone_admin($ass_detail_fishbones['fish_assess_test_id'],$testype,$emp_id,$ass_details['assessment_id']);
							$total_points=0;
							if(count($testdetails)>0){
								foreach($testdetails as $keys=>$testdetail){
									$ss=UlsFishboneListProbable::getfishbonecause($testdetail['fishbone_quest_id']);
									$valuename=Doctrine_Query::Create()->from("UlsUtestResponsesAssessment")->where("employee_id=".$emp_id." and test_type=".$testype." and event_id=".$ass_tests['assess_test_id']." and  assessment_id=".$ass_details['assessment_id'])->fetchOne();
									$ched=json_decode($valuename->text);
									$p_comment="";
									$s_order="";
									$p_reason="";
									$points=0;
									foreach($ched as $key=>$cheds){
										$p_comment=$cheds->head;
										$p_reason=$cheds->reason;
										$casue_details=UlsFishboneListProbable::get_fishbone_cause($cheds->id);
										$points+=($cheds->head==$casue_details['head_list'])?1:0;
										$totalpoints=25;
										//echo "<br>".$casue_details['probable_causes']."-".$cheds->head."-".$casue_details['head_list']."-".$points;
									}
									$total_points=round((($points/$totalpoints)*100),2);
									if(count($comp_question_fish)>0){
										foreach($comp_question_fish as $keys=>$comp_question_fishs){
											if($total_points>90){
												$sel_ass_fish=($comp_question_fishs['scale_number']+1);
											}
											elseif($total_points>=70 && $total_points<=89.9){
												$sel_ass_fish=$comp_question_fishs['scale_number'];
											}
											elseif($total_points<70){
												$sel_ass_fish=($comp_question_fishs['scale_number']-1);
											}
											$ass_level=UlsLevelMaster::viewlevel($comp_question_fishs['comp_def_level']);
											$ass_level_scale=UlsLevelMasterScale::level_scale_detail_tni($ass_level['level_id'],$sel_ass_fish);
											$sel_ass_scale_fish=$ass_level_scale['scale_id'];
											$fishbone_comp="<br>".$comp_question_fishs['comp_def_id']."-".$comp_question_fishs['comp_def_name']."-".$comp_question_fishs['scale_id']."-".$sel_ass_scale_fish;
											if($comp_question_fishs['scale_number']>$sel_ass_fish){
												$less_ass_comp_fishbone=$comp_question_fishs['comp_def_name'];
											}
											else{
												$less_ass_comp_fishbone="";
											}
											$less_ass_comp_fish[]=$less_ass_comp_fishbone;
											$compid=UlsAssessmentReport::getadminassessment_com_insert_admin($ass_details['assessment_id'],$position_id,$emp_id,$comp_question_fishs['comp_def_id']);
											$master_value=isset($compid['report_id'])?Doctrine::getTable('UlsAssessmentReport')->find($compid['report_id']): new UlsAssessmentReport();
											$master_value->assessment_id=$ass_details['assessment_id'];
											$master_value->position_id=$position_id;
											$master_value->employee_id=$emp_id;
											$master_value->competency_id=$comp_question_fishs['comp_def_id'];
											$master_value->require_scale_id=$comp_question_fishs['scale_id'];
											$master_value->assessor_id=$_SESSION['emp_id'];
											$master_value->save();
											
											$master_results=UlsAssessmentReportBytype::summary_details($master_value->report_id,$ass_details['assessment_type'],$comp_question_fishs['comp_def_id']);
											$master_value_sub=!empty($master_results['report_assess_id'])?Doctrine::getTable('UlsAssessmentReportBytype')->find($master_results['report_assess_id']): new UlsAssessmentReportBytype();
											$master_value_sub->report_id=$master_value->report_id;
											$master_value_sub->fish_assess_test_id=$comp_question_fishs['fish_assess_test_id'];
											$master_value_sub->assessment_id=$master_value->assessment_id;
											$master_value_sub->position_id=$master_value->position_id;
											$master_value_sub->employee_id=$master_value->employee_id;
											$master_value_sub->assessor_id=$master_value->assessor_id;
											$master_value_sub->assessment_type=$ass_details['assessment_type'];
											$master_value_sub->competency_id=$comp_question_fishs['comp_def_id'];
											$master_value_sub->require_scale_id=$master_value->require_scale_id;
											$master_value_sub->assessed_scale_id=$sel_ass_scale_fish;
											$master_value_sub->save();
										}
									}
								}
							}
							//print_r(array_filter($less_ass_comp_fish));
							$array_data_fish=(array_filter($less_ass_comp_fish));
							$fish_comment_comp="";
							$key=1;
							foreach($array_data_fish as $array_data_fishs){
								$fish_comment_comp.=$key.".".$array_data_fishs."<br>";
								$key++;
							}
							if(count($array_data_fish)==0){
								$fish_comments="The candidate was found to be competent in all the areas at the current level of work. He may be trained and made ready to take up responsibilities at the next level.";
							}
							else{
								$fish_comments="Except for ".count($array_data_fish)." competencies the candidate was found to meet the required levels.<br>
								The following are his Development areas:<br>
								".$fish_comment_comp."";
							}
							
							$assdetails=UlsAssessmentDefinition::viewassessment($ass_details['assessment_id']);
							$rat_number="";
							if($total_points>85){
								$rat_number=4;
								//$rating_id_scale="Very Good";
							}
							elseif($total_points>=65 && $total_points<=84.9){
								$rat_number=3;
							}
							elseif($total_points>=45 && $total_points<=64.9){
								$rat_number=2;
							}
							else{
								$rat_number=1;
							}
							//echo $rat_number;
							$rating_id_scale=UlsRatingMasterScale::ratingscale_number($assdetails['rating_id'],$rat_number);
							$fishbone_rating_scale=$rating_id_scale['scale_id'];
							$rating_process_id=UlsAssessmentAssessorRating::get_ass_rating_process_admin($ass_details['assessment_id'],$position_id,$emp_id,$ass_details['assessment_type']);
							$role=!empty($rating_process_id['ass_rating_id'])? Doctrine_Core::getTable('UlsAssessmentAssessorRating')->find($rating_process_id['ass_rating_id']):new UlsAssessmentAssessorRating();
							$role->scale_id=$fishbone_rating_scale;
							$role->attempt_id=$testdetail_insert['attempt_id'];
							$role->employee_id=$emp_id;
							$role->position_id=$position_id;
							$role->assessment_id=$ass_details['assessment_id'];
							$role->assessment_type=$ass_details['assessment_type'];
							$role->assessor_id=$_SESSION['emp_id'];
							$role->comments=$fish_comments;
							$role->status='A';
							$role->save();
						}
					} 
				}
				
				$final_report_ass_rating=UlsAssessmentReportBytype::summary_detail_info_report_admin($id,$position_id,$emp_id);
				foreach($final_report_ass_rating as $final_report_ass_ratings){
					$ass_num=$final_report_ass_ratings['ass_scale_number'];
					$ass_level_id=UlsLevelMasterScale::level_scale_detail_tni($final_report_ass_ratings['level_id'],$ass_num);
					$master_value=!empty($final_report_ass_ratings['report_id'])?Doctrine::getTable('UlsAssessmentReport')->find($final_report_ass_ratings['report_id']): new UlsAssessmentReport();
					$master_value->ass_dy_id=$ass_num;
					$master_value->save();
				}
				
				$assresults=UlsAssessmentTest::assessment_results_avg_admin($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
				$results_com=array();
				foreach($assresults as $assresult){
					$compid=$assresult['comp_def_id'];
					$finalval=!empty($assresult['assessor_val'])?round(($assresult['ass_number']*$assresult['assessor_val']),2):$assresult['ass_number'];
					$total_percenatge=round((($finalval/$assresult['req_number'])*100),2);
					
					if($total_percenatge<=80){
						$results_com[$assresult['comp_def_id']]['comp_id']=$compid;
						$results_com[$assresult['comp_def_id']]['comp_name']=$assresult['comp_def_name'];
						$results_com[$assresult['comp_def_id']]['final']=$finalval;
						$results_com[$assresult['comp_def_id']]['required']=$assresult['req_number'];
						$results_com[$assresult['comp_def_id']]['total']=$total_percenatge;
					}
				}
				
				$final_commenets="";
				$key=1;
				if(!empty($results_com)){
					$final_commenets.="The following are his Development areas:<br><br>";
					foreach($results_com as $results_coms){
						$final_commenets.="<b>".$key.". ".$results_coms['comp_name']."</b><br>";
						$key++;
					}
				}
				else{
					$final_commenets.="The candidate was found to be competent in all the areas at the current level of work. He may be trained and made ready to take up responsibilities at the next level.";
				}
				
				
				
				$ass_test_final=UlsAssessmentReportFinal::assessment_assessor_final($id,$position_id,$emp_id,$_SESSION['emp_id']);
				$master_value_final=!empty($ass_test_final['final_id'])?Doctrine::getTable('UlsAssessmentReportFinal')->find($ass_test_final['final_id']): new UlsAssessmentReportFinal();
				$master_value_final->assessment_id=$id;
				$master_value_final->position_id=$position_id;
				$master_value_final->employee_id=$emp_id;
				$master_value_final->assessor_id=$_SESSION['emp_id'];
				$master_value_final->comments=$final_commenets;
				$master_value_final->status='A';
				$master_value_final->save();
			}
			$data['final_deve_comments']=UlsAssessmentReportFinal::assessment_report_final_admin($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$posdetails=UlsPosition::viewposition($_REQUEST['pos_id']);
			$data['posdetails']=$posdetails;
			$empd=UlsEmployeeMaster::get_empdetails_id($_REQUEST['emp_id']);
			$data['emp_info']=$empd;
			$data['competencies']=UlsAssessmentCompetencies::getassessment_competencies_type($id,$_REQUEST['pos_id']);
			//$data['ass_comp_info']=UlsAssessmentReport::getassessment_admin_summary($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['category']=UlsCompetencyPositionRequirements::category_comp_details($_REQUEST['pos_id']);
			$data['scale_info_four']=UlsLevelMasterScale::scale_values_level_four();
			$data['scale_info_five']=UlsLevelMasterScale::scale_values_level_five();
			$data['cri_info']=UlsCompetencyCriticality::criticality_names();
			$beh_asstype="BEHAVORIAL_INSTRUMENT";
			$data['beh_instrument']=UlsAssessmentTest::get_ass_position_test($id,$_REQUEST['pos_id'],$beh_asstype);
			$data['kras']=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($_REQUEST['pos_id']);
			$data['testtypes']=UlsAssessmentTest::get_assessment_position($id,$_REQUEST['pos_id']);
			$data['modes']=UlsAdminMaster::get_value_names("IN_MODE");
			$data['ass_results']=UlsAssessmentTest::assessment_results_avg($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['assessor_rating_new']=UlsAssessmentAssessorRating::assessor_results_report_new($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			//$data['assessor_rating']=UlsAssessmentAssessorRating::assessor_results_report($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['ass_rating_scale']=UlsAssessmentDefinition::view_assessment_rating($id);
			$data['ass_development']=UlsAssessmentReport::getassessment_competencies_summary_report($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['ass_rating_comments']=UlsAssessmentAssessorRating::get_ass_rating_comments($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['assmethods']=UlsAssessmentTest::get_assessment_position_report($_REQUEST['ass_id'],$_REQUEST['pos_id']);
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
				'marker_size'       => 6,		  'axis_max_v'  => 4,'grid_division_v' =>1,
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
			if($ass_pos_details['assessor_process']=='N'){
				$assresults=UlsAssessmentTest::assessment_results_avg_admin($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			}
			else{
				$assresults=UlsAssessmentTest::assessment_results_avg($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			}
			$results=$ass_comname=$ass_req_sid=$ass_given_sid=array();
			
			foreach($assresults as $assresult){
				$compid=$assresult['comp_def_id'];
				if($ass_pos_details['assessor_process']=='N'){
					$finalval=!empty($assresult['assessor_val'])?round(($assresult['ass_number']*$assresult['assessor_val']),2):$assresult['ass_number'];
				}
				else{
					$finalval=!empty($assresult['assessor_val'])?round(($assresult['ass_scale_number']*$assresult['assessor_val']),2):$assresult['ass_scale_number'];
				}
				$results[$assresult['comp_def_id']]['comp_id']=$compid;
				$results[$assresult['comp_def_id']]['comp_name']=$assresult['comp_def_name'];
				$results[$assresult['comp_def_id']]['req_val']=$assresult['req_number'];
				$results[$assresult['comp_def_id']]['assessor'][$assresult['assessor_id']]=$finalval;
			}
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
			/* $req_sid=$ass_sid=$comname=$comp_id=array();
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
			$val=array();
			$val_required=array_combine($comp_id,$req_sid);
			$val_assessed=array_combine($comp_id,$ass_sid);
			$values = array($val_required,$val_assessed);
			$colours = array(array('#b12c43', '#b12c43'), array('#008534', '#008534'));
			$graph = new SVGGraph(500, 500, $settings);
			$graph->colours = $colours;
			$graph->Values($values);
			$value11=$graph->Fetch('MultiRadarGraph', false);//$graph->Fetch('MultiRadarGraph', false);
			
			
			$myfile = fopen($target_path.DS.$_REQUEST['emp_id']."_".$_REQUEST['pos_id'].'_radar.svg', "w") or die("Unable to open file!");
			//$target_path='public'.DS.'feedback'.DS.$feedid.DS.$name.'.svg';
			//$myfile = fopen($target_path, "w") or die("Unable to open file!");
			fwrite($myfile, $value11);
			fclose($myfile); */
			$assessor_rating_new=UlsAssessmentAssessorRating::assessor_results_report_new($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$result_s=array();
			foreach($assessor_rating_new as $assessor_rating_news){
				$finalval=!empty($assessor_rating_news['assessor_val'])?round(($assessor_rating_news['rat_num']*$assessor_rating_news['assessor_val']),2):$assessor_rating_news['rat_num'];
				$result_s[$assessor_rating_news['assessment_type']]['assessment_type']=$assessor_rating_news['assessment_type'];
				$result_s[$assessor_rating_news['assessment_type']]['assess_type']=$assessor_rating_news['assess_type'];
				$result_s[$assessor_rating_news['assessment_type']]['weightage']=$assessor_rating_news['weightage'];
				$result_s[$assessor_rating_news['assessment_type']]['test_ques']=$assessor_rating_news['test_ques'];
				$result_s[$assessor_rating_news['assessment_type']]['test_score']=$assessor_rating_news['test_score'];
				$result_s[$assessor_rating_news['assessment_type']]['rating_scale']=$assessor_rating_news['rating_scale'];
				$result_s[$assessor_rating_news['assessment_type']]['assessor'][$assessor_rating_news['assessor_id']]=$finalval;
			}
			//$assessor_rating=UlsAssessmentAssessorRating::assessor_results_report($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$wei_total=0;
			foreach($result_s as $key1=>$assessor_ratings){
				$score_final=$scorefinal=0;
				if($assessor_ratings['assessment_type']=='TEST'){
					$score_test=(($assessor_ratings['test_score']/$assessor_ratings['test_ques'])*100);
					$wei=$assessor_ratings['weightage'];
					echo $score_final=round((($score_test*$wei)/100),2);
				}
				else{
					$final=0;
					foreach($assessor_ratings['assessor'] as $key2=>$ass_id){
						$final=$final+$result_s[$key1]['assessor'][$key2];
					}
					$final=round($final/count($result_s[$key1]['assessor']),2);
					$score=(($final/$assessor_ratings['rating_scale'])*100);
					$wei=$assessor_ratings['weightage'];
					echo $scorefinal=round((($score*$wei)/100),2);
				} 
				$wei_total=round($wei_total+($score_final+$scorefinal),2);
			}
			$data['weitotal']=$wei_total;
			$a=540;
			$b=(540*$wei_total)/100;
			$value='<svg version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" width="800" height="100"><g transform="translate(220,5)"><rect width="540" height="25" x="0" style=" fill: #eee;"></rect><rect width="'.$a.'" height="8.333333333333334" x="0" y="8.333333333333334" style=" fill: #1d598b;"></rect><line style="stroke: #e89134; stroke-width: 5px;" x1="'.$b.'" x2="'.$b.'" y1="0" y2="25"></line><g transform="translate(0,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >0</text></g><g><line x1="10.8" x2="10.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="21.6" x2="21.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="32.4" x2="32.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="43.2" x2="43.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="64.8" x2="64.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="75.6" x2="75.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="86.4" x2="86.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="97.2" x2="97.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="118.8" x2="118.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="129.6" x2="129.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="140.4" x2="140.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="151.2" x2="151.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="172.8" x2="172.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="183.6" x2="183.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="194.4" x2="194.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="205.2" x2="205.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="226.8" x2="226.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="237.6" x2="237.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="248.4" x2="248.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="259.2" x2="259.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="280.8" x2="280.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="291.6" x2="291.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="302.4" x2="302.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="313.2" x2="313.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="334.8" x2="334.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="345.6" x2="345.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="356.4" x2="356.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="367.2" x2="367.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="388.8" x2="388.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="399.6" x2="399.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="410.4" x2="410.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="421.2" x2="421.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="442.8" x2="442.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="453.6" x2="453.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="464.4" x2="464.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="475.2" x2="475.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="496.8" x2="496.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="507.6" x2="507.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="518.4" x2="518.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="529.2" x2="529.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g transform="translate(54,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >10</text></g><g transform="translate(108,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >20</text></g><g transform="translate(162,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >30</text></g><g transform="translate(216,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >40</text></g><g transform="translate(270,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >50</text></g><g transform="translate(324,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >60</text></g><g transform="translate(378,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >70</text></g><g transform="translate(432,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >80</text></g><g transform="translate(486,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >90</text></g><g transform="translate(540,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >100</text></g><g style="text-anchor: end;" transform="translate(-6,12.5)"><text font-size="16px" style="font-family:sans-serif;">Overall Score</text></g></g></svg>';
			$myfile1 = fopen($target_path.DS.'over_all'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'.svg', "w") or die("Unable to open file!");
			fwrite($myfile1, $value);
			fclose($myfile1);
		
			//$content = $this->load->view('pdf/assessment_report_new',$data,true);
			//$filename = "Employee - ".$empd['enumber']."-".$empd['name']." - Competency Profile";
			//$this->pdfgenerator->generate($content, $filename, true, 'A4', 'portrait','competency_profiling');
			
			echo $content = $this->load->view('pdf/assessment_report_energy_new',$data,true);		
			$this->render('layouts/ajax-layout',$content);
		}		
	}
	
	public function ass_position_emp(){
		$this->load->library('tcpdf');
		$this->load->library('pdfgenerator');
		$ass_type=isset($_REQUEST['ass_type'])? $_REQUEST['ass_type']:"";
		$id=isset($_REQUEST['ass_id'])? $_REQUEST['ass_id']:"";
		$data['ass_id']=$id;
		$data['aid']=$id;
		$data['pos_id']=$_REQUEST['pos_id'];
		$data['emp_id']=$_REQUEST['emp_id'];
		if($ass_type=='SELF'){
			$posdetails=UlsPosition::viewposition($_REQUEST['pos_id']);
			$data['posdetails']=$posdetails;
			$data['emp_info']=UlsEmployeeMaster::get_empdetails_id($_REQUEST['emp_id']);
			$data['pos_info']=UlsAssessmentPosition::get_assessment_position_info($id,$_REQUEST['pos_id']);
			$data['ass_comp']=UlsSelfAssessmentReport::getselfassessment_comp_details($id,$_REQUEST['pos_id']);
			$data['ass_details']=UlsAssessmentDefinition::viewassessment($id);
			$data['ass_dev_info']=UlsSelfAssessmentReportDevArea::getselfassessment_dev_summary($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['ass_report_info']=UlsSelfAssessmentReport::getassessment_self_competency($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['scale_info']=UlsLevelMasterScale::scale_values();
			$data['scale_info_four']=UlsLevelMasterScale::scale_values_level_four();
			$data['scale_info_five']=UlsLevelMasterScale::scale_values_level_five();
			$data['cri_info']=UlsCompetencyCriticality::criticality_names();
			$data['kras']=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($_REQUEST['pos_id']);
			$data['category']=UlsCompetencyPositionRequirements::category_comp_details($_REQUEST['pos_id']);
			include("radargraphnew.php");
			//$content = $this->load->view('pdf/self_assessment_report',$data,true);
			//$filename = "Employee - Competency Profile";
			//$this->pdfgenerator->generate($content, $filename, true, 'A4', 'portrait','competency_profiling');
			
			$content = $this->load->view('pdf/self_assessment_reportnew',$data,true);		
			$this->render('layouts/ajax-layout',$content);
		}
		else{
			$update=Doctrine_Query::create()->update('UlsAssessmentEmployees');
			$update->set('report_gen','?','1');
			$update->where('assessment_id=?',$id);
			$update->andwhere('position_id=?',$_REQUEST['pos_id']);
			$update->andwhere('employee_id=?',$_REQUEST['emp_id']);
			$update->limit(1)->execute();
			
			$posdetails=UlsPosition::viewposition($_REQUEST['pos_id']);
			$data['posdetails']=$posdetails;
			$empd=UlsEmployeeMaster::get_empdetails_id($_REQUEST['emp_id']);

			$data['emp_info']=$empd;
			$data['competencies']=UlsAssessmentCompetencies::getassessment_competencies_type($id,$_REQUEST['pos_id']);
			//$data['ass_comp_info']=UlsAssessmentReport::getassessment_admin_summary($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			
			$category=UlsCompetencyPositionRequirements::category_comp_details($_REQUEST['pos_id']);
			$data['category']=$category;
			$data['scale_info_four']=UlsLevelMasterScale::scale_values_level_four();
			$data['scale_info_five']=UlsLevelMasterScale::scale_values_level_five();
			$data['cri_info']=UlsCompetencyCriticality::criticality_names();
			$beh_asstype="BEHAVORIAL_INSTRUMENT";
			$data['beh_instrument']=UlsAssessmentTest::get_ass_position_test($id,$_REQUEST['pos_id'],$beh_asstype);
			$data['kras']=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($_REQUEST['pos_id']);
			$testtypes=UlsAssessmentTest::get_assessment_position($id,$_REQUEST['pos_id']);
			$testtypes_new=UlsAssessmentTest::get_assessment_position_new($id,$_REQUEST['pos_id']);
			$data['testtypes_new']=$testtypes_new;
			$data['testtypes']=$testtypes;
			$data['testtypes_bh']=UlsAssessmentTest::get_assessment_position_beh($id,$_REQUEST['pos_id']);
			$data['modes']=UlsAdminMaster::get_value_names("IN_MODE");
			$data['ass_results']=UlsAssessmentTest::assessment_results($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['ass_rating_results']=UlsAssessmentAssessorRating::get_ass_rating_results($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['assessor_rating_new']=UlsAssessmentAssessorRating::assessor_results_report_new($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			//$data['assessor_rating']=UlsAssessmentAssessorRating::assessor_results_report($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['ass_rating_scale']=UlsAssessmentDefinition::view_assessment_rating($id);
			$data['ass_development']=UlsAssessmentReport::getassessment_competencies_summary_report($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['ass_rating_comments']=UlsAssessmentAssessorRating::get_ass_rating_comments($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['ass_rating_case_comments']=UlsAssessmentAssessorRating::get_ass_rating_report_casestudy($id,$_REQUEST['pos_id'],$_REQUEST['emp_id'],'CASE_STUDY');
			$data['get_ass_rating_report_interview']=UlsAssessmentAssessorRating::get_ass_rating_report_interview($id,$_REQUEST['pos_id'],$_REQUEST['emp_id'],'INTERVIEW');
			$data['ass_final_rating']=UlsAssessmentReportFinal::get_assessment_assessor_final($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['feedback_emp_grouping']=UlsAssessmentFeedEmployees::getfeed_assessment($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['ass_comp']=UlsAssessmentCompetencies::get_competencies_report($id,$_REQUEST['pos_id']);
			
			/* include("radargraph_full_admin.php");
			$content = $this->load->view('pdf/assessment_report',$data,true); */
			/*require_once(LIB_PATH.DS.DS.'graph'.DS.'includes'.DS.'SVGGraph.php');
			$settings = array(
				'back_colour'       => '#fff',    'stroke_colour'      => '#666',
				'back_stroke_width' => 0,         'back_stroke_colour' => '#fff',
				'axis_colour'       => '#666',    'axis_overlap'       => 2,
				'axis_font'         => 'Georgia', 'axis_font_size'     => 12,
				'grid_colour'       => '#666',    'label_colour'       => '#666',
				'pad_right'         => 50,        'pad_left'           => 50,
				'link_base'         => '/',       'link_target'        => '_top',
				'fill_under'        => false,	  'line_stroke_width'=>5,
				'marker_size'       => 6,		  'axis_max_v'  => 4,'grid_division_v' =>1,
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
			$req_sid=$ass_sid=$comname=$comp_id=array();
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
			fclose($myfile);*/
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
			$assessor_rating_new=UlsAssessmentAssessorRating::assessor_results_report_new($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$result_s=array();
			foreach($assessor_rating_new as $assessor_rating_news){
				$finalval=!empty($assessor_rating_news['assessor_val'])?round(($assessor_rating_news['rat_num']*$assessor_rating_news['assessor_val']),2):$assessor_rating_news['rat_num'];
				$result_s[$assessor_rating_news['assessment_type']]['assessment_type']=$assessor_rating_news['assessment_type'];
				$result_s[$assessor_rating_news['assessment_type']]['assess_type']=$assessor_rating_news['assess_type'];
				$result_s[$assessor_rating_news['assessment_type']]['weightage']=$assessor_rating_news['weightage'];
				$result_s[$assessor_rating_news['assessment_type']]['test_ques']=$assessor_rating_news['test_ques'];
				$result_s[$assessor_rating_news['assessment_type']]['test_score']=$assessor_rating_news['test_score'];
				$result_s[$assessor_rating_news['assessment_type']]['rating_scale']=$assessor_rating_news['rating_scale'];
				$result_s[$assessor_rating_news['assessment_type']]['assessor'][$assessor_rating_news['assessor_id']]=$finalval;
			}
			//$assessor_rating=UlsAssessmentAssessorRating::assessor_results_report($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$wei_total=0;
			foreach($result_s as $key1=>$assessor_ratings){
				$score_final=$scorefinal=0;
				if($assessor_ratings['assessment_type']=='TEST'){
					$score_test=(($assessor_ratings['test_score']/$assessor_ratings['test_ques'])*100);
					$wei=$assessor_ratings['weightage'];
					echo $score_final=round((($score_test*$wei)/100),2);
				}
				else{
					$final=0;
					foreach($assessor_ratings['assessor'] as $key2=>$ass_id){
						$final=$final+$result_s[$key1]['assessor'][$key2];
					}
					$final=round($final/count($result_s[$key1]['assessor']),2);
					$score=(($final/$assessor_ratings['rating_scale'])*100);
					$wei=$assessor_ratings['weightage'];
					echo $scorefinal=round((($score*$wei)/100),2);
				} 
				$wei_total=round($wei_total+($score_final+$scorefinal),2);
			}
			$feedbackquery=UlsMenu::callpdorow("SELECT avg(`rater_value`) as val FROM `uls_feedback_employee_rating` WHERE `assessment_id`='".$_REQUEST['ass_id']."' and `employee_id`='".$_REQUEST['emp_id']."' and `giver_id`!='".$_REQUEST['emp_id']."' and `rater_value` is not null and `rater_value`!=0");
			if(isset($feedbackquery['val'])){
				$feedbackweightagequery=UlsMenu::callpdorow("SELECT * FROM `uls_assessment_competencies_weightage` WHERE `assessment_id`='".$_REQUEST['ass_id']."' and assessment_type='FEEDBACK' and position_id='".$_REQUEST['pos_id']."'");			
				$feedbackscale=UlsMenu::callpdorow("SELECT * FROM `uls_rating_master` WHERE `rating_id` in (SELECT rating_id FROM `uls_questionnaire_master` where ques_id in (SELECT ques_id FROM `uls_assessment_test_feedback` where assessment_id='".$_REQUEST['ass_id']."' and position_id='".$_REQUEST['pos_id']."' and assessment_type='FEEDBACK' and status='A' ) )");
				//$wei_sum=($wei_sum+$feedbackweightagequery['weightage']);
				$chekfeedtotal=round(($feedbackquery['val']/$feedbackscale['rating_scale'])*100,2)/$feedbackweightagequery['weightage'];
				$chekfeedtotal=round($chekfeedtotal,1);
				$wei_total=$wei_total+$chekfeedtotal;
			}
			
			/* $a=540;
			$b=(540*$wei_total)/100;
			$value='<svg version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" width="800" height="100"><g transform="translate(220,5)"><rect width="540" height="25" x="0" style=" fill: #eee;"></rect><rect width="'.$a.'" height="8.333333333333334" x="0" y="8.333333333333334" style=" fill: #1d598b;"></rect><line style="stroke: #e89134; stroke-width: 5px;" x1="'.$b.'" x2="'.$b.'" y1="0" y2="25"></line><g transform="translate(0,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >0</text></g><g><line x1="10.8" x2="10.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="21.6" x2="21.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="32.4" x2="32.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="43.2" x2="43.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="64.8" x2="64.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="75.6" x2="75.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="86.4" x2="86.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="97.2" x2="97.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="118.8" x2="118.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="129.6" x2="129.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="140.4" x2="140.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="151.2" x2="151.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="172.8" x2="172.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="183.6" x2="183.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="194.4" x2="194.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="205.2" x2="205.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="226.8" x2="226.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="237.6" x2="237.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="248.4" x2="248.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="259.2" x2="259.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="280.8" x2="280.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="291.6" x2="291.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="302.4" x2="302.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="313.2" x2="313.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="334.8" x2="334.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="345.6" x2="345.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="356.4" x2="356.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="367.2" x2="367.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="388.8" x2="388.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="399.6" x2="399.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="410.4" x2="410.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="421.2" x2="421.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="442.8" x2="442.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="453.6" x2="453.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="464.4" x2="464.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="475.2" x2="475.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="496.8" x2="496.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="507.6" x2="507.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="518.4" x2="518.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="529.2" x2="529.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g transform="translate(54,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >10</text></g><g transform="translate(108,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >20</text></g><g transform="translate(162,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >30</text></g><g transform="translate(216,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >40</text></g><g transform="translate(270,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >50</text></g><g transform="translate(324,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >60</text></g><g transform="translate(378,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >70</text></g><g transform="translate(432,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >80</text></g><g transform="translate(486,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >90</text></g><g transform="translate(540,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >100</text></g><g style="text-anchor: end;" transform="translate(-6,12.5)"><text font-size="16px" style="font-family:sans-serif;">Overall Score</text></g></g></svg>';
			$myfile1 = fopen($target_path.DS.'over_all'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'.svg', "w") or die("Unable to open file!");
			fwrite($myfile1, $value);
			fclose($myfile1); */
		
			//$content = $this->load->view('pdf/assessment_report_new',$data,true);
			//$filename = "Employee - ".$empd['enumber']."-".$empd['name']." - Competency Profile";
			//$this->pdfgenerator->generate($content, $filename, true, 'A4', 'portrait','competency_profiling');
			$total_all_weight=0;
			$cluster_wei=array();
			foreach($category as $categorys){
				$ass_comp_info=UlsAssessmentReport::getassessment_admin_competency($_REQUEST['ass_id'],$_REQUEST['pos_id'],$categorys['category_id']);
				$results=$result_assessor=$assessor=array();
				$ass_method_score="";
				foreach($ass_comp_info as $ass_comp_infos){
					$comp_id=$ass_comp_infos['comp_def_id'];
					$req_scale_id=$ass_comp_infos['req_scale_id'];
					$results[$comp_id]['comp_id']=$comp_id;
					$results[$comp_id]['comp_name']=$ass_comp_infos['comp_def_name'];
					$results[$comp_id]['pos_com_weightage']=$ass_comp_infos['pos_com_weightage'];
				}
				$assessor_rating_new=UlsAssessmentAssessorRating::assessor_results_report_new($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
				foreach($assessor_rating_new as $assessor_rating_news){
					$finalval=!empty($assessor_rating_news['assessor_val'])?round(($assessor_rating_news['rat_num']*$assessor_rating_news['assessor_val']),2):$assessor_rating_news['rat_num'];
					$result_assessor[$assessor_rating_news['assessment_type']]['assessment_type']=$assessor_rating_news['assessment_type'];
					$result_assessor[$assessor_rating_news['assessment_type']]['event_id']=$assessor_rating_news['event_id'];
					$result_assessor[$assessor_rating_news['assessment_type']]['assess_type']=$assessor_rating_news['assess_type'];
					$result_assessor[$assessor_rating_news['assessment_type']]['weightage']=$assessor_rating_news['weightage'];
					$result_assessor[$assessor_rating_news['assessment_type']]['test_ques']=$assessor_rating_news['test_ques'];
					$result_assessor[$assessor_rating_news['assessment_type']]['test_score']=$assessor_rating_news['test_score'];
					$result_assessor[$assessor_rating_news['assessment_type']]['rating_scale']=$assessor_rating_news['rating_scale'];
					$result_assessor[$assessor_rating_news['assessment_type']]['assessor'][$assessor_rating_news['assessor_id']]=$finalval;
				}
				foreach($result_assessor as $key1=>$assessor_ratings){
					if($assessor_ratings['assessment_type']!='FEEDBACK'){
						if($assessor_ratings['assessment_type']=='TEST'){
							$ass_method_test=$assessor_ratings['event_id'];
						}
						if($assessor_ratings['assessment_type']=='INBASKET'){
							$final=0;
							foreach($assessor_ratings['assessor'] as $key2=>$ass_id){
								$final=$final+$result_assessor[$key1]['assessor'][$key2];
							}
							$final=round($final/count($result_assessor[$key1]['assessor']),2);
							$score=round($final,2);
							$score_f=$score;
							$ass_method_inbasket=$score_f;
						}
						if($assessor_ratings['assessment_type']=='CASE_STUDY'){
							$final=0;
							foreach($assessor_ratings['assessor'] as $key2=>$ass_id){
								$final=$final+$result_assessor[$key1]['assessor'][$key2];
							}
							$final=round($final/count($result_assessor[$key1]['assessor']),2);
							$score=round($final,2);
							$score_f=$score;
							$ass_method_case=$score_f;
						}
						if($assessor_ratings['assessment_type']=='INTERVIEW'){
							$final=0;
							foreach($assessor_ratings['assessor'] as $key2=>$ass_id){
								$final=$final+$result_assessor[$key1]['assessor'][$key2];
							}
							$final=round($final/count($result_assessor[$key1]['assessor']),2);
							$score=round($final,2);
							$score_f=$score;
							$ass_method_interview=$score_f;
						}
					}
				}
				if(!empty($results)){
				foreach($results as $comp_def_id=>$result){
					$multi=1;
					$test_weight=$inb_weight=$case_weight=$int_weight=$feed_weight='';
					foreach($testtypes_new as $testtype){
						if($testtype['assessment_type']=='TEST'){
							$testdetails=UlsUtestAttemptsAssessment::attempt_detail_report($ass_method_test,$_REQUEST['emp_id']);
							$emp_id=$_REQUEST['emp_id'];
							$compquestion=UlsMenu::callpdorow("SELECT group_concat(distinct(a.`question_id`)) as q_id,a.`competency_id`,count(*)  as q_count,d.comp_def_name,s.scale_name,a.position_id,d.comp_def_id,s.scale_id,ac.assessment_pos_level_id,s.scale_number FROM `uls_assessment_test_questions` a
							left join(SELECT `assessment_id`,`assessment_pos_com_id`,`assessment_pos_level_scale_id`,`assessment_type`,assessment_pos_level_id,position_id FROM `uls_assessment_competencies` where assessment_id=".$ass_id.") ac on ac.assessment_pos_com_id=a.competency_id and ac.position_id=a.position_id
							left join(SELECT `comp_def_id`,`comp_def_name` FROM `uls_competency_definition`) d on d.comp_def_id=ac.assessment_pos_com_id
							left join (SELECT `scale_id`,`scale_name`,scale_number FROM `uls_level_master_scale`) s on s.scale_id=ac.assessment_pos_level_scale_id
							WHERE a.`assess_test_id`=".$testdetails->event_id." and a.`test_id`=".$testdetails->test_id." and a.assessment_id=".$testdetails->assessment_id." and a.`competency_id`=".$result['comp_id']."  group by a.`competency_id` ");
							$total=@explode(",",$compquestion['q_id']);
							$cor_count=UlsUtestResponsesAssessment::question_count_correct($compquestion['q_id'],$emp_id,$testdetails->event_id,$testdetails->assessment_id);
							$blank_count=UlsUtestResponsesAssessment::question_count_leftblank($compquestion['q_id'],$emp_id,$testdetails->event_id,$testdetails->assessment_id);
							$total_question=!empty($blank_count['l_count'])?(count($total)-$blank_count['l_count']):count($total);
							$total_per=round((($cor_count['c_count']/$total_question)),2);
							$test_weight=($total_per*($testtype['weightage']/100));
						}
						elseif($testtype['assessment_type']=='INBASKET'){
							$inb_test_id=UlsAssessmentTest::get_ass_position_inbasket_comp($_REQUEST['ass_id'],$_REQUEST['pos_id'],$result['comp_id'],'INBASKET');
							if(!empty($inb_test_id['comp_id'])){
								$inb_weight=(($ass_method_inbasket/4)*($testtype['weightage']/100));
							}
							else{
								$multi=($multi+($testtype['weightage']/100));
							}
							
						}
						elseif($testtype['assessment_type']=='CASE_STUDY'){
							$case_test_id=UlsAssessmentTest::get_ass_position_case_comp($_REQUEST['ass_id'],$_REQUEST['pos_id'],$result['comp_id'],'CASE_STUDY');
							if(!empty($case_test_id)){
								$case_weight=(($ass_method_case/4)*($testtype['weightage']/100));
							}
							else{
								$multi=($multi+($testtype['weightage']/100));
							}
							
						}
						elseif($testtype['assessment_type']=='INTERVIEW'){
							$int_weight=(($ass_method_interview/4)*($testtype['weightage']/100));
						}
						elseif($testtype['assessment_type']=='FEEDBACK'){
							$feed_test_id=UlsAssessmentTest::get_ass_position_test($_REQUEST['ass_id'],$_REQUEST['pos_id'],'FEEDBACK');
							$feed_comp=UlsMenu::callpdorow("SELECT avg(`rater_value`) as avg_rater_value FROM `uls_feedback_employee_rating` WHERE `assessment_id`=".$_REQUEST['ass_id']." and `ass_test_id`=".$feed_test_id['assess_test_id']." and `employee_id`=".$_REQUEST['emp_id']." and `giver_id`!=".$_REQUEST['emp_id']." and `element_competency_id`=".$result['comp_id']);
							$feed_weight=((round($feed_comp['avg_rater_value'],2)/4)*($testtype['weightage']/100));
							$feed_weights=!empty($feed_weight)?$feed_weight:0;
						}
					}
					$total_com=@round(($test_weight+$inb_weight+$case_weight+$int_weight+$feed_weight)*($multi),2);
					$over_all=@round(($total_com*count($testtypes)),2);
					$over_all_weight=@round(($over_all*($result['pos_com_weightage']/100)),2);
					$total_all_weight+=$over_all_weight;
					$cat_details=$categorys['category_id']."*".$categorys['name'];
					$cluster_wei[$cat_details]=isset($cluster_wei[$cat_details])?$cluster_wei[$cat_details]+$over_all_weight:$over_all_weight;
					$clu_wei[$categorys['category_id']]=isset($clu_wei[$categorys['category_id']])?$clu_wei[$categorys['category_id']]+$result['pos_com_weightage']:$result['pos_com_weightage'];
				}
				}
			}
			
			$total_per=($total_all_weight/4*100);
			$total_per_bar=($total_per*4);
			$color=array('green','gold','blue','orange','maroon','olive','navy','fuchsia');
			$texta=array(30,135,240,330,430);
			$textb=array(10,110,210,310,410);
			$textc=array(10,110,210,310,410);
			$value_comp='<svg  version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg"  width="450" height="75">
				<line x1="10" y1="00" x2="10" y2="65" stroke="#666666" stroke-width="1"  />
				<text x="10" y="72" font-style="normal" font-size="0.5em">0</text>
				<line x1="50" y1="15" x2="50" y2="65" stroke="#666666" stroke-width="0.2"  />
				<text x="50" y="72" font-style="normal" font-size="0.5em">10</text>
				<line x1="90" y1="15" x2="90" y2="65" stroke="#666666" stroke-width="0.2"  />
				<text x="90" y="72" font-style="normal" font-size="0.5em">20</text>
				<line x1="130" y1="15" x2="130" y2="65" stroke="#666666" stroke-width="0.2"  />
				<text x="130" y="72" font-style="normal" font-size="0.5em">30</text>
				<line x1="170" y1="15" x2="170" y2="65" stroke="#666666" stroke-width="0.2"  />
				<text x="170" y="72" font-style="normal" font-size="0.5em">40</text>
				<line x1="210" y1="15" x2="210" y2="65" stroke="#666666" stroke-width="0.2"  />
				<text x="210" y="72" font-style="normal" font-size="0.5em">50</text>
				<line x1="250" y1="15" x2="250" y2="65" stroke="#666666" stroke-width="0.2"  />
				<text x="250" y="72" font-style="normal" font-size="0.5em">60</text>
				<line x1="290" y1="15" x2="290" y2="65" stroke="#666666" stroke-width="0.2"  />
				<text x="290" y="72" font-style="normal" font-size="0.5em">70</text>
				<line x1="330" y1="15" x2="330" y2="65" stroke="#666666" stroke-width="0.2"  />
				<text x="330" y="72" font-style="normal" font-size="0.5em">80</text>
				<line x1="370" y1="15" x2="370" y2="65" stroke="#666666" stroke-width="0.2"  />
				<text x="370" y="72" font-style="normal" font-size="0.5em">90</text>
				<line x1="410" y1="15" x2="410" y2="65" stroke="#666666" stroke-width="0.2"  />
				<text x="410" y="72" font-style="normal" font-size="0.5em">100</text>
				<line x1="10" y1="65" x2="410" y2="65" stroke="#666666" stroke-width="1"  />';
				$k=0;
				foreach($cluster_wei as $key=>$cluster_weis){
					$cat=explode("*",$key);
					$value_comp.='<text x="'.$textb[$k].'" y="7" font-style="normal" font-size="0.5em">'.$cat[1].' ('.($cluster_weis/4*100).')</text>
					<rect x="'.$textb[$k].'" y="10" width="100" height="20" rx="5" fill="#cccccc"  />
					<rect x="'.$textb[$k].'" y="10" width="'.($cluster_weis/4*100).'" height="20" rx="5"  fill="'.$color[$k].'"  />';
					$k++;
				}
				$value_comp.='<rect x="10" y="35" width="400" height="20" fill="#cccccc"  />
				<rect x="10" y="42" width="'.$total_per_bar.'" height="6" fill="blue"  />

			</svg>';
			$valuecomp=$value_comp;
			$myfile1 = fopen($target_path.DS.'comp_over_all'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'.svg', "w") or die("Unable to open file!");
			fwrite($myfile1, $valuecomp);
			fclose($myfile1);	
			$content = $this->load->view('pdf/assessment_report_newprocess_update',$data,true);		
			$this->render('layouts/ajax-layout',$content);
		}
	}
	
	public function ass_position_emp_update(){
		$this->load->library('tcpdf');
		$this->load->library('pdfgenerator');
		$ass_type=isset($_REQUEST['ass_type'])? $_REQUEST['ass_type']:"";
		$id=isset($_REQUEST['ass_id'])? $_REQUEST['ass_id']:"";
		$data['ass_id']=$id;
		$data['pos_id']=$_REQUEST['pos_id'];
		$data['emp_id']=$_REQUEST['emp_id'];
		if($ass_type=='SELF'){
			$posdetails=UlsPosition::viewposition($_REQUEST['pos_id']);
			$data['posdetails']=$posdetails;
			$data['emp_info']=UlsEmployeeMaster::get_empdetails_id($_REQUEST['emp_id']);
			$data['pos_info']=UlsAssessmentPosition::get_assessment_position_info($id,$_REQUEST['pos_id']);
			$data['ass_comp']=UlsSelfAssessmentReport::getselfassessment_comp_details($id,$_REQUEST['pos_id']);
			$data['ass_details']=UlsAssessmentDefinition::viewassessment($id);
			$data['ass_dev_info']=UlsSelfAssessmentReportDevArea::getselfassessment_dev_summary($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['ass_report_info']=UlsSelfAssessmentReport::getassessment_self_competency($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['scale_info']=UlsLevelMasterScale::scale_values();
			$data['scale_info_four']=UlsLevelMasterScale::scale_values_level_four();
			$data['scale_info_five']=UlsLevelMasterScale::scale_values_level_five();
			$data['cri_info']=UlsCompetencyCriticality::criticality_names();
			$data['kras']=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($_REQUEST['pos_id']);
			$data['category']=UlsCompetencyPositionRequirements::category_comp_details($_REQUEST['pos_id']);
			include("radargraphnew.php");
			//$content = $this->load->view('pdf/self_assessment_report',$data,true);
			//$filename = "Employee - Competency Profile";
			//$this->pdfgenerator->generate($content, $filename, true, 'A4', 'portrait','competency_profiling');
			
			$content = $this->load->view('pdf/self_assessment_reportnew',$data,true);		
			$this->render('layouts/ajax-layout',$content);
		}
		else{
			$update=Doctrine_Query::create()->update('UlsAssessmentEmployees');
			$update->set('report_gen','?','1');
			$update->where('assessment_id=?',$id);
			$update->andwhere('position_id=?',$_REQUEST['pos_id']);
			$update->andwhere('employee_id=?',$_REQUEST['emp_id']);
			$update->limit(1)->execute();
			$emp_id=$_REQUEST['emp_id'];
			$position_id=$_REQUEST['pos_id'];
			$assdeails_ass=UlsAssessmentDefinition::viewassessment($id);
			$data['assdetail_data']=$assdeails_ass;
			$ass_pos_details=UlsAssessmentPosition::get_assessment_position_info($_REQUEST['pos_id'],$id);
			$data['assposdetail']=$ass_pos_details;
			if($ass_pos_details['assessor_process']=='N'){
				$ass_test=UlsAssessmentTest::assessment_testemp($id,$_REQUEST['pos_id']);
				foreach($ass_test as $ass_tests){
					$ass_details=UlsAssessmentTest::test_details($ass_tests['assess_test_id']);
					if($ass_details['assessment_type']=='TEST'){
						$getpretest=UlsUtestAttemptsAssessment::getattemptvalus($ass_details['assessment_id'],$emp_id,$ass_tests['assess_test_id'],$ass_details['assessment_type']);
						$testdetails=UlsUtestAttemptsAssessment::attempt_details($getpretest['attempt_id'],$getpretest['test_id'],$emp_id);
						$comp_questions=UlsAssessmentTestQuestions::gettestquestions_admin($testdetails->event_id,$testdetails->test_id,$testdetails->test_type,$emp_id,$testdetails->assessment_id);
						$total_per_count=$total_correct_count=$total_count=$total_blank_count=$total_wrong_count=0;
						
						foreach($comp_questions as $key1=>$comp_question){
							$cor_count=UlsUtestResponsesAssessment::question_count_correct($comp_question['q_id'],$emp_id,$testdetails->event_id,$testdetails->assessment_id);
							$blank_count=UlsUtestResponsesAssessment::question_count_leftblank($comp_question['q_id'],$emp_id,$testdetails->event_id,$testdetails->assessment_id);
							$total=@explode(",",$comp_question['q_id']);
							$total_question=($blank_count['l_count'])>0?(count($total)-$blank_count['l_count']):count($total);
							$total_per=round((($cor_count['c_count']/$total_question)*100),2);
							$total_per_count+=$total_per;
							$num='';
							if($total_per>=75){
								$ass_scale_id=$comp_question['scale_id'];
								$ass_value=$comp_question['scale_number'];
							}
							else{
								$req_scale_num=UlsLevelMasterScale::levelscale_detail($comp_question['scale_id']);
								$num=($req_scale_num['scale_number']!=1)?($req_scale_num['scale_number']-1):$req_scale_num['scale_number'];
								$ass_level_scale=UlsLevelMasterScale::level_scale_detail_tni($comp_question['assessment_pos_level_id'],$num);
								$ass_scale_id=$ass_level_scale['scale_id'];
								$ass_value=$ass_level_scale['scale_number'];
							}
							$test_comp_details="<br>".$comp_question['comp_def_id'].'-'.$comp_question['comp_def_name'].'-'.$comp_question['scale_id'].'-'.$total_per.'-'.$ass_scale_id.'-'.$comp_question['scale_number'].'-'.$ass_value;
							
							if($comp_question['scale_number']>$ass_value){
								$less_ass_comps=$comp_question['comp_def_name'];
							}
							else{
								$less_ass_comps="";
							}
							$less_ass_comp[]=$less_ass_comps;
							$compid=UlsAssessmentReport::getadminassessment_com_insert_admin($testdetails->assessment_id,$position_id,$emp_id,$comp_question['comp_def_id']);
							$master_value=isset($compid['report_id'])?Doctrine::getTable('UlsAssessmentReport')->find($compid['report_id']): new UlsAssessmentReport();
							$master_value->assessment_id=$testdetails->assessment_id;
							$master_value->position_id=$position_id;
							$master_value->employee_id=$emp_id;
							$master_value->competency_id=$comp_question['comp_def_id'];
							$master_value->require_scale_id=$comp_question['scale_id'];
							$master_value->assessor_id=$_SESSION['emp_id'];
							$master_value->save();
							
							$master_results=UlsAssessmentReportBytype::summary_details($master_value->report_id,$ass_tests['assessment_type'],$comp_question['comp_def_id']);
							$master_value_sub=!empty($master_results['report_assess_id'])?Doctrine::getTable('UlsAssessmentReportBytype')->find($master_results['report_assess_id']): new UlsAssessmentReportBytype();
							$master_value_sub->report_id=$master_value->report_id;
							$master_value_sub->assessment_id=$master_value->assessment_id;
							$master_value_sub->position_id=$master_value->position_id;
							$master_value_sub->employee_id=$master_value->employee_id;
							$master_value_sub->assessor_id=$master_value->assessor_id;
							$master_value_sub->assessment_type=$ass_tests['assessment_type'];
							$master_value_sub->competency_id=$comp_question['comp_def_id'];
							$master_value_sub->require_scale_id=$master_value->require_scale_id;
							$master_value_sub->assessed_scale_id=$ass_scale_id;
							$master_value_sub->save();
						}
						//print_r(array_filter($less_ass_comp));
						$array_data_test=(array_filter($less_ass_comp));
						$test_comment_comp="";
						$key=1;
						foreach($array_data_test as $array_data_tests){
							$test_comment_comp.=$key.".".$array_data_tests."<br>";
							$key++;
						}
						if(count($array_data_test)==0){
							$test_comments="The candidate was found to be competent in all the areas at the current level of work. He may be trained and made ready to take up responsibilities at the next level.";
						}
						else{
							$test_comments="Except for ".count($array_data_test)." competencies the candidate was found to meet the required levels.<br>
							The following are his Development areas:<br>
							".$test_comment_comp."";
						}
						
						$test_total_per=round(($total_per_count/count($comp_questions)),1);
						$ass_details=UlsAssessmentDefinition::viewassessment($testdetails->assessment_id);
						$rat_number="";
						if($test_total_per>85){
							$rat_number=4;
							//$rating_id_scale="Very Good";
						}
						elseif($test_total_per>=65 && $test_total_per<=84.9){
							$rat_number=3;
						}
						elseif($test_total_per>=45 && $test_total_per<=64.9){
							$rat_number=2;
						}
						else{
							$rat_number=1;
						}
						$rating_id_scale=UlsRatingMasterScale::ratingscale_number($ass_details['rating_id'],$rat_number);
						$test_rating_scale=$rating_id_scale['scale_id'];
						$rating_process_id=UlsAssessmentAssessorRating::get_ass_rating_process_admin($testdetails->assessment_id,$position_id,$emp_id,$ass_tests['assessment_type']);
						$role=!empty($rating_process_id['ass_rating_id'])? Doctrine_Core::getTable('UlsAssessmentAssessorRating')->find($rating_process_id['ass_rating_id']):new UlsAssessmentAssessorRating();
						$role->scale_id=$test_rating_scale;
						$role->attempt_id=$getpretest['attempt_id'];
						$role->employee_id=$emp_id;
						$role->position_id=$position_id;
						$role->assessment_id=$testdetails->assessment_id;
						$role->assessment_type=$ass_tests['assessment_type'];
						$role->assessor_id=$_SESSION['emp_id'];
						$role->comments=$test_comments;
						$role->status='A';
						$role->save();
						
					}
					elseif($ass_details['assessment_type']=='INBASKET'){
						$ass_detail_inbasket=UlsAssessmentTestInbasket::getinbasketassessment($ass_tests['assess_test_id']);
						
						foreach($ass_detail_inbasket as $ass_detail_inbaskets){
							$testdetail_insert=UlsUtestAttemptsAssessment::getattemptvalus_inbasket($ass_details['assessment_id'],$emp_id,$ass_tests['assess_test_id'],$ass_details['assessment_type'],$ass_detail_inbaskets['test_id']);
							$testype="'".$ass_details['assessment_type']."'";
							$pa_id="";$ss=''; $rr='';$respvals=array();
							$question_cc= Doctrine_Query::create()->from('UlsUtestQuestionsAssessment')->where("employee_id=".$emp_id." and assessment_id=".$ass_details['assessment_id']." and parent_org_id=".$_SESSION['parent_org_id']." and test_id=".$ass_detail_inbaskets['test_id']." and event_id=".$ass_tests['assess_test_id']." and test_type=".$testype)->execute();
							
							foreach($question_cc as $qq){
								$ccc= Doctrine_Query::create()->from('UlsUtestResponsesAssessment')->where("employee_id=".$emp_id." and assessment_id=".$ass_details['assessment_id']." and parent_org_id=".$_SESSION['parent_org_id']." and event_id=".$ass_tests['assess_test_id']." and test_type=".$testype." and utest_question_id=".$qq['id'])->execute();
								foreach( $ccc as $cccs){
									$pa_id=$cccs->utest_question_id;
									$respvals[$cccs->utest_question_id]=$cccs->response_value_id;
								} 
							}
							$testdetails=UlsUtestResponsesAssessment::gettesttakenquestions_inbasket($ass_detail_inbaskets['test_id'],$testype,$ass_details['assessment_id'],$ass_tests['assess_test_id'],$emp_id);
							if(count($testdetails)>0){
								foreach($testdetails as $keys=>$testdetail){
									$ss=UlsQuestionValues::get_all_question_values($testdetail['question_id']);
									$j=0;
									$delta=array();
									foreach($ss as $key1=>$sss){
										$question_val=UlsQuestionValues::get_allquestion_values_inbasket($sss['value_id']);
										$test=$respvals[$pa_id];
										$valuename=Doctrine_Query::Create()->from("UlsUtestResponsesAssessment")->where("response_value_id in (".$test.") and employee_id=".$emp_id." and test_type=".$testype." and event_id=".$ass_tests['assess_test_id']." and  assessment_id=".$ass_details['assessment_id'])->fetchOne();
										$ched=json_decode($valuename->text);
										$s_order="";
										foreach($ched as $key=>$cheds){
											if($cheds->id==@$sss['value_id']){
												$p_comment=$cheds->text;
												$s_order=$key+1;
												$intray_order=@$sss['scorting_order'];
											}
										}
										$delta_val=abs(($question_val['priority_inbasket']-$s_order));
										if(isset($delta[$question_val['comp_def_id']])){
											$b=($delta[$question_val['comp_def_id']]);
											$a=$delta_val+$b[0];
											$c=$b[1]+1;
											$delta[$question_val['comp_def_id']]=$a."_".$c;
										}
										else{
											$delta[$question_val['comp_def_id']]=$delta_val."_1";
										}
									}
								}
							}
							$comp_questions_inbasket=UlsQuestionValues::get_allquestion_values_competency_unique_admin($ass_detail_inbaskets['inb_assess_test_id'],$testype,$emp_id,$ass_details['assessment_id']);
							$match_inb_count=0;
							if(count($comp_questions_inbasket)>0){
								foreach($comp_questions_inbasket as $keys=>$comp_question_in){
									$criticality=UlsCompetencyPositionRequirements::get_competency_position($comp_question_in['position_id'],$comp_question_in['comp_def_id']);
									$deltasplit=explode("_",$delta[$comp_question_in['comp_def_id']]);
									if($deltasplit[0]==0){
										$delval=$deltasplit[0];
									}
									else{
										$delval=$deltasplit[0]/$deltasplit[1];
									}
									$num_inb='';
									$req_scale_num=UlsLevelMasterScale::levelscale_detail($comp_question_in['scale_id']);
									if($criticality['comp_cri_code']=='C1'){
										if($delval<=1){
											$sel_ass=$comp_question_in['scale_number'];
										}
										else{
											$sel_ass=($comp_question_in['scale_number']-1);
										}
									}
									else{
										if($delval<=2){
											$sel_ass=$comp_question_in['scale_number'];
										}
										else{
											$sel_ass=($comp_question_in['scale_number']-1);
										}
									}
									//echo "<br>".$sel_ass;
									if($comp_question_in['scale_number']>$sel_ass){
										$less_ass_comp_inbasket=$comp_question_in['comp_def_name'];
									}
									else{
										$less_ass_comp_inbasket="";
									}
									$less_ass_comp_inb[]=$less_ass_comp_inbasket;
									$selass=($sel_ass==0)?1:$sel_ass;
									$match_inb_count+=($selass==$comp_question_in['scale_number'])?1:0;
									$ass_level=UlsLevelMaster::viewlevel($comp_question_in['comp_def_level']);
									$ass_level_scale=UlsLevelMasterScale::level_scale_detail_tni($ass_level['level_id'],$selass);
									$sel_ass_scale=$ass_level_scale['scale_id'];
									$inbasket_comp_data="<br>".$comp_question_in['comp_def_id']."-".$comp_question_in['comp_def_name']."-".$comp_question_in['scale_id']."-".$sel_ass_scale."-".$match_inb_count."-".$selass;
									
									$compid=UlsAssessmentReport::getadminassessment_com_insert_admin($ass_details['assessment_id'],$position_id,$emp_id,$comp_question_in['comp_def_id']);
									$master_value=isset($compid['report_id'])?Doctrine::getTable('UlsAssessmentReport')->find($compid['report_id']): new UlsAssessmentReport();
									$master_value->assessment_id=$ass_details['assessment_id'];
									$master_value->position_id=$position_id;
									$master_value->employee_id=$emp_id;
									$master_value->competency_id=$comp_question_in['comp_def_id'];
									$master_value->require_scale_id=$comp_question_in['scale_id'];
									$master_value->assessor_id=$_SESSION['emp_id'];
									$master_value->save();
									
									$master_results_inbasket=UlsAssessmentReportBytype::summary_details($master_value->report_id,$ass_details['assessment_type'],$comp_question_in['comp_def_id']);
									$master_value_sub=!empty($master_results_inbasket['report_assess_id'])?Doctrine::getTable('UlsAssessmentReportBytype')->find($master_results_inbasket['report_assess_id']): new UlsAssessmentReportBytype();
									$master_value_sub->report_id=$master_value->report_id;
									$master_value_sub->inb_assess_test_id=$comp_question_in['inb_assess_test_id'];
									$master_value_sub->assessment_id=$master_value->assessment_id;
									$master_value_sub->position_id=$master_value->position_id;
									$master_value_sub->employee_id=$master_value->employee_id;
									$master_value_sub->assessor_id=$master_value->assessor_id;
									$master_value_sub->assessment_type=$ass_details['assessment_type'];
									$master_value_sub->competency_id=$comp_question_in['comp_def_id'];
									$master_value_sub->require_scale_id=$master_value->require_scale_id;
									$master_value_sub->assessed_scale_id=$sel_ass_scale;
									$master_value_sub->save(); 
								}
							}
							//print_r((array_filter($less_ass_comp_inb)));
							$array_data_inbasket=array_filter($less_ass_comp_inb);
							$inbasket_comment_comp="";
							$key=1;
							foreach($array_data_inbasket as $array_data_inbaskets){
								$inbasket_comment_comp.=$key.".".$array_data_inbaskets."<br>";
								$key++;
							}
							if(count($array_data_inbasket)==0){
								$inbasket_comments="The candidate was found to be competent in all the areas at the current level of work. He may be trained and made ready to take up responsibilities at the next level.";
							}
							else{
								$inbasket_comments="Except for ".count($array_data_inbasket)." competencies the candidate was found to meet the required levels.<br>
								The following are his Development areas:<br>
								".$inbasket_comment_comp."";
							}
							
							
							$total_inb_count=count($comp_questions_inbasket);
							$inbratingscale=round(($match_inb_count/$total_inb_count)*100,2);
							$assdetails=UlsAssessmentDefinition::viewassessment($ass_details['assessment_id']);
							$rat_number="";
							if($inbratingscale>85){
								$rat_number=4;
								//$rating_id_scale="Very Good";
							}
							elseif($inbratingscale>=65 && $inbratingscale<=84.9){
								$rat_number=3;
							}
							elseif($inbratingscale>=45 && $inbratingscale<=64.9){
								$rat_number=2;
							}
							else{
								$rat_number=1;
							}
							//echo $rat_number;
							$rating_id_scale=UlsRatingMasterScale::ratingscale_number($assdetails['rating_id'],$rat_number);
							$inbasket_rating_scale=$rating_id_scale['scale_id'];
							$rating_process_id=UlsAssessmentAssessorRating::get_ass_rating_process_admin($ass_details['assessment_id'],$position_id,$emp_id,$ass_details['assessment_type']);
							$role=!empty($rating_process_id['ass_rating_id'])? Doctrine_Core::getTable('UlsAssessmentAssessorRating')->find($rating_process_id['ass_rating_id']):new UlsAssessmentAssessorRating();
							$role->scale_id=$inbasket_rating_scale;
							$role->attempt_id=$testdetail_insert['attempt_id'];
							$role->employee_id=$emp_id;
							$role->position_id=$position_id;
							$role->assessment_id=$ass_details['assessment_id'];
							$role->assessment_type=$ass_details['assessment_type'];
							$role->assessor_id=$_SESSION['emp_id'];
							$role->comments=$inbasket_comments;
							$role->status='A';
							$role->save();
						}
					}
					elseif($ass_details['assessment_type']=='FISHBONE'){
						$ass_detail_fishbone=UlsAssessmentTestFishbone::getfishboneassessment($ass_tests['assess_test_id']);
						$testype="'".$ass_details['assessment_type']."'";
						foreach($ass_detail_fishbone as $ass_detail_fishbones){
							//$testdetails=UlsUtestResponsesAssessment::gettesttakenquestions_inbasket($ass_detail_fishbones['test_id'],$testype,$ass_details['assessment_id'],$ass_tests['assess_test_id'],$emp_id);
							$testdetails=UlsUtestResponsesAssessment::gettesttakenquestions_fishbone($ass_detail_fishbones['test_id'],$testype,$ass_details['assessment_id'],$ass_tests['assess_test_id'],$emp_id);
							$comp_question_fish=UlsQuestionValues::get_allquestion_values_competency_unique_assessor_fishbone_admin($ass_detail_fishbones['fish_assess_test_id'],$testype,$emp_id,$ass_details['assessment_id']);
							$total_points=0;
							if(count($testdetails)>0){
								foreach($testdetails as $keys=>$testdetail){
									$ss=UlsFishboneListProbable::getfishbonecause($testdetail['fishbone_quest_id']);
									$valuename=Doctrine_Query::Create()->from("UlsUtestResponsesAssessment")->where("employee_id=".$emp_id." and test_type=".$testype." and event_id=".$ass_tests['assess_test_id']." and  assessment_id=".$ass_details['assessment_id'])->fetchOne();
									$ched=json_decode($valuename->text);
									$p_comment="";
									$s_order="";
									$p_reason="";
									$points=0;
									foreach($ched as $key=>$cheds){
										$p_comment=$cheds->head;
										$p_reason=$cheds->reason;
										$casue_details=UlsFishboneListProbable::get_fishbone_cause($cheds->id);
										$points+=($cheds->head==$casue_details['head_list'])?1:0;
										$totalpoints=25;
										//echo "<br>".$casue_details['probable_causes']."-".$cheds->head."-".$casue_details['head_list']."-".$points;
									}
									$total_points=round((($points/$totalpoints)*100),2);
									if(count($comp_question_fish)>0){
										foreach($comp_question_fish as $keys=>$comp_question_fishs){
											if($total_points>90){
												$sel_ass_fish=($comp_question_fishs['scale_number']+1);
											}
											elseif($total_points>=70 && $total_points<=89.9){
												$sel_ass_fish=$comp_question_fishs['scale_number'];
											}
											elseif($total_points<70){
												$sel_ass_fish=($comp_question_fishs['scale_number']-1);
											}
											$ass_level=UlsLevelMaster::viewlevel($comp_question_fishs['comp_def_level']);
											$ass_level_scale=UlsLevelMasterScale::level_scale_detail_tni($ass_level['level_id'],$sel_ass_fish);
											$sel_ass_scale_fish=$ass_level_scale['scale_id'];
											$fishbone_comp="<br>".$comp_question_fishs['comp_def_id']."-".$comp_question_fishs['comp_def_name']."-".$comp_question_fishs['scale_id']."-".$sel_ass_scale_fish;
											if($comp_question_fishs['scale_number']>$sel_ass_fish){
												$less_ass_comp_fishbone=$comp_question_fishs['comp_def_name'];
											}
											else{
												$less_ass_comp_fishbone="";
											}
											$less_ass_comp_fish[]=$less_ass_comp_fishbone;
											$compid=UlsAssessmentReport::getadminassessment_com_insert_admin($ass_details['assessment_id'],$position_id,$emp_id,$comp_question_fishs['comp_def_id']);
											$master_value=isset($compid['report_id'])?Doctrine::getTable('UlsAssessmentReport')->find($compid['report_id']): new UlsAssessmentReport();
											$master_value->assessment_id=$ass_details['assessment_id'];
											$master_value->position_id=$position_id;
											$master_value->employee_id=$emp_id;
											$master_value->competency_id=$comp_question_fishs['comp_def_id'];
											$master_value->require_scale_id=$comp_question_fishs['scale_id'];
											$master_value->assessor_id=$_SESSION['emp_id'];
											$master_value->save();
											
											$master_results=UlsAssessmentReportBytype::summary_details($master_value->report_id,$ass_details['assessment_type'],$comp_question_fishs['comp_def_id']);
											$master_value_sub=!empty($master_results['report_assess_id'])?Doctrine::getTable('UlsAssessmentReportBytype')->find($master_results['report_assess_id']): new UlsAssessmentReportBytype();
											$master_value_sub->report_id=$master_value->report_id;
											$master_value_sub->fish_assess_test_id=$comp_question_fishs['fish_assess_test_id'];
											$master_value_sub->assessment_id=$master_value->assessment_id;
											$master_value_sub->position_id=$master_value->position_id;
											$master_value_sub->employee_id=$master_value->employee_id;
											$master_value_sub->assessor_id=$master_value->assessor_id;
											$master_value_sub->assessment_type=$ass_details['assessment_type'];
											$master_value_sub->competency_id=$comp_question_fishs['comp_def_id'];
											$master_value_sub->require_scale_id=$master_value->require_scale_id;
											$master_value_sub->assessed_scale_id=$sel_ass_scale_fish;
											$master_value_sub->save();
										}
									}
								}
							}
							//print_r(array_filter($less_ass_comp_fish));
							$array_data_fish=(array_filter($less_ass_comp_fish));
							$fish_comment_comp="";
							$key=1;
							foreach($array_data_fish as $array_data_fishs){
								$fish_comment_comp.=$key.".".$array_data_fishs."<br>";
								$key++;
							}
							if(count($array_data_fish)==0){
								$fish_comments="The candidate was found to be competent in all the areas at the current level of work. He may be trained and made ready to take up responsibilities at the next level.";
							}
							else{
								$fish_comments="Except for ".count($array_data_fish)." competencies the candidate was found to meet the required levels.<br>
								The following are his Development areas:<br>
								".$fish_comment_comp."";
							}
							
							$assdetails=UlsAssessmentDefinition::viewassessment($ass_details['assessment_id']);
							$rat_number="";
							if($total_points>85){
								$rat_number=4;
								//$rating_id_scale="Very Good";
							}
							elseif($total_points>=65 && $total_points<=84.9){
								$rat_number=3;
							}
							elseif($total_points>=45 && $total_points<=64.9){
								$rat_number=2;
							}
							else{
								$rat_number=1;
							}
							//echo $rat_number;
							$rating_id_scale=UlsRatingMasterScale::ratingscale_number($assdetails['rating_id'],$rat_number);
							$fishbone_rating_scale=$rating_id_scale['scale_id'];
							$rating_process_id=UlsAssessmentAssessorRating::get_ass_rating_process_admin($ass_details['assessment_id'],$position_id,$emp_id,$ass_details['assessment_type']);
							$role=!empty($rating_process_id['ass_rating_id'])? Doctrine_Core::getTable('UlsAssessmentAssessorRating')->find($rating_process_id['ass_rating_id']):new UlsAssessmentAssessorRating();
							$role->scale_id=$fishbone_rating_scale;
							$role->attempt_id=$testdetail_insert['attempt_id'];
							$role->employee_id=$emp_id;
							$role->position_id=$position_id;
							$role->assessment_id=$ass_details['assessment_id'];
							$role->assessment_type=$ass_details['assessment_type'];
							$role->assessor_id=$_SESSION['emp_id'];
							$role->comments=$fish_comments;
							$role->status='A';
							$role->save();
						}
					} 
				}
				
				$final_report_ass_rating=UlsAssessmentReportBytype::summary_detail_info_report_admin($id,$position_id,$emp_id);
				foreach($final_report_ass_rating as $final_report_ass_ratings){
					$ass_num=$final_report_ass_ratings['ass_scale_number'];
					$ass_level_id=UlsLevelMasterScale::level_scale_detail_tni($final_report_ass_ratings['level_id'],$ass_num);
					$master_value=!empty($final_report_ass_ratings['report_id'])?Doctrine::getTable('UlsAssessmentReport')->find($final_report_ass_ratings['report_id']): new UlsAssessmentReport();
					$master_value->ass_dy_id=$ass_num;
					$master_value->save();
				}
				
				$assresults=UlsAssessmentTest::assessment_results_avg_admin($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
				$results_com=array();
				foreach($assresults as $assresult){
					$compid=$assresult['comp_def_id'];
					$finalval=!empty($assresult['assessor_val'])?round(($assresult['ass_number']*$assresult['assessor_val']),2):$assresult['ass_number'];
					$total_percenatge=round((($finalval/$assresult['req_number'])*100),2);
					
					if($total_percenatge<=80){
						$results_com[$assresult['comp_def_id']]['comp_id']=$compid;
						$results_com[$assresult['comp_def_id']]['comp_name']=$assresult['comp_def_name'];
						$results_com[$assresult['comp_def_id']]['final']=$finalval;
						$results_com[$assresult['comp_def_id']]['required']=$assresult['req_number'];
						$results_com[$assresult['comp_def_id']]['total']=$total_percenatge;
					}
				}
				
				$final_commenets="";
				$key=1;
				if(!empty($results_com)){
					$final_commenets.="The following are his Development areas:<br><br>";
					foreach($results_com as $results_coms){
						$final_commenets.="<b>".$key.". ".$results_coms['comp_name']."</b><br>";
						$key++;
					}
				}
				else{
					$final_commenets.="The candidate was found to be competent in all the areas at the current level of work. He may be trained and made ready to take up responsibilities at the next level.";
				}
				
				
				
				$ass_test_final=UlsAssessmentReportFinal::assessment_assessor_final($id,$position_id,$emp_id,$_SESSION['emp_id']);
				$master_value_final=!empty($ass_test_final['final_id'])?Doctrine::getTable('UlsAssessmentReportFinal')->find($ass_test_final['final_id']): new UlsAssessmentReportFinal();
				$master_value_final->assessment_id=$id;
				$master_value_final->position_id=$position_id;
				$master_value_final->employee_id=$emp_id;
				$master_value_final->assessor_id=$_SESSION['emp_id'];
				$master_value_final->comments=$final_commenets;
				$master_value_final->status='A';
				$master_value_final->save();
			}
			$data['final_deve_comments']=UlsAssessmentReportFinal::assessment_report_final_admin($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$posdetails=UlsPosition::viewposition($_REQUEST['pos_id']);
			$data['posdetails']=$posdetails;
			$empd=UlsEmployeeMaster::get_empdetails_id($_REQUEST['emp_id']);
			$data['emp_info']=$empd;
			$data['competencies']=UlsAssessmentCompetencies::getassessment_competencies_type($id,$_REQUEST['pos_id']);
			//$data['ass_comp_info']=UlsAssessmentReport::getassessment_admin_summary($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['category']=UlsCompetencyPositionRequirements::category_comp_details($_REQUEST['pos_id']);
			$data['scale_info_four']=UlsLevelMasterScale::scale_values_level_four();
			$data['scale_info_five']=UlsLevelMasterScale::scale_values_level_five();
			$data['cri_info']=UlsCompetencyCriticality::criticality_names();
			$beh_asstype="BEHAVORIAL_INSTRUMENT";
			$data['beh_instrument']=UlsAssessmentTest::get_ass_position_test($id,$_REQUEST['pos_id'],$beh_asstype);
			$data['kras']=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($_REQUEST['pos_id']);
			$data['testtypes']=UlsAssessmentTest::get_assessment_position($id,$_REQUEST['pos_id']);
			$data['modes']=UlsAdminMaster::get_value_names("IN_MODE");
			$data['ass_results']=UlsAssessmentTest::assessment_results_avg($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['assessor_rating_new']=UlsAssessmentAssessorRating::assessor_results_report_new($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			//$data['assessor_rating']=UlsAssessmentAssessorRating::assessor_results_report($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['ass_rating_scale']=UlsAssessmentDefinition::view_assessment_rating($id);
			$data['ass_development']=UlsAssessmentReport::getassessment_competencies_summary_report($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['ass_rating_comments']=UlsAssessmentAssessorRating::get_ass_rating_comments($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['assmethods']=UlsAssessmentTest::get_assessment_position_report($_REQUEST['ass_id'],$_REQUEST['pos_id']);
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
				'marker_size'       => 6,		  'axis_max_v'  => 4,'grid_division_v' =>1,
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
			if($ass_pos_details['assessor_process']=='N'){
				$assresults=UlsAssessmentTest::assessment_results_avg_admin($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			}
			else{
				$assresults=UlsAssessmentTest::assessment_results_avg($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			}
			$data['assresults']=$assresults;
			$results=$ass_comname=$ass_req_sid=$ass_given_sid=array();
			
			foreach($assresults as $assresult){
				$compid=$assresult['comp_def_id'];
				if($ass_pos_details['assessor_process']=='N'){
					$finalval=!empty($assresult['assessor_val'])?round(($assresult['ass_number']*$assresult['assessor_val']),2):$assresult['ass_number'];
				}
				else{
					$finalval=!empty($assresult['assessor_val'])?round(($assresult['ass_scale_number']*$assresult['assessor_val']),2):$assresult['ass_scale_number'];
				}
				$results[$assresult['comp_def_id']]['comp_id']=$compid;
				$results[$assresult['comp_def_id']]['comp_name']=$assresult['comp_def_name'];
				$results[$assresult['comp_def_id']]['req_val']=$assresult['req_number'];
				$results[$assresult['comp_def_id']]['assessor'][$assresult['assessor_id']]=$finalval;
			}
			$req_sid=$ass_sid=$comname=$comp_id=array();
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
			$assessor_rating_new=UlsAssessmentAssessorRating::assessor_results_report_new($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$result_s=array();
			foreach($assessor_rating_new as $assessor_rating_news){
				$finalval=!empty($assessor_rating_news['assessor_val'])?round(($assessor_rating_news['rat_num']*$assessor_rating_news['assessor_val']),2):$assessor_rating_news['rat_num'];
				$result_s[$assessor_rating_news['assessment_type']]['assessment_type']=$assessor_rating_news['assessment_type'];
				$result_s[$assessor_rating_news['assessment_type']]['assess_type']=$assessor_rating_news['assess_type'];
				$result_s[$assessor_rating_news['assessment_type']]['weightage']=$assessor_rating_news['weightage'];
				$result_s[$assessor_rating_news['assessment_type']]['test_ques']=$assessor_rating_news['test_ques'];
				$result_s[$assessor_rating_news['assessment_type']]['test_score']=$assessor_rating_news['test_score'];
				$result_s[$assessor_rating_news['assessment_type']]['rating_scale']=$assessor_rating_news['rating_scale'];
				$result_s[$assessor_rating_news['assessment_type']]['assessor'][$assessor_rating_news['assessor_id']]=$finalval;
			}
			//$assessor_rating=UlsAssessmentAssessorRating::assessor_results_report($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$wei_total=0;
			foreach($result_s as $key1=>$assessor_ratings){
				$score_final=$scorefinal=0;
				if($assessor_ratings['assessment_type']=='TEST'){
					$score_test=(($assessor_ratings['test_score']/$assessor_ratings['test_ques'])*100);
					$wei=$assessor_ratings['weightage'];
					echo $score_final=round((($score_test*$wei)/100),2);
				}
				else{
					$final=0;
					foreach($assessor_ratings['assessor'] as $key2=>$ass_id){
						$final=$final+$result_s[$key1]['assessor'][$key2];
					}
					$final=round($final/count($result_s[$key1]['assessor']),2);
					$score=(($final/$assessor_ratings['rating_scale'])*100);
					$wei=$assessor_ratings['weightage'];
					echo $scorefinal=round((($score*$wei)/100),2);
				} 
				$wei_total=round($wei_total+($score_final+$scorefinal),2);
			}
			$data['weitotal']=$wei_total;
			$a=540;
			$b=(540*$wei_total)/100;
			$value='<svg version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" width="800" height="100"><g transform="translate(220,5)"><rect width="540" height="25" x="0" style=" fill: #eee;"></rect><rect width="'.$a.'" height="8.333333333333334" x="0" y="8.333333333333334" style=" fill: #1d598b;"></rect><line style="stroke: #e89134; stroke-width: 5px;" x1="'.$b.'" x2="'.$b.'" y1="0" y2="25"></line><g transform="translate(0,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >0</text></g><g><line x1="10.8" x2="10.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="21.6" x2="21.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="32.4" x2="32.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="43.2" x2="43.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="64.8" x2="64.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="75.6" x2="75.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="86.4" x2="86.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="97.2" x2="97.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="118.8" x2="118.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="129.6" x2="129.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="140.4" x2="140.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="151.2" x2="151.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="172.8" x2="172.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="183.6" x2="183.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="194.4" x2="194.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="205.2" x2="205.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="226.8" x2="226.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="237.6" x2="237.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="248.4" x2="248.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="259.2" x2="259.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="280.8" x2="280.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="291.6" x2="291.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="302.4" x2="302.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="313.2" x2="313.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="334.8" x2="334.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="345.6" x2="345.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="356.4" x2="356.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="367.2" x2="367.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="388.8" x2="388.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="399.6" x2="399.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="410.4" x2="410.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="421.2" x2="421.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="442.8" x2="442.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="453.6" x2="453.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="464.4" x2="464.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="475.2" x2="475.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="496.8" x2="496.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="507.6" x2="507.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="518.4" x2="518.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="529.2" x2="529.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g transform="translate(54,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >10</text></g><g transform="translate(108,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >20</text></g><g transform="translate(162,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >30</text></g><g transform="translate(216,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >40</text></g><g transform="translate(270,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >50</text></g><g transform="translate(324,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >60</text></g><g transform="translate(378,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >70</text></g><g transform="translate(432,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >80</text></g><g transform="translate(486,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >90</text></g><g transform="translate(540,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >100</text></g><g style="text-anchor: end;" transform="translate(-6,12.5)"><text font-size="16px" style="font-family:sans-serif;">Overall Score</text></g></g></svg>';
			$myfile1 = fopen($target_path.DS.'over_all'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'.svg', "w") or die("Unable to open file!");
			fwrite($myfile1, $value);
			fclose($myfile1);
		
			//$content = $this->load->view('pdf/assessment_report_new',$data,true);
			//$filename = "Employee - ".$empd['enumber']."-".$empd['name']." - Competency Profile";
			//$this->pdfgenerator->generate($content, $filename, true, 'A4', 'portrait','competency_profiling');
			
			echo $content = $this->load->view('pdf/assessment_report_energy_update',$data,true);		
			$this->render('layouts/ajax-layout',$content);
		}		
	}
	
	public function emp_single_report(){
		$this->load->library('tcpdf');
		$this->load->library('pdfgenerator');
		$ass_type=isset($_REQUEST['ass_type'])? $_REQUEST['ass_type']:"";
		$id=isset($_REQUEST['ass_id'])? $_REQUEST['ass_id']:"";
		$data['ass_id']=$id;
		$data['pos_id']=$_REQUEST['pos_id'];
		$data['emp_id']=$_REQUEST['emp_id'];
		$empd=UlsEmployeeMaster::get_empdetails_id($_REQUEST['emp_id']);
		$data['emp_info']=$empd;
		$posdetails=UlsPosition::viewposition($_REQUEST['pos_id']);
		$data['posdetails']=$posdetails;
		$emp_pre_report=UlsAssessmentEmployees::get_assessment_employees_prereport($_REQUEST['emp_id'],$_REQUEST['ass_id'],$_REQUEST['pos_id']);
		$assessor_rating_new=UlsAssessmentAssessorRating::assessor_results_report_new($_REQUEST['ass_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id']);
		$data['assessor_rating_new']=$assessor_rating_new;
		$results=array();
		foreach($assessor_rating_new as $assessor_rating_news){
			$finalval=!empty($assessor_rating_news['assessor_val'])?round(($assessor_rating_news['rat_num']*$assessor_rating_news['assessor_val']),2):$assessor_rating_news['rat_num'];
			$results[$assessor_rating_news['assessment_type']]['assessment_type']=$assessor_rating_news['assessment_type'];
			$results[$assessor_rating_news['assessment_type']]['assess_type']=$assessor_rating_news['assess_type'];
			$results[$assessor_rating_news['assessment_type']]['weightage']=$assessor_rating_news['weightage'];
			$results[$assessor_rating_news['assessment_type']]['test_ques']=$assessor_rating_news['test_ques'];
			$results[$assessor_rating_news['assessment_type']]['test_score']=$assessor_rating_news['test_score'];
			$results[$assessor_rating_news['assessment_type']]['rating_scale']=$assessor_rating_news['rating_scale'];
			$results[$assessor_rating_news['assessment_type']]['assessor'][$assessor_rating_news['assessor_id']]=$finalval;
		}
		$i=1;
		$score='';
		$wei_sum=0;
		$wei_total=0;$kk=0;
		foreach($results as $key1=>$assessor_ratings){
			$wei_sum=($wei_sum+$assessor_ratings['weightage']);
			$kk++;
			if($assessor_ratings['assessment_type']=='TEST'){
				$score_test=$assessor_ratings['test_score'];
				$score_test_f=$score_test;
			}
			else{
				$final=0;
				foreach($assessor_ratings['assessor'] as $key2=>$ass_id){
					$final=$final+$results[$key1]['assessor'][$key2];
				}
				$final=round($final/count($results[$key1]['assessor']),2);
				$score=round($final,2);
				$score_f=$score;
				
			}
			if($assessor_ratings['assessment_type']=='TEST'){
				$score_test=(($assessor_ratings['test_score']/$assessor_ratings['test_ques'])*100);
				
			}
			else{
				$final=0;
				foreach($assessor_ratings['assessor'] as $key2=>$ass_id){
					$final=$final+$results[$key1]['assessor'][$key2];
				}
				$final=round($final/count($results[$key1]['assessor']),2);
				$score=(($final/$assessor_ratings['rating_scale'])*100);
			}
			$score_final=$scorefinal=0;
			if($assessor_ratings['assessment_type']=='TEST'){
				$score_test=(($assessor_ratings['test_score']/$assessor_ratings['test_ques'])*100);
				$wei=$assessor_ratings['weightage'];
				$score_final=round((($score_test*$wei)/100),2);
				
			}
			else{
				$final=0;
				foreach($assessor_ratings['assessor'] as $key2=>$ass_id){
					$final=$final+$results[$key1]['assessor'][$key2];
				}
				$final=round($final/count($results[$key1]['assessor']),2);
				$score=(($final/$assessor_ratings['rating_scale'])*100);
				$wei=$assessor_ratings['weightage'];
				$scorefinal=round((($score*$wei)/100),2);
				
			} 
			$wei_total=round($wei_total+($score_final+$scorefinal),2);
		}
		$update=Doctrine_Query::create()->update('UlsAssessmentEmployees');
		$update->set('final_score','?',$wei_total);
		$update->where('assessment_id=?',$_REQUEST['ass_id']);
		$update->andwhere('position_id=?',$_REQUEST['pos_id']);
		$update->andwhere('employee_id=?',$_REQUEST['emp_id']);
		$update->limit(1)->execute();
		$emp_post_report=UlsAssessmentEmployees::get_assessment_employees_comp($_REQUEST['emp_id'],$emp_pre_report['assessment_id'],$_REQUEST['pos_id']);
		$empprereport=UlsAssessmentEmployees::get_assessment_employees_comp($_REQUEST['emp_id'],$_REQUEST['ass_id'],$_REQUEST['pos_id']);
		$sec_score=($empprereport['final_score']*2.7);
		$second_svg='<svg width="300" height="100" xmlns="http://www.w3.org/2000/svg">
		  <!-- Color bars -->
		  <rect x="0" y="50" width="30" height="20" fill="#8B0000"/>
		  <rect x="30" y="50" width="30" height="20" fill="#B22222"/>
		  <rect x="60" y="50" width="30" height="20" fill="#DC143C"/>
		  <rect x="90" y="50" width="30" height="20" fill="#FF4500"/>
		  <rect x="120" y="50" width="30" height="20" fill="#FFA500"/>
		  <rect x="150" y="50" width="30" height="20" fill="#FFD700"/>
		  <rect x="180" y="50" width="30" height="20" fill="#9ACD32"/>
		  <rect x="210" y="50" width="30" height="20" fill="#32CD32"/>
		  <rect x="240" y="50" width="30" height="20" fill="#228B22"/>

		  <!-- Downward arrow -->
		  <polygon points="'.($sec_score-5).',40,'.($sec_score).',50,'.($sec_score+5).',40"  style="fill:lime;stroke:purple;stroke-width:0" />

		  <!-- Labels -->
		  <text x="150" y="25" font-size="14" text-anchor="middle" fill="black">2nd Assessment Score</text>
		  <text x="150" y="100" font-size="16" text-anchor="middle" fill="black">'.$empprereport['final_score'].'</text>
		</svg>';
		$target_path=__SITE_PATH.DS.'public'.DS.'reports'.DS.'graphs'.DS.'full'.DS.$_REQUEST['ass_id'];
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

		$myfile = fopen($target_path.DS.$_REQUEST['emp_id']."_".$_REQUEST['pos_id'].'_main_secound_ass.svg', "w") or die("Unable to open file!");
		fwrite($myfile, $second_svg);
		fclose($myfile);
		$first_score=($emp_post_report['final_score']*2.7);
		$first_svg='<svg width="300" height="100" xmlns="http://www.w3.org/2000/svg">
		  <!-- Color bars -->
		  <rect x="0" y="50" width="30" height="20" fill="#8B0000"/>
		  <rect x="30" y="50" width="30" height="20" fill="#B22222"/>
		  <rect x="60" y="50" width="30" height="20" fill="#DC143C"/>
		  <rect x="90" y="50" width="30" height="20" fill="#FF4500"/>
		  <rect x="120" y="50" width="30" height="20" fill="#FFA500"/>
		  <rect x="150" y="50" width="30" height="20" fill="#FFD700"/>
		  <rect x="180" y="50" width="30" height="20" fill="#9ACD32"/>
		  <rect x="210" y="50" width="30" height="20" fill="#32CD32"/>
		  <rect x="240" y="50" width="30" height="20" fill="#228B22"/>

		  <!-- Downward arrow -->
		  <polygon points="'.($first_score-5).',40,'.($first_score).',50,'.($first_score+5).',40"  style="fill:lime;stroke:purple;stroke-width:0" />

		  <!-- Labels -->
		  <text x="150" y="25" font-size="14" text-anchor="middle" fill="black">1st Assessment Score</text>
		  <text x="150" y="100" font-size="16" text-anchor="middle" fill="black">'.$emp_post_report['final_score'].'</text>
		</svg>';
		$target_path=__SITE_PATH.DS.'public'.DS.'reports'.DS.'graphs'.DS.'full'.DS.$_REQUEST['ass_id'];
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

		$myfile = fopen($target_path.DS.$_REQUEST['emp_id']."_".$_REQUEST['pos_id'].'_main_first_ass.svg', "w") or die("Unable to open file!");
		fwrite($myfile, $first_svg);
		fclose($myfile);
		$change_final=($empprereport['final_score']-$emp_post_report['final_score']);
		
		if($change_final>0){
		$triange='<polygon points="102,60 112,40 122,60" fill="#2e7d32"/>';
		}
		else{
		$triange='<polygon points="102,40 112,60 122,40" fill="#FF0000"/>';
		}
		$change_svg='
		<svg width="200" height="100" xmlns="http://www.w3.org/2000/svg">
			  <!-- Yellow label background -->
			 
			  <text x="100" y="18" font-size="12" text-anchor="middle" font-family="Arial, sans-serif">Change</text>

			  <!-- Value -->
			  <text x="95" y="60" font-size="24" text-anchor="end" fill="#111111" font-family="Arial, sans-serif">'.$change_final.'</text>

			  <!-- Larger upward triangle -->
			 
			  '.$triange.'
		</svg>
		';
		$myfile = fopen($target_path.DS.$_REQUEST['emp_id']."_".$_REQUEST['pos_id'].'_main_change_ass.svg', "w") or die("Unable to open file!");
		fwrite($myfile, $change_svg);
		fclose($myfile);
		$ass_test_info_two=UlsAssessmentTest::get_ass_position($emp_pre_report['assessment_id'],$_REQUEST['pos_id'],'TEST');
		$ass_test_info=UlsAssessmentTest::get_ass_position($_REQUEST['ass_id'],$_REQUEST['pos_id'],'TEST');
		$comp_questions=UlsAssessmentTestQuestions::gettestquestions_report($ass_test_info['assess_test_id'],$ass_test_info['test_id'],$ass_test_info['assessment_type'],$_REQUEST['emp_id'],$ass_test_info['assessment_id']);
		$data['comp_questions']=$comp_questions;
		$kkk_test=1;
		$kkcomp_idnew_test=array();
		foreach($comp_questions as $comp_question){
			$comp_id=$comp_question['competency_id'];
			$comp_name=$comp_question['comp_def_name'];
			//$kktestcomp_id[$comp_name]="C".($kkk_test);
			$kktestcomp_id[$comp_name]=$comp_name;
			
			$cor_count_one=UlsUtestResponsesAssessment::question_count_correct($comp_question['q_id'],$_REQUEST['emp_id'],$ass_test_info_two['assess_test_id'],$emp_pre_report['assessment_id']);
			$blank_count_one=UlsUtestResponsesAssessment::question_count_leftblank($comp_question['q_id'],$_REQUEST['emp_id'],$ass_test_info_two['assess_test_id'],$emp_pre_report['assessment_id']);
			$total_one=@explode(",",$comp_question['q_id']);
			$total_question_one=($blank_count_one['l_count'])>0?(count($total_one)-$blank_count_one['l_count']):count($total_one);
			//echo $comp_id."-".count($total_one)."<br>";
			//echo $comp_id."-".$blank_count_one['l_count']."<br>";
			$total_per_one=($cor_count_one['c_count']>0)?(round((($cor_count_one['c_count']/$total_question_one)*100),2)):0;
			$kkass_sid_test[$comp_name]=$total_per_one;
			$cor_count_two=UlsUtestResponsesAssessment::question_count_correct($comp_question['q_id'],$_REQUEST['emp_id'],$ass_test_info['assess_test_id'],$_REQUEST['ass_id']);
			$blank_count_two=UlsUtestResponsesAssessment::question_count_leftblank($comp_question['q_id'],$_REQUEST['emp_id'],$ass_test_info['assess_test_id'],$_REQUEST['ass_id']);
			$total_two=@explode(",",$comp_question['q_id']);
			$total_question_two=($blank_count_two['l_count'])>0?(count($total_two)-$blank_count_two['l_count']):count($total_two);
			$total_per_two=($cor_count_two['c_count']>0)?(round((($cor_count_two['c_count']/$total_question_two)*100),2)):0;
			$kkass_sid_new_test[$comp_name]=$total_per_two;
			//$kkcomp_idnew_test[]=$comp_id;
			$kkcomp_idnew_test[]=$comp_question['comp_def_name'];
			$kkk_test++;
		}
		/* echo "<pre>";
		print_r($kkass_sid_test); */
		$new_comp_bar_test=$old_comp_bar_test=array();
		foreach($kkcomp_idnew_test as $kkcomp_idnew_tests){
			$a=$kktestcomp_id[$kkcomp_idnew_tests];
			$new_comp_bar_test[$a]=$kkass_sid_new_test[$kkcomp_idnew_tests];
			$old_comp_bar_test[$a]=$kkass_sid_test[$kkcomp_idnew_tests];
		}
		require_once(LIB_PATH.DS.DS.'graph'.DS.'includes'.DS.'SVGGraph.php');
		$settings = array(
		  'auto_fit' => true,
		  'back_colour' => '#eee',
		  'back_stroke_width' => 0,
		  'back_stroke_colour' => '#eee',
		  'stroke_colour' => '#000',
		  'axis_colour' => '#333',
		  'axis_overlap' => 2,
		  'grid_colour' => '#fff',
		  'label_colour' => '#000',
		  'axis_font' => 'Arial',
		  'axis_font_size' => 16,
		  'pad_right' => 20,
		  'pad_left' => 20,
		  'link_base' => '/',
		  'link_target' => '_top',
		  'minimum_grid_spacing' => 20,
		  /* 'show_subdivisions' => true,
		  'show_grid_subdivisions' => true, 
		  'grid_subdivision_colour' => '#fff',*/
		  'show_data_labels' => true,
				'data_label_type' =>array('box'),
		  
		);
		
		

		$width = 1200;
		$height = 600;
		$values = [$old_comp_bar_test,$new_comp_bar_test];
		/* $values = [
		  ['Dough' => 30, 'Ray' => 50, 'Me' => 40, 'So' => 25, 'Far' => 45, 'Lard' => 35, 'Tea' => 35,'Doughs' => 30, 'Rays' => 50, 'Mes' => 40, 'Sos' => 25, 'Fars' => 45, 'Lards' => 35, 'Teas' => 35],
		  ['Dough' => 20, 'Ray' => 30, 'Me' => 20, 'So' => 15, 'Far' => 25, 'Lard' => 35, 'Tea' => 45,'Doughs' => 30, 'Rays' => 50, 'Mes' => 40, 'Sos' => 25, 'Fars' => 45, 'Lards' => 35, 'Teas' => 35],
		]; */

		$colours = ['#188ec8','#FFC000'] ;

		$graph = new SVGGraph($width, $height, $settings);
		$graph->colours($colours);
		$graph->values($values);
		$value11=$graph->Fetch('HorizontalGroupedBarGraph', false);//$graph->Fetch('MultiRadarGraph', false);
		$myfile = fopen($target_path.DS.$_REQUEST['emp_id']."_".$_REQUEST['pos_id'].'_competency_test.svg', "w") or die("Unable to open file!");
		fwrite($myfile, $value11);
		fclose($myfile);
		$empstatus=UlsAssessmentEmployeeFinalReport::get_assessment_employees_report_final_comp($emp_pre_report['assessment_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id'],$empprereport['comp_ids']);
		$data['compempstatus']=$empstatus;
		foreach($empstatus as $empstatuss){
			$comp_id=$empstatuss['competency_id'];
			$comp_name=$empstatuss['comp_def_name'];
			//$kkass_sid[$comp_id]=$empstatuss['assessed_value'];
			$kkass_sid[$comp_name]=$empstatuss['assessed_value'];
		}
		$kkcomp_idnew=$compid=array();
		$kkass_sid_new=$kkass_sid;
		$ass_final_re=UlsAssessmentEmployeeFinalReport::get_assessment_employees_report_final_comp($_REQUEST['ass_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id'],$empprereport['comp_ids']);
		$kkk=1;
		foreach($ass_final_re as $ass_final_res){
			$comp_id=$ass_final_res['competency_id'];
			$comp_name=$ass_final_res['comp_def_name'];
			//$kkcomp_id[$comp_id]="C".($kkk);
			$kkcomp_id[$comp_name]=$comp_name;
			$kkcomp_idnew[]=$comp_name;
			$kkass_sid_new[$comp_name]=$ass_final_res['assessed_value'];
			$kkk++;
		}
		$new_comp_bar=$old_comp_bar=array();
		foreach($kkcomp_idnew as $kkcompidnew){
			$a=$kkcomp_id[$kkcompidnew];
			$new_comp_bar[$a]=$kkass_sid_new[$kkcompidnew];
			$old_comp_bar[$a]=$kkass_sid[$kkcompidnew];
		}
		$settings_final = array(
		  'auto_fit' => true,
		  'back_colour' => '#eee',
		  'back_stroke_width' => 0,
		  'back_stroke_colour' => '#fff',
		  'stroke_colour' => '#000',
		  'axis_colour' => '#333',
		  'axis_overlap' => 2,
		  'grid_colour' => '#fff',
		  'label_colour' => '#000',
		  'axis_font' => 'Arial',
		  'axis_font_size' => 10,
		  'pad_right' => 20,
		  'pad_left' => 20,
		  'link_base' => '/',
		  'link_target' => '_top',
		  'project_angle' => 45,
		  'minimum_grid_spacing' => 20,
		 /*  'show_subdivisions' => true,
		  'show_grid_subdivisions' => true, */
		  'grid_subdivision_colour' => '#fff',
		  'axis_min_v' => 0,
				'axis_max_v' =>3,
				'grid_division_v' =>0.5,
				'axis_text_angle_h' => -45,
				'show_data_labels' => true,
				'data_label_type' =>array('circle'),
				'data_label_position' => 'above',
				'bar_width'=>30,
		);
		
		$width = 800;
		$height = 400;
		$values_final = [$new_comp_bar,$old_comp_bar];
		
		/* $value11=$graph->Fetch('GroupedBar3DGraph', false);//$graph->Fetch('MultiRadarGraph', false); */
		$colours = ['#FFC000','#188ec8'] ;
		$graph = new SVGGraph($width, $height, $settings_final);
		$graph->colours($colours);
		$graph->values($values_final);
		$value11=$graph->Fetch('GroupedBarGraph', false);//$graph->Fetch('MultiRadarGraph', false);
		$myfile = fopen($target_path.DS.$_REQUEST['emp_id']."_".$_REQUEST['pos_id'].'_competency_final.svg', "w") or die("Unable to open file!");
		fwrite($myfile, $value11);
		fclose($myfile);
		
		$data['assessor_comments']=UlsAssessmentAssessorRating::get_ass_rating_report($_REQUEST['ass_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id'],'INTERVIEW');
		
		$content = $this->load->view('pdf/assessment_report_single_new',$data,true);		
		$this->render('layouts/ajax-layout',$content);
	}
	
	public function emp_single_report_old(){
		$this->load->library('tcpdf');
		$this->load->library('pdfgenerator');
		$ass_type=isset($_REQUEST['ass_type'])? $_REQUEST['ass_type']:"";
		$id=isset($_REQUEST['ass_id'])? $_REQUEST['ass_id']:"";
		$data['ass_id']=$id;
		$data['pos_id']=$_REQUEST['pos_id'];
		$data['emp_id']=$_REQUEST['emp_id'];
		$empd=UlsEmployeeMaster::get_empdetails_id($_REQUEST['emp_id']);
		$data['emp_info']=$empd;
		$emp_pre_report=UlsAssessmentEmployees::get_assessment_employees_prereport($_REQUEST['emp_id'],$_REQUEST['ass_id'],$_REQUEST['pos_id']);
		$assessor_rating_new=UlsAssessmentAssessorRating::assessor_results_report_new($_REQUEST['ass_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id']);
		$results=array();
		foreach($assessor_rating_new as $assessor_rating_news){
			$finalval=!empty($assessor_rating_news['assessor_val'])?round(($assessor_rating_news['rat_num']*$assessor_rating_news['assessor_val']),2):$assessor_rating_news['rat_num'];
			$results[$assessor_rating_news['assessment_type']]['assessment_type']=$assessor_rating_news['assessment_type'];
			$results[$assessor_rating_news['assessment_type']]['assess_type']=$assessor_rating_news['assess_type'];
			$results[$assessor_rating_news['assessment_type']]['weightage']=$assessor_rating_news['weightage'];
			$results[$assessor_rating_news['assessment_type']]['test_ques']=$assessor_rating_news['test_ques'];
			$results[$assessor_rating_news['assessment_type']]['test_score']=$assessor_rating_news['test_score'];
			$results[$assessor_rating_news['assessment_type']]['rating_scale']=$assessor_rating_news['rating_scale'];
			$results[$assessor_rating_news['assessment_type']]['assessor'][$assessor_rating_news['assessor_id']]=$finalval;
		}
		$i=1;
		$score='';
		$wei_sum=0;
		$wei_total=0;$kk=0;
		foreach($results as $key1=>$assessor_ratings){
			$wei_sum=($wei_sum+$assessor_ratings['weightage']);
			$kk++;
			if($assessor_ratings['assessment_type']=='TEST'){
				$score_test=$assessor_ratings['test_score'];
				$score_test_f=$score_test;
			}
			else{
				$final=0;
				foreach($assessor_ratings['assessor'] as $key2=>$ass_id){
					$final=$final+$results[$key1]['assessor'][$key2];
				}
				$final=round($final/count($results[$key1]['assessor']),2);
				$score=round($final,2);
				$score_f=$score;
				
			}
			if($assessor_ratings['assessment_type']=='TEST'){
				$score_test=(($assessor_ratings['test_score']/$assessor_ratings['test_ques'])*100);
				
			}
			else{
				$final=0;
				foreach($assessor_ratings['assessor'] as $key2=>$ass_id){
					$final=$final+$results[$key1]['assessor'][$key2];
				}
				$final=round($final/count($results[$key1]['assessor']),2);
				$score=(($final/$assessor_ratings['rating_scale'])*100);
			}
			$score_final=$scorefinal=0;
			if($assessor_ratings['assessment_type']=='TEST'){
				$score_test=(($assessor_ratings['test_score']/$assessor_ratings['test_ques'])*100);
				$wei=$assessor_ratings['weightage'];
				$score_final=round((($score_test*$wei)/100),2);
				
			}
			else{
				$final=0;
				foreach($assessor_ratings['assessor'] as $key2=>$ass_id){
					$final=$final+$results[$key1]['assessor'][$key2];
				}
				$final=round($final/count($results[$key1]['assessor']),2);
				$score=(($final/$assessor_ratings['rating_scale'])*100);
				$wei=$assessor_ratings['weightage'];
				$scorefinal=round((($score*$wei)/100),2);
				
			} 
			$wei_total=round($wei_total+($score_final+$scorefinal),2);
		}
		$update=Doctrine_Query::create()->update('UlsAssessmentEmployees');
		$update->set('final_score','?',$wei_total);
		$update->where('assessment_id=?',$_REQUEST['ass_id']);
		$update->andwhere('position_id=?',$_REQUEST['pos_id']);
		$update->andwhere('employee_id=?',$_REQUEST['emp_id']);
		$update->limit(1)->execute();
		$emp_post_report=UlsAssessmentEmployees::get_assessment_employees_prereport($_REQUEST['emp_id'],$emp_pre_report['assessment_id'],$_REQUEST['pos_id']);
		$svg_main='<svg width="800" height="130" xmlns="http://www.w3.org/2000/svg">
		  <!-- Background rectangles -->
		  <rect x="20" y="20" width="220" height="200" rx="15" fill="#e6f0ff" />
		  <rect x="290" y="20" width="220" height="200" rx="15" fill="#eaffea" />
		  <rect x="560" y="20" width="220" height="200" rx="15" fill="#ffe5e5" />

		  <!-- Text: 1st Assessment Avg -->
		  <text x="50" y="60" font-size="18" font-weight="bold" fill="#003366">1st Assessment Avg</text>
		  <text x="110" y="110" font-size="32" font-weight="bold" fill="#003366">'.$emp_post_report['final_score'].'</text>
		  

		  <!-- Text: 2nd Assessment Avg -->
		  <text x="320" y="60" font-size="18" font-weight="bold" fill="#004d00">2nd Assessment Avg</text>
		  <text x="380" y="110" font-size="32" font-weight="bold" fill="#004d00">'.$emp_pre_report['final_score'].'</text>
		 

		  <!-- Text: Change -->
		  <text x="640" y="60" font-size="18" font-weight="bold" fill="#660000">Change</text>
		  <text x="640" y="110" font-size="32" font-weight="bold" fill="red">'.($emp_pre_report['final_score']-$emp_post_report['final_score']).'</text>
		</svg>';

		$target_path=__SITE_PATH.DS.'public'.DS.'reports'.DS.'graphs'.DS.'full'.DS.$_REQUEST['ass_id'];
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

		$myfile = fopen($target_path.DS.$_REQUEST['emp_id']."_".$_REQUEST['pos_id'].'_main_section_one.svg', "w") or die("Unable to open file!");
		fwrite($myfile, $svg_main);
		fclose($myfile);
		$ass_test_info_two=UlsAssessmentTest::get_ass_position($emp_pre_report['assessment_id'],$_REQUEST['pos_id'],'TEST');
		$ass_test_info=UlsAssessmentTest::get_ass_position($_REQUEST['ass_id'],$_REQUEST['pos_id'],'TEST');
		$comp_questions=UlsAssessmentTestQuestions::gettestquestions_report($ass_test_info['assess_test_id'],$ass_test_info['test_id'],$ass_test_info['assessment_type'],$_REQUEST['emp_id'],$ass_test_info['assessment_id']);
		$data['comp_questions']=$comp_questions;
		$comp_details="";
		foreach($comp_questions as $comp_question){
			$cor_count_one=UlsUtestResponsesAssessment::question_count_correct($comp_question['q_id'],$_REQUEST['emp_id'],$ass_test_info_two['assess_test_id'],$emp_pre_report['assessment_id']);
			$blank_count_one=UlsUtestResponsesAssessment::question_count_leftblank($comp_question['q_id'],$_REQUEST['emp_id'],$ass_test_info_two['assess_test_id'],$emp_pre_report['assessment_id']);
			$total_one=@explode(",",$comp_question['q_id']);
			$total_question_one=($blank_count_one['l_count'])>0?(count($total_one)-$blank_count_one['l_count']):count($total_one);
			$total_per_one=($cor_count_one['c_count']>0)?(round((($cor_count_one['c_count']/$total_question_one)*100),2)):0;
			
			$cor_count_two=UlsUtestResponsesAssessment::question_count_correct($comp_question['q_id'],$_REQUEST['emp_id'],$ass_test_info['assess_test_id'],$_REQUEST['ass_id']);
			$blank_count_two=UlsUtestResponsesAssessment::question_count_leftblank($comp_question['q_id'],$_REQUEST['emp_id'],$ass_test_info['assess_test_id'],$_REQUEST['ass_id']);
			$total_two=@explode(",",$comp_question['q_id']);
			$total_question_two=($blank_count_two['l_count'])>0?(count($total_two)-$blank_count_two['l_count']):count($total_two);
			$total_per_two=($cor_count_two['c_count']>0)?(round((($cor_count_two['c_count']/$total_question_two)*100),2)):0;
		
		$svg_secound='<svg width="500" height="30" xmlns="http://www.w3.org/2000/svg">
			  <style>
				.label { font: 14px sans-serif; fill: white; }
				.percent { color:#fff; font: 12px sans-serif; fill: white; text-anchor: middle; alignment-baseline: middle; }
			  </style>

			  <!-- Product A -->
			 
			  <rect x="10" y="0" width="'.(2.5*$total_per_one).'" height="30" fill="#4CAF50" />
			  <rect x="250" y="0" width="'.(2.5*$total_per_two).'" height="30" fill="#2196F3" />
			  <text x="70" y="22" class="percent" fill="white">'.$total_per_one.'%</text>
			  <text x="300" y="22" class="percent" fill="white">'.$total_per_two.'%</text>
			</svg>';
			
			$target_path=__SITE_PATH.DS.'public'.DS.'reports'.DS.'graphs'.DS.'full'.DS.$_REQUEST['ass_id'];
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

			$myfile = fopen($target_path.DS.$_REQUEST['emp_id']."_".$_REQUEST['pos_id'].'_comp_'.$comp_question['competency_id'].'_graph.svg', "w") or die("Unable to open file!");
			fwrite($myfile, $svg_secound);
			fclose($myfile);
		
		}
		
		$empstatus=UlsAssessmentEmployeeFinalReport::get_assessment_employees_report_final($emp_pre_report['assessment_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id']);
		$data['compempstatus']=$empstatus;
		foreach($empstatus as $empstatuss){
			$comp_id=$empstatuss['competency_id'];
			$kkass_sid[$comp_id]=$empstatuss['assessed_value'];
		}
		$kkcomp_idnew=$compid=array();
		$kkass_sid_new=$kkass_sid;
		$ass_final_re=UlsAssessmentEmployeeFinalReport::get_assessment_employees_report_final($_REQUEST['ass_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id']);
		$kkk=1;
		foreach($ass_final_re as $ass_final_res){
			$comp_id=$ass_final_res['competency_id'];
			$kkcomp_id[$comp_id]="C".($kkk);
			$kkcomp_idnew[]=$comp_id;
			$kkass_sid_new[$comp_id]=$ass_final_res['assessed_value'];
			$kkk++;
		}
		$new_comp_bar=$old_comp_bar=array();
		foreach($kkcomp_idnew as $kkcompidnew){
			$a=$kkcomp_id[$kkcompidnew];
			$new_comp_bar[$a]=$kkass_sid_new[$kkcompidnew];
			$old_comp_bar[$a]=$kkass_sid[$kkcompidnew];
		}
		require_once(LIB_PATH.DS.DS.'graph'.DS.'includes'.DS.'SVGGraph.php');
		$settings_bar = [
			  'auto_fit' => true,
			  'back_colour' => '#eee',
			  'back_stroke_width' => 0,
			  'back_stroke_colour' => '#eee',
			  'stroke_colour' => '#000',
			  'axis_colour' => '#333',
			  'axis_overlap' => 2,
			  'grid_colour' => '#666',
			  'label_colour' => '#000',
			  'axis_font' => 'Arial',
			  'axis_font_size' => 18,
			  'pad_right' => 20,
			  'pad_left' => 20,
			  'link_base' => '/',
			  'link_target' => '_top',
			  'minimum_grid_spacing' => 20,
			  'show_subdivisions' => false,
			  'show_grid_subdivisions' => false,
			  'grid_subdivision_colour' => '#ccc',
			  'axis_min_v' => 0,
				'axis_max_v' =>3,
				'grid_division_v' =>0.5,
				'bar_width'=>20,
			];

		$width = 800;
		$height = 300;
		$type = 'GroupedBarGraph';
		$values_bar = [$new_comp_bar,$old_comp_bar];

		$colours = [ ['#FFA64D'], ['#FF4D6D'] ];
		$graph = new SVGGraph($width, $height, $settings_bar);
		$graph->colours($colours);
		$graph->values($values_bar);
		$value11=$graph->Fetch('GroupedBarGraph', false);//$graph->Fetch('MultiRadarGraph', false);
		$target_path=__SITE_PATH.DS.'public'.DS.'reports'.DS.'graphs'.DS.'full'.DS.$_REQUEST['ass_id'];
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

		$myfile = fopen($target_path.DS.$_REQUEST['emp_id']."_".$_REQUEST['pos_id'].'_compbar.svg', "w") or die("Unable to open file!");
		fwrite($myfile, $value11);
		fclose($myfile);
		$data['assessor_comments']=UlsAssessmentAssessorRating::get_ass_rating_report($_REQUEST['ass_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id'],'INTERVIEW');
		$content = $this->load->view('pdf/assessment_report_single_new',$data,true);		
		$this->render('layouts/ajax-layout',$content);
	}
	
	
	
	public function empsinglereport(){
		$this->load->library('pdfgenerator');
		$ass_type=isset($_REQUEST['ass_type'])? $_REQUEST['ass_type']:"";
		$id=isset($_REQUEST['ass_id'])? $_REQUEST['ass_id']:"";
		$data['ass_id']=$id;
		$data['pos_id']=$_REQUEST['pos_id'];
		$data['emp_id']=$_REQUEST['emp_id'];
		
		$posdetails=UlsPosition::viewposition($_REQUEST['pos_id']);
		$data['posdetails']=$posdetails;
		$empd=UlsEmployeeMaster::get_empdetails_id($_REQUEST['emp_id']);
		$data['emp_info']=$empd;
		$emp_pre_report=UlsAssessmentEmployees::get_assessment_employees_prereport($_REQUEST['emp_id'],$_REQUEST['ass_id'],$_REQUEST['pos_id']);
		$ass_test_info_two=UlsAssessmentTest::get_ass_position($emp_pre_report['assessment_id'],$_REQUEST['pos_id'],'TEST');
		$data['ass_test_info_two']=$ass_test_info_two;
		
		$ass_test_info=UlsAssessmentTest::get_ass_position($id,$_REQUEST['pos_id'],'TEST');
		$data['ass_test_info']=$ass_test_info;
		
		$data['comp_questions']=UlsAssessmentTestQuestions::gettestquestions_report($ass_test_info['assess_test_id'],$ass_test_info['test_id'],$ass_test_info['assessment_type'],$_REQUEST['emp_id'],$ass_test_info['assessment_id']);
		$data['modes']=UlsAdminMaster::get_value_names("IN_MODE");
		$ass_details=UlsAssessmentDefinition::viewassessment($id);
		$getweights=UlsMenu::callpdo("SELECT * FROM `uls_assessment_competencies_weightage` WHERE `assessment_id`='".$_REQUEST['ass_id']."' and `position_id`='".$_REQUEST['pos_id']."' and assessment_type!='BEHAVORIAL_INSTRUMENT'");
		$allweights=array();
		foreach($getweights as $wei){
			$assessment_type=$wei['assessment_type'];
			$allweights[$assessment_type]=$wei['weightage'];
		}
		
		$emp_comp=UlsAssessmentEmployees::get_assessment_employees_comp($_REQUEST['emp_id'],$_REQUEST['ass_id'],$_REQUEST['pos_id']);
		$ass_comp_info=UlsAssessmentReportBytype::report_bytype_emp_competencies($_REQUEST['ass_id'],$_REQUEST['pos_id'],$emp_comp['comp_ids']);
		$results_comp=array();
		foreach($ass_comp_info as $ass_comp_infos){
			$comp_id=$ass_comp_infos['comp_def_id'];
			$req_scale_id=$ass_comp_infos['assessment_pos_level_scale_id'];
			$results_comp[$comp_id]['comp_id']=$comp_id;
			$results_comp[$comp_id]['cat_id']=$ass_comp_infos['comp_def_category'];
			$results_comp[$comp_id]['req_level']=$ass_comp_infos['scale_number'];
			$results_comp[$comp_id]['comp_name']=$ass_comp_infos['comp_def_name'];
			$results_comp[$comp_id]['pos_com_weightage']=$ass_comp_infos['pos_com_weightage'];
		}
		
		$getdats=UlsMenu::callpdo("SELECT avg(b.scale_number) as required,avg(c.scale_number) as assessed,a.`position_id`,a.`employee_id`,a.`assessment_type`,a.`competency_id`,ct.comp_def_category FROM `uls_assessment_report_bytype` a 
		inner join(SELECT `assessment_pos_assessor_id`,`assessment_id`,`position_id`,`assessor_val`,assessor_id FROM `uls_assessment_position_assessor`) ac on ac.assessor_id=a.assessor_id and a.assessment_id=ac.assessment_id and a.`position_id`=ac.position_id
		left join (select assessment_pos_com_id,assessment_id,position_id,assessment_pos_level_scale_id from uls_assessment_competencies)dc on dc.assessment_pos_com_id=a.competency_id and dc.assessment_id=a.assessment_id and dc.`position_id`=a.position_id
		inner join uls_level_master_scale b on dc.`assessment_pos_level_scale_id`=b.scale_id inner join uls_level_master_scale c on a.`assessed_scale_id`=c.scale_id 
		left join(SELECT `comp_def_id`,`comp_def_name`,`comp_def_category` FROM `uls_competency_definition`) ct on ct.comp_def_id=a.competency_id
		WHERE a.`assessment_id`='".$_REQUEST['ass_id']."' and a.`employee_id`='".$_REQUEST['emp_id']."' and a.`position_id`='".$_REQUEST['pos_id']."' group by a.`competency_id`, a.`assessment_type` ORDER BY `a`.`assessment_type` ASC");
		$final_comp=$allcomp=$allcompfeed=$allcompreq=$allcomp_score_a=$allcomp_score_b=$allcomp_score_a_subcat=$allcomp_subcat=$allcompreq_subcat=array(); 
		foreach($getdats as $aa){
			$cid=$aa['competency_id'];
			$catid=$aa['comp_def_category'];
			$ctype=$aa['assessment_type'];
			
			$score_data=round((100-((($aa['required']-$aa['assessed'])/$aa['required'])*100)),2);
			$allgg[$cid][$ctype]['score']=$score_data;
			$allcomp_score_a[$cid][$ctype]['score']=$score_data;
			$allcomp[$cid][$ctype]=$aa['assessed'];
			$allcompreq[$cid]=$aa['required'];
		}
	
		$emp_pre_report=UlsAssessmentEmployees::get_assessment_employees_prereport($_REQUEST['emp_id'],$_REQUEST['ass_id'],$_REQUEST['pos_id']);
		$empstatus=UlsAssessmentEmployeeFinalReport::get_assessment_employees_report_final($emp_pre_report['assessment_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id']);
		$data['compempstatus']=$empstatus;
		$kkk=1;
		//$kkcomp_id=$kkreq_sid=$kkass_sid=array();
		foreach($empstatus as $empstatuss){
			$comp_id=$empstatuss['competency_id'];
			$kkcomp_id[$comp_id]="C".($kkk);
			$kkreq_sid[$comp_id]=$empstatuss['require_scale_id'];
			$kkass_sid[$comp_id]=$empstatuss['assessed_value'];
			$kkk++;
		}
		
		$kkkK=1;
		$ass_val_final=$rating_final_val=0;$final_wei=0;
		$kkass_sid_new=$kkass_sid;
		$kkcomp_idnew=$compid=array();
		foreach($results_comp as $results_comps){
			$comp_id=$results_comps['comp_id'];
			$method=array();
			$me_sum=0;
			foreach($allcomp_score_a[$comp_id] as $key=>$method_val){
				$method[]=$allweights[$key];
			}
			foreach($allcomp_score_a[$comp_id] as $key=>$method_val){
				$me_sum+=($allweights[$key]/array_sum($method))*$method_val['score'];
			}
			$final_val=round($me_sum,2);
			$rating_final_val+=$results_comps['req_level'];
			$final_wei+=round((($final_val*$results_comps['pos_com_weightage'])/100),2);
			$ass_val=round(($results_comps['req_level']*$final_val)/100,2);
			$ass_val_final+=$ass_val;
			$kkcomp_id_new[$comp_id]="C".($kkkK);
			$kkcomp_idnew[]=$comp_id;
			$kkreq_sid_new[$comp_id]=$results_comps['req_level'];
			$kkass_sid_new[$comp_id]=$ass_val;
			if(($ass_val<$results_comps['req_level'])){
				$flag=1;
			}
			if($flag==1){
				if(!in_array($results_comps['comp_id'],$compid)){
					$compid[]=$results_comps['comp_id']."-".$results_comps['req_level'];
				}
			}
			$kkkK++;
		}
		$data['newcompids']=$compid;
		
		
		$new_comp_bar=$old_comp_bar=array();
		foreach($kkcomp_idnew as $kkcompidnew){
			$a=$kkcomp_id[$kkcompidnew];
			$new_comp_bar[$a]=$kkass_sid_new[$kkcompidnew];
			$old_comp_bar[$a]=$kkass_sid[$kkcompidnew];
		}
		require_once(LIB_PATH.DS.DS.'graph'.DS.'includes'.DS.'SVGGraph.php');
		$settings_bar = [
		  'auto_fit' => true,
		  'back_colour' => '#fff',
		  'bar_width'=>20,
		  'back_stroke_width' => 0,
		  'back_stroke_colour' => '#eee',
		  'stroke_colour' => '#000',
		  'axis_colour' => '#333',
		  'axis_overlap' => 2,
		  'grid_colour' => '#666',
		  'label_colour' => '#000',
		  'axis_font' => 'Arial',
		  'axis_font_size' => 10,
		  'pad_right' => 20,
		  'pad_left' => 20,
		  'link_base' => '/',
		  'link_target' => '_top',
		  'minimum_grid_spacing' => 20,
		  'show_subdivisions' => true,
		  'show_grid_subdivisions' => true,
		  'grid_subdivision_colour' => '#ccc',
		  'show_legend'=>true,
		  'legend_text_side'=>'right',
		  'legend_font_size'=>8,
		'legend_position' => "outer bottom 0 4",
		  'legend_entry_height' => 5,
		  'legend_entries' => [
			'New Rating','Old Rating'
		  ],
		  
		];

		$width = 450;
		$height = 300;
		$type = 'GroupedBarGraph';
		$values_bar = [$new_comp_bar,$old_comp_bar];

		$colours = [ ['yellow'], ['blue'] ];
		$graph = new SVGGraph($width, $height, $settings_bar);
		$graph->colours($colours);
		$graph->values($values_bar);
		$value11=$graph->Fetch('GroupedBarGraph', false);//$graph->Fetch('MultiRadarGraph', false);
		$target_path=__SITE_PATH.DS.'public'.DS.'reports'.DS.'graphs'.DS.'full'.DS.$_REQUEST['ass_id'];
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

		$myfile = fopen($target_path.DS.$_REQUEST['emp_id']."_".$_REQUEST['pos_id'].'_bar.svg', "w") or die("Unable to open file!");
		fwrite($myfile, $value11);
		fclose($myfile);
		
		
		
		$setting_score = [
		  'auto_fit' => true,
		  'back_colour' => '#fff',
		  'bar_width'=>20,
		  'back_stroke_width' => 0,
		  'back_stroke_colour' => '#eee',
		  'stroke_colour' => '#000',
		  'axis_colour' => '#333',
		  'axis_overlap' => 2,
		  'grid_colour' => '#666',
		  'label_colour' => '#000',
		  'axis_font' => 'Arial',
		  'axis_font_size' => 10,
		  'pad_right' => 20,
		  'pad_left' => 20,
		  'link_base' => '/',
		  'link_target' => '_top',
		  'minimum_grid_spacing' => 20,
		  'show_subdivisions' => true,
		  'show_grid_subdivisions' => true,
		  'grid_subdivision_colour' => '#ccc',
		  'show_legend'=>true,
		  'legend_text_side'=>'right',
		  'legend_font_size'=>8,
		'legend_position' => "outer bottom 0 4",
		  'legend_entry_height' => 5,
		  'legend_entries' => [
			'My Score','Other Avg Score'
		  ],
		];

		$width = 450;
		$height = 300;
		$type = 'GroupedBarGraph';
		$values_score = [
		  ['C7' => 1.30, 'C9' => 1.30],
		  ['C7' => 1.5, 'C9' => 1.56],
		];


		$colours = [ ['green'], ['orange'] ];
		$graph = new SVGGraph($width, $height, $setting_score);
		$graph->colours($colours);
		$graph->values($values_score);
		$value11=$graph->Fetch('GroupedBarGraph', false);//$graph->Fetch('MultiRadarGraph', false);
		$target_path=__SITE_PATH.DS.'public'.DS.'reports'.DS.'graphs'.DS.'full'.DS.$_REQUEST['ass_id'];
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

		$myfile = fopen($target_path.DS.$_REQUEST['emp_id']."_".$_REQUEST['pos_id'].'_bar_score.svg', "w") or die("Unable to open file!");
		fwrite($myfile, $value11);
		fclose($myfile);
		
		
		$division=0.5;
		
		$settings = array(
			'back_colour'       => '#fff',    'stroke_colour'      => '#666',
			'back_stroke_width' => 0,         'back_stroke_colour' => '#fff',
			'axis_colour'       => '#666',    'axis_overlap'       => 2,
			'axis_font'         => 'Georgia', 'axis_font_size'     => 14,
			'grid_colour'       => '#666',    'label_colour'       => '#666',
			'pad_right'         => 50,        'pad_left'           => 50,
			'link_base'         => '/',       'link_target'        => '_top',
			'fill_under'        => false,	  'line_stroke_width'=>5,
			'marker_size'       => 6,
			//'grid_division_v' =>5,
			'minimum_subdivision' =>$division,
			/* 'axis_min_v' => $minv,
			'axis_max_v' => $maxv, */
			'show_subdivisions' => true,
			'show_grid_subdivisions' => false,
			'grid_subdivision_colour' => '#ccc',
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
		$settings['legend_entries'] = array('Required Level', 'Assessed Level', 'New Assessed Level');

		$val=array();
		$val_required=array_combine($kkcomp_id,$kkreq_sid);
		$val_assessed=array_combine($kkcomp_id,$kkass_sid);
		$val_assessed_new=array_combine($kkcomp_id,$kkass_sid_new);

		$values = array($val_required,$val_assessed,$val_assessed_new);
		
		$colours = array(array('#b12c43', '#b12c43'), array('#008534', '#008534'), array('#F08123', '#F08456'));
		$graph = new SVGGraph(600, 600, $settings);
		$graph->colours = $colours;
		$graph->Values($values);
		$value11=$graph->Fetch('MultiRadarGraph', false);//$graph->Fetch('MultiRadarGraph', false);
		$target_path=__SITE_PATH.DS.'public'.DS.'reports'.DS.'graphs'.DS.'full'.DS.$_REQUEST['ass_id'];
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
		fwrite($myfile, $value11);
		fclose($myfile);
		echo $content = $this->load->view('pdf/assessment_report_single_new',$data,true);
		$filename = "Employee-single-report-".$empd['enumber']."-".trim($empd['name']);
		$this->pdfgenerator->generate($content, $filename, true, 'A4', 'portrait','competency_profiling');
				
	}
	
	public function ass_position_hrold(){
		$this->load->library('pdfgenerator');
		$ass_type=isset($_REQUEST['ass_type'])? $_REQUEST['ass_type']:"";
		$id=isset($_REQUEST['ass_id'])? $_REQUEST['ass_id']:"";
		$data['ass_id']=$id;
		$data['pos_id']=$_REQUEST['pos_id'];
		$data['emp_id']=$_REQUEST['emp_id'];
		if($ass_type=='SELF'){
			$posdetails=UlsPosition::viewposition($_REQUEST['pos_id']);
			$data['posdetails']=$posdetails;
			$data['emp_info']=UlsEmployeeMaster::get_empdetails_id($_REQUEST['emp_id']);
			$data['pos_info']=UlsAssessmentPosition::get_assessment_position_info($id,$_REQUEST['pos_id']);
			$data['ass_comp']=UlsSelfAssessmentReport::getselfassessment_comp_details($id,$_REQUEST['pos_id']);
			$data['ass_details']=UlsAssessmentDefinition::viewassessment($id);
			$data['ass_dev_info']=UlsSelfAssessmentReportDevArea::getselfassessment_dev_summary($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['ass_report_info']=UlsSelfAssessmentReport::getassessment_self_competency($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['scale_info']=UlsLevelMasterScale::scale_values();
			$data['scale_info_four']=UlsLevelMasterScale::scale_values_level_four();
			$data['scale_info_five']=UlsLevelMasterScale::scale_values_level_five();
			$data['cri_info']=UlsCompetencyCriticality::criticality_names();
			$data['kras']=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($_REQUEST['pos_id']);
			$data['category']=UlsCompetencyPositionRequirements::category_comp_details($_REQUEST['pos_id']);
			include("radargraphnew.php");
			//include("radargraph.php");
			//$content = $this->load->view('pdf/self_assessment_report',$data,true);
			//$filename = "Employee - Competency Profile";
			//$this->pdfgenerator->generate($content, $filename, true, 'A4', 'portrait','competency_profiling');
			$content = $this->load->view('pdf/self_assessment_detail_reportnew',$data,true);		
			$this->render('layouts/ajax-layout',$content);
		}
		else{
			$posdetails=UlsPosition::viewposition($_REQUEST['pos_id']);
			$data['posdetails']=$posdetails;
			$empd=UlsEmployeeMaster::get_empdetails_id($_REQUEST['emp_id']);
			$data['emp_info']=$empd;
			$data['competencies']=UlsAssessmentCompetencies::getassessment_competencies_type($id,$_REQUEST['pos_id']);
			//$data['ass_comp_info']=UlsAssessmentReport::getassessment_admin_summary($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['category']=UlsCompetencyPositionRequirements::category_comp_details($_REQUEST['pos_id']);
			$data['scale_info_four']=UlsLevelMasterScale::scale_values_level_four();
			$data['scale_info_five']=UlsLevelMasterScale::scale_values_level_five();
			$data['cri_info']=UlsCompetencyCriticality::criticality_names();
			$beh_asstype="BEHAVORIAL_INSTRUMENT";
			$data['beh_instrument']=UlsAssessmentTest::get_ass_position_test($id,$_REQUEST['pos_id'],$beh_asstype);
			$data['kras']=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($_REQUEST['pos_id']);
			$data['testtypes']=UlsAssessmentTest::get_assessment_position($id,$_REQUEST['pos_id']);
			$data['modes']=UlsAdminMaster::get_value_names("IN_MODE");
			$data['ass_results']=UlsAssessmentTest::assessment_results($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['assessor_rating_new']=UlsAssessmentAssessorRating::assessor_results_report_new($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			//$data['assessor_rating']=UlsAssessmentAssessorRating::assessor_results_report($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$ass_details=UlsAssessmentDefinition::viewassessment($id);
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
			$assessor_rating_new=UlsAssessmentAssessorRating::assessor_results_report_new($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$result_s=array();
			foreach($assessor_rating_new as $assessor_rating_news){
				$finalval=!empty($assessor_rating_news['assessor_val'])?round(($assessor_rating_news['rat_num']*$assessor_rating_news['assessor_val']),2):$assessor_rating_news['rat_num'];
				$result_s[$assessor_rating_news['assessment_type']]['assessment_type']=$assessor_rating_news['assessment_type'];
				$result_s[$assessor_rating_news['assessment_type']]['assess_type']=$assessor_rating_news['assess_type'];
				$result_s[$assessor_rating_news['assessment_type']]['weightage']=$assessor_rating_news['weightage'];
				$result_s[$assessor_rating_news['assessment_type']]['test_ques']=$assessor_rating_news['test_ques'];
				$result_s[$assessor_rating_news['assessment_type']]['test_score']=$assessor_rating_news['test_score'];
				$result_s[$assessor_rating_news['assessment_type']]['rating_scale']=$assessor_rating_news['rating_scale'];
				$result_s[$assessor_rating_news['assessment_type']]['assessor'][$assessor_rating_news['assessor_id']]=$finalval;
			}
			//$assessor_rating=UlsAssessmentAssessorRating::assessor_results_report($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$wei_total=0;
			foreach($result_s as $key1=>$assessor_ratings){
				$score_final=$scorefinal=0;
				if($assessor_ratings['assessment_type']=='TEST'){
					$score_test=(($assessor_ratings['test_score']/$assessor_ratings['test_ques'])*100);
					$wei=$assessor_ratings['weightage'];
					echo $score_final=round((($score_test*$wei)/100),2);
				}
				else{
					$final=0;
					foreach($assessor_ratings['assessor'] as $key2=>$ass_id){
						$final=$final+$result_s[$key1]['assessor'][$key2];
					}
					$final=round($final/count($result_s[$key1]['assessor']),2);
					$score=(($final/$assessor_ratings['rating_scale'])*100);
					$wei=$assessor_ratings['weightage'];
					echo $scorefinal=round((($score*$wei)/100),2);
				} 
				$wei_total=round($wei_total+($score_final+$scorefinal),2);
			}
			$a=540;
			$b=(540*$wei_total)/100;
			$value='<svg version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" width="800" height="180"><g transform="translate(220,5)"><rect width="540" height="25" x="0" style=" fill: #eee;"></rect><rect width="'.$a.'" height="8.333333333333334" x="0" y="8.333333333333334" style=" fill: #1d598b;"></rect><line style="stroke: #e89134; stroke-width: 5px;" x1="'.$b.'" x2="'.$b.'" y1="0" y2="25"></line><g transform="translate(0,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >0</text></g><g><line x1="10.8" x2="10.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="21.6" x2="21.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="32.4" x2="32.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="43.2" x2="43.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="64.8" x2="64.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="75.6" x2="75.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="86.4" x2="86.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="97.2" x2="97.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="118.8" x2="118.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="129.6" x2="129.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="140.4" x2="140.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="151.2" x2="151.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="172.8" x2="172.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="183.6" x2="183.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="194.4" x2="194.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="205.2" x2="205.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="226.8" x2="226.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="237.6" x2="237.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="248.4" x2="248.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="259.2" x2="259.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="280.8" x2="280.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="291.6" x2="291.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="302.4" x2="302.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="313.2" x2="313.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="334.8" x2="334.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="345.6" x2="345.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="356.4" x2="356.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="367.2" x2="367.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="388.8" x2="388.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="399.6" x2="399.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="410.4" x2="410.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="421.2" x2="421.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="442.8" x2="442.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="453.6" x2="453.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="464.4" x2="464.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="475.2" x2="475.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="496.8" x2="496.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="507.6" x2="507.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="518.4" x2="518.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="529.2" x2="529.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g transform="translate(54,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >10</text></g><g transform="translate(108,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >20</text></g><g transform="translate(162,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >30</text></g><g transform="translate(216,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >40</text></g><g transform="translate(270,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >50</text></g><g transform="translate(324,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >60</text></g><g transform="translate(378,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >70</text></g><g transform="translate(432,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >80</text></g><g transform="translate(486,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >90</text></g><g transform="translate(540,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >100</text></g><g style="text-anchor: end;" transform="translate(-6,12.5)"><text font-size="16px" style="font-family:sans-serif;">Overall Score</text></g></g></svg>';
			$myfile1 = fopen($target_path.DS.'over_all_hr'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'.svg', "w") or die("Unable to open file!");
			fwrite($myfile1, $value);
			fclose($myfile1);
		
			$content = $this->load->view('pdf/assessment_report_new_hr',$data,true);
			$filename = "Employee - ".$empd['enumber']."-".$empd['name']." - Competency Profile";
			$this->pdfgenerator->generate($content, $filename, true, 'A4', 'portrait','competency_profiling');
		}		
	}
	
	public function ass_position_hr(){
		$this->load->library('tcpdf');
		$this->load->library('pdfgenerator');
		$ass_type=isset($_REQUEST['ass_type'])? $_REQUEST['ass_type']:"";
		$id=isset($_REQUEST['ass_id'])? $_REQUEST['ass_id']:"";
		$data['ass_id']=$id;
		$data['pos_id']=$_REQUEST['pos_id'];
		$data['emp_id']=$_REQUEST['emp_id'];
		if($ass_type=='SELF'){
			$posdetails=UlsPosition::viewposition($_REQUEST['pos_id']);
			$data['posdetails']=$posdetails;
			$data['emp_info']=UlsEmployeeMaster::get_empdetails_id($_REQUEST['emp_id']);
			$data['pos_info']=UlsAssessmentPosition::get_assessment_position_info($id,$_REQUEST['pos_id']);
			$data['ass_comp']=UlsSelfAssessmentReport::getselfassessment_comp_details($id,$_REQUEST['pos_id']);
			$data['ass_details']=UlsAssessmentDefinition::viewassessment($id);
			$data['ass_dev_info']=UlsSelfAssessmentReportDevArea::getselfassessment_dev_summary($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['ass_report_info']=UlsSelfAssessmentReport::getassessment_self_competency($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['scale_info']=UlsLevelMasterScale::scale_values();
			$data['scale_info_four']=UlsLevelMasterScale::scale_values_level_four();
			$data['scale_info_five']=UlsLevelMasterScale::scale_values_level_five();
			$data['cri_info']=UlsCompetencyCriticality::criticality_names();
			$data['kras']=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($_REQUEST['pos_id']);
			$data['category']=UlsCompetencyPositionRequirements::category_comp_details($_REQUEST['pos_id']);
			include("radargraphnew.php");
			//include("radargraph.php");
			//$content = $this->load->view('pdf/self_assessment_report',$data,true);
			//$filename = "Employee - Competency Profile";
			//$this->pdfgenerator->generate($content, $filename, true, 'A4', 'portrait','competency_profiling');
			$content = $this->load->view('pdf/self_assessment_detail_reportnew',$data,true);		
			$this->render('layouts/ajax-layout',$content);
		}
		else{
			$posdetails=UlsPosition::viewposition($_REQUEST['pos_id']);
			$data['posdetails']=$posdetails;
			$empd=UlsEmployeeMaster::get_empdetails_id($_REQUEST['emp_id']);
			$data['emp_info']=$empd;
			$data['competencies']=UlsAssessmentCompetencies::getassessment_competencies_type($id,$_REQUEST['pos_id']);
			//$data['ass_comp_info']=UlsAssessmentReport::getassessment_admin_summary($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['category']=UlsCompetencyPositionRequirements::category_comp_details($_REQUEST['pos_id']);
			$data['scale_info_four']=UlsLevelMasterScale::scale_values_level_four();
			$data['scale_info_five']=UlsLevelMasterScale::scale_values_level_five();
			$data['cri_info']=UlsCompetencyCriticality::criticality_names();
			$beh_asstype="BEHAVORIAL_INSTRUMENT";
			$data['beh_instrument']=UlsAssessmentTest::get_ass_position_test($id,$_REQUEST['pos_id'],$beh_asstype);
			$data['kras']=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($_REQUEST['pos_id']);
			$data['testtypes']=UlsAssessmentTest::get_assessment_position($id,$_REQUEST['pos_id']);
			$data['modes']=UlsAdminMaster::get_value_names("IN_MODE");
			$data['ass_results']=UlsAssessmentTest::assessment_results($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['assessor_rating_new']=UlsAssessmentAssessorRating::assessor_results_report_new($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			//$data['assessor_rating']=UlsAssessmentAssessorRating::assessor_results_report($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$ass_details=UlsAssessmentDefinition::viewassessment($id);
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
			$assessor_rating_new=UlsAssessmentAssessorRating::assessor_results_report_new($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$result_s=array();
			foreach($assessor_rating_new as $assessor_rating_news){
				$finalval=!empty($assessor_rating_news['assessor_val'])?round(($assessor_rating_news['rat_num']*$assessor_rating_news['assessor_val']),2):$assessor_rating_news['rat_num'];
				$result_s[$assessor_rating_news['assessment_type']]['assessment_type']=$assessor_rating_news['assessment_type'];
				$result_s[$assessor_rating_news['assessment_type']]['assess_type']=$assessor_rating_news['assess_type'];
				$result_s[$assessor_rating_news['assessment_type']]['weightage']=$assessor_rating_news['weightage'];
				$result_s[$assessor_rating_news['assessment_type']]['test_ques']=$assessor_rating_news['test_ques'];
				$result_s[$assessor_rating_news['assessment_type']]['test_score']=$assessor_rating_news['test_score'];
				$result_s[$assessor_rating_news['assessment_type']]['rating_scale']=$assessor_rating_news['rating_scale'];
				$result_s[$assessor_rating_news['assessment_type']]['assessor'][$assessor_rating_news['assessor_id']]=$finalval;
			}
			//$assessor_rating=UlsAssessmentAssessorRating::assessor_results_report($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$wei_total=0;
			foreach($result_s as $key1=>$assessor_ratings){
				$score_final=$scorefinal=0;
				if($assessor_ratings['assessment_type']=='TEST'){
					$score_test=(($assessor_ratings['test_score']/$assessor_ratings['test_ques'])*100);
					$wei=$assessor_ratings['weightage'];
					echo $score_final=round((($score_test*$wei)/100),2);
				}
				else{
					$final=0;
					foreach($assessor_ratings['assessor'] as $key2=>$ass_id){
						$final=$final+$result_s[$key1]['assessor'][$key2];
					}
					$final=round($final/count($result_s[$key1]['assessor']),2);
					$score=(($final/$assessor_ratings['rating_scale'])*100);
					$wei=$assessor_ratings['weightage'];
					echo $scorefinal=round((($score*$wei)/100),2);
				} 
				$wei_total=round($wei_total+($score_final+$scorefinal),2);
			}
			$a=540;
			$b=(540*$wei_total)/100;
			$value='<svg version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" width="800" height="180"><g transform="translate(220,5)"><rect width="540" height="25" x="0" style=" fill: #eee;"></rect><rect width="'.$a.'" height="8.333333333333334" x="0" y="8.333333333333334" style=" fill: #1d598b;"></rect><line style="stroke: #e89134; stroke-width: 5px;" x1="'.$b.'" x2="'.$b.'" y1="0" y2="25"></line><g transform="translate(0,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >0</text></g><g><line x1="10.8" x2="10.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="21.6" x2="21.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="32.4" x2="32.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="43.2" x2="43.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="64.8" x2="64.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="75.6" x2="75.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="86.4" x2="86.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="97.2" x2="97.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="118.8" x2="118.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="129.6" x2="129.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="140.4" x2="140.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="151.2" x2="151.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="172.8" x2="172.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="183.6" x2="183.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="194.4" x2="194.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="205.2" x2="205.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="226.8" x2="226.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="237.6" x2="237.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="248.4" x2="248.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="259.2" x2="259.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="280.8" x2="280.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="291.6" x2="291.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="302.4" x2="302.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="313.2" x2="313.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="334.8" x2="334.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="345.6" x2="345.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="356.4" x2="356.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="367.2" x2="367.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="388.8" x2="388.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="399.6" x2="399.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="410.4" x2="410.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="421.2" x2="421.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="442.8" x2="442.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="453.6" x2="453.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="464.4" x2="464.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="475.2" x2="475.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="496.8" x2="496.8" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="507.6" x2="507.6" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="518.4" x2="518.4" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g><line x1="529.2" x2="529.2" y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .1px;"></line></g><g transform="translate(54,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >10</text></g><g transform="translate(108,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >20</text></g><g transform="translate(162,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >30</text></g><g transform="translate(216,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >40</text></g><g transform="translate(270,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >50</text></g><g transform="translate(324,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >60</text></g><g transform="translate(378,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >70</text></g><g transform="translate(432,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >80</text></g><g transform="translate(486,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >90</text></g><g transform="translate(540,0)" style="opacity: 1;"><line y1="25" y2="29.166666666666668" style="stroke: #666; stroke-width: .5px;"></line><text style="font-family:sans-serif;" text-anchor="middle" dy="1em" y="39.166666666666668" font-size="10px" >100</text></g><g style="text-anchor: end;" transform="translate(-6,12.5)"><text font-size="16px" style="font-family:sans-serif;">Overall Score</text></g></g></svg>';
			$myfile1 = fopen($target_path.DS.'over_all_hr'.$_REQUEST['emp_id'].'_'.$_REQUEST['pos_id'].'.svg', "w") or die("Unable to open file!");
			fwrite($myfile1, $value);
			fclose($myfile1);
			$content = $this->load->view('pdf/assessment_report_new_hrr',$data,true);		
			$this->render('layouts/ajax-layout',$content);
		}
	}
	
	public function ass_position_intemp(){
		$this->load->library('tcpdf');
		$this->load->library('pdfgenerator');
		$ass_type=isset($_REQUEST['ass_type'])? $_REQUEST['ass_type']:"";
		$id=isset($_REQUEST['ass_id'])? $_REQUEST['ass_id']:"";
		$data['ass_id']=$id;
		$data['pos_id']=$_REQUEST['pos_id'];
		$data['emp_id']=$_REQUEST['emp_id'];
		if($ass_type=='SELF'){
			$posdetails=UlsPosition::viewposition($_REQUEST['pos_id']);
			$data['posdetails']=$posdetails;
			$data['emp_info']=UlsEmployeeMaster::get_empdetails_id($_REQUEST['emp_id']);
			$data['pos_info']=UlsAssessmentPosition::get_assessment_position_info($id,$_REQUEST['pos_id']);
			$data['ass_comp']=UlsSelfAssessmentReport::getselfassessment_comp_details($id,$_REQUEST['pos_id']);
			$data['ass_details']=UlsAssessmentDefinition::viewassessment($id);
			$data['ass_dev_info']=UlsSelfAssessmentReportDevArea::getselfassessment_dev_summary($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['ass_report_info']=UlsSelfAssessmentReport::getassessment_self_competency($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['scale_info']=UlsLevelMasterScale::scale_values();
			$data['scale_info_four']=UlsLevelMasterScale::scale_values_level_four();
			$data['scale_info_five']=UlsLevelMasterScale::scale_values_level_five();
			$data['cri_info']=UlsCompetencyCriticality::criticality_names();
			$data['kras']=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($_REQUEST['pos_id']);
			$data['category']=UlsCompetencyPositionRequirements::category_comp_details($_REQUEST['pos_id']);
			include("radargraphnew.php");
			//include("radargraph.php");
			//$content = $this->load->view('pdf/self_assessment_report',$data,true);
			//$filename = "Employee - Competency Profile";
			//$this->pdfgenerator->generate($content, $filename, true, 'A4', 'portrait','competency_profiling');
			$content = $this->load->view('pdf/self_assessment_detail_reportnew',$data,true);		
			$this->render('layouts/ajax-layout',$content);
		}
		else{
			
			$posdetails=UlsPosition::viewposition($_REQUEST['pos_id']);
			$data['posdetails']=$posdetails;
			$emp_info=UlsEmployeeMaster::get_empdetails_id($_REQUEST['emp_id']);
			$data['emp_info']=$emp_info;
			$data['competencies']=UlsAssessmentCompetencies::getassessment_competencies_type($id,$_REQUEST['pos_id']);	
			$data['category']=UlsCompetencyPositionRequirements::category_comp_details($_REQUEST['pos_id']);
			//$data['ass_comp_info']=UlsAssessmentReport::getassessment_admin_competency($id,$_REQUEST['pos_id']);
			$data['scale_info']=UlsLevelMasterScale::scale_values();
			$data['scale_info_four']=UlsLevelMasterScale::scale_values_level_four();
			$data['scale_info_five']=UlsLevelMasterScale::scale_values_level_five();
			$data['cri_info']=UlsCompetencyCriticality::criticality_names();
			$beh_asstype="BEHAVORIAL_INSTRUMENT";
			$data['beh_instrument']=UlsAssessmentTest::get_ass_position_test($id,$_REQUEST['pos_id'],$beh_asstype);
			$data['kras']=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($_REQUEST['pos_id']);
			$data['modes']=UlsAdminMaster::get_value_names("IN_MODE");
			$data['testtypes']=UlsAssessmentTest::get_assessment_position($id,$_REQUEST['pos_id']);
			//include("radargraph_full.php");
			
			//$content = $this->load->view('pdf/intemp_assessment_detail_report',$data,true);
			//$filename = "".$emp_info['enumber']."-".$emp_info['name']."-assessment report";
			//$this->pdfgenerator->generate($content, $filename, true, 'A4', 'portrait','competency_profiling');
			
			$content = $this->load->view('pdf/intemp_assessment_detail_reportnew',$data,true);		
			$this->render('layouts/ajax-layout',$content);
		}		
	}
	
	public function ass_position_details(){
		$this->load->library('tcpdf');
		$this->load->library('pdfgenerator');
		$ass_type=isset($_REQUEST['ass_type'])? $_REQUEST['ass_type']:"";
		$id=isset($_REQUEST['ass_id'])? $_REQUEST['ass_id']:"";
		$data['ass_id']=$id;
		$data['pos_id']=$_REQUEST['pos_id'];
		//$data['emp_id']=$_REQUEST['emp_id'];
		if($ass_type=='SELF'){
			$posdetails=UlsPosition::viewposition($_REQUEST['pos_id']);
			$data['posdetails']=$posdetails;
			//$data['emp_info']=UlsEmployeeMaster::get_empdetails_id($_REQUEST['emp_id']);
			$data['pos_info']=UlsAssessmentPosition::get_assessment_position_info($id,$_REQUEST['pos_id']);
			$data['ass_comp']=UlsSelfAssessmentReport::getselfassessment_comp_details($id,$_REQUEST['pos_id']);
			$data['ass_details']=UlsAssessmentDefinition::viewassessment($id);
			//$data['ass_dev_info']=UlsSelfAssessmentReportDevArea::getselfassessment_dev_summary($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			//$data['ass_report_info']=UlsSelfAssessmentReport::getassessment_self_competency($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['scale_info']=UlsLevelMasterScale::scale_values();
			$data['scale_info_four']=UlsLevelMasterScale::scale_values_level_four();
			$data['scale_info_five']=UlsLevelMasterScale::scale_values_level_five();
			$data['cri_info']=UlsCompetencyCriticality::criticality_names();
			$data['kras']=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($_REQUEST['pos_id']);
			$data['category']=UlsCompetencyPositionRequirements::category_comp_details($_REQUEST['pos_id']);
			include("radargraphnew.php");
			//include("radargraph.php");
			//$content = $this->load->view('pdf/self_assessment_report',$data,true);
			//$filename = "Employee - Competency Profile";
			//$this->pdfgenerator->generate($content, $filename, true, 'A4', 'portrait','competency_profiling');
			$content = $this->load->view('pdf/self_assessment_detail_reportnew',$data,true);		
			$this->render('layouts/ajax-layout',$content);
		}
		else{
			$posdetails=UlsPosition::viewposition($_REQUEST['pos_id']);
			$data['posdetails']=$posdetails;
			//$data['emp_info']=UlsEmployeeMaster::get_empdetails_id($_REQUEST['emp_id']);
			$data['competencies']=UlsAssessmentCompetencies::getassessment_competencies_type($id,$_REQUEST['pos_id']);
			$data['category']=UlsCompetencyPositionRequirements::category_comp_details($_REQUEST['pos_id']);
			
			$data['scale_info']=UlsLevelMasterScale::scale_values_report();
			$data['cri_info']=UlsCompetencyCriticality::criticality_names();
			$beh_asstype="BEHAVORIAL_INSTRUMENT";
			$data['beh_instrument']=UlsAssessmentTest::get_ass_position_test($id,$_REQUEST['pos_id'],$beh_asstype);
			$data['kras']=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($_REQUEST['pos_id']);
			$data['modes']=UlsAdminMaster::get_value_names("IN_MODE");
			$data['scale_info_four']=UlsLevelMasterScale::scale_values_level_four();
			$data['scale_info_five']=UlsLevelMasterScale::scale_values_level_five();
			$data['testtypes']=UlsAssessmentTest::get_assessment_position($id,$_REQUEST['pos_id']);
			//$content = $this->load->view('pdf/assessment_detail_report',$data,true);
			//$pos_name=str_replace(array("/ ","/","-"," -","- "),array("_","_","_","_","_"),$posdetails['position_name']);
			//$filename = @$pos_name." - Assessment Booklet";
			//$this->pdfgenerator->generate($content, $filename, true, 'A4', 'portrait','competency_profiling');
			
			$content = $this->load->view('pdf/assessment_detail_reportnew',$data,true);		
			$this->render('layouts/ajax-layout',$content);
		}
		
		
	}
	
	/* public function ass_position_emp(){
		$data['ass_id']=$_REQUEST['ass_id'];
		$data['pos_id']=$_REQUEST['pos_id'];
		$data['emp_id']=$_REQUEST['emp_id'];
		$data['emp_info']=UlsEmployeeMaster::get_empdetails_id($_REQUEST['emp_id']);
		//$this->expenses($_REQUEST['ass_id'],$_REQUEST['pos_id'],$_REQUEST['emp_id']);
		$content = $this->load->view('index/assessment_report',$data,true);
		$this->render('layouts/ajax-layout',$content);
	} */
	
	public function expenses($ass_id,$pos_id,$emp_id){		
		/* $locwises=UlsCategory::locationwiseexpense($month,$year);
		$itemwises=UlsCategory::itemwiseexpense($month,$year); */
		$itemwise=array(2,3,4,5);
		$itemwise_key=array('one','two','three','four');
		/* Create and populate the pData object */
		$MyData = new pData();   
		$MyData->addPoints(190,"Expenses");  
		$MyData->setSerieDescription("Expenses","Itemwise Expenses");

		/* Define the absissa serie */
		$MyData->addPoints('One',"Labels");
		$MyData->setAbscissa("Labels");

		/* Create the pChart object */
		$myPicture = new pImage(700,230,$MyData);

		/* Draw the background */
		$Settings = array("R"=>255, "G"=>255, "B"=>255, "Dash"=>1, "DashR"=>255, "DashG"=>255, "DashB"=>255);
		$myPicture->drawFilledRectangle(0,0,700,230,$Settings);

		/* Overlay with a gradient */
		$Settings = array("StartR"=>255, "StartG"=>255, "StartB"=>255, "EndR"=>255, "EndG"=>255, "EndB"=>255, "Alpha"=>50);
		$myPicture->drawGradientArea(0,0,700,230,DIRECTION_VERTICAL,$Settings);

		/* Write the picture title */ 
		$myPicture->setFontProperties(array("FontName"=>LIB_PATH.DS."pChart".DS."fonts/Forgotte.ttf","FontSize"=>11));
		$myPicture->drawText(500,30,"Itemwise Expenses",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));
		$myPicture->drawText(120,30,"Locationwise Expenses",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));

		/* Set the default font properties */ 
		$myPicture->setFontProperties(array("FontName"=>LIB_PATH.DS."pChart".DS."fonts/Forgotte.ttf","FontSize"=>10,"R"=>80,"G"=>80,"B"=>80));

		/* Enable shadow computing */ 
		$myPicture->setShadow(TRUE,array("X"=>2,"Y"=>2,"R"=>150,"G"=>150,"B"=>150,"Alpha"=>100));




		

		/* Render the picture (choose the best way) */
		$myPicture->render("pictures/12/loc-item-expenses.png");
	}
	public function contact_us_form(){
	require_once('class.phpmailer.php');
require_once('class.smtp.php');
	$username="AKIAIVTS6UKQKLMDMKAA";
	$from_mail="info@simplifymytraining.com";
	$smtp_server= "email-smtp.us-east-1.amazonaws.com";//"smtpauth.net4india.com";
	$smtp_password="AvxeJhp4F3Gy6xC1hjI8WcIYeF7Ml11nYdbAFA3FY+c3";
	$smtp_port=587;
	$smtp_encrypt="tls";
	$recipient='info@simplifymytraining.com';
	$subject="N-compas Contact-us";
	$body_data="Following are the Details<br><br> Name: ".$_POST['your_name']."<br>Email: ".$_POST['business_mail']."<br>Mobile/Landline:".$_POST['phone_number']."<br> Message:".$_POST['company'];	
	$client_name="N-compas ";
	$mail = new PHPMailer;
	$mail->SMTPDebug = 4;							// Enable verbose debug output
	$mail->isSMTP();								// Set mailer to use SMTP
	$mail->Host = $smtp_server;						// Specify main and backup SMTP servers
	$mail->SMTPAuth = true;							// Enable SMTP authentication
	$mail->Username = $username;					// SMTP username
	$mail->Password = $smtp_password;				// SMTP password
	$mail->SMTPSecure = $smtp_encrypt;				// Enable TLS encryption, `ssl` also accepted
	$mail->Port = $smtp_port;						// TCP port to connect to
	
	$mail->From = $from_mail;
	$mail->FromName = $client_name;
	$mail->addAddress($recipient);
	$mail->isHTML(true);							// Set email format to HTML
	$mail->Subject = $subject;
	$mail->Body= $body_data;
	$mail->send();
    $this->session->set_flashdata('msg', 'Thank you for your interest. Our sales team will contact you shortly');
				redirect('#contact');
	}
	
	public function ass_booklet(){
		$this->load->library('pdfgenerator');
		$id=isset($_REQUEST['assess_id'])? $_REQUEST['assess_id']:"";
		$data['ass_id']=$id;
		$data['pos_id']=$_REQUEST['pos_id'];
		$posdetails=UlsPosition::viewposition($_REQUEST['pos_id']);
		$data['posdetails']=$posdetails;
		$data['competencies']=UlsAssessmentCompetencies::getassessment_competencies_type($id,$_REQUEST['pos_id']);
		$data['employee']=UlsAssessmentEmployees::getassessmentemployees_position_report($id,$_REQUEST['pos_id']);
		$data['assess_type']=UlsAssessmentCompetenciesWeightage::getassessmentcompetencies_weightage($id,$_REQUEST['pos_id']);
		$content = $this->load->view('pdf/assessment_booklet',$data,true);
		$filename = "Employee - Competency Profile";
		$this->pdfgenerator->generate($content, $filename, true, 'A4', 'portrait','competency_profiling');
	}
	
	public function ass_position_nms(){
		$this->load->library('pdfgenerator');
		$ass_type=isset($_REQUEST['ass_type'])? $_REQUEST['ass_type']:"";
		$id=isset($_REQUEST['ass_id'])? $_REQUEST['ass_id']:"";
		$data['ass_id']=$id;
		$data['pos_id']=$_REQUEST['pos_id'];
		$posdetails=UlsPosition::viewposition($_REQUEST['pos_id']);
		$data['posdetails']=$posdetails;
		$data['emp_infos']=UlsAssessmentEmployees::getassessmentemployees_position_report($id,$_REQUEST['pos_id']);
		$data['competencies']=UlsAssessmentCompetencies::getassessment_competencies_type($id,$_REQUEST['pos_id']);
		include("nms_pie_graph.php");
		$content = $this->load->view('pdf/assessment_report_old',$data,true);
		$filename = "Employee - Competency Profile";
		$this->pdfgenerator->generate($content, $filename, true, 'A4', 'portrait','competency_profiling');
		
	}
	
	public function question_name_edit_exist(){
        $validateId= (filter_input(INPUT_GET, "fieldId"))? filter_input(INPUT_GET, "fieldId"):"";
        $question_name= (filter_input(INPUT_GET, "fieldValue"))? filter_input(INPUT_GET, "fieldValue"):"";
        $question_id= (filter_input(INPUT_GET, "gid"))? filter_input(INPUT_GET, "gid"):"";
		$parent_org_ids=$this->session->userdata('parent_org_id');
        $parent_org_id= !empty($parent_org_ids)? $this->session->userdata('parent_org_id'): "";
        $sql="1";
		$sql.=!empty($question_name)? " and question_name='".$question_name."'":"";
        $sql.=!empty($parent_org_id)? " and parent_org_id='".$parent_org_id."'":"";
        $sql.=!empty($question_id)? " and question_id!='$question_id'":"";
        echo $this->commonajaxfunc('UlsQuestions',$validateId,$sql);
	}
	
	public function pre_request_insert(){
        if(isset($_POST['full_name'])){
            $fieldinsertupdates=array('full_name','email_id','mobile');
            $case=Doctrine::getTable('UlsPresentationDownload')->find($_POST['id']);
            !isset($case->id)?$case=new UlsPresentationDownload():"";
            foreach($fieldinsertupdates as $val){
				$case->$val=(!empty($_POST[$val]))?($_POST[$val]):NULL;
			}
			$case->ip_address=$_SERVER["REMOTE_ADDR"];
			$case->created_date=date("Y-m-d");
            $case->save();
			$content2 =$this->readTemplateFile("public/templates/whitepapertemplate.html");
			$name=$case->full_name;
			$fullname=ucfirst($name);
			$mailcontent="Dear ".$fullname.",<br><br>Greetings from UniTol Training Solutions!<br><br>Thank you for your interest in our N-Compas Presentation. The same is being enclosed with this mail.<br><br>Hope you enjoy reading it.<br><br>Please feel free to reach us at info@n-compas.com or Sales@UniTol.in for any further information on this topic.<br><br><br>Regards,<br>Content & Research<br>UniTol Training Solutions<br>www.UniTol.in";
			$content2=str_replace("#MAILCONTENT#",$mailcontent,$content2);
			
			$subject="Thank you for Downloading Presentation";
			$user1=new UlsNotificationHistory();
			$user1->to=$case->email_id;
			$user1->subject=$subject;
			$user1->mail_content=$content2;
			$user1->mail_type='Pres';
			$user1->parent_org_id=3;
			$user1->timestamp=date('Y-m-d');
			$user1->created_date=date("Y-m-d");
			$user1->save();
			$this->session->set_flashdata('presentation',"1");
			redirect($_POST['redirect']);
        }
        else{
			$content = $this->load->view('index/consulting',NULL,true);
			$this->render('layouts/index_layout',$content);
        }
    }
	
	public function assessment_assessor_report(){
		$ass_id=isset($_REQUEST['ass_id'])? $_REQUEST['ass_id']:"";
		$ass_type=isset($_REQUEST['ass_type'])? $_REQUEST['ass_type']:"";
		$assessor_id=isset($_REQUEST['assessor_id'])? $_REQUEST['assessor_id']:"";
		if($ass_id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$data['ass_id']=$ass_id;
			$data['asstype']=$ass_type;
			$data['assessorid']=$assessor_id;
			$data['ass_name']=UlsAssessmentDefinition::viewassessment($ass_id);
			$data['assessor_name']=UlsAssessorMaster::viewassessor($assessor_id);
			
			$data['username']=UlsReports::getusername();
			$data['type']=isset($_REQUEST['typeid'])? $_REQUEST['typeid']:"";
			$content = $this->load->view('report/lms_report_assessment_assessor_status',$data,true);
		}
		$this->render('layouts/report-layout',$content);
	}
	
	public function emp_tna_single_report(){
		$this->load->library('pdfgenerator');
		$ass_type=isset($_REQUEST['ass_type'])? $_REQUEST['ass_type']:"";
		$id=isset($_REQUEST['ass_id'])? $_REQUEST['ass_id']:"";
		$data['ass_id']=$id;
		$data['pos_id']=$_REQUEST['pos_id'];
		$data['emp_id']=$_REQUEST['emp_id'];
		if($ass_type=='SELF'){
			$posdetails=UlsPosition::viewposition($_REQUEST['pos_id']);
			$data['posdetails']=$posdetails;
			$data['emp_info']=UlsEmployeeMaster::get_empdetails_id($_REQUEST['emp_id']);
			$data['pos_info']=UlsAssessmentPosition::get_assessment_position_info($id,$_REQUEST['pos_id']);
			$data['ass_comp']=UlsSelfAssessmentReport::getselfassessment_comp_details($id,$_REQUEST['pos_id']);
			$data['ass_details']=UlsAssessmentDefinition::viewassessment($id);
			$data['ass_dev_info']=UlsSelfAssessmentReportDevArea::getselfassessment_dev_summary($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['ass_report_info']=UlsSelfAssessmentReport::getassessment_self_competency($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['scale_info']=UlsLevelMasterScale::scale_values();
			$data['scale_info_four']=UlsLevelMasterScale::scale_values_level_four();
			$data['scale_info_five']=UlsLevelMasterScale::scale_values_level_five();
			$data['cri_info']=UlsCompetencyCriticality::criticality_names();
			$data['kras']=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($_REQUEST['pos_id']);
			$data['category']=UlsCompetencyPositionRequirements::category_comp_details($_REQUEST['pos_id']);
			include("radargraphnew.php");
			//include("radargraph.php");
			//$content = $this->load->view('pdf/self_assessment_report',$data,true);
			//$filename = "Employee - Competency Profile";
			//$this->pdfgenerator->generate($content, $filename, true, 'A4', 'portrait','competency_profiling');
			$content = $this->load->view('pdf/self_assessment_detail_reportnew',$data,true);		
			$this->render('layouts/ajax-layout',$content);
		}
		else{
			$posdetails=UlsPosition::viewposition($_REQUEST['pos_id']);
			$data['posdetails']=$posdetails;
			$empd=UlsEmployeeMaster::get_empdetails_id($_REQUEST['emp_id']);
			$data['emp_info']=$empd;
			$data['competencies']=UlsAssessmentCompetencies::getassessment_competencies_type($id,$_REQUEST['pos_id']);
			//$data['ass_comp_info']=UlsAssessmentReport::getassessment_admin_summary($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
			$data['category']=UlsCompetencyPositionRequirements::category_comp_details($_REQUEST['pos_id']);
			$data['scale_info_four']=UlsLevelMasterScale::scale_values_level_four();
			$data['scale_info_five']=UlsLevelMasterScale::scale_values_level_five();
			$data['cri_info']=UlsCompetencyCriticality::criticality_names();
			$beh_asstype="BEHAVORIAL_INSTRUMENT";
			$data['beh_instrument']=UlsAssessmentTest::get_ass_position_test($id,$_REQUEST['pos_id'],$beh_asstype);
			$data['kras']=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($_REQUEST['pos_id']);
			$data['testtypes']=UlsAssessmentTest::get_assessment_position($id,$_REQUEST['pos_id']);
			$data['modes']=UlsAdminMaster::get_value_names("IN_MODE");
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
			
			$content = $this->load->view('pdf/assessment_tna_report_single_new',$data,true);
			$filename = "Employee-TNA-single-report-".$empd['enumber']."-".trim($empd['name']);
			$this->pdfgenerator->generate($content, $filename, true, 'A4', 'portrait','competency_profiling');
		}		
	}
	
	public function ass_position_emp_cal(){
		//$this->load->library('tcpdf');
		//$this->load->library('pdfgenerator');
		$ass_type=isset($_REQUEST['ass_type'])? $_REQUEST['ass_type']:"";
		$id=isset($_REQUEST['ass_id'])? $_REQUEST['ass_id']:"";
		$data['ass_id']=$id;
		$data['pos_id']=$_REQUEST['pos_id'];
		$data['emp_id']=$_REQUEST['emp_id'];
		$emp_id=$_REQUEST['emp_id'];
		$position_id=$_REQUEST['pos_id'];
		$assdeails_ass=UlsAssessmentDefinition::viewassessment($id);
		$data['assdetail_data']=$assdeails_ass;
		$ass_pos_details=UlsAssessmentPosition::get_assessment_position_info($_REQUEST['pos_id'],$id);
		$data['assposdetail']=$ass_pos_details;
		$data['final_deve_comments']=UlsAssessmentReportFinal::assessment_report_final_admin($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
		$posdetails=UlsPosition::viewposition($_REQUEST['pos_id']);
		$data['posdetails']=$posdetails;
		$empd=UlsEmployeeMaster::get_empdetails_id($_REQUEST['emp_id']);
		$data['emp_info']=$empd;
		$data['competencies']=UlsAssessmentCompetencies::getassessment_competencies_type($id,$_REQUEST['pos_id']);
		//$data['ass_comp_info']=UlsAssessmentReport::getassessment_admin_summary($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
		$data['category']=UlsCompetencyPositionRequirements::category_comp_details($_REQUEST['pos_id']);
		$data['scale_info_four']=UlsLevelMasterScale::scale_values_level_four();
		$data['scale_info_five']=UlsLevelMasterScale::scale_values_level_five();
		$data['cri_info']=UlsCompetencyCriticality::criticality_names();
		$beh_asstype="BEHAVORIAL_INSTRUMENT";
		$data['beh_instrument']=UlsAssessmentTest::get_ass_position_test($id,$_REQUEST['pos_id'],$beh_asstype);
		$data['kras']=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($_REQUEST['pos_id']);
		$data['testtypes']=UlsAssessmentTest::get_assessment_position($id,$_REQUEST['pos_id']);
		$data['modes']=UlsAdminMaster::get_value_names("IN_MODE");
		$data['ass_results']=UlsAssessmentTest::assessment_results_avg($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
		$data['assessor_rating_new']=UlsAssessmentAssessorRating::assessor_results_report_new($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
		
		$data['ass_rating_scale']=UlsAssessmentDefinition::view_assessment_rating($id);
		$data['ass_development']=UlsAssessmentReport::getassessment_competencies_summary_report($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
		$data['ass_rating_comments']=UlsAssessmentAssessorRating::get_ass_rating_comments($id,$_REQUEST['pos_id'],$_REQUEST['emp_id']);
		$data['assmethods']=UlsAssessmentTest::get_assessment_position_report($_REQUEST['ass_id'],$_REQUEST['pos_id']);
		$content = $this->load->view('pdf/assessment_report_energy_calcualtion',$data,true);		
		$this->render('layouts/ajax-layout',$content);
				
	}
	
	
}
