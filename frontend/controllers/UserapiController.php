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
use common\models\User;
use yii\filters\ContentNegotiator;
use yii\web\Response;

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
		return User::findByUsername ( 'classicalguss' );
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
					return $this->goHome ();
				}
			}
		}
		
		return $model;
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
}
