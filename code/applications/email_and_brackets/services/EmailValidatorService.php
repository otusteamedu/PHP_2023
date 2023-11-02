<?php

/**
 * Валидатор Email
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

namespace Amedvedev\code\applications\email_and_brackets\services;

class EmailValidatorService
{
    /**
     * @param array $array
     * @return array
     */
    public function simpleValidityCheck(array $array): array
    {
        $answerArray = [];
        foreach ($array as $email) {
            if (!$email) {
                continue;
            }
            $answerArray[$email] = (bool)filter_var($email, FILTER_VALIDATE_EMAIL);
        }
        return $answerArray;
    }

    /**
     * @param array $array
     * @return array
     */
    public function regExpValidityCheck(array $array): array
    {
        $answerArray = [];
        foreach ($array as $email) {
            if (!$email) {
                continue;
            }
            $answerArray[$email] = (bool)preg_match(
                "/^[-a-z0-9!#$%&'*+\/=?^_`{|}~]+(?:\.[-a-z0-9!#$%&'*+\/=?^_`{|}~]+)*@(?:[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])?\.)*(?:aero|arpa|asia|biz|cat|com|coop|edu|gov|info|int|jobs|mil|mobi|museum|name|net|org|pro|tel|travel|[a-z][a-z])$/",
                $email
            );
        }
        return $answerArray;
    }

    /**
     * @param array $array
     * @return array
     */
    public function dnsMxValidityCheck(array $array): array
    {
        $answerArray = [];
        foreach ($array as $email) {
            if (!$email) {
                continue;
            }
            $hostName = explode('@', $email)[1] ?? '';
            $answerArray[$email] = getmxrr($hostName, $hosts);
        }
        return $answerArray;
    }
}
