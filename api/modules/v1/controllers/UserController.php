<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use Yii;
use yii\helpers\Url;
use yii\filters\auth\HttpBearerAuth;
use api\modules\v1\models\User;
use common\models\Carmake;
use common\models\City;
use common\models\Area;
use yii\web\UploadedFile;

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
		$model->photoFile = UploadedFile::getInstanceByName ('photoFile');
		
		if ($model->validate ()) {
			$model->setPassword ( $model->password );
			$model->generateAuthKey ();
			$model->user_type = 1;
			
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
						'photo'=>Yii::$app->params ['imagesFolder'].$model->photo
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
		$myList = "Al Qusais First
Al Qusais Industrial Fifth
Al Qusais Industrial First
Al Qusais Industrial Fourth
Al Qusais Industrial Second
Al Qusais Industrial Third
Al Qusais Second
Al Qusais Third
Al Raffa
Al Ras
Al Rashidiya
Al Rigga
Al Safa First
Al Safa Second
Al Safouh First
Al Safouh Second
Al Satwa
Al Shindagha
Al Souq Al Kabeer
Al Twar First
Al Twar Second
Al Twar Third
Al Warqa'a Fifth
Al Warqa'a First
Al Warqa'a Fourth
Al Warqa'a Second
Al Warqa'a Third
Al Wasl
Al Waheda
Ayal Nasir
Aleyas
Bu Kadra
Dubai Investment park First
Dubai Investment Park Second
Emirates Hill First
Emirates Hill Second
Emirates Hill Third
Hatta
Hor Al Anz
Hor Al Anz East
Jebel Ali 1
Jebel Ali 2
Jebel Ali Industrial
Jebel Ali Palm
Jumeira First
Palm Jumeira
Jumeira Second
Jumeira Third
Al Mankhool
Marsa Dubai
Mirdif
Muhaisanah Fourth
Muhaisanah Second
Muhaisanah Third
Muhaisnah First
Al Mushrif
Nad Al Hammar
Nadd Al Shiba Fourth
Nadd Al Shiba Second
Nadd Al Shiba Third
Nad Shamma
Naif
Al Muteena First
Al Muteena Second
Al Nasr, Dubai
Port Saeed
Arabian Ranches
Ras Al Khor
Ras Al Khor Industrial First
Ras Al Khor Industrial Second
Ras Al Khor Industrial Third
Rigga Al Buteen
Trade Centre 1
Trade Centre 2
Umm Al Sheif
Umm Hurair First
Umm Hurair Second
Umm Ramool
Umm Suqeim First
Umm Suqeim Second
Umm Suqeim Third
Wadi Alamardi
Warsan First
Warsan Second
Za'abeel First
Za'abeel Second";
		
		$myArray = explode("\n",$myList);
		foreach ($myArray as $element) {
			$element = trim($element);
			$carMakeElement = new Area();
			$carMakeElement->city_id = 2;
			$carMakeElement->value = $element;
			$carMakeElement->save();
		}

		$myList = "Al Bateen
Al Khubeirah
Tourist Club
Al Markaziyah
Al Karamah
Al Rowdah
Madinat Zayed
Al Nahyan, Hadabat, Al Zaafaran, Al Zahra
Al Mushrif
Khalidiyah
Raha Beach
Kalifa City
Al Reef Gardens
Al Reem Island
Between the Bridges
Breakwater
Sas Al Nakheel (Umm al Naar)";
		
		$myArray = explode("\n",$myList);
		foreach ($myArray as $element) {
			$element = trim($element);
			$carMakeElement = new Area();
			$carMakeElement->city_id = 1;
			$carMakeElement->value = $element;
			$carMakeElement->save();
		}
		
		$myList = "Abu Shagara
Al Mahatta
Al Majaz
Al Nad
Al Nahda
Al Layyeh
Al Taawun
Al Yarmook
Al Qasba
Al Rolla
Musallah
Al Qulayya
Al Mujarrah
Muwailah
Buteena
Halwan
Al Suyoh";
		
		$myArray = explode("\n",$myList);
		foreach ($myArray as $element) {
			$element = trim($element);
			$carMakeElement = new Area();
			$carMakeElement->city_id = 3;
			$carMakeElement->value = $element;
			$carMakeElement->save();
		}
		
		$myList = "Ajman City Center
Ajman Corniche
Ajman Free Zone
Ajman Khor
Ajman Marina
Ajman Pearl
Ajman Port
Ajman Uptown
Al Ameera Village
Al Bustan
Al Butain
Al Dhran
Al Jurf
Al Hamidiya
Al Hamriya?
Al Helio
Al Muntazi
Al Mushairef
Al Muwayhat
Al Naemiyah
Al Nakhil
Al Naseem
Al Owan
Al Rashidiya
Al Rifaah
Al Rowdha?
Al Rumailah
Al Sawan
Al Zahra
Al Zora
Awali City
Emirates City
Emirates City Extension
Escape
Garden City
Green City
Hatta
Ittihad Village
Manama
Marmooka City
Masfout
Mazeria
Meadows Ajman
Meidan Al Tallah
Mushairef
Mushairef Commercial
New Industrial Area
Old Industrial Area
Safia Island
Subaikah";
		
		$myArray = explode("\n",$myList);
		foreach ($myArray as $element) {
			$element = trim($element);
			$carMakeElement = new Area();
			$carMakeElement->city_id = 4;
			$carMakeElement->value = $element;
			$carMakeElement->save();
		}
		$myList = "Al Bateen
Al Foah
Al Hili - see Hili
Al Jimi
Al Khabisi, Al Khabaisi
Al Khrair
Al Maqam
Al Masoudi
Al Mazam
Al Mutawaa
Al Muwaiji
Al Niyadat
Al Qattara
Al Saniya
Al Surooj
Al Tawiyah
Central District
Falaj Hazza
Hili
Magar Al Dhabi
Munaseer, Muniseer, Munasir
Saniya
Tawam
Zakhir";
		
		$myArray = explode("\n",$myList);
		foreach ($myArray as $element) {
			$element = trim($element);
			$carMakeElement = new Area();
			$carMakeElement->city_id = 5;
			$carMakeElement->value = $element;
			$carMakeElement->save();
		}

		$myList = "Al Darbijaniyah
Al Dhait
Al Hamra, Al Hamrah, AlHamra
Al Hamra Village
Al Hudaihbah
Al Jazeera
Al Juwais
Al Kharan?
Al Nakheel
Al Saih
Al Seer
Al Soor
Al Uraibi
Al Zahra
Al Zaith?
Dafan Al Khor
Dafan Al Nakheel
Dahan
Jazeera Al Hamra
Julan
Julfar
Khuzam, Khouzam
Maareed?
Mamourah
Nakheel
Old Town RAK
Seih Al Burairat
Seih Al Hudaibah
Seih Al Uraibi";
		
		$myArray = explode("\n",$myList);
		foreach ($myArray as $element) {
			$element = trim($element);
			$carMakeElement = new Area();
			$carMakeElement->city_id = 6;
			$carMakeElement->value = $element;
			$carMakeElement->save();
		}
	}
}
