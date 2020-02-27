<div class="topbar">
    <!-- LOGO -->
    <div class="topbar-left">
        <div class="text-center">
            <a href="<?php echo base_url(); ?>" target="_blank" class="logo"><img src="<?php echo IMG_URL; ?>logo.png" class="thumb-sm" alt=""> <span><?php echo APP_NAME; ?> </span></a>
        </div>
    </div>
    <!-- Button mobile view to collapse sidebar menu -->
    <div class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="">
                <div class="pull-left">
                    <button class="button-menu-mobile open-left">
                        <i class="fa fa-bars"></i>
                    </button>
                    <span class="clearfix"></span>
                </div>

                <ul class="nav navbar-nav navbar-right pull-right">
                    <li class="hidden-xs">
                        <a href="#" id="btn-fullscreen" class="waves-effect waves-light"><i class="md md-crop-free"></i></a>
                    </li>
                    <li class="dropdown">
                        <a href="" class="dropdown-toggle profile" data-toggle="dropdown" aria-expanded="true"><img src="<?php echo IMG_URL; ?>logo.png" alt="user-img" class="img-circle"> </a>
                        <ul class="dropdown-menu">
                                <li><a href="<?php echo site_url("setting/general/reset"); ?>"><i class="md md-settings"></i> Reset Profile</a></li>
                            <li><a href="<?php echo site_url("auth/logout"); ?>"><i class="md md-settings-power"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </div>
</div>
