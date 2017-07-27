<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property string $id
 * @property string $country_iso
 * @property string $value
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_iso', 'value'], 'required'],
            [['country_iso'], 'string', 'max' => 2],
            [['value'], 'string', 'max' => 50],
        ];
    }

    public function fields()
    {
    	return parent::fields();
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'country_iso' => 'Country Iso',
            'value' => 'Value',
        ];
    }
}
