<?php

namespace Shabanov\Otusphp\Redis;

class RedisDataManager
{
    private \Redis $rClient;
    public function __construct(RedisClient $rClient)
    {
        $this->rClient = $rClient->getClient();
    }

    /**
     * @throws \RedisException
     */
    public function setZ(string $hash, int $score, ...$values): void
    {
        $this->rClient->zAdd($hash, $score, ...$values);
    }

    /**
     * @throws \RedisException
     */
    public function clear(string $pattern): void
    {
        $arKeys = $this->rClient->keys($pattern);
        if (!empty($arKeys)) {
            foreach($arKeys as $key) {
                $this->rClient->del($key);
            }
        }
    }

    /**
     * @throws \RedisException
     */
    public function checkUserParams(array $arUserParams, string $pattern): array
    {
        $arKeys = $this->rClient->keys($pattern);
        $arResponses = $arResult = [];
        if (!empty($arKeys)) {
            foreach ($arKeys as $key) {
                $arResponses[$key] = $this->rClient->zrange($key, 0, -1, ['WITHSCORES' => true]);
            }
            if (!empty($arResponses)) {
                foreach($arResponses as $event=>$arVal) {
                    $arEventParams = json_decode(key($arVal), true);
                    $arInter = array_intersect_assoc($arUserParams, $arEventParams);
                    if (count($arInter) == count($arUserParams)) {
                        $arResult[$event] = current($arVal);
                    }
                }
                arsort($arResult);
            }
        }
        return $arResult;
    }
}
