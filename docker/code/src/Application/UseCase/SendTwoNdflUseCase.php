<?php

namespace IilyukDmitryi\App\Application\UseCase;

use Exception;
use IilyukDmitryi\App\Application\Builder\TwoNdflMessageBuilder;
use IilyukDmitryi\App\Application\Contract\Messenger\MessengerInterface;
use IilyukDmitryi\App\Application\Dto\TwoNdflRequest;

class SendTwoNdflUseCase
{

    public function __construct(protected readonly MessengerInterface $messenger)
    {
    }

    /**
     * @throws Exception
     */
    public function exec(TwoNdflRequest $ndflRequest): void
    {
        $twoNdflMessage = TwoNdflMessageBuilder::createFromRequest($ndflRequest);
        $this->messenger->send($twoNdflMessage);
    }
}
