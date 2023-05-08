CREATE INDEX schedules_datetime_index
    ON schedules USING btree (datetime);

CREATE INDEX tickets_movie_id_and_place_id_index
    ON tickets USING btree (movie_id, place_id);

CREATE INDEX places_cinema_hall_id_index
    ON places USING btree (cinema_hall_id);

CREATE TABLE "film_box_office" (
    "id" BIGINT NOT NULL,
    "movie_id" BIGINT NOT NULL,
    "day" DATE NOT NULL,
    "tickets_count" INT NOT NULL,
    "amount" NUMERIC(14, 2) DEFAULT NULL,
    PRIMARY KEY ("id")
);

CREATE SEQUENCE "film_box_offices_id_seq" INCREMENT BY 1 MINVALUE 1 START 1;

CREATE INDEX film_box_office_day_index
    ON film_box_office USING btree (day);

INSERT INTO "film_box_office" (id, movie_id, day, tickets_count, amount)
SELECT nextval('film_box_offices_id_seq'),
       movie_id,
       created_at::date as day,
       count(created_at) as tickets_count,
       sum(amount) as amount
FROM tickets
GROUP BY movie_id, created_at::date;
