INSERT INTO public.film (id, name, description) VALUES (1, 'Три богатыря', 'По сказкам мы знаем, что было давным-давно, но что было ещё давным-давнее? Трём богатырям предстоит узнать ответ на этот вопрос');
INSERT INTO public.film (id, name, description) VALUES (2, 'Принцесса Мононоке', 'Юный принц Аситака, убив вепря, навлёк на себя смертельное проклятие. Старая знахарка предсказала ему, что только он сам способен изменить свою судьбу. И отважный воин отправился в опасное путешествие.');

INSERT INTO public.hall (id, name, description) VALUES (1, 'Зал №1', 'малый зал');
INSERT INTO public.hall (id, name, description) VALUES (2, 'Зал №2', 'малый зал');
INSERT INTO public.hall (id, name, description) VALUES (3, 'Зал №3', 'малый зал');

INSERT INTO public.place (id, row, number, hall_id, markup) VALUES (3, 1, 3, 1, 100.00);
INSERT INTO public.place (id, row, number, hall_id, markup) VALUES (1, 1, 1, 1, 100.00);
INSERT INTO public.place (id, row, number, hall_id, markup) VALUES (2, 1, 2, 1, 100.00);
INSERT INTO public.place (id, row, number, hall_id, markup) VALUES (4, 2, 1, 1, 95.00);
INSERT INTO public.place (id, row, number, hall_id, markup) VALUES (8, 1, 1, 3, 100.00);
INSERT INTO public.place (id, row, number, hall_id, markup) VALUES (9, 2, 1, 3, 90.00);
INSERT INTO public.place (id, row, number, hall_id, markup) VALUES (10, 2, 2, 3, 90.00);
INSERT INTO public.place (id, row, number, hall_id, markup) VALUES (11, 3, 1, 3, 70.00);
INSERT INTO public.place (id, row, number, hall_id, markup) VALUES (7, 1, 3, 2, 100.00);
INSERT INTO public.place (id, row, number, hall_id, markup) VALUES (6, 1, 2, 2, 120.00);
INSERT INTO public.place (id, row, number, hall_id, markup) VALUES (5, 1, 1, 2, 100.00);

INSERT INTO public.seance (id, film_id, hall_id, date) VALUES (1, 1, 1, '2024-01-10 20:45:04.605000 +00:00');
INSERT INTO public.seance (id, film_id, hall_id, date) VALUES (2, 1, 3, '2024-01-11 20:45:21.239000 +00:00');
INSERT INTO public.seance (id, film_id, hall_id, date) VALUES (3, 1, 2, '2024-01-12 20:45:26.883000 +00:00');
INSERT INTO public.seance (id, film_id, hall_id, date) VALUES (4, 2, 2, '2024-01-13 20:45:30.868000 +00:00');
INSERT INTO public.seance (id, film_id, hall_id, date) VALUES (5, 2, 1, '2024-01-14 20:45:34.620000 +00:00');

INSERT INTO public.client (id, surname, name, patronymic, email, phone, created_at) VALUES (1, 'Петров', 'Иван', 'Иванович', 'user1@email.ru', '79237771110', '2024-01-09 20:53:35.194000 +00:00');
INSERT INTO public.client (id, surname, name, patronymic, email, phone, created_at) VALUES (2, 'Петрова', 'Оля', 'Ивановна', 'user2@email.ru', '79237771112', '2024-01-09 20:53:40.643000 +00:00');
INSERT INTO public.client (id, surname, name, patronymic, email, phone, created_at) VALUES (3, 'Иванов', 'Игорь', 'Андреевич', 'user3@email.ru', '79237771113', '2024-01-09 20:53:41.782000 +00:00');
INSERT INTO public.client (id, surname, name, patronymic, email, phone, created_at) VALUES (4, 'Иванова', 'Татьяна', 'Петровна', 'user4@email.ru', '79237771114', '2024-01-09 20:53:42.854000 +00:00');
INSERT INTO public.client (id, surname, name, patronymic, email, phone, created_at) VALUES (5, 'Сидоров', 'Андрей', 'Васильевич', 'user5@email.ru', '79237771115', '2024-01-09 20:53:43.697000 +00:00');
INSERT INTO public.client (id, surname, name, patronymic, email, phone, created_at) VALUES (6, 'Сидорова', 'Анна', 'Ивановна', 'user6@email.ru', '79237771116', '2024-01-09 20:53:44.558000 +00:00');
INSERT INTO public.client (id, surname, name, patronymic, email, phone, created_at) VALUES (7, 'Топор', 'Андрей', 'Иванович', 'user7@email.ru', '79237771117', '2024-01-09 20:53:45.511000 +00:00');
INSERT INTO public.client (id, surname, name, patronymic, email, phone, created_at) VALUES (8, 'Гусин', 'Иван', 'Андреевич', 'user8@email.ru', '79237771118', '2024-01-09 20:53:46.372000 +00:00');
INSERT INTO public.client (id, surname, name, patronymic, email, phone, created_at) VALUES (9, 'Гусина', 'Ольга', 'Васильевна', 'user9@email.ru', '79237771119', '2024-01-09 20:53:47.219000 +00:00');

