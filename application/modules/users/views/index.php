<div class="content">
	<div class="container">
		<?php echo $this->session->flashdata("msg"); ?>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-border panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">App Users View</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-3 m-b-10 pull-left">
								<div class="">
									<div class="col-md-12 m-b-10 pull-right">
										<div class="form-group">
											<label for="filter_by">Filter By</label>
											<select id="filter_by" name="filter_by" class="form-control selectpicker">
												<option value="">All</option>
												<option value="1">Active</option>
												<option value="0">Block</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4 m-b-10 pull-right  m-t-22">
								<div class="">
									<div class="col-md-12 m-b-10 pull-right">
										<div class="input-group">
											<input type="text" name="search_key" placeholder="Search User Name Phone Or Email" id="search_key" class="form-control">
											<div class="input-group-btn">
												<button class="btn btn-info" id="add_button" type="button">
													<i class="md md-search"></i>
												</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div style="overflow: hidden">
									<div id="library_loading">
										<div class="cv-spinner">
											<span class="spinner"></span>
										</div>
									</div>
									<table id="users" class="table table-striped table-bordered">
										<thead>
											<tr>
												<th class="text-center">Sl.</th>
												<th class="text-center">Name</th>
												<th class="text-center">Email</th>
												<th class="text-center">Phone</th>
												<th class="text-center">Reg.Date</th>
												<th class="text-center">Action</th>
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
<script>
	$(document).ready(function() {
		$("#search_key").on("change", function() {
			get_view(false);
			return false;
		});
		$("#filter_by").on("change", function() {
			get_view(false);
			return false;
		});
		$("#users").on("click", '.pagination li a', function() {
			var page_url = $(this).attr("href");
			if (page_url == "javascript:void(0)") {
				return false;
			}
			get_view(page_url);
			return false;
		});
		$("#users").on("click", "#user_details_modal", function() {
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
		get_view(false);

		function get_view(page_url) {
			var filter_by = $("#filter_by").val();
			var search_key = $("#search_key").val();
			var base_url = "<?php echo base_url() ?>users/view";
			if (page_url) {
				base_url = page_url;
			}
			log(base_url);
			$.ajax({
				url: base_url,
				type: "get",
				dataType: "json",
				data: {
					"search_key": search_key,
					"filter_by": filter_by,
				},
				beforeSend: function() {
					$("#library_loading").fadeIn(300);
				},
				success: function(data) {
					$("#users tbody").html(data);
					$("#library_loading").fadeOut(300);
				},
				error: function(e) {
					$("#library_loading").fadeOut(300);
				}
			});
		}

	});
</script>
