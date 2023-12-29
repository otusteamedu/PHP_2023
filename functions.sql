CREATE OR REPLACE FUNCTION
    random_in_range(min INTEGER, max INTEGER) RETURNS INTEGER
AS $$
SELECT floor((min + (max - min + 1) * random()))::INTEGER;
$$ LANGUAGE SQL;

CREATE OR REPLACE FUNCTION
    random_date(start_date DATE, end_date DATE) RETURNS DATE
AS $$
SELECT random() * (start_date::timestamp - end_date::timestamp) + end_date::timestamp;
$$ LANGUAGE SQL;
