<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use frontend\assets\SearchPageAsset;
use frontend\assets\AppAsset;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cars';
$this->params ['breadcrumbs'] [] = $this->title;
SearchPageAsset::register ( $this );
AppAsset::register ( $this );
$this->title = 'Carbnb';
?>
<main class="search-page content">
<div class="container">

	<h1 class="page-title">We Found Cars at</h1>
	<div class="main-search-bar">
		<form class="" action="" method="get">
			<div class="clearfix row-small-gutter">
				<div class="col col-md-5">
					<div class="form-group border-right">
						<label for="search-where">Where</label> <input type="search"
							class="form-control" id="search-where" name="location"
							placeholder="Choose destination">
					</div>
				</div>
				<div class="col col-md-5">
					<div class="form-group">
						<label for="search-when">When</label> <input type="text"
							class="form-control" id="search-when" name="daterange"
							placeholder="Pick date">
					</div>
				</div>
				<div class="col col-md-2">
					<button type="submit" name="button"
						class="btn btn-search btn-primary btn-lg btn-block">Search</button>
				</div>
			</div>
		</form>
	</div>
	<div class="row">
		<aside class="col-md-3 border-right">
			<!-- Filters -->
			<div class="clearfix space-bottom">
				<div class="pull-left">
					<h4 class="bold">Filters</h4>
				</div>
				<div class="pull-right">
					<a class="text-gray" href="#">Clear All</a>
				</div>
			</div>

			<ul class="list-unstyled general-filters">
				<li class="row-small-gutter">
					<div class="col col-xs-9">
						<strong>Book Instantly</strong>
						<p class="text-gray font-small">Reserve the car without waiting
							for approval</p>
					</div>
					<div class="col col-xs-3">
						<div class="switch pull-right">
							<input id="filter-1" class="cmn-toggle cmn-toggle-round"
								type="checkbox" checked=""> <label for="filter-1"></label>
						</div>
					</div>
				</li>
				<li class="row-small-gutter">
					<div class="col col-xs-9">
						<strong>Book Instantly</strong>
						<p class="text-gray font-small">Reserve the car without waiting
							for approval</p>
					</div>
					<div class="col col-xs-3">
						<div class="switch pull-right">
							<input id="filter-2" class="cmn-toggle cmn-toggle-round"
								type="checkbox" checked=""> <label for="filter-2"></label>
						</div>
					</div>
				</li>

				<li><strong class="filter-title">Price Range</strong>
					<div class="rangeSliderWrap range-slider-wrap clearfix">
						<div id="priceRangeSlider" data-initial-start="0"
							data-initial-end="200" data-start="0" data-end="1000">
							<div class="slider">
								<div class="handle handle-left slider-transition"
									style="margin-left: -10px;">
									<div class="slider-circle"></div>
								</div>
								<div class="handle handle-right slider-transition"
									style="margin-right: -10px; right: 0%;">
									<div class="slider-circle"></div>
								</div>
								<div class="slider-fill slider-transition" style="right: 0%;"></div>
							</div>
						</div>
						<div class="range-slider-text clearfix">
							<input class="rangeMinValue" type="hidden" name="0" value="0"> <input
								class="rangeMaxValue" type="hidden" name="0" value="200"> <span
								class="price pull-left range-number"> <span class="rangeMinText">0</span>
								<small class="text-gray">AED</small>
							</span> <span class="price pull-right range-number"> <span
								class="rangeMaxText">200</span> <small class="text-gray">AED</small>
							</span>
						</div>
					</div></li>

				<li><strong class="filter-title">Mileage Range</strong>
					<div class="rangeSliderWrap range-slider-wrap clearfix">
						<div id="mileageRangeSlider" data-initial-start="0"
							data-initial-end="10000" data-start="2000" data-end="5000">
							<div class="slider">
								<div class="handle handle-left slider-transition"
									style="margin-left: -10px; left: 20%;">
									<div class="slider-circle"></div>
								</div>
								<div class="handle handle-right slider-transition"
									style="margin-right: -10px; right: 50%;">
									<div class="slider-circle"></div>
								</div>
								<div class="slider-fill slider-transition"
									style="left: 20%; right: 50%;"></div>
							</div>
						</div>
						<div class="range-slider-text clearfix">
							<input class="rangeMinValue" type="hidden" name="0" value="2000">
							<input class="rangeMaxValue" type="hidden" name="0" value="5000">
							<span class="mileage pull-left range-number"> <span
								class="rangeMinText">2000</span>
							</span> <span class="mileage pull-right range-number"> <span
								class="rangeMaxText">5000</span>
							</span>
						</div>
					</div></li>

				<li><strong class="filter-title">Transmission</strong>
					<ul class="list-inline">
						<li class="checkbox"><label> <input type="checkbox" checked="">
								Manual
						</label></li>
						<li class="checkbox"><label> <input type="checkbox"> Automatic
						</label></li>
					</ul></li>
			</ul>

			<div id="filtersAccordion" class="panel-group" role="tablist"
				aria-multiselectable="true">

				<div class="panel panel-filter">
					<div class="panel-heading" role="tab">
						<strong class="panel-title"> <a class="collapsed" role="button"
							data-toggle="collapse" data-parent="#filtersAccordion"
							href="#collapse-vehicle-type" aria-expanded="true"
							aria-controls="collapse-vehicle-type"> Vehicle Types </a>
						</strong>
					</div>
					<div id="collapse-vehicle-type" class="panel-collapse collapse"
						role="tabpanel">
						<div class="panel-body">
							<ul class="list-unstyled filter-list">
								<li class="checkbox"><label><input type="checkbox"
										class="filterAction"> Filter 1</label></li>
								<li class="checkbox"><label><input type="checkbox"
										class="filterAction"> Filter 2</label></li>
								<li class="checkbox"><label><input type="checkbox"
										class="filterAction"> Filter 3</label></li>
								<li class="checkbox"><label><input type="checkbox"
										class="filterAction"> Filter 4</label></li>
								<li class="checkbox"><label><input type="checkbox"
										class="filterAction"> Filter 5</label></li>
							</ul>
						</div>
					</div>
				</div>

				<div class="panel panel-filter">
					<div class="panel-heading" role="tab">
						<strong class="panel-title"> <a class="collapsed" role="button"
							data-toggle="collapse" data-parent="#filtersAccordion"
							href="#collapse-make" aria-expanded="true"
							aria-controls="collapse-make"> Make </a>
						</strong>
					</div>
					<div id="collapse-make" class="panel-collapse collapse"
						role="tabpanel">
						<div class="panel-body">
							<ul class="list-unstyled filter-list">
								<li class="checkbox"><label><input type="checkbox"
										class="filterAction"> Filter 1</label></li>
								<li class="checkbox"><label><input type="checkbox"
										class="filterAction"> Filter 2</label></li>
								<li class="checkbox"><label><input type="checkbox"
										class="filterAction"> Filter 3</label></li>
								<li class="checkbox"><label><input type="checkbox"
										class="filterAction"> Filter 4</label></li>
								<li class="checkbox"><label><input type="checkbox"
										class="filterAction"> Filter 5</label></li>
							</ul>
						</div>
					</div>
				</div>

			</div>
		</aside>
		<section class="col-md-9">

			<div class="search-header clearfix">
				<div class="pull-left">About 397,000,000 results</div>
				<div data-layout-switcher="" class="pull-right layout-switcher">
					<a href="javascript:;" class="active" data-layout="thumb"><i
						class="fa fa-th-large"></i></a> <a href="javascript:;"
						data-layout="list" class=""><i class="fa fa-th-list"></i></a>
				</div>
			</div>

			<div class="search-list view-grid" data-thumb-class="view-grid"
				data-list-class="view-list">
				<div class="row">

					<div data-thumb-class="col-md-6" data-list-class="col-md-12"
						class="col-md-6">
						<div class="single-item-lg">
							<div class="row">
								<div data-thumb-class="col-md-12" data-list-class="col-md-6"
									class="col-md-12">
									<div class="img-wrap">
										<a href="#" class="block"> <img class="carved img-responsive"
											src="../../web/images/temp/car1.jpg" alt="">
										</a>
									</div>
								</div>
								<div data-thumb-class="col-md-12" data-list-class="col-md-6"
									class="col-md-12">

									<div class="clearfix">
										<div class="title pull-left">
											<h3>
												<a href="#">Audi R8 GT650 2017</a>
											</h3>
											<span class="rating-stars"> <span class="rated"
												style="width: 72%"></span>
											</span> <span class="total-reviews">736 Reviews</span>
										</div>
										<div class="price pull-right">
											526 <small>AED</small>
										</div>
									</div>

									<p>The new TT Quattro, an architectural rhapsody of circles and
										arches in which the promise of i…</p>

									<ul class="list-inline list-features">
										<li><i class="fa fa-car"></i> <span>5 doors</span></li>
										<li><i class="fa fa-car"></i> <span>5 doors</span></li>
										<li><i class="fa fa-car"></i> <span>5 doors</span></li>
										<li><i class="fa fa-car"></i> <span>5 doors</span></li>
									</ul>

								</div>
							</div>
						</div>
					</div>
					<div data-thumb-class="col-md-6" data-list-class="col-md-12"
						class="col-md-6">
						<div class="single-item-lg">
							<div class="row">
								<div data-thumb-class="col-md-12" data-list-class="col-md-6"
									class="col-md-12">
									<div class="img-wrap">
										<a href="#" class="block"> <img class="carved img-responsive"
											src="../../web/images/temp/car2.jpg" alt="">
										</a>
									</div>
								</div>
								<div data-thumb-class="col-md-12" data-list-class="col-md-6"
									class="col-md-12">

									<div class="clearfix">
										<div class="title pull-left">
											<h3>
												<a href="#">Audi R8 GT650 2017</a>
											</h3>
											<span class="rating-stars"> <span class="rated"
												style="width: 77%"></span>
											</span> <span class="total-reviews">736 Reviews</span>
										</div>
										<div class="price pull-right">
											223 <small>AED</small>
										</div>
									</div>

									<p>The new TT Quattro, an architectural rhapsody of circles and
										arches in which the promise of i…</p>

									<ul class="list-inline list-features">
										<li><i class="fa fa-car"></i> <span>5 doors</span></li>
										<li><i class="fa fa-car"></i> <span>5 doors</span></li>
										<li><i class="fa fa-car"></i> <span>5 doors</span></li>
										<li><i class="fa fa-car"></i> <span>5 doors</span></li>
									</ul>

								</div>
							</div>
						</div>
					</div>
					<div data-thumb-class="col-md-6" data-list-class="col-md-12"
						class="col-md-6">
						<div class="single-item-lg">
							<div class="row">
								<div data-thumb-class="col-md-12" data-list-class="col-md-6"
									class="col-md-12">
									<div class="img-wrap">
										<a href="#" class="block"> <img class="carved img-responsive"
											src="../../web/images/temp/car3.jpg" alt="">
										</a>
									</div>
								</div>
								<div data-thumb-class="col-md-12" data-list-class="col-md-6"
									class="col-md-12">

									<div class="clearfix">
										<div class="title pull-left">
											<h3>
												<a href="#">Audi R8 GT650 2017</a>
											</h3>
											<span class="rating-stars"> <span class="rated"
												style="width: 89%"></span>
											</span> <span class="total-reviews">736 Reviews</span>
										</div>
										<div class="price pull-right">
											614 <small>AED</small>
										</div>
									</div>

									<p>The new TT Quattro, an architectural rhapsody of circles and
										arches in which the promise of i…</p>

									<ul class="list-inline list-features">
										<li><i class="fa fa-car"></i> <span>5 doors</span></li>
										<li><i class="fa fa-car"></i> <span>5 doors</span></li>
										<li><i class="fa fa-car"></i> <span>5 doors</span></li>
										<li><i class="fa fa-car"></i> <span>5 doors</span></li>
									</ul>

								</div>
							</div>
						</div>
					</div>
					<div data-thumb-class="col-md-6" data-list-class="col-md-12"
						class="col-md-6">
						<div class="single-item-lg">
							<div class="row">
								<div data-thumb-class="col-md-12" data-list-class="col-md-6"
									class="col-md-12">
									<div class="img-wrap">
										<a href="#" class="block"> <img class="carved img-responsive"
											src="../../web/images/temp/car4.jpg" alt="">
										</a>
									</div>
								</div>
								<div data-thumb-class="col-md-12" data-list-class="col-md-6"
									class="col-md-12">

									<div class="clearfix">
										<div class="title pull-left">
											<h3>
												<a href="#">Audi R8 GT650 2017</a>
											</h3>
											<span class="rating-stars"> <span class="rated"
												style="width: 66%"></span>
											</span> <span class="total-reviews">736 Reviews</span>
										</div>
										<div class="price pull-right">
											208 <small>AED</small>
										</div>
									</div>

									<p>The new TT Quattro, an architectural rhapsody of circles and
										arches in which the promise of i…</p>

									<ul class="list-inline list-features">
										<li><i class="fa fa-car"></i> <span>5 doors</span></li>
										<li><i class="fa fa-car"></i> <span>5 doors</span></li>
										<li><i class="fa fa-car"></i> <span>5 doors</span></li>
										<li><i class="fa fa-car"></i> <span>5 doors</span></li>
									</ul>

								</div>
							</div>
						</div>
					</div>
					<div data-thumb-class="col-md-6" data-list-class="col-md-12"
						class="col-md-6">
						<div class="single-item-lg">
							<div class="row">
								<div data-thumb-class="col-md-12" data-list-class="col-md-6"
									class="col-md-12">
									<div class="img-wrap">
										<a href="#" class="block"> <img class="carved img-responsive"
											src="../../web/images/temp/car5.jpg" alt="">
										</a>
									</div>
								</div>
								<div data-thumb-class="col-md-12" data-list-class="col-md-6"
									class="col-md-12">

									<div class="clearfix">
										<div class="title pull-left">
											<h3>
												<a href="#">Audi R8 GT650 2017</a>
											</h3>
											<span class="rating-stars"> <span class="rated"
												style="width: 76%"></span>
											</span> <span class="total-reviews">736 Reviews</span>
										</div>
										<div class="price pull-right">
											469 <small>AED</small>
										</div>
									</div>

									<p>The new TT Quattro, an architectural rhapsody of circles and
										arches in which the promise of i…</p>

									<ul class="list-inline list-features">
										<li><i class="fa fa-car"></i> <span>5 doors</span></li>
										<li><i class="fa fa-car"></i> <span>5 doors</span></li>
										<li><i class="fa fa-car"></i> <span>5 doors</span></li>
										<li><i class="fa fa-car"></i> <span>5 doors</span></li>
									</ul>

								</div>
							</div>
						</div>
					</div>
					<div data-thumb-class="col-md-6" data-list-class="col-md-12"
						class="col-md-6">
						<div class="single-item-lg">
							<div class="row">
								<div data-thumb-class="col-md-12" data-list-class="col-md-6"
									class="col-md-12">
									<div class="img-wrap">
										<a href="#" class="block"> <img class="carved img-responsive"
											src="../../web/images/temp/car6.jpg" alt="">
										</a>
									</div>
								</div>
								<div data-thumb-class="col-md-12" data-list-class="col-md-6"
									class="col-md-12">

									<div class="clearfix">
										<div class="title pull-left">
											<h3>
												<a href="#">Audi R8 GT650 2017</a>
											</h3>
											<span class="rating-stars"> <span class="rated"
												style="width: 64%"></span>
											</span> <span class="total-reviews">736 Reviews</span>
										</div>
										<div class="price pull-right">
											748 <small>AED</small>
										</div>
									</div>

									<p>The new TT Quattro, an architectural rhapsody of circles and
										arches in which the promise of i…</p>

									<ul class="list-inline list-features">
										<li><i class="fa fa-car"></i> <span>5 doors</span></li>
										<li><i class="fa fa-car"></i> <span>5 doors</span></li>
										<li><i class="fa fa-car"></i> <span>5 doors</span></li>
										<li><i class="fa fa-car"></i> <span>5 doors</span></li>
									</ul>

								</div>
							</div>
						</div>
					</div>

				</div>

				<div class="text-center">
					<ul class="pagination">
						<li class="disabled"><a href="#">«</a></li>
						<li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
						<li><a href="#">2</a></li>
						<li><a href="#">3</a></li>
						<li><a href="#">4</a></li>
						<li><a href="#">5</a></li>
						<li><a href="#">»</a></li>
					</ul>
				</div>
			</div>

		</section>
	</div>

</div>
</main>
