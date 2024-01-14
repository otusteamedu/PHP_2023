<?php

namespace Shabanov\Otusphp\Redis;

use Exception;
use Shabanov\Otusphp\Redis\RedisClient;
use Shabanov\Otusphp\Redis\RedisDataManager;

class RedisImporter
{
    private RedisDataManager $rDm;
    private string $file;
    public function __construct(RedisDataManager $rDm, string $file)
    {
        $this->rDm = $rDm;
        $this->file = $file;
    }

    public function run()
    {
        $arFileData = $this->getDataFromFile();
        if (!empty($arFileData)) {
            $this->setDataToRedis($arFileData);
        }
    }

    /**
     * @throws Exception
     */
    private function getDataFromFile(): ?array
    {
        $fileContent = file_get_contents($this->file);
        if (!empty($fileContent)) {
            return json_decode($fileContent, true);
        } else {
            throw new \Exception('Failed to read file');
        }
    }

    private function setDataToRedis(array $arFileData): void
    {
        if (!empty($arFileData)) {
            foreach($arFileData as $arItem) {
                $this->rDm->setZ(
                    $arItem['event'],
                    $arItem['priority'],
                    json_encode($arItem['conditions'])
                );
            }
        }
    }
}
