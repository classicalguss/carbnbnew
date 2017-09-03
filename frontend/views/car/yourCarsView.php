<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\Car */

$this->title = 'Your Cars';
?>
<div class="car-update">

	<h1><?= Html::encode($this->title) ?></h1>

	<h2>Published</h2>
	<?php foreach ($publishedCars as $car):?>
		<div>
			<?=$car['make']?> <?=$car['model']?> <?=$car['year_model']?>
			<br/>
			<?=$car['trips']?> Trips
			<br/>
			Last updated on <?=$car['updated_at']?>
			<br/>
			<a href="<?=Url::to(['car/update', 'id'=>$car['id']])?>" class="btn btn-link" target="_blank">Manage Listing</a>
			<?=Html::beginForm ([
					'/car/toggle-publish'
			], 'post').Html::hiddenInput('id', $car['id']).Html::hiddenInput('is_published', '0') . Html::submitButton ( 'Unpublish', [
					'class' => 'btn btn-link'
			] ).Html::endForm ()?>
			<?=Html::beginForm ([
					'/car/delete'
			], 'post').Html::hiddenInput('id', $car['id']).Html::submitButton ( 'Remove from list', [
					'class' => 'btn btn-link'
			] ).Html::endForm ()?>
		</div>
		<br/>
	<?php endforeach;?>
	<br/><br/>
	<h2>Unpublished</h2>
	<?php foreach ($unPublishedCars as $car):?>
		<div>
			<?=$car['id']?>
			<br/>
			<?=$car['make']?> <?=$car['model']?> <?=$car['year_model']?>
			<br/>
			<?=$car['trips']?> Trips
			<br/>
			Last updated on <?=$car['updated_at']?>
			<br/>
			<a href="<?=Url::to(['car/update', 'id'=>$car['id']])?>" class="btn btn-link" target="_blank">Manage Listing</a>
			<br/>
			<?=Html::beginForm ([
					'/car/toggle-publish'
			], 'post').Html::hiddenInput('id', $car['id']).Html::hiddenInput('is_published', '1') . Html::submitButton ( 'Publish', [
					'class' => 'btn btn-link'
			] ).Html::endForm ()?>
			<?=Html::beginForm ([
					'/car/delete'
			], 'post').Html::hiddenInput('id', $car['id']).Html::submitButton ( 'Remove from list', [
					'class' => 'btn btn-link'
			] ).Html::endForm ()?>
		</div>
		<br/>
	<?php endforeach;?>
</div>