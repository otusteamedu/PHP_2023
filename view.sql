-- Create view for service data for today and 20 days ahead
CREATE VIEW service_data_view AS
SELECT
  m.title AS movie,
  v1.string_value AS today_tasks,
  v2.string_value AS tasks_in_20_days
FROM
  movies m
LEFT JOIN
  values v1 ON v1.movie_id = m.id
  AND v1.attribute_type_id = (SELECT id FROM attribute_types WHERE name = 'textual values')
  AND v1.attribute_id = (SELECT id FROM attributes WHERE name = 'today_tasks')
LEFT JOIN
  values v2 ON v2.movie_id = m.id
  AND v2.attribute_type_id = (SELECT id FROM attribute_types WHERE name = 'textual values')
  AND v2.attribute_id = (SELECT id FROM attributes WHERE name = 'tasks_in_20_days');
