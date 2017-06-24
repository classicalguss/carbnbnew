<?php

namespace api\modules\v1\models;

use Yii;
use \yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * This is the model class for table "car".
 *
 * @property string $id
 * @property string $cover_photo
 * @property integer $price
 * @property string $created_at
 * @property integer $rent_it_now
 * @property string $address
 * @property string $description
 * @property integer $milage_limitation
 * @property string $insurance_tip
 * @property integer $owner_id
 * @property string $report
 * @property string $country
 * @property string $city
 * @property string $maker
 * @property string $model
 * @property integer $is_featured
 * @property string $year_model
 * @property string $gear_type
 * @property integer $number_of_doors
 * @property integer $number_of_seats
 * @property integer $gas
 * @property string $type
 * @property string $color
 * @property string $rule_1
 * @property string $rule_2
 * @property string $rule_3
 * @property string $rule_4
 * @property string $interior_photo
 * @property string $back_photo
 * @property string $front_photo
 * @property string $side_photo
 * @property string $optional_photo_1
 * @property string $optional_photo_2
 */
class Car extends \yii\db\ActiveRecord {
	public $coverPhoto; // The file instance of the model
	public $interiorPhoto; // The file instance of the model
	public $frontPhoto; // The file instance of the model
	public $sidePhoto; // The file instance of the model
	public $backPhoto; // The file instance of the model
	public $optionalPhoto1; // The file instance of the model
	public $optionalPhoto2; // The file instance of the model
	
	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'car';
	}
	public function getUser() {
		return $this->hasOne ( User::className (), [ 
				'id' => 'owner_id' 
		] );
	}
	public function getImages() {
		return [ 
				'coverPhoto' => [ 
						'fileName' => $this->cover_photo,
						'path' => Yii::$app->params ['imagesFolder'] . $this->cover_photo 
				],
				'interiorPhoto' => [ 
						'fileName' => $this->cover_photo,
						'path' => Yii::$app->params ['imagesFolder'] . $this->interior_photo 
				],
				'backPhoto' => [ 
						'fileName' => $this->cover_photo,
						'path' => Yii::$app->params ['imagesFolder'] . $this->back_photo 
				],
				'frontPhoto' => [ 
						'fileName' => $this->cover_photo,
						'path' => Yii::$app->params ['imagesFolder'] . $this->front_photo 
				],
				'sidePhoto' => [ 
						'fileName' => $this->cover_photo,
						'path' => Yii::$app->params ['imagesFolder'] . $this->side_photo 
				],
				'optionalPhoto1' => [ 
						'fileName' => $this->cover_photo,
						'path' => Yii::$app->params ['imagesFolder'] . $this->optional_photo_1 
				],
				'optionalPhoto2' => [ 
						'fileName' => $this->cover_photo,
						'path' => Yii::$app->params ['imagesFolder'] . $this->optional_photo_2 
				] 
		];
	}
	public function getRules() {
		return [ 
				$this->rule_1,
				$this->rule_2,
				$this->rule_3,
				$this->rule_4 
		];
	}
	public function getFeatures() {
		return [ 
				'gear_type' => $this->gear_type,
				'number_of_doors' => $this->number_of_doors,
				'number_of_seats' => $this->number_of_seats,
				'gas' => $this->gas 
		];
	}
	public function getRatings() {
		return $this->hasMany ( Rating::className (), [
				'car_id' => 'id'
		] );
	}
	public function fields() {
		return [ 
				'id',
				'price',
				'address',
				'country',
				'city',
				'maker',
				'model',
				'color' 
		];
	}
	public function extraFields() {
		return [ 
				'images',
				'user',
				'rules',
				'features',
				'ratings'
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [ 
				[ 
						[ 
								'price',
								'address',
								'description',
								'milage_limitation',
								'insurance_tip',
								'owner_id',
								'report',
								'country',
								'city',
								'maker',
								'model',
								'type',
								'color',
								'currency' 
						],
						'required' 
				],
				[ 
						[ 
								'price',
								'rent_it_now',
								'milage_limitation',
								'owner_id',
								'is_featured',
								'number_of_doors',
								'number_of_seats',
								'gas' 
						],
						'integer' 
				],
				[ 
						[ 
								'created_at',
								'year_model' 
						],
						'safe' 
				],
				[ 
						[ 
								'description',
								'report' 
						],
						'string' 
				],
				[ 
						[ 
								'cover_photo',
								'address',
								'insurance_tip',
								'model' 
						],
						'string',
						'max' => 255 
				],
				[ 
						[ 
								'country',
								'city',
								'maker' 
						],
						'string',
						'max' => 50 
				],
				[ 
						[ 
								'gear_type',
								'type',
								'color' 
						],
						'string',
						'max' => 30 
				],
				[ 
						[ 
								'rule_1',
								'rule_2',
								'rule_3',
								'rule_4',
								'interior_photo',
								'back_photo',
								'front_photo',
								'side_photo',
								'optional_photo_1',
								'optional_photo_2' 
						],
						'string',
						'max' => 100 
				],
				[ 
						[ 
								'currency' 
						],
						'string',
						'max' => 3 
				],
				[ 
						[ 
								'coverPhoto',
								'interiorPhoto',
								'backPhoto',
								'frontPhoto',
								'sidePhoto',
								'optionalPhoto1',
								'optionalPhoto2' 
						],
						'file',
						'skipOnEmpty' => true,
						'extensions' => 'png,jpg,jpeg' 
				] 
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [ 
				'id' => 'ID',
				'cover_photo' => 'Cover Photo',
				'price' => 'Price',
				'created_at' => 'Created At',
				'rent_it_now' => 'Rent It Now',
				'address' => 'Address',
				'description' => 'Description',
				'milage_limitation' => 'Milage Limitation',
				'insurance_tip' => 'Insurance Tip',
				'owner_id' => 'Owner ID',
				'report' => 'Report',
				'country' => 'Country',
				'city' => 'City',
				'maker' => 'Maker',
				'model' => 'Model',
				'is_featured' => 'Is Featured',
				'year_model' => 'Year Model',
				'gear_type' => 'Gear Type',
				'number_of_doors' => 'Number Of Doors',
				'number_of_seats' => 'Number Of Seats',
				'gas' => 'Gas',
				'type' => 'Type',
				'color' => 'Color',
				'rule_1' => 'Rule 1',
				'rule_2' => 'Rule 2',
				'rule_3' => 'Rule 3',
				'rule_4' => 'Rule 4',
				'interior_photo' => 'Interior Photo',
				'back_photo' => 'Back Photo',
				'front_photo' => 'Front Photo',
				'side_photo' => 'Side Photo',
				'optional_photo_1' => 'Optional Photo 1',
				'optional_photo_2' => 'Optional Photo 2' 
		];
	}
	public function beforeSave($insert) {
		if (! parent::beforeSave ( $insert )) {
			return false;
		}
		
		if ($this->coverPhoto !== null)
			$this->cover_photo = time () . '_' . $this->coverPhoto->name;
		
		if ($this->backPhoto !== null)
			$this->back_photo = time () . '_' . $this->backPhoto->name;
		
		if ($this->interiorPhoto !== null)
			$this->interior_photo = time () . '_' . $this->interiorPhoto->name;
		
		if ($this->frontPhoto !== null)
			$this->front_photo = time () . '_' . $this->frontPhoto->name;
		
		if ($this->sidePhoto !== null)
			$this->side_photo = time () . '_' . $this->sidePhoto->name;
		
		if ($this->optionalPhoto1 !== null)
			$this->optional_photo_1 = time () . '_' . $this->optionalPhoto1->name;
		
		if ($this->optionalPhoto2 !== null)
			$this->optional_photo_2 = time () . '_' . $this->optionalPhoto2->name;
		
		return true;
	}
	public function upload() {
		if ($this->validate ()) {
			if ($this->coverPhoto)
				$this->coverPhoto->saveAs ( '../../uploads/' . $this->cover_photo );
			
			if ($this->backPhoto)
				$this->backPhoto->saveAs ( '../../uploads/' . $this->back_photo );
			
			if ($this->interiorPhoto)
				$this->interiorPhoto->saveAs ( '../../uploads/' . $this->interior_photo );
			
			if ($this->frontPhoto)
				$this->frontPhoto->saveAs ( '../../uploads/' . $this->front_photo );
			
			if ($this->sidePhoto)
				$this->sidePhoto->saveAs ( '../../uploads/' . $this->side_photo );
			
			if ($this->optionalPhoto1)
				$this->optionalPhoto1->saveAs ( '../../uploads/' . $this->optional_photo_1 );
			
			if ($this->optionalPhoto2)
				$this->optionalPhoto2->saveAs ( '../../uploads/' . $this->optional_photo_2 );
			
			return true;
		} else {
			return false;
		}
	}
}