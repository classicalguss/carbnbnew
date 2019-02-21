<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\Location;
use common\models\Carmodel;
use common\models\Area;
use common\models\City;
use common\models\Util;
use common\models\Carmake;
use common\models\User;
use common\models\Booking;

/**
 * This is the model class for table "car".
 *
 * @property string $id
 * @property integer $price
 * @property string $created_at
 * @property string $area_id //Will be the area within the city
 * @property string $description
 * @property integer $milage_limitation
 * @property integer $insurance_tip //Boolean 0 or 1
 * @property integer $owner_id
 * @property string $report
 * @property string $country_iso
 * @property string $city_id
 * @property integer $make_id //0: Kia, 2: Ferrari
 * @property integer $model_id //0: Cerrato, 1: C200
 * @property integer $is_featured
 * @property integer $year_model //2017
 * @property integer $gear_type_id //or Transmission
 * @property integer $number_of_doors //1,2,3,4,5
 * @property integer $number_of_seats //1,2,3,4,5
 * @property integer $gas_type_id //0: Diesel, 1: Gas, 2: Electric, 3: Hybrid
 * @property integer $type_id 0: Sedan, 1: Suv etc...
 * @property integer $color_id 0: Green, 1: Blue, etc...
 * @property string $rule_1
 * @property string $rule_2
 * @property string $rule_3
 * @property string $rule_4
 * @property string $photo1
 * @property string $photo2
 * @property string $photo3
 * @property string $photo4
 * @property string $photo5
 * @property string $photo6
 * @property string $license_plate
 * @property string $currency
 * @property integer $notice_period
 * @property string $features
 * @property integer $odometer
 * @property integer $is_published
 * @property integer $book_instantly
 * @property string $license_plate_number
 * @property integer $delivery
 */
