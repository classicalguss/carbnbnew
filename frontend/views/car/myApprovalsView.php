<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\Car */

$this->title = 'Reservation Requests';
?>
<div class="car-update">

	<h1><?=Html::encode($this->title)?></h1>
	<div>
		<?php foreach ($rentsInfo as $rent):?>
			<div>
				<?=$rent['renter_name']?> has requested to reserve your <?=$rent['make']?> <?=$rent['model']?> <?=$rent['year_model']?>
				<br/>
				<?=date("F d", strtotime($rent['from']))?> - <?=date("F d", strtotime($rent['to']))?>
				<br/>
				9:00 AM
				<br/>
				<b><?=$rent['price']*$rent['days_diff']?> <?=$rent['currency']?></b>
				<br/>
				for <?=$rent['days_diff']?> Days
				<br/>
				Dubai - United Arab Emirates
				<br/>
				<?=Html::beginForm ([
						'/car/approve-reserve'
				], 'post').Html::hiddenInput('id', $rent['id']).Html::hiddenInput('action', 'approve') . Html::submitButton ( 'Approve', [
						'class' => 'btn btn-link'
				] ).Html::endForm ()?>
				<?=Html::beginForm ([
						'/car/approve-decline'
				], 'post').Html::hiddenInput('id', $rent['id']).Html::hiddenInput('action', 'decline') . Html::submitButton ( 'Decline', [
						'class' => 'btn btn-link'
				] ).Html::endForm ()?>
				<br/>
				<?=$rent['left_to_confirm']?> Days left to confirm
			</div>
			<br/>
		<?php endforeach;?>
	</div>
</div>