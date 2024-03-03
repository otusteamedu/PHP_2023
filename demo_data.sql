INSERT INTO films (name)
VALUES ( 'Титаник'),
       ( 'Три Богатыря'),
       ( 'Мстители');

INSERT INTO attribute_types (name)
VALUES ('Рецензии'),
       ('Премия'),
       ('Важные даты'),
       ('Служебные даты');

INSERT INTO attributes (name, type_id)
VALUES ('Рецензии критиков', 1),
       ('Отзыв неизвестной киноакадемии', 1),
       ('Оскар', 2),
       ('Ника', 2),
       ('Мировая премьера', 3),
       ('Премьера в РФ', 3),
       ('Дата начала продажи билетов', 4),
       ('Когда запускать рекламу на ТВ', 4);

INSERT INTO attribute_values (films_id, attribute_id, varchar, bool, integer, float, date)
VALUES (1, 1, 'Рецензия: Титаник. Так же, как и «Терминатор»,' ||
              'это слово еще со времен выхода фильма на экраны, в 1997 году, стало нарицательным, ' ||
              'подразумевая под собой величайший кинематографический шедевр',
        NULL, NULL, NULL, NULL),
       (2, 1, 'Рецензия:Главная мысль сказки — нет никого на свете сильнее наших богатырей, ' ||
              'могучих и отважных воинов-защитников родной Земли.', NULL, NULL, NULL, NULL),
       (3, 2, 'Отзыв: Мстители не теряют в динамике. Это безусловно самый масштабный фильм',
        NULL, NULL, NULL, NULL),
       (1, 3, NULL, TRUE, NULL, NULL, NULL),
       (2, 3, NULL, TRUE, NULL, NULL, NULL),
       (3, 4, NULL, TRUE, NULL, NULL, NULL),
       (1, 5, NULL, NULL, NULL, NULL, '1997-03-01'),
       (2, 6, NULL, NULL, NULL, NULL, '2002-01-02'),
       (3, 6, NULL, NULL, NULL, NULL, '2005-12-31'),
       (1, 6, NULL, NULL, NULL, NULL, '1998-01-01'),
       (2, 7, NULL, NULL, NULL, NULL, '2002-02-02'),
       (3, 8, NULL, NULL, NULL, NULL, '2001-12-01');

INSERT INTO films (name)
VALUES ( 'Лёд 3');

INSERT INTO attribute_values (films_id, attribute_id, varchar, bool, integer, float, date)
VALUES (4, 1, 'российская музыкальная спортивная мелодрама режиссёра Юрия Хмельницкого, ' ||
              'для которого проект стал дебютной полнометражной работой.', NULL,NULL,NULL,NULL),
    (4, 7, NULL, NULL,NULL,NULL,'2024-03-03'),
    (4, 8, NULL, NULL,NULL,NULL,'2024-03-27');