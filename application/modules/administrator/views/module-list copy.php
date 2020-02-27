<div class="content">
    <?php $data['msg'] = "Welcome To Module List"; ?>
    <?php $this->load->view("message", $data) ?>
    <div class="container">
        <?php echo form_open("module/mlist"); ?>
            <div class="col-md-12">
                <div class="panel panel-border panel-info">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4 col-md-offset-4">
                                <div class="form-group">
                                    <label for="company_id">Company Name</label><small class="req"> *</small>
                                    <select name="company_id" data-live-search="true" id="company_id" required class="form-control selectpicker">
                                        <option value="">--Select--</option>
                                        <?php foreach ($company_name as $item) { ?>
                                            <option value="<?php echo $item->id ?>"><?php echo $item->name; ?></option>
                                        <?php } ?>

                                    </select>
                                </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <ul>
                                    <?php
                                    foreach ($all_menu as $all) { ?>
                                        <li><?php echo $all->name; ?> <input type="checkbox" class="Checkall" value="<?php echo $all->id ?>" name="id[]"> </li>
                                        <?php if (sizeof($all->sub_menu) > 0) {
                                            foreach ($all->sub_menu as $sub_menu) { ?>
                                                <ul>
                                                    <li><?php echo $sub_menu->name; ?> <input type="checkbox" class="Checkall" value="<?php echo $sub_menu->id ?>" name="id[]"></li>
                                                    <?php if (sizeof($sub_menu->child_menu) > 0){
                                                        foreach ($sub_menu->child_menu as $child_menu) { ?>
                                                            <ul>
                                                                <li><?php echo $child_menu->name; ?> <input type="checkbox" class="Checkall" value="<?php echo $child_menu->id ?>" name="id[]"></li>
                                                            </ul>
                                                        <?php }
                                                    } ?>
                                                </ul>
                                            <?php }
                                        } ?>
                                    <?php } ?>
                                </ul>
                               <span style="padding: 20px"><input type="checkbox" id="checkAll">Check All</span>
                            </div>
                        </div>
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3">
                                    <div class="form-group text-center">
                                        <button name="submit" type="submit" class="btn btn-primary"><i class="md md-add m-r-5"></i>Add</button>
                                    </div>
                                </div>
                            </div>
                    </div> <!-- panel-body -->
                </div> <!-- panel -->
            </div>
        </div>
    </div> <!-- container -->

</div>
<script>
    $("#checkAll").click(function () {
        $('.Checkall').not(this).prop('checked', this.checked);
    });
</script>