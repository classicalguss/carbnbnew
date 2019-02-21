<?php
use yii\helpers\Html;
use frontend\models\Car;
use yii\helpers\Url;
use common\models\User;

/* @var $this yii\web\View */
/* @var $car Car */
/* @var $owner User */
/* @var $renter User */

$bookingUrl = Url::to ( [
		'car/my-drives'
], true );
?>
<div>
	<p>Hello <?=$renter->first_name ?>, your request for booking has been confirmed.</p>

	<?php if ($car->book_instantly):?>
    	<p>The car owner <?=$owner->first_name?> will soon contact you for the delivery of the car.</p>
    <?php else:?>
    	<p>The car owner <?=$renter->first_name?> still needs to approve your request.</p>
    <?php endif;?>

    <p><?= Html::a(Html::encode($bookingUrl), $bookingUrl) ?></p>
</div>
