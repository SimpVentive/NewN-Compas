<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8>
<meta name=viewport content="width=device-width, initial-scale=1.0">
<meta http-equiv=X-UA-Compatible content="IE=edge">
<title>Competency Management System</title>
<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
<!--<link rel="shortcut icon" type="image/ico" href="<?php echo BASE_URL; ?>/favicon.ico" />-->
<link rel=stylesheet href="<?php echo BASE_URL; ?>/public/vendor/fontawesome/css/font-awesome.css" />
<link rel=stylesheet href="<?php echo BASE_URL; ?>/public/vendor/metisMenu/dist/metisMenu.css" />
<link rel=stylesheet href="<?php echo BASE_URL; ?>/public/vendor/animate.css/animate.css" />
<link rel=stylesheet href="<?php echo BASE_URL; ?>/public/vendor/bootstrap/dist/css/bootstrap.css" />
<link rel=stylesheet href="<?php echo BASE_URL; ?>/public/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
<link rel=stylesheet href="<?php echo BASE_URL; ?>/public/fonts/pe-icon-7-stroke/css/helper.css" />
<link rel=stylesheet href="<?php echo BASE_URL; ?>/public/styles/style.css">
</head>
<body class=blank>
<style>.color-line{background:#f7f9fa linear-gradient(to right,#62cb31 45%,#62cb31 55%) no-repeat scroll 50% 100% / 100% 10px;height:10px}.color-line2{background:#f7f9fa linear-gradient(to right,#62cb31 45%,#62cb31 55%) no-repeat scroll 50% 100% / 100% 50px;height:50px;margin-top:70px}</style>
<div class=color-line></div>
<div class=back-link>
<ul class="nav navbar-nav navbar-left">
<li class=active><a class=page-scroll href=#page-top><b style=padding-left:60px;font-size:30px><span style=color:#c0392b>N</span>-Compas</b></a></li>
</ul>
<img src="<?php echo BASE_URL; ?>/public/home/images/coromandel_logo.gif" alt=logo align=right style=padding-right:10px>
</div>
<div class=login-container>
<div class=row>
<div class=col-md-12>
<div class="text-center m-b-md">
<h3>&nbsp;</h3>
<small>&nbsp;</small>
</div>
<div class=hpanel>
<div class=panel-body>
<?=$content;?>
</div>
</div>
</div>
</div>
<div class=row>
<div class="col-md-12 text-center">
&nbsp;
</div>
</div>
</div>
<div class=color-line2>
<div class=row>
<div class="col-md-12 text-center">
<p style=color:#fff>Copyright Â© <?php echo date('Y'); ?>.UniTol Training Solutions Private Limited.<br/> All rights reserved.</p>
</div>
</div>
</div>
<script type=text/javascript src="<?php echo BASE_URL; ?>/public/js/jssor.slider.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/vendor/jquery/dist/jquery.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/vendor/iCheck/icheck.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/vendor/sparkline/index.js"></script>
<script src="<?php echo BASE_URL; ?>/public/scripts/homer.js"></script>
<script>$(document).ready(function(){$('a.page-scroll').bind('click',function(event){var link=$(this);$('html, body').stop().animate({scrollTop:$(link.attr('href')).offset().top-50},500);event.preventDefault();});$('body').scrollspy({target:'.navbar-fixed-top',offset:80});});</script>
<script>jQuery(document).ready(function($){var options={$AutoPlay:1,$AutoPlaySteps:1,$Idle:2000,$PauseOnHover:1,$ArrowKeyNavigation:1,$SlideEasing:$Jease$.$OutQuint,$SlideDuration:800,$MinDragOffsetToSlide:20,$SlideSpacing:0,$Cols:1,$Align:0,$UISearchMode:1,$PlayOrientation:1,$DragOrientation:1,$ArrowNavigatorOptions:{$Class:$JssorArrowNavigator$,$ChanceToShow:2,$Steps:1},$BulletNavigatorOptions:{$Class:$JssorBulletNavigator$,$ChanceToShow:2,$Steps:1,$Rows:1,$SpacingX:12,$SpacingY:4,$Orientation:1}};var jssor_slider1=new $JssorSlider$("slider1_container",options);function ScaleSlider(){var bodyWidth=document.body.clientWidth;if(bodyWidth)
jssor_slider1.$ScaleWidth(Math.min(bodyWidth,1920));else
window.setTimeout(ScaleSlider,30);}
ScaleSlider();$(window).bind("load",ScaleSlider);$(window).bind("resize",ScaleSlider);$(window).bind("orientationchange",ScaleSlider);});</script>
</body>
</html>