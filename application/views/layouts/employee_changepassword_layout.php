<?php
$loguserid=UlsUserCreation::user_info($this->session->userdata('user_id'));

include("menu.php");
$notificationss=$learner_announcementss=$public_announcementss=$apptrans=array();

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<!-- META :BEGIN -->
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
						<a href="#" class="navbar-brand"><img src="<?php echo BASE_URL; ?>/<?php echo LOGO_IMG; ?>" style="margin:0.0cm 0.2cm;float:right;" width="" height="50"></a>

						<ul class="navbar-nav ml-auto navbar-option">
							
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