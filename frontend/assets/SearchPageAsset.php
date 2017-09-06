<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class SearchPageAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/search-page.css',
    	'css/site.css',
    	'css/app.css',
    ];
    public $js = [
    	'js/jquery.pjax.js',
    	'js/jquery-migrate-3.0.0.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    	'yii\jui\JuiAsset'
    ];
}