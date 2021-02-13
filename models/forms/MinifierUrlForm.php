<?php

namespace app\models\forms;

use yii\base\Model;
use app\models\Url;
use Yii;

/**
 * Minifier url form model
 */
class MinifierUrlForm extends Model
{
    public $long_url;
    public $expiry_at;

    public function rules()
    {
        return [
            ['long_url', 'trim'],
            ['long_url' , 'required', 'message' => 'Введите ссылку для минификации'],
            ['long_url', 'url', 'defaultScheme' => 'https', 'message' => 'Неверный формат ссылки'],

            ['expiry_at', 'required', 'message' => 'Введите дату истечения действия ссылки'],
            ['expiry_at', 'date', 'format' => "php:Y-m-d H:i", 'message' => 'Неверный формат даты'],
            ['expiry_at', function($attribute, $params) {
                if (strtotime($this->$attribute) < time()) {
                    $this->addError($attribute, 'Минимальный срок жизни ссылки 1 день');
                }
            }],
        ];
    }


    /**
     * Saves url
     * @return Url|false
     */
    public function save()
    {
        $url = new Url();
        $url->token = Yii::$app->token->generate(Yii::$app->params['shortUrlTokenLength']);
        $url->long_url = $this->long_url;
        $url->setCreationTime();
        $url->setExpiryTime($this->expiry_at);
        $url->user_id = (!Yii::$app->user->isGuest) ? Yii::$app->user->getId() : null ;

        if ($url->save()) {
            return $url;
        }

        return false;
    }

}