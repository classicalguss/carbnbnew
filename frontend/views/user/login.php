<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\UserAsset;
use frontend\assets\AppAsset;
use yii\helpers\Url;
use yii\authclient\widgets\AuthChoice;
use yii\base\Widget;

$this->title = 'Login';
$this->params ['breadcrumbs'] [] = $this->title;
UserAsset::register ( $this );
AppAsset::register ( $this );
?>
<div class="main-nav sign-nav">
	<div class="container wide">
		<div class="row">
			<div class="col-md-4">
				<a href="<?=Url::to(['site/index'])?>" title="Home page"> <img
					width="88" height="20"
					src="<?=Yii::$app->params ['siteImagesPath']?>/logo-white.svg"
					alt="Uchaise">
				</a>
			</div>
			<div class="col-md-8 text-right">
				<ul class="list-inline list-links">
					<li>Not a member yet?</li>
					<li><a class="white" href="<?=Url::to(['user/signup'])?>">Sign up</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="sign-up-in">
	<div class="row">
		<div class="col-sm-4 hidden-xs">
			<div class="car-bg">
				<div class="sign-content">
					<img src="<?=Yii::$app->params ['siteImagesPath']?>/car-icon.png"
						alt="Car icon">
					<h5>Rent a Car Easily</h5>
					<p>Search our vast selection of unique, locally owned cars within
						your area</p>
				</div>
			</div>
		</div>
		<div class="col-sm-8">
			<div class="sign-forms">
				<h6>Sign in to uchaise</h6>
				<p>Enter your details below</p>
				<?php $form = ActiveForm::begin(['id' => 'form-signup','class'=>'form']); ?>
					<?= $form->field($model, 'email')->textInput(['placeHolder'=>'Email Address','class'=>'form-control input-lg'])->label(false)->error(['tag'=>'span'])?>
					<?= $form->field($model, 'password')->passwordInput(['placeHolder'=>'Create Password','class'=>'form-control input-lg'])->label(false)->error(['tag'=>'span'])?>
					<?= Html::a('Forgot password?', ['user/request-password-reset'],['class'=>'forget-password']) ?>
					<div class="form-group">
						<?= Html::submitButton('Login', ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'login-button']) ?>
					</div>
				<?php ActiveForm::end(); ?>
				<div class="separator-sign-in">Or</div>
				<a target="_blank" href="/web/user/auth?authclient=facebook" title="Facebook" data-popup-width="860" data-popup-height="480" class="facebook auth-link btn btn-block btn-lg btn-facebook"> <i class="fa fa-facebook"></i> Connect with Facebook </a>
			</div>
		</div>
	</div>
</div>
<div style="color: #999; margin: 1em 0">
	If you forgot your password you can <?= Html::a('reset it', ['user/request-password-reset']) ?>.
</div>