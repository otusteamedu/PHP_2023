<?php

namespace Lesson5;

class Controller
{
    public array $get;
    public array $post;
    
    public array $errors = [];

    public function actionMain()
    {
        $res = '';

        if (isset($this->get['string']) && $this->get['string'] != '') {
            $str = $this->get['string'];
            $open = 0;
            foreach (str_split($str) as $key => $symbol) {
                if ($symbol == '(') {
                    $open++;
                    $res .= $symbol;
                }
                if ($symbol == ')') {
                    if ($open == 0) {
                        $this->errors[] = "Неожиданное закрытие скобок на символе $key";
                        $res .= "'$symbol'";
                        continue;
                    }
                    $open--;
                    $res .= $symbol;
                }
            }
            if ($open > 0) {
                $this->errors[] = "Скобки не закрыты $open";
            }
            
        } else {
            $this->errors[] = "string y может быть пустым";
        }
        
        if (count($this->errors) > 0 && $res) {
            $this->errors[] = $res;
        }
        
        return $str ?? '';
    }


}