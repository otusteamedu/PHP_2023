CREATE DATABASE IF NOT EXISTS `homework`;

# set collation;

CREATE TABLE IF NOT EXISTS homework.halls
(
    id              INT UNSIGNED AUTO_INCREMENT,
    amount_of_seats TINYINT UNSIGNED NOT NULL,
    is_available    TINYINT UNSIGNED NOT NULL DEFAULT 1,
    created_at      DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS homework.seats_priorities
(
    priority TINYINT UNSIGNED,
    PRIMARY KEY (priority)
);

CREATE TABLE IF NOT EXISTS homework.halls_seats
(
    id              INT UNSIGNED AUTO_INCREMENT,
    hall_id         INT UNSIGNED     NOT NULL,
    start_from_seat TINYINT UNSIGNED NOT NULL,
    priority_id     TINYINT UNSIGNED,
    created_at      DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (hall_id) REFERENCES homework.halls (id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (priority_id) REFERENCES homework.seats_priorities (priority) ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS homework.age_restrictions
(
    id      TINYINT UNSIGNED AUTO_INCREMENT,
    min_age TINYINT UNSIGNED NOT NULL COMMENT '0+, 12+ etc.',
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS homework.films
(
    id                 INT UNSIGNED AUTO_INCREMENT,
    age_restriction_id TINYINT UNSIGNED,
    name               VARCHAR(255)      NOT NULL,
    duration           SMALLINT UNSIGNED NOT NULL,
    poster_image_path  varchar(255)               DEFAULT '',
    description        varchar(255)      NOT NULL DEFAULT '',
    actors             varchar(255)               DEFAULT '',
    country            varchar(255)               DEFAULT '',
    created_at         DATETIME          NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at         DATETIME          NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (age_restriction_id) REFERENCES homework.age_restrictions (id) ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS homework.films_types
(
    id   TINYINT UNSIGNED AUTO_INCREMENT,
    type VARCHAR(20) NOT NULL COMMENT 'imax, 2d, 3d etc.',
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS homework.films_types_to_films
(
    film_id      INT UNSIGNED,
    film_type_id TINYINT UNSIGNED,
    created_at   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (film_id, film_type_id),
    FOREIGN KEY (film_id) REFERENCES homework.films (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS homework.genres
(
    id   TINYINT UNSIGNED AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL COMMENT 'horror, comedy, action etc.',
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS homework.films_genres
(
    film_id    INT UNSIGNED,
    genre_id   TINYINT UNSIGNED,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (film_id, genre_id),
    FOREIGN KEY (film_id) REFERENCES homework.films (id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (genre_id) REFERENCES homework.genres (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS homework.screenings
(
    id           INT UNSIGNED AUTO_INCREMENT,
    hall_id      INT UNSIGNED     ,
    film_id      INT UNSIGNED ,
    film_type_id TINYINT UNSIGNED     ,
    base_price   DECIMAL(6, 2)    NOT NULL,
    start_at     DATETIME         NOT NULL,
    created_at   DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at   DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (hall_id) REFERENCES homework.halls (id) ON UPDATE CASCADE ON DELETE SET NULL,
    FOREIGN KEY (film_id) REFERENCES homework.films (id) ON UPDATE CASCADE ON DELETE SET NULL,
    FOREIGN KEY (film_type_id) REFERENCES homework.films_types (id) ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS homework.visitors
(
    id               INT UNSIGNED AUTO_INCREMENT,
    screening_id     INT UNSIGNED,
    cashless_payment TINYINT UNSIGNED NOT NULL DEFAULT 0,
    price            DECIMAL(6, 2)    NOT NULL,
    discount_percent TINYINT UNSIGNED NOT NULL DEFAULT 0,
    created_at       DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at       DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (screening_id) REFERENCES homework.screenings (id) ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS homework.tickets
(
    id         INT UNSIGNED AUTO_INCREMENT,
    visitor_id INT UNSIGNED,
    seat       TINYINT UNSIGNED NOT NULL,
    is_child   TINYINT UNSIGNED NOT NULL DEFAULT 0,
    created_at DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (visitor_id) REFERENCES homework.visitors (id) ON UPDATE CASCADE ON DELETE SET NULL
)