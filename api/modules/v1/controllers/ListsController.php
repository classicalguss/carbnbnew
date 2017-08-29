<?php 

namespace api\modules\v1\controllers;

use Yii;
use api\modules\v1\models\Car;
use yii\rest\Controller;
use common\models\Carmake;
use common\models\Carmodel;
use yii\sphinx\Query;
use common\models\Area;

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
		$cars = Car::find()->all();
		foreach ($cars as $car) {
			$areaId = rand(1,10);
			$area = Area::findOne($areaId);
			Yii::warning('Area ID '.$area->id);
			Yii::warning('city '.$area->city_id);
			$car->area_id = $area->id;
			$car->city_id = $area->city_id;
			$car->save();
		}
		
	}
	public function actionAreaautocomplete() {
		header('Access-Control-Allow-Origin: *');  
		$keyWord = Yii::$app->request->getQueryParam('q',null);
		if ($keyWord === null)
			return '';
		else 
		{
			$query = new Query();
			$rows = $query->select(['city_id','area_id','city_name','area_name'])
			->from('sphinx_areas')->match($keyWord.'*')
			->limit(10)
			->all();
			
			return $rows;
		}
	}
}
?>