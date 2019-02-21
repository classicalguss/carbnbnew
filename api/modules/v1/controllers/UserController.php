<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use Yii;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;
use yii\base\InvalidParamException;
use yii\filters\auth\HttpBearerAuth;
use api\modules\v1\models\User;
use yii\web\UploadedFile;
use api\modules\v1\models\PasswordResetRequestForm;
use api\modules\v1\models\ResetPasswordForm;
use common\models\Util;

/**
 * Country Controller API
 *
 * @author Budi Irawan <deerawan@gmail.com>
 */
class UserController extends ActiveController {
	public $modelClass = 'api\modules\v1\models\User';
	public $show_credentials = false;

	protected function verbs()
	{
		return [
				'index' => ['GET', 'HEAD'],
				'view' => ['GET', 'HEAD'],
				'create' => ['POST'],
				'update' => ['POST'],
		];
	}

	public function actions() {
		$actions = parent::actions ();
		unset ( $actions ['delete'], $actions ['create'], $actions['update']);
		return $actions;
	}
	public function behaviors() {
		$behaviors = parent::behaviors ();
		$behaviors ['authenticator'] = [
				'class' => HttpBearerAuth::className(),
				'only'=>['update','logout']
		];
		return $behaviors;
	}
	public function checkAccess($action, $model = null, $params = [])
	{
		if ($action === 'update' || $action === 'logout') {
			if ($model->author_id !== \Yii::$app->user->id)
				throw new \yii\web\ForbiddenHttpException(sprintf('You can only %s articles that you\'ve created.', $action));
		}
	}
	public function actionUpdate($id) {
		$model = User::findIdentity($id);
		if ($model->id !== Yii::$app->user->id)
			throw new \yii\web\ForbiddenHttpException('You can only update your own user');

		$model->setAttributes(Yii::$app->request->post());
		$model->photoFile = UploadedFile::getInstanceByName ('photoFile');
		$model->licenseImage = UploadedFile::getInstanceByName ('licenseImage');
		if (!empty($model->photoFile))
			$model->photo = Util::generateRandomString(). '_' . $model->photoFile->name;
		if (!empty($model->licenseImage))
			$model->license_image_file = Util::generateRandomString(). '_' . $model->licenseImage->name;

		$model->save ();
		$model->upload();
		if (empty($model->errors))
			$model = $model->findIdentity($id);

		return $model;
	}
	public function actionCreate() {
		$model = new $this->modelClass ( [
				'scenario' => 'signup'
		] );
		$model->load ( Yii::$app->getRequest ()->getBodyParams (), '' );
		$model->photoFile = UploadedFile::getInstanceByName ('photoFile');
		$model->licenseImage = UploadedFile::getInstanceByName ('licenseImage');
		if ($model->validate ()) {
			$model->setPassword ( $model->password );
			$model->generateAuthKey ();
			$model->user_type = 1;
			if (!empty($model->photoFile))
				$model->photo = Util::generateRandomString(). '_' . $model->photoFile->name;
			if (!empty($model->licenseImage))
				$model->license_image_file = Util::generateRandomString(). '_' . $model->licenseImage->name;

			if ($model->save ()) {
				$model->upload();
				$response = Yii::$app->getResponse ();
				$response->setStatusCode ( 201 );
				$id = implode ( ',', array_values ( $model->getPrimaryKey ( true ) ) );
				$this->show_credentials = true;
				$response->getHeaders ()->set ( 'Location', Url::toRoute ( [
						'view',
						'id' => $id
				], true ) );
				return [
						'id'=>$model->id,
						'first_name'=>$model->first_name,
						'last_name'=>$model->last_name,
						'email'=>$model->email,
						'user_type'=>$model->user_type,
						'access_key'=>$model->access_key,
						'photo'=>Yii::$app->params ['imagesFolder'].$model->photo,
						'license_image_file'=>Yii::$app->params ['imagesFolder'].$model->license_image_file,
						'location'=>$model->location,
						'about_me'=>$model->about_me
				];
			} elseif (! $model->hasErrors ()) {
				throw new ServerErrorHttpException ( 'Failed to create the object for unknown reason.' );
			}
		}

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
		$response = Yii::$app->getResponse ();
		if (empty($user))
		{
			$user= new User();
			$user->setScenario('facebookLogin');
			$user->setAttributes(Yii::$app->request->post());
			$user->setPassword ('facebookPass');
			$user->generateAuthKey ();
			$user->email = $result['id'].'@facebook.com';
			$user->registration_type = 1;
			$user->registration_token = $result['id'];
			$user->save();
			if ($user->errors)
			{
				Yii::$app->response->setStatusCode(422, 'Data Validation Failed.');
				return $user->errors;
			}

			$response->setStatusCode ( 201 );
		}
		else
		{
			if (empty($model->access_key))
			{
				$user->generateAuthKey();
				$user->save();
			}
			$response->setStatusCode ( 200 );
		}
		return [
				'id'=>$user->id,
				'first_name'=>$user->first_name,
				'last_name'=>$user->last_name,
				'email'=>$user->email,
				'user_type'=>$user->user_type,
				'access_key'=>$user->access_key
		];
	}

