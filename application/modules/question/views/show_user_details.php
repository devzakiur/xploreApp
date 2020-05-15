 <div class="row">
 	<div class="col-sm-12">
 		<?php if ($picture != '') : ?>
 			<div class="col-sm-12">
 				<img src="<?= base_url() . $picture ?>" alt="" style="width:100px; height: auto">
 			</div>
 		<?php endif; ?>
 		<table class="table table-bordered table-striped question_details">
 			<tr>
 				<td><strong>Name:</strong></td>
 				<td> <?= $name ?></td>
 			</tr>
 			<tr>
 				<td><strong>Display Name:</strong></td>
 				<td> <?= $display_name ?></td>
 			</tr>
 			<tr>
 				<td><strong>Email:</strong></td>
 				<td><?= $email ?></td>
 			</tr>
 			<tr>
 				<td><strong>Phone:</strong></td>
 				<td><?= $phone ?></td>
 			</tr>
 			<tr>
 				<td><strong>Birthday:</strong></td>
 				<td><?= $dob ?></td>
 			</tr>
 			<tr>
 				<td><strong>Gender:</strong></td>
 				<td><?= $gender == 0 ? "Male" : "Female" ?></td>
 			</tr>
 		</table>
 	</div>
 </div>
