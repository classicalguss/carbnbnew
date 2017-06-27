<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "location".
 *
 * @property string $id
 * @property string $iso
 * @property integer $city_id
 * @property integer $area_id
 * @property string $value
 */
class Location extends \yii\db\ActiveRecord
{
	public function fields() {
		return ['value'];
	}
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'location';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iso', 'city_id', 'area_id', 'value'], 'required'],
            [['city_id', 'area_id'], 'integer'],
            [['iso'], 'string', 'max' => 2],
            [['value'], 'string', 'max' => 255],
            [['iso', 'city_id', 'area_id'], 'unique', 'targetAttribute' => ['iso', 'city_id', 'area_id'], 'message' => 'The combination of Iso, City ID and Area ID has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'iso' => 'Iso',
            'city_id' => 'City ID',
            'area_id' => 'Area ID',
            'value' => 'Value',
        ];
    }
}
