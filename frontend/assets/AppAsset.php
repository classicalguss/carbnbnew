<?php

namespace frontend\assets;

use yii\web\AssetBundle;

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
}
