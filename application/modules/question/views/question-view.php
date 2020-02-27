<?php if(isset($all_question) && !empty($all_question)): ?>
    <?php foreach($all_question as $key=>$value):?>
        <tr>
            <td class="text-center"><?php echo ++$serial; ?></td>
            <td class="text-center"><?php echo $value['title']; ?></td>
            <td class="text-center"><?php echo $value['answer']; ?></td>
			<td class="text-center"><button type="button" class="btn btn-success btn-sm" id="details_modal" data-toggle="modal" data-id="<?= $value['id'] ?>" data-target="#con-close-modal"><i class="ion ion-android-drawer"></i></button></td>
            <td class="actions btn-group-xs text-center">
				<?php if (hasPermission("question", EDIT)) : ?>
						<a  href="<?php echo site_url("question/edit/" . $value['id']); ?>" title="Edit" class="text-info btn btn-default  btn-xs  waves-effect tooltips" data-placement="top" data-toggle="tooltip" data-original-title="Edit" id=""><i class="fa fa-edit"></i></a>
				<?php endif; ?>
				<?php if (hasPermission("question", DELETE)) : ?>
						<a onclick="return confirm('Are You Sure?')" href="<?php echo site_url("question/control/" . $value['id']); ?>" title="<?php echo $value['status']==1?"Approve":($value['status']==2?"Disable":"Pending") ?>" class="text-<?php echo $value['status']==1?"success":($value['status']==2?"danger":"info") ?> btn  btn-xs  waves-effect tooltips" data-placement="top" data-toggle="tooltip" data-original-title="View" id=""><i class="fa fa-check-circle"></i></a>
				<?php endif; ?>
				<?php if (is_super_admin()) : ?>
						<a onclick="return confirm('Are You Sure?')" href="<?php echo site_url("question/delete/" . $value['id']); ?>" title="Delete" class="text-danger btn btn-default  btn-xs  waves-effect tooltips" data-placement="top" data-toggle="tooltip" data-original-title="View" id=""><i class="fa fa-trash"></i></a>
				<?php endif; ?>
            </td>
        </tr>
    <?php endforeach;?>
	<tr>
		<td><strong>Total Data:</strong> <?= $total_rows ?></td>
		<td colspan="4" class="text-center">
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

