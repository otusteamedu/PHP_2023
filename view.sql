CREATE OR REPLACE VIEW movie_tasks AS
SELECT movie.name AS movie, q1.name AS task_now, q2.name AS task_in_20_days
FROM movie
         LEFT JOIN
     (SELECT m.id, a.name
      FROM movie m,
           attribute a,
           movie_attribute_value av
      WHERE m.id = av.movie_id
        AND a.id = av.attribute_id
        AND av.value_datetime <= NOW()) q1
     ON (movie.id = q1.id)
         LEFT JOIN (SELECT m.id, a.name
                    FROM movie m,
                         attribute a,
                         movie_attribute_value av
                    WHERE m.id = av.movie_id
                      AND a.id = av.attribute_id
                      AND av.value_datetime >= NOW() + 20) q2
                   ON (movie.id = q2.id);


CREATE OR REPLACE VIEW marketing AS
SELECT m.name  AS movie_name,
       t.name  AS attribute_type_name,
       a.name  AS attribute_name,
       CASE
           WHEN t.type = 'integer'
               THEN av.value_integer
           WHEN t.type = 'boolean'
               THEN av.value_boolean
           WHEN t.type = 'float'
               THEN av.value_float
           WHEN t.type = 'datetime'
               THEN av.value_datetime
           ELSE av.value_text
           END AS value
FROM movie m,
     attribute_type t,
     attribute a,
     movie_attribute_value av
WHERE m.id = av.movie_id
  AND t.id = a.attribute_type_id
  AND av.attribute_id = a.id;