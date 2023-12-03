<?php

namespace Myklon\Hw4\Services;

use Myklon\Hw4\Services\MemcachedBrackets;

class BracketValidator
{
    public static function validate()
    {
        $cache = new MemcachedBrackets();

        $pattern = "/[^()]/";
        $bracketString = preg_replace($pattern, "", $_POST['string']);
        if (empty($bracketString)) {
            throw new \Exception("Empty bracket sequence.");
        }

        $cachedValue = $cache->getCachedBracketString($bracketString);
        if (isset($cachedValue)) {
            if ($cachedValue === "not valid") {
                throw new \Exception("Not valid bracket sequence.");
            }
            if ($cachedValue == true) {
                return;
            }
        }

        $lenght = strlen($bracketString);
        $cost = 0;

        for ($i = 0; $i < $lenght; $i++) { 
            if ($bracketString[$i] === "(") {
                $cost++;
            }

            if ($bracketString[$i] === ")") {
                $cost--;
            }

            if ($cost === -1) {
                $cache->cacheBracketString($bracketString, "not valid");
                throw new \Exception("Not valid bracket sequence.");
            }
        }

        if ($cost !== 0) {
            $cache->cacheBracketString($bracketString, "not valid");
            throw new \Exception("Not valid bracket sequence.");
        }

        $cache->cacheBracketString($bracketString, true);
    }
}
