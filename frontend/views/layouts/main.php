<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;

AppAsset::register($this);

// Assets file Name based on controller ID
$assetsFileName = Yii::app()->controller->id;

// Register CSS files per controller
$this->registerCssFile("@web/dist/css/{$assetsFileName}.css", ['media' => 'screen'], $assetsFileName);

// To register javascript files per controller if needed.
// $this->registerJsFile("@web/dist/js/{$assetsFileName}.js",['position' => \yii\web\View::POS_END], $assetsFileName);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?= Html::csrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?></title>
	<!-- Load External font file -->
	<link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,900,900i" rel="stylesheet">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
	<div class="main-nav">
		<div class="container wide">
			<div class="row">
				<div class="col-md-4">
					<a href="<?=Url::to(['site/index'])?>" title="Uchaise">
						<img width="88" height="20" src="<?=Yii::$app->params ['siteImagesPath']?>/logo.svg" alt="Uchaise" />
					</a>
				</div>
				<div class="col-md-8 text-right">
					<ul class="list-inline list-links">
						<li><a href="<?=Url::to(['car/list-a-car'])?>">List Your Car</a></li>
						<li><a href="<?=Url::to(['car/my-drives'])?>">My Drives</a></li>
						<li><a href="<?=Url::to([''])?>">Messages</a></li>
						<?php if (Yii::$app->user->isGuest):?>
							<li><a href="<?=Url::to(['user/login'])?>">Sign In</a></li>
							<li><a href="<?=Url::to(['user/signup'])?>" class="btn btn-primary">Sign Up</a></li>
						<?php else :?>
							<li>
								<?=Html::beginForm ([
										'/user/logout'
								], 'post' ) . Html::submitButton ( '<img src="'.frontend\controllers\UserController::getUserPhoto().'" class="img-circle" alt="'.Yii::$app->user->identity->first_name.'" width="45" height="45">', [
										'class' => 'btn btn-link logout'
								] ).Html::endForm ()?>
							</li>
						<?php endif;?>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="<?php if (!in_array(Yii::$app->requestedRoute, ['site/index'])):?>container <?php endif;?>">
		<!-- <?=Breadcrumbs::widget ( [ 'links' => isset ( $this->params ['breadcrumbs'] ) ? $this->params ['breadcrumbs'] : [ ] ] )?> -->
		<?= Alert::widget() ?>
		<?= $content ?>
	</div>
</div>

<div class="container">
	<footer class="main-footer">
		<div class="row">
			<div class="col-sm-6">
				<h4>About Uchaise</h4>
				<p>Put your car to work with just a few clicks. upload your registration along with quality photos and your car is ready to go!</p>
				<ul class="list-inline social-media-links">
					<li><a href="#"><i class="fa fa-facebook"></i></a></li>
					<li><a href="#"><i class="fa fa-twitter"></i></a></li>
					<li><a href="#"><i class="fa fa-instagram"></i></a></li>
				</ul>
				<p class="copy-right">Copyright &copy; 2017 UChaise. All rights Reserved</p>
			</div>

			<div class="col-sm-3">
				<h4>Learn more</h4>
				<ul class="list-unstyled">
					<li><a href="#">How Uchaise works Policies</a></li>
					<li><a href="#">Trust &amp; safety</a></li>
					<li><a href="#">About Us</a></li>
					<li><a href="#">Contact Us</a></li>
					<li><a href="#">Careers</a></li>
					<li><a href="#">Press Corner</a></li>
				</ul>
			</div>

			<div class="col-sm-3">
				<h4>Get Started</h4>
				<ul class="list-unstyled">
					<li><a href="#">Rent a car</a></li>
					<li><a href="#">Make money with your car</a></li>
					<li class="download-app"><a href="#"><img src="<?=Yii::$app->params ['siteImagesPath']?>/download-app-store.png" alt="Download on the app store"></a></li>
					<li><a href="#"><img src="<?=Yii::$app->params ['siteImagesPath']?>/google-play.png" alt="Get it on google play"></a></li>
				</ul>
			</div>
		</div>
	</footer>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
