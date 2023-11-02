<?php

/**
 * Вспомогательный класс для работы со строкой в виде скобок
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

namespace Amedvedev\code\applications\email_and_brackets\helpers;

class BracketsHelper
{
    /**
     * @param array $post
     * @return bool
     */
    public function handle(array $post): bool
    {
        if (empty($post['string'])) {
            return false;
        }

        $counter = 0;
        $string = $post['string'];
        //проверка на скобки
        for ($i = 0; $i < strlen($string); $i++) {
            if ($i === 0 && $string[$i] === ')') {
                $counter++;
                break;
            }
            if ($string[$i] === '(') {
                $counter++;
            } else {
                $counter--;
            }
        }

        return $counter === 0;
    }
}
