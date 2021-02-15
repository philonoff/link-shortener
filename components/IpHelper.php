<?php

namespace app\components;

use yii\base\BaseObject;
use yii\helpers\Json;

/**
 * Component handling ip address information
 */
class IpHelper extends BaseObject
{
    /**
     * Gets client's ip address
     * @return string
     */
    public function getClientIpAddress()
    {
//        return $_SERVER['HTTP_X_FORWARDED_FOR'];
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe

                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
    }

    /**
     * Gets information about country by ip address
     * @param $ip
     * @return bool|string|Json
     */
    public function getCountryByIp($ip)
    {
        $ch = curl_init('http://ipwhois.app/json/' . $ip);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($ch);
        curl_close($ch);

        return json_decode($json);
    }
}