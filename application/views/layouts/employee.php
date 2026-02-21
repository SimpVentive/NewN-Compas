<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Page title -->
	<title>Competency Management System</title>
	<script>var BASE_URL="<?php echo BASE_URL; ?>";</script>
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
   
    <!-- Vendor styles -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/vendor/bootstrap/dist/css/bootstrap.css" />
    <!-- App styles -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/style.css">
	<link href="<?php echo BASE_URL; ?>/public/styles/layout_style.php?id=<?php echo isset($aboutpage['pagecss'])? $aboutpage['pagecss'] : ""; ?>" rel="stylesheet" type="text/css"/>
</head>
<body class="fixed-small-header fixed-navbar sidebar-scroll">

<div id="header">
    <div class="color-line"></div>
    <div id="logo" class="light-version">
         <span>N-Compas</span><br>
		<small class="text-muted">Competency management System</small>
    </div>
    <nav role="navigation">
        <div class="header-link hide-menu"><i class="fa fa-bars"></i></div>
        <div class="small-logo">
            <span class="text-primary">Competency management System</span>
        </div>
        <!--<form role="search" class="navbar-form-custom" method="post" action="#">
            <div class="form-group">
                <input type="text" placeholder="Search something special" class="form-control" name="search">
            </div>
        </form>-->
        <div class="mobile-menu">
            <button type="button" class="navbar-toggle mobile-menu-toggle" data-toggle="collapse" data-target="#mobile-collapse">
                <i class="fa fa-chevron-down"></i>
            </button>
            <div class="collapse mobile-navbar" id="mobile-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a class="" href="<?php echo BASE_URL; ?>/secure/login">Login</a>
                    </li>
                    <li>
                        <a class="" href="<?php echo BASE_URL; ?>/secure/logout">Logout</a>
                    </li>
                    <li>
                        <a class="" href="<?php echo BASE_URL; ?>/secure/profile">Profile</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="navbar-right">
            <ul class="nav navbar-nav no-borders">
                <li class="dropdown">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <i class="pe-7s-speaker"></i>
                    </a>
                    <ul class="dropdown-menu hdropdown notification animated flipInX">
                        <li>
                            <a>
                                <span class="label label-success">NEW</span> It is a long established.
                            </a>
                        </li>
                        <li>
                            <a>
                                <span class="label label-warning">WAR</span> There are many variations.
                            </a>
                        </li>
                        <li>
                            <a>
                                <span class="label label-danger">ERR</span> Contrary to popular belief.
                            </a>
                        </li>
                        <li class="summary"><a href="#">See all notifications</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <i class="pe-7s-keypad"></i>
                    </a>

                    <div class="dropdown-menu hdropdown bigmenu animated flipInX">
                        <table>
                            <tbody>
                            <tr>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>/admin/dashboard">
                                        <i class="pe pe-7s-filter text-info"></i>
                                        <h4>Admin</h4>
                                    </a>
                                </td>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>/admin/dashboard">
                                        <i class="pe pe-7s-network text-warning"></i>
                                        <h4>Assessor</h4>
                                    </a>
                                </td>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>/employee/profile">
                                        <i class="pe pe-7s-users text-success"></i>
                                        <h4>Employee</h4>
                                    </a>
                                </td>
                            </tr>
                            
                            </tbody>
                        </table>
                    </div>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle label-menu-corner" href="#" data-toggle="dropdown">
                        <i class="pe-7s-mail"></i>
                        <span class="label label-success">4</span>
                    </a>
                    <ul class="dropdown-menu hdropdown animated flipInX">
                        <div class="title">
                            You have 4 new messages
                        </div>
                        <li>
                            <a>
                                It is a long established.
                            </a>
                        </li>
                        <li>
                            <a>
                                There are many variations.
                            </a>
                        </li>
                        <li>
                            <a>
                                Lorem Ipsum is simply dummy.
                            </a>
                        </li>
                        <li>
                            <a>
                                Contrary to popular belief.
                            </a>
                        </li>
                        <li class="summary"><a href="#">See All Messages</a></li>
                    </ul>
                </li>
                
                <li class="dropdown">
                    <a href="<?php echo BASE_URL; ?>/secure/logout">
                        <i class="pe-7s-upload pe-rotate-90"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>

<!-- Navigation -->
<aside id="menu">
    <div id="navigation">
        <div class="profile-picture">
            <a href="index.html">
                <img src="<?php echo BASE_URL; ?>/public/images/profile.jpg" class="img-circle m-b" alt="logo">
            </a>

            <div class="stats-label text-color">
                <span class="font-extra-bold font-uppercase">UniTol</span>

                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <small class="text-muted">CEO <b class="caret"></b></small>
                    </a>
                    <ul class="dropdown-menu animated flipInX m-t-xs">
                        <li><a href="<?php echo BASE_URL; ?>/employee/profile">Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo BASE_URL; ?>/secure/logout">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
		<ul class="nav" id="side-menu">
            <li class="active">
                <a href="<?php echo BASE_URL; ?>/employee/profile"> <span class="nav-label">Profile</span>  </a>
            </li>
            <li>
                <a href="<?php echo BASE_URL; ?>/employee/employee_assessment"><span class="nav-label">Assessments</span></a>
            </li>
           
            <li>
                <a href="#"><span class="nav-label">Development Roadmap</span>
            </li>
        </ul>
    
        
	</div>
</aside>

<!-- Main Wrapper -->
<div id="wrapper">

	<?=$content;?>	

<footer class="footer">
	<span class="pull-right">
		Copyright © 2015.UniTol Training Solutions Private Limited. All rights reserved.
	</span>
</footer>

</div>

<!-- Vendor scripts -->
<script src="<?php echo BASE_URL; ?>/public/vendor/jquery/dist/jquery.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/vendor/iCheck/icheck.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/vendor/sparkline/index.js"></script>
<!-- App scripts -->
<script src="<?php echo BASE_URL; ?>/public/scripts/homer.js"></script>
<?php
$jsfiles=isset($aboutpage['pagejs']) ? explode(",",$aboutpage['pagejs']): "";
if(is_array($jsfiles)){
	foreach($jsfiles as $js){
		if(!empty($js)){ ?>
		<script type="text/javascript" src="<?php echo BASE_URL;?>/public/js/<?php echo $js; ?>"></script>
		<?php } } } ?>	
</body>

</html>