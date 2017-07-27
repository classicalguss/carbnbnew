<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "carmake".
 *
 * @property string $id
 * @property string $value
 */
class Carmake extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'carmake';
    }
    public function getCar()
    {
    	return $this->hasMany(\api\modules\v1\models\Car::className(), ['make_id' => 'id']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value'], 'required'],
            [['value'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
        ];
    }
}
