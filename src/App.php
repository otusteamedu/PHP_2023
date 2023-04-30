<?php

declare(strict_types=1);

namespace Twent\BracketsValidator;

use Exception;
use Twent\BracketsValidator\Http\Request;
use Twent\BracketsValidator\Http\Response;
use Twent\BracketsValidator\Http\Session;

final class App
{
    public function __construct(
        public Session $session = new Session(),
        public Request $request = new Request(),
    ) {
        $this->run();
    }

    public static function make(): App
    {
        return new App();
    }

    private function run(): void
    {
        try {
            $this->getValidationResult();
            echo Response::make('Строка корректна');
        } catch (Exception $e) {
            echo Response::make($e->getMessage(), $e->getCode());
        }
    }

    private function getValidationResult(): bool
    {
        $string = $this->request->string;

        return Validator::run($string);
    }
}
