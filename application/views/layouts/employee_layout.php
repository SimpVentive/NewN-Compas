<?php
$loguserid=UlsUserCreation::user_info($this->session->userdata('user_id'));
if(!empty($loguserid['employee_id'])){
	$logempid=UlsMenu::callpdoobjrow("select a.*,m.full_name as supname from employee_data a left join(SELECT `employee_number`,`full_name` FROM `employee_data` ) m on m.employee_number=a.hod where a.employee_id='".$loguserid['employee_id']."'");
	
	$emp_journey=UlsMenu::callpdo("select * from uls_assessment_employee_journey where employee_id='".$loguserid['employee_id']."'");
	$emp_journey_unread=UlsMenu::callpdo("select * from uls_assessment_employee_journey where employee_id='".$loguserid['employee_id']."' and status is NULL");
	$emp_journey_inproces=UlsMenu::callpdo("select * from uls_assessment_employee_journey where employee_id='".$loguserid['employee_id']."' and status='I'");
	$emp_journey_com=UlsMenu::callpdo("select * from uls_assessment_employee_journey where employee_id='".$loguserid['employee_id']."'  and status='C'");
	
}
include("menu.php");
$notificationss=$learner_announcementss=$public_announcementss=$apptrans=array();

?>
<!DOCTYPE html>
<html>
<head>
	<!-- META :BEGIN -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<!-- META :END -->

	<meta name="theme-color" content="#0065F2">
	<meta name="msapplication-navbutton-color" content="#0065F2">
	<meta name="apple-mobile-web-app-status-bar-style" content="#0065F2">

	<title>N Compass</title>
	<script>var BASE_URL="<?php echo BASE_URL; ?>";</script>
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/public/new_layout/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/public/new_layout/css/sf-ui-font.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/public/new_layout/css/waves.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/public/new_layout/css/jquery.scrollbar.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/public/new_layout/css/custom.css" />
	
	<link href="<?php echo BASE_URL; ?>/public/styles/layout_style.php?id=<?php echo isset($aboutpage['pagecss'])? $aboutpage['pagecss'] : ""; ?>" rel="stylesheet" type="text/css"/>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>/public/new_layout/js/jquery-3.4.1.min.js"></script>
