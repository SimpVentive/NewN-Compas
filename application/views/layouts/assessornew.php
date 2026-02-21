<?php
$loguserid=UlsUserCreation::user_info($this->session->userdata('user_id'));
if(!empty($loguserid['assessor_id'])){
	$logempid=UlsMenu::callpdoobjrow("select * from uls_assessor_master where assessor_id='".$loguserid['assessor_id']."'");
}
include("menu.php");
$notificationss=$learner_announcementss=$public_announcementss=$apptrans=array();
if(!empty($loguserid['assessor_id'])){
$notificationss=UlsNotificationHistory::get_notification();
//$learner_announcementss=UlsAdminAnnouncements::get_profile_announcements();
//$public_announcementss=UlsAdminAnnouncements::get_profile_announcements_public();
//$apptrans=UlsWfTransactionApprover::searchapprovercount_dashboard();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>Competency Management System</title>
	<script>var BASE_URL="<?php echo BASE_URL; ?>";</script>
	<!-- Favicon -->
	<link rel="shortcut icon" href="favicon.ico">
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	
	<!-- Data table CSS -->
	<link href="<?php echo BASE_URL;?>/public/newlayout/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
	
	<!-- Toast CSS -->
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/vendor/toastr/build/toastr.min.css" />
	<link href="<?php echo BASE_URL;?>/public/newlayout/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css" rel="stylesheet" type="text/css">
	<!--alerts CSS -->
	<link href="<?php echo BASE_URL;?>/public/newlayout/vendors/bower_components/sweetalert/dist/sweetalert.css" rel="stylesheet" type="text/css">
	<link href="<?php echo BASE_URL;?>/public/newlayout/vendors/bower_components/nestable2/jquery.nestable.css" rel="stylesheet" type="text/css" />
	<!-- Custom CSS -->
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/chosen.css" />
	<link href="<?php echo BASE_URL;?>/public/newlayout/dist/css/style.css" rel="stylesheet" type="text/css">
	<link href="<?php echo BASE_URL; ?>/public/styles/layout_style.php?id=<?php echo isset($aboutpage['pagecss'])? $aboutpage['pagecss'] : ""; ?>" rel="stylesheet" type="text/css"/>
	 <script src="<?php echo BASE_URL;?>/public/newlayout/vendors/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="<?php echo BASE_URL;?>/public/newlayout/dist/js/jquery-ui.min.js"></script>
</head>

<body>
	<!-- Preloader -->
	<div class="preloader-it">
		<div class="la-anim-1"></div>
	</div>
	<!-- /Preloader -->
    <div class="wrapper theme-5-active pimary-color-blue slide-nav-toggle">
		<!-- Top Menu Items -->
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="mobile-only-brand pull-left">
				<div class="nav-header pull-left">
					<div class="logo-wrap">
						<a href="#">
							<img class="brand-img" src="<?php echo BASE_URL; ?>/public/home/images/ncompas.svg" alt="brand" style="width: 53%;"/>
							<!--<span class="brand-text">-Compas</span>-->
						</a>
					</div>
				</div>
				<a id="toggle_nav_btn" class="toggle-left-nav-btn inline-block ml-20 pull-left" href="javascript:void(0);"><i class="zmdi zmdi-menu"></i></a>
				<a id="toggle_mobile_search" data-toggle="collapse" data-target="#search_form" class="mobile-only-view" href="javascript:void(0);"><i class="zmdi zmdi-search"></i></a>
				<a id="toggle_mobile_nav" class="mobile-only-view" href="javascript:void(0);"><i class="zmdi zmdi-more"></i></a>
			</div>
			<div id="mobile_only_nav" class="mobile-only-nav pull-right">
				<ul class="nav navbar-right top-nav pull-right">
					<li>
						<a id="open_right_sidebar" href="#"><i class="fa fa-users top-nav-icon"></i></a>
					</li>
					
					<li class="dropdown auth-drp">
						<a href="#" class="dropdown-toggle pr-0" data-toggle="dropdown"><img src="<?php echo BASE_URL;?>/public/newlayout/img/user1.png" alt="user_auth" class="user-auth-img img-circle"/><span class="user-online-status"></span></a>
						<ul class="dropdown-menu user-auth-dropdown" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">						
							<li>
								<a href="<?php echo BASE_URL; ?>/admin/profile"><i class="zmdi zmdi-account"></i><span>Profile</span></a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="<?php echo BASE_URL; ?>/index/logout"><i class="zmdi zmdi-power"></i><span>Log Out</span></a>
							</li>
						</ul>
					</li>
				</ul>
			</div>	
		</nav>
		<!-- /Top Menu Items -->
		
		<!-- Left Sidebar Menu -->
		<div class="fixed-sidebar-left">
					<?php
		if($loguserid['user_login']==1){
			$Role_id=$this->session->userdata('Role_id');
			if(!empty($Role_id)){
				$role_name=Doctrine_Core::getTable('UlsRoleCreation')->findOneByRole_id($this->session->userdata('Role_id'));
				?>
		<ul class="nav navbar-nav side-nav nicescroll-bar" id="side-menu">
			<li class="navigation-header btn-info">
				<span><?php echo $role_name->role_name;?></span>
				<i class="zmdi zmdi-more"></i>
			</li>
			<?php
			$id=$this->session->userdata('Role_id');
			$roles=Doctrine_Query::Create()->select("b.menu_id as menuid,b.role_name as rolename,a.*")->from('UlsUserRole a,UlsRoleCreation b')->where("a.role_id=b.role_id and a.user_id=".$this->session->userdata('user_id')." and b.role_id=".$id." and a.start_date<='".date("Y-m-d")."'  and (a.end_date >= '".date("Y-m-d")."' or a.end_date is NULL or a.end_date = '1970-01-01' or a.end_date = '0000-00-00')")->setHydrationMode(Doctrine::HYDRATE_ARRAY)->execute();
			foreach($roles as $role){
				$home=$role['rolename'];
				echo UlsMenu::display_children2(0,0,$role['menuid'],$role['menu_id'],$men);
			}
			if($role_name->report_group_id<>0){
			?>
            <li>
                <a onclick="link('/report/reportgeneration')" href="<?php echo BASE_URL; ?>/report/reportgeneration"><div class='pull-left'><i class='zmdi zmdi-book mr-20'></i><span class='right-nav-text'>Reports</span></div><div class='clearfix'></div></a>
            </li>
            <?php } ?>
        </ul>
		<?php
			}
			else{
				?>
			<ul class="nav navbar-nav side-nav nicescroll-bar" id="side-menu">
				<?php
				$role=Doctrine_Query::Create()->from('UlsUserRole a')->leftJoin('a.UlsRoleCreation b')->where("a.user_id=".$this->session->userdata('user_id'))->setHydrationMode(Doctrine::HYDRATE_ARRAY)->execute();
					foreach($role as $roles){ ?>
					<li><a href="#" onClick="menus(<?php echo $roles['UlsRoleCreation']['role_id']; ?>,<?php echo $roles['UlsRoleCreation']['menu_id']; ?>)"><?php echo $roles['UlsRoleCreation']['role_name']; ?></a></li>
					<?php } ?>
			</ul>
		<?php
			}
		}
		else{
			echo "<ul class='nav navbar-nav side-nav nicescroll-bar' id='side-menu'></ul>";
		}
		?>
		</div>
		<!-- /Left Sidebar Menu -->
		
		<!-- Right Sidebar Menu -->
		<div class="fixed-sidebar-right">
			<ul class="right-sidebar">
				<li>
					<div  class="tab-struct custom-tab-1">
						<h6 style="text-align:center">Switch&nbsp;Role</h6>
						<div class="tab-content" id="right_sidebar_content">
							<div  id="switchrole" class="tab-pane fade active in" role="tabpanel">
								<div class="chat-cmplt-wrap">
									<div class="chat-box-wrap">										
										<div id="chat_list_scroll">
											<div class="nicescroll-bar">
												<ul class="chat-list-wrap">
													<li class="chat-list">
														<div class="chat-body">
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
																					<img class="user-img img-circle"  src="<?php echo BASE_URL;?>/public/images/male_user.jpg" alt="user"/>
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
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</li>
			</ul>
		</div>
		<!-- /Right Sidebar Menu -->
		
		<!-- Right Setting Menu -->
		<div class="setting-panel">
			<ul class="right-sidebar nicescroll-bar pa-0">
				<li class="layout-switcher-wrap">
					<ul>
						<li>
							<span class="layout-title">Scrollable header</span>
							<span class="layout-switcher">
								<input type="checkbox" id="switch_3" class="js-switch"  data-color="#0FC5BB" data-secondary-color="#dedede" data-size="small"/>
							</span>	
							<h6 class="mt-30 mb-15">Theme colors</h6>
							<ul class="theme-option-wrap">
								<li id="theme-1"><i class="zmdi zmdi-check"></i></li>
								<li id="theme-2"><i class="zmdi zmdi-check"></i></li>
								<li id="theme-3"><i class="zmdi zmdi-check"></i></li>
								<li id="theme-4"><i class="zmdi zmdi-check"></i></li>
								<li id="theme-5" class="active-theme"><i class="zmdi zmdi-check"></i></li>
								<li id="theme-6"><i class="zmdi zmdi-check"></i></li>
							</ul>
							<h6 class="mt-30 mb-15">Primary color Settings</h6>
							<div class="radio mb-5">
								<input type="radio" name="radio-primary-color" id="pimary-color-green" value="pimary-color-green">
								<label for="pimary-color-green"> Green </label>
							</div>
							<div class="radio mb-5">
								<input type="radio" name="radio-primary-color" id="pimary-color-red" value="pimary-color-red">
								<label for="pimary-color-red"> Red </label>
							</div>
							<div class="radio mb-5">
								<input type="radio" name="radio-primary-color" id="pimary-color-blue" checked value="pimary-color-blue">
								<label for="pimary-color-blue"> Blue </label>
							</div>
							<div class="radio mb-5">
								<input type="radio" name="radio-primary-color" id="pimary-color-yellow" value="pimary-color-yellow">
								<label for="pimary-color-yellow"> Yellow </label>
							</div>
							<div class="radio mb-5">
								<input type="radio" name="radio-primary-color" id="pimary-color-pink" value="pimary-color-pink">
								<label for="pimary-color-pink"> Pink </label>
							</div>
							<div class="radio mb-5">
								<input type="radio" name="radio-primary-color" id="pimary-color-orange" value="pimary-color-orange">
								<label for="pimary-color-orange"> Orange </label>
							</div>
							<div class="radio mb-5">
								<input type="radio" name="radio-primary-color" id="pimary-color-gold" value="pimary-color-gold">
								<label for="pimary-color-gold"> Gold </label>
							</div>
							<div class="radio mb-35">
								<input type="radio" name="radio-primary-color" id="pimary-color-silver" value="pimary-color-silver">
								<label for="pimary-color-silver"> Silver </label>
							</div>
							<button id="reset_setting" class="btn  btn-primary btn-xs btn-outline btn-rounded mb-10">reset</button>
						</li>
					</ul>
				</li>
			</ul>
		</div>
		<button id="setting_panel_btn" class="btn btn-primary btn-circle setting-panel-btn shadow-2dp"><i class="zmdi zmdi-settings"></i></button>
		<!-- /Right Setting Menu -->
		
		<!-- Right Sidebar Backdrop -->
		<div class="right-sidebar-backdrop"></div>
		<!-- /Right Sidebar Backdrop -->

        <!-- Main Content -->
		<div class="page-wrapper">
            <div class="container-fluid">
				<div class="row heading-bg">
					<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
						<h5 class="txt-dark"><?php echo @ucfirst($aboutpage['pagetitle']); ?></h5>
					</div>
					<!-- Breadcrumb -->
					<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">						
						<?php
							$home1=isset($home)?$home:"";
							if(strpos($_REQUEST['rt'],"min/dashboard")==0){
								$breadcrum=UlsMenu::display_parent_nodes("/".$men,$home1);
									 $_SESSION['breadcrum']=$breadcrum;
									 $breadcrums=explode("**",$breadcrum);
									 echo "<ol class='breadcrumb'>";
									 foreach($breadcrums as $kb=>$yb){
										echo "<li><span>$yb</span></li>";
									 }
									  echo "</ol>";
							}
							else{
								echo "<ol class='breadcrumb'><li><span><a>".$home1."</a> </span></li><li><span>dashboard</span></li></ol>";
							}
						?>
					</div>
					<!-- /Breadcrumb -->
				</div>
				<!-- Row -->
				<div class="row">
				<?=$content;?>
				</div>
				<!-- /Row -->
			</div>
			
			<!-- Footer -->
			<footer class="footer container-fluid pl-30 pr-30">
				<div class="row">
					<div class="col-sm-12">
						<p>Copyright © <?php echo date('Y'); ?>.UniTol Training Solutions Private Limited. All rights reserved.</p>
					</div>
				</div>
			</footer>
			<!-- /Footer -->
			
		</div>
        <!-- /Main Content -->

    </div>
    <!-- /#wrapper -->
	
	<!-- JavaScript -->
	
    <!-- jQuery -->
   

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo BASE_URL;?>/public/newlayout/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    
	<!-- Data table JavaScript -->
	<script src="<?php echo BASE_URL;?>/public/newlayout/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
	
	<!-- Slimscroll JavaScript -->
	<script src="<?php echo BASE_URL;?>/public/newlayout/dist/js/jquery.slimscroll.js"></script>
	
	<!-- simpleWeather JavaScript -->
	<script src="<?php echo BASE_URL;?>/public/newlayout/vendors/bower_components/moment/min/moment.min.js"></script>
	<script src="<?php echo BASE_URL;?>/public/newlayout/vendors/bower_components/simpleWeather/jquery.simpleWeather.min.js"></script>
	<script src="<?php echo BASE_URL;?>/public/newlayout/dist/js/simpleweather-data.js"></script>
	
	<!-- Progressbar Animation JavaScript -->
	<script src="<?php echo BASE_URL;?>/public/newlayout/vendors/bower_components/waypoints/lib/jquery.waypoints.min.js"></script>
	<script src="<?php echo BASE_URL;?>/public/newlayout/vendors/bower_components/jquery.counterup/jquery.counterup.min.js"></script>
	
	<!-- Fancy Dropdown JS -->
	<script src="<?php echo BASE_URL;?>/public/newlayout/dist/js/dropdown-bootstrap-extended.js"></script>
	
	<!-- Sparkline JavaScript -->
	<script src="<?php echo BASE_URL;?>/public/newlayout/vendors/jquery.sparkline/dist/jquery.sparkline.min.js"></script>
	
	<!-- Owl JavaScript -->
	<script src="<?php echo BASE_URL;?>/public/newlayout/vendors/bower_components/owl.carousel/dist/owl.carousel.min.js"></script>
	
	<!-- Toast JavaScript -->
	<script src="<?php echo BASE_URL; ?>/public/vendor/toastr/build/toastr.min.js"></script>
	<script src="<?php echo BASE_URL;?>/public/newlayout/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js"></script>

	
	<!-- Sweet-Alert  -->
	<script src="<?php echo BASE_URL;?>/public/newlayout/vendors/bower_components/sweetalert/dist/sweetalert.min.js"></script>
	
	<!-- EChartJS JavaScript -->
	<script src="<?php echo BASE_URL;?>/public/newlayout/vendors/bower_components/echarts/dist/echarts-en.min.js"></script>
	<script src="<?php echo BASE_URL;?>/public/newlayout/vendors/echarts-liquidfill.min.js"></script>
	
	<!-- Switchery JavaScript -->
	<script src="<?php echo BASE_URL;?>/public/newlayout/vendors/bower_components/switchery/dist/switchery.min.js"></script>
	<script src="<?php echo BASE_URL;?>/public/newlayout/vendors/bower_components/nestable2/jquery.nestable.js"></script>
	<!-- Init JavaScript -->
	<script src="<?php echo BASE_URL;?>/public/newlayout/dist/js/init.js"></script>
	<script src="<?php echo BASE_URL;?>/public/newlayout/dist/js/dashboard5-data.js"></script>
	<script src="<?php echo BASE_URL; ?>/public/js/chosen.jquery.js"></script>
	<script src="<?php echo BASE_URL; ?>/public/js/alljs.js"></script>
	<script src="<?php echo BASE_URL; ?>/public/js/validate/jquery.validationEngine.js"></script>
	<script src="<?php echo BASE_URL; ?>/public/vendor/nestable/jquery.nestable.js"></script>
	<!-- Sweet-Alert  -->
	<script src="<?php echo BASE_URL;?>/public/newlayout/vendors/bower_components/sweetalert/dist/sweetalert.min.js"></script>
<script>

    $(function () {

        var updateOutput = function (e) {
            var list = e.length ? e : $(e.target),
                    output = list.data('output');
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
            } else {
                output.val('JSON browser support required for this demo.');
            }
        };


        // output initial serialised data


    });

