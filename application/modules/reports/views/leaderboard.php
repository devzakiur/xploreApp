<div class="content">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="panel">
					<div class="panel-body">
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
										<?php if (isset($all_leaderboard)) : ?>
											<?php foreach ($all_leaderboard as $key => $value) : ?>
												<tr>
													<td><?= ++$serial ?></td>
													<td><span id="user_details_modal" class="text-success user_details_modal" data-toggle="modal" data-id="<?= $value['user_id'] ?>" data-target="#con-close-user-modal"><?php echo $value['name']; ?></span></td>
													<td><?= $value['correct_question'] ?></td>
													<td><?= $value['wrong_question'] ?></td>
													<td><?= $value['unanswer_question'] ?></td>
													<td><?= formatMilliseconds($value['total_time']) ?></td>
													<td><?= $value['get_point'] ?></td>
												</tr>
											<?php endforeach ?>
											<td colspan="7" class="text-center">
												<?php echo $this->pagination->create_links(); ?>
											</td>
										<?php endif ?>
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
<script>
	$(document).ready(function() {
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
