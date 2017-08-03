<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use frontend\assets\LandingAsset;
use frontend\assets\AppAsset;
LandingAsset::register ( $this );
//AppAsset::register ( $this );
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() 

?>
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
			
			<button onclick="submitForm(this);return false;" class="registration-submit" type="submit">
				<span>Keep me Updated</span>
				<img class="hide loading-icon" src="https://www.createwebsite.net/wp-content/uploads/2015/09/GD.gif" />
			</button>
		</form>
		<div class="registration">
			<p></p>
		</div>
		<div class="copyright-text">
			<p>Copyright © 2017 UChaise. All rights Reserved</p>
		</div>
	</div>
	<div class="instructions" >
		<img src="instructions2.png" />
	</div>
	<div class="instructions" >
		<img src="instructions1.png" />
	</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage()?>