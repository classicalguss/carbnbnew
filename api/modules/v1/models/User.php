<?php

namespace api\modules\v1\models;

use Yii;
use \yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;
use common\models\Util;

/**
 * User model
 *
 * @property integer $id
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $user_type
 * @property string $first_name
 * @property string $last_name
 * @property string $birthdate
 * @property string $gender
 * @property string $phonenumber
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property string $registration_token
 * @property integer $registration_type
 * @property integer $role
 */
class User extends ActiveRecord implements IdentityInterface {
	const STATUS_DELETED = 0;
	const STATUS_ACTIVE = 10;
	
	const normal_user = 0;
	const renter_user = 1;
	const admin_user = 2;
	
	public $test;
	public $password;
	public $photoFile;
	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%user}}';
	}
	public function init() {
		parent::init ();
		Yii::$app->user->enableSession = false;
	}
	public function behaviors() {
		parent::init ();
		$behaviors [] =TimestampBehavior::className();
		return $behaviors;
	}
	public function fields()
	{
		return ['id','first_name','last_name','user_type','photoFile'];
	}
	
	public function scenarios() {
		$scenarios = parent::scenarios();
		$scenarios = array_merge($scenarios,[
				'facebookLogin'=>['registration_token','first_name','last_name','!auth_key','!status','!password_hash','!user_type','!email','photoFile'],
				'signup'=>['first_name','last_name','email','password','phonenumber','photoFile'],
		]);
		return $scenarios;
	}
	
	public function getCars() {
		return $this->hasMany(Car::className(), ['owner_id' => 'id']);
	}
	
	public function extraFields() {
		return ['cars'];
	}
	/**
	 * Define rules for validation
	 */
	public function rules() {
		return [
				[
						[ 
								'registration_token' 
						],
						'required',
						'on' => 'facebookLogin' 
				],
				[ 
						[ 
								'email',
								'first_name',
								'last_name',
								'!auth_key',
								'!password_hash' 
						],
						'required',
						'on' =>'signup'
				],
				[ 
						[ 
								'first_name',
								'last_name',
								'phonenumber' 
						],
						'trim' 
				],
				[ 
						[ 
								'first_name',
								'last_name' 
						],
						'string',
						'min' => 2,
						'max' => 255 
				],
				[ 
						[ 
								'phonenumber',
								'photoFile'
						],
						'safe' 
				],
				[ 
						'phonenumber',
						'string',
						'min' => 2,
						'max' => 30 
				],
				[ 
						'gender',
						'string',
						'min' => 1,
						'max' => 1 
				],
				[ 
						'user_type',
						'default',
						'value' => self::normal_user 
				],
				[ 
						'status',
						'default',
						'value' => self::STATUS_ACTIVE 
				],
				[ 
						'status',
						'in',
						'range' => [ 
								self::STATUS_ACTIVE,
								self::STATUS_DELETED 
						] 
				],
				[
						'email',
						'email'
				],
				[
						'email',
						'unique',
						'message' => 'This email address has already been taken.'
				],
				[
						['email'],
						'unique',
						'when' => function ($model, $attribute) {
								return $model->{$attribute} !== $model->getOldAttribute($attribute);
						},
						'on' => 'update',
						'message' => 'This email address has already been taken.'
				],
				[
						'password',
						'required',
						'on'=>['signup']
				],
				[
						'password',
						'string',
						'min' => 6
				],
				[
						[
								'photoFile'
						],
						'file',
						'skipOnEmpty' => true,
						'extensions' => 'png,jpg,jpeg'
				],
		];
	}
	
	
	/**
	 * @inheritdoc
	 */
	public static function findIdentity($id) {
		return static::findOne ( [
				'id' => $id,
				'status' => self::STATUS_ACTIVE
		] );
	}
	
	/**
	 * @inheritdoc
	 */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		return static::findOne(['access_key' => $token]);
	}
	
	/**
	 * @inheritdoc
	 */
	public function getId() {
		return $this->getPrimaryKey ();
	}
	
	/**
	 * @inheritdoc
	 */
	public function getAuthKey() {
		return $this->auth_key;
	}
	
	/**
	 * @inheritdoc
	 */
	public function validateAuthKey($authKey) {
		return $this->getAuthKey () === $authKey;
	}

	/**
	 * Validates password
	 *
	 * @param string $password
	 *        	password to validate
	 * @return bool if password provided is valid for current user
	 */
	public function validatePassword($password) {
		return Yii::$app->security->validatePassword ( $password, $this->password_hash );
	}
	
	/**
	 * Generates password hash from password and sets it to the model
	 *
	 * @param string $password
	 */
	public function setPassword($password) {
		$this->password_hash = Yii::$app->security->generatePasswordHash ( $password );
	}
	
	/**
	 * Generates "remember me" authentication key
	 */
	public function generateAuthKey() {
		$this->auth_key = Yii::$app->security->generateRandomString ();
		$this->access_key = $this->auth_key;
	}
	
	/**
	 * Generates new password reset token
	 */
	public function generatePasswordResetToken() {
		$this->password_reset_token = Yii::$app->security->generateRandomString () . '_' . time ();
	}
	
	/**
	 * Removes password reset token
	 */
	public function removePasswordResetToken() {
		$this->password_reset_token = null;
	}
	public function beforeSave($insert) {
		if (! parent::beforeSave ( $insert )) {
			return false;
		}
		
		if ($this->photoFile !== null)
		{
			$this->photo = Util::generateRandomString(). '_' . $this->photoFile->name;
		}
								
		return true;
	}
	public function upload() {
		if ($this->validate ()) {
			
			if ($this->photoFile)
			{
				$this->photoFile->saveAs ( '../../uploads/' . $this->photo );
			}
									
			return true;
		} else {
			return false;
		}
	}
	public function afterFind() {
		$this->photoFile = Yii::$app->params['imagesFolder'].$this->photo;
		return parent::afterFind();
	}
}
