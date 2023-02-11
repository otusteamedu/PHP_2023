<?php

declare(strict_types=1);

namespace Twent\BracketsValidator;

use Exception;
use Twent\BracketsValidator\Exceptions\InvalidArgumentException;
use Twent\BracketsValidator\Http\Request;
use Twent\BracketsValidator\Http\Response;
use Twent\BracketsValidator\Http\Session;

final class App
{
    public static function make(): App
    {
        return new App();
    }

    public function __construct(
        public Session $session = new Session(),
        public Request $request = new Request(),
    ) {
        $this->run();
    }

    private function run(): void
    {
        try {
            $this->getValidationResult();
            Response::make('Строка корректна');
        } catch (Exception $e) {
            Response::make($e->getMessage(), $e->getCode());
        }
    }

    public function getValidationResult(): bool
    {
        if (!$string = $this->request->string) {
            throw new InvalidArgumentException('Не передан параметр');
        }

        return Validator::run($string);
    }
}
