INSERT INTO movies (name, description, release_date, duration)
VALUES
    ('Epic Adventure', 'An epic journey across uncharted lands.', '2023-01-01', 120),
    ('Mystery in the Night', 'A thrilling mystery set in a shadowy city.', '2023-02-15', 95),
    ('Comedy Central', 'A hilarious tale of unexpected friendship.', '2023-03-10', 110);

INSERT INTO attribute_types (type_name)
VALUES
    ('Review'),
    ('Award'),
    ('Release Date');

INSERT INTO attributes (type_id, name, data_type)
VALUES
    (1, 'Critic Review', 'text'),
    (2, 'Oscar', 'boolean'),
    (3, 'World Premiere', 'date');

INSERT INTO attribute_values (movie_id, attribute_id, text_value, float_value, int_value, date_value, json_value)
VALUES
    (1, 1, 'A breathtaking adventure that keeps you on the edge of your seat.', NULL, NULL, NULL, NULL),
    (2, 2, NULL, 22.3, NULL, NULL, NULL),
    (3, 3, NULL, NULL, NULL, '2023-01-01', NULL);