 <div class="content">
     <?php echo $this->session->flashdata("msg"); ?>
     <div class="container">
         <?php if (hasPermission("sms", EDIT)) : ?>
             <div class="row">
                 <div class="col-sm-12">
                     <div class="panel panel-border panel-info">
                         <div class="panel-heading">
                             <h3 class="panel-title">Sms Setting </h3>
                         </div>
                         <div class="panel-body">
                             <!-- <form id="find"> -->
                             <?php echo form_open("setting/sms/edit"); ?>
                             <div class="row">
                                 <div class="col-md-3">
                                     <div class="form-group">
                                         <label for="api_key">Bulk Api Key<small class="req"> *</small></label>
                                         <input required type="api_key" class="form-control" name="api_key" value="<?php echo $single->api_key; ?>">
                                     </div>
                                 </div>
                                 <div class="col-md-3">
                                     <div class="form-group">
                                         <label for="sender_id">Bulk Sender Id<small class="req"> *</small></label>
                                         <input required type="text" class="form-control" name="sender_id" value="<?php echo $single->sender_id; ?>">
                                     </div>
                                 </div>
                                 <div class="col-md-3">
                                     <div class="form-group">
                                         <label for="url">Api Url<small class=" req"> *</small></label>
                                         <input required type="url" class="form-control" name="url" value="<?php echo $single->url; ?>">
                                     </div>
                                 </div>
                                 <div class="col-md-3">
                                     <div class="form-group">
                                         <label for="type">Type<small class=" req"> *</small></label>
                                         <select class="form-control" name="type" id="">
                                             <option <?php if ($single->type == "text") echo "selected"; ?> value="text">Text</option>
                                             <option <?php if ($single->type == "unicode") echo "selected"; ?> value="unicode">Unicode</option>
                                         </select>
                                     </div>
                                 </div>
                                 <div class="col-md-3">
                                     <div class="form-group">
                                         <label for="status">Status<small class=" req"> *</small></label>
                                         <select class="form-control" name="status" id="">
                                             <option <?php if ($single->status == "disabled") echo "selected"; ?> value="disabled">Disabled</option>
                                             <option <?php if ($single->status =="enabled") echo "selected"; ?> value="enabled">Enabled</option>
                                         </select>
                                     </div>
                                 </div>
                             </div>
                             <div class="col-sm-4">
                                 <div class="form-group pull-left m-t-22">
                                     <input type="submit" value="Update" id="submit" name="submit" class="btn btn-primary">
                                 </div>
                             </div>
                         </div>
                         </form>
                     </div> <!-- panel-body -->
                 </div> <!-- panel -->
             </div> <!-- col -->
         </div> <!-- End row -->
     <?php endif; ?>
 </div> <!-- container -->
 </div>