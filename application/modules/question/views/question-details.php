 <div class="row">
 	<div class="col-sm-12">
 		<table class="table table-bordered table-striped question_details">

 			<tr>
 				<td><strong>Category:</strong></td>
 				<td> <?= $category ?></td>
 			</tr>
 			<tr>
 				<td><strong>Subject:</strong></td>
 				<td><?= $subject ?></td>
 			</tr>
 			<tr>
 				<td><strong>Section:</strong></td>
 				<td><?= $section ?></td>
 			</tr>
 			<tr>
 				<td><strong>Topic:</strong></td>
 				<td><?= $topic ?></td>
 			</tr>
 			<tr>
 				<td><strong>Difficulty:</strong></td>
 				<td><?= $difficulty ?></td>
 			</tr>
 			<tr>
 				<td colspan="2">প্রশ্নঃ <?= $title ?><?php if ($batch_name != '' || $question_year != '') : ?>(<?= $batch_name ?>-<?= $question_year ?>)<?php endif; ?></td>
 			</tr>
 			<tr>
 				<td>ক. <?= $option_1 ?></td>
 				<td>খ. <?= $option_2 ?></td>
 			</tr>
 			<tr>
 				<td>গ. <?= $option_3 ?></td>
 				<td> ঘ. <?= $option_4 ?></td>
 			</tr>
 			<!-- <tr>
 				<td>ঙ. <?= $option_5 ?></td>
 				<td>চ. <?= $option_6 ?></td>
 			</tr>
 			<tr>
 				<td>ছ. <?= $option_7 ?></td>
 				<td> জ. <?= $option_8 ?></td>
 			</tr> -->
 			<tr>
 				<td colspan="2"></td>
 			</tr>
 			<tr>
 				<td>সঠিক উত্তরঃ </td>
 				<td><?= $answer ?></td>
 			</tr>
 		</table>
 	</div>
 	<div class="col-sm-12">
 		<div class="modal_question_details m-t-10" style="text-align: justify">
 			<p><strong>ব্যাখ্যাঃ</strong></p>
 			<?= html_entity_decode($answer_explain) ?>
 		</div>
 	</div>
 	<?php if ($picture != '') : ?>
 		<div class="col-sm-12">
 			<p class="m-t-10"><strong>Image:</strong></p>
 			<img src="<?= base_url() . $picture ?>" alt="" style="width:100%; height: 250px">
 		</div>
 	<?php endif; ?>
 </div>