</head>
<body>
	<header id="header" class="header">
		<div class="container">
			<div class="row">
				<div class="header-panel">
					<nav class="navbar navbar-expand-lg align-items-start">
						<a href="javascript:;" class="mobile-menu"><i class="material-icons">menu</i></a>
						<a href="<?php echo BASE_URL; ?>/admin/profile" class="navbar-brand"><img src="<?php echo BASE_URL; ?>/<?php echo LOGO_IMG; ?>" style="" width="200" height="40"></a>

						<ul class="navbar-nav ml-auto navbar-option">
							<li class="nav-item">
								<a class="nav-link dropdown-toggle" href="javascript:;" id="notification-dropdown" role="button" data-toggle="dropdown" aria-expanded="false" aria-haspopup="true"><i class="material-icons">notifications</i></a>
								<!--<div class="dropdown-menu" aria-labelledby="notification-dropdown">
									<ul class="notification-lists">
										<li class="notification-item">
											<a href="javascript:;" class="notification">
												<div class="name">Accountabilities - Job Description</div>
												<div class="description">To coordinate and carry out various activities...</div>
											</a>
										</li>
										<li class="notification-item">
											<a href="javascript:;" class="notification">
												<div class="name">Cost - Key Result Areas</div>
												<div class="description">Budgeted Cost of R&D vs Actual...</div>
											</a>
										</li>
										<li class="notification-item">
											<a href="javascript:;" class="notification">
												<div class="name">Research & Development - Competencies</div>
												<div class="description">To coordinate and carry out various activities...</div>
											</a>
										</li>
										<li class="notification-item">
											<a href="javascript:;" class="notification">
												<div class="name">Product Development - Key Result Areas</div>
												<div class="description">No. of New Molecules & formulation developed...</div>
											</a>
										</li>
										<li class="notification-item">
											<a href="javascript:;" class="notification">
												<div class="name">Process Improvement - Competencies</div>
												<div class="description">To coordinate and carry out various activities...</div>
											</a>
										</li>
									</ul>
								</div>-->
							</li>
							<li class="nav-item more-option">
								<a class="nav-link" href="javascript:;"><i class="material-icons">more_vert</i></a>
							</li>
							
							<li class="nav-item">
								<a href="<?php echo BASE_URL; ?>/index/logout" class="nav-btn" href="javascript:;"><i class="material-icons">close</i>Logout</a>
							</li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</header>
	<div id="slide-drawer" class="side-nav">
		<div class="main-navbar">

			<ul class="sidenav-items profile-item">
				<li class="nav-item">
					<div class="title">
						<span class="name">Switch Role</span>
					</div>
				</li>
				<?php
				if($loguserid['user_login']==1){
					$Role_id=$this->session->userdata('Role_id');
					if(!empty($Role_id)){
						$role_name=Doctrine_Core::getTable('UlsRoleCreation')->findOneByRole_id($this->session->userdata('Role_id'));
						$role=Doctrine_Query::Create()->from('UlsUserRole a')->leftJoin('a.UlsRoleCreation b')->where("a.user_id=".$this->session->userdata('user_id')." and a.start_date<='".date("Y-m-d")."' and (a.end_date >= '".date("Y-m-d")."' or a.end_date is NULL  or a.end_date = '1970-01-01' or a.end_date = '0000-00-00') ")->setHydrationMode(Doctrine::HYDRATE_ARRAY)->execute();
						foreach($role as $roles){
						?>
							<li class="nav-item">
								<a href="javascript:;" onClick="menus(<?php echo $roles['UlsRoleCreation']['role_id']; ?>,<?php echo $roles['UlsRoleCreation']['menu_id']; ?>)" class="nav-link close-side-nav-menu">
									<span class="flex"><?php echo $logempid->full_name; ?> <b>- <?php echo $roles['UlsRoleCreation']['role_name']; ?></b></span>
								</a>
							</li>
						<?php
						}
					}
				}?>
				
			</ul>

			<hr class="divider">

			<ul class="sidenav-items profile-item">
				<li class="nav-item">
					<div class="title">
						<span class="name">My Account</span>
					</div>
				</li>
				<li class="nav-item">
					<a href="javascript:;" data-toggle="modal" data-target="#pass-rules-modal" class="nav-link close-side-nav-menu">
						<span class="flex">Password Change</span>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?php echo BASE_URL; ?>/index/logout" class="nav-link close-side-nav-menu">
						<span class="flex">Logout</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="modal fade case-modal" id="pass-rules-modal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document" >
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title flex">Change Password</h5>
					<a href="javascript:;" class="close-modal" data-dismiss="modal" aria-label="Close">
						<i class="material-icons">close</i> Close
					</a>
				</div>
				<div class="case-info">
					
				</div>
				<div class="modal-body" >
					<form method="post" name="password" id="password" class="form-horizontal" action="#">
						<div class="form-group"><label class="col-sm-3 control-label">Old Password<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-9"><input type="password" name="oldpassword" value="" id="oldpassword" class="validate[required,minSize[4],maxSize[100],ajax[ajaxPassword]] form-control"></div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">New Password<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-9"><input type="password" name="new_password" value="" id="new_password" class="validate[required,minSize[4],maxSize[100]] form-control"></div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Confirm Password<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-9"><input type="password" name="conpassword" value="" id="conpassword" class="validate[required,minSize[4],maxSize[15],equals[new_password]] form-control"></div>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="form-group">
							<div class="col-sm-offset-9">
								
								<button class="btn btn-primary btn-sm" name="submit_r" id="submit_r" type="submit">Save changes</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<section class="main-section">
		<div class="side-panel-section">
			<div class="user-profile-section selected">
				<div class="user-name dropdown">
					<a href="javascript:;" class="name dropdown-toggle" id="user-profile-dropdown" role="button" data-toggle="dropdown" aria-expanded="false" aria-haspopup="true"><?php echo $logempid->full_name; ?><i class="see-info material-icons">info</i></a>
					<div class="dropdown-menu" aria-labelledby="user-profile-dropdown">
						<div class="user-profile d-flex align-items-center">
							<div class="user-avatar">
								<img src="<?php echo BASE_URL; ?>/public/new_layout/images/user-avatar.png" alt="">
							</div>
							<div class="user flex">
								<div class="name"><?php echo $logempid->full_name; ?> <!-- <a href="" class="edit-profile material-icons">edit</a> --></div>
								<p class="email"><b>Email ID : </b> <?php echo $logempid->email; ?></p>
								<p class="phone"><b>Phone No. : </b> <?php echo $logempid->office_number; ?></p>
								
							</div>
						</div>
						<ul class="user-data">
							<li class="d-flex align-items-center justify-content-between">
								<label class="label">Employee No. :</label>
								<p class="value"><?php echo $logempid->employee_number; ?></p>
							</li>
							<li class="d-flex align-items-center justify-content-between">
								<label class="label">Designation :</label>
								<p class="value">
								<?php 
								
								if(!empty($logempid->position_id)){
								$posdetails=UlsPosition::viewposition($logempid->position_id);
								if($posdetails['position_structure']=='A'){
									$pos_name=UlsPosition::pos_details($posdetails['position_structure_id']);
									$posname=$pos_name['position_name'];
								}
								else{
									$posname=$posdetails['position_name'];
								}
								echo $posname; 
								}?>
								</p>
							</li>
							<li class="d-flex align-items-center justify-content-between">
								<label class="label">Date of Birth :</label>
								<p class="value"><?php echo date('d F Y',strtotime($logempid->date_of_birth)); ?></p>
							</li>
							<li class="d-flex align-items-center justify-content-between">
								<label class="label">Department :</label>
								<p class="value"><?php echo $logempid->org_name; ?></p>
							</li>
							<li class="d-flex align-items-center justify-content-between">
								<label class="label">Reporting to :</label>
								<p class="value"><?php echo $logempid->supname; ?></p>
							</li>
							<li class="d-flex align-items-center justify-content-between">
								<label class="label">Office Location :</label>
								<p class="value"><?php echo $logempid->location_name; ?></p>
							</li>
							<li class="d-flex align-items-center justify-content-between">
								<label class="label">Date of Joining :</label>
								<p class="value"><?php echo date('d F Y',strtotime($logempid->date_of_joining)); ?></p>
							</li>
							<li class="d-flex align-items-center justify-content-between">
								<label class="label">Experience :</label>
								<p class="value"><?php echo $logempid->expericence; ?> years</p>
							</li>
						</ul>
					</div>
				</div>
				<div class="user-email"><b>Email ID : </b> <?php echo $logempid->email; ?></div>
				<div class="user-phone"><b>Phone No. : </b> <?php echo $logempid->office_number; ?></div>
				<!--<div class="user-phone"><b>Reportees. : </b> <a href="<?php echo BASE_URL; ?>/employee/employee_reportees">View</a></div>-->
			</div>
			<!-- TAB SECTION :BEGIN -->
			<div class="side-panel-tab-section">
				<ul class="nav nav-tabs align-items-center justify-content-center" id="myTab" role="tablist">
					<li class="nav-item">
						<a class="nav-link active show" id="all-mail" data-toggle="tab" href="#all-mail-tab" role="tab" aria-selected="true"> <i class="material-icons">check_box</i> All</a>
					</li>
					<!--<li class="nav-item">
						<a class="nav-link" id="unread-mail" data-toggle="tab" href="#unread-mail-tab" role="tab" aria-selected="false"> <i class="material-icons">mail</i> Unread</a>
					</li>-->
					<li class="nav-item">
						<a class="nav-link" id="in-process" data-toggle="tab" href="#in-process-tab" role="tab" aria-selected="false"> <i class="material-icons">loop</i> In-process</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="complete-mail" data-toggle="tab" href="#complete-mail-tab" role="tab" aria-selected="false"> <i class="material-icons">assignment_turned_in</i> Complete</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="unread-mail" data-toggle="tab" href="#unread-mail-tab" role="tab" aria-selected="false"> <i class="material-icons">mail</i> Rate others</a>
					</li>
				</ul>

				<!-- TAB BODY SECTION :BEGIN -->
				<div class="side-panel-tab-content">
					<div class="tab-content">
						<!-- ALL MAIL TAB :BEGIN -->
						<div id="all-mail-tab" class="tab-pane fade show active" role="tabpanel" aria-labelledby="all-mail-tab">
							<!-- MAIL BOX :BEGIN -->
							<ul class="mail-box-list">
							<?php 
							if(count($emp_journey)>0){
								$ass_name='';
								
								foreach($emp_journey as $key=>$emp_journeys){
									$active=($key==0)?"active":"";
									if($emp_journeys['assessment_type']=='positionval'){
										$assprocess=UlsValidationPositions::get_val_position_info_emp($emp_journeys['position_id'],$emp_journeys['val_id']);
										$assname=$assprocess['position_validation_name'];
									}
									else{
										$ass_process=UlsAssessmentPosition::get_assessment_position_info_emp($emp_journeys['position_id'],$emp_journeys['assessment_id']);
										$assname=$ass_process['assessment_name'];
									}
									if($emp_journeys['assessment_type']=='Assessment'){
										$date_s=date("Y-m-d");
										$ass_name="Assessment - Purpose";
										$data_end=$ass_process['end_date'];
										$tni_status=!empty($emp_journeys['tni_status'])?"Completed":"In-process";
										//if($data_end>=$date_s){
											$url="".BASE_URL."/employee/employee_assessment_details?jid=".$emp_journeys['id']."&pro=TEST&asstype=".$ass_process['assessment_type']."&assessment_id=".$ass_process['assessment_id']."&position_id=".$ass_process['position_id']."&assessment_pos_id=".$ass_process['assessment_pos_id'];
										//}
										//else{
											//$url="#";
										//}
										
										$date=date('dS F Y',strtotime($ass_process['end_date']));
									}
									elseif($emp_journeys['assessment_type']=='IDPPROcess'){
										$data_end=$ass_process['end_date'];
										$url="".BASE_URL."/employee/employee_self_assessment?jid=".$emp_journeys['id']."&ass_type=".$ass_process['self_ass_type']."&assessment_id=".$ass_process['assessment_id']."&position_id=".$ass_process['position_id']."&emp_id=".$_SESSION['emp_id']."&assessment_pos_id=".$ass_process['assessment_pos_id'];
										$ass_name="IDP - Purpose";
										$date=date('dS F Y',strtotime($ass_process['end_date']));
									}
									elseif($emp_journeys['assessment_type']=='positionval'){
										$url="".BASE_URL."/employee/employee_pos_validation?jid=".$emp_journeys['id']."&val_id=".$assprocess['val_id']."&position_id=".$assprocess['position_id']."&val_pos_id=".$assprocess['val_pos_id'];
										$ass_name="Position Validation - Purpose";
										$date=date('dS F Y',strtotime($assprocess['end_date']));
									}
									?>
								<li class="mail-box-item">
									<a href="<?php echo $url; ?>" class="mail-box <?php echo $active;?>">
										<div class="d-flex align-items-center">
											<i class="material-icons ml-icon">assignment_turned_in</i>
											<p class="ml-block flex">
												<span class="ml-name"><?php echo $ass_name;?></span>
												<span class="ml-received">Received: <?php echo date('dS F Y',strtotime($emp_journeys['created_date']));?></span>
											</p>
											<?php
											$date_s=date("Y-m-d");
											//if($data_end>=$date_s){
											if($emp_journeys['status']=='C'){
											?>
											<span class="ml-status completed-status">Completed</span>
											<?php	
											}
											elseif($emp_journeys['status']=='I'){
											?>
											<span class="ml-status in-progress-status">In-progress</span>
											<?php	
											}
											else{
											?>
											<span class="ml-status new-status">NEW</span>
											<?php
											}
											/*
											}
											else{
											 ?>
												<span class="ml-status in-progress-status">Locked</span>
											<?php */
											//}
											?>
										</div>
										<div class="mail-title"><?php echo $assname; ?></div>
										<span class="mail-date">Due Date: <?php echo $date; ?></span>
										<!--<span class="mail-date">TNI Status: <b style="color:#3aa9ea;"><?php echo $tni_status; ?></b></span>-->
									</a>
								</li>
							<?php }
							}
							else{
							?>
							<li class="mail-box-item">
								<a href="javascript:;" class="mail-box active">
									<div class="d-flex align-items-center">
										<i class="material-icons ml-icon">assignment_turned_in</i>
										<p class="ml-block flex">
											<span class="ml-name">Assessment - Purpose</span>
											<span class="ml-received"></span>
										</p>
										<span class="ml-status completed-status"></span>
									</div>
									<div class="mail-title">No Assessments have been triggered.</div>
									<span class="mail-date"></span>
								</a>
							</li>
							<?php
							}
							?>
							
							</ul>
							<!-- MAIL BOX :END -->
						</div>
						<!-- ALL MAIL TAB :END -->
						<!-- UNREAD MAIL TAB :BEGIN -->
						<!-- <div id="unread-mail-tab" class="tab-pane fade" role="tabpanel" aria-labelledby="unread-mail-tab">
							MAIL BOX :BEGIN
							<ul class="mail-box-list">
								<?php 
							if(count($emp_journey_unread)>0){
								$ass_name='';
								foreach($emp_journey_unread as $key=>$emp_journey_unreads){
									$active=($key==0)?"active":"";
									if($emp_journey_unreads['assessment_type']=='positionval'){
										$assprocess=UlsValidationPositions::get_val_position_info_emp($emp_journey_unreads['position_id'],$emp_journey_unreads['val_id']);
										$assname=$assprocess['position_validation_name'];
									}
									else{
										$ass_process=UlsAssessmentPosition::get_assessment_position_info_emp($emp_journey_unreads['position_id'],$emp_journey_unreads['assessment_id']);
										$assname=$ass_process['assessment_name'];
									}
									if($emp_journey_unreads['assessment_type']=='Assessment'){
										$ass_name="Assessment - Purpose";
										$url="employee_assessment_details?jid=".$emp_journeys['id']."&pro=TEST&asstype=".$ass_process['assessment_type']."&assessment_id=".$ass_process['assessment_id']."&position_id=".$ass_process['position_id']."&assessment_pos_id=".$ass_process['assessment_pos_id'];
										$date=date('dS F Y',strtotime($ass_process['end_date']));
									}
									elseif($emp_journey_unreads['assessment_type']=='IDPPROcess'){
										$url="employee_self_assessment?jid=".$emp_journeys['id']."&ass_type=".$ass_process['self_ass_type']."&assessment_id=".$ass_process['assessment_id']."&position_id=".$ass_process['position_id']."&emp_id=".$_SESSION['emp_id']."&assessment_pos_id=".$ass_process['assessment_pos_id'];
										$ass_name="IDP - Purpose";
										$date=date('dS F Y',strtotime($ass_process['end_date']));
									}
									elseif($emp_journey_unreads['assessment_type']=='positionval'){
										$url="employee_pos_validation?jid=".$emp_journeys['id']."&val_id=".$assprocess['val_id']."&position_id=".$assprocess['position_id']."&val_pos_id=".$assprocess['val_pos_id'];
										$ass_name="Position Validation - Purpose";
										$date=date('dS F Y',strtotime($assprocess['end_date']));
									}
									?>
								<li class="mail-box-item">
									<a href="<?php echo BASE_URL; ?>/employee/<?php echo $url; ?>" class="mail-box <?php echo $active;?>">
										<div class="d-flex align-items-center">
											<i class="material-icons ml-icon">assignment_turned_in</i>
											<p class="ml-block flex">
												<span class="ml-name"><?php echo $ass_name;?></span>
												<span class="ml-received">Received: <?php echo date('dS F Y',strtotime($emp_journey_unreads['created_date']));?></span>
											</p>
											<span class="ml-status new-status">NEW</span>
										</div>
										<div class="mail-title"><?php echo $assname; ?></div>
										<span class="mail-date">Due Date: <?php echo $date; ?></span>
									</a>
								</li>
							<?php }
							}
							?>	
							</ul>
							MAIL BOX :END 
						</div>-->
						<!-- UNREAD MAIL TAB :END -->
						<!-- IN PROCESS TAB :BEGIN -->
						<div id="in-process-tab" class="tab-pane fade" role="tabpanel" aria-labelledby="in-process-tab">
							<!-- MAIL BOX :BEGIN -->
							<ul class="mail-box-list">
								<?php 
							if(count($emp_journey_inproces)>0){
								$ass_name='';
								foreach($emp_journey_inproces as $key=>$emp_journey_inprocess){
									$active=($key==0)?"active":"";
									if($emp_journey_inprocess['assessment_type']=='positionval'){
										$assprocess=UlsValidationPositions::get_val_position_info_emp($emp_journey_inprocess['position_id'],$emp_journey_inprocess['val_id']);
										$assname=$assprocess['position_validation_name'];
									}
									else{
										$ass_process=UlsAssessmentPosition::get_assessment_position_info_emp($emp_journey_inprocess['position_id'],$emp_journey_inprocess['assessment_id']);
										$assname=$ass_process['assessment_name'];
									}
									if($emp_journey_inprocess['assessment_type']=='Assessment'){
										$date_s=date("Y-m-d");
										$ass_name="Assessment - Purpose";
										$data_end=$ass_process['end_date'];
										$ass_name="Assessment - Purpose";
										$url="employee_assessment_details?jid=".$emp_journeys['id']."&pro=TEST&asstype=".$ass_process['assessment_type']."&assessment_id=".$ass_process['assessment_id']."&position_id=".$ass_process['position_id']."&assessment_pos_id=".$ass_process['assessment_pos_id'];
										$date=date('dS F Y',strtotime($ass_process['end_date']));
									}
									elseif($emp_journey_inprocess['assessment_type']=='IDPPROcess'){
										$url="employee_self_assessment?jid=".$emp_journeys['id']."&ass_type=".$ass_process['self_ass_type']."&assessment_id=".$ass_process['assessment_id']."&position_id=".$ass_process['position_id']."&emp_id=".$_SESSION['emp_id']."&assessment_pos_id=".$ass_process['assessment_pos_id'];
										$ass_name="IDP - Purpose";
										$date=date('dS F Y',strtotime($ass_process['end_date']));
									}
									elseif($emp_journey_inprocess['assessment_type']=='positionval'){
										$url="employee_pos_validation?jid=".$emp_journeys['id']."&val_id=".$assprocess['val_id']."&position_id=".$assprocess['position_id']."&val_pos_id=".$assprocess['val_pos_id'];
										$ass_name="Position Validation - Purpose";
										$date=date('dS F Y',strtotime($assprocess['end_date']));
									}
									?>
								<li class="mail-box-item">
									<a href="<?php echo BASE_URL; ?>/employee/<?php echo $url; ?>" class="mail-box <?php echo $active;?>">
										<div class="d-flex align-items-center">
											<i class="material-icons ml-icon">assignment_turned_in</i>
											<p class="ml-block flex">
												<span class="ml-name"><?php echo $ass_name;?></span>
												<span class="ml-received">Received: <?php echo date('dS F Y',strtotime($emp_journey_inprocess['created_date']));?></span>
											</p>
											<span class="ml-status in-progress-status">In-progress</span>
										</div>
										<div class="mail-title"><?php echo $assname; ?></div>
										<span class="mail-date">Due Date: <?php echo $date; ?></span>
									</a>
								</li>
							<?php }
							}
							?>	
							</ul>
							<!-- MAIL BOX :END -->
						</div>
						<!-- IN PROCESS TAB :END -->
						<!-- COMPLETE MAIL TAB :BEGIN -->
						<div id="complete-mail-tab" class="tab-pane fade" role="tabpanel" aria-labelledby="complete-mail-tab">
							<!-- MAIL BOX :BEGIN -->
							<ul class="mail-box-list">
								<?php 
							if(count($emp_journey_com)>0){
								$ass_name='';
								foreach($emp_journey_com as $key=>$emp_journey_coms){
									$active=($key==0)?"active":"";
									if($emp_journey_coms['assessment_type']=='positionval'){
										$assprocess=UlsValidationPositions::get_val_position_info_emp($emp_journey_coms['position_id'],$emp_journey_coms['val_id']);
										$assname=$assprocess['position_validation_name'];
									}
									else{
										$ass_process=UlsAssessmentPosition::get_assessment_position_info_emp($emp_journey_coms['position_id'],$emp_journey_coms['assessment_id']);
										$assname=$ass_process['assessment_name'];
									}
									if($emp_journey_coms['assessment_type']=='Assessment'){
										$ass_name="Assessment - Purpose";
										$url="employee_assessment_details?jid=".$emp_journeys['id']."&pro=TEST&asstype=".$ass_process['assessment_type']."&assessment_id=".$ass_process['assessment_id']."&position_id=".$ass_process['position_id']."&assessment_pos_id=".$ass_process['assessment_pos_id'];
										$date=date('dS F Y',strtotime($ass_process['end_date']));
									}
									elseif($emp_journey_coms['assessment_type']=='IDPPROcess'){
										$url="employee_self_assessment?jid=".$emp_journeys['id']."&ass_type=".$ass_process['self_ass_type']."&assessment_id=".$ass_process['assessment_id']."&position_id=".$ass_process['position_id']."&emp_id=".$_SESSION['emp_id']."&assessment_pos_id=".$ass_process['assessment_pos_id'];
										$ass_name="IDP - Purpose";
										$date=date('dS F Y',strtotime($ass_process['end_date']));
									}
									elseif($emp_journey_coms['assessment_type']=='positionval'){
										$url="employee_pos_validation?jid=".$emp_journeys['id']."&val_id=".$assprocess['val_id']."&position_id=".$assprocess['position_id']."&val_pos_id=".$assprocess['val_pos_id'];
										$ass_name="Position Validation - Purpose";
										$date=date('dS F Y',strtotime($assprocess['end_date']));
									}
									?>
								<li class="mail-box-item">
									<a href="<?php echo BASE_URL; ?>/employee/<?php echo $url; ?>" class="mail-box <?php echo $active;?>">
										<div class="d-flex align-items-center">
											<i class="material-icons ml-icon">assignment_turned_in</i>
											<p class="ml-block flex">
												<span class="ml-name"><?php echo $ass_name;?></span>
												<span class="ml-received">Received: <?php echo date('dS F Y',strtotime($emp_journey_coms['created_date']));?></span>
											</p>
											<span class="ml-status completed-status">Completed</span>
										</div>
										<div class="mail-title"><?php echo $assname; ?></div>
										<span class="mail-date">Due Date: <?php echo $date; ?></span>
									</a>
								</li>
							<?php }
							}
							else{
							?>
							<li class="mail-box-item">
								<a href="javascript:;" class="mail-box active">
									<div class="d-flex align-items-center">
										<i class="material-icons ml-icon">assignment_turned_in</i>
										<p class="ml-block flex">
											<span class="ml-name">Assessment - Purpose</span>
											<span class="ml-received">Date: <?php echo date('dS F Y',strtotime(date("Y-m-d")));?></span>
										</p>
										<span class="ml-status completed-status">Completed</span>
									</div>
									<div class="mail-title">No Assessments are in complete state.</div>
									<span class="mail-date">Due Date: <?php echo date('dS F Y',strtotime(date("Y-m-d")));?></span>
								</a>
							</li>
							<?php
							}
							?>	
							</ul>
							<!-- MAIL BOX :END -->
						</div>
						<!-- COMPLETE MAIL TAB :END -->
						<div id="unread-mail-tab" class="tab-pane fade" role="tabpanel" aria-labelledby="unread-mail-tab">
							
							<ul class="mail-box-list">
								<li class="mail-box-item">
									<a href="<?php echo BASE_URL; ?>/employee/feedback_rating" class="mail-box active">
										<div class="d-flex align-items-center">
											<i class="material-icons ml-icon">assignment_turned_in</i>
											<p class="ml-block flex">
												<span class="ml-name">360 Degree Feedback Process</span>
												<span class="ml-received">Received: <?php echo date('dS F Y');?></span>
											</p>
											<span class="ml-status new-status">NEW</span>
										</div>
									</a>
								</li>
							
							</ul>
						</div>
					</div>
				</div>
				<!-- TAB BODY SECTION :END -->
			</div>
			<!-- TAB SECTION :END -->
		</div>
		<?=$content;?>
	</section>
	
	<script type="text/javascript" src="<?php echo BASE_URL; ?>/public/new_layout/js/popper.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>/public/new_layout/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>/public/new_layout/js/waves.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>/public/new_layout/js/jquery.scrollbar.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>/public/new_layout/js/custom.js"></script>
	<script src="<?php echo BASE_URL; ?>/public/js/alljs.js"></script>
	<script src="<?php echo BASE_URL; ?>/public/js/validate/jquery.validationEngine.js"></script>
	<?php
$jsfiles=isset($aboutpage['pagejs']) ? explode(",",$aboutpage['pagejs']): "";
if(is_array($jsfiles)){
	foreach($jsfiles as $js){
		if(!empty($js)){ ?>
		<script type="text/javascript" src="<?php echo BASE_URL;?>/public/js/<?php echo $js; ?>"></script>
<?php } } } ?>
<script>
$(document).ready(function(){
	$('#password').validationEngine();
});
</script>
</body>
</html>