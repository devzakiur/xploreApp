<?php if(isset($all_modeltest)): ?>
    <?php foreach($all_modeltest as $key=>$value):?>
        <tr>
            <td class="text-center"><?php echo ++$key; ?></td>
            <td class="text-center"><?php echo $value['category_name']; ?></td>
            <td class="text-center"><?php echo $value['title']; ?></td>
            <td class="text-center"><?php echo date("d-m-Y",strtotime($value['date'])); ?></td>
            <td class="text-center"><?php echo date("h:i A",strtotime($value['date'])); ?></td>
            <td class="text-center"><?php echo $value['duration']; ?></td>
            <td class="text-center"><?php echo $value['total_question']; ?></td>
            <td class="text-center">
                <?php if($value['status']==0): ?>
                <a title="Add Question" href="<?php echo site_url("modeltest/addquestion/" . $value['id']); ?>" class=" btn btn-primary btn-xs  waves-effect tooltips" data-placement="top" data-toggle="tooltip" data-original-title="View"><i class="fa fa-plus"></i></a>
                <?php endif; ?>
			</td>
            <td class="actions btn-group-xs text-center">
                <?php if (hasPermission("model_test", EDIT) && $value['status']==0) : ?>
                    <a title="Edit" href="<?php echo site_url("modeltest/edit/" . $value['id']); ?>" class=" btn btn-default btn-xs  waves-effect tooltips" data-placement="top" data-toggle="tooltip" data-original-title="View"><i class="fa fa-edit"></i></a>
                <?php endif; ?>
                <?php if (hasPermission("model_test", DELETE)) : ?>
                <a onclick="return confirm('Are You Sure?')" href="<?php echo site_url("modeltest/control/" . $value['id']); ?>" title="<?php echo $value['status']==1?"Published":"Not Published" ?>" class="text-<?php echo $value['status']==1?"info":"danger" ?> btn btn-default  btn-xs  waves-effect tooltips" data-placement="top" data-toggle="tooltip" data-original-title="View" id=""><i class="fa fa-check-circle"></i></a>
                <?php endif; ?>
                <?php if (is_super_admin() && $value['status']==0) : ?>
                <a onclick="return confirm('Are You Sure?')" href="<?php echo site_url("modeltest/delete/" . $value['id']); ?>" title="Delete" class="text-danger btn btn-default  btn-xs  waves-effect tooltips" data-placement="top" data-toggle="tooltip" data-original-title="View" id=""><i class="fa fa-trash"></i></a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach;?>
<?php endif; ?>
