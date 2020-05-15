<div class="row">
	<div class="col-sm-12">
		<p><strong>Category:</strong></p>
		<?= $category_name ?>
	</div>
	<div class="col-sm-12 m-t-10">
		<p><strong>Topic:</strong></p>
		<?= $topic_name ?>
	</div>
	<div class="col-sm-12 m-t-10">
		<p><strong>Title:</strong></p>
		<?= $title ?>
	</div>
	<?php if ($cover_image != '') : ?>
		<div class="col-sm-12">
			<p class="m-t-10"><strong>Cover Image:</strong></p>
			<img src="<?= base_url() . $cover_image ?>" alt="" class="img-thumbnail">
		</div>
	<?php endif; ?>
	<div class="col-sm-12">
		<div class="modal_question_details m-t-10" style="text-align: justify">
			<p><strong>Details:</strong></p>
			<?= html_entity_decode($details) ?>
		</div>
	</div>
	<div class="col-sm-12">
		<div class="modal_question_details m-t-10" style="text-align: justify">
			<p><strong>Gist:</strong></p>
			<?= html_entity_decode($gist) ?>
		</div>
	</div>
	<div class="col-sm-12">
		<div class="modal_question_details m-t-10" style="text-align: justify">
			<p><strong>Library Externl link:</strong></p>
			<?= html_entity_decode($library_link) ?>
		</div>
	</div>
	<?php if (!empty($video_slide)) : ?>
		<div class="col-sm-12">
			<p class="m-t-10"><strong>Slide Video:</strong></p>
			<div id="videoCarousel" class="carousel slide" data-ride="carousel">
				<!-- Wrapper for slides -->
				<div class="carousel-inner">
					<?php foreach ($video_slide as $key => $value) : ?>
						<div class="item <?php echo $key == 0 ? "active" : "" ?>">
							<iframe width="560" height="315" src="<?= $value['video_url'] ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
							<div class="carousel-caption">
								<h3 class="text-white"><?= $value['video_title'] ?></h3>
							</div>
						</div>
					<?php endforeach; ?>
				</div>

				<!-- Left and right controls -->
				<a class="left carousel-control" href="#videoCarousel" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="right carousel-control" href="#videoCarousel" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
		</div>
	<?php endif; ?>
	<?php if (!empty($image_slide)) : ?>
		<div class="col-sm-12">
			<p class="m-t-10"><strong>Slide Image:</strong></p>
			<div id="imageCarousel" class="carousel slide" data-ride="carousel">

				<!-- Wrapper for slides -->
				<div class="carousel-inner">
					<?php foreach ($image_slide as $key => $value) : ?>
						<div class="item <?php echo $key == 0 ? "active" : "" ?>">
							<img src="<?= base_url() . $value['picture'] ?>" alt="" style="width:100%; height: 250px">
							<div class="carousel-caption">
								<h3 class="text-white"><?= $value['slide_picture_title'] ?></h3>
							</div>
						</div>
					<?php endforeach; ?>
				</div>

				<!-- Left and right controls -->
				<a class="left carousel-control" href="#imageCarousel" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="right carousel-control" href="#imageCarousel" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
		</div>
	<?php endif; ?>
</div>
