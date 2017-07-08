<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "area".
 *
 * @property string $id
 * @property integer $city_id
 * @property string $value
 */
class Area extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city_id', 'value'], 'required'],
            [['city_id'], 'integer'],
            [['value'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city_id' => 'City ID',
            'value' => 'Value',
        ];
    }
}
