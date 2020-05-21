<div class="content">
	<div class="container">
		<?php echo $this->session->flashdata("msg"); ?>
		<?php if (hasPermission("library", ADD)) : ?>
			<?php if (isset($add)) : ?>
				<div class="row">
					<div class="col-sm-12">
						<div class="panel-group" id="accordion-test-2">
							<div class="panel panel-border panel-info">
								<div class="panel-heading">
									<h3 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion-test-2" href="#collapseOne-2" aria-expanded="false" class="collapsed">
											Manage Library
										</a>
									</h3>
								</div>
								<div id="collapseOne-2" class="panel-collapse collapse">
									<div class="panel-body">
										<form id="library_add" enctype="multipart/form-data">
											<div class="row">
												<div class="col-sm-3">
													<div class="form-group">
														<label for="subject_id">Subject</label>
														<select id="subject_id" name="subject_id" class="form-control selectpicker" data-cotainer="body" data-live-search="true">
															<option value="">--Select--</option>
															<?php if (count($subject) > 0) : ?>
																<?php foreach ($subject as $value) : ?>
																	<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
																<?php endforeach; ?>
															<?php endif; ?>
														</select>
													</div>
												</div>
												<div class="col-sm-3">
													<div class="form-group">
														<label for="section_id">Section</label>
														<select id="section_id" name="section_id" class="form-control selectpicker" data-cotainer="body" data-live-search="true">
															<option value="">--Select--</option>
														</select>
													</div>
												</div>
												<div class="col-sm-3">
													<div class="form-group">
														<label for="topic_id">Topic</label><small class="req"> *</small>
														<select id="topic_id" required name="topic_id" class="form-control selectpicker" data-cotainer="body" data-live-search="true">
															<option value="">--Select--</option>
															<?php if (count($topic) > 0) : ?>
																<?php foreach ($topic as $value) : ?>
																	<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
																<?php endforeach; ?>
															<?php endif; ?>
														</select>
													</div>
												</div>
												<div class="col-sm-3">
													<div class="form-group">
														<label for="category_id">Category</label><small class="req"> *</small>
														<select id="category_id" required name="category_id[]" class="form-control selectpicker" multiple data-cotainer="body" data-live-search="true">
														</select>
													</div>
												</div>
												<div class="col-sm-8">
													<div class="form-group">
														<label for="title">Title</label><small class="req"> *</small>
														<input type="text" name="title" placeholder="Title" class="form-control" required id="title">
													</div>
												</div>
												<div class="col-sm-2">
													<div class="form-group">
														<label for="name">Position</label><small class="req"> *</small>
														<input type="number" name="position" placeholder="Position" class="form-control" required id="position">
													</div>
												</div>
												<div class="col-sm-2">
													<div class="form-group">
														<label for="is_math">Is Math?</label><small class="req"> *</small>
														<select id="is_math" required name="is_math" class="form-control selectpicker">
															<option value="">--Select--</option>
															<option value="1">Yes</option>
															<option value="0">No</option>
														</select>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label for="details">Details</label><small class="req"> *</small> <a target="_blank" class="btn btn-success btn-xs" href="https://en.wikipedia.org/wiki/List_of_mathematical_symbols">Mathematics Symbol</a>
														<textarea name="details" id="details" class="form-control"></textarea>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label for="gist">Gist</label> <a target="_blank" class="btn btn-success btn-xs" href="https://en.wikipedia.org/wiki/List_of_mathematical_symbols">Mathematics Symbol</a>
														<textarea name="gist" id="gist" class="form-control"></textarea>
													</div>
												</div>
												<div class="col-sm-12">
													<div class="form-group">
														<label for="library_link">Library External Link</label>
														<textarea name="library_link" id="library_link" class="form-control"></textarea>
													</div>
												</div>
												<div class="col-sm-12">
													<code>Please Note** Image#1 will be always considered as Cover Image</code>
												</div>
												<div class="col-sm-6">
													<div id="video_part">
														<div class="col-sm-6">
															<div class="form-group">
																<label for="video_title">Video Title</label>
																<input type="text" name="video_title[]" class="form-control" id="video_title" placeholder="Enter Title">
															</div>
														</div>
														<div class="col-sm-6">
															<div class="form-group">
																<label for="code">Video Url</label>
																<div class="input-group">
																	<input type="text" name="video_url[]" class="form-control" id="code" placeholder="https://www.youtube.com/embed/BYkNJOkbWSM">
																	<div class="input-group-btn">
																		<button class="btn btn-info" id="youtube_add_button" type="button">
																			<i class="md md-add"></i>
																		</button>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="col-sm-6">
													<div id="image_part">
														<div class="col-sm-6">
															<div class="form-group">
																<label for="slide_picture_title">Image Title</label>
																<input type="text" name="slide_picture_title[]" class="form-control" placeholder="Image Title" id="slide_picture_title">
															</div>
														</div>
														<div class="col-sm-6">
															<div class="form-group">
																<label for="slide_picture">Slide Image</label>
																<div class="input-group">
																	<input type="file" name="slide_picture[]" data-max-file-size="500K" data-allowed-file-extensions="jpg png" id="slide_picture">
																	<div class="input-group-btn">
																		<button class="btn btn-info" id="image_add_button" type="button">
																			<i class="md md-add"></i>
																		</button>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="col-sm-12">
													<div class="form-group m-t-22 pull-right m-l-15 ">
														<button name="add_user" type="submit" class="btn btn-primary"><i class="md md-add m-r-5"></i>Add</button>
													</div>
												</div>
											</div>
										</form>
									</div> <!-- panel-body -->
								</div>
							</div> <!-- panel -->
						</div>
					</div> <!-- col -->
				</div> <!-- End row -->
			<?php endif; ?>
		<?php endif; ?>
		<?php if (hasPermission("library", EDIT)) : ?>
			<?php if (isset($edit)) : ?>
				<div class="row">
					<div class="col-sm-12">
						<div class="panel-group" id="accordion-test-2">
							<div class="panel panel-border panel-info">
								<div class="panel-heading">
									<h3 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion-test-2" href="#collapseOne-2" aria-expanded="false">
											Manage Library
										</a>
									</h3>
								</div>
								<div id="collapseOne-2" class="panel-collapse collapse in">
									<div class="panel-body">
										<!-- <form id="find"> -->
										<?php echo form_open_multipart("library/edit/" . $single['id']); ?>
										<div class="row">
											<div class="col-sm-3">
												<div class="form-group">
													<label for="subject_id">Subject</label>
													<select id="subject_id" name="subject_id" class="form-control selectpicker" data-cotainer="body" data-live-search="true">
														<option value="">--Select--</option>
														<?php if (count($subject) > 0) : ?>
															<?php foreach ($subject as $value) : ?>
																<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
															<?php endforeach; ?>
														<?php endif; ?>
													</select>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label for="section_id">Section</label>
													<select id="section_id" name="section_id" class="form-control selectpicker" data-cotainer="body" data-live-search="true">
														<option value="">--Select--</option>
													</select>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label for="topic_id">Topic</label><small class="req"> *</small>
													<select id="topic_id" required name="topic_id" class="form-control selectpicker" data-cotainer="body" data-live-search="true">
														<option value="">--Select--</option>
														<?php if (count($topic) > 0) : ?>
															<?php foreach ($topic as $value) : ?>
																<option <?php if ($single['topic_id'] == $value['id']) echo "selected" ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
															<?php endforeach; ?>
														<?php endif; ?>
													</select>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label for="category_id">Category</label><small class="req"> *</small>
													<select id="category_id" required name="category_id[]" class="form-control selectpicker" multiple data-cotainer="body" data-live-search="true">
														<?php if (count($category) > 0) : ?>
															<?php foreach ($category as $value) : ?>
																<option <?php if ($single['topic_id'] == $value['id']) echo "selected" ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
															<?php endforeach; ?>
														<?php endif; ?>
													</select>
												</div>
											</div>
											<div class="col-sm-8">
												<div class="form-group">
													<label for="title">Title</label><small class="req"> *</small>
													<input type="text" name="title" value="<?= $single['title'] ?>" placeholder="Title" class="form-control" required id="title">
													<input type="hidden" name="id" value="<?= $single['id'] ?>">
												</div>
											</div>
											<div class="col-sm-2">
												<div class="form-group">
													<label for="name">Position</label><small class="req"> *</small>
													<input type="number" name="position" placeholder="Position" value="<?= $single['position'] ?>" class="form-control" required id="position">
												</div>
											</div>
											<div class="col-sm-2">
												<div class="form-group">
													<label for="is_math">Is Math?</label><small class="req"> *</small>
													<select id="is_math" required name="is_math" class="form-control selectpicker">
														<option value="">--Select--</option>
														<option <?php if ($single["is_math"] == 1) echo "selected" ?> value="1">Yes</option>
														<option <?php if ($single["is_math"] == 0) echo "selected" ?> value="0">No</option>
													</select>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label for="details">Details</label><small class="req"> *</small> <a target="_blank" class="btn btn-success btn-xs" href="https://en.wikipedia.org/wiki/List_of_mathematical_symbols">Mathematics Symbol</a>
													<textarea name="details" id="details" class="form-control"><?= $single['details'] ?></textarea>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label for="gist">Gist</label> <a target="_blank" class="btn btn-success btn-xs" href="https://en.wikipedia.org/wiki/List_of_mathematical_symbols">Mathematics Symbol</a>
													<textarea name="gist" id="gist" class="form-control"><?= $single['gist'] ?></textarea>
												</div>
											</div>
											<div class="col-sm-12">
												<div class="form-group">
													<label for="library_link">Library External Link</label>
													<textarea name="library_link" id="library_link" class="form-control"><?= $single['library_link'] ?></textarea>
												</div>
											</div>
											<div class="col-sm-12">
												<code>Please Note** Image#1 will be always considered as Cover Image</code>
											</div>
											<div class="col-sm-6">
												<div id="video_part">
													<?php if (!empty($video_code)) : ?>
														<?php foreach ($video_code as $key => $value) : ?>
															<div class="video_append">
																<div class="col-sm-6">
																	<div class="form-group">
																		<label for="video_title">Video Title</label>
																		<input type="text" name="video_title[]" value="<?= $value['video_title'] ?>" class="form-control" id="video_title" placeholder="Enter Title">
																	</div>
																</div>
																<div class="col-sm-6">
																	<div class="form-group">
																		<label for="code">Video</label>
																		<div class="input-group">
																			<input type="text" name="video_url[]" value="<?= $value['video_url'] ?>" class="form-control" id="code" placeholder="https://www.youtube.com/embed/BYkNJOkbWSM">
																			<div class="input-group-btn">
																				<?php if ($key == 0) : ?>
																					<button class="btn btn-info" id="youtube_add_button" type="button">
																						<i class="md md-add"></i>
																					</button>
																				<?php else : ?>
																					<button class="btn btn-info btn-danger youtube_remove_button" id="" type="button">
																						<i class="fa fa-minus"></i>
																					</button>
																				<?php endif; ?>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														<?php endforeach; ?>
													<?php else : ?>
														<div class="col-sm-6">
															<div class="form-group">
																<label for="video_title">Video Title</label>
																<input type="text" name="video_title[]" class="form-control" id="video_title" placeholder="Enter Title">
															</div>
														</div>
														<div class="col-sm-6">

															<div class="form-group">
																<label for="code">Video Url</label>
																<div class="input-group">
																	<input type="text" name="video_url[]" class="form-control" id="code" placeholder="https://www.youtube.com/embed/BYkNJOkbWSM">
																	<div class="input-group-btn">
																		<button class="btn btn-info" id="youtube_add_button" type="button">
																			<i class="md md-add"></i>
																		</button>
																	</div>
																</div>
															</div>
														</div>
													<?php endif; ?>
												</div>
											</div>
											<div class="col-sm-6">
												<div id="image_part">
													<?php if (!empty($image_slide)) : ?>
														<?php foreach ($image_slide as $key => $value) : ?>
															<div class="image_append" id="<?= $value['id'] ?>">
																<div class="col-sm-6">
																	<div class="form-group">
																		<label for="slide_picture_title">Image Title</label>
																		<input type="text" name="slide_picture_title[]" value="<?= $value['slide_picture_title'] ?>" class="form-control" placeholder="Image Title" id="slide_picture_title">
																	</div>
																</div>
																<div class="col-sm-6">
																	<div class="form-group">
																		<label for="code">Slide Image</label>
																		<div class="input-group">
																			<input type="file" name="slide_picture[]" data-default-file="<?= base_url() . $value['picture'] ?>" data-max-file-size="500K" data-allowed-file-extensions="jpg png" id="slide_picture">
																			<input type="hidden" name="slide_picture_name[]" class="slide_picture_<?= $value['id'] ?>" value="<?= $value['picture'] ?>">
																			<input type="hidden" name="slide_picture_id[]" class="slide_picture_id_<?= $value['id'] ?>" value="<?= $value['id'] ?>">
																			<div class="input-group-btn">
																				<?php if ($key == 0) : ?>
																					<button class="btn btn-info" id="image_add_button" type="button">
																						<i class="md md-add"></i>
																					</button>
																				<?php else : ?>
																					<button class="btn btn-info btn-danger image_remove_button" id="" type="button">
																						<i class="fa fa-minus"></i>
																					</button>
																				<?php endif; ?>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														<?php endforeach; ?>
													<?php else : ?>
														<div class="col-sm-6">
															<div class="form-group">
																<label for="slide_picture_title">Image Title</label>
																<input type="text" name="slide_picture_title[]" class="form-control" placeholder="Image Title" id="slide_picture_title">
															</div>
														</div>
														<div class="col-sm-6">
															<div class="form-group">
																<label for="slide_picture">Slide Image</label>
																<div class="input-group">
																	<input type="file" name="slide_picture[]" data-max-file-size="500K" data-allowed-file-extensions="jpg png" id="slide_picture">
																	<div class="input-group-btn">
																		<button class="btn btn-info" id="image_add_button" type="button">
																			<i class="md md-add"></i>
																		</button>
																	</div>
																</div>
															</div>
														</div>
													<?php endif; ?>
												</div>
											</div>
											<div class="col-sm-12">
												<div class="form-group m-t-22 pull-right m-l-15 ">
													<button name="add_user" type="submit" class="btn btn-info"><i class="md md-add m-r-5"></i>Update</button>
												</div>
											</div>
										</div>
										</form>
									</div> <!-- panel-body -->
								</div>
							</div> <!-- panel -->
						</div>
					</div> <!-- col -->
				</div> <!-- End row -->
			<?php endif; ?>
		<?php endif; ?>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-border panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Topic Relation</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<table id="topic_realtion" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th class="text-center">Category Name</th>
											<th class="text-center">Subject Name</th>
											<th class="text-center">Section Name</th>
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
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-border panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Lbrary View</h3>
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
							<div class="col-md-3 m-b-10 pull-left">
								<div class="">
									<div class="col-md-12 m-b-10 pull-right">
										<div class="form-group">
											<label for="filter_by">Filter By</label>
											<select id="filter_by" name="filter_by" class="form-control selectpicker">
												<option value="">All</option>
												<option value="0">Pending</option>
												<option value="1">Approved</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3 m-b-10">
								<div class="form-group">
									<label for="created_by">Created By</label>
									<select id="created_by" name="created_by" class="form-control selectpicker">
										<option value="">All</option>
										<?php foreach ($users as $value) : ?>
											<option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="col-md-4 m-b-10 pull-right  m-t-22">
								<div class="">
									<div class="col-md-12 m-b-10 pull-right">
										<div class="input-group">
											<input type="text" name="search_key" placeholder="Search Library Title Or Topic Or Category" id="search_key" class="form-control">
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
									<table id="library" class="table table-striped table-bordered">
										<thead>
											<tr>
												<th class="text-center">Sl.</th>
												<th class="text-center">Category</th>
												<th class="text-center">Topic</th>
												<th class="text-center">Title</th>
												<th class="text-center">Details</th>
												<th class="text-center">Edit History</th>
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
				<h4 class="modal-title">Library View</h4>
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
<div id="history-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<!-- <form id="item_add"> -->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Library History View</h4>
			</div>
			<div class="modal-body">
				<div id="history_show_details">

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div><!-- /.modal -->
<script src="<?php echo VENDOR_URL; ?>notifications/notify.min.js"></script>
<script src="<?php echo VENDOR_URL; ?>notifications/notify-metro.js"></script>
<script src="<?php echo VENDOR_URL; ?>notifications/notifications.js"></script>
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>

