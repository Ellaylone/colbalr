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

class Admins extends ActiveRecord implements IdentityInterface
{
    public static function findIdentity($id){
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null){
        throw new NotSupportedException();
    }

    public function getId(){
        return $this->id;
    }

    public function getAuthKey(){
        return $this->authkey;//Here I return a value of my authKey column
    }

    public function validateAuthKey($authkey){
        return $this->authkey === $authkey;
    }

    public static function findByUsername($username){
        return self::findOne(['email'=>$username]);
    }

    public function validatePassword($password){
        return password_verify($password, $this->password);
    }

    public static function tableName()
    {
        return Yii::$app->db->tablePrefix . 'admins';
    }
}
