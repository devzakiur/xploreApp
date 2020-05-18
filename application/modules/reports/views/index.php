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

							<div class="col-md-12 col-sm-12 col-xs-12 table-responsive" style="overflow: hidden">
								<div id="library_loading">
									<div class="cv-spinner">
										<span class="spinner"></span>
									</div>
								</div>
								<table id="datatable" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th class="text-center">SL.</th>
											<th class="text-center">Title</th>
											<th class="text-center">Date</th>
											<th class="text-center">Time</th>
											<th class="text-center">Duration</th>
											<th class="text-center">Total Question</th>
											<th class="text-center">Total Participate</th>
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
		</div> <!-- End Row -->
	</div> <!-- container -->
</div>
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
			var base_url = "<?php echo base_url() ?>reports/view";
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
	});
</script>
