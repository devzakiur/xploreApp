<div class="content">
    <div class="container">
<?php echo $this->session->flashdata("msg"); ?>
        <?php  if(hasPermission("content",ADD)): ?>
            <?php if(isset($add)): ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-border panel-info">
							 <div class="panel-heading"><h3 class="panel-title">Manage Content</h3></div>
                            <div class="panel-body">
								<?php echo form_open("content/add") ?>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="slug">Select Type</label><small class="req"> *</small>
												<select name="slug" id="slug" class="form-control selectpicker">
													<option value="">--Select--</option>
													<option value="toc">Terms Of Condition</option>
													<option value="play">How To Play</option>
													<option value="coin">How To Buy Coins</option>
													<option value="about">About Xplore</option>
												</select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
											<label for="description">Description</label><small class="req"> *</small>
                                            <div class="form-group">
												<textarea name="description" id="description" required cols="30" class="form-control" placeholder="Write Your Content" id="description" rows="10"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group pull-left m-l-15 ">
                                                <button name="s" type="submit" class="btn btn-primary"><i class="md md-add m-r-5"></i>Save</button>
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

    </div> <!-- container -->
</div>

<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>
<script>
    $(document).ready(function(){
    	summernote();
    	function summernote(){
    		 $('#description').summernote({
				height:200,
				toolbar: [
					// [groupName, [list of button]]
					['style', ['bold', 'italic', 'underline', 'clear']],
					['font', ['strikethrough', 'superscript', 'subscript']],
					['fontsize', ['fontsize']],
					['color', ['color']],
					['para', ['ul', 'ol', 'paragraph']],
					['height', ['height']],
					 ['insert', ['math', 'picture', 'video','table']],
				]
			});
		}
		$("#slug").on("change",function () {
			var slug=$("#slug").val();
			var url="<?php echo base_url() ?>content/single_view";
            $.ajax({
                url:url,
                type:"get",
                dataType:"json",
                data:{"slug":slug},
                success:function(data){
					$("#description").summernote('reset');
					$("#description").summernote('destroy');
                	$("#description").val(data);
    				summernote();
                }
            });
		});
    });
</script>
