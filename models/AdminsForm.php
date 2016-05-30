<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class AdminsForm extends Model
{
    public $id;
    public $email;
    public $password;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email'], 'required', 'message' => '{attribute} не может быть пустым'],
            ['email', 'email'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'email' => 'E-mail:',
            'password' => 'Пароль',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return boolean whether the model passes validation
     */
    public function contact($email)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                 ->setTo($email)
                 ->setSubject('Лаборатория рекламы - Обратная связь')
                 ->setFrom([$this->email => $this->name])
                 ->setTextBody($this->body)
                 ->send();

            return true;
        }
        return false;
    }
}
