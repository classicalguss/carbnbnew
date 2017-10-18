<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Tabs;
use frontend\assets\CarAsset;
/* @var $this yii\web\View */
/* @var $model frontend\models\Car */

$this->title = 'Your Cars';
CarAsset::register ( $this );
?>
<h1 class="bold"><?= Html::encode($this->title) ?></h1>

<div class="car-list row">
	<div class="col-md-3">
		<ul class="nav nav-pills nav-stacked nav-stacked-uchaise">
			<li role="presentation" class="active"><a
				href="<?=Url::to(['car/your-cars'])?>">Your Cars</a></li>
			<li role="presentation"><a
				href="<?=Url::to(['car/my-approvals'])?>">Reservation Requests</a></li>
			<li role="presentation"><a
				href="<?=Url::to(['car/approved-requests'])?>">Approved Requests</a></li>
		</ul>
		<br> <br> <a href="<?=Url::to(['car/list-a-car'])?>"
			class="btn btn-primary btn-lg">List a Car</a>
	</div>
	<div class="col-md-9 border-left">
		<div class="car-owner-list">
			<?php foreach ($publishedCars as $car):?>
				<div class="single-owner-car">
					<h3 class="bold status published">
						Published <span></span>
					</h3>
					<div class="row">
						<div class="col-md-5">
							<div class="img-wrap">
								<a href="<?=Url::to(['car/view', 'id'=>$car['id']])?>"
									class="block"> <img width="291px" height="183px" class="carved"
									src="<?=$car['photo']?>" alt="">
								</a>
							</div>
						</div>
						<div class="col-md-7">
							<h3>
								<a href="<?=Url::to(['car/view', 'id'=>$car['id']])?>"><?=$car['make']?> <?=$car['model']?> <?=$car['year_model']?></a>
							</h3>
							<p class="trips"><?=$car['trips']?> Trips</p>
							<p class="text-gray">Last updated on <?=$car['updated_at']?></p>
	
							<ul class="list-inline">
								<li><a target="_blank"
									href="<?=Url::to(['car/update', 'id'=>$car['id']])?>"
									class="btn btn-primary">Manage Listing</a></li>
								<li>
									<?=Html::beginForm ( [ '/car/toggle-publish' ], 'post' ) . Html::hiddenInput ( 'id', $car ['id'] ) . Html::hiddenInput ( 'is_published', '0' ) . Html::submitButton ( 'Unpublish', [ 'class' => 'btn btn-default' ] ) . Html::endForm ()?>
								</li>
							</ul>
	
							<a href="#" class="text-gray">Remove from list</a>
						</div>
					</div>
				</div>
			<?php endforeach;?>
			<?php foreach ($unPublishedCars as $car):?>
				<div class="single-owner-car">
					<h3 class="bold status">
						Unpublished <span></span>
					</h3>
					<div class="row">
						<div class="col-md-5">
							<div class="img-wrap">
								<a href="<?=Url::to(['car/view', 'id'=>$car['id']])?>"
									class="block"> <img width="291px" height="183px" class="carved"
									src="<?=$car['photo']?>" alt="">
								</a>
							</div>
						</div>
						<div class="col-md-7">
							<h3>
								<a href="<?=Url::to(['car/view', 'id'=>$car['id']])?>"><?=$car['make']?> <?=$car['model']?> <?=$car['year_model']?></a>
							</h3>
							<p class="trips"><?=$car['trips']?> Trips</p>
							<p class="text-gray">Last updated on <?=$car['updated_at']?></p>
	
							<ul class="list-inline">
								<li><a target="_blank"
									href="<?=Url::to(['car/update', 'id'=>$car['id']])?>"
									class="btn btn-primary">Manage Listing</a></li>
								<li>
									<?=Html::beginForm ( [ '/car/toggle-publish' ], 'post' ) . Html::hiddenInput ( 'id', $car ['id'] ) . Html::hiddenInput ( 'is_published', '1' ) . Html::submitButton ( 'Publish', [ 'class' => 'btn btn-primary' ] ) . Html::endForm ()?>
								</li>
							</ul>
							<?=Html::beginForm ( [ '/car/delete' ], 'post' ) . Html::hiddenInput ( 'id', $car ['id'] ) . Html::a( 'Remove from list', 'javascript:;', [ 'onclick'=>'$(this).closest(\'form\').submit()','class' => 'text-gray' ] ) . Html::endForm ()?>
							
						</div>
					</div>
				</div>
			<?php endforeach;?>
		</div>
	</div>
</div>