<div class="content">
    <?php echo $this->session->flashdata("msg"); ?>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-border panel-info">
                    <div class="panel-heading">
                    </div>
                    <div class="panel-body">
                        <!-- <form id="find"> -->
                        <div class="row">
                            <?php echo form_open("administrator/transfer/student"); ?>
                            <div class="col-sm-5">
                                <fieldset>
                                    <legend>Student Transfer:</legend>
                                    <div class="form-group">
                                        <label for="old_session">Old Session</label><small class="req"> *</small>
                                        <select id="old_session" required name="old_session" class="form-control selectpicker" data-live-search="true">
                                            <option value="">--Select--</option>
                                            <?php if (count($session) > 0) : ?>
                                                <?php foreach ($session as $value) : ?>
                                                    <option value="<?php echo $value['id']; ?>"><?php echo $value["name"]; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="new_session">New Session</label><small class="req"> *</small>
                                        <select id="new_session" required name="new_session" class="form-control selectpicker" data-live-search="true">
                                            <option value="">--Select--</option>
                                            <?php if (count($session) > 0) : ?>
                                                <?php foreach ($session as $value) : ?>
                                                    <option value="<?php echo $value['id']; ?>"><?php echo $value["name"]; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="student_id">Student Id</label><small class="req"> *</small>
                                        <select required id="student_id" name="student_id[]" class="form-control multi-select" multiple>
        
                                        </select>
                                    </div>
                                    <div class="form-group pull-left m-t-22 m-l-15 ">
                                        <button type="submit" class="btn btn-primary"><i class="ion ion-arrow-swap "></i> Swap</button>
                                    </div>
                                </fieldset>
                            </div>
                            </form>
                            <div class="col-sm-2">
                            </div>
                            <?php echo form_open("administrator/transfer/course"); ?>
                            <div class="col-sm-5">
                                <fieldset>
                                    <legend>Course Transfer:</legend>
                                    <div class="form-group">
                                        <label for="old_session_for_course">Old Session</label><small class="req"> *</small>
                                        <select id="old_session_for_course" required name="old_session_for_course" class="form-control selectpicker" data-live-search="true">
                                            <option value="">--Select--</option>
                                            <?php if (count($session) > 0) : ?>
                                                <?php foreach ($session as $value) : ?>
                                                    <option value="<?php echo $value['id']; ?>"><?php echo $value["name"]; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="new_session">New Session</label><small class="req"> *</small>
                                        <select id="new_session" required name="new_session" class="form-control selectpicker" data-live-search="true">
                                            <option value="">--Select--</option>
                                            <?php if (count($session) > 0) : ?>
                                                <?php foreach ($session as $value) : ?>
                                                    <option value="<?php echo $value['id']; ?>"><?php echo $value["name"]; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="course_id">Course Id</label><small class="req"> *</small>
                                        <select required id="course_id" name="course_id[]" class="form-control multi-select" multiple>
                                           
                                        </select>
                                    </div>
                                    <div class="form-group pull-left m-t-22 m-l-15 ">
                                        <button type="submit" class="btn btn-primary"><i class="ion ion-arrow-swap "></i> Swap</button>
                                    </div>
                                </fieldset>
                            </div>
                            </form>
                        </div>
                    </div> <!-- panel-body -->
                </div> <!-- panel -->
            </div> <!-- col -->
        </div> <!-- End row -->
    </div>
</div>
<script type="text/javascript" src="<?php echo VENDOR_URL; ?>jquery-multi-select/jquery.multi-select.js"></script>
<script type="text/javascript" src="<?php echo VENDOR_URL; ?>jquery-multi-select/jquery.quicksearch.js"></script>
<script>
    $('#student_id,#course_id').multiSelect({
        selectableHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='Search  Id...'>",
        selectionHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='Search  Id...'>",
        afterInit: function(ms) {
            var that = this,
                $selectableSearch = that.$selectableUl.prev(),
                $selectionSearch = that.$selectionUl.prev(),
                selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
                selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

            that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                .on('keydown', function(e) {
                    if (e.which === 40) {
                        that.$selectableUl.focus();
                        return false;
                    }
                });

            that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                .on('keydown', function(e) {
                    if (e.which == 40) {
                        that.$selectionUl.focus();
                        return false;
                    }
                });
        },
        afterSelect: function() {
            this.qs1.cache();
            this.qs2.cache();
        },
        afterDeselect: function() {
            this.qs1.cache();
            this.qs2.cache();
        }
    });
    $("#old_session").on("change", function(e) {
        var session_id = $(this).val();
        e.preventDefault();
        var url = "<?php echo base_url(); ?>ajax/get_student_by_session";
        $.ajax({
            url: url,
            type: "get",
            dataType: "json",
            data: {
                "session_id": session_id
            },
            success: function(data) {
                var groupFilter = $('#student_id');
                groupFilter.find('option').remove();
                if (data != '') {
                    $.each(data, function(key, value) {
                        $("#student_id").append('<option value="' + value.st_id + '">' + value.student_unique_id + '</option>')
                    });
                }
                $('#student_id').multiSelect("refresh");
            }
        });
    });
    $("#old_session_for_course").on("change", function(e) {
        var session_id = $(this).val();
        e.preventDefault();
        var url = "<?php echo base_url(); ?>ajax/get_course_by_session";
        $.ajax({
            url: url,
            type: "get",
            dataType: "json",
            data: {
                "session_id": session_id
            },
            success: function(data) {
                console.log(data);
                var groupFilter = $('#course_id');
                groupFilter.find('option').remove();
                if (data != '') {
                    $.each(data, function(key, value) {
                        $("#course_id").append('<option value="' + value.c_id + '">' + value.course_unique_id + '</option>')
                    });
                }
                $('#course_id').multiSelect("refresh");
            }
        });
    });
</script>