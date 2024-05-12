<?php

namespace app\controllers;

use app\models\BankStatementForm;
use app\models\RabbitMq;
use app\models\RabbitMqProducer;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
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
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
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

    /**
     * Displays homepage
     */
    public function actionIndex()
    {
        $model = new BankStatementForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $message = ['start_time' => $model->start_time, 'end_time' => $model->end_time];

            $rabbit = new RabbitMq('bank_statement');
            (new RabbitMqProducer($rabbit))($message);

            Yii::$app->session->setFlash('success', 'Запрос принят в обработку');
            return $this->redirect(['index']);
        }

        return $this->render('index', compact('model'));
    }
}
