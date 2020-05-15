<div class="content">
	<div class="container">
		<?php echo $this->session->flashdata("msg"); ?>
		<?php if (hasPermission("question", ADD)) : ?>
			<?php if (isset($add)) : ?>
				<div class="row">
					<div class="col-sm-12">
						<div class="panel-group" id="accordion-test-2">
							<div class="panel panel-border panel-info">
								<div class="panel-heading">
									<h3 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion-test-2" href="#collapseOne-2" aria-expanded="false" class="collapsed">
											Manage Question
										</a>
									</h3>
								</div>
								<div id="collapseOne-2" class="panel-collapse collapse">
									<div class="panel-body">
										<form id="question_add" enctype="multipart/form-data">
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group">
														<label for="title">Title</label><small class="req"> *</small>
														<input type="text" name="title" placeholder="Title" class="form-control" required id="title">
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label for="picture">Picture</label>(<code>JPG,PNG MAX SIZE 500 KB</code>)
														<input type="file" id="picture" data-max-file-size="500K" data-allowed-file-extensions="jpg png" name="picture" class="form-control">
													</div>
												</div>
												<div class="col-sm-3">
													<div class="form-group">
														<label for="option_a">Option A</label><small class="req"> *</small>
														<input type="text" name="option_a" placeholder="Option A" class="form-control" required id="option_a">
													</div>
												</div>
												<div class="col-sm-3">
													<div class="form-group">
														<label for="option_b">Option B</label><small class="req"> *</small>
														<input type="text" name="option_b" placeholder="Option B" class="form-control" required id="option_b">
													</div>
												</div>
												<div class="col-sm-3">
													<div class="form-group">
														<label for="option_c">Option C</label>
														<input type="text" name="option_c" placeholder="Option C" class="form-control" id="option_c">
													</div>
												</div>
												<div class="col-sm-3">
													<div class="form-group">
														<label for="option_d">Option D</label>
														<input type="text" name="option_d" placeholder="Option D" class="form-control" id="option_d">
													</div>
												</div>
												<!-- <div class="col-sm-3">
													<div class="form-group">
														<label for="option_e">Option E</label>
														<input type="text" name="option_e" placeholder="Option E" class="form-control" id="option_e">
													</div>
												</div>
												<div class="col-sm-3">
													<div class="form-group">
														<label for="option_f">Option F</label>
														<input type="text" name="option_f" placeholder="Option F" class="form-control" id="option_f">
													</div>
												</div>
												<div class="col-sm-3">
													<div class="form-group">
														<label for="option_g">Option G</label>
														<input type="text" name="option_g" placeholder="Option G" class="form-control" id="option_g">
													</div>
												</div>
												<div class="col-sm-3">
													<div class="form-group">
														<label for="option_h">Option H</label>
														<input type="text" name="option_h" placeholder="Option H" class="form-control" id="option_h">
													</div>
												</div> -->
												<div class="col-sm-3">
													<div class="form-group">
														<label for="answer">Answer</label><small class="req"> *</small>
														<select id="answer" required name="answer" class="form-control selectpicker">
															<option value="">--Select--</option>
															<option value="1">Option A</option>
															<option value="2">Option B</option>
															<option value="3">Option C</option>
															<option value="4">Option D</option>
															<!-- <option value="5">Option E</option>
															<option value="6">Option F</option>
															<option value="7">Option G</option>
															<option value="8">Option H</option>
															<option value="9">All Correct</option> -->
														</select>
													</div>
												</div>
												<div class="col-sm-3">
													<div class="form-group">
														<label for="difficulty">Level</label><small class="req"> *</small>
														<select id="difficulty" required name="difficulty" class="form-control selectpicker">
															<option value="">--Select--</option>
															<option value="1">Basic</option>
															<option value="2">Intermediate</option>
															<option value="3">Advanced</option>
														</select>
													</div>
												</div>
												<div class="col-sm-3">
													<div class="form-group">
														<label for="name">Position</label><small class="req"> *</small>
														<input type="number" name="position" placeholder="Position" class="form-control" required id="position">
													</div>
												</div>
												<div class="col-sm-3">
													<div class="form-group">
														<label for="is_math">Is Math?</label><small class="req"> *</small>
														<select id="is_math" required name="is_math" class="form-control selectpicker">
															<option value="">--Select--</option>
															<option value="1">Yes</option>
															<option value="0">No</option>
														</select>
													</div>
												</div>
												<div class="col-sm-12">
													<div id="category_part">
														<div class="category_append" id="1">
															<div class="col-sm-3">
																<div class="form-group">
																	<label for="subject_id">Subject</label>
																	<select id="subject_id" name="subject_id" class="form-control selectpicker" data-cotainer="body" data-live-search="true">
																		<option value="">--Select--</option>
																		<?php if (count($subject) > 0) : ?>
																			<?php foreach ($subject as $value) : ?>
																				<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
																			<?php endforeach; ?>
																		<?php endif; ?>
																	</select>
																</div>
															</div>
															<div class="col-sm-3">
																<div class="form-group">
																	<label for="section_id">Section</label>
																	<select id="section_id" name="section_id" class="form-control selectpicker" data-cotainer="body" data-live-search="true">
																		<option value="">--Select--</option>
																	</select>
																</div>
															</div>
															<div class="col-sm-3">
																<div class="form-group">
																	<label for="topic_id">Topic</label><small class="req"> *</small>
																	<input type="hidden" name="topic_hidden_id[]" id="topic_hidden" value="1">
																	<div class="input-group">
																		<select id="topic_id" required name="topic_id_1" class="form-control selectpicker topic_id" data-cotainer="body" data-live-search="true">
																			<option value="">--Select--</option>

																		</select>
																		<div class="input-group-btn">
																			<button class="btn btn-success" id="topic_reload" type="button">
																				<i class="md  md-autorenew"></i>
																			</button>
																		</div>
																	</div>
																</div>
															</div>
															<div class="col-sm-3">
																<div class="form-group">
																	<label for="category_id">Category</label><small class="req"> *</small>
																	<div class="input-group">
																		<select id="category_id" name="category_id_1[]" data-container="body" required multiple class="form-control selectpicker" data-live-search="true">
																		</select>
																		<div class="input-group-btn">
																			<button class="btn btn-info" id="category_add_button" type="button">
																				<i class="md md-add"></i>
																			</button>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="col-sm-12">
													<div id="bsc_part">
														<div class="col-sm-6">
															<div class="form-group">
																<label for="question_batch">Batch</label>
																<div class="input-group">
																	<select id="question_batch" name="question_batch[]" data-container="body" class="form-control selectpicker" data-live-search="true">
																		<option value="">--Select--</option>
																		<?php foreach ($batch as $value) : ?>
																			<option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
																		<?php endforeach; ?>
																	</select>
																	<div class="input-group-btn">
																		<button class="btn btn-success" id="batch_reload" type="button">
																			<i class="md  md-autorenew"></i>
																		</button>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-sm-6">
															<div class="form-group">
																<label for="question_year">Year</label>
																<div class="input-group">
																	<select id="question_year" name="question_year[]" data-container="body" class="form-control selectpicker" data-live-search="true">
																		<option value="">--Select--</option>
																		<?php foreach ($year as $value) : ?>
																			<option value="<?= $value ?>"><?= $value ?></option>
																		<?php endforeach; ?>
																	</select>
																	<div class="input-group-btn">
																		<button class="btn btn-info" id="add_button" type="button">
																			<i class="md md-add"></i>
																		</button>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="col-sm-12 m-t-10">
													<div class="form-group">
														<label for="answer_explain">Answer Explain</label><small class="req"> *</small> <a target="_blank" class="btn btn-success btn-xs" href="https://en.wikipedia.org/wiki/List_of_mathematical_symbols">Mathematics Symbol</a>
														<textarea name="answer_explain" id="answer_explain" class="form-control"></textarea>
													</div>
												</div>
												<div class="col-sm-12">
													<div class="form-group m-t-22 pull-right m-l-15 ">
														<button name="add_user" type="submit" class="btn btn-primary"><i class="md md-add m-r-5"></i>Add</button>
													</div>
												</div>
											</div>
										</form>
									</div> <!-- panel-body -->
								</div>
							</div> <!-- panel -->
						</div>
					</div> <!-- col -->
				</div> <!-- End row -->
			<?php endif; ?>
		<?php endif; ?>
		<?php if (hasPermission("question", EDIT)) : ?>
			<?php if (isset($edit)) : ?>
				<div class="row">
					<div class="col-sm-12">
						<div class="panel-group" id="accordion-test-2">
							<div class="panel panel-border panel-info">
								<div class="panel-heading">
									<h3 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion-test-2" href="#collapseOne-2" aria-expanded="false">
											Manage Question
										</a>
									</h3>
								</div>
								<div id="collapseOne-2" class="panel-collapse collapse in">
									<div class="panel-body">
										<!-- <form id="find"> -->
										<?php echo form_open_multipart("question/edit/" . $single->id); ?>
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label for="title">Title</label><small class="req"> *</small>
													<input type="text" value="<?= $single->title ?>" name="title" placeholder="Title" class="form-control" required id="title">
													<input type="hidden" value="<?= $single->id ?>" name="id">
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label for="picture">Picture</label>(<code>JPG,PNG MAX SIZE 500 KB</code>)
													<input type="file" id="picture" data-max-file-size="500K" data-default-file="<?= base_url() . $single->picture ?>" data-allowed-file-extensions="jpg png" name="picture" class="form-control">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label for="option_a">Option A</label><small class="req"> *</small>
													<input type="text" value="<?= $single->option_1 ?>" name="option_a" placeholder="Option A" class="form-control" required id="option_a">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label for="option_b">Option B</label><small class="req"> *</small>
													<input type="text" value="<?= $single->option_2 ?>" name="option_b" placeholder="Option B" class="form-control" required id="option_b">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label for="option_c">Option C</label>
													<input type="text" value="<?= $single->option_3 ?>" name="option_c" placeholder="Option C" class="form-control" id="option_c">
												</div>
											</div>
											<!-- <div class="col-sm-3">
												<div class="form-group">
													<label for="option_d">Option D</label>
													<input type="text" value="<?= $single->option_4 ?>" name="option_d" placeholder="Option D" class="form-control" id="option_d">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label for="option_e">Option E</label>
													<input type="text" value="<?= $single->option_5 ?>" name="option_e" placeholder="Option E" class="form-control" id="option_e">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label for="option_f">Option F</label>
													<input type="text" value="<?= $single->option_6 ?>" name="option_f" placeholder="Option F" class="form-control" id="option_f">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label for="option_g">Option G</label>
													<input type="text" value="<?= $single->option_7 ?>" name="option_g" placeholder="Option G" class="form-control" id="option_g">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label for="option_h">Option H</label>
													<input type="text" value="<?= $single->option_8 ?>" name="option_h" placeholder="Option H" class="form-control" id="option_h">
												</div>
											</div> -->
											<div class="col-sm-3">
												<div class="form-group">
													<label for="answer">Answer</label><small class="req"> *</small>
													<select id="answer" required name="answer" class="form-control selectpicker">
														<option value="">--Select--</option>
														<option <?php if ($single->answer == 1) echo "selected" ?> value="1">Option A</option>
														<option <?php if ($single->answer == 2) echo "selected" ?> value="2">Option B</option>
														<option <?php if ($single->answer == 3) echo "selected" ?> value="3">Option C</option>
														<option <?php if ($single->answer == 4) echo "selected" ?> value="4">Option D</option>
														<!-- <option <?php if ($single->answer == 5) echo "selected" ?> value="5">Option E</option>
														<option <?php if ($single->answer == 6) echo "selected" ?> value="6">Option F</option>
														<option <?php if ($single->answer == 7) echo "selected" ?> value="7">Option G</option>
														<option <?php if ($single->answer == 8) echo "selected" ?> value="8">Option H</option>
														<option <?php if ($single->answer == 9) echo "selected" ?> value="9">All Correct</option> -->
													</select>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label for="difficulty">Level</label><small class="req"> *</small>
													<select id="difficulty" required name="difficulty" class="form-control selectpicker">
														<option value="">--Select--</option>
														<option <?php if ($single->difficulty == 1) echo "selected" ?> value="1">Basic</option>
														<option <?php if ($single->difficulty == 2) echo "selected" ?> value="2">Intermediate</option>
														<option <?php if ($single->difficulty == 3) echo "selected" ?> value="3">Advanced</option>
													</select>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label for="name">Position</label><small class="req"> *</small>
													<input type="number" name="position" placeholder="Position" value="<?= $single->position ?>" class="form-control" required id="position">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label for="is_math">Is Math?</label><small class="req"> *</small>
													<select id="is_math" required name="is_math" class="form-control selectpicker">
														<option value="">--Select--</option>
														<option <?php if ($single->is_math == 1) echo "selected" ?> value="1">Yes</option>
														<option <?php if ($single->is_math == 0) echo "selected" ?> value="0">No</option>
													</select>
												</div>
											</div>
											<div class="col-sm-12">
												<?php $i = 1; ?>
												<?php if (count($topic_id) > 0) : ?>
													<div id="category_part">
														<?php foreach ($topic_id as $key => $s_value) : ?>
															<div class="category_append" id="<?= $i ?>">
																<div class="category_append_2">
																	<div class="col-sm-3">
																		<div class="form-group">
																			<label for="subject_id">Subject</label>
																			<select id="subject_id" name="subject_id" class="form-control selectpicker" data-cotainer="body" data-live-search="true">
																				<option value="">--Select--</option>
																				<?php if (count($subject) > 0) : ?>
																					<?php foreach ($subject as $value) : ?>
																						<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
																					<?php endforeach; ?>
																				<?php endif; ?>
																			</select>
																		</div>
																	</div>
																	<div class="col-sm-3">
																		<div class="form-group">
																			<label for="section_id">Section</label>
																			<select id="section_id" name="section_id" class="form-control selectpicker" data-cotainer="body" data-live-search="true">
																				<option value="">--Select--</option>
																			</select>
																		</div>
																	</div>
																	<div class="col-sm-3">
																		<div class="form-group">
																			<label for="topic_id">Topic</label><small class="req"> *</small>
																			<input type="hidden" name="topic_hidden_id[]" value="<?= $i ?>">
																			<div class="input-group">
																				<select id="topic_id" required name="topic_id_<?= $i ?>" class="form-control selectpicker" data-cotainer="body" data-live-search="true">
																					<option value="">--Select--</option>
																					<?php if (count($topic) > 0) : ?>
																						<?php foreach ($topic as $value) : ?>
																							<option <?= topic_option_selected($s_value["topic_id"], $value['id']) ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
																						<?php endforeach; ?>
																					<?php endif; ?>
																				</select>
																				<div class="input-group-btn">
																					<button class="btn btn-success" id="topic_reload" type="button">
																						<i class="md  md-autorenew"></i>
																					</button>
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col-sm-3">
																		<div class="form-group">
																			<label for="category_id">Category</label><small class="req"> *</small>
																			<div class="input-group">
																				<select id="category_id" name="category_id_<?= $i ?>[]" data-container="body" required multiple class="form-control selectpicker" data-live-search="true">
																					<?php if (count($s_value["category"]) > 0) : ?>
																						<?php foreach ($s_value["category"] as $value) : ?>
																							<option <?= category_option_selected($s_value["topic_id"], $value['category_id']) ?> value="<?php echo $value['category_id']; ?>"><?php echo $value['category_name']; ?></option>
																						<?php endforeach; ?>
																					<?php endif; ?>
																				</select>
																				<div class="input-group-btn">
																					<?php if ($i == 1) : ?>
																						<button class="btn btn-info" id="category_add_button" type="button">
																							<i class="md md-add"></i>
																						</button>
																					<?php else : ?>
																						<button class="btn btn-info btn-danger category_remove_button" id="" type="button">
																							<i class="fa fa-minus"></i>
																						</button>
																					<?php endif; ?>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														<?php $i++;
														endforeach; ?>
													</div>
												<?php endif; ?>
											</div>
											<div class="col-sm-12">
												<?php if (count($batch_year_list) > 0) : ?>
													<div id="bsc_part">
														<?php foreach ($batch_year_list as $key => $s_value) : ?>
															<div class="bsc_append">
																<div class="col-sm-6">
																	<div class="form-group">
																		<label for="question_batch">Batch</label>
																		<div class="input-group">
																			<select id="question_batch" name="question_batch[]" data-container="body" class="form-control selectpicker" data-live-search="true">
																				<option value="">--Select--</option>
																				<?php foreach ($batch as $value) : ?>
																					<option <?php if ($s_value['batch_id'] == $value['id']) echo "selected" ?> value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
																				<?php endforeach; ?>
																			</select>
																			<div class="input-group-btn">
																				<button class="btn btn-success" id="batch_reload" type="button">
																					<i class="md  md-autorenew"></i>
																				</button>
																			</div>
																		</div>
																	</div>
																</div>
																<div class="col-sm-6">
																	<div class="form-group">
																		<label for="question_year">Year</label>
																		<div class="input-group">
																			<select id="question_year" name="question_year[]" data-container="body" class="form-control selectpicker" data-live-search="true">
																				<option value="">--Select--</option>
																				<?php foreach ($year as $value) : ?>
																					<option <?php if ($s_value['question_year'] == $value) echo "selected" ?> value="<?= $value ?>"><?= $value ?></option>
																				<?php endforeach; ?>
																			</select>
																			<div class="input-group-btn">
																				<?php if ($key == 0) : ?>
																					<button class="btn btn-info" id="add_button" type="button">
																						<i class="md md-add"></i>
																					</button>
																				<?php else : ?>
																					<button class="btn btn-info btn-danger remove_button" id="" type="button">
																						<i class="fa fa-minus"></i>
																					</button>
																				<?php endif; ?>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														<?php endforeach; ?>
													</div>
												<?php else : ?>
													<div id="bsc_part">
														<div class="col-sm-6">
															<div class="form-group">
																<label for="question_batch">Batch</label>
																<div class="input-group">
																	<select id="question_batch" name="question_batch[]" data-container="body" class="form-control selectpicker" data-live-search="true">
																		<option value="">--Select--</option>
																		<?php foreach ($batch as $value) : ?>
																			<option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
																		<?php endforeach; ?>
																	</select>
																	<div class="input-group-btn">
																		<button class="btn btn-success" id="batch_reload" type="button">
																			<i class="md  md-autorenew"></i>
																		</button>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-sm-6">
															<div class="form-group">
																<label for="question_year">Year</label>
																<div class="input-group">
																	<select id="question_year" name="question_year[]" data-container="body" class="form-control selectpicker" data-live-search="true">
																		<option value="">--Select--</option>
																		<?php foreach ($year as $value) : ?>
																			<option value="<?= $value ?>"><?= $value ?></option>
																		<?php endforeach; ?>
																	</select>
																	<div class="input-group-btn">
																		<button class="btn btn-info" id="add_button" type="button">
																			<i class="md md-add"></i>
																		</button>
																	</div>
																</div>
															</div>
														</div>
													</div>
												<?php endif; ?>
											</div>
											<div class="col-sm-12">
												<div class="form-group">
													<label for="answer_explain">Answer Explain</label><small class="req"> *</small> <a target="_blank" class="btn btn-success btn-xs" href="https://en.wikipedia.org/wiki/List_of_mathematical_symbols">Mathematics Symbol</a>
													<textarea name="answer_explain" required id="answer_explain" class="form-control"><?= $single->answer_explain ?></textarea>
												</div>
											</div>
											<div class="col-sm-12">
												<div class="form-group m-t-22 pull-right m-l-15 ">
													<button name="" type="submit" class="btn btn-info"><i class="md md-add m-r-5"></i>Update</button>
												</div>
											</div>
										</div>
										</form>
									</div> <!-- panel-body -->
								</div>
							</div> <!-- panel -->
						</div> <!-- col -->
					</div> <!-- End row -->
				<?php endif; ?>
			<?php endif; ?>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-border panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">Topic Relation</h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<table id="topic_realtion" class="table table-striped table-bordered">
										<thead>
											<tr>
												<th class="text-center">Category Name</th>
												<th class="text-center">Subject Name</th>
												<th class="text-center">Section Name</th>
											</tr>
										</thead>
										<tbody>

										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div> <!-- End Row -->
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-border panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">Question View</h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label for="search_category_id">Category</label><small class="req">*</small>
										<select id="search_category_id" name="search_category_id" class="form-control selectpicker" data-live-search="true" data-container="body">
											<option value="">--Select--</option>
											<?php foreach ($category_list as $value) : ?>
												<option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="search_subject_id">Subject</label>
										<select id="search_subject_id" name="search_subject_id" class="form-control selectpicker" data-live-search="true" data-container="body">
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="search_section_id">Section</label>
										<select id="search_section_id" name="search_section_id" class="form-control selectpicker" data-live-search="true" data-container="body">
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<label for="search_topic_id">Topic</label>
									<div class="input-group">
										<select id="search_topic_id" name="search_topic_id" class="form-control selectpicker" data-live-search="true" data-container="body">
										</select>
										<div class="input-group-btn">
											<button class="btn btn-success" id="filter_search" type="button">
												<i class="md md-search"></i>
											</button>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-2 m-b-10">
									<div class="form-group">
										<label for="filter_by">Filter By</label>
										<select id="filter_by" name="filter_by" class="form-control selectpicker">
											<option value="">All</option>
											<option value="0">Pending</option>
											<option value="1">Approved</option>
										</select>
									</div>
								</div>
								<div class="col-md-2 m-b-10">
									<div class="form-group">
										<label for="created_by">Created By</label>
										<select id="created_by" name="created_by" class="form-control selectpicker">
											<option value="">All</option>
											<?php foreach ($users as $value) : ?>
												<option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="col-md-2 m-b-10">
									<div class="form-group">
										<label for="search_batch_id">Batch</label>
										<select id="search_batch_id" name="search_batch_id" class="form-control selectpicker" data-live-search="true" data-container="body">
											<option value="">--Select--</option>
											<?php foreach ($batch as $value) : ?>
												<option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="col-md-2 m-b-10">
									<div class="form-group">
										<label for="search_year">Year</label>
										<select id="search_year" name="search_year" class="form-control selectpicker" data-live-search="true" data-container="body">
											<option value="">--Select--</option>
											<?php foreach ($year as $value) : ?>
												<option value="<?= $value ?>"><?= $value ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="col-md-4 m-b-10 m-t-22">
									<div class="input-group">
										<input type="text" name="search_key" placeholder="Search Question Title" id="search_key" class="form-control">
										<div class="input-group-btn">
											<button class="btn btn-info" id="add_button" type="button">
												<i class="md md-search"></i>
											</button>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div style="overflow: hidden">
										<div id="question_loading">
											<div class="cv-spinner">
												<span class="spinner"></span>
											</div>
										</div>
										<table id="question" class="table table-striped table-bordered">
											<thead>
												<tr>
													<th class="text-center">Sl.</th>
													<th class="text-center">Question Title</th>
													<th class="text-center">Answer</th>
													<th class="text-center">Details
													<th class="text-center">Edit History</th>
													<th class="text-center">Action</th>
												</tr>
											</thead>
											<tbody>

											</tbody>
										</table>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div> <!-- End Row -->
				</div> <!-- container -->
	</div>
	<div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<!-- <form id="item_add"> -->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">Question View</h4>
				</div>
				<div class="modal-body">
					<div id="show_details">

					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div><!-- /.modal -->
	<div id="history-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<!-- <form id="item_add"> -->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">Question History View</h4>
				</div>
				<div class="modal-body">
					<div id="history_show_details">

					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div><!-- /.modal -->
	<script src="<?php echo VENDOR_URL; ?>datatables/jquery.dataTables.min.js"></script>
	<script src="<?php echo VENDOR_URL; ?>datatables/dataTables.bootstrap.min.js"></script>
	<script src="<?php echo VENDOR_URL; ?>notifications/notify.min.js"></script>
	<script src="<?php echo VENDOR_URL; ?>notifications/notify-metro.js"></script>
	<script src="<?php echo VENDOR_URL; ?>notifications/notifications.js"></script>
	<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
	<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>
	<!-- KaTeX -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.9.0/katex.min.css" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.9.0/katex.min.js"></script>
	<script src="<?php echo VENDOR_URL; ?>summernote/summernote-math.js"></script>

	<script>
		$(document).ready(function() {

			<?php if (isset($add)) : ?>
				last_order_position();
			<?php endif; ?>

			function last_order_position() {
				$.get("<?php echo base_url() ?>ajax/get_last_order_position?table_name=question", function(data, status) {
					$("#position").val(data);
				});
			}
			summernote();

			function summernote() {
				$('#answer_explain').summernote({
					height: 200,
					toolbar: [
						// [groupName, [list of button]]
						['style', ['bold', 'italic', 'underline', 'clear']],
						['font', ['strikethrough', 'superscript', 'subscript']],
						['fontsize', ['fontsize']],
						['color', ['color']],
						['para', ['ul', 'ol', 'paragraph']],
						['height', ['height']],
						['insert', ['math', 'picture', 'video', 'table']],
					]
				});
			}
			$("#question_add").on("submit", function(e) {
				e.preventDefault();
				if ($("#answer_explain").summernote("isEmpty")) {
					$.Notification.autoHideNotify('error', 'top right', "Answer Explain Required");
					return false;
				}
				var url = "<?php echo base_url() ?>question/add";
				$.ajax({
					url: url,
					type: "post",
					data: new FormData(this),
					dataType: 'json',
					contentType: false,
					cache: false,
					processData: false,
					beforeSend: function() {
						$("#overlay").fadeIn(300);
					},
					success: function(data) {
						if (data.msg == "success") {
							$.Notification.autoHideNotify('success', 'top right', data.success);
							$("input[type=text]").val('');
							last_order_position();
							$("textarea").summernote('reset');
							$("textarea").summernote('destroy');
							$('.dropify-clear').click();
							// $(".bsc_append").remove();
							// $(".category_append_2").remove();
							summernote();
						} else {
							$.Notification.autoHideNotify('error', 'top right', data.msg);
						}
						get_view(false, 0);
						$("#overlay").fadeOut(300);
					},
					error: function() {
						$.Notification.autoHideNotify('error', 'top right', "Something Wrong. Please try again");
						$("#overlay").fadeOut(300);
					}
				});
			});
			$("#question_batch,#question_year").on("change", function() {
				validationBcs();
			});

			function validationBcs() {
				var question_batch = $("#question_batch").val();
				var question_year = $("#question_year").val();
				if (question_batch == '' && question_year == '') {
					$("#question_batch").attr("required", false);
					$("#question_year").attr("required", false);
				} else if (question_batch == '' || question_year == '') {
					$("#question_batch").attr("required", true);
					$("#question_year").attr("required", true);
				}
			}

			function topic_append(topic_id, category_id, id) {
				var section_id = $("#" + id + " #section_id").val();
				$.ajax({
					url: "<?php echo base_url() ?>ajax/get_topic_by_section",
					type: "get",
					dataType: "json",
					data: {
						"section_id": section_id
					},
					success: function(data) {
						topic_id.find('option').remove();
						category_id.find('option').remove();
						topic_id.append('<option value="">--Select--</option>');
						$.each(data, function(key, value) {
							topic_id.append('<option value="' + value.id + '">' + value.name + '</option>');
						});
						$(".selectpicker").selectpicker('render').selectpicker('refresh');
					}
				});
			}

			///subject id change
			$("#category_part").on("change", "#subject_id", function() {
				var id = $(this).closest(".category_append").attr("id");
				var subject_id = $(this).val();
				$.ajax({
					url: "<?php echo base_url() ?>ajax/get_section_by_subject",
					type: "get",
					dataType: "json",
					data: {
						"subject_id": subject_id
					},
					success: function(data) {
						var section_id = $("#" + id + " #section_id");
						$(section_id).find('option').remove();
						$(section_id).append('<option value="">--Select--</option>');
						$.each(data, function(key, value) {
							$(section_id).append('<option value="' + value.id + '">' + value.name + '</option>');
						});
						$(".selectpicker").selectpicker('render').selectpicker('refresh');
					}
				});
			});
			$("#category_part").on("change", "#section_id", function() {
				var id = $(this).closest(".category_append").attr("id");
				var topic_id = $("#" + id + " #topic_id");
				var category_id = $("#" + id + " #category_id");
				topic_append(topic_id, category_id, id);
			});

			//reload option
			$("#category_part").on("click", '#topic_reload', function() {
				var id = $(this).closest(".category_append").attr("id");
				var topic_id = $("#" + id + " #topic_id");
				var category_id = $("#" + id + " #category_id");
				topic_append(topic_id, category_id, id);
			});
			$("#bsc_part").on("click", '#batch_reload', function() {
				var batch_id = $(this).closest('.input-group').find("#question_batch");
				batch_append(batch_id);
			});

			function batch_append(batch_id) {
				$.ajax({
					url: "<?php echo base_url() ?>ajax/get_all_batch",
					type: "get",
					dataType: "json",
					data: {
						"batch": "s"
					},
					success: function(data) {
						batch_id.find('option').remove();
						batch_id.append('<option value="">--Select--</option>');
						$.each(data, function(key, value) {
							batch_id.append('<option value="' + value.id + '">' + value.name + '</option>');
						});
						$(".selectpicker").selectpicker('render').selectpicker('refresh');
					}
				});
			}

			$("#category_part").on("change", '#topic_id', function() {
				var id = $(this).closest(".category_append").attr("id");
				var topic_id = $(this).val();
				$.ajax({
					url: "<?php echo base_url() ?>question/topic_relation",
					type: "get",
					dataType: "json",
					data: {
						"topic_id": topic_id
					},
					success: function(data) {
						$("#topic_realtion tbody").html(data.html_data);
						var category_id = $("#" + id + " #category_id");
						$(category_id).find('option').remove();
						$(category_id).selectpicker("refresh");
						if (data.category_data != '') {
							$.each(data.category_data, function(key, value) {
								$(category_id).append('<option value="' + value.id + '">' + value.name + '</option>');
							});
							$(category_id).selectpicker('render').selectpicker('refresh');
						}
					}
				});

			});
			$("#search_key").on("change", function() {
				get_view(false);
				return false;
			});
			$("#filter_by").on("change", function() {
				get_view(false);
				return false;
			});
			$("#created_by").on("change", function() {
				get_view(false);
				return false;
			});
			$("#question").on("click", '.pagination li a', function() {
				var page_url = $(this).attr("href");
				if (page_url == "javascript:void(0)") {
					return false;
				}
				get_view(page_url);
				return false;
			});
			get_view(false, 0);

			function get_view(page_url, sorting = 1) {
				var category_id = $("#search_category_id").val();
				var subject_id = $("#search_subject_id").val();
				var section_id = $("#search_section_id").val();
				var topic_id = $("#search_topic_id").val();
				var batch_id = $("#search_batch_id").val();
				var year = $("#search_year").val();
				var filter_by = $("#filter_by").val();
				var search_key = $("#search_key").val();
				var created_by = $("#created_by").val();
				var base_url = "<?php echo base_url() ?>question/view";
				if (page_url) {
					base_url = page_url;
				}
				$.ajax({
					url: base_url,
					type: "post",
					dataType: "json",
					data: {
						"search_key": search_key,
						"created_by": created_by,
						"filter_by": filter_by,
						"category_id": category_id,
						"subject_id": subject_id,
						"section_id": section_id,
						"topic_id": topic_id,
						"batch_id": batch_id,
						"year": year,
						"sorting": sorting,
					},
					beforeSend: function() {
						$("#question_loading").fadeIn(300);
					},
					success: function(data) {
						$("#question tbody").html(data);
						updateMath();
						$("#question_loading").fadeOut(300);
					},
					error: function(e) {
						$.Notification.autoHideNotify('error', 'top right', "Something Wrong. Please try again");
						$("#question_loading").fadeOut(300);
					}
				});
			}


			$("#question").on("click", "#details_modal", function() {
				var question_id = $(this).data("id");
				$.ajax({
					url: "<?php echo base_url() ?>question/details_view",
					type: "get",
					dataType: "json",
					data: {
						"question_id": question_id
					},
					beforeSend: function() {
						$("#overlay").fadeIn(300);
					},
					success: function(data) {
						$("#show_details").html(data);
						updateMath();
						$("#overlay").fadeOut(300);
					},
					error: function(e) {
						$.Notification.autoHideNotify('error', 'top right', "Something Wrong. Please try again");
						$("#overlay").fadeOut(300);
					}
				});
			});
			$("#question").on("click", "#history_details_modal", function() {
				var question_id = $(this).data("id");
				$.ajax({
					url: "<?php echo base_url() ?>question/history_details_view",
					type: "get",
					dataType: "json",
					data: {
						"question_id": question_id
					},
					beforeSend: function() {
						$("#overlay").fadeIn(300);
					},
					success: function(data) {
						$("#history_show_details").html(data);
						$("#overlay").fadeOut(300);
					},
					error: function(e) {
						$.Notification.autoHideNotify('error', 'top right', "Something Wrong. Please try again");
						$("#overlay").fadeOut(300);
					}
				});
			});

			//    search area
			$("#search_category_id").on("change", function() {
				var category_id = $(this).val();
				$.ajax({
					url: "<?php echo base_url() ?>ajax/get_subject_by_category",
					type: "get",
					dataType: "json",
					data: {
						"category_id": category_id
					},
					success: function(data) {
						$("#search_subject_id").find('option').remove();
						$("#search_section_id").find('option').remove();
						$("#search_topic_id").find('option').remove();
						$("#search_subject_id").append('<option value="">--Select--</option>');
						$.each(data, function(key, value) {
							$("#search_subject_id").append('<option value="' + value.id + '">' + value.name + '</option>');
						});
						$(".selectpicker").selectpicker('render').selectpicker('refresh');
					}
				});
				get_view(false);
			});
			$("#search_subject_id").on("change", function() {
				var subject_id = $(this).val();
				$.ajax({
					url: "<?php echo base_url() ?>ajax/get_section_by_subject",
					type: "get",
					dataType: "json",
					data: {
						"subject_id": subject_id
					},
					success: function(data) {
						$("#search_section_id").find('option').remove();
						$("#search_topic_id").find('option').remove();
						$("#search_section_id").append('<option value="">--Select--</option>');
						$.each(data, function(key, value) {
							$("#search_section_id").append('<option value="' + value.id + '">' + value.name + '</option>');
						});
						$(".selectpicker").selectpicker('render').selectpicker('refresh');
					}
				});
				get_view(false);
			});
			$("#search_section_id").on("change", function() {
				var section_id = $(this).val();
				$.ajax({
					url: "<?php echo base_url() ?>ajax/get_topic_by_section",
					type: "get",
					dataType: "json",
					data: {
						"section_id": section_id
					},
					success: function(data) {
						$("#search_topic_id").find('option').remove();
						$("#search_topic_id").append('<option value="">--Select--</option>');
						$.each(data, function(key, value) {
							$("#search_topic_id").append('<option value="' + value.id + '">' + value.name + '</option>');
						});
						$(".selectpicker").selectpicker('render').selectpicker('refresh');
					}
				});
				get_view(false);
			});
			$("#search_topic_id,#search_batch_id,#search_year").on("change", function() {
				get_view(false);
			});
		});
	</script>
	<script>
		$(document).ready(function() {
			var maxField = 10; //Input fields increment limitation
			var addButton = $('#add_button'); //Add button selector
			var wrapper = $('#bsc_part'); //Input field wrapper
			var row = "";
			row += '<div class="bsc_append">';
			row += '<div class="col-sm-6">';
			row += '<div class="form-group">';
			row += '<label for="question_batch">Batch</label><small class="req"> *</small>';
			row += '<div class="input-group">';
			row += '<select name="question_batch[]" id="question_batch" required class="form-control selectpicker" data-live-search="true" data-container=body>';
			row += '<option value="">--Select--</option>';
			<?php if (isset($batch)) : ?>
				<?php foreach ($batch as $value) : ?>
					row += '<option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>';
				<?php endforeach; ?>
			<?php endif; ?>
			row += '</select>';
			row += '<div class="input-group-btn">';
			row += '<button class="btn btn-success" id="batch_reload" type="button">';
			row += '<i class="md  md-autorenew"></i>';
			row += '</button>';
			row += '</div>';
			row += '</div>';
			row += '</div>';
			row += '</div>';
			row += '<div class="col-sm-6">';
			row += '<div class="form-group">';
			row += '<label for="question_year">Year</label><small class="req"> *</small>';
			row += '<div class="input-group">';
			row += '<select name="question_year[]" id="question_year" required class="form-control selectpicker">';
			row += '<option value="">--Select--</option>';
			<?php if (isset($year)) : ?>
				<?php foreach ($year as $value) : ?>
					row += '<option value="<?= $value ?>"><?= $value ?></option>';
				<?php endforeach; ?>
			<?php endif; ?>
			row += '</select>';
			row += '<div class="input-group-btn">';
			row += '<button class="btn btn-danger remove_button" id="" type="button">';
			row += '<i class="fa fa-minus"></i>';
			row += '</button>';
			row += '</div>';
			row += '</div>';
			row += '</div>';
			row += '</div>';
			row += '</div>';
			<?php if (isset($edit)) : ?>
				var x = <?= count($batch_year_list)  ?>; //Initial field counter is 1
			<?php else : ?>
				var x = 1; //Initial field counter is 1
			<?php endif; ?>

			//Once add button is clicked
			$(addButton).click(function() {
				//Check maximum number of input fields
				if (x < maxField) {
					x++; //Increment field counter
					$(wrapper).append(row); //Add field html
				}

				$(".selectpicker").selectpicker('render').selectpicker('refresh');
			});

			//Once remove button is clicked
			$(wrapper).on('click', '.remove_button', function(e) {
				e.preventDefault();
				$(this).closest('.bsc_append').remove(); //Remove field html
				$(".selectpicker").selectpicker('render').selectpicker('refresh');
				x--; //Decrement field counter
			});
		});
	</script>
	<!--category topic part-->
	<script>
		$(document).ready(function() {
			<?php if (isset($edit)) : ?>
				var y = "<?= count($topic_id) + 1 ?>";
			<?php else : ?>
				var y = 2;
			<?php endif; ?>
			var x = 0;
			var maxField = 10; //Input fields increment limitation
			var addButton = $('#category_add_button'); //Add button selector
			var wrapper = $('#category_part'); //Input field wrapper
			<?php if (isset($edit)) : ?>
				x = <?= count($topic_id)  ?>; //Initial field counter is 1
			<?php else : ?>
				x = 1; //Initial field counter is 1
			<?php endif; ?>

			//Once add button is clicked
			$(addButton).click(function() {
				//Check maximum number of input fields
				if (x < maxField) {
					var section_id = $("#section_id").val();
					var topic_data = '';
					$.ajax({
						url: "<?php echo base_url() ?>ajax/get_topic_by_section",
						type: "get",
						dataType: "json",
						data: {
							"section_id": section_id
						},
						success: function(data) {
							x++; //Increment field counter
							$(wrapper).append(append_data(y++, data)); //Add field html
							$(".selectpicker").selectpicker('render').selectpicker('refresh');
						}
					});
				}
			});

			function append_data(x, data) {
				var row = "";
				row += '<div class="category_append" id="' + x + '">';
				row += '<div class="category_append_2"">';

				row += '<div class="col-sm-3">';
				row += '<div class="form-group">';
				row += '<label for="subject_id">Subject</label>';
				row += '<select id="subject_id"  name="subject_id" class="form-control selectpicker"  data-cotainer="body" data-live-search="true">';
				row += '<option value="">--Select--</option>';
				<?php if (count($subject) > 0) : ?>
					<?php foreach ($subject as $value) : ?>
						row += '<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>';
					<?php endforeach; ?>
				<?php endif; ?>
				row += '</select>';
				row += '</div>';
				row += '</div>';

				row += '<div class="col-sm-3">';
				row += '<div class="form-group">';
				row += '<label for="section_id">Section</label>';
				row += '<select id="section_id"  name="section_id" class="form-control selectpicker"  data-cotainer="body" data-live-search="true">';
				row += '<option value="">--Select--</option>';
				row += '</select>';
				row += '</div>';
				row += '</div>';

				row += '<div class="col-sm-3">';
				row += '<div class="form-group">';
				row += '<label for="topic_id">Topic</label><small class="req"> *</small>';
				row += '<input type="hidden" name="topic_hidden_id[]" id="topic_hidden" value="' + x + '">';
				row += '<div class="input-group">';
				row += '<select name="topic_id_' + x + '" id="topic_id"  required class="form-control selectpicker topic_id" data-live-search="true" data-container="body">';
				row += '<option value="">--Select--</option>';
				if (data != '') {
					$.each(data, function(key, value) {
						row += '<option value="' + value.id + '">' + value.name + '</option>'
					});
				}
				row += '</select>';
				row += '<div class="input-group-btn">';
				row += '<button class="btn btn-success" id="topic_reload" type="button">';
				row += '<i class="md  md-autorenew"></i>';
				row += '</button>';
				row += '</div>';
				row += '</div>';
				row += '</div>';
				row += '</div>';

				row += '<div class="col-sm-3">';
				row += '<div class="form-group">';
				row += '<label for="category_id">Category</label><small class="req"> *</small>';
				row += '<div class="input-group">';
				row += '<select name="category_id_' + x + '[]" id="category_id" required multiple class="form-control selectpicker">';
				row += '</select>';
				row += '<div class="input-group-btn">';
				row += '<button class="btn btn-danger category_remove_button" id="" type="button">';
				row += '<i class="fa fa-minus"></i>';
				row += '</button>';
				row += '</div>';
				row += '</div>';
				row += '</div>';
				row += '</div>';
				row += '</div>';
				row += '</div>';
				return row;
			}
			//Once remove button is clicked
			$(wrapper).on('click', '.category_remove_button', function(e) {
				e.preventDefault();
				$(this).closest('.category_append').remove(); //Remove field html
				$(".selectpicker").selectpicker('render').selectpicker('refresh');
				x--; //Decrement field counter
			});
		});
	</script>
