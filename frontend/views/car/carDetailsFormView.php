<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Car;
use common\models\Carmake;
use common\models\Carmodel;
use common\models\City;
use yii\helpers\ArrayHelper;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

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
<h1 class="listing-title"><?= Html::encode('Hi, '.Yii::$app->user->identity->first_name.'! Let\'s get started listing your Car.') ?></h1>

<?php $form = ActiveForm::begin(['options'=>['class'=>'listing-form','onsubmit' => 'switchForm('.$formNum.',this);return false;']]); ?>
    <?= $form->field($model, 'city_id')->dropDownList(ArrayHelper::map(City::find()->all(), 'id', 'value'), ['prompt'=>'Select City']) ?>
	<div class="row-small-gutter clearfix">
		<div class="col col-xs-4"><?= $form->field($model, 'make_id')
                ->dropDownList(Carmake::getAllCarMakes(),[
                        'prompt'=>'Select make', 'id'=>'makeId-dd'
                ])
            ?></div>
		<div class="col col-xs-4"><?= $form->field($model, 'model_id')->dropDownList($carModelList, ['prompt'=>'Select model', 'id'=>'modelId-dd']) ?></div>
		<div class="col col-xs-4"><?= $form->field($model, 'year_model')->dropDownList($yearsList,['prompt'=>'Select year']) ?></div>
	</div>
	<?= $form->field($model, 'odometer')->dropDownList(Car::odometerArray(),['prompt'=>'Select odometer']) ?>
	<?= $form->field($model, 'insurance_tip')->checkbox() ?>

	<div class="form-group">
		<?= Html::submitButton('Next', ['class' => 'btn btn-primary btn-lg btn-submit']) ?>
	</div>
<?php ActiveForm::end(); ?>
