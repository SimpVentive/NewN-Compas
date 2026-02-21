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
	<link href="<?php echo BASE_URL; ?>/public/styles/layout_style.php?id=<?php echo isset($aboutpage['pagecss'])? $aboutpage['pagecss'] : ""; ?>" rel="stylesheet" type="text/css"/>
</head>
<?php
	if(isset($_REQUEST["ExportType"]))
{
	 
    switch($_REQUEST["ExportType"])
    {
        case "export-to-excel" :
            // Submission from
			$filename ="Data_Report.xls";		 
            header("Content-Type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=\"$filename\"");
			//ExportFile($data);
			//$_POST["ExportType"] = '';
            //exit();
        default :
            //die("Unknown action : ".$_POST["action"]);
            break;
    }
}
?>
<body>
<!--[if lt IE 7]>
<p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<!-- Header -->


<!-- Navigation -->

<!-- Main Wrapper -->
<div id="">
<br>
<?=$content;?>


</div>

<!-- Vendor scripts -->


</body>

</html>
