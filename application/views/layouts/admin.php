<?php
$loguserid=UlsUserCreation::user_info($this->session->userdata('user_id'));
if(!empty($loguserid['employee_id'])){
	$logempid=UlsMenu::callpdoobjrow("select * from uls_employee_master where employee_id='".$loguserid['employee_id']."'");
}
include("menu.php");
$notificationss=$learner_announcementss=$public_announcementss=$apptrans=array();
if(!empty($loguserid['employee_id'])){
$notificationss=UlsNotificationHistory::get_notification();
//$learner_announcementss=UlsAdminAnnouncements::get_profile_announcements();
//$public_announcementss=UlsAdminAnnouncements::get_profile_announcements_public();
//$apptrans=UlsWfTransactionApprover::searchapprovercount_dashboard();
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Page title -->
	<title>Competency Management System</title>
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="<?php echo BASE_URL; ?>/favicon.ico" />-->
    <!-- Vendor styles -->
	<script>var BASE_URL="<?php echo BASE_URL; ?>";</script>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/vendor/bootstrap/dist/css/bootstrap.css" />
     <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/vendor/bootstrap-datepicker-master/dist/css/bootstrap-datepicker3.min.css" />
    <!-- App styles -->
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/vendor/sweetalert/lib/sweet-alert.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/vendor/toastr/build/toastr.min.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/fonts/pe-icon-7-stroke/css/helper.css" />
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/vendor/summernote/dist/summernote.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/vendor/summernote/dist/summernote-bs3.css" />
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/vendor/select2-3.5.2/select2.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/vendor/select2-bootstrap/select2-bootstrap.css" />
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/chosen.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/public/datatable/css/datatables.min.css">
	<link href="<?php echo BASE_URL; ?>/public/styles/layout_style.php?id=<?php echo isset($aboutpage['pagecss'])? $aboutpage['pagecss'] : ""; ?>" rel="stylesheet" type="text/css"/>
	<script src="<?php echo BASE_URL; ?>/public/vendor/jquery/dist/jquery.min.js"></script>
</head>
<body class="fixed-small-header fixed-navbar sidebar-scroll">
<!--[if lt IE 7]>
<p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<!-- Header -->
<div id="header">
    <div class="color-line"></div>
    <div id="logo" class="light-version">
        <span>N-Compas</span><br>
		<small class="text-muted">Competency Management System</small>
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
                        <a class="" href="<?php echo BASE_URL; ?>/index/logout">Logout</a>
                    </li>
                    <li>
                        <a class="" href="<?php echo BASE_URL; ?>/admin/profile">Profile</a>
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
						<?php
						if(count($public_announcementss)>0){
							$email_s="SELECT * FROM `employee_data` where status='A' and employee_status='C' and employee_id=".$this->session->userdata('emp_id')." and parent_org_id=".$this->session->userdata('parent_org_id');
							$emplist=UlsMenu::callpdorow($email_s);
							foreach($public_announcementss as $public_announcementsss){
								if($public_announcementsss['publish_type']=='secure'){
									$lerneracces=Doctrine_Query::Create()->from("UlsAnnouncementInclusions")->where("announcement_id=".$public_announcementsss['announcement_id'])->execute();
									$sq=$sq2="";
									$emp_id="";
									if(count($lerneracces)>0){
										foreach($lerneracces as $pro){
											$zone=str_replace(",","','",$pro['location_zones']);
											$emp_ty=str_replace(",","','",$pro['emp_type']);
											$emp_cat=str_replace(",","','",$pro['emp_cat']);
											if((empty($pro['location_zones']) or ($pro['location_zones']==$emplist['zone_id'])) and (empty($pro['location_id']) or ($pro['location_id']==$emplist['location_id'])) and (empty($pro['bu_id']) or ($pro['bu_id']==$emplist['bu_id'])) and (empty($pro['division_id']) or ($pro['division_id']==$emplist['division_id'])) and (empty($pro['depart_id']) or ($pro['depart_id']==$emplist['org_id'])) and (empty($pro['grade_id']) or ($pro['grade_id']==$emplist['grade_id'])) and (empty($emp_ty) or ($emp_ty==$emplist['emp_type'])) and (empty($emp_cat) or ($emp_cat==$emplist['emp_cat'])) and (empty($emp_cat) or ($emp_cat==$emplist['emp_cat'])) ){
												?>
												<li>
													<a role="button" href="#modalquestionbank" data-toggle="modal" onClick="news(<?php echo $public_announcementsss['announcement_id'];?>)" style="cursor: pointer;"><?php echo ucwords($public_announcementsss['name']);?></a>
												</li>
												<?php
											}
											elseif(!empty($pro['learner_group_id'])){
												$learner_group=UlsLnrGroupDetails::get_groupdetails_emp($pro['learner_group_id'],$_SESSION['emp_id']);
												if(!empty($learner_group['id'])){
													?>
													<li>
														<a role="button" href="#modalquestionbank" data-toggle="modal" onClick="news(<?php echo $public_announcementsss['announcement_id'];?>)" style="cursor: pointer;"><?php echo ucwords($public_announcementsss['name']);?></a>
													</li>
													<?php
												}
											}
										}
									}
								}
								else{
									?>
									<li>
										<a role="button" href="#modalquestionbank" data-toggle="modal" onClick="news(<?php echo $public_announcementsss['announcement_id'];?>)" style="cursor: pointer;"><?php echo ucwords($public_announcementsss['name']);?></a>
									</li>
									<?php
								}
							?>

						<?php } } ?>

                    </ul>
                </li>

                <!--<li class="dropdown">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <i class="pe-7s-keypad"></i>
                    </a>

                    <div class="dropdown-menu hdropdown bigmenu animated flipInX">
                        <table>
                            <tbody>
                            <tr>
							<?php
							if($loguserid['user_login']==1){
								$Role_id=$this->session->userdata('Role_id');
								if(!empty($Role_id)){
									$role_name=Doctrine_Core::getTable('UlsRoleCreation')->findOneByRole_id($this->session->userdata('Role_id'));
									$role=Doctrine_Query::Create()->from('UlsUserRole a')->leftJoin('a.UlsRoleCreation b')->where("a.user_id=".$this->session->userdata('user_id')." and a.start_date<='".date("Y-m-d")."' and (a.end_date >= '".date("Y-m-d")."' or a.end_date is NULL  or a.end_date = '1970-01-01' or a.end_date = '0000-00-00') ")->setHydrationMode(Doctrine::HYDRATE_ARRAY)->execute();
									foreach($role as $roles){
									?>
									<td>
										<a href="#" onClick="menus(<?php echo $roles['UlsRoleCreation']['role_id']; ?>,<?php echo $roles['UlsRoleCreation']['menu_id']; ?>)">
											<i class="pe pe-7s-filter text-info"></i>
											<h6><?php echo $roles['UlsRoleCreation']['role_name']; ?></h6>
										</a>
									</td>
									<?php
									}
								}
							}
							?>
                            </tr>
							</tbody>
                        </table>
                    </div>
                </li>-->
                <li class="dropdown">
                    <a class="dropdown-toggle label-menu-corner" href="#" data-toggle="dropdown">
                        <i class="pe-7s-mail"></i>
                        <span class="label label-success"><?php echo count($notificationss);?></span>
                    </a>
                    <ul class="dropdown-menu hdropdown animated flipInX">
                        <div class="title">
                            You have <?php echo count($notificationss);?>  messages
                        </div>
                        <?php if(count($notificationss)>0){
								foreach($notificationss as $notificationsss){?>
						<li>
						<a href="#modalnotification" style="cursor: pointer;" data-toggle="modal" onclick="notification_mail(<?php echo $notificationsss->notification_history_id;?>)"><?php echo $notificationsss->subject;?></a>
						</li>
						<?php } } else{ echo "<li style='text-align:center;'>No Data Found.</li>";} ?>
                    </ul>
                </li>
                <li>
                    <a href="#" id="sidebar" class="right-sidebar-toggle">
                        <i class="pe-7s-upload pe-7s-news-paper"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="<?php echo BASE_URL; ?>/index/logout">
                        <i class="pe-7s-upload pe-rotate-90"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>
<div id="right-sidebar" class="animated fadeInRight">
	<div class="p-m">
		<button id="sidebar-close" class="right-sidebar-toggle sidebar-button btn btn-default m-b-md"><i class="pe pe-7s-close"></i>
		</button>
		<div class="hpanel plan-box hgreen active">
			<div class="panel-heading hbuilt text-center">
				<h6 class="font-bold">Switch Roles</h6>
			</div>
			<div class="panel-body">
				<table class="table">
					<thead>
					<?php
					if($loguserid['user_login']==1){
						$Role_id=$this->session->userdata('Role_id');
						if(!empty($Role_id)){
							$role_name=Doctrine_Core::getTable('UlsRoleCreation')->findOneByRole_id($this->session->userdata('Role_id'));
							$role=Doctrine_Query::Create()->from('UlsUserRole a')->leftJoin('a.UlsRoleCreation b')->where("a.user_id=".$this->session->userdata('user_id')." and a.start_date<='".date("Y-m-d")."' and (a.end_date >= '".date("Y-m-d")."' or a.end_date is NULL  or a.end_date = '1970-01-01' or a.end_date = '0000-00-00') ")->setHydrationMode(Doctrine::HYDRATE_ARRAY)->execute();
							foreach($role as $roles){
							?>
							<tr>
								<td>
									<a href="#" onClick="menus(<?php echo $roles['UlsRoleCreation']['role_id']; ?>,<?php echo $roles['UlsRoleCreation']['menu_id']; ?>)"> <?php echo $roles['UlsRoleCreation']['role_name']; ?></a>
								</td>
							</tr>
							<?php
							}
						}
					} ?>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- Navigation -->
<aside id="menu">
    <div id="navigation">
        <div class="profile-picture">
            <a href="#">
				<?php $pic_path=BASE_URL.'/public/images/male_user.jpg';if(isset($loguserid['employee_id'])){ $pic_path=(!empty($logempid->photo))?BASE_URL.'/public/uploads/profile_pic/'.trim($logempid->employee_id).'/'.trim($logempid->photo):(($logempid->gender=='M')?BASE_URL.'/public/images/male_user.jpg':BASE_URL.'/public/images/female_img.jpg'); } ?>
                <img src="<?php echo $pic_path;?>" class="img-circle m-b" alt="logo">
            </a>

            <div class="stats-label text-color">
                <span class="font-extra-bold font-uppercase">
				<?php
				if(empty($loguserid['employee_id'])){
					echo isset($loguserid['user_name'])?ucwords(@$loguserid['user_name']):"";
				}
				else{
					echo ucwords(strtolower(@$logempid->full_name));
				}

				?></span>

                <div class="dropdown">

                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <small class="text-muted">Welcome, <?php  echo @$logempid->full_name; ?> <b class="caret"></b></small>
                    </a>
                    <ul class="dropdown-menu animated flipInX m-t-xs">
                        <li><a href="<?php echo BASE_URL; ?>/admin/profile">Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo BASE_URL; ?>/admin/logout">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
		<?php
		if($loguserid['user_login']==1){
			$Role_id=$this->session->userdata('Role_id');
			if(!empty($Role_id)){
				$role_name=Doctrine_Core::getTable('UlsRoleCreation')->findOneByRole_id($this->session->userdata('Role_id'));
				?>
		<ul class="nav" id="side-menu">
			<li>
				<a class="label label-success">
					<i class="menu-icon fa fa-user blue"></i>
					<span class="menu-text"><b><?php echo $role_name->role_name;?></b></span>
				</a>
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
                <a onclick="link('/report/reportgeneration')" href="<?php echo BASE_URL; ?>/report/reportgeneration">Reports</a>
            </li>
            <?php } ?>
        </ul>
		<?php
			}
			else{
				?>
			<ul class="nav" id="side-menu">
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
			echo "<ul class='nav' id='side-menu'></ul>";
		}
		?>


	</div>
</aside>

<!-- Main Wrapper -->
<div id="wrapper">



<div class="small-header">
    <div class="hpanel">
        <div class="panel-body">
            <div id="hbreadcrumb" class="pull-right">

					<?php
							$home1=isset($home)?$home:"";
							if(strpos($_REQUEST['rt'],"min/dashboard")==0){
								$breadcrum=UlsMenu::display_parent_nodes("/".$men,$home1);
									 $_SESSION['breadcrum']=$breadcrum;
									 $breadcrums=explode("**",$breadcrum);
									 echo "<ol class='hbreadcrumb breadcrumb'>";
									 foreach($breadcrums as $kb=>$yb){
										echo "<li><span>$yb</span></li>";
									 }
									  echo "</ol>";
							}
							else{
								echo $home1." > dashboard";
							}
						?>

            </div>
            <h2 class="font-light m-b-xs">
                <?php echo @ucfirst($aboutpage['pagetitle']); ?>
            </h2>
            <small><?php echo @$aboutpage['pagedescription']; ?></small>
        </div>
    </div>
</div>


<?=$content;?>

<footer class="footer">
	<span class="pull-right">
		Copyright © <?php echo date('Y'); ?>.UniTol Training Solutions Private Limited. All rights reserved.
	</span>
</footer>

</div>

<!-- Vendor scripts -->


<script src="<?php echo BASE_URL; ?>/public/vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/vendor/iCheck/icheck.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/vendor/sparkline/index.js"></script>
<!-- App scripts -->
<script src="<?php echo BASE_URL; ?>/public/scripts/homer.js"></script>
<script src="<?php echo BASE_URL; ?>/public/vendor/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/js/chosen.jquery.js"></script>
<script src="<?php echo BASE_URL; ?>/public/js/alljs.js"></script>
<script src="<?php echo BASE_URL; ?>/public/js/validate/jquery.validationEngine.js"></script>

<script src="<?php echo BASE_URL; ?>/public/vendor/sweetalert/lib/sweet-alert.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/vendor/toastr/build/toastr.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/vendor/nestable/jquery.nestable.js"></script>
<script src="<?php echo BASE_URL; ?>/public/vendor/select2-3.5.2/select2.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/vendor/summernote/dist/summernote.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo BASE_URL; ?>/public/datatable/js/jquery.dataTables.js"></script>
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
	$(function () {
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

		/* $(".js-source-states").select2();
		$(".js-source-states-2").select2(); */
    });
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

</body>

</html>
