<?php if(isset($all_notification)): ?>
    <?php foreach($all_notification as $key=>$value):?>
        <tr>
            <td class="text-center"><?php echo ++$key; ?></td>
            <td class="text-center"><?php echo $value['category_name']; ?></td>
            <td class="text-center"><?php echo $value['title']; ?></td>
            <td class="text-center"><?php echo textshorten(html_entity_decode(strip_tags($value['details']))); ?></td>
            <td class="text-center"><?php echo date("d-m-Y h:i a",strtotime($value['created_at'])); ?></td>
            <td class="actions btn-group-xs text-center">
                <?php if (hasPermission("notification", EDIT)) : ?>
                    <a title="Edit" href="<?php echo site_url("notification/edit/" . $value['id']); ?>" class=" btn btn-default btn-xs  waves-effect tooltips" data-placement="top" data-toggle="tooltip" data-original-title="View"><i class="fa fa-edit"></i></a>
                <?php endif; ?>
                <?php if (hasPermission("notification", DELETE)) : ?>
                <a onclick="return confirm('Are You Sure?')" href="<?php echo site_url("notification/delete/" . $value['id']); ?>" title="Delete" class="text-danger btn btn-default  btn-xs  waves-effect tooltips" data-placement="top" data-toggle="tooltip" data-original-title="View" id=""><i class="fa fa-trash"></i></a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach;?>
<?php endif; ?>
