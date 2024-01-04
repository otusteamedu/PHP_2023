INSERT INTO entity_attribute_types (name, datatype) VALUES ('Рецензии', 'TEXT');
INSERT INTO entity_attribute_types (name, datatype) VALUES ('Премия', 'BOOLEAN');
INSERT INTO entity_attribute_types (name, datatype) VALUES ('Важные даты', 'DATE');
INSERT INTO entity_attribute_types (name, datatype) VALUES ('Служебные даты', 'TIMESTAMP');

INSERT INTO entity_attributes (name, attribute_type) VALUES ('Рецензии критиков', 1);
INSERT INTO entity_attributes (name, attribute_type) VALUES ('Отзыв неизвестной киноакадемии', 1);
INSERT INTO entity_attributes (name, attribute_type) VALUES ('Оскар', 2);
INSERT INTO entity_attributes (name, attribute_type) VALUES ('Ника', 2);
INSERT INTO entity_attributes (name, attribute_type) VALUES ('Мировая премьера', 3);
INSERT INTO entity_attributes (name, attribute_type) VALUES ('Премьера в РФ', 3);
INSERT INTO entity_attributes (name, attribute_type) VALUES ('Дата начала продажи билетов', 4);
INSERT INTO entity_attributes (name, attribute_type) VALUES ('Дата запуска рекламы', 4);

INSERT INTO movies (name, description, rate, duration, price) VALUES ('Зеленая миля', 'Описание', 10, 3600, 2500);
INSERT INTO movies (name, description, rate, duration, price) VALUES ('Игра в лифте', 'Описание', 10, 3600, 5000);
INSERT INTO movies (name, description, rate, duration, price) VALUES ('Дочь болотного короля', 'Описание', 10, 3600, 4000);

INSERT INTO entity_attribute_values (entity_id, attribute_id, value_string) VALUES (1, 1, 'Отзыв критика о Зеленая миля');
INSERT INTO entity_attribute_values (entity_id, attribute_id, value_string) VALUES (1, 2, 'Отзыв неизвестной киноакадемии о Зеленая миля');
INSERT INTO entity_attribute_values (entity_id, attribute_id, value_boolean) VALUES (1, 3, true);
INSERT INTO entity_attribute_values (entity_id, attribute_id, value_boolean) VALUES (1, 4, false);
INSERT INTO entity_attribute_values (entity_id, attribute_id, value_date) VALUES (1, 5, '2024-01-05');
INSERT INTO entity_attribute_values (entity_id, attribute_id, value_date) VALUES (1, 6, '2022-01-08');
INSERT INTO entity_attribute_values (entity_id, attribute_id, value_timestamp) VALUES (1, 7, '2024-01-04');
INSERT INTO entity_attribute_values (entity_id, attribute_id, value_timestamp) VALUES (1, 8, '2024-01-04');

INSERT INTO entity_attribute_values (entity_id, attribute_id, value_string) VALUES (2, 1, 'Отзыв критика о Игра в лифте');
INSERT INTO entity_attribute_values (entity_id, attribute_id, value_string) VALUES (2, 2, 'Отзыв неизвестной киноакадемии о Игра в лифте');
INSERT INTO entity_attribute_values (entity_id, attribute_id, value_boolean) VALUES (2, 3, false);
INSERT INTO entity_attribute_values (entity_id, attribute_id, value_boolean) VALUES (2, 4, false);
INSERT INTO entity_attribute_values (entity_id, attribute_id, value_date) VALUES (2, 5, '2024-01-04');
INSERT INTO entity_attribute_values (entity_id, attribute_id, value_date) VALUES (2, 6, '2022-01-10');
INSERT INTO entity_attribute_values (entity_id, attribute_id, value_timestamp) VALUES (2, 7, '2024-01-24');
INSERT INTO entity_attribute_values (entity_id, attribute_id, value_timestamp) VALUES (2, 8, '2024-01-25');

INSERT INTO entity_attribute_values (entity_id, attribute_id, value_string) VALUES (3, 1, 'Отзыв критика о Дочь болотного короля');
INSERT INTO entity_attribute_values (entity_id, attribute_id, value_string) VALUES (3, 2, 'Отзыв неизвестной киноакадемии о Дочь болотного короля');
INSERT INTO entity_attribute_values (entity_id, attribute_id, value_boolean) VALUES (3, 3, true);
INSERT INTO entity_attribute_values (entity_id, attribute_id, value_boolean) VALUES (3, 4, true);
INSERT INTO entity_attribute_values (entity_id, attribute_id, value_date) VALUES (3, 5, '2024-01-04');
INSERT INTO entity_attribute_values (entity_id, attribute_id, value_date) VALUES (3, 6, '2022-01-04');
INSERT INTO entity_attribute_values (entity_id, attribute_id, value_timestamp) VALUES (3, 7, '2024-01-25');
INSERT INTO entity_attribute_values (entity_id, attribute_id, value_timestamp) VALUES (3, 8, '2024-01-24');