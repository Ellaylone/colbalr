<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class Images extends ActiveRecord
{
    public static function tableName()
    {
        return Yii::$app->db->tablePrefix . 'images';
    }
}
