<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use frontend\models\Car;
use frontend\models\CarSearch;
use frontend\models\Rating;
use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\base\Model;
use frontend\models\carDetailsForm;
use frontend\models\carFeaturesForm;
use frontend\models\carPhotosForm;
use frontend\models\carPublishForm;
use common\models\Carmodel;
use common\models\Booking;
use yii\web\UploadedFile;
use yii\db\Expression;

/**
 * CarController implements the CRUD actions for Car model.
 */
class CarController extends Controller
{
	public $model;

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['list-a-car','update', 'delete','your-cars','toggle-publish'],
				'rules' => [
					[
						'allow' => true,
						'actions' => ['list-a-car','update', 'delete','your-cars','toggle-publish'],
						'roles' => ['@'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST'],
					'toggle-publish' => ['POST'],
				],
			],
		];
	}

	/**
	 * @param Model $model
	 * @throws \yii\web\ForbiddenHttpException
	 */
	public function checkAccess($model = null)
	{
		$action = $this->action->id;
		if ($model->owner_id !== \Yii::$app->user->id && !Yii::$app->user->identity->isAdmin())
			throw new \yii\web\ForbiddenHttpException ( sprintf ( 'You can only %s cars that you\'ve created.', $action ) );
	}

	/**
	 * Lists all Car models.
	 * @return mixed
	 */
	public function actionSearch()
	{
		$searchModel = new CarSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('search', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Car model.
	 * @param string $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		$this->layout   = 'main-nav-search';
		$imagesPath     = Yii::$app->params['imagesFolder'];
		$siteImagesPath = Yii::$app->params['siteImagesPath'];

		$carModel = Car::find()
						->joinWith('make',true,'INNER JOIN')
						->joinWith('model',true,'INNER JOIN')
						->joinWith('ratings')
						->joinWith('user')
						->where('carmake.id = carmodel.make_id')
						->andWhere(['car.id'=>$id])
						->one();

		if (empty($carModel))
			throw new NotFoundHttpException ( 'The requested page does not exist.' );
		if ($carModel->owner_id !== \Yii::$app->user->id && $carModel->is_published != 1)
			throw new NotFoundHttpException ( 'The requested page does not exist.' );

		$ownerInfo   = $carModel->user->attributes;
		$carRatings  = $carModel->ratings;
		$makeName    = $carModel->make->value;
		$modelName   = $carModel->model->value;
		$carInfo     = $carModel->attributes;

		$carInfo['images']       = $carModel->getPhotos();
		$carInfo['location']     = $carModel->getLocation();
		$carInfo['makeName']     = $makeName;
		$carInfo['modelName']    = $modelName;
		$carInfo['features']     = $carModel->getAssociateFeatures();
		$carInfo['colorText']    = $carModel->colorText;
		$carInfo['properties']   = $carModel->getProperties();
		$carInfo['odometerText'] = $carModel->odometerText;

		$ratingsSum  = 0;
		$ratersInfo  = [];

		if (!empty($carRatings))
		{
			$rateTmp=[];
			$ratersIds=[];
			foreach ($carRatings as $rating)
			{
				$ratingsSum += $rating->rating;
				$rateTmp[]   = $rating->attributes;
				$ratersIds[] = $rating->user_id; // to get info about the user who rated this car.
			}
			$carRatings = $rateTmp;

			$ratersInfo = User::find()->where(['id'=>$ratersIds])->all();
			$ratersInfo = \common\models\Util::getModelAttributes($ratersInfo);
			$ratersTmp = array();
			foreach ($ratersInfo as $rater)
			{
				$ratersTmp[$rater['id']] = $rater;
			}
			$ratersInfo = $ratersTmp;
		}

		$recentlyListed   = Car::getRecentlyListed(3, [$id]);
		foreach ($recentlyListed as $car)
			$recentlyListedCarIds[] = $car->id;
		$recentlyListedCarsRatings = Car::getAllRatings($recentlyListedCarIds);
		$recentlyListedHTML = $this->renderPartial('@frontend/views/listOfCars',
		[
			'title'      => 'Recently Listed Cars',
			'columns'    => 3,
			'listOfCars' => $recentlyListed,
			'imagesPath' => $imagesPath,
			'carsRating' => $recentlyListedCarsRatings,
		]);
		return $this->render('view', [
			'imagesPath'     => $imagesPath,
			'siteImagesPath' => $siteImagesPath,
			'carInfo'        => $carInfo,
			'ownerInfo'      => $ownerInfo,
			'carRatings'     => $carRatings,
			'ratingsSum'     => $ratingsSum,
			'ratersInfo'     => $ratersInfo,
			'recentlyListedHTML' => $recentlyListedHTML,
		]);
	}

	/**
	 * Creates a new Car model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionListACar()
	{
		$model = new Car();

		$postedData = Yii::$app->request->post();
		$allFormsData  = [];
		$allFormsNames = ['carDetailsForm','carFeaturesForm','carPhotosForm','carPublishForm'];
		foreach ($allFormsNames as $formName)
		{
			if (isset($postedData[$formName]))
				$allFormsData = array_merge($allFormsData, $postedData[$formName]);
		}

		$model->load(['Car'=>$allFormsData]);
		$model->owner_id = Yii::$app->user->id;
		$model->photoFile1 = UploadedFile::getInstanceByName ( 'carPhotosForm[photoFile1]' );
		$model->photoFile2 = UploadedFile::getInstanceByName ( 'carPhotosForm[photoFile2]' );
		$model->photoFile3 = UploadedFile::getInstanceByName ( 'carPhotosForm[photoFile3]' );
		$model->photoFile4 = UploadedFile::getInstanceByName ( 'carPhotosForm[photoFile4]' );
		$model->photoFile5 = UploadedFile::getInstanceByName ( 'carPhotosForm[photoFile5]' );
		$model->photoFile6 = UploadedFile::getInstanceByName ( 'carPhotosForm[photoFile6]' );
		$model->features   = isset($allFormsData['features']) ? implode(',', $allFormsData['features']) : '';
		$model->scenario = 'create';

		if ($model->save())
		{
			$model->upload();
			return $this->redirect(['view', 'id' => $model->id]);
		}
		else
		{
			$models = [
					'carDetailsModel'  => new carDetailsForm(),
					'carFeaturesModel' => new carFeaturesForm(),
					'carPhotosModel'   => new carPhotosForm(),
					'carPublishModel'  => new carPublishForm(),
			];
			foreach ($models as &$modelObject)
			{
				$modelObject->load($postedData);
			}
			return $this->render('create', [
				'models' => $models,
			]);
		}
	}

	/**
	 * Updates an existing Car model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param string $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$this->checkAccess($model);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Deletes an existing Car model.
	 * If deletion is successful, the browser will be redirected to the 'search' page.
	 * @param string $id
	 * @return mixed
	 */
	public function actionDelete()
	{
		$id = Yii::$app->request->post ('id', null);
		$model = $this->findModel($id);
		$this->checkAccess($model);

		$model->delete();
		return $this->redirect(['your-cars']);
	}

	/**
	 * List all created cars for logged in user.
	 * @return mixed
	 */
	public function actionYourCars()
	{
		$userId = Yii::$app->user->id;

		$imagesPath     = Yii::$app->params['imagesFolder'];
		$siteImagesPath = Yii::$app->params['siteImagesPath'];

		$carModel = Car::find()
			->joinWith('make',true,'INNER JOIN')
			->joinWith('model',true,'INNER JOIN')
			->where('carmake.id = carmodel.make_id')
			->andWhere(['car.owner_id'=>$userId])
			->orderBy('car.is_published DESC, car.created_at DESC')
			->all();

		$carIds = [];
		foreach ($carModel as $car)
			$carIds[] = $car->id;

		$bookings = Booking::find()
			->select(['car_id','count(*) as count'])
			->where(['car_id'=>$carIds])
			->andWhere(['status'=>1])
			->andWhere(['<', 'date_start', new Expression('NOW()')])
			->groupBy('car_id')
			->indexBy('car_id')
			->all();

		$publishedCars   = [];
		$unPublishedCars = [];

		foreach ($carModel as $car)
		{
			$trips = 0;
			if (isset($bookings[$car->id]))
				$trips = $bookings[$car->id]->count;
			$carDetails = [
					'id' => $car->id,
					'make'  => $car->make->value,
					'model' => $car->model->value,
					'trips' => $trips,
					'year_model' => $car->year_model,
					'updated_at' => date("F d, Y", strtotime($car->created_at)),
			];

			if ($car->is_published == 1)
				$publishedCars[] = $carDetails;
			else
				$unPublishedCars[] = $carDetails;
		}

		return $this->render('yourCarsView', [
				'imagesPath'     => $imagesPath,
				'siteImagesPath' => $siteImagesPath,
				'publishedCars'  => $publishedCars,
				'unPublishedCars' => $unPublishedCars,
				'p'=>$bookings,
		]);
	}

	/**
	 * Change car publish status
	 * @return mixed
	 */
	public function actionTogglePublish()
	{
		$id = Yii::$app->request->post ('id', null);
		$model = $this->findModel($id);
		$this->checkAccess($model);

		$publishStatus = Yii::$app->request->post ('is_published', null);
		if ($publishStatus === null)
			throw new \yii\web\ForbiddenHttpException ( 'missing publish status' );

		$publishStatus= ($publishStatus== 1 ? 1 : 0);

		$model->is_published = $publishStatus;

		$newStatus = ($publishStatus== 1 ? 'Published' : 'Unpublished');
		if ($model->save())
		{
			Yii::$app->session->setFlash ( 'success', 'Car status changed to '.$newStatus );
			return $this->redirect(['your-cars']);
		}
		throw new \yii\web\ForbiddenHttpException ( 'Error editing publish status' );
	}

	/**
	 * Finds the Car model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param string $id
	 * @return Car the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Car::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	public static function getCarViewUrl($id)
	{
		return Url::to(['car/view/','id'=>$id]);
	}

	public function actionGetCarMakeModels($id)
	{
		return $this->renderAjax('carModelsDropDownListView', ['list'=>Carmodel::getCarMakeModels($id)]);
	}
}
