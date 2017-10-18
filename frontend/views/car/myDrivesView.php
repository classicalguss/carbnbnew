<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\CarAsset;
/* @var $this yii\web\View */
/* @var $model frontend\models\Car */

CarAsset::register ( $this );
$this->title = 'Drive History';
/* @var $this yii\web\View */
/* @var $model frontend\models\Car */
?>
<h2><?= Html::encode($this->title) ?></h2>
<div class="row">
	<div class="col-sm-3">
		<ul id="nav-tabs-wrapper"
			class="nav nav-tabs nav-pills nav-stacked nav-stacked-uchaise">
			<li class="active"><a href="<?=Url::to(['car/my-drives'])?>">Drive History</a></li>
		</ul>
		<a class="btn btn-primary btn-block" href="<?=Url::to(['/search'])?>">Search Cars</a>
	</div>
	<div class="col-sm-9">
		<div class="tab-content clearfix">
			<!-- history -->
			<div role="tabpanel" class="row tab-pane fade in active"
				id="myHistory">
				<div class="col-sm-12">
					<?php foreach ($carsInfo as $car):?>
						<div class="car-container clearfix">
							<div class="pull-left">
								<h2><?=$car['make']?> <?=$car['model']?> <?=$car['year_model']?></h2>
								<span>Milage Limitation: <?=$car['milage_limitation']?> Km</span>
							</div>
							<div class="pull-right">
								<img src="<?=$car['photo']?>" alt="car">
							</div>
						</div>
					<?php endforeach;?>
				</div>
			</div>
			<!-- history -->
		</div>
	</div>
</div>