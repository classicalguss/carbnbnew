<?php
namespace api\modules\v1\models;

use Yii;
use yii\base\Model;
use api\modules\v1\models\User;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'There is no user with this email address.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail($ip)
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }
        
        if (!User::isPasswordResetTokenValid($user->password_reset_number_code)) {
            $user->generatePasswordNumber();
            $user->reset_password_ip_call = $ip;
            if (!$user->save()) {
                return false;
            }
        }
        $numberCode = substr ( $user->password_reset_number_code, 0,strrpos ( $user->password_reset_number_code, '_' ));
        return Yii::$app
            ->mailer
            ->compose(
                ['text' => 'passwordResetNumber-text'],
                ['user' => $user,'numberCode'=>$numberCode]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject($numberCode.' number code can be used to reset your password for ' . Yii::$app->name)
            ->send();
    }
}