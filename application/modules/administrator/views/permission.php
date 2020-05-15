<div class="content">
	<div class="container">
		<?php echo $this->session->flashdata("msg"); ?>
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-border panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Assign Permission (<?php echo @$role_name; ?>)</h3>
					</div>
					<div class="panel-body">
						<?php echo form_open("administrator/role/permission/" . @$role_id, array("role" => "form")); ?>
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>Module Name</th>
										<th>Child Module Name</th>
										<th>Is View</th>
										<th>Is Add</th>
										<th>Is Edit</th>
										<th>Publish Permission</th>
									</tr>
								</thead>
								<tbody>
									<?php if (count($permission_list) > 0) : ?>
										<?php foreach ($permission_list as $key => $value) : ?>
											<?php if (hasPermission($value['group_code'], VIEW) && hasActive($value['group_code'])) : ?>
												<tr>
													<th>
														<?php echo $value['group_name'];  ?><br />
														<span class="m-l-15"><input value="<?php echo $value['group_code']; ?>" class="group" type="checkbox"></span>
													</th>
													<?php if (hasPermission($value['permission'][0]['short_code'], VIEW)) : ?>
														<?php if (!empty($value['permission'])) : ?>
															<td>
																<input type="hidden" name="per_cat[]" value="<?php echo $value['permission'][0]['pc_id']; ?>" />
																<input type="hidden" name="<?php echo "roles_permissions_id_" . $value['permission'][0]['pc_id']; ?>" value="<?php echo  $value['permission'][0]['rp_id']; ?>" />
																<?php echo $value['permission'][0]['name'] ?>
															</td>
															<td>
																<?php if (($value['permission'][0]['enable_view'] == 1) && hasPermission($value['permission'][0]['short_code'], VIEW)) : ?>
																	<label class="">
																		<input class="group_<?php echo $value['group_code']; ?>" type="checkbox" name="<?php echo "can_view-perm_" . $value['permission'][0]['pc_id']; ?>" value="<?php echo $value['permission'][0]['pc_id']; ?>" <?php echo set_checkbox("can_view-perm_" . $value['permission'][0]['pc_id'], $value['permission'][0]['pc_id'], ($value['permission'][0]['can_view'] == 1) ? TRUE : FALSE); ?>>
																	</label>
																<?php endif; ?>
															</td>

															<td>
																<?php if (($value['permission'][0]['enable_add'] == 1) && hasPermission($value['permission'][0]['short_code'], ADD)) : ?>
																	<label class="">
																		<input type="checkbox" class="group_<?php echo $value['group_code']; ?>" name="<?php echo "can_add-perm_" . $value['permission'][0]['pc_id']; ?>" value="<?php echo $value['permission'][0]['pc_id']; ?>" <?php echo set_checkbox("can_view-perm_" . $value['permission'][0]['pc_id'], $value['permission'][0]['pc_id'], ($value['permission'][0]['can_add'] == 1) ? TRUE : FALSE); ?>>
																	</label>
																<?php endif; ?>

															</td>

															<td>
																<?php if (($value['permission'][0]['enable_edit'] == 1) && hasPermission($value['permission'][0]['short_code'], EDIT)) : ?>
																	<label class="">
																		<input type="checkbox" class="group_<?php echo $value['group_code']; ?>" name="<?php echo "can_edit-perm_" . $value['permission'][0]['pc_id']; ?>" value="<?php echo $value['permission'][0]['pc_id']; ?>" <?php echo set_checkbox("can_view-perm_" . $value['permission'][0]['pc_id'], $value['permission'][0]['pc_id'], ($value['permission'][0]['can_edit'] == 1) ? TRUE : FALSE); ?>>
																	</label>
																<?php endif; ?>
															</td>

															<td>
																<?php if (($value['permission'][0]['enable_delete'] == 1) && hasPermission($value['permission'][0]['short_code'], DELETE)) : ?>
																	<label class="">
																		<input type="checkbox" class="group_<?php echo $value['group_code']; ?>" name="<?php echo "can_delete-perm_" . $value['permission'][0]['pc_id']; ?>" value="<?php echo $value['permission'][0]['pc_id']; ?>" <?php echo set_checkbox("can_view-perm_" . $value['permission'][0]['pc_id'], $value['permission'][0]['pc_id'], ($value['permission'][0]['can_delete'] == 1) ? TRUE : FALSE); ?>>
																	</label>
																<?php endif; ?>
															</td>
														<?php else : ?>
															<td colspan="5"></td>
														<?php endif; ?>
													<?php else : ?>
														<td colspan="5"></td>
													<?php endif; ?>
												</tr>
												<?php if (!empty($value["permission"]) && count($value["permission"]) > 1) : ?>
													<?php unset($value["permission"][0]); ?>
													<?php foreach ($value["permission"] as $new_feature_key => $new_feature_value) : ?>
														<?php if (hasPermission($new_feature_value['short_code'], VIEW)) : ?>
															<tr>
																<td></td>
																<td>
																	<input type="hidden" name="per_cat[]" value="<?php echo $new_feature_value['pc_id']; ?>" />
																	<input type="hidden" name="<?php echo "roles_permissions_id_" . $new_feature_value['pc_id']; ?>" value="<?php echo  $new_feature_value['rp_id']; ?>" />
																	<?php echo $new_feature_value['name'] ?>
																</td>
																<td>
																	<?php if ($new_feature_value['enable_view'] == 1 && hasPermission($new_feature_value['short_code'], VIEW)) : ?>
																		<label class="">
																			<input type="checkbox" class="group_<?php echo $value['group_code']; ?>" name="<?php echo "can_view-perm_" . $new_feature_value['pc_id']; ?>" value="<?php echo $new_feature_value['pc_id']; ?>" <?php echo set_checkbox("can_view-perm_" . $new_feature_value['pc_id'], $new_feature_value['pc_id'], ($new_feature_value['can_view'] == 1) ? TRUE : FALSE); ?>>
																		</label>
																	<?php endif; ?>
																</td>

																<td>
																	<?php if ($new_feature_value['enable_add'] == 1 && hasPermission($new_feature_value['short_code'], ADD)) : ?>
																		<label class="">
																			<input type="checkbox" class="group_<?php echo $value['group_code']; ?>" name="<?php echo "can_add-perm_" . $new_feature_value['pc_id']; ?>" value="<?php echo $new_feature_value['pc_id']; ?>" <?php echo set_checkbox("can_view-perm_" . $new_feature_value['pc_id'], $new_feature_value['pc_id'], ($new_feature_value['can_add'] == 1) ? TRUE : FALSE); ?>>
																		</label>
																	<?php endif; ?>

																</td>

																<td>
																	<?php if ($new_feature_value['enable_edit'] == 1 && hasPermission($new_feature_value['short_code'], EDIT)) : ?>
																		<label class="">
																			<input type="checkbox" class="group_<?php echo $value['group_code']; ?>" name="<?php echo "can_edit-perm_" . $new_feature_value['pc_id']; ?>" value="<?php echo $new_feature_value['pc_id']; ?>" <?php echo set_checkbox("can_view-perm_" . $new_feature_value['pc_id'], $new_feature_value['pc_id'], ($new_feature_value['can_edit'] == 1) ? TRUE : FALSE); ?>>
																		</label>
																	<?php endif; ?>
																</td>

																<td>
																	<?php if ($new_feature_value['enable_delete'] == 1  && hasPermission($new_feature_value['short_code'], DELETE)) : ?>
																		<label class="">
																			<input type="checkbox" class="group_<?php echo $value['group_code']; ?>" name="<?php echo "can_delete-perm_" . $new_feature_value['pc_id']; ?>" value="<?php echo $new_feature_value['pc_id']; ?>" <?php echo set_checkbox("can_view-perm_" . $new_feature_value['pc_id'], $new_feature_value['pc_id'], ($new_feature_value['can_delete'] == 1) ? TRUE : FALSE); ?>>
																		</label>
																	<?php endif; ?>
																</td>
															</tr>
														<?php endif; ?>
													<?php endforeach; ?>
												<?php endif; ?>
											<?php endif; ?>
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

	</div> <!-- container -->

</div>
<script>
	$(".group").on("click", function() {
		var group_code = $(this).val();
		$('.group_' + group_code).not(this).prop('checked', this.checked);

	});
</script>
