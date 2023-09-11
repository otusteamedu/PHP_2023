CREATE TABLE cinema
(
    ID          SERIAL PRIMARY KEY,
    name        VARCHAR(50)                    NOT NULL,
    count_rooms INT                            NOT NULL,
    address     VARCHAR(255)                   NOT NULL,
    status      INT                            NOT NULL DEFAULT 1,
    created_at  TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT NOW(),
    updated_at  TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT NOW()
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
    status                       INT                            NOT NULL DEFAULT 1,
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
    ID                 SERIAL PRIMARY KEY,
    screening_id       INT REFERENCES screening (ID),
    title              VARCHAR(255),
    show_start_date    DATE,
    show_end_date      DATE,
    likes_counts       INT,
    created_at         TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT NOW(),
    updated_at         TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT NOW()
);

INSERT INTO movie (title, show_start_date, show_end_date, likes_counts)
VALUES ('Marvel 5', '2023-09-10', '2023-10-10', 500),
       ('Marvel 4', '2023-08-10', '2023-09-10', 600),
       ('Marvel 3', '2023-07-10', '2023-08-10', 300),
       ('Marvel 2', '2023-06-10', '2023-07-10', 800),
       ('Marvel 1', '2023-05-10', '2023-06-10', 1000);


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
    created_at   TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT NOW()
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


select m.ID            as movie_id,
       m.title         as movie_title,
       count(movie_id) as tickets_sold_out_count,
       sum(s.price)    as movie_sum_profit
from movie m
         inner join ticket t on m.ID = t.movie_id
         inner join screening s on t.screening_id = s.id
group by m.ID
order by sum(s.price) DESC;

