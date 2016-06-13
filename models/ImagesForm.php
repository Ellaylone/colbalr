<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\imagine\Image;
use app\models\Images;

/**
 * ContactForm is the model behind the contact form.
 */
class ImagesForm extends Model
{
    public $id;
    public $image;

    public static function tableName()
    {
        return Yii::$app->db->tablePrefix . 'images';
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => '30'],
        ];
    }

    public function upload(){
        if ($this->validate()) {
            foreach ($this->image as $file) {
                $model = new Images();
                $imageName = Yii::$app->security->generateRandomString() . '.' . $file->extension;
                $file->saveAs('uploads/images/' . $imageName);
                Image::thumbnail('uploads/images/' . $imageName, 100, 100)
                                                   ->save(Yii::getAlias('uploads/images/thumb_' . $imageName), ['quality' => 70]);
                $model->image = $imageName;
                $model->save();
            }
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
            'image' => 'Изображение',
        ];
    }
}
