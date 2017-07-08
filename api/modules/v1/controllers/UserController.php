<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use Yii;
use yii\helpers\Url;
use yii\filters\auth\HttpBearerAuth;
use api\modules\v1\models\User;
use common\models\Carmake;
use common\models\City;

/**
 * Country Controller API
 *
 * @author Budi Irawan <deerawan@gmail.com>
 */
class UserController extends ActiveController {
	public $modelClass = 'api\modules\v1\models\User';
	public $show_credentials = false;
	
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
	public function actionCreate() {
		$model = new $this->modelClass ( [ 
				'scenario' => 'signup' 
		] );
		$model->load ( Yii::$app->getRequest ()->getBodyParams (), '' );
		if ($model->validate ()) {
			$model->setPassword ( $model->password );
			$model->generateAuthKey ();
			$model->user_type = 1;
			
			if ($model->save ()) {
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
						'access_key'=>$model->access_key
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
	public function actionUpdate($id) {
		$model = User::findIdentity($id);
		if ($model->id !== Yii::$app->user->id)
			throw new \yii\web\ForbiddenHttpException('You can only update your own user');
		$model->setAttributes(Yii::$app->request->post());
		$model->save ();
		return $model;
	}
	public function actionTest () {
		$myList = "ACURA
ALFA ROMEO
AMC
ARIEL
ASTON MARTIN
AUDI
AUSTIN HEALEY
BENTLEY
BMW
BUGATTI
BUICK
CADILLAC
CALLAWAY
CATERHAM
CHEVROLET
CHRYSLER
CITROEN
DAEWOO
DAIHATSU
DATSUN
DE TOMASO
DODGE
EAGLE
FERRARI
FIAT
FISKER
FORD
GENESIS
GEO
GMC
HOLDEN
HONDA
HUMMER
HYUNDAI
INFINITI
ISUZU
JAGUAR
JEEP
KIA
KOENIGSEGG
LAMBORGHINI
LANCIA
LAND ROVER
LEXUS
LINCOLN
LOTUS
MASERATI
MAYBACH
MAZDA
MCLAREN
MERCEDES
MERCURY
MG
MINI
MITSUBISHI
MORGAN
MOSLER / ROSSION
NISSAN
NOBLE
OLDSMOBILE
OPEL
PAGANI
PEUGEOT
PLYMOUTH
PONTIAC
PORSCHE
PROTON
RAM
RENAULT
ROLLS-ROYCE
SAAB
SALEEN
SATURN
SCION
SEAT
SHELBY
SKODA
SMART
SSANGYONG
SUBARU
SUZUKI
TESLA
TOYOTA
TRIUMPH
VAUXHALL
VW
VOLVO
WESTFIELD";
		
		$myArray = explode("\n",$myList);
		foreach ($myArray as $element) {
			$element = trim($element);
			$carMakeElement = new Carmake();
			$carMakeElement->value = $element;
			$carMakeElement->save();
		}
		//Yii::warning($myArray);
		
		$myList = "Abu Dhabi
Dubai
Sharjah
Ajman
Al Ain
Ras Al Khaimah
Fujairah
Umm al-Quwain";
		
		$myArray = explode("\n",$myList);
		foreach ($myArray as $element) {
			$element = trim($element);
			$carMakeElement = new City();
			$carMakeElement->country_iso = 'ae';
			$carMakeElement->value = $element;
			$carMakeElement->save();
		}
		//Yii::warning($myArray);
	}
}
