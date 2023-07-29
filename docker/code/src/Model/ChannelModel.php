<?php

namespace IilyukDmitryi\App\Model;


use IilyukDmitryi\App\Storage\Base\ChannelStorageInterface;
use IilyukDmitryi\App\Storage\StorageApp;


class ChannelModel
{
    private ?ChannelStorageInterface $storage;

    public function __construct()
    {
        $this->initStorage();
    }

    public function initStorage():void
    {
        $storageApp = StorageApp::get();
        $storage = $storageApp->getChannelStorage();
        $this->storage = $storage;
    }

    /**
     * @param array $channel
     * @return mixed
     */
    public function add(array $channel)
    {
        if(empty($channel['channel_id'])){
            throw new \InvalidArgumentException("Empty key channel_id");
        }
        return $this->storage->add($channel);
    }

    /**
     * @param int $channelId
     * @return mixed
     */
    public function delete(string $channelId)
    {
        if(empty($channelId)){
            throw new \InvalidArgumentException("Empty key channel_id");
        }
        return $this->storage->delete($channelId);
    }

    /**
     * @param int $channelId
     * @param array $channel
     * @return mixed
     */
    public function update(string $channelId, array $channel)
    {
        if(empty($channelId)){
            throw new \InvalidArgumentException("Empty key channel_id");
        }

        return $this->storage->update($channelId,$channel);
    }


    /**
     * @param int $channelId
     * @return array
     */
    public function findById(string $channelId): array
    {
        return $this->storage->findById($channelId);
    }

    /**
     * @param array $filter
     * @return array
     */
    
    public function getAll($cnt = 50): array
    {
        $res = $this->storage->find([],$cnt);
        return $res;
    }

}