<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use yii\helpers\Url;
use frontend\widgets\EPjax;
use yii\widgets\Pjax;
use common\models\Carmake;
use yii\helpers\ArrayHelper;
use frontend\models\Car;

/* @var $this yii\web\View */
/* @var $model frontend\models\CarSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="clearfix space-bottom">
	<div class="pull-left">
		<h4 class="bold">Filters</h4>
	</div>
	<div class="pull-right">
		<a class="form-clear text-gray" href="<?=Url::toRoute('search/index')?>">Clear
			All</a>
	</div>
</div>
<?php
		
		$form = ActiveForm::begin ( [ 
				'action' => [ 
						'index' 
				],
				'method' => 'get',
				'options' => [ 
						'data-pjax' => '',
						'id' => 'car-search-form' 
				],
				'fieldConfig'=>['options'=>['tag'=>false],'template'=>"{input}\n{label}\n{hint}\n{error}"]
		] );
?>
	<ul class="list-unstyled general-filters">
		<li class="row-small-gutter">
			<div class="col col-xs-9">
				<strong>Book Instantly</strong>
				<p class="text-gray font-small">Reserve the car without waiting for
					approval</p>
			</div>
			<div class="col col-xs-3">
				<div class="switch pull-right">
					<?= $form->field($model, 'book_instantly')->checkbox(['id'=>'filter-1','class'=>'cmn-toggle cmn-toggle-round'],false)->label('',['for'=>'filter-1']) ?>
				</div>
			</div>
		</li>
		<li class="row-small-gutter">
			<div class="col col-xs-9">
				<strong>Delivery</strong>
				<p class="text-gray font-small">Get the car delivered directly to you</p>
			</div>
			<div class="col col-xs-3">
				<div class="switch pull-right">
					<?= $form->field($model, 'delivery')->checkbox(['id'=>'filter-2','class'=>'cmn-toggle cmn-toggle-round'],false)->label('',['for'=>'filter-2']) ?>
				</div>
			</div>
		</li>
		<li><strong class="filter-title">Price Range</strong>
			<div class="rangeSliderWrap range-slider-wrap clearfix">
				<div id="priceRangeSlider" data-end="<?=$model->max_price?>" data-start="<?=$model->min_price?>" data-initial-start="<?=$stats['min_price']?>"
					data-initial-end="<?=$stats['max_price']?>">

				</div>
				<div class="range-slider-text clearfix">
					<?= $form->field($model, 'min_price')->input('hidden',['class'=>'rangeMinValue'])->label(false)?>
					<?= $form->field($model, 'max_price')->input('hidden',['class'=>'rangeMaxValue'])->label(false)?>
					<span class="price pull-left range-number"> 
						<span class="rangeMinText"><?=$stats['min_price']?></span>
						<small class="text-gray">AED</small>
					</span> 
					<span class="price pull-right range-number"> 
						<span class="rangeMaxText"><?=$stats['max_price']?></span> 
						<small class="text-gray">AED</small>
					</span>
				</div>
			</div>
		</li>
		<li><strong class="filter-title">Mileage Limitation</strong>
			<div class="rangeSliderWrap range-slider-wrap clearfix">
				<div id="milageRangeSlider" data-end="<?=$model->max_milage_limitation?>" data-start="<?=$model->min_milage_limitation?>" data-initial-start="<?=$stats['min_milage_limitation']?>"
					data-initial-end="<?=$stats['max_milage_limitation']?>">

				</div>
				<div class="range-slider-text clearfix">
					<?= $form->field($model, 'min_milage_limitation')->input('hidden',['class'=>'rangeMinValue'])->label(false)?>
					<?= $form->field($model, 'max_milage_limitation')->input('hidden',['class'=>'rangeMaxValue'])->label(false)?>
					<span class="price pull-left range-number"> 
						<span class="rangeMinText"><?=$stats['min_milage_limitation']?></span>
					</span> 
					<span class="price pull-right range-number"> 
						<span class="rangeMaxText"><?=$stats['max_milage_limitation']?></span>
					</span>
				</div>
			</div>
		</li>
		<li>
			<strong class="filter-title">Transmission</strong>
			<?=$form->field($model, 'gear_type_id')->checkboxList(['0'=>'Manual','1'=>'Automatic'],['tag'=>'ul','class'=>"list-inline",'item'=>function($index,$label,$name,$checked,$value) {
				if ($checked == 1)
					$checked = 'checked';
				return '<li class="checkbox"><label><input name='.$name.' value='.$value.' type="checkbox" '.$checked.'>'.$label.'</label></li>';
			}])->label(false)?>
			
		</li>
	</ul>
	<div id="filtersAccordion" class="panel-group" role="tablist" aria-multiselectable="true">
		<div class="panel panel-filter">
			<div class="panel-heading" role="tab">
				<strong class="panel-title"> <a class="collapsed" role="button"
					data-toggle="collapse" data-parent="#filtersAccordion"
					href="#collapse-vehicle-type" aria-expanded="true"
					aria-controls="collapse-vehicle-type"> Vehicle Types </a>
				</strong>
			</div>
			<div id="collapse-vehicle-type" class="panel-collapse collapse"
				role="tabpanel">
				<div class="panel-body">
					<?=$form->field($model, 'type_id')->checkboxList(Car::typeArray(),['tag'=>'ul','class'=>"list-unstyled",'item'=>function($index,$label,$name,$checked,$value) {
						if ($checked == 1)
							$checked = 'checked';
						return '<li class="checkbox"><label><input name='.$name.' value='.$value.' type="checkbox" '.$checked.'>'.$label.'</label></li>';
					}])->label(false)?>
				</div>
			</div>
		</div>
		<div class="panel panel-filter">
			<div class="panel-heading" role="tab">
				<strong class="panel-title"> <a class="collapsed" role="button"
					data-toggle="collapse" data-parent="#filtersAccordion"
					href="#collapse-color" aria-expanded="true"
					aria-controls="collapse-color"> Color</a>
				</strong>
			</div>
			<div id="collapse-color" class="panel-collapse collapse"
				role="tabpanel">
				<div class="panel-body">
					<?=$form->field($model, 'color')->checkboxList(Car::colorArray(),['tag'=>'ul','class'=>"list-unstyled",'item'=>function($index,$label,$name,$checked,$value) {
						if ($checked == 1)
							$checked = 'checked';
						return '<li class="checkbox"><label><input name='.$name.' value='.$value.' type="checkbox" '.$checked.'>'.$label.'</label></li>';
					}])->label(false)?>
				</div>
			</div>
		</div>
		<div class="panel panel-filter">
			<div class="panel-heading" role="tab">
				<strong class="panel-title"> <a class="collapsed" role="button"
					data-toggle="collapse" data-parent="#filtersAccordion"
					href="#collapse-make" aria-expanded="true"
					aria-controls="collapse-make"> Make </a>
				</strong>
			</div>
			<div id="collapse-make" class="panel-collapse collapse"
				role="tabpanel">
				<div class="panel-body">
					<?=$form->field($model, 'make_id')->checkboxList($allMakes,['tag'=>'ul','class'=>"list-unstyled",'item'=>function($index,$label,$name,$checked,$value) {
						if ($checked == 1)
							$checked = 'checked';
						return '<li class="checkbox"><label><input name='.$name.' value='.$value.' type="checkbox" '.$checked.'>'.$label.'</label></li>';
					}])->label(false)?>
				</div>
			</div>
		</div>
		<div class="panel panel-filter">
			<div class="panel-heading" role="tab">
				<strong class="panel-title"> <a class="collapsed" role="button"
					data-toggle="collapse" data-parent="#filtersAccordion"
					href="#collapse-year" aria-expanded="true"
					aria-controls="collapse-year"> Year</a>
				</strong>
			</div>
			<div id="collapse-year" class="panel-collapse collapse"
				role="tabpanel">
				<div class="panel-body">
					<?=$form->field($model, 'year_model')->checkboxList(['2017'=>'2017','2016'=>'2016','2015'=>'2015','2014'=>'2014'],['tag'=>'ul','class'=>"list-unstyled",'item'=>function($index,$label,$name,$checked,$value) {
						if ($checked == 1)
							$checked = 'checked';
						return '<li class="checkbox"><label><input name='.$name.' value='.$value.' type="checkbox" '.$checked.'>'.$label.'</label></li>';
					}])->label(false)?>
				</div>
			</div>
		</div>
	</div>
<?php ActiveForm::end(); ?>

<script>
jQuery('#car-search-form').change(function () {jQuery(this).submit()});
initRangeSlider('priceRangeSlider');
initRangeSlider('milageRangeSlider');
</script>