<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends  MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		//$this->load->model('QuizUsermaster');
		$user_id=$this->session->userdata('user_id');
		if(empty($user_id)){
			redirect(site_url(),'refresh');
			exit;
        }
	}

	private function readTemplateFile($FileName) {
		$fp = fopen($FileName,"r") or exit("Unable to open File ".$FileName);
		$str = "";
		while(!feof($fp)) {
			$str .= fread($fp,1024);
		}
		return $str;
	}

	 public function sessionexist(){
        $user_id=$this->session->userdata('user_id');
		if(empty($user_id)){
			redirect(site_url(),'refresh');
			exit;
        }
    }

	/*
	* Created by Srikanth for Event Material Uploads file and folder delete
	* this is used for deleting the folder from uploads/learning_material/organization_id
	* this will delete all the folders, subfolders and files
	*/
	private function recursive_dir($dir) {
		foreach(scandir($dir) as $file) {
			if ('.' === $file || '..' === $file) continue;
			if (is_dir("$dir/$file")) $this->recursive_dir("$dir/$file");
			else unlink("$dir/$file");
		}
		rmdir($dir);
	}

	public function index(){
		if($this->session->userdata('emp_id')){
			$data["aboutpage"]=$this->pagedetails('admin','index');
			$content = $this->load->view('admin/index',$data,true);
			$this->render('layouts/adminnew',$content);
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

	// employee profile

    public function profile(){

		//$data["aboutpage"]=$this->pagedetails('admin','profile');
		$emp_ids=$this->session->userdata('emp_id');
        if(!empty($emp_ids)){
			$emp_id=$this->session->userdata('emp_id');
			$data['userdetails']=UlsEmployeeMaster::getempdetails($emp_id);
			/* $data['learner17']=UlsEnrollments::get_enrollment_count_dashboard($emp_id);
            $data['learner12']=UlsEnrollments::get_enrollment_dash($emp_id);
			$data['learner55']=UlsEnrollments::get_enrollment_history_count_dashboard($emp_id);
			$data['ebook_cart']=UlsEmpBookHistory::get_ebook_emp_details();  */
			if(isset($_REQUEST['home'])){
				$orgid=$this->session->userdata('parent_org_id');
				$orgcoun=Doctrine_Query::Create()->from('UlsEmployeeWorkInfo')->where("employee_id=".$emp_id." and parent_org_id=".$orgid." and org_id<>'' and status='A'")->execute();
				$orgcounts=count($orgcoun);
				if($orgcounts>0){foreach($orgcoun as $orgid){$this->session->userdata('org_id',$orgid->org_id);}}else{$this->session->userdata('org_id',$this->session->userdata('parent_org_id'));}
				$super_id=UlsEmployeeMaster::get_supervisor_id($emp_id);
				$man_id=isset($super_id->supervisor_id)?$super_id->supervisor_id:0;
				if(isset($super_id->location_id)){
					$location=$super_id->location_id;
					$data['location']=UlsEmployeeMaster::get_admin_location($location);
				}
				$emp_type="NEW_EMP_TYPE";
				$nationality="NATIONALITY";
				$data['emp_type']=UlsAdminMaster::get_value_names($emp_type);
				$data['nationalityes']=UlsAdminMaster::get_value_names($nationality);
				//echo $emp_id;
				$data['emp_photo']=UlsEmployeeMaster::get_emp_photo($emp_id);
				$man_photo=UlsEmployeeMaster::get_emp_photo($man_id);
				$data['man_photo']=$man_photo;
				$man_org_id=(isset($man_photo->employee_id))?$man_photo->employee_id:'';
				$man_org_id=UlsEmployeeMaster::get_org_id($man_org_id);
				$orga_name=(isset($man_org_id->org_id))?$man_org_id->org_id:null;
				//echo $emp_id;
				if($orga_name>0){
					$data['man_org_name']=UlsEmployeeMaster::get_orga_name($orga_name);
				}
				$emp_org_id=UlsEmployeeMaster::get_org_id($emp_id);
				$emp_orga_name=(isset($emp_org_id->org_id))?$emp_org_id->org_id:null;
				if($emp_orga_name>0){
				$data['emp_org_name']=UlsEmployeeMaster::get_orga_name($emp_orga_name);
				}
				$content = $this->load->view('employee/employee_profile',$data,true);
				$this->render('layouts/employee',$content);

			}else if($this->session->userdata('user_role')=='emp'){
				if(!empty($_REQUEST['position_id']))
				{
				 $data['positionid']=$_REQUEST['position_id'];
				}
				$getempdetails=UlsEmployeeWorkInfo::getEmpPositionDetails($emp_ids);
				
				if(!empty($getempdetails)){
					$empwork=array();
					$empwork[0]['joining_date']=$getempdetails[0]['from_date'];
					$empwork[0]['position_id']=$getempdetails[0]['position_id'];
					
				}
				$getempstagdetails=UlsEmpStagingTable::getEmpStageDetails($emp_ids);
				if(count($getempstagdetails)>0){
					$getemppos=array();
					foreach($getempstagdetails as $k=>$val){
						$getemppos[$k]['joining_date']=$val['joining_date'];
						$getemppos[$k]['position_id']=$val['position_id'];
					}
					$merge = array_merge($empwork, $getemppos);
					$data['joining']=$merge;
				}
				else{
					$merge = array_merge($empwork);
					$data['joining']=$merge;
				}
				if(isset($_POST['new_password'])){
					$checkuser=Doctrine::getTable('UlsUserCreation')->find($this->session->userdata('user_id'));
					if(isset($checkuser->user_id)){
						$checkuser->password=(!empty($_POST['new_password']))?trim($_POST['new_password']):'welcome';
						$checkuser->user_login=1;
						$checkuser->save();
						//redirect("employee/profile");
					}
					else{
						$data['message']="Some error occurred please try again";
					}
				}
			    /*  unset($this->session->userdata('e_emp_id'));
				 unset($this->session->userdata('e_user_id')); */
				$content = $this->load->view('employee/employee_profile',$data,true);
				$this->render('layouts/employee_layout',$content);
			}
			else if($this->session->userdata('user_role')=='man'){
			    /*  unset($this->session->userdata('e_emp_id'));
				 unset($this->session->userdata('e_user_id')); */
				$content = $this->load->view('manager/manager_profile',$data,true);
				$this->render('layouts/employee_layout',$content);
			}
			else if($this->session->userdata('user_role')=='aptri'){
				
					redirect('admin/employee_training_tna_report');
				
				
			}
			else if($this->session->userdata('user_role')=='agel'){
				redirect('admin/agel_dashboard');
			}
			else if($this->session->userdata('user_role')=='admin'){
				$this->session->set_userdata('emp_type','');
				//$this->session->set_userdata('pop_id',"1");		
				if(!empty($_SESSION['security_location_id'])){
					redirect('admin/location_employee_search');
				}
				else{
					redirect('admin/dashboard');
				}
			}
			else{
				$content = $this->load->view('employee/employee_profile',$data,true);
				$this->render('layouts/employee',$content);
		    }
		}
        else{
            //$this->registry->template->public_announcements=UlsAdminAnnouncements::get_profile_announcements_public();
			$content = $this->load->view('admin/lms_admin_no_profile',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }

	/*
     * Created by Srikanth Modified by Srikanth layoutmenus
	 * This method is used set or change role id, menu id user_role, parnet_org_id,org start & end dates emp_id and menu
	 * Table used uls_menu_creation,uls_role_creation,uls_organization_master,uls_user_creation,uls_employee_work_info
    */
	public function layoutmenus(){
		$this->session->unset_userdata('security_org_id');
		$this->session->unset_userdata('security_location_id');
		$this->session->unset_userdata('security_type');
		$role=$this->session->unset_userdata('security_type');
		$emp_id=Doctrine_Core::getTable('UlsUserCreation')->find($this->session->userdata('user_id'));
		if(!empty($emp_id->employee_id)){
			$id=$_REQUEST['id'];
			$this->session->set_userdata('Role_id',$id);
			$this->session->set_userdata('Menu_Id',$_REQUEST['menu']);
			$role=Doctrine_Core::getTable('UlsMenuCreation')->find($_REQUEST['menu']);
			$this->session->set_userdata('user_role',$role->system_menu_type);
			$parentid=Doctrine_Core::getTable('UlsRoleCreation')->find($id);
			$this->session->set_userdata('parent_org_id',$parentid->parent_org_id);
			$secure=UlsSecurityProfile::secureProfile($parentid->secure_profile_id);
			$orgdata=Doctrine_Core::getTable('UlsOrganizationMaster')->find($parentid->parent_org_id);
			//$_SESSION['org_id']=$orgdata->organization_id;
			$this->session->set_userdata('org_start_date',$orgdata->start_date);
			$this->session->set_userdata('org_end_date',$orgdata->end_date);
			$emp_id=Doctrine_Core::getTable('UlsUserCreation')->find($this->session->userdata('user_id'));
			$this->session->set_userdata('emp_id',$emp_id->employee_id);
			$coun=Doctrine_Query::Create()->from('UlsEmployeeWorkInfo')->where('supervisor_id='.$emp_id->employee_id)->execute();
			$counts=count($coun);
			($counts>0)?$this->session->set_userdata('mngr_id',$emp_id->employee_id):"";
			$orgcoun=Doctrine_Query::Create()->from('UlsEmployeeWorkInfo')->where("employee_id=".$emp_id->employee_id." and parent_org_id=".$parentid->parent_org_id." and org_id<>'' and status='A'")->execute();
			$orgcounts=count($orgcoun);
			if($orgcounts>0){foreach($orgcoun as $orgid){$this->session->set_userdata('org_id',$orgid->org_id);}}else{$this->session->set_userdata('org_id',$parentid->parent_org_id);}
			if($role->system_menu_type=='asr'){
				$this->session->set_userdata('asr_id',$emp_id->assessor_id);
				redirect("assessor/profile");
			}
			elseif($role->system_menu_type=='man'){
				$this->session->set_userdata('man_id',$emp_id->employee_id);
				redirect("manager/profile");
			}
			else{
				//echo $this->session->userdata('user_role');
				redirect("admin/profile");
			}
		}
		else{
			$this->session->set_userdata('asr_id',$emp_id->assessor_id);
			redirect("assessor/profile");
		}
		//print_r($this->session);
	}

	//employee booking Status

    public function edit_booking_status(){
		$data["aboutpage"]=$this->pagedetails('admin','booking_status_edit');
		$booking_status="SYSTEM_ENROLLMENT_STATUS";
		$status="STATUS";
		$data['status']=UlsAdminMaster::get_value_names($booking_status);
		$data['active']=UlsAdminMaster::get_value_names($status);
        $data['status_view']=UlsBookingStatus::get_booking_status_view();
		$content = $this->load->view('employee/lms_booking_status_edit',$data,true);
		$this->render('layouts/adminnew',$content);
    }
	
	public function employee_type_details(){
		if(isset($_POST['save'])){
			if(isset($_POST['data_radio'])){
				if($_POST['data_radio']=="MS"){
					$this->session->set_userdata('emp_type',$_POST['data_radio']);
				}
				if($_POST['data_radio']=="NMS"){
					$this->session->set_userdata('emp_type',$_POST['data_radio']);
				}
				if($_POST['data_radio']=="Both"){
					$this->session->set_userdata('emp_type','');
				}
			}
			$this->session->unset_userdata('pop_id');
			redirect("admin/dashboard");
		}
		
	}

	public function lms_booking_status(){
		if(isset($_POST['save'])){
			foreach($_POST['system_status'] as $key1=>$system){
				$booking_status=Doctrine_Core::getTable('UlsBookingStatus')->findOneByBooking_Status_Id($_POST['b_id'][$key1]);
				if(!isset($booking_status->booking_status_id)){
					$booking_status=new UlsBookingStatus();
				}
				$booking_status->parent_org_id=$this->session->userdata('parent_org_id');
				$booking_status->system_status=$system;
				$booking_status->user_status=$_POST['user_status'][$key1];
				$booking_status->status=$_POST['status'][$key1];
				$booking_status->start_date=(!empty($_POST['start_date'][$key1]))?date('Y-m-d',strtotime($_POST['start_date'][$key1])):NULL;
				$booking_status->end_date=(!empty($_POST['end_date'][$key1]))?date('Y-m-d',strtotime($_POST['end_date'][$key1])):NULL;
				$booking_status->Save();
			}
		}
		redirect("admin/edit_booking_status");
	}
	
	public function filesystem(){
		$data=array();
		$content = $this->load->view('admin/elfinder',$data,true);
		$this->render('layouts/file',$content);
	}

	/*
     * Created by Srikanth Modified by Srikanth menucreation
	 * This method is used to view menus
	 * Based on the filter Per Page, Role, Menu Name
	 * Table used uls_menu_creation,uls_menu
    */
    public function menucreation(){
        $data["aboutpage"]=$this->pagedetails('admin','menucreation');
        $limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
        $menu_name=filter_input(INPUT_GET,'menu_name') ? filter_input(INPUT_GET,'menu_name'):"";
        $menu_type=filter_input(INPUT_GET,'menu_type') ? filter_input(INPUT_GET,'menu_type'):"";
        $page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
        $start=$page!=0? ($page-1)*$limit:0;
        $filePath=BASE_URL."/admin/menucreation";
        $data['limit']=$limit;
        $data['menu_name']=$menu_name;
        $data['menu_type']=$menu_type;
        $data['perpages']=UlsMenuCreation::perpage();
        $data['actor_types']=Doctrine_Query::Create()->from('UlsActors')->execute();
        $data['menu_types']=Doctrine_Query::Create()->from('UlsMenuCreation')->execute();
        $data['menuss']=UlsMenuCreation::search($start, $limit,$menu_name,$menu_type);
        $total=UlsMenuCreation::searchcount($menu_name,$menu_type);
        $otherParams="&perpage=".$limit."&menu_type=$menu_type&menu_name=$menu_name";
        $data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/lms_admin_menucreationsearch',$data,true);
		$this->render('layouts/adminnew',$content);
    }

	/*
     * Created by Srikanth Modified by Srikanth create_menus
	 * This method is used to Create or Modify menu
	 * Based on menu id
	 * Table used uls_menu_creation,uls_menu
    */
    public function create_menus(){
        $data["aboutpage"]=$this->pagedetails('admin','create_menus');
		$id=filter_input(INPUT_GET,'id') ? filter_input(INPUT_GET,'id'):"";
		$hash=filter_input(INPUT_GET,'hash') ? filter_input(INPUT_GET,'hash'):"";
		$menutype=!empty($id)? UlsMenuCreation::menutype($id):"";
		$flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
		$data['actor_type']=Doctrine_Query::Create()->from('UlsActors')->execute();
		if($flag==1){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
            if(!empty($menutype->system_menu_type)){
                $submenupage=Doctrine_Query::create()->from("UlsMenuCreation")->where("system_menu_type='".$menutype->system_menu_type."' and default_menu=1")->fetchOne();
                $ulsmenu= new UlsMenu();
                $selectbox=$ulsmenu->display_children_child(0,0,$submenupage->menu_creation_id,$menutype->system_menu_type);
                $data['selectboxes']=$selectbox;
                $data['parentid']=$submenupage->menu_creation_id===$menutype->menu_creation_id?true:false;
            }
			$data['menutype']=$menutype;
			$content = $this->load->view('admin/lms_admin_menucreation',$data,true);
        }
		
		$this->render('layouts/adminnew',$content);
	}

	/*
     * Created by Srikanth Modified by Srikanth actorpage
	 * This method is used to get default menu items into selectbox
	 * Based on menu id
	 * Table used uls_menu_creation,uls_menu
    */
    public function actorpage(){
        $type=filter_input(INPUT_GET, 'id');
        $submenupage=Doctrine_Query::create()->from("UlsMenuCreation")->where("system_menu_type='".$type."' and default_menu=1")->fetchOne();
        if(!empty($type)){
            $ulsmenu= new UlsMenu();
            echo $ulsmenu->display_children_child(0,0,$submenupage->menu_creation_id,$type);
        }
    }
	
	/*
     * Created by Srikanth Modified by Srikanth selectlist 
	 * This method is used to get default menu items into selectbox and disable the option selected
	 * Table used uls_menu_creation,uls_menu
    */
    public function selectlist(){
        $ids=filter_input(INPUT_POST, 'id'); $id=explode(",",$ids); $type=filter_input(INPUT_POST, 'type'); $creation=filter_input(INPUT_POST, 'creationid');
		if(!empty($type)){
			$submenupage=Doctrine_Query::create()->from("UlsMenuCreation")->where("system_menu_type='".$type."' and default_menu=1")->fetchOne();
			$ulsmenu= new UlsMenu();
			!empty($creation)? ($creation!=$submenupage->menu_creation_id? $ulsmenu->removelink($creation,$submenupage->menu_creation_id,$type,$ids):""):"";
			echo $ulsmenu->display_children_child(0,0,$submenupage->menu_creation_id,$type,"",$id);
		}
    }

	/*
     * Created by Srikanth Modified by Srikanth menulist
	 * This method is used to add menu item from select to newly creating menu
	 * Table used uls_menu
    */
    public function menulist(){
        if(filter_input(INPUT_POST,'id',FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY)){
            $id=implode(",",  filter_input(INPUT_POST,'id',FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY));
			 $ch_id=$_POST['ch_id'];
            $ulsmenu= new UlsMenu();
            $ulsmenu->menulist($id,$ch_id);
        }
    }

	/*
     * Created by Srikanth Modified by Nagaraj create_menu
	 * This method is used to insert or update menu items into DB
	 * Based on menu id
	 * Modified to update for the role based on parent_org_id, if super admin modifies the menu
	 * Table used uls_menu_creation,uls_menu
    */
    public function create_menu(){
        if(isset($_POST['menu_name'])){
            $menucreation=!empty($_POST['menu_creation_id'])? Doctrine_Core::getTable('UlsMenuCreation')->find($_POST['menu_creation_id']):new UlsMenuCreation();
            $menucreation->menu_name=filter_input(INPUT_POST,'menu_name');
            $menucreation->system_menu_type=filter_input(INPUT_POST,'menu_type');
            $menucreation->default_menu=filter_input(INPUT_POST,'default_menu');
            $menucreation->save();
            $aa=json_decode(filter_input(INPUT_POST,'nestable'));
			$mid='';$del_menuid='';
            foreach($aa as $key=>$a){
                $menunamee="menu";$name="name";$default_name="default_name";$link="link";$image_link="image_link";$create_page="create_page";$update_page="update_page";$read_page="read_page";$delete_page="delete_page";
                $menu=!empty($_POST[$menunamee][$a->id])? Doctrine_Core::getTable('UlsMenu')->find($_POST[$menunamee][$a->id]) : new UlsMenu();
                $menu->parent_id=0;
                $menu->menu_name=$_POST[$name][$a->id];
                $menu->default_name=$_POST[$default_name][$a->id];
                $menu->type=$_POST['menu_type'];
                $menu->menu_creation_id=$menucreation->menu_creation_id;
                $menu->sort_page=$key;
                $menu->link=$_POST[$link][$a->id];
				isset($_POST[$image_link][$a->id])?!empty($_POST[$image_link][$a->id])? $menu->image_link=$_POST[$image_link][$a->id]:"":"";
                isset($_POST[$create_page][$a->id])? $menu->create_page=$_POST[$create_page][$a->id]:"";
                isset($_POST[$update_page][$a->id])? $menu->update_page=$_POST[$update_page][$a->id]:"";
                isset($_POST[$read_page][$a->id])? $menu->read_page=$_POST[$read_page][$a->id]:"";
                isset($_POST[$delete_page][$a->id])? $menu->delete_page=$_POST[$delete_page][$a->id]:"";
                $menu->save();
                if(isset($a->children)){
                    $menu_child_ids=UlsMenu::parentchild($menu->menu_id,$menucreation->menu_creation_id,$a->children,$_POST);
                }
				//Modified Code
				if(!empty($_POST['menu_creation_id'])){
					//$roleid=Doctrine_Core::getTable('UlsRoleCreation')->findOneByMenuId($_POST['menu_creation_id']);
					($mid=='')? $mid=$menu->menu_id:$mid=$mid.','.$menu->menu_id;
					if(!empty($menu_child_ids)){
						$mid=$menu_child_ids.','.$mid;
					}
				}
            }
			//Modified Code
			if(!empty($_POST['menu_creation_id'])){
				Doctrine_Query::Create()->Delete('UlsMenu')->where('menu_creation_id='.$_POST['menu_creation_id'].' and menu_id not in ('.$mid.')')->execute();

				$roleid=Doctrine_Core::getTable('UlsRoleCreation')->findOneByMenuId($_POST['menu_creation_id']);
				if(!empty($roleid)){
					$update_menu=Doctrine_Query::Create()->update('UlsUserRole')->set('menu_id','?',$mid)->where('role_id='.$roleid->role_id.' and parent_org_id='.$roleid->parent_org_id.'')->execute();
				}
			}
			//End of Modified code
        }
		redirect("admin/menucreation");
    }



	public function organization(){
		$data["aboutpage"]=$this->pagedetails('admin','master_home');
        $limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
        $organization=filter_input(INPUT_GET,'organization') ? filter_input(INPUT_GET,'organization'):"";
        $org_type=filter_input(INPUT_GET,'org_type') ? filter_input(INPUT_GET,'org_type'):"";
        $page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
        $start=$page!=0? ($page-1)*$limit:0;
        $filePath=BASE_URL."/admin/organization";
        $data['limit']=$limit;
        $data['organization']=$organization;
        $data['org_type']=$org_type;
        $data['perpages']=UlsMenuCreation::perpage();
        $data['organizationtypes']=UlsAdminMaster::organizationtypes();
        $data['masterlists']=UlsOrganizationMaster::search($organization,$org_type,$start, $limit);
        $total=UlsOrganizationMaster::searchcount($organization,$org_type);
        $otherParams="perpage=".$limit."&organization=$organization&org_type=$org_type";
		$data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/organization_search',$data,true);
		$this->render('layouts/adminnew',$content);

    }

	public function Org_details(){
		if(isset($_POST['org_name'])){
			$fieldinsert=array('org_name', 'org_type', 'org_type1', 'org_manager', 'location');
			$datefield=array('start_date'=>'stdate','end_date'=>'enddate');
			$orgdata=(!empty($_POST['org_id']))?Doctrine::getTable('UlsOrganizationMaster')->find($_POST['org_id']): new UlsOrganizationMaster();
			$orgdata->parent_org_id=$this->session->userdata('parent_org_id');
			foreach($fieldinsert as $val){
				$orgdata->$val=(!empty($_POST[$val]))?$_POST[$val]:NULL;
			}
			foreach($datefield as $key=>$dateval){
				$orgdata->$key=(!empty($_POST[$dateval]))?date('Y-m-d',strtotime($_POST[$dateval])):NULL;
			}
			if($_POST['org_type']=='BU'){
				$orgdata->division_id=$_POST['division_id'];
			}
			$orgdata->save();
			if($orgdata->org_type=='PO'){
			$orgdata2=Doctrine::getTable('UlsOrganizationMaster')->find($orgdata->organization_id);
			$orgdata2->parent_org_id=$orgdata->organization_id;
			$orgdata2->org_url=$_POST['url'];
			$orgdata2->save();
			}
			$orgid=$orgdata->organization_id;
			$hash=SECRET.$orgid;
			redirect("admin/org_master_view?message&orgid=".$orgid."&hash=".md5($hash));
			$this->session->set_flashdata('msg',"Organization data ".(!empty($_POST['org_id'])?"updated":"inserted")." successfully.");
		}
		else{
			redirect("admin/organization");
		}
	}

	/*
     * Modified by Nagaraj Modified by Nagaraj org_master_view
	 * This method is used to get Master code and value
	 * based on filters like PerPage and Master Code default all are shown
	 * Table used uls_admin_master
    */
    public function org_master_view(){
		$data["aboutpage"]=$this->pagedetails('admin','organization_masters');
        $id=filter_input(INPUT_GET,'orgid') ? filter_input(INPUT_GET,'orgid'):"";
        $hash=filter_input(INPUT_GET,'hash') ? filter_input(INPUT_GET,'hash'):"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1){
           $content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
            $data['orgdetails']=UlsOrganizationMaster::vieworganization($id);
			$content = $this->load->view('admin/lms_admin_organization_view',$data,true);
		}
		$this->render('layouts/adminnew',$content);

    }

	public function deletemenu(){
		$id=trim($_REQUEST['val']);
		if(!empty($id)){
			$mmenu=Doctrine_Query::create()->from('UlsRoleCreation')->where('menu_id='.$id)->execute();
			if(count($mmenu)==0){
				$q = Doctrine_Query::create()->delete('UlsMenu')->where('menu_creation_id=?',$id);
				$q->execute();
				$q = Doctrine_Query::create()->delete('UlsMenuCreation')->where('menu_creation_id=?',$id);
				$q->execute();
				echo 1;
			}
			else{
				echo "Selected Menu cannot be deleted. Ensure you delete all the usages of the Menu before you delete it.";
			}
		}
	}

	/*
     * Created by Srikanth Modified by Srikanth viewmenu
	 * This method is used to view menu details
	 * Based on menu id
	 * Table used uls_menu_creation,uls_menu
    */
    public function viewmenu(){
        $data["aboutpage"]=$this->pagedetails('admin','viewmenu');
		$id=filter_input(INPUT_GET,'id') ? filter_input(INPUT_GET,'id'):"";
		$hash=filter_input(INPUT_GET,'hash') ? filter_input(INPUT_GET,'hash'):"";
		$flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
		if($flag==1 || $id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$data['menu_id']=$id;
			$data['menu']=!empty($id)? UlsMenu::display_children(0,1,$id):"No Menu Present";
			$content = $this->load->view('admin/lms_admin_menucreation_view',$data,true);
		}
		$this->render('layouts/adminnew',$content);
	}

	/*
     * Modified by Srikanth Start of Role Creation Module
    */

    /*
     * Created by Srikanth Modified by Srikanth role
	 * This method is used to search role
	 * Based on per page and role name
	 * Table used uls_role_creation
    */
    public function role(){
        $data["aboutpage"]=$this->pagedetails('admin','role');
        $limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
        $role_name=filter_input(INPUT_GET,'role_name') ? filter_input(INPUT_GET,'role_name'):"";
        $role_code=filter_input(INPUT_GET,'role_code') ? filter_input(INPUT_GET,'role_code'):"";
        $page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
        $start=$page!=0? ($page-1)*$limit:0;
        $filePath=BASE_URL."/admin/role";
        $data['limit']=$limit;
        $data['rolen']=$role_name;
        $data['rolec']=$role_code;
        $data['perpages']=UlsMenuCreation::perpage();
        $data['roletypess']=Doctrine_Query::Create()->from('UlsRoleCreation')->execute();
        $data['roless']=UlsRoleCreation::search($start, $limit,$role_name,$role_code);
        $total=UlsRoleCreation::searchcount($role_name,$role_code);
        $otherParams="perpage=".$limit."&role_name=$role_name";
        $data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/lms_admin_role_search',$data,true);
		$this->render('layouts/adminnew',$content);
    }

	 /*
     * Created by Srikanth Modified by Srikanth create_role
	 * This method is used to create to modify role data in the form
	 * Table used uls_role_creation
    */
    public function create_role(){
        $data["aboutpage"]=$this->pagedetails('admin','create_role');
        $id= filter_input(INPUT_GET,'id')?filter_input(INPUT_GET,'id'):"";
		$hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
		$flag=((md5(SECRET.$id)!=$hash)?1:0);
		if($flag==1 && !empty($id)){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			if(!empty($id)){
				$rcreate=Doctrine_Core::getTable('UlsRoleCreation')->find($id);
				$data['rolecreate']=$rcreate;
				$data['hierarchy']=Doctrine_Query::create()->from('UlsHeirarchyMaster')->where('parent_org_id='.$rcreate->parent_org_id)->execute();
				$data['report']=Doctrine_Query::Create()->from('UlsReportGroups')->where('parent_org_id='.$rcreate->parent_org_id)->execute();
            } else{ $data['hierarchy']=array();  $data['report']=array();}
			$data['menu']=Doctrine_Query::Create()->from('UlsMenuCreation')->execute();
			$data['secure']=UlsSecurityProfile::getAllProfiles();
			$data['orga']=Doctrine_Query::Create()->from('UlsOrganizationMaster')->where("org_type='PO'")->execute();
			$content = $this->load->view('admin/lms_admin_role',$data,true);
		}
		$this->render('layouts/adminnew',$content);
    }

	/*
     * Created by Srikanth Modified by Srikanth lms_role
	 * This method is used insert or modify data
	 * Based on role id
	 * Table used uls_role_creation
    */
    public function lms_role(){
		$fieldinsertupdates=array('role_name','role_code','parent_org_id','secure_profile_id','report_group_id','comment');
		$datefields=array('start_date','end_date');
        $role=!empty($_POST['role_id'])? Doctrine_Core::getTable('UlsRoleCreation')->find($_POST['role_id']):new UlsRoleCreation();
		foreach($fieldinsertupdates as $val){ $role->$val=!empty($_POST[$val])? trim($_POST[$val]):null;}
		foreach($datefields as $val){$role->$val=!empty($_POST[$val])?date("Y-m-d", strtotime($_POST[$val])):NULL;}
		$menu_id=explode(",",$_POST['menu_id']);
		$role->menu_id=$menu_id[0];
		$role->system_menu_type=$menu_id[1];
        $role->save();
		$this->session->set_flashdata('message',"Role data ".(!empty($_POST['role_id'])?"updated":"inserted")." successfully.");
		redirect("admin/role_view?id=".$role->role_id."&hash=".md5(SECRET.$role->role_id));

    }

	/*
     * Created by Srikanth Modified by Srikanth role_view
	 * This method is used view role details
	 * Based on role id
	 * Table used uls_role_creation
    */
    public function role_view(){
        $id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=((md5(SECRET.$id)!=$hash)?1:0);
        if($flag==1){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
            $data['roledetails']=UlsRoleCreation::viewrole($id);
			$content = $this->load->view('admin/lms_admin_role_view',$data,true);
		}
		$this->render('layouts/adminnew',$content);
    }

	public function deleterole(){
		$id=trim($_REQUEST['val']);
		if(!empty($id)){
			$rrole=Doctrine_Query::create()->from('UlsUserRole')->where('role_id='.$id)->execute();
			if(count($rrole)==0){
				$q = Doctrine_Query::create()->delete('UlsRoleCreation')->where('role_id=?',$id);
				$q->execute();
				echo 1;
			}
			else{
				echo "Selected Role cannot be deleted. Ensure you delete all the usages of the Role before you delete it.";
			}
		}
	}
    /*
     * Modified by Srikanth End of Role Creation Module
    */

	/*
     * Created by Srikanth Modified by Srikanth user_creation
	 * This method is used search users with refer to parent org id
	 * Based on filter like per page and username
	 * Table used uls_user_creation
    */
    public function user_creation(){
        $data["aboutpage"]=$this->pagedetails('admin','user_creation');
        $limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
        $username= filter_input(INPUT_GET,'username');
        $page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
        $start=$page!=0? ($page-1)*$limit:0;
        $filePath=BASE_URL."/admin/user_creation";
        $data['limit']=$limit;
        $data['username']=$username;
        $data['perpages']=UlsMenuCreation::perpage();
        $data['usercreations']=UlsUserCreation::search($start,$limit,$username);
        $total=UlsUserCreation::searchcount($username);
        $otherParams="&perpage=".$limit."&username=".$username;
        $data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/lms_admin_user_creation_search',$data,true);
		$this->render('layouts/adminnew',$content);
    }

	/*
     * Created by Srikanth Modified by Srikanth create_user
	 * This method is used insert or modify user and attach role to users
	 * Table used uls_user_creation,uls_user_role, uls_employee_master
    */
    public function create_user(){
        $data["aboutpage"]=$this->pagedetails('admin','create_user');
        $id= filter_input(INPUT_GET,'id')?filter_input(INPUT_GET,'id'):"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
		$flag=((md5(SECRET.$id)!=$hash)?1:0);
		if($flag==1 && !empty($id)){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			if(!empty($id)){
				$ucreate=Doctrine_Core::getTable('UlsUserCreation')->find($id);
				$data['usercreate']=$ucreate;
				$rcreate=Doctrine_Core::getTable('UlsUserRole')->findbyUserId($ucreate->user_id);
				$data['rolecreate']=$rcreate;
			}
			$sql=($this->session->userdata('username')=='unitol_admin' && $this->session->userdata('parent_org_id')==1 && $id==27)? "1 and parent_org_id=".$this->session->userdata('parent_org_id'): "1 and parent_org_id=".$this->session->userdata('parent_org_id');
			$sql2=($this->session->userdata('username')=='unitol_admin' && $id==27)? "1": "1 and parent_org_id=".$this->session->userdata('parent_org_id');
			$data['employees']=isset($ucreate->employee_id)?!empty($ucreate->employee_id)?UlsEmployeeMaster::fetch_emp($ucreate->employee_id):array():array();
			$data['roless']=Doctrine_Query::Create()->from('UlsRoleCreation')->where($sql2)->execute();
			$content = $this->load->view('admin/lms_admin_user_creation',$data,true);
		}
		$this->render('layouts/adminnew',$content);
    }

	/*
     * Created by Srikanth Modified by Srikanth menu_execlusion
	 * This method is used has ajax function to get menu item attached to that role
	 * Based on role id
	 * Table used uls_role_creation,uls_menu_creation,uls_menu
    */
    public function menu_execlusion(){
        $id=$_REQUEST['id'];
        $roleid=intval($_REQUEST['role_id']);
        $menui=array();
        if(!empty($roleid) && is_int($roleid)){
            $menuitemss=Doctrine_Query::Create()->from('UlsRoleCreation a')->leftJoin('a.UlsMenuCreation b')->leftJoin('b.UlsMenu c')->where("a.role_id=".$roleid)->setHydrationMode(Doctrine::HYDRATE_ARRAY)->fetchOne();
            foreach($menuitemss['UlsMenuCreation']['UlsMenu'] as $mitem){
                $menui[]=$mitem['menu_id'];
            }
        }
        $men=implode(",",$menui);
        echo "<input type='hidden' value='".$men."' name='menuid[$id]' id='menuids_".$id."' ><a onClick='exclusion(".$roleid.",".$id.")'><input type='button' name='exclusion' id='exclusion".$id."' value='Menu' class='bigbutton'></a>";
    }

	/*
     * Created by Srikanth Modified by Srikanth lms_usercreation
	 * This method is used to insert or modify the data of user
	 * insert or modify data based on user id
	 * Table used uls_user_creation,uls_user_role,uls_menu
    */
    public function lms_usercreation(){
		//echo "<pre>";
		//print_r($_POST);
		$flg=0;
        if(isset($_POST['user_id'])){
            $fieldinsertupdates=array('employee_id','user_name','password','password_validity_days','email_address','user_type');
            $datefields=array('start_date','end_date');
            $usercreation=!empty($_POST['user_id'])? Doctrine_Core::getTable('UlsUserCreation')->find($_POST['user_id']):new UlsUserCreation();
            try {
				foreach($fieldinsertupdates as $val){$usercreation->$val=!empty($_POST[$val])?$_POST[$val]:NULL;}
				foreach($datefields as $val){$usercreation->$val=(!empty($_POST[$val]))?date("Y-m-d", strtotime($_POST[$val])):NULL;}
			//	empty($_POST['user_id'])?$this->session->userdata('parent_org_id',$usercreation->parent_org_id):"";
				$usercreation->parent_org_id=$_POST['org_id'];
				$usercreation->save();

				$fieldinsertupdates2=array('role_id','description');
				$datefields2=array('start_date'=>'startdate','end_date'=>'enddate');

				foreach($_POST['description'] as $key=>$act){
					if(!empty($_POST['role_id'][$key])){
						$usercreation1=!empty($_POST['user_role_id'][$key])? Doctrine_Core::getTable('UlsUserRole')->find($_POST['user_role_id'][$key]):new UlsUserRole();
						try {
							$usercreation1->user_id=$usercreation->user_id;
							foreach($fieldinsertupdates2 as $val2){$usercreation1->$val2=$_POST[$val2][$key];}
							foreach($datefields2 as $key2=>$val2){$usercreation1->$key2=(!empty($_POST[$val2][$key]))?date("Y-m-d", strtotime($_POST[$val2][$key])):NULL;}
							$usercreation1->menu_id=isset($_POST['chk'][$key]) ? implode(",",$_POST['chk'][$key]) : $_POST['menuid'][$key];
							$usercreation1->save();
						}
						catch(Doctrine_Validator_Exception $e) {
							$orguserErrors = $usercreation1->getErrorStack();
							foreach($orguserErrors as $fieldName => $errorCodes) {
								echo $fieldName . " - " . implode(', ', $errorCodes) . "\n";
							}
							echo $msg=$usercreation1->getErrorStackAsString();
							$flg=1;
						}

					}
				}
			}
			catch(Doctrine_Validator_Exception $e) {
				$userErrors = $usercreation->getErrorStack();
				foreach($userErrors as $fieldName => $errorCodes) {
					echo $fieldName . " - " . implode(', ', $errorCodes) . "\n";
				}
				echo $msg= $usercreation->getErrorStackAsString();
				$flg=1;
			}
        }
		if($flg==0){
			redirect("admin/user_creation");
		}
		else{
			$this->session->set_flashdata('message',$msg);
			redirect("admin/create_user");
		}
    }

	/*
     * Created by Srikanth Modified by Srikanth empmail
	 * This method is used has ajax function to get email and date of join of the employee
	 * Based on employee id
	 * Table used uls_employee_master
    */
    public function empmail(){
		$id=$_REQUEST['id'];
		!empty($id)? $empid=Doctrine_Core::getTable('UlsEmployeeMaster')->findOneByEmployeeId($id):"";
		$email=isset($empid->email)?$empid->email:"";
		$email2=isset($empid->email)?  "readonly":"";
		$date=isset($empid->date_of_joining)? date('d-m-Y',strtotime($empid->date_of_joining)):"";
		echo "<input type='text'  name='email_address'  class='validate[required,custom[email],ajax[ajaxUseremail]] form-control' id='email_address' value='".$email."' $email2> <input type='hidden' name='doj' id='doj' value='".$date."'>";
    }


	/*
     * Created by Srikanth Modified by Srikanth user_view
	 * This method is used view user details
	 * Based on user id
	 * Table used uls_user_creation
    */
    public function user_view(){
		$data["aboutpage"]=$this->pagedetails('admin','user_view');
        $id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=((md5(SECRET.$id)!=$hash)?1:0);
        if($flag==1){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
            $data['userdetails']=UlsUserCreation::viewuser($id);
			$content = $this->load->view('admin/lms_admin_user_view',$data,true);
		}
		$this->render('layouts/adminnew',$content);
    }

	/*
     * Modified by Srikanth master_home
	 * This method is used to get Master code and value
	 * based on filters like PerPage and Master Code default all are shown
	 * Table used uls_admin_master
    */
    public function master_home(){
        $data["aboutpage"]=$this->pagedetails('admin','master_home');
        $limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
        $page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
		$master_code=filter_input(INPUT_GET,'master_code') ? filter_input(INPUT_GET,'master_code'):"";
        $start=$page!=0? ($page-1)*$limit:0;
        $filePath=BASE_URL."/admin/master_home";
        $data['limit']=$limit;
        $data['perpages']=UlsMenuCreation::perpage();
		$data['master_code']=$master_code;
        $data['masterlists']=UlsAdminMaster::search($start, $limit,$master_code);
        $total=UlsAdminMaster::searchcount($master_code);
        $otherParams="&perpage=".$limit."&master_code=".$master_code;
		$data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/lms_admin_master_home',$data,true);
		$this->render('layouts/adminnew',$content);
    }

	/*
     * Created by Nagaraj Modified by Srikanth masters
	 * This method is used to create or modify Master code and Master value
	 * Based on the id it will  create or modify the Master code and values
	 * Table used uls_admin_master,uls_admin_values
    */
    public function masters(){
		$data["aboutpage"]=$this->pagedetails('admin','masters_creation');
        $id=filter_input(INPUT_GET,'master_id') ? filter_input(INPUT_GET,'master_id'):"";
        $hash=filter_input(INPUT_GET,'hash') ? filter_input(INPUT_GET,'hash'):"";
        $menutype=!empty($id)? UlsMenuCreation::menutype($id):"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
            $data['viewmaster']=UlsAdminMaster::view_masters();
			$content = $this->load->view('admin/lms_admin_master',$data,true);
        }
		$this->render('layouts/adminnew',$content);
    }

	 /*
     * Created by Nagaraj list_of_values
	 * This method is used insert or update the master code and values
	 * Based on the id (if id is empty insert else update)
	 * Table used uls_admin_master,uls_admin_values
    */
    public function list_of_values(){
        if(isset($_POST['master_code'])){
            $mastecode=$_POST['master_code'];
            $fieldinsert=array('master_title'=>'master_title', 'description'=>'master_desc');
            $masters=!empty($_POST['master_id'])?$mastercode=Doctrine::getTable('UlsAdminMaster')->find($_POST['master_id']):new UlsAdminMaster();
            foreach($fieldinsert as $key=>$post_val){
                $masters->master_code=strtoupper($mastecode);
                $masters->$key=$_POST[$post_val];
            }
            $masters->save();
            $mastercode=$masters->master_code;
            $masterid=$masters->master_id;
            $hash=SECRET.$masterid;

            $valdates=array('start_date'=>'stdate', 'end_date'=>'enddate');
            foreach($_POST['code'] as $key=>$code){
                $master_value=!empty($_POST['value_id'][$key])?Doctrine::getTable('UlsAdminValues')->find($_POST['value_id'][$key]): new UlsAdminValues();
                $master_value->master_code=$masters->master_code;
               foreach($valdates as $key2=>$val_dates){
                    $master_value->value_code=strtoupper($code);
                    $master_value->value_name=$_POST['value'][$key];
                    $master_value->$key2=(!empty($_POST[$val_dates][$key]))?date('y-m-d',strtotime($_POST[$val_dates][$key])):NULL;
                }
                $master_value->save();
            }
			redirect("admin/view_masters?message&master_id=".$masterid."&hash=".md5($hash));
			$this->session->set_flashdata('message_list',"Application Master data ".(!empty($_POST['master_id'])?"updated":"inserted")." successfully.");
        }
        else{
			redirect("admin/masters");
        }
    }

	public function view_masters(){
        $this->sessionexist();
        $data["aboutpage"]=$this->pagedetails('admin','view_masters');
        $id=filter_input(INPUT_GET,'master_id') ? filter_input(INPUT_GET,'master_id'):"";
        $hash=filter_input(INPUT_GET,'hash') ? filter_input(INPUT_GET,'hash'):"";
        $menutype=!empty($id)? UlsMenuCreation::menutype($id):"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
            $data['viewmaster']=UlsAdminMaster::view_masters();
			$content = $this->load->view('admin/lms_admin_master_view',$data,true);
        }
		$this->render('layouts/adminnew',$content);
    }


	 /*
     * Created by Nagaraj deletemastervalue
	 * This method is used to delete master value
	 * Based on the value_code
	 * Table used uls_admin_values
    */
    public function deletemastervalue(){
        $code=$_REQUEST['val'];
        $q =!empty($code)? Doctrine_Query::create()->delete('UlsAdminValues')->where('value_code=?',$code)->execute():"";
    }

	 /*
     * Modified by Prasad Malla notificationsearch
	 * This method is used to check the notification search
	 * based on filter name and status
	 * Table used uls_notification,uls_admin_master
    */
	public function notificationsearch(){
		$data["aboutpage"]=$this->pagedetails("admin","notification");
		if($_SESSION['parent_org_id']==1){
			$data['notification']=UlsNotification::get_notifications();
			$data['orgs']=UlsOrganizationMaster::parent_orgs();
			$limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
			$org_id=filter_input(INPUT_GET,'org_id') ? filter_input(INPUT_GET,'org_id'):"";
			$page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
			$start=$page!=0? ($page-1)*$limit:0;
			$filePath=BASE_URL."/admin/notificationsearch";
			$data['limit']=$limit;
			$data['org_id']=$org_id;
			$data['perpages']=UlsMenuCreation::perpage();
			$data['notificdetails']=UlsNotification::search($start,$limit,$org_id);
			$total=UlsNotification::searchcount($org_id);
			$otherParams="perpage=".$limit."&org_id=$org_id";
			$data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
			$content = $this->load->view('admin/lms_admin_notification_search',$data,true);

		}
		else{
			$data['orgs']=UlsOrganizationMaster::parent_orgs();
			$limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
			$org_id=filter_input(INPUT_GET,'org_id') ? filter_input(INPUT_GET,'org_id'):"";
			$page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
			$start=$page!=0? ($page-1)*$limit:0;
			$filePath=BASE_URL."/admin/notificationsearch";
			$data['limit']=$limit;
			$data['org_id']=$org_id;
			$data['perpages']=UlsMenuCreation::perpage();
			$data['notificdetails']=UlsNotificationTypes::search($start,$limit);
			$total=UlsNotificationTypes::searchcount();
			$otherParams="perpage=".$limit."&org_id=$org_id";
			$data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
			$content = $this->load->view('admin/lms_admin_notification_search_org',$data,true);
		}
	$this->render('layouts/adminnew',$content);
	}

	/*
     * Modified by Prasad Malla notification
	 * This method is used insert or modify notifications
	 * Table used uls_notification
    */
	public function notification(){
		$data["aboutpage"]=$this->pagedetails("admin","notification");
        $nval="STATUS";
		$data['status']=UlsAdminMaster::get_value_names($nval);
		$nval="NOTIFY_TYPE";
		$data['type']=UlsAdminMaster::get_value_names($nval);
		$data['parentorgs']=UlsOrganizationMaster::parent_orgs();
		$id= filter_input(INPUT_GET,'id')?filter_input(INPUT_GET,'id'):"";
		$hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
		$flag=((md5(SECRET.$id)!=$hash)?1:0);
		if($flag==1 && !empty($id)){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			if(!empty($id)){
				$data['notification']=UlsNotification::get_notification_details($id);
				$data['notificationhistory']=UlsNotification::get_notificationhistory_details($id);
			}
			if($this->session->userdata('parent_org_id')==1){
				$content = $this->load->view('admin/lms_admin_notification',$data,true);
		    }
			else{
				$data['notification']=UlsNotificationTypes::getnotification($_REQUEST['id']);
				$data['notificationtype']=UlsNotificationTypes::getnotificationtypes();
				$content = $this->load->view('admin/lms_admin_notification_org',$data,true);
			}
		}
	$this->render('layouts/adminnew',$content);
	}

	 /*
     * Modified by Prasad
	 * This method is used to All employee details under the parent organization.
	 * Table used uuls_organization_master,uls_employee_master,uls_employee_work_info,uls_grade,uls_position.
    */
	public function getempdata(){
		$gp=$_REQUEST['group'];
		$bus=$_REQUEST['bus'];
		if($gp=='B'){ $val='B'; $name="Both";}
		else if($gp=='S'){$val='S'; $name="System" ;}
		$loc=$_REQUEST['loc'];
		$org=$_REQUEST['org'];
		$hier=$_REQUEST['hierar'];
		$grad=$_REQUEST['grad'];
		$emptyp=$_REQUEST['emptype'];
		$post=$_REQUEST['post'];
		// Get chaild org code
		$org=$_REQUEST['org'];
		$hier=$_REQUEST['hierar'];
		if($hier==''){  $hierarchy=$_REQUEST['org'];}
		else if($hier!=''){
			global $asd;
			UlsOrganizationMaster::getchildorgsdata_hierarchy($org,$hier);
			//$hierarchy=$asd;
			//echo "***********".$asd."*************";
			$asd=$asd.",".$org;
			$hierarchy=$asd;
		}
		$addgpval='';
		echo " <div id='buttonstable' align='left'><div id='addbuttondiv'style='width:80px; float:left;' ><input  id='add' class='btn btn-sm btn-success' type='button' onClick='addfun()' value='Add' name='addrow'></div><div id='deletediv' style='width:100px; float:left;'><input id='delete' class='btn btn-sm btn-danger' type='button' onclick='deletefun()' value='Delete' name='delete'></div></div><br /><br /><table class='table table-striped table-bordered table-hover' id='newtableid' style='width:1082px; margin-bottom:0px;'><thead><tr ><th style='width:49px;'><input type='checkbox' id='checkall'>Select</th><th style='width:113px;'>Employee Number</th><th  style='width:170px;'>Employee Name</th><th  style='width:159px;'>Organization</th><th style='width:110px;'>Grade</th><th style='width:139px;'>Group Option</th></tr></thead></table> <div style='overflow:auto; height:203px; width: 1100px;'>
		<table id='emptable' class='table table-striped table-bordered table-hover' style='width:1082px; margin-top:0px;'> ";
		$empdata=UlsEmployeeWorkInfo::get_emp_data($loc,$hierarchy,$grad,$emptyp,$post,$bus);
		if(!empty($empdata)){
			foreach($empdata as  $key=>$empdatas){
				//  echo $empdatas['enumber']; echo "<br /.";
				$key1=$key+1;
				if($addgpval==''){ $addgpval=$key1; }
				else{
					$addgpval=$addgpval.','.$key1;
				}
				echo "<tr><td style='text-align:center; width:77px;'><input type='checkbox' class='chkall' name='chkbox[]'  style='margin-left:10px;' id='chkbox[".$key1."]' value='".$key1."' /></td><td style='width:156px;'><input type='text' name='empno[]' id='empno[".$key1."]' style='width:85%;' value='".$empdatas['enumber']."' readonly /></td><td style='width:236px;'><input type='text' name='empval[]' id='empval[".$key1."]' style='width:90%;' value='".$empdatas['name']."' readonly /></td><td style='width:221px;'><input type='text' name='emporg[]' id='emporg[".$key1."]' value='".$empdatas['org_name']."' style='width:90%;' readonly /></td><td style='width:153px;'><input type='text' name='empgrade[]' id='empgrade[".$key1."]' style='width:85%;' value='".$empdatas['gid']."' readonly /></td><td style='width:191px;'><select id='gpoption[".$key1."]' name='gpoption[]'style='width:85%' disabled='disabled'><option value='".$val."'>".$name."</option></select></td></tr>";
			}
		}
		else{
			echo "<tr style='border: 1px solid #FFFFFF; margin-left:20px;'><td class='border' style='text-align:center;' colspan='5'>No data found.</td></tr>";
		}
		echo "</table></div>";
		// echo "addgrop val=".$addgpval; echo "haiiii";
		echo "<input type='hidden' id='addgroup' name='addgroup' value=".trim($addgpval)." >";
	}

	public function getnotificationusers(){
		$nid=$_REQUEST['nid'];
		$type=$_REQUEST['type'];
		$status=$_REQUEST['status'];
		$notification=UlsNotification::get_notifications_users($nid,$status,$type);
		echo "<div id='employeesdetails'>"
			. "<table class='bordered' width='100%' ><tr><th width='20%'>Notification Name</th>"
			. "<th width='10%'>Notification Status</th><th width='10%'>Type</th><th width='10%'>View</th><th width='10%'>Edit</th><th width='10%'>Delete</th></tr></table>";
		echo "<div style='overflow-y:auto; overflow-x:hidden; margin-top:-5px; height:203px;'>
	   <table class='bordered' width='100%' >";
		if(count($notification)>0){
			foreach($notification as $key=>$notifications){
				$hash=SECRET.$notifications['notification_id'];
				$notificatonstatus=$notifications['status']=='A'?'Active':'Inactive';
				$types=$notifications['type']=='E'?'Event':'Periodic';
				echo "<tr id='delrow_".$key."'><td width='20%'>".$notifications['notification_name']."</td><td width='10%'>".$notificatonstatus."</td><td width='10%'>".$types."</td>"
				. "<td width='10%' class='centerside'><a href='".BASE_URL."/admin/notificatio_view?id=".$notifications['notification_id']."&hash=".md5($hash)."'>
<img src='".BASE_URL."/public/images/view.gif'></a></td>"
				. "<td width='10%' class='centerside'><a href='".BASE_URL."/admin/notificatio_edit?id=".$notifications['notification_id']."&hash=".md5($hash)."'>
				<img src='".BASE_URL."/public/images/edit.gif'></a></td>"
				. "<td width='10%' class='centerside'>
				<img onclick=\"delete_notify(".$notifications['notification_id'].",'delete_notification','delrow_".$key."')\" style='cursor:pointer; padding-left: 25px;' src='".BASE_URL."/public/images/delete.gif'></td></tr>";
			}
		}
		else{ echo "<tr><td colspan='5' >Notifications are Not available.</td></tr> "; }
		echo "</table></div></div>";
    }

	public function getmailcontent(){
		$nid=$_REQUEST['nid'];
		$time=$_REQUEST['time'];
		// $sd=Doctrine_Core::getTable('UlsNotificationHistory')->findOneByMail_delivey_time($time);
		$sd=Doctrine_Query::create()->from('UlsNotificationHistory')->where("Notification_id=".$nid." and mail_delivey_time='".$time."'")->execute();
		foreach($sd as $sds){
			$subject=$sds['subject']; $mailcontent=$sds['mail_content'];
		}
		echo "<b>Subject :</b>".$subject; echo "<br />";
		echo $mailcontent;
	}

	public function getparameters(){
		$nid=$_REQUEST['ntid'];
		if($nid!=''){
			$template=Doctrine_Core::getTable('UlsNotificationTypes')->find($nid);
			
			$sd=Doctrine_Query::create()->from('UlsNotificationParameters')->where("Notification_typeid='".$nid."'")->execute();
			if(count($sd)>0){
				$content1="<option value=''>Select</option>";
				foreach($sd as $sds){
					$content1.="<option value='#".$sds['notification_paramatercode']."#'>".$sds['notification_paramatername']."</option>";
				  }
			}
			else{
				$content1="";
			}
			$content2="";
			$base=BASE_URL;
			$content2 =$this->readTemplateFile($template['template_path']);
			$content2 = str_replace("#BASE_URL#",$base,$content2);
			echo $data=$content1."####".$content2;
		}
		else {
			echo " ";
		}
	}

	public function notification_insert(){
		if(isset($_POST['notification_name'])){
			$porgid=$this->session->userdata('parent_org_id')==1?$_POST['porg']:$this->session->userdata('parent_org_id');
			//echo "heleo"; porg
			$insert_val=array('notification_name'=>'notification_name', 'comments'=>'mailcontent', 'status'=>'status','event_type'=>'system_notification','mail_to'=>'users','mail_cc'=>'manager');
			$notificationdata=(!empty($_POST['notification_id']))?Doctrine::getTable('UlsNotification')->find($_POST['notification_id']):new UlsNotification;
			foreach($insert_val as $key=>$notificationdata_val){
				$notificationdata->$key=$_POST[$notificationdata_val];
			}
			$histor=0;
			$notifytype=@explode("-",$_POST['notification_type']);
			if(isset($_POST['history'])){
				$histor=(!empty($_POST['history'])) ? $_POST['history']:0;
			}
			$notificationdata->parent_org_id=$porgid;
			$notificationdata->history=$histor;
			$notificationdata->type=isset($_POST['notification_type'])?$notifytype[0]:'';
			$notificationdata->notification_time=isset($_POST['ptime'])?!empty($_POST['ptime'])?$_POST['ptime'] : NULL : NULL;
			$notificationdata->time_units=isset($_POST['units'])?!empty($_POST['units'])?$_POST['units'] : NULL : NULL;
			$notificationdata->save();
			redirect("admin/notificationsearch");
		}
	}

	/*
     * Modified by Prasad Malla notificatio_view
	 * This method is used insert or modify notifications
	 * Table used uls_notification
    */
	public function notificatio_view(){
		$data["aboutpage"]=$this->pagedetails("admin","notification");
		$id=filter_input(INPUT_GET,'id') ? filter_input(INPUT_GET,'id'):"";
		$hash=filter_input(INPUT_GET,'hash') ? filter_input(INPUT_GET,'hash'):"";
		$flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
		if($flag==1  || $id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$id=$_REQUEST['id'];
			$data['notification']=UlsNotification::get_notification_details_forview($id);
			$data['notificationhistory']=UlsNotification::get_notificationhistory_details($id);
			$nval="NOTIFY_TYPE";
			$data['type']=UlsAdminMaster::get_value_names($nval);
			$nval="STATUS";
			$data['status']=UlsAdminMaster::get_value_names($nval);
			$data['parentorgs']=UlsOrganizationMaster::parent_orgs();
			$content = $this->load->view('admin/lms_admin_notification_view',$data,true);
		}
		$this->render('layouts/adminnew',$content);
	}

	public function delete_notification(){
		if(!empty($_REQUEST['val'])){
			$q1=Doctrine_Query::Create()->delete('UlsNotificationHistory')->where('notification_id='.$_REQUEST['val'])->execute();
			$q = Doctrine_Query::create()->delete('UlsNotification  t')->where("t.notification_id=".$_REQUEST['val']);
			$q->execute();
			echo 1;
		}
		else{
			echo "Selected Notification cannot be deleted. Ensure you delete all the usages of the Notification before you delete it.";
		}
	}

	//Function is used to search for security profiles available
	public function security_search(){
        $data["aboutpage"]=$this->pagedetails('admin','security_profile');
        $limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
        $prf_name=filter_input(INPUT_GET,'prf_name') ? filter_input(INPUT_GET,'prf_name'):"";
        $page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
        $start=$page!=0? ($page-1)*$limit:0;
        $filePath=BASE_URL."/admin/security_search";
        $data['limit']=$limit;
        $data['prf_name']=$prf_name;
        $data['perpages']=UlsMenuCreation::perpage();
        $data['prfdetails']=UlsSecurityProfile::search($start, $limit,$prf_name);
        $total=UlsSecurityProfile::searchcount($prf_name);
        $otherParams="perpage=".$limit."&prf_name=".$prf_name;
        $data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/lms_admin_security_profile_search',$data,true);
		$this->render('layouts/adminnew',$content);
    }

	// Function to call security profile page
	public function security_profile(){
		$data["aboutpage"]=$this->pagedetails('admin','security_profile');
        $grade_status="STATUS";
        $data['parent_orgs']=UlsOrganizationMaster::parent_orgs();
        $data['gradestatus']=UlsAdminMaster::get_value_names($grade_status);
		$data['last_record']=UlsSecurityProfile::lastRecord();
		$content = $this->load->view('admin/lms_admin_security_profile',$data,true);
		$this->render('layouts/adminnew',$content);
	}

	//Function to all locations based on parent org id
	public function fetch_locations(){
		$locations=UlsLocation::get_locations($_REQUEST['porg_id']);
		if(count($locations)>0){
			echo "<option value=''>Select</option>";
			foreach($locations as $location){
				echo "<option value=".$location->location_id.">".$location->location_name."</option>";
			}
		}else{
			echo "<option value=''>Select</option>";
		}
	}

	//Function to get hierarchy names and organization names based on parent org id
	public function fetch_hierarchies(){
		$hier=UlsHeirarchyMaster::hierarchynames($_REQUEST['orgid']);
		if(count($hier)>0){
			echo "<option value=''>Select</option>";
			foreach($hier as $hiers){
				echo "<option value=".$hiers['hierarchy_id'].">".$hiers['hierarchy_name']."</option>";
			}
		}else{
			echo "<option value=''>Select</option>";
		}
		$org_names=UlsOrganizationMaster::orgNames($_REQUEST['orgid']);
		if(count($org_names)>0){
			echo "#@<option value=''>Select</option>";
			foreach($org_names as $org_name){
				echo "<option value=".$org_name['id'].">".$org_name['name']."</option>";
			}
		}else{
			echo "#@<option value=''>Select</option>";
		}
	}

	//Function to insert and update security details data
	public function security_details(){
		if(isset($_POST['profile_name'])){
			$profile=array('profile_name','parent_org_id','status');
			$profile_details=(!empty($_POST['secure_profile_id']))?Doctrine::getTable('UlsSecurityProfile')->find($_POST['secure_profile_id']):new UlsSecurityProfile;
			foreach($profile as $profiles){
                $profile_details->$profiles=(!empty($_POST[$profiles]))?$_POST[$profiles]:NULL;
            }
			$profile_details->save();
			$secure=$profile_details->secure_profile_id;
			if(!empty($_POST['sec_type'])){
				$hier=array('security_type'=>'sec_type','hierarchy_id'=>'hier_name','top_organization'=>'top_org');
				$hier_det=(!empty($_POST['secure_hierarchy_id']))?Doctrine::getTable('UlsSecurityHierarchy')->find($_POST['secure_hierarchy_id']):new UlsSecurityHierarchy;
				$hier_det->secure_profile_id=$secure;
				foreach($hier as $key=>$hiers){
					$hier_det->$key=(!empty($_POST[$hiers]))?$_POST[$hiers]:NULL;
				}
				$hier_det->save();
				foreach($_POST['orgname'] as $key=>$orgs){
					if(!empty($orgs)){
						$org_det=(!empty($_POST['secure_org_id'][$key]))?Doctrine::getTable('UlsSecurityOrg')->find($_POST['secure_org_id'][$key]):new UlsSecurityOrg;
						$org_det->secure_profile_id=$secure;
						$org_det->secure_hierarchy_id=$hier_det->secure_hierarchy_id;
						$org_det->organization_id=$orgs;
						$org_det->save();
					}
				}
			}
			foreach($_POST['location'] as $key=>$locs){
				if(!empty($locs)){
					$loc_det=(!empty($_POST['secure_location_id'][$key]))?Doctrine::getTable('UlsSecurityLocation')->find($_POST['secure_location_id'][$key]):new UlsSecurityLocation;
					$loc_det->secure_profile_id=$secure;
					$loc_det->location_id=$locs;
					$loc_det->save();
				}
			}
			redirect("admin/security_profile?secure_id=".$secure);
		}
		else{
			$content = $this->load->view('admin/security_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
	}

	public function dashboard(){
		//print_r($_SESSION);
		$data=array();
		$data["aboutpage"]=$this->pagedetails('admin','dashboard');
		$data['emp_types']=UlsAdminMaster::get_value_names("POSTYPE");
		if(isset($_REQUEST['emp_type'])){
			$this->session->set_userdata('emp_type',$_REQUEST['emp_type']);
		}
		$emp_type=isset($_SESSION['emp_type'])?$_SESSION['emp_type']:"";
		$data['emp_type']=$emp_type;
		$sq=$sq2=$sq3=$sq4=$sq5="";
		if(!empty($emp_type)){
			$sq=" and a.position_type='$emp_type'";
			$sq2=" and position_type='$emp_type'";
			$sq3=" and competency_type='$emp_type'";
			$sq4=" and a.competency_type='$emp_type'";
			$sq5=" and a.assessment_cycle_type='$emp_type'";
		}
		
		$org=$this->session->userdata('security_org_id');
		$possq="";$possq2="";$comps="";$comps2="";
		if($_SESSION['security_type']=='no'){
			$possq="";$possq2="";$comps="";$comps2="";
		}
		elseif(!empty($org)){
			$comps=" and bu_id in (SELECT `organization_id` FROM `uls_organization_master` WHERE `division_id` in ($org) or `organization_id` in ($org))";
			$comps2=" and bu_id in (SELECT `organization_id` FROM `uls_organization_master` WHERE `division_id` in ($org) or `organization_id` in ($org))";
			$possq=" and a.bu_id in (SELECT `organization_id` FROM `uls_organization_master` WHERE `division_id` in ($org) or `organization_id` in ($org))";
			$possq2=" and bu_id in (SELECT `organization_id` FROM `uls_organization_master` WHERE `division_id` in ($org) or `organization_id` in ($org))";
			if($_SESSION['parent_org_id']==$org){
				
				$locs=explode(",",$_SESSION['security_location_id']);
				$possq=" and (";
				$possq2=" and (";
				foreach($locs as $loc){
					$possq.="find_in_set($loc,a.`location_id`)";
					$possq2.="find_in_set($loc,`location_id`)";
				}
				$possq.=")";
				$possq2.=")";
				$sqbus="";
				$buss=UlsMenu::callpdo("SELECT distinct(`bu_id`) as buid  FROM `uls_location` WHERE `location_id` in (".$_SESSION['security_location_id'].")");
				foreach($buss as $k=>$bus2){
					if(empty($sqbus)){
						$sqbus.=" WHERE `division_id` in (".$bus2['buid'].") or `organization_id` in (".$bus2['buid'].")";
					}
					else{
						$sqbus.=" or `division_id` in (".$bus2['buid'].") or `organization_id` in (".$bus2['buid'].")";
					}
				}
				if(!empty($sqbus)){
					$comps=" and bu_id in (SELECT `organization_id` FROM `uls_organization_master` $sqbus)";
					$comps2=" and a.bu_id in (SELECT `organization_id` FROM `uls_organization_master` $sqbus)";
				}
			}
		}
		//and position_structure='S'
		$data["positiondet"]=UlsMenu::callpdorow("SELECT count(*) as total,b.incomplete FROM `uls_position` a left join (select count(*) as incomplete,parent_org_id from uls_position where `position_desc` is not null $sq2 $possq2 and `parent_org_id`=".$_SESSION['parent_org_id']."  group by parent_org_id)b on a.parent_org_id=b.parent_org_id WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.position_structure='S'".$sq.$possq);
		//and position_structure='S' 
		$data["competenctprofile"]=UlsMenu::callpdorow("SELECT count(distinct(`comp_position_id`)) as total FROM `uls_competency_position_requirements` WHERE `comp_position_id` in (SELECT position_id FROM `uls_position` WHERE `parent_org_id`=".$_SESSION['parent_org_id']."  $sq2 $possq2 ) ORDER BY `comp_position_id` DESC ");
		//and comp_structure='S'
		$data["competencies"]=UlsMenu::callpdorow("SELECT count(*) as total FROM `uls_competency_definition`  WHERE `parent_org_id`=".$_SESSION['parent_org_id']." ".$sq3.$comps);
		
		if(!empty($sq3)){
			//and comp_structure='S'
			$data["competency"]=UlsMenu::callpdo("SELECT comp_def_id as id, comp_def_name as name FROM `uls_competency_definition` WHERE `parent_org_id`=".$_SESSION['parent_org_id']."  $sq3 $comps order by comp_def_name asc");
		}
		else{
			$data['competencymsdetails']=UlsCompetencyDefinition::competency_dashdetails("MS",$comps2);
			$data['competencynmsdetails']=UlsCompetencyDefinition::competency_dashdetails("NMS",$comps2);
		}
		//and comp_structure='S'
		$data["compincomp"]=UlsMenu::callpdorow("SELECT count(*) as total FROM `uls_competency_definition` WHERE `parent_org_id`=".$_SESSION['parent_org_id']."  and `comp_def_id` not in (SELECT distinct(`comp_def_id`) FROM `uls_competency_def_level_indicator` WHERE `parent_org_id`=".$_SESSION['parent_org_id']." ) $sq3 $comps");
		//and a.comp_structure='S'
		$data['graphs']=UlsMenu::callpdo("SELECT count(*) as tot,a.`comp_def_category`,b.name,group_concat(a.`comp_def_id`),c.total FROM `uls_competency_definition` a inner join (SELECT * FROM `uls_category` )b on b.`category_id`=a.comp_def_category left join(SELECT count(*) as total,`comp_def_category` FROM `uls_competency_definition` WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and comp_structure='S' and `comp_def_id` not in (SELECT distinct(`comp_def_id`) FROM `uls_competency_def_level_indicator` WHERE `parent_org_id`=".$_SESSION['parent_org_id'].") $sq3 $comps group by `comp_def_category`)c on c.`comp_def_category`=a.comp_def_category WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']."  $sq4 $comps2 group by a.`comp_def_category` ");
		
		$data['assessors_ext']=UlsMenu::callpdo("SELECT b.`assessor_id`,b.`assessor_name`,b.assessor_email,b.assessor_type FROM `uls_assessment_position_assessor` a 
		left join(SELECT `assessor_id`,`assessor_name`,assessor_email,assessor_type FROM `uls_assessor_master`) b on a.assessor_id=b.assessor_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.`assessor_type`='EXT' group by a.`assessor_id`");
		
		$data['assessors_int']=UlsMenu::callpdo("SELECT c.employee_id,c.`employee_number`,c.`full_name`,c.`email`,b.assessor_type,b.assessor_id FROM `uls_assessment_position_assessor` a 
		left join(SELECT `assessor_id`,`assessor_name`,assessor_email,assessor_type,employee_id FROM `uls_assessor_master`) b on a.assessor_id=b.assessor_id
		left join(SELECT `employee_id`,`employee_number`,`full_name`,`email` FROM `employee_data`) c on c.employee_id=b.employee_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.`assessor_type`='INT' group by a.`assessor_id`");
		
		$loc=$this->session->userdata('security_location_id');
		$losq="";
		if(!empty($loc)){
			$losq=" and (a.location_id in (".$loc.") )";
		}
		
		$data['assessments']=UlsMenu::callpdo("SELECT c.employees,b.positions,d.ass_emp,b.pos_id,a.* FROM `uls_assessment_definition` a 
		left join(select count(*) as positions,assessment_id,group_concat(position_id) as pos_id from `uls_assessment_position` group by `assessment_id` )b on a.`assessment_id`=b.`assessment_id`
		left join(select count(*) as employees,assessment_id from `uls_assessment_employees` group by `assessment_id` )c on a.`assessment_id`=c.`assessment_id`
		left join(SELECT count(DISTINCT `employee_id`) as ass_emp,assessment_id  FROM `uls_assessment_report_final` group by `assessment_id`) d on a.`assessment_id`=d.`assessment_id`
		WHERE 1 and a.`parent_org_id`=".$_SESSION['parent_org_id']." $sq5 $losq order by assessment_id desc");
		
		$data["questionbanks"]=UlsMenu::callpdorow("SELECT b.mcq,c.cases,d.inbasket,e.interview FROM `uls_questionbank` a left join ( SELECT count(*) as mcq,`parent_org_id` FROM `uls_questionbank` WHERE `type`='COMP_TEST' and comp_def_id in (SELECT comp_def_id FROM `uls_competency_definition` WHERE `parent_org_id`=".$_SESSION['parent_org_id'].$sq3." $comps) group by `parent_org_id` )b on a.`parent_org_id`=b.`parent_org_id` left join ( SELECT count(*) as cases,`parent_org_id` FROM `uls_questionbank` WHERE `type`='COMP_CASESTUDY' and comp_def_id in (SELECT comp_def_id FROM `uls_competency_definition` WHERE `parent_org_id`=".$_SESSION['parent_org_id'].$sq3." $comps) group by `parent_org_id` )c on a.`parent_org_id`=c.`parent_org_id` left join ( SELECT count(*) as inbasket,`parent_org_id` FROM `uls_questionbank` WHERE `type`='COMP_INBASKET' and comp_def_id in (SELECT comp_def_id FROM `uls_competency_definition` WHERE `parent_org_id`=".$_SESSION['parent_org_id'].$sq3." $comps) group by `parent_org_id` )d on a.`parent_org_id`=d.`parent_org_id` left join ( SELECT count(*) as interview,`parent_org_id` FROM `uls_questionbank` WHERE `type`='COMP_INTERVIEW' and comp_def_id in (SELECT comp_def_id FROM `uls_competency_definition` WHERE `parent_org_id`=".$_SESSION['parent_org_id'].$sq3." $comps) group by `parent_org_id` )e on a.`parent_org_id`=e.`parent_org_id` WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." group by a.`parent_org_id`");
		
		$data["questions"]=UlsMenu::callpdorow("SELECT (SELECT count(*) as mcq FROM `uls_questions` WHERE `question_bank_id` in (SELECT `question_bank_id` FROM `uls_questionbank` WHERE `type`='COMP_TEST' and comp_def_id in (SELECT comp_def_id FROM `uls_competency_definition` WHERE `parent_org_id`=".$_SESSION['parent_org_id'].$sq3." $comps) and `parent_org_id`=".$_SESSION['parent_org_id'].")) as mcq, (SELECT count(*) as mcq FROM `uls_questions` WHERE `question_bank_id` in (SELECT `question_bank_id` FROM `uls_questionbank` WHERE `type`='COMP_CASESTUDY' and comp_def_id in (SELECT comp_def_id FROM `uls_competency_definition` WHERE `parent_org_id`=".$_SESSION['parent_org_id'].$sq3." $comps)  and `parent_org_id`=".$_SESSION['parent_org_id'].")) as cases, (SELECT count(*) as mcq FROM `uls_questions` WHERE `question_bank_id` in (SELECT `question_bank_id` FROM `uls_questionbank` WHERE `type`='COMP_INBASKET' and comp_def_id in (SELECT comp_def_id FROM `uls_competency_definition` WHERE `parent_org_id`=".$_SESSION['parent_org_id'].$sq3.") and `parent_org_id`=".$_SESSION['parent_org_id'].")) as inbasket, (SELECT count(*) as mcq FROM `uls_questions` WHERE `question_bank_id` in (SELECT `question_bank_id` FROM `uls_questionbank` WHERE `type`='COMP_INTERVIEW' and comp_def_id in (SELECT comp_def_id FROM `uls_competency_definition` WHERE `parent_org_id`=".$_SESSION['parent_org_id'].$sq3." $comps) and `parent_org_id`=".$_SESSION['parent_org_id'].")) as interview ");
		
		$data['questionbanks_inbasket']=UlsMenu::callpdorow("SELECT count(distinct(a.`question_id`)) as q_bank,a.comp_def_id FROM `uls_question_values` a WHERE a.comp_def_id in (SELECT comp_def_id FROM `uls_competency_definition` WHERE `parent_org_id`=".$_SESSION['parent_org_id'].$sq3." $comps)");
		
		$data['question_inbasket']=UlsMenu::callpdorow("SELECT count(a.`question_id`) as ques FROM `uls_question_values` a WHERE a.comp_def_id in (SELECT comp_def_id FROM `uls_competency_definition` WHERE `parent_org_id`=".$_SESSION['parent_org_id'].$sq3." $comps)");
		//and position_structure='S'
		$data["position_info"]=UlsMenu::callpdo("SELECT g.value_name as position_type,a.position_id,a.position_name,a.position_desc,a.experience,a.specific_experience,a.accountablities,b.conp_profile,c.kra, if(b.conp_profile is NULL,0,1) as checka,if(a.position_desc is NULL,0,1) as checkb FROM `uls_position` a
		left join(SELECT count(*) as conp_profile,`comp_position_id` FROM `uls_competency_position_requirements` where 1 group by comp_position_id) b on a.position_id=b.comp_position_id
		left join(SELECT count(*) as kra,`comp_position_id` FROM `uls_competency_position_requirements_kra` where 1 group by comp_position_id) c on a.position_id=c.comp_position_id
		LEFT JOIN (SELECT value_id, master_code, value_code, value_name FROM uls_admin_values GROUP BY value_id)g ON g.master_code = 'POSTYPE' AND a.position_type = g.value_code 
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']."  $sq $possq ORDER BY a.position_structure DESC,a.position_name ASC, checkb DESC , checka DESC");
		
		//$org=$this->session->userdata('security_org_id');
		$busq="";$data['sbu']="";
		if($_SESSION['security_type']=='no'){
			$busq="";$data['sbu']="";
		}
		elseif(!empty($org)){
			$busq=" and (a.organization_id in (".$org.") or division_id in (".$org.") )";
			if($_SESSION['parent_org_id']!=$org){
				$data['sbu']=$org;
			}
		}
		
		$data['bus']=UlsMenu::callpdo("SELECT a.`organization_id` as id,a.`org_name` as name,b.totloc FROM `uls_organization_master` a left join (SELECT count(*) as totloc,bu_id FROM `uls_location` group by bu_id )b on a.`organization_id`=b.bu_id WHERE 1 and a.`org_type`='BU' and a.`parent_org_id`=".$_SESSION['parent_org_id']." $busq ORDER BY `a`.`org_name` ASC");
		
		
		//and position_structure='S'
		$data['locations']=UlsMenu::callpdo("SELECT sum(b.total) as positions,a.* FROM `uls_location` a left join(SELECT 1 as total,`location_id` FROM `uls_position` where 1   $sq2 group by `position_id`)b on find_in_set(a.`location_id`,b.`location_id`)>0 WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." $losq group by a.`location_id` ORDER BY a.`location_name` ASC");
		//and a.position_structure='S'
		$data['pos_department']=UlsMenu::callpdo("SELECT a.position_org_id,b.org_name,COUNT(1) as pos_count FROM uls_position a
		left join(SELECT `organization_id`,`org_name` FROM `uls_organization_master`) b on a.position_org_id=b.organization_id
		WHERE $sq2 $possq2 a.`parent_org_id`=".$_SESSION['parent_org_id']."  GROUP BY a.position_org_id ORDER BY pos_count; ");
		
		$content = $this->load->view('admin/dashboard',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function dashboarddata(){
		$id=$_REQUEST['competencies'];
		$emp_type=$_REQUEST['id'];
		$sq="";
		$sq2="";
		if(!empty($id)){
			
			$sq="a.comp_def_id=$id and ";
			$sq2="comp_def_id=$id and ";
		}
		$sq3=$sq4=$sq5="";
		if(!empty($emp_type)){
		$sq3=" and competency_type='$emp_type'";
		$sq4=" and a.competency_type='$emp_type'";
		$sq5=" and a.assessment_cycle_type='$emp_type'";
		}
		
		
		$data["questionbanks"]=UlsMenu::callpdorow("SELECT b.mcq,c.cases,e.interview,b.test_question_bank_id,c.case_question_bank_id,e.int_question_bank_id FROM `uls_questionbank` a 
		left join ( SELECT count(*) as mcq,`parent_org_id`,group_concat(distinct(question_bank_id)) as test_question_bank_id FROM `uls_questionbank` WHERE $sq2 `type`='COMP_TEST' and comp_def_id in (SELECT comp_def_id FROM `uls_competency_definition` WHERE `parent_org_id`=".$_SESSION['parent_org_id'].$sq3.") group by `parent_org_id` )b on a.`parent_org_id`=b.`parent_org_id` 
		left join ( SELECT count(*) as cases,`parent_org_id`,group_concat(distinct(question_bank_id)) as case_question_bank_id FROM `uls_questionbank` WHERE $sq2 `type`='COMP_CASESTUDY' and comp_def_id in (SELECT comp_def_id FROM `uls_competency_definition` WHERE `parent_org_id`=".$_SESSION['parent_org_id'].$sq3.") group by `parent_org_id` )c on a.`parent_org_id`=c.`parent_org_id` 
		left join ( SELECT count(*) as interview,`parent_org_id`,group_concat(distinct(question_bank_id)) as int_question_bank_id FROM `uls_questionbank` WHERE $sq2 `type`='COMP_INTERVIEW' and comp_def_id in (SELECT comp_def_id FROM `uls_competency_definition` WHERE `parent_org_id`=".$_SESSION['parent_org_id'].$sq3.") group by `parent_org_id` )e on a.`parent_org_id`=e.`parent_org_id` 
		WHERE $sq a.`parent_org_id`=".$_SESSION['parent_org_id']." group by a.`parent_org_id`");
		
		$data["questions"]=UlsMenu::callpdorow("SELECT (SELECT count(*) as mcq FROM `uls_questions` WHERE `question_bank_id` in (SELECT `question_bank_id` FROM `uls_questionbank` WHERE $sq2 `type`='COMP_TEST' and comp_def_id in (SELECT comp_def_id FROM `uls_competency_definition` WHERE `parent_org_id`=".$_SESSION['parent_org_id'].$sq3.") and `parent_org_id`=".$_SESSION['parent_org_id'].")) as mcq, (SELECT count(*) as mcq FROM `uls_questions` WHERE `question_bank_id` in (SELECT `question_bank_id` FROM `uls_questionbank` WHERE $sq2 `type`='COMP_CASESTUDY' and comp_def_id in (SELECT comp_def_id FROM `uls_competency_definition` WHERE `parent_org_id`=".$_SESSION['parent_org_id'].$sq3.")  and `parent_org_id`=".$_SESSION['parent_org_id'].")) as cases, (SELECT count(*) as mcq FROM `uls_questions` WHERE `question_bank_id` in (SELECT `question_bank_id` FROM `uls_questionbank` WHERE $sq2 `type`='COMP_INTERVIEW' and comp_def_id in (SELECT comp_def_id FROM `uls_competency_definition` WHERE `parent_org_id`=".$_SESSION['parent_org_id'].$sq3.")  and `parent_org_id`=".$_SESSION['parent_org_id'].")) as interview ");
		
		$data['questionbanks_inbasket']=UlsMenu::callpdorow("SELECT count(distinct(a.`question_id`)) as q_bank,a.comp_def_id FROM `uls_question_values` a WHERE $sq a.comp_def_id in (SELECT comp_def_id FROM `uls_competency_definition` WHERE `parent_org_id`=".$_SESSION['parent_org_id'].$sq3.")");
		
		$data['question_inbasket']=UlsMenu::callpdorow("SELECT count(a.`question_id`) as ques FROM `uls_question_values` a WHERE $sq a.comp_def_id in (SELECT comp_def_id FROM `uls_competency_definition` WHERE `parent_org_id`=".$_SESSION['parent_org_id'].$sq3.")");
		$data['comp_def_id']=$id;
		$content = $this->load->view('admin/dashboarddata',$data,true);
		$this->render('layouts/ajax-layout',$content);
		
	}
	
	public function getlocassesspos(){
		$emptype=$_REQUEST['emptype'];
		$bu=$_REQUEST['bu'];
		$loc=$_REQUEST['loc'];
		$sq=$sq2=$sq3=$sq4=$sq5="";
		if(!empty($emptype)){
			$sq.=" and a.position_type='$emptype'";
			$sq2.=" and position_type='$emptype'";
			$sq5.=" and a.assessment_cycle_type='$emptype'";
		}
		if(!empty($bu)){
			$sq.=" and a.bu_id='$bu'";
			$sq2.=" and bu_id='$bu'";
			$sq3.=" and a.bu_id='$bu'";
			$sq5.=" and a.location_id in (select location_id from `uls_location` where bu_id='$bu')";
		}
		if(!empty($loc)){
			$sq.=" and find_in_set($loc,a.location_id)>0";
			//$sq2.=" and find_in_set($loc,location_id)>0";
			$sq3.=" and a.location_id='$loc'";
			$sq5.=" and a.location_id ='$loc'";
			
		}
		$data['loc']=$loc;
		$data['bu']=$bu;
		$data['emptype']=$emptype;
		$data['locations']=UlsMenu::callpdo("SELECT sum(b.total) as positions,a.* FROM `uls_location` a left join(SELECT 1 as total,`location_id` FROM `uls_position` where 1 $sq2 group by `position_id`)b on find_in_set(a.`location_id`,b.`location_id`)>0 WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." $sq3 group by a.`location_id` ORDER BY a.`location_name` ASC");
		
		$data['assessors']=array();
		
		$data['assessments']=UlsMenu::callpdo("SELECT c.employees,b.positions,a.* FROM `uls_assessment_definition` a 
		left join(select count(*) as positions,assessment_id from `uls_assessment_position` group by `assessment_id` )b on a.`assessment_id`=b.`assessment_id`
		left join(select count(*) as employees,assessment_id from `uls_assessment_employees` group by `assessment_id` )c on a.`assessment_id`=c.`assessment_id`
		WHERE 1 and a.`parent_org_id`=".$_SESSION['parent_org_id']." $sq5 order by assessment_id desc");
		
		$data["position_info"]=UlsMenu::callpdo("SELECT g.value_name as position_type,a.position_id,a.position_name,a.position_desc,a.experience,a.specific_experience,a.accountablities,b.conp_profile,c.kra, if(b.conp_profile is NULL,0,1) as checka,if(a.position_desc is NULL,0,1) as checkb FROM `uls_position` a
		left join(SELECT count(*) as conp_profile,`comp_position_id` FROM `uls_competency_position_requirements` where 1 group by comp_position_id) b on a.position_id=b.comp_position_id
		left join(SELECT count(*) as kra,`comp_position_id` FROM `uls_competency_position_requirements_kra` where 1 group by comp_position_id) c on a.position_id=c.comp_position_id
		LEFT JOIN (SELECT value_id, master_code, value_code, value_name FROM uls_admin_values GROUP BY value_id)g ON g.master_code = 'POSTYPE' AND a.position_type = g.value_code 
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id'].$sq." ORDER BY a.position_name ASC, checkb DESC , checka DESC");
		
		$content = $this->load->view('admin/dashboardupdate',$data,true);
		$this->render('layouts/ajax-layout',$content);
	}
	
	public function getassesspos(){
		$emptype=$_REQUEST['emptype'];
		$bu=$_REQUEST['bu'];
		$loc=$_REQUEST['loc'];
		$year=$_REQUEST['year'];
		$sq=$sq2=$sq3=$sq4=$sq5="";
		if(!empty($emptype)){
			$sq.=" and a.position_type='$emptype'";
			$sq2.=" and position_type='$emptype'";
			$sq5.=" and a.assessment_cycle_type='$emptype'";
		}
		if(!empty($bu)){
			$sq.=" and a.bu_id='$bu'";
			$sq2.=" and bu_id='$bu'";
			$sq3.=" and a.bu_id='$bu'";
			$sq5.=" and a.location_id in (select location_id from `uls_location` where bu_id='$bu')";
		}
		if(!empty($loc)){
			$sq.=" and find_in_set($loc,a.location_id)>0";
			//$sq2.=" and find_in_set($loc,location_id)>0";
			$sq3.=" and a.location_id='$loc'";
			$sq5.=" and a.location_id ='$loc'";
		}
		if(!empty($year)){
			$sq5.=" and year(a.start_date) ='$year'";
		}
		$data['loc']=$loc;
		$data['bu']=$bu;
		$data['emptype']=$emptype;
		$data['year']=$year;
		
		$data['assessments']=UlsMenu::callpdo("SELECT c.employees,b.positions,a.* FROM `uls_assessment_definition` a 
		left join(select count(*) as positions,assessment_id from `uls_assessment_position` group by `assessment_id` )b on a.`assessment_id`=b.`assessment_id`
		left join(select count(*) as employees,assessment_id from `uls_assessment_employees` group by `assessment_id` )c on a.`assessment_id`=c.`assessment_id`
		WHERE 1 and a.`parent_org_id`=".$_SESSION['parent_org_id']." $sq5 order by assessment_id desc");
		
		$content = $this->load->view('admin/dashboardupdateassess',$data,true);
		$this->render('layouts/ajax-layout',$content);
	}
	
	public function getasesspos(){
		$assess_id=filter_input(INPUT_GET,'id') ? filter_input(INPUT_GET,'id'):"";
		if(!empty($assess_id)){
			$results=UlsAssessmentDefinition::getasesspos($assess_id);
		}
		else{
			
		}
	}

	public function getasessposemp(){
		$assess_id=filter_input(INPUT_GET,'id') ? filter_input(INPUT_GET,'id'):"";
		if(!empty($assess_id)){
			$results=UlsAssessmentDefinition::getasessposemp($assess_id);
		}
		else{
			
		}
	}
	
	public function getposdet(){
		$id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
		$posdetails=UlsPosition::viewposition($_REQUEST['id']);
		$data['posdetails']=$posdetails;
		$data['competencies']=UlsCompetencyPositionRequirements::getcompetencypositionrequirements($_REQUEST['id']);
		$data['kras']=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($_REQUEST['id']);
		$questionsbanks=UlsCompetencyPositionRequirements::getcompetencypositionqb($_REQUEST['id']);
		$testtypes=UlsAdminMaster::get_value_names("ASSESSMENT_TYPE");
		$qcount=$qtypes=array();
		foreach($questionsbanks as $questionsbank){
			foreach($testtypes as $testtype){
				if($testtype['code']==$questionsbank['type']){
					$id=$questionsbank['comp_def_id'];
					$sid=$questionsbank['scale_id'];
					$type=$testtype['code'];
					$qtypes[$id][$sid][$type]=isset($qtypes[$id][$sid][$type])?$qtypes[$id][$sid][$type]+1:1;
					$qcount[$id][$sid][$type]['q']=isset($qcount[$id][$sid][$type]['q'])?$qcount[$id][$sid][$type]['q']+$questionsbank['qcount']:$questionsbank['qcount'];
				}
			}
		}
		$data['qcount']=$qcount;
		$data['qtypes']=$qtypes;
		$data['testtypes']=$testtypes;
		$content = $this->load->view('admin/dashboardposition',$data,true);
		$this->render('layouts/ajax-layout',$content);
    }
	
	public function ajaxpassword(){
        $validateValue=strtolower($_REQUEST['fieldValue']);
        $validateId=$_REQUEST['fieldId'];
        $checkuser=Doctrine::getTable('UlsUserCreation')->find($_SESSION['user_id']);
		$password=strtolower($checkuser->password);
        $arrayToJs = array();
        $arrayToJs[0] = $validateId;
        $arrayToJs[1] =($validateValue == $password)?	true:false;
        echo json_encode($arrayToJs);	
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
				redirect("admin/profile");
            }
            else{
                $data['message']="Some error occurred please try again";
            }
        }
		$content = $this->load->view('admin/admin_changepassword',$data,true);
		$this->render('layouts/adminnew',$content);
	}

	public function employee_search()
	{
		$data["aboutpage"]=$this->pagedetails('admin','employeesearch');
        $limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
        $emp_name=filter_input(INPUT_GET,'emp_name') ? filter_input(INPUT_GET,'emp_name'):"";
        $emp_number=filter_input(INPUT_GET,'emp_number') ? filter_input(INPUT_GET,'emp_number'):"";
        $page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
        $start=$page!=0? ($page-1)*$limit:0;
        $filePath=BASE_URL."/admin/employee_search";
        $data['limit']=$limit;
        $data['emp_name']=$emp_name;
        $data['emp_number']=$emp_number;
        $data['perpages']=UlsMenuCreation::perpage();
        $data['empdetails']=UlsEmployeeMaster::search($start, $limit,$emp_name,$emp_number);
        $total=UlsEmployeeMaster::searchcount($emp_name,$emp_number);
        $otherParams="perpage=".$limit."&emp_number=".$emp_number."&emp_name=".$emp_name;
        $data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/employee_search',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function view_emp_details(){
        $this->sessionexist();
		$data["aboutpage"]=$this->pagedetails('admin','employee_view');
        $id=filter_input(INPUT_GET,'emp_id') ? filter_input(INPUT_GET,'emp_id'):""; 
        $hash=filter_input(INPUT_GET,'hash') ? filter_input(INPUT_GET,'hash'):""; 
        $menutype=!empty($id)? UlsMenuCreation::menutype($id):"";  
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
            $data["last_details"]=UlsEmployeeMaster::viewemployee($id);
			$content = $this->load->view('admin/employee_view',$data,true);
        }
		$this->render('layouts/adminnew',$content);
    }

	public function employee_creation()
	{
		$this->sessionexist();
		$data["aboutpage"]=$this->pagedetails('admin','employee_creations');
		$emp_title="TITLE";
        $data['emptitle']=UlsAdminMaster::get_value_names($emp_title);
        $emp_gend="GENDAR";
        $data['empgendar']=UlsAdminMaster::get_value_names($emp_gend);
        $emp_stats="EMP_STATUS";
        $data['empstats']=UlsAdminMaster::get_value_names($emp_stats);
        $emp_nat="NATIONALITY";
        $data['empnation']=UlsAdminMaster::get_value_names($emp_nat);
        $emp_crty="COUNTRY";
        $data['empcntry']=UlsAdminMaster::get_value_names($emp_crty);
        $org_stat="STATUS";
        $data['orgstat']=UlsAdminMaster::get_value_names($org_stat);
		$emp_type2="EMP_TYPE";
        $data['emptyp2']=UlsAdminMaster::get_value_names($emp_type2);
		//$emp_typ="NEW_EMP_TYPE";
        $data['emptyp']=UlsEmployeeType::getemptypes();//UlsAdminMaster::get_value_names($emp_typ);
		//$emp_cat="EMP_CATEGORY";
        $data['empcat']=UlsEmployeeCategory::getempcategory();//UlsAdminMaster::get_value_names($emp_cat);
		
        $data['last_details']=UlsEmployeeMaster::fetch_emp_data();
		//$grade_status="LOCATION_ZONES";
        $data['zonestatus']=UlsZone::getzones();//UlsAdminMaster::get_value_names($grade_status);
		$data['states']=UlsStates::get_states();
		$users=UlsUserCreation::fetchempdet();
		$data['usercreate']=$users;
		$rcreate=(isset($users->user_id))?Doctrine_Query::Create()->from('UlsUserRole')->where('user_id='.$users->user_id)->execute():'';
		$data['rolecreate']=$rcreate;
		$data['userroles']=UlsUserRole::fetchroledet();
        $data['last_wrk_details']=UlsEmployeeWorkInfo::fetch_emp_work_data();
        $data['emp_orgdetails']=UlsOrganizationMaster::org_details_names();
		$data['business_units']=UlsOrganizationMaster::business_units();
		$data['parent_depart']=UlsOrganizationMaster::parent_department();
		$data['division_detail']=UlsOrganizationMaster::division_details();
        $data['supervisors_data']=UlsEmployeeMaster::fetch_super();//fetch_allemp_details();
        $data['reportees_data']=UlsEmployeeMaster::fetch_reportees_details();
		$data['roless']=UlsRoleCreation::getAllRoles();
        $data['emp_grade']=UlsGrade::fetch_all_grades();
        $data['emp_locs']=UlsLocation::fetch_all_locs();
		$data['positions']=UlsPosition::pos_orgbased_all();
		$data['sub_grade']=array();//UlsSubGrades::sug_grades_all();
		$content = $this->load->view('admin/employee_creation',$data,true);
		$this->render('layouts/adminnew',$content);
	}

	public function emp_details(){
		
		$this->sessionexist();
        if(isset($_POST['first_name'])){
            $insert_val=array('emp_type'=>'emp_type','emp_cat'=>'emp_cat', 'first_name'=>'first_name', 'middle_name'=>'mid_name', 'last_name'=>'last_name', 'current_employee_flag'=>'emp_status', 'nationality'=>'nationality', 'email'=>'email', 'office_number'=>'phone', 'country'=>'country', 'additional_info'=>'add_info', 'employee_number'=>'emp_number', 'gender'=>'Gendar', 'title'=>'title', 'edu_qualification'=>'qualification', 'previous_exp'=>'experience');
            $insert_dates=array('date_of_birth'=>'dob', 'date_of_joining'=>'date_of_joining', 'date_of_exit'=>'date_of_exit');
            $empdata=(!empty($_POST['employee_id']))?Doctrine::getTable('UlsEmployeeMaster')->find($_POST['employee_id']):new UlsEmployeeMaster;
            $name=$_POST['first_name']." ".$_POST['mid_name']." ".$_POST['last_name'];
            $empdata->full_name=$name;
			$empdata->parent_org_id=$_SESSION['parent_org_id'];
			$empdata->start_date=NULL;
            foreach($insert_val as $key=>$ins_val){
                $empdata->$key=(!empty($_POST[$ins_val]))?$_POST[$ins_val]:NULL;
            }
            foreach($insert_dates as $key=>$dt_val){
              $empdata->$key=!empty($_POST[$dt_val])?date('Y-m-d',strtotime($_POST[$dt_val])):Null;
            }
            $profile_pic=$empdata->photo;
            if(!empty($_FILES['imgInp']['name'])){
                $filename=str_replace(array(" ","'","&"),array("_","_","_"),$_FILES['imgInp']['name']);
            }else if(empty($_FILES['imgInp']['name']) && !empty($profile_pic)){
                $filename=$profile_pic;
            }else{
                $filename='';
            }
            $empdata->photo=$filename;
            $empdata->save();
            $emp_id=$empdata->employee_id;
            $hash=SECRET.$emp_id;
            if(!empty($_FILES['imgInp']['name'])){
                $uploaddir1= __SITE_PATH .DS.'public'.DS.'uploads'.DS.'profile_pic'.DS. $empdata->employee_id;
                if(is_dir($uploaddir1)){
                    $delpic=$uploaddir1."/".$profile_pic;
                    (!empty($delpic))?unlink($delpic):'';
                    $target_path = __SITE_PATH .DS.'public'.DS.'uploads'.DS.'profile_pic'.DS. $empdata->employee_id .DS. $filename;
                    move_uploaded_file($_FILES['imgInp']['tmp_name'], $target_path);
                }
                else{
                    mkdir($uploaddir1,0777);
                    $target_path = __SITE_PATH .DS.'public'.DS.'uploads'.DS.'profile_pic'.DS. $empdata->employee_id .DS. $filename;
                    move_uploaded_file($_FILES['imgInp']['tmp_name'], $target_path);
                }
            }

            if(isset($_POST['from_date'])){
                foreach($_POST['from_date'] as $key=>$fromdate){
                    if(!empty($_POST['department'][$key])){
                        $work_val=array('status'=>'status', 'org_id'=>'department');
                        $work_dates=array('from_date', 'to_date');
                        $empwrkdata=(!empty($_POST['work_id'][$key]))?Doctrine::getTable('UlsEmployeeWorkInfo')->find($_POST['work_id'][$key]):new UlsEmployeeWorkInfo;
						
						/*if($empwrkdata['org_id']!=$_POST['department'][$key]){
							$employeeid=$empwrkdata['employee_id'];
							$getempdetails=UlsEmployeeMaster::getemployeedetails($employeeid);
					
							$empstag=new UlsEmpStagingTable();
							$empstag->title=(!empty($getempdetails['title']))?$getempdetails['title']:NULL;
							$empstag->gendar=(!empty($getempdetails['gender']))?$getempdetails['gender']:NULL;
							$empstag->employee_id=$getempdetails['employee_id'];
							$empstag->work_info_id=$empwrkdata['work_info_id'];
							$empstag->emp_name=$getempdetails['full_name'];
							$empstag->emp_number=$getempdetails['employee_number'];
							$empstag->emp_status=$getempdetails['current_employee_flag'];
							$empstag->joining_date=$empwrkdata['from_date'];
							$empstag->email=(!empty($getempdetails['email']))?$getempdetails['email']:NULL;
							$empstag->phone=(!empty($getempdetails['office_number']))?$getempdetails['office_number']:NULL;
							$empstag->parent_org_id=(!empty($getempdetails['parent_org_id']))?$getempdetails['parent_org_id']:NULL;
							$empstag->org_id=(!empty($empwrkdata['org_id']))?$empwrkdata['org_id']:NULL;
							$empstag->position_id=$empwrkdata['position_id'];
							$empstag->grade_id=(!empty($empwrkdata['grade_id']))?$empwrkdata['grade_id']:NULL;
							$empstag->location_id=(!empty($empwrkdata['location_id']))?$empwrkdata['location_id']:NULL;
							$empstag->status="A";
							$empstag->save();
						}*/
                        $empwrkdata->employee_id=$emp_id;
						$empwrkdata->parent_org_id=$_SESSION['parent_org_id'];
                        foreach($work_val as $key1=>$ins_val){
                                $empwrkdata->$key1=(!empty($_POST[$ins_val][$key]))?$_POST[$ins_val][$key]:NULL;
                        }
                        foreach($work_dates as $key2=>$date_val){
                                $empwrkdata->$date_val=(!empty($_POST[$date_val][$key]))?date('Y-m-d',strtotime($_POST[$date_val][$key])):NULL;
                        }
                        $empwrkdata->save();
                    }
                }
            }

			if(!empty($_POST['emp_number']) || !empty($_POST['employee_id']) || !empty($_POST['user_name'])){
				$usercreation=!empty($_POST['user_id'])? Doctrine_Core::getTable('UlsUserCreation')->find($_POST['user_id']):new UlsUserCreation();
				$usercreation->user_name=(!empty($_POST['user_name']))?$_POST['user_name']:$_POST['emp_number'];
				$usercreation->password=(!empty($_POST['password']))?$_POST['password']:'welcome';
				$usercreation->email_address=(!empty($_POST['email']))?$_POST['email']:NULL;
				$usercreation->user_type=(!empty($_POST['user_type']))?$_POST['user_type']:'EMP';
				$usercreation->employee_id=$emp_id;
				$usercreation->user_login=1;
				$usercreation->start_date=(!empty($_POST['start_date']))?date('Y-m-d',strtotime($_POST['start_date'])):date("Y-m-d");
				$usercreation->end_date=(!empty($_POST['end_date']))?date('Y-m-d',strtotime($_POST['end_date'])):NULL;
				empty($_POST['user_id'])?$usercreation->parent_org_id=$_SESSION['parent_org_id']:"";
				$usercreation->save();
				$check_aas=UlsAssessorMaster::check_assessor($emp_id);
				$assessor=!empty($check_aas['assessor_id'])? Doctrine_Core::getTable('UlsAssessorMaster')->find($check_aas['assessor_id']):new UlsAssessorMaster();
				$assessor->employee_id=(!empty($emp_id))?$emp_id:NULL;
				$assessor->assessor_name=(!empty($empdata->full_name))?$empdata->full_name:"";
				$assessor->assessor_email=(!empty($_POST['email']))?$_POST['email']:NULL;
				$assessor->assessor_mobile=(!empty($empdata->office_number))?$empdata->office_number:NULL;
				$assessor->assessor_type='INT';
				$assessor->assessor_status='A';
				$assessor->save();
				$fieldinsertupdates2=array('role_id','description');
				$datefields2=array('start_date'=>'startdate','end_date'=>'enddate');
				if(!empty($_POST['user_id'])){
					foreach($_POST['description'] as $key=>$act){
						if(!empty($_POST['role_id'][$key])){
							$usercreation1=!empty($_POST['user_role_id'][$key])? Doctrine_Core::getTable('UlsUserRole')->find($_POST['user_role_id'][$key]):new UlsUserRole();
							try {
								$usercreation1->user_id=$usercreation->user_id;
								foreach($fieldinsertupdates2 as $val2){$usercreation1->$val2=$_POST[$val2][$key];}
								foreach($datefields2 as $key2=>$val2){$usercreation1->$key2=(!empty($_POST[$val2][$key]))?date("Y-m-d", strtotime($_POST[$val2][$key])):NULL;}
								$usercreation1->menu_id=isset($_POST['chk'][$key]) ? implode(",",$_POST['chk'][$key]) : $_POST['menuid'][$key];
								$usercreation1->save();
							}
							catch(Doctrine_Validator_Exception $e) {
								$orguserErrors = $usercreation1->getErrorStack();
								foreach($orguserErrors as $fieldName => $errorCodes) {
									echo $fieldName . " - " . implode(', ', $errorCodes) . "\n";
								}
								echo $msg=$usercreation1->getErrorStackAsString();
								$flg=1;
							}

						}
					}
				}else{
					$men="select group_concat(m.menu_id) as menu_id, r.role_id from uls_role_creation r INNER JOIN uls_menu_creation mc on mc.menu_creation_id=r.menu_id  and mc.system_menu_type='emp' INNER JOIN uls_menu m on m.menu_creation_id=mc.menu_creation_id where r.parent_org_id=".$_SESSION['parent_org_id'];
					$menuids=UlsMenu::callpdorow($men);
					$userrole=new UlsUserRole();
					$userrole->user_id=$usercreation->user_id;
					$userrole->role_id=$menuids['role_id'];
					$userrole->menu_id=$menuids['menu_id'];
					$userrole->parent_org_id=$_SESSION['parent_org_id'];
					$userrole->start_date=date("Y-m-d");
					$userrole->save();
				}
			}
			if(isset($_POST['submit_user'])){$st="user";}else{$st="personal";}
            $this->session->set_flashdata('emp_msg',"Employee data ".(!empty($_POST['employee_id'])?"updated":"inserted")." successfully.");
            redirect('admin/employee_creation?status='.$st.'&emp_id='.$emp_id.'&hash='.md5($hash));
		}
		else{
			$content = $this->load->view('admin/employee_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }

	public function ChangeGendar(){
        $tilte=$_REQUEST['title'];
        if($tilte=='MR'){
            echo "<option value=''>Select</option>
                <option value='M' selected='selected'>Male</option>
                <option value='F'>Female</option>";
        }
        if($tilte=='MRS' || $tilte=='MS'){
            echo "<option value=''>Select</option>
                <option value='M'>Male</option>
                <option value='F' selected='selected'>Female</option>";
        }
    }

	public function ChangeTitle(){
        $gendar=$_REQUEST['gendar'];
		$title=$_REQUEST['title'];
		if($gendar=='M'){
			if($title=="DR"){
				echo "<option value=''>Select</option>
				<option value='MR' >Mr</option>
				<option value='MRS'>Mrs</option>
				<option value='MS'>Ms</option>
				<option value='DR' selected='selected'>Dr</option>";
			}
			else{
				echo "<option value=''>Select</option>
				<option value='MR' selected='selected'>Mr</option>
				<option value='MRS'>Mrs</option>
				<option value='MS'>Ms</option>
				<option value='DR'>Dr</option>";
			}
		}
		if($gendar=='F'){
			if($title=="DR"){
				echo "<option value=''>Select</option>
				<option value='MR' >Mr</option>
				<option value='MRS'>Mrs</option>
				<option value='MS'>Ms</option>
				<option value='DR' selected='selected'>Dr</option>";
			}
			else{
				echo "<option value=''>Select</option>
				<option value='MR'>Mr</option>
				<option value='MRS'>Mrs</option>
				<option value='MS' selected='selected'>Ms</option>
				<option value='DR'>Dr</option>";
			}
		}
    }

	 /*
     * Created by Nagaraj Modified by Srikanth ChangePosition
	 * This method is used to get the positions based on orgid
	 * Table used Uls_Position
    */
    public function ChangePosition(){
        //$orgid=$_REQUEST['org_id'];
        $orgpos=UlsPosition::pos_orgbased_all();
        echo "<option value=''>Select</option>";
        foreach($orgpos as $orgpost){
            echo "<option value=".$orgpost['position_id'].">".$orgpost['position_name']."</option>";
        }
    }

	public function autoemployee(){
		if(isset($_POST['data']['q'])){$id=$_POST['data']['q'];}
		else{$id=$_REQUEST['term'];}
		$empids=UlsEmployeeMaster::secure_employee_data();
		$sq=1;
		$sq.=!empty($empids)?" and employee_id in (".$empids.")":"";
		$hodquery="select employee_id,full_name,REPLACE(employee_number,' ','') as employee_number from uls_employee_master where $sq and parent_org_id='".$_SESSION['parent_org_id']."' and (employee_number like '$id%' || full_name like '%$id%')  order by employee_number limit 10";
		$hodrow=UlsMenu::callpdo($hodquery);
		$results=array();
		foreach($hodrow as $val){
			$results[] = array('id' => $val['employee_id'], 'text' => $val['employee_number']." - ".$val['full_name']);
			//$checkhod[]=$val['employee_id']." - ".$val['employee_number']." - ".$val['full_name'];
		}
		if(isset($_POST['data']['q'])){echo json_encode(array('q' => $id, 'results' => $results));}
		else{echo json_encode($results);}
	}

	public function DeleteEmpInfo(){
        $work_id=$_REQUEST['val'];
        $q =!empty($work_id)? Doctrine_Query::create()->delete('UlsEmployeeWorkInfo')->where('work_info_id=?',$work_id)->execute():"";
    }

	/*
     * Created by Srikanth Modified by Srikanth execlusion
	 * This method is used has ajax function used to show menu items in design format
	 * Table used uls_role_creation,uls_menu_creation,uls_menu
    */
    public function execlusion(){
        $id=$_REQUEST['id'];
        $mainkey=$_REQUEST['key'];
        $role=Doctrine_Core::getTable('UlsRoleCreation')->find($id);
        echo "<div class='widget-box'><div class='widget-header widget-header-flat widget-header-small'>
				<h5 class='widget-title'>
					<i class='ace-icon fa fa-signal'></i>
					Menu Details
				</h5>

				<div class='widget-toolbar no-border'>
					<div class='inline dropdown-hover'>
						<input type='button' class='btn btn-minier btn-primary' name='proceed' id='proceed' value='Close' onclick='cancelmenu(".$id.")'>
					</div>
				</div>
			</div><div class='cf nestable-lists'><div class='dd' id='nestable'>";
        echo UlsMenu::usercreation_menu(0,0,$role->menu_id,$id,$mainkey);
        echo "</div></div>";
    }

	public function menu_view(){
		$role_id=$_REQUEST['role_id'];
		$key=$_REQUEST['key'];
		$role_menuid=UlsRoleCreation::getspecRoles($role_id);
		$menu_value=UlsMenu::menu_values($role_menuid['menu_id']);
		$det="<a onClick='exclusion(".$role_id.",".$role_id.")'><input type='hidden' value='".$menu_value['menu_id']."' name='menuid[".$key."]' id='menuids_".$key."' ><input type='button' name='exclusion' id='exclusion0' value='Menu'></a>";
		echo $det;
	}

	public function delete_emp_role(){
		if(!empty($_REQUEST['val'])){
			$play=Doctrine_Query::Create()->delete('UlsUserRole')->where("user_role_id=".$_REQUEST['val'])->execute();
			echo 1;
		}
		else{
			echo "Selected User Roles cannot be deleted. Ensure you delete all the usages of the User Roles before you delete it.";
		}
	}

	public function work_info_details(){
		
		$id=$_REQUEST['work_info_id'];
		$workinfo=UlsMenu::callpdorow("select * from uls_employee_work_info where 1 and work_info_id=".$id);
		$data['view_details']=UlsEmployeeWorkInfo::fetch_emp_work_data_details($id);
		$data['business_units']=UlsOrganizationMaster::business_units();
		$data['parent_depart']=UlsOrganizationMaster::parent_department();
		$data['division_detail']=UlsOrganizationMaster::division_details();
		$data['positions']=UlsPosition::pos_orgbased_all();
		$data['emp_grade']=UlsGrade::fetch_all_grades();
		$data['sub_grade']=UlsSubGrades::get_grade_sub($workinfo['grade_id']);		
		//$grade_status="LOCATION_ZONES";
        $data['zonestatus']=UlsZone::getzones();//UlsAdminMaster::get_value_names($grade_status);
		$data['states']=!empty($id)?UlsZoneMap::zones_states($workinfo['zone_id']):array();//UlsStates::get_states();
		$data['location']=!empty($id)?UlsLocation::get_locations_states($workinfo['zone_id'],$workinfo['state_id']):array();		
		$content = $this->load->view('admin/lms_admin_employee_workinfo_details',$data,true);
		$this->render('layouts/ajax-layout',$content);
	}
	
	public function emp_work_details(){
		
		if(isset($_POST['submit_user'])){
            			
			foreach($_POST['from_date'] as $key=>$fromdate){
				$work_val=array('gross_salary'=>'gross', 'net_salary'=>'net', 'total_ctc'=>'ctc', 'bu_id'=>'business_unit', 'position_id'=>'position', 'grade_id'=>'grade', 'sub_grade_id'=>'sub_grade', 'supervisor_id'=>'supervisor', 'payroll_id'=>'payroll', 'manager_flag'=>'manager','parent_dep_id'=>'parent_dep_id', 'division_id'=>'division_id', 'zone_id'=>'zones_name', 'state_id'=>'state_id', 'location_id'=>'location');
				$empwrkdata=(!empty($_POST['work_id'][$key]))?Doctrine::getTable('UlsEmployeeWorkInfo')->find($_POST['work_id'][$key]):new UlsEmployeeWorkInfo;
				
				/* if($empwrkdata['position_id']!=$_POST['position']){
					$employeeid=$empwrkdata['employee_id'];
					$getempdetails=UlsEmployeeMaster::getemployeedetails($employeeid);
					
					$empstag=new UlsEmpStagingTable();
					$empstag->title=(!empty($getempdetails['title']))?$getempdetails['title']:NULL;
					$empstag->gendar=(!empty($getempdetails['gender']))?$getempdetails['gender']:NULL;
					$empstag->employee_id=$getempdetails['employee_id'];
					$empstag->work_info_id=$empwrkdata['work_info_id'];
					$empstag->emp_name=$getempdetails['full_name'];
					$empstag->emp_number=$getempdetails['employee_number'];
					$empstag->emp_status=$getempdetails['current_employee_flag'];
					$empstag->joining_date=$empwrkdata['from_date'];
					$empstag->email=(!empty($getempdetails['email']))?$getempdetails['email']:NULL;
					$empstag->phone=(!empty($getempdetails['office_number']))?$getempdetails['office_number']:NULL;
					$empstag->parent_org_id=(!empty($getempdetails['parent_org_id']))?$getempdetails['parent_org_id']:NULL;
					$empstag->org_id=(!empty($empwrkdata['org_id']))?$empwrkdata['org_id']:NULL;
					$empstag->position_id=$empwrkdata['position_id'];
					$empstag->grade_id=(!empty($empwrkdata['grade_id']))?$empwrkdata['grade_id']:NULL;
					$empstag->location_id=(!empty($empwrkdata['location_id']))?$empwrkdata['location_id']:NULL;
					$empstag->status="A";
					$empstag->save();
				} */
				foreach($work_val as $key1=>$ins_val){
						$empwrkdata->$key1=(!empty($_POST[$ins_val][$key]))?$_POST[$ins_val][$key]:NULL;
				}
				$empwrkdata->save();
			}
			
			$empid=$_POST['employee_id'];
			$hash=SECRET.$empid;
			$wrkid=$_POST['work_info_id'];
			$wrkhash=SECRET.$wrkid;
			redirect('admin/employee_creation?status=personal&emp_id='.$empid.'&hash='.md5($hash).'&wrk_id='.$wrkid.'&wrk_hash='.md5($wrkhash),'admin-layout');
		}
		
	}


	public function emp_work_single_details(){
		if(isset($_POST['submit_user'])){
			foreach($_POST['from_date'] as $key=>$fromdate){
				if(!empty($_POST['department'][$key])){
					$work_val=array('gross_salary'=>'gross', 'net_salary'=>'net', 'total_ctc'=>'ctc', 'status'=>'status', 'org_id'=>'department', 'bu_id'=>'business_unit', 'position_id'=>'position', 'grade_id'=>'grade', 'sub_grade_id'=>'sub_grade', 'supervisor_id'=>'supervisor', 'payroll_id'=>'payroll', 'location_id'=>'location', 'manager_flag'=>'manager', 'zone_id'=>'zones_name', 'state_id'=>'state_id', 'parent_dep_id'=>'parent_dep_id', 'division_id'=>'division_id');
					$work_dates=array('from_date', 'to_date');
					$empwrkdata=(!empty($_POST['work_id'][$key]))?Doctrine::getTable('UlsEmployeeWorkInfo')->find($_POST['work_id'][$key]):new UlsEmployeeWorkInfo;
					$empwrkdata->employee_id=$_POST['employee_id'];
					$empwrkdata->parent_org_id=$_SESSION['parent_org_id'];
					foreach($work_val as $key1=>$ins_val){
							$empwrkdata->$key1=(!empty($_POST[$ins_val][$key]))?$_POST[$ins_val][$key]:NULL;
					}
					foreach($work_dates as $key2=>$date_val){
							$empwrkdata->$date_val=(!empty($_POST[$date_val][$key]))?date('Y-m-d',strtotime($_POST[$date_val][$key])):NULL;
					}
					$empwrkdata->save();
				}
			}
			$empid=$_POST['employee_id'];
			$hash=SECRET.$empid;
			$wrkid=$empwrkdata->work_info_id;
			$wrkhash=SECRET.$wrkid;
			redirect('admin/employee_creation?status=reportees&emp_id='.$empid.'&hash='.md5($hash).'&wrk_id='.$wrkid.'&wrk_hash='.md5($wrkhash),'admin-layout');
		}

	}	
	
	public function grade_sub_emp_creation(){
		$grade_id=$_REQUEST['grade_id'];
		$key=$_REQUEST['key'];
		$grades=UlsSubGrades::get_grade_sub($grade_id);
		$data="";
		$id="sub_grade[".$key."]";
		$name="sub_grade[]";
		$data.="<select id='".$id."' name='".$name."' class='form-control m-b'><option value=''>Select</option>";
		foreach($grades as $grade){
			$data.="<option value='".$grade['sub_grade_id']."'>".$grade['sub_name']."</option>";
		}
		$data.="</select>";
		echo $data;
	}

	public function zone_states_emp_creation(){
		$zone_id=$_REQUEST['zone_id'];
		$key=$_REQUEST['key'];
		$zones=UlsZoneMap::zones_states($zone_id);
		$data="";
		$id="state_id[".$key."]";
		$name="state_id[]";
		$data.="<select id='".$id."' name='".$name."' class='validate[required] form-control m-b' onchange='open_location_state(".$key.")'  ><option value=''>Select</option>";
		foreach($zones as $zoness){
			$data.="<option value='".$zoness['state_id']."'>".$zoness['state_name']."</option>";
		}
		$data.="</select>";
		echo $data;
	}

	public function states_emp_creation(){
		$state_id=!empty($_REQUEST['state_id'])?$_REQUEST['state_id']:"";
		$zone_id=!empty($_REQUEST['zone_id'])?$_REQUEST['zone_id']:"";
		$key=$_REQUEST['key'];
		$location=(!empty($zone_id) && !empty($state_id))?UlsLocation::get_locations_states($zone_id,$state_id):array();
		$data="";
		$id="location[".$key."]";
		$name="location[]";
		$data.="<select id='".$id."' name='".$name."' class='validate[required] form-control m-b' onclick='check_org(".$key.")'><option value=''>Select</option>";
		foreach($location as $locations){
			$data.="<option value='".$locations['location_id']."'>".$locations['location_name']."</option>";
		}
		$data.="</select>";
		echo $data;
	}

	public function org_master()
	{
		$data["aboutpage"]=$this->pagedetails('admin','organization_masters');
		$orglast=UlsOrganizationMaster::org_last_data();
        $data['orgtyp']=UlsAdminMaster::get_value_names("ORG_TYPE");
        $data['butyp']=UlsAdminMaster::get_value_names("BU_TYPEs");
        $data['orgsbtyp']=UlsAdminMaster::get_value_names("ORG_SUB_TYPE");
        $data['orgloc']=UlsLocation::fetch_all_locs();
        $data['orgpo']=UlsOrganizationMaster::orgdata_po();
		$data['orgdivi']=UlsOrganizationMaster::org_division();
        $data['orglast']=$orglast;
        $data['emplist']=isset($orglast->org_manager)?!empty($orglast->org_manager)?UlsEmployeeMaster::fetch_emp($orglast->org_manager):array():array();
		$content = $this->load->view('admin/organization_creation',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function empcategory_search(){
		$data["aboutpage"]=$this->pagedetails('admin','empcategorysearch');
		$limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
		$emp_cat_name=filter_input(INPUT_GET,'emp_cat_name') ? filter_input(INPUT_GET,'emp_cat_name'):"";
		$page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
		$start=$page!=0? ($page-1)*$limit:0;
		$filePath=BASE_URL."/admin/empcategory_search";
		$data['limit']=$limit;
		$data['perpages']=UlsMenuCreation::perpage();
		$data['emp_cat_name']=$emp_cat_name;
		$data['grades']=UlsEmployeeCategory::search($start, $limit,$emp_cat_name);
		$total=UlsEmployeeCategory::searchcount($emp_cat_name);
		$otherParams="&perpage=".$limit."&emp_cat_name=".$emp_cat_name;
		$data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/empcategory_search',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function empcategory_creation(){
        $data["aboutpage"]=$this->pagedetails('admin','empcategory_creation');
        $id=isset($_REQUEST['emp_cat_id'])? $_REQUEST['emp_cat_id']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
            $pos_status="STATUS";
            $data['subgradedet']=!empty($id)?Doctrine::getTable('UlsEmployeeCategory')->find($id):array();
            $data['posstatusss']=UlsAdminMaster::get_value_names($pos_status);
			$content = $this->load->view('admin/empcategory_creation',$data,true);
        }
		$this->render('layouts/adminnew',$content);
    }
	
	public function lms_empcategory(){
        if(isset($_POST['emp_cat_id'])){ //print_r($_POST);
            $grade=(!empty($_POST['emp_cat_id']))?Doctrine::getTable('UlsEmployeeCategory')->find($_POST['emp_cat_id']):new UlsEmployeeCategory();
            $grade->emp_cat_name=$_POST['emp_cat_name'];
            $grade->emp_cat_status=$_POST['status'];
			$grade->parent_org_id=$this->session->userdata('parent_org_id');
            $grade->save();
			$this->session->userdata('empcat_msg',"Employee Category data ".(!empty($_POST['emp_cat_id'])?"updated":"inserted")." successfully.");
			redirect("admin/empcategory_view?emp_cat_id=".$grade->emp_cat_id);
        }
        else{
			$content = $this->load->view('admin/empcategory_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }
	
	public function empcategory_view(){
		$data["aboutpage"]=$this->pagedetails('admin','empcategory_view');
        $id=isset($_REQUEST['emp_cat_id'])? $_REQUEST['emp_cat_id']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1 || $id==""){
            $content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
            $data['gradedetails']=UlsEmployeeCategory::viewempcategory($id);
			$content = $this->load->view('admin/empcategory_view',$data,true);
        }
		$this->render('layouts/adminnew',$content);
    }
	
	public function deleteempcategory(){
		$id=trim($_REQUEST['val']);
		if(!empty($id)){
			$uewi=Doctrine_Query::create()->from('UlsEmployeeMaster')->where('emp_cat='.$id)->execute();
			if(count($uewi)==0){
				$q = Doctrine_Query::create()->delete('UlsEmployeeCategory')->where('emp_cat_id=?',$id);	
				$q->execute();
				echo 1;
			}
			else{
				echo "Selected Employee Category cannot be deleted. Ensure you delete all the usages of the Employee Category before you delete it.";
			}
		}
	}
	
	public function emptype_search(){
		$data["aboutpage"]=$this->pagedetails('admin','emptypesearch');
		$limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
		$emp_type_name=filter_input(INPUT_GET,'emp_type_name') ? filter_input(INPUT_GET,'emp_type_name'):"";
		$page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
		$start=$page!=0? ($page-1)*$limit:0;
		$filePath=BASE_URL."/admin/emptype_search";
		$data['limit']=$limit;
		$data['perpages']=UlsMenuCreation::perpage();
		$data['emp_type_name']=$emp_type_name;
		$data['grades']=UlsEmployeeType::search($start, $limit,$emp_type_name);
		$total=UlsEmployeeType::searchcount($emp_type_name);
		$otherParams="&perpage=".$limit."&emp_type_name=".$emp_type_name;
		$data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/emptype_search',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function emptype_creation(){
        $data["aboutpage"]=$this->pagedetails('admin','emptype_creation');
        $id=isset($_REQUEST['emp_type_id'])? $_REQUEST['emp_type_id']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
            $pos_status="STATUS";
            $data['subgradedet']=!empty($id)?Doctrine::getTable('UlsEmployeeType')->find($id):array();
            $data['posstatusss']=UlsAdminMaster::get_value_names($pos_status);
			$content = $this->load->view('admin/emptype_creation',$data,true);
        }
		$this->render('layouts/adminnew',$content);
    }
	
	public function lms_emptype(){
        if(isset($_POST['emp_type_id'])){ //print_r($_POST);
            $grade=(!empty($_POST['emp_type_id']))?Doctrine::getTable('UlsEmployeeType')->find($_POST['emp_type_id']):new UlsEmployeeType();
            $grade->emp_type_name=$_POST['emp_type_name'];
            $grade->emp_type_status=$_POST['status'];
			$grade->parent_org_id=$this->session->userdata('parent_org_id');
            $grade->save();
			$this->session->userdata('emptype_msg',"Employee Type data ".(!empty($_POST['emp_type_id'])?"updated":"inserted")." successfully.");
			redirect("admin/emptype_view?emp_type_id=".$grade->emp_type_id);
        }
        else{
			$content = $this->load->view('admin/emptype_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }
	
	public function emptype_view(){
		$data["aboutpage"]=$this->pagedetails('admin','emptype_view');
        $id=isset($_REQUEST['emp_type_id'])? $_REQUEST['emp_type_id']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1 || $id==""){
            $content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
            $data['gradedetails']=UlsEmployeeType::viewemptype($id);
			$content = $this->load->view('admin/emptype_view',$data,true);
        }
		$this->render('layouts/adminnew',$content);
    }
	
	public function deleteemptype(){
		$id=trim($_REQUEST['val']);
		if(!empty($id)){
			$uewi=Doctrine_Query::create()->from('UlsEmployeeMaster')->where('emp_type='.$id)->execute();
			if(count($uewi)==0){
				$q = Doctrine_Query::create()->delete('UlsEmployeeType')->where('emp_type_id=?',$id);	
				$q->execute();
				echo 1;
			}
			else{
				echo "Selected Employee type cannot be deleted. Ensure you delete all the usages of the Employee type before you delete it.";
			}
		}
	}
	
	public function deletezone(){
		$id=trim($_REQUEST['val']);
		if(!empty($id)){
			//$uom=Doctrine_Query::create()->from('UlsZoneMap')->where('zone_id='.$id)->execute();
			$uec=Doctrine_Query::create()->from('UlsLocation')->where("location_zones='".$id."'")->execute();
			$uewi=Doctrine_Query::create()->from('UlsEmployeeWorkInfo')->where('zone_id='.$id)->execute();
			if(count($uec)==0 && count($uewi)==0){
				$q = Doctrine_Query::create()->delete('UlsZoneMap')->where('zone_id=?',$id)->execute();
				$qq1= Doctrine_Query::create()->delete('UlsZone')->where('zone_id=?',$id)->execute();
				echo 1;
			}
		}
	}
	
	public function delete_zone_state(){
		if(!empty($_REQUEST['val'])){
			$play=Doctrine_Query::Create()->delete('UlsZoneMap')->where("map_id=".$_REQUEST['val'])->execute();
			echo 1;
		}
		else{
			echo "Selected Zone cannot be deleted. Ensure you delete all the usages of the Zone before you delete it.";
		}
	}
	
	public function zone_search()
	{
		$data["aboutpage"]=$this->pagedetails('admin','zonesearch');
        $limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
        $zonename=filter_input(INPUT_GET,'zonename') ? filter_input(INPUT_GET,'zonename'):"";
        $page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
        $start=$page!=0? ($page-1)*$limit:0;
        $filePath=BASE_URL."/admin/zone_search";
        $data['limit']=$limit;
        $data['perpages']=UlsMenuCreation::perpage();
        $data['zonename']=$zonename;
        $data['zones']=UlsZone::search($start, $limit,$zonename);
        $total=UlsZone::searchcount($zonename);
        $otherParams="&perpage=".$limit."&zonename=".$zonename;
        $data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/zone_search',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function zone_creation()
	{
		$data["aboutpage"]=$this->pagedetails('admin','zone_creation');
        $id=isset($_REQUEST['zone_id'])? $_REQUEST['zone_id']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1 && !empty($id)==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			if(!empty($_REQUEST['zone_id'])){
				$data['zonedetail']=UlsZone::zone_view($_REQUEST['zone_id']);
				$data['zonelocations']=UlsZoneMap::zone_states($_REQUEST['zone_id']);
			}
			$states=UlsStates::get_states();
			$data['locroles']=$states;
			$data['states']=$states;
			$content = $this->load->view('admin/zone_creation',$data,true);
        }
		$this->render('layouts/adminnew',$content);
	}

	/*
     * Modified by Srikanth insert/update loction
    */
    public function lms_zone(){
        if(isset($_POST['zone_id'])){
			//print_r($_POST);
            $fieldinsertupdates=array('zone_name');
            $sessionvars=array('parent_org_id');
            $zone=Doctrine::getTable('UlsZone')->find($_POST['zone_id']);
            !isset($zone->zone_id)?$zone=new UlsZone():"";
            foreach($fieldinsertupdates as $val){
				$zone->$val=(!empty($_POST[$val]))?($_POST[$val]):NULL;
			}
            foreach($sessionvars as $val){$zone->$val=$_SESSION[$val];}
            $zone->save();
			if(!empty($_POST['role_type'])){
				foreach($_POST['role_type'] as $key=>$values){
					$zonemap=(!empty($_POST['loc_role_id'][$key]))?Doctrine::getTable('UlsZoneMap')->find($_POST['loc_role_id'][$key]): new UlsZoneMap();
					$zonemap->zone_id=$zone->zone_id;
					$zonemap->parent_org_id=$_SESSION['parent_org_id'];
					$zonemap->state_id=(!empty($_POST['role_type'][$key]))?$_POST['role_type'][$key]:"";
					$zonemap->save();
				}
			}
			$this->session->set_flashdata('zone_msg',"Zone data ".(!empty($_POST['zone_id'])?"updated":"inserted")." successfully.");
			redirect("admin/zone_view?zone_id=".$zone->zone_id."&hash=".md5(SECRET.$zone->zone_id));
        }
        else{
			$content = $this->load->view('admin/zone_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }

	 /*
     * Modified by Srikanth view loction insertion page
    */
    public function zone_view(){
		$data["aboutpage"]=$this->pagedetails('admin','zones');
        $id=isset($_REQUEST['zone_id'])? $_REQUEST['zone_id']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1 || $id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
            $data['zonedetail']=UlsZone::zone_view($id);
			$data['zonestates']=UlsZoneMap::zones_states($id);
			$content = $this->load->view('admin/zone_view',$data,true);
        }
		$this->render('layouts/adminnew',$content);
    }


	public function location_search()
	{
		$data["aboutpage"]=$this->pagedetails('admin','locationsearch');
        $limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
        $locname=filter_input(INPUT_GET,'locname') ? filter_input(INPUT_GET,'locname'):"";
        $page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
        $start=$page!=0? ($page-1)*$limit:0;
        $filePath=BASE_URL."/admin/location_search";
        $data['limit']=$limit;
        $data['perpages']=UlsMenuCreation::perpage();
        $data['locname']=$locname;
        $data['locations']=UlsLocation::search($start, $limit,$locname);
        $total=UlsLocation::searchcount($locname);
        $otherParams="&perpage=".$limit."&locname=".$locname;
        $data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/location_search',$data,true);
		$this->render('layouts/adminnew',$content);
	}

	public function location_creation()
	{
		$data["aboutpage"]=$this->pagedetails('admin','location_creation');
        $id=isset($_REQUEST['locid'])? $_REQUEST['locid']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1 && !empty($id)==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			if(!empty($_REQUEST['locid'])){
				$location=UlsLocation::getloc($_REQUEST['locid']);
				$data['locdetail']=UlsLocation::location_view($_REQUEST['locid']);;
			}
            $loc_status="STATUS";
            $locations="COUNTRY";
			$roles="LOC_ROLES";
			$zones="LOCATION_ZONES";
			$data['bus']=UlsOrganizationMaster::business_units();
			$data['locat_zones']=UlsZone::getzones();//UlsAdminMaster::get_value_names($zones);
            $data['locatns']=UlsAdminMaster::get_value_names($locations);
            $data['locstatusss']=UlsAdminMaster::get_value_names($loc_status);
			$data['locroles']=UlsAdminMaster::get_value_names($roles);
			$data['states']=!empty($id)?UlsZoneMap::zones_states($location['location_zones']):array();
			$content = $this->load->view('admin/location_creation',$data,true);
        }
		$this->render('layouts/adminnew',$content);
	}

	/*
     * Modified by Srikanth insert/update loction
    */
    public function lms_location(){
        if(isset($_POST['location_id'])){
			//print_r($_POST);
            $fieldinsertupdates=array('location_name','bu_id','address_1','address_2','po_box','city','state','country','status','location_zones');//$datefields=array('start_date_active','end_date_active');
            $sessionvars=array('parent_org_id');
            $location=Doctrine::getTable('UlsLocation')->find($_POST['location_id']);
            !isset($location->location_id)?$location=new UlsLocation():"";
            foreach($fieldinsertupdates as $val){
				$location->$val=(!empty($_POST[$val]))?($_POST[$val]):NULL;
			}
            //foreach($datefields as $val){$location->$val=(!empty($_POST[$val]))?date("Y-m-d", strtotime($_POST[$val])):NULL;}
            foreach($sessionvars as $val){$location->$val=$_SESSION[$val];}
            $location->save();
			/*if(!empty($_POST['role_type'])){
				foreach($_POST['role_type'] as $key=>$values){
					$work_details=(!empty($_POST['loc_role_id'][$key]))?Doctrine::getTable('UlsLocationRoles')->find($_POST['loc_role_id'][$key]): new UlsLocationRoles();
					$work_details->location_id=$location->location_id;
					$work_details->parent_org_id=$_SESSION['parent_org_id'];
					$work_details->role_value_code=(!empty($_POST['role_type'][$key]))?$_POST['role_type'][$key]:"";
					$work_details->role_employee_id=(!empty($_POST['employee_number'][$key]))?$_POST['employee_number'][$key]:"";
					$work_details->save();
				}
			}*/
			$this->session->set_flashdata('loc_msg',"Location data ".(!empty($_POST['location_id'])?"updated":"inserted")." successfully.");
			redirect("admin/location_view?locid=".$location->location_id."&hash=".md5(SECRET.$location->location_id));
        }
        else{
			$content = $this->load->view('admin/location_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }

	 /*
     * Modified by Srikanth view loction insertion page
    */
    public function location_view(){
		$data["aboutpage"]=$this->pagedetails('admin','location');
        $id=isset($_REQUEST['locid'])? $_REQUEST['locid']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1 || $id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
            $data['locdetail']=UlsLocation::location_view($id);
			$content = $this->load->view('admin/lms_admin_location_view',$data,true);
        }
		$this->render('layouts/adminnew',$content);
    }


	public function zone_states(){
		$zone_id=$_REQUEST['zone_id'];
		$zones=UlsZoneMap::zones_states($zone_id);
		$data="";
		$data.="<select  id='state' name='state' class='validate[required] form-control m-b'><option value=''>Select</option>";
		foreach($zones as $zoness){
			$data.="<option value='".$zoness['state_id']."'>".$zoness['state_name']."</option>";
		}
		$data.="</select>";
		echo $data;
	}

	public function getdepposition(){
		$department=$_REQUEST['department'];
		$id=$_REQUEST['id'];
		echo "<label class='control-label mb-10 text-left'>Position</label>
		<select class='form-control m-b' id='position$id' name='position$id' onchange='getpositiondetails($id)' style='width: 100%'>
		<option value=''>Select</option>";
		$positions=UlsMenu::callpdo("SELECT a.* FROM uls_position a  WHERE (a.position_org_id =$department AND a.status = 'A') order by a.position_name asc ");
		foreach($positions as $position){
			echo "<option value='".$position['position_id']."'>".$position['position_name']."</option>";
		}
		echo "</select>";
	}
	
	public function getbudepart(){
		$bus=$_REQUEST['bus'];
		$id=$_REQUEST['id'];
		echo "<label class='control-label mb-10 text-left'>Department</label>
		<select class='form-control m-b' id='department$id' name='department$id' onchange='getposition($id)' style='width: 100%'>
		<option value=''>Select</option>";
		$deps=UlsMenu::callpdo("SELECT `organization_id`,`org_name` FROM `uls_organization_master` WHERE `organization_id` in (SELECT distinct(`position_org_id`) FROM `uls_position` WHERE `bu_id`=$bus and `position_org_id` is not null) order by org_name asc");
		foreach($deps as $dep){
			echo "<option value='".$dep['organization_id']."'>".$dep['org_name']."</option>";
		}
		echo "</select>";
	}
	
	public function getdeppositiondet(){
		$id=$_REQUEST['id'];
		$posdetails=UlsPosition::viewposition($id);
		$data['posdetails']=$posdetails;
		$data['competencies']=UlsCompetencyPositionRequirements::getcompetencypositionrequirements($id);
		$data['kras']=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($id);		
		$content = $this->load->view('admin/position_compareview',$data,true);
		$this->render('layouts/ajax-layout',$content);
	}
	
	public function compareposition(){
		$data["aboutpage"]=$this->pagedetails('admin','compareposition');
		$data['departments']=UlsOrganizationMaster::org_depart();
		$data['business']=UlsMenu::callpdo("SELECT `organization_id`,`org_name` FROM `uls_organization_master` WHERE `organization_id` in (SELECT DISTINCT(`bu_id`) FROM `uls_position` WHERE 1 and bu_id is not null)");
		$content = $this->load->view('admin/position_compare',$data,true);
		$this->render('layouts/adminnew',$content);
	}

	public function position_search()
	{	//print_r($this->session);
		$data["aboutpage"]=$this->pagedetails('admin','positionsearch');
        $limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
        $pos_name=filter_input(INPUT_GET,'pos_name') ? filter_input(INPUT_GET,'pos_name'):"";
		//$position_type=filter_input(INPUT_GET,'position_type') ? filter_input(INPUT_GET,'position_type'):"";
		$position_type=isset($_SESSION['emp_type'])?$_SESSION['emp_type']:"";
		$department=filter_input(INPUT_GET,'department') ? filter_input(INPUT_GET,'department'):"";
		$location=filter_input(INPUT_GET,'location') ? filter_input(INPUT_GET,'location'):"";
        $page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
        $start=$page!=0? ($page-1)*$limit:0;
        $filePath=BASE_URL."/admin/position_search";
        $data['limit']=$limit;
        $data['perpages']=UlsMenuCreation::perpage();
		$data['pos_types']=UlsAdminMaster::get_value_names("POSTYPE");
		$data['position_type']=$position_type;
        $data['pos_name']=$pos_name;
		$data['depart']=$department;
		$data['location']=$location;
		$data['departments']=UlsOrganizationMaster::org_depart();
		$data['pos_locations']=UlsLocation::fetch_all_locss();
        $data['positions']=UlsPosition::search($start, $limit,$pos_name,$position_type,$department,$location);
        $total=UlsPosition::searchcount($pos_name,$position_type,$department,$location);
        $otherParams="perpage=".$limit."&pos_name=".$pos_name."&position_type=".$position_type."&department=".$department."&location=".$location;
        $data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/position_search',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function position_archive_search()
	{
		$data["aboutpage"]=$this->pagedetails('admin','positionsearch_archive');
        $limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
        $pos_name=filter_input(INPUT_GET,'pos_name') ? filter_input(INPUT_GET,'pos_name'):"";
		//$position_type=filter_input(INPUT_GET,'position_type') ? filter_input(INPUT_GET,'position_type'):"";
		$position_type=isset($_SESSION['emp_type'])?$_SESSION['emp_type']:"";
		$department=filter_input(INPUT_GET,'department') ? filter_input(INPUT_GET,'department'):"";
		$location=filter_input(INPUT_GET,'location') ? filter_input(INPUT_GET,'location'):"";
        $page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
        $start=$page!=0? ($page-1)*$limit:0;
        $filePath=BASE_URL."/admin/position_archive_search";
        $data['limit']=$limit;
        $data['perpages']=UlsMenuCreation::perpage();
		$data['pos_types']=UlsAdminMaster::get_value_names("POSTYPE");
		$data['position_type']=$position_type;
        $data['pos_name']=$pos_name;
		$data['depart']=$department;
		$data['location']=$location;
		$data['departments']=UlsOrganizationMaster::org_depart();
		$data['pos_locations']=UlsLocation::fetch_all_locss();
        $data['positions']=UlsPositionArchive::search($start, $limit,$pos_name,$position_type,$department,$location);
        $total=UlsPositionArchive::searchcount($pos_name,$position_type,$department,$location);
        $otherParams="perpage=".$limit."&pos_name=".$pos_name."&position_type=".$position_type."&department=".$department."&location=".$location;
        $data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/position_archive_search',$data,true);
		$this->render('layouts/adminnew',$content);
	}

	public function position_creation()
	{
		$data["aboutpage"]=$this->pagedetails('admin','position_update');
        $pos_status="STATUS";
        $data['posstatusss']=UlsAdminMaster::get_value_names($pos_status);
        $data['pos_org_name']=UlsOrganizationMaster::org_depart();
		$content = $this->load->view('admin/position_creation',$data,true);
		$this->render('layouts/adminnew',$content);
	}

	public function position_update(){
        $data["aboutpage"]=$this->pagedetails('admin','position_update');
        $id=isset($_REQUEST['posid'])? $_REQUEST['posid']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			if(!empty($id)){
				$position=Doctrine_Query::Create()->from('UlsCompetencyPositionRequirements')->where('comp_position_id='.$id)->execute();
				$data['positiondetails']=$position;
				$data['competency']=UlsCompetencyPositionRequirements::getcompetencypositionrequirements($id);
				$data['kra_comp']=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($id);
				$data['kra_comp_master']=UlsCompetencyPositionRequirementsKra::getcompetencyposition_requirementskra($id);
				$data['posdetails']=Doctrine::getTable('UlsPosition')->findOneByPosition_id($id);
			}
			$data['competencymsdetails']=UlsCompetencyDefinition::competency_details("MS");
			$data['competencynmsdetails']=UlsCompetencyDefinition::competency_details("NMS");
			//$data['competencydetails']=UlsCompetencyDefinition::competency_details();
			$pos_type="POSTYPE";
			$data['pos_types']=UlsAdminMaster::get_value_names($pos_type);
            $pos_status="STATUS";
			$data['positions']=UlsPosition::fetch_all_pos();
			$data['str_positions']=UlsPosition::pos_stru_details();
			$data['criticalities']=UlsCompetencyCriticality::criticality_names();
            $data['parent_date']=Doctrine::getTable('UlsOrganizationMaster')->find($_SESSION['parent_org_id']);
            $data['posstatusss']=UlsAdminMaster::get_value_names($pos_status);
            $data['pos_org_name']=UlsOrganizationMaster::org_depart();
			$data['pos_bu_name']=UlsOrganizationMaster::org_bu();
			$data['pos_locations']=UlsLocation::fetch_all_locss();
			$data['grades']=UlsGrade::fetch_all_grades();
			$data['pos_str']=UlsAdminMaster::get_value_names("POS_ASS");
			$content = $this->load->view('admin/position_update',$data,true);
        }
		$this->render('layouts/adminnew',$content);
    }
	
	public function position_update_clone(){
        if(isset($_REQUEST['posid'])){
			$pos_details=UlsPosition::pos_details($_REQUEST['posid']);
			$position_archive=UlsPositionArchive::pos_archive($_REQUEST['posid']);
			$pos_count=(count($position_archive)+1);
			$position=new UlsPosition();
			$position->parent_org_id=$pos_details['parent_org_id'];
			$position->position_name=$pos_details['position_name']."- Duplicate";
			$position->position_code=!empty($pos_details['position_code'])?$pos_details['position_code']:NULL;
			$position->position_org_id=!empty($pos_details['position_org_id'])?$pos_details['position_org_id']:NULL;
			$position->status=!empty($pos_details['status'])?$pos_details['status']:NULL;
			$position->education=!empty($pos_details['education'])?$pos_details['education']:NULL;
			$position->experience=!empty($pos_details['experience'])?$pos_details['experience']:NULL;
			$position->specific_experience=!empty($pos_details['specific_experience'])?$pos_details['specific_experience']:NULL;
            $position->other_requirement=!empty($pos_details['other_requirement'])?$pos_details['other_requirement']:NULL;
			$position->position_desc=!empty($pos_details['position_desc'])?$pos_details['position_desc']:NULL;
			$position->accountablities=!empty($pos_details['accountablities'])?$pos_details['accountablities']:NULL;
			$position->responsibilities=!empty($pos_details['responsibilities'])?$pos_details['responsibilities']:NULL;
			$position->position_structure=!empty($pos_details['position_structure'])?$pos_details['position_structure']:NULL;
			$position->position_structure_id=!empty($pos_details['position_structure_id'])?$pos_details['position_structure_id']:NULL;
			$position->bu_id=!empty($pos_details['bu_id'])?$pos_details['bu_id']:NULL;
			$position->grade_id=!empty($pos_details['grade_id'])?$pos_details['grade_id']:NULL;
			$position->organization_id=!empty($pos_details['organization_id'])?$pos_details['organization_id']:NULL;
			$position->location_id=!empty($pos_details['location_id'])?$pos_details['location_id']:NULL;
			$position->reports_to=!empty($pos_details['reports_to'])?$pos_details['reports_to']:NULL;
			$position->reportees=!empty($pos_details['reportees'])?$pos_details['reportees']:NULL;
			$position->position_type=!empty($pos_details['position_type'])?$pos_details['position_type']:NULL;
			$position->version_id=$pos_count;
            $position->Save();
			$position_competency=Doctrine_Query::Create()->from('UlsCompetencyPositionRequirements')->where('comp_position_id='.$_REQUEST['posid'])->execute();
			foreach($position_competency as $position_competencys){
				if(!empty($position_competencys->comp_position_competency_id)){
					$work_details_level=new UlsCompetencyPositionRequirements();
					$work_details_level->comp_position_competency_id=$position_competencys->comp_position_competency_id;
					$work_details_level->comp_position_level_id=$position_competencys->comp_position_level_id;
					$work_details_level->comp_position_level_scale_id=$position_competencys->comp_position_level_scale_id;
					$work_details_level->comp_position_criticality_id=$position_competencys->comp_position_criticality_id;
					$work_details_level->comp_position_id=$position->position_id;
					$work_details_level->version_id=$pos_count;
					$work_details_level->save();
				}
			}
			$kra_comp=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($_REQUEST['posid']);
			foreach($kra_comp as $kra_comps){
				if(!empty($kra_comps['comp_kra_steps'])){
					$work_details_kra=new UlsCompetencyPositionRequirementsKra();
					$work_details_kra->comp_position_id=$position->position_id;
					$work_details_kra->comp_kra_steps=$kra_comps['comp_kra_steps'];
					$work_details_kra->kra_kri=$kra_comps['kra_kri'];
					$work_details_kra->kra_uom=$kra_comps['kra_uom'];
					$work_details_kra->version_id=$pos_count;
					$work_details_kra->save();
				}
			}
			$this->session->set_flashdata('pos_message',"Position data ".(!empty($_POST['pos_id'])?"updated":"inserted")." successfully.");
			redirect("admin/position_update?eve_stat&var=1&posid=".$position->position_id.'&hash='.md5(SECRET.$position->position_id));
        }
        else{
			$content = $this->load->view('admin/position_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }

	public function position_competency(){
		$com_id=$_REQUEST['com_id'];
		$row_id=isset($_REQUEST['r_id'])?$_REQUEST['r_id']:"";
		$aa="";
		if(empty($row_id)){
			$level=UlsCompetencyDefinition::viewcompetency($com_id);
			$aa.="<select name='comp_position_level_id' id='comp_position_level_id' class='form-control m-b validate[required]'>
				<option value=''>Select</option>
				<option value='".$level['comp_def_level']."'>".$level['level']."</option>";
			$aa.="</select>";
		}
		if(!empty($com_id) && !empty($row_id)){
			//$levels=Doctrine_Query::Create()->from('UlsCompetencyLevels')->where('comp_competency_id='.$com_id)->execute();
			$level=UlsCompetencyDefinition::viewcompetency($com_id);
			$aa.="<select name='comp_position_level_id[]' id='comp_position_level_id_".$row_id."' style='width:100%;' class='form-control m-b' onchange='pos_scale_details(".$row_id.")'>
				<option value=''>Select</option>
				<option value='".$level['comp_def_level']."'>".$level['level']."</option>";
			$aa.="</select>";
		}
		echo $aa;
	}
	
	public function position_competency_scale(){
		$com_id=$_REQUEST['com_id'];
		$row_id=isset($_REQUEST['r_id'])?$_REQUEST['r_id']:"";
		$aa="";
		if(empty($row_id)){
			$level=UlsCompetencyDefinition::viewcompetency($com_id);
			$scales=UlsLevelMasterScale::levelscale($level['comp_def_level']);
			$aa.="<input type='hidden' name='comp_position_level_id' id='comp_position_level_id' value='".$level['comp_def_level']."'>";
			$aa.="<select name='comp_position_level_scale_id' id='comp_position_level_scale_id' class='form-control m-b validate[required]'>
				<option value=''>Select</option>";
				foreach($scales as $scale){
					$aa.="<option value='".$scale['scale_id']."'>".$scale['scale_name']."</option>";
				}
			$aa.="</select>";
		}
		if(!empty($com_id) && !empty($row_id)){
			//$levels=Doctrine_Query::Create()->from('UlsCompetencyLevels')->where('comp_competency_id='.$com_id)->execute();
			$level=UlsCompetencyDefinition::viewcompetency($com_id);
			$scales=UlsLevelMasterScale::levelscale($level['comp_def_level']);
			$aa.="<input type='hidden' name='comp_position_level_id[]' id='comp_position_level_id_".$row_id."' value='".$level['comp_def_level']."'>";
			$aa.="<select name='comp_position_level_scale_id[]' id='comp_position_level_scale_id_".$row_id."' style='width:100%;' class='form-control m-b' onchange='pos_scale_details(".$row_id.")'>
				<option value=''>Select</option>";
				foreach($scales as $scale){
					$aa.="<option value='".$scale['scale_id']."'>".$scale['scale_name']."</option>";
				}
			$aa.="</select>";
		}
		echo $aa;
	}

	public function position_scale_competency(){
		$level_id=$_REQUEST['level_id'];
		$row_id=isset($_REQUEST['r_id'])?$_REQUEST['r_id']:"";
		$aa="";
		if(empty($row_id)){
			$scales=UlsLevelMasterScale::levelscale($level_id);
			$aa.="<select name='comp_position_level_scale_id' id='comp_position_level_scale_id' class='form-control m-b validate[required]'>
			<option value=''>Select</option>";
			foreach($scales as $scale){
				$aa.="<option value='".$scale['scale_id']."'>".$scale['scale_name']."</option>";
			}
			$aa.="</select>";
		}
		if(!empty($level_id) && !empty($row_id)){
			$scales=UlsLevelMasterScale::levelscale($level_id);
			$aa.="<select name='comp_position_level_scale_id[]' id='comp_position_level_scale_id_".$row_id."' style='width:100%;' class='form-control m-b'>
			<option value=''>Select</option>";
			foreach($scales as $scale){
				$aa.="<option value='".$scale['scale_id']."'>".$scale['scale_name']."</option>";
			}
			$aa.="</select>";
		}
		echo $aa;
	}



	public function deleteposition(){
		$id=trim($_REQUEST['val']);
		if(!empty($id)){
			$uewi=Doctrine_Query::create()->from('UlsEmployeeWorkInfo')->where('position_id='.$id)->execute();
			if(count($uewi)==0){
				$q = Doctrine_Query::create()->delete('UlsPosition')->where('position_id=?',$id);
				$q->execute();
				echo 1;
			}
			else{
				echo "Selected Position cannot be deleted. Ensure you delete all the usages of the Position before you delete it.";
			}
		}
	}
	
	public function deletetecompetencylevels(){
		$id=trim($_REQUEST['id']);
		if(!empty($id)){
			//$uewi=Doctrine_Query::create()->from('UlsEmployeeWorkInfo')->where('position_id='.$id)->execute();
			//if(count($uewi)==0){
				$q = Doctrine_Query::create()->delete('UlsCompetencyPositionRequirements')->where('comp_position_req_id=?',$id);
				$q->execute();
				echo 1;
			//}
		}
		else{
			echo "Selected Competency Level cannot be deleted. Ensure you delete all the usages of the Competency Level before you delete it.";
		}
	}

	public function lms_position(){
        if(isset($_POST['pos_id'])){
            $fieldinsertupdates=array('position_name','position_code','position_org_id','status','education','experience','specific_experience','other_requirement','position_desc','accountablities','responsibilities','position_structure');
            $sessionvars=array('parent_org_id');
			$position_archive=UlsPositionArchive::pos_archive($_POST['pos_id']);
			$pos_count=(count($position_archive)+1);
            $position=Doctrine::getTable('UlsPosition')->findOneByPosition_id($_POST['pos_id']);
            !isset($position->position_id)?$position=new UlsPosition():"";
            foreach($fieldinsertupdates as $val){$position->$val=!empty($_POST[$val])?$_POST[$val]:NULL;}
            foreach($sessionvars as $val){$position->$val=$_SESSION[$val];}
			$position->bu_id=isset($_POST['bu_id'])?!empty($_POST['bu_id'])?$_POST['bu_id']:NULL:NULL;
			$position->grade_id=isset($_POST['grade_id'])?!empty($_POST['grade_id'])?$_POST['grade_id']:NULL:NULL;
			$position->location_id=isset($_POST['location_id'])?implode(",",$_POST['location_id']):NULL;
			$position->reports_to=isset($_POST['reports_to'])?implode(",",$_POST['reports_to']):NULL;
			$position->reportees=isset($_POST['reportees'])?implode(",",$_POST['reportees']):NULL;
			$position->position_type=isset($_POST['position_type'])?!empty($_POST['position_type'])?$_POST['position_type']:NULL:NULL;
			if($_POST['position_structure']=='A'){
				$position->position_structure_id=isset($_POST['position_structure_id'])?!empty($_POST['position_structure_id'])?$_POST['position_structure_id']:NULL:NULL;
			}
			if($_POST['position_structure']=='S'){
				$position->position_structure_id=NULL;
			}
			$position->version_id=$pos_count;
            $position->Save();
			if(!empty($_POST['comp_position_competency_id'])){
				$attachinsrtupdt=array('comp_position_competency_id', 'comp_position_level_id', 'comp_position_level_scale_id','comp_position_criticality_id');
				foreach($_POST['comp_position_competency_id'] as $key=>$value){
					if(!empty($_POST['comp_position_competency_id'][$key])){
						$work_details_level=(!empty($_POST['comp_position_req_id'][$key]))?Doctrine::getTable('UlsCompetencyPositionRequirements')->find($_POST['comp_position_req_id'][$key]):new UlsCompetencyPositionRequirements;
						$work_details_level->comp_position_id=$position->position_id;
						foreach($attachinsrtupdt as $att_val){
							 !empty($_POST[$att_val][$key])?$work_details_level->$att_val=trim($_POST[$att_val][$key]):Null;
						}
						$work_details_level->version_id=$pos_count;
						/* $work_details_level->state_level=1;
						$work_details_level->state_history='C'; */
						$work_details_level->save();
					}
				}
			}
			if(!empty($_POST['comp_kra_steps'])){
				/* echo "<pre>";
				print_r($_POST); */
				$attachinsrtupdts=array('comp_kra_steps','kra_kri','kra_uom');
				foreach($_POST['comp_kra_steps'] as $key1=>$value){
					if(!empty($_POST['comp_kra_steps'][$key1])){
						$work_details_kra=(!empty($_POST['comp_kra_id'][$key1]))?Doctrine::getTable('UlsCompetencyPositionRequirementsKra')->find($_POST['comp_kra_id'][$key1]):new UlsCompetencyPositionRequirementsKra;
						$work_details_kra->comp_position_id=$position->position_id;
						/* $work_details_kra->comp_position_competency_id=!empty($_POST['comp_position_competency_id_kra'][$key1])?$_POST['comp_position_competency_id_kra'][$key1]:NULL; */
						foreach($attachinsrtupdts as $att_vals){
							 !empty($_POST[$att_vals][$key1])?$work_details_kra->$att_vals=trim($_POST[$att_vals][$key1]):Null;
						}
						$work_details_kra->version_id=$pos_count;
						$work_details_kra->save();
					}
				}
			}
			$this->session->set_flashdata('pos_message',"Position data ".(!empty($_POST['pos_id'])?"updated":"inserted")." successfully.");
			redirect("admin/position_view?posid=".$position->position_id);
        }
        else{
			$content = $this->load->view('admin/position_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }
	
	public function lms_position_archive(){
        if(isset($_POST['pos_id'])){
			$position_ach=Doctrine::getTable('UlsPosition')->findOneByPosition_id($_POST['pos_id']);
			$position_archive=Doctrine::getTable('UlsPositionArchive')->findOneByPosition_id($_POST['pos_id']);
            if(empty($position_archive['position_id'])){
				$positionarchive=new UlsPositionArchive();
				$positionarchive->position_id=$position_ach->position_id;
				$positionarchive->version_id=$position_ach->version_id;
				$positionarchive->position_code=$position_ach->position_code;
				$positionarchive->position_type=$position_ach->position_type;
				$positionarchive->position_name=$position_ach->position_name;
				$positionarchive->grade_id=$position_ach->grade_id;
				$positionarchive->bu_id=$position_ach->bu_id;
				$positionarchive->organization_id=$position_ach->organization_id;
				$positionarchive->location_id=$position_ach->location_id;
				$positionarchive->position_concate=$position_ach->position_concate;
				$positionarchive->start_date_active=$position_ach->start_date_active;
				$positionarchive->end_date_active=$position_ach->end_date_active;
				$positionarchive->status=$position_ach->status;
				$positionarchive->position_desc=$position_ach->position_desc;
				$positionarchive->accountablities=$position_ach->accountablities;
				$positionarchive->responsibilities=$position_ach->responsibilities;
				$positionarchive->reports_to=$position_ach->reports_to;
				$positionarchive->reportees=$position_ach->reportees;
				$positionarchive->education=$position_ach->education;
				$positionarchive->experience=$position_ach->experience;
				$positionarchive->specific_experience=$position_ach->specific_experience;
				$positionarchive->other_requirement=$position_ach->other_requirement;
				$positionarchive->save();
				$position_archive_comps=UlsCompetencyPositionRequirements::get_competency_position_details($_POST['pos_id']);
				$position_archive_comp_details=UlsPositionCompetencyArchive::get_competency_arc_position_details($_POST['pos_id']);
				if(count($position_archive_comp_details)==0){
					foreach($position_archive_comps as $position_archive_comp){
						$positionarchive_comp=new UlsPositionCompetencyArchive();
						$positionarchive_comp->comp_position_req_id=$position_archive_comp['comp_position_req_id'];
						$positionarchive_comp->version_id=$position_archive_comp['version_id'];
						$positionarchive_comp->comp_position_id=$position_archive_comp['comp_position_id'];
						$positionarchive_comp->comp_position_competency_id=$position_archive_comp['comp_position_competency_id'];
						$positionarchive_comp->comp_position_level_id=$position_archive_comp['comp_position_level_id'];
						$positionarchive_comp->comp_position_level_scale_id=$position_archive_comp['comp_position_level_scale_id'];
						$positionarchive_comp->comp_position_criticality_id=$position_archive_comp['comp_position_criticality_id'];
						$positionarchive_comp->save();
					}
				}
				$position_archive_kras=UlsCompetencyPositionRequirementsKra::getcompetency_positionrequirementskra($_POST['pos_id']);
				$position_archive_kra_details=UlsPositionKraArchive::getcompetencypositionrequirementskra_arc($_POST['pos_id']);
				if(count($position_archive_kra_details)==0){
					foreach($position_archive_kras as $position_archive_kra){
						$positionarchive_kra=new UlsPositionKraArchive();
						$positionarchive_kra->comp_kra_id=$position_archive_kra['comp_kra_id'];
						$positionarchive_kra->version_id=$position_archive_kra['version_id'];
						$positionarchive_kra->comp_position_competency_id=$position_archive_kra['comp_position_competency_id'];
						$positionarchive_kra->comp_position_id=$position_archive_kra['comp_position_id'];
						$positionarchive_kra->comp_kra_dimensions=$position_archive_kra['comp_kra_dimensions'];
						$positionarchive_kra->comp_kra_steps=$position_archive_kra['comp_kra_steps'];
						$positionarchive_kra->kra_kri=$position_archive_kra['kra_kri'];
						$positionarchive_kra->kra_uom=$position_archive_kra['kra_uom'];
						$positionarchive_kra->save();
					}
				}
			}
			
            $fieldinsertupdates=array('position_name','position_code','position_org_id','status','education','experience','specific_experience','other_requirement','position_desc','accountablities');
            $sessionvars=array('parent_org_id');
			$position_archive=UlsPositionArchive::pos_archive($_POST['pos_id']);
			$pos_count=(count($position_archive)+1);
            $position=Doctrine::getTable('UlsPosition')->findOneByPosition_id($_POST['pos_id']);
            !isset($position->position_id)?$position=new UlsPosition():"";
            foreach($fieldinsertupdates as $val){$position->$val=!empty($_POST[$val])?$_POST[$val]:NULL;}
            foreach($sessionvars as $val){$position->$val=$_SESSION[$val];}
			$position->bu_id=isset($_POST['bu_id'])?!empty($_POST['bu_id'])?$_POST['bu_id']:NULL:NULL;
			$position->grade_id=isset($_POST['grade_id'])?!empty($_POST['grade_id'])?$_POST['grade_id']:NULL:NULL;
			$position->location_id=isset($_POST['location_id'])?implode(",",$_POST['location_id']):NULL;
			$position->reports_to=isset($_POST['reports_to'])?implode(",",$_POST['reports_to']):NULL;
			$position->reportees=isset($_POST['reportees'])?implode(",",$_POST['reportees']):NULL;
			$position->position_type=isset($_POST['position_type'])?!empty($_POST['position_type'])?$_POST['position_type']:NULL:NULL;
			$position->version_id=$pos_count;
            $position->Save();
			if(!empty($_POST['comp_position_competency_id'])){
				$attachinsrtupdt=array('comp_position_competency_id', 'comp_position_level_id', 'comp_position_level_scale_id','comp_position_criticality_id');
				foreach($_POST['comp_position_competency_id'] as $key=>$value){
					if(!empty($_POST['comp_position_competency_id'][$key])){
						$work_details_level=(!empty($_POST['comp_position_req_id'][$key]))?Doctrine::getTable('UlsCompetencyPositionRequirements')->find($_POST['comp_position_req_id'][$key]):new UlsCompetencyPositionRequirements;
						$work_details_level->comp_position_id=$position->position_id;
						foreach($attachinsrtupdt as $att_val){
							 !empty($_POST[$att_val][$key])?$work_details_level->$att_val=trim($_POST[$att_val][$key]):Null;
						}
						$work_details_level->version_id=$pos_count;
						/* $work_details_level->state_level=1;
						$work_details_level->state_history='C'; */
						$work_details_level->save();
					}
				}
			}
			if(!empty($_POST['comp_kra_steps'])){
				/* echo "<pre>";
				print_r($_POST); */
				$attachinsrtupdts=array('comp_kra_steps','kra_kri','kra_uom');
				foreach($_POST['comp_kra_steps'] as $key1=>$value){
					if(!empty($_POST['comp_kra_steps'][$key1])){
						$work_details_kra=(!empty($_POST['comp_kra_id'][$key1]))?Doctrine::getTable('UlsCompetencyPositionRequirementsKra')->find($_POST['comp_kra_id'][$key1]):new UlsCompetencyPositionRequirementsKra;
						$work_details_kra->comp_position_id=$position->position_id;
						/* $work_details_kra->comp_position_competency_id=!empty($_POST['comp_position_competency_id_kra'][$key1])?$_POST['comp_position_competency_id_kra'][$key1]:NULL; */
						foreach($attachinsrtupdts as $att_vals){
							 !empty($_POST[$att_vals][$key1])?$work_details_kra->$att_vals=trim($_POST[$att_vals][$key1]):Null;
						}
						$work_details_kra->version_id=$pos_count;
						$work_details_kra->save();
					}
				}
			}
			$this->session->set_flashdata('pos_message',"Position data ".(!empty($_POST['pos_id'])?"updated":"inserted")." successfully.");
			redirect("admin/position_view?posid=".$position->position_id);
        }
        else{
			$content = $this->load->view('admin/position_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }
	
	public function positionpdf(){
		$this->load->library('tcpdf');
		$this->load->library('pdfgenerator');
		$id=isset($_REQUEST['posid'])? $_REQUEST['posid']:"";
		$hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
		$flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
		if($flag==1 || $id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$posdetails=UlsPosition::viewposition($_REQUEST['posid']);
			$data['posdetails']=$posdetails;
			$data['category']=UlsCompetencyPositionRequirements::category_comp_details($_REQUEST['posid']);
			$data['scale_info_four']=UlsLevelMasterScale::scale_values_level_four();
			$data['scale_info_five']=UlsLevelMasterScale::scale_values_level_five();
			$data['cri_info']=UlsCompetencyCriticality::criticality_names();
			$data['kras']=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($_REQUEST['posid']);
			//$content = $this->load->view('pdf/position',$data,true);
			$content = $this->load->view('pdf/positionnew',$data,true);
		}
		//$filename = $posdetails['position_name']." - JD";
		//$this->pdfgenerator->generate($content, $filename, true, 'A4', 'portrait','job_description');
		
		
		$this->render('layouts/ajax-layout',$content);
	}
	
	public function positionprofilepdf(){
		$this->load->library('pdfgenerator');
		$id=isset($_REQUEST['posid'])? $_REQUEST['posid']:"";
		$hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
		$flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
		if($flag==1 || $id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$posdetails=UlsPosition::viewposition($_REQUEST['posid']);
			$data['posdetails']=$posdetails;
			$category=UlsCompetencyPositionRequirements::category_comp_details($_REQUEST['posid']);
			$data['category']=$category;
			$data['kras']=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($_REQUEST['posid']);
			$content = $this->load->view('pdf/position_profilling',$data,true);
			if(count($category)>0){
			$filename = $posdetails['position_name']." - Competency Profile";
			$this->pdfgenerator->generate($content, $filename, true, 'A4', 'portrait','competency_profiling');
			}
			else{
				redirect('admin/position_search');
			}
		}
		//$content = $this->load->view('table_report2', $data, true);
		
		//$this->render('layouts/ajax-layout',$content);
	}

	public function position_view(){
		$data["aboutpage"]=$this->pagedetails('admin','position_view');
        $id=isset($_REQUEST['posid'])? $_REQUEST['posid']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1 || $id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			$posdetails=UlsPosition::viewposition($_REQUEST['posid']);
            $data['posdetails']=$posdetails;
			$data['competencies']=UlsCompetencyPositionRequirements::getcompetencypositionrequirements($_REQUEST['posid']);
			$data['kras']=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($_REQUEST['posid']);
			$content = $this->load->view('admin/position_view',$data,true);
        }
		
		$this->render('layouts/adminnew',$content);
    }

	public function grade_search(){
		$data["aboutpage"]=$this->pagedetails('admin','gradesearch');
		$limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
		$grade_name=filter_input(INPUT_GET,'grade_name') ? filter_input(INPUT_GET,'grade_name'):"";
		$page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
		$start=$page!=0? ($page-1)*$limit:0;
		$filePath=BASE_URL."/admin/grade_search";
		$data['limit']=$limit;
		$data['perpages']=UlsMenuCreation::perpage();
		$data['grade_name']=$grade_name;
		$data['grades']=UlsGrade::search($start, $limit,$grade_name);
		$total=UlsGrade::searchcount($grade_name);
		$otherParams="&perpage=".$limit."&grade_name=".$grade_name;
		$data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/grade_search',$data,true);
		$this->render('layouts/adminnew',$content);
	}

	public function grade_creation()
	{
        $data["aboutpage"]=$this->pagedetails('admin','grades');
        $grade_status="STATUS";
        $data['parent_date']=Doctrine::getTable('UlsOrganizationMaster')->find($this->session->userdata('parent_org_id'));
        $data['gradestatus']=UlsAdminMaster::get_value_names($grade_status);
		//$subgrade="SUBGRADE";
		$data['subgrades']=UlsSubgrade::getsubgrades();//UlsAdminMaster::get_value_names($subgrade);
		$data['category']=UlsCategory::getAllCategories();
		$content = $this->load->view('admin/grade_creation',$data,true);
		$this->render('layouts/adminnew',$content);
	}

	/*
     * Modified by Srikanth insertions/updations of grade
    */
    public function lms_grades(){
        if(isset($_POST['grade_id'])){ //print_r($_POST);
            $grade=(!empty($_POST['grade_id']))?Doctrine::getTable('UlsGrade')->find($_POST['grade_id']):new UlsGrade();
            $grade->grade_name=$_POST['grade_name'];
			$grade->grade_percentage=$_POST['grade_percentage'];
            $grade->status=$_POST['status'];
			$grade->parent_org_id=$this->session->userdata('parent_org_id');
            $grade->save();

			foreach($_POST['sub_grade_name'] as $k=>$subgradename){
				if(!empty($_POST['sub_grade_name'][$k])){
					$subgr=array('sub_grade_name','grade_status');
					$subgrade=(!empty($_POST['sub_grade_id'][$k]))?Doctrine::getTable('UlsSubGrades')->find($_POST['sub_grade_id'][$k]):new UlsSubGrades();
					$subgrade->grade_id=$grade->grade_id;
					foreach($subgr as $subgrad){
						$subgrade->$subgrad=(!empty($_POST[$subgrad][$k]))?$_POST[$subgrad][$k]:NULL;
					}
					$subgrade->save();
				}
			}

			if(!empty($_POST['grade_id'])){
				$grade_delete=Doctrine_Query::Create()->delete('UlsGradeYear t')->where('t.grade_id='.$_POST['grade_id'])->execute();
			}
			foreach($_POST['month'] as $key=>$value){
				if(!empty($value)){
					$period_from=explode('-',$_POST['month'][$key]);
					$period_to=explode('-',$_POST['month_to'][$key]);

					$work_val=array('from_month'=>trim($period_from[1]), 'from_year'=>trim($period_from[2]), 'to_month'=>trim($period_to[1]), 'to_year'=>trim($period_to[2]));
					//print_r($work_val);
					$gradeyear=(!empty($_POST['grade_year_id']))?Doctrine::getTable('UlsGradeYear')->find($_POST['grade_year_id']):new UlsGradeYear();
					$gradeyear->grade_id=$grade->grade_id;
					$gradeyear->category_id=$_POST['category'][$key];
					$gradeyear->training_days=$_POST['tra_days'][$key];
					foreach($work_val as $key1=>$ins_val){
						$gradeyear->$key1=(!empty($ins_val))?$ins_val:NULL;
					}
					$gradeyear->save();
				}
			}

			$this->session->userdata('grade_msg',"Grade data ".(!empty($_POST['grade_id'])?"updated":"inserted")." successfully.");
			redirect("admin/grade_view?grade_id=".$grade->grade_id);
        }
        else{
			$content = $this->load->view('admin/grade_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }

	/*
     * Modified by Srikanth update grade page
    */
    public function grade_update(){
        $data["aboutpage"]=$this->pagedetails('admin','grade_update');
        $id=isset($_REQUEST['grade_id'])? $_REQUEST['grade_id']:"";
        $menutype=!empty($id)? UlsMenuCreation::menutype($id):"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1 || $id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
            $pos_status="STATUS";
			$data['parent_date']=Doctrine::getTable('UlsOrganizationMaster')->find($this->session->userdata('parent_org_id'));
            $data['gradedetails']=Doctrine::getTable('UlsGrade')->findOneByGrade_id($_REQUEST['grade_id']);
            $data['posstatusss']=UlsAdminMaster::get_value_names($pos_status);
            $data['pos_org_name']=UlsOrganizationMaster::org_data();
			//$subgrade="SUBGRADE";			
			//$data['subgrades']=UlsAdminMaster::get_value_names($subgrade);
			$data['subgrades']=UlsSubgrade::getsubgrades();
			$data['category']=UlsCategory::getAllCategories();
			$content = $this->load->view('admin/grade_update',$data,true);
        }
		$this->render('layouts/adminnew',$content);
    }

	/*
     * Modified by Srikanth view grade page
    */
    public function grade_view(){
		$data["aboutpage"]=$this->pagedetails('admin','grades');
        $id=isset($_REQUEST['grade_id'])? $_REQUEST['grade_id']:"";
        $menutype=!empty($id)? UlsMenuCreation::menutype($id):"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1 || $id==""){
            $content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			$pos_status="STATUS";
			$data['posstatusss']=UlsAdminMaster::get_value_names($pos_status);
			//$subgrade="SUBGRADE";
			//$data['subgrades']=UlsAdminMaster::get_value_names($subgrade);
            $data['subgrades']=UlsSubgrade::getsubgrades();
			$data['gradedetails']=UlsGrade::viewgrade($id);
			$content = $this->load->view('admin/grade_view',$data,true);
        }
		$this->render('layouts/adminnew',$content);
    }
	
	public function subgrade_search(){
		$data["aboutpage"]=$this->pagedetails('admin','subgradesearch');
		$limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
		$subgrade_name=filter_input(INPUT_GET,'subgrade_name') ? filter_input(INPUT_GET,'subgrade_name'):"";
		$page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
		$start=$page!=0? ($page-1)*$limit:0;
		$filePath=BASE_URL."/admin/subgrade_search";
		$data['limit']=$limit;
		$data['perpages']=UlsMenuCreation::perpage();
		$data['subgrade_name']=$subgrade_name;
		$data['grades']=UlsSubgrade::search($start, $limit,$subgrade_name);
		$total=UlsSubgrade::searchcount($subgrade_name);
		$otherParams="&perpage=".$limit."&subgrade_name=".$subgrade_name;
		$data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/subgrade_search',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function subgrade_creation(){
        $data["aboutpage"]=$this->pagedetails('admin','subgrade_creation');
        $id=isset($_REQUEST['subgrade_id'])? $_REQUEST['subgrade_id']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        /* if($flag==1){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{ */
            $pos_status="STATUS";
            $data['subgradedet']=!empty($id)?Doctrine::getTable('UlsSubgrade')->find($id):array();
            $data['posstatusss']=UlsAdminMaster::get_value_names($pos_status);
			$content = $this->load->view('admin/subgrade_creation',$data,true);
        /* } */
		$this->render('layouts/adminnew',$content);
    }
	
	public function lms_subgrade(){
        if(isset($_POST['subgrade_id'])){ //print_r($_POST);
            $grade=(!empty($_POST['subgrade_id']))?Doctrine::getTable('UlsSubgrade')->find($_POST['subgrade_id']):new UlsSubgrade();
            $grade->subgrade_name=$_POST['subgrade_name'];
            $grade->subgrade_status=$_POST['status'];
			$grade->parent_org_id=$this->session->userdata('parent_org_id');
            $grade->save();
			$this->session->userdata('subgrade_msg',"Sub Grade data ".(!empty($_POST['subgrade_id'])?"updated":"inserted")." successfully.");
			redirect("admin/subgrade_view?subgrade_id=".$grade->subgrade_id);
        }
        else{
			$content = $this->load->view('admin/grade_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }
	
	public function subgrade_view(){
		$data["aboutpage"]=$this->pagedetails('admin','subgrade_view');
        $id=isset($_REQUEST['subgrade_id'])? $_REQUEST['subgrade_id']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1 || $id==""){
            $content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
            $data['gradedetails']=UlsSubgrade::viewsubgrade($id);
			$content = $this->load->view('admin/subgrade_view',$data,true);
        }
		$this->render('layouts/adminnew',$content);
    }
	
	public function deletesubgrade(){
		$id=trim($_REQUEST['val']);
		if(!empty($id)){
			$uewi=Doctrine_Query::create()->from('UlsEmployeeWorkInfo')->where('sub_grade_id='.$id)->execute();
			$uewo=Doctrine_Query::create()->from('UlsSubGrades')->where('sub_grade_name='.$id)->execute();
			if(count($uewi)==0 && count($uewo)==0){
				$q = Doctrine_Query::create()->delete('UlsSubgrade')->where('subgrade_id=?',$id);	
				$q->execute();
				echo 1;
			}
			else{
				echo "Selected Subgrade cannot be deleted. Ensure you delete all the usages of the Subgrade before you delete it.";
			}
		}
	}

	public function category_master_search()
	{
		$data["aboutpage"]=$this->pagedetails('admin','category_master_search');
		$limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
        $cat_name=filter_input(INPUT_GET,'cat_name') ? filter_input(INPUT_GET,'cat_name'):"";
        $cat_type=filter_input(INPUT_GET,'cat_type') ? filter_input(INPUT_GET,'cat_type'):"";
        $page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
        $start=$page!=0? ($page-1)*$limit:0;
        $filePath=BASE_URL."/admin/category_master_search";
        $data['limit']=$limit;
        $data['cat_name']=$cat_name;
        $data['cat_type']=$cat_type;
        $data['perpages']=UlsMenuCreation::perpage();
        $data['cat_types']=UlsAdminMaster::get_value_names("CAT_TYPE");
        $data['searchresults']=UlsCategory::catsearch($start, $limit,$cat_name,$cat_type);
        $total=UlsCategory::catsearchcount($cat_name,$cat_type);
        $otherParams="&perpage=".$limit."&cat_type=$cat_type&cat_name=$cat_name";
        $data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/category_master_search',$data,true);
		$this->render('layouts/adminnew',$content);
	}

	public function category_master()
	{
		$data["aboutpage"]=$this->pagedetails('admin','category_create');
		$this->sessionexist();
		$status="STATUS";
		$data['statusss']=UlsAdminMaster::get_value_names($status);
		$cat_type="CAT_TYPE";
		$data['category_primary']=UlsAdminMaster::get_value_names_catg($cat_type);
		$data['category']=UlsAdminMaster::get_catg($cat_type);
		$data['catcount']=UlsCategory::learning_category();
		$data['levels']=UlsLevelMaster::levels();
		if(isset($_REQUEST['id'])){

			$data['cat_update']=UlsCategory::category_update();
			$update=UlsCategory::category_update();
			if($update->category_type=='PC'){
				$categories_type='';
			}
			else if($update->category_type=='C'){
				$categories_type='PC';
			}
			else if($update->category_type=='SC'){
				$categories_type='C';
			}
			else if($update->category_type=='AC'){
				$categories_type='SC';
			}
			$type=$update->category_type;
			$pc=$update->primary_category;
			$data['categort_type']=UlsCategory::category_type($type);
			$data['dates']=UlsCategory::category_dates($pc);
			$data['category']=UlsCategory::parent_category($categories_type);
		}
		$id=filter_input(INPUT_GET,'id') ? filter_input(INPUT_GET,'id'):"";
		$hash=filter_input(INPUT_GET,'hash') ? filter_input(INPUT_GET,'hash'):"";
		$flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
		if($flag==1){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$content = $this->load->view('admin/category_master',$data,true);
		}
		$this->render('layouts/adminnew',$content);
	}

	public function parent_category(){
		$this->sessionexist();
		if(isset($_POST['category_type'])){
			if($_POST['category_type']=='PC'){
				$fieldinsert=array('category_type','name','description','status','level_id');
				$cat=(!empty($_POST['ids']))?Doctrine_Core::getTable('UlsCategory')->find($_POST['ids']):new UlsCategory();
				foreach($fieldinsert as $val){
					$cat->$val=!empty($_POST[$val])?$_POST[$val]:NULL;
				}
				$cat->primary_category=1;
				$cat->start_date=(!empty($_POST['start_date']))?date('Y-m-d',strtotime($_POST['start_date'])):NULL;
				$closedate=($_POST['end_date']=='') ? Null : date('Y-m-d',strtotime($_POST['end_date']));
				$cat->end_date=$closedate;
				$cat->Save();
				$update=Doctrine_Query::create()->update('UlsCategory');
				$update->set('primary_category','?',$cat->category_id);
				$update->where('category_id=?',$cat->category_id);
				$update->execute();
			}
			elseif(($_POST['category_type']=='C') || ($_POST['category_type']=='SC') || ($_POST['category_type']=='AC')){
				$fieldinsert=array('category_type','primary_category','name','description','status','level_id');
				$cats=(!empty($_POST['ids']))?Doctrine_Core::getTable('UlsCategory')->find($_POST['ids']):new UlsCategory();
				foreach($fieldinsert as $val){
					$cats->$val=!empty($_POST[$val])?$_POST[$val]:NULL;
				}
				$cats->start_date=(!empty($_POST['start_date']))?date('Y-m-d',strtotime($_POST['start_date'])):NULL;
				$closedate=($_POST['end_date']=='')? Null : date('Y-m-d',strtotime($_POST['end_date']));
				$cats->end_date=$closedate;
				$cats->Save();
			}
		}
		$this->session->set_flashdata('msg',"Category data ".(!empty($_POST['category_id'])?"updated":"inserted")." successfully.");
		redirect('admin/category_master_search');
	}

	public function deletecategory(){
		$id=trim($_REQUEST['val']);
		if(!empty($id)){
			$ulgd=Doctrine_Query::create()->from('UlsCategory')->where('primary_category='.$id)->execute();
			$ula=Doctrine_Query::create()->from('UlsCompetencyDefinition')->where('comp_def_category='.$id.' or comp_def_sub_category='.$id)->execute();
			if(count($ula)==0 && count($ulgd)==0){
				$q = Doctrine_Query::create()->delete('UlsCategory')->where('category_id=?',$id);
				$q->execute();
				echo 1;
			}
			else{
				echo "Selected category cannot be deleted. Ensure you delete all the usages of the category before you delete it.";
			}
		}
	}

	public function category_view(){
		$data["aboutpage"]=$this->pagedetails('admin','category_view');
        $id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1 || $id==""){
            $content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			$data['status']=UlsAdminMaster::get_value_names("STATUS");
			$data['cattypes']=UlsAdminMaster::get_value_names("CAT_TYPE");
            $data['catdetails']=UlsCategory::viewcategory($id);
			$content = $this->load->view('admin/category_view',$data,true);
        }
		$this->render('layouts/adminnew',$content);
    }

	public function criticality_master_search(){
		$data["aboutpage"]=$this->pagedetails('admin','criticality_master_search');
		$limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
        $cri_name=filter_input(INPUT_GET,'cri_name') ? filter_input(INPUT_GET,'cri_name'):"";
        $page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
        $start=$page!=0? ($page-1)*$limit:0;
        $filePath=BASE_URL."/admin/criticality_master_search";
        $data['limit']=$limit;
        $data['cri_name']=$cri_name;
        $data['perpages']=UlsMenuCreation::perpage();
		$data['cri_data']=UlsCompetencyCriticality::criticality_names();
		$loc_status="STATUS";
        $data["locstatusss"]=UlsAdminMaster::get_value_names($loc_status);
        $data['searchresults']=UlsCompetencyCriticality::search($start, $limit,$cri_name);
        $total=UlsCompetencyCriticality::searchcount($cri_name);
        $otherParams="&perpage=".$limit."&cri_name=$cri_name";
        $data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/criticality_master_search',$data,true);
		$this->render('layouts/adminnew',$content);
	}

	public function criticality_master(){
		$this->sessionexist();
        $data["aboutpage"]=$this->pagedetails('admin','criticality');
        $id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1 && !empty($id)==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			if(!empty($_REQUEST['id'])){
				$data["langdetail"]=UlsCompetencyCriticality::viewcriticality($_REQUEST['id']);
			}
            $loc_status="STATUS";
            $data["locstatusss"]=UlsAdminMaster::get_value_names($loc_status);
			$content = $this->load->view('admin/criticality_master',$data,true);
        }
		$this->render('layouts/adminnew',$content);
	}

	public function lms_criticality(){
        $this->sessionexist();
        if(isset($_POST['comp_cri_name'])){
            foreach($_POST['comp_cri_code'] as $k=>$value){
				if(!empty($_POST['comp_cri_name'][$k])){
					$sublevel=array('comp_cri_name','status','description','comp_rating_value');
					$subl=(!empty($_POST['comp_cri_id'][$k]))?Doctrine::getTable('UlsCompetencyCriticality')->find($_POST['comp_cri_id'][$k]):new UlsCompetencyCriticality();
					$subl->comp_cri_code=$value;
					foreach($sublevel as $sublevels){
						$subl->$sublevels=(!empty($_POST[$sublevels][$k]))?$_POST[$sublevels][$k]:NULL;
					}
					$subl->save();
				}
			}
			$this->session->set_flashdata('langmsg',"criticality data ".(!empty($_POST['comp_cri_id'])?"updated":"inserted")." successfully.");
            redirect('admin/criticality_master_search');
        }
        else{
			$content = $this->load->view('admin/criticality_master_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }

	public function deletecriticality(){
		$id=trim($_REQUEST['val']);
		if(!empty($id)){
			$uewi=Doctrine_Query::create()->from('UlsCompetencyPositionRequirements')->where('comp_position_criticality_id='.$id)->execute();
			if(count($uewi)==0){
				$q = Doctrine_Query::create()->delete('UlsCompetencyCriticality')->where('comp_cri_id=?',$id)->execute();
				echo 1;
			}
			else{
				echo "Selected Criticality cannot be deleted. Ensure you delete all the usages of the Criticality before you delete it.";
			}
		}
	}

	public function criticality_view(){
		$data["aboutpage"]=$this->pagedetails('admin','criticality_view');
        $id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1 || $id==""){
            $content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			$data['status']=UlsAdminMaster::get_value_names("STATUS");
            $data['criticalitydetails']=UlsCompetencyCriticality::viewcriticality($id);
			$content = $this->load->view('admin/criticality_view',$data,true);
        }
		$this->render('layouts/adminnew',$content);
    }

	public function level_master_search(){
		$data["aboutpage"]=$this->pagedetails('admin','level_master_search');
		$limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
        $level_name=filter_input(INPUT_GET,'level_name') ? filter_input(INPUT_GET,'level_name'):"";
        $page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
        $start=$page!=0? ($page-1)*$limit:0;
        $filePath=BASE_URL."/admin/level_master_search";
        $data['limit']=$limit;
        $data['level_name']=$level_name;
        $data['perpages']=UlsMenuCreation::perpage();
        $data['searchresults']=UlsLevelMaster::search($start, $limit,$level_name);
        $total=UlsLevelMaster::searchcount($level_name);
        $otherParams="&perpage=".$limit."&level_name=$level_name";
        $data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/level_master_search',$data,true);
		$this->render('layouts/adminnew',$content);
	}

	public function level_master()
	{
		$data["aboutpage"]=$this->pagedetails('admin','level_master');
		$id=filter_input(INPUT_GET,'level_id') ? filter_input(INPUT_GET,'level_id'):"";
        $hash=filter_input(INPUT_GET,'hash') ? filter_input(INPUT_GET,'hash'):"";
        $menutype=!empty($id)? UlsMenuCreation::menutype($id):"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			$data['level']=UlsLevelMaster::viewlevel($id);
			$data['level_scale']=UlsLevelMasterScale::levelscale($id);
			$data['status']=UlsAdminMaster::get_value_names("STATUS");
			$content = $this->load->view('admin/level_master',$data,true);
		}
		$this->render('layouts/adminnew',$content);

	}

	public function lms_level_master(){
        if(isset($_POST['level_id'])){ //print_r($_POST);
            $level=(!empty($_POST['level_id']))?Doctrine::getTable('UlsLevelMaster')->find($_POST['level_id']):new UlsLevelMaster();
            $level->level_name=$_POST['level_name'];
            $level->status=$_POST['status'];
			$level->level_scale=$_POST['scale_number'];
			$level->parent_org_id=$this->session->userdata('parent_org_id');
            $level->save();

			foreach($_POST['val'] as $k=>$value){
				if(!empty($_POST['val'][$k])){
					$sublevel=array('scale_name','description');
					$subl=(!empty($_POST['scale_id'][$k]))?Doctrine::getTable('UlsLevelMasterScale')->find($_POST['scale_id'][$k]):new UlsLevelMasterScale();
					$subl->level_id=$level->level_id;
					$subl->scale_number=$value;
					foreach($sublevel as $sublevels){
						$subl->$sublevels=(!empty($_POST[$sublevels][$k]))?$_POST[$sublevels][$k]:NULL;
					}
					$subl->save();
				}
			}
			$this->session->set_flashdata('level_msg',"Level data ".(!empty($_POST['level_id'])?"updated":"inserted")." successfully.");
			redirect("admin/level_view?level_id=".$level->level_id);
        }
        else{
			$content = $this->load->view('admin/level_master_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }

	public function deletelevel(){
		$id=trim($_REQUEST['val']);
		if(!empty($id)){
			$uewi=Doctrine_Query::create()->from('UlsCategory')->where('level_id='.$id)->execute();
			if(count($uewi)==0){
				$q = Doctrine_Query::create()->delete('UlsLevelMasterScale')->where('level_id=?',$id)->execute();
				$q = Doctrine_Query::create()->delete('UlsLevelMaster')->where('level_id=?',$id)->execute();
				echo 1;
			}
			else{
				echo "Selected Level cannot be deleted. Ensure you delete all the usages of the Level before you delete it.";
			}
		}
	}

	public function level_view(){
		$data["aboutpage"]=$this->pagedetails('admin','level_master_view');
        $id=isset($_REQUEST['level_id'])? $_REQUEST['level_id']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1 || $id==""){
            $content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			$data['status']=UlsAdminMaster::get_value_names("STATUS");
            $data['leveldetails']=UlsLevelMaster::viewlevel($id);
			$content = $this->load->view('admin/level_view',$data,true);
        }
		$this->render('layouts/adminnew',$content);
    }

	public function language_search(){
		$data["aboutpage"]=$this->pagedetails('admin','language_search');
		$limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
        $lang_name=filter_input(INPUT_GET,'lang_name') ? filter_input(INPUT_GET,'lang_name'):"";
        $page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
        $start=$page!=0? ($page-1)*$limit:0;
        $filePath=BASE_URL."/admin/language_search";
        $data['limit']=$limit;
        $data['lang_name']=$lang_name;
        $data['perpages']=UlsMenuCreation::perpage();
        $data['searchresults']=UlsLanguageMaster::search($start, $limit,$lang_name);
        $total=UlsLanguageMaster::searchcount($lang_name);
        $otherParams="&perpage=".$limit."&lang_name=$lang_name";
        $data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/language_search',$data,true);
		$this->render('layouts/adminnew',$content);
	}

	public function language_master(){
		$this->sessionexist();
        $data["aboutpage"]=$this->pagedetails('admin','language');
        $id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1 && !empty($id)==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			if(!empty($_REQUEST['id'])){
				$data["langdetail"]=UlsLanguageMaster::viewlanguage($_REQUEST['id']);
			}
            $loc_status="STATUS";
            $data["locstatusss"]=UlsAdminMaster::get_value_names($loc_status);
			$content = $this->load->view('admin/language_master',$data,true);
        }

		$this->render('layouts/adminnew',$content);
	}

	public function lms_language(){
        $this->sessionexist();
        if(isset($_POST['lang_id'])){
            $fieldinsertupdates=array('lang_name','lang_status');
            $sessionvars=array('parent_org_id');
            $language=Doctrine::getTable('UlsLanguageMaster')->find($_POST['lang_id']);
            !isset($language->lang_id)?$language=new UlsLanguageMaster():"";
            foreach($fieldinsertupdates as $val){
				$language->$val=(!empty($_POST[$val]))?($_POST[$val]):NULL;
			}
			foreach($sessionvars as $val){$language->$val=$_SESSION[$val];}
            $language->save();
			$this->session->set_flashdata('langmsg',"language data ".(!empty($_POST['lang_id'])?"updated":"inserted")." successfully.");
            redirect('admin/language_view?id='.$language->lang_id.'&hash='.md5(SECRET.$language->lang_id));
        }
        else{
			$content = $this->load->view('admin/lms_admin_language_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }

	public function deletelanguage(){
		$id=trim($_REQUEST['val']);
		if(!empty($id) && is_numeric($id)){
			$uewi=Doctrine_Query::create()->from('UlsLangQuestionValues')->where('lang_id='.$id)->execute();
			$uewi2=Doctrine_Query::create()->from('UlsQuestionsLanguage')->where('lang_id='.$id)->execute();
			if(count($uewi)==0 && count($uewi2)==0){
				$q = Doctrine_Query::create()->delete('UlsLanguageMaster')->where('lang_id=?',$id)->execute();
				echo 1;
			}
			else{
				echo "Selected Language cannot be deleted. Ensure you delete all the usages of the Language before you delete it.";
			}
		}
	}

	public function language_view(){
		$data["aboutpage"]=$this->pagedetails('admin','language_view');
        $id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1 || $id==""){
            $content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			$data['status']=UlsAdminMaster::get_value_names("STATUS");
            $data['langdetails']=UlsLanguageMaster::viewlanguage($id);
			$content = $this->load->view('admin/language_view',$data,true);
        }
		$this->render('layouts/adminnew',$content);
    }

	public function questionbank_search(){
		$data["aboutpage"]=$this->pagedetails('admin','questionbank_search');
		$limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
        $ques_name=filter_input(INPUT_GET,'ques_name') ? filter_input(INPUT_GET,'ques_name'):"";
		$assesment=filter_input(INPUT_GET,'assesment') ? filter_input(INPUT_GET,'assesment'):"";
        $page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
        $start=$page!=0? ($page-1)*$limit:0;
        $filePath=BASE_URL."/admin/questionbank_search";
        $data['limit']=$limit;
        $data['ques_name']=$ques_name;
		$data['assesment']=$assesment;
        $data['perpages']=UlsMenuCreation::perpage();
		$only=array("COMP_TEST","COMP_TEST");
		$data["assesments"]=UlsAdminMaster::get_value_names("ASSESSMENT_TYPE");
        $data['searchresults']=UlsQuestionbank::search($start,$limit,$ques_name,$assesment);
        $total=UlsQuestionbank::searchcount($ques_name,$assesment);
        $otherParams="&perpage=".$limit."&ques_name=$ques_name&assesment=$assesment";
		$data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/questionbank_search',$data,true);
		$this->render('layouts/adminnew',$content);
	}

	public function questionbank_creation(){
		$this->sessionexist();
        $data["aboutpage"]=$this->pagedetails("admin","questionbank_creation");
        $tna_critics="PUBLISH_STATUS";
		$data["publish"]=UlsAdminMaster::get_value_names($tna_critics);
        $id= filter_input(INPUT_GET,'id')?filter_input(INPUT_GET,'id'):"";
		$hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
		$flag=((md5(SECRET.$id)!=$hash)?1:0);
		if($flag==1 && !empty($id)){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			if(!empty($id)){
				$data["questionbank"]=Doctrine_Core::getTable('UlsQuestionbank')->find($id);
            }
			$data["assesment"]=UlsAdminMaster::get_value_names("ASSESSMENT_TYPE");
			$data['competencymsdetails']=UlsCompetencyDefinition::competency_details("MS");
			$data['competencynmsdetails']=UlsCompetencyDefinition::competency_details("NMS");
			$content = $this->load->view('admin/questionbank_creation',$data,true);
		}
		$this->render('layouts/adminnew',$content);
	}

	/*
     * Modified by Prasad Malla questionbank_edit
	 * This method is used to modify question bank details
	 * Table used uls_questionbank

	*/
	public function insert_questionbank(){
		if(isset($_REQUEST['questname'])){
			$question_bank=!empty($_POST['questionbank_id'])? Doctrine_Core::getTable('UlsQuestionbank')->find($_POST['questionbank_id']):new UlsQuestionbank();
			$question_bank->name= $_POST['questname'];
			$question_bank->active_flag=$_POST['pstatus'];
			$question_bank->type=$_POST['type'];
			$question_bank->comp_def_id=$_POST['comp_def_id'];
			$question_bank->description=$_POST['description'];
			$question_bank->save();
			redirect('admin/questionbank_view?id='.$question_bank->question_bank_id.'&hash='.md5(SECRET.$question_bank->question_bank_id));
			$this->session->set_flashdata('msg',"Question Bank data ".(!empty($_POST['questionbank_id'])?"updated":"inserted")." successfully.");
		}
	}


	public function questionbank_view(){
		$data["aboutpage"]=$this->pagedetails("admin","questionbank_view");
        $id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1 || $id==""){
            $content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			$data['questionss']=UlsQuestionbank::get_questions_data($id);
			$data['assesment']=UlsAdminMaster::get_value_names("ASSESSMENT_TYPE");
			$data['questionbanks']=UlsQuestionbank::view_questionbank($id);
			$content = $this->load->view('admin/questionbank_view',$data,true);
        }
		$this->render('layouts/adminnew',$content);
    }

	public function questions(){
		$id=$_REQUEST['id'];
		$data["aboutpage"]=$this->pagedetails("admin","questions");
        $id=filter_input(INPUT_GET,'id') ? filter_input(INPUT_GET,'id'):"";
		$hash=filter_input(INPUT_GET,'hash') ? filter_input(INPUT_GET,'hash'):"";
		$flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
		if($flag==1  || $id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$data['allquests']=UlsQuestions::get_allquestions($id);
			$data['questionbank']=UlsQuestionbank::get_questionbank_id_deatils($id);
			$data['assesment']=UlsAdminMaster::get_value_names("ASSESSMENT_TYPE");
			$content = $this->load->view('admin/questionbank_questions',$data,true);
		}
		$this->render('layouts/adminnew',$content);
	}

	public function question_view(){
        $id=$_REQUEST['id'];
        $this->sessionexist();
		$data["aboutpage"]=$this->pagedetails("admin","question_view");
        $data['questionbank']=UlsQuestions::get_questions_view($id);
        $data['questionvalues']=UlsQuestions::get_questions_view_vlaues($id);
        $id=filter_input(INPUT_GET,'id') ? filter_input(INPUT_GET,'id'):"";
        $hash=filter_input(INPUT_GET,'hash') ? filter_input(INPUT_GET,'hash'):"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
		if($flag==1  || $id==""){
			$this->registry->template->show('admin_lms_admin_restriction','admin-layout');
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$qbid=UlsQuestionbank::get_questionbank_form_question($id);
			$data['questionbankdetails']=UlsQuestionbank::get_questionbank_id($qbid->question_bank_id);
			$content = $this->load->view('admin/question_view',$data,true);
		}
		$this->render('layouts/adminnew',$content);
    }

	public function question_creation(){
		//print_r($_POST);
        $this->sessionexist();
		$data["aboutpage"]=$this->pagedetails("admin","question_creation");
        $data['questiontype']=UlsQuestionsType::get_questiontype();
        $qid=filter_input(INPUT_GET,'qid') ? filter_input(INPUT_GET,'qid'):"";
		$id=filter_input(INPUT_GET,'id') ? filter_input(INPUT_GET,'id'):"";
		$hash=filter_input(INPUT_GET,'hash') ? filter_input(INPUT_GET,'hash'):"";
		$flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
		if($flag==1  || $id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			if(!empty($_REQUEST['qid'])){
				$question=UlsQuestions::get_questions($_REQUEST['qid']);
				$data['ques_lang']=UlsQuestionsLanguage::get_questionlan_id($_REQUEST['qid']);
				$data['question']=$question;
				$data['ques_lang_n']=UlsQuestionsLanguage::get_question_language($_REQUEST['qid']);
				$data['questions']=UlsQuestionValues::get_allquestion_values($_REQUEST['qid']);				
				$data['scalevalue']=UlsLevelMasterScale::levelscale($question['level_id']);
			}
			$data['ques_bank']=UlsQuestionbank::get_questionbank_id($id);
			$tna_critics="PUBLISH_STATUS";
			$disp="DISPLAY_ORDER";
			$data['language']=UlsLanguageMaster::get_lan_id();
			$data['publish']=UlsAdminMaster::get_value_names($tna_critics);
			$data['display']=UlsAdminMaster::get_value_names($disp);
			$data['quest_cat']=UlsAdminMaster::get_value_names("QUEST_TYPE");
			$data['lastrecord']=UlsQuestions::last_questionnaire();
			//$data['level']=UlsLevelMaster::levels();
			$data['level']=UlsQuestionbank::get_questions_level($_REQUEST['id']);
			($_REQUEST['type']=='PROG_EVAL')?$content = $this->load->view('admin/lms_admin_questionnaire_creation',$data,true):$content = $this->load->view('admin/question_manage_creation',$data,true);
		}
		$this->render('layouts/adminnew',$content);
    }

	public function comp_question_insert_step_one(){
		global $con;
		if(isset($_POST['question_name'])){
			/* echo "<pre>";
			print_r($_POST); 
			$qvaln=htmlspecialchars( strip_tags(trim($_POST['question_name'])));
			$questionvalue=str_replace('<','&lt;',$qvaln);
			$questionvalue=str_replace('>','&gt;', $questionvalue); */
			$questiontype =explode(",", $_POST['questtype']);
			if(count($questiontype)==1){ $questiontype[1]=$questiontype[0];}
            //$gettyp=($_POST['questtype']=='S' || $_POST['questtype']=='4,S' || $_POST['questtype']=='M' || $_POST['questtype']=='5,M'  || $_POST['questtype']=='P' || $_POST['questtype']=='8,P')? $_POST['order'] : Null;
			$question=!empty($_POST['question_id'])? Doctrine_Core::getTable('UlsQuestions')->find($_POST['question_id']):new UlsQuestions();
            $question->question_bank_id=$_POST['qbankid'];
            //$question->question_name=mysqli_real_escape_string($con,$questionvalue);
			$question->question_name=$_POST['question_name'];
            $question->question_category=$_POST['question_category'];
            $question->question_type=$questiontype[1];
			$question->active_flag=NULL;
			$question->multi_language=$_POST['multi_language'];
			if($_POST['questtype']!=='FT'  || $_POST['questtype']!=='6,FT'){
				!empty($_POST['points'])?$question->points=$_POST['points']: $question->points=0;
            }
            $question->sequence=!empty($_POST['order'])?$_POST['order'] : Null;//$gettyp;
			$question->level_id=$_POST['level_id'];
			$question->scale_id=$_POST['scale_id'];
            $question->save();
			if($_POST['multi_language']=='yes'){
				$attachinsrtupdt=array('lang_id', 'lang_question_name');
				foreach($_POST['lang_id'] as $key=>$value){
					$work_details_level=(!empty($_POST['comp_lang_id'][$key]))?Doctrine::getTable('UlsQuestionsLanguage')->find($_POST['comp_lang_id'][$key]):new UlsQuestionsLanguage;
					$work_details_level->question_id=$question->question_id;
					$work_details_level->question_bank_id=$question->question_bank_id;
					foreach($attachinsrtupdt as $att_val){
						 !empty($_POST[$att_val][$key])?$work_details_level->$att_val=trim($_POST[$att_val][$key]):Null;
					}
					$work_details_level->save();
				}
			}
			redirect('admin/question_creation?step2&type='.$question->question_category.'&qid='.$question->question_id.'&id='.$question->question_bank_id.'&hash='.md5(SECRET.$question->question_bank_id));
		}
	}

	public function comp_question_insert_step_two(){
		if(isset($_POST['qid'])){
			if($_POST['questiontype']=='T'){
                $var="";
                $dd=explode(',',$_POST['addgroup_radio']);
            }
			if($_POST['questiontype']=='F' || $_POST['questiontype']=='B'|| $_POST['questiontype']=='FT' ){
                $var="";
                $dd=$_POST['fillquestion'];
            }
			if($_POST['questiontype']=='S'){
                $var="rad_";
                $dd=explode(',',$_POST['addgroup_single']);
            }
			if($_POST['questiontype']=='M'){
                $var="chk_";
                $dd=explode(',',$_POST['addgroup_multiple']);
            }
			if($_POST['questiontype']=='P'){
                $var="chk_";
                $dd=explode(',',$_POST['addgroup_priority']);
            }
			$anserr="answer_".$var;
			$anserr_pp="answer_";
			$anseridr="value_id_";
			foreach($dd as $key=>$act){
				$anser=$anserr.$act;
				$anserid=$anseridr.$act;
				($_POST['questiontype']=='T')? ($flg=isset($_POST['rad_radio'])? ($_POST['rad_radio']==$anser? "Y":"N" ):"N"):"";
				($_POST['questiontype']==='S')?($flg=isset($_POST['rad_multiple'])? ($_POST['rad_multiple']==$anser? "Y":"N" ):"N"):"";
				($_POST['questiontype']=='M')?($flg=isset($_POST['chkbox_'.$act])? "Y":"N"):"";
				($_POST['questiontype']=='P')?($flg=isset($_POST['chkbox_'.$act])? "Y":"N"):"";
				if($_POST['questiontype']=='F' || $_POST['questiontype']=='B'|| $_POST['questiontype']=='FT'){
                    $anserid="value_id_1";
                    $ans=$act ;
                    if($_POST['questiontype']!='FT'){
                    $exp=(($_POST['explan'][$key])=="Type your explanation text here")?"": $_POST['explan'][$key] ;
                    }
					else{
						$exp="";
					}
                    $flg="Y";
                }
                else{
                    $ans=$_POST[$anser]=='Type your answer text here'?"":$_POST[$anser];
                }

				if($_POST['questiontype']!=='FT'){
					if($_POST['questiontype']=='F' || $_POST['questiontype']=='B'){
						if((!empty($ans) && $ans!="Type your answer text here") ) {
							$question_values=!empty($_POST[$anserid])? Doctrine_Core::getTable('UlsQuestionValues')->find($_POST[$anserid]):new UlsQuestionValues();
							$question_values->question_id=$_POST['qid'];
							$question_values->correct_flag=$flg;
							$question_values->text=$ans;
							$_POST['questiontype']!=='FT' || $_POST['questiontype']!=='6,FT'? $question_values->explanation=$_POST['explan'][$key]:"";
							$question_values->start_date_active=date('Y-m-d');
							$question_values->end_date_active=date('Y-m-d');
							$question_values->save();
						}
					}
					/* elseif($_POST['questiontype']=='T'){
						if((!empty($ans) && $ans!="Type your answer text here") or $ans==0) {
							$question_values=!empty($_POST[$anserid])? Doctrine_Core::getTable('UlsCompetencyQuestionValues')->find($_POST[$anserid]):new UlsCompetencyQuestionValues();
							$question_values->question_id=$_POST['qid'];
							$question_values->correct_flag=$flg;
							$question_values->text=$ans;
							$question_values->start_date_active=date('Y-m-d');
							$question_values->end_date_active=date('Y-m-d');
							$question_values->save();
						}
					} */
					elseif($_POST['questiontype']=='T' || $_POST['questiontype']=='S' || $_POST['questiontype']=='M' || $_POST['questiontype']=='P'){
						if((!empty($ans) && $ans!="Type your answer text here") or $ans==0) {
							$question_values=!empty($_POST[$anserid])? Doctrine_Core::getTable('UlsQuestionValues')->find($_POST[$anserid]):new UlsQuestionValues();
							$question_values->question_id=$_POST['qid'];
							$question_values->correct_flag=$flg;
							$question_values->text=stripslashes($ans);
							//$_POST['questiontype']!=='FT' || $_POST['questiontype']!=='6,FT'? $question_values->explanation=$_POST['explan'][$key]:"";
							$question_values->start_date_active=date('Y-m-d');
							$question_values->end_date_active=date('Y-m-d');
							$question_values->save();
							$ques_lang_n=UlsQuestionsLanguage::get_question_language($_POST['qid']);
							foreach($ques_lang_n as $ques_langs){
								$que_lang_id="que_lang_id_".$ques_langs['language_name']."_".$act;
								$comp_lang_id="comp_lang_id_".$ques_langs['language_name']."_".$act;
								$lang_id="lang_id_".$ques_langs['language_name']."_".$act;
								$anser_lang=$anserr.$ques_langs['language_name']."_".$act;
								if(isset($_POST[$anser_lang])&& !empty($anser_lang)){
									$question_lvalues=!empty($_POST[$que_lang_id])? Doctrine_Core::getTable('UlsLangQuestionValues')->find($_POST[$que_lang_id]):new UlsLangQuestionValues();
									$question_lvalues->question_id=$_POST['qid'];
									$question_lvalues->value_id=$question_values->value_id;
									$question_lvalues->comp_lang_id=(isset($_POST[$comp_lang_id]))?$_POST[$comp_lang_id]:null;
									$question_lvalues->lang_id=(isset($_POST[$lang_id]))?$_POST[$lang_id]:null;
									$question_lvalues->text=(isset($_POST[$anser_lang]))?$_POST[$anser_lang]:null;
									$question_lvalues->save();
								}
							}
						}
					}
				}
				else {
					 //&& ($ans!="Type your answer text here")
			        if((!empty($ans)) && ($ans!="Type your answer text here")){
						$question_values=!empty($_POST[$anserid])? Doctrine_Core::getTable('UlsQuestionValues')->find($_POST[$anserid]):new UlsQuestionValues();
						$question_values->question_id=$_POST['qid'];
						$question_values->correct_flag=$flg;
						$answer=$ans!="Type your answer text here"?$ans:"left Blank";
						$question_values->text=$answer;
						$_POST['questiontype']!=='FT'? $question_values->explanation=$_POST['explan'][$key]:"";
						//$question_values->start_date_active=date('Y-m-d',strtotime($_POST['startdate']));
						//$question_values->end_date_active=$enddate;
						$question_values->save();
					}
			    }
            }
			$question=UlsQuestions::get_questions($_POST['qid']);
			redirect('admin/question_creation?step3&type='.$question['quest_cat'].'&qid='.$question['qid'].'&id='.$question['bid'].'&hash='.md5(SECRET.$question['bid']));
		}
	}

	public function comp_question_insert_step_three(){
		if(isset($_POST['tna_publish_save'])){
			$question_update=Doctrine_Core::getTable('UlsQuestions')->find($_POST['ques_id']);
			$question_update->active_flag='P';
			$question_update->save();
			$question=UlsQuestions::get_questions($_POST['ques_id']);
			redirect('admin/questions?type='.$question['quest_cat'].'&id='.$question['bid'].'&hash='.md5(SECRET.$question['bid']));
		}
	}

	public function test_home(){
        $this->sessionexist();
		$data["aboutpage"]=$this->pagedetails("admin","test_home");
        $limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
        $test_name=filter_input(INPUT_GET,'test_name') ? filter_input(INPUT_GET,'test_name'):"";
        $page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
        $start=$page!=0? ($page-1)*$limit:0;
        $filePath=BASE_URL."/admin/test_home";
        $data['limit']=$limit;
        $data['test_name']=$test_name;
        $data['perpages']=UlsMenuCreation::perpage();
        $data['testdetails']=UlsCompetencyTest::search($start,$limit,$test_name);
        $total=UlsCompetencyTest::searchcount($test_name);
        $otherParams="perpage=".$limit."&test_name=$test_name";
        $data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
        $data['quests']=UlsQuestions::get_questins_fortest();
		$content = $this->load->view('admin/test_home',$data,true);
		$this->render('layouts/adminnew',$content);
    }

	public function test_creation(){
        $this->sessionexist();
		$data["aboutpage"]=$this->pagedetails("admin","test_creation");
        $data['publish']=UlsAdminMaster::get_value_names("PUBLISH_STATUS");
        $data['assesment']=UlsAdminMaster::get_value_names("ASSESSMENT_TYPE");
		$data['ratingscale']=UlsRatingScale::rating_scales();
        if(isset($_POST['test_name'])){
            if($_POST['testtype']=='F'){
				$res=isset($_POST['resum'])?"Y":"N";
            }
			else {
				$res=null;
			}
            $question_values=!empty($_POST['test_id'])? Doctrine_Core::getTable('UlsCompetencyTest')->find($_POST['test_id']):new UlsCompetencyTest();
			$question_values->test_code=!empty($_POST['test_code'])?$_POST['test_code']:NULL;
            $question_values->test_name=$_POST['test_name'];
			$question_values->rating_scale_id=(isset($_POST['rating_scale']) && !empty($_POST['rating_scale']))?$_POST['rating_scale']:NULL;
            $question_values->test_type_flag=$_POST['testtype'];
            $question_values->description=$_POST['desc'];
            $question_values->active_flag=$_POST['publish'];
            $question_values->save();
		    if(isset($_REQUEST['id'])){
				redirect("admin/test_view?id=".$question_values->test_id."&hash=".md5(SECRET.$question_values->test_id));
				$this->session->set_flashdata('msg'," Test data ".(!empty($_POST['id'])?"updated":"inserted")." successfully.");
			}
			else {
				$this->session->set_flashdata('msg'," Test data inserted successfully.");
				redirect("admin/update_test?test_type=".$_POST['testtype']."&id=".$question_values->test_id."&hash=".md5(SECRET.$question_values->test_id));
		   }
        }
		$content = $this->load->view('admin/test_creation',$data,true);
		$this->render('layouts/adminnew',$content);
    }

	 public function update_test(){
        $this->sessionexist();
		$data["aboutpage"]=$this->pagedetails("admin","update_test");
        $tid=$_REQUEST['id'];
        $data['questnames']=UlsCompetencyTest::getquestionbanknames($tid);
        $data['testquestions']=UlsCompetencyTestQuestions::get_testquestions($tid);
		$content = $this->load->view('admin/test_update',$data,true);
		$this->render('layouts/adminnew',$content);
    }

	public function test_view(){
        $tid=$_REQUEST['id'];
        $data['testd']=UlsTest::get_test_details($tid);
        $data['testdetails']=UlsTest::get_test_view_details($tid);
		$content = $this->load->view('admin/test_view',$data,true);
		$this->render('layouts/adminnew',$content);
    }

	public function test_edit(){
		$data["aboutpage"]=$this->pagedetails("admin","test_creation");
		$tid=$_REQUEST['id'];
		$id=filter_input(INPUT_GET,'id') ? filter_input(INPUT_GET,'id'):"";
		$hash=filter_input(INPUT_GET,'hash') ? filter_input(INPUT_GET,'hash'):"";
		$data['questionss']=UlsQuestionbank::get_questions_data($id);
		$data['questionbank']=UlsQuestionbank::get_questionbank_id($id);
		$flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1  || $id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
        else{
			$testid=$_REQUEST['id'];
			$adminvalues="PUBLISH_STATUS";
			$data['publish']=UlsAdminMaster::get_value_names($adminvalues);
			$adminvalues="ASSESSMENT_TYPE";
			$data['assesment']=UlsAdminMaster::get_value_names($adminvalues);
			$data['ratingscale']=UlsRatingScale::rating_scales();
			$adminvalues="DISPLAY_ORDER";
			$data['display']=UlsAdminMaster::get_value_names($adminvalues);
			$adminvalues="SCORING_TYPE";
			$data['scoring']=UlsAdminMaster::get_value_names($adminvalues);
			$ava="MANDATORY_STATUS";
			$data['testattachment']=UlsEventsEvaluation::gettestattachments($tid);
			$data['mandatorys']=UlsAdminMaster::get_value_names($ava);
			$adminvalues="TIME_ENABLE_STATUS";
			$data['timeenable']=UlsAdminMaster::get_value_names($adminvalues);
			$data['testdetails']=UlsTest::get_test_details($testid);
			$content = $this->load->view('admin/test_edit',$data,true);
		}
		$this->render('layouts/adminnew',$content);
	}


	public function  questionbank_questions(){
        $qid=$_REQUEST['id'];
        $selqids=$_REQUEST['selquest'];
        $this->sessionexist();
        $qids=explode(',',$selqids);
        $questionbank=UlsQuestions::get_activequestions($qid);
        echo "<p>&emsp; Please Select the Questions for the Test.</p>
        <div id='popup_maindiv' style='height:415px;'>";
        echo "<div id='main_table_div' style='display:block;'>
        <table id='data_emp' class='table table-striped table-bordered table-hover' style='width: 800px; margin-left: 0px;'><thead><tr><td style='width: 37px;' align='left'><input type='checkbox' name='maincheck' id='maincheck' value='' onclick='checkAll()'></td><td style='width: 226px;'>Question Text</td><td style='width: 188px;'>Question Type</td><td style='width: 71px;'>Points</td></tr></thead></table>
        <div id='tablediv'  style='height:280px; overflow:auto; overflow-x:hidden;  margin-top:-20px; width:800px;'>
        <table id='inner_data_emp' class='table table-striped table-bordered table-hover' style='width:800px; margin-left:0px; margin-top:0px;'><tbody>";

        foreach($questionbank as $key=>$empdatas1){
            $keys=$key+1;
			$type=(isset($empdatas1['qtype']))?$empdatas1['qtype']:'';
            $ched=in_array($empdatas1['qid'],$qids) ? " checked='checked' disabled='disabled'" : "";
            echo "<tr><td style='width: 37px;' ><input type='checkbox' name='check[]' id='check[".$keys."]' ".$ched."  value=".$empdatas1['qid']."></td><td style='width: 239px;'><label for='qtext' id='qtext[".$keys."]'>".$empdatas1['qname']."</label></td><td style='width: 190px;'><label for='qtype' id='qtype[".$keys."]'>".$type."</label></td><td style='width: 50px;'><label for='points' id='points[".$keys."]'>".$empdatas1['points']."</label></td></tr>";
        }
        if(empty($questionbank)){
            $keys="";
            echo "<tr><td colspan='3'>No data found. </td></tr>";
        }
        echo "</table> </div></div>";
        echo "<div  class='modal-footer no-margin-top' >";
        if(!empty($questionbank)){

            echo " <input type='button'   aria-hidden='true' class='btn btn-sm btn-success'  name='go' id='go' value='Go' onclick='questionsids(".$keys.")'  /> </div>";
        }
    }

	 public function group_selected_questionslist(){
        $ids=$_REQUEST['qids'];
        $questions=UlsQuestions::get_selectd_questions($ids);
        echo "<table style='height: 40px;' class='table table-striped table-bordered table-hover' id='data_emp11' >
          <thead><tr><th style='width:15px;'>Select</th>
                    <th style='width: 200px;'>Question Text</th>
                    <th style='width: 164px;'>Question Type</th>
                    <th style='width: 80px;'>Points</th>
            </tr>
         </thead>
        </table>
       <div id='tablediv'  style='height:280px; margin-top: -24px; overflow:auto; overflow-x:hidden; '>
       <table id='data_emp'  class='table table-striped table-bordered table-hover'>
        <tbody id='questiondata'>" ;
        $addgpval='';
        foreach($questions as $key=>$empdatas1){
        if(empty($addgpval)){ $addgpval=$empdatas1['qid']; }
        else{  $addgpval= $addgpval.",".$empdatas1['qid']; }
        $keys=$key+1;
        echo "<tr><td style='width: 56px;text-align:center;'><input type='checkbox' name='check[]' id='check1[".$keys."]'  value=".$empdatas1['qid']."></td>"
                . "<td style='width: 198px; text-align:left;'><label for='qtext' id='qtext[".$keys."]'>".$empdatas1['qname']."</label></td>"
                . "<td style='width: 162px; text-align:center;'><label for='qtype' id='qtype[".$keys."]'>".$empdatas1['qtype']."</label></td>"
                . "<td style='width: 81px; text-align:center; '><label for='points' id='points[".$keys."]'>".$empdatas1['points']."</label></td></tr>";
        }
        echo"</tbody></table></div><input id='addgroup' type='hidden' value=".$addgpval." name='addgroup'> ";
    }

	public function addquestions_test(){
        $this->sessionexist();
        if(isset($_POST['submit'])){
            $qids=explode(',',$_POST['addgroup']);
            foreach($qids as $key=>$act){
                $qbid=Doctrine_Core::getTable('UlsQuestions')->findOneByQuestionId($act);
                $sd=Doctrine_Core::getTable('UlsCompetencyTestQuestions')->findOneByTestIdAndQuestionId($_POST['testid'],$act);
                if(empty($sd)){
                    $question_values=new UlsCompetencyTestQuestions();
                    $question_values->test_id=$_POST['testid'];
                    $question_values->question_id=$act;
                    $question_values->question_bank_id=$qbid->question_bank_id;
                    $question_values->save();
                }
            }
			redirect("admin/test_home");
        }
    }

	public function deletetestquestins(){
        $id=$_REQUEST['id'];
        $tid=$_REQUEST['tid'];
        //echo $id;echo $tid;
        if(!empty($id)){
			$test_quest=Doctrine_Query::Create()->from('UlsUtestAttempts')->where("test_id=".$tid)->execute();
			$test_quest1=Doctrine_Query::Create()->from('UlsUtestQuestions')->where("test_id=".$tid)->execute();
			if(count($test_quest)>0 || count($test_quest1)>0){
				echo "Selected Test cannot be deleted. So Questions can not be deleted.";
			}else{
				$del=Doctrine_Query::create()->delete('UlsTestQuestions')->where("question_id=".$id." and test_id=".$tid)->execute();
				echo 1;
			}
        }
    }


	public function change_level(){
		$id=$_REQUEST['id'];
		$scale=UlsLevelMasterScale::levelscale($id);
		$data="";
		$data="
		<select name='scale_id' id='scale_id' class='form-control m-b'>
			<option value=''>Select</option>";
			foreach($scale as $scales){
			$data.="<option value='".$scales['scale_id']."'>".$scales['scale_name']."</option>";
			}
		$data.="</select>";
		echo $data;
	}

	public function deletequestionbank(){
		$id=$_REQUEST['val'];
		if(!empty($id)){
			$question=Doctrine_Query::create()->from('UlsQuestions')->where("question_bank_id=".$id)->execute();
			if(count($question)>0){
				foreach($question as $questions){
					$questionsintest=Doctrine_Query::create()->from('UlsTestQuestions')->where("question_id=".$questions->question_id)->execute();
					if(count($questionsintest)>0){
						echo "Selected Question bank cannot be deleted. This Question bank is attached to Test so you cant delete it.";
						exit;
					}
					else{
						$del=Doctrine_Query::create()->delete('UlsQuestionValues')->where("question_id=".$questions['question_id'])->execute();
						$delq1=Doctrine_Query::Create()->delete('UlsCompetencyTestQuestions')->where("question_id=".$questions['question_id'])->execute();
						$delq=Doctrine_Query::Create()->delete('UlsQuestions')->where("question_id=".$questions['question_id'])->execute();
					}
				}
				$del=Doctrine_Query::create()->delete('UlsQuestionbank')->where("question_bank_id=".$id)->execute();
				echo 1;
			}
			else {
				$del=Doctrine_Query::create()->delete('UlsQuestionbank')->where("question_bank_id=".$id)->execute();
				echo 1;
			}
        }
    }

	public function deletequestion(){
        $id=$_REQUEST['val'];
        if(!empty($id) && is_numeric($id)){
			$tques=Doctrine_Query::Create()->from('UlsUtestQuestionsAssessment')->where('user_test_question_id='.$id)->execute();
			if(count($tques)>0){
				echo "Selected Question cannot be deleted.Employees have taken Test you cant Delete this Question.";
			}
			else {
				$del=Doctrine_Query::create()->delete('UlsQuestionValues')->where("question_id=".$id)->execute();
				$delq=Doctrine_Query::Create()->delete('UlsQuestions')->where("question_id=".$id)->execute();
				$dellv=Doctrine_Query::Create()->delete('UlsLangQuestionValues')->where("question_id=".$id)->execute();
				$dell=Doctrine_Query::Create()->delete('UlsQuestionsLanguage')->where("question_id=".$id)->execute();
				echo 1;
			}
		}
	}
	
	public function competencyattachedposition(){
		$comp_id=filter_input(INPUT_GET,'id') ? filter_input(INPUT_GET,'id'):"";
		if(!empty($comp_id)){
		$results=UlsCompetencyDefinition::competencyattachedposition($comp_id);
		
		}
		else{
			
		}
	}
	
	public function competencyattachedquestionbank(){
		$comp_id=filter_input(INPUT_GET,'id') ? filter_input(INPUT_GET,'id'):"";
		if(!empty($comp_id)){
		$results=UlsCompetencyDefinition::competencyattachedquestionbank($comp_id);
		$result_bank=UlsCompetencyDefinition::competencyattachedquestion_bank($comp_id);
		$data="";
		$data.="<div class='row'>
			<div class='col-md-6'>
				<h6 class='mb-15'>Following are the Question Banks mapped to this Competency</h6>
				<ol>";
				foreach($results as $result){
					$data.="<li>".$result['name']."</li>";
				}
				$data.="</ol>
			</div>
			<div class='col-md-6'> 
				<h6 class='mb-15'>Following are the Question Banks Attached to this competency</h6>
				<ol>";
				foreach($result_bank as $result_banks){
					$data.="<li>".$result_banks['name']."</li>";
				}
				$data.="</ol>
			</div>
		</div>";
		}
		echo $data;
	}
	
	

	public function competency_master_search(){
		$data["aboutpage"]=$this->pagedetails('admin','competency_master_search');
		$limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
        $comp_name=filter_input(INPUT_GET,'comp_name') ? filter_input(INPUT_GET,'comp_name'):"";
		//$comptype=filter_input(INPUT_GET,'comp_type') ? filter_input(INPUT_GET,'comp_type'):"";
		$comp_type=isset($_SESSION['emp_type'])?$_SESSION['emp_type']:"";
		$cat_type=filter_input(INPUT_GET,'cat_type') ? filter_input(INPUT_GET,'cat_type'):"";
        $page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
        $start=$page!=0? ($page-1)*$limit:0;
        $filePath=BASE_URL."/admin/competency_master_search";
        $data['limit']=$limit;
        $data['comp_name']=$comp_name;
        $data['perpages']=UlsMenuCreation::perpage();
		$data['pos_types']=UlsAdminMaster::get_value_names("POSTYPE");
		$data['comp_type']=$comp_type;
		$data['cat_type']=$cat_type;
		$data['cat_details']=UlsCategory::get_category_details_cat();
		$org=$this->session->userdata('security_org_id');
		$comps="";$comps2="";
		if($_SESSION['security_type']=='no'){
			$comps="";$comps2="";
		}
		elseif(!empty($org)){
			$comps=" and bu_id in (SELECT `organization_id` FROM `uls_organization_master` WHERE `division_id` in ($org) or `organization_id` in ($org))";
			$comps2=" and bu_id in (SELECT `organization_id` FROM `uls_organization_master` WHERE `division_id` in ($org) or `organization_id` in ($org))";
			if($_SESSION['parent_org_id']==$org){
				$sqbus="";
				$buss=UlsMenu::callpdo("SELECT distinct(`bu_id`) as buid  FROM `uls_location` WHERE `location_id` in (".$_SESSION['security_location_id'].")");
				foreach($buss as $k=>$bus2){
					if(empty($sqbus)){
						$sqbus.=" WHERE `division_id` in (".$bus2['buid'].") or `organization_id` in (".$bus2['buid'].")";
					}
					else{
						$sqbus.=" or `division_id` in (".$bus2['buid'].") or `organization_id` in (".$bus2['buid'].")";
					}
				}
				if(!empty($sqbus)){
					$comps=" and bu_id in (SELECT `organization_id` FROM `uls_organization_master` $sqbus)";
					$comps2=" and a.bu_id in (SELECT `organization_id` FROM `uls_organization_master` $sqbus)";
				}
			}
		}
		
        $data['searchresults']=UlsCompetencyDefinition::search($start, $limit,$comp_name,$comp_type,$cat_type,$comps2);
        $total=UlsCompetencyDefinition::searchcount($comp_name,$comp_type,$cat_type,$comps);
        $otherParams="&perpage=".$limit."&comp_name=$comp_name&comp_type=$comp_type&cat_type=$cat_type";
		$data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/competency_master_search',$data,true);
		$this->render('layouts/adminnew',$content);
	}

	public function competency_master()
	{
		$data["aboutpage"]=$this->pagedetails('admin','competency_master');
		$id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1){
            $content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			$data['pos_bu_name']=UlsOrganizationMaster::org_bu();
			$data['cat_details']=UlsCategory::get_category_details_cat();
			$data['subcat_details']=UlsCategory::get_category_details_subcat();
			$data['addcat_details']=UlsCategory::get_category_details_addcat();
			$data['levels']=UlsLevelMaster::levels();
			$data['status']=UlsAdminMaster::get_value_names("STATUS");
			$data['ass_methods']=UlsAdminMaster::get_value_names_comp("ASSESS_METHOD");
			$data['comp_types']=UlsAdminMaster::get_value_names("POSTYPE");
			$data['comp_str']=UlsAdminMaster::get_value_names("COMP_ASS");
			$data['comp_def']=UlsCompetencyDefinition::viewcompetency($id);
			$data['quesbanks']=UlsCompetencyDefQueBank::getcompdefquesbank($id);
			$data['intquestions']=UlsCompetencyDefIntQuestion::getcompdefintques($id);
			$case_stat="COMP_TEST";
			$data["comp_ques"]=UlsQuestionbank::get_questionbank_comp($id,$case_stat);
			$int_stat="COMP_INTERVIEW";
			$data["comp_interview"]=UlsQuestionbank::get_questionbank_comp($id,$int_stat);
			$content = $this->load->view('admin/competency_master',$data,true);
		}
		$this->render('layouts/adminnew',$content);
	}

	public function competency_insert(){
        $this->sessionexist();
        if(isset($_POST['comp_def_id'])){
            $fieldinsertupdates=array('comp_def_name','competency_type','bu_id','comp_def_category','comp_def_sub_category','comp_def_level','comp_def_short_desc','comp_def_key_coverage','comp_def_key_indicator','comp_def_status','comp_def_add_category','comp_structure','comp_def_name_alt');
            $case=Doctrine::getTable('UlsCompetencyDefinition')->find($_POST['comp_def_id']);
            !isset($case->comp_def_id)?$case=new UlsCompetencyDefinition():"";
            foreach($fieldinsertupdates as $val){
				$case->$val=(!empty($_POST[$val]))?($_POST[$val]):NULL;
			}
            $case->save();

			$this->session->set_flashdata('case',"Competency master data ".(!empty($case->comp_def_id)?"updated":"inserted")." successfully.");
			redirect('admin/competency_master?status=competency&id='.$case->comp_def_id.'&hash='.md5(SECRET.$case->comp_def_id));
        }
        else{
			$content = $this->load->view('admin/competency_master_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }

	public function comp_questionbank_insert(){
		$this->sessionexist();
		if(isset($_POST['comp_def_id'])){
			foreach($_POST['comp_def_que_bank_id'] as $key=>$value){
				$work_activation=(!empty($_POST['comp_def_que_bank_id'][$key]))?Doctrine::getTable('UlsCompetencyDefQueBank')->find($_POST['comp_def_que_bank_id'][$key]):new UlsCompetencyDefQueBank;
				$work_activation->master_ques_bank_id=$_POST['master_ques_bank_id'][$key];
				$work_activation->comp_def_id=$_POST['comp_def_id'];
				$work_activation->save();
			}
			$this->session->set_flashdata('case',"Competency Question banks has been ".(!empty($_POST['comp_def_id'])?"updated":"inserted")." successfully.");
			redirect('admin/competency_master?status=questions&id='.$_POST['comp_def_id'].'&hash='.md5(SECRET.$_POST['comp_def_id']));
		}
	}

	public function comp_interview_insert(){
		$this->sessionexist();
		if(isset($_POST['comp_def_inter_ques_id'])){
			foreach($_POST['comp_def_inter_ques_id'] as $key=>$value){
				$work_activation=(!empty($_POST['comp_def_inter_ques_id'][$key]))?Doctrine::getTable('UlsCompetencyDefIntQuestion')->find($_POST['comp_def_inter_ques_id'][$key]):new UlsCompetencyDefIntQuestion;
				$work_activation->master_int_ques_bank_id=$_POST['master_int_ques_bank_id'][$key];
				$work_activation->comp_def_id=$_POST['comp_def_id'];
				$work_activation->save();
			}
			$this->session->set_flashdata('case',"Competency Interview Question banks has been ".(!empty($_POST['comp_def_id'])?"updated":"inserted")." successfully.");
			redirect('admin/competency_master?status=questions&id='.$_POST['comp_def_id'].'&hash='.md5(SECRET.$_POST['comp_def_id']));
		}
	}

	public function delete_comp_questionbank(){
		if(!empty($_REQUEST['val'])){
			$play=Doctrine_Query::Create()->delete('UlsCompetencyDefQueBank')->where("comp_def_que_bank_id=".$_REQUEST['val'])->execute();
			echo 1;
		}
		else{
			echo "Selected Competency QuestionBank cannot be deleted. Ensure you delete all the usages of the Competency QuestionBank before you delete it.";
		}
	}

	public function delete_comp_interview(){
		if(!empty($_REQUEST['val'])){
			$play=Doctrine_Query::Create()->delete('UlsCompetencyDefIntQuestion')->where("comp_def_inter_ques_id=".$_REQUEST['val'])->execute();
			echo 1;
		}
		else{
			echo "Selected Interview QuestionBank cannot be deleted. Ensure you delete all the usages of the Interview QuestionBank before you delete it.";
		}
	}

	public function competency_levels()
	{
		$data["aboutpage"]=$this->pagedetails('admin','competency_levels');
		$id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1 || $id==""){
            $content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			$compdetails=UlsCompetencyDefinition::viewcompetency($id);
            $data['compdetails']=$compdetails;
			$data['ind_type']=UlsCompetencyLevelIndicatorMaster::indicator_master_new($compdetails['comp_def_id']);
			$data['levels']=UlsLevelMasterScale::levelscale($compdetails['comp_def_level']);
			$data['levelindicators']=UlsCompetencyDefLevelIndicator::getcompdeflevelind($compdetails['comp_def_id']);
			$loc_status="STATUS";
			$data["locstatusss"]=UlsAdminMaster::get_value_names($loc_status);
			$days="TNA_DAYS";
			$data["day_details"]=UlsAdminMaster::get_value_names($days);
			$data['ass_methods']=UlsAdminMaster::get_value_names("ASSESS_METHOD");
			$adminvalues="MIGRATE_TYPE";
			$data['migrations']=UlsAdminMaster::get_value_names($adminvalues);
			$data['comp_intquestions']=UlsAdminMaster::get_value_names("COMP_INT_QUESTION");
			$content = $this->load->view('admin/competency_level_master',$data,true);

		}
		$this->render('layouts/adminnew',$content);
	}

	public function lms_position_kra(){
        $this->sessionexist();
        if(isset($_POST['comp_position_req_id'])){
			$attachinsrtupdt=array('comp_kra_steps');
			foreach($_POST['comp_kra_steps'] as $key=>$value){
				$work_details_level=(!empty($_POST['comp_kra_id'][$key]))?Doctrine::getTable('UlsCompetencyPositionRequirementsKra')->find($_POST['comp_kra_id'][$key]):new UlsCompetencyPositionRequirementsKra;
				foreach($attachinsrtupdt as $att_val){
					 !empty($_POST[$att_val][$key])?$work_details_level->$att_val=trim($_POST[$att_val][$key]):Null;
				}
				$postion_req=UlsCompetencyPositionRequirements::get_competency_req_details($_POST['comp_position_req_id']);
				$work_details_level->comp_position_competency_id=$postion_req->comp_position_competency_id;
				$work_details_level->comp_position_id=$postion_req->comp_position_id;
				$work_details_level->comp_position_req_id=$postion_req->comp_position_req_id;
				$work_details_level->save();
			}
			$postion_req=UlsCompetencyPositionRequirements::get_competency_req_details($_POST['comp_position_req_id']);
			$this->session->set_flashdata('msg',"Position data ".(!empty($_POST['pos_id'])?"updated":"inserted")." successfully.");
			$hash=SECRET.$postion_req->comp_position_id;
            redirect('admin/position_update?eve_stat=evaluation&posid='.$postion_req->comp_position_id.'&hash='.md5($hash));
        }
        else{
			$content = $this->load->view('admin/position_search',$data,true);
			$this->render('layouts/adminnew',$content);
		}
    }

	public function competency_indicators(){
	$this->sessionexist();
	if(isset($_POST['scale_id'])){
		/* echo "<pre>";
		print_r($_POST);
		 */
		foreach($_POST['scale_id'] as $value){
			$comprgval=array('comp_def_level_ind_type'=>'comp_def_level_ind_type', 'comp_def_level_ind_name'=>'comp_def_level_ind_name');
			$vv=1;
			foreach($_POST['comp_def_level_ind_id'][$value] as $k=>$v){
				if(!empty($_POST['comp_def_level_ind_type'][$value][$k])){
					$work_activation=(!empty($v))?Doctrine::getTable('UlsCompetencyDefLevelIndicator')->find($v):new UlsCompetencyDefLevelIndicator;
					foreach($comprgval as $key=>$comprgvalues){
						$work_activation->$key=(isset($_POST[$comprgvalues][$value][$k]))?$_POST[$comprgvalues][$value][$k]:NULL;
					}
					$work_activation->comp_def_level_id=$value;
					$work_activation->comp_def_id=$_POST['comp_def_id'];
					$work_activation->save();
				}
				/* $vv++; */
			$vv++;
			}
		}
			$this->session->set_flashdata('indicator_message',"Level Indicator data ".(!empty($_POST['comp_def_id'])?"updated":"inserted")." successfully.");
			redirect('admin/competency_levels?id='.$_POST['comp_def_id'].'&hash='.md5(SECRET.$_POST['comp_def_id']),'admin-layout');
		}
	}
	
	public function competency_training_insert(){
		$this->sessionexist();
		if(isset($_POST['scale_id'])){
			$value=$_POST['scale_id'];
			$work_activation=(!empty($_POST['training_id']))?Doctrine::getTable('UlsCompetencyDefLevelTraining')->find($_POST['training_id']):new UlsCompetencyDefLevelTraining;
			$work_activation->program_title=!empty($_POST['program_title'][$value])?$_POST['program_title'][$value]: NULL;
			$work_activation->program_obj=!empty($_POST['program_obj'][$value])?$_POST['program_obj'][$value]: NULL;
			$work_activation->program_duration=!empty($_POST['program_duration'][$value])?$_POST['program_duration'][$value]: NULL;
			$work_activation->status=!empty($_POST['status'][$value])?$_POST['status'][$value]: NULL;
			$work_activation->comp_def_level_id=$value;
			$work_activation->comp_def_id=$_POST['comp_def_id'];
			$work_activation->save();
			$this->session->set_flashdata('indicator_message',"Training progam data ".(!empty($_POST['comp_def_id'])?"updated":"inserted")." successfully.");
			redirect('admin/competency_levels?id='.$_POST['comp_def_id'].'&hash='.md5(SECRET.$_POST['comp_def_id']),'admin-layout');
		}
	}

	public function competency_migration_map(){
		$this->sessionexist();
		if(isset($_POST['scale_id'])){
			$value=$_POST['scale_id'];
			$work_activation=(!empty($_POST['comp_def_level_migrate_id']))?Doctrine::getTable('UlsCompetencyDefLevelMigrationMaps')->find($_POST['comp_def_level_migrate_id']):new UlsCompetencyDefLevelMigrationMaps;
			$work_activation->from_level_id=$_POST['from_level_id'];
			$work_activation->to_level_id=!empty($_POST['to_level_id'])?$_POST['to_level_id']:NULL;
			$work_activation->comp_def_level_migrate_type=!empty($_POST['comp_def_level_migrate_type'][$value]) ? implode(",",$_POST['comp_def_level_migrate_type'][$value]) : NULL;
			$work_activation->comp_def_level_migrate_oth=!empty($_POST['comp_def_level_migrate_oth'][$value]) ? implode(",",$_POST['comp_def_level_migrate_oth'][$value]) : NULL;
			$work_activation->comp_def_level_ind_id=$value;
			$work_activation->comp_def_id=$_POST['comp_def_id'];
			$work_activation->save();
			$this->session->set_flashdata('indicator_message',"Level Indicator data ".(!empty($_POST['comp_def_id'])?"updated":"inserted")." successfully.");
			redirect('admin/competency_levels?id='.$_POST['comp_def_id'].'&hash='.md5(SECRET.$_POST['comp_def_id']),'admin-layout');
		}
	}

	public function competency_assessement_insert(){
		$this->sessionexist();
		if(isset($_POST['scale_id'])){
			$value=$_POST['scale_id'];
			foreach($_POST['comp_def_assess_type'] as $key=>$values){
				if(!empty($values)){
					$work_activation=(!empty($_POST['comp_def_level_assess_id'][$key]))?Doctrine::getTable('UlsCompetencyDefLevelAssessment')->find($_POST['comp_def_level_assess_id'][$key]):new UlsCompetencyDefLevelAssessment;
					$work_activation->comp_def_assess_type=$values;
					$work_activation->comp_def_assess_type_sub=!empty($_POST['comp_def_assess_type_sub'][$key])?$_POST['comp_def_assess_type_sub'][$key]:NULL;
					$work_activation->comp_def_level_ind_id=$value;
					$work_activation->comp_def_id=$_POST['comp_def_id'];
					$work_activation->save();
				}
			}
			$this->session->set_flashdata('indicator_message',"Level Indicator data ".(!empty($_POST['comp_def_id'])?"updated":"inserted")." successfully.");
			redirect('admin/competency_levels?id='.$_POST['comp_def_id'].'&hash='.md5(SECRET.$_POST['comp_def_id']),'admin-layout');
		}
	}

	public function delete_indicator(){
		if(!empty($_REQUEST['val'])){
			$play=Doctrine_Query::Create()->delete('UlsCompetencyDefLevelIndicator')->where("comp_def_level_ind_id=".$_REQUEST['val'])->execute();
			echo 1;
		}
		else{
			echo "Selected Indicator cannot be deleted. Ensure you delete all the usages of the Indicator before you delete it.";
		}
	}

	public function delete_migration_map(){
		if(!empty($_REQUEST['val'])){
			$mig=$_REQUEST['val1'];
			$migration=UlsCompetencyDefLevelMigrationMaps::getcompdeflevelmigmap_details($_REQUEST['val']);
			$others_migrations=isset($migration['comp_def_level_migrate_oth'])?explode(",",$migration['comp_def_level_migrate_oth']):array();
			$check_mig="";
			foreach($others_migrations as $key=>$others_migration){
				if($others_migration==$mig){
					$check_mig=$key;
				}

			}
			if(!empty($check_mig)){
				unset($others_migrations[$check_mig]);
				$play=Doctrine_Query::Create()->update('UlsCompetencyDefLevelMigrationMaps');
				$play->set('comp_def_level_migrate_oth','?',@implode(',',$others_migrations));
				$play->where("comp_def_level_migrate_id=".$_REQUEST['val'])->limit(1)->execute();
				echo 1;
			}

		}
	}

	public function delete_kra(){
		if(!empty($_REQUEST['id'])){
			$play=Doctrine_Query::Create()->delete('UlsCompetencyPositionRequirementsKra')->where("comp_kra_id=".$_REQUEST['id'])->execute();
			echo 1;
		}
		else{
			echo "Selected KRA cannot be deleted. Ensure you delete all the usages of the KRA before you delete it.";
		}
	}

	public function competency_master_view(){
		$data["aboutpage"]=$this->pagedetails('admin','competency_master_view');
        $id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1 || $id==""){
            $content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			$compdetails=UlsCompetencyDefinition::viewcompetency($id);
            $data['compdetails']=$compdetails;
			$data['levels']=UlsLevelMasterScale::levelscale($compdetails['comp_def_level']);
			$data['levelindicators']=UlsCompetencyDefLevelIndicator::getcompdeflevelind($compdetails['comp_def_id']);
			$data['levelmigrationmaps']=UlsCompetencyDefLevelMigrationMaps::getcompdeflevelmigmaps($compdetails['comp_def_id']);
			$data['levelassessments']=UlsCompetencyDefLevelAssessment::getcompdeflevelassessment($compdetails['comp_def_id']);
			
			$content = $this->load->view('admin/competency_master_view',$data,true);
        }
		$this->render('layouts/adminnew',$content);
    }
	
	public function competencypdf(){
		$this->load->library('pdfgenerator');
		$id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1 || $id==""){
            $content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
		else{
			$compdetails=UlsCompetencyDefinition::viewcompetency($id);
            $data['compdetails']=$compdetails;
			$data['levels']=UlsLevelMasterScale::levelscale($compdetails['comp_def_level']);
			$data['levelindicators']=UlsCompetencyDefLevelIndicator::getcompdeflevelind($compdetails['comp_def_id']);
			$data['levelmigrationmaps']=UlsCompetencyDefLevelMigrationMaps::getcompdeflevelmigmaps($compdetails['comp_def_id']);
			$data['levelassessments']=UlsCompetencyDefLevelAssessment::getcompdeflevelassessment($compdetails['comp_def_id']);
			//$data['levelquesbanks']=UlsCompetencyDefQueBank::getcompdefquesbank($compdetails['comp_def_id']);
			//$data['levelinterquestions']=UlsCompetencyDefLevelIntQuestion::getcompdefintques($compdetails['comp_def_id']);
			//$content = $this->load->view('admin/competency_master_view',$data,true);
			$content = $this->load->view('pdf/competency',$data,true);
		}
		//$content = $this->load->view('table_report2', $data, true);
		$filename = 'report_'.time();
		$this->pdfgenerator->generate($content, $filename, true, 'A4', 'portrait');
		//$this->render('layouts/ajax-layout',$content);
	}

	public function deletecompetencymaster(){
		$id=trim($_REQUEST['val']);
		if(!empty($id) && is_numeric($id)){
			$uewi=Doctrine_Query::create()->from('UlsLangQuestionValues')->where('lang_id='.$id)->execute();
			$uewi2=Doctrine_Query::create()->from('UlsQuestionsLanguage')->where('lang_id='.$id)->execute();
			if(count($uewi)==0 && count($uewi2)==0){
				$q = Doctrine_Query::create()->delete('UlsLanguageMaster')->where('lang_id=?',$id)->execute();
				echo 1;
			}
			
		}
	}

	public function competency_level_master(){
		$data=array();
		$data["aboutpage"]=$this->pagedetails('admin','competency_level_master');
		$content = $this->load->view('admin/competency_level_master',$data,true);
		$this->render('layouts/adminnew',$content);
	}

	public function competency_question_master(){
		$data=array();
		$content = $this->load->view('admin/competency_question_master',$data,true);
		$this->render('layouts/adminnew',$content);
	}

	public function competency_migration_map_master(){
		$data=array();
		$content = $this->load->view('admin/competency_migration_map_master',$data,true);
		$this->render('layouts/adminnew',$content);
	}

	public function competency_assessment_method_master(){
		$data=array();
		$content = $this->load->view('admin/competency_assessment_method_master',$data,true);
		$this->render('layouts/adminnew',$content);
	}

	public function delete_case_competency(){
		if(!empty($_REQUEST['val'])){
			$play=Doctrine_Query::Create()->delete('UlsCaseStudyCompMap')->where("case_map_id=".$_REQUEST['val'])->execute();
			echo 1;
		}
		else{
			echo "Selected Casestudy Competency cannot be deleted. Ensure you delete all the usages of the Casestudy Competency before you delete it.";
		}
	}

	public function delete_casetest_competency(){
		if(!empty($_REQUEST['val'])){
			$play=Doctrine_Query::Create()->delete('UlsCaseStudyQuestions')->where("casestudy_quest_id=".$_REQUEST['val'])->execute();
			echo 1;
		}
		else{
			echo "Selected Casestudy Questions cannot be deleted. Ensure you delete all the usages of the Casestudy Questions before you delete it.";
		}
	}



	public function case_study_master_search()
	{
		$data["aboutpage"]=$this->pagedetails('admin','case_study_master_search');
		$limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
        $cstudy_name=filter_input(INPUT_GET,'cstudy_name') ? filter_input(INPUT_GET,'cstudy_name'):"";
        $page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
        $start=$page!=0? ($page-1)*$limit:0;
        $filePath=BASE_URL."/admin/case_study_master_search";
        $data['limit']=$limit;
        $data['cstudy_name']=$cstudy_name;
        $data['perpages']=UlsMenuCreation::perpage();
        $data['searchresults']=UlsCaseStudyMaster::search($start, $limit,$cstudy_name);
        $total=UlsCaseStudyMaster::searchcount($cstudy_name);
        $otherParams="&perpage=".$limit."&cstudy_name=$cstudy_name";
		$data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/case_study_master_search',$data,true);
		$this->render('layouts/adminnew',$content);
	}

	public function case_study_master()
	{
		$data["aboutpage"]=$this->pagedetails('admin','case_study_master');
		$org_stat="STATUS";
        $data["orgstat"]=UlsAdminMaster::get_value_names($org_stat);
		$case_stat="CASESTUDY_TYPE";
        $data["casestat"]=UlsAdminMaster::get_value_names($case_stat);
		if(!empty($_REQUEST['id'])){
			$case="COMP_CASESTUDY";
			$data["case_study_test"]=UlsQuestionbank::get_questionbank_casestudy($case);
			$data["case_study"]=UlsCaseStudyMaster::viewcasestudy($_REQUEST['id']);
			$data["case_study_questions"]=UlsCaseStudyQuestions::viewcasestudyquestion($_REQUEST['id']);
		}
		//$data["competency"]=UlsCompetencyDefinition::competency_details();
		$data['competencymsdetails']=UlsCompetencyDefinition::competency_details("MS");
		$data['competencynmsdetails']=UlsCompetencyDefinition::competency_details("NMS");
		$content = $this->load->view('admin/case_study_master',$data,true);
		$this->render('layouts/adminnew',$content);
	}

	public function case_master_insert(){
        $this->sessionexist();
        if(isset($_POST['casestudy_id'])){
            $fieldinsertupdates=array('casestudy_name','casestudy_type','casestudy_description','casestudy_author','casestudy_link','casestudy_status');
            $case=Doctrine::getTable('UlsCaseStudyMaster')->find($_POST['casestudy_id']);
            !isset($case->casestudy_id)?$case=new UlsCaseStudyMaster():"";
            foreach($fieldinsertupdates as $val){
							$case->$val=(!empty($_POST[$val]))?($_POST[$val]):NULL;
						}
						$program_pic=!empty($_POST['casestudy_id'])?$case->casestudy_source:"";
						if(!empty($_FILES['casestudy_source']['name'])){
							$filename=str_replace(array(" ","'","&"),array("_","_","_"),$_FILES['casestudy_source']['name']);
						}
						else if(empty($_FILES['casestudy_source']['name']) && !empty($program_pic)){
							$filename=$program_pic;
						}
						else{
							$filename='';
						}
						if(!empty($filename)){
							$case->casestudy_source=$filename;
						}
						$case->save();
						if(!empty($_FILES['casestudy_source']['name'])){
							$uploaddir1= __SITE_PATH .DS.'public'.DS.'uploads'.DS.'casestudy'.DS.$case->casestudy_id;
							if(is_dir($uploaddir1)){
								$delpic=$uploaddir1."/".$case->casestudy_source;
								(!empty($delpic))?unlink($delpic):'';
								$fname=$filename;
								$target_path = $uploaddir1 .DS. $filename;
								move_uploaded_file($_FILES['casestudy_source']['tmp_name'], $target_path);
							}
							else{
								mkdir($uploaddir1,0777);
								$target_path = $uploaddir1.DS. $filename;
								$fname=$filename;
								move_uploaded_file($_FILES['casestudy_source']['tmp_name'], $target_path);
								$target_path = $uploaddir1 .DS. $filename;
								move_uploaded_file($_FILES['casestudy_source']['tmp_name'], $target_path);
							}
            }



						$this->session->set_flashdata('case',"Case master data ".(!empty($_POST['casestudy_id'])?"updated":"inserted")." successfully.");
            redirect('admin/case_study_master?status=competency&id='.$case->casestudy_id.'&hash='.md5(SECRET.$case->casestudy_id));
        }
        else{
			$content = $this->load->view('admin/case_study_master_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }

	public function casestudypdf(){
		$this->load->library('pdfgenerator');
		$id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
		$flag=0;
		if($flag==1 || $id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$case="COMP_INBASKET";
			$data["case_study"]=UlsCaseStudyMaster::viewcasestudy($_REQUEST['id']);
			$data["case_study_questions"]=UlsCaseStudyQuestions::viewcasestudyquestion($_REQUEST['id']);
			$content = $this->load->view('pdf/casestudy',$data,true);
		}
		$filename = "Case Study";
		$this->pdfgenerator->generate($content, $filename, true, 'A4', 'portrait','job_description');
	}

	public function casestudy_competency_insert(){
		$this->sessionexist();
		if(isset($_POST['casestudy_quest'])){
			$fieldinsertupdates=array('casestudy_quest','casestudy_quest_answer');
			$case=Doctrine::getTable('UlsCaseStudyQuestions')->find($_POST['casestudy_quest_id']);
            !isset($case->casestudy_quest_id)?$case=new UlsCaseStudyQuestions():"";
            foreach($fieldinsertupdates as $val){
				$case->$val=(!empty($_POST[$val]))?($_POST[$val]):NULL;
			}
			$case->casestudy_id=$_POST['casestudy_id'];
			$case->save();
			
			foreach($_POST['casestudy_competencies'] as $key=>$value){
				$work_activation=(!empty($_POST['case_map_id'][$key]))?Doctrine::getTable('UlsCaseStudyCompMap')->find($_POST['case_map_id'][$key]):new UlsCaseStudyCompMap;
				$work_activation->casestudy_quest_id=$case->casestudy_quest_id;
				$work_activation->comp_def_id=$value;
				$work_activation->level_id=$_POST['casestudy_level'][$key];
				$work_activation->scale_id=$_POST['casestudy_scale'][$key];
				$work_activation->casestudy_id=$_POST['casestudy_id'];
				$work_activation->save();
			}
			$this->session->set_flashdata('casestudy_admin',"Your casestudy competencies has been ".(!empty($_POST['casestudy_id'])?"updated":"inserted")." successfully.");
			redirect('admin/case_study_master?status=competency&id='.$_POST['casestudy_id']);
		}
	}

	public function casestudy_test_insert(){
		$this->sessionexist();
		if(isset($_POST['casestudy_quest_id'])){
			foreach($_POST['casestudy_quest_id'] as $key=>$value){
				$work_activation=(!empty($_POST['casestudy_quest_id'][$key]))?Doctrine::getTable('UlsCaseStudyQuestions')->find($_POST['casestudy_quest_id'][$key]):new UlsCaseStudyQuestions;
				$work_activation->casestudy_quest=$_POST['casestudy_quest'][$key];
				$work_activation->casestudy_id=$_POST['casestudy_id'];
				$work_activation->save();
			}
			$this->session->set_flashdata('casestudy_admin',"Your casestudy Test has been ".(!empty($_POST['casestudy_id'])?"updated":"inserted")." successfully.");
			redirect('admin/case_study_master?status=questions&id='.$_POST['casestudy_id']);
		}
	}

	public function case_study_view(){
		$data["aboutpage"]=$this->pagedetails('admin','case_study_view');
        $id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1 || $id==""){
            $content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			$compdetails=UlsCaseStudyMaster::viewcasestudy($id);
            $data['compdetails']=$compdetails;
			$data["case_study_questions"]=UlsCaseStudyQuestions::viewcasestudyquestion($compdetails['casestudy_id']);
			/* $data['questions']=UlsCaseStudyQuestions::getcasestudyquestions($compdetails['casestudy_id']);
			$data['competencies']=UlsCaseStudyCompetencies::getcasestudycompetencies($compdetails['casestudy_id']); */
			$content = $this->load->view('admin/case_study_master_view',$data,true);
        }
		$this->render('layouts/adminnew',$content);
    }

	public function deletecasestudy(){
		$id=trim($_REQUEST['val']);
		if(!empty($id) && is_numeric($id)){
			 $uewi=Doctrine_Query::create()->from('UlsCompetencyTest')->where('casestudy_id='.$id)->execute();
			if(count($uewi)==0){
				$q1 = Doctrine_Query::create()->delete('UlsCaseStudyQuestions')->where('casestudy_id=?',$id)->execute();
				$q2 = Doctrine_Query::create()->delete('UlsCaseStudyCompetencies')->where('casestudy_id=?',$id)->execute();
				$q = Doctrine_Query::create()->delete('UlsCaseStudyMaster')->where('casestudy_id=?',$id)->execute();
				echo 1;
			} 
			else{
				echo "Selected Casestudy cannot be deleted. Ensure you delete all the usages of the Casestudy before you delete it.";
			}
		}
		
	}
	
	public function inbasket_exercises_clone(){
		if(isset($_REQUEST['id'])){
			$inbasket_details=UlsInbasketMaster::viewinbasket($_REQUEST['id']);
			$case=new UlsInbasketMaster();
			$case->inbasket_name=$inbasket_details['inbasket_name']."-Mahan";
			$case->position_id=$inbasket_details['position_id'];
			$case->inbasket_narration=$inbasket_details['inbasket_narration'];
			$case->inbasket_instructions=$inbasket_details['inbasket_instructions'];
			$case->inbasket_time_period=$inbasket_details['inbasket_time_period'];
			$case->inbasket_action=$inbasket_details['inbasket_action'];
			$case->inbasket_scorting_order=$inbasket_details['inbasket_scorting_order'];
			$case->inbasket_status=$inbasket_details['inbasket_status'];
			$case->inbasket_tray_name=$inbasket_details['inbasket_tray_name'];
			$case->inbasket_reason=$inbasket_details['inbasket_reason'];
			$program_pic=!empty($inbasket_details['inbasket_upload'])?$inbasket_details['inbasket_upload']:"";
			if(!empty($program_pic)){
				$filename=$program_pic;
			}
			else{
				$filename='';
			}
			if(!empty($filename)){
				$case->inbasket_upload=$filename;
			}
			$case->save();
			if(!empty($program_pic)){
				$uploaddir1= __SITE_PATH .DS.'public'.DS.'uploads'.DS.'inbasket'.DS.$case->inbasket_id;
				if(is_dir($uploaddir1)){
					$delpic=$uploaddir1."/".$case->inbasket_upload;
					(!empty($delpic))?unlink($delpic):'';
					$fname=$filename;
					$target_path = $uploaddir1 .DS. $filename;
					move_uploaded_file($program_pic, $target_path);
				}
				else{
					mkdir($uploaddir1,0777);
					$target_path = $uploaddir1.DS. $filename;
					$fname=$filename;
					move_uploaded_file($program_pic, $target_path);
				}
            }
			$question_bank=new UlsQuestionbank();
			$question_bank->name=$case->inbasket_name;
			$question_bank->active_flag='P';
			$question_bank->type='COMP_INBASKET';
			$question_bank->inbasket_id=$case->inbasket_id;
			$question_bank->save();
			
			$question=new UlsQuestions();
			$question->question_bank_id=$question_bank->question_bank_id;
			$question->question_name=$case->inbasket_instructions;
			$question->question_category='T';
			$question->question_type='P';
			$question->active_flag=NULL;
			$question->multi_language='no';
			$question->sequence='P';
			$question->save();
			
			$question_view=UlsQuestionValues::get_allquestion_values_competency($inbasket_details['question_id']);
			foreach($question_view as $question_views){
				$question_values=new UlsQuestionValues();
				$question_values->question_id=$question->question_id;
				$question_values->text=$question_views['text'];
				$question_values->suggestion_inbasket=!empty($question_views['suggestion_inbasket'])?$question_views['suggestion_inbasket']:NULL;
				$question_values->reason_inbasket=!empty($question_views['reason_inbasket'])?$question_views['reason_inbasket']:NULL;
				$question_values->priority_inbasket=!empty($question_views['priority_inbasket'])?$question_views['priority_inbasket']:NULL;
				$question_values->start_date_active=date('Y-m-d');
				$question_values->end_date_active=date('Y-m-d');
				$question_values->comp_def_id=$question_views['comp_def_id'];
				$question_values->scale_id=$question_views['scale_id'];
				$question_values->scorting_order=$question_views['scorting_order'];
				$question_values->inbasket_mode=$question_views['inbasket_mode'];
				$question_values->save();
			}
			redirect('admin/inbasket_exercises_master?status&id='.$case->inbasket_id);
		}
	}

	public function inbasket_exercises_master_search()
	{
		$data["aboutpage"]=$this->pagedetails('admin','inbasket_exercises_master_search');
		$limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
        $inbasket=filter_input(INPUT_GET,'inbasket') ? filter_input(INPUT_GET,'inbasket'):"";
        $page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
        $start=$page!=0? ($page-1)*$limit:0;
        $filePath=BASE_URL."/admin/inbasket_exercises_master_search";
        $data['limit']=$limit;
        $data['inbasket']=$inbasket;
        $data['perpages']=UlsMenuCreation::perpage();
        $data['searchresults']=UlsInbasketMaster::search($start, $limit,$inbasket);
        $total=UlsInbasketMaster::searchcount($inbasket);
        $otherParams="&perpage=".$limit."&inbasket=$inbasket";
		$data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/inbasket_exercises_master_search',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function inbasketpdf(){
		$this->load->library('pdfgenerator');
		$id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
		//$hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
		$flag=0;//!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
		if($flag==1 || $id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$case="COMP_INBASKET";
			$data["inbas_test"]=UlsQuestionbank::get_questionbank_casestudy($case);
			$inbasket_details=UlsInbasketMaster::viewinbasket($_REQUEST['id']);
			$data["inbasket"]=$inbasket_details;
			$data["inbasket_comp"]=UlsCompetencyPositionRequirements::getcompetencypositionrequirements($inbasket_details['position_id']);
			$content = $this->load->view('pdf/inbasket',$data,true);
		}
		//$content = $this->load->view('table_report2', $data, true);
		$filename = "In-Basket";
		$this->pdfgenerator->generate($content, $filename, true, 'A4', 'portrait','job_description');
		//$this->render('layouts/ajax-layout',$content);
	}

	public function inbasket_exercises_master()
	{
		$data["aboutpage"]=$this->pagedetails('admin','inbasket_master');
		$org_stat="STATUS";
        $data["orgstat"]=UlsAdminMaster::get_value_names($org_stat);
		$yes_stat="YES_NO";
        $data["yesstat"]=UlsAdminMaster::get_value_names($yes_stat);
		$data['positions']=UlsPosition::pos_orgbased_all();
		if(!empty($_REQUEST['id'])){
			$case="COMP_INBASKET";
			$data["inbas_test"]=UlsQuestionbank::get_questionbank_casestudy($case);
			$inbasket_details=UlsInbasketMaster::viewinbasket($_REQUEST['id']);
			$data["inbasket"]=$inbasket_details;
			$data["inbasket_comp"]=UlsCompetencyPositionRequirements::getcompetencypositionrequirements($inbasket_details['position_id']);
			
		}
		$data["competency"]=UlsCompetencyDefinition::competency_details();
		$content = $this->load->view('admin/inbasket_exercises_master',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function competency_indicator_data(){
		$comp_id=$_REQUEST['comp_id'];
		$scale_id=$_REQUEST['scale_id'];
		$level_indicator=UlsCompetencyDefLevelIndicator::getcompdeflevelind_details($comp_id,$scale_id);
		$comp_name=UlsCompetencyDefinition::competency_detail_single($comp_id);
		$yes_stat="IN_MODE";
        $mode=UlsAdminMaster::get_value_names($yes_stat);
		echo "<h6 class='txt-dark capitalize-font'>Indicators
		<div class='pull-right'>					
			<a class='btn btn-danger btn-xs' data-original-title='PDF' target='_blank' href='".BASE_URL."/admin/competencypdf?id=".$comp_id."&hash=".md5(SECRET.$comp_id)."'>&nbsp  View Competency Profile &nbsp </a>
		</div>
		</h6>
		<hr class='light-grey-hr'>
		";
		echo "<select multiple id='public-methods' name='public-methods[]'>";
			foreach($level_indicator as $level_indicators){		
				echo "<option value='".$level_indicators['comp_def_level_ind_name']."'>".$level_indicators['comp_def_level_ind_name']."</option>";
			}			
		echo "</select>
		<div class='button-box'> 
			<a id='select-all' class='btn btn-danger btn-outline mr-10 mt-15' href='#'>select all</a> 
			<a id='deselect-all' class='btn btn-info btn-outline mr-10 mt-15' href='#'>deselect all</a>
		</div>
		<div class='clearfix'></div>
		<hr class='light-grey-hr'>
		<div class='panel panel-default card-view'>
			<div class='panel-heading'>
				<div class='pull-left'>
					<h6 class='panel-title inline-block txt-dark'>Enter InTray Details</h6>
				</div>
				<div class='pull-right'>
					<a class='label label-info capitalize-font inline-block' onclick='work_info_view(".$comp_id.",".$scale_id.")' data-toggle='modal' href='#workinfoview'>View Previous Intray of ".$comp_name['comp_def_name']."</a>
				</div>
				<div class='clearfix'></div>
			</div>
			<div class='panel-wrapper collapse in'>
			<div class='panel-body'>
				<div class='form-group col-lg-6'>
					<div class='form-group'>
						<label class='control-label mb-10 text-left'>Mode<sup><font color='#FF0000'>*</font></sup>:</label>
						<select style='width: 100%' name='in_mode' id='in_mode' class='form-control m-b validate[required]'>
							<option value=''>Select</option>";
							foreach($mode as $modes){
								echo "<option value='".$modes['code']."'>".$modes['name']."</option>";
							}
						echo "</select>
					</div>
					<div class='form-group'>
						<div class='form-group'>
							<label class='control-label mb-10 text-left'>Time Intervel<sup><font color='#FF0000'>*</font></sup>:</label>
							<input type='text' name='in_period' id='in_period' class='validate[required] form-control' value='' />
								
						</div>
					</div>
					<div class='form-group'>
						<label class='control-label mb-10 text-left'>From:</label>
						<input type='text' class='form-control' name='in_from' id='in_from'>
					</div>
					<div class='form-group'>
						<div class='form-group'>
							<label class='control-label mb-10 text-left'>Subject:</label>
							<input type='text' name='subject_inbasket' id='subject_inbasket' class='form-control' value='' />
								
						</div>
					</div>
					<div class='form-group'>
						<label class='control-label mb-10 text-left'>Suggestions<sup><font color='#FF0000'>*</font></sup>:</label>
						<textarea rows='5' class='form-control' name='suggestion_inbasket' id='suggestion_inbasket'></textarea>
					</div>
					
				</div>
				<div class='col-lg-6'>
					<div class='form-group'>
						<label class='control-label mb-10 text-left'>Enter InTray Details<sup><font color='#FF0000'>*</font></sup>:</label>
						<textarea rows='8' class='form-control validate[required]' name='inbasket_answer' id='inbasket_answer'></textarea>
					</div>
					<div class='form-group'>
						<label class='control-label mb-10 text-left'>Multilingual InTray Details:</label>
						<textarea rows='8' class='form-control' name='inbasket_answer_lang' id='inbasket_answer_lang'></textarea>
					</div>
					<div class='form-group'>
						<div class='form-group'>
							<label class='control-label mb-10 text-left'>Priority:</label>
							<input type='text' name='priority_inbasket' id='priority_inbasket' class='form-control' value='' />
								
						</div>
					</div>
					<div class='form-group'>
						<label class='control-label mb-10 text-left'>Reason:</label>
						<textarea rows='5' class='form-control' name='reason_inbasket' id='reason_inbasket'></textarea>
					</div>
				</div>
			</div>
		</div>
		</div>
		<div id='workinfoview'  class='modal fade' tabindex='-1' role='dialog'  aria-hidden='true'>
			<div class='modal-dialog'>
				<div class='modal-content'>
					<div class='color-line'></div>
					<div class='modal-header'>
						<h6 class='modal-title'>View All InTray Details</h6>
						<button type='button' class='btn btn-default pull-right' data-dismiss='modal'>X</button>
					</div>
					<div class='modal-body'>
						<div id='workinfodetails' class='modal-body no-padding'>
						
						</div>
					</div>
					
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>
		";
	}
	
	public function comptency_view_intray(){
		$comp_id=$_REQUEST['comp_id'];
		$scale_id=$_REQUEST['scale_id'];
		$comp_scale_view=UlsQuestionValues::get_allquestion_comp_values($comp_id,$scale_id);
		$data="";
		$data.="<div class='panel-body'>
			<ul class='list-icons'>";
			foreach($comp_scale_view as $comp_scale_views){
				$data.="<li class='mb-10'><i class='fa fa-angle-double-right text-info mr-5'></i>".$comp_scale_views['text']."</li>";
			}
			$data.="</ul>
		</div>";
		echo $data;
	}

	public function inbasket_insert(){
        $this->sessionexist();
        if(isset($_POST['inbasket_id'])){
            $fieldinsertupdates=array('inbasket_name','position_id','inbasket_narration','inbasket_instructions','inbasket_time_period','inbasket_action','inbasket_scorting_order','inbasket_status','inbasket_tray_name','inbasket_reason','inbasket_narration_lang');
            $case=!empty($_POST['inbasket_id'])?Doctrine::getTable('UlsInbasketMaster')->find($_POST['inbasket_id']):new UlsInbasketMaster();
			foreach($fieldinsertupdates as $val){
				$case->$val=(!empty($_POST[$val]))?($_POST[$val]):NULL;
			}
			$program_pic=!empty($_POST['inbasket_id'])?$case->inbasket_upload:"";
			if(!empty($_FILES['inbasket_upload']['name'])){
				$filename=str_replace(array(" ","'","&"),array("_","_","_"),$_FILES['inbasket_upload']['name']);
			}
			else if(empty($_FILES['inbasket_upload']['name']) && !empty($program_pic)){
				$filename=$program_pic;
			}
			else{
				$filename='';
			}
			if(!empty($filename)){
				$case->inbasket_upload=$filename;
			}
			$case->save();
			if(!empty($_FILES['inbasket_upload']['name'])){
				$uploaddir1= __SITE_PATH .DS.'public'.DS.'uploads'.DS.'inbasket'.DS.$case->inbasket_id;
				if(is_dir($uploaddir1)){
					$delpic=$uploaddir1."/".$case->inbasket_upload;
					(!empty($delpic))?unlink($delpic):'';
					$fname=$filename;
					$target_path = $uploaddir1 .DS. $filename;
					move_uploaded_file($_FILES['inbasket_upload']['tmp_name'], $target_path);
				}
				else{
					mkdir($uploaddir1,0777);
					$target_path = $uploaddir1.DS. $filename;
					$fname=$filename;
					move_uploaded_file($_FILES['inbasket_upload']['tmp_name'], $target_path);
					$target_path = $uploaddir1 .DS. $filename;
					move_uploaded_file($_FILES['inbasket_upload']['tmp_name'], $target_path);
				}
            }
			$question_bank=!empty($_POST['questionbank_id'])? Doctrine_Core::getTable('UlsQuestionbank')->find($_POST['questionbank_id']):new UlsQuestionbank();
			$question_bank->name=$case->inbasket_name;
			$question_bank->active_flag='P';
			$question_bank->type='COMP_INBASKET';
			$question_bank->inbasket_id=$case->inbasket_id;
			$question_bank->save();
			
			$question=!empty($_POST['question_id'])? Doctrine_Core::getTable('UlsQuestions')->find($_POST['question_id']):new UlsQuestions();
			$question->question_bank_id=$question_bank->question_bank_id;
			$question->question_name=$case->inbasket_instructions;
			$question->question_category='T';
			$question->question_type='P';
			$question->active_flag=NULL;
			$question->multi_language='no';
			$question->sequence='P';
			$question->save();
			
			$this->session->set_flashdata('inbasket',"Inbasket master data ".(!empty($_POST['inbasket_id'])?"updated":"inserted")." successfully.");
			redirect('admin/inbasket_exercises_master?status=competency&id='.$case->inbasket_id.'&hash='.md5(SECRET.$case->inbasket_id));
        }
        else{
			$content = $this->load->view('admin/inbasket_exercises_master_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }

	public function inbasket_competency_insert(){
		$this->sessionexist();
		if(isset($_POST['competency_id'])){
			$mode_action=$_POST['in_mode'];
			$period_action=$_POST['in_period'];
			$from_action=!empty($_POST['in_from'])?$_POST['in_from']:"";
			$subject_inbasket=!empty($_POST['subject_inbasket'])?$_POST['subject_inbasket']:"";
			$results[]= array('mode' => $mode_action, 'period' => $period_action,'from' => $from_action,'subject' => $subject_inbasket);
			$output = ($results);
			$inbasket_action=json_encode($output);
			$comp_inbasket=explode("-",$_POST['competency_id']);
			$q_count=UlsQuestionValues::get_allquestion_values($_POST['question_id']);
			$ques_count=(count($q_count)+1);
			$question_values=!empty($_POST['value_id'])? Doctrine_Core::getTable('UlsQuestionValues')->find($_POST['value_id']):new UlsQuestionValues();
			$question_values->question_id=$_POST['question_id'];
			$question_values->text=$_POST['inbasket_answer'];
			$question_values->text_lang=!empty($_POST['inbasket_answer_lang'])?$_POST['inbasket_answer_lang']:NULL;
			$question_values->suggestion_inbasket=!empty($_POST['suggestion_inbasket'])?$_POST['suggestion_inbasket']:NULL;
			$question_values->reason_inbasket=!empty($_POST['reason_inbasket'])?$_POST['reason_inbasket']:NULL;
			$question_values->priority_inbasket=!empty($_POST['priority_inbasket'])?$_POST['priority_inbasket']:NULL;
			$question_values->start_date_active=date('Y-m-d');
			$question_values->end_date_active=date('Y-m-d');
			$question_values->comp_def_id=$comp_inbasket[0];
			$question_values->scale_id=$comp_inbasket[1];
			$question_values->scorting_order=$ques_count;
			$question_values->inbasket_mode=$inbasket_action;
			$question_values->save();
			
			$this->session->set_flashdata('inbasket',"Your Inbasket competencies has been ".(!empty($_POST['inbasket_id'])?"updated":"inserted")." successfully.");
			redirect('admin/inbasket_exercises_master?status=competency&id='.$_POST['inbasket_id'].'&hash='.md5(SECRET.$_POST['inbasket_id']));
		}
	}

	public function inbasket_test_insert(){
		$this->sessionexist();
		if(isset($_POST['inbasket_id'])){
			foreach($_POST['value_id'] as $key=>$value){
				$work_activation=(!empty($_POST['value_id'][$key]))?Doctrine::getTable('UlsQuestionValues')->find($_POST['value_id'][$key]):new UlsQuestionValues;
				$work_activation->scorting_order=$key+1;
				$work_activation->save();
			}
			$this->session->set_flashdata('inbasket',"Your inbasket Test has been ".(!empty($_POST['inbasket_id'])?"updated":"inserted")." successfully.");
			redirect('admin/inbasket_exercises_master?status=questions&id='.$_POST['inbasket_id'].'&hash='.md5(SECRET.$_POST['inbasket_id']));
		}
	}

	public function delete_inbasket_competency(){
		if(!empty($_REQUEST['val'])){
			$play=Doctrine_Query::Create()->delete('UlsInbasketCompetencies')->where("inbasket_comp_id=".$_REQUEST['val'])->execute();
			echo 1;
		}
		else{
			echo "Selected Inbasket Competency cannot be deleted. Ensure you delete all the usages of the Inbasket Competency before you delete it.";
		}
	}

	public function delete_inbasket_test(){
		if(!empty($_REQUEST['val'])){
			$play=Doctrine_Query::Create()->delete('UlsInbasketElements')->where("inbasket_element_id=".$_REQUEST['val'])->execute();
			echo 1;
		}
		else{
			echo "Selected Inbasket Test cannot be deleted. Ensure you delete all the usages of the Inbasket Test before you delete it.";
		}
	}

	public function inbasket_view(){
		$data["aboutpage"]=$this->pagedetails('admin','inbasket_view');
        $id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1 || $id==""){
            $content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			$compdetails=UlsInbasketMaster::viewinbasket($id);
            $data['compdetails']=$compdetails;
			$data['elements']=UlsInbasketElements::getinbasketelements($compdetails['inbasket_id']);
			$data['competencies']=UlsInbasketCompetencies::getinbasketcompetencies($compdetails['inbasket_id']);
			$content = $this->load->view('admin/inbasket_exercises_master_view',$data,true);
        }
		$this->render('layouts/adminnew',$content);
    }

	public function deleteinbasket(){
		$id=trim($_REQUEST['val']);
		if(!empty($id) && is_numeric($id)){
			 $uewi=Doctrine_Query::create()->from('UlsCompetencyTest')->where('inbasket_id='.$id)->execute();
			if(count($uewi)==0){
				$q1 = Doctrine_Query::create()->delete('UlsInbasketElements')->where('inbasket_id=?',$id)->execute();
				$q2 = Doctrine_Query::create()->delete('UlsInbasketCompetencies')->where('inbasket_id=?',$id)->execute();
				$q = Doctrine_Query::create()->delete('UlsInbasketMaster')->where('inbasket_id=?',$id)->execute();
				echo 1;
			} 
			else{
				echo "Selected Inbasket cannot be deleted. Ensure you delete all the usages of the Inbasket before you delete it.";
			}
		}
	}

	public function assessor_search()
	{
		$data["aboutpage"]=$this->pagedetails('admin','assessor_search');
		$limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
        $assessors=filter_input(INPUT_GET,'assessors') ? filter_input(INPUT_GET,'assessors'):"";
        $page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
        $start=$page!=0? ($page-1)*$limit:0;
        $filePath=BASE_URL."/admin/assessor_search";
        $data['limit']=$limit;
        $data['assessors']=$assessors;
        $data['perpages']=UlsMenuCreation::perpage();
        $data['searchresults']=UlsAssessorMaster::search($start, $limit,$assessors);
        $total=UlsAssessorMaster::searchcount($assessors);
        $otherParams="&perpage=".$limit."&assessors=$assessors";
		$data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/Assessor_search',$data,true);
		$this->render('layouts/adminnew',$content);
	}

	public function assessor_master()
	{
		$data["aboutpage"]=$this->pagedetails('admin','assessor_master');
		$permit_type="YES_NO";
        $data["permit"]=UlsAdminMaster::get_value_names($permit_type);
		$assessor_type="ASSESSOR_TYPE";
        $data["assessor"]=UlsAdminMaster::get_value_names($assessor_type);
		$org_stat="STATUS";
        $data["orgstat"]=UlsAdminMaster::get_value_names($org_stat);
		$inst="BEHAVORIAL_INSTRUMENT";
        $data["instruments"]=UlsAdminMaster::get_value_names($inst);
		if(!empty($_REQUEST['id'])){
			$data["assessor_comp"]=UlsAssessorCompetencies::getassessorcompetencies($_REQUEST['id']);
			$data["assessor_int"]=UlsAssessorCertifiedInstruments::getassessorinstruments($_REQUEST['id']);
			$compdetails=UlsAssessorMaster::viewassessor($_REQUEST['id']);
            $data['compdetails']=$compdetails;
			if($compdetails['assessor_type']=='EXT'){
				if($compdetails['assessor_add_role']=="Y"){
					$data['traineruserdetail']=Doctrine::getTable('UlsUserCreation')->find($compdetails['user_id']);
				}
			}

		}
		$data["competency"]=UlsCompetencyDefinition::competency_details();
		$content = $this->load->view('admin/assessor_master',$data,true);
		$this->render('layouts/adminnew',$content);
	}

	public function delete_assessor_competency(){
		if(!empty($_REQUEST['val'])){
			$play=Doctrine_Query::Create()->delete('UlsAssessorCompetencies')->where("assessor_comp_id=".$_REQUEST['val'])->execute();
			echo 1;
		}
		else{
			echo "Selected Assessor Competency cannot be deleted. Ensure you delete all the usages of the Assessor Competency before you delete it.";
		}
	}

	public function assessor_insert(){
        $this->sessionexist();
        if(isset($_POST['assessor_id'])){
			/* echo "<pre>";
			print_r($_POST); */
			if($_POST['assessor_type']=='INT'){
				$refval=array('employee_id'=>'employee_id','assessor_type'=>'assessor_type', 'assessor_name'=>'assessor_name', 'assessor_linkedin_profile'=>'assessor_linkedin_profile', 'assessor_brief'=>'assessor_brief', 'assessor_email'=>'assessor_email', 'assessor_mobile'=>'assessor_mobile', 'assessor_experience'=>'assessor_experience', 'assessor_prev_org_name'=>'assessor_prev_org_name', 'premission_to_add_quest'=>'premission_to_add_quest', 'assessor_status'=>'assessor_status','assessor_photo'=>'assessor_photo', 'assessor_add_role'=>'add_role_int', 'user_id'=>'user_id_int');

			}
			
			if($_POST['assessor_type']=='EXT'){
				$refval=array('assessor_type'=>'assessor_type', 'assessor_name'=>'assessor_name', 'assessor_linkedin_profile'=>'assessor_linkedin_profile', 'assessor_brief'=>'assessor_brief', 'assessor_email'=>'assessor_email', 'assessor_mobile'=>'assessor_mobile', 'assessor_experience'=>'assessor_experience', 'assessor_prev_org_name'=>'assessor_prev_org_name', 'premission_to_add_quest'=>'premission_to_add_quest', 'assessor_status'=>'assessor_status','assessor_photo'=>'assessor_photo', 'assessor_add_role'=>'add_role_ext', 'user_id'=>'user_id_ext');
			}
            $resdef=(!empty($_POST['assessor_id']))?Doctrine::getTable('UlsAssessorMaster')->find($_POST['assessor_id']):new UlsAssessorMaster();
			foreach($refval as $key=>$reference_val){
				$resdef->$key=(!empty($_POST[$reference_val]))?$_POST[$reference_val]:NULL;
			}
            $program_pic=$resdef->assessor_photo;
			if(!empty($_FILES['assessor_photo']['name'])){
            $filename=str_replace(array(" ","'","&"),array("_","_","_"),$_FILES['assessor_photo']['name']);
            }else if(empty($_FILES['assessor_photo']['name']) && !empty($program_pic)){
                $filename=$program_pic;
            }else{
                $filename='';
            }
            $resdef->assessor_photo=$filename;
            $resdef->save();
			$res_def_id=$resdef->assessor_id;
			if(!empty($_FILES['assessor_photo']['name'])){
				$uploaddir1= __SITE_PATH .DS.'public'.DS.'uploads'.DS.'assessor_pic';
                if(is_dir($uploaddir1)){
					$delpic=$uploaddir1.'/'.$resdef->assessor_photo;
                    (!empty($delpic))?unlink($delpic):'';
                    $fname=$filename;
					$target_path = $uploaddir1 .DS. $filename;
                    move_uploaded_file($_FILES['assessor_photo']['tmp_name'], $target_path);
                }
                else{
                    mkdir($uploaddir1,0777);
                    $target_path = $uploaddir1.DS. $filename;
                    $fname=$filename;
					move_uploaded_file($_FILES['assessor_photo']['tmp_name'], $target_path);
					$target_path = $uploaddir1 .DS. $filename;
                    move_uploaded_file($_FILES['assessor_photo']['tmp_name'], $target_path);
                }
            }
			if($_POST['resr_type_int']=='I'){
				if(!empty($_POST['user_id_int']) && !empty($_POST['rolename_int'])){
					if(!empty($_POST['rolename_int'])){
						$checkrole=Doctrine_Query::Create()->from('UlsUserRole')->where("user_id=".$_POST['user_id_int']." and role_id=".$_POST['rolename_int'])->fetchOne();
					}
					$userrole=isset($checkrole->user_role_id)?Doctrine::getTable('UlsUserRole')->find($checkrole->user_role_id):new UlsUserRole();
					//$userrole=new UlsUserRole();
					$userrole->user_id=$_POST['user_id_int'];
					$userrole->role_id=$_POST['rolename_int'];
					$userrole->menu_id=$_POST['menu_id_int'];
					$userrole->start_date=date('Y-m-d',strtotime($_POST['start_date_int']));
					$userrole->end_date=date('Y-m-d',strtotime($_POST['end_date_int']));
					$userrole->save();
					
					$userdata=Doctrine::getTable('UlsUserCreation')->find($_POST['user_id_int']);
					$userdata->assessor_id=$res_def_id;
					$userdata->save();
				}
			}
			if($_POST['resr_type_ext']=='E'){
				if(!empty($_POST['user_name'])){
					$usrval=array('user_name'=>'user_name','password'=>'password', 'email_address'=>'assessor_email');
					$usrdt=array('start_date'=>'start_date_ext','end_date'=>'end_date_ext');
					$userdata=(!empty($_POST['user_id_ext']))?Doctrine::getTable('UlsUserCreation')->find($_POST['user_id_ext']):new UlsUserCreation;
					$userdata->assessor_id=$res_def_id;
					foreach($usrval as $key=>$reference_val){
						$userdata->$key=(!empty($_POST[$reference_val]))?$_POST[$reference_val]:NULL;
					}
					foreach($usrdt as $key=>$usrdate){
						$userdata->$key=(!empty($_POST[$usrdate]))?date('Y-m-d',strtotime($_POST[$usrdate])):NULL;
					}
					$userdata->parent_org_id=$this->session->userdata('parent_org_id');
					$userdata->user_type='EMP';
					$userdata->save();
					$user_id=$userdata->user_id;
					if(!empty($_POST['rolename_ext'])){
						$checkrole=Doctrine_Query::Create()->from('UlsUserRole')->where("user_id=$user_id and role_id=".$_POST['rolename_ext'])->fetchOne();
					}
					$userrole=isset($checkrole->user_role_id)?Doctrine::getTable('UlsUserRole')->find($checkrole->user_role_id):new UlsUserRole();
					$userrole->user_id=$user_id;
					$userrole->role_id=(!empty($_POST['rolename_ext']))?$_POST['rolename_ext']:NULL;
					$userrole->menu_id=(!empty($_POST['menu_id_ext']))?$_POST['menu_id_ext']:NULL;
					$userrole->start_date=date('Y-m-d',strtotime($_POST['start_date_ext']));
					$userrole->end_date=date('Y-m-d',strtotime($_POST['end_date_ext']));
					$userrole->save();

					$upd=Doctrine_Query::Create()->update('UlsAssessorMaster');
					$upd->set('user_id','?',$user_id);
					$upd->where('assessor_id=?',$res_def_id);
					$upd->execute();
				}
			}

			$this->session->set_flashdata('assessor',"Assessor master data ".(!empty($_POST['assessor_id'])?"updated":"inserted")." successfully.");
            redirect('admin/assessor_master?status=competency&id='.$resdef->assessor_id.'&hash='.md5(SECRET.$resdef->assessor_id));
        }
        else{
			$content = $this->load->view('admin/assessor_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }

	public function assessor_competency_insert(){
		$this->sessionexist();
		if(isset($_POST['assessor_comp_id'])){
			foreach($_POST['assessor_comp_id'] as $key=>$value){
				$work_activation=(!empty($_POST['assessor_comp_id'][$key]))?Doctrine::getTable('UlsAssessorCompetencies')->find($_POST['assessor_comp_id'][$key]):new UlsAssessorCompetencies;
				$work_activation->assessor_competencies=$_POST['assessor_competencies'][$key];
				$work_activation->assessor_levels=$_POST['assessor_levels'][$key];
				$work_activation->assessor_scale=$_POST['assessor_scale'][$key];
				$work_activation->assessor_id=$_POST['assessor_id'];
				$work_activation->save();
			}
			$this->session->set_flashdata('assessor',"Assessor competencies has been ".(!empty($_POST['assessor_id'])?"updated":"inserted")." successfully.");
			redirect('admin/assessor_master?status=questions&id='.$_POST['assessor_id'].'&hash='.md5(SECRET.$_POST['assessor_id']));
		}
	}

	public function assessor_instrument_insert(){
		$this->sessionexist();
		if(isset($_POST['assessor_instrument_id'])){
			foreach($_POST['assessor_instrument_id'] as $key=>$value){
				$work_activation=(!empty($_POST['assessor_instrument_id'][$key]))?Doctrine::getTable('UlsAssessorCertifiedInstruments')->find($_POST['assessor_instrument_id'][$key]):new UlsAssessorCertifiedInstruments;
				$work_activation->assessor_instrument_name=$_POST['assessor_instrument_name'][$key];
				$work_activation->assessor_instrument_expiry=!empty($_POST['assessor_instrument_expiry'])?date('y-m-d',strtotime($_POST['assessor_instrument_expiry'][$key])):NULL;
				$work_activation->assessor_instrument_status=$_POST['assessor_instrument_status'][$key];
				$work_activation->assessor_id=$_POST['assessor_id'];
				$work_activation->save();
			}
			$this->session->set_flashdata('assessor',"Assessor Instruments has been ".(!empty($_POST['assessor_id'])?"updated":"inserted")." successfully.");
			redirect('admin/assessor_master?status=questions&id='.$_POST['assessor_id'].'&hash='.md5(SECRET.$_POST['assessor_id']));
		}
	}

	public function delete_assessor_instrument(){
		if(!empty($_REQUEST['val'])){
			$play=Doctrine_Query::Create()->delete('UlsAssessorCertifiedInstruments')->where("assessor_instrument_id=".$_REQUEST['val'])->execute();
			echo 1;
		}
		else{
			echo "Selected Assessor instrument cannot be deleted. Ensure you delete all the usages of the Assessor instrument before you delete it.";
		}
	}

	public function assessor_view(){
		$data["aboutpage"]=$this->pagedetails('admin','assessor_view');
        $id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1 || $id==""){
            $content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			$compdetails=UlsAssessorMaster::viewassessor($id);
            $data['compdetails']=$compdetails;
			$data['instruments']=UlsAssessorCertifiedInstruments::getassessorinstruments($compdetails['assessor_id']);
			$data['competencies']=UlsAssessorCompetencies::getassessorcompetencies($compdetails['assessor_id']);
			$content = $this->load->view('admin/assessor_view',$data,true);
        }
		$this->render('layouts/adminnew',$content);
    }

	public function deleteassessor(){
		$id=trim($_REQUEST['val']);
		if(!empty($id) && is_numeric($id)){
			$uewi=Doctrine_Query::create()->from('UlsAssessorCertifiedInstruments')->where('assessor_id='.$id)->execute();
			$uewi2=Doctrine_Query::create()->from('UlsAssessorCompetencies')->where('assessor_id='.$id)->execute();
			$uewi3=Doctrine_Query::create()->from('UlsAssessmentPositionAssessor')->where('assessor_id='.$id)->execute();
			if(count($uewi)==0 && count($uewi2)==0 && count($uewi3)==0){
				$q = Doctrine_Query::create()->delete('UlsAssessorMaster')->where('assessor_id=?',$id)->execute();
				echo 1;
			}
			else{
				echo "Selected Assessor cannot be deleted. Ensure you delete all the usages of the Assessor before you delete it.";
			}
		}
	}

	public function assessment_search()
	{
		$data["aboutpage"]=$this->pagedetails('admin','assessment_search');
		$limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
        $assessment=filter_input(INPUT_GET,'assessment') ? filter_input(INPUT_GET,'assessment'):"";
		//$assess_cycle_type=filter_input(INPUT_GET,'assess_cycle_type') ? filter_input(INPUT_GET,'assess_cycle_type'):"";
		$assess_cycle_type=isset($_SESSION['emp_type'])?$_SESSION['emp_type']:"";
        $page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
        $start=$page!=0? ($page-1)*$limit:0;
        $filePath=BASE_URL."/admin/assessment_search";
        $data['limit']=$limit;
        $data['assessment']=$assessment;
		$data['pos_types']=UlsAdminMaster::get_value_names("POSTYPE");
		$data['assess_cycle_type']=$assess_cycle_type;
        $data['perpages']=UlsMenuCreation::perpage();
        $data['searchresults']=UlsAssessmentDefinition::search($start, $limit,$assessment,$assess_cycle_type);
        $total=UlsAssessmentDefinition::searchcount($assessment,$assess_cycle_type);
        $otherParams="perpage=".$limit."&assessment=$assessment&assess_cycle_type=$assess_cycle_type";
		$data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/assessment_search',$data,true);
		$this->render('layouts/adminnew',$content);
	}

	public function assessment_creation()
	{
		$data["aboutpage"]=$this->pagedetails('admin','assessment_master');
		$org_stat="STATUS";
        $data["orgstat"]=UlsAdminMaster::get_value_names($org_stat);
		$ass_type="ASS_TYPE";
		$data["asstype"]=UlsAdminMaster::get_value_names($ass_type);
		$pos_type="POSTYPE";
		$data['pos_types']=UlsAdminMaster::get_value_names($pos_type);
		$self_type="SELF_ASS_TYPE";
		$data['self_types']=UlsAdminMaster::get_value_names($self_type);
		$feed_type="YES_NO";
		$data['feed_types']=UlsAdminMaster::get_value_names($feed_type);
		if(!empty($_REQUEST['id'])){
			$compdetails=UlsAssessmentDefinition::viewassessment($_REQUEST['id']);
            $data['compdetails']=$compdetails;
			$data['position_details']=UlsAssessmentPosition::getassessmentpositions($compdetails['assessment_id']);
		}
		$data["rating"]=UlsRatingMaster::rating_details();
		$data["positions"]=UlsPosition::fetch_all_pos();
		$data["locations"]=UlsLocation::fetch_all_locs();
		$content = $this->load->view('admin/assessment_creation',$data,true);
		$this->render('layouts/adminnew',$content);
	}

	public function assessment_insert(){
        $this->sessionexist();
        if(isset($_POST['assessment_id'])){
            $fieldinsertupdates=array('assessment_name','assessment_desc','assessment_status','assessment_type','rating_id','assessment_cycle_type','location_id','self_ass_type','feedback','ass_comp_selection','ass_comp_count','ass_pro_selection','ass_pro_count','ass_methods','ass_emp_comp');
			$datefield=array('start_date'=>'stdate','end_date'=>'enddate');
            $case=Doctrine::getTable('UlsAssessmentDefinition')->find($_POST['assessment_id']);
            !isset($case->assessment_id)?$case=new UlsAssessmentDefinition():"";
            foreach($fieldinsertupdates as $val){
				$case->$val=(!empty($_POST[$val]))?($_POST[$val]):NULL;
			}
			foreach($datefield as $key=>$dateval){
				$case->$key=(!empty($_POST[$dateval]))?date('Y-m-d',strtotime($_POST[$dateval])):NULL;
			}
            $case->save();
			$path="public/uploads/assessments/".$case->assessment_id;
			if(!is_dir($path)){
				mkdir($path,0777);
			}
			$this->session->set_flashdata('assessment',"Assessment master data ".(!empty($_POST['assessment_id'])?"updated":"inserted")." successfully.");
            redirect('admin/assessment_creation?status=competency&id='.$case->assessment_id.'&hash='.md5(SECRET.$case->assessment_id));
        }
        else{
			$content = $this->load->view('admin/assessment_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }
	
	public function assessment_report()
	{
		$data["aboutpage"]=$this->pagedetails('admin','assessment_report');
		$org_stat="STATUS";
        $data["orgstat"]=UlsAdminMaster::get_value_names($org_stat);
		if(!empty($_REQUEST['id'])){
			$compdetails=UlsAssessmentDefinition::viewassessment($_REQUEST['id']);
            $data['compdetails']=$compdetails;
			$data['position_details']=UlsAssessmentPosition::getassessmentpositions($compdetails['assessment_id']);
		}
		$data["rating"]=UlsRatingMaster::rating_details();
		$data["positions"]=UlsPosition::fetch_all_pos();
		$content = $this->load->view('admin/assessment_report',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function self_assessment_report()
	{
		$data["aboutpage"]=$this->pagedetails('admin','assessment_report');
		$org_stat="STATUS";
        $data["orgstat"]=UlsAdminMaster::get_value_names($org_stat);
		if(!empty($_REQUEST['id'])){
			$compdetails=UlsAssessmentDefinition::viewassessment($_REQUEST['id']);
            $data['compdetails']=$compdetails;
			$data['position_details']=UlsAssessmentPosition::getassessmentpositions($compdetails['assessment_id']);
		}
		$data["rating"]=UlsRatingMaster::rating_details();
		$data["positions"]=UlsPosition::fetch_all_pos();
		$content = $this->load->view('admin/self_assessment_report',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function getemployees(){
		$data=array();
		$position_id=$_REQUEST['position_id'];
		$assessment_id=$_REQUEST['assessment_id'];
		$data['assessment_id']=$assessment_id;
		$data['position_id']=$position_id;
		$data['position']=Doctrine::getTable('UlsPosition')->find($position_id);
		$data['employees']=UlsAssessmentPositionAssessor::getemployees_admin($assessment_id,$position_id);
		$content = $this->load->view('admin/assessment_report_employee',$data,true);
		$this->render('layouts/ajax-layout',$content);	
	}
	
	public function self_getemployees(){
		$data=array();
		$position_id=$_REQUEST['position_id'];
		$assessment_id=$_REQUEST['assessment_id'];
		$data['assessment_id']=$assessment_id;
		$data['position_id']=$position_id;
		$data['position']=Doctrine::getTable('UlsPosition')->find($position_id);
		$data['employees']=UlsSelfAssessmentEmployees::getselfemployees_admin($assessment_id,$position_id);
		$content = $this->load->view('admin/assessment_selfreport_employee',$data,true);
		$this->render('layouts/ajax-layout',$content);	
	}
	
	public function getemployeeassessment(){
		$data=array();
		$position_id=$_REQUEST['position_id'];
		$assessment_id=$_REQUEST['assessment_id'];
		$employee_id=$_REQUEST['employee_id'];
		$data['assessment_id']=$assessment_id;
		$data['position_id']=$position_id;
		$data['employee_id']=$employee_id;
		$data['employee_name']=UlsEmployeeMaster::get_employees($employee_id);
		$data['ass_info']=UlsAssessmentReport::getassessment_assessor_name($assessment_id,$position_id,$employee_id);
		$data['ass_info_rating']=UlsAssessmentAssessorRating::getassessment_assessor_results_admin($assessment_id,$position_id,$employee_id);
		$data['test_casestudy']=UlsAssessmentTestCasestudy::viewcasestudy_count($assessment_id,$position_id);
		$data['test_inbasket']=UlsAssessmentTestInbasket::viewinbasket_count($assessment_id,$position_id);
		$data['ass_test']=UlsAssessmentTest::assessment_test($assessment_id,$position_id);
		$data['ass_comp_info']=UlsAssessmentReport::getassessment_admin_summary($assessment_id,$position_id,$employee_id);
		$content = $this->load->view('admin/assessment_final_view',$data,true);
		$this->render('layouts/ajax-layout',$content);	
	}
	
	public function beireport(){
		$id=$_REQUEST['id'];
		$ins_id=$_REQUEST['ins_id'];
		$ass_id=$_REQUEST['ass_id'];
		$emp_id=$_REQUEST['emp_id'];
		$query="SELECT d.ins_para_name,c.*,b.`user_test_question_id`, a.`utest_question_id`,a.`text` FROM `uls_bei_responses_assessment` a 
		inner join `uls_bei_questions_assessment` b on a.`utest_question_id`=b.id 
		inner join `uls_be_ins_subparameters` c on b.`user_test_question_id`=c.`ins_subpara_id` 
		inner join `uls_be_ins_parameters` d on c.`ins_para_id`=d.`ins_para_id`
		WHERE a.`employee_id`=$emp_id and a.`assessment_id`=$ass_id and a.`event_id`=$id and a.`instrument_id`=$ins_id";
		$results=UlsMenu::callpdo($query);
		$query2="SELECT `ins_rat_scale_value_number` as id,`ins_rat_scale_value_name` as name FROM `uls_be_ins_rat_scale_values` WHERE `ins_rat_scale_id` in (SELECT `instrument_scale` FROM `uls_be_instruments` WHERE `instrument_id`=$ins_id)";
		$results2=UlsMenu::callpdo($query2);
		
		$beh_asstype="BEHAVORIAL_INSTRUMENT";
		$bie_assessment=UlsBeiAttemptsAssessment::getattemptvalus_beh($ass_id,$emp_id,$beh_asstype,$id,$ins_id);
		$data['attempt_details']=$bie_assessment;
		$data['attempt_id']=$bie_assessment['attempt_id'];
		$data['results']=$results;
		$data['ratings']=$results2;
		$data['ass_id']=$ass_id;
		$data['ins_id']=$ins_id;
		$content = $this->load->view('admin/admin_beireport',$data,true);
		$this->render('layouts/ajax-layout',$content);
		
	}
	
	public function getselfemployeeassessment(){
		$data=array();
		$position_id=$_REQUEST['position_id'];
		$assessment_id=$_REQUEST['assessment_id'];
		$employee_id=$_REQUEST['employee_id'];
		$data['assessment_id']=$assessment_id;
		$data['position_id']=$position_id;
		$data['employee_id']=$employee_id;
		$data['employee_name']=UlsEmployeeMaster::get_employees($employee_id);
		
		$data['ass_comp_info']=UlsSelfAssessmentReport::getassessment_self_admin_summary($assessment_id,$position_id,$employee_id);
		$content = $this->load->view('admin/assessment_self_final_view',$data,true);
		$this->render('layouts/ajax-layout',$content);	
	}
	
	public function getassessorsummary(){
		$data=array();
		$ass_id=$_REQUEST['assessment_id'];
		$emp_id=$_REQUEST['employee_id'];
		$pos_id=$_REQUEST['position_id'];
		$assessor_id=$_REQUEST['assessor_id'];
		$data['id']=$ass_id;
		$data['emp_id']=$emp_id;
		$data['pos_id']=$pos_id;
		$data['assessor_id']=$assessor_id;
		$data['test_casestudy']=UlsAssessmentTestCasestudy::viewcasestudy_count($ass_id,$pos_id);
		$data['test_inbasket']=UlsAssessmentTestInbasket::viewinbasket_count($ass_id,$pos_id);
		$data['ass_test']=UlsAssessmentTest::assessment_test($ass_id,$pos_id);
		$data['competency']=UlsAssessmentReport::getadminassessment_competencies_summary($ass_id,$pos_id,$emp_id,$assessor_id);
		$data['rating_values']=UlsAssessmentAssessorRating::get_ass_rating_admin($ass_id,$pos_id,$emp_id,$assessor_id);
		$content = $this->load->view('admin/assessment_admin_summarydetails',$data,true);
		$this->render('layouts/ajax-layout',$content);
	}
	
	public function summary_result_insert(){
		if(isset($_POST['final_admin_id'])){
			foreach($_POST['competency'] as $key=>$competencys){
				$report_id=UlsAssessmentReport::getadminassessment_competencies_insert($_POST['assessment_id'],$_POST['position_id'],$_POST['employee_id'],$_POST['final_admin_id'],$competencys);
				$master_value=!empty($report_id['report_id'])?Doctrine::getTable('UlsAssessmentReport')->find($report_id['report_id']): new UlsAssessmentReport();
				$master_value->assessment_id=$_POST['assessment_id'];
				$master_value->position_id=$_POST['position_id'];
				$master_value->employee_id=$_POST['employee_id'];
				$master_value->final_admin_id=$_POST['final_admin_id'];
				$master_value->competency_id=$competencys;
				$master_value->require_scale_id=$_POST['requiredlevel_'.$competencys];
				/* $master_value->assessed_scale_id=$_POST['OVERALL_'.$competencys]; */
				$master_value->development_area=$_POST['development_'.$competencys];
                $master_value->save();
			}
			$update=Doctrine_Query::create()->update('UlsAssessmentEmployees');
			$update->set('status','?','A');
			$update->where('assessment_id=?',$_POST['assessment_id']);
			$update->andwhere('position_id=?',$_POST['position_id']);
			$update->andwhere('employee_id=?',$_POST['employee_id']);
			$update->limit(1)->execute();
			echo 'done';
		}
	}
	
	
	public function self_summary_result_insert(){
		if(isset($_POST['final_admin_id'])){
			foreach($_POST['competency'] as $key=>$competencys){
				$report_id=UlsSelfAssessmentReport::getadminselfassessment_competencies_insert($_POST['assessment_id'],$_POST['position_id'],$_POST['employee_id'],$_POST['final_admin_id'],$competencys);
				$master_value=!empty($report_id['self_report_id'])?Doctrine::getTable('UlsSelfAssessmentReport')->find($report_id['self_report_id']): new UlsSelfAssessmentReport();
				$master_value->final_admin_id=$_POST['final_admin_id'];
				$master_value->admin_assessed_scale_id=$_POST['OVERALL_'.$competencys];
                $master_value->save();
			}
			$update=Doctrine_Query::create()->update('UlsSelfAssessmentEmployees');
			$update->set('status','?','A');
			$update->where('assessment_id=?',$_POST['assessment_id']);
			$update->andwhere('position_id=?',$_POST['position_id']);
			$update->andwhere('employee_id=?',$_POST['employee_id']);
			$update->limit(1)->execute();
			echo 'done';
		}
	}

	public function assessment_position_insert(){
		$this->sessionexist();
		if(isset($_POST['assessment_id'])){
			foreach($_POST['assessment_pos_id'] as $key=>$value){
				$work_activation=(!empty($_POST['assessment_pos_id'][$key]))?Doctrine::getTable('UlsAssessmentPosition')->find($_POST['assessment_pos_id'][$key]):new UlsAssessmentPosition;
				$work_activation->position_id=$_POST['position_id'][$key];
				$work_activation->version_id=$_POST['version_id'][$key];
				$work_activation->assessment_pos_status=$_POST['assessment_pos_status'][$key];
				$work_activation->assessment_id=$_POST['assessment_id'];
				$work_activation->save();
				$position=UlsMenu::callpdorow("select * from uls_position where position_id=".$work_activation->position_id);
				$path="public/uploads/assessments/".$work_activation->assessment_id."/".$position['position_name'];
				/* if(!is_dir($path)){
					mkdir($path,0777);
				} */
			}
			$this->session->set_flashdata('assessment',"Assessment position information has been ".(!empty($_POST['assessment_id'])?"updated":"inserted")." successfully.");
			if($_POST['assessment_type']=='SELF'){
				redirect('admin/self_assessment_details?tab=1&id='.$_POST['assessment_id'].'&hash='.md5(SECRET.$_POST['assessment_id']));
			}
			else{
				redirect('admin/assessment_details?tab=1&id='.$_POST['assessment_id'].'&hash='.md5(SECRET.$_POST['assessment_id']));
			}
			
		}
	}
	
	public function self_assessment_details(){
		$data["aboutpage"]=$this->pagedetails('admin','assessment_master_details');
        $id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1 || $id==""){
            $content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			$compdetails=UlsAssessmentDefinition::viewassessment($id);
            $data['compdetails']=$compdetails;
			$data['positions']=UlsAssessmentPosition::getassessmentpositions($compdetails['assessment_id']);
			$data['competencies']=UlsAssessmentCompetencies::getassessmentcompetencies($compdetails['assessment_id']);
			$data['employees']=UlsSelfAssessmentEmployees::getselfassessmentemployees($compdetails['assessment_id']);
			
			$content = $this->load->view('admin/self_assessment_details',$data,true);
        }
		$this->render('layouts/adminnew',$content);
    }

	public function delete_assessment_position(){
		if(!empty($_REQUEST['val'])){
			$play=Doctrine_Query::Create()->delete('UlsAssessmentPosition')->where("assessment_pos_id=".$_REQUEST['val'])->execute();
			echo 1;
		}
		else{
			echo "Selected Assessment Position cannot be deleted. Ensure you delete all the usages of the Assessment Position before you delete it.";
		}
	}

	public function assessment_details(){
		$data["aboutpage"]=$this->pagedetails('admin','assessment_master_details');
        $id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1 || $id==""){
            $content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			$compdetails=UlsAssessmentDefinition::viewassessment($id);
            $data['compdetails']=$compdetails;
			$data['positions']=UlsAssessmentPosition::getassessmentpositions($compdetails['assessment_id']);
			$data['competencies']=UlsAssessmentCompetencies::getassessmentcompetencies($compdetails['assessment_id']);
			$data['employees']=UlsAssessmentEmployees::getassessmentemployees($compdetails['assessment_id']);
			$data['instrument']=UlsBeInstruments::view_instruments();
			$data['status']=UlsAdminMaster::get_value_names("YES_NO");
			$data['language']=UlsAdminMaster::get_value_names("YES_NO");
			$content = $this->load->view('admin/assessment_details',$data,true);
        }
		$this->render('layouts/adminnew',$content);
    }

		public function comp_position_details(){
			$id=$_REQUEST['position_id'];
			$aid=$_REQUEST['assessment_id'];
			$as_type=$_REQUEST['ass_type'];
			$ass_type='';
			if($as_type=='TEST'){
				$ass_type='COMP_TEST';
			}
			elseif($as_type=='INBASKET'){
				$ass_type='COMP_INBASKET';
			}
			elseif($as_type=='CASE_STUDY'){
				$ass_type='COMP_CASESTUDY';
			}
			elseif($as_type=='INTERVIEW'){
				$ass_type='COMP_INTERVIEW';
			}
			elseif($as_type=='BEHAVORIAL_INSTRUMENT'){
				$ass_type='BEHAVORIAL_INSTRUMENT';
			}
			elseif($as_type=='FISHBONE'){
				$ass_type='FISHBONE';
			}
			elseif($as_type=='FEEDBACK'){
				$ass_type='FEEDBACK';
			}
			$position=UlsPosition::viewposition($id);
			$ass_position=UlsAssessmentPosition::get_assessment_position($id);
			$ass_details=UlsCompetencyTest::test_count_assessment($aid,$id,$ass_type);
			$status=UlsAdminMaster::get_value_names("STATUS");
			$ass_test_detail=UlsAssessmentTest::get_ass_position($aid,$id,$as_type);
			$ass_position=UlsAssessmentPosition::get_assessment_position_info($id,$aid);
			$test_id=!empty($ass_test_detail['test_id'])?$ass_test_detail['test_id']:"";
			$comp_test_id=!empty($ass_test_detail['assess_test_id'])?$ass_test_detail['assess_test_id']:"";
			
			$time=!empty($ass_test_detail['time_details'])?$ass_test_detail['time_details']:"";
			$ass_details_int=UlsCompetencyTest::test_count_assessment_int($aid,$id,$ass_type,$test_id);
			
			$data="";
			if($as_type=='INBASKET'){
			$data.="<div class='col-lg-8'>
					<div class='panel panel-default card-view'>
						<div class='panel-heading' style='border: 1px dotted;'>
							Instruction
						</div>
						<div class='panel-body float-e-margins'>
							<h5 class='m-t-none m-b-sm'>Position Name: ".$position['position_name']."</h5>
							<div class='hr-line-dashed'></div>
							
								<input type='hidden' name='position_id' id='position_id' value='".$id."'>
								<input type='hidden' name='assessment_id' id='assessment_id' value='".$aid."'>
								<input type='hidden' name='assessment_pos_id' id='assessment_pos_id' value='".$ass_position['assessment_pos_id']."'>
								<input type='hidden' name='assessment_type' id='assessment_type' value='".$as_type."'>
								<div class='panel-heading hbuilt'>
									Add Inbasket Items
									<div class='pull-right'>";
									if($ass_position['assessment_broadcast']!='A'){
										$data.="<a class='btn btn-xs btn-success' data-toggle='modal' data-target='.myModal".$id."' onClick='return addass_details_inbasket(".$aid.",".$id.",\"".$ass_type."\")'>&nbsp <i class='fa fa-plus-circle'></i> Add &nbsp </a>";
									}	
									$data.="</div>
								</div>
								<br style='clear:both;'>
								<div class='table-responsive'>
									<table id='source_table_programs' cellpadding='1' cellspacing='1' class='table table-bordered table-striped'>
										<thead>
										<tr>
											<th class='col-sm-7'>Inbasket Items</th>
											<th class='col-sm-4'>Competency Name</th>
											<!--<th>Status</th>-->
											<th class='col-sm-1'>Action</th>
										</tr>
										</thead>
										<tbody>";
										$inbasket_test=UlsAssessmentTestInbasket::getinbasketassessment($comp_test_id);
										$ass_detail_inbasket=UlsCompetencyTest::test_count_assessment_inbasket($aid,$id,$ass_type);
										if(!empty($inbasket_test)){
											$hide_val=array();
											foreach($inbasket_test as $key=>$inbasket_tests){
												$key1=$key+1; $hide_val[]=$key1;
												$data.="<tr id='subgrd_".$id."_".$inbasket_tests['inb_assess_test_id']."'>
													<td><a data-target='#workinfoview".$inbasket_tests['inbasket_id']."' onclick='work_info_view_inbasket(".$inbasket_tests['inbasket_id'].",".$inbasket_tests['assess_test_id'].",".$inbasket_tests['test_id'].")' data-toggle='modal' href='#workinfoview".$inbasket_tests['inbasket_id']."'>".$inbasket_tests['test_name']."</a></td>
													<td><a data-target='#workinfoview_inbasket".$inbasket_tests['inbasket_id']."' onclick='work_info_view_inbasket_comp(".$inbasket_tests['inbasket_id'].")' data-toggle='modal' href='#workinfoview_inbasket".$inbasket_tests['inbasket_id']."'>View</a></td>
													<!--<td>".$inbasket_tests['value_name']."</td>-->
													<td><a class='btn btn-danger btn-xs' id='".$inbasket_tests['inb_assess_test_id']."' name='delete_assessment_inbasket' rel='subgrd_".$id."_".$inbasket_tests['inb_assess_test_id']."' onclick='deletefunction(this)'>&nbsp <i class='fa fa-trash-o'></i>  Delete &nbsp </a></td>
												</tr>
												<div id='workinfoview".$inbasket_tests['inbasket_id']."'  class='modal fade' tabindex='-1' role='dialog'  aria-hidden='true'>
													<div class='modal-dialog modal-lg' style='width:98%;'>
														<div class='modal-content'>
															<div class='color-line'></div>
															<div class='modal-header'>
																<h6 class='modal-title'>InBasket Details</h6>
																<button type='button' class='btn btn-default pull-right' data-dismiss='modal'>X</button>
															</div>
															<div class='modal-body'>
																<div id='workinfodetails_inbasket".$inbasket_tests['inbasket_id']."' class='modal-body no-padding'>
																
																</div>
															</div>
															
														</div><!-- /.modal-content -->
													</div><!-- /.modal-dialog -->
												</div>
												<div id='workinfoview_inbasket".$inbasket_tests['inbasket_id']."'  class='modal fade' tabindex='-1' role='dialog'  aria-hidden='true'>
													<div class='modal-dialog modal-lg'>
														<div class='modal-content'>
															<div class='color-line'></div>
															<div class='modal-header'>
																<h6 class='modal-title'>Competency Details</h6>
																<button type='button' class='btn btn-default pull-right' data-dismiss='modal'>X</button>
															</div>
															<div class='modal-body'>
																<div id='workinfodetails_inbasket_comp".$inbasket_tests['inbasket_id']."' class='modal-body no-padding'>
																
																</div>
															</div>
															
														</div><!-- /.modal-content -->
													</div><!-- /.modal-dialog -->
												</div>";
											}
										}
										$data.="</tbody>
										
									</table>
								</div>
								
								<div class='modal fade myModal".$id."' id='myModal".$id."' tabindex='-1' role='dialog'  aria-hidden='true'>
									<div class='modal-dialog modal-lg'>
										<div class='modal-content'>
											<div class='color-line'></div>
											<div class='modal-header'>
												<h6 class='modal-title'>Inbasket Test Details</h6>
											</div>
											<div class='modal-body' id='inbasket_model".$id."'>
											
											</div>
										</div>
									</div>
								</div>
							
						</div>
					</div>
				</div>";
			}
			elseif($as_type=='FEEDBACK'){
			$data.="<div class='col-lg-8'>
					<div class='panel panel-default card-view'>
						<div class='panel-heading' style='border: 1px dotted;'>
							Instruction
						</div>
						<div class='panel-body float-e-margins'>
							<h5 class='m-t-none m-b-sm'>Position Name: ".$position['position_name']."</h5>
							<div class='hr-line-dashed'></div>
							
								<input type='hidden' name='position_id' id='position_id' value='".$id."'>
								<input type='hidden' name='assessment_id' id='assessment_id' value='".$aid."'>
								<input type='hidden' name='assessment_pos_id' id='assessment_pos_id' value='".$ass_position['assessment_pos_id']."'>
								<input type='hidden' name='assessment_type' id='assessment_type' value='".$as_type."'>
								<div class='panel-heading hbuilt'>
									Add Feedback Items
									<div class='pull-right'>";
									if($ass_position['assessment_broadcast']!='A'){
										$data.="<a class='btn btn-xs btn-success' data-toggle='modal' data-target='.feedmyModal".$id."' onClick='return addass_details_feedback(".$aid.",".$id.",\"".$ass_type."\")'>&nbsp <i class='fa fa-plus-circle'></i> Add &nbsp </a>";
									}	
									$data.="</div>
								</div>
								<br style='clear:both;'>
								<div class='table-responsive'>
									<table id='source_table_programs' cellpadding='1' cellspacing='1' class='table table-bordered table-striped'>
										<thead>
										<tr>
											<th class='col-sm-7'>Feeeback Name</th>
											<th class='col-sm-1'>Action</th>
										</tr>
										</thead>
										<tbody>";
										$feedback_test=UlsAssessmentTestFeedback::getfeedbackassessment($comp_test_id);
										if(!empty($feedback_test)){
											$hide_val=array();
											foreach($feedback_test as $key=>$feedback_tests){
												$key1=$key+1; $hide_val[]=$key1;
												$data.="<tr id='subgrd_".$id."_".$feedback_tests['feed_assess_test_id']."'>
													<td><a data-target='#workinfoview".$feedback_tests['ques_id']."' onclick='work_info_view_inbasket(".$feedback_tests['ques_id'].",".$feedback_tests['assess_test_id'].")' data-toggle='modal' href='#workinfoview".$feedback_tests['ques_id']."'>".$feedback_tests['ques_name']."</a></td>
													<td><a class='btn btn-danger btn-xs' id='".$feedback_tests['feed_assess_test_id']."' name='delete_assessment_feedback' rel='subgrd_".$id."_".$feedback_tests['feed_assess_test_id']."' onclick='deletefunction(this)'>&nbsp <i class='fa fa-trash-o'></i>  Delete &nbsp </a></td>
												</tr>
												<div id='workinfoview".$feedback_tests['ques_id']."'  class='modal fade' tabindex='-1' role='dialog'  aria-hidden='true'>
													<div class='modal-dialog modal-lg' style='width:98%;'>
														<div class='modal-content'>
															<div class='color-line'></div>
															<div class='modal-header'>
																<h6 class='modal-title'>Feedback Details</h6>
																<button type='button' class='btn btn-default pull-right' data-dismiss='modal'>X</button>
															</div>
															<div class='modal-body'>
																<div id='workinfodetails_inbasket".$feedback_tests['ques_id']."' class='modal-body no-padding'>
																
																</div>
															</div>
															
														</div><!-- /.modal-content -->
													</div><!-- /.modal-dialog -->
												</div>";
											}
										}
										$data.="</tbody>
										
									</table>
								</div>
								
								<div class='modal fade feedmyModal".$id."' id='myModal".$id."' tabindex='-1' role='dialog'  aria-hidden='true'>
									<div class='modal-dialog modal-lg'>
										<div class='modal-content'>
											<div class='color-line'></div>
											<div class='modal-header'>
												<h6 class='modal-title'>Feedback Test Details</h6>
											</div>
											<div class='modal-body' id='feedback_model_".$id."'>
											
											</div>
										</div>
									</div>
								</div>
							
						</div>
					</div>
				</div>";
			}
			elseif($as_type=='INTERVIEW'){
			$data.="<div class='col-lg-8'>
				<div class='panel panel-default card-view'>
					<div class='panel-heading' style='border: 1px dotted;'>
						Instruction
					</div>
					<div class='panel-body float-e-margins'>
						<h5 class='m-t-none m-b-sm'>Position Name: ".$position['position_name']."</h5>
						<div class='hr-line-dashed'></div>
						<form method='post' action='".BASE_URL."/admin/lms_position_interviewsubmit' class='form-horizontal' id='ass_interview_validation".$id."' name='ass_test_validation".$id."'>
							<input type='hidden' name='position_id' id='position_id' value='".$id."'>
							<input type='hidden' name='comp_test_id' id='comp_test_id' value='".$comp_test_id."'>
							<input type='hidden' name='test_id' id='test_id' value='".$ass_details_int['test_id']."'>
							<input type='hidden' name='assessment_id' id='assessment_id' value='".$aid."'>
							<input type='hidden' name='assessment_pos_id' id='assessment_pos_id' value='".$ass_position['assessment_pos_id']."'>
							<input type='hidden' name='assessment_type' id='assessment_type' value='".$as_type."'>";
							$test_detail=UlsAssessmentTest::get_ass_position($aid,$id,$as_type);
							$assdetail=UlsAssessmentDefinition::viewassessment($aid);
							$data.="<div class='form-group'>
								<label class='col-sm-4 control-label'>Display  Questions<sup><font color='#FF0000'>*</font></sup></label>
								<div class='col-sm-6'>
									<select class='validate[required] form-control m-b' name='rating_id' id='rating_id'>
										<option value=''>Select</option>";
										$rating=UlsRatingMaster::rating_details();	
										foreach($rating as $ratings){
											$rat_sat=(isset($assdetail['rating_id']))?($assdetail['rating_id']==$ratings['rating_id'])?"selected='selected'":'':'';
											$data.="<option value='".$ratings['rating_id']."' ".$rat_sat.">".$ratings['rating_name']."</option>";
										}
									$data.="</select>
								</div>
							</div>
							<div class='form-group'><label class='col-sm-4 control-label'>Time<sup><font color='#FF0000'>*</font></sup>:</label>
								<div class='col-sm-8'>
									<input type='text' name='casestudy_time' id='casestudy_time' class='validate[required] form-control'>
								</div>
							</div>
							<div class='form-group '>
								<div class='col-sm-12'>
									<button class='btn btn-primary' type='submit' name='position_submit' id='position_submit'>Save changes</button>
								</div>
							</div>
							";
						$data.="</form>
					</div>
				</div>
			</div>";
			}
			elseif($as_type=='BEHAVORIAL_INSTRUMENT'){
			$data.="<div class='col-lg-8'>
					<div class='panel panel-default card-view'>
						<div class='panel-heading' style='border: 1px dotted;'>
							Instruction
						</div>
						<div class='panel-body float-e-margins'>
							<h5 class='m-t-none m-b-sm'>Position Name: ".$position['position_name']."</h5>
							<div class='hr-line-dashed'></div>
							
								<input type='hidden' name='position_id' id='position_id' value='".$id."'>
								<input type='hidden' name='assessment_id' id='assessment_id' value='".$aid."'>
								<input type='hidden' name='assessment_pos_id' id='assessment_pos_id' value='".$ass_position['assessment_pos_id']."'>
								<input type='text' name='assessment_type' id='assessment_type' value='".$as_type."'>
								<div class='panel-heading hbuilt'>
									Add Inbasket Items
									<div class='pull-right'>";
									if($ass_position['assessment_broadcast']!='A'){
										$data.="<a class='btn btn-xs btn-success' data-toggle='modal' data-target='.myModal".$id."' onClick='return addass_details_behavorial(".$aid.",".$id.",\"".$as_type."\")'>&nbsp <i class='fa fa-plus-circle'></i> Add &nbsp </a>";
									}	
									$data.="</div>
								</div>
								<br style='clear:both;'>
								<div class='table-responsive'>
									<table id='source_table_programs' cellpadding='1' cellspacing='1' class='table table-bordered table-striped'>
										<thead>
										<tr>
											<th class='col-sm-10'>Instrument Name</th>
											<th class='col-sm-2'>Action</th>
										</tr>
										</thead>
										<tbody>";
										$behavorial_test=UlsAssessmentTestBehavorialInst::getbehavorialassessment($comp_test_id);
										
										if(!empty($behavorial_test)){
											$hide_val=array();
											foreach($behavorial_test as $key=>$behavorial_tests){
												$key1=$key+1; $hide_val[]=$key1;
												$data.="<tr id='subgrd_".$id."_".$behavorial_tests['beh_inst_id']."'>
													<td>".$behavorial_tests['instrument_name']."</td>
													
													<td><a class='btn btn-danger btn-xs' id='".$behavorial_tests['beh_inst_id']."' name='delete_assessment_inbasket' rel='subgrd_".$id."_".$behavorial_tests['beh_inst_id']."' onclick='deletefunction(this)'>&nbsp <i class='fa fa-trash-o'></i>  Delete &nbsp </a></td>
												</tr>
												<div id='workinfoview".$behavorial_tests['beh_inst_id']."'  class='modal fade' tabindex='-1' role='dialog'  aria-hidden='true'>
													<div class='modal-dialog modal-lg' style='width:98%;'>
														<div class='modal-content'>
															<div class='color-line'></div>
															<div class='modal-header'>
																<h6 class='modal-title'>InBasket Details</h6>
																<button type='button' class='btn btn-default pull-right' data-dismiss='modal'>X</button>
															</div>
															<div class='modal-body'>
																<div id='workinfodetails_inbasket".$behavorial_tests['beh_inst_id']."' class='modal-body no-padding'>
																
																</div>
															</div>
															
														</div><!-- /.modal-content -->
													</div><!-- /.modal-dialog -->
												</div>
												<div id='workinfoview_inbasket".$behavorial_tests['beh_inst_id']."'  class='modal fade' tabindex='-1' role='dialog'  aria-hidden='true'>
													<div class='modal-dialog modal-lg'>
														<div class='modal-content'>
															<div class='color-line'></div>
															<div class='modal-header'>
																<h6 class='modal-title'>Competency Details</h6>
																<button type='button' class='btn btn-default pull-right' data-dismiss='modal'>X</button>
															</div>
															<div class='modal-body'>
																<div id='workinfodetails_inbasket_comp".$behavorial_tests['beh_inst_id']."' class='modal-body no-padding'>
																
																</div>
															</div>
															
														</div><!-- /.modal-content -->
													</div><!-- /.modal-dialog -->
												</div>";
											}
										}
										$data.="</tbody>
										
									</table>
								</div>
						</div>
						<div class='modal fade myModal".$id."' id='myModal".$id."' tabindex='-1' role='dialog'  aria-hidden='true'>
							<div class='modal-dialog modal-lg'>
								<div class='modal-content'>
									<div class='color-line'></div>
									<div class='modal-header'>
										<h6 class='modal-title'>BEHAVORIAL INSTRUMENT Details</h6>
									</div>
									<div class='modal-body' id='behavorial_model".$id."'>
									
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>";
			}
			elseif($as_type=='CASE_STUDY'){
			$data.="<div class='col-lg-8'>
					<div class='panel panel-default card-view'>
						<div class='panel-heading' style='border: 1px dotted;'>
							Instruction
						</div>
						<div class='panel-body float-e-margins'>
							<h5 class='m-t-none m-b-sm'>Position Name: ".$position['position_name']."</h5>
							<div class='hr-line-dashed'></div>
							
								<input type='hidden' name='position_id' id='position_id' value='".$id."'>
								<input type='hidden' name='assessment_id' id='assessment_id' value='".$aid."'>
								<input type='hidden' name='assessment_pos_id' id='assessment_pos_id' value='".$ass_position['assessment_pos_id']."'>
								<input type='hidden' name='assessment_type' id='assessment_type' value='".$as_type."'>
								<div class='panel-heading hbuilt'>
									Add Case Study Details
									<div class='pull-right'>";
									if($ass_position['assessment_broadcast']!='A'){
										$data.="<a class='btn btn-xs btn-success' data-toggle='modal' data-target='.myModal".$id."' onClick='return addass_details_casestudy(".$aid.",".$id.",\"".$ass_type."\")'>&nbsp <i class='fa fa-plus-circle'></i> Add &nbsp </a>";
									}
									$data.="</div>
								</div>
								<br style='clear:both;'>
								<div class='table-responsive'>
									<table id='source_table_programs' cellpadding='1' cellspacing='1' class='table table-bordered table-striped'>
										<thead>
										<tr>
											<th class='col-sm-7'>Case Study Name</th>
											
											<th  class='col-sm-1'>Action</th>
										</tr>
										</thead>
										<tbody>";
										$casestudy_test=UlsAssessmentTestCasestudy::getcasestudyassessment($comp_test_id);
										$ass_detail_inbasket=UlsCompetencyTest::test_count_assessment_inbasket($aid,$id,$ass_type);
										if(!empty($casestudy_test)){
											$hide_val=array();
											foreach($casestudy_test as $key=>$casestudy_tests){
												$key1=$key+1; $hide_val[]=$key1;
												$data.="<tr id='subgrd_".$id."_".$casestudy_tests['case_assess_test_id']."'>
													<td><a data-target='#workinfoview".$casestudy_tests['casestudy_id']."' onclick='work_info_view_casestudy(".$casestudy_tests['casestudy_id'].",".$casestudy_tests['assess_test_id'].",".$casestudy_tests['test_id'].")' data-toggle='modal' href='#workinfoview".$casestudy_tests['casestudy_id']."'>".$casestudy_tests['test_name']."</a></td>
													<td><a class='btn btn-danger btn-xs' id='".$casestudy_tests['case_assess_test_id']."' name='delete_assessment_casestudy' rel='subgrd_".$id."_".$casestudy_tests['case_assess_test_id']."' onclick='deletefunction(this)'>&nbsp <i class='fa fa-trash-o'></i>  Delete &nbsp </a></td>
												</tr>
												<div id='workinfoview".$casestudy_tests['casestudy_id']."'  class='modal fade' tabindex='-1' role='dialog'  aria-hidden='true'>
													<div class='modal-dialog modal-lg' style='width:98%;'>
														<div class='modal-content'>
															<div class='color-line'></div>
															<div class='modal-header'>
																<h6 class='modal-title'>Case Study Details</h6>
																<button type='button' class='btn btn-default pull-right' data-dismiss='modal'>X</button>
															</div>
															<div class='modal-body'>
																<div id='workinfodetails".$casestudy_tests['casestudy_id']."' class='modal-body no-padding'>
																
																</div>
															</div>
															
														</div><!-- /.modal-content -->
													</div><!-- /.modal-dialog -->
												</div>";
											}
										}
										$data.="</tbody>
										
									</table>
								</div>
								
								<div class='modal fade myModal".$id."' id='myModal".$id."' tabindex='-1' role='dialog'  aria-hidden='true'>
									<div class='modal-dialog modal-lg'>
										<div class='modal-content'>
											<div class='color-line'></div>
											<div class='modal-header'>
												<h6 class='modal-title'>Case Study Test Details</h6>
											</div>
											<div class='modal-body' id='casestudy_model".$id."'>
											
											</div>
										</div>
									</div>
								</div>
							
						</div>
					</div>
				</div>";
			}
			elseif($as_type=='FISHBONE'){
			$data.="<div class='col-lg-8'>
					<div class='panel panel-default card-view'>
						<div class='panel-heading' style='border: 1px dotted;'>
							Instruction
						</div>
						<div class='panel-body float-e-margins'>
							<h5 class='m-t-none m-b-sm'>Position Name: ".$position['position_name']."</h5>
							<div class='hr-line-dashed'></div>
							
								<input type='hidden' name='position_id' id='position_id' value='".$id."'>
								<input type='hidden' name='assessment_id' id='assessment_id' value='".$aid."'>
								<input type='hidden' name='assessment_pos_id' id='assessment_pos_id' value='".$ass_position['assessment_pos_id']."'>
								<input type='hidden' name='assessment_type' id='assessment_type' value='".$as_type."'>
								<div class='panel-heading hbuilt'>
									Add Case Study Details
									<div class='pull-right'>";
									if($ass_position['assessment_broadcast']!='A'){
										$data.="<a class='btn btn-xs btn-success' data-toggle='modal' data-target='.myModal".$id."' onClick='return addass_details_fishbone(".$aid.",".$id.",\"".$ass_type."\")'>&nbsp <i class='fa fa-plus-circle'></i> Add &nbsp </a>";
									}
									$data.="</div>
								</div>
								<br style='clear:both;'>
								<div class='table-responsive'>
									<table id='source_table_programs' cellpadding='1' cellspacing='1' class='table table-bordered table-striped'>
										<thead>
										<tr>
											<th class='col-sm-7'>Fishbone Name</th>
											
											<th  class='col-sm-1'>Action</th>
										</tr>
										</thead>
										<tbody>";
										$fishbone_test=UlsAssessmentTestFishbone::getfishboneassessment($comp_test_id);
										if(!empty($fishbone_test)){
											$hide_val=array();
											foreach($fishbone_test as $key=>$casestudy_tests){
												$key1=$key+1; $hide_val[]=$key1;
												$data.="<tr id='subgrd_".$id."_".$casestudy_tests['fish_assess_test_id']."'>
													<td><a data-target='#workinfoview".$casestudy_tests['fishbone_id']."' onclick='work_info_view_casestudy(".$casestudy_tests['fishbone_id'].",".$casestudy_tests['assess_test_id'].",".$casestudy_tests['test_id'].")' data-toggle='modal' href='#workinfoview".$casestudy_tests['fishbone_id']."'>".$casestudy_tests['test_name']."</a></td>
													<td><a class='btn btn-danger btn-xs' id='".$casestudy_tests['fish_assess_test_id']."' name='delete_assessment_casestudy' rel='subgrd_".$id."_".$casestudy_tests['fish_assess_test_id']."' onclick='deletefunction(this)'>&nbsp <i class='fa fa-trash-o'></i>  Delete &nbsp </a></td>
												</tr>
												<div id='workinfoview".$casestudy_tests['fishbone_id']."'  class='modal fade' tabindex='-1' role='dialog'  aria-hidden='true'>
													<div class='modal-dialog modal-lg' style='width:98%;'>
														<div class='modal-content'>
															<div class='color-line'></div>
															<div class='modal-header'>
																<h6 class='modal-title'>Fishbone Details</h6>
																<button type='button' class='btn btn-default pull-right' data-dismiss='modal'>X</button>
															</div>
															<div class='modal-body'>
																<div id='workinfodetails".$casestudy_tests['fishbone_id']."' class='modal-body no-padding'>
																
																</div>
															</div>
															
														</div><!-- /.modal-content -->
													</div><!-- /.modal-dialog -->
												</div>";
											}
										}
										$data.="</tbody>
										
									</table>
								</div>
								
								<div class='modal fade myModal".$id."' id='myModal".$id."' tabindex='-1' role='dialog'  aria-hidden='true'>
									<div class='modal-dialog modal-lg'>
										<div class='modal-content'>
											<div class='color-line'></div>
											<div class='modal-header'>
												<h6 class='modal-title'>Fishbone Details</h6>
											</div>
											<div class='modal-body' id='fishbone_model".$id."'>
											
											</div>
										</div>
									</div>
								</div>
							
						</div>
					</div>
				</div>";
			}
			else{
			$data.="
				<div class='col-lg-8'>
					<div class='panel panel-default card-view'>
						<div class='panel-heading' style='border: 1px dotted;'>
							Instruction
						</div>
						<div class='panel-body float-e-margins'>
							<h5 class='m-t-none m-b-sm'>Position Name: ".$position['position_name']."</h5>
							<div class='hr-line-dashed'></div>
							<h5 class='m-t-none m-b-sm'>Total Questions:Count(".$ass_details_int['questioncount'].")</h5>
							<div class='hr-line-dashed'></div>
							<form method='post' action='".BASE_URL."/admin/lms_position_submit' class='form-horizontal' id='ass_test_validation".$id."' name='ass_test_validation".$id."'>
								<input type='hidden' name='position_id' id='position_id' value='".$id."'>
								<input type='hidden' name='comp_test_id' id='comp_test_id' value='".$comp_test_id."'>
								<input type='hidden' name='test_id' id='test_id' value='".$ass_details_int['test_id']."'>
								<input type='hidden' name='assessment_id' id='assessment_id' value='".$aid."'>
								<input type='hidden' name='assessment_pos_id' id='assessment_pos_id' value='".$ass_position['assessment_pos_id']."'>
								<input type='hidden' name='assessment_type' id='assessment_type' value='".$as_type."'>";
								$data.="<div class='form-group' >";
									$test_detail=UlsAssessmentTest::get_ass_position($aid,$id,$as_type);

									$position=UlsAssessmentCompetencies::getassessmentcompetencies_test($aid,$id,$as_type,$ass_details['test_id']);
									$comp_l1=$comp_l2=$comp_l3=$comp_l4=$comp_l5=array();
									$level_l1=$level_l2=$level_l3=$level_l4=$level_l5=array();
									$level_n_l1=$level_n_l2=$level_n_l3=$level_n_l4=$level_n_l5=array();
									$level_to_l1=$level_to_l2=$level_to_l3=$level_to_l4=$level_to_l5=array();
									$cri_l1=$cri_l2=$cri_l3=$cri_l4=$cri_l5=array();
									$comp_imp=array();
									$level_imp=array();
									$cri_imp=array();
									$cri_vit=array();
									$total_que=0;
									$cricality_details=UlsCompetencyCriticality::criticality_names();
									$c_id=array();
									$i=0;
									foreach($cricality_details as $key=>$cricality_detail){
										$c_id[$i]=$cricality_detail['code'];
										$i++;
										
									}	
										
									foreach($position as $positions){
										$total_que+=$positions['assessment_que_count'];
										if(isset($c_id[0])){
											if($positions['cri_ids']==$c_id[0]){
												$comp_l1[]=$positions['comp_position_competency_id'];
												$level_l1[]=$positions['comp_position_level_scale_id'];
												$level_n_l1[]=$positions['assessment_scale_id'];
												$level_to_l1[]=$positions['assessment_que_count'];
												$cri_l1[]=$positions['cri_ids'];
											}
										}
										if(isset($c_id[1])){
											if($positions['cri_ids']==$c_id[1]){
												$comp_l2[]=$positions['comp_position_competency_id'];
												$level_l2[]=$positions['comp_position_level_scale_id'];
												$level_n_l2[]=$positions['assessment_scale_id'];
												$level_to_l2[]=$positions['assessment_que_count'];
												$cri_l2[]=$positions['cri_ids'];

											}
										}
										
										//print_r($comp_l2);
										if(isset($c_id[2])){
											if($positions['cri_ids']==$c_id[2]){
												$comp_l3[]=$positions['comp_position_competency_id'];
												$level_l3[]=$positions['comp_position_level_scale_id'];
												$level_n_l3[]=$positions['assessment_scale_id'];
												$level_to_l3[]=$positions['assessment_que_count'];
												$cri_l3[]=$positions['cri_ids'];

											}
										}
										if(isset($c_id[3])){
											if($positions['cri_ids']==$c_id[3]){
												$comp_l4[]=$positions['comp_position_competency_id'];
												$level_l4[]=$positions['comp_position_level_scale_id'];
												$level_n_l4[]=$positions['assessment_scale_id'];
												$level_to_l4[]=$positions['assessment_que_count'];
												$cri_l4[]=$positions['cri_ids'];

											}
										}
										if(isset($c_id[4])){
											if($positions['cri_ids']==$c_id[4]){
												$comp_l5[]=$positions['comp_position_competency_id'];
												$level_l5[]=$positions['comp_position_level_scale_id'];
												$level_n_l5[]=$positions['assessment_scale_id'];
												$level_to_l5[]=$positions['assessment_que_count'];
												$cri_l5[]=$positions['cri_ids'];

											}
										}
									}
									foreach($comp_l1 as $key=>$comps){
										//print_r($comps);
										if($key==0){
											$ass_test=UlsAssessmentTest::assessment_test_vital_count($ass_details['test_id'],$level_l1[$key],$level_n_l1[$key],$comps);
											$vit_count1=count($ass_test);
										}
										else{
											$ass_test=UlsAssessmentTest::assessment_test_vital_count($ass_details['test_id'],$level_l1[$key],$level_n_l1[$key],$comps);
											$vit_count1=count($ass_test)+$vit_count1;
										}
									}
									//echo "<pre>";

									foreach($comp_l2 as $key=>$comp_imps){

										if($key==0){
											$ass_test_imp=UlsAssessmentTest::assessment_test_vital_count($ass_details['test_id'],$level_l2[$key],$level_n_l2[$key],$comp_imps);
											$imp_count1=count($ass_test_imp);
										}
										else{
											$ass_test_imp=UlsAssessmentTest::assessment_test_vital_count($ass_details['test_id'],$level_l2[$key],$level_n_l2[$key],$comp_imps);
											$imp_count1=count($ass_test_imp)+$imp_count1;
										}
									}
									if(!empty($comp_l3)){
										foreach($comp_l3 as $key=>$comp_ss){

											if($key==0){
												$ass_test_l3=UlsAssessmentTest::assessment_test_vital_count($ass_details['test_id'],$level_l3[$key],$level_n_l3[$key],$comp_ss);
												$l3_count1=count($ass_test_l3);
											}
											else{
												$ass_test_l3=UlsAssessmentTest::assessment_test_vital_count($ass_details['test_id'],$level_l3[$key],$level_n_l3[$key],$comp_ss);
												$l3_count1=count($ass_test_l3)+$l3_count1;
											}
										}
									}
									if(!empty($comp_l4)){
										foreach($comp_l4 as $key=>$comp_sss){
											if($key==0){
												$ass_test_l4=UlsAssessmentTest::assessment_test_vital_count($ass_details['test_id'],$level_l4[$key],$level_n_l4[$key],$comp_sss);
												$l4_count1=count($ass_test_l4);
											}
											else{
												$ass_test_l4=UlsAssessmentTest::assessment_test_vital_count($ass_details['test_id'],$level_l4[$key],$level_n_l4[$key],$comp_sss);
												$l4_count1=count($ass_test_l4)+$l4_count1;
											}
										}
									}
									if(!empty($comp_l5)){
										foreach($comp_l5 as $key=>$comp_ssss){
											if($key==0){
												$ass_test_l5=UlsAssessmentTest::assessment_test_vital_count($ass_details['test_id'],$level_l5[$key],$level_n_l5[$key],$comp_ssss);
												$l5_count1=count($ass_test_l5);
											}
											else{
												$ass_test_l5=UlsAssessmentTest::assessment_test_vital_count($ass_details['test_id'],$level_l5[$key],$level_n_l5[$key],$comp_ssss);
												$l5_count1=count($ass_test_l5)+$l5_count1;
											}
										}
									}
									
									if(isset($c_id[0])){
										$vit_count[$c_id[0]]=!empty($vit_count1)?$vit_count1:0;
									}
									if(isset($c_id[1])){
										$vit_count[$c_id[1]]=!empty($imp_count1)?$imp_count1:0;
									}
									if(isset($c_id[2])){
										$vit_count[$c_id[2]]=!empty($l3_count1)?$l3_count1:0;
									}
									if(isset($c_id[3])){
										$vit_count[$c_id[3]]=!empty($l4_count1)?$l4_count1:0;
									}
									if(isset($c_id[4])){
										$vit_count[$c_id[4]]=!empty($l5_count1)?$l5_count1:0;
									}
									//print_r($vit_count);
									//echo $c1."<br>".$L1;
									$no_questions=!empty($ass_test_detail['no_questions'])?$ass_test_detail['no_questions']:$total_que;
									foreach($cricality_details as $key=>$cricality_detail){
										$id=$cricality_detail['code'];
										$data.="<div class='form-group'><label class='col-sm-4 control-label'>".$cricality_detail['name']."</label>
										<div class='col-sm-3'><input class='form-control' id='ass_".$cricality_detail['comp_cri_code']."' type='text' value='".(isset($vit_count[$id])?$vit_count[$id]:0)."' readonly></div></div>";
									}
									$data.="
									<input class='form-control' type='hidden' name='criticality' value='yes'>
								
									<div class='form-group'>
										<label class='col-sm-4 control-label'>Display  Questions<sup><font color='#FF0000'>*</font></sup></label>
										<div class='col-sm-6'><input class='validate[required] custom[number] form-control' type='text' name='no_questions' id='no_questions' value='".$no_questions."'></div>
									</div>
									<div class='form-group'>
										<label class='col-sm-4 control-label'>Duration<sup><font color='#FF0000'>*</font></sup></label>
										<div class='col-sm-6'><input class='validate[required] custom[number] form-control' type='text' id='time' name='time' value='".$time."'></div>
									</div>

									
								
								<div class='hr-line-dashed'></div>";
								if($ass_position['assessment_broadcast']!='A' ){
								$data.="<div class='form-group '>
									<div class='col-sm-12'>
									
										<button class='btn btn-primary' type='submit' name='position_submit' id='position_submit'>Save changes</button>&nbsp;";
										if($ass_test_detail['generate_test']==1 && !empty($comp_test_id)){
											$data.="<button class='btn btn-info' type='button' onclick='get_check_questions(".$comp_test_id.")'>Generate Questions</button>&nbsp;";
											
										}
										else{
											$test_count=UlsAssessmentTestQuestions::get_question_count_ass($comp_test_id);
											if(!empty($test_count['te_count'])){
												$data.="<button class='btn btn-info' type='button' onclick='get_check_question(".$comp_test_id.")'>Preview</button>";
											}
											else{
												$data.="<button class='btn btn-info' type='button' disabled>Preview</button>";
											}
											
										}
									$data.="</div>
								</div>";
								}
								else{
									$data.="<div class='form-group '>
									<div class='col-sm-12'>";
										if(!empty($comp_test_id)){
											$data.="<button class='btn btn-info' type='button' onclick='get_check_question(".$comp_test_id.")'>Preview</button>";
										}
										else{
											$data.="<button class='btn btn-info' type='button' disabled>Preview</button>";
										}
										$data.="</div></div>";
								}
							$data.="</form>
						</div>
					</div>
				</div>";
			}
		echo $data;
	}
	
	/* $criticality=!empty($ass_test_detail['criticality'])?($ass_test_detail['criticality']=='yes')?"checked='checked'":"":"";
	$criticality_no=!empty($ass_test_detail['criticality'])?($ass_test_detail['criticality']=='no')?"checked='checked'":"":"checked='checked'";
	$data.="<div class='form-group col-lg-12'>
		<label class='col-sm-3 control-label'>Criticality</label>
		<div class='col-sm-9'>
			<label class='radio-inline'>
				<input type='radio' name='criticality' id='critical".$id."' onclick='open_cri(".$id.")' value='yes' ".$criticality."> Yes
			</label>
			<label class='radio-inline'>
				<input type='radio' name='criticality' id='none".$id."' value='no' onclick='open_cri_no(".$id.")' ".$criticality_no."> No
			</label>
		</div>
	</div>";

	$cri_check=!empty($ass_test_detail['criticality'])?($ass_test_detail['criticality']=='yes')?"block":"none":"none";
	$data.="<div class='form-group' id='cri_info".$id."' style='display:".$cri_check."'>
		";
		
		$cricality_details=UlsCompetencyCriticality::criticality_names();
		foreach($cricality_details as $key=>$cricality_detail){
			
		$per_ass=!empty($ass_test_detail['criticality'])?$ass_test_detail[strtolower("per_".$cricality_detail['comp_cri_code'])]:"";
		$data.="<div class='form-group'>";
			if(!empty($ass_test_detail['criticality'])){
				$c1=$ass_test_detail[strtolower($cricality_detail['comp_cri_code'])];
				$data.="<label class='col-sm-4 control-label'>".$cricality_detail['name']."<sup><font color='#FF0000'>*</font></sup></label>
				<div class='col-sm-2'><input class='form-control' type='text' name='".$cricality_detail['comp_cri_code']."' id='".$cricality_detail['comp_cri_code']."' value='".$c1."' onchange='open_percentage(\"".$cricality_detail['comp_cri_code']."\")'></div>";
			}
			else{
				$data.="<label class='col-sm-4 control-label'>".$cricality_detail['name']."<sup><font color='#FF0000'>*</font></sup></label>
				<div class='col-sm-2'><input class='validate[required] form-control' type='text' name='".$cricality_detail['comp_cri_code']."' id='".$cricality_detail['comp_cri_code']."' onchange='open_percentage(\"".$cricality_detail['comp_cri_code']."\")'></div>";
			}
			$data.="<div class='col-sm-2'><input class='form-control' type='text' name='per_".$cricality_detail['comp_cri_code']."' id='per_".$cricality_detail['comp_cri_code']."' value='".$per_ass."' readonly></div>";
			$data.="</div>";
			
		}
		
	$data.="</div> */
	
	public function inbasket_test_details(){
		$in_id=$_REQUEST['inbasket_id'];
		$data="";
		$compdetails=UlsInbasketMaster::viewinbasket($in_id);
		$assess_test_id=$_REQUEST['assess_test_id'];
		$test_id=$_REQUEST['test_id'];
		$question=UlsAssessmentTestQuestions::getquestions_info($assess_test_id,$test_id);
		$act=!empty($compdetails['inbasket_upload'])?"":"display:none";
		$act2=!empty($compdetails['inbasket_upload'])?"display:none":"";
		$data.="
		<div class='row'>
			<div class='col-md-8 col-sm-12' style='height:450px;overflow: hide;'>
				<div class='panel panel-default card-view'>
					<div class='panel-body' style='padding:0px;'>
						<div class='tab-content'>
							<div id='note1' class='tab-pane active'>
								<div class='note-content'>
									<div id='casedesc' class='form-control' style='height:400px;overflow:hide;$act2'>".$compdetails['inbasket_name']."<br>".$compdetails['inbasket_narration']."
									</div>";
									if(!empty($compdetails['inbasket_upload'])){
										
										$data.="<div id='casepdf' class='form-control' style='height:400px;overflow:hide; $act'><iframe src='https://drive.google.com/viewerng/viewer?url=".BASE_URL."/public/uploads/inbasket/".$compdetails['inbasket_id']."/".$compdetails['inbasket_upload']."?pid=explorer&efh=false&a=v&chrome=false&embedded=true' height='390px' width='100%'></iframe></div>";
									}
									$data.="</div>
									<div class='btn-group'>
										<button onclick='opendesc()' class='btn btn-info' type='button'>View Description</button>";
										if(!empty($compdetails['inbasket_upload'])){
										$data.="<button onclick='openpdf()' class='btn btn-success' type='button'>View PDF</button>";
										}
									$data.="</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<style>
				.ui-widget.ui-widget-content {border: 1px solid #c5c5c5;border-bottom-right-radius: 3px;}
				.ui-widget-header {border: 1px solid #dddddd;background: #e9e9e9;color: #333333;font-weight: bold;}
				.ui-state-default{border:0px;background: #fff;}
				.ui-widget-content {border: 1px solid #dddddd;background: #ffffff;color: #333333;}
				.column { list-style-type: none; margin: 0; padding: 0; width: 95%;}
				.portlet{margin: 0 1em 1em 0;padding: 0.3em;}
				.portlet-header {padding: 0.2em 0.3em;margin-bottom: 0.5em;position: relative;border: 1px solid #dddddd;background: #e9e9e9;color: #333333;font-weight: bold;}
				.portlet-toggle {position: absolute;top: 50%;right: 0;margin-top: -8px;}
				.portlet-content {padding: 0.4em;}
				.portlet-placeholder {border: 1px dotted black;margin: 0 1em 1em 0;height: 50px;}
				</style>
				<div class='col-md-4 col-sm-12' style='height:440px;overflow: auto;'>
					<div class='panel panel-default card-view panel-group'>
						<div class='panel-body'>
							<div class='text-center text-muted font-bold'>Inbasket Questions</div>

						</div>
						<div id='notes' style='height:380px; overflow-y:auto;'>";
						
						foreach($question as $keys=>$questions){
							$key=$keys+1;
							$data.="<div class='panel-body note-link'>
								
								<div class='small'>
									<div class='panel-heading'>
										<div>
											".$questions['question_name']."
										</div>
										<div class='clearfix'></div>
									</div>
									
									<ul class='column'>";
										$question_value=UlsQuestionValues::get_allquestion_values_competency($questions['q_id']);
										foreach($question_value as $k=>$question_values){
											$parsed_json="";
											if(!empty($question_values['inbasket_mode'])){												
												$parsed_json = json_decode($question_values['inbasket_mode'], true);
											}
											$ks=$k+1;
											$data.="
											<li class='ui-state-default'>
												<div class='portlet'>
													<div class='portlet-header'>
														Intray ".$ks." - ".$question_values['comp_def_name']." : ".$question_values['scale_name']."
													</div>
													<div class='portlet-content'>";
														if(!empty($parsed_json)){
															foreach($parsed_json as $key => $value)
															{
															$data.="
															   <p><code>Mode:</code>".$value['mode']."</p>
															   <p><code>Time:</code>".$value['period']."</p>
															   <p><code>From:</code>".$value['from']."</p>";
															}
														}
														$data.="<p class='text-muted'>".$question_values['text']."</p>
													</div>
												</div>
											</li>";
										}
							$data.="</ul></div>";
						}
						$data.="</div>
					</div>
				</div>
			</div>
		</div>";
		echo $data;
	}
	
	public function inbasket_competency_details(){
		$in_id=$_REQUEST['inbasket_id'];
		$data="";
		$question=UlsQuestionValues::get_allquestion_values_competency_unique($in_id);
		$data.="
		<div class='row'>
			<table class='table table-bordered table-striped' cellspacing='1' cellpadding='1'>
				<thead>
				<tr>
					<th>Competency Name</th>
					<th>Scale Name</th>
				</tr>
				</thead>
				<tbody>";
					foreach($question as $questions){
					$data.="<tr>
						<td>".$questions['comp_def_name']."</td>
						<td>".$questions['scale_name']."</td>
					</tr>";
					}
				$data.="</tbody>
			</table>
		</div>";
		echo $data;
	}
	
	public function casestudy_test_details(){
		$in_id=$_REQUEST['casestudy_id'];
		$assess_test_id=$_REQUEST['assess_test_id'];
		$test_id=$_REQUEST['test_id'];
		$data="";
		$compdetails=UlsCaseStudyMaster::viewcasestudy($in_id);
		$question=UlsAssessmentTestQuestions::getcasesquestions_info($assess_test_id,$test_id);
		$act=!empty($compdetails['casestudy_source'])?"":"display:none";
		$act2=!empty($compdetails['casestudy_source'])?"display:none":"";
		$data.="
		<div class='row'>
			<div class='col-md-8 col-sm-12'>
				<div class='panel panel-default card-view'>
					<div class='panel-body' style='padding:0px;'>
						<div class='tab-content'>
							<div id='note1' class='tab-pane active'>
								<div class='note-content'>
									<div id='casedesc' class='form-control' style='height:345px;overflow:auto; $act2'><b>".$compdetails['casestudy_name']."</b><br>".$compdetails['casestudy_description']."
									</div>";
									if(!empty($compdetails['casestudy_source'])){
										//><iframe src='".BASE_URL."/public/webpdf/web/viewer.php?id=uploads/casestudy/".$_REQUEST['casestudy_id']."/".$compdetails['casestudy_source']."' height='345px' width='100%'></iframe>
										$data.="<div id='casepdf' class='form-control' style='height:345px;overflow:hide; $act'><iframe src='https://drive.google.com/viewerng/viewer?url=".BASE_URL."/public/uploads/casestudy/".$_REQUEST['casestudy_id']."/".$compdetails['casestudy_source']."?pid=explorer&efh=false&a=v&chrome=false&embedded=true' height='345px' width='100%'></iframe></div>";
									}
									$data.="</div>
									<div class='btn-group'>
										<button onclick='opendesc()' class='btn btn-info' type='button'>View Description</button>";
										if(!empty($compdetails['casestudy_source'])){
										$data.="<button onclick='openpdf()' class='btn btn-success' type='button'>View PDF</button>";
										}
									$data.="</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class='col-md-4 col-sm-12'>
					<div class='panel panel-default card-view panel-group'>
						<div class='panel-body'>
							<div class='text-center text-muted font-bold'>Case Study Questions</div>

						</div>
						<div class='panel-section'>
						
						</div>
						<div id='notes' style='height:350px;'>";
						foreach($question as $keys=>$questions){
							$key=$keys+1;
							$data.="<div class='panel-body note-link'>
								<a href='#note1' data-toggle='tab'>
									<h5>".$questions['comp_def_name']."</h5>
								</a>
								<div class='small'><p style='float:left;'>".$key.")</p>&nbsp;".$questions['question_name']."</div>
							</div>";
						}
						$data.="</div>
					</div>
				</div>
			</div>
			
		</div>";
								
		echo $data;
	}
	
	public function position_inbasket_details(){
		$assessment_id=$_REQUEST['assessment_id'];
		$position_id=$_REQUEST['position_id'];
		$ass_type=$_REQUEST['ass_type'];
		$ass_position=UlsAssessmentPosition::get_assessment_position($position_id);
		$status=UlsAdminMaster::get_value_names("STATUS");
		//$ass_detail_inbasket=UlsCompetencyTest::test_count_assessment_inbasket($assessment_id,$position_id,$ass_type);
		$ass_detail_inbasket=UlsInbasketMaster::viewinbasket_position($position_id);
		$data="";
		$data.="<form class='form-horizontal'  name='inbasket_form' id='inbasket_form' method='post' action='".BASE_URL."/admin/lms_assessment_position_inbasket'>
			<input type='hidden' name='inb_assess_test_id' id='inb_assess_test_id' value=''>
			<input type='hidden' name='position_id' id='position_id' value='".$position_id."'>
			<input type='hidden' name='assessment_id' id='assessment_id' value='".$assessment_id."'>
			<input type='hidden' name='assessment_pos_id' id='assessment_pos_id' value='".$ass_position['assessment_pos_id']."'>
			<input type='hidden' name='assessment_type' id='assessment_type' value='INBASKET'>
			<div class='form-group'><label class='col-sm-4 control-label'>Inbasket Test Name<sup><font color='#FF0000'>*</font></sup>:</label>
				<div class='col-sm-8'>
					<select id='inbasket_id' name='inbasket_id' class='validate[required] form-control m-b'>
						<option value=''>Select</option>";
						//".$ass_detail['test_id']."-
						foreach($ass_detail_inbasket as $key=>$ass_detail){
							$data.="<option value='".$ass_detail['inbasket_id']."' >".$ass_detail['inbasket_name']."</option>";
						}
					$data.="</select>
				</div>
			</div>
			<div class='form-group'><label class='col-sm-4 control-label'>Time<sup><font color='#FF0000'>*</font></sup>:</label>
				<div class='col-sm-8'>
					<input type='text' name='inbasket_time' id='inbasket_time' class='validate[required] form-control'>
				</div>
			</div>
			<div class='form-group'><label class='col-sm-4 control-label'>Status<sup><font color='#FF0000'>*</font></sup>:</label>
				<div class='col-sm-8'>
					<select id='status' name='status' class='validate[required] form-control m-b'>
						<option value=''>Select</option>";
						foreach($status as $comp_status){
							$data.="<option value='".$comp_status['code']."'>".$comp_status['name']."</option>";
						}
					$data.="</select>
				</div>
			</div>
			<div class='hr-line-dashed'></div>
			<div class='form-group'>
				<div class='col-sm-offset-3'>
					<button class='btn btn-danger' type='button' data-dismiss='modal'>Cancel</button>
					<button class='btn btn-success' type='submit'  name='update'>Save changes</button>
				</div>
			</div>
		</form>";
		echo $data;
	}
	
	public function position_behavorial_details(){
		$assessment_id=$_REQUEST['assessment_id'];
		$position_id=$_REQUEST['position_id'];
		$ass_type=$_REQUEST['ass_type'];
		$ass_position=UlsAssessmentPosition::get_assessment_position($position_id);
		$status=UlsAdminMaster::get_value_names("STATUS");
		$ass_detail_instrument=UlsBeInstruments::viewinstruments();
		$data="";
		$data.="<form class='form-horizontal'  name='behavorial_form' id='behavorial_form' method='post' action='".BASE_URL."/admin/lms_assessment_position_behavorial'>
			<input type='hidden' name='beh_inst_id' id='beh_inst_id' value=''>
			<input type='hidden' name='position_id' id='position_id' value='".$position_id."'>
			<input type='hidden' name='assessment_id' id='assessment_id' value='".$assessment_id."'>
			<input type='hidden' name='assessment_pos_id' id='assessment_pos_id' value='".$ass_position['assessment_pos_id']."'>
			<input type='hidden' name='assessment_type' id='assessment_type' value='BEHAVORIAL_INSTRUMENT'>
			<div class='form-group'><label class='col-sm-4 control-label'>Instrument Name<sup><font color='#FF0000'>*</font></sup>:</label>
				<div class='col-sm-8'>
					<select id='instrument_id' name='instrument_id' class='validate[required] form-control m-b'>
						<option value=''>Select</option>";
						//".$ass_detail['test_id']."-
						foreach($ass_detail_instrument as $key=>$ass_detail_instruments){
							$data.="<option value='".$ass_detail_instruments['instrument_id']."-".$ass_detail_instruments['instrument_scale']."' >".$ass_detail_instruments['instrument_name']."</option>";
						}
					$data.="</select>
				</div>
			</div>
			<div class='form-group'><label class='col-sm-4 control-label'>Status<sup><font color='#FF0000'>*</font></sup>:</label>
				<div class='col-sm-8'>
					<select id='status' name='status' class='validate[required] form-control m-b'>
						<option value=''>Select</option>";
						foreach($status as $comp_status){
							$data.="<option value='".$comp_status['code']."'>".$comp_status['name']."</option>";
						}
					$data.="</select>
				</div>
			</div>
			<div class='hr-line-dashed'></div>
			<div class='form-group'>
				<div class='col-sm-offset-3'>
					<button class='btn btn-danger' type='button' data-dismiss='modal'>Cancel</button>
					<button class='btn btn-success' type='submit'  name='update'>Save changes</button>
				</div>
			</div>
		</form>";
		echo $data;
	}
	
	public function position_casestudy_details(){
		$assessment_id=$_REQUEST['assessment_id'];
		$position_id=$_REQUEST['position_id'];
		$ass_type=$_REQUEST['ass_type'];
		$ass_position=UlsAssessmentPosition::get_assessment_position($position_id);
		$status=UlsAdminMaster::get_value_names("STATUS");
		$ass_detail_casestudy=UlsCaseStudyMaster::viewcasestudy_ass($assessment_id);
		$data="";
		$data.="<form class='form-horizontal'  name='case_study_form' id='case_study_form' method='post' action='".BASE_URL."/admin/lms_assessment_position_casestudy'>
			<input type='hidden' name='case_assess_test_id' id='case_assess_test_id' value=''>
			<input type='hidden' name='position_id' id='position_id' value='".$position_id."'>
			<input type='hidden' name='assessment_id' id='assessment_id' value='".$assessment_id."'>
			<input type='hidden' name='assessment_pos_id' id='assessment_pos_id' value='".$ass_position['assessment_pos_id']."'>
			<input type='hidden' name='assessment_type' id='assessment_type' value='CASE_STUDY'>
			<div class='form-group'><label class='col-sm-4 control-label'>Case study Test Name<sup><font color='#FF0000'>*</font></sup>:</label>
				<div class='col-sm-8'>
					<select id='test_id' name='test_id' class='validate[required] form-control m-b'>
						<option value=''>Select</option>";
						foreach($ass_detail_casestudy as $key=>$ass_detail){
							$data.="<option value='".$ass_detail['casestudy_id']."' >".$ass_detail['casestudy_name']."</option>";
						}
					$data.="</select>
				</div>
			</div>
			<div class='form-group'><label class='col-sm-4 control-label'>Time<sup><font color='#FF0000'>*</font></sup>:</label>
				<div class='col-sm-8'>
					<input type='text' name='casestudy_time' id='casestudy_time' class='validate[required] form-control'>
				</div>
			</div>
			<div class='form-group'><label class='col-sm-4 control-label'>Status<sup><font color='#FF0000'>*</font></sup>:</label>
				<div class='col-sm-8'>
					<select id='status' name='status' class='validate[required] form-control m-b'>
						<option value=''>Select</option>";
						foreach($status as $comp_status){
							$data.="<option value='".$comp_status['code']."'>".$comp_status['name']."</option>";
						}
					$data.="</select>
				</div>
			</div>
			<div class='hr-line-dashed'></div>
			<div class='form-group'>
				<div class=' col-sm-offset-3'>
					<button class='btn btn-danger' type='button' data-dismiss='modal'>Cancel</button>
					<button class='btn btn-success' type='submit'  name='update'>Save changes</button>
				</div>
			</div>
		</form>";
		echo $data;
	}
	
	public function position_fishbone_details(){
		$assessment_id=$_REQUEST['assessment_id'];
		$position_id=$_REQUEST['position_id'];
		$ass_type=$_REQUEST['ass_type'];
		$ass_position=UlsAssessmentPosition::get_assessment_position($position_id);
		$status=UlsAdminMaster::get_value_names("STATUS");
		$ass_detail_fishbone=UlsFishboneMaster::viewfishbone_ass($assessment_id);
		$data="";
		$data.="<form class='form-horizontal'  name='fishbone_form' id='fishbone_form' method='post' action='".BASE_URL."/admin/lms_assessment_position_fishbone'>
			<input type='hidden' name='case_assess_test_id' id='case_assess_test_id' value=''>
			<input type='hidden' name='position_id' id='position_id' value='".$position_id."'>
			<input type='hidden' name='assessment_id' id='assessment_id' value='".$assessment_id."'>
			<input type='hidden' name='assessment_pos_id' id='assessment_pos_id' value='".$ass_position['assessment_pos_id']."'>
			<input type='hidden' name='assessment_type' id='assessment_type' value='FISHBONE'>
			<div class='form-group'><label class='col-sm-4 control-label'>Case study Test Name<sup><font color='#FF0000'>*</font></sup>:</label>
				<div class='col-sm-8'>
					<select id='test_id' name='test_id' class='validate[required] form-control m-b'>
						<option value=''>Select</option>";
						foreach($ass_detail_fishbone as $key=>$ass_detail){
							$data.="<option value='".$ass_detail['fishbone_id']."' >".$ass_detail['fishbone_name']."</option>";
						}
					$data.="</select>
				</div>
			</div>
			<div class='form-group'><label class='col-sm-4 control-label'>Time<sup><font color='#FF0000'>*</font></sup>:</label>
				<div class='col-sm-8'>
					<input type='text' name='casestudy_time' id='casestudy_time' class='validate[required] form-control'>
				</div>
			</div>
			<div class='form-group'><label class='col-sm-4 control-label'>Status<sup><font color='#FF0000'>*</font></sup>:</label>
				<div class='col-sm-8'>
					<select id='status' name='status' class='validate[required] form-control m-b'>
						<option value=''>Select</option>";
						foreach($status as $comp_status){
							$data.="<option value='".$comp_status['code']."'>".$comp_status['name']."</option>";
						}
					$data.="</select>
				</div>
			</div>
			<div class='hr-line-dashed'></div>
			<div class='form-group'>
				<div class=' col-sm-offset-3'>
					<button class='btn btn-danger' type='button' data-dismiss='modal'>Cancel</button>
					<button class='btn btn-success' type='submit'  name='update'>Save changes</button>
				</div>
			</div>
		</form>";
		echo $data;
	}
	
	public function lms_assessment_position_behavorial(){
        $this->sessionexist();
        if(isset($_POST['position_id'])){
            $fieldinsertupdates=array('status');
			$test_beh=explode("-",$_POST['instrument_id']);
			$check_aas_test=UlsAssessmentTest::get_ass_position_test($_POST['assessment_id'],$_POST['position_id'],$_POST['assessment_type']);
			$ass_test=!empty($check_aas_test['assess_test_id'])? Doctrine_Core::getTable('UlsAssessmentTest')->find($check_aas_test['assess_test_id']):new UlsAssessmentTest();
			$ass_test->assessment_pos_id=$_POST['assessment_pos_id'];
			$ass_test->position_id=$_POST['position_id'];
			$ass_test->assessment_id=$_POST['assessment_id'];
			$ass_test->assessment_type=$_POST['assessment_type'];
			$ass_test->save();
			$beh_inst_id=trim($_POST['beh_inst_id']);
            $ass_test_beh=!empty($beh_inst_id)?Doctrine::getTable('UlsAssessmentTestBehavorialInst')->find($_POST['beh_inst_id']):new UlsAssessmentTestBehavorialInst();
            foreach($fieldinsertupdates as $val){
				$ass_test_beh->$val=(!empty($_POST[$val]))?($_POST[$val]):NULL;
			}
			$ass_test_beh->instrument_id=$test_beh[0];
			$ass_test_beh->instrument_scale=$test_beh[1];
			$ass_test_beh->assess_test_id=$ass_test->assess_test_id;
			$ass_test_beh->assessment_pos_id=$ass_test->assessment_pos_id;
			$ass_test_beh->position_id=$ass_test->position_id;
			$ass_test_beh->assessment_id=$ass_test->assessment_id;
			$ass_test_beh->assessment_type=$ass_test->assessment_type;
            $ass_test_beh->save();-
            redirect('admin/assessment_details?tab=4&pos_id='.$_POST['position_id'].'&id='.$_POST['assessment_id'].'&hash='.md5(SECRET.$_POST['assessment_id']));
        }
        else{
			$content = $this->load->view('admin/assessment_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }
	
	public function lms_assessment_position_inbasket(){
        $this->sessionexist();
        if(isset($_POST['inbasket_id'])){
            $fieldinsertupdates=array('status');
			$question=UlsQuestionbank::get_questions_data_inbasket($_POST['inbasket_id']);
			$inbasket_detail=UlsInbasketMaster::viewinbasket_ass($_POST['inbasket_id']);
			$code_inbasket='COMP_INBASKET';
			$test=UlsPosition::viewposition($_POST['position_id']);
			$test_name="Test-".$test['position_name']."-".$_POST['assessment_id']."-".$code_inbasket."-".$question['inbasket_id'];
			$test_detail=UlsCompetencyTest::get_test_detail_name($test_name);
			$question_insert=!empty($test_detail['test_id'])? Doctrine_Core::getTable('UlsCompetencyTest')->find($test_detail['test_id']):new UlsCompetencyTest();
			$question_insert->test_code='TECC';
			$question_insert->test_name=$test_name;
			$question_insert->inbasket_id=$_POST['inbasket_id'];
			$question_insert->rating_scale_id=NULL;
			$question_insert->test_type_flag=$code_inbasket;
			$question_insert->description=NULL;
			$question_insert->active_flag='P';
			$question_insert->assessment_id=$_POST['assessment_id'];
			$question_insert->position_id=$_POST['position_id'];
			$question_insert->save();
			$del=Doctrine_Query::create()->delete('UlsCompetencyTestQuestions')->where("question_id=".$question['id']." and test_id=".$question_insert->test_id)->execute();
			$sd=Doctrine_Core::getTable('UlsCompetencyTestQuestions')->findOneByTestIdAndQuestionId($question_insert->test_id,$question['id']);
			if(empty($sd)){
				$question_values=new UlsCompetencyTestQuestions();
				$question_values->test_id=$question_insert->test_id;
				$question_values->question_id=$question['id'];
				$question_values->question_bank_id=$question['question_bank_id'];
				$question_values->save();
			}
			$check_aas_test=UlsAssessmentTest::get_ass_position_test($_POST['assessment_id'],$_POST['position_id'],$_POST['assessment_type']);
			$ass_test=!empty($check_aas_test['assess_test_id'])? Doctrine_Core::getTable('UlsAssessmentTest')->find($check_aas_test['assess_test_id']):new UlsAssessmentTest();
			$ass_test->assessment_pos_id=$_POST['assessment_pos_id'];
			$ass_test->position_id=$_POST['position_id'];
			$ass_test->assessment_id=$_POST['assessment_id'];
			//$ass_test->test_id=$_POST['test_id'];
			$ass_test->assessment_type=$_POST['assessment_type'];
			$ass_test->time_details=$_POST['inbasket_time'];
			$ass_test->save();
			$inb_assess_test_id=trim($_POST['inb_assess_test_id']);
            $ass_test_inbasket=!empty($inb_assess_test_id)?Doctrine::getTable('UlsAssessmentTestInbasket')->find($_POST['inb_assess_test_id']):new UlsAssessmentTestInbasket();
            //!isset($ass_test_inbasket->inb_assess_test_id)?$ass_test_inbasket=new UlsAssessmentTestInbasket():"";
            foreach($fieldinsertupdates as $val){
				$ass_test_inbasket->$val=(!empty($_POST[$val]))?($_POST[$val]):NULL;
			}
			$ass_test_inbasket->test_id=$question_insert->test_id;
			$ass_test_inbasket->inbasket_id=$_POST['inbasket_id'];
			$ass_test_inbasket->assess_test_id=$ass_test->assess_test_id;
			$ass_test_inbasket->assessment_pos_id=$ass_test->assessment_pos_id;
			$ass_test_inbasket->position_id=$ass_test->position_id;
			$ass_test_inbasket->assessment_id=$ass_test->assessment_id;
			$ass_test_inbasket->assessment_type=$ass_test->assessment_type;
            $ass_test_inbasket->save();
			
			$check_aas_test_question=UlsAssessmentTest::assessment_test_questions($question_insert->test_id,$_POST['assessment_id'],$_POST['position_id'],'COMP_INBASKET');
			if(count($check_aas_test_question)>0){
				foreach($check_aas_test_question as $ass_tests){
					$test_qvalues=new UlsAssessmentTestQuestions();
					$test_qvalues->assess_test_id=$ass_test->assess_test_id;
					$test_qvalues->test_quest_id=$ass_tests['test_quest_id'];
					$test_qvalues->test_id=$ass_tests['test_ids'];
					$test_qvalues->question_id=$ass_tests['question_id'];
					$test_qvalues->question_bank_id=$ass_tests['question_bank_id'];
					$test_qvalues->assessment_id=$ass_tests['assessment_id'];
					$test_qvalues->position_id=$ass_tests['position_id'];
					$test_qvalues->save();
				}
			}
			
            redirect('admin/assessment_details?tab=4&pos_id='.$_POST['position_id'].'&id='.$_POST['assessment_id'].'&hash='.md5(SECRET.$_POST['assessment_id']));
        }
        else{
			$content = $this->load->view('admin/assessment_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }
	
	public function lms_assessment_position_casestudy(){
        $this->sessionexist();
        if(isset($_POST['test_id'])){
			//print_r($_POST['test_id']);
			$code_casestudy='COMP_CASESTUDY';
			$test=UlsCaseStudyMaster::viewcasestudy($_POST['test_id']);
			$test_name="Test-".$test['casestudy_name']."-".$_POST['assessment_id']."-".$code_casestudy."-".$test['casestudy_id']."-".$_POST['position_id'];
			$test_detail=UlsCompetencyTest::get_test_detail_name($test_name);
			$question_insert=!empty($test_detail['test_id'])? Doctrine_Core::getTable('UlsCompetencyTest')->find($test_detail['test_id']):new UlsCompetencyTest();
			$question_insert->test_code='TECC';
			$question_insert->test_name=$test_name;
			$question_insert->casestudy_id=$_POST['test_id'];
			$question_insert->rating_scale_id=NULL;
			$question_insert->test_type_flag=$code_casestudy;
			$question_insert->description=NULL;
			$question_insert->active_flag='P';
			$question_insert->assessment_id=$_POST['assessment_id'];
			$question_insert->position_id=$_POST['position_id'];
			$question_insert->save();
			$case_question=UlsCaseStudyMaster::viewcasestudy_ass_question($_POST['assessment_id'],$_POST['position_id'],$test['casestudy_id']);
			
			foreach($case_question as $case_questions){
				$del=Doctrine_Query::create()->delete('UlsCompetencyTestQuestions')->where("question_id=".$case_questions['casestudy_quest_id']." and test_id=".$question_insert->test_id)->execute();
				$ass_comp_details=UlsAssessmentCompetencies::get_casestudy_competencies($question_insert->assessment_id,$question_insert->position_id,$case_questions['comp_def_id'],$case_questions['scale_id']);
				if(isset($ass_comp_details['assessment_pos_comp_id'])){
					
					$sd=Doctrine_Core::getTable('UlsCompetencyTestQuestions')->findOneByTestIdAndQuestionId($question_insert->test_id,$case_questions['casestudy_quest_id']);
					if(empty($sd)){
						$question_values=new UlsCompetencyTestQuestions();
						$question_values->test_id=$question_insert->test_id;
						$question_values->question_id=$case_questions['casestudy_quest_id'];
						$question_values->save();
					}
				}
			}
			
            $fieldinsertupdates=array('status');
			$check_aas_test=UlsAssessmentTest::get_ass_position_test($_POST['assessment_id'],$_POST['position_id'],$_POST['assessment_type']);
			$ass_test=!empty($check_aas_test['assess_test_id'])? Doctrine_Core::getTable('UlsAssessmentTest')->find($check_aas_test['assess_test_id']):new UlsAssessmentTest();
			$ass_test->assessment_pos_id=$_POST['assessment_pos_id'];
			$ass_test->position_id=$_POST['position_id'];
			$ass_test->assessment_id=$_POST['assessment_id'];
			$ass_test->test_id=$question_insert->test_id;
			$ass_test->assessment_type=$_POST['assessment_type'];
			$ass_test->time_details=$_POST['casestudy_time'];
			$ass_test->save();
			
			$ass_test_inbasket=!empty($_POST['case_assess_test_id'])?Doctrine::getTable('UlsAssessmentTestCasestudy')->find($_POST['case_assess_test_id']):new UlsAssessmentTestCasestudy();
			foreach($fieldinsertupdates as $val){
				$ass_test_inbasket->$val=(!empty($_POST[$val]))?($_POST[$val]):NULL;
			}
			$ass_test_inbasket->test_id=$question_insert->test_id;
			$ass_test_inbasket->casestudy_id=$_POST['test_id'];
			$ass_test_inbasket->assess_test_id=$ass_test->assess_test_id;
			$ass_test_inbasket->assessment_pos_id=$ass_test->assessment_pos_id;
			$ass_test_inbasket->position_id=$ass_test->position_id;
			$ass_test_inbasket->assessment_id=$ass_test->assessment_id;
			$ass_test_inbasket->assessment_type=$ass_test->assessment_type;
            $ass_test_inbasket->save();
			
			$check_aas_test_question=UlsAssessmentTest::assessment_test_question_casestudy($question_insert->test_id,$_POST['assessment_id'],$_POST['position_id'],'COMP_CASESTUDY');
			if(count($check_aas_test_question)>0){
				foreach($check_aas_test_question as $ass_tests){
					$test_qvalues=new UlsAssessmentTestQuestions();
					$test_qvalues->assess_test_id=$ass_test->assess_test_id;
					$test_qvalues->test_quest_id=$ass_tests['test_quest_id'];
					$test_qvalues->test_id=$ass_tests['test_ids'];
					$test_qvalues->question_id=$ass_tests['question_id'];
					$test_qvalues->assessment_id=$ass_tests['assessment_id'];
					$test_qvalues->position_id=$ass_tests['position_id'];
					$test_qvalues->save();
				}
			}
			
           redirect('admin/assessment_details?tab=4&pos_id='.$_POST['position_id'].'&id='.$_POST['assessment_id'].'&hash='.md5(SECRET.$_POST['assessment_id']));
        }
        else{
			$content = $this->load->view('admin/assessment_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }
	
	public function lms_assessment_position_fishbone(){
        $this->sessionexist();
        if(isset($_POST['test_id'])){
			//print_r($_POST['test_id']);
			$code_casestudy='FISH_STUDY';
			$test=UlsFishboneMaster::viewfishbone($_POST['test_id']);
			$test_name="Test-".$test['fishbone_name']."-".$_POST['assessment_id']."-".$code_casestudy."-".$test['fishbone_id']."-".$_POST['position_id'];
			$test_detail=UlsCompetencyTest::get_test_detail_name($test_name);
			$question_insert=!empty($test_detail['test_id'])? Doctrine_Core::getTable('UlsCompetencyTest')->find($test_detail['test_id']):new UlsCompetencyTest();
			$question_insert->test_code='TECC';
			$question_insert->test_name=$test_name;
			$question_insert->fishbone_id=$_POST['test_id'];
			$question_insert->rating_scale_id=NULL;
			$question_insert->test_type_flag=$code_casestudy;
			$question_insert->description=NULL;
			$question_insert->active_flag='P';
			$question_insert->assessment_id=$_POST['assessment_id'];
			$question_insert->position_id=$_POST['position_id'];
			$question_insert->save();
			$case_question=UlsFishboneMaster::viewfishbone_ass_question($_POST['assessment_id'],$test['fishbone_id']);
			foreach($case_question as $case_questions){
				$ass_comp_details=UlsAssessmentCompetencies::get_casestudy_competencies($question_insert->assessment_id,$question_insert->position_id,$case_questions['comp_def_id'],$case_questions['scale_id']);
				
				if(isset($ass_comp_details['assessment_pos_comp_id'])){
					$del=Doctrine_Query::create()->delete('UlsCompetencyTestQuestions')->where("question_id=".$case_questions['fishbone_quest_id']." and test_id=".$question_insert->test_id)->execute();
					$sd=Doctrine_Core::getTable('UlsCompetencyTestQuestions')->findOneByTestIdAndQuestionId($question_insert->test_id,$case_questions['fishbone_quest_id']);
					if(empty($sd)){
						$question_values=new UlsCompetencyTestQuestions();
						$question_values->test_id=$question_insert->test_id;
						$question_values->question_id=$case_questions['fishbone_quest_id'];
						$question_values->save();
					}
				}
			}
            $fieldinsertupdates=array('status');
			$check_aas_test=UlsAssessmentTest::get_ass_position_test($_POST['assessment_id'],$_POST['position_id'],$_POST['assessment_type']);
			$ass_test=!empty($check_aas_test['assess_test_id'])? Doctrine_Core::getTable('UlsAssessmentTest')->find($check_aas_test['assess_test_id']):new UlsAssessmentTest();
			$ass_test->assessment_pos_id=$_POST['assessment_pos_id'];
			$ass_test->position_id=$_POST['position_id'];
			$ass_test->assessment_id=$_POST['assessment_id'];
			$ass_test->test_id=$question_insert->test_id;
			$ass_test->assessment_type=$_POST['assessment_type'];
			$ass_test->time_details=$_POST['casestudy_time'];
			$ass_test->save();
			
			$ass_test_inbasket=!empty($_POST['fish_assess_test_id'])?Doctrine::getTable('UlsAssessmentTestFishbone')->find($_POST['fish_assess_test_id']):new UlsAssessmentTestFishbone();
			foreach($fieldinsertupdates as $val){
				$ass_test_inbasket->$val=(!empty($_POST[$val]))?($_POST[$val]):NULL;
			}
			$ass_test_inbasket->test_id=$question_insert->test_id;
			$ass_test_inbasket->fishbone_id=$_POST['test_id'];
			$ass_test_inbasket->assess_test_id=$ass_test->assess_test_id;
			$ass_test_inbasket->assessment_pos_id=$ass_test->assessment_pos_id;
			$ass_test_inbasket->position_id=$ass_test->position_id;
			$ass_test_inbasket->assessment_id=$ass_test->assessment_id;
			$ass_test_inbasket->assessment_type=$ass_test->assessment_type;
            $ass_test_inbasket->save();
			
			$check_aas_test_question=UlsAssessmentTest::assessment_test_question_fishbone($question_insert->test_id,$_POST['assessment_id'],$_POST['position_id'],'FISH_STUDY');
			if(count($check_aas_test_question)>0){
				foreach($check_aas_test_question as $ass_tests){
					$test_qvalues=new UlsAssessmentTestQuestions();
					$test_qvalues->assess_test_id=$ass_test->assess_test_id;
					$test_qvalues->test_quest_id=$ass_tests['test_quest_id'];
					$test_qvalues->test_id=$ass_tests['test_ids'];
					$test_qvalues->question_id=$ass_tests['question_id'];
					$test_qvalues->assessment_id=$ass_tests['assessment_id'];
					$test_qvalues->position_id=$ass_tests['position_id'];
					$test_qvalues->save();
				}
			}
			
           redirect('admin/assessment_details?tab=4&pos_id='.$_POST['position_id'].'&id='.$_POST['assessment_id'].'&hash='.md5(SECRET.$_POST['assessment_id']));
        }
        else{
			$content = $this->load->view('admin/assessment_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }

	/* public function questions_view_assessment()
	{
		$this->sessionexist();
		$assess_test_id=$_REQUEST['assess_test_id'];
		$update_user=Doctrine_Query::create()->update('UlsAssessmentTest');
		$update_user->set('generate_test','?','0');
		$update_user->where("assess_test_id=".$assess_test_id)->limit(1)->execute();
		$test_detail=UlsAssessmentTest::test_details($assess_test_id);
		$del=Doctrine_Query::Create()->Delete('UlsAssessmentTestQuestions')->where("assess_test_id=".$assess_test_id)->execute();
		if($test_detail['criticality']=='yes'){
			$position=UlsAssessmentCompetencies::getassessmentcompetencies_test($test_detail['assessment_id'],$test_detail['position_id'],$test_detail['assessment_type'],$test_detail['test_id']);
			$comp_l1=$comp_l2=$comp_l3=$comp_l4=$comp_l5=$q_count_l1=array();
			$level_l1=$level_l2=$level_l3=$level_l4=$level_l5=array();
			$level=array();
			$comp_imp=array();
			$level_imp=array();
			$cricality_details=UlsCompetencyCriticality::criticality_names();
			$c_id=array();
			$i=0;
			foreach($cricality_details as $key=>$cricality_detail){
				$c_id[$i]=$cricality_detail['code'];
				$i++;
			}
			foreach($position as $positions){
				if(isset($c_id[0])){
					if($positions['cri_ids']==$c_id[0]){
						$comp_id=$positions['comp_position_competency_id'];
						$comp_l1[]=$positions['comp_position_competency_id'];
						$level_l1[$comp_id]=$positions['comp_position_level_scale_id'];
					}
				}
				
				if(isset($c_id[1])){
					if($positions['cri_ids']==$c_id[1]){
						$comp_id=$positions['comp_position_competency_id'];
						$comp_l2[]=$positions['comp_position_competency_id'];
						$level_l2[$comp_id]=$positions['comp_position_level_scale_id'];
					}
				}
				if(isset($c_id[2])){
					if($positions['cri_ids']==$c_id[2]){
						$comp_id=$positions['comp_position_competency_id'];
						$comp_l3[]=$positions['comp_position_competency_id'];
						$level_l3[$comp_id]=$positions['comp_position_level_scale_id'];
					}
				}
				if(isset($c_id[3])){
					if($positions['cri_ids']==$c_id[3]){
						$comp_id=$positions['comp_position_competency_id'];
						$comp_l4[]=$positions['comp_position_competency_id'];
						$level_l4[$comp_id]=$positions['comp_position_level_scale_id'];
					}
				}
				if(isset($c_id[4])){
					if($positions['cri_ids']==$c_id[4]){
						$comp_id=$positions['comp_position_competency_id'];
						$comp_l5[]=$positions['comp_position_competency_id'];
						$level_l5[$comp_id]=$positions['comp_position_level_scale_id'];
					}
				}
			}
			
				$no_questions=$test_detail['no_questions'];
				$vital_value = $test_detail['c1'];
				$vital_final=$vital_value;
				$imp_value = $test_detail['c2'];
				$imp_final=$imp_value;
				$imp_value_c3 = $test_detail['c3'];
				$imp_final_c3=$imp_value_c3;
				$imp_value_c4 = $test_detail['c4'];
				$imp_final_c4=$imp_value_c4;
				$imp_value_c5 = $test_detail['c5'];
				$imp_final_c5=$imp_value_c5;
				$count_v=sizeof($comp_l1);
				$total_vital=($vital_final>0)?($vital_final):0;
				$count_vital_limit=@(int)($vital_value/$count_v);
				$count_vital_limit_mul=@$vital_value-($count_vital_limit*$count_v);
				$count_i=sizeof($comp_l2);
				$total_imp=($imp_final>0)?($imp_final):0;
				$count_imp_limit=!empty($imp_value)?(int)($imp_value/$count_i):"";
				$count_imp_limit_mul=$imp_value-($count_imp_limit*$count_i);
				$count_l3=sizeof($comp_l3);
				$total_imp_l3=($imp_final_c3>0)?($imp_final_c3):0;
				$count_imp_limil3=!empty($imp_value_c3)?(int)($imp_value_c3/$count_l3):"";
				$count_imp_limit_mull3=$imp_value_c3-($count_imp_limil3*$count_l3);
				$count_l4=sizeof($comp_l4);
				$total_imp_l4=($imp_final_c4>0)?($imp_final_c4):0;
				$count_imp_limil4=!empty($imp_value_c4)?(int)($imp_value_c4/$count_l4):"";
				$count_imp_limit_mull4=$imp_value_c4-($count_imp_limil4*$count_l4);
				$count_l5=sizeof($comp_l5);
				$total_imp_l5=($imp_final_c5>0)?($imp_final_c5):0;
				$count_imp_limil5=!empty($imp_value_c5)?(int)($imp_value_c5/$count_l5):"";
				$count_imp_limit_mull5=$imp_value_c5-($count_imp_limil5*$count_l5); 
				$c1=array();
				$k=0;
				foreach($comp_l1 as $key=>$comps){
					$comp_count=UlsAssessmentTest::assessment_test_count($test_detail['test_id'],$comps);
					$c1[$comps]=$comp_count['test_count'];
				}
				asort($c1);
				
				$count_q=0;
				foreach($c1 as $key=>$comps_c1){
					if($count_vital_limit>$comps_c1){
						$count_q+=$count_vital_limit-$comps_c1;
					}
					if((count($c1)-1)==$k){
						
						$ass_test=UlsAssessmentTest::assessment_test_vital($test_detail['test_id'],($count_vital_limit+$count_vital_limit_mul+$count_q),$level_l1[$key],$key);
						foreach($ass_test as $ass_tests){
							$test_qvalues=new UlsAssessmentTestQuestions();
							$test_qvalues->assess_test_id=$assess_test_id;
							$test_qvalues->test_quest_id=$ass_tests['test_quest_id'];
							$test_qvalues->test_id=$ass_tests['test_ids'];
							$test_qvalues->question_id=$ass_tests['question_id'];
							$test_qvalues->question_bank_id=$ass_tests['question_bank_id'];
							$test_qvalues->competency_id=$ass_tests['competency_id'];
							$test_qvalues->assessment_id=$ass_tests['assessment_id'];
							$test_qvalues->position_id=$ass_tests['position_id'];
							$test_qvalues->save();
						}
						$count_q=0;
						//$c1=$comps."_".ceil($total_vital)."_".$level[$key]."<br>";
					}
					else{
						$ass_test_n=UlsAssessmentTest::assessment_test_vital($test_detail['test_id'],$count_vital_limit,$level_l1[$key],$key);
						foreach($ass_test_n as $ass_testss){
							$test_qvalues=new UlsAssessmentTestQuestions();
							$test_qvalues->assess_test_id=$assess_test_id;
							$test_qvalues->test_quest_id=$ass_testss['test_quest_id'];
							$test_qvalues->test_id=$ass_testss['test_ids'];
							$test_qvalues->question_id=$ass_testss['question_id'];
							$test_qvalues->question_bank_id=$ass_testss['question_bank_id'];
							$test_qvalues->competency_id=$ass_testss['competency_id'];
							$test_qvalues->assessment_id=$ass_testss['assessment_id'];
							$test_qvalues->position_id=$ass_testss['position_id'];
							$test_qvalues->save();
						}
						//$c1.=$comps."_".floor($total_vital)."_".$level[$key]."<br>";;
					}
					$k++;
				}
				
				$c2=array();
				foreach($comp_l2 as $key=>$comp_imps){
					$comp_count=UlsAssessmentTest::assessment_test_count($test_detail['test_id'],$comp_imps);
					$c2[$comp_imps]=$comp_count['test_count'];
				}
				asort($c2);
				//print_r($c2);
				$count_im=0;
				$k1=0;
				foreach($c2 as $key=>$comp_imps){
					if($count_imp_limit>$comp_imps){
						$count_im+=$count_imp_limit-$comp_imps;
					}
					if((count($c2)-1)==$k1){
						$ass_test_imp=UlsAssessmentTest::assessment_test_vital($test_detail['test_id'],($count_imp_limit+$count_imp_limit_mul+$count_im),$level_l2[$key],$key);
						foreach($ass_test_imp as $ass_test_imps){
							$test_qvalues=new UlsAssessmentTestQuestions();
							$test_qvalues->assess_test_id=$assess_test_id;
							$test_qvalues->test_quest_id=$ass_test_imps['test_quest_id'];
							$test_qvalues->test_id=$ass_test_imps['test_ids'];
							$test_qvalues->question_id=$ass_test_imps['question_id'];
							$test_qvalues->question_bank_id=$ass_test_imps['question_bank_id'];
							$test_qvalues->competency_id=$ass_test_imps['competency_id'];
							$test_qvalues->assessment_id=$ass_test_imps['assessment_id'];
							$test_qvalues->position_id=$ass_test_imps['position_id'];
							$test_qvalues->save();
						}
						$count_im=0;
					}
					else{
						$ass_test_impn=UlsAssessmentTest::assessment_test_vital($test_detail['test_id'],$count_imp_limit,$level_l2[$key],$key);
						foreach($ass_test_impn as $ass_test_impns){
							$test_qvalues=new UlsAssessmentTestQuestions();
							$test_qvalues->assess_test_id=$assess_test_id;
							$test_qvalues->test_quest_id=$ass_test_impns['test_quest_id'];
							$test_qvalues->test_id=$ass_test_impns['test_ids'];
							$test_qvalues->question_id=$ass_test_impns['question_id'];
							$test_qvalues->question_bank_id=$ass_test_impns['question_bank_id'];
							$test_qvalues->competency_id=$ass_test_impns['competency_id'];
							$test_qvalues->assessment_id=$ass_test_impns['assessment_id'];
							$test_qvalues->position_id=$ass_test_impns['position_id'];
							$test_qvalues->save();
						}
					}
					$k1++;
				}
				$c3=array();
				foreach($comp_l3 as $key=>$comp_impss){
					$comp_count=UlsAssessmentTest::assessment_test_count($test_detail['test_id'],$comp_impss);
					$c3[$comp_impss]=$comp_count['test_count'];
				}
				asort($c3);
				$k2=0;
				$count_im3=0;
				foreach($c3 as $key=>$comp_impss){
					if($count_imp_limil3>$comp_impss){
						$count_im3+=$count_imp_limil3-$comp_impss;
					}
					if((count($c3)-1)==$key){
						$ass_test_impl3=UlsAssessmentTest::assessment_test_vital($test_detail['test_id'],($count_imp_limil3+$count_imp_limit_mull3+$count_im3),$level_l3[$key],$key);
						foreach($ass_test_impl3 as $ass_test_impss){
							$test_qvalues=new UlsAssessmentTestQuestions();
							$test_qvalues->assess_test_id=$assess_test_id;
							$test_qvalues->test_quest_id=$ass_test_impss['test_quest_id'];
							$test_qvalues->test_id=$ass_test_impss['test_ids'];
							$test_qvalues->question_id=$ass_test_impss['question_id'];
							$test_qvalues->question_bank_id=$ass_test_impss['question_bank_id'];
							$test_qvalues->competency_id=$ass_test_impss['competency_id'];
							$test_qvalues->assessment_id=$ass_test_impss['assessment_id'];
							$test_qvalues->position_id=$ass_test_impss['position_id'];
							$test_qvalues->save();
						}
						$count_im3=0;
					}
					else{
						$ass_test_impn_l3=UlsAssessmentTest::assessment_test_vital($test_detail['test_id'],$count_imp_limil3,$level_l3[$key],$key);
						foreach($ass_test_impn_l3 as $ass_test_impnss){
							$test_qvalues=new UlsAssessmentTestQuestions();
							$test_qvalues->assess_test_id=$assess_test_id;
							$test_qvalues->test_quest_id=$ass_test_impnss['test_quest_id'];
							$test_qvalues->test_id=$ass_test_impnss['test_ids'];
							$test_qvalues->question_id=$ass_test_impnss['question_id'];
							$test_qvalues->question_bank_id=$ass_test_impnss['question_bank_id'];
							$test_qvalues->competency_id=$ass_test_impnss['competency_id'];
							$test_qvalues->assessment_id=$ass_test_impnss['assessment_id'];
							$test_qvalues->position_id=$ass_test_impnss['position_id'];
							$test_qvalues->save();
						}
					}
					$k2++;
				}
				$c4=array();
				foreach($comp_l4 as $key=>$comp_impsss){
					$comp_count=UlsAssessmentTest::assessment_test_count($test_detail['test_id'],$comp_impsss);
					$c4[$comp_impsss]=$comp_count['test_count'];
				}
				asort($c4);
				$count_im4=0;
				$k3=0;
				foreach($c4 as $key=>$comp_impsss){
					if($count_imp_limil4>$comp_impsss){
						$count_im4+=$count_imp_limil4-$comp_impsss;
					}
					if((count($c4)-1)==$k3){
						$ass_test_impl4=UlsAssessmentTest::assessment_test_vital($test_detail['test_id'],($count_imp_limil4+$count_imp_limit_mull4+$count_im4),$level_l4[$key],$key);
						foreach($ass_test_impl4 as $ass_test_impsss){
							$test_qvalues=new UlsAssessmentTestQuestions();
							$test_qvalues->assess_test_id=$assess_test_id;
							$test_qvalues->test_quest_id=$ass_test_impsss['test_quest_id'];
							$test_qvalues->test_id=$ass_test_impsss['test_ids'];
							$test_qvalues->question_id=$ass_test_impsss['question_id'];
							$test_qvalues->question_bank_id=$ass_test_impsss['question_bank_id'];
							$test_qvalues->competency_id=$ass_test_impsss['competency_id'];
							$test_qvalues->assessment_id=$ass_test_impsss['assessment_id'];
							$test_qvalues->position_id=$ass_test_impsss['position_id'];
							$test_qvalues->save();
						}
						$count_im4=0;
					}
					else{
						$ass_test_impn_l4=UlsAssessmentTest::assessment_test_vital($test_detail['test_id'],$count_imp_limil4,$level_l4[$key],$key);
						foreach($ass_test_impn_l4 as $ass_test_impnsss){
							$test_qvalues=new UlsAssessmentTestQuestions();
							$test_qvalues->assess_test_id=$assess_test_id;
							$test_qvalues->test_quest_id=$ass_test_impnsss['test_quest_id'];
							$test_qvalues->test_id=$ass_test_impnsss['test_ids'];
							$test_qvalues->question_id=$ass_test_impnsss['question_id'];
							$test_qvalues->question_bank_id=$ass_test_impnsss['question_bank_id'];
							$test_qvalues->competency_id=$ass_test_impnsss['competency_id'];
							$test_qvalues->assessment_id=$ass_test_impnsss['assessment_id'];
							$test_qvalues->position_id=$ass_test_impnsss['position_id'];
							$test_qvalues->save();
						}
					}
					$k3++;
				}
				$c5=array();
				foreach($comp_l5 as $key=>$comp_impssss){
					$comp_count=UlsAssessmentTest::assessment_test_count($test_detail['test_id'],$comp_impssss);
					$c5[$comp_impssss]=$comp_count['test_count'];
				}
				asort($c5);
				$count_im5=0;
				$k4=0;
				foreach($c5 as $key=>$comp_impssss){
					if($count_imp_limil5>$comp_impssss){
						$count_im5+=$count_imp_limil4-$comp_impssss;
					}
					if((count($c5)-1)==$k4){
						$ass_test_impl5=UlsAssessmentTest::assessment_test_vital($test_detail['test_id'],($count_imp_limil5+$count_imp_limit_mull5+$count_im5),$level_l5[$key],$key);
						foreach($ass_test_impl5 as $ass_test_impssss){
							$test_qvalues=new UlsAssessmentTestQuestions();
							$test_qvalues->assess_test_id=$assess_test_id;
							$test_qvalues->test_quest_id=$ass_test_impssss['test_quest_id'];
							$test_qvalues->test_id=$ass_test_impssss['test_ids'];
							$test_qvalues->question_id=$ass_test_impssss['question_id'];
							$test_qvalues->question_bank_id=$ass_test_impssss['question_bank_id'];
							$test_qvalues->competency_id=$ass_test_impssss['competency_id'];
							$test_qvalues->assessment_id=$ass_test_impssss['assessment_id'];
							$test_qvalues->position_id=$ass_test_impssss['position_id'];
							$test_qvalues->save();
						}
						$count_im5=0;
					}
					else{
						$ass_test_impn_l5=UlsAssessmentTest::assessment_test_vital($test_detail['test_id'],$count_imp_limil5,$level_l5[$key],$key);
						foreach($ass_test_impn_l5 as $ass_test_impnssss){
							$test_qvalues=new UlsAssessmentTestQuestions();
							$test_qvalues->assess_test_id=$assess_test_id;
							$test_qvalues->test_quest_id=$ass_test_impnssss['test_quest_id'];
							$test_qvalues->test_id=$ass_test_impnssss['test_ids'];
							$test_qvalues->question_id=$ass_test_impnssss['question_id'];
							$test_qvalues->question_bank_id=$ass_test_impnssss['question_bank_id'];
							$test_qvalues->competency_id=$ass_test_impnssss['competency_id'];
							$test_qvalues->assessment_id=$ass_test_impnssss['assessment_id'];
							$test_qvalues->position_id=$ass_test_impnssss['position_id'];
							$test_qvalues->save();
						}
					}
					$k4++;
				}
				//echo $c1."<br>".$L1;
			}
		$data['assess_test_id']=$assess_test_id;
		$content = $this->load->view('admin/ViewQuestions_assessment',$data,true);
		$this->render('layouts/ajax-layout',$content);
	} */
	
	public function questions_view_assessment()
	{
		$this->sessionexist();
		$assess_test_id=$_REQUEST['assess_test_id'];
		$update_user=Doctrine_Query::create()->update('UlsAssessmentTest');
		$update_user->set('generate_test','?','0');
		$update_user->where("assess_test_id=".$assess_test_id)->limit(1)->execute();
		$test_detail=UlsAssessmentTest::test_details($assess_test_id);
		$del=Doctrine_Query::Create()->Delete('UlsAssessmentTestQuestions')->where("assess_test_id=".$assess_test_id)->execute();
		if($test_detail['criticality']=='yes'){
			$position=UlsAssessmentCompetencies::getassessmentcompetencies_test($test_detail['assessment_id'],$test_detail['position_id'],$test_detail['assessment_type'],$test_detail['test_id']);
			foreach($position as $positions){
				$ass_test=UlsAssessmentTest::assessment_test_vital($test_detail['test_id'],$positions['assessment_que_count'],$positions['comp_position_level_scale_id'],$positions['assessment_scale_id'],$positions['comp_position_competency_id']);
				//$ass_test=UlsCompetencyTestQuestions::get_ass_test_question_id($test_detail['test_id']);
				foreach($ass_test as $ass_tests){
					$test_qvalues=new UlsAssessmentTestQuestions();
					$test_qvalues->assess_test_id=$assess_test_id;
					$test_qvalues->test_quest_id=$ass_tests['test_quest_id'];
					$test_qvalues->test_id=$ass_tests['test_ids'];
					$test_qvalues->question_id=$ass_tests['question_id'];
					$test_qvalues->question_bank_id=$ass_tests['question_bank_id'];
					$test_qvalues->competency_id=$ass_tests['competency_id'];
					$test_qvalues->assessment_id=$ass_tests['assessment_id'];
					$test_qvalues->position_id=$ass_tests['position_id'];
					$test_qvalues->save();
				}
			}
		}
		$data['assess_test_id']=$assess_test_id;
		$content = $this->load->view('admin/ViewQuestions_assessment',$data,true);
		$this->render('layouts/ajax-layout',$content);
	}


	public function questions_view_assessment_view(){
		$this->sessionexist();
		$data['assess_test_id']=filter_input(INPUT_GET,'assess_test_id') ? filter_input(INPUT_GET,'assess_test_id'):"";
		$content = $this->load->view('admin/ViewQuestions_assessment',$data,true);
		$this->render('layouts/ajax-layout',$content);
	}

	public function lms_position_submit(){
		if(isset($_POST['position_submit'])){
			$position_id=$_POST['position_id'];
			$test_id=$_POST['test_id'];
			$no_questions=$_POST['no_questions'];
			//$total_question=!empty($_POST['total_question'])?$_POST['total_question']:"";
			$vital_value =$_POST['C1'];
			$vital_value_per =$_POST['per_C1'];
			//$vital_final=round((($no_questions*$vital_value)/100),0);
			$vital_final=$vital_value;
			$imp_value = $_POST['C2'];
			$imp_value_per = $_POST['per_C2'];
			$imp_final=$imp_value;
			$imp_l3 = !empty($_POST['C3'])?$_POST['C3']:NULL;
			$imp_value_perl3 = !empty($_POST['per_C3'])?$_POST['per_C3']:NULL;
			$imp_l4 = !empty($_POST['C4'])?$_POST['C4']:NULL;
			$imp_value_perl4 = !empty($_POST['per_C4'])?$_POST['per_C4']:NULL;
			$imp_l5 = !empty($_POST['C5'])?$_POST['C5']:NULL;
			$imp_value_perl5 = !empty($_POST['per_C5'])?$_POST['per_C5']:NULL;
			//$imp_final=round((($no_questions*$imp_value)/100),0);
			$test_values=!empty($_POST['comp_test_id'])? Doctrine_Core::getTable('UlsAssessmentTest')->find($_POST['comp_test_id']):new UlsAssessmentTest();
			$test_values->assessment_pos_id=$_POST['assessment_pos_id'];
			$test_values->position_id=$_POST['position_id'];
            $test_values->assessment_id=$_POST['assessment_id'];
            $test_values->test_id=$test_id;
            $test_values->no_questions=$no_questions;
            $test_values->criticality=$_POST['criticality'];
			if($_POST['criticality']=='yes'){
				$test_values->c1=$vital_value;
				$test_values->c2=$imp_value;
				$test_values->c3=$imp_l3;
				$test_values->c4=$imp_l4;
				$test_values->c5=$imp_l5;
				$test_values->per_c1=$vital_value_per;
				$test_values->per_c2=$imp_value_per;
				$test_values->per_c3=$imp_value_perl3;
				$test_values->per_c4=$imp_value_perl4;
				$test_values->per_c5=$imp_value_perl5;
			}
			/* $test_values->level=$_POST['level'];
			if($_POST['level']=='yes'){
				$test_values->l1=$_POST['l1'];
				$test_values->l2=$_POST['l2'];
			} */
			$test_values->generate_test=1;
			$test_values->assessment_type=$_POST['assessment_type'];
			$test_values->time_details=$_POST['time'];
            $test_values->save();
			$position=UlsPosition::viewposition($_POST['position_id']);
			$this->session->set_flashdata('msg',"Assessement for ".$position['position_name']." has been created successfully.");
			$this->session->set_userdata('generatepdf',1);
			$this->session->set_userdata('assmethod',$_POST['assessment_type']);
			redirect('admin/assessment_details?tab=4&pos_id='.$_POST['position_id'].'&gen='.$_POST['assessment_type'].'&id='.$_POST['assessment_id'].'&pos_id='.$_POST['position_id'].'&hash='.md5(SECRET.$_POST['assessment_id']));
        }
	}
	
	public function lms_position_interviewsubmit(){
		if(isset($_POST['assessment_id'])){
			$test_values=!empty($_POST['comp_test_id'])? Doctrine_Core::getTable('UlsAssessmentTest')->find($_POST['comp_test_id']):new UlsAssessmentTest();
			$test_values->assessment_pos_id=$_POST['assessment_pos_id'];
			$test_values->position_id=$_POST['position_id'];
            $test_values->assessment_id=$_POST['assessment_id'];
			$test_values->rating_id=$_POST['rating_id'];
			$test_values->assessment_type=$_POST['assessment_type'];
			$test_values->time_details=$_POST['casestudy_time'];
            $test_values->save();
			$position=UlsPosition::viewposition($_POST['position_id']);
			$this->session->set_flashdata('msg',"Assessement for ".$position['position_name']." has been created successfully.");
			redirect('admin/assessment_details?tab=4&pos_id='.$_POST['position_id'].'&gen='.$_POST['assessment_type'].'&id='.$_POST['assessment_id'].'&pos_id='.$_POST['position_id'].'&hash='.md5(SECRET.$_POST['assessment_id']));
        }
	}
	
	public function self_assessment_competency_insert(){
		$this->sessionexist();
		if(isset($_POST['assessment_id'])){
			/* echo "<pre>";
			print_r($_POST); */
			foreach($_POST['check_position'] as $key=>$value){
				if(isset($value)){
					$val=$value;
					$work_activation=(!empty($_POST['self_ass_comp_id'][$val]))?Doctrine::getTable('UlsSelfAssessmentCompetencies')->find($_POST['self_ass_comp_id'][$val]):new UlsSelfAssessmentCompetencies;
					$work_activation->assessment_pos_com_id=$val;
					$work_activation->assessment_pos_level_id=$_POST['assessment_pos_level_id'][$val];
					$work_activation->assessment_pos_level_scale_id=$_POST['assessment_pos_level_scale_id'][$val];
					$work_activation->assessment_id=$_POST['assessment_id'];
					$work_activation->position_id=$_POST['position_id'];
					$work_activation->assessment_pos_id=$_POST['assessment_pos_id'][$key];
					$work_activation->save();
					
				}
			}
			
			$this->session->set_flashdata('assessment',"Assessment position information has been ".(!empty($_POST['assessment_id'])?"updated":"inserted")." successfully.");
			redirect('admin/self_assessment_details?tab=2&id='.$_POST['assessment_id'].'&hash='.md5(SECRET.$_POST['assessment_id']));
		}
	}
	

	public function assessment_competency_insert(){
		$this->sessionexist();
		if(isset($_POST['assessment_id'])){
			/* echo "<pre>";
			print_r($_POST); */
			if(!empty($_POST['check_position'])){
			foreach($_POST['check_position'] as $key=>$value){
				if(isset($value)){
					$val=$value;
					$work_activation=(!empty($_POST['assessment_pos_comp_id'][$val]))?Doctrine::getTable('UlsAssessmentCompetencies')->find($_POST['assessment_pos_comp_id'][$val]):new UlsAssessmentCompetencies;
					$work_activation->assessment_pos_com_id=$val;
					$work_activation->assessment_pos_level_id=$_POST['assessment_pos_level_id'][$val];
					$work_activation->assessment_pos_level_scale_id=$_POST['assessment_pos_level_scale_id'][$val];
					$work_activation->assessment_scale_id=!empty($_POST['assessment_scale_id'][$val])?$_POST['assessment_scale_id'][$val]:NULL;
					$work_activation->assessment_type=is_array($_POST['assessment_type'][$val])?implode(",",$_POST['assessment_type'][$val]):NULL;
					$work_activation->assessment_id=$_POST['assessment_id'];
					$work_activation->position_id=$_POST['position_id'];
					$work_activation->assessment_pos_id=$_POST['assessment_pos_id'][$key];
					$work_activation->assessment_que_count=$_POST['assessment_que_count'][$key];
					$work_activation->pos_com_weightage=$_POST['pos_com_weightage'][$key];
					$work_activation->save();
					if(!empty($_POST['assessment_type'][$val])){
						 if(in_array('TEST',$_POST['assessment_type'][$val])){
							//echo "<br>comptency_id-".$value;
							$code='COMP_TEST';
							$test=UlsPosition::viewposition($_POST['position_id']);
							$test_name="Test-".$test['position_name']."-".$_POST['assessment_id']."-".$code;
							$test_detail=UlsCompetencyTest::get_test_detail_name($test_name);
							$question_insert=!empty($test_detail['test_id'])? Doctrine_Core::getTable('UlsCompetencyTest')->find($test_detail['test_id']):new UlsCompetencyTest();
							$question_insert->test_code='TECC';
							$question_insert->test_name=$test_name;
							$question_insert->rating_scale_id=NULL;
							$question_insert->test_type_flag=$code;
							$question_insert->description=NULL;
							$question_insert->active_flag='P';
							$question_insert->assessment_id=$_POST['assessment_id'];
							$question_insert->position_id=$_POST['position_id'];
							$question_insert->save();
							$question_bank=UlsCompetencyDefQueBank::getcompdefquesbank_ass($val,$code);
							foreach($question_bank as $question_banks){
								$question=UlsQuestionbank::get_questions_data_levels($question_banks['question_bank_id'],$work_activation->assessment_pos_level_scale_id,$work_activation->assessment_scale_id,$work_activation->assessment_que_count);
								foreach($question as $questions){
									$comp_select=Doctrine_Query::create()->from('UlsCompetencyTestQuestions')->where("question_id=".$questions['id']." and test_id=".$question_insert->test_id)->execute();
									foreach($comp_select as $comp_selects){
										$del_ass=Doctrine_Query::create()->delete('UlsAssessmentTestQuestions')->where("test_quest_id=".$comp_selects['test_quest_id'])->execute();
									}
									$del=Doctrine_Query::create()->delete('UlsCompetencyTestQuestions')->where("question_id=".$questions['id']." and test_id=".$question_insert->test_id)->execute();
									$sd=Doctrine_Core::getTable('UlsCompetencyTestQuestions')->findOneByTestIdAndQuestionId($question_insert->test_id,$questions['id']);
									if(empty($sd)){
										$question_values=new UlsCompetencyTestQuestions();
										$question_values->test_id=$question_insert->test_id;
										$question_values->question_id=$questions['id'];
										$question_values->question_bank_id=$question_banks['question_bank_id'];
										$question_values->competency_id=$question_banks['comp_def_id'];
										$question_values->save();
									}
								}
							}
						}
					} 	
					if(!empty($_POST['assessment_type'][$val])){
						if(in_array('INTERVIEW',$_POST['assessment_type'][$val])){
							//echo "<br>comptency_id-".$value;
							$code_interview='COMP_INTERVIEW';
							$test=UlsPosition::viewposition($_POST['position_id']);
							$test_name="Test-".$test['position_name']."-".$_POST['assessment_id']."-".$code_interview;
							$test_detail=UlsCompetencyTest::get_test_detail_name($test_name);
							$question_insert=!empty($test_detail['test_id'])? Doctrine_Core::getTable('UlsCompetencyTest')->find($test_detail['test_id']):new UlsCompetencyTest();
							$question_insert->test_code='TECC';
							$question_insert->test_name=$test_name;
							$question_insert->rating_scale_id=NULL;
							$question_insert->test_type_flag=$code_interview;
							$question_insert->description=NULL;
							$question_insert->active_flag='P';
							$question_insert->assessment_id=$_POST['assessment_id'];
							$question_insert->position_id=$_POST['position_id'];
							$question_insert->save();
							$question_bank=UlsCompetencyDefIntQuestion::getcompdefinterview_ass($val,$code_interview);
							foreach($question_bank as $question_banks){
								$question=UlsQuestionbank::get_questions_data_levels($question_banks['question_bank_id'],$work_activation->assessment_pos_level_scale_id);
								foreach($question as $questions){
									$comp_select=Doctrine_Query::create()->from('UlsCompetencyTestQuestions')->where("question_id=".$questions['id']." and test_id=".$question_insert->test_id)->execute();
									foreach($comp_select as $comp_selects){
										$del_ass=Doctrine_Query::create()->delete('UlsAssessmentTestQuestions')->where("test_quest_id=".$comp_selects['test_quest_id'])->execute();
									}
									$del=Doctrine_Query::create()->delete('UlsCompetencyTestQuestions')->where("question_id=".$questions['id']." and test_id=".$question_insert->test_id)->execute();
									$sd=Doctrine_Core::getTable('UlsCompetencyTestQuestions')->findOneByTestIdAndQuestionId($question_insert->test_id,$questions['id']);
									if(empty($sd)){
										$question_values=new UlsCompetencyTestQuestions();
										$question_values->test_id=$question_insert->test_id;
										$question_values->question_id=$questions['id'];
										$question_values->question_bank_id=$question_banks['question_bank_id'];
										$question_values->competency_id=$question_banks['comp_def_id'];
										$question_values->save();
									}
								}
							}
						}
					}
					/* if(!empty($_POST['assessment_type'][$val])){
						if(in_array('INBASKET',$_POST['assessment_type'][$val])){
							
							$question_bank=UlsInbasketCompetencies::getinbusketcompetencies_ass($val,$work_activation->assessment_pos_level_scale_id);
							foreach($question_bank as $question_banks){
								if(!empty($question_banks['inbasket_element_name']) && !empty($question_banks['inbasket_scale']) && !empty($question_banks['inbasket_competencies'])){
									$question=UlsQuestionbank::get_questions_data_level_comp($question_banks['inbasket_element_name'],$question_banks['inbasket_scale'],$question_banks['inbasket_competencies']);
									foreach($question as $key=>$questions){
										$code_inbasket='COMP_INBASKET';
										$test=UlsPosition::viewposition($_POST['position_id']);
										$test_name="Test-".$test['position_name']."-".$_POST['assessment_id']."-".$code_inbasket."-".$question_banks['inbasket_competencies'];
										$test_detail=UlsCompetencyTest::get_test_detail_name($test_name);
										$question_insert=!empty($test_detail['test_id'])? Doctrine_Core::getTable('UlsCompetencyTest')->find($test_detail['test_id']):new UlsCompetencyTest();
										$question_insert->test_code='TECC';
										$question_insert->test_name=$test_name;
										$question_insert->inbasket_id=$question_banks['inbasket_id'];
										$question_insert->rating_scale_id=NULL;
										$question_insert->test_type_flag=$code_inbasket;
										$question_insert->description=NULL;
										$question_insert->active_flag='P';
										$question_insert->assessment_id=$_POST['assessment_id'];
										$question_insert->position_id=$_POST['position_id'];
										$question_insert->save();
										$del=Doctrine_Query::create()->delete('UlsCompetencyTestQuestions')->where("question_id=".$questions['id']." and test_id=".$question_insert->test_id)->execute();
										$sd=Doctrine_Core::getTable('UlsCompetencyTestQuestions')->findOneByTestIdAndQuestionId($question_insert->test_id,$questions['id']);
										if(empty($sd)){
											$question_values=new UlsCompetencyTestQuestions();
											$question_values->test_id=$question_insert->test_id;
											$question_values->question_id=$questions['id'];
											$question_values->question_bank_id=$question_banks['inbasket_element_name'];
											$question_values->competency_id=$question_banks['inbasket_competencies'];
											$question_values->save();
										}
									}
								}									
							}
						}
					}
					if(!empty($_POST['assessment_type'][$val])){
						if(in_array('CASE_STUDY',$_POST['assessment_type'][$val])){
							$question_bank_casestudy=UlsCaseStudyCompetencies::getcasestudycompetencies_ass($val,$work_activation->assessment_pos_level_scale_id);
							foreach($question_bank_casestudy as $question_case_banks){
								if(!empty($question_case_banks['casestudy_quest']) && !empty($question_case_banks['casestudy_scale']) && !empty($question_case_banks['casestudy_competencies'])){
									$question=UlsQuestionbank::get_questions_data_level_comp($question_case_banks['casestudy_quest'],$question_case_banks['casestudy_scale'],$question_case_banks['casestudy_competencies']);
									foreach($question as $key=>$questions){
										$code_casestudy='COMP_CASESTUDY';
										$test=UlsPosition::viewposition($_POST['position_id']);
										$test_name="Test-".$test['position_name']."-".$_POST['assessment_id']."-".$code_casestudy."-".$question_case_banks['casestudy_competencies'];
										$test_detail=UlsCompetencyTest::get_test_detail_name($test_name);
										$question_insert=!empty($test_detail['test_id'])? Doctrine_Core::getTable('UlsCompetencyTest')->find($test_detail['test_id']):new UlsCompetencyTest();
										$question_insert->test_code='TECC';
										$question_insert->test_name=$test_name;
										$question_insert->casestudy_id=$question_case_banks['casestudy_id'];
										$question_insert->rating_scale_id=NULL;
										$question_insert->test_type_flag=$code_casestudy;
										$question_insert->description=NULL;
										$question_insert->active_flag='P';
										$question_insert->assessment_id=$_POST['assessment_id'];
										$question_insert->position_id=$_POST['position_id'];
										$question_insert->save();
										$del=Doctrine_Query::create()->delete('UlsCompetencyTestQuestions')->where("question_id=".$questions['id']." and test_id=".$question_insert->test_id)->execute();
										$sd=Doctrine_Core::getTable('UlsCompetencyTestQuestions')->findOneByTestIdAndQuestionId($question_insert->test_id,$questions['id']);
										if(empty($sd)){
											$question_values=new UlsCompetencyTestQuestions();
											$question_values->test_id=$question_insert->test_id;
											$question_values->question_id=$questions['id'];
											$question_values->question_bank_id=$question_case_banks['casestudy_quest'];
											$question_values->competency_id=$question_case_banks['casestudy_competencies'];
											$question_values->save();
										}
									}
								}									
							}
						}
					} */	
					
					/* if(!empty($_POST['assessment_type'][$val])){
						if(in_array('CASE_STUDY',$_POST['assessment_type'][$val])){
							$code_casestudy='COMP_CASESTUDY';
							$test=UlsPosition::viewposition($_POST['position_id']);
							$test_name="Test-".$test['position_name']."-".$_POST['assessment_id']."-".$code_casestudy;
							$test_detail=UlsCompetencyTest::get_test_detail_name($test_name);
							$question_insert=!empty($test_detail['test_id'])? Doctrine_Core::getTable('UlsCompetencyTest')->find($test_detail['test_id']):new UlsCompetencyTest();
							$question_insert->test_code='TECC';
							$question_insert->test_name=$test_name;
							$question_insert->rating_scale_id=NULL;
							$question_insert->test_type_flag=$code_casestudy;
							$question_insert->description=NULL;
							$question_insert->active_flag='P';
							$question_insert->assessment_id=$_POST['assessment_id'];
							$question_insert->position_id=$_POST['position_id'];
							$question_insert->save();
							$question_bank=UlsCaseStudyCompetencies::getcasestudycompetencies_ass($val,$work_activation->assessment_pos_level_scale_id);
							foreach($question_bank as $question_banks){
								//echo $question_banks['casestudy_quest'];
								$question=UlsQuestionbank::get_questions_data_levels($question_banks['casestudy_quest'],$question_banks['casestudy_scale']);
								foreach($question as $questions){
									$del=Doctrine_Query::create()->delete('UlsAssessmentTestQuestions')->where("test_quest_id=".$questions['id']." and test_id=".$question_insert->test_id)->execute();
									$del=Doctrine_Query::create()->delete('UlsCompetencyTestQuestions')->where("question_id=".$questions['id']." and test_id=".$question_insert->test_id)->execute();
									$sd=Doctrine_Core::getTable('UlsCompetencyTestQuestions')->findOneByTestIdAndQuestionId($question_insert->test_id,$questions['id']);
									if(!isset($sd->test_id)){
										$question_values=new UlsCompetencyTestQuestions();
										$question_values->test_id=$question_insert->test_id;
										$question_values->question_id=$questions['id'];
										$question_values->question_bank_id=$question_banks['casestudy_quest'];
										$question_values->competency_id=$question_banks['casestudy_competencies'];
										$question_values->save();
									}
								}
							}
						}
					} */	
				}
			}
			}
			
			foreach($_POST['assessment_type_weight'] as $key_t=>$type){
				if(!empty($type)){
					if(!empty($_POST['weightage'][$key_t])){
						$work=(!empty($_POST['assessment_pos_weightage_id'][$key_t]))?Doctrine::getTable('UlsAssessmentCompetenciesWeightage')->find($_POST['assessment_pos_weightage_id'][$key_t]):new UlsAssessmentCompetenciesWeightage;
						$work->assessment_type=$_POST['assessment_type_weight'][$key_t];
						$work->weightage=!empty($_POST['weightage'][$key_t])?$_POST['weightage'][$key_t]:'0';
						$work->assessment_id=$_POST['assessment_id'];
						$work->position_id=$_POST['position_id'];
						$work->assessment_pos_id=!empty($work_activation->assessment_pos_id)?$work_activation->assessment_pos_id:$_POST['assessment_pos_id'][$key_t];
						$work->save();
					}
				}
			}
			$this->session->set_flashdata('assessment',"Assessment position information has been ".(!empty($_POST['assessment_id'])?"updated":"inserted")." successfully.");
			redirect('admin/assessment_details?tab=4&pos_id='.$_POST['position_id'].'&id='.$_POST['assessment_id'].'&hash='.md5(SECRET.$_POST['assessment_id']));
		}
	}
	
	public function assessment_position_setting_insert(){
		$this->sessionexist();
		if(isset($_POST['assessment_id'])){
			foreach($_POST['assess_test_id'] as $key=>$value){
				if(isset($value)){
					$val=$value;
					$emp_update=Doctrine_Query::Create()->update('UlsAssessmentTest');
					$emp_update->set('ass_start_date','?',$_POST['ass_start_date'][$val]);
					$emp_update->set('ass_end_date','?',$_POST['ass_end_date'][$val]);
					$emp_update->set('lang_process','?',$_POST['lang_process'][$val]);
					$emp_update->set('int_que_count','?',!empty($_POST['int_que_count'][$val])?$_POST['int_que_count'][$val]:0);
					$emp_update->where('assess_test_id=?',$_POST['assess_test_id'][$key]);
					$emp_update->execute();
				}
			}
			redirect('admin/assessment_details?tab=7&pos_id='.$_POST['position_id'].'&id='.$_POST['assessment_id'].'&hash='.md5(SECRET.$_POST['assessment_id']));
		}
	}
	
	public function assessment_competency_tna_insert(){
		$this->sessionexist();
		if(isset($_POST['assessment_id'])){
			foreach($_POST['assessment_pos_comp_id'] as $key=>$value){
				if(isset($value)){
					$val=$value;
					$emp_update=Doctrine_Query::Create()->update('UlsAssessmentCompetencies');
					$emp_update->set('comp_per','?',$_POST['comp_per'][$val]);
					$emp_update->where('assessment_pos_comp_id=?',$_POST['assessment_pos_comp_id'][$key]);
					$emp_update->execute();
				}
			}
			redirect('admin/assessment_details?tab=5&pos_id='.$_POST['position_id'].'&id='.$_POST['assessment_id'].'&hash='.md5(SECRET.$_POST['assessment_id']));
		}
	}
	
	public function assessment_competency_weightage_insert(){
		$this->sessionexist();
		if(isset($_POST['assessment_id'])){
			foreach($_POST['assessment_pos_comp_id'] as $key=>$value){
				if(isset($value)){
					$val=$value;
					$emp_update=Doctrine_Query::Create()->update('UlsAssessmentCompetencies');
					$emp_update->set('pos_com_weightage','?',$_POST['pos_com_weightage'][$val]);
					$emp_update->where('assessment_pos_comp_id=?',$_POST['assessment_pos_comp_id'][$key]);
					$emp_update->execute();
				}
			}
			redirect('admin/assessment_details?tab=1&pos_id='.$_POST['position_id'].'&id='.$_POST['assessment_id'].'&hash='.md5(SECRET.$_POST['assessment_id']));
		}
	}
	
	public function assessment_employee_tna_insert(){
		$this->sessionexist();
		if(isset($_POST['assessment_id'])){
			foreach($_POST['assessment_pos_emp_id'] as $key=>$value){
				if(isset($value)){
					$val=$value;
					$emp_update=Doctrine_Query::Create()->update('UlsAssessmentEmployees');
					$emp_update->set('tna_status','?',$_POST['tna_status'][$val]);
					$emp_update->set('tna_date','?',date("Y-m-d"));
					$emp_update->where('assessment_pos_emp_id=?',$_POST['assessment_pos_emp_id'][$key]);
					$emp_update->execute();
				}
			}
			redirect('admin/assessment_details?tab=6&pos_id='.$_POST['position_id'].'&id='.$_POST['assessment_id'].'&hash='.md5(SECRET.$_POST['assessment_id']));
		}
	}

	public function assessment_assessor_insert(){
        $this->sessionexist();
        if(isset($_POST['assessment_id_assessor_id'])){

			foreach($_POST['checkbox_assessor'] as $key_t=>$type){
				if(!empty($type)){
					$work=(!empty($_POST['assessment_pos_assessor_id'][$key_t]))?Doctrine::getTable('UlsAssessmentPositionAssessor')->find($_POST['assessment_pos_assessor_id'][$key_t]):new UlsAssessmentPositionAssessor;
					$work->assessor_id=$_POST['assessor_id'][$key_t];
					$work->assessment_id=$_POST['assessment_id_assessor_id'];
					$work->position_id=$_POST['position_id_assessor_id'];
					$work->save();
				}
			}
			$this->session->set_flashdata('assessment',"Assessment master data ".(!empty($_POST['assessment_id_assessor_id'])?"updated":"inserted")." successfully.");
            redirect('admin/assessment_details?tab=4&id='.$_POST['assessment_id_assessor_id'].'&hash='.md5(SECRET.$_POST['assessment_id_assessor_id']));
        }
        else{
			$content = $this->load->view('admin/assessment_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }

	public function assessment_assessor_insert_single(){
        $this->sessionexist();
        if(isset($_POST['emp_no_assessor'])){
			$ass_details=UlsAssessorMaster::viewassessor($_POST['emp_no_assessor']);
			$fieldinsertupdates=array('assessment_id'=>'assessment_id_assessor', 'position_id'=>'position_id_assessor', 'assessor_id'=>'emp_no_assessor','emp_display'=>'emp_display','assessor_val'=>'assessor_val','assessor_per'=>'assessor_per');
            $enroll=(!empty($_POST['assessment_pos_assessor_id']))?Doctrine_Core::getTable('UlsAssessmentPositionAssessor')->find($_POST['assessment_pos_assessor_id']): new UlsAssessmentPositionAssessor();
            foreach($fieldinsertupdates as $key=>$post_enroll){
				$enroll->$key=(!empty($_POST[$post_enroll]))?$_POST[$post_enroll]:Null;
			}
			$enroll->assessor_type=$ass_details['assessor_type'];
            $enroll->save();
			$this->session->set_flashdata('assessment',"Assessment master data ".(!empty($_POST['assessment_id_assessor'])?"updated":"inserted")." successfully.");
			redirect('admin/assessment_details?tab=3&pos_id='.$enroll->position_id.'&id='.$enroll->assessment_id.'&hash='.md5(SECRET.$enroll->assessment_id));
            //redirect('admin/assessment_details?tab=3&id='.$enroll->assessment_id.'&hash='.md5(SECRET.$enroll->assessment_id)); 
        }
        else{
			$content = $this->load->view('admin/assessment_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }

	public function self_assessment_employee_insert(){
        $this->sessionexist();
        if(isset($_POST['single_save']) || isset($_POST['bulk_save'])){
			if(isset($_POST['single_save'])){
			$pos_details=Doctrine::getTable('UlsAssessmentPosition')->findOneByAssessmentIdAndPositionId($_POST['assessment_id'],$_POST['position_id']);
			$fieldinsertupdates=array('assessment_id'=>'assessment_id', 'position_id'=>'position_id', 'employee_id'=>'emp_no');
            $enroll=(!empty($_POST['self_ass_pos_emp_id']))?Doctrine_Core::getTable('UlsSelfAssessmentEmployees')->find($_POST['self_ass_pos_emp_id']): new UlsSelfAssessmentEmployees();
            foreach($fieldinsertupdates as $key=>$post_enroll){
				$enroll->$key=(!empty($_POST[$post_enroll]))?$_POST[$post_enroll]:Null;
			}
            $enroll->save();
			$ass_journing=UlsAssessmentEmployeeJourney::get_assessment_employees($enroll->assessment_id,$enroll->position_id,$enroll->employee_id);
			$enroll_journing=(!empty($ass_journing['id']))?Doctrine_Core::getTable('UlsAssessmentEmployeeJourney')->find($ass_journing['id']): new UlsAssessmentEmployeeJourney();
			$enroll_journing->assessment_type='IDPPROcess';
			$enroll_journing->assessment_id=$enroll->assessment_id;
			$enroll_journing->position_id=$enroll->position_id;
			$enroll_journing->employee_id=$enroll->employee_id;
            $enroll_journing->save();
			$emp_sup=UlsEmployeeMaster::fetch_tna_emp($enroll->employee_id);
			if(!empty($emp_sup['supervisor_id'])){
				$ass_journing=UlsAssessmentEmployeeJourney::get_assessment_employees($_POST['assessment_id'],$_POST['position_id'],$emp_sup['supervisor_id']);
				$enroll_journing=(!empty($ass_journing['id']))?Doctrine_Core::getTable('UlsAssessmentEmployeeJourney')->find($ass_journing['id']): new UlsAssessmentEmployeeJourney();
				$enroll_journing->assessment_type='IDPPROcess';
				$enroll_journing->assessment_id=$enroll->assessment_id;
				$enroll_journing->position_id=$enroll->position_id;
				$enroll_journing->employee_id=$emp_sup['supervisor_id'];
				$enroll_journing->save();
			}
			$employee=UlsMenu::callpdorow("select * from employee_data where employee_id=".$enroll->employee_id);
			$position=UlsMenu::callpdorow("select * from uls_position where position_id=".$enroll->position_id);
			$path="public/uploads/assessments/".$enroll->assessment_id."/".$position['position_name']."/".$employee['employee_number'];
			if(!is_dir($path)){
				mkdir($path,0777);
			}
			}
			if(isset($_POST['bulk_save'])){
				foreach($_POST['employee_number'] as $key=>$value){
					$pos_details=Doctrine::getTable('UlsAssessmentPosition')->findOneByAssessmentIdAndPositionId($_POST['assessment_id'],$_POST['position_id']);
					$enroll_details=(!empty($_POST['self_ass_pos_emp_id']))?Doctrine_Core::getTable('UlsSelfAssessmentEmployees')->find($_POST['self_ass_pos_emp_id']): new UlsSelfAssessmentEmployees();
					//$enroll_details=new  UlsProgramEnrollment;
					$enroll_details->assessment_id=$_POST['assessment_id'];
					$enroll_details->employee_id=$_POST['emp_id'][$key];
					$enroll_details->position_id=$_POST['position_id'];
					$enroll_details->assessment_pos_id=$pos_details->assessment_pos_id;
					$enroll_details->save();
					$ass_journing=UlsAssessmentEmployeeJourney::get_assessment_employees($enroll_details->assessment_id,$enroll_details->position_id,$enroll_details->employee_id);
					$enroll_journing=(!empty($ass_journing['id']))?Doctrine_Core::getTable('UlsAssessmentEmployeeJourney')->find($ass_journing['id']): new UlsAssessmentEmployeeJourney();
					$enroll_journing->assessment_type='IDPPROcess';
					$enroll_journing->assessment_id=$enroll_details->assessment_id;
					$enroll_journing->position_id=$enroll_details->position_id;
					$enroll_journing->employee_id=$enroll_details->employee_id;
					$enroll_journing->save();
					$emp_sup=UlsEmployeeMaster::fetch_tna_emp($enroll_details->employee_id);
					if(!empty($emp_sup['supervisor_id'])){
						$ass_journing=UlsAssessmentEmployeeJourney::get_assessment_employees($enroll_details->assessment_id,$enroll_details->position_id,$emp_sup['supervisor_id']);
						$enroll_journing=(!empty($ass_journing['id']))?Doctrine_Core::getTable('UlsAssessmentEmployeeJourney')->find($ass_journing['id']): new UlsAssessmentEmployeeJourney();
						$enroll_journing->assessment_type='IDPPROcess';
						$enroll_journing->assessment_id=$enroll_details->assessment_id;
						$enroll_journing->position_id=$enroll_details->position_id;
						$enroll_journing->employee_id=$enroll_details['supervisor_id'];
						$enroll_journing->save();
					}
					$employee=UlsMenu::callpdorow("select * from employee_data where employee_id=".$enroll_details->employee_id);
					$position=UlsMenu::callpdorow("select * from uls_position where position_id=".$enroll_details->position_id);
					$path="public/uploads/assessments/".$enroll_details->assessment_id."/".$position['position_name']."/".$employee['employee_number'];
					if(!is_dir($path)){
						mkdir($path,0777);
					}
				}
			}
			$this->session->set_flashdata('assessment',"Assessment master data ".(!empty($_POST['assessment_id'])?"updated":"inserted")." successfully.");
            redirect('admin/self_assessment_details?tab=2&id='.$_POST['assessment_id'].'&hash='.md5(SECRET.$_POST['assessment_id']));
        }
        else{
			$content = $this->load->view('admin/assessment_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }
	
	public function assessment_employee_insert(){
        $this->sessionexist();
        if(isset($_POST['single_save']) || isset($_POST['bulk_save']) || isset($_POST['feed_bulk_save'])){
			if(isset($_POST['single_save'])){
			$pos_details=Doctrine::getTable('UlsAssessmentPosition')->findOneByAssessmentIdAndPositionId($_POST['assessment_id'],$_POST['position_id']);
			$emp_info=UlsEmployeeMaster::getempdetails($_POST['emp_no']);
			$fieldinsertupdates=array('assessment_id'=>'assessment_id', 'position_id'=>'position_id', 'employee_id'=>'emp_no');
            $enroll=(!empty($_POST['assessment_pos_emp_id']))?Doctrine_Core::getTable('UlsAssessmentEmployees')->find($_POST['assessment_pos_emp_id']): new UlsAssessmentEmployees();
            foreach($fieldinsertupdates as $key=>$post_enroll){
				$enroll->$key=(!empty($_POST[$post_enroll]))?$_POST[$post_enroll]:Null;
			}
			$enroll->assessment_pos_id=$pos_details->assessment_pos_id;
			$enroll->bu_id=$emp_info['bu_id'];
			$enroll->org_id=$emp_info['org_id'];
			$enroll->grade_id=$emp_info['grade_id'];
			$enroll->location_id=$emp_info['location_id'];
            $enroll->save();
			$ass_journing=UlsAssessmentEmployeeJourney::get_assessment_employees($_POST['assessment_id'],$_POST['position_id'],$enroll->employee_id);
			$enroll_journing=(!empty($ass_journing['id']))?Doctrine_Core::getTable('UlsAssessmentEmployeeJourney')->find($ass_journing['id']): new UlsAssessmentEmployeeJourney();
			$enroll_journing->assessment_type='Assessment';
			$enroll_journing->assessment_id=$enroll->assessment_id;
			$enroll_journing->position_id=$enroll->position_id;
			$enroll_journing->employee_id=$enroll->employee_id;
            $enroll_journing->save();
			$employee=UlsMenu::callpdorow("select * from employee_data where employee_id=".$enroll->employee_id);
			$position=UlsMenu::callpdorow("select * from uls_position where position_id=".$enroll->position_id);
			$path="public/uploads/assessments/".$enroll->assessment_id."/".$position['position_name']."/".$employee['employee_number'];
			if(!is_dir($path)){
				mkdir($path,0777);
			}
			}
			if(isset($_POST['bulk_save'])){
				foreach($_POST['employee_number'] as $key=>$value){
					$pos_details=Doctrine::getTable('UlsAssessmentPosition')->findOneByAssessmentIdAndPositionId($_POST['assessment_id'],$_POST['position_id']);
					$emp_info=UlsEmployeeMaster::getempdetails($_POST['emp_id'][$key]);
					$enroll_details=(!empty($_POST['assessment_pos_emp_id']))?Doctrine_Core::getTable('UlsAssessmentEmployees')->find($_POST['assessment_pos_emp_id']): new UlsAssessmentEmployees();
					//$enroll_details=new  UlsProgramEnrollment;
					$enroll_details->assessment_id=$_POST['assessment_id'];
					$enroll_details->employee_id=$_POST['emp_id'][$key];
					$enroll_details->position_id=$_POST['position_id'];
					$enroll_details->bu_id=$emp_info['bu_id'];
					$enroll_details->org_id=$emp_info['org_id'];
					$enroll_details->grade_id=$emp_info['grade_id'];
					$enroll_details->location_id=$emp_info['location_id'];
					$enroll_details->assessment_pos_id=$pos_details->assessment_pos_id;
					$enroll_details->save();
					
					$ass_journing=UlsAssessmentEmployeeJourney::get_assessment_employees($_POST['assessment_id'],$_POST['position_id'],$enroll_details->employee_id);
					$enroll_journing=(!empty($ass_journing['id']))?Doctrine_Core::getTable('UlsAssessmentEmployeeJourney')->find($ass_journing['id']): new UlsAssessmentEmployeeJourney();
					$enroll_journing->assessment_type='Assessment';
					$enroll_journing->assessment_id=$enroll_details->assessment_id;
					$enroll_journing->position_id=$enroll_details->position_id;
					$enroll_journing->employee_id=$enroll_details->employee_id;
					$enroll_journing->save();
					
					/* $employee=UlsMenu::callpdorow("select * from employee_data where employee_id=".$enroll_details->employee_id);
					$position=UlsMenu::callpdorow("select * from uls_position where position_id=".$enroll_details->position_id);
					$pos_name=str_replace(array("/"," - ","-"),array("_","_","_"),$position['position_name']);
					$path1="public/uploads/assessments/".$enroll_details->assessment_id;
					$path2="public/uploads/assessments/".$enroll_details->assessment_id."/".$pos_name;
					$path3="public/uploads/assessments/".$enroll_details->assessment_id."/".$pos_name."/".$employee['employee_number'];
					if(!is_dir($path1)){
						mkdir($path1,0777);
						chmod($path1,0777);
					}
					if(!is_dir($path2)){
						mkdir($path2,0777);
						chmod($path2,0777);
					}
					if(!is_dir($path3)){
						mkdir($path3,0777);
						chmod($path3,0777);
					} */
				}
			}
			if(isset($_POST['feed_bulk_save'])){
				$gggroup=0;
				foreach($_POST['employee_number'] as $key=>$value){
					if(!empty($value)){
						$checkuser=UlsEmployeeMaster::fetch_emp_tna(trim($value));
						$optuser=$checkuser['employee_id'];
						$manager=$peer=$sub=$intcust=$cust=array();
						foreach($_POST['giver_empcode_'.$key ] as $k=>$v){
							if(!empty($v)){
								$checkgiver=UlsEmployeeMaster::fetch_emp_tna(trim($v));
								$giveruser=$checkgiver['employee_id'];
								if(!in_array($giveruser,$manager) && !in_array($giveruser,$peer)&& !in_array($giveruser,$sub)&& !in_array($giveruser,$intcust)&& !in_array($giveruser,$cust)){
									if($_POST['giver_emptype_'.$key][$k]=="manager"){ $manager[]=$giveruser;}
									if($_POST['giver_emptype_'.$key][$k]=="peer"){ $peer[]=$giveruser;}
									if($_POST['giver_emptype_'.$key][$k]=="sub"){ $sub[]=$giveruser;}
									if($_POST['giver_emptype_'.$key][$k]=="internal"){ $intcust[]=$giveruser;}
									if($_POST['giver_emptype_'.$key][$k]=="customer"){ $cust[]=$giveruser;}
								}
							}
						}
						$checkgroup=UlsAssessmentFeedEmployees::getfeed_assessment($_POST['assessment_id'],$_POST['position_id'],trim($optuser));
						if(!isset($checkgroup['group_id'])){
							$feed=UlsAssessmentTestFeedback::getfeedback_assessment($_POST['assessment_id'],$_POST['position_id']);
							$newugrouping=new UlsAssessmentFeedEmployees();
							$newugrouping->assessment_id=$_POST['assessment_id'];
							$newugrouping->position_id=$_POST['position_id'];
							$newugrouping->assessment_type=$feed['assessment_type'];
							$newugrouping->employee_id=$optuser;
							count($manager)>0?$newugrouping->manager_id=@implode(",",$manager):"";
							count($peer)>0?$newugrouping->peer_id=@implode(",",$peer):"";
							count($sub)>0?$newugrouping->sub_ordinates_id=@implode(",",$sub):"";
							//count($cust)>0?$newugrouping->customer_id=@implode(",",$cust):"";
							count($intcust)>0?$newugrouping->customer_id=@implode(",",$intcust):"";
							$newugrouping->feed_assess_test_id=$feed['feed_assess_test_id'];
							$newugrouping->ques_id=$feed['ques_id'];			
							$newugrouping->save();
							$gggroup++;
						}
					}
				}
			}
			$this->session->set_flashdata('assessment',"Assessment master data ".(!empty($_POST['assessment_id'])?"updated":"inserted")." successfully.");
            redirect('admin/assessment_details?tab=3&pos_id='.$_POST['position_id'].'&id='.$_POST['assessment_id'].'&hash='.md5(SECRET.$_POST['assessment_id']));
        }
        else{
			$content = $this->load->view('admin/assessment_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }

	public function assessment_view(){
		$data["aboutpage"]=$this->pagedetails('admin','assessment_view');
		$id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
		$hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
		$flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
		if($flag==1 || $id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$compdetails=UlsAssessmentDefinition::viewassessment($id);
			$data['compdetails']=$compdetails;
			$data['positions']=UlsAssessmentPosition::getassessmentpositions($compdetails['assessment_id']);
			$data['competencies']=UlsAssessmentCompetencies::getassessmentcompetencies($compdetails['assessment_id']);
			$data['employees']=UlsAssessmentEmployees::getassessmentemployees($compdetails['assessment_id']);
			$data['assessors']=UlsAssessmentPositionAssessor::getassessmentassessors($compdetails['assessment_id']);
			
			$content = $this->load->view('admin/assessment_view',$data,true);
		}
		$this->render('layouts/adminnew',$content);
	}

	public function deleteassessment(){
		$id=trim($_REQUEST['val']);
		if(!empty($id) && is_numeric($id)){
			 $uewi=Doctrine_Query::create()->from('UlsAssessmentPosition')->where('assessment_id='.$id)->execute();
			$uewi2=Doctrine_Query::create()->from('UlsAssessmentCompetencies')->where('assessment_id='.$id)->execute();
			if(count($uewi)==0 && count($uewi2)==0){
				$q = Doctrine_Query::create()->delete('UlsAssessmentDefinition')->where('assessment_id=?',$id)->execute();
				echo 1;
			}
			else{
				echo "Selected Assessment cannot be deleted. This particular Assessment has been used in transaction table.";
			}
		}
	}

	public function assessment_position_creation()
	{
		$data=array();
		$content = $this->load->view('admin/assessment_position_creation',$data,true);
		$this->render('layouts/adminnew',$content);
	}

	public function assessment_positions()
	{
		$data=array();
		$content = $this->load->view('admin/assessment_positions',$data,true);
		$this->render('layouts/adminnew',$content);
	}

	public function assessment_add_employees()
	{
		$data=array();
		$content = $this->load->view('admin/assessment_add_employees',$data,true);
		$this->render('layouts/adminnew',$content);
	}

	public function assessment_add_assessor()
	{
		$data=array();
		$content = $this->load->view('admin/assessment_add_assessor',$data,true);
		$this->render('layouts/adminnew',$content);
	}

	public function assessment_test()
	{
		$data=array();
		$content = $this->load->view('admin/assessment_test',$data,true);
		$this->render('layouts/adminnew',$content);
	}

	public function assessment_case_study()
	{
		$data=array();
		$content = $this->load->view('admin/assessment_case_study',$data,true);
		$this->render('layouts/adminnew',$content);
	}

	public function assessment_interview()
	{
		$data=array();
		$content = $this->load->view('admin/assessment_interview',$data,true);
		$this->render('layouts/adminnew',$content);
	}

	public function assessment_inbasket()
	{
		$data=array();
		$content = $this->load->view('admin/assessment_inbasket',$data,true);
		$this->render('layouts/adminnew',$content);
	}

	public function change_subcat(){
		$id=$_REQUEST['id'];
		$data="";
		if(!empty($id)){
			$cat=UlsCategory::get_subcat_name($id);
			$data="
			<select name='scale_id' id='scale_id' class='form-control m-b'>
				<option value=''>Select</option>";
				foreach($cat as $cats){
				$data.="<option value='".$cats['category_id']."'>".$cats['name']."</option>";
				}
			$data.="</select>";
		}
		else{
			$data.="<select name='scale_id' id='scale_id' class='form-control m-b'><option value=''>Select</option></select>";
		}
		echo $data;
	}
	
	public function change_addcat(){
		$id=$_REQUEST['id'];
		$data="";
		if(!empty($id)){
			$cat=UlsCategory::get_subcat_name($id);
			$data.="<option value=''>Select</option>";
			foreach($cat as $cats){
				$data.="<option value='".$cats['category_id']."'>".$cats['name']."</option>";
			}
		}
		else{
			$data.="<option value=''>Select</option>";
		}
		echo $data;
	}

	/* public function change_level_scale(){
		$id=$_REQUEST['id'];
		$data="";
		if(!empty($id)){
			$scale=UlsLevelMasterScale::levelscale($id);
			$data="<div class='hpanel hblue'>
				<div class='panel-heading hbuilt'>
					Assessment Methods for levels
				</div>

				<div class='panel-body'>
					<p class='text-muted'>
						<div class='row'>";
							foreach($scale as $scales){
								$data.="<div class='col-md-3 border-right'> <div class='contact-stat'><label> <input type='checkbox' name='comp_def_level_ind_id[]' id='comp_def_level_ind_id[]' value='".$scales['scale_id']."'> ".$scales['scale_name']."</label></div></div>";
							}
						$data.="</div>
					</p>
					<table class='table'>
						<thead>
						<tr>
							<td>
								Assessment Methods
							</td>
						</tr>
						</thead>
						<tbody>";
						$ass_methods=UlsAdminMaster::get_value_names("ASSESS_METHOD");
						foreach($ass_methods as $ass_method){
						$data.="<tr>
							<td>
								<div class='col-md-4'><input type='checkbox' name='comp_def_assess_type[]'  id='	comp_def_assess_type[]' onchange='open_method(\"".$ass_method['code']."\")' value='".$ass_method['code']."'> ".$ass_method['name']."</div>
								<div class='col-md-4' id='sub_assessment_".$ass_method['code']."'></div>
							</td>
						</tr>";
						}
						$data.="</tbody>
					</table>
				</div>";
		}
		else{
			$data.="<select name='scale_id' id='scale_id' class='form-control m-b'><option value=''>Select</option></select>";
		}
		echo $data;
	}
	*/
	public function change_ass_sub(){
		$id=$_REQUEST['id'];
		$data="";
		if(!empty($id)){
			$master_values=UlsAdminMaster::get_value_names($id);
			foreach($master_values as $master_value){
				$data.="<label class='checkbox-inline'> <input value='".$master_value['name']."' id='comp_def_assess_type_sub[]' name='comp_def_assess_type_sub[]' type='radio'>".$master_value['name']." </label>";
			}
		}
		else{
			$data.="";
		}
		echo $data;
	}

	public function change_level_casestudy(){
		$id=$_REQUEST['comp_id'];
		$row=$_REQUEST['row'];
		$data="";
		if(!empty($id)){
			$comp_defs=UlsCompetencyDefinition::viewcompetency($id);
			$data="<select name='casestudy_level[]' id='casestudy_level".$row."' class='form-control m-b' onchange='open_scale(".$row.");'>
			<option value=''>Select</option>
			<option value='".$comp_defs['comp_def_level']."'>".$comp_defs['level']."</option>
			</select>";
		}
		else{
			$data.="<select name='casestudy_level[]' id='casestudy_level".$row."' class='form-control m-b' onchange='open_scale(".$row.");'>
				<option value=''>Select</option>
			</select>";
		}
		echo $data;
	}
	
	public function change_level_casestudy_edit(){
		$id=$_REQUEST['comp_id'];
		$row=$_REQUEST['row'];
		$data="";
		if(!empty($id)){
			$comp_defs=UlsCompetencyDefinition::viewcompetency($id);
			$data="<select name='casestudy_level[]' id='casestudy_level_".$row."' class='form-control m-b' onchange='open_scale(".$row.");'>
			<option value=''>Select</option>
			<option value='".$comp_defs['comp_def_level']."'>".$comp_defs['level']."</option>
			</select>";
		}
		else{
			$data.="<select name='casestudy_level[]' id='casestudy_level_".$row."' class='form-control m-b' onchange='open_scale(".$row.");'>
				<option value=''>Select</option>
			</select>";
		}
		echo $data;
	}




	public function change_scale_casestudy(){
		$id=$_REQUEST['level_id'];
		$row=$_REQUEST['row'];
		$data="";
		if(!empty($id)){
			$comp_level_scale=UlsLevelMasterScale::levelscale($id);
			$data="<select name='casestudy_scale[]' id='casestudy_scale".$row."' class='form-control m-b'>
				<option value=''>Select</option>";
				foreach($comp_level_scale as $comp_level_scales){
					$data.="<option value='".$comp_level_scales['scale_id']."'>".$comp_level_scales['scale_name']."</option>";
				}
			$data.="</select>";
		}
		else{
			$data.="<select name='casestudy_scale[]' id='casestudy_scale".$row."' class='form-control m-b'>
				<option value=''>Select</option>
			</select>";
		}
		echo $data;
	}
	
	public function change_scale_casestudy_edit(){
		$id=$_REQUEST['level_id'];
		$row=$_REQUEST['row'];
		$data="";
		if(!empty($id)){
			$comp_level_scale=UlsLevelMasterScale::levelscale($id);
			$data="<select name='casestudy_scale[]' id='casestudy_scale_".$row."' class='form-control m-b'>
				<option value=''>Select</option>";
				foreach($comp_level_scale as $comp_level_scales){
					$data.="<option value='".$comp_level_scales['scale_id']."'>".$comp_level_scales['scale_name']."</option>";
				}
			$data.="</select>";
		}
		else{
			$data.="<select name='casestudy_scale[]' id='casestudy_scale_".$row."' class='form-control m-b'>
				<option value=''>Select</option>
			</select>";
		}
		echo $data;
	}

	public function change_level_inbasket(){
		$id=$_REQUEST['comp_id'];
		$row=$_REQUEST['row'];
		$data="";
		if(!empty($id)){
			$comp_defs=UlsCompetencyDefinition::viewcompetency($id);
			$level_scale=UlsLevelMasterScale::levelscale($comp_defs['comp_def_level']);
			$data.="
			<select name='inbasket_scale[]' id='inbasket_scale".$row."' class='form-control m-b' >
			<option value=''>Select</option>";
			foreach($level_scale as $level_scales){
				$data.="<option value='".$level_scales['scale_id']."'>".$level_scales['scale_name']."</option>";
			}
			$data.="</select><input type='hidden' name='inbasket_levels[]' id='inbasket_levels' value='".$comp_defs['comp_def_level']."'>";
		}
		echo $data;
	}

	public function change_scale_inbasket(){
		$id=$_REQUEST['level_id'];
		$row=$_REQUEST['row'];
		$data="";
		if(!empty($id)){
			$comp_level_scale=UlsLevelMasterScale::levelscale($id);
			$data="<select name='inbasket_scale[]' id='inbasket_scale".$row."' class='form-control m-b'>
				<option value=''>Select</option>";
				foreach($comp_level_scale as $comp_level_scales){
					$data.="<option value='".$comp_level_scales['scale_id']."'>".$comp_level_scales['scale_name']."</option>";
				}
			$data.="</select>";
		}
		else{
			$data.="<select name='inbasket_scale[]' id='inbasket_scale".$row."' class='form-control m-b'>
				<option value=''>Select</option>
			</select>";
		}
		echo $data;
	}

	public function fetch_emp_data_id(){
        $empnum=$_REQUEST['empnum'];
		if(!empty($empnum)){
			$empdata=UlsEmployeeMaster::get_empdetails_id($empnum);
			if(isset($empdata['empid'])){
				echo $empdata['empid']."@".trim($empdata['name'])."@".trim($empdata['email'])."@".trim($empdata['office_number']);
			}
		}
    }

	//Function to check whether an employee has user or not in resource definition
	public function checkUser(){
		$user=UlsUserCreation::checkUser();
		if(count($user)>0){
			$dat="";
			foreach($user as $key=>$user_type){
				$stdate=(!empty($user_type['start_date']))?date('d-m-Y',strtotime($user_type['start_date'])):'';
				$enddate=(!empty($user_type['end_date']))?date('d-m-Y',strtotime($user_type['end_date'])):'';
				$sd=(!empty($user_type['sd']))?date('d-m-Y',strtotime($user_type['sd'])):'';
				$ed=(!empty($user_type['ed']))?date('d-m-Y',strtotime($user_type['ed'])):'';
				if($user_type['system_menu_type']=='asr'){
					$dat="asr";
					$sdt=",".$sd.",".$ed;
					$da=$user_type['menu_id']."_"."<option value=".$user_type['rid'].">".$user_type['rname']."</option>";
				}else{
					if($key==0){
						$data=$user_type['user_id'].",".$stdate.",".$enddate.",,#$";
						$role=UlsRoleCreation::assessorRoles();
						if(!empty($role)){
							$data.=$role['menu_id']."_"."<option value=".$role['role_id'].">".$role['role_name']."</option>";
							/* foreach($role as $tra_role){
								$data.="<option value=".$tra_role['role_id'].">".$tra_role['role_name']."</option>";
							} */
						}
					}
				}
			}
			if($dat=='asr'){
				$data=$user_type['user_id'].",".$stdate.",".$enddate.$sdt."#$".$da;
			}
			echo $data;
		}else{
			echo "0#$";
		}
	}

	//Function to check whether trainer role exists for the parent org id in resource definition
	public function checkRoleAsr(){
		$user=UlsUserCreation::checkAssRole();
		if(!empty($user)){
			echo $user['menu_id']."&*<option value=".$user['role_id'].">".$user['role_name']."</option>";
		}else{echo 0;}
	}

	public function change_level_assessor(){
		$id=$_REQUEST['comp_id'];
		$row=$_REQUEST['row'];
		$data="";
		if(!empty($id)){
			$comp_defs=UlsCompetencyDefinition::viewcompetency($id);
			$data="<select name='assessor_levels[]' id='assessor_levels".$row."' class='form-control m-b' onchange='open_scale(".$row.");'>
			<option value=''>Select</option>
			<option value='".$comp_defs['comp_def_level']."'>".$comp_defs['level']."</option>
			</select>";
		}
		else{
			$data.="<select name='assessor_levels[]' id='assessor_levels".$row."' class='form-control m-b' onchange='open_scale(".$row.");'>
				<option value=''>Select</option>
			</select>";
		}
		echo $data;
	}

	public function change_scale_assessor(){
		$id=$_REQUEST['level_id'];
		$row=$_REQUEST['row'];
		$data="";
		if(!empty($id)){
			$comp_level_scale=UlsLevelMasterScale::levelscale($id);
			$data="<select name='assessor_scale[]' id='assessor_scale".$row."' class='form-control m-b'>
				<option value=''>Select</option>";
				foreach($comp_level_scale as $comp_level_scales){
					$data.="<option value='".$comp_level_scales['scale_id']."'>".$comp_level_scales['scale_name']."</option>";
				}
			$data.="</select>";
		}
		else{
			$data.="<select name='assessor_scale[]' id='assessor_scale".$row."' class='form-control m-b'>
				<option value=''>Select</option>
			</select>";
		}
		echo $data;
	}

	public function ass_select_weightage(){
		$ass_test=array();
		$select_ass=array();
		$id=$_REQUEST['id'];
		$aid=$_REQUEST['a_id'];
		if(!empty($id)){
			$test=explode(",",$id);
			foreach($test as $tests){
				if(!in_array($tests,$ass_test)){
					$ass_test[]=$tests;
				}
			}
			//print_r($ass_test);
			$data="";
			$data.="<div class='panel-heading hbuilt'>
					You have selected he following competencies ( C1 / C2 / C3) for assessment and provide the weightages
				</div>
				<div class='table-responsive'>
					<table cellpadding='1' cellspacing='1' class='table table-bordered table-striped'>

						<tbody>";
						$select_weight="";
						$weight=UlsAssessmentCompetenciesWeightage::getassessmentcompetencies_weightage($aid);
						if(!empty($weight)){
							foreach($weight as $weights){
								$key=$weights['assessment_pos_weightage_id'];
								$value=$weights['assessment_type'];
								$weightage=$weights['weightage'];
								$select_ass[$key]=$value;
								$select_weight[]=$weightage;
							}
						}
						//print_r($select_weight);
						$ass_methods=UlsAdminMaster::get_value_names("ASSESS_METHOD");
						foreach($ass_methods as $key_m=>$ass_method){
							if(in_array($ass_method['code'],$ass_test)){
								$val=array_search($ass_method['code'],$select_ass);
							$data.="<tr>
								<td>
								<input type='hidden' name='assessment_pos_weightage_id[]' id='assessment_pos_weightage_id[]' value='".$val."'>
								<input type='hidden' name='assessment_type_weight[]' id='assessment_type[]' value='".$ass_method['code']."'>
								".$ass_method['name']."</td>
								<td><input type='text' name='weightage[]' id='weightage[]' class='form-control' value='".$select_weight[$key_m]."'></td>
							</tr>";
							}
						}
						$data.="</tbody>
					</table>
				</div>";
			echo $data;
		}
	}

	public function fetch_emp_data_id_assessment(){
        $empnum=$_REQUEST['empnum'];
        $assessment_id=$_REQUEST['assessment_id'];
		$position_id=$_REQUEST['position_id'];
		$type=$_REQUEST['type'];
		if($type=='full'){
        $checkenrlvalid=UlsAssessmentEmployees::getassessmentemployees_position($empnum,$assessment_id,$position_id);
		}else{
        $checkenrlvalid=UlsSelfAssessmentEmployees::getassessmentemployees_position($empnum,$assessment_id,$position_id);
		}
		if(count($checkenrlvalid)>0){
		echo "0@Employee has already been enrolled on this event duration for another event";
		}else{
			if(!empty($empnum)){
				$empdata=UlsEmployeeMaster::get_empdetails_id($empnum);

				if(isset($empdata['empid'])){
						echo $empdata['empid']."@".trim($empdata['name'])."@".trim($empdata['org_name'])."@".trim($empdata['depart_name'])."@".trim($empdata['position_name']);
				}
			}
		}

    }

	public function assessor_autoemployee(){
		if(isset($_POST['data']['q'])){$id=$_POST['data']['q'];}
		$hodquery="select assessor_id,assessor_name from uls_assessor_master where parent_org_id='".$_SESSION['parent_org_id']."' and assessor_name like '%$id%'  order by assessor_name limit 10";
		$hodrow=UlsMenu::callpdo($hodquery);
		$results=array();
		foreach($hodrow as $val){
			$results[] = array('id' => $val['assessor_id'], 'text' => $val['assessor_name']);
		}
		if(isset($_POST['data']['q'])){echo json_encode(array('q' => $id, 'results' => $results));}
		else{echo json_encode($results);} 
	}

	public function fetch_emp_data_id_assessor(){
        $empnum=$_REQUEST['empnum'];
        $ass_id=$_REQUEST['ass_id'];
		$pos_id=$_REQUEST['pos_id'];
        $checkenrlvalid_ass=UlsAssessmentPositionAssessor::getassessmentassessors_position($empnum,$ass_id,$pos_id);
		if(count($checkenrlvalid_ass)>0){
		echo "0%Employee has already been added as assessor for this assessment";
		}else{
			if(!empty($empnum)){
				$empdata_ass=UlsAssessmentPositionAssessor::assessor_details($empnum);
				if(!empty($empdata_ass['assessor_id'])){
					echo $empdata_ass['assessor_id']."%".$empdata_ass['assessor_name']."%".$empdata_ass['assessor_email']."%".$empdata_ass['assessor_mobile']."%".$empdata_ass['assessor_type'];
				}
			}
		}
    }
	
	public function delete_employee(){
		$code=$_REQUEST['val'];
		 if(!empty($code)){
			 $emp11 = Doctrine_Query::create()->from('UlsAssessmentEmployees')->where('employee_id=?',$code)->execute();
			 if(count($emp11)>0){
					echo "Selected Employee cannot be deleted. This particular Employee has been used in transaction table.";
			 }
			 else{
			 $emp = Doctrine::getTable('UlsUserCreation')->findOneByEmployeeId($code);
				$empdata_role = Doctrine_Query::create()->delete('UlsUserRole')->where('user_id=?',$emp->user_id)->execute();
				$empdata = Doctrine_Query::create()->delete('UlsUserCreation')->where('employee_id=?',$code)->execute();
				$empdat = Doctrine_Query::create()->delete('UlsEmployeeWorkInfo')->where('employee_id=?',$code)->execute();
				$empdata1 = Doctrine_Query::create()->delete('UlsEmployeeMaster')->where('employee_id=?',$code)->execute();			
				echo 1;
			 }         
		 }        
    }
	
	public function deleteOrganization(){
		$code=$_REQUEST['val'];
		 if(!empty($code)){         
			$org1 = Doctrine_Query::create()->from('UlsEmployeeWorkInfo')->where('org_id=?',$code)->execute();
			$org2 = Doctrine_Query::create()->from('UlsPosition')->where('position_org_id=?',$code)->execute();
			$org3 = Doctrine_Query::create()->from('UlsPosition')->where('bu_id=?',$code)->execute();
			$org4 = Doctrine_Query::create()->from('UlsSecurityOrg')->where('organization_id=?',$code)->execute();
			if(count($org1)>0 || count($org2)>0 || count($org3)>0 || count($org4)>0){
				echo "Selected Organization cannot be deleted. This particular Organization has been used in transaction table.";
				
			}
			else{
				$organization = Doctrine_Query::create()->delete('UlsOrganizationMaster')->where('organization_id=?',$code)->execute();			
				echo 1;
			}         
		 }        
    }
	
	public function hierarchy_master(){
        $data["aboutpage"]=$this->pagedetails('admin','hierarchymaster');
		$limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE; 
		$hierarchy=filter_input(INPUT_GET,'hierarchy') ? filter_input(INPUT_GET,'hierarchy'):"";
		$page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
		$start=$page!=0? ($page-1)*$limit:0;	
		$filePath=BASE_URL."/admin/hierarchy_master";
		$data['limit']=$limit;
        $data['perpages']=UlsMenuCreation::perpage();
		$data['hierarchy']=$hierarchy;
		$data['masterlists']=UlsHeirarchyMaster::search($hierarchy, $start, $limit);
		$total=UlsHeirarchyMaster::searchcount($hierarchy);
		$otherParams="&perpage=".$limit."hierarchy=$hierarchy";
		$data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/hierarchy_master',$data,true);
		$this->render('layouts/adminnew',$content);
    }
	
	public function org_hierarchy(){
        $data["aboutpage"]=$this->pagedetails('admin','hierarchymaster');
		$data['last_hiername']=UlsOrganizationHeirarchy::last_hierarchy_name();
		$data['last_details']=UlsOrganizationHeirarchy::last_hierarchy_details();
		$data['orgnz_data']=UlsOrganizationMaster::org_data();
		$data['po_orgnz']=UlsOrganizationMaster::sess_parent_orgs();
		$data['all_orgnz']=UlsOrganizationMaster::org_details_names();
		
		$content = $this->load->view('admin/lms_admin_org_hierarchy',$data,true);
		$this->render('layouts/adminnew',$content);
    }
	
	 public function heirarchy_details(){
        if(isset($_POST['heirarchy_name'])){
			$datefield_val=array('start_date', 'end_date');
            $hierarchy=(!empty($_POST['hierarchy_id']))?Doctrine::getTable('UlsHeirarchyMaster')->find($_POST['hierarchy_id']): new UlsHeirarchyMaster();
            $hierarchy->hierarchy_name=$_POST['heirarchy_name'];
			foreach($datefield_val as $datefield){
				$hierarchy->$datefield=(!empty($_POST[$datefield]))?date('Y-m-d',strtotime($_POST[$datefield])):NULL;
			}
			$hierarchy->save();
			$heirar=$hierarchy->hierarchy_id;
			foreach($_POST['org_list'] as $key=>$child_org_id){
				$details=(!empty($_POST['id'][$key]))?Doctrine::getTable('UlsOrganizationHeirarchy')->find($_POST['id'][$key]): new UlsOrganizationHeirarchy();
				$details->hierarchy_id=$heirar;
				$details->parent_org_id=$_POST['parent_org_name'];
				$details->child_org_id=$child_org_id;
				$details->save();
				$id=$details->id;
				$parentid=$details->parent_org_id;								
			}
			//$_SESSION['hierarchy']=$id;
			//$_SESSION['last_parent_org_id']=$parentid;
			$aaa='admin/org_hierarchy?hier_id='.$heirar.'&parentid='.$parentid;
			$this->session->set_flashdata('msg',"Organization Hierarchy data ".(!empty($_POST['hierarchy_id'])?"updated":"inserted")." successfully.");
        }
		else{
			$aaa='admin/hierarchy_master';
		}        
        redirect($aaa);
    }
	
	public function org_type(){
        $org_id=$_REQUEST['orgid'];
        $org_values=UlsOrganizationMaster::orgtypes($org_id);
        foreach($org_values as $org_value){
			echo $org_value['value_name'];
        }
    }
	
	public function hierarchy_child_orgs(){
		$hierarchyid=$_REQUEST['heirarchyid'];
		$child_id=$_REQUEST['parentorgid'];
		$allorgids=Doctrine_Query::create()->from('UlsOrganizationHeirarchy')->where("hierarchy_id=".$hierarchyid." and parent_org_id!=".$child_id)->execute();
		$org_id_exist=array();
		foreach($allorgids as $allorgids1){
			echo $org_id_exist[]=$allorgids1->child_org_id;				
		}
		$orgdetails=UlsOrganizationMaster::org_data();
		foreach($orgdetails as $keyy=>$orgdetailss){
			if($orgdetailss->org_type!='PO'){
				if(!in_array($orgdetailss->orgid,$org_id_exist)){
					echo "<option value=".$orgdetailss->orgid.">".$orgdetailss->orgname."</option>";  
				}
			}
		}
	}
	
	public function delete_hierarchy(){
		$code=$_REQUEST['val'];
		if(!empty($code)){
			$hierarchy5 = Doctrine_Query::create()->from('UlsRoleCreation')->where('hierarchy_id=?',$code)->execute();
			if(count($hierarchy5)==0){
				$hierarchy_data = Doctrine_Query::create()->delete('UlsOrganizationHeirarchy')->where('hierarchy_id=?',$code)->execute();
				$hierarchy = Doctrine_Query::create()->delete('UlsHeirarchyMaster')->where('hierarchy_id=?',$code)->execute();			
				echo 1;
			} 
			else{
				echo "Selected Hierarchy cannot be deleted. Ensure you delete all the usages of the Hierarchy before you delete it.";
			}
		}        
	}
	
	public function delete_hierarchy_orgid(){
		$code=$_REQUEST['hierid'];
		$orgid=$_REQUEST['orgid'];
		if(!empty($code)){         
			$hierarchy1 = Doctrine_Query::create()->from('UlsLearnerAccess')->where('org_structure_id=?',$code)->execute();
			$hierarchy2 = Doctrine_Query::create()->from('UlsLnrGroupDetails')->where('org_hier_id=?',$code)->execute();
			$hierarchy5 = Doctrine_Query::create()->from('UlsRoleCreation')->where('hierarchy_id=?',$code)->execute();
			if(count($hierarchy1)>0 || count($hierarchy2)>0  || count($hierarchy5)>0){
				echo "Selected Hierarchy cannot be deleted.This particular Hierarchy has been used in transaction table.";
			}
			else{
				$hierarchy_data = Doctrine_Query::create()->delete('UlsOrganizationHeirarchy')->where('id=?',$orgid)->execute();
				//$hierarchy = Doctrine_Query::create()->delete('UlsHeirarchyMaster')->where('hierarchy_id=?',$code)->execute();			
				echo 1;
			}         
		}        
	}
	
	 public function change_parentorg(){		
        $child_id=$_REQUEST['childid'];
        $hierarchyid=$_REQUEST['hie_id'];
        $parent_select='';
        $parent_select="<input type='hidden' name='hierarchy_id' id='hierarchy_id' value=".$hierarchyid."><select name='parent_org_name' id='parent_org_name' style='width:250px;' onchange='getchildorgs()' class='chosen-select validate[required] form-control m-b'>";
        
		$allorgids=Doctrine_Query::create()->from('UlsOrganizationHeirarchy')->where("hierarchy_id=".$hierarchyid." and parent_org_id=".$child_id)->execute();
		$org_id_exist=array();
		foreach($allorgids as $allorgids1){
			//if($org_id_exist==''){
				$org_id_exist[]=$allorgids1->child_org_id;
			// }else{
				// $org_id_exist[]=$org_id_exist.",".$allorgids1->parent_org_id.",".$allorgids1->child_org_id;
			// }				
		}
		//print_r($org_id_exist);
		
		if(!empty($child_id)){
            $heimas=Doctrine::getTable('UlsHeirarchyMaster')->findOneByHierarchy_idAndParent_org_id($hierarchyid,$_SESSION['parent_org_id']);
            $org_values=Doctrine_Query::create()->from('UlsOrganizationMaster')->where("organization_id=".$child_id)->execute();
            foreach($org_values as $org_value){
				$childids=($org_value['organization_id']==$child_id)?"selected='selected'":'';
				$parent_select.="<option value=".$org_value['organization_id']." ".$childids.">".$org_value['org_name']."</option>";                
            }
            $parent_select.="</select>@_";			
            $org=Doctrine_Query::create()->from('UlsOrganizationHeirarchy')->where("parent_org_id=".$child_id." and hierarchy_id=".$hierarchyid."")->execute();
            $parent_select.="<table id='org_data' class='table table-striped table-bordered table-hover' style='width: 1022px;'><tbody>";
            if(count($org)>0){
                $val=array();
                foreach($org as $key=>$org1){
					//echo $org1->child_org_id;
                    $val[]=$key;
                    $parent_select.="<tr id='hier_row_".$key."'><td style='padding-left:15px; width: 55px;'><input type='hidden' name='id[]' id='id' value=".$org1->id."><input type='checkbox' name='hier_chk_[]' id='hier_chk_".$key."' value=".$key."></td><td style='width: 315px;'><select name='org_list[]' id='org_list[".$key."]' style='width:250px;' onchange='getOrg_type(".$key.")' class='chosen-select form-control m-b'><option value=''>Select</option>";
                    $supchild=Doctrine::getTable('UlsOrganizationHeirarchy')->findOneByHierarchy_idAndChild_org_id($hierarchyid,$child_id);
                    $subchild=Doctrine_Query::create()->from('UlsOrganizationMaster')->where("parent_org_id=".$_SESSION['parent_org_id']." and org_type!='PO'")->execute();
                    foreach($subchild as $keyy=>$subchild1){
						if(in_array($subchild1->organization_id,$org_id_exist)){
							$orgselect=($subchild1->organization_id==$org1->child_org_id)?"selected='selected'":'';
							$parent_select.="<option value=".$subchild1->organization_id." ".$orgselect.">".$subchild1->org_name."</option>";  
						}
					}
                    $parent_select.="</td><td style='width:208px;'><div id='input_type[".$key."]'>";
                    $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
                    $query = "select om.org_type, mv.* from uls_organization_master om, uls_admin_values mv where om.organization_id=".$org1->child_org_id." and om.org_type=mv.value_code";
                    $org_val = $pdo->prepare($query);
                    $org_val->execute();
                    $org_values=$org_val->fetchAll();
                    foreach($org_values as $org_values1){
                        $parent_select.="<label>".$org_values1['value_name']."</label>";
                    }
                    $parent_select.="</div></td><td style='width:65px;'><p align='center'><img id='select_child[".$key."]' src='".BASE_URL."/public/images/up_arrow.png' onclick='Ajax_upgrade_child(".$key.")' style='cursor:pointer;'/></p></td></tr>";
                }
                $parent_select.="<input type='hidden' name='last_parent_id' value=".$heimas->parent_org_id." ><input type='hidden' name='last_id' value=".$org1->id." >";
                $values=implode(",",$val);
            }
            else{
                $parent_select.="<tr id='hier_row_0'><td style='padding-left:15px; width: 55px;'><input type='hidden' name='id[]' id='id[0]' value=''><input type='checkbox' name='hier_chk_[]' id='hier_chk_0' value='0'></td><td  style='width: 315px;'><select name='org_list[]' id='org_list[0]' style='width:250px;' onchange='getOrg_type(0)' class='chosen-select form-control m-b'><option value=''>Select</option>";
                $supchild=Doctrine::getTable('UlsOrganizationHeirarchy')->findOneByHierarchy_idAndChild_org_id($hierarchyid,$child_id);
                
				if(!empty($supchild)){
                    $subchild=Doctrine_Query::create()->from('UlsOrganizationMaster')->where("parent_org_id=".$_SESSION['parent_org_id']." and org_type!='PO'")->execute();
                    foreach($subchild as $subchild1){
						if(!in_array($subchild1->organization_id,$org_id_exist)){
							$parent_select.="<option value=".$subchild1->organization_id.">".$subchild1->org_name."</option>";
						}
					}					
                }
                $parent_select.="</select></td><td style='width:208px;'><div id='input_type[0]'></div></td><td style='width:65px;'><p align='center'><img id='select_child[0]' src='".BASE_URL."/public/images/up_arrow.png' onclick='Ajax_upgrade_child(0)' style='cursor:pointer;'/></p></td></tr>";
                $values=0;
            }
            $parent_select.="<input type='hidden' name='inner_hidden_id' id='inner_hidden_id' value=\"$values\"></table>@_";
        }
        echo $parent_select;
    }
	
	public function get_childorg(){
        $parentid=$_REQUEST['parentid'];
        $hierarchy=$_REQUEST['heirarchyid'];
        $parent_select='';
        $heimas=Doctrine::getTable('UlsHeirarchyMaster')->findOneByHierarchy_idAndParent_org_id($hierarchy,$_SESSION['parent_org_id']);
        $hiermas_id=$heimas->hierarchy_id;
        $parent_select="<input type='hidden' name='hierarchy_id' id='hierarchy_id' value=".$hierarchy."><input type='hidden' name='unique_id' id='unique_id' value='".$hierarchy."'><select name='parent_org_name' id='parent_org_name' style='width:250px;' onchange='getchildorgs()' class='chosen-select validate[required] form-control m-b'>";
        $supparent1=Doctrine::getTable('UlsOrganizationHeirarchy')->findOneByChild_org_idAndHierarchy_id($parentid,$hiermas_id);
        if(!empty($supparent1)){
            $sup=Doctrine_Query::create()->from('UlsOrganizationMaster')->where("organization_id=".$supparent1->parent_org_id)->execute();
        }
        else{
            $main=Doctrine::getTable('UlsHeirarchyMaster')->findOneByHierarchy_idAndParent_org_id($hierarchy,$_SESSION['parent_org_id']);
            $sup=Doctrine_Query::create()->from('UlsOrganizationMaster')->where("organization_id=".$main->parent_org_id)->execute();
        }
        foreach($sup as $sup1){
            $parent_select.="<option value=".$sup1->organization_id." selected>".$sup1->org_name."</option>";
        }
        $parent_select.="</select>@_";
        $paren=Doctrine::getTable('UlsOrganizationHeirarchy')->findOneByChild_org_idAndHierarchy_id($parentid,$hierarchy);
        if(!empty($paren)){
            $parent=Doctrine::getTable('UlsOrganizationHeirarchy')->findByParent_org_idAndHierarchy_id($paren->parent_org_id,$hiermas_id);
        }
        else{
            $main=Doctrine::getTable('UlsHeirarchyMaster')->findOneByHierarchy_idAndParent_org_id($hierarchy,$_SESSION['parent_org_id']);
            $parent=Doctrine::getTable('UlsOrganizationHeirarchy')->findByParent_org_idAndHierarchy_id($main->parent_org_id,$hiermas_id);
        }
		
		
        if(count($parent)>0){
            $parent_select.="<table id='org_data' class='table table-striped table-bordered table-hover' style='width: 1022px;'><tbody>";
            $val=array();
            foreach($parent as $key=>$parent1){
                $val[]=$key;
                $parent_select.="<tr id='hier_row_".$key."'><td style='padding-left:15px; width: 55px;'><input type='hidden' name='id[]' id='id[".$key."]' value='".$parent1->id."'><input type='checkbox' name='hier_chk_[]' id='hier_chk_".$key."' value=".$key."></td><td style='width:315px;'><select name='org_list[]' id='org_list[".$key."]' style='width:250px;' onchange='getOrg_type(".$key.")' class='chosen-select form-control m-b'><option value=''>Select</option>";
                $subchild=Doctrine_Query::create()->from('UlsOrganizationMaster')->where("parent_org_id=".$_SESSION['parent_org_id']." and org_type!='PO'")->execute();
                foreach($subchild as $subchild1){
                    $orgselect=($subchild1->organization_id==$parent1->child_org_id)?"selected='selected'":'';
                    $parent_select.="<option value=".$subchild1->organization_id." ".$orgselect.">".$subchild1->org_name."</option>";                    
                }
                $parent_select.="</td><td style='width:208px;'><div id='input_type[".$key."]'>";
                $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
                $query = "select om.org_type, mv.* from uls_organization_master om, uls_admin_values mv where om.organization_id=".$parent1->child_org_id." and om.org_type=mv.value_code";
                $org_val = $pdo->prepare($query);
                $org_val->execute();
                $org_values=$org_val->fetchAll();
                foreach($org_values as $org_values1){
                    $parent_select.="<label>".$org_values1['value_name']."</label>";
                }
                $parent_select.="</div></td><td style='width:65px;'><p align='center'><img id='select_child[".$key."]' src='".BASE_URL."/public/images/up_arrow.png' onclick='Ajax_upgrade_child(".$key.")' style='cursor:pointer;'/></p></td><!-- <td style='width:63px;'><p align='center'><input type='button' name='add' id='add' value='Add' class='bigbutton' onclick='Add_Row()' /></p></td> --></tr>";
            }
            $values=implode(",",$val);
            $parent_select.="<input type='hidden' name='last_parent_id' value=".$heimas->parent_org_id." ><input type='hidden' name='last_id' value=".$parent->id." ><input type='hidden' name='inner_hidden_id' id='inner_hidden_id' value=\"$values\"></tbody></table>@_";
        }
        echo $parent_select;
    }
	
	public function org_hierarchy_view(){
		$data["aboutpage"]=$this->pagedetails('admin','hierarchy_master_view');
		$data['last_hiername']=UlsOrganizationHeirarchy::last_hierarchy_name();
		$data['last_details']=UlsOrganizationHeirarchy::last_hierarchy_details();
		$data['orgnz_data']=UlsOrganizationMaster::org_data();
		$data['po_orgnz']=UlsOrganizationMaster::sess_parent_orgs();
		$data['all_orgnz']=UlsOrganizationMaster::org_details_names();
		
		$content = $this->load->view('admin/lms_admin_org_hierarchy_view',$data,true);
		$this->render('layouts/adminnew',$content);
    }
	
	public function change_parentorg_view(){		
        $child_id=$_REQUEST['childid'];
        $hierarchyid=$_REQUEST['hie_id'];
        $parent_select='';
        $parent_select="<input type='hidden' name='hierarchy_id' id='hierarchy_id' value=".$hierarchyid."><select name='parent_org_name' id='parent_org_name' style='width:250px;' onchange='getchildorgs()' class='chosen-select validate[required] form-control m-b' disabled>";
        
		$allorgids=Doctrine_Query::create()->from('UlsOrganizationHeirarchy')->where("hierarchy_id=".$hierarchyid." and parent_org_id!=".$child_id)->execute();
		$org_id_exist=array();
		foreach($allorgids as $allorgids1){
			$org_id_exist[]=$allorgids1->child_org_id;	
		}		
		if(!empty($child_id)){
            $heimas=Doctrine::getTable('UlsHeirarchyMaster')->findOneByHierarchy_idAndParent_org_id($hierarchyid,$_SESSION['parent_org_id']);
            $org_values=Doctrine_Query::create()->from('UlsOrganizationMaster')->where("organization_id=".$child_id)->execute();
            foreach($org_values as $org_value){
				$childids=($org_value['organization_id']==$child_id)?"selected='selected'":'';
				$parent_select.="<option value=".$org_value['organization_id']." ".$childids.">".$org_value['org_name']."</option>";                
            }
            $parent_select.="</select>@_";			
            $org=Doctrine_Query::create()->from('UlsOrganizationHeirarchy')->where("parent_org_id=".$child_id." and hierarchy_id=".$hierarchyid."")->execute();
            $parent_select.="<table id='org_data' class='table table-striped table-bordered table-hover'><tbody>";
            if(count($org)>0){
                $val=array();
                foreach($org as $key=>$org1){
                    $val[]=$key;
                    $parent_select.="<tr id='hier_row_".$key."'><td style='width: 348px;'><input type='hidden' name='id[]' id='id' value=".$org1->id."><select name='org_list[]' id='org_list[".$key."]' style='width:215px;' onchange='getOrg_type(".$key.")' class='chosen-select' disabled><option value=''>Select</option>";
                    $supchild=Doctrine::getTable('UlsOrganizationHeirarchy')->findOneByHierarchy_idAndChild_org_id($hierarchyid,$child_id);
                    $subchild=Doctrine_Query::create()->from('UlsOrganizationMaster')->where("parent_org_id=".$_SESSION['parent_org_id']." and org_type!='PO'")->execute();
                    foreach($subchild as $keyy=>$subchild1){
						if(!in_array($subchild1->organization_id,$org_id_exist)){
							$orgselect=($subchild1->organization_id==$org1->child_org_id)?"selected='selected'":'';
							$parent_select.="<option value=".$subchild1->organization_id." ".$orgselect.">".$subchild1->org_name."</option>";  
						}
					}
                    $parent_select.="</td><td style='width:230px;'><div id='input_type[".$key."]'>";
                    $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
                    $query = "select om.org_type, mv.* from uls_organization_master om, uls_admin_values mv where om.organization_id=".$org1->child_org_id." and om.org_type=mv.value_code";
                    $org_val = $pdo->prepare($query);
                    $org_val->execute();
                    $org_values=$org_val->fetchAll();
                    foreach($org_values as $org_values1){
                        $parent_select.="<label>".$org_values1['value_name']."</label>";
                    }
                    $parent_select.="</div></td><td style='width:72px;'><p align='center'><img id='select_child[".$key."]' src='".BASE_URL."/public/images/up_arrow.png' onclick='Ajax_upgrade_child(".$key.")' style='cursor:pointer;'/></p></td></tr>";
                }
                $parent_select.="<input type='hidden' name='last_parent_id' value=".$heimas->parent_org_id." ><input type='hidden' name='last_id' value=".$org1->id." >";
                $values=implode(",",$val);
            }
            else{
                $parent_select.="<tr id='hier_row_0'><td style='padding-left:12px; width: 25px;'><input type='hidden' name='id[]' id='id[0]' value=''><input type='checkbox' name='hier_chk_[]' id='hier_chk_0' value='0'></td><td  style='width: 305px;'><select name='org_list[]' id='org_list[0]' style='width:215px;' onchange='getOrg_type(0)' class='chosen-select' disabled><option value=''>Select</option>";
                $supchild=Doctrine::getTable('UlsOrganizationHeirarchy')->findOneByHierarchy_idAndChild_org_id($hierarchyid,$child_id);
                
				if(!empty($supchild)){
                    $subchild=Doctrine_Query::create()->from('UlsOrganizationMaster')->where("parent_org_id=".$_SESSION['parent_org_id']." and org_type!='PO'")->execute();
                    foreach($subchild as $subchild1){
						if(!in_array($subchild1->organization_id,$org_id_exist)){
							$parent_select.="<option value=".$subchild1->organization_id.">".$subchild1->org_name."</option>";
						}
					}					
                }
                $parent_select.="</select></td><td style='width:206px;'><div id='input_type[0]'></div></td><td style='width:68px;'><p align='center'><img id='select_child[0]' src='".BASE_URL."/public/images/up_arrow.png' onclick='Ajax_upgrade_child(0)' style='cursor:pointer;'/></p></td><!--<td style='width:63px;'><p align='center'><input type='button' name='add' id='add' value='Add' class='bigbutton' onclick='Add_Row()' /></p></td>--></tr>";
                $values=0;
            }
            $parent_select.="<input type='hidden' name='inner_hidden_id' id='inner_hidden_id' value=\"$values\"></table>@_";
        }
        echo $parent_select;
    }
	
	public function kra_master_search(){
		$data["aboutpage"]=$this->pagedetails('admin','kra_master_search');
		$limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
        $page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
        $start=$page!=0? ($page-1)*$limit:0;
        $filePath=BASE_URL."/admin/kra_master_search";
        $data['limit']=$limit;
        $data['perpages']=UlsMenuCreation::perpage();
        $data['searchresults']=UlsKraMasters::search($start, $limit);
        $total=UlsKraMasters::searchcount();
        $otherParams="&perpage=".$limit;
        $data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/kra_master_search',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function get_childorg_view(){
        $parentid=$_REQUEST['parentid'];
        $hierarchy=$_REQUEST['heirarchyid'];
        $parent_select='';
        $heimas=Doctrine::getTable('UlsHeirarchyMaster')->findOneByHierarchy_idAndParent_org_id($hierarchy,$_SESSION['parent_org_id']);
        $hiermas_id=$heimas->hierarchy_id;
        $parent_select="<input type='hidden' name='hierarchy_id' id='hierarchy_id' value=".$hierarchy."><input type='hidden' name='unique_id' id='unique_id' value='".$hierarchy."'><select name='parent_org_name' id='parent_org_name' style='width:200px;' onchange='getchildorgs()' class='chosen-select validate[required]' disabled>";
        $supparent1=Doctrine::getTable('UlsOrganizationHeirarchy')->findOneByChild_org_idAndHierarchy_id($parentid,$hiermas_id);
        if(!empty($supparent1)){
            $sup=Doctrine_Query::create()->from('UlsOrganizationMaster')->where("organization_id=".$supparent1->parent_org_id)->execute();
        }
        else{
            $main=Doctrine::getTable('UlsHeirarchyMaster')->findOneByHierarchy_idAndParent_org_id($hierarchy,$_SESSION['parent_org_id']);
            $sup=Doctrine_Query::create()->from('UlsOrganizationMaster')->where("organization_id=".$main->parent_org_id)->execute();
        }
        foreach($sup as $sup1){
            $parent_select.="<option value=".$sup1->organization_id." selected>".$sup1->org_name."</option>";
        }
        $parent_select.="</select>@_";
        $paren=Doctrine::getTable('UlsOrganizationHeirarchy')->findOneByChild_org_idAndHierarchy_id($parentid,$hierarchy);
        if(!empty($paren)){
            $parent=Doctrine::getTable('UlsOrganizationHeirarchy')->findByParent_org_idAndHierarchy_id($paren->parent_org_id,$hiermas_id);
        }
        else{
            $main=Doctrine::getTable('UlsHeirarchyMaster')->findOneByHierarchy_idAndParent_org_id($hierarchy,$_SESSION['parent_org_id']);
            $parent=Doctrine::getTable('UlsOrganizationHeirarchy')->findByParent_org_idAndHierarchy_id($main->parent_org_id,$hiermas_id);
        }
		
		
        if(count($parent)>0){
            $parent_select.="<table id='org_data' class='table table-striped table-bordered table-hover'><tbody>";
            $val=array();
            foreach($parent as $key=>$parent1){
                $val[]=$key;
                $parent_select.="<tr id='hier_row_".$key."'><td style='width:348px;'><input type='hidden' name='id[]' id='id[".$key."]' value='".$parent1->id."'><select name='org_list[]' id='org_list[".$key."]' style='width:215px;' onchange='getOrg_type(".$key.")' class='chosen-select' disabled><option value=''>Select</option>";
                $subchild=Doctrine_Query::create()->from('UlsOrganizationMaster')->where("parent_org_id=".$_SESSION['parent_org_id']." and org_type!='PO'")->execute();
                foreach($subchild as $subchild1){
                    $orgselect=($subchild1->organization_id==$parent1->child_org_id)?"selected='selected'":'';
                    $parent_select.="<option value=".$subchild1->organization_id." ".$orgselect.">".$subchild1->org_name."</option>";                    
                }
                $parent_select.="</td><td style='width:230px;'><div id='input_type[".$key."]'>";
                $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
                $query = "select om.org_type, mv.* from uls_organization_master om, uls_admin_values mv where om.organization_id=".$parent1->child_org_id." and om.org_type=mv.value_code";
                $org_val = $pdo->prepare($query);
                $org_val->execute();
                $org_values=$org_val->fetchAll();
                foreach($org_values as $org_values1){
                    $parent_select.="<label>".$org_values1['value_name']."</label>";
                }
                $parent_select.="</div></td><td style='width:72px;'><p align='center'><img id='select_child[".$key."]' src='".BASE_URL."/public/images/up_arrow.png' onclick='Ajax_upgrade_child(".$key.")' style='cursor:pointer;'/></p></td><!-- <td style='width:63px;'><p align='center'><input type='button' name='add' id='add' value='Add' class='bigbutton' onclick='Add_Row()' /></p></td> --></tr>";
            }
            $values=implode(",",$val);
            $parent_select.="<input type='hidden' name='last_parent_id' value=".$heimas->parent_org_id." ><input type='hidden' name='last_id' value=".$parent->id." ><input type='hidden' name='inner_hidden_id' id='inner_hidden_id' value=\"$values\"></tbody></table>@_";
        }
        echo $parent_select;
    }
	
	public function deletelocation(){
		$id=trim($_REQUEST['val']);
		if(!empty($id)){
			$uom=Doctrine_Query::create()->from('UlsOrganizationMaster')->where('location='.$id)->execute();
			$uewi=Doctrine_Query::create()->from('UlsEmployeeWorkInfo')->where('location_id='.$id)->execute();
			if(count($uom)==0 && count($uewi)==0){
			$play=Doctrine_Query::Create()->delete('UlsLocationRoles')->where("location_id=".$id)->execute();
				$q = Doctrine_Query::create()->delete('UlsLocation')->where('location_id=?',$id);	
				$q->execute();
				echo 1;
			}
			else{
				echo "Selected Location cannot be deleted. Ensure you delete all the usages of the Location before you delete it.";
			}
		}
	}
	
	public function delete_location_roles(){
		if(!empty($_REQUEST['val'])){
			$play=Doctrine_Query::Create()->delete('UlsLocationRoles')->where("loc_role_id=".$_REQUEST['val'])->execute();
			echo 1;
		}
		else{
			echo "Selected Location Roles cannot be deleted. Ensure you delete all the usages of the Location Roles before you delete it.";
		}
	}
	
	public function deletegrade(){
		$id=trim($_REQUEST['val']);
		if(!empty($id)){
			$uewi=Doctrine_Query::create()->from('UlsEmployeeWorkInfo')->where('grade_id='.$id)->execute();
			if(count($uewi)==0){
				$q = Doctrine_Query::create()->delete('UlsGradeYear')->where('grade_id=?',$id);	
				$q->execute();
				$q = Doctrine_Query::create()->delete('UlsSubGrades')->where('grade_id=?',$id);	
				$q->execute();
				$q = Doctrine_Query::create()->delete('UlsGrade')->where('grade_id=?',$id);	
				$q->execute();
				echo 1;
			}
			else{
				echo "Selected Grade cannot be deleted. Ensure you delete all the usages of the Grade before you delete it.";
			}
		}
	}
	
	public function kra_master()
	{
		$data["aboutpage"]=$this->pagedetails('admin','kra_master');
		$id=filter_input(INPUT_GET,'kra_master_id') ? filter_input(INPUT_GET,'kra_master_id'):"";
        $hash=filter_input(INPUT_GET,'hash') ? filter_input(INPUT_GET,'hash'):"";
        $menutype=!empty($id)? UlsMenuCreation::menutype($id):"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			$data['kramaster']=UlsKraMasters::viewkra($id);
			$data['kracompetencies']=UlsKraMasterCompetency::kra_competencies($id);
			$data['competencies']=UlsCompetencyDefinition::competency_details();
			$data['status']=UlsAdminMaster::get_value_names("STATUS");
			$content = $this->load->view('admin/kra_master',$data,true);
		}
		$this->render('layouts/adminnew',$content);

	}
	
	public function delete_comp_kra(){
		if(!empty($_REQUEST['val'])){
			$play=Doctrine_Query::Create()->delete('UlsKraMasterCompetency')->where("kra_comp_master_id=".$_REQUEST['val'])->execute();
			echo 1;
		}
		else{
			echo "Selected KRA Competency cannot be deleted. Ensure you delete all the usages of the KRA Competency before you delete it.";
		}
	}
	
	public function lms_kra_master(){
        if(isset($_POST['kra_master_id'])){ //print_r($_POST);
            $level=(!empty($_POST['kra_master_id']))?Doctrine::getTable('UlsKraMasters')->find($_POST['kra_master_id']):new UlsKraMasters();
            $level->kra_master_name=$_POST['kra_master_name'];
            $level->kra_status=$_POST['kra_status'];
            $level->save();
			foreach($_POST['comp_def_id'] as $k=>$value){
				if(!empty($_POST['comp_def_id'][$k])){
					$subl=(!empty($_POST['kra_comp_master_id'][$k]))?Doctrine::getTable('UlsKraMasterCompetency')->find($_POST['kra_comp_master_id'][$k]):new UlsKraMasterCompetency();
					$subl->comp_def_id=$value;
					$subl->status=$_POST['status'][$k];
					$subl->kra_master_id=$level->kra_master_id;
					$subl->save();
					$empdetails_update2=Doctrine_Query::Create()->update('UlsKraMasters');
					$empdetails_update2->set('kra_comp_count','?',1);
					$empdetails_update2->andwhere('kra_master_id=?',$level->kra_master_id);
					$empdetails_update2->limit(1)->execute();
				}
				else{
					$empdetails_update2=Doctrine_Query::Create()->update('UlsKraMasters');
					$empdetails_update2->set('kra_comp_count','?',0);
					$empdetails_update2->andwhere('kra_master_id=?',$level->kra_master_id);
					$empdetails_update2->limit(1)->execute();
				}
			}
			$this->session->set_flashdata('kra_msg',"Kra data ".(!empty($_POST['kra_master_id'])?"updated":"inserted")." successfully.");
			redirect("admin/kra_view?kra_master_id=".$level->kra_master_id);
        }
        else{
			$content = $this->load->view('admin/kra_master_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }
	
	public function kra_view(){
		$data["aboutpage"]=$this->pagedetails('admin','kra_view');
        $id=isset($_REQUEST['kra_master_id'])? $_REQUEST['kra_master_id']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1 || $id==""){
            $content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			$data['status']=UlsAdminMaster::get_value_names("STATUS");
            $data['kradetails']=UlsKraMasters::viewkra($id);
			$data['kracomp']=UlsKraMasterCompetency::viewkracomp($id);
			$content = $this->load->view('admin/kra_view',$data,true);
        }
		$this->render('layouts/adminnew',$content);
    }
	
	public function kralevel(){
		$id=trim($_REQUEST['val']);
		if(!empty($id)){
			$uewi=Doctrine_Query::create()->from('UlsCompetencyPositionRequirementsKra')->where('comp_kra_steps='.$id)->execute();
			if(count($uewi)==0){
				$q = Doctrine_Query::create()->delete('UlsKraMasterCompetency')->where('kra_master_id=?',$id)->execute();
				$q = Doctrine_Query::create()->delete('UlsKraMasters')->where('kra_master_id=?',$id)->execute();
				echo 1;
			}
			else{
				echo "Selected KRA cannot be deleted. Ensure you delete all the usages of the KRA before you delete it.";
			}
		}
	}
	
	public function delete_assessment_inbasket(){
		$code=$_REQUEST['val'];
		if(!empty($code)){
			$empdata = Doctrine_Query::create()->delete('UlsAssessmentTestInbasket')->where('inb_assess_test_id=?',$code)->execute();
			echo 1;
		}
        else{
			echo "Selected Assessment Inbasket cannot be deleted. Ensure you delete all the usages of the Assessment Inbasket before you delete it.";
		}
    }
	
	
	public function delete_assessment_casestudy(){
		$code=$_REQUEST['val'];
		if(!empty($code)){
			$query="select a.* from uls_assessment_test_casestudy a where 1 and a.case_assess_test_id=".$code;
			$compdef=UlsMenu::callpdorow($query);
			if(isset($compdef['case_assess_test_id'])){
				$empdata_testquestions = Doctrine_Query::create()->delete('UlsAssessmentTestQuestions')->where('assess_test_id=?',$compdef['assess_test_id'])->execute();
				$empdata_test = Doctrine_Query::create()->delete('UlsAssessmentTest')->where('assess_test_id=?',$compdef['assess_test_id'])->execute();
				$test_qestions = Doctrine_Query::create()->delete('UlsCompetencyTestQuestions')->where('test_id=?',$compdef['test_id'])->execute();
				$test = Doctrine_Query::create()->delete('UlsCompetencyTest')->where('test_id=?',$compdef['test_id'])->execute();
			}
			
			$empdata = Doctrine_Query::create()->delete('UlsAssessmentTestCasestudy')->where('case_assess_test_id=?',$code)->execute();
			
			echo 1;
		}
        else{
			echo "Selected Assessment Casestudy cannot be deleted. Ensure you delete all the usages of the Assessment Casestudy before you delete it.";
		}
    }
	
	public function test_data_migration_comp(){
		$data["aboutpage"]=$this->pagedetails('admin','migration_comp');
		$data['po_orgs']=UlsOrganizationMaster::parent_orgs();
		$content = $this->load->view('admin/lms_admin_datamigration_comp_test',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function test_data_questionbanks_comp(){
		$parentid=$_REQUEST['parentid'];
		$questionbanks=UlsQuestionbank::questionbanks($parentid);
		echo "<option value=''>Select</option>";
		foreach($questionbanks as $banks){
			$type="";
			if($banks->type=="COMP_TEST"){ $type="Test";}
			if($banks->type=="COMP_INTERVIEW"){ $type="Interview";}
			echo "<option value=".$banks->question_bank_id.">".$banks->name." - ".$type."</option>";
		}
	}
	
	/* public function test_comp_elements(){
		$qbid=$_REQUEST['qbid'];
		if(!empty($qbid)){
			
			$questionbanks=UlsMenu::callpdo("SELECT c.comp_def_name,b.ind_master_id,b.ind_master_name,a.`comp_def_id` FROM `uls_questionbank` a left join `uls_competency_def_level_indicator` b on a.comp_def_id=b.comp_def_id left join uls_competency_definition c on a.comp_def_id=c.comp_def_id WHERE a.`question_bank_id`=$qbid and a.`type`='COMP_TEST'");
			if(count($questionbanks)>0){
			echo "<div class='form-group'>
	<label class='control-label col-xs-12 col-sm-3 no-padding-right'>Competency Name: </label>
	<div class='col-xs-12 col-sm-9'>
		<div class='clearfix' style='width: 32%;'>".@$questionbanks[0]['comp_def_name']."<input type='hidden' name='comp_def_id' id='comp_def_id' value='".@$questionbanks[0]['comp_def_id']."'></div>
	</div>
</div>
<div class='form-group'>
	<label class='control-label col-xs-12 col-sm-3 no-padding-right'>Element Name: </label>
	<div class='col-xs-12 col-sm-9'>
		<div class='clearfix' style='width: 32%;'><select name='element' id='element' class='col-xs-12 col-sm-12 form-control'>
			<option value=''>Select</option>";
			foreach($questionbanks as $banks){
				if(!empty($banks['ind_master_id'])){
					echo "<option value=".$banks['ind_master_id'].">".$banks['ind_master_name']."</option>";
				}
			}
			echo "</select></div>
	</div>
</div>";
		}
		else{
			echo "";
		}
		}
		else{
			echo "";
		}
	} */
	
	public function test_comp_elements(){
		$qbid=$_REQUEST['qbid'];
		if(!empty($qbid)){
			
			$questionbanks=UlsMenu::callpdorow("SELECT c.comp_def_name,a.`comp_def_id`,c.comp_def_level FROM `uls_questionbank` a left join uls_competency_definition c on a.comp_def_id=c.comp_def_id WHERE a.`question_bank_id`=$qbid and a.`type`='COMP_TEST'");
			if(!empty($questionbanks)>0){
			echo "<div class='form-group'>
				<label class='control-label col-xs-12 col-sm-3 no-padding-right'>Competency Name: </label>
				<div class='col-xs-12 col-sm-9'>
					<div class='clearfix' style='width: 32%;'>".@$questionbanks['comp_def_name']."<input type='hidden' name='comp_def_id' id='comp_def_id' value='".@$questionbanks['comp_def_id']."'></div>
				</div>
			</div>
			<div class='form-group'>
				<label class='control-label col-xs-12 col-sm-3 no-padding-right'>Level Name: </label>
				<div class='col-xs-12 col-sm-9'>
					<div class='clearfix' style='width: 32%;'><select name='scale_id' id='scale_id' class='col-xs-12 col-sm-12 form-control' onchange='getlevelCompetencyElements()'>
						<option value=''>Select</option>";
						$levels=UlsLevelMasterScale::levelscale($questionbanks['comp_def_level']);
						foreach($levels as $level){							
							echo "<option value=".$level['scale_id'].">".$level['scale_name']."</option>";
						}
						echo "</select></div>
				</div>
			</div>
			<div id='competency-level-elements'></div>
			";
		}
		else{
			echo "";
		}
		}
		else{
			echo "";
		}
	}
	
	public function test_comp_level_elements(){
		$compid=$_REQUEST['compid'];
		$scaleid=$_REQUEST['scaleid'];
		if(!empty($compid)){
			echo "
			<div class='form-group'>
				<label class='control-label col-xs-12 col-sm-3 no-padding-right'>Element Name: </label>
				<div class='col-xs-12 col-sm-9'>
					<div class='clearfix' style='width: 32%;'><select name='element' id='element' class='col-xs-12 col-sm-12 form-control'>
						<option value=''>Select</option>";
						$indicator_level=UlsCompetencyDefLevelIndicator::getcompdeflevelind_details($compid,$scaleid);
						foreach($indicator_level as $indicator_levels){
							if(!empty($indicator_levels['comp_def_level_ind_id'])){
								echo "<option value=".$indicator_levels['comp_def_level_ind_id'].">".$indicator_levels['comp_def_level_ind_name']."</option>";
							}
						}
						echo "</select></div>
				</div>
			</div>";
		}
		else{
			echo "";
		}
	}
	
	public function test_data_migrate_comp_lang(){
		$this->load->library('excel');
		if(isset($_GET['files'])){	
		
		$file ="";
			foreach($_FILES as $file){
			//$file = $_FILES['files']["tmp_name"];
			if (!empty($file['tmp_name'])) {
				$valid = false;
				$types = array('Excel2007', 'Excel5','CSV');
				foreach ($types as $type) {
					$reader = PHPExcel_IOFactory::createReader($type);
					if ($reader->canRead($file['tmp_name'])) {
						$valid = true;
					}
				}
				if (!empty($valid)) {
					try {
						$objPHPExcel = PHPExcel_IOFactory::load($file['tmp_name']);
					} catch (Exception $e) {
						die("Error loading file :" . $e->getMessage());
					}
					//All data from excel
					$sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
					$qu=$qu2 = "";

					$row=-1;$row2=-1;$flgg=0;
					$qu = "";
					$qu .= "<div id='programuploaddata' class='container'><table class='table table-bordered table-striped  table-fixed' style='width:1000px'>";
					$qu .= "<thead><tr><th class='col-xs-1'>Sno</th><th class='col-xs-5'>Question</th><th class='col-xs-1'>Option1</th><th class='col-xs-1'>Option2</th><th class='col-xs-1'>Option3</th><th class='col-xs-1'>Option4</th><th class='col-xs-1'>Option5</th><th class='col-xs-1'>Comments</th></tr></thead><tbody>"; 
					$questbank_id=$_REQUEST['question_bank'];
					$parent_org_id=$_REQUEST['parent_org_id'];
					$level=array();
					$parent_org_id=$_REQUEST['parent_org_id'];
					$orgquery="select scale_id,level_id,REPLACE(scale_name,' ','') as scale_name, parent_org_id from uls_level_master_scale where parent_org_id='$parent_org_id'";
					$orgrow=UlsMenu::callpdo($orgquery);
					foreach($orgrow as $val){						
						$checkorg[$val['scale_id']]=strtolower($val['scale_name']);
						$level[$val['scale_id']]=$val['level_id'];
					}
					for ($x = 2; $x <= count($sheetData); $x++) {
						if(!empty($sheetData[$x]["A"])){
							$scale=(!empty($sheetData[$x]["D"]))?trim($sheetData[$x]["D"]):'';
							$scale_cnt=0;$scale_id='';
							if(!empty($scale)){
								$trimed_scale=str_replace(' ','',$scale);
								$trimed_scale=strtolower($trimed_scale);
								if(in_array($trimed_scale,$checkorg)){
									$scale_id=array_search($trimed_scale,$checkorg);
									$scale_cnt=1;
								}
							}
						$question_name=$sheetData[$x]["C"];
						//$question=str_replace("\n","<br />",$sheetData[$x]["C"]);
						$check_questions=UlsQuestions::questionsformigration($sheetData[$x]["B"],addslashes($question_name),$parent_org_id,$questbank_id,$scale_id);
						if(count($check_questions)>0){									
							$exist_data="<font color='red'>Question Already Exists</font>";							
						}
						else{
							$quest_name=new UlsQuestions();
							$quest_name->question_bank_id=$questbank_id;
							$quest_name->parent_org_id=$parent_org_id;
							$quest_name->question_name=$question_name;
							$quest_name->question_type=$sheetData[$x]["B"];
							$quest_name->question_category='T';
							$quest_name->points=1;
							$quest_name->active_flag=$sheetData[$x]["F"];
							$quest_name->sequence=$sheetData[$x]["E"];
							$quest_name->level_id=$level[$scale_id];
							$quest_name->scale_id=$scale_id;
							$quest_name->multi_language='no';
							$quest_name->start_date_active=date('Y-m-d');
							$quest_name->end_date_active=NULL;
							$quest_name->save();
							if(!empty($_REQUEST['element'])){
								$comp_def_level_ind_id=$_REQUEST['element'];
								$comp_def_id=$_REQUEST['comp_def_id'];
								$scale_id=$_REQUEST['scale_id'];
								$work_activation=new UlsCompetencyDefQueIndicators;
								$work_activation->comp_def_level_ind_id=$comp_def_level_ind_id;
								$work_activation->question_id=$quest_name->question_id;
								$work_activation->comp_def_id=$comp_def_id;
								$work_activation->scale_id=$scale_id;
								$work_activation->save();
							}
							$arr=array("H","I","J","K","L","M","N","O","P","Q","R");
							foreach($arr as $key=>$ar1){
								
								$flag=$key+1;
								if(!empty($sheetData[$x][$ar1])){
									//echo $sheetData[$x][$ar1];
									$multiple_ans=explode("*",$sheetData[$x]["G"]);
									$answer=(in_array($flag,$multiple_ans))?'Y':'N';
									$quest_values=new UlsQuestionValues();
									$quest_values->parent_org_id=$parent_org_id;
									$quest_values->question_id=$quest_name->question_id;
									$quest_values->correct_flag=$answer;
									$quest_values->text=trim($sheetData[$x][$ar1]);
									$quest_values->start_date_active=date('Y-m-d');
									$quest_values->end_date_active=NULL;
									$quest_values->save();
								}
							} 
							$exist_data="<font color='green'>Question Inserted</font>";
						} 
						$value_l="";
						if(isset($sheetData[$x]["L"])){
							$val_l=trim($sheetData[$x]["L"]);
							$value_l=(!empty($val_l))?$val_l:"";
						}
						$qu .= "<tr>";
						$qu .="<td class='col-xs-1'>".($x-1)."</td>";
						$qu .= "<td class='col-xs-5'>".$question_name."</td>";
						$qu .= "<td class='col-xs-1'>".trim($sheetData[$x]["H"])."</td>";
						$qu .= "<td class='col-xs-1'>".trim($sheetData[$x]["I"])."</td>";
						$qu .= "<td class='col-xs-1'>".trim($sheetData[$x]["J"])."</td>";
						$qu .= "<td class='col-xs-1'>".trim($sheetData[$x]["K"])."</td>";
						$qu .= "<td class='col-xs-1'>".$value_l."</td>";
						$qu .= "<td class='col-xs-1'>$exist_data</td>";
						$qu .= "</tr>";
						}
					}
					$qu .= "</tbody></table>
					</div>";
					
					$q=$qu ;
					$type = "success";
					$message = "ok"; 

				} else {
					$type = 'error';
					$message = "Sorry your uploaded file type not allowed ! please upload XLS/CSV File ";
				}
			} else {
				$type = 'error';
				$message = "You did not Select File! please upload XLS/CSV File ";
			}
			}
			$data = array($q);
		}
		else{
			$data = array('success' => 'Form was submitted', 'formData' => $_POST);               
		} 
		//echo $data;
		echo json_encode($data);
	}
	
	public function test_data_migrate_comp(){
		$this->sessionexist();           
		$data = array();            
		if(isset($_GET['files'])){	
			$error = false;
			$files = '';
			//$uploaddir = 'public/uploads/abc/';
			foreach($_FILES as $file){
//                    if(move_uploaded_file($file['tmp_name'], $uploaddir .basename($file['name']))){
//                        $files[] = $uploaddir .$file['name'];
//                    }
//                    else{
//                        $error = true;
//                    }
				if(!empty($file['tmp_name'])){
					$fieldseparator = ",";
					$lineseparator = "\n";
					//$lineseparator = "";
					$csvfile = $file['tmp_name'];
					$addauto = 0;
					$save = 1;
					$outputfile = "output.sql";
					if(!file_exists($csvfile)) {
						echo "File not found. Make sure you specified the correct path.\n";
					exit;
					}
					$file = fopen($csvfile,"r");
					if(!$file) {
						echo "Error opening data file.\n";
						exit;
					}
					$size = filesize($csvfile);
					if(!$size) {
						echo "File is empty.\n";
						exit;
					}
					//$csvcontent = fread($file,$size);
					//$linearray = array();
					$qu = "";
					$qu .= "<div id='programuploaddata' style='width: 1040px;'><table class='table table-striped table-bordered table-hover' style='margin-bottom:0px; border-bottom:none;'>";
					$qu .= "<thead><tr><th style='width:47px;'>Sno</th><th style='width:130px;'>Question</th><th style='width:115px;'>Question Type</th><th style='width:103px;'>Option1</th><th style='width:107px;'>Option2</th><th style='width:103px;'>Option3</th><th style='width:100px;'>Option4</th><th style='width:104px;'>Comments</th></tr></thead></table></div>
					<div id='innerdata' style='width:1058px; height: 250px; overflow:auto;'><table id='programs_data' class='table table-striped table-bordered table-hover' style='margin-top:0px; border-top:none; width: 1055px;'>"; 
					$level=array();
					$parent_org_id=$_REQUEST['parent_org_id'];
					$orgquery="select scale_id,level_id,REPLACE(scale_name,' ','') as scale_name, parent_org_id from uls_level_master_scale where parent_org_id='$parent_org_id'";
					$orgrow=UlsMenu::callpdo($orgquery);
					foreach($orgrow as $val){						
						$checkorg[$val['scale_id']]=strtolower($val['scale_name']);
						$level[$val['scale_id']]=$val['level_id'];
					}
						$c = 0;
						while(($linearray = fgetcsv($file, 1000, ",")) !== false)
							{	
								if($c>0){
								$scale=(!empty($linearray[3]))?trim($linearray[3]):'';
								$scale_cnt=0;$scale_id='';
								if(!empty($scale)){
									$trimed_scale=str_replace(' ','',$scale);
									$trimed_scale=strtolower($trimed_scale);
									if(in_array($trimed_scale,$checkorg)){
										$scale_id=array_search($trimed_scale,$checkorg);
										$scale_cnt=1;
									}
								}	
								$parent_org_id=$_REQUEST['parent_org_id'];
								$questbank_id=$_REQUEST['question_bank'];
								$question_name=$linearray[2];
								$question=str_replace("\n","<br />",$linearray[2]);
								/* $check_questions=UlsQuestions::questionsformigration($linearray[1],$question_name,$parent_org_id,$questbank_id);
								if(count($check_questions)>0){									
									$exist_data="<font color='red'>Question Already Exists</font>";							
								}
								else{  */
									$quest_name=new UlsQuestions();
									$quest_name->question_bank_id=$questbank_id;
									$quest_name->parent_org_id=$parent_org_id;
									$quest_name->question_name=$question;
									$quest_name->question_type=$linearray[1];
									$quest_name->question_category='T';
									$quest_name->points=1;
									$quest_name->active_flag=$linearray[5];
									$quest_name->sequence=$linearray[4];
									$quest_name->level_id=$level[$scale_id];
									$quest_name->scale_id=$scale_id;
									$quest_name->multi_language='no';
									$quest_name->start_date_active=date('Y-m-d');
									$quest_name->end_date_active=NULL;
									$quest_name->save(); 
									
									for($i=0; $i<5; $i++){
										$key=7+$i;
										$flag=$i+1;
										$text=trim($linearray[$key]);
										//echo $text=$linearray[$key];
										$multiple_ans=explode("*",$linearray[6]);
										$answer=(in_array($flag,$multiple_ans))?'Y':'N';
										
										if(!empty($text)){
											$answer=(in_array($flag,$multiple_ans))?'Y':'N';								
											$quest_values=new UlsQuestionValues();
											$quest_values->parent_org_id=$parent_org_id;
											$quest_values->question_id=$quest_name->question_id;
											$quest_values->correct_flag=$answer;
											$quest_values->text=$text;
											//$quest_values->explanation=(!empty($linearray[13]))?$linearray[13]:'';
											$quest_values->start_date_active=date('Y-m-d');
											$quest_values->end_date_active=NULL;
											$quest_values->save();
										} 
									}
									$exist_data="<font color='green'>Question Uploaded Successfully</font>";				
								 //}		
									$qu .= "<tr>";
									$qu .="<td style='padding-left:40px; width:74px;'>".$c."</td>";
									$qu .="<td style='width:340px;'>".str_replace("\n","<br />",$linearray[2])."</td>";
									$qu .="<td style='width:215px;'>".$linearray[0]."</td>";
									$qu .="<td style='width:224px;'>".$linearray[7]."</td>";
									$qu .="<td style='width:212px;'>".$linearray[8]."</td>";
									$qu .="<td style='width:212px;'>".$linearray[9]."</td>";
									$qu .="<td style='width:212px;'>".$linearray[10]."</td>";
									if(!empty($linearray[11])){
										$qu .="<td style='width:212px;'>".$linearray[11]."</td>";
									}
									$qu .="<td style='width:239px;'>".$exist_data."</td>";
									$qu .= "</tr>"; 	
								}
								$c = $c + 1;
			
					}
					$qu .= "</table></div>";
					$qu .="<div style='float:right;  margin-top:10px; margin-right:30px; margin-bottom:20px;'>
						<!--<input type='button' class='btn btn-sm btn-success' value='Validate' id='org_valid' name='org_valid'>&nbsp;&nbsp;&nbsp;-->
						<input type='button' onclick='cancel_funct()' value='cancel' id='cancel' name='cancel' class='btn btn-sm btn-danger'></div>";
				}
				else{
					$error = true;
				}
			}
			$data = ($error) ? array('error' => 'There was an error uploading your files') : array($qu);
		}
		else{
			$data = array('success' => 'Form was submitted', 'formData' => $_POST);               
		} 
		//echo $data;
		echo json_encode($data);
	}

	public function question_count_level(){
		$q_id=$_REQUEST['q_id'];
		$data="";
		$q_count=UlsQuestionbank::get_questions_level_count($q_id);
		$data.="<div class='table-responsive'>
			<table cellpadding='1' cellspacing='1' class='table table-bordered table-striped'>
				<thead>
				<tr>
					<th class='col-sm-3'>Scale Number</th>
					<th class='col-sm-6'>Scale Name</th>
					<th class='col-sm-3'>Count</th
				</tr>
				</thead>
				<tbody>";
				foreach($q_count as $q_counts){
					$scale_count=UlsQuestionbank::get_questions_data_level_comp($q_id,$q_counts['scale_id'],$q_counts['comp_def_id']);
					$data.="<tr>
						<td>".$q_counts['scale_number']."</td>
						<td>".$q_counts['scale_name']."</td>
						<td>".count($scale_count)."</td>
					</tr>";
				}
				$data.="</tbody>
			</table>
		</div>";
		echo $data;
	}

	public function saveuploadedfile(){
		
		$target_path = __SITE_PATH .DS.'public'.DS.'uploads'.DS.'questionimg';
		//$extension = Input::file('file')->getClientOriginalExtension();
		$tmp_name = $_FILES["file"]["tmp_name"];
		$name = $filename = date('Ymdhis').'_'.$_FILES["file"]["name"];
		move_uploaded_file($tmp_name, "$target_path/$name");
		echo BASE_URL."/public/uploads/questionimg/".$name;
		
	}
	
	public function questionbankcsv(){
		$id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1 || $id==""){
            $content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
		else{
			$quest=UlsQuestionbank::get_question_csv($id);
			$answers=UlsQuestionbank::get_answer_csv($id);
			$data['questionss']=$quest;
			$data['answers']=$answers;
			//$data['assesment']=UlsAdminMaster::get_value_names("ASSESSMENT_TYPE");
			//$data['questionbanks']=UlsQuestionbank::view_questionbank($id);
			$content = $this->load->view('admin/question_bank_csv',$data,true);
		}
		$file="demo.xls";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$file");
		echo $content;
		//print_r($answers);
		//$this->render('layouts/report-layout',$content);
		/* $filename = 'report_'.time();
		$this->pdfgenerator->generate($content, $filename, true, 'A4', 'portrait'); */
	}
	
	public function questionbankpdf(){
		$this->load->library('pdfgenerator');
		$id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1 || $id==""){
            $content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
		else{
			$data['questionss']=UlsQuestionbank::get_questions_data_pdf($id);
			$data['assesment']=UlsAdminMaster::get_value_names("ASSESSMENT_TYPE");
			$data['questionbanks']=UlsQuestionbank::view_questionbank($id);
			$content = $this->load->view('pdf/question_bank',$data,true);
		}
		$this->render('layouts/report-layout',$content);
		/* $filename = 'report_'.time();
		$this->pdfgenerator->generate($content, $filename, true, 'A4', 'portrait'); */
	}
	
	public function indicator_search()
	{
		$data["aboutpage"]=$this->pagedetails('admin','indicatorsearch');
        $limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
        $ind_master_name=filter_input(INPUT_GET,'ind_master_name') ? filter_input(INPUT_GET,'ind_master_name'):"";
        $page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
        $start=$page!=0? ($page-1)*$limit:0;
        $filePath=BASE_URL."/admin/indicator_search";
        $data['limit']=$limit;
        $data['perpages']=UlsMenuCreation::perpage();
        $data['ind_master_name']=$ind_master_name;
        $data['ind_masters']=UlsCompetencyLevelIndicatorMaster::search($start, $limit,$ind_master_name);
        $total=UlsCompetencyLevelIndicatorMaster::searchcount($ind_master_name);
        $otherParams="&perpage=".$limit."&ind_master_name=".$ind_master_name;
        $data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/indicator_search',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function indicator_update(){
        $data["aboutpage"]=$this->pagedetails('admin','indicator_update');
        $id=isset($_REQUEST['ind_master_id'])? $_REQUEST['ind_master_id']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			if(!empty($id)){
				$indicator=Doctrine_Query::Create()->from('UlsCompetencyLevelIndicatorMaster')->where('ind_master_id='.$id)->fetchOne();
				$data['indicatordetails']=$indicator;
				
			}
			$data['competencymsdetails']=UlsCompetencyDefinition::competency_details("MS"); 
			$data['competencynmsdetails']=UlsCompetencyDefinition::competency_details("NMS");
            $pos_status="STATUS";
            $data['posstatusss']=UlsAdminMaster::get_value_names($pos_status);
			$content = $this->load->view('admin/indicator_update',$data,true);
        }
		$this->render('layouts/adminnew',$content);
    }
	
	public function lms_indicator(){
        if(isset($_POST['ind_master_id'])){
            $fieldinsertupdates=array('ind_master_name','comp_def_id','status');
            $position=Doctrine::getTable('UlsCompetencyLevelIndicatorMaster')->findOneByInd_master_id($_POST['ind_master_id']);
            !isset($position->ind_master_id)?$position=new UlsCompetencyLevelIndicatorMaster():"";
            foreach($fieldinsertupdates as $val){$position->$val=!empty($_POST[$val])?$_POST[$val]:NULL;}
            $position->Save();
			$this->session->set_flashdata('pos_message',"Indicator data ".(!empty($_POST['ind_master_id'])?"updated":"inserted")." successfully.");
			redirect("admin/indicator_view?ind_master_id=".$position->ind_master_id);
        }
        else{
			$content = $this->load->view('admin/indicator_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }
	
	public function indicator_view(){
		$data["aboutpage"]=$this->pagedetails('admin','indicator_view');
        $id=isset($_REQUEST['ind_master_id'])? $_REQUEST['ind_master_id']:"";
        $menutype=!empty($id)? UlsMenuCreation::menutype($id):"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1 || $id==""){
            $content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			$pos_status="STATUS";
			$data['posstatusss']=UlsAdminMaster::get_value_names($pos_status);
			$data['indicatordetails']=UlsCompetencyLevelIndicatorMaster::indicator_master_view($id);
			$content = $this->load->view('admin/indicator_view',$data,true);
        }
		$this->render('layouts/adminnew',$content);
    }
	
	public function deleteindicators(){
		$id=trim($_REQUEST['val']);
		if(!empty($id)){
			$uewi=Doctrine_Query::create()->from('UlsCompetencyDefLevelIndicator')->where('comp_def_level_ind_type='.$id)->execute();
			if(count($uewi)==0){
				$q = Doctrine_Query::create()->delete('UlsCompetencyLevelIndicatorMaster')->where('ind_master_id=?',$id);
				$q->execute();
				echo 1;
			}
			else{
				echo "Selected Indicator cannot be deleted. Ensure you delete all the usages of the Indicator before you delete it.";
			}
		}
	}
	
	public function delete_assessor_data(){
        $code=$_REQUEST['assessment_pos_assessor_id'];
        if(!empty($code)){
			/* $attemptcount=Doctrine_Query::create()->from('UlsUtestAttempts')->where('event_id='.$event_id.' and employee_id='.$empid)->execute();
			if(count($attemptcount)==0){ */
				$endata=Doctrine_Query::create()->delete('UlsAssessmentPositionAssessor')->where('assessment_pos_assessor_id=?',$code)->execute();
				echo 1;
			/* }
			else{
				echo 0;
			} */
        }
		else{
			echo "Selected Assessor cannot be deleted. Ensure you delete all the usages of the Assessor before you delete it.";
		}
    }
	
	public function comp_level_details(){
		$comp_id=$_REQUEST['com_id'];
		$scale_id=$_REQUEST['lev_id'];
		$indicators=UlsCompetencyDefLevelIndicator::getcompdeflevelind_details($comp_id,$scale_id);
		$data="";
		$data="<div class='table-responsive'>
			<table cellpadding='1' cellspacing='1' class='table table-bordered table-striped'>
				<thead>
					<tr>
						<th class='col-sm-2'>Indicators Type</th>
						<th class='col-sm-10'>Indicators</th>
					</tr>
				</thead>
				<tbody>";
				foreach($indicators as $indicator){
					$data.="<tr>
						<td>".$indicator['ind_master_name']."</td>
						<td>".$indicator['comp_def_level_ind_name']."</td>
					</tr>";
				}
				$data.="</tbody>
			</table>
		</div>";
		echo $data;
	}
	
	////Start of Organization data migration/////	

	public function org_data_migration(){
		$data["aboutpage"]=$this->pagedetails('admin','org_migration');
		$data['po_orgs']=UlsOrganizationMaster::parent_orgs();
		$content = $this->load->view('admin/lms_admin_datamigration_org',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function org_data_migrate(){
		$this->sessionexist();           
		$data = array();            
		if(isset($_GET['files'])){	
			$error = false;
			$files = '';
			//$uploaddir = 'public/uploads/abc/';
			foreach($_FILES as $file){
//                    if(move_uploaded_file($file['tmp_name'], $uploaddir .basename($file['name']))){
//                        $files[] = $uploaddir .$file['name'];
//                    }
//                    else{
//                        $error = true;
//                    }
				if(!empty($file['tmp_name'])){
					$fieldseparator = ",";
					$lineseparator = "\n";
					$csvfile = $file['tmp_name'];
					$addauto = 0;
					$save = 1;
					$outputfile = "output.sql";
					if(!file_exists($csvfile)) {
						echo "File not found. Make sure you specified the correct path.\n";
					exit;
					}
					$file = fopen($csvfile,"r");
					if(!$file) {
						echo "Error opening data file.\n";
						exit;
					}
					$size = filesize($csvfile);
					if(!$size) {
						echo "File is empty.\n";
						exit;
					}
					$csvcontent = fread($file,$size);
					$linearray = array();
					$qu = "";
					$qu .= "<div id='orguploaddata' style='width: 1082px;'><table class='table table-striped table-bordered table-hover' style='margin-bottom:0px; border-bottom:none;'>";
					$qu .= "<thead><tr><th style='width:30px;'>Sno</th><th style='width:150px;'>Organization Name</th><th style='width:77px;'>Organization Type</th><th style='width:101px;'>Remarks</th></tr></thead></table></div><div id='innerdata' style='width:1100px; height: 250px; overflow:auto;'><table id='org_data' class='table table-striped table-bordered table-hover' style='margin-top:0px; border-top:none; width: 1082px;'>";
					$parent_org_id=$_REQUEST['parent_org_id'];
					$orgtypequery="select REPLACE(value_code,' ','') as value_code from uls_admin_values where master_code='ORG_TYPE'";
					$orgtyperow=UlsMenu::callpdo($orgtypequery);
					foreach($orgtyperow as $val){
						$checkorgtype[$val['value_code']]=($val['value_code']);
					}
					$orgsubtypequery="select REPLACE(value_code,' ','') as value_code from uls_admin_values where master_code='ORG_SUB_TYPE'";
					$orgsubtyperow=UlsMenu::callpdo($orgsubtypequery);
					foreach($orgsubtyperow as $val){
						$checkorgsubtype[$val['value_code']]=($val['value_code']);
					}
					$locquery="select location_id,REPLACE(location_name,' ','') as location_name from uls_location where parent_org_id='$parent_org_id' and status='A' and start_date_active<='".date('Y-m-d')."' and (end_date_active>='".date('Y-m-d')."' or end_date_active is null)";
					$locrow=UlsMenu::callpdo($locquery);
					foreach($locrow as $val){
						$checkloc[$val['location_id']]=($val['location_name']);
					}
					$hodquery="select employee_id,REPLACE(employee_number,' ','') as employee_number from uls_employee_master where parent_org_id='$parent_org_id'";
					$hodrow=UlsMenu::callpdo($hodquery);
					foreach($hodrow as $val){
						$checkhod[$val['employee_id']]=$val['employee_number'];
					}
					$x=0;                    
					foreach(explode($lineseparator,$csvcontent) as $key=>$line) {
						if($key>0){						
							$line = trim($line," \t");
							$line = str_replace("\r","",$line);
							$line = str_replace("'","\'",$line);
							$linearray = str_getcsv($line, ',');//explode($fieldseparator,$line);
							$linemysql = implode("','",$linearray);							
							
							if(count($linearray)>1 && !empty($linearray[0]) &&!empty($linearray[1])){
								$org_name=(!empty($linearray[0]))?$linearray[0]:'';
								$org_type=(!empty($linearray[1]))?$linearray[1]:'';
								$org_sub_type=(!empty($linearray[2]))?$linearray[2]:'';
								$manager=(!empty($linearray[3]))?$linearray[3]:'';
								$location=(!empty($linearray[4]))?$linearray[4]:'';
								$startdt=(!empty($linearray[5]))?date('Y-m-d',strtotime($linearray[5])):date('Y-m-d');
								$enddt=(!empty($linearray[6]))?date('Y-m-d',strtotime($linearray[6])):NULL;
								
								$org_typ_cnt=0;$org_typ_id='';								
								if(!empty($org_type)){
									$trimed_org_type=str_replace(' ','',$org_type);
									$trimed_org_type=trim($trimed_org_type);
									if(in_array($trimed_org_type,$checkorgtype)){
										$org_typ_id=array_search($trimed_org_type,$checkorgtype);
										$org_typ_cnt=1;
									}
								}
								
								$org_sub_typ_cnt=0;$org_sub_typ_id='';								
								if(!empty($org_sub_type)){
									$trimed_org_sub_type=str_replace(' ','',$org_sub_type);
									$trimed_org_sub_type=trim($trimed_org_sub_type);
									if(in_array($trimed_org_sub_type,$checkorgsubtype)){
										$org_sub_typ_id=array_search($trimed_org_sub_type,$checkorgsubtype);
										$org_sub_typ_cnt=1;
									}
								}
								
								$mgr_cnt=0;$mgr_id='';								
								if(!empty($manager)){
									$trimed_manager=str_replace(' ','',$manager);
									$trimed_manager=strtolower($trimed_manager);
									if(in_array($trimed_manager,$checkhod)){
										$mgr_id=array_search($trimed_manager,$checkhod);
										$mgr_cnt=1;
									}
								}
								
								$loc_cnt=0;$loc_id='';							
								if(!empty($location)){
									$trimed_loc=str_replace(' ','',$location);
									$trimed_loc=trim($trimed_loc);
									if(in_array($trimed_loc,$checkloc)){
										$loc_id=array_search($trimed_loc,$checkloc);
										$loc_cnt=1;
									}
								}
								$exist_data="";
								if((empty($org_type) || $org_typ_cnt>0) && (empty($org_sub_type) || $org_sub_typ_cnt>0) && (empty($manager) || $mgr_cnt>0) && (empty($location) || $loc_cnt>0) && (!empty($org_name))){
									$org_sub_typ_id=!empty($org_sub_typ_id)?$org_sub_typ_id:'I';
									$loc_id=!empty($loc_id)?$loc_id:NULL;
									$mgr_id=!empty($mgr_id)?$mgr_id:NULL;
									
									$check_org_name=UlsOrganizationMaster::orgnamesformigration($org_name,$parent_org_id);
									if(isset($check_org_name['organization_id'])){
										$organization_name=Doctrine_Core::getTable('UlsOrganizationMaster')->find($check_org_name['organization_id']);
										$organization_name->parent_org_id=$parent_org_id;
										$organization_name->org_name=$org_name;
										$organization_name->org_type=$org_typ_id;
										$organization_name->org_type1=$org_sub_typ_id;
										$organization_name->location=$loc_id;
										$organization_name->org_manager=$mgr_id;
										$organization_name->start_date=$startdt;
										$organization_name->end_date=$enddt;
										$organization_name->save();	
										$exist_data="<font color='orange'>Organization Updated</font>";
									}
									else{
										$organization_name=new UlsOrganizationMaster();
										$organization_name->parent_org_id=$parent_org_id;
										$organization_name->org_name=$org_name;
										$organization_name->org_type=$org_typ_id;
										$organization_name->org_type1=$org_sub_typ_id;
										$organization_name->location=$loc_id;
										$organization_name->org_manager=$mgr_id;
										$organization_name->start_date=$startdt;
										$organization_name->end_date=$enddt;
										$organization_name->save();	
										$exist_data="<font color='green'>Organization Uploaded Successfully</font>";
									}
								}
								if(!empty($org_type) && $org_typ_cnt==0){
									$exist_data.="<font color='RED'>Organization Type does not exists in Masters.</font> ";
								}
								if(!empty($org_sub_type) && $org_sub_typ_cnt==0){
									$exist_data.="<font color='RED'>Org Sub Type does not exists in Masters.</font> ";
								}
								if(!empty($manager) && $mgr_cnt==0){
									$exist_data.="<font color='RED'>Manager does not exists in Masters.</font> ";
								}
								if(!empty($location) && $loc_cnt==0){
									$exist_data.="<font color='RED'>Location does not exists in Masters.</font> ";
								}
								$qu .="<tr>";
								$qu .="<td style='padding-left:20px; width:39px;'>".$x."</td>";					
								$qu .="<td style='width:240px;'>".$linearray[0]."</td>";
								$qu .="<td style='width:129px;'>".$linearray[1]."</td>";
								$qu .="<td style='width:170px;'>".$exist_data."</td>";
								$qu .="</tr>";							
								
							}
						}$x++;
					}
					$qu .= "</table></div>";
					$qu .="<!--<div style='float:right;  margin-top:10px; margin-right:30px; margin-bottom:20px;'>
						<input type='button' class='btn btn-sm btn-success' value='Validate' id='org_valid' name='org_valid'>&nbsp;&nbsp;&nbsp;
						<input type='button' onclick='cancel_funct()' value='cancel' id='cancel' name='cancel' class='btn btn-sm btn-danger'></div>-->";
				}
				else{
					$error = true;
				}
			}
			$data = ($error) ? array('error' => 'There was an error uploading your files') : array($qu);
		}
		else{
			$data = array('success' => 'Form was submitted', 'formData' => $_POST);               
		} 
		echo json_encode($data);
	}
	
	////Start of Position data migration/////
	public function position_data_migration(){
		$data["aboutpage"]=$this->pagedetails('admin','position_migration');
		$data['po_orgs']=UlsOrganizationMaster::parent_orgs();
		$content = $this->load->view('admin/lms_admin_datamigration_position',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function position_data_migrate(){
		$this->sessionexist();
		$data = array();
		if(isset($_GET['files'])){
			$error = false;
			$files = '';$qu = "";
			foreach($_FILES as $file){
				if(!empty($file['tmp_name'])){
					$fieldseparator = ",";
					$lineseparator = "\n";
					$csvfile = $file['tmp_name'];
					$addauto = 0;
					$save = 1;
					$outputfile = "output.sql";
					if(!file_exists($csvfile)) {
						echo "File not found. Make sure you specified the correct path.\n";
					exit;
					}
					$file = fopen($csvfile,"r");
					if(!$file) {
						echo "Error opening data file.\n";
						exit;
					}
					$size = filesize($csvfile);
					if(!$size) {
						echo "File is empty.\n";
						exit;
					}
					$csvcontent = fread($file,$size);					
					$linearray = array();
					
					$qu .= "<div id='positionuploaddata' style='width: 1082px;'><table class='table table-striped table-bordered table-hover' style='margin-bottom:0px; border-bottom:none;'>";
					$qu .= "<thead><tr><th style='width:30px;'>Sno</th><th style='width:77px;'>Position</th><th style='width:101px;'>Comments</th></tr></thead></table></div>
							<div id='innerdata' style='width:1100px; height: 250px; overflow:auto;'><table id='grades_data' class='table table-striped table-bordered table-hover' style='margin-top:0px; border-top:none; width: 1082px;'>"; 
					$x=0;
					foreach(explode($lineseparator,$csvcontent) as $key=>$line) {
						if($key>0){							
							$line = trim($line," \t");
							$line = str_replace("\r","",$line);
							$line = str_replace("'","\'",$line);
							$linearray = explode($fieldseparator,$line);
							$linemysql = implode("','",$linearray);							
							$parent_org_id=$_REQUEST['parent_org_id'];
							if(count($linearray)>0){
								$check_orgforpos=UlsPosition::orgnamesformigration($linearray[0],$parent_org_id);//$linearray[0],
								if(count($check_orgforpos)>0){
									$exist_data="<font color='red'>Position Name Already Exists</font>";	
								}
								else{
									/* $exist_data="checking";
									$check_pos=UlsPosition::positionmigration($linearray[0],$parent_org_id);
									//$linearray[0],
									if(count($check_pos)>0){								
										foreach($check_pos as $check_orgpos){
											if($check_orgpos['position_org_id']==NULL){ */
											if(!empty($linearray[0])){
												$position_name=new UlsPosition();
												$position_name->parent_org_id=$parent_org_id;
												$position_name->position_org_id=NULL;//$check_orgpos['organization_id'];
												$position_name->position_name=$linearray[0];
												$position_name->organization_id=NULL;
												$position_name->start_date_active=date('Y-m-d');
												$position_name->end_date_active=NULL;
												$position_name->status='A';
												$position_name->save();
												
												$exist_data="<font color='green'>Position Uploaded Successfully</font>";
											}
											else{
												$exist_data="<font color='red'>Position Name is Empty</font>";
											}
											/* }
											else{
												$exist_data="<font color='red'>Organization Not Available in Database</font>";
											}
										}
									}
									else{
										$exist_data="<font color='red'>Organization Not Available in Database</font>";
									}		 */							
								}
								$qu .= "<tr>";
								$qu .="<td style='padding-left:20px; width:39px;'>".$x."</td>";
								$qu .="<td style='width:240px;'>".$linearray[0]."</td>";
								//$qu .="<td style='width:129px;'>".$linearray[1]."</td>";
								$qu .="<td style='width:170px;'>".$exist_data."</td>";
								$qu .= "</tr>";							
							}
						}$x++;
					}
					$qu .= "</table></div>";
					$qu .="<!--<div style='float:right;  margin-top:10px; margin-right:30px; margin-bottom:20px;'>
						<input type='button' class='btn btn-sm btn-success' value='Validate' id='org_valid' name='org_valid'>&nbsp;&nbsp;&nbsp;
						<input type='button' onclick='cancel_funct()' value='cancel' id='cancel' name='cancel' class='btn btn-sm btn-danger'></div>-->";
				}
				else{
					$error = true;
				}
			}
			$data = ($error) ? array('error' => 'There was an error uploading your files') : array($qu);
		}
		else{
			$data = array('success' => 'Form was submitted', 'formData' => $_POST);               
		} 
		echo json_encode($data);
	}
	
	////Start of Grades data migration/////
	public function grades_data_migration(){
		$data["aboutpage"]=$this->pagedetails('admin','grade_migration');
		$data['po_orgs']=UlsOrganizationMaster::parent_orgs();
		$content = $this->load->view('admin/lms_admin_datamigration_grades',$data,true);
		$this->render('layouts/adminnew',$content);
	}	
	public function grades_data_migrate(){
		$this->sessionexist();           
		$data = array();            
		if(isset($_GET['files'])){	
			$error = false;
			$files = '';
			//$uploaddir = 'public/uploads/abc/';
			foreach($_FILES as $file){
//                    if(move_uploaded_file($file['tmp_name'], $uploaddir .basename($file['name']))){
//                        $files[] = $uploaddir .$file['name'];
//                    }
//                    else{
//                        $error = true;
//                    }
				if(!empty($file['tmp_name'])){
					$fieldseparator = ",";
					$lineseparator = "\n";
					$csvfile = $file['tmp_name'];
					$addauto = 0;
					$save = 1;
					$outputfile = "output.sql";
					if(!file_exists($csvfile)) {
						echo "File not found. Make sure you specified the correct path.\n";
					exit;
					}
					$file = fopen($csvfile,"r");
					if(!$file) {
						echo "Error opening data file.\n";
						exit;
					}
					$size = filesize($csvfile);
					if(!$size) {
						echo "File is empty.\n";
						exit;
					}
					$csvcontent = fread($file,$size);
					$linearray = array();
					$qu = "";
					$qu .= "<div id='gradesuploaddata' style='width: 1082px;'><table class='table table-striped table-bordered table-hover' style='margin-bottom:0px; border-bottom:none;'>";
					$qu .= "<thead><tr><th style='width:30px;'>Sno</th><th style='width:150px;'>Grades</th><th style='width:101px;'>Comments</th></tr></thead></table></div>
							<div id='innerdata' style='width:1100px; height: 250px; overflow:auto;'><table id='grades_data' class='table table-striped table-bordered table-hover' style='margin-top:0px; border-top:none; width: 1082px;'>"; 
					$x=0;
					foreach(explode($lineseparator,$csvcontent) as $key=>$line) {
						if($key>0){							
							$line = trim($line," \t");
							$line = str_replace("\r","",$line);
							$line = str_replace("'","\'",$line);
							$linearray = explode($fieldseparator,$line);
							$linemysql = implode("','",$linearray);							
							$parent_org_id=$_REQUEST['parent_org_id'];
							if(count($linearray)>0){
								if(!empty($linearray[0])){
									$check_grade=UlsGrade::gradenamesformigration($linearray[0],$parent_org_id);
									if(count($check_grade)>0){
										$exist_data="<font color='red'>Grade Name Already Exists</font>";
									}
									else{ 
										$organization_name=new UlsGrade();
										$organization_name->parent_org_id=$parent_org_id;
										$organization_name->grade_name=$linearray[0];
										$organization_name->comments=NULL;
										$organization_name->start_date_active=date('Y-m-d');
										$organization_name->end_date_active=NULL;
										$organization_name->status='A';
										$organization_name->save();	
										$exist_data="<font color='green'>Grade Uploaded Successfully</font>";									
									}
									$qu .= "<tr>";
									$qu .="<td style='padding-left:20px; width:39px;'>".$x."</td>";
									$qu .="<td style='width:240px;'>".$linearray[0]."</td>";								
									$qu .="<td style='width:170px;'>".$exist_data."</td>";
									$qu .= "</tr>";		
								}								
							}
						}$x++;
					}
					$qu .= "</table></div>";
					$qu .="<!--<div style='float:right;  margin-top:10px; margin-right:30px; margin-bottom:20px;'>
						<input type='button' class='btn btn-sm btn-success' value='Validate' id='org_valid' name='org_valid'>&nbsp;&nbsp;&nbsp;
						<input type='button' onclick='cancel_funct()' value='cancel' id='cancel' name='cancel' class='btn btn-sm btn-danger'></div>-->";
				}
				else{
					$error = true;
				}
			}
			$data = ($error) ? array('error' => 'There was an error uploading your files') : array($qu);
		}
		else{
			$data = array('success' => 'Form was submitted', 'formData' => $_POST);               
		} 
		echo json_encode($data);
	}
	
	////Start of Employee personal data migration/////
	public function emppersonal_data_migration(){
		$data["aboutpage"]=$this->pagedetails('admin','emppersonal_migration');
		$data['po_orgs']=UlsOrganizationMaster::parent_orgs();
		$content = $this->load->view('admin/lms_admin_datamigration_emppersonal',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function emppersonal_data_migrate(){
		$this->sessionexist();           
		$data = array();            
		if(isset($_GET['files'])){	
			$error = false;
			$files = '';$qu = "";
			foreach($_FILES as $file){
				if(!empty($file['tmp_name'])){
					$fieldseparator = ",";
					$lineseparator = "\n";
					$csvfile = $file['tmp_name'];
					$addauto = 0;
					$save = 1;
					if(!file_exists($csvfile)) {
						echo "File not found. Make sure you specified the correct path.\n";
						exit;
					}
					$file = fopen($csvfile,"r");
					if(!$file) {
						echo "Error opening data file.\n";
						exit;
					}
					$size = filesize($csvfile);
					if(!$size) {
						echo "File is empty.\n";
						exit;
					}
					$csvcontent = fread($file,$size);
					$linearray = array();
					$qu .= "<div id='emppersonaluploaddata' style='width: 1082px;'><table class='table table-striped table-bordered table-hover' style='margin-bottom:0px; border-bottom:none;'>";
					$qu .= "<thead><tr><th style='width:40px;'>Sno</th><th style='width:87px;'>Employee Number</th><th style='width:150px;'>Employee Name</th><th style='width:107px;'>Comments</th></tr></thead></table></div><div id='innerdata' style='width:1100px; height: 250px; overflow:auto;'><table id='emppersonal_data' class='table table-striped table-bordered table-hover' style='margin-top:0px; border-top:none; width:1082px;'>";
					$x=0;
					$checkgender=$checktitle=array();
					$parent_org_id=$_REQUEST['parent_org_id'];
					$menuroleuserquery="select r.role_name, r.role_id, group_concat(mn.menu_id) as menu_id from uls_role_creation r 
					INNER JOIN uls_menu_creation m on m.menu_creation_id=r.menu_id and m.system_menu_type='emp'
					INNER JOIN uls_menu	mn on mn.menu_creation_id=m.menu_creation_id
					where r.parent_org_id='$parent_org_id'";
					$menuroleuser=UlsMenu::callpdorow($menuroleuserquery);
					$gendquery="select REPLACE(value_code,' ','') as value_code from uls_admin_values where master_code='GENDAR'";
					$genderrow=UlsMenu::callpdo($gendquery);
					foreach($genderrow as $val){
						$checkgender[]=$val['value_code'];
					}
					$titlequery="select REPLACE(value_code,' ','') as value_code from uls_admin_values where master_code='TITLE'";
					$genderrow=UlsMenu::callpdo($titlequery);
					foreach($genderrow as $val){
						$checktitle[]=$val['value_code'];
					}
					//code for checking employee category and employee type
					$emptypequery="select emp_type_id,emp_type_name from uls_employee_type where parent_org_id='$parent_org_id'";
					$emptyperow=UlsMenu::callpdo($emptypequery);
					foreach($emptyperow as $val){
						$checkemptype[$val['emp_type_id']]=str_replace(' ','',$val['emp_type_name']);
					}
					
					$empcatquery="select emp_cat_id,emp_cat_name from uls_employee_category where parent_org_id='$parent_org_id'";
					$empcatrow=UlsMenu::callpdo($empcatquery);
					foreach($empcatrow as $val){
						$checktempcat[$val['emp_cat_id']]=str_replace(' ','',$val['emp_cat_name']);
					}
					
					foreach(explode($lineseparator,$csvcontent) as $key=>$line) {
						
						if($key>0){
							/* echo "<pre>";
							print_r($line); */
							
							$line = trim($line," \t");
							$line = str_replace("\r","",$line);
							$line = str_replace("'","\'",$line);
							$linearray = explode($fieldseparator,$line);
							$linemysql = implode("','",$linearray);							
							
							if(count($linearray)>1){
								$gendr=0;
								if(!empty($linearray[3])){
									$trimed_gend=str_replace(' ','',$linearray[3]);
									$trimed_gend=trim($trimed_gend);
									if(in_array($trimed_gend,$checkgender)){
										$gendr=1;
									}
								}
								$titl=0;
								if(!empty($linearray[4])){
									$trimed_tit=str_replace(' ','',$linearray[4]);
									$trimed_tit=trim($trimed_tit);
									if(in_array($trimed_tit,$checktitle)){
										$titl=1;
									}
								}
								$emptype=0;$emptype_code='';
								
								if(!empty($linearray[12])){
									$trimed_emptype=str_replace(' ','',$linearray[12]);
									$trimed_emptype=trim($trimed_emptype);
									//echo $trimed_emptype;
									if(in_array($trimed_emptype,$checkemptype)){
										$emptype_code=array_search($trimed_emptype,$checkemptype);
										$emptype=1;
									}
								}
								
								$empcat=0;$empcat_code='';
								if(!empty($linearray[13])){
									$trimed_cattype=str_replace(' ','',$linearray[13]);
									$trimed_cattype=trim($trimed_cattype);
									if(in_array($trimed_cattype,$checktempcat)){
										$empcat_code=array_search($trimed_cattype,$checktempcat);
										$empcat=1;
									}
								}
								
								if($gendr>0 && $titl>0 && $emptype>0 && $empcat>0){
									$check_emp_name=UlsEmployeeMaster::emppersonal_numformigration(trim($linearray[0]),$parent_org_id);
									$fname=(!empty($linearray[2]))?$linearray[2]:$linearray[1];
									$doj=(!empty($linearray[5]))?date('Y-m-d',strtotime($linearray[5])):NULL;
									$dob=(!empty($linearray[6]))?date('Y-m-d',strtotime($linearray[6])):NULL;
									$prev_exp=(!empty($linearray[7]))?$linearray[7]:'';
									$edu_qual=(!empty($linearray[8]))? str_replace('*',',',$linearray[8]):'';
									$ofc_no=(!empty($linearray[10]))?$linearray[10]:'';
									$email=(!empty($linearray[11]))?$linearray[11]:'';
									//echo "date of birth : ".$dob;
									if(isset($check_emp_name['employee_id'])){
										$empdetails_update=Doctrine_Core::getTable('UlsEmployeeMaster')->find($check_emp_name['employee_id']);
										$empdetails_update->parent_org_id=$parent_org_id;
										$empdetails_update->emp_cat=$empcat_code;
										$empdetails_update->emp_type=$emptype_code;
										$empdetails_update->employee_number=trim($linearray[0]);
										$empdetails_update->full_name=trim($linearray[1]);
										$empdetails_update->first_name=$fname;
										$empdetails_update->gender=trim($linearray[3]);
										$empdetails_update->title=trim($linearray[4]);
										$empdetails_update->date_of_birth=$dob;
										$empdetails_update->date_of_joining=$doj;
										$empdetails_update->previous_exp=$prev_exp;
										$empdetails_update->edu_qualification=$edu_qual;
										$empdetails_update->office_number=$ofc_no;
										$empdetails_update->email=$email;
										$empdetails_update->save();
										
										if(!empty($check_emp_name['user_id']) && !empty($check_emp_name['employee_id'])){
											$doj=empty($doj)?date("Y-m-d"):$doj;
											$empdetails_update2=Doctrine_Query::Create()->update('UlsUserCreation');
											$empdetails_update2->set('user_name','?',$linearray[0]);
											$empdetails_update2->set('email_address','?',$email);
											$empdetails_update2->set('start_date','?',$doj);
											$empdetails_update2->where('user_name=?',$linearray[0]);
											$empdetails_update2->andwhere('parent_org_id=?',$parent_org_id);
											$empdetails_update2->andwhere('employee_id=?',$check_emp_name['employee_id']);
											$empdetails_update2->limit(1)->execute();
											
										
											$empdetails_update3=Doctrine_Query::Create()->update('UlsUserRole');
											$empdetails_update3->set('role_id','?',$menuroleuser['role_id']);
											$empdetails_update3->set('menu_id','?',$menuroleuser['menu_id']);
											$empdetails_update3->set('start_date','?',$doj);
											$empdetails_update3->where('user_id=?',$check_emp_name['user_id']);
											$empdetails_update3->andwhere('parent_org_id=?',$parent_org_id);
											$empdetails_update3->andwhere('role_id=?',$menuroleuser['role_id']);
											$empdetails_update3->limit(1)->execute();
											
											
										}
										
										$exist_data="<font color='orange'>Employee Data Updated</font>";									
									
										//$exist_data="<font color='orange'>Employee Number Already Exists</font>";									
									}
									else{
										
										$employee_data=new UlsEmployeeMaster();
										$employee_data->parent_org_id=$parent_org_id;
										$employee_data->emp_cat=$empcat_code;
										$employee_data->emp_type=$emptype_code;
										$employee_data->employee_number=$linearray[0];
										$employee_data->full_name=$linearray[1];
										$employee_data->first_name=$fname;
										$employee_data->gender=$linearray[3];
										$employee_data->title=$linearray[4];
										$employee_data->date_of_birth=$dob;
										$employee_data->date_of_joining=$doj;
										$employee_data->previous_exp=$prev_exp;
										$employee_data->edu_qualification=$edu_qual;
										$employee_data->office_number=$ofc_no;
										$employee_data->email=$email;
										$employee_data->current_employee_flag='C';
										$employee_data->nationality='India';							
										$employee_data->save();
										
										$usercreate=new UlsUserCreation();
										$usercreate->parent_org_id=$parent_org_id;
										$usercreate->employee_id=$employee_data->employee_id;
										$usercreate->user_name=$linearray[0];
										$usercreate->email_address=$email;
										$usercreate->password="welcome";
										$usercreate->user_login=1;
										$usercreate->user_type="EMP";
										$usercreate->start_date=$doj;
										$usercreate->save();
										
										$userrolecreate=new UlsUserRole();
										$userrolecreate->user_id=$usercreate->user_id;
										$userrolecreate->role_id=$menuroleuser['role_id'];
										$userrolecreate->menu_id=$menuroleuser['menu_id'];
										$userrolecreate->parent_org_id=$parent_org_id;
										$userrolecreate->start_date=$doj;
										$userrolecreate->save();
										$exist_data="<font color='green'>Employee Details Uploaded Successfully</font>";									
									}
								}else{$exist_data="";
								
									if($titl==0){
										$exist_data.="<font color='red'>Title does not exists in Masters</font></br>";
									}else if($gendr==0){
										$exist_data.="<font color='red'>Gender does not exists in Masters</font></br>";
									}
									else if($emptype==0){
										$exist_data.="<font color='red'>Employee type does not exists in Masters</font></br>";
									}
									else if($empcat==0){
										$exist_data.="<font color='red'>Employee category does not exists in Masters</font></br>";
									}
								}
								$empnumber=(!empty($linearray[0]))?$linearray[0]:NULL;
								$empname=(!empty($linearray[1]))?$linearray[1]:NULL;
								$qu .= "<tr>";
								$qu .="<td style='padding-left:20px; width:64px;'>".$x."</td>";					
								$qu .="<td style='width:139px;'>".$empnumber."</td>";
								$qu .="<td style='width:240px;'>".$empname."</td>";
								$qu .="<td style='width:170px;'>".$exist_data."</td>";
								$qu .= "</tr>";							
							}
						}$x++;
					}
					$qu .= "</table></div>";
					$qu .="<!--<div style='float:right;  margin-top:10px; margin-right:30px; margin-bottom:20px;'>
						<input type='button' class='btn btn-sm btn-success' value='Validate' id='org_valid' name='org_valid'>&nbsp;&nbsp;&nbsp;
						<input type='button' onclick='cancel_funct()' value='cancel' id='cancel' name='cancel' class='btn btn-sm btn-danger'></div>-->";
				}
				else{
					$error = true;
				}
			}
			$data = ($error) ? array('error' => 'There was an error uploading your files') : array($qu);
			//print_r($data);
		}
		else{
			$data = array('success' => 'Form was submitted', 'formData' => $_POST);               
		} 
		//exit();
		echo json_encode($data);
	}

	
	//Start of Employee Work Details migration
	public function empworkinfo_data_migration(){
		$data["aboutpage"]=$this->pagedetails('admin','empworkinfo_migration');
		$data['po_orgs']=UlsOrganizationMaster::parent_orgs();
		$content = $this->load->view('admin/lms_admin_datamigration_empworkinfo',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function empworkinfo_data_migrate(){
		global $con;
		$this->sessionexist();           
		$data = array();            
		if(isset($_GET['files'])){	
			$error = false;
			$files = '';$qu="";
			foreach($_FILES as $file){
				if(!empty($file['tmp_name'])){
					$fieldseparator = ",";
					$lineseparator = "\n";
					$csvfile = $file['tmp_name'];
					$addauto = 0;
					$save = 1;
					if(!file_exists($csvfile)) {
						echo "File not found. Make sure you specified the correct path.\n";
					exit;
					}
					$file = fopen($csvfile,"r");
					if(!$file) {
						echo "Error opening data file.\n";
						exit;
					}
					$size = filesize($csvfile);
					if(!$size) {
						echo "File is empty.\n";
						exit;
					}
					$csvcontent = fread($file,$size);
					$linearray = array();
					
					$qu = "";
					$qu .= "<div id='empworkinfouploaddata' style='width: 1082px;'><table class='table table-striped table-bordered table-hover' style='margin-bottom:0px; border-bottom:none;'>";
					$qu .= "<thead><tr><th style='width:30px;'>Sno</th><th style='width:77px;'>Employee Number</th><th style='width:150px;'>Employee Name</th><th style='width:101px;'>Comments</th></tr></thead></table></div><div id='innerdata' style='width:1100px; height: 250px; overflow:auto;'><table id='emppersonal_data' class='table table-striped table-bordered table-hover' style='margin-top:0px; border-top:none; width:1082px;'>";
					
					$parent_org_id=$_REQUEST['parent_org_id'];
					$orgquery="select organization_id, REPLACE(org_name,' ','') as org_name, parent_org_id from uls_organization_master where parent_org_id='$parent_org_id'";
					$orgrow=UlsMenu::callpdo($orgquery);
					foreach($orgrow as $val){						
						$checkorg[$val['organization_id']]=strtolower($val['org_name']);
					}
					$posquery="select position_id,REPLACE(position_name,' ','') as position_name from uls_position where parent_org_id='$parent_org_id' and status='A' and start_date_active<='".date('Y-m-d')."' and (end_date_active>='".date('Y-m-d')."' or end_date_active is null)";
					$posrow=UlsMenu::callpdo($posquery);
					foreach($posrow as $val){						
						$checkpos[$val['position_id']]=strtolower($val['position_name']);
					}
					$gradequery="select grade_id,REPLACE(grade_name,' ','') as grade_name from uls_grade where parent_org_id='$parent_org_id' and status='A' and start_date_active<='".date('Y-m-d')."' and (end_date_active>='".date('Y-m-d')."' or end_date_active is null)";
					$graderow=UlsMenu::callpdo($gradequery);
					foreach($graderow as $val){
						$checkgrade[$val['grade_id']]=strtolower($val['grade_name']);
					}
					$subgradequery="select grade_id,sub_grade_id,REPLACE(sub_grade_name,' ','') as sub_grade_name from uls_sub_grades where parent_org_id='$parent_org_id' and grade_status='A'";
					$subgraderow=UlsMenu::callpdo($subgradequery);
					foreach($subgraderow as $val){
						$checksubgrade[$val['sub_grade_id']]=$val['grade_id']."*".strtolower($val['sub_grade_name']);
					}
					$locquery="select location_id,state,location_zones,REPLACE(location_name,' ','') as location_name from uls_location where parent_org_id='$parent_org_id' and status='A' and start_date_active<='".date('Y-m-d')."' and (end_date_active>='".date('Y-m-d')."' or end_date_active is null)";
					$locrow=UlsMenu::callpdo($locquery);
					$zone=$state=array();
					foreach($locrow as $val){
						$checkloc[$val['location_id']]=strtolower($val['location_name']);
						$zone[$val['location_id']]=$val['location_zones'];
						$state[$val['location_id']]=$val['state'];
					}
					$hodquery="select employee_id,REPLACE(employee_number,' ','') as employee_number from uls_employee_master where parent_org_id='$parent_org_id'";
					$hodrow=UlsMenu::callpdo($hodquery);
					foreach($hodrow as $val){
						$checkhod[$val['employee_id']]=$val['employee_number'];
					}
					$buquery="select organization_id,REPLACE(org_name,' ','') as org_name from uls_organization_master where org_type='BU' and parent_org_id='$parent_org_id'";
					$burow=UlsMenu::callpdo($buquery);
					foreach($burow as $val){
						$checkbu[$val['organization_id']]=strtolower($val['org_name']);
					}
					$pdquery="select organization_id,REPLACE(org_name,' ','') as org_name from uls_organization_master where org_type='PD' and parent_org_id='$parent_org_id'";
					$pdrow=UlsMenu::callpdo($pdquery);
					foreach($pdrow as $val){
						$checkpd[$val['organization_id']]=strtolower($val['org_name']);
					}
					$divquery="select organization_id,REPLACE(org_name,' ','') as org_name from uls_organization_master where org_type='DEV' and parent_org_id='$parent_org_id'";
					$divrow=UlsMenu::callpdo($divquery);
					foreach($divrow as $val){
						$checkdiv[$val['organization_id']]=strtolower($val['org_name']);
					}
					
					
					$sysdate=date('Y-m-d');$x=0;$date_arr=array();$key_arr=array();
					foreach(explode($lineseparator,$csvcontent) as $key=>$line) {
						if($key>0){							
							$line = trim($line," \t");
							$line = str_replace("\r","",$line);
							$line = str_replace("'","\'",$line);
							$linearray = explode($fieldseparator,$line);
							//$linearray =  str_getcsv($line, ',');
							$linemysql = implode("','",$linearray);							
							
							if(count($linearray)>1){
								$emp_name=(!empty($linearray[1]))?trim($linearray[1]):'';
								$org=(!empty($linearray[2]))?trim($linearray[2]):'';
								$position=(!empty($linearray[3]))?trim($linearray[3]):'';
								$grade=(!empty($linearray[4]))?trim($linearray[4]):'';
								$subgrade=(!empty($linearray[5]))?trim($linearray[5]):'';
								$location=(!empty($linearray[6]))?trim($linearray[6]):'';
								$from_date=(!empty($linearray[7]))?date('Y-m-d', strtotime($linearray[7])):'';
								//$to_date=(!empty($linearray[7]))?date('Y-m-d', strtotime($linearray[7])):'';
								$supervisor=(!empty($linearray[9]))?trim($linearray[9]):'';
								if((!empty($linearray[8])) && ($linearray[8]=='ACTIVE' || $linearray[8]=='A' || $linearray[8]=='Active')){$status='A';} else{ $status='I';}
								$bus=(!empty($linearray[10]))?trim($linearray[10]):'';
								$pds=(!empty($linearray[11]))?trim($linearray[11]):'';
								$divs=(!empty($linearray[12]))?trim($linearray[12]):'';
								$org_cnt=0;$org_id='';
								if(!empty($org)){
									$trimed_orgname=str_replace(' ','',$org);
									$trimed_orgname=strtolower($trimed_orgname);
									if(in_array($trimed_orgname,$checkorg)){
										$org_id=array_search($trimed_orgname,$checkorg);
										$org_cnt=1;
									}
									
								}
								$pos_cnt=0;$pos_id='';
								if(!empty($position)){
									$trimed_pos=str_replace(' ','',$position);
									$trimed_pos=strtolower($trimed_pos);
									if(in_array($trimed_pos,$checkpos)){
										$pos_id=array_search($trimed_pos,$checkpos);
										$pos_cnt=1;
									}
								}
								$grd_cnt=0;$grd_id='';
								if(!empty($grade)){
									$trimed_grade=str_replace(' ','',$grade);
									$trimed_grade=strtolower($trimed_grade);
									if(in_array($trimed_grade,$checkgrade)){
										$grd_id=array_search($trimed_grade,$checkgrade);
										$grd_cnt=1;
									}
								}
								$subgrd_cnt=0;$subgrd_id='';
								if(!empty($subgrade)){
									$trimed_subgrade=str_replace(' ','',$subgrade);
									$trimed_subgrade=$grd_id."*".strtolower($trimed_subgrade);
									if(in_array($trimed_subgrade,$checksubgrade)){
										$subgrd_id=array_search($trimed_subgrade,$checksubgrade);
										$subgrd_cnt=1;
									}
								}
								$loc_cnt=0;$loc_id='';
								if(!empty($location)){
									$trimed_loc=str_replace(' ','',$location);
									$trimed_loc=strtolower($trimed_loc);
									if(in_array($trimed_loc,$checkloc)){
										$loc_id=array_search($trimed_loc,$checkloc);
										$loc_cnt=1;
									}
								}
								$sup_cnt=0;$sup_id='';
								if(!empty($supervisor)){
									$trimed_sup=str_replace(' ','',$supervisor);
									if(in_array($trimed_sup,$checkhod)){
										$sup_id=array_search($trimed_sup,$checkhod);
										$sup_cnt=1;
									}
								}
								$bu_cnt=0;$bu_id='';
								if(!empty($bus)){
									$trimed_bu=str_replace(' ','',$bus);
									$trimed_bu=strtolower($trimed_bu);
									if(in_array($trimed_bu,$checkbu)){
										$bu_id=array_search($trimed_bu,$checkbu);
										$bu_cnt=1;
									}
								}
								$pd_cnt=0;$pd_id='';
								if(!empty($pds)){
									$trimed_pd=str_replace(' ','',$pds);
									$trimed_pd=strtolower($trimed_pd);
									if(in_array($trimed_pd,$checkpd)){
										$pd_id=array_search($trimed_pd,$checkpd);
										$pd_cnt=1;
									}
								}
								$div_cnt=0;$div_id='';
								if(!empty($divs)){
									$trimed_div=str_replace(' ','',$divs);
									$trimed_div=strtolower($trimed_div);
									if(in_array($trimed_div,$checkdiv)){
										$div_id=array_search($trimed_div,$checkdiv);
										$div_cnt=1;
									}
								}
								if((empty($org) || $org_cnt>0)){
									
									$creat=$_SESSION['username'];$created_date=date('Y-m-d');$last_modified_id=$_SESSION['user_id'];
									$zon=$sta="NULL";
									$pos=(!empty($pos_id))?"'".$pos_id."'":"NULL";
									$gd=(!empty($grd_id))?"'".$grd_id."'":"NULL";
									$sgd=(!empty($subgrd_id))?"'".$subgrd_id."'":"NULL";
									$loct=(!empty($loc_id))?"'".$loc_id."'":"NULL";
									if(!empty($loc_id)){
									$zon=(isset($zone[$loc_id]))?"'".$zone[$loc_id]."'":"NULL";
									$sta=(isset($state[$loc_id]))?"'".$state[$loc_id]."'":"NULL";
									}
									$supr=(!empty($sup_id))?"'".$sup_id."'":"NULL";
									$buids=(!empty($bu_id))?"'".$bu_id."'":"NULL";
									$pdids=(!empty($pd_id))?"'".$pd_id."'":"NULL";
									$divids=(!empty($div_id))?"'".$div_id."'":"NULL";
									
									$perdat="select employee_id, employee_number from uls_employee_master where parent_org_id='$parent_org_id' and employee_number='".$linearray[0]."'";
									$perdata=UlsMenu::callpdorow($perdat);									
									if(isset($perdata['employee_id'])){
										$empl_id=$perdata['employee_id'];
										$emid="select employee_id from uls_employee_work_info where parent_org_id='$parent_org_id' and employee_id='".$empl_id."'";
										$emwrk=UlsMenu::callpdorow($emid);									
										if(isset($emwrk['employee_id'])){
											$from_date=(!empty($linearray[7]))?date('Y-m-d', strtotime($linearray[7])):'';
											$update_emp_details=UlsEmployeeMaster::updateexistingdata_migration($linearray[0],$org,$position,$grade,$location,$supervisor,$from_date,$parent_org_id,$bus);
											if(count($update_emp_details)>0){
												$exist_data="<font color='red'>Employee Details Already Exists</font>";
											}
											else{
												$from_date=(!empty($linearray[7]))?date('Y-m-d', strtotime($linearray[7])):'';
												//$to_date=(!empty($linearray[7]))?date('Y-m-d', strtotime($linearray[7])):'';
												//echo $from_date; echo $status; echo ($pos=="NULL")?"Y":"N";
												
												$updat_emp="update uls_employee_work_info set org_id='$org_id', bu_id=$buids,parent_dep_id=$pdids,division_id=$divids,position_id=$pos, grade_id=$gd, sub_grade_id=$sgd, supervisor_id=$supr, location_id=$loct,zone_id=$zon,state_id=$sta, from_date='$from_date',status='$status' where employee_id='$empl_id' and parent_org_id='$parent_org_id'";
												$success3=UlsMenu::callexecute($updat_emp);
												//if($success3){
													$exist_data="<font color='blue'>Employee Details Updated Successfully</font>";
												//}
												//else{
													//$exist_data="<font color='error'>Please Contact Admin</font>";
												//}
																				
											}
										}else{
											$from_date=(!empty($linearray[7]))?date('Y-m-d', strtotime($linearray[7])):'';
											//$to_date=(!empty($linearray[7]))?date('Y-m-d', strtotime($linearray[7])):'';
											
											$insert_data="insert into uls_employee_work_info(employee_id, parent_org_id, org_id, bu_id, parent_dep_id, division_id, position_id, grade_id, sub_grade_id, supervisor_id, location_id,zone_id,state_id, from_date, status, created_date, created_by, modified_date, modified_by, last_modified_id) values ('$empl_id','$parent_org_id','$org_id',$buids,$pdids,$divids,$pos,$gd,$sgd,$supr,$loct,$zon,$sta,'$from_date','$status','$created_date','$creat','$created_date','$creat','$last_modified_id')";
											$success3=mysqli_query($con,$insert_data);							
											
											$exist_data="<font color='green'>Data Uploaded Successfully</font>";	
										}
									}else{
										$exist_data="<font color='green'>Employee personal data doesn't exist</font>";
									}
								}else{
									$exist_data="";
									if(!empty($org) && $org_cnt==0){
										$exist_data.="Organization does not exists in Masters. ";
									}
									if(!empty($position) && $pos_cnt==0){
										$exist_data.="Position does not exists in Masters. ";
									}
									if(!empty($grade) && $grd_cnt==0){
										$exist_data.="Grade does not exists in Masters. ";
									}
									if(!empty($subgrade) && $subgrd_cnt==0){
										$exist_data.="Sub Grade does not exists in Masters. ";
									}
									if(!empty($location) && $loc_cnt==0){
										$exist_data.="Location does not exists in Masters. ";
									}
									if(!empty($supervisor) && $sup_cnt==0){
										$exist_data.="Super does not exists in Masters. ";
									}
									if(!empty($bu_id) && $bu_cnt==0){
										$exist_data.="Business Unit does not exists in Masters. ";
									}
									if(!empty($pd_id) && $pd_cnt==0){
										$exist_data.="Parent Department does not exists in Masters. ";
									}
									if(!empty($div_id) && $div_cnt==0){
										$exist_data.="Divison does not exists in Masters. ";
									}	
								}
								
								
								
								$empnumber=(!empty($linearray[0]))?$linearray[0]:NULL;
								$empname=(!empty($linearray[1]))?$linearray[1]:NULL;
								$qu .= "<tr>";
								$qu .="<td style='padding-left:20px; width:63px;'>".$x."</td>";					
								$qu .="<td style='width:133px;'>".$empnumber."</td>";
								$qu .="<td style='width:255px;'>".$empname."</td>";
								$qu .="<td style='width:171px;color:red'>".$exist_data."</td>";
								$qu .= "</tr>";							
							}
						}$x++;
					}
					$y=0;
					foreach(explode($lineseparator,$csvcontent) as $key=>$line) {
						if($key>0){							
							$line = trim($line," \t");
							$line = str_replace("\r","",$line);
							$line = str_replace("'","\'",$line);
							$linearray = explode($fieldseparator,$line);
							//$linearray =  str_getcsv($line, ',');
							$linemysql = implode("','",$linearray);							
							$parent_org_id=$_REQUEST['parent_org_id'];
							if(count($linearray)>1){
								$empdata="select e.employee_id, e.employee_number, w.work_info_id, w.from_date, w.to_date from uls_employee_master e
								LEFT JOIN (select work_info_id, employee_id, from_date, to_date from uls_employee_work_info)w on w.employee_id=e.employee_id
								where e.employee_number='".$linearray[0]."' and e.parent_org_id=".$parent_org_id." ORDER BY w.work_info_id DESC";
								$data=UlsMenu::callpdo($empdata);
								
								//Paused here(todate to be updated with the next row from date)
								foreach($data as $subkey=>$data1){
									if(!in_array($subkey,$key_arr)){
										$key_arr[]=$subkey;
										$date_arr[]=$data1['from_date'];
										//print_r($date_arr);
										if($y>0){
											$arr_cnt=count($date_arr);
											$cnt_mis=$arr_cnt-2;
											$tmp_frmdt=$date_arr[$cnt_mis];
											$tmp_todt=strtotime($tmp_frmdt.' -1 day');
											$dt=date('Y-m-d',$tmp_todt);
											//if(empty($data1['to_date'])){
												if($data1['employee_number']==$linearray[0]){	
													if(($tmp_frmdt<=$sysdate && $dt>=$sysdate) || ($tmp_frmdt<=$sysdate && $dt=='')){$stat='A';}else{$stat='I';}											
													$emp_update=Doctrine_Query::Create()->update('UlsEmployeeWorkInfo');
													$emp_update->set('to_date','?',$dt);
													$emp_update->set('status','?',$stat);
													$emp_update->where('work_info_id=?',$data1['work_info_id']);
													$emp_update->andwhere('parent_org_id=?',$parent_org_id);
													$emp_update->execute();
												}
											//}
										}$y++;	
									}
								} 
								
							
							}
						}
					}
					$qu .="</table></div>";
					$qu .="<!--<div class='form-actions center'>
						<input type='button' class='btn btn-sm btn-success' value='Validate' id='org_valid' name='org_valid'>&nbsp;&nbsp;&nbsp;
						<input type='button' onclick='cancel_funct()' value='cancel' id='cancel' name='cancel' class='btn btn-sm btn-danger'></div>-->";
				}
				else{
					$error = true;
				}
			}
			$data = ($error) ? array('error' => 'There was an error uploading your files') : array($qu);
		}
		else{
			$data = array('success' => 'Form was submitted', 'formData' => $_POST);               
		}
		
		echo json_encode($data);
	}
	//End of Employee Work Details migration
	
	public function rating_master_search(){
		$data["aboutpage"]=$this->pagedetails('admin','rating_master_search');
		$limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
        $rating_name=filter_input(INPUT_GET,'rating_name') ? filter_input(INPUT_GET,'rating_name'):"";
        $page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
        $start=$page!=0? ($page-1)*$limit:0;
        $filePath=BASE_URL."/admin/rating_master_search";
        $data['limit']=$limit;
        $data['rating_name']=$rating_name;
        $data['perpages']=UlsMenuCreation::perpage();
        $data['searchresults']=UlsRatingMaster::search($start, $limit,$rating_name);
        $total=UlsRatingMaster::searchcount($rating_name);
        $otherParams="&perpage=".$limit."&rating_name=$rating_name";
        $data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/rating_master_search',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function rating_master()
	{
		$data["aboutpage"]=$this->pagedetails('admin','rating_master');
		$id=filter_input(INPUT_GET,'rating_id') ? filter_input(INPUT_GET,'rating_id'):"";
        $hash=filter_input(INPUT_GET,'hash') ? filter_input(INPUT_GET,'hash'):"";
        $menutype=!empty($id)? UlsMenuCreation::menutype($id):"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			$data['rating']=UlsRatingMaster::viewrating($id);
			$data['rating_scale']=UlsRatingMasterScale::ratingscale($id);
			$data['status']=UlsAdminMaster::get_value_names("STATUS");
			$content = $this->load->view('admin/rating_master',$data,true);
		}
		$this->render('layouts/adminnew',$content);

	}
	
	public function lms_rating_master(){
        if(isset($_POST['rating_id'])){ //print_r($_POST);
            $level=(!empty($_POST['rating_id']))?Doctrine::getTable('UlsRatingMaster')->find($_POST['rating_id']):new UlsRatingMaster();
            $level->rating_name=$_POST['rating_name'];
            $level->status=$_POST['status'];
			$level->rating_scale=$_POST['rating_scale'];
            $level->save();
			//$q = Doctrine_Query::create()->delete('UlsRatingMasterScale')->where('rating_id=?',$level->rating_id)->execute();
			foreach($_POST['val'] as $k=>$value){
				if(!empty($_POST['val'][$k])){
				$subl=Doctrine_Core::getTable('UlsRatingMasterScale')->findOneByRatingIdAndRatingNumber($level->rating_id,$value);
				if(!isset($subl->scale_id)){
					$subl=new UlsRatingMasterScale();
				}
				/*	$sublevel=array('rating_name_scale');
					$subl=(!empty($_POST['scale_id'][$k]))?Doctrine::getTable('UlsRatingMasterScale')->find($_POST['scale_id'][$k]):new UlsRatingMasterScale();*/
					$subl->rating_id=$level->rating_id;
					$subl->rating_number=$value;
					$subl->rating_name_scale=$_POST['rating_name_scale'][$k];
					/*foreach($sublevel as $sublevels){
						$subl->$sublevels=(!empty($_POST[$sublevels][$k]))?$_POST[$sublevels][$k]:NULL;
					}*/
					$subl->save();
				}
			}
			$q = Doctrine_Query::create()->delete('UlsRatingMasterScale')->where('rating_id=?',$level->rating_id)->andwhere('rating_number >'.$_POST['rating_scale'])->execute();
			$this->session->set_flashdata('rating_msg',"Rating data ".(!empty($_POST['rating_id'])?"updated":"inserted")." successfully.");
			redirect("admin/rating_view?rating_id=".$level->rating_id);
        }
        else{
			$content = $this->load->view('admin/level_master_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }
	
	public function deleterating(){
		$id=trim($_REQUEST['val']);
		if(!empty($id)){
			$uewi=Doctrine_Query::create()->from('UlsAssessmentDefinition')->where('rating_id='.$id)->execute();
			if(count($uewi)==0){
				$q = Doctrine_Query::create()->delete('UlsRatingMasterScale')->where('rating_id=?',$id)->execute();
				$q = Doctrine_Query::create()->delete('UlsRatingMaster')->where('rating_id=?',$id)->execute();
				echo 1;
			}
			else{
				echo "Selected Rating cannot be deleted. Ensure you delete all the usages of the Rating before you delete it.";
			}
		}
	}

	public function rating_view(){
		$data["aboutpage"]=$this->pagedetails('admin','rating_view');
        $id=isset($_REQUEST['rating_id'])? $_REQUEST['rating_id']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1 || $id==""){
            $content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			$data['status']=UlsAdminMaster::get_value_names("STATUS");
            $data['ratingdetails']=UlsRatingMaster::viewrating($id);
			$content = $this->load->view('admin/rating_view',$data,true);
        }
		$this->render('layouts/adminnew',$content);
    }
	
	public function assessment_info_details(){
		$ass_id=$_REQUEST['ass_id'];
		$pos_id=$_REQUEST['pos_id'];
		$ass=UlsAssessmentDefinition::viewassessment($ass_id);
		$position_ass=UlsAssessmentPosition::get_assessment_position_info($pos_id,$ass_id);
		$data="";
		$data.="
		<form action='".BASE_URL."/admin/assessment_broadcast_submit' method='post'>
		<input type='hidden' name='assessment_pos_id' id='assessment_pos_id' value='".$position_ass['assessment_pos_id']."'>
		<input type='hidden' name='assessment_id' id='assessment_id' value='".$ass_id."'>
		<input type='hidden' name='assessment_broadcast' id='assessment_broadcast' value='A'>
		<table class='table table-bordered table-striped' cellspacing='1' cellpadding='1'>
			<thead
				<tr>
					<th style='background-color: #edf3f4;width:20%'>Question Bank Name</th>
					<th>".$ass['assessment_name']."&nbsp;</th>
				</tr>
				<tr>
					<th style='background-color: #edf3f4;width:20%'> Start Date </th>
					<th>".$ass['start_date']."&nbsp;</th>
				</tr>
				<tr>
					<th style='background-color: #edf3f4;width:20%'> End Date </th>
					<th>".$ass['end_date']."&nbsp;</th>
				</tr>
				<tr>
					<th style='background-color: #edf3f4;width:20%'> Position Name </th>
					<th>".$position_ass['position_name']."&nbsp;</th>
				</tr>
			</thead>
		</table>
		<div class='modal-footer'>
			<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
			<button type='submit' class='btn btn-primary'>Broadcast</button>
		</div>
		</form>";
		echo $data;
	}
	
	public function assessment_broadcast_submit(){
		if(isset($_POST['assessment_pos_id'])){
			$update=Doctrine_Query::create()->update('UlsAssessmentPosition');
			$update->set('assessment_broadcast','?',$_POST['assessment_broadcast']);
			$update->where('assessment_pos_id=?',$_POST['assessment_pos_id']);
			$update->execute();
			redirect("admin/assessment_details?tab=4&id=".$_POST['assessment_id']."&hash=".md5(SECRET.$_POST['assessment_id']));
		}
	}
	
	public function deletecompdef(){
		$id=trim($_REQUEST['val']);
		if(!empty($id)){
			$quesbanks=UlsCompetencyDefQueBank::getcompdefquesbank($id);
			$intquestions=UlsCompetencyDefIntQuestion::getcompdefintques($id);
			if(count($quesbanks)==0 && count($intquestions)==0){
				$q = Doctrine_Query::create()->delete('UlsCompetencyDefinition')->where('comp_def_id=?',$id);
				$q->execute();
				echo 1;
			}
			else{
				echo "Selected Competency cannot be deleted. Ensure you delete all the usages of the Competency before you delete it.";
			}
		}
	}
	
	public function comp_master_questions(){
		$comp_id=$_REQUEST['comp_id'];
		$scale_id=$_REQUEST['scale_id'];
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$order = $this->input->get("order");
		$col = 0;
        $dir = "";$que="";
		if(isset($_REQUEST["search"]["value"]) && !empty($_REQUEST["search"]["value"])){
			$que.= 'and (c.question_name LIKE "%'.$_REQUEST["search"]["value"].'%")';
		}
		
		if(!empty($order)) {
            foreach($order as $o) {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc") {
            $dir = "asc";
        }
		$columns_valid = array(
			"c.question_id",
            "c.question_name"
        );

        if(!isset($columns_valid[$col])) {
            $order = null;
        } else {
            $order = $columns_valid[$col];
        }
		$data = array();
		
		$query=UlsCompetencyDefQueBank::getcompdefquesbank_view($comp_id,$scale_id,$start,$length,$order,$dir,$que);
		if(count($query)>0){
			$key1=$start+1;
		foreach($query as $key=>$queries){
			
			$dd=$queries['question_name'];
			 $data[] = array(
				$key1++,
				"$dd"
		   );
		   
		}
		$query_count=UlsCompetencyDefQueBank::getcompdefquesbank_view_count($comp_id,$scale_id,$que);
		$output = array(
               "draw" => $draw,
                "recordsTotal" => $query_count['q_count'],
                "recordsFiltered" => $query_count['q_count'],
                "data" => $data
            );
        echo json_encode($output);
        exit();
		}
		else{
			$output = array(
               "draw" => $draw,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => $data
            );
			echo json_encode($output);
			exit();
		}
		
		
	}
	
	public function change_category(){
		$catid=$_REQUEST['id'];
		if($catid!=''){
			if($catid=='C'){
				echo "<div class='form-group'><label class='control-label mb-10 col-sm-2'>Parent Category<sup><font color='#FF0000'>*</font></sup>&nbsp;&nbsp;&nbsp;</label>
				<div class='col-sm-5'>
					<select name='primary_category' id='category' class='validate[required] form-control m-b'>";
						$category=Doctrine_Query::Create()->from('UlsCategory')->where("category_type='PC'")->andwhere('parent_org_id='.$_SESSION['parent_org_id'])->execute();
						foreach($category as $category1){
							$cat_startdate=(strtotime($category1->start_date)-strtotime(date("Y-m-d")))/(24*60*60);
							$cat_enddate=(strtotime($category1->end_date)-strtotime(date("Y-m-d")))/(24*60*60);
							if(!empty($category1->end_date)){
								if(date('d-m-Y',strtotime($category1->end_date))=='19-01-2037'){
									$enddate='';
								}
								else{
									$enddate=date('d-m-Y',strtotime($category1->end_date));
								}
							}
							else{$enddate='';}
							echo"<option value=".$category1->category_id.">".$category1->name."</option>
							<input type='hidden' name='cat_startdate' id='cat_startdate' value=".$cat_startdate.">
							<input type='hidden' name='cat_enddate' id='cat_enddate' value=".$cat_enddate.">
							<input type='hidden' name='cat_startdatetext' id='cat_startdatetext' value='".date('d-m-Y',strtotime($category1->start_date))."'>
							<input type='hidden' name='cat_enddatetext' id='cat_enddatetext' value='".$enddate."'>";
						} 
					echo"</select>
					</div>
				</div>";		
			}
			if($catid=='SC'){ 
				echo"<div class='form-group'><label class='control-label mb-10 col-sm-2'>Parent Category<sup><font color='#FF0000'>*</font></sup>&nbsp;&nbsp;&nbsp;</label>
				<div class='col-sm-5'>
					<select name='primary_category' id='category' onChange='subcatdate()' class='validate[required] form-control m-b'>
						<option value=''>Select</option>";
						$category=Doctrine_Query::Create()->from('UlsCategory')->where("category_type='C'")->andwhere('parent_org_id='.$_SESSION['parent_org_id'])->execute();
						foreach($category as $category1){
							echo"<option value=".$category1->category_id.">".$category1->name."</option>";
						} 
						echo"</select>";
						foreach($category as $category1){
							$cat_startdate=(strtotime($category1->start_date)-strtotime(date("Y-m-d")))/(24*60*60);
							$cat_enddate=(strtotime($category1->end_date)-strtotime(date("Y-m-d")))/(24*60*60);
							if(!empty($category1->end_date)){
								if(date('d-m-Y',strtotime($category1->end_date))=='19-01-2037'){
									$enddate='';
								}else{
									$enddate=date('d-m-Y',strtotime($category1->end_date));
								}
							} else{$enddate='';}
							echo"<input type='hidden' name='cat_startdate' id='cat_startdate' value=".$cat_startdate.">
							<input type='hidden' name='cat_enddate' id='cat_enddate' value=".$cat_enddate."> 
							<input type='hidden' name='cat_startdatetext' id='cat_startdatetext' value='".date('d-m-Y',strtotime($category1->start_date))."'>
							<input type='hidden' name='cat_enddatetext' id='cat_enddatetext' value='".$enddate."'>";
						}
					echo"</div>
				</div>";		
			}
			if($catid=='AC'){ 
				echo"<div class='form-group'><label class='control-label mb-10 col-sm-2'>Parent Category<sup><font color='#FF0000'>*</font></sup>&nbsp;&nbsp;&nbsp;</label>
				<div class='col-sm-5'>
					<select name='primary_category' id='category' onChange='Addcatdate()' class='validate[required] form-control m-b'>
						<option value=''>Select</option>";
						$category=Doctrine_Query::Create()->from('UlsCategory')->where("category_type='SC'")->andwhere('parent_org_id='.$_SESSION['parent_org_id'])->execute();
						foreach($category as $category1){
							echo"<option value=".$category1->category_id.">".$category1->name."</option>";
						} 
					echo"</select>";
					foreach($category as $category1){  
						$cat_startdate=(strtotime($category1->start_date)-strtotime(date("Y-m-d")))/(24*60*60);
						$cat_enddate=(strtotime($category1->end_date)-strtotime(date("Y-m-d")))/(24*60*60);
						if(!empty($category1->end_date)){
							if(date('d-m-Y',strtotime($category1->end_date))=='19-01-2037'){
								$enddate='';
							}else{
								$enddate=date('d-m-Y',strtotime($category1->end_date));
							}	
						}else{$enddate='';}
						echo" <input type='hidden' name='cat_startdate' id='cat_startdate' value=".$cat_startdate.">
						<input type='hidden' name='cat_enddate' id='cat_enddate' value=".$cat_enddate.">
						<input type='hidden' name='cat_startdatetext' id='cat_startdatetext' value='".date('d-m-Y',strtotime($category1->start_date))."'>
						<input type='hidden' name='cat_enddatetext' id='cat_enddatetext' value='".$enddate."'>";
					}
				echo"</div>
			</div>";		
			}
		}
	}
	
	public function sub_category(){
		$subcatid=$_REQUEST['id'];
		if(!empty($subcatid)){
			$subcateid=Doctrine_Core::getTable('UlsCategory')->findOneByCategory_id($subcatid);
			$category=Doctrine_Query::Create()->from('UlsCategory')->where("category_type='C'")->andwhere('parent_org_id='.$_SESSION['parent_org_id'])->execute();
			echo"<div class='form-group'><label class='col-sm-3 control-label'>Parent Category&nbsp;&nbsp;&nbsp;</label>
			<div class='col-sm-5'>
				<select name='primary_category' id='category' class='validate[required] form-control m-b' onChange='subcatdate()'>
					<!--<option value=''>Select</option>-->";
					foreach($category as $category1){
						if($category1->category_id==$subcatid){
							echo"<option value=".$category1->category_id." selected='selected'>".$category1->name."</option>";
						}
						else{
							echo"<option value=".$category1->category_id.">".$category1->name."</option>";
						}
					}
			echo"</select>";
			foreach($category as $category1){
				$cat_startdate=(strtotime($subcateid->start_date)-strtotime(date("Y-m-d")))/(24*60*60);
				$cat_enddate=(strtotime($subcateid->end_date)-strtotime(date("Y-m-d")))/(24*60*60);	
				if(!empty($subcateid->end_date)){
					if(date('d-m-Y',strtotime($subcateid->end_date))=='19-01-2037' || $subcateid->end_date==NULL){
						$enddate='';
					}
					else{
						$enddate=date('d-m-Y',strtotime($subcateid->end_date));
					}
				}
				else { $enddate='';}
				echo"<input type='hidden' name='cat_startdate' id='cat_startdate' value=".$cat_startdate.">
				<input type='hidden' name='cat_enddate' id='cat_enddate' value=".$cat_enddate.">
				<input type='hidden' name='cat_startdatetext' id='cat_startdatetext' value='".date('d-m-Y',strtotime($subcateid->start_date))."'>
				<input type='hidden' name='cat_enddatetext' id='cat_enddatetext' value='".$enddate."'>";
			}
			echo"</div>
			</div>";
		}
	}
	
	public function add_category(){
		$addcatid=$_REQUEST['id'];
		if(!empty($addcatid)){
			$addcateid=Doctrine_Core::getTable('UlsCategory')->findOneByCategory_id($addcatid);
			echo"<div class='form-group'><label class='control-label mb-10 col-sm-2'>Parent Category&nbsp;&nbsp;&nbsp;</label>
			<div class='col-sm-5'>
				<select name='primary_category' id='category' onChange='Addcatdate()' class='validate[required] form-control m-b'>
				<!--<option value=''>Select</option>-->";
				$category=Doctrine_Query::Create()->from('UlsCategory')->where("category_type='SC'")->andwhere('parent_org_id='.$_SESSION['parent_org_id'])->execute();
				foreach($category as $category1){
					if($category1->category_id==$addcatid){
						echo"<option value=".$category1->category_id." selected='selected'>".$category1->name."</option>";
					}
					else{
						echo"<option value=".$category1->category_id.">".$category1->name."</option>";
					}
				}
				echo"</select>";
				foreach($category as $category1){
					$cat_startdate=(strtotime($addcateid->start_date)-strtotime(date("Y-m-d")))/(24*60*60);
					$cat_enddate=(strtotime($addcateid->end_date)-strtotime(date("Y-m-d")))/(24*60*60);
					if(!empty($addcateid->end_date)){
						if(date('d-m-Y',strtotime($addcateid->end_date))=='19-01-2037'){
							$enddate='';
						}
						else{
							$enddate=date('d-m-Y',strtotime($addcateid->end_date));
						}
					}
					else { $enddate='';}
					echo" <input type='hidden' name='cat_startdate' id='cat_startdate' value=".$cat_startdate.">
					<input type='hidden' name='cat_enddate' id='cat_enddate' value=".$cat_enddate.">
					<input type='hidden' name='cat_startdatetext' id='cat_startdatetext' value='".date('d-m-Y',strtotime($addcateid->start_date))."'>
					<input type='hidden' name='cat_enddatetext' id='cat_enddatetext' value='".$enddate."'>";
				}
			echo"</div>
			</div>";
		}
	}
	//Function to delete security organizations
	public function delete_secure_org(){
		$code=$_REQUEST['val'];
		 if(!empty($code)){
			$empdata1=Doctrine_Query::create()->delete('UlsSecurityOrg')->where('secure_org_id=?',$code)->execute();		echo 1;
		}
		else{
			echo "Selected organisation cannot be deleted. Ensure you delete all the usages of the organisation before you delete it.";
		}
	}
	
	public function faqs(){
        $this->sessionexist();
		$data["aboutpage"]=$this->pagedetails('admin','faqs');
		$content = $this->load->view('admin/lms_faqs',$data,true);
		$this->render('layouts/adminnew',$content);
    }
	public function delete_subgrade(){
		$id=trim($_REQUEST['val']);
		if(!empty($id)){
			//$uewi=Doctrine_Query::create()->from('UlsEmployeeWorkInfo')->where('position_id='.$id)->execute();
			//if(count($uewi)==0){
				$q = Doctrine_Query::create()->delete('UlsSubGrades')->where('sub_grade_id=?',$id);
				$q->execute();
				echo 1;
			//}
		}
		else{
			echo "Selected Sub Grade cannot be deleted. Ensure you delete all the usages of the Sub Grade before you delete it.";
		}
	}
	public function deletete_multi_single(){
		$id=trim($_REQUEST['qid']);
		if(!empty($id)){
				$q = Doctrine_Query::create()->delete('UlsQuestionValues')->where('value_id=?',$id);
				$q->execute();
				echo 1;
		}
		else{
			echo "Selected Competency Level cannot be deleted. Ensure you delete all the usages of the Competency Level before you delete it.";
		}
	}
public function upload_bulk_emp(){
			$this->sessionexist();
			$data = array();
			if(isset($_GET['files'])){
				$error = false;
				$files = '';
				foreach($_FILES as $file){
					if(!empty($file['tmp_name'])){
						$fieldseparator = ",";
						$lineseparator = "\n";
                        $csvfile = $file['tmp_name'];
                        $addauto = 0;
                        $save = 1;
                        $outputfile = "output.sql";
                        if(!file_exists($csvfile)) {
                        echo "File not found. Make sure you specified the correct path.\n";
                        exit;
                        }
                        $file = fopen($csvfile,"r");
                        if(!$file) {
                            echo "Error opening data file.\n";
                            exit;
                        }
                        $size = filesize($csvfile);
                        if(!$size) {
                            echo "File is empty.\n";
                            exit;
                        }
                        $csvcontent = fread($file,$size);
                        $linearray = array();
                        $qu = "";
						$qu .= "<div style='height:300px; overflow: auto;'><table id='single_enroll_tab' class='table table-striped table-bordered table-hover'>";
						$qu .= "<thead><tr><th>Employee Number</th><th>Employee Name</th><th>Department</th><th>Position</th></tr></thead>";
						
						foreach(explode($lineseparator,$csvcontent) as $key=>$line) {
							$line = trim($line," \t");
							$line = str_replace("\r","",$line);
							$line = str_replace("'","\'",$line);
							$linearray =  str_getcsv($line, ',');//explode($fieldseparator,$line);
							$linemysql = implode("','",$linearray);
							if($key==0){
								if(count($linearray)!=1){
									$qu .= "<tr><td colspan='5' align='center'>Please Check the template uploaded.</td></tr>";
									 break;
								}
							}
                            if($key>0){
								if(count($linearray)>=1 && !empty($linearray[0])){
									$empdata=UlsEmployeeMaster::get_empdetails_id_number($linearray[0]);
                                   if(isset($empdata['empid'])){
									   if($_GET['type']=='full'){
									$val_chk=UlsAssessmentEmployees::getassessmentemployees_position($empdata['empid'],$_GET['assmtid'],$_GET['posid']);
									}else{
									$val_chk=UlsSelfAssessmentEmployees::getassessmentemployees_position($empdata['empid'],$_GET['assmtid'],$_GET['posid']);
									}
									   if(count($val_chk)==0){
									    $qu .= "<tr>";
											$qu .="<td><input id='emp_id[".$key."]' type='hidden' value='".$empdata['empid']."' name='emp_id[]'><input type='text' name='employee_number[]' id='employee_number[".$key."]' value='".$empdata['enumber']."' class='form-control' readonly >
											</td><td>
											<input type='text' name='employee_name[]'  class='form-control id='employee_name[".$key."]' value='".$empdata['name']."' readonly>
											</td>";
											$qu .="<td><input class='form-control' type='text' name='pre_score[]' id='pre_score[".$key."]' value='".$empdata['org_name']."' readonly></td>
											<td><input class='form-control' type='text' name='post_score[]' id='post_score[".$key."]' value='".$empdata['position_name']."' readonly></td>";
											$qu .= "</tr>";
									  }else{
										  $qu .= "<tr>";
											$qu .="<td><input id='emp_id[".$key."]' type='hidden'  name='emp_id[]' value='".$empdata['empid']."' disabled><input type='text' name='employee_number[]' id='employee_number[".$key."]' value='".$empdata['enumber']."' class='validate[required] form-control'  disabled><font color='red'>Already Exits</font>
											</td><td>
											<input type='text' name='employee_name[]' class='form-control'  disabled id='employee_name[".$key."]' value='".$empdata['name']."'>
											</td><td><input class='form-control' type='text' name='pre_score[]' id='pre_score[".$key."]' value='".$empdata['org_name']."' style='' disabled /></td><td><input class='form-control' type='text' name='post_score[]' id='post_score[".$key."]' value='".$empdata['position_name']."' style='' disabled /></td>";
											$qu .= "</tr>"; 
									   }
									}
								else{
									$qu .= "<tr>";
											$qu .="<td><input id='emp_id[".$key."]' type='hidden' value='' name='emp_id[]' disabled><input type='text' name='employee_number[]' id='employee_number[".$key."]' value='$linearray[0]' class=' form-control'  disabled><font color='red'>Mismatch with our Database</font></td><td>
											<input class='form-control' type='text' name='employee_name[]' disabled id='employee_name[".$key."]' value=''>
											</td><td><input class='form-control' type='text' name='pre_score[]' id='pre_score[".$key."]' value='' disabled></td><td><input class='form-control' type='text' name='post_score[]' id='post_score[".$key."]' value='' disabled></td></td>";
											$qu .= "</tr>";
								}
									}
                            }
                        }
						$parameter='"enrollment_div"';
                        $qu .= "</table></div><br>";					
						$qu .= "<div class='modal-footer'>
							<input type='submit' name='bulk_save'  id='single_save' value='Enroll' class='btn btn-primary' >&nbsp;&nbsp;&nbsp;
							<input type='button' class='btn btn-danger'   onClick='cancel_funct_bulk(\"bulk_enrollment_div_".$_GET['posid']."\")' value='cancel'/>
						</div>";
//                        
                    }
                    else{
                        $error = true;
                    }
                }
                $data = ($error) ? array('error' => 'There was an error uploading your files') : array($qu);
                //$data = $qu;
                //echo $qu;
            }
            else{
                 //$data = $qu;
                $data = array('success' => 'Form was submitted', 'formData' => $_POST);
               
            } 
			echo json_encode($data);
            //echo json_encode($data);
            //echo $data = $qu;
        }

	
	public function ass_get_posdet(){
		$id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
		$posdetails=UlsPosition::viewposition($_REQUEST['id']);
		$data['posdetails']=$posdetails;
		$data['competencies']=UlsCompetencyPositionRequirements::getcompetencypositionrequirements($_REQUEST['id']);
		$data['kras']=UlsCompetencyPositionRequirementsKra::getcompetencypositionrequirementskra($_REQUEST['id']);
		$questionsbanks=UlsCompetencyPositionRequirements::getcompetencypositionqb($_REQUEST['id']);
		$testtypes=UlsAdminMaster::get_value_names("ASSESSMENT_TYPE");
		$qcount=$qtypes=array();
		foreach($questionsbanks as $questionsbank){
			foreach($testtypes as $testtype){
				if($testtype['code']==$questionsbank['type']){
					$id=$questionsbank['comp_def_id'];
					$sid=$questionsbank['scale_id'];
					$type=$testtype['code'];
					$qtypes[$id][$sid][$type]=isset($qtypes[$id][$sid][$type])?$qtypes[$id][$sid][$type]+1:1;
					$qcount[$id][$sid][$type]['q']=isset($qcount[$id][$sid][$type]['q'])?$qcount[$id][$sid][$type]['q']+$questionsbank['qcount']:$questionsbank['qcount'];
				}
			}
		}
		$data['qcount']=$qcount;
		$data['qtypes']=$qtypes;
		$data['testtypes']=$testtypes;
		$content = $this->load->view('admin/assessmentposition',$data,true);
		$this->render('layouts/ajax-layout',$content);
	}
	
	public function question_details_view(){
		$q_id=$_REQUEST['q_id'];
		$data="";
		$questionss=UlsQuestionbank::get_questions_data($q_id);
		$data.="<h5 class='lighter block green'>Questions</h5>";
		if(count($questionss)>0){  
			$data.='<h6 style="color:green;">Green color values are Correct answers </h6>';
		}
		$data.='<div style="overflow-y:auto; height:500px; padding-left: 20px; font:10px; border: 1px solid #DDDDDD;">
			<table>';
			if(count($questionss)>0){  
				$nums=0; $single_quest=array();
				foreach ($questionss as  $key=>$question){ 
					$chk=$question['correct_flag']=='Y'? 'checked="checked"'  : '';
					$col=$question['correct_flag']=='Y'? 'style="color:green;"':'';
					$key1=$key+1;
					if($question['question_type']=='F'){ 
						$nums=$nums+1;
						$data.="<tr><td>".$nums.").".$question['question_name']."<br />
						Ans: <input type='text' name='quest' id='quest' value='".$question['text']."' readonly='readonly'/> 	</td>
						</tr>";
					}
					else if($question['question_type']=='B'){ 
						$nums=$nums+1;
						$data.="<tr><td>".$nums.").".$question['question_name']." <br />
						 Ans: <input type='text' name='fbn' id='fbn' value='".$question['text']."' readonly='readonly'/>
						</td>
						</tr>";
					}
					else if($question['question_type']=='T'){
						if(!in_array($question['id'],$single_quest)){
							$single_quest[]=$question['id'];  $nums=$nums+1;
							$data.="<tr><td>".$nums.").".$question['question_name']."</td> </tr>";
						} 
						$data.='<tr><td>&emsp;<input type="radio" disabled="disabled"  name="truefalse'.$key1.'" id="truefalse"'.$chk.' /> <label '.$col.' for="truefalse">'.$question['text'].'</label> </td></tr>';
					} 		   
					else if($question['question_type']=='S'){
						if(!in_array($question['id'],$single_quest)){
							$single_quest[]=$question['id'];  $nums=$nums+1;
								$data.='<tr><td><label class="control-label mb-10 text-left">'.$nums.').'.$question['question_name'].'</label></td> </tr>';
						}
						$data.='<tr><td>&emsp;<input type="radio" disabled="disabled"  name="truefalse'.$key1.'" id="truefalse" '.$chk.' /> <label '.$col.' for="truefalse">'.$question['text'].'</label> </td></tr>';
					}
					else if($question['question_type']=='M'){
						if(!in_array($question['id'],$single_quest)){
							$single_quest[]=$question['id']; $nums++;
							$data.="<tr><td>".$nums.").".$question['question_name']."</td></tr>";
						}
						$data.="<tr><td>&emsp;<input type='checkbox' disabled='disabled' name='truefalse' id='truefalse' ".$chk."' />
						<label  ".$col." for='truefalse'>".$question['text']."</label> </td></tr>"; 
					} 
					else if($question['question_type']=='FT'){  $nums++;
						$data.='<tr ><td valign="top"><label>'.$nums.').'.$question['question_name'].'</label>
						<textarea id="form-field-11" class="autosize-transition form-control" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 69px; name="ft" id="ft">'.$question['text'].'</textarea></td>';
					}
				}
			}
			else{
					$data.='<tr><td colspan="2"> No Questions are available for this Questions Bank.</td></tr>';
			}
			$data.="</table>
		</div>";
		
		echo $data;
	}
	
	public function delete_inbasket_intray(){
		$id=trim($_REQUEST['val']);
		if(!empty($id)){
			$inbasket=UlsQuestionValues::get_allquestion_values_delete($id);
			$inbasket_value=UlsAssessmentTestInbasket::get_inbasket_values($inbasket['inbasket_id']);
			if(count($inbasket_value)==0){
				$play=Doctrine_Query::Create()->delete('UlsQuestionValues')->where("value_id=".$id)->execute();
				echo 1;
			}
			else{
				echo "Selected Intray cannot be deleted. Ensure you delete all the usages of the Intray before you delete it.";
			}
		}
	}
	
	public function bei_assessment_insert(){
        $this->sessionexist();
        if(isset($_POST['assessment_desc'])){
            $orgdata2=Doctrine::getTable('UlsBeiAttemptsAssessment')->find($_POST['attempt_id']);
			$orgdata2->admin_id=$_SESSION['emp_id'];
			$orgdata2->admin_bei_result=$_POST['admin_bei_result'];
			$orgdata2->admin_bei_comment=$_POST['assessment_desc'];
			$orgdata2->save();
			redirect('admin/assessment_report?id='.$_POST['assessment_id'].'&hash='.md5(SECRET.$_POST['assessment_id']));
        }
       
    }
	
	
	public function position_validation_search()
	{
		$data["aboutpage"]=$this->pagedetails('admin','position_validation_search');
		$limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
        $validation_name=filter_input(INPUT_GET,'validation_name') ? filter_input(INPUT_GET,'validation_name'):"";
        $page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
        $start=$page!=0? ($page-1)*$limit:0;
        $filePath=BASE_URL."/admin/position_validation_search";
        $data['limit']=$limit;
        $data['validation_name']=$validation_name;
        $data['perpages']=UlsMenuCreation::perpage();
        $data['searchresults']=UlsValidationPositionDefinition::search($start, $limit,$validation_name);
        $total=UlsValidationPositionDefinition::searchcount($validation_name);
        $otherParams="perpage=".$limit."&validation_name=$validation_name";
		$data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/position_validation_search',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function position_validation_creation()
	{
		$data["aboutpage"]=$this->pagedetails('admin','position_validation_master');
		$org_stat="STATUS";
        $data["orgstat"]=UlsAdminMaster::get_value_names($org_stat);
		
		if(!empty($_REQUEST['id'])){
			$compdetails=UlsValidationPositionDefinition::viewpositionvalidation($_REQUEST['id']);
            $data['compdetails']=$compdetails;
			$data['position_details']=UlsValidationPositions::getvalidationpositions($compdetails['val_id']);
		}
		$data["rating"]=UlsRatingMaster::rating_details();
		$data["positions"]=UlsPosition::fetch_all_pos();
		$data["locations"]=UlsLocation::fetch_all_locs();
		$content = $this->load->view('admin/position_validation_creation',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function position_validation_insert(){
        $this->sessionexist();
        if(isset($_POST['val_id'])){
            $fieldinsertupdates=array('position_validation_name','position_validation_desc','status');
			$datefield=array('start_date'=>'stdate','end_date'=>'enddate');
            $case=Doctrine::getTable('UlsValidationPositionDefinition')->find($_POST['val_id']);
            !isset($case->val_id)?$case=new UlsValidationPositionDefinition():"";
            foreach($fieldinsertupdates as $val){
				$case->$val=(!empty($_POST[$val]))?($_POST[$val]):NULL;
			}
			foreach($datefield as $key=>$dateval){
				$case->$key=(!empty($_POST[$dateval]))?date('Y-m-d',strtotime($_POST[$dateval])):NULL;
			}
            $case->save();
			
			$this->session->set_flashdata('assessment',"Position validation info ".(!empty($_POST['val_id'])?"updated":"inserted")." successfully.");
            redirect('admin/position_validation_creation?status=competency&id='.$case->val_id.'&hash='.md5(SECRET.$case->val_id));
        }
        else{
			$content = $this->load->view('admin/position_validation_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }
	
	public function validation_position_insert(){
		$this->sessionexist();
		if(isset($_POST['val_id'])){
			/* echo "<pre>";
			print_r($_POST); */
			foreach($_POST['val_pos_id'] as $key=>$value){
				$work_activation=(!empty($_POST['val_pos_id'][$key]))?Doctrine::getTable('UlsValidationPositions')->find($_POST['val_pos_id'][$key]):new UlsValidationPositions;
				$work_activation->position_id=$_POST['position_id'][$key];
				$work_activation->version_id=$_POST['version_id'][$key];
				$work_activation->status=$_POST['assessment_pos_status'][$key];
				$work_activation->val_id=$_POST['val_id'];
				$work_activation->save();
			}
			$this->session->set_flashdata('assessment',"Assessment position information has been ".(!empty($_POST['val_id'])?"updated":"inserted")." successfully.");
			redirect('admin/position_validation_creation?status=enrol&id='.$_POST['val_id'].'&hash='.md5(SECRET.$_POST['val_id']));
		}
		else{
			$content = $this->load->view('admin/position_validation_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
	}
	
	public function delete_validation_position(){
		if(!empty($_REQUEST['val'])){
			$play=Doctrine_Query::Create()->delete('UlsValidationPositions')->where("val_pos_id=".$_REQUEST['val'])->execute();
			echo 1;
		}
		else{
			echo "Selected Assessment Position cannot be deleted. Ensure you delete all the usages of the Assessment Position before you delete it.";
		}
	}
	
	public function validation_position_employee_insert(){
		$this->sessionexist();
		if(isset($_POST['val_id'])){
			/* echo "<pre>";
			print_r($_POST); */
			foreach($_POST['check_position'] as $key=>$value){
				if(isset($value)){
					$val=$value;
					$work_activation=(!empty($_POST['val_pos_empid'][$val]))?Doctrine::getTable('UlsValidationPositionEmployees')->find($_POST['val_pos_empid'][$val]):new UlsValidationPositionEmployees;
					$work_activation->position_id=$_POST['position_id'][$val];
					$work_activation->employee_id=$val;
					$work_activation->val_pos_id=$_POST['val_pos_id'][$val];
					$work_activation->status='A';
					$work_activation->val_id=$_POST['val_id'];
					$work_activation->save();
					
					$ass_journing=UlsAssessmentEmployeeJourney::get_pos_validation_employees($work_activation->val_id,$work_activation->position_id,$work_activation->employee_id);
					$enroll_journing=(!empty($ass_journing['id']))?Doctrine_Core::getTable('UlsAssessmentEmployeeJourney')->find($ass_journing['id']): new UlsAssessmentEmployeeJourney();
					$enroll_journing->assessment_type='positionval';
					$enroll_journing->val_id=$work_activation->val_id;
					$enroll_journing->position_id=$work_activation->position_id;
					$enroll_journing->employee_id=$work_activation->employee_id;
					$enroll_journing->save();
					$emp_sup=UlsEmployeeMaster::fetch_tna_emp($enroll_journing->employee_id);
					if(!empty($emp_sup['supervisor_id'])){
						$ass_journings=UlsAssessmentEmployeeJourney::get_assessment_employees($work_activation->val_id,$work_activation->position_id,$emp_sup['supervisor_id']);
						$enroll_journings=(!empty($ass_journings['id']))?Doctrine_Core::getTable('UlsAssessmentEmployeeJourney')->find($ass_journings['id']): new UlsAssessmentEmployeeJourney();
						$enroll_journings->assessment_type='positionval';
						$enroll_journings->val_id=$work_activation->val_id;
						$enroll_journings->position_id=$work_activation->position_id;
						$enroll_journings->employee_id=$emp_sup['supervisor_id'];
						$enroll_journings->save();
					}
				}
			}
			
			$this->session->set_flashdata('assessment',"Assessment position information has been ".(!empty($_POST['val_id'])?"updated":"inserted")." successfully.");
			redirect('admin/position_validation_creation?status=enrol&id='.$_POST['val_id'].'&hash='.md5(SECRET.$_POST['val_id']));
		}
	}
	
	public function validation_employee_details(){
		$val_id=$_REQUEST['val_id'];
		$pos_id=$_REQUEST['pos_id'];
		$val_pos_id=$_REQUEST['val_pos_id'];
		$data="";
		$data.="
		<form action='".BASE_URL."/admin/validation_position_single_submit' method='post' class='form-horizontal'>
		<input type='hidden' name='val_pos_id' id='val_pos_id' value='".$val_pos_id."'>
		<input type='hidden' name='val_id' id='val_id' value='".$val_id."'>
		<input type='hidden' name='position_id' id='position_id' value='".$pos_id."'>
		<div class='form-group'>
			<label class='col-sm-4 control-label'>Employee Number<sup><font color='#FF0000'>*</font></sup>:</label>
			<div class='col-sm-6'>
				<div id='idElem_chosen'></div>
				<select name='emp_no'  id='emp_no_".$pos_id."' onChange='fetch_empdata(".$val_id.",".$pos_id.")'  class='validate[required] form-control m-b'  data-prompt-position='inline' data-prompt-target='idElem_chosen'>
					<option value=''>Select</option>
				</select>
			</div>
		</div>
		<div class='form-group'>
			<label class='col-sm-4 control-label'>Employee Name:</label>
			<div class='col-sm-6'>
				<input type='text' class='form-control' name='emp_name' id='emp_name_".$pos_id."' value='' readonly>
			</div>
		</div>
		<div class='form-group'><label class='col-sm-4 control-label'>Department:</label>
			<div class='col-sm-6'>
				<input type='text' class='form-control' name='department' id='department_".$pos_id."' value='' readonly>
			</div>
		</div>
		<div class='form-group'><label class='col-sm-4 control-label'>Position:</label>
			<div class='col-sm-6'>
				<input type='text' class='form-control' name='position' id='position_".$pos_id."' value='' readonly>
			</div>
		</div>
		<div class='form-group'><label class='col-sm-4 control-label'>Location:</label>
			<div class='col-sm-6'>
				<input type='text' class='form-control' name='location' id='location_".$pos_id."' value='' readonly>
			</div>
		</div>
		<div class='hr-line-dashed'></div>
		
		<div class='modal-footer'>
			<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
			<button type='submit' name='single_save'  id='single_save' class='btn btn-success'>Save</button>
		</div>
		</form>";
		echo $data;
	}
	
	public function fetch_emp_data_id_validation(){
        $empnum=$_REQUEST['empnum'];
        $val_id=$_REQUEST['val_id'];
		$pos_id=$_REQUEST['pos_id'];
		$checkenrlvalid=UlsValidationPositionEmployees::get_validation_employees_position($empnum,$val_id,$pos_id);
		if(count($checkenrlvalid)>0){
		echo "0@Employee has already been enrolled on this event duration for another event";
		}else{
			if(!empty($empnum)){
				$empdata=UlsEmployeeMaster::get_empdetails_id($empnum);

				if(isset($empdata['empid'])){
					echo $empdata['empid']."@".trim($empdata['name'])."@".trim($empdata['org_name'])."@".trim($empdata['depart_name'])."@".trim($empdata['position_name'])."@".trim($empdata['location_name']);
				}
			}
		}

    }
	
	public function validation_position_single_submit(){
        $this->sessionexist();
        if(isset($_POST['emp_no'])){
			$fieldinsertupdates=array('val_id'=>'val_id', 'val_pos_id'=>'val_pos_id', 'position_id'=>'position_id', 'employee_id'=>'emp_no');
            $enroll=(!empty($_POST['val_pos_empid']))?Doctrine_Core::getTable('UlsValidationPositionEmployees')->find($_POST['val_pos_empid']): new UlsValidationPositionEmployees();
            foreach($fieldinsertupdates as $key=>$post_enroll){
				$enroll->$key=(!empty($_POST[$post_enroll]))?$_POST[$post_enroll]:Null;
			}
			$enroll->diff_pos='YES';
			$enroll->status='A';
            $enroll->save();
			$position=UlsMenu::callpdorow("select * from uls_position where position_id=".$enroll->position_id);
			
			$this->session->set_flashdata('assessment',"Employee data for ".$position['position_name']." is ".(!empty($_POST['val_id'])?"updated":"inserted")." successfully.");
            redirect('admin/position_validation_creation?status=enrol&id='.$_POST['val_id'].'&hash='.md5(SECRET.$_POST['val_id']));
        }
        else{
			$content = $this->load->view('admin/assessment_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }
	
	public function deleteposition_validation_employee(){
		$id=trim($_REQUEST['val']);
		if(!empty($id) && is_numeric($id)){
			$q = Doctrine_Query::create()->delete('UlsValidationPositionEmployees')->where('val_pos_empid=?',$id)->execute();
			echo 1;
		}
	}
	
	public function position_validation_view(){
		$data["aboutpage"]=$this->pagedetails('admin','position_validation_view');
		$id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
		$hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
		$flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
		if($flag==1 || $id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$compdetails=UlsValidationPositionDefinition::viewpositionvalidation($id);
			$data['compdetails']=$compdetails;
			$data['position_details']=UlsValidationPositions::getvalidationpositions($compdetails['val_id']);
			$content = $this->load->view('admin/position_validation_view',$data,true);
		}
		$this->render('layouts/adminnew',$content);
	}
	
	public function position_validation_statusreport(){
		$id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
		if($id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$data['validation_employee']=UlsValidationPositionEmployees::get_employees_position_report($id);
			$content = $this->load->view('admin/position_validation_statusreport',$data,true);
		}
		$this->render('layouts/report-layout',$content);
	}
	
	public function position_validation_report(){
		$id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
		$pos_id=isset($_REQUEST['pos_id'])? $_REQUEST['pos_id']:"";
		$val_pos_id=isset($_REQUEST['val_pos_id'])? $_REQUEST['val_pos_id']:"";
		if($id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$data['position_temp']=UlsPositionTemp::get_admin_validation_position($id,$pos_id,$val_pos_id);
			$data['comp_details']=UlsPositionTemp::employee_view_position_cat($id,$pos_id);
			$data['pos_details']=UlsPosition::pos_details($pos_id);
			
			$version=UlsMenu::callpdorow("SELECT version_id as idd FROM `uls_validation_positions` WHERE `position_id`=$pos_id and `val_id`=$id");
			
			$data['competencies']=UlsMenu::callpdo("SELECT c.name as category, b.`comp_def_name`, d.scale_name, e.comp_cri_name, a.* FROM `uls_competency_position_requirements` a
			inner join `uls_competency_definition` b on a.`comp_position_competency_id`=b.`comp_def_id`
			inner join uls_category c on b.`comp_def_category`=c.category_id
			inner join uls_level_master_scale d on a.comp_position_level_scale_id=d.scale_id
			inner join uls_competency_criticality e on a.comp_position_criticality_id=e.comp_cri_id
			WHERE a.`comp_position_id`=$pos_id and a.`version_id`=".$version['idd']. " order by c.name asc");
			$data['employees']=UlsMenu::callpdo("SELECT b.full_name,a.employee_id,a.val_id,a.position_id FROM `uls_validation_position_employees` a inner join employee_data b on a.employee_id=b.employee_id  WHERE a.`position_id`=$pos_id and a.`val_id`=$id");
			$data['kras']=UlsMenu::callpdo("SELECT b.kra_master_name,a.* FROM `uls_competency_position_requirements_kra` a left join uls_kra_masters b on a.comp_kra_steps=b.kra_master_id WHERE a.`comp_position_id`=$pos_id and a.`version_id`=".$version['idd']);
			$content = $this->load->view('admin/position_validation_report',$data,true);
		}
		$this->render('layouts/report-layout',$content);
	}
	
	public function getposdet_archive(){
		$id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
		$posdetails=UlsPositionArchive::viewposition($_REQUEST['id']);
		$data['posdetails']=$posdetails;
		$data['competencies']=UlsPositionCompetencyArchive::getcompetencypositionrequirements($_REQUEST['id']);
		$data['kras']=UlsPositionKraArchive::getcompetencypositionrequirementskra($_REQUEST['id']);
		
		$content = $this->load->view('admin/dashboardposition_archive',$data,true);
		$this->render('layouts/ajax-layout',$content);
    }
	
	public function position_version_details(){
		$pos_id=$_REQUEST['pos_id'];
		$pos_details=UlsPosition::pos_details($pos_id);
		$version=$pos_details['version_id'];
		$data="";
		$data.="<option value=''>Select</option>";
		for($n = $version; $n >= 1; $n--) {
			$data.="<option value='".$n."'>Version ".$n."</option>";
		}
		echo $data;
	}
	
	public function publishposition(){
		$id=trim($_REQUEST['val']);
		if(!empty($id) && is_numeric($id)){
			$uewi=Doctrine_Query::create()->from('UlsValidationPositionEmployees')->where('val_id='.$id)->execute();
			if(count($uewi)!=0){
				$update=Doctrine_Query::create()->update('UlsValidationPositionDefinition');
				$update->set('publish','?','P');
				$update->where('val_id=?',$id);
				$update->execute();
				$empdetails="select a.full_name AS name, a.employee_id,a.email,u.`user_name`,u.`password` FROM uls_validation_position_employees c left join (SELECT full_name, employee_number,office_number,employee_id,email FROM uls_employee_master GROUP BY employee_id)a ON a.employee_id = c.employee_id left join (SELECT `user_id`,`employee_id`,`user_name`,`password` FROM `uls_user_creation` GROUP BY employee_id)u ON a.employee_id = u.employee_id where c.parent_org_id=".$_SESSION['parent_org_id']." and c.val_id=".$id;
				$empdetails = UlsMenu::callpdo($empdetails);
				if(count($empdetails)>0){
					foreach($empdetails as $empdetail){
						$base=BASE_URL;
						$empname=$empdetail['name'];
						$user_name=$empdetail['user_name'];
						$password=$empdetail['password'];
						$empid=$empdetail['employee_id'];
						$mail=$empdetail['email'];
						$st='POSITION_VALIDATION';
						$notification=Doctrine_core::getTable('UlsNotification')->findOneByParent_org_idAndEvent_typeAndStatus($_SESSION['parent_org_id'],$st,'A');
						if(!empty($notification)){

							$emailBody =$notification->comments;
							$emailBody = str_replace("#NAME#",ucwords($empname),$emailBody);
							$emailBody = str_replace("#LINK#",$base,$emailBody);
							$emailBody = str_replace("#USERNAME#",$user_name,$emailBody);
							$emailBody = str_replace("#PASSWORD#",$password,$emailBody);
							$mailsubject=$emailBody;
							$subject= "Position validation";
							$ss=new UlsNotificationHistory();
							$ss->employee_id=$empid;
							$ss->timestamp=date('Y-m-d H:i:s');
							$ss->to=!empty($mail)? $mail : "";
							$ss->notification_id=$notification->notification_id;
							$ss->subject=$subject;
							$ss->mail_content=$mailsubject;
							$ss->save();
						}
					}
				}
				
				
				echo 1;
			}
			else{
				echo "Selected Assessment cannot be deleted. This particular Assessment has been used in transaction table.";
			}
		}
	}
	
	public function publishassessment(){
		$id=trim($_REQUEST['val']);
		if(!empty($id) && is_numeric($id)){
			$ass_def=UlsAssessmentDefinition::viewassessment($id);
			$mail_tem="ASSESSMENT_MAIL";
			$uewi=Doctrine_Query::create()->from('UlsAssessmentEmployees')->where('assessment_id='.$id)->execute();
			if(count($uewi)!=0){
				$empdetails="select a.full_name AS name, a.employee_id,a.email,u.`user_name`,u.`password`,c.position_id FROM uls_assessment_employees c left join (SELECT full_name, employee_number,office_number,employee_id,email FROM uls_employee_master GROUP BY employee_id)a ON a.employee_id = c.employee_id left join (SELECT `user_id`,`employee_id`,`user_name`,`password` FROM `uls_user_creation` GROUP BY employee_id)u ON a.employee_id = u.employee_id where c.parent_org_id=".$_SESSION['parent_org_id']." and c.assessment_id=".$id;
				$empdetails = UlsMenu::callpdo($empdetails);
				if(count($empdetails)>0){
					foreach($empdetails as $empdetail){
						$base=BASE_URL."/index/login";
						$empname=$empdetail['name'];
						$user_name=$empdetail['user_name'];
						$password=$empdetail['password'];
						$empid=$empdetail['employee_id'];
						$mail=$empdetail['email'];
						$st=$mail_tem;
						$notification=Doctrine_core::getTable('UlsNotification')->findOneByParent_org_idAndEvent_typeAndStatus($_SESSION['parent_org_id'],$st,'A');
						if(!empty($notification)){
							//$tna_url="Assessment_Navigation.pdf";
							//$tnalink=BASE_URL."/public/tni/".$tna_url."";
							$emailBody =$notification->comments;
							$emailBody = str_replace("#NAME#",ucwords($empname),$emailBody);
							$emailBody = str_replace("#LINK#",$base,$emailBody);
							$emailBody = str_replace("#USERNAME#",$user_name,$emailBody);
							$emailBody = str_replace("#PASSWORD#",$password,$emailBody);
							//$emailBody = str_replace("#TNILINK#",$tnalink,$emailBody);
							//$emailBody = str_replace("#Assessment_methods#",$ass_methods,$emailBody);
							$mailsubject=$emailBody;
							$subject= "Technical Assessment Adani Green";
							$ss=new UlsNotificationHistory();
							$ss->employee_id=$empid;
							$ss->timestamp=date('Y-m-d H:i:s');
							$ss->to=!empty($mail)? $mail : "";
							$ss->notification_id=$notification->notification_id;
							//$ss->attachment=$tna_url;
							$ss->subject=$subject;
							$ss->mail_content=$mailsubject;
							//$ss->mail_status='A';
							$ss->save();
						}
					}
				} 
				echo 1;
			}
			else{
				echo "Selected Assessment cannot be deleted. This particular Assessment has been used in transaction table.";
			}
		}
	}
	
	public function publish_ass_assessment(){
		$id=trim($_REQUEST['val']);
		if(!empty($id) && is_numeric($id)){
			$update=Doctrine_Query::create()->update('UlsAssessmentDefinition');
			$update->set('ass_broadcast','?','P');
			$update->where('assessment_id=?',$id);
			$update->execute();
			
			$assessordetails="SELECT distinct(a.`assessor_id`),am.assessor_type,am.assessor_name,us.`user_name` as ass_login,us.`password` as ass_pass,us.email_address as ass_email,u.`user_name` as emp_login,e.email as emp_email,u.`password` as emp_pass,e.full_name as emp_name,e.employee_id as empid,group_concat(a.`position_id`) as positionname,sum(b.empcount) as ecount,group_concat(b.empcount),group_concat(p.position_name) as pos_name FROM `uls_assessment_position_assessor` a
			left join(SELECT count(assessment_pos_emp_id) as empcount,employee_id,assessment_id,position_id FROM `uls_assessment_employees` group by position_id) b on find_in_set(a.position_id,b.position_id)>0
			left join(SELECT `position_id`,`position_name` FROM `uls_position`) p on find_in_set(a.position_id,p.position_id)>0
			left join(SELECT `assessor_id`,`employee_id`,`assessor_name`,`assessor_email`,`assessor_type` FROM `uls_assessor_master`) am on am.assessor_id=a.assessor_id
			left join (SELECT full_name, employee_number,office_number,employee_id,email FROM uls_employee_master GROUP BY employee_id) e ON e.employee_id = am.employee_id 
			left join (SELECT `user_id`,`employee_id`,`user_name`,`password` FROM `uls_user_creation`)u ON e.employee_id = u.employee_id
			left join (SELECT `user_id`,`employee_id`,`user_name`,`password`,assessor_id,email_address FROM `uls_user_creation`  where assessor_id is NOT NULL)us ON am.assessor_id = us.assessor_id
			WHERE a.`assessment_id`=".$id." group by a.assessor_id";
			$assdetails = UlsMenu::callpdo($assessordetails);
			$ass_tmethods="";
				
			if(count($assdetails)>0){
				foreach($assdetails as $assdetail){
					if($assdetail['assessor_type']=='EXT'){
						$empname=$assdetail['assessor_name'];
						$user_name=$assdetail['ass_login'];
						$password=$assdetail['ass_pass'];
						$mail=$assdetail['ass_email'];
						$empid=NULL;
					}
					else{
						$empname=$assdetail['emp_name'];
						$user_name=$assdetail['emp_login'];
						$password=$assdetail['emp_pass'];
						$empid=$assdetail['empid'];
						$mail=$assdetail['emp_email'];
					}
					/* $ass_tmethods.="<table class='table608' style='mso-table-lspace:0pt;mso-table-rspace:0pt;' align='center' bgcolor='#ffffff' border='1' cellpadding='3' cellspacing='0' width='600'>
						<tbody>
							<tr>
								<td><b>Position Name:</b></td>
								<td><b>Employee Count:</b></td>
							</tr>
							<tr>
								<td>".str_replace(',','<br>',$assdetail['pos_name'])."</td>
								<td>".$assdetail['ecount']."</td>
							</tr>
						</tbody>
					</table>
					"; */
					
					$base=BASE_URL;
					$st='ASSESSMENT_MAIL_ASSESSOR';
					$notification=Doctrine_core::getTable('UlsNotification')->findOneByParent_org_idAndEvent_typeAndStatus($_SESSION['parent_org_id'],$st,'A');
					if(!empty($notification)){
						$emailBody =$notification->comments;
						$emailBody = str_replace("#NAME#",ucwords($empname),$emailBody);
						$emailBody = str_replace("#LINK#",$base,$emailBody);
						$emailBody = str_replace("#USERNAME#",$user_name,$emailBody);
						$emailBody = str_replace("#PASSWORD#",$password,$emailBody);
						/* $emailBody = str_replace("#ass_table#",$ass_tmethods,$emailBody); */
						$mailsubject=$emailBody;
						$subject= "Assessment";
						$ss=new UlsNotificationHistory();
						$ss->employee_id=$empid;
						$ss->timestamp=date('Y-m-d H:i:s');
						$ss->to=!empty($mail)? $mail : "";
						$ss->notification_id=$notification->notification_id;
						$ss->subject=$subject;
						$ss->mail_content=$mailsubject;
						$ss->save();
					}
				}
				echo 1;
			}
			else{
				echo "Selected Assessment cannot be deleted. This particular Assessment has been used in transaction table.";
			}
		}
	}
	
	public function assessment_status_report(){
		$ass_id=isset($_REQUEST['ass_id'])? $_REQUEST['ass_id']:"";
		$ass_type=isset($_REQUEST['ass_type'])? $_REQUEST['ass_type']:"";
		$pos_id=isset($_REQUEST['pos_id'])? $_REQUEST['pos_id']:"";
		if($ass_id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$data['username']=UlsReports::getusername();
			$data['type']=isset($_REQUEST['typeid'])? $_REQUEST['typeid']:"";
			$data['test_beh']=UlsAssessmentTestBehavorialInst::viewbehavorial_count($ass_id,$pos_id);
			$data['test_casestudy']=UlsAssessmentTestCasestudy::viewcasestudy_count_report($ass_id,$pos_id);
			$data['test_inbasket']=UlsAssessmentTestInbasket::viewinbasket_count_report($ass_id,$pos_id);
			$data['ass_test']=UlsAssessmentTest::assessment_test_report($ass_id,$pos_id);
			$data['employee']=UlsAssessmentEmployees::get_status_assessmentreport($ass_id,$ass_type,$pos_id);
			$content = $this->load->view('report/lms_report_assessment_status',$data,true);
		}
		$this->render('layouts/report-layout',$content);
	}
	
	public function inbasket_question_edit(){
		$q_id=$_REQUEST['q_id'];
		$inbasket_id=$_REQUEST['inbasket_id'];
		$question_value=UlsQuestionValues::get_allquestion_values_edit($q_id);
		/* $comp_name=UlsCompetencyDefinition::competency_detail_single($comp_id); */
		$yes_stat="IN_MODE";
        $mode=UlsAdminMaster::get_value_names($yes_stat);
		$parsed_json = json_decode($question_value['inbasket_mode'], true);
		echo "<form id='inbasketform".$q_id."' action='".BASE_URL."/admin/insert_inbasket_values' method='post' name='inbasketform".$q_id."' class=''>
			<input type='hidden' name='value_id' id='value_id' value='".$q_id."'>
			<input type='hidden' name='inbasket_id' id='inbasket_id' value='".$inbasket_id."'>
			<div class=''>
				<div class='form-group col-lg-6'>";
				if(!empty($parsed_json)){
					foreach($parsed_json as $key => $value)
					echo "<div class='form-group'>
						<label class='control-label mb-10 text-left'>Mode<sup><font color='#FF0000'>*</font></sup>:</label>
						<select style='width: 100%' name='in_mode' id='in_mode' class='form-control m-b validate[required]'>
							<option value=''>Select</option>";
							foreach($mode as $modes){
								$sel=isset($value['mode'])?(($value['mode']==$modes['code'])? "selected=selected":""):"";
								echo "<option value='".$modes['code']."' ".$sel.">".$modes['name']."</option>";
							}
						echo "</select>
					</div>
					<div class='form-group'>
						<div class='form-group'>
							<label class='control-label mb-10 text-left'>Time Intervel<sup><font color='#FF0000'>*</font></sup>:</label>
							<input type='text' name='in_period' id='in_period' class='validate[required] form-control' value='".$value['period']."' />
								
						</div>
					</div>
					<div class='form-group'>
						<label class='control-label mb-10 text-left'>From:</label>
						<input type='text' class='form-control' name='in_from' id='in_from' value='".$value['from']."' >
					</div>";
				}
				echo "<div class='form-group'>
						<label class='control-label mb-10 text-left'>Suggestions:</label>
						<textarea rows='5' class='form-control' name='suggestion_inbasket' id='suggestion_inbasket'>".$question_value['suggestion_inbasket']."</textarea>
					</div>
					<div class='form-group'>
						<div class='form-group'>
							<label class='control-label mb-10 text-left'>Priority:</label>
							<input type='text' name='priority_inbasket' id='priority_inbasket' class='form-control' value='".$question_value['priority_inbasket']."' />
								
						</div>
					</div>
				</div>
				<div class='col-lg-6'>
					<div class='form-group'>
						<label class='control-label mb-10 text-left'>Enter InTray Details<sup><font color='#FF0000'>*</font></sup>:</label>
						<textarea rows='8' class='form-control validate[required]' name='inbasket_answer' id='inbasket_answer'>".$question_value['text']."</textarea>
					</div>
					<div class='form-group'>
						<label class='control-label mb-10 text-left'>Multilingual InTray Details:</label>
						<textarea rows='8' class='form-control validate[required]' name='inbasket_answer_lang' id='inbasket_answer_lang'>".(!empty($question_value['text_lang'])?$question_value['text_lang']:"")."</textarea>
					</div>
					<div class='form-group'>
						<label class='control-label mb-10 text-left'>Reason:</label>
						<textarea rows='5' class='form-control' name='reason_inbasket' id='reason_inbasket'>".$question_value['reason_inbasket']."</textarea>
					</div>
					<div class='form-group'>
						<label class='control-label mb-10 text-left'>&nbsp;</label>
					</div>
				</div>
			
		<div class='form-group'>
			<div class='col-sm-offset-7'>
				<button onclick='create_link('inbasket_exercises_master_search')' type='button' class='btn btn-danger btn-sm'><i class='fa fa-reply'></i> <span class='bold'>Cancel</span></button>
				<button id='submit' name='submit' type='submit' class='btn btn-primary btn-sm'><i class='fa fa-check'></i>Edit Intray</button>
			</div>
		</div>
		</div>
		</form>
		";
	}
	
	public function insert_inbasket_values(){
		$this->sessionexist();
		if(isset($_POST['in_mode'])){
			$mode_action=$_POST['in_mode'];
			$period_action=$_POST['in_period'];
			$from_action=!empty($_POST['in_from'])?$_POST['in_from']:"";
			$results[]= array('mode' => $mode_action, 'period' => $period_action,'from' => $from_action);
			$output = ($results);
			$inbasket_action=json_encode($output);
			$question_values=!empty($_POST['value_id'])? Doctrine_Core::getTable('UlsQuestionValues')->find($_POST['value_id']):new UlsQuestionValues();
			$question_values->text=$_POST['inbasket_answer'];
			$question_values->text_lang=!empty($_POST['inbasket_answer_lang'])?$_POST['inbasket_answer_lang']:NULL;
			$question_values->suggestion_inbasket=!empty($_POST['suggestion_inbasket'])?$_POST['suggestion_inbasket']:NULL;
			$question_values->reason_inbasket=!empty($_POST['reason_inbasket'])?$_POST['reason_inbasket']:NULL;
			$question_values->priority_inbasket=!empty($_POST['priority_inbasket'])?$_POST['priority_inbasket']:NULL;
			$question_values->inbasket_mode=$inbasket_action;
			$question_values->save();
			$this->session->set_flashdata('inbasket',"Your Inbasket Intray has been updated");
			redirect('admin/inbasket_exercises_master?status=questions&id='.$_POST['inbasket_id'].'&hash='.md5(SECRET.$_POST['inbasket_id']));
		}
	}
	
	public function reminder_assessment(){
		$id=trim($_REQUEST['val']);
		if(!empty($id) && is_numeric($id)){
			$uewi=Doctrine_Query::create()->from('UlsAssessmentEmployees')->where('assessment_id='.$id)->execute();
			if(count($uewi)!=0){
				$emp_id=array();
				$ass_position=UlsAssessmentPosition::getassessmentpositions($id);
				foreach($ass_position as $ass_positions){
					$employee=UlsAssessmentEmployees::get_status_assessment_mail($id,$ass_positions['position_id']);
					foreach($employee as $key=>$employees){
						$ass_test=UlsAssessmentTest::assessment_test_report($id,$ass_positions['position_id']);
						foreach($ass_test as $ass_tests){
							if($ass_tests['assessment_type']=='TEST'){
								$test_emp=UlsMenu::callpdo("Select table1.empid,table1.enumber,table1.email from (SELECT b.employee_id AS empid, b.employee_number AS enumber, b.full_name AS name,email FROM  `uls_employee_work_info` a LEFT JOIN (SELECT employee_id, parent_org_id, employee_number, full_name,email,current_employee_flag FROM  `uls_employee_master` GROUP BY employee_id )b ON a.employee_id = b.employee_id WHERE b.`employee_id`=".$employees['employee_id']." and  a.`parent_org_id` =".$_SESSION['parent_org_id']." and a.status='A' AND b.email <> '' group by b.employee_number) as table1 where table1.empid NOT IN (SELECT employee_id FROM `uls_utest_attempts_assessment` where `assessment_id`=".$employees['assessment_id']." and test_type='TEST' and event_id=".$ass_tests['assess_test_id']." and test_id=".$ass_tests['test_id'].")");
								foreach($test_emp as $test_emps){
									$emp_id[]=$test_emps['empid'];
								}
								
							}
							
							elseif($ass_tests['assessment_type']=='INBASKET'){
								$test_inbasket=UlsAssessmentTestInbasket::viewinbasket_count_report($id,$ass_positions['position_id']);
								foreach($test_inbasket as $key=>$test_inbaskets){
								$inb_emp=UlsMenu::callpdo("Select table1.empid,table1.enumber,table1.email from (SELECT b.employee_id AS empid, b.employee_number AS enumber, b.full_name AS name,email FROM  `uls_employee_work_info` a LEFT JOIN (SELECT employee_id, parent_org_id, employee_number, full_name,email,current_employee_flag FROM  `uls_employee_master` GROUP BY employee_id )b ON a.employee_id = b.employee_id WHERE b.`employee_id`=".$employees['employee_id']." and  a.`parent_org_id` =".$_SESSION['parent_org_id']." and a.status='A' AND b.email <> '' group by b.employee_number) as table1 where table1.empid NOT IN (SELECT employee_id FROM `uls_utest_attempts_assessment` where `assessment_id`=".$employees['assessment_id']." and test_type='INBASKET' and event_id=".$test_inbaskets['assess_test_id']." and test_id=".$test_inbaskets['test_id'].")");
									foreach($inb_emp as $inb_emps){
										$emp_id[]=$inb_emps['empid'];
									}
								}
							}
							elseif($ass_tests['assessment_type']=='CASE_STUDY'){
								$test_casestudy=UlsAssessmentTestCasestudy::viewcasestudy_count_report($id,$ass_positions['position_id']);
								foreach($test_casestudy as $key=>$test_casestudys){
								
									$case_emp=UlsMenu::callpdo("Select table1.empid,table1.enumber,table1.email from (SELECT b.employee_id AS empid, b.employee_number AS enumber, b.full_name AS name,email FROM  `uls_employee_work_info` a LEFT JOIN (SELECT employee_id, parent_org_id, employee_number, full_name,email,current_employee_flag FROM  `uls_employee_master` GROUP BY employee_id )b ON a.employee_id = b.employee_id WHERE b.`employee_id`=".$employees['employee_id']." and  a.`parent_org_id` =".$_SESSION['parent_org_id']." and a.status='A' AND b.email <> '' group by b.employee_number) as table1 where table1.empid NOT IN (SELECT employee_id FROM `uls_utest_attempts_assessment` where `assessment_id`=".$employees['assessment_id']." and test_type='CASE_STUDY' and event_id=".$test_casestudys['assess_test_id']." and test_id=".$test_casestudys['test_id'].")");
									foreach($case_emp as $case_emps){
										$emp_id[]=$case_emps['empid'];
									}
								}
							}
							elseif($ass_tests['assessment_type']=='BEHAVORIAL_INSTRUMENT'){
								$test_beh=UlsAssessmentTestBehavorialInst::viewbehavorial_count($id,$ass_positions['position_id']);
								foreach($test_beh as $key=>$test_behs){
									$beh_emp=UlsMenu::callpdo("Select table1.empid,table1.enumber,table1.email from (SELECT b.employee_id AS empid, b.employee_number AS enumber, b.full_name AS name,email FROM  `uls_employee_work_info` a LEFT JOIN (SELECT employee_id, parent_org_id, employee_number, full_name,email,current_employee_flag FROM  `uls_employee_master` GROUP BY employee_id )b ON a.employee_id = b.employee_id WHERE b.`employee_id`=".$employees['employee_id']." and  a.`parent_org_id` =".$_SESSION['parent_org_id']." and a.status='A' AND b.email <> '' group by b.employee_number) as table1 where table1.empid NOT IN (SELECT employee_id FROM `uls_bei_attempts_assessment` where `assessment_id`=".$employees['assessment_id']." and test_type='BEHAVORIAL_INSTRUMENT' and event_id=".$test_behs['assess_test_id']." and instrument_id=".$test_behs['instrument_id'].")");
									foreach($beh_emp as $beh_emps){
										$emp_id[]=$beh_emps['empid'];
									}
								}
							}
						}
						
					}
					echo "<pre>";
						print_r(array_merge(array_unique($emp_id)));
						/* $emp=!empty($emp_id)?array_unique($emp_id):"";
						foreach($emp as $emps){
							echo $empdetails="SELECT full_name, employee_number,office_number,employee_id,email FROM uls_employee_master a left join (SELECT `user_id`,`employee_id`,`user_name`,`password` FROM `uls_user_creation` GROUP BY employee_id)u ON a.employee_id = u.employee_id where a.parent_org_id=".$_SESSION['parent_org_id']." and a.employee_id=".$emps;
							
							//echo 1;
						} */
				}
			}
			else{
				echo "Selected Assessment cannot be deleted. This particular Assessment has been used in transaction table.";
			}
		}
	}
	
	public function casestudy_question_edit(){
		$q_id=$_REQUEST['q_id'];
		$case_id=$_REQUEST['case_id'];
		$data="";
		$case_study_questions=UlsCaseStudyQuestions::view_casestudy_question($q_id);
		$competencymsdetails=UlsCompetencyDefinition::competency_details("MS");
		$competencynmsdetails=UlsCompetencyDefinition::competency_details("NMS");
		$level_master=UlsLevelMaster::levels();
		$scale_master=UlsLevelMasterScale::scale_values();
		$data.="<form id='case_master".$case_id."' action='".BASE_URL."/admin/casestudy_competency_edit' method='post' enctype='multipart/form-data'>
		<input type='hidden' name='casestudy_id' id='casestudy_id' value='".$case_id."'>
		<input type='hidden' name='casestudy_quest_id' id='casestudy_quest_id' value='".$q_id."'>

		<div class='row'>
			<div class='col-lg-12'>
				<div class='row'>
					<div class='form-group col-lg-12'>
						<label class='control-label mb-10 text-left'>Question Name<sup><font color='#FF0000'>*</font></sup>:</label>
						<textarea type='text' name='casestudy_quest' class='validate[required,minSize[3]]  form-control summernote' id='casestudy_quest' style='resize:none;'  data-prompt-target='prompt-req-summary' data-prompt-position='inline'>".$case_study_questions['casestudy_quest']."</textarea>
					</div>
					<div class='form-group col-lg-12'>
						<label class='control-label mb-10 text-left'>Suggested Answer:</label>
						<textarea type='text' name='casestudy_quest_answer' class='validate[minSize[3]]  form-control summernote' id='casestudy_quest_answer' style='resize:none;'  data-prompt-target='prompt-req-summary' data-prompt-position='inline'>".$case_study_questions['casestudy_quest_answer']."</textarea>
					</div>
					<div class='panel-heading hbuilt'>
						
						<div class='pull-left'>
							<h6 class='panel-title txt-dark'>Add Competencies</h6>
						</div>
						<div class='pull-right'>
							<a class='btn btn-xs btn-primary' onClick='return addsource_details_casestudy_edit()'>&nbsp <i class='fa fa-plus-circle'></i> Add &nbsp </a>
							<a class='btn btn-danger btn-xs' onClick='delete_casestudy_edit()'>&nbsp <i class='fa fa-trash-o'></i>  Delete &nbsp </a>
						</div>
						<div class='clearfix'></div>
					</div>
					<div class='table-responsive'>
						<table id='source_table_program_s' cellpadding='1' cellspacing='1' class='table table-bordered table-striped'>
							<thead>
							<tr>
								<th>Select</th>
								<th>Competency Name</th>
								<th>Level Name</th>
								<th>Level Scale</th>
							</tr>
							</thead>
							<tbody>";
							$comp_details=UlsCaseStudyCompMap::getcasestudycompetencies($case_study_questions['casestudy_quest_id']);
							if(!empty($comp_details)){
								$hide_val=array();
								foreach($comp_details as $key=>$comp_detail){
									
									$key1=$key+1; $hide_val[]=$key1;
								$data.="<tr id='subgrd_".$key1."'>
									<td><label><input type='checkbox' id='chkbox_inst".$key1."' name='chkbox[]' value='".$comp_detail['case_map_id']."' ></label>
									<input type='hidden' id='case_map_id".$key1."' name='case_map_id[]' value='".$comp_detail['case_map_id']."'>
									</td>
									<td>
										<select class='form-control m-b' name='casestudy_competencies[]' id='casestudy_competencies_".$key1."'  onchange='open_level_edit(".$key1.");'>
											<option value=''>Select</option>
											<optgroup label='MS'>";
											foreach($competencymsdetails as $competencydetail){
												$select_ms=isset($comp_detail['comp_def_id'])?($comp_detail['comp_def_id']==$competencydetail['comp_def_id'])?"selected='selected'":"":"";
												$data.="<option value='".$competencydetail['comp_def_id']."' ".$select_ms." >".$competencydetail['comp_def_name']."</option>";
											}
											$data.="</optgroup>
											<optgroup label='NMS'>";
											foreach($competencynmsdetails as $competencydetail){
												$select_nms=isset($comp_detail['comp_def_id'])?($comp_detail['comp_def_id']==$competencydetail['comp_def_id'])?"selected='selected'":"":"";
												$data.="<option value='".$competencydetail['comp_def_id']."' ".$select_nms.">".$competencydetail['comp_def_name']."</option>";
											}
											$data.="</optgroup>
										</select>
									</td>
									<td>
										<select class='form-control m-b' name='casestudy_level[]' id='casestudy_level_".$key1."' onchange='open_scale_edit(".$key1.");'>
											<option value=''>Select</option>";
											if(!empty($comp_detail['level_id'])){
												foreach($level_master as $level_masters){
													$levels=isset($comp_detail['level_id'])?($comp_detail['level_id']==$level_masters['level_id'])?"selected='selected'":"":"";
													$data.="<option value='".$level_masters['level_id']."' ".$levels.">".$level_masters['level_name']."</option>";
												}
											}
										$data.="</select>
									</td>
									<td>
										<select class='form-control m-b' name='casestudy_scale[]' id='casestudy_scale_".$key1."'>
											<option value=''>Select</option>";
											if(!empty($comp_detail['scale_id'])){
												foreach($scale_master as $scale_masters){
												$scale=isset($comp_detail['scale_id'])?($comp_detail['scale_id']==$scale_masters['scale_id'])?"selected='selected'":"":"";
												$data.="<option value='".$scale_masters['scale_id']."' ".$scale.">".$scale_masters['scale_name']."</option>";
												}
											}	
										$data.="</select>
									</td>
								</tr>";
								}
								$hidden=@implode(',',$hide_val);
							}
							else{
								$data.="<tr id='subgrd_1'>
									<td><label><input type='checkbox' id='chkbox_inst1' name='chkbox[]' value=''></label>
									<input type='hidden' id='case_map_id1' name='case_map_id[]' value=''>
									</td>
									<td>
										<select class='form-control m-b' name='casestudy_competencies[]' id='casestudy_competencies1'  onchange='open_level(1);'>
											<option value=''>Select</option>
											<optgroup label='MS'>";
											foreach($competencymsdetails as $competencydetail){
												$data.="<option value='".$competencydetail['comp_def_id']."'  >".$competencydetail['comp_def_name']."</option>";
											}
											$data.="</optgroup>
											<optgroup label='NMS'>";
											foreach($competencynmsdetails as $competencydetail){
												$data.="<option value='".$competencydetail['comp_def_id']."' >".$competencydetail['comp_def_name']."</option>";
											}
											$data.="</optgroup>
										</select>
									</td>
									<td>
										<select class='form-control m-b' name='casestudy_level[]' id='casestudy_level1' onchange='open_scale(1);'>
											<option value=''>Select</option>
										</select>
									</td>
									<td>
										<select class='form-control m-b' name='casestudy_scale[]' id='casestudy_scale1'>
											<option value=''>Select</option>

										</select>
									</td>
								</tr>";
								$hidden=1;
							}
							$data.="</tbody>
							<input type='hidden' name='addgroup_n' id='addgroup_n' value='".$hidden."' />
						</table>
					</div>
				</div>
			</div>
		</div>
		<hr class='light-grey-hr'>
		<div class='form-group'>
			<div class='col-sm-offset-7'>
				<button class='btn btn-danger btn-sm' type='button' onclick='create_link('case_study_master_search')'><i class='fa fa-reply'></i> <span class='bold'>Cancel</span></button>
				<button class='btn btn-primary btn-sm' type='submit' name='submit' id='submit' onclick='return addsource_details_casestudy_validation_edit(2);'><i class='fa fa-check'></i> Edit Questions</button>
			</div>
		</div>
		</form>";
		echo $data;
	}
	
	public function casestudy_competency_edit(){
		$this->sessionexist();
		if(isset($_POST['casestudy_quest'])){
			$fieldinsertupdates=array('casestudy_quest','casestudy_quest_answer');
			$case=Doctrine::getTable('UlsCaseStudyQuestions')->find($_POST['casestudy_quest_id']);
            !isset($case->casestudy_quest_id)?$case=new UlsCaseStudyQuestions():"";
            foreach($fieldinsertupdates as $val){
				$case->$val=(!empty($_POST[$val]))?($_POST[$val]):NULL;
			}
			$case->casestudy_id=$_POST['casestudy_id'];
			$case->save();
			
			foreach($_POST['casestudy_competencies'] as $key=>$value){
				$work_activation=(!empty($_POST['case_map_id'][$key]))?Doctrine::getTable('UlsCaseStudyCompMap')->find($_POST['case_map_id'][$key]):new UlsCaseStudyCompMap;
				$work_activation->casestudy_quest_id=$case->casestudy_quest_id;
				$work_activation->comp_def_id=$value;
				$work_activation->level_id=$_POST['casestudy_level'][$key];
				$work_activation->scale_id=$_POST['casestudy_scale'][$key];
				$work_activation->casestudy_id=$_POST['casestudy_id'];
				$work_activation->save();
			}
			$this->session->set_flashdata('casestudy_admin',"Your casestudy competencies has been ".(!empty($_POST['casestudy_id'])?"updated":"inserted")." successfully.");
			redirect('admin/case_study_master?status=questions&id='.$_POST['casestudy_id']);
		}
	}
	
	public function delete_casestudy(){
		$id=trim($_REQUEST['val']);
		if(!empty($id)){
			$casestudy=UlsCaseStudyQuestions::view_casestudy_question($id);
			$casestudy_value=UlsAssessmentTestCasestudy::get_casestudy_values($casestudy['casestudy_id']);
			if(count($casestudy_value)==0){
				$play=Doctrine_Query::Create()->delete('UlsCaseStudyQuestions')->where("casestudy_quest_id=".$id)->execute();
				$play_comp=Doctrine_Query::Create()->delete('UlsCaseStudyCompMap')->where("casestudy_quest_id=".$id)->execute();
				echo 1;
			}
			else{
				echo "Selected casestudy cannot be deleted. Ensure you delete all the usages of the casestudy before you delete it.";
			}
		}
	}
	
	public function assessment_question_validation()
	{
		$data["aboutpage"]=$this->pagedetails('admin','assessment_qvalidation');
		$org_stat="STATUS";
        $data["orgstat"]=UlsAdminMaster::get_value_names($org_stat);
		if(!empty($_REQUEST['id'])){
			$compdetails=UlsAssessmentDefinition::viewassessment($_REQUEST['id']);
            $data['compdetails']=$compdetails;
			$data['position_details']=UlsAssessmentPosition::getassessmentpositions($compdetails['assessment_id']);
		}
		$data["rating"]=UlsRatingMaster::rating_details();
		$data["positions"]=UlsPosition::fetch_all_pos();
		$content = $this->load->view('admin/assessment_question_validation',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function get_position_questions(){
		$ass_id=$_REQUEST['assessment_id'];
		$pos_id=$_REQUEST['position_id'];
		$ass_type="TEST";
		$data="";
		$ass_test=UlsAssessmentTest::get_ass_position($ass_id,$pos_id,$ass_type);
		if(!empty($ass_test['assess_test_id'])){
		$testdetails=UlsAssessmentTest::assessment_view_finals($ass_test['assess_test_id']);
		
		$data.="<hr class='light-grey-hr'>
		<div class='table-responsive'>
			<table class='table table-hover table-bordered mb-0' cellspacing='1' cellpadding='1' id='thetable'>
				<thead>
					<tr>
						<th style='width:10px;'>S.No</th>
						<th style='width:500px;'>Question Name </th>
						<th style='width:200px;'>Competency</th>
						<th style='width:130px;'>Level</th>
						<th style='width:50px;'>Action</th>
					</tr>
				</thead>
				<tbody>";
				foreach($testdetails as $key=>$que){
					$ques_check=UlsAssessmentTest::get_question_check($ass_id,$pos_id,$que['competency_id'],$que['question_id']);
					$check=!empty($ques_check['q_count'])?"style='color:red'":"";
					$keys=$key+1;
					$ques=$que['question_id'];
					$type=$que['type_flag'];
					$data.="<tr>
						<td>".$keys."</td>
						<td ".$check.">".$que['question_name']."</td>
						<td>".$que['comp_def_name']."</td>
						<td>".$que['scale_name']."</td>
						<td><a class='mr-10' data-target='#workinfoviewadd".$que['assessment_test_id']."' data-toggle='modal' href='#workinfoviewadd".$que['assessment_test_id']."' data-toggle='tooltip' data-placement='top' title='Add/Remove Question' onclick='delete_question_test(".$que['assessment_test_id'].",".$que['assess_test_id'].")'><i class='fa fa-trash-o text-danger'></i></a></td>
					</tr>
					<div id='workinfoviewadd".$que['assessment_test_id']."'  class='modal fade' tabindex='-1' role='dialog'  aria-hidden='true'>
						<div class='modal-dialog modal-lg'>
							<div class='modal-content'>
								<div class='color-line'></div>
								<div class='modal-header'>
									<h6 class='modal-title'>Questions Add/Remove In Test</h6>
								</div>
								<div class='modal-body'>
									<div id='questionbank_count".$que['assessment_test_id']."' class='modal-body no-padding'>
									
									</div>
								</div>
							</div>
						</div>
					</div>";
				}
				$data.="</tbody>
			</table>
		</div>
		<div class='hr-line-dashed'></div>
		<div class='seprator-block' style='margin-bottom: 10px;'></div>
		<div class='row'>
			<div class='col-md-offset-9 col-md-9'>
				<button class='btn btn-info btn-icon left-icon  mr-10' type='button' onclick='get_check_question(".$ass_test['assess_test_id'].")'> <i class='zmdi zmdi-edit'></i> <span>Preview Test Paper</span></button>
			</div>
		</div>
		<div class='seprator-block' style='margin-bottom: 10px;'></div>
		";
		}
		else{
			$data.="Test Not Added";
		}
		echo $data;
	}
	
	
	public function get_position_question_validation(){
		$assessment_test_id=$_REQUEST['assessment_test_id'];
		$assess_test_id=$_REQUEST['assess_test_id'];
		$ass_test_ques=UlsAssessmentTestQuestions::get_question_val($assessment_test_id,$assess_test_id);
		$ass_ques=UlsAssessmentTestQuestions::get_question_ids($assess_test_id,$ass_test_ques['comp_def_id']);
		//echo $ass_ques['question_ids'];
		$questions=UlsCompetencyTestQuestions::get_test_question_ids($ass_test_ques['test_id'],$ass_test_ques['comp_def_id'],$ass_ques['question_ids']);
		//echo $ass_test_ques['test_id']."-".$assess_test_id."-".$ass_test_ques['comp_def_id']."-".$ass_test_ques['scale_id'];
		$data="";
		$data.="
		<form id='case_master' action='".BASE_URL."/admin/assessement_question_insert' method='post' enctype='multipart/form-data'>
		<input type='hidden' name='assessment_test_id' id='assessment_test_id' value='".$assessment_test_id."'>
		<input type='hidden' name='assessment_id' id='assessment_id' value='".$ass_test_ques['assessment_id']."'>
		<input type='hidden' name='position_id' id='position_id' value='".$ass_test_ques['position_id']."'>
		<table cellspacing='1' cellpadding='1' class='table table-bordered table-striped'>
			<thead>
				<tr>
					<th style=' background-color: #edf3f4;width:20%'>Competency Name</th>
					<th>".$ass_test_ques['comp_def_name']."</th>
				</tr>
				<tr>
					<th style=' background-color: #edf3f4;width:20%'>Scale Name</th>
					<th>".$ass_test_ques['scale_name']."</th>
				</tr>
			</thead>
		</table>
		
		<div class='table-responsive'>
			<table class='table table-hover table-bordered mb-0' cellspacing='1' cellpadding='1' id='thetable'>
				<thead>
					<tr>
						<th style='width:10px;'>Select</th>
						<th style='width:800px;'>Question Name </th>
					</tr>
				</thead>
				<tbody>";
				foreach($questions as $questionss){
					$ques_check=UlsAssessmentTest::get_question_check($ass_test_ques['assessment_id'],$ass_test_ques['position_id'],$ass_test_ques['comp_def_id'],$questionss['question_id']);
					$check=!empty($ques_check['q_count'])?"style='color:red'":"";
					$data.="<tr>
						<td>
							<input type='radio' name='ques_id' id='ques_id' value='".$questionss['test_quest_id']."'>
							<input type='hidden' name='question_id_".$questionss['test_quest_id']."' id='question_id' value='".$questionss['question_id']."'>
						</td>
						<td ".$check.">".$questionss['question_name']."</td>
					</tr>";
				}
				$data.="</tbody>
			</table>
		</div>
		<div class='modal-footer'>
			<button data-dismiss='modal' class='btn btn-default' type='button'>Close</button>
			<button class='btn btn-danger' type='submit' name='submit' id='submit'>Save changes</button>
		</div>
		</form>";
		echo $data;
	}
	
	public function assessement_question_insert(){
		if(!empty($_POST['ques_id'])){
			/* echo "<pre>";
			print_r($_POST); */
			$q_id='question_id_'.$_POST['ques_id'];
			$update=Doctrine_Query::create()->update('UlsAssessmentTestQuestions');
			$update->set('test_quest_id','?',$_POST['ques_id']);
			$update->set('question_id','?',$_POST[$q_id]);
			$update->where('assessment_test_id=?',$_POST['assessment_test_id']);
			$update->execute();
			$assessment_id=$_POST['assessment_id'];
			$hash=SECRET.$assessment_id;
			redirect("admin/assessment_question_validation?id=".$assessment_id."&pos_id=".$_POST['position_id']."&hash=".md5($hash));
		}
	}
	
	public function position_assessment_statusreport(){
		$id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
		if($id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$data['comp_details']=UlsAssessmentCompetencies::getassessmentcompetencies_report($id);
			$content = $this->load->view('admin/position_assessment_statusreport',$data,true);
		}
		$this->render('layouts/report-layout',$content);
	}
	
	public function migration_master_search(){
		$data["aboutpage"]=$this->pagedetails('admin','migration_master_search');
		$limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
        $page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
        $start=$page!=0? ($page-1)*$limit:0;
        $filePath=BASE_URL."/admin/migration_master_search";
        $data['limit']=$limit;
        $data['perpages']=UlsMenuCreation::perpage();
        $data['searchresults']=UlsCompetencyMigrationContentMaster::search($start, $limit);
        $total=UlsCompetencyMigrationContentMaster::searchcount();
        $otherParams="&perpage=".$limit;
        $data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/migration_master_search',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function migration_master()
	{
		$data["aboutpage"]=$this->pagedetails('admin','migration_master');
		$id=filter_input(INPUT_GET,'course_id') ? filter_input(INPUT_GET,'course_id'):"";
        $hash=filter_input(INPUT_GET,'hash') ? filter_input(INPUT_GET,'hash'):"";
        $menutype=!empty($id)? UlsMenuCreation::menutype($id):"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			$data['migmaster']=UlsCompetencyMigrationContentMaster::viewmigration($id);
			$data['migcompetencies']=UlsCompetencyMigrationContentProgram::migration_competencies($id);
			$data['competencies']=UlsCompetencyDefinition::competency_details("MS");
			$data['status']=UlsAdminMaster::get_value_names("STATUS");
			$adminvalues="MIGRATE_TYPE";
			$data['migrations']=UlsAdminMaster::get_value_names($adminvalues);
			$content = $this->load->view('admin/migration_master',$data,true);
		}
		$this->render('layouts/adminnew',$content);

	}
	
	public function delete_comp_migration(){
		if(!empty($_REQUEST['val'])){
			$play=Doctrine_Query::Create()->delete('UlsCompetencyMigrationContentProgram')->where("pro_id=".$_REQUEST['val'])->execute();
			echo 1;
		}
		else{
			echo "Selected KRA Competency cannot be deleted. Ensure you delete all the usages of the KRA Competency before you delete it.";
		}
	}
	
	public function lms_migration_master(){
        if(isset($_POST['course_id'])){ //print_r($_POST);
            $level=(!empty($_POST['course_id']))?Doctrine::getTable('UlsCompetencyMigrationContentMaster')->find($_POST['course_id']):new UlsCompetencyMigrationContentMaster();
			$level->migration_type=$_POST['migration_type'];
			$level->type=$_POST['type'];
            $level->program_name=$_POST['program_name'];
			$level->program_objective=$_POST['program_objective'];
			$level->program_link=$_POST['program_link'];
            $level->status=$_POST['status_mig'];
            $level->save();
			foreach($_POST['comp_def_id'] as $k=>$value){
				if(!empty($_POST['comp_def_id'][$k])){
					$subl=(!empty($_POST['pro_id'][$k]))?Doctrine::getTable('UlsCompetencyMigrationContentProgram')->find($_POST['pro_id'][$k]):new UlsCompetencyMigrationContentProgram();
					$subl->comp_def_id=$value;
					$subl->scale_id=$_POST['scale_id'][$k];
					$subl->status=$_POST['status'][$k];
					$subl->course_id=$level->course_id;
					$subl->save();
				}
				
			}
			$this->session->set_flashdata('kra_msg',"Kra data ".(!empty($_POST['course_id'])?"updated":"inserted")." successfully.");
			redirect("admin/migration_view?course_id=".$level->course_id);
        }
        else{
			$content = $this->load->view('admin/migration_master_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }
	
	public function migration_view(){
		$data["aboutpage"]=$this->pagedetails('admin','migration_view');
        $id=isset($_REQUEST['course_id'])? $_REQUEST['course_id']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1 || $id==""){
            $content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			$data['migmaster']=UlsCompetencyMigrationContentMaster::view_migration($id);
			$data['migcompetencies']=UlsCompetencyMigrationContentProgram::migration_comp($id);
			$content = $this->load->view('admin/migration_view',$data,true);
        }
		$this->render('layouts/adminnew',$content);
    }
	
	public function migration_competency_scale(){
		$com_id=$_REQUEST['com_id'];
		$row_id=isset($_REQUEST['r_id'])?$_REQUEST['r_id']:"";
		$aa="";
		
		if(!empty($com_id) && !empty($row_id)){
			$level=UlsCompetencyDefinition::viewcompetency($com_id);
			$scales=UlsLevelMasterScale::levelscale($level['comp_def_level']);
		
			$aa.="<select name='scale_id[]' id='scale_id_".$row_id."' style='width:100%;' class='form-control m-b'>
				<option value=''>Select</option>";
				foreach($scales as $scale){
					$aa.="<option value='".$scale['scale_id']."'>".$scale['scale_name']."</option>";
				}
			$aa.="</select>";
		}
		echo $aa;
	}
	
	public function assessment_emp_status_report(){
		$ass_id=isset($_REQUEST['ass_id'])? $_REQUEST['ass_id']:"";
		$ass_type=isset($_REQUEST['ass_type'])? $_REQUEST['ass_type']:"";
		$pos_id=isset($_REQUEST['pos_id'])? $_REQUEST['pos_id']:"";
		if($ass_id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$data['username']=UlsReports::getusername();
			$data['type']=isset($_REQUEST['typeid'])? $_REQUEST['typeid']:"";
			$data['test_beh']=UlsAssessmentTestBehavorialInst::viewbehavorial_count($ass_id,$pos_id);
			$data['test_casestudy']=UlsAssessmentTestCasestudy::viewcasestudy_count_report($ass_id,$pos_id);
			
			$data['test_inbasket']=UlsAssessmentTestInbasket::viewinbasket_count_report($ass_id,$pos_id);
			
			$data['test_fishbone']=UlsAssessmentTestFishbone::viewfishbone_count_report($ass_id,$pos_id);
			$data['test_feedback']=UlsAssessmentTestFeedback::viewfeedback_count_report($ass_id,$pos_id);
			$data['ass_test']=UlsAssessmentTest::assessment_test_report($ass_id,$pos_id);
			$data['ass_test_status']=UlsAssessmentTest::assessment_test_report_status($ass_id,$pos_id);
			$data['employee']=UlsAssessmentEmployees::get_status_assessmentreport($ass_id,$ass_type,$pos_id);
			$posiddata=!empty($_REQUEST['pos_id'])? " and a.position_id=".$_REQUEST['pos_id']:"";
			/* $data['ass_emp']=UlsMenu::callpdo("SELECT a.*,b.assessor_name FROM `uls_assessment_position_assessor` a
			left join(SELECT `assessor_id`,`assessor_name` FROM `uls_assessor_master`) b on b.assessor_id=a.assessor_id
			where a.`assessment_id`=".$ass_id." ".$posiddata.""); */
			$content = $this->load->view('report/lms_report_assessment_status',$data,true);
		}
		$this->render('layouts/report-layout',$content);
	}
	
	public function feedback_assessment_statusreport(){
		$id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
		if($id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$data['feed_details']=UlsAssessmentFeedbackEmployees::view_feedback($id);
			$content = $this->load->view('admin/assessment_feedback_statusreport',$data,true);
		}
		$this->render('layouts/report-layout',$content);
	}
	
	public function feedback_assessment_tna_feed_statusreport(){
		$id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
		if($id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$data['feed_details']=UlsAssessmentEmployeeJourney::get_assessment_employees_tna($id);
			$content = $this->load->view('admin/assessment_feedback_tna_statusreport',$data,true);
		}
		$this->render('layouts/report-layout',$content);
	}
	
	public function scale_question_values(){
		$com_id=$_REQUEST['cid'];
		$scale_id=$_REQUEST['s_id'];
		$scale_count=UlsQuestionbank::get_questions_scale_count($com_id,$scale_id);
		$data="";
		$data.="<label id='scale_count_".$com_id."'># of Questions:".count($scale_count)."</label>";
		echo $data;
	}
	
	public function rcreport(){		
		$this->load->library('tcpdf');
		$data=array();
		echo $content = $this->load->view('admin/adani-power',$data,true);		
		$this->render('layouts/ajax-layout',$content);
	}
	
	public function insert_question_indicator(){
		$qus_id=$_REQUEST['qus_id'];
		$level_id=$_REQUEST['level_id'];
		$comp_id=$_REQUEST['comp_id'];
		$data="";
		$level_indicators=UlsCompetencyDefLevelIndicator::getcompdef_level_indicator_details($comp_id,$level_id,$qus_id);
		$data.="
		<form id='intray_val' action='".BASE_URL."/admin/insert_indicator_details'  method='post' enctype='multipart/form-data'>
			<input type='hidden' name='question_id' value='".$qus_id."'>
			<input type='hidden' name='scale_id' value='".$level_id."'>
			<input type='hidden' name='comp_def_id' value='".$comp_id."'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
				<h5 class='modal-title' id='myLargeModalLabel'>Add Indicator</h5>
			</div>
			<div class='modal-body'>
				<div class='panel-body'>
					<div class='table-responsive'>
						<table cellpadding='1' cellspacing='1' class='table table-bordered table-striped'>
							<thead>
							<tr>
								<th width='5%'>Select</th>
								<th width='95%'>Indicators</th>
							</tr>
							</thead>
							<tbody>";
							foreach($level_indicators as $levelindicator){
								$check=!empty($levelindicator['comp_def_que_ind'])?"checked='checked'":"";
								$data.="<tr>
									<td>
										<label>
										<input type='hidden' name='ind_id[".$levelindicator['comp_def_level_ind_id']."]'  value='".$levelindicator['comp_def_que_ind']."'>
										<input type='checkbox' name='comp_def_level_ind_id[]' value='".$levelindicator['comp_def_level_ind_id']."' ".$check."></label>
									</td>
									<td>".$levelindicator['comp_def_level_ind_name']."</td>
								</tr>";
							}
							$data.="</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-danger text-left' data-dismiss='modal'>Close</button>
				<button class='btn btn-primary btn-sm' type='submit' name='save' id='save'> Save</button>
			</div>
		</form>";
		echo $data;
	}
	
	public function insert_indicator_details(){
		if(isset($_POST['comp_def_level_ind_id'])){
			foreach($_POST['comp_def_level_ind_id'] as $key=>$v){
				$work_activation=(!empty($_POST['ind_id'][$v]))?Doctrine::getTable('UlsCompetencyDefQueIndicators')->find($_POST['ind_id'][$v]):new UlsCompetencyDefQueIndicators;
				$work_activation->comp_def_level_ind_id=$v;
				$work_activation->question_id=$_POST['question_id'];
				$work_activation->comp_def_id=$_POST['comp_def_id'];
				$work_activation->scale_id=$_POST['scale_id'];
				$work_activation->save();
			}
			redirect('admin/competency_levels?id='.$_POST['comp_def_id'].'&hash='.md5(SECRET.$_POST['comp_def_id']),'admin-layout');
		}
	}
	
	public function assessment_final_report(){
		$id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
		if($id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$data['ass_id']=$id;
			$data['position_details']=UlsAssessmentPosition::getassessmentpositions($id);
			$content = $this->load->view('admin/assessment_final_statusreport',$data,true);
		}
		$this->render('layouts/report-layout',$content);
	}
	
	public function location_employee_search()
	{
		$data["aboutpage"]=$this->pagedetails('admin','employee_search_report');
        $limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
        $emp_name=filter_input(INPUT_GET,'emp_name') ? filter_input(INPUT_GET,'emp_name'):"";
        $emp_number=filter_input(INPUT_GET,'emp_number') ? filter_input(INPUT_GET,'emp_number'):"";
		$assessment_id=filter_input(INPUT_GET,'assessment_id') ? filter_input(INPUT_GET,'assessment_id'):"";
        $page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
        $start=$page!=0? ($page-1)*$limit:0;
        $filePath=BASE_URL."/admin/location_employee_search";
        $data['limit']=$limit;
        $data['emp_name']=$emp_name;
        $data['emp_number']=$emp_number;
		$data['assessment_id']=$assessment_id;
        $data['perpages']=UlsMenuCreation::perpage();
		$data['ass_name']=UlsEmployeeMaster::search_report_ass();
        $data['empdetails']=UlsEmployeeMaster::search_report($start, $limit,$emp_name,$emp_number,$assessment_id);
        $total=UlsEmployeeMaster::searchcount_report($emp_name,$emp_number,$assessment_id);
        $otherParams="perpage=".$limit."&emp_number=".$emp_number."&emp_name=".$emp_name."&assessment_id=".$assessment_id;
        $data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/location_employee_search',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function hr_employee_search()
	{
		$data["aboutpage"]=$this->pagedetails('admin','hr_employee_search');
        $limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
        $emp_name=filter_input(INPUT_GET,'emp_name') ? filter_input(INPUT_GET,'emp_name'):"";
        $emp_number=filter_input(INPUT_GET,'emp_number') ? filter_input(INPUT_GET,'emp_number'):"";
		$assessment_id=filter_input(INPUT_GET,'assessment_id') ? filter_input(INPUT_GET,'assessment_id'):"";
        $page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
        $start=$page!=0? ($page-1)*$limit:0;
        $filePath=BASE_URL."/admin/hr_employee_search";
        $data['limit']=$limit;
        $data['emp_name']=$emp_name;
        $data['emp_number']=$emp_number;
        $data['perpages']=UlsMenuCreation::perpage();
		$data['ass_name']=UlsEmployeeMaster::search_report_ass();
        $data['empdetails']=UlsEmployeeMaster::search_report($start, $limit,$emp_name,$emp_number,$assessment_id);
        $total=UlsEmployeeMaster::searchcount_report($emp_name,$emp_number,$assessment_id);
        $otherParams="perpage=".$limit."&emp_number=".$emp_number."&emp_name=".$emp_name."&assessment_id=".$assessment_id;
        $data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/hr_employee_search',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function assessor_employee_selection(){
		$pos_id=$_REQUEST['pos_id'];
		$asser_id=$_REQUEST['asser_id'];
		$ass_info=UlsAssessmentPositionAssessor::assessor_position_details($asser_id);
		$employees=UlsAssessmentEmployees::getassessmentemployees_position_report($ass_info['assessment_id'],$ass_info['position_id']);
		$data="";
		$data.='
		<form id="case_master'.$pos_id.'" action="'.BASE_URL.'/admin/assessor_mapped_employee_insert" method="post" enctype="multipart/form-data">
		<input type="hidden" name="assessment_pos_assessor_id" id="assessment_pos_assessor_id" value="'.$asser_id.'">
		<input type="hidden" name="assessment_id" id="assessment_id" value="'.$ass_info['assessment_id'].'">
		<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th></th>
					<th>Employee Code</th>
					<th>Employee name</th>
					<th>Department</th>
					<th>Position</th>
					<th>Location</th>
				</tr>
			</thead>
			<tbody>';
			$select_emp=!empty($ass_info['emp_ids'])?explode(',',$ass_info['emp_ids']):"";
			$selectemp=!empty($ass_info['emp_ids'])?$ass_info['emp_ids']:"";
			foreach($employees as $employee){
				if(!empty($select_emp)){
					$ched=in_array($employee['employee_id'],$select_emp) ? " checked='checked' disabled='disabled'" : "";	
				}
				else{
					$ched="";
				}
				
				$data.='<tr>
				<td><input type="checkbox" name="emp_selection['.$employee['employee_id'].']" id="emp_selection[]" value="'.$employee['employee_id'].'" class="selected_check" '.$ched.'></td>
				<td>'.$employee['employee_number'].'</td>
				<td>'.$employee['full_name'].'</td>
				<td>'.$employee['org_name'].'</td>
				<td>'.$employee['position_name'].'</td>
				<td>'.$employee['location_name'].'</td>
				</tr>';
			}
			$data.='</tbody>
		</table>
		<input type="hidden" name="emp_ids" value="'.$selectemp.'">
		<div class="modal-footer">
			<input type="button" class="btn btn-danger"  data-dismiss="modal" value="cancel"/>&nbsp;&nbsp;&nbsp;
			<input type="submit" name="single_save"  id="single_save" value="Save" class="btn btn-primary">
			
		</div>
		</form>
		';
		echo $data;
	}
	
	public function assessor_mapped_employee_insert(){
		if(isset($_POST['single_save'])){
			echo "<pre>";
			print_r($_POST);
			$work=(!empty($_POST['assessment_pos_assessor_id']))?Doctrine::getTable('UlsAssessmentPositionAssessor')->find($_POST['assessment_pos_assessor_id']):new UlsAssessmentPositionAssessor;
			$work->emp_ids=$_POST['emp_ids'];
			$work->save();
			redirect('admin/assessment_details?tab=3&pos_id='.$work->position_id.'&id='.$work->assessment_id.'&hash='.md5(SECRET.$work->assessment_id));
			//redirect('admin/assessment_details?tab=3&id='.$_POST['assessment_id'].'&hash='.md5(SECRET.$_POST['assessment_id'])); 
		}
	}
	
	public function assessment_data_report()
	{
		$ass_id=isset($_REQUEST['ass_id'])? $_REQUEST['ass_id']:"";
		$ass_type=isset($_REQUEST['ass_type'])? $_REQUEST['ass_type']:"";
		$pos_id=isset($_REQUEST['pos_id'])? $_REQUEST['pos_id']:"";
		if($ass_id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$data["aboutpage"]=$this->pagedetails('admin','assessment_search');
			$data['assessments']=UlsMenu::callpdo("SELECT a.* FROM `uls_assessment_definition` a WHERE 1 and a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.assessment_status='A' order by assessment_id desc");
			$data['ass_id']=$ass_id;
			$data['pos_id']=$pos_id;
			$data["emp_data"]=UlsAssessmentEmployees::get_assessment_employees($ass_id,$pos_id);
			$data["comp_data"]=UlsAssessmentCompetencies::get_assessment_competencies_report($ass_id,$pos_id);
			$content = $this->load->view('admin/assessment_data_report',$data,true);
			$this->render('layouts/report-layout',$content);
		}
	}
	
	public function fishbone_master_search()
	{
		$data["aboutpage"]=$this->pagedetails('admin','fishbone_master_search');
		$limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
        $fishbone_name=filter_input(INPUT_GET,'fishbone_name') ? filter_input(INPUT_GET,'fishbone_name'):"";
        $page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
        $start=$page!=0? ($page-1)*$limit:0;
        $filePath=BASE_URL."/admin/fishbone_master_search";
        $data['limit']=$limit;
        $data['fishbone_name']=$fishbone_name;
        $data['perpages']=UlsMenuCreation::perpage();
        $data['searchresults']=UlsFishboneMaster::search($start, $limit,$fishbone_name);
        $total=UlsFishboneMaster::searchcount($fishbone_name);
        $otherParams="&perpage=".$limit."&fishbone_name=$fishbone_name";
		$data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/fishbone_master_search',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function fishbone_master()
	{
		$data["aboutpage"]=$this->pagedetails('admin','fishbone_master');
		$org_stat="STATUS";
        $data["orgstat"]=UlsAdminMaster::get_value_names($org_stat);
		$case_stat="CASESTUDY_TYPE";
        $data["casestat"]=UlsAdminMaster::get_value_names($case_stat);
		$fish_stat="FISH_LIST";
        $data["fishstat"]=UlsAdminMaster::get_value_names($fish_stat);
		$yes_no="YES_NO";
		$data["yesno"]=UlsAdminMaster::get_value_names($yes_no);
		if(!empty($_REQUEST['id'])){
			$data["case_study"]=UlsFishboneMaster::viewfishbone($_REQUEST['id']);
			$data["case_study_questions"]=UlsFishboneStudyQuestions::viewfishbonequestion($_REQUEST['id']);
		}
		//$data["competency"]=UlsCompetencyDefinition::competency_details();
		$data['competencymsdetails']=UlsCompetencyDefinition::competency_details("MS");
		$data['competencynmsdetails']=UlsCompetencyDefinition::competency_details("NMS");
		$content = $this->load->view('admin/fishbone_master',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function fishbone_insert(){
        $this->sessionexist();
        if(isset($_POST['fishbone_id'])){
            $fieldinsertupdates=array('fishbone_name','fishbone_description','time_period','fishbone_status');
            $case=Doctrine::getTable('UlsFishboneMaster')->find($_POST['fishbone_id']);
            !isset($case->fishbone_id)?$case=new UlsFishboneMaster():"";
            foreach($fieldinsertupdates as $val){
				$case->$val=(!empty($_POST[$val]))?($_POST[$val]):NULL;
			}
			$case->save();
			$this->session->set_flashdata('case',"Fishbone data ".(!empty($_POST['fishbone_id'])?"updated":"inserted")." successfully.");
            redirect('admin/fishbone_master?status=competency&id='.$case->fishbone_id.'&hash='.md5(SECRET.$case->fishbone_id));
        }
        else{
			$content = $this->load->view('admin/fishbone_master_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }
	
	public function fishbone_competency_insert(){
		$this->sessionexist();
		if(isset($_POST['fishbone_quest'])){
			$fieldinsertupdates=array('fishbone_quest','fishbone_quest_answer');
			$case=Doctrine::getTable('UlsFishboneStudyQuestions')->find($_POST['fishbone_quest_id']);
            !isset($case->fishbone_quest_id)?$case=new UlsFishboneStudyQuestions():"";
            foreach($fieldinsertupdates as $val){
				$case->$val=(!empty($_POST[$val]))?($_POST[$val]):NULL;
			}
			$case->fishbone_id=$_POST['fishbone_id'];
			$case->save();
			
			foreach($_POST['probable_causes'] as $key=>$value){
				$work_activation=(!empty($_POST['fishbone_list_id'][$key]))?Doctrine::getTable('UlsFishboneListProbable')->find($_POST['fishbone_list_id'][$key]):new UlsFishboneListProbable;
				$work_activation->fishbone_quest_id=$case->fishbone_quest_id;
				$work_activation->probable_causes=$value;
				$work_activation->head_list=$_POST['head_list'][$key];
				$work_activation->top_reason=!empty($_POST['top_reason'][$key])?$_POST['top_reason'][$key]=='Y'?1:NULL:NULL;
				$work_activation->fishbone_id=$_POST['fishbone_id'];
				$work_activation->save();
			}
			
			foreach($_POST['casestudy_competencies'] as $key=>$value){
				$work_activation=(!empty($_POST['fishbone_map_id'][$key]))?Doctrine::getTable('UlsFishboneCompMap')->find($_POST['fishbone_map_id'][$key]):new UlsFishboneCompMap;
				$work_activation->fishbone_quest_id=$case->fishbone_quest_id;
				$work_activation->comp_def_id=$value;
				$work_activation->level_id=$_POST['casestudy_level'][$key];
				$work_activation->scale_id=$_POST['casestudy_scale'][$key];
				$work_activation->fishbone_id=$_POST['fishbone_id'];
				$work_activation->save();
			}
			$this->session->set_flashdata('casestudy_admin',"Your Fishbone competencies has been ".(!empty($_POST['fishbone_id'])?"updated":"inserted")." successfully.");
			redirect('admin/fishbone_master?status=questions&id='.$_POST['fishbone_id']);
		}
	}
	
	public function feedback_assessment()
	{
		$data=array();
		$data['feed_details']=UlsAssessmentFeedbackAssessor::view_assessor_feedback();
		$content = $this->load->view('admin/assessment_feedback_assessorreport',$data,true);
		$this->render('layouts/report-layout',$content);
	}
	
	public function location_emp_status_report(){
		$loc_id=isset($_REQUEST['loc_id'])? $_REQUEST['loc_id']:"";
		$org_id=isset($_REQUEST['org_id'])? $_REQUEST['org_id']:"";
		if($loc_id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$data['type']=isset($_REQUEST['typeid'])? $_REQUEST['typeid']:"";
			$data['username']=UlsReports::getusername();
			$data['employee']=UlsAssessmentEmployees::get_status_assessment_loc_report($loc_id,$org_id);
			$content = $this->load->view('report/lms_report_assessment_location_status',$data,true);
		}
		$this->render('layouts/report-layout',$content);
	}
	
	public function assessment_status_comp_report(){
		$data=array();
		$data['comp_details']=UlsMenu::callpdo("SELECT a.`competency_id`,b.`comp_def_name`,s.scale_name,q.question_id,q.question_name FROM `uls_assessment_test_questions` a 
		left join(SELECT `comp_def_id`,`comp_def_name` FROM `uls_competency_definition`) b on b.comp_def_id=a.competency_id 
		left join(SELECT `comp_position_id`,`comp_position_competency_id`,`comp_position_level_scale_id` FROM `uls_competency_position_requirements`) c on c.comp_position_competency_id=a.competency_id and c.comp_position_id=a.position_id
		left join(SELECT `scale_id`,`scale_name` FROM `uls_level_master_scale`) s on s.scale_id=comp_position_level_scale_id
		left join(SELECT `question_id`,`question_name` FROM `uls_questions` ) q on q.question_id=a.question_id
		WHERE 1 and a.`competency_id` is not NULL");
		
		$content = $this->load->view('admin/assessment_competency_statusreport',$data,true);
		$this->render('layouts/report-layout',$content);
		
	}
	
	public function location_employee_report()
	{
		$data["aboutpage"]=$this->pagedetails('admin','employee_search_report');
        
		$content = $this->load->view('admin/location_employee_assessment_report',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function assessement_year_details(){
		$year=$_REQUEST['year_id'];
		$emp_type=isset($_SESSION['emp_type'])?$_SESSION['emp_type']:"";
		$ass_id=isset($_REQUEST['ass_id'])?$_REQUEST['ass_id']:"";
		$data['ass_id']=$ass_id;
		$sq5="";
		if(!empty($emp_type)){
			$sq5=" and a.assessment_cycle_type='$emp_type'";
		}
		$loc=$this->session->userdata('security_location_id');
		$losq="";
		if(!empty($loc)){
			$losq=" and (a.location_id in (".$loc.") )";
		}
		$data="";
		$data.="<optgroup label='Assessment Cycles'>";
		$assessments=UlsMenu::callpdo("SELECT a.* FROM `uls_assessment_definition` a
		WHERE 1 and a.`parent_org_id`=".$_SESSION['parent_org_id']." and YEAR(a.start_date)=".$year." and a.assessment_status='A' $sq5 $losq order by assessment_id desc");
		foreach($assessments as $assessment){
			$data.="<option value='".$assessment['assessment_id']."'>".$assessment['assessment_name']."</option>";
		}
		$data.="</optgroup>";
		echo $data;
	}
	
	
	
	public function assessment_dashboard(){
		$data["aboutpage"]=$this->pagedetails('admin','assessment_dashboard');
		if(isset($_REQUEST['ass_id'])){
			$year=$_REQUEST['year_id'];
			$emp_type=isset($_SESSION['emp_type'])?$_SESSION['emp_type']:"";
			$ass_id=isset($_REQUEST['ass_id'])?$_REQUEST['ass_id']:"";
			$data['ass_id']=$ass_id;
			$sq5="";
			if(!empty($emp_type)){
				$sq5=" and a.assessment_cycle_type='$emp_type'";
			}
			$loc=$this->session->userdata('security_location_id');
			$losq="";
			if(!empty($loc)){
				$losq=" and (a.location_id in (".$loc.") )";
			}
			$data['assessments']=UlsMenu::callpdo("SELECT a.* FROM `uls_assessment_definition` a
			WHERE 1 and a.`parent_org_id`=".$_SESSION['parent_org_id']." and YEAR(a.start_date)=".$year." and a.assessment_status='A' $sq5 $losq order by assessment_id desc");
			$ass_ids=$_REQUEST['ass_id'];
			
			$data['locations']=UlsMenu::callpdorow("SELECT count(distinct(location_id)) as count_loc FROM `uls_assessment_definition` a
			WHERE 1 and a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.assessment_id in (".$ass_ids.")  and a.assessment_status='A'");
			
			$data['position_f']=UlsMenu::callpdorow("SELECT count(distinct(p.position_id)) as countpoc FROM `uls_assessment_position` a
			left join(SELECT `position_id`,`position_structure`,`position_name` FROM `uls_position` where position_structure='S') p on p.position_id=a.position_id
			WHERE 1 and a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.assessment_id in (".$ass_ids.")");
			
			$data['position_taken']=UlsMenu::callpdorow("SELECT count(distinct(p.position_id)) as taken_pos FROM `uls_utest_attempts_assessment` a left join(SELECT `assessment_id`,`position_id`,`employee_id` FROM `uls_assessment_employees`) b on a.employee_id=b.employee_id and a.assessment_id=b.assessment_id 
			left join(SELECT `position_id`,`position_structure`,`position_name` FROM `uls_position` where position_structure='S') p on p.position_id=b.position_id
			WHERE 1 and a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.assessment_id in (".$ass_ids.")");
			
			$data['comp_f']=UlsMenu::callpdorow("SELECT count(distinct(a.assessment_pos_com_id)) as countcom FROM `uls_assessment_competencies` a WHERE 1 and a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.assessment_id in (".$ass_ids.")");
			
			$data['comp_emp']=UlsMenu::callpdorow("SELECT count(distinct(a.employee_id)) as countemp FROM `uls_assessment_employees` a WHERE 1 and a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.assessment_id in (".$ass_ids.")");
			
			$data['emp_taken']=UlsMenu::callpdorow("SELECT count(distinct(b.employee_id)) as taken_emp FROM `uls_utest_attempts_assessment` a left join(SELECT `assessment_id`,`position_id`,`employee_id` FROM `uls_assessment_employees`) b on a.employee_id=b.employee_id and a.assessment_id=b.assessment_id WHERE 1 and a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.assessment_id in (".$ass_ids.")");
			
			$data['assessor_f']=UlsMenu::callpdorow("SELECT count(distinct(a.assessor_id)) as countass FROM `uls_assessment_position_assessor` a WHERE 1 and a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.assessment_id in (".$ass_ids.")");
			
			$data['test_count']=UlsMenu::callpdorow("SELECT count(DISTINCT(b.test_quest_id)) as count_test FROM `uls_assessment_test` a left join(SELECT `assess_test_id`,`test_quest_id` FROM `uls_assessment_test_questions`) b on b.assess_test_id=a.`assess_test_id` WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.`assessment_id` in (".$ass_ids.") and a.`assessment_type`='TEST'");
			
			$data['inb_count']=UlsMenu::callpdorow("SELECT count(DISTINCT(b.inbasket_id)) as count_inb FROM `uls_assessment_test` a left join(SELECT `assess_test_id`,inbasket_id FROM `uls_assessment_test_inbasket`) b on b.assess_test_id=a.`assess_test_id` WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.`assessment_id` in (".$ass_ids.") and a.`assessment_type`='INBASKET' ");
			
			$data['case_count']=UlsMenu::callpdorow("SELECT count(DISTINCT(b.casestudy_id)) as count_case FROM `uls_assessment_test` a left join(SELECT `assess_test_id`,casestudy_id FROM `uls_assessment_test_casestudy`) b on b.assess_test_id=a.`assess_test_id` WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.`assessment_id` in (".$ass_ids.") and a.`assessment_type`='CASE_STUDY' ");
			
			
			
			$ass_max=UlsUtestAttemptsAssessment::get_score_value_max($ass_ids);
			$data['ass_rating_max']=$ass_max['max_score'];
			if(!empty($_REQUEST['org_id']) && !empty($_REQUEST['grade_id'])){
				
			}
			$organization_id=!empty($_REQUEST['org_id'])?$_REQUEST['org_id']:"";
			$grade_id=!empty($_REQUEST['grade_id'])?$_REQUEST['grade_id']:"";
			$position_id=!empty($_REQUEST['position_id'])?$_REQUEST['position_id']:"";
			$location_id=!empty($_REQUEST['location_id'])?$_REQUEST['location_id']:"";
			$data['organization_id']=$organization_id;
			$data['grade_id']=$grade_id;
			$data['position_id']=$position_id;
			$data['location_id']=$location_id;
			$sql_org=$sql_org_q=$sql_org_pos=$sql_org_posq=$sql_org_inbasket=$sql_org_inbasket_q="";
			$sql_gra=$sql_gra_q=$sql_gra_pos=$sql_gra_posq=$sql_gra_inbasket=$sql_gra_inbasket_q="";
			$sql_pos=$sql_pos_q=$sql_pos_pos=$sql_pos_posq=$sql_pos_inbasket=$sql_pos_inbasket_q="";
			$sql_loc=$sql_loc_q=$sql_loc_pos=$sql_loc_posq=$sql_loc_inbasket=$sql_loc_inbasket_q="";
			$sql_com=$sql_com_q=$sql_com_pos=$sql_com_posq=$sql_com_inbasket=$sql_com_inbasket_q="";
			
			$sql_com.="left join(SELECT `position_id`,`position_name`,position_org_id FROM `uls_position`) up on up.`position_id`=a.`position_id`
			left join(SELECT `employee_id`,`position_id`,`assessment_id`,`org_id`,`grade_id`,`location_id` FROM `uls_assessment_employees`) e on e.position_id=a.position_id and e.assessment_id=a.assessment_id";
			$sql_comd=$sql_comd_em="";
			if(($organization_id!="") || ($grade_id!="") || ($position_id!="") || ($location_id!="")){
				$sql_comd.=!empty($organization_id)?" and e.org_id=".$organization_id:'';
				$sql_comd.=!empty($grade_id)? " and e.grade_id=".$grade_id:"";
				$sql_comd.=!empty($position_id)? " and e.position_id=".$position_id:'';
				$sql_comd.=!empty($location_id)?" and e.location_id=".$location_id:'';
				$sql_com_q.=$sql_comd;
				$sql_com_posq.=$sql_comd;
				$sql_comd_em.=!empty($organization_id)?" and em.org_id=".$organization_id:'';
				$sql_comd_em.=!empty($grade_id)? " and em.grade_id=".$grade_id:"";
				$sql_comd_em.=!empty($position_id)? " and em.position_id=".$position_id:'';
				$sql_comd_em.=!empty($location_id)?" and em.location_id=".$location_id:'';
				$sql_org_inbasket.="left join(SELECT `employee_id`,`position_id`,`assessment_id`,`org_id`,`grade_id`,`location_id` FROM `uls_assessment_employees`) em on em.employee_id=a.employee_id";
				$sql_com_inbasket_q.=$sql_comd_em;
			}
			
			if(!empty($sql_comd)){
				$data['emp_details']=UlsMenu::callpdo("SELECT a.`employee_number`,a.`full_name`,e.assessment_id,e.position_id,a.employee_id FROM `uls_assessment_employees` e 
				left join(SELECT `employee_number`,`full_name`,`employee_id` FROM `employee_data`) a on a.employee_id=e.employee_id
				WHERE e.`assessment_id` in (".$ass_ids.")  ".$sql_comd."");
			}
			
			$data['ass_id']=$ass_ids;
			
			$data['comp_details']=UlsMenu::callpdo("SELECT b.comp_def_id,b.comp_def_name FROM `uls_assessment_competencies` a left join(SELECT `comp_def_id`,`comp_def_name`,comp_structure FROM `uls_competency_definition`) b on a.`assessment_pos_com_id`=b.comp_def_id
			$sql_org $sql_gra $sql_com WHERE a.`assessment_id` in (".$ass_ids.")  and b.comp_structure='S' ".$sql_org_q." ".$sql_gra_q." ".$sql_com_q." group by a.`assessment_pos_com_id` order by b.comp_def_name");
			
			/* $data['comp_production_details']=UlsMenu::callpdo("SELECT b.comp_def_id,b.comp_def_name FROM `uls_assessment_competencies` a left join(SELECT `comp_def_id`,`comp_def_name`,comp_structure FROM `uls_competency_definition`) b on a.`assessment_pos_com_id`=b.comp_def_id
			$sql_org $sql_gra $sql_com WHERE a.`assessment_id` in (".$ass_ids.")  and b.comp_structure='A' ".$sql_org_q." ".$sql_gra_q." ".$sql_com_q." group by a.`assessment_pos_com_id` order by b.comp_def_name"); */
			
			$data['dep_details']=UlsMenu::callpdo("SELECT ed.organization_id as org_id,ed.org_name FROM `uls_assessment_position` a 
			left join(SELECT `employee_id`,`position_id`,`assessment_id`,`org_id`,`grade_id`,`location_id` FROM `uls_assessment_employees`) e on e.position_id=a.position_id and e.assessment_id=a.assessment_id
			left join(SELECT `organization_id`,`org_name` FROM `uls_organization_master`) ed on ed.organization_id=e.org_id
			WHERE a.`assessment_id` in (".$ass_ids.") and e.`org_id` is NOT NULL group by e.`org_id`");
			
			$data['grade_details']=UlsMenu::callpdo("SELECT ed.grade_id,ed.grade_name FROM `uls_assessment_position` a 
			left join(SELECT `employee_id`,`position_id`,`assessment_id`,`org_id`,`grade_id`,`location_id` FROM `uls_assessment_employees`) e on e.position_id=a.position_id and e.assessment_id=a.assessment_id
			left join(SELECT `grade_id`,`grade_name` FROM `uls_grade`) ed on ed.grade_id=e.grade_id
			WHERE a.`assessment_id` in (".$ass_ids.") and e.`grade_id` is NOT NULL group by e.`grade_id`");
			
			$data['pos_names']=UlsMenu::callpdo("SELECT ed.position_id,ed.position_name FROM `uls_assessment_position` a 
			left join(SELECT `employee_id`,`position_id`,`assessment_id`,`org_id`,`grade_id`,`location_id` FROM `uls_assessment_employees`) e on e.position_id=a.position_id and e.assessment_id=a.assessment_id
			left join(SELECT `position_id`,`position_name` FROM `uls_position`) ed on ed.position_id=a.position_id
			WHERE a.`assessment_id` in (".$ass_ids.") group by a.`position_id`");
			
			$data['loc_details']=UlsMenu::callpdo("SELECT ed.location_id,ed.location_name FROM `uls_assessment_position` a 
			left join(SELECT `employee_id`,`position_id`,`assessment_id`,`org_id`,`grade_id`,`location_id` FROM `uls_assessment_employees`) e on e.position_id=a.position_id and e.assessment_id=a.assessment_id
			left join(SELECT `location_id`,`location_name` FROM `uls_location`) ed on ed.location_id=e.location_id
			WHERE a.`assessment_id` in (".$ass_ids.") and e.`location_id` is NOT NULL group by e.`location_id`");
			
			$data['pos_details']=UlsMenu::callpdo("SELECT b.`position_id`,b.`position_name` FROM `uls_assessment_position` a
			left join(SELECT `position_id`,`position_name`,position_org_id,grade_id FROM `uls_position`) b on a.`position_id`=b.`position_id`
			left join(SELECT `employee_id`,`position_id`,`assessment_id`,`org_id`,`grade_id`,`location_id` FROM `uls_assessment_employees`) e on e.position_id=a.position_id and e.assessment_id=a.assessment_id
			left join(SELECT `assessment_id`,`position_id`,`assessor_id` FROM `uls_assessment_position_assessor`) c on c.position_id=a.position_id and c.assessment_id=a.assessment_id
			WHERE  a.`assessment_id` in (".$ass_ids.") ".$sql_org_posq." ".$sql_gra_posq." ".$sql_com_posq." group by a.`position_id` ");
			
			$data['top_comp_details']=UlsMenu::callpdo("SELECT count(*) as total,d.comp_def_name FROM `uls_utest_responses_assessment` a left join uls_questions b on a.`user_test_question_id`=b.question_id left join uls_questionbank c on c.question_bank_id=b.question_bank_id left join uls_competency_definition d on c.comp_def_id=d.comp_def_id 
			$sql_org_inbasket $sql_gra_inbasket $sql_com_inbasket
			WHERE a.`assessment_id` in (".$ass_ids.") and a.`correct_flag`='W' and a.`test_type`='TEST' ".$sql_org_inbasket_q." ".$sql_gra_inbasket_q." ".$sql_com_inbasket_q." group by c.`comp_def_id` ORDER BY count(*) DESC LIMIT 0,5");
			
			$data['inbasket_details']=UlsMenu::callpdo("SELECT a.*,b.`employee_id`,c.position_id FROM `uls_utest_attempts_assessment` a
			left join(SELECT `employee_id`,`employee_number`,`full_name`,`org_name`,`position_name`,`grade_name`,`location_name` FROM `employee_data`) b on a.employee_id=b.employee_id
			left join(SELECT `assess_test_id`,`position_id`,`assessment_id` FROM `uls_assessment_test`) c on a.assessment_id=c.assessment_id and c.assess_test_id=a.event_id
			$sql_org_inbasket $sql_gra_inbasket $sql_com_inbasket WHERE a.`assessment_id` in (".$ass_ids.") and `test_type`='INBASKET' ".$sql_org_inbasket_q." ".$sql_gra_inbasket_q." ".$sql_com_inbasket_q."");
			
			$data['case_details']=UlsMenu::callpdo("SELECT a.*,b.`employee_id`,c.position_id FROM `uls_utest_attempts_assessment` a
			left join(SELECT `employee_id`,`employee_number`,`full_name`,`org_name`,`position_name`,`grade_name`,`location_name` FROM `employee_data`) b on a.employee_id=b.employee_id
			left join(SELECT `assess_test_id`,`position_id`,`assessment_id` FROM `uls_assessment_test`) c on a.assessment_id=c.assessment_id and c.assess_test_id=a.event_id
			$sql_org_inbasket $sql_gra_inbasket $sql_com_inbasket WHERE a.`assessment_id` in (".$ass_ids.") and `test_type`='CASE_STUDY' ".$sql_org_inbasket_q." ".$sql_gra_inbasket_q." ".$sql_com_inbasket_q."");
			
			$data['case_top_details']=UlsMenu::callpdo("SELECT a.`competency_id`,c.comp_def_name,avg(ar.scale_number) as assessed,avg(rt.scale_number) as required,(avg(rt.scale_number)-avg(ar.scale_number)) as diff_ra FROM `uls_assessment_report_bytype` a 
			left join(SELECT `scale_id`,`level_id`,`scale_number`,`scale_name` FROM `uls_level_master_scale`) ar on ar.scale_id=a.assessed_scale_id
			left join(SELECT `scale_id`,`level_id`,`scale_number`,`scale_name` FROM `uls_level_master_scale`) rt on rt.scale_id=a.require_scale_id
			left join(SELECT `comp_def_id`,`comp_def_name` FROM `uls_competency_definition`) c on c.comp_def_id=a.competency_id
			$sql_org $sql_gra $sql_com
			where a.`assessment_type`='CASE_STUDY' and a.`assessment_id` in (".$ass_ids.") ".$sql_org_q." ".$sql_gra_q." ".$sql_com_q." group by a.`competency_id` limit 0,3");
			
			$data['feed_detail_test']=UlsMenu::callpdo("SELECT count(a.`employee_id`) as emp_test,Q21 FROM `uls_assessment_feedback_employees` a
			$sql_org_inbasket $sql_gra_inbasket $sql_com_inbasket WHERE a.`assessment_id` in (".$ass_ids.") ".$sql_org_inbasket_q." ".$sql_gra_inbasket_q." ".$sql_com_inbasket_q."  group by `Q21`");
			
			$data['feed_detail_inb']=UlsMenu::callpdo("SELECT count(a.`employee_id`) as emp_inb,Q22 FROM `uls_assessment_feedback_employees` a
			$sql_org_inbasket $sql_gra_inbasket $sql_com_inbasket WHERE a.`assessment_id` in (".$ass_ids.") ".$sql_org_inbasket_q." ".$sql_gra_inbasket_q." ".$sql_com_inbasket_q."   group by `Q22`");
			
			$data['feed_detail_avg']=UlsMenu::callpdo("SELECT count(a.`employee_id`) as emp_avg,Q1 FROM `uls_assessment_feedback_employees` a
			$sql_org_inbasket $sql_gra_inbasket $sql_com_inbasket WHERE a.`assessment_id` in (".$ass_ids.") ".$sql_org_inbasket_q." ".$sql_gra_inbasket_q." ".$sql_com_inbasket_q."  group by `Q1`");
			
			$data['feed_top_avg']=UlsMenu::callpdo("SELECT b.`employee_number`,b.`full_name`,b.`org_name`,b.`grade_name`,b.`location_name`,s.position_name as map_pos_name,p.position_name as pos_name,p.position_structure,a.Q4 FROM `uls_assessment_feedback_employees` a
			left join(SELECT `employee_id`,`employee_number`,`full_name`,`org_name`,`position_name`,`grade_name`,`location_name`,position_id FROM `employee_data`) b on a.employee_id=b.employee_id
			left join(SELECT `position_id`,`position_structure`,`position_name`,position_structure_id FROM `uls_position`) p on p.position_id=b.position_id
			left join(SELECT `position_id`,`position_structure`,`position_name`,position_structure_id FROM `uls_position` where position_structure='S') s on s.position_id=p.position_structure_id
			$sql_org_inbasket $sql_gra_inbasket $sql_com_inbasket WHERE a.`assessment_id` in (".$ass_ids.") and a.`Q1`=5 and a.`Q4`<>'NA' ".$sql_org_inbasket_q." ".$sql_gra_inbasket_q." ".$sql_com_inbasket_q."  limit 0,3");
			
			$data['feed_detail_case']=UlsMenu::callpdo("SELECT count(a.`employee_id`) as emp_case,Q23 FROM `uls_assessment_feedback_employees` a
			$sql_org_inbasket $sql_gra_inbasket $sql_com_inbasket WHERE a.`assessment_id` in (".$ass_ids.") ".$sql_org_inbasket_q." ".$sql_gra_inbasket_q." ".$sql_com_inbasket_q."  group by `Q23`");
			
			
			
			$data['top_emp']=UlsMenu::callpdo("SELECT max(a.`score`) as top_score,a.assessment_id,b.`employee_id`,b.`employee_number`,b.`full_name`,b.`org_name`,b.`position_name`,b.`grade_name`,b.`location_name`,c.position_id FROM `uls_utest_attempts_assessment` a
			left join(SELECT `employee_id`,`employee_number`,`full_name`,`org_name`,`position_name`,`grade_name`,`location_name` FROM `employee_data`) b on a.employee_id=b.employee_id
			left join(SELECT `assess_test_id`,`position_id`,`assessment_id` FROM `uls_assessment_test`) c on a.assessment_id=c.assessment_id and c.assess_test_id=a.event_id
			$sql_org_inbasket $sql_gra_inbasket $sql_com_inbasket
			WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.`assessment_id` in (".$ass_ids.") and a.`test_type`='TEST' ".$sql_org_inbasket_q." ".$sql_gra_inbasket_q." ".$sql_com_inbasket_q." group by a.`employee_id` order by `score` DESC LIMIT 0,3");
			
			if(!empty($_REQUEST['org_id'])){
				$data['org_name']=UlsOrganizationMaster::vieworganization($_REQUEST['org_id']);
			}
			
		}
		$content = $this->load->view('admin/assessment_dashboard',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function hr_dashboard()
	{
		$data["total_emp"]=UlsMenu::callpdorow("SELECT count(distinct(employee_id)) as total_emp FROM `uls_assessment_employees` a
		left join(SELECT `assessment_id`,`ass_methods` FROM `uls_assessment_definition`) b on a.assessment_id=b.assessment_id WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and b.ass_methods='Y'");
		$data["assd_emp"]=UlsMenu::callpdorow("SELECT count(distinct(employee_id)) as assd_emp FROM `uls_assessment_report_final` WHERE `parent_org_id`=".$_SESSION['parent_org_id']);
		//position_structure='S'
		$data["assd_pos"]=UlsMenu::callpdorow("SELECT count(distinct(b.position_id)) as assd_pos FROM `uls_assessment_report_final` a
		left join(SELECT `position_id`,`position_structure`,`position_structure_id`,`position_name` FROM `uls_position` where 1) b on a.`position_id`=b.`position_id`
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']);
		$data["assessor_count"]=UlsMenu::callpdorow("SELECT count(distinct(assessor_id)) as assessor_count FROM `uls_assessment_position_assessor` WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and `assessor_type`='INT'");
		
		$data["loc_names"]=UlsMenu::callpdo("SELECT b.`location_id`,b.`location_name` FROM `uls_assessment_employees` a 
		left join(SELECT `location_id`,`location_name` FROM `uls_location`) b on a.location_id=b.location_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." group by a.location_id");
		//position_structure='S'
		$data["emp_details"]=UlsMenu::callpdo("select b.full_name, b.employee_number, b.org_name,b.email,b.office_number,b.location_name,s.position_name as map_pos_name,p.position_name as pos_name,p.position_structure,a.* from uls_assessment_report_final a
		left join (select employee_id,full_name,employee_number,org_name,position_id,email,office_number,location_name from employee_data group by employee_id)b on b.employee_id=a.employee_id
		left join(SELECT `position_id`,`position_structure`,`position_name`,position_structure_id FROM `uls_position`) p on p.position_id=b.position_id
		left join(SELECT `position_id`,`position_structure`,`position_name`,position_structure_id FROM `uls_position` where 1) s on s.position_id=p.position_structure_id
		where 1 and a.parent_org_id=".$_SESSION['parent_org_id']);
		$data["assessor_details"]=UlsMenu::callpdo("SELECT c.full_name, c.employee_number,c.location_name  FROM `uls_assessment_position_assessor` a 
		left join(SELECT `assessor_id`,`assessor_name`,`employee_id` FROM `uls_assessor_master`) b on b.assessor_id=a.assessor_id
		left join (select employee_id,full_name,employee_number,org_name,position_name,email,office_number,location_name from employee_data group by employee_id)c on b.employee_id=c.employee_id
		WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and `assessor_type`='INT' group by a.assessor_id");
		$data["aboutpage"]=$this->pagedetails('admin','hr_employee_search');
		$content = $this->load->view('admin/hr_dashboard',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function hr_tobe_assessement(){
		$loc_id=$_REQUEST['loc_id'];
		$total_emp_loc_details=UlsMenu::callpdo("SELECT c.full_name, c.employee_number,c.org_name,c.email,c.office_number,c.location_name,c.position_id,s.position_name as map_pos_name,p.position_name as pos_name,p.position_structure,a.* FROM `uls_assessment_employees` a
		left join(SELECT `assessment_id`,`ass_methods` FROM `uls_assessment_definition`) b on a.assessment_id=b.assessment_id
		left join (select employee_id,full_name,employee_number,org_name,position_id,position_name,email,office_number,location_name from employee_data group by employee_id)c on a.employee_id=c.employee_id
		left join(SELECT `position_id`,`position_structure`,`position_name`,position_structure_id FROM `uls_position`) p on p.position_id=c.position_id
		left join(SELECT `position_id`,`position_structure`,`position_name`,position_structure_id FROM `uls_position` where position_structure='S') s on s.position_id=p.position_structure_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and b.ass_methods='Y' and a.location_id=".$loc_id);
		$loc_name=UlsLocation::location_details($loc_id);
		$data="";
		$data.="<div class='row' id='result_data'>
			<div class='col-lg-8 col-md-7 col-sm-12 col-xs-12'>
				<div class='panel panel-default card-view panel-refresh'>
					<div class='refresh-container'>
						<div class='la-anim-1'></div>
					</div>
					<div class='panel-heading'>
						<div class='pull-left'>
							<h6 class='panel-title txt-dark'>To be Assessed in ".$loc_name['location_name']."</h6>
						</div>
						<div class='clearfix'></div>
					</div>
					<div class='panel-wrapper collapse in'>
						<div class='panel-body row pa-0'>
							<div class='table-wrap'>
								<div style='height: 500px;overflow: auto;'>
									<div class='table-responsive'>
										<table class='table table-hover table-bordered display mb-30'>
											<thead>
												<tr>
													<th>Emp Code</th>
													<th>Emp Name</th>
													<th>Designation</th>
													<th>Department</th>
													<th>Location</th>
													<th>Assessor Status</th>
												</tr>
											</thead>
											<tbody>";
											foreach($total_emp_loc_details as $total_emp_loc_detail){
												$ass_pos_count=UlsMenu::callpdorow("SELECT count(distinct(assessor_id)) as ass_count FROM `uls_assessment_position_assessor` WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and `position_id`=".$total_emp_loc_detail['position_id']." and `assessment_id`=".$total_emp_loc_detail['assessment_id']." and assessor_per='Y' and find_in_set(".$total_emp_loc_detail['employee_id'].",emp_ids)");
												$ass_pos_count2=UlsMenu::callpdorow("SELECT count(distinct(assessor_id)) as ass_counts FROM `uls_assessment_position_assessor` WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and `position_id`=".$total_emp_loc_detail['position_id']." and `assessment_id`=".$total_emp_loc_detail['assessment_id']." and assessor_per is NULL");
												$empass_pos_count=UlsMenu::callpdorow("SELECT count(assessor_id) as asscount FROM `uls_assessment_report_final` WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and employee_id=".$total_emp_loc_detail['employee_id']." and `position_id`=".$total_emp_loc_detail['position_id']." and `assessment_id`=".$total_emp_loc_detail['assessment_id']);
												$pos_name=($total_emp_loc_detail['position_structure']=='S')?$total_emp_loc_detail['pos_name']:$total_emp_loc_detail['map_pos_name'];
												$data.="<tr>
													<td>".$total_emp_loc_detail['employee_number']."</td>
													<td>".$total_emp_loc_detail['full_name']."</td>
													<td>".$pos_name."</td>
													<td>".$total_emp_loc_detail['org_name']."</td>
													<td>".$total_emp_loc_detail['location_name']."</td>
													<td>";
													$asessord_count=($ass_pos_count['ass_count']+$ass_pos_count2['ass_counts']);
													if($asessord_count==$empass_pos_count['asscount']){
														$data.="<i class='fa fa-check text-success' tittle='Completed'></i>";
													}
													else{
														$data.="<i class='fa fa-times text-danger' tittle='InProcess'></i>";
													}
													$data.="</td>
												</tr>";
											}
											$data.="</tbody>
										</table>
										
									</div>
								</div>
							</div>	
						</div>	
					</div>
				</div>
			</div>
			<div class='col-lg-4 col-md-5 col-sm-12 col-xs-12'>
				<div class='panel panel-default card-view panel-refresh'>
					<div class='refresh-container'>
						<div class='la-anim-1'></div>
					</div>
					<div class='panel-heading'>
						<div class='pull-left'>
							<h6 class='panel-title txt-dark'>Assessors in ".$loc_name['location_name']."</h6>
						</div>
						
						<div class='clearfix'></div>
					</div>
					<div class='panel-wrapper collapse in'>
						<div class='panel-body'>
							<ul class='chat-list-wrap'>
								<li class='chat-list'>
									<div class='chat-body' style='height: 500px;overflow: auto;'>";
									$assessor_details=UlsMenu::callpdo("SELECT c.full_name, c.employee_number,c.location_name  FROM `uls_assessment_position_assessor` a 
									left join(SELECT `assessor_id`,`assessor_name`,`employee_id` FROM `uls_assessor_master`) b on b.assessor_id=a.assessor_id
									left join (select employee_id,full_name,employee_number,org_name,position_name,email,office_number,location_name,location_id from employee_data group by employee_id)c on b.employee_id=c.employee_id
									WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and `assessor_type`='INT' and location_id=".$loc_id." group by a.assessor_id");	
									foreach($assessor_details as $key=>$assessor_detail){
									$data.="<div class='chat-data'>
										<img class='user-img img-circle' src='https://adani-power.n-compas.com/public/images/male_user.jpg' alt='user'>
										<div class='user-data'>
											<span class='name block capitalize-font'>".$assessor_detail['full_name']."</span>
											<span class='time block truncate txt-grey'>".$assessor_detail['employee_number']."</span>
											<span class='time block truncate txt-grey'>".$assessor_detail['location_name']."</span>
										</div>
										
										<div class='status away'></div>
										<div class='clearfix'></div>
									</div>
									<hr class='light-grey-hr row mt-10 mb-15'>";
									}
									$data.="</div>
								</li>
							</ul>
						</div>
					</div>	
				</div>	
			</div>	
		</div>";
	echo $data;
	}
	
	public function hr_assessed_assessement(){
		$loc_id=$_REQUEST['loc_id'];
		$total_emp_loc_details=UlsMenu::callpdo("SELECT c.full_name, c.employee_number,c.org_name,c.email,c.office_number,c.location_name,c.position_id,s.position_name as map_pos_name,p.position_name as pos_name,p.position_structure,a.* FROM `uls_assessment_report_final` a
		left join (select employee_id,full_name,employee_number,org_name,position_id,position_name,email,office_number,location_name,location_id from employee_data group by employee_id)c on a.employee_id=c.employee_id
		left join(SELECT `position_id`,`position_structure`,`position_name`,position_structure_id FROM `uls_position`) p on p.position_id=c.position_id
		left join(SELECT `position_id`,`position_structure`,`position_name`,position_structure_id FROM `uls_position` where position_structure='S') s on s.position_id=p.position_structure_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and c.location_id=".$loc_id);
		$loc_name=UlsLocation::location_details($loc_id);
		$data="";
		$data.="<div class='row' id='result_data'>
			<div class='col-lg-8 col-md-7 col-sm-12 col-xs-12'>
				<div class='panel panel-default card-view panel-refresh'>
					<div class='refresh-container'>
						<div class='la-anim-1'></div>
					</div>
					<div class='panel-heading'>
						<div class='pull-left'>
							<h6 class='panel-title txt-dark'>Assessed in ".$loc_name['location_name']."</h6>
						</div>
						<div class='clearfix'></div>
					</div>
					<div class='panel-wrapper collapse in'>
						<div class='panel-body row pa-0'>
							<div class='table-wrap'>
								<div style='height: 500px;overflow: auto;'>
									<div class='table-responsive'>
										<table class='table table-hover table-bordered display mb-30'>
											<thead>
												<tr>
													<th>Emp Code</th>
													<th>Emp Name</th>
													<th>Designation</th>
													<th>Department</th>
													<th>Location</th>
													<th>Assessor Status</th>
												</tr>
											</thead>
											<tbody>";
											foreach($total_emp_loc_details as $total_emp_loc_detail){
												
												$empass_pos_count=UlsMenu::callpdorow("SELECT group_concat(b.assessor_name) as assessor_name FROM `uls_assessment_report_final` a 
												left join(SELECT `assessor_id`,`assessor_name`,`employee_id` FROM `uls_assessor_master`) b on b.assessor_id=a.assessor_id
												WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.employee_id=".$total_emp_loc_detail['employee_id']." and a.`position_id`=".$total_emp_loc_detail['position_id']." and a.`assessment_id`=".$total_emp_loc_detail['assessment_id']."");
												$pos_name=($total_emp_loc_detail['position_structure']=='S')?$total_emp_loc_detail['pos_name']:$total_emp_loc_detail['map_pos_name'];
												$data.="<tr>
													<td>".$total_emp_loc_detail['employee_number']."</td>
													<td>".$total_emp_loc_detail['full_name']."</td>
													<td>".$pos_name."</td>
													<td>".$total_emp_loc_detail['org_name']."</td>
													<td>".$total_emp_loc_detail['location_name']."</td>
													<td>".$empass_pos_count['assessor_name']."</td>
												</tr>";
											}
											$data.="</tbody>
										</table>
										
									</div>
								</div>
							</div>	
						</div>	
					</div>
				</div>
			</div>
			<div class='col-lg-4 col-md-5 col-sm-12 col-xs-12'>
				<div class='panel panel-default card-view panel-refresh'>
					<div class='refresh-container'>
						<div class='la-anim-1'></div>
					</div>
					<div class='panel-heading'>
						<div class='pull-left'>
							<h6 class='panel-title txt-dark'>Assessors in ".$loc_name['location_name']."</h6>
						</div>
						
						<div class='clearfix'></div>
					</div>
					<div class='panel-wrapper collapse in'>
						<div class='panel-body'>
							<ul class='chat-list-wrap'>
								<li class='chat-list'>
									<div class='chat-body' style='height: 500px;overflow: auto;'>";
									
									$assessor_details=UlsMenu::callpdo("SELECT c.full_name, c.employee_number,c.location_name  FROM `uls_assessment_report_final` a 
									left join(SELECT `assessor_id`,`assessor_name`,`employee_id` FROM `uls_assessor_master`) b on b.assessor_id=a.assessor_id
									left join (select employee_id,full_name,employee_number,org_name,position_name,email,office_number,location_name,location_id from employee_data group by employee_id)c on b.employee_id=c.employee_id
									WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and c.location_id=".$loc_id." group by a.assessor_id");	
									foreach($assessor_details as $key=>$assessor_detail){
									$data.="<div class='chat-data'>
										<img class='user-img img-circle' src='https://adani-power.n-compas.com/public/images/male_user.jpg' alt='user'>
										<div class='user-data'>
											<span class='name block capitalize-font'>".$assessor_detail['full_name']."</span>
											<span class='time block truncate txt-grey'>".$assessor_detail['employee_number']."</span>
											<span class='time block truncate txt-grey'>".$assessor_detail['location_name']."</span>
										</div>
										
										<div class='status away'></div>
										<div class='clearfix'></div>
									</div>
									<hr class='light-grey-hr row mt-10 mb-15'>";
									}
									$data.="</div>
								</li>
							</ul>
						</div>
					</div>	
				</div>	
			</div>	
		</div>";
	echo $data;
	}
	
	public function report_assessement(){
		$loc_id=$_REQUEST['loc_id'];
		$total_emp_loc_details=UlsMenu::callpdo("SELECT c.full_name, c.employee_number,c.org_name,c.email,c.office_number,c.location_name,c.position_id,s.position_name as map_pos_name,p.position_name as pos_name,p.position_structure,a.* FROM `uls_assessment_employees` a
		left join (select employee_id,full_name,employee_number,org_name,position_id,position_name,email,office_number,location_name,location_id from employee_data group by employee_id)c on a.employee_id=c.employee_id
		left join(SELECT `position_id`,`position_structure`,`position_name`,position_structure_id FROM `uls_position`) p on p.position_id=c.position_id
		left join(SELECT `position_id`,`position_structure`,`position_name`,position_structure_id FROM `uls_position` where position_structure='S') s on s.position_id=p.position_structure_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and report_gen=1 and c.location_id=".$loc_id);
		$loc_name=UlsLocation::location_details($loc_id);
		$data="";
		$data.="<div class='row'>
			<div class='col-lg-8 col-md-7 col-sm-12 col-xs-12'>
				<div class='panel panel-default card-view panel-refresh'>
					<div class='refresh-container'>
						<div class='la-anim-1'></div>
					</div>
					<div class='panel-heading'>
						<div class='pull-left'>
							<h6 class='panel-title txt-dark'>Assessed in ".$loc_name['location_name']."</h6>
						</div>
						<div class='clearfix'></div>
					</div>
					<div class='panel-wrapper collapse in'>
						<div class='panel-body row pa-0'>
							<div class='table-wrap'>
								<div style='height: 500px;overflow: auto;'>
									<div class='table-responsive'>
										<table class='table table-hover table-bordered display mb-30'>
											<thead>
												<tr>
													<th>Emp Code</th>
													<th>Emp Name</th>
													<th>Designation</th>
													<th>Department</th>
													<th>Location</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>";
											foreach($total_emp_loc_details as $total_emp_loc_detail){
												$pos_name=($total_emp_loc_detail['position_structure']=='S')?$total_emp_loc_detail['pos_name']:$total_emp_loc_detail['map_pos_name'];
												$data.="<tr>
													<td>".$total_emp_loc_detail['employee_number']."</td>
													<td>".$total_emp_loc_detail['full_name']."</td>
													<td>".$pos_name."</td>
													<td>".$total_emp_loc_detail['org_name']."</td>
													<td>".$total_emp_loc_detail['location_name']."</td>
													<td><a href='".BASE_URL."/index/ass_position_emp?ass_type=ASS&ass_id=".$total_emp_loc_detail['assessment_id']."&pos_id=".$total_emp_loc_detail['position_id']."&emp_id=".$total_emp_loc_detail['employee_id']."' target='_blank'><span class='label label-primary'>Report</a></span></td>
												</tr>";
											}
											$data.="</tbody>
										</table>
										
									</div>
								</div>
							</div>	
						</div>	
					</div>
				</div>
			</div>
			<div class='col-lg-4 col-md-5 col-sm-12 col-xs-12'>
				<div class='panel panel-default card-view panel-refresh'>
					<div class='refresh-container'>
						<div class='la-anim-1'></div>
					</div>
					<div class='panel-heading'>
						<div class='pull-left'>
							<h6 class='panel-title txt-dark'>Assessors in ".$loc_name['location_name']."</h6>
						</div>
						
						<div class='clearfix'></div>
					</div>
					<div class='panel-wrapper collapse in'>
						<div class='panel-body'>
							<ul class='chat-list-wrap'>
								<li class='chat-list'>
									<div class='chat-body' style='height: 500px;overflow: auto;'>";
									
									$assessor_details=UlsMenu::callpdo("SELECT c.full_name, c.employee_number,c.location_name  FROM `uls_assessment_report_final` a 
									left join(SELECT `assessor_id`,`assessor_name`,`employee_id` FROM `uls_assessor_master`) b on b.assessor_id=a.assessor_id
									left join (select employee_id,full_name,employee_number,org_name,position_name,email,office_number,location_name,location_id from employee_data group by employee_id)c on b.employee_id=c.employee_id
									WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and c.location_id=".$loc_id." group by a.assessor_id");	
									foreach($assessor_details as $key=>$assessor_detail){
									$data.="<div class='chat-data'>
										<img class='user-img img-circle' src='https://adani-power.n-compas.com/public/images/male_user.jpg' alt='user'>
										<div class='user-data'>
											<span class='name block capitalize-font'>".$assessor_detail['full_name']."</span>
											<span class='time block truncate txt-grey'>".$assessor_detail['employee_number']."</span>
											<span class='time block truncate txt-grey'>".$assessor_detail['location_name']."</span>
										</div>
										
										<div class='status away'></div>
										<div class='clearfix'></div>
									</div>
									<hr class='light-grey-hr row mt-10 mb-15'>";
									}
									$data.="</div>
								</li>
							</ul>
						</div>
					</div>	
				</div>	
			</div>	
		</div>";
	echo $data;
	}
	
	public function assessor_dashboard()
	{
		$data["loc_details"]=UlsMenu::callpdo("SELECT distinct(c.`location_name`) as location_name,c.location_id FROM `uls_assessment_position_assessor` a
		left join(SELECT `assessor_id`,`employee_id`,`assessor_name`,assessor_type FROM `uls_assessor_master`) b on b.assessor_id=a.assessor_id
		left join(SELECT `employee_id`,`employee_number`,`full_name`,`location_id`,location_name FROM `employee_data`) c on c.employee_id=b.employee_id
		WHERE 1 and a.`parent_org_id`=".$_SESSION['parent_org_id']." and b.assessor_type='INT' group by a.assessor_id,c.location_id");
		
		$data["ass_int"]=UlsMenu::callpdo("SELECT b.`assessor_id`,b.`employee_id`,b.`assessor_name`,c.`employee_number`,c.`full_name`,c.`location_id` FROM `uls_assessment_position_assessor` a
		left join(SELECT `assessor_id`,`employee_id`,`assessor_name`,assessor_type FROM `uls_assessor_master`) b on b.assessor_id=a.assessor_id
		left join(SELECT `employee_id`,`employee_number`,`full_name`,`location_id` FROM `employee_data`) c on c.employee_id=b.employee_id
		WHERE 1 and a.`parent_org_id`=".$_SESSION['parent_org_id']." and b.assessor_type='INT' group by a.assessor_id,c.location_id");
		$data["ass_ext"]=UlsMenu::callpdo("SELECT b.`assessor_id`,b.`employee_id`,b.`assessor_name` FROM `uls_assessment_position_assessor` a
		left join(SELECT `assessor_id`,`employee_id`,`assessor_name`,assessor_type FROM `uls_assessor_master`) b on b.assessor_id=a.assessor_id
		WHERE 1 and a.`parent_org_id`=".$_SESSION['parent_org_id']." and b.assessor_type='EXT' group by a.assessor_id");
		$data["assessment_details"]=UlsMenu::callpdo("SELECT b.`assessor_id`,b.`assessor_name`,a.assessment_id,c.assessment_name FROM `uls_assessment_position_assessor` a
		left join(SELECT `assessor_id`,`employee_id`,`assessor_name`,assessor_type FROM `uls_assessor_master`) b on b.assessor_id=a.assessor_id
		left join(SELECT `assessment_id`,`assessment_name` FROM `uls_assessment_definition`) c on c.assessment_id=a.assessment_id
		WHERE 1 and a.`parent_org_id`=".$_SESSION['parent_org_id']." and b.assessor_type='INT' group by a.assessment_id");
		$data["aboutpage"]=$this->pagedetails('admin','hr_employee_search');
		$content = $this->load->view('admin/assessor_dashboard',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function assessor_internal_details(){
		$data="";
		$ass_int=UlsMenu::callpdo("SELECT b.`assessor_id`,b.`employee_id`,b.`assessor_name`,c.`employee_number`,c.`full_name`,c.`location_id`,c.org_name,c.position_name,c.location_name FROM `uls_assessment_position_assessor` a
		left join(SELECT `assessor_id`,`employee_id`,`assessor_name`,assessor_type FROM `uls_assessor_master`) b on b.assessor_id=a.assessor_id
		left join(SELECT `employee_id`,`employee_number`,`full_name`,`location_id`,org_name,position_name,location_name FROM `employee_data`) c on c.employee_id=b.employee_id
		WHERE 1 and a.`parent_org_id`=".$_SESSION['parent_org_id']." and b.assessor_type='INT' group by a.assessor_id");
		$data.="<div style='height: 500px;overflow: auto;'>
			<div class='table-responsive'>
				<table class='table table-hover table-bordered display mb-30'>
					<thead>
						<tr>
							<th>Emp Code</th>
							<th>Emp Name</th>
							<th>Designation</th>
							<th>Department</th>
							<th>Location</th>
						</tr>
					</thead>
					<tbody>";
					foreach($ass_int as $ass_ints){
						$data.="<tr>
							<td>".$ass_ints['employee_number']."</td>
							<td>".$ass_ints['full_name']."</td>
							<td>".$ass_ints['position_name']."</td>
							<td>".$ass_ints['org_name']."</td>
							<td>".$ass_ints['location_name']."</td>
						</tr>";
					}
					$data.="</tbody>
				</table>
			</div>
		</div>";
		echo $data;
	}
	
	public function assessor_external_details(){
		$data="";
		$ass_ext=UlsMenu::callpdo("SELECT b.`assessor_id`,b.`assessor_name`,b.assessor_email FROM `uls_assessment_position_assessor` a
		left join(SELECT `assessor_id`,`employee_id`,`assessor_name`,assessor_type,assessor_email FROM `uls_assessor_master`) b on b.assessor_id=a.assessor_id
		WHERE 1 and a.`parent_org_id`=".$_SESSION['parent_org_id']." and b.assessor_type='EXT' group by a.assessor_id");
		$data.="<div style='height: 500px;overflow: auto;'>
			<div class='table-responsive'>
				<table class='table table-hover table-bordered display mb-30'>
					<thead>
						<tr>
							<th>Assessor Name</th>
							<th>Email</th>
						</tr>
					</thead>
					<tbody>";
					foreach($ass_ext as $ass_exts){
						$data.="<tr>
							<td>".$ass_exts['assessor_name']."</td>
							<td>".$ass_exts['assessor_email']."</td>
						</tr>";
					}
					$data.="</tbody>
				</table>
			</div>
		</div>";
		echo $data;
	}
	
	public function assessor_location_details(){
		$loc_id=$_REQUEST['loc_id'];
		$data="";
		if(!empty($loc_id)){
			$location_name=UlsLocation::getloc($loc_id);
			
			$assint=UlsMenu::callpdo("SELECT b.`assessor_id`,b.`employee_id`,b.`assessor_name`,c.`employee_number`,c.`full_name`,c.`location_id` FROM `uls_assessment_position_assessor` a
			left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) d on a.assessment_id=d.assessment_id
			left join(SELECT `assessor_id`,`employee_id`,`assessor_name`,assessor_type FROM `uls_assessor_master`) b on b.assessor_id=a.assessor_id
			left join(SELECT `employee_id`,`employee_number`,`full_name`,`location_id` FROM `employee_data`) c on c.employee_id=b.employee_id
			WHERE 1 and a.`parent_org_id`=".$_SESSION['parent_org_id']." and d.assessment_status='A' and c.location_id=".$loc_id." and b.assessor_type='INT' group by a.assessor_id");
			$data.="<div class='row'>
			   <div class='col-lg-12'>
					<div class='panel panel-default card-view'>
						<div class='panel-heading'>
							<div class='pull-left'>
								<h6 class='panel-title txt-dark'>Assessors in location: ".$location_name['location_name']."</h6>
							</div>
							<div class='clearfix'></div>
						</div>
						<div class='panel-wrapper collapse in'>
							<div  class='panel-body'>
								<div class=''>
									<div id='owl_demo_4' class='owl-carousel owl-theme'>";
										foreach($assint as $key=>$ass_ints){
										$data.="<div class='item'>
											<a onclick='open_assessor_assessment_employees(".$loc_id.",".$ass_ints['assessor_id'].");' style='cursor: pointer;'>
											<div class='panel panel-default card-view hbggreen'>
												<div class='panel-body'>
													<div class='text-center'>
														<h6 class='font-11'>".$ass_ints['assessor_name']."</h6>
														<div class='progress progress-xs mb-0 '>
															<div style='width:100%' class='progress-bar progress-bar-primary'></div>
														</div>";
														
														$assd_id=UlsMenu::callpdorow("SELECT GROUP_CONCAT(DISTINCT(a.`assessment_id`)) as ass_ids FROM `uls_assessment_position_assessor` a 
														left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) d on a.assessment_id=d.assessment_id
														WHERE a.`assessor_id`=".$ass_ints['assessor_id']." and d.assessment_status='A'");
														$assm_id=$assd_id['ass_ids'];
														$ass_pos_count2=UlsMenu::callpdorow("SELECT group_concat(b.employee_id) as ass_counts FROM `uls_assessment_position_assessor` a
														left join(SELECT `employee_id`,`assessment_id`,`position_id` FROM `uls_assessment_employees`) b on a.assessment_id=b.assessment_id and a.position_id=b.position_id
														WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.assessment_id in (".$assm_id.") and a.assessor_id=".$ass_ints['assessor_id']." and a.assessor_type='INT' and (a.assessor_per is NULL || a.assessor_per='N') group by a.assessment_id");
														
														$ass_pos_count1=UlsMenu::callpdorow("SELECT group_concat(emp_ids) as ass_count FROM `uls_assessment_position_assessor` WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and assessment_id in (".$assm_id.") and assessor_id=".$ass_ints['assessor_id']." and assessor_type='INT' and (assessor_per is NULL || assessor_per='Y')");
														
														
														if(!empty($ass_pos_count2['ass_counts'])){
															$yes_array=explode(',',$ass_pos_count1['ass_count']);
															$no_array=explode(',',$ass_pos_count2['ass_counts']);
															$total_emp_ids=array_merge($no_array,$yes_array);
														}
														else{
															$total_emp_ids=explode(',',$ass_pos_count1['ass_count']);
														}
														/* echo "<pre>";
														print_r($total_emp_ids); */
														$total_emp_id=array_unique($total_emp_ids);
														$total_emp_count=count($total_emp_id);
														$data.="<span class='font-10 head-font txt-dark' >Total no of Employees mapped 
														<span class='font-18 block counter txt-dark'><span class='' >".$total_emp_count."</span></span></span>
													</div>
												</div>
											</div>
											</a>
										</div>";
										}
									$data.="</div>
								 </div>
								 
							</div>
						</div>
					</div>	
				</div>
			</div>
			<div id='result_ass_data'>
			<!--<div class='row'>
			   <div class='col-lg-12'>
					<div class='panel panel-default card-view'>
						<div class='panel-heading'>
							<div class='pull-left'>
								<h6 class='panel-title txt-dark'>Assessment Mapped : </h6>
							</div>
							<div class='clearfix'></div>
						</div>
						<div class='panel-wrapper collapse in'>
							<div  class='panel-body'>
								<div class=''>
									<div id='owl_demo_5' class='owl-carousel owl-theme'>";
										$assessmentdetails=UlsMenu::callpdo("SELECT b.`assessor_id`,b.`assessor_name`,a.assessment_id,d.assessment_name FROM `uls_assessment_position_assessor` a
										left join(SELECT `assessor_id`,`employee_id`,`assessor_name`,assessor_type FROM `uls_assessor_master`) b on b.assessor_id=a.assessor_id
										left join(SELECT `employee_id`,`employee_number`,`full_name`,`location_id`,location_name FROM `employee_data`) c on c.employee_id=b.employee_id
										left join(SELECT `assessment_id`,`assessment_name` FROM `uls_assessment_definition`) d on d.assessment_id=a.assessment_id
										WHERE 1 and a.`parent_org_id`=".$_SESSION['parent_org_id']." and c.location_id=".$loc_id." and b.assessor_type='INT' group by a.assessment_id");
										foreach($assessmentdetails as $assessment_detail){
											$emp_count=UlsMenu::callpdorow('SELECT count(distinct(a.`employee_id`)) as emp_count FROM `uls_assessment_employees` a
											WHERE 1 and a.`parent_org_id`='.$_SESSION['parent_org_id'].' and a.assessment_id='.$assessment_detail['assessment_id']);
										
										$data.="<div class='item'>
											<a href='#' data-toggle='modal' data-target='.bs-example-modal-lg' >
											<div class='panel panel-default card-view hbggreen'>
												<div class='panel-body'>
													<div class='text-center'>
														<h6>".$assessment_detail['assessment_name']."</h6>
														<div class='progress progress-xs mb-0 '>
															<div style='width:100%' class='progress-bar progress-bar-primary'></div>
														</div>
														<span class='font-12 head-font txt-dark' >Total no of Employees are 
															<span class='font-20 block counter txt-dark'><span class='counter-anim' >".$emp_count['emp_count']."</span></span></span>
													</div>
												</div>
											</div>
											</a>
											
										</div>";
										}
									$data.="</div>
								</div>
								 
							</div>
						</div>
					</div>	
				</div>
			</div>
			</div>-->
			<div id='result_assessment_data'>
			</div>
			";
		}
		echo $data;
	}
	
	public function assessment_assessor_details(){
		$loc_id=$_REQUEST['loc_id'];
		$ass_id=$_REQUEST['ass_id'];
		$data="";
		if(!empty($loc_id) && !empty($ass_id)){
			$ass_name=UlsAssessorMaster::viewassessor($ass_id);
			$data.="<div class='row'>
			   <div class='col-lg-12'>
					<div class='panel panel-default card-view'>
						<div class='panel-heading'>
							<div class='pull-left'>
								<h6 class='panel-title txt-dark'>Assessment Mapped : ".$ass_name['assessor_name']."</h6>
							</div>
							<div class='clearfix'></div>
						</div>
						<div class='panel-wrapper collapse in'>
							<div  class='panel-body'>
								<div class=''>
									<div id='owl_demo_5' class='owl-carousel owl-theme'>";
									
										$assessmentdetails=UlsMenu::callpdo("SELECT b.`assessor_id`,b.`assessor_name`,a.assessment_id,d.assessment_name FROM `uls_assessment_position_assessor` a
										left join(SELECT `assessor_id`,`employee_id`,`assessor_name`,assessor_type FROM `uls_assessor_master`) b on b.assessor_id=a.assessor_id
										left join(SELECT `employee_id`,`employee_number`,`full_name`,`location_id`,location_name FROM `employee_data`) c on c.employee_id=b.employee_id
										left join(SELECT `assessment_id`,`assessment_name` FROM `uls_assessment_definition`) d on d.assessment_id=a.assessment_id
										WHERE 1 and a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.assessor_id=".$ass_id." and c.location_id=".$loc_id." and b.assessor_type='INT' group by a.assessment_id");
										foreach($assessmentdetails as $assessment_detail){
											$ass_pos_count2=UlsMenu::callpdorow("SELECT count(b.employee_id) as ass_counts FROM `uls_assessment_position_assessor` a
											left join(SELECT `employee_id`,`assessment_id`,`position_id` FROM `uls_assessment_employees`) b on a.assessment_id=b.assessment_id and a.position_id=b.position_id
											 WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.assessor_id=".$ass_id." and a.assessor_type='INT' and a.assessment_id=".$assessment_detail['assessment_id']." and (a.assessor_per is NULL || a.assessor_per='N')");
											$ass_pos_count1=UlsMenu::callpdorow("SELECT group_concat(emp_ids) as ass_count FROM `uls_assessment_position_assessor` WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and assessor_id=".$ass_id." and assessment_id=".$assessment_detail['assessment_id']." and assessor_type='INT' and (assessor_per is NULL || assessor_per='Y')");
											$yes_array=explode(',',$ass_pos_count1['ass_count']);
											$total_emp_count=($ass_pos_count2['ass_counts']+count($yes_array));
										
										$data.="<div class='item'>
											<a onclick='open_assessor_assessment_employees(".$assessment_detail['assessment_id'].",".$ass_id.",".$loc_id.");' style='cursor: pointer;'>
											<div class='panel panel-default card-view hbggreen'>
												<div class='panel-body'>
													<div class='text-center'>
														<h6>".$assessment_detail['assessment_name']."</h6>
														<div class='progress progress-xs mb-0 '>
															<div style='width:100%' class='progress-bar progress-bar-primary'></div>
														</div>
														<span class='font-12 head-font txt-dark' >Total no of Employees are 
															<span class='font-20 block counter txt-dark'><span class='counter-anim' >".$total_emp_count."</span></span></span>
													</div>
												</div>
											</div>
											</a>
											
										</div>";
										}
									$data.="</div>
								</div>
								 
							</div>
						</div>
					</div>	
				</div>
			</div>
			<div id='result_assessment_data'>
			
			</div>
			";
		}
		echo $data;
	}
	
	public function assessor_mapped_assessment_details(){
		$loc_id=$_REQUEST['loc_id'];
		$ass_id=$_REQUEST['ass_id'];
		
		$data="";
		$sq5="";
		$sq6="";
		$sq7="";
		if(!empty($loc_id) && !empty($ass_id)){
			if(!empty($_REQUEST['assl_id'])){
				$ass_loc_name_detail=UlsMenu::callpdorow("SELECT `location_id`,`location_name` FROM `uls_location` where location_id=".$_REQUEST['assl_id']);
				$assid=UlsMenu::callpdorow("SELECT GROUP_CONCAT(DISTINCT(`assessment_id`)) as ass_ids FROM `uls_assessment_definition` WHERE ass_methods='Y' and assessment_status='A' and `location_id`=".$_REQUEST['assl_id']);
				$sq5=" and a.assessment_id in (".$assid['ass_ids'].")";
				$locids = '';
				$loc_ids=UlsMenu::callpdo("SELECT b.`location_id`,b.`location_name` FROM `uls_assessment_employees` a 
				left join(SELECT `location_id`,`location_name` FROM `uls_location`) b on a.location_id=b.location_id
				WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." ".$sq5." group by a.location_id");
				foreach($loc_ids as $loc_idss){
					$locids.=$loc_idss['location_id'].',';
				}
				$locids = trim($locids, ',');
				
				$sq6=" and a.location_id in (".$locids.")";
				if(!empty($_REQUEST['sec_id'])){
					$sq7=" and a.bu_id=".$_REQUEST['sec_id']."";
				}
			}
			$location_name=UlsLocation::getloc($loc_id);
			$ass_name=UlsAssessorMaster::viewassessor($ass_id);
			
			$assd_id=UlsMenu::callpdorow("SELECT GROUP_CONCAT(DISTINCT(a.`assessment_id`)) as ass_ids FROM `uls_assessment_position_assessor` a 
			left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) d on a.assessment_id=d.assessment_id
			WHERE a.`assessor_id`=".$ass_id." and d.assessment_status='A' ".$sq5." ");
			$assm_id=$assd_id['ass_ids'];
			
			$ass_pos_count2=UlsMenu::callpdorow("SELECT group_concat(b.employee_id) as ass_counts FROM `uls_assessment_position_assessor` a
			left join(SELECT `employee_id`,`assessment_id`,`position_id` FROM `uls_assessment_employees`) b on a.assessment_id=b.assessment_id and a.position_id=b.position_id
			left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) d on a.assessment_id=d.assessment_id
			WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.assessment_id in (".$assm_id.") and a.assessor_id=".$ass_id." and a.assessor_type='INT' and d.assessment_status='A' and (a.assessor_per is NULL || a.assessor_per='N') group by a.assessment_id");
			
			$ass_pos_count1=UlsMenu::callpdorow("SELECT group_concat(emp_ids) as ass_count FROM `uls_assessment_position_assessor` WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and assessment_id in (".$assm_id.") and assessor_id=".$ass_id." and assessor_type='INT' and (assessor_per is NULL || assessor_per='Y')");
			
			
			if(!empty($ass_pos_count2['ass_counts'])){
				$yes_array=explode(',',$ass_pos_count1['ass_count']);
				$no_array=explode(',',$ass_pos_count2['ass_counts']);
				$total_emp_ids=array_merge($no_array,$yes_array);
			}
			else{
				$total_emp_ids=explode(',',$ass_pos_count1['ass_count']);
			}
			/* echo "<pre>";
			print_r($total_emp_ids); */
			$total_emp_id=implode(",",array_filter($total_emp_ids));
			//$emp_details=UlsAssessmentEmployees::get_status_assessment_dashbaord($assm_id,$total_emp_id);
			$empids=!empty($total_emp_id)? " and a.employee_id in ($total_emp_id)":"";
			
			$emp_details=UlsMenu::callpdo("select b.full_name, b.employee_number, b.org_name,b.email, b.position_name,b.office_number,b.location_name,p.position_name as ass_position_name,s.position_name as map_pos_name,p.position_name as pos_name,po.position_structure,a.* from uls_assessment_employees a
			left join(SELECT `assessment_id`,`assessment_name`,`assessment_type` FROM `uls_assessment_definition`) c on a.assessment_id=c.assessment_id
			left join(SELECT `position_id`,`position_name` FROM `uls_position`) p on a.position_id=p.position_id
			left join (select employee_id,full_name,employee_number,org_name,position_name,email,office_number,location_name,position_id,location_id,bu_id from employee_data group by employee_id)b on b.employee_id=a.employee_id
			left join(SELECT `position_id`,`position_structure`,`position_name`,position_structure_id FROM `uls_position`) po on po.position_id=b.position_id
			left join(SELECT `position_id`,`position_structure`,`position_name`,position_structure_id FROM `uls_position` where position_structure='S') s on s.position_id=po.position_structure_id
			where 1 and a.parent_org_id=".$_SESSION['parent_org_id']." and a.assessment_id in (".$assm_id.") ".$empids." ".$sq6." ".$sq7." order by a.assessment_id asc");
			$data.="<div class='row'>
			   <div class='col-lg-12'>
					<div class='panel panel-default card-view'>
						<div class='panel-heading'>
							<div class='pull-left'>
								<h6 class='panel-title txt-dark'>Employee Data</h6>
							</div>
							
							<div class='clearfix'></div>
						</div>
						<div class='panel-wrapper collapse in'>
							<div  class='panel-body'>
								<p class='text-muted'>Location Name :<code>".$location_name['location_name']." </code></p>
								<p class='text-muted'>Assessor Name :<code>".$ass_name['assessor_name']."</code></p>
								
								<div class='clearfix'></div>
								<div class='pull-left'>
								</div>
								<div class='pull-right'>
									<a class='btn btn-sm btn-success' id='ass_download_excel'>Export To Excel</a>
									
								</div>
								<div class='clearfix'></div>
								<div class='table-wrap'>
									<div class='table-responsive'>
										<table class='table table-hover table-bordered display mb-30' id='assessor_data'>
											<thead>
												<tr>
													<th>S.No</th>
													<th>Employee Number</th>
													<th>Employee Name</th>
													<th>Department</th>
													<th>Location</th>
													<th>Position</th>
													<th>Assessment status</th>
													
												</tr>
												
											</thead>
											<tbody>";
											foreach($emp_details as $key=>$emp_detail){
												$assemp=UlsMenu::callpdorow("SELECT a.*,b.assessor_name,count(ar.ass_rating_id) as rating_ass FROM `uls_assessment_report_final` a
												left join(SELECT `ass_rating_id`,`assessment_id`,`position_id`,`employee_id`,`assessor_id` FROM `uls_assessment_assessor_rating`) ar on ar.assessment_id=a.assessment_id and ar.position_id=a.position_id and ar.employee_id=a.employee_id and ar.assessor_id=a.assessor_id
												left join(SELECT `assessor_id`,`assessor_name` FROM `uls_assessor_master`) b on b.assessor_id=a.assessor_id
												where a.`assessment_id`=".$emp_detail['assessment_id']." and a.assessor_id=".$ass_id." and a.`employee_id`=".$emp_detail['employee_id']." and a.position_id=".$emp_detail['position_id']);
												$status=!empty($assemp['rating_ass'])?(($assemp['status']=='A')?"<span class='label label-success'>Completed</span>":"<span class='label label-warning'>In-process</span>"):"<span class='label label-danger'>Not Started</span>";
												$pos_name=($emp_detail['position_structure']=='S')?$emp_detail['pos_name']:$emp_detail['map_pos_name'];
												$data.="<tr>
													<td>".($key+1)."</td>
													<td>".$emp_detail['employee_number']."</td>
													<td>".$emp_detail['full_name']."</td>
													<td>".$emp_detail['org_name']."</td>
													<td>".$emp_detail['location_name']."</td>
													<td>".$pos_name."</td>
													
													<td>".$status."</td>
													
												</tr>";
											}
											$data.="</tbody>
											
										</table>
									</div>
								</div>	
											
											
							</div>
						</div>
					</div>	
				</div>
			</div>";
		}
		echo $data;
	}
	
	public function competency_dashboard()
	{
		$data["compcount"]=UlsAssessmentCompetencies::get_competencies_count();
		$data["comp_details"]=UlsAssessmentCompetencies::get_competencies_details();
		$data["aboutpage"]=$this->pagedetails('admin','competency_dashboard');
		$data['emp_info']=UlsEmployeeMaster::emp_data_per();
		$content = $this->load->view('admin/competency_dashboard',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function get_comp_pos(){
		$comp_id=filter_input(INPUT_GET,'comp_id') ? filter_input(INPUT_GET,'comp_id'):"";
		$scale_id=filter_input(INPUT_GET,'scale_id') ? filter_input(INPUT_GET,'scale_id'):"";
		if(!empty($comp_id) && !empty($scale_id)){
			$results=UlsAssessmentCompetencies::get_comp_posdetails($comp_id,$scale_id);
		}
		else{
			
		}
	}
	
	public function get_comp_employees(){
		$comp_id=filter_input(INPUT_GET,'comp_id') ? filter_input(INPUT_GET,'comp_id'):"";
		$scale_id=filter_input(INPUT_GET,'scale_id') ? filter_input(INPUT_GET,'scale_id'):"";
		if(!empty($comp_id) && !empty($scale_id)){
			$results=UlsAssessmentEmployees::get_comp_empdetails($comp_id,$scale_id);
		}
		else{
			
		}
	}
	
	public function get_comp_analysis(){
		$comp_id=filter_input(INPUT_GET,'comp_id') ? filter_input(INPUT_GET,'comp_id'):"";
		$scale_id=filter_input(INPUT_GET,'scale_id') ? filter_input(INPUT_GET,'scale_id'):"";
		if(!empty($comp_id) && !empty($scale_id)){
			$results=UlsAssessmentReport::competency_analysis_data($comp_id,$scale_id);
		}
		else{
			
		}
	}
	
	public function location_emp_traning_status_report(){
		$loc_id=isset($_REQUEST['loc_id'])? $_REQUEST['loc_id']:"";
		$org_id=isset($_REQUEST['org_id'])? $_REQUEST['org_id']:"";
		$emp_id=isset($_REQUEST['emp_id'])? $_REQUEST['emp_id']:"";
		if($loc_id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$data['type']=isset($_REQUEST['typeid'])? $_REQUEST['typeid']:"";
			$data['username']=UlsReports::getusername();
			$data['employee']=UlsAssessmentEmployeeJourney::get_assessment_atri_tna_report($loc_id,$org_id,$emp_id);
			
			$content = $this->load->view('report/lms_report_assessment_location_training_status',$data,true);
		}
		$this->render('layouts/report-layout',$content);
	}
	
	public function location_employee_training_report()
	{
		$data["aboutpage"]=$this->pagedetails('admin','employee_training_search_report');
        
		$content = $this->load->view('admin/location_employee_assessment_training_report',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function employee_training_report()
	{
		$data["aboutpage"]=$this->pagedetails('admin','employee_training_search_report');
        
		$content = $this->load->view('admin/employee_assessment_training_report',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function employee_training_tna_report()
	{
		$data["aboutpage"]=$this->pagedetails('admin','employee_training_search_report');
        
		$content = $this->load->view('admin/employee_assessment_training_tna_report',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function employee_training_need_report()
	{
		$data["aboutpage"]=$this->pagedetails('admin','training_search_report');
        $data['type']=UlsAdminMaster::get_value_names("ASSESSOR_TYPE");
		$content = $this->load->view('admin/employee_training_need_assessment_report',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function employee_tna_details(){
		$location_id=$_REQUEST['location_id'];
		$organization_id=$_REQUEST['organization_id'];
		$data="";
		
		$emp_names=UlsMenu::callpdo("SELECT b.`employee_id`,b.`employee_number`,b.`full_name`,b.org_name,b.position_name,b.location_name,a.`assessment_id`,a.`position_id` FROM `uls_assessment_employee_dev_rating` a 
		left join(SELECT `employee_id`,`employee_number`,`full_name`,org_name,position_name,location_name FROM `employee_data` ) b on a.employee_id=b.employee_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.location_id=".$location_id." and a.org_id=".$organization_id."  group by a.employee_id order by b.`full_name` ASC");
		$data.="<div id='tna_details' class='form-group' aria-expanded='true'>
			<label class='control-label mb-10 col-sm-2'>Employee Name:</label>
			<div class='col-sm-5'>
			
			<select id='employee_id' name='employee_id' class='form-control m-b' data-prompt-position='topLeft'>
				<option value=''>Select</option>";
				foreach($emp_names as $key=>$emp_name){
					$data.="<option value='".$emp_name['employee_id']."'>".$emp_name['full_name']."</option>";
				}
			$data.="</select>
			</div>
		</div>";
		echo $data;
	}
	
	public function employee_tna_report_details(){
		$location_id=$_REQUEST['location_id'];
		$organization_id=$_REQUEST['organization_id'];
		$data="";
		
		$emp_names=UlsMenu::callpdo("SELECT b.`employee_id`,b.`employee_number`,b.`full_name`,b.org_name,b.position_name,b.location_name,a.`assessment_id`,a.`position_id` FROM `uls_assessment_employee_dev_rating` a 
		left join(SELECT `employee_id`,`tni_status`,assessment_id,position_id FROM `uls_assessment_employee_journey`) e on e.employee_id=a.employee_id and a.assessment_id=e.assessment_id and a.position_id=e.position_id
		left join(SELECT `employee_id`,`employee_number`,`full_name`,org_name,position_name,location_name FROM `employee_data` ) b on a.employee_id=b.employee_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.location_id=".$location_id." and a.org_id=".$organization_id." and e.tni_status=1  group by a.employee_id order by b.`full_name` ASC");
		
		$data.="
		
		<h3>Employee Details</h3><br>
		<table cellpadding='1' cellspacing='1' id='edit_datable_2' class='table table-hover table-bordered mb-0'>
			<thead>
				<tr>
					<th>S.No</th>
					<th>Emp. Code</th>
					<th>Emp. Name</th>
					<th>Location</th>
					<th>Department</th>
					<th>Designation</th>
					<th>Report</th>
				</tr>
			</thead>
			<tbody>";
			foreach($emp_names as $key=>$emp_name){
				$data.="<tr>
					<td>".($key+1)."</td>
					<td>".$emp_name['employee_number']."</td>
					<td>".$emp_name['full_name']."</td>
					<td>".$emp_name['location_name']."</td>
					<td>".$emp_name['org_name']."</td>
					<td>".$emp_name['position_name']."</td>
					<td>";
					$tna_status=UlsAssessmentEmployeeJourney::get_assessment_tna_employees($emp_name['assessment_id'],$emp_name['position_id'],$emp_name['employee_id']);
					if($tna_status['tni_status']==1){
						$data.="<a href='".BASE_URL."/index/emp_tna_single_report?ass_type=ASS&ass_id=".$emp_name['assessment_id']."&pos_id=".$emp_name['position_id']."&emp_id=".$emp_name['employee_id']."' target='_blank' style='color:blue;'>Report</a></td>";
					}
					else{
						$data.="TNA Process not Completed";
					}
				$data.="</tr>";
			}
			$data.="</tbody>
		</table>";
		
		echo $data;
	}
	
	public function training_scale_details(){
		$comp_def_id=$_REQUEST['comp_def_id'];
		$data="";
		$assessments=UlsMenu::callpdo("SELECT s.`scale_id`,s.`scale_name`,a.* FROM `uls_assessment_employee_dev_rating` a
		left join(SELECT `scale_id`,`scale_name` FROM `uls_level_master_scale`) s on s.scale_id=a.scale_id
		WHERE 1 and a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.comp_def_id=".$comp_def_id." group by a.`scale_id`");
		$data.="<label class='control-label mb-10'>Level:</label>
		
			<select id='scale_id' name='scale_id' class='validate[required] form-control m-b' data-prompt-position='topLeft'>
				<option value=''>Select</option>";
				foreach($assessments as $assessment){
					$data.="<option value='".$assessment['scale_id']."'>".$assessment['scale_name']."</option>";
				}
			$data.="</select>";
		echo $data;
	}
	
	public function get_training_employee_details(){
		$comp_id=filter_input(INPUT_GET,'comp_id') ? filter_input(INPUT_GET,'comp_id'):"";
		$scale_id=filter_input(INPUT_GET,'scale_id') ? filter_input(INPUT_GET,'scale_id'):"";
		$ele_id=filter_input(INPUT_GET,'ele_id') ? filter_input(INPUT_GET,'ele_id'):"";
		if(!empty($comp_id)){
			$results=UlsAssessmentEmployeeDevRating::get_training_need_emp_details($comp_id,$scale_id,$ele_id);
		}
		else{
			
		}
	}
	
	public function tni_report_insert(){
		
		if(isset($_POST['program_design'])){
			$question_insert=!empty($_POST['dev_report_id'])? Doctrine_Core::getTable('UlsAssessmentEmployeeDevReport')->find($_POST['dev_report_id']):new UlsAssessmentEmployeeDevReport();
			$question_insert->comp_def_id=$_POST['in_comp_def_id'];
			$question_insert->scale_id=$_POST['in_scale_id'];
			$question_insert->assessment_id=$_POST['assessment_id'];
			$question_insert->position_id=$_POST['position_id'];
			$question_insert->program_design=$_POST['program_design'];
			$question_insert->program_duration=$_POST['program_duration'];
			$question_insert->trainer_name=$_POST['trainer_name'];
			$question_insert->trainer_type=$_POST['trainer_type'];
			$question_insert->level_ind_ids=$_POST['level_ind_ids'];
			$question_insert->tni_per_id=$_POST['tni_per_id'];
			$question_insert->tni_percentage=$_POST['tni_percentage'];
			$question_insert->save();
			redirect('admin/employee_training_need_report?comp_def_id='.$_POST['in_comp_def_id'].'&scale_id='.$_POST['in_scale_id'].'&dev_report_id='.$question_insert['dev_report_id']);
			//redirect('admin/report_generation_tni?dev_report_id='.$question_insert['dev_report_id'],'target="_blank"');
		}
		
	}
	
	public function report_generation_tni(){
		$this->load->library('pdfgenerator');
		$dev_report_id=isset($_REQUEST['dev_report_id'])? $_REQUEST['dev_report_id']:"";
		$report_detail=UlsAssessmentEmployeeDevReport::get_details($dev_report_id);
		$data['report_details']=$report_detail;
		$content = $this->load->view('pdf/assessment_report_tni',$data,true);
		$filename = "TNI-".$report_detail['comp_def_name']."-report";
		$this->pdfgenerator->generate($content, $filename, true, 'A4', 'portrait','competency_profiling');
	}
	
	public function tni_employee_report(){
		$id=isset($_REQUEST['comp_def_id'])? $_REQUEST['comp_def_id']:"";
		$scale_id=isset($_REQUEST['scale_id'])? $_REQUEST['scale_id']:"";
		$ele_id=isset($_REQUEST['ele_id'])? $_REQUEST['ele_id']:"";
		if($id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$data['emp_details']=UlsAssessmentEmployeeDevRating::get_employee_info($id,$scale_id,$ele_id);
			$content = $this->load->view('admin/tni_employeee_statusreport',$data,true);
		}
		$this->render('layouts/report-layout',$content);
	}
	
	public function tniper_master_search(){
		$data["aboutpage"]=$this->pagedetails('admin','tniper_master_search');
		$limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
        $tni_percentage=filter_input(INPUT_GET,'tni_percentage') ? filter_input(INPUT_GET,'tni_percentage'):"";
        $page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
        $start=$page!=0? ($page-1)*$limit:0;
        $filePath=BASE_URL."/admin/tniper_master_search";
        $data['limit']=$limit;
        $data['tni_percentage']=$tni_percentage;
        $data['perpages']=UlsMenuCreation::perpage();
        $data['searchresults']=UlsTniPercentage::search($start, $limit,$tni_percentage);
        $total=UlsTniPercentage::searchcount($tni_percentage);
        $otherParams="&perpage=".$limit."&tni_percentage=$tni_percentage";
        $data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/tniper_master_search',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function tniper_master()
	{
		$data["aboutpage"]=$this->pagedetails('admin','tniper_master');
		$id=filter_input(INPUT_GET,'tni_per_id') ? filter_input(INPUT_GET,'tni_per_id'):"";
        $hash=filter_input(INPUT_GET,'hash') ? filter_input(INPUT_GET,'hash'):"";
        $menutype=!empty($id)? UlsMenuCreation::menutype($id):"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			$data['tniper']=UlsTniPercentage::viewtniper($id);
			$data['status']=UlsAdminMaster::get_value_names("STATUS");
			$content = $this->load->view('admin/tniper_master',$data,true);
		}
		$this->render('layouts/adminnew',$content);

	}
	
	public function tni_per_master(){
        if(isset($_POST['tni_per_id'])){ //print_r($_POST);
			$update=Doctrine_Query::create()->update('UlsTniPercentage');
			$update->set('status','?','I');
			$update->where('parent_org_id=?',$_SESSION['parent_org_id']);
			$update->execute();
			
            $level=(!empty($_POST['tni_per_id']))?Doctrine::getTable('UlsTniPercentage')->find($_POST['tni_per_id']):new UlsTniPercentage();
            $level->tni_percentage=$_POST['tni_percentage'];
            $level->status=$_POST['status'];
            $level->save();
			
			$this->session->set_flashdata('rating_msg',"TNI Percentage data ".(!empty($_POST['tni_per_id'])?"updated":"inserted")." successfully.");
			redirect("admin/tniper_master_search");
        }
        else{
			$content = $this->load->view('admin/tniper_master_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }
	
	public function deletetniper(){
		$id=trim($_REQUEST['val']);
		if(!empty($id)){
			$uewi=Doctrine_Query::create()->from('UlsAssessmentEmployeeDevReport')->where('tni_per_id='.$id)->execute();
			if(count($uewi)==0){
				$q = Doctrine_Query::create()->delete('UlsTniPercentage')->where('tni_per_id=?',$id)->execute();
				echo 1;
			}
			else{
				echo "Selected TNI Percentage cannot be deleted. Ensure you delete all the usages of the TNI Percentage before you delete it.";
			}
		}
	}
	public function competency_indicators_programss(){
		
			if(!empty($_POST['prg_title'])){
				$work_activation=(!empty($_POST['comp_def_pro_id']))?Doctrine::getTable('UlsCompetencyDefLevelIndicatorPrograms')->find($_POST['comp_def_pro_id']):new UlsCompetencyDefLevelIndicatorPrograms;
				$work_activation->comp_def_level_ind_id=$_POST['comp_def_level_ind_id'];
				$work_activation->comp_def_id=$_POST['comp_def_id'];
				$work_activation->comp_def_level_id=$_POST['comp_def_level_id'];
				$work_activation->parent_org_id=$_SESSION['parent_org_id'];
				$work_activation->program_name=$_POST['prg_title'];
				$work_activation->program_name_desc=$_POST['program_name_desc'];
				$work_activation->save();
			}
			redirect('admin/competency_levels?id='.$_POST['comp_def_id'].'&hash='.md5(SECRET.$_POST['comp_def_id']),'admin-layout');
		
	}
	
	public function publishemployeeassessment(){
		$id=trim($_REQUEST['val']);
		if(!empty($id) && is_numeric($id)){
			$ass_def=UlsAssessmentDefinition::viewassessment($id);
			$mail_tem=$ass_def['ass_methods']=='Y'?"ASSESSMENT_EMP":"ASSESSMENT_EMP_NEW";
			$uewi=Doctrine_Query::create()->from('UlsAssessmentEmployees')->where('assessment_id='.$id)->execute();
			if(count($uewi)!=0){
				$empdetails="select a.full_name AS name, a.employee_id,a.email,u.`user_name`,u.`password`,c.position_id FROM uls_assessment_employees c left join (SELECT full_name, employee_number,office_number,employee_id,email FROM uls_employee_master GROUP BY employee_id)a ON a.employee_id = c.employee_id left join (SELECT `user_id`,`employee_id`,`user_name`,`password` FROM `uls_user_creation` GROUP BY employee_id)u ON a.employee_id = u.employee_id where c.parent_org_id=".$_SESSION['parent_org_id']." and c.assessment_id=".$id;
				$empdetails = UlsMenu::callpdo($empdetails);
				if(count($empdetails)>0){
					foreach($empdetails as $empdetail){
						$base=BASE_URL."/index/login";
						$empname=$empdetail['name'];
						$user_name=$empdetail['user_name'];
						$password=$empdetail['password'];
						$empid=$empdetail['employee_id'];
						$mail=$empdetail['email'];
						$st=$mail_tem;
						$notification=Doctrine_core::getTable('UlsNotification')->findOneByParent_org_idAndEvent_typeAndStatus($_SESSION['parent_org_id'],$st,'A');
						if(!empty($notification)){
							$tna_url=$ass_def['ass_methods']=='Y'?"TNI_Process_Flow_Assessed.pdf":"TNI_Process_Flow_Not_Assessed.pdf";
							$tnalink=BASE_URL."/public/tni/".$tna_url."";
							$emailBody =$notification->comments;
							$emailBody = str_replace("#NAME#",ucwords($empname),$emailBody);
							$emailBody = str_replace("#LINK#",$base,$emailBody);
							$emailBody = str_replace("#USERNAME#",$user_name,$emailBody);
							$emailBody = str_replace("#PASSWORD#",$password,$emailBody);
							$emailBody = str_replace("#TNILINK#",$tnalink,$emailBody);
							//$emailBody = str_replace("#Assessment_methods#",$ass_methods,$emailBody);
							$mailsubject=$emailBody;
							$subject= "Training Needs Identification Process";
							$ss=new UlsNotificationHistory();
							$ss->employee_id=$empid;
							$ss->timestamp=date('Y-m-d H:i:s');
							$ss->to=!empty($mail)? $mail : "";
							$ss->notification_id=$notification->notification_id;
							$ss->subject=$subject;
							$ss->mail_content=$mailsubject;
							$ss->save();
						}
					}
				} 
				echo 1;
			}
			else{
				echo "Selected Assessment cannot be deleted. This particular Assessment has been used in transaction table.";
			}
		}
	}
	
	public function feedback_assessment_tna_atri_statusreport(){
		$loc_id=isset($_REQUEST['loc_id'])? $_REQUEST['loc_id']:"";
		$org_id=isset($_REQUEST['org_id'])? $_REQUEST['org_id']:"";
		$comp_def_id=isset($_REQUEST['comp_def_id'])? $_REQUEST['comp_def_id']:"";
		$comp_def_pro_id=isset($_REQUEST['comp_def_pro_id'])? $_REQUEST['comp_def_pro_id']:"";
		$compname=urldecode($comp_def_pro_id);
		$name="";
		if(!empty($loc_id)){
			$loca_name=UlsLocation::getloc($loc_id);
			$name.=!empty($loca_name['location_name'])?"Location:".$loca_name['location_name']:"";
		}
		if(!empty($org_id)){
			$org_name=UlsOrganizationMaster::orgtypes_new($org_id);
			$name.=!empty($org_name['org_name'])?"&nbsp;&nbsp;&nbsp;Department:".$org_name['org_name']:"";
		}
		if(!empty($comp_def_id)){
			$comp_name=UlsCompetencyDefinition::competency_detail_single($comp_def_id);
			$name.=!empty($comp_name['comp_def_name'])?"&nbsp;&nbsp;&nbsp;Competency:".$comp_name['comp_def_name']:"";
		}
		if(!empty($compname)){
			
			$pro_name=UlsCompetencyDefLevelIndicatorPrograms::get_pro_detail_name($compname);
			$name.=!empty($pro_name['program_name'])?"&nbsp;&nbsp;&nbsp;Program:".$pro_name['program_name']:"";
		}
		$type_id=isset($_REQUEST['type'])? $_REQUEST['type']:"";
		$data['feed_details']=UlsAssessmentEmployeeJourney::get_assessment_atri_tnanew($loc_id,$org_id,$comp_def_id,$compname,$type_id);
		$data['name_details']=$name;
		$content = $this->load->view('admin/assessment_feedback_tna_atri_statusreport',$data,true);
		$this->render('layouts/report-layout',$content);
	}
	
	public function get_location_tni_employees(){
		$location_id=!empty($_REQUEST['id'])?$_REQUEST['id']:"";
		$organization_id=!empty($_REQUEST['org_id'])?$_REQUEST['org_id']:"";
		$locationid=!empty($location_id)?"and a.location_id=".$location_id."":"";
		$organizationid=!empty($organization_id)?"and a.org_id=".$organization_id."":"";
		$data="";
		$emp_names=UlsMenu::callpdo("SELECT b.`employee_id`,b.`employee_number`,b.`full_name`,b.org_name,b.position_name,b.location_name,a.`assessment_id`,a.`position_id`,b.email FROM `uls_assessment_employees` a 
		left join(SELECT `employee_id`,`tni_status`,assessment_id,position_id FROM `uls_assessment_employee_journey`) e on e.employee_id=a.employee_id and a.assessment_id=e.assessment_id and a.position_id=e.position_id
		left join(SELECT `employee_id`,`employee_number`,`full_name`,org_name,position_name,location_name,email FROM `employee_data` ) b on a.employee_id=b.employee_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." ".$locationid." ".$organizationid." and a.tna_status='Y' and e.tni_status=1 group by a.employee_id order by b.`full_name` ASC");
		$name="";
		if(!empty($location_id)){
		$loca_name=UlsLocation::getloc($location_id);
		$name=!empty($loca_name['location_name'])?$loca_name['location_name']:"";
		}
		if(!empty($organization_id)){
		$org_name=UlsOrganizationMaster::orgtypes_new($organization_id);
		$name=!empty($org_name['org_name'])?$org_name['org_name']:"";
		}
		$data.="
		<h5 class='mb-15'>Following are the Employees of ".$name."</h5>
		<div class='table-wrap' style='height: 400px;overflow-y: auto;'>
		<table cellpadding='1' cellspacing='1' id='edit_datable_2' class='table table-hover table-bordered mb-0'>
			<thead>
				<tr>
					<th>S.No</th>
					<th>Emp. Code</th>
					<th>Emp. Name</th>
					<th>Email</th>
					<th>Location</th>
					<th>Department</th>
					<th>Designation</th>
					<th>Report</th>
				</tr>
			</thead>
			<tbody>";
			foreach($emp_names as $key=>$emp_name){
				$data.="<tr>
					<td>".($key+1)."</td>
					<td>".$emp_name['employee_number']."</td>
					<td>".$emp_name['full_name']."</td>
					<td>".$emp_name['email']."</td>
					<td>".$emp_name['location_name']."</td>
					<td>".$emp_name['org_name']."</td>
					<td>".$emp_name['position_name']."</td>
					<td>";
					$tna_status=UlsAssessmentEmployeeJourney::get_assessment_tna_employees($emp_name['assessment_id'],$emp_name['position_id'],$emp_name['employee_id']);
					if($tna_status['tni_status']==1){
						$data.="<a href='".BASE_URL."/index/emp_tna_single_report?ass_type=ASS&ass_id=".$emp_name['assessment_id']."&pos_id=".$emp_name['position_id']."&emp_id=".$emp_name['employee_id']."' target='_blank' style='color:blue;'>Report</a></td>";
					}
					else{
						$data.="TNA Process not Completed";
					}
				$data.="</tr>";
			}
			$data.="</tbody>
		</table></div>";
		
		echo $data;
	}
	
	public function get_location_tni_triggered_employees(){
		$location_id=!empty($_REQUEST['id'])?$_REQUEST['id']:"";
		$locationid=!empty($location_id)?"and a.location_id=".$location_id."":"";
		$data="";
		$emp_names=UlsMenu::callpdo("SELECT b.`employee_id`,b.`employee_number`,b.`full_name`,b.org_name,b.position_name,b.location_name,a.`assessment_id`,a.`position_id`,b.email FROM `uls_assessment_employees` a
		left join(SELECT `employee_id`,`employee_number`,`full_name`,org_name,position_name,location_name,email FROM `employee_data` ) b on a.employee_id=b.employee_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." ".$locationid." and a.tna_status='Y' group by a.employee_id order by b.`full_name` ASC");
		$name="";
		if(!empty($location_id)){
		$loca_name=UlsLocation::getloc($location_id);
		$name=!empty($loca_name['location_name'])?$loca_name['location_name']:"";
		}
		$data.="
		<h5 class='mb-15'>Following are the Employees of ".$name."</h5>
		<div class='table-wrap' style='height: 400px;overflow-y: auto;'>
		<table cellpadding='1' cellspacing='1' id='edit_datable_2' class='table table-hover table-bordered mb-0'>
			<thead>
				<tr>
					<th>S.No</th>
					<th>Emp. Code</th>
					<th>Emp. Name</th>
					<th>Email</th>
					<th>Location</th>
					<th>Department</th>
					<th>Designation</th>
				</tr>
			</thead>
			<tbody>";
			foreach($emp_names as $key=>$emp_name){
				$data.="<tr>
					<td>".($key+1)."</td>
					<td>".$emp_name['employee_number']."</td>
					<td>".$emp_name['full_name']."</td>
					<td>".$emp_name['email']."</td>
					<td>".$emp_name['location_name']."</td>
					<td>".$emp_name['org_name']."</td>
					<td>".$emp_name['position_name']."</td>
				</tr>";
			}
			$data.="</tbody>
		</table></div>";
		
		echo $data;
	}
	
	public function get_location_tni_emp_programs(){
		$location_id=!empty($_REQUEST['id'])?$_REQUEST['id']:"";
		$locid=!empty($location_id)?" and i.location_id=".$location_id."":"";
		$data="";
		$pro_names=UlsMenu::callpdo("SELECT DISTINCT (trim(p.`program_name`)) as proname,count(DISTINCT a.employee_id) as proempcount,group_concat(DISTINCT a.employee_id) as emp_id,i.location_id,group_concat(distinct(c.comp_def_name)) as comp_name,l.location_name FROM `uls_assessment_employee_select_programs` a
		left join(SELECT `comp_def_pro_id`,`comp_def_level_ind_id`,`comp_def_id`,program_name FROM `uls_competency_def_level_indicator_programs`) p on p.comp_def_pro_id=a.comp_def_pro_id
		left join(SELECT `employee_id`,`tni_status` FROM `uls_assessment_employee_journey`) e on e.employee_id=a.employee_id
		left join(SELECT `employee_id`,`location_id`,`assessment_id`,`position_id`,tna_status FROM `uls_assessment_employees`) i on a.employee_id=i.employee_id and a.assessment_id=i.assessment_id and a.position_id=i.position_id
		left join(SELECT `comp_def_id`,`comp_def_name` FROM `uls_competency_definition`) c on c.comp_def_id=p.comp_def_id
		left join(SELECT `location_id`,`location_name` FROM `uls_location`) l on l.location_id=i.location_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." ".$locid."  and i.tna_status='Y' and a.tna_year=1 and i.location_id is not NULL and e.tni_status=1 group by trim(p.`program_name`),i.location_id");
		$name="";
		if(!empty($location_id)){
		$loca_name=UlsLocation::getloc($location_id);
		$name=!empty($loca_name['location_name'])?$loca_name['location_name']:"";
		$data.="<h5 class='mb-15'>Following are the Employees of ".$name."</h5>";
		}
		$new=array();$loc=array();$locs=array();$comp=array();
		foreach($pro_names as $val){
			$p=$val['proname'];
			$l=$val['location_id'];
			if(!in_array($l,$loc)){
				
				$loc[]=$l;
				$locs[$l]=$val['location_name'];
				
			}
			$new[$p][$l]['empid']=$val['emp_id'];
			$new[$p][$l]['count']=$val['proempcount'];
			$new[$p][$l]['comp']=$val['comp_name'];
			$cps=explode(",",$val['comp_name']);
			if(!isset($comp[$p])){
				$comp[$p]=array();
			}
			foreach($cps as $cp){
				if(!in_array($cp,$comp[$p])){
					$comp[$p][]=$cp;
				}
			}
			
			
			
		}
		//print_r($comp);
		$data.="<div class='row'>	   
		<div class='col-lg-12'>
		<div class='panel panel-default card-view'>
			<div class='panel-heading'>
				<div class='pull-left'>
					<h6 class='panel-title txt-dark'>Program Details for Current Year</h6>
				</div>
				
				<div class='clearfix'></div>
			</div>
			<div class='panel-body'>
			<div class='table-wrap' style='height: 400px;overflow-y: auto;'>
			<table cellpadding='1' cellspacing='1' id='edit_datable_2' class='table table-hover table-bordered mb-0'>
			<thead>
				<tr>
					<th>S.No</th>
					<th>Programs</th>
					<th>Competencies</th>";
					foreach($locs as $k=>$v){
						$data.="<th>$v</th>";
						
					}
				$data.="</tr>
			</thead>
			<tbody>";$j=0;
			foreach($new as $ke=>$pro_name){$j++;
				$data.="<tr>
					<td>".$j."</td>
					<td>".$ke."</td>
					<td>".implode(",",@$comp[$ke])."</td>";
					foreach($locs as $k=>$v){
						if(isset($new[$ke][$k]['count'])){
							$data.="<td><a onclick='open_employee_pro(\"$ke\",".$new[$ke][$k]['empid'].");'>".$new[$ke][$k]['count']."</a></td>";
						}
						else{
							$data.="<td>-</td>";
						}
						
						
					}
					
				$data.="</tr>";
			}
			$data.="</tbody>
		</table></div></div>";
		
		$pronames=UlsMenu::callpdo("SELECT DISTINCT (trim(p.`program_name`)) as proname,count(DISTINCT a.employee_id) as proempcount,i.location_id,group_concat(distinct(c.comp_def_name)) as comp_name,l.location_name FROM `uls_assessment_employee_select_programs` a
		left join(SELECT `comp_def_pro_id`,`comp_def_level_ind_id`,`comp_def_id`,program_name FROM `uls_competency_def_level_indicator_programs`) p on p.comp_def_pro_id=a.comp_def_pro_id
		left join(SELECT `employee_id`,`tni_status` FROM `uls_assessment_employee_journey`) e on e.employee_id=a.employee_id
		left join(SELECT `employee_id`,`location_id`,`assessment_id`,`position_id`,tna_status FROM `uls_assessment_employees`) i on a.employee_id=i.employee_id and a.assessment_id=i.assessment_id and a.position_id=i.position_id
		left join(SELECT `comp_def_id`,`comp_def_name` FROM `uls_competency_definition`) c on c.comp_def_id=p.comp_def_id
		left join(SELECT `location_id`,`location_name` FROM `uls_location`) l on l.location_id=i.location_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." ".$locid."  and i.tna_status='Y' and a.tna_year=2 and i.location_id is not NULL and e.tni_status=1 group by trim(p.`program_name`),i.location_id");
		$new=array();$loc=array();$locs=array();$comp=array();
		foreach($pronames as $val){
			$p=$val['proname'];
			$l=$val['location_id'];
			if(!in_array($l,$loc)){
				
				$loc[]=$l;
				$locs[$l]=$val['location_name'];
				
			}
			$new[$p][$l]['count']=$val['proempcount'];
			$new[$p][$l]['comp']=$val['comp_name'];
			$cps=explode(",",$val['comp_name']);
			if(!isset($comp[$p])){
				$comp[$p]=array();
			}
			foreach($cps as $cp){
				if(!in_array($cp,$comp[$p])){
					$comp[$p][]=$cp;
				}
			}
		}
		$data.="<div class='panel-heading'>
				<div class='pull-left'>
					<h6 class='panel-title txt-dark'>Program Details for Next Year</h6>
				</div>
				
				<div class='clearfix'></div>
			</div>
			<div class='panel-body'>
			<div class='table-wrap' style='height: 400px;overflow-y: auto;'>
			<table cellpadding='1' cellspacing='1' id='edit_datable_2' class='table table-hover table-bordered mb-0'>
			<thead>
				<tr>
					<th>S.No</th>
					<th>Programs</th>
					<th>Competencies</th>";
					foreach($locs as $k=>$v){
						$data.="<th>$v</th>";
						
					}
				$data.="</tr>
			</thead>
			<tbody>";$j=0;
			foreach($new as $ke=>$pronames){$j++;
				$data.="<tr>
					<td>".$j."</td>
					<td>".$ke."</td>
					<td>".implode(",",@$comp[$ke])."</td>";
					foreach($locs as $k=>$v){
						if(isset($new[$ke][$k]['count'])){
							$data.="<td>".$new[$ke][$k]['count']."</td>";
						}
						else{
							$data.="<td>-</td>";
						}
						
						
					}
					
				$data.="</tr>";
			}
			$data.="</tbody>
		</table></div></div>
		</div></div></div>";
		
		echo $data;
	}
	
	public function employee_program_details(){
		$name=!empty($_REQUEST['names'])?$_REQUEST['names']:"";
		$emp_id=!empty($_REQUEST['ids'])?$_REQUEST['ids']:"";
		echo $name."-".$emp_id;
	}
	
	public function get_location_tni_inp_employees(){
		$location_id=!empty($_REQUEST['id'])?$_REQUEST['id']:"";
		$organization_id=!empty($_REQUEST['org_id'])?$_REQUEST['org_id']:"";
		$locationid=!empty($location_id)?"and a.location_id=".$location_id."":"";
		$organizationid=!empty($organization_id)?"and a.org_id=".$organization_id."":"";
		$data="";
		$emp_names=UlsMenu::callpdo("SELECT b.`employee_id`,b.`employee_number`,b.`full_name`,b.org_name,b.position_name,b.location_name,a.`assessment_id`,a.`position_id`,b.email FROM `uls_assessment_employees` a 
		left join(SELECT `employee_id`,`tni_status`,assessment_id,position_id FROM `uls_assessment_employee_journey`) e on e.employee_id=a.employee_id and a.assessment_id=e.assessment_id and a.position_id=e.position_id
		left join(SELECT `employee_id`,`employee_number`,`full_name`,org_name,position_name,location_name,email FROM `employee_data` ) b on a.employee_id=b.employee_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." ".$locationid." ".$organizationid." and a.tna_status='Y' and e.tni_status is NULL group by a.employee_id order by b.`full_name` ASC");
		$name="";
		if(!empty($location_id)){
		$loca_name=UlsLocation::getloc($location_id);
		$name=!empty($loca_name['location_name'])?$loca_name['location_name']:"";
		}
		if(!empty($organization_id)){
		$org_name=UlsOrganizationMaster::orgtypes_new($organization_id);
		$name=!empty($org_name['org_name'])?$org_name['org_name']:"";
		}
		$data.="
		<h5 class='mb-15'>Following are the Employees in ".$name." who are yet to complete TNI</h5>
		<div style='float:right;' id='loctni".trim($location_id)."'><button onclick='sendreminderall(\"".trim($location_id)."\")' class='btn btn-primary btn-xs'>Send Reminder to All</button></div><br style='clear:both;'>
		<div class='table-wrap' style='height: 400px;overflow-y: auto;'>
		<table cellpadding='1' cellspacing='1' id='edit_datable_2' class='table table-hover table-bordered mb-0'>
			<thead>
				<tr>
					<th>S.No</th>
					<th>Emp. Code</th>
					<th>Emp. Name</th>
					<th>Emailid</th>
					<th>Location</th>
					<th>Department</th>
					<th>Designation</th>
					<th>Report</th>
					<th>Reminder</th>
				</tr>
			</thead>
			<tbody>";
			foreach($emp_names as $key=>$emp_name){
				$data.="<tr>
					<td>".($key+1)."</td>
					<td>".$emp_name['employee_number']."</td>
					<td>".$emp_name['full_name']."</td>
					<td>".$emp_name['email']."</td>
					<td>".$emp_name['location_name']."</td>
					<td>".$emp_name['org_name']."</td>
					<td>".$emp_name['position_name']."</td>
					<td>";
					$tna_status=UlsAssessmentEmployeeJourney::get_assessment_tna_employees($emp_name['assessment_id'],$emp_name['position_id'],$emp_name['employee_id']);
					if($tna_status['tni_status']==1){
						$data.="<a href='".BASE_URL."/index/emp_tna_single_report?ass_type=ASS&ass_id=".$emp_name['assessment_id']."&pos_id=".$emp_name['position_id']."&emp_id=".$emp_name['employee_id']."' target='_blank' style='color:blue;'>Report</a></td>";
					}
					else{
						$data.="TNA Process not Completed</td>";
					}
				$data.="<td><div id='emp".trim($emp_name['employee_id'])."'><button onclick='sendreminder(\"".trim($emp_name['employee_id'])."\")' class='btn btn-primary btn-xs'>Send Reminder</button></div></td></tr>";
			}
			$data.="</tbody>
		</table></div>";
		
		echo $data;
	}
	
	public function tniremindertoall(){
		$location_id=!empty($_REQUEST['id'])?$_REQUEST['id']:"";
		$organization_id=!empty($_REQUEST['org_id'])?$_REQUEST['org_id']:"";
		$locationid=!empty($location_id)?"and a.location_id=".$location_id."":"";
		$organizationid=!empty($organization_id)?"and a.org_id=".$organization_id."":"";
		$data="";
		$emp_names=UlsMenu::callpdo("SELECT c.user_name,c.password,b.`employee_id`,b.`employee_number`,b.`full_name`,b.email,b.org_name,b.position_name,b.location_name,a.`assessment_id`,a.`position_id` FROM `uls_assessment_employees` a 
		left join(SELECT `employee_id`,`tni_status`,assessment_id,position_id FROM `uls_assessment_employee_journey`) e on e.employee_id=a.employee_id and a.assessment_id=e.assessment_id and a.position_id=e.position_id
		left join(SELECT `employee_id`,`employee_number`,`full_name`,`email`,org_name,position_name,location_name FROM `employee_data` ) b on a.employee_id=b.employee_id
		left join(SELECT `employee_id`,user_name,password from uls_user_creation)c on a.employee_id=c.employee_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." ".$locationid." ".$organizationid." and a.tna_status='Y' and e.tni_status is NULL group by a.employee_id order by b.`full_name` ASC");
		$emailBody2 =$this->readTemplateFile("public/templates/tnireminder.html");
		$flg=0;
		foreach($emp_names as $key=>$empdetail){
			$base=BASE_URL;
			$empname=$empdetail['full_name'];
			$user_name=$empdetail['user_name'];
			$password=$empdetail['password'];
			$empid=$empdetail['employee_id'];
			$mail=$empdetail['email'];
			$countemail=UlsMenu::callpdorow("SELECT count(*) as tot FROM `uls_notification_history` WHERE date(`timestamp`)='".date("Y-m-d")."' and `mail_type`='TNIRE' and employee_id='$empid'");
			
			if($countemail['tot']<2){
				$flg++;
				$emailBody = $emailBody2;
				$emailBody = str_replace("#NAME#",ucwords($empname),$emailBody);
				$emailBody = str_replace("#LINK#",$base,$emailBody);
				$emailBody = str_replace("#USERNAME#",$user_name,$emailBody);
				$emailBody = str_replace("#PASSWORD#",$password,$emailBody);
				$mailsubject=$emailBody;
				$subject= "TNI Reminder";
				$ss=new UlsNotificationHistory();
				$ss->employee_id=$empid;
				$ss->timestamp=date('Y-m-d H:i:s');
				$ss->to=!empty($mail)? $mail : "";
				$ss->notification_id=NULL;
				$ss->subject=$subject;
				$ss->mail_type='TNIRE';
				$ss->mail_content=$mailsubject;
				$ss->save();
			}
		}
		if($flg==0){
			echo "Mail already sent";
		}
		else{
			echo "Mail Triggered to $flg";
		}
	}
	
	public function tnireminder(){
		global $con;
		$id=@$_REQUEST['id'];
		$id=trim($id);
		$id=mysqli_escape_string($con,$id);
		if(isset($_REQUEST['id'])){
			if(!empty($id) && is_numeric($id)){
				$query="SELECT b.full_name,b.email,a.user_name,a.password,a.employee_id FROM `uls_user_creation` a 
				left join uls_employee_master b on a.employee_id=b.employee_id
				WHERE a.`employee_id`=$id";
				$empdetail=UlsMenu::callpdorow($query);
				$base=BASE_URL;
				$empname=$empdetail['full_name'];
				$user_name=$empdetail['user_name'];
				$password=$empdetail['password'];
				$empid=$empdetail['employee_id'];
				$mail=$empdetail['email'];
				$countemail=UlsMenu::callpdorow("SELECT count(*) as tot FROM `uls_notification_history` WHERE date(`timestamp`)='".date("Y-m-d")."' and `mail_type`='TNIRE' and employee_id='$empid'");
				if($countemail['tot']<2){
				$emailBody =$this->readTemplateFile("public/templates/tnireminder.html");
				$emailBody = str_replace("#NAME#",ucwords($empname),$emailBody);
				$emailBody = str_replace("#LINK#",$base,$emailBody);
				$emailBody = str_replace("#USERNAME#",$user_name,$emailBody);
				$emailBody = str_replace("#PASSWORD#",$password,$emailBody);
				$mailsubject=$emailBody;
				$subject= "TNI Reminder";
				$ss=new UlsNotificationHistory();
				$ss->employee_id=$empid;
				$ss->timestamp=date('Y-m-d H:i:s');
				$ss->to=!empty($mail)? $mail : "";
				$ss->notification_id=NULL;
				$ss->subject=$subject;
				$ss->mail_type='TNIRE';
				$ss->mail_content=$mailsubject;
				$ss->save();
				echo "mail sent";
				}
				else{
					echo "Already sent reminder mail ".$countemail['tot']." times today";
				}
			}
			else{
				echo "mail not sent";
			}			
		}
		else{
				echo "mail not sent";
			}
	}
	
	
	public function tni_location_details(){
		$location_id=$_REQUEST['location_id'];
		$loca_name=UlsLocation::getloc($location_id);
		$data="";
		$data.="
		<div class='col-lg-5' col-md-6 col-sm-6 col-xs-12'>
		<div class='panel panel-default card-view'>
			<div class='panel-heading'>
				<div class='pull-left'>
					<h6 class='panel-title txt-dark'>Status</h6>
				</div>
				
				<div class='clearfix'></div>
			</div>
			<div class='panel-wrapper collapse in'>
				<div class='panel-body'>
					<h6 class='panel-title txt-dark'>TNI information of ".$loca_name['location_name']."</h6>";
					$total_emp=UlsMenu::callpdorow("SELECT count(DISTINCT a.`employee_id`) as totemp_count FROM `uls_assessment_employees` a 
					left join(SELECT `location_id`,`location_name` FROM `uls_location`) b on a.location_id=b.location_id
					WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.location_id=".$location_id." and a.tna_status='Y'");
					$data.="<div class='row mt-25'>
						<div class='col-lg-4 col-md-6 col-sm-6 col-xs-12'>
							<div class='panel panel-default card-view pa-0'>
								<div class='panel-wrapper collapse in'>
									<div class='panel-body pa-0'>
										<div class='sm-data-box'>
											<div class='container-fluid'>
												<div class='row'>
													<div class='col-xs-6 text-center pl-0 pr-0 data-wrap-left'>
														<span class='txt-dark block counter'><span class='counter-anim'>".$total_emp['totemp_count']."</span></span>
														<span class='weight-500 uppercase-font block font-13'>Total</span>
													</div>
													<div class='col-xs-6 text-center  pl-0 pr-0 data-wrap-right'>
														<i class='icon-user-following data-right-rep-icon txt-light-grey'></i>
													</div>
												</div>	
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>";
						$totol_emp_loc=UlsMenu::callpdorow("SELECT b.`location_id`,b.`location_name`,count(DISTINCT a.`employee_id`) as emp_count FROM uls_assessment_employee_journey a left join(SELECT `employee_id`,`location_id`,`assessment_id`,`position_id`,tna_status FROM `uls_assessment_employees`) i on a.employee_id=i.employee_id and a.assessment_id=i.assessment_id and a.position_id=i.position_id left join(SELECT `location_id`,`location_name` FROM `uls_location`) b on i.location_id=b.location_id WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and i.location_id=".$location_id." and i.tna_status='Y' and a.tni_status=1 group by i.location_id order by b.`location_name` ASC");
						/* $totol_emp_loc=UlsMenu::callpdorow("SELECT b.`location_id`,b.`location_name`,count(DISTINCT a.`employee_id`) as emp_count FROM `uls_assessment_employee_dev_rating` a 
						left join(SELECT `location_id`,`location_name` FROM `uls_location`) b on a.location_id=b.location_id
						left join(SELECT `employee_id`,`tni_status` FROM `uls_assessment_employee_journey`) e on e.employee_id=a.employee_id
						left join(SELECT `employee_id`,`location_id`,`assessment_id`,`position_id`,tna_status FROM `uls_assessment_employees`) i on a.employee_id=i.employee_id and a.assessment_id=i.assessment_id and a.position_id=i.position_id
						WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.location_id=".$location_id." and i.tna_status='Y' and e.tni_status=1 group by a.location_id order by b.`location_name` ASC"); */
						$data.="<div class='col-lg-4 col-md-6 col-sm-6 col-xs-12'>
							<div class='panel panel-default card-view pa-0'>
								<div class='panel-wrapper collapse in'>
									<div class='panel-body pa-0'>
										<div class='sm-data-box'>
											<div class='container-fluid'>
												<div class='row'>
													<div class='col-xs-6 text-center pl-0 pr-0 data-wrap-left'>
														<span class='txt-dark block counter'><span class='counter-anim'>".$totol_emp_loc['emp_count']."</span></span>
														<span class='weight-500 uppercase-font block'>Completed</span>
													</div>
													<div class='col-xs-6 text-center  pl-0 pr-0 pt-25  data-wrap-right'>
														<i class='icon-user-following data-right-rep-icon txt-light-grey'></i>
													</div>
												</div>	
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					
						<div class='col-lg-4 col-md-6 col-sm-6 col-xs-12'>
							<div class='panel panel-default card-view pa-0'>
								<div class='panel-wrapper collapse in'>
									<div class='panel-body pa-0'>
										<div class='sm-data-box'>
											<div class='container-fluid'>
												<div class='row'>
													<div class='col-xs-6 text-center pl-0 pr-0 data-wrap-left'>
														
														<span class='txt-dark block counter'><span class='counter-anim'>".$notstarted=($total_emp['totemp_count']-$totol_emp_loc['emp_count'])."</span></span>
														<span class='weight-500 uppercase-font block'>Inprocess</span>
													</div>
													<div class='col-xs-6 text-center  pl-0 pr-0 data-wrap-right'>
														<i class='icon-user-following data-right-rep-icon txt-light-grey'></i>
													</div>
												</div>	
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
					</div>
					<div class='row  mt-25'>
						<div class='col-lg-4 col-md-6 col-sm-6 col-xs-12'>";
							$total_comp=UlsMenu::callpdorow("SELECT count(DISTINCT a.`comp_def_id`) as comp_count,count(DISTINCT a.employee_id) as empcount FROM `uls_assessment_employee_select_programs` a 
							left join(SELECT `employee_id`,`tni_status` FROM `uls_assessment_employee_journey`) e on e.employee_id=a.employee_id
							left join(SELECT `employee_id`,`location_id`,`assessment_id`,`position_id`,tna_status FROM `uls_assessment_employees`) i on a.employee_id=i.employee_id and a.assessment_id=i.assessment_id and a.position_id=i.position_id
							WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and i.location_id=".$location_id." and i.tna_status='Y' and i.location_id is not NULL and e.tni_status=1");
							$data.="<div class='panel panel-default card-view'>
								<div class='panel-wrapper collapse in'>
									<div class='panel-body sm-data-box-1'>
										<span class='uppercase-font weight-500 font-14 block text-center txt-dark'>Total Competencies Selected</span>	
										<div class='cus-sat-stat weight-500 txt-primary text-center mt-5'>
											<span class='counter-anim'>".$total_comp['comp_count']."</span>
										</div>
										<div class='progress-anim mt-20'>
											<div class='progress'>
												<div class='progress-bar progress-bar-primary
												wow animated progress-animated' role='progressbar' aria-valuenow='93.12' aria-valuemin='0' aria-valuemax='100' style='width: 93.12%;'></div>
											</div>
										</div>
										
									</div>
								</div>
							</div>
						</div>
						<div class='col-lg-4 col-md-6 col-sm-6 col-xs-12'>";
							$total_programs=UlsMenu::callpdorow("SELECT count(DISTINCT (trim(p.`program_name`))) as pro_count,count(DISTINCT a.employee_id) as proempcount FROM `uls_assessment_employee_select_programs` a 
							left join(SELECT `comp_def_pro_id`,`comp_def_level_ind_id`,`comp_def_id`,program_name FROM `uls_competency_def_level_indicator_programs`) p on p.comp_def_pro_id=a.comp_def_pro_id
							left join(SELECT `employee_id`,`tni_status` FROM `uls_assessment_employee_journey`) e on e.employee_id=a.employee_id
							left join(SELECT `employee_id`,`location_id`,`assessment_id`,`position_id`,tna_status FROM `uls_assessment_employees`) i on a.employee_id=i.employee_id and a.assessment_id=i.assessment_id and a.position_id=i.position_id
							WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and i.location_id=".$location_id." and i.tna_status='Y' and i.location_id is not NULL and e.tni_status=1");
							$data.="<div class='panel panel-default card-view'>
								<div class='panel-wrapper collapse in'>
									<div class='panel-body sm-data-box-1'>
										<span class='uppercase-font weight-500 font-14 block text-center txt-dark'>Total Programs Selected</span>	
										<a onclick='getasessprogram(".$location_id.")'  style='color:blue;cursor: pointer;' data-toggle='modal' data-target='.bs-example-modal-lg-pro'><div class='cus-sat-stat weight-500 txt-primary text-center mt-5'>
											<span class='counter-anim'>".$total_programs['pro_count']."</span>
										</div></a>
										<div class='progress-anim mt-20'>
											<div class='progress'>
												<div class='progress-bar progress-bar-primary
												wow animated progress-animated' role='progressbar' aria-valuenow='93.12' aria-valuemin='0' aria-valuemax='100' style='width: 93.12%;'></div>
											</div>
										</div>
										
									</div>
								</div>
							</div>
						</div>
						<div class='col-lg-4 col-md-6 col-sm-6 col-xs-12'>";
							$total_indicators=UlsMenu::callpdorow("SELECT count(DISTINCT p.`comp_def_level_ind_id`) as ind_count,count(DISTINCT a.employee_id) as indempcount FROM `uls_assessment_employee_select_programs` a 
							left join(SELECT `comp_def_pro_id`,`comp_def_level_ind_id`,`comp_def_id` FROM `uls_competency_def_level_indicator_programs`) p on p.comp_def_pro_id=a.comp_def_pro_id 
							left join(SELECT `employee_id`,`tni_status` FROM `uls_assessment_employee_journey`) e on e.employee_id=a.employee_id
							left join(SELECT `employee_id`,`location_id`,`assessment_id`,`position_id`,tna_status FROM `uls_assessment_employees`) i on a.employee_id=i.employee_id and a.assessment_id=i.assessment_id and a.position_id=i.position_id
							WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and i.location_id=".$location_id." and i.tna_status='Y' and i.location_id is not NULL and e.tni_status=1");
							$data.="<div class='panel panel-default card-view'>
								<div class='panel-wrapper collapse in'>
									<div class='panel-body sm-data-box-1'>
										<span class='uppercase-font weight-500 font-14 block text-center txt-dark'>Total Indicators Selected</span>	
										<div class='cus-sat-stat weight-500 txt-primary text-center mt-5'>
											<span class='counter-anim'>".$total_indicators['ind_count']."</span>
										</div>
										<div class='progress-anim mt-20'>
											<div class='progress'>
												<div class='progress-bar progress-bar-primary
												wow animated progress-animated' role='progressbar' aria-valuenow='93.12' aria-valuemin='0' aria-valuemax='100' style='width: 93.12%;'></div>
											</div>
										</div>
										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>
		<div class='col-lg-3 col-md-6 col-sm-6 col-xs-12'>
			<div class='panel panel-default card-view'>
				<div class='panel-heading'>
					<div class='pull-left'>
						<h6 class='panel-title txt-dark'>Top 3 Competencies of ".$loca_name['location_name']."</h6>
						<small class='text-muted'>Identified as Development</small>
					</div>
					
					<div class='clearfix'></div>
				</div>
				<div class='panel-wrapper collapse in'>
					<div class='panel-body'>";
						$top_comp=UlsMenu::callpdo("SELECT a.`comp_def_id`,c.comp_def_name,count(DISTINCT a.employee_id) as empcount FROM `uls_assessment_employee_select_programs` a 
						left join(SELECT `employee_id`,`tni_status` FROM `uls_assessment_employee_journey`) e on e.employee_id=a.employee_id
						left join(SELECT `employee_id`,`location_id`,`assessment_id`,`position_id`,tna_status FROM `uls_assessment_employees`) i on a.employee_id=i.employee_id and a.assessment_id=i.assessment_id and a.position_id=i.position_id
						left join(SELECT `comp_def_id`,`comp_def_name` FROM `uls_competency_definition`) c on c.comp_def_id=a.comp_def_id 
						WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and i.location_id=".$location_id." and i.tna_status='Y' and i.location_id is not NULL and e.tni_status=1 group by a.`comp_def_id` ORDER BY empcount DESC limit 3");
						$data.="<div>";
						foreach($top_comp as $key=>$top_comps){
							$data.="<span class='pull-left inline-block capitalize-font txt-dark'>
								".($key+1).' '.$top_comps['comp_def_name']."
							</span>
							<span class='label label-warning pull-right'></span>
							<div class='clearfix'></div>
							<hr class='light-grey-hr row mt-10 mb-20'>
							<div class='clearfix'></div>";
						}
						$data.="</div>
					</div>	
				</div>
			</div>
			<div class='panel panel-default card-view'>
				<div class='panel-heading'>
					<div class='pull-left'>
						<h6 class='panel-title txt-dark'>Top 3 Programs of ".$loca_name['location_name']."</h6>
						<small class='text-muted'>Identified for Training </small>
					</div>
					
					<div class='clearfix'></div>
				</div>
				<div class='panel-wrapper collapse in'>
					<div class='panel-body'>";
						$top_programs=UlsMenu::callpdo("SELECT DISTINCT(trim(p.`program_name`)) as programname,count(DISTINCT a.employee_id) as empcount,a.`comp_def_pro_id` FROM `uls_assessment_employee_select_programs` a 
						left join(SELECT `employee_id`,`tni_status` FROM `uls_assessment_employee_journey`) e on e.employee_id=a.employee_id
						left join(SELECT `comp_def_pro_id`,`program_name` FROM `uls_competency_def_level_indicator_programs`) p on p.comp_def_pro_id=a.comp_def_pro_id
						left join(SELECT `employee_id`,`location_id`,`assessment_id`,`position_id`,tna_status FROM `uls_assessment_employees`) i on a.employee_id=i.employee_id and a.assessment_id=i.assessment_id and a.position_id=i.position_id
						WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and i.location_id=".$location_id." and i.tna_status='Y' and i.location_id is not NULL and e.tni_status=1 group by a.`comp_def_pro_id` ORDER BY empcount DESC limit 3");
					
						$data.="<div>";
						foreach($top_programs as $key=>$top_comps){
							$data.="<span class='pull-left inline-block capitalize-font txt-dark'>
								".($key+1).' '.$top_comps['programname']."
							</span>
							<span class='label label-warning pull-right'></span>
							<div class='clearfix'></div>
							<hr class='light-grey-hr row mt-10 mb-20'>
							<div class='clearfix'></div>";
						}
						$data.="</div>
					</div>	
				</div>
			</div>
		</div>";
		echo $data;
	}
	
	public function tni_assessment_mapped_empreport(){
		$id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
		if($id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$data['feed_details']=UlsAssessmentEmployees::get_assessment_tni_employees($id);
			$content = $this->load->view('admin/assessment_tni_mapped_empstatusreport',$data,true);
		}
		$this->render('layouts/report-layout',$content);
	}
	
	public function employee_tna_report_search_details(){
		$security_location_id=$_REQUEST['loc_id'];
		$data="";
		$dap_name=!empty($security_location_id)?' and a.location_id='.$security_location_id:'';
		$org_names=UlsMenu::callpdo('SELECT b.`organization_id`,b.`org_name` FROM `uls_assessment_employee_dev_rating` a 
		left join(SELECT `organization_id`,`org_name` FROM `uls_organization_master`) b on a.org_id=b.organization_id
		WHERE a.`parent_org_id`='.$_SESSION['parent_org_id'].' '.$dap_name.'  group by a.org_id order by b.`org_name` ASC');
		$data.="<select id='orgid' name='orgid' class='form-control m-b'data-prompt-position='topLeft'>
			<option value=''>Select</option>";
			foreach($org_names as $org_name){
			$data.="<option value='".$org_name['organization_id']."'>".$org_name['org_name']."</option>";
			}
		$data.="</select>";
		echo $data;
	}
	
	public function employee_tna_search_details(){
		$security_location_id=$_REQUEST['loc_id'];
		$data="";
		$data.="<div class='form-group' aria-expanded='true' style='color: rgb(15, 197, 187);'><label class='control-label mb-10 col-sm-2'>Department Name:</label>
			<div class='col-sm-5'>";
			$dap_name=!empty($security_location_id)?' and a.location_id='.$security_location_id:'';
			$org_names=UlsMenu::callpdo('SELECT b.`organization_id`,b.`org_name` FROM `uls_assessment_employee_dev_rating` a 
			left join(SELECT `organization_id`,`org_name` FROM `uls_organization_master`) b on a.org_id=b.organization_id
			WHERE a.`parent_org_id`='.$_SESSION['parent_org_id'].' '.$dap_name.'  group by a.org_id order by b.`org_name` ASC');
			$data.="<select id='organization_id' name='organization_id' class='form-control m-b'data-prompt-position='topLeft' onchange='open_competeny();'>
				<option value=''>Select All</option>";
				foreach($org_names as $org_name){
				$data.="<option value='".$org_name['organization_id']."'>".$org_name['org_name']."</option>";
				}
			$data.="</select>
			</div>
		</div>
		<div id='comp_data_search'>";
		$comp_name=!empty($security_location_id)?' and i.location_id='.$security_location_id:'';
		$competency_names=UlsMenu::callpdo("SELECT DISTINCT(a.comp_def_id) as comp_id,c.comp_def_name FROM `uls_assessment_employee_select_programs` a left join(SELECT `employee_id`,`tni_status` FROM `uls_assessment_employee_journey`) e on e.employee_id=a.employee_id left join(SELECT `employee_id`,`location_id`,`assessment_id`,`position_id`,tna_status FROM `uls_assessment_employees`) i on a.employee_id=i.employee_id and a.assessment_id=i.assessment_id and a.position_id=i.position_id 
		left join(SELECT `comp_def_id`,`comp_def_name` FROM `uls_competency_definition`) c on c.comp_def_id=a.comp_def_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." ".$comp_name." and i.tna_status='Y' and i.location_id is not NULL and e.tni_status=1 order by c.`comp_def_name` ASC");
		$data.="<div class='form-group' aria-expanded='true' style='color: rgb(15, 197, 187);'><label class='control-label mb-10 col-sm-2'>Competency Name:</label>
			<div class='col-sm-5'>
			<select id='comp_def_id' name='comp_def_id' class='form-control m-b'data-prompt-position='topLeft' onchange='open_program();'>
				<option value=''>Select All</option>";
				foreach($competency_names as $key=>$competency_name){
				$data.="<option value='".$competency_name['comp_id']."'>".$competency_name['comp_def_name']."</option>";
				}
			$data.="</select>
			</div>
		</div>";
		$pro_name=!empty($security_location_id)?" and i.location_id=".$security_location_id:"";
		
		$programs_names=UlsMenu::callpdo("SELECT DISTINCT (trim(p.`program_name`)) as proname FROM `uls_assessment_employee_select_programs` a 
		left join(SELECT `employee_id`,`tni_status` FROM `uls_assessment_employee_journey`) e on e.employee_id=a.employee_id
		left join(SELECT `comp_def_pro_id`,`program_name` FROM `uls_competency_def_level_indicator_programs`) p on p.comp_def_pro_id=a.comp_def_pro_id
		left join(SELECT `employee_id`,`location_id`,`assessment_id`,`position_id`,tna_status FROM `uls_assessment_employees`) i on a.employee_id=i.employee_id and a.assessment_id=i.assessment_id and a.position_id=i.position_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." ".$pro_name." and i.tna_status='Y' and a.`comp_def_pro_id` is not NULL and i.location_id is not NULL and e.tni_status=1 order by proname ASC");
		$data.="<div class='form-group' aria-expanded='true' style='color: rgb(15, 197, 187);'><label class='control-label mb-10 col-sm-2'>Program Name:</label>
			<div class='col-sm-5'>
			<select id='comp_def_pro_id' name='comp_def_pro_id' class='form-control m-b' data-prompt-position='topLeft'>
				<option value=''>Select All</option>";
				foreach($programs_names as $key=>$programs_name){
				$data.="<option value='".urlencode($programs_name['proname'])."'>".$programs_name['proname']."</option>";
				}
			$data.="</select>
			</div>
		</div>
		</div>";
		echo $data;
						
	}
	
	
	
	public function employee_tna_comp_search_details(){
		$security_location_id=$_REQUEST['loc_id'];
		$org_id=$_REQUEST['org_id'];
		$data="";
		$comp_name=!empty($security_location_id)?' and i.location_id='.$security_location_id:'';
		$org_name=!empty($org_id)?' and i.org_id='.$org_id:'';
		$competency_names=UlsMenu::callpdo("SELECT DISTINCT(a.comp_def_id) as comp_id,c.comp_def_name FROM `uls_assessment_employee_select_programs` a left join(SELECT `employee_id`,`tni_status` FROM `uls_assessment_employee_journey`) e on e.employee_id=a.employee_id left join(SELECT `employee_id`,`location_id`,`assessment_id`,`position_id`,tna_status,org_id FROM `uls_assessment_employees`) i on a.employee_id=i.employee_id and a.assessment_id=i.assessment_id and a.position_id=i.position_id 
		left join(SELECT `comp_def_id`,`comp_def_name` FROM `uls_competency_definition`) c on c.comp_def_id=a.comp_def_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." ".$comp_name." ".$org_name." and i.tna_status='Y' and i.location_id is not NULL and e.tni_status=1 order by c.`comp_def_name` ASC");
		$data.="<div class='form-group' aria-expanded='true' style='color: rgb(15, 197, 187);'><label class='control-label mb-10 col-sm-2'>Competency Name:</label>
			<div class='col-sm-5'>
			<select id='comp_def_id' name='comp_def_id' class='form-control m-b'data-prompt-position='topLeft' onchange='open_program();'>
				<option value=''>Select All</option>";
				foreach($competency_names as $key=>$competency_name){
				$data.="<option value='".$competency_name['comp_id']."'>".$competency_name['comp_def_name']."</option>";
				}
			$data.="</select>
			</div>
		</div>";
		$pro_name=!empty($security_location_id)?" and i.location_id=".$security_location_id:"";
		$orgname=!empty($org_id)?' and i.org_id='.$org_id:'';
		$programs_names=UlsMenu::callpdo("SELECT DISTINCT (trim(p.`program_name`)) as proname FROM `uls_assessment_employee_select_programs` a 
		left join(SELECT `employee_id`,`tni_status` FROM `uls_assessment_employee_journey`) e on e.employee_id=a.employee_id
		left join(SELECT `comp_def_pro_id`,`program_name` FROM `uls_competency_def_level_indicator_programs`) p on p.comp_def_pro_id=a.comp_def_pro_id
		left join(SELECT `employee_id`,`location_id`,`assessment_id`,`position_id`,tna_status,org_id FROM `uls_assessment_employees`) i on a.employee_id=i.employee_id and a.assessment_id=i.assessment_id and a.position_id=i.position_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." ".$pro_name." ".$orgname." and i.tna_status='Y' and a.`comp_def_pro_id` is not NULL and i.location_id is not NULL and e.tni_status=1 order by proname ASC");
		$data.="<div id='program_data'><div class='form-group' aria-expanded='true' style='color: rgb(15, 197, 187);'><label class='control-label mb-10 col-sm-2'>Program Name:</label>
			<div class='col-sm-5'>
			<select id='comp_def_pro_id' name='comp_def_pro_id' class='form-control m-b' data-prompt-position='topLeft'>
				<option value=''>Select All</option>";
				foreach($programs_names as $key=>$programs_name){
				$data.="<option value='".urlencode($programs_name['proname'])."'>".$programs_name['proname']."</option>";
				}
			$data.="</select>
			</div>
		</div>
		</div>";
		echo $data;
						
	}
	
	public function employee_tna_program_search_details(){
		$security_location_id=$_REQUEST['loc_id'];
		$org_id=$_REQUEST['org_id'];
		$comp_def_id=$_REQUEST['comp_def_id'];
		$data="";
		
		$pro_name=!empty($security_location_id)?" and i.location_id=".$security_location_id:"";
		$orgname=!empty($org_id)?' and i.org_id='.$org_id:'';
		$compdefid=!empty($comp_def_id)?' and a.comp_def_id='.$comp_def_id:'';
		$programs_names=UlsMenu::callpdo("SELECT DISTINCT (trim(p.`program_name`)) as proname FROM `uls_assessment_employee_select_programs` a 
		left join(SELECT `employee_id`,`tni_status` FROM `uls_assessment_employee_journey`) e on e.employee_id=a.employee_id
		left join(SELECT `comp_def_pro_id`,`program_name` FROM `uls_competency_def_level_indicator_programs`) p on p.comp_def_pro_id=a.comp_def_pro_id
		left join(SELECT `employee_id`,`location_id`,`assessment_id`,`position_id`,tna_status,org_id FROM `uls_assessment_employees`) i on a.employee_id=i.employee_id and a.assessment_id=i.assessment_id and a.position_id=i.position_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." ".$pro_name." ".$orgname." ".$compdefid." and i.tna_status='Y' and a.`comp_def_pro_id` is not NULL and i.location_id is not NULL and e.tni_status=1 order by proname ASC");
		$data.="<div class='form-group' aria-expanded='true' style='color: rgb(15, 197, 187);'><label class='control-label mb-10 col-sm-2'>Program Name:</label>
			<div class='col-sm-5'>
			<select id='comp_def_pro_id' name='comp_def_pro_id' class='form-control m-b' data-prompt-position='topLeft'>
				<option value=''>Select All</option>";
				foreach($programs_names as $key=>$programs_name){
				$data.="<option value='".urlencode($programs_name['proname'])."'>".$programs_name['proname']."</option>";
				}
			$data.="</select>
			</div>
		</div>";
		echo $data;
						
	}
	
	
	public function assessment_questionbank_validation()
	{
		$data["aboutpage"]=$this->pagedetails('admin','assessment_qbankvalidation');
		$org_stat="STATUS";
        $data["orgstat"]=UlsAdminMaster::get_value_names($org_stat);
		if(!empty($_REQUEST['id'])){
			$compdetails=UlsAssessmentDefinition::viewassessment($_REQUEST['id']);
            $data['compdetails']=$compdetails;
			$data['position_details']=UlsAssessmentPosition::getassessmentpositions($compdetails['assessment_id']);
		}
		
		$content = $this->load->view('admin/assessment_questionbank_validation',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function get_position_comeptencies(){
		$ass_id=$_REQUEST['assessment_id'];
		$pos_id=$_REQUEST['position_id'];
		$data="";
		$ass_competencies=UlsAssessmentCompetencies::getassessment_competencies($ass_id,$pos_id);
		if(!empty($ass_competencies)){
			$data.="<br><div class='row'>
				<div class='col-md-2'>								
					&nbsp;
				</div>
				<div class='col-md-8'>
					<div class='form-group'>
						<label class='control-label mb-10 col-sm-2'>Competency Name:</label>
						<div class='col-sm-7'>
							<select name='comp_def_id' id='comp_def_id' class=' form-control m-b' onchange='getcompetencyquestion()'>
								<option value=''>Select</option>";
								foreach($ass_competencies as $ass_competencie){
									
									$data.="<option value='".$ass_competencie['comp_def_id']."'>".$ass_competencie['comp_def_name']."</option>";
								} 
							$data.="</select>
						</div>
					</div>
					
				</div>
				<div class='col-md-2'>								
					&nbsp;
				</div>
				
			</div>";
		}
		else{
			$data.="Competencies Not added";
		}
		echo $data;
	}
	
	public function get_position_comeptency_bank(){
		$comp_def_id=$_REQUEST['comp_def_id'];
		$data="";
		$comp_bank=UlsCompetencyDefQueBank::getcompdefquesbank($comp_def_id);
		if(!empty($comp_bank)){
			$data.="<br><div class='row'>
				<div class='col-md-2'>								
					&nbsp;
				</div>
				<div class='col-md-8'>
					<div class='form-group'>
						<label class='control-label mb-10 col-sm-2'>Question Bank Name:</label>
						<div class='col-sm-7'>
							<select name='master_ques_bank_id' id='master_ques_bank_id' class=' form-control m-b'>
								<option value=''>Select</option>";
								foreach($comp_bank as $comp_banks){
									
									$data.="<option value='".$comp_banks['master_ques_bank_id']."'>".$comp_banks['name']."</option>";
								} 
							$data.="</select>
						</div>
					</div>
					
				</div>
				<div class='col-md-2'>								
					&nbsp;
				</div>
				
			</div>";
		}
		else{
			$data.="Competencies Not added";
		}
		echo $data;
	}
	
	public function assessment_questionbank_insert(){
		if(isset($_POST['ass_position_id'])){
			echo $_POST['assessment_id']."-".$_POST['ass_position_id']."-".$_POST['comp_def_id']."-".$_POST['master_ques_bank_id'];
			$test_details=UlsAssessmentTest::get_ass_position_test($_POST['assessment_id'],$_POST['ass_position_id'],'TEST');
			$comp_scale_id=UlsAssessmentCompetencies::getassessment_competency_scale($_POST['assessment_id'],$_POST['ass_position_id'],$_POST['comp_def_id']);
			
			$question=UlsQuestionbank::get_questions_data_levels($_POST['master_ques_bank_id'],$comp_scale_id['scale_id']);
			foreach($question as $questions){
				$sd=Doctrine_Core::getTable('UlsCompetencyTestQuestions')->findOneByTestIdAndQuestionId($test_details['test_id'],$questions['id']);
				if(empty($sd)){
					$question_values=new UlsCompetencyTestQuestions();
					$question_values->test_id=$test_details['test_id'];
					$question_values->question_id=$questions['id'];
					$question_values->question_bank_id=$_POST['master_ques_bank_id'];
					$question_values->competency_id=$_POST['comp_def_id'];
					$question_values->save();
				}
			}
			$assment_id=$_POST['assessment_id'];
			$hash=SECRET.$assment_id;
			redirect("admin/assessment_questionbank_validation?id=".$assment_id."&hash=".md5($hash));
		}
	}
	
	public function questionnaire_exercises_master_search()
	{
		$data["aboutpage"]=$this->pagedetails('admin','questionnaire_exercises_master_search');
		$limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
        $ques_name=filter_input(INPUT_GET,'ques_name') ? filter_input(INPUT_GET,'ques_name'):"";
        $page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
        $start=$page!=0? ($page-1)*$limit:0;
        $filePath=BASE_URL."/admin/questionnaire_exercises_master_search";
        $data['limit']=$limit;
        $data['ques_name']=$ques_name;
        $data['perpages']=UlsMenuCreation::perpage();
        $data['searchresults']=UlsQuestionnaireMaster::search($start, $limit,$ques_name);
        $total=UlsQuestionnaireMaster::searchcount($ques_name);
        $otherParams="&perpage=".$limit."&ques_name=$ques_name";
		$data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/questionnaire_exercises_master_search',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function questionnaire_exercises_master()
	{
		$data["aboutpage"]=$this->pagedetails('admin','questionnaire_master');
		$org_stat="STATUS";
        $data["orgstat"]=UlsAdminMaster::get_value_names($org_stat);
		$yes_stat="YES_NO";
        $data["yesstat"]=UlsAdminMaster::get_value_names($yes_stat);
		$data['positions']=UlsPosition::pos_orgbased_all();
		$data["rating"]=UlsRatingMaster::rating_details();
		if(!empty($_REQUEST['id'])){
			$que_details=UlsQuestionnaireMaster::viewquestionnaire($_REQUEST['id']);
			$data["compdetails"]=$que_details;
			$data['positiondetails']=UlsQuestionnaireCompetency::view_questionnaire_comp($que_details['position_id'],$_REQUEST['id']);
			$data['elements']=UlsQuestionnaireCompetencyElement::view_comptency_element($_REQUEST['id']);
			$data['edit_elements']=UlsQuestionnaireCompetencyElement::edit_comptency_element($_REQUEST['id']);
			
		}
		$data["competency"]=UlsCompetencyDefinition::competency_details();
		$content = $this->load->view('admin/questionnaire_exercises_master',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function questionnaire_insert(){
        $this->sessionexist();
        if(isset($_POST['ques_id'])){
            $fieldinsertupdates=array('ques_name','ques_description','status','position_id','rating_id','no_elements');
			$datefield=array('start_date'=>'start_date','end_date'=>'end_date');
            $case=Doctrine::getTable('UlsQuestionnaireMaster')->find($_POST['ques_id']);
            !isset($case->ques_id)?$case=new UlsQuestionnaireMaster():"";
            foreach($fieldinsertupdates as $val){
				$case->$val=(!empty($_POST[$val]))?($_POST[$val]):NULL;
			}
			foreach($datefield as $key=>$dateval){
				$case->$key=(!empty($_POST[$dateval]))?date('Y-m-d',strtotime($_POST[$dateval])):NULL;
			}
			
            $case->save();
			
			$this->session->set_flashdata('assessment',"Questionnaire master data ".(!empty($_POST['ques_id'])?"updated":"inserted")." successfully.");
            redirect('admin/questionnaire_exercises_master?status=competency&id='.$case->ques_id.'&hash='.md5(SECRET.$case->ques_id));
        }
        else{
			$content = $this->load->view('admin/questionnaire_exercises_master_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }
	
	public function questionnaire_competency_insert(){
        $this->sessionexist();
        if(isset($_POST['ques_id'])){
           
			foreach($_POST['chkbox_select'] as $key=>$value){ 
				if(!empty($_POST['chkbox_select'])){
					
					$work_details_level=(!empty($_POST['ques_comp_id'][$key]))?Doctrine::getTable('UlsQuestionnaireCompetency')->find($_POST['ques_comp_id'][$key]):new UlsQuestionnaireCompetency;
					$work_details_level->ques_id=$_POST['ques_id'];
					$work_details_level->ques_competency_id=$value;
					$work_details_level->ques_level_scale_id=$_POST['ques_level_scale_id'][$value];
					$work_details_level->save();
					
				}
			}
			
			$this->session->set_flashdata('assessment',"Questionnaire master data ".(!empty($_POST['ques_id'])?"updated":"inserted")." successfully.");
            redirect('admin/questionnaire_exercises_master?status=questions&id='.$_POST['ques_id'].'&hash='.md5(SECRET.$_POST['ques_id']));
        }
        else{
			$content = $this->load->view('admin/questionnaire_exercises_master_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }
	
	public function questionnaire_element_insert(){
		ini_set('display_errors', 1);
        $this->sessionexist();
        if(isset($_POST['ques_id'])){
			foreach($_POST['chkbox_select_ele'] as $key=>$value){ 
				if(!empty($_POST['chkbox_select_ele'])){
					$work_details_level=(!empty($_POST['ques_element_id_ele'][$value]))?Doctrine::getTable('UlsQuestionnaireCompetencyElement')->find($_POST['ques_element_id_ele'][$value]):new UlsQuestionnaireCompetencyElement;
					$work_details_level->ques_id=$_POST['ques_id'];
					$work_details_level->element_id=$value;
					$work_details_level->element_competency_id=$_POST['element_competency_id_ele'][$value];
					$work_details_level->element_level_scale_id=$_POST['element_level_scale_id_ele'][$value];
					$work_details_level->save();
				}
			}
			
			$this->session->set_flashdata('assessment',"Questionnaire master data ".(!empty($_POST['ques_id'])?"updated":"inserted")." successfully.");
            redirect('admin/questionnaire_exercises_master?status=element&id='.$_POST['ques_id'].'&hash='.md5(SECRET.$_POST['ques_id']));
        }
        else{
			$content = $this->load->view('admin/questionnaire_exercises_master_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }
	
	public function questionnaire_element_edit(){
        $this->sessionexist();
        if(isset($_POST['ques_id'])){
			foreach($_POST['ques_element_id'] as $key=>$value){ 
				$work_details_level=(!empty($_POST['ques_element_id'][$key]))?Doctrine::getTable('UlsQuestionnaireCompetencyElement')->find($_POST['ques_element_id'][$key]):new UlsQuestionnaireCompetencyElement;
				$work_details_level->element_id_edit=$_POST['element_id_edit'][$key];
				$work_details_level->element_language=$_POST['element_language'][$key];
				$work_details_level->save();
				
			}
			
			$this->session->set_flashdata('assessment',"Questionnaire master data ".(!empty($_POST['ques_id'])?"updated":"inserted")." successfully.");
            redirect('admin/questionnaire_exercises_master?status=final&id='.$_POST['ques_id'].'&hash='.md5(SECRET.$_POST['ques_id']));
        }
        else{
			$content = $this->load->view('admin/questionnaire_exercises_master_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }
	
	public function element_details(){
		$level_id=$_REQUEST['level_id'];
		$comp_id=$_REQUEST['comp_id'];
		$id=$_REQUEST['id'];
		$data="";
		if(isset($id)){
			$element=UlsCompetencyDefLevelElements::get_element_details($id);
		}
		$status=UlsAdminMaster::get_value_names("STATUS");
		$data.="<form id='element_val' action='".BASE_URL."/admin/insert_element_details' method='post' enctype='multipart/form-data'>
			<input type='hidden' name='scale_id' value='".$level_id."'>
			<input type='hidden' name='comp_def_id' value='".$comp_id."'>
			<input type='hidden' name='element_id' value='".(isset($element['element_id'])?$element['element_id']:'')."'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
				<h5 class='modal-title' id='myLargeModalLabel'>Add/Edit Intrays</h5>
			</div>
			<div class='modal-body'>
				<div class='panel-body'>
					<div class='col-lg-12'>
						<div class='form-group'>
							<label class='control-label mb-10 text-left'>Enter Element Details<sup><font color='#FF0000'>*</font></sup>:</label>
							<textarea rows='8' class='form-control validate[required]' name='element_name' id='element_name'>".(isset($element['element_name'])?$element['element_name']:'')."</textarea>
						</div>
						<div class='form-group'>
							<label class='control-label mb-10 text-left'>Enter Others Element Details<sup><font color='#FF0000'>*</font></sup>:</label>
							<textarea rows='8' class='form-control validate[required]' name='element_oth_name' id='element_oth_name'>".(isset($element['element_oth_name'])?$element['element_oth_name']:'')."</textarea>
						</div>
						<div class='form-group'>
							<label class='control-label mb-10 text-left'>Status:</label>
							<select class='validate[required] form-control m-b' name='status' id='status'>
								<option value=''>Select</option>";
								foreach($status as $status){
									$sel_sat=(isset($element['status']))?($element['status']==$status['code'])?"selected='selected'":'':'';
									$data.="<option value='".$status['code']."' ".$sel_sat.">".$status['name']."</option>";
								}
							$data.="</select>
						</div>
					</div>
				</div>
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-danger text-left' data-dismiss='modal'>Close</button>
				<button class='btn btn-primary btn-sm' type='submit' name='save' id='save'> Proceed</button>
			</div>
		</form>";
		echo $data;
	}
	
	public function insert_element_details(){
		if(isset($_POST['element_name'])){
			$level=(!empty($_POST['element_id']))?Doctrine::getTable('UlsCompetencyDefLevelElements')->find($_POST['element_id']):new UlsCompetencyDefLevelElements();
			$level->element_name=$_POST['element_name'];
			$level->element_oth_name=$_POST['element_oth_name'];
			$level->comp_def_id=$_POST['comp_def_id'];
			$level->scale_id=$_POST['scale_id'];
            $level->status=$_POST['status'];
            $level->save();
			$this->session->set_flashdata('indicator_message',"Level Element data ".(!empty($_POST['comp_def_id'])?"updated":"inserted")." successfully.");
			redirect('admin/competency_levels?id='.$_POST['comp_def_id'].'&hash='.md5(SECRET.$_POST['comp_def_id']),'admin-layout');
		}
	}
	
	public function deletelevelelement(){
		$id=trim($_REQUEST['val']);
		if(!empty($id) && is_numeric($id)){
			$uewi=Doctrine_Query::create()->from('UlsQuestionnaireCompetencyElement')->where('element_id='.$id)->execute();
			if(count($uewi)==0){
				
				$q = Doctrine_Query::create()->delete('UlsCompetencyDefLevelElements')->where('element_id=?',$id)->execute();
				echo 1;
			}
			else{
				echo "Selected Element cannot be deleted. This particular Element has been used in transaction table.";
			}
		}
	}
	
	public function position_feedback_details(){
		$assessment_id=$_REQUEST['assessment_id'];
		$position_id=$_REQUEST['position_id'];
		$ass_type=$_REQUEST['ass_type'];
		$ass_position=UlsAssessmentPosition::get_assessment_position($position_id);
		$status=UlsAdminMaster::get_value_names("STATUS");
		$ass_detail_feedback=UlsQuestionnaireMaster::viewfeedback_position($position_id);
		$data="";
		$data.="<form class='form-horizontal'  name='feedback_form' id='feedback_form' method='post' action='".BASE_URL."/admin/lms_assessment_position_feedback'>
			<input type='hidden' name='feed_assess_test_id' id='feed_assess_test_id' value=''>
			<input type='hidden' name='position_id' id='position_id' value='".$position_id."'>
			<input type='hidden' name='assessment_id' id='assessment_id' value='".$assessment_id."'>
			<input type='hidden' name='assessment_pos_id' id='assessment_pos_id' value='".$ass_position['assessment_pos_id']."'>
			<input type='hidden' name='assessment_type' id='assessment_type' value='FEEDBACK'>
			<div class='form-group'><label class='col-sm-4 control-label'>Feedback Test Name<sup><font color='#FF0000'>*</font></sup>:</label>
				<div class='col-sm-8'>
					<select id='ques_id' name='ques_id' class='validate[required] form-control m-b'>
						<option value=''>Select</option>";
						//".$ass_detail['test_id']."-
						foreach($ass_detail_feedback as $key=>$ass_detail){
							$data.="<option value='".$ass_detail['ques_id']."' >".$ass_detail['ques_name']."</option>";
						}
					$data.="</select>
				</div>
			</div>
			<div class='form-group'><label class='col-sm-4 control-label'>Status<sup><font color='#FF0000'>*</font></sup>:</label>
				<div class='col-sm-8'>
					<select id='status' name='status' class='validate[required] form-control m-b'>
						<option value=''>Select</option>";
						foreach($status as $comp_status){
							$data.="<option value='".$comp_status['code']."'>".$comp_status['name']."</option>";
						}
					$data.="</select>
				</div>
			</div>
			<div class='hr-line-dashed'></div>
			<div class='form-group'>
				<div class='col-sm-offset-3'>
					<button class='btn btn-danger' type='button' data-dismiss='modal'>Cancel</button>
					<button class='btn btn-success' type='submit'  name='update'>Save changes</button>
				</div>
			</div>
		</form>";
		echo $data;
	}
	
	public function lms_assessment_position_feedback(){
        $this->sessionexist();
        if(isset($_POST['ques_id'])){
            $fieldinsertupdates=array('status');
			$check_aas_test=UlsAssessmentTest::get_ass_position_test($_POST['assessment_id'],$_POST['position_id'],$_POST['assessment_type']);
			$ass_test=!empty($check_aas_test['assess_test_id'])? Doctrine_Core::getTable('UlsAssessmentTest')->find($check_aas_test['assess_test_id']):new UlsAssessmentTest();
			$ass_test->assessment_pos_id=$_POST['assessment_pos_id'];
			$ass_test->position_id=$_POST['position_id'];
			$ass_test->assessment_id=$_POST['assessment_id'];
			$ass_test->assessment_type=$_POST['assessment_type'];
			$ass_test->save();
			$feed_assess_test_id=trim($_POST['feed_assess_test_id']);
            $ass_test_inbasket=!empty($feed_assess_test_id)?Doctrine::getTable('UlsAssessmentTestFeedback')->find($_POST['feed_assess_test_id']):new UlsAssessmentTestFeedback();
            foreach($fieldinsertupdates as $val){
				$ass_test_inbasket->$val=(!empty($_POST[$val]))?($_POST[$val]):NULL;
			}
			$ass_test_inbasket->ques_id=$_POST['ques_id'];
			$ass_test_inbasket->assess_test_id=$ass_test->assess_test_id;
			$ass_test_inbasket->assessment_pos_id=$ass_test->assessment_pos_id;
			$ass_test_inbasket->position_id=$ass_test->position_id;
			$ass_test_inbasket->assessment_id=$ass_test->assessment_id;
			$ass_test_inbasket->assessment_type=$ass_test->assessment_type;
            $ass_test_inbasket->save();
			
            redirect('admin/assessment_details?tab=4&pos_id='.$_POST['position_id'].'&id='.$_POST['assessment_id'].'&hash='.md5(SECRET.$_POST['assessment_id']));
        }
        else{
			$content = $this->load->view('admin/assessment_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }
	
	public function delete_assessment_feedback(){
		$code=$_REQUEST['val'];
		if(!empty($code)){
			$empdata = Doctrine_Query::create()->delete('UlsAssessmentTestFeedback')->where('feed_assess_test_id=?',$code)->execute();
			echo 1;
		}
        else{
			echo "Selected Assessment Feedback cannot be deleted. Ensure you delete all the usages of the Assessment Feedback before you delete it.";
		}
    }
	
	public function feedback_assessment_template(){
		header( "Content-Type: application/vnd.ms-excel" );
		header( "Content-disposition: attachment; filename=dashboard.xls" );
		$id=$_REQUEST['id'];
		$pos_id=$_REQUEST['pos_id'];
		if(isset($_REQUEST['id'])){
			$emp_details=UlsAssessmentEmployees::getassessmentemployees_position_report($id,$pos_id);
			$ab="<table class='tablestyled bgWhite' border='1'>
				<tr align='center' style='background-color:#436DAC; color:#fff;'>
					<td align='center'>S.No</td>
					<td align='center'>Feedback Seekers</td>
					<td>EmpCode</td>
					<td>EmpType</td>
					<td>EmpCode</td>
					<td>EmpType</td>
					<td>EmpCode</td>
					<td>EmpType</td>
					<td>EmpCode</td>
					<td>EmpType</td>
				</tr>";
				foreach($emp_details as $key=>$emp_detail){
					$ab.="<tr>
						<td>".($key+1)."</td>
						<td>".$emp_detail['employee_number']."</td>
						<td></td>
						<td>Manager</td>
						<td></td>
						<td>Peer</td>
						<td></td>
						<td>Sub</td>
						<td></td>
						<td>internal</td>
					</tr>";
				}
		$ab.="</table>";
		echo $ab;
		exit;
		
		}
	}
	
	public function upload_bulk_emp_feedback(){
		$this->sessionexist();
		$data = array();
		if(isset($_GET['files'])){
			print_r($_GET['files']);
			$error = false;
			$files = '';
			$qu = "";
			foreach($_FILES as $file){
				if(!empty($file['tmp_name'])){
					$fieldseparator = ",";
					$lineseparator = "\n";
					$csvfile = $file['tmp_name'];
					$addauto = 0;
					$save = 1;
					$outputfile = "output.sql";
					if(!file_exists($csvfile)) {
					echo "File not found. Make sure you specified the correct path.\n";
					exit;
					}
					$file = fopen($csvfile,"r");
					if(!$file) {
						echo "Error opening data file.\n";
						exit;
					}
					$size = filesize($csvfile);
					if(!$size) {
						echo "File is empty.\n";
						exit;
					}
					$csvcontent = fread($file,$size);
					$linearray = array();
					
					$qu .= "<div style='height:300px; overflow: auto;'>
					<table id='single_enroll_tab' class='table table-bordered table-striped' cellpadding='1' cellspacing='1'>";
					$qu .= "<thead>";
					$qu .= "<tr>";
					$qu .= "<th width='2%'>S.No</th>";
					$qu .= "<th width='22%'>Feedback Recipient User </th>";
					$qu .= "<th align='center' width='78%'>Feedback Giver</th>";
					$qu .= "</tr></thead><tbody>";	
					//,"internal"=>"Internal Customer","customer"=>"Customer"
					$user_relation=array("manager"=>"Manager","peer"=>"Peer","sub"=>"Sub Ordinate","internal"=>"Leadership Team");
					foreach(explode($lineseparator,$csvcontent) as $key=>$line) {
						
						if($key==0){
							$line=strtolower($line);
							$fieldname=explode($fieldseparator,$line);
						}
						if($key>0){ 
							/* $line = preg_replace_callback('|"[^"]+"|',create_function('$matches','return str_replace(\',\',\'*comma*\',$matches[0]);'),$line ); */
							$linearray = explode(',',$line);
							$linearray = str_replace('*comma*',',',$linearray);
							/*$line = trim($line," \t");
							$line = str_replace("\r","",$line);
							$line = str_replace("'","\'",$line);
							$linearray = explode($fieldseparator,$line);*/
							$linemysql = implode("','",$linearray);
							
							if(isset($linearray)){
								if(count($linearray)>1){
									$dd=$key+1;
									$chk=$key==1?"disabled":"";
									$empdata=UlsEmployeeMaster::get_empdetails_id_number($linearray[1]);
									if(isset($empdata['empid'])){
									$qu .= "<tr>";
									
									$qu .= "
									<td>".$key."</td>
									<td><input id='emp_id[".$key."]' type='hidden' value='".$empdata['empid']."' name='emp_id[]'>
									<input id='assessment_type[".$key."]' type='hidden' value='".$_GET['feed']."' name='assessment_type[]'>
										<input type='text' name='employee_number[".$key."]' id='employee_number[".$key."]' value='".$empdata['enumber']."' class='form-control' readonly ></td>";
									$k=2;
									$flag=0;
									$tt=0;
									$jj=0;
									$qu .="<td>";
									$qu .="<table class='table table-bordered' width='50%' id='Cases".$key."'>";
										for($i=2;$i<count($linearray);$i++){ // For Loop for Feedback Givers.
											$tt=$tt+1;
											if($i==2){
											  $qu .="<thead>
											  <tr> 
												   <th width='25%'>Emp Code</th>
												   <th width='25%'>Emp Type</th>
											  </tr></thead><tbody><tr>";
											}
											if($k%2==0){
												if(!empty($linearray[$i])){
												  /* if($jj==0){
													$addgpvalue=1;
												  }
												  else{
													$pp=$jj+1;
													$addgpvalue=$addgpvalue.",".$pp;
												  } */
												  $jj++;
												  //$chk_tab=$jj==1?"disabled":"";
												  $qu .="</tr><tr>";
												  
												  $flag=1;
												}
												else{
												  $qu .="</tr>";
												  $flag=0;
												}
											}
											else{
												$flag=0;
											}
											if($flag==1){
												$qu .="<td><input type='text'  name='giver_".trim($fieldname[$i])."_".($key)."[]' id='".trim($fieldname[$i])."_".($key)."[".$jj."]' value='".trim($linearray[$i])."'class='form-control col-xs-5'></td>";
											}
											else{
												if(!empty(trim($linearray[$i]))){
												$qu .="<td><select class='form-control col-xs-5' name='giver_".trim($fieldname[$i])."_".($key)."[]' id='".trim($fieldname[$i])."_".($key)."[".$jj."]'><option value=''>Select</option>";
												$aa="";
													foreach($user_relation as $ukey=>$uvalue){
													  //if($linearray[$i]=="Manager"){ echo $ukey; echo "<br />";}				
														$sel=(strtolower($ukey)==strtolower(trim($linearray[$i])))?"selected='selected'":"";
														$aa .="<option ".$sel."  value='".trim($ukey)."'>".trim($uvalue)."</option>";
													}
													$qu .=$aa."</select></td>";
												}
											}$k++;
										} //echo "mamagers count".$couman."<br />";
										//echo "for loop count-".$sp;
										$qu .="</tbody></table>
									</td>
								</tr>";
									}
								}
							}
						}
						$searchfor = array("<html>", "</html>", "<body>", "</body>","<table>", "</table>", "<tr>", "</tr>", "<th>", "</th>", "<td>", "</td>");
					}
				
					$parameter='"enrollment_div"';
					$qu .= "</table></div><br>";					
					$qu .= "<div class='modal-footer'>
						<input type='submit' name='feed_bulk_save'  id='single_save' value='Enroll' class='btn btn-primary' >&nbsp;&nbsp;&nbsp;
						<input type='button' class='btn btn-danger'   onClick='cancel_funct_bulk(\"bulk_enrollment_div_".$_GET['posid']."\")' value='cancel'/>
					</div>";
//                        
				}
				else{
					$error = true;
				}
			}
			$data = ($error) ? array('error' => 'There was an error uploading your files') : array($qu);
			//$data = $qu;
			//echo $qu;
		}
		else{
			 //$data = $qu;
			$data = array('success' => 'Form was submitted', 'formData' => $_POST);
		   
		} 
		echo json_encode($data);
		//echo json_encode($data);
		//echo $data = $qu;
	}
	
	public function assessement_feedback_details(){
		$cat=$_REQUEST['catid'];
		$ass_id=$_REQUEST['ass_id'];
		$pos_id=$_REQUEST['pos_id'];
		$group_id=$_REQUEST['group_id'];
		$seek=$_REQUEST['seekerid'];
		$catagory=explode('*' , $cat);
		echo "
		<h6>Total sought :".count($catagory)."</h6>
		<table class='table table-bordered' id='table'>
		<tr>
			<th>S.no.</th>
			<th>Name of the person</th>
			<th>Status</th>
		</tr>";
		$cou=1;
		foreach($catagory as $catag) {
		$aa=0; $bb=0; $gg=0; 
		$view=UlsEmployeeMaster::getempdetails($catag);
		$ss=UlsFeedbackEmployeeRating::giver_status($group_id,$catag,$seek);
		if(empty($ss)){
			$aa=$aa+1;
		}
		else{
			$feedopt=UlsFeedbackEmployeeRating::users_opt_dashboard($group_id,$catag,$seek);
			if(!empty($feedopt)){ 
				$gg=$gg+1;
			}
			$feedopt1=UlsFeedbackEmployeeRating::users_optw_dashboard($group_id,$catag,$seek);
			if(!empty($feedopt1)){ 
				$bb=$bb+1;
			}
		}
		echo "<tr>
				<td>".$cou."</td>
				<td>".$view['employee_number']."-".$view['full_name']."</td>
				<td>";
				if($aa==1){ echo "Not Given"; } else if ($gg==1){ echo "Given"; } else if($bb==1){  echo "Inproces"; }else{ echo  "Not Given"; } 
		echo "</td>
			</tr>";
			$cou++;
		}
		echo "</table>";
	}
	
	public function questionnaire_view(){
		$data["aboutpage"]=$this->pagedetails('admin','questionnaire_exercises_master_view');
        $id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1 || $id==""){
            $content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			$que_details=UlsQuestionnaireMaster::viewquestionnaire($_REQUEST['id']);
			$data["compdetails"]=$que_details;
			$data['positiondetails']=UlsQuestionnaireCompetency::view_questionnaire_comp_details($_REQUEST['id']);
			$data['edit_elements']=UlsQuestionnaireCompetencyElement::edit_comptency_element($_REQUEST['id']);
			$content = $this->load->view('admin/questionnaire_exercises_master_view',$data,true);
        }
		$this->render('layouts/adminnew',$content);
    }
	
	public function deletequestionnaire(){
		$id=trim($_REQUEST['val']);
		if(!empty($id) && is_numeric($id)){
			$uewi=Doctrine_Query::create()->from('UlsAssessmentTestFeedback')->where('ques_id='.$id)->execute();
			if(count($uewi)==0){
				$q1 = Doctrine_Query::create()->delete('UlsQuestionnaireCompetencyElement')->where('ques_id=?',$id)->execute();
				$q2 = Doctrine_Query::create()->delete('UlsQuestionnaireCompetency')->where('ques_id=?',$id)->execute();
				$q = Doctrine_Query::create()->delete('UlsQuestionnaireMaster')->where('ques_id=?',$id)->execute();
				echo 1;
			} 
			else{
				echo "Selected Questionnaire cannot be deleted. Ensure you delete all the usages of the Questionnaire before you delete it.";
			}
		}
	}
	
	public function instrument_search(){
		$data["aboutpage"]=$this->pagedetails('admin','instrument_search');
		$limit=filter_input(INPUT_GET,'perpage') ? filter_input(INPUT_GET,'perpage'):PER_PAGE;
        $page=filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page'):0;
        $start=$page!=0? ($page-1)*$limit:0;
        $filePath=BASE_URL."/admin/instrument_search";
        $data['limit']=$limit;
        $data['perpages']=UlsMenuCreation::perpage();
        $data['searchresults']=UlsBeInstruments::search($start, $limit);
		$total=UlsBeInstruments::searchcount();
        $otherParams="&perpage=".$limit;
        $data['pagination']=UlsMenuCreation::make_pages($page,$limit,$total,$filePath,$otherParams);
		$content = $this->load->view('admin/instrument_search',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function instrument_master(){
		$this->sessionexist();
        $data["aboutpage"]=$this->pagedetails('admin','language');
        $id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
        $hash=isset($_REQUEST['hash'])?$_REQUEST['hash']:"";
        $flag=!empty($hash)?((md5(SECRET.$id)!=$hash)?1:0):0;
        if($flag==1 && !empty($id)==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
        }
        else{
			if(!empty($_REQUEST['id'])){
				$data["intdetail"]=UlsBeInstruments::view_instrument_details($_REQUEST['id']);
				$data["sub_par_detail"]=UlsBeInsSubparameters::view_inst_subpara_details($_REQUEST['id']);
			}
            
			$content = $this->load->view('admin/instrument_master',$data,true);
        }

		$this->render('layouts/adminnew',$content);
	}
	
	public function instrument_master_edit(){
        $this->sessionexist();
        if(isset($_POST['instrument_id'])){
			foreach($_POST['ins_subpara_id'] as $key=>$value){ 
				$work_details_level=(!empty($_POST['ins_subpara_id'][$key]))?Doctrine::getTable('UlsBeInsSubparameters')->find($_POST['ins_subpara_id'][$key]):new UlsBeInsSubparameters;
				$work_details_level->ins_subpara_text=!empty($_POST['ins_subpara_text'][$key])?$_POST['ins_subpara_text'][$key]:NULL;
				$work_details_level->ins_subpara_text_lang=!empty($_POST['ins_subpara_text_lang'][$key])?$_POST['ins_subpara_text_lang'][$key]:NULL;
				$work_details_level->ins_subpara_text_ext=!empty($_POST['ins_subpara_text_ext'][$key])?$_POST['ins_subpara_text_ext'][$key]:NULL;
				$work_details_level->ins_subpara_text_ext_lang=!empty($_POST['ins_subpara_text_ext_lang'][$key])?$_POST['ins_subpara_text_ext_lang'][$key]:NULL;
				$work_details_level->save();
			}
            redirect('admin/instrument_master?id='.$_POST['instrument_id'].'&hash='.md5(SECRET.$_POST['instrument_id']));
        }
        else{
			$content = $this->load->view('admin/instrument_search',$data,true);
			$this->render('layouts/adminnew',$content);
        }
    }
	
	public function seeker_feedback_assessment_report(){
		$id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
		if($id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$data['feed_details']=UlsAssessmentFeedEmployees::get_feed_assessment_details($id);
			$content = $this->load->view('admin/assessment_seeker_feedback_statusreport',$data,true);
		}
		$this->render('layouts/report-layout',$content);
	}
	
	public function giver_feedback_assessment_report(){
		$id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
		if($id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$data['feed_details']=UlsAssessmentFeedEmployees::get_feed_giver_assessment_details($id);
			$content = $this->load->view('admin/assessment_giver_feedback_statusreport',$data,true);
		}
		$this->render('layouts/report-layout',$content);
	}
	
	public function publishfeedbackassessment(){
		$id=trim($_REQUEST['val']);
		if(!empty($id) && is_numeric($id)){
			$uewi=Doctrine_Query::create()->from('UlsAssessmentEmployees')->where('assessment_id='.$id)->execute();
			if(count($uewi)!=0){
				$feed_details=UlsAssessmentFeedEmployees::get_feed_assessment_details($id);
				$int=$pat=array();
				foreach($feed_details as $key=>$feed_detail){
					$gids=$pids="";
					if(!empty($feed_detail['manager_id'])){
						$gids=$feed_detail['manager_id'];
					}
					
					if(!empty($feed_detail['peer_id'])){
						if(!empty($gids)){
							$gids=$gids.",".$feed_detail['peer_id'];
						}
						else{
							$gids=$feed_detail['peer_id'];
						}
					}
					if(!empty($feed_detail['sub_ordinates_id'])){
						if(!empty($gids)){
							$gids=$gids.",".$feed_detail['sub_ordinates_id'];
						}
						else{
							$gids=$feed_detail['sub_ordinates_id'];
						}
					}
					if(!empty($feed_detail['customer_id'])){
						if(!empty($gids)){
							$gids=$gids.",".$feed_detail['customer_id'];
						}
						else{
							$gids=$feed_detail['customer_id'];
						}
					}
					$a=explode(',',$gids);
					
					foreach($a as $int_val){
						if(!in_array($int_val,$int)){
							$int[]=$int_val;
						}
					}
					
				}
				echo "<pre>";
				print_r(count($int));
				/* print_r(count($pat));  */
				
				foreach($int as $val){
					if(!empty($val)){
					$feedopt_giver=UlsEmployeeMaster::fetch_giver_emp($val);
					foreach($feedopt_giver as $feedopt_givers){
						if(!empty($feedopt_givers['employee_id'])){
							$empdetails="select a.full_name AS name, a.employee_id,a.email,u.`user_name`,u.`password` FROM uls_employee_master a 
							left join (SELECT `user_id`,`employee_id`,`user_name`,`password` FROM `uls_user_creation` GROUP BY employee_id)u ON a.employee_id = u.employee_id 
							where a.parent_org_id=".$_SESSION['parent_org_id']." and a.employee_id=".$feedopt_givers['employee_id'];
							$empdetail = UlsMenu::callpdorow($empdetails);
							$mail_tem="ASSESSMENT_INT_MAIL";
							//echo $feedopt_givers['employee_number']."-".$feedopt_givers['full_name'];
							$base=BASE_URL."/index/login";
							$empname=$empdetail['name'];
							$user_name=$empdetail['user_name'];
							$password=$empdetail['password'];
							$empid=$empdetail['employee_id'];
							$mail=$empdetail['email'];
							$st=$mail_tem;
							$notification=Doctrine_core::getTable('UlsNotification')->findOneByParent_org_idAndEvent_typeAndStatus($_SESSION['parent_org_id'],$st,'A');
							if(!empty($notification)){
								$tna_url="Assessment_Navigation.pdf";
								$emailBody =$notification->comments;
								$emailBody = str_replace("#NAME#",ucwords($empname),$emailBody);
								$emailBody = str_replace("#LINK#",$base,$emailBody);
								$emailBody = str_replace("#USERNAME#",$user_name,$emailBody);
								$emailBody = str_replace("#PASSWORD#",$password,$emailBody);
								$mailsubject=$emailBody;
								$subject= "myCAD - 360 Deg. Feedback";
								$ss=new UlsNotificationHistory();
								$ss->employee_id=$empid;
								$ss->timestamp=date('Y-m-d H:i:s');
								$ss->to=!empty($mail)? $mail : "";
								$ss->notification_id=$notification->notification_id;
								$ss->subject=$subject;
								$ss->attachment=$tna_url;
								$ss->mail_content=$mailsubject;
								//$ss->mail_status='A';
								$ss->save();
							} 
							//echo $feedopt_givers['employee_number']."-".$feedopt_givers['full_name'];
						}
					}
					}
				}
				
				echo 1;
			}
			else{
				echo "Selected Assessment cannot be deleted. This particular Assessment has been used in transaction table.";
			}
		}
	}
	
	public function publishfeedbackremindermails(){
		$id=trim($_REQUEST['val']);
		if(!empty($id) && is_numeric($id)){
			$uewi=Doctrine_Query::create()->from('UlsAssessmentEmployees')->where('assessment_id='.$id)->execute();
			if(count($uewi)!=0){
				$feed_details=UlsAssessmentFeedEmployees::get_feed_assessment_details($id);
				$int=array();
				foreach($feed_details as $key=>$feed_detail){
					$gids=$pids="";
					$gids=$feed_detail['employee_id'];
					if(!empty($feed_detail['manager_id'])){
						$gids=$feed_detail['manager_id'];
					}
					
					if(!empty($feed_detail['peer_id'])){
						if(!empty($gids)){
							$gids=$gids.",".$feed_detail['peer_id'];
						}
						else{
							$gids=$feed_detail['peer_id'];
						}
					}
					if(!empty($feed_detail['sub_ordinates_id'])){
						if(!empty($gids)){
							$gids=$gids.",".$feed_detail['sub_ordinates_id'];
						}
						else{
							$gids=$feed_detail['sub_ordinates_id'];
						}
					}
					if(!empty($feed_detail['customer_id'])){
						if(!empty($gids)){
							$gids=$gids.",".$feed_detail['customer_id'];
						}
						else{
							$gids=$feed_detail['customer_id'];
						}
					}
					$group_user[$feed_detail['group_id']]=$gids;
				}
				
				$a=explode(',',$gids);
					
				foreach($a as $int_val){
					if(!in_array($int_val,$int)){
						$int[]=$int_val;
					}
				}
				
				$ngivenuser=array();
		
				foreach($group_user as $key=>$val){
					$givenuser=array();
					$feedopt=UlsFeedbackEmployeeRating::getnotgivenusers($key);
					foreach($feedopt as $fopt){
						  $givenuser[]=$fopt['gv'];
					}
					
					$users=@explode(",",$val);
					
					foreach($users as $user){
						if(!in_array($user,$givenuser)){
							if(!in_array($user,$ngivenuser)){
								$ngivenuser[]=$user;
							}
						}
					}
				}
				/* echo "<pre>";
				print_r($ngivenuser); */
				foreach($ngivenuser as $val){
					$feedopt_giver=UlsEmployeeMaster::fetch_giver_emp($val);
					foreach($feedopt_giver as $feedopt_givers){
						if(!empty($feedopt_givers['employee_id'])){
							/* $empdetails="select a.full_name AS name, a.employee_id,a.email,u.`user_name`,u.`password` FROM uls_employee_master a 
							left join (SELECT `user_id`,`employee_id`,`user_name`,`password` FROM `uls_user_creation` GROUP BY employee_id)u ON a.employee_id = u.employee_id 
							where a.parent_org_id=".$_SESSION['parent_org_id']." and a.employee_id=".$feedopt_givers['employee_id'];
							$empdetail = UlsMenu::callpdorow($empdetails);
							$mail_tem="ASSESSMENT_INT_MAIL";
							//echo $feedopt_givers['employee_number']."-".$feedopt_givers['full_name'];
							$base=BASE_URL."/index/login";
							$empname=$empdetail['name'];
							$user_name=$empdetail['user_name'];
							$password=$empdetail['password'];
							$empid=$empdetail['employee_id'];
							$mail=$empdetail['email'];
							$st=$mail_tem;
							$notification=Doctrine_core::getTable('UlsNotification')->findOneByParent_org_idAndEvent_typeAndStatus($_SESSION['parent_org_id'],$st,'A');
							if(!empty($notification)){
								$emailBody =$notification->comments;
								$emailBody = str_replace("#NAME#",ucwords($empname),$emailBody);
								$emailBody = str_replace("#LINK#",$base,$emailBody);
								$emailBody = str_replace("#USERNAME#",$user_name,$emailBody);
								$emailBody = str_replace("#PASSWORD#",$password,$emailBody);
								$mailsubject=$emailBody;
								$subject= "VIBGYOR - 360 Deg. Feedback";
								$ss=new UlsNotificationHistory();
								$ss->employee_id=$empid;
								$ss->timestamp=date('Y-m-d H:i:s');
								$ss->to=!empty($mail)? $mail : "";
								$ss->notification_id=$notification->notification_id;
								$ss->subject=$subject;
								$ss->mail_content=$mailsubject;
								$ss->mail_status='A';
								$ss->save();
							}  */
							echo $feedopt_givers['employee_number']."-".$feedopt_givers['full_name']."<br>";
						}
					}
				}
				
				
				//echo 1;
			}
			else{
				echo "Selected Assessment cannot be deleted. This particular Assessment has been used in transaction table.";
			}
		}
	}
	
	public function final_assessment_report(){
		$id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
		if($id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$data['feed_details']=UlsAssessmentFeedEmployees::get_feed_assessment_details($id);
			$content = $this->load->view('admin/final_assessment_report',$data,true);
		}
		$this->render('layouts/report-layout',$content);
	}
	
	public function download_reports(){
		$content = $this->load->view('admin/admin_download_reports',$data,true);
		$this->render('layouts/ajax-layout',$content);
	}
	
	public function agel_dashboard()
	{
		$sq5="";
		$sq6="";
		$sq7="";
		if(!empty($_REQUEST['id'])){
			
			$data["ass_loc_name_detail"]=UlsMenu::callpdorow("SELECT `location_id`,`location_name` FROM `uls_location`  where location_id=".$_REQUEST['id']);
			$ass_id=UlsMenu::callpdorow("SELECT GROUP_CONCAT(DISTINCT(`assessment_id`)) as ass_ids FROM `uls_assessment_definition` WHERE ass_methods='Y' and assessment_status='A' and `location_id`=".$_REQUEST['id']);
			$sq5=" and a.assessment_id in (".$ass_id['ass_ids'].")";
			$sq6="";
			$locids = '';
			$loc_ids=UlsMenu::callpdo("SELECT b.`location_id`,b.`location_name` FROM `uls_assessment_employees` a 
			left join(SELECT `location_id`,`location_name` FROM `uls_location`) b on a.location_id=b.location_id
			WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." ".$sq5." group by a.location_id");
			foreach($loc_ids as $loc_idss){
				$locids.=$loc_idss['location_id'].',';
			}
			$locids = trim($locids, ',');
			
			$sq6=" and c.location_id in (".$locids.")";
			if(!empty($_REQUEST['aid'])){
				$data["ass_area_name_detail"]=UlsMenu::callpdorow("SELECT `organization_id`,`org_name` FROM `uls_organization_master` where organization_id=".$_REQUEST['aid']);
				$sq7=" and a.bu_id=".$_REQUEST['aid']."";
			}
		}
		$data["ass_loc_names"]=UlsMenu::callpdo("SELECT b.`location_id`,b.`location_name` FROM `uls_assessment_definition` a 
		left join(SELECT `location_id`,`location_name` FROM `uls_location`) b on a.location_id=b.location_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.ass_methods='Y' and a.assessment_status='A' group by a.location_id");
		$data["ass_area_names"]=UlsMenu::callpdo("SELECT b.`organization_id`,b.`org_name` FROM `uls_assessment_employees` a 
		left join(SELECT `organization_id`,`org_name` FROM `uls_organization_master`) b on a.bu_id=b.organization_id
		left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) c on a.assessment_id=c.assessment_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and c.ass_methods='Y' and c.assessment_status='A' group by a.bu_id");
		
		$data["total_emp"]=UlsMenu::callpdorow("SELECT count(distinct(employee_id)) as total_emp FROM `uls_assessment_employees` a
		left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) b on a.assessment_id=b.assessment_id WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and b.ass_methods='Y' and b.assessment_status='A'");
		if(!empty($_REQUEST['id'])){
			/* $data["total_emp_cluster"]=UlsMenu::callpdorow("SELECT count(distinct(employee_id)) as total_emp FROM `uls_assessment_employees` a
			left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) b on a.assessment_id=b.assessment_id WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and b.ass_methods='Y' and b.assessment_status='A' $sq5 $sq7"); */
			
			$data["total_emp_cluster"]=UlsMenu::callpdorow("SELECT count(distinct(e.employee_id)) as total_emp FROM `uls_utest_attempts_assessment` e
			left join(SELECT `assessment_id`,`position_id`,`employee_id`,`location_id`,bu_id FROM `uls_assessment_employees`) a on e.assessment_id=a.assessment_id and a.employee_id=e.employee_id
			left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) b on a.assessment_id=b.assessment_id WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and b.ass_methods='Y' and b.assessment_status='A' $sq5 $sq7");
		}
		/* $data["total_cemp"]=UlsMenu::callpdorow("SELECT count(distinct(a.employee_id)) as total_cemp FROM `uls_assessment_employees` a
		left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) b on a.assessment_id=b.assessment_id
		WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and a.status='C' and b.ass_methods='Y' and b.assessment_status='A'"); */
		$data["total_cemp"]=UlsMenu::callpdorow("SELECT count(distinct(a.employee_id)) as total_cemp FROM `uls_utest_attempts_assessment` a
		left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) b on a.assessment_id=b.assessment_id
		WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and a.status='A' and b.ass_methods='Y' and b.assessment_status='A'");
		if(!empty($_REQUEST['id'])){
		
			$data["total_cemp_cluster"]=UlsMenu::callpdorow("SELECT count(distinct(a.employee_id)) as total_cemp FROM `uls_assessment_employees` a
			left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) b on a.assessment_id=b.assessment_id
			WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and a.status='C' and b.ass_methods='Y' and b.assessment_status='A' $sq5 $sq7");
		}
		$data["assd_emp"]=UlsMenu::callpdorow("select count(distinct(e.employee_id)) as assd_emp from uls_assessment_employees a 
		left join(SELECT `assessment_id`,`position_id`,`employee_id`,`status` FROM `uls_assessment_report_final`) e on e.employee_id=a.employee_id and e.assessment_id=a.assessment_id and e.position_id=a.position_id  
		left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) b on a.assessment_id=b.assessment_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and b.ass_methods='Y' and b.assessment_status='A'  and a.status='C' and e.status='A'");
		//position_structure='S'
		if(!empty($_REQUEST['id'])){
			
			$data["assd_emp_cluster"]=UlsMenu::callpdorow("select count(distinct(e.employee_id)) as assd_emp from uls_assessment_employees a 
			left join(SELECT `assessment_id`,`position_id`,`employee_id`,`status` FROM `uls_assessment_report_final`) e on e.employee_id=a.employee_id and e.assessment_id=a.assessment_id and e.position_id=a.position_id  
			left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) b on a.assessment_id=b.assessment_id
			WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and b.ass_methods='Y' and b.assessment_status='A'  and a.status='C' and e.status='A' $sq5 $sq7");
		}
		
		$data["assd_pos"]=UlsMenu::callpdorow("SELECT count(distinct(b.position_id)) as assd_pos FROM `uls_assessment_report_final` a
		left join(SELECT `position_id`,`position_structure`,`position_structure_id`,`position_name` FROM `uls_position` where 1) b on a.`position_id`=b.`position_id`
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']);
		$data["assessor_count"]=UlsMenu::callpdorow("SELECT count(distinct(a.assessor_id)) as assessor_count FROM `uls_assessment_position_assessor` a 
		left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) b on a.assessment_id=b.assessment_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.`assessor_type`='INT' and b.ass_methods='Y' and b.assessment_status='A'");
		if(!empty($_REQUEST['id'])){
			$sq8="";
			if(!empty($_REQUEST['aid'])){
				$sq8=" and c.bu_id=".$_REQUEST['aid']."";
			}
			
			$data["assessor_count_cluster"]=UlsMenu::callpdorow("SELECT count(distinct(a.assessor_id)) as assessor_count FROM `uls_assessment_position_assessor` a 
			left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) b on a.assessment_id=b.assessment_id
			left join(SELECT `assessor_id`,`assessor_name`,`employee_id` FROM `uls_assessor_master`) d on d.assessor_id=a.assessor_id
			left join (select employee_id,full_name,employee_number,org_name,position_name,email,office_number,location_name,bu_id,location_id from employee_data group by employee_id)c on d.employee_id=c.employee_id
			WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.`assessor_type`='INT' and b.ass_methods='Y' and b.assessment_status='A' $sq5 $sq8 $sq6");
			
		}
		$data["loc_names"]=UlsMenu::callpdo("SELECT b.`location_id`,b.`location_name`,a.bu_id FROM `uls_assessment_employees` a 
		left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) d on a.assessment_id=d.assessment_id
		left join(SELECT `location_id`,`location_name` FROM `uls_location`) b on a.location_id=b.location_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and d.assessment_status='A' ".$sq5." ".$sq7." group by a.location_id");
		//position_structure='S'
		/* $data["emp_details"]=UlsMenu::callpdo("select b.full_name, b.employee_number, b.org_name,b.email,b.office_number,b.location_name,s.position_name as map_pos_name,p.position_name as pos_name,p.position_structure,a.* from uls_assessment_report_final a
		left join (select employee_id,full_name,employee_number,org_name,position_id,email,office_number,location_name from employee_data group by employee_id)b on b.employee_id=a.employee_id
		left join(SELECT `position_id`,`position_structure`,`position_name`,position_structure_id FROM `uls_position`) p on p.position_id=b.position_id
		left join(SELECT `position_id`,`position_structure`,`position_name`,position_structure_id FROM `uls_position` where 1) s on s.position_id=p.position_structure_id
		where 1 and a.parent_org_id=".$_SESSION['parent_org_id']); */
		
		$data["emp_details"]=UlsMenu::callpdo("select b.full_name, b.employee_number, b.org_name,b.email,b.office_number,b.location_name,b.position_name,a.* from uls_assessment_employees a
		left join (select employee_id,full_name,employee_number,org_name,position_name,email,office_number,location_name from employee_data group by employee_id)b on b.employee_id=a.employee_id
		left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) d on a.assessment_id=d.assessment_id
		where 1 and a.parent_org_id=".$_SESSION['parent_org_id']." and d.ass_methods='Y' and d.assessment_status='A' and a.status='C' group by a.employee_id order by b.`full_name` ASC");
		
		$data["assessor_details"]=UlsMenu::callpdo("SELECT c.full_name, c.employee_number,c.location_name  FROM `uls_assessment_position_assessor` a 
		left join(SELECT `assessor_id`,`assessor_name`,`employee_id` FROM `uls_assessor_master`) b on b.assessor_id=a.assessor_id
		left join (select employee_id,full_name,employee_number,org_name,position_name,email,office_number,location_name from employee_data group by employee_id)c on b.employee_id=c.employee_id
		WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and `assessor_type`='INT' group by a.assessor_id");
		$sq8="";
		if(!empty($_REQUEST['aid'])){
			$sq8=" and c.bu_id=".$_REQUEST['aid']."";
		}
		$data["loc_details"]=UlsMenu::callpdo("SELECT distinct(c.`location_name`) as location_name,c.location_id FROM `uls_assessment_position_assessor` a
		left join(SELECT `assessor_id`,`employee_id`,`assessor_name`,assessor_type FROM `uls_assessor_master`) b on b.assessor_id=a.assessor_id
		left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) d on a.assessment_id=d.assessment_id
		left join(SELECT `employee_id`,`employee_number`,`full_name`,`location_id`,location_name,bu_id FROM `employee_data`) c on c.employee_id=b.employee_id
		WHERE 1 and a.`parent_org_id`=".$_SESSION['parent_org_id']." and d.assessment_status='A' and b.assessor_type='INT' ".$sq5." ".$sq6." ".$sq8."  group by a.assessor_id,c.location_id");
		
		$data["ass_int"]=UlsMenu::callpdo("SELECT b.`assessor_id`,b.`employee_id`,b.`assessor_name`,c.`employee_number`,c.`full_name`,c.`location_id` FROM `uls_assessment_position_assessor` a
		left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) d on a.assessment_id=d.assessment_id
		left join(SELECT `assessor_id`,`employee_id`,`assessor_name`,assessor_type FROM `uls_assessor_master`) b on b.assessor_id=a.assessor_id
		left join(SELECT `employee_id`,`employee_number`,`full_name`,`location_id`,bu_id FROM `employee_data`) c on c.employee_id=b.employee_id
		WHERE 1 and a.`parent_org_id`=".$_SESSION['parent_org_id']." and d.assessment_status='A' and b.assessor_type='INT' ".$sq5." ".$sq6." ".$sq8."  group by a.assessor_id,c.location_id");
		
		$data["aboutpage"]=$this->pagedetails('admin','agel_dashboard');
		$content = $this->load->view('admin/agel_dashboard',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function get_agel_total_employees(){
		$loc_id=!empty($_REQUEST['id'])? " and a.location_id=".$_REQUEST['id']:"";
		
		$data="";
		
		$emp_names=UlsMenu::callpdo("SELECT b.`employee_id`,b.`employee_number`,b.`full_name`,b.org_name,b.position_name,b.location_name,a.`assessment_id`,a.`position_id`,b.email FROM `uls_assessment_employees` a
		left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) d on a.assessment_id=d.assessment_id
		left join(SELECT `employee_id`,`employee_number`,`full_name`,org_name,position_name,location_name,email FROM `employee_data` ) b on a.employee_id=b.employee_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and d.ass_methods='Y' and d.assessment_status='A' ".$loc_id." group by a.employee_id order by b.`full_name` ASC");
		
		
		$data.="
			<div class='pull-left'>";
				if(!empty($_REQUEST['id'])){
					$loca_name=UlsLocation::getloc($_REQUEST['id']);
					$data.="<h5 class='mb-15'>Location name:".$loca_name['location_name']."</h5>";
				}
			$data.="</div>
			<div class='pull-right'>
				<a class='btn btn-sm btn-success' id='download_excel'>Export To Excel</a>
				
			</div>
			<div class='clearfix'></div>
		
		<div class='table-wrap' style='height: 400px;overflow-y: auto;'>
		<table cellpadding='1' cellspacing='1' id='edit_datable_2' class='table table-hover table-bordered mb-0'>
			<thead>
				<tr>
					<th>S.No</th>
					<th>Emp. Code</th>
					<th>Emp. Name</th>
					<th>Email</th>
					<th>Location</th>
					<th>Department</th>
					<th>Designation</th>
				</tr>
			</thead>
			<tbody>";
			foreach($emp_names as $key=>$emp_name){
				$data.="<tr>
					<td>".($key+1)."</td>
					<td>".$emp_name['employee_number']."</td>
					<td>".$emp_name['full_name']."</td>
					<td>".$emp_name['email']."</td>
					<td>".$emp_name['location_name']."</td>
					<td>".$emp_name['org_name']."</td>
					<td>".$emp_name['position_name']."</td>
				</tr>";
			}
			$data.="</tbody>
		</table></div>";
		
		echo $data;
	}
	
	public function get_agel_cluster_total_employees(){
		$aid=$_REQUEST['id'];
		$bu_id=!empty($_REQUEST['b_id'])? " and a.bu_id=".$_REQUEST['b_id']:"";
		$data="";
		
		$emp_names=UlsMenu::callpdo("SELECT b.`employee_id`,b.`employee_number`,b.`full_name`,b.org_name,b.position_name,b.location_name,a.`assessment_id`,a.`position_id`,b.email FROM `uls_assessment_employees` a
		left join(SELECT `assessment_id`,`ass_methods`,assessment_status,location_id FROM `uls_assessment_definition`) d on a.assessment_id=d.assessment_id
		left join(SELECT `employee_id`,`employee_number`,`full_name`,org_name,position_name,location_name,email FROM `employee_data` ) b on a.employee_id=b.employee_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and d.ass_methods='Y' and d.assessment_status='A' and d.location_id=".$aid."  ".$bu_id." group by a.employee_id order by b.`full_name` ASC");
		
		
		$data.="
		
			<div class='pull-left'>";
		if(!empty($_REQUEST['id'])){
			$area_name="";
			$loca_name=UlsLocation::getloc($_REQUEST['id']);
			if(!empty($_REQUEST['b_id'])){
				$areaname=UlsMenu::callpdorow("SELECT `organization_id`,`org_name` FROM `uls_organization_master` where organization_id=".$_REQUEST['b_id']);
				$area_name=" - Area:".$areaname['org_name'];
			}
			$data.="<h5 class='mb-15'>Cluster:".$loca_name['location_name']." ".$area_name."</h5> ";
		}
		$data.="</div>
			<div class='pull-right'>
				<a class='btn btn-sm btn-success' id='download_excel'>Export To Excel</a>
				
			</div>
			<div class='clearfix'></div>
		
		<div class='table-wrap' style='height: 400px;overflow-y: auto;'>
		<table cellpadding='1' cellspacing='1' id='edit_datable_2' class='table table-hover table-bordered mb-0'>
			<thead>
				<tr>
					<th>S.No</th>
					<th>Emp. Code</th>
					<th>Emp. Name</th>
					<th>Email</th>
					<th>Location</th>
					<th>Department</th>
					<th>Designation</th>
				</tr>
			</thead>
			<tbody>";
			foreach($emp_names as $key=>$emp_name){
				$data.="<tr>
					<td>".($key+1)."</td>
					<td>".$emp_name['employee_number']."</td>
					<td>".$emp_name['full_name']."</td>
					<td>".$emp_name['email']."</td>
					<td>".$emp_name['location_name']."</td>
					<td>".$emp_name['org_name']."</td>
					<td>".$emp_name['position_name']."</td>
				</tr>";
			}
			$data.="</tbody>
		</table></div>";
		
		echo $data;
	}
	
	public function get_agel_completed_employees(){
		$loc_id=!empty($_REQUEST['id'])? " and e.location_id=".$_REQUEST['id']:"";
		$data="";
		/* $emp_names=UlsMenu::callpdo("SELECT b.`employee_id`,b.`employee_number`,b.`full_name`,b.org_name,b.position_name,b.location_name,a.`assessment_id`,a.`position_id`,b.email FROM `uls_assessment_employees` a
		left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) d on a.assessment_id=d.assessment_id
		left join(SELECT `employee_id`,`employee_number`,`full_name`,org_name,position_name,location_name,email FROM `employee_data` ) b on a.employee_id=b.employee_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.status='C' and d.ass_methods='Y' and d.assessment_status='A' ".$loc_id." group by a.employee_id order by b.`full_name` ASC"); */
		$emp_names=UlsMenu::callpdo("SELECT a.`employee_id`,a.`employee_number`,a.`full_name`,a.org_name,a.position_name,a.location_name,b.`assessment_id`,a.email FROM `uls_utest_attempts_assessment` b
		left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) d on b.assessment_id=d.assessment_id
		left join(SELECT `assessment_id`,`position_id`,`employee_id`,`location_id` FROM `uls_assessment_employees`) e on e.assessment_id=b.assessment_id and b.employee_id=e.employee_id
		left join(SELECT `employee_id`,`employee_number`,`full_name`,org_name,position_name,location_name,email FROM `employee_data` ) a on a.employee_id=b.employee_id
		WHERE b.`parent_org_id`=".$_SESSION['parent_org_id']." and b.status='A' and d.ass_methods='Y' and d.assessment_status='A' ".$loc_id." group by b.employee_id order by a.`full_name` ASC");
		
		$data.="
		<div class='pull-left'>";
		if(!empty($_REQUEST['id'])){
			$loca_name=UlsLocation::getloc($_REQUEST['id']);
			$data.="<h5 class='mb-15'>Location name:".$loca_name['location_name']."</h5>";
		}
		$data.="</div>
		<div class='pull-right'>
			<a class='btn btn-sm btn-success' id='download_excel_comp'>Export To Excel</a>
			
		</div>
		<div class='clearfix'></div>
		
		<div class='table-wrap' style='height: 400px;overflow-y: auto;'>
		<table cellpadding='1' cellspacing='1' id='edit_datable_2_comp' class='table table-hover table-bordered mb-0'>
			<thead>
				<tr>
					<th>S.No</th>
					<th>Emp. Code</th>
					<th>Emp. Name</th>
					<th>Email</th>
					<th>Location</th>
					<th>Department</th>
					<th>Designation</th>
				</tr>
			</thead>
			<tbody>";
			foreach($emp_names as $key=>$emp_name){
				$data.="<tr>
					<td>".($key+1)."</td>
					<td>".$emp_name['employee_number']."</td>
					<td>".$emp_name['full_name']."</td>
					<td>".$emp_name['email']."</td>
					<td>".$emp_name['location_name']."</td>
					<td>".$emp_name['org_name']."</td>
					<td>".$emp_name['position_name']."</td>
				</tr>";
			}
			$data.="</tbody>
		</table></div>";
		
		echo $data;
	}
	
	public function get_agel_cluster_completed_employees(){
		$aid=$_REQUEST['id'];
		$bu_id=!empty($_REQUEST['b_id'])? " and a.bu_id=".$_REQUEST['b_id']:"";
		
		$data="";
		$emp_names=UlsMenu::callpdo("SELECT b.`employee_id`,b.`employee_number`,b.`full_name`,b.org_name,b.position_name,b.location_name,a.`assessment_id`,a.`position_id`,b.email FROM `uls_assessment_employees` a
		left join(SELECT `assessment_id`,`ass_methods`,assessment_status,location_id FROM `uls_assessment_definition`) d on a.assessment_id=d.assessment_id
		left join(SELECT `employee_id`,`employee_number`,`full_name`,org_name,position_name,location_name,email FROM `employee_data` ) b on a.employee_id=b.employee_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.status='C' and d.ass_methods='Y' and d.assessment_status='A' and d.location_id=".$aid." ".$bu_id." group by a.employee_id order by b.`full_name` ASC");
		
		$data.="
		
			<div class='pull-left'>";
		if(!empty($_REQUEST['id'])){
			$area_name="";
			$loca_name=UlsLocation::getloc($_REQUEST['id']);
			if(!empty($_REQUEST['b_id'])){
				$areaname=UlsMenu::callpdorow("SELECT `organization_id`,`org_name` FROM `uls_organization_master` where organization_id=".$_REQUEST['b_id']);
				$area_name=" - Area:".$areaname['org_name'];
			}
			$data.="<h5 class='mb-15'>Cluster:".$loca_name['location_name']." ".$area_name."</h5> ";
		}
		$data.="</div>
			<div class='pull-right'>
				<a class='btn btn-sm btn-success' id='download_excel_comp'>Export To Excel</a>
				
			</div>
			<div class='clearfix'></div>
		
		
		<div class='table-wrap' style='height: 400px;overflow-y: auto;'>
		<table cellpadding='1' cellspacing='1' id='edit_datable_2_comp' class='table table-hover table-bordered mb-0'>
			<thead>
				<tr>
					<th>S.No</th>
					<th>Emp. Code</th>
					<th>Emp. Name</th>
					<th>Email</th>
					<th>Location</th>
					<th>Department</th>
					<th>Designation</th>
				</tr>
			</thead>
			<tbody>";
			foreach($emp_names as $key=>$emp_name){
				$data.="<tr>
					<td>".($key+1)."</td>
					<td>".$emp_name['employee_number']."</td>
					<td>".$emp_name['full_name']."</td>
					<td>".$emp_name['email']."</td>
					<td>".$emp_name['location_name']."</td>
					<td>".$emp_name['org_name']."</td>
					<td>".$emp_name['position_name']."</td>
				</tr>";
			}
			$data.="</tbody>
		</table></div>";
		
		echo $data;
	}
	
	public function get_agel_pending_employees(){
		$data="";
		$loc_id=!empty($_REQUEST['id'])? " and a.location_id=".$_REQUEST['id']:"";
		/* $emp_names=UlsMenu::callpdo("SELECT b.`employee_id`,b.`employee_number`,b.`full_name`,b.org_name,b.position_name,b.location_name,a.`assessment_id`,a.`position_id`,b.email FROM `uls_assessment_employees` a
		
		left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) d on a.assessment_id=d.assessment_id
		left join(SELECT `employee_id`,`employee_number`,`full_name`,org_name,position_name,location_name,email FROM `employee_data` ) b on a.employee_id=b.employee_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.status is NULL and d.ass_methods='Y' and d.assessment_status='A' ".$loc_id." group by a.employee_id order by b.`full_name` ASC"); */
		
		$emp_names_ass=UlsMenu::callpdorow("SELECT GROUP_CONCAT(`assessment_id`) as ass_id FROM `uls_assessment_definition` WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and assessment_status='A'");
		$emp_names=UlsMenu::callpdo("SELECT b.`employee_id`,b.`employee_number`,b.`full_name`,b.org_name,b.position_name,b.location_name,b.email FROM `uls_assessment_employees` a
		left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) d on a.assessment_id=d.assessment_id
		left join(SELECT `employee_id`,`employee_number`,`full_name`,org_name,position_name,location_name,email FROM `employee_data` ) b on a.employee_id=b.employee_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and d.assessment_status='A' ".$loc_id." and a.assessment_id in (".$emp_names_ass['ass_id'].") and a.employee_id not in (SELECT `employee_id` FROM `uls_utest_attempts_assessment` where assessment_id in (".$emp_names_ass['ass_id']."))");
		
		$data.="
		<div class='pull-left'>";
		if(!empty($_REQUEST['id'])){
			$loca_name=UlsLocation::getloc($_REQUEST['id']);
			$data.="<h5 class='mb-15'>Location name:".$loca_name['location_name']."</h5>";
		}
		$data.="</div>
		<div class='pull-right'>
			<a class='btn btn-sm btn-success' id='download_excel_pen'>Export To Excel</a>
			
		</div>
		<div class='clearfix'></div>
		<div class='table-wrap' style='height: 400px;overflow-y: auto;'>
		<table cellpadding='1' cellspacing='1' id='edit_datable_2_pen' class='table table-hover table-bordered mb-0'>
			<thead>
				<tr>
					<th>S.No</th>
					<th>Emp. Code</th>
					<th>Emp. Name</th>
					<th>Email</th>
					<th>Location</th>
					<th>Department</th>
					<th>Designation</th>
				</tr>
			</thead>
			<tbody>";
			foreach($emp_names as $key=>$emp_name){
				$data.="<tr>
					<td>".($key+1)."</td>
					<td>".$emp_name['employee_number']."</td>
					<td>".$emp_name['full_name']."</td>
					<td>".$emp_name['email']."</td>
					<td>".$emp_name['location_name']."</td>
					<td>".$emp_name['org_name']."</td>
					<td>".$emp_name['position_name']."</td>
				</tr>";
			}
			$data.="</tbody>
		</table></div>";
		
		echo $data;
	}
	
	public function get_agel_pending_employees_new(){
		$data="";
		$loc_id=!empty($_REQUEST['id'])? " and a.location_id=".$_REQUEST['id']:"";
		$emp_names_ass=UlsMenu::callpdorow("SELECT GROUP_CONCAT(`assessment_id`) as ass_id FROM `uls_assessment_definition` WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and assessment_status='A'");
		$emp_names=UlsMenu::callpdo("SELECT b.`employee_id`,b.`employee_number`,b.`full_name`,b.org_name,b.position_name,b.location_name,b.email FROM `uls_assessment_employees` a
		left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) d on a.assessment_id=d.assessment_id
		left join(SELECT `employee_id`,`employee_number`,`full_name`,org_name,position_name,location_name,email FROM `employee_data` ) b on a.employee_id=b.employee_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and d.assessment_status='A' ".$loc_id." and a.assessment_id in (".$emp_names_ass['ass_id'].") and a.employee_id not in (SELECT `employee_id` FROM `uls_utest_attempts_assessment` where assessment_id in (".$emp_names_ass['ass_id']."))");
		
		
		
		$data.="
		<div class='pull-left'>";
		if(!empty($_REQUEST['id'])){
			$loca_name=UlsLocation::getloc($_REQUEST['id']);
			$data.="<h5 class='mb-15'>Location name:".$loca_name['location_name']."</h5>";
		}
		$data.="</div>
		<div class='pull-right'>
			<a class='btn btn-sm btn-success' id='download_excel_pen'>Export To Excel</a>
			
		</div>
		<div class='clearfix'></div>
		<div class='table-wrap' style='height: 400px;overflow-y: auto;'>
		<table cellpadding='1' cellspacing='1' id='edit_datable_2_pen' class='table table-hover table-bordered mb-0'>
			<thead>
				<tr>
					<th>S.No</th>
					<th>Emp. Code</th>
					<th>Emp. Name</th>
					<th>Email</th>
					<th>Location</th>
					<th>Department</th>
					<th>Designation</th>
				</tr>
			</thead>
			<tbody>";
			foreach($emp_names as $key=>$emp_name){
				$data.="<tr>
					<td>".($key+1)."</td>
					<td>".$emp_name['employee_number']."</td>
					<td>".$emp_name['full_name']."</td>
					<td>".$emp_name['email']."</td>
					<td>".$emp_name['location_name']."</td>
					<td>".$emp_name['org_name']."</td>
					<td>".$emp_name['position_name']."</td>
				</tr>";
			}
			$data.="</tbody>
		</table></div>";
		
		echo $data;
	}
	
	public function get_agel_cluster_pending_employees(){
		$data="";
		$aid=$_REQUEST['id'];
		$bu_id=!empty($_REQUEST['b_id'])? " and a.bu_id=".$_REQUEST['b_id']:"";
		$emp_names=UlsMenu::callpdo("SELECT b.`employee_id`,b.`employee_number`,b.`full_name`,b.org_name,b.position_name,b.location_name,a.`assessment_id`,a.`position_id`,b.email FROM `uls_assessment_employees` a
		left join(SELECT `assessment_id`,`ass_methods`,assessment_status,location_id FROM `uls_assessment_definition`) d on a.assessment_id=d.assessment_id
		left join(SELECT `employee_id`,`employee_number`,`full_name`,org_name,position_name,location_name,email FROM `employee_data` ) b on a.employee_id=b.employee_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.status is NULL and d.ass_methods='Y' and d.assessment_status='A' and d.location_id=".$aid." ".$bu_id." group by a.employee_id order by b.`full_name` ASC");
		
		$data.="
		
			<div class='pull-left'>";
		if(!empty($_REQUEST['id'])){
			$area_name="";
			$loca_name=UlsLocation::getloc($_REQUEST['id']);
			if(!empty($_REQUEST['b_id'])){
				$areaname=UlsMenu::callpdorow("SELECT `organization_id`,`org_name` FROM `uls_organization_master` where organization_id=".$_REQUEST['b_id']);
				$area_name=" - Area:".$areaname['org_name'];
			}
			$data.="<h5 class='mb-15'>Cluster:".$loca_name['location_name']." ".$area_name."</h5> ";
		}
		$data.="</div>
			<div class='pull-right'>
				<a class='btn btn-sm btn-success' id='download_excel_pen'>Export To Excel</a>
				
			</div>
			<div class='clearfix'></div>
		
		<div class='table-wrap' style='height: 400px;overflow-y: auto;'>
		<table cellpadding='1' cellspacing='1' id='edit_datable_2_pen' class='table table-hover table-bordered mb-0'>
			<thead>
				<tr>
					<th>S.No</th>
					<th>Emp. Code</th>
					<th>Emp. Name</th>
					<th>Email</th>
					<th>Location</th>
					<th>Department</th>
					<th>Designation</th>
				</tr>
			</thead>
			<tbody>";
			foreach($emp_names as $key=>$emp_name){
				$data.="<tr>
					<td>".($key+1)."</td>
					<td>".$emp_name['employee_number']."</td>
					<td>".$emp_name['full_name']."</td>
					<td>".$emp_name['email']."</td>
					<td>".$emp_name['location_name']."</td>
					<td>".$emp_name['org_name']."</td>
					<td>".$emp_name['position_name']."</td>
				</tr>";
			}
			$data.="</tbody>
		</table></div>";
		
		echo $data;
	}
	
	/* public function get_agel_assessor_details(){
		$data="";
		$emp_names=UlsMenu::callpdo("SELECT c.`employee_id`,c.`employee_number`,c.`full_name`,c.org_name,c.location_name,c.email,b.assessor_id  FROM `uls_assessment_position_assessor` a 
		left join(SELECT `assessor_id`,`assessor_name`,`employee_id` FROM `uls_assessor_master`) b on b.assessor_id=a.assessor_id
		left join (select employee_id,full_name,employee_number,org_name,position_name,email,office_number,location_name from employee_data group by employee_id)c on b.employee_id=c.employee_id
		WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and `assessor_type`='INT' group by a.assessor_id");
		
		$data.="
		<a class='btn btn-sm btn-success' id='download_excel_ass'>Export To Excel</a>
		<div class='table-wrap' style='height: 400px;overflow-y: auto;'>
		<table cellpadding='1' cellspacing='1' id='edit_datable_2_ass' class='table table-hover table-bordered mb-0'>
			<thead>
				<tr>
					<th>S.No</th>
					<th>Emp. Code</th>
					<th>Emp. Name</th>
					<th>Email</th>
					<th>Location</th>
					<th>Department</th>
				</tr>
			</thead>
			<tbody>";
			foreach($emp_names as $key=>$emp_name){
				$data.="<tr>
					<td>".($key+1)."</td>
					<td>".$emp_name['employee_number']."</td>
					<td>".$emp_name['full_name']."</td>
					<td>".$emp_name['email']."</td>
					<td>".$emp_name['location_name']."</td>
					<td>".$emp_name['org_name']."</td>
				</tr>";
			}
			$data.="</tbody>
		</table></div>";
		
		echo $data;
	} */
	
	public function get_agel_assessor_details(){
		$data="";
		$assessor_details=UlsAssessmentPositionAssessor::get_unique_assessors_assessment();
		$data.="
		<a class='btn btn-sm btn-success' id='download_excel_ass'>Export To Excel</a>
		<div class='table-wrap' style='height: 500px;overflow-y: auto;'>
		<table cellpadding='1' cellspacing='1' id='edit_datable_2_ass' class='table table-hover table-bordered mb-0'>
			<thead>
				<tr>
					<th rowspan='2'>S.No</th>
					<th rowspan='2'>Assessor Name</th>
					<th rowspan='2'>Assessment Name</th>
					<th rowspan='2'>Total</th>
					<th rowspan='2'>No. of Emp Mapped</th>
					<th rowspan='2'>Completed By Assessor</th>
					<th rowspan='2'>Pending</th>
				</tr>
			</thead>
			<tbody>";
			$assessor=$ass_c=$ass_tot=$assfinal="";
			$key=1;
			$total_ass=0;
			$assessor_array=array();
			foreach($assessor_details as $assessor_detail){
				$assessor_array[$assessor_detail['assessor_id']][$assessor_detail['assessment_id']]['assessor_id']=$assessor_detail['assessor_id'];
				$assessor_array[$assessor_detail['assessor_id']][$assessor_detail['assessment_id']]['assessor_name']=$assessor_detail['assessor_name'];
				$assessor_array[$assessor_detail['assessor_id']][$assessor_detail['assessment_id']]['assessment_name']=$assessor_detail['assessment_name'];
				//$posids=$ass_rights['positionids'];
				//$pos_id=$positions['position_id'];
				$pos_id=explode(",",$assessor_detail['positionids']);
				$total_c=$fianl_c=0;
				foreach($pos_id as $pos_ids){
					$ass_rights=UlsAssessmentPositionAssessor::get_assessor_rights($assessor_detail['assessment_id'],$assessor_detail['assessor_id'],$pos_ids);
					$ass_per=($ass_rights['assessor_per']=='Y')?$ass_rights['emp_ids']:"";
					$employee=UlsAssessmentPositionAssessor::get_assessor_assessmentreport($assessor_detail['assessment_id'],'ASS',$ass_per,$pos_ids);
					$total_c+=$employee['total_emp'];
					$ass_final=UlsAssessmentReportFinal::assessment_assessor_report($assessor_detail['assessment_id'],$pos_ids,$assessor_detail['assessor_id']);
					$fianl_c+=$ass_final['comp_total'];
				}
				
				$assessor_array[$assessor_detail['assessor_id']][$assessor_detail['assessment_id']]['total_count']=$total_c;
				$assessor_array[$assessor_detail['assessor_id']][$assessor_detail['assessment_id']]['total_final']=$fianl_c;
				
			}
			/* echo "<pre>";	
			print_r($assessor_array); */
			foreach($assessor_array as $key_n=>$assessor_arrays){
				foreach($assessor_arrays as $key_h=>$assessorarrays){
				$data.="<tr>";
					if($ass_c!=$assessorarrays['assessor_id']){
						$ass_c=$assessorarrays['assessor_id'];
						$data.="<td rowspan='".count($assessor_array[$key_n])."'>".$key."</td>";
						$key++;
					}
					
					if($assessor!=$assessorarrays['assessor_id']){
						$assessor=$assessorarrays['assessor_id'];
						$data.="<td rowspan='".count($assessor_array[$key_n])."'>".$assessorarrays['assessor_name']."</td>";
					}
					$data.="<td>".$assessorarrays['assessment_name']."</td>";
					if($ass_tot!=$assessorarrays['assessor_id']){
						$ass_tot=$assessorarrays['assessor_id'];
						$count_ass=0;
						foreach($assessor_array[$key_n] as $count_assessor){
							$count_ass=($count_assessor['total_count']+$count_ass);
						}
						$data.="<td rowspan='".count($assessor_array[$key_n])."'>".$count_ass."</td>";
					}
					$data.="<td>".$assessorarrays['total_count']."</td>
					<td>".$assessorarrays['total_final']."</td>";
					if($assfinal!=$assessorarrays['assessor_id']){
						$assfinal=$assessorarrays['assessor_id'];
						$count_final=0;
						foreach($assessor_array[$key_n] as $count_assessor){
							$count_final=(($count_assessor['total_count']-$count_assessor['total_final'])+$count_final);
						}
						$data.="<td rowspan='".count($assessor_array[$key_n])."'>".$count_final."</td>";
					}
				$data.="</tr>";
				}
			}
			$data.="</tbody>
		</table></div>";
		echo $data;
	}
	
	public function get_agel_cluster_assessor_details(){
		$aid=$_REQUEST['id'];
		$bu_id=!empty($_REQUEST['b_id'])? " and c.bu_id=".$_REQUEST['b_id']:"";
		$data="";
		$ass_id=UlsMenu::callpdorow("SELECT GROUP_CONCAT(DISTINCT(`assessment_id`)) as ass_ids FROM `uls_assessment_definition` WHERE ass_methods='Y' and assessment_status='A' and `location_id`=".$aid);
		$sq5=" and a.assessment_id in (".$ass_id['ass_ids'].")";
		$sq6="";
		$locids = '';
		$loc_ids=UlsMenu::callpdo("SELECT b.`location_id`,b.`location_name` FROM `uls_assessment_employees` a 
		left join(SELECT `location_id`,`location_name` FROM `uls_location`) b on a.location_id=b.location_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." ".$sq5." group by a.location_id");
		foreach($loc_ids as $loc_idss){
			$locids.=$loc_idss['location_id'].',';
		}
		$locids = trim($locids, ',');
		
		$emp_names=UlsMenu::callpdo("SELECT c.`employee_id`,c.`employee_number`,c.`full_name`,c.org_name,c.location_name,c.email,b.assessor_id  FROM `uls_assessment_position_assessor` a 
		left join(SELECT `assessor_id`,`assessor_name`,`employee_id` FROM `uls_assessor_master`) b on b.assessor_id=a.assessor_id
		left join (select employee_id,full_name,employee_number,org_name,position_name,email,office_number,location_name,bu_id,location_id from employee_data group by employee_id)c on b.employee_id=c.employee_id
		left join(SELECT `assessment_id`,`ass_methods`,assessment_status,location_id FROM `uls_assessment_definition`) d on a.assessment_id=d.assessment_id
		WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and `assessor_type`='INT' and d.ass_methods='Y' and d.assessment_status='A' and c.location_id in (".$locids.") ".$bu_id." group by a.assessor_id");
		
		$data.="
			<div class='pull-left'>";
				if(!empty($_REQUEST['id'])){
					$area_name="";
					$loca_name=UlsLocation::getloc($_REQUEST['id']);
					if(!empty($_REQUEST['b_id'])){
						$areaname=UlsMenu::callpdorow("SELECT `organization_id`,`org_name` FROM `uls_organization_master` where organization_id=".$_REQUEST['b_id']);
						$area_name=" - Area:".$areaname['org_name'];
					}
					$data.="<h5 class='mb-15'>Cluster:".$loca_name['location_name']." ".$area_name."</h5> ";
				}
				$data.="</div>
			<div class='pull-right'>
				<a class='btn btn-sm btn-success' id='download_excel_ass'>Export To Excel</a>
				
			</div>
			<div class='clearfix'></div>
		
		
		<div class='table-wrap' style='height: 400px;overflow-y: auto;'>
		<table cellpadding='1' cellspacing='1' id='edit_datable_2_ass' class='table table-hover table-bordered mb-0'>
			<thead>
				<tr>
					<th>S.No</th>
					<th>Emp. Code</th>
					<th>Emp. Name</th>
					<th>Email</th>
					<th>Location</th>
					<th>Department</th>
				</tr>
			</thead>
			<tbody>";
			foreach($emp_names as $key=>$emp_name){
				$data.="<tr>
					<td>".($key+1)."</td>
					<td>".$emp_name['employee_number']."</td>
					<td>".$emp_name['full_name']."</td>
					<td>".$emp_name['email']."</td>
					<td>".$emp_name['location_name']."</td>
					<td>".$emp_name['org_name']."</td>
				</tr>";
			}
			$data.="</tbody>
		</table></div>";
		
		echo $data;
	}
	
	public function get_agel_emp_assessed_details(){
		$data="";
		$emp_names=UlsMenu::callpdo("select b.full_name, b.employee_number, b.org_name,b.email,b.office_number,b.location_name,b.position_name,a.* from uls_assessment_employees a 
		left join(SELECT `assessment_id`,`position_id`,`employee_id`,`status` FROM `uls_assessment_report_final`) e on e.employee_id=a.employee_id and e.assessment_id=a.assessment_id and e.position_id=a.position_id
		left join (select employee_id,full_name,employee_number,org_name,position_name,email,office_number,location_name from employee_data group by employee_id)b on b.employee_id=a.employee_id
		left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) d on a.assessment_id=d.assessment_id
		where 1 and a.parent_org_id=".$_SESSION['parent_org_id']." and d.ass_methods='Y' and d.assessment_status='A' and a.status='C' and e.status='A' group by e.employee_id");
		
		$data.="
		<a class='btn btn-sm btn-success' id='download_excel_assd'>Export To Excel</a>
		<div class='table-wrap' style='height: 400px;overflow-y: auto;'>
		<table cellpadding='1' cellspacing='1' id='edit_datable_2_assd' class='table table-hover table-bordered mb-0'>
			<thead>
				<tr>
					<th>S.No</th>
					<th>Emp. Code</th>
					<th>Emp. Name</th>
					<th>Email</th>
					<th>Location</th>
					<th>Department</th>
					<th>Designation</th>
				</tr>
			</thead>
			<tbody>";
			foreach($emp_names as $key=>$emp_name){
				$data.="<tr>
					<td>".($key+1)."</td>
					<td>".$emp_name['employee_number']."</td>
					<td>".$emp_name['full_name']."</td>
					<td>".$emp_name['email']."</td>
					<td>".$emp_name['location_name']."</td>
					<td>".$emp_name['org_name']."</td>
					<td>".$emp_name['position_name']."</td>
				</tr>";
			}
			$data.="</tbody>
		</table></div>";
		
		echo $data;
	}
	
	public function get_agel_cluster_emp_assessed_details(){
		$aid=$_REQUEST['id'];
		$bu_id=!empty($_REQUEST['b_id'])? " and a.bu_id=".$_REQUEST['b_id']:"";
		$data="";
		$emp_names=UlsMenu::callpdo("select b.full_name, b.employee_number, b.org_name,b.email,b.office_number,b.location_name,b.position_name,a.* from uls_assessment_employees a 
		left join(SELECT `assessment_id`,`position_id`,`employee_id`,`status` FROM `uls_assessment_report_final`) e on e.employee_id=a.employee_id and e.assessment_id=a.assessment_id and e.position_id=a.position_id
		left join (select employee_id,full_name,employee_number,org_name,position_name,email,office_number,location_name from employee_data group by employee_id)b on b.employee_id=a.employee_id
		left join(SELECT `assessment_id`,`ass_methods`,assessment_status,location_id FROM `uls_assessment_definition`) d on a.assessment_id=d.assessment_id
		where 1 and a.parent_org_id=".$_SESSION['parent_org_id']." and d.ass_methods='Y' and d.assessment_status='A' and a.status='C' and e.status='A' and d.location_id=".$aid." ".$bu_id." group by e.employee_id");
		
		$data.="
		
		<div class='pull-left'>";
		if(!empty($_REQUEST['id'])){
			$area_name="";
			$loca_name=UlsLocation::getloc($_REQUEST['id']);
			if(!empty($_REQUEST['b_id'])){
				$areaname=UlsMenu::callpdorow("SELECT `organization_id`,`org_name` FROM `uls_organization_master` where organization_id=".$_REQUEST['b_id']);
				$area_name=" - Area:".$areaname['org_name'];
			}
			$data.="<h5 class='mb-15'>Cluster:".$loca_name['location_name']." ".$area_name."</h5> ";
		}
		$data.="</div>
		<div class='pull-right'>
			<a class='btn btn-sm btn-success' id='download_excel_assd'>Export To Excel</a>
			
		</div>
		<div class='clearfix'></div>
		
		
		<div class='table-wrap' style='height: 400px;overflow-y: auto;'>
		<table cellpadding='1' cellspacing='1' id='edit_datable_2_assd' class='table table-hover table-bordered mb-0'>
			<thead>
				<tr>
					<th>S.No</th>
					<th>Emp. Code</th>
					<th>Emp. Name</th>
					<th>Email</th>
					<th>Location</th>
					<th>Department</th>
					<th>Designation</th>
				</tr>
			</thead>
			<tbody>";
			foreach($emp_names as $key=>$emp_name){
				$data.="<tr>
					<td>".($key+1)."</td>
					<td>".$emp_name['employee_number']."</td>
					<td>".$emp_name['full_name']."</td>
					<td>".$emp_name['email']."</td>
					<td>".$emp_name['location_name']."</td>
					<td>".$emp_name['org_name']."</td>
					<td>".$emp_name['position_name']."</td>
				</tr>";
			}
			$data.="</tbody>
		</table></div>";
		
		echo $data;
	}
	
	public function get_agel_emp_pending_assessed_details(){
		$data="";
		$emp_names=UlsMenu::callpdo("SELECT b.`employee_id`,b.`employee_number`,b.`full_name`,b.org_name,b.position_name,b.location_name,a.`assessment_id`,a.`position_id`,b.email FROM `uls_assessment_employees` a
		left join(SELECT `employee_id`,`employee_number`,`full_name`,org_name,position_name,location_name,email FROM `employee_data` ) b on a.employee_id=b.employee_id	
		left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) d on a.assessment_id=d.assessment_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and d.ass_methods='Y' and d.assessment_status='A' and a.status='C' and a.employee_id not in (SELECT `employee_id` FROM `uls_assessment_report_final` where status='A' group by employee_id) group by a.employee_id order by b.`full_name` ASC");
		
		$data.="
		<a class='btn btn-sm btn-success' id='download_excel_passd'>Export To Excel</a>
		<div class='table-wrap' style='height: 400px;overflow-y: auto;'>
		<table cellpadding='1' cellspacing='1' id='edit_datable_2_passd' class='table table-hover table-bordered mb-0'>
			<thead>
				<tr>
					<th>S.No</th>
					<th>Emp. Code</th>
					<th>Emp. Name</th>
					<th>Email</th>
					<th>Location</th>
					<th>Department</th>
					<th>Designation</th>
				</tr>
			</thead>
			<tbody>";
			foreach($emp_names as $key=>$emp_name){
				$data.="<tr>
					<td>".($key+1)."</td>
					<td>".$emp_name['employee_number']."</td>
					<td>".$emp_name['full_name']."</td>
					<td>".$emp_name['email']."</td>
					<td>".$emp_name['location_name']."</td>
					<td>".$emp_name['org_name']."</td>
					<td>".$emp_name['position_name']."</td>
				</tr>";
			}
			$data.="</tbody>
		</table></div>";
		
		echo $data;
	}
	
	public function get_agel_cluster_emp_pending_assessed_details(){
		$aid=$_REQUEST['id'];
		$bu_id=!empty($_REQUEST['b_id'])? " and a.bu_id=".$_REQUEST['b_id']:"";
		$data="";
		$emp_names=UlsMenu::callpdo("SELECT b.`employee_id`,b.`employee_number`,b.`full_name`,b.org_name,b.position_name,b.location_name,a.`assessment_id`,a.`position_id`,b.email FROM `uls_assessment_employees` a
		left join(SELECT `employee_id`,`employee_number`,`full_name`,org_name,position_name,location_name,email FROM `employee_data` ) b on a.employee_id=b.employee_id	
		left join(SELECT `assessment_id`,`ass_methods`,assessment_status,location_id FROM `uls_assessment_definition`) d on a.assessment_id=d.assessment_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and d.ass_methods='Y' and d.assessment_status='A' and a.status='C' and d.location_id=".$aid." ".$bu_id." and a.employee_id not in (SELECT `employee_id` FROM `uls_assessment_report_final` where status='A' group by employee_id) group by a.employee_id order by b.`full_name` ASC");
		
		$data.="
		<div class='pull-left'>";
		if(!empty($_REQUEST['id'])){
			$area_name="";
			$loca_name=UlsLocation::getloc($_REQUEST['id']);
			if(!empty($_REQUEST['b_id'])){
				$areaname=UlsMenu::callpdorow("SELECT `organization_id`,`org_name` FROM `uls_organization_master` where organization_id=".$_REQUEST['b_id']);
				$area_name=" - Area:".$areaname['org_name'];
			}
			$data.="<h5 class='mb-15'>Cluster:".$loca_name['location_name']." ".$area_name."</h5> ";
		}
		$data.="</div>
		<div class='pull-right'>
			<a class='btn btn-sm btn-success' id='download_excel_passd'>Export To Excel</a>
			
		</div>
		<div class='clearfix'></div>
		
		<div class='table-wrap' style='height: 400px;overflow-y: auto;'>
		<table cellpadding='1' cellspacing='1' id='edit_datable_2_passd' class='table table-hover table-bordered mb-0'>
			<thead>
				<tr>
					<th>S.No</th>
					<th>Emp. Code</th>
					<th>Emp. Name</th>
					<th>Email</th>
					<th>Location</th>
					<th>Department</th>
					<th>Designation</th>
				</tr>
			</thead>
			<tbody>";
			foreach($emp_names as $key=>$emp_name){
				$data.="<tr>
					<td>".($key+1)."</td>
					<td>".$emp_name['employee_number']."</td>
					<td>".$emp_name['full_name']."</td>
					<td>".$emp_name['email']."</td>
					<td>".$emp_name['location_name']."</td>
					<td>".$emp_name['org_name']."</td>
					<td>".$emp_name['position_name']."</td>
				</tr>";
			}
			$data.="</tbody>
		</table></div>";
		
		echo $data;
	}
	
	public function agel_assessed_assessement(){
		$loc_id=$_REQUEST['loc_id'];
		$total_emp_loc_details=UlsMenu::callpdo("SELECT c.full_name, c.employee_number,c.org_name,c.email,c.office_number,c.location_name,c.position_name,a.* FROM `uls_assessment_report_final` a
		left join(SELECT `assessment_id`,`position_id`,`employee_id`,location_id FROM `uls_assessment_employees`) e on e.employee_id=a.employee_id and e.assessment_id=a.assessment_id and e.position_id=a.position_id
		left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) d on a.assessment_id=d.assessment_id
		left join (select employee_id,full_name,employee_number,org_name,position_id,position_name,email,office_number,location_name,location_id from employee_data group by employee_id)c on a.employee_id=c.employee_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.status='A'  and d.ass_methods='Y' and d.assessment_status='A' and e.location_id=".$loc_id);
		
		
		$loc_name=UlsLocation::location_details($loc_id);
		$data="";
		$data.="<div class='row' id='result_data'>
			
			<div class='col-lg-4 col-md-5 col-sm-12 col-xs-12'>
				<div class='panel panel-default card-view panel-refresh'>
					<div class='refresh-container'>
						<div class='la-anim-1'></div>
					</div>
					<div class='panel-heading'>
						<div class='pull-left'>
							<h6 class='panel-title txt-dark'>Assessors in ".$loc_name['location_name']."</h6>
						</div>
						
						<div class='clearfix'></div>
					</div>
					<div class='panel-wrapper collapse in'>
						<div class='panel-body'>
							<ul class='chat-list-wrap'>
								<li class='chat-list'>
									<div class='chat-body' style='height: 500px;overflow: auto;'>";
									
									$assessor_details=UlsMenu::callpdo("SELECT c.full_name, c.employee_number,c.location_name  FROM `uls_assessment_report_final` a 
									left join(SELECT `assessor_id`,`assessor_name`,`employee_id` FROM `uls_assessor_master`) b on b.assessor_id=a.assessor_id
									left join (select employee_id,full_name,employee_number,org_name,position_name,email,office_number,location_name,location_id from employee_data group by employee_id)c on b.employee_id=c.employee_id
									WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and c.location_id=".$loc_id." group by a.assessor_id");	
									foreach($assessor_details as $key=>$assessor_detail){
									$data.="<div class='chat-data'>
										<img class='user-img img-circle' src='https://adani-power.n-compas.com/public/images/male_user.jpg' alt='user'>
										<div class='user-data'>
											<span class='name block capitalize-font'>".$assessor_detail['full_name']."</span>
											<span class='time block truncate txt-grey'>".$assessor_detail['employee_number']."</span>
											<span class='time block truncate txt-grey'>".$assessor_detail['location_name']."</span>
										</div>
										
										<div class='status away'></div>
										<div class='clearfix'></div>
									</div>
									<hr class='light-grey-hr row mt-10 mb-15'>";
									}
									$data.="</div>
								</li>
							</ul>
						</div>
					</div>	
				</div>	
			</div>
			<div class='col-lg-8 col-md-7 col-sm-12 col-xs-12'>
				<div class='panel panel-default card-view panel-refresh'>
					<div class='refresh-container'>
						<div class='la-anim-1'></div>
					</div>
					<div class='panel-heading'>
						<div class='pull-left'>
							<h6 class='panel-title txt-dark'>Assessed in ".$loc_name['location_name']."</h6>
						</div>
						<div class='clearfix'></div>
					</div>
					<div class='panel-wrapper collapse in'>
						<div class='panel-body row pa-0'>
							<div class='table-wrap'>
								<div style='height: 500px;overflow: auto;'>
									<div class='table-responsive'>
										<table class='table table-hover table-bordered display mb-30'>
											<thead>
												<tr>
													<th>S.No</th>
													<th>Emp Code</th>
													<th>Emp Name</th>
													<th>Designation</th>
													<th>Department</th>
													<th>Location</th>
													<th>Assessor Status</th>
												</tr>
											</thead>
											<tbody>";
											foreach($total_emp_loc_details as $key=>$total_emp_loc_detail){
												
												$ass_pos_count=UlsMenu::callpdorow("SELECT count(distinct(assessor_id)) as ass_count FROM `uls_assessment_position_assessor` WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and `position_id`=".$total_emp_loc_detail['position_id']." and `assessment_id`=".$total_emp_loc_detail['assessment_id']." and assessor_per='Y' and find_in_set(".$total_emp_loc_detail['employee_id'].",emp_ids)");
												$ass_pos_count2=UlsMenu::callpdorow("SELECT count(distinct(assessor_id)) as ass_counts FROM `uls_assessment_position_assessor` WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and `position_id`=".$total_emp_loc_detail['position_id']." and `assessment_id`=".$total_emp_loc_detail['assessment_id']." and assessor_per is NULL");
												$empass_pos_count=UlsMenu::callpdorow("SELECT count(assessor_id) as asscount FROM `uls_assessment_report_final` WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and employee_id=".$total_emp_loc_detail['employee_id']." and `position_id`=".$total_emp_loc_detail['position_id']." and `assessment_id`=".$total_emp_loc_detail['assessment_id']);
												$pos_name=$total_emp_loc_detail['position_name'];
												$data.="<tr>
													<td>".($key+1)."</td>
													<td>".$total_emp_loc_detail['employee_number']."</td>
													<td>".$total_emp_loc_detail['full_name']."</td>
													<td>".$pos_name."</td>
													<td>".$total_emp_loc_detail['org_name']."</td>
													<td>".$total_emp_loc_detail['location_name']."</td>
													<td>";
													$asessord_count=($ass_pos_count['ass_count']+$ass_pos_count2['ass_counts']);
													if($asessord_count==$empass_pos_count['asscount']){
														$data.="Completed";
													}
													else{
														$data.="InProcess";
													}
													$data.="</td>
												</tr>";
											}
											$data.="</tbody>
										</table>
										
									</div>
								</div>
							</div>	
						</div>	
					</div>
				</div>
			</div>
		</div>";
	echo $data;
	}
	
	public function agel_tobe_assessement(){
		$loc_id=$_REQUEST['loc_id'];
		$total_emp_loc_details=UlsMenu::callpdo("SELECT c.full_name, c.employee_number,c.org_name,c.email,c.office_number,c.location_name,c.position_name,a.* FROM `uls_assessment_employees` a
		left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) b on a.assessment_id=b.assessment_id
		left join (select employee_id,full_name,employee_number,org_name,position_id,position_name,email,office_number,location_name from employee_data group by employee_id)c on a.employee_id=c.employee_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.status='C' and b.ass_methods='Y' and b.assessment_status='A' and a.location_id=".$loc_id);
		$loc_name=UlsLocation::location_details($loc_id);
		$data="";
		$data.="<div class='row' id='result_data'>
			
			<div class='col-lg-4 col-md-5 col-sm-12 col-xs-12'>
				<div class='panel panel-default card-view panel-refresh'>
					<div class='refresh-container'>
						<div class='la-anim-1'></div>
					</div>
					<div class='panel-heading'>
						<div class='pull-left'>
							<h6 class='panel-title txt-dark'>Assessors in ".$loc_name['location_name']."</h6>
						</div>
						
						<div class='clearfix'></div>
					</div>
					<div class='panel-wrapper collapse in'>
						<div class='panel-body'>
							<ul class='chat-list-wrap'>
								<li class='chat-list'>
									<div class='chat-body' style='height: 500px;overflow: auto;'>";
									$assessor_details=UlsMenu::callpdo("SELECT c.full_name, c.employee_number,c.location_name  FROM `uls_assessment_position_assessor` a 
									left join(SELECT `assessor_id`,`assessor_name`,`employee_id` FROM `uls_assessor_master`) b on b.assessor_id=a.assessor_id
									left join (select employee_id,full_name,employee_number,org_name,position_name,email,office_number,location_name,location_id from employee_data group by employee_id)c on b.employee_id=c.employee_id
									WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and `assessor_type`='INT' and location_id=".$loc_id." group by a.assessor_id");	
									foreach($assessor_details as $key=>$assessor_detail){
									$data.="<div class='chat-data'>
										<img class='user-img img-circle' src='https://adani-power.n-compas.com/public/images/male_user.jpg' alt='user'>
										<div class='user-data'>
											<span class='name block capitalize-font'>".$assessor_detail['full_name']."</span>
											<span class='time block truncate txt-grey'>".$assessor_detail['employee_number']."</span>
											<span class='time block truncate txt-grey'>".$assessor_detail['location_name']."</span>
										</div>
										
										<div class='status away'></div>
										<div class='clearfix'></div>
									</div>
									<hr class='light-grey-hr row mt-10 mb-15'>";
									}
									$data.="</div>
								</li>
							</ul>
						</div>
					</div>	
				</div>	
			</div>
			<div class='col-lg-8 col-md-7 col-sm-12 col-xs-12'>
				<div class='panel panel-default card-view panel-refresh'>
					<div class='refresh-container'>
						<div class='la-anim-1'></div>
					</div>
					<div class='panel-heading'>
						<div class='pull-left'>
							<h6 class='panel-title txt-dark'>To be Assessed in ".$loc_name['location_name']."</h6>
						</div>
						<div class='clearfix'></div>
					</div>
					<div class='panel-wrapper collapse in'>
						<div class='panel-body row pa-0'>
							<div class='table-wrap'>
								<div style='height: 500px;overflow: auto;'>
									<div class='table-responsive'>
										<table class='table table-hover table-bordered display mb-30'>
											<thead>
												<tr>
													<th>S.No</th>
													<th>Emp Code</th>
													<th>Emp Name</th>
													<th>Designation</th>
													<th>Department</th>
													<th>Location</th>
													<th>Assessor Status</th>
												</tr>
											</thead>
											<tbody>";
											foreach($total_emp_loc_details as $key=>$total_emp_loc_detail){
												$ass_pos_count=UlsMenu::callpdorow("SELECT count(distinct(assessor_id)) as ass_count FROM `uls_assessment_position_assessor` WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and `position_id`=".$total_emp_loc_detail['position_id']." and `assessment_id`=".$total_emp_loc_detail['assessment_id']." and assessor_per='Y' and find_in_set(".$total_emp_loc_detail['employee_id'].",emp_ids)");
												$ass_pos_count2=UlsMenu::callpdorow("SELECT count(distinct(assessor_id)) as ass_counts FROM `uls_assessment_position_assessor` WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and `position_id`=".$total_emp_loc_detail['position_id']." and `assessment_id`=".$total_emp_loc_detail['assessment_id']." and assessor_per is NULL");
												$empass_pos_count=UlsMenu::callpdorow("SELECT count(assessor_id) as asscount FROM `uls_assessment_report_final` WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and employee_id=".$total_emp_loc_detail['employee_id']." and `position_id`=".$total_emp_loc_detail['position_id']." and `assessment_id`=".$total_emp_loc_detail['assessment_id']);
												$pos_name=$total_emp_loc_detail['position_name'];
												$data.="<tr>
													<td>".($key+1)."</td>
													<td>".$total_emp_loc_detail['employee_number']."</td>
													<td>".$total_emp_loc_detail['full_name']."</td>
													<td>".$pos_name."</td>
													<td>".$total_emp_loc_detail['org_name']."</td>
													<td>".$total_emp_loc_detail['location_name']."</td>
													<td>";
													$asessord_count=($ass_pos_count['ass_count']+$ass_pos_count2['ass_counts']);
													if($asessord_count==$empass_pos_count['asscount']){
														$data.="Completed";
													}
													else{
														$data.="InProcess";
													}
													$data.="</td>
												</tr>";
											}
											$data.="</tbody>
										</table>
										
									</div>
								</div>
							</div>	
						</div>	
					</div>
				</div>
			</div>
		</div>";
	echo $data;
	}
	
	public function assessment_test_result_statusreport(){
		$id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
		if($id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$data['emp_details']=UlsAssessmentEmployees::get_test_status_assessmentreport($id);
			$content = $this->load->view('admin/assessment_test_result_statusreport',$data,true);
		}
		$this->render('layouts/report-layout',$content);
	}
	
	public function assessor_assessment()
	{
		$data=array();
		$data['assessor_details']=UlsAssessmentPositionAssessor::get_unique_assessors_assessment();
		$content = $this->load->view('admin/assessment_assessorreport',$data,true);
		$this->render('layouts/report-layout',$content);
	}
	
	public function assessment_employee_final_data_report()
	{
		$ass_id=isset($_REQUEST['ass_id'])? $_REQUEST['ass_id']:"";
		$ass_type=isset($_REQUEST['ass_type'])? $_REQUEST['ass_type']:"";
		$pos_id=isset($_REQUEST['pos_id'])? $_REQUEST['pos_id']:"";
		if($ass_id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$data["aboutpage"]=$this->pagedetails('admin','assessment_search');
			$data['assessments']=UlsMenu::callpdo("SELECT a.* FROM `uls_assessment_definition` a WHERE 1 and a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.assessment_status='A' order by assessment_id desc");
			$data['ass_id']=$ass_id;
			$data['pos_id']=$pos_id;
			$data["comp_data"]=UlsAssessmentCompetencies::get_assessment_emp_competencies_report($ass_id,$pos_id);
			$content = $this->load->view('admin/assessment_employee_final_data_report',$data,true);
			$this->render('layouts/report-layout',$content);
		}
	}
	
	public function assessment_final_data()
	{
		$data=array();
		$data['emp_data']=UlsAssessmentEmployees::assessment_final_data();
		$content = $this->load->view('admin/assessment_final_data_report',$data,true);
		$this->render('layouts/report-layout',$content);
	}
	
	public function report_generation_data()
	{
		$data=array();
		$data['emp_data']=UlsAssessmentEmployeeReportGeneration::report_generation_data();
		$content = $this->load->view('admin/report_generation_status',$data,true);
		$this->render('layouts/report-layout',$content);
	}
	
	public function competency_employee_selection(){
		$pos_id=$_REQUEST['pos_id'];
		$emp_id=$_REQUEST['emp_id'];
		$ass_info=UlsAssessmentEmployees::get_assessment_comp_employees($emp_id);
		$compdetails=UlsAssessmentCompetencies::getassessment_competencies($ass_info['assessment_id'],$pos_id);
		$data="";
		$data.='
		<form id="case_master'.$pos_id.'" action="'.BASE_URL.'/admin/competency_mapped_employee_insert" method="post" enctype="multipart/form-data">
		<input type="hidden" name="assessment_pos_emp_id" id="assessment_pos_emp_id" value="'.$emp_id.'">
		<input type="hidden" name="assessment_id" id="assessment_id" value="'.$ass_info['assessment_id'].'">
		<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th></th>
					<th>Competencies</th>
					<th>Scale</th>
				</tr>
			</thead>
			<tbody>';
			$select_emp=!empty($ass_info['comp_ids'])?explode(',',$ass_info['comp_ids']):"";
			$selectemp=!empty($ass_info['comp_ids'])?$ass_info['comp_ids']:"";
			foreach($compdetails as $compdetail){
				if(!empty($select_emp)){
					$ched=in_array($compdetail['assessment_pos_com_id'],$select_emp) ? " checked='checked' disabled='disabled'" : "";	
				}
				else{
					$ched="";
				}
				
				$data.='<tr>
				<td><input type="checkbox" name="emp_selection['.$compdetail['assessment_pos_com_id'].']" id="emp_selection[]" value="'.$compdetail['assessment_pos_com_id'].'" class="selected_check_comp" '.$ched.'></td>
				<td>'.$compdetail['comp_def_name'].'</td>
				<td>'.$compdetail['scale_name'].'</td>
				</tr>';
			}
			$data.='</tbody>
		</table>
		<input type="hidden" name="comp_ids" value="'.$selectemp.'">
		<div class="modal-footer">
			<input type="button" class="btn btn-danger"  data-dismiss="modal" value="cancel"/>&nbsp;&nbsp;&nbsp;
			<input type="submit" name="single_save"  id="single_save" value="Save" class="btn btn-primary">
			
		</div>
		</form>
		';
		echo $data;
	}
	
	public function competency_mapped_employee_insert(){
		if(isset($_POST['single_save'])){
			/* echo "<pre>";
			print_r($_POST); */
			$work=(!empty($_POST['assessment_pos_emp_id']))?Doctrine::getTable('UlsAssessmentEmployees')->find($_POST['assessment_pos_emp_id']):new UlsAssessmentEmployees;
			$work->comp_ids=$_POST['comp_ids'];
			$work->save();
			redirect('admin/assessment_details?tab=8&pos_id='.$work->position_id.'&id='.$work->assessment_id.'&hash='.md5(SECRET.$work->assessment_id));
			//redirect('admin/assessment_details?tab=3&id='.$_POST['assessment_id'].'&hash='.md5(SECRET.$_POST['assessment_id'])); 
		}
	}
	
	public function interview_question_details(){
		$level_id=$_REQUEST['level_id'];
		$comp_id=$_REQUEST['comp_id'];
		$id=$_REQUEST['id'];
		$data="";
		if(isset($id)){
			$interview_que=UlsCompetencyDefLevelInterview::get_interview_questions_details($id);
		}
		$status=UlsAdminMaster::get_value_names("STATUS");
		$data.="<form id='interview_val' action='".BASE_URL."/admin/insert_interview_question_details' method='post' enctype='multipart/form-data'>
			<input type='hidden' name='scale_id' value='".$level_id."'>
			<input type='hidden' name='comp_def_id' value='".$comp_id."'>
			<input type='hidden' name='comp_int_id' value='".(isset($interview_que['comp_int_id'])?$interview_que['comp_int_id']:'')."'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
				<h5 class='modal-title' id='myLargeModalLabel'>Add/Edit Interview Questions</h5>
			</div>
			<div class='modal-body'>
				<div class='panel-body'>
					<div class='col-lg-12'>
						<div class='form-group'>
							<label class='control-label mb-10 text-left'>Case Scenario:<sup><font color='#FF0000'>*</font></sup>:</label>
							<input type='text' name='int_scenario' id='int_scenario' class='form-control validate[required]' value='".(isset($interview_que['int_scenario'])?$interview_que['int_scenario']:'')."'>
							
						</div>
						<div class='form-group'>
							<label class='control-label mb-10 text-left'>Enter Interview questions Details<sup><font color='#FF0000'>*</font></sup>:</label>
							<textarea rows='8' class='form-control validate[required]' name='interview_question' id='interview_question'>".(isset($interview_que['interview_question'])?$interview_que['interview_question']:'')."</textarea>
						</div>
						<div class='form-group'>
							<label class='control-label mb-10 text-left'>Status:</label>
							<select class='validate[required] form-control m-b' name='status' id='status'>
								<option value=''>Select</option>";
								foreach($status as $status){
									$sel_sat=(isset($interview_que['status']))?($interview_que['status']==$status['code'])?"selected='selected'":'':'';
									$data.="<option value='".$status['code']."' ".$sel_sat.">".$status['name']."</option>";
								}
							$data.="</select>
						</div>
					</div>
					<div class='panel-body'>
						<div class='panel-heading hbuilt'>
							<div class='pull-left'>
								<h6 class='panel-title txt-dark'>Add Interview Questions</h6>
							</div>
						</div>
						<br style='clear:both'>
						<div class='table-responsive'>
							<table cellpadding='1' cellspacing='1' class='table table-bordered table-striped' id='competencyposTab' name='competencyposTab'>
								<thead>
									<tr>
										<th style='width:5%;'>select</th>
										<th style='width:20%;'>Question Type</th>
										<th style='width:35%;'>Question Name</th>
										<th style='width:35%;'>Question Answer</th>
									</tr>
								</thead>
								<tbody>";
								if(isset($id)){
								$interview_questions=UlsCompetencyDefLevelInterviewQuestions::get_interview_questions($id);
								}
								$comp_intquestions=UlsAdminMaster::get_value_names("COMP_INT_QUESTION");
								if(!empty($interview_questions)){
									$hide_val_c=array();
									foreach($interview_questions as $key=>$interview_que){ 
										$key1=$key+1; $hide_val_c[]=$key1; 
										
									$data.="<tr>
										<td style='padding-left: 18px;'>
											<input type='checkbox' name='chkbox[]' id='chkbox_".$key1."' value='".$interview_que['comp_int_qid']."' >
											<input type='hidden' name='comp_int_qid[]' id='comp_int_qid_".$key1."' value='".$interview_que['comp_int_qid']."'>
										</td>
										<td>
											<select name='comp_qtype[]' id='comp_qtype_".$key1."'  style='width:100%;' class='form-control m-b'>
												<option value=''>Select</option>";
												foreach($comp_intquestions as $comp_intquestion){
													$sel_sat=(isset($interview_que['comp_qtype']))?($interview_que['comp_qtype']==$comp_intquestion['code'])?"selected='selected'":'':'';
													$data.="<option value='".$comp_intquestion['code']."' ".$sel_sat.">".$comp_intquestion['name']."</option>";
												}
											$data.="</select>             
										</td>
										<td>
											<textarea rows='4' class='form-control' name='comp_question_name[]' id='comp_question_name_".$key1."'>".(isset($interview_que['comp_question_name'])?$interview_que['comp_question_name']:'')."</textarea>
										</td>
										<td>
											<textarea rows='4' class='form-control validate[required]' name='comp_question_answer[]' id='comp_question_answer_".$key1."'>".(isset($interview_que['comp_question_answer'])?$interview_que['comp_question_answer']:'')."</textarea>
										</td>
									</tr>";
									}  
									$hidden=@implode(',',$hide_val_c); 
								}
								else {
								$data.="<tr>
									<td style='padding-left: 18px;'>
											<input type='checkbox' name='chkbox[]' id='chkbox_1' value='1'>
											<input type='hidden' maxlength='10' id='comp_int_qid_1' name='comp_int_qid[]' value=''>
										</td>
										<td>
											<select name='comp_qtype[]' id='comp_qtype_1' style='width:100%;' class='form-control m-b'>
												<option value=''>Select</option>";
												foreach($comp_intquestions as $comp_intquestion){
													$data.="<option value='".$comp_intquestion['code']."' >".$comp_intquestion['name']."</option>";
												}
											$data.="</select>             
										</td>
										<td>
											<textarea rows='4' class='form-control' name='comp_question_name[]' id='comp_question_name_1'></textarea>        
										</td>
										<td>
											<textarea rows='4' class='form-control validate[required]' name='comp_question_answer[]' id='comp_question_answer_1'></textarea>          
										</td>
								</tr>";
									$hidden=1; 
								} 
								$data.="</tbody>
							</table>
							<input type='hidden' name='addgroup_position' id='addgroup_position' value='".$hidden."' />
						</div>
						<div class='pull-right'>
							<a class='btn btn-xs btn-primary' onclick='addcompetencyposition();'>&nbsp <i class='fa fa-plus-circle'></i> Add &nbsp </a>
							<a class='btn btn-danger btn-xs' onclick='deletecompetencyposition();'>&nbsp <i class='fa fa-trash-o'></i>  Delete &nbsp </a>
						</div>
					</div>
				</div>
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-danger text-left' data-dismiss='modal'>Close</button>
				<button class='btn btn-primary btn-sm' type='submit' name='save' id='save'> Proceed</button>
			</div>
		</form>";
		echo $data;
	}
	
	
	
	
	
	public function insert_interview_question_details(){
		if(isset($_POST['int_scenario'])){
			$level=(!empty($_POST['comp_int_id']))?Doctrine::getTable('UlsCompetencyDefLevelInterview')->find($_POST['comp_int_id']):new UlsCompetencyDefLevelInterview();
			$level->int_scenario=$_POST['int_scenario'];
			$level->interview_question=$_POST['interview_question'];
			$level->comp_def_id=$_POST['comp_def_id'];
			$level->scale_id=$_POST['scale_id'];
            $level->status=$_POST['status'];
            $level->save();
			if(!empty($_POST['comp_qtype'])){
				$attachinsrtupdt=array('comp_qtype', 'comp_question_name', 'comp_question_answer');
				foreach($_POST['comp_qtype'] as $key=>$value){
					if(!empty($_POST['comp_qtype'][$key])){
						$work_details_level=(!empty($_POST['comp_int_qid'][$key]))?Doctrine::getTable('UlsCompetencyDefLevelInterviewQuestions')->find($_POST['comp_int_qid'][$key]):new UlsCompetencyDefLevelInterviewQuestions;
						$work_details_level->comp_int_id=$level->comp_int_id;
						$work_details_level->comp_def_id=$level->comp_def_id;
						$work_details_level->scale_id=$level->scale_id;
						foreach($attachinsrtupdt as $att_val){
							 !empty($_POST[$att_val][$key])?$work_details_level->$att_val=trim($_POST[$att_val][$key]):Null;
						}
						$work_details_level->save();
					}
				}
			}
			$this->session->set_flashdata('indicator_message',"Level Interview questions data ".(!empty($_POST['comp_def_id'])?"updated":"inserted")." successfully.");
			redirect('admin/competency_levels?id='.$_POST['comp_def_id'].'&hash='.md5(SECRET.$_POST['comp_def_id']),'admin-layout');
		}
	}
	
	public function deletelevelinterview(){
		$id=trim($_REQUEST['val']);
		if(!empty($id) && is_numeric($id)){
			/* $uewi=Doctrine_Query::create()->from('uls_questionnaire_competency_element')->where('element_id='.$id)->execute();
			if(count($uewi)==0){ */
				$q = Doctrine_Query::create()->delete('UlsCompetencyDefLevelInterview')->where('comp_int_id=?',$id)->execute();
				echo 1;
			/* }
			else{
				echo "Selected Element cannot be deleted. This particular Element has been used in transaction table.";
			} */
		}
	}
	
	public function deleteteinterviewcompetencylevels(){
		$id=trim($_REQUEST['id']);
		if(!empty($id)){
			$uewi=Doctrine_Query::create()->from('UlsAssessmentReportBytypeInterview')->where('comp_int_qid='.$id)->execute();
			if(count($uewi)==0){
				$q = Doctrine_Query::create()->delete('UlsCompetencyDefLevelInterviewQuestions')->where('comp_int_qid=?',$id);
				$q->execute();
				echo 1;
			}
		}
		else{
			echo "Selected Competency Level cannot be deleted. Ensure you delete all the usages of the Competency Level before you delete it.";
		}
	}
	
	public function assessment_position_duplicate()
	{
		$data["aboutpage"]=$this->pagedetails('admin','assessment_position_duplicate');
		$org_stat="STATUS";
        $data["orgstat"]=UlsAdminMaster::get_value_names($org_stat);
		if(!empty($_REQUEST['id'])){
			$compdetails=UlsAssessmentDefinition::viewassessment($_REQUEST['id']);
            $data['compdetails']=$compdetails;
			$data['position_details']=UlsAssessmentPosition::getassessmentpositions($compdetails['assessment_id']);
		}
		$data["rating"]=UlsRatingMaster::rating_details();
		$data["positions"]=UlsPosition::fetch_all_pos();
		$content = $this->load->view('admin/assessment_position_duplicate',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function get_position_duplicate(){
		$ass_id=$_REQUEST['assessment_id'];
		$pos_id=$_REQUEST['position_id'];
		$position_details=UlsAssessmentPosition::get_assessment_position_dup($pos_id,$ass_id);
		$data="";
		$data.="
		<br>
		<div class='row'>
			<div class='col-md-2'>&nbsp;</div>
			<div class='col-md-8'>
				<div class='form-group'>
					<label class='control-label mb-10 col-sm-2'>Mapped Position Name:</label>
					<div class='col-sm-7'>
						<select name='dup_position_id' id='dup_position_id' class=' form-control m-b' onchange='getduppositiontest(".$ass_id.")'>
							<option value=''>Select</option>";
							foreach($position_details as $position){
								$data.="<option value='".$position['position_id']."'>".$position['assessment_name']."-".$position['position_name']."</option>";
							}
						$data.="</select>
					</div>
				</div>
			</div>
			<div class='col-md-2'>&nbsp;</div>
		</div>";
		echo $data;
		
	}
	
	public function get_position_duplicate_questions(){
		$ass_id=$_REQUEST['assessment_id'];
		$pos_id=$_REQUEST['position_id'];
		$dup_pos_id=$_REQUEST['du_position_id'];
		$ass_type="TEST";
		$data="";
		$ass_test=UlsAssessmentTest::get_ass_position($ass_id,$pos_id,$ass_type);
		if(!empty($ass_test['assess_test_id'])){
			$get_dup_pos=UlsAssessmentPosition::get_assessment_position_report($dup_pos_id,$ass_id);
			$ass_dup_test=UlsAssessmentTest::get_ass_position($get_dup_pos['assessment_id'],$dup_pos_id,$ass_type);
			
			$del=Doctrine_Query::create()->delete('UlsAssessmentTestQuestions')->where("assess_test_id=".$ass_test['assess_test_id']." and test_id=".$ass_test['test_id'])->execute();
			//echo "pos:".$ass_test['assess_test_id']."-Dup Pos".$ass_dup_test['assess_test_id'];
			$que_dup_pos=UlsAssessmentTestQuestions::getquestions_info($ass_dup_test['assess_test_id'],$ass_dup_test['test_id']);
			foreach($que_dup_pos as $que_dup_poss){
				//echo "Question_id".$que_dup_poss['q_id']."-Comp_id".$que_dup_poss['competency_id']."<br>";
				$test_qvalues=new UlsAssessmentTestQuestions();
				$test_qvalues->assess_test_id=$ass_test['assess_test_id'];
				$test_qvalues->test_quest_id=$que_dup_poss['test_quest_id'];
				$test_qvalues->test_id=$ass_test['test_id'];
				$test_qvalues->question_id=$que_dup_poss['q_id'];
				$test_qvalues->question_bank_id=$que_dup_poss['question_bank_id'];
				$test_qvalues->competency_id=$que_dup_poss['competency_id'];
				$test_qvalues->assessment_id=$ass_test['assessment_id'];
				$test_qvalues->position_id=$ass_test['position_id'];
				$test_qvalues->save();
			}
			
			$testdetails=UlsAssessmentTest::assessment_view_finals($ass_test['assess_test_id']);
		
			$data.="<hr class='light-grey-hr'>
			<div class='table-responsive'>
				<table class='table table-hover table-bordered mb-0' cellspacing='1' cellpadding='1' id='thetable'>
					<thead>
						<tr>
							<th style='width:10px;'>S.No</th>
							<th style='width:500px;'>Question Name </th>
							<th style='width:200px;'>Competency</th>
							<th style='width:130px;'>Level</th>
							<th style='width:50px;'>Action</th>
						</tr>
					</thead>
					<tbody>";
					foreach($testdetails as $key=>$que){
						$ques_check=UlsAssessmentTest::get_question_check($ass_id,$pos_id,$que['competency_id'],$que['question_id']);
						$check=!empty($ques_check['q_count'])?"style='color:red'":"";
						$keys=$key+1;
						$ques=$que['question_id'];
						$type=$que['type_flag'];
						$data.="<tr>
							<td>".$keys."</td>
							<td ".$check.">".$que['question_name']."</td>
							<td>".$que['comp_def_name']."</td>
							<td>".$que['scale_name']."</td>
							<td><a class='mr-10' data-target='#workinfoviewadd".$que['assessment_test_id']."' data-toggle='modal' href='#workinfoviewadd".$que['assessment_test_id']."' data-toggle='tooltip' data-placement='top' title='Add/Remove Question' onclick='delete_question_test(".$que['assessment_test_id'].",".$que['assess_test_id'].")'><i class='fa fa-trash-o text-danger'></i></a></td>
						</tr>
						<div id='workinfoviewadd".$que['assessment_test_id']."'  class='modal fade' tabindex='-1' role='dialog'  aria-hidden='true'>
							<div class='modal-dialog modal-lg'>
								<div class='modal-content'>
									<div class='color-line'></div>
									<div class='modal-header'>
										<h6 class='modal-title'>Questions Add/Remove In Test</h6>
									</div>
									<div class='modal-body'>
										<div id='questionbank_count".$que['assessment_test_id']."' class='modal-body no-padding'>
										
										</div>
									</div>
								</div>
							</div>
						</div>";
					}
					$data.="</tbody>
				</table>
			</div>
			<div class='hr-line-dashed'></div>
			<div class='seprator-block' style='margin-bottom: 10px;'></div>
			<div class='row'>
				<div class='col-md-offset-9 col-md-9'>
					<button class='btn btn-info btn-icon left-icon  mr-10' type='button' onclick='get_check_question(".$ass_test['assess_test_id'].")'> <i class='zmdi zmdi-edit'></i> <span>Preview Test Paper</span></button>
				</div>
			</div>
			<div class='seprator-block' style='margin-bottom: 10px;'></div>
			";
		}
		else{
			$data.="Test Not Added";
		}
		echo $data;
	}
	
	public function employee_assessment_status()
	{
		$sq5="";
		$sq6="";
		$sq7="";
		
		$data["total_emp"]=UlsMenu::callpdorow("SELECT count(distinct(employee_id)) as total_emp FROM `uls_assessment_employees` a
		left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) b on a.assessment_id=b.assessment_id WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and b.ass_methods='Y' and b.assessment_status='A'");
		
		$data["total_cemp"]=UlsMenu::callpdorow("SELECT count(distinct(a.employee_id)) as total_cemp FROM `uls_utest_attempts_assessment` a
		left join(SELECT `assessment_id`,`position_id`,`employee_id`,`location_id` FROM `uls_assessment_employees`) e on e.assessment_id=a.assessment_id and a.employee_id=e.employee_id
		left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) b on a.assessment_id=b.assessment_id
		WHERE `parent_org_id`=".$_SESSION['parent_org_id']." and a.status='A' and b.ass_methods='Y' and b.assessment_status='A'");
		
		$data["assd_emp"]=UlsMenu::callpdorow("select count(distinct(e.employee_id)) as assd_emp from uls_assessment_employees a 
		left join(SELECT `assessment_id`,`position_id`,`employee_id`,`status` FROM `uls_assessment_report_final`) e on e.employee_id=a.employee_id and e.assessment_id=a.assessment_id and e.position_id=a.position_id  
		left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) b on a.assessment_id=b.assessment_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and b.ass_methods='Y' and b.assessment_status='A'  and a.status='C' and e.status='A'");
		//position_structure='S'
		
		
		$data["assd_pos"]=UlsMenu::callpdorow("SELECT count(distinct(b.position_id)) as assd_pos FROM `uls_assessment_report_final` a
		left join(SELECT `position_id`,`position_structure`,`position_structure_id`,`position_name` FROM `uls_position` where 1) b on a.`position_id`=b.`position_id`
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']);
		$data["assessor_count"]=UlsMenu::callpdorow("SELECT count(distinct(a.assessor_id)) as assessor_count FROM `uls_assessment_position_assessor` a 
		left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) b on a.assessment_id=b.assessment_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.`assessor_type`='INT' and b.ass_methods='Y' and b.assessment_status='A'");
		
		$data["loc_names"]=UlsMenu::callpdo("SELECT b.`location_id`,b.`location_name`,a.bu_id FROM `uls_assessment_employees` a 
		left join(SELECT `location_id`,`location_name` FROM `uls_location`) b on a.location_id=b.location_id
		left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) c on a.assessment_id=c.assessment_id
		WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and c.assessment_status='A' group by a.location_id");
		
		
		$data["emp_details"]=UlsMenu::callpdo("select b.full_name, b.employee_number, b.org_name,b.email,b.office_number,b.location_name,b.position_name,a.* from uls_assessment_employees a
		left join (select employee_id,full_name,employee_number,org_name,position_name,email,office_number,location_name from employee_data group by employee_id)b on b.employee_id=a.employee_id
		left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) d on a.assessment_id=d.assessment_id
		where 1 and a.parent_org_id=".$_SESSION['parent_org_id']." and d.ass_methods='Y' and d.assessment_status='A' and a.status='C' group by a.employee_id order by b.`full_name` ASC");
		
		
		
		$data["aboutpage"]=$this->pagedetails('admin','employee_assessment_status');
		$content = $this->load->view('admin/employee_assessment_dashboard',$data,true);
		$this->render('layouts/adminnew',$content);
	}
	
	public function position_assessment_status_report(){
		$id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
		if($id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$data['comp_details']=UlsAssessmentEmployees::getassessmentcompetencies_test_report($id);
			$content = $this->load->view('admin/position_assessment_status_report',$data,true);
		}
		$this->render('layouts/report-layout',$content);
	}
	
	public function assessment_overallstatus_report(){
		$id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
		if($id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$data['emp_details']=UlsAssessmentReportFinal::assessment_employee_assessor_report($id);
			$content = $this->load->view('admin/assessment_overallstatus_report',$data,true);
		}
		$this->render('layouts/report-layout',$content);
	}
	
	public function assessment_interview_status_report(){
		$id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
		if($id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$pos_id="";
			$data["comp_data"]=UlsAssessmentCompetencies::get_assessment_competencies_report($id,$pos_id);
			$data['emp_details']=UlsAssessmentReportFinal::assessment_employee_assessor_report($id);
			$content = $this->load->view('admin/assessment_interview_status_report',$data,true);
		}
		$this->render('layouts/report-layout',$content);
	}
	
	public function assessment_competency_final_report(){
		$ass_id=isset($_REQUEST['ass_id'])? $_REQUEST['ass_id']:"";
		$ass_type=isset($_REQUEST['ass_type'])? $_REQUEST['ass_type']:"";
		$pos_id=isset($_REQUEST['pos_id'])? $_REQUEST['pos_id']:"";
		if($ass_id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			
			$data["comp_data"]=UlsAssessmentCompetencies::get_assessment_competencies_report($ass_id,$pos_id);
			$data['emp_details']=UlsAssessmentReportFinal::assessment_employee_interview_assessor_report($ass_id,$pos_id);
			$content = $this->load->view('admin/assessment_competency_final_report',$data,true);
		}
		$this->render('layouts/report-layout',$content);
	}
	
	public function assessment_comp_overall_report(){
		$id=isset($_REQUEST['id'])? $_REQUEST['id']:"";
		if($id==""){
			$content = $this->load->view('admin/lms_admin_restriction',$data,true);
		}
		else{
			$pos_id="";
			$data['emp_details']=UlsAssessmentEmployeeFinalReport::get_assessment_employees_comp_final($id);
			$content = $this->load->view('admin/assessment_comp_overall_report',$data,true);
		}
		$this->render('layouts/report-layout',$content);
	}
}



