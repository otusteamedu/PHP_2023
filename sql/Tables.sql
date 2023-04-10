CREATE TABLE "movies" (
    "id" BIGINT NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    "description" TEXT DEFAULT NULL,
    "duration" INT DEFAULT NULL,
    PRIMARY KEY ("id")
);

CREATE TABLE "attribute_types" (
    "id" BIGINT NOT NULL,
    "key" VARCHAR(255) NOT NULL,
    "type" VARCHAR(10) NOT NULL,
    PRIMARY KEY ("id")
);

CREATE TABLE "attributes" (
    "id" BIGINT NOT NULL,
    "type_id" BIGINT NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    PRIMARY KEY ("id")
);

CREATE TABLE "movie_attribute_values" (
    "id" BIGINT NOT NULL,
    "movie_id" BIGINT NOT NULL,
    "attribute_id" BIGINT NOT NULL,
    "value_boolean" BOOLEAN DEFAULT NULL,
    "value_int" INT DEFAULT NULL,
    "value_float" NUMERIC(10, 4) DEFAULT NULL,
    "value_string" VARCHAR(255) DEFAULT NULL,
    "value_text" TEXT DEFAULT NULL,
    "value_date" TIMESTAMPTZ DEFAULT NULL,
    PRIMARY KEY ("id")
);

ALTER TABLE "attributes" ADD FOREIGN KEY ("type_id") REFERENCES "attribute_types" ("id");

ALTER TABLE "movie_attribute_values" ADD FOREIGN KEY ("movie_id") REFERENCES "movies" ("id");

ALTER TABLE "movie_attribute_values" ADD FOREIGN KEY ("attribute_id") REFERENCES "attributes" ("id");

ALTER TABLE "attribute_types" ADD CONSTRAINT "attribute_types_unique_key" UNIQUE ("key");

CREATE SEQUENCE "movies_id_seq" INCREMENT BY 1 MINVALUE 1 START 1;

CREATE SEQUENCE "attribute_types_id_seq" INCREMENT BY 1 MINVALUE 1 START 1;

CREATE SEQUENCE "attributes_id_seq" INCREMENT BY 1 MINVALUE 1 START 1;

CREATE SEQUENCE "movie_attribute_values_id_seq" INCREMENT BY 1 MINVALUE 1 START 1;
