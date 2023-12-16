INSERT INTO hall_scheme (name)
VALUES
    ('standard'),
    ('vip');

INSERT INTO hall (name, scheme_id)
VALUES
    ('Зал 1', (SELECT id FROM hall_scheme WHERE name = 'standard')),
    ('Зал VIP', (SELECT id FROM hall_scheme WHERE name = 'vip'));

INSERT INTO movie (name, duration)
VALUES
    ('Три мушкетера', 3600),
    ('Четыре мушкетера', 5000);

INSERT INTO time_type (start_time, description)
VALUES
    ('10:00:00', '10:00'),
    ('14:00:00', '14:00'),
    ('18:00:00', '18:00');

INSERT INTO session (hall_id, movie_id, time_type, start_date, end_date)
VALUES
    (
        (SELECT id FROM hall WHERE name = 'Зал 1'),
        (SELECT id FROM movie WHERE name = 'Три мушкетера'),
        (SELECT id FROM time_type WHERE start_time = '10:00:00'),
        '2023-12-12',
        '2023-12-20'
    ),
    (
        (SELECT id FROM hall WHERE name = 'Зал 1'),
        (SELECT id FROM movie WHERE name = 'Три мушкетера'),
        (SELECT id FROM time_type WHERE start_time = '14:00:00'),
        '2023-12-12',
        '2023-12-20'
    ),
    (
        (SELECT id FROM hall WHERE name = 'Зал 1'),
        (SELECT id FROM movie WHERE name = 'Четыре мушкетера'),
        (SELECT id FROM time_type WHERE start_time = '18:00:00'),
        '2023-12-12',
        '2023-12-20'
    ),
    (
        (SELECT id FROM hall WHERE name = 'Зал VIP'),
        (SELECT id FROM movie WHERE name = 'Три мушкетера'),
        (SELECT id FROM time_type WHERE start_time = '10:00:00'),
        '2023-12-12',
        '2023-12-20'
    ),
    (
        (SELECT id FROM hall WHERE name = 'Зал VIP'),
        (SELECT id FROM movie WHERE name = 'Четыре мушкетера'),
        (SELECT id FROM time_type WHERE start_time = '14:00:00'),
        '2023-12-12',
        '2023-12-20'
    ),
    (
        (SELECT id FROM hall WHERE name = 'Зал VIP'),
        (SELECT id FROM movie WHERE name = 'Четыре мушкетера'),
        (SELECT id FROM time_type WHERE start_time = '18:00:00'),
        '2023-12-12',
        '2023-12-20'
    );

INSERT INTO seat_type (name)
VALUES
    ('standard'),
    ('vip');

INSERT INTO seat(number, row, scheme_id, seat_type)
VALUES
    (1, 1, (SELECT id FROM hall_scheme WHERE name = 'standard'), (SELECT id FROM seat_type WHERE name = 'standard')),
    (2, 1, (SELECT id FROM hall_scheme WHERE name = 'standard'), (SELECT id FROM seat_type WHERE name = 'standard')),
    (3, 1, (SELECT id FROM hall_scheme WHERE name = 'standard'), (SELECT id FROM seat_type WHERE name = 'vip')),
    (4, 1, (SELECT id FROM hall_scheme WHERE name = 'standard'), (SELECT id FROM seat_type WHERE name = 'vip')),
    (5, 1, (SELECT id FROM hall_scheme WHERE name = 'standard'), (SELECT id FROM seat_type WHERE name = 'vip')),
    (6, 1, (SELECT id FROM hall_scheme WHERE name = 'standard'), (SELECT id FROM seat_type WHERE name = 'vip')),
    (7, 1, (SELECT id FROM hall_scheme WHERE name = 'standard'), (SELECT id FROM seat_type WHERE name = 'standard')),
    (8, 1, (SELECT id FROM hall_scheme WHERE name = 'standard'), (SELECT id FROM seat_type WHERE name = 'standard')),
    (1, 1, (SELECT id FROM hall_scheme WHERE name = 'vip'), (SELECT id FROM seat_type WHERE name = 'vip')),
    (2, 1, (SELECT id FROM hall_scheme WHERE name = 'vip'), (SELECT id FROM seat_type WHERE name = 'vip')),
    (3, 1, (SELECT id FROM hall_scheme WHERE name = 'vip'), (SELECT id FROM seat_type WHERE name = 'vip')),
    (1, 2, (SELECT id FROM hall_scheme WHERE name = 'vip'), (SELECT id FROM seat_type WHERE name = 'vip')),
    (2, 2, (SELECT id FROM hall_scheme WHERE name = 'vip'), (SELECT id FROM seat_type WHERE name = 'vip')),
    (3, 2, (SELECT id FROM hall_scheme WHERE name = 'vip'), (SELECT id FROM seat_type WHERE name = 'vip'));


