<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\Car */

$this->title = 'Car Reserved Successfully';
?>
<div class="publishded-alert text-center">
	<?php if(empty($message)):?>
    	<i class="icon fa fa-check-circle fa-5x"></i>
    	<h1>Thank You! <?=Yii::$app->user->identity->first_name?></h1>
    	<p>Booking Successful!</p>
    <?php else:?>
    	<i class="icon fa fa-times-circle fa-5x"></i>
    	<h1>Sorry <?=Yii::$app->user->identity->first_name?></h1>
    	<p><?=$message?></p>
    <?php endif;?>

	<a href="<?=Url::to(['car/my-drives'])?>" class="btn btn-primary btn-lg">See Reservations</a>
</div>