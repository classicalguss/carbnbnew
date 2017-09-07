<?php 
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\helpers\Url;
?>
<div class="main-search-bar">
	<form class="" action="<?=Url::to(['search/index'])?>" method="get">
		<div class="clearfix row-small-gutter">
			<div class="col col-md-5">
				<div class="form-group border-right">
					<label for="search-where">Where</label>
					<?php 
						echo AutoComplete::widget([
								'name' => 'CarSearch[area]',
								'value'=>$area,
								'options'=> [
									'class'=>'form-control',
									'placeHolder'=>'Choose Destination',
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
						]);
					?>
				</div>
			</div>
			<div class="col col-md-5">
				<div class="form-group">
					<label for="search-when">When</label> <input type="text"
						class="form-control" id="search-when" name="daterange"
						placeholder="Pick date">
				</div>
			</div>
			<div class="col col-md-2">
				<button type="submit" name="button"
					class="btn btn-search btn-primary btn-lg btn-block">Search</button>
			</div>
		</div>
		<input value="<?=$area_id?>" name="CarSearch[area_id]" type="hidden" id="js_autocomplete-area-id" />
	</form>
</div>
<script>
initRangeDatepicker('<?=$startDate?>','<?=$endDate?>');
</script>