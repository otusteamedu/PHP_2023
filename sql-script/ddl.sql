
-- "attribute" definition

CREATE TABLE "attribute" (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    attribute_type_id INTEGER NOT NULL
);

CREATE INDEX attribute_id_IDX ON "attribute" (id);
CREATE INDEX attribute_attribute_type_id_IDX ON "attribute" (attribute_type_id);



-- movie definition

CREATE TABLE movie (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL
);

CREATE INDEX movie_id_IDX ON movie (id);


-- "type" definition

CREATE TABLE "type" (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL
);

CREATE INDEX type_id_IDX ON "type" (id);


-- type_of_attribute definition

CREATE TABLE type_of_attribute (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    native_type_id INTEGER NOT NULL
);

CREATE INDEX type_of_attribute_id_IDX ON type_of_attribute (id);
CREATE INDEX type_of_attribute_native_type_id_IDX ON type_of_attribute (native_type_id);


-- value_for_attribute definition

CREATE TABLE value_for_attribute (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    value TEXT NOT NULL,
    movie_id INTEGER NOT NULL,
    attribute_id INTEGER NOT NULL
);

CREATE INDEX value_for_attribute_id_IDX ON value_for_attribute (id);
CREATE INDEX value_for_attribute_movie_id_IDX ON value_for_attribute (movie_id);
CREATE INDEX value_for_attribute_attribute_id_IDX ON value_for_attribute (attribute_id);
CREATE UNIQUE INDEX value_for_attribute_movie_id_and_attribute_id_uniq_IDX ON value_for_attribute (movie_id,attribute_id);
