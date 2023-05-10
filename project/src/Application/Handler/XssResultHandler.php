<?php

declare(strict_types=1);

namespace Vp\App\Application\Handler;

use Vp\App\Application\Exception\XssString;

class XssResultHandler extends AbstractResultHandler
{
    /**
     * @throws XssString
     */
    public function handle(string $result): void
    {
        if (preg_match('/(<script>(.*?)<\/script>)/', $result)) {
            throw new XssString('String contains ' . $result . ' invalid characters');
        } else {
            parent::handle($result);
        }
    }
}
