<?php

/* @var $this yii\web\View */
use frontend\assets\HomePageAsset;
use frontend\widgets\QuickSearch;
use yii\base\Widget;
HomePageAsset::register($this);
$this->title = 'Uchaise';
?>
<main class="home-page content">
	<div class="container">

		<section class="block-welcome">
			<div class="row">
				<div class="col-md-5">
					<h1>
						You Chaise.<br>
						You Choose.
					</h1>
				</div>
				<div class="col-md-7">
					<p>
						Rent a car in Dubai – simple and affordable. 
						<br>
						Own the trip, not the car!
					</p>
				</div>
			</div>
		</section>

		<?php echo QuickSearch::widget();?>

		<?=$featuredCarsHTML?>

		<?=$recentlyListedHTML?>

		<section class="block-list-car text-center">
			<h2>Ready To Make Extra Money? Upload Your Car!</h2>
			<p>Do you want to make extra money? Upload your car now and make money instantly by renting it out. </p>
			<p><a class="btn btn-primary btn-lg" href="#" role="button">List Your Car Now</a></p>
		</section>

		<?=$featuredCarMakesHTML?>

		<section class="block-uchaise-numbers">
			<h2>Where We Currently Stand</h2>

			<div class="row">

				<div class="col-sm-6 col-md-3">
					<div class="box text-center">
						<strong><span class="count" data-count-up="86">0</span>k</strong>
						<span>experiences shared</span>
					</div>
				</div>
				<div class="col-sm-6 col-md-3">
					<div class="box text-center">
						<strong><span class="count" data-count-up="156">0</span></strong>
						<span>cities available</span>
					</div>
				</div>
				<div class="col-sm-6 col-md-3">
					<div class="box text-center">
						<strong>$<span class="count" data-count-up="25">0</span></strong>
						<span>average price</span>
					</div>
				</div>
				<div class="col-sm-6 col-md-3">
					<div class="box text-center">
						<strong><span class="count" data-count-up="975">0</span></strong>
						<span>5 star ratings</span>
					</div>
				</div>

			</div>
		</section>

		
	</div>
</main>
