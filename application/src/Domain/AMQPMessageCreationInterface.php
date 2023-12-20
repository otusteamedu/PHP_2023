<?php

namespace Gesparo\Homework\Domain;

use Gesparo\Homework\Domain\ValueObject\PublisherBankStatementRequest;
use PhpAmqpLib\Message\AMQPMessage;

interface AMQPMessageCreationInterface
{
    public function create(PublisherBankStatementRequest $bankStatementRequest): AMQPMessage;
}
