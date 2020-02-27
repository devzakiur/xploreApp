<div class="content">
    <div class="container">
<?php echo $this->session->flashdata("msg"); ?>
        <?php echo form_open("module/mlist"); ?>
            <div class="col-md-12">
				<div class="panel panel-border panel-info">
					<div class="panel-heading"><h3 class="panel-title">Module List</h3></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                             <?php if(isset($submenu)): ?>
                                <?php foreach($submenu as $key=>$value): ?>
                                <!-- top menu -->
                                        <li><strong><?php echo $value['name']; ?></strong> = <?= site_url().$value['link'] ?>
                                        <input type="checkbox" class="Checkall" value="<?= $value['short_code'] ?>" <?php echo set_check_box($value['short_code']) ?> name="short_code_<?= $value['short_code'] ?>">
                                        <input type="hidden" value="<?= $value['short_code'] ?>" name="short_code_hidden[<?= $value['short_code'] ?>]">
                                            <?php if(!empty($value[$key])): ?>
                                            <!-- menu -->
                                                <ul>
                                                    <?php foreach($value[$key] as $sub_key=>$subvalue): ?>
                                                            <li><strong><?php echo $subvalue['name']; ?></strong> = <?= site_url().$subvalue['link'] ?> 
                                                            <input type="checkbox" class="Checkall" value="<?= $value['short_code'] ?>" <?php echo set_check_box($subvalue['short_code']) ?> name="short_code_<?= $subvalue['short_code'] ?>">
                                                            <input type="hidden" value="<?= $subvalue['short_code'] ?>" name="short_code_hidden[<?= $subvalue['short_code'] ?>]">

                                                                <?php if(!empty($subvalue[$sub_key])): ?>
                                                                    <!-- sub menu -->
                                                                    <ul style="">
                                                                        <?php foreach($subvalue[$sub_key] as $seceond_sub_key=>$second_sub_value): ?>
                                                                                <li ><strong><?php echo $second_sub_value['name']; ?></strong> =  <?= site_url().$second_sub_value['link'] ?> 
                                                                                <input type="checkbox" class="Checkall" value="<?= $second_sub_value['short_code'] ?>" <?php echo set_check_box($second_sub_value['short_code']) ?> name="short_code_<?= $second_sub_value['short_code'] ?>">
                                                                                <input type="hidden" value="<?= $second_sub_value['short_code'] ?>" name="short_code_hidden[<?= $second_sub_value['short_code'] ?>]">
                                                                        <?php endforeach; ?>
                                                                    </ul>
                                                                <?php endif; ?>
                                                            </li>
                                                    <?php endforeach;?>
                                                </ul>
                                            <?php endif; ?>
                                        </li>
                                <?php endforeach; ?>
                                <?php endif;?>
                               <span style="padding: 20px"><input type="checkbox" id="checkAll"><label for="checkAll">Check All</label></span>
                            </div>
                        </div>
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3">
                                    <div class="form-group text-center">
                                        <button  type="submit" class="btn btn-primary"><i class="md md-add m-r-5"></i>Add</button>
                                    </div>
                                </div>
                            </div>
                    </div> <!-- panel-body -->
                </div> <!-- panel -->
            </div>
        </form>
        </div>
    </div> <!-- container -->

</div>
<script>
    $("#checkAll").click(function () {
        $('.Checkall').not(this).prop('checked', this.checked);
    });
</script>