</script>

 <script>
		$(function(){

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $('a[data-toggle="tab"]').removeClass('btn-primary');
            //$('a[data-toggle="tab"]').addClass('');
            //$(this).removeClass('btn-default');
            $(this).addClass('btn-primary');
        })

        $('.next').click(function(){
            var nextId = $(this).parents('.tab-pane').next().attr("id");
            $('[href=#'+nextId+']').tab('show');
        })

        $('.prev').click(function(){
            var prevId = $(this).parents('.tab-pane').prev().attr("id");
            $('[href=#'+prevId+']').tab('show');
        })

		toastr.options = {
            "debug": false,
            "newestOnTop": false,
            "positionClass": "toast-top-center",
            "closeButton": true,
            "toastClass": "animated fadeInDown",
			"preventDuplicates":true,
        };

    });
	/* $(function () {
        // Initialize summernote plugin
        //$('.summernote').summernote();

        $('.summernote1').summernote({
            toolbar: [
                ['headline', ['style']],
                ['style', ['bold', 'italic', 'underline', 'superscript', 'subscript', 'strikethrough', 'clear']],
                ['textsize', ['fontsize']],
                ['alignment', ['ul', 'ol', 'paragraph', 'lineheight']],
            ]
        });

	
		
		$('.summernote').summernote({
			height: 230,
			minHeight: null,
			maxHeight: null,
			focus: false,
			callbacks: {
				onImageUpload: function(files, editor, welEditable) {
					for (var i = files.length - 1; i >= 0; i--) {
						sendFile(files[i], this);
					}
				},
			},
			dialogsFade: true,
			fontNames: ['Roboto Light', 'Roboto Regular', 'Roboto Bold'],
			toolbar: [
			['fontname', ['fontname']],
			['fontsize', ['fontsize']],
			['font', ['style','bold', 'italic', 'underline', 'clear']],
			['color', ['color']],
			['para', ['ul', 'ol', 'paragraph']],
			['height', ['height']],
			['table', ['table']],
			['insert', ['picture','link']],
			['view', ['fullscreen', 'codeview']],
			['misc', ['undo','redo']]
			]
		});

    }); */
