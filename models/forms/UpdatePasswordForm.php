<?php

namespace app\models\forms;

use app\models\User;
use Yii;
use yii\base\Model;

/**
 * Password update form model
 */
class UpdatePasswordForm extends Model
{
    public $old_password;
    public $new_password;
    public $password_repeat;

    public function rules()
    {
        return [
            [['old_password', 'new_password', 'password_repeat'], 'required'],
            ['old_password', function($attribute, $params) {
                $user = User::findOne(['id' => Yii::$app->user->getId()]);
                if (!$user || !Yii::$app->security->validatePassword($this->old_password, $user->password_hash)) {
                    $this->addError($attribute, "Неверный старый пароль");
                }
            }],
            ['new_password', function($attribute, $params) {
                $pattern = "/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&-+=()])(?=\S+$).{8,32}$/";
                if (!preg_match($pattern, $this->$attribute)) {
                    $this->addError($attribute, 'Пароль не соответствует требованиям');
                }
            }],
            ['password_repeat', 'compare', 'compareAttribute' => 'new_password']
        ];
    }

    /**
     * Updates user password
     * @return bool
     */
    public function update()
    {
        if ($this->validate()) {
            $user = User::findOne(['id' => Yii::$app->user->getId()]);
            if ($user) {
                $user->setPassword($this->new_password);
                return $user->save();
            }
        }
        return false;
    }
}