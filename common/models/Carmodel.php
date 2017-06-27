<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "carmodel".
 *
 * @property string $id
 * @property integer $make
 * @property integer $model
 * @property string $value
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
	public function fields()
	{
		return ['value'];
	}
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['make', 'model', 'value'], 'required'],
            [['make', 'model'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['make', 'model'], 'unique', 'targetAttribute' => ['make', 'model'], 'message' => 'The combination of Make and Model has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'make' => 'Make',
            'model' => 'Model',
            'value' => 'Value',
        ];
    }
}
