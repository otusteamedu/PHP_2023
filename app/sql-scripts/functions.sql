CREATE OR REPLACE FUNCTION generate_random_date(start_date DATE, end_date DATE) RETURNS DATE AS
$$
DECLARE
    random_days INTEGER;
BEGIN
    random_days := (SELECT random() * (end_date - start_date) + 1);
    RETURN start_date + random_days;
END;
$$ LANGUAGE plpgsql;