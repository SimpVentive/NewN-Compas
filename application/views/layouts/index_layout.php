<!DOCTYPE html>
<html>
<style>.need-to-discuss{background:#324349;position:relative}.need-to-discuss.bg-img{background:url(public/home/images/what-we-offer/need-discuss-bg.jpg) no-repeat center top / cover}.need-to-discuss.bg-img:after{width:100%;height:100%;display:block;background:#699882;background:-moz-linear-gradient(45deg,#699882 0,#708f99 100%);background:-webkit-linear-gradient(45deg,#699882 0,#708f99 100%);background:linear-gradient(45deg,#699882 0,#708f99 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#699882',endColorstr='#708f99',GradientType=1);content:"";position:absolute;left:0;top:0;opacity:.8;z-index:1}.need-to-discuss.bg-img .container{position:relative;z-index:2}.need-to-discuss .head-block{text-align:center;padding-bottom:60px}.need-to-discuss h2{padding:10px 0 20px;color:#fff}.need-to-discuss P{color:#000;opacity:10}.need-to-discuss .submit-form{padding-bottom:16px}/*.need-to-discuss .submit-form input{width:100%;background:0;border:0;border-bottom:1px #516167 solid;color:#9fb4bc;font-size:12px;padding:0 0 9px 0;margin:0 0 55px;text-transform:uppercase}.need-to-discuss .submit-form input{border-color:rgba(255,255,255,0.4)}.need-to-discuss .submit-form ::-webkit-input-placeholder{color:#000;opacity:2.5}.need-to-discuss .submit-form ::-moz-placeholder{color:#fff;opacity:.5}.need-to-discuss .submit-form :-ms-input-placeholder{color:#fff;opacity:.5}.need-to-discuss .submit-form :-moz-placeholder{color:#fff;opacity:.5}.need-to-discuss .submit-form input:focus{color:#fff;border-color:currentcolor currentcolor #fff}*/.need-to-discuss .submit-form .submit-btn{width:175px;margin:0 auto;background:#f29a32;border:0;border-radius:3px;color:#fff;cursor:pointer;font-size:14px;line-height:48px;text-align:center;font-weight:700;padding:0 15px;display:block;text-transform:uppercase;transition:all .3s ease 0s}.need-to-discuss .submit-form .submit-btn:hover{background:#57bce2}.portfolio-img1 img{border:0;margin:0 auto}.portfolio-img1:hover{-webkit-transform:scale(1.2);-moz-transform:scale(1.2);-o-transform:scale(1.2);transform:scale(1.2);transition:all .3s;-webkit-transition:all .3s}.portfolio-img img{border:0;margin:0 auto}.portfolio-img:hover{-webkit-transform:scale(1.6);-moz-transform:scale(1.6);-o-transform:scale(1.6);transform:scale(1.6);transition:all .3s;-webkit-transition:all .3s}</style>
<head>
<meta charset=utf-8>
<meta name=viewport content="width=device-width, initial-scale=1.0">
<meta http-equiv=X-UA-Compatible content="IE=edge">
<title>Competency Management System</title>
<script>var BASE_URL="<?php echo BASE_URL; ?>";</script>
<link rel="shortcut icon" type=image/x-icon href=favicon.ico>
<link href="<?php echo BASE_URL; ?>/public/home/css/google_css.css" rel=stylesheet>
<link rel=stylesheet href="<?php echo BASE_URL; ?>/public/home/css/font-awesome.min.css">
<link rel=stylesheet href="<?php echo BASE_URL; ?>/public/home/css/animate.css">
<link rel=stylesheet href="<?php echo BASE_URL; ?>/public/home/css/lightcase.css">
<link rel=stylesheet href="<?php echo BASE_URL; ?>/public/home/css/owl.carousel.min.css">
<link rel=stylesheet href="<?php echo BASE_URL; ?>/public/home/css/bootstrap.css">
<link rel=stylesheet href="<?php echo BASE_URL; ?>/public/home/css/styles.css">
<link rel=stylesheet href="<?php echo BASE_URL; ?>/public/home/css/colors/pink.css">
<link rel=stylesheet href="<?php echo BASE_URL; ?>/public/styles/validationEngine.jquery.css">
<link rel=stylesheet id=color href="<?php echo BASE_URL; ?>/public/home/css/default.css">
<link href="<?php echo BASE_URL; ?>/public/styles/layout_style_new.php?id=<?php echo isset($aboutpage['pagecss'])? $aboutpage['pagecss'] : ""; ?>" rel="stylesheet" type="text/css"/>
</head>
<body class=inner-pages>
<div class="header head-3">
<div class="header-bottom heading header-2 sticky-header" id=heading>
<div class=container>
<a href="<?php echo BASE_URL; ?>" class=logo>
<img src="<?php echo BASE_URL; ?>/public/home/images/ncompas.svg" alt=NCompaslogo>
</a>
<!--<h2 style=font-size:2.1em;padding-top:11px><span>-Compas</span></h2>-->
<button type=button class="button-menu hidden-lg-up collapsed" data-toggle=collapse data-target=#main-menu aria-expanded=false>
<i class="fa fa-bars" aria-hidden=true></i>
</button>
<nav id=main-menu class=collapse>
<ul>
<li><a <?php if(strstr($_SERVER['REQUEST_URI'],'index/features') || strstr($_SERVER['REQUEST_URI'],'index/consulting') || strstr($_SERVER['REQUEST_URI'],'index/customisedcms') || strstr($_SERVER['REQUEST_URI'],'index/login') || strstr($_SERVER['REQUEST_URI'],'index/aboutus')){ echo ""; }else{ echo "class='active'";} ?> href="<?php echo BASE_URL; ?>">Home</a></li>
<li><a <?php if(strstr($_SERVER['REQUEST_URI'],'index/features')){ echo "class='active'"; } ?> href="<?php echo BASE_URL; ?>/index/features">Features</a></li>
<li><a <?php if(strstr($_SERVER['REQUEST_URI'],'index/consulting')){ echo "class='active'"; } ?> href="<?php echo BASE_URL; ?>/index/consulting">Consulting</a></li>
<li><a <?php if(strstr($_SERVER['REQUEST_URI'],'index/customisedcms')){ echo "class='active'"; } ?> href="<?php echo BASE_URL; ?>/index/customisedcms">Customized CMS</a></li>
<li><a <?php if(strstr($_SERVER['REQUEST_URI'],'index/aboutus')){ echo "class='active'"; } ?> href="<?php echo BASE_URL; ?>/index/aboutus">About us</a></li>
<li><a href="<?php echo BASE_URL; ?>#contact">Contact Us</a></li>
<li><a <?php if(strstr($_SERVER['REQUEST_URI'],'index/login')){ echo "class='active'"; } ?> href="<?php echo BASE_URL; ?>/index/login">login </a></li>
</ul>
</nav>
</div>
</div>
</div>
<?=$content;?>
<footer class=second-footer>
<div class=container>
<div class="col-lg-2 col-md-3">
<div class=row>
<img src="<?php echo BASE_URL; ?>/public/home/images/ncompas.svg" alt=NCompaslogo  style="width:150px;height:60px">
</div>
</div>
<div class="col-lg-6 col-md-3" style=padding-left:0;float:left>
<p>Copyright © <?php echo date('Y'); ?>.HeadNorth Talent Solutions. - All Rights Reserved.</br>
Secunderabad, India -500 026.</p>
</div>
<div class="col-lg-2 col-md-3">
<p><a href="<?php echo BASE_URL; ?>/index/termsofuse" style=color:#fff>Terms of Services </a></p>
</div>
<div class="col-lg-2 col-md-3">
<p><a href="<?php echo BASE_URL; ?>/index/privacypolicy" style=color:#fff>Privacy Policy</a> </p>
</div>
</div>
</footer>
<a data-scroll href=#heading class=go-up><i class="fa fa-angle-double-up" aria-hidden=true></i></a>
<div id=preloader>
<div id=status>
<div class=status-mes></div>
</div>
</div>
<script src="<?php echo BASE_URL; ?>/public/home/js/jquery.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/home/js/tether.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/home/js/transition.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/home/js/bootstrap.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/home/js/imagesloaded.pkgd.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/home/js/smooth-scroll.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/home/js/lightcase.js"></script>
<script src="<?php echo BASE_URL; ?>/public/home/js/owl.carousel.js"></script>
<script src="<?php echo BASE_URL; ?>/public/home/js/jquery.themepunch.tools.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/home/js/jquery.themepunch.revolution.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/home/js/revolution.extension.actions.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/home/js/revolution.extension.carousel.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/home/js/revolution.extension.kenburn.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/home/js/revolution.extension.layeranimation.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/home/js/revolution.extension.navigation.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/home/js/revolution.extension.parallax.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/home/js/revolution.extension.slideanims.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/home/js/revolution.extension.video.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/home/js/script.js"></script>
<script src="<?php echo BASE_URL; ?>/public/js/alljs.js"></script>
<script src="<?php echo BASE_URL; ?>/public/js/validate/jquery.validationEngine.js"></script>
<script>$(document).ready(function(){$('a.page-scroll').bind('click',function(event){var link=$(this);$('html, body').stop().animate({scrollTop:$(link.attr('href')).offset().top-50},500);event.preventDefault();});$('body').scrollspy({target:'.navbar-fixed-top',offset:80});});
$(document).ready(function(){
	$("#pre_master").validationEngine();	
});
</script>
</body>
</html>