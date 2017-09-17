<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Util;
use frontend\models\Car;

/* @var $this yii\web\View */
/* @var $model frontend\models\Car */
/* @var $form ActiveForm */
?>
<h1 class="listing-title"><?= Html::encode('You\'re Almost Ready to Publish') ?></h1>
<?php $form = ActiveForm::begin(['options'=>['class'=>'listing-form']]); ?>
	<?= $form->field($model, 'license_plate_number')->hint('This will not be shown on your profile',['class'=>'help-block'])?>
	<div class="row-small-gutter clearfix">
		<div class="col col-xs-6"><?= $form->field($model, 'price') ?></div>
		<div class="col col-xs-6"><?= $form->field($model, 'currency')->dropDownList(Util::getCurrenciesList(), ['prompt'=>'Select currency']) ?></div>
	</div>
	<?= $form->field($model, 'milage_limitation') ?>
	<?= $form->field($model, 'color')->dropDownList(Car::colorArray(),['prompt'=>'Select color']) ?>
	<?= $form->field($model, 'book_instantly')->checkbox()->hint('- Travelers can book your car instantly without waiting for your approval',['tag'=>false]) ?>
	<?= $form->field($model, 'delivery')->checkbox()->hint(' - Delivering your car to people who book it make it much more attractive to rent',['tag'=>false]) ?>
	<?= $form->field($model, 'description')->textarea(['placeholder'=>'Describe the car features and properties such as Top Speed, Engine Size, Gas economy etc...','rows'=>5]) ?>
	<div class="form-group">
		<?= Html::submitButton('Publish', ['name'=>'form-submit','class' => 'btn btn-primary btn-lg btn-submit']) ?>
	</div>
<?php ActiveForm::end(); ?>
