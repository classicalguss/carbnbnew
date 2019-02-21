<?php
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use frontend\assets\JqueryUIAsset;
use frontend\assets\CarAsset;
use frontend\models\ReserveConfirmationForm;
CarAsset::register ( $this );
JqueryUIAsset::register($this);

$this->title = 'Create Car';
/* @var $reserveConfirmationForm frontend\models\ReserveConfirmationForm */
?>
<h2 class="listing-title">
	<?= Html::encode('Hi, '.Yii::$app->user->identity->first_name.'! You are about to rent a '.$carInfo ['makeName'].' '.$carInfo ['modelName'].'.')?>
</h2>
<div class="col-md-8 border-right">
	<div class="alert alert-warning listing-form">
		<i class="icon fa fa-exclamation-triangle"></i> <span> <strong>Please
				make sure your information is filled correctly before confirming.</strong>
		</span>
	</div>
	<?php $form = ActiveForm::begin(); ?>
		<div class="row-small-gutter clearfix">
			<div class="col col-xs-6">
				<?= $form->field($reserveConfirmationForm, 'first_name')->textInput(['value'=>Yii::$app->user->identity->first_name,'placeholder'=>'First Name']) ?>
			</div>
			<div class="col col-xs-6">
				<?= $form->field($reserveConfirmationForm, 'last_name')->textInput(['value'=>Yii::$app->user->identity->last_name,'placeholder'=>'Last Name']) ?>
			</div>
		</div>
		<div class="row-small-gutter clearfix">
			<div class="col col-xs-6">
				<?= $form->field($reserveConfirmationForm, 'email')->textInput(['value'=>Yii::$app->user->identity->email,'placeholder'=>'Email']) ?>
			</div>
			<div class="col col-xs-6">
				<?php if(!empty(Yii::$app->user->identity->phonenumber)):?>
					<?= $form->field($reserveConfirmationForm, 'phonenumber')->textInput(['value'=>Yii::$app->user->identity->phonenumber,'placeholder'=>'Ex: 0557154755']) ?>
				<?php else:?>
					<?= $form->field($reserveConfirmationForm, 'phonenumber')->textInput(['placeholder'=>'Ex: 0557154755']) ?>
				<?php endif;?>
			</div>
		</div>
		<?= $form->field($reserveConfirmationForm,'area')->widget(AutoComplete::className(),[
			'model'=> $reserveConfirmationForm,
			'attribute' => 'area',
			'options'=> [
				'placeHolder'=>'Please enter your city',
				'class'=>'form-control'
			],
			'clientOptions' => [
					'source' => new JsExpression(" function (request, response) {
								jQuery.get('".Yii::$app->params['apiDomain']."/web/v1/lists/areaautocomplete', {
									q: request.term
								}, function (data) {
									responseData = [];
									data.data.forEach(function(element) {
										responseData.push({
											value:element.city_name + ' - ' +element.area_name,
											label: element.city_name + ' - ' +element.area_name,
											id:element.area_id });
									});
									response(responseData);
								});
					}"),
					'select'=> new JsExpression("function( event, ui ) {
								$('#js_autocomplete-area-id').val(ui.item.id);
					}"),
					'minLength'=>2
			],
		])->label('City')?>

		<?= $form->field($reserveConfirmationForm, 'area_id',['template'=>'{input}'])->hiddenInput(['id'=>'js_autocomplete-area-id'])?>
		<div class="form-group">
			<?= Html::submitButton('Confirm', ['class' => 'btn btn-primary btn-lg btn-block']) ?>
		</div>
	<?php ActiveForm::end(); ?>
</div>
<div class="col-md-4">
	<div class="checkout-section">
		<div class="img-wrap">
			<img width="291px" height="183px" class="carved" src="<?=$carInfo['photo']?>">
			<p><strong><?=$carInfo ['makeName']?> <?=$carInfo ['modelName']?> <?=$carInfo ['year_model']?></strong></p>
		</div>
	</div>
	<div class="checkout-section">
		<div class="checkout-section-column left">
			<p><strong>Price per day:</strong></p>
			<p><strong>Renting for:</strong></p>
		</div>

		<div class="checkout-section-column right">
			<p>$<?=$carInfo['price']?></p>
			<p><?=$reservationDays?> days</p>
		</div>
	</div>
	<div class="checkout-section last">
		<div class="checkout-section-column left">
			<p><strong>Total Price:</strong></p>
		</div>

		<div class="checkout-section-column right">
			<p class="big-font">$<?=($carInfo['price'] * $reservationDays)?></p>
		</div>
	</div>
</div>