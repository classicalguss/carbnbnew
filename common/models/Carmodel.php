<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "carmodel".
 *
 * @property string $id
 * @property integer $make_id
 * @property integer $value
 */
class Carmodel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'carmodel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['make_id', 'value'], 'required'],
            [['make_id'], 'integer'],
        	[['value'],'string','min'=>2,'max'=>255],
        	[['value'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'make_id' => 'Make ID',
            'value' => 'Value',
        ];
    }
}
