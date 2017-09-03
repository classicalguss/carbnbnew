<?php

namespace common\models;

use Yii;
use frontend\models\Car;
use common\models\Carmodel;

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
    	return $this->hasMany(Car::className(), ['make_id' => 'id']);
    }
    public function getModel()
    {
    	return $this->hasMany(Carmodel::className(), ['id' => 'make_id']);
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

	public static function getFeaturedCarMakesIds($limit=10)
	{
		$res = [];
		$featuredMakes = self::find()->select('id')->where('is_featured = 1')->limit($limit)->all();
		foreach ($featuredMakes as $make)
		{
			$res[] = $make->id;
		}
		return $res;
	}

	public static function getAllCarMakes()
	{
		$res = [];
		foreach (self::find()->select(['id','value'])->all() as $carMake)
			$res[$carMake->id]=$carMake->value;
		return $res;
	}
}
