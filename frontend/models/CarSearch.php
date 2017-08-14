<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Car;

/**
 * CarSearch represents the model behind the search form about `frontend\models\Car`.
 */
class CarSearch extends Car
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'price', 'rent_it_now', 'area_id', 'milage_limitation', 'owner_id', 'city_id', 'make_id', 'model_id', 'is_featured', 'gear_type_id', 'number_of_doors', 'number_of_seats', 'gas_type_id', 'type_id', 'odometer', 'is_published', 'book_instantly'], 'integer'],
            [['created_at', 'description', 'insurance_tip', 'report', 'country_iso', 'year_model', 'color', 'rule_1', 'rule_2', 'rule_3', 'rule_4', 'photo1', 'photo2', 'photo3', 'photo4', 'photo5', 'photo6', 'currency', 'features'], 'safe'],
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
            'area_id' => $this->area_id,
            'milage_limitation' => $this->milage_limitation,
            'owner_id' => $this->owner_id,
            'city_id' => $this->city_id,
            'make_id' => $this->make_id,
            'model_id' => $this->model_id,
            'is_featured' => $this->is_featured,
            'year_model' => $this->year_model,
            'gear_type_id' => $this->gear_type_id,
            'number_of_doors' => $this->number_of_doors,
            'number_of_seats' => $this->number_of_seats,
            'gas_type_id' => $this->gas_type_id,
            'type_id' => $this->type_id,
            'odometer' => $this->odometer,
            'is_published' => $this->is_published,
            'book_instantly' => $this->book_instantly,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'insurance_tip', $this->insurance_tip])
            ->andFilterWhere(['like', 'report', $this->report])
            ->andFilterWhere(['like', 'country_iso', $this->country_iso])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'rule_1', $this->rule_1])
            ->andFilterWhere(['like', 'rule_2', $this->rule_2])
            ->andFilterWhere(['like', 'rule_3', $this->rule_3])
            ->andFilterWhere(['like', 'rule_4', $this->rule_4])
            ->andFilterWhere(['like', 'photo1', $this->photo1])
            ->andFilterWhere(['like', 'photo2', $this->photo2])
            ->andFilterWhere(['like', 'photo3', $this->photo3])
            ->andFilterWhere(['like', 'photo4', $this->photo4])
            ->andFilterWhere(['like', 'photo5', $this->photo5])
            ->andFilterWhere(['like', 'photo6', $this->photo6])
            ->andFilterWhere(['like', 'currency', $this->currency])
            ->andFilterWhere(['like', 'features', $this->features]);

        return $dataProvider;
    }
}
