<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use Yii;
use yii\helpers\Url;
use yii\filters\auth\HttpBearerAuth;
use api\modules\v1\models\User;
use api\modules\v1\models\Car;
use api\modules\v1\models\CarSearch;
use yii\web\UploadedFile;
use yii\web\ServerErrorHttpException;
use yii\sphinx\Query;
use common\models\Area;
/**
 * Country Controller API
 *
 * @author Budi Irawan <deerawan@gmail.com>
 */
class TestController extends ActiveController {
	
	public $modelClass='test';
	public function actionTest() {
		
		$query = new Query();
		$rows = $query->select('id')
		->from('sphinx_areas')->match('duba*')
		->all();
		//return $rows;

		$areas = Area::find()->with('city')->all();
		$sql = 'TRUNCATE areas; INSERT INTO `areas` (`city_id`,`area_id`,`city_name`,`area_name`) VALUES ';
		$valuesArray = [];
		foreach ($areas as $area)
		{
			$elementArray = [$area->city->id,$area->id,'\''.$area->city->value.'\'','\''.str_replace('\'', '\'\'', $area->value).'\''];
			$valuesArray[] = '('.implode(',',$elementArray).')';
		}
		$sql .= implode(',',$valuesArray);
		return $sql;
	}
}

?>