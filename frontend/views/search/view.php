<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Car */

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
            'area_id',
            'description:ntext',
            'milage_limitation',
            'insurance_tip',
            'owner_id',
            'report:ntext',
            'country_iso',
            'city_id',
            'make_id',
            'model_id',
            'is_featured',
            'year_model',
            'gear_type_id',
            'number_of_doors',
            'number_of_seats',
            'gas_type_id',
            'type_id',
            'color',
            'rule_1',
            'rule_2',
            'rule_3',
            'rule_4',
            'photo1',
            'photo2',
            'photo3',
            'photo4',
            'photo5',
            'photo6',
            'currency',
            'features',
            'odometer',
            'is_published',
            'book_instantly',
        ],
    ]) ?>

</div>
