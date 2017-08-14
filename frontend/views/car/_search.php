<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\CarSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="car-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'price') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'rent_it_now') ?>

    <?= $form->field($model, 'area_id') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'milage_limitation') ?>

    <?php // echo $form->field($model, 'insurance_tip') ?>

    <?php // echo $form->field($model, 'owner_id') ?>

    <?php // echo $form->field($model, 'report') ?>

    <?php // echo $form->field($model, 'country_iso') ?>

    <?php // echo $form->field($model, 'city_id') ?>

    <?php // echo $form->field($model, 'make_id') ?>

    <?php // echo $form->field($model, 'model_id') ?>

    <?php // echo $form->field($model, 'is_featured') ?>

    <?php // echo $form->field($model, 'year_model') ?>

    <?php // echo $form->field($model, 'gear_type_id') ?>

    <?php // echo $form->field($model, 'number_of_doors') ?>

    <?php // echo $form->field($model, 'number_of_seats') ?>

    <?php // echo $form->field($model, 'gas_type_id') ?>

    <?php // echo $form->field($model, 'type_id') ?>

    <?php // echo $form->field($model, 'color') ?>

    <?php // echo $form->field($model, 'rule_1') ?>

    <?php // echo $form->field($model, 'rule_2') ?>

    <?php // echo $form->field($model, 'rule_3') ?>

    <?php // echo $form->field($model, 'rule_4') ?>

    <?php // echo $form->field($model, 'photo1') ?>

    <?php // echo $form->field($model, 'photo2') ?>

    <?php // echo $form->field($model, 'photo3') ?>

    <?php // echo $form->field($model, 'photo4') ?>

    <?php // echo $form->field($model, 'photo5') ?>

    <?php // echo $form->field($model, 'photo6') ?>

    <?php // echo $form->field($model, 'currency') ?>

    <?php // echo $form->field($model, 'features') ?>

    <?php // echo $form->field($model, 'odometer') ?>

    <?php // echo $form->field($model, 'is_published') ?>

    <?php // echo $form->field($model, 'book_instantly') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
