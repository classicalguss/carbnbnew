<?php

namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model {
	public $username;
	public $email;
	public $password;
	public $first_name;
	public $last_name;
	public $gender;
	public $birthdate;
	public $phonenumber;
	
	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [ 
				[ 
						'username',
						'trim' 
				],
				[ 
						'username',
						'required' 
				],
				[ 
						'username',
						'unique',
						'targetClass' => '\common\models\User',
						'message' => 'This username has already been taken.' 
				],
				[ 
						'username',
						'string',
						'min' => 2,
						'max' => 255 
				],
				[
						'first_name',
						'trim',
				],
				[
						'first_name',
						'required'
				],
				[
						'first_name',
						'string',
						'min' => 2,
						'max' => 255
				],
				[
						'last_name',
						'trim',
				],
				[
						'last_name',
						'required'
				],
				[
						'last_name',
						'string',
						'min' => 2,
						'max' => 255
				],
				[
						'phonenumber',
						'trim',
				],
				[
						'phonenumber',
						'required'
				],
				[
						'phonenumber',
						'string',
						'min' => 2,
						'max' => 50
				],
				[
						'email',
						'trim' 
				],
				[ 
						'email',
						'required' 
				],
				[ 
						'email',
						'email' 
				],
				[ 
						'email',
						'string',
						'max' => 255 
				],
				[ 
						'email',
						'unique',
						'targetClass' => '\common\models\User',
						'message' => 'This email address has already been taken.' 
				],
				
				[ 
						'password',
						'required' 
				],
				[ 
						'password',
						'string',
						'min' => 6 
				] 
		];
	}
	
	/**
	 * Signs user up.
	 *
	 * @return User|null the saved model or null if saving fails
	 */
	public function signup() {
		if (! $this->validate ()) {
			return null;
		}
		
		$user = new User ();
		$user->username = $this->username;
		$user->email = $this->email;
		$user->setPassword ( $this->password );
		$user->generateAuthKey ();
		$user->first_name = $this->first_name;
		$user->last_name = $this->last_name;
		$user->phonenumber = $this->phonenumber;
		$user->user_type = 1;
		return $user->save () ? $user : null;
	}
}
