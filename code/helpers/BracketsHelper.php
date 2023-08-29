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

namespace Amedvedev\code\helpers;

class BracketsHelper
{

    /**
     * @param array $post
     * @return bool
     */
    public function handle(array $post): bool
    {
        if (isset($post['string'])) {
            $string = $post['string'];
            //проверка на не пустоту
            if (!$string) {
                return false;
            }

            $array = [];
            //проверка на скобки - стэк
            for ($i = 0; $i < strlen($string) ; $i++) {
                if ($i === 0 && $string[$i] === ')') {
                    break;
                }

                if ($i === 0) {
                    $array[] = $string[$i];
                    continue;
                }

                if (!empty($array) && $array[array_key_last($array)] == '(' && $string[$i] === ')') {
                    unset($array[array_key_last($array)]);
                } else {
                    $array[] = $string[$i];
                }
            }

            if (!empty($array)) {
                return false;
            }
        }
        return true;
    }
}
