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
class Contacts extends ActiveRecord
{
    public static function tableName()
    {
        return Yii::$app->db->tablePrefix . 'contacts';
    }
}
