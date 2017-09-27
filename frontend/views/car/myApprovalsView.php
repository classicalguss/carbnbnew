<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\CarAsset;
/* @var $this yii\web\View */
/* @var $model frontend\models\Car */

$this->title = 'Your Cars';
CarAsset::register ( $this );
$this->title = 'Reservation Requests';
?>
<h1 class="bold"><?= Html::encode($this->title) ?></h1>

<div class="car-list row">
	<div class="col-md-3">
		<ul class="nav nav-pills nav-stacked nav-stacked-uchaise">
			<li role="presentation"><a href="<?=Url::to(['car/your-cars'])?>">Your
					Cars</a></li>
			<li role="presentation" class="active"><a
				href="<?=Url::to(['car/my-approvals'])?>">Reservation Requests</a></li>
		</ul>
		<br> <br> <a href="<?=Url::to(['car/list-a-car'])?>"
			class="btn btn-primary btn-lg">List a Car</a>
	</div>
	<div class="col-md-9 border-left">
		<div class="car-owner-list">
			<?php foreach ($rentsInfo as $rent):?>
				<div class="single-reservation clearfix">
					<div class="row">
						<div class="col-md-8">
							<h5 class="bold"><?=$rent['renter_name']?> has requested to reserve your <?=$rent['make']?> <?=$rent['model']?> <?=$rent['year_model']?></h5>
	
							<div class="media">
								<div class="media-left media-middle">
									<a href="#"> <img class="media-object img-circle" width="70px"
										src="<?=$rent['renterPhoto']?>">
									</a>
								</div>
								<div class="media-body">
									<p><?=date("F d", strtotime($rent['from']))?> - <?=date("F d", strtotime($rent['to']))?></p>
									<p><?=date('H:i', strtotime($rent['delivery_time']))?></p>
									<p><?=$rent['city']?> - United Arab Emirates</p>
								</div>
							</div>
						</div>
						<div class="col-md-4 text-right">
							<span class="text-gray">Requested on <?=date('F j, Y',strtotime($rent['reserved_at']))?></span>
	
							<div class="price">
								<?=$rent['price']*$rent['days_diff']?> <small><?=$rent['currency']?></small>
							</div>
							<span>for <?=$rent['days_diff']?> days</span>
						</div>
					</div>
					<ul class="list-inline buttons-group">
						<li>
							<?=Html::beginForm ( [ '/car/approve-booking' ], 'post' ) . Html::hiddenInput ( 'id', $rent ['id'] ) . Html::hiddenInput ( 'action', 'approve' ) . Html::submitButton ( 'Approve', [ 'class' => 'btn btn-primary' ] ) . Html::endForm ()?>
						</li>
						<li>
							<?=Html::beginForm ( [ '/car/decline-booking' ], 'post' ) . Html::hiddenInput ( 'id', $rent ['id'] ) . Html::hiddenInput ( 'action', 'decline' ) . Html::submitButton ( 'Decline', [ 'class' => 'btn btn-default' ] ) . Html::endForm ()?>
						</li>
						<li class="text-gray"><?=$rent['left_to_confirm']?> Days left to confirm</li>
					</ul>
				</div>
			<?php endforeach;?>
		</div>
	</div>
</div>