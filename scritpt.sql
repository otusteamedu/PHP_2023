SELECT
    m.movie_id,
    m.name AS movie_name,
    m.description,
    m.release_date,
    m.duration,
    at.type_name AS attribute_type,
    a.name AS attribute_name,
    a.data_type,
    av.value
FROM
    movies m
        LEFT JOIN attribute_values av ON m.movie_id = av.movie_id
        LEFT JOIN attributes a ON av.attribute_id = a.attribute_id
        LEFT JOIN attribute_types at ON a.type_id = at.type_id
ORDER BY
    m.movie_id,
    a.attribute_id;
