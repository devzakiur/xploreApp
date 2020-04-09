<div class="content">
    <div class="container">
		<?php echo $this->session->flashdata("msg"); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-border panel-info">
					 <div class="panel-heading"><h3 class="panel-title">User Question Reports</h3></div>
                    <div class="panel-body">
						<div class="row">
							<div class="col-md-2 m-b-15">
								<label for="filter_by">Filter By</label>
								<select name="filter_by" id="filter_by" class="form-control selectpicker">
									<option value="">All</option>
									<option value="1">View</option>
									<option value="0">Not View</option>
								</select>
							</div>
							<div class="col-md-2 m-b-15">

							</div>
							<div class="col-md-2 m-b-15">

							</div>
						</div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
								<div style="overflow: hidden">
									<div id="question_loading">
										<div class="cv-spinner">
											<span class="spinner"></span>
										</div>
									</div>
									<table id="question" class="table table-striped table-bordered">
										<thead>
											<tr>
												<th class="text-center">Sl.</th>
												<th class="text-center">User Name</th>
												<th class="text-center">Question Title</th>
												<th class="text-center">Type</th>
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
            </div>
        </div> <!-- End Row -->
    </div> <!-- container -->
</div>
  <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <!-- <form id="item_add"> -->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">User Question Report Details</h4>
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

<script>
    $(document).ready(function(){
		$("#filter_by").on("change",function () {
			get_view(false);
			return false;
		});
		$("#question").on("click",'.pagination li a',function () {
			var page_url=$(this).attr("href");
			log(page_url);
			if(page_url=="javascript:void(0)")
			{
				return false;
			}
			get_view(page_url);
			return false;
		});
		get_view(false);

        function get_view(page_url)
        {
        	var filter_by=$("#filter_by").val();
        	var base_url="<?php echo base_url() ?>question/user_question_report_view";
        	if(page_url)
			{
				base_url=page_url;
			}
            $.ajax({
                url:base_url,
                type:"post",
                dataType:"json",
                data:{
                	"filter_by":filter_by,
				},
                beforeSend: function(){
                		$("#question_loading").fadeIn(300);　
                },
                success:function(data){
                   $("#question tbody").html(data);
                	$("#question_loading").fadeOut(300);　
                },
                error:function (e) {
                	$("#question_loading").fadeOut(300);
				}
            });
        }


        $("#question").on("click","#details_modal",function () {
			var error_id=$(this).data("id");
			var text=$("#"+error_id+" #details").text();
			$("#show_details").html(text);
		});

    });
</script>
