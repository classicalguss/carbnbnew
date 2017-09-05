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
		'dist/css/site.css',
		'dist/css/app.css',
	];
	public $js = [
		'dist/js/vendors.js',
		'dist/js/app.js'
	];

	public $depends = [
		'yii\web\YiiAsset'
	];

	public function init() {
		$this->jsOptions['position'] = View::POS_HEAD;
		parent::init();
	}
}
