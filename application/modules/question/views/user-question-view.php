<?php if(isset($all_question) && !empty($all_question)): ?>
    <?php foreach($all_question as $key=>$value):?>
        <tr>
            <td class="text-center"><?php echo ++$serial; ?></td>
            <td class="text-center"><?php echo $value['title']; ?></td>
            <td class="text-center"><?php echo $value['answer']; ?></td>
            <td class="text-center"><?php echo date("d-m-Y",strtotime($value['created_at'])); ?></td>
			<td class="text-center"><button type="button" class="btn btn-success btn-sm" id="details_modal" data-toggle="modal" data-id="<?= $value['id'] ?>" data-target="#con-close-modal"><i class="ion ion-android-drawer"></i></button></td>
            <td class="actions btn-group-xs text-center">
				<?php if (hasPermission("user_question", ADD)) : ?>
					<a onclick="return confirm('Are You Sure?')" href="<?php echo site_url("question/user_question_approve/" . $value['id']); ?>" title="Approved" class="text-success btn  btn-xs  waves-effect tooltips" data-placement="top" data-toggle="tooltip" data-original-title="View" id=""><i class="fa fa-check-circle"></i></a>
				<?php endif; ?>
				<?php if (hasPermission("user_question", DELETE)) : ?>
					<a onclick="return confirm('Are You Sure?')" href="<?php echo site_url("question/user_question_delete/" . $value['id']); ?>" title="Delete" class="text-danger btn btn-default  btn-xs  waves-effect tooltips" data-placement="top" data-toggle="tooltip" data-original-title="View" id=""><i class="fa fa-trash"></i></a>
				<?php endif; ?>
            </td>
        </tr>
    <?php endforeach;?>
	<tr>
		<td><strong>Total Data:</strong> <?= $total_rows ?></td>
		<td colspan="5" class="text-center">
				<?php echo $this->pagination->create_links(); ?>
		</td>
	</tr>
<?php else: ?>
	<tr>
		<td colspan="5" class="text-center">
				<h4 class="text-danger">No Question Found</h4>
		</td>
	</tr>
<?php endif; ?>

