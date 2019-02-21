<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use Yii;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;
use yii\filters\auth\HttpBearerAuth;
use api\modules\v1\models\User;
use yii\data\ActiveDataProvider;
use api\modules\v1\models\Rating;
use api\modules\v1\models\RatingSearch;

/**
 * Country Controller API
 *
 * @author Budi Irawan <deerawan@gmail.com>
 */
class RatingController extends ActiveController {
	public $modelClass = 'api\modules\v1\models\Rating';
	public function actions() {
		$actions = parent::actions ();
		unset ($actions ['create'], $actions['update'], $actions['delete']);
		$actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
		return $actions;
	}
	public function behaviors() {
		$behaviors = parent::behaviors ();
		$behaviors ['authenticator'] = [
				'class' => HttpBearerAuth::className (),
				'only' => [
						'create'
				]
		];
		return $behaviors;
	}

	public function actionCreate() {
		$model = new $this->modelClass([]);

		$model->load ( Yii::$app->getRequest ()->getBodyParams (), '' );
		$model->user_id = Yii::$app->user->id;

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
		$searchModel = new RatingSearch();
		return $searchModel->search(Yii::$app->request->queryParams);
	}
}