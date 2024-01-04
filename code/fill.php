<?php

try {
    $pdo = new PDO('pgsql:host=hw7_database;dbname=test', 'test', 'test');

    $halls = $pdo->query("SELECT * FROM halls")->fetchAll(PDO::FETCH_ASSOC);
    $places = $pdo->query("SELECT * FROM places")->fetchAll(PDO::FETCH_ASSOC);
    $sessions = $pdo->query("SELECT *, movies.price as price FROM sessions INNER JOIN movies ON sessions.movie_id = movies.id")->fetchAll(PDO::FETCH_ASSOC);
    $clients = $pdo->query("SELECT * FROM clients")->fetchAll(PDO::FETCH_ASSOC);

    foreach ($sessions as $session) {
        foreach ($places as $place) {
            $price = $place['price'] + $session['price'];
            $pdo->query("
INSERT INTO tickets (hall_id, place_id, session_id, price)
VALUES (".$place['hall_id'].", ".$place['place_id'].", ".$session['id'].", ".$price.");");
            $ticketId = $pdo->lastInsertId();
            $clientId = $clients[array_rand($clients)]['id'];
            $pdo->query("INSERT INTO clients_tickets (client_id, ticket_id) VALUES (".$clientId.", ".$ticketId.")");
        }
    }
} catch (Throwable $t) {
    echo $t->getMessage();
}
