CREATE SCHEMA public;

-- #############################################################################

CREATE TABLE cinema
(
    ID            SERIAL PRIMARY KEY,
    name          VARCHAR(50)                    NOT NULL,
    count_rooms   INT                            NOT NULL,
    address       VARCHAR(255)                   NOT NULL,
    active_status BOOLEAN                        NOT NULL DEFAULT TRUE,
    created_at    TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT NOW(),
    updated_at    TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT NOW()
);

INSERT INTO cinema (name, count_rooms, address)
VALUES ('soft cinema', 10, 'samara,novo-sadovaya 206-30');


-- #############################################################################


CREATE TABLE room
(
    ID                           SERIAL PRIMARY KEY,
    cinema_id                    INT REFERENCES cinema (ID),
    seats_count                  INT                            NOT NULL,
    rows_count                   INT                            NOT NULL,
    renovation_date              DATE                                    DEFAULT NULL,
    fire_safety_license_end_date DATE                           NOT NULL,
    active_status                BOOLEAN                        NOT NULL DEFAULT TRUE,
    created_at                   TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT NOW(),
    updated_at                   TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT NOW()
);

INSERT INTO room (ID, cinema_id, seats_count, rows_count, renovation_date, fire_safety_license_end_date)
VALUES (1, 1, 30, 3, '2019-05-05', '2025-05-05'),
       (2, 1, 40, 4, '2018-05-05', '2025-06-05'),
       (3, 1, 50, 5, '2017-05-05', '2025-07-05'),
       (4, 1, 60, 6, '2016-05-05', '2025-08-05'),
       (5, 1, 70, 7, '2015-05-05', '2025-09-05');


-- #############################################################################


CREATE TABLE screening
(
    ID             SERIAL PRIMARY KEY,
    start_time     TIME                           NOT NULL,
    end_time       TIME                           NOT NULL,
    day_off_status BOOLEAN                        NOT NULL,
    price          DOUBLE PRECISION               NOT NULL,
    created_at     TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT NOW(),
    updated_at     TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT NOW()
);

INSERT INTO screening (start_time, end_time, day_off_status, price)
VALUES ('07:00:00', '09:00:00', true, 300),
       ('07:00:00', '09:00:00', false, 100),
       ('09:00:00', '11:00:00', true, 300),
       ('09:00:00', '11:00:00', false, 100),
       ('11:00:00', '13:00:00', true, 400),
       ('11:00:00', '13:00:00', false, 200),
       ('13:00:00', '15:00:00', true, 400),
       ('13:00:00', '15:00:00', false, 200),
       ('15:00:00', '17:00:00', true, 450),
       ('15:00:00', '17:00:00', false, 250),
       ('17:00:00', '19:00:00', true, 450),
       ('17:00:00', '19:00:00', false, 250),
       ('19:00:00', '21:00:00', true, 600),
       ('19:00:00', '21:00:00', false, 300),
       ('21:00:00', '23:00:00', true, 600),
       ('21:00:00', '23:00:00', false, 300),
       ('23:00:00', '01:00:00', true, 400),
       ('23:00:00', '01:00:00', false, 200);


-- #############################################################################


CREATE TABLE movie
(
    ID         SERIAL PRIMARY KEY,
    title      VARCHAR(255),
    created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT NOW()
);

INSERT INTO movie (title)
VALUES ('Marvel 5'),
       ('Marvel 4'),
       ('Marvel 3'),
       ('Marvel 2'),
       ('Marvel 1');

-- #############################################################################

CREATE TABLE movie_attr_type
(
    ID      SERIAL PRIMARY KEY,
    name    VARCHAR(60),
    comment TEXT
);

INSERT INTO movie_attr_type (name, comment)
VALUES ('date', null),
       ('integer', null),
       ('bool', null),
       ('text', null);

-- #############################################################################

CREATE TABLE movie_attr
(
    ID                 SERIAL PRIMARY KEY,
    movie_attr_type_id INT REFERENCES movie_attr_type (ID),
    name               VARCHAR(60)
);

INSERT INTO movie_attr (movie_attr_type_id, name)
VALUES (1, 'world_show_start_date'),
       (1, 'russia_show_start_date'),
       (2, 'likes_counts'),
       (4, 'first_night_press'),
       (3, 'oskar'),
       (3, 'nika'),
       (1, 'sale_start_tickets_date'),
       (1, 'advertising_start_date');

-- #############################################################################

