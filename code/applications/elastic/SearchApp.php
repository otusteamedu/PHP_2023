<?php

/**
 * Приложение для поиска
 * php version 8.2.8
 *
 * @category ItIsDepricated
 * @package  AmedvedevPHP2023Otus
 * @author   Alex 150Rus <alex150rus@outlook.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @Version  GIT: 1.0.0
 * @link     http://github.com/Alex150Rus My_GIT_profile
 */

declare(strict_types=1);

namespace Amedvedev\code\applications\elastic;

use Amedvedev\code\applications\elastic\services\search\SearchService;

class SearchApp
{
    private readonly array $argv;
    private readonly int $argc;
    private readonly SearchService $searchService;

    public function __construct(array $argv, int $argc, SearchService $searchService)
    {
        $this->argv = $argv;
        $this->argc = $argc;
        $this->searchService = $searchService;
    }

    /**
     * @return void
     */
    public function run(): void
    {
        $this->searchService->strategy($this->argv, $this->argc);
    }
}
