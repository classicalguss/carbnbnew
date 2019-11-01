<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Car;
use common\models\Util;
use common\models\Booking;

/**
 * CarSearch represents the model behind the search form about `frontend\models\Car`.
 */
class CarSearch extends Car {
	public $area;
	public $min_price;
	public $max_price;
	public $min_milage_limitation;
	public $max_milage_limitation;
	public $test;
	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [ 
				[ 
						[ 
								'id',
								'price',
								'area_id',
								'milage_limitation',
								'owner_id',
								'city_id',
								'model_id',
								'is_featured',
								'number_of_doors',
								'number_of_seats',
								'gas_type_id',
								'odometer',
								'is_published',
								'book_instantly',
								'delivery',
								'min_price',
								'max_price',
								'min_milage_limitation',
								'max_milage_limitation'
						],
						'integer' 
				],
				[ 
						[ 
								'type_id',
								'gear_type_id',
								'date_start',
								'date_end',
								'area',
								'created_at',
								'description',
								'insurance_tip',
								'report',
								'country_iso',
								'year_model',
								'color',
								'rule_1',
								'rule_2',
								'rule_3',
								'rule_4',
								'photo1',
								'photo2',
								'photo3',
								'photo4',
								'photo5',
								'photo6',
								'currency',
								'features',
								'daterange',
								'make_id',
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
	 * @return ActiveDataProvider
	 */
	public function search() {
		$query = Car::find ();

		$dataProvider = new ActiveDataProvider ( [
				'query' => $query,
				'pagination' => [
						'pageSize' => 6,
				],
		] );

        if (! $this->validate ()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

		$query->distinct = true;
		// grid filtering conditions
        if ($this->area_id) {
            $this->city_id = Area::findOne($this->area_id)->city_id;
        }
		$query->andFilterWhere ( [ 
				'id' => $this->id,
				'price' => $this->price,
				'created_at' => $this->created_at,
				'milage_limitation' => $this->milage_limitation,
				'owner_id' => $this->owner_id,
				'city_id' => $this->city_id,
				'model_id' => $this->model_id,
				'number_of_doors' => $this->number_of_doors,
				'number_of_seats' => $this->number_of_seats,
				'gas_type_id' => $this->gas_type_id,
				'type_id' => $this->type_id,
				'odometer' => $this->odometer,
				'is_published' => $this->is_published,
				'book_instantly' => $this->book_instantly,
				'delivery'=>$this->delivery
		] );

		$query->andFilterWhere(['in','year_model',$this->year_model]);
		$query->andFilterWhere(['in','type_id',$this->type_id]);
		$query->andFilterWhere(['in','color',$this->color]);
		$query->andFilterWhere(['in','gear_type_id',$this->gear_type_id]);
		$query->andFilterWhere(['in','car.make_id',$this->make_id]);
		$query->andFilterWhere(['>=','price',$this->min_price]);
		$query->andFilterWhere(['<=','price',$this->max_price]);
		$query->andFilterWhere(['=','car.is_featured',$this->is_featured]);
		$query->andFilterWhere(['between','milage_limitation',$this->min_milage_limitation,$this->max_milage_limitation]);
		
		$query->andFilterWhere ( [ 
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
				'country_iso',
				$this->country_iso 
		] )->andFilterWhere ( [ 
				'like',
				'rule_1',
				$this->rule_1 
		] )->andFilterWhere ( [ 
				'like',
				'rule_2',
				$this->rule_2 
		] )->andFilterWhere ( [ 
				'like',
				'rule_3',
				$this->rule_3 
		] )->andFilterWhere ( [ 
				'like',
				'rule_4',
				$this->rule_4 
		] )->andFilterWhere ( [ 
				'like',
				'photo1',
				$this->photo1 
		] )->andFilterWhere ( [ 
				'like',
				'photo2',
				$this->photo2 
		] )->andFilterWhere ( [ 
				'like',
				'photo3',
				$this->photo3 
		] )->andFilterWhere ( [ 
				'like',
				'photo4',
				$this->photo4 
		] )->andFilterWhere ( [ 
				'like',
				'photo5',
				$this->photo5 
		] )->andFilterWhere ( [ 
				'like',
				'photo6',
				$this->photo6 
		] )->andFilterWhere ( [ 
				'like',
				'currency',
				$this->currency 
		] )->andFilterWhere ( [ 
				'like',
				'features',
				$this->features 
		] );
		
		$startDate = '';
		$endDate = '';
		$dates = Yii::$app->request->get('daterange','');
		$dates = explode(' - ',$dates);
		
		if (isset($dates[0]) && Util::isValidDate($dates[0]))
			$startDate = $dates[0];
			
		if (isset($dates[1]) && Util::isValidDate($dates[1]))
			$endDate = $dates[1];
		
		if (!empty($startDate) && !empty($endDate))
		{

			$query->joinWith('bookings',true,'LEFT JOIN')->andWhere ('(
			date_start NOT BETWEEN :date_start AND :date_end
			AND date_end NOT BETWEEN :date_start AND :date_end
			AND !(date_start < :date_start AND date_end > :date_end)
			OR date_start IS NULL)', [
					':date_start' => $startDate,
					':date_end' => $endDate
			]);
		}
		$query->joinWith('make')->joinWith('model');
		return $dataProvider;
	}
}
