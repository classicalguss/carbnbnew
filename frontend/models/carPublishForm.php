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
	public $license_plate_number;
	public $description;
	public $delivery;
	
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
						['milage_limitation','color','price'],
						'integer'
				],
				[
						['book_instantly','license_plate_number','delivery'],
						'safe'
				],
		];
	}

	public function attributeLabels()
	{
		return [
			'price' => 'Price per day',
			'currency' => 'Currency',
			'license_plate_number'=>'License Plate Number',
			'book_instantly' => 'Book Instantly',
			'description' => 'Describe Your Car',
		];
	}
}
