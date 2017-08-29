<?php

namespace frontend\models;

use yii\base\Model;

/**
 * carPhotos form
 */
class CarPhotosForm extends Model {
	public $photoFile1;
	public $photoFile2;
	public $photoFile3;
	public $photoFile4;
	public $photoFile5;
	public $photoFile6;

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
				[
					['photoFile1'],
					'required'
				],
				[
					'photoFile1',
					'file',
					'skipOnEmpty' => false,
					'extensions' => 'png,jpg,jpeg',
				],
				[
					[
						'photoFile2',
						'photoFile3',
						'photoFile4',
						'photoFile5',
						'photoFile6'
					],
					'file',
					'skipOnEmpty' => true,
					'extensions' => 'png,jpg,jpeg'
				],
		];
	}

}
