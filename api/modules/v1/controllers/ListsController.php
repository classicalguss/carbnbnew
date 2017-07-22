<?php 

namespace api\modules\v1\controllers;

use Yii;
use api\modules\v1\models\Car;
use yii\rest\Controller;
use common\models\Carmake;
use common\models\Carmodel;
use yii\sphinx\Query;

class ListsController extends Controller {
	
	public function actionGears () {
		return Car::gearArray();
	}
	public function actionTypes () {
		return Car::typeArray();
	}
	public function actiongas () {
		return Car::gearArray();
	}
	public function actionTest() {
		$makes = Carmake::find()->all();
		foreach ($makes as $make) {
			$model = new Carmodel();
			$model->value = $make->value. ' model';
			$model->make_id = $make->id;
			$model->save();
		}
		
	}
	public function actionAreaautocomplete() {
		$keyWord = Yii::$app->request->getQueryParam('q',null);
		if ($keyWord === null)
			return '';
		else 
		{
			$query = new Query();
			$rows = $query->select(['city_id','area_id','city_name','area_name'])
			->from('sphinx_areas')->match($keyWord.'*')
			->all();
			
			return $rows;
		}
	}
}
?>