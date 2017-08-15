<?php 
namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use api\modules\v1\models\Booking;
use yii\filters\auth\HttpBearerAuth;
use yii\helpers\Url;
use Yii;
use api\modules\v1\models\Car;

class BookingController extends ActiveController {
	public $modelClass = 'common\models\Booking';
	public function actions() {
		$actions = parent::actions ();
		unset($actions['create'],$actions['update']);
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
						'create',
						'delete',
						'index',
						'view',
						'approve',
						'disapprove'
				]
		];
		return $behaviors;
	}
	public function checkAccess($action, $model = null, $params = []) {
		if ($action === 'delete') {
			if ($model->renter_id !== \Yii::$app->user->id)
				throw new \yii\web\ForbiddenHttpException ( sprintf ( 'You can only %s bookings that belong to you.', $action ) );
		}
		else if ($action === 'index')
		{
			$renterId = Yii::$app->request->get('renter_id',null);
			$ownerId = Yii::$app->request->get('owner_id',null);
			Yii::warning($ownerId);
			Yii::warning(\Yii::$app->user->id);
			if ($renterId === null && $ownerId === null)
			{
				throw new \yii\web\ForbiddenHttpException ('You are not allowed to see these bookings.');
			}
			else if ($renterId !== null && $renterId != \Yii::$app->user->id)
			{
				throw new \yii\web\ForbiddenHttpException ('You are not allowed to see these bookings.');
			}
			else if ($ownerId !== null && $ownerId != \Yii::$app->user->id)
			{
				throw new \yii\web\ForbiddenHttpException ('You are not allowed to see these bookings.');
			}
		}
		else if ($action === 'view')
		{
			if ($model->renter_id != \Yii::$app->user->id && $model->owner_id != \Yii::$app->user->id)
			{
				throw new \yii\web\ForbiddenHttpException ('You are not allowed to see these bookings.');
			}
		}
		else if ($action === 'approve' || $action === 'disapprove')
		{
			if ($model->owner_id !== \Yii::$app->user->id)
				throw new \yii\web\ForbiddenHttpException ( sprintf ( 'You cannot change the status of this booking.', $action ) );
		}
	}
	public function actionApprove($id) {
		$model = \common\models\Booking::findOne($id);
		if ($model->status == 0)
		{
			$model->status = 1;
			$model->save();
		}
		else
		{
			Yii::$app->response->setStatusCode(422,'You have already set the status of this booking.');
			return $model;
		}
		
		return $model;
	}
	public function actionDisapprove($id) {
		$model = \common\models\Booking::findOne($id);
		if ($model->status == 0)
		{
			$model->status = 2;
			$model->save();
		}
		else
		{
			Yii::$app->response->setStatusCode(422,'You have already set the status of this booking.');
			return $model;
		}
		return $model;
	}
	public function actionCreate() {		
		$model = new $this->modelClass([]);
		
		$model->load(Yii::$app->getRequest()->getBodyParams(), '');
		$model->renter_id = Yii::$app->user->id;
		$response = Yii::$app->getResponse();

		$carModel = Car::findOne($model->car_id);
		$model->owner_id = $carModel->owner_id;
		if($carModel->book_instantly)
			$model->status = 1;
		else
			$model->status = 0;
		
		if ($model->renter_id == $model->owner_id)
		{
			$response->setStatusCode(422,'You cannot book your own car.');
			return $model;
		}
		if ($model->validate()) {
			
			
			$existingModel = $this->modelClass::find()->where('(
				date_start BETWEEN :date_start AND :date_end
				OR date_end BETWEEN :date_start AND :date_end
				OR (date_start < :date_start AND date_end > :date_end))',[':date_start'=>$model->date_start,':date_end'=>$model->date_end])
				->andFilterWhere(['status'=>1,'car_id'=>$model->car_id])
				->one();
			
			if (count($existingModel)>0)
			{
				$response->setStatusCode(422,'This car is not available for the required Dates');
				$existingModel->renter_id = 'Hidden';
				return $existingModel;
			}
			
			$existingModel = $this->modelClass::find()->where('(
				date_start BETWEEN :date_start AND :date_end 
				OR date_end BETWEEN :date_start AND :date_end
				OR (date_start < :date_start AND date_end > :date_end))',[':date_start'=>$model->date_start,':date_end'=>$model->date_end])
				->andFilterWhere(['status'=>0,'car_id'=>$model->car_id,'renter_id'=>$model->renter_id])->one();

			if (count($existingModel)>0)
			{
				$response->setStatusCode(422,'You already requested a booking to this car, be patient.');
				return $existingModel;
			}
			
			$model->save();
			$response->setStatusCode(201,$model->getStatusMessage());
			
			$id = implode(',', array_values($model->getPrimaryKey(true)));
			$response->getHeaders()->set('Location', Url::toRoute(['view', 'id' => $id], true));
		} elseif (!$model->hasErrors()) {
			throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
		} else {
			Yii::warning('validation failed?');
			return $model->errors;
		}
		
		return $model;
	}
	public function prepareDataProvider() {
		$query = $this->modelClass::find();
		$dataProvider = new ActiveDataProvider([
				'query' => $query,
		]);
		
		$query->andFilterWhere([
				'car_id' => Yii::$app->request->getQueryParam('car_id',null),
				'owner_id' => Yii::$app->request->getQueryParam('owner_id',null),
				'renter_id' => Yii::$app->request->getQueryParam('renter_id',null),
		]);
		
		return $dataProvider;
	}
}
?>