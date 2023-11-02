<?php

/**
 * Входная точка в приложение - FrontController
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

namespace Amedvedev\code\applications\email_and_brackets;

use Amedvedev\code\applications\email_and_brackets\presenters\EmailValidatorPresenter;

class EmailValidatorApp
{
    /**
     * @return string
     */
    public function run(): string
    {
        $emailValidatorPresenter = new EmailValidatorPresenter();
        return $emailValidatorPresenter->render($_POST);
    }
}
