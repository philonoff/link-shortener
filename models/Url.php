<?php


namespace app\models;

use yii\db\ActiveRecord;

/**
 * Url model
 *
 * @property string token
 * @property string long_url
 * @property int created_at
 * @property int expiry_at
 * @property int user_id
 */
class Url extends ActiveRecord
{
    public static function tableName()
    {
        return '{{url}}';
    }

    /**
     * Sets creation time
     */
    public function setCreationTime()
    {
        $this->created_at = time();
    }

    /**
     * Sets expiry time
     */
    public function setExpiryTime($datetime)
    {
        $this->expiry_at = strtotime($datetime);
    }

}