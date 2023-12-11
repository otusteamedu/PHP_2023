<?php

namespace Shabanov\Otusphp\Db;

class Postgres
{
    private \PDO $conn;
    public function __construct()
    {
        $this->conn = new \PDO('pgsql:host=' . $_ENV['POSTGRES_HOST']
            . ' dbname=' . $_ENV['POSTGRES_DB'],
            $_ENV['POSTGRES_USER'],
            $_ENV['POSTGRES_PASSWORD']);
        $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function createTables(): self
    {
        $this->conn->exec('CREATE TABLE IF NOT EXISTS halls ( 
            id SERIAL PRIMARY KEY, 
            name VARCHAR(255) NOT NULL
        )');

        $this->conn->exec('CREATE TABLE IF NOT EXISTS seats ( 
            id SERIAL PRIMARY KEY, 
            name VARCHAR(255) NOT NULL,
            hall_id INT NOT NULL,
            FOREIGN KEY (hall_id) REFERENCES halls (id)
        )');

        $this->conn->exec('CREATE TABLE IF NOT EXISTS movies (
            id SERIAL PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            duration INT NOT NULL
        )');

        $this->conn->exec('CREATE TABLE IF NOT EXISTS shedule ( 
            id SERIAL PRIMARY KEY, 
            movie_id INT NOT NULL,
            hall_id INT NOT NULL,
            seat_id INT NOT NULL,
            price DECIMAL(8,2) NOT NULL,
            start_time TIMESTAMP NOT NULL,
            FOREIGN KEY (movie_id) REFERENCES movies (id),
            FOREIGN KEY (hall_id) REFERENCES halls (id),
            FOREIGN KEY (seat_id) REFERENCES seats (id)
        )');

        $this->conn->exec('CREATE TABLE IF NOT EXISTS tickets (
            id SERIAL PRIMARY KEY,
            shedule_id INT NOT NULL,
            seat_id INT NOT NULL,
            FOREIGN KEY (shedule_id) REFERENCES shedule (id),
            FOREIGN KEY (seat_id) REFERENCES seats (id)
        )');

        return $this;
    }

    public function createData(): self
    {
        $queryHall = 'INSERT INTO halls (name) VALUES (:name)';
        $hallStatement = $this->conn->prepare($queryHall);
        foreach([['name' => 'Классика'], ['name' => 'VIP зал']] as $arHall) {
            $hallStatement->execute($arHall);
        }

        $querySeat = 'INSERT INTO seats (name, hall_id) VALUES (:name, :hall_id)';
        $movieSeat = $this->conn->prepare($querySeat);
        $arSeats = [
            ['name' => '1', 'hall_id' => 1],
            ['name' => '10', 'hall_id' => 1],
            ['name' => '50', 'hall_id' => 1],
            ['name' => '11', 'hall_id' => 2],
            ['name' => '22', 'hall_id' => 2],
            ['name' => '33', 'hall_id' => 2],
        ];
        foreach($arSeats as $arSeat) {
            $movieSeat->execute($arSeat);
        }

        $queryMovie = 'INSERT INTO movies (name, duration) VALUES (:name, :duration)';
        $movieStatement = $this->conn->prepare($queryMovie);
        $arMovies = [
            ['name' => 'По щучьему велению', 'duration' => 120],
            ['name' => 'Социальная сеть', 'duration' => 150],
            ['name' => 'Игры разума', 'duration' => 90]
        ];
        foreach($arMovies as $arMovie) {
            $movieStatement->execute($arMovie);
        }

        $querySession = 'INSERT INTO shedule (hall_id, movie_id, seat_id, price, start_time) VALUES (:hall_id, :movie_id, :seat_id, :price, :start_time)';
        $sessionStatement = $this->conn->prepare($querySession);
        $arSessions = [
            ['hall_id' => 1, 'movie_id' => 1, 'seat_id' => 1, 'price' => 10, 'start_time' => '2023-12-01 10:00:00'],
            ['hall_id' => 2, 'movie_id' => 2, 'seat_id' => 1, 'price' => 10, 'start_time' => '2023-12-01 10:00:00'],
            ['hall_id' => 1, 'movie_id' => 3, 'seat_id' => 1, 'price' => 10, 'start_time' => '2023-12-01 12:00:00'],
        ];
        foreach($arSessions as $arSession) {
            $sessionStatement->execute($arSession);
        }

        $queryTicket = 'INSERT INTO tickets (shedule_id, seat_id) VALUES (:shedule_id, :seat_id)';
        $ticketStatement = $this->conn->prepare($queryTicket);
        $arTickets = [
            ['shedule_id' => 1, 'seat_id' => 1],
            ['shedule_id' => 1, 'seat_id' => 2],
            ['shedule_id' => 1, 'seat_id' => 3],
            ['shedule_id' => 1, 'seat_id' => 4],
            ['shedule_id' => 1, 'seat_id' => 5],
            ['shedule_id' => 2, 'seat_id' => 6],
            ['shedule_id' => 2, 'seat_id' => 1],
            ['shedule_id' => 2, 'seat_id' => 2],
            ['shedule_id' => 3, 'seat_id' => 3],
        ];
        foreach($arTickets as $arTicket) {
            $ticketStatement->execute($arTicket);
        }

        return $this;
    }

    public function getProfitFilm(): string
    {
        $statement = $this->conn->query('
            SELECT M.name, SUM(S.price) as profit
            FROM movies M 
            INNER JOIN shedule S ON S.movie_id = M.id
            INNER JOIN tickets T ON T.shedule_id = S.id
            GROUP BY M.id
            ORDER BY profit DESC
            LIMIT 1
        ');
        if ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            return 'Самый прибыльный фильм "' . $row['name'] . '" с бюджетом ' . $row['profit'] . ' руб.';
        }
        return '';
    }
}
