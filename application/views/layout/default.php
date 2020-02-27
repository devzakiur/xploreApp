<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Xplore is a online educational system">
        <meta name="author" content="Xplore">

    <link rel="shortcut icon" href="<?php echo IMG_URL; ?>favicon.ico">

    <title><?php echo APP_NAME; ?> | <?php echo $title_for_layout; ?></title>

    <!-- Base Css Files -->
    <link href="<?php echo CSS_URL; ?>bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo CSS_URL; ?>bootstrap-select.min.css" rel="stylesheet" />

    <!-- Font Icons -->
    <link href="<?php echo VENDOR_URL; ?>font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="<?php echo VENDOR_URL; ?>ionicon/css/ionicons.min.css" rel="stylesheet" />
    <link href="<?php echo CSS_URL; ?>material-design-iconic-font.min.css" rel="stylesheet">

    <!-- animate css -->
    <link href="<?php echo CSS_URL; ?>animate.css" rel="stylesheet" />

    <!-- Waves-effect -->
    <link href="<?php echo CSS_URL; ?>waves-effect.css" rel="stylesheet">
    <!-- Plugins css-->
    <link href="<?php echo VENDOR_URL; ?>timepicker/bootstrap-timepicker.min.css" rel="stylesheet" />
    <link href="<?php echo VENDOR_URL; ?>timepicker/bootstrap-datepicker.min.css" rel="stylesheet" />
    <link href="<?php echo VENDOR_URL; ?>notifications/notification.css" rel="stylesheet" />
    <!-- sweet alerts -->
    <link href="<?php echo VENDOR_URL; ?>sweet-alert/sweet-alert.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo VENDOR_URL; ?>dropify-master/dist/css/dropify.min.css">
    <!--calendar css-->
    <link href="<?php echo VENDOR_URL; ?>jquery-multi-select/multi-select.css" rel="stylesheet" type="text/css" />

    <!-- Custom Files -->
    <link href="<?php echo CSS_URL; ?>helper.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo CSS_URL; ?>style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo CSS_URL; ?>custom.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

    <script src="<?php echo JS_URL; ?>modernizr.min.js"></script>
    <!-- jQuery  -->
    <script src="<?php echo JS_URL; ?>jquery.min.js"></script>
    <script src="<?php echo JS_URL; ?>bootstrap.min.js"></script>
    <script src="<?php echo JS_URL; ?>log.js"></script>

 <script  src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>

</head>

<body class="fixed-left">
	<div id="overlay">
		<div class="cv-spinner">
			<span class="spinner"></span>
		</div>
	</div>
    <!-- Begin page -->
    <div id="wrapper">

        <!-- Top Bar Start -->
        <?php $this->load->view("layout/header"); ?>
        <!-- Top Bar End -->

        <!-- ========== Left Sidebar Start ========== -->

        <?php $this->load->view("layout/sidebar"); ?>
        <!-- Left Sidebar End -->
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="content-page">
            <!-- Start content -->
            <?php echo $content_for_layout; ?>
            <!-- content -->

            <?php $this->load->view("layout/footer"); ?>

        </div>
        <!-- ============================================================== -->
        <!-- End Right content here -->
        <!-- ============================================================== -->
    </div>
    <!-- END wrapper -->
    <script>
        var resizefunc = [];
    </script>
    <!-- jQuery  -->
    <script src="<?php echo JS_URL; ?>waves.js"></script>
    <script src="<?php echo JS_URL; ?>wow.min.js"></script>
    <script src="<?php echo JS_URL; ?>jquery.nicescroll.js" type="text/javascript"></script>
    <script src="<?php echo JS_URL; ?>jquery.scrollTo.min.js"></script>
    <script src="<?php echo VENDOR_URL; ?>jquery-detectmobile/detect.js"></script>
    <script src="<?php echo VENDOR_URL; ?>fastclick/fastclick.js"></script>
    <script src="<?php echo VENDOR_URL; ?>jquery-slimscroll/jquery.slimscroll.js"></script>


    <!-- Counter-up -->
    <script src="<?php echo VENDOR_URL; ?>counterup/waypoints.min.js" type="text/javascript"></script>
    <script src="<?php echo VENDOR_URL; ?>counterup/jquery.counterup.min.js" type="text/javascript"></script>

    <!-- CUSTOM JS -->
    <script src="<?php echo JS_URL; ?>jquery.app.js"></script>
    <script src="<?php echo JS_URL; ?>bootstrap-select.min.js"></script>
    <script src="<?php echo VENDOR_URL; ?>dropify-master/dist/js/dropify.min.js"></script>

    <!-- Dashboard -->
    <!-- <script src="<?php echo JS_URL; ?>jquery.dashboard.js"></script> -->

    <script type="text/javascript">
        /* ==============================================
            Counter Up
            =============================================== */
        jQuery(document).ready(function($) {
            $(".counter").counterUp({
                delay: 100,
                time: 1200
            });
        });
        $(':file').dropify();
    </script>
	<script>
		function updateMath() {
			MathJax.typesetPromise();
		}
	</script>
</body>

</html>
