<?php if (isset($all_reports)) : ?>
	<?php foreach ($all_reports as $key => $value) : ?>
		<tr>
			<td><?= ++$serial ?></td>
			<td><?= $value['title'] ?></td>
			<td><?= date("d-m-Y", strtotime($value['date'])) ?></td>
			<td><?= date("h:i A", strtotime($value['date'])) ?></td>
			<td><?= $value['duration'] ?></td>
			<td><?= $value['total_question'] ?></td>
			<td><?= $value['total_participate'] ?></td>
			<td class="text-center">
				<a title="Details" target="_blank" href="<?php echo site_url("reports/gameresult/?model_test_id=" . $value['id']); ?>" class=" btn btn-success btn-sm  waves-effect tooltips" data-placement="top" data-toggle="tooltip" data-original-title="View"><i class="fa  fa-bar-chart-o"></i></a>
			</td>
		</tr>
	<?php endforeach ?>
	<td colspan="8" class="text-center">
		<?php echo $this->pagination->create_links(); ?>
	</td>
<?php endif ?>
