<?php

namespace Api\Daniel\Services;

interface MessageQueueClientInterface {
    public function declareQueue($queueName);
    public function setCallback(callable $callback);
    public function startConsuming($queueName);
}