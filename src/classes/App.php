<?php

namespace Klobkovsky\App;

use Klobkovsky\App\Validators;

class App
{
    /**
     *
     * @return string
     * @throws Exception
     */
    public function run(): string
    {
        Validators::validateCommandLineArguments();

        $result = '';
        $args = $_SERVER['argv'];
        array_shift($args);

        foreach ($args as $email) {
            if (Validators::validateEmail($email)) {
                $result .= $email . ' - корректный email' . PHP_EOL;
            } else {
                $result .= $email . ' - некорректный email' . PHP_EOL;
            }
        }

        return $result;
    }
}
