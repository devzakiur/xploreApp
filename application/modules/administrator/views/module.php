<div class="content">
        <div class="container">
<?php echo $this->session->flashdata("msg"); ?>
        <?php if(hasPermission("module",ADD)): ?>
            <div class="row">
                <?php if(isset($add)): ?>
                    <div class="col-sm-4">
                        <div class="panel panel-border panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title">Top Menu</h3>
                            </div>
                            <div class="panel-body">
                                <form id="parent_module">
                                    <div class="form-group">
                                        <label for="name">Top Menu Name</label><small class="req"> *</small> 
                                        <input required name="name" type="text" class="form-control" id="name" placeholder="Enter Top Menu Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="position">Position</label><small class="req"> *</small> 
                                        <input required name="position" type="text" class="form-control" id="position" placeholder="Position">
                                    </div>
                                    <div class="form-group">
                                    <input type="submit" class=" btn btn-primary pull-right" value="Save" name="submit" />
                                    </div>
                                </form>
                            </div> <!-- panel-body -->
                        </div> <!-- panel -->
                    </div> <!-- col -->
                <?php endif; ?>
                <?php if(isset($edit_parent)): ?>
                    <div class="col-sm-4">
                        <div class="panel panel-border panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title">Top Menu</h3>
                            </div>
                            <div class="panel-body">
                                <?php echo form_open("administrator/module/edit/$single->id/$cat_id/parent"); ?>
                                    <div class="form-group">
                                        <label for="name">Top Menu Name</label><small class="req"> *</small> 
                                        <input required name="name" value="<?= $single->name ?>" type="text" class="form-control" id="name" placeholder="Enter Top Menu Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="position">Position</label><small class="req"> *</small> 
                                        <input required name="position" value="<?= $single->position ?>" type="text" class="form-control" id="position" placeholder="Position">
                                    </div>
                                    <div class="form-group">
                                    <input type="submit" class=" btn btn-primary pull-right" value="Save" name="submit" />
                                    </div>
                                </form>
                            </div> <!-- panel-body -->
                        </div> <!-- panel -->
                    </div> <!-- col -->
                <?php endif; ?>
                <?php if(isset($add)): ?>
                    <div class="col-sm-8">
                        <div class="panel panel-border panel-info">
                            <div class="panel-heading"><h3 class="panel-title">Module Category</h3></div>
                            <div class="panel-body">
                                <?php echo form_open("administrator/module/add"); ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="parent">Select Top Menu</label><small class="req"> *</small> 
                                            <select name="parent" required class="form-control selectpicker"  data-live-search="true" id="parent">
                                                <option value="">--Select--</option>
                                                <?php if(!empty($parent_modules)): ?>
                                                    <?php foreach($parent_modules as $value): ?>
                                                        <option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Sub Menu / Child Menu</label><small class="req"> *</small> 
                                            <input required name="name" type="text" class="form-control" id="name" placeholder="Enter  Menu Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="submenu">Is SubMenu</label><small class="req"> *</small> 
                                            <select name="submenu" required class="form-control selectpicker"  id="submenu">
                                                <option value="">--Select--</option>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subparent">Sub Menu</label>
                                            <select name="subparent"  class="form-control selectpicker"  id="subparent">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="icon">Icon</label><span class="m-l-15"><a class="btn btn-info btn-xs" target="_blank" href="<?php echo site_url("administrator/module/icon"); ?>">Link</a></span>
                                            <input  name="icon" type="text" class="form-control" id="icon" placeholder="Icon">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="position">Position</label><small class="req"> *</small> 
                                            <input required name="position" type="text" class="form-control" id="position" placeholder="Position">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group m-t-22">
                                        <input type="submit" class=" btn btn-primary pull-right" value="Save" name="submit" />
                                        </div>
                                    </div>
                                </form>
                            </div> <!-- panel-body -->
                        </div> <!-- panel -->
                    </div> <!-- col -->
                <?php endif; ?>
                <?php if(isset($edit_submenu)): ?>
                    <div class="col-sm-8">
                        <div class="panel panel-border panel-info">
                            <div class="panel-heading"><h3 class="panel-title">Module Category</h3></div>
                            <div class="panel-body">
                                <?php echo form_open("administrator/module/edit/".$single->id); ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="parent">Select Top Menu</label><small class="req"> *</small> 
                                            <select name="parent" required class="form-control selectpicker"  data-live-search="true" id="parent">
                                                <option value="">--Select--</option>
                                                <?php if(!empty($parent_modules)): ?>
                                                    <?php foreach($parent_modules as $value): ?>
                                                        <option <?php if($value['id']==$single->perm_group_id) echo "selected" ?> value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Sub Menu / Child Menu</label><small class="req"> *</small> 
                                            <input required value="<?php echo $single->name ?>" name="name" type="text" class="form-control" id="name" placeholder="Enter  Menu Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="submenu">Is SubMenu</label><small class="req"> *</small> 
                                            <select name="submenu" required class="form-control selectpicker"  id="submenu">
                                                <option value="">--Select--</option>
                                                <option <?php if($single->submenu==1) echo "selected" ?> value="1">Yes</option>
                                                <option <?php if($single->submenu==0) echo "selected" ?> value="0">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subparent">Sub Menu</label>
                                            <select name="subparent"  class="form-control selectpicker"  id="subparent">
                                                <?php if(!empty($subparent)): ?>
                                                    <?php foreach($subparent as $value): ?>
                                                        <option <?php if($value['id']==$single->subparent) echo "selected" ?> value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="icon">Icon</label><span class="m-l-15"><a class="btn btn-info btn-xs" target="_blank" href="<?php echo site_url("administrator/module/icon"); ?>">Link</a></span>
                                            <input  name="icon" type="text" value="<?= $single->icon ?>" class="form-control" id="icon" placeholder="Icon">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="position">Position</label><small class="req"> *</small> 
                                            <input required name="position" value="<?= $single->position ?>" type="text" class="form-control" id="position" placeholder="Position">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group m-t-22 m-l-15">
                                        <input type="submit" class=" btn btn-info pull-right"  value="Save"/>
                                        </div>
                                    </div>
                                </form>
                            </div> <!-- panel-body -->
                        </div> <!-- panel -->
                    </div> <!-- col -->
                <?php endif; ?>
            </div> <!-- End row -->
        <?php endif; ?>
        <?php if(isset($all_module)): ?>
            <?php if(hasPermission("module",VIEW)): ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-border panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title">Module Control</h3>
                            </div>
                            <div class="panel-body">
                                <?php echo form_open("administrator/module/moduleUpdate",array("role"=>"form")); ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Module Name</th>
                                                        <th>Is Active</th>
                                                        <th>Child Module Name</th>
                                                        <th>Enable View</th>
                                                        <th>Enable Add</th>
                                                        <th>Enable Edit</th>
                                                        <th>Enable Delete</th>
                                                        <th>Delete</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if(isset($all_module)&&count($all_module)>0): ?>
                                                        <?php foreach($all_module as $key=>$value): ?>
                                                            <tr>
                                                                <th>
                                                                    <input type="hidden" name="group_id[]" value="<?php echo $value['group_id']; ?>" />
                                                                    <?php echo $value['group_name'];  ?><br />
                                                                    <span class="m-l-15"><input value="<?php echo $value['group_id']; ?>" class="group" type="checkbox"></span>
                                                                </th>
                                                                <td>
                                                                	<label class="switch">
                                                                        <input class="inputswitch" value="<?php echo $value['group_id']; ?>" <?php if($value['is_active']=="1") echo "checked"; ?> type="checkbox" name="onof">
                                                                        <span class="slider round"></span>
                                                                    </label>
                                                                </td>
                                                                <?php if (!empty($value['category'])): ?>
                                                                        <td>
                                                                        
                                                                            <input type="hidden" name="cat_id[]" value="<?php echo $value['category'][0]['cat_id']; ?>" />
                                                                            <?php echo $value['category'][0]['category_name']; ?>
                                                                        </td>
                                                                        <td>
                                                                            <label class="">
                                                                                <input type="checkbox" class="group_<?php echo $value['group_id']; ?>" name="<?php echo "enable_view-cat_" . $value['category'][0]['cat_id']; ?>" value="<?php echo $value['category'][0]['cat_id']; ?>" <?php echo set_checkbox("enable_view-cat_" . $value['category'][0]['cat_id'], $value['category'][0]['cat_id'], ($value['category'][0]['enable_view'] == 1) ? TRUE : FALSE); ?> />
                                                                            </label> 
                                                                        </td>

                                                                        <td>
                                                                            <label class="">
                                                                            <input type="checkbox" class="group_<?php echo $value['group_id']; ?>" name="<?php echo "enable_add-cat_" . $value['category'][0]['cat_id']; ?>" value="<?php echo $value['category'][0]['cat_id']; ?>" <?php echo set_checkbox("enable_add-cat_" . $value['category'][0]['cat_id'], $value['category'][0]['cat_id'], ($value['category'][0]['enable_add'] == 1) ? TRUE : FALSE); ?> />
                                                                            </label> 

                                                                        </td>

                                                                        <td>
                                                                            <label class="">
                                                                            <input type="checkbox" class="group_<?php echo $value['group_id']; ?>" name="<?php echo "enable_edit-cat_" . $value['category'][0]['cat_id']; ?>" value="<?php echo $value['category'][0]['cat_id']; ?>" <?php echo set_checkbox("enable_edit-cat_" . $value['category'][0]['cat_id'], $value['category'][0]['cat_id'], ($value['category'][0]['enable_edit'] == 1) ? TRUE : FALSE); ?> />
                                                                            </label> 
                                                                        </td>

                                                                        <td>
                                                                            <label class="">
                                                                            <input type="checkbox" class="group_<?php echo $value['group_id']; ?>" name="<?php echo "enable_delete-cat_" . $value['category'][0]['cat_id']; ?>" value="<?php echo $value['category'][0]['cat_id']; ?>" <?php echo set_checkbox("enable_delete-cat_" . $value['category'][0]['cat_id'], $value['category'][0]['cat_id'], ($value['category'][0]['enable_delete'] == 1) ? TRUE : FALSE); ?> />
                                                                            </label> 
                                                                        </td>
                                                                        <td class="text-center">
                                                                        <?php if($value['category'][0]['short_code']==$value['short_code']): ?>
                                                                            <a  class="btn btn-info btn-xs " href="<?php echo  site_url("administrator/module/edit/". $value['group_id'].'/'.$value['category'][0]['cat_id']."/parent") ?>"><i class="fa fa-edit"></i></a>
                                                                            <a onclick="return confirm('Are Your sure want to delete this?');" class="btn btn-danger btn-xs " href="<?php echo  site_url("administrator/module/delete/". $value['group_id'].'/'.$value['category'][0]['cat_id']."/parent") ?>"><i class="fa fa-trash"></i></a>
                                                                        <?php else:?>
                                                                            <a  class="btn btn-info btn-xs " href="<?php echo  site_url("administrator/module/edit/".$value['category'][0]['cat_id']) ?>"><i class="fa fa-edit"></i></a>
                                                                            <a onclick="return confirm('Are Your sure want to delete this?');" class="btn btn-danger btn-xs " href="<?php echo  site_url("administrator/module/delete/".$value['category'][0]['cat_id']) ?>"><i class="fa fa-trash"></i></a>
                                                                        <?php endif;?>
                                                                        </td>
                                                                <?php else: ?>
                                                                    <td colspan="7"></td>
                                                                <?php endif;?>
                                                            </tr>
                                                            <?php if(!empty($value["category"])&& count($value["category"]) > 1): ?>
                                                                <?php unset($value["category"][0]); ?>
                                                                <?php foreach($value["category"] as $new_feature_key => $new_feature_value): ?>
                                                                    <tr>
                                                                        <td>
                                                                        </td>
                                                                        <td>
                                                                        </td>
                                                                        <td>
                                                                            <input type="hidden" name="cat_id[]" value="<?php echo $new_feature_value['cat_id']; ?>" />
                                                                            <?php echo $new_feature_value['category_name']; ?>
                                                                        </td>
                                                                        <td>
                                                                            <label class="">
                                                                                <input type="checkbox" class="group_<?php echo $value['group_id']; ?>" name="<?php echo "enable_view-cat_" . $new_feature_value['cat_id']; ?>" value="<?php echo $new_feature_value['cat_id']; ?>" <?php echo set_checkbox("enable_view-cat_" . $new_feature_value['cat_id'], $new_feature_value['cat_id'], ($new_feature_value['enable_view'] == 1) ? TRUE : FALSE); ?> />
                                                                            </label> 
                                                                        </td>

                                                                        <td>
                                                                            <label class="">
                                                                            <input type="checkbox" class="group_<?php echo $value['group_id']; ?>" name="<?php echo "enable_add-cat_" . $new_feature_value['cat_id']; ?>" value="<?php echo $new_feature_value['cat_id']; ?>" <?php echo set_checkbox("enable_add-cat_" . $new_feature_value['cat_id'], $new_feature_value['cat_id'], ($new_feature_value['enable_add'] == 1) ? TRUE : FALSE); ?> />
                                                                            </label> 

                                                                        </td>

                                                                        <td>
                                                                            <label class="">
                                                                            <input type="checkbox" class="group_<?php echo $value['group_id']; ?>" name="<?php echo "enable_edit-cat_" . $new_feature_value['cat_id']; ?>" value="<?php echo $new_feature_value['cat_id']; ?>" <?php echo set_checkbox("enable_edit-cat_" . $new_feature_value['cat_id'], $new_feature_value['cat_id'], ($new_feature_value['enable_edit'] == 1) ? TRUE : FALSE); ?> />
                                                                            </label> 
                                                                        </td>

                                                                        <td>
                                                                            <label class="">
                                                                            <input type="checkbox" class="group_<?php echo $value['group_id']; ?>" name="<?php echo "enable_delete-cat_" . $new_feature_value['cat_id']; ?>" value="<?php echo $new_feature_value['cat_id']; ?>" <?php echo set_checkbox("enable_delete-cat_" . $new_feature_value['cat_id'], $new_feature_value['cat_id'], ($new_feature_value['enable_delete'] == 1) ? TRUE : FALSE); ?> />
                                                                            </label> 
                                                                        </td>
                                                                        <td class="text-center">
                                                                        <?php if($new_feature_value['short_code']==$value['short_code']): ?>
                                                                            <a  class="btn btn-info btn-xs " href="<?php echo  site_url("administrator/module/edit/". $value['group_id'].'/'.$new_feature_value['cat_id']."/parent") ?>"><i class="fa fa-edit"></i></a>
                                                                            <a onclick="return confirm('Are Your sure want to delete this?');" class="btn btn-danger btn-xs " href="<?php echo  site_url("administrator/module/delete/". $value['group_id'].'/'.$new_feature_value['cat_id']."/parent") ?>"><i class="fa fa-trash"></i></a>
                                                                        <?php else:?>
                                                                            <a  class="btn btn-info btn-xs " href="<?php echo  site_url("administrator/module/edit/".$new_feature_value['cat_id']) ?>"><i class="fa fa-edit"></i></a>
                                                                            <a onclick="return confirm('Are Your sure want to delete this?');" class="btn btn-danger btn-xs " href="<?php echo  site_url("administrator/module/delete/".$new_feature_value['cat_id']) ?>"><i class="fa fa-trash"></i></a>
                                                                        <?php endif;?>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            <?php endif;?>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn-lg btn btn-primary pull-right" value="Save" name="submit" />
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
<script src="<?php echo VENDOR_URL; ?>notifications/notify.min.js"></script>
<script src="<?php echo VENDOR_URL; ?>notifications/notify-metro.js"></script>
<script src="<?php echo VENDOR_URL; ?>notifications/notifications.js"></script>
<script>
    $(document).ready(function(){
        $('#parent_module').on('submit',function(e){
            e.preventDefault();
            var url="<?php echo base_url(); ?>ajax/add_parent";
            $.ajax({
                url:url,
                type:"post",
                dataType:"json",
                data:$("#parent_module").serialize(),
                success:function(data){
                    $.Notification.autoHideNotify('success', 'top right', 'Top Menu Add Successfully');
                    $("#name").val('');
                    $("#parent_module #position").val('');
                    if(data!=''){
                        $("#parent").find('option').remove();
                        $("#parent").append('<option value="">--Select--</option>')
                        $.each(data,function(key,value){
                            $("#parent").append('<option value="'+ value.id +'">'+ value.name +'</option>')
                        });
                        $("#parent").selectpicker('render').selectpicker('refresh');
                    }
                }
            });
        });
        $(".inputswitch").on("click",function(){
            var value=0;
            var id='';
            var url="<?php echo site_url("administrator/module/control"); ?>";
            if($(this).is(":checked"))
            {
                value=1;
                id=$(this).val();
            }
            else{
                value=0;
                id=$(this).val();
            }
            $.ajax({
                type: "POST",
                url: url,
                data: {'module_id': id,"value":value},
                dataType: "json",
                success: function (data) {
                }
            });
        });
        $("#parent").on("change",function(){
            var parent_id=$(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>ajax/get_subparent",
                data: {'parent_id': parent_id},
                dataType: "json",
                success: function (data) {
                    $("#subparent").find('option').remove();
                    $("#subparent").selectpicker("refresh");
                    if(data!=''){
                        $("#subparent").append('<option value="">--Select--</option>')
                        $.each(data,function(key,value){
                            $("#subparent").append('<option value="'+ value.id +'">'+ value.name +'</option>')
                        });
                        $("#subparent").selectpicker('render').selectpicker('refresh');
                    }
                }
            });
        });
    });
</script>
<script>
    $(".group").on("click",function(){
       var group_id=$(this).val();
        $('.group_'+group_id).not(this).prop('checked', this.checked);

    });
</script>
