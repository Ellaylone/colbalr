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
                'only' => ['index', 'update', 'delete', 'sort', 'status', 'type', 'parent', 'customtype'],
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
            'query' => Pages::findBySql('SELECT * FROM ' . Pages::tableName() . ' ORDER BY case when parent=0 then id else parent end * 1000 + id ASC'),
            'pagination' => [
                'pageSize' => 100,
            ],
            'sort' => false,
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
            $model->keywords = $data['keywords'];
            $model->description = $data['description'];
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

    public function actionSort($id)
    {
        if(Yii::$app->request->post() && array_key_exists('sort', Yii::$app->request->post()) && $id > 0){
            $model = Pages::findOne($id);
            if($model){
                $model->sort = intval(Yii::$app->request->post('sort'));
                $model->save();
            }
        }
        $this->redirect(['/pages/index']);
    }

    public function actionParent($id)
    {
        if(Yii::$app->request->post() && array_key_exists('parent', Yii::$app->request->post()) && $id > 0){
            $model = Pages::findOne($id);
            if($model){
                $model->parent = intval(Yii::$app->request->post('parent'));
                $model->save();
            }
        }
        $this->redirect(['/pages/index']);
    }

    public function actionStatus($id)
    {
        $model = Pages::findOne($id);
        if($model){
            $model->status = intval(!$model->status);
            $model->save();
        }
        $this->redirect(['/pages/index']);
    }

    public function actionType($id)
    {
        $model = Pages::findOne($id);
        if($model){
            $model->type = intval(!$model->type);
            $model->save();
        }
        $this->redirect(['/pages/index']);
    }

    public function actionCustomtype($id)
    {
        $model = Pages::findOne($id);
        if($model){
            $model->customtype = intval(!$model->customtype);
            $model->save();
        }
        $this->redirect(['/pages/index']);
    }
}
