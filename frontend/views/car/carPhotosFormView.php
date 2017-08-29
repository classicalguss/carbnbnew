<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Car */
/* @var $form ActiveForm */
?>
<div class="carDetails">

	<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'photoFile1')->fileInput()?>
		<?= $form->field($model, 'photoFile2')->fileInput()?>
		<?= $form->field($model, 'photoFile3')->fileInput()?>
		<?= $form->field($model, 'photoFile4')->fileInput()?>
		<?= $form->field($model, 'photoFile5')->fileInput()?>
		<?= $form->field($model, 'photoFile6')->fileInput()?>

		<div class="form-group">
			<?= Html::button('Next', ['class' => 'btn btn-primary', 'onclick' => 'switchForm('.$formNum.',-1);']) ?>
		</div>
	<?php ActiveForm::end(); ?>

</div><!-- carDetails -->
