<?php


namespace IilyukDmitryi\App\Validation;

use \Ilyukdim\OtusCheckers\Checkers;
use \Ilyukdim\OtusCheckers\Types\Brackets;


class Bracket implements Validation
{
    /**
     * @var Checkers $checkers
     */
    private Checkers $checkers;

    public function check(string $str): bool
    {
        $this->makeChecker();
        return $this->checkers->check($str);
    }

    private function makeChecker(): void
    {
        $this->checkers = new Checkers();
        $checker = new Brackets();
        $this->checkers->addChecker($checker);
    }
}