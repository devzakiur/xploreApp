<?php if(isset($assign_subject)): ?>
    <?php foreach($assign_subject as $key=>$value):?>
        <tr>
            <td class="text-center"><?php echo ++$key; ?></td>
            <td class="text-center"><?php echo $value['subject_name']; ?></td>
            <td class="text-center"><?php echo $value['category_name']; ?></td>
			<?php if (hasPermission("subject_assign", DELETE)) : ?>
				<td class="actions btn-group-xs text-center">
					<a onclick="return confirm('Are You Sure?')" href="<?php echo site_url("subject/subject_assign_delete/" . $value['subject_id']); ?>" title="Delete" class="text-danger btn btn-default  btn-xs  waves-effect tooltips" data-placement="top" data-toggle="tooltip" data-original-title="View" id=""><i class="fa fa-trash"></i></a>
				</td>
			<?php endif; ?>
        </tr>
    <?php endforeach;?>
<?php endif; ?>
