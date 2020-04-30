<?php if(isset($all_question) && !empty($all_question)): ?>
    <?php foreach($all_question as $key=>$value):?>
        <tr>
            <td class="text-center"><?php echo ++$serial; ?></td>
            <td class="text-center"><?php echo $value['title']; ?></td>
			<td class="text-center"><button type="button" class="btn btn-success btn-sm" id="details_modal" data-toggle="modal" data-id="<?= $value['id'] ?>" data-target="#con-close-modal"><i class="ion ion-android-drawer"></i></button></td>
            <td class="actions btn-group-xs text-center">
				<form class="add_question">
					<input required type="hidden" value="<?= $model_test_id ?>" name="model_test_id">
					<input required type="hidden" value="<?= $value['id'] ?>" name="question_id">
					<input required type="hidden" value="<?= $value['subject_id'] ?>" name="subject_id">
					<input required type="hidden" value="<?= $value['section_id'] ?>" name="section_id">
					<input required type="hidden" value="<?= $value['topic_id'] ?>" name="topic_id">
					<button type="submit" class="btn btn-success btn-xs"><i class="fa fa-plus"></i></button>
				</form>
            </td>
        </tr>
    <?php endforeach;?>
	<tr>
		<td><strong>Total Data:</strong> <?= $total_rows ?></td>
		<td colspan="3" class="text-center">
				<?php echo $this->pagination->create_links(); ?>
		</td>
	</tr>
<?php else: ?>
	<tr>
		<td colspan="4" class="text-center">
				<h4 class="text-danger">No Question Found</h4>
		</td>
	</tr>
<?php endif; ?>

