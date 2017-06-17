<?php

namespace api\modules\v1\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\modules\v1\models\Car;

/**
 * CarSearch represents the model behind the search form about `app\models\Car`.
 */
class CarSearch extends Car {
	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [ 
				[ 
						[ 
								'id',
								'price',
								'rent_it_now',
								'milage_limitation',
								'owner_id',
								'is_featured',
						],
						'integer' 
				],
				[ 
						[ 
								'cover_photo',
								'created_at',
								'address',
								'description',
								'insurance_tip',
								'report',
								'model',
								'maker',
								'city',
						],
						'safe' 
				] 
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function scenarios() {
		// bypass scenarios() implementation in the parent class
		return Model::scenarios ();
	}
	
	/**
	 * Creates data provider instance with search query applied
	 *
	 * @param array $params        	
	 *
	 * @return ActiveDataProvider
	 */
	public function search($params) {
		$query = Car::find ();
		
		// add conditions that should always apply here
		
		$dataProvider = new ActiveDataProvider ( [ 
				'query' => $query 
		] );
		
		$this->load ( $params,'' );
		
		if (! $this->validate ()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}
		
		// grid filtering conditions
		$query->andFilterWhere ( [ 
				'id' => $this->id,
				'created_at' => $this->created_at,
				'rent_it_now' => $this->rent_it_now,
				'milage_limitation' => $this->milage_limitation,
				'owner_id' => $this->owner_id,
				'is_featured'=> $this->is_featured,
		] );
		$query->andFilterWhere ( [ 
				'like',
				'cover_photo',
				$this->cover_photo 
		] )->andFilterWhere ( [ 
				'like',
				'address',
				$this->address 
		] )->andFilterWhere ( [ 
				'like',
				'description',
				$this->description
		] )->andFilterWhere ( [ 
				'like',
				'insurance_tip',
				$this->insurance_tip
		] )->andFilterWhere ( [ 
				'like',
				'report',
				$this->report
		] )->andFilterWhere ( [
				'like',
				'city',
				$this->city
		] )->andFilterWhere ( [
				'like',
				'maker',
				$this->maker
		] );
		
		return $dataProvider;
	}
}