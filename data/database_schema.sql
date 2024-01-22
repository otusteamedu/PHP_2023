--film
CREATE TABLE IF NOT EXISTS film (
    id          bigint PRIMARY KEY,
    name        varchar(255) NOT NULL,
    description varchar(255)
);


--attribute_type
CREATE TABLE IF NOT EXISTS attribute_type (
    id          smallint PRIMARY KEY,
    type        varchar(100) NOT NULL,
    description varchar(255) NOT NULL
);


--attribute
CREATE TABLE IF NOT EXISTS attribute (
    id             bigint PRIMARY KEY,
    attribute_type smallint     NOT NULL,
    name           varchar(150) NOT NULL,
    FOREIGN KEY (attribute_type) REFERENCES attribute_type(id)
);


--attribute_value
CREATE TABLE IF NOT EXISTS attribute_value (
    id             bigint PRIMARY KEY,
    entity_name    varchar(200) NOT NULL,
    entity_id      bigint       NOT NULL,
    attribute      bigint       NOT NULL,
    value_text     varchar(3000),
    value_bool     boolean,
    value_datetime timestamptz,
    value_int      bigint,
    value_float    numeric(30, 6),
    FOREIGN KEY (attribute) REFERENCES attribute(id)
);
