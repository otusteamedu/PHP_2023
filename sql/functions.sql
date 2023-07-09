CREATE OR REPLACE FUNCTION random_string(length INTEGER) RETURNS TEXT AS
$$
DECLARE
chars TEXT[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
    result TEXT := '';
    i INTEGER := 0;
BEGIN
    IF length < 0 THEN
        RAISE EXCEPTION 'Given length cannot be less than 0';
END IF;

FOR i IN 1..length LOOP
            result := result || chars[1 + floor(random() * (array_length(chars, 1) - 1))::int];
END LOOP;

RETURN result;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION random_date(start_date DATE, end_date DATE) RETURNS DATE AS
$$
DECLARE
random_day DATE;
BEGIN
    IF start_date > end_date THEN
        RAISE EXCEPTION 'Start date cannot be greater than end date';
END IF;

    random_day := start_date + (floor(random() * (end_date - start_date + 1))::int);

RETURN random_day;
END;
$$ language plpgsql;

CREATE OR REPLACE FUNCTION generate_random_phone_number() RETURNS TEXT AS $$
DECLARE
    random_num TEXT;
BEGIN
    random_num := '';

    FOR i IN 1..9 LOOP
            random_num := random_num || floor(random() * 10)::INT;
        END LOOP;

    RETURN random_num;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION generate_random_number(min_value INT, max_value INT)
    RETURNS INT AS
$BODY$
DECLARE
    range_width INT;
    random_number INT;
BEGIN
    range_width := max_value - min_value + 1;
    random_number := floor(random() * range_width) + min_value;

    RETURN random_number;
END;
$BODY$
LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION random_time(start_time TIME, end_time TIME)
    RETURNS TIME
AS $$
DECLARE
    random_time TIME;
BEGIN
    SELECT to_timestamp(floor(random() * (extract(epoch from (end_time - start_time)) / 3600)) * 3600 + extract(epoch from start_time))
    INTO random_time;
    RETURN random_time;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION test()
    RETURNS VOID
AS $$
DECLARE
    records RECORD;
BEGIN
   FOR records IN (
       SELECT places.id, sessions.id
       FROM places
       CROSS JOIN sessions
    )
    LOOP

    END LOOP ;
END;
$$ LANGUAGE plpgsql;
