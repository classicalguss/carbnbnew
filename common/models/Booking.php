<?php

namespace common\models;

use Yii;
use common\models\User;
use common\models\Car;

/**
 * This is the model class for table "booking".
 *
 * @property string $id
 * @property integer $car_id
 * @property integer $owner_id
 * @property integer $renter_id
 * @property string $date_created
 * @property string $date_start
 * @property string $date_end
 * @property integer $status
 */
class Booking extends \yii\db\ActiveRecord {
	public $count;
	/**
	 *
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'booking';
	}
	public function getOwner() {
		return $this->hasOne ( User::className (), [
				'id' => 'owner_id'
		] );
	}
	public function getRenter() {
		return $this->hasOne ( User::className (), [
				'id' => 'renter_id'
		] );
	}
	public function getCar() {
		return $this->hasOne ( Car::className (), [
				'id' => 'car_id'
		] );
	}
	public function fields() {
		return [
				'id',
				'car_id',
				'date_start',
				'date_end',
				'owner',
				'renter',
				'status',
				'statusMessage',
				'car',
				'delivery_time'
		];
	}
	/**
	 *
	 * @inheritdoc
	 */
	public function rules() {
		return [
				[
						[
								'car_id',
								'!owner_id',
								'!renter_id',
								'date_start',
								'date_end',
								'!status'
						],
						'required'
				],
				[
						[
								'car_id',
								'owner_id',
								'renter_id',
								'status'
						],
						'integer'
				],
				[
						[
								'date_start',
								'date_end',
								'delivery_time'
						],
						'safe'
				],
				[
						[
								'car_id'
						],
						'validateIsPublished'
				],
				[
						[
								'car_id'
						],
						'validateUserHavePendingBooking'
				],
				[
						[
								'date_start',
								'date_end'
						],
						'date',
						'format' => 'yyyy-MM-dd'
				],
				[
						'date_start',
						'compare',
						'compareAttribute' => 'date_end',
						'operator' => '<='
				]
		];
	}

	/**
	 *
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
				'id' => 'ID',
				'car_id' => 'Car ID',
				'owner_id' => 'Owner ID',
				'renter_id' => 'Renter ID',
				'date_created' => 'Date Created',
				'date_start' => 'Date Start',
				'date_end' => 'Date End',
				'status' => '0: Pending, 1: Approved, 2: Declined'
		];
	}
	public function validateIsPublished($attribute, $params, $validator) {
		$carModel = Car::findOne ( $this->$attribute );
		if (is_null ( $carModel ) || ! $carModel->is_published)
			$this->addError ( $attribute, 'This is not a published Car!' );
	}
	public function validateUserHavePendingBooking($attribute, $params, $validator) {
		$carModel = Booking::find ()->andFilterWhere ( [
				'renter_id' => $this->renter_id,
				'status' => 0
		] );
		if (is_null ( $carModel ))
			$this->addError ( $attribute, 'You already have a pending booking to this Car!' );
	}
	public function getStatusMessage() {
		if ($this->status == 0)
			return 'Be patient, waiting approval from Car Owner';
		else if ($this->status == 1)
			return 'Ok let\'s go! Rental Approved by ' . User::findOne ( $this->owner_id )->first_name;
		else
			return 'Sorry maybe next time, rental declined.';
	}

	/**
	 * check if car already reserved on the same period
	 *
	 * @param number $carId
	 * @param string $startDate
	 * @param string $endDate
	 * @return boolean
	 */
	public static function isCarRentedOnAPeriod($carId, $startDate, $endDate) {
		$overlappedRentsCountOnTheSameCar = Booking::find ()->select ( 'id' )->where ( [
				'between',
				'date_start',
				$startDate,
				$endDate
		] )->orWhere ( [
				'between',
				'date_end',
				$startDate,
				$endDate
		] )->andWhere ( [
				'status' => 1,
				'car_id' => $carId
		] )->all ();
		if (count ( $overlappedRentsCountOnTheSameCar ) > 0)
			return true;
		return false;
	}

	/**
	 * check whether the logged in user has requested to rent the car on a specific period
	 *
	 * @param number $carId
	 * @param string $startDate
	 * @param string $endDate
	 * @return boolean
	 */
	public static function isCarRequestedOnAPeriod($carId, $startDate, $endDate) {
		$overlappedRentsCountOnTheSameCar = Booking::find ()->select ( 'id' )->where ( [
				'between',
				'date_start',
				$startDate,
				$endDate
		] )->orWhere ( [
				'between',
				'date_end',
				$startDate,
				$endDate
		] )->andWhere ( [
				'status' => 0,
				'car_id' => $carId,
				'renter_id' => Yii::$app->user->id
		] )->all ();
		if (count ( $overlappedRentsCountOnTheSameCar ) > 0)
			return true;
		return false;
	}
}
