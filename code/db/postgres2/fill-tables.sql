#наполнение таблиц данными
INSERT INTO theater (name) VALUES ('Парк кино Химки');

INSERT INTO halls (theater_id) VALUES (1);

#наполнение сеансов за неделю
INSERT INTO sessions (date, hall_id, movie_id) VALUES
(now() - interval '7 days', 1, floor(random()* (5-2 + 1) + 2));
INSERT INTO sessions (id, date, hall_id, movie_id) VALUES
(generate_series(3, 5), now() - interval '7 days', 1, floor(random()* (5-2 + 1) + 2));
INSERT INTO sessions (id, date, hall_id, movie_id) VALUES
(generate_series(6, 11), now() - interval '5 days', 1, floor(random()* (5-2 + 1) + 2));
INSERT INTO sessions (id, date, hall_id, movie_id) VALUES
(generate_series(12, 18), now() - interval '2 days', 1, floor(random()* (5-2 + 1) + 2));

select* from sessions;
#id |             date              | hall_id | movie_id
#----+-------------------------------+---------+----------
#  1 | 2023-09-20 19:36:40.354723+00 |       1 |        2
#  2 | 2023-09-13 19:59:02.615688+00 |       1 |        5
#  3 | 2023-09-13 20:03:50.575902+00 |       1 |        4
#  4 | 2023-09-13 20:03:50.575902+00 |       1 |        5
#...

#формирование таблички с местами
INSERT INTO seats (id, seat_number, hall_id) VALUES
(generate_series(1, 225), generate_series(1, 225), 1);

#проданные билеты
INSERT INTO tickets (id, movie_session_id, seat_id, price, sold) VALUES
(generate_series(1, 225), 1, generate_series(1, 225), floor(random()* (90-57 + 1) + 57), random() > 0.5);

INSERT INTO tickets (id, movie_session_id, seat_id, price, sold) VALUES
(generate_series(226, 450), 2, generate_series(1, 225), floor(random()* (90-57 + 1) + 57), random() > 0.5);

INSERT INTO tickets (id, movie_session_id, seat_id, price, sold) VALUES
(generate_series(451, 675), 6, generate_series(1, 225), floor(random()* (90-57 + 1) + 57), random() > 0.5);

#id  | movie_session_id | seat_id | price
#-----+------------------+---------+-------
#   1 |                1 |       1 | 64.00
#   2 |                1 |       2 | 88.00
#   3 |                1 |       3 | 88.00
#   4 |                1 |       4 | 62.00
# ...

