<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "rating".
 *
 * @property string $id
 * @property integer $user_id
 * @property integer $car_id
 * @property integer $rating
 * @property string $description
 * @property string $created_at
 */
class Rating extends \yii\db\ActiveRecord
{
	public $sum=0;
	public $count=0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {

        return 'rating';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'car_id', 'rating', 'description'], 'required'],
            [['user_id', 'car_id', 'rating'], 'integer'],
            [['description'], 'string'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'car_id' => 'Car ID',
            'rating' => 'Rating',
            'description' => 'Description',
            'created_at' => 'Created At',
        ];
    }
}
