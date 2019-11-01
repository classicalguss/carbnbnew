<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Car */

use frontend\widgets\ETabs;
use frontend\assets\JqueryUIAsset;
use frontend\assets\CarAsset;
JqueryUIAsset::register($this);
CarAsset::register($this);

$this->title = 'Create Car';
?>
<?php echo ETabs::widget([
	'items' => [
		[
			'label' => 'Car Details',
			'content' => $this->render('carDetailsFormView', ['model' => $models['carDetailsModel'], 'formNum' => 1]),
			'linkOptions' => ['id' => 'tab1'],
			'active'=>true
		],
		[
			'label' => 'Car Features',
			'content' => $this->render('carFeaturesFormView', ['model' => $models['carFeaturesModel'], 'formNum' => 2]),
			'linkOptions' => ['id' => 'tab2'],
			'options'=>['class'=>'disabled'],
		],
		[
			'label' => 'Photos',
			'content' => $this->render('carPhotosFormView', ['model' => $models['carPhotosModel'], 'formNum' => 3]),
			'linkOptions' => ['id' => 'tab3'],
			'options'=>['class'=>'disabled'],


		],
		[
			'label' => 'Publish',
			'content' => $this->render('carPublishFormView', ['model' => $models['carPublishModel'], 'formNum' => 4]),
			'linkOptions' => ['id' => 'tab4'],
			'options'=>['class'=>'disabled'],
		],
	],
	'navType'=>'nav nav-tabs nav-uchaise',
	'headerOptions'=>[
		'role'=>'presentation',
		'class'=>'disabled',
	],
]);?>


<script>
	$( document ).ready(function() {
		$( "#makeId-dd" ).on('change', function() {
			$.ajax({
				url : '<?=Yii::$app->getUrlManager()->createUrl('car/get-car-make-models')?>',
				type : 'get',
				data : {id: this.value},
				dataType: 'html',
				success : function(data) {
					$('#modelId-dd').html(data);
				},
				error : function() {
					alert('error!');
				}
			});
		});

		$("#w3").on('beforeSubmit.yii', function(e) {
			submitCar();
			return false;
		});
	});
	function switchForm(formNum, formObj)
	{
		if(formObj == -1)
			var form = $('#w2');
		else
			var form = $(formObj);

		var nextForm = parseInt(formNum)+1;
		var data = form.data("yiiActiveForm");
		$.each(data.attributes, function() {
			this.status = 3;
		});
		form.yiiActiveForm("validate");

		var errorsCount = form.find(".has-error").length;
		if (errorsCount == 0 )
		{
			$('#tab'+nextForm).click(); // click on next tab
			for(var cc=1; cc <= formNum; cc++)
				$('#tab'+cc).parent().addClass('active'); // add class "active" on current tab
		}
		return false;
	}

	function submitCar()
	{
		var data = $('#w0,#w1,#w3').serializeArray();

		for(var cc=0;cc<data.length;cc++)
		{
			var inpData = data[cc];
			$('<input>').attr({
				type: 'hidden',
				name:  inpData.name,
				value: inpData.value,
			}).appendTo('#w2');
		}

		$('#w2').submit();
		return false;
	}
</script>