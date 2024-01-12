
INSERT INTO film (name, long) VALUES
('Шедевр1',1),
('Шедевр2',1),
('Шедевр3',2),
('Шедевр4',1),
('Скучно1',1),
('Скучно2',2);

INSERT INTO typeAttribute (name) VALUES
('text'),
('integer'),
('boolean'),
('float'),
('data'),
('string');

INSERT INTO Attribute (id_type, name) VALUES
(1, 'рецензии критиков' ),
(3,'премия Оскар'),
(3,'премия Ника'),
(3,'премия Лучший фильм года'),
(5,'мировая премьера'),
(5,'премьера в РФ'),
(5,'премьера в СПБ'),
(5,'дата начала продажи билетов'),
(5,'дата запуска рекламы'),
(1,'отзыв киноакадемии'),
(5,'старт проката'),
(6,'режиссер'),
(5,'сценарист'),
(4,'стоимость'),
(4,'жанр фильма');

CREATE TABLE valueAttribute (
    id SERIAL PRIMARY KEY,
    id_attribute INT NOT NULL,
    id_film INT NOT NULL,
        int_value INT,
        bool_value BOOL,
        text_value TEXT,
        char_value VARCHAR(255),
        num_value NUMERIC,
        time_value TIMESTAMP without time zone NULL,

INSERT INTO valueAttribute(id,id_attribute, id_film)
select
gs.id,
floor(random() * 13 + 1),
floor(random() * 6 + 1)
from generate_series(1,1000) as gs(id);

update valueAttribute as va
set int_value=floor(random() * 100 + 1)
from ATTRIBUTE as a
where va.id_attribute = a.id
and a.id_type=2;

update valueAttribute as va
set bool_value=true
from ATTRIBUTE as a
where va.id_attribute = a.id
and a.id_type=3;

update valueAttribute as va
set text_value=lipsum(25)
from ATTRIBUTE as a
where va.id_attribute = a.id
and a.id_type=1;

update valueAttribute as va
set char_value=lipsum(7)
from ATTRIBUTE as a
where va.id_attribute = a.id
and a.id_type=6;

update valueAttribute as va
set num_value=floor(random() * 10000 + 1)/100
from ATTRIBUTE as a
where va.id_attribute = a.id
and a.id_type=4;

update valueAttribute as va
set time_value=to_timestamp(random()* 63158399 + 1672520400)
from ATTRIBUTE as a
where va.id_attribute = a.id
and a.id_type=5;