class Car extends \yii\db\ActiveRecord {
	public $photoFile1; // The file instance of the model
	public $photoFile2; // The file instance of the model
	public $photoFile3; // The file instance of the model
	public $photoFile4; // The file instance of the model
	public $photoFile5; // The file instance of the model
	public $photoFile6; // The file instance of the model
	public $photoFile1Array;
	public $colorText;
	public $odometerText;
	public $max_price;
	/**
	 *
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'car';
	}
	public function getUser() {
		return $this->hasOne ( User::className (), [
				'id' => 'owner_id'
		] );
	}
	public function getBookings() {
		return $this->hasMany ( Booking::className (), [
				'car_id' => 'id'
		] );
	}
	public function getRate() {
		return $this->hasMany ( Rating::className (), [
				'car_id' => 'id'
		] )->average ( 'rating' );
	}
	public function getReviews() {
		return $this->hasMany ( Rating::className (), [
				'car_id' => 'id'
		] )->count ( 'car_id' );
	}
	public function getCity() {
		return $this->hasOne ( City::className (), [
				'id' => 'city_id'
		] );
	}
	public static function featuresArray() {
		return [
				0 => '4G LTE',
				1 => 'Audio Input',
				2 => 'Booster Seat',
				3 => 'Air Bag',
				4 => 'Sunroof',
				5 => 'Heated Seats',
				6 => 'Bluetooth',
				7 => 'Park Assist',
				8 => 'GPS',
				9 => 'Power Steering',
				10 => 'USB',
				11 => 'ABS'
		];
	}
	public static function gearArray() {
		return [
				0 => 'Automatic',
				1 => 'Manual'
		];
	}
	public static function typeArray() {
		return [
				0 => 'Sedan',
				1 => 'Coupe',
				2 => 'SUVS',
				3 => 'Pickup',
				4 => 'Vans',
				5 => 'Jeep'
		];
	}
	public static function gasArray() {
		return [
				3 => 'Gas',
				1 => 'Hybrid',
				2 => 'Electric',
				0 => 'Diesel'
		];
	}
	public static function odometerArray() {
		return [
				0 => '0k-80 Kilometers',
				1 => '80k-160 Kilometers',
				2 => '160k-200 Kilometers',
				3 => '200k+ Kilometers'
		];
	}
	public function getImages() {
		return [
				'photoFile1' => [
						'fileName' => $this->photo1,
						'path' => Yii::$app->params ['imagesFolder'] . $this->photo1
				],
				'photoFile2' => [
						'fileName' => $this->photo2,
						'path' => Yii::$app->params ['imagesFolder'] . $this->photo2
				],
				'photoFile3' => [
						'fileName' => $this->photo3,
						'path' => Yii::$app->params ['imagesFolder'] . $this->photo3
				],
				'photoFile4' => [
						'fileName' => $this->photo4,
						'path' => Yii::$app->params ['imagesFolder'] . $this->photo4
				],
				'photoFile5' => [
						'fileName' => $this->photo5,
						'path' => Yii::$app->params ['imagesFolder'] . $this->photo5
				],
				'photoFile6' => [
						'fileName' => $this->photo6,
						'path' => Yii::$app->params ['imagesFolder'] . $this->photo6
				]
		];
	}
	public function getPhotos() {
		$res = [ ];
		foreach ( [
				$this->photo1,
				$this->photo2,
				$this->photo3,
				$this->photo4,
				$this->photo5,
				$this->photo6
		] as $photo ) {
			if (! empty ( $photo ))
				$res [$photo] = Yii::$app->params ['imagesFolder'] . $photo;
		}
		return $res;
	}
	public function getRules() {
		return [
				$this->rule_1,
				$this->rule_2,
				$this->rule_3,
				$this->rule_4
		];
	}
	public function getProperties() {
		return [
				'gear_type_id' => (isset ( self::gearArray () [$this->gas_type_id] ) ? self::gearArray () [$this->gear_type_id] : "Other"),
				'number_of_doors' => $this->number_of_doors,
				'number_of_seats' => $this->number_of_seats,
				'gas_type_id' => (isset ( self::gasArray () [$this->gas_type_id] ) ? self::gasArray () [$this->gas_type_id] : "Other"),
				'type_id' => (isset ( self::typeArray () [$this->type_id] ) ? self::typeArray () [$this->type_id] : "Other")
		];
	}
	public function getRatings() {
		return $this->hasMany ( \frontend\models\Rating::className (), [
				'car_id' => 'id'
		] );
	}
	public function getCarModel() {
		return [
				'make' => Carmake::findOne ( [
						'id' => $this->make_id
				] ),
				'model' => Carmodel::findOne ( [
						'id' => $this->model_id
				] )
		];
	}
	public function getLocation() {
		$city = City::findOne ( [
				'id' => $this->city_id
		] );
		$area = Area::findOne ( [
				'id' => $this->area_id
		] );
		if ($city !== null && $area !== null) {
			return 'UAE - ' . $city->value . ' - ' . $area->value;
		} else {
			return "";
		}
	}
	public function getFeaturesArray() {
		$returnArray = [ ];
		$featuresArray = explode ( ',', $this->features );
		foreach ( $featuresArray as $feature ) {
			if (isset ( self::featuresArray () [$feature] ))
				$returnArray [] = self::featuresArray () [$feature];
		}
		return $returnArray;
	}
	public function getAssociateFeatures() {
		$res = [ ];
		$featuresArray = explode ( ',', $this->features );
		foreach ( $featuresArray as $feature ) {
			if (isset ( self::featuresArray () [$feature] ))
				$res [$feature] = self::featuresArray () [$feature];
		}
		return $res;
	}
	public function fields() {
		return [
				'id',
				'price',
				'area_id',
				'country_iso',
				'city_id',
				'make_id',
				'model_id',
				'colorText',
				'odometerText',
				'is_published',
				'photoFile1Array',
				'description',
				'year_model',
				'ratings',
				'type_id',
				'owner_id',
				'carModel',
				'rate',
				'milage_limitation'
		];
	}
	public static function getFeaturedCars($limit = 20) {
		return self::find ()->joinWith ( 'make', true, 'INNER JOIN' )->joinWith ( 'model', true, 'INNER JOIN' )->
		// ->joinWith('ratings')
		where ( 'carmake.id = carmodel.make_id AND car.is_featured = 1' )->limit ( $limit )->all ();
	}
	public static function getAllRatings($carIds = []) {
		if (empty ( $carIds ))
			return [ ];
		settype ( $carIds, 'array' );
		$return = [ ];
		$ratings = Rating::find ()->select ( [
				'car_id',
				'sum(rating) as sum, count(rating) as count'
		] )->where ( [
				'car_id' => $carIds
		] )->groupBy ( 'car_id' )->all ();
		foreach ( $ratings as $row )
			$return [$row->car_id] = [
					$row->sum,
					$row->count
			];
		return $return;
	}
	public static function getRecentlyListed($limit = 20, $excludedCarIds = []) {
		return self::find ()->joinWith ( 'make', true, 'INNER JOIN' )->joinWith ( 'model', true, 'INNER JOIN' )->where ( 'carmake.id = carmodel.make_id and is_published = 1' )->andFilterWhere ( [
				'not in',
				'car.id',
				$excludedCarIds
		] )->orderBy ( 'created_at DESC' )->limit ( $limit )->all ();
	}
	public static function getFeaturedCarMakes($makesLimit = 10, $carsLimit = 10) {
		$featuredCarMakesIds = Carmake::getFeaturedCarMakesIds ( $makesLimit );
		if (count ( $featuredCarMakesIds ) == 0)
			return [
					'cars' => [ ],
					'carIds' => [ ]
			];

		$tmp = self::find ()->joinWith ( 'make', true, 'INNER JOIN' )->joinWith ( 'model', true, 'INNER JOIN' )->where ( 'carmake.id = carmodel.make_id' )->andWhere ( [
				'car.make_id' => $featuredCarMakesIds
		] )->orderBy ( 'created_at DESC' )->limit ( $carsLimit )->all ();

		$carIds = [ ];
		$carResults = [ ];
		foreach ( $tmp as $car ) {
			$carIds [] = $car->id;
			$make = $car->make->value;
			$carResults [$make] [] = $car;
		}
		return [
				'cars' => $carResults,
				'carIds' => $carIds
		];
	}
	public function getCarRatings() {
		return Rating::find ()->where ( 'car_id=:id', [
				':id' => $this->id
		] )->all ();
	}
	public function getMake() {
		return $this->hasOne ( Carmake::className (), [
				'id' => 'make_id'
		] );
	}
	public function getModel() {
		return $this->hasOne ( Carmodel::className (), [
				'id' => 'model_id'
		] );
	}
	public function getSimilar() {
		return Car::find ()->where ( 'type_id=:area_id AND id!=:id', [
				':area_id' => $this->area_id,
				':id' => $this->id
		] )->limit ( 5 )->all ();
	}
	public function extraFields() {
		return [
				'images',
				'user',
				'rules',
				'featuresArray',
				'ratings',
				'properties',
				'location',
				'similar',
				'make'
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
								'price',
								'area_id',
								'description',
								'milage_limitation',
								'insurance_tip',
								'!owner_id',
								'country_iso',
								'city_id',
								'make_id',
								'model_id',
								'type_id',
								'color',
								'currency',
								'year_model',
								'gear_type_id',
								'gas_type_id',
								'odometer'
						],
						'required'
				],
				[
						'photoFile1',
						'required',
						'on' => [
								'create'
						]
				],
				[
						'photoFile1',
						'file',
						'skipOnEmpty' => false,
						'extensions' => 'png,jpg,jpeg',
						'on' => [
								'create'
						]
				],
				[
						[
								'price',
								'milage_limitation',
								'owner_id',
								'is_featured',
								'number_of_doors',
								'number_of_seats',
								'gas_type_id',
								'area_id',
								'insurance_tip',
								'city_id',
								'make_id',
								'model_id',
								'year_model',
								'gear_type_id',
								'type_id',
								'odometer',
								'color',
								'is_published'
						],
						'integer'
				],
				[
						[
								'description',
								'report'
						],
						'string'
				],
				[
						[
								'report'
						],
						'string',
						'max' => 255
				],
				[
						[
								'country_iso'
						],
						'string',
						'max' => 2
				],
				[
						[
								'color'
						],
						'string',
						'max' => 30
				],
				[
						[
								'rule_1',
								'rule_2',
								'rule_3',
								'rule_4'
						],
						'string',
						'max' => 100
				],
				[
						[
								'currency'
						],
						'string',
						'max' => 3
				],
				[
						[
								'photoFile2',
								'photoFile3',
								'photoFile4',
								'photoFile5',
								'photoFile6'
						],
						'file',
						'skipOnEmpty' => true,
						'extensions' => 'png,jpg,jpeg'
				],
				[
						[
								'report',
								'book_instantly',
								'delivery',
								'license_plate_number'
						],
						'safe'
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
				'price' => 'Price',
				'created_at' => 'Created At',
				'area' => 'Area',
				'description' => 'Description',
				'milage_limitation' => 'Milage Limitation',
				'insurance_tip' => 'Insurance Tip',
				'owner_id' => 'Owner ID',
				'report' => 'Report',
				'country_iso' => 'Country Iso',
				'city_id' => 'City',
				'make_id' => 'Maker',
				'model_id' => 'Model',
				'is_featured' => 'Is Featured',
				'year_model' => 'Year Model',
				'gear_type_id' => 'Gear Type',
				'number_of_doors' => 'Number Of Doors',
				'number_of_seats' => 'Number Of Seats',
				'gas_type_id' => 'Gas',
				'type_id' => 'Type',
				'color' => 'Color',
				'rule_1' => 'Rule 1',
				'rule_2' => 'Rule 2',
				'rule_3' => 'Rule 3',
				'rule_4' => 'Rule 4',
				'photo1' => 'photo1 Photo',
				'photo2' => 'photo2 Photo',
				'photo3' => 'photo3 Photo',
				'photo4' => 'photo4 Photo',
				'photo5' => 'photo5 Photo',
				'photo6' => 'photo6 Photo'
		];
	}
	public function beforeSave($insert) {
		if (! parent::beforeSave ( $insert )) {
			return false;
		}

		if ($this->photoFile1 !== null)
			$this->photo1 = Util::generateRandomString () . '_' . $this->photoFile1->name;

		if ($this->photoFile2 !== null)
			$this->photo2 = Util::generateRandomString () . '_' . $this->photoFile2->name;

		if ($this->photoFile3 !== null)
			$this->photo3 = Util::generateRandomString () . '_' . $this->photoFile3->name;

		if ($this->photoFile4 = null)
			$this->photo4 = Util::generateRandomString () . '_' . $this->photoFile4->name;

		if ($this->photoFile5 !== null)
			$this->photo5 = Util::generateRandomString () . '_' . $this->photoFile5->name;

		if ($this->photoFile6 !== null)
			$this->photo6 = Util::generateRandomString () . '_' . $this->photoFile6->name;

		return true;
	}
	public function upload() {
		if ($this->validate ()) {

			if ($this->photoFile1)
				$this->photoFile1->saveAs ( '../../uploads/' . $this->photo1 );

			if ($this->photoFile2)
				$this->photoFile2->saveAs ( '../../uploads/' . $this->photo2 );

			if ($this->photoFile3)
				$this->photoFile3->saveAs ( '../../uploads/' . $this->photo3 );

			if ($this->photoFile4)
				$this->photoFile4->saveAs ( '../../uploads/' . $this->photo4 );

			if ($this->photoFile5)
				$this->photoFile5->saveAs ( '../../uploads/' . $this->photo5 );

			if ($this->photoFile6)
				$this->photoFile6->saveAs ( '../../uploads/' . $this->photo6 );

			return true;
		} else {
			return false;
		}
	}
	public function afterFind() {
		if ($this->id !== null) {
			$this->odometerText = self::odometerArray () [$this->odometer];
			$this->colorText = self::colorArray () [$this->color];
			$this->photoFile1Array = [
					'fileName' => $this->photo1,
					'path' => Yii::$app->params ['imagesFolder'] . $this->photo1
			];
		}
		return parent::afterFind ();
	}
	public static function colorArray() {
		return [
				0 => 'White',
				1 => 'Black',
				2 => 'Silver',
				3 => 'Gray',
				4 => 'Red',
				5 => 'Blue',
				6 => 'Brown/Biege',
				7 => 'Green',
				8 => 'Yellow/Gold',
				9 => 'Others'
		];
	}
}