<?php if(isset($all_question) && !empty($all_question)): ?>
    <?php foreach($all_question as $key=>$value):?>
        <tr>
            <td class="text-center"><?php echo ++$serial; ?></td>
            <td class="text-center"><?php echo $value['title']; ?></td>
			<td class="text-center"><button type="button" class="btn btn-success btn-sm" id="details_modal" data-toggle="modal" data-id="<?= $value['question_id'] ?>" data-target="#con-close-modal"><i class="ion ion-android-drawer"></i></button></td>
            <td class="actions btn-group-xs text-center">
				<form class="delete_question">
					<input required type="hidden" value="<?= $value['model_question_id'] ?>" name="model_question_id">
					<button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
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

