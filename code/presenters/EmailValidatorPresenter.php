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

namespace Amedvedev\code\presenters;

use Amedvedev\code\services\EmailValidatorService;

class EmailValidatorPresenter
{
    /**
     * @param $post
     * @return string
     */
    public function render($post): string
    {
        $form = file_get_contents(__DIR__ . '/../views/email-validator-form.php');
        $result = '';

        if (!empty($post['emails'])) {
            $emailValidatorService = new EmailValidatorService();
            $result = str_replace(
                [
                    '{regExpValidityCheckResult}',
                    '{simpleValidityCheckResult}',
                    '{dnsMxValidityCheck}',
                ],
                [
                    json_encode($emailValidatorService->regExpValidityCheck($post['emails'])),
                    json_encode($emailValidatorService->simpleValidityCheck($post['emails'])),
                    json_encode($emailValidatorService->dnsMxValidityCheck($post['emails'])),
                ],
                file_get_contents(__DIR__ . '/../views/email-validator-result.php')
            );
        }

        return $form . $result;

    }
}