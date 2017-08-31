<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Main frontend application asset bundle.
 */
class JqueryUIAsset extends AssetBundle
{
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = [
	];
	public $js = [
		'js/jquery-ui.min.js',
	];

	public $depends = [
		'frontend\assets\AppAsset',
	];

	public function init() {
		$this->jsOptions['position'] = View::POS_END;
		parent::init();
	}
}
