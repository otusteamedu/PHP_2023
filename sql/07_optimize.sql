CREATE INDEX schedules_datetime_index
    ON schedules USING btree (datetime);

CREATE INDEX tickets_created_at_index
    ON tickets USING btree (created_at);

CREATE INDEX tickets_place_id_index
    ON tickets USING btree (place_id);

CREATE INDEX places_cinema_hall_id_index
    ON places USING btree (cinema_hall_id);

