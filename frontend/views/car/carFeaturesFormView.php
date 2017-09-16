<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Car;

/* @var $this yii\web\View */
/* @var $model frontend\models\Car */
/* @var $form ActiveForm */
?>
<h1 class="listing-title"><?= Html::encode('What Features are also Included?') ?></h1>
<?php $form = ActiveForm::begin(['options'=>['class'=>'listing-form','onsubmit' => 'switchForm('.$formNum.',this);return false;']]); ?>

	<?= $form->field($model, 'gear_type_id')->radioList(Car::gearArray(),['class'=>'list-inline','tag'=>'ul','item'=>function($index,$label,$name,$checked,$value) {
		if ($checked == 1)
			$checked = 'checked';
		return '<li class="radio"><label><input name='.$name.' value='.$value.' type="radio" '.$checked.'>'.$label.'</label></li>';
	}]) ?>
	<div class="row-small-gutter clearfix">
		<div class="col col-xs-4"><?= $form->field($model, 'number_of_doors',['inputOptions'=>['class'=>'form-control','type'=>'number','max'=>8,'min'=>2]]) ?></div>
		<div class="col col-xs-4"><?= $form->field($model, 'number_of_seats',['inputOptions'=>['class'=>'form-control','type'=>'number']]) ?></div>
	</div>
	<?= $form->field($model, 'gas_type_id')->radioList(Car::gasArray(),['class'=>'list-inline feature-checkbox','tag'=>'ul','item'=>function($index,$label,$name,$checked,$value) {
		if ($checked == 1)
			$checked = 'checked';
		return '<li><label><i class="icon fa fa-car"></i><div>'.$label.'</div><input name='.$name.' value='.$value.' type="radio" '.$checked.'></label></li>';
	}]) ?>
	<?= $form->field($model, 'type_id')->radioList(Car::typeArray(),['class'=>'list-inline feature-checkbox','tag'=>'ul','item'=>function($index,$label,$name,$checked,$value) {
		if ($checked == 1)
			$checked = 'checked';
		return '<li><label><i class="icon fa fa-car"></i><div>'.$label.'</div><input name='.$name.' value='.$value.' type="radio" '.$checked.'></label></li>';
	}]) ?>
	<?= $form->field($model, 'features')->checkboxList(Car::featuresArray(),['class'=>'list-inline feature-checkbox','tag'=>'ul','item'=>function($index,$label,$name,$checked,$value) {
		if ($checked == 1)
			$checked = 'checked';
		return '<li><label><i class="icon fa fa-car"></i><div>'.$label.'</div><input name='.$name.' value='.$value.' type="checkbox" '.$checked.'></label></li>';
	}]) ?>
	<div class="form-group">
		<?= Html::submitButton('Next', ['class' => 'btn btn-primary btn-lg btn-submit']) ?>
	</div>
<?php ActiveForm::end(); ?>
