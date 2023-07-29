<?php

namespace IilyukDmitryi\App\Model;

class StatistikaModel
{
    public function getTopPopularChannels(int $cntTop): array
    {
        $arrResult = [];
        $movieModel = new MovieModel();
        $arrTopChhanels = $movieModel->getTopPopularChannels($cntTop);
        if ($arrTopChhanels) {
            $channelModel = new ChannelModel();
            foreach ($arrTopChhanels as $channelsRaiting) {
                $channelId = $channelsRaiting['channel_id'];
                $chanelsData = $channelModel->findById($channelId);
                if ($chanelsData) {
                    $chanelsData['raiting'] = $channelsRaiting;
                    $arrResult[] = $chanelsData;
                }
            }
        }
        return $arrResult;
    }

    public function getLikesDislikesFromChannels(int $cnt): array
    {
        $arrResult = [];
        $movieModel = new MovieModel();
        $arrsummaryChhanels = $movieModel->getLikesDislikesFromChannels($cnt);
        if ($arrsummaryChhanels) {
            $channelModel = new ChannelModel();
            foreach ($arrsummaryChhanels as $channelsRaiting) {
                $channelId = $channelsRaiting['channel_id'];
                $chanelsData = $channelModel->findById($channelId);
                if ($chanelsData) {
                    $chanelsData['summary'] = $channelsRaiting;
                    $arrResult[] = $chanelsData;
                }
            }
        }
        return $arrResult;
    }
}
