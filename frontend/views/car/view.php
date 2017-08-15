<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Car */

$this->title = 'Car View';
?>
<h2>users and cars photos path (<b>$imagesPath</b>): <?=$imagesPath?></h2>
<h2>site images path (<b>$siteImagesPath</b>): <?=$siteImagesPath?></h2>
<pre><?=print_r($p,1)?></pre>

Variables:
<ul>
	<li>$carInfo</li>
	<li>$ownerInfo</li>
	<li>$carRatings</li>
	<li>$ratersInfo</li>
</ul>
Use <b>&lt;pre&gt;&lt;?=print_r($var,1)?&gt;&lt;/pre&gt;</b> in view file to print variables.

<!-- Slider -->
<div class="container wide">
	<div class="full-width-slider">
		<div id="carousel-full-width" class="carousel slide car-view-slider" data-ride="carousel">
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<li data-target="#carousel-full-width" data-slide-to="0" class="active"></li>
				<li data-target="#carousel-full-width" data-slide-to="1"></li>
				<li data-target="#carousel-full-width" data-slide-to="2"></li>
			</ol>

			<!-- Wrapper for slides -->
			<div class="carousel-inner" role="listbox">
				<div class="item active">
					<img class="img-responsive" src="http://via.placeholder.com/1500x400" alt="Toyota Camry" />
					<a href="#" class="view-photos"> View Photos </a>
				</div>
				<div class="item">
					<img class="img-responsive" src="http://via.placeholder.com/1500x400" alt="Toyota Camry" />
					<a href="#" class="view-photos"> View Photos </a>
				</div>
				<div class="item">
					<img class="img-responsive" src="http://via.placeholder.com/1500x400" alt="Toyota Camry" />
					<a href="#" class="view-photos"> View Photos </a>
				</div>
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
			<div class="car-view clearfix">
				<div class="pull-left">
					<h1>Audi R8 GT650 2017</h1>
					<h5>Coupe</h5>
					<span class="rating-stars"> <span class="rated" style="width:74%"></span> </span> <span class="total-reviews">736 Reviews</span>
				</div>
				<div class="pull-right right-side">
					<img class="img-circle" src="<?=$imagesPath?>user-photo-two.jpg" alt="user photo" />
					<h6>Owned by Lynne</h6>
					<span>(Responds in 2 days)</span>
				</div>
			</div>

			<!-- Car more info -->
			<div class="car-content">

				<section>
					<h3>Description</h3>
					<p>
						The new TT Quattro, an architectural rhapsody of circles and arches in which the promise of its
						artistic form is paid off in full, both outside and inside the car, is a three-door, two-plus-two
						sports coupe that is the ultimate gadget.Underpinning it is a new full, both outside and inside the car,
						is a three-door, two-plus-two sports coupe that is the ultimate gadget.Under� <a href="#">See all</a>
					</p>
				</section>

				<section>
					<h3>Features</h3>
					<ul class="list-inline list-options">
						<li>
							<i class="fa fa-bath" aria-hidden="true"></i>
							<h5>Automatic</h5>
						</li>
						<li>
							<i class="fa fa-bath" aria-hidden="true"></i>
							<h5>Automatic</h5>
						</li>
						<li>
							<i class="fa fa-bath" aria-hidden="true"></i>
							<h5>Automatic</h5>
						</li>
						<li>
							<i class="fa fa-bath" aria-hidden="true"></i>
							<h5>Automatic</h5>
						</li>
						<li>
							<i class="fa fa-bath" aria-hidden="true"></i>
							<h5>Automatic</h5>
						</li>
						<li>
							<i class="fa fa-bath" aria-hidden="true"></i>
							<h5>Automatic</h5>
						</li>
						<li>
							<i class="fa fa-bath" aria-hidden="true"></i>
							<h5>Automatic</h5>
						</li>
						<li>
							<i class="fa fa-bath" aria-hidden="true"></i>
							<h5>Automatic</h5>
						</li>
						<li>
							<i class="fa fa-bath" aria-hidden="true"></i>
							<h5>Automatic</h5>
						</li>
						<li>
							<i class="fa fa-bath" aria-hidden="true"></i>
							<h5>Automatic</h5>
						</li>
						<li>
							<i class="fa fa-bath" aria-hidden="true"></i>
							<h5>Automatic</h5>
						</li>
						<li>
							<i class="fa fa-bath" aria-hidden="true"></i>
							<h5>Automatic</h5>
						</li>
						<li>
							<i class="fa fa-bath" aria-hidden="true"></i>
							<h5>Automatic</h5>
						</li>
						<li>
							<i class="fa fa-bath" aria-hidden="true"></i>
							<h5>Automatic</h5>
						</li>
					</ul>
				</section>

				<section>
					<h3>Insurance Provided by</h3>
					<p>RSA insurance Company</p>
				</section>

				<section>
					<h3>Miles Included</h3>
					<p>Unlimited Miles</p>
				</section>

				<section>
					<h3>Car Terms</h3>
					<ul class="list-unstyled">
						<li>No Smoking</li>
						<li>No out of border drives</li>
					</ul>
				</section>

				<section>
					<h3>45 Reviews for Lynne</h3>
					<div class=""><span class="rating-stars"> <span class="rated" style="width:74%"></span> </span></div>

					<div class="user-comments">
						<ul class="list-unstyled">

							<li>
								<div class="clearfix user-comment">
									<div class="pull-left">
										<img class="img-circle user-img" src="<?=$imagesPath?>user-photo-two.jpg" alt="user photo" />
									</div>
									<div class="pull-left">
										<h6>Mike Andy</h6>
										<time>March 2017</time>
									</div>
								</div>
								<p>
									With snazzy styling and peppy performance, the TT and TTS appeal to both the practical and the passionate.
									The TT has a 220-hp d peppy performance, the TT and TTS appeal to both the practical and the passionate.
									The TT has a 220-hp
								</p>
							</li>

							<li>
								<div class="clearfix user-comment">
									<div class="pull-left">
										<img class="img-circle user-img" src="<?=$imagesPath?>user-photo-two.jpg" alt="user photo" />
									</div>
									<div class="pull-left">
										<h6>Mike Andy</h6>
										<time>March 2017</time>
									</div>
								</div>
								<p>
									With snazzy styling and peppy performance, the TT and TTS appeal to both the practical and the passionate.
									The TT has a 220-hp d peppy performance, the TT and TTS appeal to both the practical and the passionate.
									The TT has a 220-hp
								</p>
							</li>

							<li>
								<div class="clearfix user-comment">
									<div class="pull-left">
										<img class="img-circle user-img" src="<?=$imagesPath?>user-photo-two.jpg" alt="user photo" />
									</div>
									<div class="pull-left">
										<h6>Mike Andy</h6>
										<time>March 2017</time>
									</div>
								</div>
								<p>
									With snazzy styling and peppy performance, the TT and TTS appeal to both the practical and the passionate.
									The TT has a 220-hp d peppy performance, the TT and TTS appeal to both the practical and the passionate.
									The TT has a 220-hp
								</p>
							</li>

							<li>
								<div class="clearfix user-comment">
									<div class="pull-left">
										<img class="img-circle user-img" src="<?=$imagesPath?>user-photo-two.jpg" alt="user photo" />
									</div>
									<div class="pull-left">
										<h6>Mike Andy</h6>
										<time>March 2017</time>
									</div>
								</div>
								<p>
									With snazzy styling and peppy performance, the TT and TTS appeal to both the practical and the passionate.
									The TT has a 220-hp d peppy performance, the TT and TTS appeal to both the practical and the passionate.
									The TT has a 220-hp
								</p>
							</li>

						</ul>

						<?/* pagination mhadi*/?>

					</div>
				</section>
			</div>

			<div class="car-owner">
				<div class="clearfix car-owner-details">
					<div class="pull-left">
						<img class="img-circle user-img" src="<?=$imagesPath?>user-girl.jpg" alt="user photo" />
					</div>
					<div class="pull-left">
						<h2>Owned by Lynne</h2>
						<h6>United Arab Emirates</h6><span>(Responds in 2 days)</span>
					</div>
				</div>
				<h3>Description</h3>
				<p>
					I believe every human being needs two types of satisfaction: productive and creative.
					If you're lucky enough to have a purely creative job, like me, you spend most of your time tweaking
					and experimenting with concepts, putting words and ideas together. It's really rewarding stuff,
					but it's all a little abstract, too.
				</p>
				<a class="btn btn-primary" href="#">Say Hello</a>
			</div>

		</div>

		<aside class="col-md-4 price-box">
			<div class="price-and-reserve">
				<div class="price-details">
					<div class="price">
						<span>145 AED</span> Per day
					</div>
					<div class="total-price">TOTAL <span class="text-grey"> for 6 Days	</span> <span class="price-per-days"> 870 </span> <span class="text-grey"> AED </span></div>
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