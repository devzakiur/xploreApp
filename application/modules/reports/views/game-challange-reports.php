<div class="content">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="panel">
					<div class="panel-body">
						<form action="<?php site_url("reports") ?>" method="get" id="search">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label for="category_id">Category</label><small class="req">*</small>
										<select id="category_id" name="category_id" class="form-control selectpicker" data-live-search="true" data-container="body">
											<option value="">--Select--</option>
											<?php foreach ($category_list as $value) : ?>
												<option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="challenge_type">Challenge Type</label><small class="req">*</small>
										<select id="challenge_type" name="challenge_type" class="form-control selectpicker" data-live-search="true" data-container="body">
											<option value="">--Select--</option>
											<?php foreach ($challenge_type as $value) : ?>
												<option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="from_date">From Date</label>
										<input type="text" id="from_date" class="form-control" name="from_date" readonly>
									</div>
								</div>
								<div class="col-md-3">
									<label for="to_date">To Date</label>
									<div class="input-group">
										<input type="text" id="to_date" name="to_date" class="form-control" readonly>
										<div class="input-group-btn">
											<button class="btn btn-success" id="filter_search" type="submit">
												<i class="md md-search"></i>
											</button>
										</div>
									</div>
								</div>
							</div>
						</form>
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
								<table id="datatable" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th class="text-center">SL.</th>
											<th class="text-center">User Name</th>
											<th class="text-center">Correct Answer</th>
											<th class="text-center">Wrong Answer</th>
											<th class="text-center">Unanswered</th>
											<th class="text-center">Total Time</th>
											<th class="text-center">Total Point</th>
										</tr>
									</thead>
									<tbody>

									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div> <!-- End Row -->
	</div> <!-- container -->
</div>
<div id="con-close-user-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<!-- <form id="item_add"> -->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">User Details</h4>
			</div>
			<div class="modal-body">
				<div id="show_user_details">

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div><!-- /.modal -->
<style>
	.user_details_modal {
		cursor: pointer;
	}
</style>
<script src="<?php echo VENDOR_URL; ?>timepicker/bootstrap-datepicker.js"></script>
<script>
	$(document).ready(function() {
		jQuery('#from_date,#to_date').datepicker({
			format: 'yyyy-mm-dd',
			todayBtn: true,
			todayHighlight: true,
			autoclose: true
		});
		$("#search").on("submit", function(e) {
			e.preventDefault();
			get_view(false);
			return false;
		});
		$("#datatable").on("click", '.pagination li a', function() {
			var page_url = $(this).attr("href");
			if (page_url == "javascript:void(0)") {
				return false;
			}
			get_view(page_url);
			return false;
		});
		get_view(false);

		function get_view(page_url) {
			var base_url = "<?php echo base_url() ?>reports/challenge_view";
			if (page_url) {
				base_url = page_url;
			}
			$.ajax({
				url: base_url,
				type: "get",
				dataType: "json",
				data: $("#search").serialize(),
				beforeSend: function() {
					$("#library_loading").fadeIn(300);
				},
				success: function(data) {
					$("#datatable tbody").html(data);
					$("#library_loading").fadeOut(300);
				},
				error: function(e) {
					$("#library_loading").fadeOut(300);
				}
			});
		}
		$("#datatable").on("click", "#user_details_modal", function() {
			var user_id = $(this).data("id");
			$.ajax({
				url: "<?php echo base_url() ?>question/user_details_view",
				type: "get",
				dataType: "json",
				data: {
					"user_id": user_id
				},
				beforeSend: function() {
					$("#overlay").fadeIn(300);
				},
				success: function(data) {
					$("#show_user_details").html(data);
					$("#overlay").fadeOut(300);
				},
				error: function(e) {
					$.Notification.autoHideNotify('error', 'top right', "Something Wrong. Please try again");
					$("#overlay").fadeOut(300);
				}
			});
		});
	});
</script>
