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
		
		$image = file_get_contents('https://scontent.xx.fbcdn.net/v/t1.0-1/p50x50/18118821_10101752857313411_7550685757608308442_n.jpg?_nc_eui2=v1%3AAeFqxmFPtediQjHmzyfrSpy8aimJ5qckkuYWpgA7kOcio4emoMadEEogpELUzUXITvw&oh=b5cd504a44a1c92fa20fc76ce34951d5&oe=5A880DA9');
		file_put_contents('../../uploads/sdhfjksdfhjksdlfsd.png', $image);
	}
}

?>