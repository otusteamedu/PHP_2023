<?php

namespace app;

class BracketChecker
{
    public function check($brackets): bool
    {
        if ($brackets == null) {
            throw new EmptyBracketSequenceException();
        }

        $openBracketCounter = 0;
        $closeBracketCounter = 0;

        for ($i = 0; $i < strlen($brackets); $i++) {
            if ($brackets[$i] == '(') {
                $openBracketCounter++;
            }
            elseif ($brackets[$i] == ')') {
                $closeBracketCounter++;
                if ($closeBracketCounter > $openBracketCounter) {
                    return false;
                }
            }
        }

        return $openBracketCounter == $closeBracketCounter;
    }
}
