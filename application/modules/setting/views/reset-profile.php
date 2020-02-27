 <div class="content">
     <?php echo $this->session->flashdata("msg"); ?>
     <div class="container">
         <?php if (hasPermission("reset_profile", EDIT)) : ?>
             <div class="row">
                 <div class="col-sm-12">
                     <div class="panel panel-border panel-info">
                         <div class="panel-heading">
                             <h3 class="panel-title">Reset Password </h3>
                         </div>
                         <div class="panel-body">
                             <!-- <form id="find"> -->
                             <?php echo form_open("setting/general/reset"); ?>
                             <div class="row">
                                 <div class="col-sm-4">
                                     <div class="form-group">
                                         <label for="username">User Name</label><small class="req"> *</small>
                                         <input type="text" <?php if(!is_super_admin()) echo "readonly"; ?> value="<?php echo $single->username; ?>" placeholder="Username" required id="username" name="username" class="form-control">
                                         <input type="hidden" value="<?php echo $single->id; ?>" required id="id" name="id" class="form-control">
                                     </div>
                                 </div>
                                 <div class="col-sm-4">
                                     <div class="form-group">
                                         <label for="password">Password</label>
                                         <input type="password" placeholder="Password" id="password" name="password" class="form-control">
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