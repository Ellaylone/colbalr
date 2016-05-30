<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\models\AdminContacts;
use app\models\ContactTypes;
use app\models\AdminContactsForm;

class ContactsController extends Controller
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
            'query' => AdminContacts::findBySql('select * from ' . AdminContacts::tableName() . ' order by id'),
            'pagination' => [
                'pageSize' => 100,
            ],
            'sort' => false,
        ]);

        return $this->render('/admin/contacts/index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        if($id > 0){
            $data = AdminContacts::find()->where('id=:id', [':id' => $id])->one();
            if($data){
                $model = new AdminContactsForm($data);
            } else {
                $this->redirect(['admin/error']);
                return false;
            }
        } else {
            $model = new AdminContactsForm();
        }
        if(array_key_exists('AdminContactsForm', Yii::$app->request->post())){
            $data = Yii::$app->request->post()['AdminContactsForm'];
            if($id > 0){
                $model = AdminContacts::findOne($id);
            } else {
                $model = new AdminContacts();
            }
            $model->value = $data['value'];
            $model->type = $data['type'];
            $model->save();
            $this->redirect(['contacts/update', 'id' => $model->id]);
        } else {
            $contactTypes = ContactTypes::findBySql('select * from ' . ContactTypes::tableName() . ' order by sort ASC')->all();
            $contactTypesClean = [];
            foreach($contactTypes as $k => $v){
                $contactTypesClean[$v->id] = $v->text;
            }
            return $this->render('/admin/contacts/update', [
                'id' => $id,
                'model' => $model,
                'contactTypes' => $contactTypesClean,
            ]);
        }
    }

    public function actionDelete($id)
    {
        if($id > 0){
            $model = AdminContacts::findOne($id);
            if($model){
                $model->delete();
            }
        }
        $this->redirect(['/contacts/index']);
    }
}
