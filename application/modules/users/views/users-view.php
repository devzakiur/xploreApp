<?php if(isset($all_users) && !empty($all_users)): ?>
    <?php foreach($all_users as $key=>$value):?>
        <tr>
            <td class="text-center"><?php echo ++$serial; ?></td>
            <td class="text-center"><?php echo $value['name']; ?></td>
            <td class="text-center"><?php echo $value['email']; ?></td>
            <td class="text-center"><?php echo $value['phone']; ?></td>
            <td class="actions btn-group-xs text-center">
				<?php if (hasPermission("users", DELETE)) : ?>
						<a onclick="return confirm('Are You Sure?')" href="<?php echo site_url("user/control/" . $value['id']); ?>" title="<?php echo $value['status']==1?"Active":"Block" ?>" class="text-<?php echo $value['status']==1?"success":"danger" ?> btn  btn-xs  waves-effect tooltips" data-placement="top" data-toggle="tooltip" data-original-title="View" id=""><i class="fa fa-check-circle"></i></a>
				<?php endif; ?>
            </td>
        </tr>
    <?php endforeach;?>
	<tr>
		<td><strong>Total Data:</strong> <?= $total_rows ?></td>
		<td colspan="6" class="text-center">
				<?php echo $this->pagination->create_links(); ?>
		</td>
	</tr>
<?php else: ?>
	<tr>
		<td colspan="6" class="text-center">
				<h4 class="text-danger">No Users Found</h4>
		</td>
	</tr>
<?php endif; ?>
