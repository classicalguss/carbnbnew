<?php

namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class UpdateForm extends Model {
	public $phonenumber;
	public $first_name;
	public $last_name;
	
	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [ 
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
						['first_name','last_name','phonenumber'],
						'safe'
				],
				[
						'phonenumber',
						'string',
						'min' => 2,
						'max' => 30
				],
		];
	}
}
