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
use common\models\Util;
use common\models\Area;
use yii\web\Response;
/**
 * CarController implements the CRUD actions for Car model.
 */
class CarController extends Controller
{
	public $model;

	public $enableCsrfValidation = false;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['approved-requests','booking','ajax-reserve-a-car','list-a-car','update', 'delete','your-cars','toggle-publish','my-drives','my-approvals','reserve-a-car','car-listed-successfully','approve-booking','decline-booking'],
				'rules' => [
					[
						'allow' => true,
							'actions' => ['approved-requests','booking','ajax-reserve-a-car','list-a-car','update', 'delete','your-cars','toggle-publish','my-drives','my-approvals','reserve-a-car','car-listed-successfully','approve-booking','decline-booking'],
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
		$imagesPath     = Yii::$app->params['imagesFolder'];
		$siteImagesPath = Yii::$app->params['siteImagesPath'];

		$carModel = new Car();
		$carModel = Car::find()->joinWith('make',true,'INNER JOIN')
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
		$recentlyListedCarIds = [];
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
		$paymentParams = array(
				'command' => 'AUTHORIZATION',
				'access_code' => 'mjYoPHsRkzTGIlLPVvkX',
				'merchant_identifier' => 'ULhiPMaP',
				'merchant_reference' => '',
				'amount' => '',
				'currency' => 'AED',
				'language' => 'en',
				'customer_email' => 'test@payfort.com',
				'signature' => '',
				'return_url'=>'',
		);
		return $this->render('view', [
			'imagesPath'     => $imagesPath,
			'siteImagesPath' => $siteImagesPath,
			'carInfo'        => $carInfo,
			'ownerInfo'      => $ownerInfo,
			'carRatings'     => $carRatings,
			'ratingsSum'     => $ratingsSum,
			'ratersInfo'     => $ratersInfo,
			'recentlyListedHTML' => $recentlyListedHTML,
			'paymentParams'=>$paymentParams
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

		if ($model->area_id != null)
		{
			$area = Area::find()->where('id = :areaId',[':areaId'=>$model->area_id])->one();
			if ($area != null)
			{
				$model->country_iso = 'ae';
				$model->city_id = $area->city_id;
			}
		}
		if ($model->save())
		{
			$model->upload();
			return $this->redirect(['car-listed-successfully', 'id' => $model->id]);
		}
		else
		{
			Yii::warning($model->errors);
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
	public function actionCarListedSuccessfully($id)
	{
		$model = $this->findModel($id);
		$this->checkAccess($model);

		return $this->render('carListedSuccessfully', [
				'model' => $model,
		]);
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
					'photo' => Yii::$app->params['imagesFolder'].$car->photo1,
					'year_model' => $car->year_model,
					'updated_at' => date("F d, Y", strtotime($car->created_at)),
			];

			if ($car->is_published == 1)
				$publishedCars[] = $carDetails;
			else
				$unPublishedCars[] = $carDetails;
		}

		return $this->render('yourCarsView', [
				'siteImagesPath' => $siteImagesPath,
				'publishedCars'  => $publishedCars,
				'unPublishedCars' => $unPublishedCars,
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
	 * Get logged-in user a list of all cars he/she drove
	 */
	public function actionMyDrives()
	{
		$userId = Yii::$app->user->id;

		$siteImagesPath = Yii::$app->params['siteImagesPath'];

		$bookings = Booking::find()
			->where(['renter_id'=>$userId])
			->all();

		$carIds = [];
		foreach ($bookings as $carBook)
			$carIds[] = $carBook->car_id;
			
		$carIds = array_unique($carIds);

		$carModel = Car::find()
			->joinWith('make',true,'INNER JOIN')
			->joinWith('model',true,'INNER JOIN')
			->joinWith('user',true,'INNER JOIN')
			->where('carmake.id = carmodel.make_id')
			->andWhere(['car.id'=>$carIds])
			->indexBy('id')
			->all();

		$result = [];

		foreach ($bookings as $carBook)
		{
			if (!isset($carModel[$carBook->car_id]))
				continue;
			$carInfo = $carModel[$carBook->car_id];

			$carDetails = [
					'id' => $carBook->id,
					'make'  => $carInfo->make->value,
					'model' => $carInfo->model->value,
					'date_start' =>date("F d", strtotime($carBook['date_start'])),
					'date_end' =>date("F d", strtotime($carBook['date_end'])),
					'year_model' => $carInfo->year_model,
					'photo' => Yii::$app->params['imagesFolder'].$carInfo->photo1,
					'milage_limitation'=> $carInfo->milage_limitation,
					'location'=>$carInfo->getLocation(),
					'status'=>$carBook['status'],
					'owner_name'=>$carInfo->user->first_name
			];

			$result[] = $carDetails;
		}

		return $this->render('myDrivesView', [
				'siteImagesPath' => $siteImagesPath,
				'carsInfo'  => $result,
		]);
	}

	/**
	 * Get logged-in user a list of drive requests on his/her cars
	 */
	public function actionMyApprovals()
	{
		$userId = Yii::$app->user->id;

		$siteImagesPath = Yii::$app->params['siteImagesPath'];

		$bookings = Booking::find()
			->where(['owner_id'=>$userId])
			->andWhere(['booking.status'=>0])
			->andWhere(['>=', 'date_start', new Expression('NOW()')])
			->all();

		$carIds = [];
		foreach ($bookings as $carBook)
			$carIds[] = $carBook->car_id;

		$carIds = array_unique($carIds);

		$carModel = Car::find()
			->joinWith('make',true,'INNER JOIN')
			->joinWith('model',true,'INNER JOIN')
			->joinWith('city',true,'INNER JOIN')
			->where('carmake.id = carmodel.make_id')
			->andWhere(['car.id'=>$carIds])
			->indexBy('id')
			->all();

		$result = [];

		foreach ($bookings as $carBook)
		{
			if (!isset($carModel[$carBook->car_id]))
				continue;
			$carInfo = $carModel[$carBook->car_id];
			$renterInfo = $carBook->renter;

			$rentDetails = [
					'id' => $carBook->id,
					'to' => $carBook->date_end,
					'from' => $carBook->date_start,
					'make'  => $carInfo->make->value,
					'model' => $carInfo->model->value,
					'price' => $carInfo->price,
					'currency' => $carInfo->currency,
					'days_diff' => Util::dateDiff($carBook->date_start, $carBook->date_end)->days,
					'year_model' => $carInfo->year_model,
					'reserved_at' => $carBook->date_created,
					'renter_name' => $renterInfo->first_name,
					'carPhoto' => Yii::$app->params['imagesFolder'].$carInfo->photo1,
					'renterPhoto' => $renterInfo->photoFile,
					'left_to_confirm' => Util::dateDiff(date('Y-m-d'), $carBook->date_start)->days,
					'delivery_time'=>$carBook->delivery_time,
					'city'=>$carInfo->city->value,
					'status'=>0
			];

			$rentDetails['days_diff'] = ($rentDetails['days_diff'] == 0 ? 1 : $rentDetails['days_diff']);
			$result[] = $rentDetails;
		}

		return $this->render('myApprovalsView', [
				'siteImagesPath' => $siteImagesPath,
				'rentsInfo'  => $result,
		]);
	}

	public function actionApprovedRequests()
	{
		$userId = Yii::$app->user->id;
		
		$siteImagesPath = Yii::$app->params['siteImagesPath'];
		
		$bookings = Booking::find()
		->where(['owner_id'=>$userId])
		->andWhere(['booking.status'=>1])
		->all();
		
		$carIds = [];
		foreach ($bookings as $carBook)
			$carIds[] = $carBook->car_id;
			
			$carIds = array_unique($carIds);
			
			$carModel = Car::find()
			->joinWith('make',true,'INNER JOIN')
			->joinWith('model',true,'INNER JOIN')
			->joinWith('city',true,'INNER JOIN')
			->where('carmake.id = carmodel.make_id')
			->andWhere(['car.id'=>$carIds])
			->indexBy('id')
			->all();
			
			$result = [];
			
			foreach ($bookings as $carBook)
			{
				if (!isset($carModel[$carBook->car_id]))
					continue;
					$carInfo = $carModel[$carBook->car_id];
					$renterInfo = $carBook->renter;
					
					$rentDetails = [
							'id' => $carBook->id,
							'to' => $carBook->date_end,
							'from' => $carBook->date_start,
							'make'  => $carInfo->make->value,
							'model' => $carInfo->model->value,
							'price' => $carInfo->price,
							'currency' => $carInfo->currency,
							'days_diff' => Util::dateDiff($carBook->date_start, $carBook->date_end)->days,
							'year_model' => $carInfo->year_model,
							'reserved_at' => $carBook->date_created,
							'renter_name' => $renterInfo->first_name,
							'carPhoto' => Yii::$app->params['imagesFolder'].$carInfo->photo1,
							'renterPhoto' => $renterInfo->photoFile,
							'left_to_confirm' => Util::dateDiff(date('Y-m-d'), $carBook->date_start)->days,
							'delivery_time'=>$carBook->delivery_time,
							'city'=>$carInfo->city->value,
							'status'=>1
					];
					
					$rentDetails['days_diff'] = ($rentDetails['days_diff'] == 0 ? 1 : $rentDetails['days_diff']);
					$result[] = $rentDetails;
			}
			
			return $this->render('myApprovalsView', [
					'siteImagesPath' => $siteImagesPath,
					'rentsInfo'  => $result,
			]);
	}
	
	public function actionApproveBooking()
	{
		$ownerId = Yii::$app->user->id;
		$rentId  = Yii::$app->request->post ('id', null);

		$bookModel = Booking::find()->where(['owner_id'=>$ownerId, 'id'=>$rentId])->one();
		if (empty($bookModel))
			throw new \yii\web\ForbiddenHttpException ( 'Wrong data given' );

		// check if car already reserved on the same period
		if (Booking::isCarRentedOnAPeriod($bookModel->car_id, $bookModel->date_start, $bookModel->date_end))
		{
			Yii::$app->session->setFlash ( 'error', 'Sorry, Your car is already reserved during this period');
			return $this->redirect(['my-approvals']);
		}

		$bookModel->status = 1;
		$bookModel->save();
		return $this->redirect(['my-approvals']);
	}

	public function actionDeclineBooking()
	{
		$ownerId = Yii::$app->user->id;
		$rentId  = Yii::$app->request->post ('id', null);
		
		$bookModel = Booking::find()->where(['owner_id'=>$ownerId, 'id'=>$rentId])->one();
		if (empty($bookModel))
			throw new \yii\web\ForbiddenHttpException ( 'Wrong data given' );
		
		$bookModel->status = 2;
		$bookModel->save();
		return $this->redirect(['my-approvals']);
	}
	
	public function actionAjaxReserveACar()
	{
		Yii::$app->response->format = Response::FORMAT_JSON;
		$carId     = Yii::$app->request->post ('id', null);
		$startDate = Yii::$app->request->post ('start_date', null);
		$endDate   = Yii::$app->request->post ('end_date', null);

		$errorMsg = '';
		if (!Util::validateDate($startDate) || !Util::validateDate($endDate))
			$errorMsg = 'Please select correct dates';
		elseif ($startDate > $endDate)
			$errorMsg = 'Start reservation date should be greater than end date';
		elseif ($startDate < date('Y-m-d'))
			$errorMsg = 'Reservation should be in future';

		$renterId = Yii::$app->user->id;

		$carModal = $this->findModel($carId);

		if ($renterId == $carModal->owner_id)
			$errorMsg = 'You can\'t rent your own car!';

		if (!empty($errorMsg))
		{
			$data = ['success' => false, 'error' => $errorMsg];
			return $data;
		}
		else
		{
			// check if car already reserved on the same period
			if (Booking::isCarRentedOnAPeriod($carId, $startDate, $endDate))
			{
				$data = ['success' => false, 'error' => 'Sorry, This car is already reserved during this period'];
				return $data;
			}
		}
		
		$amount = $carModal->price*Util::dateDiff($startDate, $endDate)->days*100;
		$merchantReference = strtotime($startDate).'-'.strtotime($endDate).'-'.$carModal->id.'-'.Yii::$app->user->id;
		$paymentParams = array(
				'access_code' => 'mjYoPHsRkzTGIlLPVvkX',
				'amount' => $amount,
				'command' => 'AUTHORIZATION',
				'currency' => 'AED',
				'customer_email' => 'test@payfort.com',
				'language' => 'en',
				'merchant_identifier' => 'ULhiPMaP',
				'merchant_reference' => $merchantReference,
				'return_url'=>Url::to(['car/booking'],true),
		);
		$signature = 'iuytrertyui';
		foreach ($paymentParams as $key=>$value)
		{
			$signature .= $key.'='.$value;
		}
		$signature .= 'iuytrertyui';
		$data = ['success' => true, 'amount'=>$amount,'signature'=>hash('sha256',$signature),'merchant_reference'=>$merchantReference,'return_url'=>Url::to(['car/booking'],true)];

		return $data;
	}
	public function actionBooking()
	{
		$message = '';
		$paymentStatus = Yii::$app->request->get('status','00');
		if ($paymentStatus !== '02')
		{
			$message = 'Oops! Something went wrong with the payment, please contact us on barghouti_since88@hotmail.com';
			return $this->render('carReservedSuccessfully', ['message'=>$message]);
		}
		
		$merchantReference = Yii::$app->request->get('merchant_reference',[]);
		$merchantReferenceArray = explode('-',$merchantReference);
		if (count($merchantReferenceArray) != 4)
		{
			$message = 'Oops! Something went wrong with your purchase, please contact us on barghouti_since88@hotmail.com';
			return $this->render('carReservedSuccessfully', ['message'=>$message]);
		}
		$startDate = date('Y-m-d',$merchantReferenceArray[0]);
		$endDate = date('Y-m-d',$merchantReferenceArray[1]);
		$carId = $merchantReferenceArray[2];
		$renterId = $merchantReferenceArray[3];
		if ((int)$renterId !== Yii::$app->user->id)
		{
			$message = 'It doesn\'t seem that this purchase belongs to you! Please contact us on barghouti_since88@hotmail.com';
			return $this->render('carReservedSuccessfully', ['message'=>$message]);
		}
		
		$carModel = Car::findOne($carId);
		if ($carModel === null)
		{
			$message = 'Invalid car. Please contact us on barghouti_since88@hotmail.com';
			return $this->render('carReservedSuccessfully', ['message'=>$message]);
		}
		
		if (Booking::isCarRentedOnAPeriod($carId, $startDate, $endDate))
		{
			$message = 'Oops! Sorry but it seems someone already rented the car in this period!';
			return $this->render('carReservedSuccessfully', ['message'=>$message]);
		}
		
		//Capture the purchase
		$url = 'https://paymentservices.payfort.com/FortAPI/paymentApi';
		
		$arrData = array(
				'access_code' => Yii::$app->request->get('access_code'),
				'amount' => Yii::$app->request->get('amount'),
				'command' => 'CAPTURE',
				'currency' => Yii::$app->request->get('currency'),
				'language' => Yii::$app->request->get('language'),
				'merchant_identifier' => Yii::$app->request->get('merchant_identifier'),
				'merchant_reference' => Yii::$app->request->get('merchant_reference'),
		);
		
		
		$signature = 'iuytrertyui';
		foreach ($arrData as $key=>$value)
		{
			$signature .= $key.'='.$value;
		}
		$signature .= 'iuytrertyui';
		
		$arrData['signature'] = hash('sha256',$signature);
		$ch = curl_init( $url );
		# Setup request to send json via POST.
		$data = json_encode($arrData);
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		# Return response instead of printing.
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
		# Send request.
		$result = curl_exec($ch);
		curl_close($ch);
		# Print response.
		$result = json_decode($result,true);
		if ($result['status'] !== '04')
		{
			$message = 'Oops! Something went wrong with authorizing your purchase, please contact us on barghouti_since88@hotmail.com';
			return $this->render('carReservedSuccessfully', ['message'=>$message]);
		}
		$booking = new Booking();
		$booking->car_id = $carId;
		$booking->date_start = $startDate;
		$booking->date_end = $endDate;
		$booking->renter_id = $renterId;
		$booking->owner_id = $carModel->owner_id;
		if ($carModel->book_instantly == 1)
		{
			$booking->status = 1;
			$booking->save();
			return $this->render('carReservedSuccessfully', ['message'=>'']);
		}
		else
		{
			$booking->status = 0;
			$booking->save();
			return $this->render('carReservedSuccessfully', ['message'=>'']);
		}
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
