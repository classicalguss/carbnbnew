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
						<img class="carved" width="350" height="220" src="<?=$imagesPath.$car->photo1?>" alt="<?=$car->description?>">
					</a>
				</div>
				<div class="clearfix">
					<h3 class="pull-left"><a href="<?=frontend\controllers\CarController::getCarViewUrl($car->id)?>"><?=substr($car->make->value.' '.$car->model->value, 0, 15).'...'?></a></h3>
					<span class="price pull-right"><?=$car->price?> <small><?=$car->currency?></small></span>
				</div>
				<div>
					<?php if (!empty($carsRating[$car->id])):?>
						<span class="rating-stars">
							<span class="rated" style="width:<?= ($carsRating[$car->id][0]/$carsRating[$car->id][1]) * 20 ?>%"></span>
						</span>
						<span class="total-reviews"><?=$carsRating[$car->id][1]?> Reviews</span>
					<?php endif;?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>