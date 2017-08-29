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

	public function getCar()
	{
		return $this->hasMany(\frontend\models\Car::className(), ['model_id' => 'id']);
	}
	public function getMake()
	{
		return $this->hasOne(Carmake::className(), ['make_id' => 'id']);
	}
	public static function getCarMakeModels($id)
	{
		$res = [];
		if (empty($id))
			return $res;
		foreach (self::find()->select(['id','value'])->where(['make_id'=>$id])->all() as $carModel)
			$res[$carModel->id]=$carModel->value;
		return $res;
	}
}
