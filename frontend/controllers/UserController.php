<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use common\models\User;
use Codeception\Module\Yii2;
use common\models\Util;
/**
 * Site controller
 */
class UserController extends Controller {
	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
				'access' => [
						'class' => AccessControl::className (),
						'only' => [
								'logout',
								'signup'
						],
						'rules' => [
								[
										'actions' => [
												'signup'
										],
										'allow' => true,
										'roles' => [
												'?'
										]
								],
								[
										'actions' => [
												'logout'
										],
										'allow' => true,
										'roles' => [
												'@'
										]
								]
						]
				],
				'verbs' => [
						'class' => VerbFilter::className (),
						'actions' => [
								'logout' => [
										'post'
								]
						]
				]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function actions() {
		return [
				'error' => [
						'class' => 'yii\web\ErrorAction'
				],
				'auth' => [
						'class' => 'yii\authclient\AuthAction',
						'successCallback' => [$this, 'oAuthSuccess'],
				],
		];
	}

	/**
	 * Logs in a user.
	 *
	 * @return mixed
	 */
	public function actionLogin() {
		if (! Yii::$app->user->isGuest) {
			return $this->goHome ();
		}

		$model = new LoginForm ();
		if ($model->load ( Yii::$app->request->post () ) && $model->login ()) {
			return $this->goBack ();
		} else {
			$this->layout = 'signup-nav';
			return $this->render ( 'login', [
					'model' => $model
			] );
		}
	}

	/**
	 * Logs out the current user.
	 *
	 * @return mixed
	 */
	public function actionLogout() {
		Yii::$app->user->logout ();

		return $this->goHome ();
	}

	/**
	 * Signs user up.
	 *
	 * @return mixed
	 */
	public function actionSignup() {
		$model = new SignupForm ();
		if ($model->load ( Yii::$app->request->post () )) {
			if ($user = $model->signup ()) {
				if (Yii::$app->getUser ()->login ( $user )) {
				    if (Yii::$app->request->getQueryParam('redirectUrl'))
				        return $this->redirect(Yii::$app->urlManager->createUrl([Yii::$app->request->getQueryParam('redirectUrl')]));
				    else
                        return $this->goHome ();
				}
			}
		}

		$this->layout = 'signup-nav';
		return $this->render ( 'signup', [
				'model' => $model
		] );
	}

	/**
	 * Requests password reset.
	 *
	 * @return mixed
	 */
	public function actionRequestPasswordReset() {
		$model = new PasswordResetRequestForm ();
		if ($model->load ( Yii::$app->request->post () ) && $model->validate ()) {
			if ($model->sendEmail ()) {
				Yii::$app->session->setFlash ( 'success', 'Check your email for further instructions.' );

				return $this->goHome ();
			} else {
				Yii::$app->session->setFlash ( 'error', 'Sorry, we are unable to reset password for the provided email address.' );
			}
		}

		return $this->render ( 'requestPasswordResetToken', [
				'model' => $model
		] );
	}

	/**
	 * Resets password.
	 *
	 * @param string $token
	 * @return mixed
	 * @throws BadRequestHttpException
	 */
	public function actionResetPassword($token) {
		try {
			$model = new ResetPasswordForm ( $token );
		} catch ( InvalidParamException $e ) {
			throw new BadRequestHttpException ( $e->getMessage () );
		}

		if ($model->load ( Yii::$app->request->post () ) && $model->validate () && $model->resetPassword ()) {
			Yii::$app->session->setFlash ( 'success', 'New password saved.' );

			return $this->goHome ();
		}

		return $this->render ( 'resetPassword', [
				'model' => $model
		] );
	}

	public static function getUserPhoto()
	{
		if (Yii::$app->user->isGuest)
			return '';

		$userPhoto  = Yii::$app->user->identity->photo;
		if (!empty($userPhoto))
			return Yii::$app->params['imagesFolder'].$userPhoto;
		else
			return Yii::$app->params['siteImagesPath'].'/user-no-photo.png';
	}
	
	/**
	 * This function will be triggered when user is successfuly authenticated using some oAuth client.
	 *
	 * @param yii\authclient\ClientInterface $client
	 * @return boolean|yii\web\Response
	 */
	public function oAuthSuccess($client) {
		// get user data from client
		$userAttributes = $client->getUserAttributes();
		Yii::warning($userAttributes);
		$user = User::find()->where(['registration_token'=>$userAttributes['id']])->one();
		if (!$user)
		{
			$user = new User ();
			$photoUrl = $userAttributes['picture']['data']['url'];
			
			$image = file_get_contents($photoUrl);
			Yii::warning($image);
			$user->setPassword ('facebookPass');
			$user->generateAuthKey ();
			$user->email = $userAttributes['id'].'@facebook.com';
			$user->first_name = $userAttributes['first_name'];
			$user->last_name = $userAttributes['last_name'];
			$user->registration_type = 1;
			$user->registration_token = $userAttributes['id'];
			$user->user_type = 1;
			Yii::warning('>>>'.$photoUrl);
			$photoName = $userAttributes['id'].'_'.Util::generateRandomString().'.'.pathinfo(parse_url($photoUrl)['path'])['extension'];
			Yii::warning($photoName);
			file_put_contents('../../uploads/'.$photoName, $image);
			$user->photo = $photoName;
			$user->save();
			
			Yii::warning($user->errors);
		}
		Yii::$app->getUser ()->login ( $user );

	}
}
