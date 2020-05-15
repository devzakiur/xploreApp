<div class="content">
    <div class="container">
<?php echo $this->session->flashdata("msg"); ?>
        <?php  if(hasPermission("notification",ADD)): ?>
            <?php if(isset($add)): ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-border panel-info">
							 <div class="panel-heading"><h3 class="panel-title">Manage notification</h3></div>
                            <div class="panel-body">
                                <form id="notification_send" enctype="multipart/form-data">
                                    <div class="row">
										<div class="col-sm-3">
											<div class="form-group">
												<label for="category_id">Category</label><small class="req"> *</small>
												<select id="category_id" required name="category_id" class="form-control selectpicker" data-live-search="true">
													<option value="">--Select--</option>
													<?php if(count($category)>0): ?>
														<?php foreach($category as $value):?>
															<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
														<?php endforeach;?>
													<?php endif;?>
												</select>
											</div>
										</div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="title">Title</label><small class="req"> *</small>
                                                <input type="text" name="title" placeholder="Title" class="form-control" required id="title" >
                                            </div>
                                        </div>
										<div class="col-sm-3">
											<div class="form-group">
												<label for="action">Action</label><small class="req"> *</small>
												<select id="action" required name="action" class="form-control selectpicker" data-live-search="true">
													<option value="">--Select--</option>
													<option value="no_action">No Action</option>
													<option value="notification_details">Notification Details</option>
													<option value="game_screen">Game Screen</option>
													<option value="home_screen">Home Screen</option>
													<option value="library_screen_main">Library Screen Main</option>
												</select>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group">
												<label for="picture">Picture</label>(<code>JPG,PNG MAX SIZE 500 KB</code>)
												<input type="file"  id="picture" data-max-file-size="500K" data-allowed-file-extensions="jpg png" name="picture" class="form-control">
											</div>
										</div>
										<div class="col-sm-12">
											<div class="form-group">
												<label for="details">Details</label><small class="req"> *</small>
												<textarea name="details" id="details" class="form-control" cols="30" rows="10"></textarea>
											</div>
										</div>
                                        <div class="col-sm-4">
                                            <div class="form-group pull-left m-t-22 m-l-15 ">
                                                <button name="add_user" type="submit" class="btn btn-primary"><i class="md md-send m-r-5"></i>Send Notification</button>
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
        <?php  if(hasPermission("category",EDIT)): ?>
            <?php if(isset($edit)): ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-border panel-info">
							<div class="panel-heading"><h3 class="panel-title">Manage Category</h3></div>
                            <div class="panel-body">
                                <!-- <form id="find"> -->
                                <?php echo form_open("notification/edit/".$single->id); ?>
                                    <div class="row">
										<div class="col-sm-3">
											<div class="form-group">
												<label for="category_id">Category</label><small class="req"> *</small>
												<select id="category_id" required name="category_id" class="form-control selectpicker" data-live-search="true">
													<option value="">--Select--</option>
													<?php if(count($category)>0): ?>
														<?php foreach($category as $value):?>
															<option <?php if($single->category_id==$value['id']) echo "selected" ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
														<?php endforeach;?>
													<?php endif;?>
												</select>
											</div>
										</div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="title">Title</label><small class="req"> *</small>
                                                <input type="text" name="title" value="<?= $single->title ?>" placeholder="Title" class="form-control" required id="title" >
                                                <input type="hidden" name="id" value="<?= $single->id ?>" required>
                                            </div>
                                        </div>
										<div class="col-sm-3">
											<div class="form-group">
												<label for="action">Action</label><small class="req"> *</small>
												<select id="action" required name="action" class="form-control selectpicker" data-live-search="true">
													<option value="">--Select--</option>
													<option <?php if($single->action=="no_action") echo "selected" ?> value="no_action">No Action</option>
													<option <?php if($single->action=="notification_details") echo "selected" ?> value="notification_details">Notfication Details</option>
													<option <?php if($single->action=="game_screen") echo "selected" ?> value="game_screen">Game Screen</option>
													<option <?php if($single->action=="home_screen") echo "selected" ?> value="home_screen">Home Screen</option>
													<option <?php if($single->action=="library_screen_main") echo "selected" ?> value="library_screen_main">Library Screen Main</option>
												</select>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group">
												<label for="picture">Picture</label>(<code>JPG,PNG MAX SIZE 500 KB</code>)
												<input type="file"  id="picture" data-max-file-size="500K" data-default-file="<?= base_url().$single->picture ?>" data-allowed-file-extensions="jpg png" name="picture" class="form-control">
											</div>
										</div>
										<div class="col-sm-12">
											<div class="form-group">
												<label for="details">Details</label><small class="req"> *</small>
												<textarea name="details" id="details" class="form-control" cols="30" rows="10"><?= html_entity_decode($single->details) ?></textarea>
											</div>
										</div>
                                        <div class="col-sm-4">
                                            <div class="form-group pull-left m-t-22 m-l-15 ">
                                                <button name="add_user" type="submit" class="btn btn-primary"><i class="md md-send m-r-5"></i>Update</button>
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
							<div class="col-sm-3">
								<div class="form-group">
									<label for="search_category_id">Category</label><small class="req"> *</small>
									<select id="search_category_id" required name="search_category_id" class="form-control selectpicker" data-live-search="true">
										<option value="">--Select--</option>
										<?php if(count($category)>0): ?>
											<?php foreach($category as $value):?>
												<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
											<?php endforeach;?>
										<?php endif;?>
									</select>
								</div>
							</div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
								<div id="question_loading">
									<div class="cv-spinner">
										<span class="spinner"></span>
									</div>
								</div>
                                <table id="notification" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">SL.</th>
                                            <th class="text-center">Category Name</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Details</th>
                                            <th class="text-center">DateTime</th>
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
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>
<script>
    $(document).ready(function(){
    		summernote();
    	function summernote(){
    		 $('#details').summernote({
				height:200,
				toolbar: [
					// [groupName, [list of button]]
					['style', ['bold', 'italic', 'underline', 'clear']],
					['font', ['strikethrough', 'superscript', 'subscript']],
					['fontsize', ['fontsize']],
					['color', ['color']],
					['para', ['ul', 'ol', 'paragraph']],
					['height', ['height']],
					 ['insert', ['table']],
				]
			});
		}
        $("#notification_send").on("submit",function(e){
            e.preventDefault();
            if($("#details").summernote("isEmpty"))
			{
				 $.Notification.autoHideNotify('error', 'top right',"Details Required");
				 return false;
			}
            var url="<?php echo base_url() ?>notification/add";
            $.ajax({
                 url:url,
				 type:"post",
				 data: new FormData(this),
				 dataType: 'json',
				 contentType: false,
				 cache: false,
				 processData: false,
				 beforeSend:function(){
                	$("#overlay").fadeIn(300);　
				 },
                success:function(data){
                 	 if(data.msg=="success") {
						 $("textarea").summernote('reset');
						 $("textarea").summernote('destroy');
						 $('.dropify-clear').click();
						 $.Notification.autoHideNotify('success', 'top right',data.success);
						 summernote();
						 get_view(false);
					 }else{
                 	 	$.Notification.autoHideNotify('error', 'top right',data.msg);
					 }
                	$("#overlay").fadeOut(300);　
                },
				error:function (e) {
					$.Notification.autoHideNotify('error', 'top right',"Something Wrong. Please try again");
                	$("#overlay").fadeOut(300);　
				}
            });
        });
		$("#search_category_id").on("change",function () {
			get_view(false);
		});
		get_view(false);

        function get_view(page_url)
        {
        	var category_id=$("#search_category_id").val();
        	var base_url="<?php echo base_url() ?>notification/view";
        	if(page_url)
			{
				base_url=page_url;
			}
            $.ajax({
                url:base_url,
                type:"post",
                dataType:"json",
                data:{
					"category_id":category_id
				},
                beforeSend: function(){
                		$("#question_loading").fadeIn(300);　
                },
                success:function(data){
                   $("#notification tbody").html(data);
                	$("#question_loading").fadeOut(300);　
                },
                error:function (e) {
					$.Notification.autoHideNotify('error', 'top right',"Something Wrong. Please try again");
                	$("#question_loading").fadeOut(300);
				}
            });
        }
    });
</script>
