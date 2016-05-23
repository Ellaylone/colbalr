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
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
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
        $contracTypesForm = ContactTypes::findBySql('select * from ' . ContactTypes::tableName() . ' order by sortform ASC')->all();;
        $items = Items::find()
            ->where(['status' => 1, 'carousel' => 1])
            ->orderBy('sort')
            ->all();

        return $this->render('index', [
            'page' => $page,
            'contacts' => $contacts,
            'contactTypes' => $contactTypes,
            'contracTypesForm' => $contracTypesForm,
            'items' => $items,
            'catalogLimit' => 8,
            'partnersLimit' => 4,
        ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
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

        return $this->goHome();
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

    public function actionAbout()
    {
        return $this->render('about');
    }
}
