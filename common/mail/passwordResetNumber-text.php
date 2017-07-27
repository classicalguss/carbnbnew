<?php

/* @var $this yii\web\View */
/* @var $user api\modules\v1\models\User */
?>
Hello <?= $user->email ?>,

We received a request to reset your <?=Yii::$app->name?> password. You can use the reset code <?=$numberCode?>