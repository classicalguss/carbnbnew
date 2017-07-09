<?php 
namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use Yii;
use yii\helpers\Url;

class CarmodelController extends ActiveController {
	public $modelClass = 'common\models\Carmodel';
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
				'make_id' => Yii::$app->request->getQueryParam('make_id',null),
		]);
		
		return $dataProvider;
	}
}
?>