CREATE TABLE movie_attr_value
(
    ID            SERIAL PRIMARY KEY,
    movie_id      INT REFERENCES movie (ID),
    movie_attr_id INT REFERENCES movie_attr (ID),
    val_date      DATE,
    val_text      VARCHAR,
    val_num       INT,
    val_bool      BOOLEAN
);

INSERT INTO movie_attr_value (movie_id, movie_attr_id, val_date, val_text, val_num, val_bool)
VALUES (1, 4, null,
        'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
        null, null),
       (2, 4, null,
        'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
        null, null),
       (3, 4, null,
        'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
        null, null),
       (4, 4, null,
        'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
        null, null),
       (5, 4, null,
        'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
        null, null),
       (1, 3, null, null, 1000, null),
       (2, 3, null, null, 800, null),
       (3, 3, null, null, 300, null),
       (4, 3, null, null, 600, null),
       (5, 3, null, null, 500, null),
       (1, 1, '2023-09-10', null, null, null),
       (1, 2, '2023-10-10', null, null, null),
       (2, 1, '2023-08-10', null, null, null),
       (2, 2, '2023-09-10', null, null, null),
       (3, 1, '2023-07-10', null, null, null),
       (3, 2, '2023-08-10', null, null, null),
       (4, 1, '2023-06-10', null, null, null),
       (4, 2, '2023-07-10', null, null, null),
       (5, 1, '2023-05-10', null, null, null),
       (5, 2, '2023-06-10', null, null, null),
       (1,5, null, null, null, true),
       (2,5, null, null, null, false),
       (3,5, null, null, null, true),
       (4,5, null, null, null, false),
       (5,5, null, null, null, true),
       (1,6, null, null, null, false),
       (2,6, null, null, null, true),
       (3,6, null, null, null, false),
       (4,6, null, null, null, true),
       (5,6, null, null, null, false),
       (1,7, '2023-09-21', null, null, null),
       (1,7, '2023-09-22', null, null, null),
       (2,7, '2023-09-23', null, null, null),
       (3,7, '2023-09-24', null, null, null),
       (4,7, '2023-09-25', null, null, null),
       (5,7, '2023-09-26', null, null, null),
       (1,8, '2023-10-10', null, null, null),
       (2,8, '2023-10-11', null, null, null),
       (3,8, '2023-10-12', null, null, null),
       (4,8, '2023-10-13', null, null, null),
       (5,8, '2023-10-15', null, null, null);

-- #############################################################################

CREATE TABLE room_screening
(
    room_id      INT REFERENCES room (ID),
    screening_id INT REFERENCES screening (ID),
    CONSTRAINT room_screening_pkey PRIMARY KEY (room_id, screening_id)
);

INSERT INTO room_screening
VALUES (1, 1),
       (1, 2),
       (1, 3),
       (1, 4),
       (1, 5),
       (1, 6),
       (1, 7),
       (1, 8),
       (1, 9),
       (1, 10),
       (1, 11),
       (1, 12),
       (1, 13),
       (1, 14),
       (1, 15),
       (1, 16),
       (1, 18),
       (2, 1),
       (2, 2),
       (2, 3),
       (2, 4),
       (2, 5),
       (2, 6),
       (2, 7),
       (2, 8),
       (2, 9),
       (2, 10),
       (2, 11),
       (2, 12),
       (2, 13),
       (2, 14),
       (2, 15),
       (2, 16),
       (2, 18),
       (3, 1),
       (3, 2),
       (3, 3),
       (3, 4),
       (3, 5),
       (3, 6),
       (3, 7),
       (3, 8),
       (3, 9),
       (3, 10),
       (3, 11),
       (3, 12),
       (3, 13),
       (3, 14),
       (3, 15),
       (3, 16),
       (3, 18),
       (4, 1),
       (4, 2),
       (4, 3),
       (4, 4),
       (4, 5),
       (4, 6),
       (4, 7),
       (4, 8),
       (4, 9),
       (4, 10),
       (4, 11),
       (4, 12),
       (4, 13),
       (4, 14),
       (4, 15),
       (4, 16),
       (4, 18),
       (5, 1),
       (5, 2),
       (5, 3),
       (5, 4),
       (5, 5),
       (5, 6),
       (5, 7),
       (5, 8),
       (5, 9),
       (5, 10),
       (5, 11),
       (5, 12),
       (5, 13),
       (5, 14),
       (5, 15),
       (5, 16),
       (5, 18);


-- #############################################################################


CREATE TABLE ticket
(
    screening_id INT REFERENCES screening (ID),
    movie_id     INT REFERENCES movie (ID),
    sale_date    DATE DEFAULT now()
);

