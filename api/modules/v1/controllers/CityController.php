<?php 
namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use common\models\City;
use Yii;

class CityController extends ActiveController {
	public $modelClass = 'common\models\City';
	public function actions() {
		$actions = parent::actions ();
		unset ( $actions ['create'] );
		$actions ['index'] ['prepareDataProvider'] = [
				$this,
				'prepareDataProvider'
		];
		return $actions;
	}
	public function prepareDataProvider() {
		$query = $this->modelClass::find();
		$dataProvider = new ActiveDataProvider([
				'query' => $query,
		]);
		
		$query->andFilterWhere([
				'country_iso' => Yii::$app->request->getQueryParam('country_iso',null),
		]);
		
		return $dataProvider;
	}
}
?>