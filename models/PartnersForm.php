<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * ContactForm is the model behind the contact form.
 */
class PartnersForm extends Model
{
    public $id;
    public $title;
    public $thumb;
    public $sort;
    public $status;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['title'], 'required', 'message' => '{attribute} не может быть пустым'],
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
            'status' => 'Статус',
            'sort' => 'Порядок',
            'thumb' => 'Иконка',
        ];
    }

   public function upload(){
        if ($this->validate()) {
            if (!file_exists('uploads/partners/' . $this->id)) {
                mkdir('uploads/partners/' . $this->id, 0777, true);
            }
            $thumbName = Yii::$app->security->generateRandomString() . '.' . $this->thumb->extension;
            $this->thumb->saveAs('uploads/partners/' . $this->id . '/' . $thumbName);
            $this->thumb = $thumbName;
            return true;
        } else {
            return false;
        }
    }
}
