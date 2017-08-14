<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cars';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="car-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Car', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'price',
            'created_at',
            'rent_it_now',
            'area_id',
            // 'description:ntext',
            // 'milage_limitation',
            // 'insurance_tip',
            // 'owner_id',
            // 'report:ntext',
            // 'country_iso',
            // 'city_id',
            // 'make_id',
            // 'model_id',
            // 'is_featured',
            // 'year_model',
            // 'gear_type_id',
            // 'number_of_doors',
            // 'number_of_seats',
            // 'gas_type_id',
            // 'type_id',
            // 'color',
            // 'rule_1',
            // 'rule_2',
            // 'rule_3',
            // 'rule_4',
            // 'photo1',
            // 'photo2',
            // 'photo3',
            // 'photo4',
            // 'photo5',
            // 'photo6',
            // 'currency',
            // 'features',
            // 'odometer',
            // 'is_published',
            // 'book_instantly',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
