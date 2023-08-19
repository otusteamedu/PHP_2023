<?php

declare(strict_types=1);

$examples = [
    '()',
    ')(',
    '',
    ' ',
    '(())()()(())',
    '(())()()(()))',
    '(())()()(()))()',
    '(())()()(())(',
    '(())()()(())((',
    '(())()()(())(()',
    '(())()()(())e()',
    '(())()()(()).()',
    '-',
    'null',
    '0',
    'true',
    'false',
    '{}',
    '++',
    '-',
    '<?php echo(sprintf("%5s", "Hi, Tester!"));',
    '<?php echo(sprintf("%5s", "Ai-aai :)"));',
    '(()()()()))((((()()()))(()()()(((()))))))',
    '(()()()()) ((((()()()))(()()()(((()))))))',
];


foreach ($examples as $example) {
    $response = [];
    $ex = sprintf("%-42s", $example);
    echo '| ' . $ex . '|';
    $checkedStatus = checkString($example, $response);
    $status = sprintf("%-8s", !$checkedStatus ? 'OK' : 'Error');
    echo $status;
    echo '|';
    $readableStatus = sprintf("%-14s", getReadableStatus($checkedStatus) . ' ' .($response['ind']??''));
    echo $readableStatus;
    echo '|';
    echo PHP_EOL;
}

function getReadableStatus(int $status)
{
    return match ($status) {
        1 => 'empty',
        2 => 'error',
        3 => 'count',
        4 => 'unknown',
        0 => 'success',
        default => 'unexpected',
    };
}

function fmatch($symbol, &$stack): bool
{
    $skipNotBracketSymbolOrException = true;
    try {
        $doMatch = match ($symbol) {
            '(' => static fn() => $stack->push($symbol),
            ')' => static fn() => $stack->pop(),
            default => static fn() =>
                $skipNotBracketSymbolOrException ?
                    $stack->count() :
                    throw new Exception('unknown symbol'),
        };
        $doMatch();

    } catch (Exception $exception) {
        //echo '`'.$symbol.'`';
        return false;
    }

    return true;
}


function checkString(string $str, array &$response): int
{
    $len = strlen($str);
    if (!$len) {
        return 1;
    }

    $stack = new SplStack();
    $blIsValid = true;
    for ($i = 0; $i < $len; $i++) {
        $isMatched = fmatch($str[$i], $stack);
        if(!$isMatched) {
            $response['ind'] = $i;
            return 4;
        }
        $blIsValid &= $isMatched;
    }

    if(!$blIsValid) {
        return 2;
    }

    if($stack->count()) {
        return 3;
    }

    return 0;
}
