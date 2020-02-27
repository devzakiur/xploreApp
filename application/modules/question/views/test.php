<div class="content">
    <div class="container">
		<?php echo $this->session->flashdata("msg"); ?>
        <?php  if(hasPermission("question",ADD)): ?>
            <?php if(isset($add)): ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-border panel-info">
							 <div class="panel-heading"><h3 class="panel-title">Manage Question</h3></div>
                            <div class="panel-body">
                                <form id="question_add" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="title">Title</label><small class="req"> *</small>
                                                <input type="text" name="title" placeholder="Title" class="form-control" required id="title" >
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="option_a">Option A</label><small class="req"> *</small>
                                                <input type="text" name="option_a" placeholder="Option A" class="form-control" required id="option_a" >
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="option_b">Option B</label><small class="req"> *</small>
                                                <input type="text" name="option_b" placeholder="Option B" class="form-control" required id="option_b" >
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="option_c">Option C</label><small class="req"> *</small>
                                                <input type="text" name="option_c" placeholder="Option C" class="form-control" required id="option_c" >
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="option_d">Option D</label><small class="req"> *</small>
                                                <input type="text" name="option_d" placeholder="Option D" class="form-control" required id="option_d" >
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
											<div class="form-group">
											<label for="answer">Answer</label><small class="req"> *</small>
												<select id="answer" required name="answer" class="form-control selectpicker">
													<option value="">--Select--</option>
													<option value="1">Option A</option>
													<option value="2">Option B</option>
													<option value="3">Option C</option>
													<option value="4">Option D</option>
												</select>
											</div>
                                        </div>
                                        <div class="col-sm-2">
											<div class="form-group">
											<label for="difficulty">Lavel</label><small class="req"> *</small>
												<select id="difficulty" required name="difficulty" class="form-control selectpicker">
													<option value="">--Select--</option>
													<option value="1">Basic</option>
													<option value="2">Intermediate</option>
													<option value="3">Advanced</option>
												</select>
											</div>
                                        </div>
										<div class="col-sm-3">
											<div class="form-group">
												<label for="picture">Picture</label>(<small>JPG,PNG AND MAX SIZE 500 KB</small>)
												<input type="file"  id="picture" data-max-file-size="500K" data-allowed-file-extensions="jpg png" name="picture" class="form-control">
											</div>
										</div>
                                        <div class="col-sm-2">
											<div class="form-group">
											<label for="topic_id">Topic</label><small class="req"> *</small>
												<select id="topic_id" required name="topic_id[]" class="form-control selectpicker" multiple data-cotainer="body" data-live-search="true">
													<?php if(count($topic)>0): ?>
														<?php foreach($topic as $value):?>
															<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
														<?php endforeach;?>
													<?php endif;?>
												</select>
											</div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="answer_explain">Answer Explain</label><small class="req"> *</small>
												<textarea name="answer_explain" id="answer_explain"  class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
											<div id="bsc_part">
												<div class="col-sm-6">
													<div class="form-group">
													<label for="question_batch">Batch</label>
														<input type="text" id="question_batch" name="question_batch[]"  placeholder="Batch" class="form-control" >
													</div>
												</div>
												<div class="col-sm-6">
												<div class="form-group">
													<label for="question_year">Year</label>
													<div class="input-group">
														<input type="text" id="question_year" name="question_year[]" placeholder="Year" class="form-control" >
														<div class="input-group-btn">
															<button class="btn btn-info" id="add_button" type="button">
																<i class="md md-add"></i>
															</button>
														</div>
													</div>
												</div>
											</div>
											</div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group m-t-22 pull-right m-l-15 ">
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
        <?php  if(hasPermission("question",EDIT)): ?>
            <?php if(isset($edit)): ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-border panel-info">
							 <div class="panel-heading"><h3 class="panel-title">Manage Topic</h3></div>
                            <div class="panel-body">
                                <!-- <form id="find"> -->
                                <?php echo form_open("topic/edit/".$single->id); ?>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="name">Name</label><small class="req"> *</small>
                                                <input type="text" value="<?php echo $single->name ?>" name="name" placeholder="Subject Name" class="form-control" required id="name" >
                                                <input type="hidden" value="<?php echo $single->id ?>" name="id" class="form-control" required id="id" >
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
            <div class="col-md-12">
                <div class="panel panel-border panel-info">
					 <div class="panel-heading"><h3 class="panel-title">Topic Relation</h3></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <table id="topic_realtion" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Category Name</th>
                                            <th class="text-center">Subject Name</th>
                                            <th class="text-center">Section Name</th>
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
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-border panel-info">
					 <div class="panel-heading"><h3 class="panel-title">Question View</h3></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <table id="question" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Sl.</th>
                                            <th class="text-center">Question Title</th>
                                            <th class="text-center">Answer</th>
                                            <th class="text-center">Details</th>
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
    $(document).ready(function() {
        $('#answer_explain').summernote({
            height:200,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ]
        });
    });
