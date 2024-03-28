<?php

namespace Api\Daniel\Services;

class FileManager
{
    public function ensureDirectoryExists($directory)
    {
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
    }

    public function readJsonFile($filePath)
    {
        return file_exists($filePath) ? json_decode(file_get_contents($filePath), true) : [];
    }

    public function writeJsonFile($filePath, $data)
    {
        file_put_contents($filePath, json_encode($data));
    }
}