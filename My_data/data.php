<?php

namespace My_data;

class Auto_answers
{
        public $answer01;
        public $answer02;

        public function print_answer01()
                {
                        return $this->answer01;
                }

        public function print_answer02()
                {
                        return $this->answer02;
                }

}

$auto_answers = new Auto_answers; // создаем объект класса
$auto_answers->answer01 = 'введите пожалуйста email';
$auto_answers->answer02 = 'Пожалуйста введите корректный email';

?>
s