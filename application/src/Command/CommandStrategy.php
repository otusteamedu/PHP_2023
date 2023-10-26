<?php

declare(strict_types=1);

namespace Gesparo\ES\Command;

use Gesparo\ES\ArgvManager;

class CommandStrategy
{
    private const BULK_COMMAND = 'bulk';
    private const SEARCH_COMMAND = 'search';
    private const DELETE_INDEX_COMMAND = 'delete-index';
    private const CREATE_INDEX_COMMAND = 'create-index';

    private ArgvManager $argvManager;

    public function __construct(ArgvManager $argvManager)
    {
        $this->argvManager = $argvManager;
    }

    public function get(): RunCommandInterface
    {
        $command = $this->argvManager->getByPosition(1);

        switch ($command) {
            case self::BULK_COMMAND:
                return new BulkInitializationCommand();
            case self::SEARCH_COMMAND:
                return new SearchCommand($this->argvManager);
            case self::DELETE_INDEX_COMMAND:
                return new DeleteIndexCommand();
            case self::CREATE_INDEX_COMMAND:
                return new CreateIndexCommand();
            default:
                return new HelpCommand();
        }
    }
}
