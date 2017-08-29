<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Car;

/* @var $this yii\web\View */
/* @var $model frontend\models\Car */
/* @var $form ActiveForm */
?>
<div class="carDetails">

	<?php $form = ActiveForm::begin(['options'=>['onsubmit' => 'switchForm('.$formNum.',this);return false;']]); ?>

		<?= $form->field($model, 'gear_type_id')->radioList(Car::gearArray()) ?>
		<?= $form->field($model, 'number_of_doors') ?>
		<?= $form->field($model, 'number_of_seats') ?>
		<?= $form->field($model, 'gas_type_id')->radioList(Car::gasArray()) ?>
		<?= $form->field($model, 'type_id')->radioList(Car::typeArray()) ?>
		<?= $form->field($model, 'features')->checkboxList(Car::featuresArray()) ?>

		<div class="form-group">
			<?= Html::submitButton('Next', ['class' => 'btn btn-primary']) ?>
		</div>
	<?php ActiveForm::end(); ?>

</div><!-- carDetails -->
