<?php

declare(strict_types=1);

use Vp\App\Application\Builder\AmqpConnectionBuilder;
use Vp\App\Application\ConsoleApp;
use Vp\App\Application\Contract\AppInterface;
use Vp\App\Application\Contract\ConsoleDataInterface;
use Vp\App\Application\Contract\EmailDataInterface;
use Vp\App\Application\Contract\HelpDataInterface;
use Vp\App\Application\Contract\MailerInterface;
use Vp\App\Application\Contract\OutputInterface;
use Vp\App\Application\Handler\BankStatementConsoleHandler;
use Vp\App\Application\Handler\Contract\ConsoleHandlerInterface;
use Vp\App\Application\Handler\Contract\EmailHandlerInterface;
use Vp\App\Application\Handler\BankStatementEmailHandler;
use Vp\App\Application\RabbitMq\Contract\RabbitReceiverInterface;
use Vp\App\Application\RabbitMq\RabbitReceiver;
use Vp\App\Application\UseCase\ConsoleDataProcess;
use Vp\App\Application\UseCase\Contract\StatementGeneratorInterface;
use Vp\App\Application\UseCase\EmailDataProcess;
use Vp\App\Application\UseCase\HelpData;
use Vp\App\Application\UseCase\StatementGenerator;
use Vp\App\Infrastructure\Console\CommandProcessor;
use Vp\App\Infrastructure\Console\Commands\CommandConsole;
use Vp\App\Infrastructure\Console\Commands\CommandEmail;
use Vp\App\Infrastructure\Console\Commands\CommandHelp;
use Vp\App\Infrastructure\Console\Contract\CommandProcessorInterface;
use Vp\App\Infrastructure\Console\Output;
use Vp\App\Infrastructure\Mail\Contract\SmtpMailerInterface;
use Vp\App\Infrastructure\Mail\Mailer;
use Vp\App\Infrastructure\Mail\SmtpMailer;

return [
    AppInterface::class => DI\create(ConsoleApp::class)
        ->constructor(DI\get(CommandProcessorInterface::class)),

    CommandProcessorInterface::class => DI\create(CommandProcessor::class),

    OutputInterface::class => DI\create(Output::class),

    StatementGeneratorInterface::class => DI\create(StatementGenerator::class),

    SmtpMailerInterface::class => DI\create(SmtpMailer::class)
        ->constructor($_ENV['SMTP_EMAIL'], $_ENV['SMTP_LOGIN'], $_ENV['SMTP_PASSWORD']),

    MailerInterface::class => DI\create(Mailer::class)
        ->constructor(
            DI\get(SmtpMailerInterface::class)
        ),

    ConsoleHandlerInterface::class => DI\create(BankStatementConsoleHandler::class)
        ->constructor(
            DI\get(StatementGeneratorInterface::class),
            DI\get(OutputInterface::class),
        ),

    EmailHandlerInterface::class => DI\create(BankStatementEmailHandler::class)
        ->constructor(
            DI\get(StatementGeneratorInterface::class),
            DI\get(MailerInterface::class),
        ),

    'help' => DI\create(CommandHelp::class)
        ->constructor(DI\get(HelpDataInterface::class)),
    'console' => DI\create(CommandConsole::class)
        ->constructor(DI\get(ConsoleDataInterface::class)),
    'email' => DI\create(CommandEmail::class)
        ->constructor(DI\get(EmailDataInterface::class)),

    HelpDataInterface::class => DI\create(HelpData::class),

    RabbitReceiverInterface::class => DI\create(RabbitReceiver::class)
        ->constructor(
            (new AmqpConnectionBuilder())
                ->setHost($_ENV['RBMQ_HOST'])
                ->setPort($_ENV['RBMQ_PORT'])
                ->setUser($_ENV['RBMQ_USER'])
                ->setPassword($_ENV['RBMQ_PASSWORD'])
                ->build()
        ),

    ConsoleDataInterface::class => DI\create(ConsoleDataProcess::class)
        ->constructor(
            DI\get(RabbitReceiverInterface::class),
            DI\get(ConsoleHandlerInterface::class)
        ),

    EmailDataInterface::class => DI\create(EmailDataProcess::class)
        ->constructor(
            DI\get(RabbitReceiverInterface::class),
            DI\get(EmailHandlerInterface::class)
        ),

];
