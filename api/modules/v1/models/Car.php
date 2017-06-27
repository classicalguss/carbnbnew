<?php

namespace api\modules\v1\models;

use Yii;
use \yii\db\ActiveRecord;
use common\models\Location;
use common\models\Carmodel;

/**
 * This is the model class for table "car".
 *
 * @property string $id
 * @property integer $price
 * @property string $created_at
 * @property integer $rent_it_now
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
 * @properties integer $odometer
 */
class Car extends \yii\db\ActiveRecord {
	public $photoFile1; // The file instance of the model
	public $photoFile2; // The file instance of the model
	public $photoFile3; // The file instance of the model
	public $photoFile4; // The file instance of the model
	public $photoFile5; // The file instance of the model
	public $photoFile6; // The file instance of the model
	
	/**
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
	public static function featuresArray() {
		return [
				0=>'4G LTE',
				1=>'Audio Input',
				2=>'Booster Seat',
				3=>'Air Bag',
				4=>'Sunroof',
				5=>'Heated Seats',
				6=>'Bluetooth',
				7=>'Part Assist',
				8=>'GPS',
				9=>'Power Steering',
				10=>'USB',
				11=>'ABS'
				
		];
	}
	public static function gearArray() {
		return [
				0=>'Automatic',
				1=>'Manual'
		];
	}
	public static function typeArray() {
		return [
				0=>'Sedan',
				1=>'Coupe',
				2=>'SUVS',
				3=>'Pickup',
				4=>'Vans',
				5=>'Jeep'
		];
	}
	public static function gasArray() {
		return [
				0=>'Diesel',
				1=>'Hybrid',
				2=>'Electric',
				3=>'Gas',
		];
	}
	public static function odometerArray() {
		return [
				0=>'0k-80 Kilometers',
				1=>'80k-160 Kilometers',
				2=>'160k-200 Kilometers',
				3=>'200k+ Kilometers',
		];
	}
	public static function colorArray() {
		return [
				0=>'Red',
				1=>'White',
				2=>'Blue',
				3=>'Silver',
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
				'gear_type_id' => self::gearArray()[$this->gear_type_id],
				'number_of_doors' => $this->number_of_doors,
				'number_of_seats' => $this->number_of_seats,
				'gas_type_id' => self::gasArray()[$this->gas_type_id],
				'type_id' => self::typeArray()[$this->type_id]
		];
	}
	public function getRatings() {
		return $this->hasMany ( Rating::className (), [
				'car_id' => 'id'
		] );
	}
	public function getCarModel() {
		return $this->hasOne ( Carmodel::className(), [
				'make' => 'make_id',
				'model'=>'model_id'
		] );
	}
	public function getLocation() {
		return $this->hasOne (Location::className(),[
				'iso'=>'country_iso',
				'city_id'=>'city_id',
				'area_id'=>'area_id'
		]);
	}
	public function getFeaturesArray() {
		$returnArray = [];
		$featuresArray = explode(',',$this->features);
		foreach ($featuresArray as $feature)
		{
			if (isset(self::featuresArray()[$feature]))
				$returnArray[] = self::featuresArray()[$feature];
		}
		return $returnArray;
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
				'color',
				'odometer'
		];
	}
	public function extraFields() {
		return [ 
				'images',
				'user',
				'rules',
				'featuresArray',
				'ratings',
				'properties',
				'carModel'
		];
	}
	
	/**
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
								'owner_id',
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
						[ 
								'price',
								'rent_it_now',
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
								'odometer'
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
						'max'=>255
				],
				[
						[
								'country_iso'
						],
						'string',
						'max'=> 2
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
								'rule_4',
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
								'photo1',
								'photo2',
								'photo3',
								'photo4',
								'photo5',
								'photo6' 
						],
						'file',
						'skipOnEmpty' => true,
						'extensions' => 'png,jpg,jpeg' 
				],
				[
						[
								'report'
						],
						'safe'
				]
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [ 
				'id' => 'ID',
				'price' => 'Price',
				'created_at' => 'Created At',
				'rent_it_now' => 'Rent It Now',
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
			$this->photo1 = time () . '_' . $this->photoFile1->name;
		
		if ($this->photoFile2!== null)
			$this->photo2 = time () . '_' . $this->photoFile2->name;
		
		if ($this->photoFile3!== null)
			$this->photo3 = time () . '_' . $this->photoFile3->name;
		
		if ($this->photoFile4= null)
			$this->photo4 = time () . '_' . $this->photoFile4->name;
		
		if ($this->photoFile5!== null)
			$this->photo5 = time () . '_' . $this->photoFile5->name;
		
		if ($this->photoFile6!== null)
			$this->photo6 = time () . '_' . $this->photoFile6->name;
		
		return true;
	}
	public function upload() {
		if ($this->validate ()) {
			
			if ($this->photoFile1)
				$this->photoFile1->saveAs ( '../../uploads/' . $this->photo1 );
			
			if ($this->photoFile2)
				$this->photoFile2->saveAs ( '../../uploads/' . $this->photo2 );
			
			if ($this->photoFile3)
				$this->photoFile3->saveAs ( '../../uploads/' . $this->photo3);
			
			if ($this->photoFile4)
				$this->photoFile4->saveAs ( '../../uploads/' . $this->photo4);
			
			if ($this->photoFile5)
				$this->photoFile5->saveAs ( '../../uploads/' . $this->photo5);
			
			if ($this->photoFile6)
				$this->photoFile6->saveAs ( '../../uploads/' . $this->photo6);
			
			return true;
		} else {
			return false;
		}
	}
	public function afterFind() {
		$this->odometer = self::odometerArray()[$this->odometer];
		$this->color = self::colorArray()[$this->color];
		return parent::afterFind();
	}
}