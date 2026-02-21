<!DOCTYPE html>
<html>

<!-- Mirrored from webapplayers.com/homer_admin-v2.0/landing_page.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 16 Aug 2017 06:53:14 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title>Competency Management System</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/vendor/bootstrap/dist/css/bootstrap.css" />

    <!-- App styles -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/style.css">

</head>
<body class="landing-page">

<style>
.landing-page header{
	height:550px;
}
.landing-page .heading-image {
    /*position: absolute;
    right: 100px;
    top: 80px;*/
    text-align: left;
    width: 300px;
}

.landing-page .heading-image1 {
    position: absolute;
    left: 15px;
    text-align: left;
    top: 160px;
}
.landing-page .heading-image1 img {
    border-radius: 1px;
    box-shadow: 0 0 8px 0 #333;
    margin-left: 12px;
    margin-top: 12px;
    width: 180px;
}
</style>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
			<!--<img class="img-animate" src="<?php echo BASE_URL; ?>/public/images/landing/logo1.png">-->
			<ul class="nav navbar-nav navbar-left">
                <li class="active"><a class="page-scroll" href="#page-top"><b style='padding-left: 60px;font-size:30px;'><span style='color:#c0392b;'>N</span>-Compas</b></a></li>
            </ul>
			
			
			

        </div>
        <!--<div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="active"><a class="page-scroll" href="#page-top">Competency Management System</a></li>
            </ul>
        </div>-->
    </div>
</nav>

