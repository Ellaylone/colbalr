<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\models\LoginForm;
use app\models\Admins;
use app\models\AdminsForm;

class AdminController extends Controller
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
                'only' => ['index', 'update', 'error', 'delete', 'logout'],
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

    public function actionError()
    {
        return false;
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Admins::findBySql('select * from ' . Admins::tableName() . ' order by id'),
            'pagination' => [
                'pageSize' => 100,
            ],
            'sort' => false,
        ]);
        return $this->render('admins/index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        if($id > 0){
            $data = Admins::find()->where('id=:id', [':id' => $id])->one();
            if($data){
                $model = new AdminsForm($data);
            } else {
                $this->redirect(['admins/error']);
                return false;
            }
        } else {
            $model = new AdminsForm();
        }
        if(array_key_exists('AdminsForm', Yii::$app->request->post())){
            $data = Yii::$app->request->post()['AdminsForm'];
            if($id > 0){
                $model = Admins::findOne($id);
            } else {
                $model = new Admins();
            }
            $model->email = $data['email'];
            if($data['password'] != ''){
                $model->password = password_hash($data['password'], PASSWORD_DEFAULT);
            }
            $model->save();
            $this->redirect(['admin/update', 'id' => $model->id]);
        } else {
            return $this->render('admins/update', [
                'id' => $id,
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        if($id > 0){
            $model = Admins::findOne($id);
            if($model){
                $model->delete();
            }
        }
        $this->redirect(['admin/index']);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            $this->redirect(['admin/index']);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        $this->redirect(['admin/']);
    }
}
