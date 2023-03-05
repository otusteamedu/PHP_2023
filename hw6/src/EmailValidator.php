<?php

namespace Builov\Hw6;

/**
 * Основной метод класса принимает строку или ссылку на текстовый файл (возможны 3 режима: string', 'file_local', 'file_remote')
 * и возвращает два массива подстрок:
 * - соответствующие паттерну емейла и имеющие соответсвующую MX-запись
 * - и соответствующие паттерну емейла, но не имеющие соответсвующей MX-записи
 */
class EmailValidator
{
    /** @var string паттерн емейла */
    private $pattern = "/[a-zA-Z0-9_\-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/";

    /**
     * @param $src  //Источник данных
     * @param $mode //Тип источника данных:'string', 'file_local', 'file_remote'
     * @return array[]  //Массивы валидных и невалидных адресов
     */
    public function validate($src, $mode = 'string') {
        $correct = [];
        $incorrect = [];

        switch ($mode) {
            case 'string':  //для валидации строк "на лету"
                $data[] = $src;
                break;
            case 'file_local':  //для валидации локальных файлов, в т.ч. больших
                $data = $this->getFileLinesLocal($src);
                break;
            case 'file_remote': //для валидации веб-страниц
                $data = $this->getFileLinesRemote($src);
                break;
        }

        foreach ($data as $line) {
            preg_match_all($this->pattern, $line,$out, PREG_PATTERN_ORDER);

            foreach ($out[0] as $email) {
                $hostname = explode("@", $email);

                if (getmxrr($hostname[1],$hosts)) {
                    $correct[] = $email;
                } else {
                    $incorrect[] = $email;
                }
            }
        }

        return [
            'correct' => $correct,
            'incorrect' => $incorrect
        ];
    }


    private function getFileLinesLocal($path) {
	    $file = fopen($path, 'r');
	    while (($line = fgets($file)) !== false) {
	        yield $line;
	    }
	    fclose($file);
	}

    private function getFileLinesRemote($path) {
        return file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }

}