INSERT INTO public.price (id, seance_id, place_id, price) VALUES (1, 1, 3, 500.00);
INSERT INTO public.price (id, seance_id, place_id, price) VALUES (2, 1, 2, 500.00);
INSERT INTO public.price (id, seance_id, place_id, price) VALUES (3, 1, 4, 500.00);
INSERT INTO public.price (id, seance_id, place_id, price) VALUES (4, 2, 9, 500.00);
INSERT INTO public.price (id, seance_id, place_id, price) VALUES (5, 2, 11, 400.00);
INSERT INTO public.price (id, seance_id, place_id, price) VALUES (6, 2, 10, 300.00);
INSERT INTO public.price (id, seance_id, place_id, price) VALUES (7, 3, 5, 250.00);
INSERT INTO public.price (id, seance_id, place_id, price) VALUES (8, 3, 7, 250.00);
INSERT INTO public.price (id, seance_id, place_id, price) VALUES (9, 3, 6, 250.00);
INSERT INTO public.price (id, seance_id, place_id, price) VALUES (10, 4, 5, 900.00);
INSERT INTO public.price (id, seance_id, place_id, price) VALUES (11, 4, 7, 900.00);
INSERT INTO public.price (id, seance_id, place_id, price) VALUES (12, 4, 6, 500.00);
INSERT INTO public.price (id, seance_id, place_id, price) VALUES (13, 5, 1, 300.00);
INSERT INTO public.price (id, seance_id, place_id, price) VALUES (14, 5, 2, 300.00);
INSERT INTO public.price (id, seance_id, place_id, price) VALUES (15, 5, 3, 250.00);
INSERT INTO public.price (id, seance_id, place_id, price) VALUES (16, 5, 4, 200.00);

INSERT INTO public.ticket (id, date, client_id, price) VALUES (1, '2024-01-09 20:58:50.740000 +00:00', 1, 16);
INSERT INTO public.ticket (id, date, client_id, price) VALUES (12, '2024-01-09 20:59:14.590000 +00:00', 3, 9);
INSERT INTO public.ticket (id, date, client_id, price) VALUES (10, '2024-01-09 20:59:09.477000 +00:00', 1, 10);
INSERT INTO public.ticket (id, date, client_id, price) VALUES (3, '2024-01-09 20:58:59.081000 +00:00', 3, 8);
INSERT INTO public.ticket (id, date, client_id, price) VALUES (8, '2024-01-09 20:59:07.470000 +00:00', 8, 11);
INSERT INTO public.ticket (id, date, client_id, price) VALUES (7, '2024-01-09 20:59:05.830000 +00:00', 7, 5);
INSERT INTO public.ticket (id, date, client_id, price) VALUES (15, '2024-01-09 20:59:19.754000 +00:00', 6, 1);
INSERT INTO public.ticket (id, date, client_id, price) VALUES (5, '2024-01-09 20:59:02.522000 +00:00', 5, 6);
INSERT INTO public.ticket (id, date, client_id, price) VALUES (2, '2024-01-09 20:58:55.241000 +00:00', 2, 2);
INSERT INTO public.ticket (id, date, client_id, price) VALUES (14, '2024-01-09 20:59:17.915000 +00:00', 5, 3);
INSERT INTO public.ticket (id, date, client_id, price) VALUES (11, '2024-01-09 20:59:12.697000 +00:00', 2, 14);
INSERT INTO public.ticket (id, date, client_id, price) VALUES (13, '2024-01-09 20:59:16.218000 +00:00', 4, 4);
INSERT INTO public.ticket (id, date, client_id, price) VALUES (9, '2024-01-09 20:59:11.078000 +00:00', 9, 15);
INSERT INTO public.ticket (id, date, client_id, price) VALUES (4, '2024-01-09 20:59:00.865000 +00:00', 4, 12);
INSERT INTO public.ticket (id, date, client_id, price) VALUES (6, '2024-01-09 20:59:04.116000 +00:00', 6, 7);
