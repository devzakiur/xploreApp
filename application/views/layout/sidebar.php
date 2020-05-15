  <!-- ========== Left Sidebar Start ========== -->
  <div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <div class="user-details">
            <div class="pull-left">
                <img src="<?= WEB_IMG_URL ?>logo.png" alt="" class="thumb-md img-circle">
            </div>
            <div class="user-info">
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?= APP_NAME ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo site_url("setting/general/reset"); ?>"><i class="md md-settings"></i> Reset Profile</a></li>
                        <li><a href="<?php echo site_url("auth/logout"); ?>"><i class="md md-administrators-power"></i> Logout</a></li>
                    </ul>
                </div>
                
                <p class="text-muted m-0"><?= logged_in_role_name() ?></p>
            </div>
        </div>
        <!--- Divider -->
        <div id="sidebar-menu">
            <ul>
                <li>
                    <a href="<?php echo site_url("dashboard"); ?>" class="waves-effect <?php echo set_Topmenu("dashboard"); ?>"><i class="ion ion-grid"></i><span> Dashboard </span></a>
                </li>
				<?php if (hasActive("general_setup") && hasPermission("general_setup", VIEW)) : ?>
                <li class="has_sub">
                    <a href="#" class="waves-effect <?php echo set_Topmenu("general_setup"); ?>"><i class="ion ion-wrench"></i><span>General Setup </span><span class="pull-right"><i class="md md-add"></i></span></a>
                    <ul class="list-unstyled">
						<?php if (hasPermission("category", VIEW)) : ?>
                        <li class="<?php echo set_Submenu("category"); ?>"><a href="<?php echo site_url("category"); ?>">Category</a></li>
						<?php endif; ?>
						<?php if (hasPermission("batch", VIEW)) : ?>
                        <li class="<?php echo set_Submenu("batch"); ?>"><a href="<?php echo site_url("batch"); ?>">Batch</a></li>
						<?php endif; ?>
						<?php if (hasPermission("subject", VIEW)) : ?>
                        <li class="<?php echo set_Submenu("subject"); ?>"><a href="<?php echo site_url("subject"); ?>">Subject</a></li>
						<?php endif; ?>
						<?php if (hasPermission("subject_assign", VIEW)) : ?>
                        <li class="<?php echo set_Submenu("subject-assign"); ?>"><a href="<?php echo site_url("subject/subject_assign"); ?>">Subject Assign</a></li>
						<?php endif; ?>
						<?php if (hasPermission("section", VIEW)) : ?>
                        <li class="<?php echo set_Submenu("section"); ?>"><a href="<?php echo site_url("section"); ?>">Section</a></li>
						<?php endif; ?>
						<?php if (hasPermission("section_assign", VIEW)) : ?>
                        <li class="<?php echo set_Submenu("section-assign"); ?>"><a href="<?php echo site_url("section/section_assign"); ?>">Section Assign</a></li>
						<?php endif; ?>
						<?php if (hasPermission("topic", VIEW)) : ?>
                        <li class="<?php echo set_Submenu("topic"); ?>"><a href="<?php echo site_url("topic"); ?>">Topic</a></li>
						<?php endif; ?>
						<?php if (hasPermission("topic_assign", VIEW)) : ?>
                        <li class="<?php echo set_Submenu("topic-assign"); ?>"><a href="<?php echo site_url("topic/topic_assign"); ?>">Topic Assign</a></li>
						<?php endif; ?>
                    </ul>
                </li>
				<?php endif; ?>
				<?php if (hasActive("question_setup") && hasPermission("question_setup", VIEW)) : ?>
                <li class="has_sub">
                    <a href="#" class="waves-effect <?php echo set_Topmenu("question_setup"); ?>"><i class="ion ion-asterisk"></i><span>Question Setup </span><span class="pull-right"><i class="md md-add"></i></span></a>
                    <ul class="list-unstyled">
						<?php if (hasPermission("question", VIEW)) : ?>
                        <li class="<?php echo set_Submenu("question"); ?>"><a href="<?php echo site_url("question"); ?>">Question</a></li>
						<?php endif; ?>
						<?php if (hasPermission("user_question", VIEW)) : ?>
                        <li class="<?php echo set_Submenu("user_question"); ?>"><a href="<?php echo site_url("question/user_question"); ?>">User Question</a></li>
						<?php endif; ?>
						<?php if (hasPermission("report_question", VIEW)) : ?>
                        <li class="<?php echo set_Submenu("report_question"); ?>"><a href="<?php echo site_url("question/report_question"); ?>">Report Question</a></li>
						<?php endif; ?>
                    </ul>
                </li>
				<?php endif; ?>
				<?php if (hasActive("library_setup") && hasPermission("library_setup", VIEW)) : ?>
                <li class="has_sub">
                    <a href="#" class="waves-effect <?php echo set_Topmenu("library_setup"); ?>"><i class="ion ion-clipboard"></i><span>Library Setup </span><span class="pull-right"><i class="md md-add"></i></span></a>
                    <ul class="list-unstyled">
						<?php if (hasPermission("library", VIEW)) : ?>
                        <li class="<?php echo set_Submenu("library"); ?>"><a href="<?php echo site_url("library"); ?>">Library</a></li>
						<?php endif; ?>
                    </ul>
                </li>
				<?php endif; ?>
				<?php if (hasActive("news_setup") && hasPermission("news_setup", VIEW)) : ?>
                <li class="has_sub">
                    <a href="#" class="waves-effect <?php echo set_Topmenu("news_setup"); ?>"><i class="fa  fa-file-text"></i><span>News Setup </span><span class="pull-right"><i class="md md-add"></i></span></a>
                    <ul class="list-unstyled">
						<?php if (hasPermission("news_category", VIEW)) : ?>
                        <li class="<?php echo set_Submenu("news_category"); ?>"><a href="<?php echo site_url("news/news_category"); ?>">News Category</a></li>
						<?php endif; ?>
						<?php if (hasPermission("news", VIEW)) : ?>
                        <li class="<?php echo set_Submenu("news"); ?>"><a href="<?php echo site_url("news"); ?>">News</a></li>
						<?php endif; ?>
                    </ul>
                </li>
				<?php endif; ?>

				<?php if (hasActive("content") && hasPermission("content", VIEW)) : ?>
                <li>
                    <a href="<?php echo site_url("content"); ?>" class="waves-effect <?php echo set_Topmenu("content"); ?>"><i class="ion ion-document"></i><span> Content </span></a>
                </li>
				<?php endif; ?>
				<?php if (hasActive("model_test") && hasPermission("model_test", VIEW)) : ?>
                <li>
                    <a href="<?php echo site_url("modeltest"); ?>" class="waves-effect <?php echo set_Topmenu("model_test"); ?>"><i class="fa  fa-calendar"></i><span> Model Test </span></a>
                </li>
				<?php endif; ?>
				<?php if (hasActive("game_setting") && hasPermission("game_setting", VIEW)) : ?>
                <li>
                    <a href="<?php echo site_url("game"); ?>" class="waves-effect <?php echo set_Topmenu("game_setting"); ?>"><i class="fa fa-gamepad"></i><span>Game Setting </span></a>
                </li>
				<?php endif; ?>
				<?php if (hasActive("notification") && hasPermission("notification", VIEW)) : ?>
                <li>
                    <a href="<?php echo site_url("notification"); ?>" class="waves-effect <?php echo set_Topmenu("notification"); ?>"><i class="fa fa-bell"></i><span>Notification </span></a>
                </li>
				<?php endif; ?>
				<?php if (hasActive("social") && hasPermission("social", VIEW)) : ?>
                <li>
                    <a href="<?php echo site_url("social"); ?>" class="waves-effect <?php echo set_Topmenu("social"); ?>"><i class="fa fa-share"></i><span>Social Setting </span></a>
                </li>
				<?php endif; ?>
				<?php if (hasActive("users") && hasPermission("users", VIEW)) : ?>
                <li>
                    <a href="<?php echo site_url("users"); ?>" class="waves-effect <?php echo set_Topmenu("users"); ?>"><i class="fa fa-users"></i><span>App Users </span></a>
                </li>
				<?php endif; ?>
				<?php if (hasActive("administrator") && hasPermission("administrator", VIEW)) : ?>
                <li class="has_sub">
                    <a href="#" class="waves-effect <?php echo set_Topmenu("administrator"); ?>"><i class="ion ion-android-sort"></i><span>Administrator </span><span class="pull-right"><i class="md md-add"></i></span></a>
                    <ul class="list-unstyled">
						<?php if(is_super_admin()): ?>
                        <li class="<?php echo set_Submenu("module"); ?>"><a href="<?php echo site_url("module"); ?>">Module</a></li>
                        <li class="<?php echo set_Submenu("mlist"); ?>"><a href="<?php echo site_url("module/mlist"); ?>">Module List</a></li>
						<?php endif; ?>
						 <?php if (hasPermission("role_permission", VIEW)) : ?>
                        <li class="<?php echo set_Submenu("role-permission"); ?>"><a href="<?php echo site_url("role-permission"); ?>">Role Permission</a></li>
						<?php endif; ?>
						 <?php if (hasPermission("manage_user", VIEW)) : ?>
                        <li class="<?php echo set_Submenu("manage-user"); ?>"><a href="<?php echo site_url("manage-user"); ?>">Manage User</a></li>
						<?php endif; ?>
						<?php if (hasPermission("backup", VIEW)) : ?>
                        	<li class="<?php echo set_Submenu("backup"); ?>"><a href="<?php echo site_url("install/create_backup"); ?>">Backup</a></li>
						<?php endif; ?>
                    </ul>
                </li>
				<?php endif; ?>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<!-- Left Sidebar End --> 
