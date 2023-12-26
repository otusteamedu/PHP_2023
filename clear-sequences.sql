DROP SEQUENCE IF EXISTS attribute_types_type_id_seq CASCADE;
DROP SEQUENCE IF EXISTS attribute_values_value_id_seq CASCADE;
DROP SEQUENCE IF EXISTS attributes_attribute_id_seq CASCADE;
DROP SEQUENCE IF EXISTS movies_movie_id_seq CASCADE;

CREATE SEQUENCE attribute_types_type_id_seq START WITH 1;
CREATE SEQUENCE attribute_values_value_id_seq START WITH 1;
CREATE SEQUENCE attributes_attribute_id_seq START WITH 1;
CREATE SEQUENCE movies_movie_id_seq START WITH 1;

ALTER TABLE attribute_types ALTER COLUMN type_id SET DEFAULT nextval('attribute_types_type_id_seq');

ALTER TABLE  attribute_values ALTER COLUMN value_id SET DEFAULT nextval('attribute_values_value_id_seq');

ALTER TABLE attributes ALTER COLUMN attribute_id SET DEFAULT nextval('attributes_attribute_id_seq');

ALTER TABLE movies ALTER COLUMN movie_id SET DEFAULT nextval('movies_movie_id_seq');