INSERT INTO ticket
VALUES (1, 1),
       (1, 2),
       (1, 3),
       (1, 4),
       (1, 5),
       (1, 5),
       (1, 5),
       (2, 1),
       (2, 2),
       (2, 3),
       (2, 4),
       (2, 5),
       (2, 5),
       (2, 5),
       (3, 1),
       (3, 2),
       (3, 3),
       (3, 4),
       (3, 5),
       (4, 1),
       (4, 2),
       (4, 3),
       (4, 4),
       (4, 5),
       (4, 5),
       (4, 5),
       (5, 1),
       (5, 2),
       (5, 3),
       (5, 4),
       (5, 5),
       (5, 5),
       (5, 5),
       (6, 1),
       (6, 2),
       (6, 3),
       (6, 4),
       (6, 5),
       (6, 5),
       (6, 5),
       (7, 1),
       (7, 2),
       (7, 3),
       (7, 4),
       (7, 5),
       (7, 5),
       (7, 5),
       (8, 1),
       (8, 2),
       (8, 3),
       (8, 4),
       (8, 5),
       (8, 5),
       (8, 5),
       (9, 1),
       (9, 2),
       (9, 3),
       (9, 4),
       (9, 5),
       (9, 5),
       (9, 5),
       (10, 1),
       (10, 2),
       (10, 3),
       (10, 4),
       (10, 5),
       (10, 5),
       (10, 5),
       (11, 1),
       (11, 2),
       (11, 3),
       (11, 4),
       (11, 5),
       (11, 5),
       (11, 5),
       (12, 1),
       (12, 2),
       (12, 3),
       (12, 4),
       (12, 5),
       (13, 1),
       (13, 2),
       (13, 3),
       (13, 4),
       (13, 5),
       (14, 1),
       (14, 2),
       (14, 3),
       (14, 4),
       (14, 5),
       (15, 1),
       (15, 2),
       (15, 3),
       (15, 4),
       (15, 5),
       (16, 1),
       (16, 2),
       (16, 3),
       (16, 4),
       (16, 5),
       (17, 1),
       (17, 2),
       (17, 3),
       (17, 4),
       (17, 5),
       (18, 1),
       (18, 2),
       (18, 3),
       (18, 4),
       (18, 5);


-- #############################################################################

CREATE VIEW get_all_info_movies AS
SELECT m.title  AS movie_title,
       mat.name AS movie_attr_type,
       ma.name  AS movie_attr_name,
       COALESCE(mav.val_text,
                mav.val_num::varchar,
                mav.val_date::varchar,
                mav.val_bool::varchar
           )    AS movie_attr_value
FROM movie m
         INNER JOIN movie_attr_value mav ON m.ID = mav.movie_id
         INNER JOIN movie_attr ma ON mav.movie_attr_id = ma.ID
         INNER JOIN movie_attr_type mat ON ma.movie_attr_type_id = mat.ID
ORDER BY movie_attr_type;

-- #############################################################################

CREATE VIEW get_current_service_data_movies AS
SELECT m.title  AS movie_title,
       ma.name  AS movie_attr_name,
       mav.val_date AS movie_attr_value
FROM movie m
         INNER JOIN movie_attr_value mav  ON m.ID = mav.movie_id
         INNER JOIN movie_attr ma ON mav.movie_attr_id = ma.ID
         INNER JOIN movie_attr_type mat ON ma.movie_attr_type_id = mat.ID
WHERE mat.name = 'date' AND mav.val_date = CURRENT_DATE;

-- #############################################################################

CREATE VIEW get_future_service_data_movies AS
SELECT m.title  AS movie_title,
       ma.name  AS movie_attr_name,
       mav.val_date AS movie_attr_value
FROM movie m
         INNER JOIN movie_attr_value mav ON m.ID = mav.movie_id
         INNER JOIN movie_attr ma ON mav.movie_attr_id = ma.ID
         INNER JOIN movie_attr_type mat ON ma.movie_attr_type_id = mat.ID
WHERE mat.name = 'date' AND mav.val_date BETWEEN CURRENT_DATE + INTERVAL '20 days' AND CURRENT_DATE + INTERVAL '25 days';

-- #############################################################################

CREATE INDEX idx_movie_attr_type_name ON movie_attr_type (name);
CREATE INDEX idx_val_date ON movie_attr_value (val_date);
CREATE INDEX idx_movie_attr_type_id ON movie_attr (movie_attr_type_id);
CREATE INDEX idx_movie_id ON movie_attr_value (movie_id);
