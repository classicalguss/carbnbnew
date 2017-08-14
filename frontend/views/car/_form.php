<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Car */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="car-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'rent_it_now')->textInput() ?>

    <?= $form->field($model, 'area_id')->textInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'milage_limitation')->textInput() ?>

    <?= $form->field($model, 'insurance_tip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'report')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'country_iso')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city_id')->textInput() ?>

    <?= $form->field($model, 'make_id')->textInput() ?>

    <?= $form->field($model, 'model_id')->textInput() ?>

    <?= $form->field($model, 'is_featured')->textInput() ?>

    <?= $form->field($model, 'year_model')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gear_type_id')->textInput() ?>

    <?= $form->field($model, 'number_of_doors')->textInput() ?>

    <?= $form->field($model, 'number_of_seats')->textInput() ?>

    <?= $form->field($model, 'gas_type_id')->textInput() ?>

    <?= $form->field($model, 'type_id')->textInput() ?>

    <?= $form->field($model, 'color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rule_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rule_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rule_3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rule_4')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'currency')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'odometer')->textInput() ?>

    <?= $form->field($model, 'is_published')->textInput() ?>

    <?= $form->field($model, 'book_instantly')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
