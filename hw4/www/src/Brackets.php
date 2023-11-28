<?php
namespace Shabanov\Otusphp;

class Brackets
{
    private string $bracket;
    private Result $result;
    public function __construct()
    {
        $this->bracket = isset($_POST['string']) ? trim($_POST['string']) : '';
        $this->result = new Result();
    }

    public function check(): Result
    {
        $stack = $countOpen = $countClose = 0;
        if (!empty($this->bracket)) {
            if ($this->bracket[0] == ')') {
                $this->result->addError('Строка не может начинаться с закрытой скобки');
            } elseif ($this->bracket[mb_strlen($this->bracket)-1] == '(') {
                $this->result->addError('Строка не может заканчиваться открытой скобкой');
            }

            if (empty($this->errors)) {
                for ($i = 0; $i < mb_strlen($this->bracket); $i++) {
                    if ($this->bracket[$i] == '(') {
                        $countOpen++;
                        $stack++;
                    } elseif ($this->bracket[$i] == ')') {
                        $countClose++;
                        $stack--;
                    } else {
                        $this->result->addError('Строка не может содержать отличных от скобок символов');
                        break;
                    }
                }
            }
        } else {
            $this->result->addError('Пустая строка');
        }

        if (empty($this->errors)
            && ($countOpen != $countClose
                || $stack>0)
        ) {
            $this->result->addError('Количество открытых скобок не равно количеству закрытых скобок');
        }
        return $this->result;
    }
}
