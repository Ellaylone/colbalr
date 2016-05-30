<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use app\models\Partners;
use app\models\PartnersForm;
use yii\web\UploadedFile;


class PartnersController extends Controller
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
                'only' => ['index', 'update', 'delete', 'sort', 'status', 'type', 'parent'],
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
            'query' => Partners::findBySql('SELECT * FROM ' . Partners::tableName() . ' ORDER BY sort'),
            'pagination' => [
                'pageSize' => 100,
            ],
            'sort' => false,
        ]);

        return $this->render('/admin/partners/index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        if($id > 0){
            $data = Partners::find()->where('id=:id', [':id' => $id])->one();
            if($data){
                $model = new PartnersForm($data);
            } else {
                $this->redirect(['admin/error']);
                return false;
            }
        } else {
            $model = new PartnersForm();
        }
        if(Yii::$app->request->isPost && array_key_exists('PartnersForm', Yii::$app->request->post())){
            $data = Yii::$app->request->post()['PartnersForm'];
            if($id > 0){
                $model = Partners::findOne($id);
            } else {
                $model = new Partners();
            }
            $modelForm = new PartnersForm();
            $model->title = $data['title'];
            $model->save();
            if(UploadedFile::getInstance($modelForm, 'thumb') != null){
                $modelForm->id = $model->id;
                $modelForm->title = $model->title;
                $modelForm->thumb = UploadedFile::getInstance($modelForm, 'thumb');
                if($modelForm->upload()){
                    $model->thumb = $modelForm->thumb;
                    $model->save();
                }
            }
            $this->redirect(['partners/update', 'id' => $model->id]);
        } else {
            return $this->render('/admin/partners/update', [
                'id' => $id,
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        if($id > 0){
            $model = Partners::findOne($id);
            if($model){
                $model->delete();
            }
        }
        $this->redirect(['/partners/index']);
    }

    public function actionSort($id)
    {
        if(Yii::$app->request->post() && array_key_exists('sort', Yii::$app->request->post()) && $id > 0){
            $model = Partners::findOne($id);
            if($model){
                $model->sort = intval(Yii::$app->request->post('sort'));
                $model->save();
            }
        }
        $this->redirect(['/partners/index']);
    }

    public function actionParent($id)
    {
        if(Yii::$app->request->post() && array_key_exists('parent', Yii::$app->request->post()) && $id > 0){
            $model = Partners::findOne($id);
            if($model){
                $model->parent = intval(Yii::$app->request->post('parent'));
                $model->save();
            }
        }
        $this->redirect(['/partners/index']);
    }

    public function actionStatus($id)
    {
        $model = Partners::findOne($id);
        if($model){
            $model->status = intval(!$model->status);
            $model->save();
        }
        $this->redirect(['/partners/index']);
    }

    public function actionType($id)
    {
        $model = Partners::findOne($id);
        if($model){
            $model->type = intval(!$model->type);
            $model->save();
        }
        $this->redirect(['/partners/index']);
    }
}
