<?php

namespace api\modules\v1\models;

use Yii;
use yii\db\ActiveRecord;

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
 */
class Car extends ActiveRecord
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
            [['cover_photo', 'price', 'address', 'description', 'milage_limitation', 'insurance_tip', '!owner_id', 'report','city','country','maker','model'], 'required'],
            [['price', 'rent_it_now', 'milage_limitation', 'owner_id'], 'integer'],
            [['created_at'], 'safe'],
            [['description', 'report'], 'string'],
            [['cover_photo', 'address', 'insurance_tip'], 'string', 'max' => 255],
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
        		'maker' => 'Maker',
        ];
    }
}
