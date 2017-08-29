<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\web\View;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model frontend\models\Car */

$this->title = 'Create Car';
?>
<pre>
<?=print_r(Yii::$app->request->post(),1)?>
</pre>
<div class="car-create">

	<h1><?= Html::encode($this->title) ?></h1>

	<?php echo Tabs::widget([
		'items' => [
			[
				'label' => 'Car Details',
				'content' => $this->render('carDetailsFormView', ['model' => $models['carDetailsModel'], 'formNum' => 1]),
				'active' => true,
				'linkOptions' => ['id' => 'tab1'],
			],
			[
				'label' => 'Car Features',
				'content' => $this->render('carFeaturesFormView', ['model' => $models['carFeaturesModel'], 'formNum' => 2]),
				'linkOptions' => ['id' => 'tab2'],
			],
			[
				'label' => 'Photos',
				'content' => $this->render('carPhotosFormView', ['model' => $models['carPhotosModel'], 'formNum' => 3]),
				'linkOptions' => ['id' => 'tab3'],
			],
			[
				'label' => 'Publish',
				'content' => $this->render('carPublishFormView', ['model' => $models['carPublishModel'], 'formNum' => 4]),
				'linkOptions' => ['id' => 'tab4'],
			],
		],
	]);?>

</div>

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
		console.log(errorsCount);
		if (errorsCount == 0 )
		{
			$('#tab'+nextForm).click(); // click on next tab
			$('#'+formNum).parent().addClass('active'); // add class "active" on current tab
		}
		return false;
	}

	function submitCar()
	{
		var data = $('#w0,#w1,#w3').serializeArray();
		console.log(data);

// 		var form = document.createElement("form");
// 		form.method = "POST";
		//form.action = "<?=Url::to(['car/list-a-car'])?>";

		for(var cc=0;cc<data.length;cc++)
		{
			var inpData = data[cc];
			$('<input>').attr({
				type: 'hidden',
				name:  inpData.name,
				value: inpData.value,
			}).appendTo('#w2');
// 			var element1   = document.createElement("input");
// 			element1.name  = inpData.name;
// 			element1.value = inpData.value;
// 			form.append(element1);
		}

// 		document.body.appendChild(form);

		$('#w2').submit();
// 		$.ajax({
// 			type: "POST",
//			url: "<?=Url::to(['car/list-a-car'])?>",
// 			data: data,
// 			dataType: "html",
// 			success: function(data) {
// 				alert(data);
// 			},
// 			error: function() {
// 				alert('error handing here');
// 			}
// 		});
		return false;
	}
</script>