 <div class="content">
     <?php echo $this->session->flashdata("msg"); ?>
     <div class="container">
         <?php if (hasPermission("social", EDIT)) : ?>
             <div class="row">
                 <div class="col-sm-12">
                     <div class="panel panel-border panel-info">
                         <div class="panel-heading">
                             <h3 class="panel-title">Social Manage </h3>
                         </div>
                         <div class="panel-body">
                             <!-- <form id="find"> -->
                             <?php echo form_open("social/add"); ?>
                             <div class="row">
                                 <div class="col-sm-4">
                                     <div class="form-group">
                                         <label for="facebook">Facebook</label>
                                         <input type="text" placeholder="Facebook" value="<?= @$single->facebook ?>" id="facebook" name="facebook" class="form-control">
                                         <input type="hidden"  value="<?= @$single->id ?>" name="id">
                                     </div>
                                 </div>
                                 <div class="col-sm-4">
                                     <div class="form-group">
                                         <label for="twitter">Twitter</label>
                                         <input type="text" placeholder="Twitter" value="<?= @$single->twitter ?>" id="twitter" name="twitter" class="form-control">
                                     </div>
                                 </div>
                                 <div class="col-sm-4">
                                     <div class="form-group">
                                         <label for="linked_in">Linked In</label>
                                         <input type="text" placeholder="Linked In" value="<?= @$single->linked_in ?>" id="linked_in" name="linked_in" class="form-control">
                                     </div>
                                 </div>
                                 <div class="col-sm-4">
                                     <div class="form-group">
                                         <label for="youtube">Youtube</label>
                                         <input type="text" placeholder="Youtube" value="<?= @$single->youtube ?>" id="youtube" name="youtube" class="form-control">
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
