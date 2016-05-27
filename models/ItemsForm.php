<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ItemsForm extends Model
{
    public $id;
    public $name;
    public $text;
    public $thumb;
    public $carousel;
    public $status;
    public $sort;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'text', 'thumb', 'carousel', 'status', 'sort'], 'required'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'name' => 'Название',
            'text' => 'Текст',
            'thumb' => 'Изображение',
            'carousel' => 'Слайдер',
            'status' => 'Статус',
            'sort' => 'Порядок',
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
