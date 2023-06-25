
DROP TABLE IF EXISTS "attribute";
CREATE TABLE "public"."attribute" (
                                      "id" serial NOT NULL,
                                      "name" character varying(255) NOT NULL,
                                      "attribute_type_id" bigint NOT NULL,
                                      CONSTRAINT "attribute_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "attribute" ("id", "name", "attribute_type_id") VALUES
                                                                (1,	'рецензии критиков',	1),
                                                                (2,	'отзыв неизвестной киноакадемии',	1),
                                                                (3,	'оскар',	2),
                                                                (4,	'ника',	2),
                                                                (5,	'мировая премьера',	3),
                                                                (6,	'премьера в РФ',	3),
                                                                (7,	'дата начала продажи билетов',	4),
                                                                (8,	'начало запуска рекламы на ТВ',	4);

DROP TABLE IF EXISTS "attribute_type";
CREATE TABLE "public"."attribute_type" (
                                           "id" serial NOT NULL,
                                           "name" character varying(255) NOT NULL,
                                           "data_id" bigint NOT NULL,
                                           CONSTRAINT "attribute_type_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "attribute_type" ("id", "name", "data_id") VALUES
                                                           (1,	'рецензии',	6),
                                                           (2,	'премия',	1),
                                                           (3,	'важные даты',	3),
                                                           (4,	'служебные даты',	3);

DROP TABLE IF EXISTS "attribute_value";
CREATE TABLE "public"."attribute_value" (
                                            "id" serial NOT NULL,
                                            "attribute_id" bigint NOT NULL,
                                            "movie_id" bigint NOT NULL,
                                            "text_value" text,
                                            "char_value" character varying(255),
                                            "int_value" integer,
                                            "numeric_value" numeric(10,2),
                                            "bool_value" boolean,
                                            "date_value" date,
                                            CONSTRAINT "attribute_value_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

CREATE INDEX "attribute_value_movie_id_attribute_id_idx" ON "public"."attribute_value" USING btree ("movie_id", "attribute_id");

INSERT INTO "attribute_value" ("id", "attribute_id", "movie_id", "text_value", "char_value", "int_value", "numeric_value", "bool_value", "date_value") VALUES
                                                                                                                                                           (2,	1,	1,	'рецензии критиков',	NULL,	NULL,	NULL,	NULL,	NULL),
                                                                                                                                                           (3,	2,	1,	'отзыв неизвестной киноакадемии',	NULL,	NULL,	NULL,	NULL,	NULL),
                                                                                                                                                           (4,	3,	1,	NULL,	NULL,	NULL,	NULL,	't',	NULL),
                                                                                                                                                           (5,	4,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
                                                                                                                                                           (11,	1,	2,	'рецензии критиков',	NULL,	NULL,	NULL,	NULL,	NULL),
                                                                                                                                                           (12,	2,	2,	'отзыв неизвестной киноакадемии',	NULL,	NULL,	NULL,	NULL,	NULL),
                                                                                                                                                           (13,	3,	2,	NULL,	NULL,	NULL,	NULL,	't',	NULL),
                                                                                                                                                           (15,	5,	2,	NULL,	NULL,	NULL,	NULL,	NULL,	'2023-01-24'),
                                                                                                                                                           (16,	6,	2,	NULL,	NULL,	NULL,	NULL,	NULL,	'2023-02-23'),
                                                                                                                                                           (19,	1,	3,	'рецензии критиков',	NULL,	NULL,	NULL,	NULL,	NULL),
                                                                                                                                                           (20,	2,	3,	'отзыв неизвестной киноакадемии',	NULL,	NULL,	NULL,	NULL,	NULL),
                                                                                                                                                           (21,	3,	3,	NULL,	NULL,	NULL,	NULL,	't',	NULL),
                                                                                                                                                           (22,	4,	3,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
                                                                                                                                                           (23,	5,	3,	NULL,	NULL,	NULL,	NULL,	NULL,	'2023-01-24'),
                                                                                                                                                           (24,	6,	3,	NULL,	NULL,	NULL,	NULL,	NULL,	'2023-02-23'),
                                                                                                                                                           (14,	4,	2,	NULL,	NULL,	NULL,	NULL,	't',	NULL),
                                                                                                                                                           (17,	7,	2,	NULL,	NULL,	NULL,	NULL,	NULL,	((now())::date + 1)),
                                                                                                                                                           (25,	7,	3,	NULL,	NULL,	NULL,	NULL,	NULL,	((now())::date +3 )),
                                                                                                                                                           (10,	8,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	((now())::date + 21)),
                                                                                                                                                           (18,	8,	2,	NULL,	NULL,	NULL,	NULL,	NULL,	((now())::date + 22)),
                                                                                                                                                           (26,	8,	3,	NULL,	NULL,	NULL,	NULL,	NULL,	((now())::date + 23)),
                                                                                                                                                           (6,	5,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	((now())::date + 2 )),
                                                                                                                                                           (7,	6,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	((now())::date + 4)),
                                                                                                                                                           (8,	7,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	((now())::date + 10 ));

DROP TABLE IF EXISTS "date_type";
CREATE TABLE "public"."date_type" (
                                      "id" serial NOT NULL,
                                      "name" character varying(255) NOT NULL,
                                      CONSTRAINT "date_type_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "date_type" ("id", "name") VALUES
                                           (1,	'BOOL'),
                                           (2,	'CHAR255'),
                                           (3,	'DATE'),
                                           (4,	'INT'),
                                           (5,	'NUMERIC'),
                                           (6,	'TEXT');

DROP TABLE IF EXISTS "movies";
CREATE TABLE "public"."movies" (
                                   "id" serial NOT NULL,
                                   "title" character varying(255) NOT NULL,
                                   "description" text,
                                   "duration" integer NOT NULL,
                                   "price" numeric(10,2) NOT NULL,
                                   CONSTRAINT "movies_pkey1" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "movies" ("id", "title", "description", "duration", "price") VALUES
                                                                             (1,	'Фильм 1 ',	'Описание фильма 1',	240,	100.10),
                                                                             (3,	'Фильм 3',	'описание фильма 3',	360,	500.12),
                                                                             (2,	'Фильм 2',	'Описание фильма 2',	125,	123.05);

DROP VIEW IF EXISTS "promo";
CREATE TABLE "promo" ("title" character varying(255), "attribute" character varying(255), "attributeValue" character varying);


DROP VIEW IF EXISTS "service_task";
CREATE TABLE "service_task" ("title" character varying(255), "currenttasks" text, "futuretasks" text);


ALTER TABLE ONLY "public"."attribute" ADD CONSTRAINT "attribute_attribute_id_fkey" FOREIGN KEY (attribute_type_id) REFERENCES attribute_type(id) NOT DEFERRABLE;

ALTER TABLE ONLY "public"."attribute_type" ADD CONSTRAINT "attribute_type_data_id_fkey" FOREIGN KEY (data_id) REFERENCES date_type(id) NOT DEFERRABLE;

ALTER TABLE ONLY "public"."attribute_value" ADD CONSTRAINT "attribute_value_attribute_id_fkey" FOREIGN KEY (attribute_id) REFERENCES attribute(id) NOT DEFERRABLE;
ALTER TABLE ONLY "public"."attribute_value" ADD CONSTRAINT "attribute_value_movie_id_fkey" FOREIGN KEY (movie_id) REFERENCES movies(id) NOT DEFERRABLE;

DROP TABLE IF EXISTS "promo";
CREATE VIEW "promo" AS SELECT movies.title,
                              attribute.name AS attribute,
                              CASE
                                  WHEN ((date_type.name)::text = 'BOOL'::text) THEN (attribute_value.bool_value)::character varying
            WHEN ((date_type.name)::text = 'CHAR255'::text) THEN attribute_value.char_value
            WHEN ((date_type.name)::text = 'DATE'::text) THEN (attribute_value.date_value)::character varying
            WHEN ((date_type.name)::text = 'INT'::text) THEN (attribute_value.int_value)::character varying
            WHEN ((date_type.name)::text = 'NUMERIC'::text) THEN (attribute_value.numeric_value)::character varying
            WHEN ((date_type.name)::text = 'TEXT'::text) THEN (attribute_value.text_value)::character varying
            ELSE NULL::character varying
END AS "attributeValue"
   FROM ((((movies
     LEFT JOIN attribute_value ON ((movies.id = attribute_value.movie_id)))
     LEFT JOIN attribute ON ((attribute.id = attribute_value.attribute_id)))
     LEFT JOIN attribute_type ON ((attribute.attribute_type_id = attribute_type.id)))
     LEFT JOIN date_type ON ((date_type.id = attribute_type.data_id)))
  WHERE (attribute_type.id <> 4)
  ORDER BY movies.title;

DROP TABLE IF EXISTS "service_task";
CREATE VIEW "service_task" AS WITH futuret_tasks AS (
    SELECT attribute_value.movie_id,
           attribute.name AS nametask,
           attribute_value.date_value AS datetask
    FROM ((attribute_value
        JOIN attribute ON ((attribute_value.attribute_id = attribute.id)))
        JOIN attribute_type ON ((attribute_type.id = attribute.attribute_type_id)))
    WHERE ((attribute_type.id = 4) AND (attribute_value.date_value >= ((now())::date + 20)))
    ), current_tasks AS (
         SELECT attribute_value.movie_id,
            attribute.name AS nametask,
            attribute_value.date_value AS datetask
           FROM ((attribute_value
             JOIN attribute ON ((attribute_value.attribute_id = attribute.id)))
             JOIN attribute_type ON ((attribute_type.id = attribute.attribute_type_id)))
          WHERE ((attribute_type.id = 4) AND (attribute_value.date_value >= CURRENT_DATE) AND (attribute_value.date_value < ((now())::date + 20)))
        )
SELECT movies.title,
       concat(current_tasks.nametask, ' ', current_tasks.datetask) AS currenttasks,
       concat(futuret_tasks.nametask, ' ', futuret_tasks.datetask) AS futuretasks
FROM ((movies
    LEFT JOIN current_tasks ON ((movies.id = current_tasks.movie_id)))
    LEFT JOIN futuret_tasks ON ((movies.id = futuret_tasks.movie_id)));