INSERT INTO price(scheme_id, seat_type, time_type, price)
VALUES
    (
        (SELECT id FROM hall_scheme WHERE name = 'standard'),
        (SELECT id FROM seat_type WHERE name = 'standard'),
        (SELECT id FROM time_type WHERE start_time = '10:00:00'),
        200
    ),
    (
        (SELECT id FROM hall_scheme WHERE name = 'standard'),
        (SELECT id FROM seat_type WHERE name = 'standard'),
        (SELECT id FROM time_type WHERE start_time = '14:00:00'),
        300
    ),
    (
        (SELECT id FROM hall_scheme WHERE name = 'standard'),
        (SELECT id FROM seat_type WHERE name = 'standard'),
        (SELECT id FROM time_type WHERE start_time = '18:00:00'),
        400
    ),
    (
        (SELECT id FROM hall_scheme WHERE name = 'standard'),
        (SELECT id FROM seat_type WHERE name = 'vip'),
        (SELECT id FROM time_type WHERE start_time = '10:00:00'),
        300
    ),
    (
        (SELECT id FROM hall_scheme WHERE name = 'standard'),
        (SELECT id FROM seat_type WHERE name = 'vip'),
        (SELECT id FROM time_type WHERE start_time = '14:00:00'),
        400
    ),
    (
        (SELECT id FROM hall_scheme WHERE name = 'standard'),
        (SELECT id FROM seat_type WHERE name = 'vip'),
        (SELECT id FROM time_type WHERE start_time = '18:00:00'),
        500
    ),
    (
        (SELECT id FROM hall_scheme WHERE name = 'vip'),
        (SELECT id FROM seat_type WHERE name = 'vip'),
        (SELECT id FROM time_type WHERE start_time = '10:00:00'),
        400
    ),
    (
        (SELECT id FROM hall_scheme WHERE name = 'vip'),
        (SELECT id FROM seat_type WHERE name = 'vip'),
        (SELECT id FROM time_type WHERE start_time = '14:00:00'),
        500
    ),
    (
        (SELECT id FROM hall_scheme WHERE name = 'vip'),
        (SELECT id FROM seat_type WHERE name = 'vip'),
        (SELECT id FROM time_type WHERE start_time = '18:00:00'),
        600
    );

INSERT INTO client(phone, first_name, last_name)
VALUES
    ('79644441122', 'Вася', 'Пупкин'),
    ('71113337788', 'Гоша', 'Иванов'),
    ('79993331177', 'Маша', 'Петрорва');

INSERT INTO ticket(session_id, seat_id, client_id, date, amount)
VALUES
    (
        (SELECT id FROM session WHERE (
            hall_id = (SELECT id FROM hall WHERE name = 'Зал 1')
            AND movie_id = (SELECT id FROM movie WHERE name = 'Три мушкетера')
            AND time_type = (SELECT id FROM time_type WHERE start_time = '10:00:00')
        )),
        (SELECT id FROM seat WHERE (
            number = 1
            AND row = 1
            AND scheme_id = (SELECT id FROM hall_scheme WHERE name = 'standard')
            AND seat_type = (SELECT id FROM seat_type WHERE name = 'standard')
        )),
        (SELECT id FROM client WHERE phone = '79644441122'),
        '2023-12-12',
        200
    ),
    (
        (SELECT id FROM session WHERE (
            hall_id = (SELECT id FROM hall WHERE name = 'Зал 1')
            AND movie_id = (SELECT id FROM movie WHERE name = 'Четыре мушкетера')
            AND time_type = (SELECT id FROM time_type WHERE start_time = '18:00:00')
        )),
        (SELECT id FROM seat WHERE (
            number = 4
            AND row = 1
            AND scheme_id = (SELECT id FROM hall_scheme WHERE name = 'standard')
            AND seat_type = (SELECT id FROM seat_type WHERE name = 'vip')
        )),
        (SELECT id FROM client WHERE phone = '79993331177'),
        '2023-12-13',
        500
    ),
    (
        (SELECT id FROM session WHERE (
            hall_id = (SELECT id FROM hall WHERE name = 'Зал VIP')
            AND movie_id = (SELECT id FROM movie WHERE name = 'Три мушкетера')
            AND time_type = (SELECT id FROM time_type WHERE start_time = '10:00:00')
        )),
        (SELECT id FROM seat WHERE (
            number = 3
            AND row = 2
            AND scheme_id = (SELECT id FROM hall_scheme WHERE name = 'vip')
            AND seat_type = (SELECT id FROM seat_type WHERE name = 'vip')
        )),
        (SELECT id FROM client WHERE phone = '71113337788'),
        '2023-12-12',
        400
    ),
    (
        (SELECT id FROM session WHERE (
            hall_id = (SELECT id FROM hall WHERE name = 'Зал VIP')
            AND movie_id = (SELECT id FROM movie WHERE name = 'Четыре мушкетера')
            AND time_type = (SELECT id FROM time_type WHERE start_time = '18:00:00')
        )),
        (SELECT id FROM seat WHERE (
            number = 2
            AND row = 2
            AND scheme_id = (SELECT id FROM hall_scheme WHERE name = 'vip')
            AND seat_type = (SELECT id FROM seat_type WHERE name = 'vip')
        )),
        (SELECT id FROM client WHERE phone = '71113337788'),
        '2023-12-13',
        600
    );


