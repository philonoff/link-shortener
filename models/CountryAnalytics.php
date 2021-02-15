<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Country analytics model
 *
 * @property string $url_token
 * @property string $country
 * @property int $clicks_amount
 */
class CountryAnalytics extends ActiveRecord
{
    public static function tableName()
    {
        return '{{country_analytics}}';
    }

    /**
     * Updates clicks amount
     */
    public function updateClicks()
    {
        $this->clicks_amount++;
    }

    /**
     * Fills in model with data
     * @param $url_token
     * @param $country
     */
    public function fillIn($url_token, $country)
    {
        $this->url_token = $url_token;
        $this->country = $country;
        $this->clicks_amount = 1;
    }
}