<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\User;
use frontend\models\SubscribeForm;
use frontend\models\Car;
use frontend\models\Rating;

/**
 * Site controller
 */
class SiteController extends Controller {
	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [];
	}

	/**
	 * @inheritdoc
	 */
	public function actions() {
		return [
				'error' => [
						'class' => 'yii\web\ErrorAction'
				],
				'captcha' => [
						'class' => 'yii\captcha\CaptchaAction',
						'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
				]
		];
	}

	/**
	 * Displays homepage.
	 *
	 * @return mixed
	 */
	public function actionIndex()
	{
		$featuredCars     = Car::getFeaturedCars(10);
		$recentlyListed   = Car::getRecentlyListed(10);
		$featuredCarMakes = Car::getFeaturedCarMakes(2,10);

		$featuredCarMakesIds = $featuredCarMakes['carIds'];
		$featuredCarMakes    = $featuredCarMakes['cars'];

		$allCarIds = [];
		foreach ($featuredCars as $car)
			$allCarIds[] = $car->id;
		foreach ($recentlyListed as $car)
			$allCarIds[] = $car->id;
		if (!empty($featuredCarMakesIds))
			$allCarIds = array_merge($allCarIds, $featuredCarMakesIds);

		$carsRating= Car::getAllRatings($allCarIds);

		$imagesPath = Yii::$app->params['imagesFolder'];

		$featuredCarsHTML = $this->renderPartial('listOfCars',
		[
				'title'      => 'Featured Cars',
				'columns'    => 4,
				'listOfCars' => $featuredCars,
				'imagesPath' => $imagesPath,
				'carsRating' => $carsRating,
		]);
		$recentlyListedHTML = $this->renderPartial('listOfCars',
		[
				'title'      => 'Recently Listed Cars',
				'columns'    => 3,
				'listOfCars' => $recentlyListed,
				'imagesPath' => $imagesPath,
				'carsRating' => $carsRating,
		]);

		$featuredCarMakesHTML='';
		foreach ($featuredCarMakes as $makeName=>$cars)
		{
			$featuredCarMakesHTML.= $this->renderPartial('listOfCars',
			[
					'title'      => $makeName,
					'columns'    => 4,
					'listOfCars' => $cars,
					'imagesPath' => $imagesPath,
					'carsRating' => $carsRating,
			]);
		}
		return $this->render ('index', [
				'imagesPath' => $imagesPath,
				'featuredCarsHTML'     => $featuredCarsHTML,
				'recentlyListedHTML'   => $recentlyListedHTML,
				'featuredCarMakesHTML' => $featuredCarMakesHTML,
		]);
	}

	/**
	 * Displays contact page.
	 *
	 * @return mixed
	 */
	public function actionContact() {
		$model = new ContactForm ();
		if ($model->load ( Yii::$app->request->post () ) && $model->validate ()) {
			if ($model->sendEmail ( Yii::$app->params ['adminEmail'] )) {
				Yii::$app->session->setFlash ( 'success', 'Thank you for contacting us. We will respond to you as soon as possible.' );
			} else {
				Yii::$app->session->setFlash ( 'error', 'There was an error sending your message.' );
			}

			return $this->refresh ();
		} else {
			return $this->render ( 'contact', [
					'model' => $model
			] );
		}
	}

	/**
	 * Displays about page.
	 *
	 * @return mixed
	 */
	public function actionAbout() {
		$obj = new Rating();
		$obj->car_id = 5;
		$obj->user_id = 6;
		$obj->description = 'Rating is good';
		$obj->rating = 3;
// 		$obj->save();
		return $this->render ( 'about' );
	}
}
