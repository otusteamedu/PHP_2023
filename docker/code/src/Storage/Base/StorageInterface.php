<?php

namespace IilyukDmitryi\App\Storage\Base;

interface StorageInterface
{
    public function getMovieStorage(): MovieStorageInterface;

    public function getChannelStorage(): ChannelStorageInterface;
}
