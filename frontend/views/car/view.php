<?php

use frontend\assets\CarViewAsset;
CarViewAsset::register($this);

/* @var $this yii\web\View */
/* @var $model frontend\models\Car */

$this->title = 'Car View';
$carRatingPercentage = (count($carRatings) > 0 ? 20*$ratingsSum/count($carRatings) : 0);

?>
<!-- Slider -->
<div class="container wide">
	<div class="full-width-slider">
		<div id="carousel-full-width" class="carousel slide car-details-slider" data-ride="carousel">
			<!-- Indicators -->
			<ol class="carousel-indicators">
			<?php $i=0; foreach ($carInfo['images'] as $imageName=>$imagePath):?>
				<li data-target="#carousel-full-width" data-slide-to="<?=$i?>" <?php if ($i==0):?>class="active"<?php endif;?>></li>
			<?php endforeach;?>
			</ol>

			<!-- Wrapper for slides -->
			<div class="carousel-inner" role="listbox">
				<?php $i=0; foreach ($carInfo['images'] as $imageName=>$imagePath):?>
					<div class="item active">
						<img class="img-responsive" src="<?=$imagePath?>" alt="<?=$carInfo['makeName']?> <?=$carInfo['modelName']?> <?=$carInfo['year_model']?>" />
						<a href="#" class="view-photos"> View Photos </a>
					</div>
				<?php endforeach;?>
			</div>
		</div>
	</div>
</div>
<!-- Slider -->

<!-- Car details -->
<div class="container">
	<div class="row">
		<div class="col-md-8">
			<!-- Car details -->
			<div class="car-details clearfix">
				<div class="pull-left">
					<h1><?=$carInfo['makeName']?> <?=$carInfo['modelName']?> <?=$carInfo['year_model']?></h1>
					<h5><?=$carInfo['properties']['type_id']?></h5>
					<span class="rating-stars"> <span class="rated" style="width:<?=$carRatingPercentage?>%"></span> </span> <span class="total-reviews"><?=count($carRatings)?> Reviews</span>
				</div>
				<div class="pull-right right-side">
					<img class="img-circle" width="70" height="70" src="<?=$imagesPath?><?=$ownerInfo['photo']?>" alt="<?=$ownerInfo['first_name']?>" />
					<h6>Owned by <?=$ownerInfo['first_name']?></h6>
					<span>(Responds in 2 days)</span>
				</div>
			</div>

			<!-- Car more info -->
			<div class="car-content">

				<section>
					<h3>Description</h3>
					<p>
						<?=$carInfo['description']?>... <a href="#">See all</a>
					</p>
				</section>

				<section>
					<h3>Features</h3>
					<ul class="list-inline list-options">
						<?php foreach ($carInfo['features'] as $featureId=>$featureTxt):?>
							<li>
								<i class="fa fa-bath car-feature-<?=$featureId?>" aria-hidden="true"></i>
								<h5><?=$featureTxt?></h5>
							</li>
						<?php endforeach;?>
					</ul>
				</section>

				<section>
					<h3>Insurance Provided by</h3>
					<p><?=$carInfo['insurance_tip']?></p>
				</section>

				<section>
					<h3>Miles Included</h3>
					<?php if (!empty($carInfo['milage_limitation'])):?>
						<p><?=$carInfo['milage_limitation']?> KM</p>
					<?php else :?>
						<p>Unlimited Miles</p>
					<?php endif;?>
				</section>

				<section>
					<h3>Car Terms</h3>
					<ul class="list-unstyled">
						<?php for ($c=1;$c<=4;$c++):?>
							<?php if (!empty($carInfo['rule_'.$c])):?>
								<li><?=$carInfo['rule_'.$c]?></li>
							<?php endif;?>
						<?php endfor;?>
					</ul>
				</section>

				<section>
					<h3><?=count($carRatings)?> Reviews for <?=$ownerInfo['first_name']?></h3>
					<div class=""><span class="rating-stars"> <span class="rated" style="width:<?=$carRatingPercentage?>%"></span> </span></div>

					<div class="user-comments">
						<ul class="list-unstyled">
							<?php foreach ($carRatings as $rate):?>
								<?php if (!empty($ratersInfo[$rate['user_id']])):?>
									<li>
										<div class="clearfix user-comment">
											<div class="pull-left">
												<img class="img-circle user-img" width="70" height="70" src="<?=$imagesPath?><?=$ratersInfo[$rate['user_id']]['photo']?>" alt="<?=$ratersInfo[$rate['user_id']]['first_name']?>" />
											</div>
											<div class="pull-left">
												<h6><?=$ratersInfo[$rate['user_id']]['first_name']?> <?=$ratersInfo[$rate['user_id']]['last_name']?></h6>
												<time><?=date("F Y", strtotime($rate['created_at']))?></time>
											</div>
										</div>
										<p>
											<?=$rate['description']?>
										</p>
									</li>
								<?php endif;?>
							<?php endforeach;?>
						</ul>

						<?/*pagination*/?>

					</div>
				</section>
			</div>

			<div class="car-owner">
				<div class="clearfix car-owner-details">
					<div class="pull-left">
						<img class="img-circle user-img" width="70" height="70" src="<?=$imagesPath?><?=$ownerInfo['photo']?>" alt="<?=$ownerInfo['first_name']?>" />
					</div>
					<div class="pull-left">
						<h2>Owned by <?=$ownerInfo['first_name']?></h2>
						<h6>United Arab Emirates</h6><span>(Responds in 2 days)</span>
					</div>
				</div>
				<?php if (!empty($ownerInfo['about_me'])):?>
					<h3>Description</h3>
					<p>
						<?=$ownerInfo['about_me']?>
					</p>
				<?php endif;?>
				<a class="btn btn-primary" href="#">Say Hello</a>
			</div>

		</div>

		<aside class="col-md-4 price-box">
			<div class="price-and-reserve">
				<div class="price-details">
					<div class="price">
						<span><?=$carInfo['price']?> <?=$carInfo['currency']?></span> Per day
					</div>
					<div class="total-price">TOTAL <span class="text-grey"> for 6 Days </span> <span class="price-per-days"> <?=$carInfo['price'] * 6?> </span> <span class="text-grey"> <?=$carInfo['currency']?> </span></div>
					<div class="pick-up-time">
						<h5 class="bold">Set your pick up time</h5>
						<select class="form-control">
							<option value="9:00 AM">9:00 AM</option>
							<option value="10:00 AM">10:00 AM</option>
							<option value="11:00 AM">11:00 AM</option>
						</select>
					</div>
				</div>
				<a class="btn btn-primary btn-block no-radius btn-lg" href="#">Reserve</a>
			</div>
			<a class="btn btn-blank btn-block btn-save" href="#"><i class="fa fa-star-o"></i> Save for later</a>
			<ul class="list-inline social-media-view">
				<li><a href="#"><i class="fa fa-facebook"></i></a></li>
				<li><a href="#"><i class="fa fa-twitter"></i></a></li>
				<li><a href="#"><i class="fa fa-instagram"></i></a></li>
			</ul>
		</aside>

	</div>

	<?=$recentlyListedHTML?>

</div>