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
    ('year', 'Год выхода', (SELECT id FROM attribute_type WHERE name = 'date')),
    ('duration', 'Продолжиткльность', (SELECT id FROM attribute_type WHERE name = 'integer')),
    ('genre', 'Жанр', (SELECT id FROM attribute_type WHERE name = 'string')),
    ('age_rating', 'Возрастной рейтинг', (SELECT id FROM attribute_type WHERE name = 'string')),
    ('award', 'Премия', (SELECT id FROM attribute_type WHERE name = 'string')),
    ('world_premiere_date', 'Мировая премьера', (SELECT id FROM attribute_type WHERE name = 'date')),
    ('russia_premiere_date', 'Премьера в РФ', (SELECT id FROM attribute_type WHERE name = 'date')),
    ('advertising_start_date', 'Дата начала запуска рекламы', (SELECT id FROM attribute_type WHERE name = 'date')),
    ('ticket_sale_start_date', 'Дата начала продажи билетов', (SELECT id FROM attribute_type WHERE name = 'date')),
    ('end_date', 'Дата окончания показа', (SELECT id FROM attribute_type WHERE name = 'date'));

INSERT INTO value (movie_id, attribute_id, value)
VALUES
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'director'),
        'Василий шестеперов'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'actor'),
        'Гоша Куценко'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'actor'),
        'Бред Пит'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'actor'),
        'Кристиан Бейл'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'actor'),
        'Марго Робби'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'actor'),
        'Диана Арбенина'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'year'),
        '2023'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'duration'),
        '120'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'genre'),
        'Ужасы'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'age_rating'),
        '3+'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'award'),
        'Золотая малина'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'award'),
        'Паленая ветвь'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'award'),
        'Оскар (Кучера)'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'world_premiere_date'),
        '2023-12-12'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'russia_premiere_date'),
        '2023-12-31'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'advertising_start_date'),
        '2024-01-01'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'ticket_sale_start_date'),
        (SELECT CURRENT_DATE)
    ),
    (
        (SELECT id FROM movie WHERE name = 'Один мушкетер'),
        (SELECT id FROM attribute WHERE name = 'end_date'),
        (SELECT CURRENT_DATE + 20)
    ),
    (
        (SELECT id FROM movie WHERE name = 'Два мушкетера'),
        (SELECT id FROM attribute WHERE name = 'director'),
        'Сын маминой подруги'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Два мушкетера'),
        (SELECT id FROM attribute WHERE name = 'actor'),
        'Антон Лапенко'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Два мушкетера'),
        (SELECT id FROM attribute WHERE name = 'year'),
        '2024'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Два мушкетера'),
        (SELECT id FROM attribute WHERE name = 'duration'),
        '130'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Два мушкетера'),
        (SELECT id FROM attribute WHERE name = 'genre'),
        'Драма'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Два мушкетера'),
        (SELECT id FROM attribute WHERE name = 'age_rating'),
        '12+'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Два мушкетера'),
        (SELECT id FROM attribute WHERE name = 'award'),
        'Золотистый Глобус'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Два мушкетера'),
        (SELECT id FROM attribute WHERE name = 'award'),
        'Ника'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Два мушкетера'),
        (SELECT id FROM attribute WHERE name = 'world_premiere_date'),
        (SELECT CURRENT_DATE)
    ),
    (
        (SELECT id FROM movie WHERE name = 'Два мушкетера'),
        (SELECT id FROM attribute WHERE name = 'russia_premiere_date'),
        (SELECT CURRENT_DATE + 20)
    ),
    (
        (SELECT id FROM movie WHERE name = 'Два мушкетера'),
        (SELECT id FROM attribute WHERE name = 'advertising_start_date'),
        (SELECT CURRENT_DATE + 30)
    ),
    (
        (SELECT id FROM movie WHERE name = 'Два мушкетера'),
        (SELECT id FROM attribute WHERE name = 'ticket_sale_start_date'),
        (SELECT CURRENT_DATE + 40)
    ),
    (
        (SELECT id FROM movie WHERE name = 'Два мушкетера'),
        (SELECT id FROM attribute WHERE name = 'end_date'),
        (SELECT CURRENT_DATE + 60)
    ),
    (
        (SELECT id FROM movie WHERE name = 'Три мушкетера'),
        (SELECT id FROM attribute WHERE name = 'director'),
        'Тарантино'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Три мушкетера'),
        (SELECT id FROM attribute WHERE name = 'actor'),
        'Кристина Асмус'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Три мушкетера'),
        (SELECT id FROM attribute WHERE name = 'actor'),
        'Александр Петров'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Три мушкетера'),
        (SELECT id FROM attribute WHERE name = 'actor'),
        'Сергей Бурунов'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Три мушкетера'),
        (SELECT id FROM attribute WHERE name = 'year'),
        '2024'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Три мушкетера'),
        (SELECT id FROM attribute WHERE name = 'duration'),
        '140'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Три мушкетера'),
        (SELECT id FROM attribute WHERE name = 'genre'),
        'Мультфильм'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Три мушкетера'),
        (SELECT id FROM attribute WHERE name = 'age_rating'),
        '18+'
    ),
    (
        (SELECT id FROM movie WHERE name = 'Три мушкетера'),
        (SELECT id FROM attribute WHERE name = 'world_premiere_date'),
        (SELECT CURRENT_DATE + 20)
    ),
    (
        (SELECT id FROM movie WHERE name = 'Три мушкетера'),
        (SELECT id FROM attribute WHERE name = 'russia_premiere_date'),
        (SELECT CURRENT_DATE + 40)
    ),
    (
        (SELECT id FROM movie WHERE name = 'Три мушкетера'),
        (SELECT id FROM attribute WHERE name = 'advertising_start_date'),
        (SELECT CURRENT_DATE + 50)
    ),
    (
        (SELECT id FROM movie WHERE name = 'Три мушкетера'),
        (SELECT id FROM attribute WHERE name = 'ticket_sale_start_date'),
        (SELECT CURRENT_DATE + 60)
    ),
    (
        (SELECT id FROM movie WHERE name = 'Три мушкетера'),
        (SELECT id FROM attribute WHERE name = 'end_date'),
        (SELECT CURRENT_DATE + 80)
    )
;
