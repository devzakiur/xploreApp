<div class="content">
	<div class="container">
		<?php echo $this->session->flashdata("msg"); ?>
		<?php if (hasPermission("model_test", ADD)) : ?>
			<?php if (isset($add)) : ?>
				<div class="row">
					<div class="col-sm-12">
						<div class="panel panel-border panel-info">
							<div class="panel-heading">
								<h3 class="panel-title">Manage Model Test</h3>
							</div>
							<div class="panel-body">
								<form id="model_test">
									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="title">Title</label><small class="req"> *</small>
												<input type="text" name="title" placeholder="Title" class="form-control" required id="title">
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="date">Date</label><small class="req"> *</small>
												<input type="date" name="date" class="form-control" required id="date">
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="time">Time</label><small class="req"> *</small>
												<input type="time" name="time" class="form-control" required id="time">
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="duration">Duration</label><small class="req"> *</small>
												<input type="duration" name="duration" placeholder="Duration(Minites)" class="form-control" required id="duration">
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="total_question">Total Question</label><small class="req"> *</small>
												<input type="number" min="1" max="200" name="total_question" placeholder="Total Question" class="form-control" required id="total_question">
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="category_id">Category</label><small class="req"> *</small>
												<select id="category_id" required name="category_id" class="form-control selectpicker" data-live-search="true">
													<option value="">--Select--</option>
													<?php if (count($category) > 0) : ?>
														<?php foreach ($category as $value) : ?>
															<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
														<?php endforeach; ?>
													<?php endif; ?>
												</select>
											</div>
										</div>
										<div class="col-sm-12">
											<div class="form-group">
												<label for="syllabus">Syllabus</label><small class="req"> *</small>
												<textarea name="syllabus" id="syllabus" class="form-control" cols="30" rows="10"></textarea>
											</div>
										</div>
										<div class="col-sm-8">
											<div class="form-group">
												<label for="subject_id">Subject</label><small class="req"> *</small>
												<select name="subject_id[]" required class="multi-select form-control" multiple="" id="subject_id">
												</select>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group pull-left m-t-22 m-l-15 ">
												<button name="" type="submit" class="btn btn-primary"><i class="md md-add m-r-5"></i>Add</button>
											</div>
										</div>
									</div>
								</form>
							</div> <!-- panel-body -->
						</div> <!-- panel -->
					</div> <!-- col -->
				</div> <!-- End row -->
			<?php endif; ?>
		<?php endif; ?>
		<?php if (hasPermission("model_test", EDIT)) : ?>
			<?php if (isset($edit)) : ?>
				<div class="row">
					<div class="col-sm-12">
						<div class="panel panel-border panel-info">
							<div class="panel-heading">
								<h3 class="panel-title">Manage Model Test</h3>
							</div>
							<div class="panel-body">
								<!-- <form id="find"> -->
								<?php echo form_open("modeltest/edit/" . $single->id); ?>
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<label for="title">Title</label><small class="req"> *</small>
											<input type="text" name="title" placeholder="Title" value="<?= $single->title ?>" class="form-control" required id="title">
											<input type="hidden" name="id" value="<?= $single->id ?>">
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="date">Date</label><small class="req"> *</small>
											<input type="date" value="<?= date("Y-m-d", strtotime($single->date)) ?>" name="date" class="form-control" required id="date">
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="time">Time</label><small class="req"> *</small>
											<input type="time" name="time" value="<?= date("H:i", strtotime($single->date)) ?>" class="form-control" required id="time">
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="duration">Duration</label><small class="req"> *</small>
											<input type="duration" value="<?= $single->duration ?>" name="duration" placeholder="Duration(Minites)" class="form-control" required id="duration">
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<label for="syllabus">Syllabus</label><small class="req"> *</small>
											<textarea name="syllabus" id="syllabus" class="form-control" cols="30" rows="10"><?= $single->syllabus ?></textarea>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group pull-left m-t-22 m-l-15 ">
											<button name="" type="submit" class="btn btn-primary"><i class="md md-add m-r-5"></i>Update</button>
										</div>
									</div>
								</div>
								</form>
							</div> <!-- panel-body -->
						</div> <!-- panel -->
					</div> <!-- col -->
				</div> <!-- End row -->
			<?php endif; ?>
		<?php endif; ?>
		<div class="row">
			<div class="col-md-12">
				<div class="panel">
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<table id="datatable" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th class="text-center">SL.</th>
											<th class="text-center">Category Name</th>
											<th class="text-center">Title</th>
											<th class="text-center">Date</th>
											<th class="text-center">Time</th>
											<th class="text-center">Duration(M)</th>
											<th class="text-center">Total Question</th>
											<th class="text-center">Add Q.</th>
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
<script src="<?php echo VENDOR_URL; ?>datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo VENDOR_URL; ?>datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo VENDOR_URL; ?>notifications/notify.min.js"></script>
<script src="<?php echo VENDOR_URL; ?>notifications/notify-metro.js"></script>
<script src="<?php echo VENDOR_URL; ?>notifications/notifications.js"></script>
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>
<!-- KaTeX -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.9.0/katex.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.9.0/katex.min.js"></script>
<script src="<?php echo VENDOR_URL; ?>summernote/summernote-math.js"></script>
<script type="text/javascript" src="<?php echo VENDOR_URL; ?>jquery-multi-select/jquery.multi-select.js"></script>
<script type="text/javascript" src="<?php echo VENDOR_URL; ?>jquery-multi-select/jquery.quicksearch.js"></script>
<script>
	$(document).ready(function() {

		summernote();

		function summernote() {
			$('#syllabus').summernote({
				height: 200,
				toolbar: [
					// [groupName, [list of button]]
					['style', ['bold', 'italic', 'underline', 'clear']],
					['font', ['strikethrough', 'superscript', 'subscript']],
					['fontsize', ['fontsize']],
					['color', ['color']],
					['para', ['ul', 'ol', 'paragraph']],
					['height', ['height']],
					['insert', ['table']],
				]
			});
		}
		$("#model_test").on("submit", function(e) {
			e.preventDefault();
			var url = "<?php echo base_url() ?>modeltest/add";
			$.ajax({
				url: url,
				type: "post",
				dataType: "json",
				data: $(this).serialize(),
				beforeSend: function() {
					$("#overlay").fadeIn(300);
				},
				success: function(data) {
					if (data.msg == "success") {
						window.location.href = "<?php echo base_url() ?>modeltest/addquestion/" + data.id;
					} else {
						$.Notification.autoHideNotify('error', 'top right', data.msg);
						$("#overlay").fadeOut(300);
					}
				},
				error: function() {
					$("#overlay").fadeOut(300);
				}
			});
		});
		datatable();

		function datatable() {
			$('#datatable').dataTable({
				"info": false,
				"autoWidth": false
			});

		}
		get_view();

		function get_view() {
			$.ajax({
				url: "<?php echo base_url() ?>modeltest/view",
				type: "get",
				dataType: "json",
				data: {
					"subject": ""
				},
				success: function(data) {
					$('#datatable').DataTable().destroy();
					$("#datatable tbody").html(data);
					datatable();
				}
			});
		}

		$("#category_id").on("change", function() {
			var category_id = $(this).val();
			$.ajax({
				url: "<?php echo base_url() ?>ajax/get_subject_by_category",
				type: "get",
				dataType: "json",
				data: {
					"category_id": category_id
				},
				success: function(data) {
					$("#subject_id").find('option').remove();
					$.each(data, function(key, value) {
						$("#subject_id").append('<option value="' + value.id + '">' + value.name + '</option>');
					});
					$(".selectpicker").selectpicker('render').selectpicker('refresh');

					$('#subject_id').multiSelect("refresh");
				}
			});
		});

		$('#subject_id').multiSelect({
			selectableHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='Search...'>",
			selectionHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='Search...'>",
			afterInit: function(ms) {
				var that = this,
					$selectableSearch = that.$selectableUl.prev(),
					$selectionSearch = that.$selectionUl.prev(),
					selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
					selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

				that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
					.on('keydown', function(e) {
						if (e.which === 40) {
							that.$selectableUl.focus();
							return false;
						}
					});

				that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
					.on('keydown', function(e) {
						if (e.which == 40) {
							that.$selectionUl.focus();
							return false;
						}
					});
			},
			afterSelect: function() {
				this.qs1.cache();
				this.qs2.cache();
			},
			afterDeselect: function() {
				this.qs1.cache();
				this.qs2.cache();
			}
		});
	});
</script>
