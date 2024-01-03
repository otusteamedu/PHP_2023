<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\ORMSetup;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;
use Symfony\Component\Messenger\Middleware\SendMessageMiddleware;
use Symfony\Component\Messenger\Transport\Sender\SendersLocator;

return [
    Common\Application\ConfigInterface::class => DI\autowire(Common\Application\Config::class),
    Common\Application\AppInterface::class => DI\autowire(Common\Application\WebApp::class),

    \Sunrise\Http\Router\OpenApi\OpenApi::class => DI\factory(function (ContainerInterface $c) {
        $openapi = new Sunrise\Http\Router\OpenApi\OpenApi(new Sunrise\Http\Router\OpenApi\Object\Info('Acme2', '1.0.0'));
        $app = new \Common\Application\WebApp($c, config());
        $router = $app->getRouter();
        $openapi->addRoute(...$router->getRoutes());

        $j = $openapi->toJson();

        return $openapi;
    }),


    \Doctrine\ORM\EntityManagerInterface::class => DI\factory(function (ContainerInterface $c) {
        $doctrineConfig = ORMSetup::createAttributeMetadataConfiguration(
            config()->get('doctrine.metadata_dirs'),
            config()->get('doctrine.dev_mode')
        );

        $doctrineConfig->setProxyDir(config()->get('doctrine.cache_dir'));
        $doctrineConfig->setProxyNamespace('Proxies');

        $connection = DriverManager::getConnection(
            config()->get('doctrine.connection'),
            $doctrineConfig
        );

        return new Doctrine\ORM\EntityManager($connection, $doctrineConfig);
    }),

    LoggerInterface::class => DI\factory(function (ContainerInterface $c) {
        $logger = new \Monolog\Logger('app');
        $p = config()->get('logger.path');
        $logger->pushHandler(new \Monolog\Handler\StreamHandler($p, \Monolog\Logger::DEBUG));

        return $logger;
    }),

    // queue
    \Symfony\Component\Messenger\MessageBusInterface::class => DI\factory(function (ContainerInterface $c) {
        $logger = $c->get(LoggerInterface::class);

        $sender = (new SendMessageMiddleware(
            new SendersLocator(
                [
                    \Ad\Domain\Ad::class => ['rabbit'],
                ],
                container()
            )
        ));
        $sender->setLogger($logger);

        $handler = new HandleMessageMiddleware(
            new HandlersLocator([
                \Ad\Domain\Ad::class => [
                    new \Ad\App\AdHandler()
                ]
            ])
        );
        $handler->setLogger($logger);

        $bus = new MessageBus([
            $sender,
            $handler
        ]);

        return $bus;
    }),

    \Psr\EventDispatcher\EventDispatcherInterface::class => DI\create(\Symfony\Component\EventDispatcher\EventDispatcher::class),

    'rabbit-connection' => DI\factory(function (ContainerInterface $c) {
        return new \Symfony\Component\Messenger\Bridge\Amqp\Transport\Connection(
            [
                'host' => config()->get('rabbit-mq.host'),
                'port' => config()->get('rabbit-mq.port'),
                'user' => config()->get('rabbit-mq.user'),
                'password' => config()->get('rabbit-mq.password'),
                'vhost' => config()->get('rabbit-mq.vhost'),
            ],
            [
                'name' => 'ad',
                'type' => 'direct',
//                'auto_setup' => true,
//                'declare' => true,
//                'durable' => true,
//                'binding_keys' => ['messenger'],
            ],
            [
                'ad' => [
                    'name' => 'ad'
                ],
//                'binding_arguments' => [],
//                'flags' => 2,
//                'arguments' => []
            ]
        );
    }),

    'rabbit' => DI\factory(function (ContainerInterface $c) {
        return new \Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpTransport($c->get('rabbit-connection'));
    }),

    'receiver' => DI\factory(function (ContainerInterface $c) {
        return new \Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpReceiver($c->get('rabbit-connection'));
    }),
];