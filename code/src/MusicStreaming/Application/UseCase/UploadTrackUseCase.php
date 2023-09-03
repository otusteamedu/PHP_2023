<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Application\UseCase;

use VKorabelnikov\Hw16\MusicStreaming\Domain\Model\Genre;
use VKorabelnikov\Hw16\MusicStreaming\Domain\Model\Track;
use VKorabelnikov\Hw16\MusicStreaming\Application\Exceptions\TableRowNotFoundException;
use VKorabelnikov\Hw16\MusicStreaming\Application\AudioProcessing\AudioFileProcessor;
use VKorabelnikov\Hw16\MusicStreaming\Application\Storage\DataMapper\GenreMapperInterface;
use VKorabelnikov\Hw16\MusicStreaming\Application\Storage\DataMapper\UserMapperInterface;
use VKorabelnikov\Hw16\MusicStreaming\Application\Storage\DataMapper\TrackMapperInterface;

use function \VKorabelnikov\Hw16\MusicStreaming\Domain\Model\Functions\convertFromIntToString;

class UploadTrackUseCase
{
    const APP_ROOT_DIRECTORY = "/data/mysite.local";
    const AUDIO_FILE_PROCESSOR_NAMESPACE =  'VKorabelnikov\\Hw16\\MusicStreaming\\Infrastructure\\AudioProcessing';


    protected GenreMapperInterface $genreMapper;
    protected UserMapperInterface $userMapper;
    protected TrackMapperInterface $trackMapper;

    public function __construct(
        GenreMapperInterface $genreMapper,
        UserMapperInterface $userMapper,
        TrackMapperInterface $trackMapper
    )
    {
        $this->genreMapper = $genreMapper;
        $this->userMapper = $userMapper;
        $this->trackMapper = $trackMapper;
    }

    public function upload(array $requestParams): void
    {
        $savedFileName = $this->decodeFileFromBase64(
            $requestParams["file_contents"],
            $requestParams["file_name"]
        );

        

        $this->saveToDatabase(
            [
                "name" => $requestParams["name"],
                "author" => $requestParams["author"],
                "genre" => $requestParams["genre"],
                "description" => $requestParams["description"],
                "file_link" => $savedFileName,
                "user" => $_SESSION["userLogin"]
            ]
        );
    }

    public function saveToDatabase(array $track): int
    {
        $obAudioFileProcessor = $this->getAudioProcessor($track["file_link"]);

        $trackEntity = $this->createTrackObject($track, $obAudioFileProcessor);

        $this->trackMapper->insert($trackEntity);

        return (int) $trackEntity->getId();
    }

    protected function createTrackObject(array $trackProps, AudioFileProcessor $obAudioFileProcessor): Track
    {
        $genre = null;
        try {
            $genre = $this->genreMapper->findByName($trackProps['genre']);
        } catch (TableRowNotFoundException $e) {
            $genre = new Genre(
                Genre::FAKE_ID,
                $trackProps['genre']
            );
            $this->genreMapper->insert($genre);
        }

        $user = null;
        $user = $this->userMapper->findByLogin($trackProps['user']);


        return new Track(
            Track::FAKE_ID,
            $trackProps['name'],
            $trackProps["author"],
            $genre,
            convertFromIntToString(
                $obAudioFileProcessor->getTrackDuration()
            ),
            $trackProps["description"],
            $trackProps["file_link"],
            $user
        );
    }

    protected function getAudioProcessor(string $fileName): AudioFileProcessor
    {
        $classNamePrefix = ucfirst(
            pathinfo($fileName)["extension"]
        );
        $classname = self::AUDIO_FILE_PROCESSOR_NAMESPACE . "\\" . $classNamePrefix . "FileProcessor";
        $obAudioFileProcessor = new $classname($fileName);
        return $obAudioFileProcessor;
    }

    

    protected function decodeFileFromBase64(string $base64FileContents, string $fileName): string
    {
        $data = base64_decode($base64FileContents);
        $filePath = self::APP_ROOT_DIRECTORY . "/public/upload/" . $fileName;
        file_put_contents($filePath, $data);
        return $filePath;
    }
}
