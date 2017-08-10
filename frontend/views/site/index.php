<?php

/* @var $this yii\web\View */

$this->title = 'Carbnb';
?>
<div class="site-index">

	<div class="jumbotron">
		<h1>
			You Chaise.
			<br/>
			You Choose.
		</h1>

		<div class="lead">Browse our huge car market place to find the car you want to book, Find a car you fancy?</div>

		<form action="">
			<p>
				<input type="text" name="carLocation" class="input-lg" placeholder="Choose destination">
				<input type="text" name="bookDate"  class="input-lg" placeholder="Pick date">
				<button type="submit" class="btn btn-primary">Search</button>
			</p>
		</form>

	</div>

	<div class="body-content">

		<div class="row">
			<div class="">
				<h2>Featured Cars (<?=count($featuredCars)?>)</h2>
				<?php foreach ($featuredCars as $car):?>
					<div>
						<a><img alt="<?=$car->description?>" src="<?=$car->photo1?>"><?=$car->make->value?> <?=$car->model->value?> - <?=$car->price?> <?=$car->currency?></a>
						Rating <?php (!empty($carRatings[$car->id]) ? print $carRatings[$car->id] : print '')?>
					</div>
				<?php endforeach;?>

			</div>
				<div class="">
				<h2>Recently Listed (<?=count($recentlyListed)?>)</h2>
				<?php foreach ($recentlyListed as $car):?>
					<div>
						<a><img alt="<?=$car->description?>" src="<?=$car->photo1?>"><?=$car->make->value?> <?=$car->model->value?> - <?=$car->price?> <?=$car->currency?></a>
						<?php (!empty($carRatings[$car->id]) ? print 'Rating '.$carRatings[$car->id] : print '')?>
					</div>
				<?php endforeach;?>

			</div>
			<?php if (!empty($featuredCarMakes)):?>
				<div>
					<?php foreach ($featuredCarMakes as $makeName=>$cars):?>
						<h3><?=$makeName?></h3>
						<?php foreach ($cars as $car):?>
							<div>
								<a><img alt="<?=$car->description?>" src="<?=$car->photo1?>"><?=$car->make->value?> <?=$car->model->value?> - <?=$car->price?> <?=$car->currency?></a>
								<?php (!empty($carRatings[$car->id]) ? print 'Rating '.$carRatings[$car->id] : print '')?>
							</div>
						<?php endforeach;?>
					<?php endforeach;?>
				</div>
			<?php endif;?>
		</div>
	</div>
</div>
