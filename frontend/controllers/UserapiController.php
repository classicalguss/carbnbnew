<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use common\models\LoginForm;
use common\models\User;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use linslin\yii2\curl\Curl;

/**
 * Site controller
 */
class UserapiController extends \yii\rest\Controller {
	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		$behaviors = parent::behaviors();
		$behaviors['verbs'] = [
				'class' => VerbFilter::className (),
				'actions' => [
						'logout' => [
								'post'
						]
				]
		];
		$behaviors['access'] = [
				'class' => AccessControl::className (),
				'only' => [
						'logout',
						'signup',
						'update',
						'facebooklogin'
				],
				'rules' => [
						[
								'actions' => [
										'signup','facebooklogin'
								],
								'allow' => true,
								'roles' => [
										'?'
								]
						],
						[
								'actions' => [
										'logout','update'
								],
								'allow' => true,
								'roles' => [
										'@'
								]
						]
				]
		];
		$behaviors['contentNegotiator'] = [
				'class' => ContentNegotiator::className(),
				'formats' => [
						'application/json' => Response::FORMAT_JSON,
				],
		];
		return $behaviors;
	}
	
	/**
	 * @inheritdoc
	 */
	public function actions() {
		return [
				'error' => [
						'class' => 'yii\web\ErrorAction'
				]
		];
	}
	
	/**
	 * Logs in a user.
	 *
	 * @return mixed
	 */
	public function actionLogin() {
		if (! Yii::$app->user->isGuest) {
			return array('Already logged in');
		}
		
		$model = new LoginForm ();
		if ($model->load ( Yii::$app->request->post () ) && $model->login ()) {
			return $model;
		} else {
			return $model;
		}
	}
	
	/**
	 * Logs out the current user.
	 *
	 * @return mixed
	 */
	public function actionLogout() {
		Yii::$app->user->logout ();
	}
	
	/**
	 * Shows info of user.
	 *
	 * @return User
	 */
	public function actionView($id) {
		$model = User::findIdentity($id);
		if ($id == Yii::$app->user->id)
			return $model;
		else 
			return ['first_name'=>$model->first_name,'last_name'=>$model->last_name,'phonenumber'=>$model->phonenumber,'gender'=>$model->gender,'User Type'=>$model->user_type];
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
					return $user;
				}
			}
		}
		
		return $model;
	}
	
	public function actionUpdate() {
		$model = User::findIdentity(Yii::$app->user->id);
		$model->setAttributes(Yii::$app->request->post());
		$model->save();
		return $model;
	}
	
	public function actionFacebooklogin() {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,'https://graph.facebook.com/me');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'fields=id&access_token='.Yii::$app->request->post('facebook_token'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  //to suppress the curl output
		$result = curl_exec($ch);
		curl_close ($ch);
		
		$result = json_decode($result,true);
		if (isset($result['error']))
		{
			Yii::$app->response->setStatusCode(422, 'Data Validation Failed.');
			return $result;
		}
		else if (!isset($result['id']))
		{
			Yii::$app->response->setStatusCode(422, 'Unknown error');
			return $result;
		}
		
		$user = User::findOne(['registration_token'=>$result['id']]);
		if (empty($user))
		{
			$model = new User();
			$model->setScenario('facebookLogin');
			$model->setAttributes(Yii::$app->request->post());
			$model->setPassword ('facebookPass');
			$model->generateAuthKey ();
			$model->email = $result['id'].'@facebook.com';
			$model->registration_type = 1;
			$model->registration_token = $result['id'];
			$model->save();
			if ($model->errors)
			{
				Yii::$app->response->setStatusCode(422, 'Data Validation Failed.');
				return $model->errors;
			}
			Yii::$app->getUser()->login ($model);
			return ['status'=>'User Registered','user'=>$model];
		}
		else
		{
			Yii::$app->getUser()->login ($user);
			return ['status'=>'User Logged in','user'=>$user];
		}
	}
	
	public function actionMakerenter() {
		$model = User::findIdentity(Yii::$app->user->id);
		if (empty($model->phonenumber))
		{
			Yii::$app->response->setStatusCode(422, 'Data Validation Failed.');
			return ['field'=>'phone','message'=>'You need to have a phone number before becoming a car renter'];
		}
		$model->user_type = 2;
		$model->save();
		return ['Success'];
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
				Yii::$app->response->setStatusCode(422, 'Data Validation Failed.');
				return ['status'=>'success', 'msg'=>'Check your email for further instructions.'];
			} else {
				return ['status'=>'error', 'msg'=>'Sorry, we are unable to reset password for the provided email address.'];
			}
		}
		return $model;
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
	
	public function actionTestfirstname()
	{
		$form = new ContactForm();
		Yii::$app->mailer->compose('contact/html', ['contactForm' => $form])
		->setFrom('from@domain.com')
		->setTo($form->email)
		->setSubject($form->subject)
		->send();
	}
}
