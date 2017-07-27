<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "booking".
 *
 * @property string $id
 * @property integer $car_id
 * @property integer $owner_id
 * @property integer $renter_id
 * @property string $date_created
 * @property string $date_start
 * @property string $date_end
 * @property integer $status
 */
class Booking extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'booking';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['car_id', 'owner_id', '!renter_id', 'date_start', 'date_end', '!status'], 'required'],
            [['car_id', 'owner_id', 'renter_id', 'status'], 'integer'],
            [['date_created', 'date_start', 'date_end'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'car_id' => 'Car ID',
            'owner_id' => 'Owner ID',
            'renter_id' => 'Renter ID',
            'date_created' => 'Date Created',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'status' => '0: Pending, 1: Approved, 2: Declined',
        ];
    }
}
