<?php

declare(strict_types=1);

namespace Twent\BracketsValidator\Infrastructure\Http\Action;

use Exception;
use Twent\BracketsValidator\Application\DTO\StringDTO;
use Twent\BracketsValidator\Application\UseCase\ValidateBracketsUseCase;
use Twent\BracketsValidator\Infrastructure\Contract\ActionContract;
use Twent\BracketsValidator\Infrastructure\Http\Request;
use Twent\BracketsValidator\Infrastructure\Http\ResponseEmitter;

final class ValidateAction implements ActionContract
{
    public function __construct(
        private readonly ValidateBracketsUseCase $useCase = new ValidateBracketsUseCase()
    ) {
    }

    public function handle(Request $request): void
    {
        $data = $request->string;

        try {
            $dto = new StringDTO($data);
            $this->useCase->run($dto);
            echo ResponseEmitter::make('Строка корректна');
        } catch (Exception $e) {
            echo ResponseEmitter::make($e->getMessage(), $e->getCode());
        }
    }
}
