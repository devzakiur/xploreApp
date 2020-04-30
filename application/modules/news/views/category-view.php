<?php if(isset($all_category)): ?>
    <?php foreach($all_category as $key=>$value):?>
        <tr>
            <td class="text-center"><?php echo ++$key; ?></td>
            <td class="text-center"><?php echo $value['name']; ?></td>
            <td class="actions btn-group-xs text-center">
                <?php if (hasPermission("category", EDIT)) : ?>
                    <a title="Edit" href="<?php echo site_url("news/news_category_edit/" . $value['id']); ?>" class=" btn btn-default btn-xs  waves-effect tooltips" data-placement="top" data-toggle="tooltip" data-original-title="View"><i class="fa fa-edit"></i></a>
                <?php endif; ?>
                <?php if (hasPermission("category", DELETE)) : ?>
                <a onclick="return confirm('Are You Sure?')" href="<?php echo site_url("news/news_category_control/" . $value['id']); ?>" title="<?php echo $value['status']==1?"Enable":"Disable" ?>" class="text-<?php echo $value['status']==1?"info":"danger" ?> btn btn-default  btn-xs  waves-effect tooltips" data-placement="top" data-toggle="tooltip" data-original-title="View" id=""><i class="fa fa-check-circle"></i></a>
                <?php endif; ?>
                <?php if (is_super_admin()) : ?>
                <a onclick="return confirm('Are You Sure?')" href="<?php echo site_url("news/news_category_delete/" . $value['id']); ?>" title="Delete" class="text-danger btn btn-default  btn-xs  waves-effect tooltips" data-placement="top" data-toggle="tooltip" data-original-title="View" id=""><i class="fa fa-trash"></i></a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach;?>
<?php endif; ?>
