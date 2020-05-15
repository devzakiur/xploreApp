<div class="content">
    <div class="container">
        <?php echo $this->session->flashdata("msg"); ?>
        <?php if (hasPermission("topic", ADD)) : ?>
            <?php if (isset($add)) : ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-border panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title">Manage Topic</h3>
                            </div>
                            <div class="panel-body">
                                <form id="topic_add">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="name">Name</label><small class="req"> *</small>
                                                <input type="text" name="name" placeholder="Topic Name" class="form-control" required id="name">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="name">Position</label><small class="req"> *</small>
                                                <input type="number" name="position" placeholder="Position" class="form-control" required id="position">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group pull-left m-l-15 ">
                                                <button name="add_user" type="submit" class="btn btn-primary"><i class="md md-add m-r-5"></i>Add</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div> <!-- panel-body -->
                        </div> <!-- panel -->
                    </div> <!-- col -->
                </div> <!-- End row -->
            <?php endif; ?>
        <?php endif; ?>
        <?php if (hasPermission("topic", EDIT)) : ?>
            <?php if (isset($edit)) : ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-border panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title">Manage Topic</h3>
                            </div>
                            <div class="panel-body">
                                <!-- <form id="find"> -->
                                <?php echo form_open("topic/edit/" . $single->id); ?>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="name">Name</label><small class="req"> *</small>
                                            <input type="text" value="<?php echo $single->name ?>" name="name" placeholder="Subject Name" class="form-control" required id="name">
                                            <input type="hidden" value="<?php echo $single->id ?>" name="id" class="form-control" required id="id">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="name">Position</label><small class="req"> *</small>
                                            <input type="number" name="position" value="<?= $single->position ?>" placeholder="Position" class="form-control" required id="position">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group pull-left m-l-15 ">
                                            <button name="edit_user" type="submit" class="btn btn-primary"><i class="md md-add m-r-5"></i>Update</button>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div> <!-- panel-body -->
                        </div> <!-- panel -->
                    </div> <!-- col -->
                </div> <!-- End row -->
            <?php endif; ?>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="search_category_id">Category</label><small class="req">*</small>
                    <select id="search_category_id" name="search_category_id" class="form-control selectpicker" data-live-search="true" data-container="body">
                        <option value="">--Select--</option>
                        <?php foreach ($category_list as $value) : ?>
                            <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="search_subject_id">Subject</label>
                    <select id="search_subject_id" name="search_subject_id" class="form-control selectpicker" data-live-search="true" data-container="body">
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="search_section_id">Section</label>
                    <select id="search_section_id" name="search_section_id" class="form-control selectpicker" data-live-search="true" data-container="body">
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <table id="datatable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">SL.</th>
                                            <th class="text-center">Topic Name</th>
                                            <th class="text-center">Section Name</th>
                                            <th class="text-center">Subject Name</th>
                                            <th class="text-center">Category Name</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End Row -->

    </div> <!-- container -->
</div>
<script src="<?php echo VENDOR_URL; ?>datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo VENDOR_URL; ?>datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo VENDOR_URL; ?>notifications/notify.min.js"></script>
<script src="<?php echo VENDOR_URL; ?>notifications/notify-metro.js"></script>
<script src="<?php echo VENDOR_URL; ?>notifications/notifications.js"></script>
<script>
    $(document).ready(function() {

        <?php if (isset($add)) : ?>
            last_order_position();
        <?php endif; ?>

        function last_order_position() {
            $.get("<?php echo base_url() ?>ajax/get_last_order_position?table_name=topic", function(data, status) {
                $("#position").val(data);
            });
        }
        $("#topic_add").on("submit", function(e) {
            e.preventDefault();
            var url = "<?php echo base_url() ?>topic/add";
            $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: $(this).serialize(),
                success: function(data) {
                    if (data.msg == "success") {
                        $.Notification.autoHideNotify('success', 'top right', data.success);
                        $("input").val('');
                        last_order_position();
                    } else {
                        $.Notification.autoHideNotify('error', 'top right', data.msg);
                    }
                    get_view();
                }
            });
        });
        $("#search_category_id").on("change", function() {
            var category_id = $(this).val();
            $.ajax({
                url: "<?php echo base_url() ?>ajax/get_subject_by_category",
                type: "get",
                dataType: "json",
                data: {
                    "category_id": category_id
                },
                success: function(data) {
                    $("#search_subject_id").find('option').remove();
                    $("#search_section_id").find('option').remove();
                    $("#search_subject_id").append('<option value="">--Select--</option>');
                    $.each(data, function(key, value) {
                        $("#search_subject_id").append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                    $(".selectpicker").selectpicker('render').selectpicker('refresh');

                    get_view();
                }
            });
        });
        $("#search_subject_id").on("change", function() {
            var subject_id = $(this).val();
            $.ajax({
                url: "<?php echo base_url() ?>ajax/get_section_by_subject",
                type: "get",
                dataType: "json",
                data: {
                    "subject_id": subject_id
                },
                success: function(data) {
                    $("#search_section_id").find('option').remove();
                    $("#search_section_id").append('<option value="">--Select--</option>');
                    $.each(data, function(key, value) {
                        $("#search_section_id").append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                    $(".selectpicker").selectpicker('render').selectpicker('refresh');
                    get_view();
                }
            });
        });
        $("#search_section_id").on("change", function() {
            get_view();
        });
        datatable();

        function datatable() {
            $('#datatable').dataTable({
                "info": false,
                "autoWidth": false
            });

        }
        get_view();

        function get_view() {
            var category_id = $("#search_category_id").val();
            var subject_id = $("#search_subject_id").val();
            var section_id = $("#search_section_id").val();
            $.ajax({
                url: "<?php echo base_url() ?>topic/view",
                type: "get",
                dataType: "json",
                data: {
                    "category_id": category_id,
                    "subject_id": subject_id,
                    "section_id": section_id,
                },
                success: function(data) {
                    $('#datatable').DataTable().destroy();
                    $("#datatable tbody").html(data);
                    datatable();
                }
            });
        }
    });
</script>