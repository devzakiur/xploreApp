<div class="content">
    <div class="container">
	<?php echo $this->session->flashdata("msg"); ?>
        <?php  if(hasPermission("section_assign",ADD)): ?>
            <?php if(isset($add)): ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-border panel-info">
							 <div class="panel-heading"><h3 class="panel-title">Manage Section Assign</h3></div>
                            <div class="panel-body">
                                <form id="section_assign">
                                    <div class="row">
										<div class="col-md-6">
											<div class="col-sm-12">
												<div class="form-group">
												<label for="category_id">Category</label>
													<select id="category_id"  name="category_id" class="form-control selectpicker" data-live-search="true">
														<option value="">--Select--</option>
														<?php if(count($category_list)>0): ?>
															<?php foreach($category_list as $value):?>
																<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
															<?php endforeach;?>
														<?php endif;?>
													</select>
												</div>
											</div>
											<div class="col-sm-12">
												<div class="form-group">
												<label for="section_id">Section</label><small class="req"> *</small>
													<select id="section_id" required name="section_id" class="form-control selectpicker" data-live-search="true">
														<option value="">--Select--</option>
														<?php if(count($section)>0): ?>
															<?php foreach($section as $value):?>
																<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
															<?php endforeach;?>
														<?php endif;?>
													</select>
												</div>
											</div>
											<div class="col-sm-12">
												<label for="subject">Subject</label> <small class="req"> *</small>
													<div class="checkbox checkbox-info checkbox-inline">
														<input type="checkbox" id="subject">
														<label for="subject">Check All</label>
													</div>
												<div class="form-group m-t-10">
													<div id="subject_list">
													<?php if(count($subject)>0): ?>
														<?php foreach($subject as $key=>$value):?>
															<div class="checkbox checkbox-primary">
																<input id="<?= $key ?>" required class="subject_checkbox" name="subject_id[<?= $key ?>]" value="<?= $value['id'] ?>" type="checkbox">
																<label for="<?= $key ?>">
																	<?= $value['name'] ?>
																</label>
															</div>
														<?php endforeach;?>
													<?php endif;?>
													</div>
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
                                            <th class="text-center">Section Name</th>
                                            <th class="text-center">Subject Name</th>
                                            <th class="text-center">Category Name</th>
											<?php if(hasPermission("section_assign",DELETE)): ?>
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
        $("#section_assign").on("submit",function(e){
            e.preventDefault();
            var url="<?php echo base_url() ?>section/section_assign_add";
            $.ajax({
                url:url,
                type:"post",
                dataType:"json",
                data:$(this).serialize(),
                success:function(data){
                    if(data.msg=="success")
                    {
                        $.Notification.autoHideNotify('success', 'top right',data.success);
                        $(".subject_checkbox").attr("checked",false);
                        $('#section_id').val("");
                        $("#subject").attr("checked",false);
                    }
                    else{
                        $.Notification.autoHideNotify('error', 'top right',data.msg);
                    }
           			 $(".selectpicker").selectpicker("refresh");
                    get_view();
                }
            });
        });

        $(".subject_checkbox").on("click",function () {
        	checkboxValidation();
		});

        checkboxValidation();

        function checkboxValidation() {
        	var flag=false;
        	$(".subject_checkbox").each(function (e) {
				if(this.checked)
				{
					flag=true;
				}
			});
        	if(flag==true)
			{
				$(".subject_checkbox").attr("required",false);
			}
        	else
			{
				$(".subject_checkbox").attr("required",'required');
			}
		}
		$("#category_id").on("change",function () {
			var category_id=$(this).val();
			$.ajax({
                url:"<?php echo base_url() ?>ajax/get_subject_by_category",
                type:"get",
                dataType:"json",
                data:{"category_id":category_id},
                success:function(data){
                	$("#section_id").selectpicker("val","");
                	$("#section_id").selectpicker("refresh");
					var row='';
					$.each(data,function(key,value){
						row+='<div class="checkbox checkbox-primary">';
							row+='<input id="'+key+'" required class="subject_checkbox" name="subject_id['+key+']" value="'+value.id+'" type="checkbox">';
							row+='<label for="'+key+'">'+value.name+'</label>';
						row+='</div>';
					});
					$("#subject_list").html(row);
                }
            });
		});
		$("#section_id").on("change",function () {
			var section_id=$("#section_id").val();
			var url="<?php echo base_url() ?>section/checkAssignSection";
            $.ajax({
                url:url,
                type:"post",
                dataType:"json",
                data:{"section_id":section_id},
                success:function(data){
						var split_data=data.split(",");
						$('.subject_checkbox').each(function() {
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
			var section_id=$("#section_id").val();
            $.ajax({
                url:"<?php echo base_url() ?>section/assignSectionView",
                type:"post",
                dataType:"json",
                data:{"section_id":section_id},
                success:function(data){
                    $('#datatable').DataTable().destroy();
                   $("#datatable tbody").html(data);
                   datatable();
                }
            });
        }

        $("#subject").on("click",function () {
			$('.subject_checkbox').not(this).prop('checked', this.checked);
        	checkboxValidation();
		});
    });
</script>
