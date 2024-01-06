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

    /**
     * curl --location 'http://application.local/verifyEmail' \
     * --form 'emails[]="test@mail.ru"' \
     * --form 'emails[]="test@ya.ru"' \
     * --form 'emails[]="test@em.ru"'
     *
     * @return mixed
     */
    public function actionVerifiyEmail()
    {
        if (count($this->post) == 0){
            $this->errors[] = "Данный вызов ждет POST параметр";
            return false;
        }

        $res = [];

        if (isset($this->post['emails']) && count($this->post['emails']) > 0) {
            $emails = $this->post['emails'];

            foreach ($emails as $email){
                if (!is_string($email)){
                    $this->errors[] = "Email должен быть строкой";
                    $res[] = "'$email'";
                    continue;
                }

                $pattern = '/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/';
                if (!preg_match($pattern, $email)) {
                    $this->errors[] = "Не валидный email";
                    $res[] = "'$email'";
                    continue;
                }

                // Получить домен из email-адреса
                $domain = explode('@', $email)[1];

                // Получить MX записи для домена
                $mxRecords = [];
                if (!getmxrr($domain, $mxRecords)) {
                    $this->errors[] = "Не валидный DNS MX email";
                    $res[] = "'$email'";
                    continue;
                }

                $res[] = "$email";
            }
        } else {
            $this->errors[] = "emails не может быть пустым";
        }

        if (count($this->errors) > 0 && $res) {
            $this->errors[] = implode(', ', $res);
        }

        return $emails ? implode(', ', $emails) : '';
    }
}