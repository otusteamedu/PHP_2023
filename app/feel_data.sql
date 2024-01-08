INSERT INTO movie (name)
VALUES
    ('Один мушкетер'),
    ('Два мушкетера'),
    ('Три мушкетера');

INSERT INTO attribute_type (name)
VALUES
    ('string'),
    ('integer'),
    ('float'),
    ('boolean'),
    ('date');

INSERT INTO attribute (name, description, attribute_type)
VALUES
    ('director', 'Режиссер', (SELECT id FROM attribute_type WHERE name = 'string')),
    ('actor', 'Актер', (SELECT id FROM attribute_type WHERE name = 'string')),
    ('year', 'Год выхода', (SELECT id FROM attribute_type WHERE name = 'integer')),
    ('duration', 'Продолжиткльность', (SELECT id FROM attribute_type WHERE name = 'integer')),
    ('genre', 'Жанр', (SELECT id FROM attribute_type WHERE name = 'string')),
    ('age_rating', 'Возрастной рейтинг', (SELECT id FROM attribute_type WHERE name = 'string')),
    ('award_oscar', 'Премия Оскар', (SELECT id FROM attribute_type WHERE name = 'boolean')),
    ('award_golden_raspberry', 'Премия Золотая Малина', (SELECT id FROM attribute_type WHERE name = 'boolean')),
    ('world_premiere_date', 'Мировая премьера', (SELECT id FROM attribute_type WHERE name = 'date')),
    ('russia_premiere_date', 'Премьера в РФ', (SELECT id FROM attribute_type WHERE name = 'date')),
    ('advertising_start_date', 'Дата начала запуска рекламы', (SELECT id FROM attribute_type WHERE name = 'date')),
    ('ticket_sale_start_date', 'Дата начала продажи билетов', (SELECT id FROM attribute_type WHERE name = 'date')),
    ('end_date', 'Дата окончания показа', (SELECT id FROM attribute_type WHERE name = 'date'));

