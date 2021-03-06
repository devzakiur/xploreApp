<div class="content">
    <div class="container">
<?php echo $this->session->flashdata("msg"); ?>

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="pull-left page-title">Welcome To Xplore Dashboard !</h4>
                <?php echo breadcrumbs(); ?>
            </div>
        </div>
        <!-- Start Widget -->
		<div class="row">
			<?php if(hasPermission("total_pending_question",VIEW)): ?>
				<div class="col-md-4 col-sm-6 col-lg-3">
					<div class="mini-stat clearfix bx-shadow">
						<span class="mini-stat-icon bg-primary"><i class="fa  fa-bell"></i></span>
						<div class="mini-stat-info text-right text-muted">
							<span class="counter"><?= $total_pending_question; ?></span>
							Total Pending Question
						</div>
					</div>
				</div>
			<?php endif; ?>
			<?php if(hasPermission("total_pending_library",VIEW)): ?>
				<div class="col-md-4 col-sm-6 col-lg-3">
					<div class="mini-stat clearfix bx-shadow">
						<span class="mini-stat-icon bg-success"><i class="fa  fa-bell"></i></span>
						<div class="mini-stat-info text-right text-muted">
							<span class="counter"><?= $total_pending_library; ?></span>
							Total Pending Library
						</div>
					</div>
				</div>
			<?php endif; ?>
			<?php if(hasPermission("total_report_question",VIEW)): ?>
				<div class="col-md-4 col-sm-6 col-lg-3">
					<div class="mini-stat clearfix bx-shadow">
						<span class="mini-stat-icon bg-danger"><i class="fa  fa-bug"></i></span>
						<div class="mini-stat-info text-right text-muted">
							<span class="counter"><?= $total_question_report; ?></span>
							Total Report Question
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div> <!-- container -->
</div>
