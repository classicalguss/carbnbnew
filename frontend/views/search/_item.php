<?php
use frontend\models\Car;
use yii\helpers\Url;
?>
<div class="single-item-lg">
	<div class="row">
		<div data-thumb-class="col-md-12" data-list-class="col-md-6"
			class="col-md-12">
			<div class="img-wrap">
				<a href="<?=Url::to(['car/view/','id'=>$model->id,'daterange'=>Yii::$app->request->get('daterange')])?>" class="block">
					<img width="350" height="220" class="carved img-responsive" src="<?=$model->photoFile1Array['path']?>" alt="">
				</a>
			</div>
		</div>
		<div data-thumb-class="col-md-12" data-list-class="col-md-6" class="search-car-details col-md-12">
			<div class="clearfix">
				<div class="title pull-left left-portion">
					<h3>
						<a href="<?=Url::to(['car/view/','id'=>$model->id,'daterange'=>Yii::$app->request->get('daterange')])?>">
							<?=$model->make->value.' '.$model->model->value?>
						</a>
					</h3>

					<span class="rating-stars"> <span class="rated"
						style="width: <?=$model->rate*20?>%"></span>
					</span> <span class="total-reviews"><?=$model->reviews?> Reviews</span>
				</div>
				<div class="price pull-right">
					<?=$model->price?> <small>AED</small>
				</div>
			</div>

			<p><?=$model->description?></p>

			<ul class="list-inline list-features">
					<li>
						<img src="<?=Yii::$app->params['siteImagesPath'].'/'.Car::gearArray()[$model->gear_type_id].'_icon_sm.png'?>">
						<br />
						<span><?=Car::gearArray()[$model->gear_type_id]?></span>
					</li>
					<li>
						<img src="<?=Yii::$app->params['siteImagesPath'].'/Door_icon_sm.png'?>">
						<br />
						<span><?=$model->number_of_doors?> doors</span>
					</li>
					<li>
						<img src="<?=Yii::$app->params['siteImagesPath'].'/Seat_icon_sm.png'?>">
						<br />
						<span><?=$model->number_of_seats?> seats</span>
					</li>
					<li>
						<img src="<?=Yii::$app->params['siteImagesPath'].'/'.Car::gasArray()[$model->gas_type_id].'_icon_sm.png'?>">
						<br />
						<span><?=Car::gasArray()[$model->gas_type_id]?></span>
					</li>
			</ul>

		</div>
	</div>
</div>
