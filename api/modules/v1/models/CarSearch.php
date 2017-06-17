<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Car;

/**
 * CarSearch represents the model behind the search form about `app\models\Car`.
 */
class CarSearch extends Car
{
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
				[['id', 'price', 'rent_it_now', 'milage_limitation', 'owner_id', 'is_featured', 'number_of_doors', 'number_of_seats', 'gas'], 'integer'],
				[['cover_photo', 'created_at', 'address', 'description', 'insurance_tip', 'report', 'country', 'city', 'maker', 'model', 'year_model', 'gear_type', 'type', 'color', 'rule_1', 'rule_2', 'rule_3', 'rule_4', 'interior_photo', 'back_photo', 'front_photo', 'side_photo', 'optional_photo_1', 'optional_photo2'], 'safe'],
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function scenarios()
	{
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}
	
	/**
	 * Creates data provider instance with search query applied
	 *
	 * @param array $params
	 *
	 * @return ActiveDataProvider
	 */
	public function search($params)
	{
		$query = Car::find();
		
		// add conditions that should always apply here
		
		$dataProvider = new ActiveDataProvider([
				'query' => $query,
		]);
		
		$this->load($params);
		
		if (!$this->validate()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}
		
		// grid filtering conditions
		$query->andFilterWhere([
				'id' => $this->id,
				'price' => $this->price,
				'created_at' => $this->created_at,
				'rent_it_now' => $this->rent_it_now,
				'milage_limitation' => $this->milage_limitation,
				'owner_id' => $this->owner_id,
				'is_featured' => $this->is_featured,
				'year_model' => $this->year_model,
				'number_of_doors' => $this->number_of_doors,
				'number_of_seats' => $this->number_of_seats,
				'gas' => $this->gas,
		]);
		
		$query->andFilterWhere(['like', 'cover_photo', $this->cover_photo])
		->andFilterWhere(['like', 'address', $this->address])
		->andFilterWhere(['like', 'description', $this->description])
		->andFilterWhere(['like', 'insurance_tip', $this->insurance_tip])
		->andFilterWhere(['like', 'report', $this->report])
		->andFilterWhere(['like', 'country', $this->country])
		->andFilterWhere(['like', 'city', $this->city])
		->andFilterWhere(['like', 'maker', $this->maker])
		->andFilterWhere(['like', 'model', $this->model])
		->andFilterWhere(['like', 'gear_type', $this->gear_type])
		->andFilterWhere(['like', 'type', $this->type])
		->andFilterWhere(['like', 'color', $this->color])
		->andFilterWhere(['like', 'rule_1', $this->rule_1])
		->andFilterWhere(['like', 'rule_2', $this->rule_2])
		->andFilterWhere(['like', 'rule_3', $this->rule_3])
		->andFilterWhere(['like', 'rule_4', $this->rule_4])
		->andFilterWhere(['like', 'interior_photo', $this->interior_photo])
		->andFilterWhere(['like', 'back_photo', $this->back_photo])
		->andFilterWhere(['like', 'front_photo', $this->front_photo])
		->andFilterWhere(['like', 'side_photo', $this->side_photo])
		->andFilterWhere(['like', 'optional_photo_1', $this->optional_photo_1])
		->andFilterWhere(['like', 'optional_photo2', $this->optional_photo2]);
		
		return $dataProvider;
	}
}