INSERT INTO halls (name, description)
VALUES ('Зал 1', 'Премиум зал с большим экраном'),
       ('Зал 2', 'Зал со средним экраном'),
       ('Зал 3', 'Зал со маленьким экраном');

INSERT INTO movies (title, genre, duration)
VALUES ('Властелин колец: Возвращение короля', 'Фэнтези', 142),
       ('Звёздные войны: Эпизод 5 — Империя наносит ответный удар', 'Фэнтези', 124),
       ('Побег из Шоушенка', 'Драма', 142),
       ('Темный рыцарь', 'Фантастика', 152);

INSERT INTO sessions (hall_id, movie_id, start_time)
VALUES (1, 1, CURRENT_DATE),
       (2, 2, CURRENT_DATE - '2 days'::interval),
       (3, 4, CURRENT_DATE),
       (3, 3, CURRENT_DATE);

INSERT INTO seats_types (title)
VALUES ('Обычное'),
       ('Комфортное');

INSERT INTO seats (halls_id, seats_types_id, row, place)
VALUES (1, 1, 1, 1),
       (1, 1, 1, 2),
       (1, 1, 1, 3),
       (1, 1, 1, 4),
       (1, 1, 2, 1),
       (1, 1, 2, 2),
       (1, 2, 2, 3),
       (1, 2, 2, 4),
       (1, 1, 2, 5),
       (1, 1, 2, 6),
       (1, 1, 3, 1),
       (1, 1, 3, 2),
       (1, 2, 3, 3),
       (1, 2, 3, 4),
       (1, 2, 3, 5),
       (1, 2, 3, 6),
       (1, 1, 3, 7),
       (1, 1, 3, 8),
       (2, 1, 1, 1),
       (2, 1, 1, 2),
       (2, 1, 1, 3),
       (2, 1, 1, 4),
       (2, 1, 2, 1),
       (2, 1, 2, 2),
       (2, 2, 2, 3),
       (2, 2, 2, 4),
       (2, 1, 2, 5),
       (2, 1, 2, 6),
       (2, 1, 3, 1),
       (2, 1, 3, 2),
       (2, 2, 3, 3),
       (2, 2, 3, 4),
       (2, 2, 3, 5),
       (2, 2, 3, 6),
       (2, 1, 3, 7),
       (2, 1, 3, 8),
       (3, 1, 1, 1),
       (3, 1, 1, 2),
       (3, 1, 1, 3),
       (3, 1, 1, 4),
       (3, 1, 2, 1),
       (3, 1, 2, 2),
       (3, 2, 2, 3),
       (3, 2, 2, 4),
       (3, 1, 2, 5),
       (3, 1, 2, 6),
       (3, 1, 3, 1),
       (3, 1, 3, 2),
       (3, 2, 3, 3),
       (3, 2, 3, 4),
       (3, 2, 3, 5),
       (3, 2, 3, 6),
       (3, 1, 3, 7),
       (3, 1, 3, 8);

INSERT INTO prices (sessions_id, seats_types_id, price)
VALUES (1, 1, 350),
       (1, 2, 380),
       (2, 1, 330),
       (2, 2, 360),
       (3, 1, 300),
       (3, 2, 330),
       (4, 1, 250),
       (4, 2, 280);

INSERT INTO users (phone, name, surname)
VALUES ('+71234567890', 'Иван', 'Иванов'),
       ('+76541234376', 'Петр', 'Петров'),
       ('+79909999999', 'Елизавета', 'Егорова'),
       ('+79908888888', 'Алексей', 'Ковалев'),
       ('+79977777777', 'Ольга', 'Степанова'),
       ('+79333333333', 'Игорь', 'Игорев');

INSERT INTO tickets (seats_id, sessions_id, prices_id, price, users_id, created_at)
VALUES (1, 1, 1, 350.00, 1, '2024-04-05'),
       (2, 1, 1, 350.00, 1, '2024-04-05'),
       (3, 1, 1, 350.00, 2, '2024-04-05'),
       (4, 1, 1, 350.00, 2, '2024-04-05'),
       (5, 1, 1, 350.00, 2, '2024-04-05'),
       (6, 1, 1, 350.00, 1, '2024-04-05'),
       (7, 1, 2, 380.00, 1, '2024-04-05'),
       (8, 1, 2, 380.00, 1, '2024-04-05'),
       (9, 1, 1, 350.00, 1, '2024-04-05'),
       (10, 1, 1, 350.00, 1, '2024-04-05'),
       (11, 1, 1, 350.00, 1, '2024-04-05'),
       (12, 1, 1, 350.00, 1, '2024-04-05'),
       (13, 1, 2, 380.00, 3, '2024-04-05'),
       (14, 1, 2, 380.00, 3, '2024-04-05'),
       (15, 1, 2, 380.00, 3, '2024-04-05'),
       (16, 1, 2, 380.00, 3, '2024-04-05'),
       (17, 1, 1, 350.00, 3, '2024-04-05'),
       (18, 1, 1, 350.00, 3, '2024-04-05'),
       (19, 2, 1, 350.00, 3, '2024-04-05'),
       (20, 2, 1, 350.00, 3, '2024-04-05'),
       (21, 2, 1, 350.00, 3, '2024-04-05'),
       (22, 2, 1, 350.00, 3, '2024-04-05'),
       (23, 2, 1, 350.00, 3, '2024-04-05'),
       (24, 2, 1, 350.00, 3, '2024-04-05'),
       (25, 2, 2, 380.00, 3, '2024-04-05'),
       (26, 2, 2, 380.00, 3, '2024-04-05'),
       (27, 2, 1, 350.00, 3, '2024-04-05'),
       (28, 2, 1, 350.00, 3, '2024-04-05'),
       (29, 2, 1, 350.00, 3, '2024-04-05'),
       (30, 2, 1, 350.00, 1, '2024-04-05'),
       (31, 2, 2, 380.00, 6, '2024-04-05'),
       (32, 2, 2, 380.00, 6, '2024-04-05'),
       (33, 2, 2, 380.00, 6, '2024-04-05'),
       (34, 2, 2, 380.00, 6, '2024-04-05'),
       (35, 2, 1, 350.00, 4, '2024-04-05'),
       (36, 2, 1, 350.00, 4, '2024-04-05'),
       (37, 3, 1, 350.00, 4, '2024-04-05'),
       (38, 3, 1, 350.00, 4, '2024-04-05'),
       (39, 3, 1, 350.00, 4, '2024-04-05'),
       (40, 3, 1, 350.00, 4, '2024-04-05'),
       (41, 3, 1, 350.00, 4, '2024-04-05'),
       (42, 3, 1, 350.00, 4, '2024-04-05'),
       (43, 3, 2, 380.00, 4, '2024-04-05'),
       (44, 3, 2, 380.00, 4, '2024-04-05'),
       (45, 3, 1, 350.00, 4, '2024-04-05'),
       (46, 3, 1, 350.00, 4, '2024-04-05'),
       (47, 3, 1, 350.00, 4, '2024-04-05'),
       (48, 3, 1, 350.00, 1, '2024-04-05'),
       (49, 3, 2, 380.00, 1, '2024-04-05'),
       (50, 3, 2, 380.00, 5, '2024-04-05'),
       (51, 3, 2, 380.00, 5, '2024-04-05'),
       (52, 3, 2, 380.00, 5, '2024-04-05'),
       (53, 3, 1, 350.00, 5, '2024-04-05'),
       (54, 3, 1, 350.00, 1, '2024-04-05');

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