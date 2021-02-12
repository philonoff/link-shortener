<?php

namespace app\models\forms;

use yii\base\Model;
use yii\base\InvalidArgumentException;
use app\models\User;

/**
 * Reset password form model
 */
class ResetPasswordForm extends Model
{
    private $user;

    public $password;
    public $password_repeat;

    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('Password reset token cannot be blank.');
        }
        $this->user = User::findByPasswordResetToken($token);
        if (!$this->user) {
            throw new InvalidArgumentException('Wrong password reset token.');
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
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
     * Resets user password
     * @return bool whether password is reset successfully
     */
    public function resetPassword()
    {
        $this->user->setPassword($this->password);
        $this->user->password_reset_token = null;

        return $this->user->save();
    }
}