<?php
use frontend\models\Car;
use yii\helpers\Url;
?>
<div class="single-item-lg">
	<div class="row">
		<div data-thumb-class="col-md-12" data-list-class="col-md-6"
			class="col-md-12">
			<div class="img-wrap">
				<a href="<?=Url::to(['car/view/','id'=>$model->id])?>" class="block"> 
					<img width="350" height="220" class="carved" src="<?=$model->photoFile1Array['path']?>" alt="">
				</a>
			</div>
		</div>
		<div data-thumb-class="col-md-12" data-list-class="col-md-6" class="col-md-12">
			<div class="clearfix">
				<div class="title pull-left">
					<h3>
						<a href="<?=Url::to(['car/view/','id'=>$model->id])?>"><?=$model->make->value.' '.$model->model->value?></a>
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
					<li><i class="fa fa-car"></i> <span><?=Car::gearArray()[$model->gear_type_id]?></span></li>
					<li><i class="fa fa-car"></i> <span><?=$model->number_of_doors?> doors</span></li>
					<li><i class="fa fa-car"></i> <span><?=$model->number_of_seats?> seats</span></li>
					<li><i class="fa fa-car"></i> <span><?=Car::gasArray()[$model->gas_type_id]?></span></li>
			</ul>

		</div>
	</div>
</div>