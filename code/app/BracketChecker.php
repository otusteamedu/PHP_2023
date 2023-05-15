<?php

namespace app;

require_once "../app/Response.php";

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
            $content = 'Правильная скобочная последовательность';
            $response = new Response($content);
        } else {
            $status = 400;
            $content = 'Неправильная скобочная последовательность';
            $response = new Response($content, $status);
        }
        $response->provideResponse();
    }
}
