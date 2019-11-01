<?php

namespace frontend\models;

use yii\base\Model;

/**
 * CarDetails form
 */
class carDetailsForm extends Model {
	public $country_iso;
	public $city_id;
	public $area_id;
	public $make_id;
	public $model_id;
	public $year_model;
	public $odometer;
	public $insurance_tip;
	public $area;

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[
					['area','country_iso','city_id','make_id','model_id','year_model','odometer','insurance_tip'],
					'required'
			],
			[
					['city_id','area_id','make_id','model_id','year_model','odometer'],
					'integer'
			],
			[
					'country_iso',
					'string',
					'max' => 2
			],
			[
					'insurance_tip',
					'string',
					'max'=>255
			],
		];
	}

	public function attributeLabels()
	{
		return [
				'country_iso' => '',
				'city_id' => 'City',
				'area_id' => '',
				'make_id' => 'Make',
				'model_id' => 'Model',
				'year_model' => 'Year',
				'odometer' => 'Odometer',
				'insurance_tip' => 'I have an insurance policy that covers commercial rental transactions.',
		];
	}
}
