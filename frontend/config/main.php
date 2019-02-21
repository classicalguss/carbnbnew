<?php
$params = array_merge ( require (__DIR__ . '/../../common/config/params.php'), require (__DIR__ . '/../../common/config/params-local.php'), require (__DIR__ . '/params.php'), require (__DIR__ . '/params-local.php') );

return [
		'id' => 'app-frontend',
		'basePath' => dirname ( __DIR__ ),
		'bootstrap' => [
				'log'
		],
		'controllerNamespace' => 'frontend\controllers',
		'components' => [
				'authClientCollection' => [
						'class' => 'yii\authclient\Collection',
						'clients' => [
								'facebook' => [
										'class' => 'yii\authclient\clients\Facebook',
										'authUrl' => 'https://www.facebook.com/dialog/oauth',
										'clientId' => $params ['facebookAppId'],
										'clientSecret' => $params ['facebookAppSecret'],
										'attributeNames' => [
												'picture',
												'name',
												'email',
												'first_name',
												'last_name'
										]
								]
						]
				],
				'request' => [
						'csrfParam' => '_csrf-frontend'
				],
				'user' => [
						'identityClass' => 'common\models\User',
						'enableAutoLogin' => true,
						'identityCookie' => [
								'name' => '_identity-frontend',
								'httpOnly' => true
						],
						'loginUrl' => [
								'user/login'
						]

				],
				'session' => [
						// this is the name of the session cookie used for login on the frontend
						'name' => 'advanced-frontend'
				],
				'log' => [
						'traceLevel' => 0,
						'targets' => [
								[
										'class' => 'yii\log\FileTarget',
										'levels' => [
												'error'
										]

								],
								[
										'class' => 'yii\log\FileTarget',
										'levels' => [
												'warning'
										],
										'logVars' => [ ]
								]
						]
				],
				'errorHandler' => [
						'errorAction' => 'site/error'
				],
				'urlManager' => [
						'enablePrettyUrl' => true,
						'showScriptName' => false,
						'normalizer' => [
								'class' => 'yii\web\UrlNormalizer',
								'collapseSlashes' => true,
								'normalizeTrailingSlash' => true,
						],
						'rules' => [
								'<controller:\w+>/<id:\d+>' => '<controller>/view',
								'<controller:\w+>/<action:[\w-]+>/<id:\d+>' => '<controller>/<action>',
								'<controller:\w+>/<action:\w+>/' => '<controller>/<action>',
						]
				],
				'request' => [
						'parsers' => [
								'application/json' => 'yii\web\JsonParser'
						]
				],
				'assetManager' => [
						'bundles' => [
								'yii\web\JqueryAsset' => [
										// 'jsOptions' => [ 'position' => \yii\web\View::POS_HEAD ],
										'js' => [ ]
								],
								'yii\web\YiiAsset' => [
										'jsOptions' => [
												'position' => \yii\web\View::POS_BEGIN
										],
										'depends' => [ ]
								]
						],
						'appendTimestamp' => true
				]
		],
		'params' => $params
];
