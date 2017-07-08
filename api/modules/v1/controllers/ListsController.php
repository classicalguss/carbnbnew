<?php 

namespace api\modules\v1\controllers;

use api\modules\v1\models\Car;
use yii\rest\Controller;

class ListsController extends Controller {
	
	public function actionGears () {
		return Car::gearArray();
	}
	public function actiontypes () {
		return Car::gearArray();
	}
	public function actiongas () {
		return Car::gearArray();
	}
}
?>