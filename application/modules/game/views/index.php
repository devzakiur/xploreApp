<div class="content">
    <div class="container">
<?php echo $this->session->flashdata("msg"); ?>
        <?php  if(hasPermission("game_setting",ADD)): ?>
            <?php if(isset($add)): ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-border panel-info">
							 <div class="panel-heading"><h3 class="panel-title">Manage Game</h3></div>
                            <div class="panel-body">
								<?php echo form_open("game/add") ?>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="game_type_id">Select Type</label><small class="req"> *</small>
												<select name="game_type_id" id="game_type_id" class="form-control selectpicker">
													<option value="">--Select--</option>
													<?php if (isset($game_type)): ?>
														<?php foreach ($game_type as $value): ?>
															<option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
														<?php endforeach; ?>
													<?php endif; ?>
												</select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="question_number">Question Number</label><small class="req"> *</small>
												<input type="text" class="form-control" placeholder="Question Number" name="question_number" id="question_number" />
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="game_time">Game Time</label><small class="req"> *</small>
												<input type="text" class="form-control" name="game_time" placeholder="Game Time(Minute)" id="game_time" />
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group pull-left m-l-15 m-t-22 ">
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

<script>
    $(document).ready(function(){
		$("#game_type_id").on("change",function () {
			var game_type_id=$("#game_type_id").val();
			var url="<?php echo base_url() ?>game/single_view";
            $.ajax({
                url:url,
                type:"get",
                dataType:"json",
                data:{"game_type_id":game_type_id},
                success:function(data){
                	$("#question_number").val(data.question_number);
                	$("#game_time").val(data.game_time);
                }
            });
		});
    });
</script>
