<?php 

namespace frontend\widgets;

use yii\base\Widget;
use common\models\Util;
use Yii;
use frontend\models\CarSearch;

class QuickSearch extends Widget
{
	/**
	 * Renders the widget.
	 */
	public function run()
	{
		$this->renderWidget();
	}
	
	/**
	 * Renders the AutoComplete widget.
	 * @return string the rendering result.
	 */
	public function renderWidget()
	{
		$startDate = '2017-01-01';
		$endDate = '2017-12-31';
		$dates = Yii::$app->request->get('daterange','2017-01-01 - 2017-12-31');
		$dates = explode(' - ',$dates);
		if (isset($dates[0]) && Util::isValidDate($dates[0]))
			$startDate = $dates[0];
		
		if (isset($dates[1]) && Util::isValidDate($dates[1]))
			$endDate = $dates[1];
		
		$carSearchModel = new CarSearch();
		$carSearchModel->load(Yii::$app->request->queryParams);
		echo $this->render('quickSearch',['area'=>$carSearchModel->area,'area_id'=>$carSearchModel->area_id, 'startDate'=>$startDate,'endDate'=>$endDate]);
	}
}
?>