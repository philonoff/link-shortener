<?php

namespace app\models\forms;

use yii\base\Model;
use app\models\User;

/**
 * Username update form model
 */
class UpdateUsernameForm extends Model
{
    public $username;

    public function __construct($config = [])
    {
        $user = User::findOne(['id' => \Yii::$app->user->getId()]);
        if ($user) {
            $this->username = $user->username;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => 'app\models\User'],
            ['username', function($attribute, $params) {
                $pattern = "/^[a-zA-Z0-9](?:(?<![._-])[._-]|[a-zA-Z0-9]){2,18}[a-zA-Z0-9]$/";
                if (!preg_match($pattern, $this->$attribute)) {
                    $this->addError($attribute, 'Логин не соответствует требованиям');
                }
            }],
        ];
    }

    /**
     * Updates username
     * @return bool
     */
    public function update()
    {
        if ($this->validate()) {
            $user = User::findOne(['id' => \Yii::$app->user->getId()]);
            if ($user) {
                $user->username = $this->username;
                return $user->save();
            }
        }
        return false;
    }
}