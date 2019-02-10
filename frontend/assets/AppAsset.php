<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use frontend;
use yii\web\View;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = [
		'css/app.css',
	];
	public $js = [
		'js/vendors.js',
		'js/app.js',
		'js/omni-slider.js',
	];

	public $depends = [
// 		'yii\web\YiiAsset',
		'yii\bootstrap\BootstrapAsset',
	];

	public function init() {
		$this->jsOptions['position'] = View::POS_HEAD;
		parent::init();
	}
}
