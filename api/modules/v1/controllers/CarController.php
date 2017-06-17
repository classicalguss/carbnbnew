<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use Yii;
use yii\helpers\Url;
use yii\filters\auth\HttpBearerAuth;
use api\modules\v1\models\User;
use yii\data\ActiveDataProvider;
use api\modules\v1\models\Car;
use api\modules\v1\models\CarSearch;

/**
 * Country Controller API
 *
 * @author Budi Irawan <deerawan@gmail.com>
 */
class CarController extends ActiveController {
	public $modelClass = 'api\modules\v1\models\Car';
	public function actions() {
		$actions = parent::actions ();
		unset ($actions ['create']);
		$actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
		return $actions;
	}
	public function behaviors() {
		$behaviors = parent::behaviors ();
		$behaviors ['authenticator'] = [ 
				'class' => HttpBearerAuth::className (),
				'only' => [ 
						'update',
						'delete',
						'create' 
				] 
		];
		return $behaviors;
	}
	public function checkAccess($action, $model = null, $params = []) {
		if ($action === 'update' || $action === 'delete') {
			if ($model->owner_id !== \Yii::$app->user->id)
				throw new \yii\web\ForbiddenHttpException ( sprintf ( 'You can only %s articles that you\'ve created.', $action ) );
		}
	}
	public function actionCreate() {
		$model = new $this->modelClass([]);
		
		$model->load ( Yii::$app->getRequest ()->getBodyParams (), '' );
		$model->owner_id = Yii::$app->user->id;
		
		if ($model->save()) {
			$response = Yii::$app->getResponse();
			$response->setStatusCode(201);
			$id = implode(',', array_values($model->getPrimaryKey(true)));
			$response->getHeaders ()->set ( 'Location', Url::toRoute ( [
					'view',
					'id' => $id
			], true ) );
		} elseif (!$model->hasErrors()) {
			throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
		}
		
		return $model;
	}
	
	public function prepareDataProvider()
	{
		$searchModel = new CarSearch();
		return $searchModel->search(Yii::$app->request->queryParams);
	}
}


