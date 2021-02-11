<?php

namespace app\models\forms;

use Yii;
use app\models\User;
use yii\base\Model;

class SigninForm extends Model
{
    public $username;
    public $password;

    public function rules()
    {
        return [
            ['username', 'trim'],

            ['username', 'required'],

            ['password', 'required'],
            ['password', 'validatePassword']
        ];
    }

    public function validatePassword($attribute, $params)
    {
        $user = User::findOne(['username' => $this->username]);

        if (!$user || !\Yii::$app->security->validatePassword($this->password, $user->password_hash)) {
            $this->addError($attribute, "Неверный логин или пароль");
        }
    }

    public function signin()
    {
        if ($this->validate()) {
            $user = User::findOne(['username' => $this->username]);
            return Yii::$app->user->login($user);
        }
        return false;
    }
}