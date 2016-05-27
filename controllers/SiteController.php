<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Pages;
use app\models\Contacts;
use app\models\ContactTypes;
use app\models\Items;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $page = Pages::find()
            ->where(['url' => "homepage"])
            ->one();

        $contacts = Contacts::findBySql('select * from ' . Contacts::tableName())->all();
        $contactTypes = ContactTypes::findBySql('select * from ' . ContactTypes::tableName() . ' order by sort ASC')->all();
        $contactTypesForm = ContactTypes::findBySql('select * from ' . ContactTypes::tableName() . ' order by sortform ASC')->all();;
        $items = Items::find()
            ->where(['status' => 1, 'carousel' => 1])
            ->orderBy('sort')
            ->all();
        $model = new ContactForm();

        if ($model->load(Yii::$app->request->post()) && $model->contact('heamik91@yandex.ru')) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }

        return $this->render('index', [
            'page' => $page,
            'contacts' => $contacts,
            'contactTypes' => $contactTypes,
            'contactTypesForm' => $contactTypesForm,
            'items' => $items,
            'catalogLimit' => 8,
            'partnersLimit' => 4,
            'model' => $model,
        ]);
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionView($url)
    {
        $page = Pages::find()
              ->where(['status' => 1])
              ->andWhere(['type' => 1])
              ->andWhere('url=:url', [':url' => $url])
              ->one();

        if($page){
            return $this->render('page', [
                'page' => $page
            ]);
        }
        throw new \yii\web\NotFoundHttpException();
    }
}
