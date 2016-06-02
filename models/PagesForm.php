<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class PagesForm extends Model
{
    public $id;
    public $title;
    public $text;
    public $url;
    public $type;
    public $status;
    public $sort;
    public $parent;
    public $description;
    public $keywords;
    public $customtype;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['title', 'type', 'status', 'sort'], 'required', 'message' => '{attribute} не может быть пустым'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'title' => 'Заголовок',
            'text' => 'Текст',
            'url' => 'Ссылка',
            'type' => 'Тип',
            'status' => 'Статус',
            'sort' => 'Порядок',
            'description' => 'META Description',
            'keywords' => 'META Keywords',
            'customtype' => 'Молекулы',
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
