<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

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

    public static function tableName()
    {
        return Yii::$app->db->tablePrefix . 'items';
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['thumb'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['name', 'text'], 'required', 'message' => '{attribute} не может быть пустым'],
        ];
    }

    public function upload(){
        if ($this->validate()) {
            if (!file_exists('uploads/items/' . $this->id)) {
                mkdir('uploads/items/' . $this->id, 0777, true);
            }
            $thumbName = Yii::$app->security->generateRandomString() . '.' . $this->thumb->extension;
            $this->thumb->saveAs('uploads/items/' . $this->id . '/' . $thumbName);
            $this->thumb = $thumbName;
            return true;
        } else {
            return false;
        }
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
}
