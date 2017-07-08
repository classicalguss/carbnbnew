<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use Yii;
use yii\helpers\Url;
use yii\filters\auth\HttpBearerAuth;
use api\modules\v1\models\User;
use api\modules\v1\models\Car;
use api\modules\v1\models\CarSearch;
use yii\web\UploadedFile;
use yii\web\ServerErrorHttpException;

/**
 * Country Controller API
 *
 * @author Budi Irawan <deerawan@gmail.com>
 */
class CarController extends ActiveController {
	public $modelClass = 'api\modules\v1\models\Car';
	public function actions() {
		$actions = parent::actions ();
		unset ( $actions ['create'] );
		$actions ['index'] ['prepareDataProvider'] = [ 
				$this,
				'prepareDataProvider' 
		];
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
		$model = new $this->modelClass ( [ ] );
		
		$model->load ( Yii::$app->getRequest ()->getBodyParams (), '' );
		$model->owner_id = Yii::$app->user->id;
		$model->photoFile1 = UploadedFile::getInstanceByName ( 'photoFile1' );
		$model->photoFile2 = UploadedFile::getInstanceByName ( 'photoFile2' );
		$model->photoFile3 = UploadedFile::getInstanceByName ( 'photoFile3' );
		$model->photoFile4 = UploadedFile::getInstanceByName ( 'photoFile4' );
		$model->photoFile5 = UploadedFile::getInstanceByName ( 'photoFile5' );
		$model->photoFile6 = UploadedFile::getInstanceByName ( 'photoFile6' );
		
		Yii::warning ( $model->photoFile1 );
		$featuresList = Yii::$app->request->post ( 'featuresList', array () );
		$model->features = implode ( $featuresList, ',' );
		
		if ($model->save ()) {
			$model->upload ();
			$response = Yii::$app->getResponse ();
			$response->setStatusCode ( 201 );
			$id = implode ( ',', array_values ( $model->getPrimaryKey ( true ) ) );
			$response->getHeaders ()->set ( 'Location', Url::toRoute ( [ 
					'view',
					'id' => $id 
			], true ) );
		} elseif (! $model->hasErrors ()) {
			throw new ServerErrorHttpException ( 'Failed to create the object for unknown reason.' );
		}
		
		return $model;
	}
	public function prepareDataProvider() {
		$searchModel = new CarSearch ();
		return $searchModel->search ( Yii::$app->request->queryParams );
	}
}