INSERT INTO value (movie_id, attribute_id, value_text, value_boolean, value_integer, value_float, value_date)
VALUES
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'director'),
        'Василий шестеперов',
        null,
        null,
        null,
        null
    ),
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'actor'),
        'Гоша Куценко',
        null,
        null,
        null,
        null
    ),
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'actor'),
        'Бред Пит',
        null,
        null,
        null,
        null
    ),
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'actor'),
        'Кристиан Бейл',
        null,
        null,
        null,
        null
    ),
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'actor'),
        'Марго Робби',
        null,
        null,
        null,
        null
    ),
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'actor'),
        'Диана Арбенина',
        null,
        null,
        null,
        null
    ),
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'year'),
        null,
        null,
        2023,
        null,
        null
    ),
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'duration'),
        null,
        null,
        '120',
        null,
        null
    ),
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'genre'),
        'Ужасы',
        null,
        null,
        null,
        null
    ),
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'age_rating'),
        '3+',
        null,
        null,
        null,
        null
    ),
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'award_oscar'),
        null,
        true,
        null,
        null,
        null
    ),
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'award_golden_raspberry'),
        null,
        true,
        null,
        null,
        null
    ),
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'world_premiere_date'),
        null,
        null,
        null,
        null,
        '2023-12-12'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'russia_premiere_date'),
        null,
        null,
        null,
        null,
        '2023-12-31'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'advertising_start_date'),
        null,
        null,
        null,
        null,
        '2024-01-01'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'ticket_sale_start_date'),
        null,
        null,
        null,
        null,
        (SELECT CURRENT_DATE)
    ),
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'end_date'),
        null,
        null,
        null,
        null,
        (SELECT CURRENT_DATE + 20)
    ),
    (
        (SELECT id FROM movie WHERE name = 'Два мушкетера'),
        (SELECT id FROM attribute WHERE name = 'director'),
        'Сын маминой подруги',
        null,
        null,
        null,
        null
    ),
    (
        (SELECT id FROM movie WHERE name = 'Два мушкетера'),
        (SELECT id FROM attribute WHERE name = 'actor'),
        'Антон Лапенко',
        null,
        null,
        null,
        null
    ),
    (
        (SELECT id FROM movie WHERE name = 'Два мушкетера'),
        (SELECT id FROM attribute WHERE name = 'year'),
        null,
        null,
        2024,
        null,
        null
    ),
    (
        (SELECT id FROM movie WHERE name = 'Два мушкетера'),
        (SELECT id FROM attribute WHERE name = 'duration'),
        null,
        null,
        '130',
        null,
        null
    ),
    (
        (SELECT id FROM movie WHERE name = 'Два мушкетера'),
        (SELECT id FROM attribute WHERE name = 'genre'),
        'Драма',
        null,
        null,
        null,
        null
    ),
    (
        (SELECT id FROM movie WHERE name = 'Два мушкетера'),
        (SELECT id FROM attribute WHERE name = 'age_rating'),
        '12+',
        null,
        null,
        null,
        null
    ),
    (
        (SELECT id FROM movie WHERE name = 'Два мушкетера'),
        (SELECT id FROM attribute WHERE name = 'award_golden_raspberry'),
        null,
        true,
        null,
        null,
        null
    ),
    (
        (SELECT id FROM movie WHERE name = 'Два мушкетера'),
        (SELECT id FROM attribute WHERE name = 'world_premiere_date'),
        null,
        null,
        null,
        null,
        (SELECT CURRENT_DATE)
    ),
    (
        (SELECT id FROM movie WHERE name = 'Два мушкетера'),
        (SELECT id FROM attribute WHERE name = 'russia_premiere_date'),
        null,
        null,
        null,
        null,
        (SELECT CURRENT_DATE + 20)
    ),
    (
        (SELECT id FROM movie WHERE name = 'Два мушкетера'),
        (SELECT id FROM attribute WHERE name = 'advertising_start_date'),
        null,
        null,
        null,
        null,
        (SELECT CURRENT_DATE + 30)
    ),
    (
        (SELECT id FROM movie WHERE name = 'Два мушкетера'),
        (SELECT id FROM attribute WHERE name = 'ticket_sale_start_date'),
        null,
        null,
        null,
        null,
        (SELECT CURRENT_DATE + 40)
    ),
    (
        (SELECT id FROM movie WHERE name = 'Два мушкетера'),
        (SELECT id FROM attribute WHERE name = 'end_date'),
        null,
        null,
        null,
        null,
        (SELECT CURRENT_DATE + 60)
    ),
    (
        (SELECT id FROM movie WHERE name = 'Три мушкетера'),
        (SELECT id FROM attribute WHERE name = 'director'),
        'Тарантино',
        null,
        null,
        null,
        null
    ),
    (
        (SELECT id FROM movie WHERE name = 'Три мушкетера'),
        (SELECT id FROM attribute WHERE name = 'actor'),
        'Кристина Асмус',
        null,
        null,
        null,
        null
    ),
    (
        (SELECT id FROM movie WHERE name = 'Три мушкетера'),
        (SELECT id FROM attribute WHERE name = 'actor'),
        'Александр Петров',
        null,
        null,
        null,
        null
    ),
    (
        (SELECT id FROM movie WHERE name = 'Три мушкетера'),
        (SELECT id FROM attribute WHERE name = 'actor'),
        'Сергей Бурунов',
        null,
        null,
        null,
        null
    ),
    (
        (SELECT id FROM movie WHERE name = 'Три мушкетера'),
        (SELECT id FROM attribute WHERE name = 'year'),
        null,
        null,
        2024,
        null,
        null
    ),
    (
        (SELECT id FROM movie WHERE name = 'Три мушкетера'),
        (SELECT id FROM attribute WHERE name = 'duration'),
        null,
        null,
        '140',
        null,
        null
    ),
    (
        (SELECT id FROM movie WHERE name = 'Три мушкетера'),
        (SELECT id FROM attribute WHERE name = 'genre'),
        'Мультфильм',
        null,
        null,
        null,
        null
    ),
    (
        (SELECT id FROM movie WHERE name = 'Три мушкетера'),
        (SELECT id FROM attribute WHERE name = 'age_rating'),
        '18+',
        null,
        null,
        null,
        null
    ),
    (
        (SELECT id FROM movie WHERE name = 'Три мушкетера'),
        (SELECT id FROM attribute WHERE name = 'world_premiere_date'),
        null,
        null,
        null,
        null,
        (SELECT CURRENT_DATE + 20)
    ),
    (
        (SELECT id FROM movie WHERE name = 'Три мушкетера'),
        (SELECT id FROM attribute WHERE name = 'russia_premiere_date'),
        null,
        null,
        null,
        null,
        (SELECT CURRENT_DATE + 40)
    ),
    (
        (SELECT id FROM movie WHERE name = 'Три мушкетера'),
        (SELECT id FROM attribute WHERE name = 'advertising_start_date'),
        null,
        null,
        null,
        null,
        (SELECT CURRENT_DATE + 50)
    ),
    (
        (SELECT id FROM movie WHERE name = 'Три мушкетера'),
        (SELECT id FROM attribute WHERE name = 'ticket_sale_start_date'),
        null,
        null,
        null,
        null,
        (SELECT CURRENT_DATE + 60)
    ),
    (
        (SELECT id FROM movie WHERE name = 'Три мушкетера'),
        (SELECT id FROM attribute WHERE name = 'end_date'),
        null,
        null,
        null,
        null,
        (SELECT CURRENT_DATE + 80)
    );
