<?php

declare(strict_types=1);

namespace Vp\App\Application\Handler;

use Vp\App\Application\Exception\MaxLengthString;

class LengthResultHandler extends AbstractResultHandler
{
    private const MAX_LENGTH = 20;

    /**
     * @throws MaxLengthString
     */
    public function handle(string $result): void
    {
        if (mb_strlen($result) > self::MAX_LENGTH) {
            throw new MaxLengthString('String ' . $result . ' length exceeds allowed');
        } else {
            parent::handle($result);
        }
    }
}
