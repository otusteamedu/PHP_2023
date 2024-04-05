INSERT INTO halls (name, description)
SELECT 'Зал ' || seq.num,
       'Описание зала ' || seq.num
FROM generate_series(1, 10000000) AS seq(num);

INSERT INTO movies (title, genre, duration)
SELECT 'Фильм ' || seq.num,
       'Жанр ' || seq.num % 5,
       seq.num % 200
FROM generate_series(1, 10000000) AS seq(num);

INSERT INTO sessions (hall_id, movie_id, start_time)
SELECT seq.num % 10000000 + 1,
       seq.num % 10000000 + 1,
       CURRENT_DATE + (seq.num % 30) * INTERVAL '1 day'
FROM generate_series(1, 10000000) AS seq(num);

INSERT INTO seats_types (title)
VALUES ('Обычное'),
       ('Комфортное');

INSERT INTO seats (halls_id, seats_types_id, row, place)
SELECT seq.num % 10000000 + 1,
       seq.num % 2 + 1,
       seq.num % 20 + 1,
       seq.num % 20 + 1
FROM generate_series(1, 10000000) AS seq(num);

INSERT INTO prices (sessions_id, seats_types_id, price)
SELECT seq.num % 10000000 + 1,
       seq.num % 2 + 1,
       (seq.num % 10 + 1) * 50
FROM generate_series(1, 10000000) AS seq(num);

INSERT INTO users (phone, name, surname)
SELECT '+7' || lpad((seq.num % 9999999 + 1)::text, 7, '0'),
       'Имя ' || seq.num,
       'Фамилия ' || seq.num
FROM generate_series(1, 10000000) AS seq(num);

INSERT INTO tickets (seats_id, sessions_id, prices_id, price, users_id, created_at)
SELECT seq.num % 10000000 + 1,
       seq.num % 10000000 + 1,
       seq.num % 10000000 + 1,
       (seq.num % 10 + 1) * 50,
       seq.num % 10000000 + 1,
       generate_random_date('2024-01-01', CURRENT_DATE)
FROM generate_series(1, 10000000) AS seq(num);

INSERT INTO attributes_types (name)
VALUES ('Рецензии'),
       ('Премия'),
       ('Важные даты'),
       ('Служебные даты');

INSERT INTO attributes_names (name, attributes_types_id)
VALUES ('Рецензии критиков', 1),
       ('Отзыв кинолюбителя', 1),
       ('Оскар', 2),
       ('BAFTA', 2),
       ('Мировая премьера', 3),
       ('Премьера в РФ', 3),
       ('Дата начала продажи билетов', 4),
       ('Дата запуска рекламы на ТВ', 4);

INSERT INTO attributes_values (movies_id, attributes_names_id, value_text)
VALUES (1, 1,
        'Довольно рискованное решение продюсеров снимать все три фильма серии ' ||
        '«Властелин колец» один за другим обернулось большим кассовым успехом. ' ||
        'Первые две части собрали в прокате огромную сумму, которая в несколько раз превысила затраты на всю трилогию, и третья часть только закрепила успех, ' ||
        'который вылился в грандиозное эпическое полотно, которое даже сейчас, спустя 20 лет после премьеры, ' ||
        'смотрится просто великолепно и завораживает дух.'),
       (1, 2,
        'Фильм поражает своей масштабностью, красотой и глубиной образов и самого мира — до сих пор удивляюсь, как мог один человек создать целый мир, целую эпоху со своими мифами, героями, географией, летоисчеслением, прошлым, настояшим и будующим!'),
       (2, 2,
        'Эта часть хороша, прежде всего, почти полным отсутствием сюжетных дыр и нелогичных моментов, которые в той или иной степени присутствуют во всех других эпизодах. Также, это самый серьезный и тяжелый (в хорошем смысле) по ощущениям от просмотра эпизод в трилогии.'),
       (3, 1,
        '«Дюна» – монументальная экранизация одноимённого научно-фантастического романа Фрэнка Герберта от Дени Вильнёва, которой режиссёр окончательно и бесповоротно вписывает своё имя в историю мирового кинематографа. Складывается такое ощущение, будто бы Вильнёв вовсе не человек, а волшебник, способный справиться с любым материалом, каким бы сложным он не был.'),
       (3, 2,
        'Каждый кадр – эстетическое наслаждение для глаз. Отличный дизайн вселенной, слегка вычурный временами, но прекрасно иллюстрирующий мир будущего без его классических атрибутов – роботов и небоскребов. Напротив, здесь творения.');

INSERT INTO attributes_values (movies_id, attributes_names_id, value_int)
VALUES (1, 3, 11),
       (2, 3, 2),
       (3, 3, 6),
       (1, 4, 5),
       (2, 4, 1),
       (3, 4, 5);

INSERT INTO attributes_values (movies_id, attributes_names_id, value_date)
VALUES (1, 5, '2023-11-01'),
       (2, 5, '1980-05-17'),
       (3, 5, '2021-09-03'),
       (1, 8, CURRENT_DATE),
       (2, 8, CURRENT_DATE),
       (3, 8, CURRENT_DATE),
       (1, 7, CURRENT_DATE + '20 days'::interval),
       (2, 7, CURRENT_DATE + '20 days'::interval),
       (3, 7, CURRENT_DATE + '20 days'::interval);