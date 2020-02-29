 <div class="row">
	<div class="col-sm-12">
		<table class="table table-bordered table-striped question_details">
			<thead>
				<tr>
					<th>Sl.</th>
					<th>User Name</th>
					<th>Update Date &amp; Time</th>
				</tr>
			</thead>
			<tbody>
				<?php if(!empty($history)): ?>
					<?php foreach($history as $key=>$value): ?>
						<tr>
							<td><?= ++$key ?></td>
							<td><?= $value['user_name'] ?></td>
							<td><?= date("d-m-Y h:i:A",strtotime($value['created_at'])) ?></td>
						</tr>
					<?php endforeach; ?>
				<?php else: ?>
					<tr>
						<td class="text-center text-danger" colspan="3"><strong>No history found.</strong></td>
					</tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>
