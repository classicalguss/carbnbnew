<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\UserAsset;
use yii\helpers\Url;
use frontend\assets\AppAsset;

$this->title = 'Signup';
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
					<li>Already have an account?</li>
					<li><a class="white" href="<?=Url::to(['user/login'])?>">Sign in</a></li>
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
					<h5>List Your Car</h5>
					<p>With just just a few steps you can list your car and start
						earning tomorrow</p>
				</div>
			</div>
		</div>
		<div class="col-sm-8">
			<div class="sign-forms">
				<h6>Start using uchaise</h6>
				<p>Enter your details below</p>
				<?php $form = ActiveForm::begin(['id' => 'form-signup','class'=>'form']); ?>
					<div class="row">
						<?= $form->field($model, 'first_name',['options'=>['class'=>'col-xs-6 col-md-6']])->textInput(['placeHolder'=>'First Name','class'=>'form-control input-lg'])->label(false)->error(['tag'=>'span']) ?>
						<?= $form->field($model, 'last_name',['options'=>['class'=>'col-xs-6 col-md-6']])->textInput(['placeHolder'=>'Last Name','class'=>'form-control input-lg'])->label(false)->error(['tag'=>'span'])?>
					</div>
					<?= $form->field($model, 'email')->textInput(['placeHolder'=>'Email Address','class'=>'form-control input-lg'])->label(false)->error(['tag'=>'span'])?>
					<?= $form->field($model, 'password')->passwordInput(['placeHolder'=>'Create Password','class'=>'form-control input-lg'])->label(false)->error(['tag'=>'span'])?>

					<div class="form-group">
						<?= Html::submitButton('Signup', ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'signup-button']) ?>
					</div>
				<?php ActiveForm::end(); ?>
				<div class="separator-sign-in">Or</div>
				<a target="_blank" href="/web/user/auth?authclient=facebook" title="Facebook" data-popup-width="860" data-popup-height="480" class="facebook auth-link btn btn-block btn-lg btn-facebook"> <i class="fa fa-facebook"></i> Connect with Facebook </a>
			</div>
		</div>
	</div>
</div>