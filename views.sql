-- 1. Сервисные задачи
CREATE VIEW service_tasks AS
    WITH tasks AS (
        SELECT
            movies.id as movie_id,
            (
                SELECT
                    STRING_AGG(a.title, '; ')
                FROM values v
                    LEFT JOIN attributes a ON a.id = v.attribute_id
                    LEFT JOIN attribute_types t ON t.id = a.attribute_type_id
                WHERE
                    v.movie_id = movies.id
                    AND v.date = CURRENT_DATE
                    AND a.parent_id = 10
            ) AS today,
            (
                SELECT
                    STRING_AGG(a.title, '; ')
                FROM values v
                    LEFT JOIN attributes a ON a.id = v.attribute_id
                    LEFT JOIN attribute_types t ON t.id = a.attribute_type_id
                WHERE
                    v.movie_id = movies.id
                    AND v.date = CURRENT_DATE + INTERVAL '20 DAYS'
                    AND a.parent_id = 10
            ) AS future
        FROM movies
    )
    SELECT
        m.title, t.today, t.future
    FROM
        movies m
        INNER JOIN tasks t ON t.movie_id = m.id
    WHERE
        t.today IS NOT NULL
        OR t.future IS NOT NULL
    ORDER BY
        m.title DESC;

-- 2. Атрибуты фильмов для маркетинга
CREATE VIEW movie_attributes_for_marketing
        (movie_title ,attribute_type, attribute_title, value) AS
    SELECT
        m.title, t.type, a.title,
        CASE
            WHEN t.type = 'TEXT' THEN v.text
            WHEN t.type = 'BOOL' THEN
                CASE
                    WHEN v.bool = true THEN 'есть'
                    WHEN v.bool = false THEN 'нет'
                END
            WHEN t.type= 'DATE' THEN (v.date)::text
        END value
    FROM  values v
        JOIN attributes a on a.id = v.attribute_id
        JOIN attribute_types t on t.id = a.attribute_type_id
        JOIN movies m on m.id =  v.movie_id
    ORDER BY
        t.type, m.title, a.title;
