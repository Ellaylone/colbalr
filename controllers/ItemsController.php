<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\models\Items;
use app\models\ItemsForm;


class ItemsController extends Controller
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
            'query' => Items::findBySql('select * from ' . Items::tableName()),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('/admin/items/index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        if($id > 0){
            $data = Items::find()->where('id=:id', [':id' => $id])->one();
            if($data){
                $model = new ItemsForm($data);
            } else {
                $this->redirect(['admin/error']);
                return false;
            }
        } else {
            $model = new ItemsForm();
        }
        if(array_key_exists('ItemsForm', Yii::$app->request->post())){
            $data = Yii::$app->request->post()['ItemsForm'];
            if($id > 0){
                $model = Items::findOne($id);
            } else {
                $model = new Items();
            }
            $model->name = $data['name'];
            $model->text = $data['text'];
            $model->save();
            $this->redirect(['items/update', 'id' => $model->id]);
        } else {
            return $this->render('/admin/items/update', [
                'id' => $id,
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        if($id > 0){
            $model = Items::findOne($id);
            if($model){
                $model->delete();
            }
        }
        $this->redirect(['/items/index']);
    }
}
