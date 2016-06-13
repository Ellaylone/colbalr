<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\models\Images;
use app\models\ImagesForm;
use yii\web\UploadedFile;


class ImagesController extends Controller
{
    public function init()
    {
        $this->layout = "admin";
        parent::init();
    }

    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'admin/error',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new ImagesForm();
        $dataProvider = new ActiveDataProvider([
            'query' => Images::findBySql('select * from ' . Images::tableName() . ' order by id'),
            'pagination' => [
                'pageSize' => 1000,
            ],
            'sort' => false,
        ]);

        if(Yii::$app->request->isPost && array_key_exists('ImagesForm', Yii::$app->request->post())){
            $data = Yii::$app->request->post()['ImagesForm'];
            $model = new Images();
            $modelForm = new ImagesForm();
            if(UploadedFile::getInstances($modelForm, 'image') != null){
                $modelForm->image = UploadedFile::getInstances($modelForm, 'image');
                $modelForm->upload();
            }
            $this->redirect(['images/index']);
        } else {
            return $this->render('/admin/images/index', [
                'dataProvider' => $dataProvider,
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        if($id > 0){
            $model = Images::findOne($id);
            if($model){
                if (file_exists('uploads/images/' . $model->image)) {
                    unlink('uploads/images/' . $model->image);
                }
                if (file_exists('uploads/images/thumb_' . $model->image)) {
                    unlink('uploads/images/thumb_' . $model->image);
                }
                $model->delete();
            }
        }
        $this->redirect(['/images/index']);
    }
}
