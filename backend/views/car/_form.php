<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Car */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="car-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'rent_it_now')->textInput() ?>

    <?= $form->field($model, 'area_id')->textInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'milage_limitation')->textInput() ?>

    <?= $form->field($model, 'insurance_tip')->textInput() ?>

    <?= $form->field($model, 'owner_id')->textInput() ?>

    <?= $form->field($model, 'report')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'maker')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'model')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_featured')->textInput() ?>

    <?= $form->field($model, 'year_model')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gear_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'number_of_doors')->textInput() ?>

    <?= $form->field($model, 'number_of_seats')->textInput() ?>

    <?= $form->field($model, 'gas')->textInput() ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rule_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rule_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rule_3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rule_4')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'interior_photo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'back_photo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'front_photo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'side_photo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'optional_photo_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'optional_photo_2')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
