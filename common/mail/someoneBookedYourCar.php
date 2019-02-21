<?php
use yii\helpers\Html;
use frontend\models\Car;
use yii\helpers\Url;
use common\models\User;

/* @var $this yii\web\View */
/* @var $car Car */
/* @var $owner User */
/* @var $renter User */

if ($car->book_instantly) {
	$bookingUrl = Url::to ( [
			'car/approved-requests'
	], true );
} else {
	$bookingUrl = Url::to ( [
			'car/my-approvals'
	], true );
}
?>
<div>
	<p>Hello <?=$owner->first_name ?>,</p>

	<?php if ($car->book_instantly):?>
    	<p><?=$renter->first_name?> has booked your car. It should be delivered it to him/her soon.</p>
    <?php else:?>
    	<p><?=$renter->first_name?> has requested your car. Kindly open the link below in order to approve or decline this rent request.</p>
    <?php endif;?>

    <p><?= Html::a(Html::encode($bookingUrl), $bookingUrl) ?></p>
	<p>You can call <?=$renter->first_name?> on <?=$renter->phonenumber?>
</div>
