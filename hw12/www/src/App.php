<?php
declare(strict_types=1);

namespace Shabanov\Otusphp;

use Shabanov\Otusphp\Redis\RedisClient;
use Shabanov\Otusphp\Redis\RedisDataManager;
use Shabanov\Otusphp\Redis\RedisDataRender;
use Shabanov\Otusphp\Redis\RedisImporter;

class App
{
    private ?RedisClient $rClient = null;
    private RedisDataManager $rDm;
    const FILE_NAME = 'upload/data.json';
    const PATTERN_EVENTS = 'event:*';
    const USER_PARAMS = ['param1' => 1, 'param2' => 2];
    public function __construct()
    {
        $this->rClient = RedisClient::getInstance();
        $this->rDm = new RedisDataManager($this->rClient);
    }

    /**
     * @throws \RedisException
     */
    public function run(): void
    {
        (new RedisImporter($this->rDm, self::FILE_NAME))->run();
        echo (new RedisDataRender(
            $this->rDm->checkUserParams(
                self::USER_PARAMS,
                self::PATTERN_EVENTS
            )
        ))->show();
    }
}
