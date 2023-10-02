INSERT INTO halls (id, name) VALUES 
(1, "Vip 1", 100'),
(2, "Зал 1", 500'),
(2, "Зал 2", 500'),
(3, "Зал 3", 500'),


INSERT INTO movies (id, name) VALUES
(1, "Человек муравей")
(2, "Дети шпионы")
(3, "Чупа")


INSERT INTO seances (id, hall_id, movie_id, start, end) VALUES
(1, 1, 1, '2023-09-09 13:00:00', '2023-09-09 14:30:00')
(2, 1, 2, '2023-09-09 15:00:00', '2023-09-09 16:30:00')
(3, 1, 1, '2023-09-09 17:00:00', '2023-09-09 18:30:00')

(4, 2, 3, '2023-09-09 13:00:00', '2023-09-09 14:30:00')
(5, 2, 2, '2023-09-09 15:00:00', '2023-09-09 16:30:00')
(6, 2, 1, '2023-09-09 17:00:00', '2023-09-09 18:30:00')

(7, 3, 2, '2023-09-09 13:00:00', '2023-09-09 14:30:00')
(8, 3, 1, '2023-09-09 15:00:00', '2023-09-09 16:30:00')
(9, 3, 2, '2023-09-09 17:00:00', '2023-09-09 18:30:00')


INSERT INTO places (id, name, seat_row, hall_id) VALUES
(1, 'pl', 1, 1),
(2, 'pl', 1, 1),
(3, 'pl', 1, 1),
(4, 'pl', 1, 1),
(5, 'pl', 1, 1),
(6, 'pl', 1, 1),
(7, 'pl', 1, 1),
(8, 'pl', 1, 1),
(9, 'pl', 1, 1),
(10, 'pl', 2, 1),
(11, 'pl', 2, 1),
(12, 'pl', 2, 1),
(13, 'pl', 2, 1),
(14, 'pl', 2, 1),
(15, 'pl', 2, 1),
(16, 'pl', 2, 1),
(17, 'pl', 2, 1),
(18, 'pl', 2, 1),
(19, 'pl', 2, 1),
(20, 'pl', 2, 1),

(21, 'pl', 1, 2),
(22, 'pl', 1, 2),
(23, 'pl', 1, 2),
(24, 'pl', 1, 2),
(25, 'pl', 1, 2),
(26, 'pl', 1, 2),
(27, 'pl', 1, 2),
(28, 'pl', 1, 2),
(29, 'pl', 1, 2),
(30, 'pl', 2, 2),
(31, 'pl', 2, 2),
(32, 'pl', 2, 2),
(33, 'pl', 2, 2),
(34, 'pl', 2, 2),
(35, 'pl', 2, 2),
(36, 'pl', 2, 2),
(37, 'pl', 2, 2),
(38, 'pl', 2, 2),
(39, 'pl', 2, 2),
(40, 'pl', 2, 1)

INSERT INTO tickets (id, seance_id,place_id, price) VALUES
(1, 1, 1, 1000),
(2, 1, 2, 1000),
(3, 1, 3, 1000),
(4, 1, 4, 1000),
(5, 1, 5, 1000),
(6, 1, 6, 500),
(7, 1, 7, 500),
(8, 1, 8, 500),
(9, 1, 9, 500),
(10, 1, 10, 500),
(11, 2, 11, 1000),
(12, 2, 12, 1000),
(13, 2, 13, 1000),
(14, 2, 14, 1000),
(15, 2, 15, 1000),
(16, 2, 16, 500),
(17, 2, 17, 500),
(18, 2, 18, 500),
(19, 2, 19, 500),
(20, 2, 20, 500),
(21, 2, 21, 500),
(22, 2, 22, 500),
(23, 2, 23, 500),
(24, 2, 24, 500),
(25, 2, 25, 500),
(26, 2, 26, 500),
(27, 2, 27, 500),
(28, 2, 28, 500),
(29, 2, 29, 500)



INSERT INTO users (name, email, password) VALUES
('John Doe', 'johndoe@mail.com', 'hashaepass'),
('Jonny Deap', 'jonnydeap@mail.com', 'hashaepass'),
('Emili Clark', 'emillyclarck@mail.com', 'hashaepass'),



select m.id, name, sum(total) from movies m
    join seances s on m.id = s.movie_id
    join (select seance_id, sum(price) AS total from tickets t
        left join user_ticket ut on t.id = ut.ticket_id
        where ut.ticket_id IS NOT NULL
        GROUP BY seance_id) t on s.id = t.seance_id 
    group by id



select seance_id, sum(price) AS total from tickets t
    left join user_ticket ut on t.id = ut.ticket_id
    where ut.ticket_id IS NOT NULL
    GROUP BY seance_id



INSERT INTO user_ticket VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 4),
(2, 5),
(3, 6),
(3, 7),
(3, 8),
(3, 9),
(1, 10),
(1, 11),