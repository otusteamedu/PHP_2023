<?php

namespace app;

class BracketChecker
{
    public function check(): void
    {
        $brackets = $_REQUEST['string'] ?? null;

        if ($brackets == null) {
            throw new EmptyBracketSequenceException();
        }

        $bracketCounter = 0;

        for ($i = 0; $i < strlen($brackets); $i++) {
            if ($brackets[$i] == '(') {
                $bracketCounter++;
            } elseif ($brackets[$i] == ')') {
                $bracketCounter--;
                if ($bracketCounter < 0) {
                    break;
                }
            }
        }

        if ($bracketCounter == 0) {
            echo 'Правильная скобочная последовательность';
        } else {
            http_response_code(400);
            echo 'Неправильная скобочная последовательность';
        }
    }
}
