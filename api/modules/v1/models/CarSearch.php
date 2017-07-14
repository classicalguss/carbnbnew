<?php

namespace api\modules\v1\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\modules\v1\models\Car;
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
				[['id', 'year_model','price', 'rent_it_now', 'insurance_tip','gear_type_id','type_id','model_id','make_id','city_id','milage_limitation', 'owner_id', 'is_featured', 'number_of_doors', 'number_of_seats', 'gas_type_id', 'type_id','area_id'], 'integer'],
				[['created_at', 'description', 'report', 'country', 'color', 'rule_1', 'rule_2', 'rule_3', 'rule_4', 'interior_photo', 'back_photo', 'front_photo', 'side_photo', 'optional_photo_1', 'optional_photo_2'], 'safe'],
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
		
		$this->load($params,'');
		
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
				'gas_type_id' => $this->gas_type_id,
				'area_id'=>$this->area_id,
				'insurance_tip'=>$this->insurance_tip,
				'insurance_tip'=>$this->city_id,
				'make_id'=>$this->make_id,
				'model_id'=>$this->model_id,
				'gear_type_id'=>$this->gear_type_id,
				'type_id'=>$this->type_id,
				'is_published'=>1
		]);
		
		$query->andFilterWhere(['like', 'description', $this->description])
		->andFilterWhere(['like', 'report', $this->report])
		->andFilterWhere(['like', 'color', $this->color])
		->andFilterWhere(['like', 'rule_1', $this->rule_1])
		->andFilterWhere(['like', 'rule_2', $this->rule_2])
		->andFilterWhere(['like', 'rule_3', $this->rule_3])
		->andFilterWhere(['like', 'rule_4', $this->rule_4]);
		
		return $dataProvider;
	}
}