<header id="page-top">
	<div>
        <!-- Jssor Slider Begin -->

        <style>
            /* jssor slider loading skin spin css */
            .jssorl-009-spin img {
                animation-name: jssorl-009-spin;
                animation-duration: 1.6s;
                animation-iteration-count: infinite;
                animation-timing-function: linear;
            }

            @keyframes jssorl-009-spin {
                from {
                    transform: rotate(0deg);
                }

                to {
                    transform: rotate(360deg);
                }
            }
        </style>
        <div id="slider1_container" style="visibility: hidden; position: relative; margin: 0 auto;
        top: 0px; left: 0px; width: 1300px; height: 430px; overflow: hidden;">
            <!-- Loading Screen -->
            <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
                <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="../svg/loading/static-svg/spin.svg" />
            </div>

            <!-- Slides Container -->
            <div u="slides" style="position: absolute; left: 0px; top: 0px; width: 1300px; height: 430px; overflow: hidden;">
                <div>
                    <img data-u="image" src="<?php echo BASE_URL; ?>/public/images/slider/001.jpg" />
                </div>
                <!--<div>
                    <img data-u="image" src="<?php echo BASE_URL; ?>/public/images/slider/002.jpg" />
                </div>
                <div>
                    <img data-u="image" src="<?php echo BASE_URL; ?>/public/images/slider/003.jpg" />
                </div>-->
            </div>

            <!--#region Bullet Navigator Skin Begin -->
            <!-- Help: https://www.jssor.com/development/slider-with-bullet-navigator.html -->
            <style>
                .jssorb031 {position:absolute;}
                .jssorb031 .i {position:absolute;cursor:pointer;}
                .jssorb031 .i .b {fill:#000;fill-opacity:0.5;stroke:#fff;stroke-width:1200;stroke-miterlimit:10;stroke-opacity:0.3;}
                .jssorb031 .i:hover .b {fill:#fff;fill-opacity:.7;stroke:#000;stroke-opacity:.5;}
                .jssorb031 .iav .b {fill:#fff;stroke:#000;fill-opacity:1;}
                .jssorb031 .i.idn {opacity:.3;}
            </style>
            <div data-u="navigator" class="jssorb031" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
                <div data-u="prototype" class="i" style="width:16px;height:16px;">
                    <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                        <circle class="b" cx="8000" cy="8000" r="5800"></circle>
                    </svg>
                </div>
            </div>
            <!--#endregion Bullet Navigator Skin End -->

            <!--#region Arrow Navigator Skin Begin -->
            <!-- Help: https://www.jssor.com/development/slider-with-arrow-navigator.html -->
            <style>
                .jssora051 {display:block;position:absolute;cursor:pointer;}
                .jssora051 .a {fill:none;stroke:#fff;stroke-width:360;stroke-miterlimit:10;}
                .jssora051:hover {opacity:.8;}
                .jssora051.jssora051dn {opacity:.5;}
                .jssora051.jssora051ds {opacity:.3;pointer-events:none;}
            </style>
            <div data-u="arrowleft" class="jssora051" style="width:55px;height:55px;top:0px;left:25px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
                <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                    <polyline class="a" points="11040,1920 4960,8000 11040,14080 "></polyline>
                </svg>
            </div>
            <div data-u="arrowright" class="jssora051" style="width:55px;height:55px;top:0px;right:25px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
                <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                    <polyline class="a" points="4960,1920 11040,8000 4960,14080 "></polyline>
                </svg>
            </div>
            <!--#endregion Arrow Navigator Skin End -->
        </div>
        <!-- Jssor Slider End -->
    </div>


        <div class="heading-image animate-panel" >
            <div class="login-container">
				<div class="row">
					<div class="col-md-12">

						<div class="hpanel">
							<div class="panel-body">
								<?=$content;?>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>

</header>


<section id="features2" class="bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-12">
                <h2> <strong>Competency Framework</strong></h2>
				<p>N-Compas helps organizations to create and manage all aspects of the pre-assessment process</p>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-md-4">
                <h4 class="m-t-lg"><i class="fa fa-newspaper-o text-success icon-big"></i></h4>
                <strong>Job Description & Profile</strong>
                <p>A templated methodology to capture JD and all the key elements therein</p>
            </div>
            <?php /*<div class="col-md-3">
                <h4 class="m-t-lg"><i class="fa fa-id-card-o text-success icon-big"></i></h4>
                <strong>Competency Profile</strong>
                <p>Link the Role and the KRA to the the competency levels</p>
            </div> */ ?>
            <div class="col-md-4">
                <h4 class="m-t-lg"><i class="fa fa-exclamation-triangle text-success icon-big"></i></h4>
                <strong>Competency Model</strong>
                <p>Create multi level Competency Model (covering functional, managerial & behavioural)  </p>
            </div>
            <div class="col-md-4">
                <h4 class="m-t-lg"><i class="fa fa-book text-success icon-big"></i></h4>
                <strong>Competency Dictionary</strong>
                <p>Create, store, edit and enable access to competency dictionary for assessment & development</p>
            </div>

        </div><br>
		<div class="row text-center">
            <div class="col-lg-12">
                <h2><strong>Competency Assessment</strong></h2>
				<p>At the heart of the Competency management process is the assessment.  Using N-Compas, you can create multiple assessment methods </p>
            </div>
        </div>
        <div class="row text-center">
            <?php /*<div class="col-md-3">
                <h4 class="m-t-lg"><i class="fa fa-sitemap text-success icon-big"></i></h4>
                <strong>Competency Dictionary</strong>
                <p>Enable work flows between internal and external teams for creating Competency Dictonary</p>
            </div> */ ?>
            <div class="col-md-3">
                <h4 class="m-t-lg"><i class="fa fa-list-alt text-success icon-big"></i></h4>
                <strong>MCQ</strong>
                <p>Create Comprehensive Test repository based on competency and competency levels</p>
            </div>
            <div class="col-md-3">
                <h4 class="m-t-lg"><i class="fa fa-search text-success icon-big"></i></h4>
                <strong>Case lets/studies</strong>
                <p>Create or upload or link to case studies for assessment</p>
            </div>
            <div class="col-md-3">
                <h4 class="m-t-lg"><i class="fa fa-inbox text-success icon-big"></i></h4>
                <strong>In Basket/In Tray</strong>
                <p>Prepare and link In Tray exercises to assessment process </p>
            </div>
			<div class="col-md-3">
                <h4 class="m-t-lg"><i class="fa fa-handshake-o text-success icon-big"></i></h4>
                <strong>BEI</strong>
                <p>Provision to create, capture and store Behavioural Event Interview (BEI) </p>
            </div>
        </div><br>
		<div class="row text-center">
            <div class="col-lg-12">
                <h2><strong>Competency Development</strong></h2>
				<p>As an organization investing significant amount of time and energy on the Assessment Process, benefits can only acrue when the development  management post the assessment process is managed appropriately.  N-Compas enables you consequence management of the post assessment process </p>
            </div>
        </div>
		<?php /*<div class="row text-center">
            <div class="col-md-3">
                <h4 class="m-t-lg"><i class="fa fa-street-view text-success icon-big"></i></h4>
                <strong>Multi Rater Feedback</strong>
                <p>Customize, initiate and enable web and mobile based mutl rater feedback</p>
            </div>
            
            <div class="col-md-3">
                <h4 class="m-t-lg"><i class="pe-7s-users text-success icon-big"></i></h4>
                <strong>Self, Manager, Self+Manager</strong>
                <p>Depending on your specific needs, enable self, boss or self_boss rating </p>
            </div>
            <div class="col-md-3">
                <h4 class="m-t-lg"><i class="fa fa-user-secret text-success icon-big"></i></h4>
                <strong>Expert Panel</strong>
                <p>Identify, store and allocate experts for your assessment & development process</p>
            </div>
        </div> */ ?>
		<div class="row text-center">
            
            <div class="col-md-4">
                <h4 class="m-t-lg"><i class="fa fa-pie-chart text-success icon-big"></i></h4>
                <strong>Development Reports</strong>
                <p>Generate comprehensive assessment reports </p>
            </div>
            <div class="col-md-4">
                <h4 class="m-t-lg"><i class="fa fa-road text-success icon-big"></i></h4>
                <strong>Development Roadmaps</strong>
                <p>Develop, assign, review and monitor individual development road maps</p>
            </div>
			<div class="col-md-4">
                <h4 class="m-t-lg"><i class="fa fa-sticky-note-o text-success icon-big"></i></h4>
                <strong>TNA </strong>
                <p>Training Need Analysis</p>
            </div>

        </div>
    </div>
</section>



<section id="contact" class="bg-light" style="padding:0px;">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-8 col-md-offset-3">
                <h5>Copyright © 2015.UniTol Training Solutions Private Limited. All rights reserved.</h5>
            </div>
        </div>
    </div>
</section>

<!-- Vendor scripts -->
<script type="text/javascript" src="<?php echo BASE_URL; ?>/public/js/jssor.slider.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/vendor/jquery/dist/jquery.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/vendor/iCheck/icheck.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/vendor/sparkline/index.js"></script>

<!-- App scripts -->
<script src="<?php echo BASE_URL; ?>/public/scripts/homer.js"></script>

<!-- Local script for menu handle -->
<!-- It can be also directive -->
<script>
    $(document).ready(function () {

        // Page scrolling feature
        $('a.page-scroll').bind('click', function(event) {
            var link = $(this);
            $('html, body').stop().animate({
                scrollTop: $(link.attr('href')).offset().top - 50
            }, 500);
            event.preventDefault();
        });

        $('body').scrollspy({
            target: '.navbar-fixed-top',
            offset: 80
        });

    });
</script>
<script>

        jQuery(document).ready(function ($) {
            var options = {
                $AutoPlay: 1,                                       //[Optional] Auto play or not, to enable slideshow, this option must be set to greater than 0. Default value is 0. 0: no auto play, 1: continuously, 2: stop at last slide, 4: stop on click, 8: stop on user navigation (by arrow/bullet/thumbnail/drag/arrow key navigation)
                $AutoPlaySteps: 1,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $Idle: 2000,                                        //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                                   //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1

                $ArrowKeyNavigation: 1,   			            //[Optional] Steps to go for each navigation request by pressing arrow key, default value is 1.
                $SlideEasing: $Jease$.$OutQuint,                    //[Optional] Specifies easing for right to left animation, default value is $Jease$.$OutQuad
                $SlideDuration: 800,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide, default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 0, 					                //[Optional] Space between each slide in pixels, default value is 0
                $Cols: 1,                                           //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $Align: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 1,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $Cols is greater than 1, or parking position is not 0)

                $ArrowNavigatorOptions: {                           //[Optional] Options to specify and enable arrow navigator or not
                    $Class: $JssorArrowNavigator$,                  //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                },

                $BulletNavigatorOptions: {                                //[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$,                       //[Required] Class to create navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Rows: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 12,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 4,                                   //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1                                 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                }
            };

            var jssor_slider1 = new $JssorSlider$("slider1_container", options);

            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizing
            /* function ScaleSlider() {
                var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
                if (parentWidth) {
                    jssor_slider1.$ScaleWidth(parentWidth - 30);
                }
                else
                    window.setTimeout(ScaleSlider, 30);
            } */
			function ScaleSlider() {
                var bodyWidth = document.body.clientWidth;
                if (bodyWidth)
                    jssor_slider1.$ScaleWidth(Math.min(bodyWidth, 1920));
                else
                    window.setTimeout(ScaleSlider, 30);
            }
            ScaleSlider();

            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
            //responsive code end
        });
    </script>
</body>

<!-- Mirrored from webapplayers.com/homer_admin-v2.0/landing_page.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 16 Aug 2017 06:53:39 GMT -->
</html>
