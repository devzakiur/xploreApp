<div class="content">
    <div class="container">
	<?php echo $this->session->flashdata("msg"); ?>
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-border panel-info">
					<div class="panel-heading"><h3 class="panel-title">Manage Model Test Question</h3></div>
					<div class="panel-body">
						<div class="row">
							<input type="hidden" name="category_id" value="<?= $category_id ?>" id="category_id">
							<input type="hidden" name="model_test_id" value="<?= $model_test_id ?>" id="model_test_id">
							<div class="col-md-12">
								<div class="col-md-4">
									<div class="form-group">
										<label for="subject_id">Subject</label><small class="req"> *</small>
										<select id="subject_id" required name="subject_id" class="form-control selectpicker" data-live-search="true">
											<option value="">--Select--</option>
											<?php if(count($subject_list)>0): ?>
												<?php foreach($subject_list as $value):?>
													<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
												<?php endforeach;?>
											<?php endif;?>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="section_id">Section</label><small class="req"> *</small>
										<select id="section_id" required name="section_id" class="form-control selectpicker" data-live-search="true">
											<option value="">--Select--</option>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="topic_id">Topic</label><small class="req"> *</small>
										<select id="topic_id" required name="topic_id" class="form-control selectpicker" data-live-search="true">
											<option value="">--Select--</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="table-responsive">
									<div id="question_loading" class="question_loading">
										<div class="cv-spinner">
											<span class="spinner"></span>
										</div>
									</div>
									<table class="table table-bordered table-striped" id="all_question">
										<thead>
											<tr>
												<th colspan="4" class="text-center">All Question</th>
											</tr>
											<tr>
												<th>Sl.</th>
												<th>Title</th>
												<th>Details</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
							</div>
							<div class="col-md-6">
								<div class="table-responsive">
									<div id="question_loading" class="question_loading">
										<div class="cv-spinner">
											<span class="spinner"></span>
										</div>
									</div>
									<table class="table table-bordered table-striped" id="model_test_question">
										<thead>
											<tr>
												<th colspan="4" class="text-center">Model Test Question</th>
											</tr>
											<tr>
												<th>Sl.</th>
												<th>Title</th>
												<th>Details</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div> <!-- panel-body -->
				</div> <!-- panel -->
			</div> <!-- col -->
		</div> <!-- End row -->

    </div> <!-- container -->
</div>
<div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<!-- <form id="item_add"> -->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">Question View</h4>
				</div>
				<div class="modal-body">
				   <div id="show_details">

				   </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
				</div>
			</div>
	</div>
</div><!-- /.modal -->
<script src="<?php echo VENDOR_URL; ?>notifications/notify.min.js"></script>
<script src="<?php echo VENDOR_URL; ?>notifications/notify-metro.js"></script>
<script src="<?php echo VENDOR_URL; ?>notifications/notifications.js"></script>
<script>
    $(document).ready(function(){
		$("#subject_id").on("change",function () {
			var subject_id=$(this).val();
			$.ajax({
                url:"<?php echo base_url() ?>ajax/get_section_by_subject",
                type:"get",
                dataType:"json",
                data:{"subject_id":subject_id},
                success:function(data){
					 $("#section_id").find('option').remove();
					 $("#topic_id").find('option').remove();
					 $("#section_id").append('<option value="">--Select--</option>');
					$.each(data,function(key,value){
						$("#section_id").append('<option value="'+ value.id +'">'+ value.name +'</option>');
					});
					$(".selectpicker").selectpicker('render').selectpicker('refresh');
                }
            });
			get_view(false);
		});
		$("#section_id").on("change",function () {
			var section_id=$(this).val();
			$.ajax({
                url:"<?php echo base_url() ?>ajax/get_topic_by_section",
                type:"get",
                dataType:"json",
                data:{"section_id":section_id},
                success:function(data){
					 $("#topic_id").find('option').remove();
					 $("#topic_id").append('<option value="">--Select--</option>');
					$.each(data,function(key,value){
						$("#topic_id").append('<option value="'+ value.id +'">'+ value.name +'</option>');
					});
					$(".selectpicker").selectpicker('render').selectpicker('refresh');
                }
            });
			get_view(false);
		});
		$("#topic_id").on("change",function () {
			get_view(false);
		});

        $("#all_question").on("click",'.pagination li a',function () {
			var page_url=$(this).attr("href");
			if(page_url=="javascript:void(0)")
			{
				return false;
			}
			get_view(page_url,"all");
			return false;
		});
        $("#model_test_question").on("click",'.pagination li a',function () {
			var page_url=$(this).attr("href");
			if(page_url=="javascript:void(0)")
			{
				return false;
			}
			get_view(page_url,"model");
			return false;
		});

		get_view(false);
       function get_view(page_url,derimine="")
        {
        	var category_id=$("#category_id").val();
        	var subject_id=$("#subject_id").val();
        	var section_id=$("#section_id").val();
        	var topic_id=$("#topic_id").val();
        	var model_test_id=$("#model_test_id").val();
        	var base_url="<?php echo base_url() ?>modeltest/all_question_view";
        	if(page_url)
			{
				base_url=page_url;
			}
            $.ajax({
                url:base_url,
                type:"post",
                dataType:"json",
                data:{
					"category_id":category_id,
					"subject_id":subject_id,
					"section_id":section_id,
					"topic_id":topic_id,
					"model_test_id":model_test_id,
					"derimine":derimine,
				},
                beforeSend: function(){
                		$(".question_loading").fadeIn(300);　
                },
                success:function(data){
                   $("#all_question tbody").html(data.all_question);
                   $("#model_test_question tbody").html(data.model_all_question);
                   updateMath();
                	$(".question_loading").fadeOut(300);　
                },
                error:function (e) {
					$.Notification.autoHideNotify('error', 'top right',"Something Wrong. Please try again");
                	$(".question_loading").fadeOut(300);
				}
            });
        }

        $("#all_question").on("submit",".add_question",function (e){
        	e.preventDefault();
			 var url="<?php echo base_url() ?>modeltest/add_model_question";
            $.ajax({
                url:url,
                type:"post",
                dataType:"json",
                data:$(this).serialize(),
                success:function(data){
                	if(data.status==true)
					{
						$.Notification.autoHideNotify('success', 'top right',data.message);
						get_view(false);
					}else{
                		$.Notification.autoHideNotify('error', 'top right',data.message);
					}
                }
            });
		});
        $("#model_test_question").on("submit",".delete_question",function (e){
        	e.preventDefault();
			 var url="<?php echo base_url() ?>modeltest/delete_model_question";
            $.ajax({
                url:url,
                type:"post",
                dataType:"json",
                data:$(this).serialize(),
                success:function(data){
					$.Notification.autoHideNotify('success', 'top right',data.message);
                    get_view(false);
                }
            });
		});

         $("#all_question,#model_test_question").on("click","#details_modal",function () {
			var question_id=$(this).data("id");
			 $.ajax({
                url:"<?php echo base_url() ?>question/details_view",
                type:"get",
                dataType:"json",
                data:{"question_id":question_id},
				 beforeSend:function(){
                	$("#overlay").fadeIn(300);　
				 },
                success:function(data){
					$("#show_details").html(data);
                   updateMath();
                	$("#overlay").fadeOut(300);
                },
				error:function (e) {
					$.Notification.autoHideNotify('error', 'top right',"Something Wrong. Please try again");
                	$("#overlay").fadeOut(300);
				}
            });
		});
    });
</script>
