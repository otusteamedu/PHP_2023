<?php

declare(strict_types=1);

namespace Vp\App\Application\RabbitMq;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use Vp\App\Application\Builder\Contract\AmqpConnectionBuilderInterface;
use Vp\App\Application\RabbitMq\Contract\AmqpConnectionInterface;

class AmqpConnection implements AmqpConnectionInterface
{
    private string $host;
    private string $port;
    private string $user;
    private string $password;

    public function __construct(AmqpConnectionBuilderInterface $builder)
    {
        $this->host = $builder->getHost();
        $this->port = $builder->getPort();
        $this->user = $builder->getUser();
        $this->password = $builder->getPassword();
    }

    public function getConnection(): AMQPStreamConnection
    {
        try {
            $connection = new AMQPStreamConnection($this->host, $this->port, $this->user, $this->password);
            return $connection;
        } catch (\Exception $e) {
        }
    }
}
