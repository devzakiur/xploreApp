 <div class="content">
     <?php echo $this->session->flashdata("msg"); ?>
     <div class="container">
         <?php if (hasPermission("general", EDIT)) : ?>
             <div class="row">
                 <div class="col-sm-12">
                     <div class="panel panel-border panel-info">
                         <div class="panel-heading">
                             <h3 class="panel-title">General Setting </h3>
                         </div>
                         <div class="panel-body">
                             <!-- <form id="find"> -->
                             <?php echo form_open_multipart("setting/general/edit/" . $single->id); ?>
                             <div class="row">
                                 <div class="col-sm-4">
                                     <div class="form-group">
                                         <label for="company_name">Company Name</label><small class="req"> *</small>
                                         <input type="text" placeholder="Company Name" required id="company_name" value="<?php echo @$single->company_name; ?>" name="company_name" class="form-control">
                                         <input type="hidden" required id="id" value="<?php echo @$single->id; ?>" name="id" class="form-control">
                                     </div>
                                 </div>
                                 <div class="col-sm-4">
                                     <div class="form-group">
                                         <label for="time_zone">Time Zone</label><small class="req"> *</small>
                                         <select required name="time_zone" class="form-control selectpicker" id="time_zone" data-live-search="true">
                                             <option value="">--Select--</option>
                                             <?php foreach ($timezone as $key => $value) : ?>
                                                 <option <?php if ($key == $single->time_zone) echo "selected"; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                             <?php endforeach; ?>
                                         </select>
                                     </div>
                                 </div>
                                 <div class="col-sm-4">
                                     <div class="form-group">
                                         <label for="running_session">Running Session</label><small class="req"> *</small>
                                         <select required name="running_session" class="form-control selectpicker" id="running_session" data-live-search="true">
                                             <option value="">--Select--</option>
                                             <?php foreach ($session as $key => $value) : ?>
                                                 <option <?php if ($value['id'] == $single->running_session) echo "selected"; ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                             <?php endforeach; ?>
                                         </select>
                                     </div>
                                 </div>
                                 <div class="col-sm-4">
                                     <div class="form-group">
                                         <label for="address">Address</label><small class="req"> *</small>
                                         <textarea required name="address" id="address" class="form-control"><?php echo $single->address ?></textarea>
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
 <script src="<?php echo VENDOR_URL; ?>bootstrap-filestyle/src/bootstrap-filestyle.min.js"></script>
 <script>
     $(document).ready(function() {
         $(":file").filestyle();
     });
 </script>