	public function actionLogin() {
		$model = User::findOne([
				'email'=>Yii::$app->request->post('email')
		]);
		$response = Yii::$app->getResponse ();
		if ($model === null)
		{
			$response->setStatusCode ( 401,' Wrong email or password' );
			return null;
		}
		$model->validatePassword (Yii::$app->request->post('password'),$model->password_hash);
		if (!$model->validatePassword (Yii::$app->request->post('password'),$model->password_hash))
		{
			$response->setStatusCode ( 401,' Wrong email or password' );
			return null;
		}

		if (empty($model->access_key))
		{
			$model->generateAuthKey();
			$model->save();
		}
		return [
				'id'=>$model->id,
				'first_name'=>$model->first_name,
				'last_name'=>$model->last_name,
				'email'=>$model->email,
				'user_type'=>$model->user_type,
				'access_key'=>$model->access_key
		];
	}

	public function actionLogout() {
		$model = User::findIdentity(Yii::$app->user->id);
		$model->access_key = '';
		$model->save();
		return [
				'id'=>$model->id,
				'access_key'=>$model->access_key
		];
	}
	/**
	 * Requests password reset.
	 *
	 * @return mixed
	 */
	public function actionRequestpasswordreset() {
		$model = new PasswordResetRequestForm();

		if ($model->load ( Yii::$app->request->post (),'' ) && $model->validate ()) {
			if(!empty($_SERVER['HTTP_CLIENT_IP'])){
				$ip=$_SERVER['HTTP_CLIENT_IP'];
			}
			elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
				$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
			}
			else{
				$ip=$_SERVER['REMOTE_ADDR'];
			}
			if ($model->sendEmail ($ip)) {
				return [
						'msg'=>'Reset Password number code has been sent to email '.$model->email
				];
			} else {
				Yii::$app->session->setFlash ( 'error', 'Sorry, we are unable to reset password for the provided email address.' );
				return null;
			}
		}
		else
		{
			Yii::$app->response->setStatusCode(422, 'Data Validation Failed.');
			return $model->errors;
		}
	}

	/**
	 * Resets password.
	 *
	 * @param string $token
	 * @return mixed
	 * @throws BadRequestHttpException
	 */
	public function actionResetpassword() {
		try {
			if(!empty($_SERVER['HTTP_CLIENT_IP'])){
				$ip=$_SERVER['HTTP_CLIENT_IP'];
			}
			elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
				$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
			}
			else{
				$ip=$_SERVER['REMOTE_ADDR'];
			}
			$model = new ResetPasswordForm( Yii::$app->request->post ('numberCode',''),$ip,Yii::$app->request->post('email','') );
		} catch ( InvalidParamException $e ) {
			throw new BadRequestHttpException ( $e->getMessage () );
		}

		if ($model == null)
		{
			Yii::$app->response->setStatusCode(422, 'Data Validation Failed.');
		}
		if ($model->load ( Yii::$app->request->post (),'' ) && $model->validate () && $model->resetPassword ()) {
			return [
					'msg'=>'Reset Password number code has been sent to email '.$model->email
			];
		}

		Yii::$app->response->setStatusCode(422, 'Data Validation Failed.');
		return $model->errors;
	}
}
