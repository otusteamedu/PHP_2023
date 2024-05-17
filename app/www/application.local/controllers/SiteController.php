<?php

namespace app\controllers;

use app\components\RabbitMqProducer;
use app\models\BankStatementForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class SiteController extends Controller
{
    public function __construct($id, $module, private RabbitMqProducer $rabbitMQ, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

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

            if ($this->rabbitMQ->sendMessage('bank_statement', $message)) {
                Yii::$app->session->setFlash('success', 'Запрос принят в обработку');
            } else {
                Yii::$app->session->setFlash('error', 'Произошла ошибка при отправке запроса');
            }

            return $this->redirect(['index']);
        }

        return $this->render('index', compact('model'));
    }
}
