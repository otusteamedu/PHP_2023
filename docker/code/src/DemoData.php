<?php

namespace IilyukDmitryi\App;

use Faker\Factory;
use IilyukDmitryi\App\Storage\StorageApp;

class DemoData
{
    public static function isInstalledDemoData(): bool
    {
        $storageApp = StorageApp::get();
        $storageChannel = $storageApp->getChannelStorage();
        $res = $storageChannel->find([], 1);
        if (!$res['hits']['total']['value']) {
            return false;
        }
        $storageMovie = $storageApp->getMovieStorage();
        $res = $storageMovie->find([], 1);
        if (!$res['hits']['total']['value']) {
            return false;
        }
        return true;
    }

    public static function install()
    {
        $storageApp = StorageApp::get();
        $storageChannel = $storageApp->getChannelStorage();
        $storageMovie = $storageApp->getMovieStorage();
        $channelList = [];
        $movieList = [];
        $faker = Factory::create();
        $chanalsGen = function () use ($faker) {
            static $chanalsIds;
            do {
                $ids = implode("_", $faker->words(3));
            } while (isset($chanalsIds[$ids]));
            $chanalsIds[$ids] = 1;
            return $ids;
        };
        $movieGen = function () use ($faker) {
            static $chanalsIds;
            do {
                $ids = implode("_", $faker->words(3));
            } while (isset($chanalsIds[$ids]));
            $chanalsIds[$ids] = 1;
            return $ids;
        };

        $arrDataBulk = [];
        for ($i = 0; $i < 100; $i++) {
            $idChannel = $chanalsGen();
            $chanal =
                [
                    "id" => $idChannel,
                    "channel_id" => $idChannel,
                    'channel_name' => implode(" ", $faker->words(6)),
                    'subscriber_count' => $faker->numberBetween(100, 1000),
                ];
            $channelList[] = $chanal;

            for ($v = 0; $v < $faker->numberBetween(10, 100); $v++) {
                $idMovie = $movieGen();
                $movie =
                    [
                        "id" => $idMovie,
                        "movie_id" => $idMovie,
                        "channel_id" => $chanal['channel_id'],
                        'movie_name' => implode(" ", $faker->words(6)),
                        'movie_description' => $faker->text(500),
                        'like' => $faker->numberBetween(1, 1000),
                        'dislike' => $faker->numberBetween(1, 1000),
                        'duration' => $faker->numberBetween(10, 60),
                    ];
                $movieList[] = $movie;
            }
        }

        if ($storageChannel->import($channelList, true)) {
            return $storageMovie->import($movieList, true);
        }
        return false;
    }
}
