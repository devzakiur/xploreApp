<?php if (isset($all_question_report) && !empty($all_question_report)) : ?>
	<?php foreach ($all_question_report as $key => $value) : ?>
		<tr id="<?= $value['id'] ?>">
			<td class="text-center"><?php echo ++$serial; ?></td>
			<td class="text-center"><span id="user_details_modal" class="text-success user_details_modal" data-toggle="modal" data-id="<?= $value['user_id'] ?>" data-target="#con-close-user-modal"><?php echo $value['user_name']; ?></span></td>
			<td class="text-center"><?php echo $value['title']; ?></td>
			<td class="text-center"><?php echo $value['type']; ?><p id="details" style="display: none"><?= $value['details'] ?></p>
			</td>
			<td class="text-center"><button type="button" class="btn btn-success btn-sm" id="details_modal" data-toggle="modal" data-id="<?= $value['id'] ?>" data-target="#con-close-modal"><i class="ion ion-android-drawer"></i></button></td>
			<td class="text-center"><?php echo $value['created_at']; ?></td>
			<td class="actions btn-group-xs text-center">
				<?php if (hasPermission("report_question", ADD)) : ?>
					<a onclick="return confirm('Are You Sure?')" href="<?php echo site_url("question/report_question_approve/" . $value['id']); ?>" title="View" class="text-<?php echo $value['status'] == 1 ? "success" : "pink"; ?> btn  btn-xs  waves-effect tooltips" data-placement="top" data-toggle="tooltip" data-original-title="View" id=""><i class="fa fa-check-circle"></i></a>
				<?php endif; ?>
				<?php if (is_admin() || is_super_admin()) : ?>
					<a onclick="return confirm('Are You Sure?')" href="<?php echo site_url("question/report_question_delete/" . $value['id']); ?>" title="Delete" class="text-danger btn btn-default  btn-xs  waves-effect tooltips" data-placement="top" data-toggle="tooltip" data-original-title="View" id=""><i class="fa fa-trash"></i></a>
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
	<tr>
		<td><strong>Total Data:</strong> <?= $total_rows ?></td>
		<td colspan="5" class="text-center">
			<?php echo $this->pagination->create_links(); ?>
		</td>
	</tr>
<?php else : ?>
	<tr>
		<td colspan="5" class="text-center">
			<h4 class="text-danger">No Question Error Found</h4>
		</td>
	</tr>
<?php endif; ?>
