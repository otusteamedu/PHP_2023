<?php

declare(strict_types=1);

namespace Khalikovdn\Hw3;

use Exception;

class Validation
{
    /**
     * @return void
     * @throws Exception
     */
    public function run(): void
    {
        if (array_key_exists('string', $_REQUEST) && ! is_null($_REQUEST['string'])) {
            $this->validation();
        }

        include_once __DIR__ . '/../view/form.php';
    }

    /**
     * @return void
     * @throws Exception
     */
    private function validation(): void
    {
        $string = $_REQUEST['string'];
        $stringArray = str_split($string);

        $numberOpen = 0;

        for ($i = 0; $i <= count($stringArray) - 1; $i++) {
            $item = $stringArray[$i];

            if ($item == '(') {
                $numberOpen++;
            } elseif ($item == ')') {
                $numberOpen--;
            }

            if ($numberOpen < 0) {
                $this->exception();
            }
        }

        if ($numberOpen != 0) {
            $this->exception();
        }

        echo 'всё хорошо';
    }

    /**
     * @return void
     * @throws Exception
     */
    private function exception(): void
    {
        http_response_code(400);
        throw new Exception("всё плохо", 400);
    }
}
