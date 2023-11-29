<?php

namespace Radovinetch\Code;

use RuntimeException;
use Throwable;

class Validator
{
    /**
     * @throws RuntimeException
     */
    public function validate(): void
    {
        try {
            $string = $_POST['string'] ?? null;
            if (empty($string)) {
                throw new RuntimeException('Строка неккоректна: не допускается пустая строка');
            }

            $string = str_split($string);

            $i = 0;
            $j = $i;
            $k = $j;
            $length = count($string) - 1;

            $count = 0;

            while ($i <= $length) {
                if ($string[$i] === '(') {
                    $count++;
                    $j = $k;
                    while ($j < $length) {
                        $j++;
                        if ($string[$j] === ')') {
                            $k = $j;
                            $i++;
                            continue 2;
                        }
                    }
                    throw new RuntimeException('Строка неккоректна: не закрыта скобка в позиции ' . $i);
                } else if ($string[$i] === ')') {
                    $count--;
                    $i++;
                } else {
                    throw new RuntimeException('Строка неккоректна: неизвестный символ в позиции ' . $i);
                }
            }

            if ($count !== 0) { //проверка на лишние скобки
                throw new RuntimeException('Строка неккоректна: есть лишние скобки');
            }

            echo 'Строка корректна';
            http_response_code(200);
        } catch (Throwable $t) {
            echo $t->getMessage();
            http_response_code(400);
        }
    }
}