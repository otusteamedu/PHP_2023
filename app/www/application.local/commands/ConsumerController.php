<?php

namespace app\commands;

use app\components\RabbitMqConsumer;
use yii\console\Controller;

class ConsumerController extends Controller
{
    public function __construct($id, $module, private RabbitMqConsumer $rabbitMqConsumer, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function actionIndex(): void
    {
        $this->rabbitMqConsumer->consume('bank_statement');
    }
}
