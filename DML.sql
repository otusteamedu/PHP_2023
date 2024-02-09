INSERT INTO movie_attribute_type (name) VALUES ('Рецензии'); -- id=1
INSERT INTO movie_attribute_type (name) VALUES ('Премия'); -- id=2
INSERT INTO movie_attribute_type (name) VALUES ('Важные даты'); -- id=3
INSERT INTO movie_attribute_type (name) VALUES ('Служебные даты'); -- id=4

INSERT INTO movie_attribute (name, attr_type_id) VALUES ('Рецензии критиков', 1); -- id=1
INSERT INTO movie_attribute (name, attr_type_id) VALUES ('Отзыв неизвестной киноакадемии', 1); -- id=2
INSERT INTO movie_attribute (name, attr_type_id) VALUES ('Оскар', 2); -- id=3
INSERT INTO movie_attribute (name, attr_type_id) VALUES ('Ника', 2); -- id=4
INSERT INTO movie_attribute (name, attr_type_id) VALUES ('Мировая премьера', 3); -- id=5
INSERT INTO movie_attribute (name, attr_type_id) VALUES ('Премьера в РФ', 3); -- id=6
INSERT INTO movie_attribute (name, attr_type_id) VALUES ('Дата начала продажи билетов', 4); -- id=7
INSERT INTO movie_attribute (name, attr_type_id) VALUES ('Дата запуска рекламы на ТВ', 4); -- id=8

INSERT INTO movie (title, description, duration) VALUES ('Форест гамп', '«Фо́ррест Гамп» (англ. Forrest Gump) — комедийная драма, девятый полнометражный фильм режиссёра Роберта Земекиса. Поставлен по одноимённому роману Уинстона Грума (1986), вышел на экраны в 1994 году. Наиболее успешный фильм режиссёра как среди зрителей (первое место по сборам в 1994 году), так и среди критиков и профессиональных кинематографистов (38 наград по всему миру, включая 6 премий «Оскар»).', 8520); -- id=1
INSERT INTO movie (title, description, duration) VALUES ('Приключения Паддингтона', 'В дремучем Перу британский географ обнаруживает ранее неизвестный вид медведя. Он собирается застрелить его, чтобы забрать образец в Великобританию, в то время как другой медведь игриво забирает его винтовку и спасает ему жизнь, снимая смертельного скорпиона с куртки. Географ узнаёт, что эта семья медведей разумна и может выучить английский язык, а также они очень любят мармелад. Медведи получают имена Люси и Пастуцо. Уходя, географ бросает свою шляпу Пастуцо и говорит, что им всегда рады, если они захотят поехать в Лондон.', 4800); -- id=2
INSERT INTO movie (title, description, duration) VALUES ('Зеленая книга', '«Зелёная кни́га» (англ. Green Book) — американская биографическая комедийная драма режиссёра Питера Фаррелли, вышедшая на экраны в 2018 году. Картина рассказывает реальную историю путешествия по югу США известного джазового пианиста Дона Ширли и обычного водителя Тони Валлелонги, между которыми со временем возникает дружба. Главные роли исполнили Вигго Мортенсен, Махершала Али и Линда Карделлини.', 7204); -- id=3

INSERT INTO movie_attribute_value (movie_id, attr_id, value_text) VALUES (1, 1, 'Рецензия критика: прелестно');
INSERT INTO movie_attribute_value (movie_id, attr_id, value_text) VALUES (1, 2, 'Отзыв неизвестной киноакадемии: Том Хэнкс - молодец');
INSERT INTO movie_attribute_value (movie_id, attr_id, value_boolean) VALUES (1, 3, true);
INSERT INTO movie_attribute_value (movie_id, attr_id, value_boolean) VALUES (1, 4, true);
INSERT INTO movie_attribute_value (movie_id, attr_id, value_date) VALUES (1, 5, '2024-01-05');
INSERT INTO movie_attribute_value (movie_id, attr_id, value_date) VALUES (1, 6, '2022-01-08');
INSERT INTO movie_attribute_value (movie_id, attr_id, value_date) VALUES (1, 7, '2024-02-07');
INSERT INTO movie_attribute_value (movie_id, attr_id, value_date) VALUES (1, 8, '2024-02-27');

INSERT INTO movie_attribute_value (movie_id, attr_id, value_text) VALUES (2, 1, 'Рецензия критика: мило');
INSERT INTO movie_attribute_value (movie_id, attr_id, value_text) VALUES (2, 2, 'Отзыв неизвестной киноакадемии: 4/5');
INSERT INTO movie_attribute_value (movie_id, attr_id, value_boolean) VALUES (2, 3, true);
INSERT INTO movie_attribute_value (movie_id, attr_id, value_boolean) VALUES (2, 4, false);
INSERT INTO movie_attribute_value (movie_id, attr_id, value_date) VALUES (2, 5, '2024-01-06');
INSERT INTO movie_attribute_value (movie_id, attr_id, value_date) VALUES (2, 6, '2022-01-09');
INSERT INTO movie_attribute_value (movie_id, attr_id, value_date) VALUES (2, 7, '2024-02-28');
INSERT INTO movie_attribute_value (movie_id, attr_id, value_date) VALUES (2, 8, '2024-02-07');

INSERT INTO movie_attribute_value (movie_id, attr_id, value_text) VALUES (3, 1, 'Рецензия критика: интересно');
INSERT INTO movie_attribute_value (movie_id, attr_id, value_text) VALUES (3, 2, 'Отзыв неизвестной киноакадемии: болтун хорош');
INSERT INTO movie_attribute_value (movie_id, attr_id, value_boolean) VALUES (3, 3, true);
INSERT INTO movie_attribute_value (movie_id, attr_id, value_boolean) VALUES (3, 4, false);
INSERT INTO movie_attribute_value (movie_id, attr_id, value_date) VALUES (3, 5, '2024-01-01');
INSERT INTO movie_attribute_value (movie_id, attr_id, value_date) VALUES (3, 6, '2022-01-02');
INSERT INTO movie_attribute_value (movie_id, attr_id, value_date) VALUES (3, 7, '2024-02-27');
INSERT INTO movie_attribute_value (movie_id, attr_id, value_date) VALUES (3, 8, '2024-02-28');
