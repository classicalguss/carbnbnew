<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\sphinx\Query;

class ListsController extends Controller {

	public function actionAreaAutocomplete() {
		header('Access-Control-Allow-Origin: *');
		$keyWord = Yii::$app->request->getQueryParam('q',null);
		\Yii::error($keyWord);
		if ($keyWord === null)
			return '';
		else
		{
			$query = new Query();
// 			$rows = $query->select(['city_id','area_id','city_name','area_name'])
// 			->from('sphinx_areas')->match($keyWord.'*')
// 			->limit(10)
// 			->all();

			$rows = [];
			$rows[] = ['id'=>'ae,1,1','value'=>'Al-Hamra, Dubai'];
			$rows[] = ['id'=>'sa,5,3','value'=>'Al-Wardeh, Saudi Arabia'];
			return json_encode($rows);
		}
	}
}
?>