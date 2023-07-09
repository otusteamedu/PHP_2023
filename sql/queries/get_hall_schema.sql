DROP FUNCTION get_hall_schema(integer);
CREATE OR REPLACE FUNCTION get_hall_schema(_session_id INT)
    RETURNS TABLE(row_number INT, place INT, place_taken BOOLEAN) AS
$$
BEGIN
    RETURN QUERY
        SELECT p.row_number, p.place,
               CASE
                   WHEN t.id IS NULL THEN FALSE
                   ELSE TRUE
                   END AS place_taken
        FROM places p
                 LEFT JOIN session_place_price spp ON spp.place_id = p.id
                 LEFT JOIN tickets t ON t.session_place_price_id = spp.id
        WHERE spp.session_id = _session_id
        ORDER BY p.row_number, p.place;
    RETURN;
END;
$$
    LANGUAGE plpgsql;

SELECT * FROM get_hall_schema(1);