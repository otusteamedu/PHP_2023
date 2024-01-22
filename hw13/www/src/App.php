<?php
declare(strict_types=1);

namespace Shabanov\Otusphp;

use Exception;
use Shabanov\Otusphp\DataMapper\ProductMapper;
use Shabanov\Otusphp\Db\PgClient;
use PDO;
use Shabanov\Otusphp\Db\RedisClient;
use Shabanov\Otusphp\IdentityMap\IdentityMapHandler;

class App
{
    private PDO $pdoClient;
    private IdentityMapHandler $unitOfWork;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->pdoClient = (PgClient::getInstance())->getClient();
        $this->unitOfWork = (new IdentityMapHandler(
            (RedisClient::getInstance())->getClient()
        ));
    }

    /**
     * @throws \RedisException
     */
    public function run(): void
    {
        $pm = (new ProductMapper($this->pdoClient, $this->unitOfWork));
        $pm->getAll();
        $product = $pm->getById(950);
        $product->setTitle('Обновленное название');
        $pm->update($product);
    }
}
