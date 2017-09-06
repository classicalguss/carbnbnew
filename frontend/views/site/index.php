<?php

/* @var $this yii\web\View */
use frontend\assets\HomePageAsset;
use frontend\widgets\QuickSearch;
use yii\base\Widget;
HomePageAsset::register($this);
$this->title = 'Carbnb';
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
						Browse our huge car market place to find the car you want to book, Find a car you fancy?
					</p>
				</div>
			</div>
		</section>

		<?php echo QuickSearch::widget();?>

		<?=$featuredCarsHTML?>

		<?=$recentlyListedHTML?>

		<section class="block-list-car text-center">
			<h2>Ready to List Your Car?</h2>
			<p>Put your car to work with just a few clicks. upload your registration along with quality photos and your car is ready to go!</p>
			<p><a class="btn btn-primary btn-lg" href="#" role="button">List Your Car</a></p>
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

		<section class="block-share-uchaise">
			<h2>Share and Get Free Credit!</h2>

			<div class="row">
				<div class="col-md-6">
					<a href="#">
						<img class="carved" src="<?= $siteImagesPath ?>/share.jpg" alt="">
					</a>
				</div>
				<div class="col-md-6">
					<ul class="list-unstyled list-tips">
						<li class="row">
							<div class="col-sm-3 text-center">
								<img src="<?= $siteImagesPath?>/1.svg" alt="">
							</div>
							<div class="col-sm-9">
								<h3>Share with a friend</h3>
								<p>Browse our huge car market place to find the car you want to book, Find a car you</p>
							</div>
						</li>

						<li class="row">
							<div class="col-sm-3 text-center">
								<img src="<?= $siteImagesPath?>/2.svg" alt="">
							</div>
							<div class="col-sm-9">
								<h3>Share with a friend</h3>
								<p>Browse our huge car market place to find the car you want to book, Find a car you</p>
							</div>
						</li>

						<li class="row">
							<div class="col-sm-3 text-center">
								<img src="<?= $siteImagesPath?>/3.svg" alt="">
							</div>
							<div class="col-sm-9">
								<h3>Share with a friend</h3>
								<p>Browse our huge car market place to find the car you want to book, Find a car you</p>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</section>
	</div>
</main>