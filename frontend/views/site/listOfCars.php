<section class="grid-carousel">
	<header class="row">
		<div class="col-sm-6 text-left">
			<h3><?= $title ?></h3>
		</div>
		<div class="col-sm-6 text-right">
			<a href="#">See All cars</a>
		</div>
	</header>

	<div class="slick-carousel-<?= $columns ?>">

		<?php foreach ($listOfCars as $car): ?>
			<div class="single-item">
				<div class="img-wrap">
					<a href="<?=frontend\controllers\CarController::getCarViewUrl($car->id)?>" class="block">
						<img class="carved" src="<?=$imagesPath.$car->photo1?>" alt="<?=$car->description?>">
					</a>
				</div>
				<div class="clearfix">
					<h3 class="pull-left"><a href="<?=frontend\controllers\CarController::getCarViewUrl($car->id)?>"><?=$car->make->value?> <?=$car->model->value?></a></h3>
					<span class="price pull-right"><?=$car->price?> <small><?=$car->currency?></small></span>
				</div>
				<div>
					<?php if (!empty($carsRating[$car->id])):?>
						<span class="rating-stars">
							<span class="rated" style="width:<?= $carsRating[$car->id] * 20 ?>%"></span>
						</span>
						<span class="total-reviews">736 Reviews</span>
					<?php endif;?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>