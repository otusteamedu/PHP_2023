DROP FUNCTION IF EXISTS get_session_price_range(integer);
CREATE FUNCTION get_session_price_range(_session_id INT) RETURNS TABLE (min_price DECIMAL(10,2), max_price DECIMAL(10,2)) AS
$$
BEGIN
RETURN QUERY
SELECT MIN(prices.price), MAX(prices.price)
FROM session_place_price
INNER JOIN prices ON prices.id = session_place_price.price_id
WHERE session_place_price.session_id = _session_id;
END;
$$
LANGUAGE plpgsql;

SELECT get_session_price_range(1)