<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\models\Items;
use app\models\ItemsForm;
use yii\web\UploadedFile;


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
                'only' => ['index', 'update', 'delete', 'status', 'carousel', 'sort'],
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
            'query' => Items::findBySql('select * from ' . Items::tableName() . ' order by sort, id'),
            'pagination' => [
                'pageSize' => 100,
            ],
            'sort' => false,
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
        if(Yii::$app->request->isPost && array_key_exists('ItemsForm', Yii::$app->request->post())){
            $data = Yii::$app->request->post()['ItemsForm'];
            if($id > 0){
                $model = Items::findOne($id);
            } else {
                $model = new Items();
            }
            $modelForm = new ItemsForm();
            $model->name = $data['name'];
            $model->text = $data['text'];
            $model->save();
            if(UploadedFile::getInstance($modelForm, 'thumb') != null){
                $modelForm->id = $model->id;
                $modelForm->name = $model->name;
                $modelForm->text = $model->text;
                $modelForm->thumb = UploadedFile::getInstance($modelForm, 'thumb');
                if($modelForm->upload()){
                    $model->thumb = $modelForm->thumb;
                    $model->save();
                }
            }
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

    public function actionStatus($id)
    {
        $model = Items::findOne($id);
        if($model){
            $model->status = intval(!$model->status);
            $model->save();
        }
        $this->redirect(['/items/index']);
    }

    public function actionCarousel($id)
    {
        $model = Items::findOne($id);
        if($model){
            $model->carousel = intval(!$model->carousel);
            $model->save();
        }
        $this->redirect(['/items/index']);
    }

    public function actionSort($id)
    {
        if(Yii::$app->request->post() && array_key_exists('sort', Yii::$app->request->post()) && $id > 0){
            $model = Items::findOne($id);
            if($model){
                $model->sort = intval(Yii::$app->request->post('sort'));
                $model->save();
            }
        }
        $this->redirect(['/items/index']);
    }
}
