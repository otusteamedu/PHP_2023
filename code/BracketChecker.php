<?php

namespace app;

class BracketChecker
{
    public function check($brackets): bool
    {
        if ($brackets == null) {
            throw new EmptyBracketSequenceException();
        }

        $bracketCounter = 0;

        for ($i = 0; $i < strlen($brackets); $i++) {
            if ($brackets[$i] == '(') {
                $bracketCounter++;
            }
            elseif ($brackets[$i] == ')') {
                $bracketCounter--;
                if($bracketCounter < 0) {
                    return false;
                }
            }
        }

        return $bracketCounter == 0;
    }
}