$(function () {
	
	//$(".js-source-states-2").select2();
});
$('#side-menu .nav li.active').each(function() {
	$(this).parents().addClass('active');
	//$(this).parent().find("ul").parent().find("li.dropdown").addClass('open');
	//$(this).parents().find('li.hsub').addClass('active open');
});
function sendFile(file, el) {
var form_data = new FormData();
form_data.append('file', file);
$.ajax({
data: form_data,
type: "POST",
url: BASE_URL+'/admin/saveuploadedfile',
cache: false,
contentType: false,
enctype: 'multipart/form-data',
processData: false,
success: function(url) {
$(el).summernote('editor.insertImage', url);
}
});
}
</script>
<?php
$jsfiles=isset($aboutpage['pagejs']) ? explode(",",$aboutpage['pagejs']): "";
if(is_array($jsfiles)){
	foreach($jsfiles as $js){
		if(!empty($js)){ ?>
		<script type="text/javascript" src="<?php echo BASE_URL;?>/public/js/<?php echo $js; ?>"></script>
		<?php } } } ?>

<?php 
if(isset($employees) && count($employees)>0){
	$k=0;
	foreach($employees as $key=>$employee){
		if(!empty($assessor['emp_display'])){
			if($assessor['emp_display']=='N'){
				$emp_name="Employee ".($key+1);
			}
			else{
				$emp_name=$employee['full_name'];
			}
		}
		$empname=str_replace(array(" ","."),array("_","@"),trim($emp_name));
		if($k==0){
			echo "<script>";
			echo "getemployeeassessment(".$position_id.",".$employee['employee_id'].",".$assessment_id.",'".$empname."')";
			echo "</script>";
		}
		$k++;
	}
}
 ?>
</body>

</html>
