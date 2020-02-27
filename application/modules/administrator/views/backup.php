<div class="content">
    <?php $data['msg']="Welcome To Backup"; ?>
    <?php $this->load->view("message",$data) ?>
     <div class="container">
         <div class="row">
             <div class="col-sm-6">
                 <div class="panel panel-border panel-info">
                     <div class="panel-heading">
                         <h3 class="panel-title">Backup Restore</h3>
                     </div>
                     <div class="panel-body">
                         <?php if (hasPermission("backup", VIEW)) : ?>
                             <?php echo form_open_multipart("administrator/backup/restore"); ?>
                             <div class="form-group">
                                 <label for="name">Sql File</label><small class="req"> *</small>
                                 <span style="font-size:10px;" class="">(SQL)</span>
                                 <input required name="file" type="file" class="form-control" id="name" placeholder="Enter Session Name(2018-1019)">
                             </div>
                             <div class="form-group">
                                 <input type="submit" class=" btn btn-primary pull-left" value="Restore Backup" name="submit" />
                             </div>
                             </form>
                         <?php endif; ?>
                     </div> <!-- panel-body -->
                 </div> <!-- panel -->
             </div> <!-- col -->
         </div> <!-- End row -->
         <div class="row">
             <div class="col-sm-6">
                 <div class="panel panel-border panel-info">
                     <div class="panel-heading">
                         <h3 class="panel-title">Download Backup</h3>
                     </div>
                     <div class="panel-body">
                         <?php if (hasPermission("backup", ADD)) : ?>
                             <a href="<?php echo site_url("administrator/backup/create"); ?>" class="btn btn-info">Download Backup</a>
                         <?php endif; ?>
                     </div> <!-- panel-body -->
                 </div> <!-- panel -->
             </div> <!-- col -->
         </div> <!-- End row -->
     </div> <!-- container -->
 </div>
 <script src="<?php echo VENDOR_URL; ?>bootstrap-filestyle/src/bootstrap-filestyle.min.js"></script>
 <script>
     $(document).ready(function() {
         $(":file").filestyle();
     });
 </script>