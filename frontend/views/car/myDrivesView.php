<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\Car */

$this->title = 'Your Drives';
?>
<div class="car-update">

	<h1><?= Html::encode($this->title) ?></h1>

	<?php foreach ($carsInfo as $car):?>
		<div>
			<img alt="" src="<?=$car['photo']?>" width="280" height="164">
			<br/>
			<?=$car['make']?> <?=$car['model']?> <?=$car['year_model']?>
			<br/>
			259 Km driven
			<br/>
		</div>
		<br/>
	<?php endforeach;?>
</div>