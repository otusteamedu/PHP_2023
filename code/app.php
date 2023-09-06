<?php

/**
 * Описание класса
 * php version 8.2.8
 *
 * @category ItIsDepricated
 * @package  AmedvedevPHP2023Otus
 * @author   Alex 150Rus <alex150rus@outlook.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @Version  GIT: 1.0.0
 * @link     http://github.com/Alex150Rus My_GIT_profile
 */

declare(strict_types=1);

namespace Amedvedev\code;

use Amedvedev\code\presenters\BracketsHandlerPresenter;
use Amedvedev\code\presenters\MainPresenter;
use Amedvedev\code\presenters\MemcachedPresenter;
use Amedvedev\code\services\EmailValidatorService;

class App
{
    public function run()
    {
        $mainPresenter = new MainPresenter();

        $bracketsHandlerPresenter = new BracketsHandlerPresenter();
        $bracketsInfoHtml = $bracketsHandlerPresenter->render($_POST);

        $memcachedPresenter = new MemcachedPresenter();
        $memcachedHtml = $memcachedPresenter->render();

        $formHtml = $mainPresenter->render();

        $emails = [
            'alex150rus@outlook.com',
            'alekhimkirus58-0@yandex.ru',
            '----@----.----',
            'admin@localhost',
            'бывший-премьер@правительство.рф'
        ];
        $emailValidatorService = new EmailValidatorService();
        $regExpValidityCheckResult = $emailValidatorService->regExpValidityCheck($emails);
        $simpleValidityCheckResult = $emailValidatorService->simpleValidityCheck($emails);


        $html = $bracketsInfoHtml . $formHtml . $memcachedHtml
            . 'Валидация при помощи регулярки: ' . json_encode($regExpValidityCheckResult) . '<br>'
            . 'Простая валидация: ' . json_encode($simpleValidityCheckResult);

        return $html;
    }
}
