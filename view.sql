-- Create view for service data for today and 20 days ahead
CREATE VIEW service_data AS
SELECT
  movies.title AS movie,
  service_dates_today.value AS tasks_today,
  service_dates_20_days.value AS tasks_20_days
FROM
  movies
LEFT JOIN
  values AS service_dates_today ON (
    service_dates_today.movie_id = movies.id
    AND service_dates_today.attribute_id = (
      SELECT id FROM attributes WHERE name = 'service dates'
    )
    AND service_dates_today.attribute_type_id = (
      SELECT id FROM attribute_types WHERE name = 'date type'
    )
    AND service_dates_today.value = CURRENT_DATE
  )
LEFT JOIN
  values AS service_dates_20_days ON (
    service_dates_20_days.movie_id = movies.id
    AND service_dates_20_days.attribute_id = (
      SELECT id FROM attributes WHERE name = 'service dates'
    )
    AND service_dates_20_days.attribute_type_id = (
      SELECT id FROM attribute_types WHERE name = 'date type'
    )
    AND service_dates_20_days.value = CURRENT_DATE + INTERVAL '20 days'
  );

-- Create view for marketing data
CREATE VIEW marketing_data AS
SELECT
  movies.title AS movie,
  attribute_types.name AS attribute_type,
  attributes.name AS attribute,
  values.value
FROM
  values
JOIN
  movies ON values.movie_id = movies.id
JOIN
  attributes ON values.attribute_id = attributes.id
JOIN
  attribute_types ON values.attribute_type_id = attribute_types.id;
