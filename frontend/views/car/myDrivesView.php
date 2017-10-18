<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\CarAsset;
/* @var $this yii\web\View */
/* @var $model frontend\models\Car */

CarAsset::register ( $this );
$this->title = 'My Drives';
/* @var $this yii\web\View */
/* @var $model frontend\models\Car */
?>
<h2><?= Html::encode($this->title) ?></h2>
<div class="row">
	<div class="col-sm-3">
		<ul id="nav-tabs-wrapper"
			class="nav nav-tabs nav-pills nav-stacked nav-stacked-uchaise">
			<li class="active"><a href="<?=Url::to(['car/my-drives'])?>">My Drives</a></li>
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
								<h2>From <?=$car['date_start']?> to <?=$car['date_end']?></h2>
								<p><?=$car['make']?> <?=$car['model']?> <?=$car['year_model']?></p>
								<p class="text-gray"><?=$car['location']?></p>
								<?php if($car['status'] == 0):?>
									<p style="color:#fd8809">Be patient, waiting approval from <?=$car['owner_name']?></p>
								<?php elseif($car['status'] == 1):?>
									<p style="color:#27c650">Ok let’s go! Rental approved by <?=$car['owner_name']?></p>
								<?php else:?>
									<p style="color:#f36073">Sorry, maybe next time. Rental declined</p>
								<?php endif;?>
							</div>
							<div class="pull-right">
								<img style="width:220px;height:140px" src="<?=$car['photo']?>" alt="car">
							</div>
						</div>
					<?php endforeach;?>
				</div>
			</div>
			<!-- history -->
		</div>
	</div>
</div>