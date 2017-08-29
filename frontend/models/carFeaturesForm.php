<?php

namespace frontend\models;

use yii\base\Model;
use frontend\models\Car;

/**
 * carFeatures form
 */
class CarFeaturesForm extends Model {
	public $gear_type_id;
	public $number_of_doors;
	public $number_of_seats;
	public $gas_type_id;
	public $type_id;
	public $features;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[
					['gear_type_id','gas_type_id','type_id'],
					'required'
			],
			[
					['gear_type_id','gas_type_id','type_id','number_of_doors','number_of_seats'],
					'integer'
			],
			[
					'features',
					'isArrayOfNumbers',
			],
		];
	}

	/**
	 * Check if attribute is array of numbers
	 * @param string $attribute the attribute currently being validated
	 * @param array $params the additional name-value pairs given in the rule
	 */
	public function isArrayOfNumbers($attribute, $params)
	{
		$allFeatures = Car::featuresArray();
		if (!$this->hasErrors() && !empty($this->$attribute))
		{
			$featuresArr=explode(',', $this->$attribute);
			foreach ($featuresArr as $val)
			{
				if (!isset($allFeatures[$val]))
					$this->addError($attribute, 'Invalid feature selected.');
			}
		}
	}

	public function attributeLabels()
	{
		return [
			'gear_type_id' => 'Transmission',
			'number_of_doors' => 'Number of Doors',
			'number_of_seats' => 'Number of Seats',
			'gas_type_id' => 'Engine type',
			'type_id' => 'Vehicle Type',
			'features' => 'Features included',
		];
	}
}
