INSERT INTO halls (name) VALUES ('Малый зал');
INSERT INTO halls (name) VALUES ('Средний зал');
INSERT INTO halls (name) VALUES ('Больший зал');

INSERT INTO movies (name, description, rate, duration, price)
VALUES (
        'Зеленая миля',
        'Описание',
        9.8,
        7257,
        2500
);

INSERT INTO movies (name, description, rate, duration, price)
VALUES (
           'Побег из Шоушенка',
           'Описание',
           9.8,
           4312,
           5800
);

INSERT INTO movies (name, description, rate, duration, price)
VALUES (
           '1+1',
           'Описание',
           9.8,
           7257,
           4300
);

INSERT INTO places (hall_id, place_id, price) VALUES (1, 1, 2000);
INSERT INTO places (hall_id, place_id, price) VALUES (1, 2, 2000);
INSERT INTO places (hall_id, place_id, price) VALUES (1, 3, 2000);
INSERT INTO places (hall_id, place_id, price) VALUES (1, 4, 1000);
INSERT INTO places (hall_id, place_id, price) VALUES (1, 5, 1000);
INSERT INTO places (hall_id, place_id, price) VALUES (1, 6, 1000);
INSERT INTO places (hall_id, place_id, price) VALUES (1, 7, 500);
INSERT INTO places (hall_id, place_id, price) VALUES (1, 8, 500);
INSERT INTO places (hall_id, place_id, price) VALUES (1, 9, 500);
INSERT INTO places (hall_id, place_id, price) VALUES (1, 10, 0);
INSERT INTO places (hall_id, place_id, price) VALUES (1, 11, 0);
INSERT INTO places (hall_id, place_id, price) VALUES (1, 12, 0);

INSERT INTO places (hall_id, place_id, price) VALUES (2, 1, 2000);
INSERT INTO places (hall_id, place_id, price) VALUES (2, 2, 2000);
INSERT INTO places (hall_id, place_id, price) VALUES (2, 3, 2000);
INSERT INTO places (hall_id, place_id, price) VALUES (2, 4, 1000);
INSERT INTO places (hall_id, place_id, price) VALUES (2, 5, 1000);
INSERT INTO places (hall_id, place_id, price) VALUES (2, 6, 1000);
INSERT INTO places (hall_id, place_id, price) VALUES (2, 7, 500);
INSERT INTO places (hall_id, place_id, price) VALUES (2, 8, 500);
INSERT INTO places (hall_id, place_id, price) VALUES (2, 9, 500);
INSERT INTO places (hall_id, place_id, price) VALUES (2, 10, 0);
INSERT INTO places (hall_id, place_id, price) VALUES (2, 11, 0);
INSERT INTO places (hall_id, place_id, price) VALUES (2, 12, 0);

INSERT INTO places (hall_id, place_id, price) VALUES (3, 1, 2000);
INSERT INTO places (hall_id, place_id, price) VALUES (3, 2, 2000);
INSERT INTO places (hall_id, place_id, price) VALUES (3, 3, 2000);
INSERT INTO places (hall_id, place_id, price) VALUES (3, 4, 1000);
INSERT INTO places (hall_id, place_id, price) VALUES (3, 5, 1000);
INSERT INTO places (hall_id, place_id, price) VALUES (3, 6, 1000);
INSERT INTO places (hall_id, place_id, price) VALUES (3, 7, 500);
INSERT INTO places (hall_id, place_id, price) VALUES (3, 8, 500);
INSERT INTO places (hall_id, place_id, price) VALUES (3, 9, 500);
INSERT INTO places (hall_id, place_id, price) VALUES (3, 10, 0);
INSERT INTO places (hall_id, place_id, price) VALUES (3, 11, 0);
INSERT INTO places (hall_id, place_id, price) VALUES (3, 12, 0);

INSERT INTO clients (name, surname, fathername) VALUES ('Никита', 'Никитов', 'Никитович');
INSERT INTO clients (name, surname, fathername) VALUES ('Влад', 'Владов', 'Владович');
INSERT INTO clients (name, surname, fathername) VALUES ('Сергей', 'Сергеев', 'Сергеевич');