</script>
<script>
    $(document).ready(function(){
        $("#question_add").on("submit",function(e){
            e.preventDefault();
            var url="<?php echo base_url() ?>question/add";
            $.ajax({
                url:url,
                type:"post",
				data: new FormData(this),
				 dataType: 'json',
				 contentType: false,
				 cache: false,
				 processData: false,
                success:function(data){
                    if(data.msg=="success")
                    {
                        $.Notification.autoHideNotify('success', 'top right',data.success);
                        $("input").val('');
                        $("textarea").val('');
                        $(".bsc_append").remove();
                    }
                    else{
                        $.Notification.autoHideNotify('error', 'top right',data.msg);
                    }
                    get_view();
                }
            });
        });
		$("#question_batch,#question_year").on("change",function () {
			validationBcs();
		});
		function validationBcs() {
			var question_batch=$("#question_batch").val();
			var question_year=$("#question_year").val();
			if(question_batch=='' && question_year=='')
			{
				$("#question_batch").attr("required",false);
				$("#question_year").attr("required",false);
			}
			else if(question_batch=='' || question_year=='')
			{
				$("#question_batch").attr("required",true);
				$("#question_year").attr("required",true);
			}
		}
        datatable();
        function datatable() {
            $('#datatable').dataTable({
                "info":false,
                "autoWidth": false
            });
        }

        $("#topic_id").on("change",function(){
			var topic_id=$("#topic_id").val();
			$.ajax({
                url:"<?php echo base_url() ?>question/topic_relation",
                type:"get",
                dataType:"json",
                data:{"topic_id":topic_id},
                success:function(data){
                	log(data);
                   //  $('#datatable').DataTable().destroy();
                   $("#topic_realtion tbody").html(data);
                   // datatable();
                }
            });
		});

		get_view();

        function get_view()
        {
            $.ajax({
                url:"<?php echo base_url() ?>question/view",
                type:"get",
                dataType:"json",
                data:{"topic":"topic"},
                success:function(data){
                    // $('#datatable').DataTable().destroy();
                   $("#question tbody").html(data);
                   // datatable();
                }
            });
        }
    });
</script>
<script>
     $(document).ready(function(){
        var maxField = 4; //Input fields increment limitation
        var addButton = $('#add_button'); //Add button selector
        var wrapper = $('#bsc_part'); //Input field wrapper
        var row="";
        row+='<div class="bsc_append">';
        row+='<div class="col-sm-6">';
                row+='<div class="form-group">';
                    row+='<label for="question_batcha">Batch</label><small class="req"> *</small>';
                    row+='<input type="text" id="question_batcha" name="question_batch[] placeholder="Batch" class="form-control" >';
                row+='</div>';
            row+='</div>';
            row+='<div class="col-sm-6">';
            row+='<div class="form-group">';
                    row+='<label for="question_yeara">Year</label><small class="req"> *</small>';
                    row+='<div class="input-group">';
                    row+='<input type="text" id="question_yeara" name="question_year[]" placeholder="Year" class="form-control" >';
                        row+='<div class="input-group-btn">';
							row+='<button class="btn btn-danger remove_button" id="add_button" type="button">';
								row+='<i class="fa fa-minus"></i>';
							row+='</button>';
						row+='</div>';
						row+='</div>';
                row+='</div>';
            row+='</div>';
            row+='</div>';
        var x = 1; //Initial field counter is 1

        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){
                x++; //Increment field counter
                $(wrapper).append(row); //Add field html
            }

            $(".selectpicker").selectpicker('render').selectpicker('refresh');
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).closest('.bsc_append').remove(); //Remove field html
            $(".selectpicker").selectpicker('render').selectpicker('refresh');
            x--; //Decrement field counter
        });
     });
    </script>
