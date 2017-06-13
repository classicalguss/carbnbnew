<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;

use yii\filters\auth\CompositeAuth;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
/**
 * Country Controller API
 *
 * @author Budi Irawan <deerawan@gmail.com>
 */
class CountryController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Country';
    
    public function behaviors() {
    	$behaviors = parent::behaviors ();
    	$behaviors ['authenticator'] = [
    			'class' => CompositeAuth::className(),
    			'authMethods' => [
    					['class' => HttpBasicAuth::className()],
    			],
    			'only'=>['update','delete']
    	];
    	$behaviors['access'] = [
    					'class' => AccessControl::className(),
    					'rules' => [
    							[
    									'allow' => true,
    									'roles' => ['?'],
    							],
    					],
    	];
    	return $behaviors;
    }
}