INSERT INTO sessions (movie_id, date_start, date_end) VALUES (1, '2023-12-01 10:00:00', '2023-12-01 12:00:00');
INSERT INTO sessions (movie_id, date_start, date_end) VALUES (2, '2023-12-01 10:00:00', '2023-12-01 11:30:00');
INSERT INTO sessions (movie_id, date_start, date_end) VALUES (3, '2023-12-01 12:00:00', '2023-12-01 13:30:00');

INSERT INTO halls_sessions (hall_id, session_id) VALUES (1, 1);
INSERT INTO halls_sessions (hall_id, session_id) VALUES (1, 2);
INSERT INTO halls_sessions (hall_id, session_id) VALUES (1, 3);
INSERT INTO halls_sessions (hall_id, session_id) VALUES (2, 1);
INSERT INTO halls_sessions (hall_id, session_id) VALUES (2, 2);
INSERT INTO halls_sessions (hall_id, session_id) VALUES (2, 3);
INSERT INTO halls_sessions (hall_id, session_id) VALUES (3, 1);
INSERT INTO halls_sessions (hall_id, session_id) VALUES (3, 2);
INSERT INTO halls_sessions (hall_id, session_id) VALUES (3, 3);

INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 1, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 2, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 3, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 4, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 5, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 6, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 7, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 8, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 9, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 10, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 11, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 12, 1);

INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 1, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 2, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 3, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 4, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 5, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 6, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 7, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 8, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 9, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 10, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 11, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 12, 2);

INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 1, 3);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 2, 3);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 3, 3);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 4, 3);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 5, 3);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 6, 3);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 7, 3);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 8, 3);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 9, 3);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 10, 3);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 11, 3);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (1, 12, 3);

INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 1, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 2, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 3, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 4, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 5, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 6, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 7, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 8, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 9, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 10, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 11, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 12, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 1, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 2, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 3, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 4, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 5, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 6, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 7, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 8, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 9, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 10, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 11, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 12, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 1, 3);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 2, 3);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 3, 3);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 4, 3);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 5, 3);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 6, 3);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 7, 3);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 8, 3);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 9, 3);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 10, 3);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 11, 3);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (2, 12, 3);

INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 1, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 2, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 3, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 4, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 5, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 6, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 7, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 8, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 9, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 10, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 11, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 12, 1);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 1, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 2, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 3, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 4, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 5, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 6, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 7, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 8, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 9, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 10, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 11, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 12, 2);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 1, 3);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 2, 3);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 3, 3);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 4, 3);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 5, 3);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 6, 3);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 7, 3);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 8, 3);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 9, 3);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 10, 3);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 11, 3);
INSERT INTO tickets (hall_id, place_id, session_id) VALUES (3, 12, 3);

INSERT INTO clients_tickets (client_id, ticket_id) VALUES (1, 1);
INSERT INTO clients_tickets (client_id, ticket_id) VALUES (1, 2);
INSERT INTO clients_tickets (client_id, ticket_id) VALUES (1, 3);
INSERT INTO clients_tickets (client_id, ticket_id) VALUES (1, 4);
INSERT INTO clients_tickets (client_id, ticket_id) VALUES (1, 5);

INSERT INTO clients_tickets (client_id, ticket_id) VALUES (2, 6);
INSERT INTO clients_tickets (client_id, ticket_id) VALUES (2, 7);
INSERT INTO clients_tickets (client_id, ticket_id) VALUES (2, 8);
INSERT INTO clients_tickets (client_id, ticket_id) VALUES (2, 9);
INSERT INTO clients_tickets (client_id, ticket_id) VALUES (2, 10);

INSERT INTO clients_tickets (client_id, ticket_id) VALUES (3, 11);
INSERT INTO clients_tickets (client_id, ticket_id) VALUES (2, 12);
INSERT INTO clients_tickets (client_id, ticket_id) VALUES (2, 13);
INSERT INTO clients_tickets (client_id, ticket_id) VALUES (2, 14);
INSERT INTO clients_tickets (client_id, ticket_id) VALUES (2, 15);