<?php
use yii\web\UrlRule;

$params = array_merge ( require (__DIR__ . '/../../common/config/params.php'), require (__DIR__ . '/../../common/config/params-local.php'), require (__DIR__ . '/params.php'), require (__DIR__ . '/params-local.php') );

return [ 
		'id' => 'app-api',
		'basePath' => dirname ( __DIR__ ),
		'bootstrap' => [ 
				'log' 
		],
		'modules' => [ 
				'v1' => [ 
						'basePath' => '@app/modules/v1',
						'class' => 'api\modules\v1\Module' 
				],
		],
		'components' => [
				'mailer' => [
					'class' => 'yii\swiftmailer\Mailer',
				],
				'user' => [
						'identityClass' => 'api\modules\v1\models\User',
						'enableAutoLogin' => false,
						'enableSession'=>false,
				],
				'log' => [ 
						'traceLevel' => 0,
						'targets' => [
								[
										'class' => 'yii\log\FileTarget',
										'levels' => [
												'error',
										],
										
								],
								[
										'class' => 'yii\log\FileTarget',
										'levels' => [
												'warning',
										],
										'logVars' => [],
								]
						] 
				],
				'response' => [
					'class' => 'yii\web\Response',
					'format'=>'yii\web\Response::FORMAT_JSON',
					'on beforeSend' => function ($event) {
						$response = $event->sender;
							$response->data = [
									'status'=>$response->statusCode,
									'message'=>$response->statusText,
									'success' => $response->isSuccessful,
									'data' => $response->data,
							];
					},
				],
				'urlManager' => [ 
						'enablePrettyUrl' => true,
						'enableStrictParsing' => false,
						'showScriptName' => false,
						'rules' => [
								[
										'class' => 'yii\rest\UrlRule',
										'controller' => ['v1/rating','v1/car','v1/carmake','v1/city','v1/area','v1/carmodel'],
										'patterns'=>[
												'POST {id}' => 'update',
												'DELETE {id}' => 'delete',
												'GET,HEAD {id}' => 'view',
												'POST' => 'create',
												'GET,HEAD' => 'index',
												'{id}' => 'options',
												'' => 'options',
										]
								],
								[ 
										'class' => 'yii\rest\UrlRule',
										'controller' => 'v1/user',
										'extraPatterns' => [
												'POST facebooklogin' => 'facebooklogin',
												'POST login' => 'login',
												'POST logout' => 'logout',
												'GET test' => 'test',
										],
								],
								[
										'class' => 'yii\web\UrlRule',
										'route' => '/<controller>/<action>',
										'pattern' => '/<controller:[\w-]+>/<action:[\w-]+>',
								],
						] 
				] 
		],
		'params' => $params 
];