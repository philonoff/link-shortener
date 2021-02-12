<?php

namespace app\models\forms;

use app\models\User;
use yii\base\Model;
use Yii;

class RequestPasswordResetForm extends Model
{
    public $email;

    public function rules()
    {
        return [
            ['email', 'required'],
            ['email', 'trim'],
            ['email', 'exist', 'targetClass' => 'app\models\User']
        ];
    }

    public function sendEmail()
    {
        $user = User::findOne(['email' => $this->email]);

        if (!$user) {
            return false;
        }

        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        $result = Yii::$app->mailer->compose(
            ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
            ['user' => $user]
        )
            ->setFrom('philkrm@gmail.com')
            ->setTo($this->email)
            ->setSubject('Восстановление пароля Mini.fy')
            ->send();

        return $result;
    }
}