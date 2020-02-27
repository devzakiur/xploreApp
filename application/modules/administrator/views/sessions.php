<div class="content">
    <?php $data['msg']="Welcome To Manage Session"; ?>
    <?php $this->load->view("message",$data) ?>
    <div class="container">
        <div class="row">
        <?php  if(hasPermission("manage_session",ADD)): ?>
                <?php if(isset($add)): ?>
                    <div class="col-sm-6">
                        <div class="panel panel-border panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title">Manage Session</h3>
                            </div>
                            <div class="panel-body">
                                    <?php echo form_open("administrator/sessions/add"); ?>
                                        <div class="form-group">
                                            <label for="name">Session Name</label><small class="req"> *</small> 
                                            <input required name="name" type="text" class="form-control" id="name" placeholder="Enter Session Name(2018-2019)">
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Note</label>
                                            <textarea  placeholder="Enter Description " name="note" class="form-control"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class=" btn btn-primary pull-right" value="Save" name="submit" />
                                        </div>
                                    </form>
                            </div> <!-- panel-body -->
                        </div> <!-- panel -->
                    </div> <!-- col -->
                <?php endif; ?>
        <?php endif; ?>
        <?php  if(hasPermission("manage_session",EDIT)): ?>
            <?php if(isset($edit)): ?>
                <div class="col-sm-6">
                    <div class="panel panel-border panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Manage Session</h3>
                        </div>
                        <div class="panel-body">
                                <?php echo form_open("administrator/sessions/edit/".$single->id); ?>
                                    <div class="form-group">
                                        <label for="name">Session Name</label><small class="req"> *</small> 
                                        <input required name="id" value="<?php echo @$single->id; ?>" type="hidden" class="form-control" id="id" >
                                        <input required name="name" value="<?php echo @$single->name; ?>" type="text" class="form-control" id="name" placeholder="Enter Session Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Note</label>
                                        <textarea placeholder="Enter Description " name="note" class="form-control"><?php echo @$single->note; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class=" btn btn-primary pull-right" value="Save" name="submit" />
                                    </div>
                                </form>
                        </div> <!-- panel-body -->
                    </div> <!-- panel -->
                </div> <!-- col -->
            <?php endif; ?>
        <?php endif; ?>
            <?php if(hasPermission("manage_session",VIEW)): ?>
                <div class="col-sm-6">
                    <div class="panel panel-border panel-info">
                        <div class="panel-heading"><h3 class="panel-title">All Session</h3></div>
                        <div class="panel-body">
                            <div class="">
                                <table id="datatable" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Note</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(count($session)>0): ?>
                                        <?php foreach($session as $key=>$value): ?>
                                        <tr>
                                            <td><?php echo ++$key; ?></td>
                                            <td><?php echo $value['name']; ?></td>
                                            <td><?php echo $value['note']; ?></td>
                                            <td class="actions btn-group-xs">
                                                <?php if(hasPermission("manage_session",EDIT)): ?>
                                                    <a data-toggle="tooltip" data-placement="top" title="Edit" href="<?php echo site_url("administrator/sessions/edit/".$value['id']); ?>" class=" btn btn-default btn-xs  waves-effect"><i class="fa fa-edit"></i></a>
                                                <?php endif;?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- panel-body -->
                    </div> <!-- panel -->
                </div> <!-- col -->
            <?php endif; ?>
        </div> <!-- End row -->

    </div> <!-- container -->
                
</div>
<script src="<?php echo VENDOR_URL; ?>datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo VENDOR_URL; ?>datatables/dataTables.bootstrap.min.js"></script>
<script>
    //datatable
    $('#datatable').dataTable({
        "info":false,
        "autoWidth": false,
        "lengthChange": false,
        "paging":false
    });
</script>