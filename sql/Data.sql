INSERT INTO "attribute_types" VALUES
    ((SELECT nextval('attribute_types_id_seq')), 'review', 'text'),
    ((SELECT nextval('attribute_types_id_seq')), 'award', 'boolean'),
    ((SELECT nextval('attribute_types_id_seq')), 'public_dates', 'datetime'),
    ((SELECT nextval('attribute_types_id_seq')), 'service_dates', 'datetime');

INSERT INTO "attributes" VALUES
    ((SELECT nextval('attributes_id_seq')), (SELECT id FROM attribute_types WHERE key = 'review'), 'Рецензия критиков'),
    ((SELECT nextval('attributes_id_seq')), (SELECT id FROM attribute_types WHERE key = 'review'), 'Отзыв неизвестной киноакадемии'),
    ((SELECT nextval('attributes_id_seq')), (SELECT id FROM attribute_types WHERE key = 'award'), 'Ника'),
    ((SELECT nextval('attributes_id_seq')), (SELECT id FROM attribute_types WHERE key = 'award'), 'Оскар'),
    ((SELECT nextval('attributes_id_seq')), (SELECT id FROM attribute_types WHERE key = 'public_dates'), 'Мировая премьера'),
    ((SELECT nextval('attributes_id_seq')), (SELECT id FROM attribute_types WHERE key = 'public_dates'), 'Премьера в РФ'),
    ((SELECT nextval('attributes_id_seq')), (SELECT id FROM attribute_types WHERE key = 'service_dates'), 'Дата начала продажи билетов'),
    ((SELECT nextval('attributes_id_seq')), (SELECT id FROM attribute_types WHERE key = 'service_dates'), 'Дата старта рекламы по ТВ');

INSERT INTO "movies" VALUES
    ((SELECT nextval('movies_id_seq')), 'Лето 84');

INSERT INTO "movie_attribute_values" VALUES
    (
        (SELECT nextval('movie_attribute_values_id_seq')),
        (SELECT id FROM movies WHERE name = 'Лето 84'),
        (SELECT id FROM attributes WHERE name = 'Рецензия критиков'),
        NULL,
        NULL,
        NULL,
        NULL,
        'Просмотрев фильм «Лето 84», на ум приходит поговорка: «Поспешишь – людей насмешишь». И это я не про реализацию фильма, а про свои обманчивые ощущения и попытки предсказать, что же будет дальше.',
        NULL
    ),
    (
        (SELECT nextval('movie_attribute_values_id_seq')),
        (SELECT id FROM movies WHERE name = 'Лето 84'),
        (SELECT id FROM attributes WHERE name = 'Отзыв неизвестной киноакадемии'),
        NULL,
        NULL,
        NULL,
        NULL,
        '«Лето 84» - это классический триллер/драма, в котором реальная жизнь намного ужасней клоуна с шариком.',
        NULL
    ),
    (
        (SELECT nextval('movie_attribute_values_id_seq')),
        (SELECT id FROM movies WHERE name = 'Лето 84'),
        (SELECT id FROM attributes WHERE name = 'Ника'),
        false,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL
    ),
    (
        (SELECT nextval('movie_attribute_values_id_seq')),
        (SELECT id FROM movies WHERE name = 'Лето 84'),
        (SELECT id FROM attributes WHERE name = 'Оскар'),
        false,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL
    ),
    (
        (SELECT nextval('movie_attribute_values_id_seq')),
        (SELECT id FROM movies WHERE name = 'Лето 84'),
        (SELECT id FROM attributes WHERE name = 'Мировая премьера'),
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        '2018-01-22 00:00:00 +00:00'
    ),
    (
        (SELECT nextval('movie_attribute_values_id_seq')),
        (SELECT id FROM movies WHERE name = 'Лето 84'),
        (SELECT id FROM attributes WHERE name = 'Премьера в РФ'),
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        '2018-01-22 00:00:00 +03:00'
    ),
    (
        (SELECT nextval('movie_attribute_values_id_seq')),
        (SELECT id FROM movies WHERE name = 'Лето 84'),
        (SELECT id FROM attributes WHERE name = 'Дата начала продажи билетов'),
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        '2018-01-22 00:00:00 +03:00'
    ),
    (
        (SELECT nextval('movie_attribute_values_id_seq')),
        (SELECT id FROM movies WHERE name = 'Лето 84'),
        (SELECT id FROM attributes WHERE name = 'Дата старта рекламы по ТВ'),
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        '2018-01-22 00:00:00 +03:00'
    );
