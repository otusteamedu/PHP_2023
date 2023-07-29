<?php

namespace IilyukDmitryi\App\Controller;

use Exception;
use IilyukDmitryi\App\Model\ChannelModel;
use Throwable;

class ChannelController
{
    public function deleteAction()
    {
        try {
            $channelId = static::getChannelIdFromUrl();
            if (!$channelId) {
                throw new Exception('Пустой ID');
            }
            $channelModel = new ChannelModel();
            $res = $channelModel->findById($channelId);
            if (!$res) {
                throw new Exception('Не найден канал с таким  ID');
            }
            $res = $channelModel->delete($channelId);
        } catch (Throwable $th) {
            $resultHtml = 'Данные не установлены. Ошибка ' . $th->getMessage();
        }

        $viewPath = $_SERVER['DOCUMENT_ROOT'] . '/src/View/App/index.php';
        include $viewPath;
    }

    public static function getChannelIdFromUrl(): string
    {
        $segments = explode('/', $_SERVER['REQUEST_URI']);
        $channelId = $segments[count($segments) - 2] ?? '';
        return $channelId;
    }

    public function listAction()
    {
        try {
            $currCnt = $_GET['items_per_page'] ?? 100;
            $arrData = (new ChannelModel())->getAll($currCnt);
            $viewPath = $_SERVER['DOCUMENT_ROOT'] . '/src/View/Channel/list.php';
            include $viewPath;
        } catch (Throwable $th) {
            $resultHtml = 'Данные не установлены. Ошибка ' . $th->getMessage();
        }
    }

    public function updateAction()
    {
        try {
            $channelId = static::getChannelIdFromUrl();
            if (!$channelId) {
                throw new Exception('Пустой ID');
            }
            $channelModel = new ChannelModel();
            $channel = $channelModel->findById($channelId);
            if (!$channel) {
                throw new Exception('Не найден канал с таким  ID');
            }
            if ($_POST) {
                $channelPost = [
                    //'channel_id' => static::sanitize($_POST["channel_id"]),
                    'channel_name' => static::sanitize($_POST["channel_name"]),
                    'subscriber_count' => (int)static::sanitize($_POST["subscriber_count"])
                ];
                if (!$channelModel->update($channelId, $channelPost)) {
                    $arrResult['error'] = 'Ошибка обновления';
                } else {
                    $arrResult['message'] = 'Успешное обновление';
                    $channel['channel_name'] = $channelPost['channel_name'];
                    $channel['subscriber_count'] = $channelPost['subscriber_count'];
                }
            }
            $channel['id'] = $channelId;
            $arrResult['formData'] = $channel;
            $arrResult['formType'] = 'update';
            $viewPath = $_SERVER['DOCUMENT_ROOT'] . '/src/View/Channel/form.php';
            include $viewPath;
        } catch (Throwable $th) {
            $resultHtml = 'Данные не установлены. Ошибка ' . $th->getMessage();
        }
    }

    public static function sanitize($data)
    {
        return htmlspecialchars(trim($data));
    }

    public function addAction()
    {
        try {
            $arrResult['formData'] = [
                'channel_id' => '',
                'channel_name' => '',
                'subscriber_count' => ''
            ];
            if ($_POST) {
                $channelPost = [
                    'channel_id' => static::sanitize($_POST["channel_id"]),
                    'channel_name' => static::sanitize($_POST["channel_name"]),
                    'subscriber_count' => (int)static::sanitize($_POST["subscriber_count"])
                ];
                $channelId = $channelPost['channel_id'];
                $channelPost['id'] = $channelId;
                if (!$channelId) {
                    throw new Exception('Пустой ID');
                }
                $channelModel = new ChannelModel();
                $channel = $channelModel->findById($channelId);
                if ($channel) {
                    $arrResult['error'] = 'Найден канал с таким  ID';
                } elseif (!$channelModel->add($channelPost)) {
                    $arrResult['error'] = 'Ошибка добавления канала';
                } else {
                    $arrResult['message'] = 'Успешное добавление';
                }
                $arrResult['formData'] = $channelPost;
                $arrResult['formType'] = 'add';
            }
        } catch (Throwable $th) {
            $arrResult['error'] = 'Данные не установлены. Ошибка ' . $th->getMessage();
        }

        $viewPath = $_SERVER['DOCUMENT_ROOT'] . '/src/View/Channel/form.php';
        include $viewPath;
    }
}
