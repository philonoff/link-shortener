<?php

namespace app\components;

use yii\base\BaseObject;

/**
 * Component for generating token of different length
 */
class TokenGenerator extends BaseObject
{
    public function generate($tokenLength)
    {
        $map = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $token = "";

        for($i = 0; $i < $tokenLength; $i++) {
            $token .= $map[random_int(0, 61)];
        }

        return $token;
    }
}