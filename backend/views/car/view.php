<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Car */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="car-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'price',
            'created_at',
            'rent_it_now',
            'address',
            'description:ntext',
            'milage_limitation',
            'insurance_tip',
            'owner_id',
            'report:ntext',
            'country',
            'city',
            'maker',
            'model',
            'is_featured',
            'year_model',
            'gear_type',
            'number_of_doors',
            'number_of_seats',
            'gas',
            'type',
            'color',
            'rule_1',
            'rule_2',
            'rule_3',
            'rule_4',
            'interior_photo',
            'back_photo',
            'front_photo',
            'side_photo',
            'optional_photo_1',
            'optional_photo_2',
        ],
    ]) ?>

</div>
