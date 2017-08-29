<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Car;
use common\models\Carmake;
use common\models\Carmodel;

$startingYear = 1950;
$endingYear   = date('Y', strtotime('+1 year'));
$yearsList=[];
for ($i=$endingYear;$i>=$startingYear;$i--)
{
	$yearsList[$i]=$i;
}

$carModelList = [];
if (!empty($model->make_id))
	$carModelList = Carmodel::getCarMakeModels($model->make_id);
/* @var $this yii\web\View */
/* @var $model frontend\models\Car */
/* @var $form ActiveForm */
?>
<div class="carDetails">

	<?php $form = ActiveForm::begin(['options'=>['onsubmit' => 'switchForm('.$formNum.',this);return false;']]); ?>

		<?= $form->field($model, 'country_iso') ?>
		<?= $form->field($model, 'city_id') ?>
		<?= $form->field($model, 'area_id') ?>
		<?= $form->field($model, 'make_id')->dropDownList(Carmake::getAllCarMakes(),['prompt'=>'Select make', 'id'=>'makeId-dd']) ?>
		<?= $form->field($model, 'model_id')->dropDownList($carModelList, ['prompt'=>'Select model', 'id'=>'modelId-dd']) ?>
		<?= $form->field($model, 'year_model')->dropDownList($yearsList,['prompt'=>'Select year']) ?>
		<?= $form->field($model, 'odometer')->dropDownList(Car::odometerArray(),['prompt'=>'Select odometer']) ?>
		<?= $form->field($model, 'insurance_tip')->checkbox() ?>

		<div class="form-group">
			<?= Html::submitButton('Next', ['class' => 'btn btn-primary']) ?>
		</div>
	<?php ActiveForm::end(); ?>

</div><!-- carDetails -->
