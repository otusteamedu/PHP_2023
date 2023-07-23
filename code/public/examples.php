<?php

declare(strict_types=1);

require __DIR__ . "/../vendor/autoload.php";

use VKorabelnikov\Hw11\YoutubeChannelAnalyzer\ChannelStatistics;


// Считаем статистику по каналам youtube
$ob = new ChannelStatistics();
var_dump($ob->getBestChannelsList(2));
var_dump($ob->getChannelLikesAndDislikeCount("channel2"));
