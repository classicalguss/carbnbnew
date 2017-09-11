<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Util;
use frontend\models\Car;

/* @var $this yii\web\View */
/* @var $model frontend\models\Car */
/* @var $form ActiveForm */
?>
<div class="carDetails">

	<h1><?= Html::encode('You\'re Almost Ready to Publish') ?></h1>
	<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'milage_limitation') ?>
		<?= $form->field($model, 'color')->dropDownList(Car::colorArray(), ['prompt'=>'Select color']) ?>
		<?= $form->field($model, 'price') ?>
		<?= $form->field($model, 'currency')->dropDownList(Util::getCurrenciesList(), ['prompt'=>'Select currency']) ?>
		<?= $form->field($model, 'book_instantly')->checkbox() ?> - Travelers can book your car instantly without waiting for your approval
		<?= $form->field($model, 'description')->textarea() ?>

		<div class="form-group">
			<?= Html::submitButton('Publish', ['class' => 'btn btn-primary']) ?>
		</div>
	<?php ActiveForm::end(); ?>

</div><!-- carDetails -->
