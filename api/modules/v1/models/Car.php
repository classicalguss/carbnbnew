<?php

namespace api\modules\v1\models;

use Yii;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "car".
 *
 * @property string $id
 * @property string $cover_photo
 * @property integer $price
 * @property string $created_at
 * @property integer $rent_it_now
 * @property string $address
 * @property string $description
 * @property integer $milage_limitation
 * @property string $insurance_tip
 * @property integer $owner_id
 * @property string $report
 * @property string $country
 * @property string $city
 * @property string $maker
 * @property string $model
 * @property integer $is_featured
 * @property string $year_model
 * @property string $gear_type
 * @property integer $number_of_doors
 * @property integer $number_of_seats
 * @property integer $gas
 * @property string $type
 * @property string $color
 * @property string $rule_1
 * @property string $rule_2
 * @property string $rule_3
 * @property string $rule_4
 * @property string $interior_photo
 * @property string $back_photo
 * @property string $front_photo
 * @property string $side_photo
 * @property string $optional_photo_1
 * @property string $optional_photo2
 */
class Car extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'car';
	}
	
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
				[['cover_photo', 'price', 'address', 'description', 'milage_limitation', 'insurance_tip', 'owner_id', 'report', 'country', 'city', 'maker', 'model', 'type', 'color', 'rule_1', 'rule_2', 'rule_3', 'rule_4', 'interior_photo', 'back_photo', 'front_photo', 'side_photo', 'optional_photo_1', 'optional_photo2'], 'required'],
				[['price', 'rent_it_now', 'milage_limitation', 'owner_id', 'is_featured', 'number_of_doors', 'number_of_seats', 'gas'], 'integer'],
				[['created_at', 'year_model'], 'safe'],
				[['description', 'report'], 'string'],
				[['cover_photo', 'address', 'insurance_tip', 'model'], 'string', 'max' => 255],
				[['country', 'city', 'maker'], 'string', 'max' => 50],
				[['gear_type', 'type', 'color'], 'string', 'max' => 30],
				[['rule_1', 'rule_2', 'rule_3', 'rule_4', 'interior_photo', 'back_photo', 'front_photo', 'side_photo', 'optional_photo_1', 'optional_photo2'], 'string', 'max' => 100],
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
				'id' => 'ID',
				'cover_photo' => 'Cover Photo',
				'price' => 'Price',
				'created_at' => 'Created At',
				'rent_it_now' => 'Rent It Now',
				'address' => 'Address',
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
				'optional_photo2' => 'Optional Photo2',
		];
	}
}