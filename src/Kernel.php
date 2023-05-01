<?php

declare(strict_types=1);

namespace Twent\BracketsValidator;

use Twent\BracketsValidator\Infrastructure\Contract\ActionContract;
use Twent\BracketsValidator\Infrastructure\Contract\RequestContract;
use Twent\BracketsValidator\Infrastructure\Contract\SessionContract;
use Twent\BracketsValidator\Infrastructure\Http\Action\ValidateAction;
use Twent\BracketsValidator\Infrastructure\Http\Request;
use Twent\BracketsValidator\Infrastructure\Http\Session;

final class Kernel
{
    public function __construct(
        public SessionContract $session = new Session(),
        public RequestContract $request = new Request(),
        private readonly ActionContract $action = new ValidateAction()
    ) {
    }

    public function run(): void
    {
        $this->action->handle($this->request);
    }
}
