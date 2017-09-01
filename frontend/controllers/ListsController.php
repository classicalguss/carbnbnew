<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\sphinx\Query;

class ListsController extends Controller {

	public function actionAreaAutocomplete() {
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

			$res = [];
			foreach ($rows as $row)
			{
				$id  = 'ae,'.$row['city_id'].','.$row['area_id'];
				$val = $row['area_name'].', '.$row['city_name'];
				$res[][$id] = $val;
			}
			return json_encode($res);
		}
	}
}
?>