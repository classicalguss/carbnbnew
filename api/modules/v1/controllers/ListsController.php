<?php 

namespace api\modules\v1\controllers;

use api\modules\v1\models\Car;
use yii\rest\Controller;

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
}
?>