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
 * @property integer $area_id
 * @property string $description
 * @property integer $milage_limitation
 * @property string $insurance_tip
 * @property integer $owner_id
 * @property string $report
 * @property string $country_iso
 * @property integer $city_id
 * @property integer $make_id
 * @property integer $model_id
 * @property integer $is_featured
 * @property string $year_model
 * @property integer $gear_type_id
 * @property integer $number_of_doors
 * @property integer $number_of_seats
 * @property integer $gas_type_id
 * @property integer $type_id
 * @property string $color
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
 * @property string $currency
 * @property string $features
 * @property integer $odometer
 * @property integer $is_published
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
            [['price', 'area_id', 'description', 'milage_limitation', 'insurance_tip', 'owner_id', 'country_iso', 'city_id', 'make_id', 'model_id', 'gear_type_id', 'gas_type_id', 'type_id', 'color', 'currency', 'odometer'], 'required'],
            [['price', 'rent_it_now', 'area_id', 'milage_limitation', 'owner_id', 'city_id', 'make_id', 'model_id', 'is_featured', 'gear_type_id', 'number_of_doors', 'number_of_seats', 'gas_type_id', 'type_id', 'odometer', 'is_published'], 'integer'],
            [['created_at', 'year_model'], 'safe'],
            [['description', 'report'], 'string'],
            [['insurance_tip'], 'string', 'max' => 255],
            [['country_iso'], 'string', 'max' => 2],
            [['color'], 'string', 'max' => 30],
            [['rule_1', 'rule_2', 'rule_3', 'rule_4', 'photo1', 'photo2', 'photo3', 'photo4', 'photo5', 'photo6', 'features'], 'string', 'max' => 100],
            [['currency'], 'string', 'max' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'price' => 'Price',
            'created_at' => 'Created At',
            'rent_it_now' => 'Rent It Now',
            'area_id' => 'Area ID',
            'description' => 'Description',
            'milage_limitation' => 'Milage Limitation',
            'insurance_tip' => 'Insurance Tip',
            'owner_id' => 'Owner ID',
            'report' => 'Report',
            'country_iso' => 'Country Iso',
            'city_id' => 'City ID',
            'make_id' => 'Make ID',
            'model_id' => 'Model ID',
            'is_featured' => 'Is Featured',
            'year_model' => 'Year Model',
            'gear_type_id' => 'Gear Type ID',
            'number_of_doors' => 'Number Of Doors',
            'number_of_seats' => 'Number Of Seats',
            'gas_type_id' => 'Gas Type ID',
            'type_id' => 'Type ID',
            'color' => 'Color',
            'rule_1' => 'Rule 1',
            'rule_2' => 'Rule 2',
            'rule_3' => 'Rule 3',
            'rule_4' => 'Rule 4',
            'photo1' => 'Photo1',
            'photo2' => 'Photo2',
            'photo3' => 'Photo3',
            'photo4' => 'Photo4',
            'photo5' => 'Photo5',
            'photo6' => 'Photo6',
            'currency' => 'Currency',
            'features' => 'Features',
            'odometer' => 'Odometer',
            'is_published' => 'Is Published',
        ];
    }
}
