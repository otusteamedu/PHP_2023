DROP TABLE IF EXISTS cities;
DROP TABLE IF EXISTS states;
DROP TABLE IF EXISTS countries;
DROP TABLE IF EXISTS subregions;
DROP TABLE IF EXISTS regions;

CREATE TABLE regions
(
    id           SERIAL PRIMARY KEY,
    name         VARCHAR(100) NOT NULL,
    translations TEXT,
    created_at   TIMESTAMP,
    updated_at   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    flag         SMALLINT     NOT NULL DEFAULT 1,
    wikiDataId   VARCHAR(255)
);

CREATE TABLE subregions
(
    id           SERIAL PRIMARY KEY,
    name         VARCHAR(100) NOT NULL,
    translations TEXT,
    region_id    INTEGER      NOT NULL,
    created_at   TIMESTAMP,
    updated_at   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    flag         SMALLINT     NOT NULL DEFAULT 1,
    wikiDataId   VARCHAR(255),
    CONSTRAINT subregion_continent_final FOREIGN KEY (region_id) REFERENCES regions (id)
);

CREATE TABLE countries
(
    id              SERIAL PRIMARY KEY,
    name            VARCHAR(100) NOT NULL,
    iso3            CHAR(3),
    numeric_code    CHAR(3),
    iso2            CHAR(2),
    phonecode       VARCHAR(255),
    capital         VARCHAR(255),
    currency        VARCHAR(255),
    currency_name   VARCHAR(255),
    currency_symbol VARCHAR(255),
    tld             VARCHAR(255),
    native          VARCHAR(255),
    region          VARCHAR(255),
    region_id       INTEGER,
    subregion       VARCHAR(255),
    subregion_id    INTEGER,
    nationality     VARCHAR(255),
    timezones       TEXT,
    translations    TEXT,
    latitude        DECIMAL(10, 8),
    longitude       DECIMAL(11, 8),
    emoji           VARCHAR(191),
    emojiU          VARCHAR(191),
    created_at      TIMESTAMP,
    updated_at      TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    flag            SMALLINT     NOT NULL DEFAULT 1,
    wikiDataId      VARCHAR(255),
    CONSTRAINT country_continent_final FOREIGN KEY (region_id) REFERENCES regions (id),
    CONSTRAINT country_subregion_final FOREIGN KEY (subregion_id) REFERENCES subregions (id)
);

CREATE TABLE states
(
    id           SERIAL PRIMARY KEY,
    name         VARCHAR(255) NOT NULL,
    country_id   INTEGER      NOT NULL,
    country_code CHAR(2)      NOT NULL,
    fips_code    VARCHAR(255),
    iso2         VARCHAR(255),
    type         VARCHAR(191),
    latitude     DECIMAL(10, 8),
    longitude    DECIMAL(11, 8),
    created_at   TIMESTAMP,
    updated_at   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    flag         SMALLINT     NOT NULL DEFAULT 1,
    wikiDataId   VARCHAR(255),
    CONSTRAINT country_region_final FOREIGN KEY (country_id) REFERENCES countries (id)
);

CREATE TABLE cities
(
    id           SERIAL PRIMARY KEY,
    name         VARCHAR(255)   NOT NULL,
    state_id     INTEGER        NOT NULL,
    state_code   VARCHAR(255)   NOT NULL,
    country_id   INTEGER        NOT NULL,
    country_code CHAR(2)        NOT NULL,
    latitude     DECIMAL(10, 8) NOT NULL,
    longitude    DECIMAL(11, 8) NOT NULL,
    created_at   TIMESTAMP      NOT NULL DEFAULT '2014-01-01 06:31:01',
    updated_at   TIMESTAMP      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    flag         SMALLINT       NOT NULL DEFAULT 1,
    wikiDataId   VARCHAR(255),
    CONSTRAINT cities_state_fk FOREIGN KEY (state_id) REFERENCES states (id),
    CONSTRAINT cities_country_fk FOREIGN KEY (country_id) REFERENCES countries (id)
);