<!-- KaTeX -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.9.0/katex.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.9.0/katex.min.js"></script>
<script src="<?php echo VENDOR_URL; ?>summernote/summernote-math.js"></script>
<script>
	$(document).ready(function() {
		<?php if (isset($add)) : ?>
			last_order_position();
		<?php endif; ?>

		function last_order_position() {
			$.get("<?php echo base_url() ?>ajax/get_last_order_position?table_name=library", function(data, status) {
				$("#position").val(data);
			});
		}
		summernote();

		function summernote() {
			$('#details,#gist,#library_link').summernote({
				height: 200,
				toolbar: [
					// [groupName, [list of button]]
					['style', ['bold', 'italic', 'underline', 'clear']],
					['font', ['strikethrough', 'superscript', 'subscript']],
					['fontsize', ['fontsize']],
					['color', ['color']],
					['para', ['ul', 'ol', 'paragraph']],
					['height', ['height']],
					['insert', ['link', 'picture', 'video', 'math', 'table']],
				]
			});
		}
		$("#library_add").on("submit", function(e) {
			e.preventDefault();
			if ($("#details").summernote("isEmpty")) {
				$.Notification.autoHideNotify('error', 'top right', "Details Required");
				return false;
			}
			var url = "<?php echo base_url() ?>library/add";
			$.ajax({
				url: url,
				type: "post",
				data: new FormData(this),
				dataType: 'json',
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function() {
					$("#overlay").fadeIn(300);
				},
				success: function(data) {
					if (data.msg == "success") {
						$.Notification.autoHideNotify('success', 'top right', data.success);
						$("input").val('');
						$("#details").summernote('reset');
						$("#gist").summernote('reset');
						$("#details").summernote('destroy');
						$("#gist").summernote('destroy');
						$(".video_append").remove();
						$(".image_append").remove();
						$('.dropify-clear').click();
						last_order_position();
						summernote();
					} else {
						$.Notification.autoHideNotify('error', 'top right', data.msg);
					}
					get_view();
					$("#overlay").fadeOut(300);
				},
				error: function() {
					$.Notification.autoHideNotify('error', 'top right', "Something Wrong. Please try again");
					$("#overlay").fadeOut(300);
				}
			});
		});
		$('.dropify-clear').on("click", function() {
			var id = $(this).closest('.image_append').attr("id");
			$("slide_picture_" + id).val("");
		});

		///subject id change
		$("#subject_id").on("change", function() {
			var subject_id = $(this).val();
			$.ajax({
				url: "<?php echo base_url() ?>ajax/get_section_by_subject",
				type: "get",
				dataType: "json",
				data: {
					"subject_id": subject_id
				},
				success: function(data) {
					$("#section_id").find('option').remove();
					$("#section_id").append('<option value="">--Select--</option>');
					$.each(data, function(key, value) {
						$("#section_id").append('<option value="' + value.id + '">' + value.name + '</option>');
					});
					$(".selectpicker").selectpicker('render').selectpicker('refresh');
				}
			});
		});
		$("#section_id").on("change", function() {
			var section_id = $(this).val();
			$.ajax({
				url: "<?php echo base_url() ?>ajax/get_topic_by_section",
				type: "get",
				dataType: "json",
				data: {
					"section_id": section_id
				},
				success: function(data) {
					$("#topic_id").find('option').remove();
					$("#topic_id").append('<option value="">--Select--</option>');
					$.each(data, function(key, value) {
						$("#topic_id").append('<option value="' + value.id + '">' + value.name + '</option>');
					});
					$(".selectpicker").selectpicker('render').selectpicker('refresh');
				}
			});
		});
		$("#topic_id").on("change", function() {
			var topic_id = $("#topic_id").val();
			$.ajax({
				url: "<?php echo base_url() ?>library/topic_relation",
				type: "get",
				dataType: "json",
				data: {
					"topic_id": topic_id
				},
				success: function(data) {
					$("#topic_realtion tbody").html(data.html_data);
					$("#category_id").find('option').remove();
					$("#category_id").selectpicker("refresh");
					if (data.category_data != '') {
						$.each(data.category_data, function(key, value) {
							$("#category_id").append('<option value="' + value.id + '">' + value.name + '</option>');
						});
						$("#category_id").selectpicker('render').selectpicker('refresh');
					}
				}
			});
		});
		$("#search_key").on("change", function() {
			get_view(false);
			return false;
		});
		$("#filter_by,#created_by").on("change", function() {
			get_view(false);
			return false;
		});
		$("#library").on("click", '.pagination li a', function() {
			var page_url = $(this).attr("href");
			if (page_url == "javascript:void(0)") {
				return false;
			}
			get_view(page_url);
			return false;
		});
		get_view(false);

		function get_view(page_url) {
			var category_id = $("#search_category_id").val();
			var subject_id = $("#search_subject_id").val();
			var section_id = $("#search_section_id").val();
			var topic_id = $("#search_topic_id").val();
			var filter_by = $("#filter_by").val();
			var search_key = $("#search_key").val();
			var created_by = $("#created_by").val();
			var base_url = "<?php echo base_url() ?>library/view";
			if (page_url) {
				base_url = page_url;
			}
			$.ajax({
				url: base_url,
				type: "get",
				dataType: "json",
				data: {
					"search_key": search_key,
					"created_by": created_by,
					"filter_by": filter_by,
					"category_id": category_id,
					"subject_id": subject_id,
					"section_id": section_id,
					"topic_id": topic_id
				},
				beforeSend: function() {
					$("#library_loading").fadeIn(300);
				},
				success: function(data) {
					$("#library tbody").html(data);
					$("#library_loading").fadeOut(300);
				},
				error: function(e) {
					$("#library_loading").fadeOut(300);
				}
			});
		}


		$("#library").on("click", "#details_modal", function() {
			var library_id = $(this).data("id");
			$.ajax({
				url: "<?php echo base_url() ?>library/details_view",
				type: "get",
				dataType: "json",
				data: {
					"library_id": library_id
				},
				beforeSend: function() {
					$("#overlay").fadeIn(300);
				},
				success: function(data) {
					$("#show_details").html(data);
					$("#overlay").fadeOut(300);
				},
				error: function(e) {
					$.Notification.autoHideNotify('error', 'top right', "Something Wrong. Please try again");
					$("#overlay").fadeOut(300);
				}
			});
		});
		$("#library").on("click", "#history_details_modal", function() {
			var library_id = $(this).data("id");
			$.ajax({
				url: "<?php echo base_url() ?>library/history_details_view",
				type: "get",
				dataType: "json",
				data: {
					"library_id": library_id
				},
				beforeSend: function() {
					$("#overlay").fadeIn(300);
				},
				success: function(data) {
					$("#history_show_details").html(data);
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
		$("#search_topic_id").on("change", function() {
			get_view(false);
		});
	});
</script>

<script>
	$(document).ready(function() {
		var maxField = 10; //Input fields increment limitation
		var addButton = $('#youtube_add_button'); //Add button selector
		var wrapper = $('#video_part'); //Input field wrapper
		var row = "";
		row += '<div class="video_append">';
		row += '<div class="col-sm-6">';
		row += '<div class="form-group">';
		row += '<label for="video_title">Video Title</label>';
		row += '<input type="text" name="video_title[]" class="form-control" id="video_title" placeholder="Enter Title">';
		row += '</div>';
		row += '</div>';
		row += '<div class="col-sm-6">';
		row += '<div class="form-group">';
		row += '<label for="library_video">Video Url</label><small class="req"> *</small>';
		row += '<div class="input-group">';
		row += '<input type="text" name="video_url[]" required class="form-control" placeholder="https://www.youtube.com/embed/BYkNJOkbWSM">';
		row += '<div class="input-group-btn">';
		row += '<button class="btn btn-danger youtube_remove_button" id="" type="button">';
		row += '<i class="fa fa-minus"></i>';
		row += '</button>';
		row += '</div>';
		row += '</div>';
		row += '</div>';
		row += '</div>';
		row += '</div>';
		<?php if (isset($edit)) : ?>
			var x = <?= count($video_code)  ?>; //Initial field counter is 1
		<?php else : ?>
			var x = 1; //Initial field counter is 1
		<?php endif; ?>

		//Once add button is clicked
		$(addButton).click(function() {
			//Check maximum number of input fields
			if (x < maxField) {
				x++; //Increment field counter
				$(wrapper).append(row); //Add field html
			}

		});

		//Once remove button is clicked
		$(wrapper).on('click', '.youtube_remove_button', function(e) {
			e.preventDefault();
			$(this).closest('.video_append').remove(); //Remove field html
			$(".selectpicker").selectpicker('render').selectpicker('refresh');
			x--; //Decrement field counter
		});
	});
</script>

<script>
	$(document).ready(function() {
		var maxField = 10; //Input fields increment limitation
		var addButton = $('#image_add_button'); //Add button selector
		var wrapper = $('#image_part'); //Input field wrapper
		var row = "";
		row += '<div class="image_append">';
		row += '<div class="col-sm-6">';
		row += '<div class="form-group">';
		row += '<label for="slide_picture_title">Image Title</label>';
		row += '<input type="text" name="slide_picture_title[]" class="form-control" placeholder="Image Title" id="slide_picture_title" >';
		row += '</div>';
		row += '</div>';
		row += '<div class="col-sm-6">';
		row += '<div class="form-group">';
		row += '<label for="slide_picture">Slide Image</label><small class="req"> *</small>';
		row += '<div class="input-group">';
		row += '<input type="file" name="slide_picture[]" data-max-file-size="500K" data-allowed-file-extensions="jpg png" required id="slide_picture" class="">';
		row += '<div class="input-group-btn">';
		row += '<button class="btn btn-danger image_remove_button" id="" type="button">';
		row += '<i class="fa fa-minus"></i>';
		row += '</button>';
		row += '</div>';
		row += '</div>';
		row += '</div>';
		row += '</div>';
		row += '</div>';
		<?php if (isset($edit)) : ?>
			var x = <?= count($image_slide)  ?>; //Initial field counter is 1
		<?php else : ?>
			var x = 1; //Initial field counter is 1
		<?php endif; ?>

		//Once add button is clicked
		$(addButton).click(function() {
			//Check maximum number of input fields
			if (x < maxField) {
				x++; //Increment field counter
				$(wrapper).append(row); //Add field html
			}
			$(':file').dropify();
		});

		//Once remove button is clicked
		$(wrapper).on('click', '.image_remove_button', function(e) {
			e.preventDefault();
			$(this).closest('.image_append').remove(); //Remove field html
			$(".selectpicker").selectpicker('render').selectpicker('refresh');
			x--; //Decrement field counter
		});
	});
</script>
<?php if (isset($edit)) : ?>
	<script>
		$(document).ready(function() {
			var category = "<?= $single['category_id'] ?>"
			var category_split_data = category.split(",");
			$('#category_id option').each(function() {
				if (jQuery.inArray($(this).val(), category_split_data) !== -1) {
					this.selected = true;
				}
			});
			$(".selectpicker").selectpicker('render').selectpicker('refresh');

		});
	</script>
<?php endif; ?>
