<?php if(isset($all_user)): ?>
    <?php foreach($all_user as $key=>$value):?>
        <tr>
            <td class="text-center"><?php echo ++$key; ?></td>
            <td class="text-center"><?php echo $value['name']; ?></td>
            <td class="text-center"><?php echo $value['role_name']; ?></td>
            <td class="text-center"><?php echo $value['username']; ?></td>
            <td class="text-center"><?php echo $value['phone']; ?></td>
            <td class="text-center"><?php echo date("d-m-Y",strtotime($value['created_at'])); ?></td>
            <td class="actions btn-group-xs text-center">
                <?php if (hasPermission("manage_user", EDIT)) : ?>
                    <a title="Edit" href="<?php echo site_url("administrator/users/edit/" . $value['admin_id']); ?>" class=" btn btn-default btn-xs  waves-effect tooltips" data-placement="top" data-toggle="tooltip" data-original-title="View"><i class="fa fa-edit"></i></a>
                <?php endif; ?>
                <?php if (hasPermission("manage_user", DELETE)) : ?>
                <a onclick="return confirm('Are You Sure?')" href="<?php echo site_url("administrator/users/control/" . $value['admin_id']); ?>" title="<?php echo $value['status']==1?"Enable":"Disable" ?>" class="text-<?php echo $value['status']==1?"info":"danger" ?> btn btn-default  btn-xs  waves-effect tooltips" data-placement="top" data-toggle="tooltip" data-original-title="View" id=""><i class="fa fa-check-circle"></i></a>
                <?php endif; ?>
                <?php if (is_super_admin()) : ?>
                <a onclick="return confirm('Are You Sure?')" href="<?php echo site_url("administrator/users/delete/" . $value['admin_id']); ?>" title="Delete" class="text-danger btn btn-default  btn-xs  waves-effect tooltips" data-placement="top" data-toggle="tooltip" data-original-title="View" id=""><i class="fa fa-trash"></i></a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach;?>
<?php endif; ?>
