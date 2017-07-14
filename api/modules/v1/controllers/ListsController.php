<?php 

namespace api\modules\v1\controllers;

use Yii;
use api\modules\v1\models\Car;
use yii\rest\Controller;
use common\models\Carmake;
use common\models\Carmodel;

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
}
?>