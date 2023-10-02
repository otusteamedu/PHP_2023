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

-- #############################################################################

CREATE TABLE movie
(
    ID         SERIAL PRIMARY KEY,
    title      VARCHAR(255),
    created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT NOW()
);

-- #############################################################################

CREATE TABLE movie_attr_type
(
    ID      SERIAL PRIMARY KEY,
    name    VARCHAR(60),
    comment TEXT
);

-- #############################################################################

CREATE TABLE movie_attr
(
    ID                 SERIAL PRIMARY KEY,
    movie_attr_type_id INT REFERENCES movie_attr_type (ID),
    name               VARCHAR(60)
);

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

-- #############################################################################

CREATE TABLE ticket
(
    ID            SERIAL PRIMARY KEY,
    screening_id INT REFERENCES screening (ID),
    room_id      INT REFERENCES room (ID),
    movie_id     INT REFERENCES movie (ID),
    seat         SMALLINT NOT NULL,
    row          SMALLINT NOT NULL,
    show_date    DATE NOT NULL,
    sale_date    DATE DEFAULT now()
);

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
SELECT m.title      AS movie_title,
       ma.name      AS movie_attr_name,
       mav.val_date AS movie_attr_value
FROM movie m
         INNER JOIN movie_attr_value mav ON m.ID = mav.movie_id
         INNER JOIN movie_attr ma ON mav.movie_attr_id = ma.ID
         INNER JOIN movie_attr_type mat ON ma.movie_attr_type_id = mat.ID
WHERE mat.name = 'date'
  AND mav.val_date = CURRENT_DATE;

-- #############################################################################

CREATE VIEW get_future_service_data_movies AS
SELECT m.title      AS movie_title,
       ma.name      AS movie_attr_name,
       mav.val_date AS movie_attr_value
FROM movie m
         INNER JOIN movie_attr_value mav ON m.ID = mav.movie_id
         INNER JOIN movie_attr ma ON mav.movie_attr_id = ma.ID
         INNER JOIN movie_attr_type mat ON ma.movie_attr_type_id = mat.ID
WHERE mat.name = 'date'
  AND mav.val_date BETWEEN CURRENT_DATE + INTERVAL '20 days' AND CURRENT_DATE + INTERVAL '25 days';

-- #############################################################################

CREATE INDEX idx_movie_attr_type_name ON movie_attr_type (name);
CREATE INDEX idx_val_date ON movie_attr_value (val_date);
CREATE INDEX idx_movie_attr_type_id ON movie_attr (movie_attr_type_id);
CREATE INDEX idx_movie_id ON movie_attr_value (movie_id);
CREATE UNIQUE INDEX idx_screening_movie_room ON ticket (show_date, movie_id, screening_id, room_id, seat, row);
CREATE INDEX idx_screening_id ON ticket (screening_id);

-- #############################################################################

CREATE TABLE queries_result
(
    query                                       TEXT NOT NULL,
    query_plan_before_optimization_10000_rows  TEXT NOT NULL,
    query_plan_before_optimization_1000000_rows TEXT NOT NULL,
    query_plan_after_optimization_1000000_rows  TEXT NOT NULL,
    description_optimization                    TEXT NOT NULL
)

