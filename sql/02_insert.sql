INSERT INTO attribute_types (id, key, type) VALUES (1, 'review', 'text');
INSERT INTO attribute_types (id, key, type) VALUES (2, 'award', 'boolean');
INSERT INTO attribute_types (id, key, type) VALUES (3, 'public_date', 'datetime');
INSERT INTO attribute_types (id, key, type) VALUES (4, 'service_date', 'datetime');

INSERT INTO attributes (id, type_id, name) VALUES (1, 1, 'Рецензия критиков');
INSERT INTO attributes (id, type_id, name) VALUES (2, 1, 'Отзыв неизвестной киноакадемии');
INSERT INTO attributes (id, type_id, name) VALUES (3, 2, 'Ника');
INSERT INTO attributes (id, type_id, name) VALUES (4, 2, 'Оскар');
INSERT INTO attributes (id, type_id, name) VALUES (5, 3, 'Мировая премьера');
INSERT INTO attributes (id, type_id, name) VALUES (6, 3, 'Премьера в РФ');
INSERT INTO attributes (id, type_id, name) VALUES (7, 4, 'Дата начала продажи билетов');
INSERT INTO attributes (id, type_id, name) VALUES (8, 4, 'Дата старта рекламы по ТВ');

INSERT INTO cinema_halls (id, name) VALUES (1, 'Красный зал');
INSERT INTO cinema_halls (id, name) VALUES (2, 'Оранжевый зал');
INSERT INTO cinema_halls (id, name) VALUES (3, 'Синий зал');

INSERT INTO genres (id, name) VALUES (1, 'комедия');
INSERT INTO genres (id, name) VALUES (2, 'триллер');
INSERT INTO genres (id, name) VALUES (3, 'ужас');
INSERT INTO genres (id, name) VALUES (4, 'мультфильм');
INSERT INTO genres (id, name) VALUES (5, 'мелодрама');
INSERT INTO genres (id, name) VALUES (6, 'мюзикл');
INSERT INTO genres (id, name) VALUES (7, 'экшн');
INSERT INTO genres (id, name) VALUES (8, 'боевик');
INSERT INTO genres (id, name) VALUES (9, 'вестерн');

INSERT INTO place_types (id, name) VALUES (1, 'кресло');
INSERT INTO place_types (id, name) VALUES (2, 'диван');
