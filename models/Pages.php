<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class Pages extends ActiveRecord
{
    function __construct($url) {
        //var_dump($url);
        // $this->name = $name;
   }
    // public function getPage

    public static function tableName()
    {
        return Yii::$app->db->tablePrefix . 'pages';
    }
}
