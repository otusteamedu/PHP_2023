<?php

declare(strict_types=1);

namespace Imitronov\Hw15\OldProject\Models;

class Sberpay
{
    const API_URL = 'https://securepayments.sberbank.ru/payment/rest/';
    const TEST_URL = 'https://3dsec.sberbank.ru/payment/rest/';
    const CURRENCY_CODE = 643;
    const LANGUAGE = 'ru';
    const RETURN_URL = '/pay/result';

    private $login;
    private $password;
    private $url;

    public function __construct()
    {
        $this->login = Yii::$app->params['SBERPAY_LOGIN'];
        $this->password = Yii::$app->params['SBERPAY_PASSWORD'];
        $isTest = Yii::$app->params['SBERPAY_TEST'];
        $this->url = $isTest ? self::TEST_URL : self::API_URL;
    }

    /**
     * Регистрация платежа в сбере
     *
     * @param int $orderNumber
     * @param float $amount
     * @return void
     */
    public function register($orderNumber, $amount)
    {
        $order = Order::findOne($orderNumber);

        if (!$order) {
            return false;
        }

        $payment = new Payment();
        $payment->order_id = $order->id;
        $payment->sum = $amount;
        $payment->result = Payment::STATUS_WAIT;
        $payment->type = Payment::TYPE_ACQUIRING;
        $payment->comment = "Внесение предоплаты через Сбербанк";
        $payment->worker_id = 10;
        $payment->is_prepayment = true;
        $payment->save();

        $result = $this->request($this->url . 'register.do?', [
            'userName' => $this->login,
            'password' => $this->password,
            'orderNumber' => $payment->id,
            'amount' => $amount * 100,
            'currency' => self::CURRENCY_CODE,
            'returnUrl' => Yii::$app->urlManager->createAbsoluteUrl([self::RETURN_URL]),
            'description' => 'Оплата по бронированию №' . $orderNumber,
            'language' => self::LANGUAGE,
            'email' => $order->client->email,
            'phone' => $order->client->phone
        ]);

        if (isset($result->formUrl)) {
            $payment->transaction_id = $result->orderId;
            $payment->save();

            return $result->formUrl;
        }

        return false;
    }

    /**
     * Проверка статуса оплаты
     *
     * @param string $paymentId
     * @return void
     */
    public function check($paymentId)
    {
        $payment = Payment::findOne($paymentId);
        if (!$payment) {
            return false;
        }

        $result = $this->request($this->url . 'getOrderStatusExtended.do?', [
            'userName' => $this->login,
            'password' => $this->password,
            'orderId' => $payment->transaction_id,
            'language' => self::LANGUAGE
        ]);

        switch ($result->orderStatus) {
            case 0:
                $payment->result = Payment::STATUS_WAIT;
                $payment->save();
                return Payment::STATUS_WAIT;
                break;
            case 2:
                $payment->result = Payment::STATUS_SUCCESS;
                $payment->save();
                return Payment::STATUS_SUCCESS;
                break;
        }

        return false;
    }

    /**
     * Отправка запроса
     *
     * @param string $url
     * @param array $params
     * @return mixed
     */
    public function request($url, $params)
    {
        $query = http_build_query($params);
        ini_set('error_reporting', 'E_ERROR');
        if ($ch = curl_init()) {
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 100000);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
            $data = curl_exec($ch);
            if ($data === false) {
                var_dump(curl_error($ch));
            }
            curl_close($ch);
        } else {
            die("NO_CURL");
        }

        return json_decode($data);
    }
}
