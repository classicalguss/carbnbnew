<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use frontend\assets\LandingAsset;
use frontend\assets\AppAsset;

// LandingAsset::register ( $this );
AppAsset::register ( $this );
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
	<div class="Rectangle-5">
		<img class="logo" width=90px height="20px" src="logo.png" />
		<div class="main-header">
			<p>You Chaise.</p>
			<p>You Choose.</p>
		</div>
		<div class="site-description">
			<p>Browse our huge car market place to find the car you want to book, Find a car you fancy?</p>
		</div>
		<form class="registration-form">
			<input class="registration-input" placeholder="Your Email" type="text" />
			<button class="registration-submit" type="submit">Keep me Updated!</button>
		</form>
		<div class="registration">
			<p></p>
		</div>

	</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage()?>