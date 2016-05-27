<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\models\Pages;
use app\models\PagesForm;


class PagesController extends Controller
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
        $dataProvider = new ActiveDataProvider([
            'query' => Pages::findBySql('select * from ' . Pages::tableName()),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('/admin/pages/index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        if($id > 0){
            $data = Pages::find()->where('id=:id', [':id' => $id])->one();
            if($data){
                $model = new PagesForm($data);
            } else {
                $this->redirect(['admin/error']);
                return false;
            }
        } else {
            $model = new PagesForm();
        }
        if(array_key_exists('PagesForm', Yii::$app->request->post())){
            $data = Yii::$app->request->post()['PagesForm'];
            if($id > 0){
                $model = Pages::findOne($id);
            } else {
                $model = new Pages();
            }
            $model->title = $data['title'];
            $model->text = $data['text'];
            $model->url = $data['url'];
            $model->save();
            $this->redirect(['pages/update', 'id' => $model->id]);
        } else {
            return $this->render('/admin/pages/update', [
                'id' => $id,
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        if($id > 0){
            $model = Pages::findOne($id);
            if($model){
                $model->delete();
            }
        }
        $this->redirect(['/pages/index']);
    }
}
