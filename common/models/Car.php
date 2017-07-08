<?php

namespace common\models;

use Yii;

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
 * @property string $country
 * @property string $city
 * @property string $make //Kia, Ferrari
 * @property string $model //Cerrato, C200
 * @property integer $is_featured
 * @property string $year_model //2017
 * @property string $gear_type_id //or Transmission
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
 */
class Car extends \yii\db\ActiveRecord {
	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'car';
	}
	
	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
				[
						[
								'features',
								'each',
								'rule'=>[
										['integer']
								]
						]
				],
				[ 
						[ 
								'price',
								'area_id',
								'description',
								'milage_limitation',
								'insurance_tip',
								'owner_id',
								'report',
								'country',
								'city',
								'make',
								'model',
								'type',
								'color' 
						],
						'required' 
				],
				[ 
						[ 
								'insurance_tip',
								'price',
								'rent_it_now',
								'milage_limitation',
								'owner_id',
								'is_featured',
								'number_of_doors',
								'number_of_seats',
								'gas',
								'area_id' 
						],
						'integer' 
				],
				[ 
						[ 
								'created_at',
								'year_model' 
						],
						'safe' 
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
								'model' 
						],
						'string',
						'max' => 255 
				],
				[ 
						[ 
								'country',
								'city',
								'maker' 
						],
						'string',
						'max' => 50 
				],
				[ 
						[ 
								'gear_type',
								'type',
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
								'interior_photo',
								'back_photo',
								'front_photo',
								'side_photo',
								'optional_photo_1',
								'optional_photo_2' 
						],
						'string',
						'max' => 100 
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
				'country' => 'Country',
				'city' => 'City',
				'maker' => 'Maker',
				'model' => 'Model',
				'is_featured' => 'Is Featured',
				'year_model' => 'Year Model',
				'gear_type' => 'Gear Type',
				'number_of_doors' => 'Number Of Doors',
				'number_of_seats' => 'Number Of Seats',
				'gas' => 'Gas',
				'type' => 'Type',
				'color' => 'Color',
				'rule_1' => 'Rule 1',
				'rule_2' => 'Rule 2',
				'rule_3' => 'Rule 3',
				'rule_4' => 'Rule 4',
				'interior_photo' => 'Interior Photo',
				'back_photo' => 'Back Photo',
				'front_photo' => 'Front Photo',
				'side_photo' => 'Side Photo',
				'optional_photo_1' => 'Optional Photo 1',
				'optional_photo_2' => 'Optional Photo2' 
		];
	}
	public static function gasArray() {
		return [ 
				'1' => '90',
				'2' => '95',
				'3' => '98',
				'4' => 'Hybrid',
				'5' => 'Tesla',
				'6' => 'Other' 
		];
	}
}
