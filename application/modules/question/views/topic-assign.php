<div class="content">
    <div class="container">
	<?php echo $this->session->flashdata("msg"); ?>
        <?php  if(hasPermission("topic_assign",ADD)): ?>
            <?php if(isset($add)): ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-border panel-info">
							 <div class="panel-heading"><h3 class="panel-title">Manage Subject Assign</h3></div>
                            <div class="panel-body">
                                <form id="topic_assign">
                                    <div class="row">
										<div class="col-md-5">
											<div class="col-sm-12">
												<div class="form-group">
												<label for="topic_id">Section</label><small class="req"> *</small>
													<select id="topic_id" required name="topic_id" class="form-control selectpicker" data-live-search="true">
														<option value="">--Select--</option>
														<?php if(count($topic)>0): ?>
															<?php foreach($topic as $value):?>
																<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
															<?php endforeach;?>
														<?php endif;?>
													</select>
												</div>
											</div>
											<div class="col-sm-12">
												<label for="section">Section</label> <small class="req"> *</small>
													<div class="checkbox checkbox-info checkbox-inline">
														<input type="checkbox" id="section">
														<label for="section">Check All</label>
													</div>
												<div class="form-group m-t-10">
												<?php if(count($section)>0): ?>
													<?php foreach($section as $key=>$value):?>
														<div class="checkbox checkbox-primary">
															<input id="<?= $key ?>" required class="section_checkbox" name="section_id[<?= $key ?>]" value="<?= $value['id'] ?>" type="checkbox">
															<label for="<?= $key ?>">
																<?= $value['name'] ?>
															</label>
														</div>
													<?php endforeach;?>
												<?php endif;?>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group pull-left m-t-5 m-l-15 ">
													<button name="" type="submit" class="btn btn-primary"><i class="md md-add m-r-5"></i>Add</button>
												</div>
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
											<?php if(hasPermission("topic_assign",DELETE)): ?>
                                            <th class="text-center">Action</th>
											<?php endif; ?>
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
    $(document).ready(function(){
        $("#topic_assign").on("submit",function(e){
            e.preventDefault();
            var url="<?php echo base_url() ?>topic/topic_assign_add";
            $.ajax({
                url:url,
                type:"post",
                dataType:"json",
                data:$(this).serialize(),
                success:function(data){
                    if(data.msg=="success")
                    {
                        $.Notification.autoHideNotify('success', 'top right',data.success);
                        $(".section_checkbox").attr("checked",false);
                        $('#topic_id').val("");
                        $("#section").attr("checked",false);
                    }
                    else{
                        $.Notification.autoHideNotify('error', 'top right',data.msg);
                    }
           			 $(".selectpicker").selectpicker("refresh");
                    get_view();
                }
            });
        });

        $(".section_checkbox").on("click",function () {
        	checkboxValidation();
		});

        checkboxValidation();

        function checkboxValidation() {
        	var flag=false;
        	$(".section_checkbox").each(function (e) {
				if(this.checked)
				{
					flag=true;
				}
			});
        	if(flag==true)
			{
				$(".section_checkbox").attr("required",false);
			}
        	else
			{
				$(".section_checkbox").attr("required",'required');
			}
		}

		$("#topic_id").on("change",function () {
			var topic_id=$("#topic_id").val();
			var url="<?php echo base_url() ?>topic/checkAssignTopic";
            $.ajax({
                url:url,
                type:"post",
                dataType:"json",
                data:{"topic_id":topic_id},
                success:function(data){
						var split_data=data.split(",");
						$('.section_checkbox').each(function() {
							if (jQuery.inArray($(this).val(), split_data) !== -1) {
								this.checked = true;
							}
							else {
								this.checked = false;
							}
						});
        			checkboxValidation();
                    get_view();
                }
            });
		});

        datatable();

        function datatable() {
            $('#datatable').dataTable({
                "info":false,
                "autoWidth": false
            });

        }

        get_view();

        function get_view(){
			var topic_id=$("#topic_id").val();
            $.ajax({
                url:"<?php echo base_url() ?>topic/assignTopicView",
                type:"post",
                dataType:"json",
                data:{"topic_id":topic_id},
                success:function(data){
                    $('#datatable').DataTable().destroy();
                   $("#datatable tbody").html(data);
                   datatable();
                }
            });
        }

        $("#section").on("click",function () {
			$('.section_checkbox').not(this).prop('checked', this.checked);
        	checkboxValidation();
		});
    });
</script>
