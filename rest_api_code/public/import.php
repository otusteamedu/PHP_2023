<?php

require __DIR__ . "/../vendor/autoload.php";

use VKorabelnikov\Hw16\MusicStreaming\Domain\Model\Genre;
use VKorabelnikov\Hw16\MusicStreaming\Domain\Model\Track;
use VKorabelnikov\Hw16\MusicStreaming\Domain\Model\User;
use VKorabelnikov\Hw16\MusicStreaming\Domain\Model\Playlist;
use VKorabelnikov\Hw16\MusicStreaming\Infrastructure\Storage\DataMapper\UserMapper;
use VKorabelnikov\Hw16\MusicStreaming\Infrastructure\Storage\DataMapper\GenreMapper;
use VKorabelnikov\Hw16\MusicStreaming\Infrastructure\Storage\DataMapper\TrackMapper;
use VKorabelnikov\Hw16\MusicStreaming\Infrastructure\Storage\DataMapper\PlaylistMapper;
use VKorabelnikov\Hw16\MusicStreaming\Infrastructure\Config\IniConfig;
use VKorabelnikov\Hw16\MusicStreaming\Infrastructure\Storage\ConnectionManager;
use VKorabelnikov\Hw16\MusicStreaming\Infrastructure\HttpApiController\PlaylistController;
use VKorabelnikov\Hw16\MusicStreaming\Infrastructure\HttpApiController\UserController;
use VKorabelnikov\Hw16\MusicStreaming\Infrastructure\HttpApiController\TrackController;

$config = new IniConfig();
$connection = new ConnectionManager($config->getAllSettings());
$pdo = $connection->getPdo();


$pdo->query(
    "CREATE TABLE track (
        id INT GENERATED ALWAYS AS IDENTITY,
        name varchar(255),
        author varchar(255),
        genre_id INTEGER,
        duration varchar(255),
        description text,
        file_link varchar(255),
        user_id INTEGER,
        PRIMARY KEY(id)
    );"
);


$pdo->query(
    "CREATE TABLE genre (
        id INT GENERATED ALWAYS AS IDENTITY,
        name varchar(255),
        PRIMARY KEY(id)
    );"
);

$pdo->query(
    "CREATE TABLE playlist (
        id INT GENERATED ALWAYS AS IDENTITY,
        name varchar(255),
        user_id INTEGER,
        PRIMARY KEY(id)
    );"
);

$pdo->query(
    "CREATE TABLE straming_service_users (
        id INT GENERATED ALWAYS AS IDENTITY,
        login varchar(255),
        sha1_password varchar(40),
        PRIMARY KEY(id)
    );"
);


$pdo->query(
    "CREATE TABLE playlists_tracks (
        id INT GENERATED ALWAYS AS IDENTITY,
        playlist_id INTEGER,
        track_id INTEGER,
        PRIMARY KEY(id)
    );"
);






$user1Login = "user_1";
$user1Password = "123";
$user2Login = "user_2";
$user2Password = "321";

$userController = new UserController($pdo);
$userController->register(
    [
        "login" => $user1Login,
        "password" => $user1Password
    ]
);

$userController->register(
    [
        "login" => $user2Login,
        "password" => $user2Password
    ]
);



$userController->auth(
    [
        "login" => $user1Login,
        "password" => $user1Password
    ]
);




$genre1Name = "genre #1";
$genre2Name = "genre #2";
$b64TrackContents = file_get_contents("b64mp3track");
$trackController = new TrackController($pdo);
$trackController->upload(
    [
        "file_contents" => $b64TrackContents,
        "file_name" => "test.mp3",
        "name" => "test mp3 track",
        "author" => "author of test mp3 track",
        "genre" => $genre1Name,
        "description" => "description of test mp3 track",
        "user" => $user1Login
    ]
);



$b64TrackContents = file_get_contents("b64wavtrack");
$trackController = new TrackController($pdo);
$trackController->upload(
    [
        "file_contents" => $b64TrackContents,
        "file_name" => "test.wav",
        "name" => "test wav track",
        "author" => "author of test wav track",
        "genre" => $genre1Name,
        "description" => "description of test wav track",
        "user" => $user2Login
    ]
);

$trackController->upload(
    [
        "file_contents" => $b64TrackContents,
        "file_name" => "test2.wav",
        "name" => "test2 wav track",
        "author" => "author of test2 wav track",
        "genre" => $genre2Name,
        "description" => "description of test2 wav track",
        "user" => $user1Login
    ]
);


$trackMapper = new GenreMapper($pdo);
$genre1 = $trackMapper->findByName($genre1Name);
$genre2 = $trackMapper->findByName($genre2Name);

$trackMapper = new TrackMapper($pdo);
$genre1TracksList = $trackMapper->findByGenre($genre1, 100, 0);
$genre2TracksList = $trackMapper->findByGenre($genre2, 100, 0);

$totalTracksList = array_merge($genre1TracksList, $genre2TracksList);


$tracksForPlaylist1 = [];
$trackaForPlaylist2 = [];
foreach ($totalTracksList as $trackIndex => $track) {
    if (($trackIndex % 2) == 0) {
        $tracksForPlaylist1[] = $track->getId();
    } else {
        $tracksForPlaylist2[] = $track->getId();
    }
}

// var_dump($genre1, $genre2, $genre1TracksList, $genre2TracksList, $totalTracksList, $tracksForPlaylist1, $tracksForPlaylist2);
// die("3333333");

$playlistController = new PlaylistController($pdo);
$playlistController->create(
    [
        "name" => "playlist #1",
        "tracksList" => $tracksForPlaylist1,
        "userLogin" => $user1Login
    ]
);

$playlistController->create(
    [
        "name" => "playlist #2",
        "tracksList" => $tracksForPlaylist2,
        "userLogin" => $user2Login
    ]
);
