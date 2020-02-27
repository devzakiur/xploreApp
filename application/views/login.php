<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Xplore is a online educational system">
        <meta name="author" content="Xplore">

        <link rel="shortcut icon" href="<?php echo IMG_URL; ?>favicon.png">

        <title><?php echo APP_NAME; ?> | Login</title>

        <!-- Base Css Files -->
        <link href="<?php echo CSS_URL; ?>bootstrap.min.css" rel="stylesheet" />

        <!-- Font Icons -->
        <link href="<?php echo VENDOR_URL; ?>font-awesome/css/font-awesome.min.css" rel="stylesheet" />
        <link href="<?php echo VENDOR_URL; ?>ionicon/css/ionicons.min.css" rel="stylesheet" />
        <link href="<?php echo CSS_URL; ?>material-design-iconic-font.min.css" rel="stylesheet">

        <!-- animate css -->
        <link href="<?php echo CSS_URL; ?>animate.css" rel="stylesheet" />

        <!-- Waves-effect -->
        <link href="<?php echo CSS_URL; ?>waves-effect.css" rel="stylesheet">

        <!-- Custom Files -->
        <link href="<?php echo CSS_URL; ?>helper.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo CSS_URL; ?>style.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="js/modernizr.min.js"></script>
        
    </head>
    <body>


        <div class="wrapper-page">
            <div class="panel panel-color panel-primary panel-pages">
                <div class="panel-heading bg-img"> 
                    <div class="bg-overlay"></div>
                    <h3 class="text-center m-t-10 text-white"> Sign In to <strong><?= APP_NAME ?></strong> </h3>
                </div> 
                <div class="panel-body">
                <?php echo $this->session->flashdata("msg"); ?>
                <?php echo form_open("auth/login",array("class"=>"form-horizontal m-t-20")); ?>
                    
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control input-lg " type="text" name="username" required="" placeholder="Username">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control input-lg" type="password" name="password" required="" placeholder="Password">
                        </div>
                    </div>
                    
                    <div class="form-group text-center m-t-40">
                        <div class="col-xs-12">
                            <button class="btn btn-primary btn-lg w-lg waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>

                </form> 
                </div>                                 
                
            </div>
        </div>
	</body>
</html>
