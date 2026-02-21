<?php
$loguserid=UlsUserCreation::user_info($this->session->userdata('user_id'));
if(!empty($loguserid['employee_id'])){
	$logempid=UlsMenu::callpdoobjrow("select a.*,m.full_name as supname from employee_data a left join(SELECT `employee_number`,`full_name` FROM `employee_data` ) m on m.employee_number=a.hod where a.employee_id='".$loguserid['employee_id']."'");
	
	$emp_journey=UlsMenu::callpdo("select * from uls_assessment_employee_journey where employee_id='".$loguserid['employee_id']."'");
	
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
	<?php /*<script src="<?php echo BASE_URL;?>/public/newlayout/dist/js/jquery-ui.min.js"></script>*/ ?>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>/public/new_layout/js/jquery-3.4.1.min.js"></script>
</head>
<body>
	<header id="header" class="header">
		<div class="container">
			<div class="row">
				<div class="header-panel">
					<nav class="navbar navbar-expand-lg align-items-start">
						<a href="<?php echo BASE_URL; ?>/admin/profile" class="navbar-brand"><img src="<?php echo BASE_URL; ?>/<?php echo LOGO_IMG; ?>" style="margin:0.0cm 0.2cm;float:right;" width="176" height="50"></a>

						<ul class="navbar-nav ml-auto navbar-option">
							<!--<li class="nav-item">
								<a class="nav-link" href="javascript:;"><i class="material-icons">notifications</i></a>
							</li>
							<li class="nav-item more-option">
								<a class="nav-link" href="javascript:;" class="name dropdown-toggle" id="user-profile-dropdown" role="button" data-toggle="dropdown" aria-expanded="false" aria-haspopup="true"><i class="material-icons">more_vert</i></a>
								<div class="dropdown-menu" aria-labelledby="user-profile-dropdown">
									<div class="user-profile d-flex align-items-center">
										
										<div class="user flex">
											
											<?php
											if($loguserid['user_login']==1){
												$Role_id=$this->session->userdata('Role_id');
												if(!empty($Role_id)){
													$role_name=Doctrine_Core::getTable('UlsRoleCreation')->findOneByRole_id($this->session->userdata('Role_id'));
													$role=Doctrine_Query::Create()->from('UlsUserRole a')->leftJoin('a.UlsRoleCreation b')->where("a.user_id=".$this->session->userdata('user_id')." and a.start_date<='".date("Y-m-d")."' and (a.end_date >= '".date("Y-m-d")."' or a.end_date is NULL  or a.end_date = '1970-01-01' or a.end_date = '0000-00-00') ")->setHydrationMode(Doctrine::HYDRATE_ARRAY)->execute();
													foreach($role as $roles){
													?>
															<a href="#" onClick="menus(<?php echo $roles['UlsRoleCreation']['role_id']; ?>,<?php echo $roles['UlsRoleCreation']['menu_id']; ?>)">
																<div class="chat-data">
																	
																<div class="user-data">
																	<span class="name block capitalize-font"><?php echo $roles['UlsRoleCreation']['role_name']; ?></span>
																</div>
																<div class="clearfix"></div>
																</div>
															</a>
													<?php
													}
												}
											} ?>
										</div>
									</div>
									
								</div>
							</li>
							
							<li class="nav-item">
								<a href="<?php echo BASE_URL; ?>/index/logout" class="nav-btn" href="javascript:;"><i class="material-icons">close</i>Quit</a>
							</li>-->
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</header>
	
	<?=$content;?>
	
	<script type="text/javascript" src="<?php echo BASE_URL; ?>/public/new_layout/js/popper.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>/public/new_layout/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>/public/new_layout/js/waves.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>/public/new_layout/js/jquery.scrollbar.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>/public/new_layout/js/jquery.sortable.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>/public/new_layout/js/custom.js"></script>
	<script src="<?php echo BASE_URL; ?>/public/js/alljs.js"></script>
	<script src="<?php echo BASE_URL; ?>/public/js/validate/jquery.validationEngine.js"></script>
	<?php
	if(strstr($_SERVER['REQUEST_URI'],'employee/employee_fishbone_details')){?>
		<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
		
	<?php 
	}?>
	
	<?php
$jsfiles=isset($aboutpage['pagejs']) ? explode(",",$aboutpage['pagejs']): "";
if(is_array($jsfiles)){
	foreach($jsfiles as $js){
		if(!empty($js)){ ?>
		<script type="text/javascript" src="<?php echo BASE_URL;?>/public/js/<?php echo $js; ?>"></script>
<?php } } } ?>
</body>
</html>