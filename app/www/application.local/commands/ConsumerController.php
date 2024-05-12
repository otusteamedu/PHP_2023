<?php

namespace app\commands;

use app\models\RabbitMq;
use app\models\RabbitMqConsumer;
use Exception;
use yii\console\Controller;

class ConsumerController extends Controller
{
    /**
     * @throws Exception
     */
    public function actionIndex(): void
    {
        $rabbit = new RabbitMq('bank_statement');
        (new RabbitMqConsumer($rabbit))();
    }
}
