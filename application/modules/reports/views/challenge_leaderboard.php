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
