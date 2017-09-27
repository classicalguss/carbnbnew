<?php
use yii\helpers\Html;
use frontend\models\Car;
use yii\helpers\Url;
use frontend\assets\CarAsset;
use frontend\assets\AppAsset;
/* @var $this yii\web\View */
/* @var $model frontend\models\Car */

$this->title = 'Car Listed Successfully';
AppAsset::register($this);
CarAsset::register($this);

?>
<div class="publishded-alert text-center">
	<i class="icon fa fa-check-circle fa-5x"></i>
	<h1>Your Car is published!</h1>
	<p>Listing Successful!</p>
	<a href="#" class="btn btn-primary btn-lg">Manage Listing</a>
</div>
<div class="single-item-lg block-center">
	<div class="row">
		<div class="col-md-6">
			<div class="img-wrap">
				<a href="<?=Url::to(['car/view/','id'=>$model->id])?>" class="block"> <img width="350" height="220" class="carved img-responsive"
					src="<?=$model->photoFile1Array['path']?>" alt="">
				</a>
			</div>
		</div>
		<div class="col-md-6">

			<div class="clearfix">
				<div class="title pull-left">
					<h3>
						<a href="<?=Url::to(['car/view/','id'=>$model->id])?>"><?=$model->make->value.' '.$model->model->value?></a>
					</h3>
					<span><?=Car::typeArray()[$model->type_id]?></span>
				</div>
				<div class="price pull-right">
					<?=$model->price?> <small>AED</small>
				</div>
			</div>

			<p><?=$model->description?></p>

			<ul class="list-inline list-features">
					<li><img src="<?=Yii::$app->params['siteImagesPath'].'/'.Car::gearArray()[$model->gear_type_id].'_icon_sm.png'?>"> <div><?=Car::gearArray()[$model->gear_type_id]?></<div></li>
					<li><img src="<?=Yii::$app->params['siteImagesPath'].'/Door_icon_sm.png'?>"><div><?=$model->number_of_doors?> doors</div></li>
					<li><img src="<?=Yii::$app->params['siteImagesPath'].'/Seat_icon_sm.png'?>"><div><?=$model->number_of_seats?> seats</div></li>
					<li><img src="<?=Yii::$app->params['siteImagesPath'].'/'.Car::gasArray()[$model->gas_type_id].'_icon_sm.png'?>"></i> <div><?=Car::gasArray()[$model->gas_type_id]?></div></li>
			</ul>

		</div>
	</div>
</div>