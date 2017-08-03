<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cars';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="car-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Car', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'price',
            'created_at',
            'rent_it_now',
            // 'description:ntext',
            // 'milage_limitation',
            // 'insurance_tip',
            // 'owner_id',
            // 'report:ntext',
            // 'country',
            // 'city',
            // 'maker',
            // 'model',
            // 'is_featured',
            // 'year_model',
            // 'gear_type',
            // 'number_of_doors',
            // 'number_of_seats',
            // 'gas',
            // 'type',
            // 'color',
            // 'rule_1',
            // 'rule_2',
            // 'rule_3',
            // 'rule_4',
            // 'interior_photo',
            // 'back_photo',
            // 'front_photo',
            // 'side_photo',
            // 'optional_photo_1',
            // 'optional_photo_2',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
