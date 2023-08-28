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
    public function handle(array $post)
    {
        if (isset($post['string'])) {
            $string = $post['string'];
            //проверка на не пустоту
            if (!$string) {
                header('HTTP/1.1 400 Bad Request', true, 400);
                echo '<span style="color:red">Строка со скобками не верна</span>' . $string . '<br>';
                echo '<form method="POST"><input style="width: 199px" name="string" value="(()()()()))((((()()()))(()()()(((()))))))">' .
                    '<p><button>Отправить</button></p></form>';
                exit;
            }

            $array = [];
            $stringArray = str_split($string);
            //проверка на скобки - стэк
            for ($i = 0; $i < count($stringArray); $i++) {
                if ($i === 0 && $stringArray[$i] === ')') {
                    $array[] = $stringArray[$i];
                    break;
                }

                if ($i === 0) {
                    $array[] = $stringArray[$i];
                    continue;
                }

                if (!empty($array) && $array[array_key_last($array)] == '(' && $stringArray[$i] === ')') {
                    unset($array[array_key_last($array)]);
                } else {
                    $array[] = $stringArray[$i];
                }
            }

            if (!empty($array)) {
                header('HTTP/1.1 400 Bad Request', true, 400);
                echo '<span style="color:red">Строка со скобками не верна</span>' . $string . '<br>';
            } else {
                echo '<span>Строка со скобками верна</span>' . $string . '<br>';
            }
        }


        echo '<form method="POST"><input style="width: 199px" name="string" value="(()()()()))((((()()()))(()()()(((()))))))">' .
            '<p><button>Отправить</button></p></form>';
    }
}
