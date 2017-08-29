<?php 
namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use common\models\Area;
use Yii;

class AreaController extends ActiveController {
	public $modelClass = 'common\models\Area';
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
				'limit'=>10
		]);
		
		$query->andFilterWhere([
				'city_id' => Yii::$app->request->getQueryParam('city_id',null),
		]);
		
		return $dataProvider;
	}
}
?>