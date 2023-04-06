/*
* Спроектировать EAV-хранение для базы данных кинотеатра
4 таблицы: фильмы, атрибуты, типы атрибутов, значения.
Типы атрибутов и соответствующие им атрибуты (для примера):

рецензии (текстовые значения) - рецензии критиков, отзыв неизвестной киноакадемии ...
премия (заменяется при печати баннеров и билетов на изображение, логическое значение) - оскар, ника ...
"важные даты" даты (при печати - наименование атрибута и значение даты, тип дата) - мировая премьера, премьера в РФ ...
служебные даты (используются при планировании, тип дата) - дата начала продажи билетов, когда запускать рекламу на ТВ
*/

/* Фильмы */
CREATE TABLE movie
(
    id         serial PRIMARY KEY,
    name       varchar(255) NOT NULL,
    start_date date         NOT NULL,
    duration   int          NOT NULL DEFAULT '0',
    PRIMARY KEY (id)
);

/* Типы атрибутов */
CREATE TABLE attribute_type
(
    id   serial PRIMARY KEY,
    name varchar(255) NOT NULL,
    type varchar(64)  NOT NULL,
    PRIMARY KEY (id)
);

/* Атрибуты */
CREATE TABLE attribute
(
    id                serial PRIMARY KEY,
    attribute_type_id int          NOT NULL,
    name              varchar(255) NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT FK_attribute_type_attribute FOREIGN KEY (attribute_type_id) REFERENCES attribute_type (id) ON DELETE CASCADE ON UPDATE CASCADE
);

/* Значения типов атрибутов */
CREATE TABLE movie_attribute_value
(
    id             serial PRIMARY KEY,
    attribute_id   int          NOT NULL,
    movie_id       int          NOT NULL,
    value_text     varchar(255) NOT NULL,
    value_integer  int                            DEFAULT NULL,
    value_boolean  boolean                        DEFAULT NULL,
    value_float    NUMERIC                        DEFAULT NULL,
    value_datetime TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
    PRIMARY KEY (id),
    CONSTRAINT FK_movie_attribute_value_attribute FOREIGN KEY (attribute_id) REFERENCES attribute (id) ON DELETE CASCADE ON UPDATE CASCADE
);

