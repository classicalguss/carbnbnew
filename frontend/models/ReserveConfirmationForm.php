<?php

namespace frontend\models;

use yii\base\Model;

/**
 * CarDetails form
 */
class ReserveConfirmationForm extends Model {
	public $first_name;
	public $last_name;
	public $email;
	public $phonenumber;
	public $area;
	public $area_id;
	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
				[
						['first_name','last_name','phonenumber','email','area'],
						'required'
				],
				[
						['first_name','last_name','phonenumber','email'],
						'string',
						'min' => 2,
						'max' => 255
				],
				[
						['area_id'],
						'integer'
				]
		];
	}
	public function attributeLabels() {
		return [
				'area' => 'Area',
		];
	}
}