<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */

class AdminContacts extends ActiveRecord
{
    public function getId(){
        return $this->id;
    }

    public static function tableName()
    {
        return Yii::$app->db->tablePrefix . 'contacts';
    }
}
