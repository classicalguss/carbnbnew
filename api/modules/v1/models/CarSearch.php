<?php

namespace api\modules\v1\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\modules\v1\models\Car;
use common\models\Booking;
use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
/**
 * CarSearch represents the model behind the search form about `app\models\Car`.
 */
class CarSearch extends Car
{
	public $min_price;
	public $max_price;
	public $min_milage_limitation;
	public $max_milage_limitation;
	public $date_start;
	public $date_end;
	
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
				[['min_milage_limitation','max_milage_limitation','min_price','max_price','id', 'year_model','price', 'rent_it_now', 'insurance_tip','gear_type_id','type_id','model_id','make_id','city_id','milage_limitation', 'owner_id', 'is_featured', 'number_of_doors', 'number_of_seats', 'gas_type_id', 'type_id','area_id'], 'integer'],
				[['date_start','date_end','min_price','max_price','created_at', 'description', 'report', 'country', 'color', 'rule_1', 'rule_2', 'rule_3', 'rule_4', 'interior_photo', 'back_photo', 'front_photo', 'side_photo', 'optional_photo_1', 'optional_photo_2'], 'safe'],
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
		$query->andFilterWhere(['between','price',$this->min_price,$this->max_price]);
		$query->andFilterWhere(['between','milage_limitation',$this->min_milage_limitation,$this->max_milage_limitation]);
		
		$query->andFilterWhere(['like', 'description', $this->description])
		->andFilterWhere(['like', 'report', $this->report])
		->andFilterWhere(['like', 'color', $this->color])
		->andFilterWhere(['like', 'rule_1', $this->rule_1])
		->andFilterWhere(['like', 'rule_2', $this->rule_2])
		->andFilterWhere(['like', 'rule_3', $this->rule_3])
		->andFilterWhere(['like', 'rule_4', $this->rule_4]);
		
		if (!empty($this->date_end) && !empty($this->date_start))
		{
			$bookedCars= Booking::find()->distinct('car_id')->select('car_id')->where('(
				date_start BETWEEN :date_start AND :date_end
				OR date_end BETWEEN :date_start AND :date_end
				OR (date_start < :date_start AND date_end > :date_end))',[':date_start'=>$this->date_start,':date_end'=>$this->date_end])
				->andFilterWhere(['status'=>1])->asArray()->all();
			
			
			if (count($bookedCars) > 0)
			{
				$bookedCarIds = [];
				foreach ($bookedCars as $car)
					$bookedCarIds[] = $car['car_id'];
				
				$query->andFilterWhere(['not in','id',array_values($bookedCarIds)]);
			}
		}
		
		return $dataProvider;
	}
}