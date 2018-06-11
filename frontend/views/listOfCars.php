<?php 
use yii\helpers\Url;
?>
<section class="grid-carousel">
	<header class="row">
		<div class="col-xs-6 text-left">
			<h3><?= $title ?></h3>
		</div>
		<div class="col-xs-6 text-right">
			<?php if ($filter == 'featured'):?>
				<a href="<?=Url::to(['search/index', "CarSearch[is_featured]"=>true])?>">See All Cars</a>
			<?php else:?>
				<a href="<?=Url::to(['search/index'])?>">See All Cars</a>
			<?php endif;?>
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
