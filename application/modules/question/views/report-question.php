<div class="content">
	<div class="container">
		<?php echo $this->session->flashdata("msg"); ?>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-border panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">User Question Reports</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="search_category_id">Category</label><small class="req">*</small>
									<select id="search_category_id" name="search_category_id" class="form-control selectpicker" data-live-search="true" data-container="body">
										<option value="">--Select--</option>
										<?php foreach ($category_list as $value) : ?>
											<option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="search_subject_id">Subject</label>
									<select id="search_subject_id" name="search_subject_id" class="form-control selectpicker" data-live-search="true" data-container="body">
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="search_section_id">Section</label>
									<select id="search_section_id" name="search_section_id" class="form-control selectpicker" data-live-search="true" data-container="body">
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<label for="search_topic_id">Topic</label>
								<div class="input-group">
									<select id="search_topic_id" name="search_topic_id" class="form-control selectpicker" data-live-search="true" data-container="body">
									</select>
									<div class="input-group-btn">
										<button class="btn btn-success" id="filter_search" type="button">
											<i class="md md-search"></i>
										</button>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2 m-b-10">
								<div class="form-group">
									<label for="filter_by">Filter By</label>
									<select id="filter_by" name="filter_by" class="form-control selectpicker">
										<option value="">All</option>
										<option value="0">View</option>
										<option value="1">Not View</option>
									</select>
								</div>
							</div>
							<div class="col-md-4 m-b-10">
								<div class="form-group">
									<label for="date">Date</label>
									<input type="date" name="date" placeholder="<?= date("Y-m-d") ?>" id="date" class="form-control">
								</div>
							</div>
							<div class="col-md-2 m-b-10">
							</div>
							<div class="col-md-4 m-b-10 m-t-22">
								<div class="input-group">
									<input type="text" name="search_key" placeholder="Search Question Title Or User Name" id="search_key" class="form-control">
									<div class="input-group-btn">
										<button class="btn btn-info" id="add_button" type="button">
											<i class="md md-search"></i>
										</button>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div style="overflow: hidden">
									<div id="question_loading">
										<div class="cv-spinner">
											<span class="spinner"></span>
										</div>
									</div>
									<table id="question" class="table table-striped table-bordered">
										<thead>
											<tr>
												<th class="text-center">Sl.</th>
												<th class="text-center">User Name</th>
												<th class="text-center">Question Title</th>
												<th class="text-center">Type</th>
												<th class="text-center">Details</th>
												<th class="text-center">Date</th>
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
<div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<!-- <form id="item_add"> -->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">User Question Report Details</h4>
			</div>
			<div class="modal-body">
				<div id="show_details">

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div><!-- /.modal -->
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
		$("#filter_by,#date").on("change", function() {
			get_view(false);
			return false;
		});
		$("#search_key").on("change", function() {
			get_view(false);
			return false;
		});
		$("#question").on("click", '.pagination li a', function() {
			var page_url = $(this).attr("href");
			log(page_url);
			if (page_url == "javascript:void(0)") {
				return false;
			}
			get_view(page_url);
			return false;
		});
		get_view(false, 0);

		function get_view(page_url, sorting = 1) {
			var date = $("#date").val();
			var filter_by = $("#filter_by").val();
			var category_id = $("#search_category_id").val();
			var subject_id = $("#search_subject_id").val();
			var section_id = $("#search_section_id").val();
			var topic_id = $("#search_topic_id").val();
			var search_key = $("#search_key").val();
			var base_url = "<?php echo base_url() ?>question/user_question_report_view";
			if (page_url) {
				base_url = page_url;
			}
			$.ajax({
				url: base_url,
				type: "post",
				dataType: "json",
				data: {
					"search_key": search_key,
					"filter_by": filter_by,
					"category_id": category_id,
					"subject_id": subject_id,
					"section_id": section_id,
					"topic_id": topic_id,
					"sorting": sorting,
					"date": date,
				},
				beforeSend: function() {
					$("#question_loading").fadeIn(300);
				},
				success: function(data) {
					$("#question tbody").html(data);
					$("#question_loading").fadeOut(300);
				},
				error: function(e) {
					$("#question_loading").fadeOut(300);
				}
			});
		}


		$("#question").on("click", "#details_modal", function() {
			var error_id = $(this).data("id");
			var text = $("#" + error_id + " #details").text();
			$("#show_details").html(text);
		});
		$("#question").on("click", "#user_details_modal", function() {
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
		//    search area
		$("#search_category_id").on("change", function() {
			var category_id = $(this).val();
			$.ajax({
				url: "<?php echo base_url() ?>ajax/get_subject_by_category",
				type: "get",
				dataType: "json",
				data: {
					"category_id": category_id
				},
				success: function(data) {
					$("#search_subject_id").find('option').remove();
					$("#search_section_id").find('option').remove();
					$("#search_topic_id").find('option').remove();
					$("#search_subject_id").append('<option value="">--Select--</option>');
					$.each(data, function(key, value) {
						$("#search_subject_id").append('<option value="' + value.id + '">' + value.name + '</option>');
					});
					$(".selectpicker").selectpicker('render').selectpicker('refresh');
				}
			});
			get_view(false);
		});
		$("#search_subject_id").on("change", function() {
			var subject_id = $(this).val();
			$.ajax({
				url: "<?php echo base_url() ?>ajax/get_section_by_subject",
				type: "get",
				dataType: "json",
				data: {
					"subject_id": subject_id
				},
				success: function(data) {
					$("#search_section_id").find('option').remove();
					$("#search_topic_id").find('option').remove();
					$("#search_section_id").append('<option value="">--Select--</option>');
					$.each(data, function(key, value) {
						$("#search_section_id").append('<option value="' + value.id + '">' + value.name + '</option>');
					});
					$(".selectpicker").selectpicker('render').selectpicker('refresh');
				}
			});
			get_view(false);
		});
		$("#search_section_id").on("change", function() {
			var section_id = $(this).val();
			$.ajax({
				url: "<?php echo base_url() ?>ajax/get_topic_by_section",
				type: "get",
				dataType: "json",
				data: {
					"section_id": section_id
				},
				success: function(data) {
					$("#search_topic_id").find('option').remove();
					$("#search_topic_id").append('<option value="">--Select--</option>');
					$.each(data, function(key, value) {
						$("#search_topic_id").append('<option value="' + value.id + '">' + value.name + '</option>');
					});
					$(".selectpicker").selectpicker('render').selectpicker('refresh');
				}
			});
			get_view(false);
		});
		$("#search_topic_id,#search_batch_id,#search_year").on("change", function() {
			get_view(false);
		});
	});
</script>
