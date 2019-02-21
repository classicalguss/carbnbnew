<?php
use frontend\models\Car;
use common\models\User;
/* @var $this yii\web\View */
/* @var $car Car */
/* @var $owner User */
/* @var $renter User */

?>
<h2>Details of Booking:</h2>
<h3>Owner Details</h3>
<p>Name: <?=$owner->first_name?> <?=$owner->last_name?></p>
<p>Id: <?=$owner->id?></p>
<p>Car: <?=$carInfo['makeName']?> <?=$carInfo['modelName']?> <?=$car->year_model?></p>
<h3>Renter Details</h3>
<p>Name: <?=$renter->first_name?> <?=$renter->last_name?></p>
<p>Id: <?=$renter->id?></p>
<p>Phone: <?=$renter->phonenumber?>