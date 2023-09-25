INSERT INTO films (title, description)
VALUES ('Звездные Войны: Эпизод IV - Новая надежда', 'Фантастический фильм'),
       ('Шрек', 'Мультфильм о приключениях Шрека'),
       ('Интерстеллар', 'Фильм о путешествиях в космос.'),
       ('Титаник', 'Классика жанра');

INSERT INTO attribute_types (name)
VALUES ('Отзыв'),
       ('Премия'),
       ('Дата'),
       ('Служебная дата'),
       ('Рейтинг');

INSERT INTO attributes (name)
VALUES ('Рецензии критиков'),
       ('Отзыв телезрителя'),
       ('Комментарий актера'),
       ('Получили ли оскар'),
       ('Дата мировой премьеры'),
       ('Дата премьеры в РФ'),
       ('Дата, когда нужно запускать рекламу'),
       ('Рейтинг ImDB');

INSERT INTO values (film_id, attribute_id, type_id, text_value)
VALUES (1, 1, 1, 'Отличный фильм! Сюжет, спецэффекты и актерская игра на высшем уровне.');
INSERT INTO values (film_id, attribute_id, type_id, text_value)
VALUES (1, 1, 1, 'Мне понравился этот фильм. Звездные Войны всегда впечатляют.');
INSERT INTO values (film_id, attribute_id, type_id, text_value)
VALUES (1, 1, 1, 'Было честь сниматься в этом фильме. Фантастическая команда и зрелищные битвы.');
INSERT INTO values (film_id, attribute_id, type_id, bool_value)
VALUES (1, 2, 2, true);
INSERT INTO values (film_id, attribute_id, type_id, date_value)
VALUES (1, 3, 3, '1977-05-25');
INSERT INTO values (film_id, attribute_id, type_id, date_value)
VALUES (1, 3, 3, '1977-12-23');
INSERT INTO values (film_id, attribute_id, type_id, date_value)
VALUES (1, 7, 4, '2023-10-15');
INSERT INTO values (film_id, attribute_id, type_id, integer_value)
VALUES (1, 5, 5, 98);

INSERT INTO values (film_id, attribute_id, type_id, text_value)
VALUES (2, 1, 1, 'Забавный мультфильм с хорошей анимацией.');
INSERT INTO values (film_id, attribute_id, type_id, text_value)
VALUES (2, 1, 1, 'Мультфильм понравился всей семье.');
INSERT INTO values (film_id, attribute_id, type_id, text_value)
VALUES (2, 1, 1, 'Работать над этим мультфильмом было весело и интересно.');
INSERT INTO values (film_id, attribute_id, type_id, bool_value)
VALUES (2, 2, 2, false);
INSERT INTO values (film_id, attribute_id, type_id, date_value)
VALUES (2, 3, 3, '2001-05-18');
INSERT INTO values (film_id, attribute_id, type_id, date_value)
VALUES (2, 3, 3, '2001-06-28');
INSERT INTO values (film_id, attribute_id, type_id, date_value)
VALUES (2, 7, 4, '2023-11-01');
INSERT INTO values (film_id, attribute_id, type_id, integer_value)
VALUES (2, 5, 5, 75);

INSERT INTO values (film_id, attribute_id, type_id, text_value)
VALUES (3, 1, 1, 'Интересный и визуально потрясающий фильм о космических приключениях.');
INSERT INTO values (film_id, attribute_id, type_id, text_value)
VALUES (3, 1, 1, 'Интерстеллар оставил глубокое впечатление и задуматься о нашем месте во Вселенной.');
INSERT INTO values (film_id, attribute_id, type_id, text_value)
VALUES (3, 1, 1, 'Интерстеллар - это проект мечты для актера.');
INSERT INTO values (film_id, attribute_id, type_id, bool_value)
VALUES (3, 2, 2, true);
INSERT INTO values (film_id, attribute_id, type_id, date_value)
VALUES (3, 3, 3, '2014-10-26');
INSERT INTO values (film_id, attribute_id, type_id, date_value)
VALUES (3, 3, 3, '2014-11-06');
INSERT INTO values (film_id, attribute_id, type_id, date_value)
VALUES (3, 7, 4, '2023-10-01');
INSERT INTO values (film_id, attribute_id, type_id, integer_value)
VALUES (3, 5, 5, 86);

INSERT INTO values (film_id, attribute_id, type_id, text_value)
VALUES (4, 1, 1, 'Знаменитая драма о катастрофе Титаника.');
INSERT INTO values (film_id, attribute_id, type_id, text_value)
VALUES (4, 1, 1, 'Титаник - один из самых известных фильмов в истории кино.');
INSERT INTO values (film_id, attribute_id, type_id, text_value)
VALUES (4, 1, 1, 'Съемки в Титанике были очень трудными и захватывающими.');
INSERT INTO values (film_id, attribute_id, type_id, bool_value)
VALUES (4, 2, 2, true);
INSERT INTO values (film_id, attribute_id, type_id, date_value)
VALUES (4, 3, 3, '1997-11-01');
INSERT INTO values (film_id, attribute_id, type_id, date_value)
VALUES (4, 3, 3, '1997-12-18');
INSERT INTO values (film_id, attribute_id, type_id, date_value)
VALUES (4, 7, 4, CURRENT_DATE);
INSERT INTO values (film_id, attribute_id, type_id, integer_value)
VALUES (4, 5, 5, 87);
