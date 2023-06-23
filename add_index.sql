
-- composite index

CREATE INDEX entity_idx ON values_ USING btree (movie_id, attribute_id);

-- standart index

CREATE INDEX value_date_idx ON values_ USING btree (v_date);