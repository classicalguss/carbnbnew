<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\BadRequestHttpException;
use frontend\models\ReserveConfirmationForm;
use common\models\Booking;
use common\models\Util;
use common\models\User;

class BookingController extends Controller {
	public function behaviors() {
		return [
				'access' => [
						'class' => AccessControl::className (),
						'rules' => [
								[
										'allow' => true,
										'actions' => [
												'approved-requests',
												'reserve-confirmation'
										],
										'roles' => [
												'@'
										]
								]
						]
				]
		];
	}
	public function actionReserveConfirmation() {
		$session = Yii::$app->getSession ();
		$reserveConfirmationData = $session->get ( 'reserveConfirmationData', null );
		if ($reserveConfirmationData == null || ! is_array ( $reserveConfirmationData ) || ! array_key_exists ( 'carId', $reserveConfirmationData )) {
			throw new BadRequestHttpException ( "Something went wrong" );
		}

		$carModel = $reserveConfirmationData ['carModel'];
		$carInfo = $carModel->attributes;
		$carInfo ['photo'] = Yii::$app->params ['imagesFolder'] . $carModel->photo1;
		$carInfo ['makeName'] = $carModel->make->value;
		$carInfo ['modelName'] = $carModel->model->value;

		$reserveConfirmationForm = new ReserveConfirmationForm ();
		if (($reserveConfirmationForm->load ( Yii::$app->request->post () ) && $reserveConfirmationForm->validate ())) {
			$session->destroy ( "reserveConfirmationData" );
			// Checking one more time if the car got rented in this period
			if (Booking::isCarRentedOnAPeriod ( $reserveConfirmationData ['carId'], $reserveConfirmationData ['startDate'], $reserveConfirmationData ['endDate'] )) {
				return $this->render ( 'carReservedSuccessfully', [
						'message' => 'We\'re sorry it seems the car just got rented during the selected period'
				] );
			}
			if (Yii::$app->user->identity->phonenumber != $reserveConfirmationForm->phonenumber) {
				$loggedInUser = new User();
				$loggedInUser->id = Yii::$app->user->id;
				$loggedInUser->setIsNewRecord(false);
				$loggedInUser->phonenumber =  $reserveConfirmationForm->phonenumber;
				$loggedInUser->save(true, ['phonenumber']);
			}
			$booking = new Booking ();
			$booking->car_id = $reserveConfirmationData ['carId'];
			$booking->date_start = $reserveConfirmationData ['startDate'];
			$booking->date_end = $reserveConfirmationData ['endDate'];
			$booking->renter_id = Yii::$app->user->id;
			$booking->owner_id = $carModel->owner_id;
			$booking->status = $carModel->book_instantly;
			if ($booking->save ()) {
				Yii::$app->mailer->compose ( [
						'html' => 'youBookedACar',
				], [
						'renter' => Yii::$app->user->identity,
						'owner' => $reserveConfirmationData ['carOwner'],
						'car'=>$carModel,
						'carInfo'=>$carInfo
				] )->setFrom ( [
						Yii::$app->params ['adminEmail'] => Yii::$app->name
				] )->setTo ( Yii::$app->user->identity->email )->setSubject ( 'Your renting request from uchaise' )->send ();

				Yii::$app->mailer->compose ( [
						'html' => 'someoneBookedYourCar',
				], [
						'renter' => Yii::$app->user->identity,
						'owner' => $reserveConfirmationData ['carOwner'],
						'car'=>$carModel,
						'carInfo'=>$carInfo
				] )->setFrom ( [
						Yii::$app->params ['adminEmail'] => Yii::$app->name
				] )->setTo ( Yii::$app->user->identity->email )->setSubject ( 'Someone from uchaise wants to rent your car' )->send ();

				Yii::$app->mailer->compose ( [
						'html' => 'someoneBookedACar',
				], [
						'renter' => Yii::$app->user->identity,
						'owner' => $reserveConfirmationData ['carOwner'],
						'car'=>$carModel,
						'carInfo'=>$carInfo
				] )->setFrom ( [
						Yii::$app->params ['adminEmail'] => Yii::$app->name
				] )->setTo ( Yii::$app->user->identity->email )->setSubject ( 'Someone rented a car from uchaise' )->send ();
				return $this->render ( 'carReservedSuccessfully', [
						'message' => ''
				] );
			}
		} else {
			return $this->render ( 'reserveCar', [
					'reserveConfirmationForm' => $reserveConfirmationForm,
					'carInfo' => $carInfo,
					'reservationDays' => Util::dateDiff ( $reserveConfirmationData ['startDate'], $reserveConfirmationData ['endDate'] )->days
			] );
		}
	}
}
?>