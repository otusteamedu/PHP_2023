CREATE OR REPLACE FUNCTION random_date(start_date TIMESTAMP, end_date TIMESTAMP)
    RETURNS TIMESTAMP AS $$
BEGIN
    RETURN start_date + (random() * (end_date - start_date));
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION random_int(max_int INT)
    RETURNS INT AS $$
BEGIN
    RETURN floor(random() * max_int) + 1;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION random_decimal(min DECIMAL, max DECIMAL)
    RETURNS DECIMAL AS $$
BEGIN
    RETURN min + (random() * (max - min));
END;
$$ LANGUAGE plpgsql;
