<?php
namespace frontend\models;
use yii\base\Model;

/**
 * CarPublish form
 */
class carPublishForm extends Model {
	public $milage_limitation;
	public $color;
	public $price;
	public $currency;
	public $book_instantly;
	public $description;

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
				[
						['milage_limitation','color','price','currency','description'],
						'required',
				],
				[
						['milage_limitation','color'],
						'integer'
				],
				[
						['book_instantly'],
						'safe'
				],
		];
	}

	public function attributeLabels()
	{
		return [
			'price' => 'Price per day',
			'currency' => 'Currency',
			'book_instantly' => 'Book Instantly',
			'description' => 'Describe Your Car',
		];
	}
}
