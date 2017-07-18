<?php 
namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use Yii;

class CarmakeController extends ActiveController {
	public $modelClass = 'common\models\Carmake';
	public function actions() {
		$actions = parent::actions ();
		unset ( $actions ['create'],$actions['update'],$actions['delete'] );
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
				'is_featured' => Yii::$app->request->getQueryParam('is_featured',null),
		]);
		
		return $dataProvider;
	}
}
?>