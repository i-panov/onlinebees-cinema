<?php

namespace app\controllers;

use app\models\FilmSession;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\forms\LoginForm;

class SiteController extends Controller
{
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'error', 'login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'index', 'error'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actions() {
        return [
            'error' => 'yii\web\ErrorAction',
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex() {
        return $this->render('index', ['models' => FilmSession::find()->where('time > unix_timestamp()')->orderBy('time')->all()]);
    }

    public function actionLogin() {
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->login())
            return $this->redirect(['site/index']);

        return $this->render('login', ['model' => $model]);
    }

    public function actionLogout() {
        Yii::$app->user->logout();
        return $this->redirect(['site/login']);
    }
}
