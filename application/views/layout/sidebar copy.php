<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <div class="user-details">
            <div class="pull-left">
                <img src="<?php echo IMG_URL; ?>users/avatar-1.jpg" alt="" class="thumb-md img-circle">
            </div>
            <div class="user-info">
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">John Doe <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo site_url("setting/general/reset"); ?>"><i class="md md-settings"></i> Reset Profile</a></li>
                        <li><a href="<?php echo site_url("auth/logout"); ?>"><i class="md md-administrators-power"></i> Logout</a></li>
                    </ul>
                </div>

                <p class="text-muted m-0"><?php echo logged_in_role_name(); ?> </p>
            </div>
        </div>
        <!--- Divider -->
        <div id="sidebar-menu">
            <ul>
                <li>
                    <a href="<?php echo base_url(); ?>" class="waves-effect <?php echo set_Topmenu("dashboard"); ?>"><i class="md md-home"></i><span> Dashboard </span></a>
                </li>
                    <li class="has_sub">
                        <a href="#" class="waves-effect <?php echo set_Topmenu("administrator"); ?>"><i class="fa fa-user"></i><span> Administrator </span><span class="pull-right"><i class="md md-add"></i></span></a>
                        <ul class="list-unstyled">
                            <?php if (hasPermission("role_permission", VIEW)) : ?>
                                <li class="<?php echo set_Submenu("role-permission"); ?>"><a href="<?php echo site_url("administrator/role"); ?>">Role Permission</a></li>
                            <?php endif; ?>
                            <?php if (is_super_admin()) : ?>
                                <?php if (hasPermission("module", VIEW)) : ?>
                                    <li class="<?php echo set_Submenu("administrator/module"); ?>"><a href="<?php echo site_url("administrator/module"); ?>">Module</a></li>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if (hasPermission("manage_user", VIEW)) : ?>
                                <li class="<?php echo set_Submenu("administrator/users"); ?>"><a href="<?php echo site_url("administrator/users"); ?>">Manage User</a></li>
                            <?php endif; ?>
                            <?php if (hasPermission("session", VIEW)) : ?>
                                <li class="<?php echo set_Submenu("administrator/sessions"); ?>"><a href="<?php echo site_url("administrator/sessions"); ?>">Manage Session</a></li>
                            <?php endif; ?>
                            <?php if (hasPermission("transfer", VIEW)) : ?>
                                <li class="<?php echo set_Submenu("administrator/transfer"); ?>"><a href="<?php echo site_url("administrator/transfer"); ?>">Transfer</a></li>
                            <?php endif; ?>
                            <?php if (hasPermission("backup", VIEW)) : ?>
                                <li class="<?php echo set_Submenu("administrator/backup"); ?>"><a href="<?php echo site_url("administrator/backup"); ?>">Backup</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <li class="has_sub">
                        <a href="#" class="waves-effect <?php echo set_Topmenu("employee"); ?>"><i class="fa fa-user-md"></i><span> Human Resource </span><span class="pull-right"><i class="md md-add"></i></span></a>
                        <ul class="list-unstyled">
                            <li class="<?php echo set_Submenu("employee/designation"); ?>"><a href="<?php echo site_url("employee/designation"); ?>">Manage Designation</a></li>
                            <li class="<?php echo set_Submenu("employee/index"); ?>"><a href="<?php echo site_url("employee/index"); ?>">Manage Employee</a></li>
                        </ul>
                    </li>
                    <li class="has_sub">
                        <a href="#" class="waves-effect <?php echo set_Topmenu("student"); ?>"><i class="fa fa-user"></i><span>Student </span><span class="pull-right"><i class="md md-add"></i></span></a>
                        <ul class="list-unstyled">
                            <li class="<?php echo set_Submenu("student/add"); ?>"><a href="<?php echo site_url("student/index"); ?>">Admission</a></li>
                            <li class="<?php echo set_Submenu("student/view"); ?>"><a href="<?php echo site_url("student/view"); ?>">Student List</a></li>
                        </ul>
                    </li>
              
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
