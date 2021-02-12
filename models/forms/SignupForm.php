<?php

namespace app\models\forms;

use app\models\User;
use yii\base\Model;

/**
 * Sign up form model
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_repeat;

    public function rules()
    {
        return [
            [['username', 'email'], 'trim'],

            ['username', 'required'],
            ['username', 'unique', 'targetClass' => 'app\models\User'],
            ['username', function($attribute, $params) {
                $pattern = "/^[a-zA-Z0-9](?:(?<![._-])[._-]|[a-zA-Z0-9]){2,18}[a-zA-Z0-9]$/";
                if (!preg_match($pattern, $this->$attribute)) {
                    $this->addError($attribute, 'Логин не соответствует требованиям');
                }
            }],

            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => 'app\models\User'],

            ['password', 'required'],
            ['password', function($attribute, $params) {
                $pattern = "/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&-+=()])(?=\S+$).{8,32}$/";
                if (!preg_match($pattern, $this->$attribute)) {
                    $this->addError($attribute, 'Пароль не соответствует требованиям');
                }
            }],

            ['password_repeat', 'required'],

            ['password_repeat', 'compare', 'compareAttribute' => 'password']
        ];
    }

    /**
     * Signs user up
     * @return bool whether the creating new account was successful
     */
    public function save()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            return $user->save();
        }
        return false;
    }

}