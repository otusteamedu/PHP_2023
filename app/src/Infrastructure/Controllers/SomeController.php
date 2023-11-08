<?php

namespace App\Infrastructure\Controllers;

use App\Infrastructure\Request\Request;
use App\Infrastructure\Response\Response;

class SomeController
{
    /**
     * Бэк состоит из одного метода контроллера и выполняет следующие действия:
     * - Валидирует данные, если в данных есть ошибка, то возвращает сообщение об ошибке с кодом 400;
     * - Если данные верные, то передаёт их в API-запросе на сервис A. Сервис A пытается списать деньги,
     *   если ему это не удаётся, то он возвращает HTTP-код 403, если удаётся, то HTTP-код 200;
     * - В случае ошибки передаём её обратно на фронт.
     * - В случае успешного списания денег необходимо записать в БД информацию об успешной оплате.
     *   Предполагаем, что у нас есть соответствующий метод репозитория setOrderIsPaid(string $orderNumber, float $sum): bool,
     *   реализованный ранее. Метод проверяет соответствие номера заказа и его суммы и возвращает true,
     *   если списание успешно. В случае ошибок выбрасываются различные исключения.
     *
     * @param Request $request
     * @return Response
     */
    public function someAction(Request $request): Response
    {
        try {
            $request->validate();
        } catch (\Exception $e) {
            return new Response(400, $e->getMessage());
        }


    }
}
