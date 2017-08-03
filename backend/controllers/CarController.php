<?php

namespace backend\controllers;

use Yii;
use common\models\Car;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\AccessRule;
use common\models\User;
use yii\filters\AccessControl;

/**
 * CarController implements the CRUD actions for Car model.
 */
class CarController extends Controller {
	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [ 
				'access' => [ 
						'class' => AccessControl::className(),
						'ruleConfig'=>[
								'class'=>AccessRule::className()
						],
						'only' => [ 
								'index',
								'create',
								'update',
								'view' 
						],
						'rules' => [ 
								[ 
										'allow' => true,
										'roles' => [ 
												User::ROLE_ADMIN
										]
								]
						] 
				],
				'verbs' => [ 
						'class' => VerbFilter::className (),
						'actions' => [ 
								'delete' => [ 
										'POST' 
								] 
						] 
				] 
		];
	}
	
	/**
	 * Lists all Car models.
	 * 
	 * @return mixed
	 */
	public function actionIndex() {
		$dataProvider = new ActiveDataProvider ( [ 
				'query' => Car::find () 
		] );
		
		return $this->render ( 'index', [ 
				'dataProvider' => $dataProvider 
		] );
	}
	
	/**
	 * Displays a single Car model.
	 * 
	 * @param string $id        	
	 * @return mixed
	 */
	public function actionView($id) {
		return $this->render ( 'view', [ 
				'model' => $this->findModel ( $id ) 
		] );
	}
	
	/**
	 * Creates a new Car model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * 
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new Car ();
		$featuresList = Yii::$app->request->post('featuresList',array());
		
		if ($model->load ( Yii::$app->request->post () ) && $model->save ()) {
			return $this->redirect ( [ 
					'view',
					'id' => $model->id 
			] );
		} else {
			return $this->render ( 'create', [ 
					'model' => $model 
			] );
		}
	}
	
	/**
	 * Updates an existing Car model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * 
	 * @param string $id        	
	 * @return mixed
	 */
	public function actionUpdate($id) {
		$model = $this->findModel ( $id );
		
		if ($model->load ( Yii::$app->request->post () ) && $model->save ()) {
			return $this->redirect ( [ 
					'view',
					'id' => $model->id 
			] );
		} else {
			return $this->render ( 'update', [ 
					'model' => $model 
			] );
		}
	}
	
	/**
	 * Deletes an existing Car model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * 
	 * @param string $id        	
	 * @return mixed
	 */
	public function actionDelete($id) {
		$this->findModel ( $id )->delete ();
		
		return $this->redirect ( [ 
				'index' 
		] );
	}
	
	/**
	 * Finds the Car model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * 
	 * @param string $id        	
	 * @return Car the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Car::findOne ( $id )) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException ( 'The requested page does not exist.' );
		}
	}
}
