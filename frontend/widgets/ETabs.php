<?php 
namespace frontend\widgets;

use yii\bootstrap\Tabs;

class ETabs extends Tabs {
	public function run()
	{
		return $this->renderItems();
	}
}