<?php

namespace IilyukDmitryi\App\Model;

use Exception;
use IilyukDmitryi\App\Storage\Base\ChannelStorageInterface;
use IilyukDmitryi\App\Storage\StorageApp;
use IilyukDmitryi\App\Utils\Helper;
use InvalidArgumentException;
use Throwable;

class ChannelModel
{
    private ?ChannelStorageInterface $storage;

    public function __construct()
    {
        $this->initStorage();
    }

    protected function initStorage(): void
    {
        $storageApp = StorageApp::get();
        $storage = $storageApp->getChannelStorage();
        $this->storage = $storage;
    }

    public function addChannel(array $arrData): array
    {
        $templateData['formData'] = [
            'channel_id' => '',
            'channel_name' => '',
            'subscriber_count' => ''
        ];
        try {
            if ($arrData) {
                $channelPost = [
                    'channel_id' => Helper::sanitize($arrData["channel_id"]),
                    'channel_name' => Helper::sanitize($arrData["channel_name"]),
                    'subscriber_count' => (int)Helper::sanitize($arrData["subscriber_count"])
                ];
                $channelId = $channelPost['channel_id'];
                $channelPost['id'] = $channelId;
                if (!$channelId) {
                    throw new Exception('Пустой ID');
                }
                $channel = $this->findById($channelId);
                if ($channel) {
                    $templateData['error'] = 'Найден канал с таким  ID';
                } elseif (!$this->add($channelPost)) {
                    $templateData['error'] = 'Ошибка добавления канала';
                } else {
                    $templateData['message'] = 'Успешное добавление';
                }
                $templateData['formData'] = $channelPost;
                $templateData['formType'] = 'add';
            }
        } catch (Throwable $th) {
            $templateData['error'] = 'Данные не установлены. Ошибка ' . $th->getMessage();
        }
        return $templateData;
    }

    /**
     * @param string $channelId
     * @return array
     */
    public function findById(string $channelId): array
    {
        return $this->storage->findById($channelId);
    }

    /**
     * @param array $channel
     * @return bool
     */
    protected function add(array $channel): mixed
    {
        if (empty($channel['channel_id'])) {
            throw new InvalidArgumentException("Empty key channel_id");
        }
        return $this->storage->add($channel);
    }

    public function updateChannel(string $channelId, array $arrData): array
    {
        $templateData = [];
        try {
            if (!$channelId) {
                throw new Exception('Пустой ID');
            }
            $channel = $this->findById($channelId);
            if (!$channel) {
                throw new Exception('Не найден канал с таким  ID');
            }
            if ($arrData) {
                $channelPost = [
                    'channel_name' => Helper::sanitize($arrData["channel_name"]),
                    'subscriber_count' => (int)Helper::sanitize($arrData["subscriber_count"])
                ];
                if (!$this->update($channelId, $channelPost)) {
                    $templateData['error'] = 'Ошибка обновления';
                } else {
                    $templateData['message'] = 'Успешное обновление';
                    $channel['channel_name'] = $channelPost['channel_name'];
                    $channel['subscriber_count'] = $channelPost['subscriber_count'];
                }
            }
            $channel['id'] = $channelId;
            $templateData['formData'] = $channel;
            $templateData['formType'] = 'update';
        } catch (Throwable $th) {
            $templateData['error'] = 'Данные не обновлены. Ошибка ' . $th->getMessage();
        }
        return $templateData;
    }

    /**
     * @param string $channelId
     * @param array $channel
     * @return mixed
     */
    protected function update(string $channelId, array $channel): mixed
    {
        if (empty($channelId)) {
            throw new InvalidArgumentException("Empty key channel_id");
        }
        return $this->storage->update($channelId, $channel);
    }

    /**
     * @throws Exception
     */
    public function deleteChannel(string $channelId): array
    {
        $templateData = [];
        if (!$channelId) {
            throw new Exception('Пустой ID');
        }
        $res = $this->findById($channelId);
        if (!$res) {
            throw new Exception('Не найден канал с ID ' . $channelId);
        }
        $res = $this->delete($channelId);
        if ($res) {
            $templateData['message'] = 'Канал успешно удален ' . $channelId;
        } else {
            $templateData['error'] = 'Ошибка удаления канала ' . $channelId;
        }
        return $templateData;
    }

    /**
     * @param string $channelId
     * @return mixed
     */
    protected function delete(string $channelId): mixed
    {
        if (empty($channelId)) {
            throw new InvalidArgumentException("Empty key channel_id");
        }
        return $this->storage->delete($channelId);
    }

    public function getAll($cnt = 50): array
    {
        $res = $this->storage->find([], $cnt);
        return $res;
    }
}
